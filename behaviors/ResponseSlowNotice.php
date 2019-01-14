<?php
/**
 * Response Slow Api Notice.
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\behaviors;

use Yii;

class ResponseSlowNotice extends \app\filters\ResponseFilter {
    /**
     * Api max response Seconds
     *
     * @var int
     */
    public $maxTime = 5;
    
    public function beforeSend($response) {
        $exclTime = time() - Yii::$app->request->getStartTime();
        
        if ($exclTime > $this->maxTime) {
            $prefix = date('Ymd') . ':TimeId:';
            $key    = Yii::$app->request->getUniqueId($prefix);
            
            Yii::$app->sw->task([
                'app\services\MailService',
                'sendException'
            ], '[Api Excl Time: ' . $exclTime . 's ]', $key, [
                'request_info' => Yii::$app->request->getInfo()
            ]);
        }
    }
}