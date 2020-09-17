<?php 
class Unidad{
	
	public function contructor(){
			
	}

public function traeCursos($conn,$ano){
	 $sql="SELECT id_curso,grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo AS curso, ensenanza FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo WHERE id_ano=".$ano." and ensenanza>10 ORDER BY ensenanza,curso ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	
	

}	

public function traeRamo($conn,$curso,$ramo=''){

 $qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, ramo.eee,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen, ramo.conexper,ramo.prueba_especial,ramo.bool_nquiz,ramo.conexquiz, ramo.coef2,ramo.bool_pu FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso."))";
 
 if($ramo){
$qry.=" and ramo.id_ramo=$ramo";
}
 
 $qry.=" order by ramo.id_orden";	
 
 //echo $qry;		   
             $result = pg_exec($conn,$qry);
		
		return $result;	
}
	
public function traeDicta($conn,$ramo){
 $qry = "select
d.rut_emp,
d.id_ramo,
e.nombre_emp||' '|| e.ape_pat||' '|| e.ape_mat as nombre
from dicta d
inner join empleado e on e.rut_emp = d.rut_emp
where d.id_ramo=$ramo"; 
$result = pg_exec($conn,$qry);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
}

public function traeEjeObjetivo($conn,$rdb,$cod_ramo,$tipo){
	 $sql="SELECT * FROM planificacion.ejes WHERE tipo=$tipo and cod_subsector=".$cod_ramo." and (rdb=0 or rdb=$rdb) order by texto";
	 
	 //echo $sql."<br>";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function traeEjeObjetivo2($conn,$rdb,$cod_ramo,$tipo,$ense,$grado){
	 $sql="select distinct(ej.id_eje),ej.* from planificacion.ejes ej
inner join planificacion.obj_hab hb on hb.id_eje = ej.id_eje 
WHERE ej.tipo=$tipo and cod_subsector= $cod_ramo
and hb.tipo_ense=$ense and hb.grado=$grado
and ej.rdb in(0,$rdb) order by ej.texto";
	 //if($_PERFIL==0){echo $sql;}
	// echo $sql."<br>";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	
	
	
	public function traeEjeHabilidad($conn,$rdb,$cod_ramo){
	 $sql="SELECT * FROM planificacion.ejes WHERE tipo=1 and cod_subsector=".$cod_ramo." and (rdb=0 or rdb=$rdb) order by texto";
		$result = pg_exec($conn,$sql);
		// echo $sql."<br>";
		return $result;	
	}

public function traeRamoUno($conn,$ramo){
	 $sql="SELECT * FROM ramo WHERE  id_ramo=".$ramo;
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}

	
public function traeObj($conn,$id_eje,$rdb,$ense,$grado,$tipo){
   $sql="SELECT * FROM planificacion.obj_hab WHERE id_eje=$id_eje and tipo=$tipo and tipo_ense=$ense and grado=$grado and rdb in($rdb,0) order by codigo";
		$result = pg_exec($conn,$sql);
		//echo $sql."<br>";
		return $result;	
}	


public function traeHab($conn,$id_eje,$rdb,$ense,$grado){
 $sql="SELECT * FROM planificacion.obj_hab WHERE id_eje=$id_eje  and tipo=1 and tipo_ense=$ense and grado=$grado and (rdb=$rdb or rdb=0)   order by texto";
		$result = pg_exec($conn,$sql);
		//echo $sql."<br>";
		return $result;	
}	

public function guardaUnidad($conn,$rdb,$ano,$sel_curso,$sel_ramo,$docdicta,$txt_fechaini,$txt_fechater,$txt_semana,$texto,$txt_nombre,$tipu,$mes,$txt_horas){
	
	$txt_semana=($txt_semana=="")?0:$txt_semana;
	
	  $sql="insert into planificacion.unidad_anio(rdb,id_ano,id_curso,id_ramo,rut_emp,fecha_inicio,fecha_termino,cant_semanas,texto,nombre,tipo,num_mes,nro_horas,estado) values ($rdb,$ano,$sel_curso,$sel_ramo,$docdicta,'$txt_fechaini','$txt_fechater',$txt_semana,'$texto','$txt_nombre',$tipu,$mes,$txt_horas,1)";
	$result = pg_exec($conn,$sql);
	
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	
}

public function ultimaUnidad($conn,$rdb){
 	$sql="select id_unidad from planificacion.unidad_anio where rdb=$rdb order by id_unidad desc limit 1";
	$result = pg_exec($conn,$sql);
	
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
}
	
public function guardaObjetivo($conn,$id_unidad,$id_obj){
  $sql="insert into planificacion.unidad_anio_obj values($id_unidad,$id_obj);";
	$result = pg_exec($conn,$sql);
	return $result;
	
}	
	
public function listaUnidad($conn,$id_ano,$rdb,$curso,$ramo,$docente){
	$sql="select planificacion.unidad_anio.* from planificacion.unidad_anio inner join curso 
	on planificacion.unidad_anio.id_curso = curso.id_curso
	where rdb=$rdb";
	
	if($id_ano>0){
	$sql.=" and planificacion.unidad_anio.id_ano=$id_ano";
	}
	
	if($curso>0){
	$sql.=" and planificacion.unidad_anio.id_curso=$curso";
	}
	
	if($ramo>0){
	$sql.=" and id_ramo=$ramo";
	}
	
	if($docente>0){
	$sql.=" and rut_emp=$docente";
	}
	
	$sql.=" order by curso.ensenanza,curso.grado_curso,curso.letra_curso,planificacion.unidad_anio.id_unidad ";
	//echo $sql;
	$result = pg_exec($conn,$sql);
	
	if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
}	
	
public function traeUnidad($conn,$idUnidad){
$sql="select * from planificacion.unidad_anio where id_unidad=$idUnidad";
 $sql;
	$result = pg_exec($conn,$sql);
	
	if(!$result)
		{
			return false;	
		}
		else{
			return $result;
		}

}

public function traeObjUnidad($conn,$tipo,$idUnidad){
     $sql="select oh.* from planificacion.obj_hab oh inner join planificacion.unidad_anio_obj ob  on ob.id_obj = oh.id_obj where oh.tipo=$tipo and ob.id_unidad=$idUnidad order by oh.codigo";
 $result = pg_exec($conn,$sql);
	return $result;	
}	

public function actualizaUnidad($conn,$idUnidad,$txt_fechaini,$txt_fechater,$txt_semana,$txt_horas,$texto,$txt_nombre){
	$txt_semana=($txt_semana=="")?0:$txt_semana;
	
    $sql= "update planificacion.unidad_anio set fecha_inicio='$txt_fechaini',fecha_termino='$txt_fechater',cant_semanas=$txt_semana,nro_horas=$txt_horas,texto='$texto',nombre='$txt_nombre',estado=3 where id_unidad=$idUnidad";
	
	$result = pg_exec($conn,$sql);
	return $result;	

}

public function eliminaObHa($conn,$idUnidad){

$sql="delete from planificacion.unidad_anio_obj where id_unidad=$idUnidad";
$result = pg_exec($conn,$sql);
	return $result;	

}

public function traeMarcado($conn,$idUnidad,$id_obj){
    $sql="select id_obj as marcado from planificacion.unidad_anio_obj where id_unidad=$idUnidad and id_obj=$id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}

public function existe($conn,$fecha_inicio,$fecha_termino,$id_curso,$id_ramo){
    $sql="select * from planificacion.unidad_anio where id_curso=$id_curso and id_ramo=$id_ramo and fecha_inicio>='$fecha_inicio' AND fecha_termino<='$fecha_termino' ";
 $result = pg_exec($conn,$sql);
	return $result;	
}


public function traeObjUnidadAll($conn,$idUnidad){
    $sql="select oh.* from planificacion.obj_hab oh inner join planificacion.unidad_anio_obj ob  on ob.id_obj = oh.id_obj
where ob.id_unidad=$idUnidad order by oh.id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}

public function cursoTieneRamo($conn,$ano,$ramo){
   $sql="select r.id_curso from ramo r
inner join curso c on c.id_curso = r.id_curso
where c.id_ano=$ano and r.cod_subsector=$ramo order by c.ensenanza asc,c.grado_curso asc";
$result = pg_exec($conn,$sql);
	return $result;
}


public function cursoTieneRamoGrado($conn,$ano,$ramo,$grado,$ense,$curso){
    $sql="select r.id_curso from ramo r
inner join curso c on c.id_curso = r.id_curso
where c.id_ano=$ano and r.cod_subsector=$ramo and c.grado_curso=$grado and c.ensenanza=$ense and c.id_curso!=$curso order by c.ensenanza asc,c.grado_curso asc";
$result = pg_exec($conn,$sql);
	return $result;
}

	
public function cursoTieneRamo2($conn,$ano,$ramo,$curso){
   $sql="select r.id_ramo from ramo r
inner join curso c on c.id_curso = r.id_curso
where c.id_ano=$ano and r.cod_subsector=$ramo and c.id_curso=$curso";
$result = pg_exec($conn,$sql);
	return $result;
}

public function anoEscola($conn,$ano){
   $sql="select * from ano_escolar where id_ano=$ano";
$result = pg_exec($conn,$sql);
	return $result;
}

public function traeCursosUno($conn,$curso){
	  $sql="SELECT * FROM curso where id_curso=$curso ";
		$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function existeT2($conn,$id_curso,$id_ramo,$tipo){
    $sql="select * from planificacion.unidad_anio where id_curso=$id_curso and id_ramo=$id_ramo and tipo=$tipo ";
 $result = pg_exec($conn,$sql);
	return $result;	
}

public function subsector($conn,$cod_ramo){
 $sql="SELECT * FROM subsector where cod_subsector=".trim($cod_ramo);
		$result = pg_exec($conn,$sql);
		
		return $result;	
}


public function guardaUnidadT2($conn,$rdb,$ano,$curso,$id_ramo,$dicta,$txt_fechaini,$txt_fechater,$txt_nombre,$tipu){
	
	
	     $sql="insert into planificacion.unidad_anio(rdb,id_ano,id_curso,id_ramo,rut_emp,fecha_inicio,fecha_termino,nombre,tipo,estado) values ($rdb,$ano,$curso,$id_ramo,$dicta,'$txt_fechaini','$txt_fechater','$txt_nombre',$tipu,1)";
	   $result = pg_exec($conn,$sql);
		
		return $result;	
	
}

public function traeObjAll($conn,$rdb,$ense,$grado){
   $sql="SELECT * FROM planificacion.obj_hab WHERE tipo_ense=$ense and grado=$grado and (rdb=$rdb or rdb=0) order by texto";
		$result = pg_exec($conn,$sql);
		//echo $sql."<br>";
		return $result;	
}

public function traeObjAll2($conn,$rdb,$ense,$grado,$sub){
   $sql="select oh.id_obj
from  planificacion.obj_hab oh 
inner join planificacion.ejes pe
on oh.id_eje = pe.id_eje
where pe.cod_subsector =$sub and oh.grado=$grado and oh.tipo_ense=$ense
and pe.rdb in (0,$rdb) order by 1";
		$result = pg_exec($conn,$sql);
		//echo $sql."<br>";
		return $result;	
}

public function cursoSsDocente($conn,$emp,$ins,$ano){
 	   $sql =  "SELECT distinct (curso.id_curso), curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo
    FROM (institucion INNER JOIN ((tipo_ensenanza 
   INNER JOIN (((empleado INNER JOIN dicta ON empleado.rut_emp = dicta.rut_emp) 
   INNER JOIN ramo ON dicta.id_ramo = ramo.id_ramo) 
   INNER JOIN curso ON ramo.id_curso = curso.id_curso)
    ON tipo_ensenanza.cod_tipo = curso.ensenanza) 
    INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) 
    ON institucion.rdb = ano_escolar.id_institucion) 
    INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector 
    WHERE empleado.rut_emp=$emp and institucion.rdb = $ins and curso.id_ano = $ano
     ORDER BY curso.grado_curso ASC
     
     ";
	 $result = pg_exec($conn,$sql);
		//echo $sql."<br>";
		return $result;	
}

public function esPJefe($conn,$emp,$curso){
	$sql="select * from supervisa where rut_emp=$emp and id_curso=$curso";
	 $result = pg_exec($conn,$sql);
		//echo $sql."<br>";
		return $result;	
}

public function ramosDct($conn,$emp,$curso){
  $qry = "select r.id_ramo, s.cod_subsector,s.nombre from ramo r
inner join dicta d on d.id_ramo = r.id_ramo
inner join subsector s on s.cod_subsector = r.cod_subsector
where d.rut_emp = $emp
and r.id_curso = $curso
"; 
$result = pg_exec($conn,$qry);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
}

public function traeEstadoClase($conn){
$sql="select * from planificacion.clase_estados order by id_estado asc";
$result = pg_exec($conn,$sql);
	return $result;
}

public function traeHistorialcambiosUAnual($conn,$unidad){
  $sql="select * from planificacion.unidad_observacion where id_unidad=$unidad order by fecha,id_observacion asc";
$result = pg_exec($conn,$sql);
	return $result;
}

public function guardaHistorialcambiosUAnual($conn,$unidad,$fecha,$observacion){
    $sql="insert into planificacion.unidad_anio_observacion (id_unidad,fecha,observacion) values($unidad,'$fecha','".utf8_decode($observacion)."')";
$result = pg_exec($conn,$sql);
	return $result;
}

public function cambiaEstadoClaseUAnual($conn,$unidad,$estado){
   $sql="update planificacion.unidad_anio set estado=$estado where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
	return $result;
}

public function traeEstadoClaseUno($conn,$estado){
 $sql="select * from planificacion.clase_estados where id_estado=$estado order by id_estado asc";
$result = pg_exec($conn,$sql);
	return $result;
}

public function cambiaRealizada($conn,$unidad,$estado){
   $sql="update planificacion.unidad_anio set ejecutada=$estado where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
	return $result;
}

public function traearchivo($conn,$unidad){
    $sql="select * from planificacion.unidad_anio_archivo where id_unidad=$unidad and visible=1";
$result = pg_exec($conn,$sql);
return $result;	
}

public function pisaArchivos($conn,$unidad){
    $sql="update planificacion.unidad_anio_archivo set visible=0 where id_unidad=$unidad and visible=1";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaArchivos($conn,$unidad,$ruta){
    $sql="insert into planificacion.unidad_anio_archivo(id_unidad,ruta,visible) values ($unidad,'$ruta',1)";
$result = pg_exec($conn,$sql);
return $result;	
}


public function teje($conn,$subsector,$ense,$grado){
   $sql="select DISTINCT(tob.id_objetivo),tob.nombre from planificacion.tipo_objetivo tob
inner join planificacion.ejes pe on pe.tipo = tob.id_objetivo 
inner join planificacion.obj_hab oh on oh.id_eje = pe.id_eje
where pe.cod_subsector=$subsector 
and oh.tipo_ense=$ense and oh.grado=$grado
order by tob.id_objetivo
";
$result = pg_exec($conn,$sql);
return $result;	
}

public function tejeUnidad($conn,$unidad){
	$sql="select DISTINCT(tob.id_objetivo),tob.nombre from planificacion.tipo_objetivo tob
inner join planificacion.obj_hab oh on oh.tipo =tob.id_objetivo
left join  planificacion.unidad_anio_obj ob on ob.id_obj = oh.id_obj
where ob.id_unidad=$unidad order by tob.id_objetivo
";
$result = pg_exec($conn,$sql);
return $result;	
	}


//borrado 
public function traeUnidadU($conn,$idUnidad){
  $sql="select * from planificacion.unidad where unidad_anual=$idUnidad";
$result = pg_exec($conn,$sql);
return $result;
}

public function traeClasesU($conn,$unidad){
  $sql="select * from planificacion.clase where id_unidad=$unidad order by id_clase";
$result = pg_exec($conn,$sql);
return $result;
}

public function archivoClase($conn,$clase){
   $sql="select * from planificacion.clase_archivo where id_clase=$clase";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delArchivoClase($conn,$clase){
   $sql="delete from planificacion.clase_archivo where id_clase=$clase";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delNotaClase($conn,$clase){
   $sql="delete from planificacion.clase_nota where id_clase=$clase";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delObsClase($conn,$clase){
   $sql="delete from planificacion.clase_observacion where id_clase=$clase";
$result = pg_exec($conn,$sql);
return $result;	
}
public function delRecursoClase($conn,$clase){
   $sql="delete from planificacion.clase_recurso where id_clase=$clase";
$result = pg_exec($conn,$sql);
return $result;	
}
public function delTipoevaClase($conn,$clase){
   $sql="delete from planificacion.clase_tipoevaluacion where id_clase=$clase";
$result = pg_exec($conn,$sql);
return $result;	
}
public function delObjClase($conn,$clase){
   $sql="delete from planificacion.clase_obj where id_clase=$clase";
$result = pg_exec($conn,$sql);
return $result;	
}
public function delClase($conn,$clase){
   $sql="delete from planificacion.clase where id_clase=$clase";
$result = pg_exec($conn,$sql);
return $result;	
}


//borro unidad
public function archivoUnidadU($conn,$unidad){
   $sql="select * from planificacion.unidad_archivo where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delObsUnidadU($conn,$unidad){
   $sql="delete from planificacion.unidad_observacion where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delArchivoUnidadU($conn,$unidad){
   $sql="delete from planificacion.unidad_archivo where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delObjUnidadU($conn,$unidad){
   $sql="delete from planificacion.unidad_obj where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delUnidadU($conn,$unidad){
   $sql="delete from planificacion.unidad where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}



//borro anual

public function archivoUanual($conn,$unidad){
   $sql="select * from planificacion.unidad_anio_archivo where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

public function archivoUnidad($conn,$unidad){
   $sql="select * from planificacion.unidad_anio_archivo where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}
public function delObsUnidad($conn,$unidad){
    $sql="delete from planificacion.unidad_anio_observacion where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delObjUnidad($conn,$unidad){
   $sql="delete from planificacion.unidad_anio_obj where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delNotaUnidadU($conn,$unidad){
   $sql="delete from planificacion.unidad_nota where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delUnidad($conn,$unidad){
   $sql="delete from planificacion.unidad_anio where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

//indicador
public function buscaIndicador($conn,$id_obj){
 $sql="select * from planificacion.indicador_evaluacion where id_obj=$id_obj";
$result = pg_exec($conn,$sql);
return $result;	
}


public function buscaIndicadorSel($conn,$id_obj){
  $sql="select indic.* from planificacion.indicador_evaluacion indic
inner join planificacion.indeva_unidad_ano inde
on inde.id_indicador = indic.id_indicador
where inde.id_obj =$id_obj";
$result = pg_exec($conn,$sql);
return $result;	
}


public function guardaIndicador($conn,$unidad,$iobj,$indicador){
  $sql="insert into planificacion.indeva_unidad_ano values($unidad,$iobj,$indicador)";
$result = pg_exec($conn,$sql);
return $result;	
}


public function borraIndicador($conn,$unidad){
$sql="delete from planificacion.indeva_unidad_ano where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}


public function tipoEjesBloqueAnio($conn,$unidad,$tipo){
	    $sql="select DISTINCT(tej.id_eje),tej.texto 
from planificacion.ejes tej 
inner join planificacion.obj_hab oh on oh.id_eje = tej.id_eje
inner join planificacion.unidad_anio_obj ob on ob.id_obj = oh.id_obj
where ob.id_unidad=$unidad and tej.tipo=$tipo order by tej.texto";
$result =pg_exec($conn,$sql);
		
		return $result;
	}

public function traeObjeUnidadAnio($conn,$eje,$tipo,$unidad){
 $sql="select oh.* from planificacion.obj_hab oh 
inner join planificacion.unidad_anio_obj ob on ob.id_obj = oh.id_obj 
where oh.tipo=$tipo and id_eje =$eje  and ob.id_unidad=$unidad order by oh.id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}	


public function traeIndiUnidadC($conn,$unidad,$tipo){
 $sql="select * from planificacion.indicador_evaluacion indic
inner join planificacion.indeva_unidad_ano inde
on inde.id_indicador = indic.id_indicador
inner join planificacion.obj_hab oh on oh.id_obj = inde.id_obj
where inde.id_unidad = $unidad 
and oh.tipo=$tipo";	
$result = pg_exec($conn,$sql);
	return $result;
}


public function traeIndiUnidadO($conn,$unidad,$obj){
  $sql="select * from planificacion.indicador_evaluacion indic
inner join planificacion.indeva_unidad_ano inde
on inde.id_indicador = indic.id_indicador
inner join planificacion.obj_hab oh on oh.id_obj = inde.id_obj
where inde.id_unidad = $unidad 
and oh.id_obj=$obj";	
$result = pg_exec($conn,$sql);
	return $result;
}
}//fin clase

?>