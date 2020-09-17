<?php require('../../../../../util/header.inc');?>
<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO; 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?

for ($i=0;$i<$contalum;$i++)
{
	/*if($_ID_BASE==3){
		$fecha = $fecha_retiro_obj[$i];
	}else{*/
		$fecha = fEs2En($fecha_retiro_obj[$i]);	
	//}
	$sql_update = "UPDATE promocion SET fecha_retiro = '".$fecha."' , observacion = '";
	$sql_update .= "RET ".fEs2En2($fecha_retiro_obj[$i])." ".$observacion_obj[$i]."' "; 
	$sql_update .= "WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno='".Trim($rut_alumno[$i])."'";
	$result_insert =@pg_Exec($conn,$sql_update);		
	/*if($_PERFIL==0){
		echo "<br>".$sql_update;
		echo "CORPORACION-->".$_ID_BASE;
	}*/
 
	
}
//if($_PERFIL==0) exit;
pg_close($conn);
echo "<script>window.location = 'promocion_pro.php'</script>";

?>
</body>
</html>
