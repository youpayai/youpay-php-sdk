<?php

namespace YouPaySDK;


class OrderItem
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
    public $quantity;

    /**
     * @var float
     */
    public $total;

    /**
     * Create Order Items
     *
     * @param $fillable
     * @return OrderItem
     */
    public static function create($fillable)
    {
        $self = new self();

        $self->title = $fillable['title'];
        $self->description = $fillable['description'];
        $self->product_id = $fillable['product_id'];
        $self->price = $fillable['price'];
        $self->quantity = $fillable['quantity'];
        $self->total = $fillable['total'];

        if (!empty($fillable['variants'])) {
            $self->variants = $fillable['variants'];
        }
        if (!empty($fillable['variants_display'])) {
            $self->variants_display = $fillable['variants_display'];
        }

        return $self;
    }
}