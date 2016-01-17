<?php
    // codificação utf-8
    class Pessoa{
        private $id;
        private $nivelEscolaridade;
        private $estadoCivil;
        private $matricula;
        private $cpf;
        private $rg;
        private $rgOrgaoEmissor;
        private $formacao; // Qual formação profissional 
        private $nome;
        private $sexo;
        private $dataNascimento;
        private $grupoSanguineo;
        private $doador;
        private $endereco;        
        private $maeNome;
        private $paiNome;
        private $observacao;
        private $foto; // endereço base64
        private $dataFalecimento;
        private $naturalidade;
        private $nascionalidade;
        private $status;
        private $dataCasamento; // preenchido apenas quando o estado civil for casado
        private $qtdFilhos;
        private $ufNascimento;
        private $dataHoraAlteracao; // preenchido no cadastro para criar a exibição do status de atualização da pessoa.
        
        public function getId() {
            return $this->id;
        }

        public function getNivelEscolaridade() {
            return $this->nivelEscolaridade;
        }

        public function getEstadoCivil() {
            return $this->estadoCivil;
        }

        public function getMatricula() {
            return $this->matricula;
        }

        public function getCpf() {
            return $this->cpf;
        }

        public function getRg() {
            return $this->rg;
        }

        public function getRgOrgaoEmissor() {
            return $this->rgOrgaoEmissor;
        }

        public function getFormacao() {
            return $this->formacao;
        }

        public function getNome() {
            return $this->nome;
        }

        public function getSexo() {
            return $this->sexo;
        }

        public function getDataNascimento() {
            return $this->dataNascimento;
        }

        public function getGrupoSanguineo() {
            return $this->grupoSanguineo;
        }

        public function getDoador() {
            return $this->doador;
        }

        public function getEndereco() {
            return $this->endereco;
        }

        public function getMaeNome() {
            return $this->maeNome;
        }

        public function getPaiNome() {
            return $this->paiNome;
        }

        public function getObservacao() {
            return $this->observacao;
        }

        public function getFoto() {
            return $this->foto;
        }

        public function getDataFalecimento() {
            return $this->dataFalecimento;
        }

        public function getNaturalidade() {
            return $this->naturalidade;
        }

        public function getNascionalidade() {
            return $this->nascionalidade;
        }

        public function getStatus() {
            return $this->status;
        }

        public function getDataCasamento() {
            return $this->dataCasamento;
        }
        
        public function getQtdFilhos(){
            return $this->qtdFilhos;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function setNivelEscolaridade($nivelEscolaridade) {
            $this->nivelEscolaridade = $nivelEscolaridade;
        }

        public function setEstadoCivil($estadoCivil) {
            $this->estadoCivil = $estadoCivil;
        }

        public function setMatricula($matricula) {
            $this->matricula = $matricula;
        }

        public function setCpf($cpf) {
            $this->cpf = $cpf;
        }

        public function setRg($rg) {
            $this->rg = $rg;
        }

        public function setRgOrgaoEmissor($rgOrgaoEmissor) {
            $this->rgOrgaoEmissor = $rgOrgaoEmissor;
        }

        public function setFormacao($formacao) {
            $this->formacao = $formacao;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function setSexo($sexo) {
            $this->sexo = $sexo;
        }

        public function setDataNascimento($dataNascimento) {
            $this->dataNascimento = $dataNascimento;
        }

        public function setGrupoSanguineo($grupoSanguineo) {
            $this->grupoSanguineo = $grupoSanguineo;
        }

        public function setDoador($doador) {
            $this->doador = $doador;
        }

        public function setEndereco($endereco) {
            $this->endereco = $endereco;
        }

        public function setMaeNome($maeNome) {
            $this->maeNome = $maeNome;
        }

        public function setPaiNome($paiNome) {
            $this->paiNome = $paiNome;
        }

        public function setObservacao($observacao) {
            $this->observacao = $observacao;
        }

        public function setFoto($foto) {
            $this->foto = $foto;
        }

        public function setDataFalecimento($dataFalecimento) {
            $this->dataFalecimento = $dataFalecimento;
        }

        public function setNaturalidade($naturalidade) {
            $this->naturalidade = $naturalidade;
        }

        public function setNascionalidade($nascionalidade) {
            $this->nascionalidade = $nascionalidade;
        }

        public function setStatus($status) {
            $this->status = $status;
        }

        public function setDataCasamento($dataCasamento) {
            $this->dataCasamento = $dataCasamento;
        }
        
        public function setQtdFilhos($qtdFilhos){
            $this->qtdFilhos = $qtdFilhos;
        }
        
        public function getUfNascimento() {
            return $this->ufNascimento;
        }

        public function setUfNascimento($ufNascimento) {
            $this->ufNascimento = $ufNascimento;
        }
        
        public function getDataHoraAlteracao() {
            return $this->dataHoraAlteracao;
        }

        public function setDataHoraAlteracao($dataHoraAlteracao) {
            $this->dataHoraAlteracao = $dataHoraAlteracao;
        }
        
        public function getIdade(){            
            if($this->getDataNascimento()!=""){
                $strDataNascimento = $this->getDataNascimento(); //new DateTime( '1901-10-11' ); // data de nascimento                        
                $arrTesteExplode = explode("/", $strDataNascimento);            
                $strDataFormatada = $arrTesteExplode[2]."-".$arrTesteExplode[1]."-".$arrTesteExplode[0];            
                if($strDataFormatada != ""){
                    $dataAtual = new DateTime();
                    $dataNascimento = new DateTime($strDataFormatada);
                    $intervalo = $dataNascimento->diff($dataAtual); // data definida
                    //$retorno = $intervalo->format( '%Y Anos, %m Meses e %d Dias' );                
                    //echo $intervalo->format( '%Y Anos, %m Meses e %d Dias' ); // 110 Anos, 2 Meses e 2 Dias
                    $ano = $intervalo->format( '%Y' );
                    if($ano > 0){
                        $retorno = $intervalo->format( '%Y Anos' );
                    }else{
                        $retorno = '0 Ano';
                    }                
                }else{
                    $retorno = null;
                }
            }else{
                $retorno = null;
            }
            
            return $retorno;
        }
        
        public function getStatusAtualizacao(){             
            /*            
            Atualizado --> Cor verde " Campo preenchido com data dentro do intervalo dos 2 útimos anos".
            Pendente --> Cor amarela " Campo data atualização preenchida "desatualizada de 2 anos".
            Desatualizado --> Cor vermelha " Se não existir data de atualização".
            */
            if($this->getDataHoraAlteracao() != ""){//Desatualizado --> Cor vermelha " Se não existir data de atualização".                   
                $dataAtual = new DateTime();
                $dataNascimento = new DateTime($this->getDataHoraAlteracao());
                $intervalo = $dataNascimento->diff($dataAtual); // data definida                
                $ano = $intervalo->format( '%Y' );
                if($ano<=2){
                    $retorno = "verde";
                }else{
                    $retorno = "amarelo";
                }                
            }else{
                $retorno = "vermelho";
            }            
            return $retorno;
        }

    }
?>