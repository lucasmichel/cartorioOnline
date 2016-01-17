<?php
    // codificação utf-8
    class ReferenciaSelectComponente{
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new ReferenciaSelectComponente();
            }
            
            return self::$objInstance;
        }
        
        public function gerar($strSelectID, $strSelectName, $strLabel){            
            $strComponente  = "<div class='side-by-side clearfix'>";
            $strComponente .= "<label for='".$strSelectID."'>".$strLabel."</label>";
            $strComponente .= "<select id='".$strSelectID."' name='".$strSelectName."' data-placeholder='SELECIONE A REFER&Ecirc;NCIA.' class='chosen-select-deselect' style='width:127px;'  >";
                               
                for($intI=(intval(date("Y")) - 1); $intI<=(intval(date("Y")) + 3); $intI++){
                    for($intX=1;$intX<=12;$intX++){
                        $strMes = $intX;
                        
                        if($intX < 10){
                            $strMes = "0".$intX;
                        }
                        
                        $strSelected = '';
                        
                        if(($strMes."/".$intI) == date("m/Y")){
                            $strSelected = 'selected';
                        }
                        
                        $strReferencia = $strMes."/".$intI;
                        
                        $strComponente .= "<option value='".$strReferencia."' ".$strSelected.">".$strReferencia."</option>";
                    }
                }
                
            $strComponente .= "</select>";
            $strComponente .= "</div>";
            
            return $strComponente;
        }
    }
?>
