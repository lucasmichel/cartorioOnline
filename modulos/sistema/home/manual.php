<?php
    // codificação UTF-8
    session_start();
    include("../../../inc/config.inc.php"); 
    include("inc/autoload.inc.php");     
    $strDir = "../../sistema/gerencial";     
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script type="text/javascript" src="js/sistema.js"></script> 
    <script type="text/javascript" src="js/modernizr.custom.29473.js"></script>
    
    <link type="text/css" rel="stylesheet" href="css/acordion/style.css"/>    
    
    
    <script type="text/javascript">        
            
            
            
            $(document).ready(function(){
                
                $('#dialog-atencao').dialog({
                    autoOpen: false,
                    buttons: {
                        "Ok": function() {                            
                            $(this).dialog("close"); 
                        }
                    }
                });
                
                /*
                $('article p').bind("contextmenu",function(e){          
                    $("#dialog-atencao").html("Proibida a reprodução deste conteúdo.");
                    $('#dialog-atencao').dialog('open');
                    return false;
                });
                
                $('label').bind("contextmenu",function(e){          
                    $("#dialog-atencao").html("Proibida a reprodução deste conteúdo.");
                    $('#dialog-atencao').dialog('open');
                    return false;
                });
                
                */
                
                
                
                $("article p").click(function(){
                    $('article p').disableSelection(); 
                    return false;
                });
                $('article p').disableSelection();
                
                
                $("label").click(function(){
                    $('label').disableSelection();                     
                });
                $('label').disableSelection();
                
            });
        </script>
    <style type="text/css">
<!--
p.MsoNormal {
margin-top:0cm;
margin-right:0cm;
margin-bottom:10.0pt;
margin-left:0cm;
text-align:justify;
text-indent:-7.1pt;
line-height:115%;
font-size:11.0pt;
font-family:"Calibri","sans-serif";
}
-->
</style>
    
    
    
</head>
<body>    
    <form onSubmit="return false;">
        <div id="dialogs">     
            <div id="dialog-sucesso" title="Sucesso"></div>
            <div id="dialog-atencao" title="Aten&ccedil;&atilde;o"></div> 
            <div id="dialog-excecao" title="Exce&ccedil;&atilde;o"></div>
        </div><!-- dialogs -->
        <div style="width: 950px; margin: auto;">
            
            <fieldset class="linha" style=" width: 950px!important; " >
                <h2 style="font-size: 18px!important;" >Manual do Sistema</h2>
                <section class="ac-container">
                        
                    
                    
       

                    
                                        
<div>
<input id="ac-144" name="accordion-1" type="checkbox" />
    <label for="ac-144">1. COMO ACESSAR IGREJA CONECTADA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O Sistema IGREJA  CONECTADA é um gerenciador integrado voltado às igrejas.  Acesse o site de sua igreja e no rodapé do  mesmo clique Acesso ao Sistema. De posse de seu login de usuário e senha,  digite-os em seus respectivos campos e clique em Acessar.</span></p>
    <span style="line-height:115%; font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="202" height="169" src="manual/clip_image002.jpg"></span>
    </article>
</div>

<div>
<input id="ac-145" name="accordion-1" type="checkbox" />
    <label for="ac-145">2. CONHECENDO A TELA INICIAL DO IGREJA CONECTADA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal">&nbsp;</p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="366" height="146" src="manual/clip_image002_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O IGREJA CONECTADA  foi desenvolvido para facilitar e dar mais praticidade e agilidade às  atividades diárias das igrejas e de seus usuários. Com um design moderno e  intuitivo, o IGREJA CONECTADA traz uma plataforma atual e segura, que inova nas  metodologias de trabalho, integrando todos os processos de sua igreja.</span></p>
    </article>
</div>




<div>
<input id="ac-146" name="accordion-1" type="checkbox" />
    <label for="ac-146">3. CONHECENDO OS ATALHOS DO IGREJA CONECTADA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal">&nbsp;</p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Os atalhos do IGREJA  CONECTADA encontram-se na parte superior direita da tela. </span></p>
<p class="MsoNormal" align="center" style="margin-left:21.3pt;text-align:center;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="127" height="37" src="manual/clip_image002_0001.jpg"></span></p>
<p class="MsoNormal" align="center" style="margin-left:21.3pt;text-align:center;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="margin-left:21.3pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="27" height="34" src="manual/clip_image004.jpg"> Este  atalho serve para iniciar o chat online com o nosso suporte;</span></p>
<p class="MsoNormal" style="margin-left:21.3pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="24" height="42" src="manual/clip_image006.jpg"> Este  atalho serve fazer o download do manual do usuário do Sistema;</span></p>
<p class="MsoNormal" style="margin-left:21.3pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="24" height="40" src="manual/clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> Este  atalho serve para voltar à tela inicial do IGREJA CONECTADA;</span></p>
<p class="MsoNormal" style="margin-left:21.3pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="24" height="39" src="manual/clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> Este  atalho serve para alterar sua senha de acesso;</span></p>
<p class="MsoNormal" style="margin-left:21.3pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="23" height="41" src="manual/clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> Este  atalho serve para sair do IGREJA CONECTADA.</span></p>
    </article>
</div>



<div>    
<input id="ac-147" name="accordion-1" type="checkbox" />
    <label for="ac-147">4. MÓDULO SISTEMA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O módulo de Sistema administra toda área gerencial  dos dados da própria igreja.</span><p>
    </article>
</div>







<div>
<input id="ac-148" name="accordion-1" type="checkbox" />
    <label for="ac-148">4.1. SUBMÓDULO GERENCIAL</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo  faremos de cadastros de usuários, permissões a outros módulos e aos parâmetros  do IGREJA CONECTADA. <strong>O primeiro passo a  ser feito é cadastrar os parâmetros de sua Igreja.</strong></span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><strong><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="104" height="115" src="manual/clip_image002_0002.jpg"></span></strong><strong><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></strong></p>
    </article>
</div>


<div>
<input id="ac-149" name="accordion-1" type="checkbox" />
    <label for="ac-149">4.1.1. COMO CADASTRAR OS PARÂMETROS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><img width="218" height="104" src="manual/clip_image002_1.jpg"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span><br clear="ALL">
</p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="95" height="31" src="manual/clip_image002_2.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo Gerencial </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="30" height="33" src="manual/clip_image002_3.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela de menu Gerencial.  Clique no menu </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="124" height="25" src="manual/clip_image002_4.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Nesse menu, iremos informar  todos os dados cadastrais da igreja. Preencha todos os dados e escolha uma  imagem (logomarca) e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="61" height="22" src="manual/clip_image002_5.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Todos esses dados, como: logomarca, endereços  e telefones irão constar nos relatórios gerenciais da igreja.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="498" height="252" src="manual/clip_image002_6.jpg"></span></p>
    </article>
</div>




<div>
<input id="ac-150" name="accordion-1" type="checkbox" />
    <label for="ac-150">4.1.2. MENU CADASTROS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos  cadastrar os usuários do IGREJA CONECTADA. Também iremos cadastrar as  informações que alimentarão os cadastros de usuários.</span></p>
    </article>
</div>



<div>    
<input id="ac-151" name="accordion-1" type="checkbox" />
    <label for="ac-151">4.1.2.1. COMO CADASTRAR UM GRUPO DE USUÁRIOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="95" height="31" src="manual/clip_image002_0003.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo Gerencial </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="30" height="33" src="manual/clip_image004_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela de menu Gerencial.  Passe o mouse em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="25" src="manual/clip_image006_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> e  depois clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="111" height="21" src="manual/clip_image008_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><img width="298" height="111" src="manual/clip_image0101.jpg"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela de visualização com os  registros que já foram cadastrados. Clique na aba </span><span style="line-height:115%; font-family:'Arial','sans-serif'; font-size:12.0pt; color:red; "><img width="84" height="21" src="manual/clip_image012_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; color:red; "> </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">digite o nome do grupo de usuário. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>







<div>
<input id="ac-152" name="accordion-1" type="checkbox" />
    <label for="ac-152">4.1.2.2. COMO ALTERAR UM GRUPO DE USUÁRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  registro de grupo de usuário, vá para a tela de grupos de usuários cadastrados, clique  no registro que deseja alterar e clique no botão </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="69" height="25" src="manual/COMO ALTERAR UM GRUPO DE USUARIO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/COMO ALTERAR UM GRUPO DE USUARIO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>


<div>
<input id="ac-153" name="accordion-1" type="checkbox" />
    <label for="ac-153">4.1.2.3. COMO CADASTRAR UM USUÁRIO DO IGREJA CONECTADA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="95" height="31" src="manual/4.1.2.3. COMO CADASTRAR UM USUARIO DO IGREJA CONECTADA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo Gerencial </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="30" height="33" src="manual/4.1.2.3. COMO CADASTRAR UM USUARIO DO IGREJA CONECTADA_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela de menu Gerencial.  Passe o mouse em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="25" src="manual/4.1.2.3. COMO CADASTRAR UM USUARIO DO IGREJA CONECTADA_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> e  depois clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="57" height="23" src="manual/4.1.2.3. COMO CADASTRAR UM USUARIO DO IGREJA CONECTADA_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><img width="349" height="156" src="manual/4.1.2.3. COMO CADASTRAR UM USUARIO DO IGREJA CONECTADA_clip_image010.jpg"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span><br clear="ALL">
</p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os registros que já foram cadastrados. Clique na aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="84" height="21" src="manual/4.1.2.3. COMO CADASTRAR UM USUARIO DO IGREJA CONECTADA_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Selecione o grupo de usuários que ele fará  parte. Digite o login de usuário. Digite a senha e repita a senha para  confirmar. Digite o email e o telefone do usuário. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/4.1.2.3. COMO CADASTRAR UM USUARIO DO IGREJA CONECTADA_clip_image016.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span><span class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><img width="150" height="256" src="manual/4.1.2.3. COMO CADASTRAR UM USUARIO DO IGREJA CONECTADA_clip_image012.jpg" align="left" hspace="12"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
    </article>
</div>




<div>
<input id="ac-154" name="accordion-1" type="checkbox" />
    <label for="ac-154">4.1.2.4. COMO ALTERAR UM USUÁRIO NO IGREJA CONECTADA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um registro  de um usuário, vá para a tela de usuários cadastrados, clique no registro que  deseja alterar e clique no botão </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="69" height="25" src="manual/4.1.2.4. COMO ALTERAR UM USUARIO NO IGREJA CONECTADA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> . Faça  as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/4.1.2.4. COMO ALTERAR UM USUARIO NO IGREJA CONECTADA_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>



<div>    
<input id="ac-155" name="accordion-1" type="checkbox" />
    <label for="ac-155">4.1.3. MENU PERMISSÕES DO SISTEMA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos dar  as permissões aos grupos de usuários anteriormente criados. Também podemos dar  permissões especificamente para usuários.</span></p>
    </article>
</div>







<div>
<input id="ac-156" name="accordion-1" type="checkbox" />
    <label for="ac-156">4.1.3.1. COMO DAR PERMISSÃO A UM GRUPO DE USUÁRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;">&nbsp;</p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="95" height="31" src="manual/4.1.3.1. COMO DAR PERMISSAO A UM GRUPO DE USUARIO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo Gerencial </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="30" height="33" src="manual/4.1.3.1. COMO DAR PERMISSAO A UM GRUPO DE USUARIO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela de menu Gerencial. Clique  em  </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="142" height="24" src="manual/4.1.3.1. COMO DAR PERMISSAO A UM GRUPO DE USUARIO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:21.3pt;line-height:normal;"><img width="215" height="114" src="manual/4.1.3.1. COMO DAR PERMISSAO A UM GRUPO DE USUARIO_clip_image008.jpg"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span><br clear="ALL">
</p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Na aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="116" height="24" src="manual/4.1.3.1. COMO DAR PERMISSAO A UM GRUPO DE USUARIO_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> selecione o grupo em que se deseja dar as  permissões. Marque as ações referentes aos módulos. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/4.1.3.1. COMO DAR PERMISSAO A UM GRUPO DE USUARIO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="465" height="274" src="manual/4.1.3.1. COMO DAR PERMISSAO A UM GRUPO DE USUARIO_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
    </article>
</div>


<div>
<input id="ac-157" name="accordion-1" type="checkbox" />
    <label for="ac-157">4.1.3.2. COMO ALTERAR PERMISSÃO AO GRUPO DE USUÁRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar uma  permissão, selecione qual grupo vai ser modificada a permissão e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/4.1.3.2. COMO ALTERAR PERMISSAO AO GRUPO DE USUARIO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/4.1.3.2. COMO ALTERAR PERMISSAO AO GRUPO DE USUARIO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>




<div>
<input id="ac-158" name="accordion-1" type="checkbox" />
    <label for="ac-158">4.1.3.3. COMO DAR PERMISSÃO A APENAS UM USUÁRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="95" height="31" src="manual/4.1.3.3. COMO DAR PERMISSAO A APENAS UM USUARIO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo Gerencial </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="30" height="33" src="manual/4.1.3.3. COMO DAR PERMISSAO A APENAS UM USUARIO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela de menu Gerencial.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="142" height="24" src="manual/4.1.3.3. COMO DAR PERMISSAO A APENAS UM USUARIO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:21.3pt;line-height:normal;"><img width="195" height="96" src="manual/4.1.3.3. COMO DAR PERMISSAO A APENAS UM USUARIO_clip_image008.jpg"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span><br clear="ALL">
</p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Na aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="111" height="19" src="manual/4.1.3.3. COMO DAR PERMISSAO A APENAS UM USUARIO_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> selecione o usuário em que se deseja dar as  permissões. Marque as ações referentes aos módulos. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/4.1.3.3. COMO DAR PERMISSAO A APENAS UM USUARIO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>



<div>    
<input id="ac-159" name="accordion-1" type="checkbox" />
    <label for="ac-159">4.1.3.4. COMO ALTERAR UMA PERMISSÃO PRA USUÁRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar uma  permissão, selecione qual usuário vai ser modificada a permissão e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/4.1.3.4. COMO ALTERAR UMA PERMISSAO PRA USUARIO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/4.1.3.4. COMO ALTERAR UMA PERMISSAO PRA USUARIO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>







<div>
<input id="ac-160" name="accordion-1" type="checkbox" />
    <label for="ac-160">4.1.4. MENU RELATÓRIOS DE GRUPOS E USUÁRIOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos  gerar os relatórios de usuários e grupos.</span></p>
    </article>
</div>


<div>
<input id="ac-161" name="accordion-1" type="checkbox" />
    <label for="ac-161">4.1.4.1. COMO GERAR UM RELATÓRIO DE  USUÁRIOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="95" height="31" src="manual/4.1.4.1. COMO GERAR UM RELATORIO DE USUARIOS E GRUPOS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo Gerencial </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="30" height="33" src="manual/4.1.4.1. COMO GERAR UM RELATORIO DE USUARIOS E GRUPOS_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela de menu Gerencial.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="75" height="21" src="manual/4.1.4.1. COMO GERAR UM RELATORIO DE USUARIOS E GRUPOS_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:21.3pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><img width="221" height="112" src="manual/4.1.4.1. COMO GERAR UM RELATORIO DE USUARIOS E GRUPOS_clip_image008.jpg"></p>
    </article>
</div>




<div>
<input id="ac-162" name="accordion-1" type="checkbox" />
    <label for="ac-162">5. MÓDULO ADMINISTRATIVO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste módulo, iremos  administrar de forma mais eficiente os membros da igreja, os bens e o  patrimônio.</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="434" height="94" src="manual/5. MODULO ADMINISTRATIVO_clip_image002.jpg"></span>
    </article>
</div>



<div>   
<input id="ac-163" name="accordion-1" type="checkbox" />
    <label for="ac-163">5.1. SUBMÓDULO AGENDA TELEFÔNICA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo de  Agenda Telefônica, o IGREJA CONECTADA trás automaticamente os números  telefônicos que foram informados no momento do cadastro do membro, funcionário  e fornecedor. Se selecionar a opção de membro, irá aparecer as opções de status  de membros (ativos, congregados, visitantes...)</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="484" height="224" src="manual/5.1. SUBMODULO AGENDA TELEFONICA_clip_image002.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
    </article>
</div>







<div>
<input id="ac-1000" name="accordion-1" type="checkbox" />
    <label for="ac-1000">5.2. SUBMÓDULO CADASTROS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Aqui iremos cadastrar  as congregações, funcionários, membros e ministérios.</span></p>
    </article>
</div>


<div>
<input id="ac-164" name="accordion-1" type="checkbox" />
    <label for="ac-164">5.2.1. MENU CADASTROS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo  iremos cadastrar as informações que alimentarão os cadastros de congregações,  funcionários, membros e ministérios.</span></p>
    </article>
</div>




<div>
<input id="ac-165" name="accordion-1" type="checkbox" />
    <label for="ac-165">5.2.1.1. COMO CADASTRAR UMA ÁREA  MINISTERIAL</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="95" height="32" src="manual/5.2.1.1. COMO CADASTRAR UMA AREA MINISTERIAL_clip_image002_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no  submódulo de Cadastros<img width="41" height="46" src="manual/5.2.1.1. COMO CADASTRAR UMA AREA MINISTERIAL_clip_image004_0000.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.2.1.1. COMO CADASTRAR UMA AREA MINISTERIAL_clip_image006_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="106" height="22" src="manual/5.2.1.1. COMO CADASTRAR UMA AREA MINISTERIAL_clip_image008_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="294" height="216" src="manual/5.2.1.1. COMO CADASTRAR UMA AREA MINISTERIAL_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as áreas ministeriais que já foram cadastradas. Clique na  aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.2.1.1. COMO CADASTRAR UMA AREA MINISTERIAL_clip_image012_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite a nova área ministerial. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.1. COMO CADASTRAR UMA AREA MINISTERIAL_clip_image014_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>



<div>    
<input id="ac-166" name="accordion-1" type="checkbox" />
    <label for="ac-166">5.2.1.2. COMO ALTERAR UMA ÁREA  MINISTERIAL</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar uma área  ministerial, selecione qual registro deverá sofrer a modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.2.1.2. COMO ALTERAR UMA AREA MINISTERIAL_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.2. COMO ALTERAR UMA AREA MINISTERIAL_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>







