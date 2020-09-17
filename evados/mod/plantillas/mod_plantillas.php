<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../../class/Coneccion.class.php";

class Plantillas {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	 
	 
	 
	 public function insertar_itembloque( $id_plantilla,$id_area,$id_subarea,$id_item,$id_bloque){
	  
	  $sql = "INSERT INTO evados.eva_item_bloque( id_plantilla,id_area,id_subarea,id_item,id_bloque) 
VALUES ( $id_plantilla,$id_area,$id_subarea,$id_item,$id_bloque);";
           	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 0" );
	    	 
		if($regis){
			return true;
		}else{
			return false;
		}
	 
	 }
	 
	 
	 
	 public function eliminar_itembloque( $id_plantilla,$id_area,$id_subarea,$id_item,$id_bloque){
	  
	   $sql = "DELETE FROM evados.eva_item_bloque WHERE id_plantilla = $id_plantilla AND id_area = $id_area AND
	  id_subarea = $id_subarea AND id_item = $id_item AND id_bloque = $id_bloque;";
	  
      $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Delete 00" );
	    	 
		if($regis){
			return true;
		}else{
			return false;
		}
	 
	 }
	 
	 
	 
	 
	public function insertar_plantilla($id_bloque,$nombre_plantilla,$id_nacional){
    
	$nombre_plantilla = utf8_decode($nombre_plantilla);
	
    $sql = "INSERT INTO evados.eva_plantilla(id_nacional,id_bloque,nombre) 
	VALUES($id_nacional,$id_bloque,'$nombre_plantilla');";	 
    	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 1" );
                                            
		if($regis){
			return true;
		}else{
			return false;
		}
	                                              		
	}


   public function actualizar_plantilla($id_plantilla,$id_bloque,$nombre_plantilla){
   
   $nombre_plantilla = utf8_decode($nombre_plantilla);
   
   $sql = "UPDATE evados.eva_plantilla SET id_bloque = $id_bloque,
		   nombre = '$nombre_plantilla' WHERE id_plantilla = $id_plantilla;";
 
    	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Update 1" );
        
		if($regis){
			return true;
		}else{
			return false;
		}
			
	}

    public function eliminar_plantilla($id_plantilla){
		
        $sql = "DELETE FROM evados.eva_plantilla WHERE id_plantilla = $id_plantilla;";
        $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Delete 1" );
        
		if($regis){
			return true;
		}else{
			return false;
		}
		
	}

    
	public function insertar_area($nombre_area,$id_nacional){
    
	$nombre_area = utf8_decode($nombre_area);
	
    $sql = "INSERT INTO evados.eva_plantilla_area (nombre,id_nacional)VALUES('$nombre_area',$id_nacional);";	 
    	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
        
		if($regis){
			return true;
		}else{
			return false;
		}
			
	}


   public function actualizar_area($id_nacional,$nombre_area,$id_area){
        
		$nombre_area = utf8_decode($nombre_area);
		
        $sql = "UPDATE evados.eva_plantilla_area SET nombre = '$nombre_area',id_nacional = $id_nacional WHERE id_area = $id_area;";
        $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Update 2" );
        
		if($regis){
			return true;
		}else{
			return false;
		}
			
	}

    public function eliminar_area($id_area){
		 
        $sql = "DELETE FROM evados.eva_plantilla_area WHERE id_area = $id_area;";
        $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Delete 2" );
        
		if($regis){
			return true;
		}else{
			return false;
		}
		
	}
	
	
	public function insertar_subarea($id_nacional,$nombre_subarea){
    
	$nombre_subarea = utf8_decode($nombre_subarea);
	
   $sql = "INSERT INTO evados.eva_plantilla_subarea(id_nacional,nombre) 
VALUES ($id_nacional,'$nombre_subarea');";

    	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 22" );
        
		if($regis){
			return true;
		}else{
			return false;
		}
			
	}


