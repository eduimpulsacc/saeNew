<?php

echo "rdb->".$rdb=8905;

$connection=pg_connect("dbname=coi_usuario host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_Usuario ");

$conn=pg_connect("dbname=coi_final host=190.196.32.148 port=5432 user=postgres password=300600") or die ("Error de conexion Coi_final");	


$sql="select distinct al.rut_alumno,ap.rut_apo, ap.rut_apo||'-'||ap.dig_rut as rut_apoderado,
ap.nombre_apo||' '||ap.ape_pat||' '||ap.ape_mat as nombre_apo,
al.rut_alumno||'-'||al.dig_rut as rut_alumnos,
al.nombre_alu||' '||al.ape_pat||' '||al.ape_mat as nombre_alumno,
c.grado_curso||''||c.letra_curso||' '||te.nombre_tipo as Curso_al
from apoderado ap
inner join tiene2 t2 on ap.rut_apo=t2.rut_apo
inner join alumno al on al.rut_alumno=t2.rut_alumno 
inner join tiene2013 ti on ti.rut_alumno=al.rut_alumno
inner join curso c on c.id_curso=ti.id_curso
inner join tipo_ensenanza te on te.cod_tipo=c.ensenanza 
where c.id_ano=1352 
group by Curso_al,ap.rut_apo,ap.dig_rut,ap.nombre_apo,ap.ape_pat,ap.ape_mat,al.rut_alumno,al.dig_rut,al.nombre_alu,al.ape_pat,al.ape_mat
order by Curso_al asc";
$result = pg_exec($conn,$sql)or die("falloxxx");

?>
    
    	<table width="900px" border="1" style="border-collapse:collapse" align="center">
        <tr style="font-size:12px; font-family:Arial, Helvetica, sans-serif;">
        <td>Rut Apoderado</td>
        <td>Nombre Apoderado</td>
        <td>Clave Apoderado</td>
        <td>Rut Alumno</td>
        <td>Nombre Alumno</td>
        <td>Curso Alumno</td>
        <td>Clave Alumno</td>
        </tr>
<?

for($i=0;$i<pg_numrows($result);$i++){
$fila = pg_fetch_array($result,$i);
//print_r($fila);

$sql_2="SELECT usuario.nombre_usuario,usuario.pw  FROM USUARIO WHERE nombre_usuario='".$fila['rut_apo']."' ";	
$result2 = pg_exec($connection,$sql_2)or die("fallox");

$sql_3="SELECT usuario.nombre_usuario,usuario.pw  FROM USUARIO WHERE nombre_usuario='".$fila['rut_alumno']."' ";	
$result3 = pg_exec($connection,$sql_3)or die("fallox");

for($e=0;$e<pg_numrows($result2);$e++)
{
	$fila2=pg_fetch_array($result2,$e);
	$fila3=pg_fetch_array($result3,$e);
	
	?>
       <tr style="font-size:12px; font-family:Arial, Helvetica, sans-serif;">
        <td><?=$fila['rut_apoderado']?></td>
        <td><?=$fila['nombre_apo']?></td>
	    <td><?=$fila2['pw']?></td>
        <td><?=$fila['rut_alumnos']?></td>
        <td><?=$fila['nombre_alumno']?></td>
        <td><?=$fila['curso_al']?></td>
        <td><?=$fila3['pw']?></td>
      
    
    <?
	
	
	
}
}

?>
 </tr>
</table>
	



