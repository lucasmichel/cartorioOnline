<?php
    // codificação utf-8
    class RepoContaPagarReceber{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoContaPagarReceber();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM FIN_CON_CONTAS AS C "; 
            $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS P ON (P.PLA_ID=C.PLA_ID) ";
            $strSQL .= "INNER JOIN FIN_CEN_CENTROS_CUSTO AS CC ON (CC.CEN_ID=C.CEN_ID) ";
            $strSQL .= "WHERE C.CON_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["CON_ID"])){
                $strSQL .= "AND C.CON_ID = ".trim($arrStrFiltros["CON_ID"])." ";
            }
            
            if(!empty($arrStrFiltros["CEN_ID"])){
                $strSQL .= "AND C.CEN_ID = ".$arrStrFiltros["CEN_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["PLA_ID"])){
                $strSQL .= "AND C.PLA_ID = ".$arrStrFiltros["PLA_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["CON_Tipo"])){
                $strSQL .= "AND C.CON_Tipo = '".trim($arrStrFiltros["CON_Tipo"])."' ";
            }

            if(!empty($arrStrFiltros["CON_EntidadeID"])){
                if(!empty($arrStrFiltros["CON_TipoEntidade"])){
                    if($arrStrFiltros["CON_TipoEntidade"] == "P"){                        
                        $strSQL .= "AND C.PES_ID = ".$arrStrFiltros["CON_EntidadeID"]." ";
                    }else{
                        $strSQL .= "AND C.FOR_ID = ".$arrStrFiltros["CON_EntidadeID"]." ";
                    }
                }
            }
            
            if(isset($arrStrFiltros["CON_DataInicial"]) && isset($arrStrFiltros["CON_DataFinal"])){
                $strSQL .= " AND C.CON_ID IN (SELECT CON_ID FROM FIN_PCL_PARCELAS ";
                $strSQL .= "WHERE PCL_DataVencimento BETWEEN '".$arrStrFiltros["CON_DataInicial"]."' ";
                $strSQL .= "AND '".$arrStrFiltros["CON_DataFinal"]."') ";
            } 
            
            if(isset($arrStrFiltros["CON_Status"])){
                if($arrStrFiltros["CON_Status"] == "A"){
                    $strSQL .= " AND C.CON_ID IN (SELECT CON_ID FROM FIN_PCL_PARCELAS ";
                    $strSQL .= "WHERE PCL_DataBaixa IS NULL)";
                }else{
                    $strSQL .= " AND C.CON_ID NOT IN (SELECT CON_ID FROM FIN_PCL_PARCELAS ";
                    $strSQL .= "WHERE PCL_DataBaixa IS NULL)";
                }
            }
            
            $strSQL .= "ORDER BY C.CON_DataHoraCadastro DESC ";
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            } 
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(ContaPagarReceber $obj){
            $strSQL = "INSERT INTO FIN_CON_CONTAS (";
                $strSQL .= "PLA_ID, ";
                $strSQL .= "CEN_ID, ";
                $strSQL .= "USU_Cadastro_ID, ";
                $strSQL .= "PES_ID,";
                $strSQL .= "FOR_ID, ";
                $strSQL .= "CON_Descricao, ";               
                $strSQL .= "CON_Numero, ";                
                $strSQL .= "CON_ValorTotal, ";
                $strSQL .= "CON_Observacao, ";
                $strSQL .= "CON_Tipo, ";
                $strSQL .= "CON_NumeroParcelas, ";
                $strSQL .= "CON_Foto1, ";                
                $strSQL .= "CON_DataHoraCadastro, ";                
                $strSQL .= "CON_Foto2 ";                
            $strSQL .= ")VALUES(";
                $strSQL .= $obj->getPlanoConta()->getId().", ";
                $strSQL .= $obj->getCentroCusto()->getId().", ";
                $strSQL .= $_SESSION["USUARIO_ID"].", ";
                
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
                
                //$strSQL .= $obj->getFornecedor()->getId().", ";
                $strSQL .= "'".$obj->getDescricao()."', ";                
                $strSQL .= "'".$obj->getNumero()."', ";                
                $strSQL .= $obj->getValorTotal().", ";
                $strSQL .= "'".$obj->getObservacao()."', ";
                $strSQL .= "'".$obj->getTipo()."', ";
                $strSQL .= $obj->getNumeroParcelas().", ";
                $strSQL .= "'".$obj->getFoto1()."', ";                
                $strSQL .= "'".date("Y-m-d H:i:s")."', ";                
                $strSQL .= "'".$obj->getArquivo()."' ";                
            $strSQL .= ")";
            
            if(Db::getInstance()->executar($strSQL)){
                $intId = Db::getInstance()->getLastId();
                
                $arrObjParcelas = $obj->getParcelas();
                
                // grava as parcelas
                for($intI=0; $intI<count($arrObjParcelas); $intI++){
                    $strSQL = "INSERT INTO FIN_PCL_PARCELAS(";
                        $strSQL .= "CON_ID,";
                        $strSQL .= "PCL_DataVencimento,";
                        $strSQL .= "PCL_Valor,";
                        $strSQL .= "PCL_Numero,";
                        $strSQL .= "PCL_DataHoraCadastro";
                    $strSQL .= ")VALUES(";
                        $strSQL .= $intId.",";
                        $strSQL .= "'".$arrObjParcelas[$intI]->getDataVencimento()."',";
                        $strSQL .= $arrObjParcelas[$intI]->getValor().",";
                        $strSQL .= "'".$arrObjParcelas[$intI]->getNumero()."',";
                        $strSQL .= "'".date("Y-m-d H:i:s")."'";
                    $strSQL .= ")";
                    
                    Db::getInstance()->executar($strSQL);
                }
            }    
            
            return true;
        }
        
        public function alterar(ContaPagarReceber $obj){
            $strSQL = "UPDATE FIN_CON_CONTAS SET ";
                /*$strSQL .= "PES_ID = ".$obj->getPessoa()->getId().", ";
                $strSQL .= "FOR_ID = ".$obj->getFornecedor()->getId().", ";*/
            
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
            
                $strSQL .= "PLA_ID = ".$obj->getPlanoConta()->getId().", ";
                $strSQL .= "CEN_ID = ".$obj->getCentroCusto()->getId().", ";                
                $strSQL .= "CON_Descricao = '".$obj->getDescricao()."', ";                
                $strSQL .= "CON_Numero = '".$obj->getNumero()."', ";               
                $strSQL .= "CON_ValorTotal = ".$obj->getValorTotal().", ";                
                $strSQL .= "CON_Observacao = '".$obj->getObservacao()."', ";
                $strSQL .= "USU_Alteracao_ID = ".$_SESSION["USUARIO_ID"].", ";
                
                 // garente que seja colocado o número de parcelas
                // reais pois o usuário só poderá alterar o número de parcelas e salvar
                // dessa forma garantimos que sempre será o número de linhas mesmo que o usuário coloque um valor diferente
                $strSQL .= "CON_NumeroParcelas = ".count($obj->getParcelas()).", ";
                $strSQL .= "CON_Foto1 = '".$obj->getFoto1()."', ";                
                $strSQL .= "CON_DataHoraAlteracao = '".date("Y-m-d H:i:s")."', ";                
                $strSQL .= "CON_Foto2 = '".$obj->getArquivo()."' ";                                
            $strSQL .= "WHERE CON_ID = ".$obj->getId();
            
            if(Db::getInstance()->executar($strSQL)){
                $intId = $obj->getId();
                
                // remove as parcelas e insere novamente
                $strSQL = "DELETE FROM FIN_PCL_PARCELAS WHERE CON_ID=".$intId; 
                
                if(Db::getInstance()->executar($strSQL)){                
                    $arrObjParcelas = $obj->getParcelas();

                    // grava as parcelas
                    for($intI=0; $intI<count($arrObjParcelas); $intI++){
                        $strSQL = "INSERT INTO FIN_PCL_PARCELAS(";
                            $strSQL .= "CON_ID,";
                            $strSQL .= "PCL_DataVencimento,";
                            $strSQL .= "PCL_Valor,";
                            $strSQL .= "PCL_Numero,";
                            $strSQL .= "PCL_DataHoraCadastro";
                        $strSQL .= ")VALUES(";
                            $strSQL .= $intId.",";
                            $strSQL .= "'".$arrObjParcelas[$intI]->getDataVencimento()."',";
                            $strSQL .= $arrObjParcelas[$intI]->getValor().",";
                            $strSQL .= "'".$arrObjParcelas[$intI]->getNumero()."',";
                            $strSQL .= "'".date("Y-m-d H:i:s")."'";
                        $strSQL .= ")";

                        Db::getInstance()->executar($strSQL);
                    }
                }
            }
            
            return true;
        }
        
        public function excluir(ContaPagarReceber $obj){
            $strSQL  = "DELETE FROM FIN_PCL_PARCELAS ";            
            $strSQL .= "WHERE CON_ID = ".$obj->getId();
            
            if(Db::getInstance()->executar($strSQL)){
                $strSQL  = "DELETE FROM FIN_CON_CONTAS ";            
                $strSQL .= "WHERE CON_ID = ".$obj->getId();
            }
            
            return true;
        }
        
        public function consultarProximoVencimento($arrStrFiltros){
            $strSQL = "SELECT MIN(PCL_DataVencimento) AS PCL_DataProximoVencimento FROM FIN_PCL_PARCELAS WHERE CON_ID = ".$arrStrFiltros["CON_ID"]." ";
            $strSQL .= "AND PCL_DataBaixa IS NULL";
            return Db::getInstance()->select($strSQL);
        }
        
        public function consultarParcelas($arrStrFiltros){
            $strSQL = "SELECT * FROM FIN_PCL_PARCELAS WHERE PCL_ID IS NOT NULL ";
            
            if(!empty($arrStrFiltros["CON_ID"])){
                $strSQL .= "AND CON_ID = ".$arrStrFiltros["CON_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["PCL_ID"])){
                $strSQL .= "AND PCL_ID = ".$arrStrFiltros["PCL_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["PCL_ParcelaPaga"])){
                $strSQL .= "AND PCL_DataBaixa IS NOT NULL ";
            }
            
            if(!empty($arrStrFiltros["PCL_ParcelaAberta"])){
                $strSQL .= "AND PCL_DataBaixa IS NULL ";
            }
            
            if(!empty($arrStrFiltros["CON_Tipo"])){
                $strSQL .= "AND CON_ID IN (SELECT CON_ID FROM FIN_CON_CONTAS WHERE CON_Tipo = '".$arrStrFiltros["CON_Tipo"]."') ";
            }
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function pagarParcela(ParcelaContaPagarReceber $obj){
            $strSQL = "UPDATE FIN_PCL_PARCELAS SET ";
                $strSQL .= "FPG_ID = ".$obj->getFormaPagamento()->getId().", ";
                $strSQL .= "PCL_FormaPagamentoNumero = '".$obj->getFormaPagamentoNumero()."', ";
                $strSQL .= "COB_ID = ".$obj->getContaBancaria()->getId().", ";
                $strSQL .= "PCL_DataBaixa = '".$obj->getDataBaixa()."', ";
                $strSQL .= "PCL_Juros = ".$obj->getJuros().", ";
                $strSQL .= "PCL_Mora = ".$obj->getMora().", ";
                $strSQL .= "PCL_Multa = ".$obj->getMulta().", ";
                $strSQL .= "PCL_Desconto = ".$obj->getMulta().", ";
                $strSQL .= "PCL_ValorPago = ".$obj->getValorPago().", ";
                $strSQL .= "PCL_Referencia = '".$obj->getReferencia()."', ";
                $strSQL .= "PCL_DataHoraAlteracao = '".date("Y-m-d H:i:s")."', ";
                $strSQL .= "PCL_Arquivo = '".$obj->getAnexoArquivo()."' ";
            $strSQL .= "WHERE PCL_ID = ".$obj->getId();    
                        
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluirArquivoFisico($idConta){
            $strSQL = "UPDATE FIN_CON_CONTAS SET ";                
                $strSQL .= "CON_Foto1 = '', ";                
                $strSQL .= "CON_DataHoraAlteracao = '".date("Y-m-d H:i:s")."' ";                                
            $strSQL .= "WHERE CON_ID = ".$idConta;
            
            if(Db::getInstance()->executar($strSQL)){
                
            }
        }
            
    }
?>