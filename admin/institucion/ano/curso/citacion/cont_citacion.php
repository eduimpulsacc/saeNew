<?php require('../../../../../util/header.inc');
session_start();
require "mod_citacion.php";
$obj_citacion = new Citacion();

//echo $_NOMBREUSUARIO;

if($funcion==1){
	$rs_curso = $obj_citacion->curso($conn,$ano);
	
?>	&nbsp;
<select name="cmbCURSO" id="cmbCURSO" onchange="apoderado(this.value);">
    	<option	value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila = pg_fetch_array($rs_curso,$i);
?>
		<option value="<?=$fila['id_curso'];?>"><?=$fila['curso'];?></option>
        	
<?	
		}
?>
	</select>
<?
}

if($funcion==2){
	$rs_apoderado = $obj_citacion->Apoderado2($conn,$curso);
	
?> &nbsp;
<select name="cmbAPODERADO" id="cmbAPODERADO">
    	<option value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_apoderado);$i++){
			$fila = pg_fetch_array($rs_apoderado,$i);
			
			
			
?>
		<option value="<?=$fila['rut_apo'];?>"><?=strtoupper($fila['nombre_apo']." ".$fila['ape_pat']." ".$fila['ape_mat']);?> (<?=strtoupper($fila['nombre_alu']." ".$fila['patalu']." ".$fila['matalu']);?>)</option>
<?	
}
?>
	</select>
 <?      	
}

if($funcion==3){
	$rs_listado = $obj_citacion->ListadoCitacion($conn,$ano,$curso,$apoderado,$asunto);
?>
	<table width="90%" border="0" align="center">
  <tr>
    <td align="right"></td>
    </tr>
  <tr>
    <td class="tableindex">LISTADO DE CITACIONES</td>
    </tr>
</table>
	<br />
<table  border="1" align="center" style="border-collapse:collapse">
	  <tr class=" tablatit2-1">
	    <td align="center">#</td>
	    <td align="center">FECHA</td>
	    <td align="center">HORA</td>
	    <td align="center">CONVOCA</td>
      <?php   if ($curso==0){?>
	    <td align="center">CURSO</td>
       <?php }?>
	    <td align="center">APODERADO</td>
      
	    <td align="center">ASUNTO</td>
       
	    <td colspan="4" align="center">ACCIONES</td>
      </tr>
<? if(pg_numrows($rs_listado)==0){?>
		<tr>
		  <td colspan="11" align="center" class="textosimple">SIN INFORMACI&Oacute;N</td>
	    </tr>
<? }else{
		for($i=0;$i<pg_numrows($rs_listado);$i++){
			$fila = pg_fetch_array($rs_listado,$i);
			
			if($fila['estado']==0){
			$img ="../../../../clases/img_jquery/iconos/function_icon_set/circle_red.png";
			$est=1;
			$txt_e="PRESENTE";
			}
			elseif($fila['estado']==1){
			$img ="../../../../clases/img_jquery/iconos/function_icon_set/circle_green.png";
			$est=0;
			$txt_e="AUSENTE";
			}
?>
	  <tr class="textosimple">
	    <td><?php echo ($i+1) ?></td>
	    <td>&nbsp;<?=$fila['fecha'];?></td>
	    <td>&nbsp;<?=$fila['hora'];?></td>
	    <td  align="center"><?=$fila['atendido'];?></td>
	    <?php  if ($curso==0){
			
			 ?>
	    <td align="center"><?php echo CursoPalabra($fila['id_curso'],6,$conn) ?></td>
        <?php }?>
	   <?php  if ($apoderado==0){ ?>
	    <td  align="center"><?=$fila['nom_apo'];?></td>
        <?php }?>
	    <?php  if ($asunto==0){ ?>
	    <td align="center"><?=$fila['asunto'];?></td>
        <?php }?>
	    <td align="center"><img src="<?php echo $img ?>" width="24" height="24" onclick="marca(<?=$fila['id_asistencia']?>,<?=$est;?>)" title="MARCAR COMO <?php echo $txt_e ?>" /></td>
	    <td align="center"><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/edit.png" width="24" height="24"  onclick="modifica(<?=$fila['id_asistencia'];?>)" /></td>
	    <td align="center"><a href="#"><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Search.png" width="24" height="24" border="0" title="VISTA PREVIA"  onClick="mostrar11(<?=$fila['id_asistencia'];?>)"/></a></td>
	    <td align="center"><a href="#"><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Delete.png" width="24" height="24" border="0"  title="ELIMINAR" onclick="elimina(<?=$fila['id_asistencia'];?>)"/></a></td>
      </tr>
 <? }
}
?>
 
</table><br />
<br />

<?	
}

