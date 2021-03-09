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
     * @var string API Url
     */
    public $api_url = 'https://app.youpay.ai/';

    public function __construct()
    {
        if (defined('YOUPAY_APP_URL')) {
            $this->api_url = YOUPAY_APP_URL;
        }
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
        $self = new self();
        return $self
            ->setToken($token)
            ->setStoreID($store_id);
    }

    /**
     * Get API Token
     *
     * @param string $email
     * @param string $password
     * @param string $domain
     *
     * @return object [status_code, access_token, store_id] || [status_code, message, error]
     * @throws \Exception Bad Data.
     */
    public static function auth($email, $password, $domain, $store_type)
    {
        $self = new self();

//        $available_store_types = ['opencart', 'woocommerce', 'shopify'];
//
//        if ( ! in_array($store_type, $available_store_types)) {
//            throw new \Exception('Please select from one of the available store types: ' . implode($available_store_types, ', '));
//        }

        $response = $self->client()->post('/api/login', [
            'json' => [
                'email'      => $email,
                'password'   => $password,
                'domain'     => $domain,
                'store_type' => $store_type
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
     * @throws \Exception Bad Response Exception.
     */
    public function listOrders($limit = 10)
    {
        return $this->handleResponse(
            $this->client()
                ->post('/api/order/list', [
                    'json' => [
                        'store_id' => $this->store_id,
	                    'limit' => $limit
                    ]
                ])
        );
    }

    /**
     * List All Store Orders
     *
     * @return array
     * @throws \Exception Bad Response Exception.
     */
    public function listAllOrders($limit = 10)
    {
        return $this->handleResponse(
            $this->client()->post('/api/order/list', [
	            'json' => [
		            'limit' => $limit
	            ]
            ])
        );
    }


	/**
	 * List All Store Payments
	 *
	 * @param string
	 * @return array
	 * @throws \Exception Bad Response Exception.
	 */
	public function listPayments($limit = 10)
	{
		return $this->handleResponse(
			$this->client()
			     ->post('/api/payments/list', [
				     'json' => [
					     'store_id' => $this->store_id,
					     'limit' => $limit
				     ]
			     ])
		);
	}

	/**
	 * List All Store Payments
	 *
	 * @return array
	 * @throws \Exception Bad Response Exception.
	 */
	public function listAllPayments($limit = 10)
	{
		return $this->handleResponse(
			$this->client()->post('/api/payments/list', [
				'json' => [
					'limit' => $limit
				]
			])
		);
	}

    /**
     * Create or Update an Order
     *
     * @param Order $order
     * @param mixed $params Extra data to pass to the request
     * @return mixed
     * @throws \Exception Bad Response Exception.
     */
    public function postOrder(Order $order, $params = null)
    {
        $path = ($order->youpay_id) ? "/api/order/{$order->youpay_id}" : '/api/order/create';

        return $this->handleResponse(
            $this->client()
                ->post($path, [
                    'json' => [
                        'order' => $order,
                        'store_id' => $this->store_id,
	                    'params' => $params
                    ]
                ])
        );
    }

    /**
     * Get the Order by ID
     *
     * @param $id
     * @return mixed
     * @throws \Exception Bad Response Exception.
     */
    public function getOrder($id)
    {
        return $this->handleResponse(
            $this->client()->get('/api/order/' . $id)
        );
    }

	/**
	 * Cancel Order
	 *
	 * @param $id
	 *
	 * @return mixed|null
	 * @throws \Exception
	 */
    public function cancelOrder($id)
    {
	    return $this->handleResponse(
		    $this->client()->get('/api/order/' . $id . '/cancel')
	    );
    }

    /**
     * Get the Store by ID
     *
     * @param $id
     * @return mixed
     * @throws \Exception Bad Response Exception.
     */
    public function getStore($id = false)
    {
    	if (!$id) {
    		$id = $this->store_id;
	    }
        return $this->handleResponse(
            $this->client()->get('/api/store/' . $id)
        );
    }

    /**
     * Get the Stores
     *
     * @return mixed
     * @throws \Exception Bad Response Exception.
     */
    public function getStores()
    {
        return $this->handleResponse(
            $this->client()->get('/api/stores/list')
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
        return $this->handleResponse(
            $this->client()
                ->post('/api/stores/find', [
                    'json' => [
                        'domain' => $domain
                    ]
                ])
        );
    }

    /**
     * Update Store Details
     *
     * @param $title
     * @param string $logo
     * @param string $description
     * @return mixed|null
     * @throws \Exception Bad Response Exception.
     */
    public function updateStore($title, $logo = '', $description = '')
    {
        return $this->handleResponse(
            $this->client()
                ->post('/api/store/' . $this->store_id, [
                    'json' => [
                        'title' => $title,
                        'logo' => $logo,
                        'description' => $description,
                    ]
                ])
        );
    }

    /**
     * Get the Guzzle Client
     *
     * @return \GuzzleHttp\Client
     */
    public function client()
    {
        // TODO: prevent redirects. Should error out. Also increase timeout.
        $headers = ['Content-Type' => 'application/json'];

        if (!empty($this->token)) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        }

        return new \GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => $this->api_url,
            // You can set any number of default request options.
            'timeout' => 60.0,
            'headers' => $headers
        ]);
    }

    /**
     * Handle Response and return data
     * TODO: Handle validation errors better
     *
     * @param $response
     * @return mixed|null
     * @throws \Exception
     */
    public function handleResponse($response)
    {
        $content = $response->getBody()->getContents();
        $data = json_decode($content);
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Unknown response data: ' . $content);
        }
        return $data;
    }

    /**
     * Set Token
     *
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set Store ID
     *
     * @param $store_id
     * @return $this
     */
    public function setStoreID($store_id)
    {
        $this->store_id = $store_id;

        return $this;
    }

    /**
     * Create Order class via the client.
     *
     * @see Order::create()
     * @param $fillable
     * @return Order
     * @throws \Exception Bad Response Exception.
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
     * @throws \Exception Bad Response Exception.
     */
    public function createOrderFromArray($fillable, $youpay_id = null)
    {
        return $this->postOrder(
	        $this->createOrderClass($fillable, $youpay_id),
	        (!empty($fillable['params'])) ? $fillable['params'] : null
        );
    }

	/**
	 * Magic Login Link for URL
	 *
	 * @param $url
	 *
	 * @return mixed|null
	 * @throws \Exception
	 */
    public function link($url = '/dashboards/main')
    {
	    return $this->handleResponse(
		    $this->client()->post('/api/magic-link', [
			    'json' => [
				    'url' => $url
			    ]
		    ])
	    )->url;
    }

    /**
     * Get Checkout JS Url
     *
     * @return mixed
     * @throws \Exception
     */
    public function getCheckoutJSUrl($unique_id = false)
    {
	    if ($unique_id) {
		    return  rtrim($this->api_url, '/') . '/checkout.js?unique=' . $unique_id;
	    }
	    return  rtrim($this->api_url, '/') . '/checkout.js?random=' . time();
    }

    /**
     * Get Checkout JS Url
     *
     * @return mixed
     * @throws \Exception
     */
    public static function checkoutUrl($unique_id = false)
    {
        $self = new self();
        return $self->getCheckoutJSUrl($unique_id);
    }
}
