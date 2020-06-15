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

    /**
     * Get API Token
     *
     * @param string $email
     * @param string $password
     * @param string $domain
     *
     * @return object [access_token, store_id] || ['status_code', 'message', 'error']
     */
    public static function auth($email, $password, $domain)
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://local.youpay.ai/api',
            'timeout'  => 2.0,
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);

        $response = $client->post('/api/login', [
            'json' => [
                'email'     => $email,
                'password'  => $password,
                'domain'    => $domain
            ]
        ]);

        return json_decode(
            $response->getBody()->getContents()
        );
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
