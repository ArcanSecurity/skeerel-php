<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Data\Payment;


use Skeerel\Util\Enum;

/**
 * Class FraudRisk
 * @package Skeerel\Data\Payment
 *
 * @method static FraudRisk NORMAL()
 * @method static FraudRisk ELEVATED()
 * @method static FraudRisk HIGHEST()
 * @method static FraudRisk UNKNOWN()
 */

abstract class FraudRisk extends Enum
{
    const NORMAL = "NORMAL";

    const ELEVATED = "ELEVATED";

    const HIGHEST = "HIGHEST";

    const UNKNOWN = "UNKNOWN";
}