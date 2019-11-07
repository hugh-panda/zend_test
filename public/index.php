<?php

use Application\Service\MyPriceListService;
use Application\Service\ServiceManager;

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'on');

// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

$sm = new ServiceManager();
$config = [
    'services' => [
        MyPriceListService::class => function ($variable) {
            return new MyPriceListService($variable);
        },
        "some" => function ($variable) {
            return new MyPriceListService($variable);
        },
    ],
    'aliases' => [
        'myService' => MyPriceListService::class,
        'myService2' => MyPriceListService::class,

    ],
    'shared' => [
        MyPriceListService::class => true,
    ]
];
$sm->configure($config);

$serviceOne = $sm->get('myService');
$serviceOne = $sm->get('myService2');
$serviceTwo = $sm->get(MyPriceListService::class);
$serviceTwo = $sm->get('some');