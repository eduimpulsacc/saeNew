<?php 
//require('../../../../../util/header.inc');
include"../Coneccion/conexion.php";

$ano		=$_ANO;
$conn		=$conexion;

$alumno=$as_alumno;
$institucion=$as_institucion;
$id_periodo=$ai_periodo;

	$sqlAno="select * from ano_escolar where id_institucion=".$institucion." and nro_ano=".$ai_ano;
	$resultAno=@pg_exec($conn, $sqlAno);
	$filaAno=@pg_fetch_array($resultAno,0);
	

	$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$filaAno['id_ano']." and matricula.id_curso=curso.id_curso";
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

	$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$filaMatri['ensenanza']." AND ".$gr."=1 AND rdb=".$institucion;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);
	
	$sqlTraeAlumno="SELECT * FROM alumno WHERE rut_alumno=".$alumno;
	$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
	$filaAlumno=@pg_fetch_array($resultAlumno);
	
	$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$filaMatri['id_curso'];
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$filaMatri['ensenanza'];
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$sqlInstit="select * from institucion where rdb=".$institucion;
	$resultInstit=@pg_Exec($conn, $sqlInstit);
	$filaInstit=@pg_fetch_array($resultInstit);
	
	$sqlProfe="select * from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$filaMatri['id_curso'];
	$resultProfe=@pg_Exec($conn, $sqlProfe);
	$filaProfe=@pg_fetch_array($resultProfe);
	
	$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
    $resultEmp =@pg_Exec($conn,$qryEmp);
	$filaEmp=@pg_fetch_array($resultEmp);
	
	
