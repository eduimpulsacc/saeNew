<? /*require "../../../../util/connect.php";*/

class MotorBusqueda{

	var $ano; 			
	var $institucion;	
		
	function periodo($conn){
		$sql_peri = "select * from periodo where id_ano = '$this->ano' order by nombre_periodo asc";
		$result_peri = pg_exec($conn,$sql_peri) or die ("Select falló: " .$sql);
		return $result_peri;
	   }
	
	
	function curso($conn){
		
		/*$sql="SELECT * FROM perfil_curso WHERE rdb=".$this->rdb." AND id_perfil=".$this->perfil."";
		if($this->perfil!=0){
			$sql.=" AND rut_emp=".$this->usuario;
		}
		//echo $sql;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		
		if(pg_num_rows($rs_acceso)!=0 && $this->perfil!=0){
			$whe_perfil_curso=" AND curso.ensenanza=".pg_result($rs_acceso,3)." AND grado_curso in(";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['grado_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['grado_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}*/
	  	$sql_curso= "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
		$sql_curso.= "curso.ensenanza, curso.cod_decreto ";
		$sql_curso.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql_curso.= "WHERE (((curso.id_ano)=".$this->ano.")) ";
		if($this->grado!=""){
			$sql_curso.= " AND ensenanza>110 AND grado_curso=".$this->grado." ";
		}
		if($this->perfil==17){
			$sql_curso.= " AND id_curso=".$this->curso."";	
		}/*else if(pg_num_rows($rs_acceso)!=0 || $this->perfil!=0){
			$sql_curso.= $whe_perfil_curso;
		}*/
		
		 $sql_curso.= " ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
		$resultado_curso = pg_exec($conn,$sql_curso) or die ("Select falló: " .$sql_curso);
		return $resultado_curso;

	}
	
