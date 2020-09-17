<?php 
include"../Coneccion/conexion.php";

$ano		= $_ANO;
$conn		= $conexion;
$curso		= $c_curso;
$alumno		= $c_alumno;
$institucion= $_INSTIT;

//if ($c_alumno==0)
// exit;

	$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultDIR =@pg_Exec($conn,$qryDIR);
	$filaDIR=@pg_fetch_array($resultDIR);

	$qryORI="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=20)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultORI =@pg_Exec($conn,$qryORI);
	$filaORI=@pg_fetch_array($resultORI);

//	$sqlPeriodo="select nombre_periodo from periodo where id_ano=".$ano." order by nombre_periodo asc";
	$sqlPeriodo="select nombre_periodo from periodo where id_periodo=".$periodo;
	$resultPeriodo=@pg_exec($conn, $sqlPeriodo);

	
	$sqlInstit="select * from institucion where rdb=".$institucion;
	$resultInstit=@pg_Exec($conn, $sqlInstit);
	$filaInstit=@pg_fetch_array($resultInstit);
	
	$sql_reg="select nom_reg from region where cod_reg =". $filaInstit['region'];
	$res_reg = pg_exec($conn, $sql_reg);
	$fila_reg = pg_fetch_array($res_reg);
	
	$sql_pro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro =".$filaInstit['ciudad'];
	$res_pro=pg_exec($conn, $sql_pro);
	$fila_pro = pg_fetch_array($res_pro);
	
	$sql_com="select nom_com from comuna where cod_reg=". $filaInstit['region'] ." and cor_pro =".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
	$res_com=pg_exec($conn, $sql_com);
	$fila_com = pg_fetch_array($res_com);
		
	$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
    $resultEmp =@pg_Exec($conn,$qryEmp);
	$filaEmp=@pg_fetch_array($resultEmp);
	
	$sql_ano="select nro_ano from ano_escolar where id_ano=".$_ANO;
    $res_ano =@pg_Exec($conn,$sql_ano);
	$filaAno=@pg_fetch_array($res_ano);
	
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

<div id="capa0">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
      <td> <div align="right">
          <input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="botonX" 
		id="cmdimprimiroriginal" 
		onclick="imprimir1();" 
		value="Imprimir">
        </div></td>
  </tr>
</table>
</div>

<script>

function imprimir1() 
{
	document.getElementById("capa0").style.display='none';
	//document.getElementById("capa2").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
	//document.getElementById("capa2").style.display='block';
	
}
function imprimir2() 
{
	document.getElementById("capa0").style.display='none';
	document.getElementById("capa1").style.display='none';
	
	window.print();
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
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
	$filaPlantilla=@pg_fetch_array($resultPlantilla);
	
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
?>

<form action="proceso_informe.php" method="post">
<?php  $filaPlantilla['id_plantilla'];
//
//
//***AJUSTA EL ANCHO DE LA PAGINA PARA IMPRIMIR MAS A LA IZQUIERDA LA PLANTILLA CUANDOI ES HORIZONTAL
//
//
 if($filaPlantilla['orientacion']==0){ ?>
			<table width="76%" border="0" align="center">
<?	 	}else if($filaPlantilla['orientacion']==1){	?>
			<table width="90%" border="0" align="center">
<?		} ?>
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
          <td colspan="4">
<div id="capa0">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> 
	<!--input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="botonZ" 
		id="cmdimprimiroriginal" 
		onclick="imprimir1();" 
		value="Imprimir parte1">
		 <input 
		name="cmdimprimiroriginal2" 
		type="button" 
		class="botonZ" 
		id="cmdimprimiroriginal2" 
		onclick="imprimir2();" 
		value="Imprimir parte2"--> 
	</td>
  </tr>
</table>
</div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
			<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);?>  
    <td width="119" rowspan="6"><div align="center"><img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE" height="100"></div></td>
	<? }?>
