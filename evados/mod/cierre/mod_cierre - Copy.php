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

		$sql = "INSERT INTO evados.eva_cierre 
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
			
			$sql="SELECT id_cierre FROM evados.eva_cierre WHERE id_nacional=".$nacional." AND estado=1";
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
		
		public function insertcierreconcepto($nacional){
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
						
						$total = $fila_area['cantidad'] * $fila_con['peso'];
						
						$sql="INSERT INTO evados.eva_cierre_concepto (id_cierre,id_plantilla,id_concepto,id_cargo,peso,valor) VALUES(".$cierre.",".$fila['id_plantilla'].",".$fila_con['id_concepto'].",".$fila_area['id_bloque'].",".$fila_con['peso'].",".$total.")";
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
		
		
		
		public function insertcierredimension($nacional){
			$sql="SELECT id_cierre FROM evados.eva_cierre WHERE id_nacional=".$nacional." AND estado=1";
			$rs_cierre = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.3".$sql);	
			$cierre = pg_result($rs_cierre,0);
			
			$sql="SELECT id_plantilla FROM evados.eva_plantilla WHERE id_nacional=".$nacional;
			$result= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);	
			
			$sql="SELECT id_bloque FROM evados.eva_bloque";
			$rsbloque= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.2".$sql);	
			
			$sql="select peso,id_concepto from evados.eva_concepto where id_nacional=".$nacional." and estado=1 ORDER BY peso desc LIMIT 1 OFFSET 0";
			$rs_concepto =pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.6".$sql);	
			$peso = pg_result($rs_concepto,0);
			$id_concepto = pg_result($rs_concepto,1);
			
			$sql="SELECT id_bloque FROM evados.eva_bloque";
			$rs_bloque= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);
			
			for($i=0;$i<pg_numrows($result);$i++){
				$fila = pg_fetch_array($result,$i);
						
				for($j=0;$j<pg_numrows($rs_bloque);$j++){
					$fila_bloque =pg_fetch_array($rs_bloque,$j);
					
					$sql="SELECT count(*) as area, id_area FROM evados.eva_item_bloque WHERE id_plantilla=".$fila['id_plantilla']." AND id_bloque=".$fila_bloque['id_bloque']." GROUP BY id_area";
					$rs_cantidad_bloque= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);

					$sql="SELECT count(*) as area FROM evados.eva_item_bloque WHERE id_plantilla=".$fila['id_plantilla']."  and id_bloque=".$fila_bloque['id_bloque'];
					$rs_total_bloque= pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd insert 2.1".$sql);		
					$total_bloque = pg_result($rs_total_bloque,0);
					
					for($x=0;$x<pg_numrows($rs_cantidad_bloque);$x++){
						$fils = pg_fetch_array($rs_cantidad_bloque,$x);
						
						$porc_total = ($fils['area'] / $total_bloque) * 100 ;
						$porc_part =  $fils['area'] * $peso;
						
						$sql="INSERT INTO evados.eva_cierre_dimension (id_cierre,id_plantilla,id_area,id_cargo,cant_indicadores,porc_del_total,porc_participacion) VALUES (".$cierre.",".$fila['id_plantilla'].",".$fils['id_area'].",".$fila_bloque['id_bloque'].",".$fils['area'].",".$porc_total.",".$porc_part.")";
						$rs_insert= @pg_Exec( $this->Conec->conectar(),$sql );		
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
			
			if($rs_cierre){
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
