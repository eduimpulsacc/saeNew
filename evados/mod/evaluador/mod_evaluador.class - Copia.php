<?

require "../../class/Coneccion.class.php";

class Evaluador{
       
	public $Conec;
	
	//constructor 
	public function Evaluador($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 

	public function listadoEvaluados($rdb,$cargo,$ano,$periodo){  // guarda en la base datos 
	
		$sql = "SELECT 
		empleado.rut_emp as rut ,empleado.dig_rut as dv
		,UPPER(CAST(ape_pat || ' ' || ape_mat  || ' ' || empleado.nombre_emp as varchar)) as nombre, 
		eva.porcentaje,eva.id_cargo
		FROM empleado 
		INNER JOIN trabaja ON empleado.rut_emp=trabaja.rut_emp
		INNER JOIN cargos ON trabaja.cargo=cargos.id_cargo And cargos.id_cargo = ".$cargo." 
		LEFT JOIN evados.eva_evaluador eva ON empleado.rut_emp=eva.rut_evaluador   AND eva.id_periodo=".$periodo." 
		and id_ano=".$ano." and  eva.id_cargo = ".$cargo." WHERE trabaja.rdb=".$rdb. " ORDER BY nombre ASC; "; 
	    
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo 1:".$sql);
		
	    return $result;
	  
	 }
	
	
	public function listadoalumnos($ano,$id_curso,$cargo,$periodo){
	
	$sql = "SELECT alumno.rut_alumno as rut,alumno.dig_rut as dv,
        UPPER(CAST(alumno.ape_pat || ' ' ||alumno.ape_mat ||' '||alumno.nombre_alu as varchar)) as nombre,
		eva.porcentaje,eva.id_cargo
		FROM curso 
		inner join matricula on matricula.id_curso = curso.id_curso
		inner join alumno on alumno.rut_alumno = matricula.rut_alumno
		LEFT JOIN evados.eva_evaluador eva ON alumno.rut_alumno = eva.rut_evaluador and eva.id_ano=".$ano." and  
		eva.id_cargo = ".$cargo." WHERE curso.id_curso = ".$id_curso."   AND curso.id_ano =".$ano." order by 3";
	    
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo 2:".$sql);
	    
		return $result;
	  
	  }
	
	
	public function listadoapoderados($ano,$id_curso,$cargo){
			
	  $sql = "SELECT DISTINCT
	  apoderado.rut_apo as rut,apoderado.dig_rut as dv,
	  UPPER(CAST(apoderado.ape_pat ||' '|| apoderado.ape_mat||' '|| apoderado.nombre_apo as varchar)) as nombre,
	  eva.porcentaje,eva.id_cargo
	  FROM curso 
	  INNER JOIN matricula on matricula.id_curso = curso.id_curso
	  INNER JOIN alumno on alumno.rut_alumno = matricula.rut_alumno
	  LEFT join tiene2 on tiene2.rut_alumno = alumno.rut_alumno 
	  LEFT join apoderado on apoderado.rut_apo = tiene2.rut_apo
	  LEFT JOIN evados.eva_evaluador eva ON apoderado.rut_apo = eva.rut_evaluador and eva.id_ano=".$ano." and  
	  eva.id_cargo = ".$cargo." where curso.id_curso = ".$id_curso."  AND curso.id_ano =".$ano." order by 3";
	
	  $result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo 3:".$sql);
	  
	  return $result;
	
	  }

	

public function InsertaDocente($rut,$ano,$porc,$cargo,$rdb,$curso,$ente,$id_periodo){
	
	
		/*************************TRAIGO EL PERIODO******************************************/
		 /*$fecha =  date(d.'/'.m.'/'.Y); 
		$sql_per="select id_periodo from periodo p where p.fecha_inicio >='07/09/2012 ' and p.fecha_termino<='07/09/2012';";
		$rs_per=pg_exec($this->Conec->conectar(),$sql_per) or die("Fallo ".$sql_per);
		 $fila_per = @pg_fetch_array($rs_per,0);
		 $id_periodo = $fila_per[0];*/
		/*************************************************************************************/	
	
	
	$insert = "";
	
	if($rut=='todos'){
		
		if($ente=='1'){
			$result = $this->listadoEvaluados($rdb,$cargo,$ano,$id_periodo);
		}elseif($ente=='2'){
			$result = $this->listadoalumnos($ano,$curso,$cargo);
		}elseif($ente=='3'){
			$result = $this->listadoapoderados($ano,$curso,$cargo);
		 }
	
	  if(pg_num_rows($result)!=0){
		   	
			for($i=0;$i<pg_num_rows($result);$i++){
				
			    $fila = @pg_fetch_array($result,$i); 
			   
				if($fila['rut']!=""){   
				
					
				echo $sql_2 = "SELECT * FROM evados.eva_evaluador WHERE 
				id_ano = ".$ano." AND  rut_evaluador =".$fila['rut']." AND 
				porcentaje = 1  AND id_cargo=".$cargo."  and id_periodo=".$periodo." ; ";
				
				$rs_1 = pg_exec($this->Conec->conectar(),$sql_2) or die ("fallo:".$sql_2);	
								
				if(pg_num_rows($rs_1)==0){
			  	     
					if(!$this->crear_perfil($fila['rut'],$rdb)) return false;
									 
					echo $insert .="INSERT INTO evados.eva_evaluador (id_ano,rut_evaluador,porcentaje,id_cargo,id_periodo) 
					VALUES(".$ano.",".$fila['rut'].",1,".$cargo.",".$id_periodo.");";
			    
				    }
				  				  
				  }
			    
				}
            
	 if($insert!=""){
			
	 $rs_docente = pg_exec($this->Conec->conectar(),$insert) or die(pg_last_error($this->Conec->conectar()));	    
	  
	 }
			 
	}
	
  }else{
	        
	 if($this->crear_perfil($rut,$rdb)){ 
			
		//AND  porcentaje = 1  AND id_cargo=".$cargo." 
		echo $sql = "SELECT * FROM evados.eva_evaluador 
		WHERE id_ano = ".$ano." AND  rut_evaluador =".$rut." and id_periodo=".$id_periodo." ; ";
		$rs = pg_exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);	
				
		if(pg_num_rows($rs)==0){
					
			echo $insert ="INSERT INTO evados.eva_evaluador (id_ano,rut_evaluador,porcentaje,id_cargo,id_periodo) 
			VALUES(".$ano.",".$rut.",".$porc.",".$cargo.",".$id_periodo.");";
			$rs_docente = pg_exec($this->Conec->conectar(),$insert);
			
		 }
			
	  }else{ 
				 
		//AND  porcentaje = 1  AND id_cargo=".$cargo." 
		echo $sql = "SELECT * FROM evados.eva_evaluador 
		WHERE id_ano = ".$ano." AND  rut_evaluador =".$rut." and id_periodo=".$id_periodo." ; ";
		$rs = pg_exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);	
		
			if(pg_num_rows($rs)==0){
					
				echo $insert ="INSERT INTO evados.eva_evaluador (id_ano,rut_evaluador,porcentaje,id_cargo,id_periodo) 
				VALUES(".$ano.",".$rut.",".$porc.",".$cargo.",".$id_periodo.");";
				$rs_docente = pg_exec($this->Conec->conectar(),$insert);
				
			}
				  
	   }
	
	}
	
