<?php
    // codificação utf-8
    class NegLivroPrevio {
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegLivroPrevio();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoLivroPrevio::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        $arrStrDados[$intI]["LIP_DataHoraCadastro"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["LIP_DataHoraCadastro"]);
                        $arrStrDados[$intI]["totalFolhas"] = $arrObjs[$intI]->getQuantidadeFolha();
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoLivroPrevio::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $obj = new LivroPrevio();
            if(isset($arrStrDados["LIP_ID"])){
                $obj->setId($arrStrDados["LIP_ID"]);
            }
            if(isset($arrStrDados["LIP_NumeroLivro"])){
                $obj->setNumero($arrStrDados["LIP_NumeroLivro"]);
            }
            if(isset($arrStrDados["LIP_DataHoraCadastro"])){
                $obj->setDataHoraCadastro($arrStrDados["LIP_DataHoraCadastro"]);
            }
            
            //consulta o total de folhas pra preencher o objeto
            if(isset($arrStrDados["LIP_ID"])){
                $arrConsultaFolha["LIP_ID"] = $arrStrDados["LIP_ID"];
                $arrFolha = RepoFolhaPrevio::getInstance()->consultar($arrConsultaFolha);
                if($arrFolha!=""){
                   $obj->setQuantidadeFolha(count($arrFolha));
                }else{
                    $obj->setQuantidadeFolha(0);
                }                
            }else{
                $obj->setQuantidadeFolha(0);
            }
            
            
            
            $usuarioCadastro = new Usuario();
            if(isset($arrStrDados["USU_UsuarioCadastroID"])){
                $arrConsulta["USU_ID"] = $arrStrDados["USU_UsuarioCadastroID"];
                $arrObjUsuCad = NegUsuario::getInstance()->consultar($arrConsulta);
                if($arrObjUsuCad != ""){
                    $arrObjUsuCad = $arrObjUsuCad["objects"];
                    $usuarioCadastro = $arrObjUsuCad[0];
                }                
            }
            $obj->setUsuarioCadastro($usuarioCadastro);
            
            return $obj;
        }
        
        public function salvar($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            if($obj->getId() == ""){                
                return RepoLivroPrevio::getInstance()->salvar($obj);
            }else{
                return RepoLivroPrevio::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            //com o id do livro busca as folhas com o id das folhas busca a linhas..            
            $arrConsultaFolha["LIP_ID"] = $arrStrDados["LIP_ID"];
            $arrObjFolha = NegFolhaPrevio::getInstance()->consultar($arrConsultaFolha);
            
            if($arrObjFolha!=""){
                $arrObjFolha = $arrObjFolha["objects"];
                for($intFolha=0; $intFolha<count($arrObjFolha); $intFolha++){
                    $folha = new FolhaPrevio();
                    $folha = $arrObjFolha[$intFolha];
       
                    $arrFolha["FPR_ID"] = $folha->getId();
                    NegFolhaPrevio::getInstance()->excluir($arrFolha);
                }
            }
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            return RepoLivroPrevio::getInstance()->excluir($obj);
        }
        
        
        
        
        public function getIdLivroCadastrar(){
            
            $arrObjParametro = NegParametro::getInstance()->consultar(null);
            $arrObjParametro = $arrObjParametro["objects"];
            $parametro = new Parametro();
            $parametro = $arrObjParametro[0];
            
            $intQuantidadeFolhasLivro = (int)$parametro->getTotFolhaLivro();
            $intQuantidadeLinhasFolha = (int)$parametro->getTotLinhaFolha();
            
            //verificar se existe livro cadastrado, se não tiver cria um novo, se ja tiver segue a regra
            $arrRetornoLivro =  RepoLivroPrevio::getInstance()->consultar(null);
            if($arrRetornoLivro == ""){
                $objLivroAdd = new LivroPrevio();
                $objLivroAdd->setNumero("1");
                
                $arrConsultaUsuario["USU_ID"] = $_SESSION["USUARIO_ID"];
                $arrObjUsu = NegUsuario::getInstance()->consultar($arrConsultaUsuario);
                $arrObjUsu = $arrObjUsu["objects"];
                
                $objLivroAdd->setUsuarioCadastro($arrObjUsu[0]);
                $objLivroAdd->setDataHoraCadastro(date("Y-m-d H:i:s"));
                
                RepoLivroPrevio::getInstance()->salvar($objLivroAdd);
                return db::getInstance()->getLastId();
            }else{
                
                
                
                //se existir um livro ou mais, pegar o primeiro item do retorno, pois será  o ultimo livro cadastrado                
                //echo 'se existir um livro ou mais, pegar o primeiro item do retorno, pois será  o ultimo livro cadastrado';
                
                $arrStrFiltrosFolha["LIP_ID"] = $arrRetornoLivro[0]["LIP_ID"];
                $arrTotalFolhas = RepoFolhaPrevio::getInstance()->consultar($arrStrFiltrosFolha);

                
                if($arrTotalFolhas != ""){//tem folhas cadastradas                    
                    
                    //verifica se a quantidade de linhas pra folha foi atingida
                    //se não for ja retorna o id do livro se não continua os testes
                    $consultaLinha["FPR_ID"] = $arrTotalFolhas[0]["FPR_ID"];
                    $arrTotLinha = RepoLinhaPrevio::getInstance()->consultar($consultaLinha);
                    
                    if(count($arrTotLinha) == $intQuantidadeLinhasFolha){
                        //se o total de linhas para folha ja foi atingido 
                        //testa a quantidade de folhas da pagina
                        
                        //conta a quantidade se for igual ao que é permitido cadastra um novo livro
                        if(count($arrTotalFolhas) == $intQuantidadeFolhasLivro){
                            //se a quantidade de folhas encontradas for igual a quantidade de folhas permitidas
                            // cria um novo livro

                            $objLivroAdd = new LivroPrevio();
                            $objLivroAdd->setNumero($arrRetornoLivro[0]["LIP_NumeroLivro"] + 1);

                            $arrConsultaUsuario["USU_ID"] = $_SESSION["USUARIO_ID"];
                            $arrObjUsu = NegUsuario::getInstance()->consultar($arrConsultaUsuario);
                            $arrObjUsu = $arrObjUsu["objects"];

                            $objLivroAdd->setUsuarioCadastro($arrObjUsu[0]);
                            $objLivroAdd->setDataHoraCadastro(date("Y-m-d H:i:s"));

                            RepoLivroPrevio::getInstance()->salvar($objLivroAdd);
                            //retorna o novo id gerado..
                            return db::getInstance()->getLastId();
                        }else{                        
                            //se não retorna o id do livro
                            return $arrRetornoLivro[0]["LIP_ID"];
                        }
                    }else{
                        //se não for atingida a quantidae de linhas ja retorna o id do livro                        
                        return $arrRetornoLivro[0]["LIP_ID"];
                    }
                }else{  
                    //não tem folha então pode retorna o id
                    return $arrRetornoLivro[0]["LIP_ID"] ;
                }
                
            }
            
            /*
        
            //verifica se tem livro no ano atual        
            $arrStrFiltrosLivro["ANO"] = date("Y");
            $arrRetornoLivro =  RepoLivroPrevio::getInstance()->consultar($arrStrFiltrosLivro);
            
            
            // se não tiver o livro cadastra e retorna o id gerado
            if($arrRetornoLivro == NULL){
                //echo 'se não tiver o livro cadastra e retorna o id gerado';
                
                
                $objLivroAdd = new LivroPrevio();
                $objLivroAdd->setNumero("1");
                
                $arrConsultaUsuario["USU_ID"] = $_SESSION["USUARIO_ID"];
                $arrObjUsu = NegUsuario::getInstance()->consultar($arrConsultaUsuario);
                $arrObjUsu = $arrObjUsu["objects"];
                
                $objLivroAdd->setUsuarioCadastro($arrObjUsu[0]);
                $objLivroAdd->setDataHoraCadastro(date("Y-m-d H:i:s"));
                
                RepoLivroPrevio::getInstance()->salvar($objLivroAdd);
                
                return db::getInstance()->getLastId();
            }else{                
                
            }*/
        }
        
        public function getPermissaoAddFolhaLivro($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            $arrConsultaFolha["LIP_ID"] = $obj->getId();
            $arrRetFolha = NegFolhaPrevio::getInstance()->consultar($arrConsultaFolha);            
            if($arrRetFolha!=""){                
                $totalFolha = $arrRetFolha["num_rows"];
                $arrObjParametro = NegParametro::getInstance()->consultar(null);
                $arrObjParametro = $arrObjParametro["objects"];
                $parametro = new Parametro();
                $parametro = $arrObjParametro[0];                
                if($totalFolha<$parametro->getTotFolhaLivro()){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
        }
        
        
        
        public function montarLivro($arrConsulta) {
            
            $arrDados = array();
            
            if($arrConsulta["tipoConsulta"]=="livro"){
                $arrConsutlaLivro["LIP_DataHoraCadastroIncio"]=  DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrConsulta["dataInicial"]);
                $arrConsutlaLivro["LIP_DataHoraCadastroFim"]=  DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrConsulta["dataFim"]);
                $arrDados = NegLivroPrevio::getInstance()->consultar($arrConsutlaLivro);
                
            }else if($arrConsulta["tipoConsulta"]=="folha"){
                $arrConsutlaFolha["FPR_DataFolhaIncio"]=  DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrConsulta["dataInicial"]);
                $arrConsutlaFolha["FPR_DataFolhaFim"]=  DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrConsulta["dataFim"]);
                $arrDados = NegFolhaPrevio::getInstance()->consultar($arrConsutlaFolha);
            }else{
                $arrConsutlaLinha["FPR_DataFolhaIncio"]=  DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrConsulta["dataInicial"]);
                $arrConsutlaLinha["FPR_DataFolhaFim"]=  DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrConsulta["dataFim"]);
                $arrDados = NegLinhaPrevio::getInstance()->consultar($arrConsutlaLinha);
            }
            
            
            var_dump($arrDados);die();
            
            
            
            //atencao mudar pra que venha os objetos ja internamente
            
            $arrStrDados = RepoLivroPrevio::getInstance()->montarLivro($arrConsulta);
            $arrObjsRetorno = null;
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    
                    $arrObjsLivro = array();
                    var_dump(count($arrStrDados));die();
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        
                        
                        //monta o livro
                        $arrObjsLivro["livro"]["objeto"][$intI] = $this->factory($arrStrDados[$intI]);
                        
                        
                        //consulta folha
                        $arrConsultaFolha["LIP_ID"] = $arrObjsLivro["livro"]["objeto"][$intI]->getId();
                        $arrStrDadosFolha = NegFolhaPrevio::getInstance()->consultar($arrConsultaFolha);
                        if($arrStrDadosFolha != null){
                            if(count($arrStrDadosFolha) > 0){
                                
                                $arrObjsFolha = array();
                                
                                $arrStrDadosFolha = $arrStrDadosFolha["objects"];
                                for($intF=0; $intF<count($arrStrDadosFolha); $intF++){
                                    $arrObjsFolha["folhas"]["objetos"][$intF] = $arrStrDadosFolha[$intF];
                                    
                                    $linha = new FolhaPrevio();
                                    $linha = $arrStrDadosFolha[$intF];
                                    $arrConsultaLinha["FPR_ID"] = $linha->getId();
                                    
                                    $arrStrDadosLinha = NegLinhaPrevio::getInstance()->consultar($arrConsultaLinha);
                                    
                                    /*if($arrStrDadosLinha != null){
                                        if(count($arrStrDadosLinha) > 0){
                                            $arrObjsLinha = array();
                                            
                                            $arrObjsLinha = $arrStrDadosLinha["objects"];
                                        }
                                    }*/
                                    //$arrObjsFolha["folhas"][$intF]["linhas"] = $arrStrDadosLinha["objects"];
                                    $arrObjsFolha["folhas"]["linhas"][$intF] = $arrStrDadosLinha["objects"];
                                    
                                    //$arrObjsLivro["livro"][$intI]["folhas"][$intF] = $arrObjsFolha;
                                    $arrObjsLivro["livro"]["folhas"][$intI] = $arrObjsFolha;
                                }
                                
                            }
                        }
                        
                        
                    }
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjsLivro;
                    
                }
            }
            
            print_r($arrObjsRetorno["objects"]);
            //print_r($arrObjsRetorno["objects"]["livro"][0]);
            //print_r(count($arrObjsRetorno["objects"]["folhas"][0]));
            //print_r($arrObjsRetorno["objects"]["folhas"][0]["linhas"]);
            
            die();
            
            return $arrObjsRetorno;
        }
        
    }
?>