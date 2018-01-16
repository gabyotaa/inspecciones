/*
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR: PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
 */
var tipo_tractor      = '',
    linea_tractor     = '',
    tractorExtSel     = '',
    apiFirma          = '',
    cadenaFirma       = 'SIN_FIRMA',
    rutaFoto          = '',
    idtractor_e       = '';
var listaOperadores={};
    bandIniciarFirma=0;
$(document).ready(function(){

  /*var img = document.getElementById('sigPad');
  var cs = getComputedStyle(img);
  var width = parseInt(cs.getPropertyValue('width'), 10);
  var height = parseInt(cs.getPropertyValue('height'), 10);
  var el=$("#sigPad");
  console.log(el.width());*/
  /*alert($('#sigPad').width());
    alert($('#sigPad').outerWidth());
    alert($('#sigPad').innerWidth());*/
  window.ubicacionURL    =  sessionStorage.getItem('ubicacionURL');
 $("#txtNoOperador").val('0'); //porque en prime no hay numero de operador
 /*var canvas= $("#pad");
  /*canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
 canvas.width=$("#pad").parent().width();*/

 /*$('#txtNombre').typeahead({
     local: listaOperadores
 });*/
 $('.tt-query').css('background-color','#fff');



/************************************************************/


if(sessionStorage.getItem('tractor') != 'PROPIO'){
    $("#txtNoOperador").val('0');

}



if(sessionStorage.getItem('tipo_transporte') == 'PIPA' || sessionStorage.getItem('tipo_transporte') == 'SECO' || sessionStorage.getItem('tipo_transporte') == 'PLATAFORMA' ){
     $("#txtGatas").attr('readonly', 'true');
     $("#txtGatas").val('0');
}
 /***********METODO DE LA FIRMA************/
 // apiFirma = $('.sigPad').signaturePad({drawOnly:true,lineTop:150});
 /****************************************/
 //$("#signature").jSignature();
// findByName('');
//TAMAÑO FIRMA
//Get the canvas &
    /*var c = $("#pad");
    c.attr('width','500px');
    var container = $(c).parent();

    //Run function when browser resizes
    $(window).resize( respondCanvas );
    console.log($(container).width());
    console.log($(".sigPad").width());
    console.log($(".sigPad").innerWidth());
    console.log($("#txtSalidaFirma").width());
    function respondCanvas(){
        c.attr('width', $(container).width() ); //max width
        c.attr('height', $(container).height() ); //max height

        //Call a function to redraw other content (texts, images etc)
    }

    //Initial call
    respondCanvas();*/

}); // FIN DEL DOCUMENT READY






$('#btn_gatas_minus').click(function(event) {
  if(parseInt($('#txtGatas').val())>0){
    $('#txtGatas').val(parseInt($('#txtGatas').val())-1);
  }
});

$('#btn_gatas_plus').click(function(event) {
  $('#txtGatas').val(parseInt($('#txtGatas').val())+1);
});

