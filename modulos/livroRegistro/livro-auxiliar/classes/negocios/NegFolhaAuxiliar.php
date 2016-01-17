<?php
    // codificação utf-8
    class NegFolhaAuxiliar {
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegFolhaAuxiliar();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoFolhaAuxiliar::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        $arrStrDados[$intI]["FAU_DataFolha"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["FAU_DataFolha"]);
                        $arrStrDados[$intI]["Usuario_Cadastro"] = $arrStrDados[$intI]["Usuario_Cadastro"];
                        $arrStrDados[$intI]["totalLinhas"] = $arrObjs[$intI]->getQuantidadeLinha();
                        
                        
                        $livro = new LivroAuxiliar();
                        $livro = $arrObjs[$intI]->getLivroAuxiliar();
                        
                        $arrData = explode(" ", $livro->getDataHoraCadastro());                        
                        $arrStrDados[$intI]["LIA_NumeroLivro"] = $livro->getNumero()." - ".  DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrData[0]);
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoFolhaAuxiliar::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        
        
        public function factory($arrStrDados){
            $obj = new FolhaAuxiliar();           
            
            if(isset($arrStrDados["FAU_ID"])){
                $obj->setId($arrStrDados["FAU_ID"]);  
            }
            
            $objLivroAuxiliar = new LivroAuxiliar();
            if(isset($arrStrDados["LIA_ID"])){
                $arrConsultaLivro["LIA_ID"] = $arrStrDados["LIA_ID"];
                $arrObjLivro = NegLivroAuxiliar::getInstance()->consultar($arrConsultaLivro);                
                $arrObjLivro = $arrObjLivro["objects"];
                $objLivroAuxiliar = $arrObjLivro[0];                
            }
            $obj->setLivroAuxiliar($objLivroAuxiliar);
            
            if(isset($arrStrDados["FAU_NumeroFolha"])){
                $obj->setNumero($arrStrDados["FAU_NumeroFolha"]);  
            }
            if(isset($arrStrDados["FAU_DataFolha"])){
                $obj->setData($arrStrDados["FAU_DataFolha"]);  
            }
            
            if(isset($arrStrDados["FAU_DataHoraCadastro"])){
                $obj->setDataHoraCadastro($arrStrDados["FAU_DataHoraCadastro"]);  
            }
            if(isset($arrStrDados["FAU_DataHoraAlteracao"])){
                $obj->setDataHoraAlteracao($arrStrDados["FAU_DataHoraAlteracao"]);  
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
            
            
            $usuarioAlteracao = new Usuario();
            if(isset($arrStrDados["USU_UsuarioAlteracaoID"])){
                $arrConsulta["USU_ID"] = $arrStrDados["USU_UsuarioAlteracaoID"];
                $arrObjUsuAlt = NegUsuario::getInstance()->consultar($arrConsulta);
                if($arrObjUsuAlt != ""){
                    $arrObjUsuAlt = $arrObjUsuAlt["objects"];
                    $usuarioAlteracao = $arrObjUsuAlt[0];
                }
                
            }
            $obj->setUsuarioAlteracao($usuarioAlteracao);
            
            
            //consulta o total de linhas pra preencher o objeto
            if(isset($arrStrDados["FAU_ID"])){
                $arrConsultaLinha["FAU_ID"] = $arrStrDados["FAU_ID"];
                $arrLinha = RepoLinhaAuxiliar::getInstance()->consultar($arrConsultaLinha);
                if($arrLinha!=""){                   
                   $obj->setQuantidadeLinha(count($arrLinha));
                }else{
                    $obj->setQuantidadeLinha(0);
                }                
            }else{
                $obj->setQuantidadeLinha(0);
            }
            
            
            return $obj;
        }
        
        public function salvar($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            if($obj->getId() == ""){                
                return RepoFolhaAuxiliar::getInstance()->salvar($obj);
            }else{
                return RepoFolhaAuxiliar::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));                                    
            //busca as linhas                
            $arrConsultaLinha["FAU_ID"] = $obj->getId();
            $arrObjLinha = NegLinhaAuxiliar::getInstance()->consultar($arrConsultaLinha);
            if($arrObjLinha!=""){
                $arrObjLinha = $arrObjLinha["objects"];
                for($intLinha=0; $intLinha<count($arrObjLinha); $intLinha++ ){
                    $linha = new LinhaAuxiliar();
                    $linha= $arrObjLinha[$intLinha];
                    $arrExcluirLinha["LAU_ID"] = $linha->getId();
                    NegLinhaAuxiliar::getInstance()->excluir($arrExcluirLinha);
                }
            }
            
            return RepoFolhaAuxiliar::getInstance()->excluir($obj);            
        }
        
        
        
        
        /**
        * Metodo buscarIdFolhaCadastrarLinha()
        * @access public
        * @return um array com id do livro e da folha para cadastrar a linha
        */
        public function getIdFolhaCadastrar(){

            //pega o id do livro            
            $arrStrFiltrosFolha["LIA_ID"] = NegLivroAuxiliar::getInstance()->getIdLivroCadastrar();
            
            $intFolhaId = 0;
            
            
            
            $arrObjParametro = NegParametro::getInstance()->consultar(null);
            $arrObjParametro = $arrObjParametro["objects"];
            $parametro = new Parametro();
            $parametro = $arrObjParametro[0];            
            //pega a quantidae de linhas permitidas por folha
            $intQuantidadeLinhasFolha = (int)$parametro->getTotLinhaFolha();
            
            
            //com o id do livro pega a quantidade de folhas 
            $arrFolha = RepoFolhaAuxiliar::getInstance()->consultar($arrStrFiltrosFolha);
            //die();
            
            
            if($arrFolha == NULL){
                //cadastra uma nov folha
                
                $objFolha = new FolhaAuxiliar();
                $objFolha->setNumero(1);
                
                $arrConsultaUsuario["USU_ID"] = $_SESSION["USUARIO_ID"];
                $arrObjUsu = NegUsuario::getInstance()->consultar($arrConsultaUsuario);
                $arrObjUsu = $arrObjUsu["objects"];

                $arrConsultaLivro["LIA_ID"] = $arrStrFiltrosFolha["LIA_ID"];
                $arrObjLivro = NegLivroAuxiliar::getInstance()->consultar($arrConsultaLivro);
                $arrObjLivro = $arrObjLivro["objects"];

                $objFolha->setUsuarioCadastro($arrObjUsu[0]);
                
                $objFolha->setLivroAuxiliar($arrObjLivro[0]);
                $objFolha->setData(date("d/m/Y"));
                $objFolha->setDataHoraCadastro(date("Y-m-d H:i:s"));
                
                RepoFolhaAuxiliar::getInstance()->salvar($objFolha);
                //retorna o novo id gerado..
                $intFolhaId = db::getInstance()->getLastId();
                
                
            }else{
                //se a quantidade de folha for maior ou igua ao permitido cadastra uma nova folha
                //ver aqui .. contar as linhas pra testar
                $arrConsultaLinha["FAU_ID"] = $arrFolha[0]["FAU_ID"];
                $arrLinha = RepoLinhaAuxiliar::getInstance()->consultar($arrConsultaLinha);
                
                
                if($arrLinha != NULL){
                    
                    //conta a quantidade de linha se for igual ao que é permitido cadastra uma novo folha
                    if(count($arrLinha) == $intQuantidadeLinhasFolha){
                        //cadastra uma novo folha
                        
                        //incrementa o numero da folha
                        $numFolha = $arrFolha[0]["FAU_NumeroFolha"] + 1;
                        
                        $objFolha = new FolhaAuxiliar();
                        $objFolha->setNumero($numFolha);

                        $arrConsultaUsuario["USU_ID"] = $_SESSION["USUARIO_ID"];
                        $arrObjUsu = NegUsuario::getInstance()->consultar($arrConsultaUsuario);
                        $arrObjUsu = $arrObjUsu["objects"];

                        $arrConsultaLivro["LIA_ID"] = $arrStrFiltrosFolha["LIA_ID"];
                        $arrObjLivro = NegLivroAuxiliar::getInstance()->consultar($arrConsultaLivro);
                        $arrObjLivro = $arrObjLivro["objects"];

                        $objFolha->setUsuarioCadastro($arrObjUsu[0]);

                        $objFolha->setLivroAuxiliar($arrObjLivro[0]);
                        $objFolha->setData(date("d/m/Y"));
                        $objFolha->setDataHoraCadastro(date("Y-m-d H:i:s"));

                        RepoFolhaAuxiliar::getInstance()->salvar($objFolha);
                        //retorna o novo id gerado..
                        $intFolhaId = db::getInstance()->getLastId();
                        
                        
                        
                        
                    }else{
                        //ainda não tem a quantidade então retorna o id da folha
                        $intFolhaId = $arrFolha[0]["FAU_ID"];
                    }
                            
                }else{
                    //não tem nenhuma linha em tõ retorna a folha
                    $intFolhaId = $arrFolha[0]["FAU_ID"];
                }
                
                /*$arrRetorno["folhaId"] = $intFolhaId;
                $arrRetorno["livroId"] = $arrStrFiltrosFolha["LIA_ID"];*/
                
                return $intFolhaId;
            }
        }
        
        public function getPermissaoAddLinhaFolha($arrStrDados){
            $arrConsultaLinha["FAU_ID"] = $arrStrDados["FAU_ID"];
            $arrRetLinha = NegLinhaAuxiliar::getInstance()->consultar($arrConsultaLinha);
            if($arrRetLinha!=""){                
                $totalLinha = $arrRetLinha["num_rows"];
                $arrObjParametro = NegParametro::getInstance()->consultar(null);
                $arrObjParametro = $arrObjParametro["objects"];
                $parametro = new Parametro();
                $parametro = $arrObjParametro[0];                
                if($totalLinha<$parametro->getTotLinhaFolha()){
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