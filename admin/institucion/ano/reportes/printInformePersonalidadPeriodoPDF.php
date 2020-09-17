<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
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

	/*if($PERFIL==0){
		error_reporting(E_ALL);
		ini_set('display_errors', '1'); 
	}*/

	//$fecha = strftime("%d %m %Y");
	

	
	$fecha = $txtFECHA;
	$_POSP = 5;
	$_bot = 8;
	$cbmAreaAlign = $_POST['cbmAreaAlign'];
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
	
	//if ($cb_ok){
		$ob_membrete = new Membrete();
		$ob_membrete->institucion = $institucion;
		$rs_instit = $ob_membrete->institucion($conn);
		
		$ob_membrete->ano = $ano;
		$rs_ano = $ob_membrete->AnoEscolar($conn);
		
		$ob_membrete->periodo = $periodo;
		$rs_periodo = $ob_membrete->periodo($conn);
		
		
		
		
		
		$ob_membrete->curso = $curso;
		$rs_curso = $ob_membrete->curso($conn);
	
		if($institucion==1436 && $ob_membrete->cod_ensenanza==10){
			$Curso_pal = CursoPalabra($curso, 5, $conn);		
		}else{
			$Curso_pal = CursoPalabra($curso, 4, $conn);
		}
		
		if($ob_membrete->grado_curso==1) $gr="pa";
		if($ob_membrete->grado_curso==2) $gr="sa";
		if($ob_membrete->grado_curso==3) $gr="ta";
		if($ob_membrete->grado_curso==4) $gr="cu";
		if($ob_membrete->grado_curso==5) $gr="qu";
		if($ob_membrete->grado_curso==6) $gr="sx";
		if($ob_membrete->grado_curso==7) $gr="sp";
		if($ob_membrete->grado_curso==8) $gr="oc";
		if($ob_membrete->grado_curso==9) $gr="nv";
		if($ob_membrete->grado_curso==10) $gr="dc";
		if($ob_membrete->grado_curso==11) $gr="un";
		if($ob_membrete->grado_curso==12) $gr="duo";
		if($ob_membrete->grado_curso==13) $gr="tre";
		if($ob_membrete->grado_curso==14) $gr="cat";
		
		$ob_reporte = new Reporte();
		$ob_reporte->ensenanza = $ob_membrete->cod_ensenanza;
		$ob_reporte->institucion=$institucion;
		$ob_reporte->grado = @$gr;
		$resultPlantilla = $ob_reporte->InformePlantilla($conn);
		$filaPlantilla=@pg_fetch_array($resultPlantilla);
		$plantilla=$filaPlantilla['id_plantilla'];
		$nuevo_sis=$filaPlantilla['nuevo_sis'];
		
		
		$ob_reporte->periodo = $periodo;
		$ob_reporte->Periodo($conn);
		$dias_habiles = $ob_reporte->dias_habiles;
		$fecha_inicio = $ob_reporte->fecha_inicio;
		$fecha_termino = $ob_reporte->fecha_termino;
	    $fecha_fin = $ob_reporte->fecha_termino;
		/*if($_PERFIL==0){
			echo "fecha inicio -->".$fecha_inicio;
			echo "<br> fecha termino-->".$fecha_termino;
			exit;	
		}*/
	//}
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	//calculo edad
	function edad($fecha){
 list($Y,$m,$d) = explode("-",$fecha);
   return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}


//dias habiles
 function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);
       
        // Incremento en 1 dia
        $diainc = 24*60*60;
       
        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                        if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                                array_push($diashabiles, date('Y-m-d', $midia));
                        }
                }
        }
       
        return count($diashabiles);
}
?>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">


 <STYLE media="print">
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family: Arial, Helvetica, sans-serif;
 font-size:9px;
 }
 .item
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:8px;

 }
 .subitem
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:7px;
 }
 
 @page { margin: 0px; }
body { margin: 0px; }

 </style>
<?

  $html=" 
  <link href='../../../../".$_ESTILO."' rel='stylesheet' type='text/css'>
  <style>
  H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family: Arial, Helvetica, sans-serif;
 font-size:10px;
 }
 .item
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:9px;

 }
 .subitem
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:9px;
 }
  
  @page { margin: 0px; size: Legal;padding-top:20px  }