	function curso2($conn){
		
		$sql="SELECT * FROM perfil_curso WHERE rdb=".$this->rdb." AND id_perfil=".$this->perfil."";
		if($this->perfil!=0){
			$sql.=" AND rut_emp=".$this->usuario;
		}
		//echo $sql;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		
		if(pg_num_rows($rs_acceso)!=0 && $this->perfil!=0){
			$whe_perfil_curso=" AND id_curso in(";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['id_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['id_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}
	  	$sql_curso= "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
		$sql_curso.= "curso.ensenanza, curso.cod_decreto ";
		$sql_curso.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql_curso.= "WHERE (((curso.id_ano)=".$this->ano.")) ";
		if($this->grado!=""){
			$sql_curso.= " AND ensenanza>110 AND grado_curso=".$this->grado." ";
		}
		if($this->perfil==17){
			$sql_curso.= " AND id_curso=".$this->curso."";	
		}else if(pg_num_rows($rs_acceso)!=0 || $this->perfil!=0){
			$sql_curso.= $whe_perfil_curso;
		}
		
		$sql_curso.= " ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
		$resultado_curso = pg_exec($conn,$sql_curso) or die ("Select falló: " .$sql_curso);
		return $resultado_curso;

	}
	
	
	function cursoConNotas($conn){
	 	/*$sql_curso = "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
		$sql_curso.= "curso.ensenanza, curso.cod_decreto ";
		$sql_curso.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql_curso.= "WHERE (((curso.id_ano)=".$this->ano.")) ";
		$sql_curso.= " AND ensenanza>=110  ";
		$sql_curso.= "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";*/
		$sql="SELECT * FROM perfil_curso WHERE rdb=".$this->rdb." AND id_perfil=".$this->perfil."";
		if($this->perfil!=0){
			$sql.=" AND rut_emp=".$this->usuario;
		}
		//echo $sql;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		
		if(pg_num_rows($rs_acceso)!=0 && $this->perfil!=0){
			$whe_perfil_curso=" AND grado_curso in(";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['grado_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['grado_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}
	  	$sql_curso= "SELECT DISTINCT curso.id_curso, curso.grado_curso,curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
		$sql_curso.= "curso.ensenanza, curso.cod_decreto ";
		$sql_curso.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql_curso.= "WHERE (((curso.id_ano)=".$this->ano.")) AND ensenanza>=110 ";
		if($this->grado!=""){
			$sql_curso.= "  AND grado_curso=".$this->grado." ";
		}
		if($this->perfil==17){
			$sql_curso.= " AND id_curso=".$this->curso."";	
		}else if(pg_num_rows($rs_acceso)!=0 || $this->perfil!=0){
			$sql_curso.= $whe_perfil_curso;
		}
		
		$sql_curso.= " ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
		$resultado_curso = pg_exec($conn,$sql_curso) or die ("Select falló: " .$sql_curso);
		return $resultado_curso;

	}
	
	function curso_ensenanza($conn){
	  	$sql_curso = "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
		$sql_curso.= "curso.ensenanza, curso.cod_decreto ";
		$sql_curso.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql_curso.= "WHERE curso.id_ano=".$this->ano." and curso.ensenanza in(".$this->Ensenanza.") ";
		$sql_curso.= "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
		$resultado_curso = pg_exec($conn,$sql_curso) or die ("Select falló: " .$sql);
		
		//echo $sql_curso;
		return $resultado_curso;

	}
	
	
	
	
	function curso22($conn){
		
		
	  	$sql_curso= "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
		$sql_curso.= "curso.ensenanza, curso.cod_decreto ";
		$sql_curso.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql_curso.= "WHERE (((curso.id_ano)=".$this->ano.")) ";
		
			$sql_curso.= " AND ensenanza>10  ";
		
		$sql_curso.= " ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
		$resultado_curso = pg_exec($conn,$sql_curso) or die ("Select falló: " .$sql_curso);
		return $resultado_curso;

	}
	
	
	function alumno($conn){
	    
	if ($this->ano > 0){		
	$sql =" select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,case 
WHEN (SUBSTRING(upper(ALUMNO.ape_pat),1,1)='Á') THEN REPLACE(upper(ALUMNO.ape_pat),'Á','A') 
WHEN (SUBSTRING(upper(ALUMNO.ape_pat),1,1)='É') THEN REPLACE(upper(ALUMNO.ape_pat),'É','E') 
WHEN (SUBSTRING(upper(ALUMNO.ape_pat),1,1)='Í') THEN REPLACE(upper(ALUMNO.ape_pat),'Í','I') 
WHEN (SUBSTRING(upper(ALUMNO.ape_pat),1,1)='Ó') THEN REPLACE(upper(ALUMNO.ape_pat),'Ó','O') 
WHEN (SUBSTRING(upper(ALUMNO.ape_pat),1,1)='Ú') THEN REPLACE(upper(ALUMNO.ape_pat),'Ú','U')
ELSE upper(ALUMNO.ape_pat) END AS ORD from matricula, alumno ";
	$sql.=" where matricula.id_ano = ".$this->ano."  and  id_curso = ".$this->cmb_curso. " and matricula.rut_alumno = 	
			alumno.rut_alumno and bool_ar=0 ";
			//$sql.=" order by ape_pat,ape_mat, nombre_alu";
			$sql.=" order by ord";
		
		}else{
		$sql =" select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu from matricula, alumno ";
		$sql.=" where id_curso = ".$this->cmb_curso. "  AND matricula.rdb=".$this->rdb." ";
		if($this->retirado!=1){
			$sql.=" AND bool_ar=0 ";
		}
		$sql.="and matricula.rut_alumno = alumno.rut_alumno order by ord ";
		/*$sql.=" ape_mat, nombre_alu";	*/
		}	
	//echo $sql;	
		$result= pg_exec($conn,$sql);
		return $result;
	}
	
	
	function Sigla($conn){
		$sql  ="SELECT sigla FROM grado_nombre WHERE cod_decreto=".$this->decreto." AND grado_curso=".$this->grado."";
		$rs_sigla = @pg_exec($conn,$sql) or die ("Select falló: " .$sql);
		$this->sigla = @pg_result($rs_sigla,0);
		return;
	}
	
	
	function Comuna($conn){
		$sql = "SELECT * FROM comuna order by nom_com asc ";
		$result = pg_exec($conn,$sql) or die ("Select fallo:" . $sql);
		return $result;
	
	}
	
	
	function Ensenanza($conn){
		$sql = "SELECT tipo_ensenanza.nombre_tipo, curso.ensenanza ";
		$sql.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql.= "WHERE (((curso.id_ano)=".$this->ano.")) ";
		$sql.= "GROUP BY tipo_ensenanza.nombre_tipo, curso.ensenanza ";
		$sql.= "ORDER BY curso.ensenanza ";
				
		$result = pg_exec($conn,$sql) or die ("Select falló:".$sql);
		return $result;
	}
	
	
	function ListaEmpleado($conn){
		$sql = "SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, 
		empleado.ape_mat,  	
		trabaja.cargo ";
		$sql.= "FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON ";
		$sql.= "trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$this->institucion.")) order by ape_pat, 
		ape_mat, nombre_emp 
		asc, trabaja.cargo";
		
		$result= @pg_exec($conn,$sql) or die ("Select falló: " .$sql);
		return $result;
	}
	
