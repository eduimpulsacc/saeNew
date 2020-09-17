<?php 
require('../../../../../util/header.inc');

$c_alumno=$cmb_alumno;
$ano		= $_ANO;
$curso		= $c_curso;
$alumno		= $c_alumno;
$institucion= $_INSTIT;
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
//if ($c_alumno==0)
// exit;
if ($cb_ok){
 //$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$filaAno['id_ano']." and matricula.id_curso=curso.id_curso";
 	$sqlMatri="select * from curso where id_curso=$curso";
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
	$plantilla=$filaPlantilla[id_plantilla];
	$nuevo_sis=$filaPlantilla[nuevo_sis];
	
	$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultDIR =@pg_Exec($conn,$qryDIR);
	$filaDIR=@pg_fetch_array($resultDIR);

	$qryORI="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=11)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
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
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
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
//-->
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="window.print();window.close();" >
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="0%" height="722" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" height="1" border="0" cellpadding="0" cellspacing="0">
              
              <tr align="left" valign="top"> 
                <td height="1038"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                     
                      <td width="73%" align="left" valign="top"><table>
					  
<? if ($cb_ok){?>
<tr><td>
					  
<div id="capa0"></div>

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
					</td></tr>  
<? }?>					
 <? 
 if ($cb_ok){
 	if ($c_alumno==0)
		$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
	else
		$sql_alu = "select * from matricula where rut_alumno ='" . $c_alumno ."' and id_ano = " . $ano;
	$result_alu =pg_Exec($conn,$sql_alu);
	$cont_alumnos = pg_numrows($result_alu);

for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
{
	//echo "contador $cont_paginas;---$cont_alumnos";
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	
	 //$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$filaAno['id_ano']." and matricula.id_curso=curso.id_curso";
	$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$ano." and matricula.id_curso=curso.id_curso";
	$resultMatri=@pg_exec($conn,$sqlMatri);
	$filaMatri=@pg_fetch_array($resultMatri,0);

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
	
	$titulo2 = $filaPlantilla['titulo_informe2'];

?>
                        <tr>
                          <td>
                            <table>
						    
						  
                                <tr>
                                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
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
 -->
                    <? /*}*/?>
                </tr>
                <tr>
                  <td width="405" rowspan="5">&nbsp;</td>
                  <td width="191">&nbsp;</td>
                  <td width="78"><strong><font size="1" face="Arial, Helvetica, sans-serif">REGION</font></strong></td>
                  <td width="297"><strong><font size="1" face="Arial, Helvetica, sans-serif">: <? echo $fila_reg['nom_reg']?></font></strong></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">PROVINCIA</font></strong></td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">: <? echo $fila_pro['nom_pro']?></font></strong></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">COMUNA</font></strong></td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">: <? echo $fila_com['nom_com']?></font></strong></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">A&Ntilde;O ESCOLAR</font></strong></td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">: <? echo $filaAno['nro_ano']?></font></strong></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">RBD</font></strong></td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaInstit['rdb']," - ",$filaInstit['dig_rdb']?></font></strong></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td><table width="100%" border="0" align="center">
                                      <tr>
                                        <td align="center" class="tableindex"><div align="center"><? echo $titulo2;?>&nbsp;</div></td>
                                      </tr>
                                      <tr>
                                        <td align="center" class="tableindex"><?php for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
						$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
						/*if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE") $per="1 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE") $per="3 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE") $per="1 Sem.";
						if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE") $per="2 Sem.";*/
						
						echo $filaPeriodo['nombre_periodo'] ; }?>
&nbsp;</td>
                                      </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td><table width="100%" border="0">
                                      <tr>
                                        <td align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; <?php echo trim($filaInstit['nombre_instit']);?></font></strong></td>
                                      </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td><table width="100%" border="0">
                                      <tr valign="middle">
                                        <td width="23%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">Res. Exta. de Educaci&oacute;n N&ordm; <?php echo $filaInstit['nu_resolucion']?> de fecha
                                                <?php impF($filaInstit['fecha_resolucion'])?>
                    Rol Base de Datos <?php echo $filaInstit['rdb']," - ",$filaInstit['dig_rdb']?> </font></strong></td>
                                      </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td><table width="100%" border="0">
                                      <tr>
                                        <td colspan="4"><hr noshade color="#000000"></td>
                                      </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td><table width="100%" border="0">
                                      <tr>
                                        <td width="9%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Alumno</font></strong></td>
                                        <td width="39%"><strong><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaAlumno['nombre_alu']. " " . $filaAlumno['ape_pat']. " " . $filaAlumno['ape_mat']?></font></strong></td>
                                        <td width="5%"><strong><font size="1" face="Arial, Helvetica, sans-serif">RUT</font></strong></td>
                                        <td width="47%"><strong><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $alumno."-". $filaAlumno['dig_rut']?></font></strong></td>
                                      </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td><table width="100%" height="10%">
                                      <tr >
                                        <td width="9%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Curso</font></strong></td>
                                        <td width="91%" height="20"><strong><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaCurso['grado_curso']. " - ".$filaCurso['letra_curso']."     ".$filaEns['nombre_tipo'] ?></font></strong></td>
                                      </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td><?php if($filaMatri['ensenanza']>310){?>
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
                                  </td>
                                </tr>
                                <tr>
                                  <td><table width="100%" border="0">
                                      <tr>
                                        <td width="13%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Profesor (a) Jefe</font></strong></td>
                                        <td width="32%"><strong><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?></font></strong></td>
                                        <td width="11%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Orientador (a)</font></strong></td>
                                        <td width="44%"><strong><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat']?>&nbsp;</font></strong></td>
                                      </tr>
                                      <tr>
                                        <td><strong><font size="1" face="Arial, Helvetica, sans-serif">Fecha</font></strong></td>
                                        <td><strong><font size="1" face="Arial, Helvetica, sans-serif"> :
                                                <?php //setlocale ("LC_TIME", "es_ES");
												 $fecha = date("d-m-Y");
												 echo fecha_espanol($fecha); ?>
&nbsp;</font></strong></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td><hr noshade color="#000000"></td>
                                </tr>
                                <tr>
                                  <td><table width="100%" border="0">
                                      <tr>
                                        <td>
										<? if ($nuevo_sis==1){?>
										<table width="100%"><tr><td>
										<table width="100%" border="1" cellpadding="0" cellspacing="0">
                                            <? 	
	$contador=0;
   	$query_cat="select * from informe_area_item where id_plantilla='$plantilla' and id_padre=0";
	$result_cat=pg_exec($conn,$query_cat);
	$num_cat=pg_numrows($result_cat);
	?>
                                            <? for ($i=0;$i<$num_cat;$i++){
	$row_cat=pg_fetch_array($result_cat);
?>
                                            <tr>
                                              <td colspan="2"  class="tabla04"><? echo $row_cat['glosa'];?></td>
                                            </tr>
                                            <? 	$query_sub="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_cat[id]";
			$result_sub=pg_exec($conn,$query_sub);
			$num_sub=pg_numrows($result_sub);?>
                                            <? for ($j=0;$j<$num_sub;$j++){
				$row_sub=pg_fetch_array($result_sub);
			?>
                                            <tr class="tabla04">
                                              <td><img src="../../../../../cortes/p.gif" width="10" height="1" border="0"><? echo $row_sub['glosa'];?></td>
                                              <? if ($modificar){?>
                                              <td width="1%" nowrap><? if ($row_sub[con_concepto]==null){?>
&nbsp;
                          <? }else{?>
                          <input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_sub[id];?>">
                          <? }?>
                          <? if ($row_sub[con_concepto]=="0"){?>
                          <?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]'  and rut_alumno='$alumno'";
	$result_respuesta=pg_exec($conn,$query_respuesta);
	$num_respuesta=pg_numrows($result_respuesta);
	if ($num_respuesta>0){
	$row_respuesta=pg_fetch_array($result_respuesta);
	$valor=$row_respuesta[respuesta];
	}
	?>
                          <input name="respuesta[<? echo $contador;?>]" type="text" value="<? echo $valor;?>">
                          <? $contador++;}?>
                          <? if ($row_sub[con_concepto]=="1"){?>
                          <?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]'  and rut_alumno='$alumno'";
	$result_respuesta=pg_exec($conn,$query_respuesta);
	$num_respuesta=pg_numrows($result_respuesta);
	if ($num_respuesta>0){
	$row_respuesta=pg_fetch_array($result_respuesta);
	$valor=$row_respuesta[respuesta];
	}
	?>
                          <? 
					$query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla";
					$result_concep=pg_exec($conn,$query_concep);
					$num_concep=pg_numrows($result_concep);?>
                          <select name="respuesta[<? echo $contador;?>]">
                            <? 		for ($ii=0;$ii<$num_concep;$ii++){
							$row_concep=pg_fetch_array($result_concep);
					?>
                            <option  value="<? echo $row_concep[id_concepto];?>"<? if ($valor==$row_concep[id_concepto]){echo "selected";}?>><? echo $row_concep[glosa];?></option>
                            <? }?>
                          </select>
                          <? $contador++;}?>
                                              </td>
                                              <? }else{?>
                                              <td width="1%" nowrap><?   $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";
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
													echo $row_con[sigla];
												}
											}else{
												echo $row_respuesta[respuesta];
											}
										}
									
									
									?>
&nbsp; </td>
                                              <? }?>
                                            </tr>
                                            <? 	 $query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id]";
					$result_item=pg_exec($conn,$query_item);
					$num_item=pg_numrows($result_item);?>
                                            <? for ($z=0;$z<$num_item;$z++){
						$row_item=pg_fetch_array($result_item);
					?>
                                            <tr class="tablatit2-1">
                                              <td><img src="../../../../../cortes/p.gif" width="20" height="8" border="0"><? echo $row_item['glosa'];?></td>
                                              <? if ($modificar){?>
                                              <td width="1%" nowrap><input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_item[id];?>">
                                                  <? if ($row_item[con_concepto]=="0"){?>
                                                  <?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
	$result_respuesta=pg_exec($conn,$query_respuesta);
	$num_respuesta=pg_numrows($result_respuesta);
	if ($num_respuesta>0){
	$row_respuesta=pg_fetch_array($result_respuesta);
	$valor=$row_respuesta[respuesta];
	}
	?>
                                                  <input name="respuesta[<? echo $contador;?>]" type="text" value="<? echo $valor;?>">
                                                  <? $contador++;}?>
                                                  <? if ($row_item[con_concepto]=="1"){?>
                                                  <? 
							$query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla";
							$result_concep=pg_exec($conn,$query_concep);
							$num_concep=pg_numrows($result_concep);?>
                                                  <?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
	$result_respuesta=pg_exec($conn,$query_respuesta);
	$num_respuesta=pg_numrows($result_respuesta);
	if ($num_respuesta>0){
	$row_respuesta=pg_fetch_array($result_respuesta);
	$valor=$row_respuesta[respuesta];
	}
	?>
                                                  <select  name="respuesta[<? echo $contador;?>]">
                                                    <? 							for ($ii=0;$ii<$num_concep;$ii++){
									$row_concep=pg_fetch_array($result_concep);
							?>
                                                    <option value="<? echo $row_concep[id_concepto];?>" <? if ($valor==$row_concep[id_concepto]){echo "selected";}?>><? echo $row_concep[glosa];?></option>
                                                    <? }?>
                                                  </select>
                                                  <? $contador++;}?></td>
                                              <? }else{?>
                                              <td width="1%" nowrap><? $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
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
													echo $row_con[sigla];
												}
											}else{
											echo $row_respuesta[respuesta];
											}
										}
									
									
									?>
