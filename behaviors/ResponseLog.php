<?php
/**
 * Response log.
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\behaviors;

use Yii;

class ResponseLog extends \app\filters\ResponseFilter {
    public function beforeSend($response) {
        $log              = [
            'request'    => Yii::$app->request->getInfo(),
            'response'   => $response->data,
            'start_time' => Yii::$app->request->getStartTime(),
            'end_time'   => time(),
        ];
        $log['excl_time'] = $log['end_time'] - $log['start_time'];
        
        Yii::info(json_encode($log));
    }
}