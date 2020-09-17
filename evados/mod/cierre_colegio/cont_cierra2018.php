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
	$rs_plantilla = $ob_cierra->cierre_evaluado($id_nacional,32,$ano);
	
	$rs_bloque =$ob_cierra->buscabloque();
	?>
<table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td class="textonegrita">PROCESO</td>
      <td class="textonegrita">ESTADO</td>
    </tr>
    <? $fila=pg_fetch_array($rs_bloque,0);?>
     <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <? for($i=1;$i<pg_numrows($rs_bloque);$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td></td>
    </tr>
   <? } ?>
</table>		
<? }
if($funcion==3){
	$rs_plantilla = $ob_cierra->cierre_evaluado($id_nacional,29,$ano);
	
	$rs_bloque =$ob_cierra->buscabloque();
	?>
<table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td class="textonegrita">PROCESO</td>
      <td class="textonegrita">ESTADO</td>
    </tr>
    <? for($i=0;$i<2;$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <? }
	for($i=2;$i<pg_numrows($rs_bloque);$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td></td>
    </tr>
   <? } ?>
</table>		
<? }
if($funcion==4){
	$rs_plantilla = $ob_cierra->cierre_evaluado($id_nacional,34,$ano);
	
	$rs_bloque =$ob_cierra->buscabloque();
	?>
<table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td class="textonegrita">PROCESO</td>
      <td class="textonegrita">ESTADO</td>
    </tr>
    <? for($i=0;$i<3;$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <? }
	for($i=3;$i<pg_numrows($rs_bloque);$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td></td>
    </tr>
   <? } ?>
</table>		
<? }
if($funcion==5){
	$rs_plantilla = $ob_cierra->cierre_evaluado($id_nacional,31,$ano);
	
	$rs_bloque =$ob_cierra->buscabloque();
	?>
<table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td class="textonegrita">PROCESO</td>
      <td class="textonegrita">ESTADO</td>
    </tr>
    <? for($i=0;$i<4;$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <? }
	for($i=4;$i<pg_numrows($rs_bloque);$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td></td>
    </tr>
   <? } ?>
</table>		
<? }
if($funcion==6){
	$rs_plantilla = $ob_cierra->cierre_evaluado($id_nacional,19,$ano);
	
	$rs_bloque =$ob_cierra->buscabloque();
	?>
<table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td class="textonegrita">PROCESO</td>
      <td class="textonegrita">ESTADO</td>
    </tr>
    <? for($i=0;$i<5;$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <? }
	for($i=5;$i<pg_numrows($rs_bloque);$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td></td>
    </tr>
   <? } ?>
</table>		
<? }
if($funcion==7){
	$rs_plantilla = $ob_cierra->cierre_evaluado($id_nacional,33,$ano);
	
	$rs_bloque =$ob_cierra->buscabloque();
	?>
<table width="90%" border="1" style="border-collapse:collapse">
    <tr>
      <td class="textonegrita">PROCESO</td>
      <td class="textonegrita">ESTADO</td>
    </tr>
    <? for($i=0;$i<6;$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td class="textosimple"><?=$fila['nombre'];?></td>
      <td><img src='img/PNG-48/ok.png' width='20' height='20' border='0' alt='Evaluacion Cerrada' /></td>
    </tr>
    <? }
	for($i=6;$i<pg_numrows($rs_bloque);$i++){
			$fila=pg_fetch_array($rs_bloque,$i);
	?>
    <tr>
      <td><?=$fila['nombre'];?></td>
      <td></td>
    </tr>
   <? } ?>
</table>		
<? }
if($funcion==8){
	$rs_plantilla = $ob_cierra->cierre_evaluado($id_nacional,37,$ano);
	
	$rs_bloque =$ob_cierra->buscabloque();
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
if($funcion==9){
	$rs_plantilla = $ob_cierra->insertcierreconcepto($id_nacional,$ano);
	
	$rs_bloque =$ob_cierra->buscabloque();
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