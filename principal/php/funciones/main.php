<?php
/*
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR: BECERRA AVIÑA ISAAC ALI, MARTINEZ APARICIO JOSE LUIS, PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
 */
require_once '../../../../php/DB/conexion.php';
require_once '../../../../php/lib/class_phpmailer_php.php';
require_once '../../../../php/lib/ftp.php';
require_once '../../../../php/lib/signature-to-image.php';

if(isset($_REQUEST['horario'])){
	date_default_timezone_set($_REQUEST['horario']);
}


$metodo=$_REQUEST['metodo'];

switch($metodo){
	case 'lineasCaja':{
		echo lineaCaja();
	}break;
	case 'lineasTractor':{
		echo lineaTractor();
	}break;
	case 'validarEntradaCaja':{
		echo validarEntradaCaja();
	}break;
	case 'validarSalidaCaja':{
		echo validarSalidaCaja();
	}break;
	case 'validarEntradaTractor':{
		echo validarEntradaTractor();
	}break;
	case 'validarSalidaTractor':{
		echo validarSalidaTractor();
	}break;
	case 'insertarIntercambio':{
		echo insertarIntercambio();
	}break;
	case 'cancelarIntercambio':{
		echo cancelarIntercambio();
	}break;
	case 'agregarComentario':{
		echo agregarComentario();
	}break;
	case 'mailSugerencia':{
		echo mailSugerencia();
	}break;
	case 'fotoIncidencia':{
		echo fotoIncidencia();
	}break;
	case 'fotoFirma':{
		echo fotoFirma();
	}break;
	case 'incidencia':{
		echo incidencia();
	}break;
	case 'fotoLlanta':{
		echo fotoLlanta();
	}break;
	case 'llanta':{
		echo llanta();
	}break;
	case 'terminarIntercambio':{
		echo terminarIntercambio();
	}break;
	case 'reportarTemperaturas':{
		echo reportarTemperaturas();
	}break;
	case 'reportarDOT':{
		echo reportarDOT();
	}break;
	case 'reportarSelloSeguridad':{
		echo reportarSelloSeguridad();
	}break;
	case 'reportarDanios':{
		echo reportarDanios();
	}break;
	case 'reportarLlantas':{
		echo reportarLlantas();
	}break;
	case 'reportarEntrada':{
		echo reportarEntradaSalida('ENTRADAS');
	}break;
	case 'reportarSalida':{
		echo reportarEntradaSalida('SALIDAS');
	}break;
	case 'reportarDiesel':{
		echo reportarDiesel();
	}break;
	case 'obtenerResumenIntercambio':{
		echo obtenerResumenIntercambio();
	}break;
	case 'obtenerLlantasIntercambio':{
		echo obtenerLlantasIntercambio();
	}break;
	case 'obtenerIncidentesIntercambio':{
		echo obtenerIncidentesIntercambio();
	}break;
	case 'obtenerFirmaOper':{
		echo obtenerFirmaOper();
	}break;
	case 'buscarEntradaTractor':{
		echo buscarEntradaTractor();
	}break;
	case 'intercambioDesenganchado':{
		echo intercambioDesenganchado();
	}break;
	case 'terminarIntercambioSR':{
		echo terminarIntercambioSR(null);
	}break;
	case 'guardarIntercambioSA':{
		echo guardarIntercambioSA();
	}break;
	case 'ticket':{
		echo ticket();
	}

}

function lineaCaja(){
	$str  = "SELECT ID_LINEA_CAJA , LINEA FROM LINEA_CAJA WHERE STATUS = 1 ORDER BY LINEA";
 	$db=conexion_bd();
  	$lineas=consulta($db,$str);
  	cerrarConexion($db);
  	if($lineas!=0){
  		return '{"lineas": ' . json_encode($lineas) . '}';
  	}else{
  		return 0;
  	}
  	
}

function lineaTractor(){
	$str  = "SELECT ID_LINEA_TRACTOR , LINEA FROM LINEA_TRACTOR WHERE STATUS = 1 ORDER BY LINEA";
 	$db=conexion_bd();
  	$lineas=consulta($db,$str);
  	cerrarConexion($db);
  	if($lineas!=0){
  		return '{"lineas": ' . json_encode($lineas) . '}';
  	}else{
  		return 0;
  	}
}


function validarEntradaCaja(){
	$caja    = $_REQUEST['caja'];
	$idlinea = $_REQUEST['linea'];
	$id_patio = $_REQUEST['id_patio'];
	$str = "SELECT I.FECHA FROM INTERCAMBIO AS I WHERE I.TIPO='E' AND I.ID_INTER_SAL_CAJA IS NULL AND I.STATUS='1' AND I.NUM_CAJA='$caja' AND  I.ID_LINEA_CAJA='$idlinea'";
	$db=conexion_bd();
	$inters=consulta($db,$str);
	cerrarConexion($db);
	if($inters!=0){
		return json_encode($inters[0]);
	}else{
		return 1;
	}
}

function validarSalidaCaja(){
	$caja    = $_REQUEST['caja'];
	$idlinea = $_REQUEST['linea'];
	$id_patio = $_REQUEST['id_patio'];
	$str = "SELECT I.ID_INTERCAMBIO FROM INTERCAMBIO AS I WHERE I.TIPO='E' AND I.ID_INTER_SAL_CAJA IS NULL AND I.STATUS='1' AND I.NUM_CAJA='$caja' AND I.ID_LINEA_CAJA='$idlinea' AND I.ID_PATIO='$id_patio' ";
	$db=conexion_bd();
	$inters=consulta($db,$str);
	cerrarConexion($db);
	if($inters==0){
		return 0;
	}else{
		return json_encode($inters[0]);
	}
}

function validarEntradaTractor(){
	$no_tractor = $_REQUEST['no_tractor'];
	$idlinea    = $_REQUEST['id_linea'];
	$id_patio = $_REQUEST['id_patio'];
	$str = "SELECT I.FECHA FROM INTERCAMBIO AS I WHERE I.TIPO='E' AND I.ID_INTER_SAL_TRACTOR IS NULL AND I.STATUS='1' AND I.NUM_TRACTOR='$no_tractor' AND  I.ID_LINEA_TRACTOR='$idlinea'";
	$db=conexion_bd();
	$inters=consulta($db,$str);
	cerrarConexion($db);
	if($inters!=0){
		return json_encode($inters[0]);
	}else{
		return 1;
	}
}

function buscarEntradaTractor(){
	$patio 		= $_REQUEST['patio'];
	$no_tractor	= $_REQUEST['no_tractor'];
	$id_linea 	= $_REQUEST['id_linea'];
	$otra_linea = $_REQUEST['otra_linea'];
	$tipo_reg 	= $_REQUEST['tipo_reg'];
	$fecha 		= $_REQUEST['fecha'];
	if($tipo_reg=='COMPLETO'){
		if($otra_linea=='OTRO'){
			$str = " SELECT I.ID_INTERCAMBIO FROM INTERCAMBIO AS I, TRACTOR AS T WHERE T.ID_INTERCAMBIO=I.ID_INTERCAMBIO AND I.TIPO='E' AND I.ID_INTER_SAL_TRACTOR IS NULL AND I.STATUS='1' ".
				   " AND I.NUM_TRACTOR='$no_tractor' AND I.ID_PATIO='$patio' AND I.ID_LINEA_TRACTOR IS NULL AND T.OTRA_LINEA='$id_linea' ORDER BY I.FECHA DESC LIMIT 1 ";
		}else{
			$str = " SELECT I.ID_INTERCAMBIO FROM INTERCAMBIO AS I WHERE I.TIPO='E' AND I.ID_INTER_SAL_TRACTOR IS NULL AND I.STATUS='1' AND I.NUM_TRACTOR='$no_tractor' AND ".
				   " I.ID_LINEA_TRACTOR='$id_linea' AND I.ID_PATIO='$patio' ORDER BY I.FECHA DESC LIMIT 1 ";
		}	
	}else{
		if($otra_linea=='OTRO'){
			$str = " SELECT I.ID_INTERCAMBIO FROM INTERCAMBIO AS I, TRACTOR AS T WHERE T.ID_INTERCAMBIO=I.ID_INTERCAMBIO AND I.TIPO='E' AND I.ID_INTER_SAL_TRACTOR IS NULL AND I.STATUS='1' ".
				   " AND I.NUM_TRACTOR='$no_tractor' AND I.ID_PATIO='$patio' AND I.ID_LINEA_TRACTOR IS NULL AND T.OTRA_LINEA='$id_linea' AND I.FECHA<= '$fecha' ORDER BY I.FECHA DESC LIMIT 1 ";
		}else{
			$str = " SELECT I.ID_INTERCAMBIO FROM INTERCAMBIO AS I WHERE I.TIPO='E' AND I.ID_INTER_SAL_TRACTOR IS NULL AND I.STATUS='1' AND I.NUM_TRACTOR='$no_tractor' AND ".
				   " I.ID_LINEA_TRACTOR='$id_linea' AND I.ID_PATIO='$patio' AND I.FECHA<= '$fecha' ORDER BY I.FECHA DESC LIMIT 1 ";
		}	
	}
	
	
	$db=conexion_bd();
	$inters=consulta($db,$str);
	cerrarConexion($db);
	if($inters==0){
		return 0;
	}else{
		return json_encode($inters[0]);
	}
}

function validarSalidaTractor(){
	$no_tractor = $_REQUEST['no_tractor'];
	$idlinea    = $_REQUEST['id_linea'];
	$id_patio = $_REQUEST['id_patio'];
	$str = "SELECT I.ID_INTERCAMBIO FROM INTERCAMBIO AS I WHERE I.TIPO='E' AND I.ID_INTER_SAL_TRACTOR IS NULL AND I.STATUS='1' AND I.NUM_TRACTOR='$no_tractor' AND I.ID_LINEA_TRACTOR='$idlinea' AND I.ID_PATIO='$id_patio'";
	$db=conexion_bd();
	$inters=consulta($db,$str);
	cerrarConexion($db);
	if($inters==0){
		return 0;
	}else{
		return json_encode($inters[0]);
	}
}

function insertarIntercambio(){
	$caja=isset($_REQUEST['caja'])?$_REQUEST['caja']:$_REQUEST['num_caja'];
	$id_linea_caja=$_REQUEST['id_linea_caja'];
	$tipo=isset($_REQUEST['tipo'])?$_REQUEST['tipo']:$_REQUEST['tipo_entrada'];
	$tipo_reg=$_REQUEST['tipo_reg'];
	$id_patio=$_REQUEST['id_patio'];
	$id_usuario=$_REQUEST['id_usuario'];
	$no_tractor=$_REQUEST['no_tractor'];
	$id_linea_tractor=$_REQUEST['id_linea_tractor'];
	if($tipo=='SR'){
		$tipo='S';
	}

	if($id_linea_tractor==''){
		$id_linea_tractor='null';
	}

	if($tipo_reg=='COMPLETO' || $tipo_reg=='C'){
		$str="INSERT INTO INTERCAMBIO (TIPO,NUM_CAJA,FECHA,STATUS,ID_PATIO,ID_USUARIO,ID_LINEA_CAJA,TIPO_REG,NUM_TRACTOR,ID_LINEA_TRACTOR,REG_COMPLETO) ".
			 "VALUES ('$tipo','$caja',now(),'0',$id_patio,$id_usuario,$id_linea_caja,'C','$no_tractor',$id_linea_tractor,'0')";
	}else{
		$fecha=$_REQUEST['fecha'];
		$str="INSERT INTO INTERCAMBIO (TIPO,NUM_CAJA,FECHA,STATUS,ID_PATIO,ID_USUARIO,ID_LINEA_CAJA,TIPO_REG, NUM_TRACTOR, ID_LINEA_TRACTOR, REG_COMPLETO) ".
			 "VALUES ('$tipo','$caja','$fecha','0',$id_patio,$id_usuario,$id_linea_caja,'I','$no_tractor',$id_linea_tractor,'0')";
	}
	//return $str;
	$db=conexion_bd();
	$id_intercambio=insertar($db,$str);
	cerrarConexion($db);
	return $id_intercambio;

}

function cancelarIntercambio(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$str="UPDATE INTERCAMBIO SET STATUS=0 WHERE ID_INTERCAMBIO=$id_intercambio";
	$db=conexion_bd();
	$filas=modificar($db,$str);
	cerrarConexion($db);
	if($filas>0){
		agregarComentario();
		return 1;
	}else{
		return 0;
	}
}

function agregarComentario(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$frente=$_REQUEST['frente'];
	//$comentario=preg_replace('/[\r?\n]+/','',utf8_decode($_REQUEST['respuesta']));
	$comentario=$_REQUEST['respuesta'];
	$id_usuario=$_REQUEST['usuario'];
	$unidad=$_REQUEST['unidad'];
	$str="INSERT INTO COMENTARIO (FRENTE,COMENTARIO,ID_USUARIO,ID_INTERCAMBIO,UNIDAD) VALUES ('$frente','$comentario',$id_usuario,$id_intercambio,'$unidad')";
	$db=conexion_bd();
	$id_cometario=insertar($db,$str);
	cerrarConexion($db);
	if($id_cometario!=0){
		return 1;
	}else{
		return 0;
	}
	

}

function mailSugerencia(){
	$comentario=$_REQUEST['comentario'];
	$usuario=$_REQUEST['usuario'];
	$str="SELECT  CORREO_DESTINO_SUGERENCIAS mail_to, SERVIDOR_CORREO server, PUERTO_CORREO puerto,".
		 " CORREO_FROM_NOTIFICACIONES mail_from FROM PARAMETROS WHERE ID_PARAM=1 ";
	//	 echo $str;
	$db=conexion_bd();
	$param=consulta($db,$str);
	cerrarConexion($db);
	//print_r($param);//$param;
	if($param==0){
		return 0;
	}else{
		$param=$param[0];
		if($param['mail_to']==null || $param['mail_to']=='') {
			return -3;
		}else{
			$cuerpoCorreo = "<table><tr><th>SUGGESTION FROM: ".$usuario."</th></tr>".
                            "<tr><td><table>".
                            "<tr>".
                            "<th>MESSAGE:</th>".
                            "</tr>".
                            "<tr>".
                            "<td>".$comentario."</td>".
                            "</tr>".
                            "</table></td></tr></table>";
            $correos=explode(';', $param['mail_to']);
			return correo($cuerpoCorreo,"INSPECTION SUGGESTION",date('m/d/Y H:i'),$correos);
		}
	}

	
	

}

function objeto_correo(){
	$str="SELECT  CORREO_DESTINO_SUGERENCIAS mail_to, SERVIDOR_CORREO server, PUERTO_CORREO puerto,".
		 " CORREO_FROM_NOTIFICACIONES mail_from , SMTP_USER, SMTP_PASS , SMTP_SECURE FROM PARAMETROS WHERE ID_PARAM=1 ";
	$db=conexion_bd();
	$param=consulta($db,$str);
	cerrarConexion($db);
	$puerto=25;
	if($param==0){
		return 0;//no hay parametros de correo
	}else{
		//return json_encode($inters[0]);
		$param=$param[0];
		if($param['server']==null || $param['server']==''){
			return -1;//no se tiene definido un servidor de correo
		}elseif ($param['mail_from']==null || $param['mail_from']=='') {
			return -2;//no se tiene definido el from para las notificaciones
		}
		if($param['puerto']!=null && $param['puerto']!='' && is_numeric($param['puerto'])){
			$puerto=$param['puerto'];
		}

	}
	$mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->IsHtml(true);
    $mail->Host = $param['server'];
    $mail->Port = $puerto;
    if($param['SMTP_SECURE']!=null && $param['SMTP_SECURE']!='' && ($param['SMTP_SECURE']=='ssl' || $param['SMTP_SECURE']=='SSL' || $param['SMTP_SECURE']=='tls' || $param['SMTP_SECURE']=='TLS') ){
    	$mail->SMTPSecure = $param['SMTP_SECURE'];
    }
    if($param['SMTP_USER']==null || $param['SMTP_USER']=='' || $param['SMTP_PASS']==null || $param['SMTP_PASS']=='' ){
    	$mail->SMTPAuth = false;	
    }else{
    	$mail->SMTPAuth = true;
    	$mail->Username   = $param['SMTP_USER'];
    	$mail->Password   = $param['SMTP_PASS'];  
    }
    
    $mail->From = $param['mail_from'];
    return $mail;
}

function correo($cuerpo, $fromName, $asunto, $correos){
	$str="SELECT  CORREO_DESTINO_SUGERENCIAS mail_to, SERVIDOR_CORREO server, PUERTO_CORREO puerto,".
		 " CORREO_FROM_NOTIFICACIONES mail_from , SMTP_USER, SMTP_PASS , SMTP_SECURE FROM PARAMETROS WHERE ID_PARAM=1 ";
	$db=conexion_bd();
	$param=consulta($db,$str);
	cerrarConexion($db);
	$puerto=25;
	if($param==0){
		return 0;//no hay parametros de correo
	}else{
		//return json_encode($inters[0]);
		$param=$param[0];
		if($param['server']==null || $param['server']==''){
			return -1;//no se tiene definido un servidor de correo
		}elseif ($param['mail_from']==null || $param['mail_from']=='') {
			return -2;//no se tiene definido el from para las notificaciones
		}
		if($param['puerto']!=null && $param['puerto']!='' && is_numeric($param['puerto'])){
			$puerto=$param['puerto'];
		}

	}
	$mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->IsHtml(true);
    $mail->Host = $param['server'];
    $mail->Port = $puerto;
    if($param['SMTP_SECURE']!=null && $param['SMTP_SECURE']!='' && ($param['SMTP_SECURE']=='ssl' || $param['SMTP_SECURE']=='SSL' || $param['SMTP_SECURE']=='tls' || $param['SMTP_SECURE']=='TLS') ){
    	$mail->SMTPSecure = $param['SMTP_SECURE'];
    }
    if($param['SMTP_USER']==null || $param['SMTP_USER']=='' || $param['SMTP_PASS']==null || $param['SMTP_PASS']=='' ){
    	$mail->SMTPAuth = false;	
    }else{
    	$mail->SMTPAuth = true;
    	$mail->Username   = $param['SMTP_USER'];
    	$mail->Password   = $param['SMTP_PASS'];  
    }
    
    $mail->From = $param['mail_from'];
    $mail->FromName =  $fromName;
    $mail->Subject = $asunto;
    $mail->ClearAddresses();
    foreach ($correos as $correo) {
    	if(is_array($correo)){
    	 	if(array_key_exists('CORREO', $correo) && array_key_exists('ALIAS', $correo) && $correo['ALIAS']!=''){
    	 		$mail->AddAddress($correo['CORREO'],$correo['ALIAS']);
    	 	}elseif (array_key_exists('CORREO', $correo)) {
    	 		$mail->AddAddress($correo['CORREO']);
    	 	}
    	}else{
    		$mail->AddAddress($correo);
    	}
    }
    //$mail->AddAddress("dlira@frioexpress.com","DLIRA");
    $mail->Body = $cuerpo;
    $mail->AltBody = "";
    $error=$mail->Send();
    if (!$error)
    {
        return $mail->ErrorInfo;
    }else{
    	return 1;
    }
}

function fotoIncidencia(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$tipo=$_REQUEST['tipo'];
	$frente=$_REQUEST['frente'];
	$parte=$_REQUEST['parte'];
	$tipoplafon=$_REQUEST['tipoplafon'];
	$danio=$_REQUEST['danio'];
	$reporte=$_REQUEST['reporte'];
	$unidad=$_REQUEST['unidad'];
	$num_unidad=$_REQUEST['num_unidad'];
	$lugarExpedicion=$_REQUEST['lugarExpedicion'];
	$idpatio=$_REQUEST['idpatio'];
	$foto=$_REQUEST['foto'];
	$str="SELECT IP_FTP, USER_FTP, PASS_FTP FROM PATIO WHERE ID_PATIO=$idpatio";
	$db=conexion_bd();
	$ftp=consulta($db,$str);
	cerrarConexion($db);
	if($ftp==0){
		return 0;//no se tiene los parametros almacenados para conectarse al ftp y almacenar las fotos
	}else{
		$ftp=$ftp[0];
		$ruta="INTERCAMBIOS/".$lugarExpedicion."/".date('Y')."/".date('n')."/".date('j')."/";
		if($tipo=='E'){
			$ruta.="ENTRADA/";
		}else{
			$ruta.="SALIDA/";
		}
		$ruta.="FOLIO_".$id_intercambio."/";
		if($unidad=="C"){
			$ruta.="CAJA_";
		}else{
			$ruta.="TRACTOR_";
		}
		$ruta.=$num_unidad."/".$frente;
		$nombreArchivo=$parte;
		$res=subirFoto($ftp['IP_FTP'],$ftp['USER_FTP'],$ftp['PASS_FTP'],$ruta,$nombreArchivo);

		if($res!=1){
			return $res;
		}else{
			$rutafoto=$ruta.'/'.$nombreArchivo.".jpeg";
			//checar si no habian ya subido una foto de ese daño o parte
			$str="SELECT ID_INCIDENTE FROM INCIDENTE WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND PARTE='$parte' AND FOTO='$rutafoto' AND UNIDAD='$unidad'";
			$db=conexion_bd();
			$id_incidente=consulta($db,$str);
			cerrarConexion($db);
			if($id_incidente==0){
				$str="INSERT INTO INCIDENTE (FRENTE, PARTE, TIPO_PLAFON, DANIO, FOTO, REPORTE, ID_INTERCAMBIO, UNIDAD) ".
				 	 "VALUES ('$frente','$parte','$tipoplafon',$danio,'$rutafoto',$reporte,$id_intercambio,'$unidad')";
				$db=conexion_bd();
				$id_incidente=insertar($db,$str);
				cerrarConexion($db);
				if($id_incidente!=0){
					return 1;
				}else{
					return -6;//error al almacenar en la bd
				}
			}else{
				$str="UPDATE INCIDENTE SET TIPO_PLAFON='$tipoplafon', DANIO='$danio', REPORTE='$reporte' ".
				     "WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND PARTE='$parte' AND FOTO='$rutafoto' AND UNIDAD='$unidad'";
				
				$db=conexion_bd();
				$filasafectadas=modificar($db,$str);
				cerrarConexion($db);
				if($filasafectadas!=0){
					return 1;
				}else{
					$str="SELECT ID_INCIDENTE FROM INCIDENTE WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND PARTE='$parte' AND FOTO='$rutafoto' AND UNIDAD='$unidad' ".
					 	 " AND TIPO_PLAFON='$tipoplafon' AND DANIO='$danio' AND REPORTE='$reporte' ";	
					$db=conexion_bd();
					$id_incidente=consulta($db,$str);
					cerrarConexion($db);
					if($id_incidente!=0){
						return 1;
					}else{
						return -6;//error al almacenar en la bd	
					}
					
				}
			}
			
		}
	}
}
function subirFoto($host,$user,$pass,$ruta,$nombreArchivo){
	$id_ftp=conexion_ftp($host,21,$user,$pass);
	if($id_ftp==-1||$id_ftp==-2){
		return $id_ftp;//no se pudo conectar al ftp
	}else{

		//$local=$_FILES["archivos"]["name"][0];
		$tipo_archivo=$_FILES["archivos"]["type"][0];
		$archivo=$_FILES["archivos"]["tmp_name"][0];
		$extension=str_replace("image/", "", $tipo_archivo);
		if($archivo!=""){
			if(directorio_ftp($id_ftp,$ruta)){
				$remoto=$nombreArchivo.".".$extension;
				if(subir_ftp($id_ftp,$remoto,$archivo,FTP_BINARY)){
					cerrar_ftp($id_ftp);
					return 1;//exito al subir la imagen

				}else{
					cerrar_ftp($id_ftp);
					return -5;//error al subir la imagen
				}
			}else{
				cerrar_ftp($id_ftp);
				return -4;// no se pudo acceder o crear el directorio en el ftp
			}
		}else{
			cerrar_ftp($id_ftp);
			return -3;//llego vacio el archivo
		}
	}
}

function fotoFirma(){
	$cadena_firma=$_REQUEST['cadena_firma'];
	$id_intercambio=$_REQUEST['id_intercambio'];
	$tipo=$_REQUEST['tipo'];
	$frente=$_REQUEST['frente'];
	$parte=$_REQUEST['parte'];
	$tipoplafon=$_REQUEST['tipoplafon'];
	$danio=$_REQUEST['danio'];
	$reporte=$_REQUEST['reporte'];
	$unidad=$_REQUEST['unidad'];
	$lugarExpedicion=$_REQUEST['lugarExpedicion'];
	$idpatio=$_REQUEST['idpatio'];
	$foto=$_REQUEST['foto'];
	$str="SELECT IP_FTP, USER_FTP, PASS_FTP FROM PATIO WHERE ID_PATIO=$idpatio";
	$db=conexion_bd();
	$ftp=consulta($db,$str);
	$x_size_image=$_REQUEST['x_size_image'];
	$y_size_image=$_REQUEST['y_size_image'];
	cerrarConexion($db);
	if($ftp==0){
		return 0;//no se tiene los parametros almacenados para conectarse al ftp y almacenar las fotos
	}else{
		$ftp=$ftp[0];
		$ruta="INTERCAMBIOS/".$lugarExpedicion."/".date('Y')."/".date('n')."/".date('j')."/";
		if($tipo=='E'){
			$ruta.="ENTRADA/";
		}else{
			$ruta.="SALIDA/";
		}
		$ruta.="FOLIO_".$id_intercambio."/OPERADOR/";
		$nombreArchivo=$parte.'.jpeg';
		if(isset($_REQUEST['cadena_firma'])){
			$dir_temp="../../temp/";
			crearDirectorio($dir_temp);
			//echo "x = ".$x_size_image." y = ".$y_size_image;
			$img=sigJsonToImage($cadena_firma,array('imageSize'=>array($x_size_image+100,$y_size_image+100)));
			//$img=sigJsonToImage($cadena_firma);
			//return $img;
			$ruta_temp=$dir_temp."FOLIO_".$id_intercambio.'.jpeg';
			imagejpeg($img,$ruta_temp);
			$res=subirFotoRuta($ftp['IP_FTP'],$ftp['USER_FTP'],$ftp['PASS_FTP'],$ruta,$ruta_temp,$nombreArchivo);
			if($res!=1){
				return $res;
			}else{
				eliminarArchivo($ruta_temp);
				$rutafoto=$ruta.$nombreArchivo;
			//checar si no habian ya subido una foto de ese daño o parte
				$str="SELECT ID_INCIDENTE FROM INCIDENTE WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND PARTE='$parte' AND FOTO='$rutafoto' AND UNIDAD='$unidad'";
				$db=conexion_bd();
				$id_incidente=consulta($db,$str);
				cerrarConexion($db);
				if($id_incidente==0){
					$str="INSERT INTO INCIDENTE (FRENTE, PARTE, TIPO_PLAFON, DANIO, FOTO, REPORTE, ID_INTERCAMBIO, UNIDAD) ".
				 	 "VALUES ('$frente','$parte','$tipoplafon',$danio,'$rutafoto',$reporte,$id_intercambio,'$unidad')";
					$db=conexion_bd();
					$id_incidente=insertar($db,$str);
					cerrarConexion($db);
					if($id_incidente!=0){
						return 1;
					}else{
						return -6;//error al almacenar en la bd
					}
				}else{
					$str="UPDATE INCIDENTE SET TIPO_PLAFON='$tipoplafon', DANIO='$danio', REPORTE='$reporte' ".
				     	 "WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND PARTE='$parte' AND FOTO='$rutafoto' AND UNIDAD='$unidad'";
					
					$db=conexion_bd();
					$filasafectadas=modificar($db,$str);
					cerrarConexion($db);
					if($filasafectadas!=0){
						return 1;
					}else{
						$str="SELECT ID_INCIDENTE FROM INCIDENTE WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND PARTE='$parte' AND FOTO='$rutafoto' AND UNIDAD='$unidad' ".
							 " AND TIPO_PLAFON='$tipoplafon' AND DANIO='$danio' AND REPORTE='$reporte' ";

						$db=conexion_bd();
						$id_incidente=consulta($db,$str);
						cerrarConexion($db);
						
						if($id_incidente!=0){
							return 1;
						}else{
							return -6;//error al almacenar en la bd	
						}
						
					}
				}
			}
			//eliminarDirectorio("../../temp/");	
		}else{
			return -3;
		}
		

	}

}

