<?   require "../../util/header.inc";
	//include('../clases/class_Reporte.php');


if(!isset($caso)){

//$caso=$_GET['caso'];

	$puntaje	=$_GET['puntaje'];
	$rut 		=$_GET['rut_alumno'];
	$ano		=$_GET['ano'];
	$cod_psu	=$_GET['cod_sub_psu'];
	$curso		=$_GET['curso'];
	$tipo		=$_GET['tipo'];
	
	 
	if($cod_psu != 0){
		if($cod_psu != 999999){
			$sql = "SELECT * FROM psu_notas_2009 WHERE rut_alumno=".$rut." AND cod_sub_psu=".$cod_psu;
			$resp = pg_exec($conn,$sql);
			$result = pg_result($resp,0);
			if(!$tipo==2){
				if(!$result == NULL){
					$sql_psu="UPDATE psu_notas_2009 SET puntaje=".$puntaje." WHERE rut_alumno=".$rut." AND cod_sub_psu=".$cod_psu;
				}else{
					$sql_psu="INSERT INTO psu_notas_2009 (cod_sub_psu,rut_alumno,puntaje,cod_ano) VALUES (".$cod_psu.",".$rut.",".$puntaje.",".$ano.")";
				}
		
			}else{
				if(!$result == NULL){
					$sql_psu="UPDATE psu_notas_2009 SET ponderacion=".$puntaje." WHERE rut_alumno=".$rut." AND cod_sub_psu=".$cod_psu;
				}else{
					$sql_psu="INSERT INTO psu_notas_2009 (cod_sub_psu,rut_alumno,cod_ano,ponderacion) VALUES (".$cod_psu.",".$rut.",".$ano.",".$puntaje.")";
				}
			}
		}else{
		
			 $sql="SELECT * FROM psu_promedios_2009 WHERE id_subsector=".$rut." AND id_ano=".$ano."AND curso=".$curso;
			$resp = pg_exec($conn,$sql);
			$result = pg_result($resp,0);
			if($result != NULL){
				 $sql_psu = "UPDATE psu_promedios_2009 SET puntaje=".$puntaje." WHERE id_subsector=".$rut." AND id_ano=".$ano."AND curso=".$curso;
			}else{
				 $sql_psu = "INSERT INTO psu_promedios_2009 (id_subsector,id_ano,puntaje,curso) VALUES (".$rut.",".$ano.",".$puntaje.",".$curso.")";
			}
		
		}
		$resp = pg_exec($conn,$sql_psu);
	}else{
		
		$sql = "SELECT * FROM psu_puntajes_2009 WHERE rut_alumno=".$rut." AND cod_ano=".$ano;
		$resp= pg_exec($conn,$sql);
		$result = pg_result($resp,0);
		if(!$result == NULL){
			$sql_psu="UPDATE psu_puntajes_2009 SET puntaje=".$puntaje." WHERE rut_alumno=".$rut." AND cod_ano=".$ano;
		}else{
			$sql_psu="INSERT INTO psu_puntajes_2009 (cod_ano,rut_alumno,puntaje) VALUES (".$ano.",".$rut.",".$puntaje.")";
		}
			$resp = pg_exec($conn,$sql_psu);
			
	}
			/*$sql_sql = "INSERT INTO sql (sql) VALUES ('".$sql_psu."')";
			$sql_sql2 ="INSERT INTO sql (sql) VALUES ('".$sql."')";
			$resp1 = pg_exec($conn,$sql_sql);
			$resp2 = pg_exec($conn,$sql_sql2);*/
}else{

	if(!$tipo==2){
		 $sql = "INSERT INTO psu_conf_2009 (cod_subsector,cod_ano) VALUES (".$cmb_subsector.",".$ano.")";
		
		$result=pg_exec($conn,$sql);
	//	exit;
	}else{
		$sql = "DELETE FROM psu_conf_2009 WHERE cod_subsector=".$cod_subsector." AND cod_ano=".$cod_ano;
		$resp = pg_exec($conn,$sql);
		$sql_delete_notas = "DELETE FROM psu_notas_2009 WHERE cod_sub_psu=".$cod_sub_psu;
		$resp_notas = pg_exec($conn,$sql_delete_notas);
	}
	
?><script language="javascript">window.location="prueba_simce_psu.php"</script>
<?

}








?>

