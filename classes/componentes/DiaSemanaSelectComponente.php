<?php
    // codificação utf-8
    class DiaSemanaSelectComponente{
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new DiaSemanaSelectComponente();
            }
            
            return self::$objInstance;
        }
        
        public function gerar($strSelectID, $strSelectName){            
            $strComponente  = "<div class='side-by-side clearfix'>";
            $strComponente .= "<label for='".$strSelectID."'>Dia da semana*</label>";
            $strComponente .= "<select id='".$strSelectID."' name='".$strSelectName."' data-placeholder='SELECIONE O DIA DA SEMANA' class='chosen-select-deselect' style='width:260px;'  >";
                
                $strComponente .= "<option value=''></option>";
                
                // CONSULTA AS UFs
                $strSQL = "SELECT * FROM CAD_DIA_DIAS_SEMANA WHERE DIA_Status = 'A' ORDER BY DIA_ID";               
                $arrStrDados = Db::getInstance()->select($strSQL);           
                
                // identifica a UF informada no parâmetro SISTEMA_UF
                $arrStrParametrosFiltros = array();
                $arrStrParametrosFiltros["PAR_Descricao"] = "SISTEMA_UF";
                                
                for($intI=0; $intI<count($arrStrDados); $intI++){
                    
                    $strComponente .= "<option value='".$arrStrDados[$intI]["DIA_ID"]."' >".$arrStrDados[$intI]["DIA_Descricao"]."</option>";
                }
                
            $strComponente .= "</select>";
            $strComponente .= "</div>";
            
            return $strComponente;
        }
    }
?>
