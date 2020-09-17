<? 
// llamado a la conexión
require("../../../util/header.php");

// funciones de consulta a la base de datos

function instituciones_por_corporacion($corp,$conn){

  $sql = "select nombre_instit, rdb  from 
   institucion where rdb in (select rdb from corp_instit 
inner join nacional_corp on nacional_corp.num_corp = corp_instit.num_corp
inner join nacional on nacional.id_nacional = nacional_corp.id_nacional
where nacional.id_nacional= '$corp') ORDER BY institucion.rdb ASC";

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

function matricula_institucion_mes($id_ano,$mes,$conn,$ano){
    if ($mes==2){
	    $fecha_ini = '$ano-02-01';
		$fecha_fin = '$ano-02-28';
	}
	
	if ($mes==3){
	    $fecha_ini = '$ano-03-01';
		$fecha_fin = '$ano-03-31';
	}
	
	if ($mes==4){
	    $fecha_ini = '$ano-04-01';
		$fecha_fin = '$ano-04-30';
	}
	
	if ($mes==5){
	    $fecha_ini = '$ano-05-01';
		$fecha_fin = '$ano-05-30';
	}
	
	if ($mes==6){
	    $fecha_ini = '$ano-06-01';
		$fecha_fin = '$ano-06-30';
	}
	
	if ($mes==7){
	    $fecha_ini = '$ano-07-01';
		$fecha_fin = '$ano-07-30';
	}
	
	if ($mes==8){
	    $fecha_ini = '$ano-08-01';
		$fecha_fin = '$ano-08-30';
	}
	
	if ($mes==9){
	    $fecha_ini = '$ano-09-01';
		$fecha_fin = '$ano-09-30';
	}
	
	if ($mes==10){
	    $fecha_ini = '$ano-10-01';
		$fecha_fin = '$ano-10-30';
	}
	
	if ($mes==11){
	    $fecha_ini = '$ano-11-01';
		$fecha_fin = '$ano-11-30';
	}
	
	if ($mes==12){
	    $fecha_ini = '$ano-12-01';
		$fecha_fin = '$ano-12-30';
	}
    
   //$sql = "select count(id_ano) as cantidad from matricula where id_ano = '$id_ano' and num_mes='$mes' and bool_ar = '0'";
	
	$sql = "select count(id_ano) as cantidad from matricula where id_ano = '$id_ano' and date_part('month', fecha)=$mes  and bool_ar = '0'";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	
	return $cantidad;

}
function matricula_institucion_mes_acumulado($id_ano,$mes,$conn,$ano){
	$nro_ano=$ano;
	
	if ($mes==1){
	    $fecha_ini = ''.$nro_ano.'-01-01';
		$fecha_fin = ''.$nro_ano.'-01-28';
	}
	
	if ($mes==2){
	    $fecha_ini = ''.$nro_ano.'-02-01';
		$fecha_fin = ''.$nro_ano.'-02-28';
	}
	
	if ($mes==3){
	    $fecha_ini = ''.$nro_ano.'-03-01';
		$fecha_fin = ''.$nro_ano.'-03-31';
	}
	
	if ($mes==4){
	    $fecha_ini = ''.$nro_ano.'-04-01';
		$fecha_fin = ''.$nro_ano.'-04-30';
	}
	
	if ($mes==5){
	    $fecha_ini = ''.$nro_ano.'-05-01';
		$fecha_fin = ''.$nro_ano.'-05-30';
	}
	
	if ($mes==6){
	    $fecha_ini = ''.$nro_ano.'-06-01';
		$fecha_fin = ''.$nro_ano.'-06-30';
	}
	
	if ($mes==7){
	    $fecha_ini = ''.$nro_ano.'-07-01';
		$fecha_fin = ''.$nro_ano.'-07-30';
	}
	
	if ($mes==8){
	    $fecha_ini = ''.$nro_ano.'-08-01';
		$fecha_fin = ''.$nro_ano.'-08-30';
	}
	
	if ($mes==9){
	    $fecha_ini = ''.$nro_ano.'-09-01';
		$fecha_fin = ''.$nro_ano.'-09-30';
	}
	
	if ($mes==10){
	    $fecha_ini = ''.$nro_ano.'-10-01';
		$fecha_fin = ''.$nro_ano.'-10-30';
	}
	
	if ($mes==11){
	    $fecha_ini = ''.$nro_ano.'-11-01';
		$fecha_fin = ''.$nro_ano.'-11-30';
	}
	
	if ($mes==12){
	    $fecha_ini = ''.$nro_ano.'-12-01';
		$fecha_fin = ''.$nro_ano.'-12-30';
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

function alumnos_reprobados_ensenanza($id_ano,$conn,$tipo){

	$sql = "SELECT count(*) as cantidad FROM promocion INNER JOIN curso ON promocion.id_curso=curso.id_curso WHERE curso.id_ano='$id_ano' AND situacion_final=2 and ensenanza='$tipo'";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	
	
	$sql="SELECT count(*) FROM matricula WHERE id_ano='$id_ano' AND bool_ar=0";
	$rs_matricula = pg_exec($conn,$sql);
	$matricula = pg_result($rs_matricula,0);
	
	$porcentaje = substr((($cantidad * 100) / $matricula),0,4); 
	return $porcentaje;

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

function alumnos_adventistas($id_ano,$conn){
	
	$sql = "SELECT count(religion) as cantidad FROM matricula m
inner join alumno a on a.rut_alumno=m.rut_alumno
WHERE m.id_ano = $id_ano and a.religion ILIKE 'adventista' ";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	return $cantidad;

}   

function matricula_total($id_ano,$conn){
	
	$sql = "SELECT count(*) as cantidad FROM matricula m
inner join alumno a on a.rut_alumno=m.rut_alumno
WHERE m.id_ano = $id_ano";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	return $cantidad;

}
function matricula_ensenanza($id_ano,$conn,$tipo){
	$sql="SELECT count(*) FROM matricula m INNER JOIN curso c ON m.id_curso=c.id_curso AND m.id_ano=$id_ano WHERE ensenanza=$tipo";
	$Rs_matricula = pg_exec($conn,$sql);
	$cantidad= pg_result($Rs_matricula,0);
	
	return $cantidad;
}

function alumnos_sep($id_ano,$conn){
	
	 $sql = "SELECT count(m.ben_sep) as cantidad 
FROM matricula m inner join 
alumno a on a.rut_alumno=m.rut_alumno
 WHERE m.id_ano = $id_ano and m.ben_sep=1 ";
	$res = pg_exec($conn, $sql);
	$fila = pg_fetch_array($res,0);
	$cantidad = $fila['cantidad'];
	return $cantidad;

}   


function DocentesInstitucion($rdb,$conn){
	$sql ="SELECT count(*) FROM trabaja t WHERE rdb='$rdb' AND cargo=5";
	$rs_cantidad = pg_exec($conn,$sql);
	$cantidad= pg_result($rs_cantidad,0);
	
	return $cantidad;
		
}

?>