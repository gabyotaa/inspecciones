/*
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR:  PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
 */

var tipo_transporte  = '';
var idLinea          = '';
var Caja             = '';
var nombreLinea      = '';
var fecha            = '';
var cve_cia          = '';
var tipoInter        = '';
var cajaNoEncontrada = '';
var cve_cia_despacho = '';
var tipo_tractor      = '',
linea_tractor     = '',
tractorExtSel     = '';
window.onload = function() {
  if(sessionStorage.getItem('id_usu') == null || sessionStorage.getItem('id_usu') == ''){
    alerta('ALERTA', 'Plase Login...', 'error');
    window.location="../../../../index.html";
  }
  $("#liCambiarPatio").parent().removeClass("hidden");
};

var padre = $(window.parent.document);
$(document).ready(function(){
  $('#wrapper').load('../cabezera.html');
  cargarLineasCaja();
  cargarLineasTractor();
  $('#selLinea').hide();
  sessionStorage.setItem('datosLin_tra','2');
  window.nombreLinea=$("#selLinea option[value='2']").data('linea');
  sessionStorage.setItem('datosLinea'  ,window.nombreLinea);
  $('#selLinea').val(2);
  /**************************************************************************/
  if ( sessionStorage.getItem('tipo_entrada') == 'E') {
    tipoInter = 'Arrival';
  }else{
    tipoInter = 'Departure';
  }
  // MOSTRAMOS UNA MENSAJE DE RECORDATORIO
  var etiqueta=sessionStorage.getItem('tractor')=='PROPIO'?'OWN':'EXTERNAL';
  mensajes('INFORMATION','Inspection: '+tipoInter+'\n Truck: '+etiqueta,'info');
  // PREPARAMOS EL MODULO
  prepararModulo();
}); // FIN DEL DOCUMENT.READY
function prepararModulo(){
  $('#divAlertaViaje').hide();
  $('#divBotonesInter').hide();
  $('.segundaParte').hide();
  $('.terceraParte').hide();
  $('#selTractorExterno').parent().hide();
  $('#txtTractorLinea').hide();
  $('#groupRdFrio').hide();
  $('#groupRdPipa').hide();
  $('.divNoViaje').hide();
  $('#btnMaximizar').hide();
  $('.ocultar').hide();
  //$('#btnLimpiar').hide();
  if(sessionStorage.getItem('tractor') == 'PROPIO'){ // si tractor es PROPIO que traiga los valores de DATOS
    $('#txtTractorLinea').show();
    $('#txtTractorLinea').val('OWN');
    $("#txtTractorLinea").attr('readonly', 'true');
    linea_tractor = 'PROPIO';
    $("#divPlacaTractor").hide();
  }else{
    $('#selTractorExterno').parent().show();
  }
}

/*$("#frmBuscarCaja").submit(function(event){
event.preventDefault();
limpiarPantalla();
if(validarQR($('#txtCaja').val())==0&&validarCaja($('#txtCaja').val())!=0){
window.Caja        =  $("#txtCaja").val().toUpperCase();
$('.segundaParte').show();
$('#selLinea').show();
}else{
if(validarQR($('#txtCaja').val())==1){
//procesar qr
}
}
/*if( validarCaja($('#txtCaja').val().toUpperCase() ) !=  0 ){
buscarLinea($('#txtCaja').val().toUpperCase() );

$('#txtCaja').val($('#txtCaja').val().toUpperCase());
}


});*/

