<?php
    // codificação utf-8
    class RepoUsuario{
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoUsuario();
            }
            
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            $strColunasConsultadas  = "USU.USU_ID, USU.USU_Login, USU.USU_Nome, USU.USU_DataHoraCadastro, ";
            $strColunasConsultadas .= "USU.USU_DataHoraUltimoAcesso, GRU.GRU_ID, GRU.GRU_Descricao, ";
            $strColunasConsultadas .= "USU.USU_Email, USU.USU_Telefone, USU.USU_Status";    
            
            // $arrStrFiltros["USU_ConsultarTotal"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(USU.USU_ID) AS Total";
            }

            $strSQL = "SELECT ".$strColunasConsultadas." FROM CAD_USU_USUARIOS AS USU ";
            $strSQL.= "INNER JOIN CAD_GRU_GRUPOS_USUARIOS AS GRU ON (GRU.GRU_ID = USU.GRU_ID) "; 
            $strSQL.= "WHERE USU.USU_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["USU_ID"])){
                $strSQL .= "AND USU.USU_ID = ".trim($arrStrFiltros["USU_ID"])." ";
            }

            if((!empty($arrStrFiltros["USU_Login"])) && (!empty($arrStrFiltros["USU_Senha"]))){               
                $strSQL .= "AND (USU.USU_Login='".trim($arrStrFiltros["USU_Login"])."' AND USU.USU_Senha='".trim($arrStrFiltros["USU_Senha"])."') ";
            }

            if (!empty($arrStrFiltros["USU_ValidarLogin"])){
                $strSQL .= "AND USU.USU_Login = '".trim($arrStrFiltros["USU_ValidarLogin"])."' ";
            }

            if(isset($arrStrFiltros["USU_Email_EDICAO"])){
                $strSQL .= "AND USU.USU_Email = '".$arrStrFiltros["USU_Email_EDICAO"]."' ";
                $strSQL .= "AND USU.USU_ID <> ".$arrStrFiltros["USU_ID_EDICAO"]." ";
            }
            
            if (!empty($arrStrFiltros["USU_Email"])){
                $strSQL .= "AND USU.USU_Email = '".trim($arrStrFiltros["USU_Email"])."' ";
            }

            if(!empty($arrStrFiltros["USU_Login"])){
                $strSQL .= "AND USU.USU_Login LIKE '".trim($arrStrFiltros["USU_Login"])."%' ";
            }
            
            if(!empty($arrStrFiltros["USU_LoginIgual"])){
                $strSQL .= "AND USU.USU_Login = '".trim($arrStrFiltros["USU_LoginIgual"])."' ";
            }

            if(!empty($arrStrFiltros["USU_Status"])){
                $strSQL .= "AND USU.USU_Status = '".$arrStrFiltros["USU_Status"]."' ";
            }
            
            // o usu�rio Administrador n�o � pra ser exibido para os outros usu�rios
            if(isset($_SESSION["USUARIO_ID"])){
                if($_SESSION["USUARIO_ID"] <> -1){
                    if($_SESSION["USUARIO_ID"] <> -2){ // corresponde ao usuário SUPORTE.MS
                        $strSQL .= "AND USU.USU_ID <> -1 AND USU.USU_ID <> -2 ";
                    }else{
                        $strSQL .= "AND USU.USU_ID <> -1 ";
                    }
                }
            }
            
            $strSQL .= "ORDER BY USU.USU_Login ";
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }       
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function registrarAcesso($arrStrDados){
            $strSQL  = "INSERT INTO CAD_USA_USUARIOS_ACESSOS (USU_ID, USA_DataHora) VALUES (".$arrStrDados["USU_ID"].", '".$arrStrDados["USA_DataHora"]."')";            
            
            if(Db::getInstance()->executar($strSQL)){
                $strSQL  = "UPDATE CAD_USU_USUARIOS SET USU_DataHoraUltimoAcesso='".$arrStrDados["USA_DataHora"]."' ";
                $strSQL .= "WHERE USU_ID=".$arrStrDados["USU_ID"];
                
                Db::getInstance()->executar($strSQL);
            }
        }        

        public function salvar(Usuario $obj){
            $strSQL  = "INSERT INTO CAD_USU_USUARIOS(";
                $strSQL .= "GRU_ID, USU_Nome, USU_Login, ";
                $strSQL .= "USU_Senha, USU_Email, ";
                $strSQL .= "USU_Telefone, USU_DataHoraCadastro, ";
                $strSQL .= "USU_Status";
            $strSQL .= ")VALUES (".$obj->getGrupo()->getId().", '".$obj->getNome()."', '".$obj->getLogin()."', ";
                $strSQL .= "'".$obj->getSenha()."', '".$obj->getEmail()."', ";
                $strSQL .= "'".$obj->getTelefone()."', '".$obj->getDataHoraCadastro()."', ";
                $strSQL .= "'".$obj->getStatus()."'";
            $strSQL .= ")";
                     
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar($obj){            
            $strSQL  = "UPDATE CAD_USU_USUARIOS SET ";
            $strSQL .= "GRU_ID=".$obj->getGrupo()->getId().", USU_Nome = '".$obj->getNome()."', USU_Login='".$obj->getLogin()."', ";
            $strSQL .= "USU_Email='".$obj->getEmail()."', USU_Telefone = '".$obj->getTelefone()."', ";
            $strSQL .= "USU_Status='".$obj->getStatus()."' ";
            $strSQL .= "WHERE USU_ID=".$obj->getId();
                       
            return Db::getInstance()->executar($strSQL);
        }
        
        public function consultarUsuarioSenha($arrStrFiltros){
            

            $strSQL = "SELECT * FROM CAD_USU_USUARIOS AS USU ";
            $strSQL.= "WHERE USU.USU_ID IS NOT NULL ";

            if(!empty($arrStrFiltros["USU_ID"])){
                $strSQL .= "AND USU.USU_ID = ".trim($arrStrFiltros["USU_ID"])." ";
            }
   
            if(!empty($arrStrFiltros["USU_Senha"])){
                $strSQL .= "AND USU.USU_Senha = '".$arrStrFiltros["USU_Senha"]."' ";
            }
            
                $strSQL .= "ORDER BY USU.USU_Login ";
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){                
                $strSQL .= "LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }       
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function alterarSenha($arrStrDados){            
            $strSQL  = "UPDATE CAD_USU_USUARIOS SET ";
            $strSQL .= "USU_Senha='".$arrStrDados["USU_Nova_Senha"]."' "; 
            $strSQL .= "WHERE USU_ID=".$arrStrDados["USU_ID"];
                       
            return Db::getInstance()->executar($strSQL);
        }
        
        public function excluir($obj){
            $strSQL = "DELETE FROM CAD_USU_USUARIOS WHERE USU_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }
    }
?>