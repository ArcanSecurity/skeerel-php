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
 * @method static ReasonNotCaptured NEED_MANUAL_REVIEW()
 */

abstract class ReasonNotCaptured extends Enum
{
    const NEED_MANUAL_REVIEW = "need_manual_review";
}