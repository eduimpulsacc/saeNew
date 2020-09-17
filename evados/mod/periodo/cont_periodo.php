<? 

session_start();
require "mod_periodo.php";

$ano = $_ANO;
$funcion = $_POST['funcion'];

$ob_Periodo = new Periodo($_IPDB,$_ID_BASE);

if($funcion=="modifica"){
	$rs_periodo = $ob_Periodo->Modifica($periodo,$estado,$_ANO);
	
	if($rs_periodo){
		echo 1;	
	}else{
		echo 0;
	}
}


if($funcion=="inicio"){
	$rs_ano = $ob_Periodo->traeTodosAnos($_INSTIT);
?>
<br />
<br />
<select name="cmb_ano" id="cmb_ano" onchange="cambiaPer(this.value)">
<option value="0">Seleccione A&ntilde;o</option>
<?php for($j=0;$j<pg_numrows($rs_ano);$j++){
		$fila_ano = pg_fetch_array($rs_ano,$j);
		
		$estado = ($fila_ano['cerrado']==0)?"Cerrado":"Abierto";
		$sel = ($fila_ano['id_ano']==$_ANO)?"selected":"";
		?>
  <option value="<?php echo $fila_ano['id_ano'] ?>" <?php echo $sel ?>><?php echo $fila_ano['nro_ano'] ?> (<?php echo $estado ?>)</option>
<?php }?>
</select>
<br />
<br />

<table width="90%" border="1" align="center" style="border-collapse:collapse"> 
  <tr>
    <td colspan="4" class="cuadro02">PERIODOS</td>
    </tr>
  <tr class="cuadro02">
    <td>&nbsp;NOMBRE</td>
    <td>&nbsp;FECHA INICIO</td>
    <td>&nbsp;FECHA TERMINO</td>
    <td>&nbsp;ESTADO</td>
  </tr>
  	<? 	
  		$rs_periodo = $ob_Periodo->BuscaPeriodo($ano);
		
		for($i=0;$i<pg_numrows($rs_periodo);$i++){
			$fila =pg_fetch_array($rs_periodo,$i);
	?>
  <tr>
    <td class="textosimple">&nbsp;<?=$fila['nombre_periodo'];?></td>
    <td class="textosimple">&nbsp;<?=$fila['fecha_inicio'];?></td>
    <td class="textosimple">&nbsp;<?=$fila['fecha_termino'];?></td>
    <? 
		if($fila['cerrado']==1){
			$estado="<img src='img/PNG-48/Delete.png' width='22' height='22' border='0' title='Abrir Periodo' onclick='Modifica_Periodo(".$fila['id_periodo'].",0)'/>";	
		}else{
			$estado="<img src='img/PNG-48/Add.png' width='22' height='22' border='0' title='Cerrar Periodo' onclick='Modifica_Periodo(".$fila['id_periodo'].",1)'/>";	
		}
	?>
    <td>&nbsp;<a href="#"><?=$estado;?></a></td>
  </tr>
  <? } ?>
  
</table>
<?	
}
if($funcion=="cambia"){
	$rs_ano = $ob_Periodo->traeTodosAnos($_INSTIT);
	?>
<select name="cmb_ano" id="cmb_ano" onchange="cambiaPer(this.value)">
<option value="0">Seleccione A&ntilde;o</option>
<?php for($j=0;$j<pg_numrows($rs_ano);$j++){
		$fila_ano = pg_fetch_array($rs_ano,$j);
		
		$estado = ($fila_ano['cerrado']==0)?"Cerrado":"Abierto";
		
		?>
  <option value="<?php echo $fila_ano['id_ano'] ?>" <?php echo ($iano==$fila_ano['id_ano'])?"selected":"" ?>><?php echo $fila_ano['nro_ano'] ?> (<?php echo $estado ?>)</option>
<?php }?>
</select>
   <br />
   <br />
    <table width="90%" border="1" align="center" style="border-collapse:collapse"> 
  <tr>
    <td colspan="4" class="cuadro02">PERIODOS</td>
    </tr>
  <tr class="cuadro02">
    <td>&nbsp;NOMBRE</td>
    <td>&nbsp;FECHA INICIO</td>
    <td>&nbsp;FECHA TERMINO</td>
    <td>&nbsp;ESTADO</td>
  </tr>
  	<? 	
  		$rs_periodo = $ob_Periodo->BuscaPeriodo($iano);
		
		for($i=0;$i<pg_numrows($rs_periodo);$i++){
			$fila =pg_fetch_array($rs_periodo,$i);
	?>
  <tr>
    <td class="textosimple">&nbsp;<?=$fila['nombre_periodo'];?></td>
    <td class="textosimple">&nbsp;<?=$fila['fecha_inicio'];?></td>
    <td class="textosimple">&nbsp;<?=$fila['fecha_termino'];?></td>
    <? 
		if($fila['cerrado']==1){
			$estado="<img src='img/PNG-48/Delete.png' width='22' height='22' border='0' title='Abrir Periodo' onclick='Modifica_Periodo(".$fila['id_periodo'].",0)'/>";	
		}else{
			$estado="<img src='img/PNG-48/Add.png' width='22' height='22' border='0' title='Cerrar Periodo' onclick='Modifica_Periodo(".$fila['id_periodo'].",1)'/>";	
		}
	?>
    <td>&nbsp;<a href="#"><?=$estado;?></a></td>
  </tr>
  <? } ?>
  
</table>
    <?
}
?>

