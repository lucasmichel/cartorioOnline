<script type="text/javascript">
    // forma de pagamento
    var controladorLote = "../../administrativo/financeiro/controladores/LoteControlador.php";
    
    $("#dialogAdicionarLote").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarAdicionarLote();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    function janelaAdicionarLote(){
        $("#dialogAdicionarLote").dialog("open");    
        $("#txtAdicionarLOT_Descricao").val("");
    }
    function salvarAdicionarLote(){    
        if($.trim($('#txtAdicionarLOT_Descricao').val()) == ""){
            $("#hddFocus").val("txtAdicionarLOT_Descricao");
            $("#dialog-atencao").html("Por favor, informe o lote.");
            $("#dialog-atencao").dialog("open");
            return;
        }

        preLoadingOpen("Gravando, aguarde...");    

        // bind form using ajaxForm 
        $('#frmAdicionarLote').ajaxForm({
            dataType:  'json', // Comentar essa linha para debugar
            success: function(data){            
                preLoadingClose();

                if(data.excecao == "true"){
                    $("#dialog-excecao").html(data.mensagem);
                    $("#dialog-excecao").dialog("open");
                }else{
                    getLoteDinamico();
                    $("#dialogAdicionarLote").dialog("close");
                } 
            } 
        }).submit();
    }
</script>
<!-- forma de pagamento -->
<div id="dialogAdicionarLote" title="Adicionar Lote">
    <form id="frmAdicionarLote" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/LoteControlador.php" method="POST">
        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
        <input type="hidden" id="hddID" name="LOT_ID"/>
        <fieldset class="coluna">
            <label for="txtAdicionarLOT_Descricao">Lote*</label>
            <input type="text" id="txtAdicionarLOT_Descricao" name="LOT_Descricao" class="campoTextoPadrao" placeholder="" style="width: 250px;"/>
        </fieldset> 
    </form>
</div>