function incidencia(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$tipo=$_REQUEST['tipo'];
	$frente=$_REQUEST['frente'];
	$parte=$_REQUEST['parte'];
	$tipoplafon=$_REQUEST['tipoplafon'];
	$danio=$_REQUEST['danio'];
	$reporte=$_REQUEST['reporte'];
	$unidad=$_REQUEST['unidad'];
	$num_unidad=$_REQUEST['num_unidad'];
	$lugarExpedicion=$_REQUEST['lugarExpedicion'];
	$idpatio=$_REQUEST['idpatio'];
	$str="SELECT ID_INCIDENTE FROM INCIDENTE WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND PARTE='$parte' AND UNIDAD='$unidad'";
	$db=conexion_bd();
	$id_incidente=consulta($db,$str);
	cerrarConexion($db);
	if($id_incidente==0){
		$str="INSERT INTO INCIDENTE (FRENTE, PARTE, TIPO_PLAFON, DANIO, REPORTE, ID_INTERCAMBIO, UNIDAD) ".
	 	 "VALUES ('$frente','$parte','$tipoplafon',$danio,$reporte,$id_intercambio,'$unidad')";
		$db=conexion_bd();
		$id_incidente=insertar($db,$str);
		cerrarConexion($db);
		if($id_incidente!=0){
			return 1;
		}else{
			return -6;//error al almacenar en la bd
		}
	}else{
		$str="UPDATE INCIDENTE SET TIPO_PLAFON='$tipoplafon', DANIO='$danio', REPORTE='$reporte' ".
	     	 "WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND PARTE='$parte' AND UNIDAD='$unidad'";
	
		$db=conexion_bd();
		$filasafectadas=modificar($db,$str);
		cerrarConexion($db);
		if($filasafectadas!=0){
			return 1;
		}else{
			$str="SELECT ID_INCIDENTE FROM INCIDENTE WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND PARTE='$parte' AND UNIDAD='$unidad' ".
				 " AND TIPO_PLAFON='$tipoplafon' AND DANIO='$danio' AND REPORTE='$reporte' ";
			$db=conexion_bd();
			$id_incidente=consulta($db,$str);
			cerrarConexion($db);
			if($id_incidente!=0){
				return 1;
			}else{
				return -6;//error al almacenar en la bd	
			}

			
		}
	}
	
}

function fotollanta(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$tipo=$_REQUEST['tipo'];
	$frente=$_REQUEST['frente'];
	$danio=$_REQUEST['danio'];
	$unidad=$_REQUEST['unidad'];
	$num_unidad=$_REQUEST['num_unidad'];
	$lugarExpedicion=$_REQUEST['lugarExpedicion'];
	$idpatio=$_REQUEST['idpatio'];
	$num_llanta=$_REQUEST['num_llanta'];
	$rin=$_REQUEST['rin'];
	$marca=$_REQUEST['marca'];
	$parte=$_REQUEST['parte'];
	$profundidad=$_REQUEST['profundidad'];

	$str="SELECT IP_FTP, USER_FTP, PASS_FTP FROM PATIO WHERE ID_PATIO=$idpatio";
	$db=conexion_bd();
	$ftp=consulta($db,$str);
	cerrarConexion($db);
	if($ftp==0){
		return 0;//no se tiene los parametros almacenados para conectarse al ftp y almacenar las fotos
	}else{
		$ftp=$ftp[0];
		$ruta="INTERCAMBIOS/".$lugarExpedicion."/".date('Y')."/".date('n')."/".date('j')."/";
		if($tipo=='E'){
			$ruta.="ENTRADA/";
		}else{
			$ruta.="SALIDA/";
		}
		$ruta.="FOLIO_".$id_intercambio."/";
		if($unidad=="C"){
			$ruta.="CAJA_";
		}else{
			$ruta.="TRACTOR_";
		}
		$ruta.=$num_unidad."/".$frente;
		$nombreArchivo=$parte;
		$res=subirFoto($ftp['IP_FTP'],$ftp['USER_FTP'],$ftp['PASS_FTP'],$ruta,$nombreArchivo);

		if($res!=1){
			return $res;
		}else{
			$rutafoto=$ruta.'/'.$nombreArchivo.".jpeg";
			//checar si no habian ya subido una foto de ese daño o parte
			$str="SELECT ID_LLANTA FROM LLANTA WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND NUM_LLANTA=$num_llanta AND UNIDAD='$unidad'";
			$db=conexion_bd();
			$id_llanta=consulta($db,$str);
			cerrarConexion($db);
			if($id_llanta==0){
				$str="INSERT INTO LLANTA (FRENTE, NUM_LLANTA, RIN, MARCA, DANIO, FOTO, ID_INTERCAMBIO, UNIDAD, PROFUNDIDAD) ".
				 	 "VALUES ('$frente',$num_llanta,'$rin','$marca','$danio','$rutafoto',$id_intercambio,'$unidad', $profundidad)";
				$db=conexion_bd();

				$id_llanta=insertar($db,$str);
				cerrarConexion($db);
				if($id_llanta!=0){
					return 1;
				}else{
					return -6;//error al almacenar en la bd
				}
			}else{
				$str="UPDATE LLANTA SET RIN='$rin', MARCA='$marca', DANIO='$danio' , FOTO='$rutafoto', PROFUNDIDAD=$profundidad ".
				     "WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND NUM_LLANTA=$num_llanta  AND UNIDAD='$unidad'";
				
				$db=conexion_bd();
				$filasafectadas=modificar($db,$str);
				cerrarConexion($db);
				if($filasafectadas!=0){
					return 1;
				}else{
					$str="SELECT ID_LLANTA FROM LLANTA WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND NUM_LLANTA=$num_llanta AND UNIDAD='$unidad' ".
						 "AND RIN='$rin' AND MARCA='$marca' AND DANIO='$danio' AND FOTO='rutaFoto' AND PROFUNDIDAD=$profundidad ";
					$db=conexion_bd();
					$id_llanta=consulta($db,$str);
					cerrarConexion($db);
					if($id_llanta!=0){
						return 1;
					}else{
						return -6;//error al almacenar en la bd	
					}	 
					
				}
			}
			
		}
	}
}

function llanta(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$tipo=$_REQUEST['tipo'];
	$frente=$_REQUEST['frente'];
	$danio=$_REQUEST['danio'];
	$unidad=$_REQUEST['unidad'];
	$num_unidad=$_REQUEST['num_unidad'];
	$lugarExpedicion=$_REQUEST['lugarExpedicion'];
	$idpatio=$_REQUEST['idpatio'];
	$num_llanta=$_REQUEST['num_llanta'];
	$rin=$_REQUEST['rin'];
	$marca=$_REQUEST['marca'];
	$parte=$_REQUEST['parte'];
	$profundidad=$_REQUEST['profundidad'];

	$str="SELECT ID_LLANTA FROM LLANTA WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND NUM_LLANTA=$num_llanta AND UNIDAD='$unidad'";
	$db=conexion_bd();
	$id_llanta=consulta($db,$str);
	cerrarConexion($db);

	if($id_llanta==0){
		$str="INSERT INTO LLANTA (FRENTE, NUM_LLANTA, RIN, MARCA, DANIO, ID_INTERCAMBIO, UNIDAD, PROFUNDIDAD) ".
					 	 "VALUES ('$frente',$num_llanta,'$rin','$marca','$danio',$id_intercambio,'$unidad', $profundidad)";
	    
		$db=conexion_bd();
		$id_llanta=insertar($db,$str);
		cerrarConexion($db);
		if($id_llanta!=0){
			return 1;
		}else{
			return -6;//error al almacenar en la bd
		}
	}else{
		$str="UPDATE LLANTA SET RIN='$rin', MARCA='$marca', DANIO='$danio', FOTO=null, PROFUNDIDAD=$profundidad ".
		     "WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND NUM_LLANTA=$num_llanta AND UNIDAD='$unidad'";
				
		$db=conexion_bd();
		$filasafectadas=modificar($db,$str);
		cerrarConexion($db);

		if($filasafectadas!=0){
			return 1;
		}else{
			$str="SELECT ID_LLANTA FROM LLANTA WHERE ID_INTERCAMBIO=$id_intercambio AND FRENTE='$frente' AND NUM_LLANTA=$num_llanta AND UNIDAD='$unidad' ".
				 " AND RIN='$rin' AND MARCA='$marca' AND DANIO='$danio' AND PROFUNDIDAD=$profundidad AND FOTO IS NULL ";
		    
			$db=conexion_bd();
			$id_llanta=consulta($db,$str);
			
			cerrarConexion($db);
			if($id_llanta!=0){
				return 1;
			}else{
				return -6;//error al almacenar en la bd	
			}
			
		}
	}
	
}

function crearDirectorio($ruta){
	if(!file_exists($ruta)){
		return mkdir($ruta,0777,true);
	}
}

function eliminarDirectorio($ruta){
	if(file_exists($ruta)){
		return rmdir($ruta);
	}
}

function eliminarArchivo($ruta){
	return unlink($ruta);
}


function subirFotoRuta($host,$user,$pass,$ruta_ftp,$ruta_local,$nombreArchivo_ftp){
	$id_ftp=conexion_ftp($host,21,$user,$pass);
	if($id_ftp==-1||$id_ftp==-2){
		return $id_ftp;//no se pudo conectar al ftp
	}else{
		
			if(directorio_ftp($id_ftp,$ruta_ftp)){
				$remoto=$nombreArchivo_ftp;
				if(subir_ftp($id_ftp,$remoto,$ruta_local,FTP_BINARY)){
					cerrar_ftp($id_ftp);
					return 1;//exito al subir la imagen

				}else{
					cerrar_ftp($id_ftp);
					return -5;//error al subir la imagen
				}
			}else{
				cerrar_ftp($id_ftp);
				return -4;// no se pudo acceder o crear el directorio en el ftp
			}
		
	}
}

function guardarIntercambioSA(){
	$id_intercambio=insertarIntercambio();
	//return $id_intercambio;
	if(terminarIntercambioSR($id_intercambio)==1){
		
		return $id_intercambio;

	}else{
		return -1;
	}
}

function terminarIntercambioSR($id){
	$id_intercambio = isset($id)?$id:$_REQUEST['id_intercambio'];
	$id_linea_caja 	= $_REQUEST['id_linea_caja']; // es el ID de la linea
	$num_caja		= $_REQUEST['num_caja'];
	$nombre_linea_caja= $_REQUEST['nombre_linea_caja'];
	$gatas 		= $_REQUEST['gatas'];
	$usuario	= $_REQUEST['usuario'];
	$id_usurio 	= $_REQUEST['id_usuario'];
	$tipo_entrada= $_REQUEST['tipo_entrada'];
	$tractor	= $_REQUEST['tractor'];
	$no_tracto 	= $_REQUEST['no_tractor'];
	$tipo_reg 	= $_REQUEST['tipo_reg'];
	$tractorExtSel = $_REQUEST['tractorExtSel'];
	$tipo_caja=$_REQUEST['tipo_caja'];
	$placas_tractor=$_REQUEST['placas_tractor'];
	$linea_tractor=$_REQUEST['linea_tractor'];
	$num_ope=$_REQUEST['num_ope'];
	$nombre_ope=$_REQUEST['nombre_ope'];
	$ape_pat_ope=$_REQUEST['ape_pat_ope'];
	$ape_mat_ope=$_REQUEST['ape_mat_ope'];
	$log_querys="";
	

	if($tipo_entrada=='S' || $tipo_entrada=='SR'){
		$id_intercambio_entrada_caja=$_REQUEST['id_intercambio_entrada_caja'];
		$id_intercambio_entrada_tractor=$_REQUEST['id_intercambio_entrada_tractor'];
	}
	//echo "id_intercambio_entrada_caja ".$id_intercambio_entrada_caja." id_intercambio ".$id_intercambio." gatas ".$gatas;
	$res_caja=false;
	$res_caja=copiarDatosCaja($id_intercambio_entrada_caja,$id_intercambio, $gatas);

	if($res_caja){
		$res_tractor=false;
		if($tractor=='PROPIO'){
			$res_tractor=insertarTractor($id_intercambio,'INT',$placas_tractor,null, $log_querys);//INT ES TRACTOR INTERNO O PROPIO
			
		}else{
			if($tractorExtSel=='OTRO'){
				$res_tractor=insertarTractor($id_intercambio,'EXT',$placas_tractor,$linea_tractor, $log_querys);//TRACTOR EXTERNO QUE SU LINEA NO ESTA EN EL CATALOGO
				
			}else{
				$res_tractor=insertarTractor($id_intercambio,'EXT',$placas_tractor,null, $log_querys);//TRACTOR EXTERNO CON LINEA EN EL CATALOGO
				
			}
		}
		
		if($res_tractor){
			$res_operador=false;
			$res_operador=insertarOperador($id_intercambio, $nombre_ope, $ape_pat_ope, $ape_mat_ope, $num_ope, $gatas, $log_querys);

			if($res_operador){
				$res_llantas=false;
				$res_llantas=copiarDatosLlantas($id_intercambio_entrada_caja,$id_intercambio);
				
				if($res_llantas){
					$res_incidentes=false;
					$res_incidentes=copiarDatosIncidentes($id_intercambio_entrada_caja,$id_intercambio);
					if($res_incidentes){
						$res_salida_caja=false;
						$res_salida_caja=actualizarSalidaCaja($id_intercambio_entrada_caja,$id_intercambio, $log_querys);
						if($res_salida_caja){
							$res_salida_tractor=false;
							$res_salida_tractor=actualizarSalidaTractor($id_intercambio_entrada_tractor,$id_intercambio, $log_querys);
							if($res_salida_tractor){//actualizar el intercambio para que ya este activo e indicarle que ya se guardo completo
								$res_status_inter=false;
								$res_status_inter=actualizarStatusInter($id_intercambio, $log_querys);
								if($res_status_inter){
									return 1;//ya se almaceno todo correctamente
								}else{
									//return $result.'}';
									return -1;//error al cambiar el estatus del inter a activo y prender bandera de que se almaceno correctamente
								}
							}else{
								//return $result.'}';
								return -1;
							}
						}else{
							//return $result.'}';
							return -1;// no se pudo actualizar el id de la salida en el intercambio de entrada
						}
					}else{
						return-1;
					}
				}else{
					return -1;
				}
			}else{
				return -1;
			}
		}else{
			return -1;
		}	
	}else{
		return -1;
	}
}

function copiarDatosIncidentes($id_intercambio_entrada,$id_intercambio){
	$str=" DELETE FROM INCIDENTE WHERE ID_INTERCAMBIO=".$id_intercambio." AND PARTE!='FIRMA' ";
	$db=conexion_bd();
	$rows=modificar($db,$str);
	cerrarConexion($db);

	$str=" SELECT FRENTE, PARTE, TIPO_PLAFON, DANIO, REPORTE, UNIDAD ".
		 " FROM INCIDENTE ".
		 " WHERE ID_INTERCAMBIO=".$id_intercambio_entrada;
	$db=conexion_bd();
	$incidentes=consulta($db,$str);
	cerrarConexion($db);
	if($incidentes!=0 && count($incidentes)>0){
		
			foreach ($incidentes as $incidente) {

				$str2=" INSERT INTO INCIDENTE (FRENTE,PARTE,TIPO_PLAFON,DANIO,REPORTE,UNIDAD, ID_INTERCAMBIO) ".
					  " VALUES ('".$incidente['FRENTE']."','".$incidente['PARTE']."', ".
					  " '".$incidente['TIPO_PLAFON']."', '".$incidente['DANIO']."', '".$incidente['REPORTE']."', ".
			  		  " '".$incidente['UNIDAD']."' , '".$id_intercambio."' ".
					  " )";
				$db=conexion_bd();
				$id_incidente=insertar($db,$str2);
				cerrarConexion($db);
				if(!is_numeric($id_incidente) || $id_incidente==0){
					return false;
				}
			
			}
			return true;
		
	}else{
		return true;
	}	 

}

function copiarDatosLLantas($id_intercambio_entrada,$id_intercambio){
	$str=" DELETE FROM LLANTA WHERE ID_INTERCAMBIO=".$id_intercambio;
	$db=conexion_bd();
	$rows=modificar($db,$str);
	cerrarConexion($db);

	$str=" SELECT FRENTE, NUM_LLANTA, RIN, MARCA, DANIO , FOTO, UNIDAD, PROFUNDIDAD ".
		 " FROM LLANTA ".
		 " WHERE ID_INTERCAMBIO=".$id_intercambio_entrada;

	$db=conexion_bd();
	$llantas=consulta($db,$str);
	cerrarConexion($db);
	
	if($llantas!=0 && count($llantas)>0){
		
			foreach ($llantas as $llanta) {
				$str2=" INSERT INTO LLANTA (FRENTE,NUM_LLANTA,RIN,MARCA,DANIO,UNIDAD, ID_INTERCAMBIO, PROFUNDIDAD) ".
					  " VALUES ('".$llanta['FRENTE']."','".$llanta['NUM_LLANTA']."', ".
					  " '".$llanta['RIN']."', '".$llanta['MARCA']."', '".$llanta['DANIO']."', ".
			  		  " '".$llanta['UNIDAD']."' , '".$id_intercambio."' , '".$llanta['PROFUNDIDAD']."' ".
					  " )";
				$db=conexion_bd();
				$id_llanta=insertar($db,$str2);
				cerrarConexion($db);
				if(!is_numeric($id_llanta) || $id_llanta==0){
					return false;
				}
			
			}
			return true;
		
	}else{
		return true;
	}	 

}


function copiarDatosCaja($id_intercambio_entrada,$id_intercambio, $gatas){
	$str=" DELETE FROM CAJA WHERE ID_INTERCAMBIO=".$id_intercambio;
	$db=conexion_bd();
	$rows=modificar($db,$str);
	cerrarConexion($db);

	$str=" SELECT ESTADO, PLACAS, MARCA_THERMO, ESTADO_THERMO, DIESEL, TEMP_REAL, TEMP_PROG, HORIMETRO, ".
		 " SELLO1, SELLO2, SELLO3, GATAS, DANIOS, ALARMA, ALARMA2, ALARMA3, ODOMETRO, NUM_DANIOS, REFACCION, ".
		 " MANIBELA, TAPON_DIESEL, SELLO_SEGURIDAD, TIPO_CAJA , CANDADO, BATERIA , DOT ".
		 " FROM CAJA ".
		 " WHERE ID_INTERCAMBIO=".$id_intercambio_entrada;
	$db=conexion_bd();
	$caja=consulta($db,$str);
	cerrarConexion($db);
	if($caja!=0){
		$caja=$caja[0];
		$str="INSERT INTO CAJA (".
		 " ID_INTERCAMBIO , ".
		 " ESTADO , ".
		 " PLACAS , ".
		 " MARCA_THERMO , ".
		 " ESTADO_THERMO , ".
		 " DIESEL , ".
		 " TEMP_REAL , ".
		 " TEMP_PROG , ".
		 " HORIMETRO , ".
		 " SELLO1 , ".
		 " SELLO2 , ".
		 " SELLO3 , ".
		 " GATAS , ".//CHECAR SI ESTO SE INSERTA AQUI O SOLO EN OPERADOR
		 " DANIOS , ".//CONTAR NUMERO DE DANIOS DE INCIDENTE
		 " ALARMA , ".
		 " ALARMA2 , ".
		 " ALARMA3 , ".
		 " ODOMETRO , ".
		 " NUM_DANIOS , ".
		 " REFACCION , ".
		 " MANIBELA , ".
		 " TAPON_DIESEL , ".
		 " SELLO_SEGURIDAD, ".
		 " TIPO_CAJA, ".
		 " CANDADO, ".
		 " BATERIA, ".
		 " DOT ".
		 " )".
		 " VALUES ( ".
		 " ".$id_intercambio." , ".
		 " '".$caja['ESTADO']."' , ".
		 " '".$caja['PLACAS']."' , ".
		 " '".$caja['MARCA_THERMO']."' , ".
		 " '".$caja['ESTADO_THERMO']."' , ".
		 " '".$caja['DIESEL']."' , ".
		 " '".$caja['TEMP_REAL']."' , ".
		 " '".$caja['TEMP_PROG']."' , ".
		 " '".$caja['HORIMETRO']."' , ".
		 " '".$caja['SELLO1']."' , ".
		 " '".$caja['SELLO2']."' , ".
		 " '".$caja['SELLO3']."' , ".
		 " '".$gatas."' , ".
		 " ".$caja['DANIOS']." , ".
		 " '".$caja['ALARMA']."' , ".
		 " '".$caja['ALARMA2']."' , ".
		 " '".$caja['ALARMA3']."' , ".
		 " '".$caja['ODOMETRO']."' , ".
		 " '".$caja['NUM_DANIOS']."' , ".
		 " ".$caja['REFACCION']." , ".
		 " ".$caja['MANIBELA']." , ".
		 " ".$caja['TAPON_DIESEL']." , ".
		 " '".$caja['SELLO_SEGURIDAD']."' , ".
		 " '".$caja['TIPO_CAJA']."' , ".
		 " '".$caja['CANDADO']."' , ".
		 " '".$caja['BATERIA']."' , ".
		 " '".$caja['DOT']."' ".
		 ") ";
		//echo $str; 
		$db=conexion_bd();
		$id_caja=insertar($db,$str);
		cerrarConexion($db);
		if( is_numeric($id_caja) && $id_caja!=0){
			return true;
		}else{
			return false;//error al almacenar en la bd
		}
	}else{
		return false;
	}
}

function terminarIntercambio(){
	$id_intercambio = $_REQUEST['id_intercambio'];
	$id_linea_caja 	= $_REQUEST['id_linea_caja']; // es el ID de la linea
	$num_caja		= $_REQUEST['num_caja'];
	$nombre_linea_caja= $_REQUEST['nombre_linea_caja'];
	$thermo 	= $_REQUEST['thermo'];
	$diesel 	= $_REQUEST['diesel'];
	$temp_real 	= $_REQUEST['real'];
	$temp_prog 	= $_REQUEST['prog'];
	$horimetro 	= $_REQUEST['horimetro'];
	$S1 		= $_REQUEST['sello1'];
	$S2 		= $_REQUEST['sello2'];
	$S3 		= $_REQUEST['S3']; // sello sagarpa
	$gatas 		= $_REQUEST['gatas'];
	$alarma 	= $_REQUEST['alarma'];
	$usuario	= $_REQUEST['usuario'];
	$id_usurio 	= $_REQUEST['id_usuario'];
	$placas_caja= $_REQUEST['placas_caja'];
	$tipo_entrada= $_REQUEST['tipo_entrada'];
	
	$tractor	= $_REQUEST['tractor'];
	$estado_caja 	= $_REQUEST['estado_caja'];
	$no_tracto 	= $_REQUEST['no_tractor'];
	$alarma2 	= $_REQUEST['alrm2'];
	$alarma3 	= $_REQUEST['alrm3'];
	$odometro 	= $_REQUEST['odometro'];
	$tipo_reg 	= $_REQUEST['tipo_reg'];
	$marcaThermo 	= $_REQUEST['marca_thermo'];
	$refaccion 	= $_REQUEST['refaccion'];
	$taponDiesel 	= $_REQUEST['taponDiesel'];
	$manibela 	= $_REQUEST['manibela'];
	$selloSeguridad = $_REQUEST['selloseguridad']; 
	$candado=$_REQUEST['candado'];
	$tractorExtSel = $_REQUEST['tractorExtSel'];
	$tipo_caja=$_REQUEST['tipo_caja'];
	$placas_tractor=$_REQUEST['placas_tractor'];
	$linea_tractor=$_REQUEST['linea_tractor'];
	$num_ope=$_REQUEST['num_ope'];
	$nombre_ope=$_REQUEST['nombre_ope'];
	$ape_pat_ope=$_REQUEST['ape_pat_ope'];
	$ape_mat_ope=$_REQUEST['ape_mat_ope'];
	$bateria=$_REQUEST['bateria'];
	$dot=$_REQUEST['dot'];
	$dot_array=explode('/',$dot);
	$dot=$dot_array[1].'-'.$dot_array[0].'-01';
	$diesel_persona=strtoupper($_REQUEST['diesel_persona']);
	$diesel_razones=strtoupper($_REQUEST['diesel_razones']);
	$num_llantas=$_REQUEST['num_llantas'];
	$log_querys="";


	if($selloSeguridad==null || $selloSeguridad=='null'){
		$selloSeguridad='';
	}

	if($candado==null || $candado=='null'){
		$candado='';
	}



	if($tipo_entrada=='S'){
		$id_intercambio_entrada_caja=$_REQUEST['id_intercambio_entrada_caja'];
		$id_intercambio_entrada_tractor=$_REQUEST['id_intercambio_entrada_tractor'];
	}
	

	if($estado_caja == 'VACIA'){
	 	$realSys = "";
	 	$progSys = "";
	}
	
	$num_danios=contarDanios($id_intercambio,'C', $log_querys);
 	$result='{num_danios:'.$num_danios.' , ';
	if(is_numeric($num_danios) && $num_danios!=-1){// no hubo errores al contar los daños en la caja
		if($num_danios>0){
			$danios=1;	
		}else{
			$danios=0;
		}
		$res_caja=false;
		$res_caja=insertarCaja($id_intercambio, $estado_caja, $placas_caja, $marcaThermo, $thermo, $diesel, $temp_real, $temp_prog, $horimetro, $S1, $S2, $S3, $gatas, $danios, $alarma, $alarma2, $alarma3, $odometro, $num_danios, $refaccion, $manibela, $taponDiesel, $selloSeguridad, $tipo_caja , $candado, $bateria, $dot, $log_querys);
		$res_diesel=true;
		$res_llantas=true;
		if($diesel<75 && $diesel_persona!='' && $diesel_razones!=''){
			$res_diesel=insertarDiesel($id_intercambio,$diesel_persona,$diesel_razones, $log_querys);	
		}
		if($num_llantas==2){
			$res_llantas=borrarLlantasExcedentes($id_intercambio,$log_querys);
		}
		$result.='res_caja:'.$res_caja.' , ';
		if($res_caja && $res_diesel){
			 // si se inserta en caja sigue insertar en tractor
			$res_tractor=false;
			if($tractor=='PROPIO'){
				$res_tractor=insertarTractor($id_intercambio,'INT',$placas_tractor,null, $log_querys);//INT ES TRACTOR INTERNO O PROPIO
				$result.='res_tractor:'.$res_tractor.' , ';
			}else{
				if($tractorExtSel=='OTRO'){
					$res_tractor=insertarTractor($id_intercambio,'EXT',$placas_tractor,$linea_tractor, $log_querys);//TRACTOR EXTERNO QUE SU LINEA NO ESTA EN EL CATALOGO
					$result.='res_tractor:'.$res_tractor.' , ';
				}else{
					$res_tractor=insertarTractor($id_intercambio,'EXT',$placas_tractor,null, $log_querys);//TRACTOR EXTERNO CON LINEA EN EL CATALOGO
					$result.='res_tractor:'.$res_tractor.' , ';
				}
			}
			if($res_tractor){//luego insertar en operador
				$res_operador=false;
				$res_operador=insertarOperador($id_intercambio, $nombre_ope, $ape_pat_ope, $ape_mat_ope, $num_ope, $gatas, $log_querys);
				$result.='res_operador:'.$res_operador.' , ';
				if($res_operador){// sigue hacer update a los intercambios de entrada de la caja y el tractor si este es de salida
					if($tipo_entrada=='S'){
						//actualizar id_intercambio de salida de tractor y caja
						$res_salida_caja=false;
						$res_salida_caja=actualizarSalidaCaja($id_intercambio_entrada_caja,$id_intercambio, $log_querys);
						$result.='res_salida_caja:'.$res_salida_caja.'  ';
						if($res_salida_caja){
							$res_salida_tractor=false;
							$res_salida_tractor=actualizarSalidaTractor($id_intercambio_entrada_tractor,$id_intercambio, $log_querys);
							$result.='res_salida_tractor:'.$res_salida_tractor.'  ';
							if($res_salida_tractor){
								//actualizar el intercambio para que ya este activo e indicarle que ya se guardo completo
								$res_status_inter=false;
								$res_status_inter=actualizarStatusInter($id_intercambio, $log_querys);
								$result.='res_status_inter:'.$res_status_inter.'  ';
								if($res_status_inter){
									return 1;//ya se almaceno todo correctamente
								}else{
									//return $result.'}';
									enviarCorreoError($id_intercambio,$log_querys,'error al cambiar el estatus del inter a activo y prender bandera de que se almaceno correctamente');
									return -1;//error al cambiar el estatus del inter a activo y prender bandera de que se almaceno correctamente
								}
							}else{
								//return $result.'}';
								enviarCorreoError($id_intercambio,$log_querys,'error al actualizar la salida del tractor');
								return -1;
							}
						}else{
							//return $result.'}';
							enviarCorreoError($id_intercambio,$log_querys,'error al actualizar la salida de la caja');
							return -1;// no se pudo actualizar el id de la salida en el intercambio de entrada
						}
					}else{
						$res_status_inter=false;
						$res_status_inter=actualizarStatusInter($id_intercambio, $log_querys);
						$result.='res_status_inter:'.$res_status_inter.'  ';
						if($res_status_inter){
							
							return 1;//ya se almaceno todo correctamente
						}else{
							//return $result.'}';
							enviarCorreoError($id_intercambio,$log_querys,'error al cambiar el estatus del inter a activo y prender bandera de que se almaceno correctamente');
							return -1;//error al cambiar el estatus del inter a activo y prender bandera de que se almaceno correctamente
						}
					}
				}else{
					//return $result.'}';
					enviarCorreoError($id_intercambio,$log_querys,'error al insertar el operador');
									
					return -1;// no se pudo terminar el intercambio no se inserto en operador
				}
				
			}else{
				//return $result.'}';
				enviarCorreoError($id_intercambio,$log_querys,'error al insertar el tractor');
				return -1;// no se pudo terminar intercambio no se inserto el tractor
			}
		}else{
			//return $result.'}';
			enviarCorreoError($id_intercambio,$log_querys,'error al insertar la caja');
			return -1;//no se pudo terminar el intercambio no se inserto la caja
		}	
	}else{
		//return $result.'}';
		enviarCorreoError($id_intercambio,$log_querys,'error al contar los daños');
		return -1;// no se pudo terminar el intercambio no se pudo contar los danios a la caja
	}
	





}

