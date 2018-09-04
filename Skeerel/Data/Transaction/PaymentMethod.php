<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Data\Transaction;


abstract class PaymentMethod {
    const APPLE_PAY = "APPLE_PAY";

    const CARD = "NATIVE";

    const GOOGLE_PAY = "GOOGLE_PAY";

    /**
     * @param $value
     * @return null|string
     */
    public static function fromString($value) {
        if (strcasecmp($value, PaymentMethod::APPLE_PAY) === 0) {
            return PaymentMethod::APPLE_PAY;
        }

        if (strcasecmp($value, PaymentMethod::GOOGLE_PAY) === 0) {
            return PaymentMethod::GOOGLE_PAY;
        }

        if (strcasecmp($value, PaymentMethod::CARD) === 0) {
            return PaymentMethod::CARD;
        }

        return null;
    }
}