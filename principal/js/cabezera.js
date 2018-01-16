/*
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR:  PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
 */

$(document).ready(function () {
  sessionStorage.setItem('ubicacionURL','../../php/funciones/');
$(".selCambiarPatio").append(sessionStorage.getItem('selectPatios'));

$('#liUsuario').append('<i id="iUsuario" class="fa fa-user"></i> '+sessionStorage.getItem('nombre'));
window.ubicacionURL = sessionStorage.getItem('ubicacionURL');
if(sessionStorage.getItem('tractor') != null ){

   if(sessionStorage.getItem('caja') != null){
       window.tipo_entrada = sessionStorage.getItem('tipo_entrada');
       window.tractor = sessionStorage.getItem('tractor')=='PROPIO'?'OWN':'EXTERNAL';
       window.caja = sessionStorage.getItem('caja');
       window.lineaCaja = sessionStorage.getItem('datosLinea');
       if (window.tipo_entrada == 'E') {
         $('#aStatus').append('<strong>Status: ARRIVAL</strong>');       
       }else{
         $('#aStatus').append('<strong>Status: DEPARTURE</strong>');                
       }
       $('#aTractor').append('<strong>Truck: </strong>'+window.tractor);
       $('#aCaja').append('<strong>Trailer: </strong>'+window.caja);
       $('#aLineaCaja').append('<strong>Trailer Id: </strong>'+window.lineaCaja);
       
       if(sessionStorage.getItem('id_intercambio') != null){
        window.id_intercambio =sessionStorage.getItem('id_intercambio');
        $('#aIntercambio').append('<strong>Inspection No.: </strong>'+window.id_intercambio);
       }
   }else{
       window.tipo_entrada = sessionStorage.getItem('tipo_entrada');
      window.tractor = sessionStorage.getItem('tractor')=='PROPIO'?'OWN':'EXTERNAL';
       if (window.tipo_entrada == 'E') {
         $('#aStatus').append('<strong>Status: ARRIVAL</strong>');       
       }else{
         $('#aStatus').append('<strong>Status: DEPARTURE</strong>');                
       }
       $('#aTractor').append('<strong>Truck: </strong>'+window.tractor);
   }
}

  var trigger = $('.hamburger'),
      overlay = $('.overlay'),
     isClosed = false;
    trigger.click(function () {
      hamburger_cross();      
    });

    function hamburger_cross() {

      if (isClosed == true) {          
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
      } else {   
        overlay.show();
        trigger.removeClass('is-closed');
        trigger.addClass('is-open');
        isClosed = true;
      }
  }
  
  $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
  });  
}); // FIN DE DOCUMENT.READY

$(".selCambiarPatio").change(function(){
  cia = $(this).children('option:selected').attr('data-cia');
  lugarExpedicion = $(this).children('option:selected').attr('data-lugarExpedicion');
  ip_ftp =  $(this).children('option:selected').attr('data-ipSubirFotos');
  sessionStorage.setItem('lugarExpedicion',lugarExpedicion);
  sessionStorage.setItem('cia',cia);
  sessionStorage.setItem('idpatio',cia);
  sessionStorage.setItem('ipSubirFotos',ip_ftp);    // donde se suben las fotos al F
  mensajes('Aviso', 'Se hizo el cambio de patio a:'+$(this).children('option:selected').text(), 'success');
  $('#mdlCmbPatio').modal("hide");
});
$('#mdlCmbPatio').on('show.bs.modal', function (event) {
  $(".selCambiarPatio").val(sessionStorage.getItem('cia'));
  
});

