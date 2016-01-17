<script type="text/javascript">
    // forma de pagamento
    var controladorPlanoContas = "../../administrativo/patrimonio/controladores/TipoPatrimonioControlador.php";
    
    $("#dialogAdicionarItemTipoPatrimonio").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarAdicionarItemTipoPatrimonio();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    
    function janelaAdicionarItemTipoPatrimonio(){        
        var a = $("#selTipo").val();
        $("#tipoId").val(a);
        $("#dialogAdicionarItemTipoPatrimonio").dialog("open");    
        $("#txtAdicionarIPT_Descricao").val("");        
    }
    
    function salvarAdicionarItemTipoPatrimonio(){    
        if($.trim($('#txtAdicionarIPT_Descricao').val()) == ""){
            $("#hddFocus").val("txtAdicionarIPT_Descricao");
            $("#dialog-atencao").html("Por favor, informe a descri&ccedil;&atilde;o.");
            $("#dialog-atencao").dialog("open");
            return;
        }

        preLoadingOpen("Gravando, aguarde...");    

        // bind form using ajaxForm 
        $('#frmAdicionarItemTipoPatrimonio').ajaxForm({
            dataType:  'json', // Comentar essa linha para debugar
            success: function(data){
                preLoadingClose();

                if(data.excecao == "true"){
                    $("#dialog-excecao").html(data.mensagem);
                    $("#dialog-excecao").dialog("open");
                }else{
                    consultarItensDoGrupo()

                    //getItemTipoPatrimonioDinamico();
                    $("#dialogAdicionarItemTipoPatrimonio").dialog("close");
                } 
            } 
        }).submit();
    }
    
    
</script>
<!-- forma de pagamento -->
<div id="dialogAdicionarItemTipoPatrimonio" title="Adicionar Subgrupo de Bens">
    <form id="frmAdicionarItemTipoPatrimonio" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/ItemPatrimonioControlador.php" method="POST">
        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
        <input type="hidden" id="tipoId" name="TIP_ID"/>        
        <input type="hidden" name="IPT_PercentualDepreciacao" value="0"/>        
        <fieldset class="coluna">
            <label for="txtAdicionarTIP_Descricao">Descri&ccedil;&atilde;o*</label>
            <input type="text" id="txtAdicionarIPT_Descricao" name="IPT_Descricao" class="campoTextoPadrao" placeholder="" style="width: 250px;"/>
        </fieldset>                               
    </form>
</div>