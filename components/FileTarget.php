<?php
/**
 * FileTarget.
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\components;

class FileTarget extends \yii\log\FileTarget {
    public $logDir;
    
    public $logFileName = 'app.log';
    
    public function export() {
        $this->logFile = call_user_func($this->logDir, $this->logFileName);
        parent::export();
    }
}