<? 

session_start();
require "mod_apoderado.php";


$funcion = $_POST['funcion'];

$ob_Apoderado = new Apoderado($_IPDB,$_ID_BASE);

if($funcion==1){
	$rs_curso = $ob_Apoderado->Listado($curso);
	
?>
<table width="90%" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td>RUT ALUMNO</td>
    <td>ALUMNO</td>
    <td> RUT APODERADO</td>
    <td>APODERADO</td>
    <td>&nbsp;</td>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_curso);$i++){
	  $fila =pg_fetch_array($rs_curso,$i);
	?>
	  
  <tr>
    <td>&nbsp;<?=$fila['rut_alumno']."-".$fila['dig_rut'];?></td>
    <td>&nbsp;<?=$fila['nombre_alumno'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <? } ?>
</table>
<?		
}

?>