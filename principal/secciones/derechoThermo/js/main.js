/*
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR: PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
 */
var estadoCaja             = "";
var banderaCargadores      = '';
var banderaLodera          = '';
var banderaPatines         = '';
var banderaParte           = '';
var banderaFaldon          = '';
var banderaTaponDiesel     = null;
var banderaManibela        = null;
var banderaTanque          = '';
var banderaAleron          = '';
var banderaPalanca         = '';
var clase_Formulario       = '';
var banderaLlantas         = 0;
var banderaTrampa          = '';
var tipoRin                = '';
var marcaLlanta            = '';
var tipoDanio              = '';
var profundidad            = 0;
var banderaPerfilIzquierdo = false;
var banderaPerfilDerecho   = false;
var banderaMedidorDiesel   = true; // BANDERA SE CAMBIO A TRUE PORQUE AÚN NO SE ACLARA
var danio                  = '';
var numLlantas             = 4;

$(document).ready(function(){
  $('#rangeValue1').val('75');
  $('#btnLlantas4').addClass('active');
  window.ubicacionURL = sessionStorage.getItem('ubicacionURL');
});


function modificarLLantasIzq(){
 
    numLlantas=parseInt(sessionStorage.getItem('DER_NumLlantas'));

    if(numLlantas==2){
       $('#frameIzquierdo',window.parent.document).contents().find("#btnLlantas2").addClass('active');
       $('#frameIzquierdo',window.parent.document).contents().find("#btnLlantas4").removeClass('active');
       $('#frameIzquierdo',window.parent.document).contents().find(".divDosLlantas").fadeOut('fast');
       

    }else{
      $("#frameIzquierdo",window.parent.document).contents().find("#btnLlantas4").addClass('active');
      $("#frameIzquierdo",window.parent.document).contents().find("#btnLlantas2").removeClass('active');
      $("#frameIzquierdo",window.parent.document).contents().find(".divDosLlantas").fadeIn('fast');
       
    }
    $("#frameIzquierdo",window.parent.document).contents().find("#btnLlantas2").prop('disabled',true);
    $("#frameIzquierdo",window.parent.document).contents().find("#btnLlantas4").prop('disabled',true);
    $("#frameIzquierdo",window.parent.document).contents().find("#divNumLlantas").hide();
    
  
}






$('#rangeValue1').change(function(event) {
  $('#barDiesel').val($('#rangeValue1').val());
});




