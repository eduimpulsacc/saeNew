<?php 
require("../../util/header.php");
require("modelo.php");

$funcion=$_POST['funcion'];
$ob_solicitud = new Requerimiento();

if($funcion==1){
	
	$rs_listado = $ob_solicitud->ListadoSolicitudes($connection,$_PERFIL,$_NOMBREUSUARIO,$rdb,$solicitante,$colegio,$tipo);
	
?><table width="850" border="0">
  <tr>
    <td align="right"><a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" alt="AGREGAR" onClick="Agregar()"></a></td>
  </tr>
  <tr>
    <td><table width="850" border="1" style="border-collapse:collapse">
  <tr class="cuadro02">
    <td>ID</td>
    <td align="center">RDB</td>
    <td align="center">CLIENTE</td>
    <td align="center">ESTADO</td>
    <td align="center">ETAPA</td>
    <td align="center">SOLICITANTE</td>
    <td align="center">FECHA <br>
      INGRESO</td>
    <td align="center">OPCIONES</td>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_listado);$i++){
	  	$fila = pg_fetch_array($rs_listado,$i);
 ?>
  <tr>
    <td class="textosimple">&nbsp;<?=$fila['id_solicitud'];?></td>
    <td class="textosimple">&nbsp;<?=$fila['rdb'];?></td>
    <td class="textosimple">&nbsp;<?=utf8_decode($fila['nombre_instit']);?></td>
    <td class="textosimple">&nbsp;<?=$fila['nom_estado'];?></td>
    <td class="textosimple">&nbsp;<?=$fila['nom_tipo'];?></td>
    <td class="textosimple">&nbsp;<?=$fila['nombre'];?></td>
    <td class="textosimple">&nbsp;<?=$fila['fecha'];?></td>
    <td class="textosimple">
    <a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/edit.png" width="24" height="24" title="EDITAR" onclick="Modificar(<?=$fila['id_solicitud'];?>)" /></a>&nbsp;
   
    <? if($fila['estado']!=5){?>
    <a href="carhgafile/index.php?icls=<?php echo $fila['id_solicitud'] ?>" onClick="window.open(this.href, this.target, 'width=600,height=300'); return false;">
    <img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Load.png" width="24" height="24" title="SUBIR ARCHIVO"  />&nbsp; </a>
    <? } ?>
   
    <? if($_PERFIL==62){?>
    <a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Delete.png" width="24" height="24" title="ELIMINAR" onclick="Eliminar(<?=$fila['id_solicitud'];?>)" /></a>
    <? } ?>
     <? if($fila['estado']==5){?>
    <img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/OK.png" width="24" height="24" />
<? } ?>
    </td>
  </tr>
  <? } ?>
</table></td>
  </tr>
</table>

<?	
	
}