if($funcion==4){
	$rs_asunto = $obj_citacion->asunto($conn,$_INSTIT);
	
	?>
	<script type="text/javascript" src="../../../../clases/jquery-ui-1.9.2.custom/js/jquery.maskedinput-1.2.2.js"></script>
	<script type="text/javascript">
	var anio="";
	<?php if($_PERFIL==17){
		$rs_ano  = $obj_citacion->ano2($conn,$_ANO);
		$ann = pg_result($rs_ano,1);
		?>
		anio = <?php echo $ann; ?>;
	apoderadoI($("#cmbCURSO").val());
	<?php }else{?>
	
	anio = $("#cmbANO option:selected").text();
	<?php  } ?>
	//alert(anio);
		$(document).ready(function() {
			$("#txtFECHAS").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
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
    <td class="tableindex">&nbsp;MODULO CITACIONES APODERADO</td>
  </tr>
</table><br />
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr>
    <td class="cuadro02">FECHA CITACION</td>
    <td class="cuadro01"><input name="txtFECHAS" type="text" id="txtFECHAS" size="10" maxlength="10" readonly></td>
    <td class="cuadro02">ASUNTO</td>
    <td class="cuadro01">
    <div id="formulario_clas"></div>
    <div id="patologia">
    <select name="cmbASUNTOI" id="cmbASUNTOI">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_asunto);$i++){
				$fila_pat = pg_Fetch_array($rs_asunto,$i);
		?>
        <option value="<?=$fila_pat['id_asunto'];?>"><?=$fila_pat['asunto'];?></option>
        <? } ?>
    </select>
    <a href="#"><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Add.png" width="24" height="24" border="0" onclick="IngresoPatologia()"  title="AGREGAR ASUNTO"/></a>    
    </div>
</td>
  </tr>
  <tr>
    <td class="cuadro02">HORA</td>
    <td class="cuadro01"><input name="txtHORAINGRESO" type="text" id="txtHORAINGRESO" size="10" maxlength="5" data-mask="00:00" /> 
      (hh:mm)</td>
    <td class="cuadro02">CONVOCA</td>
    <td class="cuadro01">
  <?php    $sql_emp = "SELECT distinct (empleado.rut_emp), empleado.dig_rut, 
empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.ape_pat||' '||empleado.ape_mat||', '|| 
empleado.nombre_emp nombre FROM empleado "; 
		
		if($_PERFIL==0 || $_PERFIL==14){
		$sql_emp.=" inner join trabaja t on t.rut_emp=empleado.rut_emp ";
			if($_INSTIT!=31392){
				$sql_emp.=" and t.cargo in (1,2,5) ";
			}
		}
			
		$sql_emp.= "
		INNER JOIN institucion ON t.rdb = institucion.rdb 
		WHERE institucion.rdb=".$_INSTIT." ";
		
		if($_PERFIL==17){
		$sql_emp.=" and empleado.rut_emp=$_NOMBREUSUARIO ";
		}
		
		$sql_emp.= "ORDER BY ape_pat, ape_mat, nombre_emp asc";
		
		//echo $sql_emp;
		
		$result_emp = @pg_exec($conn,$sql_emp); ?>
        
		<?php if($_PERFIL!=17){?>
		
    <div id="empe">
    <select name="cmbEmpleado" id="cmbEmpleado">
    <option value="0">Seleccione...</option>
    <?php for($ee=0;$ee<pg_numrows($result_emp);$ee++){
		$fila_emp=pg_fetch_array($result_emp,$ee);?>
    <option value="<?php echo $fila_emp['rut_emp'] ?>"><?php echo $fila_emp['nombre'] ?></option>
    <?php }?>
    </select>
    </div>
    <?php } else {?>
   <?php   ?>
    <input name="cmbEmpleado" id="cmbEmpleado" type="hidden" value="<?php echo $_NOMBREUSUARIO ?>" />
    <?php echo pg_result($result_emp,2) ?>  <?php echo pg_result($result_emp,3) ?>  <?php echo pg_result($result_emp,4) ?>
    <?php }?>
    </td>
  </tr>
  <tr>
    <td colspan="4" class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="cuadro02">DESTINATARIOS</td>
  </tr>
  <tr>
    <td class="cuadro02">CURSO</td>
    <td colspan="3" class="cuadro01">
    <?php /*if($_PERFIL!=17){*/?>
    <div id="cursoi">
        <select name="cmbCURSOI" id="cmbCURSOI" onchange="apoderadoI();">
        <option value="0">TODOS LOS CURSOS</option>
      </select>
    </div>
    <?php /* }else{
			$sc= "SELECT grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo AS curso, ensenanza FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo WHERE id_curso=".$_CURSO." ORDER BY ensenanza,curso ASC";
		$rc = pg_exec($conn,$sc);
										echo pg_result($rc,0);
		
		?>
    <input name="cmbCURSOI" type="hidden" id="cmbCURSOI" value="<?php echo $_CURSO ?>" />
    <?php }*/?></td>
  </tr>
  <tr>
    <td class="cuadro02">APODERADO</td>
    <td colspan="3" class="cuadro01">
    <div id="apoI">
    <select name="cmbAPODERADOI" id="cmbAPODERADOI">
      <option value="0">TODOS LOS APODERADOS</option>
    </select>
    </div></td>
  </tr>
  <tr>
    <td colspan="4" class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">Mensaje</td>
    <td colspan="3" class="cuadro01"><textarea name="txtOBS" cols="70" rows="8" id="txtOBS"></textarea></td>
  </tr>
</table>
<br />


<?	
}

