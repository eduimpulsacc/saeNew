<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$agrupacion		=$_AGRUPACION;	//	1:CP	2:CA	3:WS	4:CP
	$agrupacion		=1;
	$ano			=$_ANO;
?>

<?php

$qry1="delete from evaluacion_kinder where rut_alumno=$rt_alumno and nivel_ev=1;insert into evaluacion_nin (ano,rut_alumno,nivel_ev,peso3,peso7,peso12,obs) values ($_ANO,$rt_alumno,'$pso3','$pso7','$pso12','$obs')";

$qry2="insert into evaluacion_detalle_nin values (ano,rut_alumno,nivel_ev,semestre,nro_eva,evaluacion) values ($_ANO,$rt_alumno,1,0,1,$r1);insert into evaluacion_detalle_nin values (ano,rut_alumno,nivel_ev,semestre,nro_eva,evaluacion) values ($_ANO,$rt_alumno,1,1,1,$r2);insert into evaluacion_detalle_nin values (ano,rut_alumno,nivel_ev,semestre,nro_eva,evaluacion) values ($_ANO,$rt_alumno,1,2,1,$r3);insert into evaluacion_detalle_nin values (ano,rut_alumno,nivel_ev,semestre,nro_eva,evaluacion) values ($_ANO,$rt_alumno,1,0,2,$rr1); insert into evaluacion_detalle_nin values (ano,rut_alumno,nivel_ev,semestre,nro_eva,evaluacion) values ($_ANO,$rt_alumno,1,1,2,$rr2); insert into evaluacion_detalle_nin values (ano,rut_alumno,nivel_ev,semestre,nro_eva,evaluacion) values ($_ANO,$rt_alumno,1,2,2,$rr3); insert into evaluacion_detalle_nin values (ano,rut_alumno,nivel_ev,semestre,nro_eva,evaluacion) values ($_ANO,$rt_alumno,1,0,3,rrr1);insert into evaluacion_detalle_nin values (ano,rut_alumno,nivel_ev,semestre,nro_eva,evaluacion) values ($_ANO,$rt_alumno,1,1,3,$rrr2);insert into evaluacion_detalle_nin values (ano,rut_alumno,nivel_ev,semestre,nro_eva,evaluacion) values ($_ANO,$rt_alumno,1,2,3,$rrr3);";

echo $qry1;
echo $qry2;
//$result =@pg_Exec($conn,$qry1);
//if (!$result)
//		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
//$result =@pg_Exec($conn,$qry2);
//if (!$result)
//		error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$qry2);

?>
