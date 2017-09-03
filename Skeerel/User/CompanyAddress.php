<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\User;


class CompanyAddress extends BaseAddress
{

    private $status;

    private $companyName;

    private $vatNumber;

    public function __construct($address) {
        parent::__construct($address);

        $this->setStatus($address);
        $this->setCompanyName($address);
        $this->setVatNumber($address);
    }

    private function setStatus($address) {
        if (isset($address['status']) && is_string($address['status'])) {
            $this->status = $address['status'];
        }
    }

    private function setCompanyName($address) {
        if (isset($address['company_name']) && is_string($address['company_name'])) {
            $this->companyName = $address['company_name'];
        }
    }

    private function setVatNumber($address) {
        if (isset($address['vat_number']) && is_string($address['vat_number'])) {
            $this->vatNumber = $address['vat_number'];
        }
    }

    public function isIndividual() {
        return false;
    }

    public function isCompany() {
        return true;
    }

    public function __toString() {
        return
        "{\n" .
            "\t status => $this->status,\n" .
            "\t companyName => $this->companyName,\n" .
            "\t vatNumber => $this->vatNumber,\n" .
            parent::__toString() . "\n" .
        "}";
    }
}