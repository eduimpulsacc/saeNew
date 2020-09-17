<? 
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

$curso 	=$_GET['curso'];	
$institucion	=$_INSTIT;
$ano			=$_ANO;
$id_periodo		=$cmb_periodos;
$reporte		=$c_reporte;
$_POSP = 4;
$_bot = 8;

$ob_reporte = new Reporte();
$ob_membrete = new Membrete();
//------------------------
// Año Escolar
//------------------------
$ob_membrete ->ano=$ano;
$ob_membrete ->AnoEscolar($conn);
$ano_escolar = $ob_membrete->nro_ano;

//-------------- INSTITUCION -------------------------------------------------------------
$ob_membrete ->institucion = $institucion;
$ob_membrete ->institucion($conn);

 //-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	
	
	function to_roman($num) {
if ($num <0 || $num >9999) {return -1;}
$r_ones = array(1=>"I", 2=>"II", 3=>"III", 4=>"IV", 5=>"V", 6=>"VI", 7=>"VII", 8=>"VIII",
9=>"IX");
$r_tens = array(1=>"X", 2=>"XX", 3=>"XXX", 4=>"XL", 5=>"L", 6=>"LX", 7=>"LXX",
8=>"LXXX", 9=>"XC");
$r_hund = array(1=>"C", 2=>"CC", 3=>"CCC", 4=>"CD", 5=>"D", 6=>"DC", 7=>"DCC",
8=>"DCCC", 9=>"CM");
$r_thou = array(1=>"M", 2=>"MM", 3=>"MMM", 4=>"MMMM", 5=>"MMMMM", 6=>"MMMMMM",
7=>"MMMMMMM", 8=>"MMMMMMMM", 9=>"MMMMMMMMM");
$ones = $num % 10;
$tens = ($num - $ones) % 100;
$hundreds = ($num - $tens - $ones) % 1000;
$thou = ($num - $hundreds - $tens - $ones) % 10000;
$tens = $tens / 10;
$hundreds = $hundreds / 100;
$thou = $thou / 1000;
if ($thou) {$rnum .= $r_thou[$thou];}
if ($hundreds) {$rnum .= $r_hund[$hundreds];}
if ($tens) {$rnum .= $r_tens[$tens];}
if ($ones) {$rnum .= $r_ones[$ones];}
return $rnum;
}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
/*function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<script> 
function cerrar(){ 
window.close() 
} 

/*
		function exportar(){
			window.location='printNotassubsectorcursos_C.php?cmb_periodos=<?=$id_periodo?>&xls=1';
			return false;
		  }		 

*/*/
</script>



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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
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
.t {
	font-size: 10px;
}
.t {
	font-size: 12px;
}
.t {
	font-size: 9px;
}
.c {
	text-align: center;
}
.t {
	font-size: 9px;
	font-weight: bold;
}
.TX {
	font-size: 9px;
}
.TX {
	font-size: 10px;
}
body p {
	font-size: 14px;
}
body p {
	font-size: 12px;
}
.TX {
	font-size: 12px;
}
body pt {
	font-size: 9px;
}
table {
	font-size: 9px;
}
table {
	font-size: 12px;
}
table {
	font-size: 10px;
}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->

<form name="form" method="post" action="printNotassubsectorcursos_C.php" target="_blank">

<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">
		<?
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			## código para tomar la insignia
	
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }
		?>	  		</td>
		 </tr>
     </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="487" class="item"><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></td>
          <td width="11">&nbsp;</td>
          
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
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <th align="left">curso:</th>
          <th align="left">&nbsp;</th>
          <th align="left">&nbsp;</th>
          <th align="left">Alumno:</th>
          <th align="left">&nbsp;</th>
          <th align="left">&nbsp;</th>
          <th align="left">&nbsp;</th>
        </tr>
        <tr>
          <td align="left">Profesor(a)jefe:</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">Fecha:</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
    </table>
      <table width="900" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="tableindex"><div align="center">INFORME DE NOTAS </div></td>
      </tr>
    <tr>
      <td ></td>
      </tr>
</table>
      
  <br>
  <table width="100%" border="1" cellpadding="0" cellspacing="0">
    <tr class="t">
      <th width="7%">Asignatura</th>
      <th width="7%">Pruebas Unidad</th>
      <th colspan="3">Notas Parciales</th>
      <th width="3%">P.U 40%</th>
      <th width="3%">N.P 60%</th>
      <th width="3%">p 100%</th>
      <th width="2%">N. P.S</th>
      <th width="3%">P. 100%</th>
      <th width="3%">P.S 30%</th>
      <th width="2%">P.1</th>
      <th colspan="4">Pruebas Unidad</th>
      <th colspan="3">Notas Parciales</th>
      <th width="3%">P.U 40%</th>
      <th width="3%">N.P 60%</th>
      <th width="2%">P 100</th>
      <th width="2%">N. P.S</th>
      <th width="3%">P. 70%</th>
      <th width="3%">P.S 30%</th>
      <th width="2%">P.2</th>
      <th width="4%">P.F</th>
      
    </tr>
    <tr>
      <td>xxxx</td>
      <td>ccxcxzc</td>
      <td width="5%">&nbsp;</td>
      <td width="4%">&nbsp;</td>
      <td width="5%">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="3%">&nbsp;</td>
      <td width="5%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
      <td width="5%">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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
  </table></td>
  </tr>
</table>
<table width="800" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th width="353" align="left"><table width="330" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <th colspan="4" scope="col"><span class="t">CUADRO ASISTENCIA</span></th>
    </tr>
  <tr class="c">
    <td width="86"><span class="t">DIAS</span></td>
    <td width="62"><span class="t">SEMESTRE I</span></td>
    <td width="83"><span class="t">SEMESTRE II</span></td>
    <td width="89"><span class="t">TOTAL ANUAL</span></td>
  </tr>
  <tr>
    <td><span class="t">TRABAJADOS</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="t">ASISTIDOS</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="t">INASISTIDOS</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="t">ATRASOS</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><span class="t">CUADRO ANOTACIONES</span></td>
    </tr>
  <tr>
    <td><span class="t">POSITIVAS</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="t">NEGATIVAS</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table></th>
    <th width="418" align="left" valign="top" scope="col"></th>
    <th width="7" align="right"><table width="250" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <th colspan="3" style="font-size: 10px" scope="col"><span class="TX">PRIMER SEMESTRE</span></th>
        </tr>
      <tr>
        <th colspan="3" align="left" style="font-size: 10px" scope="col"><p class="TX">Observaciones:_________________________________</p>
          <p class="TX"> ______________________________________________</p>
          <p class="TX"> ______________________________________________</p></th>
        </tr>
      <tr>
        <th>_________________ <br>
          Firma profesor jefe</th>
        <th>&nbsp;</th>
        <th>___________________<br>
          Firma Apoderado</th>
      </tr>
      <tr>
        <th height="31">&nbsp;</th>
        <th>_______________<br>
          Firma Director</th>
        <th>&nbsp;</th>
      </tr>
    </table></th>
  </tr>
</table>
<br>
<br>
<table width="770" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>

</form>



<!-- FIN CUERPO DE LA PAGINA -->

 
 	<? pg_close($conn);?>							 
</body>
</html>
