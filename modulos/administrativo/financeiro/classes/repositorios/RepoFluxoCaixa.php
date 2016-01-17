<?php
    // codificação utf-8
    class RepoFluxoCaixa{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoFluxoCaixa();
            }

            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){
            $strColunasConsultadas  = "*";
            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(LCA.LCA_ID) AS Total";
            }   
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM FIN_LCA_LANCAMENTOS_CAIXA AS LCA ";            
            $strSQL .= "LEFT JOIN CAD_PES_PESSOAS AS PES ON (PES.PES_ID = LCA.PES_ID) ";
            $strSQL .= "LEFT JOIN FIN_FOR_FORNECEDORES AS F ON (F.FOR_ID = LCA.FOR_ID) ";
            
            $strSQL .= "INNER JOIN FIN_FPG_FORMAS_PAGAMENTOS AS FPG ON (FPG.FPG_ID = LCA.FPG_ID) ";            
            $strSQL .= "INNER JOIN FIN_COB_CONTAS_BANCARIAS AS COB ON (COB.COB_ID = LCA.COB_ID) ";            
            $strSQL .= "INNER JOIN FIN_CEN_CENTROS_CUSTO AS CEN ON (CEN.CEN_ID = LCA.CEN_ID) "; 
            $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PLA ON (PLA.PLA_ID = LCA.PLA_ID) "; 
            $strSQL .= "WHERE LCA.LCA_ID IS NOT NULL ";            
            
            if(!empty($arrStrFiltros["LCA_ID"])){
                $strSQL .= "AND LCA.LCA_ID = ".$arrStrFiltros["LCA_ID"]." ";
            }            

            if(!empty($arrStrFiltros["LCA_EntidadeID"])){
                if(!empty($arrStrFiltros["LCA_TipoEntidade"])){
                    if($arrStrFiltros["LCA_TipoEntidade"] == "P"){                        
                        $strSQL .= "AND LCA.PES_ID = ".$arrStrFiltros["LCA_EntidadeID"]." ";
                    }else{
                        $strSQL .= "AND LCA.FOR_ID = ".$arrStrFiltros["LCA_EntidadeID"]." ";
                    }
                }
            }
            
            if ( (!empty($_POST["LCA_DataInicial"])) && (!empty($_POST["LCA_DataFinal"])) ){
                $strSQL .= "AND LCA.LCA_DataMovimento BETWEEN '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataInicial"])."' AND '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["LCA_DataFinal"])."' ";
            }
            if(!empty($arrStrFiltros["PLA_ID"])){
                $strSQL .= "AND LCA.PLA_ID=".$arrStrFiltros["PLA_ID"]." ";
            }  
            if(!empty($arrStrFiltros["CEN_ID"])){
                $strSQL .= "AND LCA.CEN_ID=".$arrStrFiltros["CEN_ID"]." ";
            }
            if(!empty($arrStrFiltros["COB_ID"])){
                $strSQL .= "AND LCA.COB_ID=".$arrStrFiltros["COB_ID"]." ";
            }
            if(!empty($arrStrFiltros["LCA_Tipo"])){
                $strSQL .= "AND LCA.LCA_Tipo='".$arrStrFiltros["LCA_Tipo"]."' ";
            }
            if(!empty($arrStrFiltros["LCA_Referencia"])){
                $strSQL .= "AND LCA.LCA_Referencia='".$arrStrFiltros["LCA_Referencia"]."' ";
            }
            
            $strSQL .= "ORDER BY LCA.LCA_DataMovimento DESC ";
                
            if(!empty($arrStrFiltros["limit"]) && !empty($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }  
                        
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(FluxoCaixa $obj){
            $strSQL  = "INSERT INTO FIN_LCA_LANCAMENTOS_CAIXA(";
                $strSQL .= "CEN_ID, ";
                $strSQL .= "COB_ID, ";
                $strSQL .= "PES_ID, ";
                $strSQL .= "FOR_ID, ";
                $strSQL .= "FPG_ID, ";
                $strSQL .= "PLA_ID, ";
                $strSQL .= "LCA_DataMovimento, ";
                $strSQL .= "LCA_Referencia, ";
                $strSQL .= "LCA_Valor, ";
                $strSQL .= "LCA_Observacao, ";
                $strSQL .= "LCA_DataHoraCadastro, ";
                $strSQL .= "USU_Cadastro_ID, ";
                $strSQL .= "LCA_Descricao, ";
                $strSQL .= "LCA_Tipo ";
            $strSQL .= ")VALUES(";            
                $strSQL .= " ".$obj->getCentroCusto()->getId().", ";
                $strSQL .= " ".$obj->getContaBancaria()->getId().", ";
                
                if($obj->getPessoa() == null){
                    $strSQL .= " (NULL), ";
                }elseif($obj->getPessoa()->getId() == ""){
                    $strSQL .= " (NULL), ";
                }else{
                    $strSQL .= " ".$obj->getPessoa()->getId().", ";
                }
                
                if($obj->getFornecedor() == null){
                    $strSQL .= " (NULL), ";
                }elseif($obj->getFornecedor()->getId() == ""){
                    $strSQL .= " (NULL), ";
                }else{
                    $strSQL .= " ".$obj->getFornecedor()->getId().", ";
                }
                                
                $strSQL .= " ".$obj->getFormaPagamento()->getId().", ";
                $strSQL .= " ".$obj->getPlanoConta()->getId().", ";
                $strSQL .= "'".$obj->getData()."', ";
                $strSQL .= "'".$obj->getReferencia()."', ";
                $strSQL .= " ".$obj->getValor().", ";
                $strSQL .= "'".$obj->getObservacao()."', ";
                $strSQL .= "'".date("Y-m-d H:i:s")."', ";                
                $strSQL .= " ".$_SESSION["USUARIO_ID"].", ";
                $strSQL .= " '".$obj->getHistorico()."', ";
                $strSQL .= " '".$obj->getTipo()."' ";
            $strSQL .= ")";   
            
            return Db::getInstance()->executar($strSQL);            
        }
        
        public function alterar(FluxoCaixa $obj){
            $strSQL  = "UPDATE FIN_LCA_LANCAMENTOS_CAIXA SET ";
            $strSQL .= "CEN_ID=".$obj->getCentroCusto()->getId().", ";
            $strSQL .= "COB_ID=".$obj->getContaBancaria()->getId().", ";
            
            if($obj->getPessoa() == null){
                $strSQL .= "PES_ID=(NULL), ";
            }elseif($obj->getPessoa()->getId() == ""){
                $strSQL .= "PES_ID=(NULL), ";
            }else{
                $strSQL .= "PES_ID=".$obj->getPessoa()->getId().", ";
            }
            
            if($obj->getFornecedor() == null){
                $strSQL .= "FOR_ID=(NULL), ";
            }elseif($obj->getFornecedor()->getId() == ""){
                $strSQL .= "FOR_ID=(NULL), ";
            }else{
                $strSQL .= "FOR_ID=".$obj->getFornecedor()->getId().", ";
            }
                        
            $strSQL .= "FPG_ID=".$obj->getFormaPagamento()->getId().", ";            
            $strSQL .= "LCA_DataMovimento='".$obj->getData()."', "; 
            $strSQL .= "LCA_Referencia='".$obj->getReferencia()."', "; 
            $strSQL .= "LCA_Valor=".$obj->getValor().", ";
            $strSQL .= "LCA_Observacao='".$obj->getObservacao()."', ";
            $strSQL .= "USU_Alteracao_ID=".$_SESSION["USUARIO_ID"].", ";
            $strSQL .= "LCA_DataHoraAlteracao = '".date("Y-m-d H:i:s")."', ";
            $strSQL .= "LCA_Descricao = '".$obj->getHistorico()."', ";
            $strSQL .= "LCA_Tipo = '".$obj->getTipo()."' ";
            $strSQL .= "WHERE LCA_ID=".$obj->getId(). " "; 
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(FluxoCaixa $obj){
            $strSQL  = "DELETE FROM FIN_LCA_LANCAMENTOS_CAIXA ";            
            $strSQL .= "WHERE LCA_ID = ".$obj->getId();            
            return Db::getInstance()->executar($strSQL);
        }
    }
?>