<!--     <td width="404"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><? echo $nombre_institu;?></strong></font></td>
		<? /*
		$result = @pg_Exec($conn,"select * from alumno where rut_alumno=".$alumno);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['foto']))
		{
			$output= "select lo_export(".$arr['foto'].",'/var/www/html/tmp/".$arr[rut_alumno]."');";
			$retrieve_result = @pg_exec($conn,$output);*/?>  		
    <td width="119" rowspan="6"><div align="center"><img src=../../../../../../../tmp/<? echo $alumno ?> ALT="FOTO"  height="100"></div></td>
 -->	<? /*}*/?>
  </tr>
              <tr> 
                <td width="405" rowspan="5">&nbsp;</td>
                <td width="191">&nbsp;</td>
                <td width="78"><strong><font size="1" face="Arial, Helvetica, sans-serif">REGION</font></strong></td>
                <td width="297"><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                  <? echo $fila_reg['nom_reg']?></font></strong></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><strong><font size="1" face="Arial, Helvetica, sans-serif">PROVINCIA</font></strong></td>
                <td><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                  <? echo $fila_pro['nom_pro']?></font></strong></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><strong><font size="1" face="Arial, Helvetica, sans-serif">COMUNA</font></strong></td>
                <td><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                  <? echo $fila_com['nom_com']?></font></strong></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><strong><font size="1" face="Arial, Helvetica, sans-serif">A&Ntilde;O 
                  ESCOLAR</font></strong></td>
                <td><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                  <? echo $filaAno['nro_ano']?></font></strong></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><strong><font size="1" face="Arial, Helvetica, sans-serif">RBD</font></strong></td>
                <td><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                  <?php echo $filaInstit['rdb']," - ",$filaInstit['dig_rdb']?></font></strong></td>
              </tr>
              <tr> 
                <td colspan="3">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>

</td>
        </tr>
        <tr align="center" bgcolor="#003b85"> 
            <td colspan="4"></td>
        </tr>
      </table>
	  <div id="capa1">
        <table width="100%" border="0" align="center">
          <tr> 
            <td align="center" bgcolor="#003b85"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>INFORME 
                DE DESARROLLO PERSONAL Y SOCIAL</strong></font><font size="2">&nbsp;</font></div></td>
          </tr>
          <tr> 
            <td align="center" bgcolor="#003b85"> <strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              <?php for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
						$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
						/*if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE") $per="1 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE") $per="3 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE") $per="1 Sem.";
						if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE") $per="2 Sem.";*/
						
						echo $filaPeriodo['nombre_periodo'] ; }?>
              &nbsp;</font></strong></td>
          </tr>
        </table>
          <table width="100%" border="0">
            <tr> 
              
            <td align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <?php echo trim($filaInstit['nombre_instit']);?></font></strong></td>
            </tr>
          </table>
		  <table width="100%" border="0">
            <tr valign="middle"> 
              <td width="23%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">Res. 
                Exta. de Educaci&oacute;n N&ordm; <?php echo $filaInstit['nu_resolucion']?> 
                de fecha 
                <?php impF($filaInstit['fecha_resolucion'])?>
                Rol Base de Datos <?php echo $filaInstit['rdb']," - ",$filaInstit['dig_rdb']?> 
                </font></strong></td>
            </tr>
          </table>
        <table width="100%" border="0">
          <tr> 
            <td colspan="4"><hr noshade color="#000000"></td>
          </tr>
		  </table>          
        <table width="100%" border="0">
          <tr> 
            <td width="9%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Alumno</font></strong></td>
            <td width="39%"><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
              <?php echo $filaAlumno['nombre_alu']. " " . $filaAlumno['ape_pat']. " " . $filaAlumno['ape_mat']?></font></strong></td>
            <td width="5%"><strong><font size="1" face="Arial, Helvetica, sans-serif">RUT</font></strong></td>
            <td width="47%"><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
              <?php echo $alumno."-". $filaAlumno['dig_rut']?></font></strong></td>
          </tr>
        </table>
        <table width="100%" height="10%">
          <tr > 
            <td width="9%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Curso</font></strong></td>
            <td width="91%" height="20"><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
              <?php echo $filaCurso['grado_curso']. " - ".$filaCurso['letra_curso']."     ".$filaEns['nombre_tipo'] ?></font></strong></td>
          </tr>
        </table>
	  <?php if($filaMatri['ensenanza']>310){?>
        <table width="100%" border="0">
          <tr> 
            <td width="10%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Especialidad</font></strong></td>
            <td width="90%"><strong>: <font size="1" face="Arial, Helvetica, sans-serif"> 
              <?php $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaMatri['cod_es']." and cod_sector=".$filaMatri['cod_sector']." and cod_rama=".$filaMatri['cod_rama'];
								$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
								$filaEsp=@pg_fetch_array($resultEsp,0);
								echo $filaEsp['nombre_esp'];?>
              </font></strong></td>
          </tr>
        </table>
	  <?php } ?>
