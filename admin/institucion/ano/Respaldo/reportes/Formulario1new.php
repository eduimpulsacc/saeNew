<?php
require('../../../../util/header.inc');

$institucion	=$_INSTIT;
$ano			=$_ANO;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"><?
				include("../../../../cabecera/menu_superior.php");
				?>                </td>
              </tr>
          </table></td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>              </td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="395" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                        <tr>
                          <td><br>
                              <!-- INCLUYO CODIGO DE LOS BOTONES -->
                              <?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
                              <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td width="" height="" align="center" valign="top"><?
						//include("../../../../cabecera/menu_inferior.php");
						?>                                  </td>
                                </tr>
                              </table>
                            <? } ?>
                              <!-- FIN CODIGO DE BOTONES -->
                              <!-- INICIO CUERPO DE LA PAGINA -->

                            
			
<table width="650" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div id="capa0">
<div align="right">
<input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printFormulario1.php','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
</div>
</div></td>
</tr>
</table>
<p>
               
					            <table width="650" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="196"><div align="center"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong>REPUBLICA DE CHILE </strong></font></div></td>
                                    <td width="81">&nbsp;</td>
                                    <td width="187"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">N&ordm; de Folio <strong>2 </strong></font></div></td>
                                    <td width="186"><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="1">FORMULARIO N&ordm;1</font> </strong></div></td>
                                  </tr>
                                  <tr>
                                    <td><div align="center"><font size="1" face="Verdana, Verdana, Arial, Helvetica, sans-serif">MINISTERIO DE EDUCACI&Oacute;N </font></div></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><div align="center"></div></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">A&Ntilde;O
                                      
                                    </font></div></td>
                                  </tr>
                                </table>
                                <table width="650" border="1" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td><table width="650" border="0" class="cajaborde" cellpadding="0" cellspacing="0">
                                        <tr>
                                          <td colspan="2"><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="2">IDENTIFICACI&Oacute;N</font></strong></td>
                                          <td width="75" class="Estilo2">Let. N&uacute;mero </td>
                                          <td width="160" class="Estilo2">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td width="166" class="Estilo2">Nombre del Establecimiento</td>
                                          <td width="231" class="Estilo2">&nbsp;</td>
                                          <td class="Estilo2">Tel&eacute;fono</td>
                                          <td class="Estilo2">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td class="Estilo2">Direci&oacute;n/Localidad</td>
                                          <td class="Estilo2">&nbsp;</td>
                                          <td class="Estilo2">Celular</td>
                                          <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" class="Estilo2">&iquest;Existe Centro de Padre?  &iquest;Tiene Personalidad Juridica ?  </td>
                                          <td class="Estilo2">E-mail</td>
                                          <td class="Estilo2">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td class="Estilo2">Regi&oacute;n</td>
                                          <td class="Estilo2">&nbsp;</td>
                                          <td colspan="2" rowspan="2"><table width="100%" border="1" bordercolor="#666666" cellpadding="0" cellspacing="0" class="cajaborde">
                                              <tr>
                                                <td class="Estilo2">Depend.</td>
                                                <td class="Estilo2">Área Geograf.</td>
                                                <td class="Estilo2">Tipo de Enseñanza</td>
                                                <td class="Estilo2">RBD</td>
                                                <td class="Estilo2">D/V</td>
                                              </tr>
                                              <tr>
                                                <td class="Estilo2"><div align="center"></div></td>
                                                <td class="Estilo2"><div align="center"></div></td>
                                                <td class="Estilo2"><div align="center">110</div></td>
                                                <td class="Estilo2"><div align="center"></div></td>
                                                <td class="Estilo2"><div align="center"></div></td>
                                              </tr>
                                          </table></td>
                                        </tr>
                                        <tr>
                                          <td class="Estilo2">Provincia</td>
                                          <td class="Estilo2">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td class="Estilo2">Comuna</td>
                                          <td class="Estilo2">&nbsp;</td>
                                          <td colspan="2">&nbsp;</td>
                                        </tr>
                                    </table></td>
                                  </tr>
                                </table>
                                <br>
                                <table width="650" border="1" class="Estilo2">
                                  <tr>
                                    <td rowspan="2" class="Estilo2">SEXO</td>
                                    <td rowspan="2" class="Estilo2">A&Ntilde;O DE NACIMIENTO. </td>
                                    <td colspan="11"><div align="center">MATRICULA INCIAL POR SEXO <span class="Estilo4">(SEG&Uacute;N A&Ntilde;O DE NACIMIENTO) </span></div></td>
                                  </tr>
                                  <tr>
                                    <td class="Estilo2"><div align="center">1</div></td>
                                    <td class="Estilo2"><div align="center">2</div></td>
                                    <td class="Estilo2"><div align="center">3</div></td>
                                    <td class="Estilo2"><div align="center">4</div></td>
                                    <td class="Estilo2"><div align="center">5</div></td>
                                    <td class="Estilo2"><div align="center">6</div></td>
                                    <td class="Estilo2"><div align="center">7</div></td>
                                    <td class="Estilo2"><div align="center">8</div></td>
                                    <td class="Estilo2"><div align="center">TOTAL</div></td>
                                    <td class="Estilo2"><div align="center">G.D.</div></td>
                                    <td class="Estilo2"><div align="center">Al.Integ.</div></td>
                                  </tr>
								
                                </table>
								<BR>
                                <table width="650" border="0" cellpadding="0" cellspacing="0" class="Estilo2">
                                  <tr>
                                    <td>CURSOS COMBINADOS </td>
                                  </tr>
                                  <tr>
                                    <td valign="top"><table width="650" border="1" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td rowspan="7" class="Estilo2">CURSOS <br>
                                          COMBINADOS</td>
                                        <td rowspan="2" class="Estilo2">CURSOS</td>
                                        <td colspan="8" class="Estilo2"><div align="center">MATRICULA</div></td>
                                        <td rowspan="2" class="Estilo2">TOTAL</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">1</td>
                                        <td class="Estilo2">2</td>
                                        <td class="Estilo2">3</td>
                                        <td class="Estilo2">4</td>
                                        <td class="Estilo2">5</td>
                                        <td class="Estilo2">6</td>
                                        <td class="Estilo2">7</td>
                                        <td class="Estilo2">8</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">1ER CURSO </td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">2DO CURO </td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">3ER CURSO </td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">4TO CURSO </td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">5TO CURSO </td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                        <td class="Estilo2">0</td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                </table>
								<BR>
                                <table width="650" border="0">
                                  <tr>
                                    <td class="Estilo2">RESUMEN DE MATRICULA, N&Uacute;MERO DE CURSOS POR JORNADA Y HORARIO DE FUNCIONAMIENTO </td>
                                  </tr>
                                  <tr>
                                    <td class="Estilo2">CURSOS COMBINADOS </td>
                                  </tr>
                                  <tr>
                                    <td><table width="100%" border="1">
                                      <tr>
                                        <td rowspan="2" class="Estilo2">JORN.CURSOS<br>
                                          CAMBINADOS</td>
                                        <td colspan="2" class="Estilo2"><div align="center">Horario</div></td>
                                        <td colspan="2" class="Estilo2"><div align="center">Total</div></td>
                                        <td rowspan="2" class="Estilo2"><div align="center">CURSO<br>
                                          1</div></td>
                                        <td rowspan="2" class="Estilo2"><div align="center">CURSO<br>
                                          2</div></td>
                                        <td rowspan="2" class="Estilo2"><div align="center">CURSO<br>
                                          3</div></td>
                                        <td rowspan="2" class="Estilo2"><div align="center">CURSO<br>
                                          4</div></td>
                                        <td rowspan="2" class="Estilo2"><div align="center">CURSO<br>
                                          5</div></td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2"><div align="center">Desde</div></td>
                                        <td class="Estilo2"><div align="center">Hasta</div></td>
                                        <td class="Estilo2"><div align="center">N&ordm; Cursos </div></td>
                                        <td class="Estilo2"><div align="center">Matric.</div></td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2"><strong>TOTAL</strong></td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
										<td class="Estilo2"><div align="right">0</div></td>
										<td class="Estilo2"><div align="right">0</div></td>
										<td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">Ma&ntilde;ana</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">Tarde</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo2">Ma&ntilde;ana y Tarde </td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                </table>
                                <br>
                                <table width="650" border="0">
                                  <tr>
                                    <td class="Estilo2">CURSOS SIMPLES </td>
                                  </tr>
                                  <tr>
                                    <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td rowspan="2" class="Estilo1">JORNADA<br>
                                          C.SIMPLES</td>
                                        <td colspan="2" class="Estilo1">Horario</td>
                                        <td colspan="2" class="Estilo1">Total</td>
                                        <td colspan="2" class="Estilo1"><div align="center">1&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">2&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">3&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">4&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">5&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">6&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">7&ordm;</div></td>
                                        <td colspan="2" class="Estilo1"><div align="center">8&ordm;</div></td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo1">Desde</td>
                                        <td class="Estilo1">Hasta</td>
                                        <td class="Estilo1">N&ordm; Cursos </td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos </td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos </td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos </td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos</td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos</td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos</td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos</td>
                                        <td class="Estilo1">Matric</td>
                                        <td class="Estilo1">N&ordm; Cursos</td>
                                        <td class="Estilo1">Matric</td>
                                      </tr>
                                      <tr>
                                        <td class="Estilo6">TOTAL</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
										<? 	$sql = "SELECT COUNT(*) FROM curso WHERE id_ano='$ano' AND ensenanza=110";
											$result =@pg_exec($conn,$sql);
											$Total_Curso = @pg_result($result,0);
										?>
                                        <td class="Estilo2"><div align="right"></div></td>
										<?	$sql =" SELECT COUNT(*) FROM matricula WHERE id_ano='$ano' AND id_curso in ";
											$sql.=" (SELECT id_curso FROM curso WHERE ensenanza=110 AND id_ano='$ano')";
											$result = @pg_exec($conn,$sql);
											$Total_Mat = @pg_result($result,0);										
										?>
                                        <td class="Estilo2">&nbsp;</td>
                                        <? for($i=1;$i<=8;$i++){
											$sql =" SELECT count(*) FROM matricula WHERE ID_ANO='$ano' AND id_curso IN ";
											$sql.="(SELECT id_curso FROM curso WHERE grado_curso='$i' AND id_ano='$ano' AND ";
											$sql.=" ensenanza=110)";
											$result = @pg_exec($conn,$sql);
											$totalmat = @pg_result($result,0);
											
											$sql =" SELECT count(*) FROM curso WHERE id_ano='$ano' AND grado_curso='$i' AND ";
											$sql.=" ensenanza=110";
											$result = @pg_exec($conn,$sql);
											$Total = @pg_result($result,0);
										?>
										<td class="Estilo2"><div align="right"></div></td>
										<td class="Estilo2"><div align="right"></div></td>
										<? } ?>
                                      </tr>
                                      <tr>
                                        <td class="Estilo1">Ma&ntilde;ana</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
										<? 	for($i=1;$i<=8;$i++){
											$sql =" SELECT count(*) FROM curso WHERE id_ano='$ano' AND curso.bool_jor=1 AND ";
											$sql.=" ensenanza=110 AND grado_curso='$i' ";
											$result =@pg_exec($conn,$sql);
											$Curso_M = @pg_result($result,0);
											
											$sql =" SELECT count(*) FROM matricula WHERE id_ano='$ano' AND id_curso in (SELECT ";
											$sql.=" id_curso FROM curso WHERE id_ano='$ano' AND ensenanza=110 AND ";
											$sql.=" grado_curso='$i' AND bool_jor=1)";
											$result = @pg_exec($conn,$sql);
											$Total_M = @pg_result($result,0);
											
										
										?>
                                        <td class="Estilo2"><div align="right"></div></td>
                                        <td class="Estilo2"><div align="right"></div></td>
										<? } ?>
                                      </tr>
                                      <tr>
                                        <td class="Estilo1">Tarde</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
										<? 	for($i=1;$i<=8;$i++){
											$sql =" SELECT count(*) FROM curso WHERE id_ano='$ano' AND curso.bool_jor=2 AND ";
											$sql.=" ensenanza=110 AND grado_curso='$i' ";
											$result =@pg_exec($conn,$sql);
											$Curso_T = @pg_result($result,0);
											
											$sql =" SELECT count(*) FROM matricula WHERE id_ano='$ano' AND id_curso in (SELECT ";
											$sql.=" id_curso FROM curso WHERE id_ano='$ano' AND ensenanza=110 AND ";
											$sql.=" grado_curso='$i' AND bool_jor=2)";
											$result = @pg_exec($conn,$sql);
											$Total_T = @pg_result($result,0);
											
										
										?>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2"><div align="right"></div></td>
										<? } ?>
                                      </tr>
                                      <tr>
                                        <td class="Estilo1">Ma&ntilde;ana y Tarde </td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2">&nbsp;</td>
                                        <td class="Estilo2"><div align="right">0</div></td>
                                        <td class="Estilo2"><div align="right">0</div></td>
											<? 	for($i=1;$i<=8;$i++){
											$sql =" SELECT count(*) FROM curso WHERE id_ano='$ano' AND curso.bool_jor=3 AND ";
											$sql.=" ensenanza=110 AND grado_curso='$i' ";
											$result =@pg_exec($conn,$sql);
											$Curso_MT = @pg_result($result,0);
											
											$sql =" SELECT count(*) FROM matricula WHERE id_ano='$ano' AND id_curso in (SELECT ";
											$sql.=" id_curso FROM curso WHERE id_ano='$ano' AND ensenanza=110 AND ";
											$sql.=" grado_curso='$i' AND bool_jor=3)";
											$result = @pg_exec($conn,$sql);
											$Total_MT = @pg_result($result,0);
											
										
										?>
                                        <td class="Estilo2"><div align="right"></div></td>
                                        <td class="Estilo2"><div align="right"></div></td>
										<? } ?>
                                      </tr>
                                    </table></td>
                                  </tr>
                                </table>
                                <br>
                                <table width="650" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="234" class="Estilo2">Nombre Responsable llenado Formulario </td>
                                    <td width="175" class="Estilo2">&nbsp;</td>

                                    <td width="241" class="Estilo2">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class="Estilo2">Nombre del Director del Establecimiento </td>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2">_______________________________________</td>
                                  </tr>
                                  <tr>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2">&nbsp;</td>
                                    <td class="Estilo2"><div align="center">Nombre del Director y Timbre del Establecimiento </div></td>
                                  </tr>
                                </table>
                                <br>
                                <br>
                          </td>
            </tr>
            <tr align="center" valign="middle">
              <td height="45" colspan="2" class="piepagina">SAE Sistema 
                de Administraci&oacute;n Escolar - 2005</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
   </tr>
      </table>
 </td>
  </tr>
</table>

</body>
</html>
<? pg_close($conn);?>