if($funcion==5){
	
	var_dump($_POST);
	if($curso==0){
	//busco a todos los apoderados del colegio
	$tipo=1;
	
	$rs_registro = $obj_citacion->GuardarUno($conn,$ano,$curso,$apoderado,$fecha,$hora,$asunto,$mensaje,$emp,$tipo);
	
	
	$rs_curso = $obj_citacion->curso($conn,$ano);
	if (pg_numrows($rs_curso)>0){
		for($c=0;$c<pg_numrows($rs_curso);$c++){
			$fila = pg_fetch_array($rs_curso,$c);
			$curso = $fila['id_curso'];
			$rs_apoderado = $obj_citacion->Apoderado($conn,$curso);
			if(pg_numrows($rs_apoderado)>0){
				for($a=0;$a<pg_numrows($rs_apoderado);$a++){
					$fila_apo = pg_fetch_array($rs_apoderado,$a);
					$apoderado=$fila_apo['rut_apo'];
					$rs_registro2 = $obj_citacion->guardaCitacion($conn,$ano,$curso,$apoderado,$empleado);
				}
			
			}
			
		}
	}else{
	echo 0;
	}
	
	}

	elseif($apoderado==0){
	//busco a todos los apoderados del curso
	$tipo=2;
	
	$rs_registro = $obj_citacion->GuardarUno($conn,$ano,$curso,$apoderado,$fecha,$hora,$asunto,$mensaje,$emp,$tipo);
	
	$rs_apoderado = $obj_citacion->Apoderado($conn,$curso);
			if(pg_numrows($rs_apoderado)>0){
				for($a=0;$a<pg_numrows($rs_apoderado);$a++){
					$fila_apo = pg_fetch_array($rs_apoderado,$a);
					$apoderado=$fila_apo['rut_apo'];
					$rs_registro2 = $obj_citacion->guardaCitacion($conn,$ano,$curso,$apoderado,$empleado);
				}
			
			}
	
	}
	
	else{
		$tipo=3;
		$rs_registro = $obj_citacion->Guardar($conn,$ano,$curso,$apoderado,$fecha,$hora,$asunto,$mensaje,$empleado,$tipo);
		
		
	}
	
	if($rs_registro){
		echo 1;
	}else{
		echo 0;
	}
	
	//$rs_registro = $obj_citacion->Guardar($conn,$ano,$curso,$apoderado,$fecha,$fecha,$hora,$asunto,$mensaje);
	
	/*if($rs_registro){
		echo 1;
	}else{
		echo 0;
	}*/
		
}

