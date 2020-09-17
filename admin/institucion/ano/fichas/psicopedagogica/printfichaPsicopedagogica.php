<?php require('../../../../../util/header.inc');?>
<?php
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	if($tipo_hoja!=1){
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	}else{
	/****************VARIABLES PARA HOJA DE VIDA****************/
	$ano			=$_GET['c_ano'];
	$alumno			=$_GET['c_alumno'];
	 $c_curso			=$_GET['c_curso'];
	/**********************************/
	}
	$idFicha		=$_FICHAM;
	$_POSP          = 5;
	$curso = $_CURSO;
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
//-->
</script>
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<script> 
	function cerrar(){ 
		window.close() 
	} 
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >

								  
								  
								  <!-- inicio codigo nuevo -->
								  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>                                      
                                      <td width="60%">
									  <?
									  $sql_institucion = "select * from institucion where rdb = '$_INSTIT'";
									  $res_institucion = @pg_Exec($conn,$sql_institucion);
									  $fila = @pg_fetch_array($res_institucion,0);
									  $nombre_institucion = $fila['nombre_instit'];
									  
									  ?>
									  <table width="400" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                          <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:16px"><b><?=$nombre_institucion?></b></font></td>
                                        </tr>
                                      </table></td>
                                      <td width="20%">
									  <?
									  $dd = date("d");
									  $mm = date("m");
									  $aa = date("Y");
									  ?>
									  <table width="200" border="0" align="right" cellpadding="2" cellspacing="0">
                                        <tr>
                                          <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>Fecha</b></font></td>
                                          <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b><?=$dd?></b></font></td>
                                          <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>/</b></font></td>
                                          <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b><?=$mm?></b></font></td>
                                          <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>/</b></font></td>
                                          <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b><?=$aa?></b></font></td>
										  
                                        </tr>
                                      </table></td>
                                    </tr>
</table>
								  
                                  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:16px"><b>FICHA PSICOPEDAGOGICA</b></font> </td>
                                    </tr>
                                    <tr>
                                      <td>&nbsp;</td>
                                    </tr>
</table>
								  <?
								  $sql_alum = "select * from alumno where rut_alumno = '$_ALUMNO'";
								  $res_alum = @pg_Exec($conn, $sql_alum);
								  $fil_alum = @pg_fetch_array($res_alum,0);
								  
								  $nombre_alumno    = $fil_alum['nombre_alu'];
								  $ape_pat          = $fil_alum['ape_pat'];
								  $ape_mat          = $fil_alum['ape_mat'];
								  $nombre_alumno    = "$nombre_alumno $ape_pat $ape_mat";
								  $fecha_nacimiento = $fil_alum['fecha_nac'];
								  
								  $psico_proceso = $fil_alum['psico_proceso'];
								  $psico_inicio  = $fil_alum['psico_inicio'];
								  $psico_fin     = $fil_alum['psico_fin'];
								  $psico_horario = $fil_alum['psico_horario'];
								  
								  $dd = substr($fecha_nacimiento,8,2);
								  $mm = substr($fecha_nacimiento,5,2);
								  $aa = substr($fecha_nacimiento,0,4);
								  
								  if ($psico_inicio!=NULL){
								     $dd2 = substr($psico_inicio,8,2);
								     $mm2 = substr($psico_inicio,5,2);
								     $aa2 = substr($psico_inicio,0,4);
								  
								     $psico_inicio = "$dd2-$mm2-$aa2";
								  }	 
								  
								  if ($psico_fin!=NULL){
									  $dd3 = substr($psico_fin,8,2);
									  $mm3 = substr($psico_fin,5,2);
									  $aa3 = substr($psico_fin,0,4);
									  
									  $psico_fin = "$dd3-$mm3-$aa3";
								  }
								  
								  
								  
								  ?>	
								 <div id="capa0">						  
                                   <table width="700" border="1" align="center">
                                     <tr>
                                       <td align="right"><label>
                                       <input name="cerrar" type="submit" id="cerrar" value="Cerrar" class="Botonxx" onClick="cerrar();">
                                       <input name="imprimir" type="button" class="Botonxx" id="imprimir" value="Imprimir" onClick="imprimir();">
                                       </label></td>
                                     </tr>
                                   </table>
								 </div>  
                                   <table width="700" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#cccccc" style="border-width: 1px;">
                                    <tr>
                                      <td bgcolor="cccccc"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>NOMBRE DEL ALUMNO </b></font></td>
                                      <td colspan="3" bgcolor="cccccc"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>FECHA DE NACIMIENTO</b></font> 									</td>
                                    </tr>
                                    <tr>
                                      <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><label><?=$nombre_alumno?></label></font></td>
                                      <td width="4%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?=$dd?></font></td>
                                      <td width="4%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?=$mm?></font></td>
                                      <td width="4%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?=$aa?></font></td>
                                    </tr>
