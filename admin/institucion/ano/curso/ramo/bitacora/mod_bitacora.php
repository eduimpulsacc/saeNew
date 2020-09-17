<?php 
class Bitacora{
	
	public function contructor(){
			
	}
	
	public function getDataRamo($conn,$ramo){
	$sql="select s.nombre,r.cod_subsector from subsector s inner join ramo r on r.cod_subsector = s.cod_subsector where r.id_ramo = $ramo";
	$rs = pg_exec($conn,$sql);
	return $rs;
	}
	
	public function getDicta($conn,$ramo){
	 $sql="select e.ape_pat,e.ape_mat,e.nombre_emp from empleado e inner join dicta d on d.rut_emp = e.rut_emp where d.id_ramo = $ramo";
	$rs = pg_exec($conn,$sql);
	return $rs;
	}
	
	
	
	public function getUnidades($conn,$cod_ramo,$nivel,$ensenanza){
		  $sql="select distinct(u.id),u.nombre,u.orden
from ct_unidad u 
inner join ct_asignatura_nivel an on an.id = u.asignatura_nivel_id
inner join ct_mapping_asignaturas_sae_ct m on m.asignatura_id  = an.asignatura_id and m.nivel_id = an.nivel_id
where m.sae_subsector = $cod_ramo and m.sae_tipo_ensenanza = $ensenanza and m.sae_level=$nivel order by orden;";

//if($_PERFIL==0){echo $sql;}
	$rs = pg_exec($conn,$sql);
	return $rs;
		
	}
	
	public function getBitacora($conn,$ramo,$periodo){
		 $sql="select * from asignatura_bitacora where id_ramo = $ramo and id_periodo=$periodo";
		$rs = pg_exec($conn,$sql);
		return $rs;
		}
		
	public function getDataCurso($conn,$curso){
	 $sql="select ensenanza,grado_curso from curso where id_curso = $curso";
	$rs = pg_exec($conn,$sql);
	return $rs;
	}
	
	public function getPeriodo($conn,$ano){
	$sql="select id_periodo, nombre_periodo from periodo where id_ano=$ano order by nombre_periodo";
	$rs = pg_exec($conn,$sql);
	return $rs;
	}
	
	public function getObjetivo($conn,$unidad){
	$sql="select id,codigo,descripcion from ct_objetivo where  unidad_id=$unidad order by orden;";
	$rs = pg_exec($conn,$sql);
	return $rs;
	}
	
	public function getIndicador($conn,$unidad){
	$sql="select id,codigo,descripcion from ct_indicador where  unidad_id=$unidad order by orden;";
	$rs = pg_exec($conn,$sql);
	return $rs;
	}
	
	public function guardaAct($conn,$curso,$ramo,$periodo,$unidad,$objetivo,$indicador,$fecha,$obs,$canal,$hora_inicio,$hora_termino,$bool_pie,$docente){
	 	$sql="insert into asignatura_bitacora (id_curso,id_ramo,id_periodo,id_unidad,id_objetivo,id_indicador,fecha,texto,id_canal,hora_inicio,hora_termino,bool_pie,docente) values($curso,$ramo,$periodo,$unidad,$objetivo,$indicador,'$fecha','$obs',$canal,'$hora_inicio','$hora_termino',$bool_pie,$docente)";
		$rs = pg_exec($conn,$sql);
		
	return $rs;
		}
		
	public function getUnidadbyID($conn,$unidad){
	$sql="select * from ct_unidad where id=$unidad";
	$rs = pg_exec($conn,$sql);
		
	return $rs;
	}
	
	public function getActividadById($conn,$id){
	$sql="select * from asignatura_bitacora where id_bitacora=$id";
	$rs = pg_exec($conn,$sql);
		
	return $rs;
	}
	
	
	public function getObjetivobyID($conn,$id){
	$sql="select * from ct_objetivo where id=$id";
	$rs = pg_exec($conn,$sql);
		
	return $rs;
	}
	
	public function getIndicadorID($conn,$id){
	 $sql="select * from ct_indicador where id=$id";
	$rs = pg_exec($conn,$sql);
		
	return $rs;
	}
	
	public function delActividad($conn,$id){
	 $sql="delete from asignatura_bitacora where id_bitacora=$id";
	$rs = pg_exec($conn,$sql);
		
	return $rs;
	}
	
