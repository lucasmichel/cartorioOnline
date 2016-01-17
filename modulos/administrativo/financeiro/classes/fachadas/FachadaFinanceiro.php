<?php
    // codificação utf-8
    class FachadaFinanceiro{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new FachadaFinanceiro();
            }

            return self::$objInstance;
        }
        
        public function consultarBanco($arrStrFiltros){            
            return NegBanco::getInstance()->consultar($arrStrFiltros);
        }        
        public function salvarBanco($arrStrDados){
            return NegBanco::getInstance()->salvar($arrStrDados);
        }
        public function excluirBanco($arrStrDados){
            return NegBanco::getInstance()->excluir($arrStrDados);
        }
        
        public function consultarCentroCusto($arrStrDados){
            return NegCentroCusto::getInstance()->consultar($arrStrDados);
        }        
        public function salvarCentroCusto($arrStrDados){
            return NegCentroCusto::getInstance()->salvar($arrStrDados);
        }
        public function excluirCentroCusto($arrStrDados){
            return NegCentroCusto::getInstance()->excluir($arrStrDados);
        }
        
        public function consultarContaBancaria($arrStrFiltros){
            return NegContaBancaria::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarContaBancaria($arrStrDados){
            return NegContaBancaria::getInstance()->salvar($arrStrDados);
        }
        public function excluirContaBancaria($arrStrDados){
            return NegContaBancaria::getInstance()->excluir($arrStrDados);
        }
        public function getSaldoContaBancaria($arrStrDados){
            return NegContaBancaria::getInstance()->getSaldoContaBancaria($arrStrDados);
        }
        
        public function consultarPlanoConta($arrStrFiltros){
            return NegPlanoConta::getInstance()->consultar($arrStrFiltros);
        }        
        public function salvarPlanoConta($arrStrDados){
            return NegPlanoConta::getInstance()->salvar($arrStrDados);
        }
        public function excluirPlanoConta($arrStrDados){
            return NegPlanoConta::getInstance()->excluir($arrStrDados);
        }
        
        public function consultarFormaPagamento($arrStrFiltros){
            return NegFormaPagamento::getInstance()->consultar($arrStrFiltros);
        }        
        public function salvarFormaPagamento($arrStrDados){
            return NegFormaPagamento::getInstance()->salvar($arrStrDados);
        } 
        public function excluirFormaPagamento($arrStrDados){
            return NegFormaPagamento::getInstance()->excluir($arrStrDados);
        }
        
        public function consultarContribuicao($arrStrDados){
            return NegContribuicao::getInstance()->consultar($arrStrDados);
        }        
        public function salvarContribuicao($arrStrDados){
            return NegContribuicao::getInstance()->salvar($arrStrDados);
        }
        public function excluirContribuicao($arrStrDados){
            return NegContribuicao::getInstance()->excluir($arrStrDados);
        }
        
        public function consultarFluxoCaixa($arrStrFiltros){
            return NegFluxoCaixa::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarFluxoCaixa($arrStrDados){
            return NegFluxoCaixa::getInstance()->salvar($arrStrDados);
        }
        public function excluirFluxoCaixa($arrStrDados){
            return NegFluxoCaixa::getInstance()->excluir($arrStrDados);
        }
        
        public function consultarContaPagarReceber($arrStrFiltros){
            return NegContaPagarReceber::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarContaPagarReceber($arrStrDados){
            return NegContaPagarReceber::getInstance()->salvar($arrStrDados);
        }
        public function consultarParcelasContaPagarReceber($arrStrDados){
            return NegContaPagarReceber::getInstance()->consultarParcelas($arrStrDados);
        }
        public function excluirContaPagarReceber($arrStrDados){
            return NegContaPagarReceber::getInstance()->excluir($arrStrDados);
        }
        public function pagarParcelaContaPagarReceber($arrStrDados){
            return NegContaPagarReceber::getInstance()->pagarParcela($arrStrDados);
        }
        
        public function consultarContaTransferencia($arrStrFiltros){
            return NegContaTransferencia::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarContaTransferencia($arrStrDados){
            return NegContaTransferencia::getInstance()->salvar($arrStrDados);
        }        
        public function excluirContaTransferencia($arrStrDados){
            return NegContaTransferencia::getInstance()->excluir($arrStrDados);
        }
        
        public function consultarFornecedor($arrStrFiltros){            
            return NegFornecedor::getInstance()->consultar($arrStrFiltros);
        }         
        public function salvarFornecedor($arrStrDados){
            return NegFornecedor::getInstance()->salvar($arrStrDados);
        }
        public function excluirFornecedor($arrStrDados){
            return NegFornecedor::getInstance()->excluir($arrStrDados);
        }
        
        //FornecedorTelefone
        public function consultarTelefoneFornecedor($arrStrFiltros){
            return NegFornecedorTelefone::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarTelefoneFornecedor($arrStrFiltros){
            return NegFornecedorTelefone::getInstance()->salvar($arrStrFiltros);
        }
        public function excluirTelefoneFornecedor($arrStrFiltros){
            return NegFornecedorTelefone::getInstance()->excluir($arrStrFiltros);
        }
        //FornecedorTelefone
        
        //FornecedorEmail
        public function consultarEmailFornecedor($arrStrFiltros){
            return NegFornecedorEmail::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarEmailFornecedor($arrStrFiltros){
            return NegFornecedorEmail::getInstance()->salvar($arrStrFiltros);
        }
        public function excluirEmailFornecedor($arrStrFiltros){
            return NegFornecedorEmail::getInstance()->excluir($arrStrFiltros);
        }
        //FornecedorEmail
        
        
        
        
        public function consultarLote($arrStrFiltros){            
            return NegLote::getInstance()->consultar($arrStrFiltros);
        }        
        public function salvarLote($arrStrDados){
            return NegLote::getInstance()->salvar($arrStrDados);
        }
        public function excluirLote($arrStrDados){
            return NegLote::getInstance()->excluir($arrStrDados);
        }
        
    }
?>
