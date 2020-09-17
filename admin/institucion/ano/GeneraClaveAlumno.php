<?php 

require('../../../util/header.inc');
	
	$institucion 	= $_INSTIT;
	$ano			= $_ANO;
	echo $_ID_BASE;
	//______________________________ SELECCIONA BD DE DONDE DEBE GUARDAR (COORPORACIONES)__________________________________//
	
	/*$sql_corp = "select num_corp from corp_instit where rdb = '".$_INSTIT."'";
	$res_corp = @pg_Exec($conn, $sql_corp);
	$num_corp = @pg_numrows($res_corp);*/
	
	/*if ($num_corp>0){   // pertenece a una corporación.... hay que saber a cual...
	     $fil_corp = @pg_fetch_array($res_corp,0);
		 $corporacion = $fil_corp['num_corp'];
	
	if ($corporacion=="1" or $corporacion=="4" or $corporacion=="12"){*/
		        
				/// pertenece a la corporacion de VIÑA o IQUIQUE
				// la conexión es...
		/*		 $conn3=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Viña.");*/
				 
		 /*}else if($corporacion=="13"){*/
		 		
				
			 	//$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");	
		/*		$conn3=pg_connect("dbname=coi_antofagasta host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Antofagasta.");	
				if (!$conn3) {
					 error('<b>ERROR:</b>No se puede conectar a la base de datos Antofagasta.');
					 exit;
					 }				
		 }else{
		 */
		       /// es de otra corporación... debe conectar a la base de datos nueva coi_corporacion
/*			   	 $conn3=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Corporacion.");	
		 }
		 
	
	}	 	*/	
	//______________________________________________________________________________________________________________//
	
	
	
	$sql_alumno = "SELECT rut_alumno from matricula where rdb=".$institucion." AND id_ano=".$ano."" ;
	$res_alumno = @pg_Exec($conn,$sql_alumno);
	
	$total_alum = @pg_numrows($res_alumno);
	
	$sql_id_max_usuario = "SELECT max(id_usuario) as id_max FROM accede";
	$res_id_max_usuario = @pg_Exec($connection,$sql_id_max_usuario);
	
	$fila2 = @pg_fetch_array($res_id_max_usuario,0);	
 echo	"-->".$max_id_usuario = trim($fila2['id_max']);

	$j=0;
	
	for($i=($max_id_usuario+1);$i<=($max_id_usuario+$total_alum);$i++){
		
		$fila1 = @pg_fetch_array($res_alumno,$j);	
		$password = substr("".$fila1['rut_alumno']."",0,5);			
		
		 $sql_existe = "SELECT id_usuario FROM usuario WHERE nombre_usuario='".trim($fila1['rut_alumno'])."'";
		$res_existe = @pg_Exec($connection,$sql_existe);
		
		if(pg_num_rows($res_existe)==0){
			
			$insert_usuario = "INSERT INTO usuario (id_usuario, nombre_usuario, pw) VALUES (".$i.",'".$fila1['rut_alumno']."','".$password."')";
			$Rs_usuario = @pg_exec($connection,$insert_usuario);
			
			$insert_accede = "INSERT INTO accede (id_usuario,id_perfil, rdb,id_sistema,id_base, estado) VALUES (".$i.",16,".$institucion.",1,".$_ID_BASE.",1)";
			$Rs_accede = @pg_exec($connection,$insert_accede);

		}
		else{//si existe actualizo accede solamente con el rbd actual jijijiji
		
		      $fila3 = @pg_fetch_array($res_existe,0);	
 	          $id_usuario = trim($fila3['id_usuario']);
              
			 
			  if($id_usuario){
			  echo $sql_in="INSERT INTO accede (id_usuario,id_perfil, rdb,id_sistema,id_base, estado) VALUES (".$id_usuario.",16,".$institucion.",1,".$_ID_BASE.",1)";
				  $rz=@pg_Exec($connection,$sql_in);
				  }
			  
			  
			  $q2="UPDATE ACCEDE SET  id_perfil = 16, rdb ='".$institucion."',id_sistema=1,id_base=".$_ID_BASE.",estado=1
			      WHERE id_usuario='".$id_usuario."'";
			 
			 
			 //rdb ='".$institucion."', estado = 1 , id_perfil = 16 WHERE id_usuario='".$id_usuario."' ";
		      $r2=@pg_Exec($connection,$q2);
		   }
		$j=$j+1;
	}
	
	pg_close($conn);
	pg_close($connection);
	
	//if($_PERFIL!=0){
	echo "<script>window.location = 'Claves.php'</script>";
	//}else{
	//echo"";	
	//}
?> 