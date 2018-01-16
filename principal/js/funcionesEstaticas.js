/*
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR: PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
 */

var diaserver = '';
var rootUrl='php/funciones/';
/************************************************************************************/
/********************************ERRORES AJAX************************************/
/************************************************************************************/


function erroresAjax(jqXHR, exception){
    if (jqXHR.status === 0) { // si no contesta el servidor entra en este if
      alerta('Hubo un error de conexión:(', 'No existe conexión con el Servidor, Verifica tu Wi-Fi', 'warning');                     
    } else if (jqXHR.status == 404) {
      alerta('Hubo un error de conexión:(', 'Página web no encontrada [404]', 'warning');
    } else if (jqXHR.status == 500) {
      alerta('Hubo un error de conexión:(', 'Error Interno del Servidor [500]', 'warning');
    } else if (exception === 'parsererror') {        
      alerta('Hubo un error de conexión:(', 'Error parse JSON', 'warning');
    } else if (exception === 'timeout') {    
      alerta('Hubo un error de conexión:(', 'Error Tiempo de espera en servidor', 'warning');
    } else if (exception === 'abort') {
      alerta('Hubo un error de conexión:(', 'Petición de AJAX abortada', 'warning');
    } else {             
      alerta('ERROR', 'Hubo un error de conexión:(', 'warning');
    }
} //  FIN DE LA FUNCION

function mensajes(titulo,texto,tipoMensaje){
    new PNotify({
        title: titulo,
        animation: 'none',
        shadow: false,
        text: texto,
        type: tipoMensaje
    });
}

function obtenerRutaFoto(){
/**************************FORMAMOS LA URL DE FOTOS DE INTERCAMBIOS***************************************/
    var lugarFoto = sessionStorage.getItem('lugarExpedicion'); // Valor obtenido en la pantalla de intercambio
    var patio=sessionStorage.getItem('patio');
    /*switch(sessionStorage.getItem('cia')){
      case '1':
      case '2':
      case '4':
        lugarFoto = 'AGUASCALIENTES';
      break;
      case '3':
        lugarFoto = 'REYNOSA';
      break;
      case '10':
        lugarFoto = 'TRANSFRONTERA';
      break;
    } */
    var dateObj = new Date();
    var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
    var curr_date = dateObj.getDate();
    var curr_month = dateObj.getMonth();
    curr_month = curr_month + 1;
    var curr_year = dateObj.getFullYear();
    var curr_min = dateObj.getMinutes();
    var curr_hr= dateObj.getHours();
    var curr_sc= dateObj.getSeconds();
    if(curr_month.toString().length == 1)
    curr_month =  curr_month;      
    if(curr_date.toString().length == 1)
    curr_date =  curr_date;
    if(curr_hr.toString().length == 1)
    curr_hr =  curr_hr;
    if(curr_min.toString().length == 1)
    curr_min =  curr_min;
    curr_sc = (curr_sc<10)?curr_sc:curr_sc;
    var intercambio = '';
    if(sessionStorage.getItem('tipo_entrada') == 'E'){
      intercambio = 'ENTRADA';
    }
    if(sessionStorage.getItem('tipo_entrada') == 'S'){
      intercambio = 'SALIDA';
    }
    urlFotos = 'INTERCAMBIOS/'+lugarFoto+'/'+patio+'/'+curr_year+'/'+curr_month+'/'+curr_date+'/'+intercambio+'/FOLIO_'+sessionStorage.getItem('id_intercambio');
    sessionStorage.setItem('fotosUpload',urlFotos);
/*******************************************************************************************************/
}
function validarDiaServer(){
$.ajax({
    type: 'POST',
    data:{metodo:'validarFecha', id_horario:sessionStorage.getItem('id_horario'), horario:sessionStorage.getItem('horario')},
    url: "../../../../"+rootUrl+'main.php',
    success: function(data){
      diaserver = data;
      var dateObj = new Date();
      var diacliente = dateObj.getDate();
      var mes = dateObj.getMonth();
          mes = mes + 1;
      var anio = dateObj.getFullYear();
      if(diaserver != diacliente){
         alert("**************ATENCION****************\n********* LA FECHA DE SU TABLETA ESTA MAL ********\n\n ESTAMOS A: "+diaserver+"/"+mes+"/"+anio+"  CAMBIELA POR FAVOR.");
      }
    },
    error: function(jqXHR, exception) {
         erroresAjax(jqXHR, exception);
    }
  });

}
/*******************************************************************************************************/
function cuentaDanios(id_intercambio ,status){
      $.ajax({
      type: "GET",
      url: rootUrl+'main.php',
      data: { metodo:'cuentaDanios',id_intercambio : id_intercambio , status : status },
      dataType: "json",
      async: false,
      success: function(data){
         if (data == 0) {
            sessionStorage.setItem('TICK_countDanios','0'); 
         }else{
            sessionStorage.setItem('TICK_countDanios',parseInt(data.cuentadanios)); 
         }
       },
      error: function(XMLHttpRequest, textStatus, errorThrown){
         erroresAjax(jqXHR, exception); 
      }
   });
}


