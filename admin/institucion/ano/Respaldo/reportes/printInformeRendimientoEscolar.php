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
<?
require('../../../../util/header.inc'); 
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

	//setlocale("LC_ALL","es_ES");
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$_POSP = 4;
	$_bot = 8;
	
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	//echo $sql_ano;	
	$result_ano =pg_Exec($conn,$sql_ano);
	$fila_ano = pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	
	
	//-------------- AUI TOMAMOS LOS DATOS DE LA INSTITUCIÍN------------------------------------------------------------
	$sql_ins = "SELECT institucion.dig_rdb, institucion.letra_inst, institucion.area_geo, institucion.email, institucion.nombre_instit, institucion.calle, institucion.nro, date_part('year',institucion.fecha_resolucion)as fecha_res, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.nu_resolucion ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$rdb = $institucion."-".$fila_ins['dig_rdb'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];
	$resolucion = $fila_ins['nu_resolucion'];
	$fecha_res = $fila_ins['fecha_res'];
	$comuna = $fila_ins['nom_com'];
	$ciudad = $fila_ins['nom_pro'];
	$region= $fila_ins['nom_reg'];
	$email= $fila_ins['email'];
	$letra_inst= $fila_ins['letra_inst'];
	$area_geo= $fila_ins['area_geo'];
	$dig_rdb= $fila_ins['dig_rdb'];
	//-------
	
	function validar_dav ($alumno,$dig_rut){
	      
		 $alumno = $alumno;
		 $dig_rut = $dig_rut;	 		  
		  
		 $largo_rut = strlen($alumno);
		 $multiplicador = 2;
		 $resultado = 0;
		 $largo=$largo_rut-1;
			 
		 for ($i=0; $i < $largo_rut; $i++){
			 $num = substr($alumno,$largo,1);
			 
			 if ($multiplicador > 7){
				 $multiplicador = 2;
			 }
			 $resultado = $resultado + ($multiplicador * $num);			 
			 $multiplicador++; 
			 $largo--;
				 
		 }
				 
		 $resto = 11-($resultado%11);		 
		 
		 if ($resto==10){
			 $dig = "K";
		 }else{
		     if ($resto==11){
			     $dig = 0;
			 }else{	 
		         $dig = $resto;
			 }	 
		 }	 
		 
		 if ($dig_rut=="k"){
		     $dig_rut="K";   
		 } 
		 
		 if ($dig==$dig_rut){
			  $ok=1;   
		 }else{
			  $ok=0;
		 }	
		 return $ok;
		       	 
	}

if ($tipo_ensenanza==1){
   $t_ense = "";
}else{		
   $t_ense = "and ensenanza = '$tipo_ensenanza'";
}	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
      <td><div id="capa0">
	   <tablE width="100%">
	     <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
           <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	    </td></tr>
		</tablE>
       </div></td>
     </tr>
   </table>
					  
					  
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><span class="Estilo1">REPUBLICA DE CHILE<br>
MINISTERIO DE EDUCACION </span><br></td>
                          </tr>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td class="tableindex"><div align="center">RENDIMIENTO ESCOLAR<br>
