<?php 	require('../../../../../util/header.inc');
$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$_POSP          =5;
	$_bot           =5;
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=19)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=19)){$whe_perfil_curso=" and curso.id_curso=$curso";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
function cerrar(){ 
   window.close() 
}

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<script language="JavaScript" type="text/JavaScript">
<!--


<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->

 function grabar(){
	 form2.submit(true);
 }



 function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../seteaCurso.php3?caso=11&p=14&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
		 
		 function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../../seteaAno.php3?caso=10&pa=12&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }//-->
</script>
<head>
<?php 
	
	
	if($ano==""){
		$sql_ano = "select * from ano_escolar where id_institucion=".$_INSTIT." and situacion=1";
		$result_ano = pg_exec($conn,$sql_ano);
		$fil = pg_fetch_array($result_ano,0);
		$ano = $fil['id_ano'] ;
		$nro_ano = $fil['nro_ano'];
		$_ANO=$ano;
	}else{
	    $sql_ano = "select * from ano_escolar where id_institucion=".$_INSTIT." and id_ano=$ano";
		$result_ano = pg_exec($conn,$sql_ano);
		$fil = @pg_fetch_array($result_ano,0);
		$nro_ano = $fil['nro_ano'];		
    }		

	$fecha=getdate();
	$diaActual=$fecha["mday"];
	
	//AQUI TOMO LOS PRIMEROS DATOS
	$q1="SELECT * FROM INSTITUCION WHERE RDB = '".$_INSTIT."'";
	$r1 =pg_Exec($conn,$q1);
	$n1 = pg_numrows($r1);
	
	if ($n1 == 0){
	   //echo "no hay elementos encontrados";
	}else{
	   $f1 = pg_fetch_array($r1,0);
	}
	
	
	
	
	$q2="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
	$r2 =pg_Exec($conn,$q2);
	
	if (!$r2) {
		error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
	}else{
		if (pg_numrows($r2)!=0){
			$f2 = pg_fetch_array($r2,0);
			if (!$f2){
				error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
				exit();
		    }
			$nroAno=trim($f2['nro_ano']);
		}
	}
	
	if (($curso != 0) or ($curso != NULL)){
	    $q3="SELECT * FROM CURSO WHERE ID_CURSO=".$curso;
	    $r3 =@pg_Exec($conn,$q3);
	    if (!$r3) {
		    error('<B> ERROR :</b>Error al acceder a la BD. (51)</B>');
	    }else{
		    if (pg_numrows($r3)!=0){
			    $f3 = @pg_fetch_array($r3,0);	
			    if (!$f3){
				    error('<B> ERROR :</b>Error al acceder a la BD. (52)</B>');
				    exit();
			    }
			    $q4="select nombre_tipo from tipo_ensenanza where cod_tipo=".$f3[ensenanza];
			    $r4 =@pg_Exec($conn,$q4);
			     if (!$r4) {
				     error('<B> ERROR :</b>Error al acceder a la BD. (53)</B>');
			     }else{
				     if (pg_numrows($r4)!=0){
					     $f4 = @pg_fetch_array($r4,0);	
					     if (!$f4){
					         error('<B> ERROR :</b>Error al acceder a la BD. (54)</B>');
					         exit();
					     }
				      }
			      }
			  }
		      $nombrecurso =$f3['grado_curso'];
		      $nombrecurso.="-";
		      $nombrecurso.=$f3['letra_curso'];
		      $nombrecurso.="  ";
	          $nombrecurso.=$f4['nombre_tipo'];
	      }	
	   }
	
	$idch = 1;
	
	
	
