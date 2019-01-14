<?php
/**
 * Http Server Conf
 */
$server = include_once(__DIR__ . '/server.php');

return [
    'class'         => \app\sw\servers\Http::class,
    'process_name'  => 'yii-swoole',
    'ip'            => '0.0.0.0',
    'port'          => 18330,
    'set'           => $server,
    'workerStartCb' => function () {
        $appConf = require(__DIR__ . '/web.php');
        require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
        
        new \app\sw\Application($appConf);
    },
];