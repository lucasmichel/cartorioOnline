<?php
    // codificação utf-8
    class RepoPermissao{
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoPermissao();
            }
            
            return self::$objInstance;
        }
        
        public function consultarPermissaoGrupo($arrStrFiltros){
            $strSQL = "SELECT * FROM CAD_GPE_GRUPOS_PERMISSOES WHERE GRU_ID = ".$arrStrFiltros["GRU_ID"];
            return Db::getInstance()->select($strSQL);
        }
        
        public function consultarPermissaoUsuario($arrStrFiltros){
            $strSQL = "SELECT * FROM CAD_UPE_USUARIOS_PERMISSOES WHERE USU_ID = ".$arrStrFiltros["USU_ID"];
            return Db::getInstance()->select($strSQL);
        }
        
        public function removerPermissaoGrupo($arrStrFiltros){
            $strSQL = "DELETE FROM CAD_GPE_GRUPOS_PERMISSOES WHERE GRU_ID = ".$arrStrFiltros["GRU_ID"];
            return Db::getInstance()->executar($strSQL);
        }
        
        public function removerPermissaoUsuario($arrStrFiltros){
            $strSQL = "DELETE FROM CAD_UPE_USUARIOS_PERMISSOES WHERE USU_ID = ".$arrStrFiltros["USU_ID"];
            return Db::getInstance()->executar($strSQL);
        }
        
        public function salvarPermissaoGrupo(PermissaoGrupo $obj){
            $strSQL  = "INSERT INTO CAD_GPE_GRUPOS_PERMISSOES(";
                $strSQL .= "FRM_ID, ACO_ID, GRU_ID";
            $strSQL .= ")VALUES(";
                $strSQL .= $obj->getFormulario()->getId().", ".$obj->getAcao()->getId().", ".$obj->getGrupo()->getId();
            $strSQL .= ")";
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function salvarPermissaoUsuario(PermissaoUsuario $obj){
            $strSQL  = "INSERT INTO CAD_UPE_USUARIOS_PERMISSOES(";
                $strSQL .= "FRM_ID, ACO_ID, USU_ID";
            $strSQL .= ")VALUES(";
                $strSQL .= $obj->getFormulario()->getId().", ".$obj->getAcao()->getId().", ".$obj->getUsuario()->getId();
            $strSQL .= ")";
            
            return Db::getInstance()->executar($strSQL);
        }
    }
?>