&nbsp;</td>
                                              <? }?>
                                            </tr>
                                            <? }?>
                                            <? }?>
                                            <? }?>
											
                                        </table></td></tr>
										<tr><td><?
 if  ($institucion!=25218 && $institucion!=25478 && $institucion!=24977 && $institucion!=12086 && $institucion!=24464 && $institucion!=22380){ 
	echo "<H1 class=SaltoDePagina></H1>";
	}
 ?>
                                            <!--div id="capa2"-->
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="003b85">
                                              <tr>
                                                <td class="tablatit2-1">&nbsp;&nbsp; Observaciones:</td>
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
		  $filaObs=@pg_fetch_array($resultObs, $countObs);
		  	echo "<tr>";
			echo "<td width=\"19%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">";
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
                                              <?		if($institucion!=25218 && $institucion!=25478 && $institucion!=24977 && $institucion!=22380){	?>
                                              <tr>
                                                <td>&nbsp;</td>
                                              </tr>
                                              <tr>
                                                <td></td>
                                              </tr>
                                              <?		}	?>
                                              <!--   <tr> 
            <td align="right">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><?php // setlocale ("LC_TIME", "es_ES"); echo (strftime("%d de %B de %Y")); ?></font> </td>
        </tr> -->
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
                                                  <!--input type="hidden" name="periodo" value="<?php //echo $periodo ?>"-->
                                                </font></td>
                                              </tr>
                                            </table>
                                            <?	if($institucion!=25218 && $institucion!=25478 && $institucion!=24977 && $institucion!=22380){	?>
                                            <table width="100%" border="0">
                                              <tr align="center">
                                                <td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">________________________</font></td>
                                                <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">_________________________</font></td>
                                              </tr>
                                              <tr>
                                                <td width="45%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" ><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?>&nbsp;</font></strong></td>
                                                <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>&nbsp;<?php echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat']?></strong></font></td>
                                              </tr>
                                            </table>
                                            <table width="100%" border="0">
                                              <tr align="center">
                                                <td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR (A) JEFE</font></td>
                                                <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">ORIENTADOR (A)</font></td>
                                              </tr>
                                            </table>
                                            <table width="100%" border="0">
                                              <tr>
                                                <td>&nbsp;</td>
                                                <td align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>____________________________ </strong></font></td>
                                                <td>&nbsp;</td>
                                              </tr>
                                              <tr>
                                                <td>&nbsp;</td>
                                                <td align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>
                                                  <?php
			if($institucion == 24511){
				echo "Meza Gotor Marcelo";
			}
			else{
				echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat'] ;
			}
		  ?>
                                                </strong></font></td>
                                                <td>&nbsp;</td>
                                              </tr>
                                              <tr>
                                                <td height="22">&nbsp;</td>
                                                <td height="22" align="center"><font size="1" face="Arial, Helvetica, sans-serif">JEFE ESTABLECIMIENTO</font></td>
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
                                            <?		}
		else if($institucion==25218 || $institucion==25478 || $institucion==24977){	?>
                                            <table width="630" border="0">
                                              <tr>
                                                <td width="210" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat'];?>&nbsp;</font></strong></td>
                                                <td width="210" align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong>&nbsp;<?php echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat'];?></strong></font></td>
                                                <td width="210" align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong><?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat'];?></strong></font></td>
                                              </tr>
                                              <tr align="center">
                                                <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR(A) JEFE</font></td>
                                                <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">ORIENTADOR(A)</font></td>
                                                <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">JEFE ESTABLECIMIENTO</font></td>
                                              </tr>
                                              <tr>
                                                <td>&nbsp;</td>
                                              </tr>
                                            </table>
                                            <?		}
	  if($institucion==22380){?>
                                            <table width="630" border="0">
                                              <tr>
                                                <td width="210" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat'];?>&nbsp;</font></strong></td>
                                                <td width="210" align="center">&nbsp;</td>
                                                <td width="210" align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong><?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat'];?></strong></font></td>
                                              </tr>
                                              <tr align="center">
                                                <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR(A) JEFE</font></td>
                                                <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
                                                <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">JEFE ESTABLECIMIENTO</font></td>
                                              </tr>
                                              <tr>
                                                <td>&nbsp;</td>
                                              </tr>
											  <tr><td></td></tr>
                                            </table>
                                            <? } ?>
