<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Data\Delivery;


use Skeerel\Data\Address\Country;

class PickUpPoint implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $primary;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @var string
     */
    private $city;

    /**
     * @var Country
     */
    private $country;

    /**
     * @var string
     */
    private $deliveryTextContent;

    /**
     * @var Color
     */
    private $deliveryTextColor;

    /**
     * @var int
     */
    private $price;

    /**
     * @var Color
     */
    private $priceTextColor;

    /**
     * PickUpPoint constructor.
     * @param string $id
     * @param string $name
     * @param string $address
     * @param string $zipCode
     * @param string $city
     * @param Country $country
     * @param bool $primary
     * @param string $deliveryTextContent
     * @param Color $deliveryTextColor
     * @param int $price
     * @param Color $priceTextColor
     */
    function __construct($id, $name, $address, $zipCode, $city, Country $country, $primary = false,
                         $deliveryTextContent = null, $deliveryTextColor = null, $price = 0, $priceTextColor = null) {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->country = $country;
        $this->primary = $primary;
        $this->deliveryTextContent = $deliveryTextContent;
        $this->deliveryTextColor = $deliveryTextColor;
        $this->price = $price;
        $this->priceTextColor = $priceTextColor;
    }


    /**
     * @return array
     */
    public function jsonSerialize() {
        $result = array(
            "id" => $this->id,
            "name" => $this->name,
            "primary" => $this->primary,
            "address" => $this->address,
            "zip_code" => $this->zipCode,
            "city" => $this->city,
            "country" => $this->country->getAlpha2(),
        );

        if ($this->deliveryTextContent != null) {
            $result['delivery_text_content'] = $this->deliveryTextContent;
            if ($this->deliveryTextColor != null) {
                $result['delivery_text_color'] = $this->deliveryTextColor;
            }
        }

        if ($this->price != null && $this->price > 0) {
            $result['price'] = $this->price;
            if ($this->priceTextColor != null) {
                $result['price_text_color'] = $this->priceTextColor;
            }
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