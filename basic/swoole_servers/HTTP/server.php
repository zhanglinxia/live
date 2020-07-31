<?php
$http = new \Swoole\Http\Server('0.0.0.0',9503);
$http->set([
    'document_root' => '/Users/zhanglinxia/works/swoole_demo/HTTP/data',
    'enable_static_handler' => true
]);
$http->on('request',function ($request,$response){
    print_r($request->header);
    print_r($request->get);
    $response->header('Content-type','text/html;charset=UTF-8');
    $response->end("<h1>您好，HTTPserver</h1>");
});
$http->start();