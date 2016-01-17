<?php
    // codificação utf-8
    class RepoGrupo{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoGrupo();
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
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM CAD_GRU_GRUPOS_USUARIOS "; 
            $strSQL .= "WHERE GRU_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["GRU_ID"])){
                $strSQL .= "AND GRU_ID = ".trim($arrStrFiltros["GRU_ID"])." ";
            }

            if(!empty($arrStrFiltros["GRU_Descricao"])){
                $strSQL .= "AND GRU_Descricao LIKE  '%".trim($arrStrFiltros["GRU_Descricao"])."%' ";
            }
            
            if(!empty($arrStrFiltros["GRU_Status"])){
                $strSQL .= "AND GRU_Status = '".$arrStrFiltros["GRU_Status"]."' ";
            }
            
            // o grupo Administrador n�o � pra ser exibido para os outros usu�rios
            if(isset($_SESSION["USUARIO_ID"])){
                if($_SESSION["USUARIO_ID"] <> -1){
                    if($_SESSION["USUARIO_ID"] <> -2){ // corresponde ao usuário SUPORTE.MS
                        $strSQL .= "AND GRU_ID <> -1 AND GRU_ID <> -2 ";
                    }else{
                        $strSQL .= "AND GRU_ID <> -1 ";
                    }
                }
            }
            
            $strSQL .= "ORDER BY GRU_Descricao";

            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Grupo $obj){
            $strSQL = "INSERT INTO CAD_GRU_GRUPOS_USUARIOS (";
                $strSQL .= "GRU_Descricao, ";
                $strSQL .= "GRU_Status ";
            $strSQL .= ")VALUES(";
            $strSQL .= "'".$obj->getDescricao()."', ";
                $strSQL .= "'".$obj->getStatus()."'";
            $strSQL .= ")";
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(Grupo $obj){
            $strSQL  = "UPDATE CAD_GRU_GRUPOS_USUARIOS SET ";
            $strSQL .= "GRU_Descricao = '".$obj->getDescricao()."', ";
            $strSQL .= "GRU_Status = '".$obj->getStatus()."' ";
            $strSQL .= "WHERE GRU_ID = ".$obj->getId(); 
            
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM CAD_GRU_GRUPOS_USUARIOS WHERE GRU_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>