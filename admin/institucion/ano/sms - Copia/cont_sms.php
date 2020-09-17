<?
require('../../../../util/header.php');

$funcion=$_POST['funcion'];

require "mod_sms.php";
$ob_sms = new Sms();


if($funcion==0){
$rs_hab = $ob_sms->tengoSMS($connection,$rbd);
if(pg_result($rs_hab,0)!=15){
echo 0;	
 }
 else{
	echo 1;
	}
}

if($funcion==1){
	$rs_curso = $ob_sms->Curso($conn,$_ANO);
	?>
   <select name="cmbCURSO" id="cmbCURSO" onChange="BuscaAlumno()">
        <option value="0">TODOS...</option>
        <? for($i=0;$i<pg_numrows($rs_curso);$i++){
                $fila_c=pg_fetch_array($rs_curso,$i);
        ?>
        <option value="<?=$fila_c['id_curso'];?>"><?=CursoPalabra($fila_c['id_curso'],0,$conn);?></option>
        <? } ?>
</select>
<?	
}
if($funcion==2){
	$rs_apoderado = $ob_sms->BuscaApoderado($conn,$curso,$alumno,$_ANO);
?>
<select name="cmbAPODERADO" id="cmbAPODERADO" onchange="Listado()">
<option value="0">TODOS...</option>
<? for($i=0;$i<pg_numrows($rs_apoderado);$i++){
		$fila=pg_Fetch_array($rs_apoderado,$i);
?>
	<option value="<?=$fila['rut_apo'].",".$fila['celular'];?>"><?=ucwords(strtolower($fila['nombre_apoderado']))." (".trim($fila['celular']).")";?></option>
<? } ?>
</select>

	<? 


}

if($funcion==4){
	echo $nro_ano = $ob_sms->Ano($conn,$_ANO);
}

if($funcion==5){
	
	$rs_apoderado = $ob_sms->BuscaApoderado($conn,$curso,$alumno,$_ANO);
	for($i=0;$i<pg_numrows($rs_apoderado);$i++){
		$fila =pg_fetch_array($rs_apoderado,$i);
		//echo "<br>".strlen(trim($fila['celular']));
		if(strlen(trim($fila['celular']))==9){
			if(($i % 5)==0){
				sleep(1);
				$var=1;
			}
			$celular=trim($fila['celular']);
			$rs_mensaje = $ob_sms->GuardaSMS($conn,$_ANO,$curso,$alumno,$fila['rut_apo'],$mensaje,$celular,$_INSTIT,$motivo);
			
			if($rs_mensaje){
				require_once('funcion_sms.php');
				$respuesta = Envio_SMS($celular,$mensaje);
				$codigo = explode("_",$respuesta);
				//$codigo = array("09faf3c6-a64b-41e7-ad48-a652fa6c0248","0");
				$rs_sms = $ob_sms->ModificaSMS($conn,$rs_mensaje,$codigo[0],$codigo[1]);
				$rs_sms = $ob_sms->descuentaSms($conn,$_INSTIT);
				
				$var = 1;
				
			}else{
				$var=0;
			}
		}
	}
	echo 1;
}

if($funcion==6){
	?>
	<table width="100%" border="0">
  <tr>
    <td>MOTIVO</td>
    <td><input name="txtMOTIVO" id="txtMOTIVO" type="text" size="10" maxlength="30" /></td>
  </tr>
</table>
<?	
}

if($funcion==7){
	$result = $ob_sms->AgregarMotivo($conn,$motivo,$_INSTIT);
	
	if($result){
		echo 1;
	}else{
		echo 0;	
	}
}

if($funcion==8){
	$rs_motivo = $ob_sms->Motivo($conn,$_INSTIT);
?>
	<select name="cmbMOTIVO" id="cmbMOTIVO" onchange="Listado()">
    	<option value="0">seleccione...</option>
<? 
	for($i=0;$i<pg_numrows($rs_motivo);$i++){
		$fila = pg_Fetch_array($rs_motivo,$i);
?>
	<option value="<?=$fila['id_motivo'];?>"><?=$fila['nombre'];?></option>
<? } ?>

    </select>	
<?
}

