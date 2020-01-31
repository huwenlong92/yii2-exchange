<?php


namespace larkit\exchange;


use GuzzleHttp\Client;
use yii\base\Component;
use yii\helpers\Json;

abstract class Exchange extends Component
{
    public $type;

    protected $client;

    const EVENT_BEFORE_REQUEST = 'beforeRequest';

    const EVENT_AFTER_REQUEST = 'afterRequest';


    public function init()
    {
        parent::init();
        $this->client = new Client();
    }

    protected function get($uri, $params, $headers = [])
    {
        return $this->request("GET", $uri, $params, $headers);
    }

    protected function post($uri, $params, $headers = [])
    {
        return $this->request("POST", $uri, $params, $headers);
    }

    private function request($method, $uri, $params, $headers = [])
    {
        $event = new ExchangeEvent([
            'uri' => $uri,
            'method' => $method,
            'params' => $params,
            'headers' => $headers,
            'type' => $this->type
        ]);
        $this->trigger(self::EVENT_BEFORE_REQUEST, $event);
        if ($event->handled) {
            return null;
        }
        try {
            if ($method == 'GET') {
                $response = $this->client->get($uri, [
                    'query' => $params
                ]);
            } else {
                $response = $this->client->post($uri, [
                    'form_data' => $params
                ]);
            }
            $response = Json::decode($response->getBody()->getContents());
            $this->trigger(self::EVENT_AFTER_REQUEST, $event);
        } catch (\Exception $e) {
            $response = [];
            $response['code'] = $e->getCode() ?: 4000;
            $response['msg'] = $e->getMessage();
        }
        return $response;
    }
}