<?php

require_once 'vendor/autoload.php';

$client = new \YouPaySDK\Client('4|KXi82enfziD6LLDDizVlJGs2NdjTVkZbOTeXUEmbvP4v4dri4pAemtjcp8IKr4608rTdC73B0FjfXg29');

dd($client->listOrders());


dd('hi');

$order = new \YouPaySDK\Order();
$order->title = 'hi';
$order_items = array();

$item = new \YouPaySDK\OrderItems();
$item->title = 'Product';
$order_items[] = $item;
$order->order_items = $order_items;

$order = json_encode($order);



//var_dump($order);
