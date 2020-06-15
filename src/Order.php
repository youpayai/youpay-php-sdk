<?php

namespace YouPaySDK;


class Order
{
    /**
     * @var string
     */
    public $order_id;

    /**
     * @var string
     */
    public $store_id;

    /**
     * @var string
     */
    public $title = '';

    /**
     * @var string
     */
    public $user_id;

    /**
     * @var array
     */
    public $order_items;

    /**
     * @var float
     */
    public $total;
}