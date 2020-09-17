<?php require('../../util/header.inc');
	

$corporacion   =$_CORPORACION;
$ano		   = $_ANO;

//echo $cantidad;

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
num=0;
resta=0;
curso=0;
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function muestra_tabla(tabla,span){
	t=document.getElementById(tabla);
	span2=document.getElementById(span);
	temp=document.getElementById(tabla).style.display;
	document.getElementById('matricula').style.display='none';
	document.getElementById('opcion2').style.display='none';
	document.getElementById('notas').style.display='none';
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
    form.submit(true);		
}
function enviapag3(form2){
    form2.submit(true);		
}
function enviapagNOTAS(form3){
    form3.submit(true);		
}
function enviapag4(f1){
    f1.submit(true);		
}
function enviapag5(f2){
    f2.submit(true);		
}

nume=0;
x=0;
function crear(obj) {
  nume++;
  var valor=document.getElementById(obj).checked;
  //arreglo=new array();
  //arreglo[nume]=valor;
  //alert(arreglo[nume]);
  //fi = document.getElementById('fiel'); 
  //contenedor = document.createElement('div'); 
  //contenedor.id = 'div'+nume; 
  //fi.appendChild(contenedor); 

  //ele = document.createElement('input'); 
  //ele.type = 'text'; 
 // ele.name = 'cursos'+nume; 
 // ele.value = document.getElementById(obj).value;
  //contenedor.appendChild(ele); 
  if(valor==true){
  num++;
 // alert(num);
  }else{
  --num;
  //alert(num);
  }
  //alert('resta:'+x);       
}

//function enviapag6(idInput){
/*if(document.getElementById(idInput).cheched=true){
num++;		
  	var valor=document.getElementById(idInput).value;
		// Obtenemos el div contenedor del futuro input
		//var divContenedor = document.createElement("contenedores"); 
		//divContenedor.id=curso;
		//fi.appendChild(divContenedor); 
		var divContenedor=document.getElementById("contenedores");
		// Creamos el input
		alert(idInput);
		alert(curso);
		divContenedor.innerHTML="<input type='text' id='curso"+curso+"' name='curso"+curso+"' value='"+valor+"'>";
		// Colocamos el cursor en el input creado
		//document.getElementById(idInput).focus();
		//document.getElementById(idInput).select();
		// Establecemos a true la variable para especificar que hay un input en pantalla y no se debe crear otro hasta que este se oculte
	//	mostrandoInput=true;
	//}
 curso++;
 }
 */
  
//}

function enviapag7(f4){
    f4.action='reporteCalificacionesCorporacion2.php';
	f4.submit(true);
}
function enviapag8(idInput){
resta++;		
	var valor=document.getElementById(idInput).value;
//	f3.action='reportesCorporativos.php?cantidad='+num;

}
function ver(f3){
//alert(num);
valor = num;
f3.action='reportesCorporativos.php?cantidad='+valor;
f3.submit(true);

}
function enviapagReporte(form3){
	form3.target='_blank';
	form3.action='reporteCalificacionesCorporacion2.php';
	form3.submit(true);
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
#subsectores { width: 400px;
height: 200px;
/*background-color: #366;*/
float: left;
position:relative; 
border: 1px solid #808080; 
overflow: auto; 
top:0px; 
left:0px; 

}

