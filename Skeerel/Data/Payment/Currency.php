<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Data\Payment;

use Skeerel\Util\Enum;

/**
 * Class Currency
 * @package Skeerel\Data\Payment
 *
 * @method static Currency EUR()
 */
abstract class Currency extends Enum
{
    const EUR = "EUR";
}