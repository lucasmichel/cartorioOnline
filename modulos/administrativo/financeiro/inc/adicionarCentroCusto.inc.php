<script type="text/javascript">
    var controladorCentroCusto = "../../administrativo/financeiro/controladores/CentroCustoControlador.php";
    
    $("#dialogAdicionarCentroCusto").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarAdicionarCentroCusto();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    function janelaAdicionarCentroCusto(){
        $("#dialogAdicionarCentroCusto").dialog("open");    
        $("#txtAdicionarCEN_Descricao").val("");
    }
    function salvarAdicionarCentroCusto(){    
        if($.trim($('#txtAdicionarCEN_Descricao').val()) == ""){
            $("#hddFocus").val("txtAdicionarCEN_Descricao");
            $("#dialog-atencao").html("Por favor, informe a descri&ccedil;&atilde;o.");
            $("#dialog-atencao").dialog("open");
            return;
        }

        preLoadingOpen("Gravando, aguarde...");    

        // bind form using ajaxForm 
        $('#frmAdicionarCentroCusto').ajaxForm({
            dataType:  'json', // Comentar essa linha para debugar
            success: function(data){            
                preLoadingClose();

                if(data.excecao == "true"){
                    $("#dialog-excecao").html(data.mensagem);
                    $("#dialog-excecao").dialog("open");
                }else{
                    getCentroCustoDinamico();
                    $("#dialogAdicionarCentroCusto").dialog("close");
                } 
            } 
        }).submit();
    }
</script>
<!-- centro de custo -->
<div id="dialogAdicionarCentroCusto" title="Adicionar Centro de Custo">
    <form id="frmAdicionarCentroCusto" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/CentroCustoControlador.php" method="POST">
        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
        <input type="hidden" id="hddID" name="CEN_ID"/>
        <fieldset class="coluna">
            <label for="txtAdicionarCEN_Descricao">Descri&ccedil;&atilde;o*</label>
            <input type="text" id="txtAdicionarCEN_Descricao" name="CEN_Descricao" class="campoTextoPadrao" placeholder="" style="width: 250px;"/>
        </fieldset> 
    </form>
</div>