?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="proceso_informe.php" method="post">
<table width="76%" border="0" align="center">
  <tr> 
    <td><table width="100%" border="0">
        <tr> 
          <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td width="19%">&nbsp;</td>
          <td width="28%">&nbsp;</td>
        </tr>
        <tr> 
            <td width="11%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>  
            <td width="42%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              </font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; </font></td>  <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; </font></td>
        </tr>
        <tr> 
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr align="center" bgcolor="#003b85"> 
            <td colspan="4"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong>INFORME 
              EDUCACIONAL <?php $sqlPer="select * from periodo where id_periodo=".$id_periodo;
			  				$resultPer=@pg_exec($conn, $sqlPer);
							$filaPer=@pg_fetch_array($resultPer,0);
							echo $filaPer['nombre_periodo'];
			   ?></strong></font></td>
        </tr>
        <tr> 
          <td colspan="4">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="9%"><font size="1" face="Arial, Helvetica, sans-serif">Alumno</font></td>
          <td width="50%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaAlumno['nombre_alu']. " " . $filaAlumno['ape_pat']. " " . $filaAlumno['ape_mat']?></font></td>
          <td width="5%"><font size="1" face="Arial, Helvetica, sans-serif">RUT</font></td>
          <td width="36%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $alumno."-". $filaAlumno['dig_rut']?></font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="9%"><font size="1" face="Arial, Helvetica, sans-serif">Curso</font></td>
          <td width="91%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaCurso['grado_curso']. "-".$filaCurso['letra_curso']."     ".$filaEns['nombre_tipo'] ?></font></td>
        </tr>
      </table>
	  <?php if($filaMatri['ensenanza']>310){?>
      <table width="100%" border="0">
        <tr> 
          <td width="14%"><font size="1" face="Arial, Helvetica, sans-serif">Especialidad</font></td>
            <td width="86%">: <font size="1" face="Arial, Helvetica, sans-serif">
			<?php $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaMatri['cod_es']." and cod_sector=".$filaMatri['cod_sector']." and cod_rama=".$filaMatri['cod_rama'];
								$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
								$filaEsp=@pg_fetch_array($resultEsp,0);
								echo $filaEsp['nombre_esp'];?></font></td>
        </tr>
      </table>
	  <?php } ?>
      <table width="100%" border="0">
        <tr> 
          <td width="17%"><font size="1" face="Arial, Helvetica, sans-serif">Establecimiento</font></td>
          <td width="83%">:<font size="1" face="Arial, Helvetica, sans-serif"> <?php echo $filaInstit['nombre_instit']?></font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="17%"><font size="1" face="Arial, Helvetica, sans-serif">Profesor 
            Jefe</font></td>
          <td width="83%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_pat']?></font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
      </TABLE>
 <table width="100%" cellspacing="0" border="1" bordercolor="#999999">
 <tr>
 <td>
 
          <table width="100%">
        <?php 
				$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
					//trae areas
					$sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
					for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
						$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
						echo "<tr><td></td></tr>";
						//echo "<tr bgcolor=\"#0099CC\"><td valign=bottom><font color=\"#FFFFFF\" size=1 face=Arial, Helvetica, sans-serif><strong>".$filaTraeArea['nombre']."</strong></font></td>";
						echo "<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif><strong>".$filaTraeArea['nombre']."</strong></font></td>";
						echo "<td valign=bottom><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
						
							//trae subareas para cada area y las imprime
							$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
							$resultTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
							for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
								$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);
								//echo "<tr><td valign=bottom><font color=\"#0099CC\" size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong>".$filaTraeSubarea['nombre']."</strong></font><hr></td>";
								echo "<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong>".$filaTraeSubarea['nombre']."</strong></font><hr noshade></td>";
								echo "<td valign=bottom><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
								
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
										echo "<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>".$filaTraeItem['glosa']."</font><hr size=\"1\"></td>";
												if($filaTraeItem['tipo']==0){
													$sqlTraeEval="select * from informe_evaluacion where id_item=".$filaTraeItem['id_item']." and id_ano=".$filaMatri['id_ano']." and id_periodo=".$id_periodo." and rut_alumno='".$alumno."'";
													$resultEval=@pg_Exec($conn, $sqlTraeEval);
													$filaEval=@pg_fetch_array($resultEval,0);
													
													$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
													$resultConc=@pg_Exec($conn, $sqlTraeConc);
													$filaConc=@pg_fetch_array($resultConc,0);
													
													echo "<td valign=bottom>&nbsp;&nbsp;";
													echo "<font size=1 face=Arial, Helvetica, sans-serif>".$filaConc['nombre']."</font>";
													echo "<hr size=\"1\"></td>";
												}else if($filaTraeItem['tipo']==2){
													$sqlTraeEval="select * from informe_evaluacion where id_item=".$filaTraeItem['id_item']." and id_ano=".$filaMatri['id_ano']." and id_periodo=".$id_periodo." and rut_alumno='".$alumno."'";
													$resultEval=@pg_Exec($conn, $sqlTraeEval);
													$filaEval=@pg_fetch_array($resultEval,0);
													echo "<td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;".$filaEval['text']."</font><hr size=\"1\"></td>";
												}else if($filaTraeItem['tipo']==1){
													$sqlTraeEval="select * from informe_evaluacion where id_item=".$filaTraeItem['id_item']." and id_ano=".$filaMatri['id_ano']." and id_periodo=".$id_periodo." and rut_alumno='".$alumno."'";
													$resultEval=@pg_Exec($conn, $sqlTraeEval);
													$filaEval=@pg_fetch_array($resultEval,0);
														if(($filaEval['radio']==0) and ($filaEval['radio']!="")){
															echo "<td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;No</font><hr size=\"1\"></td>";	
														}else if($filaEval['radio']==1){
															echo "<td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;Si</font><hr size=\"1\"></td>";
														}
												}
											
									}//fin for($countItem....
							}//fin for($countSubarea....
							
					}//fin for($countArea....
			
		  ?>
		  <input name="plantilla" type="hidden" value="<?php echo $filaPlantilla['id_plantilla']?>">
		  <input name="alumno" type="hidden" value="<?php echo $alumno?>">
      </table>
	  </td>
	  </tr>
	  </table>
        <table width="100%" border="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="003b85">
          <tr> 
            <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp; Observaciones:</strong></font></td>
        </tr>
      </table>
        <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0">
          <tr> 
          <td ><font size="1" face="Arial, Helvetica, sans-serif"> 
		  <?php 
					$sqlTraeObs="select * from informe_observaciones where id_periodo=".$id_periodo." and id_ano=".$filaMatri['id_ano']." and id_plantilla=".$filaPlantilla['id_plantilla']." and rut_alumno='".$alumno."'";
					$resultObs=@pg_Exec($conn, $sqlTraeObs);
					$filaObs=@pg_fetch_array($resultObs,0);
					echo $filaObs['glosa'];
			?>
            &nbsp;</font></td>
        </tr>
      </table>
        <table width="100%" border="0">
          <tr> 
            <td>&nbsp; </td>
        </tr>
        <tr> 
            <td>&nbsp;</td>
        </tr>
        <tr> 
            <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><hr size="1"></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="right"><font size="2" face="Arial, Helvetica, sans-serif">fecha:<?php echo getdate() ?>
            <input type="hidden" name="fecha">
			<input type="hidden" name="tipoEns" value="<?php echo $tipoEns ?>">
			<input type="hidden" name="grado" value="<?php echo $grado ?>">
			<!--input type="hidden" name="periodo" value="<?php echo $periodo ?>"-->
            </font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="45%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_pat']?>&nbsp;</strong></font></td>
          <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_pat']?>&nbsp;</strong></font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr align="center"> 
          <td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">PROFE 
            JEFE</font></td>
          <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">JEFE 
            ESTABLECIMIENTO</font></td>
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
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">ORIENTADOR</font></td>
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
        <tr>
        </tr>

      </table>

	  <table width="100%" border="0">
        <tr>
        <?php 
			$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
			$resultConc=@pg_Exec($conn, $sqlConc);
			for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
				$filaConc=@pg_fetch_array($resultConc,$countConc);
				echo"<tr><td><font size=1 face=Arial, Helvetica, sans-serif>".$filaConc['nombre']."</font></td>";
				echo "<td><font size=1 face=Arial, Helvetica, sans-serif>:</font></td>";
				echo "<td><font size=1 face=Arial, Helvetica, sans-serif>".$filaConc['glosa']."</font><td></tr>";
			}		
		?>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
