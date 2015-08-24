<?php

namespace Madlines\Common\ValueObjects\Tests;

use Madlines\Common\ValueObjects\ShortString;

class ShortStringTest extends \PHPUnit_Framework_TestCase
{
    public function testEquals()
    {
        $longText = new ShortString('Some text');
        $longText2 = new ShortString('Some text');
        $longText3 = new ShortString('Some different text');

        $this->assertTrue($longText->equals($longText2));
        $this->assertFalse($longText->equals($longText3));
    }

    public function testToString()
    {
        $longText = new ShortString('Some text');
        $this->assertEquals('Some text', $longText);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEmpty()
    {
        new ShortString('');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testTooLong()
    {
        $string = str_repeat('x', ShortString::MAX_LENGTH + 1);
        new ShortString($string);
    }
}