<div>
<input id="ac-167" name="accordion-1" type="checkbox" />
    <label for="ac-167">5.2.1.3. COMO CADASTRAR ATIVIDADES DO MEMBRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="95" height="32" src="manual/5.2.1.3. COMO CADASTRAR ATIVIDADES DO MEMBRO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no  submódulo de Cadastros<img width="41" height="46" src="manual/5.2.1.3. COMO CADASTRAR ATIVIDADES DO MEMBRO_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.2.1.3. COMO CADASTRAR ATIVIDADES DO MEMBRO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="136" height="24" src="manual/5.2.1.3. COMO CADASTRAR ATIVIDADES DO MEMBRO_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="289" height="156" src="manual/5.2.1.3. COMO CADASTRAR ATIVIDADES DO MEMBRO_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as atividades que já foram cadastradas. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.2.1.3. COMO CADASTRAR ATIVIDADES DO MEMBRO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite a nova atividade. Marque caso haja  exigência de data. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.3. COMO CADASTRAR ATIVIDADES DO MEMBRO_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="223" height="198" src="manual/5.2.1.3. COMO CADASTRAR ATIVIDADES DO MEMBRO_clip_image016.jpg"></span></p>
    </article>
</div>


<div>
<input id="ac-168" name="accordion-1" type="checkbox" />
    <label for="ac-168">5.2.1.4. COMO ALTERAR UMA ATIVIDADE DE MEMBRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar uma  atividade de membro, selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.2.1.4. COMO ALTERAR UMA ATIVIDADE DE MEMBRO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.4. COMO ALTERAR UMA ATIVIDADE DE MEMBRO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>




<div>
<input id="ac-169" name="accordion-1" type="checkbox" />
    <label for="ac-169">5.2.1.5. COMO CADASTRAR UMA ÁREA DE ATUAÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="93" height="31" src="manual/5.2.1.5. COMO CADASTRAR UMA AREA DE ATUACAO_clip_image002_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.1.5. COMO CADASTRAR UMA AREA DE ATUACAO_clip_image004_0000.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.2.1.5. COMO CADASTRAR UMA AREA DE ATUACAO_clip_image006_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> <img width="105" height="24" src="manual/5.2.1.5. COMO CADASTRAR UMA AREA DE ATUACAO_clip_image008_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:18.0pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="288" height="156" src="manual/5.2.1.5. COMO CADASTRAR UMA AREA DE ATUACAO_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="line-height:normal;">&nbsp;</p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os registros que já foram cadastrados. Clique na aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="84" height="21" src="manual/5.2.1.5. COMO CADASTRAR UMA AREA DE ATUACAO_clip_image012_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> digite  o nome da área de atuação na descrição </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="203" height="33" src="manual/5.2.1.5. COMO CADASTRAR UMA AREA DE ATUACAO_clip_image014_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.5. COMO CADASTRAR UMA AREA DE ATUACAO_clip_image016_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>



<div>    
<input id="ac-170" name="accordion-1" type="checkbox" />
    <label for="ac-170">5.2.1.6. COMO ALTERAR UMA ÁREA DE ATUAÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  registro de área de atuação, vá para a tela de área de atuações cadastradas,  clique na ação que deseja alterar e clique no botão </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="69" height="25" src="manual/5.2.1.6. COMO ALTERAR UMA AREA DE ATUACAO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.6. COMO ALTERAR UMA AREA DE ATUACAO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:21.3pt;line-height:normal;"><img width="459" height="215" src="manual/5.2.1.6. COMO ALTERAR UMA AREA DE ATUACAO_clip_image006.jpg"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:21.3pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:21.3pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:21.3pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
    </article>
</div>







<div>
<input id="ac-171" name="accordion-1" type="checkbox" />
    <label for="ac-171">5.2.1.7. COMO CADASTRAR UM ESTADO CIVIL</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.1.7. COMO CASDASTRAR UM ESTADO CIVIL_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="44" src="manual/5.2.1.7. COMO CASDASTRAR UM ESTADO CIVIL_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.2.1.7. COMO CASDASTRAR UM ESTADO CIVIL_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="83" height="23" src="manual/5.2.1.7. COMO CASDASTRAR UM ESTADO CIVIL_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:21.3pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="288" height="156" src="manual/5.2.1.7. COMO CASDASTRAR UM ESTADO CIVIL_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os estados civis que já foram cadastrados. Clique na aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="60" height="26" src="manual/5.2.1.7. COMO CASDASTRAR UM ESTADO CIVIL_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite o novo estado civil </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="184" height="32" src="manual/5.2.1.7. COMO CASDASTRAR UM ESTADO CIVIL_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Caso este estado civil possua um(a)  cônjuge, marque a opção. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.7. COMO CASDASTRAR UM ESTADO CIVIL_clip_image016.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<div align="center"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="218" height="160" src="manual/5.2.1.7. COMO CASDASTRAR UM ESTADO CIVIL_clip_image018.jpg"></span></div>
    </article>
</div>



<div>    
<input id="ac-172" name="accordion-1" type="checkbox" />
    <label for="ac-172">5.2.1.8. COMO ALTERAR UM ESTADO CIVIL</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:31.1pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  estado civil, selecione qual registro deverá sofrer a modificação. Faça as  devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.8. COMO ALTERAR UM ESTADO CIVIL_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>







<div>
<input id="ac-173" name="accordion-1" type="checkbox" />
    <label for="ac-173">5.2.1.9. COMO ALTERAR NÍVEL DE ESCOLARIDADE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  registro de um nível de escolaridade, vá para a tela de níveis de escolaridades  cadastrados, clique no registro que deseja alterar e clique no botão </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="69" height="25" src="manual/5.2.1.9. COMO ALTERAR NIVEL DE ESCOLARIDADE_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.9. COMO ALTERAR NIVEL DE ESCOLARIDADE_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>



<div>    
<input id="ac-174" name="accordion-1" type="checkbox" />
    <label for="ac-174">5.2.1.10. COMO CADASTRAR NÍVEL DE ESCOLARIDADE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.1.8. COMO CADASTRAR NIVEL DE ESCOLARIDADE_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.1.8. COMO CADASTRAR NIVEL DE ESCOLARIDADE_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.2.1.8. COMO CADASTRAR NIVEL DE ESCOLARIDADE_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="131" height="22" src="manual/5.2.1.8. COMO CADASTRAR NIVEL DE ESCOLARIDADE_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="289" height="156" src="manual/5.2.1.8. COMO CADASTRAR NIVEL DE ESCOLARIDADE_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os registros que já foram cadastrados. Clique na aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="84" height="21" src="manual/5.2.1.8. COMO CADASTRAR NIVEL DE ESCOLARIDADE_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> digite  o nome do nível de escolaridade. Caso possua alguma formação, assinale a opção.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.8. COMO CADASTRAR NIVEL DE ESCOLARIDADE_clip_image014.jpg">.</span></p>
<div align="center"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="253" height="180" src="manual/5.2.1.8. COMO CADASTRAR NIVEL DE ESCOLARIDADE_clip_image016.jpg"></span></div>
    </article>
</div>







<div>
<input id="ac-175" name="accordion-1" type="checkbox" />
    <label for="ac-175">5.2.1.11. COMO CADASTRAR UMA RENDA SALARIAL</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.1.10. COMO CADASTRAR UMA RENDA SALARIAL_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.1.10. COMO CADASTRAR UMA RENDA SALARIAL_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.2.1.10. COMO CADASTRAR UMA RENDA SALARIAL_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="95" height="25" src="manual/5.2.1.10. COMO CADASTRAR UMA RENDA SALARIAL_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="288" height="156" src="manual/5.2.1.10. COMO CADASTRAR UMA RENDA SALARIAL_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os registros que já foram cadastrados. Clique na aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="84" height="21" src="manual/5.2.1.10. COMO CADASTRAR UMA RENDA SALARIAL_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> digite  a informação referente a faixa de renda salarial. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.10. COMO CADASTRAR UMA RENDA SALARIAL_clip_image014.jpg">.</span></p>
    </article>
</div>



<div>    
<input id="ac-176" name="accordion-1" type="checkbox" />
    <label for="ac-176">5.2.1.12. COMO ALTERAR UMA RENDA SALARIAL </label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar uma  renda salarial, selecione qual registro deverá sofrer a modificação. Faça as  devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.12. COMO CADASTRAR UMA RENDA SALARIAL_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>







<div>
<input id="ac-177" name="accordion-1" type="checkbox" />
    <label for="ac-177">5.2.1.13. COMO CADASTRAR UM STATUS DE MEMBRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.1.13. COMO CADASTRAR UM STATUS DE MEMBRO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.1.13. COMO CADASTRAR UM STATUS DE MEMBRO_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.2.1.13. COMO CADASTRAR UM STATUS DE MEMBRO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="102" height="22" src="manual/5.2.1.13. COMO CADASTRAR UM STATUS DE MEMBRO_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="295" height="170" src="manual/5.2.1.13. COMO CADASTRAR UM STATUS DE MEMBRO_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os registros que já foram cadastrados. Clique na aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="84" height="21" src="manual/5.2.1.13. COMO CADASTRAR UM STATUS DE MEMBRO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> digite  o novo registro do status. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.13. COMO CADASTRAR UM STATUS DE MEMBRO_clip_image014.jpg">.</span></p>
    </article>
</div>



<div>    
<input id="ac-178" name="accordion-1" type="checkbox" />
    <label for="ac-178">5.2.1.14. COMO ALTERAR UM STATUS DE MEMBRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  status de membro, selecione qual registro deverá sofrer a modificação. Faça as  devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.1.14. COMO ALTERAR UM STATUS DE MEMBRO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>







<div>
<input id="ac-179" name="accordion-1" type="checkbox" />
    <label for="ac-179">5.2.2. MENU CONGREGAÇÕES</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos  gerenciar as congregações da igreja. Cadastraremos todas as congregações e seus  locais para complementar os cadastros dos membros e sua geolocalização.</span></p>
    </article>
</div>



<div>    
<input id="ac-180" name="accordion-1" type="checkbox" />
    <label for="ac-180">5.2.2.1. COMO CADASTRAR UMA CONGREGAÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.2.1. COMO CADASTRAR UMA CONGREGACAO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.2.1. COMO CADASTRAR UMA CONGREGACAO_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="92" height="30" src="manual/5.2.2.1. COMO CADASTRAR UMA CONGREGACAO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="203" height="158" src="manual/5.2.2.1. COMO CADASTRAR UMA CONGREGACAO_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as congregações que já foram cadastradas. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.2.2.1. COMO CADASTRAR UMA CONGREGACAO_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite o nome da congregação, telefone, fax  e responsável. Digite também o CEP para que o sistema traga o endereço. Digite  o número para completar o cadastro do endereço. Caso possua algum ponto de  referência, também informe. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.2.1. COMO CADASTRAR UMA CONGREGACAO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="363" height="239" src="manual/5.2.2.1. COMO CADASTRAR UMA CONGREGACAO_clip_image014.jpg"></span></p>
    </article>
</div>







<div>
<input id="ac-181" name="accordion-1" type="checkbox" />
    <label for="ac-181">5.2.2.2. COMO ALTERAR UMA CONGREGAÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar uma  congregação selecione qual registro deverá sofrer a modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.2.2.2. COMO ALTERAR UMA CONGREGACAO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.2.2. COMO ALTERAR UMA CONGREGACAO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>



<div>    
<input id="ac-182" name="accordion-1" type="checkbox" />
    <label for="ac-182">5.2.3. MENU FUNCIONÁRIO </label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos ter  todos os cadastros dos funcionários da igreja. É importante salientar que  membros também podem ser funcionários.</span></p>
    </article>
</div>






<div>    
<input id="ac-183" name="accordion-1" type="checkbox" />
    <label for="ac-183">5.2.3.1. COMO CADASTRAR UM FUNCIONÁRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.3.1. COMO CADASTRAR UM FUNCIONARIO_clip_image002_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.3.1. COMO CADASTRAR UM FUNCIONARIO_clip_image004_0000.jpg">. Você estará na tela gerencial de cadastros.  Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="80" height="22" src="manual/5.2.3.1. COMO CADASTRAR UM FUNCIONARIO_clip_image006_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="176" height="137" src="manual/5.2.3.1. COMO CADASTRAR UM FUNCIONARIO_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os funcionários que já foram cadastrados.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.2.3.1. COMO CADASTRAR UM FUNCIONARIO_clip_image010_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso este funcionário  seja um membro, marque a opção e selecione o membro. Isso fará com que o  cadastro dele em Membros sejam importados os dados e automaticamente  preenchidos. Apenas complete o cadastro com os dados que por ventura faltem  informar.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Se o funcionário não  for um membro, digite o nome do funcionário, data de nascimento, grupo  sanguíneo, e se é doador de sangue.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe os números  das documentações pessoais, como: CPF e RG.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione o sexo,  telefone fixo e celular. Digite o email principal e alternativo. Selecione o  estado civil e caso este funcionário tenha falecido, marque.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Digite também os  campos de filiação. Selecione uma foto para uma melhor identificação do  funcionário.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="409" height="190" src="manual/5.2.3.1. COMO CADASTRAR UM FUNCIONARIO_clip_image012_0000.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Agora passe para aba  de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="70" height="26" src="manual/5.2.3.1. COMO CADASTRAR UM FUNCIONARIO_clip_image014_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Digite também o CEP  para que o sistema traga o endereço. Digite o número para completar o cadastro  do endereço.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="432" height="159" src="manual/5.2.3.1. COMO CADASTRAR UM FUNCIONARIO_clip_image016_0000.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Vá para próxima aba  de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="135" height="25" src="manual/5.2.3.1. COMO CADASTRAR UM FUNCIONARIO_clip_image018_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe a Função  deste funcionário, o número de identificação da CTPS, número de registro da  CNH.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe também a data  de admissão, salário, carga horária semanal e o horário de entrada e saída.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="282" height="254" src="manual/5.2.3.1. COMO CADASTRAR UM FUNCIONARIO_clip_image020_0000.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">            Para finalizar, vá para a aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="51" height="20" src="manual/5.2.3.1. COMO CADASTRAR UM FUNCIONARIO_clip_image022_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Aqui iremos informar anotações que por ventura  seja relevante. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.3.1. COMO CADASTRAR UM FUNCIONARIO_clip_image024_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span>
    </article>
</div>






<div>    
<input id="ac-184" name="accordion-1" type="checkbox" />
    <label for="ac-184">5.2.3.2. COMO GERAR UMA FICHA DO FUNCIONÁRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para gerar uma ficha  cadastral do funcionário, selecione o funcionário e clique em <img width="113" height="25" src="manual/5.2.3.2. COMO GERAR UMA FICHA DO FUNCIONARIO_clip_image002.jpg">. Irá abrir uma nova janela com a ficha de  cadastro do funcionário selecionado.</span></p>
    </article>
</div>






<div>    
<input id="ac-185" name="accordion-1" type="checkbox" />
    <label for="ac-185">5.2.3.3. COMO ALTERAR UM FUNCIONÁRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  funcionário selecione qual registro deverá sofrer a modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.2.3.3. COMO ALTERAR UM FUNCIONARIO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.3.3. COMO ALTERAR UM FUNCIONARIO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>






<div>    
<input id="ac-186" name="accordion-1" type="checkbox" />
    <label for="ac-186">5.2.4. MENU MEMBRO </label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos  cadastrar todas as pessoas que participam da igreja. Membros, visitantes,  congregados, etc...</span></p>
    </article>
</div>






<div>    
<input id="ac-187" name="accordion-1" type="checkbox" />
    <label for="ac-187">5.2.4.1. COMO CADASTRAR UM MEMBRO </label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="66" height="22" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="182" height="142" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os membros que já foram cadastrados.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Escolha uma foto que  identifique este membro ou tire uma foto direto da webcam. <strong><em>IMPORTANTE</em></strong><em>: Em alguns computadores, é necessário dar  permissão de acesso à webcam.</em></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Digite o nome da pessoa, escolha o Tipo dessa pessoa (membro, visitante, congregado, etc...).</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe o CPF, RG,  órgão emissor, data de nascimento, sexo e o número de registro no livro de  cadastro.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione o estado  civil, grupo sanguíneo, e se é doador de sangue.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe também a  naturalidade, estado de nascimento, nacionalidade, nível de escolaridade,  formação acadêmica e sua filiação.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe seus contatos  através de telefone celular e fixo, a operadora e o nome no qual quer se  chamado e clique em <img width="82" height="27" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image012.jpg">. Em seguida informe seu email e também  clique em <img width="82" height="27" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image013.jpg">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="409" height="211" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image015.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Iremos para a segunda  aba: <img width="56" height="23" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image017.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">            Informe primeiramente a quantidade  de filhos. Em seguida informe o tipo de relacionamento (conjugue, filhos,  irmãos, pai e mãe). Se for membro, marque a opção e procure o nome na lista de  membros. Se não for membro, digite o nome da pessoa e clique em <img width="82" height="27" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image012_0000.jpg">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="566" height="137" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image019.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Agora iremos para a  terceira aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="68" height="25" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image021.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">            Digite também o CEP para que o  sistema traga o endereço. Digite o número para completar o cadastro do  endereço.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="566" height="186" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image023.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Iremos para a quarta  aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="133" height="23" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image025.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso esteja  empregado, marque a opção.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe o nome da  empresa em que o membro trabalha. Informe também o telefone comercial e fax.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione a área de  atuação e sua função. Informe também  sua faixa salarial.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Digite também o CEP  para que o sistema traga o endereço. Digite o número para completar o cadastro  do endereço.</span></p>
