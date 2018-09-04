<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Data\Transaction;


use Skeerel\Exception\IllegalArgumentException;

class Transaction
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var bool
     */
    private $live;

    /**
     * @var int
     */
    private $amountPaid;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * @var bool
     */
    private $threeDSecured;

    /**
     * @var PaymentMethod
     */
    private $paymentMethod;

    /**
     * @var int
     */
    private $errorCode;

    /**
     * @var string
     */
    private $errorMessage;

    /**
     * Payment constructor.
     * @param array $data
     * @throws IllegalArgumentException
     */
    public function __construct($data) {
        if (!is_array($data)) {
            throw new IllegalArgumentException("Transaction cannot be parsed due to incorrect data");
        }

        if (isset($data['id']) && is_string($data['id'])) {
            $this->id = $data['id'];
        }

        if (isset($data['live']) && is_bool($data['live'])) {
            $this->live = $data['live'];
        }

        if (isset($data['amount_paid']) && is_int($data['amount_paid'])) {
            $this->amountPaid = $data['amount_paid'];
        }

        if (isset($data['currency']) && is_string($data['currency'])) {
            $this->currency = Currency::fromString($data['currency']);
        }

        if (isset($data['three_d_secured']) && is_bool($data['three_d_secured'])) {
            $this->threeDSecured = $data['three_d_secured'];
        }

        if (isset($data['payment_method']) && is_string($data['payment_method'])) {
            $this->threeDSecured = PaymentMethod::fromString($data['payment_method']);
        }

        if (isset($data['error_code']) && is_int($data['error_code'])) {
            $this->errorCode = PaymentMethod::fromString($data['error_code']);
        }

        if (isset($data['error_message']) && is_string($data['error_message'])) {
            $this->errorMessage = PaymentMethod::fromString($data['error_message']);
        }
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isLive() {
        return $this->live;
    }

    /**
     * @return int
     */
    public function getAmountPaid() {
        return $this->amountPaid;
    }

    /**
     * @return Currency
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * @return bool
     */
    public function isThreeDSecured() {
        return $this->threeDSecured;
    }

    /**
     * @return PaymentMethod
     */
    public function getPaymentMethod() {
        return $this->paymentMethod;
    }

    /**
     * @return int
     */
    public function getErrorCode() {
        return $this->errorCode;
    }

    /**
     * @return string
     */
    public function getErrorMessage() {
        return $this->errorMessage;
    }


    /**
     * @return bool
     */
    public function isError() {
        return !is_null($this->errorCode) || !is_null($this->errorMessage);
    }

    /**
     * @return string
     */
    public function __toString() {
        return
            "{\n" .
            "\t id => $this->id,\n" .
            "\t live => $this->live,\n" .
            "\t amountPaid => $this->amountPaid,\n" .
            "\t currency => $this->currency,\n" .
            "\t threeDSecured => $this->threeDSecured,\n" .
            "\t paymentMethod => $this->paymentMethod,\n" .
            "\t errorCode => $this->errorCode,\n" .
            "\t errorMessage => $this->errorMessage,\n" .
            "}";
    }
}
