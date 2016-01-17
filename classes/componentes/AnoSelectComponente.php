<?php
    // codificação utf-8
    class AnoSelectComponente{
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new AnoSelectComponente();
            }
            
            return self::$objInstance;
        }
        
        public function gerar($strSelectID, $strSelectName, $strAnoSelecionado = null){   
            $intAno = 2010;
           
            $strComponente  = "<select id='".$strSelectID."' name='".$strSelectName."' class='campoSelect'>";
                for($intI=$intAno; $intI<2090; $intI++){
                    $strSelected = "";
                    
                    if($strAnoSelecionado == $intI){
                        $strSelected = "selected";
                    }
                    
                    $strComponente .= "<option value='".$intI."' ".$strSelected.">".$intI."</option>";
                }
            $strComponente .= "</select>";
            
            return $strComponente;
        }
    }
?>
