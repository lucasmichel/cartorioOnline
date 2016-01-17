<?php
    // codificação utf-8
    class NegCarta{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegCarta();
            }
            
            return self::$objInstance;
        }

       public function consultar($arrStrFiltros){
           if(isset($arrStrFiltros["CAR_DataInicial"])){
                $arrStrFiltros["CAR_DataInicial"] = DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrFiltros["CAR_DataInicial"]);
            }
            if(isset($arrStrFiltros["CAR_DataFinal"])){
                $arrStrFiltros["CAR_DataFinal"] = DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrFiltros["CAR_DataFinal"]);
            }
            $arrStrDados = RepoCarta::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        
                        $objCarta = new Carta();
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        $objCarta = $arrObjs[$intI];
                        
                        /*para repassar os dados formatados*/                        
                        $arrStrDados[$intI]["USU_LoginCadastro"] = $objCarta->getUsuarioCadastro()->getLogin();
                        $arrStrDados[$intI]["CAR_DataHoraCadastro"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["CAR_DataHoraCadastro"]);
                        /*para repassar os dados formatados*/
                    }
                    
                    
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoCarta::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new Carta();            
            if(isset($arrStrDados["CAR_ID"])){
                $obj->setId($arrStrDados["CAR_ID"]);
            }       
            
            $objTipoCarta = new TipoCarta();
            if(isset($arrStrDados["TCA_ID"])){
                $objTipoCarta->setId($arrStrDados["TCA_ID"]);
            }
            if(isset($arrStrDados["TCA_Descricao"])){
                $objTipoCarta->setDescricao($arrStrDados["TCA_Descricao"]);
            }
            if(isset($arrStrDados["TCA_Texto"])){
                $objTipoCarta->setTexto($arrStrDados["TCA_Texto"]);
            }
            if(isset($arrStrDados["TCA_Status"])){
                $objTipoCarta->setTexto($arrStrDados["TCA_Status"]);
            }
            $obj->setTipoCarta($objTipoCarta);
            
            $objUsuarioCadastro = new Usuario();
            if(isset($arrStrDados["USU_Cadastro_ID"])){
                $objUsuarioCadastro->setId($arrStrDados["USU_Cadastro_ID"]);
            }
            if(isset($arrStrDados["USU_LoginCadastro"])){
                $objUsuarioCadastro->setLogin($arrStrDados["USU_LoginCadastro"]);
            }
            $obj->setUsuarioCadastro($objUsuarioCadastro);
            
            $objUsuarioAlteracao = new Usuario();
            if(isset($arrStrDados["USU_Alteracao_ID"])){
                $objUsuarioAlteracao->setId($arrStrDados["USU_Alteracao_ID"]);
            }
            if(isset($arrStrDados["USU_LoginAlteracao"])){
                $objUsuarioAlteracao->setLogin($arrStrDados["USU_LoginAlteracao"]);
            }
            $obj->setUsuarioAlteracao($objUsuarioAlteracao);
            
            if(isset($arrStrDados["CAR_Texto"])){
                $obj->setTexto($arrStrDados["CAR_Texto"]);
            }
            
            if(isset($arrStrDados["CAR_DataHoraCadastro"])){
                $intTotOcorrencia = substr_count($arrStrDados["CAR_DataHoraCadastro"], "/");                
                if($intTotOcorrencia > 0){
                    //veio com / então retira
                    $obj->setDataHoraCadastro(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["CAR_DataHoraCadastro"]));
                }else{                    
                    //não veio com / então coloca
                    $obj->setDataHoraCadastro(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["CAR_DataHoraCadastro"]));
                }
            }
            if(isset($arrStrDados["CAR_DataHoraAlteracao"])){
                $intTotOcorrencia = substr_count($arrStrDados["CAR_DataHoraAlteracao"], "/");                
                if($intTotOcorrencia > 0){
                    //veio com / então retira
                    $obj->setDataHoraAlteracao(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["CAR_DataHoraAlteracao"]));
                }else{                    
                    //não veio com / então coloca
                    $obj->setDataHoraAlteracao(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["CAR_DataHoraAlteracao"]));
                }
            }            
            if(isset($arrStrDados["PES_ID"])){
                $membro = new Membro();
                $arrFiltroMembro["PES_ID"] = $arrStrDados["PES_ID"];
                $arrObjMembro = FachadaCadastro::getInstance()->consultarMembro($arrFiltroMembro);
                if($arrObjMembro != null){
                    $arrObj = $arrObjMembro["objects"];                    
                    $membro = $arrObj[0];
                }else{
                    $membro = null;
                }
            }else{
                $membro = null;
            }
            $obj->setObjPessoaCarta($membro);
            return $obj;
        }
        
        public function salvar($arrStrDados){
            $arrStrDados["USU_Cadastro_ID"] = $_SESSION["USUARIO_ID"];
            $arrStrDados["USU_Alteracao_ID"] = $_SESSION["USUARIO_ID"];            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosSemModificacao($arrStrDados));            
            //PRESEVA O HTML GERADO NO EDITOR
            $obj->setTexto(addslashes($arrStrDados["CAR_Texto"]));
            //PRESEVA O HTML GERADO NO EDITOR                        
            $obj->setDataHoraCadastro(date("Y-m-d H:m:s"));
            $obj->setDataHoraAlteracao(date("Y-m-d H:m:s"));            
            if($obj->getId() == ""){
                return RepoCarta::getInstance()->salvar($obj);
            }else{ 
                return RepoCarta::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){                        
            if(is_array($arrStrDados["CAR_ID"])){
                for($intI=0; $intI<count($arrStrDados["CAR_ID"]); $intI++){
                    $obj = new Carta();
                    $obj->setId($arrStrDados["CAR_ID"][$intI]);                    
                    RepoCarta::getInstance()->excluir($obj);            
                }
            }
            return true;            
        }
        
        
    }
?>