if($funcion==9){
	$rs_alumno = $ob_sms->Alumno($conn,$curso,$_ANO);
?>
	<select id="cmbALUMNO" name="cmbALUMNO" onchange="BuscaApoderado()">
    	<option value="0">TODOS...</option>
<?
	for($i=0;$i<pg_numrows($rs_alumno);$i++){
		$fila = pg_fetch_array($rs_alumno,$i);
?>
	<option value="<?=$fila['rut_alumno'];?>"><?=$fila['nombre_alumno'];?></option>
<? }
?>

    </select>	
	
<?		
			
}

if($funcion==10){
	$rs_listado =$ob_sms->Listado($conn,$curso,$alumno,$apoderado,$_ANO,$motivo);

?>
<table width="650" border="1" style="border-collapse:collapse" align="center">
  <tr class="cuadro02">
    <td width="60">&nbsp;FECHA</td>
    <td width="87">&nbsp;CURSO</td>
    <td width="121">&nbsp;ALUMNO</td>
    <td width="147">&nbsp;APODERADO</td>
    <td width="92">&nbsp;MOTIVO</td>
    <td width="103">&nbsp;OPCIONES</td>
  </tr>
  
  <?  if(pg_numrows($rs_listado)==0){ ?>
	<tr class="cuadro01">  
	    <td colspan="6">Sin registros</td>
    </tr>
  <? }else{
	  
	  for($i=0;$i<pg_numrows($rs_listado);$i++){
		  $fila = pg_Fetch_array($rs_listado,$i);
	?>
	<tr class="cuadro01">
        <td>&nbsp;<?=$fila['fecha_envio'];?></td>
        <td>&nbsp;<? echo CursoPalabra($fila['id_curso'],1,$conn);?></td>
        <td>&nbsp;<?=$fila['nombre_alumno'];?></td>
        <td>&nbsp;<?=$fila['nombre_apoderado'];?></td>
        <td>&nbsp;<?=$fila['nombre_motivo'];?></td>
        <td><a href="#"><img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Comment.png" width="24" height="24" title="Vista Previa"  onclick="VistaPrevia(<?=$fila['id_sms'];?>)"/><img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Profile.png" width="24" height="24" title="Estadistica SMS" onclick="Estadistica(<?=$fila['rut_alumno'];?>)"/>
        <? if($fila['estado']==0){?>
        <img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/OK.png" width="20" height="20" />
        <? }else{?>
        <img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/NO.png" width="20" height="20" onclick="ValidaSMS(<?=$fila['id_sms'];?>)" />
        <? } ?>
        </a></td>
    </tr>
    <? }
  } ?>
  
</table>

<?	
}

if($funcion==11){
	

?>
<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td class="cuadro02">&nbsp;Cantidad de Caracteres</td>
	<td class="cuadro01">&nbsp;<input type="text" name="caracteres" id="caracteres" size="4"> de 160</td>
  </tr>
  <tr>
    <td class="cuadro02">&nbsp;MENSAJE</td>
	<td class="cuadro01">&nbsp;<textarea name="txtSMS" id="txtSMS" cols="50" rows="10"  onKeyDown="valida_longitud()" onKeyUp="valida_longitud()" ></textarea></td>
  </tr>
   <tr>
    <td class="cuadro02">&nbsp;NOTA</td>
	<td class="cuadro01">&nbsp;Se debe ingresar el texto sin &Ntilde;, tildes, ni caracteres especiales. Solo esta permitido el @</td>
  </tr>
</table>
<br />

<?	
}

