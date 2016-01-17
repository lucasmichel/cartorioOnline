<?php
    // codificação utf-8
    class NegFolhaPrevio {
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegFolhaPrevio();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoFolhaPrevio::getInstance()->consultar($arrStrFiltros);            
            $arrObjsRetorno = null;
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        $arrStrDados[$intI]["FPR_DataFolha"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["FPR_DataFolha"]);
                        $arrStrDados[$intI]["Usuario_Cadastro"] = $arrStrDados[$intI]["Usuario_Cadastro"];
                        $arrStrDados[$intI]["totalLinhas"] = $arrObjs[$intI]->getQuantidadeLinha();
                        
                        
                        $livro = new LivroPrevio();
                        $livro = $arrObjs[$intI]->getLivroPrevio();
                        
                        $arrData = explode(" ", $livro->getDataHoraCadastro());                        
                        $arrStrDados[$intI]["LIP_NumeroLivro"] = $livro->getNumero()." - ".  DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrData[0]);
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoFolhaPrevio::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        
        
        public function factory($arrStrDados){
            $obj = new FolhaPrevio();           
            
            if(isset($arrStrDados["FPR_ID"])){
                $obj->setId($arrStrDados["FPR_ID"]);  
            }
            
            $objLivro = new LivroPrevio();
            if(isset($arrStrDados["LIP_ID"])){
                $arrConsultaLivro["LIP_ID"] = $arrStrDados["LIP_ID"];
                $arrObjLivro = NegLivroPrevio::getInstance()->consultar($arrConsultaLivro);                
                $arrObjLivro = $arrObjLivro["objects"];
                $objLivro = $arrObjLivro[0];                
            }
            $obj->setLivroPrevio($objLivro);
            
            if(isset($arrStrDados["FPR_NumeroFolha"])){
                $obj->setNumero($arrStrDados["FPR_NumeroFolha"]);  
            }
            if(isset($arrStrDados["FPR_DataFolha"])){
                $obj->setData($arrStrDados["FPR_DataFolha"]);  
            }
            
            if(isset($arrStrDados["FPR_DataHoraCadastro"])){
                $obj->setDataHoraCadastro($arrStrDados["FPR_DataHoraCadastro"]);  
            }
            if(isset($arrStrDados["FPR_DataHoraAlteracao"])){
                $obj->setDataHoraAlteracao($arrStrDados["FPR_DataHoraAlteracao"]);  
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
            if(isset($arrStrDados["FPR_ID"])){
                $arrConsultaLinha["FPR_ID"] = $arrStrDados["FPR_ID"];
                $arrLinha = RepoLinhaPrevio::getInstance()->consultar($arrConsultaLinha);
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
                return RepoFolhaPrevio::getInstance()->salvar($obj);
            }else{
                return RepoFolhaPrevio::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));                                    
            //busca as linhas                
            $arrConsultaLinha["FPR_ID"] = $obj->getId();
            $arrObjLinha = NegLinhaPrevio::getInstance()->consultar($arrConsultaLinha);
            if($arrObjLinha!=""){
                $arrObjLinha = $arrObjLinha["objects"];
                for($intLinha=0; $intLinha<count($arrObjLinha); $intLinha++ ){
                    $linha = new LinhaPrevio();
                    $linha= $arrObjLinha[$intLinha];
                    $arrExcluirLinha["LPR_ID"] = $linha->getId();
                    NegLinhaPrevio::getInstance()->excluir($arrExcluirLinha);
                }
            }
            
            return RepoFolhaPrevio::getInstance()->excluir($obj);            
        }
        
        
        
        
        /**
        * Metodo buscarIdFolhaCadastrarLinha()
        * @access public
        * @return um array com id do livro e da folha para cadastrar a linha
        */
        public function getIdFolhaCadastrar(){

            //pega o id do livro            
            $arrStrFiltrosFolha["LIP_ID"] = NegLivroPrevio::getInstance()->getIdLivroCadastrar();
            
            $intFolhaId = 0;
            
            
            
            $arrObjParametro = NegParametro::getInstance()->consultar(null);
            $arrObjParametro = $arrObjParametro["objects"];
            $parametro = new Parametro();
            $parametro = $arrObjParametro[0];            
            //pega a quantidae de linhas permitidas por folha
            $intQuantidadeLinhasFolha = (int)$parametro->getTotLinhaFolha();
            
            
            //com o id do livro pega a quantidade de folhas 
            $arrFolha = RepoFolhaPrevio::getInstance()->consultar($arrStrFiltrosFolha);
            //die();
            
            
            if($arrFolha == ""){
                //cadastra uma nov folha
                
                $objFolha = new FolhaPrevio();
                $objFolha->setNumero(1);
                
                $arrConsultaUsuario["USU_ID"] = $_SESSION["USUARIO_ID"];
                $arrObjUsu = NegUsuario::getInstance()->consultar($arrConsultaUsuario);
                $arrObjUsu = $arrObjUsu["objects"];

                $arrConsultaLivro["LIP_ID"] = $arrStrFiltrosFolha["LIP_ID"];
                $arrObjLivro = NegLivroPrevio::getInstance()->consultar($arrConsultaLivro);
                $arrObjLivro = $arrObjLivro["objects"];

                $objFolha->setUsuarioCadastro($arrObjUsu[0]);
                
                $objFolha->setLivroPrevio($arrObjLivro[0]);
                $objFolha->setData(date("d/m/Y"));
                $objFolha->setDataHoraCadastro(date("Y-m-d H:i:s"));
                
                RepoFolhaPrevio::getInstance()->salvar($objFolha);
                //retorna o novo id gerado..
                $intFolhaId = db::getInstance()->getLastId();
                
                
            }else{
                //se a quantidade de folha for maior ou igua ao permitido cadastra uma nova folha
                //ver aqui .. contar as linhas pra testar
                $arrConsultaLinha["FPR_ID"] = $arrFolha[0]["FPR_ID"];
                $arrLinha = RepoLinhaPrevio::getInstance()->consultar($arrConsultaLinha);
                
                
                if($arrLinha != ""){
                    
                    //conta a quantidade de linha se for igual ao que é permitido cadastra uma novo folha
                    if(count($arrLinha) == $intQuantidadeLinhasFolha){
                        //cadastra uma novo folha
                        
                        //incrementa o numero da folha
                        $numFolha = $arrFolha[0]["FPR_NumeroFolha"] + 1;
                        
                        $objFolha = new FolhaPrevio();
                        $objFolha->setNumero($numFolha);

                        $arrConsultaUsuario["USU_ID"] = $_SESSION["USUARIO_ID"];
                        $arrObjUsu = NegUsuario::getInstance()->consultar($arrConsultaUsuario);
                        $arrObjUsu = $arrObjUsu["objects"];

                        $arrConsultaLivro["LIP_ID"] = $arrStrFiltrosFolha["LIP_ID"];
                        $arrObjLivro = NegLivroPrevio::getInstance()->consultar($arrConsultaLivro);
                        $arrObjLivro = $arrObjLivro["objects"];

                        $objFolha->setUsuarioCadastro($arrObjUsu[0]);

                        $objFolha->setLivroPrevio($arrObjLivro[0]);
                        $objFolha->setData(date("d/m/Y"));
                        $objFolha->setDataHoraCadastro(date("Y-m-d H:i:s"));

                        RepoFolhaPrevio::getInstance()->salvar($objFolha);
                        //retorna o novo id gerado..
                        $intFolhaId = db::getInstance()->getLastId();
                        
                        
                        
                        
                    }else{
                        //ainda não tem a quantidade então retorna o id da folha
                        $intFolhaId = $arrFolha[0]["FPR_ID"];
                    }
                            
                }else{
                    //não tem nenhuma linha em tõ retorna a folha
                    $intFolhaId = $arrFolha[0]["FPR_ID"];
                }
                
                /*$arrRetorno["folhaId"] = $intFolhaId;
                $arrRetorno["livroId"] = $arrStrFiltrosFolha["LIA_ID"];*/
                
                return $intFolhaId;
            }
        }
        
        public function getPermissaoAddLinhaFolha($arrStrDados){
            $arrConsultaLinha["FPR_ID"] = $arrStrDados["FPR_ID"];
            $arrRetLinha = NegLinhaPrevio::getInstance()->consultar($arrConsultaLinha);
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