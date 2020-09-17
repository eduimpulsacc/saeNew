<?	header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
//print_r($_POST);


require "mod_crea_prfil_menu.php";



$institucion=$_INSTIT;
$objMembrete= new Membrete($_IPDB,$_DBNAME);
$obj_Perfil_vs_Menu = new Crea_Perfil_Menu($_IPDB,$_DBNAME);
//$funcion = $_POST['funcion'];

	if($caso==2){
		$sql = "DELETE FROM cede.perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$cmbPERFIL;
		$rs_delete = @pg_Exec($obj_Perfil_vs_Menu->Conec->conectar(),$sql);
		
	}
	
	for($i=0;$i<$contador_menu;$i++){
		$contador_cat = ${"contador_categoria".$i};
		$menu = ${"ck_menu".$i};
		if(isset($menu)){
			
			$sql ="SELECT * FROM cede.perfil_menu WHERE id_perfil=".$cmbPERFIL." AND rdb=".$institucion." AND id_menu=".$menu;
			$result = @pg_Exec($obj_Perfil_vs_Menu->Conec->conectar(),$sql);
			
			if(@pg_numrows($result)==0){
				if(trim($contador_cat)>0){
					for($j=0;$j<$contador_cat;$j++){
						$contador_item	= $_POST['contador_item'][$i][$j];
						$categoria 		= $_POST['ck_categoria'][$i][$j];
						$ingreso 		= $_POST['ck_ingreso'][$i][$j]; 	if($ingreso=="")	$ingreso=0;						
						$modifica 		= $_POST['ck_modifica'][$i][$j];	if($modifica=="")	$modifica=0;						
						$elimina		= $_POST['ck_elimina'][$i][$j];		if($elimina=="")	$elimina=0;						
						$ver 			= $_POST['ck_ver'][$i][$j];			if($ver=="")		$ver=0;						
						if(isset($contador_item)){
							for($x=0;$x<$contador_item;$x++){
								$item 		= $_POST['ck_item'][$i][$j][$x];
								$ingreso 	= $_POST['ck_ingreso'][$i][$j][$x];		if($ingreso=="")	$ingreso=0;		
								$modifica 	= $_POST['ck_modifica'][$i][$j][$x];	if($modifica=="")	$modifica=0;
								$elimina	= $_POST['ck_elimina'][$i][$j][$x];		if($elimina=="")	$elimina=0;	
								$ver 		= $_POST['ck_ver'][$i][$j][$x];			if($ver=="")		$ver=0;	
								if(isset($item)){
								 $sql = "INSERT INTO cede.perfil_menu (id_perfil,rdb,id_menu,id_categoria,id_item,bool_i,bool_m,bool_e,bool_v) VALUES (".$cmbPERFIL.",".$institucion.",".$menu.",".$categoria.",".$item.",".$ingreso.",".$modifica.",".$elimina.",".$ver.")";
									$rs_menu = @pg_Exec($obj_Perfil_vs_Menu->Conec->conectar(),$sql)or die("Fallo Insert 1".$sql);
								}
							}
						}else{
							if(isset($categoria)){
								$sql = "INSERT INTO cede.perfil_menu (id_perfil,rdb,id_menu,id_categoria,id_item,bool_i,bool_m,bool_e,bool_v) VALUES (".$cmbPERFIL.",".$institucion.",".$menu.",".$categoria.",0,".$ingreso.",".$modifica.",".$elimina.",".$ver.")";
								$rs_menu = @pg_Exec($obj_Perfil_vs_Menu->Conec->conectar(),$sql)or die("Fallo Insert 2".$sql);
							}
						}
					}
				}else{
						$ingreso 		= $_POST['ck_ingreso'][$i]; 	if($ingreso=="")	$ingreso=0;						
						$modifica 		= $_POST['ck_modifica'][$i];	if($modifica=="")	$modifica=0;						
						$elimina		= $_POST['ck_elimina'][$i];		if($elimina=="")	$elimina=0;						
						$ver 			= $_POST['ck_ver'][$i];			if($ver=="")		$ver=0;		
					$sql = "INSERT INTO cede.perfil_menu (id_perfil,rdb,id_menu,id_categoria,id_item,bool_i,bool_m,bool_e,bool_v) VALUES (".$cmbPERFIL.",".$institucion.",".$menu.",0,0,".$ingreso.",".$modifica.",".$elimina.",".$ver.")";
					$rs_menu = @pg_Exec($obj_Perfil_vs_Menu->Conec->conectar(),$sql)or die("Fallo Insert 3".$sql);
				}
			}
		}
	}

if($rs_menu){
echo "<script type=\"text/javascript\">alert(\"Datos Guardados\");</script>";
}

?>