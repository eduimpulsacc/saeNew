<?php require('../../../../../../util/header.inc');

$qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, ramo.eee,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen, ramo.conexper,ramo.prueba_especial,ramo.bool_nquiz,ramo.conexquiz, ramo.coef2 FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso."))  order by ramo.id_orden";			  
$result =@pg_Exec($conn,$qry);

  $contador = @pg_numrows($result);			

?>
<form action="" method="post" id="relramo_<?php echo $ramo ?>" name="relramo_<?php echo $ramo ?>">
<input type="hidden" name="rm" id="rm" value="<?php echo $ramo ?>">
<input type="hidden" name="cur" id="cur" value="<?php echo $curso ?>">
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
   <tr>
    <td height="51" colspan="3" align="right"><input type="button" name="ingrel" id="ingrel" value="Guardar Relaci&oacute;n" class="botonXX" onClick="guardaRel('relramo_<?php echo $ramo ?>')" />&nbsp;&nbsp;<input type="button" name="ingrel2" id="ingrel2" value="Cerrar Pesta&ntilde;a" onclick="cierra(<?php echo $ramo ?>)" class="botonXX"/>&nbsp;&nbsp;</td>
  </tr>
  
  <tr class="tableindex">
    <td width="12%" align="center">Padre</td>
    <td width="13%" align="center">Hijo</td>
    <td width="75%" align="center">Subsector</td>
  </tr>
  <?php for($a=0;$a<$contador;$a++){
	 $fila = pg_fetch_array($result,$a);
	 
	  $sqlh= "select id_ramo_hijo from relacion_ramo where id_ramo_padre=".$ramo." and id_ramo_hijo=".$fila['id_ramo'];
	  $resulth =@pg_Exec($conn,$sqlh);
	  $fhijo= pg_fetch_array($resulth,0);
	  $hijo= $fhijo['id_ramo_hijo'];
	 ?>
  <tr>
    <td align="center"><input type="radio" name="padre" id="padre" value="<?php echo $fila['id_ramo'] ?>" <?php echo ($fila['id_ramo']==$ramo)?"checked":"" ?> <?php echo ($fila['id_ramo']!=$ramo?"disabled":"") ?> >
   </td>
    <td align="center"><input type="checkbox" name="hijo[]" id="hijo<?php echo $a ?>" value="<?php echo $fila['id_ramo'] ?>" <?php echo ($fila['id_ramo']==$ramo?"disabled":"") ?> <?php echo ($hijo)?"checked":"" ?>>
      </td>
    <td class="textosimple"><?php echo $fila['nombre']; ?></td>
  </tr>
 <?php }?>
</table>
</form>

