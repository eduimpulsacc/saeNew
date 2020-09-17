<? 
if(($_PERFIL==15 || $_PERFIL==16) )
{
	include('menu_lateral_perfi_new.php');
}
elseif(( $_PERFIL==26 || $_INSTIT==9506 || $_PERFIL==44 || $_PERFIL==47)  ){
 include('menu_lateral_perfil.php');
}else{
 include('menu_sae.php');
}	 
?>
  