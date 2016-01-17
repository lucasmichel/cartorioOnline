<?php
    // codificação utf-8
    class NegMinisterio{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegMinisterio();
            }
            
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            $arrStrDados = RepoMinisterio::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                                                
                        // consulta  as reunioes
                        $arrStrReuniaoFiltros = array();
                        $arrStrReuniaoFiltros["MIN_ID"] = $arrStrDados[$intI]["MIN_ID"];                        
                        $arrStrDadosReuniao = RepoMinisterio::getInstance()->consultarReuniao($arrStrReuniaoFiltros); 
                        
                        $arrStrDados[$intI]["DIA_ID"] = array();
                        $arrStrDados[$intI]["MDR_Horario"] = array();
                        $arrStrDados[$intI]["MIN_DiasReuniao"] = "";
                        
                        $strVirgula = "";
                        
                        for($intX=0; $intX<count($arrStrDadosReuniao); $intX++){                            
                            $arrStrDados[$intI]["DIA_ID"][$intX] = $arrStrDadosReuniao[$intX]["DIA_ID"];
                            $arrStrDados[$intI]["MDR_Horario"][$intX] = $arrStrDadosReuniao[$intX]["MDR_Horario"];
                            $arrStrDados[$intI]["MIN_DiasReuniao"] .= $strVirgula."<b>".$arrStrDadosReuniao[$intX]["DIA_Descricao"]."</b> às ".$arrStrDadosReuniao[$intX]["MDR_Horario"];
                            $strVirgula = ", ";
                        }
                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);                        
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoMinisterio::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        private function factory($arrStrDados){
            $obj = new Ministerio();
            
            if(isset($arrStrDados["MIN_ID"])){
                $obj->setId($arrStrDados["MIN_ID"]);
            }
            
            if(isset($arrStrDados["MIN_Descricao"])){
                $obj->setDescricao($arrStrDados["MIN_Descricao"]);
            }
            
            if(isset($arrStrDados["DIA_ID"]) && isset($arrStrDados["MDR_Horario"])){
                for($intI=0; $intI<count($arrStrDados["DIA_ID"]); $intI++){
                    // monta a reuniao
                    $objReuniao = new Reuniao();
                    
                    $objDiaSemana = new DiaSemana();
                    $objDiaSemana->setId($arrStrDados["DIA_ID"][$intI]);
                    $objReuniao->setDiaSemana($objDiaSemana);
                    $objReuniao->setHorario($arrStrDados["MDR_Horario"][$intI]);
                    $obj->adicionarReuniao($objReuniao);
                }
            }
            
            if(isset($arrStrDados["MIN_Observacao"])){
                $obj->setObservacao($arrStrDados["MIN_Observacao"]);
            }
            
            //area ministerial
            $areaMinisterial = new AreaMinisterial();
            if(isset($arrStrDados["AMI_ID"])){
                $areaMinisterial->setId($arrStrDados["AMI_ID"]);
            }
            if(isset($arrStrDados["AMI_Descricao"])){
                $areaMinisterial->setDescricao($arrStrDados["AMI_Descricao"]);
            }
            $obj->setObjAreaMinisterial($areaMinisterial);
            //area ministerial
            
            // endereco
            $objEndereco = new Endereco();
            
            if(isset($arrStrDados["MIN_EnderecoCep"])){
                $objEndereco->setCep($arrStrDados["MIN_EnderecoCep"]);
            }
            
            if(isset($arrStrDados["MIN_EnderecoLogradouro"])){
                $objEndereco->setLogradouro($arrStrDados["MIN_EnderecoLogradouro"]);
            }
            
            if(isset($arrStrDados["MIN_EnderecoNumero"])){
                $objEndereco->setNumero($arrStrDados["MIN_EnderecoNumero"]);
            }
            
            if(isset($arrStrDados["MIN_EnderecoComplemento"])){
                $objEndereco->setComplemento($arrStrDados["MIN_EnderecoComplemento"]);
            }
            
            if(isset($arrStrDados["MIN_EnderecoBairro"])){
                $objEndereco->setBairro($arrStrDados["MIN_EnderecoBairro"]);
            }
            
            if(isset($arrStrDados["MIN_EnderecoPontoReferencia"])){
                $objEndereco->setPontoReferencia($arrStrDados["MIN_EnderecoPontoReferencia"]);
            }
            
            if(isset($arrStrDados["MIN_EnderecoCidade"])){
                $objEndereco->setCidade($arrStrDados["MIN_EnderecoCidade"]);
            }
            
            if(isset($arrStrDados["MIN_EnderecoUf"])){
                $objEndereco->setUf($arrStrDados["MIN_EnderecoUf"]);
            }
            
            $obj->setEndereco($objEndereco);
            
            if(isset($arrStrDados["MIN_DataHoraCadastro"])){
                $obj->setDataHoraCadastro($arrStrDados["MIN_DataHoraCadastro"]);
            }else{
                $obj->setDataHoraCadastro(date("Y-m-d H:i:s"));
            }
            
            if(isset($arrStrDados["MIN_Status"])){
                $obj->setStatus($arrStrDados["MIN_Status"]);
            }else{
                $obj->setStatus("A");
            }
            
            return $obj;
        }
        
        public function salvar($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            
            if($obj->getId() == ""){                
                return RepoMinisterio::getInstance()->salvar($obj);
            }else{ 
                return RepoMinisterio::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = new Ministerio();
            $obj->setId($arrStrDados["MIN_ID"][0]);
            return RepoMinisterio::getInstance()->excluir($obj);
        }
    }
?>