	if($rs_docente){
	  	return true;
	}else{
		return false;
	 }

   
   }

    
	public function crear_perfil($rut_evaluador,$rdb){
		
			// Busco el id usuario para insertar un registro en la tabla accede con perfil evaluador
			$sql_3 = "SELECT * FROM usuario WHERE nombre_usuario = '".$rut_evaluador."'; ";
			$rs_usuario = pg_exec($this->Conec->coi_usuario(),$sql_3);
		
			if($rs_usuario){
			
			if(pg_num_rows($rs_usuario)!=0){
					 
					$fila = pg_fetch_array($rs_usuario,0);
					
					$sql_5 = "SELECT * FROM public.accede WHERE id_usuario= ".$fila['id_usuario']." 
					AND id_perfil= 41 AND rdb = ".$rdb."; ";
					$rs_accede = pg_exec($this->Conec->coi_usuario(),$sql_5);
					
					if(pg_num_rows($rs_accede)==0){					
					
					$insert_accede = "INSERT INTO public.accede (id_usuario,id_perfil,rdb,estado) 
					VALUES (".$fila['id_usuario'].",41,".$rdb.",0);";
					$rs_accede = pg_exec($this->Conec->coi_usuario(),$insert_accede);								
					
					}else{ 
					      
					  return true; 
						  
					   }
					
				}else{ 
				
				// en caso que no existe el usuario 
				//creo el registro en tabla usuario y 
				//accede con perfil evaluador
				 
				 $sql_4 = "SELECT max(id_usuario) FROM public.usuario;";
				 $rs_usuario = pg_exec($this->Conec->coi_usuario(),$sql_4);
				 
				 if($rs_usuario){
					 if(pg_num_rows($rs_usuario)!=0){
						 
						 $fila = pg_fetch_array($rs_usuario,0);
						 
						 $id=$fila['max']+1;
						 
						  $insert_usuario =  "INSERT INTO public.usuario(id_usuario,nombre_usuario,pw) 
						 VALUES (".$id.",'".$rut_evaluador."','12345');";
                         $rs_insert = pg_exec($this->Conec->coi_usuario(),$insert_usuario);
						 
						 $insert_accede = "INSERT INTO public.accede (id_usuario,id_perfil,rdb,estado) 
						 VALUES (".$id.",41,".$rdb.",0);";
					     $rs_accede = pg_exec($this->Conec->coi_usuario(),$insert_accede);	
						 
					 }
				 }
				 
		     }
			 
		}else{

			return false; // Error al conectar
			
			}
		 
	if($rs_accede){ return true;}else{ return false; }
			   
		    }


       
	   
	   	public function eliminar_perfil($rut_evaluador,$rdb){
		
			// Busco el id usuario para eliminar en la tabla accede con perfil evaluador
			
			$sql_3 = "SELECT id_usuario FROM usuario WHERE nombre_usuario = '".$rut_evaluador."'; ";
			$rs_usuario = pg_exec($this->Conec->coi_usuario(),$sql_3);

			if($rs_usuario){
			
			if(pg_num_rows($rs_usuario)!=0){
					 
					$fila = pg_fetch_array($rs_usuario,0);
					
					$sql_deleteaccede ="DELETE FROM public.accede WHERE id_usuario = ".$fila['id_usuario']." 
					AND id_perfil=41 AND rdb=".$rdb."; ";
					pg_Exec($this->Conec->coi_usuario(),$sql_deleteaccede);
					
					return true; 
					
				}else{
				   
				     return true;	
					
					}
			 
			 }else{
				 
				 return true; 
				 
				 }
			   
		}
	   
	   
	   
	public function existeEvaluados($rut,$ano,$id_cargo,$periodo){
	
	$sql ="SELECT * FROM evados.eva_evaluador 
	WHERE id_cargo=".$id_cargo." AND id_ano=".$ano." AND rut_evaluador=".$rut." AND id_periodo=".$periodo;
	$rs_existe = pg_Exec($this->Conec->conectar(),$sql);
	return $rs_existe;
	
	}
	

	public function EliminaDocente($rut,$ano,$id_cargo,$rdb,$id_periodo){
		
		/*************************TRAIGO EL PERIODO******************************************/
		/* $fecha =  date(d.'/'.m.'/'.Y); 
		$sql_per="select id_periodo from periodo p where p.fecha_inicio >='07/09/2012 ' and p.fecha_termino<='07/09/2012';";
		$rs_per=pg_exec($this->Conec->conectar(),$sql_per) or die("Fallo ".$sql_per);
		 $fila_per = @pg_fetch_array($rs_per,0);
		 $id_periodo = $fila_per[0];*/
		/*************************************************************************************/
	
		if($this->eliminar_perfil($rut,$rdb)){ 
		
		$sql ="DELETE FROM evados.eva_evaluador WHERE 
		id_cargo=".$id_cargo." AND id_ano=".$ano." AND rut_evaluador=".$rut." and id_periodo=".$id_periodo;
		$rs_docente = pg_Exec($this->Conec->conectar(),$sql);
		
				if($rs_docente){ 
					return true;
				}else{
					return false;
				}
				
				}else{
					
					return false;
					
					}
			
		      }



	public function mostrarevaluados($ano,$periodo){
	  
	 	     $sql="SELECT a.rut_evaluador,
			 COALESCE(ap.dig_rut,al.dig_rut,em.dig_rut) as dig_rut,
			 CASE 
			 WHEN em.nombre_emp IS NOT NULL THEN UPPER(e.nombre_cargo)
			 WHEN ap.nombre_apo IS NOT NULL THEN UPPER('Apoderado')
			 WHEN al.nombre_alu IS NOT NULL THEN UPPER('Alumno')
			 END as cargo,
			 UPPER(COALESCE(ap.nombre_apo,al.nombre_alu,em.nombre_emp)) as nombre,
			 UPPER(COALESCE(ap.ape_pat,al.ape_pat,em.ape_pat)) as ape_pat,
			 UPPER(COALESCE(ap.ape_mat,al.ape_mat,em.ape_mat)) as ape_mat,
			 a.id_ano,a.id_cargo 
			 FROM  
			 evados.eva_evaluador a 
			 LEFT OUTER JOIN public.cargos e ON e.id_cargo = a.id_cargo  
			 LEFT OUTER JOIN public.empleado em ON em.rut_emp = a.rut_evaluador
			 LEFT OUTER JOIN public.alumno al ON al.rut_alumno = a.rut_evaluador
			 LEFT OUTER JOIN public.apoderado ap ON ap.rut_apo = a.rut_evaluador
			 WHERE a.id_ano = $ano AND a.id_periodo=$periodo ORDER BY 3";
					
			//echo pg_dbname($this->Conec->conectar());
					
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			
		return $result;
		
					
		 }
        
		
		
		
		public function institucion($inst){

		$sql_ins = "SELECT 
		UPPER(institucion.nombre_instit) as nombre_instit, UPPER(institucion.calle) as calle, institucion.nro,region.nom_reg, provincia.nom_pro, region,ciudad,comuna,UPPER(comuna.nom_com) as nom_com, institucion.telefono,institucion.fax,dig_rdb, email,letra_inst,area_geo,dependencia, nu_resolucion, fecha_resolucion,numero_inst FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON  (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna  ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) WHERE institucion.rdb=".$inst." ";
		$result_ins = pg_exec( $this->Conec->conectar(),$sql_ins ) or die ("Select falló : ".$sql_ins);
		return  pg_fetch_array($result_ins,0);	
				
		}
 
 
		 public function anoescolar($inst){
			$sql = "SELECT * from ano_escolar aes where aes.id_institucion = ".$inst." and aes.situacion = 1";
			$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd año escolar" );
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
 

         
	public 	function CopiarEvaluadores($a,$b,$periodo){
		
	    $sql = "select * from evados.eva_evaluador where  id_ano = $a AND id_periodo=$periodo";
		
		$result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error 11" );
        
		if(pg_num_rows($result)  > 0){
			
			return false;
			
		  }else{
			  
			$sql = "select * from evados.eva_evaluador where  id_ano = $a";
			$rs_ano = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error 11" );
        
			if(pg_num_rows($rs_ano)  > 0){
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
				$sql = 'INSERT INTO evados.eva_evaluador
				(id_ano,rut_evaluador,porcentaje,id_cargo,id_periodo) 
				(SELECT '.$a.' as id_ano,rut_evaluador,porcentaje,id_cargo,'.$periodo.'
				FROM evados.eva_evaluador WHERE id_ano = '.$a.' and id_periodo='.$ant_periodo.')';	
			}else{
		  		$sql = 'INSERT INTO evados.eva_evaluador
				(id_ano,rut_evaluador,porcentaje,id_cargo,id_periodo) 
				(SELECT '.$a.' as id_ano,rut_evaluador,porcentaje,id_cargo
				FROM evados.eva_evaluador WHERE id_ano = (SELECT ae.ano_anterior FROM ano_escolar ae 
				WHERE ae.id_institucion = '.$b.' and ae.id_ano = '.$a.') and id_periodo =(select max(id_periodo) from periodo where id_ano = (select ano_anterior from ano_escolar where id_institucion='.$b.' and id_ano='.$a.')) )';
			}
		    $result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error 12" );
		          
				  if($result){
				  	      return true; 
				  }else{
				  	      return false; 
				  }
				  
		  }
   
       }   


   }	

?>

