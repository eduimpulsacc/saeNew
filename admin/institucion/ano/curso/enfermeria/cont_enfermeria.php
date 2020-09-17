<?php require('../../../../../util/header.inc');
session_start();
require "mod_enfermeria.php";
$obj_enfermeria = new Enfermeria();



if($funcion==1){
	$rs_curso = $obj_enfermeria->curso($conn,$ano);
	
?>	&nbsp;
<select name="cmbCURSO" id="cmbCURSO" onchange="alumno(this.value);">
    	<option	value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila = pg_fetch_array($rs_curso,$i);
?>
		<option value="<?=$fila['id_curso'];?>"><?php echo CursoPalabra($fila['id_curso'],4,$conn) ?></option>
        	
<?	
		}
?>
	</select>
<?
}

if($funcion==2){
	$rs_alumno = $obj_enfermeria->alumno($conn,$curso);
	
?> &nbsp;
<select name="cmbALUMNO" id="cmbALUMNO" onchange="listado()">
    	<option value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_alumno);$i++){
			$fila = pg_fetch_array($rs_alumno,$i);
?>
		<option value="<?=$fila['rut_alumno'];?>"><?=$fila['nombre'];?></option>
<?	
}
?>
	</select>
 <?      	
}

if($funcion==3){
	$rs_listado = $obj_enfermeria->ListadoAtencion($conn,$ano,$curso,$alumno);
?>
	<table width="90%" border="0" align="center">
  <tr>
    <td align="right"><input type="submit" name="button" id="button" value="AGREGAR"  class="botonXX" onclick="agregar()"/></td>
    </tr>
  <tr>
    <td class="tableindex">LISTADO DE ATENCIONES</td>
    </tr>
</table>
	<br />
<table width="90%" border="1" style="border-collapse:collapse" align="center">
	  <tr class=" tablatit2-1">
	    <td align="center">FECHA</td>
	    <td align="center">HORA INGRESO</td>
	    <td align="center">DESTINO</td>
	    <td align="center">HORA EGRESO</td>
	    <td align="center">&nbsp;</td>
	    <td align="center">&nbsp;</td>
	    <td align="center">&nbsp;</td>
      </tr>
<? if(pg_numrows($rs_listado)==0){?>
		<tr>
	    <td colspan="7" class="textosimple">&nbsp; NO EXISTEN ATENCIONES</td>
        </tr>
<? }else{
		for($i=0;$i<pg_numrows($rs_listado);$i++){
			$fila = pg_fetch_array($rs_listado,$i);
?>
	  <tr class="textosimple">
	    <td>&nbsp;<?=CambioFD($fila['fecha']);?></td>
	    <td>&nbsp;<?=$fila['hora_ingreso'];?></td>
	    <td>&nbsp;<?=$fila['destino'];?></td>
	    <td>&nbsp;<?=$fila['hora_egreso'];?></td>
	    <td align="center"><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Search.png" width="24" height="24" border="0" title="VISTA PREVIA"  onclick="mostrar2(<?=$fila['id_enfermeria'];?>)" style="cursor:pointer"/></td>
	    <td align="center"><a href="#"><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/edit.png" width="24" height="24" border="0" title="MODIFICAR"  onclick="modifica(<?=$fila['id_enfermeria'];?>)"/></a></td>
	    <td align="center"><a href="#"><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Delete.png" width="24" height="24" border="0"  title="ELIMINAR" onclick="elimina(<?=$fila['id_enfermeria'];?>)"/></a></td>
      </tr>
 <? }
}
?>
 
</table><br />
<br />

<?	
}

if($funcion==4){
	$rs_patologia = $obj_enfermeria->Patologia($conn,$_INSTIT);
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
		$("#txtHORAEGRESO").mask('99:99');
	
	});
		
		</script>


<table width="90%" border="0" align="center">
  <tr>
    <td align="right"><input name="GIARDAR" type="button"  onclick="guardar()" value="GUARDAR" class="botonXX" />
    <input type="submit" name="VOLVER" id="VOLVER" value="VOLVER" class="botonXX"  onclick="listado();"/></td>
  </tr>
  <tr>
    <td class="tableindex">&nbsp;MODULO ATENCION DE ENFERMERIA</td>
  </tr>
</table><br />
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr>
    <td class="cuadro02">FECHA</td>
    <td class="cuadro01"><input name="txtFECHAS" type="text" id="txtFECHAS" size="10" maxlength="10" readonly></td>
    <td class="cuadro02">MOTIVO CONSULTA</td>
    <td class="cuadro01">
    <div id="formulario_clas"></div>
    <div id="patologia">
    <select name="cmbPATOLOGIA" id="cmbPATOLOGIA">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_patologia);$i++){
				$fila_pat = pg_Fetch_array($rs_patologia,$i);
		?>
        <option value="<?=$fila_pat['id_patologia'];?>"><?=strtoupper($fila_pat['nombre']);?></option>
        <? } ?>
    </select>
    <?php if ($_INSTIT != 24907 && $_INSTIT != 24988){ ?>
    <a href="#"><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Add.png" width="24" height="24" border="0" onclick="IngresoPatologia()"  title="AGREGAR PATOLOGIA"/></a>    
    </div>
    <?php }?>
