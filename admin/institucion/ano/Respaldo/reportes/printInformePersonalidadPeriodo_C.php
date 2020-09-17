<?php 

require('../../../../util/header.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');


	$c_alumno	= $cmb_alumno;
	$ano		= $_ANO;
	$curso		= $cmb_curso;
	$alumno		= $cmb_alumno;
	$institucion= $_INSTIT;
	$periodo	= $periodo;
	$reporte	= $c_reporte;
	$contador_salto=0;

	//$fecha = strftime("%d %m %Y");
	
	$fecha = $txtFECHA;
	$_POSP = 5;
	$_bot = 8;
	if ($cmb_ano){
		$ano=$cmb_ano;
		$_ANO=$ano;
		if(!session_is_registered('_ANO')){ 
			session_register('_ANO');
		}
		$curso=0;	
	}
		
	if ($cmb_curso){
		$curso=$cmb_curso;
		$_CURSO=$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		}
	}
	
	if ($cb_ok){
		$ob_membrete = new Membrete();
		$ob_membrete->institucion = $institucion;
		$rs_instit = $ob_membrete->institucion($conn);
		
		$ob_membrete->ano = $ano;
		$rs_ano = $ob_membrete->AnoEscolar($conn);
		
		$ob_membrete->periodo = $periodo;
		$rs_periodo = $ob_membrete->periodo($conn);
		
		$ob_membrete->curso = $curso;
		$rs_curso = $ob_membrete->curso($conn);
	
		$Curso_pal = CursoPalabra($curso, 4, $conn);
		
		if($ob_membrete->grado_curso==1) $gr="pa";
		if($ob_membrete->grado_curso==2) $gr="sa";
		if($ob_membrete->grado_curso==3) $gr="ta";
		if($ob_membrete->grado_curso==4) $gr="cu";
		if($ob_membrete->grado_curso==5) $gr="qu";
		if($ob_membrete->grado_curso==6) $gr="sx";
		if($ob_membrete->grado_curso==7) $gr="sp";
		if($ob_membrete->grado_curso==8) $gr="oc";
		
		$ob_reporte = new Reporte();
		$ob_reporte->ensenanza = $ob_membrete->cod_ensenanza;
		$ob_reporte->institucion=$institucion;
		$ob_reporte->grado = $gr;
		$resultPlantilla = $ob_reporte->InformePlantilla($conn);
		$filaPlantilla=@pg_fetch_array($resultPlantilla);
		$plantilla=$filaPlantilla[id_plantilla];
		$nuevo_sis=$filaPlantilla[nuevo_sis];
	}
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	

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
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" type="text/javascript">
<!--
function enviapag(form){
	if (form.cmb_curso.value!=0){
		form.cmb_curso.target="self";
		form.action = 'rpt19.php?institucion=$institucion';
		form.submit(true);

		}	
	}
//-->
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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


//-->
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="window.print();"><!---->
<!-- <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">-->
	<!--<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="0%" height="722" align="left" valign="top" bgcolor="f7f7f7"> 
              -->
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		 <!-- <table width="100%" height="1" border="0" cellpadding="0" cellspacing="0">
              
              <tr align="left" valign="top"> 
                <td height="1038">-->
					<!--<table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                     
                      <td width="73%" align="left" valign="top">-->
					  <table align="center">

<? //if ($cb_ok){?>
	<tr>
		<td>
		
		</td>
	</tr>  
