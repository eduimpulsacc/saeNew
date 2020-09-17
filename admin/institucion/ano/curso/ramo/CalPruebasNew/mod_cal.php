<?php require_once('../../../../../../util/header.inc');

class Calendario

{
	
	private $conect; 
	//private $conect2;        

//constructor 
public function __construct($con,$con2){ 
      $this->conect = $con;  
      $this->conect2 = $con2;
    }
	
public function  cursos($id_ano)
	{
		 $sql="select id_curso from curso where id_ano=$id_ano order by ensenanza,grado_curso,letra_curso";
		$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	}
	
public function ramos($id_curso){
$sql="  select r.id_ramo,s.nombre from ramo r inner join subsector s on r.cod_subsector = s.cod_subsector where id_curso = $id_curso order by r.id_orden"; 
$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
}

public function pruebas($id_curso,$id_ramo){
	

$sql="select p.*,s.nombre as asignatura,e.nombre_emp||' '||e.ape_pat as profesor
from cal_pruebas_new p inner join ramo r on r.id_ramo = p.id_ramo 
inner join subsector s on s.cod_subsector = r.cod_subsector
inner join dicta d on d.id_ramo = r.id_ramo
inner join empleado e on e.rut_emp = d.rut_emp 
where r.id_curso = $id_curso and r.id_ramo= $id_ramo order by fecha_inicio asc";
$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}

}

public function Ano_academico($id_ano){
	$sql="select nro_ano from ano_escolar where id_ano=$id_ano";
		$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
}

public function guardaPrueba($curso,$ramo,$fecha,$hora,$contenido,$archivo){
$sql="insert into cal_pruebas_new(id_curso,id_ramo,fecha_inicio,hora,descripcion,archivo) values($curso,$ramo,'$fecha','$hora','$contenido','$archivo')";
$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
}

public function seaRc($id){
$sql="select * from cal_pruebas_new where id_prueba=$id";
		$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
	if(!$result)
	{
		return false;	
	}else{
	
		return $result;
	}	
}

public function delPrueba($id){
$sql="delete from cal_pruebas_new where id_prueba=$id";
		$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
	if(!$result)
	{
		return false;	
	}else{
	
		return $result;
	}	
}

}// fin clase
?>