/****estaticas*******/
function alerta(titulo,mensaje,tipo){
   swal({title:titulo,text:mensaje,type:tipo,html:true,confirmButtonColor:'#5bc0de'});
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
    sessionStorage.setItem('datosSello2' , '');   
    sessionStorage.setItem('datosDriverno' , '');        
    sessionStorage.setItem('datosApe_p' , '');        
    sessionStorage.setItem('datosApe_m' , '');        
    sessionStorage.setItem('PUE_PASANTE' , '');        
    sessionStorage.setItem('PUE_placas' , '');        
    sessionStorage.setItem('OPE_PASANTE' , '');        
    sessionStorage.setItem('IZQ_PASANTE' , '');        
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
    sessionStorage.setItem('DER_TaponDiesel' , '');
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
    sessionStorage.setItem('FRE_VIN' , '');
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
    sessionStorage.setItem('datosFecha' , '');
    sessionStorage.setItem('fotosUpload' , '');
    sessionStorage.setItem('IZQ_Refaccion' , '');
    sessionStorage.setItem('SUS_PASANTE' , '');
    sessionStorage.setItem('NoTractor','');
    sessionStorage.setItem('linea_tractor','');
    sessionStorage.setItem('placas_tractor','');
    sessionStorage.setItem('tractorExtSel','');
    sessionStorage.setItem('TRACTOR_PASANTE','');
    sessionStorage.setItem('OPE_APE_PAT','');
    sessionStorage.setItem('OPE_APE_MAT','');
    sessionStorage.setItem('OPE_Nombre','');
    sessionStorage.setItem('DER_NumLlantas','');
    sessionStorage.setItem('IZQ_NumLlantas','');

    //sessionStorage.setItem('cadenaFirma','');
}

function subirFotoIncidencia(claseFormulario, id_inter, tipo, frente, parte, tipoplafon, danio, reporte, unidad, num_unidad){
   //subirFoto(claseFormulario,id_inter,tipo,parte,frente,unidad, num_unidad);
   var etiqueta=unidad=='C'?'CAJA_'+num_unidad:'TRACTOR_'+num_unidad;
   var formData = new FormData($("."+claseFormulario)[0]);
       formData.append('metodo','fotoIncidencia');
       formData.append('id_intercambio', id_inter);
       formData.append('tipo', tipo);
       formData.append('frente', frente);
       formData.append('parte', parte);
       formData.append('tipoplafon', tipoplafon);
       formData.append('danio', danio);
       formData.append('reporte', reporte);
       formData.append('unidad', unidad);
       formData.append('num_unidad', num_unidad);
       formData.append('lugarExpedicion', sessionStorage.getItem('lugarExpedicion'));
       formData.append('idpatio',sessionStorage.getItem('idpatio'));
       formData.append('id_horario',sessionStorage.getItem('id_horario'));
       formData.append('horario',sessionStorage.getItem('horario'));
       formData.append('foto', sessionStorage.getItem('fotosUpload')+'/'+etiqueta+'/'+frente+'/'+parte+'.jpeg');
  $.ajax({
    type: 'POST',
    url: window.ubicacionURL+"main.php",
    data: formData,
    processData: false,
    cache: false,
    contentType : false,
    mimeType    : false,
    success: function(data){
      switch(data){
        case  '1': /*se guardo correctamente*/break;
        case  '0': alerta('Error al almacenar la foto', 'No se tienen especificados los parametros de ftp en el catalogo de patios', 'warning'); break;
        case '-1': alerta('Error al almacenar la foto', 'Error con la direccion del host o el puerto ftp, debe usar el puerto 21', 'warning'); break;
        case '-2': alerta('Error al almacenar la foto', 'Usuario o contraseña de ftp incorrectos', 'warning'); break;
        case '-3': alerta('Error al almacenar la foto', 'Error al transmitirse la imagen através de la red', 'warning'); break;
        case '-4': alerta('Error al almacenar la foto', 'No se pudo acceder o crear el directorio del ftp correspondiente', 'warning'); break;
        case '-5': alerta('Error al almacenar la foto', 'No se pudo enviar la imagen al FTP', 'warning'); break;
        case '-6': alerta('Error al almacenar la foto', 'No se almaceno correctamente la informacion en la base de datos', 'warning'); break;
        default: alert(data); break;
      }
    },
    error: function(jqXHR, exception){
           erroresAjax(jqXHR, exception);
    }
  });

}

