<?
header( 'Content-type: text/html; charset=iso-8859-1' );
require "../../class/Coneccion.class.php";

class Cierre {
       
	public $Conec;

//constructor 
		public function cierre($ip,$bd){
			$this->Conec = new DBManager($ip,$bd);
		 } 
       
		public function insertarcierre($fecha,$ano,$periodo,$usuario,$nacional){ 

		echo $sql = "INSERT INTO evados.eva_cierre 
		( fecha_cierre,nro_ano,periodo,estado,id_usuario,id_nacional) VALUES ('$fecha',$ano,$periodo,1,$usuario,$nacional);";
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 1" );
		
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
		
		public function insertcierregral($nacional){
			$sql="SELECT id_plantilla FROM evados.eva_plantilla WHERE id_nacional=".$nacional;
			$result= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);	
			
			$sql="SELECT id_bloque FROM evados.eva_bloque";
			$rsbloque= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.2".$sql);	
			
			$sql="SELECT id_cierre FROM evados.eva_cierre WHERE id_nacional=".$nacional." AND nro_ano=2017";
			$rs_cierre = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.3".$sql);	
			$cierre = pg_result($rs_cierre,0);
			
			
			for($i=0;$i<pg_numrows($result);$i++){
				$fila = pg_fetch_array($result,$i);
				$sql="SELECT count(*) as bloque, id_bloque FROM evados.eva_item_bloque eib WHERE eib.id_plantilla=".$fila['id_plantilla']." GROUP BY id_bloque ORDER BY id_bloque ASC";
				$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.4".$sql);	
				
				$sql="SELECT count(*) FROM evados.eva_plantilla_nacional WHERE id_plantilla=".$fila['id_plantilla'];
				$rs_plantilla = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.5".$sql);	
				$cantidad_indicadores = pg_result($rs_plantilla,0);
				
				$total = 0;
				
				for($j=0;$j<pg_numrows($regis);$j++){
					$fila_bloque = pg_fetch_array($regis,$j);
					
					$porc_del_total = intval(($fila_bloque['bloque'] * 100) / $cantidad_indicadores);
					
					$sql="INSERT INTO evados.eva_cierre_gral (id_cierre,id_plantilla,id_cargo,cant_indicadores,porc_del_total,porc_participacion) 
					VALUES (".$cierre.",".$fila['id_plantilla'].",".$fila_bloque['id_bloque'].",".$fila_bloque['bloque'].",".$porc_del_total.",0)";	
					$rs_insert =pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.6".$sql);				
					$total = $total + $fila_bloque['bloque'];
				}
				for($j=0;$j<pg_numrows($regis);$j++){
					$fila_bloque = pg_fetch_array($regis,$j);
					
					$part = $fila_bloque['bloque'] * 100 / $total;
					$sql="UPDATE evados.eva_cierre_gral SET porc_participacion=".$part." WHERE id_cierre=".$cierre." AND id_plantilla=".$fila['id_plantilla']." AND id_cargo=".$fila_bloque['id_bloque'];
					$rs_update =pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.6".$sql);	
				}
				
			}
			if($rs_update){
				   return true;
			}else{
				  return false;
			}
			
			
		}
		  
public function insertcierreconcepto($nacional,$ano,$periodo){
	
		 	$sql="SELECT id_cierre FROM evados.eva_cierre WHERE id_nacional=".$nacional." AND estado=1";
			$rs_cierre = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.3".$sql);	
			$cierre = pg_result($rs_cierre,0);
			
			$sql="SELECT id_plantilla FROM evados.eva_plantilla WHERE id_nacional=".$nacional;
			$result= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);	
			
