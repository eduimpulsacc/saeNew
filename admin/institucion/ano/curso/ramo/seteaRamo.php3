<?php 

    require('../../../../../util/header.inc');
	 $pag="ramo.php3";


	
	if ($caso != 3){
	
	   $_SUBSECTOR	=  $cod_subsector;
	   if(!session_is_registered('_SUBSECTOR')){
	      session_register('_SUBSECTOR');
	   };
    }	
		
	if($caso==1){//MOSTRAR RAMO
		$_RAMO	=	$ramo;
	
		if(!session_is_registered('_RAMO')){
			session_register('_RAMO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		
		
		if ($swb!=1){		
		   // nueva modificacion
		   $pag="listarRamos.php3";
		   echo "<script>window.location = '".$pag."' </script>";
		   exit();
		}   
	};
	if($caso==2){//INGRESAR RAMO
		if(session_is_registered('_RAMO')){
			session_unregister('_RAMO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	
	};
	if($caso==3){//MODIFICAR RAMO
	    $_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==4){//MOSTRAR RAMO
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==5){
		if(session_is_registered('_RAMO')){
			session_unregister('_RAMO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		echo "<script>parent.location.href = '../../../../../admin/institucion/ano/curso/ramo/procesaExamen.php' </script>";
	}

	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoRamo.php3";
	};
	if($from!=1){
	    echo "<script>window.location = '".$pag."' </script>";
	}else{
	    
		echo "<script>parent.location.href = '../../../../../admin/institucion/ano/curso/ramo/ramo.php3' </script>";	
	}
?>