	function ListaEmpleadoNOCARGO($conn){
		$sql = "select distinct(em.rut_emp),
			em.nombre_emp||' '|| em.ape_pat as nombre_emp 
			from trabaja su inner join empleado em ON em.rut_emp=su.rut_emp
			 where rdb=".$this->institucion." order by 2";
		
		$result= @pg_exec($conn,$sql) or die ("Select falló: " .$sql);
		return $result;
	}
	
	
	function Subsector($conn){
		$sql = "SELECT ramo.id_ramo, subsector.nombre, ramo.cod_subsector FROM ramo,subsector ";
		$sql.= "WHERE id_curso = ".$this->curso." AND ramo.cod_subsector = subsector.cod_subsector ORDER BY id_orden  
		ASC";
		//echo $sql;
		$result = pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
		return $result;
	}
	
	function Subsector_conceptual($conn){
		$sql = "SELECT ramo.id_ramo, subsector.nombre, ramo.cod_subsector FROM ramo,subsector ";
		$sql.= "WHERE id_curso = ".$this->curso." AND ramo.cod_subsector = subsector.cod_subsector and modo_eval=3 ORDER BY id_orden  
		ASC";
		$result = pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
		return $result;
	}
	
	function Certificado($conn){
		$sql =" SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, 
		curso.ensenanza, 
		curso.cod_decreto ";
		$sql.=" FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE 
		(((curso.id_ano)=".$this->ano.")) 
		";
		$sql.=" AND (( (curso.grado_curso=8) and (curso.ensenanza=110)) OR ((curso.grado_curso<5) and (curso.ensenanza<>
		110)) OR  ";
		$sql.=" (ensenanza = 10) )ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso ";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		return $result; 
	}
	
	function Ano($conn){
		
		  $sql ="SELECT a.ano_anterior,a.fecha_inicio,a.fecha_termino,a.id_ano,
				a.id_institucion,a.nro_ano,a.situacion,a.tipo_regimen 
				FROM ano_escolar a 
				WHERE id_institucion = ".$this->rdb." ORDER BY a.nro_ano desc";
	    $result = @pg_exec($conn,$sql) or die ("SELECT FALLO (Ano):".$sql) ;
		return $result ;
		
	}
	
	function ano_escolar($conn){
		
	$sql="select * from ano_escolar an where an.id_institucion=".$this->rdb." order by an.nro_ano desc;";
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (ano_escolar):".$sql);
		return $result;
		}
		
		function ano_12($conn){
		
	$sql="select * from ano_escolar an where an.id_ano=".$this->ano." ;";
	$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (ano_escolar):".$sql);
		return $result;
		}
	
	
	function EstadoPractica($conn){
		$sql = "SELECT cod_estado, nombre_estado FROM estado_practica ORDER BY nombre_estado ASC";
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (EstadoPractica):".$sql);
		return $result;
		
	}
	
	
	function SubsectorInstitucion($conn){
		$sql ="SELECT distinct a.cod_subsector, b.nombre FROM ramo a INNER JOIN subsector b ON 
		a.cod_subsector=b.cod_subsector INNER JOIN 
		curso c ON ";
		$sql.=" a.id_curso=c.id_curso WHERE id_ano=".$this->ano;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLO (subsectorInstitucion):".$sql);
		return $result;

	}
	
	
	function SectorEconomico($conn){
		$sql =" SELECT a.cod_sector,b.nombre_sector FROM curso a INNER JOIN sector_eco b ON a.cod_sector=b.cod_sector 
		WHERE id_ano=".$this
		->ano." and a.cod_sector>0";
		$result = @pg_exec($conn,$sql) or die("SELECT FALLÓ (SectorEconomico):".$sql);
		return $result;
	}
	
	
	function Especialidad($conn){
		$sql ="SELECT b.cod_esp,b.nombre_esp FROM curso a INNER JOIN especialidad b ON a.cod_rama=b.cod_rama AND 
		a.cod_sector=b.cod_sector 		and a.cod_es=b.cod_esp ";
		$sql.="WHERE id_ano=".$this->ano." AND a.cod_sector=".$this->sector;
		$result = @pg_exec($conn,$sql) or die("SELECT FALLÓ (Especialidad):".$sql);
		return $result;
	}
	
	function Ciclos($conn){
		$sql="SELECT id_ciclo,nomb_ciclo FROM ciclo_conf WHERE rdb=".$this->rdb." AND id_ano=".$this->ano;	
		$result = pg_exec($conn,$sql) or die("SELECT FALLO : ".$sql);
		
		return $result;
	}
	
	function Nivel($conn){
		$sql="SELECT id_nivel,nombre FROM niveles";
		$result = pg_exec($conn,$sql) or die("SELECT FALLO : ".$sql);
		
		return $result;
	}
	
	function Sector($conn){
		$sql="SELECT id_sector, nombre_sector FROM sector_rdb WHERE rdb=".$this->rdb;
		$result = pg_exec($conn,$sql) or die("SELECT FALLO : ".$sql);
		
		return $result;	
	}
	
	function SubsectorNivel($conn){
		$sql="SELECT DISTINCT s.cod_subsector,s.nombre ";
		$sql.=" FROM ramo r INNER JOIN subsector s ON r.cod_subsector=s.cod_subsector ";
		$sql.=" INNER JOIN curso c ON c.id_curso=r.id_curso ";
		$sql.=" INNER JOIN niveles n ON n.id_nivel=c.id_nivel AND n.id_nivel=".$this->nivel;
		$sql.=" WHERE c.id_ano=".$this->ano." ORDER BY nombre ASC";
		$result = pg_exec($conn,$sql) or die("SELECT FALLO : ".$sql);
		
		return $result;	
	}
	
	function SubsectorCiclo($conn){
		$sql="SELECT DISTINCT s.cod_subsector,s.nombre
FROM ramo r 
INNER JOIN subsector s ON r.cod_subsector=s.cod_subsector
INNER JOIN curso c ON r.id_curso=c.id_curso
INNER JOIN ciclos cl ON c.id_curso=cl.id_curso
WHERE c.id_ano=".$this->ano." AND id_ciclo=".$this->ciclo."
ORDER BY 2 ASC";
		$result = pg_exec($conn,$sql) or die("SELECT FALLO : ".$sql);
		
		return $result;	
	
	}
	
	function SubsectorInstitucion2($conn){
		$sql="SELECT DISTINCT s.nombre,cod_subsector 
FROM subsector s
WHERE cod_subsector in (SELECT cod_subsector FROM ramo r INNER JOIN curso c ON r.id_curso=c.id_curso
INNER JOIN ano_escolar ae ON ae.id_ano=c.id_ano WHERE id_institucion=".$this->rdb.") ORDER BY nombre ASC";
	$result = pg_exec($conn,$sql) or die ("SELECT FALLO: ".$sql);
	
	return $result;
	}
	
	
	function Patologia($conn){
		$sql="SELECT id_patologia, nombre FROM enfermeria_patologia WHERE rdb=".$this->rdb;
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
		
	}
	
	
	 function traeDocente($conn){
	  $sql="select * from empleado inner join trabaja on trabaja.rut_emp=empleado.rut_emp and trabaja.cargo=5 AND trabaja.rdb=".$this->rdb." order by ape_pat,ape_mat,nombre_emp asc";	
		
	$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
	
	}
	
	function gradosDist($conn){
		 $sql="SELECT curso.grado_curso, curso.ensenanza,tipo_ensenanza.nombre_tipo FROM curso
inner join tipo_ensenanza on tipo_ensenanza.cod_tipo = curso.ensenanza 
WHERE curso.id_ano=$this->ano and curso.ensenanza > 10
GROUP BY curso.grado_curso, curso.ensenanza,tipo_ensenanza.nombre_tipo 
ORDER BY curso.ensenanza,curso.grado_curso
";
				
		$result = pg_exec($conn,$sql) or die ("Select falló:".$sql);
		return $result;
	}
	
	function areaPei($conn){
	$sql="select * from pei_area_evaluacion where rdb=$this->rdb";
	$result = pg_exec($conn,$sql) or die ("Select falló:".$sql);
		return $result;	
	}
	
	
