<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\User;


use Skeerel\Exception\IllegalArgumentException;

abstract class BaseAddress
{
    private $address;

    private $addressLine2;

    private $addressLine3;

    private $zipCode;

    private $city;

    private $country;

    private $phone;

    protected function __construct($address) {
        if (!is_array($address)) {
            throw new IllegalArgumentException("address should be an array");
        }

        $this->setAddress($address);
        $this->setAddressLine2($address);
        $this->setAddressLine3($address);
        $this->setZipCode($address);
        $this->setCity($address);
        $this->setCountry($address);
        $this->setPhone($address);
    }

    private function setAddress($address) {
        if (isset($address['address']) && is_string($address['address'])) {
            $this->address = $address['address'];
        }
    }

    private function setAddressLine2($address) {
        if (isset($address['address_line_2']) && is_string($address['address_line_2'])) {
            $this->addressLine2 = $address['address_line_2'];
        }
    }

    private function setAddressLine3($address) {
        if (isset($address['address_line_3']) && is_string($address['address_line_3'])) {
            $this->addressLine3 = $address['address_line_3'];
        }
    }

    private function setZipCode($address) {
        if (isset($address['zip_code']) && is_string($address['zip_code'])) {
            $this->zipCode = $address['zip_code'];
        }
    }

    private function setCity($address) {
        if (isset($address['city']) && is_string($address['city'])) {
            $this->city = $address['city'];
        }
    }

    private function setCountry($address){
        if (isset($address['country_code'])) {
            $this->country = Country::fromAlpha2($address['country_code']);
        }
    }

    private function setPhone($address) {
        if (isset($address['phone_number']) && is_string($address['phone_number']) &&
            preg_match('/^\+[1-9]\d{9,14}$/', $address['phone_number']) === 1) {
            $this->phone = $address['phone_number'];
        }
    }

    public function getAddress() {
        return $this->address;
    }

    public function getAddressLine2() {
        return $this->addressLine2;
    }

    public function getAddressLine3() {
        return $this->addressLine3;
    }

    public function getZipCode() {
        return $this->zipCode;
    }

    public function getCity() {
        return $this->city;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getPhone() {
        return $this->phone;
    }



    public abstract function isIndividual();

    public abstract function isCompany();

    public function __toString() {
        return
        "\t address => $this->address,\n" .
        "\t addressLine2 => $this->addressLine2,\n" .
        "\t addressLine3 => $this->addressLine3,\n" .
        "\t zipCode => $this->zipCode,\n" .
        "\t city => $this->city,\n" .
        "\t country => $this->country,\n" .
        "\t phone => $this->phone";
    }


    public static function build($address) {
        if (!is_array($address)) {
            throw new IllegalArgumentException("address should be an array");
        }

        if (isset($address['company_name'])) {
            return new CompanyAddress($address);
        }

        return new IndividualAddress($address);
    }
}