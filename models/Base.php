<?php
/**
 * Created by PhpStorm.
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\models;

use yii\db\ActiveRecord;

class Base extends ActiveRecord {
    /**
     * 有效
     */
    const AVAILABLE = 1;
    /**
     * 无效
     */
    const UNAVAILABLE = 0;
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->update_time = time();
            if ($insert) {
                $this->create_time = time();
            }
            
            return true;
        }
        
        return false;
    }
}
