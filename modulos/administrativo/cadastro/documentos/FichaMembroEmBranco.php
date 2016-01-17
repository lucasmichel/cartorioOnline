<?php 
    // codificação utf-8
    session_start();
    include("../../../../inc/config.inc.php");
    include("../../../sistema/gerencial/inc/seguranca.inc.php");
    include("../inc/autoload.inc.php");
    header('Content-Type: text/html; charset=utf-8', true);
?>
<html>
    <head>
        <title>Ficha do Membro</title>
        <link type="text/css" rel="stylesheet" href="../../../sistema/home/css/ficha.css"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="../../../../js/jquery.1.10.2.js"></script>
        <script type="text/javascript" src="../../../../js/jquery.utilitarios/jquery.print.js"></script>
        <script type="text/javascript" src="../../../sistema/home/js/sistema.js"></script>
    </head>
    <body>     
        <div id="containerFicha">
            <?php
                include("../../../sistema/gerencial/inc/executar-impressao.inc.php");
            ?>
            <div id="impressaoConteudo">
                
                <div id="cabecalho">
                    <h3>Ficha do Membro</h3>
                </div>
                
                <hr/>
                <div id="ficha">
                    <h3>Dados Pessoais</h3>
                    <table class="dadosFicha">                        
                        
                        <tr class="cabecalhoFicha">
                            <td colspan="5" >Nome</td>
                        </tr>
                        <tr>
                            <td colspan="5" >&nbsp;</td>                            
                        </tr>
                        
                        <tr class="cabecalhoFicha">                            
                            <td colspan="2" >CPF</td>
                            <td>RG</td>
                            <td>Órgão Exp.</td>
                            <td>Data Nasc.</td>                            
                        </tr>
                        <tr>
                            <td colspan="2" >&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        
                        <tr class="cabecalhoFicha">
                            <td colspan="2" >Sexo</td>
                            <td>Est. Civil</td> 
                            <td colspan="2" >Data Casamento</td>
                        </tr>
                        
                        <tr>
                            <td colspan="2" >(&nbsp;&nbsp;)Masculino &nbsp;&nbsp;(&nbsp;&nbsp;)Feminino</td>                            
                            <td>&nbsp;</td>                            
                            <td colspan="2" >&nbsp;</td>
                        </tr>
                        
                        <tr class="cabecalhoFicha">
                            <td>Naturalidade</td>
                            <td>Estado Nasc.</td>
                            <td>Nacionalidade</td>
                            <td>Nível de Escolaridade</td> 
                            <td>Formação</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr class="cabecalhoFicha">                            
                            <td colspan="3" >Pai</td>
                            <td colspan="2" >Mãe</td>
                        </tr>
                        <tr>
                            <td colspan="3" >&nbsp;</td>
                            <td colspan="2" >&nbsp;</td>
                        </tr>
                        
                        <tr class="cabecalhoFicha">                            
                            <td colspan="4" >Cônjuge</td>                            
                            <td >Quantidade de Filhos</td>                            
                        </tr>
                        <tr>
                            <td colspan="4" >&nbsp;</td>                            
                            <td >&nbsp;</td>                            
                        </tr>
                    </table>
                    
                    <h3>Contato</h3>                    
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td>Telefone(s)</td>
                            <td>E-mail(s)</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>                        
                    </table>

                    <h3>Endereço</h3>
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td>Logradouro</td>
                            <td>Complemento</td>
                            <td>Bairro</td>
                            <td>Cidade</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>                            
                            <td>&nbsp;</td>                            
                        </tr>
                        <tr class="cabecalhoFicha">
                            <td>Estado</td>
                            <td colspan="2">Ponto de Referência</td>
                            <td>Cep</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">&nbsp;</td>
                            <td>&nbsp;</td>                       
                        </tr>
                    </table>
                    
                    <h3>Dados Profissionais</h3>
                    <table class="dadosFicha">
                        <tr class="cabecalhoFicha">
                            <td>Nome da Empresa</td> 
                            <td>Telefone</td>
                            <td>Fax</td>
                            <td>Área de Atuação</td>
                            <td>Profissão</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td> 
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr class="cabecalhoFicha">
                            <td colspan="2">Endereço</td>                        
                            <td>Complemento</td>
                            <td>Bairro</td>                        
                            <td>Estado</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>                        
                            <td>&nbsp;</td>
                        </tr>
                        
                        <tr class="cabecalhoFicha">
                            <td >Cep</td>                        
                            <td colspan="3">Ponto de Referência</td>
                            <td>Possui Emprego?</td>
                        </tr>
                        
                        <tr>
                            <td>&nbsp;</td>                        
                            <td colspan="3">&nbsp;</td>
                            <td>(&nbsp;&nbsp;)Sim &nbsp;&nbsp;(&nbsp;&nbsp;)Não</td>
                        </tr>
                    </table>
                    
                    
                    
                    <?php
                        //include("../../../sistema/gerencial/inc/rodape-impressao.inc.php");
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
