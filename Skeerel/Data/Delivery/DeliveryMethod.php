<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Data\Delivery;


use Skeerel\Exception\IllegalArgumentException;

class DeliveryMethod implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $primary;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $deliveryTextContent;

    /**
     * @var int
     */
    private $price;

    /**
     * @var Color
     */
    private $pickUpPoints;


    /**
     * DeliveryMethod constructor.
     * @param string $id
     * @param string $type
     * @param string $name
     * @param string $deliveryTextContent
     * @param int $price
     * @param bool $primary
     * @param null|PickUpPoints $pickUpPoints
     * @throws IllegalArgumentException
     */
    function __construct($id, $type, $name, $deliveryTextContent, $price, $primary = false, $pickUpPoints = null) {
        $this->id = $id;
        $this->type = $type;
        $this->primary = $primary;
        $this->name = $name;
        $this->deliveryTextContent = $deliveryTextContent;
        $this->price = $price;

        if ($this->type === Type::HOME && $pickUpPoints !== null) {
            throw new IllegalArgumentException("Home delivery cannot have pick up points");
        }

        if ($this->type !== Type::HOME && ($pickUpPoints === null || $pickUpPoints->isEmpty())) {
            throw new IllegalArgumentException("$this->type must have pick up points");
        }

        $this->pickUpPoints = $pickUpPoints;
    }

    /**
     * @return array
     */
    public function jsonSerialize() {
        $result = array(
            "id" => $this->id,
            "type" => $this->type,
            "primary" => $this->primary,
            "name" => $this->name,
            "delivery_text_content" => $this->deliveryTextContent,
            "price" => $this->price
        );

        if ($this->pickUpPoints != null) {
            $result["pick_up_points"] = $this->pickUpPoints->jsonSerialize();
        }

        return $result;
    }

    /**
     * @return string
     */
    public function toJson() {
        return json_encode($this->jsonSerialize());
    }
}