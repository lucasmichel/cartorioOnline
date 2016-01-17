/* codificação utf-8 */
function isDataValida(data) {
    //alert(data);
    /******** VALIDA DATA NO FORMATO DD/MM/AAAA *******/

    var regExpCaracter = /[^\d]/;     //ExpressÃ£o regular para procurar caracter nÃ£o-numÃ©rico.
    var regExpEspaco = /^\s+|\s+$/g;  //ExpressÃ£o regular para retirar espaÃ§os em branco.

    if(data.length != 10)
    {
        return false;
    }

    var splitData = data.split('/');

    if(splitData.length != 3)
    {
        return false;
    }

    /* Retira os espaÃ§os em branco do inÃ­cio e fim de cada string. */
    splitData[0] = splitData[0].replace(regExpEspaco, '');
    splitData[1] = splitData[1].replace(regExpEspaco, '');
    splitData[2] = splitData[2].replace(regExpEspaco, '');

    if ((splitData[0].length != 2) || (splitData[1].length != 2) || (splitData[2].length != 4))
    {
        return false;
    }

    /* Procura por caracter nÃ£o-numÃ©rico. EX.: o "x" em "28/09/2x11" */
    if (regExpCaracter.test(splitData[0]) || regExpCaracter.test(splitData[1]) || regExpCaracter.test(splitData[2]))
    {
        return false;
    }

    var dia = parseInt(splitData[0],10);
    var mes = parseInt(splitData[1],10)-1; //O JavaScript representa o mÃªs de 0 a 11 (0->janeiro, 1->fevereiro... 11->dezembro)
    var ano = parseInt(splitData[2],10);

    var novaData = new Date(ano, mes, dia);

    /* O JavaScript aceita criar datas com, por exemplo, mÃªs=14, porÃ©m a cada 12 meses mais um ano Ã© acrescentado Ã  data
    final e o restante representa o mÃªs. O mesmo ocorre para os dias, sendo maior que o nÃºmero de dias do mÃªs em
    questÃ£o o JavaScript o converterÃ¡ para meses/anos.
    Por exemplo, a data 28/14/2011 (que seria o comando "new Date(2011,13,28)", pois o mÃªs Ã© representado de 0 a 11)
    o JavaScript converterÃ¡ para 28/02/2012.
    Dessa forma, se o dia, mÃªs ou ano da data resultante do comando "new Date()" for diferente do dia, mÃªs e ano da
    data que estÃ¡ sendo testada esta data Ã© invÃ¡lida. */
    if ((novaData.getDate() != dia) || (novaData.getMonth() != mes) || (novaData.getFullYear() != ano))
    {
        return false;
    }
    else
    {
        return true;
    }
}

function isEmail(email){
    var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);

    if(typeof(email) == "string"){
        if(er.test(email)){ return true; }
    }else if(typeof(email) == "object"){
        if(er.test(email.value)){
            return true;
        }
    }

    return false;
}

function isCPFValido(cpf){
    var erro = new String;
    cpf = cpf.replace( /[.-]/g, "" );

    if (cpf.length == 11){
        var nonNumbers = /\D/;

        if (nonNumbers.test(cpf))
        {
                return false;
        }
        else
        {
            if (cpf == "00000000000" ||
                    cpf == "11111111111" ||
                    cpf == "22222222222" ||
                    cpf == "33333333333" ||
                    cpf == "44444444444" ||
                    cpf == "55555555555" ||
                    cpf == "66666666666" ||
                    cpf == "77777777777" ||
                    cpf == "88888888888" ||
                    cpf == "99999999999") {

                    return false;
            }

            var a = [];
            var b = new Number;
            var c = 11;

            for (var i=0; i<11; i++){
                    a[i] = cpf.charAt(i);
                    if (i < 9) b += (a[i] * --c);
            }

            var x, y;

            if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }

            b = 0;
            c = 11;

            for (y=0; y<10; y++) b += (a[y] * c--);

            if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

            if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10])) {
                    return false;
            }
        }
    }else{
        if(cpf.length == 0)
            return false
        else
            return false;
    }
    return true;
}