A&Ntilde;O <?=$ano_escolar;?></div></td>
                          </tr>
                        </table>
                        <br>
                        <table width="100%" border="1" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="20%" class="tablatit2-1">Nombre del Establecimiento </td>
                                <td width="30%"><span class="Estilo2"><?=$ins_pal ?></span></td>
                                <td width="20%" class="tablatit2-1">Let - N&uacute;mero </td>
                                <td width="30%" class="Estilo2"><?=$letra_inst ?></td>
                              </tr>
                              <tr>
                                <td class="tablatit2-1">Direcci&oacute;n Localidad </td>
                                <td class="Estilo2">&nbsp;<?=$direccion ?> <?=$ciudad ?></td>
                                <td class="tablatit2-1">Tel&eacute;fono</td>
                                <td class="Estilo2"><?=$telefono ?></td>
                              </tr>
                              <tr>
                                <td class="tablatit2-1">E-mail</td>
                                <td class="Estilo2">&nbsp;<?=$email ?></td>
                                <td class="tablatit2-1">Celular</td>
                                <td class="Estilo2">&nbsp;<?=$celular ?></td>
                              </tr>
                              <tr>
                                <td class="tablatit2-1">Regi&oacute;n</td>
                                <td class="Estilo2"><?=$region ?></td>
                                <td colspan="2" rowspan="3" valign="bottom"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="20%" class="tablatit2-1"><div align="center">Depen<br>
                                      dencia</div></td>
                                    <td width="20%" class="tablatit2-1"><div align="center">Area<br>
                                      Geogra.</div></td>
                                    <td width="20%" class="tablatit2-1"><div align="center">Tipo de <br>
                                      Ense&ntilde;anza</div></td>
                                    <td width="20%" class="tablatit2-1"><div align="center">Rol Base<br>
                                      de datos </div></td>
                                    <td width="20%" class="tablatit2-1"><div align="center">D/V</div></td>
                                  </tr>
                                  <tr>
                                    <td class="Estilo2"><div align="center">
                                      <table width="100%" border="1" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td class="Estilo2"><div align="center"><?=$dependencia ?></div></td>
                                        </tr>
                                      </table>
                                    </div></td>
                                    <td class="Estilo2"><div align="center">
                                      <table width="100%" border="1" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td class="Estilo2"><div align="center"><?=$area_geo ?></div></td>
                                        </tr>
                                      </table>
                                    </div></td>
                                    <td class="Estilo2"><div align="center">
                                      <table width="100%" border="1" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td class="Estilo2"><div align="center"><? if ($tipo_ensenanza==1){ echo "Todas"; }else{ echo $tipo_ensenanza; } ?></div></td>
                                        </tr>
                                      </table>
                                    </div></td>
                                    <td class="Estilo2"><div align="center">
                                      <table width="100%" border="1" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td class="Estilo2"><div align="center"><?=$institucion ?></div></td>
                                        </tr>
                                      </table>
                                    </div></td>
                                    <td class="Estilo2"><div align="center">
                                      <table width="100%" border="1" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td class="Estilo2"><div align="center"><?=$dig_rdb ?></div></td>
                                        </tr>
                                      </table>
                                    </div></td>
                                  </tr>
                                </table></td>
                                </tr>
                              <tr>
                                <td class="tablatit2-1">Provincia</td>
                                <td class="Estilo2"><?=$ciudad ?></td>
                                </tr>
                              <tr>
                                <td class="tablatit2-1">Comuna</td>
                                <td class="Estilo2"><?=$comuna ?></td>
                                </tr>
                            </table></td>
                          </tr>
                        </table>
                      <br>
                      <br>
                      <table width="100%" border="1" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="10%" rowspan="3" class="tableindex">VARIABLE</td>
                          <td width="18%" rowspan="2" class="tableindex">B&aacute;sica / Media<br>
                            Ni&ntilde;os<br>
                            Media Adultos </td>
                          <td colspan="8" class="tableindex"><div align="center">TOTAL HOMBRES </div></td>
                          </tr>
                        <tr>
                          <td class="tablatit2-1"><div align="center">1</div></td>
                          <td class="tablatit2-1"><div align="center">2</div></td>
                          <td class="tablatit2-1"><div align="center">3</div></td>
                          <td class="tablatit2-1"><div align="center">4</div></td>
                          <td class="tablatit2-1"><div align="center">5</div></td>
                          <td class="tablatit2-1"><div align="center">6</div></td>
                          <td class="tablatit2-1"><div align="center">7</div></td>
                          <td class="tablatit2-1"><div align="center">8</div></td>
                        </tr>
                        <tr>
                          <td class="tableindex">B&aacute;sica Adultos </td>
                          <td width="9%" ><div align="center"><span class="Estilo2">Alfabeti-<br>
                            zaci&oacute;n</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">1&ordm; Nivel<br>
                            B&aacute;sico</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">2&ordm; Nivel<br>
                            B&aacute;sico</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">3&ordm; Nivel<br>
                            B&aacute;sico</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">Niveles<br>
                            T&eacute;cnicos</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">&nbsp;</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">&nbsp;</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">&nbsp;</span></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="tablatit2-1">Matricula inicial 30 de Abril </td>
						  <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '1' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_1_hombre = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_1_hombre ?></div></td>
						  <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_2_hombre = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_2_hombre ?></div></td>
						  <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '3' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_3_hombre = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_3_hombre ?></div></td>
						  <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '4' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_4_hombre = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_4_hombre ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '5' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_5_hombre = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_5_hombre ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '6' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_6_hombre = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_6_hombre ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '7' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_7_hombre = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_7_hombre ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '8' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_8_hombre = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_8_hombre ?></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="tablatit2-1">Ingresados despu&eacute;s 30 de Abril </td>
						  <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '1' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_hombre_1 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_hombre_1 ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_hombre_2 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_hombre_2 ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_hombre_3 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_hombre_3 ?></div></td>
						    <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '4' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_hombre_4 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_hombre_4 ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '5' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_hombre_5 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_hombre_5 ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '6' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_hombre_6 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_hombre_6 ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '7' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_hombre_7 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_hombre_7 ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '8' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_hombre_8 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_hombre_8 ?></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="tablatit2-1">Retirados</td>
						  <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '1' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 2 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_hombre_1 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$retirados_hombre_1 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 2 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_hombre_2 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$retirados_hombre_2 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '3' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 2 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_hombre_3 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$retirados_hombre_3 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '4' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 2 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_hombre_4 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$retirados_hombre_4 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '5' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 2 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_hombre_5 = $contador;
							///----------------- ?>
                          <td class="Estilo2"><div align="center"><?=$retirados_hombre_5 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '6' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 2 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_hombre_6 = $contador;
							//-----------------?>
                          <td class="Estilo2"><div align="center"><?=$retirados_hombre_6 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '7' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 2 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_hombre_7 = $contador;
							///-------------?>
							
                          <td class="Estilo2"><div align="center"><?=$retirados_hombre_7 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '8' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 2 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_hombre_8 = $contador;
							///---------------------------?>
							
                          <td class="Estilo2"><div align="center"><?=$retirados_hombre_8 ?></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="tablatit2-1">Matr&iacute;cula Final </td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '1' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_hombre_1 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_hombre_1 ?></div></td>
						  <?
						    // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_hombre_2 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_hombre_2 ?></div></td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '3' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_hombre_3 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_hombre_3 ?></div></td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '4' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_hombre_4 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_hombre_4 ?></div></td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '5' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_hombre_5 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_hombre_5 ?></div></td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '6' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_hombre_6 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_hombre_6 ?></div></td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '7' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_hombre_7 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_hombre_7 ?></div></td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '8' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_hombre_8 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_hombre_8 ?></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="tablatit2-1">Promovidos</td>
						  <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '1' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_1 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_1 ?></div></td>
						   <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_2 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_2 ?></div></td>
						   <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '3' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_3 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_3 ?></div></td>
						   <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '4' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_4 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_4 ?></div></td>
						   <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '5' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_5 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_5 ?></div></td>
						   <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '6' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_6 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_6 ?></div></td>
						   <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '7' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_7 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_7 ?></div></td>
						   <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '8' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_8 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_8 ?></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="tablatit2-1">Reprobados</td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '1' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$reprovados_hombre_1 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_1 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$reprovados_hombre_2 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_2 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '3' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}																
							}							
							$reprovados_hombre_3 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_3 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '4' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}																
							}							
							$reprovados_hombre_4 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_4 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '5' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}																
							}							
							$reprovados_hombre_5 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_5 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '6' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}																
							}							
							$reprovados_hombre_6 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_6 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '7' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}																
							}							
							$reprovados_hombre_7 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_7 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '8' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}																
							}							
							$reprovados_hombre_8 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_8 ?></div></td>
                        </tr>
                      </table>
                      <br>
                      <br>
                      <table width="100%" border="1" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="10%" rowspan="3" class="tableindex">VARIABLE</td>
                          <td width="18%" rowspan="2" class="tableindex">B&aacute;sica / Media<br>
                            Ni&ntilde;os<br>
                            Media Adultos </td>
                          <td colspan="8" class="tableindex"><div align="center">TOTAL MUJERES </div></td>
                          </tr>
                        <tr>
                          <td class="tablatit2-1"><div align="center">1</div></td>
                          <td class="tablatit2-1"><div align="center">2</div></td>
                          <td class="tablatit2-1"><div align="center">3</div></td>
                          <td class="tablatit2-1"><div align="center">4</div></td>
                          <td class="tablatit2-1"><div align="center">5</div></td>
                          <td class="tablatit2-1"><div align="center">6</div></td>
                          <td class="tablatit2-1"><div align="center">7</div></td>
                          <td class="tablatit2-1"><div align="center">8</div></td>
                        </tr>
                        <tr>
                          <td class="tableindex">B&aacute;sica Adultos </td>
                          <td width="9%" ><div align="center"><span class="Estilo2">Alfabeti-<br>
                            zaci&oacute;n</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">1&ordm; Nivel<br>
                            B&aacute;sico</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">2&ordm; Nivel<br>
                            B&aacute;sico</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">3&ordm; Nivel<br>
                            B&aacute;sico</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">Niveles<br>
                            T&eacute;cnicos</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">&nbsp;</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">&nbsp;</span></div></td>
                          <td width="9%" ><div align="center"><span class="Estilo2">&nbsp;</span></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="tablatit2-1">Matricula inicial 30 de Abril </td>
						  <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '1' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_1_mujer = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_1_mujer ?></div></td>

						  <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_2_mujer = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_2_mujer ?></div></td>
						  <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '3' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_3_mujer = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_3_mujer ?></div></td>
						  <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '4' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_4_mujer = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_4_mujer ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '5' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_5_mujer = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_5_mujer ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '6' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_6_mujer = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_6_mujer ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '7' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_7_mujer = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_7_mujer ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
							$sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '8' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.fecha < '$ano_escolar-05-01' ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_8_mujer = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_8_mujer ?></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="tablatit2-1">Ingresados despu&eacute;s 30 de Abril </td>
						  <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '1' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_mujer_1 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_mujer_1 ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_mujer_2 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_mujer_2 ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_mujer_3 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_mujer_3 ?></div></td>
						    <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '4' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_mujer_4 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_mujer_4 ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '5' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_mujer_5 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_mujer_5 ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '6' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_mujer_6 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_mujer_6 ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '7' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_mujer_7 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_mujer_7 ?></div></td>
						   <?
						  //------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '8' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_mujer_8 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_mujer_8 ?></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="tablatit2-1">Retirados</td>
						  <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '1' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 1 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_mujer_1 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$retirados_mujer_1 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 1 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_mujer_2 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$retirados_mujer_2 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '3' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 1 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_mujer_3 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$retirados_mujer_3 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '4' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 1 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_mujer_4 = $contador;
							//------------------?>
                          <td class="Estilo2"><div align="center"><?=$retirados_mujer_4 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '5' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 1 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_mujer_5 = $contador;
							///----------------- ?>
                          <td class="Estilo2"><div align="center"><?=$retirados_mujer_5 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '6' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 1 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_mujer_6 = $contador;
							//-----------------?>
                          <td class="Estilo2"><div align="center"><?=$retirados_mujer_6 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '7' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 1 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_mujer_7 = $contador;
							///-------------?>
							
                          <td class="Estilo2"><div align="center"><?=$retirados_mujer_7 ?></div></td>
						   <?
						  // ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '8' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 1 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);
								
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$retirados_mujer_8 = $contador;
							///---------------------------?>
							
                          <td class="Estilo2"><div align="center"><?=$retirados_mujer_8 ?></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="tablatit2-1">Matr&iacute;cula Final </td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '1' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_mujer_1 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_mujer_1 ?></div></td>
						  <?
						    // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_mujer_2 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_mujer_2 ?></div></td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '3' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_mujer_3 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_mujer_3 ?></div></td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '4' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_mujer_4 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_mujer_4 ?></div></td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '5' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_mujer_5 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_mujer_5 ?></div></td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '6' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_mujer_6 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_mujer_6 ?></div></td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '7' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_mujer_7 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_mujer_7 ?></div></td>
						  <?
						  // MATRICULA FINAL - HOMBRES
                             //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '8' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$matricula_final_mujer_8 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$matricula_final_mujer_8 ?></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="tablatit2-1">Promovidos</td>
						  <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '1' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_mujer_1 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_mujer_1 ?></div></td>
						   <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_2 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_2 ?></div></td>
						   <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '3' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_3 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_3 ?></div></td>
						   <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '4' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_4 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_4 ?></div></td>
						   <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '5' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_5 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_5 ?></div></td>
						   <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '6' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_6 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_6 ?></div></td>
						   <?

						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '7' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_7 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_7 ?></div></td>
						   <?
						    //PROMOVIDOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '8' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$aprobados_hombre_8 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$aprobados_hombre_8 ?></div></td>
                        </tr>
                        <tr>
                          <td colspan="2" class="tablatit2-1">Reprobados</td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '1' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$reprovados_hombre_1 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_1 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}	
																
							}	
							
							$reprovados_hombre_2 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_2 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '3' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}																
							}							
							$reprovados_hombre_3 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_3 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '4' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}																
							}							
							$reprovados_hombre_4 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_4 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '5' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}																
							}							
							$reprovados_hombre_5 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_5 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '6' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}																
							}							
							$reprovados_hombre_6 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_6 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '7' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}																
							}							
							$reprovados_hombre_7 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_7 ?></div></td>
						  <?
						    //REPROVADOS HOMBRE
                            //----------------------------------------------------------------
						    $sql ="";
							$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '8' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
								$resultado = pg_exec($conn,$sql2);
								$num_resultado = @pg_numrows($resultado);							
																
								for ($i=0; $i < $num_resultado; $i++){
									$fila2 = @pg_fetch_array($resultado,$i);
									$rut_alumno = $fila2['rut_alumno'];
									$dig_rut    = $fila2['dig_rut'];
									
									$ok = validar_dav($rut_alumno,$dig_rut);		
									if ($dig_rut==NULL){
									   $ok = 0;
									}   
									if ($ok==1){
										$contador++;
									}
								}																
							}							
							$reprovados_hombre_8 = $contador;
							///---------------------------?>
                          <td class="Estilo2"><div align="center"><?=$reprovados_hombre_8 ?></div></td>
                        </tr>
                      </table>
                      <br>
                      <br>
                      <br>
					  <?
					  //Consulta que trae el nombre del director según el perfil director
					    $sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
						$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
						$sql = $sql . "WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo=1 OR trabaja.cargo=23) ";
						$result =@pg_Exec($conn,$sql);
						if (!$result) 
						{
							error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
						}
						else
						{
							if (pg_numrows($result)!=0)
							{
								$fila = @pg_fetch_array($result,0);	
								if (!$fila)
								{
									error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
									exit();
								}
							}
						}
						$direccion2 = $fila['nombre_emp']." ".$fila['ape_pat']." ".$fila['ape_mat'];
					  
					  ?>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                       
                        <tr>
                          <td width="10%">&nbsp;</td>
                          <td class="Estilo1"><? echo "$direccion2"; ?></td>
                          <td width="10%" class="Estilo1">&nbsp;</td>
                          <td class="Estilo1">_________________</td>
                          <td width="10%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td class="Estilo1">NOMBRE DEL DIRECTOR (A) </td>
                          <td class="Estilo1">&nbsp;</td>
                          <td class="Estilo1">FIRMA DEL DIRECTOR(A) </td>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                      
</body>
</html>
<? pg_close($conn);?>