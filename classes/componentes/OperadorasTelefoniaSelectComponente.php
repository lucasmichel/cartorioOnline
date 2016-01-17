<?php
    class OperadorasTelefoniaSelectComponente {
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new OperadorasTelefoniaSelectComponente();
            }
            
            return self::$objInstance;
        }
        
        function gerar($strSelectID, $strSelectName){
            $strComponente = "<select id='".$strSelectID."' name='".$strSelectName."' class='campoSelect' style='width: 110px;' >";
                $strComponente.= "<option value=''></option>";
                $strComponente.= "<option value='CLARO'>CLARO</option>";
                $strComponente.= "<option value='EMBRATEL'>EMBRATEL</option>";
                $strComponente.= "<option value='GVT'>GVT</option>";
                $strComponente.= "<option value='INTELIG'>INTELIG</option>";
                $strComponente.= "<option value='NEXTEL'>NEXTEL</option>";
                $strComponente.= "<option value='OI'>OI</option>";                
                $strComponente.= "<option value='TIM'>TIM</option>";
                $strComponente.= "<option value='VIVO'>VIVO</option>";
                $strComponente.= "<option value='OUTROS'>OUTROS</option>";
            $strComponente.= "</select>";
            return $strComponente;
        }
    }
?>
