<?
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
//setlocale("LC_ALL","es_ES");

	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$fin_ano		=$check_ano;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
    if (($curso != 0) or ($curso != NULL)){	
	    $query_curso="select * from curso where id_curso='$curso'";
	    $row_curso=pg_fetch_array(pg_exec($conn,$query_curso));
	}
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	

if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Informe_alumnos_sexo_$fecha_actual.xls"); 	 
}	 

		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}


function exportar(){
			var ensenanza_exp = document.form.ensenanza_c.value;
			window.location='printInformeAlumnosSexo_C.php?tipo_ensenanza='+ensenanza_exp+'&xls=1';
			return false;
		  }


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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">


<form name="form" method="post" action="printInformeAlumnosSexo_C.php" target="_blank">

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr align="right">
        <td>
		<div id="capa0">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
		  <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
		<input name="ensenanza_c" type="hidden" value="<?=$tipo_ensenanza?>">
										<? }?>
        </div>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">
	<?
		
	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
	  		</td>
		 </tr>
     </table>
	</td>
  </tr>
  <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>
<?
// busco el nombre de tipo de ensenanza
$ob_reporte ->cod_tipo = $tipo_ensenanza;
$ob_reporte ->TipoEnsenanza($conn);
/// fin nombre del tipo de ensenanza
?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<td class="tableindex"><div align="center">CANTIDAD DE ALUMNOS POR TIPO DE ENSE&Ntilde;ANZA</div></td>
	</tr>
	<tr>
		<td height="25"><div align="center" class="item"><strong>Tipo de enseñanza:
            <?=$ob_reporte->nombre;?> 
            </strong></div></td>
	</tr>
</table>
<br>
<br>	
<table width="80%" border="1" align="center" cellpadding="3" cellspacing="0">
   <?
   //Aqui tomo todos los cursos dependiendo el tipo de eneseñanza
   $ob_reporte ->ano = $ano;
   $ob_reporte ->tipo_ensenanza = $tipo_ensenanza;
   $resultado_query_cue = $ob_reporte ->CursoEnsenanza($conn);
   $total_cursos = @pg_numrows($resultado_query_cue);
  
   
   for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
       $fila     = @pg_fetch_array($resultado_query_cue,$i);
	   $id_curso = $fila['id_curso'];
	   // debo tomar todos los alumnos de este curso
	   $ob_reporte ->sexo = 1;
	   $ob_reporte ->curso =$id_curso;
	   $ob_reporte ->institucion = $institucion;
	   $result_mujer = $ob_reporte ->AlumnoCurso($conn);
	   $total_mujer = @pg_numrows($result_mujer);
	   
	   if ($total_mujer > 0){
	       $alumnos_sexo_1 = $alumnos_sexo_1 + $total_mujer;
	   }
	   $ob_reporte ->sexo = 2;
	   $ob_reporte ->curso =$id_curso;
	   $ob_reporte ->institucion = $institucion;
	   $ob_reporte ->ano = $ano;
	   $result_hombre = $ob_reporte ->AlumnoCurso($conn);
	   $total_hombre = @pg_numrows($result_hombre);
	   	   
	   if ($total_hombre > 0){
	      $alumnos_sexo_2 = $alumnos_sexo_2 + $total_hombre;
       }
   }   
   ?>
    <tr>
       <td width="40%" class="subitem" ><b>Alumnos sexo Femenino</b> </td>
	   <td width="20%" class="subitem" ><div align="center"><b>
	     <?=$alumnos_sexo_1 ?>
	     </b></div></td>
       <td width="20%" ><div align="center"><img src="images/mujer.jpg" width="33" height="37"></div></td>
    </tr>  
    <tr>
       <td class="subitem"><b>Alumnos sexo Masculino</b> </td>
       <td class="subitem"><div align="center"><b>
         <?=$alumnos_sexo_2 ?>
       </b></div></td>	
       <td><div align="center"><img src="images/hombre.jpg" width="33" height="37"></div></td>	 
    </tr>	
</table>

<br>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
<table width="650" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
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