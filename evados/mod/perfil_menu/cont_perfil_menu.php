
<?
session_start();
require('../perfil_menu/mod_perfil_menu.class.php');

$obj_Perfil = new Perfil($_IPDB,$_ID_BASE);


$funcion 	= $_POST['frmModo'];
$ano 		= $_ANO;
$rdb		= $_INSTIT;
$perfil		= $_POST['cmbPERFIL'];
$menu		= $_POST['menu'];
$categoria	= $_POST['categoria'];
$nacional 	= $_NACIONAL;


if($funcion=="mostrar"){ // Muestra listado de Personal a Evaluar 
	$rs_menu = $obj_Perfil->listadoPerfil();


$tabla ="<table width='100%' border='1' cellspacing='0' cellpadding='0' style='border-collapse:collapse'>";

	for($i=0;$i<@pg_numrows($rs_menu);$i++){
		$fila_menu = @pg_fetch_array($rs_menu,$i);
		$rs_existe_menu = $obj_Perfil->ExisteMenu($fila_menu['id_menu'],$_INSTIT,$perfil);
		if(@pg_numrows($rs_existe_menu)!=0){
			
			$check= "<a href='#' onclick='EliminaMenu(".$fila_menu['id_menu'].",".$_INSTIT.",".$perfil.")' ><img src='img/PNG-48/Delete.png' width='18' height='18' border='0' alt='Eliminar'/></a>";
		}else{
			$check = "<a href='#' onclick='AgregaMenu(".$fila_menu['id_menu'].",".$_INSTIT.",".$perfil.")' ><img src='img/PNG-48/Add.png' width='18' height='18' border='0' alt='Asignar'/></a>";

		}

 $tabla.="<tr>
    <td class='textosimple'>&nbsp;$fila_menu[nombre]</td>	
    <td>
		<table width='100%' border='1' cellspacing='0' cellpadding='0'>";
		
		  	

	$rs_categoria = $obj_Perfil->listadoCategoria($fila_menu['id_menu']);
	
	
	if(@pg_numrows($rs_categoria)!=0){
		for($j=0;$j<@pg_numrows($rs_categoria);$j++){
			$fila_cat = @pg_fetch_array($rs_categoria,$j);
			$rs_existe_cat=$obj_Perfil->ExisteCategoria($_INSTIT,$perfil,$fila_menu['id_menu'],$fila_cat['id_categoria']);
					
			if(@pg_numrows($rs_existe_cat)!=0){
			$check_cat= "<a href='#' onclick='EliminaCategoria(".$fila_cat['id_categoria'].",".$fila_menu['id_menu'].",".$_INSTIT.",".$perfil.")' ><img src='img/PNG-48/Delete.png' width='18' height='18' border='0' alt='Eliminar'/></a>";
			}else{
			$check_cat = "<a href='#' onclick='AgregaCategoria(".$fila_cat['id_categoria'].",".$fila_menu['id_menu'].",".$_INSTIT.",".$perfil.")' ><img src='img/PNG-48/Add.png' width='18' height='18' border='0' alt='Asignar'/></a>";
			}
	
	$tabla.="<tr>
				<td class='textosimple' width='70%'>&nbsp;$fila_cat[nombre]</td>
				<td width='30%'>&nbsp;$check_cat</td>
		  </tr>";
		
 		}// fin for 
	}else{ 
	 $tabla.="<tr>
		<td class='textosimple' width='70%'>&nbsp;</td>
		<td width='30%'>&nbsp;$check</td>
	  </tr>";
	  
	 }
	 $tabla.="</table></td></tr>";
	 
  } 
	$tabla.="</table>";
	echo $tabla;
	
	
	
 }
 
 if($funcion=="agregar"){
	$rs_menu = $obj_Perfil->AgregaMenu($menu,$rdb,$perfil,$nacional); 
	
	if($rs_menu == true){
		echo 1;	
	}else{
		 echo $sql;
	}
 }
 
 if($funcion=="eliminar"){
 	$rs_menu = $obj_Perfil->EliminaMenu($menu,$rdb,$perfil,$nacional);
	if($rs_menu == true){
		echo 1;	
	}else{
		 echo 0;
	}
 }
  if($funcion=="agregar_cat"){
	$rs_menu = $obj_Perfil->AgregaCategoria($categoria,$menu,$rdb,$perfil,$nacional); 
	
	if($rs_menu == true){
		echo 1;	
	}else{
		 echo $sql;
	}
 }
 
 if($funcion=="eliminar_cat"){
 	$rs_menu = $obj_Perfil->EliminaCategoria($categoria,$menu,$rdb,$perfil,$nacional);
	if($rs_menu == true){
		echo 1;	
	}else{
		 echo 0;
	}
 }  
?>
	
