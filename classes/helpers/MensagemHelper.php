<?php
    // codificação utf-8
    class MensagemHelper{
        private static $objInstance;
               
        private function __construct() {}
        
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new MensagemHelper();                
            }
            
            return self::$objInstance;
        }
        
        public function getUsuarioSenhaInvalido(){
            return "O usu&aacute;rio ou a senha est&atilde;o incorretos. Tente novamente.";
        }
        
        public function getOperacaoNaoPermitida(){
            return "Voc&ecirc; n&atilde;o tem permiss&atilde;o para realizar esta opera&ccedil;&atilde;o.";
        }
        
        public function getOperacaoRealizadaComSucesso(){
            return "Opera&ccedil;&atilde;o realizada com sucesso.";
        }
        
        public function getOperacaoNaoRealizada(){
            return "Opera&ccedil;&atilde;o n&atilde;o realizada.";
        }
        
        public function getGeradoPor($strUsuarioLogin){
            return "Gerado por <b>".$strUsuarioLogin."</b> em ".date("d/m/Y")." &agrave; ".date("H:i:s");
        }
        
        public function getPlaceHolderPesquisa(){
            return "Digite o que deseja procurar.";
        }
        
        public function getPlaceHolderData(){
            return "Ex.:".date("d/m/Y");
        }
        
        public function getPlaceHolderPesquisaDataInicial(){
            return "Ex.:".date("01/m/Y");
        }
        
        public function getPlaceHolderPesquisaDataFinal(){
            return "Ex.:".date("d/m/Y");
        }
        
        public function getOperacaoJaExisteDescricao(){
            return "J&aacute; existe registro cadastrado com esta descri&ccedil;&atilde;o.";
        }
        
        public function getOperacaoJaExisteNome(){
            return "J&aacute; existe registro cadastrado com este nome.";
        }
        
        public function getProcessando(){
            return "Processando solicita&ccedil;&atilde;o...";
        }
        
        public function getOperacaoJaExisteRegistro(){
            return "J&aacute; existe registro cadastrado com estas op&ccedil;&otilde;es.";
        }
        
        public function getOperacaoJaExisteRegistroRazaoSocialCNPJ(){
            return "J&aacute; existe registro cadastrado com esta razão social ou cnpj.";
        }
        
        public function getOperacaoJaExisteRegistroRazaoSocial(){
            return "J&aacute; existe registro cadastrado com esta razão social.";
        }
        
        public function getCancelamentoRealizadoComSucesso(){
            return "Cancelamento realizado com sucesso.";
        }
        
        public function getExtensaoArquivoInvalida(){
            return "A extensao do arquivo fornecido é inválida.";
        }
        
        public function getUploadSucesso(){
            return "Upload realizado com sucesso.";
        }
    }
?>