$('#btnListo').click(function(){
   if(banderaPerfilIzquierdo == false){
    /*alert('Please take picture LEFT SIDE');*/
    alerta('Alert','<strong>PLEASE TAKE PICTURE LEFT SIDE</strong>','warning');
     return false;
   }
   if(banderaPerfilDerecho == false){
     /*alert('Please take picture RIGHT SIDE');*/
     alerta('Alert','<strong>PLEASE TAKE PICTURE RIGHT SIDE</strong>','warning');
     return false;
   } 
   if(banderaLodera == ''){
     /*alert('Please Complete RIGHT SKIRT');*/
     alerta('Alert','<strong>PLEASE COMPLETE LEFT FLAP</strong>','warning');
     return false;
   }
   if(banderaCargadores == ''){
     /*alert('Please Complete RIGHT FLAP');*/
     alerta('Alert','<strong>PLEASE COMPLETE X MEMBER</strong>','warning');
     return false;
   }
   if(banderaPatines == ''){
     /*alert('Please Complete X MEMBERS');*/
     alerta('Alert','<strong>PLEASE COMPLETE LANDING GEAR</strong>','warning');
     return false;
   }
   /*if(banderaPalanca == ''){
     alerta('Alert','<strong>PLEASE COMPLETE LANDING GEAR</strong>','warning');
     return false;
   }*/
   if(banderaFaldon == ''){
     alerta('Alert','<strong>PLEASE COMPLETE LEFT SKIRT</strong>','warning');
     return false;
   }
   if(banderaTaponDiesel == null){
     /*alert('Please Complete FUEL CAP');*/
     alerta('Alert','<strong>PLEASE COMPLETE FUEL CAP</strong>','warning');
     return false;
   }
   if(banderaManibela == null){
     /*alert('Please Complete JACK HANDLE');*/
     alerta('Alert','<strong>PLEASE COMPLETE JACK HANDLE</strong>','warning');
     return false;
   }
   if(banderaTanque == ''){
     alerta('Alert','<strong>PLEASE COMPLETE FUEL TANK</strong>','warning');
     return false;
   }
   if(banderaAleron == ''){
     alerta('Alert','<strong>PLEASE COMPLETE LEFT TAIL</strong>','warning');
     return false;
   }

   if($("#txtDot").val()==""){
     alerta('Alert','<strong>PLEASE COMPLETE DOT INSPECTION</strong>','warning');
     return false;
   }
   var exp_fecha=new RegExp('^((1[0-2]{1}){1}|(0[1-9]){1}){1}/([0-9]){4}$');
   //console.log(exp_fecha.test($("#txtDot").val()));
   if($("#txtDot").val().length<7 || !(exp_fecha.test($("#txtDot").val()))){
     alerta('Alert','<strong>INCORRECT DOT INSPECTION FORMAT</strong>','warning');
     return false;
   }
   if(sessionStorage.getItem('IZQ_NumLlantas')==null || sessionStorage.getItem('IZQ_NumLlantas')=='' ){
       sessionStorage.setItem('DER_NumLlantas',numLlantas);
       modificarLLantasIzq();
    }else{
      numLlantas=parseInt(sessionStorage.getItem('IZQ_NumLlantas'));
    }

   if(parseInt(banderaLlantas) < numLlantas){
      /*alert('Please Complete TIRES');*/
      alerta('Alert','<strong>PLEASE COMPLETE TIRES</strong>','warning');
      return false;
   }
   /*if(banderaMedidorDiesel == false){
      alert('Debe completar la Acción Medidor Diesel');
      return false;  
   }*/
   /*if ( $('#txtOdometro').val().length == 0) {
      alert("Plese complete ODOMETER");
      return false;
   };*/
   if( $('#rangeValue1').val() == ''){
      /*alert("Please complete FUEL LEVEL");*/
      alerta('Alert','<strong>PLEASE COMPLETE FUEL LEVEL</strong>','warning');
      return false;
   }

   if( parseInt($('#rangeValue1').val())<75 && (sessionStorage.getItem('diesel_persona')==null || sessionStorage.getItem('diesel_razones')==null)){
      $('#mdlDiesel').modal('show');
      return false;

   }
    if(sessionStorage.getItem('IZQ_NumLlantas')==null || sessionStorage.getItem('IZQ_NumLlantas')=='' ){
       sessionStorage.setItem('DER_NumLlantas',numLlantas);
       modificarLLantasIzq();
    }
    
    sessionStorage.setItem('DER_Dot',$("#txtDot").val());
    sessionStorage.setItem('DER_TaponDiesel',banderaTaponDiesel);
    sessionStorage.setItem('DER_Manibela',banderaManibela);
    sessionStorage.setItem('DER_Odometro',$('#txtOdometro').val() );
    sessionStorage.setItem('DER_NivelDiesel',$('#rangeValue1').val());
    sessionStorage.setItem('DER_PASANTE','true');

    var padre = $(window.parent.document);
    $(padre).find("#divDerecha").removeClass('active');
    $(padre).find("#liDerecha").removeClass('active');
    $(padre).find("#liDerecha").css('background-color','rgb(252, 213, 115)');
    
   if(sessionStorage.getItem('ladoComienza') == 'PUERTAS'){
      /*$(padre).find("#divFrente").addClass('active');
      $(padre).find("#liFrente").addClass('active');*/
      if((sessionStorage.getItem('tipo_entrada') == 'E') /*&& (sessionStorage.getItem('tractor') == 'PROPIO')*/) {
          $(padre).find("#divSuspension").addClass('active');
          $(padre).find("#liSuspension").addClass('active');
        }else{
          if(sessionStorage.getItem('tractor') == 'PROPIO'){
            if((sessionStorage.getItem('PUE_PASANTE')=='true')&&(sessionStorage.getItem('FRE_PASANTE')=='true')&&(sessionStorage.getItem('IZQ_PASANTE')=='true')&&(sessionStorage.getItem('DER_PASANTE')=='true')&&(sessionStorage.getItem('OPE_PASANTE')=='true')){
                 $(padre).find("#divTicket").addClass('active');
                 $(padre).find("#liTicket").addClass('active');
              
            }else{
                 alert('You Must Complete all sections ');
            }
          }else{
            $(padre).find("#divOperador").addClass('active');
            $(padre).find("#liOperador").addClass('active');  
          }
          
        }
   }

   if(sessionStorage.getItem('ladoComienza') == 'FRENTE'){
      $(padre).find("#divPuertas").addClass('active');
      $(padre).find("#liPuertas").addClass('active');
   }
 
$(this).addClass('active');
});

