<?php
    // codificação utf-8
    class Db extends DbMysql{
        private static $objInstance;
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new Db();
            }
            
            return self::$objInstance;
        }       
    }
?>