function EnsenanzaNotas($conn){
	$sql="select DISTINCT te.cod_tipo,te.nombre_tipo from tipo_ense_inst tei INNER JOIN tipo_ensenanza te ON tei.cod_tipo=te.cod_tipo
WHERE rdb=".$this->institucion." and te.cod_tipo>10 order by te.cod_tipo";
	$result = pg_exec($conn,$sql);
	
	return $result;
} 

function cursos4m($conn){
   $sql="select id_curso from curso where id_ano = ".$this->ano." and ensenanza >= ".$this->ensenanza." and grado_curso =".$this->grado."order by ensenanza, grado_curso,letra_curso"; 
$result = pg_exec($conn,$sql);
	
	return $result;
}

function cursos4m2($conn){
    $sql="select id_curso from curso where id_ano = ".$this->ano." and ensenanza in( ".$this->Ensenanza.") and grado_curso =".$this->grado."order by ensenanza, grado_curso,letra_curso"; 
$result = pg_exec($conn,$sql);
	
	return $result;
}

function cursos4m2B($conn){
   $sql="select id_curso from curso where id_ano = ".$this->ano." and ensenanza in( ".$this->Ensenanza.") and grado_curso =".$this->grado."order by ensenanza, grado_curso,letra_curso"; 
$result = pg_exec($conn,$sql);
	
	return $result;
}
}//fin clase

?>