<?php

namespace Madlines\Common\ValueObjects;

class Uuid
{
    /**
     ** Regular expression pattern for matching a valid UUID of any variant.
     **/
    const VALID_PATTERN = '/^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$/';

    /**
     * @var string
     */
    protected $uuidString;

    /**
     * @param string $uuidString
     */
    public function __construct($uuidString)
    {
        if (!preg_match(self::VALID_PATTERN, $uuidString)) {
            throw new \InvalidArgumentException($uuidString . ' is not valid UUID');
        }

        $this->uuidString = $uuidString;
    }

    /**
     * @param Uuid $uuid
     * @return bool
     */
    public function equals(Uuid $uuid)
    {
        return (string) $uuid === $this->uuidString;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->uuidString;
    }
}
