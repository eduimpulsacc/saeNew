<? /*require "../../../../util/connect.php";*/
 

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
		$sql.=" firma4, grado1, grado2, grado3, grado4, grado5, grado6, grado7, grado8,grado9,grado10,grado11,grado12,grado13,grado14,grado15,grado16,tipo_ense,poner_timbre,firmadig1,firmadig2,firmadig3,firmadig4,grado23,grado24,grado25,grado32,grado33,grado31)";
		$sql.=" VALUES(".$this->institucion.", ".$reporte.", ".$this->cmbREPORTE.", ".$this->rbTITULO.", ".$this->rbITEM.", ";
		$sql.=" ".$this->rbSUBITEM.", '".$this->cmbLETRATITULO."', '".$this->cmbLETRAITEM."', '".$this->cmbLETRASUBITEM."', ";
		$sql.=" 0, 0, 0, '".$this->cmbFIRMA1."', ";
		$sql.=" '".$this->cmbFIRMA2."', '".$this->cmbFIRMA3."', '".$this->cmbFIRMA4."', '".$this->ckbox1."','".$this->ckbox2."',";
		$sql.=" '".$this->ckbox3."', '".$this->ckbox4."', '".$this->ckbox5."','".$this->ckbox6."', '".$this->ckbox7."', ";
		$sql.=" '".$this->ckbox8."', '".$this->ckbox9."', '".$this->ckbox10."', '".$this->ckbox11."', '".$this->ckbox12."', '".$this->ckbox13."','".$this->ckbox14."', '".$this->ckbox15."', '".$this->ckbox16."', ";
		$sql.=" ".$this->cmbENSENANZA.",";
		$sql.=" ".$this->poner_timbre.",".$this->firmadig1.",".$this->firmadig2.",".$this->firmadig3.",".$this->firmadig4.",".$this->ckbox23.",".$this->ckbox24.",".$this->ckbox25.",".$this->ckbox32.",".$this->ckbox33.",".$this->ckbox31.")";
		//echo $sql;
		$result = @pg_exec($conn,$sql) or die (pg_last_error($conn));
		return $result;
	}
	function InsertReporte2($conn){
		$sql = "SELECT id_reporte FROM item_reporte WHERE id_item=".$this->cmbREPORTE;
		$rs_reporte = @pg_exec($conn,$sql);
		$reporte = @pg_result($rs_reporte,0);
		
		
		$sql =" INSERT INTO configuracion_reporte_new (rdb, id_reporte, id_item, titulo_tamano, item_tamano, subitem_tamano, ";
		$sql.=" titulo_letra, item_letra, subitem_letra, con_colilla, con_taller, con_anotaciones, firma1, firma2, firma3, ";
		$sql.=" firma4, empleado1, empleado2, empleado3, empleado4,grado1, grado2, grado3, grado4, grado5, grado6, grado7, grado8,grado9,grado10,grado11,grado12,grado13,grado14,grado15,grado16,tipo_ense,grado23,grado24,grado25,grado32,grado33,grado31)";
		$sql.=" VALUES(".$this->institucion.", ".$reporte.", ".$this->cmbREPORTE.", ".$this->rbTITULO.", ".$this->rbITEM.", ";
		$sql.=" ".$this->rbSUBITEM.", '".$this->cmbLETRATITULO."', '".$this->cmbLETRAITEM."', '".$this->cmbLETRASUBITEM."', ";
		$sql.=" 0, 0, 0, '".$this->cmbFIRMA1."', '".$this->cmbFIRMA2."', '".$this->cmbFIRMA3."', '".$this->cmbFIRMA4."',";
		$sql.=" '".$this->cmbEMPLEADO1."', '".$this->cmbEMPLEADO2."',  '".$this->cmbEMPLEADO3."', '".$this->cmbEMPLEADO4."','".$this->ckbox1."','".$this->ckbox2."',";
		$sql.=" '".$this->ckbox3."', '".$this->ckbox4."', '".$this->ckbox5."','".$this->ckbox6."', '".$this->ckbox7."', ";
		$sql.=" '".$this->ckbox8."', '".$this->ckbox9."', '".$this->ckbox10."', '".$this->ckbox11."', '".$this->ckbox12."', '".$this->ckbox13."','".$this->ckbox14."', '".$this->ckbox15."', '".$this->ckbox16."', ";
		$sql.=" ".$this->cmbENSENANZA.",".$this->ckbox23.",".$this->ckbox24.",".$this->ckbox25.",".$this->ckbox32.",".$this->ckbox33.",".$this->ckbox33.")";
		$result = @pg_exec($conn,$sql) or die (pg_last_error($conn));
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
		$sql.= "grado13=".$this->ckbox13.", grado14=".$this->ckbox14.", grado15=".$this->ckbox15.", grado16=".$this->ckbox16.", ";
		$sql.= "empleado1=".$this->cmbEMPLEADO1.",empleado2=".$this->cmbEMPLEADO2.",empleado3=".$this->cmbEMPLEADO3.",empleado4=".$this->cmbEMPLEADO4.",poner_timbre= ".$this->poner_timbre;
		$sql.=",firmadig1=".$this->firmadig1.",firmadig2=".$this->firmadig2.",firmadig3=".$this->firmadig3.",firmadig4=".$this->firmadig4." ";
		$sql.=", grado23=".$this->ckbox23.", grado24=".$this->ckbox24.", grado25=".$this->ckbox25.", grado32=".$this->ckbox32.", grado33=".$this->ckbox33.",grado31=".$this->ckbox31;
		$sql.= "WHERE rdb=".$this->institucion." AND id_item=".$this->cmbREPORTE." AND id_config=".$this->id_config;
		$result = @pg_exec($conn,$sql);
/*		echo $sql;
		exit;*/
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
		$sql.= "grado11=".$this->ckbox11.", grado12=".$this->ckbox12.", tipo_ense=".$this->cmbENSENANZA.", ";
		$sql.= "grado13=".$this->ckbox13.", grado14=".$this->ckbox14.", grado15=".$this->ckbox15;
		$sql.= " ,empleado1=".$this->cmbEMPLEADO1.",empleado2=".$this->cmbEMPLEADO2.",empleado3=".$this->cmbEMPLEADO3.",empleado4=".$this->cmbEMPLEADO4." ";
		$sql.=", grado23=".$this->ckbox23.", grado24=".$this->ckbox24.", grado25=".$this->ckbox25.", grado32=".$this->ckbox32.", grado33=".$this->ckbox33.",grado31=".$this->ckbox31;
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
		//if($_PERFIL==0) echo $sql;
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
		$this->grado13	=$fila['grado13'];
		$this->grado14	=$fila['grado14'];
		$this->grado15	=$fila['grado15'];
		$this->grado16	=$fila['grado16'];
		$this->ensenanza=$fila['tipo_ense'];
		$this->timbre=$fila['poner_timbre'];
		$this->firmadig1	=$fila['firmadig1'];
		$this->firmadig2	=$fila['firmadig2'];
		$this->firmadig3	=$fila['firmadig3'];
		$this->firmadig4	=$fila['firmadig4'];
		$this->grado23	=$fila['grado23'];
		$this->grado24	=$fila['grado24'];
		$this->grado25	=$fila['grado25'];
		$this->grado32	=$fila['grado32'];
		$this->grado33	=$fila['grado33'];
		$this->grado31	=$fila['grado31'];
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
	
	function ItemMenuAdm($conn){
		 $sql = " SELECT * FROM item_reporte WHERE id_reporte=".$this->reporte." and estado=1 ORDER BY id_reporte, id_item ASC";
		$result=@pg_exec($conn,$sql);
		return $result;
	}
	
	
	function ItemReporte($conn){
		
		
		
		  $sql = "select * from item_reporte where id_item in (select id_item FROM perfil_reporte WHERE rdb=".$this->rdb." AND id_reporte=".$this->reporte." AND id_perfil=".$this->perfil.") AND id_reporte=".$this->reporte." ";
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	function ListaReporte($conn){
		$sql = " SELECT nombre,id_item FROM item_reporte ";
		if($this->item_reporte!=0){
			$sql.= "WHERE id_item=".$this->item_reporte."";
		}
		$sql.=" ORDER BY id_reporte, id_item ASC";
		//echo $sql;
		$result=@pg_exec($conn,$sql);
		return $result;
	}
	
	
	function checAutReporte($conn){
		    //  echo "s2->".
		$sql = "select id_reporte from autoriza_firma where rbd=".$this->rdb." AND usuario='".$this->usuario."' AND id_reporte=".$this->item." ";
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	function checAutReporteTrabaja($conn){
		// echo "s1->".  
		  $sql = "select autoriza_firma from trabaja where rdb=".$this->rdb." AND rut_emp=".$this->usuario;
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	
	
	
	function quitaAutReporte($conn){
		   $sql = "delete from autoriza_firma where rbd=".$this->rdb." AND usuario='".$this->usuario."' AND id_reporte=".$this->item." ";
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	
	function Cargos($conn){
		$sql="SELECT * FROM cargos order by nombre_cargo ";
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
		//echo "cargo-->".$id_cargo;
		if(@$this->empleado!=0){
			$sql = "SELECT nombre_emp || cast (' ' as varchar) || ape_pat || cast(' ' as varchar) || ape_mat as nombre, rut_emp ";
			$sql.= "FROM empleado WHERE rut_emp=".$this->empleado;
		}else{
			if(($this->id_cargo ==5 || $this->id_cargo ==34)) {
				$sql = "SELECT nombre_emp || cast (' ' as varchar) || ape_pat || cast(' ' as varchar) || ape_mat as nombre, rut_emp ";
				$sql.= "FROM empleado WHERE rut_emp IN (SELECT rut_emp FROM supervisa WHERE id_curso=".$this->curso." AND  rut_emp IN ";
				$sql.= "(SELECT rut_emp FROM trabaja WHERE cargo=".$this->cargo." AND rdb=".$this->rdb."))";
			}else{
				$sql = "SELECT nombre_emp || cast (' ' as varchar) || ape_pat || cast (' ' as varchar) || ape_mat, rut_emp ";
				$sql.= "FROM empleado WHERE rut_emp IN (SELECT rut_emp FROM trabaja WHERE cargo=".$this->cargo." ";
				$sql.= "AND rdb=".$this->rdb.")";
			}	
		}
	
		//if($_PERFIL==0) echo $sql;
	
		$rs_empleado = @pg_exec($conn,$sql)/* or die ("SELECT FALLO:".$sql)*/;
		$fila = pg_fetch_array($rs_empleado,0);
		$this->nombre_emp =@pg_result($rs_empleado,0);
		$this->apellido_emp =@pg_result($rs_empleado,1)." ".@pg_result($rs_empleado,2)." ".@pg_result($rs_empleado,0);
		$this->rut_emp = $fila['rut_emp'];
		return;
	}
	
	
	function TraeUnAlumno($conn){
		$sql =" SELECT * ";
		$sql.=" FROM alumno INNER JOIN matricula ON alumno.rut_alumno=matricula.rut_alumno WHERE  id_ano=".$this->ano." ";
		if($this->curso!=0){
			$sql.=" AND id_curso=".$this->curso." ";
		}
		$sql.=" AND matricula.rut_alumno=".$this->alumno." ORDER BY ape_pat, ape_mat ASC LIMIT 1 offset 0";
		
		//if($_PERFIL==0){echo $sql;}
		$result =@pg_exec($conn,$sql) or die (pg_last_error($conn));
		return $result;
	}
	
	
	function TraeTodosAlumnos($conn){
	   	 $sql =" SELECT ALUMNO.*,matricula.*,case 
WHEN (SUBSTRING(upper(ALUMNO.ape_pat),1,1)='�') THEN REPLACE(upper(ALUMNO.ape_pat),'�','A') 
WHEN (SUBSTRING(upper(ALUMNO.ape_pat),1,1)='�') THEN REPLACE(upper(ALUMNO.ape_pat),'�','E') 
WHEN (SUBSTRING(upper(ALUMNO.ape_pat),1,1)='�') THEN REPLACE(upper(ALUMNO.ape_pat),'�','I') 
WHEN (SUBSTRING(upper(ALUMNO.ape_pat),1,1)='�') THEN REPLACE(upper(ALUMNO.ape_pat),'�','O') 
WHEN (SUBSTRING(upper(ALUMNO.ape_pat),1,1)='�') THEN REPLACE(upper(ALUMNO.ape_pat),'�','U') 
ELSE upper(ALUMNO.ape_pat) END AS ORD ";
		$sql.=" FROM alumno INNER JOIN  matricula ON alumno.rut_alumno=matricula.rut_alumno InNER JOIN curso ON curso.id_curso=matricula.id_curso
		WHERE  matricula.id_ano=".$this->ano."  ";
		if($this->curso!=0){
			$sql.=" AND matricula.id_curso=".$this->curso." ";			
		}

		if($this->retirado==0){
			$sql.=" AND bool_ar=0";
		}
		if(@$this->fecha_mat!=""){
			$sql.=" AND fecha <'$this->fecha_mat' ";
		}
		if(@$this->fecha_mat2!=""){
			$sql.=" AND fecha >'$this->fecha_mat2' ";
		}
		if(@$this->fecha_mat3!=""){
			$sql.=" AND fecha <='$this->fecha_mat3' ";
		}
		if(@$this->sexo==1 || @$this->sexo==2){
			$sql.="  AND sexo=".$this->sexo." ";
		}
		if($this->orden==0){
			$sql.="  ORDER BY nro_lista ASC";
		}elseif($this->orden==1){
			$sql.="  ORDER BY ensenanza,grado_curso, letra_curso,ORD, ape_mat ASC";			
		}else{
			$sql.="  ORDER BY ape_pat, ape_mat ASC";
		}
		
		//if($_PERFIL==0) {echo $sql;}
		
		$result =@pg_exec($conn,$sql) or die (pg_last_error($conn));
		return $result;
	}
	function TraeTodosPromovidos($conn){
		$sql ="SELECT * FROM alumno INNER JOIN promocion ON alumno.rut_alumno=promocion.rut_alumno WHERE promocion.id_ano=".$this->ano." AND promocion.id_curso=".$this->curso."  and situacion_final=1 ORDER BY ape_pat,ape_mat ASC ";
		$result = @pg_exec($conn,$sql) or die (pg_last_error($conn));
		return $result;
	
	}
	function ProfeJefe($conn){
		
		$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
		$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$this->curso.")); ";
		
		//if($_PERFIL==0) {echo $sql_profe; }
		
		$result_profe =@pg_Exec($conn,$sql_profe) or die("SELECT FALL�: ".$sql_profe);
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
	
	function AnoEscolarCurso($conn){
		 $sql_ano = "select fecha_inicio,fecha_termino from curso where id_curso = ".$this->curso;
		$result =@pg_Exec($conn,$sql_ano);
			return $result;
	}
	
	
	function Anotaciones($conn){
		$sql = "select * from anotacion where";
		$sql.= " rut_alumno = ".$this->alumno." and (fecha>='".$this->fecha_inicio."' and fecha<='".$this->fecha_termino."')";
		if($this->tipo!=""){
			$sql.= " AND tipo=".$this->tipo." ";
		}
		if($this->tipo_conducta!=""){
			$sql.= " AND tipo_conducta=".$this->tipo_conducta." ";
		}
		$sql.= "order by tipo desc, fecha ";
		//if($_PERFIL==0) echo $sql;
		$result_anota = @pg_Exec($conn, $sql) or die("SELECT FALL�:".$sql);
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
		$result_asis = pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		return $result_asis;
	}
	function AsistenciaAlumno($conn){
		$sql ="SELECT fecha FROM asistencia a WHERE a.ano=".$this->ano." and a.id_curso=".$this->curso." AND rut_alumno=".$this->alumno; 
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�(asistencia Alumno):".$sql);
		//if($_PERFIL==0) echo $sql;
		return $result;
	}
	function Ciclos($conn){
		  $sql ="SELECT * FROM ciclo_conf WHERE rdb=".$this->rdb." AND id_ano=".$this->ano;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�(ciclos):".$sql);
		return $result;
	}
	function Nivel($conn){
		$sql = "SELECT * FROM niveles ";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�(niveles):".$sql);
		return $result;
	}
	function AsistenciaCiclos($conn){
		$sql ="SELECT count(a.*) as cuenta, id_ciclo, date_part('MONTH',fecha) FROM asistencia a INNER JOIN ciclos b ON (a.id_curso=b.id_curso AND a.ano=b.id_ano) ";
		$sql.="WHERE a.ano=".$this->ano."  GROUP BY id_ciclo, date_part('MONTH',fecha)";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		return;
	}
	function AsistenciaNiveles($conn){
		$sql="SELECT count(a.*) as cuenta, c.id_nivel, date_part('MONTH',fecha) FROM asistencia a INNER JOIN curso b ON a.id_curso=b.id_curso INNER JOIN ";
		$sql.="niveles c ON b.id_nivel=c.id_nivel WHERE b.id_ano=".$this->ano." GROUP BY c.id_nivel, date_part('MONTH',fecha)";
		$result =@pg_exec($conn,$sql)  or die ("SELECT FALL�(asistencia niveles):".$sql);
		return $result;
	}
	function DiaHabil($conn){
		 $sql ="SELECT count(*) FROM feriado WHERE id_ano=".$this->ano." AND feriado.fecha_fin='".$this->fecha."'";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		return $result;
	}
	function DiaHabilH($conn){
		 $sql ="SELECT count(*) FROM feriado WHERE id_ano=".$this->ano." AND feriado.fecha_inicio<='".$this->fecha."' and feriado.fecha_fin>='".$this->fecha."'";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		return $result;
	}
	function JustificaAsistencia($conn){
		$sql =" SELECT fecha FROM justifica_inasistencia WHERE rut_alumno = ".$this->alumno." AND ";
		$sql.=" ano = ".$this->ano." ";
		if($this->fecha!=""){
			$sql.=" AND fecha = '".$this->fecha."' ";
		}
		if(@$this->fecha2!="" && @$this->fecha1!=""){
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
	
	
	
	function Periodo_actual($conn){
		$sql="SELECT * FROM periodo WHERE id_periodo=".$this->periodo;
		$result = @pg_exec($conn,$sql)or die ("F_P");
		
		
		return $result;
	}
	
	
	function TotalPeriodo($conn){
		//$sql = "SELECT * FROM periodo WHERE id_ano = ".$this->ano." order by id_periodo,fecha_inicio";
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
	function FichaAlumnoUno_fichamat($conn){
	    $sql = " SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ";
		$sql.= " alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, alumno.salud, ";
		$sql.= " alumno.religion, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, ";
		$sql.= " matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, ";
		$sql.= " matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro,alumno.sector, ";
		/*campos nuevos*/ 
		
		$sql.= "alumno.telefono_recado,alumno.peso_nace,alumno.talla_nace,alumno.tipo_parto,alumno.estado_padres, ";
		$sql.= "matricula.num_grupofamiliar,matricula.jefe_hogar,matricula.ocup_jefehogar,matricula.ingresos, matricula.tipo_vivienda, matricula.cant_dormitorios,matricula.cant_banos,alumno.s_salud,matricula.obse_general,matricula.org_participa,matricula.bool_espacio_estudio,matricula.bool_espacio_juego, matricula.bool_hizo_jardin,matricula.figura_paterna,matricula.carinoso,matricula.sociable,matricula.curioso,matricula.bool_pdentales,matricula.bool_controldental,matricula.controlsano,matricula.bool_famenfermo,matricula.con_quien_estudia,matricula.observacion_salud, ";
		/********************fin campos nuevos*/
		
		
		$sql.= " comuna.nom_com, alumno.depto, alumno.block, alumno.villa, matricula.num_mat,alumno.cerro,alumno.lugar,";
		$sql.= " alumno.contacto_emergencia,alumno.fono_contacto,matricula.bool_baj,matricula.bool_cpadre,matricula.bool_seg,matricula.bool_otros,matricula.bool_bchs,
matricula.bool_mun,matricula.ben_sep,matricula.bool_fci  , matricula.con_quien_vive,matricula.proced_alumno, matricula.bool_sename, matricula.bool_sernam, matricula.bool_junaeb, matricula.bool_integracion, matricula.bool_ccc, matricula.ben_puente, matricula.bool_bchs, matricula.bool_vif, matricula.bool_saludmental, matricula.bool_drogas, matricula.bool_pagomatricula, matricula.bool_manualconvivencia, matricula.bool_secreduc,alumno.cant_hermanos,alumno.num_hermano,
matricula.rut_retira,matricula.nombre_retira,matricula.parentesco_retira,matricula.fono_retira,matricula.celular_retira,
matricula.rut_retira2,matricula.nombre_retira2,matricula.parentesco_retira2,matricula.fono_retira2,matricula.celular_retira2,
matricula.rut_retira3,matricula.nombre_retira3,matricula.parentesco_retira3,matricula.fono_retira3,matricula.celular_retira3,matricula.numboleta,matricula.observacion,matricula.enc_matricula,alumno.cq_vive,matricula.alergia,matricula.aut_vacuna,bool_facebook,bool_tomafoto
FROM (((matricula INNER JOIN alumno ON ";
		$sql.= " matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN ";
		$sql.= " provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON ";
		
		$sql.= " (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
		$sql.= " WHERE (((matricula.rut_alumno)=".$this->alumno.") AND ((matricula.id_ano)=".$this->ano.")) ";
		if ($_PERFIL==0){
			//echo $sql;
		}
		$result_alumno = pg_exec($conn,$sql);
		return $result_alumno;
	}
	
	function FichaAlumnoUno($conn){
	    $sql = " SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ";
		$sql.= " alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, alumno.salud, ";
		$sql.= " alumno.religion, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, ";
		$sql.= " matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, ";
		$sql.= " matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, matricula.nro_lista,alumno.foto,";
		$sql.= " comuna.nom_com, alumno.depto, alumno.block, alumno.villa, matricula.num_mat,alumno.cerro,alumno.lugar,";
		$sql.= " alumno.contacto_emergencia,alumno.fono_contacto,matricula.bool_baj,matricula.bool_cpadre,matricula.bool_seg,matricula.bool_otros,matricula.bool_bchs,
matricula.bool_mun,matricula.ben_sep,matricula.bool_fci,matricula.con_quien_vive ,matricula.bool_trabajo,matricula.txt_fichaps,alumno.cant_hijos, alumno.celular,matricula.bool_estudio_anoant,matricula.lugar_trabajo,matricula.txt_mesembarazo,matricula.txt_anosrepetidos,matricula.txt_causaretiroant,matricula.bool_tastornosaprendizaje,matricula.txt_tastornosaprendizaje,matricula.enfermedad,matricula.bool_psicologo,matricula.bool_discapacidad,matricula.bool_carnetdiscapacidad,matricula.bool_examenvalidacion,matricula.bool_traecertificados,matricula.bool_traecertificadosant,matricula.apvol_cgp,matricula.plazo_autorizacion,matricula.nivel_certificado,matricula.bool_pagomatricula
FROM (((matricula INNER JOIN alumno ON ";
		$sql.= " matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN ";
		$sql.= " provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON ";
		
		$sql.= " (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
		$sql.= " WHERE (((matricula.rut_alumno)=".$this->alumno.") AND ((matricula.id_ano)=".$this->ano.")) ";
		if ($_PERFIL==0){
			
			//echo $sql;
			}
		$result_alumno = pg_exec($conn,$sql)or die("f".$sql);
		return $result_alumno;
	}
	function FichaAlumnoTodos($conn){
		$sql = " SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ";
		$sql.= " alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.celular, alumno.email,alumno.salud, alumno.salud,matricula.bool_ar, alumno.nivel_edu_padre, alumno.nivel_edu_madre, alumno.estado_civil, alumno.cant_hijos, ";
		$sql.= " matricula.total_notas, suma_pond, pond_demre, alumno.prioritario,matricula.alum_prio,matricula.nro_lista, ";
		$sql.= " alumno.religion, matricula.fecha, matricula.fecha_retiro,matricula.motivo_retiro, matricula.bool_baj, matricula.bool_bchs,alumno.foto, ";
		$sql.= " matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, ";
		$sql.= " matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, ";
		$sql.= " comuna.nom_com, alumno.depto, alumno.block, alumno.villa, matricula.num_mat, alumno.cerro,alumno.lugar,alumno.contacto_emergencia,alumno.fono_contacto,matricula.bool_baj,matricula.bool_cpadre,matricula.bool_seg,matricula.bool_otros,matricula.bool_bchs,
matricula.bool_mun,matricula.ben_sep,matricula.bool_fci,matricula.con_quien_vive,matricula.bool_trabajo,matricula.txt_fichaps,alumno.cant_hijos, alumno.celular,matricula.bool_estudio_anoant, matricula.lugar_trabajo, matricula.txt_mesembarazo, matricula.txt_anosrepetidos, matricula.txt_causaretiroant,matricula.bool_tastornosaprendizaje,matricula.txt_tastornosaprendizaje,matricula.enfermedad,matricula.bool_psicologo,matricula.bool_discapacidad,matricula.bool_carnetdiscapacidad,matricula.bool_examenvalidacion,matricula.bool_traecertificados,matricula.bool_traecertificadosant,matricula.apvol_cgp,matricula.plazo_autorizacion,matricula.nivel_certificado,matricula.bool_pagomatricula,
matricula.rut_retira,matricula.nombre_retira,matricula.parentesco_retira,matricula.fono_retira,matricula.celular_retira,
matricula.rut_retira2,matricula.nombre_retira2,matricula.parentesco_retira2,matricula.fono_retira2,matricula.celular_retira2,
matricula.rut_retira3,matricula.nombre_retira3,matricula.parentesco_retira3,matricula.fono_retira3,matricula.celular_retira3,matricula.numboleta,matricula.observacion,matricula.enc_matricula,alumno.cq_vive,matricula.alergia,matricula.aut_vacuna,bool_facebook,bool_tomafoto
   FROM (((matricula INNER JOIN ";
		$sql.= " alumno ON ";
		$sql.= " matricula.rut_alumno = alumno.rut_alumno) LEFT JOIN region ON alumno.region = region.cod_reg) LEFT JOIN ";
		$sql.= " provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) LEFT JOIN comuna ";
		$sql.= " ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
		$sql.= " WHERE (((matricula.id_ano)=".$this->ano.") and ((matricula.id_curso)=".$this->curso."))";
		if($this->comuna!=0){
			$sql.=" AND alumno.comuna=".$this->comuna;
		}
		if($this->sep!=0){
			$sql.=" AND matricula.ben_sep=".$this->sep;
		}
		if($this->alum_prio!=0){
			$sql.=" AND matricula.alum_prio=".$this->alum_prio;
		}
		
		if($this->retirado==0 || $this->retirado==1){
			$sql.=" AND matricula.bool_ar=".$this->retirado;
		}
		
		
		if($this->orden==1){
			$sql.= " order by matricula.numero_reporte,matricula.nro_lista asc ";
		}elseif($this->orden==2){			
			$sql.= " order by matricula.numero_reporte,ape_pat, ape_mat ASC ";
		}else{
			$sql.= " order by ape_pat, ape_mat ASC ";
		}
		
		//if($_PERFIL==0) echo $sql; 
		
		$result_alumno = @pg_exec($conn,$sql) or die ("SELECT FALLO (todos) :".$sql);
		return $result_alumno;
		
		
	}
	function AlumnoCurso($conn){
	 	$sql = "SELECT matricula.num_mat, curso.grado_curso, curso.letra_curso, matricula.rut_alumno, alumno.dig_rut, alumno.ape_pat,matricula.observacion,matricula.observacion_salud,matricula.datos_interes, ";
		$sql.= "alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.calle, alumno.nro, comuna.nom_com, matricula.fecha, matricula.fecha_retiro,matricula.motivo_retiro, ";
		$sql.= "alumno.fecha_nac, curso.cod_decreto, matricula.bool_rg, matricula.bool_ar,alumno.cq_vive FROM (((curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) ";
		$sql.= "INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN alumno ON ";
		$sql.= "matricula.rut_alumno = alumno.rut_alumno) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND ";
		$sql.= "(alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg)  WHERE (((curso.id_curso)=".$this->curso.") ";
		$sql.= " AND ((matricula.rdb)=".$this->institucion.")) and bool_ar=0";
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
	
	function AlumnoCursoConRetirados($conn){
	 	$sql = "SELECT matricula.num_mat, curso.grado_curso, curso.letra_curso, matricula.rut_alumno, alumno.dig_rut, alumno.ape_pat,matricula.observacion,matricula.observacion_salud,matricula.datos_interes, ";
		$sql.= "alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.calle, alumno.nro, comuna.nom_com, matricula.fecha, matricula.fecha_retiro,matricula.motivo_retiro, ";
		$sql.= "alumno.fecha_nac, curso.cod_decreto, matricula.bool_rg, matricula.bool_ar,alumno.telefono,
		 case 
WHEN (SUBSTRING(upper(alumno.ape_pat),1,1)='�') THEN REPLACE(upper(alumno.ape_pat),'�','A') 
WHEN (SUBSTRING(upper(alumno.ape_pat),1,1)='�') THEN REPLACE(upper(alumno.ape_pat),'�','E') 
WHEN (SUBSTRING(upper(alumno.ape_pat),1,1)='�') THEN REPLACE(upper(alumno.ape_pat),'�','I') 
WHEN (SUBSTRING(upper(alumno.ape_pat),1,1)='�') THEN REPLACE(upper(alumno.ape_pat),'�','O') 
WHEN (SUBSTRING(upper(alumno.ape_pat),1,1)='�') THEN REPLACE(upper(alumno.ape_pat),'�','U') 
ELSE upper(alumno.ape_pat) END AS paterno,
 case 
WHEN (SUBSTRING(upper(alumno.ape_mat),1,1)='�') THEN REPLACE(upper(alumno.ape_mat),'�','A') 
WHEN (SUBSTRING(upper(alumno.ape_mat),1,1)='�') THEN REPLACE(upper(alumno.ape_mat),'�','E') 
WHEN (SUBSTRING(upper(alumno.ape_mat),1,1)='�') THEN REPLACE(upper(alumno.ape_mat),'�','I') 
WHEN (SUBSTRING(upper(alumno.ape_mat),1,1)='�') THEN REPLACE(upper(alumno.ape_mat),'�','O') 
WHEN (SUBSTRING(upper(alumno.ape_mat),1,1)='�') THEN REPLACE(upper(alumno.ape_mat),'�','U') 
ELSE upper(alumno.ape_mat) END AS materno 
		
		
		FROM (((curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) ";
		$sql.= "INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN alumno ON ";
		$sql.= "matricula.rut_alumno = alumno.rut_alumno) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND ";
		$sql.= "(alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) WHERE (((curso.id_curso)=".$this->curso.") ";
		$sql.= " AND ((matricula.rdb)=".$this->institucion."))";
		if($this->sexo > 0){
			$sql.= " AND sexo = ".$this->sexo."  AND matricula.id_ano =".$this->ano." "; 
		}
		if($this->orden==1){
			/*$sql.= " ORDER BY nro_lista asc, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu"; */
			$sql.= " ORDER BY paterno,materno, alumno.nombre_alu"; 
		}else{
			/*$sql.= "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu"; */
			
			$sql.=" ORDER BY num_mat asc,paterno,materno,alumno.nombre_alu ";
		}
		
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		return $result;		
	}
	
	function AlumnoEnsenanza($conn){
		$sql = "SELECT matricula.num_mat, curso.grado_curso, curso.letra_curso, matricula.rut_alumno, alumno.dig_rut, alumno.ape_pat,curso.id_curso, alumno.cq_vive, alumno.c_procedencia, ";
		$sql.= "alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.calle, alumno.nro, comuna.nom_com, matricula.fecha, matricula.fecha_retiro,matricula.motivo_retiro,matricula.tipo_retiro, ";
		$sql.= "alumno.fecha_nac, curso.cod_decreto, alumno.villa, matricula.motivo_retiro, matricula.tipo_retiro,alumno.telefono,curso.sede,matricula.datos_interes,alumno.celular FROM (((curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) ";
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
	
	function AlumnoEnsenanzaMasculino($conn){
		$sql = "SELECT matricula.num_mat, curso.grado_curso, curso.letra_curso, matricula.rut_alumno, alumno.dig_rut, alumno.ape_pat,curso.id_curso, matricula.con_quien_vive, matricula.proced_alumno,
		alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.calle, alumno.nro, comuna.nom_com, matricula.fecha, matricula.fecha_retiro,matricula.motivo_retiro,matricula.tipo_retiro,
		alumno.fecha_nac, curso.cod_decreto, alumno.villa,alumno.telefono,curso.sede,matricula.datos_interes,alumno.celular FROM curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso
		INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo INNER JOIN alumno ON 
		matricula.rut_alumno = alumno.rut_alumno INNER JOIN comuna ON alumno.comuna = comuna.cor_com AND 
		alumno.ciudad = comuna.cor_pro AND alumno.region = comuna.cod_reg
		WHERE tipo_ensenanza.cod_tipo=".$this->cmb_curso." AND matricula.rdb=".$this->institucion." AND
		curso.id_ano = ".$this->ano." and alumno.sexo=".$this->SEXO."";
		if ($this->orden==1){
	    	$sql = $sql . " ORDER BY matricula.num_mat";
		}else{
	    	$sql = $sql . " ORDER BY curso.grado_curso, curso.letra_curso, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu";
    	}
		
		//echo $sql;

		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	
	function CambiaDato($fila_alumno){
		$this->rut_alumno = strtoupper($fila_alumno['rut_alumno']." - ".$fila_alumno['dig_rut']);
		$this->rut_alumno2 = strtoupper($fila_alumno['rut_alumno'].$fila_alumno['dig_rut']);
		$this->alumno = $fila_alumno['rut_alumno'];
		$this->alumno = $fila_alumno['rut_alumno'];
		$this->ddv = $fila_alumno['dig_rut'];
		$this->prioritarios = $fila_alumno['alum_prio'];
		$this->nombre = ucwords(strtolower($fila_alumno['nombre_alu']));
		$this->ape_pat = ucwords(strtolower($fila_alumno['ape_pat']));
		$this->ape_mat = ucwords(strtolower($fila_alumno['ape_mat']));
		$this->nombres = ucwords(strtolower($fila_alumno['nombre_alu']))." ".ucwords(strtolower($fila_alumno['ape_pat']))." ".ucwords(strtolower($fila_alumno['ape_mat']));
		$this->ape_nombre_alu = ucwords(strtolower(trim($fila_alumno['ape_pat'])))." ".ucwords(strtolower(trim($fila_alumno['ape_mat'])))." ".ucwords(strtolower(trim($fila_alumno['nombre_alu'])));
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
		$this->telefono_recado_alu = $fila_alumno['telefono_recado'];
		$this->email = $fila_alumno['email'];
		$this->fecha_matricula = $fila_alumno['fecha'];
		$this->num_matricula = $fila_alumno['num_mat'];
		$this->num_lista = $fila_alumno['nro_lista'];
		$this->fecha_retiro = $fila_alumno['fecha_retiro'];
		$this->motivo_retiro = $fila_alumno['motivo_retiro'];
		$this->con_quien_vive = $fila_alumno['cq_vive'];
		$this->proced_alumno = $fila_alumno['c_procedencia'];
		$this->peso_nace = $fila_alumno['peso_nace'];
		$this->talla_nace = $fila_alumno['talla_nace'];
		$this->tipo_retiro = $fila_alumno['tipo_retiro'];
		$this->foto = $fila_alumno['foto'];
		
		if($fila_alumno['tipo_parto']==1){
		 $this->tipo_parto ="Normal";
		}
		elseif($fila_alumno['tipo_parto']==2){
		 $this->tipo_parto ="Ces�rea";
		}else{
		$this->tipo_parto ="-";
		}
		
		$this->nro_lista = $fila_alumno['nro_lista'];
		$this->cq_vive = $fila_alumno['cq_vive'];
		
		
		
		//$this->curso_rep = $fila_alumno['curso_rep'];
		
		
		
		if ($fila_alumno['curso_rep']==1) 	$this->curso_rep = "SI"; else $this->curso_rep = "NO";
		
		if ($fila_alumno['bool_aoi']==1) 	$this->bool_aoi = "SI"; else $this->bool_aoi = "NO";		
		if ($fila_alumno['bool_rg']==1) 	$this->bool_rg 	= "SI"; else $this->bool_rg  = "NO";		
		if ($fila_alumno['bool_ae']==1) 	$this->bool_ae 	= "SI"; else $this->bool_ae  = "NO";		
		if ($fila_alumno['bool_i']==1) 		$this->bool_i 	= "SI"; else $this->bool_i 	 = "NO";		
		if ($fila_alumno['bool_gd']==1) 	$this->bool_gd 	= "SI"; else $this->bool_gd  = "NO";		
		if ($fila_alumno['bool_ar']==1) 	$this->bool_ar 	= "SI"; else $this->bool_ar  = "NO";		
		
		
		if ($fila_alumno['bool_baj']==1) 	$this->bool_baj     = "SI"; else $this->bool_baj = "NO";		
		if ($fila_alumno['bool_cpadre']==1) $this->bool_cpadre  = "SI"; else $this->bool_cpadre = "NO";		
		if ($fila_alumno['bool_seg']==1) 	$this->bool_seg 	= "SI"; else $this->bool_seg  = "NO";		
		if ($fila_alumno['bool_otros']==1) 	$this->bool_otros 	= "SI"; else $this->bool_otros  = "NO";		
		if ($fila_alumno['bool_bchs']==1) 	$this->bool_bchs 	= "SI"; else $this->bool_bchs 	 = "NO";		
		if ($fila_alumno['bool_mun']==1) 	$this->bool_mun 	= "SI"; else $this->bool_mun  = "NO";				
		if ($fila_alumno['ben_sep']==1) 	$this->ben_sep 	    = "SI"; else $this->ben_sep  = "NO";
		if ($fila_alumno['bool_fci']==1) 	$this->bool_fci 	= "SI"; else $this->bool_fci  = "NO";
		
		$this->inf_salud = ucwords(strtolower($fila_alumno['observacion_salud']));
		$this->d_interes = ucwords(strtolower($fila_alumno['datos_interes']));
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
		$this->alumno_retirado=$fila_alumno['bool_ar'];
		$this->num_grupofamiliar=$fila_alumno['num_grupofamiliar'];
		$this->jefe_hogar=$fila_alumno['jefe_hogar'];
		$this->ocup_jefehogar=$fila_alumno['ocup_jefehogar'];
		$this->ingresos=$fila_alumno['ingresos'];
		
		if($fila_alumno['tipo_vivienda']==1)
		{$this->tipo_vivienda="Propia";}
		elseif($fila_alumno['tipo_vivienda']==2)
		{$this->tipo_vivienda="Arrendada";}
		if($fila_alumno['tipo_vivienda']==3)
		{$this->tipo_vivienda="Allegados";}
		else
		{$this->tipo_vivienda="";}
		
		$this->cant_dormitorios=$fila_alumno['cant_dormitorios'];
		$this->cant_banos=$fila_alumno['cant_banos'];
		$this->s_salud=$fila_alumno['s_salud'];
		
		$this->obse_general=$fila_alumno['obse_general'];
		$this->org_participa=$fila_alumno['org_participa'];
		$this->alergia=$fila_alumno['alergia'];
		$this->enfermedad=$fila_alumno['enfermedad'];
		
		if ($fila_alumno['bool_espacio_estudio']==1) 	$this->bool_espacio_estudio 	= "SI"; else $this->bool_espacio_estudio  = "NO";
		if ($fila_alumno['bool_espacio_juego']==1) 	$this->bool_espacio_juego 	= "SI"; else $this->bool_espacio_juego  = "NO";
		
		if ($fila_alumno['bool_hizo_jardin']==1) 	$this->bool_hizo_jardin 	= "SI"; else $this->bool_hizo_jardin  = "NO";
		$this->figura_paterna=$fila_alumno['figura_paterna'];
		//$this->carinoso=$fila_alumno['carinoso'];
		
		if($fila_alumno['carinoso']==1){
			$this->carinoso="Siempre";
		}
		elseif($fila_alumno['carinoso']==2){
			$this->carinoso="Frecuentemente";
		}
		elseif($fila_alumno['carinoso']==3){
			$this->carinoso="Raras veces";
		}
		elseif($fila_alumno['carinoso']==4){
			$this->carinoso="Casi nunca";
		}
		elseif($fila_alumno['carinoso']==5){
			$this->carinoso="Nunca";
		}
		else{
			$this->carinoso="";
		}
		
		
		if($fila_alumno['sociable']==1){
			$this->sociable="Siempre";
		}
		elseif($fila_alumno['sociable']==2){
			$this->sociable="Frecuentemente";
		}
		elseif($fila_alumno['sociable']==3){
			$this->sociable="Raras veces";
		}
		elseif($fila_alumno['sociable']==4){
			$this->sociable="Casi nunca";
		}
		elseif($fila_alumno['sociable']==5){
			$this->sociable="Nunca";
		}
		else{
			$this->sociable="";
		}
		
		
		if($fila_alumno['curioso']==1){
			$this->curioso="Siempre";
		}
		elseif($fila_alumno['curioso']==2){
			$this->curioso="Frecuentemente";
		}
		elseif($fila_alumno['curioso']==3){
			$this->curioso="Raras veces";
		}
		elseif($fila_alumno['curioso']==4){
			$this->curioso="Casi nunca";
		}
		elseif($fila_alumno['curioso']==5){
			$this->curioso="Nunca";
		}
		else{
			$this->curioso="";
		}
		
		if ($fila_alumno['bool_pdentales']==1) 	$this->bool_pdentales 	= "SI"; else $this->bool_pdentales  = "NO";
		if ($fila_alumno['bool_controldental']==1) 	$this->bool_controldental 	= "SI"; else $this->bool_controldental  = "NO";
		
		if ($fila_alumno['controlsano']!='1111-11-11' && $fila_alumno['controlsano']!='0000-00-00' && $fila_alumno['controlsano']!=null){
			$this->controlsano=$fila_alumno['controlsano'];
		}else{
			$this->controlsano="--";
			}
		
		if ($fila_alumno['bool_famenfermo']==1) 	$this->bool_famenfermo 	= "SI"; else $this->bool_famenfermo  = "NO";
		
		
		$this->con_quien_estudia=$fila_alumno['con_quien_estudia'];
		$this->cant_hermanos=$fila_alumno['cant_hermanos'];
		$this->num_hermano=$fila_alumno['num_hermano'];
		
		switch($fila_alumno['estado_padres']){
		case 1:
		$this->estado_padres="Casados";
		break;
		case 2:
		$this->estado_padres="Separados";
		break;
		case 3:
		$this->estado_padres="Divorciados";
		break;
		case 4:
		$this->estado_padres="Viudo(a)";
		break;
		case 5:
		$this->estado_padres="Convivientes";
		break;
		case 0:
		$this->estado_padres="Sin informaci&oacute;n";
		break;
		}
		
		$this->bool_cambioropa=($fila_alumno['bool_cambioropa']==1)?"SI":"NO";
		$this->bool_tomafoto=($fila_alumno['bool_tomafoto']==1)?"SI":"NO";
		$this->bool_facebook=($fila_alumno['bool_facebook']==1)?"SI":"NO";
		$this->aut_vacuna=($fila_alumno['aut_vacuna']==1)?"SI":"NO";
		$this->sector=$fila_alumno['sector'];
		
		
		if($fila_alumno['sede']==1){
			$this->sede="Principal";
		}
		elseif($fila_alumno['sede']==2){
			$this->sede="Anexo";
		}
		
		return;
	}
	



	
	function tilde($campo){

		$dato="";
		
		for($s=0;$s<=strlen($campo);$s++){
			
			$letra = substr($campo,$s,1);
			if($letra==" "){
				$sw = $s + 1;
			}
			
			if($s==0){
				
			  if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);	
			   }else{
				$dato .= strtoupper($letra); //MAYUSCULA
				 }
			   
			 
			}elseif($sw==$s){
				if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);	
			   }else{
				$dato .= strtoupper($letra); //MAYUSCULA
				 }
				
			 
			 }else{
				 
			   if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else if($letra=="�"){
			    $dato .= str_replace("�","�",$letra);
			   }else{
				$dato .= strtolower($letra); // MINUSCULA
				 }
				 
				 }
			 
			}//for
		   
		   return $dato;
	   		   
	     }
	
	
	function tildeminuscula($campo){

		$datoA = str_replace("�","�",$campo);
		$datoE = str_replace("�","�",$datoA);
		$datoI = str_replace("�","�",$datoE);
		$datoO = str_replace("�","�",$datoI);
		$datoU = str_replace("�","�",$datoO);
		$datoN = str_replace("�","�",$datoU);
		
		if($datoN!=false){
			return $datoN;
			exit;
		}
	}
	
	function tildeM($campo){
		$datoA = str_replace("�","�",$campo);
		$datoE = str_replace("�","�",$datoA);
		$datoI = str_replace("�","�",$datoE);
		$datoO = str_replace("�","�",$datoI);
		$datoU = str_replace("�","�",$datoO);
		$dato� = str_replace("�","�",$datoU);
		if($dato�!=false){
			return $dato�;
			exit;
		}
	}
	
	
		
	function Apoderado($conn){
		$sql = "SELECT apoderado.rut_apo, apoderado.dig_rut, apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, ";
		$sql.= " apoderado.telefono, apoderado.email, tiene2.responsable, apoderado.relacion,apoderado.calle,apoderado.nro, ";
		$sql.= " apoderado.profesion, apoderado.ocupacion,apoderado.nivel_edu,apoderado.nivel_social, apoderado.sexo, ";
		$sql.= " apoderado.celular,apoderado.lugar_trabajo,  
		comuna.nom_com,apoderado.parentezco,apoderado.fecha_nac,apoderado.parentezco,ultimo_ano_aprobado FROM tiene2 INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo ";
		$sql.= "  INNER JOIN comuna ON apoderado.region=comuna.cod_reg AND apoderado.ciudad=comuna.cor_pro AND apoderado.comuna=comuna.cor_com ";
		$sql.= " WHERE tiene2.rut_alumno=".$this->alumno."";
		if($this->responsable=="1"){
			$sql.= " AND responsable=1 ";
		}
		if($this->suplente=="1"){
			$sql.= " AND suplente=1 ";
		}
		if($this->sostenedor=="1"){
			$sql.= " AND sostenedor=1 ";
		}
		$sql.= " ORDER BY apoderado.ape_pat ASC ";
	//if($_PERFIL==0) echo "<BR>".$sql;
		$result_apo = @pg_Exec($conn, $sql) or die("error apoderado->".$sql);
		return $result_apo;
	}
	
	function Madre($conn){
		$sql = "SELECT apoderado.rut_apo, apoderado.dig_rut, apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, ";
		$sql.= " apoderado.telefono, apoderado.email, tiene2.responsable, apoderado.relacion,apoderado.calle,apoderado.nro,apoderado.celular, ";
		$sql.= " apoderado.profesion, apoderado.ocupacion,apoderado.nivel_edu,apoderado.nivel_social, apoderado.sexo, ";
		$sql.= " apoderado.ultimo_ano_aprobado,apoderado.edad_primer_parto, ";
		
		$sql.= " apoderado.celular,apoderado.fecha_nac,apoderado.lugar_trabajo,apoderado.fono_pega,apoderado.estado_civil,apoderado.tipo_trabajo,comuna.nom_com,apoderado.sistema_salud		
		FROM tiene2 INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo ";
			$sql.= "  INNER JOIN comuna ON apoderado.region=comuna.cod_reg AND apoderado.ciudad=comuna.cor_pro AND apoderado.comuna=comuna.cor_com ";
		$sql.= " WHERE tiene2.rut_alumno=".$this->alumno." AND apoderado.sexo=1";
		if($this->responsable==1){
			$sql.= " AND responsable=1 ";
		}
	    $sql.= " ORDER BY apoderado.ape_pat ASC ";
		//echo $sql;
		$result_apo = @pg_Exec($conn, $sql);
		return $result_apo;
	} 
	
	
	function Padre($conn){
		 $sql = "SELECT apoderado.rut_apo, apoderado.dig_rut, apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, ";
		$sql.= " apoderado.telefono, apoderado.email,apoderado.celular, tiene2.responsable, apoderado.relacion,apoderado.calle,apoderado.nro, ";
		
		$sql.= " apoderado.ultimo_ano_aprobado, ";
		$sql.= " apoderado.profesion, apoderado.ocupacion,apoderado.nivel_edu,apoderado.nivel_social, apoderado.sexo, ";
		$sql.= "  apoderado.celular,apoderado.fecha_nac,apoderado.lugar_trabajo,apoderado.fono_pega,apoderado.estado_civil,apoderado.tipo_trabajo,comuna.nom_com,apoderado.sistema_salud  FROM tiene2 INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo ";
			$sql.= "  INNER JOIN comuna ON apoderado.region=comuna.cod_reg AND apoderado.ciudad=comuna.cor_pro AND apoderado.comuna=comuna.cor_com ";
		$sql.= " WHERE tiene2.rut_alumno=".$this->alumno." AND apoderado.sexo=2";
		if($this->responsable==1){
			$sql.= " AND responsable=1 ";
		}
	    $sql.= " ORDER BY apoderado.ape_pat ASC ";
		
	//	if($_PERFIL==0){echo $sql;};
		
		$result_apo = @pg_Exec($conn, $sql);
		return $result_apo;
	}
	
	
	
	
	
	
	function ApoderadoCurso($conn){
	 $sql = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno in (select rut_alumno from matricula where id_curso = '".$this->cmb_curso."')) ORDER BY ape_pat ASC";  
	    $result= @pg_Exec($conn,$sql);
		return $result;
	}
	
	function ApoderadoCurso2($conn){
	 $sql = "select a.*,t.rut_alumno from apoderado a
inner join tiene2 t on t.rut_apo = a.rut_apo
where t.rut_alumno in 
(select rut_alumno from matricula where id_curso = '".$this->cmb_curso."')
ORDER BY ape_pat ASC";  
	    $result= @pg_Exec($conn,$sql);
		return $result;
	}
	
	function CambiaDatoApo($fila_apo){
		$this->rut_apo		= $fila_apo['rut_apo']." - ".$fila_apo['dig_rut'];
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
		@$this->responsable =  @$fila_apo['responsable'];
		$this->parentezco =  $fila_apo['parentezco'];
		$this->ultimo_ano_aprobado =  $fila_apo['ultimo_ano_aprobado'];
		$this->edad_primer_parto =  $fila_apo['edad_primer_parto'];
		$this->fecha_nac_apo =  $fila_apo['fecha_nac'];
		
		$this->calle_apo	= $fila_apo['calle'];
		$this->numcalle_apo	= $fila_apo['nro'];
		$this->lugar_trabajo	= $fila_apo['lugar_trabajo']; 
		
				
		if ($fila_apo['responsable']==1)
			$this->relacion = "APODERADO - ";
		if ($fila_apo['relacion']==1)
			$this->relacion = $relacion."PADRE";
		if ($fila_apo['relacion']==2)
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
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso,m.tipo_retiro ";
		$sql.= " FROM alumno a, matricula m, curso c WHERE m.id_ano = ".$this->ano." and m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.bool_ar = '1'  and c.id_curso = m.id_curso and c.id_ano = m.id_ano ";
		$sql.= " ORDER BY c.ensenanza, c.grado_curso, c.letra_curso,id_curso, nro_lista, nombre_alu ";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		return $result;
	}
	
	function AlumnoActivoIns($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso ";
		$sql.= " FROM alumno a, matricula m, curso c WHERE m.id_ano = ".$this->ano." and m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.bool_ar = '0'  and c.id_curso = m.id_curso and c.id_ano = m.id_ano ";
		$sql.= " ORDER BY c.ensenanza, c.grado_curso, c.letra_curso,id_curso, nro_lista, nombre_alu ";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		return $result;
	}
	
	function AlumnoActivoCurso($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso ";
		$sql.= " FROM alumno a, matricula m, curso c WHERE m.id_curso = ".$this->curso." and m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.bool_ar = '0'  and c.id_curso = m.id_curso and c.id_ano = m.id_ano ";
		$sql.= " ORDER BY c.ensenanza, c.grado_curso, c.letra_curso,id_curso, nro_lista, nombre_alu ";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		return $result;
	}
	
	function AlumnoRetiradoCurso($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso,m.tipo_retiro ";
		$sql.= " FROM alumno a, matricula m WHERE m.id_ano = ".$this->ano." and m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.id_curso = ".$this->curso." and m.bool_ar = '1' ";
		$sql.= " ORDER BY id_curso, nro_lista, nombre_alu";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		return $result;
	}
	function AlumnoEvaluacionDiferencial($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso ";
		$sql.= " FROM alumno a, matricula m, curso c WHERE m.id_ano = ".$this->ano." and m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.bool_ed = '1'  and c.id_curso = m.id_curso and c.id_ano = m.id_ano ";
		$sql.= " ORDER BY c.ensenanza, c.grado_curso, c.letra_curso,id_curso, nro_lista, nombre_alu ";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		return $result;
	}
	function AlumnoExtranjeroIns($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.id_curso,a.pais_origen ";
		$sql.= " FROM alumno a, matricula m, curso c WHERE m.id_ano = ".$this->ano." AND m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and a.nacionalidad != '2'  and c.id_curso = m.id_curso and c.id_ano = m.id_ano ";
		$sql.= " ORDER BY c.ensenanza, c.grado_curso, c.letra_curso,id_curso, nro_lista, nombre_alu";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		return $result;
	}
	function AlumnoExtranjeroCurso($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso,a.pais_origen ";
		$sql.= " FROM alumno a, matricula m WHERE m.id_ano = ".$this->ano." AND m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.id_curso = ".$this->curso." and a.nacionalidad != '2' ";
		$sql.= " ORDER BY id_curso, nro_lista, nombre_alu";
		
		$result =@pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		return $result;
	}
	function AlumnoIndigenaIns($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.id_curso ";
		$sql.= " FROM alumno a, matricula m, curso c WHERE m.id_ano = ".$this->ano." AND m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.bool_aoi = '1'  and c.id_curso = m.id_curso and c.id_ano = m.id_ano ";
		$sql.= " ORDER BY c.ensenanza, c.grado_curso, c.letra_curso,id_curso, nro_lista, nombre_alu";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		return $result;
	}
	function AlumnoIndigenaCurso($conn){
		$sql = " SELECT a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, m.fecha_retiro, m.id_curso ";
		$sql.= " FROM alumno a, matricula m WHERE m.id_ano = ".$this->ano." AND m.rdb = ".$this->institucion." AND ";
		$sql.= " m.rut_alumno = a.rut_alumno and m.id_curso = ".$this->curso." and m.bool_aoi = '1' ";
		$sql.= " ORDER BY id_curso, nro_lista, nombre_alu";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
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
		$sql.="	ORDER BY cod_tipo ASC) ORDER BY cod_tipo ASC";
		//if($_PERFIL==0){echo $sql;}
		$result =@pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
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
		$result =@pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		return $result;
	}
	function AlumnosPromovidos($conn){
		$sql = " SELECT alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.rut_alumno, alumno.dig_rut FROM alumno ";
		$sql.= " WHERE rut_alumno IN (SELECT rut_alumno FROM promocion WHERE situacion_final='1' AND id_curso IN ";
		$sql.= " (SELECT id_curso FROM curso WHERE id_ano = ".$this->ano." AND ensenanza in( ".$this->cod_tipo.") AND ";
		$sql.= " grado_curso = ".$this->grado_curso."))  ORDER BY ape_pat, ape_mat, nombre_alu";
		$result= @pg_Exec($conn,$sql) or die ("SELECT FALL�:".$sql);
		//if($_PERFIL==0){echo "<br>".$sql;}
		return $result;
	}
	function AlumnosPromovidos2($conn){
		$sql="SELECT alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.rut_alumno, alumno.dig_rut,e.nombre_esp ";
		$sql.=" FROM alumno INNER JOIN promocion ON alumno.rut_alumno=promocion.rut_alumno AND situacion_final=1 ";
		$sql.=" INNER JOIN curso ON curso.id_curso=promocion.id_curso ";
		$sql.=" LEFT JOIN especialidad e ON e.cod_sector=curso.cod_sector AND e.cod_rama=curso.cod_rama AND e.cod_esp=curso.cod_es ";
		$sql.=" WHERE curso.id_ano=".$this->ano." AND ensenanza in(".$this->cod_tipo.") AND grado_curso = ".$this->grado_curso."";
		$sql.=" ORDER BY ensenanza,grado_curso, letra_curso,ape_pat, ape_mat, nombre_alu ";
		$result= @pg_Exec($conn,$sql) or die ("SELECT FALL�:".$sql);
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
		//echo $sql;
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
		//echo $sql;
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
  
  function CursoEnsenanza_fin_ano($conn){
		$sql = "SELECT distinct ensenanza FROM curso WHERE id_ano = '".$this->ano."' ";
		if($this->tipo_ensenanza > 0){
			$sql.=" AND ensenanza = '".$this->tipo_ensenanza."'";
		}
		if($this->grado!=""){
			$sql.= " AND grado_curso=".$this->grado."";
		}
		$sql.=" ORDER BY ensenanza ASC ";
		
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
  
  function Atrasosmes($conn){
	 $rut_alumno =substr($this->rut_alumno,0,8);
	  
  		 $sql = "SELECT * FROM anotacion WHERE tipo = ".$this->tipo." AND rut_alumno = ".$rut_alumno." and fecha >='".$this->fecha_inicio."' AND fecha <='".$this->fecha_termino."'";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO: ".$sql);
		return $result;
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
  	$sql = "SELECT subsector.cod_subsector, subsector.nombre, ramo.id_ramo, ramo.modo_eval, ramo.conex, ramo.conexper, ramo.nota_exim,ramo.sub_obli , ramo.porc_examen, bool_ip,bool_pgeneral ";
	$sql.= "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	
	
	$sql.= "WHERE (((ramo.id_curso)=".$this->curso.")) ";
	

	if($this->modo_eval!=""){
		$sql.= "AND ramo.modo_eval<>".$this->modo_eval." ";
	}
	
	if($this->promocion!=""){
		$sql.= " AND bool_ip=".$this->promocion." ";
	}
	
	if($this->cdsub!=""){
		$sql.= " AND ramo.cod_subsector=".$this->cdsub." ";
	}

	$sql.= "ORDER BY ramo.id_orden ";
	
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);

//echo $sql;
	$fila = @pg_fetch_array($result,0);
	$this->cod_subsector = $fila['cod_subsector'];
	$this->nombre_subsector = $fila['nombre'];
	$this->id_ramo  = $fila['id_ramo'];
	$this->modo_eval = $fila['modo_eval'];
	$this->porc_examen = $fila['porc_examen'];
	$this->result =$result;
    
	//if($_PERFIL==0) echo $sql;	
	 
	return; 
	
  }
  
  
   function SubsectorRamo2($conn){
  	$sql = "SELECT subsector.cod_subsector, subsector.nombre, ramo.id_ramo, ramo.modo_eval, ramo.conex, ramo.nota_exim,ramo.sub_obli , ramo.porc_examen ";
	$sql.= "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql.= "WHERE (((ramo.id_curso)=".$this->curso.")) ";

	
		$sql.= "AND ramo.modo_eval=".$this->modo_eval;
	
		$sql.= " AND bool_ip=".$this->promocion." ";
		
		$sql.= " AND bool_pgeneral=".$this->general." ";
	

	$sql.= "ORDER BY ramo.id_orden ";
	
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);

//echo $sql;
	$fila = @pg_fetch_array($result,0);
	$this->cod_subsector = $fila['cod_subsector'];
	$this->nombre_subsector = $fila['nombre'];
	$this->id_ramo  = $fila['id_ramo'];
	$this->modo_eval = $fila['modo_eval'];
	$this->porc_examen = $fila['porc_examen'];
	$this->result =$result;
    
	//if($_PERFIL==0) echo $sql;	
	 
	return; 
	
  }
  
  
  function SubsectorRamo3($conn){
  	$sql = "SELECT subsector.cod_subsector, subsector.nombre, ramo.id_ramo, ramo.modo_eval, ramo.conex, ramo.nota_exim,ramo.sub_obli , ramo.porc_examen ";
	$sql.= "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql.= "WHERE (((ramo.id_curso)=".$this->curso.")) ";

	$sql.= " AND ramo.cod_subsector=".$this->cdsub." ";
	$sql.= "ORDER BY ramo.id_orden ";
	
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);

//echo $sql;
	$fila = @pg_fetch_array($result,0);
	$this->cod_subsector = $fila['cod_subsector'];
	$this->nombre_subsector = $fila['nombre'];
	$this->id_ramo  = $fila['id_ramo'];
	$this->modo_eval = $fila['modo_eval'];
	$this->porc_examen = $fila['porc_examen'];
	$this->result =$result;
    
	//if($_PERFIL==0) echo $sql;	
	 
	return; 
	
  }
  
  
  
  function RamoAlumnoEximido($conn){
  	/*  $sql = "SELECT distinct ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip,subsector.nombre_ingles,   
	  ramo.cod_subsector, ramo.bool_ip,ramo.id_orden, ramo.bool_artis,bool_pgeneral, 
	  CASE WHEN tiene$this->nro_ano.rut_alumno IS NULL THEN 0 
      ELSE tiene$this->nro_ano.rut_alumno END AS bool_tiene  ";
	  $sql.= "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	  if($this->subsector==0){
	  	$sql.= " and ramo.cod_subsector < 50000 ";
	  }
	  $sql.= " ) LEFT JOIN ";
	  $sql.= "tiene$this->nro_ano ON (ramo.id_curso = tiene$this->nro_ano.id_curso) AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) AND (tiene$this->nro_ano.rut_alumno=".$this->alumno." ) ";
	  $sql.= "WHERE (((ramo.id_curso)=".$this->curso.") AND formacion=".$this->formacion." AND sub_obli=1 ) order by ramo.id_orden; ";*/
	  //-----------------
	 /* $sql="SELECT distinct ramo.id_ramo, subsector.nombre, ramo.modo_eval,
ramo.bool_ip,subsector.nombre_ingles, ramo.cod_subsector, 
ramo.bool_ip,ramo.id_orden,ramo.formacion, ramo.bool_artis,pct_ex_semestral,
ramo.conexper,ramo.porc_nota_pu,ramo.bool_pu,ramo.porc_psintesis,
ramo.bool_psintesis,bool_pgeneral,ramo.truncado,ramo.coef2, ramo.sub_obli,
CASE WHEN tiene$this->nro_ano.rut_alumno IS NULL THEN 0 ELSE tiene$this->nro_ano.rut_alumno
END AS bool_tiene ";

$sql.="FROM (ramo INNER JOIN subsector 
ON ramo.cod_subsector = subsector.cod_subsector )
LEFT JOIN tiene$this->nro_ano ON (ramo.id_curso = tiene$this->nro_ano.id_curso) 
AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) AND (tiene$this->nro_ano.rut_alumno=".$this->alumno." ) ";

if($this->subsector==0){
	  	$sql.= " and ramo.cod_subsector < 50000 ";
	  }
	  
	$sql.="WHERE (((ramo.id_curso)=".$this->curso.") 
AND ramo.formacion=1 and bool_ip=1  ) order by ramo.id_orden ASC";  */

$sql="SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval,
ramo.bool_ip, subsector.nombre_ingles, ramo.cod_subsector,
ramo.id_orden, ramo.formacion, ramo.bool_artis, pct_ex_semestral, 
ramo.conexper, ramo.porc_nota_pu, ramo.bool_pu, ramo.porc_psintesis, 
ramo.bool_psintesis, bool_pgeneral, ramo.truncado, ramo.coef2, 
ramo.sub_obli, ramo.nota_ex_semestral,
CASE WHEN tiene$this->nro_ano.rut_alumno IS NULL THEN 0 ELSE tiene$this->nro_ano.rut_alumno
END AS bool_tiene 
FROM (ramo INNER JOIN subsector 
ON ramo.cod_subsector = subsector.cod_subsector )
LEFT JOIN tiene$this->nro_ano ON (ramo.id_curso = tiene$this->nro_ano.id_curso) 
AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) AND (tiene$this->nro_ano.rut_alumno=".$this->alumno.") 
WHERE (((ramo.id_curso)=".$this->curso.") 
AND ramo.formacion=1 AND ramo.sub_obli=1) 
union 
SELECT distinct ramo.id_ramo, subsector.nombre, ramo.modo_eval, 
ramo.bool_ip,subsector.nombre_ingles, ramo.cod_subsector, 
ramo.id_orden,ramo.formacion, ramo.bool_artis,pct_ex_semestral,
ramo.conexper,ramo.porc_nota_pu,ramo.bool_pu,ramo.porc_psintesis, 
ramo.bool_psintesis,bool_pgeneral,ramo.truncado,ramo.coef2,
ramo.sub_obli, ramo.nota_ex_semestral,
CASE WHEN tiene$this->nro_ano.rut_alumno IS NULL THEN 0 ELSE tiene$this->nro_ano.rut_alumno
END AS bool_tiene 
FROM (ramo INNER JOIN subsector 
ON ramo.cod_subsector = subsector.cod_subsector )
inner JOIN tiene$this->nro_ano ON (ramo.id_curso = tiene$this->nro_ano.id_curso) 
AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) AND (tiene$this->nro_ano.rut_alumno=".$this->alumno.") ";
if($this->subsector==0){
	  	$sql.= " and ramo.cod_subsector < 50000 ";
	  }
$sql.="WHERE (((ramo.id_curso)=".$this->curso.") 
AND ramo.formacion=1 AND ramo.sub_elect=1) order by 7 ASC";

	  
	  
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
  	  $sql = "SELECT distinct ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip,subsector.nombre_ingles, ramo.cod_subsector, ramo.bool_ip,ramo.id_orden,ramo.bool_artis, ramo.coef2 ";
	  $sql.= "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	  if($this->subsector==0){
	  	$sql.= " and (ramo.cod_subsector < 50000 or ramo.cod_subsector=50600 or ramo.cod_subsector=50629 )";
	  }
	  $sql.= " ) INNER JOIN ";
	  $sql.= "tiene$this->nro_ano ON (ramo.id_curso = tiene$this->nro_ano.id_curso) AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) ";
	  $sql.= "WHERE (((ramo.id_curso)=".$this->curso.") AND tiene$this->nro_ano.rut_alumno=".$this->alumno." ) and ramo.bool_ip=1 order by ramo.id_orden; ";
	 // if($_PERFIL==0) echo $sql;
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
	  
  		$sql ="SELECT distinct ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip,subsector.nombre_ingles, ramo.cod_subsector, ramo.bool_ip,ramo.id_orden,ramo.formacion, ramo.bool_artis,pct_ex_semestral, ramo.conexper,ramo.porc_nota_pu,ramo.bool_pu,ramo.porc_psintesis,ramo.bool_psintesis,bool_pgeneral,ramo.truncado,ramo.coef2,ramo.nota_ex_semestral,ramo.sub_obli,
			  CASE WHEN tiene$this->nro_ano.rut_alumno IS NULL THEN 0 
      ELSE tiene$this->nro_ano.rut_alumno END AS bool_tiene  ";
		$sql.="FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ) INNER JOIN tiene$this->nro_ano ON (ramo.id_curso = tiene$this->nro_ano.id_curso) ";
		$sql.="AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) WHERE (((ramo.id_curso)=".$this->curso.") AND tiene$this->nro_ano.rut_alumno=".$this->alumno." AND  ";
		$sql.="ramo.formacion=".$this->formacion." ) ";
		if($this->incide==1){
			 $sql.=" AND ramo.bool_ip=1 ";
		}
		
		$sql.="order by ramo.id_orden ASC; ";
		
		//if($_PERFIL==0) echo $sql;
		  
		  
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
	$result = @pg_exec($conn,$sql);
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
	$sql.=" alumno.nombre_alu as nombres, nro_lista FROM matricula INNER JOIN alumno ON matricula.rut_alumno=alumno.rut_alumno WHERE rdb=".$this->institucion." ";
	$sql.=" AND id_ano=".$this->ano." AND id_curso=".$this->curso." and bool_ar=0 AND matricula.rut_alumno in (SELECT rut_alumno FROM tiene$this->nro_ano ";
	$sql.=" WHERE id_ramo=".$this->ramo.") ";
	if($this->orden==0){
		$sql.=" ORDER BY nro_lista ASC";
	}else{
		$sql.=" ORDER BY nombres ASC";
	}
	//echo $sql;
	$result = @pg_exec($conn,$sql);
	return $result;
  }
  
  function PromedioSubAlumnos($conn){
		 $sql = "SELECT promedio FROM promedio_sub_alumno WHERE id_ano=".$this->ano." AND id_curso=".$this->curso." AND id_ramo=".$this->ramo." AND ";
		$sql.= "rut_alumno=".$this->rut_alumno;
		
		//if($_PERFIL==0) echo $sql;		
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	 function PromedioSubAlumnosEnOrden($conn){
		 if($this->modo==1){
			 $sql="SELECT pr.promedio,al.rut_alumno,al.ape_pat || ' ' || al.ape_mat || ' ' || al.nombre_alu as nombre_alumno
				FROM promedio_sub_alumno pr 
				inner join matricula mat on mat.rut_alumno=pr.rut_alumno AND pr.id_ano=mat.id_ano
				inner join alumno al on mat.rut_alumno=al.rut_alumno and mat.bool_ar=0
				WHERE pr.id_ano =".$this->ano." AND pr.id_curso=".$this->curso." AND pr.id_ramo=".$this->ramo." and pr.promedio  <> '0'  order by promedio ".$this->orden."";
		 }else{
				$sql="SELECT promedio,al.rut_alumno,al.ape_pat || ' ' || al.ape_mat || ' ' || al.nombre_alu as nombre_alumno
				FROM notas$this->nro_ano nt
				INNER JOIN matricula mat ON mat.rut_alumno=nt.rut_alumno AND mat.id_ano=".$this->ano."
				INNER JOIN alumno al on mat.rut_alumno=al.rut_alumno and mat.bool_ar=0
				WHERE id_periodo=".$this->periodo." AND id_ramo=".$this->ramo."  and promedio<>'0' ORDER BY promedio ".$this->orden."";
		 }
		
		/* $sql = "SELECT promedio FROM promedio_sub_alumno WHERE id_ano =".$this->ano."  
		 AND id_curso=".$this->curso." AND id_ramo=".$this->ramo." AND rut_alumno=".$this->rut_alumno." order by promedio $this->orden ";*/
		
		//if($_PERFIL==0) echo $sql;		
		$result = @pg_exec($conn,$sql)or die("falooo");
		return $result;
	}
  
 
 
 	function NotaExamen_periodo1($conn){
		
		 $sql_periodo = "select * from periodo where id_ano = ".$this->ano . " order by id_periodo";
	  $result_periodo = @pg_Exec($conn, $sql_periodo);
	$cadena = "";
	$habiles = 0;
	$cantidad_periodos =  @pg_numrows($result_periodo);
	for($e=0 ; $e < @pg_numrows($result_periodo) ; $e++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$e);
		if ($fila_periodo['dias_habiles']>0)
			$habiles = $habiles + $fila_periodo['dias_habiles'];
		if (trim($cadena)=="")
			$cadena = $fila_periodo['id_periodo'];
		else
			$cadena = $cadena . ";" . $fila_periodo['id_periodo'];
	}
	 $periodo=explode(";",$cadena);
	 $periodo[0];
	 $periodo[1];
	 $periodo[2];
		
			$qsl="select * from ramo where id_ramo=".$this->ramo;
			$resultc =pg_Exec($conn,$qsl);
			$filac = pg_fetch_array($resultc,$qsl);
			 $conexper= $filac['conexper'];	
		
 $sql="SELECT subsector.nombre,ramo.id_ramo,ramo.conexper,
sp.id_periodo,
sp.rut_alumno,
sp.nota_final,
sp.nota_examen,
sp.prom_gral,
sp.id_ramo
FROM ramo 
INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector
LEFT outer JOIN situacion_periodo as sp on ramo.id_ramo = sp.id_ramo WHERE ramo.id_curso=".$this->curso." and sp.rut_alumno= ".$this->rut_alumno." and sp.id_periodo = ".$periodo[0]." and ramo.conexper=1 and ramo.id_ramo=".$this->ramo;	
	
	$result_con =pg_Exec($conn,$sql)or die("Fallo Ex: ".$sql);
	return $result_con; 
			
	}
	
	function NotaExamen_periodo2($conn){
		
		 $sql_periodo = "select * from periodo where id_ano = ".$this->ano . " order by id_periodo";
	  $result_periodo = @pg_Exec($conn, $sql_periodo);
	$cadena = "";
	$habiles = 0;
	$cantidad_periodos =  @pg_numrows($result_periodo);
	for($e=0 ; $e < @pg_numrows($result_periodo) ; $e++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$e);
		if ($fila_periodo['dias_habiles']>0)
			$habiles = $habiles + $fila_periodo['dias_habiles'];
		if (trim($cadena)=="")
			$cadena = $fila_periodo['id_periodo'];
		else
			$cadena = $cadena . ";" . $fila_periodo['id_periodo'];
	}
	 $periodo=explode(";",$cadena);
	 $periodo[0];
	 $periodo[1];
	 $periodo[2];
		
			$qsl="select * from ramo where id_ramo=".$this->ramo;
			$resultc =pg_Exec($conn,$qsl);
			$filac = pg_fetch_array($resultc,$qsl);
			 $conexper= $filac['conexper'];	
		
 $sql="SELECT subsector.nombre,ramo.id_ramo,ramo.conexper,
sp.id_periodo,
sp.rut_alumno,
sp.nota_final,
sp.nota_examen,
sp.prom_gral,
sp.id_ramo
FROM ramo 
INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector
LEFT outer JOIN situacion_periodo as sp on ramo.id_ramo = sp.id_ramo WHERE ramo.id_curso=".$this->curso." and sp.rut_alumno= ".$this->rut_alumno." and sp.id_periodo = ".$periodo[1]." and ramo.conexper=1 and ramo.id_ramo=".$this->ramo;	
	
	$result_con =pg_Exec($conn,$sql)or die("Fallo Ex: ".$sql);
	return $result_con; 
			
	}
	
	function NotaExamen_periodo3($conn){
		
		 $sql_periodo = "select * from periodo where id_ano = ".$this->ano . " order by id_periodo";
	  $result_periodo = @pg_Exec($conn, $sql_periodo);
	$cadena = "";
	$habiles = 0;
	$cantidad_periodos =  @pg_numrows($result_periodo);
	for($e=0 ; $e < @pg_numrows($result_periodo) ; $e++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$e);
		if ($fila_periodo['dias_habiles']>0)
			$habiles = $habiles + $fila_periodo['dias_habiles'];
		if (trim($cadena)=="")
			$cadena = $fila_periodo['id_periodo'];
		else
			$cadena = $cadena . ";" . $fila_periodo['id_periodo'];
	}
	 $periodo=explode(";",$cadena);
	 $periodo[0];
	 $periodo[1];
	 $periodo[2];
		
			$qsl="select * from ramo where id_ramo=".$this->ramo;
			$resultc =pg_Exec($conn,$qsl);
			$filac = pg_fetch_array($resultc,$qsl);
			 $conexper= $filac['conexper'];	
		
 $sql="SELECT subsector.nombre,ramo.id_ramo,ramo.conexper,
sp.id_periodo,
sp.rut_alumno,
sp.nota_final,
sp.nota_examen,
sp.prom_gral,
sp.id_ramo
FROM ramo 
INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector
LEFT outer JOIN situacion_periodo as sp on ramo.id_ramo = sp.id_ramo WHERE ramo.id_curso=".$this->curso." and sp.rut_alumno= ".$this->rut_alumno." and sp.id_periodo = ".$periodo[2]." and ramo.conexper=1 and ramo.id_ramo=".$this->ramo;	
	
	$result_con =pg_Exec($conn,$sql)or die("Fallo Ex: ".$sql);
	return $result_con; 
			
	}
 
 
 
 function Promedio1Niv($conn){
	  
	  $sql_periodo = "select * from periodo where id_ano = ".$this->ano . " order by id_periodo";
	  $result_periodo = @pg_Exec($conn, $sql_periodo);
	$cadena = "";
	$habiles = 0;
	$cantidad_periodos =  @pg_numrows($result_periodo);
	for($e=0 ; $e < @pg_numrows($result_periodo) ; $e++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$e);
		if ($fila_periodo['dias_habiles']>0)
			$habiles = $habiles + $fila_periodo['dias_habiles'];
		if (trim($cadena)=="")
			$cadena = $fila_periodo['id_periodo'];
		else
			$cadena = $cadena . ";" . $fila_periodo['id_periodo'];
	}
	 $periodo=explode(";",$cadena);
	 $periodo[0];
	 $periodo[1];
	 $periodo[2];
	  
	  $sql_promedioniv="select DISTINCT c.grado_curso ||'-'|| c.letra_curso ||' '|| ti.nombre_tipo as nom_curso,
					 su.nombre as ramo, round(avg(cast(nt.promedio as INT)))  as promedio1
					from curso c
					inner join niveles n ON c.id_nivel=n.id_nivel
					inner join tipo_ensenanza ti ON c.ensenanza=ti.cod_tipo
					inner join ramo ra on c.id_curso=ra.id_curso
					inner JOIN notas2011 nt on ra.id_ramo=nt.id_ramo 
					inner join subsector su on ra.cod_subsector=su.cod_subsector
					WHERE c.id_ano=".$this->ano." and n.id_nivel=".$this->nivel." and nt.id_periodo=".$periodo[0]." and ra.cod_subsector=".$this->subsector." and nt.promedio ".$this->orden." '".$this->nota."'
					GROUP by c.grado_curso, c.letra_curso,ti.nombre_tipo,su.nombre 
";
	  
			//echo $sql_promedioniv;
$resultpniv = @pg_exec($conn,$sql_promedioniv) or die ("SELECT FALLO (Promedios):".$sql_promedioniv);
		return $resultpniv;
	  }
 
 
 	function Promedio1Niv2($conn){
	  
	  $sql_periodo = "select * from periodo where id_ano = ".$this->ano . " order by id_periodo";
	  $result_periodo = @pg_Exec($conn, $sql_periodo);
	$cadena = "";
	$habiles = 0;
	$cantidad_periodos =  @pg_numrows($result_periodo);
	for($e=0 ; $e < @pg_numrows($result_periodo) ; $e++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$e);
		if ($fila_periodo['dias_habiles']>0)
			$habiles = $habiles + $fila_periodo['dias_habiles'];
		if (trim($cadena)=="")
			$cadena = $fila_periodo['id_periodo'];
		else
			$cadena = $cadena . ";" . $fila_periodo['id_periodo'];
	}
	 $periodo=explode(";",$cadena);
	 $periodo[0];
	 $periodo[1];
	 $periodo[2];
	  
	  $sql_promedioniv="select DISTINCT c.grado_curso ||'-'|| c.letra_curso ||' '|| ti.nombre_tipo as nom_curso,
					 su.nombre as ramo, round(avg(cast(nt.promedio as INT)))  as promedio2
					from curso c
					inner join niveles n ON c.id_nivel=n.id_nivel
					inner join tipo_ensenanza ti ON c.ensenanza=ti.cod_tipo
					inner join ramo ra on c.id_curso=ra.id_curso
					inner JOIN notas2011 nt on ra.id_ramo=nt.id_ramo 
					inner join subsector su on ra.cod_subsector=su.cod_subsector
					WHERE c.id_ano=".$this->ano." and n.id_nivel=".$this->nivel." and nt.id_periodo=".$periodo[1]." and ra.cod_subsector=".$this->subsector." and nt.promedio ".$this->orden." '".$this->nota."'
					GROUP by c.grado_curso, c.letra_curso,ti.nombre_tipo,su.nombre
";
	  
			 $sql_promedioniv;
$resultpniv = @pg_exec($conn,$sql_promedioniv) or die ("SELECT FALLO (Promedios):".$sql_promedioniv);
		return $resultpniv;
	  }
	  
	  
	  function Promedio1Niv3($conn){
	  
	  $sql_periodo = "select * from periodo where id_ano = ".$this->ano . " order by id_periodo";
	  $result_periodo = @pg_Exec($conn, $sql_periodo);
	$cadena = "";
	$habiles = 0;
	$cantidad_periodos =  @pg_numrows($result_periodo);
	for($e=0 ; $e < @pg_numrows($result_periodo) ; $e++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$e);
		if ($fila_periodo['dias_habiles']>0)
			$habiles = $habiles + $fila_periodo['dias_habiles'];
		if (trim($cadena)=="")
			$cadena = $fila_periodo['id_periodo'];
		else
			$cadena = $cadena . ";" . $fila_periodo['id_periodo'];
	}
	 $periodo=explode(";",$cadena);
	 $periodo[0];
	 $periodo[1];
	 $periodo[2];
	  
	  $sql_promedioniv="select DISTINCT c.grado_curso ||'-'|| c.letra_curso ||' '|| ti.nombre_tipo as nom_curso,
					 su.nombre as ramo, round(avg(cast(nt.promedio as INT)))  as promedio3
					from curso c
					inner join niveles n ON c.id_nivel=n.id_nivel
					inner join tipo_ensenanza ti ON c.ensenanza=ti.cod_tipo
					inner join ramo ra on c.id_curso=ra.id_curso
					inner JOIN notas2011 nt on ra.id_ramo=nt.id_ramo 
					inner join subsector su on ra.cod_subsector=su.cod_subsector
					WHERE c.id_ano=".$this->ano." and n.id_nivel=".$this->nivel." and nt.id_periodo=".$periodo[2]." and ra.cod_subsector=".$this->subsector." and nt.promedio ".$this->orden." '".$this->nota."'
					GROUP by c.grado_curso, c.letra_curso,ti.nombre_tipo,su.nombre
";
	  
			 $sql_promedioniv;
$resultpniv = @pg_exec($conn,$sql_promedioniv) or die ("SELECT FALLO (Promedios):".$sql_promedioniv);
		return $resultpniv;
	  }
 
 		
  
  function Promedio1($conn){
	  
	  $sql_periodo = "select * from periodo where id_ano = ".$this->ano . " order by id_periodo";
	  $result_periodo = @pg_Exec($conn, $sql_periodo);
	$cadena = "";
	$habiles = 0;
	$cantidad_periodos =  @pg_numrows($result_periodo);
	for($e=0 ; $e < @pg_numrows($result_periodo) ; $e++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$e);
		if ($fila_periodo['dias_habiles']>0)
			$habiles = $habiles + $fila_periodo['dias_habiles'];
		if (trim($cadena)=="")
			$cadena = $fila_periodo['id_periodo'];
		else
			$cadena = $cadena . ";" . $fila_periodo['id_periodo'];
	}
	 $periodo=explode(";",$cadena);
	 $periodo[0];
	 $periodo[1];
	 $periodo[2];
	  
	  $sql_promedio="select * from notas$this->nro_ano where id_ramo=".$this->ramo." and id_periodo=".$periodo[0]."  ";
	  if($this->periodo[0]!=""){
				$sql_promedio.=" AND id_periodo=".$this->periodo[0]." ";
			}
			if($this->rut_alumno!=""){
				$sql_promedio.=" AND rut_alumno='".$this->rut_alumno."'";
			}
			//echo $sql_promedio;
$resultp = @pg_exec($conn,$sql_promedio) or die ("SELECT FALLO (Promedios1):".$sql_promedio);
		return $resultp;
	  }
  
  		function Promedio2($conn){
			 $sql_periodo = "select * from periodo where id_ano = ".$this->ano . " order by id_periodo";
	  $result_periodo = @pg_Exec($conn, $sql_periodo);
	$cadena = "";
	$habiles = 0;
	$cantidad_periodos =  @pg_numrows($result_periodo);
	for($e=0 ; $e < @pg_numrows($result_periodo) ; $e++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$e);
		if ($fila_periodo['dias_habiles']>0)
			$habiles = $habiles + $fila_periodo['dias_habiles'];
		if (trim($cadena)=="")
			$cadena = $fila_periodo['id_periodo'];
		else
			$cadena = $cadena . ";" . $fila_periodo['id_periodo'];
	}
	 $periodo=explode(";",$cadena);
	 $periodo[0];
	 $periodo[1];
	 $periodo[2];
	  
	   $sql_promedio2="select * from notas$this->nro_ano where id_ramo=".$this->ramo." and id_periodo=".$periodo[1]."  ";
	  if($this->periodo[1]!=""){
				$sql_promedio2.=" AND id_periodo=".$this->periodo[1]." ";
			}
			if($this->rut_alumno!=""){
				$sql_promedio2.=" AND rut_alumno='".$this->rut_alumno."'";
			}
			//echo $sql_promedio2;
$resultp2 = @pg_exec($conn,$sql_promedio2) or die ("SELECT FALLO (Promedios2):".$sql_promedio2);
		return $resultp2;
			
			}	
			
			function Promedio3($conn){
			 $sql_periodo = "select * from periodo where id_ano = ".$this->ano . " order by id_periodo";
	  $result_periodo = @pg_Exec($conn, $sql_periodo);
	$cadena = "";
	$habiles = 0;
	$cantidad_periodos =  @pg_numrows($result_periodo);
	for($e=0 ; $e < @pg_numrows($result_periodo) ; $e++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$e);
		if ($fila_periodo['dias_habiles']>0)
			$habiles = $habiles + $fila_periodo['dias_habiles'];
		if (trim($cadena)=="")
			$cadena = $fila_periodo['id_periodo'];
		else
			$cadena = $cadena . ";" . $fila_periodo['id_periodo'];
	}
	 $periodo=explode(";",$cadena);
	 $periodo[0];
	 $periodo[1];
	 $periodo[2];
	  
	   $sql_promedio3="select * from notas$this->nro_ano where id_ramo=".$this->ramo." and id_periodo=".$periodo[2]." and promedio ".$this->orden." '".$this->nota."' ";
	  if($this->periodo[2]!=""){
				$sql_promedio3.=" AND id_periodo=".$this->periodo[2]." ";
			}
			if($this->rut_alumno!=""){
				$sql_promedio3.=" AND rut_alumno='".$this->rut_alumno."'";
			}
			//echo $sql_promedio3;
$resultp3 = @pg_exec($conn,$sql_promedio3) or die ("SELECT FALLO (Promedios):".$sql_promedio3);
		return $resultp3;
			
			
			}	
		
		
  function Notas($conn){
  	
	//COALESCE(sp.nota_final,cast(nts.promedio as INTEGER)) as  
	$sql ="SELECT nts.id_ramo,nts.id_periodo,nts.rut_alumno, 
		nts.nota1,nts.nota2,nts.nota3,nts.nota4,
		nts.nota5,nts.nota6,nts.nota7,nts.nota8,
		nts.nota9,nts.nota10,nts.nota11,nts.nota12,
		nts.nota13,nts.nota14,nts.nota15,nts.nota16,
		nts.nota17,nts.nota18,nts.nota19,nts.nota20,
		nts.promedio,
		nts.notaap
		 FROM notas$this->nro_ano as nts INNER JOIN periodo p ON nts.id_periodo=p.id_periodo
		WHERE nts.id_ramo=".$this->ramo." ";
			
			if($this->periodo!=""){
				$sql.=" AND nts.id_periodo=".$this->periodo."  ";
			}
			if($this->rut_alumno!=""){
				$sql.=" AND nts.rut_alumno='".$this->rut_alumno."'";
			}
			if(@$this->opcion==1){
				$sql.=" AND nts.promedio >='".$this->prom."'";	
			}
			if(@$this->opcion==2){
				$sql.=" AND nts.promedio <='".$this->prom."'";
			}
	   
	 	 $sql.=" ORDER BY fecha_inicio ASC";
	   
		//if($_PERFIL==0) echo "<br>Notas-->".$sql;
		
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (Notas):".$sql);
		return $result;
		
	  }
  
  
  	/*function nota_situacion_periodo($conn){
		$sqlc="select * from situacion_periodo
		WHERE id_ramo=".$this->ramo." ";
		if($this->periodo!=""){
		$sqlc.=" AND id_periodo=".$this->periodo." ";
	}
	if($this->rut_alumno!=""){
		$sqlc.=" AND rut_alumno='".$this->rut_alumno."'";
	}
			//echo $sqlc;
		
		$resultc = @pg_exec($conn,$sqlc) or die ("SELECT FALLO (Notas):".$sqlc);
	    return $resultc;
		}*/
  
    function Notas2($conn){
  	
	//  para mostrar examen periodo cuando exista. --COALESCE(cast(sp.nota_final as char),nts.promedio) as promedio,
	
	$sql ="SELECT nts.id_ramo,nts.id_periodo,nts.rut_alumno, 
	nts.nota1,nts.nota2,nts.nota3,nts.nota4,
	nts.nota5,nts.nota6,nts.nota7,nts.nota8,
	nts.nota9,nts.nota10,nts.nota11,nts.nota12,
	nts.nota13,nts.nota14,nts.nota15,nts.nota16,
	nts.nota17,nts.nota18,nts.nota19,nts.nota20,nts.promedio,sp.nota_final,
	nts.notaap";
	
	$sql.=" FROM notas$this->nro_ano as nts 
	LEFT OUTER JOIN situacion_periodo as sp ON sp.rut_alumno = nts.rut_alumno 
	AND sp.id_ramo = nts.id_ramo AND sp.id_periodo = nts.id_periodo
	WHERE nts.id_ramo=".$this->ramo." ";
	
	if($this->periodo!=""){
		$sql.=" AND nts.id_periodo=".$this->periodo." ";
	}
	if($this->rut_alumno!=""){
		$sql.=" AND nts.rut_alumno='".$this->rut_alumno."'";
	}
	
	//if($_PERFIL==0) echo "<pre>".$sql."</pre>";
	
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
  	if(@$this->modo_eval==1){
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
	if($this->curso!=0){
		$sql.="AND id_curso=".$this->curso." ";
	}
	if($this->situacion!=""){
		$sql.= "AND situacion_final=".$this->situacion."  ";
	}
	if($this->alumno!=""){
		$sql.=" AND rut_alumno=".$this->alumno."";
	}
	//echo $sql;
	//if($_PERFIL==0){echo "<br>".$sql;}
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
	$sql.=" and p.promedio > 0 ORDER BY  p.promedio DESC ";
	
	$result = pg_exec($conn,$sql) or die ("SELECT FALLO (mejores promedios):".$sql);
	return $result;
  }
  
  function MejoresPromediosAlumnos($conn){
	$sql =" select avg(cast(p.promedio as integer)) as prom, al.rut_alumno, al.dig_rut, 
	al.nombre_alu, al.ape_pat, al.ape_mat, al.comuna, c.id_curso, c.grado_curso, 
	c.ensenanza, c.letra_curso, co.nom_com 
	from promedio_sub_alumno p,alumno al, curso c, comuna co 
	WHERE c.id_curso = p.id_curso AND p.rut_alumno = al.rut_alumno 
	AND al.region = co.cod_reg AND al.ciudad = co.cor_pro AND al.comuna = co.cor_com";
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
		$sql.=" AND  p.promedio>'0' AND p.promedio not in ('MB','B','S','I','EX')";
	}
	$sql.=" GROUP BY al.rut_alumno, al.dig_rut, 
al.nombre_alu, al.ape_pat, al.ape_mat, al.comuna, c.id_curso, c.grado_curso, 
c.ensenanza, c.letra_curso, co.nom_com
HAVING avg(cast(p.promedio as integer)) > ".$this->promedio."";
	
	
	if($_PERFIL==0){
		//echo "<br>".$sql;
		}
	$result = @pg_Exec($conn,$sql)or die("Fallo qryProm".$sql);
	
	return $result;
  }
  
   function MejoresPromediosAlumnosParciales($conn){
	$sql =" select avg(cast(p.promedio as integer)) as prom, al.rut_alumno, al.dig_rut, 
al.nombre_alu, al.ape_pat, al.ape_mat, al.comuna, c.id_curso, c.grado_curso, 
c.ensenanza, c.letra_curso, co.nom_com 
from notas".$this->nro_ano." p,alumno al, curso c, comuna co , ramo r
WHERE p.id_ramo = r.id_ramo AND r.id_curso= c.id_curso
AND p.rut_alumno = al.rut_alumno 
AND al.region = co.cod_reg AND al.ciudad = co.cor_pro AND al.comuna = co.cor_com";
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
		$sql.=" AND  p.promedio>'0' AND p.promedio not in ('MB','B','S','I','EX')";
	}
	$sql.=" GROUP BY 2,3,4,5,6,7,8,9,10,11,12
HAVING avg(cast(p.promedio as integer)) > ".$this->promedio."";

	$result = @pg_Exec($conn,$sql);
	
	return $result;
  }
  
  
  function PromedioRamo($conn){
  	 $sql ="SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador FROM notas$this->nro_ano WHERE id_ramo IN (SELECT id_ramo FROM ";
	$sql.=" ramo WHERE id_curso=".$this->curso.") AND id_periodo=".$this->periodo." AND promedio NOT IN('0','MB','B','S','I',' ','x','P','AL','L','NL','EP') AND promedio > '0'";
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (PromedioRamo):".$sql);
	$this->suma = @pg_result($result,0);
	$this->contador = @pg_result($result,1);
	$this->result = $result;
	return;
  }
  
  function PromedioRamoEXMN($conn){
  	$sql ="SELECT NOTA_FINAL from SITUACION_PERIODO ";
	$sql.=" WHERE id_ramo=".$this->id_ramo." AND id_periodo=".$this->periodo." and rut_alumno=".$this->alumno;
	//echo $sql;
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (PromedioRamoEXMN):".$sql);
	$this->promedioex = @pg_result($result,0);
	return;
  }
  
    function PromedioPerEXMNAVG($conn){ 
  	$sql ="SELECT sum(NOTA_FINAL) as suma, count(*) as contador from SITUACION_PERIODO ";
	$sql.=" WHERE id_periodo=".$this->periodos." and rut_alumno=".$this->alumno;
	//echo $sql;
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (PromedioRamo):".$sql);
	$this->suma = @pg_result($result,0);
	$this->contador = @pg_result($result,1);
	$this->result = $result;
	return;
  }
  
  
  function PromedioEXMANRamo($conn){
  	$sql ="SELECT nota_examen,nota_final from situacion_periodo ";
	$sql.=" WHERE id_ramo=".$this->id_ramo." AND id_periodo=".$this->periodo." and rut_alumno=".$this->rut_alumno;
	//echo $sql;
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (PromedioRamoEXMN):".$sql);
	$result = @pg_Exec($conn,$sql);
	
	return $result;
  }
  
  
  function PromedioRamoCurso($conn){
  	$sql ="SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador FROM notas$this->nro_ano WHERE id_ramo=".$this->ramo." AND promedio NOT IN('0','MB','B','S','I',' ','x')  AND promedio>'0' ";
	if($this->periodo!=""){
		$sql.="AND id_periodo=".$this->periodo."";
	}
	//if($_PERFIL==0){ echo "<br>".$sql;}

	$result = @pg_exec($conn,$sql);
	$this->suma_curso = @pg_result($result,0);
	$this->contador_curso =@pg_result($result,1);
	$this->result = $result;
	return;
  }
  function PromedioRamoCursoFinal($conn){
  	$sql ="SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador FROM promedio_sub_alumno WHERE id_ramo=".$this->ramo." AND promedio NOT IN('0','MB','B','S','I',' ','x')  AND promedio>'0' AND rut_alumno in (SELECT rut_alumno FROM promocion WHERE id_ramo=".$this->ramo." AND situacion_final=1)";
	
	if($_PERFIL==0){
		//echo $sql;
	}
	$result = @pg_exec($conn,$sql);
	
	//$this->suma_curso = @pg_result($result,0);
	//$this->contador_curso =@pg_result($result,1);
	//$this->result = $result;
	return $result;
  }
  
  
  function PromedioRamoCursoFinalNew($conn){
  	 $sql ="SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador FROM promedio_sub_alumno WHERE id_ramo=".$this->ramo." AND promedio NOT IN('0','MB','B','S','I',' ','x')  AND promedio>'0' AND rut_alumno in (SELECT rut_alumno FROM promocion WHERE id_curso=".$this->curso." AND situacion_final in(1,2))";
	
	/*if($_PERFIL==0){
		echo $sql;
	}*/
	$result = @pg_exec($conn,$sql);
	
	//$this->suma_curso = @pg_result($result,0);
	//$this->contador_curso =@pg_result($result,1);
	//$this->result = $result;
	return $result;
  }
  function PromedioAPRamoCurso($conn){
  	$sql ="SELECT sum(cast (notaap as INTEGER)) as suma, count(*) as contador FROM notas$this->nro_ano WHERE id_ramo=".$this->ramo." AND notaap>'0'";
	if($this->periodo!=""){
		$sql.=" AND id_periodo=".$this->periodo."";
	}
	//echo $sql;
	$result = @pg_exec($conn,$sql);
	$this->suma = @pg_result($result,0);
	$this->contador =@pg_result($result,1);
	$this->result = $result;
	return;
  }
  function PromedioAlumno($conn){
   	$sql = "SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador,sum(cast (notaap as INTEGER)) as promedioap FROM notas$this->nro_ano WHERE id_ramo in ";
	$sql.= "(SELECT id_ramo FROM ramo WHERE id_ramo in (SELECT id_ramo ";
	$sql.= " FROM notas$this->nro_ano WHERE id_periodo = '".$this->periodos."' AND rut_alumno = '".$this->alumno."') and (cod_subsector < 50000 or cod_subsector=50600 or cod_subsector=50629)";
	$sql.= " and bool_pgeneral=1 and bool_ip=1 ) AND rut_alumno = '".$this->alumno."' AND id_periodo = '".$this->periodos."' ";
	$sql.= " AND promedio NOT IN ('MB','B','S','I','0',' ','P','AL','L','NL','G','RV','N')";
	//if($_PERFIL==0) echo "<br>".$sql;
	$result =@pg_exec($conn,$sql);
	$this->suma = @pg_result($result,0);
	$this->contador = @pg_result($result,1);
	$this->sumaAP = @pg_result($result,2);
	$this->result = $result;
	$this->sql = $sql;
	return;
  }
  
    function PromedioAlumnoSubNoValido($conn){
  	$sql = "SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador,sum(cast (notaap as INTEGER)) as promedioap FROM notas$this->nro_ano WHERE id_ramo in ";
	$sql.= "(SELECT id_ramo FROM ramo WHERE id_ramo in (SELECT id_ramo ";
	$sql.= " FROM notas$this->nro_ano WHERE id_periodo = '".$this->periodos."' AND rut_alumno = '".$this->alumno."') ";
	$sql.= " and bool_pgeneral=1 ) AND rut_alumno = '".$this->alumno."' AND id_periodo = '".$this->periodos."' ";
	$sql.= " AND promedio NOT IN ('MB','B','S','I','0',' ','P','AL','L','NL','G','RV','N')";
	//if($_PERFIL==0) echo $sql;
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
	$sql.= " WHERE rut_alumno in (SELECT rut_alumno FROM tiene_taller WHERE rut_alumno=".$this->alumno." AND id_periodo=".$this->periodos.") ";
	$sql.= " AND promedio not in ('MB','B','S','I','0',' ')";
	$result =@pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$this->suma = @pg_result($result,0);
	$this->contador = @pg_result($result,1);
	$this->result = $result;
	return;
  }
  function NombreSubsector($conn){
  	 $sql = "SELECT ramo.id_ramo,subsector.nombre,ramo.modo_eval,ramo.conex,ramo.sub_obli,sub_elect,ramo.truncado,ramo.bool_artis,ramo.cod_subsector,bool_sar,ramo.conexper,ramo.nota_ex_semestral  FROM subsector, ramo WHERE  ";
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
	
	if($this->codsu!=""){
		$sql.=" AND subsector.cod_subsector=".$this->codsu."";
	}
	
	$sql.=" ORDER BY id_orden ASC ";
	$result = @pg_exec($conn,$sql) or die( "SELECT FALLO :".$sql);
	//if($_PERFIL==0) echo $sql;
	$this->nombre_sub = pg_result($result,1);
	$this->modo_eval = pg_result($result,2);
	$this->exmp = pg_result($result,10);
	$this->nexmp = pg_result($result,11);
	
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
	$sql = " SELECT plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.truncado_per, curso.truncado_final,curso.fecha_inicio,curso.fecha_termino,grado_curso,ensenanza ";
	$sql.= " FROM (curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON ";
	$sql.= " curso.cod_eval = evaluacion.cod_eval WHERE (((curso.id_curso)=".$this->curso."));";
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$fila = @pg_fetch_array($result,0);
	$this->NombreDecreto = $fila['nombre_decreto'];
	$this->NombreDecretoEval = $fila['nombre_decreto_eval'];
	$this->truncado = $fila['truncado_per'];
	$this->truncado_final = $fila['truncado_final'];
	$this->finicio_curso = $fila['fecha_inicio'];
	$this->ftermino_curso = $fila['fecha_termino'];
	$this->grado_curso = $fila['grado_curso'];
	$this->ensenanza_curso = $fila['ensenanza'];
	return;
  }
  function ListadoCurso($conn){
	$sql= "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
	$sql.= "curso.ensenanza, curso.cod_decreto,fecha_inicio,fecha_termino ";
	$sql.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql.= "WHERE (((curso.id_ano)=".$this->ano.")";
	if($this->ensenanza!=0){
		$sql.=" AND ensenanza= ".$this->ensenanza."";
	}
	if($this->ensenanzam!=0){
		$sql.=" AND ensenanza> ".$this->ensenanzam."";
	}
	$sql.= " ) ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso ";


	$result = pg_exec($conn,$sql) or die ("Select fall�: ".$sql);
	return $result;
	}
	
	function ListadoCursoCiclo($conn){
		$sql="SELECT c.id_curso, c.grado_curso, c.letra_curso, te.nombre_tipo ";
		$sql.=" FROM curso c INNER JOIN ciclos cl ON c.id_curso=cl.id_curso and  c.id_ano=".$this->ano."";
		$sql.=" INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza ";
		$sql.=" WHERE id_ciclo=".$this->ciclo."";
		$sql.="  ORDER BY 4,2,3";
		$result = pg_exec($conn,$sql) or die ("Select fall�: ".$sql);
		return $result;
	}
	
	function ListadoCursoNivel($conn){
		$sql ="SELECT c.id_curso, c.grado_curso, c.letra_curso, te.nombre_tipo ";
		$sql.=" FROM curso c INNER JOIN niveles n ON c.id_nivel=n.id_nivel ";
		$sql.=" INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza ";
		$sql.=" WHERE c.id_ano=".$this->ano." AND n.id_nivel=".$this->nivel." ORDER BY 2,3";
		$result = pg_exec($conn,$sql) or die ("Select fall�: ".$sql);
		return $result;	
	}
	
	
	
	function ListadoSubsectores($conn){
		/*-$sql = "SELECT distinct RAMO.cod_subsector,nombre
FROM ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector WHERE id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$this->ano. " AND ensenanza=".$this->ensenanza.")";*/
	
/*	$sql="SELECT distinct RAMO.cod_subsector,nombre,os.orden 
FROM ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector 
INNER JOIN curso c ON c.id_curso=ramo.id_curso 
LEFT JOIN orden_subsector os ON ramo.cod_subsector=os.cod_subsector AND c.ensenanza=os.tipo_ensenanza 
WHERE c.id_ano=".$this->ano. " AND ensenanza=".$this->ensenanza."
ORDER BY os.orden ASC";*/

//echo $sql;
/*$sql="SELECT distinct RAMO.cod_subsector,nombre,os.orden 
FROM ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector 
INNER JOIN curso c ON c.id_curso=ramo.id_curso and c.id_ano=".$this->ano. " AND ensenanza=".$this->ensenanza."
LEFT JOIN orden_subsector os ON ramo.cod_subsector=os.cod_subsector AND c.ensenanza=os.tipo_ensenanza 
AND  os.id_ano=".$this->ano. " AND os.tipo_ensenanza=".$this->ensenanza."
ORDER BY os.orden ASC";*/

///// MODIFICACION 30-07-2013 POR ORDEN SUBSECTOR
$sql="SELECT distinct RAMO.cod_subsector,nombre,os.orden 
FROM ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector 
INNER JOIN curso c ON c.id_curso=ramo.id_curso and c.id_ano=".$this->ano. " AND ensenanza=".$this->ensenanza." 
LEFT JOIN orden_subsector os ON ramo.cod_subsector=os.cod_subsector AND c.ensenanza=os.tipo_ensenanza
and os.id_ano=".$this->ano. " AND os.tipo_ensenanza=".$this->ensenanza." 
ORDER BY os.orden ASC   ";
//echo $sql;

		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (listadosubsectores):".$sql);
		return $result;
		
	}
	
	
	function ListadoSubsectoresCiclo($conn){
		$sql="select distinct r.cod_subsector, s.nombre, os.orden
FROM ciclos cl 
INNER JOIN curso c ON cl.id_curso=c.id_curso
INNER JOIN ramo r ON r.id_curso=c.id_curso
INNER JOIN subsector s ON s.cod_subsector=r.cod_subsector
LEFT JOIN orden_subsector os ON os.cod_subsector=r.cod_subsector AND os.id_ano=".$this->ano."
WHERE id_ciclo=".$this->ciclo."
ORDER BY os.orden ASC";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (listadosubsectores):".$sql);
		return $result;
	}
	
	function ListadoSubsectoresNivel($conn){
		$sql ="SELECT distinct RAMO.cod_subsector,subsector.nombre,os.orden ";
		$sql.=" FROM ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector ";
		$sql.=" INNER JOIN curso c ON c.id_curso=ramo.id_curso and c.id_ano=".$this->ano ;
		$sql.=" INNER JOIN niveles n ON c.id_nivel=n.id_nivel AND n.id_nivel=".$this->nivel;
		$sql.=" LEFT JOIN orden_subsector os ON ramo.cod_subsector=os.cod_subsector ";
		$sql.=" AND c.ensenanza=os.tipo_ensenanza and os.id_ano=".$this->ano." ORDER BY os.orden ASC ";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (listadosubsectores):".$sql);
		return $result;
}

	function ListadoSubsectoresCicloSector($conn){
		$sql="select distinct r.cod_subsector, s.nombre, os.orden
				FROM ciclos cl 
				INNER JOIN curso c ON cl.id_curso=c.id_curso
				INNER JOIN ramo r ON r.id_curso=c.id_curso
				INNER JOIN subsector s ON s.cod_subsector=r.cod_subsector
				INNER JOIN relacion_subsector rs ON rs.cod_subsector=r.cod_subsector 
				INNER JOIN sector_rdb sr ON sr.id_sector=rs.id_sector AND rdb=".$this->rdb." AND sr.id_sector=".$this->sector."
				LEFT JOIN orden_subsector os ON os.cod_subsector=r.cod_subsector AND os.id_ano=".$this->ano."
				WHERE id_ciclo=".$this->ciclo."
				ORDER BY os.orden ASC";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (listadosubsectores):".$sql);
		return $result;
	}
	
	function ListadoSubsectoresNivelSector($conn){
		$sql="SELECT distinct r.cod_subsector,subsector.nombre,os.orden 
FROM ramo r inner join subsector on r.cod_subsector=subsector.cod_subsector 
INNER JOIN curso c ON c.id_curso=r.id_curso and c.id_ano=".$this->ano." 
INNER JOIN niveles n ON c.id_nivel=n.id_nivel AND n.id_nivel=".$this->nivel."
INNER JOIN relacion_subsector rs ON rs.cod_subsector=r.cod_subsector 
INNER JOIN sector_rdb sr ON sr.id_sector=rs.id_sector AND rdb=".$this->rdb." AND sr.id_sector=".$this->sector."
LEFT JOIN orden_subsector os ON r.cod_subsector=os.cod_subsector 
AND c.ensenanza=os.tipo_ensenanza and os.id_ano=".$this->ano."
ORDER BY os.orden ASC ";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (listadosubsectores):".$sql);
		return $result;

	}
	
	function ListadoSubsectoresEnsenanzaSector($conn){
		$sql="SELECT distinct r.cod_subsector,nombre
FROM ramo r
inner join subsector on r.cod_subsector=subsector.cod_subsector 
INNER JOIN curso c ON c.id_curso=r.id_curso AND c.id_ano=".$this->ano." 
INNER JOIN relacion_subsector rs ON rs.cod_subsector=r.cod_subsector 
INNER JOIN sector_rdb sr ON sr.id_sector=rs.id_sector AND rdb=".$this->rdb." AND sr.id_sector=".$this->sector."
ORDER BY nombre ASC ";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (listadosubsectores):".$sql);
		return $result;
	}
	function PromedioCurso($conn){
		if($this->promocion==1){
			$tabla="promedio_sub_alumno";
		}else{
			$tabla = "notas$this->nro_ano";	
		}
		$sql = " SELECT (sum(CAST(promedio as integer)) / count(*)) AS promedio FROM $tabla WHERE ";
		if($this->promocion!=1){
			$sql.="id_periodo=".$this->periodo." AND";
		}
		
		$sql.= "  id_ramo IN (SELECT id_ramo FROM ramo WHERE ramo.id_curso=".$this->curso." AND ramo.cod_subsector=".$this->subsector.") and promedio>'0' and promedio not in ('MB','B','S','I','L','EP','AL','NL')";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (promedio curso):".$sql);
		$this->promedio = @pg_result($result,0);
		return;
	}
	
	function PromediosSubsectores($conn){
		$sql="  SELECT avg(cast(promedio as INTEGER)) as prom ";
 		$sql.="FROM notas".$this->nro_ano." nt INNER JOIN ramo r ON nt.id_ramo=r.id_ramo ";
		if($this->codigo!=0){
			$sql.="	and cod_subsector in (".$this->codigo.")";
		}
		$sql.=" INNER JOIN curso c ON c.id_curso=r.id_curso ";
		$sql.=" WHERE c.id_curso=".$this->curso."  and id_periodo=".$this->periodo." AND promedio not in ('MB','B','S','I',' ','0')";
 		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (PromediosSubsectores):".$sql);
		return $result;
	}
	function MatriculaCurso($conn){
		$sql ="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, ";
		$sql.=" curso.cod_sector,curso.cod_rama,matricula.enfermedad FROM matricula, curso WHERE matricula.rut_alumno='".$this->alumno."' and matricula.id_ano=".$this->ano." and  ";
		$sql.="matricula.id_curso=curso.id_curso and bool_ar=0";
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
		$sql="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$this->ensenanza." AND $this->grado=1 and activa=1 AND rdb=".$this->institucion." and tipo = ".$this->tipop;
		//if($_PERFIL==0) echo $sql;
		$result=@pg_exec($conn,$sql) ;
		return $result;
	}
	function InformeAreas($conn){
		if($this->nuevo==1){
			 $sql="select * from informe_area_item where id_plantilla=".$this->plantilla." and id_padre=0 order by id";
		}else{
			 $sql="SELECT * FROM informe_area WHERE id_plantilla=".$this->plantilla."";
		}
		
		//if($_PERFIL==0) echo $sql;
		
		$result =pg_exec($conn,$sql) or die ("SELECT FALLO (InformeArea):".$sql);
		return $result;
	}
	function InformeSubarea($conn){
		if($this->nuevo==1){
		$sql="SELECT * FROM informe_area_item WHERE id_plantilla=".$this->plantilla." AND id_padre<>0 AND id_padre=".$this->id_padre." ORDER BY id, id_padre ASC";
		}else{
			$sql="SELECT * FROM informe_subarea WHERE id_area=".$this->id_area;
		}
		//echo $sql;
		
		$result =pg_exec($conn,$sql) or die ("SELECT FALLO (InformeSubArea):".$sql);
		return $result;

	}
	function InformeItem($conn){
		if($this->nuevo==1){
			
			if(($this->plantilla==1693 || $this->plantilla==1694) && ($this->id_padre==90741 || $this->id_padre==90864 || $this->id_padre==90835)){
				$ors = "orden";
			}else{
				$ors = "id";
			}
						
			
			$sql="SELECT * FROM informe_area_item WHERE id_plantilla=".$this->plantilla." AND id_padre<>0 AND id_padre=".$this->id_padre." ORDER BY $ors ASC";
		}else{
			$sql="SELECT * FROM informe_item WHERE id_subarea=".$this->id_subarea." ORDER BY id_item ASC";													
		}
		//echo $sql;
		
		$result =pg_exec($conn,$sql) or die ("SELECT FALLO (InformeItem):".$sql);
		return $result;
	}
	function InformeConcepto($conn){
		//echo $institucion;
		if($this->nuevo==1){
		    if ($_INSTIT==2278){   // no entra ni cagando por que la variable viene vac�a.....
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
		
		//if($_PERFIL==0) echo "<br>".$sql;
			
		$result =pg_exec($conn,$sql);
		return $result;
	}
	function InformeEvaluacion($conn){
		$sql ="SELECT * FROM informe_concepto_eval WHERE id_concepto=".$this->respuesta."";
		$result=pg_exec($conn,$sql);
		return $result;
	}
	
	function InformeConceptoEvalInforme($conn){
		$sql ="SELECT * FROM informe_concepto_eval WHERE id_plantilla=".$this->plantilla." AND tipo_eval is null ORDER BY orden ASC";
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
	function InformeFinal($conn){
		 $sql= "SELECT nombre, sigla FROM informe_concepto_eval WHERE id_concepto=(select id_concepto FROM informe_cuadro_eval inf_cua WHERE nota_minima<=(SELECT avg(ice.nota) FROM informe_evaluacion2 ie INNER JOIN informe_concepto_eval ice ON ice.id_concepto=cast(ie.respuesta as integer)
WHERE id_ano=".$this->ano." AND ie.id_plantilla=".$this->plantilla." AND ie.id_informe_area_item=".$this->id_item." AND rut_alumno='".$this->alumno."') and
nota_maxima>=(SELECT avg(ice.nota) FROM informe_evaluacion2 ie INNER JOIN informe_concepto_eval ice ON ice.id_concepto=cast(ie.respuesta as integer)
WHERE id_ano=".$this->ano." AND ie.id_plantilla=".$this->plantilla." AND ie.id_informe_area_item=".$this->id_item." AND rut_alumno='".$this->alumno."') AND 
inf_cua.id_plantilla=".$this->plantilla.")";
		$result =pg_exec($conn,$sql);
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
//if($_PERFIL==0) echo "<br>".$sql;		
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
	
	
	function AsistenciaCursoDIA($conn){
		 $sql="SELECT count(*) as cont FROM asistencia WHERE  fecha ='".$this->fechaf."' and id_curso=".$this->id_cursof;
		$result = @pg_exec($conn,$sql);
		
		$this->cont_ina = pg_result($result,0);
		return;
		
		
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
	  if($this->nro_ano!="" && $this->mes!=""){
			$sql.=" AND date_part('month',fecha)=".$this->mes." AND date_part('year',fecha)=".$this->nro_ano;  
	  }
	 // echo "<br>".$sql;
	  $result_asis = pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
	  return $result_asis;
	 }
	 
	 
	 function TotalAsistenciaMensual($conn){
	 	$sql = "select count(*), fecha from asistencia where ano=".$this->id_ano." and id_curso=".$this->id_curso." ";
	 	$sql.="and date_part('month',fecha)=".$this->mes." group by fecha order by fecha asc";
	 	$result_asis = pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
	    return $result_asis;
	 }
	 
	
	 function MatriculaAsistencia($conn){
	  $sql = "SELECT count(*) FROM matricula WHERE id_ano=".$this->ano." AND fecha<'".$this->fecha_fin."'";
	  $result = @pg_exec($conn,$sql) or die ("SELECT FALL� (matricula asistencia):".$sql);
	  return $result;

	 }
	 function MatriculaCiclos($conn){
	 	$sql="SELECT count(*), id_ciclo FROM matricula a INNER JOIN ciclos b ON (a.id_ano=b.id_ano AND  a.id_curso=b.id_curso)
WHERE a.id_ano=".$this->ano." GROUP BY id_ciclo";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (matricula Ciclos):".$sql);
		return $result;
	 }
	 function MatriculaNiveles($conn){
	 	$sql ="SELECT count(*) as cuenta, id_nivel FROM matricula a INNER JOIN curso b ON b.id_ano=a.id_ano AND a.id_curso=b.id_curso ";
		$sql.="WHERE a.id_ano=".$this->ano." GROUP BY id_nivel";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (matricula Ciclos):".$sql);
		return $result;
	 }
		
	 function MatriculaAsistencia_curso($conn){
	  $sql = "SELECT count(*) FROM matricula 
	  WHERE id_ano=".$this->ano." AND fecha<'".$this->fecha_fin."' ";
	  $sql.="and id_curso=".$this->id_curso." AND bool_ar=0";
	  $result = @pg_exec($conn,$sql) or die ("SELECT FALL� (matricula asistencia curso):".$sql);
	  return $result;
	}	
	
	
	
	
	
	
	 function TotalAsistenciaMensualHombres($conn){
		$sql = "select count(*), fecha from asistencia where ano=".$this->ano." and id_curso=".$this->id_curso." ";
		$sql.="and date_part('month',fecha)=".$this->mes."
		and rut_alumno in (select SELECT rut_alumno FROM matricula
		inner join alumno on matricula.rut_alumno=alumno.rut_alumno
		WHERE id_ano=".$this->ano." AND fecha<'".$this->fecha_fin."' ";
		$sql.="and id_curso=".$this->id_curso." AND bool_ar=0 AND alumno.sexo=2)
		group by fecha order by fecha asc";
		
		//echo $sql;
		
		$result_asis = pg_exec($conn,$sql) or die ("SELECT FALL�:".$sql);
	    return $result_asis;
	 }	
	
	function MatriculaAsistencia_curso_hobres($conn){
	  $sql = "SELECT count(matricula.*) FROM matricula
	  inner join alumno on matricula.rut_alumno=alumno.rut_alumno
	  WHERE id_ano=".$this->ano." AND fecha<='".$this->fecha_fin."' ";
	  $sql.="and id_curso=".$this->id_curso." AND alumno.sexo=2";
		  
	  $result = @pg_exec($conn,$sql) or die ("SELECT FALL� (matricula asistencia Hombres):".$sql);
	  return $result;
	}
	
	function MatriculaAsistencia_curso_hobres_mesActual($conn){
	  $sql = "SELECT count(matricula.*) FROM matricula
	  inner join alumno on matricula.rut_alumno=alumno.rut_alumno
	  WHERE id_ano=".$this->ano." AND fecha<'".$this->fecha_termino."' ";
	  $sql.="and id_curso=".$this->id_curso." AND bool_ar=0 AND alumno.sexo=2";
	  
	  
		  
	  $result = @pg_exec($conn,$sql) or die ("SELECT FALL� (matricula asistencia Hombres):".$sql);
	  return $result;
	}
	
	
	function MatriculaAsistencia_curso_mujeres($conn){/* */
	  $sql = "SELECT count(matricula.*) FROM matricula
	  inner join alumno on matricula.rut_alumno=alumno.rut_alumno
	  WHERE id_ano=".$this->ano." AND fecha<='".$this->fecha_fin."' ";
	  $sql.="and id_curso=".$this->id_curso."  AND alumno.sexo=1";
	 // echo $sql;
	  $result = @pg_exec($conn,$sql) or die ("SELECT FALL� (matricula asistencia Mujeres):".$sql);
	  return $result;
	}
	
	function MatriculaAltas_mes_hombres($conn){
		$sql ="SELECT count(matricula.*) FROM matricula 
		 inner join alumno on matricula.rut_alumno=alumno.rut_alumno
		WHERE id_ano=".$this->ano." AND id_curso=".$this->id_curso."  AND fecha between '".$this->fecha_inicio."' ";
		$sql.="AND '".$this->fecha_termino."' and alumno.sexo=1";
		
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALL� (MatriculaAltas_mes_hombres):".$sql);
		return $result;
	}
	
	
	function MatriculaAltas_mes_mujeres($conn){
		$sql ="SELECT count(matricula.*) FROM matricula 
		 inner join alumno on matricula.rut_alumno=alumno.rut_alumno
		WHERE id_ano=".$this->ano." AND id_curso=".$this->id_curso."  AND fecha between '".$this->fecha_inicio."' ";
		$sql.="AND '".$this->fecha_termino."' and alumno.sexo=2";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALL� (MatriculaAltas_mes_mujeres):".$sql);
		return $result;
	}
	
	
	function MatriculaBajas_mes_hombres($conn){
		$sql ="SELECT count(matricula.*) FROM matricula 
		 inner join alumno on matricula.rut_alumno=alumno.rut_alumno
		WHERE id_ano=".$this->ano." AND id_curso=".$this->id_curso." AND bool_ar=1 AND matricula.fecha_retiro between '".$this->fecha_inicio."' ";
		$sql.=" AND '".$this->fecha_termino."' and alumno.sexo=1";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALL� (MatriculaBajas_mes_hombres):".$sql);
		return $result;
	}
	
	function MatriculaBajas_mes_mujeres($conn){
		$sql ="SELECT count(matricula.*) FROM matricula 
		 inner join alumno on matricula.rut_alumno=alumno.rut_alumno
		WHERE id_ano=".$this->ano." AND id_curso=".$this->id_curso." AND bool_ar=1 AND matricula.fecha_retiro between '".$this->fecha_inicio."' ";
		$sql.=" AND '".$this->fecha_termino."' and alumno.sexo=2";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALL� (MatriculaBajas_mes_mujeres):".$sql);
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
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (Matriculados):".$sql);
	 	return $result;
	}	*/
	
	function Matriculados($conn){
		$sql = "Select count(*) FROM matricula WHERE id_ano=".$this->id_ano." AND id_curso=".$this->id_curso;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (Matriculados):".$sql);
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
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (MatriculaMes2):".$sql);
		return $result;
	}
	function DocenteProyecto($conn){
		$sql =" SELECT b.nombre_emp || CAST(' ' as varchar) || b.ape_pat || cast('  ' as varchar) || b.ape_mat as nombre,c.hrs_contrato,c.total_aula,d.nombre as ";
		$sql.=" titulo,b.tipo_titulo FROM proyecto_grupo a INNER JOIN empleado b ON a.rut_emp=b.rut_emp  INNER JOIN dotacion_docente c ON ";
		$sql.=" (c.rdb=a.rdb AND c.rut_emp=a.rut_emp AND c.rut_emp=b.rut_emp) INNER JOIN empleado_estudios d ON a.rut_emp=cast(d.rut_empleado as Integer) AND ";
		$sql.=" b.rut_emp=cast(d.rut_empleado as Integer) AND c.rut_emp=cast(d.rut_empleado as Integer) where a.rdb=".$this->rdb." AND c.id_ano=".$this->ano." AND id_proy=".$this->id_pro."";
		$sql.=" AND d.tipo=1 ";
		//if($_PERFIL==0) echo $sql;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (DocenteProyecto):".$sql);
		return $result;
	}
	function AlumnoProyecto($conn){
		$sql ="SELECT b.nombre_alu || cast(' ' as varchar) || ape_pat || cast(' '  as VARCHAR) || ape_mat as nombres, b.fecha_nac, a.institucion,c.nombre ";
		$sql.=" ,a.obs,d.id_curso FROM alumno_proyecto a INNER JOIN alumno b ON a.rut_alumno=b.rut_alumno INNER JOIN diagnostico c ON a.id_dignos=c.id_dignos ";
		$sql.=" INNER JOIN Matricula d ON a.id_ano=d.id_ano AND a.rut_alumno=d.rut_alumno WHERE a.rdb=".$this->rdb." AND a.id_ano=".$this->ano." AND ";
		$sql.=" id_proy=".$this->id_pro."";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (AlumnoProyecto):".$sql);
		return $result;
	}
	function Diagnostico($conn){
		$sql = "SELECT id_dignos,nombre FROM diagnostico WHERE id_dignos=".$this->id_dignos;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (Diagnostico):".$sql);
		return $result;
	}
	function AlumnoDiagnostico($conn){
		$sql = "SELECT b.nombre_alu || cast(' ' as varchar) || ape_pat || cast(' '  as VARCHAR) || ape_mat as nombres, b.fecha_nac, a.institucion,c.nombre, ";
		$sql.= " a.obs,d.id_curso,c.nombre as dignos FROM alumno_proyecto a INNER JOIN alumno b ON a.rut_alumno=b.rut_alumno INNER JOIN diagnostico c ON "; 
		$sql.= " a.id_dignos=c.id_dignos INNER JOIN Matricula d ON a.id_ano=d.id_ano AND a.rut_alumno=d.rut_alumno WHERE a.rdb=".$this->rdb." ";
		$sql.= " AND a.id_ano=".$this->ano." AND id_proy=".$this->id_pro." AND a.id_dignos=".$this->id_dignos;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (AlumnoDiagnostico):".$sql);
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
		if($this->tense){$cc="and curso.ensenanza>".$this->tense;}
		
		$sql_curso="select * from curso where id_ano=".$this->ano." $cc order by ensenanza, grado_curso,letra_curso";
		$result_cursos =@pg_exec($conn,$sql_curso)or die ("SELECT FALLO (NomCurso):".$sql_curso);
		//echo "sql_curso=$sql_curso<br>";
		return $result_cursos;
		
	}
	function DotacionDocente($conn){
		$sql="SELECT a.rut_emp,b.dig_rut ,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' ' as varchar) || ape_mat as nombre, hrs_contrato, amp_jec, a.amp_simple,a.amp_simple,a.art_69,a.cargo_asig,a.hrs_excedente,a.obs,a.tipo_emp,a.tipo_func,a.total_aula FROM dotacion_docente a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$this->rdb." AND id_ano=".$this->ano."AND cargo=".$this->cargo;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (DotacionDocente):".$sql);
		return $result;
	}
	function DotacionDirectivo($conn){
		$sql="SELECT a.rut_emp,b.dig_rut ,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' ' as varchar) || ape_mat as nombre, hrs_contrato, amp_jec, a.amp_simple,a.amp_simple,a.art_69,a.cargo_asig,a.hrs_excedente,a.obs,a.tipo_emp,a.tipo_func,a.total_aula FROM dotacion_docente a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$this->rdb." AND id_ano=".$this->ano."AND cargo in ".$this->cargo."";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (DotacionDocente):".$sql);
		return $result;
	}
	function DotacionTecnico($conn){
		$sql="SELECT a.rut_emp,b.dig_rut ,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' ' as varchar) || ape_mat as nombre, hrs_contrato, amp_jec, a.amp_simple,a.amp_simple,a.art_69,a.cargo_asig,a.hrs_excedente,a.obs,a.tipo_emp,a.tipo_func,a.total_aula FROM dotacion_docente a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$this->rdb." AND id_ano=".$this->ano."AND cargo not in ".$this->cargo."";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (DotacionDocente):".$sql);
		return $result;
	}
	
	function alu_socioeconomico($conn){
	$sql="select * from alumno_socioeconomico where rut_alumno=".$this->alumno;
	$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (DotacionDocente):".$sql);
	return $result;
	
	}
	
	
	function NotaExamenfinal($conn){
		
		
	 $sql = "SELECT * FROM examen_semestral WHERE id_curso=".$this->curso." AND id_ramo=".$this->ramo;	
	 
	         $resultc =pg_Exec($conn,$sql);
			 $filac = pg_fetch_array($resultc,$sql);
			 $id_examen= $filac['id_examen'];	
	 
		
	$sql2 = "SELECT nota FROM notas_examen WHERE id_examen=".$id_examen." AND id_curso=".$this->curso." AND id_ano=".$this->ano." AND periodo=".$this->periodo." AND id_ramo=".$this->ramo." AND rut_alumno=".$this->rut_alumno;
		
		$result_conn =pg_Exec($conn,$sql2);
	return $result_conn; 
		
	}
	
	
	
	function notaexamen($conn){
		
			$qsl="select * from ramo where id_ramo=".$this->ramo;
			$resultc =pg_Exec($conn,$qsl);
			$filac = pg_fetch_array($resultc,$qsl);
			 $conexper= $filac['conexper'];	
		
 $sql="SELECT subsector.nombre,ramo.id_ramo,ramo.conexper,
sp.id_periodo,
sp.rut_alumno,
sp.nota_final,
sp.nota_examen,
sp.prom_gral,
sp.id_ramo
FROM ramo 
INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector
LEFT outer JOIN situacion_periodo as sp on ramo.id_ramo = sp.id_ramo WHERE ramo.id_curso=".$this->curso." and sp.rut_alumno= ".$this->rut_alumno." and sp.id_periodo = ".$this->periodo." and ramo.conexper=1 and ramo.id_ramo=".$this->ramo." ORDER BY ramo.id_orden";	
	
	/*if($_PERFIL==0){
		echo $sql;}*/
	
	$result_con =pg_Exec($conn,$sql)or die("Fallo Exx: ".$sql);
	return $result_con; 
			
	}
	
	function Ramo($conn){
		$sql = "SELECT id_ramo,nombre, a.id_curso FROM ramo a INNER JOIN curso b ON a.id_curso=b.id_curso INNER JOIN subsector c ON ";
		$sql.= "a.cod_subsector=c.cod_subsector WHERE id_ano=".$this->ano." ORDER BY b.ensenanza,b.grado_curso ASC ";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALL� (Ramo):".$sql);
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
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALL� (AlumnoEximido999):".$sql);
		return $result;
	}
	function CantidadCurso($conn){
		$sql ="select count(*), grado_curso FROM curso WHERE id_ano=".$this->ano." AND ensenanza=".$this->ensenanza." GROUP BY grado_curso ORDER BY grado_curso ASC";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALL� (CantidadCurso):".$sql);
		return $result;
	}	
	
	
	
	
	function MatriculaInicial($conn){
		$sql =" SELECT count(*) FROM matricula WHERE id_ano=".$this->ano." AND id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$this->ano." ";
		$sql.=" AND ensenanza=".$this->ensenanza." AND grado_curso=".$this->grado.")  AND ";
		$sql.=" date_part('month',matricula.fecha)<=".$this->mes." AND date_part('year',fecha)=".$this->nro_ano."";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALL� (MatriculaInicial):".$sql);
		return $result;
	}
	
	
	
	
	function MatriculaAltas($conn){
		$sql ="SELECT count(*) FROM matricula WHERE id_ano=".$this->ano." AND id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$this->ano." AND ";
		$sql.="ensenanza=".$this->ensenanza." AND grado_curso=".$this->grado.") AND bool_ar=".$this->retirado." AND fecha between '".$this->fecha_inicio."' ";
		$sql.="AND '".$this->fecha_final."'";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALL� (MatriculaAltas):".$sql);
		return $result;
	}
	
	
	function MatriculaBajas($conn){
		$sql ="SELECT count(*) FROM matricula WHERE id_ano=".$this->ano." AND id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$this->ano." AND ";
		$sql.=" ensenanza=".$this->ensenanza." AND grado_curso=".$this->grado.") AND bool_ar=".$this->baja." AND fecha_retiro between '".$this->fecha_inicio."' ";
		$sql.=" AND '".$this->fecha_final."'";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALL� (MatriculaAltas):".$sql);
		return $result;
	}
	function MatriculaDia($conn){
		$sql ="SELECT count(*) FROM matricula WHERE id_ano=".$this->ano." AND id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$this->ano." AND ";
		$sql.="ensenanza=".$this->ensenanza." AND grado_curso=".$this->grado.")  AND fecha<='".$this->fecha_dia."'";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALL� (MatriculaDia):".$sql);
		return $result;
	}
	function AsistenciaDia($conn){
		$sql ="SELECT count(*) FROM asistencia WHERE ano=".$this->ano." AND rut_alumno in (SELECT rut_alumno FROM matricula WHERE id_ano=".$this->ano." AND id_curso in (SELECT id_curso  FROM curso WHERE id_ano=".$this->ano." AND ensenanza=".$this->ensenanza." AND grado_curso=".$this->grado.") AND bool_ar=0) and asistencia.fecha='".$this->fecha_dia."'";
		$result  = @pg_exec($conn,$sql) or die ("SELECT FALL� (AsistenciaDia):".$sql);
		return $result;
	}
	function EstadoPractica($conn){
		$sql ="SELECT cod_estado, nombre_estado FROM estado_practica WHERE cod_estado=".$this->cod_estado;
		$result = @pg_exec($conn,$sql) or die("SELECT FALL� (EstadoPractica):".$sql);
		return $result;
	}
	function RamoCurso($conn){
		$sql = "SELECT id_ramo,a.id_curso,nombre FROM ramo a INNER JOIN curso b ON a.id_curso=b.id_curso  INNER JOIN subsector c ON ";
		$sql.=" a.cod_subsector=c.cod_subsector WHERE id_ano=".$this->ano." and a.cod_subsector in (".$this->cod_subsector.") ";
		if($this->curso!=1){
			$sql.=" AND b.id_curso=".$this->curso."";
		}
		$result = @pg_exec($conn,$sql) or die("SELECT FALL� (RamoCurso):".$sql);
		return $result;
	}
	function Especialidad($conn){
		$sql = "SELECT nombre_esp FROM especialidad WHERE cod_esp=".$this->especialidad;
		$result = @pg_exec($conn,$sql) or die("SELECT FALL� (Especialidad):".$sql);
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
	 
	 function AtrasosAsistencia($conn){
	 	$sql="select * from anotacion where rut_alumno=".$this->rut_alumno." and anotacion.fecha>='".$this->fecha1."' AND fecha<='".$this->fecha2."' and anotacion.tipo=".$this->tipo;
		$rs_atrasos = @pg_exec($conn,$sql) or die("SELECT FALLO:".$sql);
		return $rs_atrasos;
	}
	
	
	function fecha_actual()  
{  
    $week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");  
    $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");  
    $year_now = date ("Y");  
    $month_now = date ("n");  
    $day_now = date ("j");  
    $week_day_now = date ("w");  
    $date = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now;   
    return $date;    
}  

	function PromedioCiclo($conn){
		$sql ="SELECT cu.id_curso,cu.grado_curso ||'-'||cu.letra_curso ||' '|| te.nombre_tipo as cursos,avg(CAST(nt.promedio as integer))as prom 
FROM ciclos c INNER JOIN curso cu ON c.id_curso=cu.id_curso 
INNER JOIN tipo_ensenanza te ON te.cod_tipo=cu.ensenanza 
INNER JOIN ramo r ON r.id_curso=cu.id_curso 
INNER JOIN notas$this->nro_ano nt ON nt.id_ramo=r.id_ramo and r.cod_subsector=".$this->ramo." 
 WHERE id_ciclo=".$this->ciclo." and nt.promedio not in ('0','MB','B','S','I',' ','x','P','AL','L','NL','EP') ";
 	if($this->periodo!="" and $this->curso!=""){
		$sql.=" AND nt.id_periodo=".$this->periodo." AND cu.id_curso=".$this->curso." ";
	}
 		$sql.=" group by cursos, cu.id_curso ORDER BY cursos ASC 	";
		//echo $sql;
 	$result =pg_exec($conn,$sql);
	return $result;
	}
	
	function SubsectorNivel($conn){
		$sql=" SELECT distinct s.nombre,r.id_orden, s.cod_subsector
 FROM curso c INNER JOIN ramo r ON c.id_curso=r.id_curso
 INNER JOIN subsector s ON s.cod_subsector=r.cod_subsector
 WHERE c.id_ano=".$this->ano." AND c.id_nivel=".$this->nivel." 
 ORDER BY r.id_orden ASC";
 		$result = pg_Exec($conn,$sql);
		return $result;
			
	}
	
	function sistema_salud($conn)
	{
		$sql="select * from sistema_salud where id_sistema_salud=".$this->id_sistema_salud."";
		$result = pg_Exec($conn,$sql);
		return $result;
	}
	
	
	function alumno_apo($conn)
	{
		 $sql="select * from  alumno
			  inner join tiene2 on alumno.rut_alumno = tiene2.rut_alumno	
			  INNER JOIN matricula m ON m.rut_alumno=alumno.rut_alumno AND id_curso=".$this->curso." 	
		 where rut_apo = ".$this->rut_apo."";	
		$result = pg_Exec($conn,$sql);
		return $result;
	} 
	
	
	function Notas_ano($conn){
	
	$sql="select * from notas".$this->nro_ano." n where n.id_ramo=".$this->ramo." and n.rut_alumno=".$this->rut_alumno." and id_periodo=".$this->periodo."";
	$result = pg_Exec($conn,$sql);
	 return $result;
   }
   
   function PromedioRamoAlumno($conn,$nro_ano,$alumno,$id_ramo)
   {
	  $sql="select sum(cast (promedio as integer)) from notas$nro_ano n where n.rut_alumno=$alumno and n.id_ramo=$id_ramo 
	  AND  promedio>'0' AND promedio not in ('MB','B','S','I','EX')";
	
	  $result = pg_Exec($conn,$sql)or die("f".$sql);
	  return $result;
	  	   
   }
   
      function PromedioRamoAlumnoDetalle($conn,$nro_ano,$alumno,$id_ramo)
   {
	 $sql="select promedio,notaap from notas$nro_ano n where n.rut_alumno=$alumno and n.id_ramo=$id_ramo 
	  AND  promedio>'0' AND promedio not in ('MB','B','S','I','EX')";
	
	  $result = pg_Exec($conn,$sql)or die("f".$sql);
	  return $result;
	  	   
   }
   
   
    function PromedioRamoAlumnoPeriodo($conn)
   {
	  $sql="select promedio from notas".$this->nro_ano." n where n.rut_alumno=".$this->alumno." and n.id_ramo=".$this->id_ramo." and  n.id_periodo=".$this->periodo." and promedio is not null and promedio!='0' ";
	
	  $result = pg_Exec($conn,$sql)or die("f".$sql);
	  return $result;
	  	   
   }
   
	function DiaHabil2($conn){
		   $sql ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$this->ano."  AND feriado.fecha_inicio>='".$this->fecha_ini2."' AND feriado.fecha_fin<='".$this->fecha2."';";
		   $result = @pg_exec($conn,$sql) or die ("SELECT FALL�: habil2".$sql);
		  // if($_PERFIL==0) echo $sql."<br>";
		   return $result;
	  
    }
	
	function DiaHabil3($conn){
		   $sql ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$this->ano."  AND (feriado.fecha_inicio>='".$this->fecha_ini2."' and feriado.fecha_fin<='".$this->fecha2."');";
		   $result = @pg_exec($conn,$sql) or die ("SELECT FALL�: -habil2".$sql);
		   //if($_PERFIL==0) echo $sql."<br>";
		   return $result;
	  
    }
	
		function DiaHabil4($conn){
		if($this->cursoa!=""){
			 $sql_fercur ="select * from feriado_curso where id_curso=".$this->cursoa;
			$rs_fercur = pg_exec($conn,$sql_fercur);
			
			if(pg_numrows($rs_fercur)>0){
				
				  $sql ="SELECT fecha_inicio,fecha_fin FROM feriado feriado inner join feriado_curso on feriado_curso.id_feriado=feriado.id_feriado WHERE id_ano=".$this->ano." and id_curso =".$this->cursoa." AND (feriado.fecha_inicio>='".$this->fecha_ini2."' and feriado.fecha_fin<='".$this->fecha2."') order by fecha_inicio;";
			}else{
				 $sql ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$this->ano."  AND feriado.fecha_inicio>='".$this->fecha_ini2."' AND feriado.fecha_fin<='".$this->fecha2."';";
			}
			
		}else{
		
		   $sql ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$this->ano."  AND feriado.fecha_inicio>='".$this->fecha_ini2."' AND feriado.fecha_fin<='".$this->fecha2."';";
		 
		} 
		 $result = @pg_exec($conn,$sql) or die ("SELECT FALL�: habil2".$sql);
		 //  if($_PERFIL==0) echo $sql."<br>";
		   return $result;
	  
    }
	
	function AnoInstitucionCerrado($conn){
		$sql="SELECT nro_ano,id_ano FROM ano_EScolar where id_institucion=".$this->rdb." AND situacion=0 ORDER BY nro_ano ASC";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		// if($_PERFIL==0) echo $sql."<br>";
		 return $result;	
	}
	
	function AnoInstitucion($conn){
		$sql="SELECT nro_ano,id_ano FROM ano_escolar WHERE id_institucion=".$this->rdb." ORDER BY nro_ano ASC";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		return $result;
	}
		
		function AnoInstitucionHasta($conn){
		$sql="SELECT nro_ano,id_ano FROM ano_escolar WHERE id_institucion=".$this->rdb." and nro_ano <=".$this->nroano." ORDER BY nro_ano ASC";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		return $result;
	}
	
	function PromedioSubsectorAno($conn){
		$sql="SELECT avg(cast(promedio as INTEGER)) FROM promedio_sub_alumno psa INNER JOIN ramo r ON psa.id_ramo=r.id_ramo
INNER JOIN curso c ON c.id_curso=r.id_curso AND psa.id_curso=c.id_curso AND c.id_ano=".$this->ano." WHERE cod_subsector=".$this->subsector." and ensenanza=".$this->ensenanza." AND grado_curso=".$this->grado_curso." AND letra_curso='".trim($this->letra_curso)."' AND promedio NOT IN ('MB','B','S','I','0',' ','P','AL','L','NL','G','RV','N','-','EX')";
$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		  //if($_PERFIL==0) echo $sql."<br>";
		 return $result;	
	}
	function TraeAccidenteReporte($conn){
		$sql="SELECT * FROM declaracion_accidente WHERE id_curso=".$this->curso." AND  rut_alumno=".$this->rut_alumno." AND fecha='".$this->fecha_accidente."'";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		   //if($_PERFIL==0) echo $sql."<br>";
		 return $result;	
	}

	function TraeSoloJornada($conn){
		$sql="SELECT bool_jor FROM curso WHERE id_curso=".$this->curso;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		   //if($_PERFIL==0) echo $sql."<br>";
		 return $result;		
	}
	
	function JustificaAsistenciaConteo($conn){
		$sql="SELECT count(*) FROM justifica_inasistencia WHERE rut_alumno=".$this->alumno." AND ano=".$this->ano." AND fecha>='".$this->fecha1."' AND fecha<='".$this->fecha2."'";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		   //if($_PERFIL==0) echo $sql."<br>";
		 return $result;		
	}
	function JustificaAsistenciaConteoconcurso($conn){
		$sql="SELECT count(*) FROM justifica_inasistencia WHERE rut_alumno=".$this->alumno." AND ano=".$this->ano." and id_curso=".$this->curso." AND fecha between '".$this->fecha1."' AND '".$this->fecha2."'";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		   //if($_PERFIL==0) echo $sql."<br>";
		 return $result;		
	}
	
	function fechaMatrAsis($conn){
		$sql="SELECT fecha FROM matricula WHERE rut_alumno=".$this->alumno." AND id_curso=".$this->curso;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		$fecha_matr = pg_Result($result,0);
		return  ;	
	}
	
	
	function sistemasalud($conn){
		$sql="SELECT sistema_salud FROM sistema_salud WHERE id_sistema_salud=".$this->sistema;
		$result = @pg_exec($conn,$sql) /*or die ("SELECT FALL�: x".$sql)*/;
		
		return $result ;	
	}
	
	
	function hermanos($conn){
	 $sql = "select nombre_hermano,ape_pat,ape_mat, id_curso from hermanos where rut_alumno=".$this->alumno." and id_ano=".$this->ano." order by ape_pat,ape_mat,nombre_hermano "; 	
	$result = @pg_exec($conn,$sql) /*or die ("SELECT FALL�: x".$sql)*/;
		
		return $result ;
	}
	
	
	function promFinalOrden($conn){
	
	$ord = ($this->orden==1)?"desc":"asc";
	
	if($this->finalp==1){
		$sql="select upper(al.ape_pat||' '||al.ape_mat||', '||al.nombre_alu) as nombre_alumno, pr.promedio from alumno al
left join promocion pr on al.rut_alumno = pr.rut_alumno left join matricula mt on mt.rut_alumno = pr.rut_alumno where pr.id_curso = ".$this->curso." and mt.bool_ar = ".$this->retirado." group by al.ape_pat,al.ape_mat,al.nombre_alu,pr.promedio
order by pr.promedio $ord";

		}		
		//echo $sql;
		$result = @pg_exec($conn,$sql) /*or die ("SELECT FALL�: x".$sql)*/;
		
		return $result ;
	}
	
	function EnfermeriaPatologia($conn){
		 $sql="select enfermeria.id_curso, enfermeria.fecha,enfermeria.hora_ingreso,enfermeria.hora_egreso,enfermeria.destino, upper(alumno.ape_pat||' '||alumno.ape_mat||', '|| alumno.nombre_alu) as nombre_alumno,alumno.ape_pat from enfermeria inner join alumno on enfermeria.rut_alumno = alumno.rut_alumno where enfermeria.id_ano=".$this->ano." and enfermeria.patologia=".$this->patologia." and enfermeria.fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."' order by alumno.ape_pat asc";
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
		
	}
	
	
	function Patologia($conn){
		 $sql=" select * from enfermeria_patologia where id_patologia=".$this->patologia;
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
		
	}
	
	function EstadisticaenfermeriaPatologia($conn){
	$sql="select count(*) as cuenta,(select count(*)  from enfermeria
where enfermeria.id_ano=".$this->ano." and enfermeria.patologia=".$this->patologia." and fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."') as total,id_curso from enfermeria
where enfermeria.id_ano=".$this->ano." and enfermeria.patologia=".$this->patologia."
and fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."'
group by id_curso 
order by id_curso";	
$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
	}
	
	function PatologiaCurso($conn){
	  $sql="select enfermeria.id_curso, enfermeria.fecha,
enfermeria.hora_ingreso,enfermeria.hora_egreso,
enfermeria.destino,
enfermeria_patologia.nombre as nombre_patologia,
upper(alumno.ape_pat||' '||alumno.ape_mat||', '|| alumno.nombre_alu) as nombre_alumno,alumno.ape_pat 
from enfermeria 
inner join alumno on enfermeria.rut_alumno = alumno.rut_alumno
left join enfermeria_patologia on enfermeria_patologia.id_patologia = enfermeria.patologia
where enfermeria.id_ano=".$this->ano." and enfermeria.id_curso=".$this->curso."
and enfermeria.fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."' 
order by alumno.ape_pat asc";
$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
	}
	
	
	function ConteoPatologiaCurso($conn){
	$sql="select  enfermeria.patologia,count(*)as cuenta,
(select count(*) from enfermeria  where enfermeria.id_ano=".$this->ano." and enfermeria.id_curso=".$this->curso." 
and enfermeria.fecha  between '".$this->fecha_inicio."' and '".$this->fecha_termino."') as total
from enfermeria
 where enfermeria.id_ano=".$this->ano." and enfermeria.id_curso=".$this->curso." 
and enfermeria.fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."'
group by enfermeria.patologia ";
$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
	}
	
	function ConteoPatologiaAlumno($conn){
	$sql="select  enfermeria.patologia,count(*)as cuenta,
(select count(*) from enfermeria  where enfermeria.id_ano=".$this->ano." and enfermeria.id_curso=".$this->curso." 
and enfermeria.fecha  between '".$this->fecha_inicio."' and '".$this->fecha_termino."') as total
from enfermeria
 where enfermeria.id_ano=".$this->ano." and enfermeria.id_curso=".$this->curso." AND enfermeria.rut_alumno=".$this->alumno." and enfermeria.fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."'
group by enfermeria.patologia ";
$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
	}
	
	
	
	function EnfermeriaFecha($conn){
		 $sql="select enfermeria.id_curso, enfermeria.fecha,enfermeria.hora_ingreso,enfermeria.hora_egreso,enfermeria.destino,upper(enfermeria_patologia.nombre) as nombre_patologia, upper(alumno.ape_pat||' '||alumno.ape_mat||', '|| alumno.nombre_alu) as nombre_alumno,enfermeria.patologia ,alumno.ape_pat from enfermeria inner join alumno on enfermeria.rut_alumno = alumno.rut_alumno left join enfermeria_patologia on enfermeria_patologia.id_patologia = enfermeria.patologia where enfermeria.id_ano=".$this->ano." and enfermeria.fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."' order by alumno.ape_pat, alumno.ape_mat asc";
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
		
	}
	
		function countEnfermeriaFecha($conn){
		 $sql="select * from enfermeria where enfermeria.id_ano=".$this->ano." and enfermeria.fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."' ";
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
		
	}
	
	
	function countEnfermeriaConDestino($conn){
		  $sql="  select count(en.id_enfermeria)
from enfermeria en
where  en.id_ano=".$this->ano." and en.fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."' and en.destino is not null";
$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		$this->cont_accidente = pg_Result($result,0);
		return  ;	
		
	}
	
	function countEnfermeriaPorPatologiaTODOS($conn){
	$sql=" select count(en.id_enfermeria) as conteo, en.patologia, pat.nombre
from enfermeria en
inner join enfermeria_patologia pat on pat.id_patologia = en.patologia
where en.id_ano=".$this->ano." and en.fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."'
group by en.patologia, pat.nombre "	;

$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
	}
	
	
	function ConteoEnfermeriaFecha($conn){
	$sql="select count(*) as cuenta,
(select count(*) from enfermeria 
where enfermeria.id_ano=".$this->ano." 
and fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."') 
as total,
fecha from enfermeria where enfermeria.id_ano=".$this->ano." 
and fecha 
between '".$this->fecha_inicio."' and '".$this->fecha_termino."' group by fecha order by fecha";

$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
	}
	
	
	function EnfermeriaAlumno($conn){
		 $sql="select enfermeria.id_enfermeria,enfermeria.fecha,enfermeria.hora_ingreso,enfermeria.hora_egreso,
 enfermeria.destino, ep.nombre as nombre_patologia from enfermeria  INNER JOIN enfermeria_patologia ep ON enfermeria.patologia=ep.id_patologia where enfermeria.id_ano=".$this->ano." and enfermeria.rut_alumno=".$this->alumno." ";
 	if($this->fecha_inicio==" " and $this->fecha_termino==" "){
		$sql.="  and enfermeria.fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."'";
	}
		$sql.=" order by  enfermeria.fecha asc,enfermeria.hora_ingreso asc";
		$result = pg_exec($conn,$sql) or die("ERROr--->".$sql);
		
		return $result;
		
	}
	
	
	function EnfermeriaAlumnoDetalle($conn){
		  $sql="select * from enfermeria 
   where id_enfermeria=".$this->id_atencion;
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
		
	}
	
	
	
	function conteoEnfermeriaEnsenanza($conn){
	 $sql="select count(en.id_enfermeria) 
 from enfermeria en
 inner join curso c on c.id_curso = en.id_curso
 where c.ensenanza=".$this->ensenanza."
 and en.id_ano=".$this->ano." and en.fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."'";
 $result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
	}
	
	
	
	function promedioCiclos($conn){
		$sql="select avg(CAST(promedio as INTEGER)) as promedio, cod_subsector, r.id_curso
		FROM NOTAS".$this->nro_ano." nt
		INNER JOIN ramo r ON nt.id_ramo=r.id_ramo AND cod_subsector=".$this->cod_subsector."
		INNER JOIN ciclos c ON c.id_curso=r.id_curso
		WHERE id_periodo=".$this->periodo." and id_ciclo=".$this->id_ciclo." AND promedio not in ('MB','B','S','I',' ')
		GROUP BY 2,3";
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
	
	}
	
	
	function Apoderado_all($conn){
			$sql = "SELECT apoderado.rut_apo, apoderado.dig_rut, apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, ";
		$sql.= " apoderado.telefono, apoderado.email, tiene2.responsable, apoderado.relacion,apoderado.calle,apoderado.nro, ";
		$sql.= " apoderado.profesion, apoderado.ocupacion,apoderado.nivel_edu,apoderado.nivel_social, apoderado.sexo, ";
		$sql.= " apoderado.celular, comuna.nom_com,apoderado.parentezco FROM tiene2 INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo ";
		$sql.= "  INNER JOIN comuna ON apoderado.region=comuna.cod_reg AND apoderado.ciudad=comuna.cor_pro AND apoderado.comuna=comuna.cor_com ";
		$sql.= " WHERE tiene2.rut_alumno=".$this->alumno."";
		$sql.= " ORDER BY apoderado.ape_pat ASC ";
//	if($_PERFIL==0) echo "<BR>".$sql;
		$result_apo = @pg_Exec($conn, $sql);
		return $result_apo;
		
	}
	
	
	function Apoderado_uno($conn){
			$sql = "SELECT apoderado.rut_apo, apoderado.dig_rut, apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, ";
		$sql.= " apoderado.telefono, apoderado.email, tiene2.responsable, apoderado.relacion,apoderado.calle,apoderado.nro, ";
		$sql.= " apoderado.profesion, apoderado.ocupacion,apoderado.nivel_edu,apoderado.nivel_social, apoderado.sexo, ";
		$sql.= " apoderado.celular, comuna.nom_com,apoderado.parentezco FROM tiene2 INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo ";
		$sql.= "  INNER JOIN comuna ON apoderado.region=comuna.cod_reg AND apoderado.ciudad=comuna.cor_pro AND apoderado.comuna=comuna.cor_com ";
		$sql.= " WHERE apoderado.rut_apo=".$this->rut."";
		//$sql.= " ORDER BY apoderado.ape_pat ASC ";
//	if($_PERFIL==0) echo "<BR>".$sql;
		$result_apo = @pg_Exec($conn, $sql);
		return $result_apo;
		
	}
	
	
	function PlantillaevaluacionApo($conn){
	 $sql = "select * from plantilla_apo
where plantilla_apo.id_plantilla=$this->evaluacion";
	$result = @pg_Exec($conn, $sql);
		return $result;
	}
	
	function evaluacionApo($conn){
	 $sql = "select distinct(rut),titulo,plantilla_apo.id_plantilla,plantilla_apo.descripcion from plantilla_apo
inner join plantilla_apo_evaluacion
on plantilla_apo.id_plantilla = plantilla_apo_evaluacion.id_plantilla
where  plantilla_apo_evaluacion.id_ano=$this->ano and plantilla_apo.id_plantilla=$this->evaluacion";

if($this->entrevistado>0){
$sql.=" and plantilla_apo_evaluacion.rut=$this->entrevistado";
;}
//echo $sql;
	$result = @pg_Exec($conn, $sql)  or die($sql);
		return $result;
	}
	
	
	
function getAreas($conn){
	
	   $sql="select * from plantilla_apo_area where id_plantilla=".$this->plantilla ;
			$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	
}

 function getConceptoApo($conn){
	
	   $sql="select * from plantilla_apo_item where id_plantilla=".$this->plantilla ." and id_area=$this->area and activo=1" ;
			$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	
}



function selEvaluacionPeriodo($entrevistado,$ano,$periodo){
	 $sql ="select * from plantilla_apo_evaluacion av
where av.rut=$entrevistado and  av.id_ano=$ano and av.id_periodo=$periodo";
	$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
}
	
	function selItemEvaluacionApo($conn){
$sql ="select ev.id_evaluacion,ev.id_concepto,iv.nombre from plantilla_apo_evaluacion_item ev
inner join plantilla_apo_evaluacion av
on av.id_evaluacion=ev.id_evaluacion
inner join plantilla_apo_concepto iv
on iv.id_concepto = ev.id_concepto
where ev.id_evaluacion=$this->evaluacion and id_area=$this->area and id_item=$this->item
and av.id_ano=$this->ano and av.id_periodo=$this->periodo";
$result=pg_exec($conn, $sql) or die("error".$sql);
	return $result;

}

 function ListaConceptoApo($conn){
	
	    $sql="select * from plantilla_apo_concepto where id_plantilla=".$this->plantilla ." and  activo=1" ;
			$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	
}

function ultimoPeriodo($conn){
		$sql="SELECT fecha_inicio,fecha_termino,dias_habiles, nombre_periodo,id_periodo FROM periodo WHERE id_ano=".$this->ano." order by fecha_termino desc limit 1";
		//$Rs_Periodo = @pg_exec($conn,$sql);
		/*$fila_Periodo=@pg_fetch_array($Rs_Periodo,0);
		$this->fecha_inicio_ul=$fila_Periodo['fecha_inicio'];
		$this->fecha_termino_ul=$fila_Periodo['fecha_termino'];
		$this->dias_habiles_ul = $fila_Periodo['dias_habiles'];
		$this->nombre_periodo_ul = $fila_Periodo['nombre_periodo'];
		$this->id_periodo_ul = $fila_Periodo['id_periodo'];
	  	$this->result = $Rs_Periodo;*/
		$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	}

	
	function TraePeriodoActivo($conn){
	$sql="select id_periodo from quiz_periodos where id_ano=".$this->ano." and cerrado =0;";
	$result=pg_exec($conn, $sql) or die("error".$sql);
	$this->id_periodo = pg_result($result,0);
	return;
	}
	
	
	function TraePorcentajeAsistencia($conn){
		//rut alumno
		//id_curso
		//fecha inicio a�o
		//fecha termino a�o
		//fecha matricula
		//fecha_retiro
		//bool_ar
		
		//variables conteo
		$feriados_ano=0;
		$fera=0;
		
		//parte 1: determinar fechas inicio y termino a�o de alumno
		if($this->fecha_matricula <= $this->inicio_ano_curso)
		{$fini= $this->inicio_ano_curso;}
		else
		{$fini= $this->fecha_matricula;}
		
		
		
		//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de a�o academico
		if($this->retirado==1){
		 $fter =$this->fecha_retiro;
		}else{
		 $fter = $this->fin_ano_curso;
		}
		
		
		//conteo dias habiles a�o (sin feriados)
		 $habiles_ano=$this->dabiles($fini,$fter);
		 
		 //******feriados a�o
     $sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$this->ano."  AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
	
	$rs_feriadosano = @pg_exec($conn,$sql_fano);

for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
		$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
		
		$inciof= $fila_feriadoano['fecha_inicio'];
		
	
		
		if($fila_feriadoano['fecha_fin']==NULL)
		{
			 $finf=$inciof ;
			
		}else{
		
			$finf= $fila_feriadoano['fecha_fin'];
		}
		
		 $fera=$fera+$dif_dias =$this->difdias($inciof, $finf);
		
		}
		
	 	 $feriados_ano=$fera;


//fin feriados a�o	


//dias reales a�o
	 $habil_real_ano = $habiles_ano-$feriados_ano;
	 
	 
	  //inasistencias
	 $sql_asisano = "SELECT * FROM asistencia WHERE rut_alumno = ".$this->alumno." and ano = ".$this->ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$this->curso;
	
	$r_asisano = @pg_exec($conn,$sql_asisano);
		
	$c_inasistenciaAno = pg_numrows($r_asisano);
		 
		 
		 
		 //justificadas
		 

   $sql_jasisano = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = ".$this->alumno." and ano = ".$this->ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$this->curso;
  	
  $r_justificaano= @pg_exec($conn,$sql_jasisano);
 $justificaano = pg_numrows($r_justificaano);
		
		 
 //resta final
	  $con_total_inano = $habil_real_ano-($c_inasistenciaAno-$justificaano);
	  
	 //porcentaje anual
		 $prc_base = intval((100* $con_total_inano)/$habil_real_ano);
		 
		 return $prc_base;
		
	}
	
	
	
	
	//sacar sabado y domingo
	//dias habiles por rango fijo, sin feriados
function dabiles($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
		
		//echo $fechainicio.".....".$fechafin;;
		
     $fechainicio = strtotime($fechainicio." 00:00:00");
	 $fechafin = strtotime($fechafin." 23:59:59");
       
        // Incremento en 1 dia
        $diainc = 24*60*60;
       
        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                        if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                                array_push($diashabiles, date('Y-m-d', $midia));
                        }
                }
        }
       
        return count($diashabiles);
}



