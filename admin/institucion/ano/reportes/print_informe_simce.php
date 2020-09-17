<?php
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');

	
	$_POSP = 4;
	$_bot = 8;	
	"<br>".$institucion	= $_INSTIT;
	"<br>".$ano			= $cmb_ano;
	"<br>".$curso			= $cmb_curso;
	$reporte		= $c_reporte;
	"<br>combo--> ".$cmb_opcion;
	"<br>".$contador;
	"<br>".$chk0;
	"<br>".$chk1;
	"<br>".$chk2;
	"<br>".$chk3;
	"<br>".$chk4;
	"<br>opcion--> ".$r_opcion;
	
$ob_reporte = new Reporte();

	
if($cb_ok2 =="Exportar"){
	$fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_puntajes_SIMCE_$fecha.xls"); 
	
}	
	?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link href="../../../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">
<script>
function enviapag(form){
		//form.target="_blank";
		form.action='print_informe_simce.php?cmb_curso=<?=$curso?>&cmb_opcion=<?=$cmb_opcion?>&chk0=<?=$chk0?>&chk1=<?=$chk1?>&chk2=<?=$chk2?>&chk3=<?=$chk3?>&chk4=<?=$chk4?>&contador=<?=$contador?>&r_opcion=<?=$r_opcion?>&cb_ok2=Exportar';
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


<form method="post" name="form" action="print_informe_simce.php">

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div id="capa0">
      <table width="100%">
        <tr>
          <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
          <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
          </td>
          <td align="right"><input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" onClick="enviapag(this.form);"  value="EXPORTAR"></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
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
	  }?>
			</td>
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
				</table>
			</td>

	<? }
		else{?>
		<td>
			<table width="100%">
			  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->ins_pal;?></strong></font></div></td>
			  </tr>
			</table>
			<table>  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->direccion;?></strong></font></div></td>
				</tr>
			</table>
			<table>  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->telefono;?></strong></font></div></td>
				</tr>
			</table>
		</td>
	<? }  ?>
	</tr>
</table>

