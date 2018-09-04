<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Data\Transaction;


abstract class Currency
{
    const EUR = "EUR";

    /**
     * @param $value
     * @return null|string
     */
    public static function fromString($value) {
        if (strcasecmp($value, Currency::EUR) === 0) {
            return Currency::EUR;
        }

        return null;
    }
}