<script type="text/javascript">
    // forma de pagamento
    var controladorFormaPagamento = "../../administrativo/financeiro/controladores/FormaPagamentoControlador.php";
    
    $("#dialogAdicionarFormaPagamento").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarAdicionarFormaPagamento();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    function janelaAdicionarFormaPagamento(){
        $("#dialogAdicionarFormaPagamento").dialog("open");    
        $("#txtAdicionarFPG_Descricao").val("");
    }
    function salvarAdicionarFormaPagamento(){    
        if($.trim($('#txtAdicionarFPG_Descricao').val()) == ""){
            $("#hddFocus").val("txtAdicionarFPG_Descricao");
            $("#dialog-atencao").html("Por favor, informe a descri&ccedil;&atilde;o.");
            $("#dialog-atencao").dialog("open");
            return;
        }

        preLoadingOpen("Gravando, aguarde...");    

        // bind form using ajaxForm 
        $('#frmAdicionarFormaPagamento').ajaxForm({
            dataType:  'json', // Comentar essa linha para debugar
            success: function(data){            
                preLoadingClose();

                if(data.excecao == "true"){
                    $("#dialog-excecao").html(data.mensagem);
                    $("#dialog-excecao").dialog("open");
                }else{
                    getFormaPagamentoDinamico();
                    $("#dialogAdicionarFormaPagamento").dialog("close");
                } 
            } 
        }).submit();
    }
</script>
<!-- forma de pagamento -->
<div id="dialogAdicionarFormaPagamento" title="Adicionar Forma de Pagamento">
    <form id="frmAdicionarFormaPagamento" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/FormaPagamentoControlador.php" method="POST">
        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
        <input type="hidden" id="hddID" name="FPG_ID"/>
        <fieldset class="coluna">
            <label for="txtAdicionarFPG_Descricao">Descri&ccedil;&atilde;o*</label>
            <input type="text" id="txtAdicionarFPG_Descricao" name="FPG_Descricao" class="campoTextoPadrao" placeholder="" style="width: 250px;"/>
        </fieldset> 
    </form>
</div>