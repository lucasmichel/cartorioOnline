<?php
    // codificação utf-8
    class NegParametroFone {
        private static $objInstance;
        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegParametroFone();
            }

            return self::$objInstance;
        }
       
         public function consultar(){
            $arrStrDados = RepoParametroFone::getInstance()->consultar();
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
                    $arrStrDadosTotal = RepoParametroFoneSite::getInstance()->consultar($arrStrFiltrosTotal);                     
                    $arrObjParametros["num_rows"] = $arrStrDadosTotal[0]["Total"];*/
                }
            }
            return $arrObjParametros;
        }
        
        public function factory($arrStrDados){            
            $obj = new ParametroFone();
            if(isset($arrStrDados["PART_Numero"])){
                $obj->setFone($arrStrDados["PART_Numero"]);
            }
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosSemModificacao($arrStrDados));            
            return RepoParametroFone::getInstance()->salvar($obj);
        }
        
        public function excluir(){
            return RepoParametroFone::getInstance()->excluir();
        }
        
        
    }
?>