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
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

if($_PERFIL==0){
	
	//print_r($_POST);
	}
	//setlocale("LC_ALL","es_ES");
	
	if($tipo_ensenanza==310){
			$tipos_curso="4&ordm; Medios";
			}else{
				
			$tipos_curso="Ense&ntilde;anza Basica ";	
			}
			
			
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$tipo_ensenanza	=$tipo_ensenanza;
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
	
	
	if ($tipo_ensenanza!=NULL or $tipo_ensenanza != 0){
		//////////////////// consulta para traer todos los alumnos de cuarto medio con su promedio  /////////////////
		$ob_reporte ->ano =$ano;
		$ob_reporte ->ensenanza =$tipo_ensenanza;
		if($tipo_ensenanza!=310){
			$ob_reporte ->grado = "";
			}else{
		$ob_reporte ->grado = 4;
			}
		$res_1 = $ob_reporte ->MejoresPromedios($conn);
		$num_1 = pg_numrows($res_1);
		
		$total = $num_1;
		$num_1 = ($num_1*5/100);
		$num_1 = substr($num_1,0,3);
		
		for ($i=0; $i < $num_1; $i++){
		    $fil_1 = pg_fetch_array($res_1,$i);
			/*echo "<pre>";
			print_r($fil_1);
			echo "</pre>";*/
			
		$promedio      = $fil_1['promedio'];
		
		}
		
		
		
		///
		//echo"--->".$_POST['promedio'];
		$ob_reporte ->ano =$ano;
		$ob_reporte ->ensenanza =$tipo_ensenanza;
		if($tipo_ensenanza==310){
		$ob_reporte ->grado=4;
		}else{
		$ob_reporte ->grado="";
			}
		$ob_reporte ->promedio = $promedio;
		$nro_ano = $ob_reporte ->AnoEscolar($conn);
		if($_POST['promedio']==0){
		$res_2 = $ob_reporte ->MejoresPromediosAlumnos($conn);
		}else{
		$res_2 = $ob_reporte ->MejoresPromediosAlumnosParciales($conn);	
		}
		$num_2 = @pg_numrows($res_2);		
	}
if(!$cb_ok=="Buscar"){

	$Fecha=date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Mejores_Promedios$Fecha.xls"); 
	
}	
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
			function enviapag2(form){
		   			form.target="_blank";
					form.action='printInformeMejoresPromedios_C.php?tipo_ensenanza=<?=$tipo_ensenanza?>';
					form.submit(true);
			}
/*			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformeRendimientoCriticoFinal.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}	*/		
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
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<form method="post" name="form" action="printInformeMejoresPromedios_C.php">
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<div id="capa0">
		<TABLE width="100%"><TR><TD><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></TD><TD  align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </TD>
		  <? if($_PERFIL == 0){?>
		    <TD  align="right"><input name="exp" type="button" class="botonXX" onClick="enviapag2(this.form);"  value="EXPORTAR"></TD>
			<? }?>
		</TR></TABLE>
        </div>
        
        
        
        <table width="680"  align="center" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td>
				
					<!-- aqui va la insignia -->
					
					<table width="125" border="0" cellpadding="0" cellspacing="0">
					<tr valign="top" >
					  <td width="125" align="center"> 	  
						<?
						if($institucion!=""){
						   echo "<img src='".$d."../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}?>		  </td>
					</tr>
				  </table>
					
					<!-- fin de la insignia -->					</td>
					
				  </tr><br/><br/><br/>
			
    </table>
	
	  </td>
      </tr>
      <tr>
      <td>
      <br/><br/><br/>
	  <table width="681" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="681" align="center" class="tableindex"><div align="center"><strong>5%</strong> MEJORES PROMEDIOS DE <?=$tipos_curso?>  </div></td>
      </tr>
      
      </table>
      <table width="100%" border="1" cellspacing="3" cellpadding="0" style="border-collapse:collapse">
        <tr align="center">
          <td width="5%" class="item"><b>Nro</b></td>
		  <td width="10%" class="item"><b>Rut</b></td>
          <td width="38%" class="item"><b>Alumno</b></td>
          <td width="10%" class="item"><b>Curso</b></td>
          <td width="27%" class="item"><div align="center"><b>Promedio <br> Final </b></div></td>
          <td width="10%" class="item"><b>Comuna</b></td>
        </tr>
		<?
		for ($i=0; $i < $num_2; $i++){
		    $fil_2 = pg_fetch_array($res_2,$i);
			$rut_alumno    = $fil_2['rut_alumno'];
			$nombre_alu    = $fil_2['nombre_alu'];
			$promedio      = $fil_2['prom'];
			$ape_pat       = $fil_2['ape_pat'];
			$ape_mat       = $fil_2['ape_mat'];
			$letra_curso   = $fil_2['letra_curso'];
			$grado_curso   = $fil_2['grado_curso'];
			$comuna        = $fil_2['nom_com'];
			$id_curso		=$fil_2['id_curso'];
			
			$promedio_p=substr($promedio,0,4)
			
			?>
			 <tr align="center">
			  <td align="center" class="subitem"><?=$i + 1 ?></td>
			  <td class="subitem">&nbsp;<?=$rut_alumno ?></td>
			  <td class="subitem">&nbsp;<?=$ob_reporte->tilde(ucwords(strtolower($nombre_alu)));?> <?=$ob_reporte->tilde(ucwords(strtolower($ape_pat))); ?> <?=$ob_reporte->tilde(ucwords(strtolower($ape_mat)));?></td>
			  <td class="subitem">&nbsp;<?=$grado_curso ?> <?=$letra_curso ?></td>
			  <td class="subitem">&nbsp;<?=$promedio_p?></td>
			  <td class="subitem">&nbsp;<?=$comuna ?></td>
			</tr>
			<?
		}
		
        ?>
      </table>
      <br>
      <table width="100%" border="1" cellspacing="0" cellpadding="5">
        <tr>
          <td width="30%" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px">Total alumnos <?=$tipos_curso?> </td>
          <td width="70%" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px"><b><?=$total ?></b></td>
        </tr>
        <tr>
          <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px"> 5% mejores promedios </td>
          <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px"><b><?=$num_1 ?> (a seleccionar dentro de este informe)</b></td>
        </tr>
        <tr>
          <td colspan="2" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px">
		      El 5% mejores promedios de <?=$tipos_curso?>, corresponde a: <?=$num_1 ?> dentro de este informe,
			  para evitar discriminaciones el sistema muestra  todos los alumnos, que posean
			  el mejor promedio más bajo.    
		  
		  </td>
          </tr>
      </table>
      <br>
	 
	  </td>
      </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 $concur=0;
		 include("firmas/firmas.php");?>
 </center>
</form>                                
</body>
</html>
<? pg_close($conn);
unset($cb_ok);?>