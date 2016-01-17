<?php
    // codificação utf-8
    class DataHelper{
        private static $objInstance;
               
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new DataHelper();                
            }
            
            return self::$objInstance;
        }
        
        public function getDiaAtualSemana($strDataAAAAMMDD){
            // $strDataAAAAMMDD vem no formato AAAA-MM-DD            
            $arrStrData = explode("-", $strDataAAAAMMDD);
            
            $intAno = $arrStrData[0]; 
            $intMes = $arrStrData[1];
            $intDia = $arrStrData[2];
                     
            $intDiaSemana = date("w", mktime(0, 0, 0, $intMes, $intDia, $intAno));            
            $strDiaSemana = "";
            $strMes       = "";
                        
            switch($intDiaSemana) {
                case"0": $strDiaSemana = "Domingo"; break;
                case"1": $strDiaSemana = "Segunda-Feira"; break;
                case"2": $strDiaSemana = "Ter&ccedil;a-Feira"; break;
                case"3": $strDiaSemana = "Quarta-Feira"; break;
                case"4": $strDiaSemana = "Quinta-Feira"; break;
                case"5": $strDiaSemana = "Sexta-Feira"; break;
                case"6": $strDiaSemana = "S&aacute;bado"; break;
            }

            switch ($intMes){
                case "01": $strMes = "Janeiro"; break;
                case "02": $strMes = "Fevereiro"; break;
                case "03": $strMes = "Mar&ccedil;o"; break;
                case "04": $strMes = "Abril"; break;
                case "05": $strMes = "Maio"; break;
                case "06": $strMes = "Junho"; break;
                case "07": $strMes = "Julho"; break;
                case "08": $strMes = "Agosto"; break;
                case "09": $strMes = "Setembro"; break;
                case "10": $strMes = "Outubro"; break;
                case "11": $strMes = "Novembro"; break;
                case "12": $strMes = "Dezembro"; break;
            }
            
            return $strDiaSemana.", ".$intDia." de ".$strMes." de ".$intAno;
        }
        
        public function converterDataBancoParaDataUsuario($strData){
            if($strData != ""){
                if($strData != "0000-00-00"){
                    if (strpos($strData, " ") !== false) {
                        $arrStrDataHora = explode(" ", $strData);
                        $arrStrData = explode("-", $arrStrDataHora[0]);
                        $arrStrHora = explode(":", $arrStrDataHora[1]);
                        return $arrStrData[2]."/".$arrStrData[1]."/".$arrStrData[0]." ".$arrStrHora[0].":".$arrStrHora[1].":".$arrStrHora[2];
                    } else {
                        if (strpos($strData, "-") !== false) {
                            $arrStrData = explode("-", $strData);
                            return $arrStrData[2]."/".$arrStrData[1]."/".$arrStrData[0]; 
                        } else {
                            $arrStrData = str_split($strData);
                            return $arrStrData[6].$arrStrData[7]."/".$arrStrData[4].$arrStrData[5]."/".$arrStrData[0].$arrStrData[1].$arrStrData[2].$arrStrData[3]; 
                        }
                    }
                }
            }
            return "";
        }
        
        public function converterDataUsuarioParaDataBanco($strData){
            if($strData != ""){
                if (strpos($strData, " ") !== false) {
                    $arrStrDataHora = explode(" ", $strData);
                    $arrStrData = explode("/", $arrStrDataHora[0]);
                    $arrStrHora = explode(":", $arrStrDataHora[1]);
                    return $arrStrData[2]."-".$arrStrData[1]."-".$arrStrData[0]." ".$arrStrHora[0].":".$arrStrHora[1].":".$arrStrHora[2];
                } else {
                    $arrStrData = explode("/", $strData);
                    return $arrStrData[2]."-".$arrStrData[1]."-".$arrStrData[0];
                }        
            }
        }
        
        public function getDataSimplificada($strDataAAAAMMDDHHMMSS, $boolExibirHora = true){
            // $strDataAAAAMMDDHHMMSS vem no formato AAAA-MM-DD HH:MM:SS           
            $arrStrDataHora = explode(" ", $strDataAAAAMMDDHHMMSS);
            $arrStrData = explode("-", $arrStrDataHora[0]);
            
            if($boolExibirHora){
                $arrStrHora = explode(":", $arrStrDataHora[1]);
                $strHora    = $arrStrHora[0].":".$arrStrHora[1];
            }
            
            // $intAno = $arrStrData[0]; 
            $intMes = $arrStrData[1];   
            $intDia = $arrStrData[2];
            $strMes = "";
            
            switch ($intMes){
                case "01": $strMes = "JAN"; break;
                case "02": $strMes = "FEV"; break;
                case "03": $strMes = "MAR"; break;
                case "04": $strMes = "ABR"; break;
                case "05": $strMes = "MAI"; break;
                case "06": $strMes = "JUN"; break;
                case "07": $strMes = "JUL"; break;
                case "08": $strMes = "AGO"; break;
                case "09": $strMes = "SET"; break;
                case "10": $strMes = "OUT"; break;
                case "11": $strMes = "NOV"; break;
                case "12": $strMes = "DEZ"; break;
            }
            
            $strRetorno = $intDia." ".$strMes;
            
            if($boolExibirHora){
                $strRetorno .= " ÀS ".$strHora;
            }
            
            return $strRetorno;
        }
        
        public function getMesSimplificado($strMes){
            switch ($strMes){
                case "1": $strMes  = "JAN"; break;
                case "2": $strMes  = "FEV"; break;
                case "3": $strMes  = "MAR"; break;
                case "4": $strMes  = "ABR"; break;
                case "5": $strMes  = "MAI"; break;
                case "6": $strMes  = "JUN"; break;
                case "7": $strMes  = "JUL"; break;
                case "8": $strMes  = "AGO"; break;
                case "9": $strMes  = "SET"; break;
                case "10": $strMes = "OUT"; break;
                case "11": $strMes = "NOV"; break;
                case "12": $strMes = "DEZ"; break;
            }            
            return $strMes;
        }

        //echo diferencaDatas("30/09/2013 00:00:00", "08/10/2013 00:00:00", "D");
        public function diferencaDatas($data1, $data2="",$tipo=""){
            if($data2=="") $data2 = date("d/m/Y H:i");
            if($tipo=="") $tipo = "h";

            for($i=1;$i<=2;$i++){
                
                
                
                ${"dia".$i}     = substr(${"data".$i},0,2);
                ${"mes".$i}     = substr(${"data".$i},3,2);
                ${"ano".$i}     = substr(${"data".$i},6,4);
                ${"horas".$i}   = substr(${"data".$i},11,2);
                ${"minutos".$i} = substr(${"data".$i},14,2);
                
                
                
            }
            $segundos = null;
            
            
            
            $data2 = mktime((int)$horas2,(int)$minutos2,0,(int)$mes2,(int)$dia2,(int)$ano2);
            $data1 = mktime((int)$horas1,(int)$minutos1,0,(int)$mes1,(int)$dia1,(int)$ano1);
            
            $segundos = $data2 - $data1;

            switch($tipo){
                case "m": $difere = $segundos/60; break;
                case "H": $difere = $segundos/3600; break;
                case "h": $difere = round($segundos/3600); break;
                case "D": $difere = $segundos/86400; break;
                case "d": $difere = round($segundos/86400); break;
            }
            return $difere;
        }
        
        //echo dataPorExtenso("30/09/2013 00:00:00" OU "08-10-2013 00:00:00");
        //result 30 de Setembro de 2013 
        public function dataPorExtenso($data) {

            //verifica como ta vindo a data se tiver sem / coloca
            //se tiver com / retira
            $intTotOcorrencia = substr_count($data, "/");   
            
            
            if($intTotOcorrencia > 0){
                //veio com / então retira
                $datFormatado = DataHelper::getInstance()->converterDataUsuarioParaDataBanco($data);
            }else{
                $datFormatado = $data;
            } 
                //quebra pra retirara as horas
                $arrDataComHoras = explode(" ", $datFormatado);
            
                $arrSoData = explode("-", $arrDataComHoras[0]);

		$dia = $arrSoData[2];
		$mes = $arrSoData[1];
		$ano = $arrSoData[0];

		switch ($mes){
                    case 1: $mes = "JANEIRO"; break;
                    case 2: $mes = "FEVEREIRO"; break;
                    case 3: $mes = "MAR&Ccedil;O"; break;
                    case 4: $mes = "ABRIL"; break;
                    case 5: $mes = "MAIO"; break;
                    case 6: $mes = "JUNHO"; break;
                    case 7: $mes = "JULHO"; break;
                    case 8: $mes = "AGOSTO"; break;
                    case 9: $mes = "SETEMBRO"; break;
                    case 10: $mes = "OUTUBRO"; break;
                    case 11: $mes = "NOVEMBRO"; break;
                    case 12: $mes = "DEZEMBRO"; break;
		}

		$mesTexto = ucfirst(strtolower($mes));
		return $dia." de ".$mesTexto." de ".$ano;
	}
        
        public function mesPorExtenso($intMes){
            $strMes = '';
            
            switch ($intMes){
                case 1:  $strMes = "Janeiro"; break;
                case 2:  $strMes = "Fevereiro"; break;
                case 3:  $strMes = "Mar&ccedil;o"; break;
                case 4:  $strMes = "Abril"; break;
                case 5:  $strMes = "Maio"; break;
                case 6:  $strMes = "Junho"; break;
                case 7:  $strMes = "Julho"; break;
                case 8:  $strMes = "Agosto"; break;
                case 9:  $strMes = "Setembro"; break;
                case 10: $strMes = "Outubro"; break;
                case 11: $strMes = "Novembro"; break;
                case 12: $strMes = "Dezembro"; break;
            }
            
            return $strMes;
        }
    }
?>