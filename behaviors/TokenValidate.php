<?php
/**
 * Token validate
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\behaviors;

use Yii;
use app\filters\RequestFilter;
use app\exceptions\RequestException;

class TokenValidate extends RequestFilter {
    public function beforeAction($request) {
        $token = $request->getHeaders()->get('Token');
        $jwt = Yii::$app->jwt->loadToken($token);
        if(is_null($jwt)){
            $this->handleFailure();
        }
        
        Yii::$app->user->findIdentity($jwt);
    }
    
    public function handleFailure(){
        throw new RequestException(RequestException::UNAUTHORIZED_TOKEN);
    }
}