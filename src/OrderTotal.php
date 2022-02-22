<?php

namespace YouPaySDK;


class OrderTotal
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var float
     */
    public $value;

    /**
     * @var int
     */
    public $sort_order;

    /**
     * @var string
     */
    public $key;

    /**
     * Create Order Total
     *
     * @param array $fillable [
     *        string    title*,
     *        float     value*,
     *        int     sort_order,
     * ]
     * @return OrderTotal
     */
    public static function create($fillable)
    {
        $total = new self();
        $total->title = $fillable['title'];
        $total->value = $fillable['value'];
        $total->sort_order = $fillable['sort_order'];
        $total->key = $fillable['key'];

        return $total;
    }
}