$("#btnDieselCont").click(function(){
  if($("#txtPersona").val()==''){
      alerta('Alert','<strong>PLEASE COMPLETE APPROVED BY</strong>','warning');
      return false;
  }
  if($("#areaRazones").val()==''){
      alerta('Alert','<strong>PLEASE COMPLETE THE REASONS</strong>','warning');
      return false;
  }
  sessionStorage.setItem('diesel_persona',$("#txtPersona").val());
  sessionStorage.setItem('diesel_razones',$("#areaRazones").val());
  $("#mdlDiesel").modal('hide');
});

/************************EVENTOS DE LAS IMAGENES**************************/

$('#fl_c1_der').on('change',function(){
   subirFotoIncidencia('class_fl_c1_der', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#div_c1_der').click(function(event) {
   $('#div_c1_der').css('background-color','crimson');
   frente = 'IZQUIERDO';
   parte = 'CUADRANTE_1';
  if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){   
     if(confirm('Is There some Damage?') == true){
        danio = 1;
        $("#fl_c1_der").trigger('click');
     }else{
        danio = 0; 
        subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));   
     }
        //$("#fl_c1_der").trigger('click');
   }else{
      if (confirm('Is There some Damage?')==true) {
        danio = 1;
      }else{
        danio = 0;
      }
      subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));

   }  

});

$('#fl_c2_izq').on('change',function(){
   subirFotoIncidencia('class_fl_c2_izq', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#div_c2_izq').click(function(event) {
   $('#div_c2_izq').css('background-color','crimson');
   frente = 'IZQUIERDO';
   parte = 'CUADRANTE_2';
  if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){   
     if(confirm('Is There some Damage?') == true){
        danio = 1;
        $("#fl_c2_izq").trigger('click');
     }else{
        danio = 0;
        subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));    
     }
        //$("#fl_c2_izq").trigger('click');
   }else{
      if (confirm('Is There some Damage?')==true) {
        danio = 1;
      }else{
        danio = 0;
      }
       subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));

   }  

});

$('#fl_c3_izq').on('change',function(){
   subirFotoIncidencia('class_fl_c3_izq', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#div_c3_izq').click(function(event) {
   $('#div_c3_izq').css('background-color','crimson');
   frente = 'IZQUIERDO';
   parte = 'CUADRANTE_3';
  if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){   
     if(confirm('Is There some Damage?') == true){
        danio = 1;
        $("#fl_c3_izq").trigger('click');
     }else{
        danio = 0;
        subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));    
     }
        //$("#fl_c3_izq").trigger('click');
   }else{
      if (confirm('Is There some Damage?')==true) {
        danio = 1;
      }else{
        danio = 0;
      }
       subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));

   }  

});

$('#fl_c4_izq').on('change',function(){
   subirFotoIncidencia('class_fl_c4_izq', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#div_c4_izq').click(function(event) {
   $('#div_c4_izq').css('background-color','crimson');
   frente = 'IZQUIERDO';
   parte = 'CUADRANTE_4';
  if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){   
     if(confirm('Is There some Damage?') == true){
        danio = 1;
        $("#fl_c4_izq").trigger('click');
     }else{
        danio = 0;
        subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));    
     }
        //$("#fl_c4_izq").trigger('click');
   }else{
      if (confirm('Is There some Damage?')==true) {
        danio = 1;
      }else{
        danio = 0;
      }
      subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
   }  

});

$('#fl_c5_der').on('change',function(){
   subirFotoIncidencia('class_fl_c5_der', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#div_c5_der').click(function(event) {
   $('#div_c5_der').css('background-color','crimson');
   frente = 'IZQUIERDO';
   parte = 'CUADRANTE_5';
  if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){   
     if(confirm('Is There some Damage?') == true){
        danio = 1;
        $("#fl_c5_der").trigger('click');
     }else{
        danio = 0;
        subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));    
     }
        //$("#fl_c5_der").trigger('click');
   }else{
      if (confirm('Is There some Damage?')==true) {
        danio = 1;
      }else{
        danio = 0;
      }
      subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));

   }  

});

