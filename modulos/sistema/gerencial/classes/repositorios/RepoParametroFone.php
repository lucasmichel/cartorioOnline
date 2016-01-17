<?php
    // codificação utf-8
    class RepoParametroFone{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoParametroFone();
            }

            return self::$objInstance;
        }
        
        public function consultar(){
            $strColunasConsultadas  = "*";            
            $strSQL = "SELECT ".$strColunasConsultadas." FROM CAD_PART_TELEFONES ";
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(ParametroFone $obj){            
            $strSQL  = "INSERT INTO CAD_PART_TELEFONES(";
                $strSQL .= "PART_Numero ";
            $strSQL .= ")VALUES(";
                $strSQL .= "'".$obj->getFone()."' ";
            $strSQL .= ")";
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(){            
            $strSQL  = "DELETE FROM CAD_PART_TELEFONES;";                
            return Db::getInstance()->executar($strSQL);
        }
    }
?>
