<?php
    // codificação utf-8
    class RepoFormulario{
        private static $objInstance;
        
        private function __construct(){}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoFormulario();
            }
            
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            $strColunasConsultadas  = " F.*, MF.*, M.*, MC.* ";
            
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = " COUNT(F.FRM_ID) AS Total ";
            }

            $strSQL  = "SELECT ".$strColunasConsultadas." FROM CAD_FRM_FORMULARIOS AS F ";
            $strSQL .= "INNER JOIN CAD_MFR_MODULOS_FORMULARIOS AS MF ON (MF.FRM_ID = F.FRM_ID) ";
            $strSQL .= "INNER JOIN CAD_MOD_MODULOS AS M ON (MF.MOD_ID = M.MOD_ID) ";
            $strSQL .= "INNER JOIN CAD_MCT_MODULOS_CATEGORIAS AS MC ON (MC.MCT_ID = M.MCT_ID) ";
            
            // permissões
            if(!empty($arrStrFiltros["GRU_ID"]) && !empty($arrStrFiltros["USU_ID"])){                                
                $strSQL .= "LEFT JOIN CAD_UPE_USUARIOS_PERMISSOES AS U ON (U.FRM_ID = F.FRM_ID) ";
                $strSQL .= "LEFT JOIN CAD_GPE_GRUPOS_PERMISSOES AS GP ON (GP.FRM_ID = F.FRM_ID) ";
            }
            
            $strSQL .= "WHERE F.FRM_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["FRM_Descricao"])){
                $strSQL .= "AND F.FRM_Descricao LIKE '%".$arrStrFiltros["FRM_Descricao"]."%' ";
            }
            
            if(!empty($arrStrFiltros["MOD_ID"])){
                $strSQL .= "AND MF.MOD_ID = ".$arrStrFiltros["MOD_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["MCT_ID"])){
                $strSQL .= "AND MC.MCT_ID = ".$arrStrFiltros["MCT_ID"]." ";
            }

            if(!empty($arrStrFiltros["FRM_ID"])){
                $strSQL .= "AND F.FRM_ID = ".$arrStrFiltros["FRM_ID"]." ";
            }         

            if(!empty($arrStrFiltros["FRM_Status"])){
                $strSQL .= "AND F.FRM_Status = '".$arrStrFiltros["FRM_Status"]."' ";
            }

            // utilizado para gerar a exibição dos módulos
            // que o usuário pode acessar dependendo de suas permissões
            if(!empty($arrStrFiltros["GRU_ID"]) && !empty($arrStrFiltros["USU_ID"])){
                $strSQL .= "AND (U.USU_ID = ".$arrStrFiltros["USU_ID"]." OR GP.GRU_ID = ".trim($arrStrFiltros["GRU_ID"]).") ";
            }
            
            if(empty($arrStrFiltros["TOT_Total"])){
                $strSQL .= "GROUP BY F.FRM_ID ";
                
                if(isset($arrStrFiltros["ORDER_BY"])){
                    $strSQL .= "ORDER BY ".$arrStrFiltros["ORDER_BY"]." ";
                }else{
                    // $strSQL .= "ORDER BY F.FRM_Descricao ";
                    $strSQL .= "ORDER BY MF.MFR_Nivel1Descricao, MF.MFR_Nivel2Descricao, MF.MFR_Nivel3Descricao";
                }
            }
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar($obj){
            $strSQL  = "INSERT INTO CAD_FRM_FORMULARIOS (";
                $strSQL .= "FRM_Descricao, FRM_Caminho, FRM_Status ";
            $strSQL .= ")VALUES(";
                $strSQL .= "'".$obj->getDescricao()."', ";
                $strSQL .= "'".$obj->getCaminho()."', ";
                $strSQL .= "'".$obj->getStatus()."' ";
            $strSQL .= ")";
                     
            if (Db::getInstance()->executar($strSQL)){                
                $intId = Db::getInstance()->getLastId();
                
                $strSQL = "INSERT INTO CAD_MFR_MODULOS_FORMULARIOS(";
                    $strSQL .= "MOD_ID, FRM_ID, MFR_Nivel1Descricao, ";
                    $strSQL .= "MFR_Nivel2Descricao, MFR_Nivel3Descricao";
                $strSQL .= ")VALUES(";
                    $strSQL .= $obj->getModulo()->getId().", ".$intId.", '".$obj->getNivel1Descricao()."', ";
                    $strSQL .= "'".$obj->getNivel2Descricao()."', '".$obj->getNivel3Descricao()."'";
                $strSQL .= ")";
                
                if(Db::getInstance()->executar($strSQL)){
                    $arrObjAcoes = $obj->getAcoes();
                    
                    for($intI=0; $intI<count($arrObjAcoes); $intI++){
                        $strSQL  = "INSERT INTO CAD_FAC_FORMULARIOS_ACOES(";
                            $strSQL .= "FRM_ID, ACO_ID";                        
                        $strSQL .= ")VALUES(";
                            $strSQL .= $intId.", ".$arrObjAcoes[$intI]->getId();
                        $strSQL .= ")";
                        
                        Db::getInstance()->executar($strSQL);
                    }
                    
                    return true;
                }
            }
        }

        public function alterar($obj){
            $strSQL  = "UPDATE CAD_FRM_FORMULARIOS SET ";
            $strSQL .= "FRM_Descricao = '".$obj->getDescricao()."', ";
            $strSQL .= "FRM_Caminho = '".$obj->getCaminho()."', ";
            $strSQL .= "FRM_Status = '".$obj->getStatus()."' ";
            $strSQL .= "WHERE FRM_ID = ".$obj->getId();  

            if (Db::getInstance()->executar($strSQL)){                
                $strSQL = "UPDATE CAD_MFR_MODULOS_FORMULARIOS SET ";
                    $strSQL .= "MFR_Nivel1Descricao = '".$obj->getNivel1Descricao()."', ";
                    $strSQL .= "MFR_Nivel2Descricao = '".$obj->getNivel2Descricao()."', ";
                    $strSQL .= "MFR_Nivel3Descricao = '".$obj->getNivel3Descricao()."', ";
                    $strSQL .= "MOD_ID = ".$obj->getModulo()->getId()." ";
                $strSQL .= "WHERE FRM_ID = ".$obj->getId();
                
                if(Db::getInstance()->executar($strSQL)){
                    // primeiro remove as as persmissóes do formulario
                    
                    $strSQLPermissaoGrupo = "DELETE FROM CAD_GPE_GRUPOS_PERMISSOES WHERE FRM_ID=".$obj->getId();            
                    if(Db::getInstance()->executar($strSQLPermissaoGrupo)){                
                        $strSQLPermissaoUsuario = "DELETE FROM CAD_UPE_USUARIOS_PERMISSOES WHERE FRM_ID=".$obj->getId();                        
                        if(Db::getInstance()->executar($strSQLPermissaoUsuario)){                
                            
                            // para depois remove as ações do formulário
                            // para posteriormente inserí-las novamente
                            $strSQL = "DELETE FROM CAD_FAC_FORMULARIOS_ACOES WHERE FRM_ID = ".$obj->getId();
                            if(Db::getInstance()->executar($strSQL)){                    
                                $arrObjAcoes = $obj->getAcoes();

                                for($intI=0; $intI<count($arrObjAcoes); $intI++){
                                    $strSQL  = "INSERT INTO CAD_FAC_FORMULARIOS_ACOES(";
                                        $strSQL .= "FRM_ID, ACO_ID";                        
                                    $strSQL .= ")VALUES(";
                                        $strSQL .= $obj->getId().", ".$arrObjAcoes[$intI]->getId();
                                    $strSQL .= ")";

                                    Db::getInstance()->executar($strSQL);
                                }

                                return true;
                            }
                        }
                        
                    }
                    
                    
                }
            }
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM CAD_GPE_GRUPOS_PERMISSOES WHERE FRM_ID=".$obj->getId();
            
            if(Db::getInstance()->executar($strSQL)){                
                $strSQL = "DELETE FROM CAD_UPE_USUARIOS_PERMISSOES WHERE FRM_ID=".$obj->getId();
            
                if(Db::getInstance()->executar($strSQL)){                
                    $strSQL = "DELETE FROM CAD_FAC_FORMULARIOS_ACOES WHERE FRM_ID=".$obj->getId();
                    
                    if(Db::getInstance()->executar($strSQL)){
                        $strSQL = "DELETE FROM CAD_MFR_MODULOS_FORMULARIOS WHERE FRM_ID=".$obj->getId();
                        Db::getInstance()->executar($strSQL);
                    }
                }
            }
            
            return true;
        }
    }
?>