//datediff rango de fechas
function difdias($start, $end) {
    			
        $sdate = strtotime($start);
        $edate = strtotime($end);
        
        if ($edate < $sdate) {
            $sdate_temp = $sdate;
            $sdate = $edate;
            $edate = $sdate_temp;
            
        }
       $time = $edate - $sdate;
        $preday[0] = 0;
        
        if($time>=0 && $time<=59) {
                // Seconds
                $timeshift = $time.' seconds ';

        } elseif($time>=60 && $time<=3599) {
                // Minutes + Seconds
                $pmin = ($edate - $sdate) / 60;
                $premin = explode('.', $pmin);
               
                $presec = $pmin-$premin[0];
                $sec = $presec*60;
               
                $timeshift = $premin[0].' min '.round($sec,0).' sec ';

        } elseif($time>=3600 && $time<=86399) {
                // Hours + Minutes
                $phour = ($edate - $sdate) / 3600;
                $prehour = explode('.',$phour);
               
                $premin = $phour-$prehour[0];
                $min = explode('.',$premin*60);
               
                $presec = '0.'.$min[1];
                $sec = $presec*60;

                $timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        } elseif($time>=86400) {
                // Days + Hours + Minutes
                $pday = ($edate - $sdate) / 86400;
                $preday = explode('.',$pday);

                $phour = $pday-$preday[0];
                $prehour = explode('.',$phour*24);

                $premin = ($phour*24)-$prehour[0];
                $min = explode('.',$premin*60);
               
                $presec = '0.'.$min[1];
                $sec = $presec*60;
               
                $timeshift = $preday[0].' days '.$prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        }
        

        return $preday[0]+1;
} 


