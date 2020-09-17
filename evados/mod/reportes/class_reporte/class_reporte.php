<? 
session_start();

require "../../../class/Coneccion.class.php";
	   
class Reporte{

 public $Conec;

//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 

	public function Membrete($rdb){
		$sql ="SELECT nombre_instit, telefono,calle ||' '|| nro as direc, nom_reg,rdb  FROM institucion INNER JOIN region ON institucion.region=region.cod_reg WHERE rdb=".$rdb;
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		$fila = pg_fetch_array($result,0);
		$this->nombre_instit 	= pg_result($result,0);
		$this->telefono 		= pg_result($result,1);
		$this->direc 			= pg_result($result,2);
		$this->region 			= pg_result($result,3);
		return $fila;
	}
	
	public function Director($rdb){
		$sql="SELECT nombre_emp ||' '|| ape_pat ||' '|| ape_mat as director FROM empleado INNER JOIN trabaja ON empleado.rut_emp=trabaja.rut_emp WHERE rdb=".$rdb." and cargo=1";	
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		$fila = pg_fetch_array($result,0);
		
		return $fila;
	}
	
	public function PuntajeOptimo($plantilla,$periodo){
		$sql="SELECT SUM(valor) as optimo FROM  evados.eva_cierre_concepto ecc WHERE ecc.id_plantilla=".$plantilla." AND  ecc.id_periodo=".$periodo." and ecc.id_concepto=10";
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);

