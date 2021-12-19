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
     * @var string Product Image URL.
     */
    public $order_item_id;

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
     * @var float
     */
    public $discounted_total;

    /**
     * @var string
     */
    public $discount_label;

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
        $item = new self();
        $item->order_item_id = $fillable['order_item_id'];
        $item->product_id = $fillable['product_id'];
        $item->title = $fillable['title'];
        $item->src = $fillable['src'];
        $item->price = $fillable['price'];
        $item->quantity = $fillable['quantity'];
        $item->total = $fillable['total'];

        // Optional Fields
        $item->discount_label = ! empty($fillable['discount_label']) ? $fillable['discount_label'] : 0;
        $item->discounted_total = ! empty($fillable['discounted_total']) ? $fillable['discounted_total'] : 0;
        $item->description = ! empty($fillable['description']) ? $fillable['description'] : null;
        $item->variants = ! empty($fillable['variants']) ? $fillable['variants'] : [];
        $item->variants_display = ! empty($fillable['variants_display']) ? $fillable['variants_display'] : '';

        return $item;
    }
}