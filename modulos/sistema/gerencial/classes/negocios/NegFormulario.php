<?php
    // codificação utf-8
    class NegFormulario{
        private static $objInstance;
        
        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegFormulario();
            }
            
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            $arrStrDados    = RepoFormulario::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;    
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        // identifica as ações
                        // do formulário
                        // todo formulário deve possuir ações associadas a ele
                        // montasse o array de ações ACO_ID para a factory montar
                        // o objeto formulário com todas as informações necessárias
                        $arrStrFormularioFiltros = array();
                        $arrStrFormularioFiltros["FRM_ID"] = $arrStrDados[$intI]["FRM_ID"];
                        $arrStrDadosAcao = RepoAcao::getInstance()->consultar($arrStrFormularioFiltros);
                        $arrStrDados[$intI]["ACO_ID"] = array();
                        
                        // monta o array de ACO_ID
                        for($intX = 0; $intX < count($arrStrDadosAcao); $intX++){
                            $arrStrDados[$intI]["ACO_ID"][] = $arrStrDadosAcao[$intX]["ACO_ID"];
                        }
                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoFormulario::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            
            return $arrObjsRetorno;
        }
        
        private function factory($arrStrDados){
            $obj = new Formulario();
            
            if(isset($arrStrDados["FRM_ID"])){
                $obj->setId($arrStrDados["FRM_ID"]);
            }
            
            $obj->setDescricao($arrStrDados["FRM_Descricao"]);
            $obj->setCaminho($arrStrDados["FRM_Caminho"]);
            
            if(isset($arrStrDados["FRM_Status"])){
                $obj->setStatus($arrStrDados["FRM_Status"]);
            }else{
                $obj->setStatus("A");
            }
            
            // módulo categoria
            $objModuloCategoria = new ModuloCategoria();
            
            if(isset($arrStrDados["MCT_ID"])){
                $objModuloCategoria->setId($arrStrDados["MCT_ID"]);
            }
            
            if(isset($arrStrDados["MCT_Descricao"])){
                $objModuloCategoria->setDescricao($arrStrDados["MCT_Descricao"]);
            }
            
            // módulo
            $objModulo = new Modulo();
            $objModulo->setId($arrStrDados["MOD_ID"]);
            
            if(isset($arrStrDados["MOD_Descricao"])){
                $objModulo->setDescricao($arrStrDados["MOD_Descricao"]);
            }
            
            $objModulo->setModuloCategoria($objModuloCategoria);
            $obj->setModulo($objModulo);
            
            if(isset($arrStrDados["MFR_Nivel1Descricao"])){
                $obj->setNivel1Descricao($arrStrDados["MFR_Nivel1Descricao"]);
            }
            
            if(isset($arrStrDados["MFR_Nivel2Descricao"])){
                $obj->setNivel2Descricao($arrStrDados["MFR_Nivel2Descricao"]);
            }
            
            if(isset($arrStrDados["MFR_Nivel3Descricao"])){
                $obj->setNivel3Descricao($arrStrDados["MFR_Nivel3Descricao"]);
            }
            
            // ações
            if(isset($arrStrDados["ACO_ID"])){
                if(is_array($arrStrDados["ACO_ID"])){                    
                    for($intI=0; $intI<count($arrStrDados["ACO_ID"]); $intI++){
                        $objAcao = new Acao();
                        $objAcao->setId($arrStrDados["ACO_ID"][$intI]);
                        $obj->addAcao($objAcao);
                    }
                }
            }
            
            return $obj;
        }
        
        public function salvar($arrStrDados){             
            $obj = $this->factory($arrStrDados);
            
            if($obj->getId() == ""){
                return RepoFormulario::getInstance()->salvar($obj);
            }else{ 
                return RepoFormulario::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new Formulario();
            $obj->setId($arrStrDados["FRM_ID"][0]);
            return RepoFormulario::getInstance()->excluir($obj);
        }
    }
?>