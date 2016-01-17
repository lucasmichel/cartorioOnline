<?php
    // codificação utf-8
    class FachadaLivroAuxiliar{
        private static $objInstance;
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new FachadaLivroAuxiliar();
            }

            return self::$objInstance;
        }
        
        
        //livro
        public function consultarLivroAuxiliar($arrStrFiltros){
            return NegLivroAuxiliar::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarLivroAuxiliar($arrStrDados){
            return NegLivroAuxiliar::getInstance()->salvar($arrStrDados);
        }
        public function excluirLivroAuxiliar($arrStrDados){
            return NegLivroAuxiliar::getInstance()->excluir($arrStrDados);
        }
        public function getPermissaoAddFolhaLivro($arrStrDados){
            return NegLivroAuxiliar::getInstance()->getPermissaoAddFolhaLivro($arrStrDados);
        }
        
        
        
        //folha
        public function consultarFolhaAuxiliar($arrStrFiltros){
            return NegFolhaAuxiliar::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarFolhaAuxiliar($arrStrDados){
            return NegFolhaAuxiliar::getInstance()->salvar($arrStrDados);
        }
        public function excluirFolhaAuxiliar($arrStrDados){
            return NegFolhaAuxiliar::getInstance()->excluir($arrStrDados);
        }
        public function getPermissaoAddLinhaFolha($arrStrDados){
            return NegFolhaAuxiliar::getInstance()->getPermissaoAddLinhaFolha($arrStrDados);
        }
        
        //linha
        public function consultarLinhaAuxiliar($arrStrFiltros){
            return NegLinhaAuxiliar::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarLinhaAuxiliar($arrStrDados){
            return NegLinhaAuxiliar::getInstance()->salvar($arrStrDados);
        }
        public function excluirLinhaAuxiliar($arrStrDados){
            return NegLinhaAuxiliar::getInstance()->excluir($arrStrDados);
        }
        
    }
?>