<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	guardaImp();
	document.getElementById("capa0").style.display='block';
}
</script>

<?
require('../../../../../../util/header.inc');
include('../../../../../clases/class_Membrete.php');
include('../../../../../clases/class_Reporte.php');

/*if($_PERFIL==0){
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	}*/

$ano		= $_ANO;
$curso		= $cmb_curso;
$alumno		= $cmb_alumno;
$reporte	= $c_reporte;
$institucion= $_INSTIT;
$contador_salto=0;
$_POSP = 5;
$_bot = 8;
$tipop = $tipo_planilla;

$ruta_timbre =6;
$ruta_firma =4;

if(!isset($chk_asis)){
	$chk_asis=0;
	}
	

//echo "_".$chk_asis;

																																																																																																																																																																																																																											
$ob_reporte = new Reporte();
$ob_membrete = new Membrete();


/************************ INSTITUCION ***********************/
$ob_membrete ->institucion=$institucion;
$ob_membrete ->institucion($conn);

/*********************** ANO ESCOLAR ***********************/
$ob_membrete ->ano = $ano;
$ob_membrete ->AnoEscolar($conn);
$nro_ano = $ob_membrete->nro_ano;
$finicio_col = $ob_membrete->fecha_inicio;
 $ftermino_col = $ob_membrete->fecha_termino;

/*******************CURSO ***********************/
if($institucion==1653){
	$Curso_pal = CursoPalabra($curso, 6, $conn);
}else{
	$Curso_pal = CursoPalabra($curso, 1, $conn);
}

/***************** PROFESOR JEFE *******************/
$ob_reporte ->curso =$curso;
$ob_reporte ->ProfeJefe($conn);

/****************** PERIODO ***********************/
$ob_reporte ->ano = $ano;
$resultPeriodo= $ob_reporte ->TotalPeriodo($conn);


//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	$tamañoTiulo = $ob_config->tamanoT + 4;
	
	
	$ob_membrete->curso = $curso;
	$rs_curso = $ob_membrete->curso($conn);
	

	$finicio_curso = $ob_membrete->finicio_curso;
	$ftermino_curso = $ob_membrete->ftermino_curso;
	
if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Informe_educacional_personalidad_$fecha_actual.xls"); 	 
}	


?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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

</head>
 <STYLE>
 

  H1.SaltoDePagina {
		 PAGE-BREAK-AFTER: always
		 
	  }
  .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$tamañoTiulo;?>px;
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
  .hidden
 {
 visibility:hidden
 }

  </style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

  <!-- INSERTO CODIGO SUPERIOR -->     
 

			     
<form method "post" action="printInformePersonalidadAnual_C.php" name="form" target="_blank">
			  
<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr> 
					<td>           
					<div id="capa0">
					  <div align="right">
					    <input 	name="cmdimprimiroriginal" type="button" class="botonXX" id="cmdimprimiroriginal" onClick="imprimir()" 	value="Imprimir">
					    
			          </div>
					</div>        </td>
				</tr>
			  </table>
			
<script type="text/javascript">
document.getElementById("capa4").style.display='block';

function imprimir1() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
	
}
function imprimir2() 
{
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
	
	window.print();
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
}
</script>

  <?
 	if ($cmb_alumno==0){
		$ob_reporte ->ano =$ano;
		$ob_reporte ->curso =$curso;
		$ob_reporte ->retirado =$_REQUEST['retirado'];
		$result_alu =$ob_reporte ->TraeTodosAlumnos($conn);
	}else{
		$ob_reporte ->ano =$ano;
		$ob_reporte ->curso =$curso;
		$ob_reporte ->alumno=$alumno;
		$result_alu =$ob_reporte ->TraeUnAlumno($conn);
	}	
	$cont_alumnos = @pg_numrows($result_alu);
