<?php
    // codificação utf-8
    class NegLinhaAuxiliar {
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegLinhaAuxiliar();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoLinhaAuxiliar::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){         
                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        
                        
                        $objLivro = new LivroAuxiliar();
                        $objFolha = new FolhaAuxiliar();
                        
                        $objFolha = $arrObjs[$intI]->getFolhaAuxiliar();
                        $objLivro = $objFolha->getLivroAuxiliar();
                        
                        
                        // formatações
                        $arrStrDados[$intI]["Livro"] = $objLivro->getNumero();
                        $arrStrDados[$intI]["Folha"] = $objFolha->getNumero();
                        
                        
                        $arrStrDados[$intI]["LAU_DataHoraCadastro"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["LAU_DataHoraCadastro"]);
                        $arrStrDados[$intI]["LAU_DataHoraAlteracao"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["LAU_DataHoraAlteracao"]);
                        $arrStrDados[$intI]["LAU_Data"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["LAU_Data"]);                        
                        $arrStrDados[$intI]["LAU_Valor"] = NumeroHelper::getInstance()->formatarMoeda($arrStrDados[$intI]["LAU_Valor"]);                   
                        $arrStrDados[$intI]["LAU_TipoFisicaJuridicaLinha"] = $arrObjs[$intI]->getTipoFisicaJuridica();
                        
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoLinhaAuxiliar::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $obj = new LinhaAuxiliar();           
            
            if(isset($arrStrDados["LAU_ID"])){
                $obj->setId($arrStrDados["LAU_ID"]);  
            }
            
            $objFolhaAuxiliar = new FolhaAuxiliar();
            if(isset($arrStrDados["FAU_ID"])){
                $arrConsultaFolha["FAU_ID"] = $arrStrDados["FAU_ID"];
                $arrObjFolha = NegFolhaAuxiliar::getInstance()->consultar($arrConsultaFolha);                
                $arrObjFolha = $arrObjFolha["objects"];
                $objFolhaAuxiliar = $arrObjFolha[0];                
            }
            $obj->setFolhaAuxiliar($objFolhaAuxiliar);
            
            
            $objTipoLinha= new TipoLinhaLivro();
            if(isset($arrStrDados["TIL_ID"])){
                $arrConsultaTipoLinha["TIL_ID"] = $arrStrDados["TIL_ID"];
                $arrObjTipoLinha = NegTipoLinhaLivro::getInstance()->consultar($arrConsultaTipoLinha);                
                $arrObjTipoLinha = $arrObjTipoLinha["objects"];
                $objTipoLinha = $arrObjTipoLinha[0];                
            }
            $obj->setTipoLinha($objTipoLinha);
            
            
            if(isset($arrStrDados["LAU_Descricao"])){
                $obj->setDescricao($arrStrDados["LAU_Descricao"]);  
            }
            if(isset($arrStrDados["LAU_Guia"])){
                $obj->setGuia($arrStrDados["LAU_Guia"]);  
            }
            if(isset($arrStrDados["LAU_ProtocoloRecepcao"])){
                $obj->setProtocoloRecepcao($arrStrDados["LAU_ProtocoloRecepcao"]);  
            }
            if(isset($arrStrDados["LAU_Quantidade"])){
                $obj->setQuantidade($arrStrDados["LAU_Quantidade"]);  
            }
            if(isset($arrStrDados["LAU_Cpf"])){
                $obj->setCpf($arrStrDados["LAU_Cpf"]);  
            }
            $this->setarLinhaFisicaJuridica($obj);
            
            if(isset($arrStrDados["LAU_Data"])){
                $obj->setData($arrStrDados["LAU_Data"]);  
            }
            if(isset($arrStrDados["LAU_Valor"])){
                $obj->setValor($arrStrDados["LAU_Valor"]);  
            }
            
            if(isset($arrStrDados["LAU_DataHoraCadastro"])){
                $obj->setDataHoraCadastro($arrStrDados["LAU_DataHoraCadastro"]);  
            }
            if(isset($arrStrDados["LAU_DataHoraAlteracao"])){
                $obj->setDataHoraAlteracao($arrStrDados["LAU_DataHoraAlteracao"]);  
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
            
            return $obj;
        }
        
        public function salvar($arrStrDados){            
            //verifica se ta vindo o id da folha, se não tiver é porque tem que gerar automaticamente
            if($arrStrDados["FAU_ID"] == ""){
                $arrStrDados["FAU_ID"] = NegFolhaAuxiliar::getInstance()->getIdFolhaCadastrar();
            }
            
            if(isset($arrStrDados["LAU_Valor"])){
                $arrStrDados["LAU_Valor"] = NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados["LAU_Valor"]);
            }
            if(isset($arrStrDados["LAU_Data"])){
                $arrStrDados["LAU_Data"] = DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["LAU_Data"]);
            }
            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            if($obj->getId() == ""){                
                return RepoLinhaAuxiliar::getInstance()->salvar($obj);
            }else{
                return RepoLinhaAuxiliar::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));                        
            return RepoLinhaAuxiliar::getInstance()->excluir($obj);            
        }
        
        
        private function setarLinhaFisicaJuridica(LinhaAuxiliar $linha){
            $arrDado = explode("/", $linha->getCpf());
            
            if(count($arrDado)>1){
                //juridica
                $linha->setTipoFisicaJuridica("J");
            }else{
                //fisical
                $linha->setTipoFisicaJuridica("F");
            }
        }
        
    }
?>