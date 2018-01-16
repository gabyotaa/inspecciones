/*
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR: PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
 */
var ladoComienza = "";
  obtenerRutaFoto();

$(document).ready(function(){
  $('#wrapper').load('../cabezera.html');
  switch (sessionStorage.getItem('tipo_transporte')) {
      case 'FRIO':
          $('#divIzquierda').append('<img id="imgThermo" class="img-responsive "  src="img/thermo.png" width="300" >');
          $('#divDerecha').append(' <img id="imgPuertas" class="img-responsive "  src="img/puertas.png" width="300"  >');
          break;
      case 'PIPA':
          $('#divIzquierda').append('<img id="imgThermo" class="img-responsive "  src="img/pipaSinThermo.png" width="300" >');
          $('#divDerecha').append(' <img id="imgPuertas" class="img-responsive "  src="img/pipaPuertas.JPG" width="300"  >');
          break;
      case 'PLATAFORMA':
          break;
      default:
      break;
    }
});


$('#divIzquierda').click(function(event) {
    window.ladoComienza = "FRENTE";
    sessionStorage.setItem('ladoComienza',window.ladoComienza);
    window.location="../recorrido/index.html";
});

$('#divDerecha').click(function(event) {
    window.ladoComienza = "PUERTAS";
    sessionStorage.setItem('ladoComienza',window.ladoComienza);
    window.location="../recorrido/index.html";
});
