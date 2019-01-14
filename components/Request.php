<?php
/**
 * Request.
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\components;

use Yii;

class Request extends \yii\web\Request {
    private $_swRequest;
    
    private $_startTime;
    
    public function setSwRequest($request) {
        $this->_swRequest = $request;
    }
    
    public function getSwRequest() {
        return $this->_swRequest;
    }
    
    public function setStartTime($time) {
        $this->_startTime = $time;
    }
    
    public function getStartTime() {
        return $this->_startTime;
    }
    
    /**
     * get request info
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @CreateTime 2018/9/11 15:13:46
     * @Author     : pb@likingfit.com
     */
    public function getInfo() {
        return [
            'path_info' => $this->getPathInfo(),
            'method'    => $this->getMethod(),
            'header'    => $this->getHeaders()
                                ->toArray(),
            'get'       => $this->get(),
            'post'      => $this->post()
        ];
    }
    
    /**
     * get request unique id
     *
     * @param string $prefix
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @CreateTime 2018/9/11 15:13:31
     * @Author     : pb@likingfit.com
     */
    public function getUniqueId($prefix = ''){
        $id = md5(json_encode([
            $this->getPathInfo(),
            $this->getMethod(),
            $this->get(),
            $this->post()
        ]));
        
        return Yii::$app->id .":{$prefix}:".$id;
    }
}