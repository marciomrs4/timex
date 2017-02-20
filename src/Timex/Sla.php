<?php

namespace Timex;

/**
 * Class Sla
 * @package Timex
 * @autor Márcio Ramos
 * @name Sla
 * @license MIT
 * @version 2.0.0
 * @since 09/02/2017
 * @umacoisabla coisablaadd
 */
class Sla
{
    public $data1; //Primeira parâmetro de data
    public $data2; //Segundo parâmetro de data
    public $forma;
    public $dif_sec;
    public $dif_date;
    public $diff;
    public $dDomingo;
    public $tValido;
    public $dFullAll;

    /**
     * @param $data
     * @return //Retorna saída no formado AAAA-MM-DD HH:mm:SS
     * @throws none
     * @name formatDate
     * @author Márcio Ramos <marciomrs4@hotmail.com>
     * @version 2.0.0
     * @since 19/02/2017

     */
    public function formatDate ($data)
    {
        $dateFormat = new \DateTime($data);
        return $dateFormat->format('Y-m-d H:i:s');
    }

    public function setData1 ($data)
    {
        $this->data1 = $this->formatDate($data);
    }

    public function setData2 ($data)
    {
        $this->data2 = $this->formatDate($data);
    }

    public function getData1 ()
    {
        print $this->data1;
    }

    public function getData2 ()
    {
        print $this->data2;
    }

    public function secToHour($sec)
    { //Recebe valor formatado em segundos (valor inteiro) e retorna em formato de hora
        $h = intval($sec/3600);
        $sec -= $h*3600;
        $m = intval($sec/60);
        $sec -= $m*60;
        if(strlen($h) == 1){$h = "0".$h;}; //Coloca um zero antes
        if(strlen($m) == 1){$m = "0".$m;}; //Coloca um zero antes
        if(strlen($sec) == 1){$sec = "0".$sec;}; //Coloca um zero antes
        $v = $h.":".$m.":".$sec;
        return $v;
    }


    public function hourToSec($hour)
    {
        $s = 0;

        if (preg_match("/([0-9]{1,}):([0-9]{1,2}):([0-9]{1,2})/", $hour, $sep)) {

            $s= $sep[3];
            $s+=$sep[2]*60;
            $s+=$sep[1]*3600;

        }
        return $s;
    }



    public function somadata($dias,$datahoje)
    { //Formato americano de data com hora
        // Desmembra Data -------------------------------------------------------------
        //FORMATO VÃ�LIDO: ANO-MES-DIA


        if(preg_match("/([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/", $datahoje, $sep)){

            $dia = $sep[3];
            $mes = $sep[2];
            $ano = $sep[1];
            $time = $sep[4].":".$sep[5].":".$sep[6];

        } else {
            echo "<b>Invalid date format (valid format: aaaa-mm-dd) - $datahoje</b><br>";
        }
        $i = $dias;
        for($i = 0;$i<$dias;$i++){
            if ($mes == "01" || $mes == "03" || $mes == "05" || $mes == "07" || $mes == "08" || $mes == "10" || $mes == "12"){
                if($mes == 12 && $dia == 31){
                    $mes = 01;
                    $ano++;
                    $dia = 00;
                }
                if($dia == 31 && $mes != 12){
                    $mes++;
                    $dia = 00;
                }
            }//fecha if geral
            if($mes == "04" || $mes == "06" || $mes == "09" || $mes == "11"){
                if($dia == 30){
                    $dia = 00;
                    $mes++;
                }
            }//fecha if geral
            if($mes == "02"){
                if($ano % 4 == 0 && $ano % 100 != 0){ //ano bissexto
                    if($dia == 29){
                        $dia = 00;
                        $mes++;
                    }
                }
                else{
                    if($dia == 28){
                        $dia = 00;
                        $mes++;
                    }
                }
            }//FECHA IF DO MES 2
            $dia++;
        }//fecha o for()
        // Confirma SaÃ­da de 2 dÃ­gitos ------------------------------------------------
        if(strlen($dia) == 1){$dia = "0".$dia;}; //Coloca um zero antes
        if(strlen($mes) == 1){$mes = "0".$mes;};
        // Monta SaÃ­da ----------------------------------------------------------------
        $nova_data = $ano."-".$mes."-".$dia." ".$time;
        //print $nova_data;
        return $nova_data;
    }//fecha a funÃ§Ã¢o data

