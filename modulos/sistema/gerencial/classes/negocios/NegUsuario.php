<?php
    // codificação utf-8
    class NegUsuario{
        private static $objInstance;
        
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegUsuario();
            }

            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){
            $arrStrDados = RepoUsuario::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        
                        // formata a data
                        $arrStrDados[$intI]["USU_DataHoraCadastro"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["USU_DataHoraCadastro"]);
                        $arrStrDados[$intI]["USU_DataHoraUltimoAcesso"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["USU_DataHoraUltimoAcesso"]);
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta
                    $arrStrFiltrosTotal = array();
                    $arrStrFiltrosTotal["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoUsuario::getInstance()->consultar($arrStrFiltrosTotal); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }
        
        public function consultarUsuarioSenha($arrStrFiltros){
            $arrStrDados = RepoUsuario::getInstance()->consultarUsuarioSenha($arrStrFiltros);
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
                   
                }
            }

            return $arrObjsRetorno;
        }
        private function factory($arrStrDados){
            $obj = new Usuario();
            
            if(isset($arrStrDados["USU_ID"])){
                $obj->setId($arrStrDados["USU_ID"]);
            }
            
            $objGrupo = new Grupo();

            if(isset($arrStrDados["GRU_ID"])){
                $objGrupo->setId($arrStrDados["GRU_ID"]);
                
                if(isset($arrStrDados["GRU_Descricao"])){
                    $objGrupo->setDescricao($arrStrDados["GRU_Descricao"]);
                }
            }
            
            $obj->setGrupo($objGrupo);
            $obj->setNome($arrStrDados["USU_Nome"]);
            $obj->setLogin($arrStrDados["USU_Login"]);
            $obj->setEmail($arrStrDados["USU_Email"]);
            $obj->setTelefone($arrStrDados["USU_Telefone"]);
            
            if(isset($arrStrDados["USU_DataHoraCadastro"])){
                $obj->setDataHoraCadastro($arrStrDados["USU_DataHoraCadastro"]);
            }else{
                $obj->setDataHoraCadastro(date("Y-m-d H:i:s"));
            }
            
            if(isset($arrStrDados["USU_DataHoraUltimoAcesso"])){
                $obj->setDataHoraUltimoAcesso($arrStrDados["USU_DataHoraUltimoAcesso"]);
            }
            
            if(isset($arrStrDados["USU_Status"])){
                $obj->setStatus($arrStrDados["USU_Status"]);
            }else{
                $obj->setStatus("A");
            }
                       
            return $obj;
        }
        
        public function registrarAcesso($arrStrDados){
            RepoUsuario::getInstance()->registrarAcesso($arrStrDados);
        }
        
        public function alterarSenha($arrStrDados){
            $arrStrDados["USU_Nova_Senha"] = md5($arrStrDados["USU_Nova_Senha"]);            
            
            if(RepoUsuario::getInstance()->alterarSenha($arrStrDados)){
                // envia um email informando que a senha foi alterada
                require_once('../../../../lib/PHPMailer_v2.0.4/class.phpmailer.php');
                
                // consulta os dados do usuário
                $arrStrFiltrosUsuario = array();
                $arrStrFiltrosUsuario["USU_ID"] = $arrStrDados["USU_ID"];
                $arrStrDadosUsuario = RepoUsuario::getInstance()->consultar($arrStrFiltrosUsuario);
                
                // Inicia a classe PHPMailer
                $objMail = new PHPMailer();
                $objMail->IsSMTP(); // Define que a mensagem será SMTP
                
                // define o destinatário
                $objMail->AddAddress(strtolower($arrStrDadosUsuario[0]["USU_Email"]), $arrStrDadosUsuario[0]["USU_Login"]);
                $objMail->IsHTML(true);
                
                // confira a mensagem
                $objMail->Subject  = "Alteração de Senha [".$objMail->FromName."]"; // Assunto da mensagem
                $objMail->Body = file_get_contents('../../../../../../../../templates/igreja_conectada/alteracao_senha.html');
                
                // preenchimento das hashtags do arquivo
                $objMail->Body = str_replace("#destinatario", $arrStrDadosUsuario[0]["USU_Login"], $objMail->Body);
                $objMail->Body = str_replace("#datahora", date("d/m/Y")." às ".date("H:i:s"), $objMail->Body);
                $objMail->Body = str_replace("#ambiente", SISTEMA_HTTP, $objMail->Body);
                                
                $boolEnviado = $objMail->Send();
                $objMail->ClearAllRecipients(); 
                
                if(!$boolEnviado) {
                    throw new Exception($objMail->ErrorInfo);
                } 
                
                return true;
            }
        }
        
        public function recuperarSenha($arrStrFiltros){            
            $arrObjsRetorno = $this->consultar($arrStrFiltros);
            
            if($arrObjsRetorno != null){                                
                $arrObjs = $arrObjsRetorno["objects"];
                $objUsuario = new Usuario();
                $objUsuario = $arrObjs[0];
                
                
                $strNovaSenha = uniqid();                
                $arrDadosAlteracao["USU_ID"] = $objUsuario->getId();                
                $arrDadosAlteracao["USU_Nova_Senha"] = md5($strNovaSenha); 
                
                if(RepoUsuario::getInstance()->alterarSenha($arrDadosAlteracao)){
                    // envia um email informando que a senha foi alterada
                    require_once('../../../../lib/PHPMailer_v2.0.4/class.phpmailer.php');

                    // consulta os dados do usuário
                    $arrStrFiltrosUsuario = array();
                    $arrStrFiltrosUsuario["USU_ID"] = $objUsuario->getId();
                    $arrStrDadosUsuario = RepoUsuario::getInstance()->consultar($arrStrFiltrosUsuario);

                    // Inicia a classe PHPMailer
                    $objMail = new PHPMailer();
                    $objMail->IsSMTP(); // Define que a mensagem será SMTP

                    // define o destinatário
                    $objMail->AddAddress(strtolower($arrStrDadosUsuario[0]["USU_Email"]), $arrStrDadosUsuario[0]["USU_Login"]);
                    $objMail->IsHTML(true);

                    // confira a mensagem
                    $objMail->Subject  = "Alteração de Senha [".$objMail->FromName."]"; // Assunto da mensagem
                    $objMail->Body = file_get_contents('../../../../../../../../templates/igreja_conectada/recuperacao_senha.html');

                    // preenchimento das hashtags do arquivo
                    $objMail->Body = str_replace("#destinatario", $arrStrDadosUsuario[0]["USU_Login"], $objMail->Body);
                    $objMail->Body = str_replace("#datahora", date("d/m/Y")." às ".date("H:i:s"), $objMail->Body);
                    $objMail->Body = str_replace("#novasenha", $strNovaSenha, $objMail->Body);

                    $boolEnviado = $objMail->Send();
                    $objMail->ClearAllRecipients(); 

                    if(!$boolEnviado) {
                        throw new Exception($objMail->ErrorInfo);
                    }       
                    
                    return true;
                }else{
                    throw new Exception("Erro ao executar a SQL de alteração de senha.");
                }                
            }else{
                throw new Exception("O E-mail informado não foi localizado em nossa base de dados.");
            }            
        }
        
        public function salvar($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            
            if(isset($arrStrDados["USU_Senha"])){
                $obj->setSenha(md5($arrStrDados["USU_Senha"]));
            }
            
            if($obj->getId() != ""){
                $arrALteraSenha["USU_Nova_Senha"] = $obj->getSenha();
                $arrALteraSenha["USU_ID"] = $obj->getId();
                RepoUsuario::getInstance()->alterarSenha($arrALteraSenha);
                return RepoUsuario::getInstance()->alterar($obj);
            }

            return RepoUsuario::getInstance()->salvar($obj);
        }
        
        public function excluir($arrStrDados){            
            $obj = new Usuario();
            $obj->setId($arrStrDados["USU_ID"][0]);
            return RepoUsuario::getInstance()->excluir($obj);
        }
    }
?>