$("#liSugerencias").click(function(event) {
   $('#mdlSugerencias').modal('show');
});
/******************PARTE DE COMENTARIOS *****************/
$("#liComentarios").click(function(event) {
   $('#mdlComentarios').modal('show');
   $('#divComentExito').hide();
   $('#divComentError').hide();
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
     alert('You must select a side.');
     return false;
   }
   if($('#txtComentario') == ''){
      alert('Write a comment');
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
       formData.append('unidad', unidad);
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
         mensajes('Comentario','Succesfully Saved','success');
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

/******************PARTE DE SUGERENCIAS *****************/
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
       formData.append('id_horario',sessionStorage.getItem('id_horario'));
       formData.append('horario',sessionStorage.getItem('horario'));
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
        /*case '1': alert('Thank you very much... as soon as posible will be contact you');break;*/
        case '1':alerta('Alert','<strong>THANK YOU VERY MUCH....AS SOON AS POSIBLE WILL BE CONTACT YOU</strong>','success');break;
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


$('#liSalirSistema').click(function(event) {
  var espacio_blanco    = /[a-z]/i;  //Expresión regular
     if(sessionStorage.getItem('id_intercambio') == null || sessionStorage.getItem('id_intercambio') == ''){
        sessionStorage.clear();
             
        window.location = '../../../../index.html';  
     }else{
      var r = prompt("The Inspection will be canceled, trailer No. "+sessionStorage.getItem('caja')+" !  \n Please enter the reason: ");
       if(r == ""){
          alert("Please enter the reason...");
          return false;
       }else if(!espacio_blanco.test(r)){
          alert("Reason must be completed");
          return false;
       }else if(r.length < 4){
          alert("Please enter the reason...");
          return false;
       }else{
         cancelarIntercambio(sessionStorage.getItem('id_intercambio'),sessionStorage.getItem('tipo_entrada'),sessionStorage.getItem('caja'),r.toUpperCase(),sessionStorage.getItem('idusuario'),'salir');
       }
    }
});

$('#liCancelarInter').click(function(event) {
  var espacio_blanco    = /[a-z]/i;  //Expresión regular
     if(sessionStorage.getItem('id_intercambio') == '' || sessionStorage.getItem('id_intercambio') == null){
        sessionStorage.clear();
        window.location = '../intercambio/index.html';  
     }else{
      var r = prompt("The Inspection will be canceled, trailer No. "+sessionStorage.getItem('caja')+"!  \n Please enter the reason: ");
       if(r == ""){
          alert("Please enter the reason...");
          return false;
       }else if(!espacio_blanco.test(r)){
          alert("Reason must be completed");
          return false;
       }else if(r.length < 4){
          alert("Please enter the reason....");
          return false;
       }else{
         cancelarIntercambio(sessionStorage.getItem('id_intercambio'),sessionStorage.getItem('tipo_entrada'),sessionStorage.getItem('caja'),r.toUpperCase(),sessionStorage.getItem('idusuario'),'cancelar');
       }
    }
});

/*$('#liLiberarIntercambio').click(function(event) {
  swal({   
    title: "¿ESTAS SEGURO?",   
    text: "Se Liberara el intercambio de la caja "+sessionStorage.getItem('caja')+" \n para que lo pueda TERMINAR otra persona: ",  
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "LIBERAR",   
    cancelButtonText: "CANCELAR",
    closeOnConfirm: false }, 
    function(){  
      limpiarSessionStorage();
      window.location = '../intercambio/index.php'; 
    }
  );
});*/

function eliminarIntercambio(id_intercambio,status) {
  var valores = "id_intercambio="+id_intercambio+"&status="+status;
      $.ajax({
      type: "GET",
      url: window.ubicacionURL+'eliminarIntercambio.php',
      data: valores, 
      async: true,
      beforeSend: function(){
           dyn_notice();
      },
      success: function(data){
           sessionStorage.clear();
           window.location = '../index.html'; 
       },
      error: function(XMLHttpRequest, textStatus, errorThrown){
        alert(errorThrown);
      }
   });
}


function cancelarIntercambio(id_intercambio, status,caja,respuesta,usuario,demorar){
      $.ajax({
      type: "GET",
      url: window.ubicacionURL+'main.php',
      data: {metodo: 'cancelarIntercambio', id_intercambio : id_intercambio , tipo : status , caja : caja , respuesta : respuesta , usuario : usuario, frente:'CANCELAR',unidad:'C'}, 
      async: true,
      beforeSend: function(){
         cancelarInterNoticia();
      },
      success: function(data){
         if(demorar == 'cancelar'){
          limpiarSessionStorage();
          window.location = '../intercambio/index.html'; 
         }else{
          sessionStorage.clear();
          localStorage.clear();
          window.location = '../../../../index.html';  
         }
       },
      error: function(XMLHttpRequest, textStatus, errorThrown){
        //alert(errorThrown);  
        alert('Error, please contact system administrator \n INSPECTION NO.:'+sessionStorage.getItem('id_intercambio'));

      }
   });
}

function limpiarSessionStorage(){
    sessionStorage.setItem('datosLin_tra' , '');        
    sessionStorage.setItem('ladoComienza' , '');        
    sessionStorage.setItem('tipo_transporte' , '');        
    sessionStorage.setItem('datosSupply' , '');        
    sessionStorage.setItem('datosTrac_lintra' , '');        
    sessionStorage.setItem('datosTracto_placas' , ''); 

    sessionStorage.setItem('datosSecuencia' , '');        
    sessionStorage.setItem('datosNombre' , '');        
    sessionStorage.setItem('datosNo_viaje' , '');        
    sessionStorage.setItem('datosNo_trac' , '');        
    sessionStorage.setItem('datosNo_caja' , '');        
    sessionStorage.setItem('datosNip' , '');        
    sessionStorage.setItem('datosLinea' , '');   
    sessionStorage.setItem('datosSello1' , '');   

    sessionStorage.setItem('datosDriverno' , '');        
    sessionStorage.setItem('datosApe_p' , '');        
    sessionStorage.setItem('datosApe_m' , '');        
    sessionStorage.setItem('PUE_PASANTE' , '');        
    sessionStorage.setItem('PUE_placas' , '');        
    sessionStorage.setItem('OPE_PASANTE' , '');        
    sessionStorage.setItem('IZQ_PASANTE' , '');        
    sessionStorage.setItem('FRE_PASANTE' , '');        
    sessionStorage.setItem('FRE_PASANTE' , '');        
    sessionStorage.setItem('DER_PASANTE' , '');        

    sessionStorage.setItem('id_intercambio' , '');
    sessionStorage.setItem('caja' , '');
    sessionStorage.setItem('estadoCaja' , '');
    sessionStorage.setItem('noViaje' , '');
    sessionStorage.setItem('OPE_Inspeccion' , '');
    sessionStorage.setItem('datosPlacas' , '');
    sessionStorage.setItem('FRE_Marca_Thermo' , '');
    sessionStorage.setItem('FRE_StatusThermo' , '');
    sessionStorage.setItem('DER_NivelDiesel' , ''); 
    sessionStorage.setItem('DER_Sello' , '');
    sessionStorage.setItem('DER_SelloCarcasa' , '');
    sessionStorage.setItem('datosRetorno' , '');
    sessionStorage.setItem('FRE_SetPoint' , '');
    sessionStorage.setItem('FRE_Horimetro' , '');
    sessionStorage.setItem('PUE_REPORTARPLACAS' , '');
    sessionStorage.setItem('PUE_Sello1' , '');
    sessionStorage.setItem('PUE_Sello2' , '');
    sessionStorage.setItem('PUE_SelloSagarpa' , '');
    sessionStorage.setItem('OPE_NoGatas' , '');
    sessionStorage.setItem('OPE_Pacas' , '');
    sessionStorage.setItem('tractor' , '');
    sessionStorage.setItem('OPE_NoTractor' , '');
    sessionStorage.setItem('DER_VIN' , '');
    sessionStorage.setItem('DER_Manibela' , '');
    sessionStorage.setItem('datosLin_tractor' , '');
    sessionStorage.setItem('tipo_entrada' , '');
    sessionStorage.setItem('FRE_Real' , '');
    sessionStorage.setItem('FRE_Fisico_Mec' , '');
    sessionStorage.setItem('datosSet_point' , '');
    sessionStorage.setItem('FRE_Alarma1' , '');
    sessionStorage.setItem('FRE_Alarma2' , '');
    sessionStorage.setItem('FRE_Alarma3' , '');
    sessionStorage.setItem('FRE_AVISOTEMPERATURAS' , '');
    sessionStorage.setItem('DER_Odometro' , '');
    sessionStorage.setItem('datosCOMPLETO' , '');
    sessionStorage.setItem('TICK_countDanios' , '');
    sessionStorage.setItem('datosFecha' , '');
}

function dyn_notice() {
    var percent = 0;
    var notice = new PNotify({
        title: "Espere por favor...",
        type: 'info',
        icon: 'picon picon-throbber',
        hide: false,
        buttons: {
            closer: false,
            sticker: false
        },
        shadow: false,
        width: "170px"
    });

    setTimeout(function() {
        notice.update({
            title: false
        });
        var interval = setInterval(function() {
            percent += 2;
            var options = {
                text: percent + "% saliendo"
            };
            if (percent == 80) options.title = "¡Bien!";
            if (percent >= 100) {
                window.clearInterval(interval);
                options.title = "Saliendo!";
                options.type = "success";
                options.hide = true;
                options.buttons = {
                    closer: true,
                    sticker: true
                };
                options.icon = 'picon picon-task-complete';
                options.opacity = 1;
                options.shadow = true;
                options.width = PNotify.prototype.options.width;
            }
            notice.update(options);
        }, 120);
    }, 2000);
}


function cancelarInterNoticia() {
    var percent = 0;
    var notice = new PNotify({
        title: "Espere por favor...",
        type: 'info',
        icon: 'picon picon-throbber',
        hide: false,
        buttons: {
            closer: false,
            sticker: false
        },
        shadow: false,
        width: "170px"
    });

    setTimeout(function() {
        notice.update({
            title: false
        });
        var interval = setInterval(function() {
            percent += 2;
            var options = {
                text: percent + "% cancelando"
            };
            if (percent == 80) options.title = "¡Bien!";
            if (percent >= 100) {
                window.clearInterval(interval);
                options.title = "Regresando...";
                options.type = "success";
                options.hide = true;
                options.buttons = {
                    closer: true,
                    sticker: true
                };
                options.icon = 'picon picon-task-complete';
                options.opacity = 1;
                options.shadow = true;
                options.width = PNotify.prototype.options.width;
            }
            notice.update(options);
        }, 120);
    }, 2000);
}


