<?php
require('../../../../util/header.inc');
	
	$_POSP = 4;
	$_bot = 8;
	$ANO =$cmb_ano;	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $cmb_curso;
	$reporte		= $c_reporte;
	$count = 0;
for($i=1;$i<7;$i++){
	if(${"ck_".$i} == 1){
	$count = $count+1;
	}
}
//echo "count".$count;
//echo $cmb_tipo_ensenanza;
//echo $ANO;
//echo $valor;	
if($valor == "2"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_Psu_$Fecha.xls"); 
	
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
function enviapag2(form){
		form.target="_blank";
		form.action='print_Informe_psu.php?cmb_tipo_ensenanza=<?=$cmb_tipo_ensenanza?>&r_ordena=<?=$r_ordena?>&cmb_ano=<?=$ANO?>&ck_1=<?=$ck_1?>&ck_2=<?=$ck_2?>&ck_3=<?=$ck_3?>&ck_4=<?=$ck_4?>&ck_5=<?=$ck_5?>&ck_6=<?=$ck_6?>&ck_7=<?=$ck_7?>&r_puntaje=<?=$r_puntaje?>&valor=2';
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
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div id="capa0">
	<table width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </td>
	    <td align="right"><input name="button4" type="button" class="botonXX" onClick="enviapag2(this.form)"  value="EXPORTAR"></td>
	  </tr></table>
      
      </div></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
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
			</table>
		</td>
	<? }  ?>
	</tr>
</table>
<? if($r_ordena == 1){?>
<?
	$sql_curso="select a.grado_curso,letra_curso,b.nombre_tipo from curso a 
inner join tipo_ensenanza b on (a.ensenanza=b.cod_tipo) where a.id_curso=$curso	";
	$resp_curso=pg_exec($conn,$sql_curso);
	$fila_curso=pg_fetch_array($resp_curso,0);
	$nombre_curso=$fila_curso['grado_curso']."-".$fila_curso['letra_curso']." ".$fila_curso['nombre_tipo'];

?>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#CCCCCC"><div align="left" class=" Estilo11"><strong>CURSO:<?=$nombre_curso;?></strong></div></td>
    </tr>
</table>
<br/>
<? }?>
<table width="650" border="1" cellpadding="2" cellspacing="0" align="center">
  <tr>
  <? if($r_ordena == 2){?>
    <td width="5%" bgcolor="#CCCCCC"><div align="center" class="Estilo21 Estilo20 Estilo3 Estilo3"><strong>Curso</strong></div></td>
	<? }
	if($r_ordena == 1){?>
    <td width="7%" bgcolor="#CCCCCC"><div align="center" class="Estilo21 Estilo20 Estilo3 Estilo3"><strong>RUT</strong></div></td>
	<td width="7%" bgcolor="#CCCCCC"><div align="center" class="Estilo21 Estilo20 Estilo3 Estilo3"><strong>Alumnos</strong></div></td>
    <? }?>
	<? if($ck_1==1){?>
	<td width="10%" bgcolor="#CCCCCC"><div align="center" class="Estilo21 Estilo20 Estilo3 Estilo3"><strong>HISTORIA Y CIENCIAS SOCIALES</strong></div></td>
    <? }
	if($ck_2==1){?>
    <td width="10%" bgcolor="#CCCCCC"><div align="center" class="Estilo21 Estilo20 Estilo3 Estilo3"><strong>MATEMATICA</strong></div></td>
    <? }
	if($ck_3==1){?>  
	<td width="10%" bgcolor="#CCCCCC"><div align="center" class="Estilo21 Estilo20 Estilo3 Estilo3"><strong>BIOLOGIA</strong></div></td>
	<? }
   	if($ck_4==1){?> 
	<td width="10%" bgcolor="#CCCCCC"><div align="center" class="Estilo21 Estilo20 Estilo3 Estilo3"><strong>QUIMICA</strong></div></td>
  	<? }
  	if($ck_5==1){?>
	<td width="10%" bgcolor="#CCCCCC"><div align="center" class="Estilo21 Estilo20 Estilo3 Estilo3"><strong>FISICA</strong></div></td>
  	<? }
  	if($ck_6==1){?>	
    <td width="10%" bgcolor="#CCCCCC"><div align="center" class="Estilo21 Estilo20 Estilo3 Estilo3"><strong>LENGUA CASTELLANA Y COMUNIC.</strong></div></td>
   	<? }
   	if($ck_7==1){?> 
	<td width="10%" bgcolor="#CCCCCC"><div align="center" class="Estilo21 Estilo20 Estilo3 Estilo3"><strong>CIENCIAS</strong></div></td>
  	<? }?>
	<? if($r_puntaje==2){?>
    <td width="10%" bgcolor="#CCCCCC"><div align="center" class="Estilo21 Estilo20 Estilo3 Estilo3"><strong>Promedio</strong></div></td>
    <? }?>
	<td width="15%" bgcolor="#CCCCCC"><div align="center" class="Estilo21 Estilo20 Estilo3 Estilo3"><strong>Puntaje PSU</strong></div></td>
  </tr>
  <?
  
   		$sql = "SELECT nro_ano FROM ano_escolar WHERE id_institucion =".$institucion." and id_ano=".$ANO;
		$resp = @pg_exec($conn,$sql);
		$num = @pg_result($resp,0);
  
  
  if($r_ordena == 1){//SELECCIONA ALUMNOS 
   		$sql =" SELECT DISTINCT(a.rut_alumno),b.nombre_alu,b.ape_pat,b.ape_mat FROM psu_notas_2009 a INNER JOIN ";
		$sql.="alumno b ON (a.rut_alumno=b.rut_alumno) INNER JOIN matricula$num c ON(b.rut_alumno=c.rut_alumno) ";
		$sql.="WHERE a.cod_ano=".$ANO." AND c.id_curso=".$curso." ORDER BY b.ape_pat ASC ";
  }else{//SELECCIONA RESULTADOS POR CURSO
  		$sql="SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo ";
		$sql.="FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql.="WHERE (((curso.id_ano)=".$ANO.")) and ensenanza=310 and grado_curso=4 ORDER BY ";
		$sql.=" curso.ensenanza, curso.grado_curso, curso.letra_curso ";
  }
  
  		$resp = pg_exec($conn,$sql);
		$num_ordena = pg_numrows($resp);
		for($i=0;$i<$num_ordena;$i++){
		$fila_X= pg_fetch_array($resp,$i);
		
  ?>
 
  <tr>
  <? if($r_ordena == 2){
  		$nombre = $fila_X['grado_curso']."-".$fila_X['letra_curso'];
  ?>
    <td width="5%"><div align="left"><span class="Estilo24">
      <?=$nombre?>
    </span></div></td>
	<? }
	if($r_ordena == 1){
	$nombre = $fila_X['ape_pat']." ".$fila_X['ape_mat'].",".$fila_X['nombre_alu'];
	?>
    <td width="7%"><div align="left"><span class="Estilo24"><?=$fila_X['rut_alumno']?></span></div></td>
	<td width="7%"><div align="left"><span class="Estilo24"><?=$nombre?></span></div></td>
    <? }?>
	<? if($ck_1==1){
		if($r_ordena == 1){
			$sql_1="SELECT puntaje FROM psu_notas_2009 WHERE cod_sub_psu=(SELECT cod_sub_psu ";
			$sql_1.=" FROM psu_conf_2009 WHERE cod_ano=".$ANO." AND cod_subsector=1) AND rut_alumno=".$fila_X['rut_alumno'];
		}else{
			 $sql_1="SELECT puntaje FROM psu_promedios_2009 WHERE id_subsector=1 AND id_ano=".$ANO." AND curso=".$fila_X['id_curso'];
		}
		$resp_1 = pg_exec($conn,$sql_1);
	?>
	<td width="10%"><div align="center" class="Estilo24">
	  <div align="center">
	    <? if(pg_result($resp_1,0)==NULL){ echo "-"; }else{ echo pg_result($resp_1,0); }?>
	      </div>
	</div></td>
	<? }
  	if($ck_2==1){
		if($r_ordena == 1){
			$sql_2="SELECT puntaje FROM psu_notas_2009 WHERE cod_sub_psu=(SELECT cod_sub_psu ";
			$sql_2.=" FROM psu_conf_2009 WHERE cod_ano=".$ANO." AND cod_subsector=2) AND rut_alumno=".$fila_X['rut_alumno'];
		}else{
			$sql_2="SELECT puntaje FROM psu_promedios_2009 WHERE id_subsector=2 AND id_ano=".$ANO." AND curso=".$fila_X['id_curso'];;
		}	
		$resp_2 = pg_exec($conn,$sql_2);
	?>
	<td width="10%"><div align="center" class="Estilo24">
	  <div align="center">
	    <? if(pg_result($resp_2,0)==NULL){ echo "-"; }else{ echo pg_result($resp_2,0); }?>
	      </div>
	</div></td>
    <? }
    if($ck_3==1){
		if($r_ordena == 1){
			$sql_3="SELECT puntaje FROM psu_notas_2009 WHERE cod_sub_psu=(SELECT cod_sub_psu ";
			$sql_3.=" FROM psu_conf_2009 WHERE cod_ano=".$ANO." AND cod_subsector=3) AND rut_alumno=".$fila_X['rut_alumno'];
		}else{
			$sql_3="SELECT puntaje FROM psu_promedios_2009 WHERE id_subsector=3 AND id_ano=".$ANO." AND curso=".$fila_X['id_curso'];;
		}
		$resp_3 = pg_exec($conn,$sql_3);
	
	?> 
	<td width="8%"><div align="center" class="Estilo24">
	  <div align="center">
	    <? if(pg_result($resp_3,0)==NULL){ echo "-"; }else{ echo pg_result($resp_3,0); }?>
	      </div>
	</div></td>
	<? }
  	if($ck_4==1){
		if($r_ordena == 1){
			$sql_4="SELECT puntaje FROM psu_notas_2009 WHERE cod_sub_psu=(SELECT cod_sub_psu ";
			$sql_4.=" FROM psu_conf_2009 WHERE cod_ano=".$ANO." AND cod_subsector=4) AND rut_alumno=".$fila_X['rut_alumno'];
		}else{
			$sql_4="SELECT puntaje FROM psu_promedios_2009 WHERE id_subsector=4 AND id_ano=".$ANO." AND curso=".$fila_X['id_curso'];;
		}
		$resp_4 = pg_exec($conn,$sql_4);
	?> 
    <td width="8%"><div align="center" class="Estilo24">
      <div align="center">
        <? if(pg_result($resp_4,0)==NULL){ echo "-"; }else{ echo pg_result($resp_4,0); }?>
        </div>
    </div></td>
    <? }
  	if($ck_5==1){
		if($r_ordena == 1){
			$sql_5="SELECT puntaje FROM psu_notas_2009 WHERE cod_sub_psu=(SELECT cod_sub_psu ";
			$sql_5.=" FROM psu_conf_2009 WHERE cod_ano=".$ANO." AND cod_subsector=5) AND rut_alumno=".$fila_X['rut_alumno'];
		}else{
			$sql_5="SELECT puntaje FROM psu_promedios_2009 WHERE id_subsector=5 AND id_ano=".$ANO." AND curso=".$fila_X['id_curso'];
		}
		$resp_5 = pg_exec($conn,$sql_5);
	?>
	<td width="6%"><div align="center" class="Estilo24">
	  <div align="center">
	    <? if(pg_result($resp_5,0)==NULL){ echo "-"; }else{ echo pg_result($resp_5,0); }?>
	      </div>
	</div></td>
  	<? }
	if($ck_6==1){
		if($r_ordena == 1){
			$sql_6="SELECT puntaje FROM psu_notas_2009 WHERE cod_sub_psu=(SELECT cod_sub_psu ";
			$sql_6.=" FROM psu_conf_2009 WHERE cod_ano=".$ANO." AND cod_subsector=6) AND rut_alumno=".$fila_X['rut_alumno'];
		}else{
			$sql_6="SELECT puntaje FROM psu_promedios_2009 WHERE id_subsector=6 AND id_ano=".$ANO." AND curso=".$fila_X['id_curso'];
		}
		$resp_6 = pg_exec($conn,$sql_6);
	?>	
    <td width="10%"><div align="center" class="Estilo24">
      <div align="center">
        <? if(pg_result($resp_6,0)==NULL){ echo "-"; }else{ echo pg_result($resp_6,0); }?>
        </div>
    </div></td>
   	<? }
	if($ck_7==1){
	if($r_ordena == 1){
		$sql_7="SELECT puntaje FROM psu_notas_2009 WHERE cod_sub_psu=(SELECT cod_sub_psu ";
		$sql_7.=" FROM psu_conf_2009 WHERE cod_ano=".$ANO." AND cod_subsector=7) AND rut_alumno=".$fila_X['rut_alumno'];
	}else{
		$sql_7="SELECT puntaje FROM psu_promedios_2009 WHERE id_subsector=7 AND id_ano=".$ANO." AND curso=".$fila_X['id_curso'];
	}
		$resp_7 = pg_exec($conn,$sql_7);
	?> 
	<td width="8%"><div align="center" class="Estilo24">
	  <div align="center">
	    <? if(pg_result($resp_7,0)==NULL){ echo "-"; }else{ echo pg_result($resp_7,0); }?>
	      </div>
	</div></td>
  	<? }
	if($r_puntaje==2){
	if($r_ordena ==1){
		$sql_prom = "SELECT promedio FROM promedio_alumno WHERE rut_alumno=".$fila_X['rut_alumno']." AND id_ano=".$ANO;
	}else{
		$sql_prom = "SELECT promedio FROM promedio_curso WHERE id_curso =".$fila_X['id_curso']." AND id_ano=".$ANO;
	}
		$resp_prom= pg_exec($conn,$sql_prom);
	?>
    <td width="8%"><div align="center" class="Estilo24">
      <div align="center">
        <? if(pg_result($resp_prom,0)==NULL){ echo "-"; }else{ echo pg_result($resp_prom,0); }?>
        </div>
    </div></td>
    <? }
	if($r_ordena == 1){
		$sql_pn="SELECT puntaje FROM psu_puntajes_2009 WHERE cod_ano=".$ANO." AND rut_alumno=".$fila_X['rut_alumno'];
	}else{
		$sql_pn ="SELECT puntaje FROM psu_promedios_2009 WHERE id_subsector=999999 and id_ano=".$ANO." AND curso=".$fila_X['id_curso'];
	}
	$resp_pn = pg_exec($conn,$sql_pn);
	?>
	<td width="20%">
	<div align="center" class="Estilo24">
		<div align="center">
		  <? if(pg_result($resp_pn,0)==NULL){ echo "-"; }else{ echo pg_result($resp_pn,0); }?>
	      </div>
	</div>	</td>
  </tr> 
  <? }//FIN FOR?>
</table>
</form>
</body>
</html>
<? pg_close($conn);?>