		return $optimo;
	}
	
	public function Concepto($nacional){
		$sql="SELECT id_concepto,sigla FROM evados.eva_concepto WHERE estado=1 and id_nacional=".$nacional." order by orden ASC";
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);

		return $result;
	}
	
	public function Bloque(){
		$sql="SELECT *  FROM evados.eva_bloque WHERE estado=1 ORDER BY nombre ASC";
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);

		return $result;
	}
	
	public function ResultadoConcepto($ano,$periodo,$plantilla,$rut,$bloque,$concepto,$nacional){
		
		$sql_a = "select nro_ano from evados.eva_ano_escolar where id_ano=$ano";
		$rs_ano = pg_exec($this->Conec->conectar(),$sql_a) or die ("Select falló : ".$sql_a);
		$annio = pg_result($rs_ano,0);
		
		$sql="SELECT id_cierre FROM evados.eva_cierre WHERE estado=1 AND id_nacional=".$nacional;
		//$sql="SELECT id_cierre FROM evados.eva_cierre WHERE nro_ano=$annio";
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		$cierre = pg_result($result,0);
		
		$sql="SELECT valor,ece.id_concepto FROM evados.eva_cierre_evaluado ece WHERE id_ano=".$ano." AND id_plantilla=".$plantilla." AND id_periodo=".$periodo." AND rut_evaluado=".$rut." and id_bloque=".$bloque." AND id_cierre=".$cierre." AND id_concepto=".$concepto." ORDER BY id_concepto ASC	";
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);

		return $result;
	}
	public function PuntajeObtenido($ano,$periodo,$plantilla,$rut){
		
		$sql_a = "select nro_ano from evados.eva_ano_escolar where id_ano=$ano";
		$rs_ano = pg_exec($this->Conec->conectar(),$sql_a) or die ("Select falló : ".$sql_a);
		$annio = pg_result($rs_ano,0);
		
		//$sql="SELECT id_cierre FROM evados.eva_cierre WHERE estado=1";
		$sql="SELECT id_cierre FROM evados.eva_cierre WHERE nro_ano=$annio";
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		$cierre = pg_result($result,0);
		
		  $sql="SELECT ecef.sumatoria,ecef.total_concepto,ecef.porcentaje,ecef.evaluacion_final,ecef.valor_final FROM evados.eva_cierre_evaluado_final ecef WHERE ecef.id_ano=".$ano." AND ecef.id_periodo=".$periodo." AND ecef.rut_evaluado=".$rut." AND ecef.id_plantilla=".$plantilla." AND id_cierre=".$cierre;
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		$fila = pg_fetch_array($result,0);		
		return $fila;
		
		
		
	}
	
	public function CantidadEvaluaciones($ano,$periodo,$rut,$cargo){
		$sql="select * from evados.eva_relacion_evaluacion ere where ere.rut_evaluado=".$rut." and ere.id_ano=".$ano." AND ere.id_periodo=".$periodo." AND ere.cargo_evaluado=".$cargo;
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);

		return $result;
		
	}
	public function Empleado($rut,$ano){
		$sql="SELECT nombre_emp ||' '|| ape_pat ||' '|| ape_mat as empleado,1 as docente FROM empleado INNER JOIN supervisa ON empleado.rut_emp=supervisa.rut_emp INNER JOIN curso ON curso.id_curso=supervisa.id_curso WHERE empleado.rut_emp=".$rut." AND id_ano=".$ano; 
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		if(pg_numrows($result)==0){
			$sql="SELECT DISTINCT nombre_emp ||' '|| ape_pat ||' '|| ape_mat as empleado,2  as docente FROM empleado INNER JOIN dicta ON empleado.rut_emp=dicta.rut_emp  INNER JOIN ramo ON ramo.id_ramo=dicta.id_ramo INNER JOIN curso ON curso.id_curso=ramo.id_curso WHERE empleado.rut_emp=".$rut."  AND id_ano=".$ano; 
			$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		}
		if(pg_numrows($result)==0){
			$sql="SELECT nombre_emp ||' '|| ape_pat ||' '|| ape_mat as empleado, 0 as docente FROM empleado  WHERE rut_emp=".$rut;		
			$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		}
		//echo $sql;
		$fila = pg_fetch_array($result,0);
		
		return $fila;
	} 
	
	public function Dimension($pauta,$docente,$ano){
		
	 $sql="select DISTINCT epa.id_area,epa.nombre
FROM evados.eva_cierre_dimension_final ecdf 
INNER JOIN evados.eva_plantilla_area epa ON ecdf.id_area=epa.id_area
INNER JOIN evados.eva_cierre ec ON ecdf.id_cierre=ec.id_cierre
WHERE  ecdf.rut_evaluado=".$docente." AND ecdf.id_plantilla=".$pauta." AND ecdf.id_area<>22 
AND ecdf.id_ano=".$ano."
ORDER BY epa.id_area DESC";

//ec.estado=1 AND
/*		if($docente==1 or $docente==0){
		echo "1--->".$sql="select DISTINCT eib.id_area,epa.nombre from evados.eva_item_bloque eib INNER JOIN evados.eva_plantilla_area epa ON eib.id_area=epa.id_area WHERE eib.id_plantilla=".$pauta." and  epa.id_area<>22";
		}else{
		echo "2--->".$sql="select DISTINCT eib.id_area,epa.nombre from evados.eva_item_bloque eib INNER JOIN evados.eva_plantilla_area epa ON eib.id_area=epa.id_area WHERE eib.id_plantilla=".$pauta." and  epa.id_area not in(22,24)";
		}*/

		//$sql="select DISTINCT eib.id_area,epa.nombre from evados.eva_item_bloque eib INNER JOIN evados.eva_plantilla_area epa ON eib.id_area=epa.id_area WHERE eib.id_plantilla=".$pauta." and  epa.id_area<>22";
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		$fila = pg_fetch_array($result,0);
		
		return $result;
	}
	
	public function Escala($rut,$plantilla,$ano,$periodo,$area){
		$sql="SELECT count(*) as contador FROM evados.eva_plantilla_evaluacion epe  INNER JOIN evados.eva_plantilla_area epa ON epe.id_area=epa.id_area INNER JOIN evados.eva_concepto ec ON ec.id_concepto=epe.id_concepto WHERE rut_evaluado=".$rut." and epe.id_plantilla=".$plantilla." and id_ano=".$ano." AND epe.ip_periodo=".$periodo." and epe.id_area=".$area;
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		$total_evaluacion = pg_result($result,0);
		
		
		$sql ="SELECT count(*) as contador FROM evados.eva_plantilla_evaluacion epe INNER JOIN evados.eva_plantilla_area epa ON epe.id_area=epa.id_area INNER JOIN evados.eva_concepto ec ON ec.id_concepto=epe.id_concepto WHERE rut_evaluado=".$rut." and epe.id_plantilla=".$plantilla." and id_ano=".$ano." AND epe.ip_periodo=".$periodo." AND ec.id_concepto in (10,12) AND epe.id_area=".$area."";
		$result =pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		$categoria = pg_result($result,0);
		
		$porc_categoria = round(($categoria * 100 )/ $total_evaluacion);
		
		if($porc_categoria>=90 and $porc_categoria<=100){
				echo "DESTACADO";
		}elseif($porc_categoria>=75 and $porc_categoria<=89){
				echo "COMPETENTE";
		}elseif($porc_categoria>=60 and $porc_categoria<=74){
				echo "BÁSICO";
		}else{
			echo "INSATISFACTORIO";	
		}
		/*echo $sql ="select count(*) as contador,ec.categoria,epa.nombre,epe.id_area from evados.eva_plantilla_evaluacion epe  INNER JOIN evados.eva_plantilla_area epa ON epe.id_area=epa.id_area INNER JOIN evados.eva_concepto ec ON ec.id_concepto=epe.id_concepto where rut_evaluado=".$rut." and epe.id_plantilla=".$plantilla." and id_ano=".$ano." AND epe.ip_periodo=".$periodo." AND epe.id_area=".$area." GROUP BY ec.categoria,epe.id_area,epa.nombre ORDER BY epe.id_area,contador DESC LIMIT 1 OFFSET 0";		
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		$fila = pg_fetch_array($result,0);
		
		return $fila;*/
	}
	
	public function Dimension_Destacada($rut,$plantilla,$ano,$periodo,$nacional){
		$sql ="select count(*) as contador,ec.categoria,epa.nombre,epe.id_item from evados.eva_plantilla_evaluacion epe  INNER JOIN evados.eva_plantilla_item epa ON epe.id_item=epa.id_item INNER JOIN evados.eva_concepto ec ON ec.id_concepto=epe.id_concepto where rut_evaluado=".$rut." and epe.id_plantilla=".$plantilla." and id_ano=".$ano." AND epe.ip_periodo=".$periodo." AND ec.id_concepto in (select id_concepto from evados.eva_concepto where id_nacional=".$nacional." and optimo=1)  GROUP BY ec.categoria,epe.id_item,epa.nombre ORDER BY contador DESC LIMIT 3 OFFSET 0	";
		$result= pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		$fila = pg_fetch_array($result,0);
		
		return $result;
		
	}
	
	public function Dimension_Insatisfactoria($rut,$plantilla,$ano,$periodo,$nacional){
		$sql ="select count(*) as contador,ec.categoria,epa.nombre,epe.id_item from evados.eva_plantilla_evaluacion epe  INNER JOIN evados.eva_plantilla_item epa ON epe.id_item=epa.id_item INNER JOIN evados.eva_concepto ec ON ec.id_concepto=epe.id_concepto where rut_evaluado=".$rut." and epe.id_plantilla=".$plantilla." and id_ano=".$ano." AND epe.ip_periodo=".$periodo." AND ec.id_concepto in (select id_concepto from evados.eva_concepto where id_nacional=".$nacional." and optimo=2)  GROUP BY ec.categoria,epe.id_item,epa.nombre ORDER BY contador DESC LIMIT 3 OFFSET 0	";
		$rs_destacado= pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		for($i=0;$i<pg_numrows($rs_destacado);$i++){
			$fila = pg_fetch_array($rs_destacado,$i);
			$destacado[$i] =  $fila['id_item'];
		}
		if(pg_numrows($rs_destacado)==0){
			$variab="";	
		}else{
			$variab="AND epe.id_item not in (".$destacado[0]."";
			
			if($destacado[1]!=""){
				$variab.=",".$destacado[1]."";
			}
			if($destacado[2]!=""){
				$variab.=",".$destacado[2]." ";
			}
			$variab.=")";
		}
		$sql ="select count(*) as contador,ec.categoria,epa.nombre,epe.id_item from evados.eva_plantilla_evaluacion epe  INNER JOIN evados.eva_plantilla_item epa ON epe.id_item=epa.id_item INNER JOIN evados.eva_concepto ec ON ec.id_concepto=epe.id_concepto where rut_evaluado=".$rut." and epe.id_plantilla=".$plantilla." and id_ano=".$ano." AND epe.ip_periodo=".$periodo." AND ec.id_concepto in(select id_concepto FROM evados.eva_concepto WHERE id_nacional=".$nacional." AND optimo=2)    GROUP BY ec.categoria,epe.id_item,epa.nombre ORDER BY contador DESC LIMIT 3 OFFSET 0	";
		$result= pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		$fila = pg_fetch_array($result,0);
		
		
		return $result;
		
	}
	
	public function Evaluacion_Final_New($rut,$plantilla,$ano,$periodo){
		
		$sql_a = "select nro_ano from evados.eva_ano_escolar where id_ano=$ano";
		$rs_ano = pg_exec($this->Conec->conectar(),$sql_a) or die ("Select falló : ".$sql_a);
		$annio = pg_result($rs_ano,0);
		
		//$sql="SELECT id_cierre FROM evados.eva_cierre WHERE estado=1";
		$sql="SELECT id_cierre FROM evados.eva_cierre WHERE nro_ano=$annio";
		$rs_cierre = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		$cierre = pg_result($rs_cierre,0);
		
		$sql="SELECT sumatoria,total_concepto,valor_final,evaluacion_final,porcentaje
				FROM evados.eva_cierre_evaluado_final ecef 
				WHERE ecef.id_cierre=".$cierre." AND ecef.id_ano=".$ano." AND id_periodo=".$periodo." AND rut_evaluado=".$rut." and id_plantilla=".$plantilla;
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	
	}
	
	public function DescripcionEvaluacion($concepto){
		$sql="SELECT descripcion FROM evados.eva_escala WHERE concepto='".$concepto."'";
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
		
	}
	
	public function Escala2($rut,$plantilla,$ano,$periodo,$area){
		 $sql="SELECT evaluacion_final,valor_final FROM evados.eva_cierre_dimension_final WHERE id_ano=".$ano." AND id_periodo=".$periodo." AND id_plantilla=".$plantilla." AND rut_evaluado=".$rut." AND id_area=".$area;
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		echo pg_result($result,0)."(".pg_result($result,1).")";
		
		return $result;
	}
	
	public function Evaluacion_Final($rut,$plantilla,$ano,$periodo){
		$sql="SELECT count(*) as contador FROM evados.eva_plantilla_evaluacion epe  INNER JOIN evados.eva_plantilla_area epa ON epe.id_area=epa.id_area INNER JOIN evados.eva_concepto ec ON ec.id_concepto=epe.id_concepto WHERE rut_evaluado=".$rut." and epe.id_plantilla=".$plantilla." and id_ano=".$ano." AND epe.ip_periodo=".$periodo;
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		$total_evaluacion = pg_result($result,0);
		
		
		$sql ="SELECT count(*) as contador FROM evados.eva_plantilla_evaluacion epe INNER JOIN evados.eva_plantilla_area epa ON epe.id_area=epa.id_area INNER JOIN evados.eva_concepto ec ON ec.id_concepto=epe.id_concepto WHERE rut_evaluado=".$rut." and epe.id_plantilla=".$plantilla." and id_ano=".$ano." AND epe.ip_periodo=".$periodo." AND ec.id_concepto in (4,5)";
		$result =pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		$categoria = pg_result($result,0);
		
		$porc_categoria = round(($categoria * 100 )/ $total_evaluacion);
		
		if($porc_categoria>=90 and $porc_categoria<=100){
			echo "DESTACADO";
		}elseif($porc_categoria>=75 and $porc_categoria<=89){
			echo "COMPETENTE";
		}elseif($porc_categoria>=60 and $porc_categoria<=74){
			echo "BÁSICO";
		}else{
			echo "INSATISFACTORIO";	
		}
	
	}
	public function Evaluadores($ano,$periodo){
		 $sql ="SELECT a.rut_evaluador,
			 COALESCE(ap.dig_rut,al.dig_rut,em.dig_rut) as dig_rut,
			 CASE 
			 WHEN ap.nombre_apo IS NOT NULL THEN UPPER('Apoderado')
			 WHEN al.nombre_alu IS NOT NULL THEN UPPER('Alumno')
			 WHEN em.nombre_emp IS NOT NULL THEN UPPER(e.nombre_cargo)
			 END as cargo,
             UPPER(COALESCE(ap.ape_pat,al.ape_pat,em.ape_pat)) ||' '||
             UPPER(COALESCE(ap.ape_mat,al.ape_mat,em.ape_mat)) ||' '||
			 UPPER(COALESCE(ap.nombre_apo,al.nombre_alu,em.nombre_emp)) as nombres,
			 a.id_ano,a.id_cargo 
			 FROM  
			 evados.eva_evaluador a 
			 LEFT OUTER JOIN public.cargos e ON e.id_cargo = a.id_cargo  
			 LEFT OUTER JOIN public.empleado em ON em.rut_emp = a.rut_evaluador
			 LEFT OUTER JOIN public.alumno al ON al.rut_alumno = a.rut_evaluador
			 LEFT OUTER JOIN public.apoderado ap ON ap.rut_apo = a.rut_evaluador
			 WHERE a.id_ano = ".$ano." and id_periodo=".$periodo." ORDER BY 3,4";
		$result =	pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	public function Evaluados($ano,$periodo){
		 $sql ="SELECT a.rut_evaluado,em.dig_rut,
					UPPER(e.nombre_cargo) as nombre_cargo,
					UPPER(em.ape_pat) ||' '|| UPPER(em.ape_mat) ||' '||	UPPER(em.nombre_emp) as nombres,a.id_ano
					FROM 
					evados.eva_evaluado a
					LEFT OUTER JOIN public.cargos e ON e.id_cargo = a.id_cargo  
					LEFT OUTER JOIN public.empleado em ON em.rut_emp = a.rut_evaluado
					WHERE a.id_ano = $ano  and id_periodo= $periodo 
					ORDER BY 3,4";
		$result = 	pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	public function Relacion_Evaluacion($rut,$ano,$periodo){
	 $sql="SELECT  a.rut_evaluado,
					COALESCE(em_evdo.dig_rut,al_evdo.dig_rut,ap_evdo.dig_rut) as dig_rut, 
					CASE 
					WHEN em_evdo.rut_emp IS NOT NULL THEN UPPER(ca_evdo.nombre_cargo)
					WHEN ap_evdo.rut_apo IS NOT NULL THEN UPPER('Apoderado') 
					WHEN al_evdo.rut_alumno IS NOT NULL THEN UPPER('Alumno') 
					END as cargo,
					UPPER(COALESCE(em_evdo.ape_pat,ap_evdo.ape_pat,al_evdo.ape_pat)) ||' '||
					UPPER(COALESCE(em_evdo.ape_mat,ap_evdo.ape_mat,al_evdo.ape_mat)) ||' '||
					UPPER(COALESCE(em_evdo.nombre_emp,ap_evdo.nombre_apo,al_evdo.nombre_alu)) as nombre_evaluador, 
					
					CASE 
					WHEN a.fecha_evaluacion IS NOT NULL THEN 'Evaluado'
					ELSE 'No Evaluado' END as Estado_evaluacion,
					a.fecha_evaluacion as Fecha_Evaluacion
					FROM evados.eva_relacion_evaluacion As a 
					LEFT OUTER JOIN empleado As em_evdo ON em_evdo.rut_emp = a.rut_evaluado 
					LEFT OUTER JOIN alumno As al_evdo ON al_evdo.rut_alumno = a.rut_evaluado 
					LEFT OUTER JOIN apoderado As ap_evdo ON ap_evdo.rut_apo = a.rut_evaluado 
					LEFT OUTER JOIN cargos as ca_evdo ON ca_evdo.id_cargo = a.cargo_evaluado 
					WHERE a.rut_evaluador = $rut AND a.id_ano = $ano ORDER BY 3;";
			$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:111".$sql);
			return $result;	
	}
	
	public function Pendiente_Evaluacion($rut,$ano,$periodo){
	 $sql="SELECT  a.rut_evaluado,
					COALESCE(em_evdo.dig_rut,al_evdo.dig_rut,ap_evdo.dig_rut) as dig_rut, 
					CASE 
					WHEN em_evdo.rut_emp IS NOT NULL THEN UPPER(ca_evdo.nombre_cargo)
					WHEN ap_evdo.rut_apo IS NOT NULL THEN UPPER('Apoderado') 
					WHEN al_evdo.rut_alumno IS NOT NULL THEN UPPER('Alumno') 
					END as cargo,
					UPPER(COALESCE(em_evdo.ape_pat,ap_evdo.ape_pat,al_evdo.ape_pat)) ||' '||
					UPPER(COALESCE(em_evdo.ape_mat,ap_evdo.ape_mat,al_evdo.ape_mat)) ||' '||
					UPPER(COALESCE(em_evdo.nombre_emp,ap_evdo.nombre_apo,al_evdo.nombre_alu)) as nombre_evaluador, 
					
					CASE 
					WHEN a.fecha_evaluacion IS NOT NULL THEN 'Evaluado'
					ELSE 'No Evaluado' END as Estado_evaluacion,
					a.fecha_evaluacion as Fecha_Evaluacion
					FROM evados.eva_relacion_evaluacion As a 
					LEFT OUTER JOIN empleado As em_evdo ON em_evdo.rut_emp = a.rut_evaluado 
					LEFT OUTER JOIN alumno As al_evdo ON al_evdo.rut_alumno = a.rut_evaluado 
					LEFT OUTER JOIN apoderado As ap_evdo ON ap_evdo.rut_apo = a.rut_evaluado 
					LEFT OUTER JOIN cargos as ca_evdo ON ca_evdo.id_cargo = a.cargo_evaluado 
					WHERE a.rut_evaluador = $rut AND a.id_ano = $ano AND a.fecha_evaluacion IS NULL
					ORDER BY 3;";
			$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			return $result;	
	}
	
	
	
	public function valida_reporte_evaluacion($ano,$rut,$periodo){
		
		  $sql="select count(*) as primera from evados.eva_relacion_evaluacion evar where id_ano=$ano and rut_evaluado=$rut and id_periodo=$periodo
		 UNION select count(*) as segunda from evados.eva_relacion_evaluacion evar where id_ano=$ano and rut_evaluado=$rut and id_periodo=$periodo and fecha_evaluacion is NULL";
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			return $result;	
		
	}
	
	public function resultados_dimension($plantilla){
		 $sql="SELECT DISTINCT epa.id_area, epa.nombre as dimension, eps.id_subarea , eps.nombre as funcion, epi.id_item,epi.nombre as indicador
FROM evados.eva_item_bloque eib 
INNER JOIN evados.eva_plantilla_area epa ON epa.id_area=eib.id_area
INNER JOIN evados.eva_plantilla_subarea eps ON eib.id_subarea=eps.id_subarea
INNER JOIN evados.eva_plantilla_item epi ON eib.id_item=epi.id_item
WHERE id_plantilla=$plantilla 
ORDER BY 1,3,5";
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		return $result;	
	}
	
	public function total_por_concepto($plantilla,$ano,$periodo,$rut,$indicador){
	echo "<br>".$sql="	SELECT count(*) as cantidad, id_concepto 
				FROM evados.eva_plantilla_evaluacion epe 
				WHERE epe.id_ano=$ano AND epe.ip_periodo=$periodo AND id_item=$indicador AND rut_evaluado=$rut 
				group by id_concepto
				ORDER BY id_concepto ASC";
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		return $result;	
		
	}
	
	public function Iniciales($texto)
{
	$largo = strlen($texto);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($texto,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($texto,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($texto,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($texto,$cont_letras+1,1));
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		echo trim(strtoupper(substr($texto,0,3)));
	else
		echo trim($cadena);
}


public function EvaluacionXCargo($cmbINS,$ano,$cargo){
		
		
		$sql = "select 
				public.empleado.ape_pat,
				public.empleado.ape_mat,
				public.empleado.nombre_emp,
				evados.eva_cierre_evaluado_final.rut_evaluado,
				evados.eva_cierre_evaluado_final.valor_final,
				evados.eva_cierre_evaluado_final.evaluacion_final,
				evados.eva_cierre_evaluado_final.id_ano,
				evados.eva_evaluado.id_cargo,
				public.institucion.rdb,
				public.institucion.nombre_instit
				
				from  evados.eva_cierre_evaluado_final
				join public.empleado
				on public.empleado.rut_emp = evados.eva_cierre_evaluado_final.rut_evaluado
				join evados.eva_ano_escolar
				on evados.eva_ano_escolar.id_ano = evados.eva_cierre_evaluado_final.id_ano
				join evados.eva_evaluado
				ON evados.eva_cierre_evaluado_final.rut_evaluado = evados.eva_evaluado.rut_evaluado
				 AND evados.eva_cierre_evaluado_final.id_ano=evados.eva_evaluado.id_ano 
				join public.institucion
				on public.institucion.rdb = evados.eva_ano_escolar.id_institucion
				
				where 
				evados.eva_cierre_evaluado_final.id_ano in (".$ano.")
				and evados.eva_evaluado.id_cargo = ".$cargo."
				
				group by
				public.empleado.ape_pat,
				public.empleado.ape_mat,
				public.empleado.nombre_emp,
				evados.eva_cierre_evaluado_final.rut_evaluado,
				evados.eva_cierre_evaluado_final.valor_final,
				evados.eva_cierre_evaluado_final.evaluacion_final,
				evados.eva_cierre_evaluado_final.id_ano,
				evados.eva_evaluado.id_cargo,
				public.institucion.rdb,
				public.institucion.nombre_instit
				
				order by 
				public.institucion.nombre_instit,
				evados.eva_cierre_evaluado_final.valor_final desc";
		
		//echo $sql;
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		return $result;	
	
	}
	
	function EvaluacionXCargo2($cmbINS,$ano,$cargo){
		$sql="SELECT DISTINCT e.ape_pat ,e.ape_mat, e.nombre_emp,
				i.nombre_instit,
				ecef.valor_final,
				ecef.evaluacion_final,
				ecef.porcentaje
				FROM institucion i 
				INNER JOIN evados.eva_ano_escolar ae ON i.rdb=ae.id_institucion
				INNER JOIN evados.eva_cierre_evaluado_final ecef ON ecef.id_ano=ae.id_ano
				INNER JOIN evados.eva_evaluado ee ON ee.id_ano=ae.id_ano AND ecef.rut_evaluado=ee.rut_evaluado
				INNER JOIN evados.eva_plantilla ep ON ecef.id_plantilla=ep.id_plantilla  AND ep.id_bloque=".$cargo."
				INNER JOIN empleado e ON e.rut_emp=ee.rut_evaluado AND e.rut_emp=ecef.rut_evaluado
				WHERE ae.id_ano in (".$ano.") AND ee.id_cargo=".$cargo."
				--GROUP BY
				ORDER BY 1,2,4";
				
				
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		return $result;	
	}
	
	function buscaNroAnio($ano,$corp){
	$sql = "select i.id_ano from evados.eva_ano_escolar i
			INNER JOIN public.corp_instit ci
			ON i.id_institucion=ci.rdb 
			WHERE num_corp in (".$corp.")
			and i.nro_ano = ".$ano."
			group by i.id_ano 
			order by i.id_ano";	
			
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		return $result;	
	
	}
	
	public function Cargo($idCargo){
		 $sql="SELECT id_cargo, nombre_cargo FROM public.cargos WHERE id_cargo=$idCargo";
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);

		$fila = pg_fetch_array($result,0);
		
		return $fila;
	}
	 
	public function Subarea($nacional){
		$sql="select id_subarea,nombre from evados.eva_plantilla_subarea WHERE id_nacional=".$nacional;
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);

		return $result;
	}
	
	public function carga_empleado($cargo,$rdb,$ano,$periodo){
		//$sql ="SELECT empleado.rut_emp, nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombre FROM empleado INNER JOIN trabaja ON empleado.rut_emp=trabaja.rut_emp WHERE rdb=".$rdb." AND cargo=".$cargo." ORDER BY nombre ASC";
		$sql="  select e.rut_emp, nombre_emp ||' '|| ape_pat as nombre from empleado e INNER JOIN evados.eva_evaluado ee ON e.rut_emp=ee.rut_evaluado
  WHERE id_ano=".$ano." and ee.id_periodo=".$periodo." AND  ee.id_cargo=".$cargo."  ORDER BY nombre ASC";
		$rs_empleado = pg_exec($this->Conec->conectar(),$sql) or die(pg_last_error($this->Conec->conectar()));
		
		return $rs_empleado;
	}
	
	public function Detalle_Funsion($ano,$periodo,$rut,$subarea){
		$sql="SELECT * FROM evados.eva_cierre_funsion_final WHERE id_ano=".$ano." AND id_periodo=".$periodo." AND rut_evaluado=".$rut." AND id_subarea=".$subarea;
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);

		return $result;	
	}
	
	
public function listaAreas($pauta,$nacional,$ano,$periodo){
		   
 $sql="SELECT distinct epa.id_area,epe.id_plantilla,epa.nombre 
FROM evados.eva_plantilla_evaluacion epe 
inner join evados.eva_plantilla_area epa on epa.id_area =epe.id_area
INNER JOIN evados.eva_plantilla_nacional epn ON epn.id_area=epe.id_area
WHERE epe.id_ano=$ano 
and epe.id_plantilla =$pauta 
AND epe.ip_periodo=$periodo
and epa.nombre is not null
and epa.id_nacional = $nacional";
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);

		return $result;		
	}
	
