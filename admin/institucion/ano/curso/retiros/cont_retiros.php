<?
require('../../../../../util/header.php');

$funcion=$_POST['funcion'];

require "mod_retiros.php";
$ob_retiro = new Retiro();

if($funcion==1){
	$rs_curso = $ob_retiro->Curso($conn,$_ANO);
	?>
   <select name="cmbCURSO" id="cmbCURSO" onChange="BuscaAlumno()">
        <option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_curso);$i++){
                $fila_c=pg_fetch_array($rs_curso,$i);
        ?>
        <option value="<?=$fila_c['id_curso'];?>"><?=CursoPalabra($fila_c['id_curso'],0,$conn);?></option>
        <? } ?>
</select>
<?	
}

if($funcion==2){
	$rs_alumno = $ob_retiro->Alumno($conn,$curso);
?>
<select name="cmbALUMNO" id="cmbALUMNO" onchange="Listado()">
<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_alumno);$i++){
		$fila=pg_Fetch_array($rs_alumno,$i);
?>
	<option value="<?=$fila['rut_alumno'];?>"><?=$fila['nombre_alumno'];?></option>
<? } ?>
</select>

<?	
}

if($funcion==3){
	$rs_listado = $ob_retiro->ListadoRetiros($conn,$curso,$alumno);
	?>
<table width="650" border="0" align="center">
  <tr>
    <td align="right">&nbsp;<input name="cmbAGREGAR" type="button" onClick="NuevoRetiro()" value="AGREGAR" class="botonXX" /></td>
  </tr>
  <tr>
    <td class="tableindex" align="center">LISTADO DE RETIROS</td>
  </tr>
  
</table>
<table width="650" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="tablatit2-1">
    <td>&nbsp;FECHA</td>
    <td>&nbsp;PERSONA QUE RETIRA</td>
    <td>&nbsp;HORA SALIDA</td>
    <td>&nbsp;HORA REGRESO</td>
    <td>&nbsp;OPCIONES</td>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_listado);$i++){
	  	$fila = pg_fetch_array($rs_listado,$i);
	?>
  <tr>
    <td class="textosimple">&nbsp;<?=CambioFD($fila['fecha']);?></td>
    <td class="textosimple">&nbsp;<?=$fila['quien_retira'];?></td>
    <td class="textosimple">&nbsp;<?=$fila['hora_salida'];?></td>
    <td class="textosimple">&nbsp;<?=$fila['hora_regreso'];?></td>
    <td class="textosimple"><a href="#"><img src="../../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Info.png" width="24" height="24" border="0" title="VER" onclick="VistaPrevia(<?=$fila['id_retiro'];?>)" /><img src="../../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Modify.png" width="24" height="24" border="0" title="MODIFICAR" onclick="Modificar(<?=$fila['id_retiro'];?>)" /><img src="../../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Delete.png" width="24" height="24" border="0" title="ELIMINAR" onclick="Eliminar(<?=$fila['id_retiro'];?>)"/></a></td>
  </tr>
  <? } ?>
</table>
<? } 

if($funcion==4){
	echo $nro_ano = $ob_retiro->Ano($conn,$_ANO);
}

if($funcion==5){
	$rs_empleado = $ob_retiro->Empleado($conn,$_INSTIT);
	
?>
<script type="text/javascript" src="../../../../clases/jquery-ui-1.9.2.custom/js/jquery.maskedinput-1.2.2.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		$("#txtFECHAS").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			yearRange: "1900:<?php echo date("Y") ?>"
			//buttonImage: 'img/Calendario.PNG',
		});
		$( "#txtPROCEDIMIENTO" ).resizable({
			handles: "se",
			ghost: true
		});
		$( "#txtOBS" ).resizable({
			handles: "se",
			ghost: true
		});
		$("#txtHORAINGRESO").mask('99:99');
		$("#txtHORAREGESO").mask('99:99');
	
	});
		
		</script>