/*$('#txtCaja').change(function(event){
if(validarQR($('#txtCaja').val())==1||validarCaja($('#txtCaja').val())==1){
alert("entro");
$('.segundaParte').show();
$('#selLinea').show();
}
});*/
$('#txtCaja').keyup(function(event){
  //sessionStorage.setItem('tipo_transporte','');
  //sessionStorage.setItem('datosLin_tra','');
  sessionStorage.setItem('FRE_Marca_Thermo','');
  sessionStorage.setItem('datosPlacas','');
  $("#groupRdPipa").fadeOut('fast');
  $('.terceraParte').hide();
  $('#selLinea').hide();
  $('.segundaParte').hide();
  $('#divBotonesInter').hide('fast');
  if(validarQR($('#txtCaja').val())==1||validarCaja($('#txtCaja').val())==1){
    $('.segundaParte').show();
    $("#btnPRIME").trigger('click');
    $('#selLinea').show();
    if( $('#selLinea').val()!=''){
      $("#groupRdPipa").fadeIn('fast');
      $('#divBotonesInter').show('fast');
      $('.terceraParte').show();
    }
    //sessionStorage.setItem()

    $('#btnPipa').prop('disabled',false);
    $('#btnPRIME').prop('disabled',false);
    $("#selLinea").prop('disabled',false);
    if(validarQR($('#txtCaja').val())==1){
      var datos=$('#txtCaja').val().split('/');
      $('#txtCaja').val(datos[0]);
      var id_linea_caja=datos[1];
      sessionStorage.setItem('datosLin_tra',id_linea_caja);
      window.nombreLinea=$("#selLinea option[value='"+id_linea_caja+"']").data('linea');
      sessionStorage.setItem('datosLinea'  ,window.nombreLinea);
      $("#selLinea").val(id_linea_caja);
      $("#selLinea").prop('disabled',true);
      window.idLinea=id_linea_caja;
      var placas_caja=datos[2];
      sessionStorage.setItem('datosPlacas',placas_caja);
      var tipo_transporte=datos[3];
      sessionStorage.setItem('tipo_transporte',tipo_transporte);
      switch (tipo_transporte){
        case 'PIPA':{
          $("#btnPipa").addClass('active');
          $("#btnPRIME").removeClass('active');
          $("#btnPlataforma").removeClass('active');
        }break;
        case 'FRIO':{
          $("#btnPRIME").addClass('active');
          $("#btnPipa").removeClass('active');
          $("#btnPlataforma").removeClass('active');
        }break;
        case 'PLATAFORMA':{
          $("#btnPlataforma").addClass('active');
          $("#btnPipa").removeClass('active');
          $("#btnPRIME").removeClass('active');
        }break;
      }
      $("#groupRdPipa").fadeIn('fast');
      $('#btnPipa').prop('disabled',true);
      $('#btnPRIME').prop('disabled',true);
      $('#btnPlataforma').prop('disabled',true);
      $('#divBotonesInter').show('fast');
      $('.terceraParte').show();
      if(datos.length==5){
        var marca_thermo=datos[4];
        sessionStorage.setItem('FRE_Marca_Thermo',marca_thermo);
      }

    }

  }
});

$('#selTractorExterno').change(function(event) {
  tractorExtSel = $(this).val();

  if(tractorExtSel == 'OTRO'){
    $('#txtTractorLinea').show();
    //$(this).hide();
    linea_tractor = '';
  }else{
    $('#txtTractorLinea').hide();
  }
});

function limpiarPantalla(){
  $('#selLinea').hide();
  $('.segundaParte').hide();
  $('.terceraParte').hide();
  $('.terceraParte:input').val('');
  $('#divBotonesInter').hide('fast');
  $("#groupRdPipa").fadeOut('fast');
  $('#selLinea').val("");
  tipo_transporte = "";
  window.Caja ="";
  $(".btn").removeClass('active');
  $(".btn").removeClass('disabled');
}

function cargarLineasCaja(){
  $.ajax({
    type: 'POST',
    url: ubicacionURL+'main.php',
    data:{metodo:'lineasCaja'},
    dataType : 'json',
    async : false,
    success: renderLineasCaja,
    error: function(jqXHR, exception) {
      erroresAjax(jqXHR, exception);
    }
  });

}

function cargarLineasTractor(){
  $.ajax({
    type: 'POST',
    url: ubicacionURL+'main.php',
    data:{metodo:'lineasTractor'},
    dataType : 'json',
    async : false,
    success: renderLineasTractor,
    error: function(jqXHR, exception) {
      erroresAjax(jqXHR, exception);
    }
  });
}

function renderLineasCaja(data){
  if(data!='0'){
    var list = data == null ? [] : (data.lineas instanceof Array ? data.lineas : [data.lineas]);
    var renderSelect = '<option value="" selected="">Select Id...</option>';
    $.each(list, function(index, linea) {

      renderSelect += '<option data-id_linea_caja="'+linea.ID_LINEA_CAJA+'" data-linea="'+linea.LINEA+'"  value="'+linea.ID_LINEA_CAJA+'">'+linea.LINEA+'</option>';
    });

    $("#selLinea").append(renderSelect);
  }else{
    var renderSelect = '<option value="" selected="">NOT FOUND ANY TRAILER ID, PLEASE ADD</option>';
    $("#selLinea").append(renderSelect);
  }

}

