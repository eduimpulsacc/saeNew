<? 

class Objetivo_Habilidad{
	public function contructor(){
			
	}
	
	public function Guardar($conn,$codigo,$tipo,$eje,$texto,$rdb,$ense,$grado,$base){
		 $sql="INSERT INTO planificacion.obj_hab (id_eje,rdb,codigo,texto,tipo,tipo_ense,grado,visible) VALUES(".$eje.",".$rdb.",'".$codigo."','".utf8_decode($texto)."',".$tipo.",".$ense.",".$grado.",1)";	
		$result = pg_exec($conn,$sql);
		
		
		if($base==1){
		//coi final
	
	 $conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	 $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");
	 
}
if($base==2){
	 //coi viña
	
	  $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
      $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	
}
	 //coi corpraciones
if($base==4){	
	 $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
	  $conn3=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	
	
	
	}
$result2 = pg_exec($conn2,$sql);
$result3 = pg_exec($conn3,$sql);
		
		
		return $result;
	}
	
	public function listado($conn,$tipo,$eje,$grado,$ense){
		/*$sql="SELECT oh.codigo,oh.texto as texto_oh, 
case when (oh.tipo=0) THEN 'OBJETIVOS' else 'HABILIDADES' end AS NOMBRE_tipo, e.texto as textoeje,
a.nombre
FROM planificacion.obj_hab oh 
INNER JOIN planificacion.ejes e ON oh.id_eje=e.id_eje
INNER JOIN planificacion.asignatura a ON a.cod_subsector=e.cod_subsector";*/
		 $sql="SELECT * FROM planificacion.obj_hab WHERE tipo=".$tipo." AND id_eje=".$eje." and tipo_ense=$ense and grado=$grado and visible=1 ORDER BY id_obj ASC";
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
	
public function guardaEje($conn,$nombre,$tipo,$rbd,$codramo,$base){
  $sql="insert into planificacion.ejes (rdb,texto,tipo,cod_subsector) values($rbd,'".utf8_decode($nombre)."',$tipo,$codramo)";
$result = pg_exec($conn,$sql);


if($base==1){
		//coi final
	
	 $conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	 $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");
	 
}
if($base==2){
	 //coi viña
	
	  $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
      $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	
}
	 //coi corpraciones
if($base==4){	
	 $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
	  $conn3=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	
	
	
	}
$result2 = pg_exec($conn2,$sql);
$result3 = pg_exec($conn3,$sql);
	
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

public function BuscarEje($conn,$cod_subsector,$tipo){
	$sql="SELECT * FROM planificacion.ejes WHERE cod_subsector=".$cod_subsector." AND tipo=".$tipo." ORDER BY texto ASC";
	$result = pg_exec($conn,$sql);
	
	return $result;
		
}


public function listadoGradoEnse($conn,$tipo){
			
			
			 $sql="SELECT * FROM planificacion.grado_ense WHERE tipo_ense=".$tipo." ORDER BY tipo_ense,grado_curso ASC";
		$result = pg_exec($conn,$sql);	
		
		return $result;
	}
	
	public function listadoGradoEnseINS($conn,$tipo,$ano){
			 $sql="select distinct grado_curso
from curso where ensenanza = $tipo and id_ano=$ano order by grado_curso";
		$result = pg_exec($conn,$sql);	
		
		return $result;
	}
	
	
	
	public function listaRamoINS($conn,$tipo,$ano,$grado){
		 $sql ="select distinct(s.cod_subsector),s.nombre
	from subsector s
	inner join ramo r on r.cod_subsector = s.cod_subsector
	inner join curso c on c.id_curso = r.id_curso
	where c.id_ano=$ano and c.ensenanza=$tipo and c.grado_curso=$grado
	order by s.cod_subsector;";
	$result = pg_exec($conn,$sql);	
			
		return $result;
	}
	
	public function listaRamoADM($conn,$tipo,$grado){
		  $sql ="SELECT * FROM planificacion.asignatura where tipo_ensenaza=$tipo and grado_curso=$grado order by cod_subsector;";
		 	$result = pg_exec($conn,$sql);	
			
		return $result;
	}
	
	public function listaTipoObj($conn){
	  $sql ="SELECT * FROM planificacion.tipo_objetivo order by id_objetivo;";
		 	$result = pg_exec($conn,$sql);	
			
		return $result;
	}
	
	
public function ocObj($conn,$obj,$base){
	 $sql="update planificacion.obj_hab set visible=0 where id_obj = $obj";
	$result = pg_exec($conn,$sql);	
	
		if($base==1){
		//coi final
	
	 $conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	 $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");
	 
}
if($base==2){
	 //coi viña
	
	  $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
      $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	
}
	 //coi corpraciones
if($base==4){	
	 $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
	  $conn3=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	
	
	
	}
$result2 = pg_exec($conn2,$sql);
$result3 = pg_exec($conn3,$sql);
		
		
		return $result;
	return $result;

}

public function Dobj($conn,$obj){
	  $sql="select * from planificacion.obj_hab where id_obj=$obj";
	$result = pg_exec($conn,$sql);
		
		return $result;	
	}

public function exobj2($conn,$cadena,$obj){
	  $sql="select codigo from planificacion.obj_hab where codigo like '".trim($cadena)."' and id_obj !=$obj";
	$result = pg_exec($conn,$sql);
		
		return $result;	
	}	
	
	public function updObj($conn,$obj,$cod,$txt,$base){
	 $sql="update planificacion.obj_hab set codigo='$cod',texto='$txt' where id_obj=$obj ";
	$result = pg_exec($conn,$sql);	
	
	if($base==1){
		//coi final
	
	 $conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	 $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");
	 
}
if($base==2){
	 //coi viña
	
	  $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
      $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	
}
	 //coi corpraciones
if($base==4){	
	 $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
	  $conn3=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	
	
	
	}
$result2 = pg_exec($conn2,$sql);
$result3 = pg_exec($conn3,$sql);
		
		
		return $result;
	}

}
?>
