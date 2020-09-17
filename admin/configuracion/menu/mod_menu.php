<?php 

class Menu{
	public function contruct(){
		
	}
	
	
	public function cargamenu($conn){
	 $sql="SELECT * FROM menu_alu_apo";
	$result = pg_exec($conn,$sql);
	return $result;
	}
	
	public function tengoPerfil($conn,$rdb,$perfil,$menu){
		 $sql="select * from perfil_menu_alu_apo where rdb=$rdb and id_perfil=$perfil and id_menu=$menu";
		$result = pg_exec($conn,$sql);
	return $result;
	}
	
	public function quitaPerfil($conn,$rdb,$perfil,$menu){
		  $sql="delete from perfil_menu_alu_apo where rdb=$rdb and id_perfil=$perfil and id_menu=$menu";
		$result = pg_exec($conn,$sql);
	return $result;
	}
	
	public function ponPerfil($conn,$rdb,$perfil,$menu){
		  $sql="insert into perfil_menu_alu_apo values ($rdb,$perfil,$menu)";
		$result = pg_exec($conn,$sql);
	return $result;
	}
}//fin clase

?>