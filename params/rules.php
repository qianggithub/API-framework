<?php
/**
 * RestFul url.
 *
 * @Author     : andy.qiang@foxmail.com
 */
return [
    [
        'class'         => 'yii\rest\UrlRule',
        'pluralize'     => false,
        'controller'    => [
            'login',
            'user',
            'v1/user'
        ],
        'extraPatterns' => [
            'POST sms' => 'sms',
        ]
    ]
];