body { margin: 0px;padding-top:20px }
</style>
<table align='center' width='600' border='0' cellpadding='0' cellspacing='0'  >


	<tr>
		<td>
		
		</td>
	</tr>  ";
				

		$ob_reporte->ano=$ano;
		$ob_reporte->curso=$curso;
		$ob_reporte->alumno=$alumno;
		$result_alu =$ob_reporte->TraeUnAlumno($conn);
	
	$cont_alumnos = pg_numrows($result_alu);

	for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
	{
		$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
		$ob_reporte->CambiaDato($fila_alu);
		$alumno = $ob_reporte->alumno;
		$titulo2 = $filaPlantilla['titulo_informe2'];
		
		
		//%asistencia
		
		
		if($ob_reporte->fecha_matricula > $fecha_inicio){
		 $fecha_ini = $ob_reporte->fecha_matricula;
		
		}
		else{
		 $fecha_ini = $fecha_inicio;
		}
		
		if($ob_reporte->fecha_retiro == null ){
			$fecha_fin = $fecha_termino;
		}
		else
		{
			$fecha_fin = $ob_reporte->fecha_retiro;
		
		}
		
		
		
		 if($diash < $dias_habiles){
			$dias_habiles = getDiasHabiles($fecha_ini,$fecha_fin);
			}else{
				$dias_habiles = $dias_habiles;
				}
		
		
			$sql13 = "select count(*) as cantidad from asistencia where rut_alumno = '" . $alumno . "' and ano = ". $ano . " and id_curso = " . $curso . " and fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD')";
			$result13 =@pg_Exec($conn,$sql13);
			$sql13 = "select count(*) as cantidad from asistencia where rut_alumno = '" . $alumno . "' and ano = ". $ano . " and id_curso = " . $curso . " and fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD')";
				$result13 =@pg_Exec($conn,$sql13);
				if($_PERFIL==0){
					//echo "consutla-->".$sql13;
				}
			    if (!$result13) 
			    {
			  	  error('<B> ERROR :</b>Error al acceder a la BD. (ASISTENCIA)</B>');
			  	}
			    else
			  	{
				  	if (pg_numrows($result13)!=0)
				    {
				  	  $fila13 = @pg_fetch_array($result13,0);	
				  	  if (!$fila13)
				  	  {
					  	  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  	  exit();
					    }
				    }
			    }
				$inasistencia = $fila13['cantidad'];
				 $dias_asistidos = $dias_habiles - $fila13['cantidad'];
				
				if ($dias_habiles>0)
			{
				$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,1);
				$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
				$prom_cont_asis = $prom_cont_asis + 1;
			}



