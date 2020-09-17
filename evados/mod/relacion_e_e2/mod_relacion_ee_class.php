<?
require "../../class/Coneccion.class.php";

class Relacion_ee {
       
	public $Conec;
	
	//constructor 
	public function Relacion_ee($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
       

	public function insertar_relacion_ee($Arreglo_RutevaluadoresCargos,$rut_evaluado,$cargo_evaluado,$_ANO,$periodo){ 
       
      /* echo "<pre>";
	   print_r($Arreglo_RutevaluadoresCargos);
	   echo "<pre/>";*/
	   $sql="";
	   
	   for($i=1;$i<count($Arreglo_RutevaluadoresCargos);$i++){
		   
		  $array = explode("C",$Arreglo_RutevaluadoresCargos[$i]);
		 
		/*  echo "<pre>";
	      print_r($array);
	      echo "<pre/>";*/
		  
		   $select = "SELECT * FROM evados.eva_relacion_evaluacion WHERE id_ano=".$_ANO." AND rut_evaluado=".$array[0]." AND rut_evaluador=".$rut_evaluado." AND id_cargo = ".$cargo_evaluado." AND cargo_evaluado = ".$array[1]." AND id_periodo=".$periodo.";";
           $regis_select = pg_Exec( $this->Conec->conectar(),$select ) or die( "Error bd Select ".$select );

		if(pg_numrows($regis_select)==0){
			
		 $sql .= "INSERT INTO   
		evados.eva_relacion_evaluacion(id_ano,rut_evaluado,rut_evaluador,id_cargo,cargo_evaluado,id_periodo)
		VALUES(".$_ANO.",".$array[0].",".$rut_evaluado.",".$cargo_evaluado.",".$array[1].",".$periodo.");";
				
			   }
		       
		    }// fin for
			
			if($sql!=""){ 
			   $regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd :".$sql );
				 if($regis){
					return true;
				 }else{
					return false;
				   }
			}else{ 
			   return true; 
			 }
	
     }// fin metodo



	public function cargabloques($_ano){
			
	$sql = "SELECT id_bloque,nombre,porcentaje FROM evados.eva_bloque order by 2 ASC ;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 1" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			 
	 } 


		public function cargacargos(){
				
		$sql = "SELECT * FROM cargos ORDER BY nombre_cargo ASC;";
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
				if($regis){
					   return $regis;
				}else{
					  return false;
				}
				 
		 } 

    
public function buscarevaluadores($id_bloque,$idano,$periodo){ //Busca Evaluadores por Bloque 

 $sql = "SELECT DISTINCT ev.nombre As 
        bloque,evdor.rut_evaluador,evdor.id_cargo, ";
		
		if($id_bloque==15 or $id_bloque==14){
		$sql.="mat.id_curso,cu.ensenanza,grado_curso, letra_curso,";
		}
		
		
	$sql.="UPPER(COALESCE(em.nombre_emp,al.nombre_alu,ap.nombre_apo)) as nombre_emp,
	UPPER(COALESCE(em.ape_pat,al.ape_pat,ap.ape_pat)) as ape_pat,
	UPPER(COALESCE(em.ape_mat,al.ape_mat,ap.ape_mat)) as ape_mat
	FROM evados.eva_bloque As ev 
	INNER JOIN evados.eva_bloque_evaluador As evblo 
	ON evblo.id_bloque = ev.id_bloque AND evblo.id_bloque = ".$id_bloque." 
	INNER JOIN evados.eva_evaluador as evdor ON evdor.rut_evaluador = evblo.rut_evaluador AND evdor.id_cargo = evblo.id_cargo AND evdor.id_ano = ".$idano." AND evblo.id_periodo=".$periodo."  
	LEFT OUTER JOIN empleado As em ON em.rut_emp = evdor.rut_evaluador 
	LEFT OUTER JOIN alumno As al ON al.rut_alumno = evdor.rut_evaluador
	LEFT OUTER JOIN apoderado As ap ON ap.rut_apo = evdor.rut_evaluador ";
	
	if($id_bloque==15 ){
		$sql.="LEFT OUTER JOIN tiene2 t2 on al.rut_alumno=t2.rut_alumno 
               LEFT OUTER JOIN matricula mat on al.rut_alumno=mat.rut_alumno  and mat.id_ano=".$idano."  
			   LEFT OUTER JOIN curso cu ON mat.id_curso=cu.id_curso ";
		}
		
		if($id_bloque==14){
		$sql.="LEFT OUTER JOIN tiene2 t2 on ap.rut_apo=t2.rut_apo 
               LEFT OUTER JOIN matricula mat on t2.rut_alumno=mat.rut_alumno and mat.id_ano=".$idano."  
			   LEFT OUTER JOIN curso cu ON mat.id_curso=cu.id_curso ";
		}
	$sql.="WHERE ev.id_bloque = ".$id_bloque." ";
	if($id_bloque==15 or $id_bloque==14){
		$sql.="order by 5,6,7,9 ASC";
	}else{
		$sql.="order by 5,6 ASC";
	}
	
//	echo $sql;

$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2".$sql );
				
	if($regis){
		return $regis;
	}else{
		return false;
	   }
  
   }
	
	
	public function buscarevaluados($id_cargo,$idano,$rdb){ //Busca Evaluados por Cargo 
			
	  	$sql ="SELECT id_ano FROM evados.eva_ano_Escolar WHERE id_institucion=".$rdb." AND situacion=1";
		$rs_ano = @pg_exec($this->Conec->conectar(),$sql) or die("ERROR");
	
		$idano= @pg_result($rs_ano,0);
	    $sql = "SELECT distinct ca.id_cargo,ca.nombre_cargo,
		UPPER(em.nombre_emp) as nombre_emp,UPPER(em.ape_pat) as ape_pat,UPPER(em.ape_mat) as ape_mat,evaeva.rut_evaluado 
		FROM cargos ca 
		INNER JOIN trabaja tra on tra.cargo = ca.id_cargo
		INNER JOIN empleado em on em.rut_emp = tra.rut_emp
		INNER JOIN evados.eva_evaluado evaeva on evaeva.rut_evaluado = em.rut_emp 
		and evaeva.id_cargo = ca.id_cargo 
		and evaeva.id_ano = ".$idano." 
		WHERE ca.id_cargo = ".$id_cargo." order by 4,5,6;";
										
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 3" );
					
		if($regis){
			return $regis;
		}else{
			return false;
			}
	    
	  }
			
			
			
	
	
		public function buscarevaluadoresrelacionados($rut_evaluado,$ano,$periodo,$cargo){
			
		          /*$sql = "SELECT a.id_ano,a.rut_evaluado,a.rut_evaluador,a.id_cargo,ca.nombre_cargo,
					em.nombre_emp,em.ape_pat,em.ape_mat
					FROM evados.eva_relacion_evaluacion As a 
					INNER JOIN empleado As em ON em.rut_emp = a.rut_evaluador
					INNER JOIN cargos as ca ON ca.id_cargo = a.id_cargo
					WHERE a.rut_evaluado = $rut_evaluado;";*/
										
		  $sql = "SELECT a.id_ano,a.rut_evaluado,a.rut_evaluador,
						 a.id_cargo,
						COALESCE(ca.nombre_cargo, 
						CASE WHEN al.rut_alumno IS NOT NULL THEN 'Alumno' END,
						CASE WHEN ap.rut_apo IS NOT NULL THEN 'Apoderado' END) as nombre_cargo,
						COALESCE(em.nombre_emp,al.nombre_alu,ap.nombre_apo) as nombre_emp,
						COALESCE(em.ape_pat,al.ape_pat,ap.ape_pat) as ape_pat,
						COALESCE(em.ape_mat,al.ape_mat,ap.ape_mat) as 
						ape_mat,a.cargo_evaluado,a.fecha_evaluacion 
						FROM evados.eva_relacion_evaluacion As a 
						LEFT OUTER JOIN empleado As em ON em.rut_emp = a.rut_evaluador 
						LEFT OUTER JOIN alumno As al ON al.rut_alumno = a.rut_evaluador
						LEFT OUTER JOIN apoderado As ap ON ap.rut_apo = a.rut_evaluador
						LEFT OUTER JOIN cargos as ca ON ca.id_cargo = a.id_cargo
						WHERE a.rut_evaluado = $rut_evaluado and a.id_ano= $ano AND a.id_periodo=$periodo AND a.cargo_evaluado=$cargo ORDER BY 5,6;";
			$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error :".$sql );
			
			    if($regis){
				   return $regis;
				}else{
				   return false;
				}
		   
		   } 
	



		public function eliminar_relacion($rut_evaluador,$id_cargo,$rut_evaluado,$cargo_evaluado){
				
        $sql = "SELECT ee.fecha_evaluacion  FROM evados.eva_relacion_evaluacion ee  
		WHERE  ee.rut_evaluador = $rut_evaluador  
        and ee.id_cargo = $id_cargo 
        and ee.rut_evaluado = $rut_evaluado
        and ee.cargo_evaluado =  $cargo_evaluado";
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Select 23" );
        
		if($regis){
			
			if(pg_num_rows($regis)!=0){
				
				    $fila = pg_fetch_array($result,0);
				     
					 if($fila['fecha_evaluacion']==NULL){
						 
						$sql = "DELETE FROM evados.eva_relacion_evaluacion ee WHERE  ee.rut_evaluador = $rut_evaluador  and ee.id_cargo = $id_cargo and ee.rut_evaluado = $rut_evaluado and ee.cargo_evaluado =  $cargo_evaluado";
						$regis2 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Delete 1" );
													 
				        }
				         
				     }
			        
			      }
				  
		 if($regis2){
			   return true;
			}else{
				return false;
				}
		
		} 




	public function mostrar_evaluadores($ano,$periodo){
		 
		$sql="SELECT  a.rut_evaluador,
					COALESCE(ap.dig_rut,al.dig_rut,em.dig_rut) as dig_rut,
					CASE 
					WHEN em.nombre_emp IS NOT NULL THEN UPPER(e.nombre_cargo)
					WHEN ap.nombre_apo IS NOT NULL THEN UPPER('Apoderado')
					WHEN al.nombre_alu IS NOT NULL THEN UPPER('Alumno')
					END as cargo,
					UPPER(COALESCE(em.nombre_emp,ap.nombre_apo,al.nombre_alu)) as nombre,
					UPPER(COALESCE(em.ape_pat,ap.ape_pat,al.ape_pat)) as ape_pat,
					UPPER(COALESCE(em.ape_mat,ap.ape_mat,al.ape_mat)) as ape_mat,
					a.id_ano, a.id_cargo as dato 
					FROM 
					evados.eva_evaluador a 
					LEFT OUTER JOIN public.cargos e ON e.id_cargo = a.id_cargo  
					LEFT OUTER JOIN public.empleado em ON em.rut_emp = a.rut_evaluador
					LEFT OUTER JOIN public.alumno al ON al.rut_alumno = a.rut_evaluador
					LEFT OUTER JOIN public.apoderado ap ON ap.rut_apo = a.rut_evaluador
					WHERE a.id_ano = $ano and a.id_periodo=$periodo;";
			$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			return $result;
			 }

		
		public function mostrar_evaluados($rut,$ano,$periodo,$cargo){
	   		$sql="SELECT  a.rut_evaluado,
					COALESCE(em_evdo.dig_rut,al_evdo.dig_rut,ap_evdo.dig_rut) as dig_rut, 
					CASE 
					WHEN em_evdo.rut_emp IS NOT NULL THEN UPPER(ca_evdo.nombre_cargo)
					WHEN ap_evdo.rut_apo IS NOT NULL THEN UPPER('Apoderado') 
					WHEN al_evdo.rut_alumno IS NOT NULL THEN UPPER('Alumno') 
					END as cargo,
					UPPER(COALESCE(em_evdo.nombre_emp,ap_evdo.nombre_apo,al_evdo.nombre_alu)) as nombre_emp_evaluador, 
					UPPER(COALESCE(em_evdo.ape_pat,ap_evdo.ape_pat,al_evdo.ape_pat)) as ape_pat_evaluador, 
					UPPER(COALESCE(em_evdo.ape_mat,ap_evdo.ape_mat,al_evdo.ape_mat)) as ape_mat_evaluador,
					CASE 
					WHEN a.fecha_evaluacion IS NOT NULL THEN 'Evaluado'
					ELSE 'No Evaluado' END as Estado_evaluacion,
					a.fecha_evaluacion as Fecha_Evaluacion
					FROM evados.eva_relacion_evaluacion As a 
					LEFT OUTER JOIN empleado As em_evdo ON em_evdo.rut_emp = a.rut_evaluado 
					LEFT OUTER JOIN alumno As al_evdo ON al_evdo.rut_alumno = a.rut_evaluado 
					LEFT OUTER JOIN apoderado As ap_evdo ON ap_evdo.rut_apo = a.rut_evaluado 
					LEFT OUTER JOIN cargos as ca_evdo ON ca_evdo.id_cargo = a.cargo_evaluado 
					WHERE a.rut_evaluador = $rut AND a.id_ano = $ano AND a.id_periodo=$periodo AND a.id_cargo=".$cargo." ORDER BY 3;";
			$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			return $result;
		 }
		
		
		
		
		public function institucion($inst){

			$sql_ins = "SELECT UPPER(institucion.nombre_instit) as nombre_instit, UPPER(institucion.calle) as calle, 
			institucion.nro,   region.nom_reg, provincia.nom_pro, region,ciudad,comuna,UPPER(comuna.nom_com) as nom_com, 
			institucion.telefono,institucion.fax,dig_rdb, email,letra_inst,area_geo, dependencia, nu_resolucion, 
			fecha_resolucion,numero_inst 
			FROM institucion 
			INNER JOIN region ON institucion.region = region.cod_reg 
			INNER JOIN provincia ON  institucion.ciudad = provincia.cor_pro AND institucion.region = provincia.cod_reg 
			INNER JOIN comuna  ON institucion.region = comuna.cod_reg 
			AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) 
			WHERE institucion.rdb=".$inst." ";
			$result_ins = pg_exec( $this->Conec->conectar(),$sql_ins ) or die ("Select falló : ".$sql_ins);
			return  pg_fetch_array($result_ins,0);	
					
			 }
			 
 
 
 
 public function anoescolar($inst){

$sql = "SELECT * from ano_escolar aes where aes.id_institucion = ".$inst." and aes.situacion = 1";

$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd E#e#ee#" );
return pg_fetch_array($regis,0);


 } 
 
