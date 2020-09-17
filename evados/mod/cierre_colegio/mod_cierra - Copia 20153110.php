<?
header( 'Content-type: text/html; charset=iso-8859-1' );
require "../../class/Coneccion.class.php";

class Cierra {
       
	public $Conec;

//constructor 
public function Cierra($ip,$bd){
	$this->Conec = new DBManager($ip,$bd);
 } 
      
public function buscabloque(){
	$sql="SELECT id_plantilla,nombre FROM evados.eva_plantilla ORDER BY id_bloque ASC";
	$rs_bloque =  pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 1" );
	
	if($rs_bloque){
		return $rs_bloque;	
	}else{
		return false;
	}
}

public function insertcierreconcepto($nacional,$ano){
	$sql="SELECT id_cierre FROM evados.eva_cierre WHERE id_nacional=".$nacional." AND estado=1";
	$rs_cierre = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.3".$sql);	
	$cierre = pg_result($rs_cierre,0);
	
	$sql="SELECT id_plantilla FROM evados.eva_plantilla WHERE id_nacional=".$nacional;
	$result= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);	
	
	$sql="SELECT id_bloque FROM evados.eva_bloque";
	$rs_bloque= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);
	
	$sql="SELECT peso,id_concepto FROM evados.eva_concepto where id_nacional=".$nacional." and estado=1";			
	$rs_concepto= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);
	
	$sql ="SELECT id_periodo FROM periodo WHERE id_ano=".$ano." AND (cerrado=0 or cerrado is null)";
	$rs_periodo = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);
	$periodo = pg_result($rs_periodo,0);
	
	
	
	for($i=0;$i<pg_numrows($result);$i++){
		$fila = pg_fetch_array($result,$i);
		
		$sql="SELECT count(*) as cantidad, id_bloque  FROM evados.eva_item_bloque eib WHERE eib.id_plantilla=".$fila['id_plantilla']." GROUP BY id_bloque";
		$rs_area = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);
		
		for($j=0;$j<pg_numrows($rs_area);$j++){
			$fila_area = pg_fetch_array($rs_area,$j);
			
			for($x=0;$x<pg_numrows($rs_concepto);$x++){
				$fila_con = pg_fetch_array($rs_concepto,$x);
				
				$sql="select count(*) as contador from evados.eva_relacion_evaluacion ere 
	INNER JOIN evados.eva_bloque_evaluador ebe ON ere.id_cargo=ebe.id_cargo AND ere.rut_evaluador=ebe.rut_evaluador
	INNER JOIN evados.eva_plantilla ep ON ep.id_bloque=ere.cargo_evaluado 
	where ebe.id_bloque=".$fila_area['id_bloque']." and id_ano=".$ano." and ere.id_periodo=".$periodo." and id_plantilla=".$fila['id_plantilla'];
				$rs_contar = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);
				$contador = pg_result($rs_contar,0);
				
				$total = $fila_area['cantidad'] * $fila_con['peso'] * $contador;
				
				
				$sql="INSERT INTO evados.eva_cierre_concepto (id_cierre,id_plantilla,id_concepto,id_cargo,id_ano,id_periodo,peso,valor) VALUES(".$cierre.",".$fila['id_plantilla'].",".$fila_con['id_concepto'].",".$fila_area['id_bloque'].",".$ano.",".$periodo.",".$fila_con['peso'].",".$total.")";
				$rs_insert = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);
			}
		}
	}
	
	if($rs_insert){
		   return true;
	}else{
		  return false;
	}
}
public function cierre_evaluado($nacional,$a,$ano){
//	$sql="SELECT id_plantilla,id_bloque FROM evados.eva_plantilla WHERE id_nacional=".$nacional."  ORDER BY id_bloque ASC LIMIT 1 OFFSET $a";
	$sql="SELECT id_plantilla,id_bloque FROM evados.eva_plantilla WHERE id_nacional=".$nacional." AND id_plantilla=".$a." ORDER BY id_bloque ASC ";
	$rs_plantilla = pg_exec($this->Conec->conectar(),$sql);
	$plantilla = pg_result($rs_plantilla,0);
	$bloque = pg_result($rs_plantilla,1);
	
	$sql="SELECT id_cierre FROM evados.eva_cierre WHERE id_nacional=".$nacional." AND estado=1";
	$rs_cierre = pg_exec($this->Conec->conectar(),$sql);
	$cierre = pg_result($rs_cierre,0);
	
	$sql="SELECT id_periodo FROM periodo WHERE id_ano=".$ano." AND (cerrado=0 or cerrado is null) ";
	$rs_periodo =  pg_exec($this->Conec->conectar(),$sql);
	$periodo = pg_result($rs_periodo,0);
	
	
	/*$sql ="SELECT count(*) as cantidad,id_cargo,rut_evaluado
			 FROM evados.eva_plantilla ep 
			 INNER JOIN evados.eva_relacion_evaluacion ere ON ere.cargo_evaluado=ep.id_bloque
			 WHERE id_plantilla=".$plantilla." and ere.id_ano=".$ano." and ere.id_periodo=".$periodo." and fecha_evaluacion is not null
			 GROUP BY id_cargo,rut_evaluado";*/
	  $sql="SELECT count(*) as cantidad,ebe.id_bloque,rut_evaluado, ere.id_cargo
		 FROM evados.eva_plantilla ep 
		 INNER JOIN evados.eva_relacion_evaluacion ere ON ere.cargo_evaluado=ep.id_bloque
		 INNER JOIN evados.eva_bloque_evaluador ebe ON ebe.rut_evaluador=ere.rut_evaluador and ebe.id_cargo=ere.id_cargo
		 WHERE id_plantilla=".$plantilla."  and ere.id_ano=".$ano." and ere.id_periodo=".$periodo." and fecha_evaluacion is not null
		 GROUP BY 2,3,4"; 

	$rs_bloques = pg_exec($this->Conec->conectar(),$sql)or die ("ERROR 1 ".$sql);
	
	for($i=0;$i<pg_numrows($rs_bloques);$i++){
		$fila_bloque = pg_fetch_array($rs_bloques,$i);
		
		$sql="SELECT count(*) as cantidad, id_concepto
				FROM evados.eva_plantilla_evaluacion epe 
				WHERE id_ano=".$ano." AND ip_periodo=".$periodo." AND id_plantilla=".$plantilla." AND epe.id_cargo_evaluador=".$fila_bloque['id_cargo']." AND epe.rut_evaluado=".$fila_bloque['rut_evaluado']." 
				GROUP BY id_concepto
				ORDER BY id_concepto ASC";
			
				//
		$rs_evaluacion = pg_exec($this->Conec->conectar(),$sql) or die ("ERROR 2 ".$sql);
		
		$total_unitario =0;
		
		for($j=0;$j<pg_numrows($rs_evaluacion);$j++){
			$fila_eva = pg_fetch_array($rs_evaluacion,$j);	
			$valor_unitario =0;
			$sql="SELECT peso * ".$fila_eva['cantidad']." FROM evados.eva_cierre_concepto WHERE id_plantilla=".$plantilla." and id_cargo=".$fila_bloque['id_bloque']." AND id_concepto=".$fila_eva['id_concepto'];
			$rs_conceptos = @pg_exec($this->Conec->conectar(),$sql)or die ("ERROR 3 ".$sql);
			$total_unitario = @pg_result($rs_conceptos,0);
			
			//echo "<br>valor-->".$valor_unitario = @($valor / $fila_bloque['cantidad']);
			
			//echo "<br>total-->".$total_unitario = $total_unitario + $valor_unitario;
			$sql="SELECT valor FROM evados.eva_cierre_evaluado WHERE id_cierre=".$cierre." AND id_ano=".$ano." AND id_periodo=".$periodo." AND id_plantilla=".$plantilla." AND rut_evaluado=".$fila_bloque['rut_evaluado']." AND id_concepto=".$fila_eva['id_concepto']." AND id_bloque=".$fila_bloque['id_bloque'];
			$rs_existe = @pg_exec($this->Conec->conectar(),$sql);	
			$valor_existe = @pg_result($rs_existe,0);
		
			if(@pg_numrows($rs_existe)==0){		
				$sql="INSERT INTO evados.eva_cierre_evaluado (id_cierre,id_ano,id_periodo,id_plantilla,rut_evaluado,id_concepto,id_bloque,valor) VALUES (".$cierre.",".$ano.",".$periodo.",".$plantilla.",".$fila_bloque['rut_evaluado'].",".$fila_eva['id_concepto'].",".$fila_bloque['id_bloque'].",".$total_unitario.")";
				$rs_cierre_evaluado  = @pg_exec($this->Conec->conectar(),$sql);	
			}else{
				$sql="UPDATE evados.eva_cierre_evaluado SET valor = ".$valor_existe." + ".$total_unitario." WHERE id_cierre=".$cierre." AND id_ano=".$ano." AND id_periodo=".$periodo." AND id_plantilla=".$plantilla." AND rut_evaluado=".$fila_bloque['rut_evaluado']." AND id_concepto=".$fila_eva['id_concepto']." AND id_bloque=".$fila_bloque['id_bloque'];
				$rs_cierre_evaluado  = pg_exec($this->Conec->conectar(),$sql) or die ("ERROR 6 ".$sql);
			}
		} // fin $rs_evaluacion

		
		
	}
	
	// -------------- PROCESO DE CIERRE INDIVIDUAL  FINAL ------------------------
		
		//echo  $sql="SELECT sum(valor) as cantidad FROM evados.eva_cierre_evaluado WHERE id_cierre=".$cierre." AND id_ano=".$ano." AND id_periodo=".$periodo." AND id_plantilla=".$plantilla." AND rut_evaluado=".$fila_bloque['rut_evaluado'];
		$sql="SELECT sum(valor) as cantidad, rut_evaluado
FROM evados.eva_cierre_evaluado 
WHERE id_cierre=".$cierre." AND id_ano=".$ano." AND id_periodo=".$periodo." AND id_plantilla=".$plantilla."
GROUP BY 2";
		$rs_total_unitario = pg_exec($this->Conec->conectar(),$sql) or die ("ERROR 7 ".$sql);
		$sumatoria = pg_result($rs_total_unitario,0);
		
		//echo "<br>".$sql="SELECT valor FROM evados.eva_cierre_concepto WHERE id_plantilla=".$plantilla." AND optimo=1";
		$sql="SELECT sum(valor)
FROM evados.eva_cierre_concepto ecc
INNER JOIN evados.eva_concepto ec ON ecc.id_concepto=ec.id_concepto
WHERE id_plantilla=".$plantilla." and optimo=1";
		$rs_valor_concepto = pg_exec($this->Conec->conectar(),$sql) or die ("ERROR 8 ".$sql);
		$optimo = pg_result($rs_valor_concepto,0);
		
		for($g=0;$g<pg_numrows($rs_total_unitario);$g++){
			$fila_sum = pg_fetch_array($rs_total_unitario,$g);
			$sumatoria = $fila_sum['cantidad'];
	
			$final = round(($sumatoria * 100) / $optimo);		
			
			$sql="SELECT concepto FROM evados.eva_escala WHERE desde<=".$final." AND hasta>=".$final;
			$rs_escala = pg_exec($this->Conec->conectar(),$sql) or die ("ERROR 8 ".$sql);
			$concepto = pg_Result($rs_escala,0);
			
			$sql="SELECT  ((SELECT  count(*)
			FROM evados.eva_relacion_evaluacion
			WHERE id_ano=".$ano." AND id_periodo=".$periodo." AND rut_evaluado=".$fila_sum['rut_evaluado']." and fecha_evaluacion is not null) * 100) / count(*) as porcentaje
			FROM evados.eva_relacion_evaluacion
			WHERE id_ano=".$ano." AND id_periodo=".$periodo." AND rut_evaluado=".$fila_sum['rut_evaluado']."";
			$rs_porcentaje = pg_exec($this->Conec->conectar(),$sql) or die ("ERROR 8 ".$sql);
			$porcentaje = pg_Result($rs_porcentaje,0);
			
			$sql="INSERT INTO evados.eva_cierre_evaluado_final (id_cierre,id_ano,id_periodo,id_plantilla,rut_evaluado,sumatoria,total_concepto,valor_final,evaluacion_final, porcentaje) VALUES(".$cierre.",".$ano.",".$periodo.",".$plantilla.",".$fila_sum['rut_evaluado'].",".$sumatoria.",".$optimo.",".$final.",'".$concepto."',".$porcentaje.")";
			$rs_insert = pg_exec($this->Conec->conectar(),$sql) or die ("ERROR 8 ".$sql);	
			
			
		}

		
		
	
	
	if($rs_cierre_evaluado){
		return $rs_cierre_evaluado;
	}else{
		return false;	
	}
}
}
?>