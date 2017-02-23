<?php
namespace Tests\Timex;
use PHPUnit\Framework\TestCase;
use Timex\Date;

/**
 * Class DateTest
 * @package Tests\Timex
 */
class DateTest extends TestCase
{
    private $date;

    public function setUp()
    {
        $this->date = new Date();
    }

    public function testValidateDate()
    {
        $date = '2017-02-21 17:36:00';
        $this->date->add($date);
        $this->assertEquals(true, $this->date->validate());
    }

    public function testValidateDateBR()
    {
        $date = '21/02/2017 17:36:00';
        $this->date->setFormat('d/m/Y H:i:s');
        $this->date->add($date);
        $this->assertEquals(true, $this->date->validate());
    }

    public function testValidateTimestamp()
    {
        $date = time();
        $this->date->isTimestamp();
        $this->date->add($date);
        $this->assertEquals(true, $this->date->validate());
    }
}
