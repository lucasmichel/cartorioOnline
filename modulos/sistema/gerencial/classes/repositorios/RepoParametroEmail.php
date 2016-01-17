<?php
    // codificação utf-8
    class RepoParametroEmail{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoParametroEmail();
            }

            return self::$objInstance;
        }
        
        public function consultar(){
            $strColunasConsultadas  = "*";            
            $strSQL = "SELECT ".$strColunasConsultadas." FROM CAD_PARE_EMAILS ";
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(ParametroEmail $obj){            
            $strSQL  = "INSERT INTO CAD_PARE_EMAILS(";
                $strSQL .= "PARE_EMAILS ";
            $strSQL .= ")VALUES(";
                $strSQL .= "'".$obj->getEmail()."' ";
            $strSQL .= ")";
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(){            
            $strSQL  = "DELETE FROM CAD_PARE_EMAILS;";                
            return Db::getInstance()->executar($strSQL);
        }
    }
?>
