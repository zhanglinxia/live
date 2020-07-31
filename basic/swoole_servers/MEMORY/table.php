<?php
$table = new Swoole\Table(4);
$table->column('id',\Swoole\Table::TYPE_INT,4);
$table->column('name',\Swoole\Table::TYPE_STRING,'100');
$table->column('age',\Swoole\Table::TYPE_INT,2);
$table->create();
$table->set('profile',['id' => 1,'name' => 'lisa','age' =>20]);
print_r($table->get('profile'));
print_r($table['profile']);
$table->incr('profile','age',2);
print_r($table['profile']);
var_dump($table->exist('profile'));
$table->del('profile');
print_r($table['profile']);
var_dump($table->exist('profile'));
