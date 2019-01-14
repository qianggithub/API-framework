<?php
/**
 * Base filter behavior.
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\filters;

use Yii;
use yii\base\Behavior;
use yii\helpers\StringHelper;

class BaseFilter extends Behavior {
    /**
     * only url
     *
     * ```
     * [
     *      'user/create',
     *      ...
     * ]
     * ```
     *
     * @var
     */
    public $only = [];
    
    /**
     * except url
     *
     * ```
     * [
     *      'user/create',
     *      'user/*'
     *      ...
     * ]
     * ```
     *
     * @var array
     */
    public $except = [];
    
    public function isActive() {
        $action = Yii::$app->controller->action;
        if(is_null($action)){
            return true;
        }
        $id = $action->getUniqueId();
        
        if (empty($this->only)) {
            $onlyMatch = true;
        } else {
            $onlyMatch = false;
            foreach ($this->only as $pattern) {
                if (StringHelper::matchWildcard($pattern, $id)) {
                    $onlyMatch = true;
                    break;
                }
            }
        }
        
        $exceptMatch = false;
        foreach ($this->except as $pattern) {
            if (StringHelper::matchWildcard($pattern, $id)) {
                $exceptMatch = true;
                break;
            }
        }
        
        return !$exceptMatch && $onlyMatch;
    }
}