<br />
<br />
<br />


<table width="650" border="0" align="center">
  <tr>
    <td align="right">&nbsp;<input name="cmbGUARDAR" id="cmbGUARDAR" type="button" class="botonXX" value="GUARDAR" onclick="GuardarRetiro()"/>
    <input name="cmbVOLVER2" id="cmbVOLVER2" type="button" class="botonXX" value="VOLVER" onclick="Listado()"/></td>
  </tr>
  <tr>
    <td class="tableindex" align="center">INGRESO DE ALUMNO A RETIRAR</td>
  </tr>
 
</table>
<br />
<br />

<table width="650" border="0" align="center">
  <tr>
    <td class="cuadro02">FECHA</td>
    <td class="cuadro01"><input name="txtFECHAS" type="text" id="txtFECHAS" size="10" maxlength="10" readonly></td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro02">HORA SALIDA</td>
    <td class="cuadro01"><input name="txtHORAINGRESO" type="text" id="txtHORAINGRESO" size="10"  data-mask="00:00"/></td>
  </tr>
  <tr>
    <td class="cuadro02">PERSONA QUE RETIRA</td>
    <td class="cuadro01"><input type="text" name="txtRETIRA" id="txtRETIRA" /></td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro02">HORA REGRESO</td>
    <td class="cuadro01"><input name="txtHORAREGESO" type="text" id="txtHORAREGESO" size="10"  data-mask="00:00"/></td>
  </tr>
  <tr>
    <td class="cuadro02">FUNCIONARIO QUE AUTORIZA</td>
    <td colspan="4"  class="cuadro01">
    <select name="cmbEMPLEADO" id="cmbEMPLEADO">
    	<option value="0">seleccione...</option>
       <? for($i=0;$i<pg_numrows($rs_empleado);$i++){
			$fila = pg_fetch_array($rs_empleado,$i);
		?>
        <option value="<?=$fila['rut_emp'];?>"><?=$fila['nombre_empl'];?></option>   
	   <? } ?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="cuadro02">MOTIVO</td>
    <td colspan="4" class="cuadro01">&nbsp;<textarea name="txtMOTIVO" id="txtMOTIVO" cols="50" rows="8"></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<? }

if($funcion==6){
	$rs_guarda = $ob_retiro->GuardaRetiro($conn,$ano,$curso,$alumno,$empleado,CambioFE($fecha),$hora_ing,$hora_egr,$motivo,$retira);
	
	if($rs_guarda){
		echo 1;	
	}else{
		echo 0;
	}
}
	
if($funcion==7){
	$rs_elimina = $ob_retiro->EliminaRetiro($conn,$id_retiro);
	
	if($rs_elimina){
		echo 1;	
	}else{
		echo 0;
	}
}
if($funcion==8){
	$rs_empleado = $ob_retiro->Empleado($conn,$_INSTIT);
	$rs_retiro  = $ob_retiro->BuscaRetiro($conn,$id_retiro);
	$fila_r= pg_fetch_array($rs_retiro,0); 
	
?>
<script type="text/javascript" src="../../../../clases/jquery-ui-1.9.2.custom/js/jquery.maskedinput-1.2.2.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		$("#txtFECHAS").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			yearRange: "1900:<?php echo date("Y") ?>"
			//buttonImage: 'img/Calendario.PNG',
		});
		$( "#txtPROCEDIMIENTO" ).resizable({
			handles: "se",
			ghost: true
		});
		$( "#txtOBS" ).resizable({
			handles: "se",
			ghost: true
		});
		$("#txtHORAINGRESO").mask('99:99');
		$("#txtHORAREGESO").mask('99:99');
	
	});
		
		</script>
<br />
<br />
<br />


