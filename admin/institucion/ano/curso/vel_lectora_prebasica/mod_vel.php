<?php header( 'Content-type: text/html; charset=iso-8859-1' );
require('../../../../../util/header.inc');

class VelocidadLec {
	public $conect;       

//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	
	
public function selAno($rdb){
	  $sql="select * from ano_escolar where id_institucion=$rdb order by nro_ano desc";
	$regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
	 if($regis){
			   return $regis;
		}else{
			 return false;
	}
	

}

public function selAnoUno($ano){
	  $sql="select * from ano_escolar where id_ano=$ano";
	$regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
	 if($regis){
			   return $regis;
		}else{
			 return false;
	}
	

}

public function selCurso($ano){
	  $sql="select * from curso where id_ano=$ano order by ensenanza, grado_curso,letra_curso";
	$regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
	 if($regis){
			   return $regis;
		}else{
			 return false;
	}
	

}

public function selAlumnos($curso){
	  $sql="select a.* from alumno a inner join matricula m on m.rut_alumno = a.rut_alumno where id_curso=$curso order by nro_lista ";
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
	
	
	
	public function listaConCal($rdb){
		 $sql="select * from vlectorapb_concepto where rdb=$rdb order by id_concepto";
		 $regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
		$regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
public function tengoEva($ano,$curso,$rut,$fecha,$area,$item){
  $sql="select * from vlectorapb_evaluacion where id_ano=$ano and id_curso=$curso and rut_alumno=$rut and fecha='$fecha' and area=$area and item=$item
";
$regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
}

public function guardarNEva($ano,$curso,$rut,$fecha,$area,$item,$respuesta){
	  $sql="insert into vlectorapb_evaluacion(id_ano,id_curso,rut_alumno,area,item,respuesta,fecha) values($ano,$curso,$rut,$area,$item,$respuesta,'$fecha')
	";
	$regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
}

public function guardarUEva($ano,$curso,$rut,$fecha,$area,$item,$respuesta){
	 $sql="update vlectorapb_evaluacion set respuesta=$respuesta where id_ano=$ano and id_curso=$curso and rut_alumno=$rut and fecha='$fecha' and  area=$area and item=$item
	";
	$regis = @pg_Exec($this->conect,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
}


}//fin clase
	?>