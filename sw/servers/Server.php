<?php
/**
 * Sw Server
 *
 * @Author     : andy.qiang@foxmail.com
 */
namespace app\sw\servers;

abstract class Server {
    public $swServer;
    public $swEvents;
    
    public $process_name;
    public $ip;
    public $port;
    public $set;
    
    public $workerStartCb;
    
    public function __construct() {
        @swoole_set_process_name($this->process_name);
    }
    
    public function getPidFile() {
        return $this->set['pid_file'];
    }
    
    public function onWorkerStart($server, $workerId) {
        @swoole_set_process_name($this->process_name);
        
        if ($server->taskworker) {
            $this->dump("Task Worker Start #{$workerId}");
        }
        else {
            $this->dump("Worker Start #{$workerId}");
        }
    }
    
    public function onTask($server, $taskId, $srcWorkerId, $data) {
        try {
            call_user_func(...$data);
            $server->finish($data);
        } catch (\Exception $e) {
            $msg = "Task #{$taskId} srcWorker #{$srcWorkerId} Exception:\n";
            $msg .= "Err_data : {" . json_encode($data) . "}\n";
            $msg .= "Err_file : {$e->getFile()}\n";
            $msg .= "Err_line : {$e->getLine()}\n";
            $msg .= "Err_msg  : {$e->getMessage()}\n";
            $msg .= "Err_trace: {$e->getTraceAsString()}";
            $this->dump($msg);
        }
    }
    
    public function onFinish($server, $taskId, $data) {
        $this->dump("Task #{$taskId} Finish,data is " . json_encode($data));
    }
    
    /**
     * Run Func
     *
     * @CreateTime 2018/8/30 11:28:09
     * @Author     : pb@likingfit.com
     */
    public function run() {
        $this->dump("Server {$this->ip}:{$this->port} Start");
        
        $this->swServer = $this->getSwServer();
        $this->swServer->set($this->set);
        $this->bindEvents();
        $this->swServer->start();
    }
    
    abstract public function getSwServer();
    
    public function bindEvents() {
        $this->swServer->on('WorkerStart', [
            $this,
            'onWorkerStart'
        ]);
        $this->swServer->on('request', [
            $this,
            'onRequest'
        ]);
        $this->swServer->on('task', [
            $this,
            'onTask'
        ]);
        $this->swServer->on('finish', [
            $this,
            'onFinish'
        ]);
        
        foreach ($this->swEvents as $event) {
            if (method_exists($this, 'on' . $event)) {
                $this->swServer->on($event, [
                    $this,
                    'on' . $event
                ]);
            }
        }
    }
    
    public function dump($msg) {
        echo sprintf("[%s]%s\n", date('Y-m-d H:i:s'), $msg);
    }
}