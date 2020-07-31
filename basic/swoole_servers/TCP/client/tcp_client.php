<?php
$client = new Swoole\Client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_SYNC);
$flag = $client->connect('127.0.0.1','9501');
if(!$flag){
    die("链接失败");
}
fwrite(STDOUT,"请输入发送信息");
$data = fgets(STDIN);
$client->send($data);
echo $client->recv();
$client->close();
