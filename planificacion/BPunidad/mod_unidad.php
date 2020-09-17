<?php 
class Unidad{
	
	public function contructor(){
			
	}

public function traeCursos($conn,$ano){
	  $sql="SELECT id_curso,grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo AS curso, ensenanza FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo WHERE id_ano=".$ano." and ensenanza>10 ORDER BY ensenanza,curso ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	
	

}	


public function traeCursosUno($conn,$curso){
	 $sql="SELECT * FROM curso where id_curso=$curso ";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	
	

}


public function traeRamo($conn,$curso,$ramo=''){

 $qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, ramo.eee,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen, ramo.conexper,ramo.prueba_especial,ramo.bool_nquiz,ramo.conexquiz, ramo.coef2,ramo.bool_pu FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso."))";
 
 if($ramo){
$qry.=" and ramo.id_ramo=$ramo";
}
 
 $qry.=" order by ramo.id_orden";	
 
// echo $qry;		   
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
	 $sql="SELECT * FROM planificacion.ejes WHERE tipo=$tipo and cod_subsector=".$cod_ramo." and in (0,$rdb) order by texto";
	 
	//echo $sql."<br>";
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
   $sql="SELECT * FROM planificacion.obj_hab WHERE id_eje=$id_eje and tipo=$tipo and tipo_ense=$ense and grado=$grado and (rdb=$rdb or rdb=0) order by texto";
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

/********objetivos por año*********/
public function traeObjAnio($conn,$id_eje,$rdb,$unidad,$tipo){
   $sql="SELECT * FROM planificacion.obj_hab 
inner join planificacion.bp_unidad_anio_obj 
on planificacion.bp_unidad_anio_obj.id_obj = planificacion.obj_hab.id_obj
WHERE id_eje=$id_eje and planificacion.obj_hab.tipo=$tipo and   planificacion.bp_unidad_anio_obj.id_unidad=$unidad
and rdb in($rdb,0) order by codigo";
//echo $sql;
		$result = pg_exec($conn,$sql);
		//echo $sql."<br>";
		return $result;	
}	



/*****************/



public function guardaUnidad($conn,$rdb,$ano,$sel_curso,$sel_ramo,$docdicta,$txt_fechaini,$txt_fechater,$cant_clases,$txt_horas,$texto,$txt_nombre,$ciu){
	
	  $sql="insert into planificacion.bp_unidad(rdb,id_ano,id_curso,id_ramo,rut_emp,fecha_inicio,fecha_termino,cantidad_clases,nro_horas,texto,nombre,unidad_anual,estado) values ($rdb,$ano,$sel_curso,$sel_ramo,$docdicta,'$txt_fechaini','$txt_fechater',$cant_clases,$txt_horas,'".utf8_decode($texto)."','".utf8_decode($txt_nombre)."',$ciu,1)";
	$result = pg_exec($conn,$sql);
	
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	
}

public function ultimaUnidad($conn,$rdb){
 	$sql="select id_unidad from planificacion.bp_unidad where rdb=$rdb order by id_unidad desc limit 1";
	$result = pg_exec($conn,$sql);
	
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
}
	
public function guardaObjetivo($conn,$id_unidad,$id_obj){
	 $sql="insert into planificacion.bp_unidad_obj values($id_unidad,$id_obj);";
	$result = pg_exec($conn,$sql);
	
}	
	
public function listaUnidad($conn,$id_ano,$rdb,$curso,$ramo,$docente,$id_unidad){
	$sql="select planificacion.bp_unidad.* from planificacion.bp_unidad inner join curso 
	on planificacion.bp_unidad.id_curso = curso.id_curso
	where rdb=$rdb";
	
	if($id_ano>0){
	$sql.=" and planificacion.bp_unidad.id_ano=$id_ano";
	}
	
	if($curso>0){
	$sql.=" and planificacion.bp_unidad.id_curso=$curso";
	}
	
	if($ramo>0){
	$sql.=" and id_ramo=$ramo";
	}
	
	if($docente>0){
	$sql.=" and rut_emp=$docente";
	}
	
	if($id_unidad>0){
	$sql.=" and unidad_anual=$id_unidad";
	}
	
	$sql.=" order by curso.ensenanza,curso.grado_curso,curso.letra_curso,planificacion.bp_unidad.id_unidad ";
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
$sql="select * from planificacion.bp_unidad where id_unidad=$idUnidad";
 //echo $sql;
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
  $sql="select oh.* from planificacion.obj_hab oh inner join planificacion.bp_unidad_obj ob  on ob.id_obj = oh.id_obj
where oh.tipo=$tipo and ob.id_unidad=$idUnidad order by oh.id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}	

public function actualizaUnidad($conn,$idUnidad,$txt_fechaini,$txt_fechater,$cant_clases,$txt_horas,$texto,$txt_nombre){
 $sql= "update planificacion.bp_unidad set fecha_inicio='$txt_fechaini',fecha_termino='$txt_fechater',cantidad_clases=$cant_clases,nro_horas=$txt_horas,texto='".utf8_decode($texto)."',nombre='".utf8_decode($txt_nombre)."' where id_unidad=$idUnidad";
	
	$result = pg_exec($conn,$sql);
	return $result;	

}

public function eliminaObHa($conn,$idUnidad){

$sql="delete from planificacion.bp_unidad_obj where id_unidad=$idUnidad";
$result = pg_exec($conn,$sql);
	return $result;	

}

public function traeMarcado($conn,$idUnidad,$id_obj){
    $sql="select id_obj as marcado from planificacion.bp_unidad_obj where id_unidad=$idUnidad and id_obj=$id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}

public function existe($conn,$fecha_inicio,$fecha_termino,$id_curso,$id_ramo){
    $sql="select * from planificacion.unidad where id_curso=$id_curso and id_ramo=$id_ramo and fecha_inicio>='$fecha_inicio' AND fecha_termino<='$fecha_termino'";
 $result = pg_exec($conn,$sql);
	return $result;	
}


public function traeObjUnidadAll($conn,$idUnidad){
    $sql="select oh.* from planificacion.obj_hab oh inner join planificacion.unidad_obj ob  on ob.id_obj = oh.id_obj
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
	
public function cursoTieneRamo2($conn,$ano,$ramo,$curso){
   $sql="select r.id_ramo from ramo r
inner join curso c on c.id_curso = r.id_curso
where c.id_ano=$ano and r.cod_subsector=$ramo and c.id_curso=$curso";
$result = pg_exec($conn,$sql);
	return $result;
}


public function traeUnidadAnio($conn,$idUnidad){
  $sql="select * from planificacion.bp_unidad_anio where id_unidad=$idUnidad";
 //echo $sql;
	$result = pg_exec($conn,$sql);
	
	if(!$result)
		{
			return false;	
		}
		else{
			return $result;
		}

}

public function listaUnidadAnio($conn,$curso,$ramo){
 $sql="select * from planificacion.bp_unidad_anio where id_curso=$curso and id_ramo=$ramo";
//echo  $sql;
	$result = pg_exec($conn,$sql);
	
	if(!$result)
		{
			return false;	
		}
		else{
			return $result;
		}

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
and r.id_curso = $curso"; 
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
    $sql="insert into planificacion.unidad_observacion (id_unidad,fecha,observacion) values($unidad,'$fecha','".utf8_decode($observacion)."')";
$result = pg_exec($conn,$sql);
	return $result;
}

public function cambiaEstadoClaseUAnual($conn,$unidad,$estado){
   $sql="update planificacion.unidad set estado=$estado where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
	return $result;
}

public function traeEstadoClaseUno($conn,$estado){
 $sql="select * from planificacion.clase_estados where id_estado=$estado order by id_estado asc";
$result = pg_exec($conn,$sql);
	return $result;
}

public function cambiaRealizada($conn,$unidad,$estado){
    $sql="update planificacion.unidad set ejecutada=$estado where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
	return $result;
}
public function periodo($conn,$ano){
		$sql = "select * from periodo where id_ano = ".$ano." order by fecha_inicio";
		$result = pg_exec($conn,$sql);
	return $result;	
	}
	
	
public function marcanota($conn,$unidad,$periodo,$posicion,$ramo){
  $sql="select * from planificacion.unidad_nota where id_unidad=$unidad and id_periodo=$periodo and id_ramo=$ramo and posicion_nota=$posicion";
$result = pg_exec($conn,$sql);
	return $result;	

}

public function borraNota($conn,$unidad,$periodo){
   $sql="delete from planificacion.unidad_nota where id_unidad=$unidad and id_periodo=$periodo";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaNota($conn,$unidad,$periodo,$posicion,$ramo){
 $sql="insert into planificacion.unidad_nota values($unidad,$periodo,$posicion,$ramo)";
$result = pg_exec($conn,$sql);
return $result;	
}

public function traearchivo($conn,$unidad){
     $sql="select * from planificacion.bp_unidad_archivo where id_unidad=$unidad and visible=1";
$result = pg_exec($conn,$sql);
return $result;	
}

public function pisaArchivos($conn,$unidad){
    $sql="update planificacion.unidad_archivo set visible=0 where id_unidad=$unidad and visible=1";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaArchivos($conn,$unidad,$ruta){
    $sql="insert into planificacion.unidad_archivo(id_unidad,ruta,visible) values ($unidad,'$ruta',1)";
$result = pg_exec($conn,$sql);
return $result;	
}

public function tejeUnidad($conn,$unidad){
	  $sql="select DISTINCT(tob.id_objetivo),tob.nombre from planificacion.tipo_objetivo tob
inner join planificacion.obj_hab oh on oh.tipo =tob.id_objetivo
left join  planificacion.bp_unidad_anio_obj ob on ob.id_obj = oh.id_obj
where ob.id_unidad=$unidad order by tob.id_objetivo";
$result = pg_exec($conn,$sql);
return $result;		
	}
	
	
	public function ejeDeUnidad($conn,$unidad,$tipo,$rdb,$cod_ramo){
	  $sql="SELECT DISTINCT(pe.id_eje),pe.texto FROM planificacion.ejes pe
inner join planificacion.obj_hab oh on pe.id_eje = oh.id_eje
inner join planificacion.bp_unidad_anio_obj ao on ao.id_obj = oh.id_obj
WHERE ao.id_unidad=$unidad and pe.tipo=$tipo and cod_subsector=$cod_ramo and pe.rdb in(0,$rdb) order by pe.texto";
$result = pg_exec($conn,$sql);
return $result;		
	}
	
/*******************************************************/	
public function traeClases($conn,$unidad){
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

/******************************************************/

//borro unidad
public function archivoUnidadT($conn,$unidad){
   $sql="select * from planificacion.unidad_archivo where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}


public function delObsUnidad($conn,$unidad){
   $sql="delete from planificacion.unidad_observacion where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delArchivoUnidad($conn,$unidad){
   $sql="delete from planificacion.unidad_archivo where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delObjUnidad($conn,$unidad){
   $sql="delete from planificacion.unidad_obj where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delNotaUnidad($conn,$unidad){
   $sql="delete from planificacion.unidad_nota where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

public function delUnidad($conn,$unidad){
   $sql="delete from planificacion.unidad where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

//indicador
public function guardaIndicador($conn,$unidad,$indicador){
$sql="insert into planificacion.bp_unidad_indicador values($unidad,$indicador)";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaIndicadorSel($conn,$unidad,$iobj,$indicador){
$sql="insert into planificacion.bp_unidad_indicador values($unidad,$iobj,$indicador)";
$result = pg_exec($conn,$sql);
return $result;	
}

public function borra($conn,$unidad){
$sql="delete from planificacion.bp_unidad_indicador where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

//indicador
public function buscaIndicador($conn,$id_obj){
 $sql="select * from planificacion.indicador_evaluacion where id_obj=$id_obj";
$result = pg_exec($conn,$sql);
return $result;	
}


public function buscaIndicadorSel($conn,$id_obj,$uano){
$sql="select indic.* from planificacion.indicador_evaluacion indic
inner join planificacion.bp_unidad_anio_indicador inde
on inde.id_indicador = indic.id_indicador
where inde.id_obj =$id_obj and inde.id_unidad=$uano";
$result = pg_exec($conn,$sql);
return $result;	
}

public function buscaIndicadorSel2($conn,$id_obj,$uni){
 $sql="select indic.* from planificacion.indicador_evaluacion indic
inner join planificacion.bp_unidad_indicador inde
on inde.id_indicador = indic.id_indicador
where inde.id_obj =$id_obj and inde.id_unidad=$uni";
$result = pg_exec($conn,$sql);
return $result;	
}

public function tipoEjesBloqueUnidadInd($conn,$unidad,$tipo){
	      $sql="select DISTINCT(tej.id_eje),tej.texto 
from planificacion.ejes tej 
inner join planificacion.obj_hab oh on oh.id_eje = tej.id_eje
inner join planificacion.bp_unidad_obj ob on ob.id_obj = oh.id_obj
where ob.id_unidad=$unidad and tej.tipo=$tipo order by tej.texto";
$result =pg_exec($conn,$sql);
		
		return $result;
	}
	
public function traeObjeUnidadInd($conn,$eje,$tipo,$unidad){
 $sql="select oh.* from planificacion.obj_hab oh 
inner join planificacion.bp_unidad_obj ob on ob.id_obj = oh.id_obj 
where oh.tipo=$tipo and id_eje =$eje  and ob.id_unidad=$unidad order by oh.id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}

public function traeIndiUnidadC($conn,$unidad,$tipo){
  $sql="select * from planificacion.indicador_evaluacion indic
inner join planificacion.bp_unidad_indicador inde
on inde.id_indicador = indic.id_indicador
inner join planificacion.obj_hab oh on oh.id_obj = inde.id_obj
where inde.id_unidad = $unidad 
and oh.tipo=$tipo";	
$result = pg_exec($conn,$sql);
	return $result;
}

public function traeIndiUnidadO($conn,$unidad,$tipo){
   $sql="select * from planificacion.indicador_evaluacion indic
inner join planificacion.bp_unidad_indicador inde
on inde.id_indicador = indic.id_indicador
inner join planificacion.obj_hab oh on oh.id_obj = inde.id_obj
where inde.id_unidad = $unidad 
and oh.id_obj=$tipo";	
$result = pg_exec($conn,$sql);
	return $result;
}

public function borraIndicador($conn,$unidad){
 $sql="delete from planificacion.bp_unidad_indicador where id_unidad=$unidad";
$result = pg_exec($conn,$sql);
	return $result;
}

}//fin clase

?>