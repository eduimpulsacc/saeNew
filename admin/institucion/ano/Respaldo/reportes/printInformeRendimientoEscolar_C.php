<script>
function exportar(form){
					form.target="_blank";
					document.form.action='printInformeRendimientoEscolar_C.php?tipo_ensenanza=<?=$tipo_ensenanza?>&c_reporte=<?=$c_reporte?>';
					document.form.submit(true);
			}
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
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$reporte		= $c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$ano_escolar = $ob_membrete->nro_ano;
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
   $t_ense = $tipo_ensenanza;
}	
	

if(!$cb_ok =="Buscar"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_Rendimiento_Escolar_$Fecha.xls"); 
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
 <form name="form" action="printInformeRendimientoEscolar_C.php" method="post">
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
      <td><div id="capa0">
	   <tablE width="100%">
	     <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
           <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	    </td>
		<? if($_PERFIL==0){?>
			  <td align="right"><input name="button4" type="button" class="botonXX" onClick="exportar(this.form)"  value="EXPORTAR"></td>
	    <? }?>
		 </tr>
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
A&Ntilde;O <?=$ano_escolar;?> </div></td>
                          </tr>
                        </table>
                        <br>
                        <table width="100%" border="1" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="20%" class="tablatit2-1">Nombre del Establecimiento </td>
                                <td width="30%"><span class="Estilo2"><?=$ob_membrete->ins_pal ?></span></td>
                                <td width="20%" class="tablatit2-1">Let - N&uacute;mero </td>
                                <td width="30%" class="Estilo2"><?=$ob_membrete->letra ?></td>
                              </tr>
                              <tr>
                                <td class="tablatit2-1">Direcci&oacute;n Localidad </td>
                                <td class="Estilo2">&nbsp;<?=$ob_membrete->direccion ?> <?=$ob_membrete->ciudad ?></td>
                                <td class="tablatit2-1">Tel&eacute;fono</td>
                                <td class="Estilo2"><?=$ob_membrete->telefono ?></td>
                              </tr>
                              <tr>
                                <td class="tablatit2-1">E-mail</td>
                                <td class="Estilo2">&nbsp;<?=$ob_membrete->email ?></td>
                                <td class="tablatit2-1">Celular</td>
                                <td class="Estilo2">&nbsp;<?=$ob_membrete->celular ?></td>
                              </tr>
                              <tr>
                                <td class="tablatit2-1">Regi&oacute;n</td>
                                <td class="Estilo2"><?=$ob_membrete->region ?></td>
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
                                          <td class="Estilo2"><div align="center"><?=$ob_membrete->dependencia ?></div></td>
                                        </tr>
                                      </table>
                                    </div></td>
                                    <td class="Estilo2"><div align="center">
                                      <table width="100%" border="1" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td class="Estilo2"><div align="center"><?=$ob_membrete->area_geo ?></div></td>
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
                                          <td class="Estilo2"><div align="center"><?=$ob_membrete->dig_rdb ?></div></td>
                                        </tr>
                                      </table>
                                    </div></td>
                                  </tr>
                                </table></td>
                                </tr>
                              <tr>
                                <td class="tablatit2-1">Provincia</td>
                                <td class="Estilo2"><?=$ob_membrete->provincia ?></td>
                                </tr>
                              <tr>
                                <td class="tablatit2-1">Comuna</td>
                                <td class="Estilo2"><?=$ob_membrete->comuna ?></td>
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=1;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							//$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '2' $t_ense order by id_curso";
							//$res = pg_Exec($conn,$sql);
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=2;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							/*$sql = "select id_curso from curso where id_ano = '$ano' and grado_curso = '3' $t_ense order by id_curso";
							$res = pg_Exec($conn,$sql);*/
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=3;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=4;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=5;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=6;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=7;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=8;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=1;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
								/*$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
								$resultado = pg_exec($conn,$sql2);*/
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=2;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=3;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=4;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=5;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=6;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=7;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=8;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=1;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=2;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=3;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=4;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=5;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat2 = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=6;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=7;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=8;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=1;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=2;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
								/*$sql2 = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and (matricula.bool_ar=0)";
								$resultado = pg_exec($conn,$sql2);*/
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=3;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=4;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=5;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=6;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=7;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=8;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =2;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=1;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
								
								/*$sql2 = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
								pg_exec($conn,$sql2);*/
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=2;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=3;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=4;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=5;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=6;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=7;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=8;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=1;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=2;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=3;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=4;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=5;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=6;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=7;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=8;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=2;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=1;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=1;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=3;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=4;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=5;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=6;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=6;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=8;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-05-01";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=1;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=2;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);

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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=3;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);

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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=4;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);

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
						$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=5;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);

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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=6;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
																$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);

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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=7;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);

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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=8;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);

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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=1;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=2;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);

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
						$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=3;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=4;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=5;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=6;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=7;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=8;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "$ano_escolar-11-30";
								$ob_reporte ->fecha_mat2 = "$ano_escolar-04-30";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=1;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=1;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=2;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=3;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=4;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=5;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=6;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=7;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=8;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->ano=$ano;
								$ob_reporte ->curso =$curso;
								$ob_reporte ->fecha_mat = "12-01-$ano_escolar";
								$ob_reporte ->fecha_mat2 = "";
								$ob_reporte ->sexo =1;
								$ob_reporte ->retirado=0;
								$resultado = $ob_reporte ->TraeTodosAlumnos($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=1;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=2;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=3;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=4;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=5;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=6;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=7;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=8;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=1;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=1;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=2;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=3;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=4;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=5;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=6;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=7;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
							$ob_reporte ->ano = $ano;
							$ob_reporte ->tipo_ensenanza = $t_ense;
							$ob_reporte ->grado=8;
							$res = $ob_reporte ->CursoEnsenanza($conn);
							$num = @pg_numrows($res);
							$contador=0;
							for ($j=0; $j < $num; $j++){ 
							    $fil = @pg_fetch_array($res,$j);
								$curso = $fil['id_curso'];
								
								$ob_reporte ->sexo=1;
								$ob_reporte ->situacion=2;
								$ob_reporte ->curso =$curso;
								$resultado = $ob_reporte ->AlumnoPromovido($conn);
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
</form>                      
</body>
</html>
<? pg_close($conn);?>