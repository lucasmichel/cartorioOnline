<script type="text/javascript">
    // forma de pagamento
    var controladorPlanoContas = "../../administrativo/patrimonio/controladores/TipoPatrimonioControlador.php";
    
    $("#dialogAdicionarTipoPatrimonio").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarAdicionarTipoPatrimonio();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    
    function janelaAdicionarTipoPatrimonio(){
        $("#dialogAdicionarTipoPatrimonio").dialog("open");    
        $("#txtAdicionarTIP_Descricao").val("");        
    }
    
    function salvarAdicionarTipoPatrimonio(){    
        if($.trim($('#txtAdicionarTIP_Descricao').val()) == ""){
            $("#hddFocus").val("txtAdicionarTIP_Descricao");
            $("#dialog-atencao").html("Por favor, informe a descri&ccedil;&atilde;o.");
            $("#dialog-atencao").dialog("open");
            return;
        }

        preLoadingOpen("Gravando, aguarde...");    

        // bind form using ajaxForm 
        $('#frmAdicionarTipoPatrimonio').ajaxForm({
            dataType:  'json', // Comentar essa linha para debugar
            success: function(data){
                preLoadingClose();

                if(data.excecao == "true"){
                    $("#dialog-excecao").html(data.mensagem);
                    $("#dialog-excecao").dialog("open");
                }else{
                    getItemPatrimonioDinamico();
                    $("#dialogAdicionarTipoPatrimonio").dialog("close");
                } 
            } 
        }).submit();
    }
    
    
</script>
<!-- forma de pagamento -->
<div id="dialogAdicionarTipoPatrimonio" title="Adicionar Grupo de Bens">
    <form id="frmAdicionarTipoPatrimonio" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/TipoPatrimonioControlador.php" method="POST">
        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
        <input type="hidden" id="hddID" name="TIP_ID"/>
        <fieldset class="coluna">
            <label for="txtAdicionarTIP_Descricao">Descri&ccedil;&atilde;o*</label>
            <input type="text" id="txtAdicionarTIP_Descricao" name="TIP_Descricao" class="campoTextoPadrao" placeholder="" style="width: 250px;"/>
        </fieldset>                               
    </form>
</div>