<? //}?>					
<? //if ($cb_ok){
 	if ($c_alumno==0){
		$ob_reporte->ano=$ano;
		$ob_reporte->curso=$curso;
		$result_alu= $ob_reporte->TraeTodosAlumnos($conn);
	}else{
		$ob_reporte->ano=$ano;
		$ob_reporte->curso=$curso;
		$ob_reporte->alumno=$alumno;
		$result_alu =$ob_reporte->TraeUnAlumno($conn);
	}
	$cont_alumnos = pg_numrows($result_alu);

	for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
	{
		$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
		$ob_reporte->CambiaDato($fila_alu);
		$alumno = $ob_reporte->alumno;
		$titulo2 = $filaPlantilla['titulo_informe2'];

?>

<tr><td>



<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
				<table width="190" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td align="center"><?
						if($institucion!=""){
							if($institucion==12086 && $ob_membrete->cod_ensenanza==10){
								echo "<img src='".$d."tmp/".$institucion."insignia2". "' >";
							}else{ 
							   echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
							}
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?>
						</td>
					  </tr>
					
					<tr>
					   <td>
					   <? if($institucion!=24977){?>
						   <table align="center">
							   <!--<tr><td class="subitem"><?=$ob_membrete->ins_pal;?></td></tr>-->
								<tr><td class="subitem"><?=$ob_membrete->direccion;?></td></tr>
								<tr>
								  <td class="subitem">Fono: <?=$ob_membrete->telefono;?> <br> 
							      Fax: <?=$ob_membrete->fax;?></td>
								</tr>
						   </table>
						   <? } ?>
						</td>
					</tr>
				</table>
			
		</td>
		<td>
		<td><img src='linea_v.jpg'></td>
		<td>
			<table width="440" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr><td colspan="3" class="titulo" align="center">&nbsp;<strong><? echo $titulo2;?></strong></td></tr>
				<tr><td colspan="3"><hr color="#660000"></td></tr>
				<tr>
					<td class="subitem">&nbsp;A&ntilde;o Escolar</td>
					<td class="subitem">Período</td>	
					<td class="subitem">RBD</td>										
				</tr>
				<tr>
					<td class="subitem">&nbsp;<?=$ob_membrete->nro_ano;?></td>
					<td class="subitem"><? if ($_INSTIT=="1436"){ ?>Anual <? }else{ ?><?=$ob_membrete->nombre_periodo;?><? } ?></td>
					<td class="subitem"><?php echo $institucion."-".$ob_membrete->dig_rdb;?></td>										
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr>
					<td colspan="3" class= "subitem" >Nombre Alumno(a)</td>
				</tr>												
				<tr>
					<td colspan="3" class="subitem">&nbsp;<?php echo strtoupper($ob_reporte->tildeM($ob_reporte->nombres));?></td>
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td class="subitem" colspan="3">Curso</td>
				</tr>												
				<tr>
					<td class="subitem" colspan="3"> <?php echo $Curso_pal; ?></td>										
				</tr>																
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="4">
	<? if($ckEVALUACION==1 and $ckPOSICION==1){?>
			<table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="4" class="subitem">ESCALA DE EVALUACI&Oacute;N:</td>
				</tr>
				<tr>
			<? 	$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);	?>
					<td class="subitem"><? echo $filaConc['sigla'];?>:</td>
					<td align="left" class="subitem"><? echo $filaConc['nombre'];?></td>
					<td></td>
			<?	}	?>
				</tr>
			</table>
	<? } ?>
		</td>
	</tr>
<!--	<tr>
		<td colspan="4"></td>
	</tr>-->
	<tr>
		<td colspan="4">
			<table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td>