function renderLineasTractor(data){
  if(data!='0'){
    var list = data == null ? [] : (data.lineas instanceof Array ? data.lineas : [data.lineas]);
    var renderSelect = '<option value="" selected="">Select Carrier...</option>';
    $.each(list, function(index, linea) {
      if(linea.ID_LINEA_TRACTOR!=1 && linea.ID_LINEA_TRACTOR!='1'){
        renderSelect += '<option data-id_linea_tractor="'+linea.ID_LINEA_TRACTOR+'" data-linea="'+linea.LINEA+'"  value="'+linea.ID_LINEA_TRACTOR+'">'+linea.LINEA+'</option>';
      }
    });
    renderSelect += '<option  value="OTRO">Other Carrier</option>';
    $("#selTractorExterno").append(renderSelect);
  }else{
    var renderSelect = '<option value="" selected="">Select Carrier...</option>';
    renderSelect += '<option  value="OTRO">Other Carrier</option>';
    $("#selTractorExterno").append(renderSelect);
  }

}

function validarQR(valor){
  var datos=valor.split('/');
  if(datos.length<4 || datos.length>5){
    return 0;
  }else{
    if(validarCaja(datos[0])==0){
      return 0;
    }else{
      numeros= /^[0-9]+$/;
      if(numeros.test(datos[1])==false){
        return 0;
      }else{
        if(datos[2].length<6){//PLACAS
          return 0;
        }else{
          if(datos[3]!='PIPA'&&datos[3]!='FRIO'&&datos[3]!='PLATAFORMA'){
            return 0;
          }else{
            if(datos.length==5 && datos[4]==""){
              return 0;
            }else{
              return 1;
            }
          }
        }
      }
    }
  }
}

function validarCaja(valor) {
  var patron=/[\^$-.<>*+?=!:|\\/,()\[\]{}]/;
  if (valor == ''){
    return 0;
  }else if(buscarEspacioBlanco(valor,' ','') == 0){
    return 0;
  }else if(patron.test(valor)){
    return 0;
  }else if(valor.length <= 3){
    return 0;
  }else{
    return 1;
  }
}
function validarCajaMensaje(valor) {
  var patron=/[\^$-.<>*+?=!:|\\/,()\[\]{}]/;
  if (valor == ''){
    alerta('ALERT', 'TRAILER NUMBER IS MISSING', 'warning');
    return 0;
  }else if(buscarEspacioBlanco(valor,' ','') == 0){
    alerta('ALERT', 'TRAILER NUMBER CONTAINS BLANK SPACES, PLEASE CORRECT', 'warning');
    return 0;
  }else if(patron.test(valor)){
    alerta('ALERT', 'TRAILER NUMBER CONTAINS INVALID CHARACTERS', 'warning');
    return 0;
  }else if(valor.length <= 3){
    alerta('ALERT', 'TRAILER NUMBER LENGTH IS LESS THAN 3 CHARACTERS', 'warning');
    return 0;
  }else{
    return valor;
  }
}
$('#btnLimpiar').click(function(event) {
  limpiarFormulario();
});

function buscarEspacioBlanco(texto,encontrar,nuevo){
  var cadena = '';
  var i      = 0;
  while(i<texto.length){
    if(texto[i] != encontrar)// Si el carácter de la cadena es igual al carácter a remplazar
    {
      // si es diferente simplemente concatena el carácter original de la cadena original.
      cadena = cadena + texto[i];
    }else{
      // si no es diferente concatena el carácter que introdujiste a remplazar
      cadena = cadena + nuevo;
      return 0; // REGRESAMOS 0 PORQUE LA CADENA SI TIENE UNA ESPACIO EN BLANCO
    }
    i++;
  } // Fin del while
  // return cadena;
}


function validarLinea(idlinea){
  /*switch (idlinea) {
  case '1':
  $("#groupRdPipa").fadeOut('fast');
  $("#groupRdFrio").fadeIn('fast');
  break;
  case '2':
  $("#groupRdFrio").fadeOut('fast');
  $("#groupRdPipa").fadeIn('fast');
  break;
  default:
  $("#groupRdPipa").fadeOut('fast');
  $("#groupRdFrio").fadeIn('fast');
}*/
$("#groupRdPipa").fadeIn('fast');
}
function validarTipoTransporte(idLinea,tipo_transporte){
  /*if(idLinea == '1'){
  if(tipo_transporte == ''){
  alerta('Alerta','<strong>DEBE SELECCIONAR SI ES FRIO O SECO.</strong>','warning');
  return 0;
}
}
if(idLinea == '2'){
if(tipo_transporte == ''){
alerta('Alerta','<strong>DEBE SELECCIONAR SI ES PIPA O CAJA.</strong>','warning');
return 0;
}
}*/
if(tipo_transporte==''){
  alerta('Alert','<strong>PLEASE SELECT TRAILER TYPE</strong>','warning');
  return 0;
}
}

