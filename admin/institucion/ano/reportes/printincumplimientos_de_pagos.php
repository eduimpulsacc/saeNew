<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

</script>

<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	if($retirado!=""){
		$retirado = $retirado;
	}else{
		$retirado = 0;
	}
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno 		=$c_alumno;
	$reporte		=$c_reporte;	
	$_POSP = 4;
	$_bot = 8;

	
	$ob_reporte = new Reporte();
	
	$ob_membrete = new Membrete();
	$ob_membrete->institucion=$institucion;
	$ob_membrete->institucion($conn);
	
	
	
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);


if($cb_ok!="Buscar"){
	$xls=1;
}
/*<!--	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Ficha_personal_alumno_$fecha_actual.xls"); 	 
}-->*/	 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
function cerrar(){ 
window.close() 
} 
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
 
.C {
	text-align: center;
}
</style>
</head>

<body>
<!-- FIN DE COPIA DE BOTONES -->
<script language="javascript" type="text/javascript">

function exportar(){
			window.location='printFichaAlumno_C.php?c_curso=<?=$curso?>&c_alumno=<?=$alumno?>&xls=1';
			return false;
		  }
</script>

<!-- AQUÍ EL CONTENIDO CENTRAL DE LA PÁGINA -->

<form name="form" method="post" action="printFichaAlumno_C.php" target="_blank">
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td>
	
	<div id="capa0">
	<table width="100%">
	  <tr>
	  	<td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
		<td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
		  <input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
		</td>
	  </tr></table>
      </div></td>
  </tr>
</table>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th width="156" align="left">&nbsp;</th>
    <th width="349" align="left">&nbsp;</th>
    <th width="72" align="left">&nbsp;</th>
    <th width="73" align="left">&nbsp;</th>
  </tr>
  <tr>
    <td align="left"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>
      <?=$ob_membrete->ins_pal;?>
    </strong></font></td>
    <td align="left">&nbsp;</td>
    <td colspan="2" rowspan="7" align="left" valign="top"><? echo "<img src='".$d."tmp/".$institucion."insignia". "' >"; ?></td>
    </tr>
  <tr>
    <td align="left"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>
      <?=$ob_membrete->direccion;?>
    </strong></font></td>
    <td align="left">&nbsp;</td>
    </tr>
  <tr>
    <td align="left"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><? echo $ob_membrete->comuna?></strong></font></td>
    <td align="left">&nbsp;</td>
    </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    </tr>
</table>
 
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">INCUMPLIMIENTO DE PAGOS POR ALUMNO</div></td>
  </tr>
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th>R.U.T</th>
    <th>Nombre </th>
    <th>Curso</th>
    <th>Tipo</th>
    <th>Cuota</th>
    <th>Vencimiento</th>
    <th>Pactado</th>
    <th>Pagado</th>
    <th>Saldo</th>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>

   </tr>
 </table>
 
</form>

</center>

  <!-- FIN DEL CONTENIDO CENTRAL DE LA PÁGINA -->
  
  
  
       <!-- INSERTO EL CONTENIDO DEL MOTOR DE BUSQUEDA -->
	  
	   
	   <!-- FIN DEL CONTENIDO DEL MOTOR DE BUSQUEDA -->								  
								  
								 
</body>
</html>
<? pg_close($conn);
pg_close($connection);?>