//porcentaje atraso
function traePorcetajeAtraso($conn){
//variables conteo
		$feriados_ano=0;
		$fera=0;
		
		//parte 1: determinar fechas inicio y termino a�o de alumno
		if($this->fecha_matricula <= $this->inicio_ano_curso)
		{$fini= $this->inicio_ano_curso;}
		elseif($this->inicio_ano_curso == NULL){
		$fini= $this->inicio_ano_inst;
		}
		else
		{$fini= $this->fecha_matricula;}
		
		
		
		//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de a�o academico
		if($this->retirado==1){
		 $fter =$this->fecha_retiro;
		}
		else{
			if($this->fin_ano_curso == NULL){
			$fter= $this->fin_ano_inst;
			}
			else{
			 $fter = $this->fin_ano_curso;
			}
		}
		
		
		//conteo dias habiles a�o (sin feriados)
		 $habiles_ano=$this->dabiles($fini,$fter);
		 
		 //******feriados a�o
    $sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$this->ano."  AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
	
	$rs_feriadosano = @pg_exec($conn,$sql_fano);

for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
		$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
		
		$inciof= $fila_feriadoano['fecha_inicio'];
		
	
		
		if($fila_feriadoano['fecha_fin']==NULL)
		{
			 $finf=$inciof ;
			
		}else{
		
			$finf= $fila_feriadoano['fecha_fin'];
		}
		
		 $fera=$fera+$dif_dias =$this->difdias($inciof, $finf);
		
		}
		
	 	$feriados_ano=$fera;


