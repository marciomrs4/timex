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
        $date = new \DateTime('now');
        $dateSystem = $date->format('Y-m-d H:i:s');//passthru('date');
        $datePhp = date('Y-m-d H:i:s');

        $this->assertEquals($dateSystem,$datePhp,'Erro no teste');
    }

    public function testClassWasFound()
    {

        $this->assertInstanceOf(Sla::class,$this->sla,'Erro não é o mesmo objeto');
    }

    public function testCalculateTimeFirstCenario()
    {
        $data1 = '2016-01-01 10:00:00';
        $data2 = '2016-01-01 13:00:00';
        $horaInicio = '08:00';
        $horaFim = '18:00';
        $meiodia = '12:00';
        $sabado = '00';
        $saida = 'H';

        $tempo = $this->sla->tempo_valido($data1,$data2,$horaInicio,$horaFim,$meiodia,$sabado,$saida);

        $this->assertEquals($tempo,'02:00:00');
    }

    public function testCalculateTimeSecundCenario()
    {
        $data1 = '2017-02-06 10:00:00';
        $data2 = '2017-02-07 13:00:00';
        $horaInicio = '08:00';
        $horaFim = '18:00';
        $meiodia = '12:00';
        $sabado = '00';
        $saida = 'H';

        $tempo = $this->sla->tempo_valido($data1,$data2,$horaInicio,$horaFim,$meiodia,$sabado,$saida);

        $this->assertEquals($tempo,'11:00:00');
    }


    public function testCalculateTimeThirdCenario()
    {
        $data1 = '2017-02-06 10:00:00';
        $data2 = '2017-02-08 13:00:00';
        $horaInicio = '08:00';
        $horaFim = '18:00';
        $meiodia = '12:00';
        $sabado = '00';
        $saida = 'H';

        $tempo = $this->sla->tempo_valido($data1,$data2,$horaInicio,$horaFim,$meiodia,$sabado,$saida);

        $this->assertEquals($tempo,'20:00:00');
    }

    public function testCalculateTimeForthCenario()
    {
        $data1 = '2017-02-06 09:35:00';
        $data2 = '2017-02-06 17:00:00';
        $horaInicio = '08:00';
        $horaFim = '18:00';
        $meiodia = '12:00';
        $sabado = '00';
        $saida = 'H';

        $esperado = '06:25:00';

        $tempo = $this->sla->tempo_valido($data1,$data2,$horaInicio,$horaFim,$meiodia,$sabado,$saida);

        $this->assertEquals($tempo,$esperado,"Erro no teste: Informado: {$tempo} Esperado: {$esperado} ");
    }

    public function testCalculateTimeFifthCenario()
    {
        $data1 = '2017-02-06 08:00:00';
        $data2 = '2017-02-06 18:00:00';
        $horaInicio = '07:00';
        $horaFim = '18:00';
        $meiodia = '12:00';
        $sabado = '00';
        $saida = 'H';

        $esperado = '09:00:00';

        $tempo = $this->sla->tempo_valido($data1,$data2,$horaInicio,$horaFim,$meiodia,$sabado,$saida);

        $this->assertEquals($tempo,$esperado,"Erro no teste: Informado: {$tempo} Esperado: {$esperado} ");
    }

    public function testCalculateTimeOpenTickeOnSaturdayCenario()
    {
        $data1 = '2017-02-04 09:35:23';
        $data2 = '2017-02-04 13:00:00';
        $horaInicio = '08:00';
        $horaFim = '18:00';
        $meiodia = '12:00';
        $sabado = '04';
        $saida = 'H';

        $tempo = $this->sla->tempo_valido($data1,$data2,$horaInicio,$horaFim,$meiodia,$sabado,$saida);

        $this->assertEquals($tempo,'02:24:37');
    }


    public function testCalculateTimeIncludeOneWeekendCenario()
    {
        $data1 = '2017-02-10 10:00:00';
        $data2 = '2017-02-13 14:00:00';
        $horaInicio = '08:00';
        $horaFim = '18:00';
        $meiodia = '12:00';
        $sabado = '04';
        $saida = 'H';

        $esperado = '16:00:00';

        $tempo = $this->sla->tempo_valido($data1,$data2,$horaInicio,$horaFim,$meiodia,$sabado,$saida);

        $this->assertEquals($tempo,$esperado,"Erro no teste: Informado: {$tempo} Esperado: {$esperado} ");
    }

    public function testCalculateTimeIncludeTwoWeekendCenario()
    {
        $data1 = '2017-02-10 10:00:00';
        $data2 = '2017-02-20 14:00:00';
        $horaInicio = '08:00';
        $horaFim = '18:00';
        $meiodia = '12:00';
        $sabado = '04';
        $saida = 'H';

        $esperado = '66:00:00';

        $tempo = $this->sla->tempo_valido($data1,$data2,$horaInicio,$horaFim,$meiodia,$sabado,$saida);

        $this->assertEquals($tempo,$esperado,"Erro no teste: Informado: {$tempo} Esperado: {$esperado} ");
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