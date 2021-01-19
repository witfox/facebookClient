<?php
namespace FacebookClient\Client;

class Test
{
    public function testGet()
    {
        $accessToken = "EAAHE0mTSloIBADNDi2mUPA8xKiIqoS1nxZBhswvxhK3ILPmhdWkGGkKt76gurANlyd4CLWIlj7xwVZCLVx8LqxdZBwVN5THPpaLb5vSFiOfZAdP9d1ZBdkNMJqqL0ZCm5sUzwHRAvZBzmZBab6RGoyBs7WBy2rxmsI2PafxEeCuG6QZDZD";
        $result = (new GraphApiClient($accessToken))->get();
        var_dump($result);
    }
}