$html.="<tr>
<td valign='top' align='left'>
<table width='500' border='0' align='center' cellpadding='0' cellspacing='0'>
	<tr>
		<td align='left' style='padding-left:20px' width='150'>
				<table width='130'   border='0'  cellpadding='0' cellspacing='0'>
					<tr>
					  <td align='center' height='120'>";
						if($institucion!=""){
							if($institucion==26094 && $ob_membrete->cod_ensenanza==10){
								$html.= "<img src='../../../../tmp/".$institucion."Kinder.jpg". "' >";
							}else{ 
							   $html.= "<img src='../../../../tmp/".$institucion."insignia". "'>";
							}
						}else{
						   $html.= "<img src='".$d."menu/imag/logo.gif' >";
						}	
						$html.="</td>
					  </tr>
					
					<tr>
					   <td align='left'>";
					  if($institucion!=24977){
						  $html.=" <table align='center' border='0'>
							  	<tr><td class='subitem'>".$ob_membrete->direccion."</td></tr>
								<tr><td class='subitem'>Fono: ".$ob_membrete->telefono."</td></tr>
                                <tr><td class='subitem'>Fax: ".$ob_membrete->fax."</td></tr>
						   </table>
						  ";
						   }
					$html.="</td>
					</tr>
				</table>
			
		</td>
		<td width='5' ><img src='linea_v.jpg' ></td>
		<td valign='top' align='left'>
			<table width='400' border='0' align='center' cellpadding='0' cellspacing='0'>
				<tr><td colspan='3' class='titulo' align='center'><strong>".$titulo2."</strong></td></tr>
				<tr><td colspan='3'><hr color='#660000'></td></tr>
				<tr>
					<td class='subitem'>&nbsp;A&ntilde;o Escolar</td>
                    
					<td class='subitem'>";
					
					if($_INSTIT=="4772" or $_INSTIT=="5265"){ $html.="Informe"; }else{ $html.="Periodo"; } $html.="</td>	
					<td class='subitem'>RBD</td>										
				</tr>
				<tr>
					<td class='subitem'>&nbsp;".$ob_membrete->nro_ano."</td>
					<td class='subitem'>"; if ($_INSTIT=="4772"){ $html.="Anual";  }else{ $html.=$ob_membrete->nombre_periodo; } $html.="</td>
					<td class='subitem'>".$institucion."-".$ob_membrete->dig_rdb."</td>										
				</tr>
				<tr><td colspan='3'>&nbsp;</td></tr>
				<tr>
					<td class= 'subitem' >Nombre Alumno(a)</td>";
					if($chk_rut==1){
                    $html.="<td class= 'subitem' >Rut Alumno</td>";
                    }
                    if($chk_edad==1){
					$html.="<td class= 'subitem' >Edad</td>";
                     }
				$html.="</tr>												
				<tr>
					<td class='subitem'>&nbsp;". strtoupper($ob_reporte->tildeM($ob_reporte->nombres))."</td>";
					 if($chk_rut==1){
                    $html.="<td class= 'subitem' >".$ob_reporte->rut_alumno."</td>";
                  }
                    if($chk_edad==1){
					$html.="<td class= 'subitem' >".edad($ob_reporte->fecha_nacimiento)." a&ntilde;os</td>";
                    }
				$html.="</tr>
				<tr>
				  <td class='subitem'>&nbsp;</td>
				  <td class= 'subitem' >&nbsp;</td>
				  <td class= 'subitem' >&nbsp;</td>
			  </tr>
				
				<tr>
					<td class='subitem' colspan='3'>Curso</td>
				</tr>												
				<tr>
					<td class='subitem' colspan='3'>".$Curso_pal."</td>										
				</tr>
				<tr>
				  <td class='subitem' colspan='3'>&nbsp;</td>
			  </tr>";
				 if($chk_pasis==1){
				$html.="<tr>
				  <td class='subitem' colspan='3'>Asistencia: ".$promedio_asistencia ." %</td>
			  </tr>	";
             }															
			$html.="</table>
		</td>		
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td colspan='4'>";
	 if($ckEVALUACION==1 and $ckPOSICION==1){
			$html.="<table width='550' border='0' align='center' cellpadding='0' cellspacing='0'>
				<tr>
					<td colspan='4' class='subitem'>ESCALA DE EVALUACI&Oacute;N:</td>
				</tr>
				<tr>";
			$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla']." AND tipo_eval is null";
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);
					 if($countConc==5){
						$html.= "</tr>
                         <tr>	";		 
						
					 } 
					$html.="<td class='subitem'>".$filaConc['sigla'].":</td>
					<td align='left' class='subitem'>".$filaConc['nombre']."</td>
					<td></td>";
				}	
				$html.="</tr>
			</table>";
	 } 
		$html.="</td>
	</tr>
	";

					if ($nuevo_sis==1){
						$html.="<table width='550' align='center'><tr><td valign='top'>";
						
						
						$contador=0;
						$ob_informe = new Reporte();
						$ob_informe->nuevo=1;
						$ob_informe->plantilla=$plantilla;
						$result_cat= $ob_informe->InformeAreas($conn);
						$num_cat=pg_numrows($result_cat);
						for ($i=0;$i<$num_cat;$i++){
							$row_cat=pg_fetch_array($result_cat);
						
							
							$html.="<table width='550' align='center' border='0' cellpadding='0' cellspacing='0' align='center' >
							<tr class='tabla04' >
							  <td   align='".$cbmAreaAlign."' class='titulo'>";
							   if($CHKAREAN==1){ $html.= "<strong>"; } if($CHKAREAC==1){ $html.= "<i>"; } 
							   $html.="<br>";
						      if ($row_cat['salto_pagina']==1){
								$html.= "<H1 class=SaltoDePagina></H1>";  
								} 
							  
							  $html.= $row_cat['glosa'];
							  if($CHKAREAN==1){ $html.= "</strong>"; } 
							  if($CHKAREAC==1){ $html.= "</i>"; } 
							  $html.="</td>
							</tr>
						</table>";
						//tabla padres
						$html.="<table width='550'  align='center' border='1' align='center' cellpadding='".$txtFILAS."' cellspacing='0' style='border-collapse:collapse'>";
						
						$ob_informe->id_padre=$row_cat['id'];
							$ob_informe->nuevo=1;
							$result_sub=$ob_informe->InformeSubarea($conn);
							$num_sub=pg_numrows($result_sub);
							for ($j=0;$j<$num_sub;$j++){
								$row_sub=pg_fetch_array($result_sub);
								
								
			$html.="<tr class='tabla04'>
									<td colspan='2' valign='top' align='".$cbmSubAreaAlign."' class='subitem'>";
	 if($CHKSUBN==1){ $html.= "<strong>"; }
	  if($CHKSUBC==1){ $html.= "<i>"; } 
	  $html.="<img src='../../../../cortes/p.gif' width='10' height='1' border='0'>".$row_sub['glosa'];
	   if($CHKSUBN==1){ $html.= "</strong>"; }
	   if($CHKSUBC==1){ $html.= "</i>"; } 
	   $html.="<span class='subitem'>
		</span></td>";
	$html.="<td><span class='subitem'>";
	$ob_informe->ano=$ano;
	$ob_informe->periodo=$periodo;
	$ob_informe->plantilla=$plantilla;
	$ob_informe->id_item=$row_sub['id'];
	$ob_informe->alumno=$alumno;
	$result_respuesta=$ob_informe->InformeConcepto($conn);
	
	$num_respuesta=pg_numrows($result_respuesta);
	if ($num_respuesta>0){
		
												$row_respuesta=pg_fetch_array($result_respuesta);
	if ($row_respuesta['concepto']==1){
		$query_con="select * from informe_concepto_eval  where id_concepto=".$row_respuesta['respuesta'];
		$result_con=pg_exec($conn,$query_con);
		$num_con=pg_numrows($result_con);
		if ($num_con>0){
			$row_con=pg_fetch_array($result_con);
			$html.= "&nbsp;".$row_con[sigla];
		}
	}else{
			$html.= "&nbsp;".$row_respuesta[respuesta];
	}
											
	}
	
	
	$html.="</span></td>";$html.="</tr>";	
	
	// orden de los elementos
									
	if ($plantilla==1322 or $plantilla==1104 or $plantilla==1101 ){
		$orden_elementos = " order by id";
	}else{
		$orden_elementos = " ";									
	}
	
	$query_item="select * from informe_area_item where id_plantilla=".$plantilla." and id_padre != 0 and id_padre=".$row_sub['id']." ORDER BY id ASC ";
	
	$result_item=pg_exec($conn,$query_item);
	$num_item=pg_numrows($result_item);
	for($z=0;$z<$num_item;$z++){
	$html.="<tr><td width='470'>1</td><td width='80'>2</td></tr>";
	}
									
	
								
								
						}//fin categorias
					
							
		$html.="</table>";//fin tabla padres
							
							
							
						}//fin forn informearas 
						if($institucion==10026){
                               $html.=" <TR>
                                <td>
                                <table width='550' align='center' border='1' cellpadding='".$txtFILAS."' cellspacing='0' style='border-collapse:collapse' align='center'>	
                                <tr>
                                	<td width='470' class='subitem'>&nbsp;LOGRO PROMEDIO</td>
                                    <td width='80' class='item'>&nbsp;";
                                     
									$sql="select round(avg(cast(respuesta as integer))) FROM informe_evaluacion2 ie where id_plantilla=".$plantilla." and id_ano=".$ano." and id_periodo=".$periodo." and id_curso=".$curso." and rut_alumno=".$alumno." and respuesta<>''";
									$rs_promedio = pg_exec($conn,$sql);
									$html.= pg_result($rs_promedio,0)."%";
								                                      
                                   $html.=" </td>
                                </tr>
                                </table>
                                </td>
                               </TR>";
                           } 
						$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla']." AND tipo_eval=1";
				$resultConc=@pg_Exec($conn, $sqlConc);
				if(pg_numrows($resultConc)>0){
					
							  $html.=" <table width='550' border='0' align='center' cellpadding='0' cellspacing='0'>
				<tr>
					<td colspan='4' class='subitem'>ESCALA DE EVALUACI&Oacute;N:</td>
				</tr>
				<tr>";
				
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);
					 if($countConc==5){
						 $html.=" </tr>
                         <tr>";			 
						
					} 
					 $html.="<td class='subitem'>".$filaConc['sigla'].":</td>
					<td align='left' class='subitem'>".$filaConc['nombre']."</td>
					<td></td>";
			}	
				 $html.="</tr>
			</table>";
			 } 		
			 
			   if ($ckDESTACA==1){  
										$ob_reporte ->plantilla = $filaPlantilla['id_plantilla'];
										$ob_reporte ->periodo = $periodo;
										$ob_reporte ->ano =$_ANO;
										$ob_reporte ->alumno = $alumno;
										$resultObs= $ob_reporte ->InformeObservaciones($conn);
					
									 for($countObs=0; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
										  $filaObs=@pg_fetch_array($resultObs, $countObs);
										  $sedestaca = $filaObs['sedestaca'];
									 }
							  							
									$html.="<table width='550' align='center' border='0' cellspacing='0' cellpadding='0'>
									  <tr>
										<td width='20%' class='tabla04'><font face='Verdana, Arial, Helvetica, sans-serif' size='1'>Se destaca "; if($institucion!=14703){ $html.="en:";  }$html.="</font></td>
										<td width='80%' class='tablatit2_1'><font face='Verdana, Arial, Helvetica, sans-serif' size='1'>&nbsp;".$sedestaca."</font></td>
									 </tr>
								   </table>	";	
															
							  }
							   if($ckOBS==1){
									$html.="<table width='550' border='0' cellpadding='0' cellspacing='0'>
									  <tr>
										<td><font size='1' face='Arial, Helvetica, sans-serif'>&nbsp; Observaciones:</font></td>
									  </tr>
									</table>

									
									<table width='550' border'1' align='center' cellpadding='0' cellspacing='0' style='border-collapse:collapse'>";
				            		 	$ob_informe->pantilla=$plantilla;
										$ob_informe->ano=$ano;
										$ob_informe->alumno=$alumno;
										$resultObs= $ob_informe->InformeObservaciones($conn);
									for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
										$filaObs=@pg_fetch_array($resultObs, $countObs);	
										$html.="<tr>
											<td width='19%'><span class='Estilo2'><font size='1' face='Arial, Helvetica, sans-serif'>";
		                                         if ($_INSTIT=="4772" ){ $html.="ANUAL"; }else{	$html.= $filaObs['nombre_periodo'];  } 
											$html.="</span></td>
											<td class='subitem'>".$filaObs['observaciones']."</td>
										</tr>";
									} 
									$html.="</table>";
									 }
									 
									 
									  /********************** ESCALA DE EVALUACION *******************/
										if($ckEVALUACION==1 and $ckPOSICION==0){
											$html.="<table width='550' border='0' align='center' cellpadding='0' cellspacing='0'>
												<tr>
													<td colspan='4' class='subitem'>ESCALA DE EVALUACI&Oacute;N:</td>
												</tr>
												<tr>";
											$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
												$resultConc=@pg_Exec($conn, $sqlConc);
												for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
													$filaConc=@pg_fetch_array($resultConc,$countConc);	
													$html.="<td class='subitem'>".$filaConc['sigla'].":</td>
													<td align='left' class='subitem'>".$filaConc['nombre']."</td>
													<td></td>";
												}	
												$html.="</tr>
											</table>";
									 } 
									 
									 
									 //firmas
									 for($i=0;$i<=$txtFIRMA;$i++){ 
										$html.="<br>";
										} 
                                    
									$html.="<table width='550' border='0' align='center'>
                                      <tr>";
                                        if(!$cb_ok=="Buscar"){
                                       $html.=" <td>&nbsp;</td>";
                                        }
                                          
										if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->empleado=$ob_config->empleado1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='80'><hr align='center' width='120' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				 $html.= $firmadig1;
				}else{
				
                
			 $html.="<td width='25%' class='item' height='100'><div style='width:100; height:50;'><br>
			  <br>
            </div>
			<hr align='center' width='120' color='#000000'><div align='center'><span class='item'>".$ob_reporte->nombre_emp."</span><br>".$ob_reporte->nombre_cargo."</div></td>";
			}} 
			if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->empleado=$ob_config->empleado2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='80'><hr align='center' width='120' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				if(isset($firmadig2)){
				 $html.= $firmadig2;
				}else{
				
		     $html.="<td width='25%' class='item'><div style='width:100; height:50;'></div><hr align='center' width='120' color='#000000'><div align='center'>".$ob_reporte->nombre_emp."<br>".$ob_reporte->nombre_cargo."</div></td>";
			 }} 
			  if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->empleado=$ob_config->empleado3;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='80'><hr align='center' width='120' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				 $html.= $firmadig3;
				}else{
				
				
			 $html.="<td width='25%' class='item'><div style='width:100; height:50;'></div><hr align='center' width='120' color='#000000'><div align='center'>".$ob_reporte->nombre_emp."<br>".$ob_reporte->nombre_cargo."</div></td>";
			 }} 
			  if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->empleado=$ob_config->empleado4;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='80'><hr align='center' width='120' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				 $html.= $firmadig4;
				}else{
		
		  $html.=" <td width='25%' class='item'><div style='width:100; height:50;'></div><hr align='center' width='120' color='#000000'><div align='center'>".$ob_reporte->nombre_emp."<br>".$ob_reporte->nombre_cargo."</div></td>";
			 }}
            if($chk_apo==1){
           $html.="<td width='25%' class='item'><br><br><br>
            <br>
            <br>
            <br>
<hr align='center' width='120' color='#000000'>
	        <div align='center'>";
	          	$ob_reporte->FirmaApo($conn);
			  		 $html.= $ob_reporte->nombre_apo;
	          $html.=" <br>
	          Apoderado
	          </div></td>";
			   } 
		   $html.="</tr>
		</table>";
		$html.="<table>
		<tr>
		<td class='subitem'>".$ob_membrete->comuna.",".fecha_espanol($fecha)."</td>
		</tr>
        </table>";
		if($institucion==5265 || $institucion==5661 || $institucion==6122 || $institucion==6835 || $institucion==7405 || $institucion==11678 || $institucion==19968 || $institucion==22019){
			
                      $html.="<table width='550' border='0' align='center'>
                          <tr>
                            <td class='item' align='center'><em>&nbsp;“Únicamente al esforzaros seriamente por tener éxito, lograréis la verdadera felicidad. Son preciosas las oportunidades que se os ofrecen durante el tiempo que pasáis en la escuela. Haced tan perfecta como sea posible vuestra vida estudiantil. Recorreréis ese camino una sola vez.Y de vosotros mismos depende que vuestra tarea sea un éxito o un fracaso. A medida que tengáis éxito en adquirir el conocimiento de la Biblia, estaréis acumulando tesoros para impartir.” (Mensaje para los Jóvenes. Elena de White).</em></td>
                          </tr>
                        </table>";
		}
						
						//fin tabla contenedora
						$html.="</td></tr></table>";
								}else{
									/**************tipo2*/
									$html.="<table width='550' border='0' cellpadding='0' cellspacing='0' align='center'>
								<tr valign='top'>
									<td>
										<table width='550' border='1' cellpadding='".$txtFILAS."' cellspacing='0'>";
											$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
							
											$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
												//trae areas
											$ob_reporte = new Reporte();
											$ob_reporte->nuevo=0;
											$ob_reporte->plantilla=$filaPlantilla['id_plantilla'];
											$resultTraeArea=$ob_reporte->InformeAreas($conn);
										
											for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
												$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
												$nroA=$countArea+1;	
													
												$html.="<tr><td><font face='Arial, Helvetica, sans-serif'></font></td></tr>
												<tr><td valign='bottom'><font size='1' face='Arial, Helvetica, sans-serif'><strong>".$nroA.".-  ".$filaTraeArea['nombre']."</strong></font></td>";
												if($countArea==0){													
													$html.="<td><font size='1' face='Arial, Helvetica, sans-serif'><strong>EVALUACI&Oacute;N</strong></font></td>";												
												}else{	
													$html.="<td>&nbsp;&nbsp;</td>";
												}
												//trae subareas para cada area y las imprime
												$ob_reporte->id_area=$filaTraeArea['id_area'];
												$resultTraeSubarea=$ob_reporte->InformeSubarea($conn);

												for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
												$nroS=$countSubarea+1;
												$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);	
												$html.="<tr><td valign='bottom' colspan='2'><font size='1' face='Arial, Helvetica, sans-serif'>&nbsp;&nbsp;&nbsp;<strong>";
												$html.= $nroA.".".$nroS.".-  ".$filaTraeSubarea['nombre']."</strong></font>
                                                </td></tr>";
												//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
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
													}	
													$html.="<tr><td valign='bottom'>";
												$nroI=$countItem+1;		
													$html.="<font size='1' face='Arial, Helvetica, sans-serif'>&nbsp;".$nroA.".".$nroS.".".$nroI.".-  ".trim($filaTraeItem['glosa'])."</font>
													</td>";
													if($filaTraeItem['tipo']==0){
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
															if($ckCONCEPTO==0){	
																$html.="<td valign='bottom'>&nbsp;&nbsp;
																<font size='1' face='Arial, Helvetica, sans-serif'>".trim($filaConc['sigla'])."</font></td>";
															}else{	
																$html.="<td valign='bottom'>&nbsp;&nbsp;
																<font size='1' face='Arial, Helvetica, sans-serif'>".trim($filaConc['nombre'])."</font></td>";
														}
														}
													}else if($filaTraeItem['tipo']==2){
														$ob_reporte->ano=$ano;
														$ob_reporte->periodo=$filaP['id_periodo'];
														$ob_reporte->alumno=$alumno;
														$ob_reporte->id_item=$filaTraeItem['id_item'];
														$resultEvalu=$ob_reporte->InformeConcepto($conn);
													
														for($countEvalu=0 ; $countEvalu<pg_numrows($resultEvalu) ; $countEvalu++){
															$filaEvalu=pg_fetch_array($resultEvalu,$countEvalu);
												  $html.="<tr><td valign=bottom>
															<font size='1' face='Arial, Helvetica, sans-serif'>&nbsp;&nbsp;&nbsp;&nbsp;".$filaEvalu['nombre_periodo'].":&nbsp;&nbsp".$filaEvalu['text']."</td></tr>
															<tr><td bgcolor='#0099FF' ></td></tr>";
														}
													}else if($filaTraeItem['tipo']==1){
														$ob_reporte->ano=$ano;
														$ob_reporte->periodo=$filaP['id_periodo'];
														$ob_reporte->alumno=$alumno;
														$ob_reporte->id_item=$filaTraeItem['id_item'];
														$resultEvalua=$ob_reporte->InformeConcepto($conn);
														
														for($countEvalua=0 ; $countEvalua<pg_numrows($resultEvalua) ; $countEvalua++){
															$filaEvalua=@pg_fetch_array($resultEvalua,$countEvalua);
															if(($filaEvalua['radio']==0) and ($filaEvalua['radio']!="")){	
																	$html.="<tr><td valign='bottom'>
																	<font size='1' face='Arial, Helvetica, sans-serif'>&nbsp;&nbsp;&nbsp;&nbsp;".$filaEvalua['nombre_periodo'].":&nbsp;&nbsp;No</font></td></tr>	
																	<tr><td bgcolor='#0099FF' ></td></tr>";
															}else if($filaEvalua['radio']==1){	
																	$html.="<tr><td valign='bottom'>
																	<font size='1' face='Arial, Helvetica, sans-serif'>&nbsp;&nbsp;&nbsp;&nbsp;".$filaEvalua['nombre_periodo'].":&nbsp;&nbsp;Si</font></td></tr>
																	<tr><td bgcolor='#0099FF'></td></tr>";
															}
														}
													}
												}//fin for($countItem....
											}//fin for($countSubarea....
										}//fin for($countArea....			 
										
                                        $html.="</table>";
										
													if ($ckDESTACA==1){  
										$ob_reporte ->plantilla = $filaPlantilla['id_plantilla'];
										$ob_reporte ->ano =$_ANO;
										$ob_reporte ->alumno = $alumno;
										$resultObs= $ob_reporte ->InformeObservaciones($conn);
					
									 for($countObs=0; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
										  $filaObs=@pg_fetch_array($resultObs, $countObs);
										  $sedestaca = $filaObs['sedestaca'];
									 }
							 							
									$html.="<table width='100%' border='0' cellspacing='0' cellpadding='0'>
									  <tr>
										<td width='20%' class='tabla04'><font face='Verdana, Arial, Helvetica, sans-serif' size='1'>Se destaca en:</font></td>
										<td width='80%' class='tablatit2_1'><font face='Verdana, Arial, Helvetica, sans-serif' size='1'>&nbsp;".$sedestaca."</font></td>
									 </tr>
								   </table>	";								
							   } 
							  $html.=" <table width='100%' border='0' cellpadding='0' cellspacing='0'>
										  <tr>
											<td><font size='1' face='Arial, Helvetica, sans-serif'>Observaciones:</font></td>
										  </tr>
										</table>";
										
										
							$html.="<table width='100%' border='1' align='center' cellpadding='1' cellspacing='0'>";
										$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_periodo=".$periodo." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
										$resultObs=@pg_Exec($conn, $sqlTraeObs);
										for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
											$filaObs=@pg_fetch_array($resultObs, $countObs);	
											$html.="<tr>
												<td width='19%'><font size='1' face='Arial, Helvetica, sans-serif'>";
	                                              if ($_INSTIT=="1436" ){ $html.="ANUAL" ; }else{ $html.= $filaObs['nombre_periodo'];  }
												$html.="</td>";
												$html.="<td><font size='1' face='Arial, Helvetica, sans-serif'>".$filaObs['glosa']."&nbsp;</font></td></tr>";
									}	
										$html.="</table>";
										$html.="<table width='100%' border='0'>";
										if($institucion!=25218 && $institucion!=14629 && $institucion!=25478 && $institucion!=24977 && $institucion!=22380 ){
											$html.="<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td></td>
											</tr>";
                              		}	
											$html.="<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td align='right'><font size='2' face='Arial, Helvetica, sans-serif'>
												</font></td>
											</tr>
										</table>";
										
										for($i=0;$i<=$txtFIRMA;$i++){ 
										$html.="<br>";
										}
										
										
										//firmas
										$html.="<table width='100%' border='0' align='center'>
                                      <tr>";
                                        if(!$cb_ok=="Buscar"){
                                        $html.="<td>&nbsp;</td>";
                                         } 
										if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->empleado=$ob_config->empleado1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='120' color='#000000'><div  align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				$html.= $firmadig1;
				}else{
				
                
			$html.="<td width='25%' class='item' height='100'><div style='width:100; height:50;'></div><hr align='center' width='120' color='#000000'><div align='center'><span class='item'>".$ob_reporte->nombre_emp."</span><br>".$ob_reporte->nombre_cargo."</div></td>";
			 }}
			 if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->empleado=$ob_config->empleado2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='120' color='#000000'><div  align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				if(isset($firmadig2)){
				$html.= $firmadig2;
				}else{
				
		    $html.="<td width='25%' class='item' height='100'><div style='width:100; height:50;'></div><hr align='center' width='120' color='#000000'> 
		      <div align='center'>".$ob_reporte->nombre_emp."<br>".$ob_reporte->nombre_cargo."</div></td>";
			 }} 
			 if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->empleado=$ob_config->empleado3;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='120' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				$html.= $firmadig3;
				}else{
				
				
			$html.="<td width='25%' class='item' height='100'><div style='width:100; height:50;'></div><hr align='center' width='120' color='#000000'><div align='center'>".$ob_reporte->nombre_emp."<br>".$ob_reporte->nombre_cargo."</div></td>";
			}} 
			 if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->empleado=$ob_config->empleado4;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='120' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				$html.= $firmadig4;
				}else{
		
		 $html.=" <td width='25%' class='item' height='100'><div style='width:100; height:50;'></div><hr align='center' width='120' color='#000000'><div align='center'>".$ob_reporte->nombre_emp."<br>".$ob_reporte->nombre_cargo."</div></td>";
			 }}
               if($chk_apo==1){
          $html.="<td width='25%' class='item' height='100'><br><br><br><br><br><hr align='center' width='120' color='#000000'>
	        <div align='center'>";
	          	$ob_reporte->FirmaApo($conn);
			  		$html.= $ob_reporte->nombre_apo;
	         $html.=" <br>
	          Apoderado
	          </div></td>";
			  } 
		 $html.=" </tr>
		</table>";
		$html.="<table>
		 <tr>
         <td class='subitem'>".$ob_membrete->comuna.",".fecha_espanol($fecha)."</td>
      </tr>
      </table>";
		
									
									
									}//fin tipo2

									
									
				
				$html.= " </td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</td>
</tr>
	</table>";
		}	?>

<?php

     
 //  $content=$html;
    $content = ob_get_clean();
	$fecha_actual = date('d_m_Y-H:i:s');

    // convert to PDF
    require_once("../../../clases/dompdf/dompdf_config.inc.php");
    $dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->set_paper('legal', 'portrait');
$dompdf->stream("Inorme Personalidad".$fecha_actual.".pdf",array("Attachment" => false));
?>
						
				