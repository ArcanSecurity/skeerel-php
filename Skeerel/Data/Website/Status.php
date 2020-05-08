<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Data\Website;

use Skeerel\Util\Enum;

/**
 * Class Status
 * @package Skeerel\Data\Website
 *
 * @method static Status NOT_VERIFIED()
 * @method static Status PENDING()
 * @method static Status REJECTED()
 * @method static Status VERIFIED()
 */
class Status extends Enum
{
    const NOT_VERIFIED = "NOT_VERIFIED";
    const PENDING = "PENDING";
    const REJECTED = "REJECTED";
    const VERIFIED = "VERIFIED";
}