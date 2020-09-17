<?php 
require('../../../../util/header.inc');
//$plantilla	=$_PLANTILLA;
$institucion ="25478";
$ano		="431";
//$modificar= $_GET[modificar];
		/*if(session_is_registered('_PLANTILL')){
			session_unregister('_CURSO');
		};*/

if($grado==1) $gr="pa";
if($grado==2) $gr="sa";
if($grado==3) $gr="ta";
if($grado==4) $gr="cu";
if($grado==5) $gr="qu";
if($grado==6) $gr="sx";
if($grado==7) $gr="sp";
if($grado==8) $gr="oc";

	$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=110 AND cu=1 and activa=1 AND rdb=".$institucion;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);

	
	$sqlTraeAlumno="SELECT * FROM alumno WHERE rut_alumno=".$alumno;
	$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
	$filaAlumno=@pg_fetch_array($resultAlumno);
	
	$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$_CURSO;
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$tipoEns;
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$sqlInstit="select * from institucion where rdb=".$institucion;
	$resultInstit=@pg_Exec($conn, $sqlInstit);
	$filaInstit=@pg_fetch_array($resultInstit);
	
	$sqlProfe="select * from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$_CURSO;
	$resultProfe=@pg_Exec($conn, $sqlProfe);
	$filaProfe=@pg_fetch_array($resultProfe);
	
	$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
    $resultEmp =@pg_Exec($conn,$qryEmp);
	$filaEmp=@pg_fetch_array($resultEmp);
	
	
?>
<SCRIPT language="JavaScript">
function enviapag(form){
			if (form.periodo.value!=0){
				form.periodo.target="self";
//				form.action = form.cmbPERIODO.value;
				
				form.action = 'modificarPlantilla.php?periodo=$periodo&creada=1';
				form.submit(true);
	
				}	
			}
			
			
			/*function enviar(form){
			//if (form.periodo.value!=0){
				//form.periodo.target="self";
//				form.action = form.cmbPERIODO.value;
				//var periodo=form.periodo.value;
				form.action = 'muestraPlantilla.php?creada=0';
				form.submit(true);
				//}	
			}*/
</SCRIPT>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<?php if($_PERFIL!=17){ ?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../../periodo/listarPeriodo.php3"><img src="../../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../feriado/listaFeriado.php3"><img src="../../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../planEstudio/listarPlanesEstudio.php3"><img src="../../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../atributos/listarTiposEnsenanza.php3"><img src="../../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../../botones/cursos_roll.gif" name="Image6" width="81" height="30" border="0" id="Image6"></a></td>
          <td width="81" height="30"><a href="../../matricula/listarMatricula.php3"><img src="../../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../../../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../periodo/listarPeriodo.php3"><!--img src="../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a--></td>
        </tr>
      </table> </td>
  </tr>
</table>
<?php } ?>