  public function periodo($periodo){
			$sql ="SELECT nombre_periodo FROM periodo WHERE id_periodo=".$periodo;
			$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd periodo" );
			return pg_fetch_array($regis,0);	
		}
 
 
 public 	function tilde($campo){

		$dato="";
		
		for($s=0;$s<=strlen($campo);$s++){
			
			$letra = substr($campo,$s,1);
			
			if($s==0){
				
			  if($letra=="á"){
			    $dato .= str_replace("á","Á",$letra);
			   }else if($letra=="é"){
			    $dato .= str_replace("é","É",$letra);
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
			   }else{
				$dato .= strtolower($letra); // MINUSCULA
				 }
				 
				 }
			 
			}//for
		   
		   return $dato;
	   		   
	     }


   public 	function CopiarRelacionados($a,$b,$periodo){
		
	$sql = "SELECT * FROM evados.eva_relacion_evaluacion eere  WHERE  eere.id_ano = $a AND eere.id_periodo=$periodo";
		
		$result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error 11" );
        
		if(pg_num_rows($result) > 0){
			
			return false;
			
		  }else{
		  	$sql = "SELECT * FROM evados.eva_relacion_evaluacion eere  WHERE  eere.id_ano = $a";
			$rs_existe = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error 11" );
			if(pg_num_rows($rs_existe) > 0){
				$ant_periodo = $periodo - 1;
				if($b==133){
					$ant_periodo =2382;
				}	
				if($b==17686){
					$ant_periodo =2539;
				}
				if($b==4655){
					$ant_periodo =2538;
				}
				$sql = 'INSERT INTO evados.eva_relacion_evaluacion (id_ano,rut_evaluado, rut_evaluador, fecha_evaluacion, id_cargo, cargo_evaluado,id_periodo)( 
						SELECT '.$a.' as id_ano,rut_evaluado,rut_evaluador,NULL as fecha_evaluacion,id_cargo,cargo_evaluado,'.$periodo.' 
						FROM evados.eva_relacion_evaluacion eere WHERE eere.id_ano = '.$a.' and eere.id_periodo='.$ant_periodo.')';
			}else{
			  $sql = 'INSERT INTO evados.eva_relacion_evaluacion (id_ano,rut_evaluado,rut_evaluador,fecha_evaluacion, id_cargo,cargo_evaluado)( 
						SELECT '.$a.' as id_ano,rut_evaluado,rut_evaluador,NULL as fecha_evaluacion,id_cargo,cargo_evaluado 
						FROM evados.eva_relacion_evaluacion eere WHERE eere.id_ano = 
						( SELECT ae.id_ano FROM ano_escolar ae WHERE ae.id_institucion = '.$b.' 
						and ae.nro_ano = (SELECT (a.nro_ano - 1) as anio FROM ano_escolar a WHERE a.id_ano = '.$a.') ) )';
			}

