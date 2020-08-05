<?php


namespace app\tasks;


use yii\db\Exception;

class Task
{
    /**
     * @param $params
     * @throws \ReflectionException
     */
    public function exec($params){
        $class_name = $params['class_name'];
        $init_params = !empty($params['init_params']) ? $params['init_params'] : [];
        $business_params = $params['business_params'];
        if(empty($class_name)){
            throw new Exception("任务名称不能为空");
        }
        if(empty($business_params)){
            throw new Exception("业务参数不能为空");
        }
        if(!is_array($init_params)){
            throw new Exception("实例参数必须为数组");
        }
        $class_name = __NAMESPACE__."\\".$class_name;
        $reflect  = new \ReflectionClass($class_name);
        $obj = $reflect->newInstanceArgs($init_params);
        $obj->doExec($business_params);
    }
}