</td>
  </tr>
  <tr>
    <td class="cuadro02">HORA INGRESO</td>
    <td class="cuadro01"><input name="txtHORAINGRESO" type="text" id="txtHORAINGRESO" size="10" maxlength="5" data-mask="00:00" /> 
      (hh:mm)</td>
    <td class="cuadro02">HORA EGRESO</td>
    <td class="cuadro01"><input name="txtHORAEGRESO" type="text" id="txtHORAEGRESO" size="10" maxlength="5" data-mask="00:00" />
    (hh:mm)</td>
  </tr>
  <tr>
   <!-- <td class="cuadro02">MOTIVO CONSULTA</td>
    <td class="cuadro01"><input type="text" name="txtCONSULTA" id="txtCONSULTA" /></td>-->
    <td class="cuadro02">DESTINO</td>
    <td class="cuadro01" colspan="3"><input type="text" name="txtDESTINO" id="txtDESTINO" style="width:250px" /></td>
  </tr>
  <tr>
    <td class="cuadro02">DESCRIPCI&Oacute;N MOTIVO</td>
    <td colspan="3" class="cuadro01"><textarea name="txtMOTIVO" cols="70" rows="4" id="txtMOTIVO"></textarea></td>
  </tr>
  <tr>
    <td class="cuadro02">ATENCI&Oacute;N DE ENFERMER&Iacute;A</td>
    <td colspan="3" class="cuadro01"><textarea name="txtPROCEDIMIENTO" cols="70" rows="4" id="txtPROCEDIMIENTO"></textarea></td>
  </tr>
  <tr>
    <td class="cuadro02">OBSERVACIONES</td>
    <td colspan="3" class="cuadro01"><textarea name="txtOBS" cols="70" rows="4" id="txtOBS"></textarea></td>
  </tr>
</table>
<br />


<?	
}

if($funcion==5){
	$rs_registro = $obj_enfermeria->Guardar($conn,$ano,$curso,$alumno,CambioFE($fecha),$ingreso,$egreso,$consulta,$destino,$proced,$obs,$patologia,$motivo);
	
	if($rs_registro){
		$rs_ultimo = $obj_enfermeria->ultimoEnfermeria($conn,$ano,$alumno);
		$ultimo = pg_result($rs_ultimo,0);
		
		echo $ultimo;
	}else{
		echo 0;
	}
		
}