function enviarCorreoError($id_intercambio,$log,$error){
	$correos=array(array('CORREO'=>'gpadilla@frioexpress.com', 'ALIAS'=>'ANA GABRIELA PADILLA'));
	$body="ERROR AL TERMINAR EL INTERCAMBIO CON FOLIO ".$id_intercambio."<br>".$error."QUERYS EJECUTADOS: <br>".$log;
	correo($body,"ERROR INTERCAMBIO PRIME"," intercambio con id: ".$id_intercambio." fecha: ".date('m/d/Y H:i'),$correos);

}

function borrarLlantasExcedentes($id_intercambio, &$log){
	$str=" DELETE FROM LLANTA WHERE ID_INTERCAMBIO=".$id_intercambio." AND NUM_LLANTA IN (13,14,15,16) ";
	$log.='<br>'.$str;
	$db=conexion_bd();
	$rows=modificar($db,$str);
	cerrarConexion($db);
	if($rows===0 || $rows>0){
		return true;
	}else{
		return false;
	}
}

function insertarCaja($id_intercambio, $estado_caja, $placas_caja, $marca_thermo, $thermo, $diesel, $temp_real, $temp_prog, $horimetro, $S1, $S2, $S3, $gatas, $danios, $alarma, $alarma2, $alarma3, $odometro, $num_danios, $refaccion, $manibela, $taponDiesel, $selloSeguridad, $tipo_caja, $candado, $bateria, $dot , &$log){
	$str=" DELETE FROM CAJA WHERE ID_INTERCAMBIO=".$id_intercambio;
	$log.='<br>'.$str;
	$db=conexion_bd();
	$rows=modificar($db,$str);
	cerrarConexion($db);

	$danios=validarBinarios($danios);
	$refaccion=validarBinarios($refaccion);
	$manibela=validarBinarios($manibela);
	$taponDiesel=validarBinarios($taponDiesel);

	$str="INSERT INTO CAJA (".
		 " ID_INTERCAMBIO , ".
		 " ESTADO , ".
		 " PLACAS , ".
		 " MARCA_THERMO , ".
		 " ESTADO_THERMO , ".
		 " DIESEL , ".
		 " TEMP_REAL , ".
		 " TEMP_PROG , ".
		 " HORIMETRO , ".
		 " SELLO1 , ".
		 " SELLO2 , ".
		 " SELLO3 , ".
		 " GATAS , ".//CHECAR SI ESTO SE INSERTA AQUI O SOLO EN OPERADOR
		 " DANIOS , ".//CONTAR NUMERO DE DANIOS DE INCIDENTE
		 " ALARMA , ".
		 " ALARMA2 , ".
		 " ALARMA3 , ".
		 " ODOMETRO , ".
		 " NUM_DANIOS , ".
		 " REFACCION , ".
		 " MANIBELA , ".
		 " TAPON_DIESEL , ".
		 " SELLO_SEGURIDAD, ".
		 " TIPO_CAJA, ".
		 " CANDADO, ".
		 " BATERIA, ".
		 " DOT ".
		 " )".
		 " VALUES ( ".
		 " ".$id_intercambio." , ".
		 " '".$estado_caja."' , ".
		 " '".$placas_caja."' , ".
		 " '".$marca_thermo."' , ".
		 " '".$thermo."' , ".
		 " '".$diesel."' , ".
		 " '".$temp_real."' , ".
		 " '".$temp_prog."' , ".
		 " '".$horimetro."' , ".
		 " '".$S1."' , ".
		 " '".$S2."' , ".
		 " '".$S3."' , ".
		 " '".$gatas."' , ".
		 " ".$danios." , ".
		 " '".$alarma."' , ".
		 " '".$alarma2."' , ".
		 " '".$alarma3."' , ".
		 " '".$odometro."' , ".
		 " '".$num_danios."' , ".
		 " ".$refaccion." , ".
		 " ".$manibela." , ".
		 " ".$taponDiesel." , ".
		 " '".$selloSeguridad."' , ".
		 " '".$tipo_caja."' , ".
		 " '".$candado."' , ".
		 " '".$bateria."', ".
		 " '".$dot."' ".
		 ") ";
	$log.='<br>'.$str;
		//echo $str; 
		$db=conexion_bd();
		$id_caja=insertar($db,$str);
		cerrarConexion($db);
		if(is_numeric($id_caja) && $id_caja!=0){
			return true;
		}else{
			return false;//error al almacenar en la bd
		}
}

function insertarDiesel($id_intercambio, $diesel_persona, $diesel_razones, &$log){
	$str=" DELETE FROM DIESEL WHERE ID_INTERCAMBIO=".$id_intercambio;
	$log.='<br>'.$str;
	$db=conexion_bd();
	$rows=modificar($db,$str);
	cerrarConexion($db);

	
	$str="INSERT INTO DIESEL (".
		 " ID_INTERCAMBIO , ".
		 " PERSONA_AUTORIZO , ".
		 " RAZON  ".
		 " )".
		 " VALUES ( ".
		 " ".$id_intercambio." , ".
		 " '".$diesel_persona."' , ".
		 " '".$diesel_razones."'  ".
		 ") ";
		//echo $str; 
		$log.='<br>'.$str;
		$db=conexion_bd();
		$id_diesel=insertar($db,$str);
		cerrarConexion($db);
		if(is_numeric($id_diesel) && $id_diesel!=0){
			return true;
		}else{
			return false;//error al almacenar en la bd
		}
}

function validarBinarios($x){
	if($x==0 || $x=='0'){
		return 0;
	}
	if($x==1 || $x=='1'){
		return 1;
	}
	return null;
}

function contarDanios($id_intercambio, $unidad, &$log){
	$str="SELECT COUNT(*) AS NUM_DANIOS FROM INCIDENTE WHERE ID_INTERCAMBIO=".$id_intercambio." AND DANIO=1 AND UNIDAD='".$unidad."'";
	$log.='<br>'.$str;
	$db=conexion_bd();
	$num_danios=consulta($db,$str);
	cerrarConexion($db);
	if($num_danios!=0){
		return $num_danios[0][0];
	}else{
		return -1;
	}
}

function insertarTractor($id_intercambio, $tipo_tractor, $placas, $otra_linea, &$log){
	$str=" DELETE FROM TRACTOR WHERE ID_INTERCAMBIO=".$id_intercambio;
	$log.='<br>'.$str;
	$db=conexion_bd();
	$rows=modificar($db,$str);
	cerrarConexion($db);

	if($otra_linea!=null){
		$str="INSERT INTO TRACTOR (".
		 " ID_INTERCAMBIO , ".
		 " TIPO , ".
		 " PLACAS , ".
		 " OTRA_LINEA ".
		 " ) VALUES ( ".
		 " ".$id_intercambio." , ".
		 " '".$tipo_tractor."' , ".
		 " '".$placas."' , ".
		 " '".$otra_linea."'  ".
		 " )";
	
	}else{
		$str="INSERT INTO TRACTOR (".
		 " ID_INTERCAMBIO , ".
		 " TIPO , ".
		 " PLACAS , ".
		 " OTRA_LINEA ".
		 " ) VALUES ( ".
		 " ".$id_intercambio." , ".
		 " '".$tipo_tractor."' , ".
		 " '".$placas."' , ".
		 "  NULL ".
		 " )";	
	}
	$log.='<br>'.$str;
	$db=conexion_bd();
	$id_tractor=insertar($db,$str);
	cerrarConexion($db);
	
	if(is_numeric($id_tractor) && $id_tractor!=0){
		return true;
	}else{
		return false;//error al almacenar en la bd
	}
	

}

function insertarOperador($id_intercambio, $nombre, $ape_p, $ape_m, $num_ope, $gatas, &$log){
	$str=" DELETE FROM OPERADOR WHERE ID_INTERCAMBIO=".$id_intercambio;
	$log.='<br>'.$str;
	$db=conexion_bd();
	$rows=modificar($db,$str);
	cerrarConexion($db);

	$str="INSERT INTO OPERADOR (".
		 " ID_INTERCAMBIO , ".
		 " NOMBRE , ".
		 " APE_P , ".
		 " APE_M , ".
		 " NUM_OPE , ".
		 " GATAS ".
		 " ) VALUES ( ".
		 " ".$id_intercambio." , ".
		 " '".$nombre."' , ".
		 " '".$ape_p."' , ".
		 " '".$ape_m."' , ".
		 " ".$num_ope." , ".
		 " ".$gatas." ".
		 " ) ";
	$log.='<br>'.$str;
	$db=conexion_bd();
	$id_operador=insertar($db,$str);
	cerrarConexion($db);
	
	if(is_numeric($id_operador) && $id_operador!=0){
		return true;
	}else{
		return false;//error al almacenar en la bd
	}
}

function actualizarSalidaCaja($id_intercambio_entrada_caja,$id_intercambio,&$log){
	$str=" UPDATE INTERCAMBIO SET ".
		 " ID_INTER_SAL_CAJA=".$id_intercambio.
		 " WHERE ".
		 " ID_INTERCAMBIO=".$id_intercambio_entrada_caja." ";
	$log.='<br>'.$str;
	$db=conexion_bd();
	$filas=modificar($db,$str);
	cerrarConexion($db);
	if(is_numeric($filas) && $filas>0){
		
		return true;
	}else{
		$str='SELECT ID_INTERCAMBIO FROM INTERCAMBIO WHERE ID_INTER_SAL_CAJA='.$id_intercambio." AND ID_INTERCAMBIO=".$id_intercambio_entrada_caja." ";
		$log.='<br>'.$str;
		$db=conexion_bd();
		$reg=consulta($db,$str);
		cerrarConexion($db);
		if($reg!=0){
			return true;
		}else{
			return false;	
		}
		
	}
}

function actualizarSalidaTractor($id_intercambio_entrada_tractor,$id_intercambio, &$log){
	if($id_intercambio_entrada_tractor!=0 && $id_intercambio_entrada_tractor!='0'){
		$str=" UPDATE INTERCAMBIO SET ".
			 " ID_INTER_SAL_TRACTOR=".$id_intercambio.
			 " WHERE ".
			 " ID_INTERCAMBIO=".$id_intercambio_entrada_tractor." ";
	 	$log.='<br>'.$str;
		$db=conexion_bd();
		$filas=modificar($db,$str);
		cerrarConexion($db);
		if(is_numeric($filas) && $filas>0){
			
			return true;
		}else{
			$str='SELECT ID_INTERCAMBIO FROM INTERCAMBIO WHERE ID_INTER_SAL_TRACTOR='.$id_intercambio." AND ID_INTERCAMBIO=".$id_intercambio_entrada_tractor." ";
			$log.='<br>'.$str;
			$db=conexion_bd();
			$reg=consulta($db,$str);
			cerrarConexion($db);
			if($reg!=0){
				return true;
			}else{
				return false;	
			}
		}	
	}else{
		return true;
	}
		
}

function actualizarStatusInter($id_intercambio, &$log){
	$str=" UPDATE INTERCAMBIO SET ".
		 " STATUS=1 , ".
		 " REG_COMPLETO=1  ".
		 " WHERE ".
		 " ID_INTERCAMBIO=".$id_intercambio." ";
	$log.='<br>'.$str;
	$db=conexion_bd();
	$filas=modificar($db,$str);
	cerrarConexion($db);
	if(is_numeric($filas) && $filas>0){
		
		return true;
	}else{
		// si ya se habia hecho el update antes
		$str="SELECT COUNT(*) FROM INTERCAMBIO WHERE STATUS=1 AND REG_COMPLETO=1 AND ID_INTERCAMBIO=".$id_intercambio." ";
		$log.='<br>'.$str;
		$db=conexion_bd();
		$num_reg=consulta($db,$str);
		cerrarConexion($db);
		if($num_reg!=0 && $num_reg[0][0]!=0 && $num_reg[0][0]!='0'){
			return true;
		}else{
			return false;	
		}
		
	}		
}

function reportarTemperaturas(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$tipo_entrada=$_REQUEST['tipo_entrada'];
	$caja=$_REQUEST['caja'];
	$status_thermo=$_REQUEST['statusthermo'];
	$setpoint=$_REQUEST['setpoint'];
	$real=$_REQUEST['real'];
	$patio=$_REQUEST['patio'];
	$str="SELECT CORREO, ALIAS FROM NOTIFICACION WHERE DIF_TEMPERATURA=1 AND STATUS=1";
	$db=conexion_bd();
	$correos=consulta($db,$str);
	cerrarConexion($db);
	if($correos!=0){
		if(count($correos)>0){
			//hay al menos un correo registrado para recibir notificaciones de temperatura
			if($tipo_entrada=='E'){
				$tipoIntercambio='ARRIVAL';
			}else{
				$tipoIntercambio='DEPARTURE';
			}
			$cuerpo="<table style='width:100%; border-collapse: collapse;'><tr style='font-size:17px; width=100%; color:red; ' text-align='center'><th>The following inspection shows temperature difference </th></tr></table>".
					"<table style=' border-collapse: collapse; font-size:17px;'>".

								"<tr>".
										"<th style='padding:5px; color:#05B;' align='left'>Location: </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$patio."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$caja."</td>".
								"</tr>".
					"</table><br><br>".
					"<table style='border: 1px solid #ddd; border-collapse: collapse; font-size:17px;' width='50%'>".
						"<tr style=''>".
							"<td colspan='2' align='center' style='background-color: #2E72C5; color: white;'><b>TEMPERATURES</b></td>".
						"</tr>".
						"<tr style='border-bottom: 1px solid #ddd;'>".
							"<td style='border-bottom: 1px solid #ddd;' align='left'>SET POINT</td>".
							"<td style='border-bottom: 1px solid #ddd;' align='left'>".$setpoint."</td>".
						"</tr>".
						"<tr style='border-bottom: 1px solid #ddd;'>".
							"<td style='border-bottom: 1px solid #ddd;' align='left'>BOX TEMPERATURE</td>".
							"<td style='border-bottom: 1px solid #ddd;' align='left'>".$real."</td>".
						"</tr>".
						"</table>";
			return correo($cuerpo,"AUTOMATIC ALERT",$tipoIntercambio." TRAILER: ".$caja."-TEMPERATURE DIFFERENCE :".date('m/d/Y H:i'),$correos);



		}else{
			return 1;
		}
	}else{
		return 1;
	}

}

function reportarDOT(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$tipo_entrada=$_REQUEST['tipo_entrada'];
	$caja=$_REQUEST['caja'];
	$patio=$_REQUEST['patio'];
	$dot=$_REQUEST['dot'];
	$str="SELECT CORREO, ALIAS FROM NOTIFICACION WHERE DOT=1 AND STATUS=1";
	$db=conexion_bd();
	$correos=consulta($db,$str);
	cerrarConexion($db);
	if($correos!=0){
		if(count($correos)>0){
			//hay al menos un correo registrado para recibir notificaciones de temperatura
			if($tipo_entrada=='E'){
				$tipoIntercambio='ARRIVAL';
			}else{
				$tipoIntercambio='DEPARTURE';
			}
			$cuerpo="<table style='width:100%; border-collapse: collapse;'><tr style='font-size:17px; width=100%; color:red; ' text-align='center'><th>DOT Inspection Date Expired </th></tr></table>".
					"<table style=' border-collapse: collapse; font-size:17px;'>".

								"<tr>".
										"<th style='padding:5px; color:#05B;' align='left'>Location: </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$patio."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$caja."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>DOT Inspection : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$dot."</td>".
								"</tr>".
					"</table><br><br>";
			return correo($cuerpo,"AUTOMATIC ALERT",$tipoIntercambio." TRAILER: ".$caja."-DOT Inspection Date Expired ",$correos);



		}else{
			return 1;
		}
	}else{
		return 1;
	}

}

function reportarDiesel(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$str="SELECT CORREO, ALIAS FROM NOTIFICACION WHERE DIESEL=1 AND STATUS=1";
	$db=conexion_bd();
	$correos=consulta($db,$str);
	cerrarConexion($db);
	if($correos!=0){
		$str="SELECT ".
			 " CASE ".
			 		" WHEN I.TIPO='E' THEN 'ARRIVAL' ".
			 		" WHEN I.TIPO='S' THEN 'DEPARTURE' ".
			 " END AS TIPO_INTERCAMBIO, ". 
			 " I.ID_INTERCAMBIO, I.NUM_CAJA, I.NUM_TRACTOR, ".
			 " DATE_FORMAT(I.FECHA, '%M %D  %Y , %H:%i') AS FECHA ,".
			 " I.ID_LINEA_CAJA, I.ID_LINEA_TRACTOR, I.ID_PATIO, ".
			 " P.PATIO, P.USER_FTP, P.PASS_FTP , P.IP_FTP, ".
			 " CASE ".
			 		" WHEN C.ESTADO='C' THEN 'LOADED' ".
			 		" WHEN C.ESTADO='V' THEN 'EMPTY' ".
			 " END AS ESTADO_CAJA, ".
			 " LC.LINEA AS LINEA_CAJA, ".
			 " CASE ".
			 		" WHEN I.ID_LINEA_TRACTOR IS NULL THEN T.OTRA_LINEA ".
			 		" WHEN I.ID_LINEA_TRACTOR IS NOT NULL THEN LT.LINEA ".
			 " END AS LINEA_TRACTOR, ".
			 " CASE ".
			 		" WHEN T.TIPO='INT' THEN 'OWN' ".
			 		" WHEN T.TIPO='EXT' THEN 'EXTERNAL' ".
			 " END AS TIPO_TRACTOR, ".
			 " CONCAT(O.NOMBRE,' ',O.APE_P) AS NOMBRE_OPERADOR, O.NUM_OPE,  ".
			 " C.DIESEL, E.PERSONA_AUTORIZO, E.RAZON ".
			 " FROM ".
			 " INTERCAMBIO AS I ".
			 " LEFT OUTER JOIN LINEA_TRACTOR AS LT ON I.ID_LINEA_TRACTOR=LT.ID_LINEA_TRACTOR  ".
			 " JOIN LINEA_CAJA AS LC ON I.ID_LINEA_CAJA=LC.ID_LINEA_CAJA ".
			 " JOIN TRACTOR AS T ON I.ID_INTERCAMBIO=T.ID_INTERCAMBIO ".
			 " JOIN OPERADOR AS O ON I.ID_INTERCAMBIO=O.ID_INTERCAMBIO ".
			 " JOIN PATIO AS P ON I.ID_PATIO=P.ID_PATIO ".
			 " JOIN CAJA AS C ON I.ID_INTERCAMBIO=C.ID_INTERCAMBIO ".
			 " JOIN DIESEL AS E ON I.ID_INTERCAMBIO=E.ID_INTERCAMBIO ".
			 " WHERE ".
			 " I.ID_INTERCAMBIO=".$id_intercambio." ";
		$db=conexion_bd();
		$diesel=consulta($db,$str);
		cerrarConexion($db);
		if($diesel!=0){
				$diesel=$diesel[0];
				$cuerpo="<table style='width:100%; border-collapse: collapse;'><tr style='font-size:17px; width=100%; color:red; ' text-align='center'><th>The following inspection shows Fuel level less than 3/4 </th></tr></table>".
						"<table style=' border-collapse: collapse; font-size:17px;'>".

								"<tr>".
										"<th style='padding:5px; color:#05B;' align='left'>Inspection No. :</th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$diesel['ID_INTERCAMBIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Inspection type : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$diesel['TIPO_INTERCAMBIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Location: </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$diesel['PATIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Date and time : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$diesel['FECHA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$diesel['NUM_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer Id : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$diesel['LINEA_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer Status : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$diesel['ESTADO_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Truck type : </th>".
										"<td style='padding:5px;  border-bottom: 1px solid #ddd;'>".$diesel['TIPO_TRACTOR']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Truck No : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$diesel['NUM_TRACTOR']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Carrier : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$diesel['LINEA_TRACTOR']."</td>".
								"</tr>";
				if($diesel['NUM_OPE']!=0 && $diesel['NUM_OPE']!=null && $diesel['NUM_OPE']!=''){
						$cuerpo.="<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Driver No : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$diesel['NUM_OPE']."</td>".
								"</tr>";
				}
				$cuerpo.=		"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Driver : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$diesel['NOMBRE_OPERADOR']."</td>".
								"</tr>";
				
				
				$cuerpo.="</table>";
				$cuerpo.="<br><br><table style='width:100%; border-collapse: collapse;'>".
							"<tr style='border-bottom: 1px solid #ddd;'>".
								"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>FUEL LEVEL</th>".
								"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>APPROVED BY</th>".
								"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>REASONS</th>".
							"</tr>".
							"<tr style='border-bottom: 1px solid #ddd; background-color: white;'>".
								"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$diesel['DIESEL']."</td>".
								"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$diesel['PERSONA_AUTORIZO']."</td>".
								"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$diesel['RAZON']."</td>".
							"</tr></table>";
				return correo($cuerpo,"AUTOMATIC ALERT",$diesel['TIPO_INTERCAMBIO']." TRAILER: ".$diesel['NUM_CAJA']."-FUEL LEVEL:".date('m/d/Y H:i'),$correos);			
		}else{
					return 1;
		}	
	}else{
		return 1;
	}
}

function reportarSelloSeguridad(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$str="SELECT CORREO, ALIAS FROM NOTIFICACION WHERE SELLOS=1 AND STATUS=1";
	$db=conexion_bd();
	$correos=consulta($db,$str);
	cerrarConexion($db);
	if($correos!=0){
		$str="SELECT ".
			 " CASE ".
			 		" WHEN I.TIPO='E' THEN 'ARRIVAL' ".
			 		" WHEN I.TIPO='S' THEN 'DEPARTURE' ".
			 " END AS TIPO_INTERCAMBIO, ". 
			 " I.ID_INTERCAMBIO, I.NUM_CAJA, I.NUM_TRACTOR, ".
			 " DATE_FORMAT(I.FECHA, '%M %D  %Y , %H:%i') AS FECHA ,".
			 " I.ID_LINEA_CAJA, I.ID_LINEA_TRACTOR, I.ID_PATIO, ".
			 " P.PATIO, P.USER_FTP, P.PASS_FTP , P.IP_FTP, P.HOME_DIR_FTP, P.WEB_PORT_FTPSERVER, ".
			 " CASE ".
			 		" WHEN C.ESTADO='C' THEN 'LOADED' ".
			 		" WHEN C.ESTADO='V' THEN 'EMPTY' ".
			 " END AS ESTADO_CAJA, ".
			 " LC.LINEA AS LINEA_CAJA, ".
			 " CASE ".
			 		" WHEN I.ID_LINEA_TRACTOR IS NULL THEN T.OTRA_LINEA ".
			 		" WHEN I.ID_LINEA_TRACTOR IS NOT NULL THEN LT.LINEA ".
			 " END AS LINEA_TRACTOR, ".
			 " CASE ".
			 		" WHEN T.TIPO='INT' THEN 'OWN' ".
			 		" WHEN T.TIPO='EXT' THEN 'EXTERNAL' ".
			 " END AS TIPO_TRACTOR, ".
			 " CONCAT(O.NOMBRE,' ',O.APE_P) AS NOMBRE_OPERADOR, O.NUM_OPE,  ".
			 " D.FOTO ".
			 " FROM ".
			 " INTERCAMBIO AS I ".
			 " LEFT OUTER JOIN LINEA_TRACTOR AS LT ON I.ID_LINEA_TRACTOR=LT.ID_LINEA_TRACTOR  ".
			 " JOIN LINEA_CAJA AS LC ON I.ID_LINEA_CAJA=LC.ID_LINEA_CAJA ".
			 " JOIN TRACTOR AS T ON I.ID_INTERCAMBIO=T.ID_INTERCAMBIO ".
			 " JOIN OPERADOR AS O ON I.ID_INTERCAMBIO=O.ID_INTERCAMBIO ".
			 " JOIN PATIO AS P ON I.ID_PATIO=P.ID_PATIO ".
			 " JOIN CAJA AS C ON I.ID_INTERCAMBIO=C.ID_INTERCAMBIO ".
			 " LEFT OUTER JOIN INCIDENTE AS D ON I.ID_INTERCAMBIO=D.ID_INTERCAMBIO AND D.PARTE='ALDABA' ".
			 " WHERE ".
			 " I.ID_INTERCAMBIO=".$id_intercambio." ";
		$db=conexion_bd();
		$sello=consulta($db,$str);
		cerrarConexion($db);
		if($sello!=0){
				$sello=$sello[0];
				$cuerpo="<table style='width:100%; border-collapse: collapse;'><tr style='font-size:17px; width=100%; color:red; ' text-align='center'><th>The following inspection shows absence of security seal </th></tr></table>".
						"<table style=' border-collapse: collapse; font-size:17px;'>".

								"<tr>".
										"<th style='padding:5px; color:#05B;' align='left'>Inspection No. :</th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$sello['ID_INTERCAMBIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Inspection type : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$sello['TIPO_INTERCAMBIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Location: </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$sello['PATIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Date and time : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$sello['FECHA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$sello['NUM_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer Id : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$sello['LINEA_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer Status : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$sello['ESTADO_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Truck type : </th>".
										"<td style='padding:5px;  border-bottom: 1px solid #ddd;'>".$sello['TIPO_TRACTOR']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Truck No : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$sello['NUM_TRACTOR']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Carrier : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$sello['LINEA_TRACTOR']."</td>".
								"</tr>";
				if($sello['NUM_OPE']!=0 && $sello['NUM_OPE']!=null && $sello['NUM_OPE']!=''){
						$cuerpo.="<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Driver No : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$sello['NUM_OPE']."</td>".
								"</tr>";
				}
				$cuerpo.=		"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Driver : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$sello['NOMBRE_OPERADOR']."</td>".
								"</tr>";
				
				if($sello['FOTO']!=null && $sello['FOTO']!=''){
						//$rutafoto="ftp:".$sello['USER_FTP'].":".$sello['PASS_FTP']."@".$sello['IP_FTP']."/".$sello['FOTO'];
						$rutafoto="http://".$sello['IP_FTP'].":".$sello['WEB_PORT_FTPSERVER']."/".$sello['HOME_DIR_FTP'].'/'.$sello['FOTO'];
						$cuerpo.="<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Picture:</th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'><a href='".$rutafoto."'>SEE</a></td>".
								"</tr>";		
				}
				$cuerpo.="</table>";
				return correo($cuerpo,"AUTOMATIC ALERT",$sello['TIPO_INTERCAMBIO']." TRAILER: ".$sello['NUM_CAJA']."-NO SECURITY SEAL:".date('m/d/Y H:i'),$correos);			
		}else{
					return 1;
		}	
	}else{
		return 1;
	}
}