$('#fl_c6_izq').on('change',function(){
   subirFotoIncidencia('class_fl_c6_izq', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#div_c6_izq').click(function(event) {
   $('#div_c6_izq').css('background-color','crimson');
   frente = 'IZQUIERDO';
   parte = 'CUADRANTE_6';
  if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){   
     if(confirm('Is There some Damage?') == true){
        danio = 1;
        $("#fl_c6_izq").trigger('click');
     }else{
        danio = 0; 
        subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));   
     }
       // $("#fl_c6_izq").trigger('click');
   }else{
      if (confirm('Is There some Damage?')==true) {
        danio = 1;
      }else{
        danio = 0;
      }
      subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
   }  

});

$('#fl_c7_izq').on('change',function(){
   subirFotoIncidencia('class_fl_c7_izq', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#div_c7_izq').click(function(event) {
   $('#div_c7_izq').css('background-color','crimson');
   frente = 'IZQUIERDO';
   parte = 'CUADRANTE_7';
  if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){   
     if(confirm('Is There some Damage?') == true){
        danio = 1;
        $("#fl_c7_izq").trigger('click');
     }else{
        danio = 0; 
        subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));   
     }
        //$("#fl_c7_izq").trigger('click');
   }else{
      if (confirm('Is There some Damage?')==true) {
        danio = 1;
      }else{
        danio = 0;
      }
      subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));

   }  

});

$('#fl_c8_izq').on('change',function(){
   subirFotoIncidencia('class_fl_c8_izq', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#div_c8_izq').click(function(event) {
   $('#div_c8_izq').css('background-color','crimson');
   frente = 'IZQUIERDO';
   parte = 'CUADRANTE_8';
  if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){   
     if(confirm('Is There some Damage?') == true){
        danio = 1;
        $("#fl_c8_izq").trigger('click');
     }else{
        danio = 0; 
        subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));   
     }
       // $("#fl_c8_izq").trigger('click');
   }else{
      if (confirm('Is There some Damage?')==true) {
        danio = 1;
      }else{
        danio = 0;
      }
      subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));

   }  

});

$('#fl_foco_ezq').on('change',function(){
   subirFotoIncidencia('class_fl_foco_ezq', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#div_foco_ezq').click(function(event) {
   $('#div_foco_ezq').css('background-color','crimson');
   frente = 'IZQUIERDO';
   parte = 'FOCO_ESQUINA';
  if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){   
     if(confirm('Is There some Damage?') == true){
        danio = 1;
        $("#fl_foco_ezq").trigger('click');
     }else{
        danio = 0; 
        subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));   
     }
       // $("#fl_foco_ezq").trigger('click');
   }else{
      if (confirm('Is There some Damage?')==true) {
        danio = 1;
      }else{
        danio = 0;
      }
      subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));

   }  

});

$('#fl_foco_med').on('change',function(){
   subirFotoIncidencia('class_fl_foco_med', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#div_foco_med').click(function(event) {
   $('#div_foco_med').css('background-color','crimson');
   frente = 'IZQUIERDO';
   parte = 'FOCO_MEDIO';
  if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){   
     if(confirm('Is There some Damage?') == true){
        danio = 1;
         $("#fl_foco_med").trigger('click');
     }else{
        danio = 0;
        subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));    
     }
        //$("#fl_foco_med").trigger('click');
   }else{
      if (confirm('Is There some Damage?')==true) {
        danio = 1;
      }else{
        danio = 0;
      }
      subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));

   }  

});

