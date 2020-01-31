<?php


namespace larkit\exchange\dirivers\juhe;

/**
 *  聚合数据 汇率查询
 * Class Exchange
 * @package larkit\exchange\dirivers\juhe
 */
class Exchange extends \larkit\exchange\Exchange
{
    public $type = 1;

    public $key;

    const QUERY_URL = 'http://op.juhe.cn/onebox/exchange/currency';


    public function eur()
    {
        $response = $this->get(self::QUERY_URL, [
            'key' => $this->key,
            'from' => 'EUR',
            'to' => 'CNY'
        ]);
        return $response;
    }


    /**
     * 人民币对应欧元
     */
    public function cnyToEur()
    {
        $response = $this->get(self::QUERY_URL, [
            'key' => $this->key,
            'from' => 'CNY',
            'to' => 'EUR'
        ]);
        return $response;
    }


}