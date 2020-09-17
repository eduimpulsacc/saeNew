<?php require('../../../../../../util/header.inc');

$qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, ramo.eee,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen, ramo.conexper,ramo.prueba_especial,ramo.bool_nquiz,ramo.conexquiz, ramo.coef2 FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso.")) and ramo.bool_ip=1  order by ramo.id_orden";			  
$result =@pg_Exec($conn,$qry);

  $contador = @pg_numrows($result);			

?>

<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr class="tableindex">
    <td colspan="5" align="center">Listado de Relaciones</td>
  </tr>
  <tr>
    <td colspan="5" align="right">&nbsp;</td>
  </tr>
 <?php for($a=0;$a<$contador;$a++){
	 $fila = pg_fetch_array($result,$a);
	 ?>
  <tr>
    <td width="80%" class="textonegrita"><?php echo  $fila['nombre']; ?> </td>
    <td width="10%" align="center"><input type="submit" name="relacion" id="relacion" value="Ver Relación" class="botonXX" onclick="mues_data(<?php echo $fila['id_ramo'] ?>)" /></td>
    <td width="10%" align="center"><input type="button" name="ingrel" id="ingrel" value="Ingresar" onclick="mod_data(<?php echo $fila['id_ramo'] ?>)" class="botonXX"/></td>
   </tr>
   <tr>
   <td colspan="3">
     <div id="data_<?php echo $fila['id_ramo'] ?>" style="display:none" class="print">
      </div>
     <div id="relacion_<?php echo $fila['id_ramo'] ?>" style="display:none" class="print">
    </div>
    </td>
   </tr>  
  <?php }?>
 
</table>