public function listaSubAreas($pauta,$id_area,$nacional,$ano,$periodo){
 /*$sql="SELECT distinct epe.id_subarea,epe.id_area,epe.id_plantilla,eps.nombre
from evados.eva_plantilla_evaluacion epe
left join evados.eva_plantilla_subarea eps on eps.id_subarea = epe.id_subarea 
and epe.id_area =$id_area
INNER JOIN evados.eva_plantilla_nacional epn ON epe.id_subarea=epn.id_subarea
where 
epe.id_plantilla=$pauta 
and eps.id_nacional=$nacional
and epe.id_ano=$ano
and epe.ip_periodo = $periodo
and eps.nombre is not null;";*/

 /*$sql="SELECT distinct epn.id_plantilla,epn.id_area,eps.id_subarea,eps.nombre 
FROM evados.eva_plantilla_subarea as eps 
INNER JOIN evados.eva_plantilla_nacional epn ON epn.id_area = $id_area 
AND eps.id_subarea=epn.id_subarea 
WHERE epn.id_plantilla = $pauta and id_nacional=$nacional and eps.nombre is not null; ";*/
$sql="SELECT distinct eib.id_plantilla,eib.id_area,eps.id_subarea,eps.nombre 
FROM evados.eva_plantilla_subarea as eps 
inner join evados.eva_item_bloque eib on eib.id_subarea = eps.id_subarea
where eib.id_plantilla = $pauta and eib.id_area = $id_area  and eps.id_nacional = $nacional
and eps.nombre is not null order by eib.id_area,eps.id_subarea";


$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);

		return $result;
	}
	
