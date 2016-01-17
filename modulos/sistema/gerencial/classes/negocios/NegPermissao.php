<?php
    // codificação utf-8
    class NegPermissao{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegPermissao();
            }
            
            return self::$objInstance;
        }

        public function consultarPermissaoGrupo($arrStrFiltros){
            $arrStrDados = RepoPermissao::getInstance()->consultarPermissaoGrupo($arrStrFiltros);
            $arrObjRetorno = null;            
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjRetorno = array();
                    $arrObjRetorno["rows"] = $arrStrDados;
                }
            }  
            
            return $arrObjRetorno;
        }
        
        public function consultarPermissaoUsuario($arrStrFiltros){
            $arrStrDados = RepoPermissao::getInstance()->consultarPermissaoUsuario($arrStrFiltros);
            $arrObjRetorno = null;            
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjRetorno = array();
                    $arrObjRetorno["rows"] = $arrStrDados;
                }
            }  
            
            return $arrObjRetorno;
        }

        private function factoryPermissaoGrupo($arrStrDados){
            $obj = new PermissaoGrupo();
            
            // formulario
            $objFormulario = new Formulario();
            $objFormulario->setId($arrStrDados["FRM_ID"]);
            $obj->setFormulario($objFormulario);
            
            // acao
            $objAcao = new Acao();
            $objAcao->setId($arrStrDados["ACO_ID"]);
            $obj->setAcao($objAcao);
            
            // grupo
            $objGrupo = new Grupo();
            $objGrupo->setId($arrStrDados["GRU_ID"]);
            $obj->setGrupo($objGrupo);
            
            return $obj;
        }
        
        private function factoryPermissaoUsuario($arrStrDados){
            $obj = new PermissaoUsuario();
            
            // formulario
            $objFormulario = new Formulario();
            $objFormulario->setId($arrStrDados["FRM_ID"]);
            $obj->setFormulario($objFormulario);
            
            // acao
            $objAcao = new Acao();
            $objAcao->setId($arrStrDados["ACO_ID"]);
            $obj->setAcao($objAcao);
            
            // usuario
            $objUsuario = new Usuario();
            $objUsuario->setId($arrStrDados["USU_ID"]);
            $obj->setUsuario($objUsuario); 
            
            return $obj;
        }

        public function salvarPermissaoGrupo($arrStrDados){            
            if(isset($arrStrDados["ACO_ID"])){
                if(is_array($arrStrDados["ACO_ID"])){
                    // remove todas as permissões do Grupo
                    // para posteriormente inserir as novas permissões
                    if(RepoPermissao::getInstance()->removerPermissaoGrupo($arrStrDados)){
                        for($intI=0; $intI<count($arrStrDados["ACO_ID"]); $intI++){
                            // separa os dados do FRM_ID e ACO_ID da string recebida
                            $arrStr = explode("#", $arrStrDados["ACO_ID"][$intI]);
                            $arrStrDadosPermissao["FRM_ID"] = $arrStr[0];
                            $arrStrDadosPermissao["ACO_ID"] = $arrStr[1];
                            $arrStrDadosPermissao["GRU_ID"] = $arrStrDados["GRU_ID"];
                            
                            RepoPermissao::getInstance()->salvarPermissaoGrupo($this->factoryPermissaoGrupo($arrStrDadosPermissao));
                        }
                    }
                }
            }
            
            return true;
        }
        
        public function salvarPermissaoUsuario($arrStrDados){               
            if(isset($arrStrDados["ACO_ID"])){
                if(is_array($arrStrDados["ACO_ID"])){                    
                    // remove todas as permissões do Grupo
                    // para posteriormente inserir as novas permissões
                    if(RepoPermissao::getInstance()->removerPermissaoUsuario($arrStrDados)){
                        for($intI=0; $intI<count($arrStrDados["ACO_ID"]); $intI++){
                            // separa os dados do FRM_ID e ACO_ID da string recebida
                            $arrStr = explode("#", $arrStrDados["ACO_ID"][$intI]);
                            $arrStrDadosPermissao["FRM_ID"] = $arrStr[0];
                            $arrStrDadosPermissao["ACO_ID"] = $arrStr[1];
                            $arrStrDadosPermissao["USU_ID"] = $arrStrDados["USU_ID"];
                            
                            RepoPermissao::getInstance()->salvarPermissaoUsuario($this->factoryPermissaoUsuario($arrStrDadosPermissao));
                        }
                    }
                }
            }else{
                RepoPermissao::getInstance()->removerPermissaoUsuario($arrStrDados);
            }
            
            return true;
        }
    }
?>