<?php
	
	function conexion_ftp($host,$puerto,$user,$pass){
		$id_ftp = @ftp_connect($host,$puerto);
		if($id_ftp){
			if(@ftp_login($id_ftp, $user, $pass)){
				@ftp_pasv($id_ftp, true);
				return $id_ftp;
			}else{
				return -2;//usuario o contraseña incorrecta
			}
		}else{
			return -1; //error con el host y puerto
		}
		
		

	}

	function directorio_ftp($id_ftp,$ruta){
		
		if(@ftp_chdir($id_ftp, $ruta)){
			return true;
		}else{
			$carpetas= explode('/', $ruta);
			foreach ($carpetas as $carpeta) {
				if(!@ftp_chdir($id_ftp, $carpeta)){
					@ftp_mkdir($id_ftp, $carpeta);
					@ftp_chdir($id_ftp, $carpeta);
				}
			}
			//echo $ruta;
			if(@ftp_chdir($id_ftp, "/".$ruta)){
				return true;
			}else{
				return false;
			}
		}
	}

	function subir_ftp($id_ftp,$remote_file,$local_file,$mode){
		return @ftp_put($id_ftp, $remote_file, $local_file, $mode);
	}

	function cerrar_ftp($id_ftp){
		@ftp_close($id_ftp);
	}

	function bajar_dir_ftp ($id_ftp, $dir) { 
		//echo "dir=".$dir."\n";
    

	    if ($dir != ".") { 
	        if (ftp_chdir($id_ftp, $dir) == false) { 
	            //echo ("Change Dir Failed: $dir<BR>\r\n"); 
	            return -3; 
	        } 
	        if (!(is_dir($dir))) 
	            mkdir($dir); 
	        chdir ($dir);
	    } 

	    $contents = ftp_nlist($id_ftp, "."); 
	    foreach ($contents as $file) { 

	        if ($file == '.' || $file == '..') 
	            continue; 

	        if (@ftp_chdir($id_ftp, $file)) { 
	            ftp_chdir ($id_ftp, ".."); 
	            bajar_dir_ftp ($id_ftp,$file); 
	        } 
	        else 
	            ftp_get($id_ftp, $file, $file, FTP_BINARY); 
	    } 

	    ftp_chdir ($id_ftp, ".."); 
	    chdir (".."); 

	} 

?>