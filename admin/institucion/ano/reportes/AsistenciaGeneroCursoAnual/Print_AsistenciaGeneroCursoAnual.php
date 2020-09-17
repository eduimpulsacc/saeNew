
<?php
require('../../../../../util/header.inc');
include_once("class_AsistenciaGeneroCursoAnual.php");
include('../../../../clases/class_Reporte.php');
include('../../../../clases/class_Membrete.php');
//print_r($_POST);
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $select_ano;
	$curso			= $select_cursos;
	$docente		= 5; //Codigo Docente
	$frmModo		= $_FRMMODO;
	$alumno			= $cmb_alumno;	
	$reporte		= $c_reporte;

	//print_r($_POST);

/*if ($select_cursos>0){
	$Curso_pal = CursoPalabra($curso, 1, $conn);
}*/


	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	$ob_motor = new BuscadorReporte($conn);

	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
 
	$fecha=$ob_reporte->fecha_actual();
	
	
	$rs_nro_ano = $ob_motor->numero_ano($ano);
	$nro_ano = pg_result($rs_nro_ano,1);
	
	/******************DIAS HABILES AÑO******************************************************/
	$rs_habiles=$ob_motor->dias_habiles($ano);
	$dias_habiles = pg_result($rs_habiles,0);
	
	/***************************************************************************************/
	
	
	/**************CURSOS***************************************************************************/
		$rs_cursos= $ob_motor->carga_cursos($ano);
		
		


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

<?
	
				
?>
        
        
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
        		
		


		<table width="680"  align="center" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
					<td>&nbsp;</td>
				  </tr>
				</table>
		<br><br>
        
        <table width="650">
        <tr>
        <td class="textonegrita"><DIV style="width:50; height:10; float:left; text-align:left">INSTITUCION:</DIV></td>
        <td class="titulo"><?     $ob_membrete->institucion = $institucion;                                   
					$ob_membrete->institucion($conn);
					
					?>
            <DIV style="width:250; height:10; float:left; text-align:left"><? echo $ob_membrete->ins_pal ?></DIV>        
                    </td>
        </tr>
      <tr>
      <td colspan="2">&nbsp; </td>
      </tr>
        <tr>
        <td class="titulo"><DIV style="width:50; height:10; float:left; text-align:left">A&Ntilde;O:</DIV></td>
        <td class="titulo"><?    
					
					?>
            <DIV style="width:250; height:10; float:left; text-align:left"><? echo $nro_ano ?></DIV>        
                    </td>
        </tr>
        </table>
        <BR><BR>
		
        <table class="tableindex"  width="650" border="1" style="border-collapse:collapse">
        <tr>
        <td align="center">REPORTE ASISTENCIA POR GENERO ANUAL</td>
        </tr>
        </table>
        
        <BR>
		<table width="650" style="border-collapse:collapse" border="1">
         <tr class="subitem" style="background-color:#CCC">
        <td align="center" class="textonegrita">Curso</td>
        <td align="center" class="textonegrita">Masculino</td>
        <td align="center" class="textonegrita">Femenino</td>
        <td align="center" class="textonegrita">Total</td>
        </tr>
        <tr class="subitem">
        <?php
        
				
		for($e=0;$e<@pg_numrows($rs_cursos);$e++){
			
		$fila = pg_fetch_array($rs_cursos,$e);
		$id_curso=$fila['id_curso'];	
		
		$Curso_pal = CursoPalabra($id_curso, 1, $conn);
		$rs_asistencia1=$ob_motor->asistencias_mujeres($ano,$id_curso);
		$total_asistecia_hombres= pg_result($rs_asistencia1,0);
		if($total_asistecia_hombres==""){
			$total_asistecia_hombres=0;
			}
		
		$rs_asistencia2=$ob_motor->asistencias_hombres($ano,$id_curso);
		$total_asistecia_mujeres= pg_result($rs_asistencia2,0);
		if($total_asistecia_mujeres==""){
			$total_asistecia_mujeres=0;
			}
		
		
	    ?>
        
		<td class="subitem"><?=$Curso_pal?></td>
        
        <?
        	
		?>
        
        <td class="subitem"><?	
        		$proc_hom=($total_asistecia_hombres*100)/$dias_habiles;
				$total_porc_hom=100-$proc_hom;
				echo round($total_porc_hom)." % ";
				
				?></td>
        <td class="subitem"><?
				$porc_muj=($total_asistecia_mujeres*100)/$dias_habiles;
				$total_porc_muj=100-$porc_muj;
				echo round($total_porc_muj)." % ";
				
				?></td>
        <td  class="subitem"><?
		$total_total=$total_porc_hom+$total_porc_muj;
		$porc_total=($total_total*100)/$dias_habiles;
		//$total_porc_total=100-$porc_total;
		$total_porc_total= $total_total / 2;
		echo round($total_porc_total)." %";
		
		?></td>
        </tr>
        
        <?
        }
		?>
        
        </table>
        <br>
        
             
		
   </td>
	  </tr>
</table>
 <?php  
		 $ruta_timbre =5;
		 $ruta_firma =3;
		 
		 include("../firmas/firmas.php");?>
<table width="650" border="0" align="center">
  <tr>
    <td>&nbsp;<hr></td>
  </tr>
  
  <tr>
    <td><div align="right" class="subitem"><?=$fecha;?></div></td>
  </tr>

  
</table>

	<?
	    echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	
	?>
	
    

</body>
</html>
<? pg_close($conn);?>