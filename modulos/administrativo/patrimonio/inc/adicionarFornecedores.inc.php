<script type="text/javascript">
    // forma de pagamento
    var controladorPlanoContas = "../../administrativo/financeiro/controladores/FornecedorControlador.php";
        
    $("#dialogAdicionarFornecedor").dialog({
        autoOpen: false,        
        buttons: {
            "Salvar": function() {                         
                salvarFornecedor();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    
    function janelaAdicionarFornecedores(){
        $("#dialogAdicionarFornecedor").dialog("open");    
        $("#txtAdicionarTIP_Descricao").val("");        
    }
    
    function salvarFornecedor(){
        if($.trim($('#txtNomeFantasia').val()) == ""){        
            $('#tabs-dados-fornecedores').tabs('option', 'active', 0);
            $("#hddFocus").val("txtNomeFantasia");
            $("#dialog-atencao").html("Por favor, informe o nome.");
            $("#dialog-atencao").dialog("open");
            return;
        }    

        preLoadingOpen("Gravando, aguarde...");

        // bind form using ajaxForm 
        $('#frmAdicionarFornecedor').ajaxForm({
            // dataType identifies the expected content type of the server response 
            dataType:  'json', // Comentar essa linha para debugar
            // success identifies the function to invoke when the server response 
            // has been received
            success: function(data){             
                preLoadingClose();
                if(data.excecao == "true"){
                    $("#dialog-excecao").html(data.mensagem);
                    $("#dialog-excecao").dialog("open");
                }else{
                    getFornecedoresDinamico();
                    $("#dialogAdicionarFornecedor").dialog("close");
                } 
            }
        }).submit();
    }
    
    function verificaTipoPessoa(){    
        if($('#ckbTipo').is(':checked')) {         
            $("#labNomeFantasiaLabel").html("Nome*");            
        }else{
            $("#labNomeFantasiaLabel").html("Nome Fantasia*");
        } 
    }
</script>
<!-- forma de pagamento -->
<div id="dialogAdicionarFornecedor" title="Adicionar Fornecedores">
    <form id="frmAdicionarFornecedor" onsubmit="return false;" action="../../administrativo/financeiro/controladores/FornecedorControlador.php" method="POST">
        <input type="hidden" id="hddFocus"/><!-- responsável por guardar o campos que receberá o focus -->        
        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
        <fieldset class="linha" style="margin-bottom: 20px;">
            <input type="checkbox" id="ckbTipo" value="PF" name="FOR_Tipo" onclick="verificaTipoPessoa()"  />Pessoa F&iacute;sica
        </fieldset>  

        <fieldset class="linha">
            <fieldset class="coluna">
                <label id="labNomeFantasiaLabel" for="txtNomeFantasia">Nome Fantasia*</label>
                <input type="text" id="txtNomeFantasia" name="FOR_NomeFantasia" class="campoTextoPadrao"  style="width: 250px;"/>
            </fieldset>
        </fieldset>        
    </form>
</div>