    public function fullDays($data1,$data2)
    {
        $fullDays = false;
        $fisrt_is_minor = false;
        $sep1 = explode(" ",$this->somadata(2,$data1));
        $sep2 = explode(" ",$data2);
        if ($sep1['0'] <= $sep2['0']) {
            $fullDays = true;
        } else
            $fullDays = false;
        $sep1['1'] = $this->hourToSec($sep1['1']);
        $sep2['1'] = $this->hourToSec($sep2['1']);
        if ($sep1['1']<=$sep2['1']){
            $first_is_minor = true;
            //print "<br>O hora de início é menor!<br>";
        } else {
            $first_is_minor = false;
            //print "<br>O hora de início é maior!<br>";
        }
        $this->dFullAll = array("fullDays"=>$fullDays, "first_is_minor"=>$first_is_minor);
        //return $fullDays;
        return $this->dFullAll;
    }

    //Parâmetros em segundos - data1: data mais antiga - data2: data mais recente (SEMPRE NO FORMATO AMERICANO!!!
    public function diff_time($data1,$data2)
    {
        $s = strtotime($data2)-strtotime($data1);
        $secs = $s;
        $emHora=$this->secToHour($secs);
        $sep = explode(":",$emHora);
        $hFull = $sep[0];
        $dFullOK = 0; //criado em 14-05-08
        $d = intval($s/86400);
        $s -= $d*86400;
        $h = intval($s/3600);
        $s -= $h*3600;
        $m = intval($s/60);
        $s -= $m*60;
        if(strlen($h) == 1){$h = "0".$h;}; //Coloca um zero antes
        if(strlen($m) == 1){$m = "0".$m;}; //Coloca um zero antes
        if(strlen($s) == 1){$s = "0".$s;}; //Coloca um zero antes
        $v = $d." dias ".$h.":".$m.":".$s;
        $min = $m;
        $dias = $d;
        //ALTERAÇÃO PARA AJUSTAR O TOTAL DE DIAS CHEIOS - 14-15-08
        //if ($this->fullDays($data1,$data2)){
        $this->fullDays($data1,$data2);
        ## CONTROLE PARA IDENTIFICAR DIAS CHEIOS NO INTERVALO
        if ($this->dFullAll['fullDays']){
            if ($dias>1) {
                if ($this->dFullAll['first_is_minor']) {
                    $hFull>24?$dFullOK=$dias-1:$dFullOK=$dias;
                } else {
                    $dFullOK=$dias;
                }
            } else
                $dFullOK=$dias;
        } else {
            $dFullOK = 0;
        }
        $horas = $h;
        $minutos = $m;
        $segundos = $s;
        $dias *=86400; //Dia de 24 horas
        $horas *=3600;
        $minutos *=60;
        $segundos +=$dias+$horas+$minutos;
        $h = intval($segundos/3600);
        $m = intval($segundos/60);
        //Alterado em 14-05-08
        //$this->diff = array("dFull"=>$d, "hFull"=>$hFull, "mFull"=>$m, "sFull"=>$secs, "tHoras"=>$emHora, "tDias"=>$v);
        $this->diff = array("dFullTotal"=>$d, "dFull"=>$dFullOK, "hFull"=>$hFull, "mFull"=>$m, "sFull"=>$secs, "tHoras"=>$emHora, "tDias"=>$v);
        return $this->diff;
    }

