<?php
//进程管理：process.php为主进程
//通过swoole\process folk子进程 子进程通过管道通信
$urls = ['url1','url2','url3','url4','url5','url6'];
$works = [];
$redis = new \Swoole\Redis();
$redis->connect('127.0.0.1',6379);
function callback_function() {
    swoole_timer_after(1000, function () {
        echo "hello world";
    });
    global $redis;//同一个连接
    $redis->auth(1);
    $redis->set('swoole','test');
};
$p = new Swoole\Process('callback_function');

$p->start();