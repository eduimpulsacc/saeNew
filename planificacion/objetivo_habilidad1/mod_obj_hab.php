<? 

class Objetivo_Habilidad{
	public function contructor(){
			
	}
	
	public function Guardar($conn,$codigo,$tipo,$eje,$texto,$rdb){
		 $sql="INSERT INTO planificacion.obj_hab (id_eje,rdb,codigo,texto,tipo) VALUES(".$eje.",".$rdb.",'".$codigo."','".utf8_decode($texto)."',".$tipo.")";	
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function listado($conn){
		 $sql="SELECT oh.codigo,oh.texto as texto_oh, 
case when (oh.tipo=0) THEN 'OBJETIVOS' else 'HABILIDADES' end AS NOMBRE_tipo, e.texto as textoeje,
a.nombre
FROM planificacion.obj_hab oh 
INNER JOIN planificacion.ejes e ON oh.id_eje=e.id_eje
INNER JOIN planificacion.asignatura a ON a.cod_subsector=e.cod_subsector";
		$result = pg_exec($conn,$sql);	
		
		return $result;
	}
	
	public function ejes($conn,$tipo,$subsector){
		 $sql="SELECT * FROM planificacion.ejes WHERE tipo=".$tipo." and cod_subsector=$subsector";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function exobj($conn,$cadena){
	 $sql="select codigo from planificacion.obj_hab where codigo like '".trim($cadena)."'";
	$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function tipoEnse($conn){
	 $sql="select * from tipo_ensenanza order by cod_tipo asc";
	$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function subsector($conn){
	  $sql="select * from subsector where cod_subsector>0 and char_length(nombre)>0 order by nombre asc";
	$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
public function guardaEje($conn,$nombre,$tipo,$rbd,$codramo){
 $sql="insert into planificacion.ejes (rdb,texto,tipo,cod_subsector) values($rbd,'".utf8_decode($nombre)."',$tipo,$codramo)";
$result = pg_exec($conn,$sql);
	
	return $result;	
}

public function gradosense($conn,$tipoense){
$sql="select grado from tipo_ense_eval WHERE cod_tipo = $tipoense order by grado";
$result = pg_exec($conn,$sql);
	return $result;
}


public function existeSubsector($conn,$codigo){
	   $sql="select * from subsector where cod_subsector=$codigo";
$result = pg_exec($conn,$sql);
	
	return $result;	
}

}
?>
