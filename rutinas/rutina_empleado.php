<?php 

$id_base= 4;
$nano = 2019;
//$rdb =9098;
$perfil=14;  
 $connection=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	

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
$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");
	 }
	
	
//adm web
$sql_usr="select ac.rdb,us.nombre_usuario,ins.base_datos
from usuario us
inner join accede ac on ac.id_usuario = us.id_usuario
inner join institucion ins on ins.rdb = ac.rdb
where ac.id_perfil=$perfil order by ac.rdb and ins.base_datos = $id_base";
$rs_usr=pg_exec($connection,$sql_usr) or die("no->".$sql_usr);
?>

<table width="100%" border="1" cellspacing="1" cellpadding="1">
<?
for($i=0;$i<pg_numrows($rs_usr);$i++){
$fila = pg_fetch_array($rs_usr,$i);
$sql_emp = "select DISTINCT (ins.rdb),upper(ins.nombre_instit) as nombre_institucion,
emp.rut_emp||'-'||emp.dig_rut as rut_empleado,upper(emp.nombre_emp||' '||emp.ape_pat||' '||emp.ape_mat) as nombre_empleado, 
emp.telefono,emp.celular,emp.email
from empleado emp 
inner join trabaja t on t.rut_emp = emp.rut_emp 
inner join institucion ins on ins.rdb = t.rdb 
inner join ano_escolar an on an.id_institucion = ins.rdb 
where t.rut_emp = ".trim($fila['nombre_usuario'])." and ins.rdb = ".trim($fila['rdb'])." and an.nro_ano = $nano
order by 1";


$rs_emp = pg_exec($conn,$sql_emp);

if(pg_numrows($rs_emp)>0){
	for($o=0;$o<pg_numrows($rs_emp);$o++){
$fila_emp = pg_fetch_array($rs_emp,$o);
?>
<tr>
    <td><?php echo $fila_emp['rdb'] ?></td>
    <td><?php echo $fila_emp['nombre_institucion'] ?></td>
    <td><?php echo $fila_emp['rut_empleado'] ?></td>
    <td><?php echo $fila_emp['nombre_empleado'] ?></td>
    <td><?php echo $fila_emp['telefono'] ?></td>
    <td><?php echo $fila_emp['celular'] ?></td>
    <td><?php echo $fila_emp['email'] ?></td>
  </tr>

<?
}
}
}?></table>