/*************************************************************************/
$('#div_llantaIzq_int').click(function(event) {
    $('#div_llantaIzq_int').css('background-color','crimson');
    parte = 'INTERNA_IZQ';
    frente = 'IZQUIERDO';
    banderaParte = '12';
    divLLanta='#div_llantaIzq_int';
    banderaLlantas = banderaLlantas + 1;
    $('#mdlLlantas').modal('show');
});
$('#div_llantaDer_int').click(function(event) {
    $('#div_llantaDer_int').css('background-color','crimson');
    parte = 'INTERNA_DER';
    frente = 'IZQUIERDO';
    banderaParte = '16';
    divLLanta='#div_llantaDer_int';
    banderaLlantas = banderaLlantas + 1;
    $('#mdlLlantas').modal('show');
});
$('#div_llantaIzq_ext').click(function(event) {
    $('#div_llantaIzq_ext').css('background-color','crimson');
    parte = 'EXTERNA_IZQ';
    frente = 'IZQUIERDO';
    banderaParte = '11';
    divLLanta='#div_llantaIzq_ext';
    banderaLlantas = banderaLlantas + 1;
    $('#mdlLlantas').modal('show');
});
$('#div_llantaDer_ext').click(function(event) {
    $('#div_llantaDer_ext').css('background-color','crimson');
    parte = 'EXTERNA_DER';
    frente = 'IZQUIERDO';
    banderaParte = '15';
    divLLanta='#div_llantaDer_ext';
    banderaLlantas = banderaLlantas + 1;
    $('#mdlLlantas').modal('show');
});
/****************************PARTE DEL MODAL*************************/
$("#groupRdTipoRin input[name='radiosTipoRin']").click(function(){
    //console.log($(this).parent().parent().find('.selRin').html());
    $(this).parent().parent().find('.selRin').removeClass('active');
    //$('.selRin').removeClass('active');
    $(this).parent().parent().find('.selRin').removeClass('btn-danger');
   // $('.selRin').removeClass('btn-danger');
    $(this).parent('label').addClass('btn-danger');
    tipoRin = $(this).val();    
});

$("#grupoRdMarcas input[name='radioMarca']").click(function(){
    $(this).parent().parent().parent().parent().find(".selMarca").removeClass('active');
    $(this).parent().parent().parent().parent().find(".selMarca").removeClass('btn-danger');
   // $('.selMarca').removeClass('active');
    //$('.selMarca').removeClass('btn-danger');
    $(this).parent('label').addClass('btn-danger');
    //console.log($(this).parent().parent().parent().parent().find("#divOtro").html());   
    if($(this).val()=='Other'){
      $(this).parent().parent().parent().parent().find("#divOtro").show();
      
    }else{
      $(this).parent().parent().parent().parent().find("#divOtro").hide();
      
    }

    marcaLlanta = $(this).val();
  //  $(this).parent('label').addClass('active');
  //  alert(marcaLlanta);
});

/*$("#mdlRefaccion").closest("#grupoRdMarcas > div.row > div.col-md-12 > div.row >label>input").click(function(){
  alert("modal REFACCION");
});*/

$("#groupRdDanio input[name='radiosDanios']").click(function(){
    tipoDanio = $(this).val();
    //console.log($(this).parent().parent().html());
    //$('.selDanio').removeClass('active');
    //$('.selDanio').removeClass('btn-danger');
    $(this).parent().parent().find('.selDanio').removeClass('active');
    $(this).parent().parent().find('.selDanio').removeClass('btn-danger');
    $(this).parent('label').addClass('btn-danger');

  if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){     
    switch (tipoDanio) { 
    case 'PONCHADA': 
       clase_Formulario = 'class_fl_Baja';
       $("#fl_Baja").trigger('click');
    break;
    case 'TRONADA': 
       $("#fl_Tronada").trigger('click');
       clase_Formulario = 'class_fl_Tronada';
    break;
    case 'DESGASTADA': 
       $("#fl_Desgastada").trigger('click');
       clase_Formulario = 'class_fl_Desgastada';
    break;      
    case 'GOLPE': 
       $("#fl_Golpe").trigger('click');
       clase_Formulario = 'class_fl_Golpe';
    break;  
    case 'BURBUJA': 
       $("#fl_Burbuja").trigger('click');
       clase_Formulario = 'class_fl_Burbuja';
    break;     
    case 'SIN LLANTA': 
       $("#fl_Sinllanta").trigger('click');
       clase_Formulario = 'class_fl_Sinllanta';
    break;      
    default:
   }
  }  
   
});


