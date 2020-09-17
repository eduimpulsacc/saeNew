<?php 
//require('../../../../../util/header.inc');
include"../Coneccion/conexion.php";

$ano		= $_ANO;
$conn		= $conexion;
$curso		= $c_curso;
$alumno		= $c_alumno;
$institucion= $_INSTIT;

//if ($c_alumno==0)
 //exit;
	if ($curso==0) $sw = 1;
	if ($sw == 1) exit;
 

	$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultDIR =@pg_Exec($conn,$qryDIR);
	$filaDIR=@pg_fetch_array($resultDIR);

	//$sqlPeriodo="select nombre_periodo from periodo where id_ano=".$filaAno['id_ano']." order by nombre_periodo asc";
	$sqlPeriodo="select nombre_periodo from periodo where id_ano=".$ano." order by nombre_periodo asc";
	$resultPeriodo=@pg_exec($conn, $sqlPeriodo);

	
	$sqlInstit="select * from institucion where rdb=".$institucion;
	$resultInstit=@pg_Exec($conn, $sqlInstit);
	$filaInstit=@pg_fetch_array($resultInstit);
	
	
	$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
    $resultEmp =@pg_Exec($conn,$qryEmp);
	$filaEmp=@pg_fetch_array($resultEmp);
	
	
?>

<html>
<head>
<title>Informe Educacional</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>


                <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td>
		<div id="capa0"> 
        <div align="right">
          <input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="botonX" 
		id="cmdimprimiroriginal" 
		onClick="imprimir1();" 
		value="Imprimir">
        </div>
      </div> </td>
                  </tr>
                </table>
              </td>


<script>
//document.getElementById("capa4").style.display='none';

function imprimir1() 
{
	document.getElementById("capa0").style.display='none';
	//document.getElementById("capa2").style.display='none';
	//document.getElementById("capa4").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
	//document.getElementById("capa2").style.display='block';
	//document.getElementById("capa4").style.display='block';
	
}
function imprimir2() 
{
	document.getElementById("capa0").style.display='none';
	document.getElementById("capa1").style.display='none';
	
	window.print();
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
	//document.getElementById("capa4").style.display='none';
	//if
}
</script>
<?
 	if (empty($c_alumno))
		$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
	else
		$sql_alu = "select * from matricula where rut_alumno ='" . $c_alumno ."' and id_ano = " . $ano;
		
	$result_alu =@pg_Exec($conn,$sql_alu);
	$cont_alumnos = @pg_numrows($result_alu);

