<?php

namespace Madlines\Common\ValueObjects;

class Email
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @param $value - a valid email address
     */
    public function __construct($value)
    {
        $filtered = filter_var($value, FILTER_VALIDATE_EMAIL);
        if (!$filtered) {
            throw new \InvalidArgumentException('$value must be a valid email address.');
        }

        $this->value = $filtered;
    }

    /**
     * @param Email $email
     * @return bool
     */
    public function equals(Email $email)
    {
        return (string) $email === $this->value;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return substr(strrchr($this->value, "@"), 1);
    }

    /**
     * @return string
     */
    public function getLocalPart()
    {
        return substr($this->value, 0, strpos($this->value, '@'));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
