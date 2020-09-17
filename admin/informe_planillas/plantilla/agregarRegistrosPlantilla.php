
<?php 
require('../../../../util/header.inc');
//$plantilla	=$_PLANTILLA;
$institucion =$_INSTIT;
$ano		=$_ANO;
//$modificar= $_GET[modificar];
		/*if(session_is_registered('_PLANTILL')){
			session_unregister('_CURSO');
		};*/
echo $hiddenPlantilla;
if($grado==1) $gr="pa";
if($grado==2) $gr="sa";
if($grado==3) $gr="ta";
if($grado==4) $gr="cu";
if($grado==5) $gr="qu";
if($grado==6) $gr="sx";
if($grado==7) $gr="sp";
if($grado==8) $gr="oc";

	//$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=110 AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE id_plantilla=".$hiddenPlantilla;
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
/*function enviapag(form){
			if (form.periodo.value!=0){
				form.periodo.target="self";
//				form.action = form.cmbPERIODO.value;
				
				form.action = 'modificarPlantilla.php?periodo=$periodo&creada=1';
				form.submit(true);
	
				}	
}*/
			
			
			function enviar(form){
			//if (form.periodo.value!=0){
				//form.periodo.target="self";
//				form.action = form.cmbPERIODO.value;
				
				form.action = 'string1.php';
				form.submit(true);
	
				//}	
			}
</SCRIPT>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<?php if($_PERFIL!=17){?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../../ano/periodo/listarPeriodo.php3"><img src="../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../ano/feriado/listaFeriado.php3"><img src="../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../planEstudio/listarPlanesEstudio.php3"><img src="../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../atributos/listarTiposEnsenanza.php3"><img src="../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../ano/curso/listarCursos.php3"><img src="../../botones/cursos.gif" name="Image6" width="81" height="30" border="0" id="Image6"onMouseOver="MM_swapImage('Image6','','../../botones/cursos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../ano/matricula/listarMatricula.php3"><img src="../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../botones/informe_roll.gif" name="Image0" width="81" height="30" border="0" id="Image0" ></a></td>
		  <td width="81" height="30"><a href="../../ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../ano/ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>
<?php } ?>

<?php //if($creada!=1){//creando por 1ra vez?>
<!-- <form action="proceso_informe.php" method="post">
 --><?php //}else{//modificando?>
<!-- <form action="muestraPlantilla.php?creada=0" method="post">
 --><?php //} ?><form action="" method="post">
  <table width="76%" border="0" align="center">
    <tr> 
      <td><table width="100%" border="0">
          <tr> 
            <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td width="32%">&nbsp;</td>
            <td width="17%">&nbsp;</td>
          </tr>
          <tr> 
            <td width="10%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              </font></td>
            <td width="41%"><font size="2" face="Arial, Helvetica, sans-serif"> <input name="nroplantilla" type="hidden" value="<? $filaPlantilla['id_plantilla']?>">
              <?php $sqlPeriodo="select * from periodo where id_ano=".$ano." order by nombre_periodo";
					$resultPeriodo=@pg_Exec($conn, $sqlPeriodo);
			 ?>
              <!--               <select name="periodo" onChange="enviapag(this.form);">
                <option value="0">Seleccione Periodo</option>
 -->
              <?php /*
				for($countPer=0 ; $countPer<@pg_numrows($resultPeriodo) ; $countPer++){
					$filaPeriodo=@pg_fetch_array($resultPeriodo, $countPer);
					if($filaPeriodo['id_periodo']==$periodo){
					echo "<option selected value=".$filaPeriodo['id_periodo'].">".$filaPeriodo['nombre_periodo']."</option>";
					}else{
					echo "<option value=".$filaPeriodo['id_periodo'].">".$filaPeriodo['nombre_periodo']."</option>";
					}
				}*/
				?>
              <!--               </select>
 -->
              <?php echo $periodo;?></font></td>
            <td align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              </font></td>
            <td align="right"><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php if(($creada!=1) and ($periodo!="")){?>
              <?php } ?>
              <?php //if($creada==1){?>
              <?php //} ?>
              </font></td>
          </tr>
          <tr align="right"> 
            <td colspan="4"> 
              <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="Submit2" value="LISTADO" onClick="window.location='listaPlantillas.php?botonera=1'">
              &nbsp;</td>
          </tr>
          <tr align="center" bgcolor="#003b85"> 
            <td colspan="4"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>AGREGAR 
              REGISTROS A INFORME EDUCACIONAL</strong></font></td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td><font size="2" face="Arial, Helvetica, sans-serif">Debe seleccionar 
              que tipo de informacion desea agregar:</font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td><a href="plantilla.php?plantilla=<?php echo $hiddenPlantilla;?>"><font size="2" face="Arial, Helvetica, sans-serif">Agregar 
              AREAS</font></a></td>
          </tr>
          <tr>
            <td><a href="plantillaPaso2.php?plantilla=<?php echo $hiddenPlantilla;?>"><font size="2" face="Arial, Helvetica, sans-serif">Agregar 
              SUBAREAS</font></a></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td><a href="plantillaPaso2.php?plantilla=<?php echo $hiddenPlantilla;?>"><font size="2" face="Arial, Helvetica, sans-serif">Agregar 
              ITEMES</font></a></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td height="21">&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td colspan="2"><font size="" face="Arial, Helvetica, sans-serif"><strong> 
              </strong></font></td>
          </tr>
        </TABLE>
        
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
