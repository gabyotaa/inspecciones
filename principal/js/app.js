/*
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR: PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
 */

var host = window.location.hostname;
var port = location.port;
//var ubicacionURL = "http://"+host+":"+port+"/intercambios_prime/php/funciones/";
var ubicacionURL = "../../php/funciones/";
$(document).ready(function() {

});

function check_user() {
  if(sessionStorage.getItem('id_usu') == null || sessionStorage.getItem('cia') == null){
    alert('Por favor Debe Autenticarse...');
    window.location="../../../../index.html";
  }
}
