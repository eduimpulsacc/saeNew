<?php 
require('../../../../../../util/header.inc');


 $query="select al.rut_alumno,al.ape_pat,al.ape_mat,al.nombre_alu from matricula m inner join alumno al on m.rut_alumno  = al.rut_alumno  where id_curso=".$_POST['curso']." and bool_ar=0 order by nro_lista";
$rs = pg_exec($conn,$query);

?>
<table  border="1" cellpadding="0" style="font-size:10px">
<?php for($i=0;$i<pg_numrows($rs);$i++){
$fila_alu = pg_fetch_array($rs,$i);

?>
<?php if($i%3==0){?>
</tr><tr>
<?php }?>
  
    <td valign="top"><table width="100%" border="1" cellpadding="0" style="border-collapse:collapse">
  <tr>
    <td align="center" style="font-size:10px"><?php echo $fila_alu['ape_pat'] ?> <?php echo $fila_alu['ape_mat'] ?> <?php echo $fila_alu['nombre_alu'] ?></td>
  </tr>
  <tr>
    <td align="center">
  <img src="http://app.colegiointeractivo.cl/sae3.0/admin/institucion/ano/curso/alumno/codbarra/barcode.php?text=<?php echo $fila_alu['rut_alumno'] ?>&size=60&print=true" />
    </td>
  </tr>
</table>
</td>
  

  <?php }?>

  </tr>
 </table>
