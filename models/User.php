<?php
/**
 * User model.
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\models;

use Lcobucci\JWT\Token;

class User extends Base {
    public static function tableName() {
        return 't_user';
    }
    
    public static function findIdentity(Token $jwt) {
        //return static::findOne($id);
        return [
            'id' => $jwt->getClaim('user_id'),
            'name' => 'info'
        ];
    }
}