<?php 
	require('../../../../../util/header.inc');
	$pag="taller.php3";
	
	
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		$institucion	=$_INSTIT;
		if($nw==1){
			
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
			$_ITEM =$item;
			session_register('_ITEM');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
	
	if($caso==1){//MOSTRAR RAMO
		$_TALLER	=	$taller;
		if(!session_is_registered('_TALLER')){
			session_register('_TALLER');
		};
		if(!session_is_registered('_RAMO')){
			session_register('_RAMO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR RAMO
		if(session_is_registered('_RAMO')){
			session_unregister('_RAMO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$_TALLER	=	$taller;
		if(!session_is_registered('_TALLER')){
			session_register('_TALLER');
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

	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoTaller.php3";
	};
	if($from!=1){
		echo "<script>window.location = '".$pag."' </script>";
	}else{
		echo "<script>parent.location.href = '../../../../../fichas/docente/index3.html' </script>";	
	}

?>