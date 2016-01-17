<?php
    // codificação utf-8
    class NegFamilia{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegFamilia();
            }
            
            return self::$objInstance;
        }

       public function consultar($arrStrFiltros){            
            $arrStrDados = RepoFamilia::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);                        
                        if($arrStrDados[$intI]["PES_Secundario_ID"] <= 0){                            
                            $novoNomeSecundario = $arrStrDados[$intI]["FAM_Nome"]." (NÃO MEMBRO)";                            
                            $arrStrDados[$intI]["PES_Nome_Secundario"] = $novoNomeSecundario;
                            $arrStrDados[$intI]["FAM_Nome"] = $novoNomeSecundario;
                            $arrObjs[$intI]->setPessoaSecundarioNome($novoNomeSecundario);
                        }
                    }
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoFamilia::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        public function validarRelacionamentoFamiliar($arrStrFiltros){
            // PES_Secundario_ID não pode ser conjugue de mais ninguem                
            $arrConsultaFamilia["PES_Secundario_ID"] = $arrStrFiltros["PES_Secundario_ID"];
            $arrConsultaFamilia["FAM_GrauParentesco"] = "CÔNJUGE";
            $arrObjFamili = $this->consultar($arrConsultaFamilia);
            if($arrObjFamili == null){
                return true;
            }else{
                $arrObjFamili = $arrObjFamili["objects"];
                $objFamilia = new Familia();
                $objFamilia = $arrObjFamili[0];                    
                $menssagem = "O sistema identificou que ".$objFamilia->getPessoaSecundarioNome()." já se encontra relacionada com ".$objFamilia->getPessoaPrimarioNome();                     
                throw new Exception($menssagem);
            }            
            
        }
        
        private function factory($arrStrDados){
            $obj = new Familia();             
            if(isset($arrStrDados["PES_Primario_ID"])){
                $obj->setPessoaPrimarioId($arrStrDados["PES_Primario_ID"]);
            }
            if(isset($arrStrDados["PES_Nome_Primario"])){
                $obj->setPessoaPrimarioNome($arrStrDados["PES_Nome_Primario"]);
            }            
            if(isset($arrStrDados["PES_Secundario_ID"])){
                $obj->setPessoaSecundarioId($arrStrDados["PES_Secundario_ID"]);
            }
            //if idPessoaSecundaria não preenchido é do tipo não membro
            if(!isset($arrStrDados["PES_Secundario_ID"])){
                if(isset($arrStrDados["FAM_Nome"])){
                    $obj->setPessoaSecundarioNome($arrStrDados["FAM_Nome"]);
                }
            }
            if(isset($arrStrDados["PES_Nome_Secundario"])){
                $obj->setPessoaSecundarioNome($arrStrDados["PES_Nome_Secundario"]);
            }
            if(isset($arrStrDados["FAM_Nome"])){
                if($arrStrDados["FAM_Nome"] != ""){                    
                    $obj->setPessoaSecundarioNome($arrStrDados["FAM_Nome"]);
                }
            }
            if(isset($arrStrDados["FAM_GrauParentesco"])){
                $obj->setGrauParentesco($arrStrDados["FAM_GrauParentesco"]);
            }
            return $obj;
        }
        
        public function excluir($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDados($arrStrDados));
            return RepoFamilia::getInstance()->excluir($obj);
        }
        
        public function salvar($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosSemModificacao($arrStrDados));
            if(RepoFamilia::getInstance()->salvar($obj)){
                if ( ( $arrStrDados["PES_Secundario_ID"] > 0 ) && ( $arrStrDados["PES_Primario_ID"] > 0 ) ){
                    /*gerencia o relacionamento familiar*/
                    switch ($arrStrDados["FAM_GrauParentesco"]) {
                        case "CÔNJUGE":                        
                            //pega o id primario e inverte com o secundario e salva como CÔNJUGE                        
                            return $this->executaAmarracaoConjuge($obj);                        
                        case "FILHO(A)":
                            //pega o id primario e inverte com o secundario e salva como PAI MAE ao depender do sexo
                            return $this->executaAmarracaoFilho($obj);                        
                        case "IRMÃO(Ã)":
                            //pega o id primario e inverte com o secundario e salva como IRMÃO(A)
                            return $this->executaAmarracaoIrmao($obj);                        
                        case "MÃE":                    
                            //pega o id primario e inverte com o secundario e salva como FILHO(A)
                            return $this->executaAmarracaoMae($obj);                        
                        case "PAI":
                            //pega o id primario e inverte com o secundario e salva como FILHO(A)                        
                            return $this->executaAmarracaoPai($obj);                        
                    }
                    /*gerencia o relacionamento familiar*/            
                }
            }
        }
        
        private function executaAmarracaoPai(Familia $objDados){
            //pega o id primario e inverte com o secundario e salva como FILHO(A)            
            $novaFamia = new Familia();
            $novaFamia->setGrauParentesco("FILHO(A)");
            $novaFamia->setPessoaPrimarioId($objDados->getPessoaSecundarioId());
            $novaFamia->setPessoaSecundarioId($objDados->getPessoaPrimarioId());
            return RepoFamilia::getInstance()->salvar($novaFamia);
        }
        
        private function executaAmarracaoMae(Familia $objDados){
            //pega o id primario e inverte com o secundario e salva como FILHO(A)
            $novaFamia = new Familia();
            $novaFamia->setGrauParentesco("FILHO(A)");
            $novaFamia->setPessoaPrimarioId($objDados->getPessoaSecundarioId());
            $novaFamia->setPessoaSecundarioId($objDados->getPessoaPrimarioId());
            return RepoFamilia::getInstance()->salvar($novaFamia);
        }
        
        
        private function executaAmarracaoIrmao(Familia $objDados){
            //pega o id primario e inverte com o secundario e salva como IRMÃO(A)
            $novaFamia = new Familia();
            $novaFamia->setGrauParentesco("IRMÃO(A)");
            $novaFamia->setPessoaPrimarioId($objDados->getPessoaSecundarioId());
            $novaFamia->setPessoaSecundarioId($objDados->getPessoaPrimarioId());
            return RepoFamilia::getInstance()->salvar($novaFamia);
        }
        
        private function executaAmarracaoFilho(Familia $objDados){            
            //pego o primario e vejo o sexo pra saber o GrauParentesco se mãe ou pai
            $strGrauParentesco = null;            
            $arrConsultaPesso["PES_ID"] = $objDados->getPessoaPrimarioId();
            $arrObjPessoa = NegPessoa::getInstance()->consultar($arrConsultaPesso);
            if($arrObjPessoa!=null){                
                $pessoa =new Pessoa();
                $pessoa = $arrObjPessoa[0];
                if($pessoa->getSexo() == "M"){
                    $strGrauParentesco = "PAI";
                }else{
                    $strGrauParentesco = "MÃE";
                }                
            }else{
                throw new Exception (" Erro ao executar amarrção filho, pessoa primaria não encontrada.");
            }            
            //pega o id primario e inverte com o secundario e salva como PAI MAE ao depender do sexo
            $novaFamia = new Familia();
            $novaFamia->setGrauParentesco($strGrauParentesco);
            $novaFamia->setPessoaPrimarioId($objDados->getPessoaSecundarioId());
            $novaFamia->setPessoaSecundarioId($objDados->getPessoaPrimarioId());
            return RepoFamilia::getInstance()->salvar($novaFamia);
        }
        
        private function executaAmarracaoConjuge(Familia $objDados){            
            //pega o id primario e inverte com o secundario e salva como CÔNJUGE
            $novaFamia = new Familia();
            $novaFamia->setGrauParentesco("CÔNJUGE");
            $novaFamia->setPessoaPrimarioId($objDados->getPessoaSecundarioId());
            $novaFamia->setPessoaSecundarioId($objDados->getPessoaPrimarioId());            
            return RepoFamilia::getInstance()->salvar($novaFamia);
        }
    }
?>