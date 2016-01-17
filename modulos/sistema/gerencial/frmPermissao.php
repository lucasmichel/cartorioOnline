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
    <script type="text/javascript" src="<?php echo $strDir;?>/js/frmPermissao.js"></script>    
</head>
<body>
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Permiss&otilde;es por Grupo</a></li>
            <li><a href="#tabs-2">Permiss&otilde;es por Usu&aacute;rio</a></li>
        </ul>        
        <div id="tabs-1">
            <div id="dialogs">     
                <div id="dialog-sucesso" title="Sucesso"></div>
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
            </div><!-- dialogs -->             
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/PermissaoGrupoUsuarioControlador.php" method="POST" onSubmit="return false;"  style="margin-top: 20px;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="SalvarGrupo"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="FRM_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                
                <fieldset class="linha">                    
                    <label for="selGrupo">Grupo do Usu&aacute;rio* (Para visualizar as permiss&otilde;es &eacute; necess&aacute;rio que selecione o grupo.)</label>
                    <select id="selGrupo" name="GRU_ID" class="campoSelect" style="width: 500px;" onblur="fimFocus(this.id);" onchange="consultarPermissoesGrupo();">
                        <option value="">SELECIONE</option>
                        <?php
                            $arrStrFiltros = array();
                            $arrStrFiltros["GRU_Status"] = "A";
                            $arrObjs = FachadaGerencial::getInstance()->consultarGrupo($arrStrFiltros);
                            $arrObjs = $arrObjs["objects"];
                            
                            for($intI=0; $intI<count($arrObjs); $intI++){                                
                                echo '<option value="'.$arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                            }
                        ?>
                    </select>
                </fieldset>
                
                <table width="100%" cellpadding="5" cellspacing="0" border="1" class="lista" style="margin-top: 20px;">
                    <tr class="titulo">
                        <td width="17%">M&oacute;dulo</td>
                        <td width="17%">Subm&oacute;dulo</td>
                        <td width="20%">Tela (Formul&aacute;rio)</td>
                        <td width="7%" align="center"><input id="ckbTodos" type="checkbox" onclick="marcarDesmarcarTodosGrupo();"/>Todos</td>
                        <td>A&ccedil;&otilde;es</td>
                    </tr>
                    <?php
                        // formularios
                        $arrStrFiltros = array();
                        $arrStrFiltros["ORDER_BY"] = "MC.MCT_Descricao, MF.MOD_ID";// para deixar mais organizado o grid
                        $arrObjs = FachadaGerencial::getInstance()->consultarFormulario($arrStrFiltros);
                        $arrObjs = $arrObjs["objects"];
                        
                        if($arrObjs != null){
                            if(count($arrObjs) > 0){
                                $strHtml = '';
                                
                                for($intI=0; $intI<count($arrObjs); $intI++){
                                    $strHtml .= '<tr>';
                                        $strHtml .= '<td>'.$arrObjs[$intI]->getModulo()->getModuloCategoria()->getDescricao().'</td>';
                                        $strHtml .= '<td>'.$arrObjs[$intI]->getModulo()->getDescricao().'</td>';
                                        $strHtml .= '<td>'.$arrObjs[$intI]->getDescricao().'</td>';
                                        $strHtml .= '<td align="center"><input class="checkboxTodos" id="checkboxTodos_'.$arrObjs[$intI]->getId().'" type="checkbox" onclick="marcarDesmarcarTodasAcoesGrupo('.$arrObjs[$intI]->getId().');"/></td>';
                                        $strHtml .= '<td>';
                                            // exibe as ações do formulário
                                            $arrObjAcoes = $arrObjs[$intI]->getAcoes();                                           
                                            $strHtmlAcoes  = '<table>';
                                            $strHtmlAcoes .= '<tr>';
                                            
                                            for($intX=0; $intX<count($arrObjAcoes); $intX++){
                                                $arrStrFiltrosAcao = array();
                                                $arrStrFiltrosAcao["ACO_ID"] = $arrObjAcoes[$intX]->getId();
                                                $arrObjAcaoPesquisa = FachadaGerencial::getInstance()->consultarAcao($arrStrFiltrosAcao);
                                                $arrObjAcaoPesquisa = $arrObjAcaoPesquisa["objects"];
                                                $strHtmlAcoes .= '<td><input class="checkboxAcao_'.$arrObjs[$intI]->getId().'" id="ckbAcao_'.$arrObjs[$intI]->getId().'_'.$arrObjAcoes[$intX]->getId().'" name="ACO_ID[]" type="checkbox" value="'.$arrObjs[$intI]->getId().'#'.$arrObjAcoes[$intX]->getId().'"/>'.$arrObjAcaoPesquisa[0]->getDescricao().'</td>';                                                
                                            }
                                            
                                            $strHtmlAcoes .= '</tr>';
                                            $strHtmlAcoes .= '</table>';
                                            $strHtml .= $strHtmlAcoes;
                                        $strHtml .= '</td>';
                                    $strHtml .= '</tr>';
                                }
                            }
                        }
                        
                        echo $strHtml;
                    ?>
                </table>
                <div class="linha">
                    <input type="button" class="botao" value="Salvar" onclick="salvarPermissaoGrupo();"/>
                    <input type="button" class="botao" value="Cancelar" onclick="cancelarPermissaoGrupo();"/>
                </div>
            </form>
        </div>
        <div id="tabs-2">
            <form id="frmCadastroUsuario" action="<?php echo $strDir;?>/controladores/PermissaoGrupoUsuarioControlador.php" method="POST" onSubmit="return false;"  style="margin-top: 20px;">
                <!-- campos obrigatórios no Salvar/Alterar -->
                <input type="hidden" name="ACO_Descricao" value="SalvarUsuario"/> <!-- para o Salvar/Alterar -->
                <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
                <input type="hidden" id="hddID" name="FRM_ID"/><!-- PK do registro, utilizado no ALTERAR -->
                <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
                
                <fieldset class="linha">                    
                    <label for="selUsuario">Usu&aacute;rio* (Para visualizar as permiss&otilde;es &eacute; necess&aacute;rio que selecione o usu&aacute;rio.)</label>
                    <select id="selUsuario" name="USU_ID" class="campoSelect" style="width: 500px;" onblur="fimFocus(this.id);" onchange="consultarPermissoesUsuario();">
                        <option value="">SELECIONE</option>
                        <?php                            
                            $arrObjs = FachadaGerencial::getInstance()->consultarUsuario(null);
                            $arrObjs = $arrObjs["objects"];
                            
                            for($intI=0; $intI<count($arrObjs); $intI++){                                
                                echo '<option value="'.$arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getLogin().'</option>';
                            }
                        ?>
                    </select>
                </fieldset>
                
                <table width="100%" cellpadding="5" cellspacing="0" border="1" class="lista" style="margin-top: 20px;">
                    <tr class="titulo">
                        <td width="15%">M&oacute;dulo</td>
                        <td width="10%">Subm&oacute;dulo</td>
                        <td width="15%">Tela (Formul&aacute;rio)</td>
                        <td width="7%" align="center"><input id="ckbTodosU" type="checkbox" onclick="marcarDesmarcarTodosUsuario();"/>Todos</td>
                        <td>A&ccedil;&otilde;es</td>
                    </tr>
                    <?php
                        // formularios
                        $arrObjs = FachadaGerencial::getInstance()->consultarFormulario(null);
                        $arrObjs = $arrObjs["objects"];
                        
                        if($arrObjs != null){
                            if(count($arrObjs) > 0){
                                $strHtml = '';
                                
                                for($intI=0; $intI<count($arrObjs); $intI++){
                                    $strHtml .= '<tr>';
                                        $strHtml .= '<td>'.$arrObjs[$intI]->getModulo()->getDescricao().'</td>';
                                        $strHtml .= '<td>'.$arrObjs[$intI]->getModulo()->getModuloCategoria()->getDescricao().'</td>';
                                        $strHtml .= '<td>'.$arrObjs[$intI]->getDescricao().'</td>';
                                        $strHtml .= '<td align="center"><input class="checkboxTodosU" id="checkboxTodosU_'.$arrObjs[$intI]->getId().'" type="checkbox" onclick="marcarDesmarcarTodasAcoesUsuario('.$arrObjs[$intI]->getId().');"/></td>';
                                        $strHtml .= '<td>';
                                            // exibe as ações do formulário
                                            $arrObjAcoes = $arrObjs[$intI]->getAcoes();                                           
                                            $strHtmlAcoes  = '<table>';
                                            $strHtmlAcoes .= '<tr>';
                                            
                                            for($intX=0; $intX<count($arrObjAcoes); $intX++){
                                                $arrStrFiltrosAcao = array();
                                                $arrStrFiltrosAcao["ACO_ID"] = $arrObjAcoes[$intX]->getId();
                                                $arrObjAcaoPesquisa = FachadaGerencial::getInstance()->consultarAcao($arrStrFiltrosAcao);
                                                $arrObjAcaoPesquisa = $arrObjAcaoPesquisa["objects"];
                                                $strHtmlAcoes .= '<td><input class="checkboxAcaoU_'.$arrObjs[$intI]->getId().'" id="ckbAcaoU_'.$arrObjs[$intI]->getId().'_'.$arrObjAcoes[$intX]->getId().'" name="ACO_ID[]" type="checkbox" value="'.$arrObjs[$intI]->getId().'#'.$arrObjAcoes[$intX]->getId().'"/>'.$arrObjAcaoPesquisa[0]->getDescricao().'</td>';                                                
                                            }
                                            
                                            $strHtmlAcoes .= '</tr>';
                                            $strHtmlAcoes .= '</table>';
                                            $strHtml .= $strHtmlAcoes;
                                        $strHtml .= '</td>';
                                    $strHtml .= '</tr>';
                                }
                            }
                        }
                        
                        echo $strHtml;
                    ?>
                </table>
                <div class="linha">
                    <input type="button" class="botao" value="Salvar" onclick="salvarPermissaoUsuario();"/>
                    <input type="button" class="botao" value="Cancelar" onclick="cancelarPermissaoUsuario();"/>
                </div>
            </form>
        </div>
    </div>    
    <script type="text/javascript">
        init();
    </script>
</body>
</html>