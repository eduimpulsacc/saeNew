<?php 
require('../../../../../util/header.inc');
include('../../../../clases/class_Reporte.php');
//include('../../../clases/class_Membrete.php');

	$c_alumno	= $cmb_alumno;
	$ano		= $_ANO;
	$curso		= $c_curso;
	$alumno		= $c_alumno;
	$institucion= $_INSTIT;
	$periodo	= $periodo;
	$reporte	= 22;

	$fecha = strftime("%d %m %Y");
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
	
		$sqlPeriodo="select nombre_periodo from periodo where id_periodo=".$periodo;
		$resultPeriodo=@pg_exec($conn, $sqlPeriodo);
		$filaPer=@pg_fetch_array($resultPeriodo,0);		
	
		
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
	
	
	/*$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);*/
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
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
<style type="text/css">
<!--
.Estilo2 {font-size: 10px}
.Estilo3 {font-size: 12px}
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="window.print();">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="0%" height="722" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" height="1" border="0" cellpadding="0" cellspacing="0">
              
              <tr align="left" valign="top"> 
                <td height="1038">
					<table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                     
                      <td width="73%" align="left" valign="top">
					  <table>

<? if ($cb_ok){?>
	<tr>
		<td>
			<div id="capa0">
<!--			<table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				  <td> <div align="right">
					  <input 		name="cmdimprimiroriginal" 		type="button" 		class="botonXX" 		id="cmdimprimiroriginal" 		onclick="MM_openBrWindow('print_rpt19_formato.php?c_curso=<?=$c_curso ?>&cmb_alumno=<?=$alumno ?>&cb_ok=1&periodo=<? echo $periodo;?>','','scrollbars=yes,resizable=yes,width=770,height=500')" 		value="Imprimir">
					</div></td> 
			  </tr>
			</table>
-->			</div>
			
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
		</td>
	</tr>  
<? }?>					
<? if ($cb_ok){
 	if ($c_alumno==0)
		$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
	else
		$sql_alu = "select * from matricula where rut_alumno ='" . $c_alumno ."' and id_ano = " . $ano;
	$result_alu =pg_Exec($conn,$sql_alu);
	$cont_alumnos = pg_numrows($result_alu);

	for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
	{
		$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
		$alumno = $fila_alu['rut_alumno'] ;
		
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

		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

?>

<tr><td>



<table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
				<table width="190" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td><center><?
						if($institucion!=""){
						   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?>
						</center></td>
					  </tr>
					
					<tr>
					   <td>
						   <table align="center">
							   <tr><td><font size="1" face="Arial, Helvetica, sans-serif"><? echo $filaInstit['nombre_instit'];?></font></td></tr>
								<tr><td><font size="1" face="Arial, Helvetica, sans-serif"><? echo $filaInstit['calle']." ".$filaInstit['nro'].", ".ucwords(strtolower($fila_com['nom_com']));?></font></td></tr>
								<tr><td><font size="1" face="Arial, Helvetica, sans-serif">Fono: <? echo $filaInstit['telefono'];?> - Fax: <? echo $filaInstit['fax'];?></font></td></tr>
						   </table>
						</td>
					</tr>
				</table>
			
		</td>
		<td>
		<td><img src='linea_v.jpg'></td>
		<td>
			<table width="440" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr><td colspan="3">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><strong><center><? echo $titulo2;?></center></strong></font></td></tr>
				<tr><td colspan="3"><hr color="#660000"></td></tr>
				<tr>
					<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<strong>A&ntilde;o Escolar</strong></font></td>
					<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>Periodo</strong></font></td>	
					<? if($institucion != 25218) {	?>				
					<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>RBD</strong></font></td>										
					<? 	}	?>									
				</tr>
				<tr>
					<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<? echo $filaAno['nro_ano'];?></font></td>
					<td><font size="1" face="Arial, Helvetica, sans-serif"><? echo ucwords(strtolower($filaPer['nombre_periodo']));?></font></td>
					<? if($institucion != 25218) {	?>
					<td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $filaInstit['rdb']."-".$filaInstit['dig_rdb'];?></font></td>										
					<? 	}	?>					
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr>
					<td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<strong>Nombre Alumno(a)</strong></font></td>
					<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>Curso</strong></font></td>
				</tr>												
				<tr>
					<td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $filaAlumno['nombre_alu']." ".$filaAlumno['ape_pat']." ".$filaAlumno['ape_mat'];?></font></td>
					<td><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $filaCurso['grado_curso']." - ".$filaCurso['letra_curso']." ".$filaEns['nombre_tipo'];?></font></td>										
				</tr>																
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="4">
			<table width="630" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="4"><strong><font size="1" face="Arial, Helvetica, sans-serif">ESCALA DE EVALUACI&Oacute;N:</font></strong></td>
				</tr>
				<tr>
<?				$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);	?>
					<td><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $filaConc['sigla'];?></strong></font>:</td>
					<td align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $filaConc['nombre'];?></font></td>
					<td></td>
<?				}	?>
				</tr>
			</table>
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
					<table width="630" align="center"><tr><td>
						<table width="630" align="center" border="1" cellpadding="0" cellspacing="0">
						<?
						$contador=0;
						$query_cat="select * from informe_area_item where id_plantilla='$plantilla' and id_padre=0 order by id" ;
						$result_cat=pg_exec($conn,$query_cat);
						$num_cat=pg_numrows($result_cat);
						for ($i=0;$i<$num_cat;$i++){
							$row_cat=pg_fetch_array($result_cat);	?>
							<tr>
							  <td colspan="2"  class="tabla04 Estilo3"><? echo $row_cat['glosa'];?></td>
							</tr>
                        <? 	$query_sub="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_cat[id]";
							$result_sub=pg_exec($conn,$query_sub);
							$num_sub=pg_numrows($result_sub);
							for ($j=0;$j<$num_sub;$j++){
								$row_sub=pg_fetch_array($result_sub);	?>
								<tr class="tabla04">
									<td><span class="Estilo2"><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">
										<? echo $row_sub['glosa'];?></span></td>
                                 <? if ($modificar){?>
										<td>
									      <span class="Estilo2">
												<? 	if ($row_sub['con_concepto']==null){?>
												&nbsp;
                                                <?									}else{	?>
											    <input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_sub[id];?>">
									            <?	}
										if ($row_sub[con_concepto]=="0"){
							    			$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]'  and rut_alumno='$alumno'";
											$result_respuesta=pg_exec($conn,$query_respuesta);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												$valor=$row_respuesta[respuesta];
											}	?>
											    <input name="respuesta[<? echo $contador;?>]" type="text" value="<? echo $valor;?>">
									            <? 		$contador++;	
										}
										if ($row_sub[con_concepto]=="1"){?>
							                    <?  			$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]'  and rut_alumno='$alumno'";
											$result_respuesta=pg_exec($conn,$query_respuesta);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												$valor=$row_respuesta[respuesta];
											}
											$query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla";
											$result_concep=pg_exec($conn,$query_concep);
											$num_concep=pg_numrows($result_concep);?>
											    <select name="respuesta[<? echo $contador;?>]">
									                    <? 		for ($ii=0;$ii<$num_concep;$ii++){
												$row_concep=pg_fetch_array($result_concep);	?>
											      <option  value="<? echo $row_concep[id_concepto];?>"
											<?	if ($valor==$row_concep[id_concepto]){
														echo "selected";
												}?>><? echo $row_concep[glosa];?></option>
									                    <? 		}?>
											          </select>
									            <? 		$contador++;
										}	?>                                              
										  </span></td>
				<? 						}else{	?>
											<td width="1%" nowrap>
									          <span class="Estilo2">
										<?		$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";
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
											}		?>
										<!--	&nbsp; -->
									    <? 		if($i==0){	?>
												  
										<?	}else{	?> 
												
										<?	} 	?>								
											  </span></td>
									<?	}  // fin else?>
										</tr>
									<?	$query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id]";
										$result_item=pg_exec($conn,$query_item);
										$num_item=pg_numrows($result_item);?>
									<?	for ($z=0;$z<$num_item;$z++){
											$row_item=pg_fetch_array($result_item);	?>
											<tr>
												<td><span class="Estilo2"><img src="../../../../../cortes/p.gif" width="20" height="8" border="0"><font face="Arial, Helvetica, sans-serif"><? echo $row_item['glosa'];?></font></span></td>
											<?	if ($modificar){?>
													<td width="1%" nowrap><span class="Estilo2">
													  <input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_item[id];?>">
												      <? 	if ($row_item[con_concepto]=="0"){?>
												      <?		$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
														$result_respuesta=pg_exec($conn,$query_respuesta);
														$num_respuesta=pg_numrows($result_respuesta);
														if ($num_respuesta>0){
															$row_respuesta=pg_fetch_array($result_respuesta);
															$valor=$row_respuesta[respuesta];
														}	?>
														<input name="respuesta[<? echo $contador;?>]" type="text" value="<? echo $valor;?>">
												      <?	$contador++;
													}
													if ($row_item[con_concepto]=="1"){
														$query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla";
														$result_concep=pg_exec($conn,$query_concep);
														$num_concep=pg_numrows($result_concep);?>
		
												      <?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
														$result_respuesta=pg_exec($conn,$query_respuesta);
														$num_respuesta=pg_numrows($result_respuesta);
														if ($num_respuesta>0){
															$row_respuesta=pg_fetch_array($result_respuesta);
															$valor=$row_respuesta[respuesta];
														}	?>
														<select  name="respuesta[<? echo $contador;?>]">
			                                              <?				 							for ($ii=0;$ii<$num_concep;$ii++){
															$row_concep=pg_fetch_array($result_concep);	?>
														  <option value="<? echo $row_concep[id_concepto];?>" 
														<?	if ($valor==$row_concep[id_concepto]){
																echo "selected";}?>><? echo $row_concep[glosa];?></option>
													      <?	}?>
													    </select>
														<?	$contador++;
														}?>
													</span></td>
												<?	}else{?>
														<td width="1%" nowrap>
														  <span class="Estilo2">
												<!------------------------------------------------>
												<?		$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
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
																?> 
												<font face="Arial, Helvetica, sans-serif">
												<?= $row_con[nombre];?>
												</font>
												<?
																}
															}else{
																?>
												<font face="Arial, Helvetica, sans-serif">
												<?= $row_respuesta[respuesta];?>
												</font>
												<?
															}
														}	?>
