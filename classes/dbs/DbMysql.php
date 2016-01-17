<?php
    set_time_limit(0);
    
    
    
    /*
    private $quantidadeFolhasLivro = 200;
    private $quantidadeLinhasFolha = 36;
    */
    
    // codificação utf-8
    class DbMysql implements InterfaceDatabase{               
        private $hdlCon   = null;
        private $hdlDb    = null;
       
        private $strHost  = "localhost";
        private $strUser  = "root";
        private $strPass  = "";
        private $strBanco = "CARTORIO_ONLINE";
        
        /*private $strHost  = "localhost";
        private $strUser  = "root";
        private $strPass  = "mysql@ms";
        private $strBanco = "IC_TESTAR";*/
        private $debug = "T";//P-producao,T-teste
		
        
        public function __construct() {            
            $this->hdlCon = @mysql_connect($this->strHost, $this->strUser, $this->strPass);
             
            mysql_set_charset('utf8',$this->hdlCon);
            
            if($this->hdlCon){
                $this->hdlDb = mysql_select_db($this->strBanco, $this->hdlCon);

                if(!$this->hdlDb){                        
                    throw new Exception(mysql_error());
                }else{
                    return true;
                }
            }else{
                throw new Exception(mysql_error());
            }
        }
        
        public function select($strSQL){
            $hdlResult = mysql_query($strSQL);
            if($hdlResult){
                $intNumeroLinhas = mysql_num_rows($hdlResult);
                $arrStrLinhas    = null;
                if($intNumeroLinhas > 0){
                    $intI = 0;
                    while($arrStrRes = mysql_fetch_assoc($hdlResult)){
                        $arrStrLinhas[$intI] = $arrStrRes;
                        $intI++;
                    }
                }                
                return $arrStrLinhas;
            }else{                
                if($this->debug == "T"){
                    $msgmErro = "ERRO:<br> CÓD.: ".  mysql_errno()." <br><br> MEN.: ".mysql_error()." <br><br> SQL executada: ".$strSQL;
                }else{
                    $msgmErro = "ERRO: ".$this->menssagensErroNumero(mysql_errno());
                }
                throw new Exception($msgmErro);
            }
        }

        public function executar($strSQL){
            if(!mysql_query($strSQL)){             
                if($this->debug == "T"){
                    $msgmErro = "ERRO:<br> CÓD.: ".  mysql_errno()." <br><br> MEN.: ".mysql_error()." <br><br> SQL executada: ".$strSQL;
                }else{
                    $msgmErro = "ERRO: ".$this->menssagensErroNumero(mysql_errno());
                }
                throw new Exception($msgmErro);
            }
            return true;
        }

        public function getLastId(){                        
            $intId = @mysql_insert_id();            
            if ($intId == 0){                
                if($this->debug == "T"){
                    $msgmErro = "ERRO:<br> CÓD.: ".  mysql_errno()." <br><br> MEN.: ".mysql_error()." <br><br> SQL executada: @mysql_insert_id()";
                }else{
                    $msgmErro = "<pre>ERRO: ".$this->menssagensErroNumero(mysql_errno());
                }
                throw new Exception($msgmErro);                
            }
            return $intId;
        }
        
        private function menssagensErroNumero($mysqlErroNumero) {            
            $txt = "";
            switch ($mysqlErroNumero) {
                case 1451:
                    $txt = " O item não pode ser excluído.<br>Está sendo utilizado em algum relacionamento.";
                    break;
                case 1064:
                    $txt = " Sintaxe SQL. Contate o administrador do sistema.";
                    break;
                default:
                    $txt = " Não identificado,<br>contate o administrador do sistema.";
                    break;
            }
            return $txt;
        }
        
        public function getHost(){
            return $this->strHost;
        }           
    }
?>