//fin feriados a�o	


//dias reales a�o
	  $habil_real_ano = $habiles_ano-$feriados_ano;
	 
	 //atrasos
	  $this->fecha1=$fini;
	 $this->fecha2=$fter;
	 $atr=$this->Atrasos($conn);
	 $atr=pg_numrows($atr);
	 
	  //resta final
	  $con_total_inano = $habil_real_ano-$atr;
	  
	 //porcentaje anual
		 $prc_base = (100* $con_total_inano)/$habil_real_ano;
		 
		 return $prc_base;
	 
	 

}



//*************************************************************************
//traigo solo los dias habiles del a�o (lunea a viernes y ya con feeriados fuera)
function traeDiasHabilesAnio($conn){
	//variables conteo
		$feriados_ano=0;
		$fera=0;
		
		//parte 1: determinar fechas inicio y termino a�o de alumno
		if($this->inicio_ano_curso == NULL){
		$fini= $this->inicio_ano_inst;
		}
		elseif($this->fecha_matricula <= $this->inicio_ano_curso)
		{$fini= $this->inicio_ano_curso;}
		else
		{$fini= $this->fecha_matricula;}
		
		
		
		//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de a�o academico
		if($this->retirado==1){
		 $fter =$this->fecha_retiro;
		}
		else{
			if($this->fin_ano_curso == NULL){
			$fter= $this->fin_ano_inst;
			}
			else{
			 $fter = $this->fin_ano_curso;
			}
		}
		
		
		//conteo dias habiles a�o (sin feriados)
		 $habiles_ano=$this->dabiles($fini,$fter);
		 
		 //******feriados a�o
    $sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$this->ano."  AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
	
	$rs_feriadosano = @pg_exec($conn,$sql_fano);

for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
		$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
		
		$inciof= $fila_feriadoano['fecha_inicio'];
		
	
		
		if($fila_feriadoano['fecha_fin']==NULL)
		{
			 $finf=$inciof ;
			
		}else{
		
			$finf= $fila_feriadoano['fecha_fin'];
		}
		
		 $fera=$fera+$dif_dias =$this->difdias($inciof, $finf);
		
		}
		
	 	$feriados_ano=$fera;


