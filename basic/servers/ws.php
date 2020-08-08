<?php
const WEB_DIR_PATH = '/Users/zhanglinxia/works/live/basic';
class Ws{
    public $ws = null;
    public $chart_ws = null;
    public static $host = '0.0.0.0';
    public static $port =  '8888';
    public static $chart_port =  '6988';
    public function __construct()
    {
        $this->ws = new Swoole\WebSocket\Server(self::$host,self::$port);
        $this->chart_ws = $this->ws->listen(self::$host,self::$chart_port,SWOOLE_SOCK_TCP);
        $this->ws->set([
            'worker_num' => 2,
            'task_worker_num' => 4,
            'enable_static_handler' => true,
            'document_root' => '/Users/zhanglinxia/works/live/basic/web'
        ]);
        $this->ws->on('open',[$this,'onOpen']);
        $this->ws->on('message',[$this,'onMessage']);
        $this->ws->on('workerStart',[$this,'onWorkerStart']);
        $this->ws->on('request',[$this,'onRequest']);
        $this->ws->on('task',[$this,'onTask']);
        $this->ws->on('finish',[$this,'onFinish']);
        $this->ws->start();
    }

    /**
     * Websocket客户端连接，回调函数
     * @param \Swoole\WebSocket\Server $server
     * @param \Swoole\Http\Request $request
     */
    public function onOpen(\Swoole\WebSocket\Server $server, \Swoole\Http\Request $request)
    {
        $server->push($request->fd,"当前客户端id：".$request->fd);
    }

    /**
     * Websocket客户端与服务器通信，回调函数
     * @param \Swoole\WebSocket\Server $server
     * @param \Swoole\WebSocket\Frame $frame
     */
    public function onMessage(Swoole\WebSocket\Server $server, \Swoole\WebSocket\Frame $frame)
    {
    }
    /**
     * Websocket客户端与服务器通信，回调函数
     * @param \Swoole\WebSocket\Server $server
     * @param \Swoole\WebSocket\Frame $frame
     */
    public function onChartMessage(Swoole\WebSocket\Server $server, \Swoole\WebSocket\Frame $frame)
    {
    }
    /**
     * 启动进程，回调事件
     * @param \Swoole\Http\Server $server
     * @param $worker_id
     */
    public function onWorkerStart(\Swoole\Server $server, $worker_id)
    {
        require WEB_DIR_PATH . '/vendor/autoload.php';
        require WEB_DIR_PATH . '/vendor/yiisoft/yii2/Yii.php';
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        defined('YII_ENV') or define('YII_ENV', 'dev');

    }

    /***
     * Http请求，回调事件：加载框架入口文件，并创建yii的应用容器
     * @param \Swoole\Http\Request $request
     * @param \Swoole\Http\Response $response
     */
    public function onRequest(\Swoole\Http\Request $request, Swoole\Http\Response $response)
    {
        $config = require WEB_DIR_PATH . '/config/web.php';
        if(isset($request->server)){
            foreach ($request->server as $k => $value){
                $_SERVER[strtoupper($k)] = $value;
            }
        }
        if(isset($request->header)){
            foreach ($request->header as $k => $value){
                $_SERVER[strtoupper($k)] = $value;
            }
        }
        $_GET = [];
        if(isset($request->get)){
            foreach ($request->get as $k => $value){
                $_GET[$k] = $value;
            }
        }
        $_POST = [];
        if(isset($request->post)){
            foreach ($request->post as $k => $value){
                $_POST[$k] = $value;
            }
        }
        $_COOKIE = [];
        if(isset($request->cookie)){
            foreach ($request->cookie as $k => $value){
                $_COOKIE[$k] = $value;
            }
        }
        $_POST['http_server'] = $this->ws;
        try {
            $content = (new yii\web\Application($config))->swooleRun();
        } catch (\Exception $e) {
            $content = $e->getMessage();
        }
        $response->end($content);
    }

    /**
     * 异步任务，投递任务
     * @param \Swoole\Http\Server $server
     * @param $task_id
     * @param $worker_id
     * @param $data
     */
    public function onTask(\Swoole\Server $server, $task_id, $worker_id, $data)
    {
        $task = new \app\tasks\Task();
        $task->exec($data);
    }

    /**
     * woker进程投递的任务完成时，task进程通过该方法告知woker进程
     * 说明：若task进程中没有调用finish方法或return结果，不会触发该方法
     * @param \Swoole\Server $server
     * @param $task_id
     * @param $data
     */
    public function onFinish(\Swoole\Server $server,$task_id, $data)
    {

    }
}
new Ws();