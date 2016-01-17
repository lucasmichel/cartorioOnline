<?php
    // codificação utf-8
    class RepoFuncionario{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoFuncionario();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $strColunasConsultadas  = "*, TIME_FORMAT(FUN_HorarioEntrada, '%H:%i') AS FUN_HorarioEntrada, TIME_FORMAT(FUN_HorarioSaida, '%H:%i') AS FUN_HorarioSaida, ";
            $strColunasConsultadas  .= "USUARIO_CADASTRO.USU_Login AS Usuario_Cadastro, ";
            $strColunasConsultadas  .= "USUARIO_CADASTRO.USU_ID AS Usuario_Cadastro_Id,   ";
            
            $strColunasConsultadas  .= "USUARIO_ALTERACAO.USU_Login AS Usuario_Alteracao,   ";
            $strColunasConsultadas  .= "USUARIO_ALTERACAO.USU_ID AS Usuario_Alteracao_Id   ";

            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = "COUNT(FUNCIONARIO.PES_ID) AS Total";
            }            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM RH_FUN_FUNCIONARIOS AS FUNCIONARIO ";             
            $strSQL .= "INNER JOIN CAD_PES_PESSOAS AS PESSOA ON (PESSOA.PES_ID = FUNCIONARIO.PES_ID) ";                        
            $strSQL .= "LEFT JOIN CAD_ECV_ESTADOS_CIVIS AS ESTADO_CIVIL ON (ESTADO_CIVIL.ECV_ID = PESSOA.ECV_ID) ";
            
            $strSQL .= "LEFT JOIN CAD_NES_NIVEIS_ESCOLARIDADE AS ESCOLARIDADE ON (ESCOLARIDADE.NES_ID = PESSOA.NES_ID) ";            
            $strSQL .= "LEFT JOIN CAD_USU_USUARIOS AS USUARIO ON (USUARIO.USU_ID = PESSOA.USU_Sistema_ID) ";                    
            
            $strSQL .= "INNER JOIN CAD_USU_USUARIOS AS USUARIO_CADASTRO ON (USUARIO_CADASTRO.USU_ID = PESSOA.USU_Cadastro_ID) ";            
            $strSQL .= "LEFT JOIN CAD_USU_USUARIOS AS USUARIO_ALTERACAO ON (USUARIO_ALTERACAO.USU_ID = PESSOA.USU_Alteracao_ID) ";
                       
            
            $strSQL .= "WHERE FUNCIONARIO.PES_ID IS NOT NULL ";

            if(isset($arrStrFiltros["PES_Matricula"])){
                $strSQL .= "AND PESSOA.PES_Matricula = '".trim($arrStrFiltros["PES_Matricula"])."' ";
            }
            
            if(isset($arrStrFiltros["PES_ID"])){
                $strSQL .= "AND FUNCIONARIO.PES_ID = ".trim($arrStrFiltros["PES_ID"])." ";
            }
            
            if(isset($arrStrFiltros["PES_Membro_ID"])){
                $strSQL .= "AND FUNCIONARIO.PES_Membro_ID = ".trim($arrStrFiltros["PES_Membro_ID"])." ";
            }
            
            if(isset($arrStrFiltros["PES_Nome"])){
                $strSQL .= "AND PESSOA.PES_Nome LIKE  '%".trim($arrStrFiltros["PES_Nome"])."%' ";
            }
            
            if(isset($arrStrFiltros["PES_CPF_EDICAO"])){
                $strSQL .= "AND PESSOA.PES_CPF = '".$arrStrFiltros["PES_CPF_EDICAO"]."' ";
                $strSQL .= "AND PESSOA.PES_ID <> ".$arrStrFiltros["PES_ID_EDICAO"]." ";
            }
            
            if(isset($arrStrFiltros["PES_Status"])){
                $strSQL .= "AND PESSOA.PES_Status = '".$arrStrFiltros["PES_Status"]."' ";
            } 
            
            if(isset($arrStrFiltros["NES_ID"])){
                $strSQL .= "AND PESSOA.NES_ID = '".$arrStrFiltros["NES_ID"]."' ";
            } 
            
            if(isset($arrStrFiltros["PES_Sexo"])){
                $strSQL .= "AND PESSOA.PES_Sexo = '".$arrStrFiltros["PES_Sexo"]."' ";
            } 
            
            if(isset($arrStrFiltros["ECV_ID"])){
                $strSQL .= "AND PESSOA.ECV_ID = '".$arrStrFiltros["ECV_ID"]."' ";
            } 
            
            $strSQL .= "ORDER BY PESSOA.PES_Nome";
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }                          
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Funcionario $obj){            
            $intIdMembroId = "(NULL)";
            if($obj->getMembroFuncionario() != null ){
                $intIdMembroId = $obj->getMembroFuncionario()->getId();
            } 
            $strDataAdmissao = "(NULL)";
            if($obj->getDataAdmissao() != null){
                $strDataAdmissao = "'".$obj->getDataAdmissao()."'";
            }
            
            $strDataSaida = "(NULL)";
            if($obj->getDataSaida() != null){
                $strDataSaida = "'".$obj->getDataSaida()."'";
            }            
            $txtSalario = 0;
            if($obj->getSalario()>0){
                $txtSalario = $obj->getSalario();
            }
            $txtHoraEntrada = 00;
            if($obj->getHorarioEntrada()>0){
                $txtHoraEntrada = $obj->getHorarioEntrada();
            }            
            $txtHoraSaida = 00;
            if($obj->getHorarioSaida()>0){
                $txtHoraSaida = $obj->getHorarioSaida();
            }
            
            $strSQL = "INSERT INTO RH_FUN_FUNCIONARIOS (";
                $strSQL .= " PES_ID, ";
                $strSQL .= " PES_Membro_ID, ";
                $strSQL .= " FUN_DataAdmissao, ";
                $strSQL .= " FUN_DataSaida, ";                
                $strSQL .= " FUN_Funcao, ";
                $strSQL .= " FUN_Salario, ";
                $strSQL .= " FUN_CargaHoraria, ";
                $strSQL .= " FUN_HorarioEntrada, ";
                $strSQL .= " FUN_HorarioSaida, ";
                $strSQL .= " FUN_CNHNumero, ";                
                $strSQL .= " FUN_CarteiraTrabalhoNumero ";                
            $strSQL .= ")VALUES("
            ." ".$obj->getIdFuncionario().", "
            ." ".$intIdMembroId.", "
            .$strDataAdmissao.", "
            .$strDataSaida.", "
            ."'".$obj->getFuncao()."', "
            ."".$txtSalario.", "
            ."".$obj->getCargaHoraria().", "
            ."'".$txtHoraEntrada.":00', "
            ."'".$txtHoraSaida.":00', "                    
            ."'".$obj->getCnhNumero()."', "             
            ."'".$obj->getCarteiraTrabalhoNumero()."')";             
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(Funcionario $obj){
            $intIdMembroId = "(NULL)";
            if($obj->getMembroFuncionario() != null){
                if($obj->getMembroFuncionario()->getId() > 0){
                    $intIdMembroId = $obj->getMembroFuncionario()->getId();
                }            
            }
            $txtSalario = 0;
            if($obj->getSalario()>0){
                $txtSalario = $obj->getSalario();
            }            
            $txtHoraEntrada = '00:00';
            if($obj->getHorarioEntrada()>0){
                $txtHoraEntrada = $obj->getHorarioEntrada()."00";
            }            
            $txtHoraSaida = '00:00';
            if($obj->getHorarioSaida()>0){
                $txtHoraSaida = $obj->getHorarioSaida()."00";
            }            
            $strSQL = "UPDATE RH_FUN_FUNCIONARIOS SET                      
                      PES_ID = ".$obj->getIdFuncionario().", 
                      PES_Membro_ID = ".$intIdMembroId.", 
                      FUN_DataAdmissao = '".$obj->getDataAdmissao()."',
                      FUN_DataSaida = '".$obj->getDataSaida()."',
                      FUN_Funcao = '".$obj->getFuncao()."',                          
                      FUN_Salario = ".$txtSalario.",                          
                      FUN_CargaHoraria = '".$obj->getCargaHoraria()."',    
                      FUN_HorarioEntrada = '".$txtHoraEntrada."',    
                      FUN_HorarioSaida = '".$txtHoraSaida."',    
                      FUN_CNHNumero = '".$obj->getCnhNumero()."',
                      FUN_CarteiraTrabalhoNumero = '".$obj->getCarteiraTrabalhoNumero()."' ";
            $strSQL.= "WHERE PES_ID = ".$obj->getId()." ";
            return Db::getInstance()->executar($strSQL);            
        }
        
        /*public function excluir(Funcionario $obj){
            $strSQL = "DELETE FROM RH_FUN_FUNCIONARIOS WHERE PES_ID=".$obj->getId();
            return Db::getInstance()->executar($strSQL);
        }*/
    }
?>