<p align="center" class="MsoNormal" style="text-align:center;text-indent:0cm;line-height:normal;"><img width="437" height="221" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image027.jpg" align="middle" hspace="12"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;">&nbsp;</p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;">&nbsp;</p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Avançamos para a quinta  aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="124" height="25" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image029.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">            Existem 04 opções de dados  eclesiásticos que podemos cadastrar para o membro. São eles: Aclamação,  Batismo, Reconciliação e transferência.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para cadastrar o  membro como aclamação, selecione o tipo Aclamação e informe a data de aclamação  e clique em <img width="70" height="24" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image031.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para informar o  batismo do membro, selecione o tipo Batismo e informe a data do batismo, data  do aceito, ano de batismo, igreja de batismo, pastor, cidade e UF. Clique em <img width="70" height="24" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image031_0000.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para informar a  reconciliação do membro, selecione o tipo Reconciliação, informe a data da  reconciliação e clique em <img width="70" height="24" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image031_0001.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para informar que o  membro veio de transferido de outra igreja, selecione o tipo Transferência,  informe a data de sessão, data aceito da carta, n° da ata, igreja, pastor,  cidade e UF. Clique em <img width="70" height="24" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image031_0002.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe a congregação  em que esta pessoa participa. Informe o Status desta pessoa.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="360" height="190" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image033.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Agora iremos  cadastrar sexta aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="127" height="23" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image035.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">            Caso este membro exerça alguma  atividade dentro da igreja, informe qual é e sua data de início e término. Caso  o membro ainda esteja exercendo, marque como atividade atual.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="566" height="98" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image037.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Agora iremos  cadastrar a sétima aba <img width="78" height="25" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image039.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione a Área  Ministerial e o Ministério que está atrelado nesta área. Informe a data de  início e a data de término de sua participação. Caso esta pessoa ainda participe  deste Ministério, marque a opção de Ministério Atual. Clique em <img width="70" height="24" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image040.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso o Ministério  ainda não esteja cadastrado, clique no <img width="16" height="24" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image042.jpg"> e  cadastre o Ministério sem ter que sair da tela.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image044.jpg" width="566" height="89" align="middle"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;">&nbsp;</p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Iremos cadastrar a oitava  aba <img width="118" height="27" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image046.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">            Se este membro está desligado da  igreja, informe a data de saída e o motivo.</span></p>
<p align="right" class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image048.jpg" width="566" height="102" align="middle"></span></p>
<p align="right" class="MsoNormal" style="text-indent:0cm;line-height:normal;">&nbsp;</p>
<p align="right" class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Agora iremos para a  última aba <img width="57" height="24" src="manual/5.2.4.1. COMO CADASTRAR UM MEMBRO_clip_image050.jpg"></span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Nesta aba iremos informar qualquer anotação que  seja relevante para o membro cadastrado.</span>
    </article>
</div>






<div>    
<input id="ac-188" name="accordion-1" type="checkbox" />
    <label for="ac-188">5.2.4.2. COMO ALTERAR UM MEMBRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  membro selecione qual registro deverá sofrer a modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.2.4.2. COMO ALTERAR UM MEMBRO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.4.2. COMO ALTERAR UM MEMBRO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>






<div>    
<input id="ac-189" name="accordion-1" type="checkbox" />
    <label for="ac-189">5.2.4.3. COMO GERAR UMA FICHA DO MEMBRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">            Para gerar uma ficha cadastral do  membro, selecione o membro e clique em <img width="113" height="25" src="manual/5.2.4.3. COMO GERAR UMA FICHA DO MEMBRO_clip_image002.jpg">. Irá abrir uma nova janela com a ficha de  cadastro do membro selecionado.</span></p>
    </article>
</div>






<div>    
<input id="ac-190" name="accordion-1" type="checkbox" />
    <label for="ac-190">5.2.4.4. COMO GERAR UM CERTIFICADO DE BATISMO DO  MEMBRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione o membro  batizado e clique em <img width="128" height="26" src="manual/5.2.4.4. COMO GERAR UM CERTIFICADO DE BATISMO DO MEMBRO_clip_image002.jpg">. Irá abrir uma nova janela com o certificado  para impressão.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="388" height="164" src="manual/5.2.4.4. COMO GERAR UM CERTIFICADO DE BATISMO DO MEMBRO_clip_image004.jpg"></span></p>
    </article>
</div>






<div>    
<input id="ac-191" name="accordion-1" type="checkbox" />
    <label for="ac-191">5.2.4.5. COMO GERAR UMA CARTEIRINHA DE MEMBRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">            Para gerar uma carteirinha de membro  da igreja, selecione o membro desejado e clique em <img width="83" height="25" src="manual/5.2.4.5. COMO GERAR UMA CARTEIRINHA DE MEMBRO_clip_image002.jpg">. Irá abrir uma nova janela com a carteirinha  para impressão.</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img src="manual/5.2.4.5. COMO GERAR UMA CARTEIRINHA DE MEMBRO_clip_image004.jpg" width="395" height="126" align="middle"></span>
    </article>
</div>




       
<div>    
<input id="ac-192" name="accordion-1" type="checkbox" />
    <label for="ac-192">5.2.5. MENU MINISTÉRIO </label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.5. MENU MINISTERIO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.5. MENU MINISTERIO_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="70" height="25" src="manual/5.2.5. MENU MINISTERIO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="203" height="158" src="manual/5.2.5. MENU MINISTERIO_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os ministérios que já foram cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.2.5. MENU MINISTERIO_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite o nome do Ministério. Selecione a  área ministerial a qual pertence. Selecione os dias e escolha os horários que  acontecerão as reuniões. Digite o CEP para que o sistema mostre o endereço de  onde serão feitas as reuniões. Digite o número para completar o cadastro do  endereço.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso queira fazer  alguma observação sobre este ministério, digite no campo de Anotações. Clique  em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.5. MENU MINISTERIO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img src="manual/5.2.5. MENU MINISTERIO_clip_image014.jpg" width="452" height="204" align="middle"></span></p>
    </article>
</div>




       
<div>   
<input id="ac-193" name="accordion-1" type="checkbox" />
    <label for="ac-193">5.2.5.1. COMO ALTERAR UM MINISTÉRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  ministério selecione qual registro deverá sofrer a modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.2.5.1. COMO ALTERAR UM MINISTERIO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.2.5.1. COMO ALTERAR UM MINISTERIO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>




       
<div>    
<input id="ac-194" name="accordion-1" type="checkbox" />
    <label for="ac-194">5.2.6. MENU RELATÓRIOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos ter  a possibilidade de gerar relatórios referente a congregações, funcionários e  membros</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img src="manual/5.2.6. MENU RELATORIOS_clip_image002_0001.jpg" width="174" height="255" align="middle"></span>
    </article>
</div>    

<div>
<input id="ac-1" name="accordion-1" type="checkbox" />
    <label for="ac-1">5.2.6.1. COMO GERAR UM RELATÓRIO DE CONGREGAÇÕES</label>
    <article class="ac-large" style="overflow: auto;">                                    
       <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.6.1. COMO GERAR UM RELATORIO DE CONGREGACOES_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.6.1. COMO GERAR UM RELATORIO DE CONGREGACOES_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de <img width="78" height="22" src="manual/5.2.6.1. COMO GERAR UM RELATORIO DE CONGREGACOES_clip_image006.jpg"> e  clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="85" height="20" src="manual/5.2.6.1. COMO GERAR UM RELATORIO DE CONGREGACOES_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione se quer as  congregações ativas ou inativas e clique em <img width="69" height="30" src="manual/5.2.6.1. COMO GERAR UM RELATORIO DE CONGREGACOES_clip_image010.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O relatório irá  aparecer na tela do sistema. Podemos gerar 03 opções (imprimir direto, PDF e  Excel).</span></p>
    </article>
</div>

<div>
<input id="ac-2" name="accordion-1" type="checkbox" />
    <label for="ac-2">5.2.6.2. COMO GERAR UM RELATÓRIO DE FUNCIONÁRIOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.6.2. COMO GERAR UM RELATORIO DE FUNCIONARIOS_clip_image002_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.6.2. COMO GERAR UM RELATORIO DE FUNCIONARIOS_clip_image004_0000.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de <img width="78" height="22" src="manual/5.2.6.2. COMO GERAR UM RELATORIO DE FUNCIONARIOS_clip_image006_0000.jpg"> e  clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="81" height="22" src="manual/5.2.6.2. COMO GERAR UM RELATORIO DE FUNCIONARIOS_clip_image008_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso queira um  relatório mais específico, selecione os filtros e clique em <img width="69" height="30" src="manual/5.2.6.2. COMO GERAR UM RELATORIO DE FUNCIONARIOS_clip_image010_0000.jpg">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="473" height="42" src="manual/5.2.6.2. COMO GERAR UM RELATORIO DE FUNCIONARIOS_clip_image012_0000.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;"><span style="line-height:115%; font-family:'Arial','sans-serif'; font-size:12.0pt; ">O relatório irá aparecer na  tela do sistema. Podemos gerar 03 opções (imprimir direto, PDF e Excel).</span></p>
    </article>
</div>

<div>
<input id="ac-3" name="accordion-1" type="checkbox" />
    <label for="ac-3">5.2.6.3. COMO GERAR UM RELATÓRIO DE MEMBRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.6.3. COMO GERAR UM RELATORIO DE MEMBRO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.6.3. COMO GERAR UM RELATORIO DE MEMBRO_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de <img width="78" height="22" src="manual/5.2.6.3. COMO GERAR UM RELATORIO DE MEMBRO_clip_image006.jpg"> e  clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="88" height="21" src="manual/5.2.6.3. COMO GERAR UM RELATORIO DE MEMBRO_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso queira um  relatório mais específico, selecione os filtros e clique em <img width="69" height="30" src="manual/5.2.6.3. COMO GERAR UM RELATORIO DE MEMBRO_clip_image010.jpg">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="566" height="31" src="manual/5.2.6.3. COMO GERAR UM RELATORIO DE MEMBRO_clip_image012.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O relatório irá  aparecer na tela do sistema. Podemos gerar 03 opções (imprimir direto, PDF e  Excel).</span></p>
    </article>
</div>

<div>
<input id="ac-4" name="accordion-1" type="checkbox" />
    <label for="ac-4">5.2.6.4. COMO GERAR UM RELATÓRIO DE MEMBROS ANIVERSARIANTES</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.6.4. COMO GERAR UM RELATORIO DE MEMBROS ANIVERSARIANTES_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.6.4. COMO GERAR UM RELATORIO DE MEMBROS ANIVERSARIANTES_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de <img width="78" height="22" src="manual/5.2.6.4. COMO GERAR UM RELATORIO DE MEMBROS ANIVERSARIANTES_clip_image006.jpg"> e  clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="143" height="24" src="manual/5.2.6.4. COMO GERAR UM RELATORIO DE MEMBROS ANIVERSARIANTES_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione o mês que  deseja saber os aniversariantes. Caso queira um relatório mais específico,  selecione os filtros e clique em <img width="69" height="30" src="manual/5.2.6.4. COMO GERAR UM RELATORIO DE MEMBROS ANIVERSARIANTES_clip_image010.jpg">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="459" height="49" src="manual/5.2.6.4. COMO GERAR UM RELATORIO DE MEMBROS ANIVERSARIANTES_clip_image012.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O relatório irá aparecer na  tela do sistema. Podemos gerar 03 opções (imprimir direto, PDF e Excel).</span></p>
    </article>
</div>    

<div>
<input id="ac-5" name="accordion-1" type="checkbox" />
    <label for="ac-5">5.2.6.5. COMO GERAR UM RELATÓRIO DE MEMBROS POR ESTADO CIVIL</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.6.5. COMO GERAR UM RELATORIO DE MEMBROS POR ESTADO CIVIL_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.6.5. COMO GERAR UM RELATORIO DE MEMBROS POR ESTADO CIVIL_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de <img width="78" height="22" src="manual/5.2.6.5. COMO GERAR UM RELATORIO DE MEMBROS POR ESTADO CIVIL_clip_image006.jpg"> e clique  em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="145" height="20" src="manual/5.2.6.5. COMO GERAR UM RELATORIO DE MEMBROS POR ESTADO CIVIL_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso queira um  relatório mais específico, selecione os filtros e clique em <img width="69" height="30" src="manual/5.2.6.5. COMO GERAR UM RELATORIO DE MEMBROS POR ESTADO CIVIL_clip_image010.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O relatório irá aparecer na  tela do sistema. Podemos gerar 03 opções (imprimir direto, PDF e Excel).</span></p>
    </article>
</div>   

<div>
<input id="ac-6" name="accordion-1" type="checkbox" />
    <label for="ac-6">5.2.6.6. COMO GERAR UM RELATÓRIO DE MEMBROS POR MINISTÉRIOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.6.6. COMO GERAR UM RELATORIO DE MEMBROS POR MINISTERIOS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.6.6. COMO GERAR UM RELATORIO DE MEMBROS POR MINISTERIOS_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de <img width="78" height="22" src="manual/5.2.6.6. COMO GERAR UM RELATORIO DE MEMBROS POR MINISTERIOS_clip_image006.jpg"> e  clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="145" height="20" src="manual/5.2.6.6. COMO GERAR UM RELATORIO DE MEMBROS POR MINISTERIOS_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso queira um  relatório mais específico, selecione os filtros e clique em <img width="69" height="30" src="manual/5.2.6.6. COMO GERAR UM RELATORIO DE MEMBROS POR MINISTERIOS_clip_image010.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O relatório irá aparecer na  tela do sistema. Podemos gerar 03 opções (imprimir direto, PDF e Excel).</span></p>
</body>
    </article>
</div>


<div>
<input id="ac-7" name="accordion-1" type="checkbox" />
    <label for="ac-7">5.2.6.7. COMO GERAR UM RELATÓRIO DE MEMBROS POR SEXO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.6.7. COMO GERAR UM RELATORIO DE MEMBROS POR SEXO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.6.7. COMO GERAR UM RELATORIO DE MEMBROS POR SEXO_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de <img width="78" height="22" src="manual/5.2.6.7. COMO GERAR UM RELATORIO DE MEMBROS POR SEXO_clip_image006.jpg"> e  clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="109" height="19" src="manual/5.2.6.7. COMO GERAR UM RELATORIO DE MEMBROS POR SEXO_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso queira um  relatório mais específico, selecione os filtros e clique em <img width="69" height="30" src="manual/5.2.6.7. COMO GERAR UM RELATORIO DE MEMBROS POR SEXO_clip_image010.jpg">.</span></p>
<p class="MsoNormal"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O relatório irá aparecer na tela do sistema. Podemos  gerar 03 opções (imprimir direto, PDF e Excel).</span></p>
    </article>
</div>    
    

<div>
<input id="ac-8" name="accordion-1" type="checkbox" />
    <label for="ac-8">5.2.6.8. COMO GERAR UM RELATÓRIO DE MINISTÉRIOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.2.6.8. COMO GERAR UM RELATORIO DE MINISTERIOS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros <img width="41" height="46" src="manual/5.2.6.8. COMO GERAR UM RELATORIO DE MINISTERIOS_clip_image004.jpg">. Você estará na tela gerencial de cadastros.  Passe o mouse em cima de <img width="78" height="22" src="manual/5.2.6.8. COMO GERAR UM RELATORIO DE MINISTERIOS_clip_image006.jpg"> e  clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="73" height="21" src="manual/5.2.6.8. COMO GERAR UM RELATORIO DE MINISTERIOS_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso queira um  relatório mais específico, selecione os filtros e clique em <img width="69" height="30" src="manual/5.2.6.8. COMO GERAR UM RELATORIO DE MINISTERIOS_clip_image010.jpg">.</span></p>
<p class="MsoNormal"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O relatório irá aparecer na tela do sistema. Podemos  gerar 03 opções (imprimir direto, PDF e Excel).</span></p>
    </article>
</div>


<div>
<input id="ac-9" name="accordion-1" type="checkbox" />
    <label for="ac-9">5.3. SUBMÓDULO CARTAS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo iremos  cadastrar os modelos de cartas que poderão ser remetidas aos membros,  funcionários e visitantes.</span></p>
    </article>
</div>


<div>
<input id="ac-10" name="accordion-1" type="checkbox" />
    <label for="ac-10">5.3.1. MENU CADASTRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Aqui neste menu iremos  cadastrar os modelos de cartas dos mais variados tipos.</span></p>
    </article>
</div>   


<div>
<input id="ac-11" name="accordion-1" type="checkbox" />
    <label for="ac-11">5.3.1.1. COMO CADASTRAR UM MODELO DE CARTA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.3.1.1. COMO CADASTRAR UM MODELO DE CARTA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no  submódulo de Cartas <img width="30" height="35" src="manual/5.3.1.1. COMO CADASTRAR UM MODELO DE CARTA_clip_image004.jpg">. Você estará na tela gerencial de Cartas.  Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="111" height="24" src="manual/5.3.1.1. COMO CADASTRAR UM MODELO DE CARTA_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="293" height="63" src="manual/5.3.1.1. COMO CADASTRAR UM MODELO DE CARTA_clip_image008.jpg"></span></p>
<p class="MsoNormal"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os modelos que já foram cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.3.1.1. COMO CADASTRAR UM MODELO DE CARTA_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite o nome do modelo da carta, informe  uma hashtag para identificar este modelo. Após isso, Digite o modelo da carta.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.3.1.1. COMO CADASTRAR UM MODELO DE CARTA_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
 </div>   



<div>
<input id="ac-12" name="accordion-1" type="checkbox" />
    <label for="ac-12">5.3.1.2. COMO ALTERAR UM MODELO DE CARTA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um tipo  de carta selecione qual registro deverá sofrer a modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.3.1.2. COMO ALTERAR UM MODELO DE CARTA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.3.1.2. COMO ALTERAR UM MODELO DE CARTA_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>   




<div>   
<input id="ac-13" name="accordion-1" type="checkbox" />
    <label for="ac-13">5.3.2. MENU CARTAS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">É neste menu que  iremos gerar as cartas para que sejam impressas ou enviadas por email.</span></p>
    </article>
</div>       



