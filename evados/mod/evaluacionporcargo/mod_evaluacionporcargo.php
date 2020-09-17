<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
//print_r($_POST);
require "../../class/Membrete.class.php";

class PautaevaCargo {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	 

public function cargadorportafolio($r,$a){
	
$sql = "SELECT rut_evaluado,id_ano,id_documento,nombre_archivo,tipo_archivo,td.nombre as tipo_doc
FROM evados.eva_portafolio 
  inner join evados.eva_tipo_doc as td on td.id_tipo = id_documento
  WHERE rut_evaluado = $r AND id_ano = $a;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error EEEE1" );
		if($regis){
		 return $regis;
		}else{
		return false;
		}	
	
	}
	
	public function evaluadosporevaluadorcargo($r,$a,$i,$periodo)
	{
		$sql="SELECT DISTINCT v.id_bloque, ev.id_cargo,ev.rut_evaluador,ev.cargo_evaluado,c.nombre_cargo from evados.eva_relacion_evaluacion ev
              JOIN cargos c on c.id_cargo=ev.cargo_evaluado
			  JOIN evados.eva_bloque_evaluador v on v.rut_evaluador=ev.rut_evaluador
              where ev.rut_evaluador = $r and ev.id_ano=$a and ev.id_periodo=$periodo";	
			  
	    $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( $sql );
		
		/*echo "<pre>";
		echo $sql;
		echo "</pre>";*/
		
	    if($regis){  return $regis; }else{ return false; }
	}
	 
	 

   
   public function fechas_periodo_evaluacion($anio){
   			
   $sql = "SELECT CASE WHEN CURRENT_DATE  BETWEEN eee.fecha_inicio AND eee.fecha_termino 
					  THEN 1 ELSE 0 END as bool,eee.id_periodo   
					  FROM evados.eva_periodos_evaluacion eee
					  INNER JOIN evados.eva_periodo p ON p.id_periodo = eee.id_periodo 
					  WHERE eee.id_anio = $anio and eee.id_periodo in (
					  SELECT CASE WHEN CURRENT_DATE BETWEEN p.fecha_inicio AND p.fecha_termino 
					  THEN p.id_periodo ELSE 0 END as periodo
					  FROM evados.eva_periodo p WHERE p.id_ano = $anio )";
     
     $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error. 2");
     
     return $regis;
             	
      }

public function pautaporcargos($rut_evaluador,$id_cargo,$cargo_evaluado,$id_bloque,$id_nacional,$numero)
{
	$sql = "SELECT epa.id_area,epa.nombre as dimension,eps.id_subarea,eps.nombre as funcion, epi.id_item, epi.nombre as indicador,ep.id_plantilla
			FROM evados.eva_plantilla ep
			INNER JOIN evados.eva_item_bloque eib ON ep.id_plantilla=eib.id_plantilla and ep.id_nacional=$id_nacional
			INNER JOIN evados.eva_bloque_evaluador ebe ON eib.id_bloque=ebe.id_bloque
			INNER JOIN evados.eva_plantilla_area epa ON epa.id_area=eib.id_area
			INNER JOIN evados.eva_plantilla_subarea eps ON eps.id_subarea=eib.id_subarea
			INNER JOIN evados.eva_plantilla_item epi ON epi.id_item=eib.id_item
			WHERE ep.id_bloque=$cargo_evaluado and ebe.rut_evaluador=$rut_evaluador ORDER by epa.id_area,eps.id_subarea,epi.id_item  limit 1 offset $numero";
    // echo $sql;
     $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error. 2");
     return $regis;
}

public function cuenta_total($rut_evaluador,$id_cargo,$cargo_evaluado,$id_bloque,$id_nacional,$numero)
	{				
	$sql = "SELECT epa.id_area,epa.nombre as dimension,eps.id_subarea,eps.nombre as funcion, epi.id_item, epi.nombre as indicador,ep.id_plantilla
			FROM evados.eva_plantilla ep
			INNER JOIN evados.eva_item_bloque eib ON ep.id_plantilla=eib.id_plantilla and ep.id_nacional=$id_nacional
			INNER JOIN evados.eva_bloque_evaluador ebe ON eib.id_bloque=ebe.id_bloque
			INNER JOIN evados.eva_plantilla_area epa ON epa.id_area=eib.id_area
			INNER JOIN evados.eva_plantilla_subarea eps ON eps.id_subarea=eib.id_subarea
			INNER JOIN evados.eva_plantilla_item epi ON epi.id_item=eib.id_item
			WHERE ep.id_bloque=$cargo_evaluado and ebe.rut_evaluador=$rut_evaluador";	
	 $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error. 2 ".$sql);
     $total = pg_numrows($regis);
	 
	 return $total;
}

	
public function insert_evaluacion($datos,$id_conce,$a){
	
 $sql_insert = "INSERT INTO evados.eva_plantilla_evaluacion_tmp(id_plantilla,id_area,id_subarea,id_item,  
id_concepto,rut_evaluador,rut_evaluado,id_ano,id_cargo_evaluado,id_cargo_evaluador,ip_periodo) 
VALUES (".$datos[0].",".$datos[1].",".$datos[2].",".$datos[3].",".$id_conce.",".$datos[4].",".$datos[5].",".$a.",".$datos[7].",".$datos[8].",".$datos[6].");";

$regis = pg_Exec($this->Conec->conectar(),$sql_insert) or die($sql_insert)or die("fallo ".$sql_insert);  
		if($regis){
			   return $regis ;
			}else{
		       return false;
		    }		
          }


	
	public function fechaevaluacion($a,$b,$c,$p){
		
			$sql_update = "UPDATE evados.eva_relacion_evaluacion SET fecha_evaluacion = CURRENT_DATE
			WHERE id_ano = ".$a." AND rut_evaluado = ".$b." AND rut_evaluador = ".$c."; and id_periodo=".$p."";
			$regis = pg_Exec($this->Conec->conectar(),$sql_update) or die( "Error:".$sql_update );
		      	    
					if($regis){
						return  true;
					}else{
					    return false;
					}	
					
    		}
	
	
	
	
	public function borra_datos_tmp($rut_evaluador,$id_ano,$id_periodo)
	{
		$sql="delete from evados.eva_plantilla_evaluacion_tmp pe where pe.rut_evaluador=$rut_evaluador and pe.id_ano = $id_ano and pe.ip_periodo = $id_periodo";	
		$regis = pg_Exec($this->Conec->conectar(),$sql) or die( "Error d:".$sql );
	}
	
	
	public function nombre_emp($rut_evaluado)
	{
		$sql=" select em.nombre_emp||' '||em.ape_pat as nombre_emp from empleado em where em.rut_emp =$rut_evaluado";	
		$regis = pg_Exec($this->Conec->conectar(),$sql) or die( "Error B:".$sql );
		$nombre_emp = pg_result($regis,0);
		return $nombre_emp;
		
	}
	
	
	public function tabla_tmp($rut_evaluador,$id_ano,$periodo)
	{
		echo $sql="INSERT INTO 
  evados.eva_plantilla_evaluacion
(id_plantilla,
  id_area,
  id_subarea,
  id_item,
  id_concepto,
  rut_evaluador,
  rut_evaluado,
  id_ano,
  id_cargo_evaluado,
  id_cargo_evaluador,
  ip_periodo
) 
 (select tm.id_plantilla,tm.id_area,tm.id_subarea,tm.id_item,tm.id_concepto,tm.rut_evaluador,tm.rut_evaluado,tm.id_ano,tm.id_cargo_evaluado,tm.id_cargo_evaluador,tm.ip_periodo 
 from evados.eva_plantilla_evaluacion_tmp AS tm where tm.rut_evaluador=".$rut_evaluador." and tm.id_ano=".$id_ano." and tm.ip_periodo = ".$periodo.")";	
	
	//echo $sql;
	//print($sql);
		//$regis = pg_Exec($this->Conec->conectar(),$sql) or die( "Error B:".$sql );
		//$nombre_emp = pg_result($regis,0);
		//return $nombre_emp;
		if($regis){
		
		$sql_s = "select * from evados.eva_plantilla_evaluacion_tmp AS tm where tm.rut_evaluador=".$rut_evaluador." and tm.id_ano=".$id_ano." and tm.ip_periodo = ".$periodo.")";
			$regis_2 = pg_Exec($this->Conec->conectar(),$sql_s) or die( "Error B:".$sql_s );
			for($i=0; $i<pg_numrows($regis_2); $i++){
				
				$fila = pg_fetch_array($regis_2,$i);
				
				$sql_update = "UPDATE evados.eva_relacion_evaluacion SET fecha_evaluacion = CURRENT_DATE
			    WHERE id_ano = ".$id_ano." AND rut_evaluado = ".$fila['rut_evaluado']." AND rut_evaluador = ".$rut_evaluador."; and id_periodo=".$periodo."";
				
				$regis = pg_Exec($this->Conec->conectar(),$sql_update) or die( "Error B:".$sql_update );
				return $regis;
				}
		
		}else{
			
			return false;
			
			}
		
		
		
	}
	
	
	
	 public function tilde($campo){

		$dato="";
		
		for($s=0;$s<=strlen($campo);$s++){
			
			$letra = substr($campo,$s,1);
			
			if($s==0){
				
			  if($letra=="á"){
			    $dato .= str_replace("á","Á",$letra);
			   }else if($letra=="é"){
			    $dato .= str_replace("é","é",$letra);
			   }else if($letra=="í"){
			    $dato .= str_replace("í","Í",$letra);
			   }else if($letra=="ó"){
			    $dato .= str_replace("ó","Ó",$letra);
			   }else if($letra=="ú"){
			    $dato .= str_replace("ú","Ú",$letra);
			   }else if($letra=="ñ"){
			    $dato .= str_replace("ñ","Ñ",$letra);	
			   }else{
				$dato .= strtoupper($letra); //MAYUSCULA
				 }
			   
			 }else{
				 
			   if($letra=="Á"){
			    $dato .= str_replace("Á","á",$letra);
			   }else if($letra=="É"){
			    $dato .= str_replace("É","é",$letra);
			   }else if($letra=="Í"){
			    $dato .= str_replace("Í","í",$letra);
			   }else if($letra=="Ó"){
			    $dato .= str_replace("Ó","ó",$letra);
			   }else if($letra=="Ú"){
			    $dato .= str_replace("Ú","ú",$letra);
			   }else if($letra=="Ñ"){
			    $dato .= str_replace("Ñ","ñ",$letra);
			   }else if($letra=="á"){
			    $dato .= str_replace("á","á",$letra);
			   }else if($letra=="é"){
			    $dato .= str_replace("é","é",$letra);
			   }else if($letra=="í"){
			    $dato .= str_replace("í","í",$letra);
			   }else if($letra=="ó"){
			    $dato .= str_replace("ó","ó",$letra);
			   }else if($letra=="ú"){
			    $dato .= str_replace("ú","ú",$letra);
			   }else if($letra=="ñ"){
			    $dato .= str_replace("ñ","ñ",$letra);	
			   }else{
				$dato .= strtolower($letra); // MINUSCULA
				 }
				 
				 }
			 
			}//for
		   
		   return $dato;
	   		   
	     }
	
	
	
	}  //Fin Funcion 




?>