		    $result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error 12" );
		          
				  if($result){
				  	      return true; 
				  }else{
				  	      return false; 
				  }
				  
		  }
   
       }   
   
   
   
   	public function buscarevaluadorestodos($id_bloque,$cargo_evaluado,$idano,$periodo,$rut_evaluado){ //Busca Evaluadores por Bloque 

 $sql = "SELECT ev.nombre As 
        bloque,evdor.rut_evaluador,evdor.id_cargo, ";
		
		if($id_bloque==15 or $id_bloque==14){
		$sql.="mat.id_curso,";
		}
		
		
	$sql.="UPPER(COALESCE(em.nombre_emp,al.nombre_alu,ap.nombre_apo)) as nombre_emp,
	UPPER(COALESCE(em.ape_pat,al.ape_pat,ap.ape_pat)) as ape_pat,
	UPPER(COALESCE(em.ape_mat,al.ape_mat,ap.ape_mat)) as ape_mat
	FROM evados.eva_bloque As ev 
	INNER JOIN evados.eva_bloque_evaluador As evblo 
	ON evblo.id_bloque = ev.id_bloque AND evblo.id_bloque = ".$id_bloque." AND evblo.id_periodo=".$periodo."  
	INNER JOIN evados.eva_evaluador as evdor ON evdor.rut_evaluador = evblo.rut_evaluador AND evdor.id_cargo = evblo.id_cargo AND evdor.id_ano = ".$idano." AND evdor.id_periodo=".$periodo."  
	LEFT OUTER JOIN empleado As em ON em.rut_emp = evdor.rut_evaluador 
	LEFT OUTER JOIN alumno As al ON al.rut_alumno = evdor.rut_evaluador
	LEFT OUTER JOIN apoderado As ap ON ap.rut_apo = evdor.rut_evaluador ";
	
	if($id_bloque==15 ){
		$sql.="LEFT OUTER JOIN tiene2 t2 on al.rut_alumno=t2.rut_alumno 
               LEFT OUTER JOIN matricula mat on al.rut_alumno=mat.rut_alumno  and mat.id_ano=".$idano."  ";
		}
		
		if($id_bloque==14){
		$sql.="LEFT OUTER JOIN tiene2 t2 on ap.rut_apo=t2.rut_apo 
               LEFT OUTER JOIN matricula mat on t2.rut_alumno=mat.rut_alumno and mat.id_ano=".$idano."  ";
		}
		
		
	
	$sql.="WHERE ev.id_bloque = ".$id_bloque." order by 3";
	
	/*echo $sql;
	exit;*/
$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2".$sql);
				
	if($regis){
		
		
			for($i=0;$i<pg_numrows($regis);$i++){
				
				$fila_evaluador=pg_fetch_array($regis,$i);
				
		
		   $select = "SELECT * FROM evados.eva_relacion_evaluacion WHERE id_ano=".$idano." AND rut_evaluado=".$rut_evaluado." AND rut_evaluador=".$fila_evaluador['rut_evaluador']." AND id_cargo = ".$fila_evaluador['id_cargo']." AND cargo_evaluado = ".$cargo_evaluado." AND id_periodo=".$periodo.";";
           $regis_select = pg_Exec( $this->Conec->conectar(),$select );

		//if(@pg_numrows($regis_select)==0){
			
	    $sql_insert = "INSERT INTO evados.eva_relacion_evaluacion(id_ano,rut_evaluado,rut_evaluador,id_cargo,cargo_evaluado,id_periodo)
		VALUES(".$idano.",".$rut_evaluado.",".$fila_evaluador['rut_evaluador'].",".$fila_evaluador['id_cargo'].",".$cargo_evaluado.",".$periodo.");";
				
				$regis_insert = @pg_Exec( $this->Conec->conectar(),$sql_insert );
			  // }
		
		}
		if($regis_insert){
		return $regis_insert;
		}else{
		return false;	
		}
	}else{
		return false;
	   }
  
   }
   
	public function Avance($ano,$periodo){
			$sql="SELECT count(*) FROM evados.eva_relacion_evaluacion WHERE id_ano=".$ano." AND id_periodo=".$periodo." ";
			$rs_relaciones = @pg_Exec( $this->Conec->conectar(),$sql );
			$relacion = pg_result($rs_relaciones,0);
			
			$sql="SELECT count(*) FROM evados.eva_relacion_evaluacion WHERE id_ano=".$ano." AND id_periodo=".$periodo." AND fecha_evaluacion is not null";
			$rs_realizadas = @pg_Exec( $this->Conec->conectar(),$sql );
			$realizadas = pg_result($rs_realizadas,0);
			
			$porcentaje = substr((($realizadas * 100 ) / $relacion),0,5);
			return $porcentaje;
	}
			 
   } // FIN CLASE

?>
