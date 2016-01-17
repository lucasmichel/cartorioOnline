<?php
    // codificação utf-8
    class NegLinhaPrevio {
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegLinhaPrevio();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoLinhaPrevio::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){         
                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        
                        $objLivro = new LivroPrevio();
                        $objFolha = new FolhaPrevio();
                        
                        $objFolha = $arrObjs[$intI]->getFolhaPrevio();
                        $objLivro = $objFolha->getLivroPrevio();
                        
                        
                        // formatações
                        $arrStrDados[$intI]["Livro"] = $objLivro->getNumero();
                        $arrStrDados[$intI]["Folha"] = $objFolha->getNumero();
                        
                        
                        $arrStrDados[$intI]["LPR_DataHoraCadastro"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["LPR_DataHoraCadastro"]);
                        $arrStrDados[$intI]["LPR_DataHoraAlteracao"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["LPR_DataHoraAlteracao"]);
                        $arrStrDados[$intI]["LPR_Data"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["LPR_Data"]);                        
                        $arrStrDados[$intI]["LPR_Valor"] = NumeroHelper::getInstance()->formatarMoeda($arrStrDados[$intI]["LPR_Valor"]);                   
                        
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoLinhaPrevio::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $obj = new LinhaPrevio();           
            
            if(isset($arrStrDados["LPR_ID"])){
                $obj->setId($arrStrDados["LPR_ID"]);  
            }
            
            if(isset($arrStrDados["FPR_ID"])){
                $arrConsultaFolha["FPR_ID"] = $arrStrDados["FPR_ID"];
                $arrObjFolha = NegFolhaPrevio::getInstance()->consultar($arrConsultaFolha);
                if($arrObjFolha != ""){
                    $arrObjFolha = $arrObjFolha["objects"];
                    $obj->setFolhaPrevio($arrObjFolha[0]);
                }else{
                    $obj->setFolhaPrevio(null);
                }
            }else{
                $obj->setFolhaPrevio(null);
            }
            
            if(isset($arrStrDados["TIL_ID"])){
                $arrConsultaTipoLinha["TIL_ID"] = $arrStrDados["TIL_ID"];
                $arrObjTipoLinha = NegTipoLinhaLivro::getInstance()->consultar($arrConsultaTipoLinha);                
                if($arrObjTipoLinha != ""){
                    $arrObjTipoLinha = $arrObjTipoLinha["objects"];
                    $obj->setTipoLinha($arrObjTipoLinha[0]);
                }else{
                    $obj->setTipoLinha(null);
                }
            }else{
                $obj->setTipoLinha(null);
            }
            
            if(isset($arrStrDados["LPR_Descricao"])){
                $obj->setDescricao($arrStrDados["LPR_Descricao"]);  
            }
            if(isset($arrStrDados["LPR_Nome"])){
                $obj->setNome($arrStrDados["LPR_Nome"]);  
            }
            if(isset($arrStrDados["LPR_Guia"])){
                $obj->setGuia($arrStrDados["LPR_Guia"]);  
            }
            if(isset($arrStrDados["LPR_ProtocoloRecepcao"])){
                $obj->setProtocoloRecepcao($arrStrDados["LPR_ProtocoloRecepcao"]);  
            }
            if(isset($arrStrDados["LPR_Quantidade"])){
                $obj->setQuantidade($arrStrDados["LPR_Quantidade"]);  
            }
            if(isset($arrStrDados["LPR_Cpf"])){
                $obj->setCpf($arrStrDados["LPR_Cpf"]);  
            }
            if(isset($arrStrDados["LPR_Data"])){
                $obj->setData($arrStrDados["LPR_Data"]);  
            }
            if(isset($arrStrDados["LPR_Valor"])){
                $obj->setValor($arrStrDados["LPR_Valor"]);  
            }
            
            if(isset($arrStrDados["LPR_DataHoraCadastro"])){
                $obj->setDataHoraCadastro($arrStrDados["LPR_DataHoraCadastro"]);  
            }
            if(isset($arrStrDados["LPR_DataHoraAlteracao"])){
                $obj->setDataHoraAlteracao($arrStrDados["LPR_DataHoraAlteracao"]);  
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
            
            
            if(isset($arrStrDados["LPR_StatusConclusao"])){
                $obj->setStatusConclusao($arrStrDados["LPR_StatusConclusao"]);  
            }else{
                $obj->setStatusConclusao("N");  
            }
            
            if(isset($arrStrDados["LPR_DataHoraStatusConclusao"])){
                $obj->setDataHoraStatusConclusao($arrStrDados["LPR_DataHoraStatusConclusao"]);  
            }
            
            
            $usuarioStatusConclusao = new Usuario();
            if(isset($arrStrDados["USU_StatusConclusao_ID"])){
                $arrConsultaSta["USU_ID"] = $arrStrDados["USU_StatusConclusao_ID"];
                $arrObjUsuSta = NegUsuario::getInstance()->consultar($arrConsultaSta);
                if($arrObjUsuSta != ""){
                    $arrObjUsuSta = $arrObjUsuSta["objects"];
                    $usuarioStatusConclusao = $arrObjUsuSta[0];
                }
            }
            $obj->setUsuarioStatusConclusao($usuarioStatusConclusao);
            
            
            return $obj;
        }
        
        public function salvar($arrStrDados){
            //verifica se ta vindo o id da folha, se não tiver é porque tem que gerar automaticamente
            if($arrStrDados["FPR_ID"] == ""){
                $arrStrDados["FPR_ID"] = NegFolhaPrevio::getInstance()->getIdFolhaCadastrar();
            }
            
            if(isset($arrStrDados["LPR_Valor"])){
                $arrStrDados["LPR_Valor"] = NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados["LPR_Valor"]);
            }
            if(isset($arrStrDados["LPR_Data"])){
                $arrStrDados["LPR_Data"] = DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["LPR_Data"]);
            }
            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            if($obj->getId() == ""){                
                return RepoLinhaPrevio::getInstance()->salvar($obj);
            }else{
                return RepoLinhaPrevio::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));                        
            return RepoLinhaPrevio::getInstance()->excluir($obj);            
        }
        
        
        
        
        
        
        
        function alterarStatusConclusao($arrFiltro){            
        /*CRIA UMA LINHA EM LINHA_LIVRO_AUXILIAR E REPLICA OS DADOS DESSE 
        * PREVIO E PEGA O ID DELA GERADO E PASSA PRA 
        * $arrStrDados["liv_linha_auxiliar_id"]         
        */
        $arrCon["LPR_ID"] = $arrFiltro["LPR_ID"];
        
        $arrObjPrevio = $this->consultar($arrCon);
        if($arrObjPrevio != ""){
            
            $linhaPrevio = new LinhaPrevio();
            $linhaPrevio = $arrObjPrevio["objects"][0];
            
            //$arrDadosLinhaAuxiliar["FAU_ID"] = "";//manda assim pra criar a linha automatico.
            $arrDadosLinhaAuxiliar["FAU_ID"] = $arrFiltro["FAU_ID"];;//manda assim pra criar a linha automatico.
            
            $arrDadosLinhaAuxiliar["TIL_ID"] = $arrFiltro["TIL_ID"];
            $arrDadosLinhaAuxiliar["USU_UsuarioCadastroID"] = $_SESSION["USUARIO_ID"];
            $arrDadosLinhaAuxiliar["LAU_Descricao"] = $linhaPrevio->getDescricao();
            $arrDadosLinhaAuxiliar["LAU_Guia"] = $linhaPrevio->getGuia();
            $arrDadosLinhaAuxiliar["LAU_ProtocoloRecepcao"] = $linhaPrevio->getProtocoloRecepcao();
            $arrDadosLinhaAuxiliar["LAU_Quantidade"] = $linhaPrevio->getQuantidade();
            $arrDadosLinhaAuxiliar["LAU_Cpf"] = $linhaPrevio->getCpf();
            $arrDadosLinhaAuxiliar["LAU_Data"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($linhaPrevio->getData());
            $arrDadosLinhaAuxiliar["LAU_Valor"] = NumeroHelper::getInstance()->formatarMoeda($linhaPrevio->getValor());
            $arrDadosLinhaAuxiliar["LAU_DataHoraCadastro"] = date("Y-m-d H:i:s");                                
            if(NegLinhaAuxiliar::getInstance()->salvar($arrDadosLinhaAuxiliar)){
                return RepoLinhaPrevio::getInstance()->alterarStatusConclusao($linhaPrevio);
            }else{                
                throw new Exception("Erro ao criar a linha auxiliar, contate o administrador.");                
            }
        }else{
            throw new Exception("Linha previo não encontrada, contate o administrador. ID_CONSULTA: ".$arrFiltro["LPR_ID"]);
        }
        
    }
        
    }
?>