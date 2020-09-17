<?
require('../../../../util/header.inc');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');

$ano		= $_ANO;
$curso		= $cmb_curso;
$alumno		= $cmb_alumno;
$reporte	= $c_reporte;
$institucion= $_INSTIT;
$_POSP = 5;
$_bot = 8;

$ob_reporte = new Reporte();
$ob_membrete = new Membrete();


/************************ INSTITUCION ***********************/
$ob_membrete ->institucion=$institucion;
$ob_membrete ->institucion($conn);

/*********************** ANO ESCOLAR ***********************/
$ob_membrete ->ano = $ano;
$ob_membrete ->AnoEscolar($conn);
$nro_ano = $ob_membrete->nro_ano;

/*******************CURSO ***********************/
$Curso_pal = CursoPalabra($curso, 1, $conn);

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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<body>
<? if ($_PERFIL!=16 AND $_PERFIL!=15 ) {
      
	if ($_INSTIT!=1599){?>   
			  <table width="650" border="0" cellpadding="0" cellspacing="0">
				<tr> 
					<td>           
					<div id="capa0">
					  <input 	name="cmdimprimiroriginal" type="button" class="botonXX" id="cmdimprimiroriginal" onClick="imprimir()" 	value="Imprimir">
					</div> 
					</td>
				</tr>
			  </table>
	<? }
}?>
<?
 	if (empty($cmb_alumno)){
		$ob_reporte ->ano =$ano;
		$ob_reporte ->curso =$curso;
		$ob_reporte ->retirado =$retirado;
		$result_alu =$ob_reporte ->TraeTodosAlumnos($conn);
	}else{
		$ob_reporte ->ano =$ano;
		$ob_reporte ->curso =$curso;
		$ob_reporte ->alumno=$alumno;
		$result_alu =$ob_reporte ->TraeUnAlumno($conn);
	}	
	$cont_alumnos = @pg_numrows($result_alu);

for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++){
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	$ob_reporte ->CambiaDato($fila_alu);
	
	
	$ob_reporte ->alumno =$alumno;
	$ob_reporte ->ano =$ano;
	$resultMatri =$ob_reporte ->MatriculaCurso($conn);
	$filaMatri=@pg_fetch_array($resultMatri,0);
	if($filaMatri['grado_curso']==1) $gr="pa";
	if($filaMatri['grado_curso']==2) $gr="sa";
	if($filaMatri['grado_curso']==3) $gr="ta";
	if($filaMatri['grado_curso']==4) $gr="cu";
	if($filaMatri['grado_curso']==5) $gr="qu";
	if($filaMatri['grado_curso']==6) $gr="sx";
	if($filaMatri['grado_curso']==7) $gr="sp";
	if($filaMatri['grado_curso']==8) $gr="oc";

	$ob_reporte ->ensenanza=$filaMatri['ensenanza'];
	$ob_reporte ->grado= $gr;
	$ob_reporte ->institucion=$institucion;
	$resultPlantilla=$ob_reporte ->InformePlantilla($conn);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);
	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$filaMatri['ensenanza'];
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$titulo1 = $filaPlantilla['titulo_informe1'];
	$nuevo = $filaPlantilla['nuevo_sis'];	

