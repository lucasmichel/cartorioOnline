<?php
    // codificação utf-8
    class RepoParametro{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new RepoParametro();
            }

            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){
            $strColunasConsultadas  = "*";
            
            if(!empty($arrStrFiltros["TOT_Total"])){
                $strColunasConsultadas = " COUNT(*) AS Total ";
            }
            
            $strSQL = "SELECT ".$strColunasConsultadas." FROM CAD_PAR_PARAMETROS ";
            
            return Db::getInstance()->select($strSQL);
        }
        
        public function salvar(Parametro $obj){     
            $arrStr = $this->consultar(null);
            
            if(count($arrStr) > 0){
                $strSQL  = "UPDATE CAD_PAR_PARAMETROS SET ";
                $strSQL .= "PAR_CNPJ = '".$obj->getCnpj()."', ";
                $strSQL .= "PAR_RazaoSocial = '".$obj->getRazaoSocial()."', ";
                $strSQL .= "PAR_NomeFantasia = '".$obj->getNomeFantasia()."', ";
                $strSQL .= "PAR_Denominacao = '".$obj->getDenominacao()."', ";    
                $strSQL .= "PAR_Site = '".$obj->getSite()."', ";
                $strSQL .= "PAR_Pastor = '".$obj->getPastor()."', ";
                $strSQL .= "PAR_EnderecoLogradouro = '".$obj->getEnderecoLogradouro()."', ";
                $strSQL .= "PAR_EnderecoNumero = '".$obj->getEnderecoNumero()."', ";
                $strSQL .= "PAR_EnderecoComplemento = '".$obj->getEnderecoComplemento()."', ";
                $strSQL .= "PAR_EnderecoBairro = '".$obj->getEnderecoBairro()."', ";
                $strSQL .= "PAR_EnderecoCidade = '".$obj->getEnderecoCidade()."', ";
                $strSQL .= "PAR_EnderecoUf = '".$obj->getEnderecoUf()."', ";
                $strSQL .= "PAR_EnderecoCep = '".$obj->getEnderecoCep()."', ";
                $strSQL .= "PAR_Logo = '".$obj->getLogo()."', ";
                $strSQL .= "PAR_TotFolhaLivro = '".$obj->getTotFolhaLivro()."', ";
                $strSQL .= "PAR_TotLinhaFolha = '".$obj->getTotLinhaFolha()."' ";                
            }else{
                $strSQL  = "INSERT INTO CAD_PAR_PARAMETROS(";
                    $strSQL .= "PAR_CNPJ,";
                    $strSQL .= "PAR_RazaoSocial,";
                    $strSQL .= "PAR_NomeFantasia,";
                    $strSQL .= "PAR_Denominacao,";
                    $strSQL .= "PAR_Site,";
                    $strSQL .= "PAR_Pastor,";
                    $strSQL .= "PAR_EnderecoLogradouro,";
                    $strSQL .= "PAR_EnderecoNumero,";
                    $strSQL .= "PAR_EnderecoComplemento,";
                    $strSQL .= "PAR_EnderecoBairro,";
                    $strSQL .= "PAR_EnderecoCidade,";
                    $strSQL .= "PAR_EnderecoUf,";
                    $strSQL .= "PAR_EnderecoCep,";
                    $strSQL .= "PAR_Logo,";
                    $strSQL .= "PAR_TotFolhaLivro,";
                    $strSQL .= "PAR_TotLinhaFolha";
                    
                $strSQL .= ")VALUES(";
                    $strSQL .= "'".$obj->getCnpj()."', ";
                    $strSQL .= "'".$obj->getRazaoSocial()."', ";
                    $strSQL .= "'".$obj->getNomeFantasia()."', ";
                    $strSQL .= "'".$obj->getDenominacao()."', ";
                    $strSQL .= "'".$obj->getSite()."', ";
                    $strSQL .= "'".$obj->getPastor()."', ";
                    $strSQL .= "'".$obj->getEnderecoLogradouro()."', ";
                    $strSQL .= "'".$obj->getEnderecoNumero()."', ";
                    $strSQL .= "'".$obj->getEnderecoComplemento()."', ";
                    $strSQL .= "'".$obj->getEnderecoBairro()."', ";
                    $strSQL .= "'".$obj->getEnderecoCidade()."', ";
                    $strSQL .= "'".$obj->getEnderecoUf()."', ";
                    $strSQL .= "'".$obj->getEnderecoCep()."', ";
                    $strSQL .= "'".$obj->getLogo()."', ";
                    $strSQL .= "'".$obj->getTotFolhaLivro()."', ";
                    $strSQL .= "'".$obj->getTotLinhaFolha()."' ";
                $strSQL .= ")";
            }
            
            return Db::getInstance()->executar($strSQL);
        }
    }
?>
