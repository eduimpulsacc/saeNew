<?

$conn2=pg_connect("dbname=coi_usuario host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Corporacion.");	
				

$sql="SELECT DISTINCT a.rdb,i.nombre_instit, nombre_usuario, p.nombre_perfil,p.id_perfil, a.estado
FROM usuario u
INNER JOIN accede a ON u.id_usuario=a.id_usuario
INNER JOIN corp_instit ci ON a.rdb=ci.rdb
INNER JOIN nacional_corp nc ON nc.num_corp=ci.num_corp
INNER JOIN perfil p ON p.id_perfil=a.id_perfil
INNER JOIN institucion i ON i.rdb=a.rdb
WHERE  id_nacional=2 and a.id_perfil=14 and a.estado=1
ORDER BY 1,3";
$rs_usuario = pg_exec($conn2,$sql);

?>

<table width="90%" border="1">
  <tr>
    <td>RBD</td>
    <td>INSTTIUCION</td>
    <td>RUT</td>
    <td>ADMINISTRADOR</td>
  </tr>
  <?
for($i=0;$i<pg_numrows($rs_usuario);$i++){
	$fila = pg_fetch_array($rs_usuario,$i);
	$sql="SELECT nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombre FROM empleado WHERE rut_emp=".$fila['nombre_usuario'];
	$rs_empleado = pg_exec($conn,$sql);
	$nombre = pg_result($rs_empleado,0);
?>

  <tr>
    <td>&nbsp;<?=$fila['rdb'];?></td>
    <td>&nbsp;<?=$fila['nombre_instit'];?></td>
    <td>&nbsp;<?=$fila['nombre_usuario'];?></td>
    <td>&nbsp;<?=$nombre;?></td>
  </tr>


<?	
}

?></table>
<?

?>