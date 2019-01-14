<?php
/**
 * Created by PhpStorm.
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use app\exceptions\RequestException;
use app\behaviors\DbKeepAlive;
use app\behaviors\TokenValidate;
use app\behaviors\ParamsValidate;
use app\behaviors\RequestXssFilter;
use app\behaviors\SignValidate;

class BaseController extends Controller {
    public function behaviors() {
        return [
            'DbKeepAlive'          => [
                'class' => DbKeepAlive::class,
            ],
            'requestXssFilter'     => [
                'class' => RequestXssFilter::class,
            ],
            'requestHeadersFilter' => [
                'class'   => ParamsValidate::class,
                // 验证数据
                'data'    => Yii::$app->request->getSwRequest()->header,
                // 验证规则
                'rules'   => Yii::$app->params['requestHeadersRules'],
                // 错误回调函数
                'errFunc' => function ($data) {
                    throw new ForbiddenHttpException(reset($data), RequestException::INVALID_PARAM);
                },
            ],
            'requestParamsFilter'  => [
                'class'   => ParamsValidate::class,
                'data'    => array_merge(Yii::$app->request->getQueryParams(), Yii::$app->request->getBodyParams()),
                'rules'   => Yii::$app->params['requestParamsRules'],
                'errFunc' => function ($data) {
                    throw new RequestException(RequestException::INVALID_PARAM, reset($data));
                },
            ],
            'signValidate'         => [
                'class'     => SignValidate::class,
                'secretKey' => [
                    '1.1.0' => 'andy.qiang!@#$%%^&*(^^)',
                    '1.1.1' => 'andy.qiang!@#$%%^&*(^^)'
                ]
            ],
            'tokenValidate'        => [
                'class' => TokenValidate::class,
            ]
        ];
    }
}