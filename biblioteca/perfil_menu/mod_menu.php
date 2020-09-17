<?
class Menu{
	public function construct(){
		
	}
	
	public function ListadoMenu($conn,$perfil,$rdb){
		$sql="SELECT m.nombre as nombre_menu, c.id_menu, c.id_categoria, c.nombre as nombre_categoria, pm.rdb
				FROM biblio.menu m 
				INNER JOIN biblio.menu_categoria c ON m.id_menu=c.id_menu
				LEFT JOIN biblio.perfil_menu pm ON pm.id_categoria=c.id_categoria AND 
				 rdb=".$rdb." AND pm.id_perfil=".$perfil."
				ORDER BY m.orden ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;
	
	}
	
	public function AgregarMenu($conn,$perfil,$rdb,$categoria,$menu){
		$sql="INSERT INTO biblio.perfil_menu (id_perfil,rdb,id_menu,id_categoria) VALUES(".$perfil.",".$rdb.",".$menu.",".$categoria.")";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function EliminaMenu($conn,$perfil,$rdb,$categoria,$menu){
		$sql="DELETE FROM biblio.perfil_menu WHERE rdb=".$rdb." AND id_perfil=".$perfil." AND id_menu=".$menu." AND id_categoria=".$categoria;
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
	}
}
?>
