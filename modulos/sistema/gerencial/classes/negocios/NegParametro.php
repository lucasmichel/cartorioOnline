<?php
    // codificação utf-8
    class NegParametro{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegParametro();
            }

            return self::$objInstance;
        }
        
        public function consultar($arrStrFiltros){
            $arrStrDados = RepoParametro::getInstance()->consultar($arrStrFiltros);
            $arrObjParametros = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        $arrObjs[$intI] = $this->factoryParametro($arrStrDados[$intI]);
                    }
                    // responsável por exibir dados na grid
                    $arrObjParametros = array();
                    $arrObjParametros["objects"]  = $arrObjs;
                    $arrObjParametros["rows"]     = $arrStrDados;                    
                    // identifica o total de registros referente a consulta
                    $arrStrFiltrosTotal = array();
                    $arrStrFiltrosTotal["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoParametro::getInstance()->consultar($arrStrFiltrosTotal);                     
                    $arrObjParametros["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            } 

            return $arrObjParametros;
        }
        
        public function factoryParametro($arrStrDados){            
            $objParametro = new Parametro();            
            
            if(isset($arrStrDados["PAR_CNPJ"])){
                $objParametro->setCnpj($arrStrDados["PAR_CNPJ"]);
            }
            if(isset($arrStrDados["PAR_RazaoSocial"])){
                $objParametro->setRazaoSocial($arrStrDados["PAR_RazaoSocial"]);
            }
            if(isset($arrStrDados["PAR_NomeFantasia"])){
                $objParametro->setNomeFantasia($arrStrDados["PAR_NomeFantasia"]);
            }
            if(isset($arrStrDados["PAR_Denominacao"])){
                $objParametro->setDenominacao($arrStrDados["PAR_Denominacao"]);
            }
            if(isset($arrStrDados["PAR_Site"])){
                $objParametro->setSite($arrStrDados["PAR_Site"]);
            }
            if(isset($arrStrDados["PAR_Pastor"])){
                $objParametro->setPastor($arrStrDados["PAR_Pastor"]);
            }
            if(isset($arrStrDados["PAR_EnderecoLogradouro"])){
                $objParametro->setEnderecoLogradouro($arrStrDados["PAR_EnderecoLogradouro"]);
            }
            if(isset($arrStrDados["PAR_EnderecoNumero"])){
                $objParametro->setEnderecoNumero($arrStrDados["PAR_EnderecoNumero"]);
            }
            if(isset($arrStrDados["PAR_EnderecoComplemento"])){
                $objParametro->setEnderecoComplemento($arrStrDados["PAR_EnderecoComplemento"]);
            }
            if(isset($arrStrDados["PAR_EnderecoBairro"])){
                $objParametro->setEnderecoBairro($arrStrDados["PAR_EnderecoBairro"]);
            }
            if(isset($arrStrDados["PAR_EnderecoCidade"])){
                $objParametro->setEnderecoCidade($arrStrDados["PAR_EnderecoCidade"]);
            }
            if(isset($arrStrDados["PAR_EnderecoUf"])){
                $objParametro->setEnderecoUf($arrStrDados["PAR_EnderecoUf"]);
            }
            if(isset($arrStrDados["PAR_EnderecoCep"])){
                $objParametro->setEnderecoCep($arrStrDados["PAR_EnderecoCep"]);
            }
            if(isset($arrStrDados["PAR_Logo"])){
                $objParametro->setLogo($arrStrDados["PAR_Logo"]);
            }
            if(isset($arrStrDados["PAR_TotFolhaLivro"])){
                $objParametro->setTotFolhaLivro($arrStrDados["PAR_TotFolhaLivro"]);
            }
            if(isset($arrStrDados["PAR_TotLinhaFolha"])){
                $objParametro->setTotLinhaFolha($arrStrDados["PAR_TotLinhaFolha"]);
            }
            return $objParametro;
        }
        
        public function salvar($arrStrDados){            
            // grava os telefones
            /*NegParametroFone::getInstance()->excluir();
            if(isset($arrStrDados["DADOS_PARAMETRO_SISTEMA"]["FONES"])){
                if(count($arrStrDados["DADOS_PARAMETRO_SISTEMA"]["FONES"]) > 0){
                    foreach ($arrStrDados["DADOS_PARAMETRO_SISTEMA"]["FONES"] as $arrStrFone) {                        
                        NegParametroFone::getInstance()->salvar($arrStrFone);
                    }
                }
            }
            // grava os e-mails
            NegParametroEmail::getInstance()->excluir();
            if(isset($arrStrDados["DADOS_PARAMETRO_SISTEMA"]["EMAILS"])){
                if(count($arrStrDados["DADOS_PARAMETRO_SISTEMA"]["EMAILS"]) > 0){
                    foreach ($arrStrDados["DADOS_PARAMETRO_SISTEMA"]["EMAILS"] as $arrStrEmail) {                        
                        NegParametroEmail::getInstance()->salvar($arrStrEmail);
                    }
                }
            }*/
            
            $obj = $this->factoryParametro(DadosHelper::getInstance()->prepararDadosSemModificacao($arrStrDados));
            //$obj->setLogo($arrStrDados["PAR_Logo"]);
            
            //var_dump($obj);die();
            
            return RepoParametro::getInstance()->salvar($obj);
        }
    }
?>
