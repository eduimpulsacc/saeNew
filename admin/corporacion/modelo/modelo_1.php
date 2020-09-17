<? 
// llamado a la conexión
require("../../../util/header.php");

// funciones de consulta a la base de datos

function instituciones_por_corporacion($corp,$conn){
   $sql = "select nombre_instit, rdb from institucion where rdb in (select rdb from corp_instit where num_corp = '$corp')";
   $res = pg_exec($conn,$sql);
   $num = pg_numrows($res);
   $instituciones = array();
   for ($i=0; $i < $num; $i++){
       $fila = pg_fetch_array($res,$i);
       $instituciones[] = $fila;
   }
   return $instituciones;	   

}

function ano_escolar_por_institucion($inst,$ano,$conn){
    $sql = "select id_ano from ano_escolar where id_institucion = '$inst' and nro_ano = '$ano'";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$ano_escolar = $fila['id_ano'];
	
	return $ano_escolar;

}

function matricula_institucion_mes($id_ano,$mes,$conn){
    if ($mes==2){
	    $fecha_ini = '2010-02-01';
		$fecha_fin = '2010-02-28';
	}
	
	if ($mes==3){
	    $fecha_ini = '2010-03-01';
		$fecha_fin = '2010-03-31';
	}
	
	if ($mes==4){
	    $fecha_ini = '2010-04-01';
		$fecha_fin = '2010-04-30';
	}
	
	if ($mes==5){
	    $fecha_ini = '2010-05-01';
		$fecha_fin = '2010-05-30';
	}
	
	if ($mes==6){
	    $fecha_ini = '2010-06-01';
		$fecha_fin = '2010-06-30';
	}
	
	if ($mes==7){
	    $fecha_ini = '2010-07-01';
		$fecha_fin = '2010-07-30';
	}
	
	if ($mes==8){
	    $fecha_ini = '2010-08-01';
		$fecha_fin = '2010-08-30';
	}
	
	if ($mes==9){
	    $fecha_ini = '2010-09-01';
		$fecha_fin = '2010-09-30';
	}
	
	if ($mes==10){
	    $fecha_ini = '2010-10-01';
		$fecha_fin = '2010-10-30';
	}
	
	if ($mes==11){
	    $fecha_ini = '2010-11-01';
		$fecha_fin = '2010-11-30';
	}
	
	if ($mes==12){
	    $fecha_ini = '2010-12-01';
		$fecha_fin = '2010-12-30';
	}
    
   //$sql = "select count(id_ano) as cantidad from matricula where id_ano = '$id_ano' and num_mes='$mes' and bool_ar = '0'";
	
	$sql = "select count(id_ano) as cantidad from matricula where id_ano = '$id_ano' and date_part('month', fecha)=$mes  and bool_ar = '0'";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	
	return $cantidad;

}
function matricula_institucion_mes_acumulado($id_ano,$mes,$conn,$ano){
	
	if ($mes==2){
	    $fecha_ini = $ano.'-02-01';
		$fecha_fin = $ano.'-02-28';
	}
	
	if ($mes==3){
	    $fecha_ini = $ano.'-03-01';
		$fecha_fin = $ano.'-03-28';
	}
	
	if ($mes==4){
	    $fecha_ini = $ano.'-04-01';
		$fecha_fin = $ano.'-04-30';
	}
	
	if ($mes==5){
	    $fecha_ini = $ano.'-05-01';
		$fecha_fin = $ano.'-05-30';
	}
	
	if ($mes==6){
	    $fecha_ini = $ano.'-06-01';
		$fecha_fin = $ano.'-06-30';
	}
	
	if ($mes==7){
	    $fecha_ini = $ano.'-07-01';
		$fecha_fin = $ano.'-07-30';
	}
	
	if ($mes==8){
	    $fecha_ini = $ano.'-08-01';
		$fecha_fin = $ano.'-08-30';
	}
	
	if ($mes==9){
	    $fecha_ini = $ano.'-09-01';
		$fecha_fin = $ano.'-09-30';
	}
	
	if ($mes==10){
	    $fecha_ini = $ano.'-10-01';
		$fecha_fin = $ano.'-10-30';
	}
	
	if ($mes==11){
	    $fecha_ini = $ano.'-11-01';
		$fecha_fin = $ano.'-11-30';
	}
	
	if ($mes==12){
	    $fecha_ini = $ano.'-12-01';
		$fecha_fin = $ano.'-12-30';
	}
	$sql = "select count(id_ano) as cantidad from matricula where id_ano = '$id_ano' AND fecha<='$fecha_fin'  and bool_ar = '0'";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	
	return $cantidad;

}

