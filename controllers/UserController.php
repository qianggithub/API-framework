<?php
/**
 * RestFul example.
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\controllers;

use app\helpers\Helper;

/***
 * RestFul 默认解析路由
 * 'PUT,PATCH {id}' => 'update',
 * 'DELETE {id}'    => 'delete',
 * 'GET,HEAD {id}'  => 'view',
 * 'POST'           => 'create',
 * 'GET,HEAD'       => 'index',
 * '{id}'           => 'options',
 * ''               => 'options',
 */
class UserController extends BaseController {
    public function behaviors() {
        return [];
    }
    
    /**
     * 新增
     * POST /users
     *
     * @return array
     */
    public function actionCreate() {
        return [
            'token' => (string)\Yii::$app->jwt->issue(['user_id' => 1])
        ];
    }
    
    /**
     * 列表
     * GET /users
     *
     * @return array
     * @throws
     */
    public function actionIndex() {
        return [
            'info' => [
                'curl'   => Helper::Curl('http://127.0.0.1:18330/user?aaa=1', 'get', ['aaa' => 1]),
                'header' => \Yii::$app->request->getHeaders()
                                               ->toArray(),
                'get'    => \Yii::$app->request->get()
            ]
        ];
    }
    
    /**
     * 详情
     * GET /users/{id}
     */
    public function actionView() {
        return [
            'view' => [
                'header' => \Yii::$app->request->getHeaders()
                                               ->toArray(),
                'get'    => \Yii::$app->request->get()
            ]
        ];
    }
    
    /**
     * 更新
     * PUT /users/{id}
     *
     * @return array
     */
    public function actionUpdate() {
        //1 / 0;
        
        return [
            'put' => [
                'header' => \Yii::$app->request->getHeaders()
                                               ->toArray(),
                'get'    => \Yii::$app->request->get(),
                'post'   => \Yii::$app->request->post()
            ]
        ];
    }
}