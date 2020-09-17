<? 	include('../../../clases/class_bitacora.php');

$titulo=$_POST[txt_titulo];
$rut_emp=$_POST[txt_rut];
$institucion = $_POST[txt_institucion];

//$frmmodo="ingresar";


if($caso == "1"){//CREAR TITULO
	$ob_ingresar_titulo=new Bitacora();
	$ob_ingresar_titulo->rdb=$institucion;
	$ob_ingresar_titulo->rut_emp=$rut_emp;
	$ob_ingresar_titulo->titulo=$titulo;
	//$ob_ingresar_evento->fecha=$fecha;
	//$ob_ingresar_evento->evento=$evento;
	$result=$ob_ingresar_titulo->Ingresar_titulo($conn);
	
		echo "<script>parent.location='setea_bitacora.php?caso=1'</script>";

}

if($caso == "2"){//AGREGAR EVENTO

 $id			=$_POST[txt_id];	
 $nomb_titulo	=$_POST[txt_nomb_titulo];
 $fecha			=$_POST[txt_fecha_evento];
 $evento		=$_POST[textarea_evento];

			$FECHA2 = $fecha;
			$AA = substr ("$FECHA2;", 6, -1); 
			$mm = substr ("$FECHA2;", 3, -6);
			$dd = substr ("$FECHA2;", 0, -9);
			$dia2 = getdate(mktime(0,0,0,$mm,$dd,$AA));
			//$hoy=$dia2["wday"];
			$dia = $dia2["mday"];
			$fecha_mes = $dia2["mon"]."-".$dia;
			$FECHA3 = $fecha_mes."-".$dia2["year"];
			
	$ob_ingresar_evento=new Bitacora();
	$ob_ingresar_evento->id_titulo=$id;
	$ob_ingresar_evento->fecha=$FECHA3;
	$ob_ingresar_evento->evento=$evento;
	$result=$ob_ingresar_evento->Ingresar_evento($conn);
	
	echo "<script>parent.location='setea_bitacora.php?caso=3&id_titulo=$id&nomb_titulo=$nomb_titulo'</script>";

}

if($caso == "3"){//MODIFICAR EVENTO

$id			=$_POST[txt_id2];	
$nomb_titulo	=$_POST[txt_nomb_titulo2];
$fecha			=$_POST[txt_fecha_evento21];
$evento		=$_POST[textarea_evento2];

			$FECHA2 = $fecha;
			$AA = substr ("$FECHA2;", 6, -1); 
			$mm = substr ("$FECHA2;", 3, -6);
			$dd = substr ("$FECHA2;", 0, -9);
			$dia2 = getdate(mktime(0,0,0,$mm,$dd,$AA));
			//$hoy=$dia2["wday"];
			$dia = $dia2["mday"];
			$fecha_mes = $dia2["mon"]."-".$dia;
			$FECHA3 = $fecha_mes."-".$dia2["year"];
			
	$ob_ingresar_evento=new Bitacora();
	$ob_ingresar_evento->id_titulo2=$id;
	$ob_ingresar_evento->fecha=$FECHA3;
	$ob_ingresar_evento->evento2=$evento;
	$result=$ob_ingresar_evento->Modificar_evento($conn);
	
	echo "<script>parent.location='setea_bitacora.php?caso=3&id_titulo=$id&nomb_titulo=$nomb_titulo'</script>";

}


?>