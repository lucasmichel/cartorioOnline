<?php
    // codificação utf-8
    class FachadaCadastro{
        private static $objInstance;
        private function __construct() {}
        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new FachadaCadastro();
            }
            return self::$objInstance;
        }
        // MEMBRO 
        public function consultarMembro($arrStrFiltros){
            return NegMembro::getInstance()->consultar($arrStrFiltros);
        }        
        public function salvarMembro($arrStrDados){
            return NegMembro::getInstance()->salvar($arrStrDados);
        }
        
        // MINISTERIO
        public function consultarMinisterio($arrStrFiltros){
            return NegMinisterio::getInstance()->consultar($arrStrFiltros);
        }
        public function salvarMinisterio($arrStrDados){
            return NegMinisterio::getInstance()->salvar($arrStrDados);
        }
        public function consultarMembroMinisterio($arrStrFiltros){
            return NegMembroMinisterio::getInstance()->consultar($arrStrFiltros);
        }
        public function excluirMinisterio($arrStrDados){
            return NegMinisterio::getInstance()->excluir($arrStrDados);
        }
        
        // FUNCIONARIO
        public function consultarFuncionario($arrStrFiltros){
            return NegFuncionario::getInstance()->consultar($arrStrFiltros);
        }       
        public function salvarFuncionario($arrStrDados){
            return NegFuncionario::getInstance()->salvar($arrStrDados);
        }
        public function excluirFuncionario($arrStrDados){
            return NegFuncionario::getInstance()->excluir($arrStrDados);
        }
        
        // MOTIVOS DESLIGAMENTO
        public function consultarStatusMembro($arrStrFiltros){
            return NegStatusMembro::getInstance()->consultar($arrStrFiltros);
        }       
        public function salvarStatusMembro($arrStrDados){
            return NegStatusMembro::getInstance()->salvar($arrStrDados);
        }
        public function excluirStatusMembro($arrStrDados){
            return NegStatusMembro::getInstance()->excluir($arrStrDados);
        }        
        
        // ATIVIDADE
        public function consultarAtividade($arrStrFiltros){
            return NegAtividade::getInstance()->consultar($arrStrFiltros);
        }       
        public function salvarAtividade($arrStrDados){
            return NegAtividade::getInstance()->salvar($arrStrDados);
        }
        public function consultarAtividadeMembro($arrStrFiltros){
            return NegAtividadeMembro::getInstance()->consultar($arrStrFiltros);
        } 
        public function excluirAtividade($arrStrDados){
            return NegAtividade::getInstance()->excluir($arrStrDados);
        }
        
        //CONGREGAÇÃO
        public function consultarCongregacao($arrStrFiltros){
            return NegCongregacao::getInstance()->consultar($arrStrFiltros);
        }       
        public function salvarCongregacao($arrStrDados){
            return NegCongregacao::getInstance()->salvar($arrStrDados);
        }
        public function excluirCongregacao($arrStrDados){
            return NegCongregacao::getInstance()->excluir($arrStrDados);
        }
        
        // MALA DIRETA
        public function consultarMalaDireta($arrStrFiltros){
            return NegMalaDireta::getInstance()->consultar($arrStrFiltros);
        }        
        public function salvarMalaDireta($arrStrDados){
            return NegMalaDireta::getInstance()->salvar($arrStrDados);
        }
        public function excluirMalaDireta($arrStrDados){
            return NegMalaDireta::getInstance()->excluir($arrStrDados);
        }
        public function consultarPessoasMalaDireta($arrStrFiltros){
            return NegMalaDireta::getInstance()->consultarPessoas($arrStrFiltros);
        }
        public function enviarEmailMalaDireta($arrStrFiltros){
            return NegMalaDireta::getInstance()->enviarEmail($arrStrFiltros);
        }
        
        // DADOS ECLESIASTICOS
        public function consultarDadosEclesiasticos($arrStrFiltros){
            return NegDadosEclesiasticos::getInstance()->consultar($arrStrFiltros);
        }       
        public function salvarDadosEclesiasticos($arrStrDados){
            return NegDadosEclesiasticos::getInstance()->salvar($arrStrDados);
        }
        
        
        // RENDA SALARIO
        public function consultarRendaSalario($arrStrFiltros){
            return NegRendaSalario::getInstance()->consultar($arrStrFiltros);
        }       
        public function salvarRendaSalario($arrStrDados){
            return NegRendaSalario::getInstance()->salvar($arrStrDados);
        }
        public function excluirRendaSalario($arrStrDados){
            return NegRendaSalario::getInstance()->excluir($arrStrDados);
        }

        // NÍVEL DE ESCOLARIDADE
        public function consultarNivelEscolaridade($arrStrFiltros){
            return NegNivelEscolaridade::getInstance()->consultar($arrStrFiltros);
        }        
        public function salvarNivelEscolaridade($arrStrDados){
            return NegNivelEscolaridade::getInstance()->salvar($arrStrDados);
        }
        public function excluirNivelEscolaridade($arrStrDados){
            return NegNivelEscolaridade::getInstance()->excluir($arrStrDados);
        }
        
        // ESTADO CIVIL
        public function consultarEstadoCivil($arrStrFiltros){
            return NegEstadoCivil::getInstance()->consultar($arrStrFiltros);
        }        
        public function salvarEstadoCivil($arrStrDados){
            return NegEstadoCivil::getInstance()->salvar($arrStrDados);
        }
        public function excluirEstadoCivil($arrStrDados){
            return NegEstadoCivil::getInstance()->excluir($arrStrDados);
        }
        
        // ÁREA DE ATUAÇÃO
        public function consultarAreaAtuacao($arrStrFiltros){
            return NegAreaAtuacao::getInstance()->consultar($arrStrFiltros);
        }        
        public function salvarAreaAtuacao($arrStrDados){
            return NegAreaAtuacao::getInstance()->salvar($arrStrDados);
        }
        public function excluirAreaAtuacao($arrStrDados){
            return NegAreaAtuacao::getInstance()->excluir($arrStrDados);
        }
        
        // PROCESSO DE DELISGAMENTO
        public function consultarMotivoDesligamentoMembro($arrStrFiltros){
            return NegMotivosDesligamentoMembro::getInstance()->consultar($arrStrFiltros);
        } 
        
        // FAMILIA
        public function consultarFamiliaMembro($arrStrFiltros){
            return NegFamilia::getInstance()->consultar($arrStrFiltros);
        }        
        public function validarRelacionamentoFamiliar($arrStrFiltros){
            return NegFamilia::getInstance()->validarRelacionamentoFamiliar($arrStrFiltros);
        }
        
        // ÁREAS MINISTERIAIS
        public function consultarAreaMinisterial($arrStrFiltros){
            return NegAreaMinisterial::getInstance()->consultar($arrStrFiltros);
        }        
        public function salvarAreaMinisterial($arrStrDados){
            return NegAreaMinisterial::getInstance()->salvar($arrStrDados);
        }
        public function excluirAreaMinisterial($arrStrDados){
            return NegAreaMinisterial::getInstance()->excluir($arrStrDados);
        }
    }
?>