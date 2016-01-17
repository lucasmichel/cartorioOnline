<?php
    // codificação utf-8


    class Monetary {
        private static $unidades = array("um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze", "doze",
                                         "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove");
        private static $dezenas = array("dez", "vinte", "trinta", "quarenta","cinqüenta", "sessenta", "setenta", "oitenta", "noventa");
        private static $centenas = array("cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", 
                                         "seiscentos", "setecentos", "oitocentos", "novecentos");
        private static $milhares = array(
            array("text" => "mil", "start" => 1000, "end" => 999999, "div" => 1000),
            array("text" => "milhão", "start" =>  1000000, "end" => 1999999, "div" => 1000000),
            array("text" => "milhões", "start" => 2000000, "end" => 999999999, "div" => 1000000),
            array("text" => "bilhão", "start" => 1000000000, "end" => 1999999999, "div" => 1000000000),
            array("text" => "bilhões", "start" => 2000000000, "end" => 2147483647, "div" => 1000000000)        
        );
        const MIN = 0.01;
        const MAX = 2147483647.99;
        const MOEDA = " real ";
        const MOEDAS = " reais ";
        const CENTAVO = " centavo ";
        const CENTAVOS = " centavos ";    

        static function numberToExt($number, $moeda = true) {
            if ($number >= self::MIN && $number <= self::MAX) {
                $value = self::conversionR((int)$number);       
                if ($moeda) {
                    if (floor($number) == 1) {
                        $value .= self::MOEDA;
                    }
                    else if (floor($number) > 1) $value .= self::MOEDAS;
                }

                $decimals = self::extractDecimals($number);            
                if ($decimals > 0.00) {
                    $decimals = round($decimals * 100);
                    $value .= " e ".self::conversionR($decimals);
                    if ($moeda) {
                        if ($decimals == 1) {
                            $value .= self::CENTAVO;
                        }   
                        else if ($decimals > 1) $value .= self::CENTAVOS;
                    }
                }
            }
            return trim($value);
        }

        private static function extractDecimals($number) {
            return $number - floor($number);
        }

        static function conversionR($number) {
            $value = null;
            if (in_array($number, range(1, 19))) {
                $value = self::$unidades[$number-1];
            }
            else if (in_array($number, range(20, 90, 10))) {
                 $value = self::$dezenas[floor($number / 10)-1]." ";           
            }     
            else if (in_array($number, range(21, 99))) {
                 $value = self::$dezenas[floor($number / 10)-1]." e ".self::conversionR($number % 10);           
            }     
            else if (in_array($number, range(100, 900, 100))) {
                 $value = self::$centenas[floor($number / 100)-1]." ";           
            }          
            else if (in_array($number, range(101, 199))) {
                 $value = ' cento e '.self::conversionR($number % 100);         
            }   
            else if (in_array($number, range(201, 999))) {
                 $value = self::$centenas[floor($number / 100)-1]." e ".self::conversionR($number % 100);        
            }  
            else {
                foreach (self::$milhares as $item) {
                    if ($number >= $item['start'] && $number <= $item['end']) {
                        $value = self::conversionR(floor($number / $item['div']))." ".$item['text']." ".self::conversionR($number % $item['div']);
                        break;
                    }
                }
            }        
            return $value;
        }
    }


    class NumeroHelper{
        private static $objInstance;
               
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NumeroHelper();                
            }
            
            return self::$objInstance;
        }
        
        public function completarComZero($strNumero, $intTamanho){
            $intNumero        = $intTamanho;
            $intTamanhoNumero = strlen($strNumero);
            $strNumeroFinal   = "";
            
            for($intI=1; $intI<=($intNumero - $intTamanhoNumero); $intI++){
                $strNumeroFinal .= "0";
            }            
            
            return $strNumeroFinal.$strNumero;
        }
        
        public function formatarNumeroParaBanco($strNumero){
            $strNumero = str_replace(".", "", $strNumero);
            $strNumero = str_replace(",", ".", $strNumero);
            return $strNumero;
        }
        
        public function formatarMoeda($strNumero){            
            return number_format($strNumero, 2, ",", ".");
        }
        
        public function formatar2CasasDecimais($srtNumero){            
            $strNumeroNovo = '0.00'; 
            $arrStrNumero  = explode(".", $srtNumero);
            
            if(count($arrStrNumero) == 2){                
                if(strlen($arrStrNumero[1]) == 1){                    
                    $arrStrNumero[1] .= '0';
                }else{
                    if(strlen($arrStrNumero[1]) > 2){
                        // sempre reduz para duas casas decimais
                        $arrStrNumero[1] = substr($arrStrNumero[1], 0, 2);
                    }
                }
                
                $strNumeroNovo = $arrStrNumero[0].'.'.$arrStrNumero[1];                
            }else{
                $strNumeroNovo = $arrStrNumero[0].'.00';
            }
            
            return $strNumeroNovo;
        }
        
        public function valorPorExtenso($valor=0)
        {
            return Monetary::numberToExt($valor);            
        }
        
        function modulo11($num, $base=9, $r=0) {
            /**
            * Autor:
            * Pablo Costa <pablo@users.sourceforge.net>
            *
            * Função:
            * Calculo do Modulo 11 para geracao do digito verificador 
            * de boletos bancarios conforme documentos obtidos 
            * da Febraban - www.febraban.org.br 
            *
            * Entrada:
            * $num: string numérica para a qual se deseja calcularo digito verificador;
            * $base: valor maximo de multiplicacao [2-$base]
            * $r: quando especificado um devolve somente o resto
            *
            * Saída:
            * Retorna o Digito verificador.
            *
            * Observações:
            * - Script desenvolvido sem nenhum reaproveitamento de código pré existente.
            * - Assume-se que a verificação do formato das variáveis de entrada é feita antes da execução deste script.
            */ 

            $soma = 0;
            $fator = 2;

            /* Separacao dos numeros */
            for ($i = strlen($num); $i > 0; $i--) {
                // pega cada numero isoladamente
                $numeros[$i] = substr($num,$i-1,1);
                // Efetua multiplicacao do numero pelo falor
                $parcial[$i] = $numeros[$i] * $fator;
                // Soma dos digitos
                $soma += $parcial[$i];
                if ($fator == $base) {
                    // restaura fator de multiplicacao para 2 
                    $fator = 1;
                }
                $fator++;
            }

            /* Calculo do modulo 11 */
            if ($r == 0) {
                $soma *= 10;
                $digito = $soma % 11;
                
                if ($digito == 10) {
                    $digito = 0;
                }
                
                return $digito;
            }elseif ($r == 1){
                $resto = $soma % 11;
                return $resto;
            }
        } 
    }
?>