$('#btnListo').click(function(event) {

  if($('#txtNombre').val().length < 1 || $('#txtNombre').val() == ''){
     /*alert('You Must Complete DRIVER FIRST NAME');*/
     alerta('Alert','<strong>PLEASE ENTER DRIVER FIRST NAME</strong>','warning');
     return false;
  }
  if($('#txtApePat').val().length < 1 || $('#txtNombre').val() == ''){
     /*alert('You Must Complete DRIVER LAST NAME');*/
     alerta('Alert','<strong>PLEASE ENTER DRIVER LAST NAME</strong>','warning');
     return false;
  }
  if ($('#txtGatas').val().length<1 || $('#txtGatas').val() == '') {
     /*alert('You Must Complete LOAD LOCKS');*/
     alerta('Alert','<strong>PLEASE ENTER LOAD LOCKS</strong>','warning');
    return false;
  }
  /*if(sessionStorage.getItem('tractor') == 'PROPIO'){
    if($('#txtNoOperador').val() == '' || $('#txtNoOperador').val() == 0){
       alert('Debe completar el campo NUMERO OPERADOR');
       return false;
    }
  }*/




  $('#btnListo').addClass('disabled');
  $("#iListo").addClass('fa fa-spinner fa-spin');
  sessionStorage.setItem('OPE_NoOpe',$('#txtNoOperador').val());
  sessionStorage.setItem('OPE_Nombre',$('#txtNombre').val().toUpperCase());
  sessionStorage.setItem('OPE_APE_PAT',$('#txtApePat').val().toUpperCase());
  sessionStorage.setItem('OPE_NoGatas',$('#txtGatas').val());
  sessionStorage.setItem('OPE_PASANTE','true');

  var padre = $(window.parent.document);
  $(padre).find("#divOperador").removeClass('active');
  $(padre).find("#liOperador").removeClass('active');
  $(padre).find("#liOperador").css('background-color','rgb(252, 213, 115)');
  if(sessionStorage.getItem('tipo_entrada')=='SR'){
    $(padre).find("#divTicket").addClass('active');
    $(padre).find("#liTicket").addClass('active');
  }else{
    /*if(sessionStorage.getItem('ladoComienza') == 'PUERTAS'){
        $(padre).find("#divDerecha").addClass('active');
        $(padre).find("#liDerecha").addClass('active');
        /*if((sessionStorage.getItem('tipo_entrada') == 'E') && (sessionStorage.getItem('tractor') == 'PROPIO')) {
            $(padre).find("#divSuspension").addClass('active');
            $(padre).find("#liSuspension").addClass('active');
        }else{
            $(padre).find("#divTicket").addClass('active');
            $(padre).find("#liTicket").addClass('active');
        }
    }*/
    if(sessionStorage.getItem('ladoComienza') == 'FRENTE' || sessionStorage.getItem('ladoComienza') == 'PUERTAS'){
        /*$(padre).find("#divDerecha").addClass('active');
        $(padre).find("#liDerecha").addClass('active');*/
        if((sessionStorage.getItem('PUE_PASANTE')=='true')&&(sessionStorage.getItem('FRE_PASANTE')=='true')&&(sessionStorage.getItem('IZQ_PASANTE')=='true')&&(sessionStorage.getItem('DER_PASANTE')=='true')&&(sessionStorage.getItem('OPE_PASANTE')=='true')){
          if((sessionStorage.getItem('tipo_entrada') == 'E') /*&& (sessionStorage.getItem('tractor') == 'PROPIO')*/) {
              if((sessionStorage.getItem('SUS_PASANTE')=='true')){
                //ir al ticket
                $(padre).find("#divTicket").addClass('active');
                $(padre).find("#liTicket").addClass('active');  
              }else{
                alert('You Must Complete SUSPENSION');
              }
          }else{
             $(padre).find("#divTicket").addClass('active');
             $(padre).find("#liTicket").addClass('active');
          }
        }else{
             alert('You Must Complete all sections ');
        }
    }  
  }
  
  // Cambiamos el color del boton de LISTO a rojo

});






/*
function datosFormData(cve_cia,id_inter,caja,no_viaje,no_oper,tipo_tractor,nombre_oper,no_tractor,linea_tractor,placas,status){
   var formData = new FormData();
       if(no_oper == ''){
        alert('Debe completar el campo Número de operador');
        return false;
       }
       if(nombre_oper == ''){
        alert('Debe completar el campo nombre operador');
        return false;
       }
       if(no_tractor == ''){
        alert('Debe completar el campo número de tractor');
        return false;
       }
       if(placas == ''){
        alert('Debe completar el campo placas');
        return false;
       }
       formData.append('cve_cia'      , cve_cia.trim()       );
       formData.append('id_inter'     , id_inter.trim()      );
       formData.append('caja'         , caja.trim()          );
       formData.append('no_viaje'     , no_viaje.trim()      );
       formData.append('no_oper'      , no_oper.trim()       );
       formData.append('tipo_tractor' , tipo_tractor.trim()  );
       formData.append('nombre_oper'  , nombre_oper.trim()   );
       formData.append('no_tractor'   , no_tractor.trim()    );
       formData.append('linea_tractor', linea_tractor.trim() );
       formData.append('placas'       , placas.trim()        );
       formData.append('status'       , status.trim()        );

   return formData;
}*/

