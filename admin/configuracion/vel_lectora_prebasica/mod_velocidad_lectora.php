<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
require('../../../util/header.inc');

class VelocidadLec {
	public $conect;       

//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	
	

	  public function carga_grado($id_ano){
		
	 $sql="select c.ensenanza,c.grado_curso,
			CASE WHEN c.ensenanza=10 and c.grado_curso=4 THEN 'Pre KINDER'
			WHEN c.ensenanza=10 and c.grado_curso=5 THEN 'KINDER'
			WHEN c.ensenanza=10 THEN '&deg; Pre Basico' 
			when c.ensenanza=110 then  c.grado_curso||''||'&deg; Basico'
			WHEN c.ensenanza>309 THEN c.grado_curso||''||'&deg; Medio' END as tipo_grado
			from curso c 
			where c.id_ano=".$id_ano." 
			group by c.ensenanza,c.grado_curso order by c.ensenanza,c.grado_curso ASC";
 
   $regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function guardad_vel_lec($id_ano,$grado_curso,$concepto,$rango_ini,$rango_fin,$ensenanza,$id_concepto){
		
	 $sql="insert into velocidad_lectora (id_ano, grado_curso, rango_inicial, rango_final, ensenanza,id_concepto)
		       VALUES
               ($id_ano,$grado_curso,$rango_ini,$rango_fin,$ensenanza,$id_concepto)"; 
		  $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);	
		if ($regis){
				return true;
			}else{
				 return false;
	 }
	}
	
	
	public function Carga_Vel_lec($id_ano){
		
		   $sql="select  DISTINCT (c.grado_curso),c.ensenanza,c.grado_curso||''||
			CASE WHEN c.ensenanza=10 THEN '&deg; Pre Basico' 
			when c.ensenanza=110 then '&deg; Basico'
			WHEN c.ensenanza>309 THEN '&deg; Media' END as tipo_grado
            from velocidad_lectora c where id_ano=".$id_ano." 	ORDER BY c.ensenanza,c.grado_curso ASC";
			
		 $regis = pg_Exec($this->conect,$sql) or die( "Error bd select 2".$sql);	
		 if ($regis){
				return $regis;
			}else{
		   return 0;
		   }
	}
	
	
	
	
	public function carga_concepto($rdb){
		
		 $sql="select * from concepto_velocidad_lectora where rdb=".$rdb;
			 $regis = pg_Exec($this->conect,$sql) or die( "Error bd select 2".$sql);	
		 if ($regis){
				return $regis;
			}else{
		return false;
		}
	}
	
	
	
	public function guarda_concepto($rdb,$nombre_funcion){
		 $sql="insert into concepto_velocidad_lectora (nombre_concepto,rdb)VALUES
         ('$nombre_funcion',$rdb)"; 
		 
		$regis = pg_Exec($this->conect,$sql) or die( "Error bd select Concepto".$sql);	
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	
	
	public function modifica_vel($notaini,$notafin,$idvel){
		
		 $sql="UPDATE velocidad_lectora 
			   SET    rango_inicial = ".$notaini.", rango_final = ".$notafin."
			   WHERE id_vel_lec=".$idvel; 
		 
		$regis = pg_Exec($this->conect,$sql) or die( "Error bd Update vel".$sql);	
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	public function guardaConCal($rdb,$nombre,$sigla){
		 $sql="insert into vlectorapb_concepto(rdb,nombre,sigla) values($rdb,'$nombre','$sigla')";
		$regis = pg_Exec($this->conect,$sql) or die( "Error bd Update vel".$sql);	
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	public function listaConCal($rdb){
		 $sql="select * from vlectorapb_concepto where rdb=$rdb order by id_concepto";
		 $regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function quitaConCal($concepto){
		 $sql="delete from vlectorapb_concepto where id_concepto=$concepto";
		 $regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function ConCalUno($concepto){
		 $sql="select * from vlectorapb_concepto where id_concepto=$concepto";
		 $regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function modCalUno($concepto,$nombre,$sigla){
		 $sql="update vlectorapb_concepto set nombre='$nombre',sigla='$sigla' where id_concepto=$concepto";
		 $regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function traeItem($rdb,$padre){
		 $sql="select * from vlectorapb_area_item where rdb=$rdb and id_padre=$padre order by id_item";
		$regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function traeItemUno($item){
		 $sql="select * from vlectorapb_area_item where id_item=$item";
		$regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function modItemUno($item,$glosa){
		 $sql="update vlectorapb_area_item set glosa='$glosa' where id_item=$item";
		 $regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	 
}//fin clase
?>