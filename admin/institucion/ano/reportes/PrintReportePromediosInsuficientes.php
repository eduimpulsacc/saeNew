<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
/*if($_PERFILL==0){
print_r($_POST);
}*/

if(!isset($chk_aprec)){
	$chk_aprec=0;
	}
 $chk_aprec;
	$_POSP = 4;
	$_bot = 8;
	
	 $institucion	= $_INSTIT;
	 $ano			= $_ANO;
	$docente		= 5; //Codigo Docente
	$frmModo		= $_FRMMODO;
	$ensenanza	= $cmb_ensenanza;
	$reporte		= $c_reporte;
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	$sql ="SELECT id_curso FROM curso WHERE id_ano=".$ano." AND ensenanza=".$ensenanza;
	$rs_curso = @pg_exec($conn,$sql);
	$curso = pg_result($rs_curso,0);

	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	$fecha=$ob_reporte->fecha_actual();

	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);

$sql_per="select * from  periodo where periodo.id_periodo=".$cmb_periodos;
		$result_p =pg_Exec($conn,$sql_per);
		$fila_p = pg_fetch_array($result_p,$sql_per);
		 $nombre_per=$fila_p['nombre_periodo'];

$sql_nro_ano="select an.nro_ano from ano_escolar an where an.id_ano=".$ano;
			$result_a =pg_Exec($conn,$sql_nro_ano);
			$fila_nro_ano = pg_fetch_array($result_a,$sql_nro_ano);
			 $nro_ano=$fila_nro_ano['nro_ano'];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<SCRIPT language="JavaScript">
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
									
</script>


<script language="JavaScript" type="text/JavaScript">
<!--