function reportarDanios(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$str="SELECT CORREO, ALIAS FROM NOTIFICACION WHERE DANIOS=1 AND STATUS=1";
	$db=conexion_bd();
	$correos=consulta($db,$str);
	cerrarConexion($db);
	if($correos!=0){
		$str="SELECT ".
			 " CASE ".
			 " WHEN UNIDAD='C' THEN 'TRAILER' ".
			 " WHEN UNIDAD='T' THEN 'TRUCK' ".
			 " END AS UNIDAD, ".
			 " FRENTE , PARTE , FOTO ".
			 " FROM INCIDENTE ".
			 " WHERE ".
			 " DANIO=1 AND ".
			 " ID_INTERCAMBIO=".$id_intercambio." ".
			 " ORDER BY UNIDAD ";
		$db=conexion_bd();
		$danios=consulta($db,$str);
		cerrarConexion($db);
		if($danios!=0 && count($danios)>0){	
			$str="SELECT ".
				 " CASE ".
				 		" WHEN I.TIPO='E' THEN 'ARRIVAL' ".
				 		" WHEN I.TIPO='S' THEN 'DEPARTURE' ".
				 " END AS TIPO_INTERCAMBIO, ". 
				 " I.ID_INTERCAMBIO, I.NUM_CAJA, I.NUM_TRACTOR, ".
				 " DATE_FORMAT(I.FECHA, '%M %D  %Y , %H:%i') AS FECHA,".
				 " I.ID_LINEA_CAJA, I.ID_LINEA_TRACTOR, I.ID_PATIO, ".
				 " P.PATIO, P.USER_FTP, P.PASS_FTP , P.IP_FTP, P.WEB_PORT_FTPSERVER, P.HOME_DIR_FTP, ".
				 " CASE ".
				 		" WHEN C.ESTADO='C' THEN 'LOADED' ".
				 		" WHEN C.ESTADO='V' THEN 'EMPTY' ".
				 " END AS ESTADO_CAJA, ".
				 " LC.LINEA AS LINEA_CAJA, ".
				 " CASE ".
				 		" WHEN I.ID_LINEA_TRACTOR IS NULL THEN T.OTRA_LINEA ".
				 		" WHEN I.ID_LINEA_TRACTOR IS NOT NULL THEN LT.LINEA ".
				 " END AS LINEA_TRACTOR, ".
				 " CASE ".
				 		" WHEN T.TIPO='INT' THEN 'OWN' ".
				 		" WHEN T.TIPO='EXT' THEN 'EXTERNAL' ".
				 " END AS TIPO_TRACTOR, ".
				 " CONCAT(O.NOMBRE,' ',O.APE_P) AS NOMBRE_OPERADOR, O.NUM_OPE ".
				 " FROM ".
				 " INTERCAMBIO AS I ".
				 " LEFT OUTER JOIN LINEA_TRACTOR AS LT ON I.ID_LINEA_TRACTOR=LT.ID_LINEA_TRACTOR  ".
				 " JOIN LINEA_CAJA AS LC ON I.ID_LINEA_CAJA=LC.ID_LINEA_CAJA ".
				 " JOIN TRACTOR AS T ON I.ID_INTERCAMBIO=T.ID_INTERCAMBIO ".
				 " JOIN OPERADOR AS O ON I.ID_INTERCAMBIO=O.ID_INTERCAMBIO ".
				 " JOIN PATIO AS P ON I.ID_PATIO=P.ID_PATIO ".
				 " JOIN CAJA AS C ON I.ID_INTERCAMBIO=C.ID_INTERCAMBIO ".
				 " WHERE ".
				 " I.ID_INTERCAMBIO=".$id_intercambio." ";
			$db=conexion_bd();
			$intercambio=consulta($db,$str);
			cerrarConexion($db);
			if($intercambio!=0){
				$intercambio=$intercambio[0];
				$cuerpo="<table style='width:100%; border-collapse: collapse;'><tr style='font-size:17px; width=100%; color:red; ' text-align='center'><th>The following inspection recorded damages </th></tr></table>".
						"<table style=' border-collapse: collapse; font-size:17px;'>".

								"<tr>".
										"<th style='padding:5px; color:#05B;' align='left'>Inspection No. :</th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['ID_INTERCAMBIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Inspection type : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['TIPO_INTERCAMBIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Location: </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['PATIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Date and time : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['FECHA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['NUM_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer Id : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['LINEA_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer Status : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['ESTADO_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Truck type : </th>".
										"<td style='padding:5px;  border-bottom: 1px solid #ddd;'>".$intercambio['TIPO_TRACTOR']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Truck No : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['NUM_TRACTOR']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Carrier : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['LINEA_TRACTOR']."</td>".
								"</tr>";
				if($intercambio['NUM_OPE']!=0 && $intercambio['NUM_OPE']!=null && $intercambio['NUM_OPE']!=''){
						$cuerpo.="<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Driver No : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['NUM_OPE']."</td>".
								"</tr>";
				}
				$cuerpo.=		"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Driver : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['NOMBRE_OPERADOR']."</td>".
								"</tr>";
				$cuerpo.="</table>";
				$str="SELECT ".
			 		" CASE ".
				 		" WHEN UNIDAD='C' THEN 'TRAILER' ".
				 		" WHEN UNIDAD='T' THEN 'TRUCK' ".
				 		" WHEN FRENTE='FIRMA_OPER' THEN 'DRIVER' ".
						" ELSE UNIDAD ".
			 		" END AS UNIDAD, ".
			 		" CASE ".
						" WHEN FRENTE='FRENTE' THEN 'FRONT' ".
						" WHEN FRENTE='DERECHO' THEN 'RIGHT' ".
						" WHEN FRENTE='IZQUIERDO' THEN 'LEFT' ".
						" WHEN FRENTE='PUERTAS' THEN 'REAR' ".
						" WHEN FRENTE='OPERADOR' THEN 'DRIVER' ".
						" WHEN FRENTE='SUSPENSION' THEN 'SUSPENSION' ".
						" WHEN FRENTE='REFACCION' THEN 'TIRE RACK' ".
						" ELSE FRENTE ".
					" END AS FRENTE, ".
			 		" FOTO, ".
			 		" CASE ".
						" WHEN PARTE='CUADRANTE_1' THEN 'QUADRANT 1' ".
						" WHEN PARTE='CUADRANTE_2' THEN 'QUADRANT 2' ".
						" WHEN PARTE='CUADRANTE_3' THEN 'QUADRANT 3' ".
						" WHEN PARTE='CUADRANTE_4' THEN 'QUADRANT 4' ".
						" WHEN PARTE='FIRMA' THEN 'SIGNATURE' ".
						" WHEN PARTE='LODERA' THEN 'FLAP' ".
						" WHEN PARTE='PERFIL_DERECHO' THEN 'RIGHT SIDE' ".
						" WHEN PARTE='PERFIL_IZQUIERDO' THEN 'LEFT SIDE' ".
						" WHEN PARTE='PATINES' THEN 'LANDING GEAR' ".
						" WHEN PARTE='REFACCION' THEN 'TIRE RACK' ".
						" WHEN PARTE='PLACAS' THEN 'LICENSE PLATE' ".
						" WHEN PARTE='PLAFON_IZQ' THEN 'LEFT TAIL LIGHT' ".
						" WHEN PARTE='PLAFON_DER' THEN 'RIGHT TAIL LIGHT' ".
						" WHEN PARTE='FOCO_ESQUINA' THEN 'LIGHT' ".
						" WHEN PARTE='FOCO_MEDIO' THEN 'LIGHT' ".
						" WHEN PARTE='PALANCA_EJES' THEN '' ".
						" WHEN PARTE='CUADRANTE_5' THEN 'QUADRANT 5' ".
						" WHEN PARTE='CUADRANTE_6' THEN 'QUADRANT 6' ".
						" WHEN PARTE='CUADRANTE_7' THEN 'QUADRANT 7' ".
						" WHEN PARTE='CUADRANTE_8' THEN 'QUADRANT 8' ".
						" WHEN PARTE='MEDIDOR_DIESEL_THERMO' THEN '' ".
						" WHEN PARTE='CARGADOR' THEN 'X MEMBER' ".
						" WHEN PARTE='PALANCA_EJES' THEN '' ".
						" WHEN PARTE='PUERTAS_THERMO' THEN 'REEFER UNIT DOORS' ".
						" WHEN PARTE='BISAGRA_SUP_IZQ' THEN 'LEFT HINGE' ".
						" WHEN PARTE='BISAGRA_SUP_DER' THEN 'RIGHT HINGE' ".
						" WHEN PARTE='BISAGRA_INF_IZQ' THEN 'LEFT HINGE' ".
						" WHEN PARTE='BISAGRA_INF_DER' THEN 'RIGHT HINGE' ".
						" WHEN PARTE='ALDABA' THEN 'LOCK CATCH' ".
						" WHEN PARTE='DEFENSA' THEN 'DOT BUMPER' ".
						" WHEN PARTE='DEFENSA_IZQ' THEN 'DOT BUMPER' ".
						" WHEN PARTE='DEFENSA_DER' THEN 'DOT BUMPER' ".
						" WHEN PARTE='PUERTA' THEN 'DOORS' ".
						" WHEN PARTE='BOLSAS_AIRE_DELANTERAS' THEN 'AIRBAG' ".
						" WHEN PARTE='BOLSAS_AIRE_TRASERAS' THEN 'AIRBAG' ".
						" WHEN PARTE='VASTAGO_DELANTERO' THEN 'PUSHROD' ".
						" WHEN PARTE='VASTAGO_TRASERO' THEN 'PUSHROD' ".
						" WHEN PARTE='BALATAS_DELANTERAS' THEN 'BREAKS' ".
						" WHEN PARTE='BALATAS_TRASERAS' THEN 'BREAKS' ".
						" WHEN PARTE='ROTOCHAMBER_DELANTERO' THEN 'BREAKCHAMBER' ".
						" WHEN PARTE='ROTOCHAMBER_TRASERO' THEN 'BREAKCHAMBER' ".
						" WHEN PARTE='MANGUERAS' THEN 'HOSES' ".
						" WHEN PARTE='AMORTIGUADORES_DELANTEROS' THEN 'SHOCK' ".
						" WHEN PARTE='AMORTIGUADORES_TRASEROS' THEN 'SHOCK' ".
						" WHEN PARTE='VARILLA_SUSP' THEN '' ".
						" WHEN PARTE='CARGADOR_DELANTERO' THEN 'XMEMBER' ".
						" WHEN PARTE='CARGADOR_TRASERO' THEN 'XMEMBER' ".
						" WHEN PARTE='EJE_DELANTERO' THEN 'AXLE' ".
						" WHEN PARTE='EJE_TRASERO' THEN 'AXLE' ".
						" WHEN PARTE='QUINTA_IZQUIERDA' THEN '' ".
						" WHEN PARTE='QUINTA_DERECHA' THEN '' ".
						" WHEN PARTE='TANQUE_IZQUIERDO' THEN '' ".
						" WHEN PARTE='TANQUE_DERECHO' THEN '' ".
						" WHEN PARTE='MOTOR_IZQUIERDO' THEN 'MOTOR' ".
						" WHEN PARTE='MOTOR_DERECHO' THEN 'MOTOR' ".
						" WHEN PARTE='CAJA' THEN 'INSIDE' ".
						" WHEN PARTE='FALDON' THEN 'SKIRT' ".
						" WHEN PARTE='TANQUE' THEN 'FUEL TANK' ".
						" WHEN PARTE='ALERON' THEN 'TAIL' ".
						" WHEN PARTE='BATERIA' THEN 'BATTERY' ".
						" ELSE PARTE ".
					" END AS PARTE ".
			 		" FROM INCIDENTE ".
			 		" WHERE ".
			 		" DANIO=1 AND ".
			 		" ID_INTERCAMBIO=".$id_intercambio." AND ".
			 		" UNIDAD='C' ".
			 		" ORDER BY UNIDAD ";
			 	$db=conexion_bd();
				$danios_caja=consulta($db,$str);
				cerrarConexion($db);
				if($danios_caja!=0 && count($danios_caja)>0){
						$cuerpo.="<br><br><table style='width:100%; border-collapse: collapse;'>".
								 		"<tr style='border-bottom: 1px solid #ddd;'>".
								 				"<th colspan='3' style='border-bottom: 1px solid #ddd; font-size: 15pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:center;'>TRAILER DAMAGES</th>".
								 		"</tr>".
								 		"<tr style='border-bottom: 1px solid #ddd;'>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>SIDE</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>PART</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>PICTURE</th>".
								 		"</tr>";
						foreach ($danios_caja as $danio) {
							$cuerpo.="<tr style='border-bottom: 1px solid #ddd; background-color: white;'>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$danio['FRENTE']."</td>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$danio['PARTE']."</td>";
							if($danio['FOTO']!=null && $danio['FOTO']!=""){
								//$rutafoto="ftp:".$intercambio['USER_FTP'].":".$intercambio['PASS_FTP']."@".$intercambio['IP_FTP']."/".$danio['FOTO'];
								$rutafoto="http://".$intercambio['IP_FTP'].":".$intercambio['WEB_PORT_FTPSERVER']."/".$intercambio['HOME_DIR_FTP'].'/'.$danio['FOTO'];
								//var rutafoto="http://"+resumenIntercambio.IP_FTP+":"+resumenIntercambio.WEB_PORT_FTPSERVER+"/"+resumenIntercambio.HOME_DIR_FTP+"/";
								$cuerpo.=	"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'><a href='".$rutafoto."'>SEE</a></td>";
							}else{
								$cuerpo.=	"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'></td>";
							}
							$cuerpo.="</tr>";
						}
						$cuerpo.="</table>";
				}
				$str="SELECT ".
			 		" CASE ".
				 		" WHEN UNIDAD='C' THEN 'TRAILER' ".
				 		" WHEN UNIDAD='T' THEN 'TRUCK' ".
				 		" WHEN FRENTE='FIRMA_OPER' THEN 'DRIVER' ".
						" ELSE UNIDAD ".
			 		" END AS UNIDAD, ".
			 		" CASE ".
						" WHEN FRENTE='FRENTE' THEN 'FRONT' ".
						" WHEN FRENTE='DERECHO' THEN 'RIGHT' ".
						" WHEN FRENTE='IZQUIERDO' THEN 'LEFT' ".
						" WHEN FRENTE='PUERTAS' THEN 'REAR' ".
						" WHEN FRENTE='OPERADOR' THEN 'DRIVER' ".
						" WHEN FRENTE='SUSPENSION' THEN 'SUSPENSION' ".
						" WHEN FRENTE='REFACCION' THEN 'TIRE RACK' ".
						" ELSE FRENTE ".
					" END AS FRENTE, ".
			 		" FOTO, ".
			 		" CASE ".
						" WHEN PARTE='CUADRANTE_1' THEN 'QUADRANT 1' ".
						" WHEN PARTE='CUADRANTE_2' THEN 'QUADRANT 2' ".
						" WHEN PARTE='CUADRANTE_3' THEN 'QUADRANT 3' ".
						" WHEN PARTE='CUADRANTE_4' THEN 'QUADRANT 4' ".
						" WHEN PARTE='FIRMA' THEN 'SIGNATURE' ".
						" WHEN PARTE='LODERA' THEN 'FLAP' ".
						" WHEN PARTE='PERFIL_DERECHO' THEN 'RIGHT SIDE' ".
						" WHEN PARTE='PERFIL_IZQUIERDO' THEN 'LEFT SIDE' ".
						" WHEN PARTE='PATINES' THEN 'LANDING GEAR' ".
						" WHEN PARTE='REFACCION' THEN 'TIRE RACK' ".
						" WHEN PARTE='PLACAS' THEN 'LICENSE PLATE' ".
						" WHEN PARTE='PLAFON_IZQ' THEN 'LEFT TAIL LIGHT' ".
						" WHEN PARTE='PLAFON_DER' THEN 'RIGHT TAIL LIGHT' ".
						" WHEN PARTE='FOCO_ESQUINA' THEN 'LIGHT' ".
						" WHEN PARTE='FOCO_MEDIO' THEN 'LIGHT' ".
						" WHEN PARTE='PALANCA_EJES' THEN '' ".
						" WHEN PARTE='CUADRANTE_5' THEN 'QUADRANT 5' ".
						" WHEN PARTE='CUADRANTE_6' THEN 'QUADRANT 6' ".
						" WHEN PARTE='CUADRANTE_7' THEN 'QUADRANT 7' ".
						" WHEN PARTE='CUADRANTE_8' THEN 'QUADRANT 8' ".
						" WHEN PARTE='MEDIDOR_DIESEL_THERMO' THEN '' ".
						" WHEN PARTE='CARGADOR' THEN 'X MEMBER' ".
						" WHEN PARTE='PALANCA_EJES' THEN '' ".
						" WHEN PARTE='PUERTAS_THERMO' THEN 'REEFER UNIT DOORS' ".
						" WHEN PARTE='BISAGRA_SUP_IZQ' THEN 'LEFT HINGE' ".
						" WHEN PARTE='BISAGRA_SUP_DER' THEN 'RIGHT HINGE' ".
						" WHEN PARTE='BISAGRA_INF_IZQ' THEN 'LEFT HINGE' ".
						" WHEN PARTE='BISAGRA_INF_DER' THEN 'RIGHT HINGE' ".
						" WHEN PARTE='ALDABA' THEN 'LOCK CATCH' ".
						" WHEN PARTE='DEFENSA' THEN 'DOT BUMPER' ".
						" WHEN PARTE='DEFENSA_IZQ' THEN 'DOT BUMPER' ".
						" WHEN PARTE='DEFENSA_DER' THEN 'DOT BUMPER' ".
						" WHEN PARTE='PUERTA' THEN 'DOORS' ".
						" WHEN PARTE='BOLSAS_AIRE_DELANTERAS' THEN 'AIRBAG' ".
						" WHEN PARTE='BOLSAS_AIRE_TRASERAS' THEN 'AIRBAG' ".
						" WHEN PARTE='VASTAGO_DELANTERO' THEN 'PUSHROD' ".
						" WHEN PARTE='VASTAGO_TRASERO' THEN 'PUSHROD' ".
						" WHEN PARTE='BALATAS_DELANTERAS' THEN 'BREAKS' ".
						" WHEN PARTE='BALATAS_TRASERAS' THEN 'BREAKS' ".
						" WHEN PARTE='ROTOCHAMBER_DELANTERO' THEN 'BREAKCHAMBER' ".
						" WHEN PARTE='ROTOCHAMBER_TRASERO' THEN 'BREAKCHAMBER' ".
						" WHEN PARTE='MANGUERAS' THEN 'HOSES' ".
						" WHEN PARTE='AMORTIGUADORES_DELANTEROS' THEN 'SHOCK' ".
						" WHEN PARTE='AMORTIGUADORES_TRASEROS' THEN 'SHOCK' ".
						" WHEN PARTE='VARILLA_SUSP' THEN '' ".
						" WHEN PARTE='CARGADOR_DELANTERO' THEN 'XMEMBER' ".
						" WHEN PARTE='CARGADOR_TRASERO' THEN 'XMEMBER' ".
						" WHEN PARTE='EJE_DELANTERO' THEN 'AXLE' ".
						" WHEN PARTE='EJE_TRASERO' THEN 'AXLE' ".
						" WHEN PARTE='QUINTA_IZQUIERDA' THEN '' ".
						" WHEN PARTE='QUINTA_DERECHA' THEN '' ".
						" WHEN PARTE='TANQUE_IZQUIERDO' THEN '' ".
						" WHEN PARTE='TANQUE_DERECHO' THEN '' ".
						" WHEN PARTE='MOTOR_IZQUIERDO' THEN 'MOTOR' ".
						" WHEN PARTE='MOTOR_DERECHO' THEN 'MOTOR' ".
						" WHEN PARTE='CAJA' THEN 'INSIDE' ".
						" WHEN PARTE='FALDON' THEN 'SKIRT' ".
						" WHEN PARTE='TANQUE' THEN 'FUEL TANK' ".
						" WHEN PARTE='ALERON' THEN 'TAIL' ".
						" WHEN PARTE='BATERIA' THEN 'BATTERY' ".
						" ELSE PARTE ".
					" END AS PARTE ".
			 		" FROM INCIDENTE ".
			 		" WHERE ".
			 		" DANIO=1 AND ".
			 		" ID_INTERCAMBIO=".$id_intercambio." AND ".
			 		" UNIDAD='T' ".
			 		" ORDER BY UNIDAD ";
			 	$db=conexion_bd();
				$danios_tractor=consulta($db,$str);
				cerrarConexion($db);
				if($danios_tractor!=0 && count($danios_tractor)>0){
						$cuerpo.="<br><br>".
								 "<table style='width:100%; border-collapse: collapse;'>".
								 		"<tr style='border-bottom: 1px solid #ddd;'>".
								 				"<th colspan='3' style='border-bottom: 1px solid #ddd; font-size: 15pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:center;'>TRUCK DAMAGES</th>".
								 		"</tr>".
								 		"<tr style='border-bottom: 1px solid #ddd;'>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>SIDE</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>PART</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>PICTURE</th>".
								 		"</tr>";
						foreach ($danios_tractor as $danio) {
							$cuerpo.="<tr style='border-bottom: 1px solid #ddd; background-color: white;'>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$danio['FRENTE']."</td>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$danio['PARTE']."</td>";
							if($danio['FOTO']!=null && $danio['FOTO']!=""){
								//$rutafoto="ftp:".$intercambio['USER_FTP'].":".$intercambio['PASS_FTP']."@".$intercambio['IP_FTP']."/".$danio['FOTO'];
								$rutafoto="http://".$intercambio['IP_FTP'].":".$intercambio['WEB_PORT_FTPSERVER']."/".$intercambio['HOME_DIR_FTP'].'/'.$danio['FOTO'];
								$cuerpo.=	"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'><a href='".$rutafoto."'>SEE</a></td>";
							}else{
								$cuerpo.=	"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'></td>";
							}
							$cuerpo.="</tr>";
						}
						$cuerpo.="</table>";
				}
				return correo($cuerpo,"AUTOMATIC ALERT",$inter['TIPO_INTERCAMBIO']."-DAMAGES:".date('m/d/Y H:i'),$correos);

			}else{
				return 1;
			}

		}else{
			return 1;
		}
	}else{
		return 1;
	}	
}


