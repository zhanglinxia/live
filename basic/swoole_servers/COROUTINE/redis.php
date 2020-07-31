<?php
//一般连接redis，需要在回调函数里设置信息，使用协程可以使用过程的方法达到异步调用io的目的
/*
 * 在http_server中使用协程redis
 */
//$http = new Swoole\Http\Server('0.0.0.0','8888',SWOOLE_BASE);
//$http->on('request',function ($request,$response){
//    $redis = new \Swoole\Coroutine\Redis();
//    $redis->connect('127.0.0.1','6379');
//    $redis->auth('1');
//    $redis->set('set','key');
//    $response->end('222');
//});
//$http->start();
/*
 * 使用go语法创建协程
 */
go(function () {
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1', 6380);
    var_dump($redis->auth(1));
    $val = $redis->set('key22','key22');
    var_dump($val);
});