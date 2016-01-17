<?php
    // codificação utf-8
    class NegTipoLinhaLivro {
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegTipoLinhaLivro();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoTipoLinhaLivro::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoTipoLinhaLivro::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        public function factory($arrStrDados){
            $obj = new TipoLinhaLivro();           
            
            if(isset($arrStrDados["TIL_ID"])){
                $obj->setId($arrStrDados["TIL_ID"]);  
            }            
            if(isset($arrStrDados["TIL_Descricao"])){
                $obj->setDescricao($arrStrDados["TIL_Descricao"]);  
            }
            if(isset($arrStrDados["TIL_Tipo"])){
                $obj->setTipo($arrStrDados["TIL_Tipo"]);  
            }
            if(isset($arrStrDados["TIL_DataHoraCadastro"])){
                $obj->setDataHoraCadastro($arrStrDados["TIL_DataHoraCadastro"]);  
            }
            if(isset($arrStrDados["TIL_DataHoraAlteracao"])){
                $obj->setDataHoraAlteracao($arrStrDados["TIL_DataHoraAlteracao"]);  
            }
            if(isset($arrStrDados["TIL_Status"])){
                $obj->setStatus($arrStrDados["TIL_Status"]);  
            }else{
                $obj->setStatus("A");
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
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            if($obj->getId() == ""){                
                return RepoTipoLinhaLivro::getInstance()->salvar($obj);
            }else{
                return RepoTipoLinhaLivro::getInstance()->alterar($obj);
            }
        }
        
    }
?>