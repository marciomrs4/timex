<?php
/**
 * Created by PhpStorm.
 * User: mrs4
 * Date: 19/02/17
 * Time: 00:49
 */

include_once 'vendor/autoload.php';

error_reporting('E_ALL');

$sla = new \Timex\Sla;

$data1 = '2017-05-01 11:30:00';
$data2 = '2017-05-01 14:00:00';
$horaInicio = '08';
$horaFim = '18';
$horaAlmoco = '12';
$sabado = '00';
$saida = 'H';

$output = $sla->tempo_valido($data1,$data2,$horaInicio,$horaFim,$horaAlmoco,$sabado,$saida);

echo $output,PHP_EOL;;