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
        $self = new self();
        $self->title = $fillable['title'];
        $self->product_id = $fillable['product_id'];
        $self->price = $fillable['price'];
        $self->quantity = $fillable['quantity'];
        $self->total = $fillable['total'];

        // Option Fields
        if ( ! empty($fillable['description']) ) {
            $self->description = $fillable['description'];
        }
        if ( ! empty($fillable['variants'])) {
            $self->variants = $fillable['variants'];
        }
        if ( ! empty($fillable['variants_display'])) {
            $self->variants_display = $fillable['variants_display'];
        }

        return $self;
    }
}