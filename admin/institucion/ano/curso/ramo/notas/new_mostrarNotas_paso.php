<?php require('../../../../../../util/header.inc');?>
<?php 




	if ($id_ramo != NULL or $id_ramo != 0){
		$_RAMO=$id_ramo;
		session_register('_RAMO');
	}
	
	if ($viene_de){
		$_VIENEPAG=$viene_de;	
	}
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$docente		=5; //Codigo Docente
	$_POSP          =6;
	$_bot           =5;

if($drop=="1"){ //Elimino la tabla temporal que se creo, al no efectuar los cambios
$qry_drop = "DROP TABLE $_TABLA_TEMP";	
$res_drop = @pg_Exec($qry_drop);
}
	/// AQUI CONSULTO SI ESTE RAMO ES PARTE DE ALGUNNA FORMULA (SUBSECTORRAMO)
	/// Y SI SE DEBE DAR LA OPCION DE INGRESAR NOTA O SOLO MOSTRAR
	$q1 = "select * from formula where id_ramo = '".trim($ramo)."' and modo = '2'";
	$r1 = @pg_Exec($conn,$q1);
	$n1 = @pg_numrows($r1);
	if ($n1>0){
	    $boton_ing = "no";
	}	
		
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		/*if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
			$_ITEM =$item;
			session_register('_ITEM');
		}*/
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}	
	
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
	if($aux!=1)	{//HACER LA CONSULTA Y DESPLEGAR EL PRIMER PERIODO
		$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY NOMBRE_PERIODO";
		$result =@pg_Exec($conn,$qry);
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
		else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
					exit();
				};
				$periodo	= $fila1['id_periodo'];
			}else{
				
			}
		};
	}

	$_PERIODORAMO	=	$periodo;
	if(!session_is_registered('_PERIODORAMO')){
		session_register('_PERIODORAMO');
	};
	
	// VERIFICO SI EL PERIODO ESTA CERRADO
	$q1 = "select * from periodo where id_periodo = ".$periodo."";
	$r1 = pg_Exec($conn,$q1);
	if (!$r1){
	   echo "Erro: No encontró el periodo";
	   exit();
	}else{
	   $f1 = pg_fetch_array($r1,0);
	   $cerradop = $f1['cerrado'];
	}      
	   
	
	
?>

<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../../index.php";
		 </script>

<? } ?>
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

		
		<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>

		<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmbPERIODO.value!=0){
				form.cmbPERIODO.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'new_mostrarNotas.php3?aux=1&periodo='+ form.cmbPERIODO.value;
				form.submit(true);
				}
			}
			function enviapag2(form){
			if (form.cmbPERIODO.value!=0){
				form.cmbPERIODO.target="_blank";
//				form.action = form.cmbPERIODO.value;
				form.action = 'mostrarNotasexcel.php?aux=1&periodo='+ form.cmbPERIODO.value;
				form.submit(true);
				}
			}
		</SCRIPT>

<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">	

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
									<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													
												}
											}
										?>
											<?php
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													
												}
											}
										?>
											<?php
											$qry="SELECT subsector.nombre, subsector.cod_subsector, modo_eval FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila10 = @pg_fetch_array($result,0);	
												
												$_SESSION['_MODOEVAL'] = trim($fila10['modo_eval']);
												
											}
										?>
								       <?php
											$qry4="SELECT curso.id_curso, plan_estudio.cod_decreto, plan_estudio.nombre_decreto FROM curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto WHERE (((curso.id_curso)=".$curso."))";
														$result4 =@pg_Exec($conn,$qry4);
														$fila4= @pg_fetch_array($result4,0);
													
												
											
										?>
                                    			<?php 
	                                                     $qry4="SELECT curso.id_curso, evaluacion.cod_eval FROM curso INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval WHERE (((curso.id_curso)=".$curso."))";
														$result4 =@pg_Exec($conn,$qry4);
														$fila4= @pg_fetch_array($result4,0);
                                                           

													$qry5="SELECT * FROM EVALUACION WHERE COD_EVAL=".$fila4['cod_eval'];
													$result5 =@pg_Exec($conn,$qry5);
													if (!$result5) {
														error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
													}else{
														if (pg_numrows($result5)!=0){
															$fila9 = @pg_fetch_array($result5,0);	
															if (!$fila9){
																error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																exit();
															}
															
														}
													
												}
												
												
				$qry1106="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO = '$ano' AND ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
				$result1106 =@pg_Exec($conn,$qry1106);
				
				if (!$result1106){
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result1106)!=0){
						$fila1106 = @pg_fetch_array($result1106,0);	
						if (!$fila1106){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}else{
						  $fila1106 = @pg_fetch_array($result1106,0);
					    }	  
					}
											
				}				?>	
													
							<?php if(($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){  ?>							
							
										 <?		
										 /// proceso para ver si este ramo es un subsector padre del modo 2
										 /// si es así, no se debe permitir ingresar notas desde aquí
										 $qry_formula = "select * from formula where id_ramo = '$ramo' and modo = '2'";
										 $res_formula = @pg_Exec($conn,$qry_formula);
										 $num_formula = @pg_numrows($res_formula);
										 
										 /// fin proceso formula			 
										 
															 
										 		
									}?>	
																	
							
									<?php
										$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano."))  order by id_periodo";
										$result =@pg_Exec($conn,$qry);
										if (!$result) 
											error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
										else{
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												
												for($i=0 ; $i < @pg_numrows($result) ; $i++){
													$fila1 = @pg_fetch_array($result,$i);
													
												}
											}
										};
									?>
								
								<?php
									//ALUMNOS DEL CURSO
