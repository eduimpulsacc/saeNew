<?php 
	require('../../../util/header.inc');
	
	$pag="ano_escolar.php3";
	
	$mdis = $_GET['mdi'];
	
	if($caso==1){//MOSTRAR AÑO ESCOLAR
		$_ANO	=	$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};	
	};
	
	if($caso==2){//INGRESAR AÑO ESCOLAR
		if(session_is_registered('_ANO')){
			session_unregister('_ANO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR AÑO ESCOLAR
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==4){//MOSTRAR AÑO 
		session_unregister('_CURSO');			//LIBERA EL CURSO
		session_unregister('_MATRICULA');		//LIBERA EL MATRICULA
		session_unregister('_PERIODO');			//LIBERA EL PERIODO
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoAno.php3";
	};


	if($caso==50){//MOSTRAR CURSO
		$_ANO	=	$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
		};

		$_FRMMODO	=	$frmModo;
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		if ($pa == 1){
		   $pag = "curso/vitacora_alumno/vitacora_alumno.php?url=0";
		}
	
	};

    if($caso==10){//MOSTRAR AÑO ESCOLAR
		$_ANO	=	$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
		};

		$_FRMMODO	=	$frmModo;
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		
		if ($pa == 1){
		   $pag = "curso/alumno/listarAlumnos.php3";
		}
		if ($pa == 2){
		   $pag = "curso/ramo/listarRamos.php3";
		}
		if ($pa == 3){
		   $pag = "curso/ramo/listarTalleres.php3";
		}
		if ($pa == 4){
		   $pag = "curso/horario/listarHorario.php";
		}
		if ($pa == 5){
		   $pag = "curso/promocion/promocion_pro.php";
		}
		if ($pa == 6){
		   $pag = "curso/asistencia/asistencia.php3";
		}
		if ($pa == 7){
		   $pag = "curso/inasistencia/inasistencia.php";
		}
		if ($pa == 8){
		   $pag = "fichas/listarAlumnosMatriculados.php3";
		}
		if ($pa == 9){
		   $pag = "curso/Listado_Claves.php";
		}
		if ($pa == 10){
		   $pag = "curso/ramo/ramo.php3";
		}
		if ($pa == 11){
		   $pag = "curso/frecuencias/main_informe_rendimiento.php";
		}
		if ($pa == 12){
		   $pag = "curso/inasistencia/reporte_inasistencia.php";
		}
		if ($pa == 13){
		   $pag = "curso/atrasos/atrasos.php";
		}	
		if ($pa == 14){
		   $pag = "curso/asistencia/justifica_inasistencia.php";
		}
		if ($pa == 15){
		   $pag = "curso/inasistencia/inasistencia_docente.php";
		}
		if ($pa == 16){
		   $pag = "curso/asistencia/asistencia_apo.php?tpv=$tpv";
		}
		if ($pa == 17){
		   $pag = "reportes/Evaluaciones/NotasporCiclo.php?c_reporte=88";
		}
		if ($pa == 18){
		   $pag = "reportes/Evaluaciones/NotasFinalesporCiclo.php?c_reporte=89";
		}
		if ($pa == 19){
		   $pag = "reportes/Evaluaciones/NotasporNivel.php?c_reporte=90";
		}
		if ($pa == 20){
		   $pag = "reportes/Evaluaciones/NotasFinalesporNivel.php?c_reporte=91";
		}
		if ($pa == 21){
		   $pag = "reportes/Evaluaciones/NotasCursoporSubsector.php?c_reporte=92";
		}
		if ($pa == 22){
		   $pag = "reportes/Evaluaciones/NotasAlumnoporSubsector.php?c_reporte=93";
		}
		if ($pa == 23){
		   $pag = "reportes/Evaluaciones/NotasFinalesTipoEnsenanza.php?c_reporte=94";
		}		
		if ($pa == 24){
		   $pag = "reportes/Evaluaciones/LibroDeClasesElectronicoFinal.php?c_reporte=97";
		}
		if ($pa == 25){
		   $pag = "reportes/Evaluaciones/LibroDeClasesElectronicoporSubsector.php?c_reporte=96";
		}
		if ($pa == 26){
		   $pag = "reportes/Evaluaciones/CantidadAprobadosyReprobadosporNivel.php?c_reporte=98";
		}
		if ($pa == 27){
		   $pag = "reportes/Evaluaciones/CantidadAprobadosyReprobadosporCursos.php?c_reporte=99";
		}
		if ($pa == 28){
		   $pag = "reportes/Evaluaciones/CantidadAprobadosyReprobadosNivelporSubsector.php?c_reporte=100";
		}
		if ($pa == 29){
		   $pag = "reportes/Evaluaciones/CantidadAprobadosyReprobadosCursoporSubsector.php?c_reporte=101";
		}
		if ($pa == 30){
		   $pag = "reportes/Evaluaciones/CantidadAprobadosyReprobadosporCursos.php?c_reporte=99";
		}
		if ($pa == 31){
		   $pag = "../../corporacion/reportesCorporativos.php?pesta=8&bus=1";
		}
		if ($pa == 32){
		   $pag = "../../corporacion/reportesCorporativos.php?pesta=8&bus=2";
		}
		if ($pa == 33){
		   $pag = "../../corporacion/reportesCorporativos.php?pesta=8&bus=3";
		}
		if ($pa == 34){
		   $pag = "../../corporacion/reportesCorporativos.php?pesta=8&bus=4";
		}
		if ($pa == 35){
		   $pag = "../../corporacion/reportesCorporativos.php?pesta=8&bus=5";
		}
		if ($pa == 36){
		   $pag = "../../corporacion/reportesCorporativos.php?pesta=8&bus=6";
		}
		if ($pa == 37){
		   $pag = "reportes/motor_informe_becas_beneficio.php?";
		}
		if ($pa == 38){
		   $pag = "reportes/informe_simce.php?";
		}
		if ($pa == 39){
		   $pag = "Respaldo/MenuRespaldoPromocion.php?";
		}
		if ($pa == 40){
		   $pag = "anotacion_empleado/asistencia.php?";
		}
	};
	
	
	
	pg_close($conn);

	if($from!=1){
	   	echo "<script>window.location = '".$pag."' </script>";
	}else{
	switch ($_PERFIL){
	case 19:
	echo "<script>parent.location.href = '../../../admin/institucion/ano/ano_escolar.php3?mdi=$mdis' </script>";
	break;
	case 20:
	echo "<script>parent.location.href = '../../../admin/institucion/ano/ano_escolar.php3?mdi=$mdis' </script>";
	break;
	case 21:
	echo "<script>parent.location.href = '../../../admin/institucion/ano/ano_escolar.php3?mdi=$mdis' </script>";
	break;
	case 22:
	echo "<script>parent.location.href = '../../../fichas/psicopedagogo/index2.html' </script>";
	break;
	case 25:
	echo "<script>window.location = '".$pag."' </script>";
	break;	
	case 6:
	echo "<script>parent.location.href = 'ano_escolar.php3' </script>";
	break;
	case 2:
	echo "<script>parent.location.href = 
	'../../../admin/institucion/seteaInstitucion.php3?caso=1&mdinamico=1&menu=4&categoria=61' </script>";
	/*echo "<script>parent.location.href = '../../../fichas/utp/index2.html' </script>";*/
	break;
		}
		
	}?>