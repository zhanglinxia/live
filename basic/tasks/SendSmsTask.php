<?php


namespace app\tasks;


use app\libs\AlidayuClient;
use Swoole\Redis;

class SendSmsTask extends Task
{
    public function __construct()
    {

    }
    /**
     * 发送短信任务
     * @param $data
     */
    public function doExec($params)
    {
        $phone = $params['phone'];
        $code = $params['code'];
        $client = new AlidayuClient($phone, '丽萨直播', 'SMS_198692604');
        $client->setTemplateParam(['code' => $code]);
        $client->sendSms();
//        go(function (){
//            $redis = new Redis();
//            $redis->connect('127.0.0.1',6379);
//            $redis->auth('1');
//            $redis->set('test_yii_co_redis','1');
//        });
        return $client;
    }
}