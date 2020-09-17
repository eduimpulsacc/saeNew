<?php 
	require('../../../util/header.inc');
		
	$pag="sms.php";
	
	if ($mdinamico == 0){
	   $_MDINAMICO = 0;
	}else{
	   $_MDINAMICO = 1;
	}      

	if($caso==1){//MOSTRAR INSTITUCION
		if ($institucion!=""){//SI VIENE DEL LISTADO DE INSTITUCIONES
			$_INSTIT	=	$institucion;
			if(!session_is_registered('_FRMMODO')){
				session_register('_FRMMODO');
			};
		}

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		
		
		
	};
	if($caso==2){//INGRESAR INSTITUCION
		if(session_is_registered('_FRMMODO')){
			session_unregister('_FRMMODO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR INSTITUCION
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==4){//MOSTRAR INSTITUCION VOLVIENDO DE AÑO O EMPLEADO
		session_unregister('_ANO');				//LIBERA EL AÑO
		session_unregister('_EMPLEADO');		//LIBERA EL EMPLEADO
		session_unregister('_NOTA_AGENDA');		//LIBERA LA NOTA DE LA AGENDA
		session_unregister('_NOTICIA');			//LIBERA LA NOTICIA
		session_unregister('_ESTILO');			//LIBERA LA NOTICIA
		session_unregister('_EDUGESTOR');			//LIBERA edugestor

		$_FRMMODO	=	"mostrar";
		$_ESTILO  	= 	"estilo.css";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	
	if($caso==5){//MOSTRAR INSTITUCION
		if ($institucion!=""){//SI VIENE DEL LISTADO DE INSTITUCIONES
			$_INSTIT	=	$institucion;
			if(!session_is_registered('_INSTIT')){
				session_register('_INSTIT');
			};
		}

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$_MENU =$menu;
		session_register('_MENU');
		$_CATEGORIA = $categoria;
		session_register('_CATEGORIA');
		
	};

	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoSMS.php";
	};
	echo "<script>window.location = '".$pag."'</script>";
?>