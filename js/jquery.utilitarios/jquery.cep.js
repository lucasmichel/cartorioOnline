function consultarCEP(objEnderecoCampos) {     
    if(objEnderecoCampos != null){
        if(typeof objEnderecoCampos == "object"){            
            var cep = $.trim($("#" + objEnderecoCampos.campoCep).val());
            if(cep == "" || existeEspacosVazios(cep)){
                $("#hddFocus").val(objEnderecoCampos.campoCep);
                $("#dialog-atencao").html("Por favor, informe um CEP.");        
                $('#dialog-atencao').dialog('open');
            }else{
                var objPreLoading = $("#" + objEnderecoCampos.spanPreLoading);                
                objPreLoading.html("<b>Aguarde, verificando o CEP...</b>");
                
                $.getScript("http://cep.portalms.net/?cep=" + cep, function(){
                    if(sucesso){                         
                        if(objEnderecoCampos.campoUf != null){                            
                            $("#" + objEnderecoCampos.campoUf).val(END_Uf);
                        }                        
                        $("#" + objEnderecoCampos.campoLogradouro).val(END_Logradouro);
                        $("#" + objEnderecoCampos.campoBairro).val(END_Bairro);
                        
                        if(objEnderecoCampos.campoCidade != null){
                            // objEnderecoCampos.campoCidade.id
                            // criado dessa forma pois o id pode ser TXT ou SEL(select)
                            // quando for select tem que identificar o código do município
                            if(!objEnderecoCampos.campoCidade.isSelect){
                                $("#" + objEnderecoCampos.campoCidade.id).val(END_Cidade);
                            }else{
                                $("#" + objEnderecoCampos.campoCidade.id).find("option").filter(function(index) {
                                    return END_Cidade === $(this).text();
                                }).attr("selected", "selected");
                            }
                        }
                    }else{
                        $("#hddFocus").val(objEnderecoCampos.campoCep);
                        $("#dialog-atencao").html("O CEP informado não foi encontrado.");        
                        $('#dialog-atencao').dialog('open');
                    }
                    objPreLoading.html("");
                });
            }
        }
    }		
}

function existeEspacosVazios(cep){
    var retorno = false;
    
    for(var i=0; i<cep.length; i++){
        if(cep[i] == "_"){
            retorno = true;
            break;
        }
    }
    
    return retorno;
}