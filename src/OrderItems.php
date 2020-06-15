<?php

namespace YouPaySDK;


class OrderItems
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $product_id;

    /**
     * @var array
     */
    public $variants;

    /**
     * @var array
     */
    public $variant_display;

    /**
     * @var float
     */
    public $price;
}