&nbsp;														  </span></td>
												<?	}  // fin else?>
	                                              </tr>
<?												}?>
<? 											}?>
<? 										}	// fin if modificar?>
		                                </table>					
							
								
									</td>
								</tr>
								<tr>
									<td>
									
					<!--<H1 class=SaltoDePagina></H1> -->
                                       
      
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
									  <tr>
										<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; Observaciones:</font></td>
									  </tr>
									</table>
									<table width="100%" border="1" align="center" cellpadding="1" cellspacing="0">
				<?					//$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_periodo=".$periodo." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
									$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_ano=".$ano." AND informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
									$resultObs=@pg_Exec($conn, $sqlTraeObs);

									for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
										$filaObs=@pg_fetch_array($resultObs, $countObs);	?>
										<tr>
											<td width="19%"><span class="Estilo2"><font size="1" face="Arial, Helvetica, sans-serif">
		                                        <?										echo $filaObs['nombre_periodo'];	?>
											</span></td>
											<td><span class="Estilo2"><font face="Arial, Helvetica, sans-serif">
											<?	echo $filaObs['observaciones'];	?>	
											&nbsp;</font>
											</span></td>
										</tr>
<?									}			?>
									</table>
									
									<table width="100%" border="0">
					
						  <?		if($institucion!=25218 && $institucion!=14629 && $institucion!=25478 && $institucion!=24977 && $institucion!=22380){	?>
										
							<?		}	?>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="right"><font size="2" face="Arial, Helvetica, sans-serif">
											  <input type="hidden" name="fecha2">
											  <input type="hidden" name="tipoEns" value="<?php echo $tipoEns ?>">
												<input type="hidden" name="grado" value="<?php echo $grado ?>">
											</font></td>
										</tr>
									</table>
                                
                                    </td>
								</tr>
							</table>
						
