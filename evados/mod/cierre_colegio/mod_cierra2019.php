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
	$sql="SELECT id_plantilla,nombre FROM evados.eva_plantilla WHERE id_nacional=".$nacional." ORDER BY nombre ASC";
	$rs_bloque =  pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2".$sql );
	
	if($rs_bloque){
		return $rs_bloque;	
	}else{
		return false;
	}
}

public function CicloPlantillas($nacional,$id){
	$sql="SELECT id_plantilla,nombre FROM evados.eva_plantilla WHERE id_nacional=".$nacional." ORDER BY nombre ASC LIMIT 1 OFFSET  ".$id.";";
	$rs_ciclo =  pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert ->".$sql );
	
	if($rs_ciclo){
		return $rs_ciclo;	
	}else{
		return false;
	}
}


public function cierre_evaluado($nacional,$a,$ano){
	//$a=32;
//	$sql="SELECT id_plantilla,id_bloque FROM evados.eva_plantilla WHERE id_nacional=".$nacional."  ORDER BY id_bloque ASC LIMIT 1 OFFSET $a";
	echo $sql="SELECT id_plantilla,id_bloque FROM evados.eva_plantilla WHERE id_nacional=".$nacional." AND id_plantilla=".$a." ORDER BY id_bloque ASC ";
	$rs_plantilla = pg_exec($this->Conec->conectar(),$sql);
	$plantilla =  pg_result($rs_plantilla,0);
	$bloque = pg_result($rs_plantilla,1);
	
	$sql="SELECT id_cierre FROM evados.eva_cierre WHERE id_nacional=".$nacional." AND estado=1";
	$rs_cierre = pg_exec($this->Conec->conectar(),$sql);
	$cierre = pg_result($rs_cierre,0);

	$sql="SELECT id_periodo FROM evados.eva_periodo WHERE id_ano=".$ano." AND (cerrado=0 or cerrado is null) ";
	$rs_periodo =  pg_exec($this->Conec->conectar(),$sql);
	$periodo = pg_result($rs_periodo,0);
	
	$sql="SELECT DISTINCT id_area FROM evados.eva_plantilla_evaluacion WHERE id_plantilla=".$plantilla." AND ip_periodo=".$periodo;
	$rs_areas = pg_exec($this->Conec->conectar(),$sql);
	
	$sql="SELECT id_concepto, peso, optimo  FROM evados.eva_concepto WHERE id_nacional=".$nacional." AND estado=1";
	$rs_concepto = pg_exec($this->Conec->conectar(),$sql);
	
	$sql="SELECT distinct rut_evaluado FROM evados.eva_plantilla_evaluacion WHERE id_plantilla=".$plantilla." AND ip_periodo=".$periodo."";
	$rs_evaluados = pg_exec($this->Conec->conectar(),$sql);
	
	
	for($x=0;$x<pg_numrows($rs_areas);$x++){
		$fila_area= pg_fetch_array($rs_areas,$x);
		$obtenido_dimension = 0;
		
	for($i=0;$i<pg_numrows($rs_evaluados);$i++){
		$fila_evaluados = pg_fetch_array($rs_evaluados,$i);
		
		$sql="SELECT distinct id_cargo_evaluador, c.nombre_cargo
				FROM evados.eva_plantilla_evaluacion epe
				INNER JOIN cargos c ON c.id_cargo=epe.id_cargo_evaluador
				WHERE id_plantilla=".$plantilla."
				AND rut_evaluado=".$fila_evaluados['rut_evaluado']."
				AND ip_periodo=".$periodo."
				ORDER BY 1";
		$rs_cargos  =pg_exec($this->Conec->conectar(),$sql);	
		$porcentaje_dimension = 0;
		$cantidad_indicadores = 0;
		$obtenido_dimension = 0;
		for($j=0;$j<pg_numrows($rs_cargos);$j++){
			$fila_cargos = pg_fetch_array($rs_cargos,$j);
				for($c=0;$c<pg_numrows($rs_concepto);$c++){
					$fila_concepto = pg_fetch_array($rs_concepto,$c);
					
					 $sql="SELECT count(*) as cantidad
							FROM evados.eva_plantilla_evaluacion epe 
							WHERE id_plantilla=".$plantilla."
							AND rut_evaluado=".$fila_evaluados['rut_evaluado']."
							AND ip_periodo=".$periodo."
							and id_cargo_evaluador=".$fila_cargos['id_cargo_evaluador']."
							AND id_area=".$fila_area['id_area']."  AND epe.id_concepto=".$fila_concepto['id_concepto'];
					$rs_resultado = pg_exec($this->Conec->conectar(),$sql);
					
					$cantidad_indicadores += pg_result($rs_resultado,0);
					echo "<br> Obtenido -->".$obtenido_dimension += pg_result($rs_resultado,0) * $fila_concepto['peso'];
				} // fin conceptos
			} // fin cargos
			$obtenido_dimension;
			$optimo_dimension = $cantidad_indicadores * 4;
			
			
			$porcentaje_dimension = round(($obtenido_dimension * 100)/$optimo_dimension);
			
			$sql="SELECT concepto FROM evados.eva_escala WHERE desde<=".$porcentaje_dimension." AND hasta>=".$porcentaje_dimension."";
			$rs_escala = pg_exec($this->Conec->conectar(),$sql);
			$escala = pg_result($rs_escala,0);
			
			$sql="UPDATE evados.eva_cierre_dimension_final SET sumatoria=".$optimo_dimension.", total_concepto=".$obtenido_dimension.", valor_final=".$porcentaje_dimension.", evaluacion_final='".$escala."' WHERE id_cierre=".$cierre." AND id_periodo=".$periodo." AND rut_evaluado=".$fila_evaluados['rut_evaluado']." AND id_plantilla=".$plantilla." AND id_area=".$fila_area['id_area']."";
			$rs_dimension = pg_exec($this->Conec->conectar(),$sql);
		}// fin evaluados
	} // fin dimensiones
	
	
	for($i=0;$i<pg_numrows($rs_evaluados);$i++){
		$fila_evaluado = pg_fetch_array($rs_evaluados,$i);
		
		$sql="SELECT avg(valor_final) FROM evados.eva_cierre_dimension_final WHERE id_cierre=".$cierre." AND id_periodo=".$periodo." AND id_plantilla=".$plantilla." AND rut_evaluado=".$fila_evaluado['rut_evaluado'];		
		$rs_calculo = pg_exec($this->Conec->conectar(),$sql);
		echo "<br> nuevo valor final-->".$valor_final = round(pg_result($rs_calculo,0));
		
		$sql="SELECT sumatoria FROM evados.eva_cierre_evaluado_final WHERE id_cierre=".$cierre." AND id_periodo=".$periodo." AND id_plantilla=".$plantilla." AND rut_evaluado=".$fila_evaluado['rut_evaluado'];		
		$rs_optimo = pg_exec($this->Conec->conectar(),$sql);
		echo "<br> nuevo optimo-->".$new_optimo = round((pg_result($rs_optimo,0) * 100 ) / $valor_final);
		
		$sql="SELECT concepto FROM evados.eva_escala WHERE desde<=".$valor_final." AND hasta>=".$valor_final."";
		$rs_escala = pg_exec($this->Conec->conectar(),$sql);
		$concepto= pg_result($rs_escala,0);
		
		echo "<br>".$sql="UPDATE evados.eva_cierre_evaluado_final SET valor_final=".$valor_final.", total_concepto=".$new_optimo.", evaluacion_final='".$concepto."' WHERE id_cierre=".$cierre." AND id_periodo=".$periodo." AND id_plantilla=".$plantilla." AND rut_evaluado=".$fila_evaluado['rut_evaluado'];
		$rs_final = pg_exec($this->Conec->conectar(),$sql);
		
	}

	if($rs_final){
		echo 1;
	}else{
		echo 2;
	}
}
}
?>