<?php 	require('../../../../../util/header.inc');
$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$_POSP          =5;
	$_bot           =5;
	
	$sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL."";
		if($_PERFIL!=0){
			$sql.=" AND rut_emp=".$_NOMBREUSUARIO;
		}
		//echo $sql;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0){
			$whe_perfil_curso=" AND curso.ensenanza=".pg_result($rs_acceso,3)." AND grado_curso in(";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['grado_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['grado_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}else{
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL!=19)){$whe_perfil_ano=" and id_ano=$ano";}
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL!=29)&&($_PERFIL!=19)){$whe_perfil_curso=" and curso.id_curso=$curso";}
		}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
				pag="../seteaCurso.php3?caso=11&p=17&curso="+curso2+"&frmModo="+frmModo
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
				pag="../../seteaAno.php3?caso=10&pa=15&ano="+ano2+"&frmModo="+frmModo
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
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>            <table width="100%"><tr><td>&nbsp;</td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3">
				<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table>
					  <tr> 
					  <td>
                        <? $menu_lateral="3_1";   include("../../../../../menus/menu_lateral.php"); ?>
						</td>
						</tr>
						</table>
					  </td>
					
                      <td width="100%" align="left" valign="top">
  					   <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                           <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top">
								  
								  <table width="100%" border="0" cellpadding="5" cellspacing="0">
                                    <tr>
                                      <td colspan="3" class="tableindex">Inasistencia por Asignatura</td>
                                      </tr>
                                    
                                    <tr valign="top">
                                      <td width="145" class="textosimple"><strong>A&Ntilde;O ESCOLAR</strong> </td>
                                      <td width="10">:</td>
                                      <td>
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
					              <form name="form"   action="" method="post">
									  <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
						              <select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
						                <option value=0 selected>(Seleccione un A�o)</option> 
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
		                          echo "<option value=".$id_ano." selected>".$nro_anos."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_anos."&nbsp;(".$estado.")</option>";
                              }
							} ?>
				                 </select>
								</form>				
					                  <? }?></td>
                                    </tr>
                                    <tr valign="top">
                                      <td class="textosimple"><strong>CURSO</strong></td>
                                      <td>:</td>
                                      <td>
						  <form name="form"   action="" method="post">
							    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
                 <? // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS // 
						$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
						$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
						$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
						$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
						$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $filan = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($filan['id_curso'], 1, $conn);
		  
		        if (($filan['id_curso'] == $cmb_curso) or ($filan['id_curso'] == $curso)){
		           echo "<option value=".$filan['id_curso']." selected>".$Curso_pal."</option>";
		        }else{	    
		           echo "<option value=".$filan['id_curso'].">".$Curso_pal."</option>";
                }
		     } ?>
          </select>
									</form>									  </td>
                                    </tr>
                                  </table>
									
						<? if (($curso != 0) or ($curso != NULL)){ ?>			
									<form name="form1" method="post" action="inasistencia_docente.php?listar=true" id="listar">
                                    <table width="100%" border="0" cellpadding="5" cellspacing="0">
                                      
                                      <tr>
                                        <td width="145" class="textosimple"><strong>INGRESE FECHA</strong></td>
                                        <td width="10" >:</td>
                                        <td ><input name="fechac" type="text" id="listar" maxlength="5" size="5"> <span class="textosimple">dd-mm</span></td>
                                      </tr>
                                      <tr>
                                        <td colspan="3"><div align="center"><br>
                                          <input name="listar" type="submit" id="listar" value="Buscar" class="botonXX">
                                        </div></td>
                                      </tr>
                                    </table>
									</form>
									
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
										 
										 $contadorfecha=strlen($fechac);	 
									     if ($contadorfecha != 5){
									         echo "<div align='center'><font size='2' face='arial' color='ff6600'>
																			ERROR, DEBE INGRESAR D�A Y MES EN FORMATO: DD-MM </font></div>";
										 }else{
										     echo "<div align='center'><font size='2' face='arial' color='ff6600'>
																			&nbsp;&nbsp; $diasemana,  $dd de $mes de $aa  </font></div><br>";
										 				  
									 ?>						 								  	 
								  	 
									 
										 
								   <form name="form2" method="post" action="ing_inasistencia_docente.php">
								      <input name="fechac" type="hidden" value="<?=$fechac ?>">	
									  <input name="listar" type="hidden" value="1">	 

									  
                                    <br>
                                   
                                    <table width="100%" border="0" cellspacing="0" cellpadding="3">
									  <tr>
									  	<td class="textosesion">Tipo 1: Permiso Administrativo </td>
										<td class="textosesion">Tipo 2: Licencia Medica </td>
										<td class="textosesion">Tipo 3: Ausente</td>
										<td class="textosesion">&nbsp;</td>
									  </tr>
                                      <tr>
                                        <td width="150" bgcolor="#CCCCCC" class="tablatit2-1"><div align="left">Docentes</div></td>
                                        <td bgcolor="#CCCCCC" class="tablatit2-1" colspan="3"><div align="center">Asignaturas</div></td>
                                      </tr>
								    </table>
                                      <!-- PROCESO PARA BUSCAR A LOS ALUMNOS -->
									  <?
									  if ($listar){
									     
									// TODOS LOS DOCENTES DEL CURSO
		                                $q5="
										select distinct(rut_emp)
										from ramo r, dicta d
										where r.id_ramo = d.id_ramo and r.id_curso = '$curso'										
										";
	                                    $r5= pg_Exec($conn,$q5);
		                                $n5= pg_numrows($r5);
										

		                                //echo "n5 tiene: $n5<br>";
		
		                                // ACA HE ENCONTRADO A LOS ALUMOS QUE PERTENECENA LA INSITUCION AL CURSO Y EN EL ANO ELEGIDO
	                                    // SE DEBE SABER QUE HORARIO TIENE CADA ALUMNO ENCONTRADO
										?>
										<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#D7D7D7">
		                                <?
		                                if ($n5 != 0){
		                                   $i = 0;
			                               while ($i < $n5){
			                                  $f5 = @pg_fetch_array($r5,$i);
				                              $rut_emp = $f5['rut_emp'];
											  ?>
											  
											  <?
											  // SACO EL NOMBRE DE LOS DOCENTES
											  $q55="select empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from empleado where rut_emp = '$rut_emp'";
											  $r55=pg_Exec($conn,$q55);
											  $n55=pg_numrows($r55);
											  
											  if ($n55 != 0){
											     $f55 = pg_fetch_array($r55,0);
											     $nombrempleado = $f55['nombre_emp'];
												 $nombrempleado.= $f55['ape_pat'];
												 $nombrempleado.= $f55['ape_mat'];
												 ?>
												 
												 <!-- DESPLIEGO EL NOMBRE DEL ALUMNO -->
<? // VEL ?>												 
									             <tr>
                                                    
													
													 <?
													 // SACO LA RELACION DEL DOCENTE CON EL RAMO																										 
													 $q6="select r.id_ramo, d.rut_emp, e.nombre_emp, e.ape_pat, e.ape_mat
															from ramo r, dicta d, empleado e
															where r.id_ramo = d.id_ramo and r.id_curso = '$curso' and d.rut_emp = e.rut_emp and e.rut_emp = '$rut_emp'";
				                                     $r6= pg_Exec($conn,$q6);
		                                             $n6= pg_numrows($r6);		
		                                              //echo "n6 tiene: $n6<br>";
				
				                                      // TENGO LOS RAMOS DE CADA ALUMNO
				                                      // SE DEBE BUSCAR EL HORARIO DE CADA RAMO ENCONTRADO
				
				                                      if ($n6 != 0){													  
				                                         $j = 0;
														 $cont_emp =0;
				                                         while ($j < $n6){					
															$cont_emp++;
				                                            $f6 = @pg_fetch_array($r6,$j);
				                                            $id_ramo = $f6['id_ramo'];
																											 
					  
					                                       //SACO LA RELACION DEL DOCENTE CON EL HORARIO
															
															$q7 = "SELECT a.id_horario,to_char(a.horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(a.horafin,'HH24:MI') AS hora, trim(c.nombre) AS nombre FROM horario a, ramo b, subsector c WHERE a.id_ramo=b.id_ramo AND a.id_ramo = '$id_ramo' AND b.cod_subsector=c.cod_subsector AND a.id_curso=" . $curso . " AND a.dia=" . $wday . " union (SELECT a.id_horario,to_char(a.horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(a.horafin,'HH24:MI') AS hora, trim(c.nombre_taller) AS nombre FROM horario a, taller c WHERE a.id_taller=c.id_taller AND c.rdb=" . $institucion ." AND a.dia=" . $wday . "AND a.id_curso=" . $curso . ") order by hora";
					                                        $r7= pg_Exec($conn,$q7);
		                                                    $n7= pg_numrows($r7);
															
															$f7 = @pg_fetch_array($r7,0);
															$horaini    = $f7['hora'];
															$asignatura = $f7['nombre'];											
															if($n7!=999){ 
																if($cont_emp==1){?>
																<td width="150" bgcolor="#FFFFFF"><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><?=$nombrempleado ?></font></div></td>
														<?		}
															if($horaini != NULL){
														
															   ?>
															   <td width="200" bgcolor="#FFFFFF">
															      <table width="100%" border="0" cellpadding="0" cellspacing="0">
															         <tr><td height="50"><div align="center"><? echo "<font face='arial' size='1'>$horaini <br>$asignatura</font>"?></div></td></tr>
																	 <tr><td height="10"><div align="center">
																		<?      $datos = $rut_emp."_".$id_ramo."_".$horaini;	
																		
																		        $horaini    = substr($horaini,0,5);
																				$datos = $rut_emp."_".$id_ramo."_".$horaini;
																																																							
																	   
																				$sql_inasis = "select * from inasistencia_docente where rut_emp = '".trim($rut_emp)."' and id_ramo = '".trim($id_ramo)."' and ano = '".$ano."' and fecha = '".trim($fecha_ing)."'";
																				$res_inasis = pg_Exec($conn, $sql_inasis);
																				$fila_docente = pg_fetch_array($res_inasis);
																				if(pg_numrows($res_inasis)!="")
																				{	?>
																					<input type="checkbox" name="datos[<?=$idch ?>]" value="<?=$datos ?>" checked="checked">
																		<?		}else{	?>
																					<input type="checkbox" name="datos[<?=$idch ?>]" value="<?=$datos ?>">
																		<?		}		?>
																				Tipo <select name="chk_tipo[<?=$idch ?>]">
																				<? if($fila_docente['tipo']==""){?><option>- -</option><? }?>
																				<? if($fila_docente['tipo']==1){?><option selected="selected" value="1">1</option><? }else{?><option value="1">1</option><? } ?>
																				<? if($fila_docente['tipo']==2){?><option selected="selected" value="2">2</option><? }else{?><option value="2">2</option><? } ?>
																				<? if($fila_docente['tipo']==3){?><option selected="selected" value="3">3</option><? }else{?><option value="3">3</option><? } ?>
	  																				 </select> 																							 		
																		
																		 </div></td></tr>
															     </table>															   </td>	  	 
                                                               <?
															}else{
															   
														 	}	
															}
															$idch++;
															$j++;
														 }
													 }
													 ?>	 	
                                                 </tr>
									            
												 <? // Fin VEL
											  }else{
											      echo "Docente no encontrado";
											  }
											  $i++;											  
										   }
										   
										   ?>
						            </table>
										    <?
										}
								    } 
									?>							  
									<input type="hidden" name="cont_fin" value="<?=$idch?>">
									        <table width="100%" border="0" cellspacing="0" cellpadding="0">
																	     <tr>
                                                <td><div align="center">
                                                  <label> <br>
                                                  <br>
                                                 <?
											      if (($_PERFIL==17) AND ($_INSTIT==9566 || $_INSTIT==24977 || $_INSTIT==516)){ 
			                                          // no muestro
			                                      }else{
												       if (($_PERFIL!=2) and ($_PERFIL!=20)){
													      ?>
												          <input type="button" name="Submit" value="GRABAR INASISTENCIA" class="botonXX" onClick="grabar()">
                                                    <? } 
											     } ?>   
												  
												  </label>  
												  <?
												  if (($_PERFIL!=2) and ($_PERFIL!=20)){ ?>												   
												      <input name="Submit2" type="button" onClick="MM_goToURL('parent','inasistencia_docente.php');return document.MM_returnValue" value="VOLVER" class="botonXX">
                                                <? } ?>												
												</div></td>
                                              </tr>
                                            </table>  
                                   </form>
								   
								    <? }
									}
									
									}else{  ?>							      </td>
								</tr>
                                <tr>
                                  <td height="390" valign="top">&nbsp;</td>
                                </tr>
							  </table>
									<? }	
										
									    
										
									
									?>
                                    <br>
                                    <br></td>
                          </tr>
                              </table>
				      </td>
                    </tr>
                  </table></td>
              </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
            </table>
	      </td>
        </tr>
            </table>
    </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</body>
</html>