	public function modificaAct($conn,$unidad,$objetivo,$indicador,$fecha,$obs,$id,$canal,$hora_inicio,$hora_termino,$bool_pie,$doc){
		
		  $sql="update asignatura_bitacora set id_unidad=$unidad,id_objetivo=$objetivo,id_indicador=$indicador,fecha='$fecha',texto='$obs',id_canal=$canal,hora_inicio='$hora_inicio',hora_termino='$hora_termino',bool_pie=$bool_pie,docente = $doc where id_bitacora=$id";
		$rs = pg_exec($conn,$sql);
		
	return $rs;
		}
		
	public function getListAlumno($conn,$curso){
	$sql="select a.rut_alumno,a.ape_pat,a.ape_mat,a.nombre_alu from alumno a inner join matricula m on m.rut_alumno = a.rut_alumno where m.id_curso = $curso order by 2,3,4";
	$rs = pg_exec($conn,$sql);
		
	return $rs;
	}
	
	public function insertAluBitacora($conn,$id,$rut){
		 $sql="insert into asignatura_bitacora_alumno values($id,$rut)";
		$rs = pg_exec($conn,$sql);
		return $rs;
	
	}
	
	public function getLastBitacora($conn,$ramo){
	$sql="select max(id_bitacora) from asignatura_bitacora where id_ramo = $ramo";	
	$rs = pg_exec($conn,$sql);
	$ult = pg_result($rs,0);
		
	return $ult;
	}
	
	public function getCanales($conn,$rbd){
	$sql="select * from asignatura_bitacora_canal where rbd in(0,$rbd) order by id";
	$rs = pg_exec($conn,$sql);
		return $rs;
	}
	
	public function guardaCanal($conn,$rbd,$nombre){
	$sql="insert into asignatura_bitacora_canal(rbd,nombre)  values($rbd,'$nombre')";
	$rs = pg_exec($conn,$sql);
		return $rs;
	}
	
	public function getAlumnosParticipantes($conn,$id){
		$sql="select distinct(a.rut_alumno),a.ape_pat,a.ape_mat,a.nombre_alu from alumno a 
left join matricula m on m.rut_alumno = a.rut_alumno
left join asignatura_bitacora_alumno ab on ab.rut_alumno = m.rut_alumno
where ab.id_bitacora=$id order by 2,3,4";
	$rs = pg_exec($conn,$sql);
		
	return $rs;
	
	}
	
	public function getListAlumnoRA($conn,$curso,$id){
	$sql="select a.rut_alumno,a.ape_pat,a.ape_mat,a.nombre_alu from alumno a
inner join matricula m on m.rut_alumno = a.rut_alumno
 where m.id_curso = $curso 
 and m. rut_alumno 
 not in (select rut_alumno from asignatura_bitacora_alumno where id_bitacora=$id )
 order by 2,3,4";
	$rs = pg_exec($conn,$sql);
		
	return $rs;
	}
	
	public function delAluAct($conn,$id){
	 $sql="delete from asignatura_bitacora_alumno where id_bitacora=$id";
	$rs = pg_exec($conn,$sql);
		
	return $rs;
	}
	
	public function getCanalbyID($conn,$id){
	$sql="select * from asignatura_bitacora_canal where id=$id";
	$rs = pg_exec($conn,$sql);
		return $rs;
	}
	
	public function getEnsenanzabyCurso($conn,$curso){
	  $sql="select ensenanza from curso where id_curso=$curso";
	$rs = pg_exec($conn,$sql);
	$enseCurso = pg_result($rs,0);
	return $enseCurso;
	}
	
	public function listaDoc($conn,$instit,$cargo){
	 $sql="select e.rut_emp,upper(e.ape_pat||' '||e.ape_mat||' '||e.nombre_emp) as nombre from empleado e
     inner join trabaja t on t.rut_emp = e.rut_emp
     where cargo=$cargo and rdb = $instit";	
	 $rs = pg_exec($conn,$sql);
		return $rs;
	}
	
	
	public function dictaAsig($conn,$ramo){
	 $sql="select rut_emp from dicta where id_ramo = $ramo";
	$rs = pg_exec($conn,$sql);
		return $rs;
	}
	
	public function getDocenteBitacora($conn,$emp){
	 $sql="select e.rut_emp,upper(e.ape_pat||' '||e.ape_mat||' '||e.nombre_emp) as nombre from empleado e where rut_emp = $emp";	
	 $rs = pg_exec($conn,$sql);
		return $rs;
	}
	
}//fin clase?>