-->
</style>
</head>
<script>
	document.getElementById('matricula').style.display='none';
	document.getElementById('opcion2').style.display='none';
	document.getElementById('notas').style.display='none';
	document.getElementById('opcion4').style.display='none';
	document.getElementById('opcion5').style.display='none';
	t.style.display="";
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="
<? if (($pesta == "") or ($pesta == NULL) or ($pesta == " ") or ($pesta == 1) or (!isset($pesta))){ ?>
      muestra_tabla('matricula','pesta1'); <?
   } 
   if ($pesta == 2){ ?>
      muestra_tabla('opcion2','pesta2'); <?
   }
   if ($pesta == 3){ ?>
      muestra_tabla('notas','pesta3'); <?
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
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%"><tr><td><?
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
						 ?>					  </td>
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
						        <td width="20%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('opcion2','pesta2');"><span id="pesta2" class="span_normal" >Opcion 2 </span></a></div></td>
						        <td width="20%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('notas','pesta3');"><span id="pesta3" class="span_normal" >Calificaciones </span></a></div></td>
						        <td width="20%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('opcion4','pesta4');"><span id="pesta4" class="span_normal" >Opcion 4 </span></a></div></td>
						        <td width="20%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('opcion5','pesta5');"><span id="pesta5" class="span_normal" >Opcion 5 </span></a></div></td>
						      </tr>
						   </table>						 </td>
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
									 </form>					               </td>
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
											 </form>											 </td>
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
									      <? } ?>										</td>
									</tr>
								   </table>								 </td>
							 </tr>
							</table>
							
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
                             <tr id="opcion2">
                               <td valign="top">&nbsp;</td>
							 </tr>
							</table>
							
							<table width="100%" border="0"  cellpadding="0" cellspacing="0">
                             <tr id="notas" >
                               <td valign="top">
							   <form name="frm_aux" method="post">
							   <input name="pesta" value="3" type="hidden">
							   <br>
							   <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                 <tr class="Estilo4">
                                   <td height="19">&nbsp;Buscador </td>
                                   <td height="19">:</td>
                                   <td height="19">&nbsp;</td>
                                 </tr>
                                 <tr class="Estilo4">
                                   <td width="23%" height="19">&nbsp;Instituciones</td>
                                   <td width="2%">: </td>
								   <td width="75%"><form method="post" name="f1"  action="">
                                     <select name="cmb_ins" id="cmb_ins" class="ddlb_x" onChange="enviapag4(this.form);">
                                       <option value="0" selected="selected">Seleccione Institucion</option>
                                       <?
								 	$sql = "select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit ";
									$sql.= "from corp_instit,institucion where corp_instit.num_corp = '$corporacion' ";
									$sql.= "and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
									
									$rs_inst= @pg_exec($conn,$sql);  
								    for($i=0;$i<pg_numrows($rs_inst);$i++){
										  $combo=pg_fetch_array($rs_inst,$i);
									      if($combo['rdb']==$cmb_ins){								   				   
								   ?>
                                       <option value="<?=$combo['rdb'];?>" selected="selected">
                                       <?=ucfirst($combo['nombre_instit']);?>
                                       </option>
                                       <? }else{ ?>
                                       <option value="<?=$combo['rdb'];?>">
                                       <?=ucfirst($combo['nombre_instit']);?>
                                       </option>
                                       <? }
		 } ?>
                                     </select>
                                   </form>								   </td>
                               <?
												   if($cmb_ins!=0){
				   	$sql_ano="select max(id_ano) as ano_escolar from ano_escolar where id_institucion=$cmb_ins";
								   	$rs_ano= @pg_exec($conn,$sql_ano);
								   	$ano_2 = pg_result ($rs_ano,0);
								   	
								   }
								   ?>
                             </tr>
                                 <tr class="Estilo4">
                                   <td>&nbsp;Tipo Ense&ntilde;anza </td>
                                   <td>:</td>
                                   <td><FORM method="post" name="f2" action="">
								   <input name="pesta" value="3" type="hidden">
								   <select name="cmb_en" id="cmb_en" class="ddlb_x"  onChange="enviapag5(this.form);">
								   		<option value="0" selected="selected">Seleccione Tipo Enseñanza</option>
										<?
										$sql_ense = "select distinct tipo_ense_inst.cod_tipo,tipo_ensenanza.nombre_tipo";
										$sql_ense.= " from tipo_ense_inst, tipo_ensenanza where tipo_ense_inst.cod_tipo = ";
										$sql_ense.= "tipo_ensenanza.cod_tipo  ";
									if($cmb_ins==0){
										$sql_ense.= "and rdb in (select rdb from corp_instit where num_corp='$corporacion') ";	
											}else{
										$sql_ense.= "and tipo_ense_inst.rdb='$cmb_ins' ";
											}	
																								
  										$rs_ense= pg_exec($conn,$sql_ense);  
								    for($j=0;$j<pg_numrows($rs_ense);$j++){
										  $combo_ense=pg_fetch_array($rs_ense,$j);
									      if($combo_ense['cod_tipo']==$cmb_en){			
										?>
		<option value="<?=$combo_ense['cod_tipo'];?>" selected="selected"><?=ucfirst($combo_ense['nombre_tipo']);?></option>
            <? }else{ ?>
         <option value="<?=$combo_ense['cod_tipo'];?>"><?=ucfirst($combo_ense['nombre_tipo']);?></option>
          <? }
		 } ?>
                                     </select>
									 <?
									$ano1=$ano_2;
									$inst1=$cmb_ins;
								//	echo $sql_ense;
								//  echo "ano:".$ano1;
								//  echo "<br>rdb:".$cmb_ins;
								//  echo "<br>ense:".$cmb_en;
									 
									 
									 ?>
									<input type="hidden" name="cmb_ins" value="<?=$inst1?>">
									 </FORM></td>
								</tr>
                                 <tr class="Estilo4">
								 <FORM method="post" name="f3" action="">
								 <input name="pesta" value="3" type="hidden">
								 <input type="hidden" name="cmb_ins" value="<?=$inst1?>">
								 <input type="hidden" name="cmb_en" value="<?=$cmb_en?>">
								 
                                   <td>&nbsp;Curso
								   </td>
                                   <td>:</td>
                                   <td>
								   
								   <? if($cmb_ins!=0){ //or $cmb_en!=0?>
								   <?
								   		$sql_ens1 ="select distinct tipo_ense_inst.cod_tipo,tipo_ensenanza.nombre_tipo ";
								  		$sql_ens1.="from tipo_ense_inst, tipo_ensenanza where tipo_ense_inst.cod_tipo = ";
							  		    $sql_ens1.="tipo_ensenanza.cod_tipo";
							if($cmb_ins==0){	
										
								}else{
								 	    $sql_ens1.=" and tipo_ense_inst.rdb='$cmb_ins' ";
								}
								if($cmb_en==0){                          
								   				
									}else{
									    $sql_ens1.=" and tipo_ense_inst.cod_tipo=$cmb_en";
									}	
									$rs_ense1= pg_exec($conn,$sql_ens1);	
									$dig=0;				   
								   for($x=0;$x<pg_numrows($rs_ense1);$x++){
								   	 $ense=pg_fetch_array($rs_ense1,$x);
									 echo "<br>";
									 echo $ense['nombre_tipo'];
									 echo "<br>";
									 $cod_tipo=$ense['cod_tipo'];
									
								 $sql_cursos="SELECT distinct curso.ensenanza, curso.grado_curso,tipo_ensenanza.nombre_tipo ";
								 $sql_cursos.="FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = ";
								 $sql_cursos.="tipo_ensenanza.cod_tipo WHERE (((curso.id_ano)=$ano_2)) and ";
								 $sql_cursos.=" curso.ensenanza=$cod_tipo ORDER BY curso.ensenanza";
								 $rs_cursos= @pg_exec($conn,$sql_cursos);
								for($k=0;$k<pg_numrows($rs_cursos);$k++){
								   $cursos=pg_fetch_array($rs_cursos,$k);
								  if($cursos['ensenanza']!=NULL){
								  	$grado=$cursos['grado_curso'];
									echo $cursos['grado_curso'];
									$check="checkbox".$dig;
								//	if ($caso != $cod_tipo."_".$grado){
								//	echo "<input type='checkbox' name='".$cod_tipo."_".$grado."' id='".$cod_tipo."_".$grado."' value='".$cod_tipo."_".$grado."' checked='checked' onClick='enviapag6(this.form,this.id);'  />";
								//	}else{
									echo "<input onClick='crear(this.id)' type='checkbox' name=".$check." value='".$cod_tipo."_".$grado."' id='checkbox".$x.$k."'/>";
									//}
								  }else{
								 	echo "No Hay Cursos";
								   	}
									$dig++;
								}
								   ?>
								
								   <? }?>
								   <? }else{// sin nada ni tipo ense e insti 
								 $sql1="select distinct tipo_ense_inst.cod_tipo,tipo_ensenanza.nombre_tipo from ";
								 $sql1.="tipo_ense_inst, tipo_ensenanza where tipo_ense_inst.cod_tipo = tipo_ensenanza.cod_tipo ";
								 $sql1.="and rdb in (select rdb from corp_instit where num_corp='$corporacion')";
							  if($cmb_en==0){
							   							  
							  	}else{
							     $sql1.=" and tipo_ensenanza.cod_tipo=$cmb_en";
							 	 }
								 $rs_sql1=pg_exec($conn,$sql1);
								 $dig=0;
							for($y=0;$y<pg_numrows($rs_sql1);$y++){  
								 $fila=pg_fetch_array($rs_sql1,$y);
								 echo "<br>";
								 echo $fila['nombre_tipo'];
								 echo "<br>";
								 $cod_tipo=$fila['cod_tipo'];
								   
									$sql="SELECT distinct a.ensenanza,grado_curso,b.nombre_tipo FROM curso a INNER JOIN ";
									$sql.="tipo_ensenanza b ON (a.ensenanza =b.cod_tipo) INNER JOIN ano_escolar c ON ";
									$sql.="(a.id_ano=c.id_ano) INNER JOIN corp_instit d ON (c.id_institucion=d.rdb) ";
					   	    	    $sql.="where d.num_corp='$corporacion' and a.ensenanza=$cod_tipo ";
							
									$rs_sql=pg_exec($conn,$sql);
								      for($z=0;$z<pg_numrows($rs_sql);$z++){
									     $curso=pg_fetch_array($rs_sql,$z);
								 			 if($curso['ensenanza']!=NULL){
											    $grado=$curso['grado_curso'];
												$check = "checkbox".$dig;
												//echo $value = $cod_tipo."_".$grado;
								    			echo $curso['grado_curso'];
												echo "<input onClick='crear(this.id)' type='checkbox' name='".$check."' value='".$cod_tipo."_".$grado."' id='checkbox".$y.$z."' />";
								  }else{
								 				echo "No Hay Cursos";
								   	   }
									   $dig++;
								     }
								   }
								 }
								   ?><br>
								   <input align="right" type="button" name="Submit" value="Ver Asignaturas" onClick="ver(this.form)">
                                  <div id="fiel"></div>	
								   </td>
								   												
								   </FORM>
								  
                                 </tr>
                                 <tr class="Estilo4">
                                   <td valign="top">&nbsp;Asignaturas</td>
                                   <td valign="top">:</td>
								    <td valign="top">
								<? 
								
				if($cantidad!=0){
				
					if($cmb_ins!=0 and $cmb_en==0){ 
					      $sql_3.=" select distinct a.cod_subsector, b.nombre from ramo a inner join subsector b on ";
						  $sql_3.=" (a.cod_subsector=b.cod_subsector) inner join curso c on (a.id_curso=c.id_curso) ";
						  $sql_3.=" inner join ano_escolar d on (d.id_ano=c.id_ano) inner join corp_instit e on ";
						  $sql_3.=" (e.rdb=d.id_institucion) where e.num_corp='$corporacion' and e.rdb='$cmb_ins' and d.id_ano='$ano1' ";
					  
					 }else{
					 
					   if($cmb_ins==0 and $cmb_en==0){
					      $sql_3.=" select distinct a.cod_subsector, b.nombre from ramo a inner join subsector b on ";
						  $sql_3.=" (a.cod_subsector=b.cod_subsector) inner join curso c on (a.id_curso=c.id_curso) ";
						  $sql_3.=" inner join ano_escolar d on (d.id_ano=c.id_ano) inner join corp_instit e on ";
						  $sql_3.=" (e.rdb=d.id_institucion) where e.num_corp='$corporacion' ";
					   }else{
					   	   
											
						if($cmb_ins!=0){
						
						    $sql_3="select distinct ramo.cod_subsector,subsector.nombre from ramo inner join subsector on ";
							$sql_3.=" ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso ";
							$sql_3.=" from curso where id_ano=$ano1 and id_ano in (select id_ano from ano_escolar where ";
							$sql_3.=" id_institucion in (select rdb from corp_instit where num_corp='$corporacion' ) and id_institucion='$cmb_ins') ";
											
						}else{
							$sql_3="select distinct ramo.cod_subsector,subsector.nombre from ramo inner join subsector on ";
							$sql_3.=" ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso ";
							$sql_3.=" from curso where id_ano in (select id_ano from ano_escolar where ";
							$sql_3.=" id_institucion in (select rdb from corp_instit where num_corp='$corporacion'))";
					      }
						}
					}	   					
							$xx=0;
							$var3=0;
						    $var4=0;
							$sql_tipo_ense="select distinct tipo_ense_inst.cod_tipo,tipo_ensenanza.nombre_tipo from ";
							$sql_tipo_ense.="tipo_ense_inst, tipo_ensenanza where tipo_ense_inst.cod_tipo = tipo_ensenanza.cod_tipo ";
							$sql_tipo_ense.="and rdb in (select rdb from corp_instit where num_corp='$corporacion')";
							$rs_sql_tipo_ense=pg_exec($conn,$sql_tipo_ense);	
							  
						   
						for($a=0;$a<pg_numrows($rs_sql_tipo_ense);$a++){  
								 $fila_tipo_ense=pg_fetch_array($rs_sql_tipo_ense,$a);
								 $cod_tipo_ense=$fila_tipo_ense['cod_tipo'];
								 $var=0;
							     $var2=0;
									$sql_cursos="SELECT distinct a.ensenanza,grado_curso,b.nombre_tipo FROM curso a INNER JOIN ";
									$sql_cursos.="tipo_ensenanza b ON (a.ensenanza =b.cod_tipo) INNER JOIN ano_escolar c ON ";
									$sql_cursos.="(a.id_ano=c.id_ano) INNER JOIN corp_instit d ON (c.id_institucion=d.rdb) ";
					   	    	    $sql_cursos.="where d.num_corp='$corporacion' and a.ensenanza=$cod_tipo_ense ";
									$rs_sql_cursos=pg_exec($conn,$sql_cursos);
									
								      for($b=0;$b<pg_numrows($rs_sql_cursos);$b++){
									     $cursos=pg_fetch_array($rs_sql_cursos,$b);	
										 $valor = $_POST["checkbox".$var3];
										//echo "<br/>";
										// $valor3 = strstr($valor,"_");
									   //  $grado_prueba = substr($valor3,1);
										 if(trim($valor)==NULL){
																				
										 }else{
										 
										$arreglo[$xx]=$valor;
									//	echo "<br/>";
										 $xx++;
										 }
										
									//	 $var=0;
						//------------------------VER------------------------	
						      
						if($cmb_ins!=0 and $cmb_en==0){  //-------($cmb_ins==0 or agregar?
					//	echo "aca";
						  if($valor==NULL){
								
								
								}else{		 
								  if($cmb_ins!=0 and $cmb_en==0){
									   $ense2 = strtok($valor,"_");
								  if($var2==0){
									 if($var4==0){
									   $sql_3.=" and ((c.ensenanza=$ense2";
									  }else{
									   $sql_3.=" and (c.ensenanza=$ense2";
									  }
									   $var2=$ense2;
									   $var3=$ense2;
									   $var4=$ense2;
									     }else{
									if($var3==$ense2){
									
									     }else{
									   $sql_3.=" or (c.ensenanza=$ense2";
									       }
									     }
									   
									   }
						  if($ense2==NULL){
						  
						       }else{
							   
								  if($var==0){
								      $valor2 = strstr($valor,"_");
									  $grado = substr($valor2,1);
									  $sql_3.= " and (c.grado_curso=$grado ";
									  $var++;
									}else{
								      $valor2 = strstr($valor,"_");
									  $grado = substr($valor2,1);
									  $sql_3.= " or c.grado_curso=$grado ";
									// $var++;
									}
						            $sql_3.="))";
							    }
							  }
							
						//---------------------------------------------------------
						}else{
						//echo "aki";
						    if($valor!=NULL){
									if($var==0){
										 $ense = strtok($valor,"_");
										  }else{
										 
										 }
									  if(trim($ense)!=$var){ 
									 	 $sql_3.=" and (ensenanza=$ense";
										 $var=$ense;
										   }else{
										 $sql3.=" or (ensenanza=$ense";
										  
										   }
									
									    $valor2 = strstr($valor,"_");
										$grado = substr($valor2,1);
									if($var2==0){
										
									    $sql_3.=" and (grado_curso=$grado ";
							   	        $var2++;
									  }else{
												
										$sql_3.=" or grado_curso=$grado";
									  }		
																											
									     }else{
																				 										 
								     } 
								}	
									
								$var3++;									   
							}//$sql_3.="))";
							
						}	$sql_3.="))";		
						if($cmb_ins!=0 and $cmb_en==0){   //--------------($cmb_ins==0 or agregar?
								//echo "entre";							
								$sql4 = eregi_replace( " )) or ", " or ", $sql_3);
								$sql5 = eregi_replace( " )) and ",")) or ", $sql4);
						 		$sql5.=")";
								$sql6= eregi_replace( ")))",")", $sql5);
								$sql_3=$sql6;
								
																			
								}
		                         if($cmb_ins!=0 and $cmb_en==0){ //--------($cmb_ins==0 or agregar?
								
								 }else{
								 
								 
								 $sql_3 = ereg_replace( " and  "," )) or ", $sql_3);
								// $sql5 = eregi_replace( " )) and ",")) or ", $sql4);
								 $sql_3.=")";
								// $sql_3;
								// $sql_3=$sql4;
									 }
						             
								 $rs_sql3=pg_exec($conn,$sql_3);
							     $sql_3;
						}
								 ?>
								 <br>
								 <form action="" method="post" name="f4" target="_blank">
								
								 
								 <div id="subsectores" > 
								 	 
								<?   
																	
									 $total=pg_numrows($rs_sql3);
								for($f=0;$f<pg_numrows($rs_sql3);$f++){ 
									 $sub=pg_fetch_array($rs_sql3,$f);
									 $nombre=$sub['nombre'];
									 $cod_ensen=$sub['ensenanza'];
									 $cod=$sub['cod_subsector'];
									 
				echo "<input type='checkbox' name='chek".$f."' value='".$nombre."_".$cod."' checked='checked' />".$sub['nombre'];
				echo "<br>";
						
								   
								  }
								 
								?>
								 
								 </div>
								  
                                 <tr>
								 
                                   <td valign="top" colspan="3">
								   </td>
                                 </tr>
                                 <tr>
                                   <td colspan="3">&nbsp;</td>
                                 </tr>
                                 <tr>
								 <?   for($g=0;$g<$cantidad;$g++){
								    
									//echo $arreglo[$g];
								      
								  ?>
								 		
                                <input type="hidden" name="arreglo[]" value="<?=$arreglo[$g];?>">	  
									 	 		 
								 <? }?>                        
                                  <td  align="center"colspan="3">
								 <? if($cmb_ins!=0){?>
								 <input type="hidden" value="<?=$cmb_ins;?>" name="rdb">
								 <? }?>
								 <? if($cmb_en!=0){?>
								 <input type="hidden" value="<?=$cmb_en;?>" name="ensenanza">
								 <? }?>			
                                					
								<input type="hidden" value="<?=$cantidad;?>" name="cantidad">
								<input type="hidden" value="<?=$total;?>" name="total">
								<input  align="middle" type="button" name="Submit" value="Buscar" onClick="enviapag7(this.form)"/>
								</form>
								</td>
								 </tr>
                               </table>
							   <br>
							   << Reporte en proceso de construcción >>
							   <!--
							   <table width="100%" border="0" cellpadding="3" cellspacing="3">
                                   <tr>
                                     <td colspan="3" class="Estilo1">CALIFICACIONES POR INSTITUCI&Oacute;N </td>
                                   </tr>
                                   <tr>
                                     <td width="37%" class="Estilo1">&nbsp;</td>
                                     <td width="60%">&nbsp;</td>
                                     <td width="3%" rowspan="7">&nbsp;</td>
                                   </tr>
                                   <tr>
                                     <td class="Estilo1"><div align="right" class="Estilo4">A&Ntilde;O ESCOLAR (*)</div></td>
                                     <td><select name="cmbANO" onChange="javascript:enviapagNOTAS(this.form)">
									 <option value="0">Seleccione</option>
									 <? $sql ="SELECT DISTINCT nro_ano FROM ano_escolar WHERE id_institucion in (SELECT rdb FROM corp_instit WHERE num_corp=$_CORPORACION)";
									 	$result = @pg_exec($conn,$sql);
										for($i=0; $i<@pg_numrows($result); $i++){
											$fila = @pg_fetch_array($result,$i);
											if($cmbANO==$fila['nro_ano']){ ?>
											 	<option value="<?=$fila['nro_ano'];?>" selected="selected"><?=$fila['nro_ano'];?></option>
										<? }else{ ?>
											 	<option value="<?=$fila['nro_ano'];?>"><?=$fila['nro_ano'];?></option>
									<? 	   }
										}
									 ?>
                                     </select></td>
                                   </tr>
								   <? if($pesta==3 && $cmbANO!=""){?>
                                   <tr>
                                     <td class="Estilo4"><div align="right">INSTITUCION</div></td>
                                     <td><select name="cmbINST" onChange="javascript:enviapagNOTAS(this.form)">
									 <option value="0">Seleccione</option>
									 <? if($cmbANO!=0){
									 		 $inner = " INNER JOIN ano_escolar ON institucion.rdb=ano_escolar.id_institucion ";
									  		 $wer = "  AND ano_escolar.nro_ano=$cmbANO";
										}	
									 	$sql = "SELECT rdb,nombre_instit FROM institucion $inner WHERE rdb in(SELECT rdb FROM corp_instit WHERE num_corp=$_CORPORACION) $wer";
									 	$result = @pg_exec($conn,$sql);
										for($i=0; $i<@pg_numrows($result); $i++){
											$fila = @pg_fetch_array($result,$i);
											if($cmbINST==$fila['rdb']){ ?>
												<option value="<?=$fila['rdb'];?>" selected="selected"><?=$fila['nombre_instit'];?></option>
											<? }else{ ?>
												<option value="<?=$fila['rdb'];?>" ><?=$fila['nombre_instit'];?></option>
											<? }
										} ?>
                                     </select>                                     </td>
                                   </tr>
                                   <tr>
                                     <td class="Estilo4"><div align="right">TIPO ENSE&Ntilde;ANZA (*) </div></td>
                                     <td><select name="cmbENSENANZA" onChange="javascript:enviapagNOTAS(this.form)">
									 <option value="0">Seleccione</option>
									 <? $sql = "SELECT DISTINCT a.cod_tipo, b.nombre_tipo FROM tipo_ense_inst a INNER JOIN tipo_ensenanza b ON ";
									 	$sql.="a.cod_tipo=b.cod_tipo WHERE  a.rdb IN (select RDB from corp_instIT WHERE num_corp=$_CORPORACION) AND a.cod_tipo<>10 ";
									 	if($cmbINST!=0){
											$sql.=" AND a.rdb=".$cmbINST;
										}
										$resultTE = @pg_exec($conn,$sql);
										for($i=0; $i<@pg_numrows($resultTE); $i++){
											$fila= @pg_fetch_array($resultTE,$i);
											if($cmbENSENANZA==$fila['cod_tipo']){ ?>
											<option value="<?=$fila['cod_tipo'];?>" selected="selected"><? echo $fila['cod_tipo'].",".$fila['nombre_tipo'];?></option>
										<?	}else{ ?>
											<option value="<?=$fila['cod_tipo'];?>"	><? echo $fila['cod_tipo'].",".$fila['nombre_tipo'];?></option>	
										
									<? }
									} ?>		
										
                                     </select>
                                       </td>
                                   </tr>
                                   <tr>
                                     <td class="Estilo4"><div align="right">GRADO</div></td>
                                     <td class="Estilo8">1
                                       <input type="checkbox" name="grado1" value="1"> 
                                       2
                                       <input type="checkbox" name="grado2" value="2"> 
                                       3
                                       <input type="checkbox" name="grado3" value="3"> 
                                       4
                                       <input type="checkbox" name="grado4" value="4">
                                       5
                                       <input type="checkbox" name="grado5" value="5"> 
                                       6
                                       <input type="checkbox" name="grado6" value="6"> 
                                       7 
                                       <input type="checkbox" name="grado7" value="7"> 
                                       8 
                                       <input type="checkbox" name="grado8" value="8">
                                       9
                                       <input type="checkbox" name="grado9" value="9">
                                       10
                                       <input type="checkbox" name="grado10" value="10">
                                       11
                                       <input type="checkbox" name="grado11" value="11">
                                       12
                                       <input type="checkbox" name="grado12" value="12">
									 </td>
                                   </tr>
                                   <tr>
                                     <td class="Estilo4"><div align="right">ASIGNATURA (*)</div></td>
                                     <td><div style="overflow:auto; height:185px">
									 <? $sql = "SELECT DISTINCT ramo.cod_subsector,subsector.nombre FROM ramo INNER JOIN subsector ON ";
									 	$sql.= " ramo.cod_subsector=subsector.cod_subsector WHERE id_curso in (SELECT id_curso FROM curso WHERE id_ano in ";
										$sql.= "(SELECT id_ano FROM ano_escolar WHERE id_institucion in (select rdb FROM corp_instit WHERE num_corp=$_CORPORACION) ";
										if($cmbINST!=0){
											$sql.=" AND id_institucion=".$cmbINST." ";
										}
											$sql.=") ";
										if($cmbENSENANZA!=0){
											$sql.=" AND ensenanza=".$cmbENSENANZA." ";
										}
											$sql.=")";
										$result = pg_exec($conn,$sql);
										$contSubsector = pg_numrows($result);
									?>
									<input name="contSubsector" type="hidden" value="<?=$contSubsector;?>">
									 <table width="%" border="1" cellpadding="2" cellspacing="0">
									  <? for($i=0; $i<pg_numrows($result); $i++){
									  		$fils = pg_fetch_array($result,$i);	?>
									  <tr>
										<td class="Estilo8"><input name="cod_subsector<?=$i;?>" type="checkbox" value="<?=$fils['cod_subsector'];?>"><? echo $fils['cod_subsector']." ".$fils['nombre'];?></td>
										<? 	$i++;
											$fils = pg_fetch_array($result,$i);
										?>
										<td class="Estilo8"><input name="cod_subsector<?=$i;?>" type="checkbox" value="<?=$fils['cod_subsector'];?>"><?=$fils['cod_subsector']." ".$fils['nombre'];?></td>
									  </tr>
									 <? } ?>
									</table>
									 </div>
                                     </td>
                                   </tr>
                                   <tr>
                                     <td class="Estilo4"><div align="right">&nbsp;</div></td>
                                     <td>&nbsp;</td>
                                   </tr>
                                   <tr>
                                     <td colspan="3"><input name="buscar" type="button" onClick="javascript:enviapagReporte(this.form);" value="BUSCAR"> </td>
                                   </tr>
								   <? } ?>
                                 </table>-->
								 </form></td>
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
							</table>						 </td>
					     </tr>
					  </table> 
					  <!-- FIN CUERPO REPORTE DE CORPORACIONES -->					  </td>
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
