<?php

namespace YouPaySDK;


class OrderItem
{
    /**
     * @var string
     */
    public $product_id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string Product Image URL.
     */
    public $src;

    /**
     * @var array
     */
    public $variants = [];

    /**
     * @var array
     */
    public $variants_display = '';

    /**
     * @var float
     */
    public $price;

    /**
     * @var int
     */
    public $quantity;

    /**
     * @var float
     */
    public $total;

    /**
     * Create Order Items
     *
     * @param array $fillable [
     *        string    title*,
     *        string    product_id*,
     *        string    src*,
     *        float     price*,
     *        int       quantity*,
     *        float     total*,
     *        string    description,
     *        array     variants,
     *        string    variants_display
     * ]
     * @return OrderItem
     */
    public static function create($fillable)
    {
        $order = new self();
        $order->title = $fillable['title'];
        $order->product_id = $fillable['product_id'];
        $order->price = $fillable['price'];
        $order->quantity = $fillable['quantity'];
        $order->total = $fillable['total'];
        $order->src = $fillable['src'];

        // Option Fields
        if ( ! empty($fillable['description']) ) {
            $order->description = $fillable['description'];
        }
        if ( ! empty($fillable['variants'])) {
            $order->variants = $fillable['variants'];
        }
        if ( ! empty($fillable['variants_display'])) {
            $order->variants_display = $fillable['variants_display'];
        }

        return $order;
    }
}