<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\User;


use DateTime;

class IndividualAddress extends BaseAddress
{
    private $title;

    private $lastName;

    private $firstName;

    private $birthDate;

    public function __construct($address) {
        parent::__construct($address);

        $this->setTitle($address);
        $this->setLastName($address);
        $this->setFirstName($address);
        $this->setBirthDate($address);
    }

    private function setTitle($address) {
        if (isset($address['title']) && is_int($address['title']) &&
            (Title::MISS === $address['title'] || Title::MISTER === $address['title'])) {
            $this->title = $address['title'];
        }
    }

    private function setLastName($address) {
        if (isset($address['last_name']) && is_string($address['last_name'])) {
            $this->lastName = $address['last_name'];
        }
    }

    private function setFirstName($address) {
        if (isset($address['first_name']) && is_string($address['first_name'])) {
            $this->firstName = $address['first_name'];
        }
    }

    private function setBirthDate($address) {
        if (isset($address['birth_date']) && is_string($address['birth_date'])) {
            $d = DateTime::createFromFormat('Y-m-d', $address['birth_date']);
            if ($d && $d->format('Y-m-d') === $address['birth_date']) {
                $this->birthDate = $address['birth_date'];
            }
        }
    }

    public function getTitle() {
        return $this->title;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getBirthDate() {
        return $this->birthDate;
    }

    public function isIndividual() {
        return true;
    }

    public function isCompany() {
        return false;
    }

    public function __toString() {
        return
        "{\n" .
            "\t title => $this->title,\n" .
            "\t lastName => $this->lastName,\n" .
            "\t firstName => $this->firstName,\n" .
            "\t birthDate => $this->birthDate,\n" .
            parent::__toString() . "\n" .
        "}";
    }
}