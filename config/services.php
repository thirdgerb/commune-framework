<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    /*
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => 'none',
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    */


    //短信功能
    'sms'   =>  [
        'sender'    =>  'shumi365',
        'from'      =>  'zhongbao_',
        'user_id'   =>  '400076',
        'password'  =>  '025355',
        'url'       =>  "http://api.shumi365.com:8090/sms/send.do",
    ],

    'ali_oss' => [
        'sdk' => base_path('sdk/oss/demo/OssObject.class.php'),
        'host' => 'http://treevc-demo-public.oss-cn-beijing.aliyuncs.com/',
        'pic_host' => 'http://treevc-demo-public.oss-cn-beijing.aliyuncs.com/',
        'access_id' => 'YhP2NK2AqP4xXZ3e',
        'access_key'=> 'bDMKjAYvIdYx4t0gy752mlts8sfdsF',
        'endpoint' => 'oss-cn-beijing.aliyuncs.com',
        'bucket' => 'treevc-demo-public',
    ],

];
