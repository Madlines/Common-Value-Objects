<?php

namespace Madlines\Common\ValueObjects\Tests;

use Madlines\Common\ValueObjects\Email;

class EmailTest extends \PHPUnit_Framework_TestCase
{
    public function testEquals()
    {
        $email = new Email('foo@bar.com');
        $email2 = new Email('foo@bar.com');
        $email3 = new Email('foo2@bar.com');

        $this->assertTrue($email->equals($email2));
        $this->assertFalse($email->equals($email3));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEmptyValue()
    {
        new Email('');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testImproperEmailAddress()
    {
        new Email('notAnEmail');
    }

    public function testGetLocalAndDomain()
    {
        $email = new Email('foo@bar.com');
        $email2 = new Email('foo+bar.lorem@ipsum.foobar.com');

        $this->assertEquals('foo', $email->getLocalPart());
        $this->assertEquals('bar.com', $email->getDomain());

        $this->assertEquals('foo+bar.lorem', $email2->getLocalPart());
        $this->assertEquals('ipsum.foobar.com', $email2->getDomain());
    }
}