?>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
	
	<div id="capa0">	
	<table width="100%">
	      <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
	      <td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
	      </td></tr>
	</table>
	</div>						
 
  <? if ($institucion=="770"){ 
		   // no muestro los datos de la institucion
		   // por que ellos tienen hojas pre-impresas
		   echo "<br><br><br><br><br><br><br><br><br>";
   }  ?>		
				
							
		  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
			<tr> 
			  <td valign="top">		  
			  		  
			  <table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr>
				  <td colspan="3" class="tableindex">Inasistencia por Asignatura</td>
				  </tr>
				
				<tr valign="top">
				  <td width="145" class="textosimple"><strong>A&Ntilde;O ESCOLAR</strong> </td>
				  <td width="10">:</td>
				  <td class="textosimple">
									  <?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." $whe_perfil_ano ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} ?>
					             
									  
						                <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_anos = $filann['nro_ano'];
			                  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "$nro_anos ";
		                      }else{	    
		                          //echo "<option value=".$id_ano.">".$nro_anos."&nbsp;(".$estado.")</option>";
                              }
							} ?>
				               
								
					                  <? }?>
									  
									  </td>
                                    </tr>
                                    <tr valign="top">
                                      <td class="textosimple"><strong>CURSO</strong></td>
                                      <td>:</td>
                                      <td class="textosimple">
						  
									 <? // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS // 
											$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
											$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
											$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
											$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
											$resultado_query_cue = pg_exec($conn,$sql_curso);
									 ?>
								 								  
									 <?
									 for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
										{  
										$filan = @pg_fetch_array($resultado_query_cue,$i); 
										$Curso_pal = CursoPalabra($filan['id_curso'], 1, $conn);
								  
										if (($filan['id_curso'] == $cmb_curso) or ($filan['id_curso'] == $curso)){
										   echo "$Curso_pal";
										}else{	    
										   //echo "<option value=".$filan['id_curso'].">".$Curso_pal."</option>";
										}
									 } 
									 ?>
         				      </td>
                               </tr>
                                  </table>
									
						<? if (($curso != 0) or ($curso != NULL)){ ?>			
									<table width="100%" border="0" cellpadding="5" cellspacing="0">                                      
                                      <tr>
                                        <td width="145" class="textosimple"><strong>FECHA</strong></td>
                                        <td width="10" >:</td>
                                        <td >
										<?
										
										 // TOMO LA FECHA INGRESADA
										 $dd = substr($fechac,0,2);
										 $mm = substr($fechac,3,2);
										 $aa = $nroAno;
										 $fecha_ing = $nroAno."-".$mm."-".$dd;
										 
										 $tstamp=mktime(0,0,0,$mm,$dd,$aa);
                                         $Tdate = getdate($tstamp);
                                         $wday=$Tdate["wday"];
										 $wday--;
										 if ($wday < 0){
										    $wday = 6;
										 }
										 
										 if ($wday == 0){
										    $diasemana = "Lunes";
										 }
										 if ($wday == 1){
										    $diasemana = "Martes";
										 }
										 if ($wday == 2){
										    $diasemana = "Miercoles";
										 }
										 if ($wday == 3){
										    $diasemana = "Jueves";
										 }
										 if ($wday == 4){
										    $diasemana = "Viernes";
										 }
										 if ($wday == 5){
										    $diasemana = "S�bado";
										 }
										 if ($wday == 6){
										    $diasemana = "Domingo";
										 }
										 
										 if ($mm == "01"){
										    $mes = "Enero";
										 }
										 if ($mm == "02"){
										    $mes = "Febrero";
										 }
										 if ($mm == "03"){
										    $mes = "Marzo";
										 }
										 if ($mm == "04"){
										    $mes = "Abril";
										 }
										 if ($mm == "05"){
										    $mes = "Mayo";
										 }
										 if ($mm == "06"){
										    $mes = "Junio";
										 }
										 if ($mm == "07"){
										    $mes = "Julio";
										 }
										 if ($mm == "08"){
										    $mes = "Agosto";
										 }
										 if ($mm == "09"){
										    $mes = "Septiembre";
										 }
										 if ($mm == "10"){
										    $mes = "Octubre";
										 }
										 if ($mm == "11"){
										    $mes = "Noviembre";
										 }
										 if ($mm == "12"){
										    $mes = "Diciembre";
										 }
										 
										 $contadorfecha=strlen($fechac);	 
									     if ($contadorfecha != 5){
									         echo "<font size='2' face='arial' >
																ERROR, DEBE INGRESAR D�A Y MES EN FORMATO: DD-MM </font>";
										 }else{
										     echo "<font size='2' face='arial' >$diasemana,  $dd de $mes de $aa  </font>";
									     }
										 ?>					
										
										
										
										 </td>
                                      </tr>
                                      
                                    </table>
									
									
									<?
									
									 if ($listar){
									     // TOMO LA FECHA INGRESADA
										 $dd = substr($fechac,0,2);
										 $mm = substr($fechac,3,2);
										 $aa = $nroAno;
										 $fecha_ing = $nroAno."-".$mm."-".$dd;
										 
										 $tstamp=mktime(0,0,0,$mm,$dd,$aa);
                                         $Tdate = getdate($tstamp);
                                         $wday=$Tdate["wday"];
										 $wday--;
										 if ($wday < 0){
										    $wday = 6;
										 }
										 
										 if ($wday == 0){
										    $diasemana = "Lunes";
										 }
										 if ($wday == 1){
										    $diasemana = "Martes";
										 }
										 if ($wday == 2){
										    $diasemana = "Miercoles";
										 }
										 if ($wday == 3){
										    $diasemana = "Jueves";
										 }
										 if ($wday == 4){
										    $diasemana = "Viernes";
										 }
										 if ($wday == 5){
										    $diasemana = "S�bado";
										 }
										 if ($wday == 6){
										    $diasemana = "Domingo";
										 }
										 
										 if ($mm == "01"){
										    $mes = "Enero";
										 }
										 if ($mm == "02"){
										    $mes = "Febrero";
										 }
										 if ($mm == "03"){
										    $mes = "Marzo";
										 }
										 if ($mm == "04"){
										    $mes = "Abril";
										 }
										 if ($mm == "05"){
										    $mes = "Mayo";
										 }
										 if ($mm == "06"){
										    $mes = "Junio";
										 }
										 if ($mm == "07"){
										    $mes = "Julio";
										 }
										 if ($mm == "08"){
										    $mes = "Agosto";
										 }
										 if ($mm == "09"){
										    $mes = "Septiembre";
										 }
										 if ($mm == "10"){
										    $mes = "Octubre";
										 }
										 if ($mm == "11"){
										    $mes = "Noviembre";
										 }
										 if ($mm == "12"){
										    $mes = "Diciembre";
										 }
										 
										
										 				  
									 ?>						 								  	 
								  	 
									 
										 
								   <form name="form2" method="post" action="ing_inasistencia.php">
								      <input name="fechac" type="hidden" value="<?=$fechac ?>">	
									  <input name="listar" type="hidden" value="1">	 

									  
                                    <br>
                                   
                                    <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="cccccc">
                                      <tr class="tableindex">
                                        <td width="30%"  class="textosimple"><strong><div align="left">Alumnos</div></strong></td>
                                        <td width="70%"  class="textosimple"><strong><div align="center">Asignaturas</div></strong></td>
                                      </tr>
								    </table>
                                      <!-- PROCESO PARA BUSCAR A LOS ALUMNOS -->
									  <?
									  if ($listar){							 										 
										 
																			  
	                                     // PROCESO PARA LISTAR LAS ASIGNATURAS POR DIA PARA EL ALUMNO
	                                     //echo "institucion : $institucion<br>";
		                                 //echo "ano : $ano<br>";
		                                 //echo "curso: $curso<br>";
				
		                                 // CONSULTA PARA TOMAR LOS ALUMNOS DEL CURSO SELECCIONADO
		
		
		                                //$q5="select * from matricula where rdb = '$institucion' and id_ano = '$ano' and id_curso = '$curso'";
		                                $q5="
										select m.* from matricula m, alumno a
										where m.rut_alumno=a.rut_alumno
										and m.rdb = '$institucion' 
										and m.id_ano = '$ano' 
										and m.id_curso = '$curso'
										order by ape_pat, ape_mat, nombre_alu
										";
	                                    $r5= pg_Exec($conn,$q5);
		                                $n5= pg_numrows($r5);
										

		                                //echo "n5 tiene: $n5<br>";
		
		                                // ACA HE ENCONTRADO A LOS ALUMOS QUE PERTENECENA LA INSITUCION AL CURSO Y EN EL ANO ELEGIDO
	                                    // SE DEBE SABER QUE HORARIO TIENE CADA ALUMNO ENCONTRADO
										?>
										<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="cccccc" bgcolor="#D7D7D7">
		                                <?
		                                if ($n5 != 0){
		                                   $i = 0;
			                               while ($i < $n5){
			                                  $f5 = @pg_fetch_array($r5,$i);
				                              $rut_alumno = $f5['rut_alumno'];
											  ?>
											  
											  <?
											  // TENGO EL RUT DEL ALUMNO, BUSCO AHORA EL NOMBRE Y APELLIDO DEL ALUMNO
											  $qry = "select * from inasistencia_asignatura where rut_alumno = '".trim($rut_alumno)."'";
											  $res = @pg_Exec($conn,$qry);
											  
											  if (@pg_numrows($res)>0){
											      /// muestro al alumno
												  
											  	  
											    				  
											  
												  $q55="select alumno.nombre_alu, alumno.ape_pat from alumno where rut_alumno = '".trim($rut_alumno)."'";
												  $r55=pg_Exec($conn,$q55);
												  $n55=pg_numrows($r55);
												  
												  if ($n55 != 0){
													 $f55 = pg_fetch_array($r55,0);
													 $nombrealumno = $f55['nombre_alu'];
													 $nombrealumno.= $f55['ape_pat'];
													 
													 ?>
													 
													 <!-- DESPLIEGO EL NOMBRE DEL ALUMNO SI ES QUE ESTA EN inaistencia_asignatura -->
																		 
													 
													 <tr>
													   <td width="30%" bgcolor="#FFFFFF"><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><?=$nombrealumno ?></font></div></td>
														
														 <?
														 // TENGO QUE BUSCAR CUANTAS ASIGNATURAS TIENE CADA ALUMNO
														 
														 
														 $q6="select * from tiene$nro_ano, ramo, subsector where tiene$nro_ano.rut_alumno = '$rut_alumno' and ramo.id_ramo = tiene$nro_ano.id_ramo and tiene$nro_ano.id_curso = '$curso' and ramo.cod_subsector = subsector.cod_subsector";
														 $r6= pg_Exec($conn,$q6);
														 $n6= pg_numrows($r6);		
														  //echo "n6 tiene: $n6<br>";
					
														  // TENGO LOS RAMOS DE CADA ALUMNO
														  // SE DEBE BUSCAR EL HORARIO DE CADA RAMO ENCONTRADO
					
														  if ($n6 != 0){
															 $j = 0;
															 while ($j < $n6){
																$f6 = @pg_fetch_array($r6,$j);
																$id_ramo = $f6['id_ramo'];
																
						  
															   /* $q7="select * from horario, estancia where horario.id_ramo = '$id_ramo' and horario.id_curso = '$curso' and horario.dia = '$wday' and estancia.id_institucion = '$institucion' and estancia.id_estancia = horario.id_estancia order by horario.horaini desc";  */
																
																$q7 = "SELECT a.id_horario,to_char(a.horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(a.horafin,'HH24:MI') AS hora, trim(c.nombre) AS nombre FROM horario a, ramo b, subsector c WHERE a.id_ramo=b.id_ramo AND b.cod_subsector=c.cod_subsector AND a.id_curso=" . $curso . " AND a.dia=" . $wday . " union (SELECT a.id_horario,to_char(a.horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(a.horafin,'HH24:MI') AS hora, trim(c.nombre_taller) AS nombre FROM horario a, taller c WHERE a.id_taller=c.id_taller AND c.rdb=" . $institucion ." AND a.dia=" . $wday . "AND a.id_curso=" . $curso . ") order by hora";
																														
																$r7= pg_Exec($conn,$q7);
																$n7= pg_numrows($r7);
																
																$f7 = @pg_fetch_array($r7,$j);
																$horaini    = $f7['hora'];
																$asignatura = $f7['nombre'];
																
																if ($horaini != NULL){
																	?>
																	 <td width="70%" bgcolor="#FFFFFF">
																	  <table width="100" border="0" cellpadding="0" cellspacing="0">
																		<?
																		$sql_inasis = "select * from inasistencia_asignatura where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_ramo)."' and ano = '".$ano."' and fecha = '".trim($fecha_ing)."'";
																		$res_inasis = pg_Exec($conn, $sql_inasis);
																		
																		if(pg_numrows($res_inasis)!=""){
																			?>																																
																			 <tr><td height="0"><div align="center"><? echo "<font face='arial' size='1'>$horaini <br>$asignatura</font>"; ?></div></td></tr>
																			 <tr><td height="0"><div align="center">
																			<? 																																				
																			$datos = $rut_alumno."_".$id_ramo."_".$horaini;
																			?>
																			<!-- <input type="checkbox" name="datoss[<?=$idch ?>]" value="<?=$datos ?>" checked="checked" disabled="disabled">-->
																			<input name="datos[<?=$idch ?>]" type="hidden" value="<?=$datos ?>">
																	<? }else{	
																			$datos = $rut_alumno."_".$id_ramo."_".$horaini;																		       
																			?>
																			<!-- <input type="checkbox" name="datos[<?=$idch ?>]" value="<?=$datos ?>"> -->
																			<input name="datos[<?=$idch ?>]" type="hidden" value="<?=$datos ?>">
																	<? } ?>
																		  </div></td></tr>
																	 </table>
													   </td>	  	 
																	<?
																}else{
																
																   
																}	
																
																$idch++;
																$j++;
															 }
														 }
														 ?>	 	
													 </tr>
													
													 <?
												  }else{
													  echo "alumno no encontrado";
												  }
											  
											  }else{
											      // no muestro nada
											  }										  
											  
											  $i++;											  
										   }
										   
										   ?>
				                     </table>
										    <?
										
								    } 
									?>							  
								   <input type="hidden" name="cont_fin" value="<?=$idch?>">
									          
                                   </form>
								   
								    <? }
									}
									
									}else{  ?>							      </td>
								</tr>
                                <tr>
                                  <td height="390" valign="top">&nbsp;</td>
                                </tr>
							  </table>
						<? } ?>
						
						
						     </td>
                          </tr>
                        </table>
				      </td>
                    </tr>
                  </table>			
</body>
</html>
