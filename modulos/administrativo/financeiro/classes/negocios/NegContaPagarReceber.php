<?php
    // codificação utf-8
    class NegContaPagarReceber{
        private static $objInstance;

        private function __construct() {}

        public static function getInstance(){
            if(self::$objInstance == null){
                self::$objInstance = new NegContaPagarReceber();
            }
            return self::$objInstance;
        }

        public function consultar($arrStrFiltros){            
            if(isset($arrStrFiltros["CON_DataInicial"])){
                $arrStrFiltros["CON_DataInicial"] = DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrFiltros["CON_DataInicial"]);
            }
            
            if(isset($arrStrFiltros["CON_DataFinal"])){
                $arrStrFiltros["CON_DataFinal"] = DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrFiltros["CON_DataFinal"]);
            }
            
            $arrStrDados = RepoContaPagarReceber::getInstance()->consultar($arrStrFiltros);
            $arrObjsRetorno = null;
            
            if($arrStrDados != null){
                if(count($arrStrDados) > 0){
                    $arrObjs = array();
                    
                    $douValorTotalLancamentos = 0;
                    
                    for($intI=0; $intI<count($arrStrDados); $intI++){                        
                        $arrObjs[$intI] = $this->factory($arrStrDados[$intI]);
                        
                        $douValorTotalLancamentos += doubleval($arrStrDados[$intI]["CON_ValorTotal"]);
                                                
                        // formatações
                        $arrStrDados[$intI]["CON_DataHoraCadastro"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["CON_DataHoraCadastro"]);                         
                        $arrStrDados[$intI]["CON_ValorTotal"] = NumeroHelper::getInstance()->formatarMoeda($arrStrDados[$intI]["CON_ValorTotal"]);                   
                        
                        $arrStrDados[$intI]["CON_ProximoVencimento"] = "-";
                        $arrStrDados[$intI]["CON_Foto_Acoes"] = $arrObjs[$intI]->getFoto1()."|".$arrObjs[$intI]->getId();
                        
                        // identifica o próximo vencimento em aberto
                        $arrStrFiltrosProximoVencimento = array();
                        $arrStrFiltrosProximoVencimento["CON_ID"] = $arrStrDados[$intI]["CON_ID"];  
                        $arrStrDadosProximoVencimentoAberto = RepoContaPagarReceber::getInstance()->consultarProximoVencimento($arrStrFiltrosProximoVencimento);
                        
                        if($arrStrDadosProximoVencimentoAberto != null){
                            if(count($arrStrDadosProximoVencimentoAberto) > 0){
                                $arrStrDados[$intI]["CON_ProximoVencimento"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDadosProximoVencimentoAberto[0]["PCL_DataProximoVencimento"]);
                            }
                        }
                    }
                    
                    // responsável por exibir dados na grid
                    $arrObjsRetorno = array();
                    $arrObjsRetorno["objects"]  = $arrObjs;
                    $arrObjsRetorno["rows"]     = $arrStrDados;
                    
                    $arrObjsRetorno["totalLancamentos"] = NumeroHelper::getInstance()->formatarMoeda($douValorTotalLancamentos);
                    
                    // identifica o total de registros referente a consulta                    
                    $arrStrFiltros["TOT_Total"] = true;
                    $arrStrDadosTotal = RepoContaPagarReceber::getInstance()->consultar($arrStrFiltros); 
                    
                    $arrObjsRetorno["num_rows"] = $arrStrDadosTotal[0]["Total"];
                }
            }

            return $arrObjsRetorno;
        }

        public function consultarParcelas($arrStrFiltros){
            $arrStrDados = RepoContaPagarReceber::getInstance()->consultarParcelas($arrStrFiltros);
            
            for($intI=0; $intI<count($arrStrDados); $intI++){
                $arrStrDados[$intI]["PCL_DataVencimento"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["PCL_DataVencimento"]);
                
                if(isset($arrStrDados[$intI]["PCL_DataBaixa"])){
                    if(trim($arrStrDados[$intI]["PCL_DataBaixa"]) != ""){
                        $arrStrDados[$intI]["PCL_DataBaixa"] = DataHelper::getInstance()->converterDataBancoParaDataUsuario($arrStrDados[$intI]["PCL_DataBaixa"]);
                    }
                }
                
                $arrStrDados[$intI]["PCL_Valor"] = NumeroHelper::getInstance()->formatarMoeda($arrStrDados[$intI]["PCL_Valor"]);
                
                // diferença entre datas
                $intTimeInicial = strtotime(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados[$intI]["PCL_DataVencimento"]));
                $intTimeFinal   = strtotime(date("Y-m-d"));
                $intDiferenca   = $intTimeFinal - $intTimeInicial;
                $arrStrDados[$intI]["PCL_DiasAtraso"] = 0;

                if($intDiferenca > 0){
                    $arrStrDados[$intI]["PCL_DiasAtraso"] = (int)floor( $intDiferenca / (60 * 60 * 24)); 
                }   
            }
            
            return $arrStrDados;
        }
        
        private function factory($arrStrDados){
            $obj = new ContaPagarReceber();
            
            if(isset($arrStrDados["CON_ID"])){
                $obj->setId($arrStrDados["CON_ID"]);
            }
            
            if(isset($arrStrDados["CON_Descricao"])){
                $obj->setDescricao($arrStrDados["CON_Descricao"]);
            }
            
            if(isset($arrStrDados["CON_Numero"])){
                $obj->setNumero($arrStrDados["CON_Numero"]);
            }
            
            if(isset($arrStrDados["CON_ValorTotal"])){
                $obj->setValorTotal($arrStrDados["CON_ValorTotal"]);
            }
            
            if(isset($arrStrDados["CON_Observacao"])){
                $obj->setObservacao($arrStrDados["CON_Observacao"]);
            }
            
            // centro de custo
            $objCentroCusto = new CentroCusto();
            
            if(isset($arrStrDados["CEN_ID"])){
                $objCentroCusto->setId($arrStrDados["CEN_ID"]);
            }
            
            if(isset($arrStrDados["CEN_Descricao"])){
                $objCentroCusto->setDescricao($arrStrDados["PLA_Descricao"]);
            }
            
            $obj->setCentroCusto($objCentroCusto);
            
            // conta caixa
            $objPlanoConta = new PlanoConta();
            
            if(isset($arrStrDados["PLA_ID"])){
                $objPlanoConta->setId($arrStrDados["PLA_ID"]);
            }
            
            if(isset($arrStrDados["PLA_Descricao"])){
                $objPlanoConta->setDescricao($arrStrDados["PLA_Descricao"]);
            }
            
            $obj->setPlanoConta($objPlanoConta);            
                        
            // fornecedor
            /*$objFornecedor = new Fornecedor();
                        
            if(isset($arrStrDados["FOR_ID"])){
                $objFornecedor->setId($arrStrDados["FOR_ID"]);
            }
            
            $obj->setFornecedor($objFornecedor);*/
            
            $objPessoa = null;
            $objFornecedor = null;
            
            if($arrStrDados["CON_Tipo"] == "R"){
                if(isset($arrStrDados["CON_TipoOrigem"])){
                    if($arrStrDados["CON_TipoOrigem"] == "P"){
                        $objPessoa = new Pessoa();

                        if(isset($arrStrDados["PES_ID"])){
                            $objPessoa->setId($arrStrDados["PES_ID"]);            
                        }            
                        if(isset($arrStrDados["PES_Nome"])){
                            $objPessoa->setNome($arrStrDados["PES_Nome"]);            
                        }
                    }else{
                        $objFornecedor = new Fornecedor();
                        if(isset($arrStrDados["FOR_Origem_ID"])){
                            $objFornecedor->setId($arrStrDados["FOR_Origem_ID"]);            
                        }            
                        if(isset($arrStrDados["FOR_NomeFantasia"])){
                            $objFornecedor->setNomeFantasia($arrStrDados["FOR_NomeFantasia"]);            
                        } 
                    }
                }
            }else{
                $objFornecedor = new Fornecedor();
                        
                if(isset($arrStrDados["FOR_ID"])){
                    $objFornecedor->setId($arrStrDados["FOR_ID"]);
                }
            }
                    
            $obj->setPessoa($objPessoa);
            $obj->setFornecedor($objFornecedor);
            
            
            if(isset($arrStrDados["CON_Tipo"])){
                $obj->setTipo($arrStrDados["CON_Tipo"]);
            }
            
            if(isset($arrStrDados["CON_NumeroParcelas"])){
                $obj->setNumeroParcelas($arrStrDados["CON_NumeroParcelas"]);
            }
            
            if(isset($arrStrDados["CON_Foto1"])){
                $obj->setFoto1($arrStrDados["CON_Foto1"]);
            }
            
            if(isset($arrStrDados["CON_Foto2"])){
                $obj->setArquivo($arrStrDados["CON_Foto2"]);
            }
            
            return $obj;
        }
        
        private function fazerUploadArquivo($arrStrDados){
            $arrayRetorno = array();    
            
            if(isset($arrStrDados["uploadAnexoParcela"])){
                if(isset($arrStrDados["FILES"])){
                    if(isset($arrStrDados["FILES"]["anexoParcela"])){
                        // upload obra digitalizada
                        $strSalvarEm = "../../../administrativo/financeiro/uploads/contaPagarReceber/parcelas/";
                        $strCaminhoDownload = "../../administrativo/financeiro/uploads/contaPagarReceber/parcelas/";
                        $arrStrRetornoUpload = UploadHelper::getInstance()->upload($arrStrDados["FILES"]["anexoParcela"], $strSalvarEm, null, null);

                        if($arrStrRetornoUpload["sucesso"]){       
                            // define o nome do arquivo         
                            $strArquivo         = explode(".", $arrStrRetornoUpload["arquivo"]);
                            $intTamanho         = count($strArquivo) - 1;
                            $strNovoNomeArquivo = rand(10000, 1000000000).date('dmYHis').".".$strArquivo[$intTamanho];

                            // atualiza o campo para salvar com o novo nome
                            $arrStrDados["anexoParcela"] = $strCaminhoDownload.$strNovoNomeArquivo;

                            // novo nome do arquivo
                            rename($arrStrRetornoUpload["caminho"], $strSalvarEm.$strNovoNomeArquivo);

                            // se for uma alteração
                            // e se o pdf não for informado
                            // ele deixa o antigo
                            /*if($arrStrDados["CON_ID"] != ""){
                                $arrStrDados["anexoConta"] = $arrStrDados["anexoContaEdicao"];
                            }*/

                            // o anexoContaEdicao serve para identificar o nome do arquivo anterior
                            // toda vez que é feito um upload ele remove o anterior e coloca o novo
                            // isso vai evitar o acúmulo de arquivos no servidor
                            if(!empty($arrStrDados["anexoParcelaEdicao"])){
                                if(trim($arrStrDados["anexoParcelaEdicao"]) != ""){
                                    if(file_exists($strSalvarEm.$arrStrDados["anexoParcelaEdicao"])){
                                        unlink($strSalvarEm.$arrStrDados["anexoParcelaEdicao"]);
                                    }
                                }
                            }                        
                            $arrayRetorno["sucesso"] = TRUE;
                            $arrayRetorno["PCL_Arquivo"] = $arrStrDados["anexoParcela"];

                        }else{
                            $arrayRetorno["sucesso"] = FALSE;
                            $arrayRetorno["PCL_Arquivo"] = null;
                        }                    
                    }else{
                        $arrayRetorno["sucesso"] = FALSE;
                        $arrayRetorno["PCL_Arquivo"] = null;
                    }
                }                
            }else{
                if(isset($arrStrDados["FILES"])){
                    if(isset($arrStrDados["FILES"]["anexoConta"])){
                        // upload obra digitalizada
                        $strSalvarEm = "../../../administrativo/financeiro/uploads/contaPagarReceber/contas/";
                        $strCaminhoDownload = "../../administrativo/financeiro/uploads/contaPagarReceber/contas/";
                        $arrStrRetornoUpload = UploadHelper::getInstance()->upload($arrStrDados["FILES"]["anexoConta"], $strSalvarEm, null, null);

                        if($arrStrRetornoUpload["sucesso"]){       
                            // define o nome do arquivo         
                            $strArquivo         = explode(".", $arrStrRetornoUpload["arquivo"]);
                            $intTamanho         = count($strArquivo) - 1;
                            $strNovoNomeArquivo = rand(10000, 1000000000).date('dmYHis').".".$strArquivo[$intTamanho];

                            // atualiza o campo para salvar com o novo nome
                            $arrStrDados["anexoConta"] = $strCaminhoDownload.$strNovoNomeArquivo;

                            // novo nome do arquivo
                            rename($arrStrRetornoUpload["caminho"], $strSalvarEm.$strNovoNomeArquivo);

                            // se for uma alteração
                            // e se o pdf não for informado
                            // ele deixa o antigo
                            /*if($arrStrDados["CON_ID"] != ""){
                                $arrStrDados["anexoConta"] = $arrStrDados["anexoContaEdicao"];
                            }*/

                            // o anexoContaEdicao serve para identificar o nome do arquivo anterior
                            // toda vez que é feito um upload ele remove o anterior e coloca o novo
                            // isso vai evitar o acúmulo de arquivos no servidor
                            if(!empty($arrStrDados["anexoContaEdicao"])){
                                if(trim($arrStrDados["anexoContaEdicao"]) != ""){
                                    if(file_exists($strSalvarEm.$arrStrDados["anexoContaEdicao"])){
                                        unlink($strSalvarEm.$arrStrDados["anexoContaEdicao"]);
                                    }
                                }
                            }                        
                            $arrayRetorno["sucesso"] = TRUE;
                            $arrayRetorno["CON_Foto1"] = $arrStrDados["anexoConta"];

                        }else{
                            $arrayRetorno["sucesso"] = FALSE;
                            $arrayRetorno["CON_Foto1"] = null;
                        }                    
                    }else{
                        $arrayRetorno["sucesso"] = FALSE;
                        $arrayRetorno["CON_Foto1"] = null;
                    }
                }
            }
            
            
            
            
            return $arrayRetorno;
        }
        
        public function salvar($arrStrDados){
            //conserva CON_FOTO_1
            $conFoto = $arrStrDados["CON_Foto1"];
            
            //pegar data do vencimento e incrementar o mes pela quantidade de parcelas
            // fazer um contador com a quantidade de parcelas geradas e ir            
            $obj = $this->factory(DadosHelper::getInstance()->prepararDadosComAcentuacao($arrStrDados));
            
            
            //se não vier foto
            if($arrStrDados["CON_Foto1"] == ""){
                //faz upload de arquivo se existir
                if(isset($arrStrDados["FILES"])){
                    $arrRetorno = $this->fazerUploadArquivo($arrStrDados);                
                    if($arrRetorno["sucesso"] == TRUE){                    
                        $obj->setFoto1($arrRetorno["CON_Foto1"]);            
                    }else{                    
                        //se não adiciona a foto
                        $obj->setFoto1($conFoto);            
                    }
                }else{
                    //se não adiciona a foto
                    $obj->setFoto1($conFoto);            
                }
            }else{
                $obj->setFoto1($conFoto);
            }            
            $obj->setValorTotal($arrStrDados["CON_Valor"]);
            
            
            
            // monta as parcelas
            for($intI=0; $intI<count($arrStrDados["PCL_DataVencimento"]); $intI++){
                $objParcela = new ParcelaContaPagarReceber();
                $objParcela->setDataVencimento(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["PCL_DataVencimento"][$intI]));
                $objParcela->setNumero($arrStrDados["PCL_Numero"][$intI]);
                $objParcela->setValor(NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados["PCL_Valor"][$intI]));
                $obj->adicionarParcela($objParcela);
            }
            
            if($obj->getId() == ""){ 
                return RepoContaPagarReceber::getInstance()->salvar($obj);
            }else{ 
                return RepoContaPagarReceber::getInstance()->alterar($obj);
            }
        }
        
        public function excluir($arrStrDados){
            $obj = new ContaPagarReceber();
            $obj->setId($arrStrDados["CON_ID"][0]);      
                        
            return RepoContaPagarReceber::getInstance()->excluir($obj);
        }
        
        public function pagarParcela($arrStrDados){
            $obj = new ParcelaContaPagarReceber();
            
            //conserva PCL_Arquivo
            $foto = $arrStrDados["PCL_Arquivo"];
            
            //se não vier foto
            if($arrStrDados["PCL_Arquivo"] == ""){
                //faz upload de arquivo se existir
                if(isset($arrStrDados["FILES"])){
                    $arrStrDados["uploadAnexoParcela"] = true;
                    $arrRetorno = $this->fazerUploadArquivo($arrStrDados);                
                    if($arrRetorno["sucesso"] == TRUE){                    
                        $obj->setAnexoArquivo($arrRetorno["PCL_Arquivo"]);
                    }else{                    
                        //se não adiciona a foto
                        $obj->setAnexoArquivo($foto);            
                    }
                }else{
                    //se não adiciona a foto
                    $obj->setAnexoArquivo($foto);            
                }
            }else{
                $obj->setAnexoArquivo($foto);
            }            
            $obj->setId($arrStrDados["PCL_ID"]);
            
            // forma de pagamento
            $objFormaPagamento = new FormaPagamento();
            $objFormaPagamento->setId($arrStrDados["FPG_ID"]);
            $obj->setFormaPagamento($objFormaPagamento);
            
            // conta bancária
            $objContaBancaria = new ContaBancaria();
            $objContaBancaria->setId($arrStrDados["COB_ID"]);
            $obj->setContaBancaria($objContaBancaria);
            
            $obj->setDataBaixa(DataHelper::getInstance()->converterDataUsuarioParaDataBanco($arrStrDados["PCL_DataBaixa"]));
            $obj->setJuros(NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados["PCL_Juros"]));
            $obj->setMora(NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados["PCL_Mora"]));
            $obj->setMulta(NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados["PCL_Multa"]));
            $obj->setDesconto(NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados["PCL_Desconto"]));
            $obj->setReferencia($arrStrDados["PCL_Referencia"]);
            $obj->setValorPago(NumeroHelper::getInstance()->formatarNumeroParaBanco($arrStrDados["PCL_ValorPago"]));
            $obj->setFormaPagamentoNumero($arrStrDados["PCL_FormaPagamentoNumero"]);
            
            return RepoContaPagarReceber::getInstance()->pagarParcela($obj);
        }
        
        public function excluirArquivoFisico($idConta){
            return RepoContaPagarReceber::getInstance()->excluirArquivoFisico($idConta);
        }
    }
?>