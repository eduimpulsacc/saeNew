<?
require('../../../../util/header.inc');
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno			=$c_alumno;
	$_POSP = 4;
	$_bot = 8;
	
	$sql_1 = "select nombre_instit, calle, nro, region, ciudad, comuna, letra_inst, numero_inst, telefono,  email, dependencia, area_geo, dig_rdb from institucion where rdb = '".$_INSTIT."'";
	$res_1 = pg_Exec($conn,$sql_1);
	$fil_1 = pg_fetch_array($res_1,0);
	$nombre_instit = $fil_1['nombre_instit'];
	$calle = $fil_1['calle'];
	$nro   = $fil_1['nro'];
	$region   = $fil_1['region'];
	$ciudad   = $fil_1['ciudad'];
	$comuna   = $fil_1['comuna'];
	$letra_inst   = $fil_1['letra_inst'];
	$numero_inst  = $fil_1['numero_inst'];
	$telefono     = $fil_1['telefono'];
	//$celular      = $fil_1['celular'];
	$email        = $fil_1['email']; 
	$dependencia  = $fil_1['dependencia'];
	$area_geo  = $fil_1['area_geo'];
	$dig_rdb   = $fil_1['dig_rdb'];  
	
	$sql_2 = "select nom_com from comuna where cor_com = '$comuna' and cor_pro = '$ciudad' and cod_reg = '$region'";
	$res_2 = @pg_Exec($conn, $sql_2);
	$fil_2 = @pg_fetch_array($res_2,0);
	$nom_comuna = $fil_2['nom_com'];
	
	$sql_3 = "select nom_pro from provincia where cor_pro = '$ciudad' and cod_reg = '$region'";
	$res_3 = @pg_Exec($conn, $sql_3);
	$fil_3 = @pg_fetch_array($res_3,0);
	$nom_provincia = $fil_3['nom_pro'];
	
	$sql_4 = "select nom_reg from region where cod_reg = '$region'";
	$res_4 = @pg_Exec($conn, $sql_4);
	$fil_4 = @pg_fetch_array($res_4,0);
	$nom_region = $fil_4['nom_reg'];
	
	$sql_44 = "select nro_ano from ano_escolar where id_ano = '$ano'";
	$res_44 = @pg_Exec($conn, $sql_44);
	$fil_44 = @pg_fetch_array($res_44,0);
	$nro_ano = $fil_44['nro_ano'];
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
function enviapag(){
	form.submit(true);
}
function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
									
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 
					  
