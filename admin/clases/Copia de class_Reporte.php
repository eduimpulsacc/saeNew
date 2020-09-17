<? require "../../../../util/connect.php";




$institucion =$_INSTIT;
class Reporte { 
    
	var $ano;
	//echo  $institucion;
	
	function InsertReporte($conn){
		$sql = "SELECT id_reporte FROM item_reporte WHERE id_item=".$this->cmbREPORTE;
		$rs_reporte = @pg_exec($conn,$sql);
		$reporte = @pg_result($rs_reporte,0);
		
		
		$sql =" INSERT INTO configuracion_reporte (rdb, id_reporte, id_item, titulo_tamano, item_tamano, subitem_tamano, ";
		$sql.=" titulo_letra, item_letra, subitem_letra, con_colilla, con_taller, con_anotaciones, firma1, firma2, firma3, ";
		$sql.=" firma4, grado1, grado2, grado3, grado4, grado5, grado6, grado7, grado8,grado9,grado10,grado11,grado12,tipo_ense)";
		$sql.=" VALUES(".$this->institucion.", ".$reporte.", ".$this->cmbREPORTE.", ".$this->rbTITULO.", ".$this->rbITEM.", ";
		$sql.=" ".$this->rbSUBITEM.", '".$this->cmbLETRATITULO."', '".$this->cmbLETRAITEM."', '".$this->cmbLETRASUBITEM."', ";
		$sql.=" 0, 0, 0, '".$this->cmbFIRMA1."', ";
		$sql.=" '".$this->cmbFIRMA2."', '".$this->cmbFIRMA3."', '".$this->cmbFIRMA4."', '".$this->ckbox1."','".$this->ckbox2."',";
		$sql.=" '".$this->ckbox3."', '".$this->ckbox4."', '".$this->ckbox5."','".$this->ckbox6."', '".$this->ckbox7."', ";
		$sql.=" '".$this->ckbox8."', '".$this->ckbox9."', '".$this->ckbox10."', '".$this->ckbox11."', '".$this->ckbox12."', ";
		$sql.=" ".$this->cmbENSENANZA.")";
		$result = @pg_exec($conn,$sql) or die ("Select falló: " .$sql);
		return $result;
	}
	function InsertReporte2($conn){
		$sql = "SELECT id_reporte FROM item_reporte WHERE id_item=".$this->cmbREPORTE;
		$rs_reporte = @pg_exec($conn,$sql);
		$reporte = @pg_result($rs_reporte,0);
		
		
		$sql =" INSERT INTO configuracion_reporte_new (rdb, id_reporte, id_item, titulo_tamano, item_tamano, subitem_tamano, ";
		$sql.=" titulo_letra, item_letra, subitem_letra, con_colilla, con_taller, con_anotaciones, firma1, firma2, firma3, ";
		$sql.=" firma4, empleado1, empleado2, empleado3, empleado4,grado1, grado2, grado3, grado4, grado5, grado6, grado7, grado8,grado9,grado10,grado11,grado12,tipo_ense)";
		$sql.=" VALUES(".$this->institucion.", ".$reporte.", ".$this->cmbREPORTE.", ".$this->rbTITULO.", ".$this->rbITEM.", ";
		$sql.=" ".$this->rbSUBITEM.", '".$this->cmbLETRATITULO."', '".$this->cmbLETRAITEM."', '".$this->cmbLETRASUBITEM."', ";
		$sql.=" 0, 0, 0, '".$this->cmbFIRMA1."', '".$this->cmbFIRMA2."', '".$this->cmbFIRMA3."', '".$this->cmbFIRMA4."',";
		$sql.=" '".$this->cmbEMPLEADO1."', '".$this->cmbEMPLEADO2."',  '".$this->cmbEMPLEADO3."', '".$this->cmbEMPLEADO4."','".$this->ckbox1."','".$this->ckbox2."',";
		$sql.=" '".$this->ckbox3."', '".$this->ckbox4."', '".$this->ckbox5."','".$this->ckbox6."', '".$this->ckbox7."', ";
		$sql.=" '".$this->ckbox8."', '".$this->ckbox9."', '".$this->ckbox10."', '".$this->ckbox11."', '".$this->ckbox12."', ";
		$sql.=" ".$this->cmbENSENANZA.")";
		$result = @pg_exec($conn,$sql) or die ("Select falló: " .$sql);
		return $result;
	}
	function ModificaReporte($conn){
		$sql = "UPDATE configuracion_reporte SET titulo_tamano=".$this->rbTITULO.", item_tamano=".$this->rbITEM.", ";
		$sql.= "subitem_tamano=".$this->rbSUBITEM.", titulo_letra='".$this->cmbLETRATITULO."', ";
		$sql.= "item_letra='".$this->cmbLETRAITEM."', subitem_letra='".$this->cmbLETRASUBITEM."', ";
		$sql.= "con_colilla=0, con_taller=0, ";
		$sql.= "con_anotaciones=0, firma1=".$this->cmbFIRMA1.", firma2=".$this->cmbFIRMA2.", ";
		$sql.= "firma3=".$this->cmbFIRMA3.", firma4=".$this->cmbFIRMA4.", grado1=".$this->ckbox1.", grado2=".$this->ckbox2.", ";
		$sql.= "grado3=".$this->ckbox3.", grado4=".$this->ckbox4.", grado5=".$this->ckbox5.", grado6=".$this->ckbox6.", ";
		$sql.= "grado7=".$this->ckbox7.", grado8=".$this->ckbox8.", grado9=".$this->ckbox9.", grado10=".$this->ckbox10.", ";
		$sql.= "grado11=".$this->ckbox11.", grado12=".$this->ckbox12.", tipo_ense=".$this->cmbENSENANZA.", ";
		$sql.= "empleado1=".$this->cmbEMPLEADO1.",empleado2=".$this->cmbEMPLEADO2.",empleado3=".$this->cmbEMPLEADO3.",empleado4=".$this->cmbEMPLEADO4." ";
		$sql.= "WHERE rdb=".$this->institucion." AND id_item=".$this->cmbREPORTE." AND id_config=".$this->id_config;
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	function ModificaReporte2($conn){
		$sql = "UPDATE configuracion_reporte SET titulo_tamano=".$this->rbTITULO.", item_tamano=".$this->rbITEM.", ";
		$sql.= "subitem_tamano=".$this->rbSUBITEM.", titulo_letra='".$this->cmbLETRATITULO."', ";
		$sql.= "item_letra='".$this->cmbLETRAITEM."', subitem_letra='".$this->cmbLETRASUBITEM."', ";
		$sql.= "con_colilla=0, con_taller=0, ";
		$sql.= "con_anotaciones=0, firma1=".$this->cmbFIRMA1.", firma2=".$this->cmbFIRMA2.", ";
		$sql.= "firma3=".$this->cmbFIRMA3.", firma4=".$this->cmbFIRMA4.", grado1=".$this->ckbox1.", grado2=".$this->ckbox2.", ";
		$sql.= "grado3=".$this->ckbox3.", grado4=".$this->ckbox4.", grado5=".$this->ckbox5.", grado6=".$this->ckbox6.", ";
		$sql.= "grado7=".$this->ckbox7.", grado8=".$this->ckbox8.", grado9=".$this->ckbox9.", grado10=".$this->ckbox10.", ";
		$sql.= "grado11=".$this->ckbox11.", grado12=".$this->ckbox12.", tipo_ense=".$this->cmbENSENANZA." ";
		$sql.= ",empleado1=".$this->cmbEMPLEADO1.",empleado2=".$this->cmbEMPLEADO2.",empleado3=".$this->cmbEMPLEADO3.",empleado4=".$this->cmbEMPLEADO4." ";
		$sql.= "WHERE rdb=".$this->institucion." AND id_item=".$this->cmbREPORTE." AND id_config=".$this->id_config;
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	function EliminaReporte($conn){
		$sql = "DELETE FROM configuracion_reporte WHERE id_config=".$this->id_config." ";
		$sql.="and id_item=".$this->id_item." and rdb=".$this->institucion."";
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	
	function BuscaReporte($conn){
		$sql ="SELECT * FROM configuracion_reporte WHERE rdb=".$this->institucion." ";
		if($this->cmbaREPORTE!=""){
			$sql.="AND id_item=".$this->cmbREPORTE." ";
		}
		if($this->id_config!=""){
			$sql.="AND id_config=".$this->id_config." ";
		}
		$sql.=" ORDER BY id_item ASC";
		$rs_reporte = @pg_exec($conn,$sql);
		return $rs_reporte;

	}
	function BuscaReporte2($conn){
		$sql ="SELECT * FROM configuracion_reporte_new WHERE rdb=".$this->institucion." ";
		if($this->cmbaREPORTE!=""){
			$sql.="AND id_item=".$this->cmbREPORTE." ";
		}
		if($this->id_config!=""){
			$sql.="AND id_config=".$this->id_config." ";
		}
		$sql.=" ORDER BY id_item ASC";
		$rs_reporte = @pg_exec($conn,$sql);
		return $rs_reporte;

	}
	function ConfiguraReporte($conn){
		$sql = "SELECT grado_curso FROM curso WHERE id_curso=".$this->curso;
		$rs_curso = @pg_exec($conn,$sql);
		$grado = @pg_result($rs_curso,0);
		$sql ="SELECT * FROM configuracion_reporte WHERE rdb=".$this->institucion." AND id_item=".$this->id_item." ";
		if($this->curso!=1){
		$sql.=" AND tipo_ense in (SELECT ensenanza FROM curso WHERE id_curso=".$this->curso.")  AND grado$grado=1";
		}
		//if($_PERFIL==0) echo $sql;
		$result = @pg_exec($conn,$sql);
		return $result;
	}	
	function CambiaDatoReporte($fila){
		$this->tamanoT	=$fila['titulo_tamano'];
		$this->tamanoI	=$fila['item_tamano'];
		$this->tamanoS	=$fila['subitem_tamano'];
		$this->letraT	=$fila['titulo_letra'];
		$this->letraI	=$fila['item_letra'];
		$this->letraS	=$fila['subitem_letra'];
		$this->colilla	=$fila['con_colilla'];
		$this->taller	=$fila['con_taller'];
		$this->anotac	=$fila['con_anotaciones'];
		$this->firma1	=$fila['firma1'];
		$this->firma2	=$fila['firma2'];
		$this->firma3	=$fila['firma3'];
		$this->firma4	=$fila['firma4'];
		$this->empleado1=$fila['empleado1'];
		$this->empleado2=$fila['empleado2'];
		$this->empleado3=$fila['empleado3'];
		$this->empleado4=$fila['empleado4'];
		$this->grado1	=$fila['grado1'];
		$this->grado2	=$fila['grado2'];
		$this->grado3	=$fila['grado3'];
		$this->grado4	=$fila['grado4'];
		$this->grado5	=$fila['grado5'];
		$this->grado6	=$fila['grado6'];
		$this->grado7	=$fila['grado7'];
		$this->grado8	=$fila['grado8'];
		$this->grado9	=$fila['grado9'];
		$this->grado10	=$fila['grado10'];
		$this->grado11	=$fila['grado11'];
		$this->grado12	=$fila['grado12'];
		$this->ensenanza=$fila['tipo_ense'];
		return;
	}
	function Menu($conn){
		$sql="SELECT id_reporte, nombre FROM reporte ORDER BY id_reporte ASC";
		$result =@pg_exec($conn,$sql);
		return $result;
	}	
	function ItemMenu($conn){
		$sql = " SELECT * FROM item_reporte WHERE id_reporte=".$this->reporte." ORDER BY id_reporte, id_item ASC";
		$result=@pg_exec($conn,$sql);
		return $result;
	}
	function ItemReporte($conn){
		$sql = "select * from item_reporte where id_item in (select id_item FROM perfil_reporte WHERE rdb=".$this->rdb." AND id_reporte=".$this->reporte." AND id_perfil=".$this->perfil.")";
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	function ListaReporte($conn){
		$sql = " SELECT nombre,id_item FROM item_reporte ";
		if($this->item_reporte!=0){
			$sql.= "WHERE id_item=".$this->item_reporte."";
		}
		$sql.=" ORDER BY id_reporte, id_item ASC";
		$result=@pg_exec($conn,$sql);
		return $result;
	}
	function Cargos($conn){
		$sql="SELECT * FROM cargos ";
		$result =@pg_exec($conn,$sql);
		return $result;
	}
	function UnCargo($conn){
		$sql="SELECT * FROM cargos WHERE id_Cargo=".$this->cargo."";
		$result =@pg_exec($conn,$sql);
		$this->id_cargo = @pg_result($resul,0);
		$this->nombre_cargo = @pg_result($result,1);
		return;
	}
	function Firmas($conn){
		$sql="SELECT * FROM cargos WHERE id_Cargo=".$this->cargo."";
		$result =@pg_exec($conn,$sql);
		$this->id_cargo = @pg_result($result,0);
		if($this->id_cargo ==5){
			$this->nombre_cargo = "Profesor(a) Jefe";
		}else{
			$this->nombre_cargo = @pg_result($result,1);
		}
		if($this->empleado!=0){
			$sql = "SELECT nombre_emp || cast (' ' as varchar) || ape_pat || cast(' ' as varchar) || ape_mat as nombre ";
			$sql.= "FROM empleado WHERE rut_emp=".$this->empleado;
		}else{
			if(($this->id_cargo ==5 || $this->id_cargo ==34)) {
				$sql = "SELECT nombre_emp || cast (' ' as varchar) || ape_pat || cast(' ' as varchar) || ape_mat as nombre ";
				$sql.= "FROM empleado WHERE rut_emp IN (SELECT rut_emp FROM supervisa WHERE id_curso=".$this->curso." AND  rut_emp IN ";
				$sql.= "(SELECT rut_emp FROM trabaja WHERE cargo=".$this->cargo." AND rdb=".$this->rdb."))";
			}else{
				$sql = "SELECT nombre_emp ,ape_pat ,ape_mat ";
				$sql.= "FROM empleado WHERE rut_emp IN (SELECT rut_emp FROM trabaja WHERE cargo=".$this->cargo." ";
				$sql.= "AND rdb=".$this->rdb.")";
			}	
		}
		//if($_PERFIL==0) echo $sql;
		$rs_empleado = @pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
		$this->nombre_emp =@pg_result($rs_empleado,0)." ".@pg_result($rs_empleado,1)." ".@pg_result($rs_empleado,2);
		$this->apellido_emp =@pg_result($rs_empleado,1)." ".@pg_result($rs_empleado,2)." ".@pg_result($rs_empleado,0);
		return;
	}
	function TraeUnAlumno($conn){
		$sql =" SELECT * ";
		$sql.=" FROM alumno WHERE rut_alumno in (SELECT rut_alumno FROM matricula WHERE  id_ano=".$this->ano." AND ";
		$sql.=" id_curso=".$this->curso." AND rut_alumno=".$this->alumno.") ORDER BY ape_pat, ape_mat ASC";
		$result =@pg_exec($conn,$sql) or die ("Select falló (Trae un Alumno): " .$sql);
		return $result;
	}
	function TraeTodosAlumnos($conn){
	   	$sql =" SELECT * ";
		$sql.=" FROM alumno INNER JOIN  matricula ON alumno.rut_alumno=matricula.rut_alumno WHERE  id_ano=".$this->ano." AND ";
		$sql.=" id_curso=".$this->curso." ";
		if($this->retirado==0){
			$sql.=" AND bool_ar=0";
		}
		if($this->fecha_mat!=""){
			$sql.=" AND fecha <'$this->fecha_mat' ";
		}
		if($this->fecha_mat2!=""){
			$sql.=" AND fecha >'$this->fecha_mat2' ";
		}
		if($this->sexo==1 || $this->sexo==2){
			$sql.="  AND sexo=".$this->sexo." ";
		}
		if($this->orden==0){
			$sql.="  ORDER BY nro_lista ASC";
		}else{
			$sql.="  ORDER BY ape_pat, ape_mat ASC";
		}
		//if($_PERFIL==0) echo $sql;
		$result =@pg_exec($conn,$sql) or die ("Select falló (Trae Todos): " .$sql);
		return $result;
	}
	function ProfeJefe($conn){
		$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
		$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$this->curso.")); ";
		$result_profe =@pg_Exec($conn,$sql_profe) or die("SELECT FALLÓ: ".$sql_profe);
		$fila_profe = @pg_fetch_array($result_profe,0);	
		$this->profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat'])." ".trim($fila_profe['ape_mat'])." ".trim($fila_profe['nombre_emp'])));
		$this->profe_nombre =ucwords(strtoupper(trim($fila_profe['nombre_emp'])." ".trim($fila_profe['ape_pat'])." ".trim($fila_profe['ape_mat'])));
		return;
	}
	function AnoEscolar($conn){
		$sql_ano = "select * from ano_escolar where id_ano = ".$this->ano;
		$result_ano =@pg_Exec($conn,$sql_ano);
		$fila_ano = @pg_fetch_array($result_ano,0);
		$this->nro_ano = $fila_ano['nro_ano'];
		return;
	}
	function Anotaciones($conn){
		$sql = "select * from anotacion where";
		$sql.= " rut_alumno = ".$this->alumno." and (fecha>='".$this->fecha_inicio."' and fecha<='".$this->fecha_termino."')";
		if($this->tipo!=""){
			$sql.= " AND tipo=".$this->tipo." ";
		}
		$sql.= "order by tipo desc, fecha ";
		//if($_PERFIL==0) echo $sql;
		$result_anota = @pg_Exec($conn, $sql) or die("SELECT FALLÓ:".$sql);
		return $result_anota;
	}
	function Profesor($conn){
		$sql_emple = "select * from empleado where rut_emp = ".$this->rut_emp;
		$res_emple = pg_Exec($conn,$sql_emple);
		$fil_emple = pg_fetch_array($res_emple,0);	
		$this->profesor = strtoupper($fil_emple['ape_pat'] . " " . $fil_emple['ape_mat'] . " " . $fil_emple['nombre_emp']);
		return;
	}
	function Asistencia($conn){
		$sql = "SELECT * FROM asistencia WHERE rut_alumno = ".$this->alumno." and ano = ".$this->ano." ";
		if($this->fecha_inicio!="" AND $this->fecha_termino!=""){
			$sql.=" and (fecha>='".$this->fecha_inicio."' and fecha<='".$this->fecha_termino."') ";
		}
		if($this->curso!=""){
			$sql.= " AND id_curso =".$this->curso." ";
		}
		$sql.=" ORDER BY fecha ASC";
		//if($_PERFIL==0) echo $sql;
		$result_asis = pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result_asis;
	}
	function AsistenciaAlumno($conn){
		$sql ="SELECT fecha FROM asistencia a WHERE a.ano=".$this->ano." and a.id_curso=".$this->curso." AND rut_alumno=".$this->alumno; 
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ(asistencia Alumno):".$sql);
		return $result;
	}
	function Ciclos($conn){
		$sql ="SELECT * FROM ciclo_conf WHERE rdb=".$this->rdb." AND id_ano=".$this->ano;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ(ciclos):".$sql);
		return $result;
	}
	function Nivel($conn){
		$sql = "SELECT * FROM niveles ";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ(niveles):".$sql);
		return $result;
	}
	function AsistenciaCiclos($conn){
		$sql ="SELECT count(a.*) as cuenta, id_ciclo, date_part('MONTH',fecha) FROM asistencia a INNER JOIN ciclos b ON (a.id_curso=b.id_curso AND a.ano=b.id_ano) ";
		$sql.="WHERE a.ano=".$this->ano."  GROUP BY id_ciclo, date_part('MONTH',fecha)";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return;
	}
	function AsistenciaNiveles($conn){
		$sql="SELECT count(a.*) as cuenta, c.id_nivel, date_part('MONTH',fecha) FROM asistencia a INNER JOIN curso b ON a.id_curso=b.id_curso INNER JOIN ";
		$sql.="niveles c ON b.id_nivel=c.id_nivel WHERE b.id_ano=".$this->ano." GROUP BY c.id_nivel, date_part('MONTH',fecha)";
		$result =@pg_exec($conn,$sql)  or die ("SELECT FALLÓ(asistencia niveles):".$sql);
		return $result;
	}
	function DiaHabil($conn){
		$sql ="SELECT count(*) FROM feriado WHERE id_ano=".$this->ano." AND feriado.fecha_fin='".$this->fecha."'";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return;
	}
	function JustificaAsistencia($conn){
		$sql =" SELECT fecha FROM justifica_inasistencia WHERE rut_alumno = ".$this->alumno." AND ";
		$sql.=" ano = ".$this->ano." ";
		if($this->fecha!=""){
			$sql.=" AND fecha = '".$this->fecha."' ";
		}
		if($this->fecha2!="" && $this->fecha1!=""){
			$sql.=" AND (fecha >='".$this->fecha1."' and fecha <='".$this->fecha2."')"; 
		}
		//if($_PERFIL==0) echo $sql;
		$res_justifica = @pg_Exec($conn,$sql);
		$fila_justifica = @pg_fetch_array($res_justifica,0);
		$this->justifica = $fila_justifica['fecha'];	
		return $res_justifica;		
	}
	function Periodo($conn){
		$sql="SELECT fecha_inicio,fecha_termino,dias_habiles, nombre_periodo,id_periodo FROM periodo WHERE id_periodo=".$this->periodo;
		$Rs_Periodo = @pg_exec($conn,$sql);
		$fila_Periodo=@pg_fetch_array($Rs_Periodo,0);
		$this->fecha_inicio=$fila_Periodo['fecha_inicio'];
		$this->fecha_termino=$fila_Periodo['fecha_termino'];
		$this->dias_habiles = $fila_Periodo['dias_habiles'];
		$this->nombre_periodo = $fila_Periodo['nombre_periodo'];
		$this->result = $Rs_Periodo;
		return;
	}
	function TotalPeriodo($conn){
		$sql = "SELECT * FROM periodo WHERE id_ano = ".$this->ano." order by fecha_inicio";
		$result =@pg_exec($conn,$sql) or die("SELECT FALLO :".$sql);	
		return $result;
	}
	function TipoAnotacion($conn){
	    $q1 = "SELECT * FROM tipos_anotacion WHERE id_tipo = '$this->cod_ta'";
		$r1 = @pg_Exec($conn,$q1);
		$f1 = @pg_fetch_array($r1,0);
		$this->codta       = $f1['codtipo'];
		$this->descripcion = $f1['descripcion'];
		return;
	}
	function SiglaSubsector($conn){
		 $q1 = "SELECT * FROM sigla_subsectoraprendisaje WHERE id_sigla = ".$this->sigla_aux;
		$r1 = @pg_Exec($conn,$q1) or die("SELECT FALLO :".$ql);
		$f1 = @pg_fetch_array($r1,0);
		$this->detalle_sigla = $f1['detalle'];
		$this->sigla = $f1['sigla'];
		return;
	}
	function FichaAlumnoUno($conn){
		$sql = " SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ";
		$sql.= " alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, alumno.salud, ";
		$sql.= " alumno.religion, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, ";
		$sql.= " matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, ";
		$sql.= " matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, ";
		$sql.= " comuna.nom_com, alumno.depto, alumno.block, alumno.villa, matricula.num_mat,alumno.cerro,alumno.lugar,";
		$sql.= " alumno.contacto_emergencia,alumno.fono_contacto FROM (((matricula INNER JOIN alumno ON ";
		$sql.= " matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN ";
		$sql.= " provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON ";
		$sql.= " (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
		$sql.= " WHERE (((matricula.rut_alumno)=".$this->alumno.") AND ((matricula.id_ano)=".$this->ano.")) ";
		$result_alumno = pg_exec($conn,$sql);
		return $result_alumno;
	}
	function FichaAlumnoTodos($conn){
		$sql = " SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ";
		$sql.= " alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, alumno.salud,matricula.bool_ar, ";
		$sql.= " matricula.total_notas, suma_pond, pond_demre, alumno.prioritario, ";
		$sql.= " alumno.religion, matricula.fecha, matricula.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, ";
		$sql.= " matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, ";
		$sql.= " matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, ";
		$sql.= " comuna.nom_com, alumno.depto, alumno.block, alumno.villa, matricula.num_mat, alumno.cerro,alumno.lugar,alumno.contacto_emergencia,alumno.fono_contacto FROM (((matricula INNER JOIN ";
		$sql.= " alumno ON ";
		$sql.= " matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN ";
		$sql.= " provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ";
		$sql.= " ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
		$sql.= " WHERE (((matricula.id_ano)=".$this->ano.") and ((matricula.id_curso)=".$this->curso."))";
		if($this->comuna!=0){
			$sql.=" AND alumno.comuna=".$this->comuna;
		}
		if($this->sep!=0){
			$sql.=" AND matricula.ben_sep=".$this->sep;
		}
		if($this->retirado==0 or $this->retirado==1){
			$sql.=" AND matricula.bool_ar=".$this->retirado;
		}
		if($this->orden==1){
			$sql.= " order by matricula.nro_lista asc ";
		}else{			
			$sql.= " order by ape_pat, ape_mat ASC ";
		}
		//if($_PERFIL==0) echo $sql;
		$result_alumno = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		return $result_alumno;
	}
	function AlumnoCurso($conn){
	 	$sql = "SELECT matricula.num_mat, curso.grado_curso, curso.letra_curso, matricula.rut_alumno, alumno.dig_rut, alumno.ape_pat, ";
		$sql.= "alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.calle, alumno.nro, comuna.nom_com, matricula.fecha, matricula.fecha_retiro, ";
		$sql.= "alumno.fecha_nac, curso.cod_decreto, matricula.bool_rg FROM (((curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) ";
		$sql.= "INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN alumno ON ";
		$sql.= "matricula.rut_alumno = alumno.rut_alumno) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND ";
		$sql.= "(alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) WHERE (((curso.id_curso)=".$this->curso.") ";
		$sql.= " AND ((matricula.rdb)=".$this->institucion.")) ";
		if($this->sexo > 0){
			$sql.= "AND sexo = ".$this->sexo."  AND matricula.id_ano =".$this->ano." "; 
		}
		if($this->orden==1){
			$sql.= "ORDER BY nro_lista asc, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu"; 
		}else{
			$sql.= "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu"; 
		}
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		return $result;		
	}
	function AlumnoEnsenanza($conn){
		$sql = "SELECT matricula.num_mat, curso.grado_curso, curso.letra_curso, matricula.rut_alumno, alumno.dig_rut, alumno.ape_pat,curso.id_curso, ";
		$sql.= "alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.calle, alumno.nro, comuna.nom_com, matricula.fecha, matricula.fecha_retiro, ";
		$sql.= "alumno.fecha_nac, curso.cod_decreto, alumno.villa FROM (((curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) ";
		$sql.= "INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN alumno ON ";
		$sql.= "matricula.rut_alumno = alumno.rut_alumno) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND ";
		$sql.= "(alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
		$sql.= "WHERE (((tipo_ensenanza.cod_tipo)=".$this->cmb_curso.") AND ((matricula.rdb)=".$this->institucion.")) AND ";
		$sql.= "((curso.id_ano = ".$this->ano." )) ";
		if ($this->orden==1){
	    	$sql = $sql . "ORDER BY matricula.num_mat; ";
		}else{
	    	$sql = $sql . "ORDER BY curso.grado_curso, curso.letra_curso, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
    	}
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	function CambiaDato($fila_alumno){
		$this->rut_alumno = strtoupper($fila_alumno['rut_alumno']." - ".$fila_alumno['dig_rut']);
		$this->rut_alumno2 = strtoupper($fila_alumno['rut_alumno'].$fila_alumno['dig_rut']);
		$this->alumno = $fila_alumno['rut_alumno'];
		$this->prioritario = $fila_alumno['prioritario'];
		$this->nombre = ucwords(strtolower($fila_alumno['nombre_alu']));
		$this->ape_pat = ucwords(strtolower($fila_alumno['ape_pat']));
		$this->ape_mat = ucwords(strtolower($fila_alumno['ape_mat']));
		$this->nombres = ucwords(strtolower($fila_alumno['nombre_alu']))." ".ucwords(strtolower($fila_alumno['ape_pat']))." ".ucwords(strtolower($fila_alumno['ape_mat']));
		$this->ape_nombre_alu = htmlentities(ucwords(strtolower(trim($fila_alumno['ape_pat'])))." ".ucwords(strtolower(trim($fila_alumno['ape_mat'])))." ".ucwords(strtolower(trim($fila_alumno['nombre_alu']))));
		$this->fecha_nacimiento = $fila_alumno['fecha_nac'];
		if ($fila_alumno['sexo']==1){
			$this->sexo = "Femenino";
			$this->letra_sexo = "F";
		}else{
			$this->sexo = "Masculino";
			$this->letra_sexo = "M";
		}
		
		if ($fila_alumno['nacionalidad']==2)
			$this->nacionalidad = "Chilena";
		else
			$this->nacionalidad = "Extranjera";
			
		$this->telefono_alu = $fila_alumno['telefono'];
		$this->email = $fila_alumno['email'];
		$this->fecha_matricula = $fila_alumno['fecha'];
		$this->num_matricula = $fila_alumno['num_mat'];
		$this->fecha_retiro = $fila_alumno['fecha_retiro'];
		
		if ($fila_alumno['bool_baj']==1) 	$this->bool_baj = "SI"; else $this->bool_baj = "NO";		
		if ($fila_alumno['bool_aoi']==1) 	$this->bool_aoi = "SI"; else $this->bool_aoi = "NO";		
		if ($fila_alumno['bool_rg']==1) 	$this->bool_rg 	= "SI"; else $this->bool_rg  = "NO";		
		if ($fila_alumno['bool_ae']==1) 	$this->bool_ae 	= "SI"; else $this->bool_ae  = "NO";		
		if ($fila_alumno['bool_i']==1) 		$this->bool_i 	= "SI"; else $this->bool_i 	 = "NO";		
		if ($fila_alumno['bool_gd']==1) 	$this->bool_gd 	= "SI"; else $this->bool_gd  = "NO";		
		if ($fila_alumno['bool_ar']==1) 	$this->bool_ar 	= "SI"; else $this->bool_ar  = "NO";		
		if ($fila_alumno['bool_bchs']==1) 	$this->bool_bchs= "SI"; else $this->bool_bchs= "NO";				
		
		$this->direccion_alu = ucwords(strtolower($fila_alumno['calle']." ".$fila_alumno['nro']));
		$this->comuna = ucwords(strtolower($fila_alumno['nom_com']));
		$this->provincia = ucwords(strtolower($fila_alumno['nom_pro']));
		$this->region = ucwords(strtolower($fila_alumno['nom_reg']));
		$this->block = ucwords(strtolower($fila_alumno['block']));
		$this->depto = ucwords(strtolower($fila_alumno['depto']));
		$this->villa = ucwords(strtolower($fila_alumno['villa']));
		$this->salud = ucwords(strtolower($fila_alumno['salud']));
		$this->religion = ucwords(strtolower($fila_alumno['religion']));
		$this->fecha_retiro = $fila_alumno['fecha_retiro'];
		$this->cod_decreto = $fila_alumno['cod_decreto'];
		$this->grado_curso = $fila_alumno['grado_curso'];
		$this->letra_curso = $fila_alumno['letra_curso'];
		$this->id_curso = $fila_alumno['id_curso'];
		return;
	}
	function tilde($campo){
		$datoA = str_replace("Á","á",$campo);
		$datoE = str_replace("É","é",$datoA);
		$datoI = str_replace("Í","í",$datoE);
		$datoO = str_replace("Ó","ó",$datoI);
		$datoU = str_replace("Ú","ú",$datoO);
		$datoN = str_replace("Ñ","ñ",$datoU);
		if($datoN!=false){
			return $datoN;
			exit;
		}
	}
	function tildeM($campo){
		$datoA = str_replace("á","Á",$campo);
		$datoE = str_replace("é","É",$datoA);
		$datoI = str_replace("í","Í",$datoE);
		$datoO = str_replace("ó","Ó",$datoI);
		$datoU = str_replace("ú","Ú",$datoO);
		$datoÑ = str_replace("ñ","Ñ",$datoU);
		if($datoÑ!=false){
			return $datoÑ;
			exit;
		}
	}
	function Apoderado($conn){
		$sql = "SELECT apoderado.rut_apo, apoderado.dig_rut, apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, ";
		$sql.= " apoderado.telefono, apoderado.email, tiene2.responsable, apoderado.relacion,apoderado.calle,apoderado.nro, ";
		$sql.= " apoderado.profesion, apoderado.ocupacion,apoderado.nivel_edu,apoderado.nivel_social, apoderado.sexo, ";
		$sql.= " apoderado.celular, comuna.nom_com FROM tiene2 INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo ";
		$sql.= "  INNER JOIN comuna ON apoderado.region=comuna.cod_reg AND apoderado.ciudad=comuna.cor_pro AND apoderado.comuna=comuna.cor_com ";
		$sql.= " WHERE tiene2.rut_alumno=".$this->alumno."";
		if($this->responsable==1){
			$sql.= " AND responsable=1 ";
		}
		$sql.= " ORDER BY apoderado.ape_pat ASC ";
		//if($_PERFIL==0) echo $sql;
		$result_apo = @pg_Exec($conn, $sql);
		return $result_apo;
	}
	function Madre($conn){
		$sql = "SELECT apoderado.rut_apo, apoderado.dig_rut, apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, ";
		$sql.= " apoderado.telefono, apoderado.email, tiene2.responsable, apoderado.relacion,apoderado.calle,apoderado.nro, ";
		$sql.= " apoderado.profesion, apoderado.ocupacion,apoderado.nivel_edu,apoderado.nivel_social, apoderado.sexo, ";
		$sql.= " apoderado.celular FROM tiene2 INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo ";
		$sql.= " WHERE tiene2.rut_alumno=".$this->alumno." AND apoderado.sexo=1";
		if($this->responsable==1){
			$sql.= " AND responsable=1 ";
		}
	    $sql.= " ORDER BY apoderado.ape_pat ASC ";
		$result_apo = @pg_Exec($conn, $sql);
		return $result_apo;
	}
	function ApoderadoCurso($conn){
		$sql = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno in (select rut_alumno from matricula where id_curso = '".$this->cmb_curso."')) ORDER BY ape_pat ASC";  
	    $result= @pg_Exec($conn,$sql);
		return $result;
	}
	function CambiaDatoApo($fila_apo){
		$this->rut_apo 		= $fila_apo['rut_apo']." - ".$fila_apo['dig_rut'];
		$this->nombre_apo 	= ucwords(strtolower($fila_apo['nombre_apo']));
		$this->ape_pat 		= ucwords(strtolower($fila_apo['ape_pat']));
		$this->ape_mat 		= ucwords(strtolower($fila_apo['ape_mat']));
		$this->nombre		= ucwords(strtolower(ucwords(strtolower($fila_apo['ape_pat']))." ".ucwords(strtolower($fila_apo['ape_mat'])." ".$fila_apo['nombre_apo'])));
		$this->ape_nombre_apo	= ucwords(strtolower($fila_apo['ape_pat']))." ".ucwords(strtolower($fila_apo['ape_mat']))." ".ucwords(strtolower($fila_apo['nombre_apo']));
		$this->telefono_apo = $fila_apo['telefono'];
		$this->email_apo 	= $fila_apo['email'];
		$this->direccion	= $fila_apo['calle']." ".$fila_apo['nro'];
		$this->celular		= $fila_apo['celular'];
		$this->profesion	= $fila_apo['profesion'];
		$this->ocupacion	= $fila_apo['ocupacion'];
		$this->nivel_edu	= $fila_apo['nivel_edu'];
		$this->nivel_social	= $fila_apo['nivel_social'];
		$this->sexo			= $fila_apo['sexo'];
		$this->rel_apo		= $fila_apo['relacion'];
		$this->cerro_apo	= $fila_apo['cerro'];
		$this->comuna_apo	= $fila_apo['nom_com'];
				
		if ($fila_apo['responsable']==1)
			$this->relacion = "APODERADO - ";
		if ($fila_apo['relacion']==1)
			$this->relacion = $relacion."PADRE";
		if ($fila_apo['relacion']==1)
			$this->relacion = $relacion."MADRE";
		return;
	}
	function CambiaDatoEmp($result,$num){
		if($num!=0){
			$i=$num;
		}else{
			$i=0;
		}
		$fila = @pg_fetch_array($result,$num);
		$this->rut_emp 		= $fila['rut_emp']." - ".$fila['dig_rut'];	
		$this->nombre		= $fila['nombre'];
		$this->nombre_emp	= $fila['nombre_emp'];
		$this->ape_pat		= $fila['ape_pat'];
		$this->ape_mat		= $fila['ape_mat'];
		$this->cargo		= $fila['cargo'];
		$this->fecha_ingreso= $fila['fecha_ingreso'];
		$this->fecha_retiro	= $fila['fecha_retiro'];
		return;
	}
	function AlumnoRetiradoIns($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso ";
		$sql.= " FROM alumno a, matricula m, curso c WHERE m.id_ano = ".$this->ano." and m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.bool_ar = '1'  and c.id_curso = m.id_curso and c.id_ano = m.id_ano ";
		$sql.= " ORDER BY c.ensenanza, c.grado_curso, c.letra_curso,id_curso, nro_lista, nombre_alu ";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	function AlumnoRetiradoCurso($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso ";
		$sql.= " FROM alumno a, matricula m WHERE m.id_ano = ".$this->ano." and m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.id_curso = ".$this->curso." and m.bool_ar = '1' ";
		$sql.= " ORDER BY id_curso, nro_lista, nombre_alu";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	function AlumnoEvaluacionDiferencial($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso ";
		$sql.= " FROM alumno a, matricula m, curso c WHERE m.id_ano = ".$this->ano." and m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.bool_ed = '1'  and c.id_curso = m.id_curso and c.id_ano = m.id_ano ";
		$sql.= " ORDER BY c.ensenanza, c.grado_curso, c.letra_curso,id_curso, nro_lista, nombre_alu ";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	function AlumnoExtranjeroIns($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.id_curso ";
		$sql.= " FROM alumno a, matricula m, curso c WHERE m.id_ano = ".$this->ano." AND m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and a.nacionalidad != '2'  and c.id_curso = m.id_curso and c.id_ano = m.id_ano ";
		$sql.= " ORDER BY c.ensenanza, c.grado_curso, c.letra_curso,id_curso, nro_lista, nombre_alu";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	function AlumnoExtranjeroCurso($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso ";
		$sql.= " FROM alumno a, matricula m WHERE m.id_ano = ".$this->ano." AND m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.id_curso = ".$this->curso." and a.nacionalidad != '2' ";
		$sql.= " ORDER BY id_curso, nro_lista, nombre_alu";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	function AlumnoIndigenaIns($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.id_curso ";
		$sql.= " FROM alumno a, matricula m, curso c WHERE m.id_ano = ".$this->ano." AND m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.bool_aoi = '1'  and c.id_curso = m.id_curso and c.id_ano = m.id_ano ";
		$sql.= " ORDER BY c.ensenanza, c.grado_curso, c.letra_curso,id_curso, nro_lista, nombre_alu";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	function AlumnoIndigenaCurso($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso ";
		$sql.= " FROM alumno a, matricula m WHERE m.id_ano = ".$this->ano." AND m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.id_curso = ".$this->curso." and m.bool_aoi = '1' ";
		$sql.= " ORDER BY id_curso, nro_lista, nombre_alu";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	function Ensenanza($conn){
		$sql = " SELECT * FROM tipo_ensenanza WHERE cod_tipo IN (SELECT cod_tipo FROM tipo_ense_inst WHERE ";
		$sql.= " rdb = ".$this->institucion." AND cod_tipo > 9 ";
		if($this->tipo_ense!=""){
			$sql.="AND cod_tipo=".$this->tipo_ense."";
		}
		if($this->mayor!=""){
			$sql.="AND cod_tipo>".$this->mayor."";
		}
		$sql.="	ORDER BY cod_tipo)";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	function DecretoCurso($conn){
		$sql = "SELECT DISTINCT curso.cod_decreto, plan_estudio.nombre_decreto,curso.grado_curso, curso.letra_curso FROM curso INNER JOIN  ";
		$sql.= " plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto WHERE curso.id_curso=".$this->curso;
		$result = @pg_Exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$fila = @pg_fetch_array($result,0);
		$this->cod_decreto 		= $fila['cod_decreto'];
		$this->nombre_decreto 	= $fila['nombre_decreto'];
		$this->grado_curso		= $fila['grado_curso'];
		$this->letra_curso		= $fila['letra_curso'];
		return;
	}
	function EmpleadoCargo($conn){
		$sql = " SELECT empleado.rut_emp, empleado.dig_rut, (empleado.nombre_emp || ' ' || empleado.ape_pat ||' ' || ";
		$sql.= " empleado.ape_mat) as nombre, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado ";
		$sql.= " INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON ";
		$sql.= " trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$this->institucion.") AND ";
		$sql.= " ((trabaja.cargo)=".$this->cargo.")) ORDER BY trabaja.cargo, ape_pat, ape_mat, nombre_emp ASC";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	function AlumnosPromovidos($conn){
		$sql = " SELECT alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.rut_alumno, alumno.dig_rut FROM alumno ";
		$sql.= " WHERE rut_alumno IN (SELECT rut_alumno FROM promocion WHERE situacion_final='1' AND id_curso IN ";
		$sql.= " (SELECT id_curso FROM curso WHERE id_ano = ".$this->ano." AND ensenanza = ".$this->cod_tipo." AND ";
		$sql.= " grado_curso = ".$this->grado_curso."))  ORDER BY ape_pat, ape_mat, nombre_alu";
		$result= @pg_Exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	function TipoEnsenanza($conn){
		$sql = "SELECT cod_tipo,nombre_tipo FROM tipo_ensenanza WHERE cod_tipo = ".$this->cod_tipo;
		$result = @pg_exec($conn,$sql);
		$fila = @pg_fetch_array($result);
		$this->cod_tipo = $fila['cod_tipo'];
		$this->nombre	= $fila['nombre_tipo'];
		return;
	}
	function Empleado($conn){
		$sql = "SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, empleado.calle, empleado.nro, ";
		$sql.= "empleado.telefono, empleado.email, empleado.fecha_nacimiento,comuna.nom_com FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN ";
		$sql.= "institucion ON trabaja.rdb = institucion.rdb INNER JOIN comuna ON (empleado.region=comuna.cod_reg AND empleado.ciudad=comuna.cor_pro AND empleado.comuna=comuna.cor_com) ";
		$sql.= "WHERE (((institucion.rdb)=".$this->institucion.")) ";
		if($this->empleado > 0){
		$sql.= " AND empleado.rut_emp = ".$this->empleado." ";
		}
		$sql.= "ORDER BY ape_pat, ape_mat, nombre_emp asc, trabaja.cargo";
		//if($_PERFIL==0) echo $sql;
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	function AtrasoAsignaturaDocente($conn){
		$sql = " SELECT a.*, c.nombre FROM inasistencia_docente a INNER JOIN ramo b ON a.id_ramo=b.id_ramo INNER JOIN subsector c ON ";
		$sql.= " b.cod_subsector=c.cod_subsector  where rut_emp = ".$this->empleado." and ano = ".$this->ano."";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO:" .$sql);
		return $result;
	}
	function CambiaDatoAtrasoDocente($fila){
		$fecha_asig = $fila['fecha'];
		$diaa = substr($fecha_asig,8,2);
		$mesa = substr($fecha_asig,5,2);
		$annoa = substr($fecha_asig,0,4);
		$this->fecha_asig = $diaa."-".$mesa."-".$annoa;
		$this->hora_asig = $fila['hora'];
		$tipo_asig = $fila['tipo'];
		$this->ramo_asig = $fila['nombre'];
		if($tipo_asig==1) $this->tipo="Tipo: Permiso Administrativo";
		if($tipo_asig==2) $this->tipo="Tipo: Licencia Medica";
		if($tipo_asig==3) $this->tipo="Tipo: Ausente";
		return;
	}
	function AtrasoInasistenciaDocente($conn){
		$sql = "SELECT * FROM anotacion_empleado WHERE rut_emp = ".$this->empleado." AND tipo = ".$this->tipo."";
		$result =@pg_exec($conn,$sql);
		return $result;
	}
	function Entrevista($conn){
		$sql = "SELECT * FROM entrevista WHERE rdb = '".$this->institucion."' and id_ano = '".$this->ano."' and rut_alumno = '".$this->alumno."' ";
		$sql.= " order by id_entrevista";
		$result = @pg_Exec($conn,$sql) or die("SELECT FALLO :".$sql);
		return $result;
	}
	function TipoAnotaciones($conn){
		 $sql = "SELECT * FROM tipos_anotacion WHERE rdb = '".$this->institucion."' ";
		 if($this->tipo!=""){
		 	$sql.=" AND id_tipo=".$this->tipo." ";
		 } 
		 $sql.=" ORDER BY id_tipo ASC";
		 $result = pg_Exec($conn,$sql) or die("SELECT FALLO:".$sql);
		 return $result;
	}
	function DetalleAnotaciones($conn){
		$sql = "SELECT * FROM detalle_anotaciones WHERE id_tipo ='".$this->id_tipo."' ";
		if($this->codigo!=""){
			$sql.=" AND codigo = '".$this->codigo."' ";
		}
		$sql.=" ORDER BY id_anotacion ASC";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
		return $result;
	}
	function CursoEnsenanza($conn){
		$sql = "SELECT * FROM curso WHERE id_ano = '".$this->ano."' ";
		if($this->tipo_ensenanza > 0){
			$sql.=" AND ensenanza = '".$this->tipo_ensenanza."'";
		}
		if($this->grado!=""){
			$sql.= " AND grado_curso=".$this->grado."";
		}
		$sql.=" ORDER BY ensenanza,grado_curso,letra_curso ASC ";
		$result= pg_exec($conn,$sql);  
		return $result;
  }
  function Becas($conn){
  	$sql = "SELECT count(*) as total FROM matricula WHERE id_ano=".$this->ano." AND id_curso=".$this->curso." ";
	if($this->bool_baj==1){
		$sql.=" AND bool_baj=1 ";
	}
	if($this->bool_seg==1){
		$sql.=" AND bool_seg=1 ";
	}
	if($this->alum_prio==1){
		$sql.=" AND alum_prio=1 ";
	}
	if($this->bool_bchs==1){
		$sql.=" AND bool_bchs=1 ";
	}
	if($this->ben_hpv==1){
		$sql.=" AND ben_hpv=1 ";
	}
	if($this->ben_pie==1){
		$sql.=" AND ben_pie=1 ";
	}
	if($this->bool_cpadre==1){
		$sql.=" AND bool_cpadre=1 ";
	}
	if($this->bool_otros==1){
		$sql.=" AND bool_otros=1 ";
	}
	if($this->bool_mun==1){
		$sql.=" AND bool_mun=1 ";
	}
	if($this->ben_cedae==1){
		$sql.=" AND ben_cedae=1 ";
	}
	if($this->ben_puente==1){
		$sql.=" AND ben_puente=1 ";
	}
	if($this->ben_sep==1){
		$sql.=" AND ben_sep=1 ";
	}
	$sql.=" AND rut_alumno in (SELECT rut_alumno FROM alumno WHERE sexo=".$this->sexo." AND rut_alumno in(SELECT rut_alumno FROM matricula WHERE id_ano=".$this->ano." AND id_curso=".$this->curso." ))";
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO".$sql);
	$this->total = @pg_result($result,0);
	$this->result = $result;
	return;
  }	
  function Atrasos($conn){
  		$sql = "SELECT * FROM anotacion WHERE tipo = ".$this->tipo." AND rut_alumno = ".$this->rut_alumno." and fecha <='".$this->fecha2."' and fecha >='".$this->fecha1."'";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO: ".$sql);
		return $result;
  }	
  function AsistenciaApo($conn){
  		$sql = "SELECT count(*) as cantidad FROM asistencia_apo WHERE ano = ".$this->ano." AND rut_apo = ".$this->rut_apo." AND ";
		$sql.= "(fecha >='".$this->fecha1."' AND fecha <='".$this->fecha2."')";
		$result =@pg_Exec($conn,$sql);
		$this->dias_ausente = @pg_result($result,0);
		return $result;		
  }
  function DiasHabiles($conn){
  	$sql = "SELECT sum(dias_habiles) as dias_habiles FROM periodo WHERE id_ano = ".$this->ano;
	$result = @pg_exec($conn,$sql) or die("SELECT FALLO:".$sql);
	return $result;
  }
  function AlumnoEximido1($conn){
  	$sql ="SELECT * FROM tiene$this->nro_ano WHERE id_ramo=".$this->ramo." AND rut_alumno=".$this->alumno;
	$result = @pg_exec($conn,$sql);
	return $result;
  }
  function SubsectorRamo($conn){
  	$sql = "SELECT subsector.cod_subsector, subsector.nombre, ramo.id_ramo, ramo.modo_eval, ramo.conex, ramo.nota_exim,ramo.sub_obli , ramo.porc_examen ";
	$sql.= "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql.= "WHERE (((ramo.id_curso)=".$this->curso.")) ";
	if($this->modo_eval!=""){
		$sql.= "AND ramo.modo_eval<>".$this->modo_eval." ";
	}
	if($this->promocion!=""){
		$sql.= " AND bool_ip=".$this->promocion." ";
	}
	$sql.= "ORDER BY ramo.id_orden ";
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
	$fila = @pg_fetch_array($result,0);
	$this->cod_subsector = $fila['cod_subsector'];
	$this->nombre_subsector = $fila['nombre'];
	$this->id_ramo  = $fila['id_ramo'];
	$this->modo_eval = $fila['modo_eval'];
	$this->porc_examen = $fila['porc_examen'];
	$this->result =$result;
	return; 
	
  }
  function RamoAlumnoEximido($conn){
  	  $sql = "SELECT distinct ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip,subsector.nombre_ingles, ramo.cod_subsector, ramo.bool_ip,ramo.id_orden, ramo.bool_artis  ";
	  $sql.= "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	  if($this->subsector==0){
	  	$sql.= " and ramo.cod_subsector < 50000 ";
	  }
	  $sql.= " ) INNER JOIN ";
	  $sql.= "tiene$this->nro_ano ON (ramo.id_curso = tiene$this->nro_ano.id_curso) AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) ";
	  $sql.= "WHERE (((ramo.id_curso)=".$this->curso.") AND formacion=".$this->formacion." AND sub_obli=1 ) order by ramo.id_orden; ";
	  //if($_PERFIL==0) echo $sql;	  
	  $result =@pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	  $fila = @pg_fetch_array($result,0);
	  $this->id_ramo = $fila['id_ramo'];
	  $this->nombre_subsector = $fila['nombre'];
	  $this->modo_eval = $fila['modo_eval'];
	  $this->bool_ip = $fila['bool_ip'];
	  $this->nombre_ingles = $fila['nombre_ingles'];
	  $this->result = $result;
	  return;
  }
  function RamoAlumno($conn){
  	  $sql = "SELECT distinct ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip,subsector.nombre_ingles, ramo.cod_subsector, ramo.bool_ip,ramo.id_orden,ramo.bool_artis ";
	  $sql.= "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	  if($this->subsector==0){
	  	$sql.= " and ramo.cod_subsector < 50000 ";
	  }
	  $sql.= " ) INNER JOIN ";
	  $sql.= "tiene$this->nro_ano ON (ramo.id_curso = tiene$this->nro_ano.id_curso) AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) ";
	  $sql.= "WHERE (((ramo.id_curso)=".$this->curso.") AND tiene$this->nro_ano.rut_alumno=".$this->alumno." ) order by ramo.id_orden; ";
	  //if($_PERFIL==0) echo $sql;
	  $result =@pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	  $fila = @pg_fetch_array($result,0);
	  $this->id_ramo = $fila['id_ramo'];
	  $this->nombre_subsector = $fila['nombre'];
	  $this->modo_eval = $fila['modo_eval'];
	  $this->bool_ip = $fila['bool_ip'];
	  $this->nombre_ingles = $fila['nombre_ingles'];
	  $this->result = $result;
	  return;
  }
  function RamoAlumnoGeneral($conn){
  		$sql = " SELECT ramo.id_ramo, subsector.nombre,subsector.nombre_ingles, ramo.modo_eval, ramo.bool_ip FROM (ramo INNER JOIN subsector ON ";
		$sql.= " ramo.cod_subsector = subsector.cod_subsector and ramo.cod_subsector < 50000) INNER JOIN tiene$this->nro_ano ON ";
		$sql.= " (ramo.id_curso = tiene$this->nro_ano.id_curso) AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) ";
		$sql.= " WHERE (((ramo.id_curso)=".$this->curso.") AND ((tiene$this->nro_ano.rut_alumno)='".$this->alumno."') and ";
		$sql.= " (ramo.cod_subsector<1000 and ramo.cod_subsector <> 250 and ramo.cod_subsector !=42 and ramo.cod_subsector !=742 and ";
		$sql.= " ramo.cod_subsector !=43 and ramo.cod_subsector !=395 and ramo.cod_subsector !=488 and ramo.cod_subsector !=155 and ramo.cod_subsector !=136 ";
		$sql.= " or ramo.cod_subsector =3574)) ORDER BY ramo.id_orden";
        $result =@pg_exec($conn,$sql);
		$this->result = $result;
		return;
  }
  function RamoFormacion($conn){
  		$sql ="SELECT distinct ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip,subsector.nombre_ingles, ramo.cod_subsector, ramo.bool_ip,ramo.id_orden,ramo.formacion, ramo.bool_artis ";
		$sql.="FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ) INNER JOIN tiene$this->nro_ano ON (ramo.id_curso = tiene$this->nro_ano.id_curso) ";
		$sql.="AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) WHERE (((ramo.id_curso)=".$this->curso.") AND tiene$this->nro_ano.rut_alumno=".$this->alumno." AND  ";
		$sql.="ramo.formacion=".$this->formacion." ) order by ramo.id_orden ASC; ";
		$result = @pg_exec($conn,$sql) or die("SELECT FALLO :".$sql);
		$this->id_ramo = $fila['id_ramo'];
  	    $this->nombre_subsector = $fila['nombre'];
	    $this->modo_eval = $fila['modo_eval'];
	    $this->bool_ip = $fila['bool_ip'];
	    $this->nombre_ingles = $fila['nombre_ingles'];
	    $this->result = $result;

		return $result;
  }
   function RamoAlumnoEximidoIntrumental($conn){
  	 $sql ="SELECT distinct ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip,subsector.nombre_ingles, ramo.cod_subsector, ramo.bool_ip,ramo.id_orden,ramo.formacion, ramo.bool_artis ";
		$sql.="FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ) INNER JOIN tiene$this->nro_ano ON (ramo.id_curso = tiene$this->nro_ano.id_curso) ";
		$sql.="AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) WHERE (((ramo.id_curso)=".$this->curso.") AND  ";
		$sql.="ramo.formacion=".$this->formacion." ) order by ramo.id_orden ASC; ";
	  //if($_PERFIL==0) echo $sql;	  
	  $result =@pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	  $fila = @pg_fetch_array($result,0);
	  $this->id_ramo = $fila['id_ramo'];
	  $this->nombre_subsector = $fila['nombre'];
	  $this->modo_eval = $fila['modo_eval'];
	  $this->bool_ip = $fila['bool_ip'];
	  $this->nombre_ingles = $fila['nombre_ingles'];
	  $this->result = $result;
	  return;
  }
  function RamoFormacionDiferenciada($conn){
  		$sql ="SELECT distinct ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip,subsector.nombre_ingles, ramo.cod_subsector, ramo.bool_ip,ramo.id_orden,ramo.formacion ";
		$sql.="FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ) INNER JOIN tiene$this->nro_ano ON (ramo.id_curso = tiene$this->nro_ano.id_curso) ";
		$sql.="AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) WHERE (((ramo.id_curso)=".$this->curso.") AND tiene$this->nro_ano.rut_alumno=".$this->alumno." AND  ";
		$sql.="ramo.formacion=2 ) order by ramo.id_orden; ";
		$result = @pg_exec($conn,$sql) or die("SELECT FALLO :".$sql);
		$this->id_ramo = $fila['id_ramo'];
  	    $this->nombre_subsector = $fila['nombre'];
	    $this->modo_eval = $fila['modo_eval'];
	    $this->bool_ip = $fila['bool_ip'];
	    $this->nombre_ingles = $fila['nombre_ingles'];
	    $this->result = $result;
		return $result;
  }
  function RamoAlumnoEximidoDiferenciada($conn){
  	 	$sql ="SELECT distinct ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip,subsector.nombre_ingles, ramo.cod_subsector, ramo.bool_ip,ramo.id_orden,ramo.formacion ";
		$sql.="FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ) INNER JOIN tiene$this->nro_ano ON (ramo.id_curso = tiene$this->nro_ano.id_curso) ";
		$sql.="AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) WHERE (((ramo.id_curso)=".$this->curso.") AND  ";
		$sql.="ramo.formacion=2 ) order by ramo.id_orden; ";
	  //if($_PERFIL==0) echo $sql;	  
	  $result =@pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	  $fila = @pg_fetch_array($result,0);
	  $this->id_ramo = $fila['id_ramo'];
	  $this->nombre_subsector = $fila['nombre'];
	  $this->modo_eval = $fila['modo_eval'];
	  $this->bool_ip = $fila['bool_ip'];
	  $this->nombre_ingles = $fila['nombre_ingles'];
	  $this->result = $result;
	  return;
  }

   function RamoAlumnoDiferenciada($conn){
  		$sql = " SELECT ramo.id_ramo, subsector.nombre, subsector.nombre_ingles, ramo.modo_eval, ramo.bool_ip FROM (ramo INNER JOIN subsector ON ";
		$sql.= " ramo.cod_subsector = subsector.cod_subsector and ramo.cod_subsector < 50000) INNER JOIN tiene$this->nro_ano ON ";
		$sql.= " (ramo.id_curso = tiene$this->nro_ano.id_curso) AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) ";
		$sql.= " WHERE (((ramo.id_curso)=".$this->curso.") AND ((tiene$this->nro_ano.rut_alumno)='".$this->alumno."') and ";
		$sql.= " ((ramo.cod_subsector>999 AND ramo.cod_subsector!=3574) OR ramo.cod_subsector =250 OR ramo.cod_subsector =42 OR ramo.cod_subsector =742 OR ";
		$sql.= " ramo.cod_subsector =43 OR ramo.cod_subsector =395 OR ramo.cod_subsector =488 OR ramo.cod_subsector=155 OR ramo.cod_subsector =136)) ";
		$sql.= " ORDER BY ramo.id_orden";
        $result =@pg_exec($conn,$sql);
		$this->result = $result;
		return;
  }
  function AlumnoTaller($conn){
  		$sql = " SELECT t.* FROM taller as t INNER JOIN tiene_taller as tt ON t.id_taller=tt.id_taller ";
		$sql.= " WHERE rut_alumno=".$this->alumno." and id_ano=".$this->ano." ";
        $result =@pg_exec($conn,$sql);
		$this->result = $result;
		return;
  }
  function ProfeSubsector($conn){
 	$sql = "SELECT dicta.id_ramo, empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql.= "FROM dicta INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp ";
	$sql.= "WHERE (((dicta.id_ramo)=".$this->ramo.")); ";
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
	$fila = @pg_fetch_array($result,0);
	$this->id_ramo = $fila['id_ramo'];
	$this->ape_pat = $fila['ape_pat'];
	$this->ape_mat = $fila['ape_mat'];
	$this->nombre_emp = $fila['nombre_emp'];
	$this->nombre_ape = ucwords(strtolower($fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_emp']));
	$this->result_sub = $result;
	return;	
  }
  function AlumnosTiene($conn){
  	$sql =" SELECT  tiene$this->nro_ano .rut_alumno ,alumno.ape_pat || cast(' ' as varchar) || CAST(' ' as varchar) ||  ape_mat || cast(' ' as varchar) ||  alumno.nombre_alu  as nombres FROM tiene$this->nro_ano INNER JOIN alumno ON tiene$this->nro_ano.rut_alumno=alumno.rut_alumno WHERE id_ramo=".$this->ramo." AND tiene$this->nro_ano.rut_alumno in (SELECT rut_alumno FROM ";
	$sql.=" matricula$this->nro_ano WHERE id_ano=".$this->ano." AND rdb=".$this->institucion." AND id_curso=".$this->curso." and bool_ar=".$this->bool_ar." ORDER BY nro_lista ASC) ";
	$result = @pg_exec($conn,$sql);
	//if($_PERFIL==0) echo $sql;
	return $result;
  }
  function AlumnosSubsector($conn){
  	$sql =" SELECT matricula .rut_alumno ,alumno.ape_pat || cast(' ' as varchar) || CAST(' ' as varchar) || ape_mat || cast(' ' as varchar) || ";
	$sql.=" alumno.nombre_alu as nombres FROM matricula INNER JOIN alumno ON matricula.rut_alumno=alumno.rut_alumno WHERE rdb=".$this->institucion." ";
	$sql.=" AND id_ano=".$this->ano." AND id_curso=".$this->curso." and bool_ar=0 AND matricula.rut_alumno in (SELECT rut_alumno FROM tiene$this->nro_ano ";
	$sql.=" WHERE id_ramo=".$this->ramo.") ";
	if($this->orden==0){
		$sql.=" ORDER BY nro_lista ASC";
	}else{
		$sql.=" ORDER BY nombres ASC";
	}
	$result = @pg_exec($conn,$sql);
	return $result;
  }
  function Notas($conn){
  	$sql =" SELECT id_ramo, id_periodo,rut_alumno, nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, ";
	$sql.=" nota13, nota14, nota15, nota16, nota17, nota18, nota19, nota20, promedio, notaap";
	$sql.=" FROM notas$this->nro_ano  WHERE id_ramo=".$this->ramo." ";
	if($this->periodo!=""){
		$sql.=" AND id_periodo=".$this->periodo." ";
	}
	if($this->rut_alumno!=""){
		$sql.=" AND rut_alumno='".$this->rut_alumno."'";
	}
	
	//if($_PERFIL==0) echo $sql;
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (Notas):".$sql);
	return $result;
  }
  function NotasExamen($conn){
  	$sql = "SELECT nota,porc,bool_ap FROM notas_examen a INNER JOIN examen_semestral b ON a.id_examen=b.id_examen WHERE a.id_ramo=".$this->ramo." AND rut_alumno=".$this->rut_alumno." AND periodo=".$this->periodo;
	$result = @pg_exec($conn,$sql) or die ("SELECT EXAMEN FALLO :".$sql);
	return $result;
	
  }
  function NotasTaller($conn){
  	$sql =" SELECT nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14, nota15, ";
	$sql.=" nota16, nota17,  nota18,  nota19,  nota20,  promedio ";
	$sql.=" FROM notas_taller WHERE rut_alumno='".$this->alumno."' ";
	if($this->taller!=""){
		$sql.=" AND id_taller=".$this->taller." ";
	}
	if($this->periodo!=""){
		$sql.=" AND  id_periodo=".$this->periodo." ";
	}
	$result =@pg_Exec($conn,$sql);
	return $result;
  }
  function CambiaNota($fila2){
  	if($this->modo_eval==1){
		if ($fila2['nota1']>0) $this->nota1 = $fila2['nota1']; else $this->nota1 = "&nbsp;";
		if ($fila2['nota2']>0) $this->nota2 = $fila2['nota2']; else $this->nota2 = "&nbsp;";
		if ($fila2['nota3']>0) $this->nota3 = $fila2['nota3']; else $this->nota3 = "&nbsp;";
		if ($fila2['nota4']>0) $this->nota4 = $fila2['nota4']; else $this->nota4 = "&nbsp;";
		if ($fila2['nota5']>0) $this->nota5 = $fila2['nota5']; else $this->nota5 = "&nbsp;";
		if ($fila2['nota6']>0) $this->nota6 = $fila2['nota6']; else $this->nota6 = "&nbsp;";
		if ($fila2['nota7']>0) $this->nota7 = $fila2['nota7']; else $this->nota7 = "&nbsp;";
		if ($fila2['nota8']>0) $this->nota8 = $fila2['nota8']; else $this->nota8 = "&nbsp;";
		if ($fila2['nota9']>0) $this->nota9 = $fila2['nota9']; else $this->nota9 = "&nbsp;";
		if ($fila2['nota10']>0) $this->nota10 = $fila2['nota10']; else $this->nota10 = "&nbsp;";
		if ($fila2['nota11']>0) $this->nota11 = $fila2['nota11']; else $this->nota11 = "&nbsp;";
		if ($fila2['nota12']>0) $this->nota12 = $fila2['nota12']; else $this->nota12 = "&nbsp;";
		if ($fila2['nota13']>0) $this->nota13 = $fila2['nota13']; else $this->nota13 = "&nbsp;";
		if ($fila2['nota14']>0) $this->nota14 = $fila2['nota14']; else $this->nota14 = "&nbsp;";
		if ($fila2['nota15']>0) $this->nota15 = $fila2['nota15']; else $this->nota15 = "&nbsp;";
		if ($fila2['nota16']>0) $this->nota16 = $fila2['nota16']; else $this->nota16 = "&nbsp;";
		if ($fila2['nota17']>0) $this->nota17 = $fila2['nota17']; else $this->nota17 = "&nbsp;";
		if ($fila2['nota18']>0) $this->nota18 = $fila2['nota18']; else $this->nota18 = "&nbsp;";
		if ($fila2['nota19']>0) $this->nota19 = $fila2['nota19']; else $this->nota19 = "&nbsp;";
		if ($fila2['nota20']>0) $this->nota20 = $fila2['nota20']; else $this->nota20 = "&nbsp;";		
	}else{
		if (chop($fila2['nota1'])=="0" or chop($fila2['nota1'])=="") $this->nota1 = "&nbsp;";  else $this->nota1 = $fila2['nota1'];
		if (chop($fila2['nota2'])=="0" or chop($fila2['nota2'])=="")  $this->nota2 = "&nbsp;"; else $this->nota2 = $fila2['nota2'];
		if (chop($fila2['nota3'])=="0" or chop($fila2['nota3'])=="")  $this->nota3 = "&nbsp;"; else $this->nota3 = $fila2['nota3'];
		if (chop($fila2['nota4'])=="0" or chop($fila2['nota4'])=="")  $this->nota4 = "&nbsp;"; else $this->nota4 = $fila2['nota4'];
		if (chop($fila2['nota5'])=="0" or chop($fila2['nota5'])=="")  $this->nota5 = "&nbsp;"; else $this->nota5 = $fila2['nota5'];
		if (chop($fila2['nota6'])=="0" or chop($fila2['nota6'])=="")  $this->nota6 = "&nbsp;"; else $this->nota6 = $fila2['nota6'];
		if (chop($fila2['nota7'])=="0" or chop($fila2['nota7'])=="")  $this->nota7 = "&nbsp;"; else $this->nota7 = $fila2['nota7'];
		if (chop($fila2['nota8'])=="0" or chop($fila2['nota8'])=="")  $this->nota8 = "&nbsp;"; else $this->nota8 = $fila2['nota8'];
		if (chop($fila2['nota9'])=="0" or chop($fila2['nota9'])=="")  $this->nota9 = "&nbsp;"; else $this->nota9 = $fila2['nota9'];
		if (chop($fila2['nota10'])=="0" or chop($fila2['nota10'])=="")  $this->nota10 = "&nbsp;"; else $this->nota10 = $fila2['nota10'];
		if (chop($fila2['nota11'])=="0" or chop($fila2['nota11'])=="")  $this->nota11 = "&nbsp;"; else $this->nota11 = $fila2['nota11'];
		if (chop($fila2['nota12'])=="0" or chop($fila2['nota12'])=="")  $this->nota12 = "&nbsp;"; else $this->nota12 = $fila2['nota12'];
		if (chop($fila2['nota13'])=="0" or chop($fila2['nota13'])=="")  $this->nota13 = "&nbsp;"; else $this->nota13 = $fila2['nota13'];
		if (chop($fila2['nota14'])=="0" or chop($fila2['nota14'])=="")  $this->nota14 = "&nbsp;"; else $this->nota14 = $fila2['nota14'];
		if (chop($fila2['nota15'])=="0" or chop($fila2['nota15'])=="")  $this->nota15 = "&nbsp;"; else $this->nota15 = $fila2['nota15'];
		if (chop($fila2['nota16'])=="0" or chop($fila2['nota16'])=="")  $this->nota16 = "&nbsp;"; else $this->nota16 = $fila2['nota16'];
		if (chop($fila2['nota17'])=="0" or chop($fila2['nota17'])=="")  $this->nota17 = "&nbsp;"; else $this->nota17 = $fila2['nota17'];
		if (chop($fila2['nota18'])=="0" or chop($fila2['nota18'])=="")  $this->nota18 = "&nbsp;"; else $this->nota18 = $fila2['nota18'];
		if (chop($fila2['nota19'])=="0" or chop($fila2['nota19'])=="")  $this->nota19 = "&nbsp;"; else $this->nota19 = $fila2['nota19'];
		if (chop($fila2['nota20'])=="0" or chop($fila2['nota20'])=="")  $this->nota20 = "&nbsp;"; else $this->nota20 = $fila2['nota20'];
	}
	return;
  }
  function Promocion($conn){
  	$sql = "SELECT * FROM promocion WHERE rdb=".$this->institucion." ";
	if($this->ano!=""){
		$sql.=" AND id_ano=".$this->ano." ";
	}
	if($this->curso!=""){
		$sql.="AND id_curso=".$this->curso." ";
	}
	if($this->situacion!=""){
		$sql.= "AND situacion_final=".$this->situacion."  ";
	}
	if($this->alumno!=""){
		$sql.=" AND rut_alumno=".$this->alumno."";
	}
	$result =@pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	return $result;
  }
  function SituacionFinal($conn){
  	$sql= " SELECT rut_alumno,id_ramo, prom_gral, nota_examen, nota_final, prueba_especial, nota_exam_esc, nota_exam_oral FROM situacion_final ";
	$sql.=" WHERE rut_alumno = '".$this->alumno."' AND id_ramo = ".$this->ramo;
	$result =@pg_exec($conn,$sql);
	return $result;
  }
  function MejoresPromedios($conn){
  	$sql =" SELECT p.promedio FROM promocion p, curso c WHERE  c.id_curso = p.id_curso ";
	if($this->ano!=""){
		$sql.=" AND c.id_ano = ".$this->ano." ";
	}
	if($this->grado!=""){
		$sql.=" AND c.grado_curso = ".$this->grado." ";
	}
	if($this->ensenanza!=""){
		$sql.=" AND c.ensenanza = ".$this->ensenanza." ";
	}
	$sql.=" ORDER BY  p.promedio DESC";
	$result = pg_exec($conn,$sql) or die ("SELECT FALLO (mejores promedios):".$sql);
	return $result;
  }
  function MejoresPromediosAlumnos($conn){
  	$sql =" SELECT al.rut_alumno, al.dig_rut, al.nombre_alu, al.ape_pat, al.ape_mat, al.comuna, c.id_curso, c.grado_curso, c.ensenanza, ";
	$sql.=" c.letra_curso, p.promedio, co.nom_com FROM alumno al, promocion p, curso c, comuna co WHERE c.id_curso = p.id_curso AND ";
	$sql.=" p.rut_alumno = al.rut_alumno AND al.region = co.cod_reg AND al.ciudad = co.cor_pro AND al.comuna = co.cor_com  ";
	if($this->ano!=""){
		$sql.=" AND c.id_ano = ".$this->ano. ""; 
	}
	if($this->grado!=""){
		$sql.=" AND c.grado_curso = ".$this->grado."";
	}
	if($this->ensenanza!=""){
		$sql.=" AND c.ensenanza = ".$this->ensenanza." ";
	}
	if($this->promedio!=""){
		$sql.=" AND p.promedio >= ".$this->promedio." ";
	}
	$sql.=" ORDER BY p.promedio DESC";
	$result = @pg_Exec($conn,$sql);
	return $result;
		
  }
  function PromedioRamo($conn){
  	$sql ="SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador FROM notas$this->nro_ano WHERE id_ramo IN (SELECT id_ramo FROM ";
	$sql.=" ramo WHERE id_curso=".$this->curso.") AND id_periodo=".$this->periodo." AND promedio NOT IN('0','MB','B','S','I',' ') AND promedio > '0'";
	$result = @pg_exec($conn,$sql);
	$this->suma = @pg_result($result,0);
	$this->contador = @pg_result($result,1);
	$this->result = $result;
	return;
  }
  function PromedioRamoCurso($conn){
  	$sql ="SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador FROM notas$this->nro_ano WHERE id_ramo=".$this->ramo." AND promedio NOT IN('0','MB','B','S','I',' ')  AND promedio>'0' ";
	if($this->periodo!=""){
		$sql.="AND id_periodo=".$this->periodo."";
	}
	//if($_PERFIL==0) echo "<br>".$sql;
	$result = @pg_exec($conn,$sql);
	$this->suma_curso = @pg_result($result,0);
	$this->contador_curso =@pg_result($result,1);
	$this->result = $result;
	return;
  }
  function PromedioRamoCursoFinal($conn){
  	$sql ="SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador FROM promedio_sub_alumno WHERE id_ramo=".$this->ramo." AND promedio NOT IN('0','MB','B','S','I',' ')  AND promedio>'0' AND rut_alumno in (SELECT rut_alumno FROM promocion WHERE id_ramo=".$this->ramo." AND situacion_final=1)";
	$result = @pg_exec($conn,$sql);
	//echo $sql;
	$this->suma_curso = @pg_result($result,0);
	$this->contador_curso =@pg_result($result,1);
	$this->result = $result;
	return;
  }
  function PromedioAPRamoCurso($conn){
  	$sql ="SELECT sum(cast (notaap as INTEGER)) as suma, count(*) as contador FROM notas$this->nro_ano WHERE id_ramo=".$this->ramo." AND notaap>0";
	if($this->periodo!=""){
		$sql.="AND id_periodo=".$this->periodo."";
	}
	$result = @pg_exec($conn,$sql);
	$this->suma = @pg_result($result,0);
	$this->contador =@pg_result($result,1);
	$this->result = $result;
	return;
  }
  function PromedioAlumno($conn){
  	$sql = "SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador,sum(cast (notaap as INTEGER)) as promedioap FROM notas$this->nro_ano WHERE id_ramo in ";
	$sql.= "(SELECT id_ramo FROM ramo WHERE id_ramo in (SELECT id_ramo ";
	$sql.= " FROM notas$this->nro_ano WHERE id_periodo = '".$this->periodos."' AND rut_alumno = '".$this->alumno."') and cod_subsector < 50000 ";
	$sql.= " and bool_ip=1) AND rut_alumno = '".$this->alumno."' AND id_periodo = '".$this->periodos."' ";
	$sql.= " AND promedio NOT IN ('MB','B','S','I','0',' ','P')";
	//if($_PERFIL==0 and $this->alumno==18034457) echo $sql;
	$result =@pg_exec($conn,$sql);
	$this->suma = @pg_result($result,0);
	$this->contador = @pg_result($result,1);
	$this->sumaAP = @pg_result($result,2);
	$this->result = $result;
	$this->sql = $sql;
	return;
  }
  function PromedioAlumnoTaller($conn){
   	$sql = "SELECT sum(CAST(promedio as INTEGER)) as suma, count(promedio) as contador FROM notas_taller ";
	$sql.= " WHERE rut_alumno in (SELECT rut_alumno FROM tiene_taller WHERE rut_alumno=".$this->alumno." AND id_periodo=".$this->periodo.") ";
	$sql.= " AND promedio not in ('MB','B','S','I','0')";
	$result =@pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$this->suma = @pg_result($result,0);
	$this->contador = @pg_result($result,1);
	$this->result = $result;
	return;
  }
  function NombreSubsector($conn){
  	$sql = "SELECT ramo.id_ramo,subsector.nombre,ramo.modo_eval,ramo.conex,ramo.sub_obli,sub_elect,ramo.truncado,ramo.bool_artis,ramo.cod_subsector  FROM subsector, ramo WHERE  ";
	$sql.= " ramo.cod_subsector = subsector.cod_subsector ";
	if($this->subsector!=0){
		$sql.=" AND ramo.id_ramo = ".$this->subsector." ";
	}
	if($this->curso!=""){
		$sql.=" AND ramo.id_curso=".$this->curso."";
	}
	if($this->incide!=""){
		$sql.=" AND bool_ip=".$this->incide."";
	}
	$sql.=" ORDER BY id_orden ASC ";
	$result = @pg_exec($conn,$sql) or die( "SELECT FALLO :".$sql);
	//if($_PERFIL==0) echo $sql;
	$this->nombre_sub = pg_result($result,1);
	$this->modo_eval = pg_result($result,2);
	$this->result = $result;
	return;
  }
  function AlumnoPromovido($conn){
  	$sql =" SELECT alumno.rut_alumno, alumno.dig_rut FROM promocion, alumno WHERE promocion.id_curso = ".$this->curso." AND ";
	$sql.=" promocion.situacion_final = ".$this->situacion." AND promocion.rut_alumno = alumno.rut_alumno AND alumno.sexo = ".$this->sexo." ";
	$result = pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	return $result;
  }
  function Curso($conn){
	$sql = " SELECT plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.truncado_per, curso.truncado_final ";
	$sql.= " FROM (curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON ";
	$sql.= " curso.cod_eval = evaluacion.cod_eval WHERE (((curso.id_curso)=".$this->curso."));";
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$fila = @pg_fetch_array($result,0);
	$this->NombreDecreto = $fila['nombre_decreto'];
	$this->NombreDecretoEval = $fila['nombre_decreto_eval'];
	$this->truncado = $fila['truncado_per'];
	$this->truncado_final = $fila['truncado_final'];
	return;
  }
  function ListadoCurso($conn){
	$sql= "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
	$sql.= "curso.ensenanza, curso.cod_decreto ";
	$sql.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql.= "WHERE (((curso.id_ano)=".$this->ano.")";
	if($this->ensenanza!=""){
		$sql.=" AND ensenanza= ".$this->ensenanza."";
	}
	$sql.= " ) ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso ";
	$result = pg_exec($conn,$sql) or die ("Select falló: ".$sql);
	return $result;
	}
	function ListadoSubsectores($conn){
		$sql = "SELECT distinct RAMO.cod_subsector,nombre 
FROM ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector WHERE id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$this->ano. " AND ensenanza=".$this->ensenanza.")";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (listadosubsectores):".$sql);
		return $result;
		
	}
	function PromedioCurso($conn){
		$sql = " SELECT (sum(CAST(promedio as integer)) / count(*)) AS promedio FROM notas$this->nro_ano WHERE id_periodo=".$this->periodo." ";
		$sql.= " AND id_ramo IN (SELECT id_ramo FROM ramo WHERE ramo.id_curso=".$this->curso." AND ramo.cod_subsector=".$this->subsector.") and promedio>'0'";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (promedio curso):".$sql);
		$this->promedio = @pg_result($result,0);
		return;
	}
	function MatriculaCurso($conn){
		$sql ="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, ";
		$sql.=" curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$this->alumno."' and matricula.id_ano=".$this->ano." and  ";
		$sql.="matricula.id_curso=curso.id_curso";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLO (promedio curso):".$sql);
		return $result;
	}
	function MatriculaCursoAnual($conn){
		$sql= "SELECT count(*) as cuenta, id_curso  FROM matricula where id_ano=".$this->ano." and BOOL_AR=0 GROUP BY ID_CURSO";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (promedio curso):".$sql);
		return $result;
	}
	function InasistenciaHombre($conn){
		$sql ="SELECT count(*) FROM alumno WHERE rut_alumno IN(SELECT a.rut_alumno FROM matricula a INNER JOIN asistencia b ON a.id_ano=b.ano AND ";
		$sql.="a.id_curso=b.id_curso AND a.rut_alumno=b.rut_alumno WHERE a.id_ano=".$this->ano." AND a.id_curso=".$this->curso." AND ";
		$sql.="b.fecha='".$this->fecha."' AND bool_ar=0) AND sexo=2";
 		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (InasistenciaHombre):".$sql);
		return $result;
	}
	function InasistenciaMujer($conn){
		$sql ="SELECT count(*) FROM alumno WHERE rut_alumno IN(SELECT a.rut_alumno FROM matricula a INNER JOIN asistencia b ON a.id_ano=b.ano AND ";
		$sql.="a.id_curso=b.id_curso AND a.rut_alumno=b.rut_alumno WHERE a.id_ano=".$this->ano." AND a.id_curso=".$this->curso." AND ";
		$sql.="b.fecha='".$this->fecha."' AND bool_ar=0) AND sexo=1";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (InasistenciaMujer):".$sql);
		return $result;
	}
	function MatriculaHombre($conn){
		$sql ="SELECT COUNT(*) FROM alumno a INNER JOIN matricula b ON a.rut_alumno=b.rut_alumno WHERE id_ano=".$this->ano." AND id_curso=".$this->curso." ";
		$sql.=" AND sexo=2";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (MatriculaHombre):".$sql);
		return $result;
	}
	function MatriculaMujer($conn){
		$sql ="SELECT COUNT(*) FROM alumno a INNER JOIN matricula b ON a.rut_alumno=b.rut_alumno WHERE id_ano=".$this->ano." AND id_curso=".$this->curso." ";
		$sql.=" AND sexo=1";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (MatriculaHombre):".$sql);
		return $result;
	}
	function InformePlantilla($conn){
		$sql="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$this->ensenanza." AND $this->grado=1 and activa=1 AND rdb=".$this->institucion;
		$result=@pg_exec($conn,$sql) ;
		return $result;
	}
	function InformeAreas($conn){
		if($this->nuevo==1){
			 $sql="select * from informe_area_item where id_plantilla=".$this->plantilla." and id_padre=0 order by id";
		}else{
			$sql="SELECT * FROM informe_area WHERE id_plantilla=".$this->plantilla."";
		}
		$result =pg_exec($conn,$sql) or die ("SELECT FALLO (InformeArea):".$sql);
		return $result;
	}
	function InformeSubarea($conn){
		if($this->nuevo==1){
			$sql="SELECT * FROM informe_area_item WHERE id_plantilla=".$this->plantilla." AND id_padre<>0 AND id_padre=".$this->id_padre." ORDER BY id, id_padre ASC";
		}else{
			$sql="SELECT * FROM informe_subarea WHERE id_area=".$this->id_area;
		}
		$result =pg_exec($conn,$sql) or die ("SELECT FALLO (InformeSubArea):".$sql);
		return $result;

	}
	function InformeItem($conn){
		if($this->nuevo==1){
			$sql="SELECT * FROM informe_area_item WHERE id_plantilla=".$this->plantilla." AND id_padre<>0 AND id_padre=".$this->id_padre." ORDER BY id ASC";
		}else{
			$sql="SELECT * FROM informe_item WHERE id_subarea=".$this->id_subarea." ORDER BY id_item ASC";													
		}
		$result =pg_exec($conn,$sql) or die ("SELECT FALLO (InformeItem):".$sql);
		return $result;
	}
	function InformeConcepto($conn){
		//echo $institucion;
		if($this->nuevo==1){
		    if ($_INSTIT==2278){   // no entra ni cagando por que la variable viene vacía.....
				 $tabla_informe = 'informe_evaluacion2_new';	
			}else{
				 $tabla_informe = 'informe_evaluacion2';											
			}
			$sql ="SELECT * FROM $tabla_informe WHERE id_ano=".$this->ano." AND id_periodo=".$this->periodo." AND id_plantilla=".$this->plantilla." AND ";
			$sql.=" id_informe_area_item=".$this->id_item." AND rut_alumno=".$this->alumno."";
		}else{
		   	$sql ="SELECT * FROM informe_evaluacion WHERE id_item=".$this->id_item." AND id_ano=".$this->ano." and id_periodo=".$this->periodo." AND ";
			$sql.="rut_alumno='".$this->alumno."'";
		}
		
		$result =pg_exec($conn,$sql);
		return $result;
	}
	function InformeEvaluacion($conn){
		$sql ="SELECT * FROM informe_concepto_eval WHERE id_concepto=".$this->respuesta."";
		$result=pg_exec($conn,$sql);
		return $result;
	}
	function InformeObservaciones($conn){
		$sql ="SELECT * FROM informe_observaciones INNER JOIN periodo ON informe_observaciones.id_periodo=periodo.id_periodo WHERE ";
		$sql.="informe_observaciones.id_ano=".$this->ano." AND informe_observaciones.id_plantilla=".$this->plantilla." AND ";
		$sql.=" informe_observaciones.rut_alumno='".$this->alumno."'";
		if($this->periodo!=""){
			$sql.=" AND informe_observaciones.id_periodo=".$this->periodo;
		}
		//if($_PERFIL==0) echo $sql;
	    $result =@pg_exec($conn,$sql)or die ("SELECT FALLO (InformeObservaciones):".$sql);
		return $result;
	}	
	function Padres($conn){
		$sql = "SELECT a.rut_apo,dig_rut,nombre_apo, ape_pat,ape_mat,nivel_edu,profesion,nivel_social FROM apoderado a INNER JOIN tiene2 b ON a.rut_apo=b.rut_apo WHERE ";
		$sql.= " b.rut_alumno=".$this->rut_alumno." AND sexo=".$this->sexo;
		$result = @pg_exec($conn,$sql)or die ("SELECT FALLO (Padres):".$sql);
		$fila = @pg_fetch_array($result,0);
		$this->rut_padre = $fila['rut_apo']."-".$fila['dig_rut'];
		$this->nombre_padre = $fila['nombre_apo']." ".$fila['ape_pat']." ".$fila['ape_mat'];
		$this->educacion = $fila['nivel_edu'];
		$this->profesion = $fila['profesion'];
		$this->nivel_social = $fila['nivel_social'];
		return;		 
	}
	function PromedioSubAlumno($conn){
		$sql = "SELECT promedio FROM promedio_sub_alumno WHERE id_ano=".$this->ano." AND id_curso=".$this->curso." AND id_ramo=".$this->ramo." AND ";
		$sql.= "rut_alumno=".$this->alumno;
		//if($_PERFIL==0) echo $sql;		
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	function Minimo($conn){
		 $sql="SELECT min(promedio) FROM promedio_sub_alumno WHERE rdb=".$this->institucion." and id_curso=".$this->curso." ";
		 $sql.="and id_ramo=".$this->ramo." and promedio!=0 and promedio!='-' and id_ano=".$this->ano." and rut_alumno in (SELECT rut_alumno FROM ";
		 $sql.="matricula WHERE bool_ar=0) "; 
		 $result =pg_exec($conn,$sql) or die ("Fallo sql:".$sql);
		 return $result;
			}	
	function Maximo($conn){
		 $sql="SELECT max(promedio) FROM promedio_sub_alumno WHERE rdb=".$this->institucion." and id_curso=".$this->curso." ";
		 $sql.="and id_ramo=".$this->ramo." and promedio!=0 and promedio!='-'  and id_ano=".$this->ano." and rut_alumno in (SELECT rut_alumno FROM ";
		 $sql.="matricula WHERE bool_ar=0) "; 
		 $result =pg_exec($conn,$sql) or die ("Fallo sql:".$sql);
		 return $result;
			}	
   	function Promedio($conn){
		 $sql="SELECT avg(cast(promedio as integer)) FROM promedio_sub_alumno WHERE rdb=".$this->institucion." and  ";
	     $sql.="id_curso=".$this->curso." and promedio!=0 and promedio!='-' and id_ramo=".$this->ramo."  and id_ano=".$this->ano." and rut_alumno in ";
	   	 $sql.="(SELECT rut_alumno FROM matricula WHERE bool_ar=0) ";
		 $result =pg_exec($conn,$sql) or die ("Fallo sql:".$sql);
		 return $result;
	}	
		
	 
	function AsistenciaAno($conn){
	  $sql="SELECT count(*) as cont,fecha FROM asistencia WHERE ano = ".$this->ano." ";
	  if($this->nro_ano!=""){
	   $sql.="and date_part('year',fecha)=".$this->nro_ano." ";
	  }
	  if($this->mes!=""){
	   $sql.="and date_part('month',fecha)=".$this->mes." ";
	  }
	 $sql.=" GROUP BY fecha ORDER BY fecha ASC";
	 $result = @pg_exec($conn,$sql);
	 return $result;
	 }
	function AsistenciaCurso($conn){
		$sql="SELECT count(*) as cont,fecha,id_curso FROM asistencia WHERE ano=".$this->ano." GROUP BY id_curso, fecha ";
		$sql.="ORDER BY id_curso ASC ";
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	function AsistenciaCursoAnual($conn){
		$sql ="SELECT count(*) as cuenta, id_curso,date_part('month',fecha) as fecha  FROM asistencia where ano=".$this->ano." GROUP BY ID_CURSO,date_part('month',fecha) ";
		$result = @pg_exec($conn,$sql);
		return $result; 
	}
	 function TotalAsistencia($conn){
	  $sql = "SELECT count(*) FROM asistencia WHERE ano = ".$this->ano." ";
	  if($this->alumno!=""){
	   $sql.=" AND rut_alumno = ".$this->alumno." ";
	  }
	  if($this->fecha_inicio!="" AND $this->fecha_termino!=""){
	   $sql.=" and (fecha>='".$this->fecha_inicio."' and fecha<='".$this->fecha_termino."') ";
	  }
	  if($this->curso!=""){
	   $sql.= " AND id_curso =".$this->curso." ";
	  }
	  if($this->fecha!=""){
	  $sql.= " AND fecha ='".$this->fecha."' and id_curso=".$this->id_curso."";
	  }
	  $sql;
	  $result_asis = pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
	  return $result_asis;
	 }
	 
	 
	 function TotalAsistenciaMensual($conn){
	 	$sql = "select count(*), fecha from asistencia where ano=".$this->id_ano." and id_curso=".$this->id_curso." ";
	 	$sql.="and date_part('month',fecha)=".$this->mes." group by fecha order by fecha asc";
	 	$result_asis = pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
	    return $result_asis;
	 }
	 
	
	 function MatriculaAsistencia($conn){
	  $sql = "SELECT count(*) FROM matricula WHERE id_ano=".$this->ano." AND fecha<'".$this->fecha_fin."'";
	  $result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (matricula asistencia):".$sql);
	  return $result;

	 }
	 function MatriculaCiclos($conn){
	 	$sql="SELECT count(*), id_ciclo FROM matricula a INNER JOIN ciclos b ON (a.id_ano=b.id_ano AND  a.id_curso=b.id_curso)
WHERE a.id_ano=".$this->ano." GROUP BY id_ciclo";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (matricula Ciclos):".$sql);
		return $result;
	 }
	 function MatriculaNiveles($conn){
	 	$sql ="SELECT count(*) as cuenta, id_nivel FROM matricula a INNER JOIN curso b ON b.id_ano=a.id_ano AND a.id_curso=b.id_curso ";
		$sql.="WHERE a.id_ano=".$this->ano." GROUP BY id_nivel";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (matricula Ciclos):".$sql);
		return $result;
	 }
		
	 function MatriculaAsistencia_curso($conn){
	  $sql = "SELECT count(*) FROM matricula WHERE id_ano=".$this->ano." AND fecha<'".$this->fecha_fin."' ";
	  $sql.="and id_curso=".$this->id_curso." AND bool_ar=0";
	  $result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (matricula asistencia curso):".$sql);
	  return $result;

	}	
	function MatriculaMes($conn){
		$sql = " SELECT count(*) FROM matricula WHERE id_ano=".$this->ano." AND(fecha>='".$this->fecha_inicio."' ";
		$sql.=" AND fecha<='".$this->fecha_termino."') AND id_curso=".$this->curso;
		//echo $sql;
		$result = pg_exec($conn,$sql);
		return $result;																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																										
	}
		
/*	function Matriculados($conn){
		$sql = "Select count(*) FROM matricula WHERE id_ano=".$this->id_ano." AND id_curso=".$this->id_curso."";
		$sql.=" AND (fecha>='".$this->fecha_ini."' AND fecha<='".$this->fecha_fin."')";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (Matriculados):".$sql);
	 	return $result;
	}	*/
	
	function Matriculados($conn){
		$sql = "Select count(*) FROM matricula WHERE id_ano=".$this->id_ano." AND id_curso=".$this->id_curso;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (Matriculados):".$sql);
	 	return $result;
		}
	function MatriculaMes2($conn){
		$sql ="SELECT COUNT(*) as cantidad,id_curso FROM asistencia WHERE ano = ".$this->ano."  ";
		if($this->nro_ano!=""){
			$sql.=" AND date_part('year',fecha)=".$this->nro_ano." ";
		}
		if($this->mes!=""){
			$sql.= " AND date_part('month',fecha)= ".$this->mes." ";
		}
		$sql.=" GROUP BY id_curso ";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (MatriculaMes2):".$sql);
		return $result;
	}
	function DocenteProyecto($conn){
		$sql =" SELECT b.nombre_emp || CAST(' ' as varchar) || b.ape_pat || cast('  ' as varchar) || b.ape_mat as nombre,c.hrs_contrato,c.total_aula,d.nombre as ";
		$sql.=" titulo,b.tipo_titulo FROM proyecto_grupo a INNER JOIN empleado b ON a.rut_emp=b.rut_emp  INNER JOIN dotacion_docente c ON ";
		$sql.=" (c.rdb=a.rdb AND c.rut_emp=a.rut_emp AND c.rut_emp=b.rut_emp) INNER JOIN empleado_estudios d ON a.rut_emp=cast(d.rut_empleado as Integer) AND ";
		$sql.=" b.rut_emp=cast(d.rut_empleado as Integer) AND c.rut_emp=cast(d.rut_empleado as Integer) where a.rdb=".$this->rdb." AND c.id_ano=".$this->ano." AND id_proy=".$this->id_pro."";
		$sql.=" AND d.tipo=1 ";
		//if($_PERFIL==0) echo $sql;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DocenteProyecto):".$sql);
		return $result;
	}
	function AlumnoProyecto($conn){
		$sql ="SELECT b.nombre_alu || cast(' ' as varchar) || ape_pat || cast(' '  as VARCHAR) || ape_mat as nombres, b.fecha_nac, a.institucion,c.nombre ";
		$sql.=" ,a.obs,d.id_curso FROM alumno_proyecto a INNER JOIN alumno b ON a.rut_alumno=b.rut_alumno INNER JOIN diagnostico c ON a.id_dignos=c.id_dignos ";
		$sql.=" INNER JOIN Matricula d ON a.id_ano=d.id_ano AND a.rut_alumno=d.rut_alumno WHERE a.rdb=".$this->rdb." AND a.id_ano=".$this->ano." AND ";
		$sql.=" id_proy=".$this->id_pro."";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (AlumnoProyecto):".$sql);
		return $result;
	}
	function Diagnostico($conn){
		$sql = "SELECT id_dignos,nombre FROM diagnostico WHERE id_dignos=".$this->id_dignos;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (Diagnostico):".$sql);
		return $result;
	}
	function AlumnoDiagnostico($conn){
		$sql = "SELECT b.nombre_alu || cast(' ' as varchar) || ape_pat || cast(' '  as VARCHAR) || ape_mat as nombres, b.fecha_nac, a.institucion,c.nombre, ";
		$sql.= " a.obs,d.id_curso,c.nombre as dignos FROM alumno_proyecto a INNER JOIN alumno b ON a.rut_alumno=b.rut_alumno INNER JOIN diagnostico c ON "; 
		$sql.= " a.id_dignos=c.id_dignos INNER JOIN Matricula d ON a.id_ano=d.id_ano AND a.rut_alumno=d.rut_alumno WHERE a.rdb=".$this->rdb." ";
		$sql.= " AND a.id_ano=".$this->ano." AND id_proy=".$this->id_pro." AND a.id_dignos=".$this->id_dignos;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (AlumnoDiagnostico):".$sql);
		return $result;
	}
	 function planificacion_curri($conn){
	  if($this->periodo==0)
	 {
		$sql="select * from plani where id_ramo=".$this->id_ramo;
		$res=@pg_exec($conn,$sql);
		return $res;
		}
	  else
	  { 
		 $sql="select * from plani where id_ramo=".$this->id_ramo." and fecha_inicio>='".$this->fecha_inicio."' and fecha_fin<='".$this->fecha_termino."'";
		$res=@pg_exec($conn,$sql);
		return $res;
	  
	  }
	 }
	 
	 function NomCurso($conn)
	{
		$sql_curso="select * from curso where id_ano=".$this->ano." order by ensenanza, grado_curso,letra_curso";
		$result_cursos =@pg_exec($conn,$sql_curso)or die ("SELECT FALLO (NomCurso):".$sql_curso);
	//	echo "sql_curso=$sql_curso<br>";
		return $result_cursos;
		
	}
	function DotacionDocente($conn){
		$sql="SELECT a.rut_emp,b.dig_rut ,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' ' as varchar) || ape_mat as nombre, hrs_contrato, amp_jec, a.amp_simple,a.amp_simple,a.art_69,a.cargo_asig,a.hrs_excedente,a.obs,a.tipo_emp,a.tipo_func,a.total_aula FROM dotacion_docente a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$this->rdb." AND id_ano=".$this->ano."AND cargo=".$this->cargo;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
		return $result;
	}
	function DotacionDirectivo($conn){
		$sql="SELECT a.rut_emp,b.dig_rut ,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' ' as varchar) || ape_mat as nombre, hrs_contrato, amp_jec, a.amp_simple,a.amp_simple,a.art_69,a.cargo_asig,a.hrs_excedente,a.obs,a.tipo_emp,a.tipo_func,a.total_aula FROM dotacion_docente a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$this->rdb." AND id_ano=".$this->ano."AND cargo in ".$this->cargo."";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
		return $result;
	}
	function DotacionTecnico($conn){
		$sql="SELECT a.rut_emp,b.dig_rut ,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' ' as varchar) || ape_mat as nombre, hrs_contrato, amp_jec, a.amp_simple,a.amp_simple,a.art_69,a.cargo_asig,a.hrs_excedente,a.obs,a.tipo_emp,a.tipo_func,a.total_aula FROM dotacion_docente a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$this->rdb." AND id_ano=".$this->ano."AND cargo not in ".$this->cargo."";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
		return $result;
	}
	
	function alu_socioeconomico($conn){
	$sql="select * from alumno_socioeconomico where rut_alumno=".$this->alumno;
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
	return $result;
	
	}
	function Ramo($conn){
		$sql = "SELECT id_ramo,nombre, a.id_curso FROM ramo a INNER JOIN curso b ON a.id_curso=b.id_curso INNER JOIN subsector c ON ";
		$sql.= "a.cod_subsector=c.cod_subsector WHERE id_ano=".$this->ano." ORDER BY b.ensenanza,b.grado_curso ASC ";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (Ramo):".$sql);
		return $result;
	}
	function AlumnoEximido($conn){
	if(trim($this->curso)==1){
		$sql ="SELECT d.rut_alumno,b.id_curso, d.nombre_alu || cast(' ' as varchar) || ape_pat || cast(' ' as varchar) || ape_mat as nombres FROM matricula a ";
		$sql.=" INNER JOIN curso b ON a.id_ano=b.id_ano AND a.id_curso=b.id_curso INNER JOIN ramo c ON c.id_curso=a.id_curso AND c.id_curso=b.id_curso ";
		$sql.="INNER JOIN alumno d ON d.rut_alumno=a.rut_alumno  WHERE a.id_ano=".$this->ano." AND c.id_ramo=".$this->ramo." AND a.rut_alumno not in ";
		$sql.="(SELECT rut_alumno FROM tiene$this->nro_ano WHERE id_ramo=".$this->ramo.")";
	}else{
		$sql ="SELECT d.rut_alumno,b.id_curso, d.nombre_alu || cast(' ' as varchar) || ape_pat || cast(' ' as varchar) || ape_mat as nombres FROM matricula a ";
		$sql.=" INNER JOIN curso b ON a.id_ano=b.id_ano AND a.id_curso=b.id_curso INNER JOIN ramo c ON c.id_curso=a.id_curso AND c.id_curso=b.id_curso ";
		$sql.="INNER JOIN alumno d ON d.rut_alumno=a.rut_alumno  WHERE a.id_ano=".$this->ano." AND c.id_ramo=".$this->ramo." AND b.id_curso=".$this->curso." AND a.rut_alumno not in ";
		$sql.="(SELECT rut_alumno FROM tiene$this->nro_ano WHERE id_ramo=".$this->ramo.")";
	}
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (AlumnoEximido999):".$sql);
		return $result;
	}
	function CantidadCurso($conn){
		$sql ="select count(*), grado_curso FROM curso WHERE id_ano=".$this->ano." AND ensenanza=".$this->ensenanza." GROUP BY grado_curso ORDER BY grado_curso ASC";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (CantidadCurso):".$sql);
		return $result;
	}	
	function MatriculaInicial($conn){
		$sql =" SELECT count(*) FROM matricula WHERE id_ano=".$this->ano." AND id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$this->ano." ";
		$sql.=" AND ensenanza=".$this->ensenanza." AND grado_curso=".$this->grado.")  AND ";
		$sql.=" date_part('month',matricula.fecha)<=".$this->mes." AND date_part('year',fecha)=".$this->nro_ano."";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (MatriculaInicial):".$sql);
		return $result;
	}
	function MatriculaAltas($conn){
		$sql ="SELECT count(*) FROM matricula WHERE id_ano=".$this->ano." AND id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$this->ano." AND ";
		$sql.="ensenanza=".$this->ensenanza." AND grado_curso=".$this->grado.") AND bool_ar=".$this->retirado." AND fecha between '".$this->fecha_inicio."' ";
		$sql.="AND '".$this->fecha_final."'";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (MatriculaAltas):".$sql);
		return $result;
	}
	function MatriculaBajas($conn){
		$sql ="SELECT count(*) FROM matricula WHERE id_ano=".$this->ano." AND id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$this->ano." AND ";
		$sql.=" ensenanza=".$this->ensenanza." AND grado_curso=".$this->grado.") AND bool_ar=".$this->baja." AND fecha_retiro between '".$this->fecha_inicio."' ";
		$sql.=" AND '".$this->fecha_final."'";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (MatriculaAltas):".$sql);
		return $result;
	}
	function MatriculaDia($conn){
		$sql ="SELECT count(*) FROM matricula WHERE id_ano=".$this->ano." AND id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$this->ano." AND ";
		$sql.="ensenanza=".$this->ensenanza." AND grado_curso=".$this->grado.")  AND fecha<='".$this->fecha_dia."'";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (MatriculaDia):".$sql);
		return $result;
	}
	function AsistenciaDia($conn){
		$sql ="SELECT count(*) FROM asistencia WHERE ano=".$this->ano." AND rut_alumno in (SELECT rut_alumno FROM matricula WHERE id_ano=".$this->ano." AND id_curso in (SELECT id_curso  FROM curso WHERE id_ano=".$this->ano." AND ensenanza=".$this->ensenanza." AND grado_curso=".$this->grado.") AND bool_ar=0) and asistencia.fecha='".$this->fecha_dia."'";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (AsistenciaDia):".$sql);
		return $result;
	}
	function EstadoPractica($conn){
		$sql ="SELECT cod_estado, nombre_estado FROM estado_practica WHERE cod_estado=".$this->cod_estado;
		$result = @pg_exec($conn,$sql) or die("SELECT FALLÓ (EstadoPractica):".$sql);
		return $result;
	}
	function RamoCurso($conn){
		$sql = "SELECT id_ramo,a.id_curso,nombre FROM ramo a INNER JOIN curso b ON a.id_curso=b.id_curso  INNER JOIN subsector c ON ";
		$sql.=" a.cod_subsector=c.cod_subsector WHERE id_ano=".$this->ano." and a.cod_subsector in (".$this->cod_subsector.") ";
		if($this->curso!=1){
			$sql.=" AND b.id_curso=".$this->curso."";
		}
		$result = @pg_exec($conn,$sql) or die("SELECT FALLÓ (RamoCurso):".$sql);
		return $result;
	}
	function Especialidad($conn){
		$sql = "SELECT nombre_esp FROM especialidad WHERE cod_esp=".$this->especialidad;
		$result = @pg_exec($conn,$sql) or die("SELECT FALLÓ (Especialidad):".$sql);
		return $result;
	}
	function ConfigPromedios($conn){
		$sql = "SELECT truncado_per,truncado_final FROM curso WHERE id_curso=".$this->curso;
		$rs_curso = @pg_exec($conn,$sql) or die("SELECT FALLO (ConfigPromedios):".$sql);
		$truncado_final = @pg_result($rs_curso,0);
		$truncado_gral = @pg_result($rs_curso,1);
		if($this->tipo==1){ 
			$sql = "SELECT sum(cast(promedio as integer)), count(*) FROM notas$this->nro_ano WHERE id_ramo=".$this->ramo." and id_ramo in (SELECT id_ramo FROM ramo WHERE id_ramo=".$this->ramo." and cod_subsector <> '13' )  AND  rut_alumno=".$this->alumno;
			$rs_notas = @pg_exec($conn,$sql) or die("SELECT FALLO (notas condif).".$sql);
			$suma_notas = @pg_result($rs_notas,0);
			$contador_notas = @pg_result($rs_notas,1);
			
			if($truncado_final==1){
				$this->promedio = round($suma_notas/$contador_notas);
			}else{
				$this->promedio = intval($suma_notas/$contador_notas);
			}
		}else{ 
			$sql = "SELECT sum(cast(promedio as integer)) as promedio, count(*) as contador,a.id_ramo FROM notas$this->nro_ano a INNER JOIN ramo b ON a.id_ramo=b.id_ramo  WHERE  rut_alumno=".$this->alumno." AND a.id_ramo in (SELECT id_ramo FROM ramo WHERE id_curso=".$this->curso." and cod_subsector <> '13' ) AND b.bool_ip=1 AND promedio not in ('0','','I','S','B','MB')  GROUP BY a.id_ramo ";
			$rs_notas = @pg_exec($conn,$sql) or die("SELECT FALLO (notas condif).".$sql);
			$suma_notas =0;
			$contador_notas=0;
			for($i=0;$i<@pg_numrows($rs_notas);$i++){
				$fila = @pg_fetch_array($rs_notas,$i);
				if($truncado_final==1){
					$prom = round($fila['promedio'] / $fila['contador']);
					$suma_notas = $suma_notas + $prom;
				}else{
					$prom = intval($fila['promedio'] / $fila['contador']);
					$suma_notas = $suma_notas + $prom;
				}
				$contador_notas++;	
				
			}
			
			if($truncado_gral==1){
				$this->promedio = round($suma_notas/$contador_notas);
			}else{
				$this->promedio = intval($suma_notas/$contador_notas);
			}
		}
		return;
	}
	 function FirmaApo($conn){
	 	$sql ="select a.ape_pat || cast(' ' as varchar) || a.nombre_apo as nombre from apoderado a inner join tiene2 b ON a.rut_apo=b.rut_apo
where rut_alumno=".$this->alumno."";
		$rs_apo =@pg_exec($conn,$sql);
		$this->nombre_apo = @pg_result($rs_apo,0);
		return;
	 }
}
?>

