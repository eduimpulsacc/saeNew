<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../../Class/Membrete.php";

//require "../../Class/Coneccion.php";
class CreaMenu {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	 
	 public function cargaMenu(){
		$sql ="SELECT id_menu,nombre,orden FROM cede.menu ORDER BY orden ASC";
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error Select tabla" );
		if ($regis){
				return $regis;
			}else{
				 return false;
		}
	}
	
	public function Busca_menu($id_menu){
		 $sql ="SELECT * FROM cede.menu where id_menu=".$id_menu;
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error Select tabla" );
		if ($regis){
				return $regis;
			}else{
				 return false;
		}
	}
	
	
	 
	 
	 public function guarda_menu ($nombre_menu,$url,$nivel,$orden_menu,$ck_ingreso,$ck_modifica,$ck_elimina,$ck_ver){
 $sql="INSERT INTO cede.menu (nombre,url,nivel,orden,bool_i,bool_m,bool_e,bool_v)  VALUES ('".$nombre_menu."','".$url."','".$nivel."',".$orden_menu.",".$ck_ingreso.",".$ck_modifica.",".$ck_elimina.",".$ck_ver.");"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	 public function modifica_menu($nombre_menu,$url,$nivel,$orden_menu,$ck_ingreso,$ck_modifica,$ck_elimina,$ck_ver,$id_menu){
		   $sql="update cede.menu set nombre='$nombre_menu', url='$url',nivel=$nivel,
		 orden=$orden_menu, bool_i = $ck_ingreso, bool_m=$ck_modifica, bool_e=$ck_elimina, bool_v=$ck_ver  
		 where id_menu=".$id_menu; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	
	public function eliminad_menu($id_menu){
		 $sql="delete from cede.menu where id_menu=$id_menu;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	
	public function carga_menu(){
		 $sql="select * from cede.menu order by 1 ;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function guarda_menu_categoria ($id_Menu,$categoria,$nivel,$url_cat,$orden_cat,$ck_ingresoC,$ck_modificaC,$ck_eliminaC,$ck_verC){
		
  $sql="INSERT INTO cede.menu_categoria (id_menu,nombre_categoria,url,nivel,orden_categoria,bool_i,bool_m, bool_e,bool_v)  
        VALUES  
		('".$id_Menu."','".$categoria."','".$url_cat."','".$nivel."',".$orden_cat.",".$ck_ingresoC.",".$ck_modificaC.",".$ck_eliminaC.",".$ck_verC.");"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2".$sql );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	
	public function cargaMenu_categoria(){
		$sql="select * from cede.menu cm 
		inner join cede.menu_categoria cmc on cm.id_menu=cmc.id_menu
		order by cmc.id_categoria ;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2".$sql );
		if ($regis){
				return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function Busca_menu_categoria($id_categoria){
		 $sql ="select * from cede.menu_categoria cm 
inner join cede.menu cmc on cm.id_menu=cmc.id_menu
 where id_categoria=$id_categoria order by cm.id_categoria";
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error Select tabla".$sql );
		if ($regis){
				return $regis;
			}else{
				 return false;
		}
	}
		 
		 
	 public function modifica_menu_categoria($id_Menu,$categoria,$nivel,$url_cat,$orden_cat,$ck_ingresoC,$ck_modificaC,$ck_eliminaC,$ck_verC,$i_id_categoria){
		   $sql="update cede.menu_categoria set id_menu='$id_Menu', nombre_categoria='$categoria',nivel=$nivel,
	 orden_categoria=$orden_cat,url='$url_cat', bool_i = $ck_ingresoC, bool_m=$ck_modificaC, bool_e=$ck_eliminaC, bool_v=$ck_verC  
		 where id_categoria=".$i_id_categoria; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Update 2" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	
	public function eliminad_menu_categoria($id_categoria){
		 $sql="delete from cede.menu_categoria where id_categoria=$id_categoria;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	
	public function carga_menu_categoria($id_menu){
		$sql="select * from cede.menu_categoria where id_menu =$id_menu order by 1 ;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return $regis;
			}else{
				 return false;
		}
	}
	
	
public function guarda_menu_item($id_Menu,$categoria,$nombre_item,$nivel,$url_item,$orden_Item,$ck_ingresoI,$ck_modificaI,$ck_eliminaI,$ck_verI){
		
  $sql="INSERT INTO cede.menu_categ_item (id_menu,id_categoria,nombre_item,url,nivel,orden_item,bool_i,bool_m, bool_e,bool_v)  
        VALUES  
		('".$id_Menu."','".$categoria."','".$nombre_item."','".$url_item."','".$nivel."',".$orden_Item.",".$ck_ingresoI.",".$ck_modificaI.",".$ck_eliminaI.",".$ck_verI.");"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 3".$sql );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	
	public function Busca_menu_item($id_item){
		 $sql ="select * from cede.menu_categ_item mi 
inner join cede.menu cm on mi.id_menu=cm.id_menu 
inner join cede.menu_categoria mc on mi.id_categoria=mc.id_categoria
where id_item=$id_item order by mi.id_item";
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error Select tabla".$sql );
		if ($regis){
				return $regis;
			}else{
				 return false;
		}
	}
	
	
	 public function eliminad_menu_item($id_item){
		 $sql="delete from cede.menu_categ_item where id_item=$id_item;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error Delete Item" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	 
}
	 ?>