function reportarLlantas(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$str="SELECT CORREO, ALIAS FROM NOTIFICACION WHERE LLANTAS=1 AND STATUS=1";
	$db=conexion_bd();
	$correos=consulta($db,$str);
	cerrarConexion($db);
	if($correos!=0){
		$str="SELECT ".
			 " CASE ".
			 " WHEN UNIDAD='C' THEN 'TRAILER' ".
			 " WHEN UNIDAD='T' THEN 'TRUCK' ".
			 " END AS UNIDAD, ".
			 " FRENTE , NUM_LLANTA , RIN, MARCA, DANIO, FOTO, PROFUNDIDAD ".
			 " FROM LLANTA ".
			 " WHERE ".
			 " (DANIO!= 'NORMAL' OR PROFUNDIDAD<7) ".
			 " AND ".
			 " ID_INTERCAMBIO=".$id_intercambio." ".
			 " ORDER BY UNIDAD, FRENTE ";
		$db=conexion_bd();
		$llantas=consulta($db,$str);
		cerrarConexion($db);
		if($llantas!=0 && count($llantas)>0){	
			$str="SELECT ".
				 " CASE ".
				 		" WHEN I.TIPO='E' THEN 'ARRIVAL' ".
				 		" WHEN I.TIPO='S' THEN 'DEPARTURE' ".
				 " END AS TIPO_INTERCAMBIO, ". 
				 " I.ID_INTERCAMBIO, I.NUM_CAJA, I.NUM_TRACTOR, ".
				 " DATE_FORMAT(I.FECHA, '%M %D  %Y , %H:%i') AS FECHA,".
				 " I.ID_LINEA_CAJA, I.ID_LINEA_TRACTOR, I.ID_PATIO, ".
				 " P.PATIO, P.USER_FTP, P.PASS_FTP , P.IP_FTP, P.HOME_DIR_FTP, P.WEB_PORT_FTPSERVER,  ".
				 " CASE ".
				 		" WHEN C.ESTADO='C' THEN 'LOADED' ".
				 		" WHEN C.ESTADO='V' THEN 'EMPTY' ".
				 " END AS ESTADO_CAJA, ".
				 " LC.LINEA AS LINEA_CAJA, ".
				 " CASE ".
				 		" WHEN I.ID_LINEA_TRACTOR IS NULL THEN T.OTRA_LINEA ".
				 		" WHEN I.ID_LINEA_TRACTOR IS NOT NULL THEN LT.LINEA ".
				 " END AS LINEA_TRACTOR, ".
				 " CASE ".
				 		" WHEN T.TIPO='INT' THEN 'OWN' ".
				 		" WHEN T.TIPO='EXT' THEN 'EXTERNAL' ".
				 " END AS TIPO_TRACTOR, ".
				 " CONCAT(O.NOMBRE,' ',O.APE_P) AS NOMBRE_OPERADOR, O.NUM_OPE ".
				 " FROM ".
				 " INTERCAMBIO AS I ".
				 " LEFT OUTER JOIN LINEA_TRACTOR AS LT ON I.ID_LINEA_TRACTOR=LT.ID_LINEA_TRACTOR  ".
				 " JOIN LINEA_CAJA AS LC ON I.ID_LINEA_CAJA=LC.ID_LINEA_CAJA ".
				 " JOIN TRACTOR AS T ON I.ID_INTERCAMBIO=T.ID_INTERCAMBIO ".
				 " JOIN OPERADOR AS O ON I.ID_INTERCAMBIO=O.ID_INTERCAMBIO ".
				 " JOIN PATIO AS P ON I.ID_PATIO=P.ID_PATIO ".
				 " JOIN CAJA AS C ON I.ID_INTERCAMBIO=C.ID_INTERCAMBIO ".
				 " WHERE ".
				 " I.ID_INTERCAMBIO=".$id_intercambio." ";
			$db=conexion_bd();
			$intercambio=consulta($db,$str);
			cerrarConexion($db);
			if($intercambio!=0){
				$intercambio=$intercambio[0];
				$cuerpo="<table style='width:100%; border-collapse: collapse;'><tr style='font-size:17px; width=100%; color:red; ' text-align='center'><th>The following inspection recorded damaged tires</th></tr></table>".
						"<table style=' border-collapse: collapse; font-size:17px;'>".

								"<tr>".
										"<th style='padding:5px; color:#05B;' align='left'>Inspection No. :</th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['ID_INTERCAMBIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Inspection type : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['TIPO_INTERCAMBIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Location: </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['PATIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Date and time : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['FECHA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['NUM_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer Id : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['LINEA_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer Status : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['ESTADO_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Truck type : </th>".
										"<td style='padding:5px;  border-bottom: 1px solid #ddd;'>".$intercambio['TIPO_TRACTOR']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Truck No : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['NUM_TRACTOR']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Carrier : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['LINEA_TRACTOR']."</td>".
								"</tr>";
				if($intercambio['NUM_OPE']!=0 && $intercambio['NUM_OPE']!=null && $intercambio['NUM_OPE']!=''){
						$cuerpo.="<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Driver No : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['NUM_OPE']."</td>".
								"</tr>";
				}
				$cuerpo.=		"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Driver : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['NOMBRE_OPERADOR']."</td>".
								"</tr>";
				$cuerpo.="</table>";
				$str="SELECT ".
					 " CASE ".
					 " WHEN UNIDAD='C' THEN 'TRAILER' ".
					 " WHEN UNIDAD='T' THEN 'TRUCK' ".
					 " END AS UNIDAD, ".
					 " NUM_LLANTA , MARCA, FOTO , ".
					 " CASE ".
					    " WHEN UPPER(RIN)='ACERO' THEN 'STEEL' ".
					    " WHEN UPPER(RIN)='ALUMINIO' THEN 'ALUMINUM' ".
					    " ELSE UPPER(RIN) ".
					 " END AS RIN, ".
					 " CASE ".
						" WHEN DANIO='PONCHADA' THEN 'FLAT' ".
						" WHEN DANIO='TRONADA' THEN 'BLOW OUT' ".
						" WHEN DANIO='DESGASTADA' THEN 'WORN OUT' ".
						" WHEN DANIO='NORMAL' THEN 'NORMAL' ".
						" WHEN DANIO='GOLPE' THEN 'HITTED' ".
						" WHEN DANIO='BURBUJA' THEN 'BUBBLE' ".
						" WHEN DANIO='SIN LLANTA' THEN 'NO TIRE' ".
						" ELSE DANIO ".
					 " END AS DANIO, ".
					 " CASE ".
						" WHEN FRENTE='IZQUIERDO' THEN 'LEFT' ".
						" WHEN FRENTE='DERECHO' THEN 'RIGHT' ".
						" WHEN FRENTE='REFACCION' THEN 'TIRE RACK' ".
						" ELSE FRENTE ".
				     " END AS FRENTE, ".
				     " PROFUNDIDAD ".
					 " FROM LLANTA ".
					 " WHERE ".
					 " (DANIO!= 'NORMAL' OR PROFUNDIDAD<7) ".
					 " AND ".
					 " ID_INTERCAMBIO=".$id_intercambio." AND ".
					 " UNIDAD='C' ".
					 " ORDER BY UNIDAD, FRENTE ";
			 	$db=conexion_bd();
				$llantas_caja=consulta($db,$str);
				cerrarConexion($db);
				if($llantas_caja!=0 && count($llantas_caja)>0){
						$cuerpo.="<br><br>".
								  "<table style='width:100%; border-collapse: collapse;'>".
								  		"<tr style='border-bottom: 1px solid #ddd;'>".
								 				"<th colspan='7' style='border-bottom: 1px solid #ddd; font-size: 15pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:center;'>DAMAGED TRAILER TIRES</th>".
								 		"</tr>".
								 		"<tr style='border-bottom: 1px solid #ddd;'>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>SIDE</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>TIRE POSITION</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>RIM TYPE</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>BRAND</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>DAMAGES</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>TREAD DEPTH</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>PICTURE</th>".
								 		"</tr>";
						//$color="background-color: background-color: #99FF99;";//verde

						foreach ($llantas_caja as $llanta) {
							$color="background-color: white;";
							//$color="background-color: #99FF99;";//verde
							if($llanta['PROFUNDIDAD']<7){
								$color="background-color:  #FFFF99;";//amarillo
							}
							if($llanta['PROFUNDIDAD']<3){
								$color="background-color: #FF0000;";//rojo
							}
							$cuerpo.="<tr style='border-bottom: 1px solid #ddd; background-color: white; '>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$llanta['FRENTE']."</td>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$llanta['NUM_LLANTA']."</td>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$llanta['RIN']."</td>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".strtoupper($llanta['MARCA'])."</td>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$llanta['DANIO']."</td>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px; ".$color."'>".$llanta['PROFUNDIDAD']."</td>";

							if($llanta['FOTO']!=null && $llanta['FOTO']!=""){
								//$rutafoto="ftp:".$intercambio['USER_FTP'].":".$intercambio['PASS_FTP']."@".$intercambio['IP_FTP']."/".$llanta['FOTO'];
								$rutafoto="http://".$intercambio['IP_FTP'].":".$intercambio['WEB_PORT_FTPSERVER']."/".$intercambio['HOME_DIR_FTP'].'/'.$llanta['FOTO'];
								$cuerpo.=	"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'><a href='".$rutafoto."'>SEE</a></td>";
							}else{
								$cuerpo.=	"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>NO PICTURE</td>";
							}
							$cuerpo.="</tr>";
						}
						$cuerpo.="</table>";
				}
				$str="SELECT ".
					 " CASE ".
					 " WHEN UNIDAD='C' THEN 'TRAILER' ".
					 " WHEN UNIDAD='T' THEN 'TRUCK' ".
					 " END AS UNIDAD, ".
					 " NUM_LLANTA , MARCA, FOTO , ".
					 " CASE ".
					    " WHEN UPPER(RIN)='ACERO' THEN 'STEEL' ".
					    " WHEN UPPER(RIN)='ALUMINIO' THEN 'ALUMINUM' ".
					    " ELSE UPPER(RIN) ".
					 " END AS RIN, ".
					 " CASE ".
						" WHEN DANIO='PONCHADA' THEN 'FLAT' ".
						" WHEN DANIO='TRONADA' THEN 'BLOW OUT' ".
						" WHEN DANIO='DESGASTADA' THEN 'WORN OUT' ".
						" WHEN DANIO='NORMAL' THEN 'NORMAL' ".
						" WHEN DANIO='GOLPE' THEN 'HITTED' ".
						" WHEN DANIO='BURBUJA' THEN 'BUBBLE' ".
						" WHEN DANIO='SIN LLANTA' THEN 'NO TIRE' ".
						" ELSE DANIO ".
					 " END AS DANIO, ".
					 " CASE ".
						" WHEN FRENTE='IZQUIERDO' THEN 'LEFT' ".
						" WHEN FRENTE='DERECHO' THEN 'RIGHT' ".
						" WHEN FRENTE='REFACCION' THEN 'TIRE RACK' ".
						" ELSE FRENTE ".
				     " END AS FRENTE, ".
				     " PROFUNDIDAD ".
					 " FROM LLANTA ".
					 " WHERE ".
					 " (DANIO!= 'NORMAL' OR PROFUNDIDAD<7) ".
					 " AND ".
					 " ID_INTERCAMBIO=".$id_intercambio." AND ".
					 " UNIDAD='T' ".
					 " ORDER BY UNIDAD, FRENTE ";
			 	$db=conexion_bd();
				$llantas_tractor=consulta($db,$str);
				cerrarConexion($db);
				if($llantas_tractor!=0 && count($llantas_tractor)>0){
						$cuerpo.="<br><br>".
								  "<table style='width:100%; border-collapse: collapse;'>".
								  		"<tr style='border-bottom: 1px solid #ddd;'>".
								 				"<th colspan='7' style='border-bottom: 1px solid #ddd; font-size: 15pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:center;'>DAMAGED TRUCK TIRES</th>".
								 		"</tr>".
								 		"<tr style='border-bottom: 1px solid #ddd;'>".
								 				//"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>SIDE</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>SIDE</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>TIRE POSITION</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>RIM TYPE</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>BRAND</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>DAMAGES</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>TREAD DEPTH</th>".
								 				"<th style='border-bottom: 1px solid #ddd; font-size: 14pt !important; padding:5px; background-color: #2E72C5; color: white; text-align:left;'>PICTURE</th>".
								 		"</tr>";
						foreach ($llantas_tractor as $llanta) {
							$color="background-color: white;";
							//$color="background-color: #99FF99;";//verde
							if($llanta['PROFUNDIDAD']<7){
								$color="background-color: #FFFF99;";//amarillo
							}
							if($llanta['PROFUNDIDAD']<3){
								$color="background-color: #FF0000;";//rojo
							}
							$cuerpo.="<tr style='border-bottom: 1px solid #ddd; background-color: white;'>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$llanta['FRENTE']."</td>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$llanta['NUM_LLANTA']."</td>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$llanta['RIN']."</td>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".strtoupper($llanta['MARCA'])."</td>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>".$llanta['DANIO']."</td>".
											"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px; ".$color." '>".$llanta['PROFUNDIDAD']."</td>";
							if($llanta['FOTO']!=null && $llanta['FOTO']!=""){
								//$rutafoto="ftp:".$intercambio['USER_FTP'].":".$intercambio['PASS_FTP']."@".$intercambio['IP_FTP']."/".$llanta['FOTO'];
								$rutafoto="http://".$intercambio['IP_FTP'].":".$intercambio['WEB_PORT_FTPSERVER']."/".$intercambio['HOME_DIR_FTP'].'/'.$llanta['FOTO'];
								$cuerpo.=	"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'><a href='".$rutafoto."'>SEE</a></td>";
							}else{
								$cuerpo.=	"<td style='border-bottom: 1px solid #ddd; font-size: 12pt !important; padding:5px;'>NO PICTURE</td>";
							}
							$cuerpo.="</tr>";
						}
						$cuerpo.="</table>";
				}
				//echo $cuerpo;
				return correo($cuerpo,"AUTOMATIC ALERT",$inter['TIPO_INTERCAMBIO']."-TIRES DAMAGED:".date('m/d/Y H:i'),$correos);

			}else{
				return 1;
			}

		}else{
			return 1;
		}
	}else{
		return 1;
	}	
}

function reportarEntradaSalida($campo){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$str="SELECT CORREO, ALIAS FROM NOTIFICACION WHERE ".strtoupper($campo)."=1 AND STATUS=1";
	$db=conexion_bd();
	$correos=consulta($db,$str);
	cerrarConexion($db);
	if($correos!=0){
			$str="SELECT ".
				 " CASE ".
				 		" WHEN I.TIPO='E' THEN 'ARRIVAL' ".
				 		" WHEN I.TIPO='S' THEN 'DEPARTURE' ".
				 " END AS TIPO_INTERCAMBIO, ". 
				 " I.ID_INTERCAMBIO, I.NUM_CAJA, I.NUM_TRACTOR, ".
				 " DATE_FORMAT(I.FECHA, '%M %D  %Y , %H:%i') AS FECHA,".
				 " I.ID_LINEA_CAJA, I.ID_LINEA_TRACTOR, I.ID_PATIO, ".
				 " P.PATIO, P.USER_FTP, P.PASS_FTP , P.IP_FTP, P.WEB_PORT_FTPSERVER, P.HOME_DIR_FTP, ".
				 " CASE ".
				 		" WHEN C.ESTADO='C' THEN 'LOADED' ".
				 		" WHEN C.ESTADO='V' THEN 'EMPTY' ".
				 " END AS ESTADO_CAJA, C.ESTADO AS ESTADO_CAJA2, ".
				 " LC.LINEA AS LINEA_CAJA, ".
				 " CASE ".
				 		" WHEN I.ID_LINEA_TRACTOR IS NULL THEN T.OTRA_LINEA ".
				 		" WHEN I.ID_LINEA_TRACTOR IS NOT NULL THEN LT.LINEA ".
				 " END AS LINEA_TRACTOR, ".
				 " CASE ".
				 		" WHEN T.TIPO='INT' THEN 'OWN' ".
				 		" WHEN T.TIPO='EXT' THEN 'EXTERNAL' ".
				 " END AS TIPO_TRACTOR, ".
				 " CONCAT(O.NOMBRE,' ',O.APE_P) AS NOMBRE_OPERADOR, O.NUM_OPE ".
				 " FROM ".
				 " INTERCAMBIO AS I ".
				 " LEFT OUTER JOIN LINEA_TRACTOR AS LT ON I.ID_LINEA_TRACTOR=LT.ID_LINEA_TRACTOR  ".
				 " JOIN LINEA_CAJA AS LC ON I.ID_LINEA_CAJA=LC.ID_LINEA_CAJA ".
				 " JOIN TRACTOR AS T ON I.ID_INTERCAMBIO=T.ID_INTERCAMBIO ".
				 " JOIN OPERADOR AS O ON I.ID_INTERCAMBIO=O.ID_INTERCAMBIO ".
				 " JOIN PATIO AS P ON I.ID_PATIO=P.ID_PATIO ".
				 " JOIN CAJA AS C ON I.ID_INTERCAMBIO=C.ID_INTERCAMBIO ".
				 " WHERE ".
				 " I.ID_INTERCAMBIO=".$id_intercambio." ";
			$db=conexion_bd();
			$intercambio=consulta($db,$str);
			cerrarConexion($db);
			if($intercambio!=0){
				$intercambio=$intercambio[0];
				$cuerpo="<table style='width:100%; border-collapse: collapse;'><tr style='font-size:17px; width=100%; color:red; ' text-align='center'><th>".$intercambio['TIPO_INTERCAMBIO']." INSPECTION </th></tr></table>".
						"<table style=' border-collapse: collapse; font-size:17px;'>".

								"<tr>".
										"<th style='padding:5px; color:#05B;' align='left'>Inspection No. :</th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['ID_INTERCAMBIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Inspection type : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['TIPO_INTERCAMBIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Location: </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['PATIO']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Date and time : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['FECHA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['NUM_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer Id : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['LINEA_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Trailer Status : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['ESTADO_CAJA']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Truck type : </th>".
										"<td style='padding:5px;  border-bottom: 1px solid #ddd;'>".$intercambio['TIPO_TRACTOR']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Truck No : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['NUM_TRACTOR']."</td>".
								"</tr>".
								"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Carrier : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['LINEA_TRACTOR']."</td>".
								"</tr>";
				if($intercambio['NUM_OPE']!=0 && $intercambio['NUM_OPE']!=null && $intercambio['NUM_OPE']!=''){
						$cuerpo.="<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Driver No : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['NUM_OPE']."</td>".
								"</tr>";
				}
				$cuerpo.=		"<tr>".
										"<th style='padding:5px; color:#05B; ' align='left'>Driver : </th>".
										"<td style='padding:5px; border-bottom: 1px solid #ddd;'>".$intercambio['NOMBRE_OPERADOR']."</td>".
								"</tr>";
				$cuerpo.="</table>";
				
		}
		if($intercambio['ESTADO_CAJA2']=='C'){
			return correo($cuerpo,"AUTOMATIC ALERT",$inter['TIPO_INTERCAMBIO']."- TRAILER: ".$intercambio['NUM_CAJA']." TRUCK: ".$intercambio['NUM_TRACTOR']."-".date('m/d/Y H:i'),$correos);	
		}else{
			return 1;
		}
		

	}else{
				return 1;
	}

		
}

function ticket_frio($id_intercambio, $resumenIntercambio,$correos){
	$ruta_inicial=getcwd();
	$firmaOperador=obtenerFirmaOper_array($id_intercambio);
	$llantas=obtenerLlantasIntercambio_array($id_intercambio);
	$incidentesIntercambio=obtenerIncidentesIntercambio_array($id_intercambio);
	/*ESTILOS*/
      $img="vertical-align: middle;border: 0;";
      $img_responsive="display: block;height: auto;max-width: 100%;";
      //$col_md="position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;";
	  $col_md="position: relative;min-height: 1px;";
      $col_md_12="width:100%;";
      $col_md_6="width:50%;";
      $col_md_8="width:66.666666%;";
      $col_md_3="width:25%;";
      $col_md_9="width:75%;";
      $col_md_4="width:33.333333%;";
      $col_md_11="width:91.666666%;";
      $th_primario_style="padding:0px; border:1px solid #ddd; border-collapse: collapse; background-color:#1F517B; color:white;";
      $th_secundario_style=" padding:0px; border:1px solid #ddd; border-collapse: collapse; background-color:#2E72C5; color:white;";
      $td_style="padding:0px;border:1px solid #ddd; border-collapse: collapse;";
      $table_style="border-collapse: collapse;";
      $table_foto="border-collapse: collapse; width:25%;";
      $img_center="display: block; margin-left: auto; margin-right: auto;";
      $font="font-size:12px !important;";
      
    /*FIN DE ESTILOS*/
      
      $mail=objeto_correo();

      //descargarFotosIntercambio_temp($id_intercambio);
      //chdir($ruta_inicial.'/temp/'.$id_intercambio);
      //echo getcwd();
      //echo $ruta_inicial.'/temp/'.$id_intercambio;
      $rutafoto="http://".$resumenIntercambio['IP_FTP'].":".$resumenIntercambio['WEB_PORT_FTPSERVER']."/".$resumenIntercambio['HOME_DIR_FTP']."/";
      $ticket_html="<div style='font-size:8px !important; width:97%; '>".
                  "<table style='".$col_md_12."'>".
                    "<tr>".
                      "<td style='".$col_md_3."'><img style='".$img.$img_responsive."' src='http://".$resumenIntercambio['IP_APP']."/inspections/img/logo.png' ></td>".
                      "<td style='".$col_md_9."'><h3 align='center'><b>TRAILER INSPECTION</b><br>".strtoupper($resumenIntercambio['PATIO'])."</h3></td>".
                    "</tr>".
                  "</table>".
                  "<div style='margin-top:20px;".$col_md.$col_md_12."'>".
                    "<table style='".$col_md_6." ".font." text-align: left;' align='left' >".
                      "<tr>".
                          "<th>INSPECTION No: </th>".
                          "<td>".$resumenIntercambio['ID_INTERCAMBIO']."</td>".
                      "</tr>".
                      "<tr>".
                          "<th>TRAILER: </th>".
                          "<td>".strtoupper($resumenIntercambio['NUM_CAJA'])."</td>".
                      "</tr>".
                      "<tr>".
                          "<th>".$resumenIntercambio['TIPO_INTERCAMBIO'].": </th>".
                          "<td>".strtoupper($resumenIntercambio['FECHA'])."</td>".
                      "</tr>".
                      "<tr>".
                          "<th>LOCATION: </th>".
                          "<td>".strtoupper($resumenIntercambio['PATIO'])."</td>".
                      "</tr>".
                      "<tr>".
                          "<th>INSPECTED BY: </th>".
                          "<td>".strtoupper($resumenIntercambio['NOMBRE_USARIO'])."</td>".
                      "</tr>".   
                    "</table>". 
                  "</div>";
     
     $ticket_html.="<br><br><br><br><br><br><br><div style='margin-top:20px;".$col_md.$col_md_12."'>".
                    "<table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style."' >".
                      "<tr style='text-align: center;'>".
                        "<th style='text-align: center;  ".$th_primario_style."' colspan='7'>TRAILER</th>".
                      "</tr>".
                      "<tr style='text-align: center;'>".
                        "<th style='text-align: center;".$th_secundario_style."'>Trailer No.</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Trailer Id</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>License Plate</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Status</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Reefer Unit Type</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Thermo Status</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Battery</th>".
                      "</tr>".
                      "<tr style='text-align: center;'>".
                        "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['NUM_CAJA'])."</td>".
                        "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['LINEA_CAJA'])."</td>".
                        "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['PLACAS_CAJA'])."</td>".
                        "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['ESTADO_CAJA'])."</td>".
                        "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['MARCA_THERMO'])."</td>".
                        "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['ESTADO_THERMO'])."</td>";

    $ticket_html.=$resumenIntercambio['BATERIA']!='null'&&$resumenIntercambio['BATERIA']!=null?"<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['BATERIA'])."</td>":"<td style='text-align: center;".$td_style."'></td>";
    $ticket_html.=     "</tr>";
    //echo "candado".$resumenIntercambio['CANDADO'];
   	if($resumenIntercambio['ESTADO_THERMO2']=='E' && $resumenIntercambio['ESTADO_CAJA2']=='C'){
   		
      	$ticket_html.=   "<tr style='text-align: center;'>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'></th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'>Temperatures</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'>Seals</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'></th>".
                      "</tr>".
                      "<tr style='text-align: center;'>".
                        "<th style='text-align: center;".$th_secundario_style."'>Fuel</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Box Temp</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Set Point</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'>Seal 1</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'>Seal 2</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'>Master Lock</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'>DOT Inspection</th>".
                      "</tr>".
                       "<tr style='text-align: center;'>".
                        "<td style='text-align: center;".$td_style."'>".number_format($resumenIntercambio['DIESEL'], 2,'.', ',')." % </td>".
                        "<td style='text-align: center;".$td_style."'>".number_format($resumenIntercambio['TEMP_REAL'],2,'.',',')." °F</td>".
                        "<td style='text-align: center;".$td_style."'>".number_format($resumenIntercambio['TEMP_PROG'],2,'.',',')." °F</td>".
                        "<td style='text-align: center;".$td_style."' colspan='1'>".strtoupper($resumenIntercambio['SELLO1'])."</td>".
                        "<td style='text-align: center;".$td_style."' colspan='1'>".strtoupper($resumenIntercambio['SELLO2'])."</td>";
      $ticket_html.=$resumenIntercambio['CANDADO']!='null'&&$resumenIntercambio['CANDADO']!=null?"<td style='text-align: center;".$td_style."' colspan='1'>".strtoupper($resumenIntercambio['CANDADO'])."</td>":"<td style='text-align: center;".$td_style."' colspan='1'></td>";
      $ticket_html.=$resumenIntercambio['DOT']!='null'&&$resumenIntercambio['DOT']!=null?"<td style='text-align: center;".$td_style."' colspan='1'>".strtoupper($resumenIntercambio['DOT'])."</td>":"<td style='text-align: center;".$td_style."' colspan='1'></td>";
      $ticket_html.=   "</tr>";  
    }else{
        if($resumenIntercambio['ESTADO_THERMO2']=='E' && $resumenIntercambio['ESTADO_CAJA2']!='C'){
        	
           $ticket_html.="<tr style='text-align: center;'>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'></th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='4'>Temperatures</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'></th>".
                      "</tr>".
                      "<tr style='text-align: center;'>".
                        "<th style='text-align: center;".$th_secundario_style."' >Fuel</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2' >Box Temp</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2' >Set Point</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1' >Master Lock</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1' >DOT Inspection</th>".
                      "</tr>".
                       "<tr style='text-align: center;'>".
                        "<td style='text-align: center;".$td_style."'>".number_format($resumenIntercambio['DIESEL'],2,'.',',')." % </td>".
                        "<td style='text-align: center;".$td_style."' colspan='2'>".number_format($resumenIntercambio['TEMP_REAL'],2,'.',',')." °F</td>".
                        "<td style='text-align: center;".$td_style."' colspan='2'>".number_format($resumenIntercambio['TEMP_PROG'],2,'.',',')." °F</td>";
          $ticket_html.=$resumenIntercambio['CANDADO']!='null'&&$resumenIntercambio['CANDADO']!=null?"<td style='text-align: center;".$td_style."' colspan='1'>".strtoupper($resumenIntercambio['CANDADO'])." </td>":"<td style='text-align: center;".$td_style."' colspan='1'></td>";
          $ticket_html.=$resumenIntercambio['DOT']!='null'&&$resumenIntercambio['DOT']!=null?"<td style='text-align: center;".$td_style."' colspan='1'>".strtoupper($resumenIntercambio['DOT'])." </td>":"<td style='text-align: center;".$td_style."' colspan='1'></td>";
          $ticket_html.="</tr>"; 
            
            
        }else{
        	
          if($resumenIntercambio['ESTADO_THERMO2']!='E' && $resumenIntercambio['ESTADO_CAJA2']=='C') {
            $ticket_html.= "<tr style='text-align: center;'>".
                          "<th style='text-align: center;".$th_secundario_style."' colspan='4'>Seals</th>".
                          "<th style='text-align: center;".$th_secundario_style."' colspan='3'></th>".
                      "</tr>".
                      "<tr style='text-align: center;'>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'>Seal 1</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'>Seal 2</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'>Master Lock</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'>DOT Inspection</th>".
                      "</tr>".
                       "<tr style='text-align: center;'>".
                        "<td style='text-align: center;".$td_style."' colspan='2'>".strtoupper($resumenIntercambio['SELLO1'])."</td>".
                        "<td style='text-align: center;".$td_style."' colspan='2'>".strtoupper($resumenIntercambio['SELLO2'])."</td>";
            $ticket_html.=$resumenIntercambio['CANDADO']!='null'&&$resumenIntercambio['CANDADO']!=null?"<td style='text-align: center;".$td_style."' colspan='1'>".$resumenIntercambio['CANDADO']."</td>":"<td style='text-align: center;".$td_style."' colspan='1'></td>";
            $ticket_html.=$resumenIntercambio['DOT']!='null'&&$resumenIntercambio['DOT']!=null?"<td style='text-align: center;".$td_style."' colspan='2'>".strtoupper($resumenIntercambio['DOT'])."</td>":"<td style='text-align: center;".$td_style."' colspan='2'></td>";
            $ticket_html.="</tr>";
            
            
             
          }
        }
    }
    $ticket_html.=   "</table>";
    if($resumenIntercambio['DIESEL']<75 && $resumenIntercambio['PERSONA_AUTORIZO']!=null && $resumenIntercambio['RAZON']!=null){
    	$ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px;  ".$table_style."' >".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_primario_style."' colspan='4'>FUEL LEVEL LOWER THAN 3/4</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_secundario_style."'>Approved by</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Reasons</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['PERSONA_AUTORIZO'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['RAZON'])."</td>".
                            "</tr>".
                        "</table>";
    }
    if($resumenIntercambio['TIPO_TRACTOR2']!='INT'){
    	$ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px;  ".$table_style."' >".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_primario_style."' colspan='4'>TRUCK</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_secundario_style."'>Truck No.</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Type/Origin</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Carrier</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>License Plate</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['NUM_TRACTOR'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['TIPO_TRACTOR'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['LINEA_TRACTOR'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['PLACAS_TRACTOR'])."</td>".
                            "</tr>".
                        "</table>";
 	}else{
    	$ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px;  ".$table_style."' >".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_primario_style."' colspan='3'>TRUCK</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_secundario_style."'>Truck No.</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Type/Origin</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Carrier</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['NUM_TRACTOR'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['TIPO_TRACTOR'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['LINEA_TRACTOR'])."</td>".
                            "</tr>".
                        "</table>";
  }
  if($resumenIntercambio['TIPO_TRACTOR2']!='INT'){
      if($resumenIntercambio['NUM_OPE']!='0' && $resumenIntercambio['NUM_OPE']!=''){
        $ticket_html+=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style." ' >".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_primario_style."' colspan='3'>DRIVER</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_secundario_style."'>Driver No.</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Name</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Signature</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['NUM_OPE'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['NOMBRE_OPERADOR'])."</td>";

       	if($firmaOperador!=0 && $firmaOperador!=null){
		
          
        	  $ticket_html.=       "<td style='text-align: center;".$td_style."".$col_md_4."'><img style='".$img.$img_center." height:80px; max-height: 80px;' src='".$rutafoto.$firmaOperador['FOTO']."' height='80' ></td>";       
		  
		 // $mail->AddEmbeddedImage($firmaOperador['FOTO'],'firma',$firmaOperador['FOTO']);            
       	}else{
          
        	  $ticket_html.=       "<td style='text-align: center;".$td_style."".$col_md_4."'>NO SIGNATURE</td>"; 
       	}
       	$ticket_html.=        "</tr>".
                        "</table>";    
      }else{
        	$ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style."' >".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_primario_style."' colspan='2'>DRIVER</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['NOMBRE_OPERADOR'])."</td>";
       if($firmaOperador!=0 && $firmaOperador!=null){
          	$ticket_html.=       "<td style='text-align: center;".$td_style."".$col_md_4."'><img style='".$img.$img_center." height:80px; max-height: 80px;' height='80' src='".$rutafoto.$firmaOperador['FOTO']."' ></td>";                   
		
		//$mail->AddEmbeddedImage($firmaOperador['FOTO'],'firma',$firmaOperador['FOTO']);
       }else{
          	$ticket_html.=       "<td style='text-align: center;".$td_style."".$col_md_4."'>NO SIGNATURE</td>"; 
       }
        $ticket_html.=    "</tr>".
                        "</table>";      
      }
  }
   $ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style." ' >".
                          "<tr style='text-align: center;'>".
                            "<th style='text-align: center;".$th_primario_style."' colspan='6'>TIRES</th>".
                          "</tr>".
                          "<tr style='text-align: center;'>".
                            /*"<th style='text-align: center;"+th_secundario_style+"'>Unidad</th>"+*/
                            "<th style='text-align: center;".$th_secundario_style."'>Side</th>".
                            "<th style='text-align: center;".$th_secundario_style."'>Position No.</th>".
                            "<th style='text-align: center;".$th_secundario_style."'>Rim Type</th>".
                            "<th style='text-align: center;".$th_secundario_style."'>Brand</th>".
                            "<th style='text-align: center;".$th_secundario_style."'>Condition</th>".
                            "<th style='text-align: center;".$th_secundario_style."'>Tread Depth</th>".
                          "</tr>";
    foreach ($llantas as $llanta){
    	$ticket_html.=     "<tr style='text-align: center;'>".
                            /*"<td style='text-align: center;"+td_style+"'>"+llanta.UNIDAD.toUpperCase()+"</td>"+*/
                            "<td style='text-align: center;".$td_style."'>".strtoupper($llanta['FRENTE'])."</td>".
                            "<td style='text-align: center;".$td_style."'>".strtoupper($llanta['NUM_LLANTA'])."</td>".
                            "<td style='text-align: center;".$td_style."'>".strtoupper($llanta['RIN'])."</td>".
                            "<td style='text-align: center;".$td_style."'>".strtoupper($llanta['MARCA'])."</td>".
                            "<td style='text-align: center;".$td_style."'>".strtoupper($llanta['DANIO'])."</td>";
        $ticket_html.=$llanta['PROFUNDIDAD']!='null'&&$llanta['PROFUNDIDAD']!=null&&$llanta['PROFUNDIDAD']!=''?"<td style='text-align: center;".$td_style."'>".$llanta['PROFUNDIDAD']."/32</td>":"<td style='text-align: center;".$td_style."'></td>";
        $ticket_html.=     "</tr>";
    }
    $ticket_html.=     "</table>";

    if($incidentesIntercambio!=0 && $incidentesIntercambio!=null){
        if($resumenIntercambio['TIPO_REG2']=='I'){
            $ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style." ' >".
                              "<tr style='text-align: center;'>".
                                "<th style='text-align: center;".$th_primario_style."' colspan='2'>DAMAGES</th>".
                              "</tr>".
                              "<tr style='text-align: center;'>".
                               // "<th style='text-align: center;"+th_secundario_style+"'>Unidad</th>"+
                                "<th style='text-align: center;".$th_secundario_style."'>Side</th>".
                                "<th style='text-align: center;".$th_secundario_style."'>Part</th>".
                              "</tr>";
            foreach($incidentesIntercambio as $incidente) {
                $ticket_html.=     "<tr style='text-align: center;'>".
                                   // "<td style='text-align: center;"+td_style+"'>"+incidente.UNIDAD.toUpperCase()+"</td>"+
                                    "<td style='text-align: center;".$td_style."'>".strtoupper($incidente['FRENTE'])."</td>".
                                    "<td style='text-align: center;".$td_style."'>".strtoupper($incidente['PARTE'])."</td>".
                                  "</tr>";

            } 
            $ticket_html.=     "</table>";    
        }else{
            //var rutafoto="ftp:"+resumenIntercambio.USER_FTP+":"+resumenIntercambio.PASS_FTP+"@"+resumenIntercambio.IP_FTP+"/";
            //rutafoto="img/temp/"+carpeta_fotos+"/";
            $ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style."' >".
                              "<tr style='text-align: center;'>".
                                "<th style='text-align: center;".$th_primario_style."' colspan='3'>DAMAGES</th>".
                              "</tr>";
                      
            $indexCelda=0;     
            $indextr=0; 
	    $num_incidente=0;
            foreach($incidentesIntercambio as $incidente) {
                
                if($indexCelda==0){
                     
                    $ticket_html.="<tr style='text-align: center;'>";    
                                  
                }
                $ticket_html.="<td style='".$col_md_4."text-align: center;padding:0px;' colspan='1'>";
                $ticket_html.= "<table  style='font-size:13px !important; ".$col_md_12." ".$font." text-align: center; ".$table_style." ' >". 
                                "<tr style='text-align: center;'>".
                                  /*"<th style='text-align: center;"+th_secundario_style+"'>Unidad</th>"+*/
                                  "<th style='text-align: center;".$th_secundario_style."'>Side</th>".
                                  "<th style='text-align: center;".$th_secundario_style."'>Part</th>".
                                "</tr>".
                                "<tr style='text-align: center;'>".
                                  /*"<td style='text-align: center;"+td_style+"'>"+incidente.UNIDAD.toUpperCase()+"</td>"+*/
                                  "<td style='text-align: center;".$td_style."'>".strtoupper($incidente['FRENTE'])."</td>".
                                  "<td style='text-align: center;".$td_style."'>".strtoupper($incidente['PARTE'])."</td>".
                                "</tr>".
                                "<tr style='text-align: center;'>";
                if($incidente['FOTO']!='' && $incidente['FOTO']!=null){
		  $num_incidente++; 
		  $nombre_imagen="incidente".$num_incidente;
		  
                  $ticket_html.=    "<td style='text-align: center;".$td_style." height:140px; ' colspan='2' align='center'><img style='".$img.$img_center." height:140px; max-height: 140px;' height='140' src='".$rutafoto.$incidente['FOTO']."' ></td>"; 
		  
		 // $mail->AddEmbeddedImage($incidente['FOTO'],$nombre_imagen,$incidente['FOTO']);
                }else{
                  $ticket_html.=    "<td style='text-align: center;".$td_style." height:140px; ' colspan='2' align='center'>NO PICTURE</td>";
                }
                                  
                $ticket_html.=   "</tr>".
                              "</table>";
                $ticket_html.="</td>";
                if($indexCelda==2){
                  
                  $ticket_html.="</tr>";
                  if($indextr%5==0){
                    $ticket_html.="</table><div style='display:block; page-break-after:always;'></div><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style." ' >";
                  }
                  $indexCelda=0; 
                  $indextr++;   
                }else{
                  $indexCelda++;
                }
            }
            if($indexCelda!=0){
              while($indexCelda<=2){
                 $ticket_html.="<td style='".$col_md_4."text-align: center;padding:0px;' colspan='1'></td>";  
                 $indexCelda++;
              }
              $ticket_html.="</tr>";
            }  
            $ticket_html.="</table>";
        }
	 
    }
    $ticket_html.=       "</div>".
                "</div>";
 	//echo $ticket_html;
    $fromName="AUTOMATIC ALERT";
    $asunto=$resumenIntercambio['TIPO_INTERCAMBIO']."- TRAILER: ".$resumenIntercambio['NUM_CAJA']." TRUCK: ".$resumenIntercambio['NUM_TRACTOR']."-".date('m/d/Y H:i');
    $mail->FromName =  $fromName;
    $mail->Subject = $asunto;
    $mail->ClearAddresses();
    $mail->AddAddress('gpadilla@frioexpress.com');
    foreach ($correos as $correo) {
    	if($correo!=''){
    		 $mail->AddAddress($correo);
    	}
    }
    //$mail->AddAddress('gpadilla@frioexpress.com','Ana Gabriela Padilla');
   // $mail->AddAddress('jlmtz@frioexpress.com','Jose Luis Martinez Aparicio');
//echo getcwd();
    //$mail->AddEmbeddedImage('../../../../../../img/logo.png','logo','logo.png');
 	
    
    
	$mail->Body = $ticket_html;
    $mail->AltBody = "";
    $error=$mail->Send();
    //borrarFotosFtp_temp($ruta_inicial.'/temp', $id_intercambio);
    if (!$error)
    {
        return $mail->ErrorInfo;
    }else{
    	return 1;
    }
    
}