function validarTractor(){
  if($("#txtNoTractor").val()==""){
    alerta('Alert','<strong>PLEASE ENTER TRUCK NUMBER</strong>','warning');
    return 0;
  }
  if(($("#txtPlacas").val()=='' || $("#txtPlacas").val().length<6) && (sessionStorage.getItem('tractor')!='PROPIO')){
    alerta('Alert','<strong>PLEASE ENTER PLATE NUMBER</strong>','warning');
    return 0;
  }
  if(sessionStorage.getItem('tractor') == "EXTERNO"){
    if($('#selTractorExterno').val() == ''){ // SI NO HA SELECCIONADO NADA
      alerta('Alert','<strong>PLEASE SELECT TRACTOR ID</strong>','warning');
      //alerta('Debe seleccionar el la linea del tractor');
      return 0;
    }else{

      if(tractorExtSel == 'OTRO'){
        // SI SELECCIONO OTRO TOMAR EL VALOR DEL TXT
        if($('#txtTractorLinea').val()==''){
          alerta('Alert','<strong>PLEASE ENTER TRACTOR ID</strong>','warning');
          return 0;
        }else{
          linea_tractor = $('#txtTractorLinea').val();
        }

      }else{
        linea_tractor = $('#selTractorExterno').val();  // SI SELECCIONO OTRA OPCION TOMA SU VALOR
      }

    }
  }else{
    if($('#txtTractorLinea').val()==''){
      alerta('Alert','<strong>PLEASE ENTER TRACTOR ID</strong>','warning');
      return 0;
    }else{
      linea_tractor = $('#txtTractorLinea').val();
    }

  }
}