$cadalu="";
for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++){

	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	$fecha_retiro = $fila_alu['fecha_retiro'];
	$fecha_matricula = $fila_alu['fecha'];
	$ob_reporte ->CambiaDato($fila_alu);
	$cadalu.=$alumno.",";
	
	$ob_reporte ->alumno =$alumno;
	$ob_reporte ->ano =$ano;
	$resultMatri =$ob_reporte ->MatriculaCurso($conn);
	$filaMatri=@pg_fetch_array($resultMatri,0);
	/*if($filaMatri['grado_curso']==1) $gr="pa";
	if($filaMatri['grado_curso']==2) $gr="sa";
	if($filaMatri['grado_curso']==3) $gr="ta";
	if($filaMatri['grado_curso']==4) $gr="cu";
	if($filaMatri['grado_curso']==5) $gr="qu";
	if($filaMatri['grado_curso']==6) $gr="sx";
	if($filaMatri['grado_curso']==7) $gr="sp";
	if($filaMatri['grado_curso']==8) $gr="oc";
	if($filaMatri['grado_curso']==9) $gr="nv";
	if($filaMatri['grado_curso']==10) $gr="dc";
	if($filaMatri['grado_curso']==11) $gr="un";
	if($filaMatri['grado_curso']==12) $gr="duo";
	if($filaMatri['grado_curso']==13) $gr="tre";
	if($filaMatri['grado_curso']==14) $gr="cat";
	if($filaMatri['grado_curso']==15) $gr="quince";
	if($filaMatri['grado_curso']==16) $gr="diezseis";
	*/

	$ob_reporte ->ensenanza=$filaMatri['ensenanza'];
	$ob_reporte ->grado= $gr;
	$ob_reporte ->institucion=$institucion;
	$ob_reporte->tipop = @$tipop;
	$resultPlantilla=$ob_reporte ->InformePlantillaPei($conn);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);
	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$filaMatri['ensenanza'];
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$titulo1 = $filaPlantilla['nombre'];
	$nuevo = $filaPlantilla['nuevo_sis'];	