?>  


    <table width="700" border="0">
      <tr>
	<!--CABECERA REPORTE PERSONALIDAD-->
        <td>
		<table width="650" border="0" align="left">
		  <tr> 
			<td valign="top">
					<?	$sql="select * from institucion where rdb=".$institucion;
						$result = pg_Exec($conn,$sql);
						$arr=pg_fetch_array($result,0);
						$fila_foto = pg_fetch_array($result,0);
						if 	(!empty($fila_foto['insignia'])){?>   
					   <table width="100%">
						 <tr>
						 <td width="600">
						 <?	  if ($_INSTIT==770){
								 echo "INFORME DE CRECIMIENTO PERSONAL <BR>";
									if ($filaMatri['ensenanza']==110){
										echo "EDUCACION BASICA <br>";
									}
									if ($filaMatri['ensenanza']==310){
										echo "EDUCACION MEDIA <br>";
									} 	
								 echo "AÑO ESCOLAR $nro_ano";
							   }else{ 				  
								 echo $titulo1;
							   }?>
						  </td>
						  </tr>
						</table>
						<? if($_INSTIT!=770){?>
						<table width="471" border="1" align="center">
							<tr> 
							  <td align="center" class="titulo"><strong>&nbsp;<?php echo $ob_membrete->ins_pal;?><br><? echo "AÑO ESCOLAR ".$nro_ano;?></strong></td>
							</tr>
						</table>
						<table width="471" border="1" align="center">
							<tr valign="middle"> 
							  <td width="23%" align="center" class="item"><strong>Res. 
							Exta. de Educaci&oacute;n N&ordm; <?php echo $ob_membrete->nu_resolucion;?> 
							de fecha 
							<?php impF($ob_membrete->fecha_resol)?>
							Rol Base de Datos <?php echo $institucion," - ",$ob_membrete->dig_rdb?> 
							</strong></td>
							</tr>
						</table>
						<? }?>
			</td>
			 <?		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto = @pg_fetch_array($result,0);
					## código para tomar la insignia
				  if($institucion!=""){
					   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>
			<? }else{?>
			 <td width="100%">
				  <table width="100%" border="1" align="center">
						<tr> 
						  <td align="center" class="titulo">
						  <div align="center">
						  <strong>
					   		<?  if ($_INSTIT==770){
					     			echo "INFORME DE CRECIMIENTO PERSONAL <BR>";
									if ($filaMatri['ensenanza']==110){
										echo "EDUCACION BASICA <br>";
									}
									if ($filaMatri['ensenanza']==310){
										echo "EDUCACION MEDIA <br>";
									} 	
								echo "AÑO ESCOLAR $nro_ano";
						  		}else{ 	
					  	        echo $titulo1;
							 }?>
						  </strong>
						  </div>
						  </td>
						</tr>
				  </table>
				  <? if ($_INSTIT!=770){ ?>
				  <table width="100%" border="1" align="center">
						<tr> 
						  <td align="center">
						  <strong>
							  <font size="2" face="Arial, Helvetica, sans-serif">&nbsp;
								  <?php echo $ob_membrete->ins_pal;?><br><? echo "AÑO ESCOLAR ".$nro_ano;?>
							  </font>
						  </strong>
						  </td>
						</tr>
				  </table>
				  <table width="100%" border="1" align="center">
						<tr valign="middle"> 
						  <td align="center" class="item">
						  <strong>
						  	Res.Exta. de Educaci&oacute;n N&ordm; 
							<?php echo $ob_membrete->nu_resolucion?> 
							de fecha 
							<?php impF($ob_membrete->fecha_resol)?>
							Rol Base de Datos 
							<?php echo $institucion," - ",$ob_membrete->dig_rdb?> 
						  </strong>
						  </td>
						</tr>
				  </table>
				  <? }?>
			  </td>
			 <td>
			 <span class="item">
				  <? $result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
					 $arr=@pg_fetch_array($result,0);
					 $fila_foto = @pg_fetch_array($result,0);
					 ## código para tomar la insignia
					if($institucion!=""){
					 	  echo "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
				  	}else{
						  echo "<img src='".$d."menu/imag/logo.gif' >";
				  	}?>
			 </span>
			 </td>
			 <? }?>
				 </tr>
			   </table>
		</td>
      </tr>
	<!--FIN CABECERA REPORTE PERSONALIDAD-->
      <tr>
	  	<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
		   		<tr>
					<td width="80%">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
				 			<tr> 
				  				<td width="18%" class="item">Alumno(a)</td>
				  				<td width="54%" class="subitem">: <?php echo $ob_reporte->nombres?></td>
								<? if ($_INSTIT!=770){ ?>
								  <td width="6%" class="item">RUT</td>			  
								  <td width="21%"  class="item">: <?php echo $ob_reporte->rut_alumno?></td>
								  <td width="1%" colspan="5">&nbsp;</td>
						  		<? } ?>	  
					  
				 			</tr>
			   			</table>
		  				<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr> 
				  				<td width="20%" class="item">Curso</td>
				  				<td width="80%" class="subitem">: <?php echo $Curso_pal; ?></td>
							</tr>
			  			</table>
		  				<? if($filaMatri['ensenanza']>310 and $_INSTIT!=770){?>
				  		<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr> 
					  			<td width="20%" class="item">Especialidad</td>
					  			<td width="80%" class="subitem">: 
								<?  $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaMatri['cod_es']." and ";
									$sqlTraeEsp.=" cod_sector=".$filaMatri['cod_sector']." and cod_rama=".$filaMatri['cod_rama'];
											$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
											$filaEsp=@pg_fetch_array($resultEsp,0);
											echo $filaEsp['nombre_esp'];?>
								</td>
							</tr>
				  		</table>
		 				<? } ?>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr> 
								<td width="20%" class="item">Profesor Jefe</td>
								<td width="80%" class="subitem">: 
								<? echo $ob_reporte->profe_nombre;?>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
		  				</table>
					 </td>
		 			 <td width="20%" valign="top">&nbsp;
						<!-- <tr>
							<td>
							<? /*if($institucion!=""){
								echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' width='80' height='100' >";
							}else{
								echo "<img src='".$d."menu/imag/logo.gif' >";
							}*/?>
							</td>
						</tr>-->
		  		 	</td>
				</tr>
			</table>
			<table width="650" border="1" align="center" cellpadding="<?=$txtFILAS;?>" cellspacing="0" bordercolor="#CCCCCC">
		    <?	echo "<tr><td><img src='../../../../../cortes/p.gif' width='10' height='1' border='0'></td>";
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
								echo "<td align=\"center\"><font size=1 face=Arial, Helvetica, sans-serif>".$per."</font></td>";
							}
						
						echo "</tr>";
						$plantilla = $filaPlantilla['id_plantilla'];
						$ob_reporte ->nuevo = $nuevo;
						$ob_reporte ->plantilla = $plantilla;
						$result_cat=$ob_reporte ->InformeAreas($conn);
						$num_cat=@pg_numrows($result_cat);
						$jjj = 1;
							
							for ($i=0;$i<$num_cat;$i++)	{	
								$row_cat=pg_fetch_array($result_cat);	?>  
								     <tr>
										<td colspan="4" class="item">
										<?	if ($_INSTIT==770){
										    	echo "$jjj".".- ";
												$jjj++;
										}		
										if($nuevo==1){
												echo $row_cat['glosa'];
										}else{
												echo $row_cat['nombre'];
										}?>
										 </td>                                   
									   </tr>
								 	   
							<?  // Subareas
								$ob_reporte ->nuevo = $nuevo;
								$ob_reporte ->plantilla = $plantilla;
								$ob_reporte ->id_padre = $row_cat[id];
								$ob_reporte ->id_area = $row_cat[id_area];
								$result_sub=$ob_reporte ->InformeSubArea($conn);
								$num_sub=pg_numrows($result_sub);
								for ($j=0;$j<$num_sub;$j++){
								      $row_sub=pg_fetch_array($result_sub);	
									  if ($row_sub['glosa']!=1 and $row_sub['glosa']!=2 and $row_sub['glosa']!=3 and $row_sub['glosa']!=4 and $row_sub['glosa']!=5 and $row_sub['glosa']!=6){
									  ?> 
									 <tr>
                                   	  	<td colspan="1" class="subitem"><img src="../../../../../cortes/p.gif" width="10" height="10" border="0">
									  <? if($nuevo==1){
											echo $row_sub['glosa'];
										 }else{
											echo $row_sub['nombre'];
										 }?>
										</font>											
								       </td>		
									   <td width="1%" nowrap class="subitem">
									   <img src="../../../../../cortes/p.gif" width="10" height="1" border="0">
									   <? // Conceptos subareas
									   		if($nuevo==1){
												$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$id_peri[0]' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";
												$result_respuesta=pg_exec($conn,$query_respuesta);
												$num_respuesta=pg_numrows($result_respuesta);
									   		}
									   		if($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												if($row_respuesta[concepto]==1){
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
									   		}?>
										</td>
									    <td width="1%" nowrap class="subitem"><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">
										<? if($nuevo==1){
		   										$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$id_peri[1]' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";										   
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
								<? 	 
								     if($regimen=="trimestre"){
								        
								     	?>
									    <td width="1%" nowrap><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">
										<? // $id_peri[0]; para 1er Semestre
										   $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$id_peri[2]' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";
											$result_respuesta=pg_exec($conn,$query_respuesta);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												if ($row_respuesta[concepto]==1){
													$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
													$result_con=pg_exec($conn,$query_con);
													$num_con=pg_numrows($result_con);
													if ($num_con>0){
														$row_con=pg_fetch_array($result_con);
														echo $row_con[nombre];
													}
												}else{
													echo $row_respuesta[respuesta];
												}
											}?>	</td>
								<? }?>																		
								   </tr>
								   <? } ?>
						 <?	// Items
							$ob_reporte ->plantilla = $plantilla;
							$ob_reporte ->id_padre=$row_sub[id];
							$ob_reporte ->id_subarea = $row_sub['id_subarea'];
							$result_item= $ob_reporte->InformeItem($conn);
							$num_item=pg_numrows($result_item);?>
                         <? for ($z=0;$z<$num_item;$z++){
								$row_item=pg_fetch_array($result_item);	
								$id_item = $row_item['id_item'];?>
                                <tr >
 	                            <td class="subitem"><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">&nbsp;
								<? echo $row_item['glosa'];?>
															
								</td>
				         	<?	if($nuevo==1){	?>
									<td width="1%" nowrap class="subitem"><? 	//Conceptos Items
									$ob_reporte ->nuevo =$nuevo;
									$ob_reporte ->ano = $ano;
									$ob_reporte ->periodo = $id_peri[0];
									$ob_reporte ->plantilla = $plantilla;
									$ob_reporte ->id_item = $row_item[id];
									$ob_reporte ->alumno = $alumno;
									$result_respuesta= $ob_reporte ->InformeConcepto($conn);
									$num_respuesta=pg_numrows($result_respuesta);
									if($num_respuesta>0){
										$row_respuesta=pg_fetch_array($result_respuesta);
										if ($row_respuesta[concepto]==1){
											$ob_reporte ->respuesta = $row_respuesta['respuesta'];
											$result_con =$ob_reporte ->InformeEvaluacion($conn);
											$num_con=pg_numrows($result_con);
											if ($num_con>0){
												$row_con=pg_fetch_array($result_con);
												if ($evaluacion=="1"){												
													 echo $row_con[sigla];
 												}else{												
													 echo $row_con[nombre];
												}
											}
										}else{
											echo $row_respuesta[respuesta];
										}
									}									
									
									?></td>
									<td width="1%" nowrap class="subitem"><? 	$ob_reporte ->nuevo =$nuevo;
										$ob_reporte ->ano = $ano;
										$ob_reporte ->periodo = $id_peri[1];
										$ob_reporte ->plantilla = $plantilla;
										$ob_reporte ->id_item = $row_item[id];
										$ob_reporte ->alumno = $alumno;
										$result_respuesta= $ob_reporte ->InformeConcepto($conn);
										$num_respuesta=pg_numrows($result_respuesta);
										if ($num_respuesta>0){
											$row_respuesta=pg_fetch_array($result_respuesta);
											if ($row_respuesta[concepto]==1){
												$ob_reporte ->respuesta = $row_respuesta['respuesta'];
												$result_con =$ob_reporte ->InformeEvaluacion($conn);
												$num_con=pg_numrows($result_con);
												if ($num_con>0){
													$row_con=pg_fetch_array($result_con);
													if ($evaluacion=="1"){												
													    echo $row_con[sigla] ;
													}else{												
														echo $row_con[nombre];
													}
												}
											}else{
												echo $row_respuesta[respuesta];
											}
										}
									
									
									?></td>
								<? 	 
								    
								
								     if(trim($regimen)=="trimestre" or $_INSTIT==770){							  
									 
									 	?>
										<td width="1%" nowrap class="subitem"><? 	$ob_reporte ->nuevo =$nuevo;
											$ob_reporte ->ano = $ano;
											$ob_reporte ->periodo = $id_peri[2];
											$ob_reporte ->plantilla = $plantilla;
											$ob_reporte ->id_item = $row_item[id];
											$ob_reporte ->alumno = $alumno;
											$result_respuesta= $ob_reporte ->InformeConcepto($conn);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												if ($row_respuesta[concepto]==1){
													$ob_reporte ->respuesta = $row_respuesta['respuesta'];
													$result_con =$ob_reporte ->InformeEvaluacion($conn);;
													$num_con=pg_numrows($result_con);
													if ($num_con>0){
														$row_con=pg_fetch_array($result_con);
														if ($evaluacion=="1"){												
													         echo $row_con[sigla];
														}else{												
															 echo $row_con[nombre];
														}
													}
												}else{
												    echo $row_respuesta[respuesta];
												}
											}
										?></td>
					             <?	}									
							  }else{								
	//Primer Periodo				
									$ob_reporte ->nuevo=0;
									$ob_reporte ->id_item = $id_item;
									$ob_reporte ->ano =$ano;
									$ob_reporte ->periodo = $id_peri[0];				
									$ob_reporte ->alumno = $alumno;
									$resultEval= $ob_reporte ->InformeConcepto($conn);
									
									if(pg_numrows($resultEval)!=0){
										$filaEval=pg_fetch_array($resultEval,0);
										$ob_reporte ->respuesta = $filaEval['id_concepto'];
										$resultConc=$ob_reporte ->InformeEvaluacion($conn);
										$filaConc=pg_fetch_array($resultConc,0);
										$sigla = $filaConc['sigla'];
										$concepto = $filaConc['nombre'];
									}else{
										$sigla = "&nbsp;";
										$concepto = "&nbsp;";
									}?>
								<td class="subitem"><? 	if ($evaluacion=="1"){ 
										echo $sigla;
									}else{ 
										echo $nombre;
									} ?>								</td>
								
<? 	//Segundo Periodo			
									$ob_reporte ->nuevo=0;
									$ob_reporte ->id_item = $id_item;
									$ob_reporte ->ano =$ano;
									$ob_reporte ->periodo = $id_peri[1];				
									$ob_reporte ->alumno = $alumno;
									$resultEval= $ob_reporte ->InformeConcepto($conn);
									
									if(pg_numrows($resultEval)!=0){
										$filaEval=pg_fetch_array($resultEval,0);
										$ob_reporte ->respuesta = $filaEval['id_concepto'];
										$resultConc=$ob_reporte ->InformeEvaluacion($conn);
										$filaConc=@pg_fetch_array($resultConc,0);
										$sigla = $filaConc['sigla'];
										$concepto = $filaConc['nombre'];
									}else{
										$sigla = "&nbsp;";
										$concepto = "&nbsp;";
									}?>
									
								<td class="subitem"><? 	if ($evaluacion=="1"){ 
										echo $sigla;
									}else{ 
										echo $nombre;
									} ?></td>																						
                                <?  //tercer Periodo			
								if($tot_periodos==3){
									$ob_reporte ->nuevo=0;
									$ob_reporte ->id_item = $id_item;
									$ob_reporte ->ano =$ano;
									$ob_reporte ->periodo = $id_peri[2];				
									$ob_reporte ->alumno = $alumno;
									$resultEval= $ob_reporte ->InformeConcepto($conn);
									
									 
									if(@pg_numrows($resultEval)!=0){
										$filaEval=@pg_fetch_array($resultEval,0); 
										$ob_reporte ->respuesta = $filaEval['id_concepto'];
										$resultConc=$ob_reporte ->InformeEvaluacion($conn);
										$filaConc=@pg_fetch_array($resultConc,0);
										$sigla = $filaConc['sigla'];
										$concepto = $filaConc['nombre'];
									}else{
										$sigla = "&nbsp;";
										$concepto = "&nbsp;";
									}?>
								<td class="subitem"><? 	if ($evaluacion=="1"){ 
										echo $sigla;
									}else{ 
										echo $nombre;
									} ?></td>																
							<?	 }
							  }	?>																		
								</tr>
<?							
							} //FIN AMBITO
							} //FIN NUCLEO							
							} // FIN DETALLES	