/*
function insertaOperador(cve_cia,id_inter,caja,no_viaje,no_oper,clase_oper,nombre_oper,tractor,linea_tractor,placas,tipo,cadenaFirma){
      if(cadenaFirma != 'SIN_FIRMA'){ // SI TIENE FIRMA ENTONCES INSERTA Y SUBE LA FIRMA
        insertarIncidenciaFirma(sessionStorage.getItem('cia'), sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('caja'),  sessionStorage.getItem('noViaje'), sessionStorage.getItem('tipo_entrada'), 'FIRMA_OPER', 'OPERADOR', 'N/A', 'NO', '', 'SI', 'P', '10');
      }
      $.ajax({
      type: "POST",
      url: window.ubicacionURL+'operador.php',
      data: datosFormData(cve_cia,id_inter,caja,no_viaje,no_oper,clase_oper,nombre_oper,tractor,linea_tractor,placas,tipo),
      processData: false,
      cache: false,
      contentType : false,
      dataType: 'json',
      success: function(data){
        $('#btnListo').removeClass('disabled')
        $("#iListo").removeClass('fa fa-spinner fa-spin');
           if (data == 0) {
             alert(":( Ocurrio un Problema:"+data);
           }else{
             // los datos se insertaron correctamente
              mensajes('¡Bien hecho!','continuemos...','success');
             // **************************************
              sessionStorage.setItem('OPE_NoGatas',$('#txtGatas').val());

              sessionStorage.setItem('OPE_Pacas',$('#txtPlacas').val());
              sessionStorage.setItem('OPE_PASANTE','true');

              var padre = $(window.parent.document);
                $(padre).find("#divOperador").removeClass('active');
                $(padre).find("#liOperador").removeClass('active');
                $(padre).find("#liOperador").css('background-color','rgb(252, 213, 115)');
                if(sessionStorage.getItem('ladoComienza') == 'PUERTAS'){

                    if((sessionStorage.getItem('tipo_entrada') == 'E') && (sessionStorage.getItem('tractor') == 'FRIO EXPRESS')) {
                      $(padre).find("#divSuspension").addClass('active');
                      $(padre).find("#liSuspension").addClass('active');
                    }else{
                      $(padre).find("#divTicket").addClass('active');
                      $(padre).find("#liTicket").addClass('active');
                    }
                }
                if(sessionStorage.getItem('ladoComienza') == 'FRENTE'){
                   $(padre).find("#divDerecha").addClass('active');
                   $(padre).find("#liDerecha").addClass('active');
                }
              // **************************************
           }
       },
      error: function(jqXHR, exception){
          erroresAjax(jqXHR, exception);
      }
   });
}
*/



/*********************SECCION DEL FIRMA EN EL MODAL**********************/
$("#btnGuardarFirma").click(function(){
  cadenaFirma = $("#txtSalidaFirma").val();
  //sessionStorage.setItem("cadenaFirma",cadenaFirma);
  subirFirma(cadenaFirma, sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), 'FIRMA_OPER', 'FIRMA', 'N/A', 0, 1, 'O',$(".pad").width(),$(".pad").height());

  $("#mdlFirma").modal("hide");
  $("#btnFirma").removeClass('btn-primary');
  $("#btnFirma").addClass('btn-danger');
  $("#txtNombre").val(window.nombreTmp);
});

$("#btnLimpiarFirma").click(function(){
  apiFirma.regenerate();
  cadenaFirma = 'SIN_FIRMA';
});

