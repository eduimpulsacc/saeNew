<?	require('../../../util/header.inc');
	
	$institucion	=$_INSTIT;
	$_POSP           = 3;
	
//	print_r($_POST);


$sql ="SELECT id_base FROM base_dato WHERE dbname='".pg_dbname($conn)."'";
$rs_base = pg_exec($connection,$sql);
$id_base = pg_result($rs_base,0);

for($i=0;$i<$contador;$i++){
	$rut_emp = ${"rut".$i};
	$pw = ${"pw".$i};
	$sql="SELECT * FROM usuario WHERE nombre_usuario='".$rut_emp."'";
	 
	
	 
	$rs_existe = pg_exec($connection,$sql);
	 $id = pg_result($rs_existe,0);
	
	$pass=pg_result($rs_existe,2);
	
	if(trim($pass)==""){
		 $sql_up="update usuario set pw='".$pw."' where nombre_usuario='".$rut_emp."' ";
		$rs_up=pg_exec($connection,$sql_up)or die("fallo law"); 
		}
	
	
	
	if(pg_numrows($rs_existe)==0){
		 $sql = "INSERT INTO usuario (nombre_usuario,pw) VALUES ('".$rut_emp."','".$pw."')";
		$rs_usuario = pg_exec($connection,$sql);
		
		$sql ="SELECT LAST_INSERT_ID() FROM usuario";
		$rs_ultimo =pg_exec($connection,$sql);
		$id = pg_result($rs_ultimo,0);
		
		$sql ="INSERT INTO accede (id_usuario,id_perfil,rdb,id_sistema,id_base,estado) VALUES (".$id.",17,".$institucion.",1,".$id_base.",1)";
		$rs_accede = pg_exec($connection,$sql);
		
			
	}else if($rs_existe>0){
		$sql ="INSERT INTO accede (id_usuario,id_perfil,rdb,id_sistema,id_base,estado) VALUES (".$id.",17,".$institucion.",1,".$id_base.",1)";
		$rs_accede = pg_exec($connection,$sql);
		/*$sql_up="update accede set estado=1 where id_usuario = $id";
		$rs_accede_up=pg_exec($connection,$sql_up);
		*/
	}else{
		
	}
	
}





/*exit;
return;

 $sql = "SELECT * FROM trabaja WHERE trabaja.rdb = ".$institucion.";";
 $reg =@pg_Exec($conn,$sql);
 
 
 for($i=0;$i >= pg_num_rows($reg); ){
	 
 $fila =  pg_fetch_array($reg);
	 
	 }
 

 $sql = "SELECT * FROM usuario WHERE nombre_usuario = '6651158' ";
 $reg =@pg_Exec($connection,$sql);
 

	
	while ($arr_sinp = pg_fetch_array($res_sinp)) {
		
		if (isset($_POST[$arr_sinp['rut_emp']])) {
			
			$rut_emp = $arr_sinp['rut_emp'];
			
			if ($_POST[$rut_emp] != NULL && trim($_POST[$rut_emp]) != "") {
				
				$pass = $_POST[$rut_emp];
				
				$sql_usr1 = "SELECT id_usuario FROM usuario WHERE nombre_usuario = ".$rut_emp;
				$res_usr1 = @pg_Exec($conn,$sql_usr1);
				$con1 = pg_num_rows($res_usr1);
				
				//echo $sql_usr1."<br>";
				
				if ($con1 > 0) {
					
					$arr_usr1 = pg_fetch_array($res_usr1);
					$next_id = $arr_usr1['id_usuario'];
					
				} else {
								
					$sql_usr2 = "SELECT MAX(id_usuario) AS id_usuario FROM usuario";
					
					//echo $sql_usr2."<br>";
					
					$res_usr2 = @pg_Exec($conn,$sql_usr2);
					$arr_usr2 = pg_fetch_array($res_usr2);
					$next_id = $arr_usr2['id_usuario']+1;
					
					
					$sql_usr3 = "INSERT INTO usuario (id_usuario, nombre_usuario, pw) VALUES (".$next_id.", '".$rut_emp."', '".$pass."')";
					
					//echo $sql_usr3."<br>";
					$res_usr3 = @pg_Exec($conn,$sql_usr3);
					
				}
				
				$sql_genera = "INSERT INTO accede (id_usuario, id_perfil, rdb, estado) VALUES (".$next_id.", 17, ".$institucion.", 1)";
				//echo $sql_genera."<br><br>";
				$res_genera = @pg_Exec($conn,$sql_genera);
			}
		}
	}
	*/
	// if($institucion==11209){
		//  echo ""; }else{
	echo " <script>document.location.href='claves.php3'</script>"; 
	// }
	
?>