//} // FIN PERFIL == 0

//------------------------------------------- vel

?>
		
      </table>
	  		
		</td>
	  </tr>
	  <tr>
	  	<td>
		<?	if ($destaca==0){ 
					$ob_reporte ->plantilla = $filaPlantilla['id_plantilla'];
					$ob_reporte ->ano =$filaMatri['id_ano'];
					$ob_reporte ->alumno = $alumno;
					$resultObs= $ob_reporte ->InformeObservaciones($conn);

				 for($countObs=0; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
					  $filaObs=@pg_fetch_array($resultObs, $countObs);
					  $sedestaca = $filaObs['sedestaca'];
				 }	  ?>							
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td width="20%" class="tabla04"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Se destaca en:</font></td>
					<td width="80%" class="tablatit2_1"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;<?=$sedestaca ?></font></td>
				 </tr>
			   </table>									
		  <? } ?>
			
		<? if($obs==0) { ?> 
		      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
			  <tr> 
				<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;Observaciones:</font></td>
			  </tr>
		      </table>
			  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
				<?  for($xxx=0 ; $xxx<@pg_numrows($resultObs) ;$xxx++ ){
					  $filaObs=@pg_fetch_array($resultObs, $xxx);?>
						<tr>
						<td width="20%"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $filaObs['nombre_periodo']; ?></font></td>
						<td><font size="1" face="Arial, Helvetica, sans-serif"><?	echo $filaObs['observaciones'];	echo "&nbsp; ";?></font></td>
						</tr>
			 <?  } ?>
		  	</table>
	 	 <? } ?> 
	<?
		$sql_con ="SELECT * FROM configuracion_reporte WHERE rdb=".$institucion." AND id_item=".$reporte." ";
			if($curso!=1){
		$sql_con.=" AND tipo_ense in (SELECT ensenanza FROM curso WHERE id_curso=".$curso.") ";
			}					
			echo "<font class='hidden'>".$sql_con."</font>";	
			$resp = @pg_exec($conn,$sql_con);
			$fila_config= pg_fetch_array($resp,0);
				
		$firma1=$fila_config['firma1'];
		$firma2=$fila_config['firma2'];
		$firma3=$fila_config['firma3'];
		$firma4=$fila_config['firma4'];
		?>
		
		
		<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<?   
				if($ob_config->firma1!=0){
						$ob_reporte->cargo=$ob_config->firma1;
						$ob_reporte->rdb=$institucion;
						$ob_reporte->Firmas($conn);?>
			<td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000">
				<div align="center"><?=$ob_reporte->nombre_emp;?>
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
		<? $fecha = date("d-m-Y");?>
		<table width="650"  border="0" cellpadding="0" cellspacing="0">
          <tr> 
             <td >
			   <font size="1" face="Arial, Helvetica, sans-serif">
			   <?
			   if ($_INSTIT==770){
			      echo "OVALLE, ";
			   }
			   ?>		   
			   
			   <?php echo  fecha_espanol($fecha); ?> </font></td>
          </tr> 
       </table>
		<?  if ($_INSTIT==12829){ ?>
	   <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
			    <tr>
					<td colspan="12"><strong><font size="1" face="Arial, Helvetica, sans-serif">ESCALA DE EVALUACI&Oacute;N:</font></strong></td>
				</tr>				
				<tr>
			<?	$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'] ;
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);	?>
					<td width="10" valign="top"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $filaConc['sigla'];?></strong></font>: </td>
					<td align="left" valign="bottom"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $filaConc['nombre'];?></font></td>
					
			<?	}?>
				</tr>
	        </table>
	  
	  
   		<? }else{ 
   			if($escala==1){?>	  
	  
		  <table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr> 
			  <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">ESCALA DE EVALUACI&Oacute;N / AREAS DE DESARROLLO</font></td>
			</tr>
		  </table>
		  
		  <table width="100%" cellpadding="0" cellspacing="0" border="0">	
			<?php 
			
				$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);
					?>
					
					<tr>
					   <td width="59%" align=center><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8"><? echo  $filaConc['nombre']; ?> (<? echo $filaConc['sigla']; ?>) </font></td>
					   <td width="4%" align=center><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8">:</font></td>
					   <td width="37%" align=left><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8"><? echo $filaConc['glosa']; ?></font></td>
					</tr>
			 
			  <? 
			  }	?>
			
	        </table>
   		<? } // fin if escala
  		}?>  
		
		<? if ($cont_alumnos > 1){  ?>  
	    	    <H1 class="SaltoDePagina"></H1>
		<? } ?>  
		</td>
	  </tr>
	
	</table>
<? }?>

			 
</body>
</html>
