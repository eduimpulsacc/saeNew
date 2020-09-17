<?php require("../../../util/header.php");
 require("mod_activa.php");

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
}

$ob_activa = new Activa($conn,$connection);


 if($funcion==1){
	 $rs_sis = $ob_activa->listaSistemas();
	 $rs_aso = $ob_activa->listaAsociados($col);
	 
	$fila_aso = pg_fetch_array($rs_aso,0);

	
	if($fila_aso['estado_colegio']==1){
		$ar_aso['id_sis'][]="estado_colegio";
		$ar_aso['no_sis'][]="SAE";	
	}
	else{
		$ar_dis['id_sis'][]="estado_colegio";
		$ar_dis['no_sis'][]="SAE";
	}
	
	if($fila_aso['saemovil']==2){
		$ar_aso['id_sis'][]="saemovil";
		$ar_aso['no_sis'][]="SAEMOVIL";
		}
	else{
		$ar_dis['id_sis'][]="saemovil";
		$ar_dis['no_sis'][]="SAEMOVIL";
	}
	
	
	if($fila_aso['evados']==3){
		$ar_aso['id_sis'][]="evados";
		$ar_aso['no_sis'][]="EVADOS";
		}
	else{
		$ar_dis['id_sis'][]="evados";
		$ar_dis['no_sis'][]="EVADOS";
	} 
	
	
	if($fila_aso['reca']==4){
		$ar_aso['id_sis'][]="reca";
		$ar_aso['no_sis'][]="RECAUDACION";
		}
	else{
		$ar_dis['id_sis'][]="reca";
		$ar_dis['no_sis'][]="RECAUDACION";
	} 
	
	if($fila_aso['cede']==7){
		$ar_aso['id_sis'][]="cede";
		$ar_aso['no_sis'][]="CEDE";
		}
	else{
		$ar_dis['id_sis'][]="cede";
		$ar_dis['no_sis'][]="CEDE";
	} 
	
	if($fila_aso['planificacion']==12){
		$ar_aso['id_sis'][]="planificacion";
		$ar_aso['no_sis'][]="PLANIFICACION";
		}
	else{
		$ar_dis['id_sis'][]="planificacion";
		$ar_dis['no_sis'][]="PLANIFICACION";
	} 
	
	if($fila_aso['biblioteca']==13){
		$ar_aso['id_sis'][]="biblioteca";
		$ar_aso['no_sis'][]="BIBLIOTECA";
		}
	else{
		$ar_dis['id_sis'][]="biblioteca";
		$ar_dis['no_sis'][]="BIBLIOTECA";
	} 
	
	if($fila_aso['edugestor']==14){
		$ar_aso['id_sis'][]="edugestor";
		$ar_aso['no_sis'][]="EDUGESTOR";
		}
	else{
		$ar_dis['id_sis'][]="edugestor";
		$ar_dis['no_sis'][]="EDUGESTOR";
	} 
	
	if($fila_aso['sms']==15){
		$ar_aso['id_sis'][]="sms";
		$ar_aso['no_sis'][]="SMS";
		}
	else{
		$ar_dis['id_sis'][]="sms";
		$ar_dis['no_sis'][]="SMS";
	} 
	
	
	if($fila_aso['codbarra']==16){
		$ar_aso['id_sis'][]="codbarra";
		$ar_aso['no_sis'][]="CODBARRA";
		}
	else{
		$ar_dis['id_sis'][]="codbarra";
		$ar_dis['no_sis'][]="CODBARRA";
	} 
	
	if($fila_aso['comunicapp']==17){
		$ar_aso['id_sis'][]="comunicapp";
		$ar_aso['no_sis'][]="COMUNICAPP";
		}
	else{
		$ar_dis['id_sis'][]="comunicapp";
		$ar_dis['no_sis'][]="COMUNICAPP";
	} 
	
?>
<script>
$(document).ready(function(){

	 $('.pasaro').click(function() { return !$('#disponible option:selected').remove().appendTo('#asociado'); });  
		$('.quitaro').click(function() { return !$('#asociado option:selected').remove().appendTo('#disponible'); });
		$('.pasartodoso').click(function() { $('#disponible option').each(function() { $(this).remove().appendTo('#asociado'); }); });
		$('.quitartodoso').click(function() { $('#asociado option').each(function() { $(this).remove().appendTo('#disponible'); }); });
		
	});	
</script>
<form id="frm">
<input type="hidden" name="yy" id="yy" value="" />
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr class="cuadro02" height="50">
    <td align="center">SISTEMAS DISPONIBLES</td>
    <td align="center">&nbsp;</td>
    <td align="center">SISTEMAS ASOCIADOS</td>
    </tr>
  <tr class="cuadro01">
    <td align="center">
      <select name="disponible[]" size="7" multiple id="disponible" style="width:250px">
        <?php for($d=0;$d<count($ar_dis['id_sis']);$d++){ ?>
        <option value="<?php echo $ar_dis['id_sis'][$d] ?>"><?php echo $ar_dis['no_sis'][$d] ?></option>
        <?php }?>
      </select>    </td>
    <td align="center"><p>
      <input type="button" class="pasaro izq botonXX" value="Pasar &raquo;">
      
      <input type="button" class="quitaro der botonXX" value="&laquo; Quitar"><br />
      <input type="button" class="pasartodoso izq botonXX" value="Todos &raquo;" >
      
      <input type="button" class="quitartodoso der botonXX" value="&laquo; Todos">
    </p></td>
    <td align="center"><select name="asociado[]" size="7" multiple id="asociado" style="width:250px">
      <?php  for($a=0;$a<count($ar_aso['id_sis']);$a++){ ?>
      <option value="<?php echo $ar_aso['id_sis'][$a] ?>"><?php echo $ar_aso['no_sis'][$a] ?></option>
      <?php }?>
      
      
    </select></td>
    </tr>
</table>
</form>
<?
}
if($funcion==2){
$caddis = "";
$cadaso = "";
show($_POST);

$aso = $_POST['asociado'];	
if(count($aso)>0){
	
	for($a=0;$a<count($aso);$a++){
		
	if($aso[$a] == 'estado_colegio'){
		$aso[$a] = 'estado_colegio=1,';
	}
	
	
	if($aso[$a] == 'saemovil'){
		$aso[$a] = 'saemovil=2,';
	}
	
		
	if($aso[$a] == 'evados'){
		$aso[$a] = 'evados=3,';
	}
	
	
	if($aso[$a] == 'reca'){
	  $aso[$a] = 'reca=4,';
	 }
	
	
	if($aso[$a] == 'cede'){
		$aso[$a] = 'cede=7,';
	 }
	
	
	if($aso[$a] == 'planificacion'){
		$aso[$a] = 'planificacion=12,';
	}
	
	
	if($aso[$a] == 'biblioteca'){
		$aso[$a] = 'biblioteca=13,';
	}
	
	
	if($aso[$a] == 'edugestor'){
		$aso[$a] = 'edugestor=14,';
	}
	
	
	if($aso[$a] == 'sms'){
	 	$aso[$a] = 'sms=15,';
		
	}
	
	if($aso[$a] == 'codbarra'){
		$aso[$a] = 'codbarra=16,';
		
	}
	
	
	if($aso[$a] == 'comunicapp'){
		$aso[$a] = 'comunicapp=17,';
	}
		
		$cadaso.=$aso[$a];
	}

}


$dis = $_POST['disponible'];	
if(count($dis)>0){
	for($d=0;$d<count($dis);$d++){
		$caddis.=$dis[$d]."=0,";
	}
	
}
 $caddis = substr($caddis,0,-1);

 $cadaso = substr($cadaso,0,-1);

$ob_activa->upColegio($col,$caddis,$cadaso);

}

 ?>