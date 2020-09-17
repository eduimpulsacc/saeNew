<?php
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');

	
	$_POSP = 6;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $cmb_curso;
	$docente		= 5; //Codigo Docente
	$frmModo		= $_FRMMODO;
	$alumno			= $cmb_alumno;	
	$reporte		= $c_reporte;


if ($cmb_curso>0){
	$Curso_pal = CursoPalabra($curso, 1, $conn);
	$fecha = $txtFECHA;//date("d m Y");
}

	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();

	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);

	$qry_url = "select * from salida where rdb = '$institucion'";
    $result_2 =pg_Exec($conn,$qry_url);
    $fila_1 = @pg_fetch_array($result_2,0);	
	$web = $fila_1['direccion'];
	
	
	
	/************** FIRMA ***********************/
		$ob_reporte->rdb=$institucion;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		$ob_reporte->item=$reporte;
		
	
		
		if($_PERFIL!=0 && $_PERFIL!=14){
			//veo si tiene autorizacion permanente
			$autp=$ob_reporte->checAutReporteTrabaja($conn);
			$aut = pg_result($autp,0);
			//echo "aut->".$aut;
			
		
			if($aut==0){
				//veo si el usuario tiene el reporte
				$ob_reporte->rdb=$institucion;
				$ob_reporte->usuario= $_NOMBREUSUARIO;
				$ob_reporte->item=$reporte;
				$rp = $ob_reporte->checAutReporte($conn);
				$crp= pg_numrows($rp);
				//echo "aut2->".$crp;
			
				}
				else{
				$crp = $aut;
				}
				
				$rs_quita = $ob_reporte->quitaAutReporte($conn);
		}
		else{
		$crp=1;
		}


if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Carta_apoderados_$fecha_actual.xls"); 	 
}	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
			window.location='printCartaApoderado_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
 

<!-- INICIO CUERPO DE LA PAGINA -->

<form name="form" method="post" action="../../printCartaApoderado_C.php" target="_blank">
<div id="capa0">
  <table width="650">
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
      </td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	  <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
										<? }?>
	  
      </td>
    </tr>
  </table>
</div>
<?
if ($cmb_alumno==0){
    $ob_reporte ->cmb_curso = $cmb_curso;
	$rs = $ob_reporte ->ApoderadoCurso2($conn);
}else{
	$ob_reporte ->alumno = $cmb_alumno;
	$rs = $ob_reporte ->Apoderado($conn);
}
?>

