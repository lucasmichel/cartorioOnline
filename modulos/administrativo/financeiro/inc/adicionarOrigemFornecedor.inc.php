<script type="text/javascript">
    var controladorFornecedor = "../../administrativo/financeiro/controladores/FornecedorControlador.php";
    
    $("#dialogAdicionarFornecedor").dialog({
        autoOpen: false,
        buttons: {
            "Salvar": function() {                         
                salvarAdicionarFornecedor();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    function janelaAdicionarFornecedor(){
        $("#dialogAdicionarFornecedor").dialog("open");    
        $("#txtAdicionarFOR_NomeFantasia").val("");
    }
    function salvarAdicionarFornecedor(){    
        if($.trim($('#txtAdicionarFOR_NomeFantasia').val()) == ""){
            $("#hddFocus").val("txtAdicionarFOR_NomeFantasia");
            $("#dialog-atencao").html("Por favor, informe o nome.");
            $("#dialog-atencao").dialog("open");
            return;
        }

        preLoadingOpen("Gravando, aguarde...");    

        // bind form using ajaxForm 
        $('#frmAdicionarFornecedor').ajaxForm({
            dataType:  'json', // Comentar essa linha para debugar
            success: function(data){            
                preLoadingClose();

                if(data.excecao == "true"){
                    $("#dialog-excecao").html(data.mensagem);
                    $("#dialog-excecao").dialog("open");
                }else{
                    getFornecedorDinamico();
                    $("#dialogAdicionarFornecedor").dialog("close");
                } 
            } 
        }).submit();
    }
</script>
<!-- centro de custo -->
<div id="dialogAdicionarFornecedor" title="Adicionar Fornecedor">
    <form id="frmAdicionarFornecedor" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/FornecedorControlador.php" method="POST">
        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
        <input type="hidden" id="hddID" name="FOR_ID"/>
        <input type="hidden" id="hddStatus" name="FOR_Status" value="A"/>
        <fieldset class="coluna">
            <label for="txtAdicionarFOR_NomeFantasia">Nome*</label>
            <input type="text" id="txtAdicionarFOR_NomeFantasia" name="FOR_NomeFantasia" class="campoTextoPadrao" placeholder="" style="width: 250px;"/>
        </fieldset> 
    </form>
</div>