<?							} // fin if nuevo sistema	
							if ($nuevo_sis!=1){	?>
							<table width="630" border=0 cellpadding="0" cellspacing="0">
								<tr valign="top">
									<td>
										<table width="630" border="1" cellpadding="0" cellspacing="0">
							<?				$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
											$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
												//trae areas
											 $sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla']." ORDER BY id_area";	
											$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
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
												 $sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area']." order by orden asc";
												$resultTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
												for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
												$nroS=$countSubarea+1;
												$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);	?>
												<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong><? echo $nroA.".".$nroS.".-  ".$filaTraeSubarea['nombre'];?></strong></font></td></tr>
			<?									//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
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
															$sqlTraeEval="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']."and periodo.id_periodo='".$filaP['id_periodo']."' and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo";
															$resultEval=@pg_Exec($conn, $sqlTraeEval);
															$filaEval=@pg_fetch_array($resultEval,0);
															$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
															$resultConc=@pg_Exec($conn, $sqlTraeConc);
															$filaConc=@pg_fetch_array($resultConc,0);
															if($institucion!=12086){	?>
																<td valign=bottom>&nbsp;&nbsp;
																<font size=1 face=Arial, Helvetica, sans-serif><? echo trim($filaConc['sigla']);?></font></td>
	<?														}else{	?>
																<td valign=bottom>&nbsp;&nbsp;
																<font size=1 face=Arial, Helvetica, sans-serif><? echo trim($filaConc['nombre']); ?></font></td>
<?															}
														}
													}else if($filaTraeItem['tipo']==2){
														$sqlTraeEvalu="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$filaMatri['id_ano']." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo asc";
														$resultEvalu=@pg_Exec($conn, $sqlTraeEvalu);
														for($countEvalu=0 ; $countEvalu<pg_numrows($resultEvalu) ; $countEvalu++){
															$filaEvalu=pg_fetch_array($resultEvalu,$countEvalu);	?>
												  <tr><td valign=bottom>
															<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalu['nombre_periodo'].":&nbsp;&nbsp".$filaEvalu['text'];?></td></tr>
															<tr><td bgcolor="#0099FF" ></td></tr>
<?														}
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
										}//fin for($countArea....			  ?>
										<input name="plantilla" type="hidden" value="<?php echo $filaPlantilla['id_plantilla']?>">
										<input name="alumno" type="hidden" value="<?php echo $alumno?>">
                                        </table>
