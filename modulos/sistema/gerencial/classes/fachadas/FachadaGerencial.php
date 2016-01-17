<?php
    // codificação utf-8
    class FachadaGerencial{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new FachadaGerencial();
            }

            return self::$objInstance;
        }
        
        // ####### CADASTRO #######
        // USUARIO        
        public function consultarUsuario($arrStrFiltros){
            return NegUsuario::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarUsuario($arrStrDados){
            return NegUsuario::getInstance()->salvar($arrStrDados);
        }
        public function registrarAcessoUsuario($arrStrDados){
            return NegUsuario::getInstance()->registrarAcesso($arrStrDados);
        }
        public function excluirUsuario($arrStrDados){
            return NegUsuario::getInstance()->excluir($arrStrDados);
        }
        
        // MODULO / SUBMODULO        
        public function consultarModuloCategoria($arrStrFiltros){
            return NegModuloCategoria::getInstance()->consultar($arrStrFiltros);
        }
        public function consultarModulo($arrStrFiltros){
            return NegModulo::getInstance()->consultar($arrStrFiltros);
        }
        
        // PARAMETROS        
        public function consultarParametro($arrStrFiltros){
            return NegParametro::getInstance()->consultar($arrStrFiltros);
        } 
        public function salvarParametro($arrStrDados){
            return NegParametro::getInstance()->salvar($arrStrDados);
        }
        
        // FORMULARIOS       
        public function consultarAcao($arrStrFiltros){
            return NegAcao::getInstance()->consultar($arrStrFiltros);
        }        
        public function consultarAcoesPermitidas($arrStrFiltros){
            return NegAcao::getInstance()->consultarAcoesPermitidas($arrStrFiltros);
        }        
        public function consultarFormulario($arrStrFiltros){
            return NegFormulario::getInstance()->consultar($arrStrFiltros);
        }        
        public function salvarFormulario($arrStrDados){              
            return NegFormulario::getInstance()->salvar($arrStrDados);
        }
        public function excluirFormulario($arrStrDados){              
            return NegFormulario::getInstance()->excluir($arrStrDados);
        }
                
        // PERMISSOES        
        public function salvarPermissaoGrupo($arrStrDados){
            return NegPermissao::getInstance()->salvarPermissaoGrupo($arrStrDados);
        }
        public function salvarPermissaoUsuario($arrStrDados){            
            return NegPermissao::getInstance()->salvarPermissaoUsuario($arrStrDados);
        }
        public function consultarPermissaoGrupo($arrStrFiltros){
            return NegPermissao::getInstance()->consultarPermissaoGrupo($arrStrFiltros);
        }
        public function consultarPermissaoUsuario($arrStrFiltros){
            return NegPermissao::getInstance()->consultarPermissaoUsuario($arrStrFiltros);
        }
        public function consultarGrupo($arrStrFiltros){
            return NegGrupo::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarGrupo($arrStrDados){
            return NegGrupo::getInstance()->salvar($arrStrDados);
        }
        public function excluirGrupo($arrStrDados){
            return NegGrupo::getInstance()->excluir($arrStrDados);
        }
         
        // PESSOA
        public function consultarPessoa($arrStrFiltros){
            return NegPessoa::getInstance()->consultar($arrStrFiltros);
        }
        public function consultarPessoaJSON($arrStrFiltros){
            return NegPessoa::getInstance()->consultarJSON($arrStrFiltros);
        }
        // #######
        
        // CADASTRO
        
        // UTILITARIOS
        // #######        
        public function consultarDiasSemana($arrStrFiltros){
            return NegDiaSemana::getInstance()->consultar($arrStrFiltros);
        }
        // #######
                
        public function consultarUsuarioSenha($arrStrFiltros){
            return NegUsuario::getInstance()->consultarUsuarioSenha($arrStrFiltros);
        }        
        public function alterarSenhaUsuario($arrStrDados){
            return NegUsuario::getInstance()->alterarSenha($arrStrDados);
        }
        public function recuperarSenha($arrStrFiltros){
            return NegUsuario::getInstance()->recuperarSenha($arrStrFiltros);
        }
        
        //PessoaTelefone
        public function consultarTelefonePessoa($arrStrFiltros){
            return NegPessoaTelefone::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarTelefonePessoa($arrStrFiltros){
            return NegPessoaTelefone::getInstance()->salvar($arrStrFiltros);
        }
        public function excluirTelefonePessoa($arrStrFiltros){
            return NegPessoaTelefone::getInstance()->excluir($arrStrFiltros);
        }
        //PessoaTelefone
        
        //PessoaEmail
        public function consultarEmailPessoa($arrStrFiltros){
            return NegPessoaEmail::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarEmailPessoa($arrStrFiltros){
            return NegPessoaEmail::getInstance()->salvar($arrStrFiltros);
        }
        public function excluirEmailPessoa($arrStrFiltros){
            return NegPessoaEmail::getInstance()->excluir($arrStrFiltros);
        }
        //PessoaEmail
        
        //parametro email e fone
        public function consultarTelefoneParametro(){
            return NegParametroFone::getInstance()->consultar();
        }
        
        public function consultarEmailParametro(){
            return NegParametroEmail::getInstance()->consultar();
        }
        //parametro email e fone
    }
?>