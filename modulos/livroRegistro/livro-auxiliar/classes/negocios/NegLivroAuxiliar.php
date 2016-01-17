<?php
    // codificação utf-8
    class NegLivroAuxiliar {
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegLivroAuxiliar();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoLivroAuxiliar::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        $arrStrDados[$intI]["LIA_DataHoraCadastro"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["LIA_DataHoraCadastro"]);
                        $arrStrDados[$intI]["totalFolhas"] = $arrObjs[$intI]->getQuantidadeFolha();
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoLivroAuxiliar::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $obj = new LivroAuxiliar();
            if(isset($arrStrDados["LIA_ID"])){
                $obj->setId($arrStrDados["LIA_ID"]);
            }
            if(isset($arrStrDados["LIA_NumeroLivro"])){
                $obj->setNumero($arrStrDados["LIA_NumeroLivro"]);
            }
            if(isset($arrStrDados["LIA_DataHoraCadastro"])){
                $obj->setDataHoraCadastro($arrStrDados["LIA_DataHoraCadastro"]);
            }
            
            //consulta o total de folhas pra preencher o objeto
            if(isset($arrStrDados["LIA_ID"])){
                $arrConsultaFolha["LIA_ID"] = $arrStrDados["LIA_ID"];
                $arrFolha = RepoFolhaAuxiliar::getInstance()->consultar($arrConsultaFolha);
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
                return RepoLivroAuxiliar::getInstance()->salvar($obj);
            }else{
                return RepoLivroAuxiliar::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            //com o id do livro busca as folhas com o id das folhas busca a linhas..            
            $arrConsultaFolha["LIA_ID"] = $arrStrDados["LIA_ID"];
            $arrObjFolha = NegFolhaAuxiliar::getInstance()->consultar($arrConsultaFolha);
            
            if($arrObjFolha!=""){
                $arrObjFolha = $arrObjFolha["objects"];
                for($intFolha=0; $intFolha<count($arrObjFolha); $intFolha++){
                    $folha = new FolhaAuxiliar();
                    $folha = $arrObjFolha[$intFolha];

                    $arrFolha["FAU_ID"] = $folha->getId();
                    //excluindo as folhas exclui as linhas
                    NegFolhaAuxiliar::getInstance()->excluir($arrFolha);
                }
            }
            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            return RepoLivroAuxiliar::getInstance()->excluir($obj);
        }
        
        
        
        
        public function getIdLivroCadastrar(){
            $arrObjParametro = NegParametro::getInstance()->consultar(null);
            $arrObjParametro = $arrObjParametro["objects"];
            $parametro = new Parametro();
            $parametro = $arrObjParametro[0];
            
            $intQuantidadeFolhasLivro = (int)$parametro->getTotFolhaLivro();
            $intQuantidadeLinhasFolha = (int)$parametro->getTotLinhaFolha();
        
            //verificar se existe livro cadastrado, se não tiver cria um novo, se ja tiver segue a regra
            $arrRetornoLivro =  RepoLivroAuxiliar::getInstance()->consultar(null);
            
            if($arrRetornoLivro == ""){
                $objLivroAdd = new LivroAuxiliar();
                $objLivroAdd->setNumero("1");
                
                $arrConsultaUsuario["USU_ID"] = $_SESSION["USUARIO_ID"];
                $arrObjUsu = NegUsuario::getInstance()->consultar($arrConsultaUsuario);
                $arrObjUsu = $arrObjUsu["objects"];
                
                $objLivroAdd->setUsuarioCadastro($arrObjUsu[0]);
                $objLivroAdd->setDataHoraCadastro(date("Y-m-d H:i:s"));
                
                RepoLivroAuxiliar::getInstance()->salvar($objLivroAdd);
                
                return db::getInstance()->getLastId();
            }else{
                
                //se existir um livro ou mais, pegar o primeiro item do retorno, pois será  o ultimo livro cadastrado                
                //echo 'se existir um livro ou mais, pegar o primeiro item do retorno, pois será  o ultimo livro cadastrado';
                $arrStrFiltrosFolha["LIA_ID"] = $arrRetornoLivro[0]["LIA_ID"];
                $arrTotalFolhas = RepoFolhaAuxiliar::getInstance()->consultar($arrStrFiltrosFolha);
                if($arrTotalFolhas != NULL){//tem folhas cadastradas                    
                    
                    //verifica se a quantidade de linhas pra folha foi atingida
                    //se não for ja retorna o id do livro se não continua os testes
                    $consultaLinha["FAU_ID"] = $arrTotalFolhas[0]["FAU_ID"];
                    $arrTotLinha = RepoLinhaAuxiliar::getInstance()->consultar($consultaLinha);
                    
                    if(count($arrTotLinha) == $intQuantidadeLinhasFolha){
                        //se o total de linhas para folha ja foi atingido 
                        //testa a quantidade de folhas da pagina
                        
                        //conta a quantidade se for igual ao que é permitido cadastra um novo livro
                        if(count($arrTotalFolhas) == $intQuantidadeFolhasLivro){
                            //se a quantidade de folhas encontradas for igual a quantidade de folhas permitidas
                            // cria um novo livro

                            $objLivroAdd = new LivroAuxiliar();
                            $objLivroAdd->setNumero($arrRetornoLivro[0]["LIA_NumeroLivro"] + 1);

                            $arrConsultaUsuario["USU_ID"] = $_SESSION["USUARIO_ID"];
                            $arrObjUsu = NegUsuario::getInstance()->consultar($arrConsultaUsuario);
                            $arrObjUsu = $arrObjUsu["objects"];

                            $objLivroAdd->setUsuarioCadastro($arrObjUsu[0]);
                            $objLivroAdd->setDataHoraCadastro(date("Y-m-d H:i:s"));

                            RepoLivroAuxiliar::getInstance()->salvar($objLivroAdd);
                            //retorna o novo id gerado..
                            return db::getInstance()->getLastId();
                        }else{                        
                            //se não retorna o id do livro
                            return $arrRetornoLivro[0]["LIA_ID"];
                        }
                    }else{
                        //se não for atingida a quantidae de linhas ja retorna o id do livro                        
                        return $arrRetornoLivro[0]["LIA_ID"];
                    }
                }else{  
                    //não tem folha então pode retorna o id
                    return $arrRetornoLivro[0]["LIA_ID"] ;
                }
            }
            
            
            /*
            // se não tiver o livro cadastra e retorna o id gerado
            if($arrRetornoLivro == NULL){
                //echo 'se não tiver o livro cadastra e retorna o id gerado';
                
                
                $objLivroAdd = new LivroAuxiliar();
                $objLivroAdd->setNumero("1");
                
                $arrConsultaUsuario["USU_ID"] = $_SESSION["USUARIO_ID"];
                $arrObjUsu = NegUsuario::getInstance()->consultar($arrConsultaUsuario);
                $arrObjUsu = $arrObjUsu["objects"];
                
                $objLivroAdd->setUsuarioCadastro($arrObjUsu[0]);
                $objLivroAdd->setDataHoraCadastro(date("Y-m-d H:i:s"));
                
                RepoLivroAuxiliar::getInstance()->salvar($objLivroAdd);
                
                return db::getInstance()->getLastId();
            }else{
                //se existir um livro ou mais, pegar o primeiro item do retorno, pois será  o ultimo livro cadastrado                
                //echo 'se existir um livro ou mais, pegar o primeiro item do retorno, pois será  o ultimo livro cadastrado';
                
                $arrStrFiltrosFolha["LIA_ID"] = $arrRetornoLivro[0]["LIA_ID"];
                $arrTotalFolhas = RepoFolhaAuxiliar::getInstance()->consultar($arrStrFiltrosFolha);

                if($arrTotalFolhas != NULL){//tem folhas cadastradas                    
                    
                    //verifica se a quantidade de linhas pra folha foi atingida
                    //se não for ja retorna o id do livro se não continua os testes
                    $consultaLinha["FAU_ID"] = $arrTotalFolhas[0]["FAU_ID"];
                    $arrTotLinha = RepoLinhaAuxiliar::getInstance()->consultar($consultaLinha);
                    
                    if(count($arrTotLinha) == $intQuantidadeLinhasFolha){
                        //se o total de linhas para folha ja foi atingido 
                        //testa a quantidade de folhas da pagina
                        
                        //conta a quantidade se for igual ao que é permitido cadastra um novo livro
                        if(count($arrTotalFolhas) == $intQuantidadeFolhasLivro){
                            //se a quantidade de folhas encontradas for igual a quantidade de folhas permitidas
                            // cria um novo livro

                            $objLivroAdd = new LivroAuxiliar();
                            $objLivroAdd->setNumero($arrRetornoLivro[0]["LIA_NumeroLivro"] + 1);

                            $arrConsultaUsuario["USU_ID"] = $_SESSION["USUARIO_ID"];
                            $arrObjUsu = NegUsuario::getInstance()->consultar($arrConsultaUsuario);
                            $arrObjUsu = $arrObjUsu["objects"];

                            $objLivroAdd->setUsuarioCadastro($arrObjUsu[0]);
                            $objLivroAdd->setDataHoraCadastro(date("Y-m-d H:i:s"));

                            RepoLivroAuxiliar::getInstance()->salvar($objLivroAdd);
                            //retorna o novo id gerado..
                            return db::getInstance()->getLastId();
                        }else{                        
                            //se não retorna o id do livro
                            return $arrRetornoLivro[0]["LIA_ID"];
                        }
                    }else{
                        //se não for atingida a quantidae de linhas ja retorna o id do livro                        
                        return $arrRetornoLivro[0]["LIA_ID"];
                    }
                }else{  
                    //não tem folha então pode retorna o id
                    return $arrRetornoLivro[0]["LIA_ID"] ;
                }
            }*/
        }
        
        public function getPermissaoAddFolhaLivro($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            $arrConsultaFolha["LIA_ID"] = $obj->getId();
            $arrRetFolha = NegFolhaAuxiliar::getInstance()->consultar($arrConsultaFolha);            
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
        
    }
?>