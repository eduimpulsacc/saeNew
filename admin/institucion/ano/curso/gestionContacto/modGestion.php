<?php 
session_start();

class Gestion{
	
	
public function getPeriodo($conn,$ano){
$sql="select * from gestion_periodo where id_ano=$ano order by fecha_desde";
$rs = pg_exec($conn,$sql);
return $rs;
}

public function getNroAno($conn,$ano){
$sql="select nro_ano from ano_escolar where id_ano=$ano";
$rs = pg_exec($conn,$sql);
$nro_ano = pg_result($rs,0);
return $nro_ano;
}

public function guardaPer($conn,$ano,$ini,$ter){
$sql="insert into gestion_periodo(id_ano,fecha_desde,fecha_hasta) values($ano,'$ini','$ter')";
$rs = pg_exec($conn,$sql);
return $rs;
}

public function existPeriodo($conn,$ano,$ini,$ter){
$sql="select * from gestion_periodo where id_ano=$ano and fecha_desde between '$ini' and '$ter'
or fecha_hasta between '$ini' and '$ter'";
$rs = pg_exec($conn,$sql);
return $rs;
}

public function getCurso($conn,$ano){
$sql="select id_curso from curso where id_ano=$ano order by ensenanza,grado_curso,letra_curso";	
$rs = pg_exec($conn,$sql);
return $rs;
}

public function getAlumno($conn,$curso){
$sql="select a.rut_alumno,upper(a.ape_pat||' '||a.ape_mat||' '||a.nombre_alu) as nombre from alumno a
inner join matricula m on m.rut_alumno = a.rut_alumno
where m.id_curso = $curso and m.bool_ar=0 order by m.nro_lista";
$rs = pg_exec($conn,$sql);
return $rs;
}

public function getPreguntas($conn){
$sql="select * from gestion_periodo_pregunta order by nro_pregunta";
$rs = pg_exec($conn,$sql);
return $rs;
}

public function getAlternativas($conn,$pregunta){
$sql="select * from gestion_periodo_alterantiva_pregunta where nro_pregunta = $pregunta order by id_alternativa";
$rs = pg_exec($conn,$sql);
return $rs;
}

public function extRespuesta($conn,$id_periodo,$id_curso,$rut_alumno,$cod_pregunta){
	 $sql="select cod_respuesta from gestion_periodo_respuesta where cod_pregunta=$cod_pregunta and id_periodo=$id_periodo and id_curso=$id_curso and rut_alumno=$rut_alumno";
	$rs = pg_exec($conn,$sql);
return $rs;
}

public function addRespuesta($conn,$id_periodo,$id_curso,$rut_alumno,$cod_pregunta,$id_ano,$cod_respuesta){
$sql="insert into gestion_periodo_respuesta (id_ano,id_curso,id_periodo,rut_alumno,cod_pregunta,cod_respuesta) values ($id_ano,$id_curso,$id_periodo,$rut_alumno,$cod_pregunta,$cod_respuesta)";
$rs = pg_exec($conn,$sql);
return $rs;
}

public function upRespuesta($conn,$id_periodo,$id_curso,$rut_alumno,$cod_pregunta,$id_ano,$cod_respuesta){
$sql="update gestion_periodo_respuesta set  cod_respuesta = $cod_respuesta where cod_pregunta=$cod_pregunta and id_periodo=$id_periodo and id_curso=$id_curso and rut_alumno=$rut_alumno";
$rs = pg_exec($conn,$sql);
return $rs;
}

public function cuentaRes($conn,$ano,$id_periodo)
{
 $sql="select count(distinct(re.rut_alumno)) from gestion_periodo_respuesta re inner join matricula m on re.rut_alumno =  m.rut_alumno
where m.id_ano=$ano and re.id_periodo=$id_periodo";
$rs = pg_exec($conn,$sql);
$cant = pg_result($rs,0);
return $cant;
}
	
	
public function getCantMatricula($conn,$ano){
$sql="select count(*) from matricula where id_ano=$ano and bool_ar=0";
$rs = pg_exec($conn,$sql);
$cant = pg_result($rs,0);
return $cant;
}
}//fin clase	?>