for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
{
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	
	 //$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$filaAno['id_ano']." and matricula.id_curso=curso.id_curso";
	$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$ano." and matricula.id_curso=curso.id_curso";
	$resultMatri=@pg_exec($conn,$sqlMatri);
	$filaMatri=@pg_fetch_array($resultMatri,0);
			if($filaMatri['grado_curso']==1) $gr="pa";
			if($filaMatri['grado_curso']==2) $gr="sa";
			if($filaMatri['grado_curso']==3) $gr="ta";
			if($filaMatri['grado_curso']==4) $gr="cu";
			if($filaMatri['grado_curso']==5) $gr="qu";
			if($filaMatri['grado_curso']==6) $gr="sx";
			if($filaMatri['grado_curso']==7) $gr="sp";
			if($filaMatri['grado_curso']==8) $gr="oc";

	$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$filaMatri['ensenanza']." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla,0);
	
	$sqlTraeAlumno="SELECT * FROM alumno WHERE rut_alumno='".$alumno."'";
	$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
	$filaAlumno=@pg_fetch_array($resultAlumno,0);
	
	$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$filaMatri['id_curso'];
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$filaMatri['ensenanza'];
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$sqlProfe="select * from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$filaMatri['id_curso'];
	$resultProfe=@pg_Exec($conn, $sqlProfe);
	$filaProfe=@pg_fetch_array($resultProfe);

	$titulo1 = $filaPlantilla['titulo_informe1'];
?>


<form action="proceso_informe.php" method="post">
  <table width="76%" border="0" align="center">
    <tr> 
      <td valign="top"> 
        <div id="capa1"> 

<table width="100%">
	<tr>
		<?
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			if 	(!empty($fila_foto['insignia']))
			{ ?>
				<td width="600">
				  <table width="471" border="0" align="center">
					<tr> 
					  <td align="center" bgcolor="#003b85"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">
					  <strong><? echo $titulo1;?>&nbsp;</strong></font></td>

					</tr>
				  </table>
				  <table width="471" border="0" align="center">
					<tr> 
					  <td align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $filaInstit['nombre_instit']?></font></strong></td>
					</tr>
				  </table>
				  <table width="471" border="0" align="center">
					<tr valign="middle"> 
					  <td width="23%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">Res. 
						Exta. de Educaci&oacute;n N&ordm; <?php echo $filaInstit['nu_resolucion']?> 
						de fecha 
						<?php impF($filaInstit['fecha_resolucion'])?>
						Rol Base de Datos <?php echo $filaInstit['rdb']," - ",$filaInstit['dig_rdb']?> 
						</font></strong></td>
					</tr>
				  </table>
			</td>
						<?
				$output = "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
				$retrieve_result = @pg_exec($conn,$output);?>  
				<td width="119" rowspan="6"align="left"><div align="center"><img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE" height="100"></div></td>
				
		<? }
			else{?>
			<td width="100%">
			  <table width="100%" border="0" align="center">
				<tr> 
				  <td align="center" bgcolor="#003b85"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">
				  <strong><? echo $titulo1;?></strong></font><font size="2">&nbsp;</font></td>
				</tr>
			  </table>
			  <table width="100%" border="0" align="center">
				<tr> 
				  <td align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $filaInstit['nombre_instit']?></font></strong></td>
				</tr>
			  </table>
			  <table width="100%" border="0" align="center">
				<tr valign="middle"> 
				  <td width="23%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">Res. 
					Exta. de Educaci&oacute;n N&ordm; <?php echo $filaInstit['nu_resolucion']?> 
					de fecha 
					<?php impF($filaInstit['fecha_resolucion'])?>
					Rol Base de Datos <?php echo $filaInstit['rdb']," - ",$filaInstit['dig_rdb']?> 
					</font></strong></td>
				</tr>
			  </table>
			</td>

	<? } ?>
	</tr>
</table>





          <table width="100%" border="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <td width="9%"><font size="1" face="Arial, Helvetica, sans-serif">Alumno</font></td>
              <td width="50%"><font size="1" face="Arial, Helvetica, sans-serif">: 
                <?php echo $filaAlumno['nombre_alu']. " " . $filaAlumno['ape_pat']. " " . $filaAlumno['ape_mat']?></font></td>
              <td width="5%"><font size="1" face="Arial, Helvetica, sans-serif">RUT</font></td>
              <td width="36%"><font size="1" face="Arial, Helvetica, sans-serif">: 
                <?php echo $alumno."-". $filaAlumno['dig_rut']?></font></td>
            </tr>
          </table>
          <table width="100%" border="0">
            <tr> 
              <td width="9%"><font size="1" face="Arial, Helvetica, sans-serif">Curso</font></td>
              <td width="91%"><font size="1" face="Arial, Helvetica, sans-serif">: 
                <?php echo $filaCurso['grado_curso']. " - ".$filaCurso['letra_curso']."     ".$filaEns['nombre_tipo'] ?></font></td>
            </tr>
          </table>
          <?php if($filaMatri['ensenanza']>310){?>
          <table width="100%" border="0">
            <tr> 
              <td width="10%"><font size="1" face="Arial, Helvetica, sans-serif">Especialidad</font></td>
              <td width="90%">: <font size="1" face="Arial, Helvetica, sans-serif"> 
                <?php   $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaMatri['cod_es']." and cod_sector=".$filaMatri['cod_sector']." and cod_rama=".$filaMatri['cod_rama'];
								$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
								$filaEsp=@pg_fetch_array($resultEsp,0);
								echo $filaEsp['nombre_esp'];?>
                </font></td>
            </tr>
          </table>
          <?php } ?>
          <!--table width="100%" border="0">
            <tr valign="middle"> 
              <td width="17%"><font size="1" face="Arial, Helvetica, sans-serif">Establecimiento</font></td>
              <td width="83%">:<font size="1" face="Arial, Helvetica, sans-serif"> 
                <?php echo $filaInstit['nombre_instit']?></font></td>
        </tr>
      </table-->
          <table width="100%" border="0">
            <tr> 
              <td width="10%"><font size="1" face="Arial, Helvetica, sans-serif">Profesor 
                Jefe</font></td>
              <td width="90%"><font size="1" face="Arial, Helvetica, sans-serif">: 
                <?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?></font></td>
            </tr>
          </table>
          <table width="100%" border="0">
            <tr> 
              <!--td colspan="2">&nbsp;</td-->
            </tr>
          </table>
          <!--table width="100%" cellspacing="0" border="1" bordercolor="#999999">
 <tr>
 <td-->
          <table width="630">
            <?php 
						echo "<tr><td></td>";
						for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
						$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
						if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE") $per="1 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE") $per="3 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE") $per="1 Sem.";
						if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE") $per="2 Sem.";
						echo "<td align=\"center\"><font size=1 face=Arial, Helvetica, sans-serif>".$per."</font></td>";
						
						}echo "</tr>";
				$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
					//trae areas
					$sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
					for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
						$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
						
						
						//echo "<tr bgcolor=\"#0099CC\"><td valign=bottom><font color=\"#FFFFFF\" size=1 face=Arial, Helvetica, sans-serif><strong>".$filaTraeArea['nombre']."</strong></font></td>";
						echo "<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif><strong>".$filaTraeArea['nombre']."</strong></font></td>";
						echo "<td valign=bottom><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
						
							//trae subareas para cada area y las imprime
							$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
							$resultTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
							for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
								$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);
								//echo "<tr><td valign=bottom><font color=\"#0099CC\" size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong>".$filaTraeSubarea['nombre']."</strong></font><hr></td>";
								echo "<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong>".$filaTraeSubarea['nombre']."</strong></font></td><tr><td bgcolor=\"#000000\" ></td></tr>";
								//echo "<td valign=bottom><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
								
									//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
									$sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea'];
									$resultTraeItem=@pg_Exec($conn, $sqlTraeItem);
									
									for($countItem=0 ; $countItem<@pg_numrows($resultTraeItem) ; $countItem++){
									$countI++;
										$filaTraeItem=@pg_fetch_array($resultTraeItem, $countItem);
										//PRIMERO TENGO QUE PREGUNTAR SI EL ITEM SE EVALUA CON CONCEPTOS, SI/NO(RADIO), TEXTO
										
										if($countItem%2==0){
											$color="#CDCDCD";
										}else{
											$color="#B5B5B5";
										}
										//echo "<tr bgcolor=".$color."><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>".$filaTraeItem['glosa']."</font><hr></td>";
										//echo "<div style=\"page-break-after:always\"></div>";
										echo "<tr><td valign=bottom>";
										
										
										if(($filaTraeItem['tipo']==1) or ($filaTraeItem['tipo']==2) and ($countItem!=0)){
											//echo "<tr><td bgcolor=\"#0099FF\" colspan=\"4\"></td></tr>";
											//echo "<hr size=\"1\">";
										}
										
										//if ($countI==14) echo "<div style=\"page-break-after:always\"></div>";
										
										echo "<font size=1 face=Arial, Helvetica, sans-serif>".$filaTraeItem['glosa']."</font>";
										
										if($filaTraeItem['tipo']==0){
											//echo "<tr><td bgcolor=\"#0099FF\" ></td></tr>";
											//echo "<hr size=\"1\">";
										}
										echo "</td>";
											
												if($filaTraeItem['tipo']==0){
												
												   $sqlP="select * from periodo where id_ano=".$ano." order by id_periodo";
												   $resultP=@pg_Exec($conn, $sqlP);
												   for($countEval=0 ; $countEval<pg_numrows($resultP) ; $countEval++){
												   $filaP=@pg_fetch_array($resultP,$countEval);
													$sqlTraeEval="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']."and periodo.id_periodo='".$filaP['id_periodo']."' and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo";
													$resultEval=@pg_Exec($conn, $sqlTraeEval);
													$filaEval=@pg_fetch_array($resultEval,0);
														$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
														$resultConc=@pg_Exec($conn, $sqlTraeConc);
														$filaConc=@pg_fetch_array($resultConc,0);

													/*$sqlTraeEval="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo";
													$resultEval=@pg_Exec($conn, $sqlTraeEval);
													
													for($countEval=0 ; $countEval<pg_numrows($resultEval) ; $countEval++){
													$filaEval=@pg_fetch_array($resultEval,$countEval);
														$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
														$resultConc=@pg_Exec($conn, $sqlTraeConc);
														$filaConc=@pg_fetch_array($resultConc,0);*/
														
														echo "<td valign=bottom>&nbsp;&nbsp;";
														echo "<font size=1 face=Arial, Helvetica, sans-serif>".$filaConc['sigla']."</font></td>";
													}
												}else if($filaTraeItem['tipo']==2){
													//$sqlTraeEval="select * from informe_evaluacion where id_item=".$filaTraeItem['id_item']." and id_ano=".$filaMatri['id_ano']." and id_periodo=".$id_periodo." and rut_alumno='".$alumno."'";
													$sqlTraeEvalu="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo asc";
													$resultEvalu=@pg_Exec($conn, $sqlTraeEvalu);
													for($countEvalu=0 ; $countEvalu<pg_numrows($resultEvalu) ; $countEvalu++){
														$filaEvalu=pg_fetch_array($resultEvalu,$countEvalu);
														//if ($countI==28) echo "<div style=\"page-break-after:always\"></div>";
														//echo "<td valign=bottom>";</td>
														echo "<tr><td valign=bottom>";
														//if ($countI==28) echo"</table><table width=\"100%\">";
														echo "<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;".$filaEvalu['nombre_periodo'].":&nbsp;&nbsp".$filaEvalu['text']."</td></tr>";
														echo "<tr><td bgcolor=\"#0099FF\" ></td></tr>";
													}
												}else if($filaTraeItem['tipo']==1){
													//$sqlTraeEval="select * from informe_evaluacion where id_item=".$filaTraeItem['id_item']." and id_ano=".$filaMatri['id_ano']." and id_periodo=".$id_periodo." and rut_alumno='".$alumno."'";
													$sqlTraeEvalua="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo asc";
													$resultEvalua=@pg_Exec($conn, $sqlTraeEvalua);
													for($countEvalua=0 ; $countEvalua<pg_numrows($resultEvalua) ; $countEvalua++){
														$filaEvalua=@pg_fetch_array($resultEvalua,$countEvalua);
														if(($filaEvalua['radio']==0) and ($filaEvalua['radio']!="")){
																echo "<tr><td valign=bottom>";
																//if ($countI==28) echo "<div style=\"page-break-after:always\"></div>";
																//if ($countI==28) echo"</table><table width=\"100%\">";
																echo "<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;".$filaEvalua['nombre_periodo'].":&nbsp;&nbsp;No</font></td></tr>";	
																echo "<tr><td bgcolor=\"#0099FF\" ></td></tr>";
															}else if($filaEvalua['radio']==1){
																echo "<tr><td valign=bottom>";
																//if ($countI==28) echo "<div style=\"page-break-after:always\"></div>";
																//if ($countI==28) echo"</table><table width=\"100%\">";
																echo "<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;".$filaEvalua['nombre_periodo'].":&nbsp;&nbsp;Si</font></td></tr>";
																echo "<tr><td bgcolor=\"#0099FF\"></td></tr>";
															}
													}
														
												}
												
											//if ($countI==14) //echo "<br style=\"page-break-after:always\">";
											
									}//fin for($countItem....
									
							}//fin for($countSubarea....
							
					}//fin for($countArea....
									
	
		  ?>
            <input name="plantilla" type="hidden" value="<?php echo $filaPlantilla['id_plantilla']?>">
            <input name="alumno" type="hidden" value="<?php echo $alumno?>">
          </table>
          <!--/td>
	  </tr>
	  </table-->
          <table width="100%" border="0">
            <tr> 
              <td>&nbsp;</td>
            </tr>
          </table>
          <!--/div-->
          <?
		if(($institucion!=24464)&&($institucion!=12086)){
// if  (($cont_alumnos - $cont_paginas)<>1) 
	echo "<H1 class=SaltoDePagina></H1>";
		}
 ?>
          <!--div id="capa2"-->
          <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="003b85">
            <tr> 
              <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp; 
                Observaciones:</strong></font></td>
            </tr>
          </table>
          <table width="95%" border="1" align="left" cellpadding="1" cellspacing="0">
            <?php //$sqlTraeObs="select * from informe_observaciones where id_periodo=".$id_periodo." and id_ano=".$filaMatri['id_ano']." and id_plantilla=".$filaPlantilla['id_plantilla']." and rut_alumno='".$alumno."'";
					$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_ano=".$filaMatri['id_ano']." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
					//exit;
					$resultObs=@pg_Exec($conn, $sqlTraeObs);
					?>
            <?php 
		  for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
		  $filaObs=@pg_fetch_array($resultObs, $countObs);
		  	echo "<tr>";
			echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">";
			echo $filaObs['nombre_periodo'];
			echo "</td>";
          	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">";
			echo $filaObs['glosa'];
            echo "&nbsp;</font></td>";
        	echo "</tr>";
		}
		?>
          </table>
          <table width="100%" border="0">
            <tr> 
              <td>&nbsp; </td>
            </tr>
            <tr> 
              <td align="right">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">
                <?php setlocale ("LC_TIME", "es_ES"); echo (strftime("%d de %B de %Y")); ?>
                </font> </td>
            </tr>
            <tr> 
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <td></td>
            </tr>
            <tr> 
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <td align="right"><font size="2" face="Arial, Helvetica, sans-serif"> 
                <input type="hidden" name="fecha">
                <input type="hidden" name="tipoEns" value="<?php echo $tipoEns ?>">
                <input type="hidden" name="grado" value="<?php echo $grado ?>">
                <!--input type="hidden" name="periodo" value="<?php //echo $periodo ?>"-->
                </font></td>
            </tr>
          </table>
          <table width="100%" border="0">
            <tr> 
              <td width="45%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?>&nbsp;</strong></font></td>
              <? if ($institucion==24511) { ?>
              <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo "Marcela Paz Cardemil Bañados"?>&nbsp;</strong></font></td>
              <? } else { ?>
              <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat']?>&nbsp;</strong></font></td>
              <? } ?>
            </tr>
          </table>
          <table width="100%" border="0">
            <tr align="center"> 
              <td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR 
                JEFE</font></td>
              <? if ($institucion==24511) { ?>
              <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">DIRECTORA 
                DE CICLO</font></td>
              <? } else { ?>
              <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">JEFE 
                ESTABLECIMIENTO</font></td>
              <? } ?>
            </tr>
          </table>
          <table width="100%" border="0">
            <tr> 
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <td height="22">&nbsp;</td>
            </tr>
            <tr> 
              <td align="center">&nbsp;</td>
            </tr>
            <tr> 
              <td align="center">&nbsp;</td>
            </tr>
            <tr> 
              <td align="center"></td>
            </tr>
          </table>
          <table width="100%">
            <tr> 
              <td align="center" bgcolor="#003B85"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">ESCALA 
                DE EVALUACI&Oacute;N / AREAS DE DESARROLLO</font></strong></td>
            </tr>
            <tr> </tr>
          </table>
          <table width="100%" border="0">
            <tr> 
              <?php 
			$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
			$resultConc=@pg_Exec($conn, $sqlConc);
			for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
				$filaConc=@pg_fetch_array($resultConc,$countConc);
				echo "<tr><td><font size=1 face=Arial, Helvetica, sans-serif>".$filaConc['nombre']."&nbsp;(".$filaConc['sigla'].")</font></td>";
				echo "<td><font size=1 face=Arial, Helvetica, sans-serif>:</font></td>";
				echo "<td><font size=1 face=Arial, Helvetica, sans-serif>".$filaConc['glosa']."</font><td></tr>";
			}		
		?>
            </tr>
          </table>
        </div></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
  </table>
 <? 
// }
  if  (($cont_alumnos - $cont_paginas)<>1) 
	echo "<H1 class=SaltoDePagina></H1>";
	}
?>
</form>
</div>
</body>
</html>
