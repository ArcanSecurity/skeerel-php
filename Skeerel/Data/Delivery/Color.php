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
        if (strcasecmp($value, Color::GREEN) === 0) {
            return Color::GREEN;
        }

        if (strcasecmp($value, Color::ORANGE) === 0) {
            return Color::ORANGE;
        }

        if (strcasecmp($value, Color::RED) === 0) {
            return Color::RED;
        }

        return null;
    }
}