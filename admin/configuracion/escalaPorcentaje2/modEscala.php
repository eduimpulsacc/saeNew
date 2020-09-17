<?php
 class Escala{
	public function contruct(){
		
	} 
	
public function getEnsenanza($conn,$ano){
	
		$sql="select DISTINCT(c.ensenanza),te.nombre_tipo
from curso c 
inner join tipo_ensenanza te on te.cod_tipo = c.ensenanza
where id_ano = $ano and ensenanza >10 order by ensenanza" ;
		$result = pg_exec($conn,$sql);
		return $result; 
	
}

public function nroAno($conn,$ano){
 $sql="select nro_ano from ano_escolar where id_ano=$ano";
$result=pg_exec($conn,$sql);
$nano = pg_result($result,0);
return $nano;

}

public function tablaGrupo($conn,$rdb,$ano,$ensenanza,$nivel,$subsector,$periodo){
		  $sql="select * from escala_porcentaje where rdb = $rdb and id_ano = $ano and ensenanza=$ensenanza and nivel=$nivel and cod_subsector=$subsector and id_periodo=$periodo order by orden";
		$result=pg_exec($conn,$sql);
		return $result;
	}
	
function getOrdenGrupo($conn,$ano,$ensenanza,$nivel,$subsector,$periodo){
		 $sql="select max(orden) from escala_porcentaje  where id_ano=$ano and ensenanza=$ensenanza  and nivel=$nivel and cod_subsector=$subsector and id_periodo=$periodo";
		$result=pg_exec($conn,$sql);
		return $result;
 }	
 
 function getMaxMaximo($conn,$ano,$ensenanza,$nivel,$subsector,$periodo){
		 $sql="select max(maximo) from escala_porcentaje  where id_ano=$ano and ensenanza=$ensenanza and nivel=$nivel and cod_subsector=$subsector and id_periodo=$periodo";
		$result=pg_exec($conn,$sql);
		return $result;
 }	
 
public function guardaGrupo($conn,$rdb,$ano,$minimo,$maximo,$concepto,$ensenanza,$orden,$nivel,$subsector,$periodo,$descripcion){
		
	   $sql="insert into escala_porcentaje(rdb,id_ano,minimo,maximo,concepto,ensenanza,orden,nivel,cod_subsector,id_periodo,descripcion) values($rdb,$ano,$minimo,$maximo,'$concepto',$ensenanza,$orden,$nivel,$subsector,$periodo,'$descripcion')";
		$result=pg_exec($conn,$sql);
		return $result;
	
	}	
	
public function tablaGrupoDet($conn,$grupo){
	 	$sql="select * from escala_porcentaje where id=$grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	}

public function borraGrupo($conn,$grupo){
		  $sql="delete from escala_porcentaje where id=$grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	}

public function actualizaGrupo($conn,$id_grupo,$minimo,$maximo,$concepto,$orden,$descripcion){
		
		   $sql="update  escala_porcentaje set minimo=$minimo,maximo=$maximo, concepto='$concepto',orden=$orden,descripcion='$descripcion' where id=$id_grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	
	}
	
	public function getPeriodos($conn,$ano){
$sql="select id_periodo,nombre_periodo from periodo where id_ano=$ano order by id_periodo";
	$result=pg_exec($conn,$sql);
		return $result;	
}

public function getNivel($conn,$ano,$ensenanza){
	
		$sql="select DISTINCT(c.grado_curso)
from curso c where id_ano = $ano and ensenanza= $ensenanza order by c.grado_curso" ;
		$result = pg_exec($conn,$sql);
		return $result; 
	
}

public function getAsignatura($conn,$ano,$ensenanza,$nivel){
	
	$sql="select distinct(r.cod_subsector),s.nombre
from ramo r
inner join subsector s on s.cod_subsector = r.cod_subsector
where id_curso in(select id_curso from 
curso where id_ano=$ano and ensenanza=$ensenanza and grado_curso =$nivel)
order by 1" ;
		$result = pg_exec($conn,$sql);
		return $result; 
	
}
	
 }//fin clase?>