			$sql="SELECT id_bloque FROM evados.eva_bloque";
			$rs_bloque= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);
			
			$sql="SELECT peso,id_concepto FROM evados.eva_concepto where id_nacional=".$nacional." and estado=1";			
			$rs_concepto= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);
			
			
			for($i=0;$i<pg_numrows($result);$i++){
				$fila = pg_fetch_array($result,$i);
				
				$sql="SELECT count(*) as cantidad, id_bloque  FROM evados.eva_item_bloque eib WHERE eib.id_plantilla=".$fila['id_plantilla']." GROUP BY id_bloque";
				$rs_area = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);
				
				for($j=0;$j<pg_numrows($rs_area);$j++){
					$fila_area = pg_fetch_array($rs_area,$j);
					
					for($x=0;$x<pg_numrows($rs_concepto);$x++){
						$fila_con = pg_fetch_array($rs_concepto,$x);
						
						$sql="select distinct ere.rut_evaluado from evados.eva_relacion_evaluacion ere 
INNER JOIN evados.eva_bloque_evaluador ebe ON ere.id_cargo=ebe.id_cargo AND ere.rut_evaluador=ebe.rut_evaluador and ebe.id_periodo=".$periodo." 
INNER JOIN evados.eva_plantilla ep ON ep.id_bloque=ere.cargo_evaluado 
where ebe.id_bloque=".$fila_area['id_bloque']." and id_ano=".$ano." and ere.id_periodo=".$periodo." and id_plantilla=".$fila['id_plantilla'];
						$rs_rel=pg_exec($this->Conec->conectar(),$sql);
						$total = $fila_area['cantidad'] * $fila_con['peso'];
						
						for($p=0;$p<pg_numrows($rs_rel);$p++){
							$fila_rel=pg_fetch_array($rs_rel,$p);
						
						//echo "<br>".$sql="INSERT INTO evados.eva_cierre_concepto (id_cierre,id_plantilla,id_concepto,id_cargo,peso,valor) VALUES(".$cierre.",".$fila['id_plantilla'].",".$fila_con['id_concepto'].",".$fila_area['id_bloque'].",".$fila_con['peso'].",".$total.")";
						$sql="INSERT INTO evados.eva_cierre_concepto (id_cierre,id_plantilla,id_concepto,id_cargo,id_ano,id_periodo,rut_evaluado,peso,valor) VALUES(".$cierre.",".$fila['id_plantilla'].",".$fila_con['id_concepto'].",".$fila_area['id_bloque'].",".$ano.",".$periodo.",".$fila_rel['rut_evaluado'].",".$fila_con['peso'].",".$total.")";
						$rs_insert = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);
						}
					}
				}
			}
			
			if($rs_insert){
				   return true;
			}else{
				  return false;
			}
		}
		
		
		
		public function insertcierredimension($nacional){
			$sql="SELECT id_cierre FROM evados.eva_cierre WHERE id_nacional=".$nacional." AND estado=1";
			$rs_cierre = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.3".$sql);	
			$cierre = pg_result($rs_cierre,0);
			
			$sql="SELECT id_plantilla FROM evados.eva_plantilla WHERE id_nacional=".$nacional;
			$result= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);	
			
			$sql="SELECT id_bloque FROM evados.eva_bloque";
			$rsbloque= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.2".$sql);	
			
			$sql="select peso,id_concepto from evados.eva_concepto where id_nacional=".$nacional." and estado=1";
			$rs_concepto =pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.6".$sql);	
			
			$sql="SELECT id_bloque FROM evados.eva_bloque";
			$rs_bloque= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);
			
			for($i=0;$i<pg_numrows($result);$i++){
				$fila = pg_fetch_array($result,$i);
						
				for($j=0;$j<pg_numrows($rs_bloque);$j++){
					$fila_bloque =pg_fetch_array($rs_bloque,$j);
					
					 $sql="SELECT count(*) as area, id_area FROM evados.eva_item_bloque WHERE id_plantilla=".$fila['id_plantilla']." AND id_bloque=".$fila_bloque['id_bloque']." GROUP BY id_area";
					$rs_cantidad_bloque= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);

					for($x=0;$x<pg_numrows($rs_cantidad_bloque);$x++){
						$fils = pg_fetch_array($rs_cantidad_bloque,$x);
						
						for($z=0;$z<pg_numrows($rs_concepto);$z++){
							$fila_concepto = pg_fetch_array($rs_concepto,$z);
							
							$valor = $fils['area'] * $fila_concepto['peso'];
	
							$sql="INSERT INTO evados.eva_cierre_dimension (id_cierre,id_plantilla,id_area,id_cargo,id_concepto,cant_indicadores,valor) VALUES (".$cierre.",".$fila['id_plantilla'].",".$fils['id_area'].",".$fila_bloque['id_bloque'].",".$fila_concepto['id_concepto'].",".$fils['area'].",".$valor.")";
							$rs_insert= @pg_Exec( $this->Conec->conectar(),$sql ) or die("Insert Fallo: ".$sql);				
						}
						
						
					}
				}
					
			}
			if($rs_insert){
				   return true;
			}else{
				  return false;
			}
				
		}
		
		public function insertcierrefunsion($nacional){
			$sql="SELECT id_cierre FROM evados.eva_cierre WHERE id_nacional=".$nacional." AND estado=1";
			$rs_cierre = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.3".$sql);	
			$cierre = pg_result($rs_cierre,0);
			
			$sql="SELECT id_plantilla FROM evados.eva_plantilla WHERE id_nacional=".$nacional;
			$result= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);	
			
			$sql="SELECT id_bloque FROM evados.eva_bloque";
			$rsbloque= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.2".$sql);	
			
			$sql="select peso,id_concepto from evados.eva_concepto where id_nacional=".$nacional." and estado=1";
			$rs_concepto =pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.6".$sql);	
			
			$sql="SELECT id_bloque FROM evados.eva_bloque";
			$rs_bloque= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);
			
			for($i=0;$i<pg_numrows($result);$i++){
				$fila = pg_fetch_array($result,$i);
						
				for($j=0;$j<pg_numrows($rs_bloque);$j++){
					$fila_bloque =pg_fetch_array($rs_bloque,$j);
					
					 $sql="SELECT count(*) as area, id_area,id_subarea FROM evados.eva_item_bloque WHERE id_plantilla=".$fila['id_plantilla']." AND id_bloque=".$fila_bloque['id_bloque']." GROUP BY id_area,id_subarea";
					$rs_cantidad_bloque= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);

					for($x=0;$x<pg_numrows($rs_cantidad_bloque);$x++){
						$fils = pg_fetch_array($rs_cantidad_bloque,$x);
						
						for($z=0;$z<pg_numrows($rs_concepto);$z++){
							$fila_concepto = pg_fetch_array($rs_concepto,$z);
							
							$valor = $fils['area'] * $fila_concepto['peso'];
	
							$sql="INSERT INTO evados.eva_cierre_funsion (id_cierre,id_plantilla,id_area,id_subarea,id_cargo,id_concepto,cant_indicadores,valor) VALUES (".$cierre.",".$fila['id_plantilla'].",".$fils['id_area'].",".$fils['id_subarea'].",".$fila_bloque['id_bloque'].",".$fila_concepto['id_concepto'].",".$fils['area'].",".$valor.")";
							$rs_insert= @pg_Exec( $this->Conec->conectar(),$sql );				
						}
						
						
					}
				}
					
			}
			if($rs_insert){
				   return true;
			}else{
				  return false;
			}
			
		}
		
		public function eliminacierre($nacional){
			$sql="DELETE FROM evados.eva_cierre WHERE id_nacional=".$nacional." AND estado=1";
			$result =pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.6".$sql);	
			
			if($result){
				   return true;
			}else{
				  return false;
			}	
		}

		
	
			 
} // FIN FUNCION


?>