$('#btnCompleto').click(function(event) {
  if(validarTipoTransporte(sessionStorage.getItem('datosLin_tra'), sessionStorage.getItem('tipo_transporte')) == 0){
    return false;
  }

  if(validarTractor()==0){
    return false;
  }
  if(validarCajaMensaje($("#txtCaja").val())==0){
    return false;
  }
  //$(this).addClass('disabled');
  window.Caja =  $("#txtCaja").val().toUpperCase();
  $("#iContinuar").addClass('fa fa-spinner fa-spin');
  sessionStorage.setItem('datosCOMPLETO', "COMPLETO");
  sessionStorage.setItem('caja', window.Caja);
  sessionStorage.setItem('NoTractor',$('#txtNoTractor').val());
  sessionStorage.setItem('linea_tractor',linea_tractor.toUpperCase());
  sessionStorage.setItem('placas_tractor', $('#txtPlacas').val().toUpperCase());
  sessionStorage.setItem('tractorExtSel',tractorExtSel);
  //sessionStorage.setItem('noViaje',$('#txtNoViaje').val());
  $.blockUI({
    message: '<h1><img src="../../img/ajax-loader.gif" /> Wait...</h1>' ,
    onBlock: function() {
      obtenerInformacion(sessionStorage.getItem('tipo_entrada'),  $("#txtCaja").val(), sessionStorage.getItem('datosLin_tra'), window.nombreLinea, $('#txtNoTractor').val(), linea_tractor, sessionStorage.getItem('idpatio'));
    }
  });

});
/**********BOTONES HORIZONTALES PARA SABER QUE TIPO TRANSPORTE ES***************/
/*$('#btnFrio').click(function(event) {
$('#btnFrio').addClass('active');
$('#btnSeco').removeClass('active');
tipo_transporte = "FRIO";
sessionStorage.setItem('tipo_transporte',tipo_transporte);

});
$('#btnSeco').click(function(event) {
$('#btnSeco').addClass('active');
$('#btnFrio').removeClass('active');
tipo_transporte = "SECO";
sessionStorage.setItem('tipo_transporte',tipo_transporte);
});*/
$('#btnPipa').click(function(event) {
  $('#btnPipa').addClass('active');
  $('#btnPRIME').removeClass('active');
  $('#btnPlataforma').removeClass('active');
  tipo_transporte = "PIPA";
  sessionStorage.setItem('tipo_transporte',tipo_transporte);
  $('#divBotonesInter').show('fast');
  $('.terceraParte').show();
});
$('#btnPRIME').click(function(event) {
  $('#btnPRIME').addClass('active');
  $('#btnPipa').removeClass('active');
  $('#btnPlataforma').removeClass('active');
  tipo_transporte = "FRIO";
  sessionStorage.setItem('tipo_transporte',tipo_transporte);
  $('#divBotonesInter').show('fast');
  $('.terceraParte').show();
});
$('#btnPlataforma').click(function(event) {
  $('#btnPlataforma').addClass('active');
  $('#btnPipa').removeClass('active');
  $('#btnPRIME').removeClass('active');
  tipo_transporte = "PLATAFORMA";
  sessionStorage.setItem('tipo_transporte',tipo_transporte);
  $('#divBotonesInter').show('fast');
  $('.terceraParte').show();
});
/******************************************************************************/
/*$('#selLineaSinCaja').change(function(event) {
window.nombreLinea =  $(this).children('option:selected').attr('data-nombre').trim();
window.idLinea     =  $(this).children('option:selected').attr('data-idlinea').trim();
window.cve_cia     =  $(this).children('option:selected').attr('data-cve_cia').trim();
window.cve_lineatras     =  $(this).children('option:selected').attr('data-cve_lineatras').trim();
window.Caja        =  $("#txtCaja").val().toUpperCase();
sessionStorage.setItem('datosLin_tra',window.idLinea.trim());
sessionStorage.setItem('datosLinea'  ,window.nombreLinea);
sessionStorage.setItem('cve_cia'  ,window.cve_cia);
sessionStorage.setItem('cve_lineatras'  ,window.cve_lineatras);
buscarViaje(window.idLinea, $('#txtCaja').val(),'01',cajaNoEncontrada,window.nombreLinea,sessionStorage.getItem('tipo_entrada'));
});*/
$('#selLinea').change(function(event) {
  $("#groupRdPipa").fadeOut('fast');
  if($(this).val()!=''){
    window.nombreLinea =  $(this).children('option:selected').attr('data-linea').trim();
    window.idLinea     =  $(this).children('option:selected').attr('data-id_linea_caja').trim();
    //window.Caja        =  $("#txtCaja").val().toUpperCase();
    sessionStorage.setItem('datosLin_tra',window.idLinea.trim());
    sessionStorage.setItem('datosLinea'  ,window.nombreLinea);
    validarLinea(window.idLinea);
  }


});
/******BOTON DE INCOMPLETO PRINCIPAL********/
$('#btnIncompleto').click(function(event) {
  if(validarTipoTransporte(sessionStorage.getItem('datosLin_tra'), sessionStorage.getItem('tipo_transporte')) == 0){
    return false;
  }


  if(validarTractor()==0){
    return false;
  }
  if(validarCajaMensaje($("#txtCaja").val())==0){
    return false;
  }
  window.Caja =  $("#txtCaja").val().toUpperCase();
  sessionStorage.setItem('datosCOMPLETO', "INCOMPLETO");
  sessionStorage.setItem('caja', window.Caja);
  sessionStorage.setItem('NoTractor',$('#txtNoTractor').val());
  sessionStorage.setItem('linea_tractor',linea_tractor.toUpperCase());
  sessionStorage.setItem('placas_tractor', $('#txtPlacas').val().toUpperCase());
  sessionStorage.setItem('tractorExtSel',tractorExtSel);
  //sessionStorage.setItem('noViaje',$('#txtNoViaje').val());
  $('#mdlIncompleto').modal('show');
  $('#datetimepicker1').datetimepicker({
    format: 'YYYY-MM-DD HH:mm'
  });
  $('#datetimepicker1').data("DateTimePicker").show();

});

function esRealLaFecha(fecha){
  if (fecha == ""){
    mensajes('Alerta','Debe Seleccionar una fecha','error');
    return false;
  }
  var fechaf = fecha.split("-");
  var anio = fechaf[0];
  var mes = fechaf[1];
  var dia=fechaf[2].substring(0,2);
  var tiempo =  fechaf[2].substring(fechaf[2].length - 5).split(":");
  var hora = tiempo[0];
  var minuto = tiempo[1];
  var fecha_dada=new Date(anio,parseInt(mes)-1,dia,hora,minuto,0,0);
  //alert(fecha_dada);
  //////////////////////////////
  var dateObj = new Date();
  var curr_date = dateObj.getDate();
  var curr_month = dateObj.getMonth();
  curr_month = curr_month + 1;
  var curr_year = dateObj.getFullYear();
  var curr_min = dateObj.getMinutes();
  var curr_hr= dateObj.getHours();
  var curr_sc= dateObj.getSeconds();
  if(curr_month.toString().length == 1)
  curr_month =  '0'+curr_month;
  if(curr_date.toString().length == 1)
  curr_date =  '0'+curr_date;
  if(curr_hr.toString().length == 1)
  curr_hr =  curr_hr;
  if(curr_min.toString().length == 1)
  curr_min =  curr_min;
  curr_sc = (curr_sc<10)?curr_sc:curr_sc;

  //////////////////////////////
  /*if(mes != curr_month){
  alerta("ALERTA","EL MES SELECCIONADO NO ES CORRECTO","warning");
  return false;
}else{
if(dia>curr_date){
alerta("ALERTA","EL DIA SELECCIONADO NO ES CORRECTO","warning");
return false;
}
}*/
if(fecha_dada>new Date()){
  alerta("ALERTA","NO SE PUEDE SELECCIONAR UNA FECHA POSTERIOR A LA ACTUAL","warning");
  return false;
}
}


