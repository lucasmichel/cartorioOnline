<?php
    // codificação utf-8
    class FachadaLivroPrevio{
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new FachadaLivroPrevio();
            }
            return self::$objInstance;
        }
        
        
        //livro
        public function consultarLivroPrevio($arrStrFiltros){
            return NegLivroPrevio::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarLivroPrevio($arrStrDados){
            return NegLivroPrevio::getInstance()->salvar($arrStrDados);
        }
        public function excluirLivroPrevio($arrStrDados){
            return NegLivroPrevio::getInstance()->excluir($arrStrDados);
        }
        public function getPermissaoAddFolhaLivro($arrStrDados){
            return NegLivroPrevio::getInstance()->getPermissaoAddFolhaLivro($arrStrDados);
        }
        
        
        
        //folha
        public function consultarFolhaPrevio($arrStrFiltros){
            return NegFolhaPrevio::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarFolhaPrevio($arrStrDados){
            return NegFolhaPrevio::getInstance()->salvar($arrStrDados);
        }
        public function excluirFolhaPrevio($arrStrDados){
            return NegFolhaPrevio::getInstance()->excluir($arrStrDados);
        }
        public function getPermissaoAddLinhaFolha($arrStrDados){
            return NegFolhaPrevio::getInstance()->getPermissaoAddLinhaFolha($arrStrDados);
        }
        
        //linha
        public function consultarLinhaPrevio($arrStrFiltros){
            return NegLinhaPrevio::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarLinhaPrevio($arrStrDados){
            return NegLinhaPrevio::getInstance()->salvar($arrStrDados);
        }
        public function excluirLinhaPrevio($arrStrDados){
            return NegLinhaPrevio::getInstance()->excluir($arrStrDados);
        }
        public function alterarStatusConclusao($arrStrDados){
            return NegLinhaPrevio::getInstance()->alterarStatusConclusao($arrStrDados);
        }
        
    }
?>