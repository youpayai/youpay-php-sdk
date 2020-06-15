<?php
namespace YouPaySDK;

/**
 * YouPay Client
 *
 * @package YouPaySDK
 */
class Client
{
    private $api_key;

    public static function create($api_key = '')
    {
        return new self($api_key = '');
    }

    public function __construct($api_key = '')
    {
        $this->api_key = $api_key;
    }

    public static function auth()
    {
        return (object)[
            'store_id'  => 'xxx-xxx-xxx',
            'token'     => 'xxx'
        ];
    }

    public function listOrders()
    {
        $response = $this->client()->get('/order/list');
        $body = $response->getBody()->getContents();
        dd($body);
    }

    public function createOrder(Order $order)
    {
        $response = $this->client()->post('/order/create', array(
            'json' => $order
        ));
        dd('hi');
        $body = $response->getBody()->getContents();
        dd($body);
    }

    public function  updateOrder(Order $order)
    {

    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function client()
    {
        return $client = new \GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://local.youpay.ai/api',
            // You can set any number of default request options.
            'timeout'  => 2.0,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->api_key
            ]
        ]);
    }

    public function request($path, $data = [], $type = 'GET')
    {

    }
}
