<?php

namespace Madlines\Common\ValueObjects;

class Price
{
    /**
     * @var int
     */
    protected $pennies;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @param int $pennies
     * @param null $currency
     */
    protected function __construct($pennies, $currency = null)
    {
        if ($pennies < 0) {
            throw new \InvalidArgumentException('Value of the price cannot be less than 0');
        }

        $this->pennies = (int) $pennies;
        $this->currency = $currency ? (string) $currency : null;
    }

    /**
     * @param float $value
     * @param null $currency
     * @return Price
     */
    public static function fromFloat($value, $currency = null)
    {
        return new self(round((float) $value * 100), $currency);
    }

    /**
     * @param int $pennies
     * @param null $currency
     * @return Price
     */
    public static function fromInt($pennies, $currency = null)
    {
        return new self($pennies, $currency);
    }

    /**
     * @return float
     */
    public function toFloat()
    {
        return $this->pennies / 100;
    }

    /**
     * @return int
     */
    public function toPennies()
    {
        return $this->pennies;
    }

    /**
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param Price $price
     * @return bool
     */
    public function equals(Price $price)
    {
        return $this->pennies === $price->pennies && $this->currency === $price->currency;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = $this->pennies / 100;
        if ($this->currency) {
            $string .= ' ' . $this->currency;
        }

        return (string) $string;
    }

    /**
     * @param Price $price
     * @return Price
     */
    public function add(Price $price)
    {
        if ($this->currency !== $price->currency) {
            throw new \InvalidArgumentException('You cannot sum prices of different currencies');
        }

        return new self($this->pennies + $price->pennies, $this->currency);
    }

    /**
     * @param Price $price
     * @return Price
     */
    public function subtract(Price $price)
    {
        if ($this->currency !== $price->currency) {
            throw new \InvalidArgumentException('You cannot subtract price of different currency');
        }

        if ($this->pennies < $price->pennies) {
            throw new \InvalidArgumentException('You cannot subtract a price of a bigger value');
        }

        return new self($this->pennies - $price->pennies, $this->currency);
    }

    /**
     * @param $percentage
     * @return Price
     */
    public function addPercentage($percentage)
    {
        if ($percentage < 0) {
            throw new \InvalidArgumentException('$percentage cannot be a negative value');
        }

        $fraction = ($this->pennies * $percentage) / 100;
        $value = round($this->pennies + $fraction);

        return new self($value, $this->currency);
    }

    /**
     * @param $percentage
     * @return Price
     */
    public function subtractPercentage($percentage)
    {
        if ($percentage < 0) {
            throw new \InvalidArgumentException('$percentage cannot be a negative value');
        }

        $fraction = ($this->pennies * $percentage) / 100;
        $value = round($this->pennies - $fraction);

        return new self($value, $this->currency);
    }
}