function subirFirma(cadenaFirma, id_inter, tipo, frente, parte, tipoplafon, danio, reporte, unidad,x_size_image,y_size_image){
   //subirFoto(claseFormulario,id_inter,tipo,parte,frente,unidad, num_unidad);
   var etiqueta='OPERADOR';
   var formData = new FormData();
       formData.append('cadena_firma',cadenaFirma);
       formData.append('metodo','fotoFirma');
       formData.append('id_intercambio', id_inter);
       formData.append('tipo', tipo);
       formData.append('frente', frente);
       formData.append('parte', parte);
       formData.append('tipoplafon', tipoplafon);
       formData.append('danio', danio);
       formData.append('reporte', reporte);
       formData.append('unidad', unidad);
       formData.append('lugarExpedicion', sessionStorage.getItem('lugarExpedicion'));
       formData.append('idpatio',sessionStorage.getItem('idpatio'));
       formData.append('foto', sessionStorage.getItem('fotosUpload')+'/'+etiqueta+'/'+parte+'.jpeg');
       formData.append('x_size_image',x_size_image);
       formData.append('y_size_image',y_size_image);
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
    before:function(){
      $("#btnListo").prop('disabled',true);
    },
    success: function(data){
      $("#btnListo").prop('disabled',false);
      switch(data){
        case  '1': /*se guardo correctamente*/break;
        case  '0': alerta('Error al almacenar la foto', 'No se tienen especificados los parametros de ftp en el catalogo de patios', 'warning'); break;
        case '-1': alerta('Error al almacenar la foto', 'Error con la direccion del host o el puerto ftp, debe usar el puerto 21', 'warning'); break;
        case '-2': alerta('Error al almacenar la foto', 'Usuario o contraseña de ftp incorrectos', 'warning'); break;
        case '-3': alerta('Error al almacenar la foto', 'Error al transmitirse la imagen através de la red', 'warning'); break;
        case '-4': alerta('Error al almacenar la foto', 'No se pudo acceder o crear el directorio del ftp correspondiente', 'warning'); break;
        case '-5': alerta('Error al almacenar la foto', 'No se pudo enviar la imagen al FTP', 'warning'); break;
        case '-6': alerta('Error al almacenar la foto', 'No se almaceno correctamente la informacion en la base de datos', 'warning'); break;
        default: alerta(data); break;
      }
    },
    error: function(jqXHR, exception){
           erroresAjax(jqXHR, exception);
    }
  });

}

function subirIncidencia(id_inter, tipo, frente, parte, tipoplafon, danio, reporte, unidad, num_unidad){
   //subirFoto(claseFormulario,id_inter,tipo,parte,frente,unidad, num_unidad);
   var etiqueta=unidad=='C'?'CAJA_'+num_unidad:'TRACTOR_'+num_unidad;
   var formData = new FormData();
       formData.append('metodo','incidencia');
       formData.append('id_intercambio', id_inter);
       formData.append('tipo', tipo);
       formData.append('frente', frente);
       formData.append('parte', parte);
       formData.append('tipoplafon', tipoplafon);
       formData.append('danio', danio);
       formData.append('reporte', reporte);
       formData.append('unidad', unidad);
       formData.append('num_unidad', num_unidad);
       formData.append('lugarExpedicion', sessionStorage.getItem('lugarExpedicion'));
       formData.append('idpatio',sessionStorage.getItem('idpatio'));
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
    success: function(data){
      switch(data){
        case  '1': /*se guardo correctamente*/break;
        /*case  '0': alerta('Error al almacenar la foto', 'No se tienen especificados los parametros de ftp en el catalogo de patios', 'warning'); break;
        case '-1': alerta('Error al almacenar la foto', 'Error con la direccion del host o el puerto ftp, debe usar el puerto 21', 'warning'); break;
        case '-2': alerta('Error al almacenar la foto', 'Usuario o contraseña de ftp incorrectos', 'warning'); break;
        case '-3': alerta('Error al almacenar la foto', 'Error al transmitirse la imagen através de la red', 'warning'); break;
        case '-4': alerta('Error al almacenar la foto', 'No se pudo acceder o crear el directorio del ftp correspondiente', 'warning'); break;
        case '-5': alerta('Error al almacenar la foto', 'No se pudo enviar la imagen al FTP', 'warning'); break;*/
        case '-6': alerta('Error al almacenar la foto', 'No se almaceno correctamente la informacion en la base de datos', 'warning'); break;
        default: alert(data); break;
      }
    },
    error: function(jqXHR, exception){
           erroresAjax(jqXHR, exception);
    }
  });

}


