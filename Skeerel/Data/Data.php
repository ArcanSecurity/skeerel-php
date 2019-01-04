<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Data;


use Skeerel\Data\Delivery\Delivery;
use Skeerel\Data\Payment\Payment;
use Skeerel\Exception\IllegalArgumentException;

class Data
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Delivery
     */
    private $delivery;

    /**
     * @var Payment
     */
    private $payment;

    /**
     * User constructor.
     * @param array $data
     * @throws IllegalArgumentException
     */
    function __construct($data) {
        if (!is_array($data) || !isset($data['user']) || !is_array($data['user'])) {
            throw new IllegalArgumentException("Data cannot be parsed due to incorrect data");
        }

        $this->user = new User($data['user']);

        if (isset($data['payment'])) {
            $this->payment = new Payment($data['payment']);

            if (isset($data['delivery'])) {
                $this->delivery = new Delivery($data['delivery']);
            }
        }
    }

    /**
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @return Delivery
     */
    public function getDelivery() {
        return $this->delivery;
    }

    /**
     * @return Payment
     */
    public function getPayment() {
        return $this->payment;
    }

    /**
     * @return string
     */
    public function __toString() {
        return
        "{\n" .
            "\t user => $this->user,\n" .
            "\t delivery => $this->delivery,\n" .
            "\t payment => $this->payment,\n" .
        "}";
    }
}