function matricula_institucion_mes_acumulado_niv($id_ano,$mes,$nivel,$conn){
	
	if ($mes==2){
	    $fecha_ini = '2010-02-01';
		$fecha_fin = '2010-02-28';
	}
	
	if ($mes==3){
	    $fecha_ini = '2010-03-01';
		$fecha_fin = '2010-03-31';
	}
	
	if ($mes==4){
	    $fecha_ini = '2010-04-01';
		$fecha_fin = '2010-04-30';
	}
	
	if ($mes==5){
	    $fecha_ini = '2010-05-01';
		$fecha_fin = '2010-05-30';
	}
	
	if ($mes==6){
	    $fecha_ini = '2010-06-01';
		$fecha_fin = '2010-06-30';
	}
	
	if ($mes==7){
	    $fecha_ini = '2010-07-01';
		$fecha_fin = '2010-07-30';
	}
	
	if ($mes==8){
	    $fecha_ini = '2010-08-01';
		$fecha_fin = '2010-08-30';
	}
	
	if ($mes==9){
	    $fecha_ini = '2010-09-01';
		$fecha_fin = '2010-09-30';
	}
	
	if ($mes==10){
	    $fecha_ini = '2010-10-01';
		$fecha_fin = '2010-10-30';
	}
	
	if ($mes==11){
	    $fecha_ini = '2010-11-01';
		$fecha_fin = '2010-11-30';
	}
	
	if ($mes==12){
	    $fecha_ini = '2010-12-01';
		$fecha_fin = '2010-12-30';
	}
	 $sql = "select count(*) as cantidad from matricula where id_ano = '$id_ano' AND fecha<='$fecha_fin'  and bool_ar = '0' AND id_curso IN (SELECT id_curso FROM curso WHERE id_nivel=$nivel AND id_ano=$id_ano)";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	
	return $cantidad;

}

function alumnos_retirados($id_ano,$conn){
	
	$sql = "select count(id_ano) as cantidad from matricula where id_ano = '$id_ano' and bool_ar = '1'";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	
	return $cantidad;

}
function alumnos_sexo($id_ano,$sexo,$conn){
	
	$sql = "select count(id_ano) as cantidad from matricula INNER JOIN alumno ON matricula.rut_alumno=alumno.rut_alumno where id_ano = '$id_ano' and alumno.sexo='$sexo'";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	
	return $cantidad;

}   
function alumnos_indigena($id_ano,$conn){
	
	$sql = "SELECT count(id_ano) as cantidad FROM matricula WHERE id_ano = '$id_ano' and bool_aoi='1'";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	
	return $cantidad;

}   
function matricula_mes_abril($id_ano,$conn){

	$sql = "select count(id_ano) as cantidad from matricula where id_ano = '$id_ano' and date_part('month', fecha)>'3'  and bool_ar = '0'";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	
	return $cantidad;

}
function alumnos_promovidos($id_ano,$conn){

	  $sql = "SELECT count(*) as cantidad FROM promocion WHERE id_ano='$id_ano' AND situacion_final=1";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	
	return $cantidad;

}
function alumnos_reprobados($id_ano,$conn){

	$sql = "SELECT count(*) as cantidad FROM promocion WHERE id_ano='$id_ano' AND situacion_final=2";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	
	return $cantidad;

}

function alumnos_promovidos_nivel($id_ano,$nivel,$conn){

	 $sql = "SELECT count(*) as cantidad FROM promocion WHERE id_ano=$id_ano AND situacion_final=1 AND id_curso IN (SELECT id_curso FROM curso WHERE id_nivel=$nivel AND id_ano=$id_ano)";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	
	return $cantidad;

}

function alumnos_reprobados_nivel($id_ano,$nivel,$conn){

	$sql = "SELECT count(*) as cantidad FROM promocion WHERE id_ano=$id_ano AND situacion_final=2 AND id_curso IN (SELECT id_curso FROM curso WHERE id_nivel=$nivel AND id_ano=$id_ano)";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	
	return $cantidad;

}


?>