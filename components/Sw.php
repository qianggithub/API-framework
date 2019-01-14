<?php
/**
 * Sw Server.
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\components;

use yii\base\Component;

class Sw extends Component {
    public $_swServer;
    
    public function setSwServer($server) {
        $this->_swServer = $server;
    }
    
    /**
     * async func
     *
     * @param mixed ...$paramArr, Same as call_func_user() Params
     *
     * ```
     *      Yii::$app->sw->task(...$paramArr);
     * ```
     *
     * @CreateTime 2018/7/27 13:49:20
     * @Author     : pb@likingfit.com
     */
    public function task(...$paramArr) {
        $this->_swServer->task($paramArr);
    }
}