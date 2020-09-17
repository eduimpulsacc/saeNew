<? require('../../../util/header.inc');
	
	
	$institucion	=$_GET['rdb'];
	"<br>".$servidor	=	$_GET['servidor'];
	"<br>".$serializado	=	$_GET['serializado'];
	"<br>".$contador	=	$_GET['contador'];

	"<br>".$tmp = stripslashes($serializado); 
	"<br>".$datos = unserialize($tmp);

	/*echo "<PRE>";
	print_r($datos);
	echo "</PRE>";*/

	for($i=0;$i<$contador;$i++){
		for($j=0;$j<3;$j++){
		if($j==0){
		 echo $id_origen=$datos[$i][$j];
		  }
		if($j==1){
		 echo $rut_emp=$datos[$i][$j];
		  }
		if($j==2){
		 echo $pass=$datos[$i][$j];
		  }
		}
	//}
	
	
	
	
	
	//$sql_sinp = "SELECT trabaja.rut_emp FROM trabaja WHERE trabaja.rdb = ".$institucion." AND 'trabaja.rut_emp' NOT IN (SELECT nombre_usuario FROM usuario WHERE id_usuario IN (SELECT id_usuario FROM accede WHERE rdb = ".$institucion."))";
	//echo $sql_sinp."<br><br>";
	//$res_sinp =@pg_Exec($conn,$sql_sinp);
	
/*	$sql_sinp1="select rut_emp from trabaja where rdb=".$institucion."";
	$res_sinp1 =@pg_Exec($conn,$sql_sinp1);
	for($i=0;$i<pg_numrows($res_sinp1);$i++){
	$empleados = pg_fetch_array($res_sinp1,$i);
	if($_PERFIL==0){
	echo "<br>".$empleados['rut_emp'];
	}*/
	
	echo $sql_sinp2 = "SELECT * from usuario where nombre_usuario='".$rut_emp."'";
	$res_sinp2 =@pg_Exec($conn2,$sql_sinp2);
	"pg_numrows".$cuenta = pg_numrows($res_sinp2);


	if($cuenta==0){
		echo "<br>".$sql_sinp = "SELECT * from empleado where rut_emp='".$rut_emp."'";
		$res_sinp =@pg_Exec($conn2,$sql_sinp);
		}	

			
	//}
	

	
	
/*	
	while ($arr_sinp = pg_fetch_array($res_sinp)) {
		if (isset($_POST[$arr_sinp['rut_emp']])) {
			$rut_emp = $arr_sinp['rut_emp'];
			if ($_POST[$rut_emp] != NULL && trim($_POST[$rut_emp]) != "") {
				$pass = $_POST[$rut_emp];
				
				"<br>".$sql_usr1 = "SELECT id_usuario FROM usuario WHERE nombre_usuario = ".$rut_emp;
				$res_usr1 = @pg_Exec($conn,$sql_usr1);
				$con1 = pg_num_rows($res_usr1);
				
				//echo $sql_usr1."<br>";
				
				if ($con1 > 0) {
					$arr_usr1 = pg_fetch_array($res_usr1);
					$next_id = $arr_usr1['id_usuario'];
				} else {
								
					"<br>".$sql_usr2 = "SELECT MAX(id_usuario) AS id_usuario FROM usuario";
					
					//echo $sql_usr2."<br>";
					
					$res_usr2 = @pg_Exec($conn,$sql_usr2);
					$arr_usr2 = pg_fetch_array($res_usr2);
					$next_id = $arr_usr2['id_usuario']+1;
					
					
					"<br>".$sql_usr3 = "INSERT INTO usuario (id_usuario, nombre_usuario, pw) VALUES (".$next_id.", '".$rut_emp."', '".$pass."')";
					
					//echo $sql_usr3."<br>";
					//$res_usr3 = @pg_Exec($conn,$sql_usr3);
					
				}
				
				"<br>".$sql_genera = "INSERT INTO accede (id_usuario, id_perfil, rdb, estado) VALUES (".$next_id.", 17, ".$institucion.", 1)";
				//echo $sql_genera."<br><br>";
				//$res_genera = @pg_Exec($conn,$sql_genera);
			}
		}
	}*/
	
	
	
	
	
	
	echo "<br>".$sql_usr1 = "SELECT id_usuario FROM usuario WHERE nombre_usuario = ".$rut_emp;
				$res_usr1 = @pg_Exec($conn2,$sql_usr1);
				$con1 = pg_num_rows($res_usr1);
				
				//echo $sql_usr1."<br>";
				
				if ($con1 > 0) {
					$arr_usr1 = pg_fetch_array($res_usr1);
					$next_id = $arr_usr1['id_usuario'];
				} else {
								
					echo "<br>".$sql_usr2 = "SELECT MAX(id_usuario) AS id_usuario FROM usuario";
					
					//echo $sql_usr2."<br>";
					
					$res_usr2 = @pg_Exec($conn2,$sql_usr2);
					$arr_usr2 = pg_fetch_array($res_usr2);
					$next_id = $arr_usr2['id_usuario']+1;
					
					
					echo "<br>".$sql_usr3 = "INSERT INTO usuario (id_usuario, id_usuario_origen, nombre_usuario, pw) VALUES (".$next_id.",".$id_origen.", '".$rut_emp."', '".$pass."')";
					
					//echo $sql_usr3."<br>";
					$res_usr3 = @pg_Exec($conn2,$sql_usr3);
					
				}
				
				echo "<br>".$sql_genera = "INSERT INTO accede (id_usuario, id_perfil, rdb, estado) VALUES (".$id_origen.", 17, ".$institucion.", 1)";
				//echo $sql_genera."<br><br>";
				$res_genera = @pg_Exec($conn2,$sql_genera);
	
	
	
	
	
	}
	
	
	echo " <script>document.location.href='http://www.cmds.cl/admin/institucion/empleado/listarEmpleado.php3'</script>";
	
	
?>