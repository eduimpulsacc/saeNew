<?php 
	require('../../../../util/header.inc');
	$pag="curso.php3";

	if($caso==1){//MOSTRAR CURSO
		$_CURSO	=	$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		};
		
		$_ANO	=	$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
		};

		$_INSTIT	=	$institucion;
		if(!session_is_registered('_INSTIT')){
			session_register('_INSTIT');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR CURSO
		if(session_is_registered('_CURSO')){
			session_unregister('_CURSO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		
		
	};
	if($caso==3){//MODIFICAR CURSO
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==4){//MOSTRAR CURSO VOLVIENDO DE ALUMNO O RAMO

		session_unregister('_ALUMNO');		//LIBERA EL ALUMNO
		session_unregister('_RAMO');		//LIBERA EL RAMO

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag = "ramo/listarRamos.php3";
	};

	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoCurso.php3";
	};
	if($caso==10){//MOSTRAR CURSO
		$_CURSO	=	$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		};

		$_FRMMODO	=	$frmModo;
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="alumno/listarAlumnos.php3?url=0";
	};
	
	if($caso==50){//MOSTRAR CURSO
		$_CURSO	=	$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		};

		$_FRMMODO	=	$frmModo;
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="vitacora_alumno/vitacora_alumno.php?url=0";
	};
	
	if($caso==11){//MOSTRAR CURSO
		$_CURSO	=	$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		};

		$_FRMMODO	=	$frmModo;
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		
		$_JORNADA	=	$Jornada;
		if(!session_register('_JORNADA')){
			session_register('_JORNADA');
		};
		
		//if($_PERFIL==0){
			//print_r($_POST);}
		
		if ($p == 1){
		   $pag = "ramo/Ordensubsector.php";
		}else{ 
		   if ($p == 2){
		      $pag = "ramo/listarFormulas.php3";
		   }else{
		      if ($p == 3){
			     $pag = "ramo/formulas.php3";
			  }else{
			     if ($p == 4){
				    $pag = "ramo/ramo.php3";
				 }else{
				    if ($p == 5){
					   $pag = "horario/listarHorario.php";
					}else{
					   if ($p == 6){
					      $pag = "horario/horario.php";
					   }else{
					      if ($p == 7){
						      $pag = "promocion/promocion_pro.php";
						  }else{
						      if ($p == 8){
						         $pag = "asistencia/asistencia.php3";
							  }else{ 	
							     if ($p == 9){
								    $pag = "inasistencia/inasistencia.php";
								 }else{
								    if ($p == 10){
									   $pag = "../fichas/listarAlumnosMatriculados.php3?tipoFicha=1";
									}else{
									   if ($p == 11){
									      $pag = "Listado_Claves.php";
									   }else{
									      if ($p == 12){
										     $pag = "frecuencias/main_informe_rendimiento.php";
										  }else{
										     if ($p == 13){
											    $pag = "ramo/taller.php3";
											 }else{	
												 if ($p == 14){
											        $pag = "inasistencia/reporte_inasistencia.php";
										         }else{
												 	if ($p == 15){
														$pag = "atrasos/atrasos.php?menu=$menu&categoria=$categoria&item=$item&nw=$nw";	
													}else{
														if ($p == 16){
															$pag = "asistencia/justifica_inasistencia.php";	
														}else{	
															if ($p == 17){
																$pag = "inasistencia/inasistencia_docente.php";
															}else{	
															    if ($p == 18){
																     $pag = "asistencia/asistencia_apo.php?tpv=$tpv";
																}else{
																     if ($p == 19){
																         $pag = "../../../configuracion/bloq_notas.php?curso=$curso";
																     }else
																	  if ($p == 21){
																         $pag = "asistencia/Asistencia_Sige/asistencia_sige.php";
																     }else{	
														        		         $pag="ramo/listarRamos.php3";
																	 }	 
															    }
															}
														}
													}
												 }   
											 }	
										  }	  
						               }
									}
								 }
							  }
						  }	  
	                   }
					}
				 }
			  }
		   }
		}
	};
	
	
	
	
	
	
	if($from!=1){
		
		//if($_perfil!=0){
		
	echo "<script>window.location = '".$pag."' </script>";
		//}
	}else{
	echo "<script>parent.location.href = '../../../../admin/institucion/ano/curso/curso.php3' </script>";	
	
	}
?>