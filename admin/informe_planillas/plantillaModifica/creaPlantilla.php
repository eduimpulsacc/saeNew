<?php require('../../../../util/header.inc');
$institucion =$_INSTIT;
echo "plan", $_PLANTILLA;
/*if($plantilla==""){
	if($_PLANTILLA!="") {
		$plantilla	=$_PLANTILLA;
	}
}*/
$_POSP = 4;
$_bot = 7;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<script>
function Confirmacion(form){
		var pla=form.hiddenPlantilla.value;
		if(confirm('¿ESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
			//window.location='procesoPlantilla.php?plantilla=pla&eliminar=1'
			form.action='procesoPlantilla.php?eliminar=1';
			form.submit(true);
		};
function Modifica(form){
		form.target='_parent';
		form.action='modificarPlantilla.php';
		//form.action='seteaPlantilla.php?plantilla=<? echo $plantilla;?>&caso=3';
		form.submit(true);
}

function agregaReg(form){
		form.target='_parent';
		form.action='agregarRegistrosPlantilla.php';
		//form.action='seteaPlantilla.php?plantilla=<? echo $plantilla;?>&caso=3';
		form.submit(true);
}

</script>
</head>
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">

								  
							
						   
						   <form action="procesoPlantilla.php" method="post">
  <table width="76%" border="0" align="center">
    <tr> 
      <td colspan="2"> <font size="2" face="Arial, Helvetica, sans-serif">1.- 
        <?php if($creada!=1){
        echo "Seleccione el Tipo de Ense&ntilde;anza al que aplicar&aacute; este informe.";
		}else{
		echo "Tipo de Ense&ntilde;anza al que aplicar&aacute; este informe:";
		}
		?>
        </font>&nbsp;</td>
    </tr>
    <tr> 
      <td width="8%">&nbsp;</td>
      <td width="92%"> 
        <?php 
	 	$sqlEns="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from  tipo_ense_inst inner join tipo_ensenanza on tipo_ense_inst.cod_tipo=tipo_ensenanza.cod_tipo where tipo_ense_inst.rdb='".$institucion."' and tipo_ense_inst.estado=0 or tipo_ense_inst.estado=1";
		$resultEns=pg_Exec($conn,$sqlEns);
			if (!$resultEns) {
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlEns);
			}

	 ?>
        <?php if($creada!=1){?>
        <select name="cmbEns" id="cmbEns">
          <option value="0" selected>Seleccione Tipo de Ense&ntilde;anza</option>
          <?php
		  
		  for($cEns=0 ; $cEns<pg_numrows($resultEns) ; $cEns++){
			  $filaEns=pg_fetch_array($resultEns,$cEns);
			  echo "<option value=".$filaEns['cod_tipo'].">".$filaEns['nombre_tipo']."</option>";	
		  }//fin for
		  
		  ?>
        </select> 
        <?php }else{ //fin if($creada!=1)
				$sqlTraeEns="select nombre_tipo from tipo_ensenanza inner join informe_plantilla on tipo_ensenanza.cod_tipo=informe_plantilla.tipo_ensenanza where informe_plantilla.id_plantilla=".$plantilla;
				$resultTraeEns=pg_Exec($conn,$sqlTraeEns);
					if (!$resultTraeEns) {
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$sqlTraeEns);
					}

				$filaTraeEns=pg_fetch_array($resultTraeEns,0);
				echo "<font size=2 face=Arial, Helvetica, sans-serif>";
				echo $filaTraeEns['nombre_tipo'];
				echo "</font>";
			}
			?>
      </td>
    </tr>
    <tr> 
      <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
    </tr>
    <tr> 
      <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">2.- 
        <?php 
	  if($creada!=1){
	  echo "Seleccione grados a los que aplica esta Plantilla de Informe.";
	  }else{
	  echo "Grados a los que aplica esta Plantilla de Informe:";
	  }
	  ?>
        &nbsp; <font size="2" face="Arial, Helvetica, sans-serif"><font size="1">Ed. Parvularia: SC=</font><font size="1" face="Arial, Helvetica, sans-serif"> 
        1&ordm; A&Ntilde;O, NMME= 2&ordm; A&Ntilde;O, NMMA= 3&ordm; A&Ntilde;O, 
        1NT= 4&ordm; A&Ntilde;O, 2NT= 5&ordm; A&Ntilde;O</font></font></font></td>
    </tr>
	<?php if($creada!=1){?>
    <tr> <td width="8%">&nbsp;</td>
      <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif"> 
        <input name="pa" type="checkbox" id="pa" value="1">
        PRIMER A&Ntilde;O 
        <input name="sa" type="checkbox" id="sa" value="1">
        SEGUNDO A&Ntilde;O 
        <input name="ta" type="checkbox" id="ta" value="1">
        TERCER A&Ntilde;O 
        <input name="cu" type="checkbox" id="cu" value="1">
        CUARTO A&Ntilde;O </font></td>
    </tr>
    <tr> 
	<td width="8%">&nbsp;</td>
      <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">
        <input name="qu" type="checkbox" id="qu" value="1">
        QUINTO A&Ntilde;O 
        <input name="sx" type="checkbox" id="sx" value="1">
        SEXTO A&Ntilde;O 
        <input name="sp" type="checkbox" id="sp" value="1">
        SEPTIMO A&Ntilde;O 
        <input name="oc" type="checkbox" id="oc" value="1">
        OCTAVO A&Ntilde;O</font></td>
    </tr>
	<?php } else{?>
	<tr> 
      <td>&nbsp;</td><td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">
	<?php 
		$sqlTraeGrados="SELECT * FROM informe_plantilla WHERE id_plantilla=".$plantilla;
		$resultGrados=pg_Exec($conn, $sqlTraeGrados);
			if (!$resultGrados) {
				error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$sqlTraeGrados);
			}
		for($countGr=0 ; $countGr<pg_numrows($resultGrados) ; $countGr++){
			$filaGr=pg_fetch_array($resultGrados);
			if ($filaGr['pa']==1) echo "PRIMERO   ";
			if ($filaGr['sa']==1) echo "SEGUNDO   ";
			if ($filaGr['ta']==1) echo "TERCERO   ";
			if ($filaGr['cu']==1) echo "CUARTO   ";
			if ($filaGr['qu']==1) echo "QUINTO   ";
			if ($filaGr['sx']==1) echo "SEXTO  ";
			if ($filaGr['sp']==1) echo "SEPTIMO   ";
			if ($filaGr['oc']==1) echo "OCTAVO   ";
		} ?>
	</font>&nbsp;</td>
    </tr>
	<?php }?>
	    <tr> 
      <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
    </tr>
    <tr> 
      <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">3.- 
        <?php 
	  if($creada!=1){
	  echo "Asigne un nombre a la nueva Plantilla de Informe.";
	  }else{
	  echo "Nombre de la nueva Plantilla de Informe:";
	  }
	  ?>
        </font> &nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"> 
        <?php if($creada!=1){
		echo "Nombre:";?>
        <input name="txtNombrePla" type="text" id="txtNombrePla" size="50" maxlength="50">
        <?php }else{
				$sqlTraeNombre="select nombre from informe_plantilla where id_plantilla=".$plantilla;
				$resultTraeNombre=pg_Exec($conn, $sqlTraeNombre);
				if (!$resultTraeNombre) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$sqlTraeNombre);
				}
				$filaTraeNombre=pg_fetch_array($resultTraeNombre,0);
				echo "<font size=2 face=Arial, Helvetica, sans-serif>";
				echo $filaTraeNombre['nombre'];
				echo "</font>";
	  		} ?>
        </font></td>
    </tr>
    <!--tr> 
      <td colspan="2">&nbsp;</td>
    </tr-->
    <tr> 
      <td colspan="2"> 
        <?php if (($creada!=1) and ($eliminar!=1)){?>
        <input class="botonXX"  type="submit" name="Submit" value="GRABAR">
      <?php }elseif(($creada==1) and ($eliminar==1)){?>
	  	<input type="hidden" name="hiddenPlantilla" value="<?php echo $plantilla?>"></input>
	  	<input class="botonXX"  type="button" name="eliminar" value="ELIMINAR" onClick="Confirmacion(this.form)">
	  	<input class="botonXX"  type="button" name="cancelar" value="CANCELAR" onClick="history.back()">
		<input class="botonXX"  type="button" name="cancelar" value="MODIFICAR" onClick="Modifica(this.form)">
		<input class="botonXX"  type="button" name="cancelar" value="AGREGAR REGISTROS" onClick="agregaReg(this.form)">
		</td>
	  <?php }else{
			echo "<font size=2 face=Arial, Helvetica, sans-serif><STRONG>";
	  		echo "Estos datos han sido grabados siga con el paso Nro. 2";
			echo "</strong></font>";
	  		}
	  ?>
    </tr>
  </table>
</form>
						   
						    
	 							 
</body>
</html>
