<?php
require('../../../../util/header.inc');
	
	$_POSP = 4;
	$_bot = 8;
	$institucion	= $_INSTIT;
	$ano			= $_ANO;

//echo "count".$count;
//echo $cmb_tipo_ensenanza;
//echo $ANO;
	
/*if(!$cb_ok =="Buscar"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_Psu_$Fecha.xls"); 
	
}	*/
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--<link href="../../../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">
--><script>
function enviapag2(form){
		form.target="_blank";
		form.action='print_Informe_psu.php?cmb_tipo_ensenanza=<?=$cmb_tipo_ensenanza?>&r_ordena=<?=$r_ordena?>&cmb_ano=<?=$ANO?>&ck_1=<?=$ck_1?>&ck_2=<?=$ck_2?>&ck_3=<?=$ck_3?>&ck_4=<?=$ck_4?>&ck_5=<?=$ck_5?>&ck_6=<?=$ck_6?>&ck_7=<?=$ck_7?>&r_puntaje=<?=$r_puntaje?>';
		form.submit(true);
}
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){ 
window.close() 
} 
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script></head>

</script>

<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
.Estilo20 {font-family: Arial, Helvetica, sans-serif}
.Estilo21 {color: #000000}
.Estilo24 {font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; }
</style>
<body>
<?
//echo $c
 
?>
<form name="form" action="print_Informe_psu.php" method="post">
<table width="325" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="5">
	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="capa0">
	<table width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </td>
	    </tr></table>
      
      </div></td>
  </tr>
</table>	</td>
  </tr>
  <tr>
    <td colspan="5">
	<table width="650" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<?
		$sql_inst="select * from institucion where rdb=".$institucion;
		$result = @pg_Exec($conn,$sql_inst);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{ ?>
			<td width="119" rowspan="6">
						<?
	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>			</td>
			<td width="50">&nbsp;</td>
			<td>
	
				<table>
				  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$arr['nombre_instit']?></strong></font></div></td>
				  </tr>
				</table>
				<table>  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$arr['calle'].$arr['nro'];?></strong></font></div></td>
					</tr>
				</table>
				<table>  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$arr['telefono'];?></strong></font></div></td>
					</tr>
				</table>			</td>

	<? }
		else{?>
		<td>
			<table width="100%">
			  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->ins_pal?></strong></font></div></td>
			  </tr>
			</table>
			<table>  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->direccion;?></strong></font></div></td>
				</tr>
			</table>
			<table>  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->telefono;?></strong></font></div></td>
				</tr>
			</table>		</td>
	<? }  ?>
	</tr>
</table>	</td>
  </tr>
  <?
		$sql_beca = "SELECT * FROM becas_conf WHERE id_beca=".$beca;
		$resp_beca= pg_exec($conn,$sql_beca);
		$fila_beca = pg_fetch_array($resp_beca,0);
  ?>
  <tr>
    <td colspan="5" class="tableindex">Comprobante Postulacion : <?=$fila_beca['nomb_beca']?></td>
  </tr>
  <tr>
    <td colspan="5">
	<table align="center" width="500" border="0" cellpadding="0" cellspacing="1">
  <tr>
    <td width="77" class="cuadro02">Alumno:</td>
	<?
		$sql ="SELECT nombre_alu,ape_pat,ape_mat FROM alumno WHERE rut_alumno =".$rut_alumno;
		$resp = pg_exec($conn,$sql);
		$fila_nomb = pg_fetch_array($resp,0);
		$nombre = $fila_nomb['ape_pat']." ".$fila_nomb['ape_mat'].",".$fila_nomb['nombre_alu'];
	 
	?>
    <td width="420" class="Estilo24"><?=$nombre?></td>
  </tr>
  <tr>
    <td class="cuadro02">Curso:</td>
	<?
		$sql ="SELECT grado_curso,letra_curso FROM curso WHERE id_curso =".$curso." AND id_ano=".$ano;
		$resp = pg_exec($conn,$sql);
		$nomb_curso = pg_result($resp,0)."-".pg_result($resp,1);
	?>
    <td class="Estilo24"><?=$nomb_curso?></td>
  </tr>
  <tr>
    <td class="cuadro02">Beca:</td>
    <td class="Estilo24"><?=$fila_beca['nomb_beca']?></td>
  </tr>
  <tr>
    <td class="cuadro02">Fecha:</td>
    <td class="Estilo24"><?
	
	$YY = substr($fecha_postul,0,4);
	$dd = substr($fecha_postul,8,9);
	$mm = substr($fecha_postul,5,2);
	echo $fecha = $dd."-".$mm."-".$YY;
	?></td>
  </tr>
  <tr>
    <td class="cuadro02">Descripci&oacute;n:</td>
    <td class="Estilo24"><?=$fila_beca['descripcion']?></td>
  </tr>
</table>	</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="124">&nbsp;</td>
    <td width="92">&nbsp;</td>
    <td width="212" class="cajamenu">&nbsp;</td>
    <td width="84">&nbsp;</td>
    <td width="138">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="textonegrita">&nbsp;</td>
    <td class="textonegrita"><div align="center">Firma<br />Asistente Social </div></td>
    <td class="textonegrita">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>






</form>
</body>
</html>
<? pg_close($conn);?>