   public function actualizar_subarea($id_nacional,$nombre_subarea,$id_subarea){
        
		$nombre_subarea = utf8_decode($nombre_subarea);
		
        $sql = "UPDATE evados.eva_plantilla_subarea  SET 
					  id_nacional = $id_nacional,nombre = '$nombre_subarea'
					WHERE  id_subarea = $id_subarea;";
        $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Update 22" );
        
		if($regis){
			return true;
		}else{
			return false;
		}
			
	}

    public function eliminar_subarea($id_subarea){
		 
      $sql = "DELETE FROM evados.eva_plantilla_subarea WHERE id_subarea = $id_subarea;";
        $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Delete 2233" );
        
		if($regis){
			return true;
		}else{
			return false;
		}
		
	}
	
	
	
	
	public function insertar_item($id_area,$id_plantilla,$id_subarea,$nombre_item,$id_nacional){
     
	$nombre_item = utf8_decode($nombre_item);
	
	$sql = "SELECT * FROM evados.eva_plantilla_item  where nombre='".$nombre_item."';";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error Select Insert Item" );
	
	if(pg_numrows($regis)>0){
   
		  $fila = pg_fetch_array($regis,0);
	      $id_item = $fila['id_item'];
		  
	}else{
	
		$sql = "INSERT INTO evados.eva_plantilla_item(id_nacional,nombre) 
            VALUES(".$id_nacional.",'".$nombre_item."');";	 
    	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 3" );
		
			$sql = " select last_value as id from evados.eva_plantilla_item_id_item_seq";
			$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select id" );
		    $fila = pg_fetch_array($regis,0);
	        $id_item = $fila['id'];
	
	}
    
        $sql = "INSERT INTO evados.eva_plantilla_nacional(id_plantilla,id_area,id_subarea,id_item) 
                     VALUES (".$id_plantilla.",".$id_area.",".$id_subarea.",".$id_item.");";
					 $regis = @pg_Exec( $this->Conec->conectar(),$sql ); //or die( "Error Insert".$sql );

			return true;
			
	} // TERMINADO


   public function actualizar_item($id_plantilla,$nombre_item,$id_area,$id_item,$id_subarea){
	    
		$nombre_item = utf8_decode($nombre_item);

		$sql = "UPDATE evados.eva_plantilla_item SET id_area = $id_area,id_subarea = $id_subarea,id_plantilla = $id_plantilla,nombre = '$nombre_item' WHERE id_item = $id_item ;";
		  
        $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Update 3" );
        
		if($regis){
			return true;
		}else{
			return false;
		}
			
	}

    public function eliminar_item($id_item){
		 
        $sql = "DELETE FROM evados.eva_plantilla_item WHERE id_item=$id_item; ";
        $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Delete 3" );
        
		if($regis){
			return true;
		}else{
			return false;
		}
		
	}
	
	
	public function cargabloques($_ano){
			
	$sql = "SELECT id_bloque,nombre,porcentaje FROM evados.eva_bloque order by 1 desc ;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 1" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			 
	 } 
   
   
   
   public function cargacargos(){
				
	$sql = "SELECT * FROM cargos ORDER BY nombre_cargo ASC;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
	
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
				 
	 } 
	 
   
    	public function relacion_bloques_item($id_item){
			
			 $sql = "SELECT e.id_bloque,e.nombre as nombrebloque
			FROM evados.eva_bloque e ORDER BY 2 ASC";
			
			$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 4" );
					if($regis){
						   return $regis;
					}else{
						  return false;
					}
			 
	 } 
	 
	 
	 /*******************filtro item_bloque*********************************/
	public function filtro_bloques_item($id_item,$id_bloque,$id_plantilla,$id_area,$id_sub_area){
			
		  $sql = "SELECT *
			FROM evados.eva_item_bloque
			where id_item=$id_item and id_bloque=$id_bloque and id_plantilla=$id_plantilla and id_area=$id_area and id_subarea=$id_sub_area";
			
			$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select filtro" );
					if($regis){
						   return $regis;
					}else{
						  return false;
					}
			 
	 } 


