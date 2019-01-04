<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Data\Delivery;


use Skeerel\Data\Address\BaseAddress;
use Skeerel\Exception\IllegalArgumentException;

class Delivery
{
    /**
     * @var string
     */
    private $methodId;

    /**
     * @var BaseAddress
     */
    private $shippingAddress;

    /**
     * @var string
     */
    private $pickUpPointId;

    /**
     * User constructor.
     * @param array $data
     * @throws IllegalArgumentException
     */
    function __construct($data) {
        if (!is_array($data)) {
            throw new IllegalArgumentException("Delivery cannot be parsed due to incorrect data");
        }

        if (isset($data['method_id']) && is_string($data['method_id'])) {
            $this->methodId = $data['method_id'];
        }

        if (isset($data['shipping_address'])) {
            $this->shippingAddress = BaseAddress::build($data['shipping_address']);
        }

        if (isset($data['pick_up_point_id']) && is_string($data['pick_up_point_id'])) {
            $this->pickUpPointId = $data['pick_up_point_id'];
        }
    }

    /**
     * @return string
     */
    public function getMethodId() {
        return $this->methodId;
    }

    /**
     * @return BaseAddress
     */
    public function getShippingAddress() {
        return $this->shippingAddress;
    }

    /**
     * @return string
     */
    public function getPickUpPointId() {
        return $this->pickUpPointId;
    }



    public function __toString() {
        return
            "{\n" .
            "\t methodId => $this->methodId,\n" .
            "\t shippingAddress => $this->shippingAddress,\n" .
            "\t pickUpPointId => $this->pickUpPointId,\n" .
            "}";
    }
}