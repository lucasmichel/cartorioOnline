<div id="divexport" style="margin-top: 10px;">   
    <form> 
        <fieldset class="linha">
            <fieldset class="coluna">
                <a href="javascript: void(0);" id="btnExportPrint"><img src="../../sistema/home/img/imprimir.png" width="24" height="24" border="0" alt="Imprimir" title="Imprimir" align="absmiddle" /></a>
            </fieldset>
            <fieldset class="coluna">
                <a href="javascript: void(0);" id="btnExportPdf"><img src="../../sistema/home/img/pdf.png" width="24" height="24" border="0" alt="Gerar PDF" title="Gerar PDF" align="absmiddle" /></a>
            </fieldset>
            <fieldset class="coluna" >
                <a href="javascript: void(0);" id="btnExportExcel"><img src="../../sistema/home/img/xls.png" width="24" height="24" border="0" alt="Gerar Excel" title="Gerar Excel" align="absmiddle"  /></a>
            </fieldset>
        </fieldset>
    </form>
    <iframe id="iframeExportPDF" src=""></iframe>
</div>

<script type="text/javascript">
    function exportExcel(tableID){
        $("#" + tableID).btechco_excelexport({
            containerid: tableID
           ,datatype: $datatype.Table
        });
    }

    function exportPdf(pdfNome, divID, orientacao){
        $.ajax({
            type: "POST",
            url: "../gerencial/controladores/PDFPreparacaoControlador.php",
            dataType: "json",
            async: false,
            data: {PDF_Nome: pdfNome, PDF_Cabecalho: getCabecalhoExport(), PDF_Conteudo: $("#" + divID).html(), PDF_Orientacao: orientacao}
        })
        .done(function( data ) {                
            //$("#iframeExportPDF").prop("src","../gerencial/controladores/PDFControlador.php?pdfID=" + data.pdfID);         
            novaJanelaFullscreen("../gerencial/controladores/PDFControlador.php?pdfID=" + data.pdfID);
        });
    }

    function exportImprimir(divID){   
        $('#' + divID).printThis();
    }
    
    function getCabecalhoExport(){
        var cabecalho = '';
        
        $.ajax({
            type: "POST",
            url: "../gerencial/controladores/ParametroControlador.php",
            //dataType: "json",
            async: false,
            data: {ACO_Descricao: "GerarCabecalho"}
        })
        .done(function( data ) {                
            /*cabecalho += '<h1 style="margin-bottom: 0px;">' + data.rows[0].PAR_RazaoSocial + '</h1>';
            cabecalho += '<p>';
                cabecalho += data.rows[0].PAR_EnderecoLogradouro + ", " + data.rows[0].PAR_EnderecoNumero;
                
                if($.trim(data.rows[0].PAR_EnderecoComplemento) != ""){
                    cabecalho += ", " + data.rows[0].PAR_EnderecoComplemento + "<br/>";
                }else{
                    cabecalho += "<br/>";
                }
                
                cabecalho += data.rows[0].PAR_EnderecoBairro + ", " + data.rows[0].PAR_EnderecoCidade + " - " + data.rows[0].PAR_EnderecoUf + " - Cep: " + data.rows[0].PAR_EnderecoCep + "<br/>";
                
                //if($.trim(data.rows[0].PAR_CNPJ) != ""){
                  //  cabecalho += "Cnpj: " + data.rows[0].PAR_CNPJ + "<br/>";
                //}
                if($.trim(data.rows[0].PAR_Telefone) != ""){
                    cabecalho += "Tel.: " + data.rows[0].PAR_Telefone;
                }
                
                if($.trim(data.rows[0].PAR_Fax) != ""){
                    cabecalho += " Fax: " + data.rows[0].PAR_Fax;
                }
            cabecalho += '</p>';*/
            cabecalho = data;
        });
        
        return cabecalho;
    }
</script>