if($funcion==6){
	$rs_elimina = $obj_citacion->elimina($conn,$id);
	
	if($rs_elimina){
		echo 1;
	}else{
		echo 0;
	}
	
}
if($funcion==7){
	$rs_muestra = $obj_citacion->Mostrar($conn,$id);
	$fila = pg_fetch_array($rs_muestra,0);
?>
<table width="90%" border="0">
  <tr>
    <td class="textonegrita">&nbsp;CURSO:</td>
    <td class="textosimple"><?php 
	$rs_curso = $obj_citacion->cursoUno($conn,$fila['id_curso']);
			$ncurso = pg_result($rs_curso,1);
	echo $ncurso ?></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;APODERADO:</td>
    <td class="textosimple"><?=$fila['nom_apo'];?></td>
  </tr>
</table>

<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr>
    <td class="cuadro02">FECHA</td>
    <td class="cuadro01"><?php echo $fila['fecha'] ?></td>
    <td class="cuadro02">HORA</td>
    <td class="cuadro01"><?php echo $fila['hora'] ?></td>
  </tr>
  <tr>
    <td class="cuadro02"> ASUNTO</td>
    <td class="cuadro01"><?php echo $fila['asunto'] ?></td>
    <td class="cuadro02">QUIEN CONVOCA</td>
    <td class="cuadro01"><?php echo $fila['atendido'] ?></td>
  </tr>
  <tr>
    <td class="cuadro02">MENSAJE</td>
    <td colspan="3" class="cuadro01"><?php echo $fila['motivo'] ?></td>
  </tr>
</table>
<?	
}

if($funcion==8){
	$rs_registro = $obj_citacion->Mostrar($conn,$id);
	$fila = pg_fetch_array($rs_registro,0);
	$rs_asunto = $obj_citacion->asunto($conn,$_INSTIT);
	
	?>
	<script type="text/javascript" src="../../../../clases/jquery-ui-1.9.2.custom/js/jquery.maskedinput-1.2.2.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		$("#txtFECHAS").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd-mm-yy',
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
    <td class="tableindex">&nbsp;MODULO CITACION APODERADO</td>
  </tr>
</table><br />
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr>
    <td class="cuadro02">FECHA</td>
    <td class="cuadro01"><input name="txtFECHAS" type="text" id="txtFECHAS" size="10" maxlength="10" readonly value="<?=$fila['fecha'];?>"></td>
    <td class="cuadro02">ASUNTO</td>
    <td class="cuadro01"><div id="formulario_clas2"></div>
      <div id="patologia">
        <select name="cmbASUNTOI" id="cmbASUNTOI">
          <option value="0">seleccione...</option>
          <? for($i=0;$i<pg_numrows($rs_asunto);$i++){
				$fila_pat = pg_Fetch_array($rs_asunto,$i);
		?>
          <option value="<?=$fila_pat['id_asunto'];?>" <?php echo ($fila_pat['id_asunto']==$fila['id_asunto'])?"selected":"" ?>>
            <?=$fila_pat['asunto'];?>
          </option>
          <? } ?>
        </select>
    <a href="#"><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Add.png" width="24" height="24" border="0" onclick="IngresoPatologia()"  title="AGREGAR ASUNTO"/></a> </div></td>
  </tr>
  <tr>
    <td class="cuadro02">HORA </td>
    <td class="cuadro01"><input name="txtHORAINGRESO" type="text" id="txtHORAINGRESO" size="10" maxlength="5" data-mask="00:00" value="<?=$fila['hora'];?>" /> 
      (hh:mm)</td>
    <td class="cuadro02">CONVOCA</td>
    <td class="cuadro01">
	
	
	<?php    $sql_emp = "SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, empleado.calle, empleado.nro, ";
		$sql_emp.= "empleado.telefono, empleado.email, empleado.fecha_nacimiento,comuna.nom_com FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN ";
		$sql_emp.= "institucion ON trabaja.rdb = institucion.rdb INNER JOIN comuna ON (empleado.region=comuna.cod_reg AND empleado.ciudad=comuna.cor_pro AND empleado.comuna=comuna.cor_com)"; 
		
		if($_PERFIL==0 || $_PERFIL==14){
		$sql_emp.=" inner join trabaja t on t.rut_emp=empleado.rut_emp and t.cargo in (1,2,5) ";
		}
		
		
		
		
		$sql_emp.= "WHERE (((institucion.rdb)=".$_INSTIT.")) ";
		
		if($_PERFIL==17){
		$sql_emp.=" and empleado.rut_emp=$_NOMBREUSUARIO ";
		}
		
		$sql_emp.= "ORDER BY ape_pat, ape_mat, nombre_emp asc, trabaja.cargo";
		
		//echo $sql_emp;
		
		$result_emp = @pg_exec($conn,$sql_emp); ?>
		<?php if($_PERFIL!=17){?>
      <div id="empe3">
        <select name="cmbEmpleado" id="cmbEmpleado">
          <option value="0">Seleccione...</option>
          <?php for($ee=0;$ee<pg_numrows($result_emp);$ee++){
		$fila_emp=pg_fetch_array($result_emp,$ee);?>
          <option value="<?php echo $fila_emp['rut_emp'] ?>" <?php echo ($fila_emp['rut_emp']==$fila['rutatendido'])?"selected":""?>><?php echo $fila_emp['ape_pat'] ?> <?php echo $fila_emp['ape_mat'] ?>,<?php echo $fila_emp['nombre_emp'] ?></option>
          <?php }?>
        </select>
    </div> 
      <?php } else {?>
   <?php   ?>
    <input name="cmbEmpleado" id="cmbEmpleado" type="hidden" value="<?php echo $_NOMBREUSUARIO ?>" />
    <?php echo pg_result($result_emp,2) ?>  <?php echo pg_result($result_emp,3) ?>  <?php echo pg_result($result_emp,4) ?>
    <?php }?>
    </td>
  </tr>
  <tr>
    <td class="cuadro02">MENSAJE</td>
    <td colspan="3" class="cuadro01"><textarea name="txtOBS" cols="70" rows="8" id="txtOBS"><?=$fila['motivo'];?></textarea></td>
  </tr>
</table>
<input type="hidden" id="id" name="id" value="<?=$fila['id_citacion'];?>" />
<br />


<?	
}