function obtenerInformacion(status, caja, idlinea, nombreLinea, noTractor, lineaTractor, idPatio  ){
  if (status === 'E') {
    //var metodo = 'validarEntrada';
    var valores = "metodo=validarEntradaCaja&caja="+caja+"&linea="+idlinea+"&id_patio="+idPatio;
  }else{
    //var tipo = 'salida2.php';
    var valores = "metodo=validarSalidaCaja&caja="+caja+"&linea="+idlinea+"&id_patio="+idPatio;
  }
  
  $.ajax({
    type: "POST",
    url: ubicacionURL+'main.php',
    data: valores, //Parametro enviados a la acción
    async: false,
    success: function(data){
      // console.log(data.length);
      
      if(data == 0) {
        $.unblockUI();

        alerta('Alert','<strong>THE TRAILER NUMBER YOU ENTERED IS NOT AT THIS LOCATION</strong>','warning');
        limpiarFormulario();
        return false;
      }else if(jQuery.parseJSON(data).hasOwnProperty('FECHA')){ // ERROR QUE MANDA DESDE ENTRADA.PHP POR NO DAR SALIDA AL INTERCAMBIO ANTERIOR
        console.log(data);
        data= jQuery.parseJSON(data);
        $.unblockUI();
        alerta('Alerta','<strong>YOU HAVE TO REGISTER A DEPARTURE BEFORE YOU ENTER AN ARRIVAL \n LAST ARRIVAL REGISTERED WAS: '+data.FECHA+'</strong>','warning');
        //   mensajes('Alerta','<strong>FALTA CAPTURAR LA SALIDA DE ESTA CAJA EN EL INTERCAMBIO ANTERIOR</strong>','error');
        limpiarFormulario();
        return false;
      }else{
        console.log(data);
        data= jQuery.parseJSON(data);
        /**TRAIDA DEL JSON**/
        if (status === 'S' || status === 'SR') {//SR salida rapida
          sessionStorage.setItem('id_intercambio_entrada_caja',data.ID_INTERCAMBIO);
          if(sessionStorage.getItem("tractor")!='PROPIO'){
            buscarEntradaTractor(sessionStorage.getItem('idpatio'),noTractor,sessionStorage.getItem('linea_tractor'),sessionStorage.getItem('tractorExtSel'),$('#txtfechaIncompleto').val(), sessionStorage.getItem('datosCOMPLETO'));
          }else{
            buscarEntradaTractor(sessionStorage.getItem('idpatio'),noTractor,1,'',$('#txtfechaIncompleto').val(), sessionStorage.getItem('datosCOMPLETO'));
          }
        }
        if(sessionStorage.getItem("tractor")=='PROPIO'){
          //validarIntercambioTractor(status,noTractor,1,lineaTractor,sessionStorage.getItem("tractor"),idPatio);
          insertarIntercambio(
            window.Caja,
            sessionStorage.getItem('datosLin_tra'),
            sessionStorage.getItem('tipo_entrada'),
            $('#txtfechaIncompleto').val(),
            sessionStorage.getItem('datosCOMPLETO'),
            sessionStorage.getItem('idpatio'),
            sessionStorage.getItem('idusuario'),
            sessionStorage.getItem('NoTractor'),
            1
          );
        }else{
          /*****************INSERT EN TABLA INTENTRADAS E INTSALIDAS****************/
          if(sessionStorage.getItem('tractorExtSel')=="OTRO"){
            insertarIntercambio(
              window.Caja,
              sessionStorage.getItem('datosLin_tra'),
              sessionStorage.getItem('tipo_entrada'),
              $('#txtfechaIncompleto').val(),
              sessionStorage.getItem('datosCOMPLETO'),
              sessionStorage.getItem('idpatio'),
              sessionStorage.getItem('idusuario'),
              sessionStorage.getItem('NoTractor'),
              ''
            );
          }else{
            insertarIntercambio(
              window.Caja,
              sessionStorage.getItem('datosLin_tra'),
              sessionStorage.getItem('tipo_entrada'),
              $('#txtfechaIncompleto').val(),
              sessionStorage.getItem('datosCOMPLETO'),
              sessionStorage.getItem('idpatio'),
              sessionStorage.getItem('idusuario'),
              sessionStorage.getItem('NoTractor'),
              sessionStorage.getItem('linea_tractor')
            );
          }

        }
        /*****FIN JSON******/


        /***************** FIN DE LA FUNCION INSERTAR INTERCAMBIO ****************/
      } // FIN DEL ELSE

      //  $.unblockUI();
    },
    error: function(jqXHR, exception){

      erroresAjax(jqXHR, exception);
    }
  });
}

