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
		$sql_update = "UPDATE promocion SET tipo_reprova = " . $tipo_reproba_obj[$i] . ", observacion = '" . $observacion_obj[$i] ."' WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno='".Trim($rut_alumno[$i])."'";	
		$result_insert =@pg_Exec($conn,$sql_update);		
}
pg_close($conn);
echo "<script>window.location = 'FechaObserva.php'</script>";
?>

</body>
</html>