function imprimir(){
Element = document.getElementById("layer1")
Element.style.display='none';
Element = document.getElementById("layer2")
Element.style.display='none';
window.print();
Element = document.getElementById("layer1")
Element.style.display='';
Element = document.getElementById("layer2")
Element.style.display='';
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
//-->
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

function exportar(){
		//	window.location='printCartaApoderado_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
			return false;
		  }		  
		  
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 
<!-- INICIO CUERPO DE LA PAGINA -->

<form name="form" method="post" action="PrintReportePromediosInsuficientes.php" target="_blank">
<div id="capa0">
  <table width="650" align="center">
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
      </td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	  <? if($_PERFIL==0){?>		  
		<!--<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">-->
	<? }?>
      </td>
    </tr>
  </table>
</div>
<br>
<table width="75%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
		    <td width="487" class="item"><strong><? echo strtoupper(trim($ob_membrete->ins_pal));?></strong></td>
		    <td width="11">&nbsp;</td>
		    <td width="152" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
		      <tr valign="top" >
		        <td width="125" align="center"><?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## c&oacute;digo para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?></td>
	          </tr>
		      </table></td>
	      </tr>
		  <tr>
		    <td class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td class="item">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td height="41">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
  </table>
		<br>
  <table width="75%" align="center">
	<tr><td class="tableindex" align="center"><div align="center">

<u>RESULTADOS DEL <?=$nombre_per.' '.$nro_ano?></u> </div>

</td></tr>
</table>
<br><br><br>
<div style="margin-left:13%"  class="titulo">

<?
if($orden==0){
		
		$orden="Menor a";
		}else{
			$orden="Mayor a";
			}
?>
Nota&nbsp;<span> <?=$orden.' '.$nota?></span>
</div>
<br>
<table width="75%" border="1"  align="center" style="border-collapse:collapse" cellpadding="1" cellspacing="2">
<tr>
<td class="item">
NIVEL
</td>
<?
	$sql_nivel="SELECT DISTINCT curso.grado_curso, curso.ensenanza,tipo_ensenanza.nombre_tipo
				FROM curso 
				INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo 
				WHERE curso.ensenanza=".$ensenanza." and curso.id_ano=".$ano." ORDER BY grado_curso ASC";

				$result_nivel = @pg_exec($conn,$sql_nivel)or die("Fallo 1-".$sql_nivel);
				for($e=0 ; $e < @pg_numrows($result_nivel) ; $e++)
	{
		$fila_nivel = @pg_fetch_array($result_nivel,$e);
		$nombre_tipo=$fila_nivel['nombre_tipo'];
		if($ensenanza==110){
		$nombre_T=substr($nombre_tipo,9,7);
	}
		if($ensenanza==310){
			$nombre_T=substr($nombre_tipo,9,7);
	}
?>
<td colspan="2" class="subitem"><?=$fila_nivel['grado_curso'].'º'.$nombre_T?></td>
<? } ?>

</tr>
<tr>
<td class="item">MATRICULA</td>
<?
	for($e=0 ; $e < @pg_numrows($result_nivel) ; $e++)
	{
		$fila_nivel = @pg_fetch_array($result_nivel,$e);
		
		$sql_mat="select count(*) as cantidad from matricula ma
		inner join curso cu on ma.id_curso=cu.id_curso
		WHERE cu.ensenanza=".$ensenanza." and ma.id_ano=".$ano." AND cu.grado_curso=".$fila_nivel['grado_curso'];
		$result_mat = @pg_exec($conn,$sql_mat)or die("Fallo 2-".$sql_mat);
		$fila_m = @pg_fetch_array($result_mat,$sql_mat);
		
?>
<td colspan="2" align="center" class="subitem"><?=$fila_m['cantidad']?></td>
<? } ?>


</tr>
<tr>
  <td width="%" class="item">CANTIDAD / PORCENTAJES</td>
  <?

	for($e=0 ; $e < @pg_numrows($result_nivel) ; $e++)
	{
		
?>
<td width="%" align="center" class="subitem">C&nbsp;&nbsp;</td>
<td width="%" align="center" class="subitem">%</td>
<? } ?>

</tr>
<tr>
<td>&nbsp;</td>
 <?

	for($e=0 ; $e < @pg_numrows($result_nivel) ; $e++)
	{
		
?>
<td width="%" align="center">&nbsp;&nbsp;</td>
<td width="%" align="center">&nbsp;</td>
<? } ?>
</tr>



<tr>
<TD class="item">SUBSECTORES</TD>
<?
for($e=0 ; $e <@pg_numrows($result_nivel) ; $e++)
	{
		
?>
<td width="%" align="center">&nbsp;&nbsp;</td>
<td width="%" align="center">&nbsp;</td>
<? } ?>
<tr>
<?
	 $sql_subsec="select DISTINCT ramo.cod_subsector,subsector.nombre  from ramo
				inner join subsector on ramo.cod_subsector=subsector.cod_subsector
				WHERE id_curso IN
				(select id_curso from curso where curso.id_ano=".$ano." and curso.ensenanza=".$ensenanza.")
				order by subsector.nombre";
			
				$result_subsec = @pg_exec($conn,$sql_subsec)or die("Fallo 1-".$sql_subsec);
				for($i=0 ; $i < @pg_numrows($result_subsec) ; $i++){
				$fila_sub = @pg_fetch_array($result_subsec,$i);
	?>
<td class="subitem"><?=$fila_sub['nombre']?></td>
<?
	for($e=0 ; $e < @pg_numrows($result_nivel) ; $e++)
	{
		$fila_nivel = @pg_fetch_array($result_nivel,$e);
?>
<td width="%" align="center" class="subitem">
<?
	
	if($_POST['orden']==0){
		$orden="<";
		}else if($_POST['orden']==1){
			$orden=">";
			}
			
			if($chk_aprec==1){
				$promedio_desde="notaap";
				}else{ 
	           $promedio_desde="promedio"; 
			}

	        $qry="select count(*) as contador from notas$nro_ano
	 		
		   where id_ramo in (select id_ramo from ramo 
		   inner join curso c on ramo.id_curso=c.id_curso
		   where c.id_ano=".$ano." and c.ensenanza=".$ensenanza." and c.grado_curso=".$fila_nivel['grado_curso']." AND
		   ramo.cod_subsector=".$fila_sub['cod_subsector'].") and notas$nro_ano.id_periodo=".$cmb_periodos." and $promedio_desde $orden '".$nota."' AND promedio not in('0',' ')"; 
		   $result_not = @pg_exec($conn,$qry)or die("Fallo 2-".$qry);
		   $fila_not = @pg_fetch_array($result_not,$qry);
		   $cant_notas=$fila_not['contador'];	
		   		   
		   if($cant_notas==0){
			   $cant_notas=" ";
			   }
		    echo $cant_notas;
?>

</td>
<td width="%" align="center" class="subitem">
<?
	 $sql_mat="select count(*) as cantidad from matricula ma
		inner join curso cu on ma.id_curso=cu.id_curso
		WHERE cu.ensenanza=".$ensenanza." and ma.id_ano=".$ano." AND cu.grado_curso=".$fila_nivel['grado_curso'];
		$result_mat = @pg_exec($conn,$sql_mat)or die("Fallo 2-".$sql_mat);
		$fila_m = @pg_fetch_array($result_mat,$sql_mat);
		
	if($cant_notas!=0){
	
	$total=($cant_notas * 100)/$fila_m['cantidad'];

    echo round($total,1);
	}
?>
</td>
<? } ?>
</tr>
<? } ?>

</tr>
</table>
<br><br><br>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
<table width="75%" border="0" align="center">
  <tr>
    <td>&nbsp;<hr></td>
  </tr>
</table>
<br>
<div style="margin-left:65%" class="subitem"><?=$fecha;?></div>
</form>
	<?
	    echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	?>
   
</body>
</html>
<? pg_close($conn);?>