<?php
    // codificação utf-8
    class NegTipoCarta{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegTipoCarta();
            }
            
            return self::$objInstance;
        }

       public function consultar($arrStrFiltros){            
            $arrStrDados = RepoTipoCarta::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoTipoCarta::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new TipoCarta();            
            if(isset($arrStrDados["TCA_ID"])){
                $obj->setId($arrStrDados["TCA_ID"]);
            }            
            if(isset($arrStrDados["TCA_Descricao"])){
                $obj->setDescricao($arrStrDados["TCA_Descricao"]);
            }
            if(isset($arrStrDados["TCA_Texto"])){
                $obj->setTexto($arrStrDados["TCA_Texto"]);
            }
            if(isset($arrStrDados["TCA_Status"])){
                $obj->setStatus($arrStrDados["TCA_Status"]);
            }else{
                $obj->setStatus("A");
            }            
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            //PRESEVA O HTML GERADO NO EDITOR
            $obj->setTexto($arrStrDados["TCA_Texto"]);
            //PRESEVA O HTML GERADO NO EDITOR            
            if($obj->getId() == ""){                
                return RepoTipoCarta::getInstance()->salvar($obj);
            }else{ 
                return RepoTipoCarta::getInstance()->alterar($obj);
            }
        }
        
        
        public function excluir($arrStrDados){            
            $obj = new TipoCarta();
            $obj->setId($arrStrDados["TCA_ID"][0]);            
            return RepoTipoCarta::getInstance()->excluir($obj);
            
        }
    }
?>