public function listaItems($id_plantilla,$id_area,$id_subarea,$nacional,$ano,$periodo){
	 
/*$sql="select distinct epe.id_area,epe.id_subarea,epe.id_item,epi.nombre
from evados.eva_plantilla_evaluacion epe
left join evados.eva_plantilla_item epi on epi.id_item = epe.id_item 
and epe.id_area =$id_area and epe.id_subarea = $id_subarea
left join evados.eva_plantilla_nacional epn on epn.id_item = epi.id_item  
where epe.id_plantilla=$id_plantilla
and epe.id_ano = $ano
and epe.ip_periodo = $periodo
and epi.id_nacional=$nacional
and epi.nombre is not null
";*/

/*$sql="SELECT epn.id_plantilla,epn.id_area,epn.id_subarea,epi.id_item,epi.nombre 
FROM evados.eva_plantilla_item epi 
INNER JOIN evados.eva_plantilla_nacional epn ON epn.id_area =$id_area 
and epn.id_subarea = $id_subarea and epn.id_item = epi.id_item 
WHERE epn.id_plantilla = $id_plantilla and epi.id_nacional=1 and epi.nombre is not null; ";*/
$sql="SELECT distinct eib.id_plantilla,eib.id_area,eib.id_subarea,eps.id_item,eps.nombre 
FROM evados.eva_plantilla_item as eps 
inner join evados.eva_item_bloque eib on eib.id_item = eps.id_item
where eib.id_plantilla = $id_plantilla and eib.id_area = $id_area and eib.id_subarea = $id_subarea and eps.id_nacional = $nacional
and eps.nombre is not null order by eib.id_area,eib.id_subarea,eps.id_item";

$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);

		return $result;
	}
	