function buscarEntradaTractor(patio, noTractor, linea_tractor, otra_linea, fecha, tipoReg){
  var valores="metodo=buscarEntradaTractor&no_tractor="+noTractor+"&id_linea="+linea_tractor+"&otra_linea="+otra_linea+"&patio="+patio+"&fecha="+fecha+"&tipo_reg="+tipoReg;
  $.ajax({
    type: "GET",
    url: ubicacionURL+'main.php',
    data: valores, //Parametro enviados a la acción
    async: false,

    success: function(data){
      if(data!='-1' && data!='0' && data!=0){
        data= jQuery.parseJSON(data);
        sessionStorage.setItem('id_intercambio_entrada_tractor',data.ID_INTERCAMBIO);
      }else{
        sessionStorage.setItem('id_intercambio_entrada_tractor','0');
      }
    },
    error: function(jqXHR, exception){

      erroresAjax(jqXHR, exception);
    }
  });
}

function validarIntercambioTractor(status ,noTractor,idLineaTractor,lineaTractor,tipo_tractor, idPatio){
  if (status === 'E') {
    //var metodo = 'validarEntrada';
    var valores = "metodo=validarEntradaTractor&no_tractor="+noTractor+"&id_linea="+idLineaTractor+"&linea_tractor="+lineaTractor+"&tipo_tractor="+tipo_tractor+"&id_patio="+idPatio;
  }else{
    //var tipo = 'salida2.php';
    var valores = "metodo=validarSalidaTractor&no_tractor="+noTractor+"&id_linea="+idLineaTractor+"&linea_tractor="+lineaTractor+"&tipo_tractor="+tipo_tractor+"&id_patio="+idPatio;
  }
  $.ajax({
    type: "POST",
    url: ubicacionURL+'main.php',
    data: valores, //Parametro enviados a la acción
    async: false,

    success: function(data){
      // console.log(data.length);
      if(data == 0) {
        $.unblockUI();
        alerta('Alerta','<strong>EL TRACTOR NO HA TENIDO REGISTRO DE ENTRADA, COMPLETE LA ENTRADA PARA PODER CAPTURAR SU SALIDA.</strong>','warning');
        limpiarFormulario();

        return false;
      }else if(jQuery.parseJSON(data).hasOwnProperty('FECHA')){ // ERROR QUE MANDA DESDE ENTRADA.PHP POR NO DAR SALIDA AL INTERCAMBIO ANTERIOR
        console.log(data);
        data= jQuery.parseJSON(data);
        $.unblockUI();
        alerta('Alerta','<strong>FALTA CAPTURAR LA SALIDA DE ESTE TRACTOR EN EL INTERCAMBIO ANTERIOR \n CON FECHA : '+data.FECHA+'</strong>','warning');
        //   mensajes('Alerta','<strong>FALTA CAPTURAR LA SALIDA DE ESTA CAJA EN EL INTERCAMBIO ANTERIOR</strong>','error');
        limpiarFormulario();

        return false;
      }else{
        data= jQuery.parseJSON(data);
        /**TRAIDA DEL JSON**/
        if (status === 'S') {
          sessionStorage.setItem('id_intercambio_entrada_tractor',data.ID_INTERCAMBIO);

        }

        /*****FIN JSON******/
        /*****************INSERT EN TABLA INTENTRADAS E INTSALIDAS****************/
        insertarIntercambio(
          window.Caja,
          sessionStorage.getItem('datosLin_tra'),
          sessionStorage.getItem('tipo_entrada'),
          $('#txtfechaIncompleto').val(),
          sessionStorage.getItem('datosCOMPLETO'),
          sessionStorage.getItem('idpatio'),
          sessionStorage.getItem('idusuario'),
          sessionStorage.getItem('NoTractor'),
          idLineaTractor
        );

        /***************** FIN DE LA FUNCION INSERTAR INTERCAMBIO ****************/
      } // FIN DEL ELSE

      //  $.unblockUI();
    },
    error: function(jqXHR, exception){

      erroresAjax(jqXHR, exception);
    }
  });
}

