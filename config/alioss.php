<?php

return [
    //'ossServer' => env('ALIOSS_SERVER', null),                      // 外网
    //'ossServerInternal' => env('ALIOSS_SERVERINTERNAL', null),      // 内网
    'city' => env('CITY', '北京'),                                  //  城市
    'networkType' => env('NETWORK_TYPE', '经典网络'),                // 经典网络 or VPC
    'AccessKeyId' => env('ALIOSS_KEYID', null),                     // key
    'AccessKeySecret' => env('ALIOSS_KEYSECRET', null),             // secret
    'BucketName' => env('ALIOSS_BUCKETNAME', null)                  // bucket
];