function ticket_frio_imagenes_embebidas($id_intercambio, $resumenIntercambio,$correos){
	$ruta_inicial=getcwd();
	$firmaOperador=obtenerFirmaOper_array($id_intercambio);
	$llantas=obtenerLlantasIntercambio_array($id_intercambio);
	$incidentesIntercambio=obtenerIncidentesIntercambio_array($id_intercambio);
	/*ESTILOS*/
      $img="vertical-align: middle;border: 0;";
      $img_responsive="display: block;height: auto;max-width: 100%;";
      //$col_md="position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;";
	  $col_md="position: relative;min-height: 1px;";
      $col_md_12="width:100%;";
      $col_md_6="width:50%;";
      $col_md_8="width:66.666666%;";
      $col_md_3="width:25%;";
      $col_md_9="width:75%;";
      $col_md_4="width:33.333333%;";
      $col_md_11="width:91.666666%;";
      $th_primario_style="padding:0px; border:1px solid #ddd; border-collapse: collapse; background-color:#1F517B; color:white;";
      $th_secundario_style=" padding:0px; border:1px solid #ddd; border-collapse: collapse; background-color:#2E72C5; color:white;";
      $td_style="padding:0px;border:1px solid #ddd; border-collapse: collapse;";
      $table_style="border-collapse: collapse;";
      $table_foto="border-collapse: collapse; width:25%;";
      $img_center="display: block; margin-left: auto; margin-right: auto;";
      $font="font-size:12px !important;";
      
    /*FIN DE ESTILOS*/
      
      $mail=objeto_correo();

      descargarFotosIntercambio_temp($id_intercambio);
      chdir($ruta_inicial.'/temp/'.$id_intercambio);
      //echo getcwd();
      //echo $ruta_inicial.'/temp/'.$id_intercambio;
      $rutafoto="ftp:".$resumenIntercambio['USER_FTP'].":".$resumenIntercambio['PASS_FTP']."@".$resumenIntercambio['IP_FTP']."/";
      $ticket_html="<div style='font-size:8px !important; width:97%; '>".
                  "<table style='".$col_md_12."'>".
                    "<tr>".
                      "<td style='".$col_md_3."'><img style='".$img.$img_responsive."' src='cid:logo' ></td>".
                      "<td style='".$col_md_9."'><h3 align='center'><b>TRAILER INSPECTION</b><br>".strtoupper($resumenIntercambio['PATIO'])."</h3></td>".
                    "</tr>".
                  "</table>".
                  "<div style='margin-top:20px;".$col_md.$col_md_12."'>".
                    "<table style='".$col_md_6." ".font." text-align: left;' align='left' >".
                      "<tr>".
                          "<th>INSPECTION No: </th>".
                          "<td>".$resumenIntercambio['ID_INTERCAMBIO']."</td>".
                      "</tr>".
                      "<tr>".
                          "<th>TRAILER: </th>".
                          "<td>".strtoupper($resumenIntercambio['NUM_CAJA'])."</td>".
                      "</tr>".
                      "<tr>".
                          "<th>".$resumenIntercambio['TIPO_INTERCAMBIO'].": </th>".
                          "<td>".strtoupper($resumenIntercambio['FECHA'])."</td>".
                      "</tr>".
                      "<tr>".
                          "<th>LOCATION: </th>".
                          "<td>".strtoupper($resumenIntercambio['PATIO'])."</td>".
                      "</tr>".
                      "<tr>".
                          "<th>INSPECTED BY: </th>".
                          "<td>".strtoupper($resumenIntercambio['NOMBRE_USARIO'])."</td>".
                      "</tr>".   
                    "</table>". 
                  "</div>";
     
     $ticket_html.="<br><br><br><br><br><br><br><div style='margin-top:20px;".$col_md.$col_md_12."'>".
                    "<table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style."' >".
                      "<tr style='text-align: center;'>".
                        "<th style='text-align: center;  ".$th_primario_style."' colspan='7'>TRAILER</th>".
                      "</tr>".
                      "<tr style='text-align: center;'>".
                        "<th style='text-align: center;".$th_secundario_style."'>Trailer No.</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Trailer Id</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>License Plate</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Status</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Reefer Unit Type</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Thermo Status</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Battery</th>".
                      "</tr>".
                      "<tr style='text-align: center;'>".
                        "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['NUM_CAJA'])."</td>".
                        "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['LINEA_CAJA'])."</td>".
                        "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['PLACAS_CAJA'])."</td>".
                        "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['ESTADO_CAJA'])."</td>".
                        "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['MARCA_THERMO'])."</td>".
                        "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['ESTADO_THERMO'])."</td>";

    $ticket_html.=$resumenIntercambio['BATERIA']!='null'&&$resumenIntercambio['BATERIA']!=null?"<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['BATERIA'])."</td>":"<td style='text-align: center;".$td_style."'></td>";
    $ticket_html.=     "</tr>";
    //echo "candado".$resumenIntercambio['CANDADO'];
   	if($resumenIntercambio['ESTADO_THERMO2']=='E' && $resumenIntercambio['ESTADO_CAJA2']=='C'){
   		
      	$ticket_html.=   "<tr style='text-align: center;'>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'></th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'>Temperatures</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'>Seals</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'></th>".
                      "</tr>".
                      "<tr style='text-align: center;'>".
                        "<th style='text-align: center;".$th_secundario_style."'>Fuel</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Box Temp</th>".
                        "<th style='text-align: center;".$th_secundario_style."'>Set Point</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'>Seal 1</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'>Seal 2</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'>Master Lock</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'>DOT Inspection</th>".
                      "</tr>".
                       "<tr style='text-align: center;'>".
                        "<td style='text-align: center;".$td_style."'>".number_format($resumenIntercambio['DIESEL'], 2,'.', ',')." % </td>".
                        "<td style='text-align: center;".$td_style."'>".number_format($resumenIntercambio['TEMP_REAL'],2,'.',',')." °F</td>".
                        "<td style='text-align: center;".$td_style."'>".number_format($resumenIntercambio['TEMP_PROG'],2,'.',',')." °F</td>".
                        "<td style='text-align: center;".$td_style."' colspan='1'>".strtoupper($resumenIntercambio['SELLO1'])."</td>".
                        "<td style='text-align: center;".$td_style."' colspan='1'>".strtoupper($resumenIntercambio['SELLO2'])."</td>";
      $ticket_html.=$resumenIntercambio['CANDADO']!='null'&&$resumenIntercambio['CANDADO']!=null?"<td style='text-align: center;".$td_style."' colspan='1'>".strtoupper($resumenIntercambio['CANDADO'])."</td>":"<td style='text-align: center;".$td_style."' colspan='1'></td>";
      $ticket_html.=$resumenIntercambio['DOT']!='null'&&$resumenIntercambio['DOT']!=null?"<td style='text-align: center;".$td_style."' colspan='1'>".strtoupper($resumenIntercambio['DOT'])."</td>":"<td style='text-align: center;".$td_style."' colspan='1'></td>";
      $ticket_html.=   "</tr>";  
    }else{
        if($resumenIntercambio['ESTADO_THERMO2']=='E' && $resumenIntercambio['ESTADO_CAJA2']!='C'){
        	
           $ticket_html.="<tr style='text-align: center;'>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'></th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='4'>Temperatures</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'></th>".
                      "</tr>".
                      "<tr style='text-align: center;'>".
                        "<th style='text-align: center;".$th_secundario_style."' >Fuel</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2' >Box Temp</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2' >Set Point</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1' >Master Lock</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1' >DOT Inspection</th>".
                      "</tr>".
                       "<tr style='text-align: center;'>".
                        "<td style='text-align: center;".$td_style."'>".number_format($resumenIntercambio['DIESEL'],2,'.',',')." % </td>".
                        "<td style='text-align: center;".$td_style."' colspan='2'>".number_format($resumenIntercambio['TEMP_REAL'],2,'.',',')." °F</td>".
                        "<td style='text-align: center;".$td_style."' colspan='2'>".number_format($resumenIntercambio['TEMP_PROG'],2,'.',',')." °F</td>";
          $ticket_html.=$resumenIntercambio['CANDADO']!='null'&&$resumenIntercambio['CANDADO']!=null?"<td style='text-align: center;".$td_style."' colspan='1'>".strtoupper($resumenIntercambio['CANDADO'])." </td>":"<td style='text-align: center;".$td_style."' colspan='1'></td>";
          $ticket_html.=$resumenIntercambio['DOT']!='null'&&$resumenIntercambio['DOT']!=null?"<td style='text-align: center;".$td_style."' colspan='1'>".strtoupper($resumenIntercambio['DOT'])." </td>":"<td style='text-align: center;".$td_style."' colspan='1'></td>";
          $ticket_html.="</tr>"; 
            
            
        }else{
        	
          if($resumenIntercambio['ESTADO_THERMO2']!='E' && $resumenIntercambio['ESTADO_CAJA2']=='C') {
            $ticket_html.= "<tr style='text-align: center;'>".
                          "<th style='text-align: center;".$th_secundario_style."' colspan='4'>Seals</th>".
                          "<th style='text-align: center;".$th_secundario_style."' colspan='3'></th>".
                      "</tr>".
                      "<tr style='text-align: center;'>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'>Seal 1</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'>Seal 2</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='1'>Master Lock</th>".
                        "<th style='text-align: center;".$th_secundario_style."' colspan='2'>DOT Inspection</th>".
                      "</tr>".
                       "<tr style='text-align: center;'>".
                        "<td style='text-align: center;".$td_style."' colspan='2'>".strtoupper($resumenIntercambio['SELLO1'])."</td>".
                        "<td style='text-align: center;".$td_style."' colspan='2'>".strtoupper($resumenIntercambio['SELLO2'])."</td>";
            $ticket_html.=$resumenIntercambio['CANDADO']!='null'&&$resumenIntercambio['CANDADO']!=null?"<td style='text-align: center;".$td_style."' colspan='1'>".$resumenIntercambio['CANDADO']."</td>":"<td style='text-align: center;".$td_style."' colspan='1'></td>";
            $ticket_html.=$resumenIntercambio['DOT']!='null'&&$resumenIntercambio['DOT']!=null?"<td style='text-align: center;".$td_style."' colspan='2'>".strtoupper($resumenIntercambio['DOT'])."</td>":"<td style='text-align: center;".$td_style."' colspan='2'></td>";
            $ticket_html.="</tr>";
            
            
             
          }
        }
    }
    $ticket_html.=   "</table>";
    if($resumenIntercambio['DIESEL']<75 && $resumenIntercambio['PERSONA_AUTORIZO']!=null && $resumenIntercambio['RAZON']!=null){
    	$ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px;  ".$table_style."' >".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_primario_style."' colspan='4'>FUEL LEVEL LOWER THAN 3/4</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_secundario_style."'>Approved by</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Reasons</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['PERSONA_AUTORIZO'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['RAZON'])."</td>".
                            "</tr>".
                        "</table>";
    }
    if($resumenIntercambio['TIPO_TRACTOR2']!='INT'){
    	$ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px;  ".$table_style."' >".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_primario_style."' colspan='4'>TRUCK</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_secundario_style."'>Truck No.</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Type/Origin</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Carrier</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>License Plate</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['NUM_TRACTOR'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['TIPO_TRACTOR'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['LINEA_TRACTOR'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['PLACAS_TRACTOR'])."</td>".
                            "</tr>".
                        "</table>";
 	}else{
    	$ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px;  ".$table_style."' >".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_primario_style."' colspan='3'>TRUCK</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_secundario_style."'>Truck No.</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Type/Origin</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Carrier</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['NUM_TRACTOR'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['TIPO_TRACTOR'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['LINEA_TRACTOR'])."</td>".
                            "</tr>".
                        "</table>";
  }
  if($resumenIntercambio['TIPO_TRACTOR2']!='INT'){
      if($resumenIntercambio['NUM_OPE']!='0' && $resumenIntercambio['NUM_OPE']!=''){
        $ticket_html+=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style." ' >".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_primario_style."' colspan='3'>DRIVER</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_secundario_style."'>Driver No.</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Name</th>".
                              "<th style='text-align: center;".$th_secundario_style."'>Signature</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['NUM_OPE'])."</td>".
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['NOMBRE_OPERADOR'])."</td>";

       	if($firmaOperador!=0 && $firmaOperador!=null){
		
          
        	  $ticket_html.=       "<td style='text-align: center;".$td_style."".$col_md_4."'><img style='".$img.$img_center." height:80px; max-height: 80px;' src='cid:firma' height='80' ></td>";       
		  
		  $mail->AddEmbeddedImage($firmaOperador['FOTO'],'firma',$firmaOperador['FOTO']);            
       	}else{
          
        	  $ticket_html.=       "<td style='text-align: center;".$td_style."".$col_md_4."'>NO SIGNATURE</td>"; 
       	}
       	$ticket_html.=        "</tr>".
                        "</table>";    
      }else{
        	$ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style."' >".
                            "<tr style='text-align: center;'>".
                              "<th style='text-align: center;".$th_primario_style."' colspan='2'>DRIVER</th>".
                            "</tr>".
                            "<tr style='text-align: center;'>".
                              
                              "<td style='text-align: center;".$td_style."'>".strtoupper($resumenIntercambio['NOMBRE_OPERADOR'])."</td>";
       if($firmaOperador!=0 && $firmaOperador!=null){
          	$ticket_html.=       "<td style='text-align: center;".$td_style."".$col_md_4."'><img style='".$img.$img_center." height:80px; max-height: 80px;' height='80' src='cid:firma' ></td>";                   
		
		$mail->AddEmbeddedImage($firmaOperador['FOTO'],'firma',$firmaOperador['FOTO']);
       }else{
          	$ticket_html.=       "<td style='text-align: center;".$td_style."".$col_md_4."'>NO SIGNATURE</td>"; 
       }
        $ticket_html.=    "</tr>".
                        "</table>";      
      }
  }
   $ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style." ' >".
                          "<tr style='text-align: center;'>".
                            "<th style='text-align: center;".$th_primario_style."' colspan='6'>TIRES</th>".
                          "</tr>".
                          "<tr style='text-align: center;'>".
                            /*"<th style='text-align: center;"+th_secundario_style+"'>Unidad</th>"+*/
                            "<th style='text-align: center;".$th_secundario_style."'>Side</th>".
                            "<th style='text-align: center;".$th_secundario_style."'>Position No.</th>".
                            "<th style='text-align: center;".$th_secundario_style."'>Rim Type</th>".
                            "<th style='text-align: center;".$th_secundario_style."'>Brand</th>".
                            "<th style='text-align: center;".$th_secundario_style."'>Condition</th>".
                            "<th style='text-align: center;".$th_secundario_style."'>Tread Depth</th>".
                          "</tr>";
    foreach ($llantas as $llanta){
    	$ticket_html.=     "<tr style='text-align: center;'>".
                            /*"<td style='text-align: center;"+td_style+"'>"+llanta.UNIDAD.toUpperCase()+"</td>"+*/
                            "<td style='text-align: center;".$td_style."'>".strtoupper($llanta['FRENTE'])."</td>".
                            "<td style='text-align: center;".$td_style."'>".strtoupper($llanta['NUM_LLANTA'])."</td>".
                            "<td style='text-align: center;".$td_style."'>".strtoupper($llanta['RIN'])."</td>".
                            "<td style='text-align: center;".$td_style."'>".strtoupper($llanta['MARCA'])."</td>".
                            "<td style='text-align: center;".$td_style."'>".strtoupper($llanta['DANIO'])."</td>";
        $ticket_html.=$llanta['PROFUNDIDAD']!='null'&&$llanta['PROFUNDIDAD']!=null&&$llanta['PROFUNDIDAD']!=''?"<td style='text-align: center;".$td_style."'>".$llanta['PROFUNDIDAD']."/32</td>":"<td style='text-align: center;".$td_style."'></td>";
        $ticket_html.=     "</tr>";
    }
    $ticket_html.=     "</table>";

    if($incidentesIntercambio!=0 && $incidentesIntercambio!=null){
        if($resumenIntercambio['TIPO_REG2']=='I'){
            $ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style." ' >".
                              "<tr style='text-align: center;'>".
                                "<th style='text-align: center;".$th_primario_style."' colspan='2'>DAMAGES</th>".
                              "</tr>".
                              "<tr style='text-align: center;'>".
                               // "<th style='text-align: center;"+th_secundario_style+"'>Unidad</th>"+
                                "<th style='text-align: center;".$th_secundario_style."'>Side</th>".
                                "<th style='text-align: center;".$th_secundario_style."'>Part</th>".
                              "</tr>";
            foreach($incidentesIntercambio as $incidente) {
                $ticket_html.=     "<tr style='text-align: center;'>".
                                   // "<td style='text-align: center;"+td_style+"'>"+incidente.UNIDAD.toUpperCase()+"</td>"+
                                    "<td style='text-align: center;".$td_style."'>".strtoupper($incidente['FRENTE'])."</td>".
                                    "<td style='text-align: center;".$td_style."'>".strtoupper($incidente['PARTE'])."</td>".
                                  "</tr>";

            } 
            $ticket_html.=     "</table>";    
        }else{
            //var rutafoto="ftp:"+resumenIntercambio.USER_FTP+":"+resumenIntercambio.PASS_FTP+"@"+resumenIntercambio.IP_FTP+"/";
            //rutafoto="img/temp/"+carpeta_fotos+"/";
            $ticket_html.=   "<br><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style."' >".
                              "<tr style='text-align: center;'>".
                                "<th style='text-align: center;".$th_primario_style."' colspan='3'>DAMAGES</th>".
                              "</tr>";
                      
            $indexCelda=0;     
            $indextr=0; 
	    $num_incidente=0;
            foreach($incidentesIntercambio as $incidente) {
                
                if($indexCelda==0){
                     
                    $ticket_html.="<tr style='text-align: center;'>";    
                                  
                }
                $ticket_html.="<td style='".$col_md_4."text-align: center;padding:0px;' colspan='1'>";
                $ticket_html.= "<table  style='font-size:13px !important; ".$col_md_12." ".$font." text-align: center; ".$table_style." ' >". 
                                "<tr style='text-align: center;'>".
                                  /*"<th style='text-align: center;"+th_secundario_style+"'>Unidad</th>"+*/
                                  "<th style='text-align: center;".$th_secundario_style."'>Side</th>".
                                  "<th style='text-align: center;".$th_secundario_style."'>Part</th>".
                                "</tr>".
                                "<tr style='text-align: center;'>".
                                  /*"<td style='text-align: center;"+td_style+"'>"+incidente.UNIDAD.toUpperCase()+"</td>"+*/
                                  "<td style='text-align: center;".$td_style."'>".strtoupper($incidente['FRENTE'])."</td>".
                                  "<td style='text-align: center;".$td_style."'>".strtoupper($incidente['PARTE'])."</td>".
                                "</tr>".
                                "<tr style='text-align: center;'>";
                if($incidente['FOTO']!='' && $incidente['FOTO']!=null){
		  $num_incidente++; 
		  $nombre_imagen="incidente".$num_incidente;
		  
                  $ticket_html.=    "<td style='text-align: center;".$td_style." height:140px; ' colspan='2' align='center'><img style='".$img.$img_center." height:140px; max-height: 140px;' height='140' src='cid:".$nombre_imagen."' ></td>"; 
		  
		  $mail->AddEmbeddedImage($incidente['FOTO'],$nombre_imagen,$incidente['FOTO']);
                }else{
                  $ticket_html.=    "<td style='text-align: center;".$td_style." height:140px; ' colspan='2' align='center'>NO PICTURE</td>";
                }
                                  
                $ticket_html.=   "</tr>".
                              "</table>";
                $ticket_html.="</td>";
                if($indexCelda==2){
                  
                  $ticket_html.="</tr>";
                  if($indextr%5==0){
                    $ticket_html.="</table><div style='display:block; page-break-after:always;'></div><table  style='".$col_md_12." ".$font." text-align: center; padding-top:30px; ".$table_style." ' >";
                  }
                  $indexCelda=0; 
                  $indextr++;   
                }else{
                  $indexCelda++;
                }
            }
            if($indexCelda!=0){
              while($indexCelda<=2){
                 $ticket_html.="<td style='".$col_md_4."text-align: center;padding:0px;' colspan='1'></td>";  
                 $indexCelda++;
              }
              $ticket_html.="</tr>";
            }  
            $ticket_html.="</table>";
        }
	 
    }
    $ticket_html.=       "</div>".
                "</div>";
 	//echo $ticket_html;
    $fromName="AUTOMATIC ALERT";
    $asunto=$resumenIntercambio['TIPO_INTERCAMBIO']."- TRAILER: ".$resumenIntercambio['NUM_CAJA']." TRUCK: ".$resumenIntercambio['NUM_TRACTOR']."-".date('m/d/Y H:i');
    $mail->FromName =  $fromName;
    $mail->Subject = $asunto;
    $mail->ClearAddresses();
    $mail->AddAddress('gpadilla@frioexpress.com');
    foreach ($correos as $correo) {
    	if($correo!=''){
    		 $mail->AddAddress($correo);
    	}
    }
    //$mail->AddAddress('gpadilla@frioexpress.com','Ana Gabriela Padilla');
   // $mail->AddAddress('jlmtz@frioexpress.com','Jose Luis Martinez Aparicio');
//echo getcwd();
    $mail->AddEmbeddedImage('../../../../../../img/logo.png','logo','logo.png');
 	
    
    
	$mail->Body = $ticket_html;
    $mail->AltBody = "";
    $error=$mail->Send();
    borrarFotosFtp_temp($ruta_inicial.'/temp', $id_intercambio);
    if (!$error)
    {
        return $mail->ErrorInfo;
    }else{
    	return 1;
    }
    
}

function ticket(){
	
	$id_intercambio=$_REQUEST['id_intercambio'];
	$resumenIntercambio=obtenerResumenIntercambio_array($id_intercambio);
	
	if($resumenIntercambio['CORREOS_LINEA_TRACTOR']!=null && $resumenIntercambio['CORREOS_LINEA_TRACTOR']!='' && $resumenIntercambio['CORREOS_LINEA_TRACTOR']!='null'){
		$correos=explode(";",$resumenIntercambio['CORREOS_LINEA_TRACTOR']);
		//$correos=explode(";",'gpadilla@frioexpress.com;gaby_otaa@hotmail.com;');
		switch($resumenIntercambio['TIPO_CAJA']){
			case 'FRIO': return ticket_frio($id_intercambio, $resumenIntercambio,$correos);break;
		}
	}//if de que existan correos destinatarios
}

