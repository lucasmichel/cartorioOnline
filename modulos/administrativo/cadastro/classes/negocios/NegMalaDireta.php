<?php
    // codificação utf-8
    class NegMalaDireta{
        private static $objInstance;
        private function __construct() {}
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegMalaDireta();
            }
            return self::$objInstance;
        }

       public function consultar($arrStrFiltros){            
            $arrStrDados = RepoMalaDireta::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        $arrStrDados[$intI]["MAD_DataHoraCadastro"] = $arrObjs[$intI]->getDataHoraCadastro();     
                        $arrStrDados[$intI]["MAD_DataHoraAlteracao"] = $arrObjs[$intI]->getDataHoraAlteracao();     
                    }
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoMalaDireta::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }
            return $arrObjsRetorno;
        }
        
        public function enviarEmail($arrStrDados){            
            //pega os id da malla e busca
            $arrConsultaMala = array();
            $objMalaDireta = new MalaDireta();            
            if(isset($arrStrDados["MAD_ID"])){
                $arrConsultaMala["MAD_ID"] = $arrStrDados["MAD_ID"];
            }else{
                throw new Exception("Mala direta não localizada.");
            }            
            $arrDadosMala = $this->consultar($arrConsultaMala);
            if($arrDadosMala!=null && count($arrDadosMala)>1){
                $objMalaDireta = $arrDadosMala["objects"][0]; //COM ISSO TENHO A MALA 
                
                if(isset($arrStrDados["PES_ID"])){                    
                    $objPessoa = new Pessoa();                        
                    $arrConsultaPessoa["PES_ID"] = $arrStrDados["PES_ID"];                        
                    $arrDadosPessoa = NegPessoa::getInstance()->consultar($arrConsultaPessoa);
                    if($arrDadosPessoa!=null ){
                    //if($arrDadosPessoa!=null && count($arrDadosPessoa)>1 ){
                        $objPessoa = $arrDadosPessoa[0];                        
                        //cadastra a junção de pessoa com a mala direta
                        $arrDadosMalaPessoa["PES_ID"] = $objPessoa->getId();
                        $arrDadosMalaPessoa["MAD_ID"] = $objMalaDireta->getId();
                        $arrDadosMalaPessoa["MDP_DataHoraEnvio"] = date("d/m/Y H:i:s");
                        $idMalaDiretaPessoa = NegMalaDiretaPessoa::getInstance()->salvar($arrDadosMalaPessoa);                        
                        //com o objeto pessoa manda agora pra função executaEnviaEmail();                                               
                        return $this->executaEnviarEmail($idMalaDiretaPessoa, $objPessoa, $objMalaDireta );                        
                    }else{
                        return false;
                        //throw new Exception("Pessoa não localizada.");
                    }
                    
                }else{
                    return false;
                    //throw new Exception("Pessoa não localizada.");
                }
            }else{
                return false;
                //throw new Exception("Mala direta não localizada.");
            }
        }
        
        private function executaEnviarEmail($idMalaDiretaPessoa, Pessoa $objPessoa, MalaDireta $objMalaDireta){
            
            // envia um email informando que a senha foi alterada
            require_once('../../../../lib/PHPMailer_v2.0.4/class.phpmailer.php');
            
            //BUSCA OS EMAISL DAS PESSOAS E CRIA UM LAÇO DE ENVIO
            $arrConsultaEmail["PES_ID"] = $objPessoa->getId();
            $arrObjEmail = NegPessoaEmail::getInstance()->consultar();
            if($arrObjEmail != null){
                $arrObjEmail = $arrObjEmail["objects"];
                for($intI=0; $intI<count($arrObjEmail); $intI++){
                    $objPessoaEmail = New PessoaEmail();
                    $objPessoaEmail = $arrObjEmail[$intI];
                    
                    $objPessoaEmail->getEmail();
                }
                
            }else{
                return true;
            }
            
            

            // consulta os dados do usuário
            /*$arrStrFiltrosUsuario = array();
            $arrStrFiltrosUsuario["USU_ID"] = $objUsuario->getId();
            $arrStrDadosUsuario = RepoUsuario::getInstance()->consultar($arrStrFiltrosUsuario);*/

            // Inicia a classe PHPMailer
            $objMail = new PHPMailer();
            $objMail->IsSMTP(); // Define que a mensagem será SMTP

            // define o destinatário
            $objMail->AddAddress(strtolower($objPessoa->getEmailPrimario()), $objPessoa->getNome());
            $objMail->IsHTML(true);

            // confira a mensagem
            //$objMail->Subject  = "Alteração de Senha [".$objMail->FromName."]"; // Assunto da mensagem
            $objMail->Subject  = $objMalaDireta->getAssunto(); // Assunto da mensagem
            $objMail->Body = file_get_contents('../../../../../../../templates/igreja_conectada/mala_direta.html');
            
            $endereco = HOST_HTTP."sig/modulos/administrativo/cadastro/registraVisualizacaoEmail.php?MDP_ID=".$idMalaDiretaPessoa ;
            
            //$indentificadorEmail = "<img src='".$endereco."' />";
            
            /*$conteudo = $indentificadorEmail . $objMalaDireta->getConteudo();            
            $objMail->Body = $conteudo;*/

            // preenchimento das hashtags do arquivo
            $objMail->Body = str_replace("#conteudo", $objMalaDireta->getConteudo() , $objMail->Body);
            $objMail->Body = str_replace("#imagem_verificacao", $endereco, $objMail->Body);
            

            
            $boolEnviado = $objMail->Send();
            $objMail->ClearAllRecipients(); 

            if(!$boolEnviado) {
                //throw new Exception($objMail->ErrorInfo);
                return false;
                
            }else{
                return true;
            }
        }
        
       public function consultarPessoas($arrStrFiltros){
            $tipoFilro = "TODOS";
            $filtro = "";
            if(isset($arrStrFiltros["filtrarPor"])){
                $tipoFilro = $arrStrFiltros["filtrarPor"];
            }            
            if(isset($arrStrFiltros["filtro"])){
                $filtro = $arrStrFiltros["filtro"];
            }
            switch ($tipoFilro) {
                case "FUNCIONARIO":
                    $instanciaNegocio= NegFuncionario::getInstance();
                    return $this->consultarPessoaMala($filtro, $instanciaNegocio);                    
                case "MEMBRO":
                    $instanciaNegocio= NegMembro::getInstance();
                    return $this->consultarPessoaMala($filtro, $instanciaNegocio);                    
                    
                case "VISITANTE":
                    $instanciaNegocio = NegVisitante::getInstance();
                    return $this->consultarPessoaMala($filtro, $instanciaNegocio);  
                    
                case "TODOS":
                    $instanciaNegocio = NegPessoa::getInstance();                    
                    $arrObjPessoa = $this->consultarPessoaMala($filtro, $instanciaNegocio);
                    if($arrObjPessoa!=null && count($arrObjPessoa) > 1){
                        //remona o array rows 
                        $arrStrDados = array();
                        for($intI = 0; $intI<count($arrObjPessoa); $intI++){
                            $objPessoa = new Pessoa();
                            $objPessoa = $arrObjPessoa[$intI];
                            $arrStrDados[$intI]["PES_ID"] = $objPessoa->getId();
                            $arrStrDados[$intI]["PES_Nome"] = $objPessoa->getNome();
                            //$arrStrDados[$intI]["PES_EmailPrimario"] = $objPessoa->getEmailPrimario();
                            //$arrStrDados[$intI]["PES_EmailSecundario"] = $objPessoa->getEmailSecundario();                         
                        }
                        $arrObjsRetorno = array();
                        $arrObjsRetorno["objects"]  = $arrObjPessoa;
                        $arrObjsRetorno["rows"]     = $arrStrDados; 
                        return $arrObjsRetorno;
                        
                    }else{
                        return null;
                    }
            }
        }
        
        private function consultarPessoaMala($filtro, $instanciaNegocio){
            $arrFiltro["PES_Status"] = "A";
            $arrFiltro["PES_Nome"] = $filtro;
            $arrStrDados = $instanciaNegocio->consultar($arrFiltro);            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){                    
                    return $arrStrDados;                    
                }else{
                    return null;
                }
            }else{
                return null;
            }
        }
        
        
        private function factory($arrStrDados){
            $obj = new MalaDireta();            
            if(isset($arrStrDados["MAD_ID"])){
                $obj->setId($arrStrDados["MAD_ID"]);
            }            
            if(isset($arrStrDados["MAD_Assunto"])){
                $obj->setAssunto($arrStrDados["MAD_Assunto"]);
            }
            if(isset($arrStrDados["MAD_Conteudo"])){
                $obj->setConteudo($arrStrDados["MAD_Conteudo"]);
            }
            if(!empty($arrStrDados["MAD_DataHoraCadastro"])){           
                $intTotOcorrencia = substr_count($arrStrDados["MAD_DataHoraCadastro"], "/");                
                if($intTotOcorrencia > 0){                    
                    $obj->setDataHoraCadastro(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["MAD_DataHoraCadastro"]));
                }else{                                        
                    $obj->setDataHoraCadastro(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["MAD_DataHoraCadastro"]));
                }                
            }else{
                $obj->setDataHoraCadastro(date("Y-m-d H:i:s"));
            }
            $usuarioCadastro = new Usuario();
            if(isset($arrStrDados["Usuario_Cadastro_Id"])){
                if(isset($arrStrDados["Usuario_Cadastro_Id"])){
                    $usuarioCadastro->setId($arrStrDados["Usuario_Cadastro_Id"]);
                }
                if(isset($arrStrDados["Usuario_Cadastro"])){
                    $usuarioCadastro->setLogin($arrStrDados["Usuario_Cadastro"]);
                }                
            }else{
                $usuarioCadastro->setId($_SESSION["USUARIO_ID"]);
            }
            $obj->setUsuarioCadastro($usuarioCadastro);
            if(!empty($arrStrDados["MAD_DataHoraAlteracao"])){           
                $intTotOcorrencia = substr_count($arrStrDados["MAD_DataHoraAlteracao"], "/");                
                if($intTotOcorrencia > 0){                    
                    $obj->setDataHoraAlteracao(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["MAD_DataHoraAlteracao"]));
                }else{                                        
                    $obj->setDataHoraAlteracao(DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados["MAD_DataHoraAlteracao"]));
                }                
            }else{
                $obj->setDataHoraAlteracao(date("Y-m-d H:i:s"));
            }            
            $usuarioAlteracao = new Usuario();
            if(isset($arrStrDados["Usuario_Alteracao_Id"])){
                if(isset($arrStrDados["Usuario_Alteracao_Id"])){
                    $usuarioAlteracao->setId($arrStrDados["Usuario_Alteracao_Id"]);
                }
                if(isset($arrStrDados["Usuario_Alteracao"])){
                    $usuarioAlteracao->setLogin($arrStrDados["Usuario_Alteracao"]);
                }                
            }else{
                $usuarioAlteracao->setId($_SESSION["USUARIO_ID"]);
            }
            $obj->setUsuarioAlteracao($usuarioAlteracao);
            return $obj;
        }
        
        public function salvar($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            //PRESEVA O HTML GERADO NO EDITOR
            $obj->setConteudo($arrStrDados["MAD_Conteudo"]);
            //PRESEVA O HTML GERADO NO EDITOR            
            if($obj->getId() == ""){                
                return RepoMalaDireta::getInstance()->salvar($obj);
            }else{ 
                return RepoMalaDireta::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));            
            return RepoMalaDireta::getInstance()->excluir($obj);
            
        }
    }
?>