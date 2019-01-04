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
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $mail;

    /**
     * @var bool
     */
    private $mailVerified;

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

        if (isset($data['first_name']) && is_string($data['first_name'])) {
            $this->firstName = $data['first_name'];
        }

        if (isset($data['last_name']) && is_string($data['last_name'])) {
            $this->lastName = $data['last_name'];
        }

        if (isset($data['mail']) && is_string($data['mail']) && filter_var($data['mail'], FILTER_VALIDATE_EMAIL) !== false) {
            $this->mail = $data['mail'];
        }

        if (isset($data['mail_verified']) && is_bool($data['mail_verified'])) {
            $this->mailVerified = $data['mail_verified'];
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
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
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
            "\t firstName => $this->firstName,\n" .
            "\t lastName => $this->lastName,\n" .
            "\t mail => $this->mail,\n" .
            "\t mailVerified => $this->mailVerified,\n" .
            "}";
    }
}