</table>
                                  <br>
                                  <br>
                                 
								  <table width="700" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#cccccc" style="border-width: 1px;">
                                    <tr>
                                      <td width="70%" bgcolor="cccccc"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>CURSO </b></font></td>
                                      <td width="30%" bgcolor="cccccc"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>PROCESO </b></font></td>
                                    </tr>
                                    <tr>
                                      <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?
									  $Curso_pal = CursoPalabra($curso, 0, $conn);
									  echo $Curso_pal;
									  ?>
									  </font></td>
                                      <td>
									  <table width="100%" border="0" cellpadding="2" cellspacing="2">
                                        <?
										if ($psico_proceso==1){ ?>
										<tr>                                          
                                          <td width="95%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>En evaluaci&oacute;n </b></font></td>
                                        </tr>
									  <? } ?>
									  <?
									    if ($psico_proceso==2){ ?>	
                                        <tr>                                          
                                          <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>Finalizaci&oacute;n</b></font></td>
                                        </tr>
									  <? } ?>	
                                      </table>
									  </td>
                                    </tr>
</table>
                                  <br>
                                  <br>
                                  <table width="700" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#cccccc" style="border-width: 1px;">
                                    <tr>
                                      <td width="33%" bgcolor="cccccc"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>FECHA INICIO PARTICIPACION </b></font></td>
                                      <td width="33%" bgcolor="cccccc"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>FECHA FIN PARTICIPACION </b></font></td>
                                      <td width="33%" bgcolor="cccccc"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>HORARIO DE CLASES </b></font></td>
                                    </tr>
                                    <tr>
                                      <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><label>
                                        <?=$psico_inicio?></label></font></td>
                                      <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><label>
                                        <?=$psico_fin?></label></font></td>
                                      <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><label>
                                        <?=$psico_horario?>
                                      </label></font></td>
                                    </tr>
</table>
                                  <br>
                                  <br>
                                  <table width="700" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#cccccc" style="border-width: 1px;">
                                    <tr>
                                      <td width="33%" bgcolor="cccccc"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>ESTADO DE AVANCE</b></font></td>
                                    </tr>
                                    <tr>
                                      <td><table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#cccccc" style="border-width: 1px;">
                                        <tr>
                                          <td width="15%" bgcolor="f5f5f5"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>FECHA</b></font></td>
                                          <td width="85%" bgcolor="f5f5f5"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>COMENTARIOS</b></font></td>
                                        </tr>
                                       
										<?
										// avances
										$sql_avance = "select * from psico_avance where rut_alumno = '$_ALUMNO' order by id_avance desc";
										$res_avance = @pg_Exec($conn, $sql_avance);
										$num_avance = @pg_numrows($res_avance);
										for ($i=0; $i < $num_avance; $i++){
										    $fil_avance = pg_fetch_array($res_avance,$i);
											$fecha      =  $fil_avance['fecha'];
											$comentario =  $fil_avance['comentario'];
											$dd = substr($fecha,8,2);
											$mm = substr($fecha,5,2);
											$aa = substr($fecha,0,4);
											$fecha = "$dd-$mm-$aa";
											?>
											<tr>
											  <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?=$fecha?></font></td>
											  <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?=$comentario?></font></td>
											</tr>
											<?
										}
										?>                                       
                                      </table>
									  </td>
                                    </tr>
