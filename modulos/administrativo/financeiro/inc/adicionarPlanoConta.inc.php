<script type="text/javascript">
    // forma de pagamento
    var controladorPlanoContas = "../../administrativo/financeiro/controladores/PlanoContaControlador.php";
    
    $("#dialogAdicionarPlanoConta").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarAdicionarPlanoConta();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    function janelaAdicionarPlanoConta(){
        $("#dialogAdicionarPlanoConta").dialog("open");    
        $("#txtAdicionarPLA_Descricao").val("");
        $('#txtAdicionarPLA_CodigoContabil').val("");
    }
    function salvarAdicionarPlanoConta(){    
        if($.trim($('#txtAdicionarPLA_Descricao').val()) == ""){
            $("#hddFocus").val("txtAdicionarPLA_Descricao");
            $("#dialog-atencao").html("Por favor, informe a descri&ccedil;&atilde;o.");
            $("#dialog-atencao").dialog("open");
            return;
        }

        if($.trim($('#txtAdicionarPLA_CodigoContabil').val()) == ""){
            $("#hddFocus").val("txtAdicionarPLA_CodigoContabil");
            $("#dialog-atencao").html("Por favor, informe o código contábil.");
            $("#dialog-atencao").dialog("open");
            return;
        }

        if(!consultarCodigoContabil($('#txtAdicionarPLA_CodigoContabil').val())){                        
            $("#hddFocus").val("txtAdicionarPLA_CodigoContabil");
            $("#dialog-atencao").html("Código contábil já cadastrado.");        
            $("#dialog-atencao").dialog("open");                
            return;
        }

        preLoadingOpen("Gravando, aguarde...");    

        // bind form using ajaxForm 
        $('#frmAdicionarPlanoConta').ajaxForm({
            dataType:  'json', // Comentar essa linha para debugar
            success: function(data){
                preLoadingClose();

                if(data.excecao == "true"){
                    $("#dialog-excecao").html(data.mensagem);
                    $("#dialog-excecao").dialog("open");
                }else{
                    getPlanoContasDinamico();
                    $("#dialogAdicionarPlanoConta").dialog("close");
                } 
            } 
        }).submit();
    }
    
    function consultarCodigoContabil(codigoContabil){    
        var retorno = false;
        $.ajax({
            type: "POST",
            url: controladorPlanoContas,
            dataType: 'json',
            cache: false,
            async:false,    
            data: {PLA_CodigoContabil: codigoContabil, ACO_Descricao: "ConsultarCodigoContabil"}
        }).done(function( data ) {  
            if(data.sucesso == "true"){                                       
                retorno = true;                
            }else{            
                retorno = false;
            }
        });

        return retorno; 
    }
</script>
<!-- forma de pagamento -->
<div id="dialogAdicionarPlanoConta" title="Adicionar Plano de Contas">
    <form id="frmAdicionarPlanoConta" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/PlanoContaControlador.php" method="POST">
        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
        <input type="hidden" id="hddID" name="PLA_ID"/>
        <fieldset class="coluna">
            <label for="txtAdicionarPLA_Descricao">Descri&ccedil;&atilde;o*</label>
            <input type="text" id="txtAdicionarPLA_Descricao" name="PLA_Descricao" class="campoTextoPadrao" placeholder="" style="width: 250px;"/>
        </fieldset>                
        <fieldset class="linha">
            <label for="txtAdicionarPLA_CodigoContabil">C&oacute;digo Cont&aacute;bil*</label>
            <input type="text" id="txtAdicionarPLA_CodigoContabil" name="PLA_CodigoContabil" class="campoTextoPadrao" style="width: 250px;" maxlength="45" placeholder=""/>
        </fieldset>
        <fieldset class="linha">
            <label for="txtCodigoContabil">Movimenta&ccedil;&atilde;o*</label>
            <input type="radio" name="PLA_Movimentacao" value="E" checked/>Entrada
            <input type="radio" name="PLA_Movimentacao" value="S"/>Sa&iacute;da
        </fieldset>
       <input type="hidden" id="hddID" name="PLA_Tipo" value="A"/>
    </form>
</div>