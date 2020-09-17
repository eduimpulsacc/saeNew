<?
	require('../../../../../util/header.inc');
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$_POSP          =5;
	$_bot           =5;
	$fecha =$_GET['fecha'];
	
	$sql ="SELECT * FROM inasistencia_asignatura WHERE ano=".$ano." AND id_curso=".$curso." AND fecha='".$fecha."'";
	$rs_asistencia = @pg_exec($conn,$sql);
	
	for($i=0; $i<@pg_numrows($rs_asistencia); $i++){
		$fila = @pg_fetch_array($rs_asistencia,$i);
		
		$sql = "INSERT INTO asistencia (rut_alumno,ano,id_curso,fecha) VALUES (".$fila['rut_alumno'].",".$fila['ano'].",".$fila['id_curso'].",'".$fila['fecha']."')";
		$rs_ingresa = @pg_exec($conn,$sql);
		
	}
	
	pg_close($conn); 
	
	echo "<script>window.location='inasistencia.php'</script>";
?>