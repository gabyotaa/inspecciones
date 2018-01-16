<?php
require_once '../DB/conexion.php';

if(isset($_REQUEST['horario'])){
	date_default_timezone_set($_REQUEST['horario']);
}

$metodo=$_REQUEST['metodo'];
switch($metodo){
	case 'infoPatio':{
		infoPatio();
	}break;
	case 'login':{
		login();
	}break;
	case 'validarFecha':{
		validarFecha();
	}break;
	case 'cuentaDanios':{
		cuentaDanios();
	}break;
}


function infoPatio(){
	if(isset($_REQUEST['patio'])){ // si recive la variable post patio entra
  		$patio	= $_REQUEST['patio'];
  		$str		= "SELECT P.*, H.horario FROM PATIO AS P, HORARIO H WHERE STATUS = 1 AND P.id_horario=H.id AND ID_PATIO = $patio";
  		$db			= conexion_bd();
  		$patios =consulta($db,$str);
  		cerrarConexion($db);
  		echo json_encode($patios[0]);

	}else{                    // si no recive ninguna variable entra
 		$str  = " SELECT P.*, H.horario FROM PATIO AS P, HORARIO H WHERE STATUS = 1 AND P.id_horario=H.id ";
 		$db=conexion_bd();
  		$patios=consulta($db,$str);
  		cerrarConexion($db);
  		//echo json_encode($patios);
 	 	echo '{"patios": ' . json_encode($patios) . '}';
	}
}

function login(){
	$usuario    = $_REQUEST['usuario'];
	$contrasena = md5($_REQUEST['contrasena']);
	$str = 	"SELECT id_usuario as idusuario , usr as id_usu ,nombre,ape_p,ape_m,correo, tipo_usr ".
			"FROM usuario ".
			"WHERE usr='$usuario' ".
			"AND password='$contrasena' ".
			"AND status=1";
	$db=conexion_bd();
	$datosUsuario=consulta($db,$str);
	cerrarConexion($db);
	if($datosUsuario!=0){
		echo json_encode($datosUsuario[0]);
	}else{
		echo 0;
	}
}

function validarFecha(){
	echo date('j');
	//echo date('Y-m-d H:i');
}



?>