<div>   
<input id="ac-14" name="accordion-1" type="checkbox" />
    <label for="ac-14">5.3.2.1. COMO GERAR UMA CARTA</label>
    <article class="ac-large" style="overflow: auto;">                                    
       <p class="MsoNormal" style="text-indent:35.4pt;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.3.2.1. COMO GERAR UMA CARTA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no  submódulo de Cartas <img width="30" height="35" src="manual/5.3.2.1. COMO GERAR UMA CARTA_clip_image004.jpg">. Você estará na tela gerencial de Cartas.  Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="121" height="24" src="manual/5.3.2.1. COMO GERAR UMA CARTA_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="189" height="99" src="manual/5.3.2.1. COMO GERAR UMA CARTA_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as cartas que já foram geradas. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.3.2.1. COMO GERAR UMA CARTA_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Selecione o modelo de carta e depois  selecione pra quem será enviada. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.3.2.1. COMO GERAR UMA CARTA_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Após montar a carta,  clique em <img width="112" height="23" src="manual/5.3.2.1. COMO GERAR UMA CARTA_clip_image014.jpg"> para  imprimir a carta e seja entregue.</span></p>
    </article>
</div>       

<div>   
<input id="ac-15" name="accordion-1" type="checkbox" />
    <label for="ac-15">5.4. SUBMÓDULO FINANCEIRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:1.0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo  iremos gerenciar todas as receitas e despesas da Igreja.</span></p>
<p class="MsoNormal" style="text-indent:1.0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Assim que entrarmos  no financeiro, o IGREJA CONECTADA mostra um resumo dos pagamentos em abertos  das contas<span style="color:red; "> </span>a pagar e das contas a<span style="color:red; "> </span>receber. Dependendo da data de vencimento, o sistema  diz quantos dias está em atraso.</span></p>
<img width="567" height="148" src="manual/5.4. SUBMODULO FINANCEIRO_clip_image002.jpg" align="left" hspace="12">
    </article>
</div>       


<div>   
<input id="ac-16" name="accordion-1" type="checkbox" />
    <label for="ac-16">5.4.1. MENU CADASTROS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos cadastrar todas as informações  auxiliares que subsidiarão os demais menus. Iremos cadastrar bancos, centros de  custos, contas bancárias, formas de pagamentos, fornecedores e planos de  contas.</span></p>
    </article>
</div>       



<div>   
<input id="ac-17" name="accordion-1" type="checkbox" />
    <label for="ac-17">5.4.1.1. COMO CADASTRAR UM BANCO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.1.1. COMO CADASTRAR UM BANCO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.1.1. COMO CADASTRAR UM BANCO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.4.1.1. COMO CADASTRAR UM BANCO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="48" height="24" src="manual/5.4.1.1. COMO CADASTRAR UM BANCO_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="line-height:115%; font-family:'Arial','sans-serif'; font-size:12.0pt; "><img src="manual/5.4.1.1. COMO CADASTRAR UM BANCO_clip_image002_0000.jpg" width="328" height="157" align="middle"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span><br clear="ALL">
</p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os bancos que já foram cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.4.1.1. COMO CADASTRAR UM BANCO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite na Descrição o nome do banco e  Digite o código do Banco. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.1. COMO CADASTRAR UM BANCO_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="280" height="140" src="manual/5.4.1.1. COMO CADASTRAR UM BANCO_clip_image016.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
    </article>
</div>       
<div>   
<input id="ac-18" name="accordion-1" type="checkbox" />
    <label for="ac-18">5.4.1.2. COMO ALTERAR UM BANCO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um banco  selecione qual registro deverá sofrer a modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.4.1.2. COMO ALTERAR UM BANCO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.2. COMO ALTERAR UM BANCO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
 </div>      



<div>   
<input id="ac-19" name="accordion-1" type="checkbox" />
    <label for="ac-19">5.4.1.3. COMO CADASTRAR UM CENTRO DE CUSTO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.1.3. COMO CADASTRAR UM CENTRO DE CUSTO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.1.3. COMO CADASTRAR UM CENTRO DE CUSTO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.4.1.3. COMO CADASTRAR UM CENTRO DE CUSTO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="102" height="24" src="manual/5.4.1.3. COMO CADASTRAR UM CENTRO DE CUSTO_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="310" height="141" src="manual/5.4.1.3. COMO CADASTRAR UM CENTRO DE CUSTO_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os centros de custos que já foram cadastrados. Clique na  aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.4.1.3. COMO CADASTRAR UM CENTRO DE CUSTO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite na Descrição o nome do centro de  custo. Caso tenha alguma observação, digite no campo de Anotações. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.3. COMO CADASTRAR UM CENTRO DE CUSTO_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="374" height="173" src="manual/5.4.1.3. COMO CADASTRAR UM CENTRO DE CUSTO_clip_image016.jpg"></span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
    </article>
</div>       





<div>
        <input id="ac-20" name="accordion-1" type="checkbox" />
    <label for="ac-20">5.4.1.4. COMO ALTERAR UM CENTRO DE CUSTO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  centro de custo selecione qual registro deverá sofrer a modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.4.1.4. COMO ALTERAR UM CENTRO DE CUSTO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.4. COMO ALTERAR UM CENTRO DE CUSTO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
 </div>      



<div>   
<input id="ac-21" name="accordion-1" type="checkbox" />
    <label for="ac-21">5.4.1.5. COMO CADASTRAR CONTAS BANCÁRIAS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.1.5. COMO CADASTRAR CONTAS BANCARIAS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.1.5. COMO CADASTRAR CONTAS BANCARIAS_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.4.1.5. COMO CADASTRAR CONTAS BANCARIAS_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="104" height="21" src="manual/5.4.1.5. COMO CADASTRAR CONTAS BANCARIAS_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="310" height="141" src="manual/5.4.1.5. COMO CADASTRAR CONTAS BANCARIAS_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as contas bancárias que já foram cadastradas. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.4.1.5. COMO CADASTRAR CONTAS BANCARIAS_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite na Descrição alguma identificação  para a conta. Selecione o banco, agência, número da conta, data de abertura e o  saldo inicial da referida conta. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.5. COMO CADASTRAR CONTAS BANCARIAS_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="318" height="222" src="manual/5.4.1.5. COMO CADASTRAR CONTAS BANCARIAS_clip_image016.jpg"></span></p>
    </article>
</div>       

<div>   
<input id="ac-22" name="accordion-1" type="checkbox" />
    <label for="ac-22">5.4.1.6. COMO ALTERAR UMA CONTA BANCÁRIA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar uma  conta bancária selecione qual registro deverá sofrer a modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.4.1.6. COMO ALTERAR UMA CONTA BANCARIA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.6. COMO ALTERAR UMA CONTA BANCARIA_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>   


<div>   
<input id="ac-23" name="accordion-1" type="checkbox" />
    <label for="ac-23">5.4.1.7. COMO CADASTRAR UMA FORMA DE PAGAMENTOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.1.7. COMO CADASTRAR UMA FORMA DE PAGAMENTOS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.1.7. COMO CADASTRAR UMA FORMA DE PAGAMENTOS_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.4.1.7. COMO CADASTRAR UMA FORMA DE PAGAMENTOS_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="132" height="21" src="manual/5.4.1.7. COMO CADASTRAR UMA FORMA DE PAGAMENTOS_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="line-height:115%; font-family:'Arial','sans-serif'; font-size:12.0pt; "><img src="manual/5.4.1.7. COMO CADASTRAR UMA FORMA DE PAGAMENTOS_clip_image002_0000.jpg" width="310" height="141" align="absmiddle"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as formas de pagamentos que já foram cadastradas. Clique na  aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.4.1.7. COMO CADASTRAR UMA FORMA DE PAGAMENTOS_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite a Descrição para a forma de pagamento.  Se essa forma de pagamento oferece algum número de documento, exemplo: cheques  e depósitos, marque a opção que Exige o Número de Documento. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.7. COMO CADASTRAR UMA FORMA DE PAGAMENTOS_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="322" height="219" src="manual/5.4.1.7. COMO CADASTRAR UMA FORMA DE PAGAMENTOS_clip_image016.jpg"></span></p>
    </article>
</div>       



<div>   
<input id="ac-24" name="accordion-1" type="checkbox" />
    <label for="ac-24">5.4.1.8. COMO ALTERAR UMA FORMA DE PAGAMENTO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar uma  forma de pagamento selecione qual registro deverá sofrer a modificação e clique  em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.4.1.8. COMO ALTERAR UMA FORMA DE PAGAMENTO_clip_image002_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.8. COMO ALTERAR UMA FORMA DE PAGAMENTO_clip_image004_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;">&nbsp;</p>
    </article>
</div>       



<div>   
<input id="ac-25" name="accordion-1" type="checkbox" />
    <label for="ac-25">5.4.1.10. COMO CADASTRAR UM FORNECEDOR</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="89" height="23" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="268" height="148" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as formas de recebimentos que já foram cadastradas. Clique  na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Na primeira aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="93" height="26" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, Caso este fornecedor seja um membro, marque  a opção desejada e selecione o membro. Os outros campos serão preenchidos  automaticamente.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="231" height="263" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image016.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso não seja um  membro, informe o nome fantasia, razão social, inscrição estadual, CNPJ, email,  site e telefone.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="251" height="260" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image018.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Se for pessoa física,  informe o nome, RG, CPF, email, site e telefone.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="310" height="253" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image020.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Na segunda aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="71" height="26" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image022.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, informe o CEP para que o sistema traga o  endereço. Informe agora o número para completar o endereço.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="512" height="134" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image024.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Nesta última aba </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="92" height="25" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image026.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, informe data de fundação, ramo de atividade,  dados bancários. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image028.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="379" height="198" src="manual/5.4.1.9. COMO CADASTRAR UM FORNECEDOR_clip_image030.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
    </article>
</div>       



<div>   
<input id="ac-26" name="accordion-1" type="checkbox" />
    <label for="ac-26">5.4.1.10. COMO ALTERAR UM FORNECEDOR</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  cadastro de fornecedor selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.4.1.10. COMO ALTERAR UM FORNECEDOR_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.10. COMO ALTERAR UM FORNECEDOR_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>       




<div>   
<input id="ac-27" name="accordion-1" type="checkbox" />
    <label for="ac-27">5.4.1.11. COMO CADASTRAR UM LOTE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.1.11. COMO CADASTRAR UM LOTE_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.1.11. COMO CADASTRAR UM LOTE_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.4.1.11. COMO CADASTRAR UM LOTE_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="47" height="25" src="manual/5.4.1.11. COMO CADASTRAR UM LOTE_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="268" height="148" src="manual/5.4.1.11. COMO CADASTRAR UM LOTE_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os lotes que já foram cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.4.1.11. COMO CADASTRAR UM LOTE_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite na Descrição o nome do Lote e clique  em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.11. COMO CADASTRAR UM LOTE_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>       



<div>   
<input id="ac-28" name="accordion-1" type="checkbox" />
    <label for="ac-28">5.4.1.12. COMO ALTERAR UM LOTE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  cadastro de lote selecione qual registro deverá sofrer a modificação e clique  em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.4.1.12. COMO ALTERAR UM LOTE_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.12. COMO ALTERAR UM LOTE_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>       


<div>   
<input id="ac-30" name="accordion-1" type="checkbox" />
    <label for="ac-30">5.4.1.13. COMO CADASTRAR UM PLANO DE CONTA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.1.13. COMO CADASTRAR UM PLANO DE CONTA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.1.13. COMO CADASTRAR UM PLANO DE CONTA_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Passe o mouse em cima de </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="27" src="manual/5.4.1.13. COMO CADASTRAR UM PLANO DE CONTA_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="100" height="26" src="manual/5.4.1.13. COMO CADASTRAR UM PLANO DE CONTA_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="310" height="150" src="manual/5.4.1.13. COMO CADASTRAR UM PLANO DE CONTA_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com planos de contas que já foram cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.4.1.13. COMO CADASTRAR UM PLANO DE CONTA_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite na Descrição o nome do plano de  conta, informe o código contábil. Selecione se é uma conta de entrada ou saída.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione o Tipo  deste Plano de Conta. Se for um dos planos de contas principais, marque a opção  SINTÉTICO, denominada de Conta Pai. Caso seja um plano de conta que está dentro  da Conta Pai, selecione a opção ANALÍTICA , denominada de Conta  Filha e selecione a qual Conta Pai irá compor  o plano de contas. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.13. COMO CADASTRAR UM PLANO DE CONTA_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="189" height="272" src="manual/5.4.1.13. COMO CADASTRAR UM PLANO DE CONTA_clip_image016.jpg"></span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
    </article>
</div>       


<div>   
<input id="ac-31" name="accordion-1" type="checkbox" />
    <label for="ac-31">5.4.1.14. COMO ALTERAR UM PLANO DE CONTA </label>
    <article class="ac-large" style="overflow: auto;">                                    
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um plano  de conta selecione qual registro deverá sofrer a modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.4.1.14. COMO ALTERAR UM PLANO DE CONTA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.1.14. COMO ALTERAR UM PLANO DE CONTA_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>      



<div>   
<input id="ac-32" name="accordion-1" type="checkbox" />
    <label for="ac-32">5.4.2. MENU CONTAS A PAGAR/RECEBER</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos  registrar todas as contas da igreja. Tanto de pagamento e recebimento.</span></p>
    </article>
</div>      



<div>   
<input id="ac-33" name="accordion-1" type="checkbox" />
    <label for="ac-33">COMO REGISTRAR UMA CONTA A PAGAR/RECEBER</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.2.1. COMO REGISTRAR UMA CONTA A PAGAR E RECEBER_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.2.1. COMO REGISTRAR UMA CONTA A PAGAR E RECEBER_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="137" height="23" src="manual/5.4.2.1. COMO REGISTRAR UMA CONTA A PAGAR E RECEBER_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="192" height="130" src="manual/5.4.2.1. COMO REGISTRAR UMA CONTA A PAGAR E RECEBER_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as contas que já foram cadastradas. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.4.2.1. COMO REGISTRAR UMA CONTA A PAGAR E RECEBER_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Selecione se é uma Conta a Pagar ou a  Receber.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Se for uma conta a  pagar, informe o valor, número do documento (contrato), histórico, selecione o  plano de conta no qual faz parte, o centro de custo e o fornecedor.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe a quantidade  de parcelas e clique em <img width="102" height="28" src="manual/5.4.2.1. COMO REGISTRAR UMA CONTA A PAGAR E RECEBER_clip_image012.jpg">, informe o número inicial da parcela.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="203" height="143" src="manual/5.4.2.1. COMO REGISTRAR UMA CONTA A PAGAR E RECEBER_clip_image014.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso queira digitalizar  a conta ou fatura, temos dois campos para salvar imagens. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.2.1. COMO REGISTRAR UMA CONTA A PAGAR E RECEBER_clip_image016.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Se for uma conta a  receber, faça o mesmo procedimento, mas ao invés de selecionar um fornecedor,  iremos informar o membro no qual a igreja está recebendo dele.</span></p>
    </article>
</div>       


<div>   
<input id="ac-34" name="accordion-1" type="checkbox" />
    <label for="ac-34">5.4.2.2. COMO ALTERAR UMA CONTA A PAGAR/RECEBER</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar uma  conta a pagar/receber selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.4.2.2. COMO ALTERAR UMA CONTA A PAGAR E RECEBER_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.2.2. COMO ALTERAR UMA CONTA A PAGAR E RECEBER_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>       




<div>   
<input id="ac-35" name="accordion-1" type="checkbox" />
    <label for="ac-35">5.4.2.3. COMO DAR BAIXA DAS PARCELAS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Após o cadastramento  da conta a pagar/receber, no momento em que a transação for efetuada temos que  dar baixa das parcelas. Assim iremos informar ao sistema que entrou ou saiu  dinheiro da conta.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Na tela inicial de  Contas a Pagar/Receber, selecione a conta que iremos dar baixa da parcela e  clique em <img width="137" height="27" src="manual/5.4.2.3. COMO DAR BAIXA DAS PARCELAS_clip_image002.jpg">. Selecione a parcela que iremos dar baixa e  clique em <img width="28" height="34" src="manual/5.4.2.3. COMO DAR BAIXA DAS PARCELAS_clip_image004.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">            Preencha os campos de juros, mora,  multa, descontos. Selecione a data de vencimento, qual referência faz (mês).  Informe a forma de pagamento, data de pagamento e qual conta debitar ou  creditar (vai depender se é uma conta a pagar ou receber, respectivamente).  Clique em <img width="57" height="25" src="manual/5.4.2.3. COMO DAR BAIXA DAS PARCELAS_clip_image006.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Se já foram pagas  todas as parcelas desta conta, esse registro irá sair do status de Em Aberto e  passará para o status de Pago.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="360" height="254" src="manual/5.4.2.3. COMO DAR BAIXA DAS PARCELAS_clip_image008.jpg"></span></p>
    </article>
</div>       



<div>   
<input id="ac-36" name="accordion-1" type="checkbox" />
    <label for="ac-36">5.4.3. MENU CONTRIBUIÇÕES </label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos  registrar todos os dízimos, ofertas e outras contribuições que a Igreja recebe.</span></p>
    </article>
</div>       

<div>   
<input id="ac-37" name="accordion-1" type="checkbox" />
    <label for="ac-37">5.4.3.1. COMO REGISTRAR UMA CONTRIBUIÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.3.1. COMO REGISTRAR UMA CONTRIBUICAO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.3.1. COMO REGISTRAR UMA CONTRIBUICAO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="94" height="23" src="manual/5.4.3.1. COMO REGISTRAR UMA CONTRIBUICAO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="206" height="137" src="manual/5.4.3.1. COMO REGISTRAR UMA CONTRIBUICAO_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as contribuições que já foram cadastradas. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.4.3.1. COMO REGISTRAR UMA CONTRIBUICAO_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe a data de  recebimento, a referência (mês), o valor recebido. Selecione o plano de conta  (dízimo, ofertas).</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe a conta  caixa, centro de custo e se a pessoa quiser se identificar. Informe a forma de  pagamento.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Caso tenha alguma  observação relevante, informe no campo Anotações. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.3.1. COMO REGISTRAR UMA CONTRIBUICAO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="435" height="269" src="manual/5.4.3.1. COMO REGISTRAR UMA CONTRIBUICAO_clip_image014.jpg"></span></p>
    </article>
</div>      


