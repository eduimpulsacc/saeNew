<?php
require('../../../../util/header.inc');	
include('../../../clases/class_Reporte.php');
	$_POSP = 4;
	$_bot = 8;
	$cmb_alumnos=$_POST['cmb_alumnos'];
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $cmb_curso;
	$reporte		= $c_reporte;
	//echo $cmb_estados;
	$count = 0;
for($i=1;$i<7;$i++){
	if(${"ck_".$i} == 1){
	$count = $count+1;
	}
}
/************** CURSO ***********************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
if($valor == "1"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_Practicas_$Fecha.xls"); 
	
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
function enviapag2(form){ //-------------------para exportar
		form.target="_blank";
		form.action='PrintInformePracticas.php?valor=1&cmb_estados=<?=$cmb_estados?>&cmb_alumnos=<?=$cmb_alumnos?>&r_ordena=<?=$r_ordena?>&cmb_ano=<?=$ANO?>&ck_1=<?=$ck_1?>&ck_2=<?=$ck_2?>&ck_3=<?=$ck_3?>&ck_4=<?=$ck_4?>&ck_5=<?=$ck_5?>&ck_6=<?=$ck_6?>&ck_7=<?=$ck_7?>&r_puntaje=<?=$r_puntaje?>';
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
</script>
<script src="../../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

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
</style>
<body>

<form name="form" action="PrintInformePracticas.php" method="post">
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div id="capa0">
	<table width="100%" align="center">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </td>
	    <td align="right"><input name="button4" type="button" class="botonXX" onClick="enviapag2(this.form)"  value="EXPORTAR"></td>
	  </tr></table>
      
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
<br/>
<?
//-----------------------------obtener alumnos-----------------------------------
 if($cmb_alumnos==0){
 
 		$sql="select distinct  a.nombre_alu,a.rut_alumno,a.dig_rut,a.ape_pat,a.ape_mat,b.fecha_ini, ";
		$sql.=" nombre_emp,c.cod_estado,nombre_estado from alumno a "; 
		$sql.=" INNER JOIN practicas b ON (a.rut_alumno=b.rut_alu) INNER JOIN estado_practica c ";
		$sql.=" ON (b.estado=c.cod_estado) INNER JOIN matricula d ON (b.rut_alu=d.rut_alumno)";
	
	if($cmb_estados!=0 and $cmb_estados!=100){
	
		$sql.=" where c.cod_estado=$cmb_estados and d.id_ano=$ano"; 
	
	  }else{
	  
	  	$sql.=" where d.id_curso=$curso AND c.cod_estado=$cmb_estados and d.id_ano=$ano order by c.cod_estado ASC";
	  
	  } 
  }else{
  
  		$sql="select distinct  a.nombre_alu,a.rut_alumno,a.dig_rut,a.ape_pat,a.ape_mat,b.fecha_ini,nombre_emp,c.nombre_estado,c.cod_estado from alumno a ";
		$sql.=" INNER JOIN practicas b ON (a.rut_alumno=b.rut_alu) INNER JOIN estado_practica c ON (b.estado=c.cod_estado) INNER JOIN matricula d ON (b.rut_alu=d.rut_alumno) WHERE id_curso=$curso ";
		
	if($cmb_alumnos!=1 and ($cmb_estados!=0 and $cmb_estados!=100)){	
		
		$sql.=" AND a.rut_alumno=$cmb_alumnos and c.cod_estado=$cmb_estados and d.id_ano=$ano order by b.fecha_ini DESC ";
	
		}
	if($cmb_alumnos!=1 and ($cmb_estados==0 or $cmb_estados==100)){	
		
		$sql.=" AND a.rut_alumno=$cmb_alumnos and d.id_ano=$ano order by b.fecha_ini DESC ";
			
	 }
	if(($cmb_estados!=100 and $cmb_estados!=0) and $cmb_alumnos==1){
	
		$sql.=" AND c.cod_estado=$cmb_estados and d.id_ano=$ano";
	
	}
	
	if($cmb_estados==100 and $cmb_alumnos==1){
	  
			
	}
		
		
	}
	//echo $sql;
	$rs_sql= pg_exec($conn,$sql);

//------------------------------------------------------------------------------
?>
<?  if($cmb_alumnos>1){?>
<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" class="tableindex"><div align="center">REPORTE DE ESTADOS</div></td>
  </tr>
  <tr>
    <td width="104"><strong class="item">CURSO</strong></td>
    <td width="21"><strong>:</strong></td>
    <td width="515" class="item"><?=$Curso_pal;?></td>
  </tr>
</table>
<table width="640" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="tablatit2-1">
    <td colspan="3"><div align="left">Nombre Alumno :
      <?
    	$sql="select nombre_alu,rut_alumno,dig_rut,ape_pat,ape_mat from alumno ";
		$sql.=" where rut_alumno=$cmb_alumnos";
		$rs_alumno=pg_exec($conn,$sql);
		$alumno = pg_fetch_array($rs_alumno,0);
	
	?>
      <font face="Arial, Helvetica, sans-serif" size="-1"><strong>
        <?=$ob_reporte->tilde(ucwords(strtolower($alumno['nombre_alu']." ".$alumno['ape_pat']." ".$alumno['ape_mat'])));?>
      </strong></font></div></td>
    </tr>
  <tr>
    <td width="187"><div align="center">Nombre Empresa</div></td>
    <td width="208"><div align="center">Fecha Inicio Practica</div></td>
    <td width="234"><div align="center">Estado</div></td>
    </tr>
      <?
  	for($i=0;$i<pg_numrows($rs_sql);$i++){
  		$lista=pg_fetch_array($rs_sql,$i);
	
  	//////////////////////////////////////////////////
	$FECHAC1= $lista['fecha_ini'];
	$AA1 = substr ("$FECHAC1;", 0, -7); 
	$mm1 = substr ("$FECHAC1;", 5, -4);
	$dd1 = substr ("$FECHAC1;", 8, -1);
	$dia11 = getdate(mktime(0,0,0,$mm1,$dd1,$AA1));
	$dia1 = $dia11["mday"];
	if($dia1<10){
		$dia1 = "0".$dia1;
	}else{
		$dia1;
		}
	$mes1 = $dia11["mon"];
	if($mes1<10){
		$mes1 = "0".$mes1;
	}else{
		$mes1;
	}
	$fecha_mes1 = $dia1."-".$mes1;
	$FECHAC1 = $fecha_mes1."-".$dia11["year"];
	////////////////////////////////////////////////
  
  ?>
  <tr>
    <td><div align="center">
      <?=$lista['nombre_emp']?>
    </div></td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
      <?=$FECHAC1?>
    </strong></font></div></td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
      <?=$lista['nombre_estado']?>
    </strong></font></div></td>
    </tr>
  <? }?>
   
</table>

<? }else{ ?>
		<? if ($cmb_estados==5){?>
		<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="3" class="tableindex"><div align="center">REPORTE DE ESTADOS</div></td>
          </tr>
          <tr>
            <td width="104"><strong class="item">CURSO</strong></td>
            <td width="21"><strong>:</strong></td>
            <td width="515" class="item"><?=$Curso_pal;?></td>
          </tr>
        </table>
		<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">	
  <tr class="tablatit2-1">
    <td width="159"><div align="center">Rut</div></td>
    <td width="173"><div align="center">Nombre Alumno</div></td>
    <td width="138"><div align="center">Fecha Entrega Titulo</div></td>
    <td width="170"><div align="center">N&ordm; De Titulo</div></td>
  </tr>
  <?
 		$sql="select distinct a.rut_alumno,a.dig_rut,a.nombre_alu,a.ape_pat,a.ape_mat,";
		$sql.="c.estado,c.id_practica,e.* from alumno a ";
		$sql.="inner join matricula b on (a.rut_alumno=b.rut_alumno) ";
		$sql.="inner join practicas c on (a.rut_alumno=c.rut_alu)  ";
		$sql.="inner join titulacion e on (a.rut_alumno=e.rut_alu) ";
		$sql.="where c.estado=5 and b.id_ano=$ano "; //b.id_ano=$ano and b.id_curso=$curso and b.rdb=$institucion and //revisar 
		$resp=pg_exec($conn,$sql);
		//echo $sql;		
	for($i=0;$i<pg_numrows($resp);$i++){
  		$lista=pg_fetch_array($resp,$i);
		
		
  	//////////////////////////////////////////////////
	$FECHAC1= $lista['fecha_entrega_titulo'];
	$AA1 = substr ("$FECHAC1;", 0, -7); 
	$mm1 = substr ("$FECHAC1;", 5, -4);
	$dd1 = substr ("$FECHAC1;", 8, -1);
	$dia11 = getdate(mktime(0,0,0,$mm1,$dd1,$AA1));
	$dia1 = $dia11["mday"];
	if($dia1<10){
		$dia1 = "0".$dia1;
	}else{
		$dia1;
		}
	$mes1 = $dia11["mon"];
	if($mes1<10){
		$mes1 = "0".$mes1;
	}else{
		$mes1;
	}
	$fecha_mes1 = $dia1."-".$mes1;
	$FECHAC1 = $fecha_mes1."-".$dia11["year"];
	////////////////////////////////////////////////
  
  ?>
  <tr>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
      <?=$lista['rut_alumno']."-".$lista['dig_rut']?>
    </strong></font></div></td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
      <?=ucfirst($lista['nombre_alu']." ".$lista['ape_pat']." ".$lista['ape_mat'])?>
    </strong></font></div></td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
      <?=$FECHAC1?>
      &nbsp;</strong></font></div></td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
      <?=$lista['numero_titulo']?>
    </strong></font></div></td>
  </tr>
  <? }?>
  
</table>
        
  <? }else{?>
  <table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="3" class="tableindex"><div align="center">REPORTE DE ESTADOS</div></td>
    </tr>
    <tr>
      <td width="104"><strong class="item">CURSO</strong></td>
      <td width="21"><strong>:</strong></td>
      <td width="515" class="item"><?=$Curso_pal;?></td>
    </tr>
  </table>
  <table width="649" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="tablatit2-1">
    <td width="159"><div align="center">Rut</div></td>
    <td width="173"><div align="center">Nombre Alumno</div></td>
    <td width="138"><div align="center">Fecha Inicio Practica</div></td>
    <td width="169"><div align="center">Estado</div></td>
  </tr>
  <?
 
		
  	for($i=0;$i<pg_numrows($rs_sql);$i++){
  		$lista=pg_fetch_array($rs_sql,$i);
		
		
  	//////////////////////////////////////////////////
	$FECHAC1= $lista['fecha_ini'];
	$AA1 = substr ("$FECHAC1;", 0, -7); 
	$mm1 = substr ("$FECHAC1;", 5, -4);
	$dd1 = substr ("$FECHAC1;", 8, -1);
	$dia11 = getdate(mktime(0,0,0,$mm1,$dd1,$AA1));
	$dia1 = $dia11["mday"];
	if($dia1<10){
		$dia1 = "0".$dia1;
	}else{
		$dia1;
		}
	$mes1 = $dia11["mon"];
	if($mes1<10){
		$mes1 = "0".$mes1;
	}else{
		$mes1;
	}
	$fecha_mes1 = $dia1."-".$mes1;
	$FECHAC1 = $fecha_mes1."-".$dia11["year"];
	////////////////////////////////////////////////
  
  ?>
  <tr>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
      <?=$lista['rut_alumno']."-".$lista['dig_rut']?>
    </strong></font></div></td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
      <?=ucfirst($lista['nombre_alu']." ".$lista['ape_pat']." ".$lista['ape_mat'])?>
    </strong></font></div></td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
      <?=$FECHAC1?>
      &nbsp;</strong></font></div></td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
      <?=$lista['nombre_estado']?>
    </strong></font></div></td>
  </tr>
  <? switch ($lista['cod_estado']){
  		case 1:
			$cont_1++;
			break;
		case 2:
			$cont_2++;
			break;
		case 3:
			$cont_3++;
			break;
		case 4:
			$cont_4++;
			break;
		case 5:
			$cont_5++;
			break;
		case 6:
			$cont_6++;
			break;
		case 7:
			$cont_7++;
			break;
	  }
  }?>
  
  </table>
<br>
<table width="649" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr  class="tablatit2-1">
		<td class="item">PRACTICA REPROBADA</td>
		<td class="item">EN PRACTICA</td>
		<td class="item">PRACTICA APROBADA</td>
		<td class="item">EN PROCESO DE TITULACION</td>
		<td class="item">TITULADO</td>
		<td class="item">VARIOS (ESTUDIOS UNIVERSITARIOS)</td>
		<td class="item">VARIOS (DESICION PERSONAL)</td>
    </tr>
	  <tr>
		<td class="subitem">&nbsp;<?=$cont_1;?></td>
		<td class="subitem">&nbsp;<?=$cont_2;?></td>
		<td class="subitem">&nbsp;<?=$cont_3;?></td>
		<td class="subitem">&nbsp;<?=$cont_4;?></td>
		<td class="subitem">&nbsp;<?=$cont_5;?></td>
		<td class="subitem">&nbsp;<?=$cont_6;?></td>
		<td class="subitem">&nbsp;<?=$cont_7;?></td>
	  </tr>
  </table>

  <? }?>
 <? }
 
 
 ?>
 <table width="650" border="0" align="center">
  <tr>
	<?  
	if($ob_config->firma1!=0){
		$ob_reporte->cargo=$ob_config->firma1;
		$ob_reporte->empleado=$ob_config->empleado1;
		$ob_reporte->rdb=$institucion;
		$ob_reporte->curso=$curso;
		$ob_reporte->Firmas($conn);?>
	<td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000">
		<div align="center">
		  <?=$ob_reporte->nombre_emp;?>
		  <br>
		  <?=$ob_reporte->nombre_cargo;?>
	  </div></td>
	<? } ?>
	<? if($ob_config->firma2!=0){
			$ob_reporte->cargo=$ob_config->firma2;
			$ob_reporte->empleado=$ob_config->empleado2;
			$ob_reporte->curso=$curso;
			$ob_reporte->rdb=$institucion;
			$ob_reporte->Firmas($conn);?>
	<td width="25%" class="item"><hr align="center" width="150" color="#000000">
		<div align="center">
		  <?=$ob_reporte->nombre_emp;?>
		  <br>
		  <?=$ob_reporte->nombre_cargo;?>
	  </div></td>
	<? } ?>
	<? if($ob_config->firma3!=0){
			$ob_reporte->cargo=$ob_config->firma3;
			$ob_reporte->empleado=$ob_config->empleado3;
			$ob_reporte->curso=$curso;
			$ob_reporte->rdb=$institucion;
			$ob_reporte->Firmas($conn);?>
	<td width="25%" class="item"><hr align="center" width="150" color="#000000">
		<div align="center">
		  <?=$ob_reporte->nombre_emp;?>
		  <br>
		  <?=$ob_reporte->nombre_cargo;?>
	  </div></td>
	<? } ?>
	<? if($ob_config->firma4!=0){
			$ob_reporte->cargo=$ob_config->firma4;
			$ob_reporte->empleado=$ob_config->empleado4;
			$ob_reporte->curso=$curso;
			$ob_reporte->rdb=$institucion;
			$ob_reporte->Firmas($conn);?>
	<td width="25%" class="item"><hr align="center" width="150" color="#000000">
		<div align="center">
		  <?=$ob_reporte->nombre_emp;?>
		  <br>
		  <?=$ob_reporte->nombre_cargo;?>
	  </div></td>
	<? }?>
  </tr>
</table>

</form>
</body>
</html>
<? pg_close($conn);?>