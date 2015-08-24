<?php

namespace Madlines\Common\ValueObjects\Tests;

use Madlines\Common\ValueObjects\Uuid;

class UuidTest extends \PHPUnit_Framework_TestCase
{
    public function testEquals()
    {
        $uuid = new Uuid('00000000-0000-0000-0000-000000000000');
        $uuid2 = new Uuid('00000000-0000-0000-0000-000000000000');
        $uuid3 = new Uuid('00000000-0000-0000-0000-000000000001');

        $this->assertTrue($uuid->equals($uuid2));
        $this->assertFalse($uuid->equals($uuid3));
    }

    public function testToString()
    {
        $uuid = new Uuid('00000000-0000-0000-0000-000000000000');
        $this->assertEquals(
            '00000000-0000-0000-0000-000000000000',
            (string) $uuid
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidUuid()
    {
        new Uuid('not-proper-uuid');
    }
}
