<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php"); 
    
    $strDir = "../../administrativo/patrimonio";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>     
    <script type="text/javascript" src="<?php echo $strDir;?>/js/frmItemPatrimonio.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Subgrupos de Bens Cadastrados</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" class="frmPesquisa">
                    <fieldset class="coluna">
                        <label for="txtPesquisaDescricao">Descri&ccedil;&atilde;o</label>
                        <input type="text" id="txtPesquisaDescricao" name="txtPesquisa" class="campoTextoPadrao" style="width: 350px" placeholder="DIGITE A DESCRIÇÃO" />
                    </fieldset>
                    <fieldset class="coluna"> 
                        <label>Status</label>
                        <select id="selPesquisaStatus" class="campoSelect">
                            <option value="A" selected>ATIVO</option>
                            <option value="I">INATIVO</option>
                        </select>                        
                    </fieldset>
                    <fieldset class="coluna">
                        <input type="button" value="Pesquisar" onclick="consultar();" class="botao"/>
                    </fieldset>
                </form>
            </div>
            <div id="grid" style="margin-top: 20px;"></div>
        </div>
        <div id="tabs-2">
            <div id="dialogs">     
                <div id="dialog-sucesso" title="Sucesso"></div>
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
                
                <!-- Janelas -->
                <div id="dialog-excluir" title="Exclusão">
                    <p id="dialogMensagemExcluir"></p>
                </div>
                <?php          
                    include("inc/adicionarTipoPatrimonio.inc.php");                    
                ?>                
            </div><!-- dialogs -->
            <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
            <form id="frmCadastro" name="frmFormulario" action="<?php echo $strDir;?>/controladores/ItemPatrimonioControlador.php" method="POST">
                <input type="hidden" id="hddAcao" name="ACO_Descricao" value="Salvar"/>
                <input type="hidden" id="hddFormularioID" name="FRM_ID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="IPT_ID"/>                
                <input type="hidden" id="hddFocus"/>
                <fieldset class="linha" >
                
                    <fieldset class="coluna" style="float: left; ">
                        <fieldset class="linha">
                            <div class="side-by-side clearfix">
                            <label for="selTipo">Grupos de Bens <a href="javascript: void(0);" onclick="janelaAdicionarTipoPatrimonio();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>                                
                                <select data-placeholder="SELECIONE O GRUPO DE BEM" style="width:420px;" class="chosen-select-deselect" id="selTipo"  name="TIP_ID">
                                    
                                </select>
                            </div>
                        </fieldset>                
                        <fieldset class="linha">
                            <fieldset class="coluna">
                                <label for="txtDescricao">Descri&ccedil;&atilde;o*</label>
                                <input type="text" id="txtDescricao" name="IPT_Descricao" class="campoTextoPadrao" style="width: 400px" placeholder="DESCRIÇÃO DO ITEM PATRIMONIAL" />
                            </fieldset>
                            <fieldset class="coluna">
                                <label for="txtDepreciacao">Depreciação <span style="font-size: 18px !important; font-weight: bold; color: #737373" >¹</span></label>
                                <input type="text" id="txtDepreciacao" name="IPT_PercentualDepreciacao" class="campoTextoPadrao" style="width: 60px" placeholder="2%" />
                            </fieldset>

                        </fieldset>
                    </fieldset>


                    <fieldset class="coluna" style="float: left; margin-left: 20px; margin-top: 20px; ">
                        <span style="font-size: 18px !important; font-weight: bold; color: #737373" >¹</span><span style="font-size: 11px !important; font-weight: bold; color: #737373" >Nota: o percentual de depreciação é 
                            <br> correspondente a um ano. 
                            <br><br> Vide tabela completa nos links abaixo: 
                            <br><br><a style="font-size: 11px !important; font-weight: bold; color: #737373" href="http://www.receita.fazenda.gov.br/Legislacao/ins/Ant2001/1998/in16298ane1.htm" target="_blank"> Tabela depreciação - Receita Federal </a>
                            <br><a style="font-size: 11px !important; font-weight: bold; color: #737373" href="http://portalcfc.org.br/wordpress/wp-content/uploads/2013/04/CFC_INT_VCPI-004_2012_DEPRECIACAO_Final.pdf" target="_blank"> Tabela depreciação - CFC </a> </span>
                    </fieldset>
                </fieldset>
                
                
                
                
                <fieldset class="linha" style="margin-top: 10px;">
                    <input type="checkbox" id="ckbStatus" name="IPT_Status" value="I" />Inativo<br />
                </fieldset>
                <fieldset class="linha" style="margin-top: 10px;">
                    <input type="button" value="Salvar" onclick="salvar();" class="botao" id="btnSalvar"/><input type="button" value="Cancelar" onclick="cancelar();" class="botao"/>
                </fieldset>                
            </form>            
        </div>      
    </div>    
    <script type="text/javascript">
        init();
    </script>
</body>
</html>