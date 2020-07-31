<?php
$serv = new \Swoole\Server('127.0.0.1', 9502, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);
$serv->on('packet', function ($serv, $data, $clientInfo) {
    $serv->sendto($clientInfo['address'], $clientInfo['port'], 'hello');
    var_dump($clientInfo);
    var_dump($data);
});
$serv->start();