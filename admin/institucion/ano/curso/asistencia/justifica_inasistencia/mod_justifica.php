<?php 
require_once('../../../../../../util/header.inc');

class Justifica

{
	
	private $conect; 
	//private $conect2;        

//constructor 
public function __construct($con,$con2){ 
      $this->conect = $con;  
      $this->conect2 = $con2;
    }


public function Ano_academico($id_ano)
	{
		$sql="select nro_ano from ano_escolar where id_ano=$id_ano";
		$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	}
public function tipoJustifica($rbd){
	 $sql="select * from justifica_inasistencia_tipo where rbd=$rbd order by nombre";
		$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	}
public function creaTipo($nombre,$rbd){
	 $sql="insert into justifica_inasistencia_tipo (nombre,rbd) values ('$nombre',$rbd)";
	$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	}	
	
public function guardaHistoria($rut,$ano,$curso,$desde,$hasta,$tipo,$detalle,$archivo){
  $sql="insert into justifica_inasistencia_detalle (rut_alumno,id_ano,id_curso,fecha_desde,fecha_hasta,tipo_justificacion,detalle,archivo) values($rut,$ano,$curso,'$desde','$hasta',$tipo,'$detalle','$archivo')";
 $result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
 
 }	
 
public function cargaHistoria($rut,$ano,$curso,$desde,$hasta){
 $sql="select * from justifica_inasistencia_detalle where rut_alumno = $rut and id_ano =$ano and id_curso=$curso and fecha_desde>='$desde' and fecha_hasta<='$hasta' order by fecha_desde ";
$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
}

public function tipoUno($tipo){
$sql="select nombre from justifica_inasistencia_tipo where id_tipo=$tipo";
$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
return $result;
}

public function historiaUno($id){
$sql="select * from justifica_inasistencia_detalle where id_justifica_inasistencia_detalle=$id";
$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
return $result;
}

public function delhistoriaUno($id){
$sql="delete from justifica_inasistencia_detalle where id_justifica_inasistencia_detalle=$id";
$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
}
public function nomAlumno($rut){
$sql="select nombre_alu||' '||ape_pat||' '||ape_mat from alumno where rut_alumno=$rut";	
$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
}

}//fin clase
?>