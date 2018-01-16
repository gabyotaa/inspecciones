/*
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR:  PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
 */
var banderaLado = '';
var padre = $(window.parent.document);


$(document).ready(function(){


/*******************CODIGO PARA NO SALIR*******************/
  window.onbeforeunload = function (e) {
      var e = e || window.event;
      var msg = "ARE YOU SURE YOU WANT TO LEAVE THE INSPECTION?"
       // For IE and Firefox
        if (e) {
           e.returnValue = msg;
        }
       // For Safari / chrome
    return msg;
 };
/**********************************************************/
 if(sessionStorage.getItem('nombre') == null ){
    alert('Por favor Debe Autenticarse...');
    window.location="../../index.html";
 }
 if(sessionStorage.getItem('id_intercambio') == null){
    alert('Ocurrio Un error si continua el intercambio no saldrá exitoso \n por favor vuelva a comenzar...');
    window.location="../../index.html";
 }

 $('#divComentExito').hide();
 $('#divComentError').hide();
  window.ubicacionURL    = sessionStorage.getItem('ubicacionURL');
  window.tipo_transporte = sessionStorage.getItem('tipo_transporte');

    sessionStorage.setItem('OPE_PASANTE','false');
    sessionStorage.setItem('PUE_PASANTE','false');
    sessionStorage.setItem('IZQ_PASANTE','false');
    sessionStorage.setItem('FRE_PASANTE','false');
    sessionStorage.setItem('DER_PASANTE','false');
    sessionStorage.setItem('SUS_PASANTE','false');

  if(sessionStorage.getItem('tractor') == 'PROPIO'){//PRIME DICE QUE PARA SUS CHOFERES NO QUIEREN PEDIR DATOS Y FIRMA
    sessionStorage.setItem('OPE_NoOpe',0);
    sessionStorage.setItem('OPE_Nombre','');
    sessionStorage.setItem('OPE_APE_PAT','');
    sessionStorage.setItem('OPE_NoGatas',0);
    sessionStorage.setItem('OPE_PASANTE','true');
  }

  if(sessionStorage.getItem('tipo_entrada')=='SR'){
      if(sessionStorage.getItem('tractor') == 'PROPIO'){
        $('#liTicket').addClass('active');
        $('#divTicket').addClass('active');
      }else{
        $('#liOperador').addClass('active');
        $('#divOperador').addClass('active');
      }
      
      cargarSalidaRapida();
  }else{
    if( sessionStorage.getItem('ladoComienza') == 'FRENTE'){
       $('#liFrente').addClass('active');
       $('#divFrente').addClass('active');
      switch (window.tipo_transporte) {
        case 'SECO':
          cargarFrameSeco();
          if((sessionStorage.getItem('tipo_entrada') == 'E') /*&& (sessionStorage.getItem('tractor') == 'PROPIO')*/) {
            $("#frameSuspension").attr("src",'../suspension/index.php');
          }else{
            $("#liSuspension").hide();
            sessionStorage.setItem('SUS_PASANTE','true');

          }
        break;
        case 'PIPA':
          cargarFramePipa();
          if((sessionStorage.getItem('tipo_entrada') == 'E') /*&& (sessionStorage.getItem('tractor') == 'PROPIO')*/) {
            $("#frameSuspension").attr("src",'../suspension/index.php');
          }else{
            $("#liSuspension").hide();
            sessionStorage.setItem('SUS_PASANTE','true');

          }
        break;
        default:
          cargarFrameFrio();
          if((sessionStorage.getItem('tipo_entrada') == 'E') /*&& (sessionStorage.getItem('tractor') == 'PROPIO')*/) {
            $("#frameSuspension").attr("src",'../suspension/index.php');
          }else{
            $("#liSuspension").hide();
            sessionStorage.setItem('SUS_PASANTE','true');
          }
      }
    }

    if( sessionStorage.getItem('ladoComienza') == 'PUERTAS'){
       $('#liPuertas').addClass('active');
       $('#divPuertas').addClass('active');
      switch (window.tipo_transporte) {
        case 'SECO':
          cargarFrameSeco();
          if((sessionStorage.getItem('tipo_entrada') == 'E') /*&& (sessionStorage.getItem('tractor') == 'PROPIO')*/) {
            $("#frameSuspension").attr("src",'../suspension/index.php');
          }else{
            $("#liSuspension").hide();
            sessionStorage.setItem('SUS_PASANTE','true');
          }
        break;
        case 'PIPA':
          cargarFramePipa();
           if((sessionStorage.getItem('tipo_entrada') == 'E') /*&& (sessionStorage.getItem('tractor') == 'PROPIO')*/) {
            $("#frameSuspension").attr("src",'../suspension/index.php');
          }else{
            $("#liSuspension").hide();
            sessionStorage.setItem('SUS_PASANTE','true');

          }
        break;
        default:
          cargarFrameFrio();
          if((sessionStorage.getItem('tipo_entrada') == 'E') /*&& (sessionStorage.getItem('tractor') == 'PROPIO')*/) {
            $("#frameSuspension").attr("src",'../suspension/index.php');
          }else{
            $("#liSuspension").hide();
            sessionStorage.setItem('SUS_PASANTE','true');
          }
      }

    }  
  }
  


});

