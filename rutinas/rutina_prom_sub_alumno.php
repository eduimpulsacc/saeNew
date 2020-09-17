<?php 
$id_base =1; 
$nano = 2017;  
$rdb =25478;                                 
    
  


 if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vina");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");	
	 }
?>
<?php 
//buscar año
$sql_ano = "select id_ano from ano_escolar where id_institucion=$rdb and nro_ano=$nano";
$rs_ano = pg_exec($conn,$sql_ano);
$id_ano = pg_result($rs_ano,0);


//promedios

$sql_prom="select ps.*,
al.rut_alumno||'-'||al.dig_rut rut_completo,
al.ape_pat||' '||al.ape_mat||' '||al.nombre_alu nombre_alumno,
cu.grado_curso||'-'||cu.letra_curso||' '||en.nombre_tipo curso_completo,
ra.cod_subsector,su.nombre
from promedio_sub_alumno ps 
inner join alumno al on al.rut_alumno = ps.rut_alumno
inner join curso cu on cu.id_curso = ps.id_curso
inner join tipo_ensenanza en on en.cod_tipo = cu.ensenanza
inner join ramo ra on ra.id_ramo = ps.id_ramo
inner join subsector su on ra.cod_subsector = su.cod_subsector
inner join promocion p on p.rut_alumno = ps.rut_alumno and p.id_ano =$id_ano and p.situacion_final!= 3
where ps.id_ano = $id_ano  order by cu.ensenanza,cu.grado_curso,cu.letra_curso,nombre_alumno,ra.id_orden";
$rs_prom = pg_exec($conn,$sql_prom);



header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=promedio_sub_alumno_".$rdb."_".$nano.".xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td>RBD</td>
    <td>A&Ntilde;O</td>
    <td>CURSO</td>
    <td>RUT ALUMNO</td>
    <td>ALUMNO</td>
    <td>ASIGNATURA</td>
    <td>PROMEDIO</td>
  </tr>
  <?php 
  for($p=0;$p<pg_numrows($rs_prom);$p++){
	  $fila_prom = pg_fetch_array($rs_prom,$p);
	  ?>
  <tr>
    <td><?php echo $rdb ?></td>
    <td><?php echo $nano ?></td>
    <td><?php echo $fila_prom['curso_completo'] ?></td>
    <td><?php echo $fila_prom['rut_completo'] ?></td>
    <td><?php echo strtoupper($fila_prom['nombre_alumno']) ?></td>
    <td><?php echo strtoupper($fila_prom['nombre']) ?></td>
    <td><?php echo $fila_prom['promedio'] ?></td>
  </tr>
  <?php }?>
</table>