$('#btnLlantasCont').click(function(){
   //console.log($(this).parent().parent().parent().find(".selRin.btn-danger > input").val());
   //tipoRin=$(this).parent().parent().parent().find('input[name="radiosTipoRin"]:checked').val();
   tipoRin=$(this).parent().parent().parent().find(".selRin.btn-danger > input").val()
   if (tipoRin == '' || tipoRin==null) {
      /*alert('Please select RIM TYPE');*/
      alerta('Alert','<strong>PLEASE SELECT RIM TYPE</strong>','warning');
     return false;
   }
   //marcaLlanta=$(this).parent().parent().parent().find('input[name="radioMarca"]:checked').val();
   marcaLlanta=$(this).parent().parent().parent().find(".selMarca.btn-danger > input").val();
   if (marcaLlanta == '' || marcaLlanta== null) {
      /*alert('Please select TIRE BRAND');*/
      alerta('Alert','<strong>PLEASE TIRE BRAND</strong>','warning');
      return false;
   }
   
   tipoDanio=$(this).parent().parent().parent().find(".selDanio.btn-danger > input").val();
   //tipoDanio=$(this).parent().parent().parent().find('input[name="radiosDanios"]:checked').val();
   if (tipoDanio == '' || tipoDanio== null) {
      /*alert('Please select TYPE OF DAMAGE');*/
      alerta('Alert','<strong>PLEASE SELECT TYPE OF DAMAGE</strong>','warning');
     return false;
   }
   if($(this).parent().parent().parent().find('#txtProfundidad').val()==''){
      alerta('Alert','<strong>PLEASE WRITE TREAD DEPTH</strong>','warning');
      return false;
   }
   if(marcaLlanta=='Other' && $(this).parent().parent().parent().find("#txtOtraMarca").val()==''){
      alerta('Alert','<strong>PLEASE WRITE OTHER TIRE BRAND</strong>','warning');
      return false;
   }
   if(marcaLlanta=='Other'){
      marcaLlanta=$(this).parent().parent().parent().find("#txtOtraMarca").val().toUpperCase();
   }
   
   profundidad=parseInt($(this).parent().parent().parent().find('#txtProfundidad').val());
   if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' && tipoDanio!='NORMAL'){
      insertarLlantaFoto(clase_Formulario, sessionStorage.getItem('id_intercambio'),'C', sessionStorage.getItem('caja'), frente,sessionStorage.getItem('tipo_entrada'),banderaParte,tipoRin,marcaLlanta,tipoDanio,profundidad,parte,divLLanta); 
   }else{
      insertarLlanta( sessionStorage.getItem('id_intercambio'),'C', sessionStorage.getItem('caja'), frente,sessionStorage.getItem('tipo_entrada'),banderaParte,tipoRin,marcaLlanta,tipoDanio, profundidad ,parte,divLLanta);
   }           
  /*switch (tipoDanio) { 
    case 'PONCHADA': 
       $('.selDanio').removeClass('active btn-danger');
    break;
    case 'TRONADA': 
       $('.selDanio').removeClass('active btn-danger');
    break;
    case 'DESGASTADA': 
       $('.selDanio').removeClass('active btn-danger');
    break;      
    case 'GOLPE': 
       $('.selDanio').removeClass('active btn-danger');
    break;
    case 'BURBUJA': 
       $('.selDanio').removeClass('active btn-danger');
    break;
    case 'SIN LLANTA': 
       $('.selDanio').removeClass('active btn-danger');
    break;      
    default:
   }  */
   $(this).parent().parent().parent().find(".selDanio.btn-danger").removeClass('active btn-danger'); 

});




/**************************** FIN PARTE DEL MODAL*************************/

$('#fl_perfil_izq').on('change',function(){
   subirFotoIncidencia('class_fl_perfil_izq', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#btnPerfilIzquierdo').click(function(event) {
   banderaPerfilIzquierdo = true;
   frente = 'IZQUIERDO';
   parte = 'PERFIL_IZQUIERDO';
   if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){ 
      if(confirm("¿Would you like to send Left Side Picture by email?") == true){
        danio = 1;    
        $("#fl_perfil_izq").trigger('click');
      }else{
        danio = 0;    
        $("#fl_perfil_izq").trigger('click');
      }  
    }else{
      if (confirm("Is There some Damage?") == true) {
         danio = 1;
      }else{
         danio = 0; 
      }
      subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
    }   
  $(this).removeClass('btn-info');
  $(this).addClass('btn-danger');
});