<div id="capa0">
<table width="650">
<tr>
<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
</td>
<td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td>
</tr>
</table>
</div>
                        <table width="770" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><b>REPUBLICA DE CHILE</b></font><br>
                            <font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px">MINISTERIO DE EDUCACI&Oacute;N </font></td>
                            <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px">N&ordm; DE FOLIO: <b>1</b> </font></div></td>
                            <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px">FORMULARIO N&ordm; 3</font><br>
                              <font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px">EDUCACI&Oacute;N PARVULARIA<br>
                                ANO 2008 </font></div></td>
                          </tr>
                        </table>
                          <table width="770" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                              <td><table width="770" border="1">
                                <tr>
                                  <td width="50%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><b>IDENTIFICACION</b></font></td>
                                  <td width="50%" rowspan="4" valign="top"><div align="right">
                                    <table width="250" border="0" cellpadding="2" cellspacing="0">
                                      <tr>
                                        <td width="40%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Let-N&uacute;mero:</font></td>
                                        <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><? echo "$letra_inst - $numero_inst"; ?>&nbsp;</font></td>
                                      </tr>
                                      <tr>
                                        <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Tel&eacute;fono:</font></td>
                                        <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><? echo "$telefono"; ?>&nbsp;</font></td>
                                      </tr>
                                      <tr>
                                        <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Celular:</font></td>
                                        <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><? echo "$celular"; ?>&nbsp;</font></td>
                                      </tr>
                                      <tr>
                                        <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">E-mail:</font></td>
                                        <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><? echo "$email"; ?>&nbsp;</font></td>
                                      </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Nombre del establecimiento: <?=$nombre_instit?> </font></td>
                                </tr>
                                <tr>
                                  <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Direccion / localidad: <? echo "$calle $nro,  $nom_comuna"; ?></font></td>
                                </tr>
                                <tr>
                                  <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">&iquest;Existe Centro de Padres?: No &iquest;Tiene Personalidad Jur&iacute;dica? : No </font></td>
                                </tr>
                                <tr>
                                  <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Regi&oacute;n: <?=$nom_region ?> </font></td>
                                  <td rowspan="3"><div align="center">
                                    <table width="350" border="0" cellpadding="2" cellspacing="0">
                                      <tr>
                                        <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Depen-<br>
                                          dencia</font></td>
                                        <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Area<br>
                                          Geogra.</font></td>
                                        <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Tipo de<br>
                                          Ense&ntilde;anza</font></td>
                                        <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Rol Base de Datos </font></td>
                                        <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">D/V</font></td>
                                      </tr>
                                      <tr>
                                        <td><div align="center">
                                          <table width="98%" border="1" cellpadding="0" cellspacing="0">
                                            <tr>
                                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$dependencia?>&nbsp;</font></td>
                                            </tr>
                                          </table>
                                        </div></td>
                                        <td><div align="center">
                                          <table width="98%" border="1" cellpadding="0" cellspacing="0">
                                            <tr>
                                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$area_geo?>&nbsp;</font></td>
                                            </tr>
                                          </table>
                                        </div></td>
                                        <td><div align="center">
                                          <table width="98%" border="1" cellpadding="0" cellspacing="0">
                                            <tr>
                                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">10&nbsp;</font></td>
                                            </tr>
                                          </table>
                                        </div></td>
                                        <td><div align="center">
                                          <table width="98%" border="1" cellpadding="0" cellspacing="0">
                                            <tr>
                                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$_INSTIT?>&nbsp;</font></td>
                                            </tr>
                                          </table>
                                        </div></td>
                                        <td><div align="center">
                                          <table width="98%" border="1" cellpadding="0" cellspacing="0">
                                            <tr>
                                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$dig_rdb?>&nbsp;</font></td>
                                            </tr>
                                          </table>
                                        </div></td>
                                      </tr>
                                    </table>
                                  </div></td>
                                </tr>
                                <tr>
                                  <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Provincia: <?=$nom_provincia?> </font></td>
                                </tr>
                                <tr>
                                  <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Comuna: <?=$nom_comuna?> </font></td>
                                </tr>
                                </table></td>
                            </tr>
                        </table>
                          <table width="770" border="1" cellpadding="0">
                            <tr>
                              <td rowspan="4"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">SEXO</font></div></td>
                              <td rowspan="4"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">A&ntilde;o de <br>
                                Nacimiento</font></div></td>
                              <td colspan="5"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">MATRICULA INICIAL POR SEXO (Seg&uacute;n a&ntilde;o de nacimiento) </font></div></td>
                              <td><div align="center"></div></td>
                              <td><div align="center"></div></td>
                            </tr>
                            <tr>
                              <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">SALA CUNA </font></div></td>
                              <td colspan="2"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">NIVEL MEDIO </font></div></td>
                              <td colspan="2"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">TRANSICI&Oacute;N</font></div></td>
                              <td rowspan="3"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">TOTAL</font></div></td>
                              <td rowspan="3"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">ALUMNOS<br>
                                INTEGRADOS</font></div></td>
                            </tr>
                            <tr>
                              <td rowspan="2"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0 - 2 </font></div></td>
                              <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">MENOR</font></div></td>
                              <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">MAYOR</font></div></td>
                              <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">1er NIVEL </font></div></td>
                              <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2do NIVEL </font></div></td>
                            </tr>
                            <tr>
                              <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2 - 3 </font></div></td>
                              <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">3 - 4 </font></div></td>
                              <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">4 - 5 </font></div></td>
                              <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">5 - 6 </font></div></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Masculino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Despu&eacute;s 2006 </font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_5 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '2' and fecha_nac > '2006-12-31'";
							$res_5 = pg_Exec($conn,$sql_5);
							$fil_5  = pg_fetch_array($res_5);
							$num_5 = $fil_5[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_5?>&nbsp;</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_5?>&nbsp;</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Masculino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2006</font></td>
                             <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
						     <?
							$sql_6 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '2' and fecha_nac between '2006-01-01' and '2006-12-31'";
							$res_6 = pg_Exec($conn,$sql_6);
							$fil_6  = pg_fetch_array($res_6);
							$num_6 = $fil_6[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_6?></font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_6?></font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Masculino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2005</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_7 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '2' and fecha_nac between '2005-01-01' and '2005-12-31'";
							$res_7 = pg_Exec($conn,$sql_7);
							$fil_7  = pg_fetch_array($res_7);
							$num_7 = $fil_7[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_7?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_7?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Masculino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2004</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_8 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '2' and fecha_nac between '2004-01-01' and '2004-12-31'";
							$res_8 = pg_Exec($conn,$sql_8);
							$fil_8  = pg_fetch_array($res_8);
							$num_8 = $fil_8[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_8?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_8?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Masculino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2003</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_9 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '2' and fecha_nac between '2003-01-01' and '2003-12-31'";
							$res_9 = pg_Exec($conn,$sql_9);
							$fil_9  = pg_fetch_array($res_9);
							$num_9 = $fil_9[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_9?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_9?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Masculino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2002</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_10 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '2' and fecha_nac between '2002-01-01' and '2002-12-31'";
							$res_10 = pg_Exec($conn,$sql_10);
							$fil_10  = pg_fetch_array($res_10);
							$num_10 = $fil_10[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_10?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_10?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Masculino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2001</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_11 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '2' and fecha_nac between '2001-01-01' and '2001-12-31'";
							$res_11 = pg_Exec($conn,$sql_11);
							$fil_1  = pg_fetch_array($res_11);
							$num_11 = $fil_1[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_11?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_11?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Masculino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Antes del 2001 </font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_12 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '2' and fecha_nac between  '2000-01-01' and '1900-12-31'";
							$res_12 = pg_Exec($conn,$sql_12);
							$fil_12  = pg_fetch_array($res_12);
							$num_12 = $fil_12[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_12?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_12?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Masculino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Totales</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$tot_1 = $num_5 + $num_6 + $num_7 + $num_8 + $num_9 + $num_10 + $num_11 + $num_12;
							?>							
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$tot_1?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$tot_1?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Masculino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Als. Integrados </font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Masculino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Als. Origen Indigena </font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Femenino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Despu&eacute;s 2006 </font></td>
                             <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
						     <?
							$sql_13 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '1' and fecha_nac > '2006-12-31'";
							$res_13 = pg_Exec($conn,$sql_13);
							$fil_13  = pg_fetch_array($res_13);
							$num_13 = $fil_13[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_13?></font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_13?></font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Femenino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2006</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_14 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '1' and fecha_nac between '2006-01-01' and '2006-12-31'";
							$res_14 = pg_Exec($conn,$sql_14);
							$fil_14  = pg_fetch_array($res_14);
							$num_14 = $fil_14[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_14?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_14?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Femenino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2005</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_15 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '1' and fecha_nac between '2005-01-01' and '2005-12-31'";
							$res_15 = pg_Exec($conn,$sql_15);
							$fil_15  = pg_fetch_array($res_15);
							$num_15 = $fil_15[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_15?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_15?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Femenino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2004</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_16 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '1' and fecha_nac between '2004-01-01' and '2004-12-31'";
							$res_16 = pg_Exec($conn,$sql_16);
							$fil_16  = pg_fetch_array($res_16);
							$num_16 = $fil_16[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_16?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_16?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Femenino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2003</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_17 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '1' and fecha_nac between '2003-01-01' and '2003-12-31'";
							$res_17 = pg_Exec($conn,$sql_17);
							$fil_17  = pg_fetch_array($res_17);
							$num_17 = $fil_17[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_17?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_17?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Femenino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2002</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_18 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '1' and fecha_nac between '2002-01-01' and '2002-12-31'";
							$res_18 = pg_Exec($conn,$sql_18);
							$fil_18  = pg_fetch_array($res_18);
							$num_18 = $fil_18[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_18?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_18?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Femenino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2001</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_19 = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '1' and fecha_nac between '2001-01-01' and '2001-12-31'";
							$res_19 = pg_Exec($conn,$sql_19);
							$fil_19  = pg_fetch_array($res_19);
							$num_19 = $fil_19[0];
							?>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_19?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_19?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Femenino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Antes del 2001 </font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?
							$sql_20  = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano')) and sexo = '1' and fecha_nac between '1900-01-01' and '2000-12-31'";
							$res_20  = pg_Exec($conn,$sql_20);
							$fil_20  = pg_fetch_array($res_20);
							$num_20  = $fil_20[0];
							?>							
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_20?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_20?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Femenino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Totales</font></td>
                             <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
						     <?
							$tot_2 = $num_13 + $num_14 + $num_15 + $num_16 + $num_17 + $num_18 + $num_19 + $num_20;
							?>							   
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$tot_2?></font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$tot_2?></font></td>
						     <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Femenino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Als. Integrados </font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?							
							$sql_21  = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano' and bool_i='1')) and sexo = '1'";
							$res_21  = pg_Exec($conn,$sql_21);
							$fil_21  = pg_fetch_array($res_21);
							$num_21  = $fil_21[0];
							?>							
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_21?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_21?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Femenino</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Als. Origen Indigena </font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?							
							$sql_22  = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and  id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano' and bool_aoi='1')) and sexo = '1'";
							$res_22  = pg_Exec($conn,$sql_22);
							$fil_22  = pg_fetch_array($res_22);
							$num_22  = $fil_22[0];
							?>							
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_22?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_22?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">CURSOS SIMPLES</font> </td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <?							
							$sql_23  = "select count(*) from alumno$nro_ano where rut_alumno in (select rut_alumno from matricula$nro_ano where fecha < '$nro_ano-05-01' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza = '10' and (grado_curso='5' or grado_curso='6') and id_ano = '$ano'))";
							$res_23  = pg_Exec($conn,$sql_23);
							$fil_23  = pg_fetch_array($res_23);
							$num_23  = $fil_23[0];
							?>	
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_23?></font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><?=$num_23?></font></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td rowspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">CURSOS COMBINADOS<br>
                                (AGRUPACIONES HETEROGENEAS) </font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">1er CURSO </font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">2do CURSO </font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">3er CURSO </font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">4to CURSO </font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                              <td>&nbsp;</td>
                            </tr>
</table>
                          <table width="770" border="1">
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">RESUMEN DE MATRICULA, NUMERO DE CURSOS POR JORNADA Y HORARIO DE FUNCIONAMIENTO </font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">CURSOS COMBINADOS </font></td>
                            </tr>
                        </table>
                          <table width="770" border="1" cellpadding="0">
                            <tr>
                              <td rowspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">JORNADAS</font></td>
                              <td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Horario</font></td>
                              <td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Total</font></td>
                              <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">JORNADA</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Desde</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Hasta</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">N&ordm; Cursos </font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Matric.</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Curso<br>1</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Curso<br>2</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Curso<br>3</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Curso<br>3</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">TOTAL</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Ma&ntilde;ana</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Tarde</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Ma&ntilde;ana y Tarde </font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
</table>
                          <table width="770" border="1">
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">CURSOS SIMPLES</font> </td>
                            </tr>
                        </table>
                          <table width="770" border="1" cellpadding="0">
                            <tr>
                              <td rowspan="3"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">JORNADA CURSOS SIMPLES</font> </td>
                              <td colspan="2" rowspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Horario</font></td>
                              <td colspan="2" rowspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Total</font></td>
                              <td colspan="2" rowspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Nivel Sala Cuna </font></td>
                              <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Nivel Medio </font></td>
                              <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Nivel de Transici&oacute;n </font></td>
                            </tr>
                            <tr>
                              <td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Menor</font></td>
                              <td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Mayor</font></td>
                              <td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Menor</font></td>
                              <td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Mayor</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Desde</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Hasta</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">N&ordm; Cursos</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Matric.</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">N&ordm; Cursos </font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Matric.</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">N&ordm; Cursos </font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Matric.</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">N&ordm; Cursos </font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Matric.</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">N&ordm; Cursos </font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Matric.</font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">N&ordm; Cursos </font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Matric.</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">TOTAL</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">1</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">45</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Ma&ntilde;ana</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">1</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">45</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Tarde</font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Ma&ntilde;ana y Tarde </font></td>
                              <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
							  <td align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">0</font></td>
                            </tr>
</table>
						<?
						$sql = "SELECT nombre_emp || cast(' ' as varchar)|| ape_pat || cast(' ' as varchar)|| ape_mat as nombre FROM empleado WHERE rut_emp in(SELECT rut_emp FROM trabaja WHERE RDB=".trim($institucion)." AND CARGO=1)";
	$result = @pg_exec($conn,$sql);
	$Director = @pg_result($result,0);
	
	$sql = "SELECT nombre_emp || cast(' ' as varchar)|| ape_pat || cast(' ' as varchar)|| ape_mat as nombre FROM empleado WHERE rut_emp in(SELECT rut_emp FROM trabaja WHERE RDB=".trim($institucion)." AND CARGO=2)";
	$result = @pg_exec($conn,$sql);
	$UTP = @pg_result($result,0);
	                    ?>
                          <table width="770" border="1" cellspacing="0">
                            <tr>
                              <td height="20"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:11px">Nombre Responsable llenado Formulario: 
							  <u><? echo ucwords(strtolower($UTP));?></u> </font></td>
                            </tr>
                            <tr>
                              <td height="20"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Nombre del Director del Establecimiento: 
							  <u><? echo ucwords(strtolower($Director));?></u></font></td>
                            </tr>
                            <tr>
                              <td><div align="right"> <br>
                                <br>
                                <table width="300" border="1">
                                  <tr>
                                    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">__________________________________________<br>
                                      Firma del Director y Timbre del Establecimiento </font></div></td>
                                  </tr>
                                </table>
                              </div></td>
                            </tr>
</table>
</body>
</html>
<? pg_close($conn);?>