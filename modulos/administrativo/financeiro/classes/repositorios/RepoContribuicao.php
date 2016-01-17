<?php
    // codificação utf-8
    class RepoContribuicao{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoContribuicao();
            }

            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){
            $strColunasConsultadas  = "*";
            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(CTB.CTB_ID) AS Total";
            }   
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM FIN_CTB_CONTRIBUICOES AS CTB ";            
            $strSQL .= "LEFT JOIN CAD_PES_PESSOAS AS PES ON (PES.PES_ID = CTB.PES_ID) ";
            
            $strSQL .= "INNER JOIN FIN_FPG_FORMAS_PAGAMENTOS AS FPG ON (FPG.FPG_ID = CTB.FPG_ID) ";            
            $strSQL .= "INNER JOIN FIN_COB_CONTAS_BANCARIAS AS COB ON (COB.COB_ID = CTB.COB_ID) ";            
            $strSQL .= "INNER JOIN FIN_CEN_CENTROS_CUSTO AS CEN ON (CEN.CEN_ID = CTB.CEN_ID) "; 
            $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PLA ON (PLA.PLA_ID = CTB.PLA_ID) "; 
            $strSQL .= "WHERE CTB.CTB_ID IS NOT NULL ";            
            
            if(!empty($arrStrFiltros["CTB_ID"])){
                $strSQL .= "AND CTB.CTB_ID = ".$arrStrFiltros["CTB_ID"]." ";
            }            

            if(!empty($arrStrFiltros["PES_ID"])){
                if($arrStrFiltros["PES_ID"] == "N/I"){
                    // busca as contribuições NAO IDENTIFICADAS
                    $strSQL .= "AND CTB.PES_ID IS NULL ";
                }else{
                    $strSQL .= "AND CTB.PES_ID = ".$arrStrFiltros["PES_ID"]." ";
                }
            }
            if ( (!empty($_POST["CTB_DataInicial"])) && (!empty($_POST["CTB_DataFinal"])) ){
                $strSQL .= "AND CTB.CTB_DataContribuicao BETWEEN '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["CTB_DataInicial"])."' AND '".DataHelper::getInstance()->converterDataUsuarioParaDataBanco($_POST["CTB_DataFinal"])."' ";
            }
            if(!empty($arrStrFiltros["PLA_ID"])){
                $strSQL .= "AND CTB.PLA_ID=".$arrStrFiltros["PLA_ID"]." ";
            }  
            if(!empty($arrStrFiltros["LOT_ID"])){
                $strSQL .= "AND CTB.LOT_ID=".$arrStrFiltros["LOT_ID"]." ";
            }  
            if(!empty($arrStrFiltros["CEN_ID"])){
                $strSQL .= "AND CTB.CEN_ID=".$arrStrFiltros["CEN_ID"]." ";
            }
            if(!empty($arrStrFiltros["COB_ID"])){
                $strSQL .= "AND CTB.COB_ID=".$arrStrFiltros["COB_ID"]." ";
            }
            
            $strSQL .= "ORDER BY CTB.CTB_DataContribuicao DESC ";
                
            if(!empty($arrStrFiltros["limit"]) && !empty($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }  
                        
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Contribuicao $obj){
            $intIdLote = "(NULL)";
            if($obj->getLote()->getId() > 0){
                $intIdLote = "'".$obj->getLote()->getId()."'";
            }
            $strSQL  = "INSERT INTO FIN_CTB_CONTRIBUICOES(";
                $strSQL .= "CEN_ID, ";
                $strSQL .= "COB_ID, ";
                $strSQL .= "PES_ID, ";
                $strSQL .= "FPG_ID, ";
                $strSQL .= "PLA_ID, ";
                $strSQL .= "LOT_ID, ";
                $strSQL .= "CTB_DataContribuicao, ";
                $strSQL .= "CTB_Referencia, ";
                $strSQL .= "CTB_Valor, ";
                $strSQL .= "CTB_Observacao, ";
                $strSQL .= "CTB_DataHoraCadastro, ";
                $strSQL .= "USU_Cadastro_ID ";                
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
                $strSQL .= " ".$obj->getFormaPagamento()->getId().", ";
                $strSQL .= " ".$obj->getPlanoConta()->getId().", ";
                $strSQL .= " ".$intIdLote.", ";
                $strSQL .= "'".$obj->getData()."', ";
                $strSQL .= "'".$obj->getReferencia()."', ";
                $strSQL .= " ".$obj->getValor().", ";
                $strSQL .= "'".$obj->getObservacao()."', ";
                $strSQL .= "'".date("Y-m-d H:i:s")."', ";                
                $strSQL .= " ".$_SESSION["USUARIO_ID"]." ";                
            $strSQL .= ")";   
            
            return Db::getInstance()->executar($strSQL);            
        }
        
        public function alterar(Contribuicao $obj){            
            $intIdLote = "(NULL)";
            if($obj->getLote()->getId() > 0){
                $intIdLote = "'".$obj->getLote()->getId()."'";
            }
            $strSQL  = "UPDATE FIN_CTB_CONTRIBUICOES SET ";
            $strSQL .= "CEN_ID=".$obj->getCentroCusto()->getId().", ";
            $strSQL .= "COB_ID=".$obj->getContaBancaria()->getId().", ";            
            if($obj->getPessoa() == null){
                $strSQL .= "PES_ID=(NULL), ";
            }elseif($obj->getPessoa()->getId() == ""){
                $strSQL .= "PES_ID=(NULL), ";
            }else{
                $strSQL .= "PES_ID=".$obj->getPessoa()->getId().", ";
            }
            $strSQL .= "FPG_ID=".$obj->getFormaPagamento()->getId().", ";
            $strSQL .= "LOT_ID=".$intIdLote.", ";
            $strSQL .= "CTB_DataContribuicao='".$obj->getData()."', "; 
            $strSQL .= "CTB_Referencia='".$obj->getReferencia()."', "; 
            $strSQL .= "CTB_Valor=".$obj->getValor().", ";
            $strSQL .= "CTB_Observacao='".$obj->getObservacao()."', ";
            $strSQL .= "USU_Alteracao_ID=".$_SESSION["USUARIO_ID"].", ";
            $strSQL .= "CTB_DataHoraAlteracao = '".date("Y-m-d H:i:s")."' ";
            $strSQL .= "WHERE CTB_ID=".$obj->getId(). " "; 
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(Contribuicao $obj){
            $strSQL  = "DELETE FROM FIN_CTB_CONTRIBUICOES ";            
            $strSQL .= "WHERE CTB_ID = ".$obj->getId();            
            return Db::getInstance()->executar($strSQL);
        }
    }
?>