function cargarSalidaRapida(){
  if(sessionStorage.getItem('tractor') == 'PROPIO'){
      $("#liOperador").addClass("hidden");
  }else{
      $("#frameOperador").attr("src",'../operador/index.php');
  }
  
  $("#frameTicket").attr("src",'../ticket/index.php');
  $("#liFrente").addClass("hidden");
  $("#liDerecha").addClass("hidden");
  $("#liIzquieda").addClass("hidden");
  $("#liPuertas").addClass("hidden");
  $("#liSuspension").addClass("hidden");
  $("#liTractor").addClass("hidden");
}

function cargarFramePipa(){
    $("#frameFrente").attr("src",'../frentePiPa/index.php');
    $("#frameDerecha").attr("src",'../derechoPipa/index.php');
    $("#frameIzquierdo").attr("src",'../izquierdoPipa/index.php');
    $("#framePuertas").attr("src",'../puertasPipa/index.php');

    
    $("#frameTicket").attr("src",'../ticket/index.php');
    if(sessionStorage.getItem('tractor') == 'PROPIO'){
        $("#liOperador").addClass("hidden");
    }else{
        $("#frameOperador").attr("src",'../operador/index.php');
    }
    /*if((sessionStorage.getItem('tractor')=='PROPIO') && (sessionStorage.getItem('tipo_entrada') == 'E')){
      $("#liTractor").removeClass("hidden");
      $("#frameTractor").attr("src",'../tractorFotos/index.php');
    }*/
}

function cargarFrameFrio(){
    $("#frameFrente").attr("src",'../frenteThermo/index.php');
    $("#frameDerecha").attr("src",'../derechoThermo/index.php');
    $("#frameIzquierdo").attr("src",'../izquierdoThermo/index.php');
    $("#framePuertas").attr("src",'../puertasFrioSeco/index.php');
    $("#frameTicket").attr("src",'../ticket/index.php');
    if(sessionStorage.getItem('tractor') == 'PROPIO'){
        $("#liOperador").addClass("hidden");
    }else{
        $("#frameOperador").attr("src",'../operador/index.php');
    }
    /*if((sessionStorage.getItem('tractor')=='PROPIO') && (sessionStorage.getItem('tipo_entrada') == 'E')){
      $("#liTractor").removeClass("hidden");
      $("#frameTractor").attr("src",'../tractorFotos/index.php');
    }*/
}