?>
<!--tabla colegio-->
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <? if ($institucion!="770"){ ?>
    <td width="114" class="item"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
    <td width="9" class="item"><strong>:</strong></td>
    <td width="361" class="item"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
    <td width="161" rowspan="5" align="center" valign="top" ><?
					$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto  = @pg_fetch_array($result,0);
					## c&oacute;digo para tomar la insignia
			
				  if($institucion!=""){
					   echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>    </td>
    <? } ?>
  </tr>
  <tr>
    <td valign="top" class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
  </tr>
  
</table>
<br>

<!--<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td width="80%" valign="top">
      
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr></tr>
        <tr> 
          <td width="13%" class="item">Alumno(a)</td>
			    <td width="52%" class="subitem" >: <b> <?php echo strtoupper( $ob_reporte->Tilde($ob_reporte->nombres));?> </b></td>
			        
		      </tr>
               <tr>
                <td width="6%" class="item">RUT</td>			  
			        <td width="21%"  class="item">: <?php echo $ob_reporte->rut_alumno?></td>
               </tr>
        </table>
	    
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
		    <tr> 
		      <td width="20%" class="item">Curso</td>
			    <td width="80%" class="subitem">: <?php echo $Curso_pal; ?></td>
			  </tr>
		    </table>
	    <?php if($filaMatri['ensenanza']>310 ){?>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="20%" class="item">Especialidad</td>
		  <td width="80%" class="subitem">: <?php $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaMatri['cod_es']." and cod_sector=".$filaMatri['cod_sector']." and cod_rama=".$filaMatri['cod_rama'];
										$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
										$filaEsp=@pg_fetch_array($resultEsp,0);
										echo $filaEsp['nombre_esp'];?></font></td>
		      </tr>
        </table>
	    <?php } ?>
      
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="20%" class="item">Profesor Jefe</td>
            <td width="80%" class="subitem">: <?php echo $ob_reporte->tildeM($ob_reporte->profe_nombre);?></td>
          </tr>
        <tr>
          
          </tr>
        </table>
	   </td>
	   <td width="20%" valign="top">&nbsp;</td>
	  </tr>
  </table>-->
  <table width="650" border="0" align="center" class="textosimple">
  <tr>
    <td height="24" colspan="4" align="center">PLAN ESPEC&Iacute;FICO INDIVIDUAL</td>
    </tr>
  <tr>
    <td height="24" colspan="4" align="center">
    <?php $sa="select nombre from pei_area_evaluacion where id_area=".$filaPlantilla['area'];
			$ra=pg_exec($conn,$sa);
			
	?>
    &Aacute;REA (<?php echo strtoupper(pg_result($ra,0)); ?>)</td>
    </tr>
  <tr>
    <td height="24" colspan="4" align="center">PROGRAMA DE INTEGRACI&Oacute;N (PIE) - EQUIPO MULTIDISCIPLINARIO (EQM)</td>
  </tr>
  <tr>
    <td height="24">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="25%" height="24">Nombre</td>
    <td width="25%"><?php echo strtoupper( $ob_reporte->Tilde($ob_reporte->nombres));?></td>
    <td width="25%">Edad al 03/03</td>
    <td width="25%"><?php echo edadAnoMes($ob_reporte->fecha_nacimiento,$nro_ano."-03-03",3);  ?></td>
  </tr>
  <tr>
    <td width="25%">Fecha de Nacimiento</td>
    <td width="25%"><?php echo CambioFD($ob_reporte->fecha_nacimiento) ?></td>
    <td width="25%">Curso:</td>
    <td width="25%"><?php echo $Curso_pal; ?></td>
  </tr>
  <tr>
    <td width="25%">Diagn&oacute;stico</td>
    <td width="25%"><?php echo strtoupper( $ob_reporte->Tilde($ob_reporte->enfermedad));?></td>
    <td width="25%">Psic&oacute;loga</td>
    <td width="25%">&nbsp;</td>
  </tr>
  <tr>
    <td width="25%">Profesor Especialista</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
  </tr>
</table>
<br>

<!--escala arriba-->

<!--fin escala arriba-->
<?

$plantilla = $filaPlantilla['id_plantilla'];
// Areas
$ob_reporte ->nuevo = $nuevo;
$ob_reporte ->plantilla = $plantilla;
$result_cat=$ob_reporte ->InformeAreasPei($conn);
$num_cat=@pg_numrows($result_cat);
$jjj = 1;

for ($i=0;$i<$num_cat;$i++)	{
?>
 <table width="650" border="1" align="center" cellpadding="<?=$txtFILAS;?>" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse">
 <?php 
					//parto con las categorias
					$row_cat=pg_fetch_array($result_cat);	?> 
                    <?php if ($row_cat['salto_pagina']==1){	?>
                    </table>
                    <H1 class=SaltoDePagina></H1>
<table width="650" border="1" align="center" cellpadding="<?=$txtFILAS;?>" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse">
                    <?php }?> 
 <tr><td><img src='../../../../cortes/p.gif' width='10' height='1' border='0'></td>
 <?
						$tot_periodos = pg_numrows($resultPeriodo);
						for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
							$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
							$id_peri[$countP] = $filaPeriodo['id_periodo']; 						
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE")  $per="1 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE")  $per="3 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE")  $regimen="trimestre";
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE")   $per="1 Sem.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE")  $per="2 Sem.";
							?>
                            
							<td align="center" class="subitem"><?php echo $per ?></td>
						<?php }?>
                        
  </tr>	
						
							
					
                    <tr>
                     <td colspan="<?php echo $tot_periodos+2 ?>" class="item" height="15" align="center" ><strong>
											
					 <? 
											echo $row_cat['glosa'];
									   ?> 
									  </strong>               
					  </td>  
                                                                   
			</tr>
              <?            				    // Subareas
								$ob_reporte ->nuevo = $nuevo;
								$ob_reporte ->plantilla = $plantilla;
								$ob_reporte ->id_padre = $row_cat[id_item];
								$ob_reporte ->id_area = $row_cat[id_item];
								$result_sub=$ob_reporte ->InformeSubAreaPei($conn);
								$num_sub=pg_numrows($result_sub);?>
            <? for ($j=0;$j<$num_sub;$j++){
								      $row_sub=pg_fetch_array($result_sub);	
									
										  if($institucion==14703){ $alig = "center"; }else{ $alig = "left";}
									  ?> 
                                      <?php if ($row_sub['salto_pagina']==1){	?>
                                  <!--<tr ><td colspan="2" style="border-color:#FFF"><H1 class=SaltoDePagina></H1></td></tr> -->                   </table>
<H1 class=SaltoDePagina></H1>
                                   <table width="650" border="1" align="center" cellpadding="<?=$txtFILAS;?>" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse">
                                    <tr><td><img src='../../../../cortes/p.gif' width='10' height='1' border='0'></td>
								<? for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
							$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
							$id_peri[$countP] = $filaPeriodo['id_periodo']; 						
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE")  $per="1 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE")  $per="3 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE")  $regimen="trimestre";
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE")   $per="1 Sem.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE")  $per="2 Sem.";
							?>
                            
							<td align="center" class="subitem"><?php echo $per ?></td>
						<?php }?>
                        <?  
								} ?>
            <tr>
              <td colspan="1" align="<?=$alig;?>" width="90%" ><span class="item"><strong><img src="../../../../cortes/p.gif" width="10" height="10" border="0">
                
                
                <?
										
											echo $row_sub['glosa'];
										?>
                              </strong> </span></td>
                             <? for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
							$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
							$id_peri[$countP] = $filaPeriodo['id_periodo']; 
								 ?>	
                                 <td align="center" nowrap class="subitem">
                                  <? // Conceptos subareas
									   if($nuevo==1){
											if ($_INSTIT==2278){
											     $tabla_informe = 'informe_evaluacion2_new';
												 
											}else{
											     $tabla_informe = 'informe_evaluacion2';											
											}
											
											
											 $query_respuesta="select * from $tabla_informe where id_ano='$_ANO' and id_periodo='$id_peri[$countP]' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";
											$result_respuesta=pg_exec($conn,$query_respuesta);
											$num_respuesta=pg_numrows($result_respuesta);
									   }
									   if ($num_respuesta>0){
											$row_respuesta=pg_fetch_array($result_respuesta);
											if ($row_respuesta[concepto]==1){
												$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
												$result_con=pg_exec($conn,$query_con);
												$num_con=pg_numrows($result_con);
												if ($num_con>0){
													$row_con=pg_fetch_array($result_con);
													
													echo $row_con[sigla];
												}
											}else{
													echo $row_respuesta[respuesta];
											}

									   }else{
									        
											echo "&nbsp;";
									   }
                                 ?>
                                 </td>
                                 <?php }?>	
                                 </tr>
                                 
									 <?	// Items
							$ob_reporte ->plantilla = $plantilla;
							$ob_reporte ->id_padre=$row_sub[id_item];
							//$ob_reporte ->id_subarea = $row_sub['id_subarea'];
							$result_item= $ob_reporte->InformeItemPeiAno($conn);
							$num_item=pg_numrows($result_item);?>
            <? for ($z=0;$z<$num_item;$z++){
					$row_item=pg_fetch_array($result_item);	
					$id_item = $row_item['id_item'];?>
                     <?php if ($row_item['salto_pagina']==1){	?>
                                     </table>
                                  <H1 class=SaltoDePagina></H1>
                                   <table width="650" border="1" align="center" cellpadding="<?=$txtFILAS;?>" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse">
                                    <tr><td><img src='../../../../cortes/p.gif' width='10' height='1' border='0'></td>
								<? for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
							$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
							$id_peri[$countP] = $filaPeriodo['id_periodo']; 						
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE")  $per="1 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE")  $per="3 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE")  $regimen="trimestre";
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE")   $per="1 Sem.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE")  $per="2 Sem.";
							?>
                            
							<td align="center" class="subitem"><?php echo $per ?></td>
						<?php }?>
                        <?  
								} ?>
                     <tr >
              <td class="subitem" width="600"><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">&nbsp;&nbsp;&nbsp;&nbsp;
                <? echo $row_item['glosa'];?>  </td>
                <? for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
							$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
							$id_peri[$countP] = $filaPeriodo['id_periodo']; ?>
                            <td align="center" class="subitem">
                             
                              <? 	//Conceptos Items
									$ob_reporte ->nuevo =$nuevo;
									$ob_reporte ->ano = $ano;
									$ob_reporte ->periodo = $id_peri[$countP];
									$ob_reporte ->plantilla = $plantilla;
									$ob_reporte ->id_item = $row_item[id_item];
									$ob_reporte ->alumno = $alumno;
									//echo "r.".$row_item[id_item];
									$result_respuesta= $ob_reporte ->InformeConceptoPei($conn);
									$num_respuesta=pg_numrows($result_respuesta);
									if($num_respuesta>0){
										$row_respuesta=pg_fetch_array($result_respuesta);
										if ($row_respuesta['evaluado']==1){
											$ob_reporte ->respuesta = $row_respuesta['respuesta'];
											$result_con =$ob_reporte ->InformeEvaluacionPei($conn);
											$num_con=pg_numrows($result_con);
											if ($num_con>0){
												$row_con=pg_fetch_array($result_con);
												
												if ($evaluacion=="1"){												
													 echo $row_con['sigla'];
 												}else{												
													 echo $row_con['nombre'];
												}
											}
										}else{
											echo "-";
										}
									}?>
                             
                            
                            </td>
                            <?php }?>
                            </tr>	
                    <?php } // fin item?>  									  
						 		   
                                       <?php  
									   }// fin subarea ?>
                                           
                    
 </table>
