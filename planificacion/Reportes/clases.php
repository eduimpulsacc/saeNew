<? 
class Reporte{
	
	public function Membrete($conn,$rdb){
		$sql="SELECT * FROM institucion WHERE rdb=".$rdb;
		$result = pg_exec($conn,$sql);
		$fila = pg_fetch_array($result,0);
		
		return $fila;
	}
	
	public function Docente($conn,$rut){
		$sql="SELECT * FROM empleado WHERE rut_emp=".$rut;
		$result = pg_exec($conn,$sql);
		$fila = pg_fetch_array($result,0);
		
		return $fila;
	}
	
	public function Ano($conn,$ano){
		$sql="SELECT * FROM ano_Escolar WHERE id_ano=".$ano;
		$result = pg_exec($conn,$sql);
		$fila = pg_fetch_array($result,0);
		
		return $fila;	
	}
	
	public function Periodo($conn,$ano,$periodo=""){
		$sql="SELECT * FROM periodo WHERE id_ano=".$ano;
		
		if($periodo!=0 && $periodo != ""){
		$sql.=" and id_periodo=$periodo";
		}
		
		//echo $sql;
		
		$result = pg_exec($conn,$sql);
		//$fila = pg_fetch_array($result,0);
		
		return $result;	
	}
	public function Supervisa($conn,$curso){
		$sql="SELECT e.nombre_emp ||' '|| e.ape_pat ||' '|| e.ape_mat as nombre FROM supervisa s INNER JOIN curso c ON c.id_curso=s.id_curso INNER JOIN empleado e ON e.rut_emp=s.rut_emp WHERE c.id_curso=".$curso;
		$result = pg_exec($conn,$sql);	
		$nombre = pg_result($result,0);
		return $nombre;	
	}
	public function Dicta($conn,$rut,$ano){
		$sql="SELECT DISTINCT a.nombre,a.cod_subsector,r.id_ramo
				FROM dicta d 
				INNER JOIN ramo r ON r.id_ramo=d.id_ramo
				INNER JOIN curso c ON r.id_curso=c.id_curso 
				INNER JOIN subsector a ON a.cod_subsector=r.cod_subsector  WHERE id_ano=".$ano." AND rut_emp=".$rut;
				//echo "<br>".$sql;
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Dicta2($conn,$rut,$ano){
		$sql="SELECT DISTINCT a.nombre,a.cod_subsector
				FROM dicta d 
				INNER JOIN ramo r ON r.id_ramo=d.id_ramo
				INNER JOIN curso c ON r.id_curso=c.id_curso 
				INNER JOIN subsector a ON a.cod_subsector=r.cod_subsector  WHERE id_ano=".$ano." AND rut_emp=".$rut;
				//echo "<br>".$sql;
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function CursoDicta($conn,$ano,$rut,$cod_subsector){
		 $sql="SELECT c.id_curso,d.id_ramo
				FROM dicta d 
				INNER JOIN ramo r ON r.id_ramo=d.id_ramo 
				INNER JOIN curso c ON r.id_curso=c.id_curso 
				INNER JOIN subsector a ON a.cod_subsector=r.cod_subsector 
				WHERE id_ano=".$ano." AND rut_emp=".$rut." and a.cod_subsector=".$cod_subsector."
				ORDER BY ensenanza, grado_curso, letra_curso ASC";
		$result = pg_exec($conn,$sql);
		//echo "<br>".$sql;
		
		return $result;
	}
	
	public function CursoDicta2($conn,$ano,$rut,$cod_subsector,$curso){
		  $sql="SELECT d.id_ramo,c.id_curso
				FROM dicta d 
				INNER JOIN ramo r ON r.id_ramo=d.id_ramo 
				INNER JOIN curso c ON r.id_curso=c.id_curso 
				INNER JOIN subsector a ON a.cod_subsector=r.cod_subsector 
				WHERE id_ano=".$ano." AND rut_emp=".$rut." and a.cod_subsector=".$cod_subsector."
				and r.id_curso = $curso
				ORDER BY ensenanza, grado_curso, letra_curso ASC";
		$result = pg_exec($conn,$sql);
		//echo "<br>".$sql;
		
		return $result;
	}
	
	
	public function Unidad($conn,$ano,$curso,$ramo){
	 	$sql="SELECT * FROM planificacion.unidad WHERE id_ano=".$ano." AND id_curso=".$curso." AND id_ramo=".$ramo." ORDER BY fecha_inicio ASC";
		$result =pg_exec($conn,$sql);
		
		return $result;	
	}
	
	
	public function UnidadIID($conn,$unidad){
	 	$sql="SELECT * FROM planificacion.unidad WHERE id_unidad=".$unidad;
		$result =pg_exec($conn,$sql);
		
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

public function traeObjUnidad($conn,$tipo,$idUnidad){
     $sql="select oh.* from planificacion.obj_hab oh inner join planificacion.unidad_obj ob  on ob.id_obj = oh.id_obj
where oh.tipo=$tipo and ob.id_unidad=$idUnidad order by oh.id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}


public function traeClases($conn,$unidad){
  $sql="select * from planificacion.clase where id_unidad=$unidad order by id_clase";
$result = pg_exec($conn,$sql);
return $result;
}

public function traeEstadoClaseUno($conn,$estado){
$sql="select * from planificacion.clase_estados where id_estado=$estado order by id_estado asc";
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
where planificacion.clase_recurso.id_clase =  $clase order by nombre";
$result = pg_exec($conn,$sql);
return $result;	
}

public function traeObjclase($conn,$tipo,$clase){
   $sql="select oh.* from planificacion.obj_hab oh inner join planificacion.clase_obj ob  on ob.id_obj = oh.id_obj
where oh.tipo=$tipo and ob.id_clase=$clase order by oh.id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}

public function traeClaseUno($conn,$clase){
  $sql="select * from planificacion.clase where id_clase=$clase";
$result = pg_exec($conn,$sql);
return $result;	
}

public function traeUnidadUno($conn,$unidad){
		 $sql="SELECT * FROM planificacion.unidad WHERE id_unidad=$unidad ";
		$result =pg_exec($conn,$sql);
		
		return $result;	
	}


public function traeClasesRealizadas($conn,$ano,$curso,$rut_emp,$ejecutada){
$sql="select cl.*,un.nombre as nom_unidad from planificacion.clase cl
inner join planificacion.unidad un on un.rut_emp = cl.rut_emp
where un.id_ano =$ano and cl.id_curso=$curso and cl.rut_emp=$rut_emp and cl.ejecutada=$ejecutada";
$result = pg_exec($conn,$sql);
return $result;	
}


public function traeClasesRamo($conn,$ano,$curso,$ramo,$rut_emp){
	$sql="select cl.*,un.nombre as nom_unidad from planificacion.clase cl
	inner join planificacion.unidad un on un.rut_emp = cl.rut_emp
	where un.id_ano =$ano and cl.id_curso=$curso and cl.id_ramo = $ramo and cl.rut_emp=$rut_emp order by id_clase";
	$result = pg_exec($conn,$sql);
	return $result;		
}

public function traeObsclase($conn,$clase){
$sql="select * from planificacion.clase_observacion where id_clase = $clase order by id_observacion";
$result = pg_exec($conn,$sql);
return $result;		
}

public function tieneElRamo($conn,$curso,$ramo,$nro_ano,$tipo_clase){
	if($tipo_clase==2){
		$tipo=1;	
	}else{
		$tipo=0;
	}
	$sql="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno INNER JOIN matricula ON matricula.rut_alumno=alumno.rut_alumno AND tiene$nro_ano.rut_alumno=matricula.rut_alumno and tiene$nro_ano.id_curso=matricula.id_curso and matricula.ben_pie=".$tipo.")   WHERE (((tiene$nro_ano.id_ramo)=".$ramo.") AND((tiene$nro_ano.id_curso)=".$curso.")) order by nro_lista,ape_pat, ape_mat, nombre_alu asc ";
	$result = pg_exec($conn,$sql);
	return $result;	
}

public function posicionNotas($conn,$unidad,$periodo,$ramo,$clase=""){
$sql="select posicion_nota from planificacion.clase_nota where id_unidad = $unidad and id_periodo = $periodo and id_ramo = $ramo";

if($clase!=0 && $clase != ""){
$sql.=" and id_clase= $clase ";
}

$sql.=" order by posicion_nota ";

//echo $sql;
$result = pg_exec($conn,$sql);
return $result;
}

public function traePromedio($conn,$nro_ano,$posicion,$conteo,$alumno,$ramo,$periodo){
 $sql ="select ($posicion)/$conteo from notas$nro_ano where rut_alumno=$alumno and id_ramo =$ramo and id_periodo=$periodo";

$fila = pg_fetch_array($result,0);
return $fila;
	
}

public function traeNotas($conn,$nro_ano,$posicion,$alumno,$ramo,$periodo){
 $sql ="select $posicion from notas$nro_ano where rut_alumno=$alumno and id_ramo =$ramo and id_periodo=$periodo";

//echo $sql;
$result = pg_exec($conn,$sql);
return $result;
	
} 

public function PromedioRamo($conn,$periodo,$ramo,$nro_ano){
	 $sql="SELECT avg(cast(promedio as integer)) FROM notas$nro_ano WHERE id_periodo=".$periodo." AND id_ramo=".$ramo." and promedio !='0'";
	$result = pg_exec($conn,$sql);
	
	return round(pg_result($result,0),0);;	
}

public function rangoEscala($conn,$ano,$rango){
$sql="select * from planificacion.escala where id_ano=$ano and inicio<=$rango and termino>=$rango";
$result = pg_exec($conn,$sql);
return $result;	
}

public function rangoEscalaTodo($conn,$ano){
 $sql="select * from planificacion.escala where id_ano=$ano order by id_escala asc";
$result = pg_exec($conn,$sql);
return $result;	
}

public function Grados($conn,$ano){
		 $sql="select DISTINCT(c.ensenanza),c.grado_curso,e.nombre_tipo
from curso c
INNER JOIN tipo_ensenanza e on e.cod_tipo = c.ensenanza
where id_ano =$ano order by ensenanza";
		$result = pg_exec($conn,$sql);
return $result;	
	}
	
	
public function EnsenanzaUno($conn,$ense){
	$sql="select * from tipo_ensenanza where cod_tipo = $ense";
	$result = pg_exec($conn,$sql);
	return $result;	
}


public function CodRamoUno($conn,$codramo){
		$sql="SELECT cod_subsector,nombre from subsector where cod_subsector=$codramo ";
		$result = pg_exec($conn,$sql);
		return $result;
	}
	
	
public function DictaRamo($conn,$ramo){
	$sql="select * from empleado
	inner join dicta on dicta.rut_emp = empleado.rut_emp
	inner join ramo on ramo.id_ramo = dicta.id_ramo
	where ramo.id_ramo = $ramo;
	";
	$result = pg_exec($conn,$sql);
	
	return $result;
}

public function promedioCurso($conn,$nro_ano,$periodo,$ramo){
  $sql="select promedio from notas$nro_ano 
where promedio NOT IN ('MB','B','S','I','0',' ','P','AL','L','NL','G','RV','N') 
and id_periodo = $periodo and id_ramo = $ramo";
$result = pg_exec($conn,$sql);
		
		return $result;
}

public function traeUnidadRamoRocente($conn,$ano,$docente,$ramo){
		  $sql="SELECT * FROM planificacion.unidad WHERE id_ano=$ano and rut_emp=$docente and id_ramo =$ramo  ";
		$result =pg_exec($conn,$sql);
		
		return $result;	
	}
	
public function ejesUnidad($conn,$unidad){
	   $sql="select DISTINCT(tob.id_objetivo),tob.nombre from planificacion.tipo_objetivo tob
inner join planificacion.obj_hab oh on oh.tipo =tob.id_objetivo
left join  planificacion.unidad_obj ob on ob.id_obj = oh.id_obj
where ob.id_unidad=$unidad order by tob.id_objetivo
";
$result =pg_exec($conn,$sql);
		
		return $result;
	}

public function tipoEjesUnidad($conn,$unidad){
	    $sql="select DISTINCT(tej.id_eje),tej.texto 
from planificacion.ejes tej 
inner join planificacion.obj_hab oh on oh.id_eje = tej.id_eje
inner join planificacion.unidad_anio_obj ob on ob.id_obj = oh.id_obj
where ob.id_unidad=$unidad order by tej.texto";
$result =pg_exec($conn,$sql);
		
		return $result;
	}


//////////////////anual
public function UnidadAnio($conn,$ano,$curso,$ramo){
		$sql="SELECT * FROM planificacion.unidad_anio WHERE id_ano=".$ano." AND id_curso=".$curso." AND id_ramo=".$ramo." ORDER BY fecha_inicio ASC";
		$result =pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function ejesUnidadAnio($conn,$unidad){
	    $sql="select DISTINCT(tob.id_objetivo),tob.nombre,oh.id_eje from planificacion.tipo_objetivo tob
inner join planificacion.obj_hab oh on oh.tipo =tob.id_objetivo
left join  planificacion.unidad_anio_obj ob on ob.id_obj = oh.id_obj
where ob.id_unidad=$unidad order by tob.id_objetivo
";
$result =pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function traeObjUnidadAnio($conn,$tipo,$idUnidad){
     $sql="select oh.* from planificacion.obj_hab oh inner join planificacion.unidad_anio_obj ob  on ob.id_obj = oh.id_obj
where oh.tipo=$tipo and ob.id_unidad=$idUnidad order by oh.id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}

public function traeObjUnidadAnioDeje($conn,$eje,$idUnidad,$tipo){
     $sql="select oh.* from planificacion.obj_hab oh inner join planificacion.unidad_anio_obj ob  on ob.id_obj = oh.id_obj
where oh.id_eje=$eje and ob.id_unidad=$idUnidad and oh.tipo=$tipo order by oh.id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}


public function UnidadIndAnio($conn,$idUnidad){
		 $sql="SELECT * FROM planificacion.unidad WHERE unidad_anual=$idUnidad ORDER BY fecha_inicio ASC";
		$result =pg_exec($conn,$sql);
		
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


public function listaEvaluacionClase($conn,$clase){
  $sql = "select * from planificacion.tipoevaluacion a inner join planificacion.clase_tipoevaluacion b
on a.id_tipo = b.id_tipo
where b.id_clase =  $clase";
$result = pg_exec($conn,$sql);
return $result;	
}


//indicador
public function buscaIndicador($conn,$id_obj){
 $sql="select * from planificacion.indicador_evaluacion where id_obj=$id_obj";
$result = pg_exec($conn,$sql);
return $result;	
}


public function buscaIndicadorN($conn,$id_obj,$unidad){
 $sql="select indic.* from planificacion.indicador_evaluacion indic
inner join planificacion.indeva_unidad inde
on inde.id_indicador = indic.id_indicador
where inde.id_obj =$id_obj and inde.id_unidad=$unidad";
$result = pg_exec($conn,$sql);
return $result;	
}

public function buscaIndicadorC($conn,$id_obj,$clase){
 $sql="select indic.* from planificacion.indicador_evaluacion indic
inner join planificacion.indeva_clase inde
on inde.id_indicador = indic.id_indicador
where inde.id_obj =$id_obj and inde.id_clase=$clase";
$result = pg_exec($conn,$sql);
return $result;	
}





/*********correcciones reporte*********************/
//unidad anño
public function tipoEjesUnidadAnio($conn,$unidad){
$sql="select DISTINCT(tob.id_objetivo),tob.nombre from planificacion.tipo_objetivo tob inner join planificacion.obj_hab oh on oh.tipo =tob.id_objetivo left join planificacion.unidad_anio_obj ob on ob.id_obj = oh.id_obj where ob.id_unidad=$unidad order by tob.id_objetivo";
$result =pg_exec($conn,$sql);
		
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

//fin unidad año
//unidad menor

public function tipoEjesUnidadInd($conn,$unidad){
   $sql="select DISTINCT(tob.id_objetivo),tob.nombre from planificacion.tipo_objetivo tob inner join planificacion.obj_hab oh on oh.tipo =tob.id_objetivo left join planificacion.unidad_obj ob on ob.id_obj = oh.id_obj where ob.id_unidad=$unidad order by tob.id_objetivo";
$result =pg_exec($conn,$sql);
		
		return $result;
}

public function tipoEjesBloqueUnidadInd($conn,$unidad,$tipo){
	      $sql="select DISTINCT(tej.id_eje),tej.texto 
from planificacion.ejes tej 
inner join planificacion.obj_hab oh on oh.id_eje = tej.id_eje
inner join planificacion.unidad_obj ob on ob.id_obj = oh.id_obj
where ob.id_unidad=$unidad and tej.tipo=$tipo order by tej.texto";
$result =pg_exec($conn,$sql);
		
		return $result;
	}
	
public function traeObjeUnidadInd($conn,$eje,$tipo,$unidad){
  $sql="select oh.* from planificacion.obj_hab oh 
inner join planificacion.unidad_obj ob on ob.id_obj = oh.id_obj 
where oh.tipo=$tipo and id_eje =$eje  and ob.id_unidad=$unidad order by oh.id_obj";
 $result = pg_exec($conn,$sql);
	return $result;	
}	

//fin unidd menor

//indicadores de clase
public function tipoEjesClaseInd($conn,$clase){
  $sql="select DISTINCT(tob.id_objetivo),tob.nombre from planificacion.tipo_objetivo tob inner join planificacion.obj_hab oh on oh.tipo =tob.id_objetivo left join planificacion.clase_obj ob on ob.id_obj = oh.id_obj where ob.id_clase=$clase order by tob.id_objetivo";
$result =pg_exec($conn,$sql);
		
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

//fin indicadores de clase

public function UnidadAnionEW($conn,$ano,$curso,$ramo){
		$sql="SELECT * FROM planificacion.unidad_anio WHERE id_ano=".$ano." AND id_curso=".$curso." AND id_ramo=".$ramo." ORDER BY fecha_inicio ASC";
		$result =pg_exec($conn,$sql);
		
		return $result;	
	}
	

public function lisPlaniMensual($conn,$ano,$curso,$ramo){
	 $sql="select pa.* from planificacion.plani_anual_new pa inner join planificacion.plani_anual_new_det pd
	on pd.id_panual = pa.id_planificacion
	where pa.id_ano=$ano and pa.id_curso=$curso and pa.id_ramo=$ramo";
	$result = pg_exec($conn,$sql);
	return $result;	
}

public function lisUnidades($conn,$ano,$curso,$ramo){
	  $sql="select pd.num_unidad from planificacion.plani_anual_new_det pd
inner join  planificacion.plani_anual_new pa 
 on pd.id_panual = pa.id_planificacion 
 where pa.id_ano=$ano and pa.id_curso=$curso and pa.id_ramo=$ramo
 group by pd.num_unidad
 order by pd.num_unidad";
 
	$result = pg_exec($conn,$sql);
	return $result;	
}

public function lisMeses($conn,$ano,$curso,$ramo,$num_unidad){
	   $sql="select pd.num_mes from planificacion.plani_anual_new_det pd
inner join  planificacion.plani_anual_new pa 
 on pd.id_panual = pa.id_planificacion 
 where pa.id_ano=$ano and pa.id_curso=$curso and pa.id_ramo=$ramo and pd.num_unidad=$num_unidad 
 group by pd.num_mes";
	$result = pg_exec($conn,$sql);
	return $result;	
}

public function lisSemana($conn,$ano,$curso,$ramo,$num_unidad,$num_mes){
	     $sql="select pd.id_semana from planificacion.plani_anual_new_det pd 
inner join planificacion.plani_anual_new pa on pd.id_panual = pa.id_planificacion
 where pa.id_ano=$ano and pa.id_curso=$curso and pa.id_ramo=$ramo 
 and pd.num_unidad=$num_unidad and pd.num_mes=$num_mes group by pd.id_semana";
	$result = pg_exec($conn,$sql);
	return $result;	
}


public function lisObjAN($conn,$ano,$curso,$ramo,$num_unidad,$num_mes,$num_semana){
	    $sql="select ob.* from planificacion.obj_hab ob
inner join planificacion.plani_anual_new_obj po
on po.id_obj_hab = ob.id_obj
inner join planificacion.plani_anual_new_det pd
on pd.id_anual_det = po.id_semana
inner join planificacion.plani_anual_new pa on pd.id_panual = pa.id_planificacion
where pa.id_ano=$ano and pa.id_curso=$curso and pa.id_ramo=$ramo
 and pd.num_unidad=$num_unidad and pd.num_mes=$num_mes and pd.id_semana=$num_semana";
	$result = pg_exec($conn,$sql);
	return $result;	
}

//PLANIFICACION MES
	public function horasMes($conn,$ano,$curso,$ramo,$num_mes){
	 $sql="select sum(pm.cant_semanas),sum(pm.cant_horas),min(pd.fecha_inicio),max(pd.fecha_termino) from planificacion.plani_new_mensual pm
inner join planificacion.plani_anual_new_det pd 
on pd.id_pmensual = pm.id_mensual
 inner join planificacion.plani_anual_new pa on pd.id_panual = pa.id_planificacion
  where pa.id_ano=$ano and pa.id_curso=$curso and pa.id_ramo=$ramo 
  and pd.num_mes=$num_mes ";
  $result = pg_exec($conn,$sql);
	return $result;	
	}
	
	public function semanasMes($conn,$ano,$curso,$ramo,$num_mes){
	 $sql="  select ps.*,pd.id_semana ids from planificacion.plani_semanal ps
 inner join planificacion.plani_new_mensual pm 
 on pm.id_mensual = ps.id_mensual
  inner join planificacion.plani_anual_new_det pd 
  on pd.id_pmensual = pm.id_mensual 
  inner join planificacion.plani_anual_new pa 
  on pd.id_panual = pa.id_planificacion 
  where pa.id_ano=$ano and pa.id_curso=$curso and pa.id_ramo=$ramo 
  and pd.num_mes=$num_mes";
  $result = pg_exec($conn,$sql);
	return $result;		
	}
	
	
public function objClaseSem($conn,$clase){
 $sql="select ob.* from planificacion.obj_hab ob 
inner join planificacion.plani_semanal_obj po
 on po.id_obj= ob.id_obj 
where po.id_clase=$clase order by codigo ";
$result = pg_exec($conn,$sql);
	return $result;		
}

public function indClaseSem($conn,$clase,$eje){
 $sql="select * from planificacion.indicador_evaluacion indic 
inner join planificacion.plani_semanal_ind inde 
on inde.id_indicador = indic.id_indicador
where inde.id_clase = $clase and inde.id_obj=$eje  ";
$result = pg_exec($conn,$sql);
	return $result;		
}

}//fin clase
?>