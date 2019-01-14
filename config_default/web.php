<?php
/**
 * yii2 restful config
 */
defined('YII_DEBUG') or define('YII_DEBUG', true);// true or false
defined('YII_ENV') or define('YII_ENV', 'dev');// dev or test or prod

$db     = include_once(__DIR__ . '/db.php');
$redis  = include_once(__DIR__ . '/redis.php');
$rules  = include_once(__DIR__ . '/../params/rules.php');
$params = include_once(__DIR__ . '/../params/params.php');

$config = [
    'id'         => 'sw-http',
    'name'       => 'sw-http',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'components' => [
        'db'           => $db,
        'redis'        => $redis,
        'errorHandler' => [
            'class'            => \app\components\ErrorHandle::class,
            'as response'      => [
                'class'    => \app\behaviors\ExceptionResponse::class,
            ],
        ],
        'request'      => [
            'class'                => \app\components\Request::class,
            'cookieValidationKey'  => 'andy.qiang@foxmail.com',
            'enableCsrfValidation' => false,
            'parsers'              => [
                'application/json' => \yii\web\JsonParser::class
            ]
        ],
        'response'     => [
            'class'     => \app\components\Response::class,
            'format'    => \yii\web\Response::FORMAT_JSON,
            'as log'    => [
                'class' => \app\behaviors\ResponseLog::class,
            ],
            'as filter' => [
                'class'  => \app\behaviors\ResponseFilter::class,
                'except' => [],
            ]
        ],
        'sw'           => [
            'class' => \app\components\Sw::class
        ],
        'jwt'          => [
            'class'   => \app\components\Jwt::class,
            'key'     => 'hello_world_123456',
            'expTime' => 200000
        ],
        'user'         => [
            'class' => \app\models\User::class
        ],
        'log'          => [
            'flushInterval' => 1,
            'targets'       => [
                [
                    'class'          => \app\components\FileTarget::class,
                    'logDir'         => function ($logFileName) {
                        return __DIR__ . '/../logs/' . $logFileName;
                    },
                    'logFileName'    => 'ex.log',
                    'categories'     => ['ex'],
                    'exportInterval' => 1,
                    'maxFileSize'    => 10240 * 1000,
                    'logVars'        => [],
                    'levels'         => ['error'],
                ],
                [
                    'class'          => \app\components\FileTarget::class,
                    'logDir'         => function ($logFileName) {
                        return __DIR__ . '/../logs/' . date('Y-m-d') . '/' . $logFileName;
                    },
                    'logFileName'    => 'app.log',
                    'categories'     => ['application'],
                    'exportInterval' => 1,
                    'maxFileSize'    => 10240 * 1000,
                    'logVars'        => [],
                    'levels'         => [
                        'info',
                        'warning'
                    ],
                ],
            ],
        ],
        'urlManager'   => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules'               => $rules,
        ],
    ],
    'params'     => $params,
];

return $config;