if($funcion==2){
	$rs_personal = $ob_solicitud->Asignacion($connection);
	$rs_tipo = $ob_solicitud->Tipo($connection);
	$rs_personal_asg = $ob_solicitud->PersonalAsignado($connection,$_NOMBREUSUARIO);
	$rs_sistema =$ob_solicitud->Sistemas($connection);
	$rs_medio	=$ob_solicitud->Medio($connection);
?>
<div align="right"><a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Load.png" width="24" height="24"  title="GUARDAR" onClick="GuardaSolicitud();"/></a><a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Back.png" width="24" height="24" title="VOLVER" onclick="listado();" /></a><br />
&nbsp;</div>
<table width="850" border="1" style="border-collapse:collapse">
  <tr>
    <td width="172" class="cuadro02">RDB</td>
    <td width="165" class="cuadro01"><label for="txtRDB"></label>
    <input name="txtRDB" type="text" id="txtRDB" size="10" onblur="BuscaColegio()"></td>
    <td width="8" rowspan="5" class="cuadro02">&nbsp;</td>
    <td width="171" class="cuadro02">COLEGIO</td>
    <td width="300" class="cuadro01"><input name="txtCOLEGIO" type="text" id="txtCOLEGIO" size="50"></td>
  </tr>
  <tr>
    <td class="cuadro02">FECHA INGRESO</td>
    <td class="cuadro01">
    <input type="text" name="txtFECHA" id="txtFECHA" value="<?=date("d-m-Y");?>"  size="10" /></td>
    <td class="cuadro02">SOLICITANTE</td>
    <td class="cuadro01">
    <? if($_PERFIL==63){
			echo pg_result($rs_personal_asg,0);
	?>
    	<input type="hidden" id="cmbSOLICITANTE" value="<?=$_NOMBREUSUARIO;?>" />
     <?					
	}else{?>
		
     <select id="cmbSOLICITANTE" name="cmbSOLICITANTE">
        <option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_personal);$i++){
				$fila = pg_Fetch_array($rs_personal,$i);
		?>
        <option value="<?=$fila['rut_soporte'];?>" <? echo ($fila['rut_soporte']==$_NOMBREUSUARIO)?"selected":"";?> ><?=$fila['nombre'];?></option>
        <?	
		}
		?>
      </select>
      <? } ?>
    </td>
  </tr>
  <tr>
    <td class="cuadro02">SISTEMA</td>
    <td class="cuadro01">
    <select id="cmbSISTEMA">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_sistema);$i++){
			$fila_s = pg_fetch_array($rs_sistema,$i);
		?>
        <option value="<?=$fila_s['id_sistema'];?>"><?=$fila_s['nombre'];?></option>
        <? } ?>	
    </select>
    </td>
    <td class="cuadro02">MEDIO ENTRADA</td>
    <td class="cuadro01">
    <select id="cmbMEDIO">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_medio);$i++){
			$fila_m = pg_fetch_array($rs_medio,$i);
		?>
        	<option value="<?=$fila_m['id_medio'];?>"><?=$fila_m['nombre'];?></option>
		<? } ?>
    </select>
    </td>
  </tr>
  <? if($_PERFIL!=63){?>
  <tr>
    <td class="cuadro02">ASIGNADO</td>
    <td class="cuadro01">
      <select id="cmbPERSONAL" name="cmbPERSONAL">
        <option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_personal);$i++){
				$fila = pg_Fetch_array($rs_personal,$i);
		?>
        <option value="<?=$fila['rut_soporte'];?>"><?=$fila['nombre'];?></option>
        <?	
		}
		?>
      </select>
    </td>
    <td class="cuadro02">TIPO</td>
    <td class="cuadro01">
      <select id="cmbTIPO" name="cmbTIPO">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_tipo);$i++){
				$fila = pg_Fetch_array($rs_tipo,$i);
		?>
        <option value="<?=$fila['id_tipo'];?>"><?=$fila['nombre'];?></option>
        <?	
		}
		?>
     </select></td>
  </tr>
  <tr>
    <td class="cuadro02">ESTADO</td>
    <td class="cuadro01">
      <select name="cmbESTADO" id="cmbESTADO">
        <option value="0">seleccion...</option>
        <option value="1">APROBADO</option>
        <option value="2">EN DESARROLLO</option>
        <option value="3">RECHAZADO</option>
        <option value="4">TERMINADO</option>
      </select>
    </td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <? } ?>
  <tr>
    <td colspan="5" class="cuadro02">OBSERVACIONES</td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;</td>
    <td colspan="4" class="cuadro01">&nbsp;<textarea name="txtOBS" id="txtOBS" cols="50" rows="10"></textarea></td>
  </tr>
</table>

<?	
}


if($funcion==3){
	$rs_institucion = $ob_solicitud->BuscaColegio($conn,$rdb);
	$fila =pg_fetch_array($rs_institucion,0);
	echo $datos = trim($fila['nombre_instit']).",".trim($fila['rdb']);
	return $datos;		
}

