<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\User;


class User
{
    /**
     * @var string
     */
    private $uid;

    /**
     * @var string
     */
    private $mail;

    /**
     * @var BaseAddress
     */
    private $shippingAddress;

    /**
     * @var BaseAddress
     */
    private $billingAddress;

    /**
     * User constructor.
     * @param string $uid
     * @param string $mail
     * @param BaseAddress|null $shippingAddress
     * @param BaseAddress|null $billingAddress
     */
    public function __construct($uid, $mail, $shippingAddress = null, $billingAddress = null) {
        $this->uid = $uid;
        $this->mail = $mail;
        $this->shippingAddress = $shippingAddress;
        $this->billingAddress = $billingAddress;
    }

    public function getUid() {
        return $this->uid;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getShippingAddress() {
        return $this->shippingAddress;
    }

    public function getBillingAddress() {
        return $this->billingAddress;
    }

    public function __toString() {
        return
        "{\n" .
            "\t uid => $this->uid,\n" .
            "\t mail => $this->mail,\n" .
            "\t shippingAddress => $this->shippingAddress,\n" .
            "\t billingAddress => $this->billingAddress\n" .
        "}";
    }


}