<!-- desde aki -->
<?					if ($nuevo_sis==1){  ?>
&nbsp;
					<table width="630" align="center"><tr><td valign="top">
					
						
						<?
						$contador=0;
						$ob_informe = new Reporte();
						$ob_informe->nuevo=1;
						$ob_informe->plantilla=$plantilla;
						$result_cat= $ob_informe->InformeAreas($conn);
						$num_cat=pg_numrows($result_cat);
						for ($i=0;$i<$num_cat;$i++){
							$row_cat=pg_fetch_array($result_cat);	?>
						<table width="630" align="center" border="0" cellpadding="0" cellspacing="0" >
							<tr>
							  <td width="630" colspan="2" align="center"  class="item"><strong><br>
						      <? echo $row_cat['glosa'];?></strong></td>
							</tr>
						</table>
						
						
						<table width="630" align="center" border="1" cellpadding="<?=$txtFILAS;?>" cellspacing="0" style="border-collapse:collapse">	
                        <? 	$ob_informe->id_padre=$row_cat[id];
							$ob_informe->nuevo=1;
							$result_sub=$ob_informe->InformeSubarea($conn);
							$num_sub=pg_numrows($result_sub);
							for ($j=0;$j<$num_sub;$j++){
								$row_sub=pg_fetch_array($result_sub);	?>
								<tr class="tabla04">
									<td colspan="2" valign="top"><span class="subitem"><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">
										<? echo $row_sub['glosa'];?></span>
									          <span class="subitem">
									</span></td>
									<td><span class="subitem">		  
										<?	$ob_informe->ano=$ano;
											$ob_informe->periodo=$periodo;
											$ob_informe->plantilla=$plantilla;
											$ob_informe->id_item=$row_sub[id];
											$ob_informe->alumno=$alumno;
											$result_respuesta=$ob_informe->InformeConcepto($conn);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												if ($row_respuesta[concepto]==1){
													$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
													$result_con=pg_exec($conn,$query_con);
													$num_con=pg_numrows($result_con);
													if ($num_con>0){
														$row_con=pg_fetch_array($result_con);
														echo "&nbsp;".$row_con[sigla];
													}
												}else{
													echo "&nbsp;".$row_respuesta[respuesta];
												}
											}		?>
									    </span></td>
	                       	  	</tr>
									<?	
									// orden de los elementos
									
									if ($plantilla==1322 or $plantilla==1104 or $plantilla==1101 ){
									    $orden_elementos = " order by id";
									}else{
									    $orden_elementos = " ";									
									}
									
									$query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id] ORDER BY id ASC ";
										$result_item=pg_exec($conn,$query_item);
										$num_item=pg_numrows($result_item);
										//$contador_salto=0;
										for ($z=0;$z<$num_item;$z++){
											$row_item=pg_fetch_array($result_item);	?>
											<tr>
												<td width="550" class="subitem"><img src="../../../../../cortes/p.gif" width="20" height="8" border="0"><? echo $row_item['glosa'];?></td>
												<td width="80" nowrap class="subitem">
												<?	$ob_informe->ano=$ano;
													$ob_informe->nuevo=1;
													$ob_informe->periodo=$periodo;
													$ob_informe->plantilla=$plantilla;
													$ob_informe->id_item=$row_item[id];
													$ob_informe->alumno=$alumno;
													$result_respuesta=$ob_informe->InformeConcepto($conn);
													$num_respuesta=pg_numrows($result_respuesta);
														if ($num_respuesta>0){
															$row_respuesta=pg_fetch_array($result_respuesta);
															if ($row_respuesta[concepto]==1){
																$ob_informe->respuesta=$row_respuesta[respuesta];
																$result_con= $ob_informe->InformeEvaluacion($conn);
																$num_con=pg_numrows($result_con);
																if ($num_con>0){
																	$row_con=pg_fetch_array($result_con);
																 	if($ckCONCEPTO==1){
																	 	echo "&nbsp;".$row_con[nombre];
																	}else{
																		echo "&nbsp;".$row_con[sigla];
																	}
																}
															}else{
																echo "&nbsp;".$row_respuesta[respuesta];
																
															}
														}	
														$contador_salto++;?>
											  </td>
                          </tr>
<?												
											/*	maloooo todos reclaman, nadie sabe cuantas lineas tiene su informe, mala idea

												if(($contador_salto % $txtSALTO)==0){
												?></table><?
													echo "<H1 class=SaltoDePagina></H1>";
												?><table width="630" align="center" border="0" cellpadding="<?=$txtFILAS;?>" cellspacing="0" style="border-collapse:collapse">
													<tr><td></td></tr><?	
												}
											*/
													}?>
<? 											}?>
<? 										}	// fin if modificar?>
                        </table>					
							
								
									</td>
								</tr>
								<tr>
									<td>
									
					<!--<H1 class=SaltoDePagina></H1> -->
                                     <?	if ($ckDESTACA==1){  
										$ob_reporte ->plantilla = $filaPlantilla['id_plantilla'];
										$ob_reporte ->periodo = $periodo;
										$ob_reporte ->ano =$_ANO;
										$ob_reporte ->alumno = $alumno;
										$resultObs= $ob_reporte ->InformeObservaciones($conn);
					
									 for($countObs=0; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
										  $filaObs=@pg_fetch_array($resultObs, $countObs);
										  $sedestaca = $filaObs['sedestaca'];
									 }
							  ?>							
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td width="20%" class="tabla04"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Se destaca en:</font></td>
										<td width="80%" class="tablatit2_1"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;<?=$sedestaca ?></font></td>
									 </tr>
								   </table>									
							  <? } ?>  
								  <? if($ckOBS==1){?>
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
									  <tr>
										<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; Observaciones:</font></td>
									  </tr>
									</table>
									
									<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
				            		<? 	$ob_informe->pantilla=$plantilla;
										$ob_informe->ano=$ano;
										$ob_informe->alumno=$alumno;
										$resultObs= $ob_informe->InformeObservaciones($conn);
									for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
										$filaObs=@pg_fetch_array($resultObs, $countObs);	?>
										<tr>
											<td width="19%"><span class="Estilo2"><font size="1" face="Arial, Helvetica, sans-serif">
		                                         <? if ($_INSTIT=="1436"){ ?>ANUAL <? }else{ ?><?	echo $filaObs['nombre_periodo']; ?><? } ?>
											</span></td>
											<td class="subitem">
											<?	echo $filaObs['observaciones'];	?>	
											&nbsp;</td>
										</tr>
									<?	} ?>
									</table>
									<? } //---------- FIN OBSERVACIONES ******************?>
									
									<? /********************** ESCALA DE EVALUACION *******************/
										if($ckEVALUACION==1 and $ckPOSICION==0){?>
											<table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
												<tr>
													<td colspan="4" class="subitem">ESCALA DE EVALUACI&Oacute;N:</td>
												</tr>
												<tr>
											<? 	$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
												$resultConc=@pg_Exec($conn, $sqlConc);
												for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
													$filaConc=@pg_fetch_array($resultConc,$countConc);	?>
													<td class="subitem"><? echo $filaConc['sigla'];?>:</td>
													<td align="left" class="subitem"><? echo $filaConc['nombre'];?></td>
													<td></td>
											<?	}	?>
												</tr>
											</table>
									<? } 
									/************************ FIN ESCALA DE EVALUACIO ******************/
									?>
									<? for($i=0;$i<=$txtFIRMA;$i++){ ?>
										<br>
									<? 	} ?>
                                    
									<table width="650" border="0" align="center">
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
											$ob_reporte->Firmas($conn);?>
                                        <td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000">
                                            <div align="center">
                                              <?
											  if ($chcargo!=1){
											  echo $ob_reporte->nombre_emp;
                                              echo "<br>";
											  }?>
                                              <?=$ob_reporte->nombre_cargo;?>
                                          </div></td>
                                        <? } ?>
                                        <? if($ob_config->firma2!=0){
												$ob_reporte->cargo=$ob_config->firma2;
												$ob_reporte->empleado=$ob_config->empleado2;
												$ob_reporte->curso=$curso;
												$ob_reporte->rdb=$institucion;
												$ob_reporte->Firmas($conn);?>
                                        <td width="25%" class="item"><hr align="center" width="150" color="#000000">
                                            <div align="center">
                                              <? if ($chcargo!=1){
											  echo $ob_reporte->nombre_emp;
                                              echo "<br>";
											  }?>
                                              <?=$ob_reporte->nombre_cargo;?>
                                          </div></td>
                                        <? } ?>
                                        <? if($ob_config->firma3!=0){
												$ob_reporte->cargo=$ob_config->firma3;
												$ob_reporte->empleado=$ob_config->empleado3;
												$ob_reporte->curso=$curso;
												$ob_reporte->rdb=$institucion;
												$ob_reporte->Firmas($conn);?>
                                        <td width="25%" class="item"><hr align="center" width="150" color="#000000">
                                            <div align="center">
                                              <? if (chcargo!=1){
											  echo $ob_reporte->nombre_emp;
                                              echo "<br>";
											  }?>
                                              <?=$ob_reporte->nombre_cargo;?>
                                          </div></td>
                                        <? } ?>
                                        <? if($ob_config->firma4!=0){
												$ob_reporte->cargo=$ob_config->firma4;
												$ob_reporte->empleado=$ob_config->empleado4;
												$ob_reporte->curso=$curso;
												$ob_reporte->rdb=$institucion;
												$ob_reporte->Firmas($conn);?>
                                        <td width="25%" class="item"><hr align="center" width="150" color="#000000">
                                            <div align="center">
                                              <? if (chcargo!=1){
											  echo $ob_reporte->nombre_emp;
                                              echo "<br>";
											  }?>
                                              <?=$ob_reporte->nombre_cargo;?>
                                          </div></td>
                                        <? }?>
                                      </tr>
                                    </table>
								   </td>
								</tr>
								<tr>
									<td class="subitem"><? echo $ob_membrete->comuna.",".fecha_espanol($fecha);?></td>
								</tr>
					  </table>
						<H1 class=SaltoDePagina></H1>
						<?	} // fin if nuevo sistema	
							if ($nuevo_sis!=1){	?>
							<table width="630" border=0 cellpadding="0" cellspacing="0">
								<tr valign="top">
									<td>
										<table width="630" border="1" cellpadding="<?=$txtFILAS;?>" cellspacing="0">
							<?				$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
											$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
												//trae areas
											$ob_reporte = new Reporte();
											$ob_reporte->nuevo=0;
											$ob_reporte->plantilla=$filaPlantilla['id_plantilla'];
											$resultTraeArea=$ob_reporte->InformeAreas($conn);
										
											for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
												$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
												$nroA=$countArea+1;		?>
												<tr><td><font face=Arial, Helvetica, sans-serif></font></td></tr>
												<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif><strong><? echo $nroA.".-  ".$filaTraeArea['nombre'];?></strong></font></td>
<?												if($countArea==0){	?>												
													<td><font size=1 face=Arial, Helvetica, sans-serif><strong>EVALUACI&Oacute;N</strong></font></td>												
					<?							}else{	?>
													<td>&nbsp;&nbsp;</td>
<?												}
												//trae subareas para cada area y las imprime
												$ob_reporte->id_area=$filaTraeArea['id_area'];
												$resultTraeSubarea=$ob_reporte->InformeSubarea($conn);

												for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
												$nroS=$countSubarea+1;
												$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);	?>
												<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong><? echo $nroA.".".$nroS.".-  ".$filaTraeSubarea['nombre'];?></strong></font></td></tr>
			<?									//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
												$ob_reporte->id_subarea=$filaTraeSubarea['id_subarea'];
												$resultTraeItem=$ob_reporte->InformeItem($conn);
												
												for($countItem=0 ; $countItem<@pg_numrows($resultTraeItem) ; $countItem++){
													$countI++;
													$filaTraeItem=@pg_fetch_array($resultTraeItem, $countItem);
													//PRIMERO TENGO QUE PREGUNTAR SI EL ITEM SE EVALUA CON CONCEPTOS, SI/NO(RADIO), TEXTO
													if($countItem%2==0){
														$color="#CDCDCD";
													}else{
														$color="#B5B5B5";
													}	?>
													<tr><td valign=bottom>
			<?										$nroI=$countItem+1;		?>
													<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;<? echo $nroA.".".$nroS.".".$nroI.".-  ".trim($filaTraeItem['glosa']);?></font>
													</td>
<?													if($filaTraeItem['tipo']==0){
														$sqlP="select * from periodo where id_periodo=".$periodo;
														$resultP=@pg_Exec($conn, $sqlP);
														for($countEval=0 ; $countEval<pg_numrows($resultP) ; $countEval++){
															$filaP=@pg_fetch_array($resultP,$countEval);
															$ob_reporte->ano=$ano;
															$ob_reporte->periodo=$filaP['id_periodo'];
															$ob_reporte->alumno=$alumno;
															$ob_reporte->id_item=$filaTraeItem['id_item'];
															$resultEval=$ob_reporte->InformeConcepto($conn);
															$filaEval=@pg_fetch_array($resultEval,0);
															$ob_reporte->respuesta=$filaEval['id_concepto'];
															$resultConc=$ob_reporte->InformeEvaluacion($conn);
															$filaConc=@pg_fetch_array($resultConc,0);
															if($ckCONCEPTO==0){	?>
																<td valign=bottom>&nbsp;&nbsp;
																<font size=1 face=Arial, Helvetica, sans-serif><? echo trim($filaConc['sigla']);?></font></td>
	<?														}else{	?>
																<td valign=bottom>&nbsp;&nbsp;
																<font size=1 face=Arial, Helvetica, sans-serif><? echo trim($filaConc['nombre']); ?></font></td>
<?															}
														}
													}else if($filaTraeItem['tipo']==2){
														$ob_reporte->ano=$ano;
														$ob_reporte->periodo=$filaP['id_periodo'];
														$ob_reporte->alumno=$alumno;
														$ob_reporte->id_item=$filaTraeItem['id_item'];
														$resultEvalu=$ob_reporte->InformeConcepto($conn);
													
														for($countEvalu=0 ; $countEvalu<pg_numrows($resultEvalu) ; $countEvalu++){
															$filaEvalu=pg_fetch_array($resultEvalu,$countEvalu);	?>
												  <tr><td valign=bottom>
															<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalu['nombre_periodo'].":&nbsp;&nbsp".$filaEvalu['text'];?></td></tr>
															<tr><td bgcolor="#0099FF" ></td></tr>
<?														}
													}else if($filaTraeItem['tipo']==1){
														$ob_reporte->ano=$ano;
														$ob_reporte->periodo=$filaP['id_periodo'];
														$ob_reporte->alumno=$alumno;
														$ob_reporte->id_item=$filaTraeItem['id_item'];
														$resultEvalua=$ob_reporte->InformeConcepto($conn);
														
														for($countEvalua=0 ; $countEvalua<pg_numrows($resultEvalua) ; $countEvalua++){
															$filaEvalua=@pg_fetch_array($resultEvalua,$countEvalua);
															if(($filaEvalua['radio']==0) and ($filaEvalua['radio']!="")){	?>
																	<tr><td valign=bottom>
																	<font size=1 face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalua['nombre_periodo'];?>:&nbsp;&nbsp;No</font></td></tr>	
																	<tr><td bgcolor="#0099FF" ></td></tr>
<?															}else if($filaEvalua['radio']==1){	?>
																	<tr><td valign=bottom>
																	<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalua['nombre_periodo'];?>:&nbsp;&nbsp;Si</font></td></tr>
																	<tr><td bgcolor="#0099FF"></td></tr>
<?															}
														}
													}
												}//fin for($countItem....
											}//fin for($countSubarea....
										}//fin for($countArea....			  ?>
										<input name="plantilla" type="hidden" value="<?php echo $filaPlantilla['id_plantilla']?>">
										<input name="alumno" type="hidden" value="<?php echo $alumno?>">
                                        </table>