public function total_por_concepto_global($plantilla,$ano,$periodo,$rut,$indicador,$concepto,$id_area,$id_subarea){
	 $sql="	SELECT count(*) as cantidad, id_concepto
				FROM evados.eva_plantilla_evaluacion epe 
				WHERE epe.id_ano=$ano AND epe.ip_periodo=$periodo AND  epe.id_area=$id_area
and epe.id_subarea  = $id_subarea  and epe.id_item=$indicador AND rut_evaluado=$rut and id_concepto=$concepto
				group by id_concepto
				ORDER BY id_concepto ASC";
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		return $result;	
		
	}	

public function escalaGeneral(){
$sql="select * from evados.eva_escala order by desde";
$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
}

public function hex2rgba($color, $opacity = false) {
 
	$default = 'rgb(0,0,0)';
 
	//Return default if no color provided
	if(empty($color))
          return $default; 
 
	//Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.str_replace(",",".",$opacity).')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}

public function evaluacionPauta($ano,$periodo,$pauta,$area){
$sql="select round(avg(cdf.valor_final)) as valorf 
from evados.eva_cierre_dimension_final cdf
where cdf.id_ano = $ano and cdf.id_periodo = $periodo
and cdf.id_plantilla =$pauta
and cdf.id_area=$area";
$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);

$final = pg_result($result,0);

$sqle="select * from evados.eva_escala order by desde";
$resulte = pg_exec($this->Conec->conectar(),$sqle) or die ("Select falló : ".$sqle);

$rango[$area][0] = $final;

for($s=0;$s<pg_numrows($resulte);$s++){
$fr = pg_fetch_array($resulte,$e);

if($final>=$fr['desde'] && $final<=$fr['hasta']){
$rango[$area][1] = $fr['concepto'];
}
}

return $rango;
}

