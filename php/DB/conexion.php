<?php
/*
APLICATION NAME: ELECTRONIC INSPECTION SYSTEM
DESCTIPTION: SISTEMA ELECTRONICO DE INSPECCIONES DE CAJAS, PLATAFORMAS, PIPAS Y TRACTORES
AUTHOR:  PADILLA GUTIERREZ ANA GABRIELA
CREATED: DICIEMBRE, 2016
 */
	//error_reporting(E_ALL); PARA VER ERRORES
	error_reporting(0);
	require_once 'credenciales.php';
	function conexion_bd(){
		 try {

		    $db = new PDO("mysql:host=".HOST.";dbname=".BD,USER,PWD);
		    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		    //$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		    $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES UTF8');
		    return $db;
		  } catch (PDOException $e) {
		    return new PDOException("Error  : " .$e->getMessage());
		  }
	}

	function consulta($db,$query){
		 $stmt = $db->query($query);
		 /*if($stmt->fetchColumn() > 0){

		 	$stmt = $db->query($query);
		 	$array=$stmt->fetchAll(PDO::FETCH_BOTH);
 			return $array;
		 }else{
		 	return 0;
		 }*/
		 //$stmt = $db->query($query);
		 $array=$stmt->fetchAll(PDO::FETCH_BOTH);
		 if(count($array)>0){
		 	return $array;
		 }else{
		 	return 0;
		 }

		 $stmt=null;

	}

	function insertar($db,$query){
		$result = $db->exec($query);
		$insertId = $db->lastInsertId();
		if($result>0){
			return $insertId;
		}else{
			return 0;
		}
	}

	function modificar($db,$query){
		$affected_rows = $db->exec($query);
		return $affected_rows;
	}

    function cerrarConexion($db){
    	$db=null;
	}

	if (!function_exists('json_decode')){
		function json_decode($content,$assoc=false){
		require_once 'JSON.php';
			if($assoc){
			$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
			} else {
			$json = new Services_JSON;
			}
		return $json->decode($content);
		}
	}
	if(!function_exists('json_encode')){
		function json_encode($content){
			require_once 'JSON.php';
			$json = new Services_JSON;
			return $json->encode($content);
		}
	}
?>