<?										/*if($institucion!=25218  && $institucion!=14629 && $institucion!=24977 && $institucion!=25478 && $institucion!=12086 && $institucion!=24464 && $institucion!=22380 && $institucion!=25768  && $institucion!=9035 && $institucion!=1707 && $institucion!=9276 && $institucion!=8905 && $institucion!=318 ){ 	?>
											<H1 class=SaltoDePagina></H1>
                                            <p></p>
                                              <?										} ?>*/
											  
											if ($ckDESTACA==1){  
										$ob_reporte ->plantilla = $filaPlantilla['id_plantilla'];
										$ob_reporte ->ano =$_ANO;
										$ob_reporte ->alumno = $alumno;
										$resultObs= $ob_reporte ->InformeObservaciones($conn);
					
									 for($countObs=0; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
										  $filaObs=@pg_fetch_array($resultObs, $countObs);
										  $sedestaca = $filaObs['sedestaca'];
									 }
							  ?>							
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td width="20%" class="tabla04"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Se destaca en:</font></td>
										<td width="80%" class="tablatit2_1"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;<?=$sedestaca ?></font></td>
									 </tr>
								   </table>									
							  <? } ?>  
                                           <!-- <p>&nbsp;</p>-->
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
										  <tr>
											<td><font size="1" face="Arial, Helvetica, sans-serif">Observaciones:</font></td>
										  </tr>
										</table>
										
                                        <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0">
					<?					$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_periodo=".$periodo." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
										$resultObs=@pg_Exec($conn, $sqlTraeObs);
										for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
											$filaObs=@pg_fetch_array($resultObs, $countObs);	?>
											<tr>
												<td width="19%"><font size="1" face="Arial, Helvetica, sans-serif">
	                                             <? if ($_INSTIT=="1436"){ ?>ANUAL <? }else{ ?><?	echo $filaObs['nombre_periodo']; ?><? } ?>
												</td>
												<td><font size="1" face="Arial, Helvetica, sans-serif">
	<?												echo $filaObs['glosa'];	?>&nbsp;</font>
												</td>
											</tr>
