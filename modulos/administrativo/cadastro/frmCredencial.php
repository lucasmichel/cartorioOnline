<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    // diretório do módulo
    $strDir = "../../administrativo/cadastro";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmCredencial.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Credenciais</a></li>            
        </ul>        
        <div id="tabs-1">
            <div id="dialogs">
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
            </div><!-- dialogs -->            
            <form id="frmPesquisa" onSubmit="return false;">                
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <label for="selPesquisarPor">Pesquisar por:</label>
                        <select class="campoSelect" id="selPesquisarPor" onchange="formatrCampoPesquisa();" >                            
                            <option value="nome">NOME</option>
                            <option value="cpf">CPF</option>
                            <option value="matricula">MATRÍCULA</option>                        
                        </select>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtPesquisaCampo">Campo</label>
                        <input type="text" id="txtPesquisaCampo" placeholder="Digite o que deseja pesquisar" class="campoTextoPadrao" style="width: 250px;">
                    </fieldset>
                    <fieldset class="coluna">
                            <label for="selPesquisaStatus">Status</label>
                            <select id="selPesquisaStatus" name="CEN_Status" class="campoSelect">                            
                                <option value="A">ATIVO</option>
                                <option value="I">INATIVO</option>  
                            </select>                    
                    </fieldset>
                    <fieldset class="coluna">                                    
                        <label for="selSexoPesquisa">Sexo</label>                                    
                        <select style="width:100px;" class="campoSelect" id="selSexoPesquisa"  name="PES_Sexo">    
                            <option value=""></option>
                            <option value="F">FEMININO</option>
                            <option value="M">MASCULINO</option>
                        </select>
                    </fieldset>
                </fieldset>                
                <fieldset class="linha"> 
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selNivelEscolaridadePesquisa">Nível de escolaridade</label>                                
                            <select data-placeholder="SELECIONE O NÍVEL DE ESCOLARIDADE" style="width:280px;" class="chosen-select-deselect"  id="selNivelEscolaridadePesquisa"  name="NES_ID">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["NES_Status"] = "A";
                                    $arrObjEscolaridade  = FachadaGerencial::getInstance()->consultarNivelEscolaridade($arrStrFiltros);
                                    if($arrObjEscolaridade != null){
                                        $arrObj = $arrObjEscolaridade["objects"];                                                
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.utf8_encode($arrObj[$intI]->getDescricao()).'</option>';
                                        }
                                    }else{
                                        echo '<option value="">NENHUMA ESCOLARIDADE CADASTRADA</option>';
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>                
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selEstadoCivilPesquisa">Estado civil</label>                                
                            <select data-placeholder="SELECIONE O ESTADO CIVIL" style="width:280px;" class="chosen-select-deselect" id="selEstadoCivilPesquisa"  name="ECV_ID">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["ECV_Status"] = "A";
                                    $arrObjEstadoCivil  = FachadaGerencial::getInstance()->consultarEstadoCivil($arrStrFiltros);
                                    //$arrObjEstadoCivil  = null;
                                    if($arrObjEstadoCivil != null){
                                        $arrObj = $arrObjEstadoCivil["objects"];                                                
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.utf8_encode($arrObj[$intI]->getDescricao()).'</option>';
                                        }
                                    }else{
                                        echo '<option value="">NENHUM ESTADO CIVIL CADASTRADO</option>';
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="coluna">
                        <input type="button" value="Pesquisar" onclick="consultar();" class="botao"/>                    
                    </fieldset>
                </fieldset>
            </form>
            <fieldset style="margin-top: 5px; margin-bottom: 5px; padding: 0px; border: 0px;">
                <input type="checkbox" style="margin-left: 0px; " id="ckbSelecionarTodos" onclick="selecionarTodos();"/>Selecionar todos
            </fieldset>
            <div id="grid" style="margin-top: 20px;"></div><!-- grid -->            
        </div>      
    </div>    
    <script type="text/javascript">
        init();
    </script>
</body>
</html>