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
    <script type="text/javascript" src="<?php echo $strDir;?>/js/frmPatrimonio.js"></script>    
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Patrim&ocirc;nios Cadastrados</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <div>
                <form id="frmPesquisa" class="frmPesquisa">
                    <fieldset class="coluna">
                        <label for="selPesquisaTipo">Grupo</label>
                        <select id="selPesquisaTipo" class="campoSelect" style="width: 200px;" onchange="consultarItens('selPesquisaTipo', 'selPesquisaItem');">
                            <option value="">TODOS</option>
                            <?php
                                $arrStrFiltros               = array();                                
                                $arrStrFiltros["TIP_Status"] = "A";
                                $arrObjTiposPatrimonios        = null;    
                                $arrObjTiposPatrimonios        = FachadaPatrimonio::getInstance()->consultarTipoPatrimonio($arrStrFiltros);

                                $arrObjTiposPatrimonios = $arrObjTiposPatrimonios["objects"];
                                if($arrObjTiposPatrimonios != null){
                                    if(count($arrObjTiposPatrimonios) > 0){
                                        $strHtml = "";
                                        for($intI=0; $intI<count($arrObjTiposPatrimonios); $intI++){
                                            $strHtml .= '<option value="'.$arrObjTiposPatrimonios[$intI]->getId().'">'.html_entity_decode($arrObjTiposPatrimonios[$intI]->getDescricao()).'</option>';
                                        }
                                        echo $strHtml;
                                    }
                                }
                            ?>
                        </select>
                     </fieldset>
                    <fieldset class="coluna">
                        <label for="selPesquisaItem">Subgrupo</label>                                
                        <select id="selPesquisaItem" name="ITP_ID" class="campoSelect" style="width: 200px;">
                            <option value="">SELECIONE</option>
                        </select>
                    </fieldset> 
                    
                    <fieldset class="coluna">                        
                        <label for="txtPesquisaDescricao">Descrição</label>
                        <input type="text" id="txtPesquisaDescricao" name="" class="campoTextoPadrao" value=""  style="width: 300px;" maxlength="80"/>
                    </fieldset> 
                    
                    <fieldset class="coluna">
                        <label for="selPesquisaCondicao">Condi&ccedil;&atilde;o</label>
                        <select id="selPesquisaCondicao" name="PTM_Condicao" class="campoSelect" style="width: 100px;" >
                            <option value="">TODOS</option>
                            <option value="NOVO">NOVO</option>
                            <option value="BOM">BOM</option>
                            <option value="REGULAR">REGULAR</option>
                            <option value="RUIM">RUIM</option>
                        </select>
                    </fieldset>                    
                    <fieldset class="coluna">
                        <input type="button" value="Pesquisar" onclick="consultar();" class="botao"/>
                    </fieldset>
                </form>
            </div>
            <fieldset style="margin-top: 5px; margin-bottom: 5px; padding: 0px; border: 0px;">
                <input type="checkbox" style="margin-left: 0px; " id="ckbSelecionarTodos" onclick="selecionarTodos();"/>Selecionar todos
            </fieldset>
            <div id="grid" style="margin-top: 20px;"></div>
        </div>
        <div id="tabs-2">
            <div id="dialogs">     
                <div id="dialog-sucesso" title="Sucesso"></div>
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
                <div id="dialog-add-grupo" title="Adicionar Grupo"></div>
                <div id="dialog-excluir" title="Exce&ccedil;&atilde;o">
                    <input type="hidden" id="hddIDExcluir" />
                    <p>
                        Tem certeza que deseja remover?
                    </p>
                </div>
                <?php          
                    include("inc/adicionarTipoPatrimonio.inc.php");
                    include("inc/adicionarItemTipoPatrimonio.inc.php");
                    include("inc/adicionarFornecedores.inc.php");
                ?>
            </div><!-- dialogs -->
            
            <form id="frmFormulario" name="frmFormulario" action="<?php echo $strDir;?>/controladores/PatrimonioControlador.php" method="POST">
                <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
                <div id="tabs-formulario">
                    <ul>
                        <li><a href="#tabs-formulario-1">Dados do Patrim&ocirc;nio</a></li>
                    </ul>
                    <div id="tabs-formulario-1">
                        <input type="hidden" id="hddAcao" name="ACO_Descricao" value="Salvar"/>
                        <input type="hidden" id="hddFormularioID" name="FRM_ID" value="<?php echo $_GET["FRM_ID"];?>"/>
                        <input type="hidden" id="hddID" name="PTM_ID"/>
                        <input type="hidden" id="hddFocus"/>
                        <input type="hidden" id="hddFoto" name="PTM_Foto"/>
                        
                        <fieldset class="coluna" style="float: right; ">
                            <div id="div-foto" style="width: 330px; height: 365px; overflow: auto; margin-top: 24px;  ">
                                <img src='../../../modulos/sistema/home/img/bloqueio.png' width="330" height="300" id="imgFotoSalvar" style="margin-bottom: 13px;" />
                                <input type="file" id="fileFoto" accept="image/*"  placeholder="Clique aqui para selecionar a foto (Máx. 1M por foto)" />
                            </div>
                            
                        </fieldset>
                        
                        <fieldset class="coluna" >
                            <fieldset class="linha">
                                <label for="selTipo">Grupo*<a href="javascript: void(0);" onclick="janelaAdicionarTipoPatrimonio();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>
                                <select id="selTipo" name="TIP_ID" class="campoSelect" style="width: 608px;" onchange="consultarItensDoGrupo();">
                                    <option value="">SELECIONE</option>
                                </select>

                            </fieldset>
                            <fieldset class="linha">
                                <label for="selItem">Subgrupo*<a href="javascript: void(0);" onclick="janelaAdicionarItemTipoPatrimonio();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px" id="btAddItemTipoPatrimonio"/></a></label>                                
                                <select id="selItem" name="ITP_ID" class="campoSelect" style="width: 608px;">
                                    <option value="">SELECIONE</option>
                                </select>
                            </fieldset> 
                        
                            <fieldset class="linha">                            
                                <fieldset class="coluna">
                                    <label>Quantidade</label>
                                    <input type="text" id="txtQuantidade" name="PTM_Quantidade" class="campoTextoPadrao" value=" "  style="width: 50px; text-align: right;"/>
                                </fieldset>
                                <fieldset class="coluna">
                                    <label>Descrição</label>
                                    <input type="text" id="txtDescricao" name="PTM_Descricao" class="campoTextoPadrao" value=" "  style="width: 516px; "/>
                                </fieldset>
                            </fieldset>

                            <fieldset class="linha">                            
                                <fieldset class="coluna">
                                    <label>Fabricante</label>
                                    <input type="text" id="txtFabricante" name="PTM_Fabricante" class="campoTextoPadrao" value=" "  style="width: 280px; "/>
                                </fieldset>
                                <fieldset class="coluna">
                                    <label>Fornecedor*<a href="javascript: void(0);" onclick="janelaAdicionarFornecedores();" title="Adicionar novo registro." class="adicionar"><img src="img/adicionar.png" border="0" width="12px" height="12px"/></a></label>
                                    <select id="selFornecedor" name="FOR_ID" class="campoSelect" style="width: 305px;" >
                                        <option value="">SELECIONE</option>
                                        <?php
                                            /*$arrStrFiltros               = array();
                                            $arrStrFiltros["FOR_Status"] = "A";                                        
                                            $arrObjFornecedor = FachadaFinanceiro::getInstance()->consultarFornecedor($arrStrFiltros);                                        
                                            $strHtml = '';                                        
                                            if($arrObjFornecedor != null){
                                                $arrObjFornecedor = $arrObjFornecedor["objects"];                                            
                                                for($intIa=0; $intIa<count($arrObjFornecedor); $intIa++){
                                                    $strHtml .= '<option value="'.$arrObjFornecedor[$intIa]->getId().'">'.$arrObjFornecedor[$intIa]->getNomeFantasia().'</option>';
                                                }                          
                                            }else{
                                                $strHtml = '<option value="">NENHUM FORNECEDOR CADASTRADO</option>';
                                            }

                                            echo $strHtml;*/
                                        ?>
                                    </select>
                                </fieldset>
                            </fieldset>
                            
                            <fieldset class="linha">
                                <fieldset class="coluna">
                                    <label for="selFormaAquisicao">Forma de Aquisi&ccedil;&atilde;o*</label>                                
                                    <select id="selFormaAquisicao" name="FRA_ID" class="campoSelect" style="width: 145px;" >
                                        <option value="">SELECIONE</option>
                                        <?php
                                            $arrStrFiltros               = array();
                                            $arrStrFiltros["FRA_Status"] = "A";                                        
                                            $arrObjFormasAquisicoes       = FachadaPatrimonio::getInstance()->consultarFormaAquisicao($arrStrFiltros);                                        
                                            $arrObjFormasAquisicoes = $arrObjFormasAquisicoes["objects"];
                                            $strHtml                     = '';                                        
                                            for($intIa=0; $intIa<count($arrObjFormasAquisicoes); $intIa++){
                                                $strHtml .= '<option value="'.$arrObjFormasAquisicoes[$intIa]->getId().'">'.$arrObjFormasAquisicoes[$intIa]->getDescricao().'</option>';
                                            }                                        
                                            echo $strHtml;
                                        ?>
                                    </select>
                                </fieldset>
                                
                                <fieldset class="coluna">
                                    <label for="txtData">Data Aquisi&ccedil;&atilde;o</label>
                                    <input type="text" id="txtDataAquisicao" name="PTM_DataAquisicao" class="campoData" placeholder="__/__/____" style="width: 130px;" />
                                </fieldset>
                                
                                
                                <fieldset class="coluna">
                                    <label for="txtExpiracao">Garantia expira em</label>
                                    <input type="text" id="txtDataExpiracaoGarantia" name="PTM_DataExpiracaoGarantia" class="campoTextoPadrao" placeholder="__/__/____" style="width: 130px;" />
                                </fieldset>
                                <fieldset class="coluna">
                                    <label>Valor do Bem (R$)*</label>
                                    <input type="text" id="txtValorEstimado" name="PTM_ValorEstimado" class="campoTextoPadrao" value="0,00"  style="width: 135px;"/>
                                </fieldset>                            
                            </fieldset>                         
                        
                            <fieldset class="linha">
                                <fieldset class="coluna">
                                    <label>Localiza&ccedil;&atilde;o</label>
                                    <select id="selUnidadeCongregacao" name="UNI_Localizacao_ID" class="campoSelect" style="width: 450px;">
                                        <option value="">SEDE</option>
                                        <?php
                                            $arrStrFiltros = array();
                                            $arrStrFiltros["UNI_Status"] = "A";
                                            $arrObjs = FachadaCadastro::getInstance()->consultarCongregacao($arrStrFiltros);
                                            $arrObjs = $arrObjs["objects"];

                                            if($arrObjs != null){
                                                $strOptions = '';

                                                for($intI=0; $intI<count($arrObjs); $intI++){
                                                    $strOptions .= '<option value="'.$arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                                                }

                                                echo $strOptions;
                                            }
                                        ?>
                                    </select>
                                </fieldset>
                                <fieldset class="coluna">
                                    <label for="selCondicao">Condi&ccedil;&atilde;o*</label>
                                    <select id="selCondicao" name="PTM_Condicao" class="campoSelect" style="width: 155px;" >
                                        <option value="">SELECIONE</option>
                                        <option value="NOVO">NOVO</option>
                                        <option value="BOM">BOM</option>
                                        <option value="REGULAR">REGULAR</option>
                                        <option value="RUIM">RUIM</option>
                                    </select>
                                </fieldset>
                            </fieldset>
                        </fieldset>
                        
                        <fieldset class="linha" style="margin-top: 22px;">
                            <label>Anota&ccedil;&otilde;es</label>
                            <textarea id="txtObservacao" name="PTM_Observacao" rows="5" class="campoTextoPadrao" style="width: 98%" ></textarea>
                        </fieldset>
                    </div> 
                </div>
                <fieldset class="linha" style="border: 0px; margin-top: 10px;">
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