$('#fl_perfil_der').on('change',function(){
   subirFotoIncidencia('class_fl_perfil_der', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});
$('#btnPerfilDerecho').click(function(event) {
   banderaPerfilDerecho = true;
   frente = 'IZQUIERDO';
   parte = 'PERFIL_DERECHO';
   if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){ 
     if(confirm("¿Would you like to send Right Side Picture by email?") == true){
      danio = 1;    
      $("#fl_perfil_der").trigger('click');
     }else{
      danio = 2;    
      $("#fl_perfil_der").trigger('click');
     }
    }else{
      if (confirm("Is There some Damage?") == true) {
         danio = 1;
      }else{
         danio = 0; 
      }
      subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
    }
  $(this).removeClass('btn-info');
  $(this).addClass('btn-danger');
});

$('#fl_medidor_diesel_img').on('change',function(){
     subirFotoIncidencia('class_medidor_diesel_img', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#btnFotoMedidorDiesel').click(function(event) {
     banderaMedidorDiesel = true;
     frente = 'IZQUIERDO';
     parte = 'MEDIDOR_DIESEL_THERMO';
     if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){ 
        if(confirm("¿Would you like to send Fuel Level Picture by email?") == true){
           danio = 1;
           $("#fl_medidor_diesel_img").trigger('click');
        }else{
           danio = 0;
           $("#fl_medidor_diesel_img").trigger('click');
        }
    }else{
      if (confirm("Is There some Damage?") == true) {
         danio = 1;
      }else{
         danio = 0; 
      }
      subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
     } 
  $(this).removeClass('btn-info');
  $(this).addClass('btn-danger');
});


$('#fl_cargadores').on('change',function(){
   subirFotoIncidencia('class_fl_cargadores', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#btnCargadoresSD').click(function(event) {
    $('#btnCargadoresSD').addClass('active');
    $('#btnCargadoresND').removeClass('active');
     banderaCargadores = 'SI';
     frente = 'IZQUIERDO';
     parte = 'CARGADOR';
     danio = 1; 
     if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){ 
       $("#fl_cargadores").trigger('click');
     }else{
       subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));  
     }
});

$('#btnCargadoresND').click(function(event) {
    $('#btnCargadoresND').addClass('active');
    $('#btnCargadoresSD').removeClass('active');
    banderaCargadores = 'NO';
    danio = 0;  
});


$('#fl_lodera').on('change',function(){
   subirFotoIncidencia('class_fl_lodera',sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#btnLoderaSD').click(function(event) {
    $('#btnLoderaSD').addClass('active');
    $('#btnLoderaND').removeClass('active');
     banderaLodera = 'SI';
     frente = 'IZQUIERDO';
     parte = 'LODERA';
     danio = 1; 
     if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){ 
       $("#fl_lodera").trigger('click');
     }else{
       subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
     }
});

$('#btnLoderaND').click(function(event) {
    $('#btnLoderaND').addClass('active');
    $('#btnLoderaSD').removeClass('active');
    banderaLodera = 'NO';
    danio = 0;  
});



$('#fl_Patines').on('change',function(){
   subirFotoIncidencia('class_fl_Patines', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#btnPatinesSD').click(function(event) {
    $('#btnPatinesSD').addClass('active');
    $('#btnPatinesND').removeClass('active');
     banderaPatines = 'SI';
     frente = 'IZQUIERDO';
     parte = 'PATINES';
     danio = 1; 
     if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){  
       $("#fl_Patines").trigger('click');
     }else{
        subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
     }
});

$('#btnPatinesND').click(function(event) {
    $('#btnPatinesND').addClass('active');
    $('#btnPatinesSD').removeClass('active');
    banderaPatines = 'NO';
    danio = 0;  
});


/**************SECCIÓN INFERIOR DE LA PÁGINA***************/

$('#btnLlantas2').click(function(event) {
    $('#btnLlantas2').addClass('active');
    $('#btnLlantas4').removeClass('active');
    $('.divCuatroLlantas').fadeOut('fast');
    numLlantas=2;
});

$('#btnLlantas4').click(function(event) {
    $('#btnLlantas4').addClass('active');
    $('#btnLlantas2').removeClass('active');
    $('.divDosLlantas').fadeIn('fast');
    $('.divCuatroLlantas').fadeIn('fast');
    numLlantas=4;
 });

$('#btnTaponDieselSi').click(function(event) {
    $('#btnTaponDieselSi').addClass('active');
    $('#btnTaponDieselNo').removeClass('active');
    banderaTaponDiesel = 1;
});

