<?php
    // codificação utf-8
    class RepoMembro{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoMembro();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            
            $strColunasConsultadas  = "P.*, M.*, MS.*";
            
            if(!empty($arrStrFiltros["GRID"])){
                $strColunasConsultadas  = "P.PES_ID, P.PES_Nome, P.PES_CPF, P.PES_Matricula, P.PES_DataHoraAlteracao, ";
                $strColunasConsultadas .= "P.PES_DataNascimento, MS.MES_Descricao, M.MEM_Tipo ";
            }

            // $arrStrFiltros["TOT_Total"] é true ou false
            // criada para pegar o total de registros quando houver
            // necessidade de paginação
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = " COUNT(P.PES_ID) AS Total ";
            }   
            
            
            
            $strSQL  = "SELECT ".$strColunasConsultadas." FROM CAD_PES_PESSOAS AS P ";             
            $strSQL .= "INNER JOIN ADM_MEM_MEMBROS AS M ON (P.PES_ID = M.PES_ID) ";            
            $strSQL .= "INNER JOIN ADM_MES_MEMBROS_STATUS AS MS ON (M.MES_ID = MS.MES_ID) ";            
            
            /*if(isset($arrStrFiltros["MembroNaoFuncionario"])){
                $strSQL .= "WHERE M.PES_ID NOT IN (SELECT PES_Membro_ID FROM RH_FUN_FUNCIONARIOS ) ";                
            }*/
            
            if(isset($arrStrFiltros["MembroNaoFornecedor"])){
                $strSQL .= "WHERE M.PES_ID NOT IN (SELECT PES_ID FROM FIN_FOR_FORNECEDORES WHERE PES_ID IS NOT NULL) ";                
            }else{
                $strSQL .= "WHERE M.PES_ID IS NOT NULL ";
            }
            
            
            if(isset($arrStrFiltros["PES_MesAniversario"])){                
                $strSQL .= "AND MONTH(P.PES_DataNascimento) = '".$arrStrFiltros["PES_MesAniversario"]."' " ; 
            }
            if(isset($arrStrFiltros["PES_Matricula"])){
                $strSQL .= "AND P.PES_Matricula = '".trim($arrStrFiltros["PES_Matricula"])."' ";
            }
            if(isset($arrStrFiltros["PES_ID"])){
                $strSQL .= "AND M.PES_ID = ".trim($arrStrFiltros["PES_ID"])." ";
            }
            if(isset($arrStrFiltros["PES_Nome"])){
                if(trim($arrStrFiltros["PES_Nome"]) != ""){
                    $strSQL .= "AND P.PES_Nome LIKE  '%".trim($arrStrFiltros["PES_Nome"])."%' ";
                }
            }
            if(isset($arrStrFiltros["MES_ID"])){
                if(trim($arrStrFiltros["MES_ID"]) != ""){
                    $strSQL .= "AND M.MES_ID = ".$arrStrFiltros["MES_ID"]." ";
                }
            }
            if(isset($arrStrFiltros["NES_ID"])){
                if(trim($arrStrFiltros["NES_ID"]) != ""){
                    $strSQL .= "AND P.NES_ID = ".$arrStrFiltros["NES_ID"]." ";
                }
            }
            if(isset($arrStrFiltros["PES_Sexo"])){
                if(trim($arrStrFiltros["PES_Sexo"]) != ""){
                    $strSQL .= "AND P.PES_Sexo = '".$arrStrFiltros["PES_Sexo"]."' ";
                }
            }
            if(isset($arrStrFiltros["ECV_ID"])){
                if(trim($arrStrFiltros["ECV_ID"]) != ""){
                    $strSQL .= "AND P.ECV_ID = ".$arrStrFiltros["ECV_ID"]." ";
                }
            }
            if(isset($arrStrFiltros["MEM_Tipo"])){
                if(trim($arrStrFiltros["MEM_Tipo"]) != ""){
                    $strSQL .= "AND M.MEM_Tipo = '".$arrStrFiltros["MEM_Tipo"]."' ";
                }
            }
            if(isset($arrStrFiltros["UNI_ID"])){
                if(trim($arrStrFiltros["UNI_ID"]) != "TODOS"){
                    // o que indica que os membros pertencem a SEDE
                    // é o UNI_ID NULO
                    // se pertencer a uma congregação o valor virá em UNI_ID
                    if($arrStrFiltros["UNI_ID"] == ""){
                        $strSQL .= "AND M.UNI_ID IS NULL ";
                    }else{
                        $strSQL .= "AND M.UNI_ID = ".$arrStrFiltros["UNI_ID"]." ";
                    }                    
                }
            }
            if(isset($arrStrFiltros["PESQ_Por"])){
                if(trim($arrStrFiltros["PESQ_Por"]) == "NOME"){
                    if(trim($arrStrFiltros["PESQ_Campo"]) != ""){
                        $strSQL .= " AND P.PES_Nome LIKE _utf8 '%".$arrStrFiltros["PESQ_Campo"]."%' COLLATE utf8_unicode_ci ";
                    }
                }elseif(trim($arrStrFiltros["PESQ_Por"]) == "FICHA"){
                    $strSQL .= " AND M.MEM_NumeroFicha='".$arrStrFiltros["PESQ_Campo"]."' ";
                }elseif(trim($arrStrFiltros["PESQ_Por"]) == "MATRICULA"){
                    $strSQL .= " AND P.PES_Matricula='".$arrStrFiltros["PESQ_Campo"]."' ";
                }
            }
            
            if(!isset($arrStrFiltros["PES_MesAniversario"])){
                $strSQL .= " ORDER BY P.PES_Nome ";
            }else{
                $strSQL .= " ORDER BY DAY(P.PES_DataNascimento), MONTH(P.PES_DataNascimento) ";
            }
            
            if(isset($arrStrFiltros["limit"]) && isset($arrStrFiltros["offset"])){
                $strSQL .= " LIMIT ".$arrStrFiltros["offset"].", ".$arrStrFiltros["limit"];
            }            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Membro $obj){                     
            $intCongregacao       = "(NULL)";      
            $intAreaAtuacao       = "(NULL)";
            $intIdRendaSalario    = "(NULL)";
                        
            if($obj->getRendaSalario()->getId() > 0){
                $intIdRendaSalario = $obj->getRendaSalario()->getId();
            }
            if($obj->getCongregacao()->getId() > 0){
                $intCongregacao = $obj->getCongregacao()->getId();
            }
            if($obj->getAreaDeAtuacao()->getId() > 0){
                $intAreaAtuacao = $obj->getAreaDeAtuacao()->getId();
            }
            
            $strDataInativacao = "(NULL)";
            $strMotivoInativacao = "(NULL)";
            $strDescricaoInativacao = "(NULL)";
            $strDataDescricaoInativacao = "(NULL)";
            
            if(trim($obj->getDataInativacao()) != ""){
                $strDataInativacao = "'".$obj->getDataInativacao()."'";
            }            
            if(trim($obj->getMotivoInativacao()) != ""){
                $strMotivoInativacao = "'".$obj->getMotivoInativacao()."'";
            }            
            if(trim($obj->getDescricaoInativacao()) != ""){
                $strDescricaoInativacao = "'".$obj->getDescricaoInativacao()."'";
            }            
            if(trim($obj->getDataDescricaoInativacao()) != ""){
                $strDataDescricaoInativacao = "'".$obj->getDataDescricaoInativacao()."'";
            }
            
            $strSQL = "INSERT INTO ADM_MEM_MEMBROS (";
                $strSQL .= " PES_ID, ";                
                $strSQL .= " MES_ID, ";
                $strSQL .= " UNI_ID, ";                
                $strSQL .= " AAT_ID, ";                
                $strSQL .= " ARS_ID, ";                
                $strSQL .= " MEM_EmpresaNome, ";
                $strSQL .= " MEM_EmpresaTelefoneComercial, ";
                $strSQL .= " MEM_EmpresaTelefoneFax, ";
                $strSQL .= " MEM_EmpresaEnderecoCep, ";
                $strSQL .= " MEM_EmpresaEnderecoLogradouro, ";
                $strSQL .= " MEM_EmpresaEnderecoNumero, ";
                $strSQL .= " MEM_EmpresaEnderecoComplemento, ";
                $strSQL .= " MEM_EmpresaEnderecoPontoReferencia, ";
                $strSQL .= " MEM_EmpresaEnderecoBairro, ";
                $strSQL .= " MEM_EmpresaEnderecoCidade, ";
                $strSQL .= " MEM_EmpresaEnderecoUf, ";
                $strSQL .= " MEM_TemEmprego, ";
                $strSQL .= " MEM_Profissao, ";                                
                $strSQL .= " MEM_NumeroFicha, ";   
                $strSQL .= " MEM_Tipo, ";   
                $strSQL .= " MEM_MotivoInativacao, ";
                $strSQL .= " MEM_DataInativacao, ";
                $strSQL .= " MEM_DescricaoInativacao, ";
                $strSQL .= " MEM_DataDescricaoInativacao ";
            $strSQL .= ")VALUES("
            ." ".$obj->getId().", "            
            ." ".$obj->getStatusMembro()->getId().", "            
            ." ".$intCongregacao.", "
            ." ".$intAreaAtuacao.", "
            ." ".$intIdRendaSalario.", "
            ."'".$obj->getEmpresaNome()."', "
            ."'".$obj->getEmpresaTelefoneComercial()."', "
            ."'".$obj->getEmpresaTelefoneFax()."', "
            ."'".$obj->getEnderecoEmpresa()->getCep()."', "
            ."'".$obj->getEnderecoEmpresa()->getLogradouro()."', "
            ."'".$obj->getEnderecoEmpresa()->getNumero()."', "
            ."'".$obj->getEnderecoEmpresa()->getComplemento()."', "
            ."'".$obj->getEnderecoEmpresa()->getPontoReferencia()."', "
            ."'".$obj->getEnderecoEmpresa()->getBairro()."', "
            ."'".$obj->getEnderecoEmpresa()->getCidade()."', "
            ."'".$obj->getEnderecoEmpresa()->getUf()."', "              
            ."'".$obj->getTemEmprego()."', "  
            ."'".$obj->getProfissao()."',"            
            ."'".$obj->getNumeroFicha()."',"
            ."'".$obj->getTipo()."',"
            ."'".$obj->getDataInativacao()."',"
            ."'".$obj->getMotivoInativacao()."',"
            ."'".$obj->getDescricaoInativacao()."',"
            ."'".$obj->getDataDescricaoInativacao()."')";
                    
            return Db::getInstance()->executar($strSQL);
        }
        
        public function alterar(Membro $obj){
            $intCongregacao = "(NULL)";            
            $intAreaAtuacao = "(NULL)";   
            $intIdRendaSalario = "(NULL)";            
            $numeroFicha = "";
            
            if($obj->getRendaSalario()->getId() > 0){
                $intIdRendaSalario = $obj->getRendaSalario()->getId();
            }
            
            if($obj->getCongregacao()->getId() > 0){
                $intCongregacao = $obj->getCongregacao()->getId();
            }
            if($obj->getAreaDeAtuacao()->getId() > 0){
                $intAreaAtuacao = $obj->getAreaDeAtuacao()->getId();
            }
            if($obj->getNumeroFicha() > 0){
                $numeroFicha = $obj->getNumeroFicha();
            }
            
            $strDataInativacao = "(NULL)";
            $strMotivoInativacao = "(NULL)";
            $strDescricaoInativacao = "(NULL)";
            $strDataDescricaoInativacao = "(NULL)";
            
            if(trim($obj->getDataInativacao()) != ""){
                $strDataInativacao = "'".$obj->getDataInativacao()."'";
            }            
            if(trim($obj->getMotivoInativacao()) != ""){
                $strMotivoInativacao = "'".$obj->getMotivoInativacao()."'";
            }            
            if(trim($obj->getDescricaoInativacao()) != ""){
                $strDescricaoInativacao = "'".$obj->getDescricaoInativacao()."'";
            }            
            if(trim($obj->getDataDescricaoInativacao()) != ""){
                $strDataDescricaoInativacao = "'".$obj->getDataDescricaoInativacao()."'";
            }
            
            $strSQL = "UPDATE ADM_MEM_MEMBROS SET 
                      UNI_ID = ".$intCongregacao.",  
                      AAT_ID = ".$intAreaAtuacao.",
                      ARS_ID = ".$intIdRendaSalario.",
                      MES_ID = ".$obj->getStatusMembro()->getId().",
                      MEM_EmpresaNome = '".$obj->getEmpresaNome()."',
                      MEM_EmpresaTelefoneComercial = '".$obj->getEmpresaTelefoneComercial()."',
                      MEM_EmpresaTelefoneFax = '".$obj->getEmpresaTelefoneFax()."',
                      MEM_EmpresaEnderecoCep = '".$obj->getEnderecoEmpresa()->getCep()."',
                      MEM_EmpresaEnderecoLogradouro = '".$obj->getEnderecoEmpresa()->getLogradouro()."',
                      MEM_EmpresaEnderecoNumero = '".$obj->getEnderecoEmpresa()->getNumero()."',
                      MEM_EmpresaEnderecoComplemento = '".$obj->getEnderecoEmpresa()->getComplemento()."',
                      MEM_EmpresaEnderecoPontoReferencia = '".$obj->getEnderecoEmpresa()->getPontoReferencia()."',
                      MEM_EmpresaEnderecoBairro = '".$obj->getEnderecoEmpresa()->getBairro()."',
                      MEM_EmpresaEnderecoCidade = '".$obj->getEnderecoEmpresa()->getCidade()."',
                      MEM_EmpresaEnderecoUf = '".$obj->getEnderecoEmpresa()->getUf()."',  
                      MEM_TemEmprego = '".$obj->getTemEmprego()."', 
                      MEM_Profissao = '".$obj->getProfissao()."',
                      MEM_NumeroFicha = '".$numeroFicha."', 
                      MEM_Tipo = '".$obj->getTipo()."', 
                      MEM_MotivoInativacao = ".$strMotivoInativacao.", 
                      MEM_DataInativacao = ".$strDataInativacao.", 
                      MEM_DescricaoInativacao = ".$strDescricaoInativacao.", 
                      MEM_DataDescricaoInativacao = ".$strDataDescricaoInativacao." ";
                        
            $strSQL.= "WHERE PES_ID = ".$obj->getId()." "; 
            
            return Db::getInstance()->executar($strSQL);            
        }
    }
?>