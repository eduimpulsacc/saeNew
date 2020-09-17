<?
require('../../../../../../util/header.inc');

 session_start();

class Plantilla{

public function listaCurso($conn,$ano){

 $sql_curso = "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
		$sql_curso.= "curso.ensenanza, curso.cod_decreto ";
		$sql_curso.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql_curso.= "WHERE (((curso.id_ano)=".$ano.")) ";
		
		$sql_curso.= "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
		//echo $sql_curso;
		$resultado_curso = pg_exec($conn,$sql_curso) or die ("Select falló: " .$sql_curso);
		return $resultado_curso;

}

public function listaApo($conn,$ano,$curso){
$sql_apo ="select DISTINCT a.rut_apo,a.dig_rut,
a.ape_pat,a.ape_mat,a.nombre_apo 
from tiene2 t
inner join matricula m on t.rut_alumno = m.rut_alumno
inner join apoderado a on t.rut_apo = a.rut_apo
where m.id_curso=$curso";
$sql.=" order by ape_pat,ape_mat, nombre_apo";
$resultado_apo = pg_exec($conn,$sql_apo) or die ("Select falló: " .$sql_curso);
		return $resultado_apo;

}

public function listaPeriodo($conn,$ano){

$sqlPeriodo="select * from periodo where id_ano=".$ano." order by nombre_periodo";
	$resultPeriodo=pg_Exec($conn, $sqlPeriodo) or die("fallo:".$sqlPeriodo);
	return $resultPeriodo;
}

public function listaalu($conn,$curso){

			
	$sql =" select matricula.rut_alumno, alumno.dig_rut,alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu from matricula, alumno ";
	$sql.=" where matricula.id_curso = ".$curso. " and matricula.rut_alumno = 	
			alumno.rut_alumno and bool_ar=0 ";
			$sql.=" order by ape_pat,ape_mat, nombre_alu";
		//echo $sql;
		
		$result= pg_exec($conn,$sql)or die("fallo:".$sql);
		return $result;
	}


public function listaTrabaja($conn,$institucion){
	
$qry="SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.email, trabaja.cargo,empleado.telefono,empleado.telefono2,empleado.telefono3, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.")) order by ape_pat, ape_mat, nombre_emp asc, trabaja.cargo ";
$result =@pg_Exec($conn,$qry) or die("fallo:".$qry);
return $result;

}

public function enseCurso($conn,$curso){
	$sql_curso = "SELECT grado_curso,ensenanza from curso where id_curso=$curso ";
$result =@pg_Exec($conn,$sql_curso) or die("fallo:".$sql_curso);
return $result;
}


public function planActiva($conn,$ense,$grado,$tipo,$rbd){
 $sql ="select id_plantilla,nombre_informe from plantilla_apo where tipo_ense=$ense and grado$grado=1 and activa=1 and tipo_plantilla =$tipo and rbd=$rbd order by id_plantilla";
 
 $result =@pg_Exec($conn,$sql) or die("fallo:".$sql_curso);
return $result;
}

public function planActivaEmp($conn,$tipo,$rbd){
 $sql ="select id_plantilla,nombre_informe from plantilla_apo where activa=1 and tipo_plantilla =$tipo  and rbd=$rbd order by id_plantilla";
 
 $result =@pg_Exec($conn,$sql) or die("fallo:".$sql_curso);
return $result;
}

public function getDatoPlantilla($conn,$id_plantilla){
	
	  $sql="select * from plantilla_apo where id_plantilla=".$id_plantilla ;
			$result=pg_exec($conn, $sql);
		return $result;
	
}	

public function getAreas($conn,$plantilla){
	
	   $sql="select * from plantilla_apo_area where id_plantilla=".$plantilla ;
			$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	
}

public function getConcepto($conn,$plantilla,$area){
	
	   $sql="select * from plantilla_apo_item where id_plantilla=".$plantilla ." and id_area=$area and activo=1" ;
			$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	
}

public function ListaConcepto($conn,$plantilla){
	
	     $sql="select * from plantilla_apo_concepto where id_plantilla=".$plantilla ." and  activo=1" ;
			$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	
}

public function traeAlumnoUno($conn,$rut){
	$sql = "select rut_alumno, upper(dig_rut),upper(nombre_alu||' '||ape_pat||' '||ape_mat) as nombre from alumno where rut_alumno=$rut";
	$result=pg_exec($conn, $sql) or die("error".$sql);
	return $result;
}

public function traeApoderadoUno($conn,$rut){
	$sql = "select rut_apo, upper(dig_rut),upper(nombre_apo||' '||ape_pat||' '|| ape_mat) as nombre from apoderado where rut_apo=$rut";
	$result=pg_exec($conn, $sql) or die("error".$sql);
	return $result;
}
public function traeEmpleadoUno($conn,$rut){
	$sql = "select rut_emp, upper(dig_rut),upper(nombre_emp||' '||ape_pat||' '||ape_mat) as nombre from empleado where rut_emp=$rut";
	$result=pg_exec($conn, $sql) or die("error".$sql);
	return $result;
}

public function traeEvaluacion($conn,$rut,$periodo,$plantilla){
	$sql = "select * from plantilla_apo_evaluacion where rut=$rut and id_periodo=$periodo and id_plantilla=$plantilla";
	$result=pg_exec($conn, $sql) or die("error".$sql);
	return $result;
}

public function guardaEvaluacion($conn,$rut,$id_periodo,$id_plantilla,$entrevistador,$observacion,$ano){
  $sql="insert into plantilla_apo_evaluacion(rut,id_periodo,id_plantilla,entrevistador,observacion,fecha,id_ano) values($rut,$id_periodo,$id_plantilla,'$entrevistador','$observacion','".date("Y-m-d")."',$ano)";
$result=pg_exec($conn, $sql) or die("error".$sql);
	return $result;
}

public function actualizaEvaluacion($conn,$observacion,$evaluacion){
	 $sql="update plantilla_apo_evaluacion set observacion='$observacion' where id_evaluacion=$evaluacion ";
$result=pg_exec($conn, $sql) or die("error".$sql);
	return $result;
	
}

public function guardaEvaluacionItem($conn,$evaluacion,$area,$item,$concepto){

$sql ="insert into plantilla_apo_evaluacion_item values($evaluacion,$area,$item,$concepto)";
$result=pg_exec($conn, $sql) or die("error".$sql);
	return $result;


}

public function eliminaEvaluacionItem($conn,$evaluacion){

 $sql ="delete from plantilla_apo_evaluacion_item where id_evaluacion=$evaluacion;";
$result=pg_exec($conn, $sql) or die("error".$sql);
	return $result;


}

public function selItemEvaluacion($conn,$evaluacion,$area,$item,$concepto){
  $sql ="select * from plantilla_apo_evaluacion_item where id_evaluacion=$evaluacion and id_area=$area and id_item=$item and id_concepto=$concepto;";
$result=pg_exec($conn, $sql) or die("error".$sql);
	return $result;

}

public function traeEvaluacionultimo($conn){
	 $sql = "select * from plantilla_apo_evaluacion order by id_evaluacion desc limit 1";
	$result=pg_exec($conn, $sql) or die("error".$sql);
	return $result;
}


}//fin clase

?>