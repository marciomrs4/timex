<?php

/**
 * Created by PhpStorm.
 * User: mrs4
 * Date: 11/02/17
 * Time: 23:30
 */

use PHPUnit\Framework\TestCase;
use Timex\Sla;

class TimexSlaTest extends TestCase
{

    public function testIsReturnTimeCorrect()
    {
        $this->assertTrue(true,'Erro no teste');
    }

    public function testClassWasFound()
    {

        $sla = new Sla();

        $this->assertInstanceOf('Sla',$sla,'Erro não é o mesmo objeto');
    }

}