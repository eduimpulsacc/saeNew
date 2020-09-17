<?php 
require('../../../util/header.inc');

	 $institucion 	= $_INSTIT;
	 $ano			= $_ANO;
	
	//______________________________ SELECCIONA BD DE DONDE DEBE GUARDAR (COORPORACIONES)__________________________________//
	
/*	$sql_corp = "select num_corp from corp_instit where rdb = '".$_INSTIT."'";
	$res_corp = @pg_Exec($conn, $sql_corp);
	$num_corp = @pg_numrows($res_corp);
	
	if ($num_corp>0){   // pertenece a una corporación.... hay que saber a cual...
	     $fil_corp = @pg_fetch_array($res_corp,0);
		 $corporacion = $fil_corp['num_corp'];
	
	if ($corporacion=="1" or $corporacion=="4" or $corporacion=="12"){*/
		        
				/// pertenece a la corporacion de VIÑA o IQUIQUE
				// la conexión es...
	/*			 $conn2=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die 
("Error de conexión Viña.");
 
		 }else if($corporacion=="13"){
		 		*/
				
//$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die 

//("Error de conexión Antofagasta.");	

/*$conn2=pg_connect("dbname=coi_antofagasta host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die 
("Error de conexión Antofagasta.");	
				if (!$conn2) {
					 error('<b>ERROR:</b>No se puede conectar a la base de datos Antofagasta.');
					 exit;
					 }				
		 }else{
		 */
		       /// es de otra corporación... debe conectar a la base de datos nueva coi_corporacion
	/*		   	 $conn2=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or 
die ("Error de conexión Corporacion.");	
		 }
		 
	
	}	*/
	
	//________________________________________________________________________________________________//
	
	
	 $sql_apoderado = "SELECT rut_apo from tiene2 as t2 
	                   INNER JOIN matricula as m 
					   ON m.rut_alumno=t2.rut_alumno 
					   WHERE m.rdb=".$institucion." AND m.id_ano=".$ano."" ;
	$res_apoderado = @pg_Exec($conn,$sql_apoderado);

	$total_apoderado = @pg_num_rows($res_apoderado);
	
	

	$j=0;
	
	for($i=0;$i<($total_apoderado);$i++){
		
		$fila1 = @pg_fetch_array($res_apoderado,$i);	
		
		$password = substr("".$fila1['rut_apo']."",0,5);			
		//echo"<pre>";
		//echo $password;
		//echo"</pre>";
			
		 $sql_existe = "SELECT id_usuario FROM usuario WHERE nombre_usuario='".$fila1['rut_apo']."'";
		$res_existe = @pg_Exec($connection,$sql_existe);
		
		if(@pg_numrows($res_existe)==0){

			$insert_usuario = "INSERT INTO usuario (nombre_usuario, pw) VALUES ('".$fila1['rut_apo']."','".$password."')";
		    $Rs_usuario = @pg_exec($connection,$insert_usuario);

			$sql_id_max_usuario = "SELECT max(id_usuario) as id_max FROM accede";
			$res_id_max_usuario = @pg_Exec($connection,$sql_id_max_usuario);
			
			$fila2 = @pg_fetch_array($res_id_max_usuario,0);	
			
			$max_id_usuario = trim($fila2['id_max']);
			
		   $insert_accede = "INSERT INTO accede (id_usuario, id_perfil, rdb, estado) VALUES 
			(".$max_id_usuario.",15,".$institucion.",1)";
						$Rs_accede = @pg_exec($connection,$insert_accede);
			
		}else{//si existe actualizo accede solamente con el rbd actual jijijiji
		 
		 /* $sqlw = "select id_usuario from USUARIO where id_usuario = ".$fila['id_usuario'];
		  $rz=@pg_Exec($connection,$sqlw);
		  $filaz=pg_fetch_array($rz,0);
		 	
		 	if($filaz['id_usuario']){
			  echo $sql_in="INSERT INTO accede (id_usuario,id_perfil, rdb,id_sistema,id_base, estado) VALUES (".$id_usuario.",15,".$institucion.",1,".$_ID_BASE.",1)";
				  $rz=@pg_Exec($connection,$sql_in);
				  }*/
		 
		 
		   $fila = @pg_fetch_array($res_existe,0);
			 
			   $sql = "select * from accede where id_usuario = ".$fila['id_usuario']." and id_perfil = 15 and rdb = ".$institucion." ";
			   $Rs_accede = @pg_exec($connection,$sql) or die ("ERROR".$sql); 
			 
		   if(pg_num_rows($Rs_accede)==0){
				
				$insert_accede   = "INSERT INTO public.accede 
				( id_usuario,id_perfil,rdb,id_sistema,id_base,estado ) VALUES ( ".$fila['id_usuario'].",15,".$institucion.",1,".$_ID_BASE.",1);";
				$Rs_accede = @pg_exec($connection,$insert_accede) or die ("ERROR".$insert_accede);
				
				}
			
			/*
			  $fila3 = @pg_fetch_array($res_existe,0);	
 	          $id_usuario = trim($fila3['id_usuario']);
		   $q2="UPDATE ACCEDE SET  rdb ='".$institucion."', estado = 1  id_perfil = 15 WHERE id_usuario='".$id_usuario."' ";
		   $r2=@pg_Exec($connection,$q2);  */
			  
		 
		 }
		
		$j=$j+1;
	}
	
	
	pg_close($conn);
	pg_close($connection);
//	if($_PERFIL!=0){
	echo "<script> window.location = 'Claves.php' </script>";
	//}
?> 


