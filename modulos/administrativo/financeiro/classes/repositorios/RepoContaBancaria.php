<?php
    // codificação utf-8
    class RepoContaBancaria{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoContaBancaria();
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
            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM FIN_COB_CONTAS_BANCARIAS AS CB ";
            $strSQL .= "INNER JOIN FIN_BAN_BANCOS AS B ON (B.BAN_ID=CB.BAN_ID) ";
            $strSQL .= "WHERE CB.COB_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["COB_ID"])){
                $strSQL .= "AND CB.COB_ID = ".trim($arrStrFiltros["COB_ID"])." ";
            }

            if(!empty($arrStrFiltros["COB_Descricao"])){
                $strSQL .= "AND CB.COB_Descricao LIKE  '%".trim($arrStrFiltros["COB_Descricao"])."%' ";
            }
            
            if(!empty($arrStrFiltros["BAN_ID"])){
                $strSQL .= "AND CB.BAN_ID =  ".$arrStrFiltros["BAN_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["COB_Status"])){
                $strSQL .= "AND CB.COB_Status = '".$arrStrFiltros["COB_Status"]."' ";
            }
            
            $strSQL .= "ORDER BY COB_Descricao";

            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(ContaBancaria $obj){
            $strSQL = "INSERT INTO FIN_COB_CONTAS_BANCARIAS (";
                $strSQL .= "BAN_ID, ";                
                $strSQL .= "COB_Descricao, ";                
                $strSQL .= "COB_DataAbertura, ";                
                $strSQL .= "COB_Agencia, ";
                $strSQL .= "COB_Conta, ";
                $strSQL .= "COB_SaldoInicial, ";                
                $strSQL .= "COB_Observacao, ";
                $strSQL .= "COB_DataHoraCadastro, ";
                $strSQL .= "USU_Cadastro_ID, ";
                $strSQL .= "COB_Status ";
            $strSQL .= ")VALUES(";
                $strSQL .= $obj->getBanco()->getId().", ";                
                $strSQL .= "'".$obj->getDescricao()."', ";
                
                $strDataAbertura = "(NULL)";
                
                if($obj->getDataAbertura() != ""){
                    if(trim($obj->getDataAbertura()) != ""){
                        $strDataAbertura = "'".$obj->getDataAbertura()."'";
                    }
                }
                
                $strSQL .= $strDataAbertura.", ";
                $strSQL .= "'".$obj->getAgencia()."', ";
                $strSQL .= "'".$obj->getConta()."', ";
                $strSQL .= $obj->getSaldoInicial().", ";
                $strSQL .= "'".$obj->getObservacao()."', ";
                $strSQL .= "'".date("Y-m-d H:i:s")."', ";
                $strSQL .= $_SESSION["USUARIO_ID"].", ";
                $strSQL .= "'".$obj->getStatus()."'";
            $strSQL .= ")";
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(ContaBancaria $obj){
            $strSQL  = "UPDATE FIN_COB_CONTAS_BANCARIAS SET ";
            $strSQL .= "BAN_ID = ".$obj->getBanco()->getId().", ";            
            $strSQL .= "COB_Descricao = '".$obj->getDescricao()."', ";
            $strSQL .= "COB_DataAbertura = '".$obj->getDataAbertura()."', ";
            $strSQL .= "COB_Agencia = '".$obj->getAgencia()."', ";
            $strSQL .= "COB_Conta = '".$obj->getConta()."', ";
            $strSQL .= "COB_SaldoInicial = ".$obj->getSaldoInicial().", ";
            $strSQL .= "COB_Observacao = '".$obj->getObservacao()."', ";
            $strSQL .= "COB_DataHoraAlteracao = '".date("Y-m-d H:i:s")."', ";
            $strSQL .= "USU_Alteracao_ID = ".$_SESSION["USUARIO_ID"].", ";
            $strSQL .= "COB_Status = '".$obj->getStatus()."' ";
            $strSQL .= "WHERE COB_ID = ".$obj->getId(); 
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM FIN_COB_CONTAS_BANCARIAS WHERE COB_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
        
        
        
        
        
        public function consultarSaldoContaBancaria(ContaBancaria $obj){            
            $douValorTotalEntrada = 0;
            $douValorTotalSaida = 0;
            
            //valor inicial da conta
            $strSQL  = "SELECT COB_SaldoInicial FROM FIN_COB_CONTAS_BANCARIAS ";
            $strSQL .= "WHERE COB_ID = ".$obj->getId()." ";
            $arrStrDados = Db::getInstance()->select($strSQL);
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    if(trim($arrStrDados[0]["COB_SaldoInicial"]) != ""){
                        $douValorTotalEntrada += $arrStrDados[0]["COB_SaldoInicial"];
                    }
                }
            }
            
            
            //entradas fluxo de caixa
            $strSQL  = "SELECT SUM(LCA_Valor) AS LCA_ValorTotal FROM FIN_LCA_LANCAMENTOS_CAIXA WHERE COB_ID = ".$obj->getId()." ";            
            $strSQL .= " AND LCA_Tipo = 'E' ";
            $arrStrDados = Db::getInstance()->select($strSQL);
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    if(trim($arrStrDados[0]["LCA_ValorTotal"]) != ""){
                        $douValorTotalEntrada += $arrStrDados[0]["LCA_ValorTotal"];
                    }
                }
            }
            
            // saidas fluxo de caixa            
            $strSQL  = "SELECT SUM(LCA_Valor) AS LCA_ValorTotal FROM FIN_LCA_LANCAMENTOS_CAIXA WHERE COB_ID = ".$obj->getId()." ";            
            $strSQL .= " AND LCA_Tipo = 'S' ";
            $arrStrDados = Db::getInstance()->select($strSQL);
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    if(trim($arrStrDados[0]["LCA_ValorTotal"]) != ""){
                        $douValorTotalSaida += $arrStrDados[0]["LCA_ValorTotal"];
                    }
                }
            }
            
            // entradas contas a pagar            
            $strSQL  = "SELECT SUM(P.PCL_Valor) AS PCL_ValorTotal FROM FIN_PCL_PARCELAS AS P ";
            $strSQL .= "INNER JOIN FIN_CON_CONTAS AS C ON (C.CON_ID=P.CON_ID) ";
            $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
            $strSQL .= "WHERE P.COB_ID = ".$obj->getId()." ";            
            $strSQL .= "AND PC.PLA_Movimentacao = 'E' ";
            $arrStrDados = Db::getInstance()->select($strSQL);
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    if(trim($arrStrDados[0]["PCL_ValorTotal"]) != ""){
                        $douValorTotalEntrada += $arrStrDados[0]["PCL_ValorTotal"];
                    }
                }
            }
            
            // saidas contas a pagar            
            $strSQL  = "SELECT SUM(P.PCL_Valor) AS PCL_ValorTotal FROM FIN_PCL_PARCELAS AS P ";
            $strSQL .= "INNER JOIN FIN_CON_CONTAS AS C ON (C.CON_ID=P.CON_ID) ";
            $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
            $strSQL .= "WHERE P.COB_ID = ".$obj->getId()." ";            
            $strSQL .= "AND PC.PLA_Movimentacao = 'S' ";
            $arrStrDados = Db::getInstance()->select($strSQL);
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    if(trim($arrStrDados[0]["PCL_ValorTotal"]) != ""){
                        $douValorTotalSaida += $arrStrDados[0]["PCL_ValorTotal"];
                    }
                }
            }
            
            // Contribuições            
            $strSQL  = "SELECT SUM(CTB_Valor) AS CTB_ValorTotal FROM FIN_CTB_CONTRIBUICOES AS C ";
            $strSQL .= "INNER JOIN FIN_PLA_PLANOS_CONTAS AS PC ON (PC.PLA_ID=C.PLA_ID) ";
            $strSQL .= "WHERE C.COB_ID = ".$obj->getId()." ";            
            $strSQL .= " AND PC.PLA_Movimentacao = 'E' ";
            $arrStrDados = Db::getInstance()->select($strSQL);
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    if(trim($arrStrDados[0]["CTB_ValorTotal"]) != ""){
                        $douValorTotalEntrada += $arrStrDados[0]["CTB_ValorTotal"];
                    }
                }
            }
            
            
            // Transferencias Entradas
            $strSQL  = "SELECT SUM(TRC_Valor) AS TRC_ValorTotal FROM FIN_TRC_TRANSFERENCIAS_CONTAS ";            
            $strSQL .= "WHERE COB_Para_ID = ".$obj->getId()." ";                        
            $arrStrDados = Db::getInstance()->select($strSQL);
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    if(trim($arrStrDados[0]["TRC_ValorTotal"]) != ""){
                        $douValorTotalEntrada += $arrStrDados[0]["TRC_ValorTotal"];
                    }
                }
            }
            
            // Transferencias Saidas
            $strSQL  = "SELECT SUM(TRC_Valor) AS TRC_ValorTotal FROM FIN_TRC_TRANSFERENCIAS_CONTAS ";            
            $strSQL .= "WHERE COB_De_ID = ".$obj->getId()." ";                        
            $arrStrDados = Db::getInstance()->select($strSQL);
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    if(trim($arrStrDados[0]["TRC_ValorTotal"]) != ""){
                        $douValorTotalSaida += $arrStrDados[0]["TRC_ValorTotal"];
                    }
                }
            }
            return ($douValorTotalEntrada - $douValorTotalSaida);
            
        }
    }
?>