function cargarFrameSeco(){
    $("#frameFrente").attr("src",'../frenteSeco/index.php');
    $("#frameDerecha").attr("src",'../derechoSeco/index.php');
    $("#frameIzquierdo").attr("src",'../izquierdoSeco/index.php');
    $("#framePuertas").attr("src",'../puertasFrioSeco/index.php');
    $("#frameTicket").attr("src",'../ticket/index.php');
    if(sessionStorage.getItem('tractor') == 'PROPIO'){
        $("#liOperador").addClass("hidden");
    }else{
        $("#frameOperador").attr("src",'../operador/index.php');
    }
    /*if((sessionStorage.getItem('tractor')=='PROPIO') && (sessionStorage.getItem('tipo_entrada') == 'E')){
      $("#liTractor").removeClass("hidden");
      $("#frameTractor").attr("src",'../tractorFotos/index.php');
    }*/
}

$('#tabNavegacion a').click(function (e) {
    e.preventDefault();
 //   $('#liFrente').removeClass('active');
 //   $('#liPuertas').removeClass('active');
    var tabSeleccionado = $(this).data('lado');
    
    switch (tabSeleccionado) {
        case 'FRENTE':
               $(this).tab('show');
            break;
        case 'DERECHO':
               $(this).tab('show');
            break;
        case 'IZQUIERDO':
               $(this).tab('show');
            break;
        case 'PUERTAS':
               $(this).tab('show');
            break;
        case 'OPERADOR':
               $(this).tab('show');
            break;
        case 'SUSPENSION':
               $(this).tab('show');
            break;
        case 'TRACTOR':
               $(this).tab('show');
            break;
        case 'TICKET':
               if(sessionStorage.getItem('tipo_entrada')=='SR'){
                  if( sessionStorage.getItem('OPE_PASANTE') != 'true'){
                      $('#liTicket').removeClass('active');
                      alert('Please complete DRIVER section');
                      return false;
                  }
               }else{
                  if( sessionStorage.getItem('PUE_PASANTE') != 'true'){
                      $('#liTicket').removeClass('active');
                      alert('Please Complete DOORS Section');
                      return false;
                  }
                  if( sessionStorage.getItem('FRE_PASANTE') != 'true'){
                      $('#liTicket').removeClass('active');
                      alert('Pleae complete FRONT section');
                      return false;
                  }
                  if( sessionStorage.getItem('IZQ_PASANTE') != 'true'){
                      $('#liTicket').removeClass('active');
                      alert('Please complete LEFT section');
                      return false;
                  }
                  if( sessionStorage.getItem('DER_PASANTE') != 'true'){
                      $('#liTicket').removeClass('active');
                      alert('Please complete RIGHT section');
                      return false;
                  }
                  if( sessionStorage.getItem('OPE_PASANTE') != 'true'){
                      $('#liTicket').removeClass('active');
                      alert('Please complete DRIVER section');
                      return false;
                  }
                  if((sessionStorage.getItem('tipo_entrada') == 'E') /*&& (sessionStorage.getItem('tractor') == 'PROPIO')*/) {
                    if( sessionStorage.getItem('SUS_PASANTE') != 'true'){
                        $('#liTicket').removeClass('active');
                        alert('Please complete SUSPENSION section');
                        return false;
                    }
                  } 
               }
               
               /* if((sessionStorage.getItem('tractor') == 'PROPIO') && (sessionStorage.getItem('tipo_entrada') == 'E')) {
                  if( sessionStorage.getItem('TRACTOR_PASANTE') != 'true'){
                      $('#liTicket').removeClass('active');
                      alert('Debe completar la pantalla del TRACTOR');
                      return false;
                  }
                } */
                $(this).tab('show');
            break;
        default:
            alert('ERROR NINGUNA SECCION SELECCIONADA');
    }
});
/*
$("#liSugerencias").click(function(event) {
   $('#mdlSugerencias').modal('show');
});
/******************PARTE DE COMENTARIOS ****************
$("#liComentarios").click(function(event) {
   $('#mdlComentarios').modal('show');
   $('#divComentExito').hide();
});

$("#groupRdLado input[name='rdLado']").click(function(){
switch ($(this).val()) {
    case 'FRENTE':
      banderaLado = 'FRENTE';
        break;
    case 'DERECHO':
      banderaLado = 'DERECHO';
        break;
    case 'IZQUIERDO':
      banderaLado = 'IZQUIERDO';
        break;
    case 'PUERTAS':
      banderaLado = 'PUERTAS';
        break;
    case 'OPERADOR':
      banderaLado = 'OPERADOR';
        break;
    case 'SUSPENSION':
      banderaLado = 'SUSPENSION';
        break;
    default:
      alert('Vuelva a Seleccionar el lado por favor.');
}
$('.selLado').removeClass('active');
   $(this).parent('label').addClass('active');
});

$('#btnGuardarComment').click(function(event) {
   if(banderaLado == ''){
     alert('Debe Seleccionar el lado :)');
     return false;
   }
   if($('#txtComentario') == ''){
      alert('Debe Ingresar el comentario');
      return false;
   }
   $(this).addClass('btn-danger');
   $('.selLado').removeClass('active');
   insertarComment(sessionStorage.getItem('id_intercambio'),
                   banderaLado,
                   $('#txtComentario').val(),
                   sessionStorage.getItem('idusuario'),
                   'C'
                   );

});

function insertarComment(id_inter,frente,comentario,usuario,unidad){
   var formData = new FormData();
       formData.append('metodo','agregarComentario');
       formData.append('id_intercambio', id_inter);
       formData.append('frente', frente);
       formData.append('respuesta', comentario);
       formData.append('usuario', usuario);
       formData.append('unidad', status);
  $.ajax({
    type: 'POST',
    url: window.ubicacionURL+"main.php",
    data: formData,
    processData: false,
    cache: false,
    contentType : false,
    mimeType    : false,
    success: function(data, textStatus, jqXHR){
      if(data == 0){
        // alert('Ocurrio Un Error Vuelva a Intentar...');
         $('#divComentError').show();
      }else{
         //LIMPIAMOS LAS VARIABLES
         banderaLado = '';
         $('#divComentExito').show();
         $('#txtComentario').val('');
         $("#groupRdLado input[name='rdLado']").prop('checked',false);
         $('#btnGuardarComment').removeClass('btn-danger');
         $('#mdlComentarios').modal('hide');
         mensajes('Comentario','Se guardo con exito','success');
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
       erroresAjax(jqXHR, exception);
    }
  });
}

$('#btnCerrarMdlComment').click(function(){
  $('#divComentError').hide();
  $('#divComentExito').hide();
});

/******************PARTE DE SUGERENCIAS ****************
$('#btnCerrarSug').click(function(event) {
    $('#txtSugerencia').val('');
});

$('#btnEnviarMailSug').click(function(event) {
    enviarMailSug($('#txtSugerencia').val(),sessionStorage.getItem('id_usu'));
});

function enviarMailSug(comentario,usuario){
   var formData = new FormData();
       formData.append('metodo','mailSugerencia');
       formData.append('comentario', comentario);
       formData.append('usuario', usuario);
  $.ajax({
    type: 'POST',
    url: window.ubicacionURL+"main.php",
    data: formData,
    processData: false,
    cache: false,
    contentType : false,
    mimeType    : false,
    async: false,
    success: function(data, textStatus, jqXHR){
      switch(data){
        case '0':alert("Error, no se pueden enviar correos porque no se han especificado los parametros de envio de correos en el modulo de administración");break;
        case '-1':alert("Error, no se pueden enviar correos porque no se ha especificado el servidor de correos en el modulo de administración");break;
        case '-2':alert("Error, no se pueden enviar correos porque no se ha especificado el correo from en el modulo de administración");break;
        case '-3':alert("Error, no se pueden enviar correos de sugerencia porque no se ha especificado el email destino para las sugerencias en el modulo de administración");break;
        case '1': alert('Gracias... en brevedad nos pondremos en contacto.');break;
        default:alert(data);

      }


      $('#txtSugerencia').val('');
      $('#mdlSugerencias').modal('hide');

    },
    error: function(jqXHR, textStatus, errorThrown){
      erroresAjax(jqXHR, exception);
    }
  });
}
*/