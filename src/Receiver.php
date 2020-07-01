<?php

namespace YouPaySDK;


class Receiver
{
    /**
     * @var string Full Name
     */
    public $name;

    /**
     * @var string Phone Number
     */
    public $phone;

    /**
     * @var string Email Address
     */
    public $email;

    /**
     * @var string Address Line 1
     */
    public $address_1;

    /**
     * @var string Address Line 2
     */
    public $address_2;

    /**
     * @var string Suburb
     */
    public $suburb;

    /**
     * @var string State
     */
    public $state;

    /**
     * @var string Country - AU, US, etc
     */
    public $country;

    /**
     * @var string Postal / Zip code
     */
    public $postcode;

    /**
     * @var array Everything else. Might be used in the future.
     */
    public $extra = array();

    /**
     * Create Receiver
     *
     * @return Receiver
     */
    public static function create($fillable)
    {
        $user = new self();
        $user->name = $fillable['name'];
        if ( !empty($fillable['phone']) ) {
            $user->phone = $fillable['phone'];
        }
        $user->email = $fillable['email'];
        $user->address_1 = $fillable['address_1'];
        $user->address_2 = $fillable['address_2'];
        $user->suburb = $fillable['suburb'];
        $user->state = $fillable['state'];
        $user->country = $fillable['country'];
        $user->postcode = $fillable['postcode'];

        if (!empty($fillable['extra'])) {
            $user->extra = $fillable['extra'];
        }

        return $user;
    }
}