	public function cargaplantillas($id_bloque,$id_nacional){
			
$sql = "SELECT evpl.id_plantilla,evpl.nombre FROM evados.eva_plantilla evpl 
WHERE evpl.id_bloque = ".$id_bloque." and evpl.id_nacional = ".$id_nacional."";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 22" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			 
	 } 
  
    
    
	public function carga_areas($id_nacional){
			
	$sql = "select evpa.id_area,evpa.nombre from evados.eva_plantilla_area as evpa where evpa.id_nacional = ".$id_nacional." ";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 3" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			 
	     } 

   public function carga_subareas($id_nacional){
	   
	  $sql="SELECT id_subarea,nombre FROM evados.eva_plantilla_subarea  Where id_nacional = $id_nacional;"; 
	   $regis = pg_Exec($this->Conec->conectar(),$sql) or die("Error db Select 44");
	   if($regis){
		    return $regis;
		   }else{
			   return false;			   
			   }
	       }
	
	public function carga_items($id_nacional,$id_plantilla,$id_area,$id_subarea){
	
	if($id_plantilla!=0) $where_plantilla = " WHERE epn.id_plantilla = ".$id_plantilla."; ";		
	
	if($id_area!=0)  $where_area  = "AND epn.id_area = ".$id_area."";
	
	if($id_subarea!=0)	 $where_subarea  = "AND epn.id_subarea = ".$id_subarea."";	
  
    $sql = "SELECT epn.id_plantilla,epn.id_area,epn.id_subarea,epi.id_item,epi.nombre
FROM evados.eva_plantilla_item epi
INNER JOIN evados.eva_plantilla_nacional epn ON epn.id_item = epi.id_item  $where_area  $where_subarea 
$where_plantilla ";
    
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 4" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			 
	     }
	 
	
	public function buscar_plantilla($id_plantilla){
			
	$sql = "select evpa.id_plantilla,evpa.nombre from evados.eva_plantilla evpa where evpa.id_plantilla = ".$id_plantilla."";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 4" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			 
	     }
	
	
	public function buscar_area($id_area){
			
	$sql = "select evpa.id_area,evpa.nombre from evados.eva_plantilla_area as evpa where evpa.id_area = ".$id_area."";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 4" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			 
	     }

	public function buscar_subarea($id_subarea){
		 $sql="SELECT id_subarea,nombre FROM evados.eva_plantilla_subarea Where id_subarea = $id_subarea;"; 
		 $regis = pg_Exec($this->Conec->conectar(),$sql) or die("Error db Select 444");
		 if($regis){
		   return $regis;
		 }else{
		   return false;			   
		   }
	    }
	
	
	
