<?
header( 'Content-type: text/html; charset=iso-8859-1' );
require "../../class/Coneccion.class.php";

class Cierra {
       
	public $Conec;

//constructor 
public function Cierra($ip,$bd){
	$this->Conec = new DBManager($ip,$bd);
 } 
      
public function buscabloque($nacional){
	//$sql="SELECT id_plantilla,nombre FROM evados.eva_plantilla ORDER BY id_bloque ASC";
	$sql="SELECT id_plantilla,nombre FROM evados.eva_plantilla WHERE id_nacional=".$nacional." ORDER BY nombre ASC";
	$rs_bloque =  pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 1" );
	
	if($rs_bloque){
		return $rs_bloque;	
	}else{
		return false;
	}
}
public function CicloPlantillas($nacional,$id){
	$sql="SELECT id_plantilla,nombre FROM evados.eva_plantilla WHERE id_nacional=".$nacional." ORDER BY nombre ASC LIMIT 1 OFFSET ".$id.";";
	$rs_ciclo =  pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert ->".$sql );
	
	if($rs_ciclo){
		return $rs_ciclo;	
	}else{
		return false;
	}
}

public function cierre_evaluado($nacional,$a,$ano){
//	$sql="SELECT id_plantilla,id_bloque FROM evados.eva_plantilla WHERE id_nacional=".$nacional."  ORDER BY id_bloque ASC LIMIT 1 OFFSET $a";
   
	echo "<br>".$sql="SELECT id_plantilla,id_bloque FROM evados.eva_plantilla WHERE id_nacional=".$nacional." AND id_plantilla=".$a." ORDER BY id_bloque ASC ";
	$rs_plantilla = pg_exec($this->Conec->conectar(),$sql)  or die( "Error bd SQL 2" );
	$plantilla = pg_result($rs_plantilla,0);
	$cargo_evaluado = pg_result($rs_plantilla,1);
	
	echo "<br>".$sql="SELECT id_cierre FROM evados.eva_cierre WHERE id_nacional=".$nacional." AND estado=1";
	$rs_cierre = pg_exec($this->Conec->conectar(),$sql) or die( "Error bd SQL 3" );
	$cierre = pg_result($rs_cierre,0);
	
	echo "<br>".$sql="SELECT id_periodo FROM evados.eva_periodo WHERE id_ano=".$ano." AND (cerrado=0 or cerrado is null) ";
	$rs_periodo =  pg_exec($this->Conec->conectar(),$sql) or die( "Error bd SQL 4" );
	$periodo = pg_result($rs_periodo,0);


	echo "<br>".$sql="SELECT id_concepto,peso FROM evados.eva_concepto WHERE estado=1 and id_nacional=".$nacional." ORDER BY orden";
	$rs_concepto = pg_exec($this->Conec->conectar(),$sql) or die( "Error bd SQL 5" );

		if($cargo_evaluado==102){
			$bloq=$cargo_evaluado;
		}else{
			$bloq=$cargo_evaluado;
		}

		//---------------- CANTIDAD DE INDICADORES POR AREA Y BLOQUE
	 	$sql="SELECT count(eib.*) as cant_area, eb.id_bloque,eib.id_area,epa.nombre
				FROM evados.eva_item_bloque eib
				INNER JOIN evados.eva_bloque eb ON eib.id_bloque=eb.id_bloque AND eb.estado=1
				INNER JOIN evados.eva_plantilla_area epa ON epa.id_area=eib.id_area
				WHERE id_plantilla=".$plantilla." and id_nacional=".$nacional."
				GROUP BY 2,3,4
				ORDER BY 3,2";
		$rs_indicadores_bloque = pg_exec($this->Conec->conectar(),$sql) or die( "Error bd SQL 6".$sql );


		//---------------- CANTIDAD DE EVALUADOS POR PAUTA
		/*$sql="SELECT DISTINCT rut_evaluado
			  FROM evados.eva_relacion_evaluacion ere
			  WHERE ere.id_ano=".$ano." and ere.id_periodo=".$periodo." and  ere.rut_evaluado=13508692 AND ere.cargo_evaluado=".$bloq;*/
		  $sql="SELECT DISTINCT ere.rut_evaluado
			  FROM evados.eva_relacion_evaluacion ere
			  INNER JOIN evados.eva_plantilla_evaluacion epe ON epe.rut_evaluado=ere.rut_evaluado AND epe.ip_periodo=ere.id_periodo
			  WHERE ere.id_ano=".$ano." and ere.id_periodo=".$periodo." AND epe.id_plantilla=".$plantilla."
			  AND epe.id_cargo_evaluado=".$bloq;

		$rs_evaluado = pg_exec($this->Conec->conectar(),$sql) or die( "Error bd SQL 7" );

	
	//------------- INICIO CARGA TABLA EVA_CIERRE_CONCEPTO_DIMENSION-------------------
		for($i=0;$i<pg_numrows($rs_evaluado);$i++){
			$fila_evaluado = pg_fetch_array($rs_evaluado,$i);
		
			//------ CANTIDAD DE INDICADORES POR BLOQUE DE UNA PAUTA EN PARTICULAR
			

			for($j=0;$j<pg_numrows($rs_indicadores_bloque);$j++){
				$fila_ind = pg_fetch_array($rs_indicadores_bloque,$j);

				//if($cargo_evaluado==102) $cargo_evaluado=5;
					
					  /*echo "<br>".$sql="SELECT count(*) as cant_bloque, ebe.id_bloque
					  FROM evados.eva_relacion_evaluacion ere
					  INNER JOIN evados.eva_bloque_evaluador ebe ON ere.rut_evaluador=ebe.rut_evaluador AND ere.id_cargo=ebe.id_cargo
					  WHERE ere.id_ano=".$ano." and ere.id_periodo=".$periodo." and ere.cargo_evaluado=".$cargo_evaluado." 
					  and ere.rut_evaluado=".$fila_evaluado['rut_evaluado']." AND ebe.id_bloque=".$fila_ind['id_bloque']." 
					  GROUP BY 2";*/
					  $sql="SELECT count(distinct ere.rut_evaluador) as cant_bloque, ebe.id_bloque
							FROM evados.eva_plantilla_evaluacion ere
							INNER JOIN evados.eva_bloque_evaluador ebe ON ere.rut_evaluador=ebe.rut_evaluador 
							AND ere.id_cargo_evaluador=ebe.id_cargo
							WHERE ere.id_ano=".$ano." and ere.ip_periodo=".$periodo." and ere.id_cargo_evaluado=".$cargo_evaluado."
							and ere.rut_evaluado=".$fila_evaluado['rut_evaluado']." AND ebe.id_bloque=".$fila_ind['id_bloque']." 
							GROUP BY 2";
					 
					  $rs_cantidad =pg_exec($this->Conec->conectar(),$sql) or die( "Error bd SQL 8" );

				for($x=0;$x<pg_numrows($rs_concepto);$x++){
					$fila_concepto = pg_fetch_array($rs_concepto,$x);
					
					for($n=0;$n<pg_numrows($rs_cantidad);$n++){
						$fila_cantidad = pg_fetch_array($rs_cantidad,$n);
						$peso = $fila_concepto['peso'];
						//echo "  ".$fila_concepto['peso']." ".$fila_ind['cant_area']." ".$fila_cantidad['cant_bloque'];
						$valor = $fila_concepto['peso'] * $fila_ind['cant_area'] * $fila_cantidad['cant_bloque'];
						$fila_concepto['peso']." ".$fila_ind['cant_area']." ".$fila_cantidad['cant_bloque'];
						$sql="INSERT INTO evados.eva_cierre_concepto_dimension (id_cierre,id_plantilla,id_area,id_ano,
							  id_periodo,id_concepto,rut_evaluado,id_bloque,peso,valor) 
							  VALUES (".$cierre.",".$plantilla.",".$fila_ind['id_area'].",".$ano.",".$periodo.",".$fila_concepto['id_concepto'].",
							  ".$fila_evaluado['rut_evaluado'].",".$fila_cantidad['id_bloque'].",".$peso.",".$valor.")";
						$rs_insert = pg_exec($this->Conec->conectar(),$sql);
					}
				}
				
				
					for($x=0;$x<pg_numrows($rs_concepto);$x++){
					$fila_concepto = pg_fetch_array($rs_concepto,$x);
					
					
						$peso = $fila_concepto['peso'];
						//echo "  ".$fila_concepto['peso']." ".$fila_ind['cant_area']." ".$fila_cantidad['cant_bloque'];
						$valor = $fila_concepto['peso'] * 1 * $fila_cantidad['cant_bloque'];
						$fila_concepto['peso']." ".$fila_ind['cant_area']." ".$fila_cantidad['cant_bloque'];
						$sql="INSERT INTO evados.eva_cierre_concepto_dimension (id_cierre,id_plantilla,id_area,id_ano,
							  id_periodo,id_concepto,rut_evaluado,id_bloque,peso,valor) 
							  VALUES (".$cierre.",".$plantilla.",".$fila_ind['id_area'].",".$ano.",".$periodo.",".$fila_concepto['id_concepto'].",
							  ".$fila_evaluado['rut_evaluado'].",4,".$peso.",".$valor.")";
						$rs_insert = pg_exec($this->Conec->conectar(),$sql);
					
					}
				
			

			}

		}
		
	//------------------ FIN CARGA TABLA EVA_CIERRE_CONCEPTO_DIMENSION -------------------

	//------------------- INICIO CARGA TABLA EVA_CIERRE_DIMENSION_CARGO------------------

	 $sql="select DISTINCT id_area,id_bloque from evados.eva_item_bloque eib where eib.id_plantilla=".$plantilla." ORDER BY id_area,id_bloque";	
	$rs_area = pg_exec($this->Conec->conectar(),$sql);

	
	for($j=0;$j<pg_numrows($rs_evaluado);$j++){
		$fila_evaluado = pg_fetch_array($rs_evaluado,$j);

		for($i=0;$i<pg_numrows($rs_area);$i++){
			$fila_area = pg_fetch_array($rs_area,$i);

			  $sql="SELECT count(*) * ec.peso as valor
			  FROM evados.eva_plantilla_evaluacion epe 
			  INNER JOIN evados.eva_bloque_evaluador ebe ON epe.id_cargo_evaluador=ebe.id_cargo AND 
			  epe.rut_evaluador=ebe.rut_evaluador AND ebe.id_periodo=".$periodo."
			  INNER JOIN evados.eva_concepto ec ON ec.id_concepto=epe.id_concepto 
			  WHERE epe.id_ano=".$ano." and epe.ip_periodo=".$periodo." AND epe.rut_evaluado=".$fila_evaluado['rut_evaluado']."  AND ec.id_nacional=".$nacional."
			  AND ebe.id_bloque=".$fila_area['id_bloque']." and epe.id_area=".$fila_area['id_area']."
			  AND epe.id_plantilla=".$plantilla."
			  GROUP BY ec.peso";
			  
			  if($fila_area['id_bloque']==4){
				  $sql="SELECT count(*) * ec.peso as valor
			  FROM evados.eva_plantilla_evaluacion epe 
			  INNER JOIN evados.eva_bloque_evaluador ebe ON epe.id_cargo_evaluador=ebe.id_cargo AND 
			  epe.rut_evaluador=ebe.rut_evaluador AND ebe.id_periodo=".$periodo."
			  INNER JOIN evados.eva_concepto ec ON ec.id_concepto=epe.id_concepto 
			  WHERE epe.id_ano=".$ano." and epe.ip_periodo=".$periodo." AND epe.rut_evaluado=".$fila_evaluado['rut_evaluado']."  AND ec.id_nacional=".$nacional."
			  AND epe.rut_evaluador=".$fila_evaluado['rut_evaluado']." and epe.id_area=".$fila_area['id_area']."
			  AND epe.id_plantilla=".$plantilla."
			  GROUP BY ec.peso"; 
			  }
			$rs_total =pg_exec($this->Conec->conectar(),$sql);

			$total = 0;
			for($x=0;$x<pg_numrows($rs_total);$x++){
				$fila_total = pg_fetch_array($rs_total,$x);

				$total = $total + $fila_total['valor'];
			}

			 $sql ="INSERT INTO evados.eva_cierre_dimension_bloque (id_cierre,id_plantilla,id_area,id_ano,id_periodo, id_bloque, rut_evaluado, valor ) VALUES (".$cierre.",".$plantilla.",".$fila_area['id_area'].", ".$ano.", ".$periodo.", ".$fila_area['id_bloque'].", ".$fila_evaluado['rut_evaluado'].", ".$total.")";
			$rs_insert = pg_exec($this->Conec->conectar(),$sql);

		}
	}
	

	//------------------ INICIO CARGA DE TABLA CIERRE DIMENSION FINAL ---------------------------
	echo "<br>".$sql="SELECT DISTINCT id_area FROM evados.eva_item_bloque WHERE id_plantilla=".$plantilla." ORDER BY id_area ASC";
	$rs_area =  pg_exec($this->Conec->conectar(),$sql);

	for($i=0;$i<pg_numrows($rs_area);$i++){
		$fila_area = pg_fetch_array($rs_area,$i);

		for($j=0;$j<pg_numrows($rs_evaluado);$j++){
			$fila_evaluado = pg_fetch_array($rs_evaluado,$j);
			$obtenido=0;
			$optimo=0;
			echo "<br>".$sql="SELECT sum(valor) FROM evados.eva_cierre_dimension_bloque WHERE id_ano=".$ano." and id_periodo=".$periodo." AND id_area=".$fila_area['id_area']." AND rut_evaluado=".$fila_evaluado['rut_evaluado']." and id_cierre=".$cierre;
			$rs_total =pg_exec($this->Conec->conectar(),$sql);
			$obtenido = pg_result($rs_total,0);

			echo "<br>".$sql="SELECT sum(valor) FROM evados.eva_cierre_concepto_dimension eccd WHERE id_ano=".$ano." and id_periodo=".$periodo." AND id_area=".$fila_area['id_area']." AND rut_evaluado=".$fila_evaluado['rut_evaluado']."  AND eccd.id_concepto in (select id_concepto from evados.eva_concepto where id_nacional=".$nacional." and optimo=1) AND id_cierre=".$cierre;
			$rs_sumatoria = pg_exec($this->Conec->conectar(),$sql);
			$optimo = pg_result($rs_sumatoria,0);
			
			$resultado_obtenido = round(($obtenido * 100) / $optimo);
			
			

			echo "<br>".$sql="SELECT * FROM evados.eva_escala ee WHERE ee.desde<=".$resultado_obtenido." AND ee.hasta>=".$resultado_obtenido;
			$rs_escala = pg_exec($this->Conec->conectar(),$sql);
			$concepto = pg_result($rs_escala,1);

			echo "<br>".$sql="INSERT INTO evados.eva_cierre_dimension_final (id_cierre,id_plantilla, id_area,id_ano,id_periodo,rut_evaluado, sumatoria,total_concepto,valor_final, evaluacion_final, porcentaje) VALUES (".$cierre.",".$plantilla.",".$fila_area['id_area'].",".$ano.",".$periodo.",".$fila_evaluado['rut_evaluado'].", ".$optimo.", ".$obtenido.", ".$resultado_obtenido.", '".$concepto."', 100)";
			$rs_cierre_dimension =  pg_exec($this->Conec->conectar(),$sql);
			
			/******** PARCHE DE CIERRE 2015****/
			
			$sql="SELECT * FROM evados.eva_cierre_evaluado_final WHERE id_cierre=".$cierre." AND id_plantilla=".$plantilla." AND rut_evaluado=".$fila_evaluado['rut_evaluado']."";
			$rs_final = pg_exec($this->Conec->conectar(),$sql);
			$fila_final = pg_fetch_array($rs_final,0);
			
			$sql="select sum(valor) from evados.eva_cierre_concepto_dimension where id_cierre=".$cierre." and rut_evaluado=".$fila_evaluado['rut_evaluado']." and peso=4 and id_plantilla=".$plantilla."";
			$rs_nuevo_optimo = pg_exec($this->Conec->conectar(),$sql);
			$nuevo_optimo=pg_result($rs_nuevo_optimo,0);
			
			$new_final = round(($fila_final['sumatoria'] * 100) / $nuevo_optimo);
			
			$sql="SELECT concepto FROM evados.eva_escala WHERE desde<=".$new_final." AND hasta>=".$new_final;
			$rs_escala = pg_exec($this->Conec->conectar(),$sql) or die ("ERROR 8 ".$sql);
			$concepto = pg_Result($rs_escala,0);
			
			$sql="UPDATE evados.eva_cierre_evaluado_final SET total_concepto=".$nuevo_optimo.", evaluacion_final='".$concepto."', valor_final=".$new_final." WHERE id_cierre=".$cierre." AND id_plantilla=".$plantilla." AND rut_evaluado=".$fila_evaluado['rut_evaluado'];
			$rs_modificacion = pg_exec($this->Conec->conectar(),$sql);


			

		}
	}
	//-------------------- FIN CARGA DE TABLA CIERRE DIMENSION FINAL-------------------------------
	if($rs_evaluado){
		return $rs_evaluado;
	}else{
		return false;	
	}
}
}
?>