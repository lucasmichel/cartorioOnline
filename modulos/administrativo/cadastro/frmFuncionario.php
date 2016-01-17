<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php");    
    include("inc/autoload.inc.php");      
    
    // diret�rio do m�dulo
    $strDir = "../../administrativo/cadastro";
    header('Content-Type: text/html; charset=utf-8', true);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo SISTEMA_TITULO; ?></title>           
    <script type="text/javascript" src="<?php echo $strDir; ?>/js/frmFuncionario.js"></script> 
</head>
<body>    
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Funcionários Cadastrados</a></li>
            <li><a href="#tabs-2">Novo Registro*</a></li>
        </ul>
        <div id="tabs-1">
            <form id="frmPesquisa" onSubmit="return false;">                
                <fieldset class="linha">
                    <fieldset class="coluna">
                        <label for="selPesquisarPor">Pesquisar por</label>
                        <select class="campoSelect" id="selPesquisarPor" onchange="formatrCampoPesquisa();" >                            
                            <option value="nome">NOME</option>                            
                            <option value="matricula">MATRÍCULA</option>                        
                        </select>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="txtPesquisaCampo"></label>
                        <input type="text" id="txtPesquisaCampo" placeholder="<?php echo MensagemHelper::getInstance()->getPlaceHolderPesquisa();?>" class="campoTextoPadrao" style="width: 200px;">
                    </fieldset>
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selNivelEscolaridadePesquisa">Nível de escolaridade</label>                                
                            <select data-placeholder="FILTRO POR NÍVEL DE ESCOLARIDADE." style="width:260px;" class="chosen-select-deselect" id="selNivelEscolaridadePesquisa"  name="NES_ID">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["NES_Status"] = "A";
                                    $arrObjEscolaridade  = FachadaCadastro::getInstance()->consultarNivelEscolaridade($arrStrFiltros);
                                    if($arrObjEscolaridade != null){
                                        $arrObj = $arrObjEscolaridade["objects"];                                                
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.utf8_encode($arrObj[$intI]->getDescricao()).'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>                
                    <fieldset class="coluna">
                        <div class="side-by-side clearfix">
                        <label for="selEstadoCivilPesquisa">Estado civil</label>                                
                            <select data-placeholder="FILTRO POR ESTADO CIVIL." style="width:200px;" class="chosen-select-deselect" id="selEstadoCivilPesquisa"  name="ECV_ID">
                                <option value=""></option>
                                <?php
                                    $arrStrFiltros["ECV_Status"] = "A";
                                    $arrObjEstadoCivil  = FachadaCadastro::getInstance()->consultarEstadoCivil($arrStrFiltros);
                                    //$arrObjEstadoCivil  = null;
                                    if($arrObjEstadoCivil != null){
                                        $arrObj = $arrObjEstadoCivil["objects"];                                                
                                        for($intI=0; $intI<count($arrObj); $intI++){
                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.utf8_encode($arrObj[$intI]->getDescricao()).'</option>';
                                        }
                                    }
                                ?> 
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="coluna">                                    
                        <label for="selSexoPesquisa">Sexo</label>                                    
                        <select style="width:100px;" class="campoSelect" id="selSexoPesquisa"  name="PES_Sexo">    
                            <option value=""></option>
                            <option value="F">FEMININO</option>
                            <option value="M">MASCULINO</option>
                        </select>
                    </fieldset>
                    <fieldset class="coluna">
                        <label for="selPesquisaStatus">Status</label>
                        <select id="selPesquisaStatus" name="CEN_Status" class="campoSelect">                            
                            <option value="A">ATIVO</option>
                            <option value="I">INATIVO</option>  
                        </select>                    
                    </fieldset>
                    
                    <fieldset class="coluna">
                        <input type="button" value="Pesquisar" onclick="consultar();" class="botao"/>                    
                    </fieldset>
                </fieldset> 
            </form>
            <div id="grid" style="margin-top: 20px;"></div><!-- grid -->            
        </div><!-- tabs-1 -->
        <div id="tabs-2">            
            <div id="dialogs">     
                <div id="dialog-sucesso" title="Sucesso"></div>
                <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
                <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
                <div id="dialog-excluir" title="Exclusão">
                    <p id="dialogMensagemExcluir"></p>
                </div>
            </div><!-- dialogs -->             
            
            <form id="frmCadastro" action="<?php echo $strDir;?>/controladores/FuncionarioControlador.php" method="POST" onSubmit="return false;">
            <!-- campos obrigatórios no Salvar/Alterar -->
            <h1 class="h1CamposObrigatorios">(*) Campos obrigat&oacute;rios</h1>
            <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
            <input type="hidden" id="hddFormularioID" value="<?php echo $_GET["FRM_ID"];?>"/>
            <input type="hidden" id="hddID" name="PES_ID"/><!-- PK do registro, utilizado no ALTERAR -->
            <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->
            <input type="hidden" id="hddFotoMembro" name="PES_ArquivoFoto"/><!-- responsável por guardar o campos que receberá a foto -->
            <input type="hidden" id="hddMatricula" name="PES_Matricula"/><!-- responsável por guardar o campos que receberá a foto -->
            
            <div id="tabs-dados">
            <ul>
                <li><a href="#tabs-pessoais">Dados Pessoais</a></li>                
                <li><a href="#tabs-endereco">Endereço</a></li>
                <li><a href="#tabs-profissionais">Dados Profissionais</a></li>                
                <li><a href="#tabs-outros">Outros</a></li>
                
            </ul>            
                <div id="tabs-pessoais">
                        <fieldset class="coluna" style="float: right; width: 338px; height: 300px; margin-top: 40px; margin-right: 8px;">
                            <div id="div-foto" style="width: 330px; height: 300px; margin: auto;">
                                <img src='../../../modulos/sistema/home/img/sem-foto.png' id="imgFotoSalvar" width='330px' height='300px'/>
                            </div>
                            <div style="width: 170px; height: 163px; margin: auto;">
                                <input type="button" id="btnAdicionarFoto" value="Adicionar Foto" onclick="tirarFoto();" class="botao" style="width: 170px;"/>
                            </div>
                        </fieldset> 
                        <fieldset class="coluna">
                            <fieldset class="linha" style="width: 630px; border: 0px;" >
                                <fieldset class="linha" >
                                    <fieldset class="linha">
                                        <input type="checkbox" id="ckbEmembro" value="I" onclick="exibirMembro();"/>Este funcionário é um membro?
                                    </fieldset>
                                    <fieldset class="coluna" id="divEMembro" style="width: 415px;">
                                        <div class="side-by-side clearfix">
                                            <label for="selMembro">Membro</label>                                
                                            <select data-placeholder="SELECIONE O MEMBRO." class="chosen-select-deselect" id="selMembro"  name="PES_Membro_ID" onchange="preencheDadosMembro();"  style="width: 323px;" >
                                                <option value=""></option>
                                                <?php
                                                    $arrStrFiltros["PES_Status"] = "A";
                                                    $arrStrFiltros["MembroNaoFuncionario"] = true; //pra trazer mebros que não estão relacionados com funcionários ainda                                                
                                                    $arrStrFiltros["MES_ID"] = "1";
                                                    $arrObjMembro  = FachadaCadastro::getInstance()->consultarMembro($arrStrFiltros);
                                                    if($arrObjMembro != null){
                                                        $arrObj = $arrObjMembro["objects"];                                                
                                                        for($intI=0; $intI<count($arrObj); $intI++){
                                                           echo '<option value="'. $arrObj[$intI]->getId().'">   '.utf8_encode($arrObj[$intI]->getNome()).'</option>';
                                                        }
                                                    }
                                                ?> 
                                            </select>
                                        </div>
                                    </fieldset>
                                </fieldset>
                                <fieldset class="linha">                    
                                    <fieldset class="coluna">
                                        <label for="txtNome">Nome*</label>
                                        <input type="text" id="txtNome" name="PES_Nome" class="campoTextoPadrao" placeholder="EX.: JOÃO DA SILVA" style="width: 303px;"/>
                                    </fieldset>
                                    
                                    <fieldset class="coluna">
                                        <div class="side-by-side clearfix">
                                        <label for="selEstadoCivil">Estado civil</label>                                
                                            <select data-placeholder="SELECIONE O ESTADO CIVIL." style="width:300px;" class="chosen-select-deselect" id="selEstadoCivil"  name="ECV_ID">
                                                <option value=""></option>
                                                <?php
                                                    $arrStrFiltros["ECV_Status"] = "A";
                                                    $arrObjEstadoCivil  = FachadaCadastro::getInstance()->consultarEstadoCivil($arrStrFiltros);                                                
                                                    if($arrObjEstadoCivil != null){
                                                        $arrObj = $arrObjEstadoCivil["objects"];                                                
                                                        for($intI=0; $intI<count($arrObj); $intI++){
                                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.utf8_encode($arrObj[$intI]->getDescricao()).'</option>';
                                                        }
                                                    }
                                                ?> 
                                            </select>
                                        </div>
                                    </fieldset>
                                    
                                </fieldset>
                                
                                
                                
                                <fieldset class="linha">
                                    <fieldset class="coluna">
                                        <label for="txtDataNascimento">Data Nascimento*</label>
                                        <input type="text" id="txtDataNascimento" name="PES_DataNascimento" class="campoData" placeholder="__/__/____" style="width: 150px;"/>
                                    </fieldset> 
                                    <fieldset class="coluna">                                    
                                        <label for="selSexo">Sexo*</label>                                    
                                        <select class="campoSelect" id="selSexo"  name="PES_Sexo" style="width: 150px;">    
                                            <option value=""></option>
                                            <option value="F">FEMININO</option>
                                            <option value="M">MASCULINO</option>
                                        </select>
                                    </fieldset>
                                    
                                    <fieldset class="coluna">                                    
                                        <label for="selTipoSanguineo">Grupo Sangu&iacute;neo</label>
                                        <select  class="campoSelect" id="selTipoSanguineo"  name="PES_GrupoSanguineo" style="width: 165px;">    
                                            <option value=""></option>
                                            <option value="O-">O-</option>
                                            <option value="O+">O+</option>
                                            <option value="A-">A-</option>
                                            <option value="A+">A+</option>
                                            <option value="B-">B-</option>
                                            <option value="B+">B+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="AB+">AB+</option>
                                        </select>
                                    </fieldset>
                                    <fieldset class="coluna" >
                                        <input type="checkbox" id="ckbDoador" value="S" name="PES_Doador" />Doador de sangue?
                                    </fieldset>
                                    
                                </fieldset>
                                
                                <fieldset class="linha">
                                    <fieldset class="coluna">
                                        <label for="txtCPF">CPF</label>
                                        <input type="text" id="txtCPF" name="PES_CPF" class="campoTextoPadrao" placeholder="___.___.___-__" style="width: 82px;"/>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label for="txtRG">RG</label>
                                        <input type="text" id="txtRG" name="PES_RG" class="campoTextoPadrao" placeholder="" style="width: 105px;"/>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label for="txtRGOrgaoEmissor">Órgão Emissor</label>
                                        <input type="text" id="txtRGOrgaoEmissor" name="PES_RGOrgaoEmissao" class="campoTextoPadrao" placeholder="EX.: SSP/PE" style="width: 70px;"/>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label for="txtTelefone">Telefone</label>
                                        <input type="text" id="txtTelefone" name="PES_TelefoneResidencial" class="campoTextoPadrao" placeholder="(__) ____.____" style="width: 100px;"/>
                                    </fieldset>                    
                                    <fieldset class="coluna">
                                        <label for="txtCelular">Celular</label>
                                        <input type="text" id="txtCelular" name="PES_TelefoneCelular" class="campoTextoPadrao" placeholder="(__) ____.____" style="width: 100px;"/>
                                    </fieldset> 
                                </fieldset>
                                
                                <fieldset class="linha">
                                    <fieldset class="coluna">
                                        <label for="txtEmailPrimario">E-mail primário</label>
                                        <input type="text" id="txtEmailPrimario" name="PES_EmailPrimario" class="campoTextoPadrao" placeholder="" style="width: 303px;" />
                                    </fieldset>
                                    <fieldset class="coluna">                        
                                        <label for="txtEmailSecundario">E-mail secundário</label>
                                        <input type="text" id="txtEmailSecundario" name="PES_EmailSecundario" class="campoTextoPadrao" placeholder="" style="width: 280px;" />
                                    </fieldset>
                                </fieldset> 
                                
                                <fieldset class="linha">
                                    <fieldset class="coluna">
                                        <label for="txtNaturalidade">Naturalidade</label>
                                        <input type="text" id="txtNaturalidade" name="PES_Naturalidade" class="campoTextoPadrao" placeholder="EX.: RECIFE" style="width: 303px;"/>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label for="txtNascionalidade">Nacionalidade</label>
                                        <input type="text" id="txtNascionalidade" name="PES_Nacionalidade" class="campoTextoPadrao" placeholder="EX.: BRASILEIRA" style="width: 280px;"/>
                                    </fieldset>
                                </fieldset>

                                <fieldset class="linha">
                                    <fieldset class="coluna">
                                        <div class="side-by-side clearfix">
                                        <label for="selNivelEscolaridade">Nível de escolaridade</label>                                
                                            <select data-placeholder="SELECIONE O NÍVEL DE ESCOLARIDADE." style="width:320px;" class="chosen-select-deselect" id="selNivelEscolaridade"  name="NES_ID">
                                                <option value=""></option>
                                                <?php
                                                    $arrStrFiltros["NES_Status"] = "A";
                                                    $arrObjEscolaridade  = FachadaCadastro::getInstance()->consultarNivelEscolaridade($arrStrFiltros);
                                                    if($arrObjEscolaridade != null){
                                                        $arrObj = $arrObjEscolaridade["objects"];                                                
                                                        for($intI=0; $intI<count($arrObj); $intI++){
                                                           echo '<option value="'. $arrObj[$intI]->getId().'">'.utf8_encode($arrObj[$intI]->getDescricao()).'</option>';
                                                        }
                                                    }
                                                ?> 
                                            </select>
                                        </div>
                                    </fieldset>
                                    <fieldset class="coluna">
                                        <label for="txtFormacao">Formação</label>
                                        <input type="text" id="txtFormacao" name="PES_Formacao" class="campoTextoPadrao" placeholder="EX.: ANALISTA DE SISTEMAS" style="width: 280px;" />                                    
                                    </fieldset>                                
                                </fieldset> 
                                
                                
                                <fieldset class="linha">                                    
                                    <fieldset class="linha">                    
                                        <fieldset class="coluna">
                                            <label for="txtMae">Nome da mãe</label>
                                            <input type="text" id="txtMae" name="PES_MaeNome" class="campoTextoPadrao" placeholder="EX.: MARIA DA SILVA" style="width: 300px;"/>
                                        </fieldset> 
                                        <fieldset class="coluna">
                                            <label for="txtPai">Nome do pai</label>
                                            <input type="text" id="txtPai" name="PES_PaiNome" class="campoTextoPadrao" placeholder="EX.: JOÃO DA SILVA" style="width: 280px;"/>
                                        </fieldset> 
                                    </fieldset>
                                    
                                </fieldset>
                                
                                <fieldset class="linha">                                
                                        <fieldset class="coluna" style="  margin: 25px 5px 10px 0px;  ">
                                            <input type="checkbox" id="ckbFalecimento" value="I" name="PES_Falecimento" onclick="exibirDataFalecimento();"/>Falecido?
                                        </fieldset>
                                        <fieldset class="coluna" id="divDataFalecimento" >                                    
                                            <label for="txtDataFalecimento">Data de falecimento</label>
                                            <input type="text" id="txtDataFalecimento" name="PES_DataFalecimento" class="campoData" placeholder="__/__/____" style="width: 110px;"/>
                                        </fieldset>
                                    </fieldset>
                                
                            </fieldset>
                        </fieldset>
                        
                    </div>
                    <!--tabs-pessoais --> 
                    
                     
                    
                    <div id="tabs-endereco">
                        <fieldset class="linha">
                            <fieldset style="border: 0px;" >
                             
                                 <fieldset class="linha">
                                     <label for="txtEnderecoCEP">CEP</label>
                                     <input type="text" id="txtEnderecoCEP" name="PES_EnderecoCep" class="campoTextoPadrao" style="width: 100px;" placeholder="_____-___"/>
                                     <a href="javascript: void();" onclick="consultarEndereco();">                                         
                                         <img src="../../../modulos/sistema/home/img/botao-pesquisar.png" border="0" align="absmiddle"/>
                                     </a>
                                     <span id="spnCarregandoCEP"></span>
                                 </fieldset>
                                 <fieldset class="coluna">
                                     <label for="txtEnderecoLogradouro">Logradouro</label>
                                     <input type="text" id="txtEnderecoLogradouro" name="PES_EnderecoLogradouro" class="campoTextoPadrao"  style="width: 300px;"/>
                                 </fieldset>
                                 <fieldset class="coluna">
                                     <label for="txtEnderecoNumero">N&uacute;mero</label>
                                     <input type="text" id="txtEnderecoNumero" name="PES_EnderecoNumero" class="campoTextoPadrao" style="width: 100px;"/>
                                 </fieldset>
                                 <fieldset class="coluna">
                                     <label for="txtEnderecoComplemento">Complemento</label>
                                     <input type="text" id="txtEnderecoComplemento" name="PES_EnderecoComplemento" class="campoTextoPadrao" style="width: 300px;"/>
                                 </fieldset>                
                                 <fieldset class="coluna">
                                     <label for="txtEnderecoBairro">Bairro</label>
                                     <input type="text" id="txtEnderecoBairro" name="PES_EnderecoBairro" class="campoTextoPadrao" style="width: 300px;"/>
                                 </fieldset>
                                <fieldset class="coluna">
                                     <label for="txtEnderecoCidade">Cidade</label>
                                     <input type="text" id="txtEnderecoCidade" name="PES_EnderecoCidade" class="campoTextoPadrao" style="width: 300px;"/>
                                 </fieldset>
                                 <fieldset class="linha">                                     
                                     <fieldset class="coluna">
                                        <label for="txtEnderecoPontoReferencia">Ponto de referência</label>
                                        <input type="text" id="txtEnderecoPontoReferencia" name="PES_EnderecoPontoReferencia" class="campoTextoPadrao" style="width: 300px;"/>
                                    </fieldset> 
                                     <fieldset class="coluna" >
                                         <label for="selEnderecoUF">UF</label>
                                         <?php
                                             echo UFSelectComponente::getInstance()->gerarSigla("selEnderecoUF", "PES_EnderecoUf", true);
                                         ?>
                                     </fieldset>
                                 </fieldset>
                             </fieldset>  
                         </fieldset>                                 
                    </div><!--tabs-endereco -->
                    
                    <div id="tabs-profissionais">
                        
                        <fieldset class="linha" >                                    
                            <label for="txtFuncao">Função</label>
                            <input type="text" id="txtFuncao" name="FUN_Funcao" class="campoTextoPadrao" placeholder="EX.: ZELADOR" style=" width: 400px; "/>
                        </fieldset>
                        
                        <fieldset class="linha" >                                    
                            <label for="txtCarteiraTrabalho">Carteira de trabalho</label>
                            <input type="text" id="txtCarteiraTrabalho" name="FUN_CarteiraTrabalhoNumero" class="campoTextoPadrao" placeholder="EX.: 3240903 " style=" width: 400px; "/>
                        </fieldset>
                        
                        <fieldset class="linha" >                                    
                            <label for="txtCNH">Carteira de habilitação</label>
                            <input type="text" id="txtCNH" name="FUN_CNHNumero" class="campoTextoPadrao" placeholder="EX.: 3240903 CATEGORIA 'A' " style=" width: 400px; "/>
                        </fieldset>
                        
                        
                        <fieldset class="linha">                                                     
                            <fieldset class="coluna" >                                    
                                <label for="txtDataAdmissao">Data de admissão</label>
                                <input type="text" id="txtDataAdmissao" name="FUN_DataAdmissao" class="campoData" placeholder="__/__/____" style="width: 190px;"/>
                            </fieldset>
                            
                            <fieldset class="coluna" >                                    
                                <label for="txtDataSaida">Data saída</label>
                                <input type="text" id="txtDataSaida" name="FUN_DataSaida" class="campoData" placeholder="__/__/____" style="width: 190px;"/>
                            </fieldset>
                        </fieldset>
                            
                            
                            
                        <fieldset class="linha" >                                    
                            <fieldset class="coluna" >                                    
                                <label for="txtSalario">Salário (R$)</label>
                                <input type="text" id="txtSalario" name="FUN_Salario" class="campoTextoPadrao" placeholder="0,00" style="width: 190px;"/>
                            </fieldset>                            
                            <fieldset class="coluna" >                                    
                                <label for="txtCargaHoraria">Carga horária (Semana)</label>
                                <input type="text" id="txtCargaHoraria" name="FUN_CargaHoraria" class="campoTextoPadrao" placeholder="0" style="width: 190px;"/>
                                <!--<input type="text" id="txtCargaHoraria" name="FUN_CargaHoraria" class="campoTextoPadrao" placeholder="00" data-timeEntry="show24Hours: true, minTime: 'new Date(0, 0, 0, 8, 30, 0)'"/>-->

                            </fieldset>
                        </fieldset>
                            
                        <fieldset class="linha" >                                    
                            <fieldset class="coluna" >                                    
                                <label for="txtHorarioEntrada">Hórario de entrada</label>
                                <input type="text" id="txtHorarioEntrada" name="FUN_HorarioEntrada" class="campoTextoPadrao" placeholder="00:00" style="width: 190px;"/>
                            </fieldset>
                            <fieldset class="coluna" >                                    
                                <label for="txtHorarioSaida">Hórario de saída</label>
                                <input type="text" id="txtHorarioSaida" name="FUN_HorarioSaida" class="campoTextoPadrao" placeholder="00:00" style="width: 190px;"/>
                            </fieldset>
                        </fieldset>
                        
                    </div><!--tabs-profissionais-->
                    
                    <div id="tabs-outros">                        
                        <fieldset class="linha">  
                            <fieldset style="border: 0px; height: 300px;">
                                <label>Anotações</label>
                                <textarea id="txtObservacao" name="PES_Observacao" rows="4" class="campoTextoPadrao" style="width: 98%; height:85%"></textarea>
                            </fieldset>                            
                        </fieldset>
                    </div><!--tabs-outros-->
                    
                    
                    
                </div><!--fim tabs-dados -->
                
                <fieldset class="linha" style="margin-top: 20px;">
                    <input type="checkbox" id="ckbStatus" value="I" name="PES_Status"/>Inativo
                </fieldset>
                <fieldset class="linha">
                    <input type="button" value="Salvar" onclick="salvar();" class="botao" id="btnSalvar"/>
                    <input type="button" value="Cancelar" onclick="cancelar();" class="botao"/>
                </fieldset>
            </form>        
            
            
            
            <div id="dialog-gerencia-foto" title="Gerenciar foto">
            <form id="frmFoto" method="POST" onSubmit="return false;">                                
                <div id="tabs-foto"  >
                    <ul>
                        <li><a href="#tabs-tirar-foto">Tirar foto</a></li>
                        <li><a href="#tabs-importar-foto">Importar foto</a></li>
                    </ul>                        
                    <div id="tabs-tirar-foto">
                        <div style=" height:440px; width: 100%;">                            
                            <table border="0" cellpadding="5" cellspacing="0" width="100%" height="100%" align="center">
                                <tr height="50px">
                                    <td width="50%" valign="middle" height="5%" align="left">
                                        <legend>Nova foto</legend>                                        
                                    </td>
                                    <td width="50%" valign="middle" height="5%" align="left">
                                        <legend>Tirar foto</legend>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" valign="middle" height="95%" align="center">                                        
                                        <div id="fotoTirada">
                                            <img  src="../../../modulos/sistema/home/img/sem-foto.png"  width='330' height='300' />
                                        </div>
                                    </td>
                                    <td width="50%" valign="middle" height="95%" align="center">
                                        
                                        <div id="div-camera" style=" margin-left: 15px; height:350px;	width: 400px; float: left;">
                                        </div>                                
                                    </td>
                                </tr>
                            </table>
                            
                        </div>
                    </div>
                    
                    <div id="tabs-importar-foto">                        
                                        
                        <table border="0" cellpadding="5" cellspacing="0" width="100%" height="440px" align="center">
                            
                            <tr height="50px">
                                <td colspan="2">
                                    <legend>Foto com 320px X 240px, com no máximo 1MB</legend>
                                    <input type="file" name="FUN_Imagem" id="fileImagem" class="file" accept="image/*" />
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td width="50%" valign="middle" height="5%" align="left">
                                    <legend>Nova foto</legend>
                                </td>
                                <td width="50%" valign="middle" height="5%" align="left">
                                    <legend>Foto existente</legend>                                     
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="50%" valign="middle" height="95%" align="center">                                        
                                    <div id="div-foto-nova">
                                        <center>
                                            <img  src="../../../modulos/sistema/home/img/sem-foto.png"  width='330' height='300' />
                                        </center>
                                    </div>
                                </td>
                                <td width="50%" valign="middle" height="95%" align="center">

                                    <div id="div-foto-existente">
                                        <center>
                                            <img src="../../../modulos/sistema/home/img/sem-foto.png" class="fotoTirada"  width='330' height='300' />
                                        </center>
                                    </div>                               
                                </td>
                            </tr>
                        </table>                                           
                    </div>
                </div> 
            </form>
            </div>            
        </div>      
    </div>    
    <script type="text/javascript">
        init();        
    </script>
</body>
</html>