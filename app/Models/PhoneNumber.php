<?php

namespace App\Models;

use App\Traits\Numverify;

class PhoneNumber
{
    use Numverify;

    /**
     * The phone number of the object
     * @var string
     */
    public $number;

    /**
     * The validity of the phone number
     * @var boolean
     */
    public $valid;

    /**
     * The status of the phone number
     * @var string
     */
    public $status;

    /**
     * The carrier of the phone number
     * @var string
     */
    public $carrier;


    public function __construct()
    {
        $this->key = config('services.numverify.key');
    }

    /**
     * Use Numverify trait to check the phone number
     * @return App\Model\PhoneNumber
     */
    public function lookup()
    {
        $response = $this->search($this->number);

        if (array_key_exists('valid', $response)) {
            $valid = $response['valid'];

            if ($valid) {
                $status = 'valid';
            } else {
                $status = 'not valid';
            }

            $this->setStatus($status);
            $this->setValid($valid);
        }

        // only include carrier information for valid numbers
        if ($this->valid && array_key_exists('carrier', $response)) {
            $carrier = $response['carrier'];
            $this->setCarrier($carrier);
        }

        return $this;
    }

    public function setValid($valid)
    {
        $this->valid = $valid;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setCarrier($carrier)
    {
        $this->carrier = $carrier;
    }

}
