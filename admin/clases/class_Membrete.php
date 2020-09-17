<? 

class Membrete{

	/*var $ano;
	var $institucion;*/
	
	function institucion($conn){
		$sql_ins = "SELECT institucion.run,institucion.dig_run,institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, region,ciudad,comuna, villa, institucion.rdb,institucion.dig_rdb,";
		$sql_ins.= " comuna.nom_com, institucion.telefono,institucion.fax,dig_rdb, email,letra_inst,area_geo, dependencia, nu_resolucion, fecha_resolucion,numero_inst, institucion.timbre_ins ";
		$sql_ins.= "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON ";
		$sql_ins.= " (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ";
		$sql_ins.= " ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND ";
		$sql_ins.= "(institucion.comuna = comuna.cor_com) WHERE (((institucion.rdb)=".$this->institucion.")); ";
		//echo $sql_ins
		$result_ins =pg_exec($conn,$sql_ins) /*or die ("Select falló---: ".$sql_ins)*/;
		$fila_ins 	= pg_fetch_array($result_ins,0);
		$this->run			= $fila_ins['run'];	
		$this->dig_run		= $fila_ins['dig_run'];
		$this->dig_rdb		= $fila_ins['dig_rdb'];
		$this->ins_pal 		= ucwords(strtoupper($fila_ins['nombre_instit']));
		$this->direccion 	= $fila_ins['calle']." ".$fila_ins['nro']." ".$fila_ins['nom_com'];
		$this->direccion2 	= $fila_ins['calle']." ".$fila_ins['nro']." ".$fila_ins['villa']." ".$fila_ins['nom_com'];
		$this->telefono 	= $fila_ins['telefono'];
		$this->fax		 	= $fila_ins['fax'];	
		$this->region		= $fila_ins['nom_reg'];
		$this->provincia	= $fila_ins['nom_pro'];
		$this->comuna		= $fila_ins['nom_com'];
		$this->num_region	= $fila_ins['region'];
		$this->num_ciudad	= $fila_ins['ciudad'];
		$this->num_comuna	= $fila_ins['comuna'];
		$this->email		= $fila_ins['email'];
		$this->letra		= $fila_ins['letra_inst'];
		$this->numero_inst	= $fila_ins['numero_inst'];
		/*$this->celular		= $fila_ins['celular'];
		$this->area_geo		= $fila_ins['area_geo'];*/
		$this->dependencia	= $fila_ins['dependencia'];
		$this->nu_resolucion= $fila_ins['nu_resolucion'];
		$this->fecha_resol 	= $fila_ins['fecha_resolucion'];
		$this->timbre_ins 	= $fila_ins['timbre_ins'];
		$this->rrdb			= $fila_ins['rdb']."-".$fila_ins['dig_rdb'];
		return;
	}
	function AnoEscolar($conn){
		$sql_ano = "select * from ano_escolar where id_ano = ".$this->ano;
		$result_ano =@pg_Exec($conn,$sql_ano);
		$fila_ano = @pg_fetch_array($result_ano,0);
		$this->nro_ano = $fila_ano['nro_ano'];
		$this->fecha_inicio = $fila_ano['fecha_inicio'];
		$this->fecha_termino = $fila_ano['fecha_termino'];
		return;
	}
	
	
	function curso($conn){
		$sql ="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, curso.ensenanza,
		tipo_ensenanza.nombre_tipo, curso.truncado_per,curso.fecha_inicio,curso.fecha_termino FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza 
		WHERE (((curso.id_curso)=".$this->curso."))";
		//$sql.="";
		$result = @pg_exec($conn,$sql) or die ("Select fallo: ".$sql);
		$fila = @pg_fetch_array($result,0);
		$this->cod_decreto =$fila['cod_decreto'];
		$this->grado_curso =$fila['grado_curso'];
		$this->letra_curso =$fila['letra_curso'];
		$this->ensenanza   =$fila['nombre_tipo'];
		$this->cod_ensenanza  =$fila['ensenanza'];
		$this->finicio_curso = $fila['fecha_inicio'];
		$this->ftermino_curso = $fila['fecha_termino'];
		return;
	}
	
	
	function periodo($conn){
		$sql = "select * from periodo where id_ano = ".$this->ano."  AND id_periodo=".$this->periodo." order by fecha_inicio";
		$result_peri = pg_exec($conn,$sql) /*or die ("Select falló:".$sql)*/;
		$fila = pg_fetch_array($result_peri,0);
		$this->nombre_periodo = $fila['nombre_periodo'];
		$this->dias_habiles = $fila['dias_habiles'];
		$this->result = $result_peri;
		return;
	}
	
	
	function periodoALL($conn){
		 $sql = "select * from periodo where id_ano = ".$this->ano." order by fecha_inicio";
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	
	function nivel($conn){
		$sql = "Select ni.nombre from niveles as ni where ni.id_nivel=".$this->idnivel;
	    $result_nivel = @pg_exec($conn,$sql) or die ("Select fallo: ".$sql);
	    $fila_nivel = @pg_fetch_array($result_nivel,0);
	    $this->nombre_nivel = $fila_nivel['nombre'];
	    return;		
	}
	
	function Ciclo($conn){
		$sql ="SELECT nomb_ciclo FROM ciclo_conf WHERE id_ciclo=".$this->ciclo;
		$result = pg_exec($conn,$sql);
		$this->nombre_ciclo=pg_result($result,0);
		return;
		
	}
	function Asignatura($conn){
		$sql ="SELECT s.nombre FROM subsector s WHERE cod_subsector=".$this->ramo;
		$result = pg_exec($conn,$sql) or die(pg_last_error($conn));
		$this->nombre_subsector=pg_result($result,0);
		return;
	}
	
	
}

  

?>