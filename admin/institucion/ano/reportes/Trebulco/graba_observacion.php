<script>
	function Refresca(){
		window.opener.location = "NotasParciales_Ingles.php?c_curso=<?echo $curso_auxi?>&c_alumno=<?echo $alumno_auxi?>&c_periodos=<? echo $periodo?>";
		window.close();
	}
</script>
<?
	require('../../../../../util/header.inc');
//	setlocale("LC_ALL","es_ES");
	$sql_borra = "delete from observacion_evaluacion where rut_alumno = ".$alumno." AND id_periodo=".$periodo." ";
	$result_borra =@pg_Exec($conn,$sql_borra);
	$sql_insert = "insert into observacion_evaluacion (rut_alumno, id_periodo, id_curso, glosa) values ('".$alumno."', ".$periodo.", ".$curso.", '".$observacion."')";
	$result_insert =@pg_Exec($conn,$sql_insert);	
	if(pg_numrows($result_insert)!=0){
		printf("<title>OBSERVACION</title>LA OBSERVACION NO SE INGRESO</p>");	
	}else{
		printf("<title>OBSERVACION</title>LA OBSERVACION FUE GRABADA EXITOSAMENTE</p>");
	}
	?>
	<input type=button class="botonXX"  value=ACEPTAR onClick=Refresca()>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>

</body>
</html>
