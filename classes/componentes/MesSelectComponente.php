<?php
    // codificação utf-8
    class MesSelectComponente{
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new MesSelectComponente();
            }
            
            return self::$objInstance;
        }
        
        public function gerar($strSelectID, $strSelectName, $strNumeroMesSelecionado = null){
            $arrStrMeses       = array();
            $arrStrMeses["01"] = "JANEIRO";
            $arrStrMeses["02"] = "FEVEREIRO";
            $arrStrMeses["03"] = "MAR&Ccedil;O";
            $arrStrMeses["04"] = "ABRIL";
            $arrStrMeses["05"] = "MAIO";
            $arrStrMeses["06"] = "JUNHO";
            $arrStrMeses["07"] = "JULHO";
            $arrStrMeses["08"] = "AGOSTO";
            $arrStrMeses["09"] = "SETEMBRO";
            $arrStrMeses["10"] = "OUTUBRO";
            $arrStrMeses["11"] = "NOVEMBRO";
            $arrStrMeses["12"] = "DEZEMBRO";
            
            $strComponente  = "<select id='".$strSelectID."' name='".$strSelectName."' class='campoSelect'>";
                foreach($arrStrMeses as $strNumeroMes => $strMes){
                    $strSelected = "";
                    
                    if($strNumeroMesSelecionado == $strNumeroMes){
                        $strSelected = "selected";
                    }
                    
                    $strComponente.= "<option value='".$strNumeroMes."' ".$strSelected.">".$strMes."</option>";
                }
            $strComponente .= "</select>";
            
            return $strComponente;
        }
    }
?>