if($funcion==6){
	$rs_elimina = $obj_enfermeria->elimina($conn,$id);
	
	if($rs_elimina){
		echo 1;
	}else{
		echo 0;
	}
	
}
if($funcion==7){
	//var_dump($_POST);
	$rs_muestra = $obj_enfermeria->Mostrar($conn,$id);
	$fila = pg_fetch_array($rs_muestra,0);
?>

<table width="90%" border="0">
  <tr>
    <td class="textonegrita">&nbsp;CURSO:</td>
    <td class="textosimple">&nbsp;<?=$fila['curso'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;ALUMNO:</td>
    <td class="textosimple">&nbsp;<?=$fila['nombre'];?></td>
  </tr>
</table>

<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr>
    <td class="cuadro02">FECHA</td>
    <td class="cuadro01"><?=CambioFD($fila['fecha']);?></td>
    <td class="cuadro02">MOTIVO CONSULTA</td>
    <td class="cuadro01"><?=$fila['patol'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">HORA INGRESO</td>
    <td class="cuadro01"><?=$fila['hora_ingreso'];?></td>
    <td class="cuadro02">HORA EGRESO</td>
    <td class="cuadro01"><?=$fila['hora_egreso'];?></td>
  </tr>
  <tr>
  
    <td class="cuadro02">DESTINO</td>
    <td class="cuadro01" colspan="3"><?=$fila['destino'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">DESCRIPCI&Oacute;N MOTIVO</td>
    <td colspan="3" class="cuadro01"><?=$fila['desc_motivo'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">ATENCI&Oacute;N DE ENFERMER&Iacute;A</td>
    <td colspan="3" class="cuadro01"><?=$fila['procedimiento'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">OBSERVACIONES</td>
    <td colspan="3" class="cuadro01"><?=$fila['observaciones'];?></td>
  </tr>
</table>
<?	
}

if($funcion==8){
	$rs_registro = $obj_enfermeria->Mostrar($conn,$id);
	$fila = pg_fetch_array($rs_registro,0);
	$rs_patologia = $obj_enfermeria->Patologia($conn,$_INSTIT);
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
		$("#txtHORAEGRESO").mask('99:99');
	
	});
		
		</script>


<table width="90%" border="0" align="center">
  <tr>
    <td align="right"><input name="GIARDAR" type="button"  onclick="guarda_modifica()" value="GUARDAR" class="botonXX" />
    <input type="submit" name="VOLVER" id="VOLVER" value="VOLVER" class="botonXX"  onclick="listado();"/></td>
  </tr>
  <tr>
    <td class="tableindex">&nbsp;MODULO ATENCION DE ENFERMERIA</td>
  </tr>
</table><br />
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr>
    <td class="cuadro02">FECHA</td>
    <td class="cuadro01"><input name="txtFECHAS" type="text" id="txtFECHAS" size="10" maxlength="10" readonly value="<?=CambioFD($fila['fecha']);?>"></td>
    <td class="cuadro02">MOTIVO CONSULTA</td>
    <td class="cuadro01"> <div id="formulario_clas"></div>
    <div id="patologia">
    <select name="cmbPATOLOGIA" id="cmbPATOLOGIA">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_patologia);$i++){
				$fila_pat = pg_Fetch_array($rs_patologia,$i);
		?>
        <option value="<?=$fila_pat['id_patologia'];?>" <?php echo ($fila_pat['id_patologia']==$fila['patologia'])?"selected":""; ?>><?=$fila_pat['nombre'];?></option>
        <? } ?>
    </select>
     <?php if ($_INSTIT != 24907 && $_INSTIT != 24988){ ?>
    <a href="#"><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Add.png" width="24" height="24" border="0" onclick="IngresoPatologia()"  title="AGREGAR PATOLOGIA"/></a>    
    </div>
    <?php }?></td>
  </tr>
  <tr>
    <td class="cuadro02">HORA INGRESO</td>
    <td class="cuadro01"><input name="txtHORAINGRESO" type="text" id="txtHORAINGRESO" size="10" maxlength="5" data-mask="00:00" value="<?=$fila['hora_ingreso'];?>" /> 
      (hh:mm)</td>
    <td class="cuadro02">HORA EGRESO</td>
    <td class="cuadro01"><input name="txtHORAEGRESO" type="text" id="txtHORAEGRESO" size="10" maxlength="5" data-mask="00:00" value="<?=$fila['hora_egreso'];?>" />
    (hh:mm)</td>
  </tr>
  <tr>
    <!--<td class="cuadro02">MOTIVO CONSULTA</td>
    <td class="cuadro01"><input type="text" name="txtCONSULTA" id="txtCONSULTA"  value="<?=$fila['motivo_consulta'];?>"/></td>-->
    <td class="cuadro02">DESTINO</td>
    <td class="cuadro01" colspan="3"><input type="text" name="txtDESTINO" id="txtDESTINO"  value="<?=$fila['destino'];?>"/></td>
  </tr>
  <tr>
    <td class="cuadro02">DESCRIPCI&Oacute;N MOTIVO</td>
    <td colspan="3" class="cuadro01"><textarea name="txtMOTIVO" cols="70" rows="4" id="txtMOTIVO"><?=$fila['desc_motivo'];?></textarea></td>
  </tr>
  <tr>
    <td class="cuadro02">ATENCI&Oacute;N DE ENFERMER&Iacute;A</td>
    <td colspan="3" class="cuadro01"><textarea name="txtPROCEDIMIENTO" cols="70" rows="4" id="txtPROCEDIMIENTO"><?=$fila['procedimiento'];?></textarea></td>
  </tr>
  <tr>
    <td class="cuadro02">OBSERVACIONES</td>
    <td colspan="3" class="cuadro01"><textarea name="txtOBS" cols="70" rows="4" id="txtOBS"> <?=$fila['observaciones'];?></textarea></td>
  </tr>
</table>
<input type="hidden" id="id" name="id" value="<?=$fila['id_enfermeria'];?>" />
<br />


<?	
}

if($funcion==9){
	$result = $obj_enfermeria->Modifica($conn,$ano,$curso,$alumno,CambioFE($fecha),$ingreso,$egreso,$consulta,$destino,$proced,$obs,$id,$patolo,$motivo);
	
	if($result){
		echo 1;
	}else{
		echo 0;	
	}
}

if($funcion==10){
	$result = $obj_enfermeria->AgregaPatologia($conn,$_INSTIT,$nombre);	

	if($result){
		echo 1;
	}else{
		echo 0;	
	}

}
if($funcion==11){
	$result = $obj_enfermeria->Patologia($conn,$_INSTIT);
?>
<select name="cmbPATOLOGIA" id="cmbPATOLOGIA">
    	<option value="0">seleccione...</option>
      <? for($i=0;$i<pg_numrows($result);$i++){
		  	$fila_a = pg_fetch_array($result,$i);
	  ?>
      	<option value="<?=$fila_a['id_patologia'];?>"><?=$fila_a['nombre'];?></option>
      <? } ?>
    </select>
<?		
}
//var_dump($_POST);

?>