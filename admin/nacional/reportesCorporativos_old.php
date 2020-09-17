<?php require('../../util/header.inc');


function diashabiles($ano,$mes){

	if($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 || $mes==10 || $mes==12){
		$dia=31;
	}elseif($mes==4 || $mes==6 || $mes==9 || $mes==11){
		$dia=30;
	}else{
		$dia=28;
	}
	
	for($i=1;$i<=$dia;$i++){
		$semana=date("l",mktime(0,0,0,$mes,$i,$ano));
		if($semana=="Sunday" OR $semana=="Saturday"){
			$cuentanohabil++;
		}
	}
	$diashabiles = $dia - $cuentanohabil;
	return($diashabiles);
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
		 	
<script type="text/JavaScript">
<!--

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function muestra_tabla(tabla,span){
	t=document.getElementById(tabla);
	span2=document.getElementById(span);
	temp=document.getElementById(tabla).style.display;
	document.getElementById('matricula').style.display='none';
	document.getElementById('asistencia').style.display='none';
	document.getElementById('opcion3').style.display='none';
	document.getElementById('opcion4').style.display='none';
	document.getElementById('opcion5').style.display='none';
	document.getElementById('pesta1').className='span_normal';
	document.getElementById('pesta2').className='span_normal';
	document.getElementById('pesta3').className='span_normal';
	document.getElementById('pesta4').className='span_normal';
	document.getElementById('pesta5').className='span_normal';
	t.style.display="";
	span2.className='span_seleccionado';
}

function enviapag2(form){
	form.action='reportesCorporativos.php?pesta=1';
    form.submit(true);		
}
function enviapag3(form2){
	form2.action='reportesCorporativos.php?pesta=1';
    form2.submit(true);		
}
function enviapag4(form3){
	if(document.form3.cmb_anoA.value!=0 && document.form3.cmb_mesA.value!=0){
		form3.action='reportesCorporativos.php?pesta=2&op=1';
		form3.submit(true);		
	}
}
function enviapag5(form5){
	if(document.form5.cmb_anoP.value!=0 && document.form5.cmb_mesP.value!=0 && document.form5.cmb_plan.value!=0){
		form5.action='reportesCorporativos.php?pesta=2&op=2';
		form5.submit(true);		
	}
}
function enviapag6(form6){
	if(document.form6.cmb_anoI.value!=0 && document.form6.cmb_mesI.value!=0 && document.form6.cmb_instI.value!=0){
		form6.action='reportesCorporativos.php?pesta=2&op=3';
		form6.submit(true);		
	}
}

//-->
</script>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo8 {font-size: 10px}
.Estilo10 {color: #0099FF}
-->
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<script>
	/*document.getElementById('matricula').style.display='none';
	document.getElementById('asistencia').style.display='none';
	document.getElementById('opcion3').style.display='none';
	document.getElementById('opcion4').style.display='none';
	document.getElementById('opcion5').style.display='none';
	t.style.display="";*/
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="
<? if (($pesta == "") or ($pesta == NULL) or ($pesta == " ") or ($pesta == 1) or (!isset($pesta))){ ?>
      muestra_tabla('matricula','pesta1'); <?
   } 
   if ($pesta == 2){ ?>
      muestra_tabla('asistencia','pesta2'); <?
   }
   if ($pesta == 3){ ?>
      muestra_tabla('opcion3','pesta3'); <?
   }
   if ($pesta == 4){ ?>
      muestra_tabla('opcion4','pesta4'); <?
   }
   if ($pesta == 5){ ?>
      muestra_tabla('opcion5','pesta5'); <?
   }
   ?>
   
MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../cabecera/menu_superior.php");
			   ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><!--- CUERPO DE LA PÁGINA REPORTES CORPORACIONES -->
                        <table width="100%" border="0" cellpadding="5" cellspacing="0">
                          <tr>
                          <td><span class="Estilo1">REPORTES NIVEL CORPORACI&Oacute;N </span></td>
                        </tr></table>
						
                        <table width="100%" border="3" cellpadding="3" cellspacing="3" bordercolor="#999999">
					   <tr>
					     <td>
						   <table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#000000">
						      <tr>
						        <td width="20%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('matricula','pesta1');"><span id="pesta1" class="span_normal" >Matricula</span></a></div></td>
						        <td width="20%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('asistencia','pesta2');"><span id="pesta2" class="span_normal" >Asistencia</span></a></div></td>
						        <td width="20%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('opcion3','pesta3');"><span id="pesta3" class="span_normal" >Opcion 3 </span></a></div></td>
						        <td width="20%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('opcion4','pesta4');"><span id="pesta4" class="span_normal" >Opcion 4 </span></a></div></td>
						        <td width="20%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('opcion5','pesta5');"><span id="pesta5" class="span_normal" >Opcion 5 </span></a></div></td>
						      </tr>
						   </table>					 
						 </td>
					   </tr>
					   <tr>
					     <td height="400" valign="top">
						   <table width="100%" border="0" cellpadding="0" cellspacing="0">
                             <tr id="matricula">
                               <td valign="top" class="Estilo1">MATR&Iacute;CULA<br>
                                 <br>
								   <table width="100%" border="0" cellpadding="5" cellspacing="0">
								    <tr>
								      <td>
									 <form name="form"   action="" method="post">
									    <span class="Estilo8">A&ntilde;o escolar:</span> 
										<input type="hidden" value="<?=$txt ?>" name="txt">
										<select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
										   <option value="0">Seleccione Año</option>
                                           <option value="2008" <? if ($cmb_ano=="2008"){ ?> selected="selected" <? } ?>>2008</option>
										   <option value="2007" <? if ($cmb_ano=="2007"){ ?> selected="selected" <? } ?>>2007</option>
										   <option value="2006" <? if ($cmb_ano=="2006"){ ?> selected="selected" <? } ?>>2006</option>
										   <option value="2005" <? if ($cmb_ano=="2005"){ ?> selected="selected" <? } ?>>2005</option>
										   <option value="2004" <? if ($cmb_ano=="2004"){ ?> selected="selected" <? } ?>>2004</option>
										</select>
									    <input name="cmb_inst" type="hidden" id="cmb_inst" value="<?=$cmb_inst ?>">
									 </form>
					
					               </td>
								    </tr>
									<tr>
									  <td>
									  
									   <? if ($op==NULL and $cmb_ano > 0){ ?>
									   <table width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
										  <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=1&op=1&cmb_ano=<?=$cmb_ano ?>">Matr&iacute;cula total Corporaci&oacute;n </a></td>
									     </tr>
										  <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=1&op=2&cmb_ano=<?=$cmb_ano ?>">Alumnos Retirados de la Corporaci&oacute;n </a></td>
									     </tr>
										  <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=1&op=3&cmb_ano=<?=$cmb_ano ?>">Matrícula de alumnos sexo Masculino de la Corporaci&oacute;n </a></td>
									     </tr>
										   <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=1&op=4&cmb_ano=<?=$cmb_ano ?>">Matrícula de alumnos sexo Femenino de la Corporaci&oacute;n </a></td>
									     </tr>
										   <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=1&op=5&cmb_ano=<?=$cmb_ano ?>">Matrícula de alumnos origen indígena de la Corporaci&oacute;n </a></td>
										   </tr>
										   <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=1&op=6&cmb_ano=<?=$cmb_ano ?>">Matrícula a partir del 30 de Abril de la Corporaci&oacute;n </a></td>
										   </tr>
										   <tr>
										     <td colspan="2" valign="middle">
											 <form name="form2" method="post" action="reportesCorporativos.php?pesta=1&op=7&cmb_ano=<?=$cmb_ano ?>">
											 <div align="center" class="Estilo8"><br>
											   <br>
											   B&uacute;squeda de alumnos 
													   <label>
													   <input name="txt" type="text" id="txt" size="20">
													   </label>
													   <label>
													   &nbsp;Establecimiento
													   <select name="cmb_inst" id="cmb_inst">
													      <option value="0">Buscar en todos</option>
														  <?
														  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												          $result_ins=@pg_Exec($conn,$qry_ins);
												          for($i=0;$i<pg_numrows($result_ins);$i++){	
													          $fila_ins = pg_fetch_array($result_ins,$i);
													          $rdb = $fila_ins['rdb'];
													          $establecimiento = $fila_ins['nombre_instit']; 
															  ?>
													          <option value="<?=$rdb ?>"><?=$establecimiento ?></option>
															  <?
														  }
														  ?>	  
                                                       </select>
													     &nbsp; <input name="buscar" type="image" src="images/lupa.gif" align="bottom" width="21" height="20">
													   </label>
													    <label></label>
													    <br>
											   <span class="Estilo10">Criterios de b&uacute;squeda<br> 
											 (Rut sin d&iacute;gito verificador, nombre, apellido paterno, apellido materno del alumno)</span> </div>
											 </form>
											 </td>
								         </tr>				
										</table> 
										<? } ?>
										  
										 
									    <?
										if ($pesta==1 and $op==1 and $cmb_ano!=0){ ?>
											<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="3">
												  <tr>
													<td colspan="2"><div align="center">Total matr&iacute;cula corporaci&oacute;n </div></td>
												  </tr>
												  <tr>
													<td class="Estilo4">Establecimiento</td>
													<td width="20%" class="Estilo4"><div align="right">Matricula</div></td>
												  </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as mat from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar<>1";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $matriculados = $filsMatriculados['mat'];
													   ?>
													   <tr>
														<td class="Estilo8"><?=$establecimiento ?></td>
														<td class="Estilo8"><div align="right"><b><?=$matriculados ?></b></div></td>
													   </tr>
													   <?
													   $total_matriculados = $total_matriculados + $matriculados;
												  }
												  ?>
												  <tr>
													<td class="Estilo4"><div align="right">Total</div></td>
													<td class="Estilo4"><div align="right"><?=$total_matriculados ?></div></td>
												  </tr>
												</table></td>
											  </tr>
											</table>
										    <table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><img src="images/imprimir_reporte.gif" width="118" height="14"></td>
                                              </tr>
                                            </table>
									      <? } ?>
										  
										  
										  
										  <?
										if ($pesta==1 and $op==2 and $cmb_ano!=0){ ?>
											<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="3">
												  <tr>
													<td colspan="2"><div align="center">Alumnos retirados corporaci&oacute;n </div></td>
												  </tr>
												  <tr>
													<td class="Estilo4">Establecimiento</td>
													<td width="20%" class="Estilo4"><div align="right">Cantidad</div></td>
												  </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as ret from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar='1'";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $retirados = $filsMatriculados['ret'];
													   ?>
													   <tr>
														<td class="Estilo8"><?=$establecimiento ?></td>
														<td class="Estilo8"><div align="right"><b><?=$retirados ?></b></div></td>
													   </tr>
													   <?
													   $total_retirados = $total_retirados + $retirados;
												  }
												  ?>
												  <tr>
													<td class="Estilo4"><div align="right">Total</div></td>
													<td class="Estilo4"><div align="right"><?=$total_retirados ?></div></td>
												  </tr>
												</table></td>
											  </tr>
											</table>
										    <table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><img src="images/imprimir_reporte.gif" width="118" height="14"></td>
                                              </tr>
                                            </table>
									      <? } ?>
										  
										   <?
										if ($pesta==1 and $op==3 and $cmb_ano!=0){ ?>
											<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="3">
												  <tr>
													<td colspan="2"><div align="center">Matrícula de alumnos sexo Masculino de la orporaci&oacute;n </div></td>
												  </tr>
												  <tr>
													<td class="Estilo4">Establecimiento</td>
													<td width="20%" class="Estilo4"><div align="right">Cantidad</div></td>
												  </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as mascu from alumno where rut_alumno in (select rut_alumno from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar<>1) and sexo = '2'";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $mascu = $filsMatriculados['mascu'];
													   ?>
													   <tr>
														<td class="Estilo8"><?=$establecimiento ?></td>
														<td class="Estilo8"><div align="right"><b><?=$mascu ?></b></div></td>
													   </tr>
													   <?
													   $total_mascu = $total_mascu + $mascu;
												  }
												  ?>
												  <tr>
													<td class="Estilo4"><div align="right">Total</div></td>
													<td class="Estilo4"><div align="right"><?=$total_mascu ?></div></td>
												  </tr>
												</table></td>
											  </tr>
											</table>
										    <table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><img src="images/imprimir_reporte.gif" width="118" height="14"></td>
                                              </tr>
                                            </table>
									      <? } ?>
										  
										   <?
										if ($pesta==1 and $op==4 and $cmb_ano!=0){ ?>
											<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="3">
												  <tr>
													<td colspan="2"><div align="center">Matrícula de alumnos sexo Femenino de la orporaci&oacute;n </div></td>
												  </tr>
												  <tr>
													<td class="Estilo4">Establecimiento</td>
													<td width="20%" class="Estilo4"><div align="right">Cantidad</div></td>
												  </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as feme from alumno where rut_alumno in (select rut_alumno from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar<>1) and sexo = '1'";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $feme = $filsMatriculados['feme'];
													   ?>
													   <tr>
														<td class="Estilo8"><?=$establecimiento ?></td>
														<td class="Estilo8"><div align="right"><b><?=$feme ?></b></div></td>
													   </tr>
													   <?
													   $total_feme = $total_feme + $feme;
												  }
												  ?>
												  <tr>
													<td class="Estilo4"><div align="right">Total</div></td>
													<td class="Estilo4"><div align="right"><?=$total_feme ?></div></td>
												  </tr>
												</table></td>
											  </tr>
											</table>
										    <table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><img src="images/imprimir_reporte.gif" width="118" height="14"></td>
                                              </tr>
                                            </table>
									      <? } ?>
										  
										   <?
										if ($pesta==1 and $op==5 and $cmb_ano!=0){ ?>
											<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="3">
												  <tr>
													<td colspan="2"><div align="center">Matrícula de alumnos origen indígena de la orporaci&oacute;n </div></td>
												  </tr>
												  <tr>
													<td class="Estilo4">Establecimiento</td>
													<td width="20%" class="Estilo4"><div align="right">Cantidad</div></td>
												  </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as indi from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar<>1 and bool_aoi = '1'";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $indi = $filsMatriculados['indi'];
													   ?>
													   <tr>
														<td class="Estilo8"><?=$establecimiento ?></td>
														<td class="Estilo8"><div align="right"><b><?=$indi ?></b></div></td>
													   </tr>
													   <?
													   $total_indi = $total_indi + $indi;
												  }
												  ?>
												  <tr>
													<td class="Estilo4"><div align="right">Total</div></td>
													<td class="Estilo4"><div align="right"><?=$total_indi ?></div></td>
												  </tr>
												</table></td>
											  </tr>
											</table>
										    <table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><img src="images/imprimir_reporte.gif" width="118" height="14"></td>
                                              </tr>
                                            </table>
									      <? } ?>
										  
										  <?
										if ($pesta==1 and $op==6 and $cmb_ano!=0){ ?>
											<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="3">
												  <tr>
													<td colspan="2"><div align="center">Matrícula de alumnos después del 30 de abril</div></td>
												  </tr>
												  <tr>
													<td class="Estilo4">Establecimiento</td>
													<td width="20%" class="Estilo4"><div align="right">Cantidad</div></td>
												  </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as abril from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar<>1 and fecha > '$cmb_ano-04-30'";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $abril = $filsMatriculados['abril'];
													   ?>
													   <tr>
														<td class="Estilo8"><?=$establecimiento ?></td>
														<td class="Estilo8"><div align="right"><b><?=$abril ?></b></div></td>
													   </tr>
													   <?
													   $total_abril = $total_abril + $abril;
												  }
												  ?>
												  <tr>
													<td class="Estilo4"><div align="right">Total</div></td>
													<td class="Estilo4"><div align="right"><?=$total_abril ?></div></td>
												  </tr>
												</table></td>
											  </tr>
											</table>
										    <table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><img src="images/imprimir_reporte.gif" width="118" height="14"></td>
                                              </tr>
                                            </table>
									      <? } ?>
										  
									   <?
										if ($pesta==1 and $op==7 and $cmb_ano!=0 and $rut_alumno!=NULL){
										    //// consulta que trae casi todos la información
										 	$sql_1 = "select institucion.nombre_instit, curso.ensenanza, curso.grado_curso, curso.letra_curso, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.rut_alumno, alumno.dig_rut, alumno.fecha_nac, alumno.sexo, alumno.telefono, alumno.email, matricula.fecha, matricula.num_mat, alumno.calle, alumno.nro, alumno.depto, alumno.block, region.nom_reg, provincia.nom_pro, comuna.nom_com from ((((((((matricula inner join ano_escolar on matricula.id_ano = ano_escolar.id_ano) inner join alumno on matricula.rut_alumno = alumno.rut_alumno and matricula.rut_alumno = '$rut_alumno')   inner join curso on curso.id_curso = matricula.id_curso) inner join supervisa on curso.id_curso = supervisa.id_curso) inner join empleado on supervisa.rut_emp = empleado.rut_emp)  inner join institucion on matricula.rdb = institucion.rdb) inner join region on alumno.region = region.cod_reg) inner join provincia on region.cod_reg = provincia.cod_reg) inner join comuna on provincia.cor_pro = comuna.cor_pro  where ano_escolar.id_institucion = '$rdb' and ano_escolar.nro_ano = '$cmb_ano' and provincia.cor_pro = alumno.ciudad and comuna.cor_com = alumno.comuna and comuna.cod_reg = alumno.region";
											$res_1 = pg_Exec($conn,$sql_1);
											$fil_1 = pg_fetch_array($res_1);
											
																						
											$nombre_instit    = $fil_1[0];
											$ensenanza        = $fil_1[1];
											$grado_curso      = $fil_1[2];
											$letra_curso      = $fil_1[3];
											$nombre_emp       = $fil_1[4];
											$ape_pat_emp      = $fil_1[5];
											$ape_mat_emp      = $fil_1[6];
											$nombre_alu       = $fil_1[7];
											$ape_pat_alu      = $fil_1[8];
											$ape_mat_alu      = $fil_1[9];
											$rut_alumno       = $fil_1[10];
											$dig_alumno       = $fil_1[11];
											$fecha_nac        = $fil_1[12];
											$sexo_alu         = $fil_1[13];
											$fono_alu         = $fil_1[14];
											$email_alu        = $fil_1[15];
											$fecha_mat        = $fil_1[16];
											$num_mat          = $fil_1[17];
											$calle_alu        = $fil_1[18];
											$nro_alu          = $fil_1[19];
											$depto_alu        = $fil_1[20];
											$block_alu        = $fil_1[21];
											$region_alu       = $fil_1[22];
											$ciudad_alu       = $fil_1[23];
											$comuna_alu       = $fil_1[24];
											
											
											if ($ensenanza==10){
											    $ensenanza = "Parvularia";
											}
											if ($ensenanza==110){
											    $ensenaza = "Básica";
											}
											if ($ensenanza==310){
											    $ensenanza = "Media";
											}
											$dd = substr($fecha_nac,8,2);
											$mm = substr($fecha_nac,5,2);
											$aa = substr($fecha_nac,0,4);
											
											$fecha_nac = "$dd-$mm-$aa";
											
											if ($sexo_alu==2){
											    $sexo_alu = "Masculino";
											}
											if ($sexo_alu==1){
											   $sexo_alu = "Femenino";
											}    				
										    $dd = substr($fecha_mat,8,2);
											$mm = substr($fecha_mat,5,2);
											$aa = substr($fecha_mat,0,4);
											
											$fecha_mat = "$dd-$mm-$aa";
										    ?>										
											<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="20%" class="Estilo4">Establecimiento</td>
                                                        <td class="Estilo8"><?=$nombre_instit ?></td>
                                                      </tr>
                                                      <tr>
                                                        <td class="Estilo4">A&ntilde;o escolar </td>
                                                        <td class="Estilo8"><?=$cmb_ano ?></td>
                                                      </tr>
                                                      <tr>
                                                        <td class="Estilo4">Curso</td>
                                                        <td class="Estilo8"><? echo "$grado_curso-$letra_curso Ensenanza $ensenanza"; ?></td>
                                                      </tr>
                                                      <tr>
                                                        <td class="Estilo4">Profesor Jefe </td>
                                                        <td class="Estilo8"><? echo "$nombre_emp $ape_pat_emp $ape_mat_emp"; ?></td>
                                                      </tr>
                                                      <tr>
                                                        <td colspan="2"><div align="center"><b>FICHA DE MATRICULA</b> </div></td>
                                                      </tr>
                                                      <tr>
                                                        <td colspan="2"><hr></td>
                                                      </tr>
                                                    </table></td>
                                                  </tr>
                                                  <tr>
                                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td class="Estilo4">I. Informaci&oacute;n del alumno <br>
                                                          <br>
                                                          <br></td>
                                                        <td width="150" rowspan="2" valign="top">
														<div align="center">
                                                          <table width="100%" height="160" border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                              <td><div align="center"><img src="../../infousuario/images/<?=trim($rut_alumno)  ?>" width="110" height="130"></div></td>
                                                            </tr>
                                                          </table>
                                                        </div>														</td>
                                                      </tr>
                                                      <tr>
                                                        <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
                                                          <tr>
                                                            <td colspan="2" bgcolor="#E2E2E2" class="Estilo4">Nombre</td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" class="Estilo8"><? echo "$nombre_alu $ape_pat_alu $ape_mat_alu"; ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Rut</td>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Fecha de Nacimiento </td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><? echo "$rut_alumno-$dig_alumno"; ?></td>
                                                            <td class="Estilo8"><?=$fecha_nac ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Sexo</td>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Fono</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><?=$sexo_alu ?></td>
                                                            <td class="Estilo8"><?=$fono_alu ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" bgcolor="#E2E2E2" class="Estilo4">E-mail</td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" class="Estilo8"><?=$email_alu ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Fecha Matr&iacute;cula </td>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Nro. Matricula </td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><?=$fecha_mat ?></td>
                                                            <td class="Estilo8"><?=$num_mat ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Direcci&oacute;n, calle </td>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Nro</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><?=$calle_alu ?></td>
                                                            <td class="Estilo8"><?=$nro_alu ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Block</td>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Dpto.</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><?=$block_alu ?></td>
                                                            <td class="Estilo8"><?=$depto_alu ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Regi&oacute;n</td>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Ciudad</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><?=$region_alu ?></td>
                                                            <td class="Estilo8"><?=$ciudad_alu ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Comuna</td>
                                                            <td class="Estilo4">.</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><?=$comuna_alu ?></td>
                                                            <td class="Estilo8">&nbsp;</td>
                                                          </tr>
                                                          
                                                        </table></td>
                                                      </tr>
                                                    </table>
                                                      <br>
                                                      <br>
													  <?
													  ////////// tomamos la informacion del apodera responsable //////
												      $sql_2 = "select apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, apoderado.rut_apo, apoderado.dig_rut, apoderado.fecha_nac, apoderado.telefono, apoderado.relacion, apoderado.email, apoderado.nivel_edu, apoderado.calle, apoderado.nro, apoderado.villa, region.nom_reg, provincia.nom_pro, comuna.nom_com from ((apoderado inner join region on region.cod_reg = apoderado.region) inner join provincia on region.cod_reg = provincia.cod_reg) inner join comuna on comuna.cor_pro = provincia.cor_pro where apoderado.rut_apo in (select rut_apo from tiene2 where rut_alumno = '$rut_alumno' and responsable = '1') and provincia.cor_pro = apoderado.ciudad and comuna.cor_com = apoderado.comuna and region.cod_reg = comuna.cod_reg"; 
													  $res_2 = pg_Exec($conn,$sql_2);
													  $num_2 = pg_numrows($res_2);
													  
													  if ($num_2 > 0){
													      $fil_2 = pg_fetch_array($res_2,0);
														  $nombre_apo   = $fil_2['nombre_apo'];
														  $ape_pat_apo  = $fil_2['ape_pat'];
														  $ape_mat_apo  = $fil_2['ape_mat'];
														  $rut_apo      = $fil_2['rut_apo'];
														  $dig_rut      = $fil_2['dig_rut'];
														  $fecha_nac    = $fil_2['fecha_nac'];
														  $fono_apo     = $fil_2['telefono'];
														  $relacion     = $fil_2['relacion'];
														  $email        = $fil_2['email'];
														  $nivel_edu    = $fil_2['nivel_edu'];
														  $calle        = $fil_2['calle'];
														  $nro          = $fil_2['nro'];
														  $villa        = $fil_2['villa'];
														  $region       = $fil_2['nom_reg'];
														  $ciudad       = $fil_2['nom_pro'];
														  $comuna       = $fil_2['nom_com'];
														  
														  $dd = substr($fecha_nac,8,2);
														  $mm = substr($fecha_nac,5,2);
														  $aa = substr($fecha_nac,0,4);
														  
														  $fecha_nac = "$dd-$mm-$aa";
														  
														  if ($relacion == 2){
														      $relacion = "Madre";
														  }
														  if ($relacion == 1){
														     $relacion = "Padre";
														  }	 	  
													  }else{
													      $nombre_apo   = "&nbsp;";
														  $ape_pat_apo  = "&nbsp;";
														  $ape_mat_apo  = "&nbsp;";
														  $rut_apo      = "&nbsp;";
														  $dig_rut      = "&nbsp;";
														  $fecha_nac    = "&nbsp;";
														  $fono_apo     = "&nbsp;";
														  $relacion     = "&nbsp;";
														  $email        = "&nbsp;";
														  $nivel_edu    = "&nbsp;";
														  $calle        = "&nbsp;";
														  $nro          = "&nbsp;";
														  $villa        = "&nbsp;";
														  $region       = "&nbsp;";
														  $ciudad       = "&nbsp;";
														  $comuna       = "&nbsp;";
													  }	  
													  
													  ?>
                                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td class="Estilo4">II. Informaci&oacute;n del Apoderado  <br>
                                                              <br></td>
                                                        </tr>
                                                        <tr>
                                                          <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
                                                            <tr>
                                                              <td colspan="3" bgcolor="#E2E2E2" class="Estilo4">Nombre</td>
                                                            </tr>
                                                            <tr>
                                                              <td colspan="3" class="Estilo8"><? echo "$nombre_apo $ape_pat_apo $ape_mat_apo"; ?></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Rut</td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Fecha de Nacimiento </td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Fono</td>
                                                            </tr>
                                                            <tr>
                                                              <td class="Estilo8"><? echo "$rut_apo-$dig_rut"; ?></td>
                                                              <td class="Estilo8"><?=$fecha_nac ?></td>
                                                              <td class="Estilo8"><?=$fono_apo ?></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Relaci&oacute;n</td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">E-mail</td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Nivel Educacional</td>
                                                            </tr>
                                                            <tr>
                                                              <td class="Estilo8"><?=$relacion ?></td>
                                                              <td class="Estilo8"><?=$email ?></td>
                                                              <td class="Estilo8"><?=$nivel_edu ?></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Direcci&oacute;n, calle </td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Nro.</td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Villa / Poblaci&oacute;n </td>
                                                            </tr>
                                                            <tr>
                                                              <td class="Estilo8"><?=$calle ?></td>
                                                              <td class="Estilo8"><?=$nro ?></td>
                                                              <td class="Estilo8"><?=$villa ?></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Regi&oacute;n</td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Ciudad</td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Comuna</td>
                                                            </tr>
                                                            <tr>
                                                              <td class="Estilo8"><?=$region ?></td>
                                                              <td class="Estilo8"><?=$ciudad ?></td>
                                                              <td class="Estilo8"><?=$comuna ?></td>
                                                            </tr>
                                                            
                                                            
                                                            
                                                          </table></td>
                                                        </tr>
                                                      </table>
                                                      <br>
                                                      <br>
													  <?
													  ////////// tomamos la informacion del la MADRE //////
												      $sql_2 = "select apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, apoderado.rut_apo, apoderado.dig_rut, apoderado.fecha_nac, apoderado.telefono, apoderado.relacion, apoderado.email, apoderado.nivel_edu, apoderado.calle, apoderado.nro, apoderado.villa, region.nom_reg, provincia.nom_pro, comuna.nom_com from ((apoderado inner join region on region.cod_reg = apoderado.region) inner join provincia on region.cod_reg = provincia.cod_reg) inner join comuna on comuna.cor_pro = provincia.cor_pro where apoderado.rut_apo in (select rut_apo from tiene2 where rut_alumno = '$rut_alumno' ) and provincia.cor_pro = apoderado.ciudad and comuna.cor_com = apoderado.comuna and region.cod_reg = comuna.cod_reg and apoderado.relacion = '2'"; 
													  $res_2 = pg_Exec($conn,$sql_2);
													  $num_2 = pg_numrows($res_2);
													  
													  if ($num_2 > 0){
													      $fil_2 = pg_fetch_array($res_2,0);
														  $nombre_apo   = $fil_2['nombre_apo'];
														  $ape_pat_apo  = $fil_2['ape_pat'];
														  $ape_mat_apo  = $fil_2['ape_mat'];
														  $rut_apo      = $fil_2['rut_apo'];
														  $dig_rut      = $fil_2['dig_rut'];
														  $fecha_nac    = $fil_2['fecha_nac'];
														  $fono_apo     = $fil_2['telefono'];
														  $relacion     = $fil_2['relacion'];
														  $email        = $fil_2['email'];
														  $nivel_edu    = $fil_2['nivel_edu'];
														  $calle        = $fil_2['calle'];
														  $nro          = $fil_2['nro'];
														  $villa        = $fil_2['villa'];
														  $region       = $fil_2['nom_reg'];
														  $ciudad       = $fil_2['nom_pro'];
														  $comuna       = $fil_2['nom_com'];
														  
														  $dd = substr($fecha_nac,8,2);
														  $mm = substr($fecha_nac,5,2);
														  $aa = substr($fecha_nac,0,4);
														  
														  $fecha_nac = "$dd-$mm-$aa";
														  
														  if ($relacion == 2){
														      $relacion = "Madre";
														  }
														  if ($relacion == 1){
														     $relacion = "Padre";
														  }	 	  
													  }else{
													      $nombre_apo   = "&nbsp;";
														  $ape_pat_apo  = "&nbsp;";
														  $ape_mat_apo  = "&nbsp;";
														  $rut_apo      = "&nbsp;";
														  $dig_rut      = "&nbsp;";
														  $fecha_nac    = "&nbsp;";
														  $fono_apo     = "&nbsp;";
														  $relacion     = "&nbsp;";
														  $email        = "&nbsp;";
														  $nivel_edu    = "&nbsp;";
														  $calle        = "&nbsp;";
														  $nro          = "&nbsp;";
														  $villa        = "&nbsp;";
														  $region       = "&nbsp;";
														  $ciudad       = "&nbsp;";
														  $comuna       = "&nbsp;";
													  }	  
													  
													  ?>
                                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td class="Estilo4">III. Informaci&oacute;n de la Madre <br>
                                                              <br></td>
                                                        </tr>
                                                        <tr>
                                                          <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
                                                              <tr>
                                                                <td colspan="3" bgcolor="#E2E2E2" class="Estilo4">Nombre</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" class="Estilo8"><? echo "$nombre_apo $ape_pat_apo $ape_mat_apo"; ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Rut</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Fecha de Nacimiento </td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Fono</td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><? echo "$rut_apo-$dig_apo"; ?></td>
                                                                <td class="Estilo8"><?=$fecha_nac ?></td>
                                                                <td class="Estilo8"><?=$fono_apo ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Relaci&oacute;n</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">E-mail</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Nivel Educacional</td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><?=$relacion ?></td>
                                                                <td class="Estilo8"><?=$email ?></td>
                                                                <td class="Estilo8"><?=$nivel_edu ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Direcci&oacute;n, calle </td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Nro.</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Villa / Poblaci&oacute;n </td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><?=$calle ?></td>
                                                                <td class="Estilo8"><?=$nro ?></td>
                                                                <td class="Estilo8"><?=$villa ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Regi&oacute;n</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Ciudad</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Comuna</td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><?=$region ?></td>
                                                                <td class="Estilo8"><?=$ciudad ?></td>
                                                                <td class="Estilo8"><?=$comuna ?></td>
                                                              </tr>
                                                          </table></td>
                                                        </tr>
                                                      </table>
                                                      <br>
                                                    <br>
													<?
													  ////////// tomamos la informacion del la PADRE //////
												      $sql_2 = "select apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, apoderado.rut_apo, apoderado.dig_rut, apoderado.fecha_nac, apoderado.telefono, apoderado.relacion, apoderado.email, apoderado.nivel_edu, apoderado.calle, apoderado.nro, apoderado.villa, region.nom_reg, provincia.nom_pro, comuna.nom_com from ((apoderado inner join region on region.cod_reg = apoderado.region) inner join provincia on region.cod_reg = provincia.cod_reg) inner join comuna on comuna.cor_pro = provincia.cor_pro where apoderado.rut_apo in (select rut_apo from tiene2 where rut_alumno = '$rut_alumno' ) and provincia.cor_pro = apoderado.ciudad and comuna.cor_com = apoderado.comuna and region.cod_reg = comuna.cod_reg and apoderado.relacion = '1'"; 
													  $res_2 = pg_Exec($conn,$sql_2);
													  $num_2 = pg_numrows($res_2);
													  
													  if ($num_2 > 0){
													      $fil_2 = pg_fetch_array($res_2,0);
														  $nombre_apo   = $fil_2['nombre_apo'];
														  $ape_pat_apo  = $fil_2['ape_pat'];
														  $ape_mat_apo  = $fil_2['ape_mat'];
														  $rut_apo      = $fil_2['rut_apo'];
														  $dig_rut      = $fil_2['dig_rut'];
														  $fecha_nac    = $fil_2['fecha_nac'];
														  $fono_apo     = $fil_2['telefono'];
														  $relacion     = $fil_2['relacion'];
														  $email        = $fil_2['email'];
														  $nivel_edu    = $fil_2['nivel_edu'];
														  $calle        = $fil_2['calle'];
														  $nro          = $fil_2['nro'];
														  $villa        = $fil_2['villa'];
														  $region       = $fil_2['nom_reg'];
														  $ciudad       = $fil_2['nom_pro'];
														  $comuna       = $fil_2['nom_com'];
														  
														  $dd = substr($fecha_nac,8,2);
														  $mm = substr($fecha_nac,5,2);
														  $aa = substr($fecha_nac,0,4);
														  
														  $fecha_nac = "$dd-$mm-$aa";
														  
														  if ($relacion == 2){
														      $relacion = "Madre";
														  }
														  if ($relacion == 1){
														     $relacion = "Padre";
														  }	 	  
													  }else{
													      $nombre_apo   = "&nbsp;";
														  $ape_pat_apo  = "&nbsp;";
														  $ape_mat_apo  = "&nbsp;";
														  $rut_apo      = "&nbsp;";
														  $dig_rut      = "&nbsp;";
														  $fecha_nac    = "&nbsp;";
														  $fono_apo     = "&nbsp;";
														  $relacion     = "&nbsp;";
														  $email        = "&nbsp;";
														  $nivel_edu    = "&nbsp;";
														  $calle        = "&nbsp;";
														  $nro          = "&nbsp;";
														  $villa        = "&nbsp;";
														  $region       = "&nbsp;";
														  $ciudad       = "&nbsp;";
														  $comuna       = "&nbsp;";
													  }  	  
													  
													  ?>
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td class="Estilo4">IV. Informaci&oacute;n del Padre <br>
                                                            <br></td>
                                                      </tr>
                                                      <tr>
                                                        <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
                                                              <tr>
                                                                <td colspan="3" bgcolor="#E2E2E2" class="Estilo4">Nombre</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" class="Estilo8"><? echo "$nombre_apo $ape_pat_apo $ape_mat_apo"; ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Rut</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Fecha de Nacimiento </td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Fono</td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><? echo "$rut_apo-$dig_apo"; ?></td>
                                                                <td class="Estilo8"><?=$fecha_nac ?></td>
                                                                <td class="Estilo8"><?=$fono_apo ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Relaci&oacute;n</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">E-mail</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Nivel Educacional</td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><?=$relacion ?></td>
                                                                <td class="Estilo8"><?=$email ?></td>
                                                                <td class="Estilo8"><?=$nivel_edu ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Direcci&oacute;n, calle </td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Nro.</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Villa / Poblaci&oacute;n </td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><?=$calle ?></td>
                                                                <td class="Estilo8"><?=$nro ?></td>
                                                                <td class="Estilo8"><?=$villa ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Regi&oacute;n</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Ciudad</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Comuna</td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><?=$region ?></td>
                                                                <td class="Estilo8"><?=$ciudad ?></td>
                                                                <td class="Estilo8"><?=$comuna ?></td>
                                                              </tr>
                                                          </table></td>
                                                      </tr>
                                                    </table></td>
                                                  </tr>
                                                  
                                                  
                                                </table></td>
											  </tr>
										  </table>
										    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=7&cmb_ano=<?=$cmb_ano ?>&txt=<?=$txt ?>&cmb_inst=<?=$cmb_inst ?>&pesta=1"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><img src="images/imprimir_reporte.gif" width="118" height="14"></td>
                                              </tr>
                                          </table>
									      <? } ?>	  
										  
										  <?
										if ($pesta==1 and $op==7 and $cmb_ano!=0 and $rut_alumno==NULL){ ?>
											<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
												  <tr>
												   <td>
												   
												       <form name="form2" method="post" action="reportesCorporativos.php?pesta=1&op=7&cmb_ano=<?=$cmb_ano ?>">
													   <div align="center" class="Estilo8">
													     <input name="cmb_ano" type="hidden" id="cmb_ano" value="<?=$cmb_ano ?>">
													     B&uacute;squeda de alumnos 
													   <label>
													   <input name="txt" type="text" id="txt" value="<?=$txt ?>" size="20">
													   </label>
													   <label>
													   &nbsp;Establecimiento
													   <select name="cmb_inst" onChange="enviapag3(this.form);">
													    
                                                         <option value="0" selected="selected">Buscar en todos</option>
														  <?
														  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												          $result_ins=@pg_Exec($conn,$qry_ins);
												          for($i=0;$i<pg_numrows($result_ins);$i++){	
													          $fila_ins = pg_fetch_array($result_ins,$i);
													          $rdb = $fila_ins['rdb'];
													          $establecimiento = $fila_ins['nombre_instit']; 
															  ?>
													          <option value="<?=$rdb ?>" <? if ($rdb==$cmb_inst){ ?> selected="selected" <? } ?> ><?=$establecimiento ?></option>
															  <?
														  }
														  ?>
													   
													   </select>
													     &nbsp; <input name="buscar" type="image" src="images/lupa.gif" align="bottom" width="21" height="20">
													   </label>
													    <label></label>
													    <br>
													   <span class="Estilo10">Criterios de b&uacute;squeda<br> 
													   (Rut sin d&iacute;gito verificador, nombre, apellido paterno, apellido materno del alumno)</span> </div>
													   </form>											       </td>
												  </tr> 
												  
                                                  <tr>
                                                    <td><div align="center">Alumnos encontrados para texto <b>&quot;<?=$txt ?>&quot;</b> </div></td>
                                                  </tr>
                                                  <tr>
                                                    <td>
													<?
													if (strlen($txt) > 2){ ?>
													
													<table width="100%" border="0" cellspacing="0" cellpadding="2">
														 <tr>
														 <td width="30%" height="22" bgcolor="#CCCCCC" class="Estilo4">Establecimiento</td>
														 <td width="15%" bgcolor="#CCCCCC" class="Estilo4">Rut Alumno </td>
														 <td width="40%" bgcolor="#CCCCCC" class="Estilo4">Nombre</td>
														 <td width="15%" bgcolor="#CCCCCC" class="Estilo4">Curso</td>
														 </tr>
													<?
													///// consulta de busqueda de alumno en la coooorporacion  ////
													$txt2 = $txt;
													$txt=strtoupper($txt);
													$qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												    $result_ins=@pg_Exec($conn,$qry_ins);
												    for($i=0;$i<pg_numrows($result_ins);$i++){	
													    $fila_ins = pg_fetch_array($result_ins,$i);
													    $rdb = $fila_ins['rdb'];
													    $establecimiento = $fila_ins['nombre_instit'];
													   
													    $query_mat="select matricula.id_curso, matricula.rut_alumno, matricula.id_ano, alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, curso.ensenanza, curso.grado_curso, curso.letra_curso from (matricula inner join alumno on matricula.rut_alumno = alumno.rut_alumno) inner join curso on matricula.id_curso = curso.id_curso where matricula.id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and (alumno.rut_alumno like '%$txt%' or alumno.nombre_alu like '%$txt%' or alumno.ape_pat like '%$txt%' or alumno.ape_mat like '%$txt%' or alumno.rut_alumno like '%$txt2%' or alumno.nombre_alu like '%$txt2%' or alumno.ape_pat like '%$txt2%' or alumno.ape_mat like '%$txt2%')  order by curso.ensenanza, curso.grado_curso, curso.letra_curso";
                                                        $res_mat  = @pg_Exec($conn,$query_mat);
														$num_mat  = @pg_numrows($res_mat);
														
														for ($j=0; $j < $num_mat; $j++){
														    $fil_mat = @pg_fetch_array($res_mat,$j);
														    $rut_alumno = $fil_mat['rut_alumno'];
															$dig        = $fil_mat['dig_rut'];
															$nombre_alu = $fil_mat['nombre_alu'];
															$ape_pat    = $fil_mat['ape_pat'];
															$ape_mat    = $fil_mat['ape_mat'];
															$ensenanza  = $fil_mat['ensenanza'];
															$grado_curso= $fil_mat['grado_curso'];
															$letra_curso= $fil_mat['letra_curso'];
														    if ($ensenanza==10){
															   $ensenanza = "Ed. Parvularia";
															}
															if ($ensenanza==110){
															   $ensenanza = "Ed. Básica";
															}
															if ($ensenanza > 300){
															   $ensenanza = "Ed. Media";
															}         
														
														    if ($cmb_inst=="0"){ ?>
															     <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff' onClick=go('reportesCorporativos.php?rut_alumno=<?=$rut_alumno ?>&pesta=1&op=7&cmb_ano=<?=$cmb_ano ?>&rdb=<?=$rdb ?>&txt=<?=$txt ?>&cmb_inst=<?=$cmb_inst ?>')>
															     <td width="30%" class="Estilo8"><?=$establecimiento ?></td>
															     <td width="15%" class="Estilo8"><? echo "$rut_alumno-$dig"; ?></td>
															     <td width="40%" class="Estilo8"><? echo "$ape_pat $ape_mat $nombre_alu"; ?></td>
															     <td width="15%" class="Estilo8"><? echo "$letra_curso-$grado_curso $ensenanza"; ?></td>
															     </tr> <?															
															}else{															
															     if ($cmb_inst==$rdb){  ?>													
																	 <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff' onClick=go('reportesCorporativos.php?rut_alumno=<?=$rut_alumno ?>&pesta=1&op=7&cmb_ano=<?=$cmb_ano ?>&rdb=<?=$rdb ?>&txt=<?=$txt ?>&cmb_inst=<?=$cmb_inst ?>')>
															         <td width="30%" class="Estilo8"><?=$establecimiento ?></td>
															         <td width="15%" class="Estilo8"><? echo "$rut_alumno-$dig"; ?></td>
															         <td width="40%" class="Estilo8"><? echo "$ape_pat $ape_mat $nombre_alu"; ?></td>
															         <td width="15%" class="Estilo8"><? echo "$letra_curso-$grado_curso $ensenanza"; ?></td>
															         </tr>
															  <? } 
															}  		 
																														
													    }
												   }
												   ?>	
												      </table>	
												  <? } ?>												   </td>
                                                  </tr>
                                                </table></td>
											  </tr>
										  </table>
										    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><img src="images/imprimir_reporte.gif" width="118" height="14"></td>
                                              </tr>
                                          </table>
									      <? } ?>
										  
										  
										   
										
									  </td>
									</tr>
								   </table>								 
							   </td>
							 </tr>
						   </table>
							
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
                             <tr id="asistencia">
                               <td valign="top" class="Estilo1">ASISTENCIA<br>
                                 <br>
								   <table width="100%" border="0" cellpadding="5" cellspacing="0">
								  
							 <tr>
							 	<td valign="top">
								<? if($op==NULL OR $pesta!=2){?>
									   <table width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
										  <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=2&op=1">Asistencia Mensual por Institución</a></td>
									     </tr>
										  <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=2&op=2">Asistencia Mensual tipo de Enseñanza Institución</a></td>
									     </tr>
										  <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=2&op=3">Asistencia de cursos detalle mensual por Institución</a></td>
									     </tr>
										 <tr>
										     <td colspan="2" valign="middle">
											 <form name="form2" method="post" action="reportesCorporativos.php?pesta=1&op=7&cmb_ano=<?=$cmb_ano ?>">
											 <div align="center" class="Estilo8"><br>
											   <br>
											   B&uacute;squeda de alumnos 
													   <label>
													   <input name="txt" type="text" id="txt" size="20">
													   </label>
													   <label>
													   &nbsp;Establecimiento
													   <select name="cmb_inst" id="cmb_inst">
													      <option value="0">Buscar en todos</option>
														  <?
														  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												          $result_ins=@pg_Exec($conn,$qry_ins);
												          for($i=0;$i<@pg_numrows($result_ins);$i++){	
													          $fila_ins = @pg_fetch_array($result_ins,$i);
													          $rdb = $fila_ins['rdb'];
													          $establecimiento = $fila_ins['nombre_instit']; 
															  ?>
													          <option value="<?=$rdb ?>"><?=$establecimiento ?></option>
															  <?
														  }
														  ?>	  
                                                       </select>
													     &nbsp; <input name="buscar" type="image" src="images/lupa.gif" align="bottom" width="21" height="20">
													   </label>
													    <label></label>
													    <br>
											   <span class="Estilo10">Criterios de b&uacute;squeda<br> 
											 (Rut sin d&iacute;gito verificador, nombre, apellido paterno, apellido materno del alumno)</span> </div>
											 </form></td>
								         </tr>				
									</table>										</td>
									</tr>
									<? } ?>	
									<tr>
										<td>
										<? if($pesta==2 && $op==1){ ?>
										<table width="650" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td><form name="form3" action="" method="post">
									    <span class="Estilo8">A&ntilde;o escolar:</span> 
										<input type="hidden" value="<?=$txt ?>" name="txt">
										<select name="cmb_anoA" class="ddlb_x" onChange="enviapag4(this.form);">
										   <option value="0">Seleccione Año</option>
                                           <option value="2008" <? if ($cmb_anoA=="2008"){ ?> selected="selected" <? } ?>>2008</option>
										   <option value="2007" <? if ($cmb_anoA=="2007"){ ?> selected="selected" <? } ?>>2007</option>
										   <option value="2006" <? if ($cmb_anoA=="2006"){ ?> selected="selected" <? } ?>>2006</option>
										   <option value="2005" <? if ($cmb_anoA=="2005"){ ?> selected="selected" <? } ?>>2005</option>
										   <option value="2004" <? if ($cmb_anoA=="2004"){ ?> selected="selected" <? } ?>>2004</option>
										</select>
										<select name="cmb_mesA" class="ddlb_x" onChange="enviapag4(this.form);">
										   <option value="0">Seleccione Mes</option>
                                           <option value="1" <? if ($cmb_mesA=="1"){ ?> selected="selected" <? } ?>>Enero</option>
										   <option value="2" <? if ($cmb_mesA=="2"){ ?> selected="selected" <? } ?>>Febrero</option>
										   <option value="3" <? if ($cmb_mesA=="3"){ ?> selected="selected" <? } ?>>Marzo</option>
										   <option value="4" <? if ($cmb_mesA=="4"){ ?> selected="selected" <? } ?>>Abril</option>
										   <option value="5" <? if ($cmb_mesA=="5"){ ?> selected="selected" <? } ?>>Mayo</option>
										   <option value="6" <? if ($cmb_mesA=="6"){ ?> selected="selected" <? } ?>>Junio</option>
										   <option value="7" <? if ($cmb_mesA=="7"){ ?> selected="selected" <? } ?>>Julio</option>
										   <option value="8" <? if ($cmb_mesA=="8"){ ?> selected="selected" <? } ?>>Agosto</option>
										   <option value="9" <? if ($cmb_mesA=="9"){ ?> selected="selected" <? } ?>>Septiembre</option>
										   <option value="10" <? if ($cmb_mesA=="10"){ ?> selected="selected" <? } ?>>Octubre</option>
										   <option value="11" <? if ($cmb_mesA=="11"){ ?> selected="selected" <? } ?>>Noviembre</option>
										   <option value="12" <? if ($cmb_mesA=="12"){ ?> selected="selected" <? } ?>>Diciembre</option>
										</select>
									    <input name="cmb_inst" type="hidden" id="cmb_inst" value="<?=$cmb_inst ?>">
									 </form> </td>
										  </tr>
										</table>
										<? } ?>
										<? if($cmb_mesA!=0 && $cmb_anoA!=0){
										$valor = diashabiles($cmb_anoA,$cmb_mesA); ?>
										<table width="100%" border="1">
										  <tr>
											<td colspan="5"><div align="center" class="textonegrita">ASISTENCIA MENSUAL POR INSTITUCIÓN</div></td>
										  </tr>
										  <tr>
											<td width="47%" class="tablatit2-1">Instituci&oacute;n </td>
											<td width="15%" class="tablatit2-1"><div align="center">Total Matriculados </div></td>
											<td width="12%" class="tablatit2-1"><div align="center">Total Asistentes </div></td>
											<td width="14%" class="tablatit2-1"><div align="center">Total Inasistentes </div></td>
											<td width="12%" class="tablatit2-1"><div align="center">% Asistencia </div></td>
										  </tr>
										  <? 	$sql = "SELECT a.nombre_instit,a.rdb FROM institucion a WHERE a.rdb in(select rdb from corp_instit where num_corp='$_CORPORACION')";
										  		$res = @pg_exec($conn,$sql);
												for($i=0;$i<pg_numrows($res);$i++){
													$fila =@pg_fetch_array($res,$i);
													$sql = "SELECT count(*) FROM matricula WHERE RDB=".$fila['rdb']." AND date_part('month',fecha)<".$cmb_mesA." AND id_ano in (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila['rdb']." AND nro_ano=".$cmb_anoA." )";
													$res2 = @pg_exec($conn,$sql);
													$Total_M = @pg_result($res2,0);
													
													$sql="SELECT count(*) FROM asistencia WHERE date_part('month',fecha)=".$cmb_mes." AND date_part('year',fecha)=".$cmb_ano." AND id_curso in (SELECT DISTINCT id_curso FROM matricula WHERE
RDB=".$fila['rdb'].")";
													$res3 =@pg_exec($conn,$sql);
													$Total_IN = @pg_result($res3,0);
													if(!isset($Total_IN)) $Total_IN=0;
													
													$sql = "SELECT count(*) FROM feriado WHERE id_periodo IN(
