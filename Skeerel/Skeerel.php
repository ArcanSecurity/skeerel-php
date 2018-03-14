<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel;

use phpseclib\Crypt\RSA;
use Skeerel\Exception\APIException;
use Skeerel\Exception\IllegalArgumentException;
use Skeerel\Exception\InvalidStateException;
use Skeerel\User\BaseAddress;
use Skeerel\User\User;
use Skeerel\Util\Crypto;
use Skeerel\Util\Random;
use Skeerel\Util\Request;
use Skeerel\Util\Session;
use Skeerel\Util\UUID;

class Skeerel
{
    const API_BASE = 'https://api.skeerel.com/v2/';

    const DEFAULT_COOKIE_NAME = 'skeerel-state';

    private $websiteID;

    private $websiteSecret;

    /**
     * @var RSA
     */
    private $rsaInstance;

    public function __construct($websiteID, $websiteSecret, $rsaPrivateKey = null)
    {
        if (!is_string($websiteID) || !UUID::isValid($websiteID)) {
            throw new IllegalArgumentException("websiteId must be a string UUID");
        }

        if (!is_string($websiteSecret)) {
            throw new IllegalArgumentException("websiteSecret must be a string");
        }

        if (null !== $rsaPrivateKey) {
            $this->rsaInstance = new RSA();
            $this->rsaInstance->setEncryptionMode(RSA::ENCRYPTION_OAEP);
            $this->rsaInstance->setHash("sha256");
            $this->rsaInstance->setMGFHash("sha256");

            if (!$this->rsaInstance->loadKey($rsaPrivateKey)) {
                throw new IllegalArgumentException("the provided rsa private key is not valid");
            }
        }

        $this->websiteID = $websiteID;
        $this->websiteSecret = $websiteSecret;
    }

    public function getUser($token) {
        if (!is_string($token)) {
            throw new IllegalArgumentException("token must be a string");
        }

        $json = Request::getJson(self::API_BASE . 'me', array(
            "access_token" => $token,
            "website_id" => $this->websiteID,
            "website_secret" => $this->websiteSecret
        ));

        if (!isset($json['status']) || "ok" !== $json['status']) {
            $errorCode = isset($json['error_code']) && is_int($json['error_code']) ? $json['error_code'] : '';
            $errorMsg = isset($json['message']) && is_string($json['message']) ? $json['message'] : '';
            throw new APIException("Error " . $errorCode . ": " . $errorMsg);
        }

        if (!isset($json['data']) || !is_array($json['data'])) {
            throw new APIException("Unexpected error: status is ok, but cannot get data");
        }

        $data = $json['data'];
        if (!isset($data['uid'])  || !is_string($data['uid'])  || !UUID::isValid($data['uid']) ||
            !isset($data['mail']) || !is_string($data['mail']) || filter_var($data['mail'], FILTER_VALIDATE_EMAIL) === false) {
            throw new APIException("Unexpected error: status is ok, but cannot get user id and/or mail");
        }

        $shippingAddress = null;
        $billingAddress = null;
        if (null !== $this->rsaInstance && isset($data['addresses'])) {
            $addresses = Crypto::verifySignatureAndDecrypt($data['addresses'], $this->rsaInstance);

            if (isset($addresses['shipping_address'])) {
                $shippingAddress = BaseAddress::build($addresses['shipping_address']);
            }

            if (isset($addresses['billing_address'])) {
                $billingAddress = BaseAddress::build($addresses['billing_address']);
            }
        }

        return new User($data['uid'], $data['mail'], $shippingAddress, $billingAddress);
    }

    public static function generateSessionStateParameter($sessionName = self::DEFAULT_COOKIE_NAME) {
        Session::set($sessionName, Random::token());
    }

    public static function verifySessionStateParameter($stateValue, $sessionName = self::DEFAULT_COOKIE_NAME) {
        return Session::get($sessionName) !== $stateValue;
    }
}