if($funcion==4){
	$rs_guardar = $ob_solicitud->GuardaSolicitud($connection,$rdb,$colegio,$fecha,$solicitante,$obs,$sistema,$medio);
	
	if($rs_guardar){
		echo 1;
	}else{
		echo 0;
	}	
	
}

if($funcion==5){
	$rs_personal 	= $ob_solicitud->Asignacion($connection);
	$rs_tipo 		= $ob_solicitud->Tipo($connection);
	$rs_estado 		= $ob_solicitud->Estado($connection);
	$rs_sol 		= $ob_solicitud->Solicitud($connection,$id);
	$fila 			= pg_fetch_array($rs_sol,0);
	$rs_asignado	= $ob_solicitud->PersonalAsignado($connection,$fila['rut_asignado']);
	$rs_obs 		= $ob_solicitud->Observaciones($connection,$id);
	$rs_archivo		= $ob_solicitud->BuscaArchivos($connection,$id);
?>
<div align="right">
<? if($_PERFIL==62){?>
<A href="#">
<img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Load.png" width="24" height="24"  title="GUARDAR" onClick="AsignaSolicitud(<?=$id;?>);"/></A>
<? } ?>
<a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Back.png" width="24" height="24" title="VOLVER" onclick="listado();" /></a><br />&nbsp;</div>
<table width="850" border="1" style="border-collapse:collapse">
  <tr>
    <td width="172" class="cuadro02">RDB</td>
    <td width="165" class="cuadro01"><?=$fila['rdb'];?></td>
    <td width="10" rowspan="4" class="cuadro02">&nbsp;</td>
    <td width="169" class="cuadro02">COLEGIO</td>
    <td width="300" class="cuadro01"><?=utf8_decode($fila['nombre_instit']);?></td>
  </tr>
  <tr>
    <td class="cuadro02">FECHA INGRESO</td>
    <td class="cuadro01"><? impF($fila['fecha']);?></td>
    <td class="cuadro02">SOLICITANTE</td>
    <td class="cuadro01"><?=$fila['nombre'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">SISTEMA</td>
    <td class="cuadro01"><?=$fila['sistema'];?></td>
    <td class="cuadro02">MEDIO</td>
    <td class="cuadro01"><?=$fila['medio'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">ASIGNADO</td>
    <td class="cuadro01">
    <? if($_PERFIL==63){
			echo pg_result($rs_asignado,0);
	}else{?>
      <select id="cmbPERSONAL" name="cmbPERSONAL">
        <option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_personal);$i++){
				$fila_p = pg_Fetch_array($rs_personal,$i);
				if($fila['rut_asignado']==$fila_p['rut_soporte']){
		?>
        		<option value="<?=$fila_p['rut_soporte'];?>" selected="selected"><?=$fila_p['nombre'];?></option>
        <?	
				}else{
		?>
                <option value="<?=$fila_p['rut_soporte'];?>"><?=$fila_p['nombre'];?></option>
         <?     
              }			
		}
	
		?>
      </select>
      <? } ?>
    </td>
    <td class="cuadro02">TIPO</td>
    <td class="cuadro01">
    <? if($_PERFIL==63){
			echo $fila['nom'];
	}else{?>
      <select id="cmbTIPO" name="cmbTIPO">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_tipo);$i++){
				$fila_t = pg_Fetch_array($rs_tipo,$i);
				if($fila['id_tipo']==$fila_t['id_tipo']){
		?>
       			 <option value="<?=$fila_t['id_tipo'];?>" selected="selected"><?=$fila_t['nombre'];?></option>
        <?	
				}else{
		?>
                <option value="<?=$fila_t['id_tipo'];?>"><?=$fila_t['nombre'];?></option>
        <?	
				}
		}
		?>
     </select>
     <? } ?>
    </td>
  </tr>
  <? if($_PERFIL!=63){?>
  <tr>
    <td class="cuadro02">ESTADO</td>
    <td class="cuadro01">
      <select name="cmbESTADO" id="cmbESTADO">
        <option value="0">seleccion...</option>
       <? for($i=0;$i<pg_numrows($rs_estado);$i++){
		   	$fila_e = pg_fetch_array($rs_estado,$i);
			if($fila['estado']==$fila_e['id_estado']){
		?>	
				<option value="<?=$fila_e['id_estado'];?>" selected="selected"><?=$fila_e['nombre'];?></option>
        <?	}else{?>
				<option value="<?=$fila_e['id_estado'];?>"><?=$fila_e['nombre'];?></option>
         <? }
	   }?>
      </select>
    </td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <? } ?>
  <tr>
    <td class="cuadro02">ARCHIVOS</td>
    <td colspan="4" class="cuadro01">
    <? for($v=0;$v<pg_numrows($rs_archivo);$v++){
			$fila_ar = pg_fetch_array($rs_archivo,$v);
			$numero = $v + 1;
	?>
    	<a href="acv/<?=$fila_ar['nombre_archivo'];?>"><? echo $numero.".- ".$fila_ar['nombre_archivo'];?></a><br />

    <?
	}
    ?>
    </td>
  </tr>
  
  <tr>
    <td colspan="5" class="cuadro02">OBSERVACIONES
    <? if($fila['estado']!=5){?>
    <a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" title="AGREGAR COMENTARIO" onclick="AgregarComentario(<?=$fila['id_solicitud'];?>)" /></a>
    <? } ?>
    </td>
  </tr>
  <tr>
    <td colspan="5" class="cuadro02"><table width="100%" border="0" cellpadding="5">
      <tr>
        <td width="10%">FECHA</td>
        <td width="14%">PERSONA</td>
        <td width="63%">OBSERVACIONES</td>
        <td width="13%">ESTADO</td>
      </tr>
      <tr>
        <td class="cuadro01">&nbsp;<?=$fila['fecha'];?></td>
        <td class="cuadro01">&nbsp;<?=$fila['nombre'];?></td>
        <td class="cuadro01">&nbsp;<?=$fila['observaciones'];?></td>
        <td class="cuadro01">&nbsp;<?=$fila['nom_estado'];?></td>
      </tr>
      
      <? for($x=0;$x<pg_numrows($rs_obs);$x++){
		  	$fila_obs = pg_fetch_array($rs_obs,$x);
	  ?>
		  	
      <tr>
        <td class="cuadro01">&nbsp;<?=$fila_obs['fecha'];?></td>
        <td class="cuadro01">&nbsp;<?=$fila_obs['nombre'];?></td>
        <td class="cuadro01">&nbsp;<?=$fila_obs['obs'];?></td>
        <td class="cuadro01">&nbsp;<?=$fila_obs['estado'];?></td>
      </tr>
      <? } ?>
    </table></td>
  </tr>
  