<!--                 <?php //echo $filaInstit['nombre_instit']?></font></td>
        </tr>
 -->        <!-- <table width="100%" border="0">
        <tr> 
          <td width="10%"><font size="1" face="Arial, Helvetica, sans-serif">Establecimiento</font></td>
          <td width="90%">:<font size="1" face="Arial, Helvetica, sans-serif"> <?php /* echo $filaInstit['nombre_instit']*/?></font></td>
        </tr>
      </table> -->
        
          
        <table width="100%" border="0">
          <tr> 
            <td width="13%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Profesor 
              (a) Jefe</font></strong></td>
            <td width="32%"><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
              <?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?></font></strong></td>
            <td width="11%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Orientador 
              (a)</font></strong></td>
            <td width="44%"><strong>:<?php echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat']?>&nbsp;</strong></td>
          </tr>
          <tr> 
            <td><strong><font size="1" face="Arial, Helvetica, sans-serif">Fecha</font></strong></td>
            <td><strong><font size="1" face="Arial, Helvetica, sans-serif"> : 
              <?php setlocale ("LC_TIME", "es_ES"); echo (strftime("%d de %B de %Y")); ?>
              &nbsp;</font></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <hr noshade color="#000000">
        <table width="100%" border="0">
        <tr> 
        </tr>
      </TABLE>
 
<!--           <table width="630"> -->
<?php //if($filaPlantilla['orientacion']==0){?>
          <table width="630">
        
						<tr><td></td>
		 <?php				/*for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
						$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
						if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE") $per="1 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE") $per="3 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE") $per="1 Sem.";
						if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE") $per="2 Sem.";
						echo "<td align=\"center\"><font size=1 face=Arial, Helvetica, sans-serif>".$per."</font></td>";
						
						}echo "</tr>";*/
				$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
					//trae areas
					$sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
					for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
						$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
						$nroA=$countArea+1;	?>
						<tr><td><font face=Arial, Helvetica, sans-serif></font></td></tr>					
						<tr><td><font face=Arial, Helvetica, sans-serif></font></td></tr>					
						<tr><td><font face=Arial, Helvetica, sans-serif></font></td></tr>					
						<tr><td valign=bottom valing=top><font size=1 face=Arial, Helvetica, sans-serif><strong><? echo $filaTraeArea['nombre'];?></strong></font><hr noshade color="#000000"></td>
<? //						echo "<td valign=bottom><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
						
							//trae subareas para cada area y las imprime
							$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
							$resultTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
							for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
							$nroS=$countSubarea+1;
								$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);	?>
								<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif style="text-decoration:underline">&nbsp;&nbsp;&nbsp;<strong><? echo "".$nroA." -  ".$filaTraeSubarea['nombre'];?></strong></font></td></tr>
								
<?									//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
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
										}	?>
										<tr><td valign=bottom height=1>
										
										
<?										if(($filaTraeItem['tipo']==1) or ($filaTraeItem['tipo']==2) and ($countItem!=0)){
										}
										
										$nroI=$countItem+1;	?>
										<font size=1 face=Arial, Helvetica, sans-serif><? echo trim($filaTraeItem['glosa']);?> </font>
										
<?										if($filaTraeItem['tipo']==0){
										}	?>
										</td>
											
