<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Data\Delivery;


abstract class Type
{
    const HOME = "home";

    const RELAY = "relay";

    const COLLECT = "collect";

    /**
     * @param $value
     * @return null|string
     */
    public static function fromString($value) {
        if (strcasecmp($value, Type::HOME) === 0) {
            return Type::HOME;
        }

        if (strcasecmp($value, Type::RELAY) === 0) {
            return Type::RELAY;
        }

        if (strcasecmp($value, Type::COLLECT) === 0) {
            return Type::COLLECT;
        }

        return null;
    }
}