//fin feriados a�o	


//dias reales a�o
	  $habil_real_ano = $habiles_ano-$feriados_ano;
	  
	  return $habil_real_ano;
}


function atrasosCursoMesConteo($conn){
	 $sql="SELECT count(*) as conteo FROM anotacion an 
inner join matricula on matricula.rut_alumno=an.rut_alumno
WHERE tipo = ".$this->tipo." and matricula.id_curso=".$this->curso."
and an.fecha BETWEEN '".$this->fecha1."'  and  '".$this->fecha2."'";

$rs = @pg_exec($conn,$sql) or die("error".$sql);
$this->cuentaatraso = pg_result($rs,0);
return;
}


//porcentaje atraso curso
function traePorcetajeAtrasoCurso($conn){
//variables conteo
		$feriados_ano=0;
		$fera=0;
		
		//parte 1: determinar fechas inicio y termino a�o de alumno
		
		if($this->inicio_ano_curso == NULL){
		$fini= $this->inicio_ano_inst;
		}
		else
		{$fini= $this->inicio_ano_curso;}
		
		
		
		//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de a�o academico
		
			if($this->fin_ano_curso == NULL){
			$fter= $this->fin_ano_inst;
			}
			else{
			 $fter = $this->fin_ano_curso;
			}
		
		
		
		//conteo dias habiles a�o (sin feriados)
		 $habiles_ano=$this->dabiles($fini,$fter);
		 
		 //******feriados a�o
    $sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$this->ano."  AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
	
	$rs_feriadosano = @pg_exec($conn,$sql_fano);

for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
		$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
		
		$inciof= $fila_feriadoano['fecha_inicio'];
		
	
		
		if($fila_feriadoano['fecha_fin']==NULL)
		{
			 $finf=$inciof ;
			
		}else{
		
			$finf= $fila_feriadoano['fecha_fin'];
		}
		
		 $fera=$fera+$dif_dias =$this->difdias($inciof, $finf);
		
		}
		
	 	$feriados_ano=$fera;


