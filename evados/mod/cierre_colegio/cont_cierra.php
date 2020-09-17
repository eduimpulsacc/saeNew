<?
header( 'Content-type: text/html; charset=latin1' );
session_start();

require "../cierre_colegio/mod_cierra.php";

$ob_cierra = new Cierra($_IPDB,$_ID_BASE);

$funcion 		= $_POST['funcion'];
$id_nacional	= $_NACIONAL;
$ano 			= $_ANO;
$institucion 	= $_INSTIT;

if($funcion==1){
	$rs_bloque =$ob_cierra->buscabloque($id_nacional);
	?>
<table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td class="textonegrita">PROCESO</td>
      <td class="textonegrita">ESTADO</td>
    </tr>
    <? for($i=0;$i<pg_numrows($rs_bloque);$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td>&nbsp;</td>
    </tr>
   <? } ?>
</table>
<? }

if($funcion==2){
	$rs_ciclo = $ob_cierra->CicloPlantillas($id_nacional,$id);
	$plantilla = pg_result($rs_ciclo,0);
	$rs_plantilla = $ob_cierra->cierre_evaluado($id_nacional,$plantilla,$ano);
	
	$rs_bloque =$ob_cierra->buscabloque($id_nacional);
	?>
<table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td class="textonegrita">PROCESO</td>
      <td class="textonegrita">ESTADO</td>
    </tr>
    <? for($i=0;$i<($id+1);$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td align="center"><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <? }
	for($i=$id;$i<pg_numrows($rs_bloque);$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td></td>
    </tr>
   <? } ?>
</table>		
<? 
	if(pg_numrows($rs_bloque)>$id){
		$contador = $id + 1;
		echo "<script>CicloPlantillas($contador);</script>";
	}
}

if($funcion==9){
	$rs_plantilla = $ob_cierra->insertcierreconcepto($id_nacional,$ano);
	
	$rs_bloque =$ob_cierra->buscabloque($id_nacional);
	?>
<table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td class="textonegrita">PROCESO</td>
      <td class="textonegrita">ESTADO</td>
    </tr>
    <? for($i=0;$i<7;$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <? }
	for($i=7;$i<pg_numrows($rs_bloque);$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td></td>
    </tr>
   <? } ?>
</table>		
<? }
?>