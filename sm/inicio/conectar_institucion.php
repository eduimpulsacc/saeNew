<?
session_start();
	/////////////////
    //INICIO SESSION
	/////////////////

			//CHEQUEA QUE EL NRO DE LA SESSION ASIGNADO 
			//AL LOGONEARSE CORRESPONDE AL ID ACTUAL DE LA SESSION
			if( !( @$_CHK_ID==@session_id() ) ){
			echo "LA SESION DE USUARIO HA EXPIRADO";
			session_unset();
			session_destroy();
			exit;
			}

///////////////////////////////
//CONECCION A LA BASE DE DATOS
//////////////////////////////





$connection=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_Usuario ");


$sql ="SELECT dbname,host,port,base_dato.user,base_dato.password FROM institucion INNER JOIN accede ON institucion.rdb=accede.rdb INNER JOIN base_dato ON accede.id_base=base_dato.id_base WHERE institucion.rdb='".$_INSTIT."'";
$result = pg_exec($connection,$sql) or die("ERROR DE INSTITUCION");


$fila = @pg_fetch_array($result,0);
$dbname = $fila['dbname'];
$host = $fila['host'];
$port = $fila['port'];
$user = $fila['user'];
$password = $fila['password'];

$conn=pg_connect("dbname=$dbname host=$host port=$port user=$user password=$password") or die ("Error de conexión en institucion.");
		
	   function tilde($campo){

		$dato="";
		
		for($s=0;$s<=strlen($campo);$s++){
			
			$letra = substr($campo,$s,1);
			
			if($s==0){
				
			  if($letra=="á"){
			    $dato .= str_replace("á","Á",$letra);
			   }else if($letra=="é"){
			    $dato .= str_replace("é","É",$letra);
			   }else if($letra=="í"){
			    $dato .= str_replace("í","Í",$letra);
			   }else if($letra=="ó"){
			    $dato .= str_replace("ó","Ó",$letra);
			   }else if($letra=="ú"){
			    $dato .= str_replace("ú","Ú",$letra);
			   }else if($letra=="ñ"){
			    $dato .= str_replace("ñ","Ñ",$letra);	
			   }else{
				$dato .= strtoupper($letra); //MAYUSCULA
				 }
			   
			 }else{
				 
			   if($letra=="Á"){
			    $dato .= str_replace("Á","á",$letra);
			   }else if($letra=="É"){
			    $dato .= str_replace("É","é",$letra);
			   }else if($letra=="Í"){
			    $dato .= str_replace("Í","í",$letra);
			   }else if($letra=="Ó"){
			    $dato .= str_replace("Ó","ó",$letra);
			   }else if($letra=="Ú"){
			    $dato .= str_replace("Ú","ú",$letra);
			   }else if($letra=="Ñ"){
			    $dato .= str_replace("Ñ","ñ",$letra);
			   }else{
				$dato .= strtolower($letra); // MINUSCULA
				 }
				 
				 }
			 
			}//for
		   
		   return $dato;
	   		   
	     }
	  
	   
	   
?>
