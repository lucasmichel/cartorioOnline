<?php
    // codificação utf-8
    class RepoMinisterio{
        private static $objInstance;
        private function __construct() {}
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoMinisterio();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM ADM_MIN_MINISTERIOS AS MINISTERIOS "; 
            $strSQL .= "LEFT JOIN ADM_AMI_AREAS_MINISTERIAIS AS AREA_MIINISTERIAIS ON (AREA_MIINISTERIAIS.AMI_ID = MINISTERIOS.AMI_ID) ";
            $strSQL .= "WHERE MINISTERIOS.MIN_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["MIN_ID"])){
                $strSQL .= "AND MINISTERIOS.MIN_ID = ".trim($arrStrFiltros["MIN_ID"])." ";
            }
            if(!empty($arrStrFiltros["AMI_ID"])){
                
                if(trim($arrStrFiltros["AMI_ID"]) > 0){
                    $strSQL .= "AND MINISTERIOS.AMI_ID = ".trim($arrStrFiltros["AMI_ID"])." ";
                }else{
                    $strSQL .= "AND MINISTERIOS.AMI_ID ".trim($arrStrFiltros["AMI_ID"])." ";
                }
                
                
                
            }
            if(!empty($arrStrFiltros["MIN_Descricao"])){
                $strSQL .= "AND MINISTERIOS.MIN_Descricao LIKE  '%".trim($arrStrFiltros["MIN_Descricao"])."%' ";
            }
            if(!empty($arrStrFiltros["MIN_Status"])){
                $strSQL .= "AND MINISTERIOS.MIN_Status = '".$arrStrFiltros["MIN_Status"]."' ";
            }
            $strSQL .= "ORDER BY MIN_Descricao ";
            if(isset($arrStrFiltros["offset"]) && isset($arrStrFiltros["limit"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Ministerio $obj){            
            $idAreaMinisterial = "(NULL)";
            if($obj->getObjAreaMinisterial()->getId() > 0){
                $idAreaMinisterial = $obj->getObjAreaMinisterial()->getId();
            }
            $strSQL = "INSERT INTO ADM_MIN_MINISTERIOS (";
                $strSQL .= "MIN_Descricao, ";
                $strSQL .= "MIN_Observacao, ";
                $strSQL .= "MIN_DataHoraCadastro, ";
                $strSQL .= "MIN_EnderecoCep, ";
                $strSQL .= "MIN_EnderecoLogradouro, ";
                $strSQL .= "MIN_EnderecoNumero, ";
                $strSQL .= "MIN_EnderecoComplemento, ";
                $strSQL .= "MIN_EnderecoPontoReferencia, ";
                $strSQL .= "MIN_EnderecoBairro, ";
                $strSQL .= "MIN_EnderecoCidade, ";
                $strSQL .= "MIN_EnderecoUf, ";
                $strSQL .= "MIN_Status, ";
                $strSQL .= "AMI_ID ";
            $strSQL .= ")VALUES(";
                $strSQL .= "'".$obj->getDescricao()."', ";
                $strSQL .= "'".$obj->getObservacao()."', ";
                $strSQL .= "'".$obj->getDataHoraCadastro()."', ";
                $strSQL .= "'".$obj->getEndereco()->getCep()."', ";
                $strSQL .= "'".$obj->getEndereco()->getLogradouro()."', ";
                $strSQL .= "'".$obj->getEndereco()->getNumero()."', ";
                $strSQL .= "'".$obj->getEndereco()->getComplemento()."', ";
                $strSQL .= "'".$obj->getEndereco()->getPontoReferencia()."', ";
                $strSQL .= "'".$obj->getEndereco()->getBairro()."', ";
                $strSQL .= "'".$obj->getEndereco()->getCidade()."', ";
                $strSQL .= "'".$obj->getEndereco()->getUf()."', ";
                $strSQL .= "'".$obj->getStatus()."', ";
                $strSQL .= " ".$idAreaMinisterial." ";
            $strSQL .= ")";                       
            if(Db::getInstance()->executar($strSQL)){
                $arrObjReunioes = $obj->getReunioes();
                $intID = Db::getInstance()->getLastId();                
                for($intI=0; $intI<count($arrObjReunioes); $intI++){
                    $strSQL = "INSERT INTO ADM_MDR_MINISTERIOS_DIAS_REUNIAO(";
                        $strSQL .= "MIN_ID, ";
                        $strSQL .= "DIA_ID, ";
                        $strSQL .= "MDR_Horario";
                    $strSQL .= ")VALUES(";
                        $strSQL .= $intID.", ";
                        $strSQL .= $arrObjReunioes[$intI]->getDiaSemana()->getId().", ";
                        $strSQL .= "'".$arrObjReunioes[$intI]->getHorario()."' ";                                          
                    $strSQL .= ")";                    
                    Db::getInstance()->executar($strSQL);
                }                
                return true;
            }
        }
        
        public function alterar(Ministerio $obj){
            $idAreaMinisterial = "(NULL)";
            if($obj->getObjAreaMinisterial()->getId() > 0){
                $idAreaMinisterial = $obj->getObjAreaMinisterial()->getId();
            }
            $strSQL = "UPDATE ADM_MIN_MINISTERIOS  SET ";
                $strSQL .= "MIN_Descricao = '".$obj->getDescricao()."', ";
                $strSQL .= "MIN_Observacao = '".$obj->getObservacao()."', ";                
                $strSQL .= "MIN_EnderecoCep = '".$obj->getEndereco()->getCep()."', ";
                $strSQL .= "MIN_EnderecoLogradouro = '".$obj->getEndereco()->getLogradouro()."', ";
                $strSQL .= "MIN_EnderecoNumero = '".$obj->getEndereco()->getNumero()."', ";
                $strSQL .= "MIN_EnderecoComplemento = '".$obj->getEndereco()->getComplemento()."', ";
                $strSQL .= "MIN_EnderecoPontoReferencia = '".$obj->getEndereco()->getPontoReferencia()."', ";
                $strSQL .= "MIN_EnderecoBairro = '".$obj->getEndereco()->getBairro()."', ";
                $strSQL .= "MIN_EnderecoCidade = '".$obj->getEndereco()->getCidade()."', ";
                $strSQL .= "MIN_EnderecoUf = '".$obj->getEndereco()->getUf()."', ";
                $strSQL .= "MIN_Status = '".$obj->getStatus()."', ";                
                $strSQL .= "AMI_ID = ".$idAreaMinisterial." ";
            $strSQL .= "WHERE MIN_ID = ".$obj->getId();            
            if(Db::getInstance()->executar($strSQL)){
                $strSQL = "DELETE FROM ADM_MDR_MINISTERIOS_DIAS_REUNIAO WHERE MIN_ID = ".$obj->getId();                
                if(Db::getInstance()->executar($strSQL)){
                    $arrObjReunioes = $obj->getReunioes();
                    for($intI=0; $intI<count($arrObjReunioes); $intI++){
                        $strSQL = "INSERT INTO ADM_MDR_MINISTERIOS_DIAS_REUNIAO(";
                            $strSQL .= "MIN_ID, ";
                            $strSQL .= "DIA_ID, ";
                            $strSQL .= "MDR_Horario";
                        $strSQL .= ")VALUES(";
                            $strSQL .= $obj->getId().", ";
                            $strSQL .= $arrObjReunioes[$intI]->getDiaSemana()->getId().", ";
                            $strSQL .= "'".$arrObjReunioes[$intI]->getHorario()."' ";                                          
                        $strSQL .= ")";
                        Db::getInstance()->executar($strSQL);
                    }
                    
                    return true;
                }
            }            
        }
        
        public function consultarReuniao($arrStrFiltros){
            $strSQL  = "SELECT * FROM ADM_MDR_MINISTERIOS_DIAS_REUNIAO AS DR ";
            $strSQL .= "INNER JOIN CAD_DIA_DIAS_SEMANA AS D ON (D.DIA_ID = DR.DIA_ID) ";
            $strSQL .= "WHERE DR.MIN_ID = ".$arrStrFiltros["MIN_ID"];            
            return Db::getInstance()->select($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM ADM_MIN_MINISTERIOS WHERE MIN_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>