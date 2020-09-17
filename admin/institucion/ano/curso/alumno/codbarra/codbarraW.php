<?php 


require('../../../../../../util/header.inc');

$query="select al.rut_alumno,al.ape_pat,al.ape_mat,al.nombre_alu from matricula m inner join alumno al on m.rut_alumno  = al.rut_alumno  where id_curso=".$_REQUEST['curso']." and bool_ar=0 order by nro_lista";
$rs = pg_exec($conn,$query);
?>
 <body onLoad="window.print()">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
</style>
<table  border="0" cellpadding="0" style="font-size:10px" width="650">

<?php for($i=0;$i<pg_numrows($rs);$i++){
$fila_alu = pg_fetch_array($rs,$i);

?>
<?php if($i>0 && $i%24==0){?>
 </tr>
 </table>
<H1 class=SaltoDePagina></H1>
<table  border="0" cellpadding="0" style="font-size:10px"  width="650">
<tr>
<?php }?>
<?php if($i%3==0){?>
</tr><tr>
<?php }?>
  
    <td valign="top" width="33%" nowrap="nowrap">
    <table width="100%" border="0" cellpadding="0" style="border-collapse:collapse">
  <tr>
    <td height="7" align="center" style="font-size:10px"><?php echo $fila_alu['ape_pat'] ?> <?php echo $fila_alu['ape_mat'] ?> <?php echo $fila_alu['nombre_alu'] ?></td>
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
</body>