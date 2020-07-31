<?php
go(function (){
    co::sleep(1);
    echo "协程1:获取redis".PHP_EOL;
});
echo "swoole 进程".PHP_EOL;
\Swoole\Coroutine::create(function (){
    echo "协程2：发送邮件".PHP_EOL;
});