<div>   
<input id="ac-38" name="accordion-1" type="checkbox" />
    <label for="ac-38">5.4.3.2. COMO ALTERAR UMA CONTRIBUIÇÃO </label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  registro de contribuição selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.4.3.2. COMO ALTERAR UMA CONTRIBUICAO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.3.2. COMO ALTERAR UMA CONTRIBUICAO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>       



<div>   
<input id="ac-39" name="accordion-1" type="checkbox" />
    <label for="ac-39">5.4.4. MENU FLUXO DE CAIXA </label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos registrar  toda a movimentação financeira dos caixas da igreja.</span></p>
    </article>
</div>   







<div>   
<input id="ac-40" name="accordion-1" type="checkbox" />
    <label for="ac-40">5.4.4.1. COMO REGISTRAR UM FLUXO DE CAIXA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.4.1. COMO REGISTRAR UM FLUXO DE CAIXA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.4.1. COMO REGISTRAR UM FLUXO DE CAIXA_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Clique em</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="86" height="24" src="manual/5.4.4.1. COMO REGISTRAR UM FLUXO DE CAIXA_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="195" height="140" src="manual/5.4.4.1. COMO REGISTRAR UM FLUXO DE CAIXA_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os fluxos de caixas que já foram registrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.4.4.1. COMO REGISTRAR UM FLUXO DE CAIXA_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">            Selecione se é uma entrada ou saída,  informe a data da transação, a referência (mês), valor e o plano de contas.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe a conta que  está entrando ou saindo o recurso. Informe o centro de custo.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Se for entrada,  selecione a origem. Se for saída, selecione o destino. Informe a forma de  pagamento. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.4.1. COMO REGISTRAR UM FLUXO DE CAIXA_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="395" height="322" src="manual/5.4.4.1. COMO REGISTRAR UM FLUXO DE CAIXA_clip_image014.jpg"></span></p>
    </article>
</div>       



<div>   
<input id="ac-41" name="accordion-1" type="checkbox" />
    <label for="ac-41">5.4.4.2. COMO ALTERAR UM FLUXO DE CAIXA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  registro de um fluxo de caixa selecione qual registro deverá sofrer a  modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.4.4.2. COMO ALTERAR UM FLUXO DE CAIXA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.4.2. COMO ALTERAR UM FLUXO DE CAIXA_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>










    

<div>   
<input id="ac-42" name="accordion-1" type="checkbox" />
    <label for="ac-42">5.4.5. MENU RELATÓRIOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos  gerar relatórios de acumulados por centros de custos, planos de contas, balancetes  financeiros e fornecedores.</span></p>
    </article>
</div>       



<div>   
<input id="ac-43" name="accordion-1" type="checkbox" />
    <label for="ac-43">5.4.5.1. COMO GERAR UM RELATÓRIO DE CENTRO DE CUSTO ACUMULADO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.5.1. COMO GERAR UM RELATORIO DE CENTRO DE CUSTO ACUMULADO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.5.1. COMO GERAR UM RELATORIO DE CENTRO DE CUSTO ACUMULADO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Passe o mouse em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="26" src="manual/5.4.5.1. COMO GERAR UM RELATORIO DE CENTRO DE CUSTO ACUMULADO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="132" height="30" src="manual/5.4.5.1. COMO GERAR UM RELATORIO DE CENTRO DE CUSTO ACUMULADO_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img src="manual/5.4.5.1. COMO GERAR UM RELATORIO DE CENTRO DE CUSTO ACUMULADO_clip_image010.jpg" width="264" height="181" align="middle"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione o período  no qual deseja este relatório e escolha qual Centro de Custo ou todos e clique  em <img width="69" height="30" src="manual/5.4.5.1. COMO GERAR UM RELATORIO DE CENTRO DE CUSTO ACUMULADO_clip_image012.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O relatório irá aparecer na  tela do sistema. Podemos gerar 03 opções (imprimir direto, PDF e Excel).</span></p>
    </article>
</div>       










    

<div>   
<input id="ac-44" name="accordion-1" type="checkbox" />
    <label for="ac-44">5.4.5.2. COMO GERAR UM RELATÓRIO ANALÍTICO DE PLANO DE CONTAS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.5.2. COMO GERAR UM RELATORIO ANALITICO DE PLANO DE CONTAS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.5.2. COMO GERAR UM RELATORIO ANALITICO DE PLANO DE CONTAS_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Passe o mouse em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="26" src="manual/5.4.5.2. COMO GERAR UM RELATORIO ANALITICO DE PLANO DE CONTAS_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="126" height="31" src="manual/5.4.5.2. COMO GERAR UM RELATORIO ANALITICO DE PLANO DE CONTAS_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="264" height="181" src="manual/5.4.5.2. COMO GERAR UM RELATORIO ANALITICO DE PLANO DE CONTAS_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione o período  no qual deseja este relatório e escolha qual plano de contas ou todos e clique  em <img width="69" height="30" src="manual/5.4.5.2. COMO GERAR UM RELATORIO ANALITICO DE PLANO DE CONTAS_clip_image012.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O relatório irá aparecer na  tela do sistema. Podemos gerar 03 opções (imprimir direto, PDF e Excel).</span></p>
    </article>
</div>       



<div>   
<input id="ac-45" name="accordion-1" type="checkbox" />
    <label for="ac-45">5.4.5.3. COMO GERAR UM BALANCETE FINANCEIRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.5.3. COMO GERAR UM BALANCETE FINANCEIRO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.5.3. COMO GERAR UM BALANCETE FINANCEIRO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Passe o mouse em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="26" src="manual/5.4.5.3. COMO GERAR UM BALANCETE FINANCEIRO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="123" height="20" src="manual/5.4.5.3. COMO GERAR UM BALANCETE FINANCEIRO_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="259" height="181" src="manual/5.4.5.3. COMO GERAR UM BALANCETE FINANCEIRO_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione o mês no  qual deseja este relatório e clique em <img width="69" height="30" src="manual/5.4.5.3. COMO GERAR UM BALANCETE FINANCEIRO_clip_image012.jpg">.</span></p>
<p class="MsoNormal"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O relatório irá aparecer na tela do sistema. Podemos  gerar 03 opções (imprimir direto, PDF e Excel).</span></p>
    </article>
</div>       










    

<div>   
<input id="ac-46" name="accordion-1" type="checkbox" />
    <label for="ac-46">5.4.5.5. COMO GERAR UM RELATÓRIO DE FORNECEDORES</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.5.4. COMO GERAR UM RELATORIO DE FORNECEDORES_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.5.4. COMO GERAR UM RELATORIO DE FORNECEDORES_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Financeiro.  Passe o mouse em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="26" src="manual/5.4.5.4. COMO GERAR UM RELATORIO DE FORNECEDORES_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="83" height="22" src="manual/5.4.5.4. COMO GERAR UM RELATORIO DE FORNECEDORES_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="267" height="190" src="manual/5.4.5.4. COMO GERAR UM RELATORIO DE FORNECEDORES_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Podemos filtrar por  pessoa jurídica, pessoa física e todos. Clique em <img width="69" height="30" src="manual/5.4.5.4. COMO GERAR UM RELATORIO DE FORNECEDORES_clip_image012.jpg">.</span></p>
<p class="MsoNormal"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O relatório irá aparecer na tela do sistema. Podemos gerar  03 opções (imprimir direto, PDF e Excel).</span></p>
    </article>
</div>       



<div>   
<input id="ac-47" name="accordion-1" type="checkbox" />
    <label for="ac-47">5.4.6. MENU TRANFERÊNCIAS ENTRE CONTAS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu podemos efetuar  transferências de valores entre as contas da igreja.</span></p>
    </article>
</div>       





<div>   
<input id="ac-48" name="accordion-1" type="checkbox" />
    <label for="ac-48">5.4.6.1. COMO EFETUAR UMA TRANSFERÊNCIA ENTRE CONTAS DA IGREJA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.4.6.1. COMO EFETUAR UMA TRANSFERENCIA ENTRE CONTAS DA IGREJA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo  de Financeiro </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="40" height="46" src="manual/5.4.6.1. COMO EFETUAR UMA TRANSFERENCIA ENTRE CONTAS DA IGREJA_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela  gerencial do Financeiro. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="121" height="33" src="manual/5.4.6.1. COMO EFETUAR UMA TRANSFERENCIA ENTRE CONTAS DA IGREJA_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;"><img width="197" height="165" src="manual/5.4.6.1. COMO EFETUAR UMA TRANSFERENCIA ENTRE CONTAS DA IGREJA_clip_image008.jpg"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os registros de transferências já efetuados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.4.6.1. COMO EFETUAR UMA TRANSFERENCIA ENTRE CONTAS DA IGREJA_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">            Selecione a conta de origem (de onde  o dinheiro irá sair) e também selecione a conta de destino (para onde o  dinheiro será transferido). Informe o valor e a data da transferência. Clique  em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.4.6.1. COMO EFETUAR UMA TRANSFERENCIA ENTRE CONTAS DA IGREJA_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;"><img width="247" height="211" src="manual/5.4.6.1. COMO EFETUAR UMA TRANSFERENCIA ENTRE CONTAS DA IGREJA_clip_image014.jpg"></p>
    </article>
</div>       



<div>   
<input id="ac-49" name="accordion-1" type="checkbox" />
    <label for="ac-49">5.5. SUBMÓDULO PATRIMÔNIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo  iremos gerenciar todos os bens patrimoniais móveis ou imóveis.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Assim que entrarmos  no submódulo, o IGREJA CONECTADA mostra um resumo dos bens com os número de  quantidade e qualidade dos bens.</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="444" height="223" src="manual/5.5. SUBMODULO PATRIMONIO_clip_image002.jpg"></span>
    </article>
</div>










    

<div>
<input id="ac-50" name="accordion-1" type="checkbox" />
    <label for="ac-50">5.5.1. MENU CADASTROS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos  cadastrar as informações auxiliares que subsidiarão os cadastros dos bens  patrimoniais.</span></p>
    </article>
</div>    



<div>
<input id="ac-51" name="accordion-1" type="checkbox" />
    <label for="ac-51">5.5.1.1. COMO CADASTRAR UMA FORMA DE AQUISIÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.5.1.1. COMO CADASTRAR UMA FORMA DE AQUISICAO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Patrimônio</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="35" height="38" src="manual/5.5.1.1. COMO CADASTRAR UMA FORMA DE AQUISICAO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Patrimônio.  Passe o mouse em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="21" src="manual/5.5.1.1. COMO CADASTRAR UMA FORMA DE AQUISICAO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="124" height="22" src="manual/5.5.1.1. COMO CADASTRAR UMA FORMA DE AQUISICAO_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="360" height="94" src="manual/5.5.1.1. COMO CADASTRAR UMA FORMA DE AQUISICAO_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as formas de aquisição que já foram cadastradas. Clique na  aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.5.1.1. COMO CADASTRAR UMA FORMA DE AQUISICAO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Digite no campo  Descrição o nome da forma de aquisição. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="28" src="manual/5.5.1.1. COMO CADASTRAR UMA FORMA DE AQUISICAO_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><img width="279" height="116" src="manual/5.5.1.1. COMO CADASTRAR UMA FORMA DE AQUISICAO_clip_image016.jpg" align="left" hspace="12"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
    </article>    
</div>









    

<div>
<input id="ac-52" name="accordion-1" type="checkbox" />
    <label for="ac-52">5.5.1.2. COMO ALTERAR UMA FORMA DE AQUISIÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  registro de uma forma de aquisição selecione qual registro deverá sofrer a  modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.5.1.2. COMO ALTERAR UMA FORMA DE AQUISICAO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.5.1.2. COMO ALTERAR UMA FORMA DE AQUISICAO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
    </div>



<div>
<input id="ac-53" name="accordion-1" type="checkbox" />
    <label for="ac-53">5.5.1.4. COMO CADASTRAR UM GRUPO DE BENS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.5.1.3. COMO CADASTRAR UM GRUPO DE BENS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Patrimônio</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> <img width="35" height="38" src="manual/5.5.1.3. COMO CADASTRAR UM GRUPO DE BENS_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Patrimônio.  Passe o mouse em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="21" src="manual/5.5.1.3. COMO CADASTRAR UM GRUPO DE BENS_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="95" height="24" src="manual/5.5.1.3. COMO CADASTRAR UM GRUPO DE BENS_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="329" height="89" src="manual/5.5.1.3. COMO CADASTRAR UM GRUPO DE BENS_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os grupos de bens que já foram cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.5.1.3. COMO CADASTRAR UM GRUPO DE BENS_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Digite no campo  Descrição o nome do grupo de bem. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="28" src="manual/5.5.1.3. COMO CADASTRAR UM GRUPO DE BENS_clip_image016.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span><span class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><img width="279" height="116" src="manual/5.5.1.3. COMO CADASTRAR UM GRUPO DE BENS_clip_image014.jpg" align="left" hspace="12"></span></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
    </article>
</div>    



   

<div>
<input id="ac-54" name="accordion-1" type="checkbox" />
    <label for="ac-54">5.5.1.4. COMO ALTERAR UM GRUPO DE BENS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  registro de um grupo de bens selecione qual registro deverá sofrer a  modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.5.1.4. COMO ALTERAR UM GRUPO DE BENS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.5.1.4. COMO ALTERAR UM GRUPO DE BENS_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
 </div>   



<div>
<input id="ac-55" name="accordion-1" type="checkbox" />
    <label for="ac-55">5.5.1.5. COMO CADASTRAR UM SUBGRUPO DE BENS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="343" height="102" src="manual/5.5.1.5. COMO CADASTRAR UM SUBGRUPO DE BENS_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os subgrupos de bens que já foram cadastrados. Clique na  aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.5.1.5. COMO CADASTRAR UM SUBGRUPO DE BENS_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione o grupo de  bens, caso o grupo de bens não esteja cadastrado, clique em <img width="18" height="20" src="manual/5.5.1.5. COMO CADASTRAR UM SUBGRUPO DE BENS_clip_image014.jpg"> para  cadastrar sem ter que sair da tela. Digite no campo Descrição o nome do  subgrupo de bem e informe o percentual de depreciação. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="28" src="manual/5.5.1.5. COMO CADASTRAR UM SUBGRUPO DE BENS_clip_image016.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="418" height="166" src="manual/5.5.1.5. COMO CADASTRAR UM SUBGRUPO DE BENS_clip_image018.jpg"></span></p>
    </article>
</div>    





   

<div>
<input id="ac-56" name="accordion-1" type="checkbox" />
    <label for="ac-56">5.5.1.6. COMO ALTERAR UM SUBGRUPO DE BENS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  registro de um subgrupo de bens selecione qual registro deverá sofrer a  modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.5.1.6. COMO ALTERAR UM SUBGRUPO DE BENS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.5.1.6. COMO ALTERAR UM SUBGRUPO DE BENS_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-57" name="accordion-1" type="checkbox" />
    <label for="ac-57">5.5.2. MENU PATRIMÔNIOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos de  fato cadastrar todos os bens patrimoniais.</span></p>
    </article>
</div>   



    

<div>
<input id="ac-58" name="accordion-1" type="checkbox" />
    <label for="ac-58">5.5.2.1. COMO CADASTRAR UM BEM PATRIMONIAL</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.5.3. COMO CADASTRAR UM BEM PATRIMONIAL_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Patrimônio</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> <img width="35" height="38" src="manual/5.5.3. COMO CADASTRAR UM BEM PATRIMONIAL_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Patrimônio.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="80" height="22" src="manual/5.5.3. COMO CADASTRAR UM BEM PATRIMONIAL_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="214" height="87" src="manual/5.5.3. COMO CADASTRAR UM BEM PATRIMONIAL_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os bens patrimoniais que já foram cadastrados. Clique na  aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/5.5.3. COMO CADASTRAR UM BEM PATRIMONIAL_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione o grupo, caso  o registro não esteja cadastrado clique em <img width="20" height="22" src="manual/5.5.3. COMO CADASTRAR UM BEM PATRIMONIAL_clip_image012.jpg"> para  cadastrar sem ter que sair da tela, selecione também o subgrupo, a quantidade,  a descrição, o fabricante e o fornecedor, a forma de aquisição, data de aquisição,  data de expiração da garantia, valor do bem, localização que está este bem e as  condições do mesmo. Selecione uma foto para identificar este bem. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="61" height="26" src="manual/5.5.3. COMO CADASTRAR UM BEM PATRIMONIAL_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="444" height="252" src="manual/5.5.3. COMO CADASTRAR UM BEM PATRIMONIAL_clip_image016.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
    </article>
</div>    



<div>
<input id="ac-59" name="accordion-1" type="checkbox" />
    <label for="ac-59">5.5.2.2. COMO ALTERAR UM BEM PATRIMONIAL</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar um  registro de um bem patrimonial selecione qual registro deverá sofrer a  modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/5.5.2.2. COMO ALTERAR UM BEM PATRIMONIAL_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/5.5.2.2. COMO ALTERAR UM BEM PATRIMONIAL_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    





<div>
<input id="ac-60" name="accordion-1" type="checkbox" />
    <label for="ac-60">5.5.2.3. COMO GERAR ETIQUETAS PARA O PATRIMÔNIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Vá a tela inicial de  Patrimônios, selecione o bem patrimonial e clique em <img width="124" height="26" src="manual/5.5.2.3. COMO GERAR ETIQUETAS PARA O PATRIMONIO_clip_image002.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="566" height="49" src="manual/5.5.2.3. COMO GERAR ETIQUETAS PARA O PATRIMONIO_clip_image004.jpg"></span></p>
    </article>
</div>   



<div>
<input id="ac-61" name="accordion-1" type="checkbox" />
    <label for="ac-61">5.5.3. MENU RELATÓRIOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos gerar o relatório dos, grupos de  bens, subgrupos de bens e bens patrimoniais.</span></p>
    </article>
</div>    



