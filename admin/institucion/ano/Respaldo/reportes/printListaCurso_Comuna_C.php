<?php 

	require('../../../../util/header.inc');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$reporte		=$c_reporte;
    $_POSP = 4;
	$_bot = 8;
	
	if (trim($_url)=="") $_url=0;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
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
		header("Content-Disposition:inline; filename=Lista_Curso_Nac_$Fecha.xls"); 
	}	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
//-->
</script>
<script> 
function exportar(){
			//form.target="_blank";
			window.location='printListaCurso_Comuna_C.php?cmb_curso=<?=$curso?>&c_reporte=<?=$reporte?>&cmb_comuna=<?=$cmb_comuna?>';
			//document.form.submit(true);
		return false;
}
function cerrar(){ 
window.close() 
} 
</script>
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->
<?
if ($cmb_curso!=0){
   ?>

	<?php //echo tope("../../../../../util/");?>
	<center>
	
<table width="640" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        <?php if(($_PERFIL!=15)and($_PERFIL!=16)and($_PERFIL!=17)) { ?>

	  <div id="capa0">
	  <table width="100%">
	    <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
	    <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
		</td>
		<? if($_PERIFL == 0){?>
	      <td align="right"><input name="button32" TYPE="button" class="botonXX" onClick="javascript:exportar();" value="EXPORTAR"></td>
	   <? }?>
	    </tr></table>
	  </div>

<?	}	?>	
	</td>
  </tr>
  <TR><TD>&nbsp;</TD></TR>
</table>
	
  <table width="640" border="0" cellspacing="1" cellpadding="3">
    <tr height=15> 
      <td colspan=5> 
	  
	  
  <? if ($institucion=="770"){ 
		   // no muestro los datos de la institucion
		   // por que ellos tienen hojas pre-impresas
		   echo "<br><br><br><br><br><br><br><br><br><br>";
		   
	  }else{
	
		?>
	  <table  width="640" border=0 cellspacing=1 cellpadding=1>
          <tr> 
            <td align=left class="item"><strong>  INSTITUCION              </strong></td>
            <td>  <strong>:</strong>              </td>
            <td class="subitem">              <?php  
                    $ob_membrete->institucion = $institucion;                                   
					$ob_membrete->institucion($conn);
					echo $ob_membrete->ins_pal;
			  ?>              </td>
                <td width="161" rowspan="5" align="center" valign="top" >
			  <?	
				if($institucion!=""){
					echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
				}else{
					echo "<img src='".$d."menu/imag/logo.gif' >";
				}
			  ?>				</td>
          </tr>
          <tr> 
            <td align=left class="item"><strong> AÑO ESCOLAR  </strong></td>
            <td>  <strong>:</strong>  </td>
            <td class="subitem">              <?php
			  		$ob_membrete->ano = $ano;
					$ob_membrete ->AnoEscolar($conn);
					echo $ob_membrete->nro_ano;
			  
				?>              </td>
          </tr>
          <tr> 
            <td align=left class="item"><strong>  CURSO              </strong></td>
            <td>  <strong>:</strong>              </td>
            <td class="subitem">              <?php
							$ob_membrete->curso =$curso;
							$ob_membrete ->curso($conn);
											
							if (($ob_membrete->cod_decreto==771982) or ($ob_membrete->cod_decreto==461987) or ($ob_membrete->cod_decreto==121987) or ($ob_membrete->cod_decreto==1521989) or ($ob_membrete->cod_decreto==1000) or ($ob_membrete->cod_decreto==1000)){
								$ob_membrete->grado =$ob_membrete->grado_curso;
								$ob_membrete->decreto =$ob_membrete->cod_decreto;
								$ob_membrete->CambiaDatoCurso($conn);
								echo $ob_membrete->sigla." - ".$ob_membrete->letra_curso." ".$ob_membrete->nombre_tipo;
								
							}else{
								echo $ob_membrete->grado_curso." - ".$ob_membrete->letra_curso." ".$ob_membrete->ensenanza;
							}
				?>               </td>
          </tr>
		  <tr> 
            <td align=left class="item"><strong>  PROFESOR JEFE              </strong></td>
            <td>  <strong>:</strong>              </td>
            <td class="subitem">              <? 
			  	$ob_reporte->curso = $curso;
			  	$ob_reporte->ProfeJefe($conn);
				echo $ob_reporte->tildeM($ob_reporte->profe_jefe);
				?>               </td>
          </tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td></tr>
        </table>
 <? } ?>	
	</td>
    </tr>
      <tr>
        <td height="20" class="tableindex"><div align="center">LISTADO DEL CURSO </div></td>
      </tr>
	
	<tr><td>&nbsp;</td></tr>
	<br>
	<tr><td><table width="640" border="1" align="center" cellpadding="0" cellspacing="0">
	
    <tr> 
      <td width="29" align="center" class="item">N&ordm;</td>
      <td width="89" align="center" class="item">RUT</td>
      <td width="133" align="center" class="item">APELLIDOS</td>
      <td width="135" align="center" class="item">NOMBRES</td>
      <td width="69" align="center" class="item">FECHA NAC.</td>
      <td width="98" align="center" class="item">COMUNA</td>
      <td width="71" align="center" class="item">ISAPRE</td>
    </tr>
    <?php
				$ob_reporte->ano = $ano;
				$ob_reporte->curso = $curso;
				$ob_reporte->comuna =$cmb_comuna;
				$ob_reporte->retirado=0;
				$ob_reporte->orden=$ck_orden;
				$result=$ob_reporte->FichaAlumnoTodos($conn);
	
				for($i=0 ; $i < @pg_numrows($result) ; $i++){
					$fila = @pg_fetch_array($result,$i);
					$ob_reporte ->CambiaDato($fila);
		?>
			  <td align="left" class="subitem" > <font color="#000000">&nbsp;&nbsp;<? echo $i+1; ?></font> </td>
			  <td align="left" class="subitem" ><font color="#000000">&nbsp;
              <?=$ob_reporte->rut_alumno; ?>
	          </font></td>
			  <td align="left" class="subitem" ><font color="#000000">&nbsp;&nbsp;<? echo $ob_reporte->tilde($ob_reporte->ape_pat." ".$ob_reporte->ape_mat);?> </font></td>
			  <td align="left" class="subitem" > <font color="#000000">&nbsp;&nbsp;
              <?=$ob_reporte->tilde($ob_reporte->nombre); ?>
			  </font> </td>
			  <td align="left" class="subitem" > <font color="#000000">&nbsp;&nbsp;
              <? impF($ob_reporte->fecha_nacimiento); ?>
			  </font> </td>
			  <td align="left" class="subitem" ><font color="#000000">&nbsp;&nbsp;
              <?=$ob_reporte->tilde($ob_reporte->comuna);?>
	          </font></td>
			  <td align="left" class="subitem" > <font color="#000000">&nbsp;&nbsp;<? echo strtoupper($ob_reporte->salud); ?></font> </td>
    </tr>
	    <?php }	?>
	</table></td></tr>
    
	<tr> 
      <td colspan="5"> <hr width="100%" color="#003b85"> </td>
    </tr>
  </table>
</center>
   <?
}

?>   
<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>