</table>

<?	
}

if($funcion==6){
	$rs_asigna = $ob_solicitud->AsignaSolicitud($connection,$id,$estado,$rut,$tipo);
	
	if($rs_asigna){
		echo 1;	
	}else{
		echo 0;
	}
}

if($funcion==7){
	
	?>
	<table width="100%" border="0">
	<tr>
    <td width="20%" class="textonegrita">ESTADO</td>
    <td width="2%" class="textonegrita">:</td>
    <td width="78%">
    	<select id="cmbESTADO2" class="textosimple">
        	<option value="0">seleccion...</option>
            <option value="1">APROBADO</option>
            <option	value="2">RECHAZADO</option>
        </select>            
    </td>
  </tr>
  <tr>
    <td class="textonegrita">OBSERVACIONES</td>
    <td class="textonegrita">:</td>
    <td><textarea name="txtOBS" id="txtOBS" cols="45" rows="5"></textarea></td>
  </tr>
</table>
<?
}
if($funcion==8){
	$rs_obs = $ob_solicitud->AgregaObs($connection,$id,$_NOMBREUSUARIO,$estado,1,$obs);
	
	if($rs_obs){
		echo 1;	
	}else{
		echo 0;
	}
}
if($funcion==9){
	$rs_sol = $ob_solicitud->CantidadSolicitudes($connection);
	$rs_asignacion = $ob_solicitud->Asignacion($connection);
	$rs_tipo = $ob_solicitud->Tipo($connection);
	$rs_colegio = $ob_solicitud->ListadoColegio($connection);
?>
<table width="95%" border="1" style="border-collapse:collapse" align="center"> 
  <tr class="cuadro02">
    <td>&nbsp;ESTADO</td>
    <td align="center">&nbsp;CANTIDAD</td>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_sol);$i++){
	  	$fila= pg_fetch_array($rs_sol,$i);
  ?>
  <tr>
    <td class="textosimple">&nbsp;<?=$fila['nombre'];?></td>
    <td class="textosimple" align="center">&nbsp;<?=$fila['cantidad'];?></td>
  </tr>
  <? } ?>