<div>
<input id="ac-62" name="accordion-1" type="checkbox" />
    <label for="ac-62">5.5.3.1. COMO GERAR O RELATÓRIO DE PATRIMÔNIOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="32" src="manual/5.5.3.1. COMO GERAR O RELATORIO DE PATRIMONIOS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Patrimônio</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> <img width="35" height="38" src="manual/5.5.3.1. COMO GERAR O RELATORIO DE PATRIMONIOS_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial do Patrimônio.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="66" height="20" src="manual/5.5.3.1. COMO GERAR O RELATORIO DE PATRIMONIOS_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><img width="247" height="132" src="manual/5.5.3.1. COMO GERAR O RELATORIO DE PATRIMONIOS_clip_image008.jpg"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O IGREJA CONECTADA  trará filtros de grupos, subgrupos e condição dos bens patrimoniais. Selecione  uma as opções ou deixe em branco pra gerar relatório de tudo. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="68" height="28" src="manual/5.5.3.1. COMO GERAR O RELATORIO DE PATRIMONIOS_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-63" name="accordion-1" type="checkbox" />
    <label for="ac-63">6. MÓDULO GERENCIADOR DO SITE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste módulo iremos  gerenciar os serviços web da igreja, bem como a comunicação, site e pedidos de  orações.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="399" height="116" src="manual/6. MODULO GERENCIADOR DO SITE_clip_image002.jpg"></span>
    </article>
</div>    



<div>
<input id="ac-64" name="accordion-1" type="checkbox" />
    <label for="ac-64">6.1. SUBMODULO COMUNICAÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo iremos gerir toda área de assessoria em  comunicação por meio de notícias, álbuns e banners.</span></p>
    </article>
</div>    



<div>
<input id="ac-65" name="accordion-1" type="checkbox" />
    <label for="ac-65">6.1.1. MENU ÁLBUNS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos cadastrar os álbuns com imagens que  irão ser publicadas no site da Igreja.</span></p>
    </article>
</div>    




<div>
    <input id="ac-66" name="accordion-1" type="checkbox" />
    <label for="ac-66">6.1.1.1. COMO CADASTRAR UM ÁLBUM </label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="89" height="29" src="manual/6.1.1.1. COMO CADASTRAR UM ALBUM_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Comunicação </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="43" height="48" src="manual/6.1.1.1. COMO CADASTRAR UM ALBUM_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de  Comunicação. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="51" height="25" src="manual/6.1.1.1. COMO CADASTRAR UM ALBUM_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="187" height="158" src="manual/6.1.1.1. COMO CADASTRAR UM ALBUM_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os álbuns que já foram cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/6.1.1.1. COMO CADASTRAR UM ALBUM_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe a data o  título do álbum e o local. Agora</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="113" height="20" src="manual/6.1.1.1. COMO CADASTRAR UM ALBUM_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, Selecione as imagens que farão parte do  álbum. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.1.1.1. COMO CADASTRAR UM ALBUM_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="453" height="161" src="manual/6.1.1.1. COMO CADASTRAR UM ALBUM_clip_image016.jpg"></span>
    </article>
</div>    



<div>
<input id="ac-67" name="accordion-1" type="checkbox" />
    <label for="ac-67">6.1.1.2. COMO ALTERAR UM ÁLBUM</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um álbum selecione qual registro deverá sofrer a modificação e clique  em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/6.1.1.2. COMO ALTERAR UM ALBUM_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.1.1.2. COMO ALTERAR UM ALBUM_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>   



<div>
<input id="ac-68" name="accordion-1" type="checkbox" />
    <label for="ac-68">6.1.2. MENU BOLETINS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu, iremos  cadastrar todos os boletins informativos da igreja.</span></p>
    </article>
</div>   



<div>
<input id="ac-69" name="accordion-1" type="checkbox" />
    <label for="ac-69">6.1.2.1. COMO CADASTRAR UM BOLETIM</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="89" height="29" src="manual/6.1.2.1. COMO CADASTRAR UM BOLETIM_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Comunicação </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="43" height="48" src="manual/6.1.2.1. COMO CADASTRAR UM BOLETIM_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de  Comunicação. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="57" height="23" src="manual/6.1.2.1. COMO CADASTRAR UM BOLETIM_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="193" height="158" src="manual/6.1.2.1. COMO CADASTRAR UM BOLETIM_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os boletins que já foram cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/6.1.2.1. COMO CADASTRAR UM BOLETIM_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Informe a data e escolha o arquivo no  formato PDF. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.1.2.1. COMO CADASTRAR UM BOLETIM_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="319" height="201" src="manual/6.1.2.1. COMO CADASTRAR UM BOLETIM_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
    </article>
</div>    



<div>
<input id="ac-70" name="accordion-1" type="checkbox" />
    <label for="ac-70">6.1.2.2. COMO ALTERAR UM BOLETIM</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um boletim selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/6.1.2.2. COMO ALTERAR UM BOLETIM_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.1.2.2. COMO ALTERAR UM BOLETIM_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-71" name="accordion-1" type="checkbox" />
    <label for="ac-71">6.1.3. MENU DIVULGAÇÕES</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos  registrar os banners com anúncios e informações referentes aos eventos da  Igreja.</span></p>
    </article>
</div>   



<div>
<input id="ac-72" name="accordion-1" type="checkbox" />
    <label for="ac-72">6.1.3.1. COMO CADASTRAR UMA DIVULGAÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="89" height="29" src="manual/6.1.3.1. COMO CADASTRAR UMA DIVULGACAO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Comunicação </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="43" height="48" src="manual/6.1.3.1. COMO CADASTRAR UMA DIVULGACAO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de  Comunicação. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="25" src="manual/6.1.3.1. COMO CADASTRAR UMA DIVULGACAO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="187" height="158" src="manual/6.1.3.1. COMO CADASTRAR UMA DIVULGACAO_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as divulgações que já foram cadastradas. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/6.1.3.1. COMO CADASTRAR UMA DIVULGACAO_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe o título da  divulgação. Escolha a data em quem iniciará e terminará a divulgação do banner.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="34" height="31" src="manual/6.1.3.1. COMO CADASTRAR UMA DIVULGACAO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> para  procurar a imagem do banner a ser utilizado. Arraste a imagem para ajustar  dentro do quadro que irá aparecer no site.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso queira escreve  algum texto para que também apareça, marque a opção e digite o texto. </span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="394" height="162" src="manual/6.1.3.1. COMO CADASTRAR UMA DIVULGACAO_clip_image014.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso queira  relacionar um link externo, marque a opção desejada.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="567" height="65" src="manual/6.1.3.1. COMO CADASTRAR UMA DIVULGACAO_clip_image016.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Caso não queira  associar nenhum texto ou link, clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.1.3.1. COMO CADASTRAR UMA DIVULGACAO_clip_image018.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
    </article>
</div>    



<div>
<input id="ac-73" name="accordion-1" type="checkbox" />
    <label for="ac-73">6.1.3.2. COMO ALTERAR UMA DIVULGAÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de uma divulgação selecione qual registro deverá sofrer a modificação  e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/6.1.3.2. COMO ALTERAR UMA DIVULGACAO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.1.3.2. COMO ALTERAR UMA DIVULGACAO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-74" name="accordion-1" type="checkbox" />
    <label for="ac-74">6.1.4. MENU FILMES</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Aqui neste menu  iremos cadastrar os filmes pertinentes e que interessam a igreja. São filmes  que já estão alocados em mídias de vídeo. Exemplo: Youtube.</span></p>
    </article>
</div>    



<div>
<input id="ac-75" name="accordion-1" type="checkbox" />
    <label for="ac-75">6.1.4.1. COMO CADASTRAR UM FILME</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="89" height="29" src="manual/6.1.4.1. COMO CADASTRAR UM FILME_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Comunicação </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="43" height="48" src="manual/6.1.4.1. COMO CADASTRAR UM FILME_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de  Comunicação. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="49" height="24" src="manual/6.1.4.1. COMO CADASTRAR UM FILME_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="159" height="141" src="manual/6.1.4.1. COMO CADASTRAR UM FILME_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os filmes que já foram cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/6.1.4.1. COMO CADASTRAR UM FILME_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Informe o título do filme e a sinopse.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="113" height="20" src="manual/6.1.4.1. COMO CADASTRAR UM FILME_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> e  escolhe uma imagem para representar a capa do filme.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Agora informe o link  de onde está hospedado o vídeo. E, por último, informe o ano de lançamento.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.1.4.1. COMO CADASTRAR UM FILME_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-76" name="accordion-1" type="checkbox" />
    <label for="ac-76">6.1.4.2. COMO ALTERAR UM FILME</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um filme selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/6.1.4.2. COMO ALTERAR UM FILME_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.1.4.2. COMO ALTERAR UM FILME_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-77" name="accordion-1" type="checkbox" />
    <label for="ac-77">6.1.5. MENU NOTÍCIAS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos cadastrar as notícias que irão ao ar  no site da igreja.</span></p>
    </article>
</div>    



<div>
<input id="ac-78" name="accordion-1" type="checkbox" />
    <label for="ac-78">6.1.5.1. COMO CADASTRAR UMA NOTÍCIA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="margin-left:2.7pt;text-indent:32.7pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique  no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="89" height="29" src="manual/6.1.5.1. COMO CADASTRAR UMA NOTICIA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Comunicação </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="43" height="48" src="manual/6.1.5.1. COMO CADASTRAR UMA NOTICIA_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de  Comunicação. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="57" height="22" src="manual/6.1.5.1. COMO CADASTRAR UMA NOTICIA_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="193" height="158" src="manual/6.1.5.1. COMO CADASTRAR UMA NOTICIA_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as notícias que já foram cadastradas. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/6.1.5.1. COMO CADASTRAR UMA NOTICIA_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Digite o título da notícia, e digite o texto da mesma. Caso  queira colocar uma imagem em destaque para a notícia, selecione clicando em <img width="233" height="44" src="manual/6.1.5.1. COMO CADASTRAR UMA NOTICIA_clip_image012.jpg">, procure a imagem e salve. Caso haja uma  data para esta notícia sair do site, informe no campo de Data de Expiração. Para  finalizar o cadastro da notícia, c</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">lique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.1.5.1. COMO CADASTRAR UMA NOTICIA_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="566" height="157" src="manual/6.1.5.1. COMO CADASTRAR UMA NOTICIA_clip_image016.jpg"></span></p>
    </article>
</div>    



<div>
<input id="ac-79" name="accordion-1" type="checkbox" />
    <label for="ac-79">6.1.5.2. COMO ALTERAR UMA NOTÍCIA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de uma notícia selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/6.1.5.2. COMO ALTERAR UMA NOTICIA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.1.5.2. COMO ALTERAR UMA NOTICIA_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>   



<div>
<input id="ac-80" name="accordion-1" type="checkbox" />
    <label for="ac-80">6.1.6. MENU VÍDEOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Aqui neste menu  iremos cadastrar os vídeos de curta duração que serão publicados no site da  igreja.</span></p>
    </article>
</div>    



<div>
<input id="ac-81" name="accordion-1" type="checkbox" />
    <label for="ac-81">6.1.6.1. COMO CADASTRAR UM VÍDEO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="89" height="29" src="manual/6.1.6.1. COMO CADASTRAR UM VIDEO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Comunicação </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="43" height="48" src="manual/6.1.6.1. COMO CADASTRAR UM VIDEO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de  Comunicação. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="48" height="29" src="manual/6.1.6.1. COMO CADASTRAR UM VIDEO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="193" height="167" src="manual/6.1.6.1. COMO CADASTRAR UM VIDEO_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os vídeos que já foram cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/6.1.6.1. COMO CADASTRAR UM VIDEO_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Informe o título do vídeo, a data e a  descrição. Agora informe o link de onde está hospedado o vídeo. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.1.6.1. COMO CADASTRAR UM VIDEO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-82" name="accordion-1" type="checkbox" />
    <label for="ac-82">6.1.6.2. COMO ALTERAR UM VÍDEO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um vídeo selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/6.1.6.2. COMO ALTERAR UM VIDEO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.1.6.2. COMO ALTERAR UM VIDEO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-83" name="accordion-1" type="checkbox" />
    <label for="ac-83">6.2. SUBMÓDULO CONFIGURAÇÕES DO SITE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo iremos configurar todas as ferramentas  do site da igreja.</span></p>
    </article>
</div>    



<div>
<input id="ac-84" name="accordion-1" type="checkbox" />
    <label for="ac-84">6.2.1. MENU CONFIGURAÇÕES DO SITE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Na primeira aba <img width="132" height="20" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image002.jpg"> iremos  cadastrar o título e as URL&rsquo;s das redes sociais da igreja (instagram, facebook,  twitter e youtube). Informe também o link do canal stream para visualização do  culto ao vivo. Caso possua uma conta no google, poderá salvar o google  analytics no site da igreja.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="567" height="215" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image004.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">            Na  segunda aba <img width="66" height="25" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image006.jpg">, informe o CEP para que o Sistema busque o  endereço, complete o restante dos campos.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="333" height="176" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">            Na  terceira aba <img width="66" height="25" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image010.jpg">, informe a marca de sua igreja para que ela  possa ser exibida no site.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="411" height="166" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image012.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Na quarta aba <img width="68" height="27" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image014.jpg">, digite os telefones de contatos e clique em <img width="94" height="28" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image016.jpg">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="427" height="71" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image018.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Na quinta aba <img width="57" height="27" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image020.jpg">, informe os e-mails e clique em <img width="94" height="28" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image016_0000.jpg">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="438" height="70" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image022.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Na sexta e última aba <img width="100" height="22" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image024.jpg"> informe os horários que começam os cultos e  clique em <img width="94" height="28" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image016_0001.jpg">. Para Salvar todas as informações, clique em <img width="77" height="26" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image026.jpg">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="433" height="70" src="manual/6.2.1. MENU CONFIGURACOES DO SITE_clip_image028.jpg"></span></p>
    </article>
</div>    



<div>
<input id="ac-85" name="accordion-1" type="checkbox" />
    <label for="ac-85">6.3. SUBMÓDULO EVENTOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo iremos cadastrar todos os eventos que a  igreja irá proporcionar aos seus membros, visitantes e congregados.</span></p>
    </article>
 </div>   



<div>
<input id="ac-86" name="accordion-1" type="checkbox" />
    <label for="ac-86">6.3.1. MENU  EVENTOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Será neste menu que iremos gerenciar todos os eventos e  inscrições da igreja.</span></p>
    </article>
 </div>   



<div>
<input id="ac-87" name="accordion-1" type="checkbox" />
    <label for="ac-87">6.3.1.1. COMO CADASTRAR UM EVENTO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="89" height="29" src="manual/6.3.1.1. COMO CADASTRAR UM EVENTO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Eventos <img width="40" height="45" src="manual/6.3.1.1. COMO CADASTRAR UM EVENTO_clip_image004.jpg">. Você estará na tela gerencial de Eventos.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="55" height="22" src="manual/6.3.1.1. COMO CADASTRAR UM EVENTO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os eventos que já foram cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/6.3.1.1. COMO CADASTRAR UM EVENTO_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Informe o título do evento e a descrição. Informe  a data de início e fim do evento. Agora digite a quantidade de vagas  disponíveis para este evento. O evento exige taxa de inscrição? Marque sim ou  não, se sim, informe o valor a ser pago e se haverá alguma integração com o  Pagseguro. Se houver integração, informe o email da conta do Pagseguro e o token.  Será um evento externo? Marque sim ou não, se sim, informe o CEP e complete o  endereço do local do evento. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.3.1.1. COMO CADASTRAR UM EVENTO_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="447" height="204" src="manual/6.3.1.1. COMO CADASTRAR UM EVENTO_clip_image012.jpg"></span></p>
    </article>
</div>   



<div>
<input id="ac-1001" name="accordion-1" type="checkbox" />
    <label for="ac-1001">6.3.1.2. COMO ALTERAR UM EVENTO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um evento selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/6.3.1.2. COMO ALTERAR UM EVENTO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.3.1.2. COMO ALTERAR UM EVENTO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-88" name="accordion-1" type="checkbox" />
    <label for="ac-88">6.3.1.3. COMO VERIFICAR OS INSCRITOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para verificar as  inscrições, selecione o evento e clique em <img width="94" height="24" src="manual/6.3.1.3. COMO VERIFICAR OS INSCRITOS_clip_image002.jpg">. Podemos pesquisar por nome e e-mail.  Informe se a pessoa inscrita efetuou ou não o pagamento.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="322" height="196" src="manual/6.3.1.3. COMO VERIFICAR OS INSCRITOS_clip_image004.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
    </article>
</div>   



<div>
<input id="ac-89" name="accordion-1" type="checkbox" />
    <label for="ac-89">6.3.1.4. COMO GERAR UM RELATÓRIO DE EVENTOS E SEUS INSCRITOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="89" height="29" src="manual/6.3.1.4. COMO GERAR UM RELATORIO DE EVENTOS E SEUS INSCRITOS_clip_image002_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Eventos <img width="40" height="45" src="manual/6.3.1.4. COMO GERAR UM RELATORIO DE EVENTOS E SEUS INSCRITOS_clip_image004_0000.jpg">. Você estará na tela gerencial de Eventos.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="69" height="20" src="manual/6.3.1.4. COMO GERAR UM RELATORIO DE EVENTOS E SEUS INSCRITOS_clip_image006_0000.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="342" height="83" src="manual/6.3.1.4. COMO GERAR UM RELATORIO DE EVENTOS E SEUS INSCRITOS_clip_image008_0000.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Selecione qual evento  e a situação dos inscritos deseja gerar o relatório e clique em <img width="69" height="30" src="manual/6.3.1.4. COMO GERAR UM RELATORIO DE EVENTOS E SEUS INSCRITOS_clip_image010_0000.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">O relatório irá aparecer na  tela do sistema. Podemos gerar 03 opções (imprimir direto, PDF e Excel).</span></p>
    </article>
</div>    



<div>
<input id="ac-90" name="accordion-1" type="checkbox" />
    <label for="ac-90">6.4. SUBMÓDULO OPORTUNIDADES DE SERVIR</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para saber quem se  cadastrou pela web site da igreja para servir a igreja, clique no módulo </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="89" height="29" src="manual/6.4. SUBMODULO OPORTUNIDADES DE SERVIR_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Oportunidades  de Servir </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="37" height="42" src="manual/6.4. SUBMODULO OPORTUNIDADES DE SERVIR_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial das  Oportunidades de Servir.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="566" height="93" src="manual/6.4. SUBMODULO OPORTUNIDADES DE SERVIR_clip_image006.jpg"></span></p>
    </article>