//fin feriados a�o	


//dias reales a�o
	  $habil_real_ano = $habiles_ano-$feriados_ano;
	 
	 //atrasos
	  $this->fecha1=$fini;
	 $this->fecha2=$fter;
	 $atr=$this->atrasosCursoMesConteo($conn);
	 $atr=$this->cuentaatraso;
	 
	  //resta final
	  $con_total_inano = $habil_real_ano-$atr;
	  
	 
	 //porcentaje anual
	 //0: trae porcentaje; 1: solo trae conteo
	 if( $this->fr==0){
		 $prc_base = (100* $con_total_inano)/$habil_real_ano;
	 }
	 elseif( $this->fr==1){
		$prc_base =  $this->cuentaatraso;
		}
		 return $prc_base;
	 
	 

}

function traeNombreAsunto($conn){
		 $sql="select id_asunto,asunto from citacion_asunto where id_asunto =".$this->asunto;
		$result = @pg_exec($conn,$sql) or die("error asunto: ".$sql);
		return $result;
}

function citacionTotal($conn){

			
			$sql="SELECT count(a.*) as cuenta
			from citacion_asistencia a 
			inner join citacion c on c.id_citacion=a.id_citacion 
			where c.id_ano=".$this->ano."  and date_part('year',c.fecha)=".$this->nro_ano." 
			and date_part('month',c.fecha)=".$this->mes;
			
			if($curso>0){
			$sql.=" and a.id_curso=".$this->curso;
			}
			$sql.=" and c.id_asunto=".$this->asunto;
			
			$result = @pg_exec($conn,$sql) or die("error asunto: ".$sql);
			return $result;
			
			
	
	

}

function citacionAusente($conn){
	$sql="SELECT count(a.*) as cuenta
			from citacion_asistencia a 
			inner join citacion c on c.id_citacion=a.id_citacion 
			where c.id_ano=".$this->ano."  and date_part('year',c.fecha)=".$this->nro_ano." 
			and date_part('month',c.fecha)=".$this->mes;
			
			if($curso>0){
			$sql.=" and a.id_curso=".$this->curso;
			}
			$sql.=" and c.id_asunto=".$this->asunto."
			and a.estado=1";
			
			$result = @pg_exec($conn,$sql) or die("error asunto: ".$sql);
			return $result;

}


function traeRetirados($conn){
$sql="select * from retiro where id_curso=".$this->curso." and fecha between '".$this->fecha_desde."' and '".$this->fecha_hasta."'";
$result = @pg_exec($conn,$sql) or die("error asunto: ".$sql);
return $result;

}

function traeRetiradosNew($conn){
$sql="select * from matricula where id_curso=".$this->curso." and bool_ar=1 and fecha_retiro between '".$this->fecha_desde."' and '".$this->fecha_hasta."'";
$result = @pg_exec($conn,$sql) or die("error asunto: ".$sql);
return $result;

}

function PeriodoFecha($conn){
		 $sql="SELECT * FROM periodo WHERE fecha_inicio <='".$this->fechaacc."' and fecha_termino>='".$this->fechaacc."' and id_ano=".$this->ano;
		$result = @pg_exec($conn,$sql)or die ("F_P");
		
		
		return $result;
	}


public function cambiaEstado($conn){
	  $sql="update enfermeria set visto =1 where id_enfermeria =".$this->id_atencion;
	
		$result = pg_exec($conn,$sql) or die("no pase por ultimo:".$sql);
		
		return $result;	
	}

/************escala******************/
public function conceptoEscala($conn){
 $sql = "select * from modulo_conceptos where id=".$this->concepto;
 $result = pg_exec($conn,$sql) or die("no pase por ultimo:".$sql);
 return $result;
}

public function conceptoEscalaAll($conn){
 $sql = "select * from modulo_conceptos where id_ano=".$this->ano;
 $result = pg_exec($conn,$sql) or die("no pase por ultimo:".$sql);
 return $result;
}

public function ramoTipoEnse($conn){
$sql = "select distinct(r.cod_subsector), s.nombre 
from ramo r
inner join subsector s on s.cod_subsector = r.cod_subsector  
inner join curso c on c.id_curso = r.id_curso
where c.ensenanza = ".$this->tipo_ense."
and c.id_ano = ".$this->ano."
and r.modo_eval=1
order by r.cod_subsector "	;

		$result = pg_exec($conn,$sql) or die("no pase por ultimo:".$sql);
		
		return $result;	
}

public function gradoTipoEnseEscala($conn){
$sql="select distinct(c.grado_curso)
from curso c
where c.ensenanza = ".$this->tipo_ense."
and c.id_ano = ".$this->ano."
order by grado_curso";

		$result = pg_exec($conn,$sql) or die("no pase por ultimo:".$sql);
		
		return $result;
}

public function cuentaAlumnogrado($conn){
$sql="select count (m.*) as cuenta from matricula m
inner join curso c on c.id_curso = m.id_curso
where c.ensenanza = ".$this->tipo_ense."
and c.id_ano =".$this->ano."
and c.grado_curso = ".$this->grado."
and m.bool_ar=0
and m.fecha<='".$this->fecha_termino."'";

		$result = pg_exec($conn,$sql) or die("no pase por ultimo:".$sql);
		
		return $result;
}

public function notaRamoGrado($conn){
 $sql="select count(nt.promedio)
FROM notas".$this->nro_ano." nt
INNER JOIN tiene".$this->nro_ano." te ON te.rut_alumno=nt.rut_alumno and te.id_ramo=nt.id_ramo
INNER JOIN ramo r ON r.id_ramo=te.id_ramo AND r.id_ramo=nt.id_ramo
INNER JOIN curso c ON c.id_curso=r.id_curso
WHERE c.id_ano=".$this->ano." AND nt.id_periodo=".$this->periodo." AND c.ensenanza=".$this->tipo_ense." AND c.grado_curso=".$this->grado." AND r.cod_subsector=".$this->cod_subsector." 
AND nt.promedio between '".$this->notamin."' and '".$this->notamax."'
";
$rs = @pg_exec($conn,$sql) or die("error".$sql);
$this->cuentanot = pg_result($rs,0);
return;
}


public function cursoTieneRamo($conn){
$sql="select c.id_curso,r.id_ramo,c.ensenanza
from curso c
inner join ramo r on r.id_curso = c.id_curso
where c.id_ano=".$this->ano."
and r.cod_subsector=".$this->codsu."
order by c.ensenanza, c.grado_curso, c.letra_curso
"
;	
$result = pg_exec($conn,$sql) or die("no pase por ultimo:".$sql);
		
		return $result;
}

public function cuentaAlumnoRamo($conn){
$sql="select count(tn.*)
from tiene".$this->nro_ano." tn
where tn.rut_alumno 
in (select rut_alumno from matricula 
where bool_ar=0 and id_curso=".$this->curso." and fecha<='".$this->fecha_termino."')
and id_ramo=".$this->ramo."";
$rs = @pg_exec($conn,$sql) or die("error".$sql);
$this->cuentalu = pg_result($rs,0);
return;
}

public function  cuentaPromedioRamo($conn){
	 $sql="select count(n.promedio)
from notas".$this->nro_ano." n
where n.id_ramo = ".$this->ramo."
and n.id_periodo =".$this->periodo."
and n.promedio between '".$this->notamin."' and '".$this->notamax."'";
$rs = @pg_exec($conn,$sql) or die("error".$sql);
$this->prome = pg_result($rs,0);
return;
}

/************fin escala******************/

/************entrevista*/
function traeEntrevista($conn){
	 $sql="select * from entrevista_docente where entrevistado=".$this->rut_emp." and id_ano=".$this->ano;  
	
	
	$result = pg_exec($conn,$sql) or die("no pase por ultimo:".$sql);
		
		return $result;
}
function traeEntrevistaOrientador($conn){
	 $sql="select * from entrevista_orientador where rut_entrevistado=".$this->rut_entrevistado." and id_ano=".$this->ano;
	$result = pg_exec($conn,$sql) or die("no pase por ultimo:".$sql);
		
		return $result;
}

 function traeAsuntoDetalle($conn){
	  $sql="select * from entrevista_docente_asunto where id_asunto=".$this->id_asunto;	
		
	$result = pg_exec($conn,$sql) or die("no pase por ultimo:".$sql);
		
		return $result;
	
	}

/************fin entrevista*/
function EnsenanzaNotas($conn){
	$sql="select DISTINCT te.cod_tipo,te.nombre_tipo from tipo_ense_inst tei INNER JOIN tipo_ensenanza te ON tei.cod_tipo=te.cod_tipo
WHERE rdb=".$this->institucion;
	$result = pg_exec($conn,$sql);
	
	return $result;
} 

/*promedio psintesis*/
function promPSintesisCurso($conn){
	
 $sql="SELECT (sum((CAST(promedio as float) * 30)/100) +
(SELECT sum((CAST(promedio as float) * 50)/100) FROM notas".$this->nro_ano." 
WHERE id_ramo=".$this->ramo." ) +
(SELECT sum((CAST(nota as float) * 20)/100) FROM notas_psintesis 
WHERE id_ramo=".$this->ramo." )) / 
(select count(*) from tiene".$this->nro_ano." where id_ramo = ".$this->ramo." )
FROM pu_notas 
WHERE id_ramo=".$this->ramo." 


";
	$result = pg_exec($conn,$sql);
	
	return $result;
}


function promPSintesisCursoPeriodo($conn){
	
  $sql="SELECT (sum((CAST(promedio as float) * 30)/100) +
(SELECT sum((CAST(promedio as float) * 50)/100) FROM notas".$this->nro_ano."  
WHERE id_ramo=".$this->ramo." AND id_periodo=".$this->periodo.") +
(SELECT sum((CAST(nota as float) * 20)/100) FROM notas_psintesis 
WHERE id_ramo=".$this->ramo." AND periodo=".$this->periodo.")) / 
(select count(*) from tiene".$this->nro_ano." where id_ramo = ".$this->ramo." )
FROM pu_notas 
WHERE id_ramo=".$this->ramo." AND id_periodo=".$this->periodo."


";
	$result = pg_exec($conn,$sql);
	
	return $result;
}

/************ensayos simce****************************/
 function listaPuntajeSimce($conn){
		 
		    $sql="select distinct fecha from ensayos_simce  where id_curso=".$this->id_curso." and id_ramo=".$this->id_ramo." order by fecha";
		$result = pg_exec($conn,$sql);
		return $result;
	}
	
	 function puntajeAlumnoSimce($conn){
		 $sql="select * from ensayos_simce  where id_curso=".$this->id_curso." and id_ramo=".$this->id_ramo." and rut_alumno=".$this->rut_alumno." AND fecha='".$this->fecha."'";
		 $result = pg_exec($conn,$sql);	
		 return $result;
	}
/************fin ensayos simce************************/


function ramoUNO($conn){
  $sql="select ramo.id_ramo,su.nombre,ramo.id_orden,su.cod_subsector,ramo.bool_aprgrp from ramo 
	inner join subsector su on ramo.cod_subsector=su.cod_subsector
	where ramo.id_ramo=".$this->ramo." order by ramo.id_orden ASC"; 
	$result = pg_exec($conn,$sql);	
		 return $result;
}



