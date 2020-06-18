<?php
namespace YouPaySDK;

/**
 * YouPay Client
 *
 * @package YouPaySDK
 */
class Client
{
    /**
     * @var string API Token
     */
    private $token;

    /**
     * @var string Store ID
     */
    private $store_id;

    /**
     * Client constructor.
     *
     * @param string $token
     * @param string $store_id
     */
    public function __construct($token, $store_id = '')
    {
        $this->token = $token;
        $this->store_id = $store_id;
    }

    /**
     * Create the client
     *
     * @param string $token
     * @param string $store_id
     * @return Client
     */
    public static function create($token, $store_id = '')
    {
        return new self($token, $store_id);
    }

    /**
     * Get API Token
     *
     * @param string $email
     * @param string $password
     * @param string $domain
     *
     * @return object [status_code, access_token, store_id] || [status_code, message, error]
     */
    public static function auth($email, $password, $domain)
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://local.youpay.ai/api',
            'timeout' => 2.0,
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);

        $response = $client->post('/api/login', [
            'json' => [
                'email' => $email,
                'password' => $password,
                'domain' => $domain
            ]
        ]);

        return json_decode(
            $response->getBody()->getContents()
        );
    }

    /**
     * List All Store Orders
     *
     * @param string
     * @return array
     */
    public function listOrders()
    {
        return json_decode(
            $this->client()
                ->post('/api/order/list', [
                    'json' => [
                        'store_id' => $this->store_id
                    ]
                ])
                ->getBody()->getContents()
        );
    }

    /**
     * List All Store Orders
     *
     * @return array
     */
    public function listAllOrders()
    {
        return json_decode(
            $this->client()
                ->get('/api/order/list')
                ->getBody()->getContents()
        );
    }

    /**
     * Create or Update an Order
     *
     * @param Order $order
     * @return mixed
     */
    public function postOrder(Order $order)
    {
        $path = ($order->youpay_id) ? "/api/order/{$order->youpay_id}" : '/api/order/create';

        return json_decode(
            $this->client()
                ->post($path, [
                    'json' => [
                        'order' => $order,
                        'store_id' => $this->store_id
                    ]
                ])
                ->getBody()->getContents()
        );
    }

    /**
     * Get the Order by ID
     *
     * @param $id
     * @return mixed
     */
    public function getOrder($id)
    {
        return json_decode(
            $this->client()
                ->get('/api/order/' . $id)
                ->getBody()->getContents()
        );
    }

    /**
     * Get the Store by ID
     *
     * @param $id
     * @return mixed
     */
    public function getStore($id)
    {
        return json_decode(
            $this->client()
                ->get('/api/store/' . $id)
                ->getBody()->getContents()
        );
    }

    /**
     * Get the Stores
     *
     * @return mixed
     */
    public function getStores()
    {
        return json_decode(
            $this->client()
                ->get('/api/stores/list')
                ->getBody()->getContents()
        );
    }

    /**
     * Get the Store by Domain name
     *
     * @param string $domain eg. google.com
     * @return mixed
     */
    public function findStore($domain)
    {
        return json_decode(
            $this->client()
                ->post('/api/stores/find', [
                    'json' => [
                        'domain' => $domain
                    ]
                ])
                ->getBody()->getContents()
        );
    }

    /**
     * Get the Guzzle Client
     *
     * @return \GuzzleHttp\Client
     */
    public function client()
    {
        return new \GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://local.youpay.ai/api',
            // You can set any number of default request options.
            'timeout' => 2.0,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token
            ]
        ]);
    }

    /**
     * Create Order class via the client.
     *
     * @see Order::create()
     * @param $fillable
     * @return Order
     */
    public function createOrderClass($fillable, $youpay_id = null)
    {
        $order = Order::create($fillable)
            ->setStoreID($this->store_id);
        if ($youpay_id) {
            $order->setYouPayID($youpay_id);
        }
        return $order;
    }

    /**
     * Create Order and Post to API
     *
     * @param $fillable
     * @param null $youpay_id
     * @return mixed
     */
    public function createOrder($fillable, $youpay_id = null)
    {
        $order = $this->createOrderClass($fillable, $youpay_id);
        return $this->postOrder($order);
    }
}
