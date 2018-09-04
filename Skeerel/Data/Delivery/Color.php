<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Data\Delivery;


abstract class Color
{
    const GREEN = "green";

    const ORANGE = "orange";

    const RED = "red";

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