if($funcion==12){
	$rs_sms =$ob_sms->VistaPrevia($conn,$id);
	$fila = pg_fetch_array($rs_sms,0);
	require_once('funcion_sms.php');
	$estado = $fila['estado'];
	/*$respuesta = EstadoMsg($fila['clave']);
	if($respuesta){
	$ob_sms->Recepcion($conn,$id,$respuesta);	
	}*/
	/*//$id= "c43bd33c-548d-4ddd-9002-c44f9ab289b1";
		$id = $codigo[0];
		
		$cestado = ;*/
	
?>
<table width="500" border="1" style="border-collapse:collapse">
  <tr>
    <td width="132" class="cuadro02">A&Ntilde;O</td>
    <td colspan="3" class="cuadro01">&nbsp;<?=$fila['nro_ano'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">CURSO</td>
    <td colspan="3" class="cuadro01">&nbsp;<?=CursoPalabra($fila['id_curso'],0,$conn);;?></td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO</td>
    <td colspan="3" class="cuadro01">&nbsp;<?=$fila['nombre_alumno'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">APODERADO</td>
    <td colspan="3" class="cuadro01">&nbsp;<?=$fila['nombre_apoderado'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">TELEFONO</td>
    <td colspan="3" class="cuadro01">&nbsp;<?=$fila['nro_telefono'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">MOTIVO</td>
    <td colspan="3" class="cuadro01">&nbsp;<?=$fila['nombre'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">ESTADO</td>
    <td width="148" class="cuadro01">
      <?php 
	switch($fila['estado']){
	case 0: $estado = "Enviado Correctamente"; break;
	case 1: $estado = "Error de par&aacute;metros ingresados"; break;
	case 2: $estado = "Usuario o contrase&ntilde;a incorrecto"; break;
	case 3: $estado = "Sin cr&eacute;ditos disponibles"; break;
	case 4: $estado = "Numero desinscrito"; break;
	case 5: $estado = "SMS por segundo superado"; break;
	case 10: $estado = "Mensaje sin enviar"; break;
	}?>
	&nbsp;<?=$estado;?></td>
    <td width="44" class="cuadro02">RECEPCION</td>
    <td width="148" class="cuadro01">&nbsp;<?=$fila['fecha_recepcion'];?></td>
  </tr>
  <tr>
    <td class="cuadro02">MENSAJE</td>
    <td colspan="3" class="cuadro01">&nbsp;<?=$fila['mensaje'];?></td>
  </tr>
</table>


<?	
}

if($funcion==13){
	$mes = date("m");
	$result = $ob_sms->Estadistica($conn,$rut,$_ANO,$mes);
	$fila = pg_fetch_array($result,1);
	$alafecha = $fila['cantidad'];
	$fila = pg_fetch_array($result,0);
	$almes= $fila['cantidad'];

	
?>
<table width="400" border="0">
  <tr>
    <td class="cuadro02">A la fecha</td>
    <td class="cuadro01"><?=$alafecha;?></td>
  </tr>
  <tr>
    <td class="cuadro02">En el mes</td>
    <td class="cuadro01"><?=$almes;?></td>
  </tr>
  <tr>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
</table>


<?		
}

if($funcion==14){
	$rs_sms =$ob_sms->VistaPrevia($conn,$id);
	$fila = pg_fetch_array($rs_sms,0);
	require_once('funcion_sms.php');
	$estado = $fila['estado'];
	$dato_sms = EstadoMsg($fila['clave']);
	
	if($estado!=0){
		$dato = split("_",$dato_sms);
		$result = $ob_sms->ModificaEstado($conn,$id,$dato[0],$dato[1]);	
	}
	
	if($result){
		echo $dato[1];	
	}else{
		echo "error";	
	}
}
if($funcion==15){
?>
<div align="center">
<p class="textonegrita">Estimado Usuario:</p>
<p class="textonegrita">

  Su instituci&oacute;n no tiene habilitada la opci&oacute;n de enviar SMS.</p>
<p class="textonegrita"> Si desea obtener esta funcionalidad, cont&aacute;ctenos al (56) 22 829 3350</p>
<p class="textonegrita">

  o al mail <a href="mailto:info@colegiointeractivo.com">info@colegiointeractivo.com</a></p>
</div>
<?	
}
if($funcion==16){
	$rs_con = $ob_sms->saldoSMS($conn,$_INSTIT);
	$rs_mat = $ob_sms->cuentaMAT($conn,$_ANO);
	//echo "saldo=".pg_result($rs_con,5);
	//echo "matricula=".pg_result($rs_mat,0);
	if(pg_numrows($rs_con)>0){
	echo pg_result($rs_con,5)."_".pg_result($rs_con,2)."_".pg_result($rs_mat,0)."_".pg_result($rs_con,4)."_".pg_result($rs_con,0);
	}else{
	echo 999;	
	}
	
}
if($funcion==17){
$result = $ob_sms->caducaBolsa($conn,$ic);
if($result){
		echo 1;	
	}else{
		echo 0;	
	}
}
?>

