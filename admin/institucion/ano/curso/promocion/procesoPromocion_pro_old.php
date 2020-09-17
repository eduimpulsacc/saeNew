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
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<?
for ($i=0;$i<$contalum;$i++)
{
	$sql_existe = "select count(*) as cantidad from promocion where rut_alumno = '".$rut_alumno[$i]."' and id_curso = ".$curso;
	$result_existe =@pg_Exec($conn,$sql_existe );
	$fila_existe = @pg_fetch_array($result_existe,0);	
	$cantidad = $fila_existe['cantidad'];
	$situacion = $situacion_final[$i];
	
	if ($cantidad==0){
		$sql_insert = "INSERT INTO promocion  (rdb,id_ano,id_curso,rut_alumno,promedio,asistencia,situacion_final, observacion) VALUES (" . $institucion . "," . $ano . "," . $curso . ",'" . Trim($rut_alumno[$i]) . "'," . intval(Trim($nota_final[$i]))  . "," . intval(Trim($asistencia[$i])) . "," . $situacion . ",'".$observacion[$i]."')";
		$result_insert =@pg_Exec($conn,$sql_insert);
	}else{
		$sql_update = "UPDATE promocion SET promedio=" . intval(Trim($nota_final[$i])) . ", asistencia=" . intval(Trim($asistencia[$i])) . ", situacion_final=" . $situacion . ", observacion = '".$observacion[$i]."' WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno='".Trim($rut_alumno[$i])."'";	
		$result_insert =@pg_Exec($conn,$sql_update);		
	}
}

echo "<script>window.location = 'Reprobados.php'</script>";
?>

</body>
</html>
