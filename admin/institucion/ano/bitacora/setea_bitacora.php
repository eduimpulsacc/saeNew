<?php 
	require('../../../../util/header.inc');
	
	if($caso==1){//MOSTRAR TITULOS
		
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	
	if($caso==2){//INGRESAR TITULO
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==3){// LISTAR EVENTOS
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		
		$_TITULO = $nomb_titulo;
		if(!session_is_registered('_TITULO')){
			session_register('_TITULO');
		};
		$_ID = $id_titulo;
		if(!session_is_registered('_ID')){
			session_register('_ID');
		};
	};
	
	if($caso==4){//AGREGAR EVENTO
		$_FRMMODO	=	"AG_EVENTO";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	
	if($caso==5){//MODIFICAR EVENTO
		$_FRMMODO	=	"MOD_EVENTO";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$_FECHA_EVENTO	= $fecha;
		if(!session_is_registered('_FECHA_EVENTO')){
			session_register('_FECHA_EVENTO');
		};
		$_EVENTO	= $evento;
		if(!session_is_registered('_EVENTO')){
			session_register('_EVENTO');
		};
	};

	//pg_close($conn);
	echo "<script>window.location = 'bitacora.php' </script>";
?>