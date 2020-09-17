<?php
require_once('../../../../../util/header.inc');
require_once('../../../../clases/class_Membrete.php');
require_once('../../../../clases/class_Reporte.php');
include('../../../../clases/class_MotorBusqueda.php');
//print_r($_GET);





	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $cmb_ano;
	$docente		= 5; //Codigo Docente
	$frmModo		= $_FRMMODO;
	$reporte		= $c_reporte;
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	$curso=1;
	
	

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
  

 $sql_nro_ano="select an.nro_ano from ano_escolar an where an.id_ano=".$ano;
			$result_a =pg_Exec($conn,$sql_nro_ano);
			$fila_nro_ano = pg_fetch_array($result_a,$sql_nro_ano);
			 $nro_ano=$fila_nro_ano['nro_ano'];
	
			
				
				
				
		function getMonthDays($Month, $Year)
{
   //Si la extensión que mencioné está instalada, usamos esa.
   if( is_callable("cal_days_in_month"))
   {
      return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
   }
   else
   {
      //Lo hacemos a mi manera.
      return date("d",mktime(0,0,0,$Month+1,0,$Year));
   }
}
//Obtenemos la cantidad de días que tiene septiembre del 2008
//echo "<br>"."Dias-->".
$nomero_dias = getMonthDays($cmb_meses, $nro_ano);
			
	function nombremes($mes){
		
setlocale(LC_TIME, 'spanish');
$nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000));
return $nombre;
} 		 
			 
	$nombre_mes=nombremes($cmb_meses);
//echo "nombre_mes-->".$nombre_mes; //devuelve "agosto"		





	$ob_motor = new MotorBusqueda();
	$ob_motor->institucion = $institucion;
	$result_emp = $ob_motor->ListaEmpleadoNOCARGO($conn);
			   
			 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 
<!-- INICIO CUERPO DE LA PAGINA -->

<form name="form" method="post" action="print_promedios_insuficientes_curso.php" target="_blank">
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
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
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
		   echo "<img src='../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."../menu/imag/logo.gif' >";
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
  <table width="650" align="center">
	<tr><td class="tableindex" align="center"><div align="center">
<u>RESULTADOS DEL MES <?=$nombre_mes.' '.$nro_ano?></u> </div>
</td></tr>
</table>
<br><br><br>
<table  align="center" border="1" width="95%" style="border-collapse:collapse">
<tr class="textonegrita">
<td >Nombre</td>
<?php

for($x=1;$x<=$nomero_dias;$x++){
	?>
    <td width="%" align="center" style="text-align:center;font-size:10px; width:25px"><?=$x?></td>
    <?
//echo $cantDias.='<input type="text" size="2" value="'.$x.'">';	
}
?>
 <td width="%" align="center" style=" width:25px; text-align:center">T&deg;<br>
Total</td>
</tr>


<?
	for($e=0;$e<pg_num_rows($result_emp);$e++){
		$suma_min=0;
		$fila_emp = @pg_fetch_array($result_emp,$e);
		$ob_reporte->rut_emp = $fila_emp["rut_emp"];
		$ob_reporte->ano = $cmb_ano;
		?>
        <tr class="textosimple">
		<td ><?=ucwords(strtolower($fila_emp["ape_pat"]." ".$fila_emp["nombre_emp"]))?></td>
       <?php for($x=1;$x<=$nomero_dias;$x++){
		   $dia = ($x<10)?"0".$x:$x;
		   $mes = ($cmb_meses<10)?"0".$cmb_meses:$cmb_meses;
		   $ff = $nro_ano."-".$mes."-".$dia;
		   $ob_reporte->fecha = $ff;
		    ?>
        <td align="center" style="text-align:center;font-size:10px">
        <?php $rs_atr = $ob_reporte->minAtrasoEmp($conn);
		if(pg_numrows($rs_atr)>0){
		$atr = pg_result($rs_atr,3);
		$suma_min = $suma_min+$atr;
		?>
        <?php echo convertirMH($atr); ?>
        
        <?php }else{echo "&nbsp;";}?>
        </td>
        <?php }?>
        <td  style=" width:25px; text-align:center"><?php echo ($suma_min>0)?convertirMH($suma_min):""; ?></td>
        <?
		}
?>
 
</tr>
</table>




<br>

 <?php  
		 $ruta_timbre =5;
		 $ruta_firma =3;
		 $concur=0;
		 include("../firmas/firmas.php");?>
 <table width="75%" border="0" align="center">
   <tr>
    <td>&nbsp;</td>
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