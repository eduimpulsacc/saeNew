<?php 
	require('../../../../util/header.inc');
	include('../../../clases/class_Reporte.php');
	include('../../../clases/class_Membrete.php');
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;

	
	if (trim($_url)=="") $_url=0;
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Lista_Curso_$Fecha.xls"); 
	}	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=latin9">
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
function exportar(){
			//form.target="_blank";
			window.location='printListaCurso_C.php?cmb_curso=<?=$curso?>&c_reporte=<?=$reporte?>';
			//document.form.submit(true);
		return false;
}
function cerrar(){ 
window.close() 
} 
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
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
 
</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->

<?
if ($curso != 0){
   ?>
<?php //echo tope("../../../../../util/");?>
<div id="capa0">
	<table width="550" align="center">
	  <tr>
	  	<td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
		<td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR"></td>
	    <td align="right"><input name="button32" type="button" class="botonXX" onClick="javascript:exportar();"  value="EXPORTAR"></td>
	
	  </tr>
	</table>
</div>
	<center>
  
<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br>";
	   
  }	?>
  
  
  
  
  
  
  <table width="550" border="0" cellspacing="1" cellpadding="3">
    <tr height=15> 
      <td colspan=5> <table border=0 cellspacing=1 cellpadding=1>
          <tr> 
            <td align=left class="item"> <strong> INSTITUCION 
              </strong> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
              </font> </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong> 
              <?php  
			  		$ob_membrete->institucion = $institucion;                                   
					$ob_membrete->institucion($conn);
					echo $ob_membrete->ins_pal;
			  ?>
              </strong> </font> </td>
          </tr>
          <tr> 
            <td align=left class="item">  <strong>AÑO ESCOLAR</strong>  </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> </font> </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong> 
              <?php
					$ob_membrete->ano = $ano;
					$ob_membrete ->AnoEscolar($conn);
					echo $ob_membrete->nro_ano;
				?>
              </strong> </font> </td>
          </tr>
          <tr> 
            <td align=left class="item">  <strong>CURSO</strong>              </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
              </font> </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong> 
              <?php 
			  		$ob_membrete->curso =$curso;
					$ob_membrete ->curso($conn);
									
					/*if (($ob_membrete->cod_decreto==771982) or ($ob_membrete->cod_decreto==461987) or ($ob_membrete->cod_decreto==121987) or ($ob_membrete->cod_decreto==1521989) or ($ob_membrete->cod_decreto==1000) or ($ob_membrete->cod_decreto==1000)){
						/*$ob_membrete->grado =$ob_membrete->grado_curso;
						$ob_membrete->decreto =$ob_membrete->cod_decreto;
						$ob_membrete->CambiaDatoCurso($conn);*/
						//echo $Curso_pal = CursoPalabra($curso, 1, $conn);
						//echo $ob_membrete->sigla." - ".$ob_membrete->letra_curso." ".$ob_membrete->nombre_tipo;
						
				//	}else{
											echo $Curso_pal = CursoPalabra($curso, 1, $conn);
						//echo $ob_membrete->grado_curso." - ".$ob_membrete->letra_curso." ".$ob_membrete->ensenanza;
					//}
			 ?>
              </strong> </font> </td>
          </tr>
		  
		  <tr> 
            <td align=left class="item"><strong>  PROFESOR JEFE              </strong></td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> : 
              </font> </td>
            <td class="subitem"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">  
              <?
				$ob_reporte->curso = $curso;
			  	$ob_reporte->ProfeJefe($conn);
				echo $ob_reporte->tildeM($ob_reporte->profe_jefe);
				?>
               </font> </td>
          </tr>
        </table></td>
    </tr>
	<tr><td></td></tr>
    <tr> 
      <td colspan=5 align=right> 
     </td>
    </tr>
	<TR></TR>
	<br>
	<tr height="20"> 
      <td align="middle" colspan="5" class="tableindex"><div align="center">LISTADO DEL CURSO</div></td>
    </tr>
	<tr><td><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
	
    <tr> 
    <? if ($_INSTIT==770){ ?><td width="50" align="center" bgcolor="#999999" class="item">Rut</td><? } ?>
     <? if ($_INSTIT!=770){ ?> <td width="30" align="center" bgcolor="#999999" class="item">N&ordm;</td><? } ?>
      <td width="270" align="center" bgcolor="#999999" class="item">NOMBRE</td>
    </tr>
    <?php
		$ob_reporte->ano = $ano;
		$ob_reporte->curso = $curso;
		echo $ob_reporte->retirado = $ck_retirado;
		$ob_reporte->orden=$ck_opcion;
		$result=$ob_reporte->FichaAlumnoTodos($conn);
		
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);
			$ob_reporte ->CambiaDato($fila);
			$nombre_alu=ucwords(strtolower($ob_reporte->ape_nombre_alu));
			?>
      <? if ($_INSTIT==770){ ?><td align="left" class="subitem" >&nbsp;&nbsp;<?=$ob_reporte->alumno?></td>	
      <? } ?>
    <? if ($_INSTIT!=770){ ?>  <td align="left" class="subitem" >&nbsp;&nbsp;<? echo $i+1; ?> </td>
    <? } ?>
      <td align="left" class="subitem" ><strong>&nbsp;&nbsp;
            <?=$ob_reporte->tilde($nombre_alu);?>
      </strong> </td>
    </tr>
    <?php
					}
				}
			?>
	
	</table></td></tr>
    
	<tr> 
      <td colspan="5"> <hr width="100%" color="#003b85"> </td>
    </tr>
  </table>  
</center>
<!-- FIN CUERPO DE LA PAGINA -->

</body>
</html>
<? pg_close($conn);?>