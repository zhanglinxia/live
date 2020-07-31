<?php
//创建socket对象
$ws = new Swoole\WebSocket\Server('127.0.0.1',8888);
$ws->set([
    'document_root' => '/Users/zhanglinxia/works/swoole_demo/HTTP/data',
    'enable_static_handler' => true,
    'task_worker_num' => 2
]);
//监听连接打开事件
$ws->on('Open',function ($server,$request){
    echo "server:建立三次握手成功 与client{$request->fd}创建连接";
});
//监听ws的接受消息事件
$ws->on('Message',function (Swoole\WebSocket\Server $ws, Swoole\WebSocket\Frame $frame){
    $message = $frame->data;
    $fd = $frame->fd;
    $ws->task("hello task");
    echo "客户端-{$fd}  message-{$message}\n";
});
//监听ws的关闭连接事件
$ws->on('Close',function ($fd){
   echo "客户端{$fd}关闭连接\n";
});
$ws->on('task',function ($ws,$task_id,$from_id,$data){
    echo "客户端发送数据 ：".$data.PHP_EOL;
    echo time().PHP_EOL;
    sleep(10);
    echo time().PHP_EOL;
    return "I'm finished";
});
$ws->on('finish',function ($data){
    echo "task-finished".PHP_EOL;
    echo time();
});
//开启服务
$ws->start();
//$server = new Swoole\WebSocket\Server("0.0.0.0", 8888);
//
//$server->on('open', function (Swoole\WebSocket\Server $server, $request) {
//    echo "server: handshake success with fd{$request->fd}\n";
//});
//
//$server->on('message', function (Swoole\WebSocket\Server $server, $frame) {
//    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
//    $server->push($frame->fd, "this is server");
//});
//
//$server->on('close', function ($ser, $fd) {
//    echo "client {$fd} closed\n";
//});
//
//$server->start();