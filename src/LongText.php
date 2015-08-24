<?php

namespace Madlines\Common\ValueObjects;

class LongText
{
    const MAX_LENGTH = 33554432;

    /**
     * @var string
     */
    protected $value;

    /**
     * @param $string
     */
    public function __construct($string)
    {
        $string = (string) $string;
        if (strlen($string) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException('The LongText cannot be longer that ' . self::MAX_LENGTH . ' bytes');
        }

        if (!$string) {
            throw new \InvalidArgumentException('The LongText cannot be empty');
        }

        $this->value = $string;
    }

    /**
     * @param LongText $longText
     * @return bool
     */
    public function equals(LongText $longText)
    {
        return (string) $longText === $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
