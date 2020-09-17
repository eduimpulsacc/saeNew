<?php 
class Clase{
	
	public function contructor(){
			
	}

public function traeUnidad($conn,$idUnidad){
 $sql="select * from planificacion.unidad where id_unidad=$idUnidad";
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


public function traeDocente($conn,$rdb,$cod_ramo){
  $qry = "SELECT distinct (e.rut_emp), e.dig_rut, 
e.nombre_emp, e.ape_pat, e.ape_mat,t.cargo FROM empleado e
inner join trabaja t on t.rut_emp=e.rut_emp and t.cargo in (5)
INNER JOIN institucion ON t.rdb = institucion.rdb 
inner join dicta d on e.rut_emp = d.rut_emp
inner join ramo r on r.id_ramo = d.id_ramo
WHERE institucion.rdb=$rdb
and r.cod_subsector=$cod_ramo"; 
$result = pg_exec($conn,$qry);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
}

public function traeRamoUno($conn,$ramo){
	 $sql="SELECT * FROM ramo WHERE  id_ramo=".$ramo;
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

public function tipoClase($conn){
 $sql="select * from planificacion.clase_tipo";
$result = pg_exec($conn,$sql);
return $result;	
}

public function traeRecurso($conn,$institucion){
  $sql="select * from planificacion.recursos where rdb=0 or rdb=$institucion";
$result = pg_exec($conn,$sql);
return $result;	
}


public function guardaRecurso($conn,$nombre,$ins){
 $sql="insert into planificacion.recursos (rdb,nombre) values($ins,'".utf8_decode($nombre)."')";
$result = pg_exec($conn,$sql);
	//	echo $sql."<br>";
		return $result;	
}

public function traeUltimoRecurso($conn,$institucion){
  $sql="select * from planificacion.recursos where rdb=0 or rdb=$institucion order by id_recurso desc limit 1";
$result = pg_exec($conn,$sql);
return $result;	
}


public function traeObjUnidad($conn,$tipo,$idUnidad){
       $sql="select oh.* from planificacion.obj_hab oh inner join planificacion.unidad_obj ob  on ob.id_obj = oh.id_obj
where oh.tipo=$tipo and ob.id_unidad=$idUnidad order by oh.id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}	

public function guardaClase($conn,$iunidad,$icurso,$iramo,$cmbDocente,$txt_nombre,$cmb_tipo,$f_inicio,$f_termino,$txt_evaluacion,$txt_inicio,$txt_desarrollo,$txt_cierre,$txt_actitudes,$cant_clases,$cant_horas){
	
	 $sql="insert into planificacion.clase(id_unidad, id_curso, id_ramo, rut_emp, nombre, tipo, fecha_inicio, fecha_termino, evaluacion, inicio, desarrollo, cierre, actitudes,cant_clase,cant_hora) values($iunidad,$icurso,$iramo,$cmbDocente,'".utf8_decode($txt_nombre)."',$cmb_tipo,'$f_inicio','$f_termino','".utf8_decode($txt_evaluacion)."','".utf8_decode($txt_inicio)."','".utf8_decode($txt_desarrollo)."','".utf8_decode($txt_cierre)."','".utf8_decode($txt_actitudes)."',$cant_clases,$cant_horas)";
	$result = pg_exec($conn,$sql) or die("fallo clase: ".$sql);
	return $result;	
	
}

public function ultimaClase($conn,$unidad){
  $sql="select * from planificacion.clase where id_unidad=$unidad order by id_clase desc limit 1";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaClaseRecurso($conn,$clase,$rec){
    $sql="insert into planificacion.clase_recurso values($clase,$rec)";
$result = pg_exec($conn,$sql);
return $result;	

}

public function guardaObjetivo($conn,$clase,$id_obj){
 $sql="insert into planificacion.clase_obj values($clase,$id_obj);";
$result = pg_exec($conn,$sql);
return $result;
	
}	



public function traeClases($conn,$unidad){
 $sql="select * from planificacion.clase where id_unidad=$unidad order by id_clase";
$result = pg_exec($conn,$sql);
return $result;
}

public function traeClaseUno($conn,$clase){
  $sql="select * from planificacion.clase where id_clase=$clase";
$result = pg_exec($conn,$sql);
return $result;	
}

public function tipoClaseUno($conn,$tipo){
  $sql="select * from planificacion.clase_tipo where id_tipo=$tipo";
$result = pg_exec($conn,$sql);
return $result;	
}

public function listaRecursosClase($conn,$clase){
  $sql = "select * from planificacion.recursos inner join planificacion.clase_recurso
on planificacion.clase_recurso.id_recurso = planificacion.recursos.id_recurso
where planificacion.clase_recurso.id_clase =  $clase";
$result = pg_exec($conn,$sql);
return $result;	
}

public function traeObjclase($conn,$tipo,$clase){
      $sql="select oh.* from planificacion.obj_hab oh inner join planificacion.clase_obj ob  on ob.id_obj = oh.id_obj
where oh.tipo=$tipo and ob.id_clase=$clase order by oh.id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}


public function recursoNoSE($conn,$clase,$rdb){
	
 $sql="select * from planificacion.recursos pr 
where rdb in (0,$rdb) and pr.id_recurso not IN
(select id_recurso from planificacion.clase_recurso where id_clase=$clase) order by pr.nombre";	
$result = pg_exec($conn,$sql);
	return $result;
}


public function traeMarcado($conn,$clase,$id_obj){
     $sql="select id_obj as marcado from planificacion.clase_obj where id_clase=$clase and id_obj=$id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}

public function modificaClase($conn,$cmbDocente,$txt_nombre,$cmb_tipo,$f_inicio,$f_termino,$txt_evaluacion,$txt_inicio,$txt_desarrollo,$txt_cierre,$txt_actitudes,$cant_clase,$cant_hora,$id_clase){

 $sql="update planificacion.clase set rut_emp=$cmbDocente,nombre='$txt_nombre',tipo=$cmb_tipo,fecha_inicio ='$f_inicio',fecha_termino='$f_termino',evaluacion='$txt_evaluacion',inicio='$txt_inicio',desarrollo='$txt_desarrollo',cierre='$txt_cierre',actitudes='$txt_actitudes',cant_clase=$cant_clase,cant_hora=$cant_hora,estado=3,fecha_modificacion='".date("Y-m-d")."' where id_clase=$id_clase";

$result = pg_exec($conn,$sql);
	return $result;	

}

public function eliminaObHa($conn,$idclase){

 $sql="delete from planificacion.clase_obj where id_clase=$idclase";
$result = pg_exec($conn,$sql);
	return $result;	

}

public function eliminaRec($conn,$idclase){

$sql="delete from planificacion.clase_recurso where id_clase=$idclase";
$result = pg_exec($conn,$sql);
	return $result;	

}

public function traeEstadoClase($conn){
$sql="select * from planificacion.clase_estados order by id_estado asc";
$result = pg_exec($conn,$sql);
	return $result;
}

public function traeEstadoClaseUno($conn,$estado){
$sql="select * from planificacion.clase_estados where id_estado=$estado order by id_estado asc";
$result = pg_exec($conn,$sql);
	return $result;
}

public function traeHistorialcambios($conn,$clase){
 $sql="select * from planificacion.clase_observacion where id_clase=$clase order by fecha,id_observacion asc";
$result = pg_exec($conn,$sql);
	return $result;
}

public function guardaHistorialcambios($conn,$clase,$fecha,$observacion){
  $sql="insert into planificacion.clase_observacion (id_clase,fecha,observacion) values($clase,'$fecha','".utf8_decode($observacion)."')";
$result = pg_exec($conn,$sql);
	return $result;
}

public function cambiaEstadoClase($conn,$clase,$estado){
  $sql="update planificacion.clase set estado=$estado where id_clase=$clase";
$result = pg_exec($conn,$sql);
	return $result;
}

public function cambiaRealizada($conn,$clase,$estado){
   $sql="update planificacion.clase set ejecutada=$estado where id_clase=$clase";
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

public function listaUnidad($conn,$curso){
	$sql="select * from planificacion.unidad where id_curso=$curso";
	$result = pg_exec($conn,$sql);
	return $result;
}	


public function traecodRamo2($conn,$curso,$cod_ramo){
	 $sql="SELECT * from ramo WHERE id_curso=".$curso." and cod_subsector=$cod_ramo";
	 
	// echo $sql."<br>";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
public function traeObjclaseAll($conn,$clase){
        $sql="select oh.* from planificacion.obj_hab oh inner join planificacion.clase_obj ob  on ob.id_obj = oh.id_obj
where  ob.id_clase=$clase order by oh.id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}

public function periodo($conn,$ano){
		$sql = "select * from periodo where id_ano = ".$ano." order by fecha_inicio";
		$result = pg_exec($conn,$sql);
	return $result;	
	}
	
public function marcanota($conn,$clase,$unidad,$periodo,$posicion,$ramo){
  $sql="select * from planificacion.clase_nota where id_unidad=$unidad and id_periodo=$periodo and id_ramo=$ramo and posicion_nota=$posicion";
$result = pg_exec($conn,$sql);
	return $result;	

}

public function borraNota($conn,$clase,$unidad,$periodo){
  $sql="delete from planificacion.clase_nota where id_clase=$clase and id_unidad=$unidad and id_periodo=$periodo";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaNota($conn,$clase,$unidad,$periodo,$posicion,$ramo){
$sql="insert into planificacion.clase_nota values($clase,$unidad,$periodo,$posicion,$ramo)";
$result = pg_exec($conn,$sql);
return $result;	
}

public function traeLeccionario($conn,$ramo,$nota,$periodo){
 $sql="select * from lexionario where id_ramo=$ramo and nota=$nota and id_periodo=$periodo";
$result = pg_exec($conn,$sql);
return $result;	
}

public function traeTipoLeccionario($conn,$ramo,$curso,$ano){
  $sql="select * from tipo_lexionario where id_ramo=$ramo and id_curso=$curso and id_ano=$ano order by nombre";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaLeccionario($conn,$id_ano,$id_curso,$id_ramo,$fecha,$descripcion,$tipo,$nota,$id_periodo){
	
  $sql="insert into lexionario (id_ano,id_curso,id_ramo,fecha,descripcion,tipo,nota,id_periodo) values ($id_ano,$id_curso,$id_ramo,'$fecha','".utf8_decode($descripcion)."',$tipo,$nota,$id_periodo)";
$result = pg_exec($conn,$sql);
return $result;		
}

public function eliminaLeccionario($conn,$id_leccionario){
 $sql="delete from lexionario where id_lexionario=".$id_leccionario;
$result = pg_exec($conn,$sql);
return $result;	

}

public function traeLeccionarioUno($conn,$id_lexionario){
 $sql="select * from lexionario where id_lexionario=$id_lexionario";
$result = pg_exec($conn,$sql);
return $result;	
}

public function actualizaLeccionario($conn,$fecha,$descripcion,$tipo,$id_lexionario){
	
  $sql="update lexionario set fecha='$fecha',descripcion='".utf8_decode($descripcion)."',tipo=$tipo where id_lexionario=$id_lexionario";
$result = pg_exec($conn,$sql);
return $result;		
}

public function guardaTipoLeccionario($conn,$ramo,$curso,$ano,$nombre){
	
   $sql="insert into tipo_lexionario (id_curso,id_ramo,id_ano,nombre) values ($curso,$ramo,$ano,'".utf8_decode($nombre)."')";
$result = pg_exec($conn,$sql);
return $result;		
}

public function traearchivo($conn,$clase){
   $sql="select * from planificacion.clase_archivo where id_clase=$clase and visible=1";
$result = pg_exec($conn,$sql);
return $result;	
}

public function pisaArchivos($conn,$clase){
   $sql="update planificacion.clase_archivo set visible=0 where id_clase=$clase and visible=1";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaArchivos($conn,$clase,$ruta){
   $sql="insert into planificacion.clase_archivo(id_clase,ruta,visible) values ($clase,'$ruta',1)";
$result = pg_exec($conn,$sql);
return $result;	
}

public function traeTipoEva($conn,$rdb){
	 $sql="select * from planificacion.tipoevaluacion where rdb in(0,$rdb) order by nombre";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardatipo($conn,$nombre,$ins){
 $sql="insert into planificacion.tipoevaluacion (rdb,nombre) values($ins,'".utf8_decode($nombre)."')";
$result = pg_exec($conn,$sql);
	//	echo $sql."<br>";
		return $result;	
}

public function traeUltimotipo($conn,$institucion){
  $sql="select * from planificacion.tipoevaluacion where rdb=0 or rdb=$institucion order by id_tipo desc limit 1";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaEva($conn,$clase,$tip){
    $sql="insert into planificacion.clase_tipoevaluacion values($clase,$tip)";
$result = pg_exec($conn,$sql);
return $result;	
}

public function listaEvaluacionClase($conn,$clase){
  $sql = "select * from planificacion.tipoevaluacion a inner join planificacion.clase_tipoevaluacion b
on a.id_tipo = b.id_tipo
where b.id_clase =  $clase";
$result = pg_exec($conn,$sql);
return $result;	
}

public function tipoevaNoSE($conn,$clase,$rdb){
	
 $sql="select * from planificacion.tipoevaluacion pr 
where rdb in (0,$rdb) and pr.id_tipo not IN
(select id_tipo from planificacion.clase_tipoevaluacion where id_clase=$clase) order by pr.nombre";	
$result = pg_exec($conn,$sql);
	return $result;
}

public function eliminaEva($conn,$idclase){

$sql="delete from planificacion.clase_tipoevaluacion where id_clase=$idclase";
$result = pg_exec($conn,$sql);
	return $result;	

}


public function tejeUnidad($conn,$unidad){
	    $sql="select DISTINCT(tob.id_objetivo),tob.nombre from planificacion.tipo_objetivo tob
inner join planificacion.obj_hab oh on oh.tipo =tob.id_objetivo
left join  planificacion.unidad_obj ob on ob.id_obj = oh.id_obj
where ob.id_unidad=$unidad order by tob.id_objetivo
";
$result = pg_exec($conn,$sql);
return $result;	
	}
	
	
	public function tejeClase($conn,$clase){
	$sql="select DISTINCT(tob.id_objetivo),tob.nombre 
from planificacion.tipo_objetivo tob 
inner join planificacion.obj_hab oh on oh.tipo =tob.id_objetivo 
left join planificacion.clase_obj ob on ob.id_obj = oh.id_obj where ob.id_clase=$clase order by tob.id_objetivo";	
$result = pg_exec($conn,$sql);
return $result;
	}
	
	public function ejeDeClase($conn,$clase,$tipo,$rdb,$cod_ramo){
	 $sql="SELECT DISTINCT(pe.id_eje),pe.texto FROM planificacion.ejes pe
inner join planificacion.obj_hab oh on pe.id_eje = oh.id_eje
inner join planificacion.clase_obj ao on ao.id_obj = oh.id_obj
WHERE ao.id_clase=$clase and pe.tipo=$tipo and cod_subsector=$cod_ramo and pe.rdb in(0,$rdb) order by pe.texto";
$result = pg_exec($conn,$sql);
return $result;	;	
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

//indicador
public function guardaIndicador($conn,$clase,$indicador){
$sql="insert into planificacion.indeva_unidad_clase values($clase,$indicador)";
$result = pg_exec($conn,$sql);
return $result;	
}

public function borra($conn,$clase){
$sql="delete from planificacion.indeva_clase where id_clase=$clase";
$result = pg_exec($conn,$sql);
return $result;	
}

//indicador
public function buscaIndicador($conn,$id_obj){
$sql="select * from planificacion.indicador_evaluacion where id_obj=$id_obj";
$result = pg_exec($conn,$sql);
return $result;	
}

public function tipoEjesBloqueClaseInd($conn,$clase,$tipo){
	       $sql="select DISTINCT(tej.id_eje),tej.texto 
from planificacion.ejes tej 
inner join planificacion.obj_hab oh on oh.id_eje = tej.id_eje
inner join planificacion.clase_obj ob on ob.id_obj = oh.id_obj
where ob.id_clase=$clase and tej.tipo=$tipo order by tej.texto";
$result =pg_exec($conn,$sql);
		
		return $result;
	}
	
public function traeObjeclaseInd($conn,$eje,$tipo,$clase){
   $sql="select oh.* from planificacion.obj_hab oh 
inner join planificacion.clase_obj ob on ob.id_obj = oh.id_obj 
where oh.tipo=$tipo and id_eje =$eje  and ob.id_clase=$clase order by oh.id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}	

public function buscaIndicadorSel($conn,$id_obj,$uano){
$sql="select indic.* from planificacion.indicador_evaluacion indic
inner join planificacion.indeva_unidad inde
on inde.id_indicador = indic.id_indicador
where inde.id_obj =$id_obj and inde.id_unidad=$uano";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaIndicadorSel($conn,$clase,$iobj,$indicador){
 $sql="insert into planificacion.indeva_clase values($clase,$iobj,$indicador)";
$result = pg_exec($conn,$sql);
return $result;	
}

public function traeIndiClaseO($conn,$clase,$tipo){
   $sql="select * from planificacion.indicador_evaluacion indic
inner join planificacion.indeva_clase inde
on inde.id_indicador = indic.id_indicador
inner join planificacion.obj_hab oh on oh.id_obj = inde.id_obj
where inde.id_clase = $clase 
and oh.id_obj=$tipo";	
$result = pg_exec($conn,$sql);
	return $result;
}

public function traeIndiUnidadC($conn,$unidad,$tipo){
    $sql="select * from planificacion.indicador_evaluacion indic
inner join planificacion.indeva_clase inde
on inde.id_indicador = indic.id_indicador
inner join planificacion.obj_hab oh on oh.id_obj = inde.id_obj
where inde.id_clase = $unidad 
and oh.tipo=$tipo";	
$result = pg_exec($conn,$sql);
	return $result;
}

public function borraIndicador($conn,$clase){
$sql="delete from planificacion.indeva_clase where id_clase=$clase";
$result = pg_exec($conn,$sql);
return $result;	
}

public function buscaIndicadorSel2($conn,$id_obj,$uni){
 
 $sql="select indic.* from planificacion.indicador_evaluacion indic
inner join planificacion.indeva_clase inde
on inde.id_indicador = indic.id_indicador
where inde.id_obj =$id_obj and inde.id_clase=$uni";
$result = pg_exec($conn,$sql);
return $result;	
}

}//fin clase