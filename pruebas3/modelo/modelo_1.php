<? 
// llamado a la conexión
require("../conn/conn.php");

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

function ano_escolar_por_institucion($inst,$conn){
    $sql = "select id_ano from ano_escolar where id_institucion = '$inst' and nro_ano = '2010'";
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


   

?>