/*function subirFoto(claseFormulario,id_inter,tipo,parte,){
   var formData = new FormData($("."+claseFormulario)[0]);
       formData.append('cveinter', id_inter);
       formData.append('tipo', tipo);
       formData.append('parte', parte);
       formData.append('caja', caja);
       formData.append('frente', frente);
       formData.append('lugarExpedicion', sessionStorage.getItem('lugarExpedicion'));
$.ajax({
    type: 'POST',
    url: sessionStorage.getItem('ipSubirFotos')+'fotosRecorrido.php',
  //  url: "http://localhost:8080/intercambios/fotosFrente.php",
    data: formData,
    processData: false,
    cache: false,
    contentType : false,
    mimeType    : false,
    success: function(data){
     console.log(data);
    },
    error: function(jqXHR, exception) {
          erroresAjax(jqXHR, exception);
    }
  });

}*/

function insertarLlantaFoto(clase_formulario,id_intercambio,unidad, num_unidad,frente,tipo,llanta,rin,marca,danio,profundidad,parte,divLLanta){
    var formData = new FormData($("."+clase_formulario)[0]);
    formData.append('metodo','fotoLlanta');
    formData.append('id_intercambio',id_intercambio);
    formData.append('unidad',unidad);
    formData.append('num_unidad',num_unidad);
    formData.append('frente',frente);
    formData.append('tipo',tipo);
    formData.append('num_llanta',llanta);
    formData.append('rin',rin);
    formData.append('marca',marca);
    formData.append('danio',danio);
    formData.append('parte',parte);
    formData.append('lugarExpedicion', sessionStorage.getItem('lugarExpedicion'));
    formData.append('idpatio',sessionStorage.getItem('idpatio'));
    formData.append('id_horario',sessionStorage.getItem('id_horario'));
    formData.append('horario',sessionStorage.getItem('horario'));
    formData.append('profundidad',profundidad);
    $('#mdlLlantas').modal('hide');
    
     $.ajax({
    type: 'POST',
    url: window.ubicacionURL+"main.php",
    data: formData,
    processData: false,
    cache: false,
    contentType : false,
    mimeType    : false,
    beforeSend: function(){
      $('#btnLlantasCont').removeClass('btn-primary');
      $('#btnLlantasCont').addClass('btn-danger');
    },
    success: function(data, textStatus, jqXHR){
     console.log(data);
        switch(data){
            case  '1':{
                $('#btnLlantasCont').removeClass('btn-danger');
                $('#btnLlantasCont').addClass('btn-primary');
                if(divLLanta!='' && parte!='REFACCION'){
                  $(divLLanta).css('background-color','blue');
                }
                
            } /*se guardo correctamente*/break;
            case  '0': alerta('Error al almacenar la foto', 'No se tienen especificados los parametros de ftp en el catalogo de patios', 'warning'); break;
            case '-1': alerta('Error al almacenar la foto', 'Error con la direccion del host o el puerto ftp, debe usar el puerto 21', 'warning'); break;
            case '-2': alerta('Error al almacenar la foto', 'Usuario o contraseña de ftp incorrectos', 'warning'); break;
            case '-3': alerta('Error al almacenar la foto', 'Error al transmitirse la imagen através de la red', 'warning'); break;
            case '-4': alerta('Error al almacenar la foto', 'No se pudo acceder o crear el directorio del ftp correspondiente', 'warning'); break;
            case '-5': alerta('Error al almacenar la foto', 'No se pudo enviar la imagen al FTP', 'warning'); break;
            case '-6': alerta('Error al almacenar la foto', 'No se almaceno correctamente la informacion en la base de datos', 'warning'); break;
            default: alert(data); break;
        }
         
          /*switch(parte){
             case 'INTERNA_IZQ':
                $("#div_llantaIzq_int").css('background-color','blue');
             break;
             case 'INTERNA_DER':
                $("#div_llantaDer_int").css('background-color','blue');
             break;
             case 'EXTERNA_IZQ':
                $("#div_llantaIzq_ext").css('background-color','blue');
             break;
             case 'EXTERNA_DER':
                $("#div_llantaDer_ext").css('background-color','blue');
             break;         
           }*/
           
       
    },
    error: function(jqXHR, textStatus, errorThrown){
        erroresAjax(jqXHR, exception);
    }
  });


}

