<?php
namespace FacebookClient\Client;

use Exception;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Facebook;

class GraphApiClient
{
    /**
     * facebook SDK 初始化对象
     *
     * @var mixed
     */
    protected $facebookObj;

    /**
     * 是否使用主页token去调用api
     *
     * @var boolean
     */
    protected $isPageToken = false;

    protected $accessToken;

    const VERSION = 'v6.0';
    const MAX_GET_COUNT = 50;
    const MAX_POST_COUNT = 10;

    public function __construct($accessToken)
    {
        $this->facebookObj = new Facebook([
            'app_id' => getenv("FACEBOOK_APP_ID"),
            'app_secret' => getenv("FACEBOOK_APP_SECRET"),
            'default_graph_version' => getenv("FACEBOOK_VERSION", static::VERSION),
            'http_client_handler' => null,   //定义请求方式
        ]);
        $this->accessToken = $accessToken;
        $this->facebookObj->setDefaultAccessToken($this->accessToken);
    }

    public function get($subject = 'me', $params = null)
    {
        return $this->request($subject, $params,"GET");
    }
    public function post($subject = 'me', $params = null)
    {
        return $this->request($subject, $params,"POST");
    }
    public function batchGet($batchQuerys = [])
    {
        return $this->batchRequest($batchQuerys, 'GET');
    }
    public function batchPost($batchQuerys = [])
    {
        return $this->batchRequest($batchQuerys, 'POST');
    }

    public function request($subject, $params, $method)
    {
        $response = [];
        try{
            if($method == "POST"){
                $response = $this->facebookObj->post($subject, $params)->getDecodedBody();
            }else{
                if(!empty($params)){
                    $subject .= '?'.http_build_query($params);
                }
                $response = $this->facebookObj->get($subject)->getDecodedBody();
            }
            $response['clientCode'] = 1;
        }catch(Exception $e){
            $response = [
                'clientCode' => 0,
                'message' => $e->getMessage()
            ];
        }catch(FacebookResponseException $re){
            $response = $re->getResponse()->getDecodedBody()['error'];
            $response['clientCode'] = 0;
        }
        return $response;
    }

    /**
     * 批量请求，支持重试
     *
     * @param array $batchQuerys
     * @param string $method
     * @return array
     */
    public function batchRequest($batchQuerys, $method)
    {
        $result = [];
        if($batchQuerys){
            $index = 0;
            $batch = [];
            $i = 0;
            if($method == 'GET'){
                foreach($batchQuerys as $key => $query){
                    $batch[$index][$key] = $this->facebookObj->request('GET',$query);
                    if ((($i + 1) % static::MAX_GET_COUNT) == 0) {
                        $index ++;
                    }
                    $i++;
                }
            }else{
                foreach($batchQuerys as $key => $query){
                    $batch[$index][$key] = $this->facebookObj->request('GET',$query);
                    if ((($i + 1) % static::MAX_GET_COUNT) == 0) {
                        $index ++;
                    }
                    $i++;
                }
            }
        }
        return $result;
    }

    private function fbAdGraphQL()
    {
        $fields = /* GraphQL */'
            account_id,
            campaign { id, objective, },
            adset { id, promoted_object, targeting, },
            creative {
                id, name,
                asset_feed_spec,
                applink_treatment,
                object_story_id,
                object_type,
                object_story_spec,
                product_set_id,
                url_tags,
            },
            id, name, tracking_specs, status,
        ';

        $fields = preg_replace( '/\s+/', '', $fields );
        $fields = preg_replace( '/,(?=\}|$)/', '', $fields );

        return $fields;
    }

}