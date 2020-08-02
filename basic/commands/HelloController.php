<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use AlibabaCloud\Client\AlibabaCloud;
use app\libs\AlidayuClient;
use yii\console\Controller;
use yii\console\ExitCode;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionSms()
    {
//        AlibabaCloud::accessKeyClient('LTAI4G8vcxt8kdi4HHBqkenP', 'QKP8LEhtlYxE03hAKIIjIjgENyh57B')
//            ->regionId('cn-hangzhou')
//            ->asDefaultClient();
//        try {
//            $result = AlibabaCloud::rpc()
//                ->product('Dysmsapi')
//                // ->scheme('https') // https | http
//                ->version('2017-05-25')
//                ->action('SendSms')
//                ->method('POST')
//                ->host('dysmsapi.aliyuncs.com')
//                ->options([
//                    'query' => [
//                        'RegionId' => "cn-hangzhou",
//                        'PhoneNumbers' => "15215046877",
//                        'SignName' => "丽萨直播",
//                        'TemplateCode' => "SMS_198692604",
//                        'TemplateParam' => "{\"code\":8989}",
//                    ],
//                ])
//                ->request();
//            print_r($result->toArray());
//        } catch (ClientException $e) {
//            echo $e->getErrorMessage() . PHP_EOL;
//        } catch (ServerException $e) {
//            echo $e->getErrorMessage() . PHP_EOL;
//        }

        $aliClient = new AlidayuClient(15215046877,'丽萨直播','SMS_198692604');
        $aliClient->setTemplateParam(['code' => '0808']);
        $result = $aliClient->sendSms();
    }
}
