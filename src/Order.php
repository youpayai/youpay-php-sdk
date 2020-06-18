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
     * @var array
     */
    public $order_items = [];

    /**
     * Handling, fees, discounts and other line item totals
     *
     * @var float|false
     */
    public $extra_fees = false;

    /**
     * @var float
     */
    public $sub_total;

    /**
     * @var float
     */
    public $total;

    /**
     * Static way to initialize the class
     *
     * @param $order_id
     * @param $store_id
     * @param $title
     * @param $order_items
     * @param $extra_fees
     * @param $sub_total
     * @param $total
     * @return Order
     */
    public static function create($fillable)
    {
        $self = new self();
        $self->order_id = $fillable['order_id'];
        $self->store_id = $fillable['store_id'];
        $self->title = $fillable['title'];
        $self->order_items = $fillable['order_items'];
        $self->extra_fees = $fillable['extra_fees'];
        $self->sub_total = $fillable['sub_total'];
        $self->total = $fillable['total'];

        return $self;
    }

    /**
     * Create Order Item
     *
     * @param $fillable
     * @return $this
     */
    public function create_order_item($fillable)
    {
        $item = OrderItem::create($fillable);

        $this->order_items[] = $item;

        return $this;
    }

    /**
     * Create Order Item
     *
     * @param OrderItem $order_item
     * @return $this
     */
    public function add_order_item($order_item)
    {
        $this->order_items[] = $order_item;

        return $this;
    }
}