<?												if($filaTraeItem['tipo']==0){
												//  $sqlP="select * from periodo where id_ano=".$ano;
												$sqlP="select * from periodo where id_periodo=".$periodo;
												   $resultP=@pg_Exec($conn, $sqlP);
												  // $sqlTraeEval="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']."and periodo.id_periodo='".$filaP['id_periodo']."' and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo";
												  // $filaP=@pg_fetch_array($resultP,$countEval);
												   for($countEval=0 ; $countEval<pg_numrows($resultP) ; $countEval++){
												   $filaP=@pg_fetch_array($resultP,$countEval);
													$sqlTraeEval="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']."and periodo.id_periodo='".$filaP['id_periodo']."' and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo";
													$resultEval=@pg_Exec($conn, $sqlTraeEval);
													$filaEval=@pg_fetch_array($resultEval,0);
														$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
														$resultConc=@pg_Exec($conn, $sqlTraeConc);
														$filaConc=@pg_fetch_array($resultConc,0);	?>
														
														<td valign=bottom>&nbsp;&nbsp;
														<font size=1 face=Arial, Helvetica, sans-serif><? echo trim($filaConc['sigla']);?></font></td>

<?													}
												}else if($filaTraeItem['tipo']==2){
													$sqlTraeEvalu="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo asc";
													$resultEvalu=@pg_Exec($conn, $sqlTraeEvalu);
													for($countEvalu=0 ; $countEvalu<pg_numrows($resultEvalu) ; $countEvalu++){
														$filaEvalu=pg_fetch_array($resultEvalu,$countEvalu);	?>
														<tr><td valign=bottom>
														<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo "".$filaEvalu['nombre_periodo'].":&nbsp;&nbsp".$filaEvalu['text']."";?></td></tr>
														<tr><td bgcolor="#0099FF" ></td></tr>
<?													}
												}else if($filaTraeItem['tipo']==1){
													$sqlTraeEvalua="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo asc";
													$resultEvalua=@pg_Exec($conn, $sqlTraeEvalua);
													for($countEvalua=0 ; $countEvalua<pg_numrows($resultEvalua) ; $countEvalua++){
														$filaEvalua=@pg_fetch_array($resultEvalua,$countEvalua);
														if(($filaEvalua['radio']==0) and ($filaEvalua['radio']!="")){	?>
																<tr><td valign=bottom>
																<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalua['nombre_periodo'];?>:&nbsp;&nbsp;No</font></td></tr>	
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
							
					}//fin for($countArea....
									
	
		  ?>
		  <input name="plantilla" type="hidden" value="<?php echo $filaPlantilla['id_plantilla']?>">
		  <input name="alumno" type="hidden" value="<?php echo $alumno?>">
      </table>
	  
	  <?php /*}else if($filaPlantilla['orientacion']==1){
	  //
	  //
	  //***IMPRESION SI LA PLANTILLA ES HORIZONTAL
	  //
	  //
	  ?>
	  
	  
	            <table width="430">
        <?php 	$itemes=1;
				$subareas=1;
				$areas=1;
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
						
						if($itemes==20){
						echo "<tr><td>$total&nbsp;</td></tr>";
						}
						echo "<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif><strong>".$filaTraeArea['nombre']."</strong></font></td>";
						echo "<td valign=bottom><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
						
							//trae subareas para cada area y las imprime
							$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
							$resultTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
							for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
								$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);
								echo "<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong>".$filaTraeSubarea['nombre']."</strong></font></td><tr><td bgcolor=\"#000000\" ></td></tr>";
								
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
										echo "<tr><td valign=bottom>";
										
										
										if(($filaTraeItem['tipo']==1) or ($filaTraeItem['tipo']==2) and ($countItem!=0)){
										}
										
										
										echo $total,"<font size=1 face=Arial, Helvetica, sans-serif>".trim($filaTraeItem['glosa'])."</font>";
										
										if($filaTraeItem['tipo']==0){
										}
										echo "</td>";
											
												if($filaTraeItem['tipo']==0){
												  $sqlP="select * from periodo where id_ano=".$ano;
												   $resultP=@pg_Exec($conn, $sqlP);
												   for($countEval=0 ; $countEval<pg_numrows($resultP) ; $countEval++){
												   $filaP=@pg_fetch_array($resultP,$countEval);
													$sqlTraeEval="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']."and periodo.id_periodo='".$filaP['id_periodo']."' and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo";
													$resultEval=@pg_Exec($conn, $sqlTraeEval);
													$filaEval=@pg_fetch_array($resultEval,0);
														$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
														$resultConc=@pg_Exec($conn, $sqlTraeConc);
														$filaConc=@pg_fetch_array($resultConc,0);
														
														echo "<td valign=bottom>&nbsp;&nbsp;";
														echo "<font size=1 face=Arial, Helvetica, sans-serif>".trim($filaConc['sigla'])."</font></td>";

													}
												}else if($filaTraeItem['tipo']==2){
													$sqlTraeEvalu="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo asc";
													$resultEvalu=@pg_Exec($conn, $sqlTraeEvalu);
													for($countEvalu=0 ; $countEvalu<pg_numrows($resultEvalu) ; $countEvalu++){
														$filaEvalu=pg_fetch_array($resultEvalu,$countEvalu);
														echo "<tr><td valign=bottom>";
														echo "<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;".$filaEvalu['nombre_periodo'].":&nbsp;&nbsp".$filaEvalu['text']."</td></tr>";
														echo "<tr><td bgcolor=\"#0099FF\" ></td></tr>";
													}
												}else if($filaTraeItem['tipo']==1){
													$sqlTraeEvalua="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo asc";
													$resultEvalua=@pg_Exec($conn, $sqlTraeEvalua);
													for($countEvalua=0 ; $countEvalua<pg_numrows($resultEvalua) ; $countEvalua++){
														$filaEvalua=@pg_fetch_array($resultEvalua,$countEvalua);
														if(($filaEvalua['radio']==0) and ($filaEvalua['radio']!="")){
																echo "<tr><td valign=bottom>";
																echo "<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;".$filaEvalua['nombre_periodo'].":&nbsp;&nbsp;No</font></td></tr>";	
																echo "<tr><td bgcolor=\"#0099FF\" ></td></tr>";
															}else if($filaEvalua['radio']==1){
																echo "<tr><td valign=bottom>";
																echo "<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;".$filaEvalua['nombre_periodo'].":&nbsp;&nbsp;Si</font></td></tr>";
																echo "<tr><td bgcolor=\"#0099FF\"></td></tr>";
															}
													}
														
												}
												
											
									}//fin for($countItem....
									$itemes=$itemes+$countItem;
							}//fin for($countSubarea....
							$subareas=$subareas+$countSubarea;
					}//fin for($countArea....
						$areas=$areas+countArea;				
	echo $total=$itemes+$subareas+$areas;
		  ?>
		  <input name="plantilla" type="hidden" value="<?php echo $filaPlantilla['id_plantilla']?>">
		  <input name="alumno" type="hidden" value="<?php echo $alumno?>">
      </table>

	  
	  
	  
	 <?php  }*///FIN SI ES HORIZONTAL ?>
	  
	  
<!-- 	  </td>
	  </tr>
	  </table>
 -->        <table width="100%" border="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
		<!--/div-->
          <?
 if  ($institucion!=25218){ 	?>
	<H1 class=SaltoDePagina></H1>
<?	}
 ?>
		<!--div id="capa2"-->
        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="003b85">
          <tr> 
            <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp; Observaciones:</strong></font></td>
        </tr>
      </table>
        <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0">
		<?php //$sqlTraeObs="select * from informe_observaciones where id_periodo=".$id_periodo." and id_ano=".$filaMatri['id_ano']." and id_plantilla=".$filaPlantilla['id_plantilla']." and rut_alumno='".$alumno."'";
					//$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_ano=".$filaMatri['id_ano']." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
					$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_periodo=".$periodo." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
					$resultObs=@pg_Exec($conn, $sqlTraeObs);
					?>
          <?php 
		  for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
		  $filaObs=@pg_fetch_array($resultObs, $countObs);	?>
		  	<tr>
			<td width="19%"><font size="1" face="Arial, Helvetica, sans-serif">
			<? echo $filaObs['nombre_periodo'];?>
			</td>
          	<td><font size="1" face="Arial, Helvetica, sans-serif">
			<? echo $filaObs['glosa'];?>
            &nbsp;</font></td>
        	</tr>
<?		}
		?>
      </table>
        <table width="100%" border="0">
          <tr> 
            <td>&nbsp; </td>
        </tr>
      <!--   <tr> 
            <td align="right">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><?php // setlocale ("LC_TIME", "es_ES"); echo (strftime("%d de %B de %Y")); ?></font> </td>
        </tr> -->
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
          <td width="45%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?>&nbsp;</font></strong></td>
          <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong>&nbsp;<?php echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat']?></strong></font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr align="center"> 
            
          <td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR 
            (A) JEFE</font></td>
          <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">ORIENTADOR 
            (A)</font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td>&nbsp;</td>
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong><?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat']?></strong></font></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td height="22">&nbsp;</td>
          <td height="22" align="center"><font size="1" face="Arial, Helvetica, sans-serif">JEFE 
            ESTABLECIMIENTO</font></td>
          <td height="22">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3" align="center">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3" align="center">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3" align="center"></td>
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
				$filaConc=@pg_fetch_array($resultConc,$countConc);	?>
				<tr><td width="137"><font size=1 face=Arial, Helvetica, sans-serif><? echo "".$filaConc['nombre']."&nbsp;(".$filaConc['sigla'].")";?></font></td>
<?				//echo "<td><font size=1 face=Arial, Helvetica, sans-serif>:</font></td>";	?>
				<td align="left"><font size=1 face=Arial, Helvetica, sans-serif>:  <? echo $filaConc['glosa'];?></font><td></tr>
<?			}		
		?>
        </tr>
      </table></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
 <? 

  if  (($cont_alumnos - $cont_paginas)<>1) ?>
	<H1 class=SaltoDePagina></H1>
<?	}
?>

</form>
</div>

</body>
</html>