//                                     $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno) WHERE tiene$nro_ano.id_ramo=".$ramo." ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
    	                                $qry="SELECT matricula.rut_alumno, matricula.bool_ar, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso, matricula.nro_lista "; 
										$qry = $qry . " FROM alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno ";
										$qry = $qry . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno ";
										$qry = $qry . " WHERE tiene$nro_ano.id_ramo=".$ramo." AND matricula.id_ano=".$ano." ";
										$qry = $qry . " ORDER BY  nro_lista, ape_pat, ape_mat, nombre_alu, rut_alumno asc ";
										
																				
										$result =@pg_Exec($conn,$qry);
										
										//matricula.nro_lista asc,
										
									if (!$result) 
										error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>'.$qry);
									else{
										if (pg_numrows($result)!=0){
											$fila1 = @pg_fetch_array($result,0);											

											for($i=0 ; $i < @pg_numrows($result) ; $i++){
												$fila1 = @pg_fetch_array($result,$i);
												if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
													
												}else{
													
												}											
													
												//NOTAS ALUMNO POR RAMO Y PERIODO
  											    $qry2="SELECT * FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)=".$fila1['rut_alumno'].") AND ((notas$nro_ano.id_periodo)=".$periodo.") AND ((notas$nro_ano.id_ramo)=".$ramo."))"; 
												$result2 =@pg_Exec($conn,$qry2) or die("select fallo:".$qry2);
												if (!$result2) 
													error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>');
												else{
													if (pg_numrows($result2)!=0){
														$fila2 = @pg_fetch_array($result2,0);
														
														for($j=1;$j<22;$j++){
															$var="nota"."$j";
															
															if ($j==21){
															       if ($fila10['modo_eval']==2){
															    		if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I)){
															       			
															      		}
																	}
															       if ($fila10['modo_eval']==1){
															            if ( trim($fila2['promedio'])!=0){
															                
															            }
															        }
															       if ($fila10['modo_eval']==3){
															            if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I)){
															                
															            }
															        }
															       if ($fila10['modo_eval']==4){
															            if ($fila2['promedio']!=0){
															               
															            }
															        }

															}
															else{
															     if ($fila10['modo_eval']==2){
																	   if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I) OR $fila2["$var"]!=0){
																	     
																	   }
																 }
															     if ($fila10['modo_eval']==1){
																 	if(!strcmp($var,'nota20')){
															           if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){
															              
																		}
																		else{
																		   if ($fila2["$var"]!=0){
																			  
																		   }
																		}
																	}
																	else{
															           if ($fila2["$var"]!=0){
															             
															           }
																	}
															     }
															     if ($fila10['modo_eval']==3){
															           if ($fila2["$var"]!=0){
															              
															           }
															     }
															     if ($fila10['modo_eval']==4){
															           if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){
															            
															           }
															     }
															}
															
														}
													}else{
															
													}
												};
											
											};


										};
									};
								?>
					
  <? 			
  
      // antiguo
      echo "<script>window.location='new_mostrarNotas.php3'</script>";
      // nuevo  
      //echo "<script>window.location='new_mostrarNotas_dav2.php3'/script>";
  
	
   
    
   /*
   if ($_INSTIT==25478 or $_INSTIT==1450 or $_INSTIT==8905 or $_INSTIT==24988 or $_INSTIT==8413 or $_INSTIT==9035 or $_INSTIT==516 or $_INSTIT==1756  or $_INSTIT==9071 or $_INSTIT==1973 or $_INSTIT==24723 or $_INSTIT==14703){ ?>
		   <script>
			 window.location='new_mostrarNotas.php3';
		   </script>
 <? }else{ ?>
           <?
		   if ($_INSTIT==2090){  ?>
		           <script>
					 window.location='new_mostrarNotas_dav2.php3';					
				   </script>
		   
	  <?  }else{ ?>         
				   <script>
					 <!--window.location='new_mostrarNotas_dav2.php3';-->
					 window.location='new_mostrarNotas.php3';
				   </script> 
		<? } ?>		   
 <? } 
 
   */
 	?>	   
</body>
</html>
