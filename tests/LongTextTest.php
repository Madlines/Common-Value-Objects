<?php

namespace Madlines\Common\ValueObjects\Tests;

use Madlines\Common\ValueObjects\LongText;

class LongTextTest extends \PHPUnit_Framework_TestCase
{
    public function testEquals()
    {
        $longText = new LongText('Some text');
        $longText2 = new LongText('Some text');
        $longText3 = new LongText('Some different text');

        $this->assertTrue($longText->equals($longText2));
        $this->assertFalse($longText->equals($longText3));
    }

    public function testToString()
    {
        $longText = new LongText('Some text');
        $this->assertEquals('Some text', $longText);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEmpty()
    {
        new LongText('');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testTooLong()
    {
        $string = str_repeat('x', LongText::MAX_LENGTH + 1);
        new LongText($string);
    }
}
