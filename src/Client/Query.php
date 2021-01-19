<?php
namespace FacebookClient\Client;

class Query implements IQuery
{
    protected $method= 'GET';
    protected $subject= 'me';
    protected $isDone= false;
    protected $response= null;
    protected $params= null;
    protected $name= null;
    protected $ignoreError= false;  //区别controller、model、console层调用

    public function get($subject, $params)
    {
        $response = $fb->get($url)->getDecodedBody();
    }

    function notDone(): bool;

    function toArray(): array;

    function loadResponse(array $response);

    function getResponse():? array;
}