<?										if($institucion!=25218  && $institucion!=14629 && $institucion!=24977 && $institucion!=25478 && $institucion!=12086 && $institucion!=24464 && $institucion!=22380 && $institucion!=25768  && $institucion!=9035 && $institucion!=1707 && $institucion!=9276 ){ 	?>
											<H1 class=SaltoDePagina></H1>
                                            <p></p>
                                              <?										} ?>
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
	<? 												echo $filaObs['nombre_periodo'];	?>
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
				
									
									<table width="1024" border="0">
									  <tr>
										<?  
										if($ob_config->firma1!=0){
											$ob_reporte->cargo=$ob_config->firma1;
											$ob_reporte->rdb=$institucion;
											$ob_reporte->Firmas($conn);?>
										<td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
										<?=$ob_reporte->nombre_cargo;?></div></td>
										<? } ?>
										<? if($ob_config->firma2!=0){
											$ob_reporte->cargo=$ob_config->firma2;
											$ob_reporte->rdb=$institucion;
											$ob_reporte->Firmas($conn);?>
										<td width="25%" class="item"><hr align="center" width="150" color="#000000"> 
										  <div align="center"><?=$ob_reporte->nombre_emp;?><br>
										<?=$ob_reporte->nombre_cargo;?></div></td>
										<? } ?>
										 <? if($ob_config->firma3!=0){
											$ob_reporte->cargo=$ob_config->firma3;
											$ob_reporte->rdb=$institucion;
											$ob_reporte->Firmas($conn);?>
										<td width="25%" class="item"><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
										<?=$ob_reporte->nombre_cargo;?></div></td>
										<? } ?>
										 <? if($ob_config->firma4!=0){
											$ob_reporte->cargo=$ob_config->firma4;
											$ob_reporte->rdb=$institucion;
											$ob_reporte->Firmas($conn);?>
										<td width="25%" class="item"><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
										<?=$ob_reporte->nombre_cargo;?> </div></td>
										<? }?>
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
<?	}	?>

						
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>
</html>
