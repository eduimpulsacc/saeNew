<? 
//$conn=@pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");
$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña."); 

$connect=pg_connect("dbname=coi_usuario host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Usuario.");





$sql="SELECT DISTINCT a.rdb, nombre_usuario
FROM usuario u
INNER JOIN accede a ON u.id_usuario=a.id_usuario
INNER JOIN corp_instit ci ON a.rdb=ci.rdb
INNER JOIN nacional_corp nc ON nc.num_corp=ci.num_corp
WHERE  id_nacional=2
ORDER BY 1";
$rs_total = pg_exec($connect,$sql);



?>
<table width="90%" border="1" style="border-collapse:collapse">
  <tr>
    <td>RDB</td>
    <td>RUT</td>
    <td>NOMBRE</td>
    <td>ACCESO</td>
  </tr>
 <? for($i=0;$i<pg_numrows($rs_total);$i++){
		$fila=pg_fetch_array($rs_total,$i);
		
		$sql="SELECT rut_emp, dig_rut, nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombre
				FROM empleado WHERE rut_emp=".$fila['nombre_usuario'];
		$rs_empleado = pg_exec($conn,$sql);
		$digito = pg_result($rs_empleado,1);
		$nombre = pg_result($rs_empleado,2);
		
		if(pg_numrows($rs_empleado)==0){
			$sql="SELECT rut_alumno, dig_rut, nombre_alu ||' '|| ape_pat ||' '|| ape_mat as nombre
					FROM alumno WHERE rut_alumno=".$fila['nombre_usuario'];	
			$rs_alumno = pg_exec($conn,$sql);
			$digito = pg_result($rs_alumno,1);
			$nombre = pg_result($rs_alumno,2);
		}
		if(pg_numrows($rs_empleado)==0 && pg_numrows($rs_alumno)==0){
			$sql="SELECT rut_apo, dig_rut, nombre_apo ||' '|| ape_pat ||' '|| ape_mat as nombre
					FROM apoderado WHERE rut_apo=".$fila['nombre_usuario'];	
			$rs_apoderado = pg_exec($conn,$sql);
			$digito = pg_result($rs_apoderado,1);
			$nombre = pg_result($rs_apoderado,2);	
		}
?>	

  <tr>
    <td>&nbsp;<?=$fila['rdb'];?></td>
    <td>&nbsp;<?=$fila['nombre_usuario']."- ".$digito;?></td>
    <td>&nbsp;<?=$nombre;?></td>
    <td>
    	<table width="100%" border="1" style="border-collapse:collapse">
		<? $sql="SELECT p.nombre_perfil,a.estado
FROM usuario u INNER JOIN accede a ON u.id_usuario=a.id_usuario
INNER JOIN perfil p ON p.id_perfil=a.id_perfil
WHERE nombre_usuario='".$fila['nombre_usuario']."' and a.rdb=".$fila['rdb'];
			$rs_accede = pg_exec($connect,$sql);
		
			for($j=0;$j<pg_numrows($rs_accede);$j++){
				$fila_a=pg_fetch_array($rs_accede,$j);
		?>
          <tr>
            <td width="70%">&nbsp;<?=$fila_a['nombre_perfil'];?></td>
            <td width="30%">&nbsp;<? if($fila_a['estado']==1)	echo "HABILITADO"; else "DESHABILITADO"; ?></td>
          </tr>
          <? } ?>
        </table>

    </td>
  </tr>
<?  } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<? 

?>