<?										}	?>
										</table>
										
										
                                        <table width="100%" border="0">
<?										if($institucion!=25218 && $institucion!=14629 && $institucion!=25478 && $institucion!=24977 && $institucion!=22380 ){?>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td></td>
											</tr>
                              <?		}	?>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td align="right"><font size="2" face="Arial, Helvetica, sans-serif">
												<input type="hidden" name="fecha">
												<input type="hidden" name="tipoEns" value="<?php echo $tipoEns ?>">
												<input type="hidden" name="grado" value="<?php echo $grado ?>">
												</font></td>
											</tr>
										</table>
									<!--AQUI VAN LAS FIRMAS-->
									<? for($i=0;$i<=$txtFIRMA;$i++){ ?>
										<br>
									<? 	} ?>
                                    
									<table width="650" border="0" align="center">
                                      <tr>
                                        <? if(!$cb_ok=="Buscar"){?>
                                        <td>&nbsp;</td>
                                        <? }?>
                                        <?  
										if($ob_config->firma1!=0){
											$ob_reporte->cargo=$ob_config->firma1;
											$ob_reporte->empleado=$ob_config->empleado1;
											$ob_reporte->rdb=$institucion;
											$ob_reporte->curso=$curso;
											$ob_reporte->Firmas($conn);?>
                                        <td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000">
                                            <div align="center">
                                              <? if ($chcargo!=1){
											  echo $ob_reporte->nombre_emp;
                                              echo "<br>";
											  }?>
                                              <?=$ob_reporte->nombre_cargo;?>
                                          </div></td>
                                        <? } ?>
                                        <? if($ob_config->firma2!=0){
												$ob_reporte->cargo=$ob_config->firma2;
												$ob_reporte->empleado=$ob_config->empleado2;
												$ob_reporte->curso=$curso;
												$ob_reporte->rdb=$institucion;
												$ob_reporte->Firmas($conn);?>
                                        <td width="25%" class="item"><hr align="center" width="150" color="#000000">
                                            <div align="center">
                                              <? if ($chcargo!=1){
											  echo $ob_reporte->nombre_emp;
                                              echo "<br>";
											  }?>
                                              <?=$ob_reporte->nombre_cargo;?>
                                          </div></td>
                                        <? } ?>
                                        <? if($ob_config->firma3!=0){
												$ob_reporte->cargo=$ob_config->firma3;
												$ob_reporte->empleado=$ob_config->empleado3;
												$ob_reporte->curso=$curso;
												$ob_reporte->rdb=$institucion;
												$ob_reporte->Firmas($conn);?>
                                        <td width="25%" class="item"><hr align="center" width="150" color="#000000">
                                            <div align="center">
                                              <? if ($chcargo!=1){
											  echo $ob_reporte->nombre_emp;
                                              echo "<br>";
											  }?>
                                              <?=$ob_reporte->nombre_cargo;?>
                                          </div></td>
                                        <? } ?>
                                        <? if($ob_config->firma4!=0){
												$ob_reporte->cargo=$ob_config->firma4;
												$ob_reporte->empleado=$ob_config->empleado4;
												$ob_reporte->curso=$curso;
												$ob_reporte->rdb=$institucion;
												$ob_reporte->Firmas($conn);?>
                                        <td width="25%" class="item"><hr align="center" width="150" color="#000000">
                                            <div align="center">
                                              <? if ($chcargo!=1){
											 echo $ob_reporte->nombre_emp;
                                              echo "<br>";
											  }?>
                                              <?=$ob_reporte->nombre_cargo;?>
                                          </div></td>
                                        <? }?>
                                      </tr>
                                    </table>
																		
                              <tr>
											<td class="subitem"><? echo $ob_membrete->comuna.",".fecha_espanol($fecha);?></td>
							  </tr>
							
                      </table>
							<? }?>

							<? if (($institucion==25478) || ($institucion==24977) || ($institucion==25218) || ($institucion==14629 || $institucion!=1707)) {  ?>
									<H1 class=SaltoDePagina></H1>
									<? } ?>
									
									
<!-- hasta aki -->					
				  </td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</td>
</tr>
<?		}	?>
<?	//}	?>

						
						</table>
					<!--  </td>
					  </tr>
				  </table>-->
			<!--	</td>
			  </tr>
			</table>-->
		 <!-- </td>
		</tr>
	  </table>-->
<!--	</td>
   </tr>
</table>-->

</body>
</html>