public function dimensionPauta($pauta,$ano){

 $sql="select DISTINCT epa.id_area,epa.nombre
FROM evados.eva_cierre_dimension_final ecdf 
INNER JOIN evados.eva_plantilla_area epa ON ecdf.id_area=epa.id_area
INNER JOIN evados.eva_cierre ec ON ecdf.id_cierre=ec.id_cierre
WHERE  ecdf.id_plantilla=".$pauta." AND ecdf.id_area<>22 
AND ecdf.id_ano=".$ano."
ORDER BY epa.id_area DESC";
$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		return $result;	
}


function EvaluacionXCargo3($cmbINS,$ano,$cargo,$periodo){
		   $sql="SELECT DISTINCT e.rut_emp,e.ape_pat||' '||e.ape_mat||' '||e.nombre_emp as nombre,
				i.nombre_instit,
				ecef.valor_final,
				ecef.evaluacion_final,
				ecef.porcentaje,
				esc.id_escala
				FROM institucion i 
				INNER JOIN evados.eva_ano_escolar ae ON i.rdb=ae.id_institucion
				INNER JOIN evados.eva_cierre_evaluado_final ecef ON ecef.id_ano=ae.id_ano
				INNER JOIN evados.eva_evaluado ee ON ee.id_ano=ae.id_ano AND ecef.rut_evaluado=ee.rut_evaluado
				INNER JOIN evados.eva_plantilla ep ON ecef.id_plantilla=ep.id_plantilla  AND ep.id_bloque=".$cargo."
				INNER JOIN empleado e ON e.rut_emp=ee.rut_evaluado AND e.rut_emp=ecef.rut_evaluado
				INNER JOIN evados.eva_escala esc on esc.concepto =  ecef.evaluacion_final
				WHERE ae.id_ano in (".$ano.") AND ee.id_cargo=".$cargo." and ecef.id_periodo = ".$periodo."
				--GROUP BY
				ORDER BY 1";
				
				
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		return $result;	
	}


