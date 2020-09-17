<?
require('../../../../util/header.php');

$funcion=$_POST['funcion'];

require "mod_sms.php";
$ob_sms = new Sms();


if($funcion==0){
$rs_hab = $ob_sms->tengoSMS($connection,$rbd);
$rs_com = $ob_sms->tengoComu($connection,$rbd);
if(pg_result($rs_hab,0)!=15 && pg_result($rs_com,0)!=17 ){
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
<select name="cmbAPODERADO" id="cmbAPODERADO" >
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
	if($_PERFIL==0){
	//show($_POST);
	}
	
	if($_INSTIT==9088){
		$rs_directivo = $ob_sms->ArmaGrupo($conn,480);
		for($d=0;$d<pg_numrows($rs_directivo);$d++){
			$filad =pg_fetch_array($rs_directivo,$d);
			if(strlen(trim($filad['celular']))==9){
			if(($i % 5)==0){
				sleep(1);
				$var=1;
			}
			$celular=trim($filad['celular']);
			$rs_mensaje = $ob_sms->GuardaSMS2($conn,$_ANO,0,0,$filad['rint'],sanear_string($mensaje),$celular,$_INSTIT,$motivo,$filad['tipo']);
			
			if($rs_mensaje){
				require_once('funcion_sms.php');
				$respuesta = Envio_SMS($celular,sanear_string($mensaje));
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
		
		
	}
	
	
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
			$rs_mensaje = $ob_sms->GuardaSMS($conn,$_ANO,$curso,$alumno,$fila['rut_apo'],sanear_string($mensaje),$celular,$_INSTIT,$motivo);
			
			if($rs_mensaje){
				require_once('funcion_sms.php');
				$respuesta = Envio_SMS($celular,sanear_string($mensaje));
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
	<select name="cmbMOTIVO" id="cmbMOTIVO" >
    	<option value="0">seleccione...</option>
<? 
	for($i=0;$i<pg_numrows($rs_motivo);$i++){
		$fila = pg_Fetch_array($rs_motivo,$i);
?>
	<option value="<?=$fila['id_motivo'];?>"><?=utf8_decode($fila['nombre']);?></option>
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
	//$rs_listado =$ob_sms->Listado($conn,$curso,$alumno,$apoderado,$_ANO,$motivo);
	//show($_POST);

	$tabla=($via==1)?"sms":"sms_comu";
	$fec=($via==1)?"fecha_envio":"fecha";
	
	$desde=($desde!=1)?CambioFE($desde):"";
	$hasta=($hasta!=1)?CambioFE($hasta):"";
	
	

	$rs_listado = $ob_sms->ListadoNew($conn,$_ANO,$motivo,$desde,$hasta,$tabla,$fec,$via,$modulo);

?>

<link rel="stylesheet" type="text/css" href="../../../clases/smartpaginator/smartpaginator.css">
<script src="../../../clases/smartpaginator/smartpaginator.js"></script>
<script>
 $(document).ready(function() {//pg_numrows($rs_listado)
 
               $('#green').smartpaginator({ totalrecords: <?php echo pg_numrows($rs_listado) ?>,

                                      recordsperpage: 30, 

                                      datacontainer: 'mt', 

                                      dataelement: 'tr',

                                      theme: 'red' });

        });
</script>
<style>
#green > ul{
width:260px;
}
</style>

<table width="650" border="1" style="border-collapse:collapse" align="center" id="mt">
 <tbody>
  <tr class="cuadro02 header">
    <th width="60">&nbsp;FECHA</th>
    <th width="87">&nbsp;CURSO</th>
    <th width="121">&nbsp;ALUMNO</th>
    <th width="147">&nbsp;APODERADO</th>
    <th width="92">&nbsp;MOTIVO</th>
    <th width="103">&nbsp;OPCIONES</th>
  </tr>
  
  
  
  <?  if(pg_numrows($rs_listado)==0){ ?>
	<tr class="cuadro01">  
	    <td colspan="6">Sin registros</td>
    </tr>
  <? }else{
	  
	  for($i=0;$i<pg_numrows($rs_listado);$i++){
		  $fila = pg_Fetch_array($rs_listado,$i);
		  
		  $campo = ($via==1)?$fila['id_sms']:$fila['id_comu'];
	?>
	<tr class="cuadro01">
        <td>&nbsp;<?=$fila[$fec];?></td>
        <td>&nbsp;<? echo CursoPalabra($fila['id_curso'],1,$conn);?></td>
        <td>&nbsp;<?=$fila['nombre_alumno'];?></td>
        <td>&nbsp;<?=$fila['nombre_apoderado'];?></td>
        <td>&nbsp;<?=utf8_decode($fila['nombre_motivo']);?></td>
        <td><a href="#"><img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Comment.png" width="24" height="24" title="Vista Previa"  onclick="VistaPrevia(<?=$campo?>)"/>
     
      <?php   if($fila['rut_alumno']!=0){?>
        <img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Profile.png" width="24" height="24" title="Estadistica SMS" onclick="Estadistica(<?=$fila['rut_alumno'];?>)"/>
        <?php }?>
       <?php  if($via==1){?>
        <? if($fila['estado']==0){?>
        <img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/OK.png" width="20" height="20" /> <? } else if($fila['estado']==1){?>
        <img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Warning.png" width="20" height="20" />
        <?php }else{?>
        <img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/NO.png" width="20" height="20"  />
        <? } ?>
        <?php }?>
        </a></td>
    </tr>
    <? }
  } ?>
  </tbody>
</table>
<?php if (pg_numrows($rs_listado)>0){ ?>
<br />
<br />

<div id="green" style="margin: auto;"> </div>

<?php }?>

<?	
}

if($funcion==11){
	

?>
<script>
 /* $('.tq').keyup(function (){
            this.value = (this.value + '').replace(/[^á]/g, /[^a]/g);			
          });*/



</script>
<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td class="cuadro02">&nbsp;Cantidad de Caracteres</td>
	<td class="cuadro01">&nbsp;<input type="text" name="caracteres" id="caracteres" size="4"> de 160</td>
  </tr>
  <tr>
    <td class="cuadro02">&nbsp;MENSAJE</td>
	<td class="cuadro01">&nbsp;<textarea name="txtSMS" id="txtSMS" cols="50" rows="10"  onKeyDown="valida_longitud(); " onKeyUp="valida_longitud();"  ></textarea></td>
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
	
	$rs_sms =$ob_sms->VistaPrevia($conn,$id,$via);
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
    <td colspan="3" class="cuadro01">&nbsp;<?=$fila['nro_ano'];
	
	
	?></td>
  </tr>
  <tr>
    <td class="cuadro02">CURSO</td>
    <td colspan="3" class="cuadro01">&nbsp;<?=CursoPalabra($fila['id_curso'],0,$conn);?></td>
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
	case 1: $estado = "Mensaje en espera de confirmaci&oacute;n"; break;
	case 2: $estado = "Mensaje no entregado o rechazado"; break;
	}?>
	&nbsp;<?=$estado;?></td>
    <td width="44" class="cuadro02">RECEPCION</td>
    <td width="148" class="cuadro01">&nbsp;<?=($fila['estado']==0)?$fila['fecha_recepcion']:"-";?></td>
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
	if($_SMS==0 && $_COMUNICAPP==0){
?>
<div align="center">
<p class="textonegrita">Estimado Usuario:</p>
<p class="textonegrita">

  Su instituci&oacute;n no tiene habilitado el servicio de mensajer&iacute;a.</p>
<p class="textonegrita"> Si desea obtener esta funcionalidad, cont&aacute;ctenos al (56) 2-324 11 860</p>
<p class="textonegrita">

  o al mail <a href="mailto:contacto@eduimpulsa.com">contacto@eduimpulsa.com</a></p>
</div>
<?	
	}
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
if($funcion==18){
$result = $ob_sms->Grupos($conn,$_INSTIT);
if($result){?>
		<select name="gdes" id="gdes" onChange="grupodes()">
        <option value="0">seleccione...</option>
        <?php for($g=0;$g<pg_numrows($result);$g++){
			$fila_g=pg_fetch_array($result,$g);?>
         <option value="<?php echo $fila_g['id_grupo'] ?>"><?php echo $fila_g['nombre'] ?></option>
         <?php }?>
        </select>
        <?
	}else{
		echo 0;	
	}
}
if($funcion==19){
//$result = $ob_sms->ArmaGrupo($conn,$grupo);
$result = $ob_sms->ArmaGrupo2($conn,$grupo,$_ANO);
if($result){?>
		<select name="desgrupo" id="desgrupo" >
        <option value="0">TODOS...</option>
        <?php for($g=0;$g<pg_numrows($result);$g++){
			$fila_g=pg_fetch_array($result,$g);?>
         <option value="<?php echo trim($fila_g['rint']) ?>,<?php echo trim($fila_g['celular']) ?>,<?php echo trim($fila_g['tipo']) ?>"><?php echo $fila_g['nombre_int'] ?> (<?php echo trim($fila_g['celular']) ?>)</option>
         <?php }?>
        </select>
        <?
	}else{
		echo 0;	
	}
}

if($funcion==4){
	 $nro_ano = $ob_sms->Ano($conn,$_ANO);
}

if($funcion==20){
	if($_PERFIL==0){
	show($_POST);	
	}
	
	if($_INSTIT==9088 && $grupo != 480){
		$rs_directivo = $ob_sms->ArmaGrupo($conn,480);
		for($d=0;$d<pg_numrows($rs_directivo);$d++){
			$filad =pg_fetch_array($rs_directivo,$d);
			if(strlen(trim($filad['celular']))==9){
			if(($i % 5)==0){
				sleep(1);
				$var=1;
			}
			$celular=trim($filad['celular']);
			$rs_mensaje = $ob_sms->GuardaSMS2($conn,$_ANO,0,0,$filad['rint'],sanear_string($mensaje),$celular,$_INSTIT,$motivo,$filad['tipo']);
			
			
			
			if($rs_mensaje){
				require_once('funcion_sms.php');
				$respuesta = Envio_SMS($celular,sanear_string($mensaje));
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
		
		
	}
	
	if($usuario==0){
	
	//$rs_apoderado = $ob_sms-> ArmaGrupo($conn,$grupo);
	$rs_apoderado = $ob_sms-> ArmaGrupo2($conn,$grupo,$_ANO);
	
	
	for($i=0;$i<pg_numrows($rs_apoderado);$i++){
		$fila =pg_fetch_array($rs_apoderado,$i);
		//echo "<br>".strlen(trim($fila['celular']));
		if(strlen(trim($fila['celular']))==9){
			if(($i % 5)==0){
				sleep(1);
				$var=1;
			}
			 $celular=trim($fila['celular']);
			$rs_mensaje = $ob_sms->GuardaSMS2($conn,$_ANO,0,0,$fila['rint'],sanear_string($mensaje),$celular,$_INSTIT,$motivo,$fila['tipo']);
			
			if($rs_mensaje){
				require_once('funcion_sms.php');
				$respuesta = Envio_SMS($celular,sanear_string($mensaje));
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
	
	}
	else{
		$dusuario = explode(",",$usuario);
		 $celular=trim($dusuario[1]);
		$rs_mensaje = $ob_sms->GuardaSMS2($conn,$_ANO,0,0,$dusuario[0],sanear_string($mensaje),$celular,$_INSTIT,$motivo,$dusuario[1]);
			
			if($rs_mensaje){
				require_once('funcion_sms.php');
				$respuesta = Envio_SMS($celular,sanear_string($mensaje));
				$codigo = explode("_",$respuesta);
				//$codigo = array("09faf3c6-a64b-41e7-ad48-a652fa6c0248","0");
				$rs_sms = $ob_sms->ModificaSMS($conn,$rs_mensaje,$codigo[0],$codigo[1]);
				$rs_sms = $ob_sms->descuentaSms($conn,$_INSTIT);
				
				$var = 1;
				
			}else{
				$var=0;
			}
		
	}
	
	
	echo 1;
}
if($funcion==21){
//show($_POST);
$rs_motivo = $ob_sms->Motivo($conn,$_INSTIT);
?>
<script type="text/javascript" src="../../../clases/jquery-ui-1.8.14.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script>
$( document ).ready(function() {
   // $('#fechaval').datepicker({title:'Test Dialog'});
   	$("#fechaval").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			/*minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),*/
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
});

  </script>
<table border="0">
  <tr>
    <td>Fecha </td>
    <td>:</td>
    <td><input type="text" name="fechaval" id="fechaval" readonly="readonly" /></td>
  </tr>
  <tr>
    <td>Asunto</td>
    <td>:</td>
    <td>

	<select name="tipoval" id="tipoval">
    	<option value="0">seleccione...</option>
<? 
	for($i=0;$i<pg_numrows($rs_motivo);$i++){
		$fila = pg_Fetch_array($rs_motivo,$i);
?>
	<option value="<?=$fila['id_motivo'];?>"><?=$fila['nombre'];?></option>
<? } ?>

    </select>	</td>
  </tr>
</table>
<?	
}
if($funcion==22){
//show($_POST);
$fecha=CambioFE($fecha);
//$fecha='2017-04-27';
require_once('funcion_sms.php');
/*
$id= "8ca287d8-1c65-453a-b031-f4ffbf6e1814";
	$respuesta = EstadoMsg($id);
	show($respuesta);
*/	

$cuentaverde=0;
$cuentaamarillo=0;
$cuentarojo=0;

$rs_listado= $ob_sms->filtroSMS($conn,$motivo,$fecha);	
	for($i=0;$i<pg_numrows($rs_listado);$i++){
		$fila=pg_fetch_array($rs_listado,$i);
		if(strlen(trim($fila['nro_telefono']))==9){
		$respuesta = EstadoMsg($fila['clave']);
 		//show($respuesta);	
			if($respuesta){//
				$codigo = explode("_",$respuesta);
				$mensaje=trim($codigo[2]);
				if($mensaje=="CONFIRMED DELIVERY"){
					$estado=0;	
					$cuentaverde++;
				}
				elseif($mensaje=="SENT" || $mensaje=="WAITING FOR CONFIRMATION"){
					$estado=1;	
					$cuentaamarillo++;
				}
				else{
					$estado=2;	
					$cuentarojo++;
				}

//				
				$ob_sms-> ModificaEstado($conn,$fila['id_sms'],substr($codigo[0], 0, -2),$estado);
			}

	}
	}
 
echo $cuentaverde."/".$cuentaamarillo."/".$cuentarojo;

}
if($funcion==23){
	//show($_POST);
if($tipo==1){
$rs_curso = $ob_sms->Curso($conn,$_ANO);
	?>
   <select name="tipodes" id="tipodes" onChange="BuscaAlumno()">
        <option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_curso);$i++){
                $fila_c=pg_fetch_array($rs_curso,$i);
        ?>
        <option value="<?=$fila_c['id_curso'];?>"><?=CursoPalabra($fila_c['id_curso'],0,$conn);?></option>
        <? } ?>
</select>
<?	
}
if($tipo==2){
	$result = $ob_sms->Grupos($conn,$_INSTIT);
?>
		<select name="tipodes" id="tipodes" >
        <option value="0">seleccione...</option>
        <?php for($g=0;$g<pg_numrows($result);$g++){
			$fila_g=pg_fetch_array($result,$g);?>
         <option value="<?php echo $fila_g['id_grupo'] ?>"><?php echo $fila_g['nombre'] ?></option>
         <?php }?>
        </select>
        <?
	
}	
	
	
}

if($funcion==24){
?>
<table width="100%" border="0">
 <tr>
    <td class="cuadro02">&nbsp;Cantidad de Caracteres</td>
	<td class="cuadro01">&nbsp;<input name="caracteres2" type="text" id="caracteres2" value="0" size="4"> de 160</td>
  </tr>
  <tr>
    <td class="cuadro02">T&Iacute;TULO</td>
    <td class="cuadro01"><input name="txtMOTIVOP" id="txtMOTIVOP" type="text" size="30" maxlength="30" /></td>
  </tr>
  <tr>
    <td class="cuadro02">MENSAJE</td>
    <td class="cuadro01"><textarea name="txtMENSAJE" style="margin: 0px; height: 154px; width: 327px;" id="txtMENSAJE" onKeyDown="valida_longitud2(); " onKeyUp="valida_longitud2(); "></textarea ></td>
  </tr>
</table>
<?
}
if($funcion==25){
	$result = $ob_sms->AgregarPlantilla($conn,sanear_string($titulo),sanear_string($mensaje),$_INSTIT);
	
	if($result){
		echo 1;
	}else{
		echo 0;	
	}
}
if($funcion==26){
	$rs_motivo = $ob_sms->listaPlantilla($conn,$_INSTIT);
?>
	<select name="cmbPLANTILLA" id="cmbPLANTILLA" onchange="cargaPlantilla(this.value)">
    	<option value="0">seleccione...</option>
<? 
	for($i=0;$i<pg_numrows($rs_motivo);$i++){
		$fila = pg_Fetch_array($rs_motivo,$i);
?>
	<option value="<?=$fila['id_plantilla'];?>"><?=$fila['titulo'];?></option>
<? } ?>

</select>	
    <?
}
if($funcion==27){
$rs_plantilla = $ob_sms->cargaPlantilla($conn,$idP);
$fila_plantilla = pg_fetch_array($rs_plantilla,0);
 echo trim($fila_plantilla['texto']);	
}
if($funcion==28){
$rs_hab = $ob_sms->tengoSMS($connection,$rbd);
$rs_com = $ob_sms->tengoComu($connection,$rbd);
if(pg_result($rs_hab,0)==15){
?>
<input type="hidden" id="hsms" value="15" />
<?
}
if(pg_result($rs_com,0)==17){
?>
<input type="hidden" id="hsms" value="17" />
<input type="hidden" id="token" value="RWR1SW1wdWxzYQ==" />
<?
}

}
if($funcion==29){
if($usu!=0){
	$rs_per = $ob_sms->CargoEmpleado($conn,$usu,$_INSTIT);
	$fi_usu = pg_fetch_array($rs_per,0);
	$pern = $fi_usu['nombre_cargo'];
	$peri = $fi_usu['cargo'];
}
else{
$pern="Admin";
$peri=0;

}
?>
<input id="pern" type="hidden" value="<?php echo $pern ?>">
<input id="peri" type="hidden" value="<?php echo $peri ?>">
<?

}

if($funcion==30){
$rs = $ob_sms->guardaMensajeCom($conn,$token,$rbd,$curso,$destinatario,$user,$fecha,$hora,$modo,$user_type,$texto,trim($tipomensaje),$motivo,$_ANO);
}
if($funcion==31){
	
$des = explode(",",$destinatario);

if(count($des)>0){
	for($d=0;$d<count($des);$d++){
	$des[$d];
	$rs = $ob_sms->guardaMensajeCom($conn,$token,$rbd,$curso,$des[$d],$user,$fecha,$hora,$modo,$user_type,$texto,trim($tipomensaje),$motivo);
	
	}
}

}
if($funcion==32){
$des = explode(",",$destinatario);

if(count($des)>0){
	for($d=0;$d<count($des);$d++){
	$des[$d];
	$rs = $ob_sms->guardaMensajeCom($conn,$token,$rbd,$curso,$des[$d],$user,$fecha,$hora,$modo,$user_type,$texto,trim($tipomensaje),$motivo,$_ANO);
	
	}

}
	
/*$rs_apoderado = $ob_sms->BuscaApoderado($conn,$curso,$alumno,$_ANO);
	for($i=0;$i<pg_numrows($rs_apoderado);$i++){
		$fila =pg_fetch_array($rs_apoderado,$i);
	}*/
}
if($funcion==33){
	$rs_alu = $ob_sms->alumnosAct($conn,$_ANO);
	$al="";
	for($a=0;$a<pg_numrows($rs_alu);$a++){
		$fila_a = pg_fetch_array($rs_alu,$a);
		$al.=$fila_a['rut_alumno'].",";
	}
	$al = substr($al, 0, -1);
	echo '<input type="hidden" id="talu" value="'.$al.'">';
	
	
}
if($funcion==34){
	$rs_motivo = $ob_sms->Motivo($conn,$_INSTIT);
?>
	<select name="cmbMOTIVOB" id="cmbMOTIVOB">
    	<option value="0">seleccione...</option>
<? 
	for($i=0;$i<pg_numrows($rs_motivo);$i++){
		$fila = pg_Fetch_array($rs_motivo,$i);
?>
	<option value="<?=$fila['id_motivo'];?>"><?=utf8_decode($fila['nombre']);?></option>
<? } ?>

    </select>	
<?
}
if($funcion==35){
	//show($_POST);

	$tabla=($via==1)?"sms":"sms_comu";
	$fec=($via==1)?"fecha_envio":"fecha";
	
	$desde=($desde!=1)?CambioFE($desde):"";
	$hasta=($hasta!=1)?CambioFE($hasta):"";

	$listado = $ob_sms->ListadoNew($conn,$_ANO,$motivo,$desde,$hasta,$tabla,$fec,$via,$modulo);
	

}
if($funcion==36){
	show($_POST);
	
	$ca = json_decode($respuesta);
	$noregistrados = $ca->{'respuesta'}->{'registrados'}->{'no_registrados'};
	
	//tengo todos lo alumnos donde no llega mensaje
	for($n=0;$n<count($noregistrados);$n++){
		$alumno = $noregistrados[$n];
		$cu = $ob_sms->buscaCursoAlu($conn,$alumno,$_ANO);
		$curso = pg_result($cu,0);
		
		$rs_apoderado = $ob_sms->BuscaApoderado($conn,$curso,$alumno,$_ANO);
		
		
		
		
		//buscar a todos los alumno del listado
		for($i=0;$i<pg_numrows($rs_apoderado);$i++){
		$fila =pg_fetch_array($rs_apoderado,$i);
		//echo "<br>".strlen(trim($fila['celular']));
		if(strlen(trim($fila['celular']))==9){
			if(($i % 5)==0){
				sleep(1);
				$var=1;
			}
			$celular=trim($fila['celular']);
			$rs_mensaje = $ob_sms->GuardaSMS($conn,$_ANO,$curso,$alumno,$fila['rut_apo'],sanear_string($texto),$celular,$_INSTIT,$motivo);
			
			if($rs_mensaje){
				require_once('funcion_sms.php');
				$respuesta = Envio_SMS($celular,sanear_string($mensaje));
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
		
	}
}
?>

