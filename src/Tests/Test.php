<?php
namespace FacebookClient\Tests;

use FacebookClient\Client\GraphApiClient;

class Test
{
    public function testGet()
    {
        $batchQ['a'] = "me";
        $batchQ['b'] = "me";
        $batchQ['c'] = "me";
        $batchQ['d'] = "me";
        $batchQ['e'] = "me";
        $batchQ['f'] = "me";
        $batchQ['g'] = "me";
        $batchQ['11'] = "me";
        $batchQ['12'] = "me";
        $batchQ['13'] = "me";
        $batchQ['14'] = "me";
        $batchQ['15'] = "me";
        $accessToken = "EAAHE0mTSloIBADNDi2mUPA8xKiIqoS1nxZBhswvxhK3ILPmhdWkGGkKt76gurANlyd4CLWIlj7xwVZCLVx8LqxdZBwVN5THPpaLb5vSFiOfZAdP9d1ZBdkNMJqqL0ZCm5sUzwHRAvZBzmZBab6RGoyBs7WBy2rxmsI2PafxEeCuG6QZDZD";
        $result = (new GraphApiClient("2709330685824206", '4d249b347fae3134e4137f7a956f1124', 'v6.0', $accessToken))->batchPost($batchQ);
        var_dump($result);
    }
}