if($funcion==9){
	$result = $obj_citacion->Modifica($conn,$ano,$fecha,$hora,$asunto,$mensaje,$empleado,$id);
	
	if($result){
		echo 1;
	}else{
		echo 0;	
	}
}

if($funcion==10){
	
	$result = $obj_citacion->AgregaAsunto($conn,$_INSTIT,$nombre);	

	if($result){
		echo 1;
	}else{
		echo 0;	
	}

}
if($funcion==11){
	
	$result = $obj_citacion->asunto($conn,$_INSTIT);
?>
<select name="cmbASUNTOI" id="cmbASUNTOI">
    	<option value="0">seleccione...</option>
      <? for($i=0;$i<pg_numrows($result);$i++){
		  	$fila_a = pg_fetch_array($result,$i);
	  ?>
      	<option value="<?=$fila_a['id_asunto'];?>"><?=$fila_a['asunto'];?></option>
      <? } ?>
    </select>
<?		
}
//var_dump($_POST);

if($funcion==12){
	$rs_asunto = $obj_citacion->asunto($conn,$rdb);
	
?>	&nbsp;<!--onchange="listado();"-->
<select name="cmbASUNTO" id="cmbASUNTO"  >
    	<option	value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_asunto);$i++){
			$fila = pg_fetch_array($rs_asunto,$i);
?>
		<option value="<?=$fila['id_asunto'];?>"><?=$fila['asunto'];?></option>
        	
<?	
		}
?>
	</select>
<?
}

if($funcion==13){
	$rs_curso = $obj_citacion->curso($conn,$ano);
	
?>	&nbsp;
<select name="cmbCURSOI" id="cmbCURSOI" onchange="apoderadoI(this.value);">
    	<option	value="0">TODOS LOS CURSOS</option>
<? 		for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila = pg_fetch_array($rs_curso,$i);
?>
		<option value="<?=$fila['id_curso'];?>"><?=$fila['curso'];?></option>
        	
<?	
		}
?>
	</select>
<?
}

if($funcion==14){
	
	
?> &nbsp;
<select name="cmbAPODERADOI" id="cmbAPODERADOI">
    	
 <?       if($curso!=0){?>
	 <option value="0">TODOS LOS APODERADOS</option>
     <?
	 $rs_apoderado = $obj_citacion->Apoderado2($conn,$curso);
 		for($i=0;$i<pg_numrows($rs_apoderado);$i++){
			$fila = pg_fetch_array($rs_apoderado,$i);
?>
		<option value="<?=$fila['rut_apo'];?>"><?=$fila['nombre_apo'];?> <?=$fila['ape_pat'];?> <?=$fila['ape_mat'];?> (<?=strtoupper($fila['nombre_alu']." ".$fila['patalu']." ".$fila['matalu'])?>)</option>
<?	
}} else{?>
<option value="0">TODOS LOS APODERADOS</option>
	<?
    }
   ?>

</select>
 <?      	
}

if($funcion==15){
$rs_cambiaestado=$obj_citacion->cambiaEstado($conn,$id,$est);
if($rs_cambiaestado){
		echo 1;
	}else{
		echo 0;	
	}
}

?>