<?php

namespace app\controllers;

use app\libs\AlidayuClient;
use app\tasks\Task;
use Swoole\Coroutine\Redis;
use Swoole\IDEHelper\StubGenerators\Swoole;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use function AlibabaCloud\Client\json;
use function foo\func;
use function GuzzleHttp\Psr7\_parse_request_uri;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSms()
    {
        $phone = 1521546877;
        $client = new AlidayuClient($phone, '丽萨直播', 'SMS_198692604');
        $client->setTemplateParam(['code' => '3333']);
        $client->sendSms();
        go(function (){
            $redis = new Redis();
            $redis->connect('127.0.0.1',6379);
            $redis->auth('1');
            $redis->set('test_yii_co_redis','1');
        });
        return true;
    }

    public function actionTask()
    {
        $params['class_name'] = 'SendSmsTask';
        $params['init_params'] = null;
        $params['business_params'] = [
            'phone' => 15215046877,
            'code' => '8888'
        ];
        error_log("http_server1");
        $http = $_POST['http_server'];
        error_log("http_server2");
        error_log("http_server2");
        $http->task($params);
    }
}