<? if($cmb_opcion==1 and $r_opcion!=1){?>
  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3">Curso</div></td>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3">Rut</div></td>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3">Alumnos</div></td>
	  <? $sql_subs="SELECT * FROM simce_conf_2009 INNER JOIN subsector ON ";
	  	 $sql_subs.="simce_conf_2009.cod_subsector=subsector.cod_subsector WHERE simce_conf_2009.rdb=".$institucion."";
		 $sql_subs.=" and simce_conf_2009.id_ano=".$ano;	
		 $resp_subs = pg_exec($conn,$sql_subs);
		 $num_subs = pg_numrows($resp_subs);
	  	
		for($k=0;$k<$num_subs;$k++){
		$fila_subs = pg_fetch_array($resp_subs,$k);
	  		
			
			if($fila_subs['id_sub_sim']==$chk0){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  		if($fila_subs['id_sub_sim']==$chk1){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  		if($fila_subs['id_sub_sim']==$chk2){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  		if($fila_subs['id_sub_sim']==$chk3){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  		if($fila_subs['id_sub_sim']==$chk4){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  	}?>
	  <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3">Puntaje SIMCE </div></td>
    </tr>
    <?     
	$sql="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ";
	$sql.="alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, ";
	$sql.=" alumno.comuna, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, matricula.num_mat ";
	$sql.=" FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON ";
	$sql.=" matricula.rut_alumno = alumno.rut_alumno WHERE (matricula.bool_ar=0 and ((matricula.id_curso)=".$curso.") AND ";
	$sql.=" ((matricula.id_ano)=".$ano.")) order by ape_pat, ape_mat, nombre_alu ";
 	$resp = @pg_exec($conn,$sql);
	$num_alumnos = pg_numrows($resp);
	for($i=0;$i<$num_alumnos;$i++){
	$fila_alumnos = pg_fetch_array($resp,$i);
	?>
    <tr>
	<?
	$sql_curso="SELECT letra_curso,grado_curso FROM curso where id_curso=".$fila_alumnos['id_curso']."";
	$res_curso=@pg_exec($conn,$sql_curso);
	$curso1=pg_fetch_array($res_curso,0);
	?>
      <td width="12%" class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3">
        <?=$curso1['grado_curso']."-".$curso1['letra_curso']?>
      </div></td>
  
      <td width="12%" class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><?=$fila_alumnos['rut_alumno']?></div></td>
      <td width="12%" class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3">
      <?=$ob_reporte->tilde(ucwords(strtolower($fila_alumnos['ape_pat']." ".$fila_alumnos['ape_mat'].", ".$fila_alumnos['nombre_alu'])));?>
    </div></td>
    <? 
	for($k=0;$k<$num_subs;$k++){
		$fila_subs = pg_fetch_array($resp_subs,$k);
		
		$sql_puntaje="SELECT nota FROM simce_notas_2009 WHERE rut_alumno=".$fila_alumnos['rut_alumno']." ";
		$sql_puntaje.="and id_sub_sim=".$fila_subs['id_sub_sim']." and id_ano=".$ano."";
		$res_puntaje=@pg_exec($conn,$sql_puntaje);
		$nota=pg_result($res_puntaje,0);
		
		
		if($fila_subs['id_sub_sim']==$chk0){
	?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if($nota!=NULL){ echo $nota;}else{echo "-";}?></div></td>
	<?	 }
		if($fila_subs['id_sub_sim']==$chk1){?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if($nota!=NULL){ echo $nota;}else{echo "-";}?></div></td>
	<? }
		if($fila_subs['id_sub_sim']==$chk2){?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if($nota!=NULL){ echo $nota;}else{echo "-";}?></div></td>
	<? }
		if($fila_subs['id_sub_sim']==$chk3){?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if($nota!=NULL){ echo $nota;}else{echo "-";}?></div></td>
	<? }
		if($fila_subs['id_sub_sim']==$chk4){?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if($nota!=NULL){ echo $nota;}else{echo "-";}?></div></td>
	<? }
	
		}?>
		
	<? $sql_final="SELECT puntaje_final FROM simce_final_2009 WHERE rut_alumno=".$fila_alumnos['rut_alumno']." and id_curso=".$curso." and id_ano=".$ano."";
		$res_final=@pg_exec($conn,$sql_final);
		$final=pg_result($res_final,0);
	?> 
	  <td width="12%" class="cuadro01">
        <div align="center" class="Estilo21 Estilo20 Estilo3"><? if($final!=NULL){ echo $final;}else{ echo "-";}?></div></td>
    </tr> 
	<? }?>
  </table>
  <? }?>
  
  <? if($cmb_opcion==1 and $r_opcion==1){?>
  <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3">Curso</div></td>
      <td width="6%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3">Rut</div></td>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3">Alumnos</div></td>
	  <td width="6%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"></div></td>
	  <? $sql_subs="SELECT * FROM simce_conf_2009 INNER JOIN subsector ON ";
	  	 $sql_subs.="simce_conf_2009.cod_subsector=subsector.cod_subsector WHERE simce_conf_2009.rdb=".$institucion."";
		 $sql_subs.=" and simce_conf_2009.id_ano=".$ano;	
		 $resp_subs = pg_exec($conn,$sql_subs);
		 $num_subs = pg_numrows($resp_subs);
	  	
		for($k=0;$k<$num_subs;$k++){
		$fila_subs = pg_fetch_array($resp_subs,$k);
	  		
			
			if($fila_subs['id_sub_sim']==$chk0){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  		if($fila_subs['id_sub_sim']==$chk1){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  		if($fila_subs['id_sub_sim']==$chk2){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  		if($fila_subs['id_sub_sim']==$chk3){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  		if($fila_subs['id_sub_sim']==$chk4){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  	}?>
	  <!--<td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3">Puntaje SIMCE </div></td>-->
    </tr>
    
    <?     
	$sql="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ";
	$sql.="alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, ";
	$sql.=" alumno.comuna, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, matricula.num_mat ";
	$sql.=" FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON ";
	$sql.=" matricula.rut_alumno = alumno.rut_alumno WHERE (matricula.bool_ar=0 and ((matricula.id_curso)=".$curso.") AND ";
	$sql.=" ((matricula.id_ano)=".$ano.")) order by ape_pat, ape_mat, nombre_alu ";
 	$resp = @pg_exec($conn,$sql);
	$num_alumnos = pg_numrows($resp);
	for($i=0;$i<$num_alumnos;$i++){
	$fila_alumnos = pg_fetch_array($resp,$i);
	?>
    <tr>
	<?
	$sql_curso="SELECT letra_curso,grado_curso FROM curso where id_curso=".$fila_alumnos['id_curso']."";
	$res_curso=@pg_exec($conn,$sql_curso);
	$curso1=pg_fetch_array($res_curso,0);
	?>
      <td width="12%" rowspan="2" class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3">
        <?=$curso1['grado_curso']."-".$curso1['letra_curso']?>
      </div></td>
  
      <td width="12%" rowspan="2" class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><?=$fila_alumnos['rut_alumno']?></div></td>
      <td width="6%" rowspan="2" class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3">
      <?=$ob_reporte->tilde(ucwords(strtolower($fila_alumnos['ape_pat']." ".$fila_alumnos['ape_mat'].", ".$fila_alumnos['nombre_alu'])));?>
    </div></td>
      <td width="6%" class="cuadro01">Puntaje</td>
      <? 
	for($k=0;$k<$num_subs;$k++){
		$fila_subs = pg_fetch_array($resp_subs,$k);
		
		$sql_puntaje="SELECT nota FROM simce_notas_2009 WHERE rut_alumno=".$fila_alumnos['rut_alumno']." ";
		$sql_puntaje.="and id_sub_sim=".$fila_subs['id_sub_sim']." and id_ano=".$ano."";
		$res_puntaje=@pg_exec($conn,$sql_puntaje);
		$nota=pg_result($res_puntaje,0);
		

		$sql_prom="SELECT a.promedio FROM promedio_sub_alumno a INNER JOIN ramo b ON(a.id_ramo=b.id_ramo) ";
		$sql_prom.="WHERE a.rut_alumno=".$fila_alumnos['rut_alumno']." and a.id_curso=".$curso." and a.id_ano=".$ano." ";
		$sql_prom.="and b.cod_subsector=".$fila_subs['cod_subsector'];
		$res_prom=@pg_exec($conn,$sql_prom);
		
		if(pg_numrows($res_prom)!=0){
		$prom=pg_result($res_prom,0);
		}else{
		
		$sql_ano = "SELECT nro_ano FROM ano_escolar WHERE id_institucion =".$institucion." and id_ano=".$ano." ORDER BY nro_ano ASC";
		$resp_ano = pg_exec($conn,$sql_ano);
		$num_ano = pg_result($resp_ano,0);
		
		$sql_prom="SELECT SUM(CAST(a.promedio AS INTEGER)),count(a.id_periodo) FROM notas$num_ano a INNER JOIN ramo b ";
		$sql_prom.="ON (a.id_ramo=b.id_ramo) WHERE a.rut_alumno=".$fila_alumnos['rut_alumno']." ";
		$sql_prom.="and b.cod_subsector=".$fila_subs['cod_subsector'];
		$res_prom=@pg_exec($conn,$sql_prom);
		for($m=0;$m<pg_numrows($res_prom);$m++){
		$promedio=pg_fetch_array($res_prom,$m);
		
		$prom[$k] = round($promedio['sum']/$promedio['count']);
		
			}
		}
		
		
		
		if($fila_subs['id_sub_sim']==$chk0){
	?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if($nota!=NULL){ echo $nota;}else{echo "-";}?></div></td>
	<?	 }
		if($fila_subs['id_sub_sim']==$chk1){?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if($nota!=NULL){ echo $nota;}else{echo "-";}?></div></td>
	<? }
		if($fila_subs['id_sub_sim']==$chk2){?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if($nota!=NULL){ echo $nota;}else{echo "-";}?></div></td>
	<? }
		if($fila_subs['id_sub_sim']==$chk3){?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if($nota!=NULL){ echo $nota;}else{echo "-";}?></div></td>
	<? }
		if($fila_subs['id_sub_sim']==$chk4){?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if($nota!=NULL){ echo $nota;}else{echo "-";}?></div></td>
	<? }
	
		}?>
		
	<? $sql_final="SELECT puntaje_final FROM simce_final_2009 WHERE rut_alumno=".$fila_alumnos['rut_alumno']." and id_curso=".$curso." and id_ano=".$ano."";
		$res_final=@pg_exec($conn,$sql_final);
		$final=pg_result($res_final,0);
	
	?> 
	  <?php /*?><td width="12%" rowspan="2" class="cuadro01">
        <div align="center" class="Estilo21 Estilo20 Estilo3"><? if($final!=NULL){ echo $final;}else{ echo "-";}?></div></td><?php */?>
    </tr>
    <tr>

      <td class="cuadro01">Promedio</td>
	  	<? for($k=0;$k<$num_subs;$k++){
		$fila_subs = pg_fetch_array($resp_subs,$k);?>
	  <?	if($fila_subs['id_sub_sim']==$chk0){
	?>
      <td width="12%"class="cuadro01"><div align="center"><? if($prom[$k]!=NULL){ echo $prom[$k];}else{echo "-";}?></div></td>
	  <? }?>
	  <?	if($fila_subs['id_sub_sim']==$chk1){
	?>
      <td width="12%"class="cuadro01"><div align="center"><? if($prom[$k]!=NULL){ echo $prom[$k];}else{echo "-";}?></div></td>
	  <? }?>
	  <? 	if($fila_subs['id_sub_sim']==$chk2){
	?>
      <td width="12%"class="cuadro01"><div align="center"><? if($prom[$k]!=NULL){ echo $prom[$k];}else{echo "-";}?></div></td>
	  <? }?>
	 <? 	if($fila_subs['id_sub_sim']==$chk3){
	?>
      <td width="12%"class="cuadro01"><div align="center"><? if($prom[$k]!=NULL){ echo $prom[$k];}else{echo "-";}?></div></td>
	  <? }?>
	  <?	if($fila_subs['id_sub_sim']==$chk4){
	?>
      <td width="12%"class="cuadro01"><div align="center"><? if($prom[$k]!=NULL){ echo $prom[$k];}else{echo "-";}?></div></td>
	  <? }
	  }?>
    </tr> 
	<? }?>
  </table>
  
  <? }?>
  
  
  <?
  
  
  if($cmb_opcion==2){?>
  

  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="cuadro02">
    <td width="15%"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3">Cursos</div></td>
	<?
		 $sql_subs="SELECT * FROM simce_conf_2009 INNER JOIN subsector ON ";
	  	 $sql_subs.="simce_conf_2009.cod_subsector=subsector.cod_subsector WHERE simce_conf_2009.rdb=".$institucion."";
		 $sql_subs.=" and simce_conf_2009.id_ano=".$ano;	
		 $resp_subs = @pg_exec($conn,$sql_subs);
		 $num_subs = pg_numrows($resp_subs);
	  	
		for($k=0;$k<$num_subs;$k++){
		$fila_subs = pg_fetch_array($resp_subs,$k);
	
    		if($fila_subs['id_sub_sim']==$chk0){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  		if($fila_subs['id_sub_sim']==$chk1){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  		if($fila_subs['id_sub_sim']==$chk2){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  		if($fila_subs['id_sub_sim']==$chk3){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	  		if($fila_subs['id_sub_sim']==$chk4){
	  ?>
      <td width="12%" class="cuadro02"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3"><?=$fila_subs['nombre']?></div></td>
      <? 	}
	 }?>
    <td width="15%"><div align="center" bgcolor="#CCCCCC" class="Estilo21 Estilo20 Estilo3">Resultado Puntaje </div></td>
  </tr>
    <? 
  	 $sql_cursos="SELECT DISTINCT a.id_curso,b.grado_curso,b.letra_curso,b.ensenanza FROM simce_notas_2009 a INNER JOIN ";
	 $sql_cursos.="curso b ON (a.id_curso=b.id_curso) WHERE b.id_ano=".$ano." 	ORDER BY b.letra_curso ASC";
	 $res_cursos=@pg_exec($conn,$sql_cursos);
	 $conteo_cursos=pg_numrows($res_cursos);
  
  	for($j=0;$j<$conteo_cursos;$j++){
		$info_curso=pg_fetch_array($res_cursos,$j);
  ?>
  <tr class="cuadro01">
    <td width="15%"><div align="center" class="Estilo21 Estilo20 Estilo3"><?=$info_curso['grado_curso']."-".$info_curso['letra_curso']?></div></td>
    <?	for($k=0;$k<$num_subs;$k++){
		$fila_subs = pg_fetch_array($resp_subs,$k);
		
		$sql_puntaje="SELECT * FROM simce_notas_2009 WHERE id_curso=".$info_curso['id_curso']." ";
		$sql_puntaje.="and id_sub_sim=".$fila_subs['id_sub_sim']." and id_ano=".$ano."";
		$res_puntaje=@pg_exec($conn,$sql_puntaje);

		
		if($fila_subs['id_sub_sim']==$chk0){
	?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if(pg_numrows($res_puntaje)!=NULL){	
			for($n=0;$n<pg_numrows($res_puntaje);$n++){
			$nota_par=pg_fetch_array($res_puntaje,$n);	
			"<br>".$nota=round($nota+$nota_par['nota']);
			} 
			$nota=round($nota/$n);
			echo "<br>".$nota;}else{echo "-";}?></div></td>
			<? unset($nota);?>
	<?	 }
		if($fila_subs['id_sub_sim']==$chk1){?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if(pg_numrows($res_puntaje)!=NULL){	
			for($n=0;$n<pg_numrows($res_puntaje);$n++){
			$nota_par=pg_fetch_array($res_puntaje,$n);	
			"<br>".$nota1=round($nota1+$nota_par['nota']);
			} 
			$nota1=round($nota1/$n);
			echo $nota1;}else{echo "-";}?></div></td>
			<? unset($nota1);?>
	<? }
		if($fila_subs['id_sub_sim']==$chk2){?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if(pg_numrows($res_puntaje)!=NULL){	
			for($n=0;$n<pg_numrows($res_puntaje);$n++){
			$nota_par=pg_fetch_array($res_puntaje,$n);	
			"<br>".$nota2=round($nota2+$nota_par['nota']);
			} 
			$nota2=round($nota2/$n);
			echo $nota2;}else{echo "-";}?></div></td>
			<? unset($nota2);?>
	<? }
		if($fila_subs['id_sub_sim']==$chk3){?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if(pg_numrows($res_puntaje)!=NULL){	
			for($n=0;$n<pg_numrows($res_puntaje);$n++){
			$nota_par=pg_fetch_array($res_puntaje,$n);	
			"<br>".$nota3=round($nota3+$nota_par['nota']);
			} 
			$nota3=round($nota3/$n);
			echo $nota3;}else{echo "-";}?></div></td>
			<? unset($nota3);?>
	<? }
		if($fila_subs['id_sub_sim']==$chk4){?>
	<td width="12%"class="cuadro01"><div align="center" class="Estilo21 Estilo20 Estilo3"><? if(pg_numrows($res_puntaje)!=NULL){	
			for($n=0;$n<pg_numrows($res_puntaje);$n++){
			$nota_par=pg_fetch_array($res_puntaje,$n);	
			"<br>".$nota4=round($nota4+$nota_par['nota']);
			} 
			$nota4=round($nota4/$n);
			echo $nota4;}else{echo "-";}?></div></td>
			<? unset($nota4);?>
	<? }
    }?>
	<?
		$sql_prom="SELECT puntaje FROM simce_inst_2009 WHERE id_curso=".$info_curso['id_curso']." ";
		$sql_prom.="and rdb=".$institucion." and id_ano=".$ano."";
		$res_prom=@pg_exec($conn,$sql_prom);
		$prom_final=pg_result($res_prom,0);
	?>
	<td width="15%"><div align="center" class="Estilo21 Estilo20 Estilo3"><?=$prom_final?></div></td>
  </tr>
    <? }?>
</table>

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  <? }?>
</form>
</body>
</html>
<? pg_close($conn);?>