<table width="650" border="0" align="center">
  <tr>
    <td align="right">&nbsp;<input name="cmbGUARDAR" id="cmbGUARDAR" type="button" class="botonXX" value="GUARDAR" onclick="ModificaRetiro(<?=$fila_r['id_retiro'];?>)"/>
    <input name="cmbVOLVER" id="cmbVOLVER" type="button" class="botonXX" value="VOLVER" onclick="Listado()"/></td>
  </tr>
  <tr>
    <td class="tableindex" align="center">INGRESO DE ALUMNO A RETIRAR</td>
  </tr>
 
</table>
<br />
<br />

<table width="650" border="0" align="center">
  <tr>
    <td class="cuadro02">FECHA</td>
    <td class="cuadro01"><input name="txtFECHAS" type="text" id="txtFECHAS" size="10" maxlength="10" readonly value="<?=CambioFD($fila_r['fecha']);?>"></td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro02">HORA SALIDA</td>
    <td class="cuadro01"><input name="txtHORAINGRESO" type="text" id="txtHORAINGRESO" size="10"  data-mask="00:00" value="<?=$fila_r['hora_salida'];?>"/></td>
  </tr>
  <tr>
    <td class="cuadro02">PERSONA QUE RETIRA</td>
    <td class="cuadro01"><input type="text" name="txtRETIRA" id="txtRETIRA" value="<?=$fila_r['quien_retira'];?>" /></td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro02">HORA REGRESO</td>
    <td class="cuadro01"><input name="txtHORAREGESO" type="text" id="txtHORAREGESO" size="10"  data-mask="00:00" value="<?=$fila_r['hora_regreso'];?>"/></td>
  </tr>
  <tr>
    <td class="cuadro02">FUNCIONARIO QUE AUTORIZA</td>
    <td colspan="4"  class="cuadro01">
    <select name="cmbEMPLEADO" id="cmbEMPLEADO">
    	<option value="0">seleccione...</option>
       <? for($i=0;$i<pg_numrows($rs_empleado);$i++){
			$fila = pg_fetch_array($rs_empleado,$i);
			
			if($fila['rut_emp']==$fila_r['rut_emp']){
		?>
	        <option value="<?=$fila['rut_emp'];?>" selected="selected"><?=$fila['nombre_empl'];?></option>   
	   <? 	}else{ ?>
           <option value="<?=$fila['rut_emp'];?>"><?=$fila['nombre_empl'];?></option>   
	   <?	}
	   } ?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="cuadro02">MOTIVO</td>
    <td colspan="4" class="cuadro01">&nbsp;<textarea name="txtMOTIVO" id="txtMOTIVO" cols="50" rows="8"><?=$fila_r['motivo'];?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<? }

if($funcion==9){
	$rs_modifica = $ob_retiro->ModificaRetiro($conn,$ano,$curso,$alumno,$empleado,CambioFE($fecha),$hora_ing,$hora_egr,$motivo,$retira,$id_retiro);
	
	if($rs_modifica){
		echo 1;	
	}else{
		echo 0;
	}
}

if($funcion==10){
	$rs_retiro  = $ob_retiro->VistaPrevia($conn,$id_retiro);
	$fila_r= pg_fetch_array($rs_retiro,0); 
	?>
<table width="650" border="0" align="center">
  <tr>
    <td class="cuadro02">FECHA</td>
    <td class="cuadro01"><?=CambioFD($fila_r['fecha']);?></td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro02">HORA SALIDA</td>
    <td class="cuadro01"><?=$fila_r['hora_salida'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">PERSONA QUE RETIRA</td>
    <td class="cuadro01"><?=$fila_r['quien_retira'];?></td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro02">HORA REGRESO</td>
    <td class="cuadro01"><?=$fila_r['hora_regreso'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">FUNCIONARIO QUE AUTORIZA</td>
    <td colspan="4"  class="cuadro01">&nbsp;<?=$fila_r['nombre_empleado'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">MOTIVO</td>
    <td colspan="4" class="cuadro01">&nbsp;<? echo nl2br($fila_r['motivo']);?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
 <?
}
?>