function insertarLlanta(id_intercambio,unidad, num_unidad,frente,tipo,llanta,rin,marca,danio,profundidad,parte,divLLanta){
    var formData = new FormData();
    formData.append('metodo','llanta');
    formData.append('id_intercambio',id_intercambio);
    formData.append('unidad',unidad);
    formData.append('num_unidad',num_unidad);
    formData.append('frente',frente);
    formData.append('tipo',tipo);
    formData.append('num_llanta',llanta);
    formData.append('rin',rin);
    formData.append('marca',marca);
    formData.append('danio',danio);
    formData.append('parte',parte);
    formData.append('lugarExpedicion', sessionStorage.getItem('lugarExpedicion'));
    formData.append('idpatio',sessionStorage.getItem('idpatio'));
    formData.append('id_horario',sessionStorage.getItem('id_horario'));
    formData.append('horario',sessionStorage.getItem('horario'));
    formData.append('profundidad',profundidad);
    $('#mdlLlantas').modal('hide');
     $.ajax({
        type: 'POST',
        url: window.ubicacionURL+"main.php",
        data: formData,
        processData: false,
        cache: false,
        contentType : false,
        mimeType    : false,
        beforeSend: function(){
          $('#btnLlantasCont').removeClass('btn-primary');
          $('#btnLlantasCont').addClass('btn-danger');
        },
        success: function(data, textStatus, jqXHR){
         console.log(data);
            switch(data){
                case  '1':{
                    $('#btnLlantasCont').removeClass('btn-danger');
                    $('#btnLlantasCont').addClass('btn-primary');
                    if(divLLanta!='' && parte!='REFACCION'){
                      $(divLLanta).css('background-color','blue');
                    }
                   
                } /*se guardo correctamente*/break;
                /*case  '0': alerta('Error al almacenar la foto', 'No se tienen especificados los parametros de ftp en el catalogo de patios', 'warning'); break;
                case '-1': alerta('Error al almacenar la foto', 'Error con la direccion del host o el puerto ftp, debe usar el puerto 21', 'warning'); break;
                case '-2': alerta('Error al almacenar la foto', 'Usuario o contraseña de ftp incorrectos', 'warning'); break;
                case '-3': alerta('Error al almacenar la foto', 'Error al transmitirse la imagen através de la red', 'warning'); break;
                case '-4': alerta('Error al almacenar la foto', 'No se pudo acceder o crear el directorio del ftp correspondiente', 'warning'); break;
                case '-5': alerta('Error al almacenar la foto', 'No se pudo enviar la imagen al FTP', 'warning'); break;*/
                case '-6': alerta('Error al almacenar la foto', 'No se almaceno correctamente la informacion en la base de datos', 'warning'); break;
                default: alert(data); break;
            }
         
          /*switch(parte){
             case 'INTERNA_IZQ':
                $("#div_llantaIzq_int").css('background-color','blue');
             break;
             case 'INTERNA_DER':
                $("#div_llantaDer_int").css('background-color','blue');
             break;
             case 'EXTERNA_IZQ':
                $("#div_llantaIzq_ext").css('background-color','blue');
             break;
             case 'EXTERNA_DER':
                $("#div_llantaDer_ext").css('background-color','blue');
             break;         
           }*/
           
       
            },
            error: function(jqXHR, textStatus, errorThrown){
                erroresAjax(jqXHR, exception);
            }
    });


}