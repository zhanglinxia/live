<?php


namespace app\libs;
use AlibabaCloud\Client\AlibabaCloud;
use yii\db\Exception;

class AlidayuClient
{
    //通用参数
    private $product = 'Dysmsapi';
    private $version = '2017-05-25';
    private $host = 'dysmsapi.aliyuncs.com';
    private $regionId = 'cn-hangzhou';
    private $accessKeyId = 'LTAI4G8vcxt8kdi4HHBqkenP';
    private $accessSecret = 'QKP8LEhtlYxE03hAKIIjIjgENyh57B';

    //业务参数：默认值
    private $method = 'POST';
    private $action = 'SendSms';

    //业务参数
    private $phone = null;
    private $sign = null;
    private $template_code = null;
    private $template_params = null;

    private $_rpc = null;
    //格式化结果:code=1表示发送成功 2表示发送失败
    private $_code = null;
    private $_message = null;
    public function __construct($phone,$sign,$template_code)
    {
        //初始化类参数
        $this->setPhone($phone);
        $this->setSign($sign);
        $this->setTemplateCode($template_code);

        //实例话阿里大鱼对象
        AlibabaCloud::accessKeyClient(
            $this->accessKeyId,
            $this->accessSecret)
            ->regionId($this->regionId)
            ->asDefaultClient();
        $this->_rpc = AlibabaCloud::rpc()
            ->product($this->product)
            ->action($this->action)
            ->version($this->version);
    }

    /**
     * 发送短信
     * @return bool
     * @throws \Exception
     */
    public function sendSms()
    {
        try {
            //参数设置
            $request = $this->_rpc
                ->method($this->method)
                ->host($this->host);
            $query = [
                'RegionId' =>$this->regionId,
                'PhoneNumbers' => $this->phone,
                'SignName' => $this->sign,
                'TemplateCode' => $this->template_code
            ];
            if(!empty($this->template_params)){
                $query['TemplateParam'] = $this->template_params;
            }
            $request->options([
                'query' => $query
            ]);

            //发送请求
            $result = $request->request();

            //请求结果分析
            return $this->parseResult($result);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 发送结果code
     * @param $code
     */
    private function setCode($code){
        $this->_code = intval($code);
    }
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * 发送结果信息
     * @param $message
     */
    private function setMessage($message){
        $this->_message = trim($message);
    }
    public function getMessage(){
        return $this->_message;
    }

    /**
     * 电话号码
     * @param $phone
     * @throws Exception
     */
    public function setPhone($phone)
    {
        if(empty($phone)){
            throw new \Exception("电话号码不能为空");
        }
        $this->phone = is_array($phone) ? implode(',',array_unique($phone)) : $phone;
    }
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * 签名
     * @param $sign
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
    }
    public function getSign(){
        return $this->sign;
    }

    /**
     * 短信模版
     * @param $code
     */
    public function setTemplateCode($code)
    {
        $this->template_code = $code;
    }
    public function getTemplateCode()
    {
        return $this->template_code;
    }

    /**
     * 访问方法
     */
    public function setMethod($method)
    {
        if(empty($method)){
            throw new Exception("访问方法不能为空");
        }
        $this->method = $method;
    }
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * 访问名称
     */
    public function setAction($action)
    {
        if(empty($action)){
            throw new Exception("控制器名不能为空");
        }
        $this->action = $action;
    }

    public function getAction()
    {
        return $this->action;
    }

    /**
     * 业务参数
     */
    public function setTemplateParam(array $params)
    {
        if(empty($params)){
            throw new Exception("设置业务参数时，参数名称不能为空");
        }
        $this->template_params = json_encode($params);
    }
    public function getTemplateParam()
    {
        $params = !empty($this->template_params) ? json_decode($this->template_params, true) : null;
        return $params;
    }

    /**
     * 解析结果
     */
    public function parseResult($result)
    {
        $result = $result->toArray();
        if(strtoupper($result['Code']) == 'OK'){
            $this->setCode(1);
        }else{
            $this->setCode(2);
        }
        $this->setMessage($result['Message']);
        return $this->getCode();
    }
    public function __toString()
    {
        $obj_str = [
            'code' => $this->getCode(),
            'message' => $this->getMessage()
        ];
        return json_encode($obj_str);
    }
}