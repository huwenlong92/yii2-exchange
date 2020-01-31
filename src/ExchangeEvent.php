<?php


namespace larkit\exchange;


use yii\base\Event;

class ExchangeEvent extends Event
{
    // 请求URI
    public $uri;

    // HTTP 方法
    public $method;

    // 请求参数
    public $params;

    // 请求头
    public $headers;

    // 接口提示方
    public $type;

    // 返回结果
    public $response;

}