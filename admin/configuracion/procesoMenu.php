<?	require('../../util/header.inc');

$institucion	=$_INSTIT;


if($tipo==1){
	$sql = "INSERT INTO menu (nombre,url,nivel,orden,bool_i,bool_m,bool_e,bool_v)  VALUES ('".$txtMENU."','".$txtURLMENU."','".$cmbNIVEL."',".$txtORDENMENU.",".$ck_ingreso.",".$ck_modifica.",".$ck_elimina.",".$ck_ver.")";
	$rs_menu = @pg_exec($conn,$sql) or die ("INSERT FALLO (MENU):".$sql);
	
}elseif($tipo==2){
	$sql = "INSERT INTO menu_categoria (id_menu,nombre,url,nivel,orden,bool_i,bool_m,bool_e,bool_v) VALUES (".$cmbMENU.",'".$txtCATEGORIA."','".$txtURLCATEGORIA."','".$cmbNIVELC."',".$txtORDENCATEGORIA.",".$ck_ingresoC.",".$ck_modificaC.",".$ck_eliminaC.",".$ck_verC.")";
	$rs_categoria = @pg_exec($conn,$sql) or die ("INSERT FALLO :".$sql);
	
}elseif($tipo==3){
	$sql = "INSERT INTO menu_categ_item (id_menu,id_categoria,nombre,url,nivel,orden,bool_i,bool_m,bool_e,bool_v) VALUES (".$cmbMENU.",".$cmbCATEGORIA.",'".$txtITEM."','".$txtURLITEM."','".$cmbNIVEL."','".$txtORDENITEM."',".$ck_ingresoI.",".$ck_modificaI.",".$ck_eliminaI.",".$ck_verI.")";
	$rs_item = @pg_exec($conn,$sql)  or die ("INSERT FALLO :".$sql);
	
}elseif($tipo==4){
	$sql ="DELETE FROM menu WHERE id_menu=".$menu;
	$rs_menu =@pg_exec($conn,$sql) or die("DELETE FALLO :".$sql);
	
}elseif($tipo==5){
	$sql ="DELETE FROM menu_categoria WHERE id_categoria=".$categoria;
	$rs_categoria =@pg_exec($conn,$sql) or die("DELETE FALLO :".$sql);
	
}elseif($tipo==6){
	$sql ="DELETE FROM menu_categ_item WHERE id_item=".$item;
	$rs_item =@pg_exec($conn,$sql) or die("DELETE FALLO :".$sql);
	
}elseif($tipo==7){
	if($ck_ingreso=="") 	$ck_ingreso=0;
	if($ck_modifica=="") 	$ck_modifica=0;
	if($ck_elimina=="") 	$ck_elimina=0;
	if($ck_ver=="") 		$ck_ver=0;
	$sql ="UPDATE menu SET nombre='".$txtMENU."', url='".$txtURLMENU."', nivel='".$cmbNIVEL."',orden=".$txtORDENMENU.",bool_i='".$ck_ingreso."', bool_m='".$ck_modifica."', bool_e='".$ck_elimina."', bool_v='".$ck_ver."' WHERE id_menu=".$menu;
	$rs_menu = @pg_exec($conn,$sql) or die ("UPDATE FALLO :".$sql);
	echo "<script>window.location='modificaMenu.php?cierra=1'</script>";	
	
}elseif($tipo==8){
	if($ck_ingresoC=="") 	$ck_ingresoC=0;
	if($ck_modificaC=="") 	$ck_modificaC=0;
	if($ck_eliminaC=="") 	$ck_eliminaC=0;
	if($ck_verC=="") 		$ck_verC=0;
	$sql ="UPDATE menu_categoria SET nombre='".$txtCATEGORIA."', url='".$txtURLCATEGORIA."', nivel='".$cmbNIVEL."',orden=".$txtORDENCATEGORIA.",bool_i='".$ck_ingresoC."', bool_m='".$ck_modificaC."', bool_e='".$ck_eliminaC."', bool_v='".$ck_verC."' WHERE id_menu=".$menu." AND id_categoria=".$categoria;
	$rs_categoria = @pg_exec($conn,$sql) or die ("UPDATE FALLO :".$sql);
	echo "<script>window.location='modificaMenu.php?cierra=1'</script>";	
	
}elseif($tipo==9){
	if($ck_ingresoI=="") 	$ck_ingresoI=0;
	if($ck_modificaI=="") 	$ck_modificaI=0;
	if($ck_eliminaI=="") 	$ck_eliminaI=0;
	if($ck_verI=="") 		$ck_verI=0;
	$sql ="UPDATE menu_categ_item SET nombre='".$txtITEM."', url='".$txtURLITEM."', nivel='".$cmbNIVEL."',orden=".$txtORDENITEM.",bool_i='".$ck_ingresoI."', bool_m='".$ck_modificaI."', bool_e='".$ck_eliminaI."', bool_v='".$ck_verI."' WHERE id_menu=".$menu." AND id_categoria=".$categoria." AND id_item=".$item;
	$rs_item = @pg_exec($conn,$sql) or die ("UPDATE FALLO :".$sql);
	echo "<script>window.location='modificaMenu.php?cierra=1'</script>";	
	
}

echo "<script>window.location='creaMenu.php'</script>";



 pg_close($conn);
 ?>
