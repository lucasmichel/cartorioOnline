<?php
    // codificação utf-8
    class RepoCarta{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoCarta();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $strColunasConsultadas  = " *, USUARIO_CADASTRO.*, USUARIO_CADASTRO.USU_Login AS USU_LoginCadastro, ";
            $strColunasConsultadas  .= " USUARIO_ALTERACAO.*, USUARIO_ALTERACAO.USU_Login AS USU_LoginAlteracao ";

            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(*) AS Total";
            }            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM ADM_CAR_CARTAS AS CARTA ";             
            $strSQL .= "INNER JOIN ADM_TCA_TIPOS_CARTAS AS TIPOS_CARTA ON (TIPOS_CARTA.TCA_ID = CARTA.TCA_ID) ";
            $strSQL .= "INNER JOIN CAD_PES_PESSOAS AS PESSOA ON (PESSOA.PES_ID = CARTA.PES_ID) ";            
            $strSQL .= "INNER JOIN CAD_USU_USUARIOS AS USUARIO_CADASTRO ON (USUARIO_CADASTRO.USU_ID = CARTA.USU_Cadastro_ID) ";
            $strSQL .= "LEFT JOIN CAD_USU_USUARIOS AS USUARIO_ALTERACAO ON (USUARIO_ALTERACAO.USU_ID = CARTA.USU_Alteracao_ID) ";            
            $strSQL .= "WHERE CARTA.CAR_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["CAR_ID"])){
                $strSQL .= "AND CARTA.CAR_ID = ".trim($arrStrFiltros["CAR_ID"])." ";
            }
            
            if(!empty($arrStrFiltros["PES_ID"])){
                $strSQL .= "AND CARTA.PES_ID = ".trim($arrStrFiltros["PES_ID"])." ";
            }
            
            if(!empty($arrStrFiltros["TCA_ID"])){
                $strSQL .= "AND TIPOS_CARTA.TCA_ID = ".trim($arrStrFiltros["TCA_ID"])." ";
            }
            
            if(!empty($arrStrFiltros["TCA_Descricao"])){
                $strSQL .= "AND TIPOS_CARTA.TCA_Descricao = ".trim($arrStrFiltros["TCA_Descricao"])." ";
            }

            if(!empty($arrStrFiltros["CAR_Texto"])){
                $strSQL .= "AND CARTA.CAR_Texto LIKE  '%".trim($arrStrFiltros["CAR_Texto"])."%' ";
            }
            
            if(isset($arrStrFiltros["CAR_DataInicial"]) && isset($arrStrFiltros["CAR_DataFinal"])){
                $strSQL .="AND CARTA.CAR_DataHoraCadastro BETWEEN '".$arrStrFiltros["CAR_DataInicial"]." 00:00:00' AND '".$arrStrFiltros["CAR_DataFinal"]." 23:59:59' ";
            }            
            $strSQL .= "ORDER BY CAR_ID DESC";
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }            
                        
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Carta $obj){
            $strSQL = "INSERT INTO ADM_CAR_CARTAS (";
                $strSQL .= "TCA_ID, ";                
                $strSQL .= "USU_Cadastro_ID, ";                
                $strSQL .= "CAR_Texto, ";                
                $strSQL .= "CAR_DataHoraCadastro, ";
                $strSQL .= "PES_ID ";
                
            $strSQL .= ")VALUES(";
            $strSQL .= "".$obj->getTipoCarta()->getId().", ";            
            $strSQL .= "".$obj->getUsuarioCadastro()->getId().", ";            
            $strSQL .= "'".$obj->getTexto()."', ";            
            $strSQL .= "'".$obj->getDataHoraCadastro()."', ";            
            $strSQL .= "".$obj->getObjPessoaCarta()->getId()." ";            
            $strSQL .= ")";            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(Carta $obj){
            $strSQL  = "UPDATE ADM_CAR_CARTAS SET ";
            $strSQL .= "TCA_ID = ".$obj->getTipoCarta()->getId().", ";            
            $strSQL .= "USU_Alteracao_ID = ".$obj->getUsuarioAlteracao()->getId().", ";
            $strSQL .= "CAR_Texto = '".$obj->getTexto()."', ";            
            $strSQL .= "CAR_DataHoraAlteracao = '".$obj->getDataHoraAlteracao()."' ";
            $strSQL .= "PES_ID = ".$obj->getObjPessoaCarta()->getId()." ";
            $strSQL .= "WHERE CAR_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir(Carta $obj){
            $strSQL  = "DELETE FROM ADM_CAR_CARTAS ";            
            $strSQL .= "WHERE CAR_ID = ".$obj->getId()." ";             
            return Db::getInstance()->executar($strSQL);
        }
    }
?>