<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php");      
    
    // diretório do módulo
    $strDir = "../../sistema/gerencial";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>           
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmFormulario.js"></script> 
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Telas (Formul&aacute;rios) Cadastradas</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <form id="frmPesquisa" onSubmit="return false;">
                <fieldset class="coluna">
                    <label for="selPesquisaModulo">M&oacute;dulo</label>
                    <select id="selPesquisaModulo" class="campoSelect" style="width: 200px;" onchange="consultarSubmodulos(this.id, 'selPesquisaSubmodulo');">
                        <option value="">SELECIONE</option>
                        <?php                            
                            $arrStrFiltrosMod               = null;
                            $arrStrFiltrosMod["MOD_Status"] = "A";
                            $arrObjs = FachadaGerencial::getInstance()->consultarModuloCategoria($arrStrFiltrosMod); 
                            $arrObjs = $arrObjs["objects"];

                            $strHtml = "";

                            for($intI=0; $intI<count($arrObjs); $intI++){
                                $strHtml .= "<option value='".$arrObjs[$intI]->getId()."'>".$arrObjs[$intI]->getDescricao()."</option>";
                            }

                            echo $strHtml;
                        ?>
                    </select>
                </fieldset>
                <fieldset class="coluna">
                    <label for="selPesquisaSubmodulo">Subm&oacute;dulo</label>
                    <select id="selPesquisaSubmodulo" class="campoSelect" style="width: 200px;">
                        <option value="">SELECIONE</option>
                    </select>                
                </fieldset>
                <fieldset class="coluna">
                    <label for="txtPesquisaDescricao">Tela (Formul&aacute;rio)</label>
                    <input type="text" id="txtPesquisaDescricao" name="FRM_Descricao" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisa()?>" class="campoTextoPadrao" style="width: 250px;">
                </fieldset>
                <fieldset class="coluna">
                    <input type="button" value="Pesquisar" onclick="consultar();" class="botao"/>                    
                </fieldset>
            </form>
            <div id="grid" style="margin-top: 20px;"></div><!-- grid -->            
        </div><!-- tabs-1 -->
        <div id="tabs-2">
            <div id="dialogs">     
                <div id="dialog-sucesso" title="Sucesso"></div>
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
                
                <!-- Janelas -->
                <div id="dialog-excluir" title="Exclusão">
                    <p id="dialogMensagemExcluir"></p>
                </div>
            </div><!-- dialogs -->            
            <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/FormularioControlador.php" method="POST" onSubmit="return false;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="FRM_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                
                <fieldset class="coluna">
                    <label for="selModulo">M&oacute;dulo*</label>
                    <select id="selModulo" class="campoSelect" style="width: 200px;" onchange="consultarSubmodulos(this.id, 'selSubmodulo');" onblur="fimFocus(this.id);">
                        <option value="">SELECIONE</option>
                        <?php                            
                            $arrStrFiltrosMod               = null;
                            $arrStrFiltrosMod["MOD_Status"] = "A";
                            $arrObjs = FachadaGerencial::getInstance()->consultarModuloCategoria($arrStrFiltrosMod); 
                            $arrObjs = $arrObjs["objects"];
                            
                            $strHtml = "";
                            
                            for($intI=0; $intI<count($arrObjs); $intI++){
                                $strHtml .= "<option value='".$arrObjs[$intI]->getId()."'>".$arrObjs[$intI]->getDescricao()."</option>";
                            }
                            
                            echo $strHtml;
                        ?>
                    </select>                
                </fieldset>                 
                <fieldset class="coluna">
                    <label for="MOD_ID">Subm&oacute;dulo*</label>
                    <select id="selSubmodulo" name="MOD_ID" class="campoSelect" style="width: 200px;" onblur="fimFocus(this.id);">
                        <option value="">SELECIONE</option>
                    </select>                
                </fieldset>                
                <fieldset class="coluna">
                    <label for="txtDescricao">Descri&ccedil;&atilde;o*</label>
                    <input type="text" id="txtDescricao" name="FRM_Descricao" class="campoTextoPadrao" placeholder="DESCRI&Ccedil;&Atilde;O PARA O FORMUL&Aacute;RIO." style="width: 250px; text-transform: none;"/>
                </fieldset> 
                <fieldset class="coluna">
                    <label for="txtCaminho">Caminho (arquivo .PHP)*</label>
                    <input type="text" id="txtCaminho" name="FRM_Caminho" class="campoTextoPadrao" placeholder="EX.: frmArquivo.php" style="width: 200px; text-transform: none;" />
                </fieldset> 
                <fieldset>
                    <legend>Menu</legend>
                    <fieldset class="coluna">
                        <label for="txtNivel1Descricao">N&iacute;vel 1*</label>
                        <input type="text" id="txtNivel1Descricao" name="MFR_Nivel1Descricao" class="campoTextoPadrao" style="width: 250px !important; text-transform: none;" placeholder="MENU N&Iacute;VEL 1" />
                    </fieldset>                
                    <fieldset class="coluna">
                        <label for="txtNivel2Descricao">N&iacute;vel 2</label>
                    <input type="text" id="txtNivel2Descricao" name="MFR_Nivel2Descricao" class="campoTextoPadrao" style="width: 250px !important; text-transform: none;" placeholder="MENU N&Iacute;VEL 2" />
                    </fieldset>                
                    <fieldset class="coluna">
                        <label for="txtNivel3Descricao">N&iacute;vel 3</label>
                    <input type="text" id="txtNivel3Descricao" name="MFR_Nivel3Descricao" class="campoTextoPadrao" style="width: 250px !important; text-transform: none;" placeholder="MENU N&Iacute;VEL 3" />
                    </fieldset>
                </fieldset>    
                <fieldset style="margin-top: 10px;">
                    <legend>A&ccedil;&otilde;es do Formul&aacute;rio* (Selecione pelo menos uma)</legend>
                    <select multiple id="selAcao" name="ACO_ID[]" class="campoSelect" style="width: 150px;">
                    <?php
                        $arrObjs = FachadaGerencial::getInstance()->consultarAcao(null);
                        $arrObjs = $arrObjs["objects"];
                        
                        if (count($arrObjs) > 0){
                            $strOption = '';
                            
                            for($intI=0;$intI<count($arrObjs);$intI++){
                                $strOption .= '<option value="'.$arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';                                                                                    
                            }
                            
                            echo $strOption;
                        }
                    ?>  
                    </select>
                </fieldset>
                <fieldset class="linha" style="margin-top: 20px;">
                    <input type="checkbox" id="ckbStatus" name="FRM_Status"/>Inativo
                </fieldset>
                <fieldset class="linha">
                    <input type="button" value="Salvar" onclick="salvar();" class="botao" id="btnSalvar"/>
                    <input type="button" value="Cancelar" onclick="cancelar();" class="botao"/>
                </fieldset>                
            </form>            
        </div>      
    </div>    
    <script type="text/javascript">
        init();        
    </script>
</body>
</html>