    public function diasDomingo($data1,$data2)
    {//Retorna a quantidade de Domingos do período
        $this->diff_time($data1, $data2);
        $dias_diff = $this->diff["dFullTotal"];
        //print "<br>Funcao diasDomingo()";
        //print "<br>dias_diff: ".$this->diff["dFullTotal"]."<br><br>";
        $domingo=0;
        if ($dias_diff>=1) {
            $temp = $data1;
            //for ($i=1;$i<=$dias_diff; $i++){
            for ($i=0;$i<=$dias_diff; $i++){
                $temp = $this->somadata($i,$data1);
                $dias[$i]= date("l",strtotime($temp));
                if ($dias[$i]=="Sunday") {
                    $domingo++;
                }
            }
            //$validos = $dias_diff-$domingo;
        }// else $validos=$dias_diff;
        $this->dDomingo=$domingo;
        /*Warning: Caso não tenha o retorno Isso impacta no calculo do final de semana*/
        return $domingo;
    }
    /**
     * @todo Retorna o tempo vÃ¡lido em horas ou segundos entre duas datas descontando finais de semana e feriados.
     * TambÃ©m desconta os horÃ¡rios fora da carga horÃ¡ria de cada Ã¡rea.
     * Colocar parâmetro para identificar o tempo de intervalo
     * PARAMETROS:
     * @param $hora_ini: inicio da jornada
     * @param $hora_fim: final da jornada
     * @param $meio_dia: intervalo
     * @param $sabado: total de horas trabalhadas nos sábados
     * @param $saida: formato da saída da função, se será em horas ou segundos
     * @return $horautil
     */
    public function tempo_valido($data1,$data2,$hora_ini,$hora_fim,$meio_dia,$sabado,$saida)
    {
        set_time_limit(300);
        $noData = false;
        if (empty($data1)|| empty($data2)) {
            $noData = true;
        } else {
            $data1 = $this->formatDate($data1);
            $data2 = $this->formatDate($data2);
            //Inverte a ordem das datas se os parÃ¢metros estiverem invertidos!!
            if ($data1>$data2) {
                $temp = $data1;
                $data1 = $data2;
                $data2 = $temp;
            }
            /*-------------------------------------------------------------------------------------------*/
            $data1_aux= explode("-",date("Y-m-d-H-i-s",strtotime($data1))); //EXTRAINDO OS ELEMENTOS DA DATA
            $data2_aux= explode("-",date("Y-m-d-H-i-s",strtotime($data2)));
            /*-------------------------------------------------------------------------------------------*/
            if ($data1_aux['3']<$hora_ini){ //ABERTURA COMPARADA A HORA DE INÍCIO
                $data1_aux['3'] = $hora_ini;
                $data1_aux['4'] = "00";
                $data1_aux['5'] = "00";
                $data1 = $data1_aux['0']."-".$data1_aux['1']."-".$data1_aux['2']." ".$data1_aux['3'].":".$data1_aux['4'].":".$data1_aux['5'];
            } else
                if ($data1_aux['3']>=$hora_fim){ //ABERTURA COMPARADA A HORA DE FIM
                    $data1_aux['3'] = $hora_fim;
                    $data1_aux['4'] = "00";
                    $data1_aux['5'] = "00";
                    $data1 = $data1_aux['0']."-".$data1_aux['1']."-".$data1_aux['2']." ".$data1_aux['3'].":".$data1_aux['4'].":".$data1_aux['5'];
                } else
                    if (($data1_aux['3']>=($meio_dia-1)) && ($data1_aux['3'] <$meio_dia) && $meio_dia!=0) { //ABERTURA COMPARADA A HORA MEIO DIA
                        $data1_aux['3'] = $meio_dia;
                        $data1_aux['4'] = "00";
                        $data1_aux['5'] = "00";
                        $data1 = $data1_aux['0']."-".$data1_aux['1']."-".$data1_aux['2']." ".$data1_aux['3'].":".$data1_aux['4'].":".$data1_aux['5'];
                    }
            if ($data2_aux['3']>=$hora_fim){//HORA FECHAMENTO COMPARADA A HORA FIM
                $data2_aux['3'] = $hora_fim;
                $data2_aux['4'] = "00";
                $data2_aux['5'] = "00";
                $data2 = $data2_aux['0']."-".$data2_aux['1']."-".$data2_aux['2']." ".$data2_aux['3'].":".$data2_aux['4'].":".$data2_aux['5'];
            } else
                if ($data2_aux['3']<$hora_ini){//HORA FECHAMENTO COMPARADA A HORA INI
                    $data2_aux['3'] = $hora_ini;
                    $data2_aux['4'] = "00";
                    $data2_aux['5'] = "00";
                    $data2 = $data2_aux['0']."-".$data2_aux['1']."-".$data2_aux['2']." ".$data2_aux['3'].":".$data2_aux['4'].":".$data2_aux['5'];
                } else
                    if (($data2_aux['3']>=($meio_dia-1)) && ($data2_aux['3'] <$meio_dia) && $meio_dia!=0) { //FECHAMENTO COMPARADA A HORA MEIO DIA
                        #CONTROLE PARA IDENTIFICAR CHAMADOS ABERTOS E CONSULTADOS NO INTERVALO (DENTRO DO MESMO DIA)
                        $abDiasMesAno = $data1_aux['0']."-".$data1_aux['1']."-".$data1_aux['2'];
                        $feDiasMesAno = $data2_aux['0']."-".$data2_aux['1']."-".$data2_aux['2'];
                        if ($abDiasMesAno == $feDiasMesAno && $data1_aux['3'] == $meio_dia) {
                            $data2_aux['3'] = $meio_dia;
                        } else {
                            $data2_aux['3'] = $meio_dia-1;
                        }
                        $data2_aux['4'] = "00";
                        $data2_aux['5'] = "00";
                        $data2 = $data2_aux['0']."-".$data2_aux['1']."-".$data2_aux['2']." ".$data2_aux['3'].":".$data2_aux['4'].":".$data2_aux['5'];
                    }
            //Verifica se existem feriados nos dias uteis cadastrados na tabela feriados
            //	entre as duas datas (também verifica os feriados permanentes);
            $sql = "SELECT data_feriado AS dia_semana, fixo_feriado as permanente ".
                "\nFROM feriados ".
                "\nWHERE ".
                "\n\t(data_feriado BETWEEN '".$data1."' AND '".$data2."' AND date_format( data_feriado, '%w' ) NOT IN ( 0, 6 ))".
                "\n\t\tOR ( fixo_feriado = 1 AND ".
                "\n\t\t\tdate_format(data_feriado,'%m-%d' ) BETWEEN date_format('".$data1."' , '%m-%d' ) ".
                "\n\t\t\tAND date_format('".$data2."' , '%m-%d' ) ".
                "\n\t\t\tAND CONCAT_WS('-','".$data2_aux['0']."', date_format(data_feriado , '%m-%d' )) BETWEEN  '".$data1."' AND '".$data2."' ".
                "\n\t\t\tAND date_format( CONCAT_WS('-','".$data2_aux['0']."', date_format(data_feriado , '%m-%d' )) , '%w' ) NOT IN ( 0, 6 ) ".
                "\n\t\t ) ".
                "\n\tGROUP BY date_format(data_feriado,'%m-%d' )";
            //$resultado = mysql_query($sql);
            $feriados = 0; // mysql_num_rows($resultado);//Em dias Ãºteis
            //Verifica os feriados que cairam em Domingo;
            $sql2 = "SELECT data_feriado AS dia_semana, fixo_feriado as permanente ".
                "\nFROM feriados ".
                "\nWHERE ".
                "\n\t(data_feriado BETWEEN '".$data1."' AND '".$data2."' AND date_format( data_feriado, '%w' ) IN ( 0 ))".
                "\n\t\tOR ( fixo_feriado = 1 AND ".
                "\n\t\t\tdate_format(data_feriado,'%m-%d' ) BETWEEN date_format('".$data1."' , '%m-%d' ) ".
                "\n\t\t\tAND date_format('".$data2."' , '%m-%d' ) ".
                "\n\t\t\tAND CONCAT_WS('-','".$data2_aux['0']."', date_format(data_feriado , '%m-%d' )) BETWEEN  '".$data1."' AND '".$data2."' ".
                "\n\t\t\tAND date_format( CONCAT_WS('-','".$data2_aux['0']."', date_format(data_feriado , '%m-%d' )) , '%w' ) IN ( 0 ) ".
                "\n\t\t ) ".
                "\n\tGROUP BY date_format(data_feriado,'%m-%d' )";
            //$resultado2 = mysql_query($sql2);
            $feriados_domingo = 0; // mysql_num_rows($resultado2);
            //Verifica os feriados que cairam em SÃ¡bado;
            $sql3 = "SELECT data_feriado AS dia_semana, fixo_feriado as permanente ".
                "\nFROM feriados ".
                "\nWHERE ".
                "\n\t(data_feriado BETWEEN '".$data1."' AND '".$data2."' AND date_format( data_feriado, '%w' ) IN ( 6 ))".
                "\n\t\tOR ( fixo_feriado = 1 AND ".
                "\n\t\t\tdate_format(data_feriado,'%m-%d' ) BETWEEN date_format('".$data1."' , '%m-%d' ) ".
                "\n\t\t\tAND date_format('".$data2."' , '%m-%d' ) ".
                "\n\t\t\tAND CONCAT_WS('-','".$data2_aux['0']."', date_format(data_feriado , '%m-%d' )) BETWEEN  '".$data1."' AND '".$data2."' ".
                "\n\t\t\tAND date_format( CONCAT_WS('-','".$data2_aux['0']."', date_format(data_feriado , '%m-%d' )) , '%w' ) IN ( 6 ) ".
                "\n\t\t ) ".
                "\n\tGROUP BY date_format(data_feriado,'%m-%d' )";
            //$resultado3 = mysql_query($sql3);
            $feriados_sabado = 0; //mysql_num_rows($resultado3);
            $feriados+= $feriados_domingo+$feriados_sabado;
            $invalidos=0; //Inicializando o numero de horas invÃ¡lidas do intervalo!!
            //$diffSegundos = diff_em_segundos($data1,$data2); //DiferenÃ§a total em segundos entre as duas datas!
            $this->diff_time($data1,$data2);
            $diffSegundos = $this->diff["sFull"];
            $dias_cheios = $this->diff["dFull"];
            ##
            $data1_aux= explode("-",date("d-m-Y-H-i-s",strtotime($data1))); //EXTRAINDO OS ELEMENTOS DA DATA
            $data2_aux= explode("-",date("d-m-Y-H-i-s",strtotime($data2)));
            $dia_abert = $data1_aux[0].$data1_aux[1].$data1_aux[2];
            $dia_fech = $data2_aux[0].$data2_aux[1].$data2_aux[2];
            //$t_horas = $horas_completas[0]; //DiferenÃ§a em horas completas!
            $t_horas = $this->diff["hFull"];
            $hora_1 = $data1_aux[3];
            $hora_2 = $data2_aux[3];
            if ($t_horas>=1) {
                //Horas invalidas dos dias cheios
                if ($dias_cheios>=1) {//>=
                    for ($i=0;$i<24; $i++){
                        if ($i>$hora_fim || $i<=$hora_ini || $i==$meio_dia) {
                            $invalidos++;
                        }
                    }
                    $invalidos*=$dias_cheios;
                }
                if ($dia_abert!=$dia_fech) {
                    //Retirando as horas invalidas do primeiro dia
                    for ($i=$hora_1+1;$i<=24; $i++){
                        if ($i>$hora_fim || $i <=$hora_ini || $i==$meio_dia) {
                            $invalidos++;
                        }
                    }
                    //Retirando as horas invÃ¡lidas do Ãºltimo dia
                    for ($i=1; $i<$hora_2+1; $i++){
                        if ($i>$hora_fim || $i <=$hora_ini || $i==$meio_dia) {
                            $invalidos++;
                        }
                    }
                } else { //Verifica as horas invÃ¡lidas no perÃ­odo dentro do mesmo dia!!
                    for ($i=$hora_1+1;$i<=$hora_2;$i++){
                        if ($i>$hora_fim || $i <=$hora_ini || $i==$meio_dia) {
                            $invalidos++;
                        }
                    }
                }
            }
            $horas_invalidas_segundos = $invalidos*3600; //Total de horas invalidas em segundos
            //$domingos = dias_invalidos($data1,$data2)-$feriados_domingo;##### //Quantos Domingos existem no perÃ­odo
            $domingos = $this->diasDomingo($data1,$data2)-$feriados_domingo;
            $sabados = $this->diasDomingo($data1,$data2)-$feriados_sabado;
            $domingo = $hora_fim - $hora_ini; //PerÃ­odo de horas normalmente trabalhadas durante a semana que precisam ser...
            //.. descontadas dos Domingos!!
            if ($meio_dia > $hora_ini && $meio_dia < $hora_fim) { //Se existe intervalo (almoÃ§o) na carga horÃ¡ria!
                $domingo--;
            }
            $domingo*=3600; //Transformo em segundos
            $sabado*=3600; //Transformo em segundos
            $feriados*=$domingo; //A quantidade de horas invÃ¡lidas de um feriado Ã© igual Ã s horas de um Domingo!
            $sabado = $domingo-$sabado; //A quantidade de horas invÃ¡lidas do SÃ¡bado Ã© iqual Ã s horas do Domingo menos..
            // ... as horas trabalhadas no sÃ¡bado.
            $final_de_semana = (($sabado*$sabados)+($domingo*$domingos)+$feriados); //Total de horas invÃ¡lidas em todo o perÃ­odo!!
            $total_tempo_valido = $diffSegundos-($horas_invalidas_segundos+$final_de_semana);
            //$total_tempo_valido_horas = segundos_em_horas($total_tempo_valido);//$total_tempo_valido_horas;
            $total_tempo_valido_horas = $this->secToHour($total_tempo_valido);
            $auxiliar = explode(":",$total_tempo_valido_horas);
            if(strlen($auxiliar[0]) == 1){$auxiliar[0] = "0".$auxiliar[0];}; //Coloca um zero antes
            if(strlen($auxiliar[1]) == 1){$auxiliar[1] = "0".$auxiliar[1];}; //Coloca um zero antes
            if(strlen($auxiliar[2]) == 1){$auxiliar[2] = "0".$auxiliar[2];}; //Coloca um zero antes
            if ($auxiliar['1']<0) $auxiliar['1']="00";
            if ($auxiliar['2']<0) $auxiliar['2']="00";
        }
        if ($noData) {
            $msg = "Data vazia!";
            return $msg;
        } else
            if ($saida=="S") {
                $this->diff["hValido"]=$auxiliar[0];
                $this->diff["sValido"]=$total_tempo_valido;
                $this->tValido=$total_tempo_valido;
                return $total_tempo_valido;
            } else
                if ($saida=="H") {
                    $this->diff["hValido"]=$auxiliar[0];
                    $this->diff["sValido"]=$total_tempo_valido;
                    $this->tValido=$auxiliar[0].":".$auxiliar[1].":".$auxiliar[2];
                    return  $auxiliar[0].":".$auxiliar[1].":".$auxiliar[2];
                }
    }

}
?>