</div>   



<div>
<input id="ac-91" name="accordion-1" type="checkbox" />
    <label for="ac-91">6.5. SUBMÓDULO PÁGINAS DO SITE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo iremos gerenciar as páginas e abas do  web site da Igreja.</span></p>
    </article>
</div>    



<div>
<input id="ac-92" name="accordion-1" type="checkbox" />
    <label for="ac-92">6.5.1. COMO CADASTRAR MENU E SUBMENU DO SITE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="89" height="29" src="manual/6.5.1. COMO CADASTRAR MENU E SUBMENU DO SITE_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Páginas  do Site </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="29" height="33" src="manual/6.5.1. COMO CADASTRAR MENU E SUBMENU DO SITE_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de Páginas do  Site. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="119" height="24" src="manual/6.5.1. COMO CADASTRAR MENU E SUBMENU DO SITE_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="234" height="92" src="manual/6.5.1. COMO CADASTRAR MENU E SUBMENU DO SITE_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os menus e submenus que já foram cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/6.5.1. COMO CADASTRAR MENU E SUBMENU DO SITE_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Informe o título do menu/submenu, escolha o  tipo (menu ou submenu). Se for menu, informe se vai possuir submenu. Se for  submenu, informe qual menu ele pertence. Informe a ordem de exibição.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Digite todo o texto  que aparecerá no site. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.5.1. COMO CADASTRAR MENU E SUBMENU DO SITE_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="466" height="231" src="manual/6.5.1. COMO CADASTRAR MENU E SUBMENU DO SITE_clip_image014.jpg"></span></p>
    </article>
 </div>   



<div>
<input id="ac-93" name="accordion-1" type="checkbox" />
    <label for="ac-93">6.5.2. COMO ALTERAR UM MENU E SUBMENU DO SITE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um menu e submenu selecione qual registro deverá sofrer a  modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/6.5.2. COMO ALTERAR UM MENU E SUBMENU DO SITE_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.5.2. COMO ALTERAR UM MENU E SUBMENU DO SITE_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>   



<div>
<input id="ac-94" name="accordion-1" type="checkbox" />
    <label for="ac-94">6.5. SUBMÓDULO PEDIDOS DE ORAÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo  iremos gerenciar todos os pedidos de oração que vamos receber dos nossos fiéis  através de nossa web site.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Também iremos  gerenciar os fiéis que têm interesse em servir de alguma forma à igreja.</span></p>
    </article>
</div>    



<div>
<input id="ac-95" name="accordion-1" type="checkbox" />
    <label for="ac-95">6.5.3. MENU CADASTROS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Aqui neste menu,  iremos cadastrar todos os motivos de orações e relacionar todos os fiéis que  tenham interesse em ajudar a igreja</span></p>
    </article>
</div>    



<div>
<input id="ac-96" name="accordion-1" type="checkbox" />
    <label for="ac-96">6.5.3.1. COMO CADASTRAR UM MOTIVO DE ORAÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="89" height="29" src="manual/6.5.3.1. COMO CADASTRAR UM MOTIVO DE ORACAO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Pedidos  de Oração </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="32" height="36" src="manual/6.5.3.1. COMO CADASTRAR UM MOTIVO DE ORACAO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial dos Pedidos  de Oração. Passe o mouse em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="73" height="23" src="manual/6.5.3.1. COMO CADASTRAR UM MOTIVO DE ORACAO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="125" height="23" src="manual/6.5.3.1. COMO CADASTRAR UM MOTIVO DE ORACAO_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="303" height="78" src="manual/6.5.3.1. COMO CADASTRAR UM MOTIVO DE ORACAO_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os motivos de orações já cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/6.5.3.1. COMO CADASTRAR UM MOTIVO DE ORACAO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite no campo Descrição o nome do motivo  da oração. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.5.3.1. COMO CADASTRAR UM MOTIVO DE ORACAO_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="249" height="146" src="manual/6.5.3.1. COMO CADASTRAR UM MOTIVO DE ORACAO_clip_image016.jpg"></span>
    </article>
</div>    



<div>
<input id="ac-97" name="accordion-1" type="checkbox" />
    <label for="ac-97">6.5.3.2. COMO ALTERAR UM MOTIVO DE ORAÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um motivo de oração selecione qual registro deverá sofrer a modificação  e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/6.5.3.2. COMO ALTERAR UM MOTIVO DE ORACAO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/6.5.3.2. COMO ALTERAR UM MOTIVO DE ORACAO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-98" name="accordion-1" type="checkbox" />
    <label for="ac-98">6.5.4. MENU PEDIDOS DE ORAÇÃO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Aqui neste menu  iremos gerenciar todos os pedidos de orações que iremos receber dos fiéis  através da nossa web site.</span></p>
    </article>
 </div>   



<div>
<input id="ac-99" name="accordion-1" type="checkbox" />
    <label for="ac-99">6.5.4.1. COMO VISUALIZAR OS PEDIDOS DE ORAÇÕES</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para saber quem se  mandou um pedido de oração, clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="89" height="29" src="manual/6.5.4.1. COMO VISUALIZAR OS PEDIDOS DE ORACOES_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Pedidos  de Oração </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="32" height="36" src="manual/6.5.4.1. COMO VISUALIZAR OS PEDIDOS DE ORACOES_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial dos Pedidos  de Oração. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="109" height="26" src="manual/6.5.4.1. COMO VISUALIZAR OS PEDIDOS DE ORACOES_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="211" height="87" src="manual/6.5.4.1. COMO VISUALIZAR OS PEDIDOS DE ORACOES_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  gerencial com todos os pedidos de orações enviados por fiéis.</span></p>
    </article>
</div>    



<div>
<input id="ac-100" name="accordion-1" type="checkbox" />
    <label for="ac-100">7. MÓDULO PASTORAL</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste módulo iremos  gerenciar o Prontuário de atendimento aos membros e o Sermonário através das  mensagens bíblicas, auxiliando o pastor a temporizar seu culto a fim de  gerenciar o tempo em cada passagem.</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="209" height="110" src="manual/7. MODULO PASTORAL_clip_image002.jpg"></span>
    </article>
 </div>   



<div>
<input id="ac-101" name="accordion-1" type="checkbox" />
    <label for="ac-101">7.1. SUBMÓDULO PRONTUÁRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo  iremos gerenciar os atendimentos aos membros da igreja.</span></p>
    </article>
 </div>   



<div>
<input id="ac-102" name="accordion-1" type="checkbox" />
    <label for="ac-102">7.1.1. MENU CADASTROS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Aqui vamos cadastrar  os assuntos tratados nos encontros e os estados emocionais dos membros.</span></p>
    </article>
</div>   



<div>
<input id="ac-103" name="accordion-1" type="checkbox" />
    <label for="ac-103">7.1.1.1. COMO CADASTRAR UM ASSUNTO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo  Pastoral</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="76" height="25" src="manual/7.1.1.1. COMO CADASTRAR UM ASSUNTO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Prontuário </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="27" height="31" src="manual/7.1.1.1. COMO CADASTRAR UM ASSUNTO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial dos  Prontuários. Passe o mouse em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="73" height="23" src="manual/7.1.1.1. COMO CADASTRAR UM ASSUNTO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="64" height="19" src="manual/7.1.1.1. COMO CADASTRAR UM ASSUNTO_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="290" height="62" src="manual/7.1.1.1. COMO CADASTRAR UM ASSUNTO_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os assuntos já cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/7.1.1.1. COMO CADASTRAR UM ASSUNTO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite no campo Descrição do assunto.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/7.1.1.1. COMO CADASTRAR UM ASSUNTO_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="152" height="117" src="manual/7.1.1.1. COMO CADASTRAR UM ASSUNTO_clip_image016.jpg"></span>
    </article>
 </div>   



<div>
<input id="ac-104" name="accordion-1" type="checkbox" />
    <label for="ac-104">7.1.1.2. COMO ALTERAR UM ASSUNTO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um assunto selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/7.1.1.2. COMO ALTERAR UM ASSUNTO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/7.1.1.2. COMO ALTERAR UM ASSUNTO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>   



<div>
<input id="ac-105" name="accordion-1" type="checkbox" />
    <label for="ac-105">7.1.1.3. COMO CADASTRAR UM ESTADO EMOCIONAL</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo  Pastoral</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="76" height="25" src="manual/7.1.1.3. COMO CADASTRAR UM ESTADO EMOCIONAL_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Prontuário </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="27" height="31" src="manual/7.1.1.3. COMO CADASTRAR UM ESTADO EMOCIONAL_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial dos  Prontuários. Passe o mouse em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="73" height="23" src="manual/7.1.1.3. COMO CADASTRAR UM ESTADO EMOCIONAL_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="125" height="26" src="manual/7.1.1.3. COMO CADASTRAR UM ESTADO EMOCIONAL_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="290" height="70" src="manual/7.1.1.3. COMO CADASTRAR UM ESTADO EMOCIONAL_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os estados emocionais já cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/7.1.1.3. COMO CADASTRAR UM ESTADO EMOCIONAL_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite no campo Descrição do estado  emocional. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/7.1.1.3. COMO CADASTRAR UM ESTADO EMOCIONAL_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>
                    
<div>
    <input id="ac-106" name="accordion-1" type="checkbox" />
    <label for="ac-106">7.1.1.4. COMO ALTERAR UM ESTADO EMOCIONAL</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um assunto selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/7.1.1.4. COMO ALTERAR UM ESTADO EMOCIONAL_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/7.1.1.4. COMO ALTERAR UM ESTADO EMOCIONAL_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-107" name="accordion-1" type="checkbox" />
    <label for="ac-107">7.1.2. MENU PRONTUÁRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos  registrar os atendimentos aos membros consultados.</span></p>
    </article>
</div>    



<div>
<input id="ac-108" name="accordion-1" type="checkbox" />
    <label for="ac-108">7.1.2.1. COMO REGISTRAR UM ATENDIMENTO NO PRONTUÁRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo  Pastoral</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="76" height="25" src="manual/7.1.2.1. COMO REGISTRAR UM ATENDIMENTO NO PRONTUARIO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Prontuário </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="27" height="31" src="manual/7.1.2.1. COMO REGISTRAR UM ATENDIMENTO NO PRONTUARIO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial dos  Prontuários e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="24" src="manual/7.1.2.1. COMO REGISTRAR UM ATENDIMENTO NO PRONTUARIO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="192" height="88" src="manual/7.1.2.1. COMO REGISTRAR UM ATENDIMENTO NO PRONTUARIO_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os atendimentos por membro já cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/7.1.2.1. COMO REGISTRAR UM ATENDIMENTO NO PRONTUARIO_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite a data do atendimento, selecione o  membro que foi atendido, escolha o assunto conversado e o estado emocional do  membro.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Descreva todo o  atendimento e informe uma data de retorno. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/7.1.2.1. COMO REGISTRAR UM ATENDIMENTO NO PRONTUARIO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="335" height="272" src="manual/7.1.2.1. COMO REGISTRAR UM ATENDIMENTO NO PRONTUARIO_clip_image014.jpg"></span>
    </article>
</div>    



<div>
<input id="ac-109" name="accordion-1" type="checkbox" />
    <label for="ac-109">7.1.2.2. COMO ALTERAR UM ATENDIMENTO NO PRONTUÁRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um atendimento selecione qual registro deverá sofrer a modificação  e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/7.1.2.2. COMO ALTERAR UM ATENDIMENTO NO PRONTUARIO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/7.1.2.2. COMO ALTERAR UM ATENDIMENTO NO PRONTUARIO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
 </div>   



<div>
<input id="ac-110" name="accordion-1" type="checkbox" />
    <label for="ac-110">7.2. SUBMÓDULO SERMONÁRIO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Aqui neste submódulo,  iremos gerenciar os tipos de cadastros de mensagens e as mensagens propriamente  ditas. Ao clicar, será mostrado um gráfico indicando a quantidade de mensagens  por categoria.</span></p>
    </article>
</div>   



<div>
<input id="ac-111" name="accordion-1" type="checkbox" />
    <label for="ac-111">7.2.1. MENU CADASTRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos  cadastrar as categorias de mensagens para que possamos classificar por tipos de  mensagens bíblicas.</span></p>
    </article>
</div>    



<div>
<input id="ac-112" name="accordion-1" type="checkbox" />
    <label for="ac-112">7.2.2.1. COMO CADASTRAR UMA CATEGORIA DE MENSAGEM</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="87" height="29" src="manual/7.2.1.1. COMO CADASTRAR UMA CATEGORIA DE MENSAGEM_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Sermonário </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="44" height="50" src="manual/7.2.1.1. COMO CADASTRAR UMA CATEGORIA DE MENSAGEM_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de Sermonário.  Passe o mouse em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="73" height="23" src="manual/7.2.1.1. COMO CADASTRAR UMA CATEGORIA DE MENSAGEM_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="146" height="26" src="manual/7.2.1.1. COMO CADASTRAR UMA CATEGORIA DE MENSAGEM_clip_image008.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="294" height="59" src="manual/7.2.1.1. COMO CADASTRAR UMA CATEGORIA DE MENSAGEM_clip_image010.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as categorias de mensagens já cadastradas. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/7.2.1.1. COMO CADASTRAR UMA CATEGORIA DE MENSAGEM_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Digite no campo Descrição o nome do motivo  da oração. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/7.2.1.1. COMO CADASTRAR UMA CATEGORIA DE MENSAGEM_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><img width="253" height="150" src="manual/7.2.1.1. COMO CADASTRAR UMA CATEGORIA DE MENSAGEM_clip_image016.jpg" align="left" hspace="12"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
    </article>
</div>



<div>
<input id="ac-113" name="accordion-1" type="checkbox" />
    <label for="ac-113">7.2.1.2. COMO ALTERAR UMA CATEGORIA DE MENSAGEM</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de uma categoria de mensagem selecione qual registro deverá sofrer a  modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/7.2.1.2. COMO ALTERAR UMA CATEGORIA DE MENSAGEM_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/7.2.1.2. COMO ALTERAR UMA CATEGORIA DE MENSAGEM_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-114" name="accordion-1" type="checkbox" />
    <label for="ac-114">7.2.2. MENU MENSAGEM E SERMÕES</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos  cadastrar as mensagens bíblicas que serão passadas no culto do pastor.</span></p>
    </article>
 </div>   



<div>
<input id="ac-115" name="accordion-1" type="checkbox" />
    <label for="ac-115">7.2.2.1. COMO CADASTRAR UMA MENSAGEM</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="87" height="29" src="manual/7.2.2.1. COMO CADASTRAR UMA MENSAGEM_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Sermonário </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="44" height="50" src="manual/7.2.2.1. COMO CADASTRAR UMA MENSAGEM_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de Sermonário.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="113" height="28" src="manual/7.2.2.1. COMO CADASTRAR UMA MENSAGEM_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="203" height="85" src="manual/7.2.2.1. COMO CADASTRAR UMA MENSAGEM_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as mensagens já cadastradas. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/7.2.2.1. COMO CADASTRAR UMA MENSAGEM_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe o título da  mensagem. Informe a data em que essa mensagem será apresentada. Selecione a  categoria da mensagem.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe as  palavras-chaves desta mensagem e o prefácio. Digite o local onde será dada esta  mensagem.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe um tópico  para cada parte desta mensagem e quanto tempo durará (em minutos). Caso queira  que lhe seja informado que este tempo esteja acabando, informe com quantos  minutos o Sistema lhe alerte do encerramento do tempo. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="101" height="24" src="manual/7.2.2.1. COMO CADASTRAR UMA MENSAGEM_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. </span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique em <img width="62" height="38" src="manual/7.2.2.1. COMO CADASTRAR UMA MENSAGEM_clip_image014.jpg"> abrirá  uma janela.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="275" height="225" src="manual/7.2.2.1. COMO CADASTRAR UMA MENSAGEM_clip_image016.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informaremos a versão  de tradução da bíblia, qual testamento está sendo usado, qual livro proferido e  os versículos usados e clique em <img width="110" height="23" src="manual/7.2.2.1. COMO CADASTRAR UMA MENSAGEM_clip_image018.jpg"> e  depois clique em <img width="35" height="23" src="manual/7.2.2.1. COMO CADASTRAR UMA MENSAGEM_clip_image020.jpg">. Para finalizar o cadastro da mensagem, clique  em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/7.2.2.1. COMO CADASTRAR UMA MENSAGEM_clip_image022.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="441" height="251" src="manual/7.2.2.1. COMO CADASTRAR UMA MENSAGEM_clip_image024.jpg"></span></p>
    </article>
 </div>   



<div>
<input id="ac-116" name="accordion-1" type="checkbox" />
    <label for="ac-116">7.2.2.2. COMO ALTERAR UMA MENSAGEM</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de uma categoria de mensagem selecione qual registro deverá sofrer a  modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/7.2.2.2. COMO ALTERAR UMA MENSAGEM_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/7.2.2.2. COMO ALTERAR UMA MENSAGEM_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>



<div>
<input id="ac-117" name="accordion-1" type="checkbox" />
    <label for="ac-117">8. MÓDULO GEORREFERENCIAMENTO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Este módulo nos  permitirá ver no mapa onde os membros e visitantes moram através de seus  endereços. Isso fará com que o Pastor saiba onde se concentra seus membros.</span></p>
    </article>
</div>   



<div>
<input id="ac-118" name="accordion-1" type="checkbox" />
    <label for="ac-118">8.1. SUBMÓDULO MEMBROS E VISITANTES</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo  iremos localizar a residência dos membros e visitantes da igreja.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique em <img width="40" height="47" src="manual/8.1. SUBMODULO MEMBROS E VISITANTES_clip_image002.jpg"> para  abrir o mapa que mostrará aas localizações das residências de cada membro ou  visitante cadastrado.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="409" height="332" src="manual/8.1. SUBMODULO MEMBROS E VISITANTES_clip_image004.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">No mapa a igreja está  representada pelo ícone <img width="35" height="44" src="manual/8.1. SUBMODULO MEMBROS E VISITANTES_clip_image006.jpg">. E o membro da mesma forma com o ícone <img width="31" height="36" src="manual/8.1. SUBMODULO MEMBROS E VISITANTES_clip_image008.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Na parte superior do  mapa existe um filtro onde podemos mostrar separadamente todos os tipos de  membros e visitantes.</span></p>
    </article>
    
