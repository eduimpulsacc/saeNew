<?

require "../../class/Coneccion.class.php";

class Perfil{
	   
	public $Conec;
	
	//constructor 
	public function Perfil($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 


	public function listadoPerfil(){  // Lista el memu 	
		  $sql="SELECT id_menu,nombre FROM evados.eva_menu ORDER BY id_menu ASC";
		  $result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			
		return $result;
	}
	
	
	public function ExisteMenu($menu,$rdb,$perfil){
		$sql = "SELECT estado FROM evados.eva_perfil_menu WHERE rdb=".$rdb." AND id_perfil=".$perfil." AND id_menu=".$menu;
	  	$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			
		return $result;

	}
	
	
	public function listadoCategoria($menu){
		$sql ="SELECT id_categoria, nombre FROM evados.eva_categoria WHERE id_menu=".$menu." ORDER BY nombre ASC";
	  	$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			
		return $result;

	}
	
	
	  
	  public function buscar_instituciones($nacional){
		
		 $sql = "SELECT pci.rdb  FROM public.nacional pn
						INNER JOIN public.nacional_corp pnc ON pnc.id_nacional = pn.id_nacional
						INNER JOIN public.corporacion pc ON pc.num_corp = pnc.num_corp  
						INNER JOIN public.corp_instit pci ON pci.num_corp = pc.num_corp AND pci.estado = true
						WHERE pn.id_nacional = $nacional
						ORDER BY 1 ";

		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		
		return $result;
		
		}
	
	
	
	public function ExisteCategoria($rdb,$perfil,$menu,$categoria){
		$sql ="SELECT estado FROM evados.eva_perfil_menu WHERE rdb=".$rdb." AND id_perfil=".$perfil." AND id_menu=".$menu." AND id_categoria=".$categoria." ORDER BY id_menu,id_categoria ";	
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			
		return $result;
	}
	
	
	
	public function AgregaMenu($menu,$rdb,$perfil,$nacional){
		
		$reg_rdb = $this->buscar_instituciones($nacional);
		
		for($r=0 ; $r<pg_num_rows($reg_rdb) ; $r++ ){
			     
		   $fila = @pg_fetch_array($reg_rdb,$r); 
				 
		   $sql_select = "SELECT * 
		   FROM evados.eva_perfil_menu 
		   WHERE id_menu=".$menu." AND id_categoria=0 
		   AND id_perfil=".$perfil." AND rdb=".$fila['rdb']." ;";
		   $result = pg_Exec($this->Conec->conectar(),$sql_select) or die ("fallo:".$sql_select);
		
			if(pg_num_rows($result)==0){
				  
				  	$sql= "INSERT INTO evados.eva_perfil_menu (id_menu,id_categoria,id_perfil,rdb) 
					VALUES(".$menu.",0,".$perfil.",".$fila['rdb'].")";
					$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
				 
			     }
				 
			}
		
		if($result){
			return true;
		}else{
			return $sql;
		}
		
	}
	
	
		public function EliminaMenu($menu,$rdb,$perfil,$nacional){
						
		$reg_rdb = $this->buscar_instituciones($nacional);
		
		for($r=0 ; $r<pg_num_rows($reg_rdb) ; $r++ ){
			     
		$fila = @pg_fetch_array($reg_rdb,$r); 
		
		$sql_select = "SELECT * FROM evados.eva_perfil_menu WHERE id_menu=".$menu." AND id_categoria=0 AND id_perfil=".$perfil." AND rdb=".$fila['rdb']." ;";
		$result = pg_Exec($this->Conec->conectar(),$sql_select) or die ("fallo:".$sql_select);
		
			if(pg_num_rows($result)==1){
						
				$sql ="DELETE FROM evados.eva_perfil_menu 
				WHERE rdb=".$fila['rdb']." AND id_perfil=".$perfil." 
				AND id_menu=".$menu." AND id_categoria=0";
				$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
				
			    }
			
		   }
				
			if($result){
					return true;
				}else{
					return $sql;
				}
			
		}
////////************** categgoria ++++++++++++++++++/////////////////

	public function AgregaCategoria($categoria,$menu,$rdb,$perfil,$nacional){
		
		
		$reg_rdb = $this->buscar_instituciones($nacional);
		
		for($r=0 ; $r<pg_num_rows($reg_rdb) ; $r++ ){
			     
		$fila = @pg_fetch_array($reg_rdb,$r); 
		
		$sql_select = "SELECT * FROM evados.eva_perfil_menu WHERE id_menu=".$menu." AND id_categoria=".$categoria." AND id_perfil=".$perfil." AND rdb=".$fila['rdb']." ;";
		$result = pg_Exec($this->Conec->conectar(),$sql_select) or die ("fallo:".$sql_select);
		
			if(pg_num_rows($result)==0){
			
				$sql= "INSERT INTO evados.eva_perfil_menu (id_menu,id_categoria,id_perfil,rdb) 
				VALUES(".$menu.",".$categoria.",".$perfil.",".$fila['rdb'].")";
				$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			
			}
		
		 }
		
		if($result){
			return true;
		}else{
			return $sql;
		}
	
	
	}
	
	
	public function EliminaCategoria($categoria,$menu,$rdb,$perfil,$nacional){
		
		$reg_rdb = $this->buscar_instituciones($nacional);
		
		for($r=0 ; $r<pg_num_rows($reg_rdb) ; $r++ ){
			     
		$fila = @pg_fetch_array($reg_rdb,$r); 
		
		$sql_select = "SELECT * FROM evados.eva_perfil_menu WHERE id_menu=".$menu." AND id_categoria=".$categoria." AND id_perfil=".$perfil." AND rdb=".$fila['rdb']." ;";
		$result = pg_Exec($this->Conec->conectar(),$sql_select) or die ("fallo:".$sql_select);
		
			if(pg_num_rows($result)==1){
		
		$sql ="DELETE FROM evados.eva_perfil_menu WHERE rdb=".$fila['rdb']." AND id_perfil=".$perfil." AND id_menu=".$menu." AND id_categoria=".$categoria."";
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		
		
			}
			
		}
		
		if($result){
			return true;
		}else{
			return $sql;
		}
	}


 }	

?>

