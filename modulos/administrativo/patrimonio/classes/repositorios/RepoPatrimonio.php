<?php
    // codificação utf-8
    class RepoPatrimonio{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoPatrimonio();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strSQL = "SELECT COUNT(P.PTM_ID) AS Total FROM PAT_PTM_PATRIMONIOS AS P ";
            }else{
                
                if(!empty($arrStrFiltros["GRID"])){
                    $strColunasConsultadas = "P.PTM_ID ,";
                    $strColunasConsultadas.= "P.TIP_ID ,";
                    $strColunasConsultadas.= "P.FRA_ID,";
                    $strColunasConsultadas.= "P.USU_Cadastro_ID,";
                    $strColunasConsultadas.= "P.USU_Alteracao_ID,";
                    $strColunasConsultadas.= "P.IPT_ID,";
                    $strColunasConsultadas.= "P.UNI_Localizacao_ID,";
                    $strColunasConsultadas.= "P.PTM_NumeroTombamento,";
                    $strColunasConsultadas.= "P.PTM_DataAquisicao,";
                    $strColunasConsultadas.= "P.PTM_DataHoraCadastro,";
                    $strColunasConsultadas.= "P.PTM_DataHoraAlteracao,";
                    $strColunasConsultadas.= "P.PTM_DataExpiracaoGarantia,";
                    $strColunasConsultadas.= "P.PTM_Observacao,";
                    $strColunasConsultadas.= "P.PTM_Condicao,";
                    $strColunasConsultadas.= "P.PTM_ValorEstimado,";
                    $strColunasConsultadas.= "P.PTM_Numero,";
                    $strColunasConsultadas.= "P.PTM_Descricao,";
                    $strColunasConsultadas.= "P.PTM_Quantidade,";
                    $strColunasConsultadas.= "P.PTM_Fabricante,";
                    $strColunasConsultadas.= "P.FOR_ID,";
                    $strColunasConsultadas.= "P.PTM_NumeroDocumento,";
                    
                    $strColunasConsultadas.= "TP.*,";
                    $strColunasConsultadas.= "IP.*,";
                    $strColunasConsultadas.= "A.*,";
                    $strColunasConsultadas.= "FORN.*,";
                    $strColunasConsultadas.= "CONGREGACAO.*,";
                    
                    
                    $strColunasConsultadas.= "USUARIO_CADASTRO.USU_Login AS Usuario_Cadastro, ";
                    $strColunasConsultadas.= "USUARIO_CADASTRO.USU_ID AS Usuario_Cadastro_Id, ";

                    $strColunasConsultadas.= "USUARIO_ALTERACAO.USU_Login AS Usuario_Alteracao, ";
                    $strColunasConsultadas.= "USUARIO_ALTERACAO.USU_ID AS Usuario_Alteracao_Id ";                        
                    
                }else{
                    $strColunasConsultadas = "*, USUARIO_CADASTRO.USU_Login AS Usuario_Cadastro, ";
                    $strColunasConsultadas.= "USUARIO_CADASTRO.USU_ID AS Usuario_Cadastro_Id, ";

                    $strColunasConsultadas.= "USUARIO_ALTERACAO.USU_Login AS Usuario_Alteracao, ";
                    $strColunasConsultadas.= "USUARIO_ALTERACAO.USU_ID AS Usuario_Alteracao_Id ";                        
                }
                
                
                
                
                
                $strSQL = "SELECT ".$strColunasConsultadas." FROM PAT_PTM_PATRIMONIOS AS P ";
                $strSQL.= "INNER JOIN PAT_TIP_TIPOS_PATRIMONIOS TP ON (TP.TIP_ID = P.TIP_ID) ";
                $strSQL.= "INNER JOIN PAT_IPT_ITENS_PATRIMONIAIS IP ON (IP.IPT_ID = P.IPT_ID) ";
                $strSQL.= "INNER JOIN PAT_FRA_FORMAS_AQUISICAO A ON (A.FRA_ID = P.FRA_ID) ";
                $strSQL.= "INNER JOIN FIN_FOR_FORNECEDORES FORN ON (FORN.FOR_ID = P.FOR_ID) ";
                
                $strSQL.= "INNER JOIN CAD_USU_USUARIOS AS USUARIO_CADASTRO ON (USUARIO_CADASTRO.USU_ID = P.USU_Cadastro_ID) ";
                $strSQL.= "LEFT JOIN CAD_USU_USUARIOS AS USUARIO_ALTERACAO ON (USUARIO_ALTERACAO.USU_ID = P.USU_Alteracao_ID) ";         
                $strSQL.= "LEFT JOIN ADM_UNI_UNIDADES AS CONGREGACAO ON (CONGREGACAO.UNI_ID = P.UNI_Localizacao_ID) ";         
            }   
            $strSQL .= "WHERE P.PTM_ID IS NOT NULL ";
 
            
            if(!empty($arrStrFiltros["PTM_ID"])){
                $strSQL .= "AND P.PTM_ID = ".$arrStrFiltros["PTM_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["PTM_ID_IMPRESSAO"])){
                $strSQL .= "AND ".$arrStrFiltros["PTM_ID_IMPRESSAO"]." ";
            }
            
            if(!empty($arrStrFiltros["TIP_ID"])){
                $strSQL .= "AND P.TIP_ID = ".$arrStrFiltros["TIP_ID"]." ";
            }
            
            if(!empty($arrStrFiltros["IPT_ID"])){
                $strSQL .= "AND P.IPT_ID = ".$arrStrFiltros["IPT_ID"]." ";
            }
               
            if(!empty($arrStrFiltros["PTM_Condicao"])){
                $strSQL .= "AND P.PTM_Condicao = '".$arrStrFiltros["PTM_Condicao"]."' ";
            }
            
            if(!empty($arrStrFiltros["PTM_Situacao"])){
                $strSQL .= "AND P.PTM_Situacao = '".$arrStrFiltros["PTM_Situacao"]."' ";
            }
            if(!empty($arrStrFiltros["PTM_Descricao"])){
                $strSQL .= "AND P.PTM_Descricao LIKE '%".$arrStrFiltros["PTM_Descricao"]."%' ";                
            }
            
            if(!empty($arrStrFiltros["REL_Grupo"])){
                $strSQL .= " GROUP BY P.TIP_ID ";
            }
             
            if(empty($arrStrFiltros["TOT_Total"])&& empty($arrStrFiltros["REL_Grupo"])){
                $strSQL .= "GROUP BY P.PTM_ID ";                
                $strSQL .= "ORDER BY TP.TIP_Descricao ";            
            }
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            return Db::getInstance()->select($strSQL);
        }

        /*public function consultarSintetico($arrStrFiltros){
            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strSQL = "SELECT COUNT(P.PTM_ID) AS Total FROM PAT_PTM_PATRIMONIOS AS P ";
            }else{
                $strSQL = "SELECT * FROM PAT_PTM_PATRIMONIOS AS P ";
                $strSQL.= "INNER JOIN PAT_TIP_TIPOS_PATRIMONIOS TP ON (TP.TIP_ID = P.TIP_ID) ";
                $strSQL.= "INNER JOIN PAT_IPT_ITENS_PATRIMONIAIS IP ON (IP.IPT_ID = P.IPT_ID) ";
                $strSQL.= "INNER JOIN PAT_FRA_FORMAS_AQUISICAO A ON (A.FRA_ID = P.FRA_ID) ";
            }
             
            $strSQL .= "WHERE P.PTM_ID IS NOT NULL ";
 
               
            if(empty($arrStrFiltros["TOT_Total"])&& empty($arrStrFiltros["REL_Grupo"])){
                $strSQL .= "GROUP BY P.PTM_ID ";
                
                $strSQL .= "ORDER BY TP.TIP_Descricao ";
            
            }
            
        }*/

        public function salvar(Patrimonio $obj){
            
            $dataAquisicao = "(NULL)";
            $dataExpiraGarantia = "(NULL)";
            
            if($obj->getDataAquisicao() != ""){
                $dataAquisicao = "'".$obj->getDataAquisicao()."'";
            }
            
            if($obj->getDataExpiracaoGarantia() != ""){
                $dataExpiraGarantia = "'".$obj->getDataExpiracaoGarantia()."'";
            }
            
            $strSQL = "INSERT INTO PAT_PTM_PATRIMONIOS ( ";
            $strSQL.= "TIP_ID,	";
            $strSQL.= "FRA_ID,	";
            $strSQL.= "USU_Cadastro_ID,	";
            $strSQL.= "IPT_ID, ";
            $strSQL.= "UNI_Localizacao_ID, ";
            
            $strSQL.= "PTM_NumeroTombamento, ";            
            $strSQL.= "PTM_DataAquisicao, ";            
            $strSQL.= "PTM_DataHoraCadastro, ";            
            $strSQL.= "PTM_DataExpiracaoGarantia, ";
            
            $strSQL.= "PTM_Observacao, ";            
            $strSQL.= "PTM_Condicao, ";
            $strSQL.= "PTM_ValorEstimado, ";
            
            $strSQL.= "PTM_Descricao, ";
            $strSQL.= "PTM_Quantidade, ";
            $strSQL.= "PTM_Foto, ";
            $strSQL.= "PTM_Fabricante, ";
            $strSQL.= "FOR_ID, ";
            $strSQL.= "PTM_NumeroDocumento ";
            $strSQL.= ") ";
            $strSQL.= "VALUES(";             
            $strSQL.= $obj->getTipoPatrimonio()->getId().", ";            
            $strSQL.= $obj->getFormaAquisicao()->getId().", ";
            $strSQL.= $obj->getUsuarioCadastro()->getId().", ";
            $strSQL.= $obj->getItemPatrimonio()->getId().", ";
            $strSQL.= $obj->getCongregacao()->getId().", ";
            
            $strSQL.= "'".$obj->getNumeroTombamento()."', ";
            $strSQL.= " ".$dataAquisicao.", ";
            $strSQL.= "'".date("Y-m-d H:m:s")."', ";
            $strSQL.= " ".$dataExpiraGarantia.", ";
            
            $strSQL.= "'".$obj->getObservacao()."', ";
            $strSQL.= "'".$obj->getCondicao()."', ";
            $strSQL.= "".$obj->getValorEstimado().", ";
            
            $strSQL.= "'".$obj->getDescricao()."', ";
            $strSQL.= "".$obj->getQuantidade().", ";
            $strSQL.= "'".$obj->getFoto()."', ";
            $strSQL.= "'".$obj->getFabricante()."', ";
            $strSQL.= " ".$obj->getFornecedor()->getId().", ";            
            $strSQL.= "'".$obj->getNumeroDocumento()."' ";
            $strSQL.= ") ";

            if(Db::getInstance()->executar($strSQL)){
                $intID = Db::getInstance()->getLastId(); // id do patrimonio criado
                
                // serve para gerar o número de tombamento
                // este número deve possuir sequência
                // pelo Tipo de Patromônio e Item do Patrimônio
                // o número do tombamento deverá respeitar o layout abaixo
                // TIP_ID(3 num).IPT_ID(4 num).PTM_Numero(4 num).DIGITO VERIFICADOR
                // Ex.: 007.0001.0008.X
                $strSQL  = "SELECT MAX(PTM_Numero) AS PTM_Numero FROM PAT_PTM_PATRIMONIOS ";
                $strSQL .= "WHERE TIP_ID = ".$obj->getTipoPatrimonio()->getId()." ";
                $strSQL .= "AND IPT_ID = ".$obj->getItemPatrimonio()->getId();
                
                $arrStrDados = Db::getInstance()->select($strSQL);                
                $intUltimoNumero = 1;
                
                if(count($arrStrDados) > 0){
                    if($arrStrDados[0]["PTM_Numero"] != ""){                        
                        $intUltimoNumero = intval($arrStrDados[0]["PTM_Numero"]) + 1;
                    }                    
                }
                
                // gera o número como string para identificar o dígito verificador
                // depois que montar o número, o mesmo é convertido para geração do dígito
                $strNumero = $obj->getTipoPatrimonio()->getId().$obj->getItemPatrimonio()->getId().$intUltimoNumero;
                $strDigito = NumeroHelper::getInstance()->modulo11($strNumero);
                     
                // monta o número do tombamento
                $strNumeroTombamento  = NumeroHelper::getInstance()->completarComZero($obj->getTipoPatrimonio()->getId(), 3);
                $strNumeroTombamento .= NumeroHelper::getInstance()->completarComZero($obj->getItemPatrimonio()->getId(), 4);
                $strNumeroTombamento .= NumeroHelper::getInstance()->completarComZero($intUltimoNumero, 4);
                $strNumeroTombamento .= $strDigito;
                
                $strSQL  = "UPDATE PAT_PTM_PATRIMONIOS SET ";
                $strSQL .= "PTM_Numero = ".$intUltimoNumero.", ";                    
                $strSQL .= "PTM_NumeroTombamento = '".$strNumeroTombamento."' ";
                $strSQL .= "WHERE PTM_ID = ".$intID;
                
                Db::getInstance()->executar($strSQL);                
            }

            return true;
        }

        public function alterar(Patrimonio $obj){            
            $strSQL = "UPDATE PAT_PTM_PATRIMONIOS SET ";
            $strSQL.= " TIP_ID=".$obj->getTipoPatrimonio()->getId().", ";
            $strSQL.= " FRA_ID=".$obj->getFormaAquisicao()->getId().", ";
            $strSQL.= " USU_Alteracao_ID=".$obj->getUsuarioAlteracao()->getId().", ";
            $strSQL.= " IPT_ID = ".$obj->getItemPatrimonio()->getId().", ";
            $strSQL.= " UNI_Localizacao_ID=".$obj->getCongregacao()->getId().", ";            
            $strSQL.= " PTM_DataAquisicao='".$obj->getDataAquisicao()."', ";
            $strSQL.= " PTM_DataHoraAlteracao='".date("Y-m-d H:m:s")."', ";
            $strSQL.= " PTM_DataExpiracaoGarantia='".$obj->getDataExpiracaoGarantia()."', ";
            $strSQL.= " PTM_Observacao='".$obj->getObservacao()."', ";
            $strSQL.= " PTM_Condicao='".$obj->getCondicao()."', ";
            $strSQL.= " PTM_ValorEstimado=".$obj->getValorEstimado().", ";            
            $strSQL.= " PTM_Descricao='".$obj->getDescricao()."', ";
            $strSQL.= " PTM_Quantidade=".$obj->getQuantidade().", ";
            $strSQL.= " PTM_Foto='".$obj->getFoto()."', ";
            $strSQL.= " PTM_Fabricante='".$obj->getFabricante()."', ";
            $strSQL.= " FOR_ID=".$obj->getFornecedor()->getId().", ";
            $strSQL.= " PTM_NumeroDocumento= '".$obj->getNumeroDocumento()."' ";
            $strSQL.= " WHERE PTM_ID = ".$obj->getId();
            
            //echo $strSQL;
            return Db::getInstance()->executar($strSQL); 
        } 
        
        public function excluir($obj){
            $strSQL  = "DELETE FROM PAT_PTM_PATRIMONIOS ";            
            $strSQL .= "WHERE PTM_ID = ".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
        
        public function contarCampo($arrStrFiltros){
            $strSQL  = "SELECT COUNT(".$arrStrFiltros["PTM_Campo"].") AS Total FROM PAT_PTM_PATRIMONIOS AS P ";
            $strSQL .= "WHERE P.".$arrStrFiltros["PTM_Campo"]." = '".$arrStrFiltros["PTM_CampoValor"]."' ";
            $strSQL .= "AND P.IPT_ID = ".$arrStrFiltros["IPT_ID"]." ";
            
            return Db::getInstance()->select($strSQL);
        }
    }
?>