$("#btnFirma").click(function(event) {
    window.nombreTmp = $("#txtNombre").val();

    $("#mdlFirma").modal("show");
    if(bandIniciarFirma==0){
      console.log($("#mdlFirma").width()-20);
      $(".pad").attr("width",$("#mdlFirma").width()-170+"px");
      $('.sigPad').attr("width",$("#mdlFirma").width()-170+"px");
      apiFirma = $('.sigPad').signaturePad({drawOnly:true,lineTop:250});
      bandIniciarFirma=1;
    }
    
    //apiFirma = $('.sigPad').signaturePad({drawOnly:true,lineTop:150});
    //apiFirma=new SignaturePad($(".pad"));
    /*canvas= $(".pad");
    canvas.width=$("#mdlFirma").width()-20;*/
});

/*function subirFirma(id_inter,tipo,parte,noCaja,frente,cadenaFirma){
   var formData = new FormData();
       formData.append('cveinter'       ,id_inter);
       formData.append('tipo'           ,tipo);
       formData.append('parte'          ,parte);
       formData.append('caja'           ,noCaja);
       formData.append('frente'         ,frente);
       formData.append('lugarExpedicion',sessionStorage.getItem('lugarExpedicion'));
       formData.append('cadenaFirma'    ,cadenaFirma);
    $.ajax({
        type: 'POST',
        url: sessionStorage.getItem('ipSubirFotos')+'firmaOperador.php',
        data: formData,
        processData: false,
        cache: false,
        contentType : false,
        success: function(data){
        },
        error: function(jqXHR, exception) {
              erroresAjax(jqXHR, exception);
         }
      });
}

function insertarIncidenciaFirma(cia, id_inter, caja, viaje, tipo, frente, parte, tipoplafon, danio, foto, reporte, status, cve_cia){
   subirFirma(id_inter,tipo,'OPERADOR',caja,'FIRMA_OPER',cadenaFirma);
  var formData = new FormData();
     formData.append('cia', cia);
     formData.append('cveinter', id_inter);
     formData.append('caja', caja);
     formData.append('viaje', viaje);
     formData.append('tipo', tipo);
     formData.append('frente', frente);
     formData.append('parte', parte);
     formData.append('tipoplafon', tipoplafon);
     formData.append('danio', danio);
     formData.append('reporte', reporte);
     formData.append('status', status);
     formData.append('foto', sessionStorage.getItem('fotosUpload')+'/'+frente+'/'+parte+'/FIRMA.jpeg');
  $.ajax({
    type: 'POST',
    url: window.ubicacionURL+"fotosFirma.php",
    data: formData,
    processData: false,
    cache: false,
    contentType : false,
    mimeType    : false,
    success: function(data){
     console.log(data);
     danio = '';
    },
    error: function(jqXHR, exception){
        erroresAjax(jqXHR, exception);
    }
  });
}*/

$("#btnLimpiarForm").click(function(){
  $(".limpiar").val("");
  $("#txtGatas").val(0);
});

/****************************************************************************/
/*****************  FUNCIONES PLUGIN MINIUS Y MAX   *************************/
/****************************************************************************/
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});

$('.btn-number').click(function(e){

    e.preventDefault();

    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {

            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            }
            if(parseInt(input.val()) <= input.attr('min')) {
                $(this).attr('disabled', true);
            }
            if(parseInt(input.val()) < input.attr('max')) {
                $("button.btn-number[data-type='plus']").attr('disabled', false);
            }

        }else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) >= input.attr('max')) {
                $(this).attr('disabled', true);
            }
            if(parseInt(input.val()) > input.attr('min')) {
                $("button.btn-number[data-type='minus']").attr('disabled', false);
            }

        }
    } else {
        input.val(0);
    }

});

$('#txtGatas').blur(function() {
  if(parseInt($(this).val())<0){
    alert('LO SIENTO EL MENOR NUMERO DE GATAS ES 0');
  }
});

$("#txtGatas").keydown(function (e) {
  // Allow: backspace, delete, tab, escape, enter and .
  if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
       // Allow: Ctrl+A
      (e.keyCode == 65 && e.ctrlKey === true) ||
       // Allow: home, end, left, right
      (e.keyCode >= 35 && e.keyCode <= 39)) {
           // let it happen, don't do anything
           return;
  }
  // Ensure that it is a number and stop the keypress
  if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      e.preventDefault();
  }
});
