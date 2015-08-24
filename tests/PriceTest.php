<?php

namespace Madlines\Common\ValueObjects\Tests;

use Madlines\Common\ValueObjects\Price;

class PriceTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromFloatyString()
    {
        $pricePlainString = '7.93';
        $pricePlain = 7.93;

        $price = Price::fromFloat($pricePlainString);
        $price2 = Price::fromFloat($pricePlain);

        $this->assertEquals($price, $price2);
    }

    public function testCreateFromInt()
    {
        $pennies = 2730;
        $float = 27.30;

        $price = Price::fromFloat($float);
        $price2 = Price::fromInt($pennies);

        $this->assertEquals($price, $price2);
    }

    public function createFromIntWithNoIntyData()
    {
        $price = Price::fromInt('A');
        $price2 = Price::fromInt('2.50 EUR');
        $price3 = Price::fromInt('$3');

        $this->assertSame(0, $price->toPennies());
        $this->assertSame(250, $price2->toPennies());
        $this->assertSame(300, $price3->toPennies());
    }

    public function createFromFloatWithNoFloatyData()
    {
        $price = Price::fromFloat('A');
        $price2 = Price::fromFloat('2.50 EUR');
        $price3 = Price::fromFloat('$3.50');

        $this->assertSame(0, $price->toFloat());
        $this->assertSame(2.5, $price2->toFloat());
        $this->assertSame(3.5, $price3->toFloat());
    }

    public function testEquals()
    {
        $price = Price::fromInt(99);
        $price2 = Price::fromFloat(0.99);
        $price3 = Price::fromFloat(1.99);

        $this->assertTrue($price->equals($price2));
        $this->assertFalse($price->equals($price3));
    }

    public function testToFloatAndToInt()
    {
        $price = Price::fromInt(1399);
        $price2 = Price::fromFloat(13.99);
        $price3 = Price::fromInt(99);
        $price4 = Price::fromFloat(0.99);

        $this->assertSame(13.99, $price->toFloat());
        $this->assertSame(13.99, $price2->toFloat());
        $this->assertSame(0.99, $price3->toFloat());
        $this->assertSame(0.99, $price4->toFloat());

        $this->assertSame(1399, $price->toPennies());
        $this->assertSame(1399, $price2->toPennies());
        $this->assertSame(99, $price3->toPennies());
        $this->assertSame(99, $price4->toPennies());
    }

    public function testGetCurrency()
    {
        $price = Price::fromInt(1399, 'EUR');
        $price2 = Price::fromFloat(13.99, 'USD');
        $price3 = Price::fromInt(99);

        $this->assertEquals('EUR', $price->getCurrency());
        $this->assertEquals('USD', $price2->getCurrency());
        $this->assertNull($price3->getCurrency());
    }

    public function testToString()
    {
        $price = Price::fromInt(1399, 'EUR');
        $price2 = Price::fromFloat(13.99, 'USD');
        $price3 = Price::fromInt(99);

        $this->assertEquals('13.99 EUR', (string) $price);
        $this->assertEquals('13.99 USD', (string) $price2);
        $this->assertEquals('0.99', (string) $price3);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLessThanZero()
    {
        Price::fromInt(-1);
    }

    public function testAdd()
    {
        $price = Price::fromInt(399);
        $price2 = Price::fromInt(601);

        $sum = $price->add($price2);
        $this->assertEquals(1000, $sum->toPennies());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddWithDifferentCurrencies()
    {
        $price = Price::fromInt(399, 'EUR');
        $price2 = Price::fromInt(601, 'USD');

        $price->add($price2);
    }

    public function testSubtract()
    {
        $price = Price::fromInt(1000);
        $price2 = Price::fromInt(601);

        $diff = $price->subtract($price2);
        $this->assertEquals(399, $diff->toPennies());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSubtractWithDifferentCurrencies()
    {
        $price = Price::fromInt(1000, 'USD');
        $price2 = Price::fromInt(601, 'EUR');

        $price->subtract($price2);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSubtractBiggerFromSmaller()
    {
        $price = Price::fromInt(1000, 'USD');
        $price2 = Price::fromInt(601, 'USD');

        $price2->subtract($price);
    }

    public function testAddPercentage()
    {
        $price = Price::fromFloat(10.00, 'USD');

        $this->assertSame(12.30, $price->addPercentage(23)->toFloat());
        $this->assertSame(13.34, $price->addPercentage(33.37)->toFloat());
        $this->assertSame(13.34, $price->addPercentage(33.377)->toFloat());
        $this->assertSame(13.36, $price->addPercentage(33.61)->toFloat());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddPercentageWithNegativeValue()
    {
        $price = Price::fromFloat(10.00, 'USD');
        $price->addPercentage(-1);
    }

    public function testSubtractPercentage()
    {
        $price = Price::fromFloat(10.00, 'USD');

        $this->assertSame(9, $price->subtractPercentage(10)->toFloat());
        $this->assertSame(7.7, $price->subtractPercentage(23)->toFloat());
        $this->assertSame(6.66, $price->subtractPercentage(33.37)->toFloat());
        $this->assertSame(6.66, $price->subtractPercentage(33.377)->toFloat());
        $this->assertSame(6.64, $price->subtractPercentage(33.61)->toFloat());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSubtractPercentageWithNegativeValue()
    {
        $price = Price::fromFloat(10.00, 'USD');
        $price->subtractPercentage(-1);
    }
}