<?php } //cat?>
<br>

  <!--/// FECHA DEL INFORME //// -->
      <? 
	  $sql_con ="SELECT * FROM configuracion_reporte WHERE rdb=".$institucion." AND id_item=".$reporte." ";
	
	  $fecha1= date("d-m-Y");
	  $fecha=fecha_espanol($txtFECHA);
	?>
     <!-- <table width="650"  border="0" cellpadding="0" cellspacing="0" align="center">
    <tr> 
      <td >
        <font size="1" face="Arial, Helvetica, sans-serif">
          
         <?php $fecha = date("d-m-Y");
           echo  $ob_membrete->comuna.",".fecha_espanol_min($fecha); ?> </font></td>
        </tr> 
    </table>-->
	     
	  <br>
      <? if ($obs==0){?>
		  	<table width="650" border="1" align="center" class="subitem" style="border-collapse:collapse">
  
  <tr>
  <td align="center">ESTADO DE AVANCE CUALITATIVO</td></tr>
  <?
      for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
							$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
							$id_peri[$countP] = $filaPeriodo['id_periodo']; 						
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE")  $per="1 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE")  $per="3 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE")  $regimen="trimestre";
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE")   $per="1 Sem.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE")  $per="2 Sem.";
							?>
                           <?php  $ob_reporte ->plantilla = $filaPlantilla['id_plantilla'];
										$ob_reporte ->periodo = $filaPeriodo['id_periodo'];
										$ob_reporte ->ano =$_ANO;
										$ob_reporte ->alumno = $alumno;
										$resultDes= $ob_reporte ->InformeObservacionesPei($conn);
					
									
										  $filaDes=@pg_fetch_array($resultDes, $countDes);
										  $observaciones = $filaDes['observaciones'];
										  $sugerencias = $filaDes['sedestaca'];
									?>
							
  
  <tr>
    <td><?php echo $filaPeriodo['nombre_periodo'] ?></td>
    </tr>
  <tr>
    <td>OBSERVACIONES</td>
    </tr>
  <tr>
    <td><?php echo $observaciones ?></td>
    </tr>
  <tr>
    <td>SUGERENCIAS</td>
    </tr>
  <tr>
    <td><?php echo $sugerencias ?></td>
    </tr>


						<?php } // fin sugerencias ?></table>

                        <?php }?>
 <br>

	    
	  	  
	

          </tr>
        </table>

