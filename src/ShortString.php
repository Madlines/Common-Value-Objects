<?php

namespace Madlines\Common\ValueObjects;

class ShortString
{
    const MAX_LENGTH = 255;

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
            throw new \InvalidArgumentException('The ShortString cannot be longer that ' . self::MAX_LENGTH . ' bytes');
        }

        if (!$string) {
            throw new \InvalidArgumentException('The ShortString cannot be empty');
        }

        $this->value = $string;
    }

    /**
     * @param ShortString $shortString
     * @return bool
     */
    public function equals(ShortString $shortString)
    {
        return (string) $shortString === $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
