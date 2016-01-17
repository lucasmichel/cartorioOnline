<?php
    // codificação utf-8
    class RepoHistoricoMembroEstadoCivil{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoHistoricoMembroEstadoCivil();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $strColunasConsultadas  = "*";

            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM ADM_HMEC_HISTORICO_MEMBROS_ESTADOS_CIVIS AS HISTORICO ";             
            $strSQL .= "INNER JOIN CAD_ECV_ESTADOS_CIVIS AS ESTADO_CIVIL ON (ESTADO_CIVIL.ECV_ID = HISTORICO.PES_ID) "; 
            $strSQL .= "INNER JOIN ADM_MEM_MEMBROS AS MEMBRO ON (MEMBRO.PES_ID = HISTORICO.ECV_ID) "; 
            $strSQL .= "INNER JOIN CAD_USU_USUARIOS AS USUARIO_CADASTRO ON (USUARIO_CADASTRO.USU_ID = HISTORICO.USU_Cadastro_ID) ";             
            $strSQL .= "WHERE HISTORICO.ECV_ID IS NOT NULL ";

            if(isset($arrStrFiltros["PES_ID"])){
                $strSQL .= "AND HISTORICO.PES_ID = ".trim($arrStrFiltros["PES_ID"])." ";
            }
            
            if(isset($arrStrFiltros["ECV_ID"])){
                $strSQL .= "AND HISTORICO.ECV_ID = ".trim($arrStrFiltros["ECV_ID"])." ";
            }
            
            if(isset($arrStrFiltros["USU_Cadastro_ID"])){
                $strSQL .= "AND HISTORICO.USU_Cadastro_ID = ".trim($arrStrFiltros["USU_Cadastro_ID"])." ";
            }
            $strSQL .= "ORDER BY HISTORICO.HMEC_DataHoraCadastro";

            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Membro $obj){            
            $retorno = false;
            $arrObjHistoricoMembroEstadoCivil = $obj->getHistoricoMembroEstadoCivil();            
            for($intI=0; $intI<count($arrObjHistoricoMembroEstadoCivil); $intI++){   
                $objHistoricoEstadoCivil  = $arrObjHistoricoMembroEstadoCivil[$intI];
                $strSQL = "INSERT INTO ADM_HMEC_HISTORICO_MEMBROS_ESTADOS_CIVIS (";
                $strSQL .= " ECV_ID, ";    
                $strSQL .= " PES_ID, ";
                $strSQL .= " HMEC_Data, ";
                $strSQL .= " HMEC_DataHoraCadastro, ";
                $strSQL .= " USU_Cadastro_ID, ";
                $strSQL .= " HMEC_Observacao ";                
                $strSQL .= ")VALUES("
                ." ".$objHistoricoEstadoCivil->getEstadoCivil()->getId().", "
                ." ".$obj->getId().", "                        
                ."'".$objHistoricoEstadoCivil->getData()."', "
                ."'".$objHistoricoEstadoCivil->getDataHoraCadastro()."', "
                ." ".$objHistoricoEstadoCivil->getUsuarioCadastro()->getId().", "
                ."'".$objHistoricoEstadoCivil->getObservacao()."')"; 
                
                //echo $strSQL;
                if (Db::getInstance()->insert($strSQL)){
                    $retorno = true;
                }else{
                    $retorno = false;
                } 
            }
            return $retorno;            
        }
        
        public function excluir(Membro $obj){
            $strSQL = "DELETE FROM ADM_HMEC_HISTORICO_MEMBROS_ESTADOS_CIVIS ";
            $strSQL.= "WHERE PES_ID = '".$obj->getId()."'";
            if (DbMysql::getInstance()->update($strSQL)) return true; else return false;
        }
    }
?>