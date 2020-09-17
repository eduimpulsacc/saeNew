<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<? 

//base de datos antigua
$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");

//if($conn)echo "conecte final";

//base de datos coifinal
$conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//if($conn2)echo "conecte viña"; 
 
//exit;


//
$nro_ano = 2008;  
$rbd = 1598;  



//armo array 
$array_asistencia = array();

//id año zapallar
$sql_anio ="select * from ano_escolar where id_institucion= $rbd and nro_ano =$nro_ano;";
$rs_ano = pg_exec($conn,$sql_anio) or die ("error 1:".$sql_anio);
$fila_ano = pg_fetch_array($rs_ano,0);
$idano_acad = $fila_ano['id_ano'];
$array_asistencia['anio_didier'][0]=$idano_acad ;

//id_año coefinal

$sql_anio_coifinal ="select * from ano_escolar where id_institucion= $rbd and nro_ano =$nro_ano;";
$rs_ano_coifinal = pg_exec($conn2,$sql_anio_coifinal) or die ("error 1:".$sql_anio_coifinal);
$fila_ano_coifinal = pg_fetch_array($rs_ano_coifinal,0);
$idano_acad_coifinal = $fila_ano_coifinal['id_ano'];
$array_asistencia['anio_coi'][0]=$idano_acad_coifinal ;



//tabla asistencia didier
$sql_asis="select * from asistencia where ano=$idano_acad";
$rs_asis = pg_exec($conn,$sql_asis) or die ("error 1:".$sql_asis);
for($a=0;$a<pg_numrows($rs_asis);$a++){
	$fila_asis = pg_fetch_array($rs_asis,$a);
	
 $fil_curso = $fila_asis['id_curso'];	
	
	//cursos
 $qry_curso = "select grado_curso,letra_curso,ensenanza from curso where id_curso=$fil_curso";
$res_cur_didier = pg_exec($conn,$qry_curso);
$fil_cur_didier = pg_fetch_array($res_cur_didier,0);
$fil_grado = $fil_cur_didier['grado_curso'];
$fil_letra = $fil_cur_didier['letra_curso'];
$fil_ense = $fil_cur_didier['ensenanza'];

//curso coi
$cur_coi = "select id_curso from curso where id_ano=$idano_acad_coifinal and grado_curso=".$fil_grado." and letra_curso='".$fil_letra."' and ensenanza=".$fil_ense ;
$res_cur_coi = pg_exec($conn2,$cur_coi);
$fil_cur_coi = pg_fetch_array($res_cur_coi,0);
$fil_curso_coi = $fil_cur_coi['id_curso'];
	
	echo  $sql_ins = "insert into asistencia values(".$fila_asis['rut_alumno'].",$idano_acad_coifinal,$fil_curso_coi,'".$fila_asis['fecha']."');";
echo "<br>";
	$rs_ins = pg_exec($conn2,$sql_ins) or die ("error 1:".$sql_ins);	
	
	}


/*echo "<pre>";
var_dump($array_asistencia);
echo "</pre>";*/

?>
