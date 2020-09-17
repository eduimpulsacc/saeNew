<script>
	function Refresca(){
		window.opener.location = "NotasParciales.php?c_curso=<?echo $curso_auxi?>&c_alumno=<?echo $alumno_auxi?>&c_periodos=<? echo $periodo?>";
		window.close();
	}
</script>
<?
	require('../../../../../util/header.inc');
	setlocale("LC_ALL","es_ES");
	$sql_borra = "delete from observa_informe where rut_alumno = ".$alumno;
	$result_borra =@pg_Exec($conn,$sql_borra);
	$sql_insert = "insert into observa_informe (id_periodo, rut_alumno, observacion) values (".$periodo.",'".$alumno."','".$observacion."')";
	$result_insert =@pg_Exec($conn,$sql_insert);	
	printf("<title>OBSERVACION</title>LA OBSERVACION FUE GRABADA EXITOSAMENTE</p>")?>
	<input type=button class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value=ACEPTAR onClick=Refresca()>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>

</body>
</html>
