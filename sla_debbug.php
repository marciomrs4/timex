<?php
/**
 * Created by PhpStorm.
 * User: mrs4
 * Date: 19/02/17
 * Time: 00:49
 */

include_once 'vendor/autoload.php';

$sla = new \Timex\Sla;

$data1 = '2017-05-01 11:00:00';
$data2 = '2017-05-01 16:00:00';
$horaInicio = '08:00';
$horaFim = '18:00';
$horaAlmoco = '12';
$sabado = '00';
$saida = 'H';

echo $sla->tempo_valido($data1,$data2,$horaInicio,$horaFim,$horaAlmoco,$sabado,$saida);