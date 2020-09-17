
<?

$id_base =4; 
$nano = 2018;
$rbd=array(9087,9088,9098,9103,9105,9106,9107,9110,9111,9117,9121,9127,12249,24997,25247);  
  


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
?>
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td>RDB</td>
    <td>COLEGIO</td>
    <td>CURSO</td>
    <td>RUT ALUMNO</td>
    <td>NOMBRE ALUMNO</td>
    <td>DIRECCI&Oacute;N</td>
    <td>TEL&Eacute;FONO</td>
    <td>CELULAR</td>
    <td>FECHA RETIRO</td>
    <td>&Uacute;LTIMO CURSO APROBADO</td>
  </tr>
<?
//colegios
for($a=0;$a<count($rbd);$a++){
  $sqla="select 
m.id_ano,
ins.rdb||'-'||ins.dig_rdb instrdb,
ins.nombre_instit,
m.rut_alumno,
al.ape_pat||' '||al.ape_mat||' '||al.nombre_alu nombrealumno,
c.grado_curso||'-'||c.letra_curso||' '||te.nombre_tipo nomcurso,
al.rut_alumno||'-'||al.dig_rut rutalu,
al.calle||' '||al.nro diralu,
al.telefono,
al.celular,
m.fecha_retiro
from matricula m
inner join ano_escolar a on a.id_ano = m.id_ano
inner join alumno al on al.rut_alumno = m.rut_alumno
inner join curso c on c.id_curso = m.id_curso
inner join tipo_ensenanza te on te.cod_tipo = c.ensenanza 
inner join institucion ins on ins.rdb = m.rdb
where a.nro_ano=$nano 
and a.id_institucion = ".$rbd[$a]."
and m.bool_ar =1
order by a.id_institucion,c.ensenanza,c.grado_curso,c.letra_curso,al.ape_pat,al.ape_mat,al.nombre_alu";
$rsa = pg_exec($conn,$sqla) or die("??");

for($b=0;$b<pg_numrows($rsa);$b++){
	$fila_col = pg_fetch_array($rsa,$b);
	
	//ultimo curso aprobado
	 $sql_ul = "select 
p.id_curso,
c.grado_curso||' '||te.nombre_tipo pcurso
from promocion p
inner join curso c on c.id_curso = p.id_curso
inner join tipo_ensenanza te on te.cod_tipo = c.ensenanza 
where rut_alumno = ".$fila_col['rut_alumno']." and situacion_final=1 
and fecha_prom is not null
order by c.ensenanza desc,c.grado_curso desc limit 1";
$rs_ul = pg_exec($conn,$sql_ul) or die("???");
$fila_ul = pg_fetch_array($rs_ul,0);
?>
<tr>
    <td><?php echo $fila_col['instrdb'] ?></td>
    <td><?php echo $fila_col['nombre_instit'] ?></td>
    <td><?php echo $fila_col['nomcurso'] ?></td>
    <td><?php echo $fila_col['rutalu'] ?></td>
    <td><?php echo $fila_col['nombrealumno'] ?></td>
    <td><?php echo $fila_col['diralu'] ?></td>
    <td><?php echo $fila_col['telefono'] ?></td>
    <td><?php echo $fila_col['celular'] ?></td>
    <td><?php  
	$fe = explode("-",$fila_col['fecha_retiro']);
	echo $fe[2]."-".$fe[1]."-".$fe[0] ?></td>
    <td><?php echo $fila_ul['pcurso'] ?></td>
  </tr>
<?
}
}

//anos escolares
//echo $sql_ano ="select id_ano from ano_escolar where nro_ano=$nano and id_institucion in ($rbd)";

?>

 
</table>