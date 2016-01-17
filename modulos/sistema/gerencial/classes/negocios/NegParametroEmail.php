<?php
    // codificação utf-8
    class NegParametroEmail {
        private static $objInstance;
        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegParametroEmail();
            }

            return self::$objInstance;
        }
       
         public function consultar(){
            $arrStrDados = RepoParametroEmail::getInstance()->consultar();
            $arrObjParametros = null;
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                    }
                    // responsável por exibir dados na grid
                    $arrObjParametros = array();
                    $arrObjParametros["objects"]  = $arrObjs;
                    $arrObjParametros["rows"]     = $arrStrDados;
                    // identifica o total de registros referente a consulta
                    /*$arrStrFiltrosTotal = array();
                    $arrStrFiltrosTotal["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoParametroEmailSite::getInstance()->consultar($arrStrFiltrosTotal);                     
                    $arrObjParametros["num_rows"] = $arrStrDadosTotal[0]["Total"];*/
                }
            }
            return $arrObjParametros;
        }
        
        public function factory($arrStrDados){            
            $obj = new ParametroEmail();
            if(isset($arrStrDados["PARE_EMAILS"])){
                $obj->setEmail($arrStrDados["PARE_EMAILS"]);
            }
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosSemModificacao($arrStrDados));            
            return RepoParametroEmail::getInstance()->salvar($obj);
        }
        
        public function excluir(){
            return RepoParametroEmail::getInstance()->excluir();
        }
        
    }
?>