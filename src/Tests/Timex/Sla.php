<?php

/**
 * Created by PhpStorm.
 * User: mrs4
 * Date: 11/02/17
 * Time: 23:30
 */

namespace Tests\Timex;

use PHPUnit\Framework\TestCase;

use Timex\Sla;

class SlaTest extends TestCase
{

    private $sla;

    public function setUp()
    {
        $this->sla = new Sla();
    }

    public function testIsReturnTimeCorrect()
    {
        $this->assertTrue(true,'Erro no teste');
    }

    public function testClassWasFound()
    {

        $this->assertInstanceOf(Sla::class,$this->sla,'Erro não é o mesmo objeto');
    }

    public function testCalculateTime()
    {
        $data1 = '2017-01-01 12:00:00';
        $data2 = '2017-01-01 14:00:00';
        $horaInicio = '08:00';
        $horaFim = '18:00';
        $meiodia = '12:00';
        $sabado = '00';
        $saida = 'H';

        $tempo = $this->sla->tempo_valido($data1,$data2,$horaInicio,$horaFim,$meiodia,$sabado,$saida);

        $this->assertEquals($tempo,'02:00:00');
    }

    public function testValidateCorretDate()
    {
        $dataEntrada = '2017-01-01 12:00:00';
        $dataComparacao = '01-01-2017 12:00:00';

        $result = new \DateTime($dataEntrada);

        $this->assertEquals($result->format('d-m-Y H:i:s'),$dataComparacao);

        $this->assertEquals($result->format('Y-m-d H:i:s'),$dataEntrada);

    }

}