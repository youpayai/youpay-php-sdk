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
        return json_decode(
            $this->client()
                ->get('/api/order/list')
                ->getBody()
                ->getContents()
        );
    }

    public function createOrUpdateOrder(Order $order)
    {
        return json_decode(
            $this->client()
                ->get('/api/order/create', array(
                    'json' => $order
                ))
                ->getBody()
                ->getContents()
        );
    }

    public function  getOrder($id)
    {
        return json_decode(
            $this->client()
                ->get('/api/order/create', array(
                    'json' => $order
                ))
                ->getBody()
                ->getContents()
        );
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function client()
    {
        $options = [
            // Base URI is used with relative requests
            'base_uri' => 'http://local.youpay.ai/api',
            // You can set any number of default request options.
            'timeout'  => 2.0,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->api_key
            ]
        ];
        return $client = new \GuzzleHttp\Client($options);
    }

    public function request($path, $data = [], $type = 'GET')
    {

    }
}