</table>
<br />
<br />
<table width="95%" border="1" style="border-collapse:collapse" align="center" cellpadding="3">
  <tr>
    <td colspan="2" class="cuadro02">BUSCADOR</td>
  </tr>
  <fieldset> 
  <tr>
    <td width="25%" class="textosimple">&nbsp;RDB</td>
    <td width="75%">
    <input type="text" name="txtRDB2" id="txtRDB2" /></td>
  </tr>
  <tr>
    <td class="textosimple">COLEGIO</td>
    <td>
    
    <select id="cmbCOLEGIO" >
    	<option	value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_colegio);$i++){
				$fila_col = pg_fetch_array($rs_colegio,$i);
		?>
        	<option value="<?=$fila_col['rdb'];?>"><?=$fila_col['nombre_instit'];?></option>
        <?    	
		}
        ?>
    </select>
    
    </td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;SOLICITANTE</td>
    <td><select id="cmbSOLICITANTE2">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_asignacion);$i++){
				$fila_s = pg_fetch_array($rs_asignacion,$i);
		?>
        	<option	value="<?=$fila_s['rut_soporte'];?>"><?=$fila_s['nombre'];?></option>
        <? } ?>
            
    </select>
    </td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;ESTADO</td>
    <td><select id="cmbTIPO2">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_tipo);$i++){
				$fila_t = pg_fetch_array($rs_tipo,$i);
		?>
        	<option value="<?=$fila_t['id_tipo'];?>"><?=$fila_t['nombre'];?></option>	
		
		<? } ?>
    </select></td>
  </tr>
  </fieldset>
  <tr>
    <td colspan="2" align="right">
    <a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Search.png" width="24" height="24"  title="BUSCAR" onclick="listado();"/></a>    
    <a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Exit.png" width="24" height="24" onclick="Limpiar();"  title="LISTAR TODO"/></a>
    </td>
  </tr>
</table>
<br />
<br />
<table width="95%" border="1" style="border-collapse:collapse" align="center">
  <tr>
    <td class="cuadro02">&nbsp;LISTAR PERFILES</td>
    <td align="center"><a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Profile.png" width="24" height="24" title="LISTAR PERFILES"  onclick="window.location='../../session/listarPerfiles.php'" /></a>
    </td>
  </tr>
  <tr>
    <td class="cuadro02">&nbsp;CERRAR SESION</td>
    <td align="center"><a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Exit.png" width="24" height="24" title="CERRAR SESION" onclick="window.location='../../menu/salida.php'" /></a></td>
  </tr>
</table>



<?	
}

if($funcion==10){
	$rs_elimina = $ob_solicitud->EliminaSolicitud($connection,$id);
	
	if($rs_elimina){
		echo 1;	
	}else{
		echo 0;
	}
}
?>