select id_periodo from periodo where id_ano IN (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmb_anoP.") and (date_part('month',fecha_inicio)<=".$cmb_mesP." AND date_part('month',fecha_termino)>=".$cmb_mesP.")) AND id_ano IN (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." and nro_ano=".$cmb_anoP.")";
													$res_fer = @pg_exec($conn,$sql);
													$Feriado = @pg_result($res_fer,0);
													
													$Total_ASI = $Total_M * ($valor - $Feriado);
													if($Total_ASI!=0){
														$Porc = substr(100-((($Total_INA *100)/$Total_ASI)),0,5);
													}else{
														$Porc = "&nbsp;";
													}
										?>
										  <tr>
											<td class="datosB"><div align="left"><?=$fila['nombre_instit'];?></div></td>
											<td class="datosB"><div align="right"><? echo number_format($Total_M,'0',',','.');?></div></td>
											<td class="datosB"><div align="right"><?=$Total_ASI;?></div></td>
											<td class="datosB"><div align="right"><? echo $Total_IN;?></div></td>
											<td class="datosB"><div align="right"><?=$Porc;?></div></td>
										  </tr>
										 <? } ?>
										</table>
										<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
															  <tr>
																<td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&pesta=2"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
																<td width="50%"><a href="printInformeAsistenciaInstitucion.php?cmb_anoA=<? echo $cmb_anoA;?>&cmb_mesA=<? echo $cmb_mesA;?>" target="_blank" ><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
															  </tr>
										  </table>
										<? } ?>									</td>
								</tr>
								 
									<tr>
									  <td>
									   <? if($pesta==2 && $op==2){ ?>
										  <table width="650" border="0">
										 
										  <tr>
											<td>
											
											<form name="form5" action="" method="post">
									    <span class="Estilo8">
										<? 	$sql = "select cod_tipo,nombre_tipo from tipo_ensenanza where cod_tipo in(select distinct cod_tipo from tipo_ense_inst where rdb in(select rdb from corp_instit a where a.num_corp=".$_CORPORACION.")) order by cod_tipo asc";
											$res1 = @pg_exec($conn,$sql);?>Tipo de Ense&ntilde;anza
											<select name="cmb_plan" class="ddlb_x" onChange="enviapag5(this.form);" style="max-width:150">
											  <option value="0" selected="selected">Seleccione Tipo de Enseñanza</option>
											  <? for($i=0;$i<@pg_numrows($res1);$i++){
													$fila_plan = @pg_fetch_array($res1,$i);
														if($fila_plan['cod_tipo']==$cmb_plan){?>
												  <option value="<? echo $fila_plan['cod_tipo'];?>" selected="selected"><? echo $fila_plan['cod_tipo'].",".$fila_plan['nombre_tipo'];?></option>
												  <? }else{?>
												  <option value="<? echo $fila_plan['cod_tipo'];?>"><? echo $fila_plan['cod_tipo'].",".$fila_plan['nombre_tipo'];?></option>
												  <? }
											} ?>
											</select>
                                            <br>
                                            <br>
                                            A&ntilde;o 
									    <select name="cmb_anoP" class="ddlb_x" onChange="enviapag5(this.form);">
										   <option value="0">Seleccione Año</option>
                                           <option value="2008" <? if ($cmb_anoP=="2008"){ ?> selected="selected" <? } ?>>2008</option>
										   <option value="2007" <? if ($cmb_anoP=="2007"){ ?> selected="selected" <? } ?>>2007</option>
										   <option value="2006" <? if ($cmb_anoP=="2006"){ ?> selected="selected" <? } ?>>2006</option>
										   <option value="2005" <? if ($cmb_anoP=="2005"){ ?> selected="selected" <? } ?>>2005</option>
										   <option value="2004" <? if ($cmb_anoP=="2004"){ ?> selected="selected" <? } ?>>2004</option>
										</select>
									    Mes
									    <select name="cmb_mesP" class="ddlb_x" onChange="enviapag5(this.form);">
										   <option value="0">Seleccione Mes</option>
                                           <option value="1" <? if ($cmb_mesP=="1"){ ?> selected="selected" <? } ?>>Enero</option>
										   <option value="2" <? if ($cmb_mesP=="2"){ ?> selected="selected" <? } ?>>Febrero</option>
										   <option value="3" <? if ($cmb_mesP=="3"){ ?> selected="selected" <? } ?>>Marzo</option>
										   <option value="4" <? if ($cmb_mesP=="4"){ ?> selected="selected" <? } ?>>Abril</option>
										   <option value="5" <? if ($cmb_mesP=="5"){ ?> selected="selected" <? } ?>>Mayo</option>
										   <option value="6" <? if ($cmb_mesP=="6"){ ?> selected="selected" <? } ?>>Junio</option>
										   <option value="7" <? if ($cmb_mesP=="7"){ ?> selected="selected" <? } ?>>Julio</option>
										   <option value="8" <? if ($cmb_mesP=="8"){ ?> selected="selected" <? } ?>>Agosto</option>
										   <option value="9" <? if ($cmb_mesP=="9"){ ?> selected="selected" <? } ?>>Septiembre</option>
										   <option value="10" <? if ($cmb_mesP=="10"){ ?> selected="selected" <? } ?>>Octubre</option>
										   <option value="11" <? if ($cmb_mesP=="11"){ ?> selected="selected" <? } ?>>Noviembre</option>
										   <option value="12" <? if ($cmb_mesP=="12"){ ?> selected="selected" <? } ?>>Diciembre</option>
										</select>
										
										
								</span>		
										<input name="cmb_inst" type="hidden" id="cmb_inst" value="<?=$cmb_inst ?>">
									 </form>									 </td>
									</tr>
									 <? } ?>
										</table> 
									      <?	if($cmb_anoP!=0 && $cmb_mesP!=0 && $cmb_plan!=0){
											 		$valor = diashabiles($cmb_anoP,$cmb_mesP);?>
									      <table width="100%" border="0" cellpadding="0" cellspacing="3">
										  <tr>
										    <td colspan="5"><div align="center" class="Estilo1">LISTADO DE ASISTENCIA POR TIPO DE ENSE&Ntilde;ANZA </div></td>
									      </tr>
										  <tr>
										    <td colspan="5">&nbsp;</td>
									      </tr>
										  <tr>
											<td class="tablatit2-1"><div align="center">INSTITUCI&Oacute;N</div></td>
											<td class="tablatit2-1"><div align="center">MATRIC.</div></td>
											<td class="tablatit2-1"><div align="center">ASIST.</div></td>
											<td class="tablatit2-1"><div align="center">INASIST.</div></td>
										    <td class="tablatit2-1"><div align="center">%</div></td>
										  </tr>
										  
										  <? 	$sql = "SELECT rdb, nombre_instit FROM institucion WHERE rdb IN (SELECT rdb FROM corp_instit WHERE num_corp=".$_CORPORACION." AND rdb in(SELECT rdb FROM tipo_ense_inst WHERE cod_tipo=".$cmb_plan."))";
										  		$res2 = @pg_Exec($conn,$sql);
												  for($i=0;$i<@pg_numrows($res2);$i++){
												  	$fila_inst = @pg_fetch_array($res2,$i);
													$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb'];
													$res_ano = @pg_exec($conn,$sql);
													$Ano_Esc = @pg_result($res_ano,0);
													
													$sql = "SELECT count(*) FROM matricula WHERE rdb=".$fila_inst['rdb']." AND date_part('month',fecha)<=".$cmb_mesP." AND id_ano=".$Ano_Esc;
													$res_mat = @pg_exec($conn,$sql);
													$Total_M = @pg_result($res_mat,0);
													
													$sql = "SELECT count(*) FROM asistencia a where date_part('year',fecha)=".$cmb_anoP." AND date_part('month',fecha)=".$cmb_mesP." AND a.ano in(SELECT id_ano FROM ano_escolar WHERE id_institucion IN (SELECT rdb FROM plan_inst WHERE cod_decreto=".$cmb_plan." AND rdb=".$fila_inst['rdb']."))";
													$res_ina = @pg_exec($conn,$sql);
													$Total_INA = @pg_result($res_ina,0);
													if(!isset($Total_INA)) $Total_INA="&nbsp;";
													
													$sql = "SELECT count(*) FROM feriado WHERE id_periodo IN(
select id_periodo from periodo where id_ano IN (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmb_anoP.") and (date_part('month',fecha_inicio)<=".$cmb_mesP." AND date_part('month',fecha_termino)>=".$cmb_mesP.")) AND id_ano IN (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." and nro_ano=".$cmb_anoP.")";
													$res_fer = @pg_exec($conn,$sql);
													$Feriado = @pg_result($res_fer,0);
													
													$Total_ASI = $Total_M * ($valor - $Feriado);
													if($Total_ASI!=0){
														$Porc = substr(100-((($Total_INA *100)/$Total_ASI)),0,5);
													}else{
														$Porc = "&nbsp;";
													}
													
										?>
													  <tr>
														<td height="20" class="Estilo8"><? echo $fila_inst['nombre_instit'];?></td>
														<td height="20" class="Estilo8"><div align="center"><?=$Total_M;?></div></td>
														<td height="20" class="Estilo8"><div align="center"><?=$Total_ASI;?></div></td>
														<td height="20" class="Estilo8"><div align="center"><?=$Total_INA;?></div></td>
														<td height="20" class="Estilo8"><div align="center"><?=$Porc;?></div></td>
													  </tr>
													  
										  <? } ?>
													  <tr>
														 <td colspan="5" class="Estilo8">
														 	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
															  <tr>
																<td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&pesta=2"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
																<td width="50%"><a href="printInformeAsistenciaEnsenanza.php?cmb_anoP=<? echo $cmb_anoP;?>&cmb_mesP=<? echo $cmb_mesP;?>&cmb_plan=<? echo $cmb_plan;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
															  </tr>
															</table>														</td>
									      			  </tr>
										</table>
                        <? } ?>									  </td>
								   </tr>
								   <tr>
									  <td valign="top">
								   <? if($pesta==2 && $op==3){ ?>
									<table width="100%" border="0">
                                        <tr>
                                          <td valign="top"><form name="form6" action="" method="post">
										  <? 	$sql = "SELECT  a.nombre_instit, a.rdb FROM institucion a WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$_CORPORACION.")";
											$res1 = @pg_exec($conn,$sql);?>
										<span class="Estilo8">Institución:</span> 
										<select name="cmb_instI" class="ddlb_x" onChange="enviapag6(this.form);" style="max-width:200">
											<option value="0" selected="selected">Seleccione Institución</option>
											<? for($i=0;$i<@pg_numrows($res1);$i++){
												$fila_inst = @pg_fetch_array($res1,$i);
													if($fila_inst['rdb']==$cmb_instI){?>
													<option value="<? echo $fila_inst['rdb'];?>" selected="selected"><? echo $fila_inst['nombre_instit'];?></option>
													<? }else{?>
													<option value="<? echo $fila_inst['rdb'];?>"><? echo $fila_inst['nombre_instit'];?></option>
													
												<? }
												} ?>
										</select>
									    <br>
									    <br>
									    <span class="Estilo8">A&ntilde;o escolar:</span> 
										<input type="hidden" value="<?=$txt ?>" name="txt">
										<select name="cmb_anoI" class="ddlb_x" onChange="enviapag6(this.form);">
										   <option value="0">Seleccione Año</option>
                                           <option value="2008" <? if ($cmb_anoI=="2008"){ ?> selected="selected" <? } ?>>2008</option>
										   <option value="2007" <? if ($cmb_anoI=="2007"){ ?> selected="selected" <? } ?>>2007</option>
										   <option value="2006" <? if ($cmb_anoI=="2006"){ ?> selected="selected" <? } ?>>2006</option>
										   <option value="2005" <? if ($cmb_anoI=="2005"){ ?> selected="selected" <? } ?>>2005</option>
										   <option value="2004" <? if ($cmb_anoI=="2004"){ ?> selected="selected" <? } ?>>2004</option>
										</select>
										<span class="Estilo8">Mes escolar:</span> 
										<select name="cmb_mesI" class="ddlb_x" onChange="enviapag6(this.form);">
										   <option value="0">Seleccione Mes</option>
                                           <option value="1" <? if ($cmb_mesI=="1"){ ?> selected="selected" <? } ?>>Enero</option>
										   <option value="2" <? if ($cmb_mesI=="2"){ ?> selected="selected" <? } ?>>Febrero</option>
										   <option value="3" <? if ($cmb_mesI=="3"){ ?> selected="selected" <? } ?>>Marzo</option>
										   <option value="4" <? if ($cmb_mesI=="4"){ ?> selected="selected" <? } ?>>Abril</option>
										   <option value="5" <? if ($cmb_mesI=="5"){ ?> selected="selected" <? } ?>>Mayo</option>
										   <option value="6" <? if ($cmb_mesI=="6"){ ?> selected="selected" <? } ?>>Junio</option>
										   <option value="7" <? if ($cmb_mesI=="7"){ ?> selected="selected" <? } ?>>Julio</option>
										   <option value="8" <? if ($cmb_mesI=="8"){ ?> selected="selected" <? } ?>>Agosto</option>
										   <option value="9" <? if ($cmb_mesI=="9"){ ?> selected="selected" <? } ?>>Septiembre</option>
										   <option value="10" <? if ($cmb_mesI=="10"){ ?> selected="selected" <? } ?>>Octubre</option>
										   <option value="11" <? if ($cmb_mesI=="11"){ ?> selected="selected" <? } ?>>Noviembre</option>
										   <option value="12" <? if ($cmb_mesI=="12"){ ?> selected="selected" <? } ?>>Diciembre</option>
										</select>
										
										
										
												
									    <input name="cmb_inst" type="hidden" id="cmb_inst" value="<?=$cmb_inst ?>">
									 </form></td>
                                        </tr>
										</table> 
										<? } ?>
										</td>
										</tr>
										<tr valign="top">
                                          <td valign="top">
										<? if($cmb_anoI!=0 && $cmb_mesI!=0 && $cmb_instI!=0){
												$valor = diashabiles($cmb_anoI,$cmb_mesI);
												$sql = "SELECT id_curso,grado_curso,letra_curso FROM curso WHERE id_ano in (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$cmb_instI." AND nro_ano=".$cmb_anoI.") ORDER BY grado_curso, letra_curso";
												$res = @pg_exec($conn,$sql);
												?>
                                        <table width="100%" border="1" cellpadding="3" cellspacing="0" class="tabla02">
                                            <tr valign="top">
                                              <td class="tablatit2-1"><div align="center">CURSOS</div></td>
                                              <td class="tablatit2-1"><div align="center">MATRICULADOS</div></td>
                                              <td class="tablatit2-1"><div align="center">ASISTENTES</div></td>
                                              <td class="tablatit2-1"><div align="center">INASISTENTES</div></td>
                                              <td class="tablatit2-1"><div align="center">%</div></td>
                                            </tr>
											<? for($i=0;$i<@pg_numrows($res);$i++){
												$fila_curso = @pg_fetch_array($res,$i);
												$sql = "SELECT count(*) FROM matricula WHERE id_curso=".$fila_curso['id_curso']." AND date_part('month',fecha)<=".$cmb_mesI;
												$res2 = @pg_exec($conn,$sql);
												$Total_M = @pg_result($res2,0);
												
												$sql = "SELECT count(*) FROM asistencia WHERE id_curso=".$fila_curso['id_curso']." and date_part('month',fecha)=".$cmb_mesI;
												$res3 = @pg_exec($conn,$sql);
												$Total_INA = @pg_result($res3,0);
												if(isset($Total_INA)) $Total_INA= "&nbsp;";
												
												$sql = "SELECT count(*) FROM feriado WHERE id_periodo IN(
select id_periodo from periodo where id_ano IN (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$cmb_instI." AND nro_ano=".$cmb_anoI.") and (date_part('month',fecha_inicio)<=".$cmb_mesI." AND date_part('month',fecha_termino)>=".$cmb_mesI.")) AND id_ano IN (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$cmb_instI." and nro_ano=".$cmb_anoI.")";
												$res_fer = @pg_exec($conn,$sql);
												$Feriado = @pg_result($res_fer,0);
												
												$Total_ASI = $Total_M * ($valor - $Feriado);
												if($Total_ASI!=0){
													$Porc = substr(100-((($Total_INA *100)/$Total_ASI)),0,5);
												}else{
													$Porc = "&nbsp;";
												}
											?>	
                                            <tr>
                                              <td class="Estilo8"><div align="center"><?=$fila_curso['grado_curso']." ".$fila_curso['letra_curso'];?></div></td>
                                              <td class="Estilo8"><div align="center"><?=$Total_M;?></div></td>
                                              <td class="Estilo8"><div align="center"><?=$Total_ASI;?></div></td>
                                              <td class="Estilo8"><div align="center"><?=$Total_INA;?></div></td>
                                              <td class="Estilo8"><div align="center"><?=$Porc;?></div></td>
                                            </tr>
											<? } ?>
                                          </table>
										 </td>
                                        </tr>
										<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
										  <tr>
											<td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&pesta=2"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
											<td width="50%"><a href="printInformeAsistenciaCurso.php?cmb_anoI=<? echo $cmb_anoI;?>&cmb_mesI=<? echo $cmb_mesI;?>&cmb_instI=<? echo $cmb_instI;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
										  </tr>
										</table>	
										<? } ?>
                                      </table></td>
								     </tr>
									 	
							</table>
							
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
                             <tr id="opcion3">
                               <td valign="top">&nbsp;</td>
							 </tr>
							</table>
							
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
                             <tr id="opcion4">
                               <td valign="top">&nbsp;</td>
							 </tr>
							</table>
							
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
                             <tr id="opcion5">
                               <td valign="top">&nbsp;</td>
							 </tr>
							</table>   
						 
						 </td>
					     </tr>
					  </table> 
					  <!-- FIN CUERPO REPORTE DE CORPORACIONES -->					  
					  </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2007 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
    </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
