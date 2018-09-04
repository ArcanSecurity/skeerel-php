<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Data;


use Skeerel\Data\Address\BaseAddress;
use Skeerel\Exception\IllegalArgumentException;
use Skeerel\Util\UUID;

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
     * @var bool
     */
    private $mailVerified;

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
     * @param array $data
     * @throws IllegalArgumentException
     */
    function __construct($data) {
        if (!is_array($data)) {
            throw new IllegalArgumentException("User cannot be parsed due to incorrect data");
        }

        if (isset($data['uid']) && is_string($data['uid']) && UUID::isValid($data['uid'])) {
            $this->uid = $data['uid'];
        }

        if (isset($data['mail']) && is_string($data['mail']) && filter_var($data['mail'], FILTER_VALIDATE_EMAIL) !== false) {
            $this->mail = $data['mail'];
        }

        if (isset($data['mail_verified']) && is_bool($data['mail_verified'])) {
            $this->mailVerified = $data['mail_verified'];
        }

        if (isset($data['shipping_address'])) {
            $this->shippingAddress = BaseAddress::build($data['shipping_address']);
        }

        if (isset($data['billing_address'])) {
            $this->billingAddress = BaseAddress::build($data['billing_address']);
        }
    }

    /**
     * @return string
     */
    public function getUid() {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function getMail() {
        return $this->mail;
    }

    /**
     * @return bool
     */
    public function isMailVerified() {
        return $this->mailVerified;
    }

    /**
     * @return BaseAddress
     */
    public function getShippingAddress() {
        return $this->shippingAddress;
    }

    /**
     * @return BaseAddress
     */
    public function getBillingAddress() {
        return $this->billingAddress;
    }



    /**
     * @return bool
     */
    public function isGuest() {
        return $this->uid == null;
    }

    /**
     * @return string
     */
    public function __toString() {
        return
            "{\n" .
            "\t uid => $this->uid,\n" .
            "\t mail => $this->mail,\n" .
            "\t mailVerified => $this->mailVerified,\n" .
            "\t shippingAddress => $this->shippingAddress,\n" .
            "\t billingAddress => $this->billingAddress\n" .
            "}";
    }
}