function isCNPJValido(cnpj){
    var result = true;

    // Limpa pontos e TraÃƒÂ§os da string
    cnpj = cnpj.replace(/\./g, "");
    cnpj = cnpj.replace(/\-/g, "");
    cnpj = cnpj.replace(/\_/g, "");
    cnpj = cnpj.replace(/\//g, "");

    if(jQuery.trim(cnpj) != ""){
        if(cnpj.length!=14){ result = false; }

        var pri = eval(cnpj.substring(0,2));
        var seg = eval(cnpj.substring(3,6));
        var ter = eval(cnpj.substring(7,10));
        var qua = eval(cnpj.substring(11,15));
        var qui = eval(cnpj.substring(16,18));

        var i;
        var numero;

        numero = (pri+seg+ter+qua+qui);

        var s = numero;

        var c = cnpj.substr(0,12);

        var dv = cnpj.substr(12,2);
        var d1 = 0;

        for (i = 0; i < 12; i++){
            d1 += c.charAt(11-i)*(2+(i % 8));
        }

        if (d1 == 0){
            result = false;
        }

        d1 = 11 - (d1 % 11);

        if (d1 > 9) d1 = 0;

        if (dv.charAt(0) != d1){
            result = false;
        }

        d1 *= 2;

        for (i = 0; i < 12; i++){
            d1 += c.charAt(11-i)*(2+((i+1) % 8));
        }

        d1 = 11 - (d1 % 11);

        if (d1 > 9) d1 = 0;

        if (dv.charAt(1) != d1){
            result = false;
        }
    }
    if(!result){
        return false;
    }
    return true;
}

function novaJanelaFullscreen(url){    
    window.open(url, '_blank', 'fullscreen=yes, scrollbars=auto');
}

function popUpCentralizado(url,w,h) {
    var newW = w + 100;
    var newH = h + 100;
    var left = (screen.width-newW)/2;
    var top = (screen.height-newH)/2;
    var newwindow = window.open(url, 'name', 'width='+newW+',height='+newH+',left='+left+',top='+top);
    newwindow.resizeTo(newW, newH);

    //posiciona o popup no centro da tela
    newwindow.moveTo(left, top);
    newwindow.focus();
    return false;
}

function isHoraValida(valor){
    var strHora = valor.split(":");
    
    if(strHora.length < 2)
        return false;    
    if (parseInt(strHora[0]) > parseInt(23)){
        return false;
    }else if (parseInt(strHora[1]) > parseInt(59)){
        return false;
    }else{
        return true;
    }
}

function validarHorario(horaInicio, horaFim){
    var aa1=horaInicio.split(":");
    var aa2=horaFim.split(":");
    var d1=new Date(parseInt("2001",10),(parseInt("01",10))-1,parseInt("01",10),parseInt(aa1[0],10),parseInt(aa1[1],10),parseInt(0));
    var d2=new Date(parseInt("2001",10),(parseInt("01",10))-1,parseInt("01",10),parseInt(aa2[0],10),parseInt(aa2[1],10),parseInt(0));
    var dd1=d1.valueOf();
    var dd2=d2.valueOf();
    if(dd1<dd2)    
        return true;    
    else 
        return false;
}

function retornaExtensaoArquivo(file){//string com nome do arquivo
    var extensao = (file.substring(file.lastIndexOf(".")+1)).toLowerCase();
    return extensao;
}

function compararDatas(strDataInicial, strHoraInicial, strDataFinal, strHoraFinal){
    /******** COMPARA DATA NO FORMATO DD/MM/AAAA 00:00 *******/
    //se não quiser informar oo horario, definir as variaves de hora na função como null
    
    var arrayDataInicial = null;
    var arrayHoraInicial = null;
    var arrayDataFinal = null;
    var arrayHoraFinal = null;
    
    
    var datDataInicial = null;
    var datDataFinal = null;
    
    if(strDataInicial != null){
        arrayDataInicial = strDataInicial.split("/");    
    }
    
    if(strHoraInicial != null){
        arrayHoraInicial = strHoraInicial.split(":");
    }
    
    
    if(strDataFinal != null){
        arrayDataFinal = strDataFinal.split("/");    
    }
    
    if(strHoraFinal != null){
        arrayHoraFinal = strHoraFinal.split(":");
    }
        
    
    if(arrayDataInicial == null){
        return false;
    }
    if(arrayDataFinal == null){
        return false;
    }
        
    if(strHoraInicial == null){
        datDataInicial = new Date(arrayDataInicial[2], arrayDataInicial[1], arrayDataInicial[0], 0, 0, 0);
    }
    else{
        datDataInicial = new Date(arrayDataInicial[2], arrayDataInicial[1], arrayDataInicial[0], arrayHoraInicial[0], arrayHoraInicial[1], 0 );
    }
    
    
    
    if(strHoraFinal == null){
        datDataFinal = new Date(arrayDataFinal[2], arrayDataFinal[1], arrayDataFinal[0], 0, 0, 0);
    }
    else{
        datDataFinal = new Date(arrayDataFinal[2], arrayDataFinal[1], arrayDataFinal[0], arrayHoraFinal[0], arrayHoraFinal[1], 0 );
    }
    
    if(datDataInicial<datDataFinal){
        return true;
    }else{
        return false;
    }
    /*
    var dataInicio = new Date();
    
    new Date(year, month, day, hours, minutes, seconds, milliseconds)
    
    
    var x=new Date();
    x.setFullYear(2100,0,14);
    var today = new Date();

    if (x>today)
    {
        alert("Today is before 14th January 2100");
    }
    else
    {
        alert("Today is after 14th January 2100");
    }
  */   
}

function getDataAtual(){  
    var dataAtual;
    $.ajax({
        type: "POST",
        url: "../../sistema/gerencial/controladores/ComumControlador.php",
        dataType: "json",
        async: false,
        data: {ACO_Descricao: "getDataAtual"}
    })
    .done(function( data ) {        
         dataAtual = data.dataAtual;
    });
    return dataAtual;
}

function convertStringDateToDDMMYYYY(str) {
   var mnths = { 
        Jan:"01", Feb:"02", Mar:"03", Apr:"04", May:"05", Jun:"06",
        Jul:"07", Aug:"08", Sep:"09", Oct:"10", Nov:"11", Dec:"12"
    };
    var str = String(str);
    var res = str.split(" ");
    
    return [ res[2], mnths[res[1]], res[3] ].join("/");
}