function obtenerResumenIntercambio_array($id_intercambio){
	
	$str="SELECT ".
		 " I.ID_INTERCAMBIO AS ID_INTERCAMBIO, ".
		 " I.TIPO AS TIPO_INTERCAMBIO1 , ".
		 " CASE ".
		 		" WHEN I.TIPO='E' THEN 'ARRIVAL' ".
		 		" WHEN I.TIPO='S' THEN 'DEPARTURE' ".
		 		" ELSE I.TIPO ".
		 " END AS TIPO_INTERCAMBIO, ".
		 " I.ID_INTERCAMBIO, I.NUM_CAJA, I.NUM_TRACTOR, ".
		 " DATE_FORMAT(I.FECHA, '%M %D  %Y , %H:%i') AS FECHA,".
		 " I.FECHA AS FECHA_SIN_FORMATO, ".
		 " I.ID_LINEA_CAJA, I.ID_LINEA_TRACTOR, I.ID_PATIO, I.TIPO_REG as TIPO_REG2, ".
		 " CASE ".
		 	 	" WHEN I.TIPO_REG='C' THEN 'COMPLETE' ".
		 	 	" WHEN I.TIPO_REG='I' THEN 'INCOMPLETE' ".
		 	 	" ELSE I.TIPO_REG ".
		 " END AS TIPO_REG , ".
		 " P.PATIO, P.USER_FTP, P.PASS_FTP , P.IP_FTP, P.WEB_PORT_FTPSERVER, P.HOME_DIR_FTP, P.IP_APP, ".
		 " CASE ".
		 		" WHEN C.ESTADO='C' THEN 'LOADED' ".
		 		" WHEN C.ESTADO='V' THEN 'EMPTY' ".
		 		" ELSE C.ESTADO ".
		 " END AS ESTADO_CAJA, C.ESTADO AS ESTADO_CAJA2, C.TIPO_CAJA, C.NUM_DANIOS,  ".
		 " CASE ".
		 		" WHEN C.REFACCION='1' THEN 'YES' ".
		 		" WHEN C.REFACCION='0' THEN 'NO' ".
		 		" ELSE C.REFACCION ".
		 " END AS REFACCION, C.REFACCION AS REFACCION2, ".
		 " CASE ".
		 		" WHEN C.MANIBELA='1' THEN 'YES' ".
		 		" WHEN C.MANIBELA='0' THEN 'NO' ".
		 		" ELSE C.MANIBELA ".
		 " END AS MANIBELA, C.MANIBELA AS MANIBELA2, ".
		 " CASE ".
		 		" WHEN C.TAPON_DIESEL='1' THEN 'YES' ".
		 		" WHEN C.TAPON_DIESEL='0' THEN 'NO' ".
		 		" ELSE C.TAPON_DIESEL ".
		 " END AS TAPON_DIESEL, C.TAPON_DIESEL AS TAPON_DIESEL2, C.ODOMETRO,  ".
		 " CASE ".
		 		" WHEN C.TIPO_CAJA = 'PIPA'  THEN 'TANKER' ".
		 		" WHEN C.TIPO_CAJA = 'PLATAFORMA' THEN 'FLATBED' ".
		 		" WHEN C.TIPO_CAJA = 'FRIO'  THEN C.MARCA_THERMO ".
		 		" ELSE C.TIPO_CAJA ".
		 " END AS MARCA_THERMO, C.GATAS , ".
		 " C.PLACAS AS PLACAS_CAJA,  C.ESTADO_THERMO AS ESTADO_THERMO2, C.HORIMETRO, ".
		 " CASE ".
		 		" WHEN C.ESTADO_THERMO='E' THEN 'POWER ON' ".
		 		" WHEN C.ESTADO_THERMO='A' THEN 'POWER OFF' ".
		 		" WHEN C.ESTADO_THERMO='S' THEN 'NO THERMO' ".
		 		" ELSE C.ESTADO_THERMO ".
		 " END AS ESTADO_THERMO , C.ESTADO_THERMO AS ESTADO_THERMO2, ".
		 " CASE ".
		 		" WHEN C.SELLO_SEGURIDAD='SI' THEN 'YES' ".
		 		" WHEN C.SELLO_SEGURIDAD='NO' THEN 'NO' ".
		 		" WHEN C.SELLO_SEGURIDAD='NA' THEN 'N/A' ".
		 		" ELSE C.SELLO_SEGURIDAD ".
		 " END AS SELLO_SEGURIDAD, C.SELLO_SEGURIDAD AS SELLO_SEGURIDAD2, ".
		 " CASE ".
		 		" WHEN C.CANDADO='SI' THEN 'YES' ".
		 		" WHEN C.CANDADO='NO' THEN 'NO' ".
		 		" WHEN C.CANDADO='NA' THEN 'N/A' ".
		 		" WHEN C.CANDADO is null THEN '' ".
		 		" ELSE C.CANDADO ".
		 " END AS CANDADO, C.CANDADO AS CANDADO2, ".
		 " CASE ".
		 		" WHEN C.BATERIA='C' THEN 'CARRIER' ".
		 		" WHEN C.BATERIA='O' THEN 'OTHER' ".
		 		" WHEN C.BATERIA is null THEN '' ".
		 		" ELSE C.BATERIA ".
		 " END AS BATERIA, C.BATERIA AS BATERIA2, ".
		 " C.DIESEL, C.TEMP_REAL, C.TEMP_PROG, C.SELLO1, C.SELLO2, C.TIPO_CAJA , ".
		 " C.ALARMA, C.ALARMA2, C.ALARMA3, ".
		 " D.PERSONA_AUTORIZO, D.RAZON, ".
		 " DATE_FORMAT(C.DOT,'%m/%Y') AS DOT, ".
		 " LC.LINEA AS LINEA_CAJA, ".
		 " CASE ".
		 		" WHEN I.ID_LINEA_TRACTOR IS NULL THEN T.OTRA_LINEA ".
		 		" WHEN I.ID_LINEA_TRACTOR IS NOT NULL THEN LT.LINEA ".
		 		" ELSE I.ID_LINEA_TRACTOR ".
		 " END AS LINEA_TRACTOR, ".
		 " CASE ".
		 		" WHEN I.ID_LINEA_TRACTOR IS NULL THEN '' ".
		 		" WHEN I.ID_LINEA_TRACTOR IS NOT NULL THEN LT.CORREOS ".
		 		" ELSE LT.CORREOS ".
		 " END AS CORREOS_LINEA_TRACTOR, ".		
		 " CASE ".
		 		" WHEN T.TIPO='INT' THEN 'OWN' ".
		 		" WHEN T.TIPO='EXT' THEN 'EXTERNAL' ".
		 		" ELSE T.TIPO ".
		 " END AS TIPO_TRACTOR, T.TIPO AS TIPO_TRACTOR2,  ".
		 " T.PLACAS AS PLACAS_TRACTOR, ".
		 " CONCAT(O.NOMBRE,' ',O.APE_P) AS NOMBRE_OPERADOR, O.NOMBRE AS NOMBRE_OPERADOR1, O.APE_P AS NOMBRE_OPERADOR2, O.NUM_OPE, ".
		 " CONCAT(U.NOMBRE,' ',U.APE_P) AS NOMBRE_USARIO, U.USR AS USUARIO  ".
		 //" ,(SELECT COUNT(*) FROM INCIDENTE WHERE DANIO='1' AND UNIDAD='C' AND ID_INTERCAMBIO='".$id_intercambio."') AS DANIOS"
		 " FROM ".
		 " INTERCAMBIO AS I ".
		 " LEFT OUTER JOIN LINEA_TRACTOR AS LT ON I.ID_LINEA_TRACTOR=LT.ID_LINEA_TRACTOR  ".
		 " JOIN LINEA_CAJA AS LC ON I.ID_LINEA_CAJA=LC.ID_LINEA_CAJA ".
		 " JOIN TRACTOR AS T ON I.ID_INTERCAMBIO=T.ID_INTERCAMBIO ".
		 " JOIN OPERADOR AS O ON I.ID_INTERCAMBIO=O.ID_INTERCAMBIO ".
		 " JOIN PATIO AS P ON I.ID_PATIO=P.ID_PATIO ".
		 " JOIN CAJA AS C ON I.ID_INTERCAMBIO=C.ID_INTERCAMBIO ".
		 " JOIN USUARIO AS U ON I.ID_USUARIO=U.ID_USUARIO ".
		 " LEFT OUTER JOIN DIESEL AS D ON I.ID_INTERCAMBIO= D.ID_INTERCAMBIO ".
		 " WHERE ".
		 " I.ID_INTERCAMBIO=".$id_intercambio." ";
	$db=conexion_bd();
	$intercambio=consulta($db,$str);
	cerrarConexion($db);
	if($intercambio!=0){
		$intercambio=$intercambio[0];
		return $intercambio;
	}else{
		//return $str;
		return 0;//no se encontro el intercambio
	}
}

function obtenerResumenIntercambio(){
	$id_intercambio=$_REQUEST['id_intercambio'];	
	$str="SELECT ".
		 " I.ID_INTERCAMBIO AS ID_INTERCAMBIO, ".
		 " I.TIPO AS TIPO_INTERCAMBIO1 , ".
		 " CASE ".
		 		" WHEN I.TIPO='E' THEN 'ARRIVAL' ".
		 		" WHEN I.TIPO='S' THEN 'DEPARTURE' ".
		 		" ELSE I.TIPO ".
		 " END AS TIPO_INTERCAMBIO, ".
		 " I.ID_INTERCAMBIO, I.NUM_CAJA, I.NUM_TRACTOR, ".
		 " DATE_FORMAT(I.FECHA, '%M %D  %Y , %H:%i') AS FECHA,".
		 " I.FECHA AS FECHA_SIN_FORMATO, ".
		 " I.ID_LINEA_CAJA, I.ID_LINEA_TRACTOR, I.ID_PATIO, I.TIPO_REG as TIPO_REG2, ".
		 " CASE ".
		 	 	" WHEN I.TIPO_REG='C' THEN 'COMPLETE' ".
		 	 	" WHEN I.TIPO_REG='I' THEN 'INCOMPLETE' ".
		 	 	" ELSE I.TIPO_REG ".
		 " END AS TIPO_REG , ".
		 " P.PATIO, P.USER_FTP, P.PASS_FTP , P.IP_FTP, P.WEB_PORT_FTPSERVER, P.HOME_DIR_FTP, ".
		 " CASE ".
		 		" WHEN C.ESTADO='C' THEN 'LOADED' ".
		 		" WHEN C.ESTADO='V' THEN 'EMPTY' ".
		 		" ELSE C.ESTADO ".
		 " END AS ESTADO_CAJA, C.ESTADO AS ESTADO_CAJA2, C.TIPO_CAJA, C.NUM_DANIOS,  ".
		 " CASE ".
		 		" WHEN C.REFACCION='1' THEN 'YES' ".
		 		" WHEN C.REFACCION='0' THEN 'NO' ".
		 		" ELSE C.REFACCION ".
		 " END AS REFACCION, C.REFACCION AS REFACCION2, ".
		 " CASE ".
		 		" WHEN C.MANIBELA='1' THEN 'YES' ".
		 		" WHEN C.MANIBELA='0' THEN 'NO' ".
		 		" ELSE C.MANIBELA ".
		 " END AS MANIBELA, C.MANIBELA AS MANIBELA2, ".
		 " CASE ".
		 		" WHEN C.TAPON_DIESEL='1' THEN 'YES' ".
		 		" WHEN C.TAPON_DIESEL='0' THEN 'NO' ".
		 		" ELSE C.TAPON_DIESEL ".
		 " END AS TAPON_DIESEL, C.TAPON_DIESEL AS TAPON_DIESEL2, C.ODOMETRO,  ".
		 " CASE ".
		 		" WHEN C.TIPO_CAJA = 'PIPA'  THEN 'TANKER' ".
		 		" WHEN C.TIPO_CAJA = 'PLATAFORMA' THEN 'FLATBED' ".
		 		" WHEN C.TIPO_CAJA = 'FRIO'  THEN C.MARCA_THERMO ".
		 		" ELSE C.TIPO_CAJA ".
		 " END AS MARCA_THERMO, C.GATAS , ".
		 " C.PLACAS AS PLACAS_CAJA,  C.ESTADO_THERMO AS ESTADO_THERMO2, C.HORIMETRO, ".
		 " CASE ".
		 		" WHEN C.ESTADO_THERMO='E' THEN 'POWER ON' ".
		 		" WHEN C.ESTADO_THERMO='A' THEN 'POWER OFF' ".
		 		" WHEN C.ESTADO_THERMO='S' THEN 'NO THERMO' ".
		 		" ELSE C.ESTADO_THERMO ".
		 " END AS ESTADO_THERMO , C.ESTADO_THERMO AS ESTADO_THERMO2, ".
		 " CASE ".
		 		" WHEN C.SELLO_SEGURIDAD='SI' THEN 'YES' ".
		 		" WHEN C.SELLO_SEGURIDAD='NO' THEN 'NO' ".
		 		" WHEN C.SELLO_SEGURIDAD='NA' THEN 'N/A' ".
		 		" ELSE C.SELLO_SEGURIDAD ".
		 " END AS SELLO_SEGURIDAD, C.SELLO_SEGURIDAD AS SELLO_SEGURIDAD2, ".
		 " CASE ".
		 		" WHEN C.CANDADO='SI' THEN 'YES' ".
		 		" WHEN C.CANDADO='NO' THEN 'NO' ".
		 		" WHEN C.CANDADO='NA' THEN 'N/A' ".
		 		" WHEN C.CANDADO is null THEN '' ".
		 		" ELSE C.CANDADO ".
		 " END AS CANDADO, C.CANDADO AS CANDADO2, ".
		 " CASE ".
		 		" WHEN C.BATERIA='C' THEN 'CARRIER' ".
		 		" WHEN C.BATERIA='O' THEN 'OTHER' ".
		 		" WHEN C.BATERIA is null THEN '' ".
		 		" ELSE C.BATERIA ".
		 " END AS BATERIA, C.BATERIA AS BATERIA2, ".
		 " C.DIESEL, C.TEMP_REAL, C.TEMP_PROG, C.SELLO1, C.SELLO2, C.TIPO_CAJA , ".
		 " C.ALARMA, C.ALARMA2, C.ALARMA3, ".
		 " DATE_FORMAT(C.DOT,'%m/%Y') AS DOT, ".
		 " D.PERSONA_AUTORIZO, D.RAZON, ".
		 " LC.LINEA AS LINEA_CAJA, ".
		 " CASE ".
		 		" WHEN I.ID_LINEA_TRACTOR IS NULL THEN T.OTRA_LINEA ".
		 		" WHEN I.ID_LINEA_TRACTOR IS NOT NULL THEN LT.LINEA ".
		 		" ELSE I.ID_LINEA_TRACTOR ".
		 " END AS LINEA_TRACTOR, ".
		 " CASE ".
		 		" WHEN T.TIPO='INT' THEN 'OWN' ".
		 		" WHEN T.TIPO='EXT' THEN 'EXTERNAL' ".
		 		" ELSE T.TIPO ".
		 " END AS TIPO_TRACTOR, T.TIPO AS TIPO_TRACTOR2,  ".
		 " T.PLACAS AS PLACAS_TRACTOR, ".
		 " CONCAT(O.NOMBRE,' ',O.APE_P) AS NOMBRE_OPERADOR, O.NOMBRE AS NOMBRE_OPERADOR1, O.APE_P AS NOMBRE_OPERADOR2, O.NUM_OPE, ".
		 " CONCAT(U.NOMBRE,' ',U.APE_P) AS NOMBRE_USARIO, U.USR AS USUARIO  ".
		 //" ,(SELECT COUNT(*) FROM INCIDENTE WHERE DANIO='1' AND UNIDAD='C' AND ID_INTERCAMBIO='".$id_intercambio."') AS DANIOS"
		 " FROM ".
		 " INTERCAMBIO AS I ".
		 " LEFT OUTER JOIN LINEA_TRACTOR AS LT ON I.ID_LINEA_TRACTOR=LT.ID_LINEA_TRACTOR  ".
		 " JOIN LINEA_CAJA AS LC ON I.ID_LINEA_CAJA=LC.ID_LINEA_CAJA ".
		 " JOIN TRACTOR AS T ON I.ID_INTERCAMBIO=T.ID_INTERCAMBIO ".
		 " JOIN OPERADOR AS O ON I.ID_INTERCAMBIO=O.ID_INTERCAMBIO ".
		 " JOIN PATIO AS P ON I.ID_PATIO=P.ID_PATIO ".
		 " JOIN CAJA AS C ON I.ID_INTERCAMBIO=C.ID_INTERCAMBIO ".
		 " JOIN USUARIO AS U ON I.ID_USUARIO=U.ID_USUARIO ".
		 " LEFT OUTER JOIN DIESEL AS D ON I.ID_INTERCAMBIO=D.ID_INTERCAMBIO ".
		 " WHERE ".
		 " I.ID_INTERCAMBIO=".$id_intercambio." ";
	$db=conexion_bd();
	$intercambio=consulta($db,$str);
	cerrarConexion($db);
	if($intercambio!=0){
		$intercambio=$intercambio[0];
		return json_encode($intercambio);
	}else{
		//return $str;
		return 0;//no se encontro el intercambio
	}
}
function obtenerLlantasIntercambio_array($id_intercambio){
	$str  = " SELECT  NUM_LLANTA, UPPER(MARCA) AS MARCA, FOTO, ".
			" CASE ".
				" WHEN DANIO='PONCHADA' THEN 'FLAT' ".
				" WHEN DANIO='TRONADA' THEN 'BLOW OUT' ".
				" WHEN DANIO='DESGASTADA' THEN 'WORN OUT' ".
				" WHEN DANIO='NORMAL' THEN 'NORMAL' ".
				" WHEN DANIO='GOLPE' THEN 'HITTED' ".
				" WHEN DANIO='BURBUJA' THEN 'BUBBLE' ".
				" WHEN DANIO='SIN LLANTA' THEN 'NO TIRE' ".
				" ELSE DANIO ".
			" END AS DANIO, ".
			" CASE ".
				" WHEN FRENTE='IZQUIERDO' THEN 'LEFT' ".
				" WHEN FRENTE='DERECHO' THEN 'RIGHT' ".
				" WHEN FRENTE='REFACCION' THEN 'TIRE RACK' ".
				" ELSE FRENTE ".
			" END AS FRENTE, ".
			" CASE ".
			    " WHEN UPPER(RIN)='ACERO' THEN 'STEEL' ".
			    " WHEN UPPER(RIN)='ALUMINIO' THEN 'ALUMINUM' ".
			    " ELSE UPPER(RIN) ".
			" END AS RIN, ".
			" CASE ".
				" WHEN UNIDAD='T' THEN 'TRUCK' ".
				" WHEN UNIDAD='C' THEN 'TRAILER' ".
				" ELSE UNIDAD ".
			" END AS UNIDAD, ".
			" PROFUNDIDAD ".
		    " FROM LLANTA WHERE ID_INTERCAMBIO = ".$id_intercambio." ".
		    " ORDER BY UNIDAD, FRENTE, NUM_LLANTA ";
 	$db=conexion_bd();
  	$llantas=consulta($db,$str);
  	cerrarConexion($db);
  	if($llantas!=0){
  		return $llantas;
  	}else{
  		return 0;
  	}
  	
}

function descargarFotosIntercambio_temp($id_intercambio){
	

	$str="SELECT F.FOTO, P.IP_FTP, P.USER_FTP, P.PASS_FTP FROM INCIDENTE AS F , INTERCAMBIO AS I, PATIO AS P ".
		" WHERE F.FOTO IS NOT NULL AND F.FOTO!='' AND F.ID_INTERCAMBIO='".$id_intercambio."' ".
		" AND I.ID_INTERCAMBIO=F.ID_INTERCAMBIO ".
		" AND I.ID_PATIO=P.ID_PATIO ".
		" LIMIT 1 ";
	
	$db=conexion_bd();
	$rutas=consulta($db,$str);
	cerrarConexion($db);
	if($rutas!=0){
		$ruta =$rutas[0][0];
		$index = strpos($ruta, "FOLIO");
		$ruta_local= substr($ruta, 0, $index-1);
		$ruta_ftp=substr($ruta, $index);
		$folders=split('/', $ruta_local);
		$folders_ftp=split('/', $ruta_ftp);
		$ruta_origen_ftp=$ruta_local."/".$folders_ftp[0];
		$ruta_temp='temp/'.$id_intercambio;

		if(file_exists($ruta_temp)){
			if(!chdir($ruta_temp)){
				return -1;
			}else{
				if(file_exists($ruta_origen_ftp)){
					return 1;
				}
			}
		}else{
			if(mkdir($ruta_temp,777,true)){
				if(!chdir($ruta_temp)){
					return -1;
				}	
			}else{
				return -1;
			}
			
		}
		
		if(file_exists($ruta_origen_ftp)){
			if(!chdir($ruta_origen_ftp)){
				return -1;
			}
		}else{
		    if(mkdir($ruta_origen_ftp,777,true)){
		    	if(!chdir($ruta_origen_ftp)){
					return -1;
				}
			}else{
				return -1;
			}
		}
		
		return bajarCarpeta($rutas[0][1],$rutas[0][2],$rutas[0][3],$ruta_origen_ftp);

		
	}

}

function bajarCarpeta($host,$user,$pass,$ruta){
	
	$id_ftp=conexion_ftp($host,21,$user,$pass);
	if($id_ftp==-1||$id_ftp==-2){
		return -2;//no se pudo conectar al ftp
	}else{
		bajar_dir_ftp ($id_ftp, $ruta);
		return 1;
	}
}

function borrarFotosFtp_temp($ruta_dirtemp, $directorio){
	
	
	$ruta_borrar=$ruta_dirtemp.'/'.$directorio;
	//echo "entra a borrar dir<br>".$ruta_borrar;
	if(!file_exists($ruta_borrar)){
		return 1;
	}else{
		if(chdir($ruta_dirtemp)){
			eliminarDir($directorio);
		}else{
			return -1;
		}

	}
}



function eliminarDir($carpeta)
{

    foreach(glob($carpeta . "/*") as $archivos_carpeta){
        //echo $archivos_carpeta;
 
        
	if (is_dir($archivos_carpeta))
{
            
		eliminarDir($archivos_carpeta);
        
	}
else
{
            
		unlink($archivos_carpeta);
        
	}
    
    }
 
    
    rmdir($carpeta);
    
    return 1;

}

