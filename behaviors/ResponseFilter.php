<?php
/**
 * Response filter
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\behaviors;

class ResponseFilter extends \app\filters\ResponseFilter {
    public $successCode = 0;
    public $successMsg  = 'success';
    
    public function beforeSend($response) {
        $data = $response->data;
        
        if (isset($data['code']) && isset($data['msg'])) {
            return;
        }
        
        $response->data = [
            'code' => $this->successCode,
            'msg' => $this->successMsg,
            'data' => is_array($data) ? $data : (object)[]
        ];
    }
}