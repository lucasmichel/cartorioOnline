<?php
    // codificação utf-8
    class UFSelectComponente{
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new UFSelectComponente();
            }
            
            return self::$objInstance;
        }
        
        public function gerar($strSelectID, $strSelectName, $boolExibirTextoSelecione = true){            
            $strComponente  = "<select id='".$strSelectID."' name='".$strSelectName."' class='campoSelect'>";
                
                if($boolExibirTextoSelecione){
                    $strComponente .= "<option value=''></option>";
                }
                
                // CONSULTA AS UFs
                $strSQL = "SELECT * FROM CAD_UF_UNIDADES_FEDERATIVAS WHERE UF_Status = 'A' ORDER BY UF_Sigla";               
                $arrStrDados = Db::getInstance()->select($strSQL);           
                                                
                for($intI=0; $intI<count($arrStrDados); $intI++){
                    $strComponente .= "<option value='".$arrStrDados[$intI]["UF_ID"]."'>".$arrStrDados[$intI]["UF_Sigla"]." - ".$arrStrDados[$intI]["UF_Descricao"]."</option>";
                }
                
            $strComponente .= "</select>";
            
            return $strComponente;
        }
        
        public function gerarSigla($strSelectID, $strSelectName, $boolExibirTextoSelecione = true, $style = ""){
            $strComponente  = "<select id='".$strSelectID."' name='".$strSelectName."' class='campoSelect' style='".$style."'>";
                
                if($boolExibirTextoSelecione){
                    $strComponente .= "<option value=''></option>";
                }
                
                // CONSULTA AS UFs
                $strSQL = "SELECT * FROM CAD_UF_UNIDADES_FEDERATIVAS WHERE UF_Status = 'A' ORDER BY UF_Sigla";               
                $arrStrDados = Db::getInstance()->select($strSQL);           
                                             
                for($intI=0; $intI<count($arrStrDados); $intI++){
                    $strComponente .= "<option value='".$arrStrDados[$intI]["UF_Sigla"]."'>".$arrStrDados[$intI]["UF_Sigla"]."</option>";
                }
                
            $strComponente .= "</select>";
            
            return $strComponente;
        }
    }
?>
