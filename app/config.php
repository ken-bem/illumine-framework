<?php if(!defined('ABSPATH')){ die(); }
return [

    'namespace' => 'WppSkeleton',
    'mode' => 'development',
    'database' => true,
    'locale' => 'en',

    'encryption.enabled' => false, //or false to disable
    'encryption.cipher' => 'AES-256-CBC', //or false to disable
    'encryption.key' => 'nInrMfTMQngxqRvoFpjstYjZX0qH1Nlr',


    'paths.views' => realpath(__DIR__.'/../resources/views'),
    'paths.assets' => realpath(__DIR__.'/../resources/assets'),
    'paths.public' => plugins_url('/resources/assets', realpath(__FILE__.'../')),

    'cache.routes' => true,
    'cache.prefix' => 'WppSkeleton',
    'cache.default' => 'files',
    'cache.stores.files' => [
        'driver' => 'file',
        'path' => str_replace('/app','',__DIR__.'/cache/objects')
    ],
    'session.driver' => 'file',
    'session.connection' => null,
    'session.table' => null,
    'session.store' => null,
    'session.lottery' => [2, 100],
    'session.lifetime' => 120,
    'session.expire_on_close' => false,
    'session.encrypt' => false,
    'session.files' => str_replace('/app','',__DIR__.'/cache/sessions'),
    'session.cookie' => 'WppSkeleton',
    'session.path' => '/',
    'session.domain' => '.wordpresspluginpro.com',
    'session.secure' => false,
    'session.http_only' => false, //HTTP Access Only
    'providers' => [
        //Illuminate\Encryption\Encrypter::class, //"illuminate/encryption": "^5.0"
    ]
];