function AsistenciaCMALU($conn){
	 	$sql="select count(*) from asistencia where ano=".$this->ano." and id_curso = ".$this->curso."
 and date_part('month',fecha)=".$this->mes." and rut_alumno=".$this->rut_alumno." ";
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	
	function fechaMatricula15($conn){
		 $sql =" SELECT fecha FROM matricula where matricula.rut_alumno=".$this->rut_alumno." and id_ano=".$this->ano." and bool_ar=0 ";
		//echo $sql;
		
		$rs = @pg_exec($conn,$sql) or die("error".$sql);
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	
	//minutos atraso
	function minAtrasoEmp($conn){
		 $sql =" SELECT * FROM atraso_minutosemp where id_ano=".$this->ano." and rut_empleado=".$this->rut_emp." and fecha_atraso='".$this->fecha."' ";
		//echo $sql;
		
		$rs = @pg_exec($conn,$sql) or die("error".$sql);
		$result = @pg_exec($conn,$sql);
		return $result;
	}


public function AsistenciaCiclosMES($conn){
		 $sql ="SELECT count(a.*) as cuenta FROM asistencia a INNER JOIN ciclos b ON (a.id_curso=b.id_curso AND a.ano=b.id_ano) ";
		$sql.="WHERE a.ano=".$this->ano."  and date_part('MONTH',fecha)=".$this->mes." and id_ciclo=".$this->ciclo." GROUP BY id_ciclo, date_part('MONTH',fecha)";
		//echo $sql."<br>";
		$rs = @pg_exec($conn,$sql) or die("error".$sql);
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	function AsistenciaNivelesMES($conn){
		$sql="SELECT count(a.*) as cuenta, c.id_nivel, date_part('MONTH',fecha) FROM asistencia a INNER JOIN curso b ON a.id_curso=b.id_curso INNER JOIN ";
		$sql.="niveles c ON b.id_nivel=c.id_nivel WHERE b.id_ano=".$this->ano." and date_part('MONTH',fecha)=".$this->mes." and c.id_nivel=".$this->nivel." GROUP BY c.id_nivel, date_part('MONTH',fecha)";
		
		//echo $sql."<br>";
		$result =@pg_exec($conn,$sql)  or die ("SELECT FALL�(asistencia niveles):".$sql);
		return $result;
	}
	
	public function traeJustificaAtraso($conn){
$sql ="select * from justifica_atraso where rut_alumno=".$this->alumno." and fecha='".$this->fecha."' and ano=".$this->ano." and id_curso=".$this->id_curso;
//echo $sql;
$result = pg_exec($conn,$sql);
return $result;
}
 
 
function TraeAccidenteLista($conn){
	if($this->curso>0){
	$conc = " AND id_curso=".$this->curso;	
	}
	
	
	 	$sql="SELECT a.*,upper(alumno.ape_pat||' '||alumno.ape_mat||', '|| alumno.nombre_alu) as nombre_alumno FROM declaracion_accidente a 
	inner join alumno on a.rut_alumno = alumno.rut_alumno WHERE fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."' and id_ano=".$this->ano." $conc order by fecha, hora,minuto";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		// if($_PERFIL==0) echo $sql."<br>";
		 return $result;	
	}
	
function TraeAccidentecuenta($conn){
	if($this->curso>0){
	$conc = " AND id_curso=".$this->curso;	
	}
	
	
	 	$sql="SELECT count(a.*) as cuenta,a.tipo  FROM declaracion_accidente a 
	inner join alumno on a.rut_alumno = alumno.rut_alumno WHERE fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."' and id_ano=".$this->ano." $conc group by a.tipo ";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
				 return $result;	
	}
	

function ejutp($conn){
	  $sql="select * from entrevista_jefeutp where id_ano=".$this->ano." and id_curso=".$this->curso." and fecha='".$this->fecha."'";
	$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		   
		 return $result;
}


function TraeUnempleado($conn){
		$sql="SELECT * FROM empleado WHERE rut_emp=".$this->empleado;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		  //if($_PERFIL==0) echo $sql."<br>";
		 return $result;	
	}



function apoLista($conn){
	 $sql="select DISTINCT(a.rut_apo),a.dig_rut,a.ape_pat,a.ape_mat,a.nombre_apo,a.calle||' '||a.nro direccion,a.telefono,a.email from apoderado a
inner join tiene2 t on t.rut_apo = a.rut_apo and t.responsable =1
inner join matricula m on m.rut_alumno = t.rut_alumno
inner join curso c on c.id_curso = m.id_curso
where m.id_ano = ".$this->ano." 
order by a.ape_pat,a.ape_mat,a.nombre_apo";
$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		   //if($_PERFIL==0) echo $sql."<br>";
		 return $result;
}


function alumno_curapo($conn)
	{
		 $sql="select a.rut_alumno,m.id_curso,a.dig_rut,a.ape_pat,a.ape_mat,
a.nombre_alu 
from alumno a 
inner join tiene2 t on t.rut_alumno = a.rut_alumno 
inner join matricula m on m.rut_alumno = a.rut_alumno 
inner join curso c on c.id_curso = m.id_curso 
where t.rut_apo = ".$this->rut_apo."  and m.id_ano = ".$this->ano." 
order by a.ape_pat,a.ape_mat,a.nombre_alu";	
		$result = pg_Exec($conn,$sql);
		return $result;
	} 




function ListadoCursoGrado($conn){
	$sql= "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
	$sql.= "curso.ensenanza, curso.cod_decreto ";
	$sql.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql.= "WHERE curso.id_ano=".$this->ano."";
	$sql.=" AND ensenanza= ".$this->ensenanza."";
	$sql.=" AND curso.grado_curso= ".$this->grado."";
	
	$sql.= " ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso ";
	
	
	$result = pg_exec($conn,$sql) or die ("Select fall�: ".$sql);
	return $result;
	}
	
	function MatriculadosGrado($conn){
	$sql = "Select * FROM matricula WHERE id_ano=".$this->ano." AND id_curso=".$this->id_curso." and bool_ar=0";
	$result = @pg_exec($conn,$sql) or die ("SELECT FALL� (Matriculados):".$sql);
	return $result;
	}

function ListadoSubsectoresGrado($conn){
		$sql ="SELECT distinct RAMO.cod_subsector,subsector.nombre from ramo 
inner join curso on curso.id_curso = ramo.id_curso
inner join subsector on subsector.cod_subsector = ramo.cod_subsector
WHERE curso.id_ano=$this->ano and curso.grado_curso = $this->grado and curso.ensenanza=$this->ensenanza and ramo.bool_ip=1 and ramo.modo_eval=1
order by ramo.cod_subsector
		 ";
		
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (listadosubsectores):".$sql);
		return $result;
}

function cuentaPromedioSubAlumno($conn){

	
  $sql="select promedio_sub_alumno.promedio,promedio_sub_alumno.rut_alumno 
from promedio_sub_alumno 
inner join matricula on matricula.rut_alumno = promedio_sub_alumno.rut_alumno 
where matricula.id_ano=$this->ano and id_ramo = $this->id_ramo 
and promedio not in(' ','0','-','EX') and matricula.bool_ar=0
group by promedio_sub_alumno.promedio,promedio_sub_alumno.rut_alumno;";
$result = @pg_exec($conn,$sql);
		return $result;
}

function AnotacionesCueCur($conn){
	
		$sql = " select * from anotacion where";
		$sql.= " fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."'";
		$sql.= " AND tipo=".$this->tipo." ";
		if(strlen($this->conducta)>0){
		$sql.= " AND tipo_conducta=".$this->conducta." ";
		}
		
		$sql.= " AND rut_alumno in(select rut_alumno from matricula where id_ano = ".$this->ano. " and id_curso =".$this->curso. " )"; 
		
		
		$sql.= "order by tipo desc, fecha ";
		//if($_PERFIL==0) echo $sql;
		$result_anota = @pg_Exec($conn, $sql) or die("SELECT FALL�:".$sql);
		return $result_anota;
	}


 function promocionAsistencia($conn){
 $sql="select a.rut_alumno || '-' || a.dig_rut as ruta, p.asistencia,p.id_curso,p.id_ano,p.rut_alumno from promocion p 
inner join alumno a on a.rut_alumno = p.rut_alumno  where id_ano=".$this->ano;
	if(!$this->retirado){
		$sql.=" and  p.situacion_final in(1,2)";
	}
$sql.=" order by id_curso,a.rut_alumno";
	
	//echo $sql;
	
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (listadosubsectores):".$sql);
		return $result;

}

function cuentaDescarga($conn){
	 $sql="select count(*) as conteo,id_reporte from cuenta_certificado 
	where id_ano 
	in(select id_ano from ano_escolar where id_institucion = $this->rdb)
	and fecha between '$this->desde' and '$this->hasta'
	group by id_reporte";
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (conteo descarga):".$sql);
		return $result;
}

function rangoAnos($conn){
	 $sql="select id_ano,nro_ano from ano_escolar 
where id_institucion = ".$this->rdb." and id_ano between ".$this->ano_desde." and ".$this->ano_hasta."
order by nro_ano";
$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (conteo descarga):".$sql);
		return $result;
}

function promedioRangoPsu($conn){
$sql="select avg(puntaje), cod_ano from psu_notas_2009
where cod_ano = ".$this->idano."  
group by cod_ano";
$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (conteo descarga):".$sql);
		return $result;
}


function reporteTipoAlu($conn){
  $sql="select ent.*, 
emp.nombre_emp||' '||emp.ape_pat||' '||emp.ape_mat as entrevistador 
from entrevista_alumno ent
 inner join empleado emp on emp.rut_emp = ent.rut_entrevistador
 where id_ano = $this->ano and id_curso = $this->curso and rut_entrevistado = $this->entrevistado
 and tipo_entrevista = $this->tipo";
$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (conteo descarga):".$sql);
		return $result;
}

public function pOrigen1($conn){
	  $sql="select * from paises where id=$this->idp";
		$result =pg_Exec($conn,$sql);
		return $result;
}
 
 public function Subs1($conn){
		 $sql = "SELECT * FROM subsector WHERE cod_subsector = ".$this->subsector;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (conteo descarga):".$sql);
		return $result;
		
	}
	
public function subsDocente($conn){
 $sql="select DISTINCT(s.cod_subsector),s.nombre
from subsector s
inner join ramo r on s.cod_subsector = r.cod_subsector
inner join dicta d on d.id_ramo = r.id_ramo
inner join curso c on c.id_curso = r.id_curso
where c.id_ano=".$this->ano." and d.rut_emp = ".$this->rut_emp." 
order by s.cod_subsector  ";
$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (conteo descarga):".$sql);
		return $result;	

}
 public function currRamo($conn){
  $sql="select r.id_ramo,r.id_curso
from ramo r
inner join dicta d on d.id_ramo = r.id_ramo
inner join curso c on c.id_curso = r.id_curso
where c.id_ano=".$this->ano." and d.rut_emp = ".$this->rut_emp."  and r.cod_subsector=".$this->subsector;
$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (conteo descarga):".$sql);
		return $result;	
	 }
	 
public function cuentaNotaPos($conn){
$sql="select nota".$this->posicion."  from notas".$this->nro_ano." where id_ramo=".$this->id_ramo." and id_periodo =".$this->periodo." and nota".$this->posicion."!='0'";
$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (conteo conteo):".$sql);
		return $result;	
}

public function smsCatego($conn){
	
	$cad="";
	$ti = ($this->crr==0)?"=0":"!=0";
	if($this->nmes!=0){
	$cad= " and date_part('month',fecha_envio)=".$this->nmes;	
	}
	
  $sql="select a.nombre motivo,s.id_motivo,count(s.*) conteo from sms s
inner join sms_motivo a on a.id_motivo = s.id_motivo
where s.rdb=$this->rdb and id_ano=$this->ano $cad 
GROUP by s.id_motivo,a.nombre 
order by motivo";
$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (conteo conteo):".$sql);
		return $result;	
}
public function smsCurso($conn){
	$cad="";
	$ti = ($this->crr==0)?"=0":"!=0";
	if($this->nmes!=0){
	$cad= " and date_part('month',fecha_envio)=".$this->nmes;	
	}
	
	
 $sql="SELECT count(*)from sms where rdb=$this->rdb and id_ano=$this->ano and id_curso$ti $cad";
$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (conteo conteo):".$sql);
		return $result;	
}


//informe pei
function InformePlantillaPei($conn){
		  $sql="SELECT * FROM pei_plantilla WHERE  activa=1 AND rdb=".$this->institucion." and area=".$this->area;
		$result=@pg_exec($conn,$sql) ;
		return $result;
	}
function InformeAreasPei($conn){
		
			  $sql="select * from pei_area_item where id_plantilla=".$this->plantilla." and id_padre=0 order by id_item";
		
		
		//if($_PERFIL==0) echo $sql;
		
		$result =pg_exec($conn,$sql) or die ("SELECT FALLO (InformeArea):".$sql);
		return $result;
	}
	
	function InformeSubareaPei($conn){
		
		 $sql="SELECT * FROM pei_area_item WHERE id_plantilla=".$this->plantilla." AND id_padre<>0 AND id_padre=".$this->id_padre." ORDER BY id_item, id_padre ASC";
		
		//echo $sql;
		
		$result =pg_exec($conn,$sql) or die ("SELECT FALLO (InformeSubArea):".$sql);
		return $result;

	}
	
	function InformeItemPei($conn){
		
		 $sql="select DISTINCT(p.id_item) as id_item,p.glosa
from pei_area_item p
left join pei_evaluacion e
on e.id_plantilla = p.id_plantilla
where 
e.id_ano='".$this->ano."' 
and e.id_periodo='".$this->periodo."' 
and e.rut_alumno='".$this->rut_alumno."' 
and p.id_plantilla='".$this->plantilla."' 
and id_padre<>0
and p.id_padre ='".$this->id_padre."' 
and e.evaluado=1
order by p.id_item,p.id_padre ASC";
		
		//echo $sql;
		
		$result =pg_exec($conn,$sql) or die ("SELECT FALLO (InformeSubArea):".$sql);
		return $result;

	}
	function InformeItemPeiAno($conn){
		
		 $sql="select DISTINCT(p.id_item) as id_item,p.glosa,p.id_padre
from pei_area_item p
where 
p.id_plantilla='".$this->plantilla."' 
and id_padre<>0
and p.id_padre ='".$this->id_padre."' 

order by p.id_item,p.id_padre ASC";
		
		//echo $sql;
		
		$result =pg_exec($conn,$sql) or die ("SELECT FALLO (InformeSubArea):".$sql);
		return $result;

	}
	
	
	function InformeConceptoPei($conn){
		//echo $institucion;
		
			$sql ="SELECT * FROM pei_evaluacion WHERE id_ano=".$this->ano." AND id_periodo=".$this->periodo." AND id_plantilla=".$this->plantilla." AND  id_item=".$this->id_item." AND rut_alumno=".$this->alumno."";
		
		
		//if($_PERFIL==0) echo $sql;
			
		$result =pg_exec($conn,$sql);
		return $result;
	}
	function InformeEvaluacionPei($conn){
	  $sql ="SELECT * FROM pei_concepto WHERE id_concepto=".$this->respuesta."";
		$result=pg_exec($conn,$sql);
		return $result;
	}
	
	function InformeObservacionesPei($conn){
		$sql ="SELECT * FROM pei_observaciones INNER JOIN periodo ON pei_observaciones.id_periodo=periodo.id_periodo WHERE ";
		$sql.="pei_observaciones.id_ano=".$this->ano." AND pei_observaciones.id_plantilla=".$this->plantilla." AND ";
		$sql.=" pei_observaciones.rut_alumno='".$this->alumno."'";
		if($this->periodo!=""){
			$sql.=" AND pei_observaciones.id_periodo=".$this->periodo;
		}
		//if($_PERFIL==0) echo $sql;
	    $result =@pg_exec($conn,$sql)or die ("SELECT FALLO (InformeObservaciones):".$sql);
		return $result;
	}	
	
	
//informe pain
function InformePlantillaPain($conn){
			$sql="SELECT * FROM pain_plantilla WHERE tipo_ensenanza=".$this->ensenanza." AND $this->grado=1 and activa=1 AND rdb=".$this->institucion;
		$result=@pg_exec($conn,$sql) ;
		return $result;
	}
function InformeAreasPain($conn){
		
			  $sql="select * from pain_area_item where id_plantilla=".$this->plantilla." and id_padre=0 order by id_item";
		
		
		//if($_PERFIL==0) echo $sql;
		
		$result =pg_exec($conn,$sql) or die ("SELECT FALLO (InformeArea):".$sql);
		return $result;
	}
	
	function InformeSubareaPain($conn){
		
		 $sql="SELECT * FROM pain_area_item WHERE id_plantilla=".$this->plantilla." AND id_padre<>0 AND id_padre=".$this->id_padre." ORDER BY id_item, id_padre ASC";
		
		//echo $sql;
		
		$result =pg_exec($conn,$sql) or die ("SELECT FALLO (InformeSubArea):".$sql);
		return $result;

	}
	
	
	function InformeConceptoPain($conn){
		//echo $institucion;
		
			 $sql ="SELECT * FROM pain_evaluacion WHERE id_ano=".$this->ano." AND id_periodo=".$this->periodo." AND id_plantilla=".$this->plantilla." AND ";
			$sql.=" id_item=".$this->id_item." AND rut_alumno=".$this->alumno."";
		
		
		//if($_PERFIL==0) echo $sql;
			
		$result =pg_exec($conn,$sql);
		return $result;
	}
	function InformeEvaluacionPain($conn){
	 $sql ="SELECT * FROM pain_concepto WHERE id_concepto=".$this->respuesta."";
		$result=pg_exec($conn,$sql);
		return $result;
	}
	
	function InformeObservacionesPain($conn){
		$sql ="SELECT * FROM pain_observaciones INNER JOIN periodo ON pain_observaciones.id_periodo=periodo.id_periodo WHERE ";
		$sql.="pain_observaciones.id_ano=".$this->ano." AND pain_observaciones.id_plantilla=".$this->plantilla." AND ";
		$sql.=" pain_observaciones.rut_alumno='".$this->alumno."'";
		if($this->periodo!=""){
			$sql.=" AND pain_observaciones.id_periodo=".$this->periodo;
		}
		//if($_PERFIL==0) echo $sql;
	    $result =@pg_exec($conn,$sql)or die ("SELECT FALLO (InformeObservaciones):".$sql);
		return $result;
	}	
	
	
	public function fechasCurso($conn){
	  $sql="select c.fecha_inicio,c.fecha_termino,m.fecha,m.fecha_retiro,m.bool_ar from curso c inner join matricula m on m.id_curso= c.id_curso where m.id_curso=".$this->_idcurso." and m.rut_alumno=".$this->_rutalumno;
	 $result =@pg_exec($conn,$sql)or die ("SELECT FALLO (InformeObservaciones):".$sql);
		return $result;
	
	}
	
public function velLectora($conn){ 
	//$an="";
	$an=($this->ramo)?" and id_ramo=".$this->ramo:"";

	  $sql="select * from lectura_veloz where id_ano=".$this->ano." and id_curso=".$this->curso." $an and fecha ='".$this->fecha_conc."' and rut_alumno=".$this->rut_alumno;	
	$result =@pg_exec($conn,$sql)or die ("SELECT FALLO (InformeObservaciones):".$sql);
		return $result;
	}
	
	public function calvelLectora($conn){ 

	 $sql="select * from velocidad_lectora_calectora where id_concepto=".$this->concepto;	
	$result =@pg_exec($conn,$sql)or die ("SELECT FALLO (InformeObservaciones):".$sql);
		return $result;
	}
	
	
	public function grafVelLectora($conn){
		$sql="select cal.nombre,count(lv.*) as cuenta from lectura_veloz lv
inner join velocidad_lectora_calectora cal on cal.id_concepto = lv.concepto
where id_curso= $this->curso and lv.fecha='$this->fecha'
group by cal.nombre";
$result=pg_exec($conn,$sql)or die ("SELECT FALLO (plantilla):".$sql);
return $result;	
	}
	
//planificacion plan indicudual
public function dPlan($conn){
 $sql="select * from pain_planificacion where id_ano=".$this->ano." and id_curso=".$this->curso;
$result=pg_exec($conn,$sql)or die ("SELECT FALLO (plantilla):".$sql);
return $result;	
}	

public function contPlan($conn){
 $sql="select * from pain_planificacion_continua where id_curso=".$this->curso." and id_periodo=".$this->periodo." and rut_alumno=".$this->alumno;
$result=pg_exec($conn,$sql)or die ("SELECT FALLO (continuidad):".$sql);
return $result;	
}

public function temp($conn){
  $sql="select * from empleado where rut_emp=".$this->empleado;	
$result=pg_exec($conn,$sql);
return $result;	
}
	
	
public function itmVelLectoraPB($conn){
  $sql="select * from vlectorapb_area_item where rdb=$this->rdb and id_padre=$this->padre order by id_item";	
$result=pg_exec($conn,$sql);
return $result;
}

public function tengoEvaPB($conn){
   $sql="select * from vlectorapb_evaluacion where id_ano=$this->ano and id_curso=$this->curso and rut_alumno=$this->rut and fecha='$this->fecha' and area=$this->area and item=$this->item
";
$regis = @pg_Exec($conn,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
}

public function tengoRespEvaPB($conn){
    $sql="select * from vlectorapb_concepto where id_concepto=$this->concepto
";
$regis = @pg_Exec($conn,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
}
	
	
//estilos de aprendizaje
public function cuentaEstiloAprendizaje($conn){
}

public function estiloAprendizajeCurso($conn){
	 $sql="select m.estilo_aprendizaje,al.rut_alumno,al.ape_pat,al.ape_mat,al.nombre_alu from matricula m inner join alumno al on al.rut_alumno=m.rut_alumno where m.id_curso=$this->curso";
	$regis = @pg_Exec($conn,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	
}

public function estiloAprendizaje($conn){
	 $sql="select * from estilo_aprendizaje where id_estilo =$this->estilo ";
	$regis = @pg_Exec($conn,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	
}
	
	
public function estiloAprendizajeTabla($conn){
	  $sql="select * from estilo_aprendizaje ";
	$regis = @pg_Exec($conn,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	
}	

public function conteoEstiloAprendizaje($conn){
	 //$sql="select m.estilo_aprendizaje,al.rut_alumno,al.ape_pat,al.ape_mat,al.nombre_alu from matricula m inner join alumno al on al.rut_alumno=m.rut_alumno where m.id_curso=$this->curso";
	 if($this->idc!=0){
		 $cad=" and id_curso=$this->idc";
		 }
		 
	 if($this->idc==0){
		 $cad=" and id_ano=$this->ano";
		 }
		 
	  $sql="select count(m.*) from matricula m where estilo_aprendizaje=$this->estilo $cad";
	$regis = @pg_Exec($conn,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	
}


public function cuentaVelLectoraPB($conn){
	   $sql="select count(*) from vlectorapb_evaluacion where id_ano=$this->ano and id_curso=$this->curso and fecha='$this->fecha' and area=$this->area and item=$this->item and respuesta=$this->respuesta
";
$regis = @pg_Exec($conn,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
}
	
	
public function ConEstiloAprCol($conn){
     $sql="select * from vlectorapb_concepto where rdb=$this->rdb";
$regis = @pg_Exec($conn,$sql) or die( "Error bd select 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
}	
	
//autoevaluacion informe personalidad	
function InformeConceptoAutoEvaluacion($conn){


  $sql ="SELECT * FROM informe_autoevaluacion WHERE id_ano=".$this->ano." AND id_periodo=".$this->periodo." AND id_plantilla=".$this->plantilla." AND  id_informe_area_item=".$this->id_item." AND rut_alumno=".$this->alumno."";



$result =pg_exec($conn,$sql);
		return $result;
}
	
	public function InformeObservacionesAutoevaluacion($conn){
		$sql ="SELECT * FROM informe_observaciones_autoevaluacion INNER JOIN periodo ON informe_observaciones_autoevaluacion.id_periodo=periodo.id_periodo WHERE ";
		$sql.="informe_observaciones_autoevaluacion.id_ano=".$this->ano." AND informe_observaciones_autoevaluacion.id_plantilla=".$this->plantilla." AND ";
		$sql.=" informe_observaciones_autoevaluacion.rut_alumno='".$this->alumno."'";
		if($this->periodo!=""){
			$sql.=" AND informe_observaciones_autoevaluacion.id_periodo=".$this->periodo;
		}
		//if($_PERFIL==0) echo $sql;
	    $result =@pg_exec($conn,$sql)or die ("SELECT FALLO (InformeObservaciones):".$sql);
		return $result;
	}	
	
//citaciones
function citacionapos($conn){
	 $sql="select a.id_asistencia, c.id_citacion, c.fecha, 
				c.hora, c.id_asunto, a.estado, a.rut_apo,a.id_curso,
				asu.asunto, (em.ape_pat||' '||em.ape_mat||', '||em.nombre_emp) as atendido,
				(ap.ape_pat||' '||ap.ape_mat||', '||ap.nombre_apo) as nom_apo
				from citacion c 
				inner join citacion_asistencia a on c.id_citacion=a.id_citacion 
				left join citacion_asunto asu on asu.id_asunto = c.id_asunto
				left join empleado em on em.rut_emp = a.atendido
				left join apoderado ap on ap.rut_apo = a.rut_apo
				where 
				 c.id_ano = $this->ano  and  a.id_curso = $this->curso  and c.id_asunto =$this->asunto  ORDER BY c.fecha ASC,nom_apo ASC";
			
			$result = @pg_exec($conn,$sql) or die("error asunto: ".$sql);
			return $result;

}

//anotaciones por codigo
public function cuentAnotacionesCodigo($conn){
 $sql="select count(*) from anotacion where rut_alumno in
 (select rut_alumno from matricula where id_curso = '".$this->curso."' and bool_ar = '0') 
and codigo_tipo_anotacion = '".$this->tipoanotacion."' 
 and id_periodo in(select id_periodo from periodo where id_ano = '".$this->ano."')";
$result = @pg_exec($conn,$sql) or die("error asunto: ".$sql);
			return $result;	
}
	
	
//armar grupos de notas
public function TraeGrupoNota($conn){
	 $sql="select * from grupo_nota where id_ramo=".$this->ramo." and id_curso=".$this->curso." order by id_grupo";
	$result = @pg_exec($conn,$sql) or die("error asunto: ".$sql);
			return $result;	
}	

public function TraeNotaG($conn){
	 $sql="select nota".$this->posicion." from notas".$this->nro_ano." 
where rut_alumno=".$this->alumno." and id_ramo=".$this->ramo." and id_periodo=".$this->periodo." and nota".$this->posicion."!='0'";
	$result = @pg_exec($conn,$sql) or die("error asunto: ".$sql);
			return $result;	
}

    function TraePosNota($conn){
	  $sql="select * from grupo_nota where id_grupo=".$this->grupo;
	$result = @pg_exec($conn,$sql) or die("error asunto: ".$sql);
		return $result;	
}	



function PromedioAlumnoG($conn)
   {
	  $sql="select promedio from notas".$this->nro_ano." n  where n.rut_alumno=".$this->alumno." and n.id_ramo=".$this->ramo." AND id_periodo=".$this->periodo;
	
	  $result = pg_Exec($conn,$sql)or die("f".$sql);
	  return $result;
	  	   
   }
   
   

   
   public function tEnsenanzaAno($conn){
	   $sql="select distinct e.cod_tipo,e.nombre_tipo
 from tipo_ensenanza e
 inner join curso c on c.ensenanza = e.cod_tipo
 where c.id_ano = ".$this->ano." 
 order by e.cod_tipo";
  $result = pg_Exec($conn,$sql)or die("f".$sql);
	  return $result;
	 }
	 
	 
public function cuenMatriculaFecha($conn){
	 $sql="select count(*) from 
matricula where id_curso = ".$this->curso."
and fecha <='".$this->fecha."' ";
$result = pg_Exec($conn,$sql)or die("f".$sql);

	  return $result;
	}
	
public function cuenMariculaSexo($conn){
 $sql="select count(m.*) from
matricula m inner join alumno a on
a.rut_alumno = m.rut_alumno
and id_curso = ".$this->curso."
and fecha <='".$this->fecha."'
and sexo=".$this->sexo;
$result = pg_Exec($conn,$sql)or die("f".$sql);
	  return $result;	
	
}

function cuenMatriculaAlta($conn){/* */
	  $sql = "SELECT count(matricula.*) FROM matricula
	  inner join alumno on matricula.rut_alumno=alumno.rut_alumno
	  WHERE id_ano=".$this->ano." 
	  AND  bool_ar=0 and fecha between '".$this->fecha_inicio."' and '".$this->fecha_fin."' ";
	  $sql.="and id_curso=".$this->curso."  AND alumno.sexo=".$this->sexo;
	 // echo $sql;
	  $result = @pg_exec($conn,$sql) or die ("SELECT FALL� (matricula asistencia Mujeres):".$sql);
	  return $result;
	}
	
	function cuenMatriculaBaja($conn){/* */
	 $sql = "SELECT count(matricula.*) FROM matricula
	  inner join alumno on matricula.rut_alumno=alumno.rut_alumno
	  WHERE id_ano=".$this->ano." 
	  AND  bool_ar=1 and matricula.fecha_retiro between '".$this->fecha_inicio."' and '".$this->fecha_fin."' ";
	  $sql.="and id_curso=".$this->curso."  AND alumno.sexo=".$this->sexo;
	  //echo $sql."<br>";
	  $result = @pg_exec($conn,$sql) or die ("SELECT FALL� (matricula asistencia Mujeres):".$sql);
	  return $result;
	}
	
	
	  function AlumnosTieneop($conn){
		  $ret = ($this->bool_ar==0)?"and bool_ar=0":"";
		  
		  
  //	$sql =" SELECT  tiene$this->nro_ano.rut_alumno ,alumno.ape_pat || cast(' ' as varchar) || CAST(' ' as varchar) ||  ape_mat || cast(' ' as varchar) ||  alumno.nombre_alu  as nombres FROM tiene$this->nro_ano INNER JOIN alumno ON tiene$this->nro_ano.rut_alumno=alumno.rut_alumno WHERE id_ramo=".$this->ramo." AND tiene$this->nro_ano.rut_alumno in (SELECT rut_alumno FROM ";
//	$sql.=" matricula WHERE id_ano=".$this->ano." AND rdb=".$this->institucion." AND id_curso=".$this->curso." $ret )ORDER BY nombres ASC ";
$sql="SELECT tiene$this->nro_ano.rut_alumno ,
alumno.ape_pat || cast(' ' as varchar) || CAST(' ' as varchar) 
|| ape_mat || cast(' ' as varchar) || alumno.nombre_alu as nombres ,
matricula.nro_lista
FROM tiene$this->nro_ano 
INNER JOIN alumno ON tiene$this->nro_ano.rut_alumno=alumno.rut_alumno
INNER join matricula on matricula.rut_alumno = tiene$this->nro_ano.rut_alumno and matricula.id_curso = $this->curso
WHERE id_ramo=$this->ramo
group by 1,2,3
order by matricula.nro_lista";
	
	$result = @pg_exec($conn,$sql);
	
	//if($_PERFIL==0) echo $sql;
	return $result;
  }

public function maxGrupoN($conn){
$sql="SELECT id_curso,id_ramo, count(*) maximum FROM grupo_nota 
where id_curso=".$this->curso."
GROUP BY id_curso,id_ramo
ORDER BY maximum DESC 
LIMIT 1";

$result = @pg_exec($conn,$sql);
	
	//if($_PERFIL==0) echo $sql;
	return $result;
	
}

//riesgo repitencia
public function repitentesCursoNotasCP($conn){

$cad="";
if($this->tipo_rep==0){
$cad=" ";
}
elseif($this->tipo_rep==1 || $this->tipo_rep==2){
$cad=" and situacion_final=2 and tipo_reprova = ".$this->tipo_rep;
}
elseif($this->tipo_rep==3){
$cad=" and situacion_final=2";
}



 $sql="select * from promocion where id_ano=".$this->ano." and id_curso=".$this->curso."  $cad 
  ";
$result = @pg_exec($conn,$sql);
	
	//if($_PERFIL==0) echo $sql;
	return $result;

}


public function repitentesCicloNotasCP($conn){
$cad="";
if($this->tipo_rep==0){
$cad=" ";
}
elseif($this->tipo_rep==1 || $this->tipo_rep==2){
$cad=" and situacion_final=2 and tipo_reprova = ".$this->tipo_rep;
}
elseif($this->tipo_rep==3){
$cad=" and situacion_final=2";
}
//echo "<br>".
$sql=" select p.* from promocion p 
  inner join ciclos c on c.id_curso = p.id_curso
   where p.id_ano=".$this->ano." and c.id_ciclo=".$this->ciclo."  $cad ";	
   $result = @pg_exec($conn,$sql);
	
	
	return $result;
}

public function repitentesCursoNotasSP($conn){
//echo "<br>".
 $sql="select round(AVG(cast(p.promedio as INT))) as promedio,p.rut_alumno
  from notas".$this->nro_ano." p
  inner join matricula m on m.rut_alumno = p.rut_alumno and m.bool_ar=0
  where id_ramo IN( select id_ramo from ramo 
  where id_curso=".$this->curso." and modo_eval=1 and bool_pgeneral=1)
  and p.promedio not in(' ','0')
  group by p.rut_alumno order by promedio desc";
//$result = @pg_exec($conn,$sql);
	
	//if($_PERFIL==0) echo $sql;
	//return $result;

}


/**************/

public function getLeccionario($conn){
$sql="select le.descripcion,le.nota,tl.nombre from lexionario le 
  inner join tipo_lexionario tl on tl.id_tipo = le.tipo
  where  le.id_curso=".$this->curso." and le.id_ramo=".$this->ramo." and nota=".$this->nota." and id_periodo=".$this->periodo;	
$result = @pg_exec($conn,$sql);
	return $result;
}


public function TotalAsistenciaDia($conn){
$sql="select count(*) from asistencia where id_curso=".$this->id_curso."and fecha='".$this->fecha."' and ano=".$this->ano;
$result = @pg_exec($conn,$sql);
	return $result;	
}


function MatriculaAsistencia_cursoN($conn){
	// echo "<br>". 
	 $sql = "SELECT count(*) FROM matricula 
	  WHERE id_ano=".$this->ano." and id_curso=".$this->id_curso." AND ((bool_ar = 0 and fecha<='".$this->fecha_fin."') or (bool_ar=1 and fecha<='".$this->fecha_fin."') ) ";
	  $sql.="and id_curso=".$this->id_curso."";
	  $result = @pg_exec($conn,$sql) or die ("SELECT FALL� (matricula asistencia curso):".$sql);
	  return $result;
	}	
	

function TraeContelAlsCurso($conn){
	   	$sql =" SELECT * ";
		$sql.=" FROM alumno INNER JOIN  matricula ON alumno.rut_alumno=matricula.rut_alumno INNER JOIN curso ON curso.id_curso=matricula.id_curso
		WHERE  matricula.id_ano=".$this->ano."  ";
		
		if($this->curso!=0){
			$sql.=" AND matricula.id_curso=".$this->curso." ";			
		}

		if($this->retirado!=""){
			$sql.=" AND bool_ar=".$this->retirado;
		}
		if(@$this->fecha!=""){
			$sql.=" AND fecha <='$this->fecha' ";
		}
		if(@$this->fechar!=""){
			$sql.=" AND matricula.fecha_retiro <'$this->fechar' ";
		}
		
		
		
		//if($_PERFIL==0) {echo "<br>".$sql;}
		
		$result =@pg_exec($conn,$sql) or die ("Select fall� (Trae Todos): " .$sql);
		return $result;
	}
	
	
//feriados curso
public function feriadoCursoNew($conn){

  $sql ="select * from feriado_curso where id_curso=".$this->curso;
$result =@pg_exec($conn,$sql); //or die ("Select fall� (Trae Todos): " .$sql);
		return $result;
}

public function feriadoCursoDIANew($conn){

 $sql ="select feriado.id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado inner join feriado_curso on feriado_curso.id_feriado=feriado.id_feriado where date_part('month',feriado.fecha_inicio)=".$this->cmbMes." and id_ano=".$this->ano."  and id_curso =".$this->curso." order by dia_ini";
$result =@pg_exec($conn,$sql) or die ("Select fall� (Trae Todos): " .$sql);
		return $result;
}	

public function feriadoCursoMesNew($conn){

 $sql =" select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado inner join feriado_curso on feriado_curso.id_feriado=feriado.id_feriado where date_part('month',feriado.fecha_inicio)=".trim($this->mes)." and and id_ano=".$this->ano." order by dia_ini;";	
$result =@pg_exec($conn,$sql) or die ("Select fall� (Trae Todos): " .$sql);

		return $result;
}

public function ensCu($conn){
	 $sql="select ensenanza,grado_curso,letra_curso from curso where id_curso=".$this->curso;
	$result =@pg_exec($conn,$sql) or die ("Select fall� (Trae Todos): " .$sql);
	return $result;
	
}

//padre en asignatura formula
public function formulaPadre($conn){
 $sql="select * from formula where id_ramo = ".$this->ramo;
$result =@pg_exec($conn,$sql) or die ("Select fall� (Trae padre formula): " .$sql);
	return $result;
}

//hijo en asignatura formula
public function formulahijo($conn){
$sql="select r.*,s.nombre from ramo r
inner join formula_hijo fh on fh.id_hijo = r.id_ramo
inner join subsector s on s.cod_subsector = r.cod_subsector where id_formula = ".$this->formula. " order by r.id_orden";
$result =@pg_exec($conn,$sql) /*or die ("Select fall� (Trae hijo formula): " .$sql)*/;
	return $result;
}

//hijo en asignatura formula
public function formulaSoyHijo($conn){
	 $sql="select * from formula_hijo where id_hijo=".$this->ramo_hijo;
$result =@pg_exec($conn,$sql) or die ("Select fall� (Trae hijo formula): " .$sql);
	return $result;
}


public function grabaCodigo($connection){
$sql="insert into codigo_verificacion (rbd,id_ano,id_base,id_curso,tipo_certificado,rut_alumno,codigo,fecha_emision,hora_emision) values($this->rdb,$this->ano,$this->id_base,$this->curso,$this->tipo_certificado,$this->alumno,'$this->codigo','$this->fecha_emision','$this->hora_emision')";
$result =@pg_exec($connection,$sql) /*or die ("Select fall� (Trae hijo formula): " .$sql)*/;
	return $result;
}

//cuenta informe nevegacio
public function catNavegacion($conn){
 $sql="select upper(n.pagina_tabla) as reporte
from navegacion n 
where n.rbd = $this->rdb
and (n.fecha BETWEEN '$this->inicio' and '$this->fin') 
group by 1
order by 1";
$result =@pg_exec($conn,$sql) or die ("Select fall� (Trae hijo formula): " .$sql);
	return $result;
}

public function catNavegacionAlu($conn){
 $sql="select count(n.*) from navegacion n 
inner join matricula ap on ap.rut_alumno = n.rut_usuario 
where n.rbd = $this->rdb and (n.fecha BETWEEN '$this->inicio' and '$this->fin')
and n.pagina_tabla = '$this->pagina'";
$result =@pg_exec($conn,$sql) or die ("Select fall� (Trae hijo formula): " .$sql);
	return $result;
}

public function catNavegacionApo($conn){
$sql="select count(n.*) from navegacion n 
inner join apoderado ap on ap.rut_apo = n.rut_usuario 
where n.rbd = $this->rdb and (n.fecha BETWEEN '$this->inicio' and '$this->fin') 
and n.pagina_tabla = '$this->pagina'";
$result =@pg_exec($conn,$sql) or die ("Select fall� (Trae hijo formula): " .$sql);
	return $result;
}


function InasistenciaDocente($conn){
		 $sql = "SELECT * FROM anotacion_empleado WHERE rut_emp = ".$this->empleado." AND tipo = ".$this->tipo." and fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."' and rdb=".$this->institucion;
		$result =@pg_exec($conn,$sql);
		return $result;
	}

function InasistenciaDocenteMesTodos($conn){
		$sql = "SELECT * FROM anotacion_empleado WHERE  tipo = ".$this->tipo." and fecha between '".$this->fecha_inicio."' and '".$this->fecha_termino."' and rdb=".$this->institucion;
		$result =@pg_exec($conn,$sql);
		return $result;
	}
	
function getCursosDictaDocente($conn){
$sql="select distinct(r.id_curso) id_curso,c.ensenanza,c.grado_curso,c.letra_curso
from ramo r
inner join dicta d on d.id_ramo = r.id_ramo
inner join curso c on c.id_curso = r.id_curso
where c.id_ano=".$this->ano." and d.rut_emp = ".$this->rut_emp." order by c.ensenanza,c.grado_curso,c.letra_curso";
$result =@pg_exec($conn,$sql) or die ("Select fall� (Trae hijo formula): " .$sql);
	return $result;
}	


//reporte pot tipo curso
//reporte pot tipo curso
function reporteTipoCurso($conn){
   $sql="select ent.*
from entrevista_alumno ent
 inner join empleado emp on emp.rut_emp = ent.rut_entrevistador
 where id_ano = $this->ano and id_curso = $this->curso 
 and tipo_entrevista = $this->tipo";
$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (conteo descarga):".$sql);
		return $result;
}

public function AlumnoInscrito2($conn){
 $sql="SELECT ramo.id_ramo,
subsector.nombre,
ramo.modo_eval, 
ramo.bool_ip,
ramo.cod_subsector, 
ramo.id_orden,
ramo.formacion, 
ramo.bool_artis,
pct_ex_semestral, 
ramo.conexper,
ramo.porc_nota_pu,
ramo.bool_pu,
ramo.porc_psintesis, 
ramo.bool_psintesis,
bool_pgeneral,
ramo.truncado,
ramo.coef2, 
ramo.sub_obli,
ramo.nota_ex_semestral,
ramo.bool_pgeneral
from ramo 
inner JOIN tiene$this->nro_ano ON (ramo.id_curso = tiene$this->nro_ano.id_curso) 
AND (ramo.id_ramo = tiene$this->nro_ano.id_ramo) 
AND (tiene$this->nro_ano.rut_alumno=$this->alumno)
inner join subsector on subsector.cod_subsector = ramo.cod_subsector
WHERE ramo.id_curso=$this->curso order by ramo.id_orden ASC";

$result = @pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);

//echo $sql;
	$fila = @pg_fetch_array($result,0);
	$this->cod_subsector = $fila['cod_subsector'];
	$this->nombre_subsector = $fila['nombre'];
	$this->id_ramo  = $fila['id_ramo'];
	$this->modo_eval = $fila['modo_eval'];
	$this->porc_examen = $fila['porc_examen'];
	$this->result =$result;
    
	//if($_PERFIL==0) echo $sql;	
	 
	return; 

}

public function AlumnoInscrito3($conn){
$sql="SELECT subsector.cod_subsector, subsector.nombre, ramo.id_ramo, ramo.modo_eval, 
ramo.conex, ramo.conexper, ramo.nota_exim,ramo.sub_obli , ramo.porc_examen, 
bool_ip,bool_pgeneral FROM ramo 
INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector 
INNER JOIN tiene$this->nro_ano on tiene$this->nro_ano.id_ramo = ramo.id_ramo 	
WHERE (((ramo.id_curso)=$this->curso)) and tiene$this->nro_ano.rut_alumno = $this->alumno and bool_ip=1 ";


	


	$sql.= "ORDER BY ramo.id_orden ";
	
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);

//echo $sql;
	$fila = @pg_fetch_array($result,0);
	$this->cod_subsector = $fila['cod_subsector'];
	$this->nombre_subsector = $fila['nombre'];
	$this->id_ramo  = $fila['id_ramo'];
	$this->modo_eval = $fila['modo_eval'];
	$this->porc_examen = $fila['porc_examen'];
	$this->result =$result;
    
	//if($_PERFIL==0) echo $sql;	
	 
	return; 
}


public function fichaMedica($conn){
	$sql="select * from ficha_medicanew3 where rut_alumno = ".$this->alumno;
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (conteo descarga):".$sql);
	return $result;
}

function fechaMatrPANO($conn){
		 $sql="SELECT fecha,fecha_retiro FROM matricula WHERE rut_alumno=".$this->alumno." AND id_ano=".$this->id_ano;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		return $result;
	}
	

public function registroSIGE($conn){
 $sql="select asistencia_sige_historia.* from asistencia_sige_historia inner join curso on curso.id_curso = asistencia_sige_historia.id_curso where rbd=$this->institucion and asistencia_sige_historia.id_ano= $this->ano and fecha_envio='$this->fecha' and tipo not in (1) order by curso.ensenanza,curso.grado_curso,curso.letra_curso,fecha_operacion,id_historia";
$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		return $result;
}

public function detalleJustificaInasistencia($conn){
$sql="select det.*,tip.nombre
from justifica_inasistencia_detalle det
inner join justifica_inasistencia_tipo tip
on tip.id_tipo = det.tipo_justificacion
where det.rut_alumno = $this->alumno
and det.id_ano = $this->ano
and det.id_curso = $this->curso
and det.fecha_desde >='$this->desde' and det.fecha_hasta <='$this->hasta'";
$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
return $result;

}

public function notDemre($conn){
$sql="select sum(p.promedio) suma_pond,count(*) total_notas from promocion p 
inner join curso c on c.id_curso = p.id_curso
where rut_alumno = $this->alumno and c.ensenanza>309
and p.situacion_final=1";
$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
return $result;
}

public function numCorp($connection){
$sql="select num_corp from corp_instit where rdb=$this->institucion;";
$result = @pg_exec($connection,$sql) or die ("SELECT FALL�: x".$sql);
$fila = @pg_fetch_array($result,0);
	$this->num_corp = $fila['num_corp'];
	return;
}

public function Director($conn){
		$sql="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$this->institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
		$fila = @pg_fetch_array($result,0);
		$this->rut_director = $fila['rut_emp'];	
		$this->nombre_director = $fila['nombre_emp']." ".$fila['ape_pat']." ".$fila['ape_mat'];	
		
		
		
		return;
	}



//lista 
public function listaCursosPorAsignatura($conn){
$sql = "select r.*
from ramo r
inner join curso c on c.id_curso = r.id_curso
where c.id_ano = $this->ano
and r.cod_subsector = $this->subsector
and c.ensenanza= $this->ensenanza
order by c.ensenanza,c.grado_curso,c.letra_curso";
  
  $result = pg_exec($conn,$sql);
  return $result;
  
}

function promedioExamenPeriodo($conn){
	 $sql = "select sum(nota_final) as suma,count(*) as contador
FROM situacion_periodo 
WHERE id_ramo=$this->ramo AND nota_final >0 AND id_periodo=$this->periodo";
  
  $result = pg_exec($conn,$sql);
  	$this->suma = @pg_result($result,0);
	$this->contador = @pg_result($result,1);
	$this->result = $result;
	return;
	}
	
	
	
//30-06-2020 ->reporte bitacora
function getListaBitacora($conn){
 $sql="select bas.*, 
basc.nombre as nombre_canal,
e.ape_pat||' '||e.ape_mat||' '||e.nombre_emp as nombre_docente,
s.nombre as nombre_ramo,
u.nombre as nombre_unidad,
o.codigo||' '||o.descripcion as nombre_objetivo,
i.descripcion as nombre_indicador,
p.nombre_periodo
from asignatura_bitacora bas 
inner join ramo r on r.id_ramo  = bas.id_ramo
inner join dicta d on d.id_ramo = r.id_ramo
inner join empleado e on e.rut_emp = d.rut_emp
inner join asignatura_bitacora_canal basc on basc.id = bas.id_canal
inner join subsector s on s.cod_subsector = r.cod_subsector
left join ct_unidad u on u.id = bas.id_unidad
left join ct_objetivo o on o.id = bas.id_objetivo
left join ct_indicador i on i.id = bas.id_indicador
inner join periodo p on p.id_periodo = bas.id_periodo
where bas.id_ramo  =$this->ramo and bas.id_periodo = $this->periodo order by fecha; 
 "; 
 $result = pg_exec($conn,$sql);
  return $result;
}

function getListaAlumnosBitacora($conn){
 $sql="select al.rut_alumno,al.ape_pat||' '||al.ape_mat||' '||al.nombre_alu as nombre_alumno
from alumno al
inner join asignatura_bitacora_alumno aba on aba.rut_alumno = al.rut_alumno
where aba.id_bitacora = $this->idbitacora order by al.ape_pat,al.ape_mat,al.nombre_alu";	
 $result = pg_exec($conn,$sql);
  return $result;
}
 
 function anosAtras($conn){
   $sql="select nro_ano from ano_escolar where id_institucion = $this->institucion and nro_ano <= $this->parte order by id_ano desc limit $this->limite ";
   
// if($_PERFIL==0){echo $sql."<br>";}
    
$result = pg_exec($conn,$sql);
  return $result;
}
function anosAtras4($conn){ 
  $sql="select id_ano,nro_ano from ano_escolar where id_institucion = $this->institucion and nro_ano < $this->parte order by nro_ano desc limit $this->limite ";
  //if($_PERFIL==0){echo $sql."<br>";}
$result = pg_exec($conn,$sql);
  return $result;
} 

 function promedioAnosAtras($conn){  
  $sql="select avg(promedio) from promocion where id_curso in(select id_curso from curso where id_ano = $this->ano and ensenanza = $this->ensenanza and grado_curso = $this->grado) ";
  
// if($_PERFIL==0){echo $sql."<br>";}
$result = pg_exec($conn,$sql);
  return $result;
}


function idAnosAtras($conn){
  $sql="select id_ano from ano_escolar where id_institucion = $this->institucion and nro_ano = $this->parte";
// if($_PERFIL==0){echo $sql."<br>";}
$result = pg_exec($conn,$sql);
  return $result;
} 
 
 function ramosSubAtras($conn){
   $sql="select id_ramo,truncado,aprox_entero,conexper,conex from ramo 
where id_curso  =".$this->curso." and cod_subsector in(".$this->ramo.") ";
$result = @pg_exec($conn,$sql);
		return $result;
}

function PromedioSubAlumnosIn($conn){
		 $sql = "SELECT promedio FROM promedio_sub_alumno WHERE id_ano=".$this->ano." AND id_curso=".$this->curso." AND id_ramo in (".$this->ramo.") AND  rut_alumno=".$this->alumno;
		
		//if($_PERFIL==0) echo $sql;		
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
function CursoPromedioSubAlumno($conn){
	  $sql = "select p.id_curso from promocion p where id_ano = $this->ano 
and rut_alumno =  $this->alumno and p.situacion_final=1";
		
		//if($_PERFIL==0) echo $sql;		
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	
 function Promedio1x($conn){
	  
	 $sql_promedio = "select promedio,notaap from  notas$this->nro_ano where id_ramo=$this->ramo  AND rut_alumno='$this->alumno'";
$resultp = @pg_exec($conn,$sql_promedio) or die ("SELECT FALLO (Promedios1):".$sql_promedio);
		return $resultp;
	  }	
	

		function Menu_Apo($conn){
		$sql="SELECT r.id_reporte, r.nombre 
FROM reporte r inner join item_reporte it on it.id_item = r.id_reporte
 where it.apoderado=1 ORDER BY 1 ASC ";
		$result =@pg_exec($conn,$sql);
		return $result;
	}
	
	
public function proConcentracion($conn){
$sql="select sum(promedio) as promedio,count(*) as cuenta from concentracion_notas where rut_alumno=$this->alumno and promedio>0 "; 
$result = @pg_exec($conn,$sql) or die ("SELECT FALL�: x".$sql);
//if ($_PERFIL==0){echo $sql;}
return $result;
}	


//armar grupos de notas porcentaje
public function TraeGrupoPorcentaje($conn){ 
	  $sql="select * from grupo_nota_ramo_porcentaje where id_ramo=".$this->ramo." and id_curso=".$this->curso." and id_periodo = $this->id_periodo order by orden";
	$result = @pg_exec($conn,$sql)/* or die("error asunto: ".$sql)*/;
			return $result;	
}	

public function TraeNotaPorc($conn){
	   $sql="select nota".$this->posicion." from porc_notas".$this->nro_ano." 
where rut_alumno=".$this->alumno." and id_ramo=".$this->ramo." and id_periodo=".$this->periodo." ";
	$result = @pg_exec($conn,$sql) /*or die("error asunto: ".$sql)*/;
			return $result;	
}

    


function NotasPorc($conn)
   { 
	 $sql="select promedio from porc_notas".$this->nro_ano." n  where n.rut_alumno=".$this->alumno." and n.id_ramo=".$this->ramo." AND id_periodo=".$this->periodo;
	
	  $result = pg_Exec($conn,$sql)/*or die("f".$sql)*/;
	  return $result;
	  	   
   }
   
 /* function NotasPorc($conn){
  	
	//COALESCE(sp.nota_final,cast(nts.promedio as INTEGER)) as  
	$sql ="SELECT nts.id_ramo,nts.id_periodo,nts.rut_alumno, 
		nts.nota1,nts.nota2,nts.nota3,nts.nota4,
		nts.nota5,nts.nota6,nts.nota7,nts.nota8,
		nts.nota9,nts.nota10,nts.nota11,nts.nota12,
		nts.nota13,nts.nota14,nts.nota15,nts.nota16,
		nts.nota17,nts.nota18,nts.nota19,nts.nota20,
		nts.promedio,
		nts.notaap
		 FROM porc_notas$this->nro_ano as nts INNER JOIN periodo p ON nts.id_periodo=p.id_periodo
		WHERE nts.id_ramo=".$this->ramo." ";
			
			if($this->periodo!=""){
				$sql.=" AND nts.id_periodo=".$this->periodo."  ";
			}
			if($this->rut_alumno!=""){
				$sql.=" AND nts.rut_alumno='".$this->rut_alumno."'";
			}
			if(@$this->opcion==1){
				$sql.=" AND nts.promedio >='".$this->prom."'";	
			}
			if(@$this->opcion==2){
				$sql.=" AND nts.promedio <='".$this->prom."'";
			}
	   
	 	 $sql.=" ORDER BY fecha_inicio ASC";
	   
		if($_PERFIL==0) echo "<br>Notas-->".$sql;
		
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (NotasPorc):".$sql);
		return $result;
		
	  }*/
	  
	  
	    function PromedioAlumnoPorc($conn){
   	$sql = "SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador,sum(cast (notaap as INTEGER)) as promedioap FROM porc_notas$this->nro_ano WHERE id_ramo in ";
	$sql.= "(SELECT id_ramo FROM ramo WHERE id_ramo in (SELECT id_ramo ";
	$sql.= " FROM notas$this->nro_ano WHERE id_periodo = '".$this->periodos."' AND rut_alumno = '".$this->alumno."') and (cod_subsector < 50000 or cod_subsector=50600 or cod_subsector=50629)";
	$sql.= " and bool_pgeneral=1 and bool_ip=1 ) AND rut_alumno = '".$this->alumno."' AND id_periodo = '".$this->periodos."' ";
	$sql.= " AND promedio NOT IN ('101')";
	//if($_PERFIL==0) echo "<br>".$sql;
	$result =@pg_exec($conn,$sql);
	$this->suma = @pg_result($result,0);
	$this->contador = @pg_result($result,1);
	$this->sumaAP = @pg_result($result,2);
	$this->result = $result;
	$this->sql = $sql;
	return;
  }
  
   function PromedioAlumnoSubNoValidoPorc($conn){
  	$sql = "SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador,sum(cast (notaap as INTEGER)) as promedioap FROM porc_notas$this->nro_ano WHERE id_ramo in ";
	$sql.= "(SELECT id_ramo FROM ramo WHERE id_ramo in (SELECT id_ramo ";
	$sql.= " FROM notas$this->nro_ano WHERE id_periodo = '".$this->periodos."' AND rut_alumno = '".$this->alumno."') ";
	$sql.= " and bool_pgeneral=1 ) AND rut_alumno = '".$this->alumno."' AND id_periodo = '".$this->periodos."' ";
	$sql.= " AND promedio NOT IN ('MB','B','S','I','0',' ','P','AL','L','NL','G','RV','N')";
	//if($_PERFIL==0) echo $sql;
	$result =@pg_exec($conn,$sql);
	$this->suma = @pg_result($result,0);
	$this->contador = @pg_result($result,1);
	$this->sumaAP = @pg_result($result,2);
	$this->result = $result;
	$this->sql = $sql;
	return;
  }
   
  
  public function rangoEscalaLogro($conn){
	   $sql="select * from escala_porcentaje where id_ano=$this->ano and ensenanza=$this->ensenanza and minimo<=$this->minimo and maximo>=$this->maximo"; 
	 $result = @pg_exec($conn,$sql) ;
		return $result;
	 }
	
	
//02-2020: formulas nuevas para reporte nem
public function getPromConcentracionByAno($conn){
$sql="select promedio from concentracion_notas where rut_alumno=$this->alumno and curso=$this->grado_curso "; 
//if ($_PERFIL==0){echo "<br>".$sql;}
$result = @pg_exec($conn,$sql) or die ("SELECT FALLo: x".$sql);

return $result; 
}	
	
public function getCursoAlumnoAnt($conn){
$sql="select c.id_curso 
from curso c
inner join matricula m on m.id_curso  = c.id_curso
where m.id_ano =$this->id_ano and rut_alumno=$this->alumno and c.ensenanza=$this->ensenanza and c.grado_curso=$this->grado_curso
and m.bool_ar=0 ";  
$result = @pg_exec($conn,$sql) or die ("SELECT FALLo: x".$sql);
//if ($_PERFIL==0){echo "<br>".$sql;}
return $result;
}

public function getNemNota($conn){
 $sql="select * from nem_notas where tipo_ense = $this->ensenanza and nota=$this->nota";
$result = @pg_exec($conn,$sql) or die ("SELECT FALLo: x".$sql);

return $result;
}
	
function anosAtrasPHI($conn){
   $sql="select nro_ano,id_ano from ano_escolar where id_institucion = $this->institucion and nro_ano < $this->parte order by nro_ano desc limit $this->limite ";
   
 //if($_PERFIL==0){echo $sql;} 
   
$result = pg_exec($conn,$sql);
  return $result;
}
	
public function getEnsenanzaEgresado($conn){
	
	$sql="select DISTINCT(c.ensenanza),te.nombre_tipo
from curso c 
inner join tipo_ensenanza te on te.cod_tipo = c.ensenanza
where id_ano = $this->ano and ensenanza >=310 order by ensenanza" ;
 //if($_PERFIL==0){echo $sql;} 
		$result = pg_exec($conn,$sql);
		return $result; 
	
}

 function anosAtrasPR($conn){
   $sql="select id_ano,nro_ano from ano_escolar where id_institucion = $this->institucion and id_ano <= $this->parte order by id_ano desc limit $this->limite ";
   
//if($_PERFIL==0){echo $sql."<br>";} 
    
$result = pg_exec($conn,$sql) or die ("SELECT FALLo: anos atras".$sql);
return $result; 
 }
	
	
	
//armar grupos de notas con periodo
public function TraeGrupoNotaPer($conn){
	 $sql="select * from grupo_nota where id_ramo=".$this->ramo." and id_curso=".$this->curso." and id_periodo=".$this->periodo." order by id_grupo";
	$result = @pg_exec($conn,$sql) or die("error asunto: ".$sql);
			return $result;	
}	
	
	
public function getEnsenanzabyCurso($conn){
  	$sql="select ensenanza from curso where id_curso=$this->idc";
	$rs = pg_exec($conn,$sql);
	$enseCurso = pg_result($rs,0);
	return $enseCurso;
}


public function idAnosAtrasNew2($conn){
  $sql="select ae.id_ano
from ano_escolar ae
inner join matricula m on m.id_ano = ae.id_ano and m.rut_alumno= $this->alumno
inner join curso c on c.id_ano = m.id_ano  and c.id_curso = m.id_curso
where ae.id_institucion =$this->institucion  and ae.nro_ano=$this->parte
 and c.grado_curso = $this->grado_curso and c.ensenanza = $this->ensenanza and m.rut_alumno= $this->alumno ";
// if($_PERFIL==0){echo $sql."<br>";}
$result = pg_exec($conn,$sql);
  return $result;
} 
 
public function getGradobyCurso($conn){
 $sql="select grado_curso from curso where id_curso=$this->curso";
$result = pg_exec($conn,$sql);
$grado = pg_result($result,0);
  return $grado; 
}	

/*Cambios 04-09-2020: Porcentajes de logro y concepto*/
public function TraeNotaGPond($conn){
	 $sql="select nota".$this->posicion." from notaponderacion".$this->nro_ano." 
where rut_alumno=".$this->alumno." and id_ramo=".$this->ramo." and id_periodo=".$this->periodo." and nota".$this->posicion."!='101'";
	$result = @pg_exec($conn,$sql) or die("error asunto: ".$sql);
			return $result;	
}

 function PromedioRamoAlumnoPeriodoGPond($conn)
   {
	  $sql="select promedio from notaponderacion".$this->nro_ano." n where n.rut_alumno=".$this->alumno." and n.id_ramo=".$this->ramo." and  n.id_periodo=".$this->periodo." and promedio is not null and promedio!='101' ";
	
	  $result = pg_Exec($conn,$sql)or die("f".$sql);
	  $result = pg_result($result,0);
	  return $result;
	  	   
   }
   
   
   function getConcEscalaPorcentaje($conn){
	//si viene todo
	$sql="select concepto from escala_porcentaje where id_ano=$this->ano and id_periodo = $this->idp and minimo<=$this->pminimo and maximo>=$this->pmaximo and ensenanza = $this->ense and nivel=$this->nivel and cod_subsector = $this->subs";
	
	$result = pg_Exec($conn,$sql)/*or die("f".$sql)*/;
	
	//periodo =0
		if(pg_numrows($result)==0){
			$sql="select concepto from escala_porcentaje where id_ano=$this->ano and id_periodo = 0 and minimo<=$this->pminimo and maximo>=$this->pmaximo and ensenanza = $this->ense and nivel=$this->nivel and cod_subsector = $this->subs";
		
		$result = pg_Exec($conn,$sql)/*or die("f".$sql)*/;
		
		//ensenanza=0
				if(pg_numrows($result)==0){
				$sql="select concepto from escala_porcentaje where id_ano=$this->ano and id_periodo = 0 and minimo<=$this->pminimo and maximo>=$this->pmaximo and ensenanza = 0 and nivel=$this->nivel and cod_subsector = $this->subs";
			
			$result = pg_Exec($conn,$sql)/*or die("f".$sql)*/;
			//nivel=0
			if(pg_numrows($result)==0){
					$sql="select concepto from escala_porcentaje where id_ano=$this->ano and id_periodo = 0 and minimo<=$this->pminimo and maximo>=$this->pmaximo and ensenanza = 0 and nivel=0 and cod_subsector = $this->subs";
				
				$result = pg_Exec($conn,$sql)/*or die("f".$sql)*/;
				//subsector=0
					if(pg_numrows($result)==0){
						$sql="select concepto from escala_porcentaje where id_ano=$this->ano and id_periodo = 0 and minimo<=$this->pminimo and maximo>=$this->pmaximo and ensenanza = 0 and nivel=0 and cod_subsector = 0";
					
					$result = pg_Exec($conn,$sql)/*or die("f".$sql)*/;
					}
				
				}
			 
			}
		
		
		
		}
	
	//if($_PERFIL==0){echo $sql;}
//	echo $sql;
	 $result = pg_result($result,0);
	  return $result;
	}
	
 function getEscalaPorcentaje($conn){
	//si viene todo
	$sql="select * from escala_porcentaje where id_ano=$this->ano and id_periodo = $this->idp and ensenanza = $this->ense and nivel=$this->nivel and cod_subsector = $this->subs order by orden";
	
	$result = pg_Exec($conn,$sql)or die("f".$sql);
	
	//periodo =0
		if(pg_numrows($result)==0){
			$sql="select * from escala_porcentaje where id_ano=$this->ano and id_periodo = 0  and ensenanza = $this->ense and nivel=$this->nivel and cod_subsector = $this->subs order by orden";
		
		$result = pg_Exec($conn,$sql)or die("f".$sql);
		
		//ensenanza=0
				if(pg_numrows($result)==0){
				$sql="select * from escala_porcentaje where id_ano=$this->ano and id_periodo = 0   and ensenanza = 0 and nivel=$this->nivel and cod_subsector = $this->subs order by orden";
			
			$result = pg_Exec($conn,$sql)or die("f".$sql);
			//nivel=0
			if(pg_numrows($result)==0){
					$sql="select * from escala_porcentaje where id_ano=$this->ano and id_periodo = 0  and ensenanza = 0 and nivel=0 and cod_subsector = $this->subs order by orden";
				
				$result = pg_Exec($conn,$sql)or die("f".$sql);
				//subsector=0
					if(pg_numrows($result)==0){
						$sql="select * from escala_porcentaje where id_ano=$this->ano and id_periodo = 0  and ensenanza = 0 and nivel=0 and cod_subsector = 0 order by orden";
					
					$result = pg_Exec($conn,$sql)or die("f".$sql);
					}
				
				}
			 
			}
		
		
		
		}
	

	//echo $sql;
	  return $result;
	}
	
}//fin clase 


?>

