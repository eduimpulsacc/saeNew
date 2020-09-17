<?php
 class Grupo{
	public function contruct(){
		
	} 
	
public function getEnsenanza($conn,$ano){
	$sql="select DISTINCT(c.ensenanza),te.nombre_tipo
from curso c 
inner join tipo_ensenanza te on te.cod_tipo = c.ensenanza
where id_ano = $ano order by ensenanza" ;
		$result = pg_exec($conn,$sql);
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

public function tablaGrupo($conn,$ano,$ensenanza,$nivel,$subsector,$per){
		 $sql="select * from grupo_nota_curso  where id_ano=$ano and ensenanza=$ensenanza and nivel =$nivel and subsector = $subsector and id_periodo=$per order by orden";
		$result=pg_exec($conn,$sql);
		return $result;
	}
	
	
public function veMarca($conn,$ano,$ensenanza,$nivel,$subsector,$per,$posicion,$grupo=""){
	 if(strlen($grupo)>0){
		$cad="AND id_grupo!=$grupo ";
		}
	
	  $sql="
select nota$posicion from grupo_nota_curso  where id_ano=$ano and id_periodo = $per and ensenanza=$ensenanza and nivel =$nivel and subsector = $subsector $cad order by nota$posicion desc limit 1";
$result = pg_exec($conn,$sql);

//if($_PERFIL==0)echo $sql;
	return $result;	
	}


public function guardaGrupo($conn,$id_ano,$porcentaje,$nota1,$nota2,$nota3,$nota4,$nota5,$nota6,$nota7,$nota8,$nota9,$nota10,$nota11,$nota12,$nota13,$nota14,$nota15,$nota16,$nota17,$nota18,$nota19,$nota20,$leccionario,$ensenanza,$nivel,$subsector,$orden,$per){
		
	 $sql="insert into grupo_nota_curso(id_ano,porcentaje,nota1,nota2,nota3,nota4,nota5,nota6,nota7,nota8,nota9,nota10,nota11,nota12,nota13,nota14,nota15,nota16,nota17,nota18,nota19,nota20,nombre,ensenanza,nivel,subsector,orden,id_periodo) values($id_ano,$porcentaje,$nota1,$nota2,$nota3,$nota4,$nota5,$nota6,$nota7,$nota8,$nota9,$nota10,$nota11,$nota12,$nota13,$nota14,$nota15,$nota16,$nota17,$nota18,$nota19,$nota20,'$leccionario',$ensenanza,$nivel,$subsector,$orden,$per)";
		$result=pg_exec($conn,$sql);
		return $result;
	
	}	
	
public function tablaGrupoDet($conn,$grupo){
	 	$sql="select * from grupo_nota_curso where id_grupo=$grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	}

public function borraGrupo($conn,$grupo){
		  $sql="delete from grupo_nota_curso where id_grupo=$grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	}

public function actualizaGrupo($conn,$id_grupo,$porcentaje,$nota1,$nota2,$nota3,$nota4,$nota5,$nota6,$nota7,$nota8,$nota9,$nota10,$nota11,$nota12,$nota13,$nota14,$nota15,$nota16,$nota17,$nota18,$nota19,$nota20,$leccionario,$orden){
		
		  $sql="update  grupo_nota_curso set porcentaje=$porcentaje,nota1=$nota1,nota2=$nota2,nota3=$nota3,nota4=$nota4,nota5=$nota5,nota6=$nota6,nota7=$nota7,nota8=$nota8,nota9=$nota9,nota10=$nota10,nota11=$nota11,nota12=$nota12,nota13=$nota13,nota14=$nota14,nota15=$nota15,nota16=$nota16,nota17=$nota17,nota18=$nota18,nota19=$nota19,nota20=$nota20, nombre='$leccionario',orden=$orden where id_grupo=$id_grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	
	}

public function listaCurso($conn,$ano,$ensenanza,$grado){
	 $sql="select id_curso from curso where id_ano=$ano and ensenanza=$ensenanza and grado_curso=$grado";
	$result=pg_exec($conn,$sql);
		return $result;
	
	}
	
	public function listaRamo($conn,$ano,$ensenanza,$grado,$ramo){
	$sql="select id_ramo,notagrupo,id_curso from ramo where cod_subsector =$ramo and id_curso in (select id_curso from curso where id_ano=$ano and ensenanza=$ensenanza and grado_curso=$grado)";
	$result=pg_exec($conn,$sql);
		return $result;
	
	}
	
	
	public function borraGrupoFrom($conn,$grupo){
		 $sql="delete from grupo_nota where copied_from=$grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	}
	
public function ramoGR($conn,$ano,$ensenanza,$grado,$ramo,$activo){
	 $sql="select r.id_ramo,r.id_curso,r.modo_eval,r.truncado,r.bool_aprgrp from ramo r
where id_curso in (
select id_curso from curso where id_ano = $ano
and ensenanza = $ensenanza and grado_curso=$grado
) and r.cod_subsector=$ramo and notagrupo=$activo";
$result=pg_exec($conn,$sql);
		return $result;
	}
	
//activar grupo de nota en curso
public function activaGrupo($conn,$ramo){
	$sql="update ramo set notagrupo=1 where id_ramo = $ramo";
	$result=pg_exec($conn,$sql);
	return $result;
	}
	
public function PegaGrupo($conn,$ano,$ensenanza,$nivel,$subsector,$curso,$id_ramo,$id_periodo){
	 $sql="insert into grupo_nota(id_ano, id_curso,id_ramo,id_periodo, porcentaje,nota1,
nota2, nota3, nota4,nota5,nota6,nota7, nota8,nota9, nota10, nota11, nota12,nota13, nota14, nota15,nota16,nota17,nota18,nota19, nota20,nombre,copied_from,orden)
select $ano,$curso,$id_ramo,$id_periodo,porcentaje,nota1,
nota2, nota3, nota4,nota5,nota6,nota7, nota8,nota9, nota10, nota11, nota12,nota13, nota14, nota15,nota16,nota17,nota18,nota19, nota20,nombre,id_grupo,orden
from grupo_nota_curso where id_ano=$ano and ensenanza=$ensenanza and nivel =$nivel and subsector = $subsector and id_periodo = $id_periodo order by orden";
 $result=pg_exec($conn,$sql);
 		return $result;
	}	
	
	
public function tablaCurso($conn,$curso){
		  $sql="select * from grupo_nota_curso where id_curso=$curso order by id_grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	}

public function getIdRamo($conn,$curso,$subsector){
		 $sql="select id_ramo,modo_eval,truncado,bool_aprgrp,aprox_entero from ramo where id_curso=$curso and cod_subsector = $subsector";
		$result=pg_exec($conn,$sql);
		return $result;
	}
	
public function countGrupoforRamo($conn,$ramo,$id_periodo){
		 $sql="select * from grupo_nota where id_ramo=$ramo and id_periodo=$id_periodo order by id_grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	}	


public function alumnosInscritos($conn,$nro_ano,$idramo){
	$sql="select rut_alumno from tiene$nro_ano where id_ramo = $idramo";
	$result=pg_exec($conn,$sql);
		return $result;
}

public function nroAno($conn,$ano){
 $sql="select nro_ano from ano_escolar where id_ano=$ano";
$result=pg_exec($conn,$sql);
$nano = pg_result($result,0);
return $nano;

}

public function getPeriodos($conn,$ano){
$sql="select id_periodo,nombre_periodo from periodo where id_ano=$ano order by id_periodo";
	$result=pg_exec($conn,$sql);
		return $result;	
}

public function getNotaPosicion($conn,$nano,$posicion,$ramo,$periodo,$alumno){
	
	$sql="select nota".$posicion." from notas$nano 
where rut_alumno=".$alumno." and id_ramo=".$ramo." and id_periodo=".$periodo;
$result=pg_exec($conn,$sql);
		return $result;	
	}
	
public function actPromedio($conn,$nro_ano,$rut_alumno,$id_ramo,$id_periodo,$promedio){
$sql="update notas$nro_ano set promedio='$promedio' where rut_alumno = $rut_alumno and id_ramo=$id_ramo and id_periodo=$id_periodo";
$result=pg_exec($conn,$sql);
return $result;	
}

 function desifranotaconseptualN($conn,$id_ano,$institucion,$dato){
$nueva_nota=0;

	$sql="SELECT valor_numerico, rango_x, rango_y FROM modulo_conceptos WHERE id_ano=".$id_ano." AND id_rdb=".$institucion." AND nombre_concepto=".$dato;
	$rs_concepto = pg_exec($conn,$sql);
	$nueva_nota = pg_result($rs_concepto,0);
	return $nueva_nota;
	
 }
 
 
  function promedioconceptualN2($conn,$id_ano,$institucion,$rango){
$nueva_nota=0;

	$sql="SELECT nombre_concepto FROM modulo_conceptos 
WHERE id_ano=$id_ano AND id_rdb=$institucion AND rango_x >=60 and rango_y<=70;";
	$rs_concepto = pg_exec($conn,$sql);
	$nueva_nota = pg_result($rs_concepto,0);
	return $nueva_nota;
	
 }
 
 function getOrdenGrupo($conn,$ano,$ensenanza,$nivel,$subsector){
		 $sql="select max(orden) from grupo_nota_curso  where id_ano=$ano and ensenanza=$ensenanza and nivel =$nivel and subsector = $subsector ";
		$result=pg_exec($conn,$sql);
		return $result;
 }

function getPeriodo($conn,$ano){
 $sql="select * from periodo where id_ano = $ano order by fecha_inicio";
$result=pg_exec($conn,$sql);
		return $result;
}

public function getNivelAll($conn,$ano,$ensenanza){
	
		$sql="select DISTINCT(c.grado_curso),c.ensenanza
from curso c where id_ano = $ano and ensenanza in ($ensenanza) order by 2,1" ;
		$result = pg_exec($conn,$sql);
		return $result; 
	
}

public function cursoHasRamo($conn,$ano,$ensenanza,$grado,$subsector){
$sql="select  c.id_curso,r.id_ramo,r.modo_eval,r.truncado,r.bool_aprgrp,r.aprox_entero from curso c 
inner join ramo r on r.id_curso = c.id_curso
where c.id_ano =$ano and  c.ensenanza = $ensenanza and c.grado_curso =$grado and r.cod_subsector=$subsector";
$result = pg_exec($conn,$sql);
		return $result; 
}


public function PegaGrupoAll($conn,$ano,$curso,$id_ramo,$id_periodo,$ensenanza=0,$nivel=0,$subsector=0,$per=0){
	
	$en=($ensenanza!=0)?" and ensenanza=$ensenanza":" and ensenanza=0";
	$nv=($nivel!=0)?" and nivel=$nivel":" and nivel=0";
	$su=($subsector!=0)?" and subsector=$subsector":" and subsector=0";
	$pe=($per!=0)?" and id_periodo=$id_periodo":" and id_periodo=0";
	
	$sql="insert into grupo_nota(id_ano, id_curso,id_ramo,id_periodo, porcentaje,nota1,
nota2, nota3, nota4,nota5,nota6,nota7, nota8,nota9, nota10, nota11, nota12,nota13, nota14, nota15,nota16,nota17,nota18,nota19, nota20,nombre,copied_from,orden) select $ano,$curso,$id_ramo,$id_periodo,porcentaje,nota1,
nota2, nota3, nota4,nota5,nota6,nota7, nota8,nota9, nota10, nota11, nota12,nota13, nota14, nota15,nota16,nota17,nota18,nota19, nota20,nombre,id_grupo,orden from grupo_nota_curso where id_ano=$ano $en $nv $su $pe order by orden";
$result=pg_exec($conn,$sql);
 		return $result;
		
	}
	
	public function countGrupoforRamoPer($conn,$ramo,$per){
		$sql="select * from grupo_nota where id_ramo=$ramo and id_periodo=$per order by id_grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	}
		
		
public function tablaGrupoFrom($conn,$from,$periodo){
		 $sql="select * from grupo_nota where copied_from =$from order by id_curso,id_periodo";
		$result=pg_exec($conn,$sql);
		return $result;
	}
	
public function ramoInd($conn,$ramo){
 $sql="select id_curso,r.id_ramo,r.modo_eval,r.truncado,r.bool_aprgrp,r.aprox_entero from ramo r where id_ramo=$ramo";
$result=pg_exec($conn,$sql);
return $result;
}


public function countGrupoforRamoID($conn,$id_grupo){
		$sql="select * from grupo_nota where id_grupo=$id_grupo ";
		$result=pg_exec($conn,$sql);
		return $result; 
	}	
	
public function alumnosInscritosAll($conn,$nro_ano,$idramo,$id_periodo){
$sql="select * from tiene$nro_ano t 
inner join notas$nro_ano n on n.id_ramo = t.id_ramo and n.rut_alumno = t.rut_alumno
where t.id_ramo = $idramo and id_periodo = $id_periodo 
and promedio not in('0','');
";
	$result=pg_exec($conn,$sql);
		return $result;
}	

	
		
 }//fin clase?>