function EvaluacionXAnoTodos($ano,$periodo){
		 /* $sql="SELECT e.ape_pat,
				e.ape_mat,
				e.nombre_emp,
				i.nombre_instit,
				ecef.valor_final,
				ecef.evaluacion_final,
				esc.id_escala,
				ecef.porcentaje,
				ee.id_cargo,
				ca.nombre_cargo
				FROM institucion i 
				INNER JOIN evados.eva_ano_escolar ae ON i.rdb=ae.id_institucion
				INNER JOIN evados.eva_cierre_evaluado_final ecef ON ecef.id_ano=ae.id_ano
				INNER JOIN evados.eva_evaluado ee ON ee.id_ano=ae.id_ano AND ecef.rut_evaluado=ee.rut_evaluado
				INNER JOIN evados.eva_plantilla ep ON ecef.id_plantilla=ep.id_plantilla 
				INNER JOIN empleado e ON e.rut_emp=ee.rut_evaluado AND e.rut_emp=ecef.rut_evaluado
				INNER JOIN evados.eva_escala esc on esc.concepto =  ecef.evaluacion_final
				LEFT JOIN public.cargos ca on ca.id_cargo = ee.id_cargo
				
				WHERE ae.id_ano in (".$ano.") and ecef.id_periodo = ".$periodo."	
				
				ORDER BY 9,1,2,3";*/
				
				$sql="select e.rut_emp,e.ape_pat||' '||e.ape_mat||' '||e.nombre_emp as nombre,
ecef.id_plantilla,ecef.valor_final, ecef.evaluacion_final,esc.id_escala, ecef.porcentaje 
FROM institucion i 
INNER JOIN evados.eva_ano_escolar ae ON i.rdb=ae.id_institucion 
INNER JOIN evados.eva_evaluado ee ON ee.id_ano=ae.id_ano 
INNER JOIN evados.eva_cierre_evaluado_final ecef ON ecef.id_ano=ae.id_ano 
INNER JOIN empleado e ON e.rut_emp=ee.rut_evaluado AND e.rut_emp=ecef.rut_evaluado
AND ecef.rut_evaluado=ee.rut_evaluado 
INNER JOIN evados.eva_escala esc on esc.concepto = ecef.evaluacion_final 
INNER JOIN evados.eva_plantilla ep ON ecef.id_plantilla=ep.id_plantilla 
WHERE ae.id_ano in ($ano) and ecef.id_periodo = $periodo
group by e.rut_emp,ecef.id_plantilla,e.ape_pat,e.ape_mat,e.nombre_emp,ecef.valor_final,
 ecef.evaluacion_final,esc.id_escala, ecef.porcentaje
order by ecef.id_plantilla,nombre";
				
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		return $result;	
	}

