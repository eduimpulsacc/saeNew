<?php 	require('../../../../../util/header.inc');

$institucion= $_INSTIT;
$curso		= $_CURSO;
$ano		= $_ANO;

//----------------------------- TABLA DE ASISTENNCIA POR CURSO --------------------

$sql = "SELECT ensenanza FROM curso WHERE id_curso = ".$curso;
$Rs_Ense = @pg_exec($conn,$sql);
$Ensenanza = pg_result($Rs_Ense,0);

$sql = "";
$sql = "SELECT count(*) as cantidad, fecha FROM asistencia WHERE ano=".$ano." AND id_curso=".$curso." GROUP BY fecha";
$Rs_Asistencia = @pg_exec($conn,$sql);
for($i=0;$i<@pg_numrows($Rs_Asistencia);$i++){
	$fils_Asis = @pg_fetch_array($Rs_Asistencia,$i);
		$sql = "";
		$sql = "SELECT * FROM asistencia_curso WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND fecha=to_date('".$fils_Asis['fecha']."','YYYY MM DD')";
		$Rs_AsistPrevio= @pg_exec($conn,$sql);
		if(@pg_numrows($Rs_AsistPrevio)==0){
			$sql = "";
			$sql = "INSERT INTO asistencia_curso VALUES (".$institucion.",".$ano.",".$curso.",NULL,to_date('".$fils_Asis['fecha']."','YYYY MM DD'),".$fils_Asis['cantidad'].",".$Ensenanza.")";
			$Rs_AsisCurso = @pg_exec($conn,$sql);
		}else{
			$sql="";
			$sql = "UPDATE asistencia_curso SET cantidad=".$fils_Asis['cantidad']." WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND fecha=to_date('".$fils_Asis['fecha']."','YYYY MM DD')";
			$Rs_AsisCurso = @pg_exec($conn,$sql);
		}
}
//--------------------------- TABLA DE ASISTENCIA POR AÑO --------------------------

$sql="";
$sql="SELECT sum(cantidad) AS cantidad, fecha FROM asistencia_curso WHERE rdb=".$institucion." AND id_ano=".$ano." GROUP BY fecha";
$Rs_AsistAno = @pg_exec($conn,$sql);

for($i=0;$i<@pg_numrows($Rs_AsistAno);$i++){
	$fils_Ano = @pg_fetch_array($Rs_AsistAno,$i);
	$sql="";
	$sql = "SELECT * FROM asistencia_ano WHERE rdb=".$institucion." AND id_ano=".$ano." AND fecha=to_date('".$fils_AsisAno['fecha']."','YYYY MM DD')";
	$Rs_AsisPrevioAno = @pg_exec($conn,$sql);
	if(@pg_numrows($Rs_AsisPrevioAno)==0){
		$sql = "";
		$sql = "INSERT INTO asistencia_ano VALUES (".$institucion.",".$ano.",NULL,to_date('".$fils_Ano['fecha']."','YYYY MM DD'),".$fils_Ano['cantidad'].",".$Ensenanza.")";
		$Rs_AsisAno = @pg_exec($conn,$sql);
	}else{
		$sql = "";
		$sql = "UPDATE asistencia_ano SET cantidad=".$fils_Ano['cantidad']." WHERE rdb=".$institucion." AND id_ano=".$ano." AND fecha=to_date('".$fils_Ano['fecha']."','YYYY MM DD')";
		$Rs_AsisAno = @pg_exec($conn,$sql);
	}
}
?>
<script>window.location ="seteaAsistencia.php3?caso=2"</script>
