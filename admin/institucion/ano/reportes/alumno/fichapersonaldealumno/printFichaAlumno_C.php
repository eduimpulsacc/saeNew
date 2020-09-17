<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

</script>

<?
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_MotorBusqueda.php');
include('../../../../../clases/class_Membrete.php');
include('../../../../../clases/class_Reporte.php');


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
				$ob_reporte->item= $fils_item['id_item'];
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
		
		//
		//echo $crp;


if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Ficha_personal_alumno_$fecha_actual.xls"); 	 
}	 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<?
if ($curso != 0){
   ?><br>
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
   <?
}


	if ($alumno > 0){
		$ob_reporte->alumno=$alumno;
		$ob_reporte->ano=$ano;
		$ob_reporte->rdb=$rdb;
		$ob_reporte->curso=$curso;
		$result_alumno=$ob_reporte->FichaAlumnoUno($conn);
	}else{
		$ob_reporte->ano=$ano;
		$ob_reporte->curso=$curso;
		$ob_reporte->retirado=$retirado;
		$ob_reporte->rdb=$rdb;
		$result_alumno=$ob_reporte->FichaAlumnoTodos($conn);		
	}	
	$cantidad_alumnos = @pg_numrows($result_alumno);
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++)
	{
		$fila_alumno = @pg_fetch_array($result_alumno,$i);
		$ob_reporte->CambiaDato($fila_alumno);
		
		$alumno 			= $ob_reporte->alumno;
		$rut_alumno 		= $ob_reporte->rut_alumno;
		$nombre 			= $ob_reporte->nombre;
		$ape_pat 			= $ob_reporte->ape_pat;
		$ape_mat 			= $ob_reporte->ape_mat;
		$fecha_nacimiento 	= $ob_reporte->fecha_nacimiento;
		$sexo 				= $ob_reporte->sexo;
		$nacionalidad 		= $ob_reporte->nacionalidad;
		$telefono_alu 		= $ob_reporte->telefono_alu;
		$email 				= $ob_reporte->email;
		$fecha_matricula 	= $ob_reporte->fecha_matricula;
		$fecha_retiro 		= $ob_reporte->fecha_retiro;
		$bool_baj 			= $ob_reporte->bool_baj;		
		$bool_aoi 			= $ob_reporte->bool_aoi;		
		$bool_rg 			= $ob_reporte->bool_rg;		
		$bool_ae 			= $ob_reporte->bool_ae;		
		$bool_i 			= $ob_reporte->bool_i;		
		$bool_gd 			= $ob_reporte->bool_gd;		
		$bool_ar 			= $ob_reporte->bool_ar;		
		$bool_bchs 			= $ob_reporte->bool_bchs;	
		$direccion_alu 		= $ob_reporte->direccion_alu;
		$comuna 			= $ob_reporte->comuna;
		$provincia 			= $ob_reporte->provincia;
		$region 			= $ob_reporte->region;
		$block 				= $ob_reporte->block;
		$depto 				= $ob_reporte->depto;
		$villa 				= $ob_reporte->villa;
		$salud 				= $ob_reporte->salud;
		$religion 			= $ob_reporte->religion;		
?>
<?
 if ($institucion=="770"){ 
	    // no muestro los datos de la institucion
	    // por que ellos tienen hojas pre-impresas
	    echo "<br><br><br><br><br><br><br><br><br><br><br>";
			   
  }else{
		
       ?>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="152"><? echo "<img src='../../../../../../tmp/".$institucion."insignia". "' >"; ?> </td>
    <td width="379">&nbsp;</td>
    <?
				$result = @pg_Exec($conn,"select * from alumno where rut_alumno=".$alumno);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				if 	(!empty($fila_foto['foto']))
				{
					$output= "select lo_export(".$arr['foto'].",'/var/www/html/tmp/".$arr[rut_alumno]."');";
					$retrieve_result = @pg_exec($conn,$output);?>
    <td width="119" rowspan="7"><div align="center"><img src=../../../../../../../tmp/<? echo $alumno ?> alt="FOTO"  height="100"></div></td>
    <? }?>
  </tr>
      <? if($cb_ok!="Buscar"){?>
	<tr>&nbsp;</tr>
	<tr>&nbsp;</tr>
	<tr>&nbsp;</tr>
  <? }?>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>
      <?=$ob_membrete->ins_pal;?>
    </strong></font></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>
      <?=$ob_membrete->direccion;?>
    </strong></font></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>
      <?=$ob_membrete->telefono;?>
    </strong></font></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>

</table>
<? } ?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">FICHA DEL ALUMNO &nbsp;</div></td>
  </tr>
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="280" class="item"><div align="left"><strong>Rut Alumno</strong></div></td>
    <td width="184">&nbsp;</td>
    <td width="186">&nbsp;</td>
  </tr>
  <tr>
    <td class="subitem"><div align="left"><? echo $rut_alumno?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td class="item"><div align="left"><strong>Nombres</strong></div></td>
    <td class="item"><div align="left"><strong>Apellido Paterno</strong></div></td>
    <td class="item"><div align="left"><strong>Apellido Materno</strong></div></td>
  </tr>
  <tr>
    <td class="subitem"><? echo $nombre?></td>
    <td class="subitem"><div align="left"><? echo $ape_pat?></div></td>
    <td class="subitem"><? echo $ape_mat?></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>Fecha de Nacimiento</strong></div></td>
    <td class="item"><div align="left"><strong>Sexo</strong></div></td>
    <td class="item"><div align="left"><strong>Nacionalidad</strong></div></td>
  </tr>
  <tr>
    <td class="subitem"><div align="left"><? echo Cfecha2($fecha_nacimiento)?></div></td>
    <td class="subitem"><? echo $sexo?></td>
    <td class="subitem"><? echo $nacionalidad?></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>Teléfono</strong></div></td>
    <td class="item"><div align="left"><strong>E-mail</strong></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td class="subitem"><? echo $telefono_alu?></td>
    <td class="subitem"><div align="left"><? echo $email?></div></td>
    <td>&nbsp;</td>
  </tr>  
   <tr>
    <td class="item"><div align="left"><strong>Sistema de salud</strong></div></td>
    <td class="item"><div align="left"><strong>Religion</strong></div></td>
    <td class="item">&nbsp;</td>
  </tr>
  <tr>
      <td class="subitem"><? echo $salud?></td>
    <td class="subitem"><div align="left"><? echo $religion?></div></td>
    <td class="subitem">&nbsp;</td>
  </tr>  
  <tr>
    <td class="item"><div align="left"><strong>Curso</strong></div></td>
    <td class="item"><div align="left"><strong>Fecha de Matricula</strong></div></td>
    <td class="item">&nbsp;</td>
  </tr>
  <tr>
    <td class="subitem">
	  <? 
				$Curso_pal = CursoPalabra($curso, 0, $conn);
				echo $Curso_pal; 
				?>	</td>
    <td class="subitem"><div align="left"><? echo Cfecha2($fecha_matricula)?></div></td>
    <td class="subitem">&nbsp;</td>
  </tr>
</table>
 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
             <? $qryD="select dependencia from institucion where rdb=".$_INSTIT;
		    	 $resultD =@pg_Exec($conn,$qryD);
			 		$filaD = @pg_fetch_array($resultD,0);
				 if (($filaD['dependencia']!=0) and ($filaD['dependencia']!=1)){ 
				 ?>

   <tr>
     <td width="101" class="item"><strong>BECA ALIMENTACION JUNAEB</strong> </td>
     <td width="94" class="item"><strong>BENEFICIO CHILE SOLIDARIO </strong></td>
     <td width="103" class="item"><strong>ALUMNO ORIGEN INDIGENA</strong></td>
     <td width="76" class="item"><strong>REPITENTE DEL GRADO </strong></td>
     <td width="93" class="item"><strong>ALUMNA EMBARAZADA </strong></td>
     <td width="89" class="item"><strong>GRUPO DIFERENCIAL </strong></td>
     <td width="77" class="item"><strong>INTEGRADO</strong></td>
   </tr>
   <tr>
     <td class="subitem"><? echo $bool_baj?></td>
     <td class="subitem"><? echo $bool_bchs?></td>
     <td class="subitem"><? echo $bool_aoi?></td>
     <td class="subitem"><? echo $bool_rg?></td>
     <td class="subitem"><? echo $bool_ae?></td>
     <td class="subitem"><? echo $bool_gd?></td>
     <td class="subitem"><? echo $bool_i?></td>
   </tr>
               <? } ?>

   <tr>
     <td><font class="item"><strong>Alumno Retirado </strong></font></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td class="subitem"><? echo $bool_ar?></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><font class="item"><strong>Fecha Retiro </strong></font></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><? echo Cfecha2($fecha_retiro)?></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
</table>
 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table> 
 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
      <td width="221"><font class="item"><strong>Direcci&oacute;n</strong></font></td>
    <td width="206">&nbsp;</td>
    <td width="223">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="subitem"><? echo $direccion_alu?></td>
   </tr>
  <tr>
      <td class="item"><strong>Depto</strong></td>
      <td class="item"><strong>Block</strong></td>
      <td class="item"><strong>Villa/Poblaci&oacute;n</strong></td>
  </tr>
  <tr>
    <td class="subitem"><div align="left"><? echo $depto?></div></td>
    <td class="subitem"><div align="left"><? echo $block?></div></td>
    <td class="subitem"><div align="left"><? echo $villa?></div></td>
  </tr>
  <tr>
      <td class="item"><strong>Regi&oacute;n</strong></td>
      <td class="item"><strong>Provincia</strong></td>
      <td class="item"><strong>Comuna</strong></td>
  </tr>
  <tr>
    <td class="subitem"><? echo $ob_reporte->tilde($region);?></td>
    <td class="subitem"><? echo $provincia?></td>
    <td class="subitem"><? echo $comuna?></td>
  </tr>
</table>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
</table>
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <?
	$ob_reporte->alumno=$alumno;
	$result_apo=$ob_reporte->Apoderado($conn);
	if (@pg_numrows($result_apo)>0)
	{
?>
    <tr> 
      <td colspan="3" class="item"><font class="item"><strong>PADRES 
        Y APODERADOS </strong></font></td>
    </tr>
    <?	
}
	for($e=0 ; $e < @pg_numrows($result_apo) ; $e++)
	{
		$fila_apo = @pg_fetch_array($result_apo,$e);
		$ob_reporte->CambiaDatoApo($fila_apo);
		
		$rut_apo 		= $ob_reporte->rut_apo;
		$nombre_apo 	= $ob_reporte->nombre_apo;
		$ape_pat 		= $ob_reporte->ape_pat;
		$ape_mat 		= $ob_reporte->ape_mat;
		$telefono_apo 	= $ob_reporte->telefono_apo;
		$email_apo 		= $ob_reporte->email_apo;
		$relacion 		= $ob_reporte->relacion;
		
?>
    <tr> 
      <td class="item"><strong>Rut</strong></td>
      <td class="item">&nbsp;</td>
      <td class="item">&nbsp;</td>
    </tr>
    <tr> 
      <td class="subitem"><? echo $rut_apo?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td class="item"><strong>Nombres</strong></td>
      <td class="item"><strong>Apellido Paterno </strong> </td>
      <td class="item"><strong>Apellido Materno </strong></td>
    </tr>
    <tr> 
      <td class="subitem"><? echo $nombre_apo?></td>
      <td class="subitem"><? echo $ape_pat?></td>
      <td class="subitem"><? echo $ape_mat?></td>
    </tr>
    <tr> 
      <td class="item"><strong>Tel&eacute;fono</strong></td>
      <td class="item"><strong>E-mail</strong></td>
      <td class="item"><strong>Relaci&oacute;n</strong></td>
    </tr>
    <tr> 
      <td class="subitem"><div align="left"><? echo $telefono_apo?></div></td>
      <td class="subitem"><? echo $email_apo?></td>
      <td class="subitem"><? echo $relacion?></td>
    </tr>
    <tr> 
      <td colspan="3"><hr width="100%" color=#003b85></td>
    </tr>
    <? } ?><br><br>
	<tr>
		<td colspan="3">
         <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
		<!--<table width="650" border="0" align="center">
                                      <tr>
                                        <? if(!$cb_ok=="Buscar"){?>
                                        <td>&nbsp;</td>
                                        <? }?>
                                        <?  
										if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->empleado=$ob_config->empleado1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg") && $crp==1){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='200' height='80'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
                
			<td width="25%" class="item" height="100"><div style="width:100; height:50;"><br>
			  <br>
            </div>
			<hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			<? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->empleado=$ob_config->empleado2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg") && $crp==1){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='200' height='80'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				if(isset($firmadig2)){
				echo $firmadig2;
				}else{
				?>
		    <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"> 
		      <div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->empleado=$ob_config->empleado3;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg") && $crp==1){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='200' height='80'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				echo $firmadig3;
				}else{
				
				?>
			<td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->empleado=$ob_config->empleado4;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg") && $crp==1){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='200' height='80'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				echo $firmadig4;
				}else{
		?>
		  <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?> </div></td>
			<? }}?>
            
            
            <? if($chk_apo==1){?>
          <td width="25%" class="item"><br>
            <br>
            <br>
            <br>
<hr align="center" width="150" color="#000000">
	        <div align="center">
             Nombre :<br>
	         RUN :  <br>
	         Firma Apoderado :
	          </div></td>
		<? }
		if($institucion==14490){ ?>
        <td width="25%" class="item"><br>
            <br>
            <br>
            <br>
<hr align="center" width="150" color="#000000">
	        <div align="center">
	          
	          <br>
	          Direcci&oacute;n
	          </div></td>
        <? } ?>
		  </tr>
		</table>--></td>
	</tr>
</table>
</form>

 <? if  (($cantidad_alumnos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
} ?>
</center>

  <!-- FIN DEL CONTENIDO CENTRAL DE LA PÁGINA -->
  
  
  
       <!-- INSERTO EL CONTENIDO DEL MOTOR DE BUSQUEDA -->
	  
	   
	   <!-- FIN DEL CONTENIDO DEL MOTOR DE BUSQUEDA -->								  
								  
								 
</body>
</html>
<? pg_close($conn);
pg_close($connection);?>