<?php if($creada!=1){//creando por 1ra vez?>
<form action="proceso_informe.php" method="post">
<?php }else{//modificando?>
<form action="muestraPlantilla.php?creada=0" method="post">
<?php } ?>
  <table width="76%" border="0" align="center">
    <tr> 
      <td><table width="100%" border="0">
          <tr> 
            <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td width="19%">&nbsp;</td>
            <td width="28%">&nbsp;</td>
          </tr>
          <tr> 
            <td width="11%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <font size="1">PERIODO</font></font></td>
            <td width="42%"><font size="2" face="Arial, Helvetica, sans-serif"> 
              : 
              <?php $sqlPeriodo="select * from periodo where id_ano=".$ano." order by nombre_periodo";
					$resultPeriodo=@pg_Exec($conn, $sqlPeriodo);
			 ?>
              <select name="periodo" onChange="enviapag(this.form);">
                <option value="0">Seleccione Periodo</option>
                <?php
				for($countPer=0 ; $countPer<@pg_numrows($resultPeriodo) ; $countPer++){
					$filaPeriodo=@pg_fetch_array($resultPeriodo, $countPer);
					if($filaPeriodo['id_periodo']==$periodo){
					echo "<option selected value=".$filaPeriodo['id_periodo'].">".$filaPeriodo['nombre_periodo']."</option>";
					}else{
					echo "<option value=".$filaPeriodo['id_periodo'].">".$filaPeriodo['nombre_periodo']."</option>";
					}
				}
				?>
              </select>
              <?php echo $periodo;?></font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; </font></td>
            <td align="right"><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php if(($creada!=1) and ($periodo!="")){?>
              <input class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' type="submit" name="Submit" value="GUARDAR">
              <?php } ?>
              <?php if($creada==1){?>
              <input class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="Submit3" value="MODIFICAR" onClick="window.location='string.php?plantilla=<? echo $filaPlantilla['id_plantilla']?>'">
              <?php } ?>
              <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="Submit2" value="LISTADO" onClick="window.location='listarAlumnos.php'">
              </font></td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr align="center" bgcolor="#003b85"> 
            <td colspan="4"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>INFORME 
              EDUCACIONAL</strong></font></td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td width="9%"><font size="2" face="Arial, Helvetica, sans-serif">Alumno</font></td>
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">: 
              <?php echo $filaAlumno['nombre_alu']. " " . $filaAlumno['ape_pat']. " " . $filaAlumno['ape_mat']?></font></td>
            <td width="5%"><font size="2" face="Arial, Helvetica, sans-serif">RUT</font></td>
            <td width="36%"><font size="2" face="Arial, Helvetica, sans-serif">: 
              <?php echo $alumno."-". $filaAlumno['dig_rut']?></font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td width="9%"><font size="2" face="Arial, Helvetica, sans-serif">Curso</font></td>
            <td width="91%"><font size="2" face="Arial, Helvetica, sans-serif">: 
              <?php echo $filaCurso['grado_curso']. "-".$filaCurso['letra_curso']."     ".$filaEns['nombre_tipo'] ?></font></td>
          </tr>
        </table>
        <?php if($tipoEns>310){?>
        <table width="100%" border="0">
          <tr> 
            <td width="14%"><font size="2" face="Arial, Helvetica, sans-serif">Especialidad</font></td>
            <td width="86%">: <font size="2" face="Arial, Helvetica, sans-serif">
              <?php $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaCurso['cod_es']." and cod_sector=".$filaCurso['cod_sector']." and cod_rama=".$filaCurso['cod_rama'];
								$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
								$filaEsp=@pg_fetch_array($resultEsp,0);
								echo $filaEsp['nombre_esp'];
								echo $modificar;?>
              </font></td>
          </tr>
        </table>
        <?php } ?>
        <table width="100%" border="0">
          <tr> 
            <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif">Establecimiento</font></td>
            <td width="83%">:<font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php echo $cmbConcepto[0]; echo $filaInstit['nombre_instit']?></font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif">Profesor 
              Jefe</font></td>
            <td width="83%"><font size="2" face="Arial, Helvetica, sans-serif">: 
              <?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_pat']?></font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td colspan="2"><font size="" face="Arial, Helvetica, sans-serif"><strong> 
              <?php if(!$filaPlantilla){
			echo "NO EXISTE UNA PLANTILLA DE EVALUACION PARA ESTE GRADO Y TIPO DE ENSEÑANZA";
			}?>
              &nbsp;</strong></font></td>
          </tr>
        </TABLE>
        <table width="100%" border="0"  cellspacing="0">
          <?php if(($creada!=1) and ($periodo!="")) {
					$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
					//trae areas
					$sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
					for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
						$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
						echo "<tr><td></td></tr>";
						echo "<tr bgcolor=\"#0099CC\"><td><font color=\"#FFFFFF\" size=2 face=Arial, Helvetica, sans-serif><strong>".$filaTraeArea['nombre']."</strong></font></td>";
						echo "<td><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
						
							//trae subareas para cada area y las imprime
							$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
							$resultTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
							for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
								$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);
								echo "<tr><td><font color=\"#0099CC\" size=2 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong>".$filaTraeSubarea['nombre']."</strong></font></td>";
								echo "<td><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
								
									//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
									$sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea'];
									$resultTraeItem=@pg_Exec($conn, $sqlTraeItem);
									for($countItem=0 ; $countItem<pg_numrows($resultTraeItem) ; $countItem++){
									$countI++;
										$filaTraeItem=@pg_fetch_array($resultTraeItem, $countItem);
										if($countItem%2==0){
											$color="#CDCDCD";
										}else{
											$color="#B5B5B5";
										}
										//PRIMERO TENGO QUE PREGUNTAR SI EL ITEM SE EVALUA CON CONCEPTOS, SI/NO(RADIO), TEXTO
										echo "<tr bgcolor=".$color."><td><font size=2 face=Arial, Helvetica, sans-serif><input name=".$filaTraeItem['glosa']." type=\"text\" id=\"txtNombrePla\" size=\"50\" maxlength=\"50\"></font></td>";
												if($filaTraeItem['tipo']==0){
													echo "<td>&nbsp;&nbsp;<SELECT name=\"cmbConcepto[".$countI."]\">";
													echo "<option value=0>Seleccione Concepto</option>"; 
															for($countConc=0 ; $countConc<@pg_numrows($resultTraeConcepto) ; $countConc++){
																$filaConc=@pg_fetch_array($resultTraeConcepto, $countConc);
																if($filaConc['id_concepto']==$cmbConcepto[$countI]){//
																	echo "<option selected value=".$filaConc['id_concepto'].">".$filaConc['nombre']."</option>";//
																}else{//
																	echo "<option value=".$filaConc['id_concepto'].">".$filaConc['nombre']."</option>";
																}//
															}//fin for($countConc.....
													echo "</select></td>";
												}else if($filaTraeItem['tipo']==2){
													if($text[$countI]!=""){
														echo "<td>&nbsp;&nbsp;<input name=\"text[".$countI."]\" type=text maxlength=200 value=".$text[$countI]."></td>";// "<td>&nbsp;&nbsp;".$text[$countI]."</td>";
													}else{
														echo "<td>&nbsp;&nbsp;<input name=\"text[".$countI."]\" type=text maxlength=200></td>";
													}
												}else if($filaTraeItem['tipo']==1){
												if($radio[$countI]!=""){
													if($radio[$countI]==1){
													echo "<td>&nbsp;&nbsp;<input type=radio name=\"radio[".$countI."]\" value=1 checked><font size=2 face=Arial, Helvetica, sans-serif>SI</font></label><label>";
													echo "<input type=radio name=\"radio[".$countI."]\" value=0 ><font size=2 face=Arial, Helvetica, sans-serif>NO</font></label></td>";
													}elseif ($radio[$countI]==0){
													echo "<td>&nbsp;&nbsp;<input type=radio name=\"radio[".$countI."]\" value=1 checked><font size=2 face=Arial, Helvetica, sans-serif>SI</font></label><label>";
													echo "<input type=radio name=\"radio[".$countI."]\" value=0 checked><font size=2 face=Arial, Helvetica, sans-serif>NO</font></label></td>";
													}
												}else{
													echo "<td>&nbsp;&nbsp;<input type=radio name=\"radio[".$countI."]\" value=1><font size=2 face=Arial, Helvetica, sans-serif>SI</font></label><label>";
													echo "<input type=radio name=\"radio[".$countI."]\" value=0><font size=2 face=Arial, Helvetica, sans-serif>NO</font></label></td>";
												}
												}
									}//fin for($countItem....
							}//fin for($countSubarea....
							
					}//fin for($countArea....
			}//fin if($creada!=1)
			
			if($creada==1){
			//$countI=0;
				$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
					//trae areas
					$sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
					for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
						$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
						echo "<tr><td></td></tr>";
						echo "<tr bgcolor=\"#0099CC\"><td>AREA: ".$filaTraeArea['id_area']."<input name=\"AREA[\"".$filaTraeArea['id_area']."\"] type=\"text\" id=\"txtNombrePla\" size=\"50\" maxlength=\"50\" value=\"".trim($filaTraeArea['nombre'])."\"></td>";
						echo "<td><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
						
							//trae subareas para cada area y las imprime
							$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
							$resultTraeSubarea=pg_Exec($conn, $sqlTraeSubarea);
							for($countSubarea=0 ; $countSubarea<pg_numrows($resultTraeSubarea) ; $countSubarea++){
								$filaTraeSubarea=pg_fetch_array($resultTraeSubarea, $countSubarea);
								echo "<tr><td>SUBAREA:".$filaTraeSubarea['id_subarea']." <input name=\"SUBAREA[\"".$filaTraeSubarea['id_subarea']."\" type=\"text\" id=\"txtNombrePla\" size=\"50\" maxlength=\"50\" value=\"".trim($filaTraeSubarea['nombre'])."\"></td>";
								echo "<td><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
								
									//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
									$sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea'];
									$resultTraeItem=pg_Exec($conn, $sqlTraeItem);
									
									for($countItem=0 ; $countItem<pg_numrows($resultTraeItem) ; $countItem++){
									$countI++;
										$filaTraeItem=pg_fetch_array($resultTraeItem, $countItem);
										//PRIMERO TENGO QUE PREGUNTAR SI EL ITEM SE EVALUA CON CONCEPTOS, SI/NO(RADIO), TEXTO
										
										if($countItem%2==0){
											$color="#CDCDCD";
										}else{
											$color="#B5B5B5";
										}
										//echo "<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'><td><font size=2 face=Arial, Helvetica, sans-serif>".$filaTraeItem['glosa']."</font></td>";
										echo "<tr bgcolor=\"".$color."\"><td>ITEM:".$filaTraeItem['id_item']."<input name=\"item[\"".$filaTraeItem['id_item']."\" type=\"text\" id=\"txtNombrePla\" size=\"50\" maxlength=\"50\" value=\"".trim($filaTraeItem['glosa'])."\"></td>";
												if($filaTraeItem['tipo']==0){
													$sqlTraeEval="select * from informe_evaluacion where id_item=".$filaTraeItem['id_item']." and id_ano=".$ano." and id_periodo=".$periodo." and rut_alumno='".$alumno."'";
													$resultEval=@pg_Exec($conn, $sqlTraeEval);
													$filaEval=@pg_fetch_array($resultEval,0);
													
													$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
													$resultConc=@pg_Exec($conn, $sqlTraeConc);
													$filaConc=@pg_fetch_array($resultConc,0);
													
													echo "<td>&nbsp;&nbsp;";
													echo "<input type=\"hidden\" name=\"cmbConcepto[".$countI."]\" value=".$filaConc['id_concepto'].">";
													echo "<font size=2 face=Arial, Helvetica, sans-serif>".$filaConc['nombre']."</font>";
													echo "</td>";
												}else if($filaTraeItem['tipo']==2){
													$sqlTraeEval="select * from informe_evaluacion where id_item=".$filaTraeItem['id_item']." and id_ano=".$ano." and id_periodo=".$periodo." and rut_alumno='".$alumno."'";
													$resultEval=@pg_Exec($conn, $sqlTraeEval);
													$filaEval=@pg_fetch_array($resultEval,0);
													echo "<input type=\"hidden\" name=\"text[".$countI."]\" value=".$filaEval['text'].">";
													echo "<td><font size=2 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;".$filaEval['text']."</font></td>";
												}else if($filaTraeItem['tipo']==1){
													$sqlTraeEval="select * from informe_evaluacion where id_item=".$filaTraeItem['id_item']." and id_ano=".$ano." and id_periodo=".$periodo." and rut_alumno='".$alumno."'";
													$resultEval=@pg_Exec($conn, $sqlTraeEval);
													$filaEval=@pg_fetch_array($resultEval,0);
													echo "<input type=\"hidden\" name=\"radio[".$countI."]\" value=".$filaEval['radio'].">";
														if(($filaEval['radio']==0) and ($filaEval['radio']!="")){
															echo "<td><font size=2 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;No</font></td>";	
														}else if($filaEval['radio']==1){
															echo "<td><font size=2 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;Si</font></td>";
														}
												}
											
									}//fin for($countItem....
							}//fin for($countSubarea....
							
					}//fin for($countArea....
			}//fin if($creada==1)
			
		  ?>
          <input name="plantilla" type="hidden" value="<?php echo $filaPlantilla['id_plantilla']?>">
          <input name="alumno" type="hidden" value="<?php echo $alumno?>">
        </table>
        <table width="100%" border="0">
          <tr> 
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="003b85">
          <tr> 
            <td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp; 
              Observaciones:</strong></font></td>
          </tr>
        </table>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td ><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php if($creada!=1){
		  			if($txtO!=""){
						echo "<TEXTAREA NAME=txtObs ROWS=20 COLS=60>";
						print trim($txtO);
						echo "</TEXTAREA>";
					}elseif ($filaPlantilla){
            			echo "<TEXTAREA NAME=txtObs ROWS=20 COLS=60></TEXTAREA>";
					}
				}elseif ($creada==1){;
					$sqlTraeObs="select * from informe_observaciones where id_periodo=".$periodo." and id_ano=".$ano." and id_plantilla=".$filaPlantilla['id_plantilla']." and rut_alumno='".$alumno."'";
					$resultObs=@pg_Exec($conn, $sqlTraeObs);
					$filaObs=@pg_fetch_array($resultObs,0);
					echo nl2br (trim($filaObs['glosa']));
					//echo "<input type=\"hidden\" name=\"txtO\" value=".$filaObs['glosa'].">";
					echo "<input type=\"hidden\" name=\"txtO\" value=\"".trim($filaObs['glosa'])."\">";
				}
			?>
              &nbsp;</font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td align="right"><font size="2" face="Arial, Helvetica, sans-serif">
              <?php //echo getdate() ?>
              <input type="hidden" name="fecha">
              <input type="hidden" name="tipoEns" value="<?php echo $tipoEns ?>">
              <input type="hidden" name="grado" value="<?php echo $grado ?>">
              <?php 
			if($creada!=1){//creando por 1ra vez
			$modificar=0;
			}
				if(($creada==0) and ($cmbConcepto[1]!="")){
			$modificar=1;
			}
			?>
              <input type="hidden" name="modificar" value="<?php echo $modificar ?>">
              </font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td width="45%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
              <?php // echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_pat']?>
              &nbsp;</strong></font></td>
            <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
              <?php //echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_pat']?>
              &nbsp;</strong></font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr align="center"> 
            <td width="45%">&nbsp;</td>
            <td width="55%">&nbsp;</td>
          </tr>
        </table> 
        <table width="100%" border="0">
          <tr> 
            <td align="center"></td>
          </tr>
        </table>
        <table width="100%">
          <!--tr> 
          <td align="center" bgcolor="#003B85"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ESCALA 
            DE EVALUACI&Oacute;N / AREAS DE DESARROLLO</font></strong></td>
        </tr-->
          <tr> </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <?php 
			/*$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
			$resultConc=pg_Exec($conn, $sqlConc);
			for($countConc=0 ; $countConc<pg_numrows($resultConc) ; $countConc++){
				$filaConc=pg_fetch_array($resultConc,$countConc);
				echo"<tr><td><font size=2 face=Arial, Helvetica, sans-serif>".$filaConc['nombre']."</font></td>";
				echo "<td><font size=2 face=Arial, Helvetica, sans-serif>:</font></td>";
				echo "<td><font size=2 face=Arial, Helvetica, sans-serif>".$filaConc['glosa']."</font><td></tr>";
			}		*/
		?>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
