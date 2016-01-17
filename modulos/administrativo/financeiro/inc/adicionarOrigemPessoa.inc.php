<script type="text/javascript">
    var controladorPessoa = "../../sistema/gerencial/controladores/PessoaControlador.php";
    
    $("#dialogAdicionarPessoa").dialog({
        autoOpen: false,
        width: 700,
        buttons: {
            "Salvar": function() {                         
                salvarAdicionarPessoa();
            },
            "Cancelar": function() {                         
                $(this).dialog("close"); 
            }
        }
    });
    function janelaAdicionarPessoa(){
        $("#dialogAdicionarPessoa").dialog("open");    
        $("#txtAdicionarPES_Nome").val("");
        $("#txtAdicionarPES_DataNascimento").val("");
        $("#txtAdicionarPES_DataNascimento").mask("99/99/9999");
        $("#selAdicionarPES_Sexo").val("M");
    }
    function salvarAdicionarPessoa(){    
        if($.trim($('#txtAdicionarPES_Nome').val()) == ""){
            $("#hddFocus").val("txtAdicionarPES_Nome");
            $("#dialog-atencao").html("Por favor, informe o nome.");
            $("#dialog-atencao").dialog("open");
            return;
        }
        
        if($.trim($('#txtAdicionarPES_DataNascimento').val()) == ""){
            $("#hddFocus").val("txtAdicionarPES_DataNascimento");
            $("#dialog-atencao").html("Por favor, informe a data de nascimento.");
            $("#dialog-atencao").dialog("open");
            return;
        }
        
        if(!isDataValida($.trim($('#txtAdicionarPES_DataNascimento').val()))){
            $("#hddFocus").val("txtAdicionarPES_DataNascimento");
            $("#dialog-atencao").html("Por favor, informe uma data de nascimento válida.");
            $("#dialog-atencao").dialog("open");
            return;
        }

        var tipo = $('input:radio[name=AdicionarPES_Tipo]:checked').val();
        
        //preLoadingOpen("Gravando, aguarde...");    

        if(tipo == "M"){
            $.ajax({
                type: "POST",
                url: "../../administrativo/cadastro/controladores/MembroControlador.php",
                dataType: "json",
                async: false,
                data: {
                    ACO_Descricao: "Salvar", 
                    PES_ID: $("#hddID").val(), 
                    PES_Status: $("#hddStatus").val(), 
                    MES_ID: $("#hddStatusMembro").val(), 
                    PES_Nome: $("#txtAdicionarPES_Nome").val(), 
                    PES_DataNascimento: $("#txtAdicionarPES_DataNascimento").val(), 
                    PES_Sexo: $("#selAdicionarPES_Sexo").val()
                }
            })
            .done(function( data ) {         
                 preLoadingClose();

                if(data.excecao == "true"){
                    $("#dialog-excecao").html(data.mensagem);
                    $("#dialog-excecao").dialog("open");
                }else{
                    getPessoaDinamico();
                    $("#dialogAdicionarPessoa").dialog("close");
                } 
            });
        }else{
            $.ajax({
                type: "POST",
                url: "../../administrativo/cadastro/controladores/FuncionarioControlador.php",
                dataType: "json",
                async: false,
                data: {
                    ACO_Descricao: "Salvar", 
                    PES_ID: $("#hddID").val(), 
                    PES_Status: $("#hddStatus").val(), 
                    MES_ID: $("#hddStatusMembro").val(), 
                    PES_Nome: $("#txtAdicionarPES_Nome").val(), 
                    PES_DataNascimento: $("#txtAdicionarPES_DataNascimento").val(), 
                    PES_Sexo: $("#selAdicionarPES_Sexo").val()
                }
            })
            .done(function( data ) {          
                 preLoadingClose();

                if(data.excecao == "true"){
                    $("#dialog-excecao").html(data.mensagem);
                    $("#dialog-excecao").dialog("open");
                }else{
                    getPessoaDinamico();
                    $("#dialogAdicionarPessoa").dialog("close");
                } 
            });
        }
    }
</script>
<!-- centro de custo -->
<div id="dialogAdicionarPessoa" title="Adicionar Membro/Funcionário">
    <form id="frmAdicionarPessoa" onsubmit="return false;" action="<?php echo $strDir; ?>/controladores/PessoaControlador.php" method="POST">
        <input type="hidden" name="ACO_Descricao" value="Salvar"/> <!-- para o Salvar/Alterar -->
        <input type="hidden" id="hddID" name="PES_ID"/>
        <input type="hidden" id="hddStatus" name="PES_Status" value="A"/>
        <input type="hidden" id="hddStatusMembro" name="MES_ID" value="1"/><!-- Entra como membro -->
        <fieldset class="coluna">
            <label for="txtAdicionarPES_Nome">Nome*</label>
            <input type="text" id="txtAdicionarPES_Nome" name="PES_Nome" class="campoTextoPadrao" placeholder="" style="width: 250px;"/>
        </fieldset>
        <fieldset class="coluna">
            <label for="txtAdicionarPES_DataNascimento">Data Nasc.*</label>
            <input type="text" id="txtAdicionarPES_DataNascimento" name="PES_DataNascimento" class="campoData" placeholder="__/__/____" style="width: 75px;"/>
        </fieldset>
        <fieldset class="coluna">                                    
            <label for="selAdicionarPES_Sexo">Sexo*</label>                                    
            <select style="width:100px;" class="campoSelect" id="selAdicionarPES_Sexo"  name="PES_Sexo">    
                <option value="F">FEMININO</option>
                <option value="M" selected>MASCULINO</option>
            </select>
        </fieldset>
        <fieldset class="coluna">
            <input type="radio" id="rdbAdicionarPES_TipoM" name="AdicionarPES_Tipo" value="M" checked/>Membro
            <input type="radio" id="rdbAdicionarPES_TipoF" name="AdicionarPES_Tipo" value="F"/>Funcionário
        </fieldset>
    </form>
</div>