function obtenerLlantasIntercambio(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$str  = " SELECT  NUM_LLANTA, UPPER(MARCA) AS MARCA, FOTO, ".
			" CASE ".
				" WHEN DANIO='PONCHADA' THEN 'FLAT' ".
				" WHEN DANIO='TRONADA' THEN 'BLOW OUT' ".
				" WHEN DANIO='DESGASTADA' THEN 'WORN OUT' ".
				" WHEN DANIO='NORMAL' THEN 'NORMAL' ".
				" WHEN DANIO='GOLPE' THEN 'HITTED' ".
				" WHEN DANIO='BURBUJA' THEN 'BUBBLE' ".
				" WHEN DANIO='SIN LLANTA' THEN 'NO TIRE' ".
				" ELSE DANIO ".
			" END AS DANIO, ".
			" CASE ".
				" WHEN FRENTE='IZQUIERDO' THEN 'LEFT' ".
				" WHEN FRENTE='DERECHO' THEN 'RIGHT' ".
				" WHEN FRENTE='REFACCION' THEN 'TIRE RACK' ".
				" ELSE FRENTE ".
			" END AS FRENTE, ".
			" CASE ".
			    " WHEN UPPER(RIN)='ACERO' THEN 'STEEL' ".
			    " WHEN UPPER(RIN)='ALUMINIO' THEN 'ALUMINUM' ".
			    " ELSE UPPER(RIN) ".
			" END AS RIN, ".
			" CASE ".
				" WHEN UNIDAD='T' THEN 'TRUCK' ".
				" WHEN UNIDAD='C' THEN 'TRAILER' ".
				" ELSE UNIDAD ".
			" END AS UNIDAD, ".
			" PROFUNDIDAD ".
		    " FROM LLANTA WHERE ID_INTERCAMBIO = ".$id_intercambio." ".
		    " ORDER BY UNIDAD, FRENTE, NUM_LLANTA ";
 	$db=conexion_bd();
  	$llantas=consulta($db,$str);
  	cerrarConexion($db);
  	if($llantas!=0){
  		return '{"llantas": ' . json_encode($llantas) . '}';
  	}else{
  		return 0;
  	}
  	
}
function obtenerIncidentesIntercambio_array($id_intercambio){
	$danio=$_REQUEST['danio'];
	if($danio==''){
		$str  = " SELECT  TIPO_PLAFON, DANIO, FOTO, REPORTE, ".
			" CASE ".
						" WHEN PARTE='CUADRANTE_1' THEN 'QUADRANT 1' ".
						" WHEN PARTE='CUADRANTE_2' THEN 'QUADRANT 2' ".
						" WHEN PARTE='CUADRANTE_3' THEN 'QUADRANT 3' ".
						" WHEN PARTE='CUADRANTE_4' THEN 'QUADRANT 4' ".
						" WHEN PARTE='FIRMA' THEN 'SIGNATURE' ".
						" WHEN PARTE='LODERA' THEN 'FLAP' ".
						" WHEN PARTE='PERFIL_DERECHO' THEN 'RIGHT SIDE' ".
						" WHEN PARTE='PERFIL_IZQUIERDO' THEN 'LEFT SIDE' ".
						" WHEN PARTE='PATINES' THEN 'LANDING GEAR' ".
						" WHEN PARTE='REFACCION' THEN 'TIRE RACK' ".
						" WHEN PARTE='PLACAS' THEN 'LICENSE PLATE' ".
						" WHEN PARTE='PLAFON_IZQ' THEN 'LEFT TAIL LIGHT' ".
						" WHEN PARTE='PLAFON_DER' THEN 'RIGHT TAIL LIGHT' ".
						" WHEN PARTE='FOCO_ESQUINA' THEN 'LIGHT' ".
						" WHEN PARTE='FOCO_MEDIO' THEN 'LIGHT' ".
						" WHEN PARTE='PALANCA_EJES' THEN '' ".
						" WHEN PARTE='CUADRANTE_5' THEN 'QUADRANT 5' ".
						" WHEN PARTE='CUADRANTE_6' THEN 'QUADRANT 6' ".
						" WHEN PARTE='CUADRANTE_7' THEN 'QUADRANT 7' ".
						" WHEN PARTE='CUADRANTE_8' THEN 'QUADRANT 8' ".
						" WHEN PARTE='MEDIDOR_DIESEL_THERMO' THEN '' ".
						" WHEN PARTE='CARGADOR' THEN 'X MEMBER' ".
						" WHEN PARTE='PALANCA_EJES' THEN '' ".
						" WHEN PARTE='PUERTAS_THERMO' THEN 'REEFER UNIT DOORS' ".
						" WHEN PARTE='BISAGRA_SUP_IZQ' THEN 'LEFT HINGE' ".
						" WHEN PARTE='BISAGRA_SUP_DER' THEN 'RIGHT HINGE' ".
						" WHEN PARTE='BISAGRA_INF_IZQ' THEN 'LEFT HINGE' ".
						" WHEN PARTE='BISAGRA_INF_DER' THEN 'RIGHT HINGE' ".
						" WHEN PARTE='ALDABA' THEN 'LOCK CATCH' ".
						" WHEN PARTE='DEFENSA' THEN 'DOT BUMPER' ".
						" WHEN PARTE='DEFENSA_IZQ' THEN 'DOT BUMPER' ".
						" WHEN PARTE='DEFENSA_DER' THEN 'DOT BUMPER' ".
						" WHEN PARTE='PUERTA' THEN 'DOORS' ".
						" WHEN PARTE='BOLSAS_AIRE_DELANTERAS' THEN 'AIRBAG' ".
						" WHEN PARTE='BOLSAS_AIRE_TRASERAS' THEN 'AIRBAG' ".
						" WHEN PARTE='VASTAGO_DELANTERO' THEN 'PUSHROD' ".
						" WHEN PARTE='VASTAGO_TRASERO' THEN 'PUSHROD' ".
						" WHEN PARTE='BALATAS_DELANTERAS' THEN 'BREAKS' ".
						" WHEN PARTE='BALATAS_TRASERAS' THEN 'BREAKS' ".
						" WHEN PARTE='ROTOCHAMBER_DELANTERO' THEN 'BREAKCHAMBER' ".
						" WHEN PARTE='ROTOCHAMBER_TRASERO' THEN 'BREAKCHAMBER' ".
						" WHEN PARTE='MANGUERAS' THEN 'HOSES' ".
						" WHEN PARTE='AMORTIGUADORES_DELANTEROS' THEN 'SHOCK' ".
						" WHEN PARTE='AMORTIGUADORES_TRASEROS' THEN 'SHOCK' ".
						" WHEN PARTE='VARILLA_SUSP' THEN '' ".
						" WHEN PARTE='CARGADOR_DELANTERO' THEN 'XMEMBER' ".
						" WHEN PARTE='CARGADOR_TRASERO' THEN 'XMEMBER' ".
						" WHEN PARTE='EJE_DELANTERO' THEN 'AXLE' ".
						" WHEN PARTE='EJE_TRASERO' THEN 'AXLE' ".
						" WHEN PARTE='QUINTA_IZQUIERDA' THEN '' ".
						" WHEN PARTE='QUINTA_DERECHA' THEN '' ".
						" WHEN PARTE='TANQUE_IZQUIERDO' THEN '' ".
						" WHEN PARTE='TANQUE_DERECHO' THEN '' ".
						" WHEN PARTE='MOTOR_IZQUIERDO' THEN 'MOTOR' ".
						" WHEN PARTE='MOTOR_DERECHO' THEN 'MOTOR' ".
						" WHEN PARTE='CAJA' THEN 'INSIDE' ".
						" WHEN PARTE='FALDON' THEN 'SKIRT' ".
						" WHEN PARTE='TANQUE' THEN 'FUEL TANK' ".
						" WHEN PARTE='ALERON' THEN 'TAIL' ".
						" WHEN PARTE='BATERIA' THEN 'BATTERY' ".
						" ELSE PARTE ".
			" END AS PARTE, ".
			" CASE ".
				" WHEN UNIDAD='T' THEN 'TRUCK' ".
				" WHEN UNIDAD='C' THEN 'TRAILER' ".
				" WHEN FRENTE='FIRMA_OPER' THEN 'DRIVER' ".
				" ELSE UNIDAD ".
			" END AS UNIDAD , ".
			" CASE ".
				" WHEN FRENTE='FRENTE' THEN 'FRONT' ".
				" WHEN FRENTE='DERECHO' THEN 'RIGHT' ".
				" WHEN FRENTE='IZQUIERDO' THEN 'LEFT' ".
				" WHEN FRENTE='PUERTAS' THEN 'REAR' ".
				" WHEN FRENTE='OPERADOR' THEN 'DRIVER' ".
				" WHEN FRENTE='SUSPENSION' THEN 'SUSPENSION' ".
				" WHEN FRENTE='REFACCION' THEN 'TIRE RACK' ".
				" ELSE FRENTE ".
			" END AS FRENTE ".
		    " FROM INCIDENTE WHERE ID_INTERCAMBIO = ".$id_intercambio." ".
		    " AND FRENTE!='FIRMA_OPER' ".
		    " ORDER BY UNIDAD, FRENTE, PARTE ";
	}else{
		$str  = " SELECT   TIPO_PLAFON, DANIO, FOTO, REPORTE, ".
				" CASE ".
				" WHEN PARTE='CUADRANTE_1' THEN 'QUADRANT 1' ".
						" WHEN PARTE='CUADRANTE_2' THEN 'QUADRANT 2' ".
						" WHEN PARTE='CUADRANTE_3' THEN 'QUADRANT 3' ".
						" WHEN PARTE='CUADRANTE_4' THEN 'QUADRANT 4' ".
						" WHEN PARTE='FIRMA' THEN 'SIGNATURE' ".
						" WHEN PARTE='LODERA' THEN 'FLAP' ".
						" WHEN PARTE='PERFIL_DERECHO' THEN 'RIGHT SIDE' ".
						" WHEN PARTE='PERFIL_IZQUIERDO' THEN 'LEFT SIDE' ".
						" WHEN PARTE='PATINES' THEN 'LANDING GEAR' ".
						" WHEN PARTE='REFACCION' THEN 'TIRE RACK' ".
						" WHEN PARTE='PLACAS' THEN 'LICENSE PLATE' ".
						" WHEN PARTE='PLAFON_IZQ' THEN 'LEFT TAIL LIGHT' ".
						" WHEN PARTE='PLAFON_DER' THEN 'RIGHT TAIL LIGHT' ".
						" WHEN PARTE='FOCO_ESQUINA' THEN 'LIGHT' ".
						" WHEN PARTE='FOCO_MEDIO' THEN 'LIGHT' ".
						" WHEN PARTE='PALANCA_EJES' THEN '' ".
						" WHEN PARTE='CUADRANTE_5' THEN 'QUADRANT 5' ".
						" WHEN PARTE='CUADRANTE_6' THEN 'QUADRANT 6' ".
						" WHEN PARTE='CUADRANTE_7' THEN 'QUADRANT 7' ".
						" WHEN PARTE='CUADRANTE_8' THEN 'QUADRANT 8' ".
						" WHEN PARTE='MEDIDOR_DIESEL_THERMO' THEN '' ".
						" WHEN PARTE='CARGADOR' THEN 'X MEMBER' ".
						" WHEN PARTE='PALANCA_EJES' THEN '' ".
						" WHEN PARTE='PUERTAS_THERMO' THEN 'REEFER UNIT DOORS' ".
						" WHEN PARTE='BISAGRA_SUP_IZQ' THEN 'LEFT HINGE' ".
						" WHEN PARTE='BISAGRA_SUP_DER' THEN 'RIGHT HINGE' ".
						" WHEN PARTE='BISAGRA_INF_IZQ' THEN 'LEFT HINGE' ".
						" WHEN PARTE='BISAGRA_INF_DER' THEN 'RIGHT HINGE' ".
						" WHEN PARTE='ALDABA' THEN 'LOCK CATCH' ".
						" WHEN PARTE='DEFENSA' THEN 'DOT BUMPER' ".
						" WHEN PARTE='DEFENSA_IZQ' THEN 'DOT BUMPER' ".
						" WHEN PARTE='DEFENSA_DER' THEN 'DOT BUMPER' ".
						" WHEN PARTE='PUERTA' THEN 'DOORS' ".
						" WHEN PARTE='BOLSAS_AIRE_DELANTERAS' THEN 'AIRBAG' ".
						" WHEN PARTE='BOLSAS_AIRE_TRASERAS' THEN 'AIRBAG' ".
						" WHEN PARTE='VASTAGO_DELANTERO' THEN 'PUSHROD' ".
						" WHEN PARTE='VASTAGO_TRASERO' THEN 'PUSHROD' ".
						" WHEN PARTE='BALATAS_DELANTERAS' THEN 'BREAKS' ".
						" WHEN PARTE='BALATAS_TRASERAS' THEN 'BREAKS' ".
						" WHEN PARTE='ROTOCHAMBER_DELANTERO' THEN 'BREAKCHAMBER' ".
						" WHEN PARTE='ROTOCHAMBER_TRASERO' THEN 'BREAKCHAMBER' ".
						" WHEN PARTE='MANGUERAS' THEN 'HOSES' ".
						" WHEN PARTE='AMORTIGUADORES_DELANTEROS' THEN 'SHOCK' ".
						" WHEN PARTE='AMORTIGUADORES_TRASEROS' THEN 'SHOCK' ".
						" WHEN PARTE='VARILLA_SUSP' THEN '' ".
						" WHEN PARTE='CARGADOR_DELANTERO' THEN 'XMEMBER' ".
						" WHEN PARTE='CARGADOR_TRASERO' THEN 'XMEMBER' ".
						" WHEN PARTE='EJE_DELANTERO' THEN 'AXLE' ".
						" WHEN PARTE='EJE_TRASERO' THEN 'AXLE' ".
						" WHEN PARTE='QUINTA_IZQUIERDA' THEN '' ".
						" WHEN PARTE='QUINTA_DERECHA' THEN '' ".
						" WHEN PARTE='TANQUE_IZQUIERDO' THEN '' ".
						" WHEN PARTE='TANQUE_DERECHO' THEN '' ".
						" WHEN PARTE='MOTOR_IZQUIERDO' THEN 'MOTOR' ".
						" WHEN PARTE='MOTOR_DERECHO' THEN 'MOTOR' ".
						" WHEN PARTE='CAJA' THEN 'INSIDE' ".
						" WHEN PARTE='FALDON' THEN 'SKIRT' ".
						" WHEN PARTE='TANQUE' THEN 'FUEL TANK' ".
						" WHEN PARTE='ALERON' THEN 'TAIL' ".
						" WHEN PARTE='BATERIA' THEN 'BATTERY' ".
						" ELSE PARTE ".
			" END AS PARTE, ".
			" CASE ".
				" WHEN UNIDAD='T' THEN 'TRUCK' ".
				" WHEN UNIDAD='C' THEN 'TRAILER' ".
				" WHEN FRENTE='FIRMA_OPER' THEN 'DRIVER' ".
				" ELSE UNIDAD ".
			" END AS UNIDAD , ".
			" CASE ".
				" WHEN FRENTE='FRENTE' THEN 'FRONT' ".
				" WHEN FRENTE='DERECHO' THEN 'RIGHT' ".
				" WHEN FRENTE='IZQUIERDO' THEN 'LEFT' ".
				" WHEN FRENTE='PUERTAS' THEN 'REAR' ".
				" WHEN FRENTE='OPERADOR' THEN 'DRIVER' ".
				" WHEN FRENTE='SUSPENSION' THEN 'SUSPENSION' ".
				" WHEN FRENTE='REFACCION' THEN 'TIRE RACK' ".
				" ELSE FRENTE ".
			" END AS FRENTE ".
		    " FROM INCIDENTE WHERE ID_INTERCAMBIO = ".$id_intercambio." ".
		    " AND DANIO=".$danio." ".
		    " AND FRENTE!='FIRMA_OPER' ".
		    " ORDER BY UNIDAD, FRENTE, PARTE ";
	}
 	$db=conexion_bd();
  	$incidentes=consulta($db,$str);
  	cerrarConexion($db);
  	if($incidentes!=0){
  		return $incidentes;
  	}else{
  		return 0;
  	}
  	
}
function obtenerIncidentesIntercambio(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	$danio=$_REQUEST['danio'];
	if($danio==''){
		$str  = " SELECT  TIPO_PLAFON, DANIO, FOTO, REPORTE, ".
			" CASE ".
						" WHEN PARTE='CUADRANTE_1' THEN 'QUADRANT 1' ".
						" WHEN PARTE='CUADRANTE_2' THEN 'QUADRANT 2' ".
						" WHEN PARTE='CUADRANTE_3' THEN 'QUADRANT 3' ".
						" WHEN PARTE='CUADRANTE_4' THEN 'QUADRANT 4' ".
						" WHEN PARTE='FIRMA' THEN 'SIGNATURE' ".
						" WHEN PARTE='LODERA' THEN 'FLAP' ".
						" WHEN PARTE='PERFIL_DERECHO' THEN 'RIGHT SIDE' ".
						" WHEN PARTE='PERFIL_IZQUIERDO' THEN 'LEFT SIDE' ".
						" WHEN PARTE='PATINES' THEN 'LANDING GEAR' ".
						" WHEN PARTE='REFACCION' THEN 'TIRE RACK' ".
						" WHEN PARTE='PLACAS' THEN 'LICENSE PLATE' ".
						" WHEN PARTE='PLAFON_IZQ' THEN 'LEFT TAIL LIGHT' ".
						" WHEN PARTE='PLAFON_DER' THEN 'RIGHT TAIL LIGHT' ".
						" WHEN PARTE='FOCO_ESQUINA' THEN 'LIGHT' ".
						" WHEN PARTE='FOCO_MEDIO' THEN 'LIGHT' ".
						" WHEN PARTE='PALANCA_EJES' THEN '' ".
						" WHEN PARTE='CUADRANTE_5' THEN 'QUADRANT 5' ".
						" WHEN PARTE='CUADRANTE_6' THEN 'QUADRANT 6' ".
						" WHEN PARTE='CUADRANTE_7' THEN 'QUADRANT 7' ".
						" WHEN PARTE='CUADRANTE_8' THEN 'QUADRANT 8' ".
						" WHEN PARTE='MEDIDOR_DIESEL_THERMO' THEN '' ".
						" WHEN PARTE='CARGADOR' THEN 'X MEMBER' ".
						" WHEN PARTE='PALANCA_EJES' THEN '' ".
						" WHEN PARTE='PUERTAS_THERMO' THEN 'REEFER UNIT DOORS' ".
						" WHEN PARTE='BISAGRA_SUP_IZQ' THEN 'LEFT HINGE' ".
						" WHEN PARTE='BISAGRA_SUP_DER' THEN 'RIGHT HINGE' ".
						" WHEN PARTE='BISAGRA_INF_IZQ' THEN 'LEFT HINGE' ".
						" WHEN PARTE='BISAGRA_INF_DER' THEN 'RIGHT HINGE' ".
						" WHEN PARTE='ALDABA' THEN 'LOCK CATCH' ".
						" WHEN PARTE='DEFENSA' THEN 'DOT BUMPER' ".
						" WHEN PARTE='DEFENSA_IZQ' THEN 'DOT BUMPER' ".
						" WHEN PARTE='DEFENSA_DER' THEN 'DOT BUMPER' ".
						" WHEN PARTE='PUERTA' THEN 'DOORS' ".
						" WHEN PARTE='BOLSAS_AIRE_DELANTERAS' THEN 'AIRBAG' ".
						" WHEN PARTE='BOLSAS_AIRE_TRASERAS' THEN 'AIRBAG' ".
						" WHEN PARTE='VASTAGO_DELANTERO' THEN 'PUSHROD' ".
						" WHEN PARTE='VASTAGO_TRASERO' THEN 'PUSHROD' ".
						" WHEN PARTE='BALATAS_DELANTERAS' THEN 'BREAKS' ".
						" WHEN PARTE='BALATAS_TRASERAS' THEN 'BREAKS' ".
						" WHEN PARTE='ROTOCHAMBER_DELANTERO' THEN 'BREAKCHAMBER' ".
						" WHEN PARTE='ROTOCHAMBER_TRASERO' THEN 'BREAKCHAMBER' ".
						" WHEN PARTE='MANGUERAS' THEN 'HOSES' ".
						" WHEN PARTE='AMORTIGUADORES_DELANTEROS' THEN 'SHOCK' ".
						" WHEN PARTE='AMORTIGUADORES_TRASEROS' THEN 'SHOCK' ".
						" WHEN PARTE='VARILLA_SUSP' THEN '' ".
						" WHEN PARTE='CARGADOR_DELANTERO' THEN 'XMEMBER' ".
						" WHEN PARTE='CARGADOR_TRASERO' THEN 'XMEMBER' ".
						" WHEN PARTE='EJE_DELANTERO' THEN 'AXLE' ".
						" WHEN PARTE='EJE_TRASERO' THEN 'AXLE' ".
						" WHEN PARTE='QUINTA_IZQUIERDA' THEN '' ".
						" WHEN PARTE='QUINTA_DERECHA' THEN '' ".
						" WHEN PARTE='TANQUE_IZQUIERDO' THEN '' ".
						" WHEN PARTE='TANQUE_DERECHO' THEN '' ".
						" WHEN PARTE='MOTOR_IZQUIERDO' THEN 'MOTOR' ".
						" WHEN PARTE='MOTOR_DERECHO' THEN 'MOTOR' ".
						" WHEN PARTE='CAJA' THEN 'INSIDE' ".
						" WHEN PARTE='FALDON' THEN 'SKIRT' ".
						" WHEN PARTE='TANQUE' THEN 'FUEL TANK' ".
						" WHEN PARTE='ALERON' THEN 'TAIL' ".
						" WHEN PARTE='BATERIA' THEN 'BATTERY' ".
						" ELSE PARTE ".
			" END AS PARTE, ".
			" CASE ".
				" WHEN UNIDAD='T' THEN 'TRUCK' ".
				" WHEN UNIDAD='C' THEN 'TRAILER' ".
				" WHEN FRENTE='FIRMA_OPER' THEN 'DRIVER' ".
				" ELSE UNIDAD ".
			" END AS UNIDAD , ".
			" CASE ".
				" WHEN FRENTE='FRENTE' THEN 'FRONT' ".
				" WHEN FRENTE='DERECHO' THEN 'RIGHT' ".
				" WHEN FRENTE='IZQUIERDO' THEN 'LEFT' ".
				" WHEN FRENTE='PUERTAS' THEN 'REAR' ".
				" WHEN FRENTE='OPERADOR' THEN 'DRIVER' ".
				" WHEN FRENTE='SUSPENSION' THEN 'SUSPENSION' ".
				" WHEN FRENTE='REFACCION' THEN 'TIRE RACK' ".
				" ELSE FRENTE ".
			" END AS FRENTE ".
		    " FROM INCIDENTE WHERE ID_INTERCAMBIO = ".$id_intercambio." ".
		    " AND FRENTE!='FIRMA_OPER' ".
		    " ORDER BY UNIDAD, FRENTE, PARTE ";
	}else{
		$str  = " SELECT   TIPO_PLAFON, DANIO, FOTO, REPORTE, ".
				" CASE ".
				" WHEN PARTE='CUADRANTE_1' THEN 'QUADRANT 1' ".
						" WHEN PARTE='CUADRANTE_2' THEN 'QUADRANT 2' ".
						" WHEN PARTE='CUADRANTE_3' THEN 'QUADRANT 3' ".
						" WHEN PARTE='CUADRANTE_4' THEN 'QUADRANT 4' ".
						" WHEN PARTE='FIRMA' THEN 'SIGNATURE' ".
						" WHEN PARTE='LODERA' THEN 'FLAP' ".
						" WHEN PARTE='PERFIL_DERECHO' THEN 'RIGHT SIDE' ".
						" WHEN PARTE='PERFIL_IZQUIERDO' THEN 'LEFT SIDE' ".
						" WHEN PARTE='PATINES' THEN 'LANDING GEAR' ".
						" WHEN PARTE='REFACCION' THEN 'TIRE RACK' ".
						" WHEN PARTE='PLACAS' THEN 'LICENSE PLATE' ".
						" WHEN PARTE='PLAFON_IZQ' THEN 'LEFT TAIL LIGHT' ".
						" WHEN PARTE='PLAFON_DER' THEN 'RIGHT TAIL LIGHT' ".
						" WHEN PARTE='FOCO_ESQUINA' THEN 'LIGHT' ".
						" WHEN PARTE='FOCO_MEDIO' THEN 'LIGHT' ".
						" WHEN PARTE='PALANCA_EJES' THEN '' ".
						" WHEN PARTE='CUADRANTE_5' THEN 'QUADRANT 5' ".
						" WHEN PARTE='CUADRANTE_6' THEN 'QUADRANT 6' ".
						" WHEN PARTE='CUADRANTE_7' THEN 'QUADRANT 7' ".
						" WHEN PARTE='CUADRANTE_8' THEN 'QUADRANT 8' ".
						" WHEN PARTE='MEDIDOR_DIESEL_THERMO' THEN '' ".
						" WHEN PARTE='CARGADOR' THEN 'X MEMBER' ".
						" WHEN PARTE='PALANCA_EJES' THEN '' ".
						" WHEN PARTE='PUERTAS_THERMO' THEN 'REEFER UNIT DOORS' ".
						" WHEN PARTE='BISAGRA_SUP_IZQ' THEN 'LEFT HINGE' ".
						" WHEN PARTE='BISAGRA_SUP_DER' THEN 'RIGHT HINGE' ".
						" WHEN PARTE='BISAGRA_INF_IZQ' THEN 'LEFT HINGE' ".
						" WHEN PARTE='BISAGRA_INF_DER' THEN 'RIGHT HINGE' ".
						" WHEN PARTE='ALDABA' THEN 'LOCK CATCH' ".
						" WHEN PARTE='DEFENSA' THEN 'DOT BUMPER' ".
						" WHEN PARTE='DEFENSA_IZQ' THEN 'DOT BUMPER' ".
						" WHEN PARTE='DEFENSA_DER' THEN 'DOT BUMPER' ".
						" WHEN PARTE='PUERTA' THEN 'DOORS' ".
						" WHEN PARTE='BOLSAS_AIRE_DELANTERAS' THEN 'AIRBAG' ".
						" WHEN PARTE='BOLSAS_AIRE_TRASERAS' THEN 'AIRBAG' ".
						" WHEN PARTE='VASTAGO_DELANTERO' THEN 'PUSHROD' ".
						" WHEN PARTE='VASTAGO_TRASERO' THEN 'PUSHROD' ".
						" WHEN PARTE='BALATAS_DELANTERAS' THEN 'BREAKS' ".
						" WHEN PARTE='BALATAS_TRASERAS' THEN 'BREAKS' ".
						" WHEN PARTE='ROTOCHAMBER_DELANTERO' THEN 'BREAKCHAMBER' ".
						" WHEN PARTE='ROTOCHAMBER_TRASERO' THEN 'BREAKCHAMBER' ".
						" WHEN PARTE='MANGUERAS' THEN 'HOSES' ".
						" WHEN PARTE='AMORTIGUADORES_DELANTEROS' THEN 'SHOCK' ".
						" WHEN PARTE='AMORTIGUADORES_TRASEROS' THEN 'SHOCK' ".
						" WHEN PARTE='VARILLA_SUSP' THEN '' ".
						" WHEN PARTE='CARGADOR_DELANTERO' THEN 'XMEMBER' ".
						" WHEN PARTE='CARGADOR_TRASERO' THEN 'XMEMBER' ".
						" WHEN PARTE='EJE_DELANTERO' THEN 'AXLE' ".
						" WHEN PARTE='EJE_TRASERO' THEN 'AXLE' ".
						" WHEN PARTE='QUINTA_IZQUIERDA' THEN '' ".
						" WHEN PARTE='QUINTA_DERECHA' THEN '' ".
						" WHEN PARTE='TANQUE_IZQUIERDO' THEN '' ".
						" WHEN PARTE='TANQUE_DERECHO' THEN '' ".
						" WHEN PARTE='MOTOR_IZQUIERDO' THEN 'MOTOR' ".
						" WHEN PARTE='MOTOR_DERECHO' THEN 'MOTOR' ".
						" WHEN PARTE='CAJA' THEN 'INSIDE' ".
						" WHEN PARTE='FALDON' THEN 'SKIRT' ".
						" WHEN PARTE='TANQUE' THEN 'FUEL TANK' ".
						" WHEN PARTE='ALERON' THEN 'TAIL' ".
						" WHEN PARTE='BATERIA' THEN 'BATTERY' ".
						" ELSE PARTE ".
			" END AS PARTE, ".
			" CASE ".
				" WHEN UNIDAD='T' THEN 'TRUCK' ".
				" WHEN UNIDAD='C' THEN 'TRAILER' ".
				" WHEN FRENTE='FIRMA_OPER' THEN 'DRIVER' ".
				" ELSE UNIDAD ".
			" END AS UNIDAD , ".
			" CASE ".
				" WHEN FRENTE='FRENTE' THEN 'FRONT' ".
				" WHEN FRENTE='DERECHO' THEN 'RIGHT' ".
				" WHEN FRENTE='IZQUIERDO' THEN 'LEFT' ".
				" WHEN FRENTE='PUERTAS' THEN 'REAR' ".
				" WHEN FRENTE='OPERADOR' THEN 'DRIVER' ".
				" WHEN FRENTE='SUSPENSION' THEN 'SUSPENSION' ".
				" WHEN FRENTE='REFACCION' THEN 'TIRE RACK' ".
				" ELSE FRENTE ".
			" END AS FRENTE ".
		    " FROM INCIDENTE WHERE ID_INTERCAMBIO = ".$id_intercambio." ".
		    " AND DANIO=".$danio." ".
		    " AND FRENTE!='FIRMA_OPER' ".
		    " ORDER BY UNIDAD, FRENTE, PARTE ";
	}
 	$db=conexion_bd();
  	$incidentes=consulta($db,$str);
  	cerrarConexion($db);
  	if($incidentes!=0){
  		return '{"incidentes": ' . json_encode($incidentes) . '}';
  	}else{
  		return 0;
  	}
  	
}

function intercambioDesenganchado(){
	$tipo=$_REQUEST['tipo_intercambio'];
	$no_tractor=$_REQUEST['no_tracto'];
	
	$id_patio=$_REQUEST['patio'];
	$tipo_reg=$_REQUEST['tipo_reg'];
	$id_usuario=$_REQUEST['id_usuario'];
	$log_querys="";
	
	if($_REQUEST['tractorExtSel']=='OTRO'){
		$id_linea_tractor='null';
		$otra_linea=$_REQUEST['linea_tracto'];
	}else{
		$id_linea_tractor=$_REQUEST['tractorExtSel'];
		$otra_linea=null;
	}
	

	if($tipo_reg=='COMPLETO'){
		$str="INSERT INTO INTERCAMBIO (TIPO,FECHA,STATUS,ID_PATIO,ID_USUARIO,TIPO_REG,NUM_TRACTOR,ID_LINEA_TRACTOR,REG_COMPLETO) ".
			 "VALUES ('$tipo',now(),'0',$id_patio,$id_usuario,'C','$no_tractor',$id_linea_tractor,'0')";
	}else{
		$fecha=$_REQUEST['fecha'];
		$str="INSERT INTO INTERCAMBIO (TIPO,FECHA,STATUS,ID_PATIO,ID_USUARIO,TIPO_REG, NUM_TRACTOR, ID_LINEA_TRACTOR, REG_COMPLETO) ".
			 "VALUES ('$tipo','$fecha','0',$id_patio,$id_usuario,'I','$no_tractor',$id_linea_tractor,'0')";
	}
	//return $str;
	$db=conexion_bd();
	$id_intercambio=insertar($db,$str);
	cerrarConexion($db);
	if($id_intercambio!=0){
		$tipo_tractor=$_REQUEST['tipo_tractor'];
		$placas=$_REQUEST['placas_tracto'];
		$res_tractor=insertarTractor($id_intercambio,$tipo_tractor,$placas,$otra_linea,$log_querys);
		if($res_tractor){
			$nombre_ope=$_REQUEST['nombre_oper'];
			$ape_pat_ope=$_REQUEST['ape_p'];
			$ape_mat_ope=$_REQUEST['ape_m'];
			$num_ope=$_REQUEST['no_oper'];
			$gatas=$_REQUEST['gatas_tracto'];
			$res_operador=insertarOperador($id_intercambio, $nombre_ope, $ape_pat_ope, $ape_mat_ope, $num_ope, $gatas, $log_querys);
			if($res_operador){
				if($tipo=='S'){
					$id_intercambio_entrada_tractor=$_REQUEST['id_intercambio_entrada_tractor'];
					$res_salida_tractor=actualizarSalidaTractor($id_intercambio_entrada_tractor,$id_intercambio, $log_querys);
					if($res_salida_tractor){//actualizar el intercambio para que ya este activo e indicarle que ya se guardo completo
						$res_status_inter=actualizarStatusInter($id_intercambio, $log_querys);
						if($res_status_inter){
							return 1;//ya se almaceno todo correctamente
						}else{
							return -1;//error al cambiar el estatus del inter a activo y prender bandera de que se almaceno correctamente
						}
					}else{
						return -1;
					}
				}else{
					$res_status_inter=actualizarStatusInter($id_intercambio, $log_querys);
					if($res_status_inter){
						return 1;//ya se almaceno todo correctamente
					}else{
						return -1;//error al cambiar el estatus del inter a activo y prender bandera de que se almaceno correctamente
					
					}	
				}	
			}else{
				return -1;
			}
		}else{
			return -1;
		}
	}else{
		return -1;
	}

}

function obtenerFirmaOper(){
	$id_intercambio=$_REQUEST['id_intercambio'];
	
	$str  = " SELECT  FOTO ".
			" FROM INCIDENTE WHERE ID_INTERCAMBIO = ".$id_intercambio." ".
		    " AND FRENTE='FIRMA_OPER' AND FOTO!='' AND FOTO IS NOT NULL ";
		    
	//return $str;
 	$db=conexion_bd();
  	$firma=consulta($db,$str);
  	cerrarConexion($db);
  	if($firma!=0){
  		return  json_encode($firma[0]) ;
  	}else{
  		return 0;
  	}

}

function obtenerFirmaOper_array($id_intercambio){
	
	$str  = " SELECT  FOTO ".
			" FROM INCIDENTE WHERE ID_INTERCAMBIO = ".$id_intercambio." ".
		    " AND FRENTE='FIRMA_OPER' AND FOTO!='' AND FOTO IS NOT NULL ";
		    
	//return $str;
 	$db=conexion_bd();
  	$firma=consulta($db,$str);
  	cerrarConexion($db);
  	if($firma!=0){
  		return $firma[0];
  	}else{
  		return 0;
  	}

}


?>