function limpiarFormulario(){
  //$('.divNoViaje').hide();
  $('#divBotonesInter').hide();
  //$('#groupRdFrio').hide();
  $('#groupRdPipa').hide();
  $('.segundaParte').hide();
  $('.terceraParte').hide();
  tipo_transporte = '';
  $('#txtCaja').val('');
  /*$('#selLinea option').remove();
  $('#selLinea').append('<option value="">Seleccionar...</option>');
  $('#txtNoViaje').val('');
  $('#btnBuscarLinea').show();*/
  $(".btn").removeClass('active');
  $(".btn").removeClass('disabled');
  $("#mdlIncompleto").modal("hide");
  //$('#divAlertaViaje').hide();
  //$('#btnLimpiar').hide();
  /*$('#selLineaSinCaja').hide();
  $('#selLineaSinCaja').val('');*/
  $("#iIncContinuar").removeClass('fa fa-spinner fa-spin');
  sessionStorage.setItem('FRE_Marca_Thermo','');
  sessionStorage.setItem('datosPlacas','');
  $('#btnPipa').prop('disabled',false);
  $('#btnPRIME').prop('disabled',false);
  $("#selLinea").prop('disabled',false);
  $("#selLinea").val("");
  sessionStorage.setItem('datosLin_tra','2');
  sessionStorage.setItem('datosLinea'  ,'PRIME INC');
  sessionStorage.setItem('tipo_transporte','');
  $("#txtNoTractor").val("");
  $("#txtPlacas").val("");
  $(padre).find("#liLoader").hide();
}
function insertarIntercambio(caja,id_linea_caja,tipo_entrada,fecha,tipo_reg,id_patio,id_usuario,noTractor,id_linea_tractor){
  var valores = "metodo=insertarIntercambio&caja="+caja+"&id_linea_caja="+id_linea_caja+"&tipo="+tipo_entrada+"&tipo_reg="+tipo_reg;
  valores = valores + "&id_patio="+id_patio+"&id_usuario="+id_usuario+"&no_tractor="+noTractor+"&id_linea_tractor="+id_linea_tractor;
  valores+="&id_horario="+sessionStorage.getItem('id_horario')+"&horario="+sessionStorage.getItem("horario");

  if(tipo_reg == "INCOMPLETO"){
    valores = valores + "&fecha="+fecha;
  }
  $.ajax({
    type: "GET",
    url: ubicacionURL+'main.php',
    data: valores,
    success: function(data){
      //console.log(data);
      if (data == 0 || data.length>16) {
        mensajes('Alerta','<strong>OCURRIO UN ERROR, INTENTELO NUEVAMENTE MAS TARDE</strong>','error');
        $.unblockUI();
        return false;
      }else{
        mensajes('¡Well Done!','continue...','success');
        sessionStorage.setItem('id_intercambio',data.trim());
        sessionStorage.setItem('datosFecha',fecha);

        setTimeout(function() {
          if(tipo_entrada=='SR'){
            window.location="../recorrido/index.html";
          }else{
            window.location = "../ladoinicial/index.html";
          }
          
        }, 600);
      }
    },
    error: function(jqXHR, exception){
      erroresAjax(jqXHR, exception);
    }
  });

}
/******BOTON CONTINUAR DEL MODAL INCOMPLETO********/
$('#btnIncContinuar').click(function(event) {
  fecha = $('#txtfechaIncompleto').val();
  if(esRealLaFecha(fecha) != false){
    $(this).addClass('disabled');
    $("#iIncContinuar").addClass('fa fa-spinner fa-spin');
    obtenerInformacion(sessionStorage.getItem('tipo_entrada'),  $("#txtCaja").val(),  sessionStorage.getItem('datosLin_tra'), window.nombreLinea, $('#txtNoTractor').val(), linea_tractor, sessionStorage.getItem('idpatio'));

  }
});
