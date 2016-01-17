<script type="text/javascript">
    // forma de pagamento
    var controladorContaBancaria = "../../administrativo/financeiro/controladores/ContaBancariaControlador.php";
    
    $("#dialogAdicionarContaBancaria").dialog({
        autoOpen: false,
        width: 700,
        height: 500,
        buttons: {
            "Salvar": function() {                         
                salvarAdicionarContaBancaria();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    function janelaAdicionarContaBancaria(){
        $("#dialogAdicionarContaBancaria").dialog("open");    
        $("#txtAdicionarCOB_Descricao").val("");
        
        $('#selAdicionarCOB_Banco').val("");        
        $("#selAdicionarCOB_Banco").trigger('chosen:updated');
        
        $("#txtAdicionarCOB_Agencia").val("");
        
        $("#txtAdicionarCOB_Conta").val("");
        $("#txtAdicionarCOB_SaldoInicial").val("0,00");
        
        $("#selAdicionarCOB_PlanoConta").val("");
        $("#selAdicionarCOB_PlanoConta").trigger('chosen:updated');        
    }
    function salvarAdicionarContaBancaria(){    
        if($.trim($('#txtAdicionarCOB_Descricao').val()) == ""){
            $("#hddFocus").val("txtAdicionarCOB_Descricao");
            $("#dialog-atencao").html("Por favor, informe a descri&ccedil;&atilde;o.");
            $("#dialog-atencao").dialog("open");
            return;
        }

        if($.trim($('#selAdicionarCOB_Banco').val()) == ""){
            $("#hddFocus").val("selAdicionarCOB_Banco");
            $("#dialog-atencao").html("Por favor, informe o banco.");
            $("#dialog-atencao").dialog("open");
            return;
        }

        if($.trim($('#txtAdicionarCOB_Agencia').val()) == ""){
            $("#hddFocus").val("txtAdicionarCOB_Agencia");
            $("#dialog-atencao").html("Por favor, informe a agência.");
            $("#dialog-atencao").dialog("open");
            return;
        }
        
        if($.trim($('#txtAdicionarCOB_Conta').val()) == ""){
            $("#hddFocus").val("txtAdicionarCOB_Conta");
            $("#dialog-atencao").html("Por favor, informe a conta.");
            $("#dialog-atencao").dialog("open");
            return;
        }
        
        if($.trim($('#txtAdicionarCOB_SaldoInicial').val()) == ""){
            $("#hddFocus").val("txtAdicionarCOB_SaldoInicial");
            $("#dialog-atencao").html("Por favor, informe o saldo inicial.");
            $("#dialog-atencao").dialog("open");
            return;
        }
        
        if($.trim($('#selAdicionarCOB_PlanoConta').val()) == ""){
            $("#hddFocus").val("selAdicionarCOB_PlanoConta");
            $("#dialog-atencao").html("Por favor, informe o plano de contas.");
            $("#dialog-atencao").dialog("open");
            return;
        }

        preLoadingOpen("Gravando, aguarde...");    

        // bind form using ajaxForm 
        $('#frmAdicionarContaBancaria').ajaxForm({
            dataType:  'json', // Comentar essa linha para debugar
            success: function(data){
                preLoadingClose();

                if(data.excecao == "true"){
                    $("#dialog-excecao").html(data.mensagem);
                    $("#dialog-excecao").dialog("open");
                }else{
                    getContasBancariasDinamico();
                    $("#dialogAdicionarContaBancaria").dialog("close");
                } 
            } 
        }).submit();
    }
</script>
<!-- conta bancária -->
<div id="dialogAdicionarContaBancaria" title="Adicionar Conta Bancária">
    <form id="frmAdicionarContaBancaria" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/ContaBancariaControlador.php" method="POST">
        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
        <input type="hidden" id="hddID" name="COB_ID"/>
        <fieldset class="linha">
            <fieldset class="coluna">
                <label for="txtAdicionarCOB_Descricao">Descri&ccedil;&atilde;o* </label>
                <input type="text" id="txtAdicionarCOB_Descricao" name="COB_Descricao" class="campoTextoPadrao" style="width: 259px;" placeholder="Ex.: Conta, Poupan&ccedil;a, etc" />
            </fieldset>
            <fieldset class="coluna">
                <label for="selAdicionarCOB_Banco">Banco*</label>
                <select id="selAdicionarCOB_Banco" name="BAN_ID" data-placeholder="SELECIONE O BANCO." class="chosen-select-deselect" style="width: 281px;">
                    <option value=""></option>
                    <?php
                        $arrStrFiltros = array();
                        $arrStrFiltros["BAN_Status"] = "A";
                        $arrObjs = FachadaFinanceiro::getInstance()->consultarBanco($arrStrFiltros);
                        $arrObjs = $arrObjs["objects"];
                        $strHtml = '';                            

                        for($intI=0; $intI<count($arrObjs); $intI++){
                            $strHtml .= '<option value="'.$arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().' (COD. '.$arrObjs[$intI]->getCodigo().') '.'</option>';
                        }

                        echo $strHtml;
                    ?>
                </select>
            </fieldset>                    
        </fieldset>
        <fieldset class="linha" style="margin-top: 10px;">
            <fieldset class="coluna">
                <label for="txtAdicionarCOB_Agencia">Ag&ecirc;ncia*</label>
                <input type="text" id="txtAdicionarCOB_Agencia" name="COB_Agencia" class="campoTextoPadrao" />
            </fieldset>
            <fieldset class="coluna">
                <label for="txtAdicionarCOB_Conta">Conta*</label>
                <input type="text" id="txtAdicionarCOB_Conta" name="COB_Conta" class="campoTextoPadrao" style="width: 120px;" />
            </fieldset> 
            <fieldset class="coluna">
                <label for="txtAdicionarCOB_SaldoInicial">Saldo Inicial*</label>
                <input type="text" id="txtAdicionarCOB_SaldoInicial" name="COB_SaldoInicial" class="campoTextoPadrao" value="0,00" style="width: 120px;"  />
            </fieldset>
        </fieldset>

        <fieldset class="linha">
            <fieldset class="coluna">
                <label for="selAdicionarCOB_PlanoConta">Plano de Contas*</label>
                <select id="selAdicionarCOB_PlanoConta" name="PLA_ID" data-placeholder="SELECIONE O PLANO DE CONTAS." class="chosen-select-deselect" style="width: 564px;">
                    <option value=""></option>
                    <?php
                        $arrStrFiltros = array();
                        $arrStrFiltros["PLA_Status"] = "A";
                        $arrStrFiltros["PLA_Tipo"] = "A";
                        $arrObjs = FachadaFinanceiro::getInstance()->consultarPlanoConta($arrStrFiltros);
                        $arrObjs = $arrObjs["objects"];
                        $strHtml = '';                            

                        for($intI=0; $intI<count($arrObjs); $intI++){
                            $strHtml .= '<option value="'.$arrObjs[$intI]->getId().'">'.$arrObjs[$intI]->getDescricao().'</option>';
                        }

                        echo $strHtml;
                    ?>
                </select>
            </fieldset>
        </fieldset>
    </form>
</div>