<!--escala abajo-->
 <? if($escala==1 ){ ?>
 <table width="650" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr> 
          <td align="left"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">ESCALA DE EVALUACI&Oacute;N / AREAS DE DESARROLLO</font></td>
	    </tr>
      </table>
		    
		  <table width="650" cellpadding="0" cellspacing="0" border="0" align="center">	
		    <?php 
			
				$sqlConc="SELECT * FROM  pei_concepto where id_plantilla=".$filaPlantilla['id_plantilla']." order by id_concepto asc";
				
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);
					?>
		    
		    <tr>
		      <td width="37%" align=left><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8"><? echo  $filaConc['nombre']; ?> (<? echo $filaConc['sigla']; ?>) </font></td>
					     <td width="4%" align=left><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8">:</font></td>
					     <td width="59%" align=left><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8"><? echo $filaConc['glosa']; ?></font></td>
		    </tr>
		    
		    <? 
			  }	?>
		    
	    </table>
        <? } ?>
<!--fin escala abajo-->
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("firmas/firmas.php");
		?>  


 <table width="650"  border="0" cellpadding="0" cellspacing="0" align="center">
    <tr> 
      <td >
        <font size="1" face="Arial, Helvetica, sans-serif">
          
         <?php $fecha = date("d-m-Y");
           echo  $ob_membrete->comuna.",".fecha_espanol_min($fecha); ?> </font></td>
        </tr> 
    </table>
        
</td>
</tr>
</table> 


 <br>
                
  <? if ($cont_alumnos > 1){  ?>
      <H1 class=SaltoDePagina></H1>
      <? } ?>                    
                    
                    
<?php } //fin alumnos?>

</body>
</html>
