<?php
/**
 * Db KeepAlive.
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\behaviors;

use Yii;
use app\filters\RequestFilter;

class DbKeepAlive extends RequestFilter
{
    public function beforeAction($request) {
        if(Yii::$app->db->isGoneWay()){
            Yii::$app->db->close();
        }
    }
}