	    public function buscar_items($id_item){
			
	$sql = "select evpi.nombre,evpi.id_item from evados.eva_plantilla_item evpi where evpi.id_item = ".$id_item."";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 4" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			 
	     }
		 

	
	public function insertarbloque($nombre,$porcentaje){ 
		
	$sql = "INSERT INTO evados.eva_bloque ( nombre,porcentaje ) VALUES ( '$nombre',$porcentaje );";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 1" );
			if($regis){
				   return true;
			}else{
				  return false;
			}
	}
	
  
	public function eliminarbloques($id_bloque){
			
	$sql = "DELETE FROM evados.eva_bloque WHERE id_bloque = $id_bloque ;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Delete 1" );
		if($regis){
		   return true;
		}else{
 		   return false;
		}
   } 


	public function modificarbloques($id_bloque,$nombre_bloque,$porcentaje_bloque){
			
   $sql = "UPDATE  evados.eva_bloque SET nombre = '".trim($nombre_bloque)."' ,porcentaje = $porcentaje_bloque  WHERE  id_bloque =   $id_bloque ;";

	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Update 1" );
	
		if($regis){
			   return true;
		}else{
			  return false;
				}
	} 
		
		
	
	public function buscarbloque($id_bloque){
			
	$sql = "SELECT  id_bloque,nombre,porcentaje FROM evados.eva_bloque  WHERE id_bloque= $id_bloque;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Select 2" );
	
		if($regis){
			   return $regis;
		}else{
			  return false;
				}
	} 
		
    
	public function vistaprevia($id_plantilla){
	
		 $sql = "SELECT * FROM evados.eva_plantilla evpa WHERE evpa.id_plantilla = $id_plantilla;";
		$regis0 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 1" );
		
		  if($regis0){
			$fila = pg_fetch_array($regis0,0);
			$nombre_plantilla = $fila['nombre'];
			$id_plantilla = $fila['id_plantilla'];
			
		  }else{
		   echo "No Encontrado";
		  }
		
		$table = "<table border=1 style='border-collapse:collapse'  id='vistaprevia' width='100%' >
		<tr><th colspan='4' >".$nombre_plantilla."</th></tr>";
		
		$sql = "SELECT distinct epe.id_area,epn.id_plantilla,epe.nombre 
FROM evados.eva_plantilla_area  epe
INNER JOIN evados.eva_plantilla_nacional epn ON epe.id_area=epn.id_area
WHERE epn.id_plantilla = ".$id_plantilla.";";
		$regis1 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		
		  if($regis1){
			 
			  for($e=0;$e<pg_numrows($regis1);$e++){
			  
				$fila = pg_fetch_array($regis1,$e);
				$nombre_area = $fila['nombre'];
				$id_area = $fila['id_area'];
				$id_plantilla = $fila['id_plantilla'];
				
				$table .= "<tr><td colspan='1' width='3%' >&nbsp;>&nbsp;</td><td><strong>".$nombre_area."</strong></td></tr>";
			  
				 $sql = "SELECT distinct epn.id_plantilla,epn.id_area,eps.id_subarea,eps.nombre 
FROM evados.eva_plantilla_subarea as eps
INNER JOIN evados.eva_plantilla_nacional epn ON epn.id_area = ".$id_area." AND eps.id_subarea=epn.id_subarea
WHERE epn.id_plantilla = ".$id_plantilla.";";
				 
				 $regis2 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 3" );
		
				  if($regis2){
					
				  for($t=0;$t<pg_numrows($regis2);$t++){
					  
				  $fila = pg_fetch_array($regis2,$t);
				  $nombre_subarea = $fila['nombre'];
				  $id_subarea = $fila['id_subarea'];
				  
				  $table .= "<tr><td>&nbsp;&nbsp;</td><td><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>&nbsp;".$nombre_subarea.
				  "&nbsp;&nbsp;&nbsp;</strong></td></tr>";
				  
					$sql = "SELECT epn.id_plantilla,epn.id_area,epn.id_subarea,epi.id_item,epi.nombre
FROM evados.eva_plantilla_item epi
INNER JOIN evados.eva_plantilla_nacional epn ON  epn.id_area =".$id_area."  and epn.id_subarea = ".$id_subarea."  and epn.id_item = epi.id_item WHERE epn.id_plantilla = ".$id_plantilla.";";
	
	                 $regis3 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 4" );
				   
				     for($q=0;$q<pg_numrows($regis3);$q++){ 
					 
					     $fila = pg_fetch_array($regis3,$q);
				         $nombre_item = $fila['nombre'];
						 
						  $table .= "<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>&nbsp;".$nombre_item."&nbsp;&nbsp;&nbsp;</td></tr>";
					 
					 } // for 3
					   
				  } // for 2
				  
				  }else{
				  
				  echo "No Encontrado";
				  
				  } 
			  
			 } // for 1 
			 
		  }else{
		   echo "No Encontrado";
		  }
		
		echo $table .= "</table>";
        
		//return $table;
	
	 } // fun metodo vista previa

			 
    } // FIN FUNCION


?>