public function CargoEmpleadoUno($rut_emp,$plantilla,$ano,$periodo){
	 $sql="select distinct(c.nombre_cargo)
from cargos c  
inner join  evados.eva_plantilla_evaluacion epe
on epe.id_cargo_evaluado = c.id_cargo
WHERE epe.id_ano in ($ano) and epe.ip_periodo = $periodo
and epe.id_plantilla = $plantilla and epe.rut_evaluado = $rut_emp";
$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		return $result;	
	}


public function CantidadEvaluacionesSI($ano,$periodo,$rut,$cargo){
		$sql="select * from evados.eva_relacion_evaluacion ere where ere.rut_evaluado=".$rut." and ere.id_ano=".$ano." AND ere.id_periodo=".$periodo." AND ere.cargo_evaluado=".$cargo." and fecha_evaluacion is not null";
		$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);

		return $result;
		
	}

public function empleadoNom($rut){
			$sql="SELECT nombre_emp ||' '|| ape_pat ||' '|| ape_mat as empleado FROM empleado  WHERE rut_emp=".$rut;		
			$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
			return $result;
}

public function dimension2($pauta,$docente,$ano,$nacional){
   $sql="select DISTINCT epa.id_area,epa.nombre
FROM evados.eva_cierre_dimension_final ecdf 
INNER JOIN evados.eva_plantilla_area epa ON ecdf.id_area=epa.id_area
INNER JOIN evados.eva_cierre ec ON ecdf.id_cierre=ec.id_cierre
WHERE  ecdf.rut_evaluado=".$docente." AND ecdf.id_plantilla=".$pauta." AND ecdf.id_area<>22 
AND ecdf.id_ano=".$ano." and epa.id_nacional=".$nacional."
ORDER BY epa.id_area ";
$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
			return $result;
	}
	
public function respuestaEvaluadorInd($ano,$periodo,$area,$subarea,$item,$evaluado,$evaluador,$cargo){
$sql="SELECT id_concepto
FROM evados.eva_plantilla_evaluacion epe 
WHERE epe.id_ano=$ano
AND epe.ip_periodo=$periodo
AND  epe.id_area=$area
and epe.id_subarea = $subarea
and epe.id_item=$item
AND rut_evaluado=$evaluado 
and rut_evaluador = $evaluador
and id_cargo_evaluado = $cargo";
$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
			return $result;
}

public function cargo1($id_cargo){
$sql="select nombre_cargo from cargos where id_cargo=$id_cargo";
$result = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
			return $result;
}

} //fin clase