</div>


<div>
<input id="ac-119" name="accordion-1" type="checkbox" />
    <label for="ac-119">9. MÓDULO BIBLIOTECA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste módulo iremos  ter o controle de cadastro e empréstimos de livros de nosso acervo.</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="206" height="112" src="manual/9. MODULO BIBLIOTECA_clip_image002.jpg"></span>
    </article>
    
</div>


<div>
<input id="ac-120" name="accordion-1" type="checkbox" />
    <label for="ac-120">9.1. SUBMÓDULO CADASTROS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste módulo iremos  cadastrar todos os livros de nosso acervo, bem como os autores, editoras e  gêneros.</span></p>
    </article>
</div>



<div>
<input id="ac-121" name="accordion-1" type="checkbox" />
    <label for="ac-121">9.1.1. MENU AUTORES</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="80" height="26" src="manual/9.1.1. MENU AUTORES_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="31" height="35" src="manual/9.1.1. MENU AUTORES_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de Cadastros.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="60" height="29" src="manual/9.1.1. MENU AUTORES_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="189" height="153" src="manual/9.1.1. MENU AUTORES_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os autores já cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/9.1.1. MENU AUTORES_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Informe o nome do Autor e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/9.1.1. MENU AUTORES_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="196" height="157" src="manual/9.1.1. MENU AUTORES_clip_image014.jpg"></span></p>
    </article>
</div>



<div>
<input id="ac-122" name="accordion-1" type="checkbox" />
    <label for="ac-122">9.1.1. COMO ALTERAR UM CADASTRO DE AUTOR</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um autor, selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/9.1.1.1. COMO ALTERAR UM CADASTRO DE AUTOR_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/9.1.1.1. COMO ALTERAR UM CADASTRO DE AUTOR_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>   



<div>
<input id="ac-123" name="accordion-1" type="checkbox" />
    <label for="ac-123">9.1.2. MENU BIBLIOTECAS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="80" height="26" src="manual/9.1.2. MENU BIBLIOTECAS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="31" height="35" src="manual/9.1.2. MENU BIBLIOTECAS_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de Cadastros.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="22" src="manual/9.1.2. MENU BIBLIOTECAS_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="189" height="153" src="manual/9.1.2. MENU BIBLIOTECAS_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as bibliotecas já cadastradas. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/9.1.2. MENU BIBLIOTECAS_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Informe o nome da biblioteca e sua  localização. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/9.1.2. MENU BIBLIOTECAS_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="174" height="164" src="manual/9.1.2. MENU BIBLIOTECAS_clip_image014.jpg"></span></p>
    </article>
</div>    



<div>
<input id="ac-124" name="accordion-1" type="checkbox" />
    <label for="ac-124">9.1.2.1. COMO ALTERAR UM CADASTRO DE BIBLIOTECA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de uma biblioteca, selecione qual registro deverá sofrer a modificação  e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/9.1.2.1. COMO ALTERAR UM CADASTRO DE BIBLIOTECA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/9.1.2.1. COMO ALTERAR UM CADASTRO DE BIBLIOTECA_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-125" name="accordion-1" type="checkbox" />
    <label for="ac-125">9.1.3. MENU EDITORAS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="80" height="26" src="manual/9.1.3. MENU EDITORAS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="31" height="35" src="manual/9.1.3. MENU EDITORAS_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de Cadastros.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="50" height="24" src="manual/9.1.3. MENU EDITORAS_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="205" height="169" src="manual/9.1.3. MENU EDITORAS_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as editoras já cadastradas. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/9.1.3. MENU EDITORAS_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Informe o nome da editora, email, telefone  e fax. Digite o número do CEP para que o sistema informe o endereço. Complete  informando o número e complemento. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/9.1.3. MENU EDITORAS_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="381" height="203" src="manual/9.1.3. MENU EDITORAS_clip_image014.jpg"></span>
    </article>
</div>    



<div>
<input id="ac-126" name="accordion-1" type="checkbox" />
    <label for="ac-126">9.1.3.1. COMO ALTERAR UM REGISTRO DE EDITORA</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de uma editora, selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/9.1.3.1. COMO ALTERAR UM REGISTRO DE EDITORA_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/9.1.3.1. COMO ALTERAR UM REGISTRO DE EDITORA_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-127" name="accordion-1" type="checkbox" />
    <label for="ac-127">9.1.4. MENU GÊNEROS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="80" height="26" src="manual/9.1.4. MENU GENEROS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="31" height="35" src="manual/9.1.4. MENU GENEROS_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de Cadastros.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="58" height="23" src="manual/9.1.4. MENU GENEROS_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="205" height="169" src="manual/9.1.4. MENU GENEROS_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os gêneros já cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/9.1.4. MENU GENEROS_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Informe o nome do gênero. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/9.1.4. MENU GENEROS_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="187" height="149" src="manual/9.1.4. MENU GENEROS_clip_image014.jpg"></span>
    </article>
</div>   



<div>
<input id="ac-128" name="accordion-1" type="checkbox" />
    <label for="ac-128">9.1.4.1. COMO ALTERAR UM REGISTRO DE GÊNERO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um gênero, selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/9.1.5. COMO ALTERAR UM REGISTRO DE GENERO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/9.1.5. COMO ALTERAR UM REGISTRO DE GENERO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-129" name="accordion-1" type="checkbox" />
    <label for="ac-129">9.1.5. MENU LIVROS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="80" height="26" src="manual/9.1.6. MENU LIVROS_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Cadastros </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="31" height="35" src="manual/9.1.6. MENU LIVROS_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de Cadastros.  Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="49" height="22" src="manual/9.1.6. MENU LIVROS_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="210" height="169" src="manual/9.1.6. MENU LIVROS_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os livros já cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/9.1.6. MENU LIVROS_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Informe o título do livro, gênero, autor,  editora, ano de publicação, cidade, código ISBN, número da edição, número de  páginas e um resumo.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Informe a quantidade  existente dessa publicação no acervo e a biblioteca em que se encontra. Caso  queira publique também a digitalização desta obra. Selecione também a foto da  capa do livro. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/9.1.6. MENU LIVROS_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
 </div>   



<div>
<input id="ac-130" name="accordion-1" type="checkbox" />
    <label for="ac-130">9.1.5.1. COMO ALTERAR UM REGISTRO DE LIVRO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um livro, selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/9.1.5.1. COMO ALTERAR UM REGISTRO DE LIVRO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/9.1.5.1. COMO ALTERAR UM REGISTRO DE LIVRO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-131" name="accordion-1" type="checkbox" />
    <label for="ac-131">9.1.6. MENU RELATÓRIOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste menu iremos ter  acesso a todos os tipos de relatórios relacionado ao módulo de cadastro de  livros, autores editoras e gêneros.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Basta selecionar qual  filtro caso queira refinar o relatório e clique em <img width="70" height="29" src="manual/9.1.6. MENU RELATORIOS_clip_image002.jpg">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><img width="209" height="194" src="manual/9.1.6. MENU RELATORIOS_clip_image004.jpg" align="left" hspace="12"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "> </span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
    </article>
</div>   



<div>
<input id="ac-132" name="accordion-1" type="checkbox" />
    <label for="ac-132">9.2. SUBMÓDULO EMPRÉSTIMOS</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste submódulo  iremos fazer o gerenciamento e ter o controle dos empréstimos de livros do  acervo da biblioteca da igreja.</span></p>
    </article>
</div>   



<div>
<input id="ac-133" name="accordion-1" type="checkbox" />
    <label for="ac-133">9.2.1. MENU EMPRÉSTIMO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para registrar um  empréstimo, clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="80" height="26" src="manual/9.2.1. MENU EMPRESTIMO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de  Empréstimo </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="30" height="35" src="manual/9.2.1. MENU EMPRESTIMO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de  Empréstimos. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="76" height="22" src="manual/9.2.1. MENU EMPRESTIMO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="230" height="66" src="manual/9.2.1. MENU EMPRESTIMO_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os empréstimos já cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/9.2.1. MENU EMPRESTIMO_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Selecione o nome do membro que está  solicitando o empréstimo. Selecione a data do empréstimo e data prevista para  devolução. Informe o valor (em R$) do empréstimo e o valor da multa caso haja  atraso. Por fim selecione o livro que está sendo emprestado. E clique em <img width="65" height="25" src="manual/9.2.1. MENU EMPRESTIMO_clip_image012.jpg">. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/9.2.1. MENU EMPRESTIMO_clip_image014.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="508" height="266" src="manual/9.2.1. MENU EMPRESTIMO_clip_image016.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Quando o livro for  devolvido, basta selecionar o registro e clicar em <img width="75" height="27" src="manual/9.2.1. MENU EMPRESTIMO_clip_image018.jpg"> e  informar a data de entrega e clicar em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/9.2.1. MENU EMPRESTIMO_clip_image014_0000.jpg">.</span></p>
    </article>
</div>    



<div>
<input id="ac-134" name="accordion-1" type="checkbox" />
    <label for="ac-134">10. MÓDULO ESCOLA BÍBLICA</label>
    <article class="ac-large" style="overflow: auto;">                                    
          <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Neste módulo iremos  manter o controle, e ao mesmo tempo, gerenciar as classes de disciplinas de  ensinamentos bíblicos e seus conteúdos programáticos.</span></p>
  <p style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</p>
  <p style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="84" height="97" src="manual/10. MODULO ESCOLA BIBLICA_clip_image002_0000.jpg"></p>
    </article>
</div>    



<div>
<input id="ac-135" name="accordion-1" type="checkbox" />
    <label for="ac-135">10.1. MENU CADASTRO DE CLASSES</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para cadastrar uma  classe, clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="75" height="25" src="manual/10.1. MENU CADASTRO DE CLASSES_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Escola  Bíblica </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="28" height="33" src="manual/10.1. MENU CADASTRO DE CLASSES_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de Escola  Bíblica. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="124" height="25" src="manual/10.1. MENU CADASTRO DE CLASSES_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="230" height="85" src="manual/10.1. MENU CADASTRO DE CLASSES_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com as classes já cadastradas. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/10.1. MENU CADASTRO DE CLASSES_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Informe a descrição (nome) da classe,  horário em que acontecerão os encontros. Informe uma sigla de código, selecione  qual dia da semana ocorrerá cada encontro e o turno (manhã, tarde ou noite)  Informe também o tipo de Classe (Escola Bíblica, núcleo ou Pequenos Grupos) Se  selecionar núcleo ou pequenos grupos, aparecerá a opção de inserir o endereço  se for fora da igreja. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/10.1. MENU CADASTRO DE CLASSES_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="277" height="173" src="manual/10.1. MENU CADASTRO DE CLASSES_clip_image014.jpg"></span>
    </article>
</div>    



<div>
<input id="ac-136" name="accordion-1" type="checkbox" />
    <label for="ac-136">10.1.1. COMO ALTERAR UM REGISTRO DE UMA CLASSE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de uma classe, selecione qual registro deverá sofrer a modificação e  clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/10.1.1. COMO ALTERAR UM REGISTRO DE UMA CLASSE_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/10.1.1. COMO ALTERAR UM REGISTRO DE UMA CLASSE_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>   



<div>
<input id="ac-137" name="accordion-1" type="checkbox" />
    <label for="ac-137">10.1.2. COMO INSERIR PROFESSORES NA CLASSE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para inserir um ou  mais professores numa classe, vá para a tela inicial de classes cadastradas,  selecione a classe que deseja adicionar o professor e clique em <img width="107" height="24" src="manual/10.1.2. COMO INSERIR PROFESSORES NA CLASSE_clip_image002.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Abrirá uma janela  onde poderemos selecionar o professor e adicionar à classe.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="454" height="220" src="manual/10.1.2. COMO INSERIR PROFESSORES NA CLASSE_clip_image004.jpg"></span></p>
    </article>
</div>    



<div>
<input id="ac-138" name="accordion-1" type="checkbox" />
    <label for="ac-138">10.1.3. COMO INSERIR ALUNOS A CLASSE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para inserir os  alunos numa classe, vá para a tela inicial de classes cadastradas, selecione a  classe que deseja adicionar os alunos e clique em <img width="77" height="23" src="manual/10.1.3. COMO INSERIR ALUNOS A CLASSE_clip_image002.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Abrirá uma janela  onde poderemos selecionar os alunos e adicionar à classe.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="461" height="222" src="manual/10.1.3. COMO INSERIR ALUNOS A CLASSE_clip_image004.jpg"></span></p>
    </article>
</div>    



<div>
<input id="ac-139" name="accordion-1" type="checkbox" />
    <label for="ac-139">10.1.4. COMO INSERIR UM CONTEÚDO PROGRAMÁTICO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para inserir conteúdo  programático numa classe, vá para a tela inicial de classes cadastradas,  selecione a classe que deseja adicionar os conteúdos programáticos e clique em <img width="157" height="21" src="manual/10.1.4. COMO INSERIR UM CONTEUDO PROGRAMATICO_clip_image002.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Abrirá uma janela  onde poderemos selecionar os conteúdos programáticos e adicionar à classe.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="407" height="197" src="manual/10.1.4. COMO INSERIR UM CONTEUDO PROGRAMATICO_clip_image004.jpg"></span></p>
    </article>
</div>    



<div>
<input id="ac-140" name="accordion-1" type="checkbox" />
    <label for="ac-140">10.1.5. DETALHANDO UMA CLASSE</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para detalhar uma  classe, vá para a tela inicial de classes cadastradas, selecione a classe que  deseja ser detalhada e clique em <img width="84" height="27" src="manual/10.1.5. DETALHANDO UMA CLASSE_clip_image002.jpg">.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Abrirá uma janela  onde poderemos visualizar os alunos, professores e conteúdos programáticos.</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="471" height="252" src="manual/10.1.5. DETALHANDO UMA CLASSE_clip_image004.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Podemos também gerar  uma ficha para impressão clicando em <img width="253" height="33" src="manual/10.1.5. DETALHANDO UMA CLASSE_clip_image006.jpg"></span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="448" height="360" src="manual/10.1.5. DETALHANDO UMA CLASSE_clip_image008.jpg"></span></p>
    </article>
</div>    



<div>
<input id="ac-141" name="accordion-1" type="checkbox" />
    <label for="ac-141">10.2. MENU CONTEÚDO PROGRAMÁTICO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para cadastrar um  conteúdo programático, clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="72" height="24" src="manual/10.2. MENU CONTEUDO PROGRAMATICO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Escola  Bíblica </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="24" height="28" src="manual/10.2. MENU CONTEUDO PROGRAMATICO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de Escola  Bíblica. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="144" height="23" src="manual/10.2. MENU CONTEUDO PROGRAMATICO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="230" height="94" src="manual/10.2. MENU CONTEUDO PROGRAMATICO_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os conteúdos já cadastrados. Clique na aba</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="97" height="28" src="manual/10.2. MENU CONTEUDO PROGRAMATICO_clip_image010.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Informe o título da disciplina, crie um  código para a mesma, informe uma breve descrição acerca da disciplina e informe  a carga horária (em horas). Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/10.2. MENU CONTEUDO PROGRAMATICO_clip_image012.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="330" height="243" src="manual/10.2. MENU CONTEUDO PROGRAMATICO_clip_image014.jpg"></span>
    </article>
</div>   



<div>
<input id="ac-142" name="accordion-1" type="checkbox" />
    <label for="ac-142">10.2.1. COMO ALTERAR UM REGISTRO DE CONTEÚDO PROGRAMÁTICO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Para alterar o  registro de um conteúdo programático, selecione qual registro deverá sofrer a  modificação e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="77" height="27" src="manual/10.2.1. COMO ALTERAR UM REGISTRO DE CONTEUDO PROGRAMATICO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Faça as devidas alterações e clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="74" height="31" src="manual/10.2.1. COMO ALTERAR UM REGISTRO DE CONTEUDO PROGRAMATICO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
    </article>
</div>    



<div>
<input id="ac-143" name="accordion-1" type="checkbox" />
    <label for="ac-143">10.2.2. COMO GERAR UMA FICHA DE CONTEÚDO PROGRAMÁTICO</label>
    <article class="ac-large" style="overflow: auto;">                                    
        <p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Clique no módulo</span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="75" height="25" src="manual/10.2.2. COMO GERAR UMA FICHA DE CONTEUDO PROGRAMATICO_clip_image002.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">, em seguida clique no submódulo de Escola  Bíblica </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="28" height="33" src="manual/10.2.2. COMO GERAR UMA FICHA DE CONTEUDO PROGRAMATICO_clip_image004.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">. Você estará na tela gerencial de Escola  Bíblica. Clique em </span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="144" height="23" src="manual/10.2.2. COMO GERAR UMA FICHA DE CONTEUDO PROGRAMATICO_clip_image006.jpg"></span><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">.</span></p>
<p class="MsoNormal" align="center" style="text-align:center;text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; "><img width="215" height="94" src="manual/10.2.2. COMO GERAR UMA FICHA DE CONTEUDO PROGRAMATICO_clip_image008.jpg"></span></p>
<p class="MsoNormal" style="text-indent:0cm;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">&nbsp;</span></p>
<p class="MsoNormal" style="text-indent:35.4pt;line-height:normal;"><span style="font-family:'Arial','sans-serif'; font-size:12.0pt; ">Irá aparecer a tela  de visualização com os conteúdos programáticos já cadastrados. Selecione o  conteúdo e clique em <img width="99" height="21" src="manual/10.2.2. COMO GERAR UMA FICHA DE CONTEUDO PROGRAMATICO_clip_image010.jpg">. Irá abrir em outra janela a ficha de  cadastro do conteúdo programático.</span></p>
    </article>           
 </div>                   
                    
                    
                    
                    
                    
                    
                    
                    
                </section>
            </fieldset>            
        </div>
    </form>
</body>
</html>





    