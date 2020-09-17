<?php 
require('../../../../../../util/header.inc');

$ano=$_ANO;

//nro de año escolar
$qry="SELECT nro_ano FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
$result =@pg_Exec($conn,$qry);
$an= pg_result($result,0);

//buscar condifuracion de ramo
$qry_ramo="select porc_nota_pu, truncado_pu from ramo where id_ramo=$ramo";
$rs_ramo =@pg_Exec($conn,$qry_ramo);
$prc= pg_result($rs_ramo,0);
$truncado_pu= pg_result($rs_ramo,1);
$prc_reales = 100-intval($prc);

$pr_pu=intval($prc)/100;
$pr_nr=$prc_reales/100;

//selecciono alumnos notas reales
$sql1="select rut_alumno,promedio from notas$an where id_ramo=".$ramo." and id_periodo=".$periodo;
$rs1=@pg_Exec($conn,$sql1); 

//voy a buscar el promedio del ramo
for($a=0;$a<pg_numrows($rs1);$a++){
$fil_p=pg_fetch_array($rs1,$a);
$alumno=$fil_p['rut_alumno'];
$promedio_r=$fil_p['promedio'];

$nota_parciales_calculo=0;
$notas_pu_calculo=0;
$nuevo_promedio=0;

$nota_parciales_calculo =$promedio_r*$pr_nr;

//selecciono promedio notas pu
$sql2="select promedio from pu_notas where rut_alumno=$alumno and id_ramo=$ramo and id_periodo=$periodo";
$rs2=@pg_Exec($conn,$sql2); 

$promedio = pg_result($rs2,0);

$notas_pu_calculo=$promedio*$pr_pu;

$nuevo_promedio = ($truncado_pu==1)?round($nota_parciales_calculo+$notas_pu_calculo,0):intval($nota_parciales_calculo+$notas_pu_calculo);

//inserto la nota
$sql3="update notas$an set notapu=$nuevo_promedio where rut_alumno=$alumno and id_ramo=$ramo and id_periodo=$periodo";
$rs3=@pg_Exec($conn,$sql3); 
}



?>