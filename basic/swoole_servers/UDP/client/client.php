<?php
$client = new \Swoole\Client(SWOOLE_SOCK_UDP,SWOOLE_SOCK_SYNC);
$flag = $client->connect('127.0.0.1',9502);
if($flag){
    $client->send("hello,swoole-server");
    $message = $client->recv();
    echo $message;
}