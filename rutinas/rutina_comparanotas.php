<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 
$id_base =1; 
$nano = 2017;
$rdb =10026;  
  


 if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

  if($id_base==3){
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
	//$conn=pg_connect("dbname=coi_antofagasta host=190.196.32.148 port=5432 user=postgres password=300600") or die ("Error de conexion Antofagasta.");	
	 }
	 
  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	 }?>
     
     
    <?php  header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=ComparaNotas.xls"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);?>
     
	<table> 
<?php 

//$sql_bn="select * from notas$nano order by rut_alumno,id_ramo,id_periodo";
$sql_bn = "select n.* from notas$nano n
inner join ramo r on r.id_ramo = n.id_ramo
inner join curso c on c.id_curso = r.id_curso
inner join ano_escolar a on a.id_ano = c.id_ano
where a.id_institucion = $rdb order by c.id_curso,n.rut_alumno,n.id_ramo,n.id_periodo";
$rs_bn=pg_exec($conn,$sql_bn);
?>
<table border="1">
<tr>
  <td>Rut alumno</td>
  <td>Nombre Alumno</td>
<td>Periodo</td>
<td>Ramo</td>
<?php for($i=1;$i<=20;$i++){?>
<td colspan="2">Nota <?php echo $i;?></td>
<?php }?>
</tr>
<?
for($i=0;$i<pg_numrows($rs_bn);$i++){
$f_bn = pg_fetch_array($rs_bn,$i);
$sql_alu ="select ape_pat,ape_mat,nombre_alu,dig_rut from alumno where rut_alumno=".$f_bn['rut_alumno'];
$rs_alu = pg_exec($conn,$sql_alu);
$fila_alu = pg_fetch_array($rs_alu,0);

$sql_periodo="select nombre_periodo from periodo where id_periodo=".$f_bn['id_periodo'];
$rs_periodo=pg_exec($conn,$sql_periodo);

$sql_ramo="select s.nombre from subsector s
inner join ramo r on s.cod_subsector = r.cod_subsector
where r.id_ramo=".$f_bn['id_ramo'];
$rs_ramo=pg_exec($conn,$sql_ramo);
?>
<tr><td><?php echo $f_bn['rut_alumno']?>-<?php echo $fila_alu['dig_rut']?></td>
  <td><?php echo $fila_alu['ape_pat']?> <?php echo $fila_alu['ape_mat']?>,<?php echo $fila_alu['nombre_alu']?></td>
  <td><?php echo pg_result($rs_periodo,0);?></td><td><?php echo pg_result($rs_ramo,0);?></td>
<?php for($j=1;$j<=20;$j++){
		$sql_nt = "select campo".($j+3)." from temporal_dav where campo1 ='".$f_bn['rut_alumno']."' and campo3='".$f_bn['id_periodo']."' and campo2='".$f_bn['id_ramo']."'";
	$rs_nt = pg_exec($conn,$sql_nt);
	
	$nn1 = (string) trim($f_bn['nota'.$j]);
	$nn2 = (string) trim(pg_result($rs_nt,0)); 
	?>
<td  background="<?php echo ($nn1!=$nn2)?"#f3f3f3":"#ffffff"?>"><?php echo $nn1;?></td>
<td ><?php echo $nn2;?></td>
<?php }?>
</tr>
<?	
}

	 
?>
</table>