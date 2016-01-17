<?php
    // codificação utf-8
    class DocumentacaoHelper{
        private static $objInstance;
               
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new DocumentacaoHelper();                
            }
            
            return self::$objInstance;
        }
        
        public function formatarCPFCNPJ($strCampo, $booFormatado = true){
            //retira formato
            $strCodigoLimpo = @ereg_replace("[' '-./ t]", '', $strCampo);
            
            // pega o tamanho da string menos os digitos verificadores
            $intTamanho = (strlen($strCodigoLimpo) - 2);
            
            //verifica se o tamanho do cÃ³digo informado Ã© vÃ¡lido
            if ($intTamanho != 9 && $intTamanho != 12){
                //return "00.000.000/0000-00"; 
                return " "; 
            }

            if ($booFormatado){ 
                // seleciona a mÃ¡scara para cpf ou cnpj
                $strMascara = ($intTamanho == 9) ? '###.###.###-##' : '##.###.###/####-##'; 

                $intIndice = -1;
                
                for ($intI=0; $intI < strlen($strMascara); $intI++) {
                    if ($strMascara[$intI] == '#') $strMascara[$intI] = $strCodigoLimpo[++$intIndice];
                }
                
                //retorna o campo formatado
                $strRetorno = $strMascara;
            }else{
                //se nÃ£o quer formatado, retorna o campo limpo
                $strRetorno = $strCodigoLimpo;
            }

            return $strRetorno;
        }
    }
?>
