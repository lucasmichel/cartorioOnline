<?php 
    // codificação utf-8 
    $strAcao = null;
    
    if(isset($_POST["ACO_Descricao"])){
        $strAcao = $_POST["ACO_Descricao"];
    }
    
    $arrObjPermissoesSistema = null;
    
    if(isset($_SESSION["USUARIO_ID"]) && isset($_SESSION["ACESSOPERMITIDO"])){
        if ($_SESSION["ACESSOPERMITIDO"] == "TRUE") {
            // identifica o grupo do usuário através de uma nova consulta de Usuário
            $arrStrUsuarioFiltros = array();
            $arrStrUsuarioFiltros["USU_ID"] = $_SESSION["USUARIO_ID"];
            $arrObjUsuarios = FachadaGerencial::getInstance()->consultarUsuario($arrStrUsuarioFiltros);
            $arrObjUsuarios = $arrObjUsuarios["objects"];
            
            $arrStrFiltros = array();
            $arrStrFiltros["USU_ID"]     = $arrObjUsuarios[0]->getId();
            $arrStrFiltros["GRU_ID"]     = $arrObjUsuarios[0]->getGrupo()->getId();
            $arrStrFiltros["FRM_Status"] = "A";
            $arrStrFiltros["FRM_ID"]     = null;
                        
            // busca informações de um formulário específico
            // por exemplo, só é preciso retornar as ações do formulário
            // que o usuário está acessando atualmente
            if(isset($_POST["FRM_ID"])){
                $arrStrFiltros["FRM_ID"] = $_POST["FRM_ID"];                
            }            
            
            // obtem todos os formulários acessíveis para o usuário atual
            $arrObjFormularios = FachadaGerencial::getInstance()->consultarFormulario($arrStrFiltros);
            $arrObjFormularios = $arrObjFormularios["objects"];         
            
            // identifica as permissões(as ações do formulário)
            // que este grupo pode executar
            // primeiro identifica as permissões por grupo            
            if($arrObjFormularios != null){
                if(count($arrObjFormularios) > 0){
                    for($intI=0; $intI<count($arrObjFormularios); $intI++){
                        // verifica as permissões por grupo
                        $arrStrFiltrosAcao = array();
                        $arrStrFiltrosAcao["FRM_ID"]   = $arrObjFormularios[$intI]->getId(); 
                        $arrStrFiltrosAcao["GRU_ID"]   = $arrObjUsuarios[0]->getGrupo()->getId();                        
                        $arrStrFiltrosAcao["PER_Tipo"] = "G"; 
                        
                        $arrObjAcoes = FachadaGerencial::getInstance()->consultarAcoesPermitidas($arrStrFiltrosAcao);
                        
                        //os formularios já vem com as acoes dele
                        //precisamos aqui setar como null para o formulario so receber 
                        // as acoes permitidas pelo grupo ou pelo usuario                        
                        $arrObjFormularios[$intI]->setAcoes(null);
                        
                        for($intY=0; $intY<count($arrObjAcoes); $intY++){                            
                            $arrObjFormularios[$intI]->addAcao($arrObjAcoes[$intY]);
                        }
                        
                        // verifica as permissões por usuário
                        $arrStrFiltrosAcao = array();
                        $arrStrFiltrosAcao["FRM_ID"]   = $arrObjFormularios[$intI]->getId(); 
                        $arrStrFiltrosAcao["USU_ID"]   = $arrObjUsuarios[0]->getId();                        
                        $arrStrFiltrosAcao["PER_Tipo"] = "U"; 
                        
                        $arrObjAcoes = FachadaGerencial::getInstance()->consultarAcoesPermitidas($arrStrFiltrosAcao);
                        
                        for($intY=0; $intY<count($arrObjAcoes); $intY++){
                            $arrObjAcoesForm   = $arrObjFormularios[$intI]->getAcoes(); // pega as ações do formulário
                            $boolAcaoExistente = false; // informa se já existe a ação
                            
                            for($intU=0; $intU<count($arrObjAcoesForm); $intU++){
                                if($arrObjAcoesForm[$intU]->getId() == $arrObjAcoes[$intY]->getId()){
                                    $boolAcaoExistente = true;
                                    break;
                                }
                            }
                            
                            // só insere se for uma ação que não tenha sido encontrada no grupo
                            // mas foi encontrada no usuário
                            if(!$boolAcaoExistente){
                                $arrObjFormularios[$intI]->addAcao($arrObjAcoes[$intY]);
                            }
                        }
                    }
                }
            }
            
            // depois de idenfiticar os formulários e suas respectivas ações
            // o array $arrObjFormularios será atribuído a um array que será utilizado para 
            // as funções de validações necessárias
            $arrObjPermissoesSistema = $arrObjFormularios;            
        }
    }
        
    // a variável $strAcao é fornecida no controlador
    // todo controlador deve possuir esta variável
    // e o arquivo de permissões deve ficar após esta variável
    if(isset($strAcao)){
        if($strAcao == "ChecarPermissao"){                
            // verifica se há permissão para executar as ações desejadas
            if(isset($_POST["FRM_Acao"])){
                $arrStrJson = array();
                $arrStrJson["sucesso"] = "true";
                
                if(!permitirAcao($_POST["FRM_Acao"], $arrObjPermissoesSistema)){             
                    $arrStrJson = array();
                    $arrStrJson["sucesso"]  = "false";
                    $arrStrJson["mensagem"] = "<b>(#".$_POST["FRM_Acao"].")</b> ".MensagemHelper::getInstance()->getOperacaoNaoPermitida();                     
                }
                
                echo json_encode($arrStrJson);
                exit;
            }
        }
    }
    
    /*
     * Função que checa se o formulário está com permissão
     * de acesso no menu (só exibe os menus permitidos)
     * param $objFormulario : formulário que deseja checar
     * param $arrObjPermissoesSistema : array de permissões
    */    
    function permitirFormulario($objFormulario, $arrObjPermissoesSistema){
        $boolPermitir = false;
        
        if($arrObjPermissoesSistema != null){
            for($intI=0; $intI<count($arrObjPermissoesSistema); $intI++){
                if($arrObjPermissoesSistema[$intI]->getId() == $objFormulario->getId()){
                    $boolPermitir = true;
                    break;
                }
            }
        }
        
        return $boolPermitir;        
    }
    
    /*
     * Função que checa se as ações do formulário     
    */
    function permitirAcao($strAcao, $arrObjPermissoesSistema){
        $boolPermitir = false;
        
       
        
        if($arrObjPermissoesSistema != null){
            for($intI=0; $intI<count($arrObjPermissoesSistema); $intI++){
                $arrObjAcoes = $arrObjPermissoesSistema[$intI]->getAcoes();
                
                if($arrObjAcoes != null){
                    if(count($arrObjAcoes) > 0){
                        for($intX=0; $intX<count($arrObjAcoes); $intX++){
                            // identifica a descrição da ação
                            // para poder fazer a comparação com a Descrição
                            // enviada
                            // pois quando vamos verificar a permissão
                            // fazemos isso através da Descrição da ação e não
                            // do ID(
                            $arrStrAcaoFiltros = array();
                            $arrStrAcaoFiltros["ACO_ID"] = $arrObjAcoes[$intX]->getId();                            
                            $arrObjAcoesPerm = FachadaGerencial::getInstance()->consultarAcao($arrStrAcaoFiltros);
                            $arrObjAcoesPerm = $arrObjAcoesPerm["objects"];
                            
                            if($arrObjAcoesPerm != null){                            
                                // verifica se exista a ação para o formulário
                                if(strtoupper($arrObjAcoesPerm[0]->getDescricao()) == strtoupper($strAcao)){
                                    $boolPermitir = true;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
        
        return $boolPermitir;        
    }
?>