<?
$ns = @pg_numrows($rs);
$i=0;
while ($i < $ns){
	$fs = @pg_fetch_array($rs,$i);
	$ob_reporte ->CambiaDatoApo($fs);
	$rut_apo =  $fs['rut_apo']; 
	$rut_alu =  $fs['rut_alumno']; 
	
    ?>	
	<table width="650" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td>
		
		
	<? if ($institucion=="770"){ 
		   // no muestro los datos de la institucion
		   // por que ellos tienen hojas pre-impresas
		   echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
		   
	  }else{
		
		    ?>
		
		
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td>
					<!-- aqui va la insignia -->
					
					<table width="125" border="0" cellpadding="0" cellspacing="0">
					<tr valign="top" >
					  <td width="125" align="center"> 	  
						<?
						if($institucion!=""){
						   echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}?>		  </td>
					</tr>
				  </table>
					
					<!-- fin de la insignia -->					</td>
					<td><div align="right" class="subitem"><?=fecha_espanol($txtFECHA) ?></div></td>
				  </tr>
				</table>
	<? } ?>	
		
		
		
		<?
				
		//// aqui tomo los datos del alumno
		if($cmb_alumno==0){
			 //$sql="select * from alumno where rut_alumno in (select rut_alumno from matricula where rdb=$_INSTIT AND id_ano=$ano and id_curso=$curso and bool_ar=0 and rut_alumno in ( select rut_alumno from tiene2 where rut_apo = '".trim($rut_apo)."'))";
			 $sql="select * from alumno where rut_alumno =".$rut_alu;
		}else{
			$sql="select * from alumno where rut_alumno in (select rut_alumno from tiene2 where rut_apo = '".trim($rut_apo)."'  and rut_alumno in (select rut_alumno from matricula where rdb=$_INSTIT AND id_ano=$ano and id_curso=$curso and bool_ar=0 and rut_alumno=$cmb_alumno))";
		//$sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno and alumno.rut_alumno = '".trim($cmb_alumno)."'";
		}	
		
		$result= @pg_Exec($conn,$sql);
		$fila =  @pg_fetch_array($result,0);
		$nombre_alumno  = $fila['ape_pat'];
		$nombre_alumno .= $fila['ape_mat'];
		$nombre_alumno .= $fila['nombre_alu'];
		
		/// fin nombre del alumno
	    		
		/// ahora debo tomar los datos de acceso
		$sq1 = "select * from usuario where nombre_usuario = '".trim($rut_apo)."'";
		$rq1 = pg_Exec($connection,$sq1);
		if (@pg_numrows($rq1)>0){
			 $filasq1 = @pg_fetch_array($rq1,0);
			 $usuario_apoderado = $filasq1['nombre_usuario'];
			 $clave_apoderado   = $filasq1['pw'];
		}
		//// fin datos de acceso del apoderado	
	    ?>
		<br>
		<br>
		
		  <p class="Estilo5"><br>
			<span class="subitem"><br>
			Se&ntilde;or(a): <b>
			<?=$ob_reporte->tilde($ob_reporte->ape_nombre_apo); ?>
			</b><br>
			Apoderado(a)  de <b>
			<?=$ob_reporte->tilde($nombre_alumno); ?>
			</b> de <b>
			<?=$Curso_pal ?>
			</b></span></p>
		  <span class="subitem"><strong>Presente:</strong> con saludarle, tenemos el agrado de informarle que nuestro establecimiento se  encuentra en un plan de innovaci&oacute;n tecnol&oacute;gica y se ha adherido a la plataforma  Internet de Gesti&oacute;n Escolar &ldquo;Colegio Interactivo&rdquo;.<br>            
			<br>
			Esta  aplicaci&oacute;n a la cual podr&aacute; acceder desde el &nbsp;sitio Web , nos permitir&aacute;&nbsp; fortalecer la misi&oacute;n familia-colegio,  inform&aacute;ndole en forma continua tanto del rendimiento acad&eacute;mico de su pupilo(a),  como su conducta, a fin de fortalecer sus debilidades y destacar sus logros.</span><br>            
			<br>            
			<br>
			<span class="subitem">Para  acceder a esta informaci&oacute;n por primera vez, siga los siguientes pasos:</span><br>            
			<br>            
			<span class="subitem"><strong>Acceso como apoderado: </strong>                </span>            </span>
		  <ol class="Estilo5">
			<li class="subitem">Nombre de usuario: <b>
		    <?=$usuario_apoderado ?>
			</b> </li>
			<li class="subitem">Clave: <b>
		    <?=$clave_apoderado ?>
			</b><br>
			</li>
		  </ol>
		    <span class="subitem">
		  <? 
		  // ahora tomo el nombre del alumno
		  if ($cmb_alumno>0){
			  $sql_usu = "select * from usuario where nombre_usuario = '".trim($cmb_alumno)."'";
			  $res_usu = @pg_Exec($connection,$sql_usu);
			  $num_usu = @pg_numrows($res_usu);
				
			  if ($num_usu > 0){
				 $fil_usu = @pg_fetch_array($res_usu,0);
				 $alu_usu  = $fil_usu['nombre_usuario'];
				 $alu_pw   = $fil_usu['pw'];		     
			  } 	 
		  		  
		  }else{
		     // $sql_usu = "select rut_alumno from alumno where rut_alumno in (select rut_alumno from matricula where rdb=$_INSTIT AND id_ano=$ano and id_curso=$curso and bool_ar=0 and rut_alumno in ( select rut_alumno from tiene2 where rut_apo = '".trim($rut_apo)."'))";
			   $sql_usu="select * from alumno where rut_alumno =".$rut_alu;
			  $res_usu = @pg_exec($conn,$sql_usu);
			 $num_usu = @pg_numrows($res_usu);
				
			  if ($num_usu > 0){
			      $fil_usu = @pg_fetch_array($res_usu,0);
		          $rut_alumno  = $fil_usu['rut_alumno'];
				  
				  
				  //$sql_usu2 = "select * from usuario where nombre_usuario = '".trim($rut_alumno)."'";
				   $sql_usu2 = "select * from usuario where nombre_usuario = '".trim($rut_alu)."'";
				  $res_usu2 = @pg_Exec($connection,$sql_usu2);
				  $num_usu2 = @pg_numrows($res_usu2);
					
				  if ($num_usu2 > 0){
					 $fil_usu2 = @pg_fetch_array($res_usu2,0);
					 $alu_usu  = $fil_usu2['nombre_usuario'];
					 $alu_pw   = $fil_usu2['pw'];		     
				  }
			   }  
		  } 
		  ?>
		  <br>          
		  <strong>Acceso como Alumno:</strong>            </span>
	      <ol>
		    <li class="subitem">Nombre de usuario:<strong> 
	        <?=$alu_usu ?>
		    </strong></li>
		    <li class="subitem">Clave: <strong> 
	        <?=$alu_pw ?>
		    </strong> </li>
		  </ol>
	  
	            <span class="subitem"><br>
	            Como norma de  seguridad, le solicitamos modifique su clave peri&oacute;dicamente y en caso de tener  dificultades comun&iacute;quese con el soporte interno del Colegio.
                </p>  	      
                Atentamente a  usted.</span><br>
		  <p align="center" class="Estilo5"><br>
		  </p>	    </td>
	  </tr>
</table>
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
	
<table width="650" border="0">
  <tr>
    <td>&nbsp;<hr></td>
  </tr>
  <tr>
    <td>
    <? if($colilla==1){?>
    <table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td colspan="4"><div align="justify"><font face="Arial, Helvetica, sans-serif"><strong><img src="../../tijera.gif" width="32" height="16">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </strong></font></div></td>
      </tr>
      <tr>
        <td colspan="2"><div align="left" class="Estilo2"><font face="Arial, Helvetica, sans-serif">Devolver colilla firmada</font></div></td>
        <td width="109"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
        <td width="162">&nbsp;</td>
      </tr>
      <tr>
        <td width="124"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Alumno</strong></font></div></td>
        <td width="245"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $ob_reporte->tildeM($nombre_alumno); ?></strong></font></div></td>
        <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Curso</strong></font></div></td>
        <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $Curso_pal?></strong></font></div></td>
      </tr>
      <tr>
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
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="center">___________________________</div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Firma Apoderado </font></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <? } ?>
    </td>
  </tr>
</table>
</form>
	<?
	
	if  ($ns > 1){ 
	    echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	}
	?>
	
    <?
	$i++;
 } ?>

</body>
</html>
<? pg_close($conn);?>