</td>
										</tr>
										<tr><td><table width="100%">
                                          <tr>
                                            <td align="center" class="tablatit2-1">ESCALA DE EVALUACI&Oacute;N / AREAS DE DESARROLLO</td>
                                          </tr>
                                          <tr> </tr>
                                        </table></td></tr>
										<tr><td>  <table width="100%" border="0">

                                                    <?php 
			$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
			$resultConc=@pg_Exec($conn, $sqlConc);
			for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
				$filaConc=@pg_fetch_array($resultConc,$countConc);?>
				<tr><td width="137"><font size=1 face=Arial, Helvetica, sans-serif><? echo $filaConc['nombre']."&nbsp;(".$filaConc['sigla'].")";?></font></td>
				
				<td align="left"><font size=1 face=Arial, Helvetica, sans-serif> <? echo $filaConc['glosa'];?></font><td></tr>
<? 			}		
		?>

                                                </table></td></tr>
										</table>
										<? }if ($nuevo_sis!=1){?>
										<table width="630" border=0 cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td><table width="630">
                                                <?php 
						echo "<tr><td></td>";
						/*for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
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
					$sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla']." ORDER BY id_area";
					$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
					for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
						$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
						$nroA=$countArea+1;	
						echo "<tr><td><font face=Arial, Helvetica, sans-serif></font></td></tr>";					
						echo "<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif><strong>"/*.$nroA.".-  "*/.$filaTraeArea['nombre']."</strong></font><hr noshade color=\"#000000\"></td>";
//						echo "<td valign=bottom><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
						
							//trae subareas para cada area y las imprime
							$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
							$resultTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
							for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
							$nroS=$countSubarea+1;
								$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);
								echo "<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif style=\"text-decoration:underline\">&nbsp;&nbsp;&nbsp;<strong>".$nroA./*".".$nroS.*/".-  ".$filaTraeSubarea['nombre']."</strong></font></td></tr>";
								
									//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
									$sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea']." ORDER BY id_item";
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
										
										$nroI=$countItem+1;
										echo "<font size=1 face=Arial, Helvetica, sans-serif>"/*.$nroA.".".$nroS.".".$nroI.".-  "*/.trim($filaTraeItem['glosa'])."</font>";
										
										if($filaTraeItem['tipo']==0){
										}
										echo "</td>";
											
												if($filaTraeItem['tipo']==0){
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
														$filaConc=@pg_fetch_array($resultConc,0);
														if($institucion!=12086){
															echo "<td valign=bottom>&nbsp;&nbsp;";
															echo "<font size=1 face=Arial, Helvetica, sans-serif>".trim($filaConc['sigla'])."</font></td>";
														}else{
															echo "<td valign=bottom>&nbsp;&nbsp;";
															echo "<font size=1 face=Arial, Helvetica, sans-serif>".trim($filaConc['nombre'])."</font></td>";
														}
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
 -->
                                                <table width="100%" border="0">
                                                  <tr>
                                                    <td>&nbsp;</td>
                                                  </tr>
                                                </table>
                                                <!--/div-->
                                                <?
 if  ($institucion!=25218 && $institucion!=25478 && $institucion!=24977 && $institucion!=12086 && $institucion!=24464 && $institucion!=22380){ 
	echo "<H1 class=SaltoDePagina></H1>";
	}
 ?>
                                                <!--div id="capa2"-->
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="003b85">
                                                  <tr>
                                                    <td class="tablatit2-1">&nbsp;&nbsp; Observaciones:</td>
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
		  $filaObs=@pg_fetch_array($resultObs, $countObs);
		  	echo "<tr>";
			echo "<td width=\"19%\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">";
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
                                                  <?		if($institucion!=25218 && $institucion!=25478 && $institucion!=24977 && $institucion!=22380){	?>
                                                  <tr>
                                                    <td>&nbsp;</td>
                                                  </tr>
                                                  <tr>
                                                    <td></td>
                                                  </tr>
                                                  <?		}	?>
                                                  <!--   <tr> 
            <td align="right">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><?php // setlocale ("LC_TIME", "es_ES"); echo (strftime("%d de %B de %Y")); ?></font> </td>
        </tr> -->
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
                                                      <!--input type="hidden" name="periodo" value="<?php //echo $periodo ?>"-->
                                                    </font></td>
                                                  </tr>
                                                </table>
                                                <?	if($institucion!=25218 && $institucion!=25478 && $institucion!=24977 && $institucion!=22380){	?>
                                                <table width="100%" border="0">
                                                  <tr align="center">
                                                    <td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">________________________</font></td>
                                                    <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">_________________________</font></td>
                                                  </tr>
                                                  <tr>
                                                    <td width="45%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" ><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?>&nbsp;</font></strong></td>
                                                    <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>&nbsp;<?php echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat']?></strong></font></td>
                                                  </tr>
                                                </table>
                                                <table width="100%" border="0">
                                                  <tr align="center">
                                                    <td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR (A) JEFE</font></td>
                                                    <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">ORIENTADOR (A)</font></td>
                                                  </tr>
                                                </table>
                                                <table width="100%" border="0">
                                                  <tr>
                                                    <td>&nbsp;</td>
                                                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>____________________________ </strong></font></td>
                                                    <td>&nbsp;</td>
                                                  </tr>
                                                  <tr>
                                                    <td>&nbsp;</td>
                                                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif" ><strong>
                                                      <?php
			if($institucion == 24511){
				echo "Meza Gotor Marcelo";
			}
			else{
				echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat'] ;
			}
		  ?>
                                                    </strong></font></td>
                                                    <td>&nbsp;</td>
                                                  </tr>
                                                  <tr>
                                                    <td height="22">&nbsp;</td>
                                                    <td height="22" align="center"><font size="1" face="Arial, Helvetica, sans-serif">JEFE ESTABLECIMIENTO</font></td>
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
                                                <?		}
		else if($institucion==25218 || $institucion==25478 || $institucion==24977){	?>
                                                <table width="630" border="0">
                                                  <tr>
                                                    <td width="210" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat'];?>&nbsp;</font></strong></td>
                                                    <td width="210" align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong>&nbsp;<?php echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat'];?></strong></font></td>
                                                    <td width="210" align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong><?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat'];?></strong></font></td>
                                                  </tr>
                                                  <tr align="center">
                                                    <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR(A) JEFE</font></td>
                                                    <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">ORIENTADOR(A)</font></td>
                                                    <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">JEFE ESTABLECIMIENTO</font></td>
                                                  </tr>
                                                  <tr>
                                                    <td>&nbsp;</td>
                                                  </tr>
                                                </table>
                                                <?		}
	  if($institucion==22380){?>
                                                <table width="630" border="0">
                                                  <tr>
                                                    <td width="210" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat'];?>&nbsp;</font></strong></td>
                                                    <td width="210" align="center">&nbsp;</td>
                                                    <td width="210" align="center"><font size="1" face="Arial, Helvetica, sans-serif" style="text-decoration:underline"><strong><?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat'];?></strong></font></td>
                                                  </tr>
                                                  <tr align="center">
                                                    <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR(A) JEFE</font></td>
                                                    <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
                                                    <td width="210"><font size="1" face="Arial, Helvetica, sans-serif">JEFE ESTABLECIMIENTO</font></td>
                                                  </tr>
                                                  <tr>
                                                    <td>&nbsp;</td>
                                                  </tr>
                                                </table>
                                                <? } ?>
                                                <table width="100%">
                                                  <tr>
                                                    <td align="center" class="tablatit2-1">ESCALA DE EVALUACI&Oacute;N / AREAS DE DESARROLLO</td>
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
				echo "<tr><td width=\"137\"><font size=1 face=Arial, Helvetica, sans-serif>".$filaConc['nombre']."&nbsp;(".$filaConc['sigla'].")</font></td>";
				//echo "<td><font size=1 face=Arial, Helvetica, sans-serif>:</font></td>";
				echo "<td align=\"left\"><font size=1 face=Arial, Helvetica, sans-serif>:  ".$filaConc['glosa']."</font><td></tr>";
			}		
		?>
                                                  </tr>
                                                </table>
                                                <?		if($institucion!=25218 && $institucion!=25478 && $institucion!=24977 && $institucion!=22380){	?>
                                            <tr>
                                                                                    <td>&nbsp;</td>
                                            </tr>
                                                                                  <?		}	?>
                                        </table>
										<? }?>
										
										</td>
                                      </tr>
                                  </TABLE></td>
                                </tr>
                          </table></td></tr><? }}?>
                        <tr>
                          <td>                                                            <center>
                            </center></td>
                        </tr>
                      </table>
                      <p>&nbsp;</p></td>
                    </tr>
   
                </table></td>
              </tr>
            </table>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