$('#btnTaponDieselNo').click(function(event) {
    $('#btnTaponDieselNo').addClass('active');
    $('#btnTaponDieselSi').removeClass('active');
    banderaTaponDiesel = 0;
});

$('#btnManibelaSi').click(function(event) {
    $('#btnManibelaSi').addClass('active');
    $('#btnManibelaNo').removeClass('active');
    banderaManibela = 1;
});

$('#btnManibelaNo').click(function(event) {
    $('#btnManibelaNo').addClass('active');
    $('#btnManibelaSi').removeClass('active');
    banderaManibela = 0;
});


$('#fl_Palanca').on('change',function(){
   subirFotoIncidencia('class_fl_Palanca', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#btnPalancaEjesSD').click(function(event) {
    $('#btnPalancaEjesSD').addClass('active');
    $('#btnPalancaEjesND').removeClass('active');
     banderaPalanca = 'SI';
     frente = 'IZQUIERDO';
     parte = 'PALANCA_EJES';
     danio = 1;  
     if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){  
       $("#fl_Palanca").trigger('click');
     }else{
       subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
     }
});

$('#btnPalancaEjesND').click(function(event) {
    $('#btnPalancaEjesND').addClass('active');
    $('#btnPalancaEjesSD').removeClass('active');
    banderaPalanca = 'NO';
    danio = 0;  
});

$('#fl_Faldon').on('change',function(){
   subirFotoIncidencia('class_fl_Faldon', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#btnFaldonSD').click(function(event) {
    $('#btnFaldonSD').addClass('active');
    $('#btnFaldonND').removeClass('active');
     banderaFaldon = 'SI';
     frente = 'IZQUIERDO';
     parte = 'FALDON';
     danio = 1;  
     if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){  
       $("#fl_Faldon").trigger('click');
     }else{
       subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
     }
});

$('#btnFaldonND').click(function(event) {
    $('#btnFaldonND').addClass('active');
    $('#btnFaldonSD').removeClass('active');
    banderaFaldon = 'NO';
    danio = 0;  
});

$('#fl_tanque').on('change',function(){
   subirFotoIncidencia('class_fl_tanque', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#btnTanqueSD').click(function(event) {
    $('#btnTanqueSD').addClass('active');
    $('#btnTanqueND').removeClass('active');
     banderaTanque = 'SI';
     frente = 'IZQUIERDO';
     parte = 'TANQUE';
     danio = 1;  
     if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){  
       $("#fl_tanque").trigger('click');
     }else{
       subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
     }
});

$('#btnTanqueND').click(function(event) {
    $('#btnTanqueND').addClass('active');
    $('#btnTanqueSD').removeClass('active');
    banderaTanque = 'NO';
    danio = 0;  
});

$('#fl_aleron').on('change',function(){
   subirFotoIncidencia('class_fl_aleron', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#btnAleronSD').click(function(event) {
    $('#btnAleronSD').addClass('active');
    $('#btnAleronND').removeClass('active');
     banderaAleron = 'SI';
     frente = 'IZQUIERDO';
     parte = 'ALERON';
     danio = 1;  
     if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){  
       $("#fl_aleron").trigger('click');
     }else{
       subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
     }
});

$('#btnAleronND').click(function(event) {
    $('#btnAleronND').addClass('active');
    $('#btnAleronSD').removeClass('active');
    banderaAleron = 'NO';
    danio = 0;  
});


$('#fl_trampa').on('change',function(){
   subirFotoIncidencia('class_fl_trampa', sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
});

$('#btnBuena').click(function(event) {
    $('#btnBuena').addClass('active');
    $('#btnRota').removeClass('active');
    banderaTrampa = 'NO';
    danio = 0;  
});

$('#btnRota').click(function(event) {
    $('#btnRota').addClass('active');
    $('#btnBuena').removeClass('active');
    banderaTrampa = 'SI';
    frente = 'IZQUIERDO';
    parte = 'TRAMPA';
    danio = 1;  
   if( sessionStorage.getItem('datosCOMPLETO') == 'COMPLETO' ){   
     $("#fl_trampa").trigger('click');
   }else{
     subirIncidencia(sessionStorage.getItem('id_intercambio'), sessionStorage.getItem('tipo_entrada'), frente, parte, 'N/A', danio, '1', 'C', sessionStorage.getItem('caja'));
   }
});