</table>
                                  <br>
                                  <br>
                                  <table width="700" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#cccccc" style="border-width: 1px;">
                                    <tr>
                                      <td width="33%" bgcolor="cccccc"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>MATERIAL COMPLEMENTARIO</b></font></td>
                                    </tr>
                                    <tr>
                                      <td><table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#cccccc" style="border-width: 1px;">
                                          <tr>
                                            <td width="20%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>FECHA</b></font></td>
                                            <td width="75%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>COMENTARIOS</b></font></td>
                                           
                                          </tr>
                                         
										<?
										// complementario
										$sql_comple = "select * from psico_comple where rut_alumno = '$_ALUMNO' order by id_comple desc";
										$res_comple = @pg_Exec($conn, $sql_comple);
										$num_comple = @pg_numrows($res_comple);
										for ($i=0; $i < $num_comple; $i++){
										    $fil_comple = pg_fetch_array($res_comple,$i);
											$fecha      =  $fil_comple['fecha'];
											$comentario =  $fil_comple['comentario'];
											$dd = substr($fecha,8,2);
											$mm = substr($fecha,5,2);
											$aa = substr($fecha,0,4);
											$fecha = "$dd-$mm-$aa";
											?>
										  
                                          <tr>
                                            <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?=$fecha?></font></td>
                                            <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?=$comentario?></font></td>
                                            
                                          </tr>
                                       <? } ?>   
                                      </table></td>
                                    </tr>
</table>
                                  <br>
                                  <br>
                                  <table width="700" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#cccccc" style="border-width: 1px;">
                                    <tr>
                                      <td width="33%" bgcolor="cccccc"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>ASISTENCIA</b></font></td>
                                    </tr>
                                    <tr>
                                      <td><table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#cccccc" style="border-width: 1px;">
                                          <tr>
                                            <td width="15%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>FECHA</b></font></td>
                                            <td width="10%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>ASISTE</b></font></td>
                                            <td width="75%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>COMENTARIOS</b></font></td>
                                          </tr>
                                         
										 <?
										// Asistencia
										$sql_asis = "select * from psico_asistencia where rut_alumno = '$_ALUMNO' order by id_asistencia desc";
										$res_asis = pg_Exec($conn, $sql_asis);
										$num_asis = pg_numrows($res_asis);
										for ($i=0; $i < $num_asis; $i++){
										    $fil_asis = pg_fetch_array($res_asis,$i);
											$fecha      =  $fil_asis['fecha'];
											$comentario =  $fil_asis['comentario'];
											$asiste     =  $fil_asis['asiste'];
											$dd = substr($fecha,8,2);
											$mm = substr($fecha,5,2);
											$aa = substr($fecha,0,4);
											$fecha = "$dd-$mm-$aa";
											
											if ($asiste==1){
											   $asiste="SI";
											}else{
											   $asiste="NO";
											}
											?> 										  
										    <tr>
											  <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?=$fecha?></font></td>
											  <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?=$asiste?></font></td>
											  <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?=$comentario?></font></td>
										    </tr>
                                            <?
										}
										?>	
                                      </table></td>
                                    </tr>
</table>
                                  <br>
                                  <br>
                                  <table width="700" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#cccccc" style="border-width: 1px;">
                                    <tr>
                                      <td width="33%" bgcolor="cccccc"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>CITACI&Oacute;N DE APODERADOS</b></font> </td>
                                    </tr>
                                    <tr>
                                      <td><table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#cccccc" style="border-width: 1px;">
                                          <tr>
                                            <td width="15%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>FECHA</b></font></td>
                                            <td width="10%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>ASISTE</b></font></td>
                                            <td width="75%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><b>COMENTARIOS</b></font></td>
                                          </tr>
                                         
										<?   
										// Asistencia
										$sql_cita = "select * from psico_citacion where rut_alumno = '$_ALUMNO' order by id_citacion desc";
										$res_cita = pg_Exec($conn, $sql_cita);
										$num_cita = pg_numrows($res_cita);
										for ($i=0; $i < $num_cita; $i++){
										    $fil_cita = pg_fetch_array($res_cita,$i);
											$fecha      =  $fil_cita['fecha'];
											$comentario =  $fil_cita['comentario'];
											$asiste     =  $fil_cita['asiste'];
											$dd = substr($fecha,8,2);
											$mm = substr($fecha,5,2);
											$aa = substr($fecha,0,4);
											$fecha = "$dd-$mm-$aa";
											
											if ($asiste==1){
											   $asiste="SI";
											}else{
											   $asiste="NO";
											}
											?>
											  <tr>
												<td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?=$fecha?></font></td>
												<td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?=$asiste?></font></td>
												<td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><?=$comentario?></font></td>
											  </tr>
                                       <? } ?>
									 	  
                                      </table></td>
                                    </tr>
</table>
								
</body>
</html>
