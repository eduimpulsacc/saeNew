<? require "../../class/Coneccion.class.php";

class Evaluados{
       
	public $Conec;
	
	//Constructor 
	public function Evaluados($ip,$bd){
		
		$this->Conec = new DBManager($ip,$bd);
	 
	 } 

	public function listadoEvaluados($rdb,$cargo){   //Guarda en la Base Datos 
	
		  $sql="SELECT 
		  empleado.rut_emp, empleado.dig_rut, upper(ape_pat)  || ' ' || upper(ape_mat)  || ' ' || upper(empleado.nombre_emp)
		  as nombre
				FROM empleado
				INNER JOIN trabaja ON empleado.rut_emp=trabaja.rut_emp 
				INNER JOIN cargos ON trabaja.cargo=cargos.id_cargo
				WHERE trabaja.rdb=$rdb and id_cargo=$cargo 
				ORDER BY nombre ASC";
		  $result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			
		return $result;
		
	}
	
	public function InsertaDocente($rut,$ano,$id_cargo,$rdb,$id_periodo){
		
		/*************************TRAIGO EL PERIODO******************************************/
		/*$fecha =  date(d.'/'.m.'/'.Y); 
		$sql_per="select id_periodo from periodo p where p.fecha_inicio >='07/09/2012 ' and p.fecha_termino<='07/09/2012';";
		$rs_per=pg_exec($this->Conec->conectar(),$sql_per) or die("Fallo ".$sql_per);
		$fila_per = @pg_fetch_array($rs_per,0);
		$id_periodo = $fila_per[0];*/
		/*************************************************************************************/
	     
		 $insert = "";
		 if($rut=='todos'){
		 
		     $resultado = $this->listadoEvaluados($rdb,$id_cargo);
		     
			 if(pg_num_rows($resultado)!=0){
			 
			 for($i=0;$i<@pg_num_rows($resultado);$i++){
				
			 $fila = @pg_fetch_array($resultado,$i); 
			 
			    echo $sql = "SELECT * FROM evados.eva_evaluado 
						WHERE  evados.eva_evaluado.id_ano = ".$ano." AND 
						evados.eva_evaluado.rut_evaluado = ".$fila['rut_emp']." AND 
						evados.eva_evaluado.id_cargo = ".$id_cargo." ; ";
                $rs_1 = pg_Exec($this->Conec->conectar(),$sql) or die ("Error 1");
			    
				if(pg_num_rows($rs_1)==0){
			   
						$insert .="INSERT INTO evados.eva_evaluado (id_ano,rut_evaluado,id_cargo,id_periodo) 
						VALUES(".$ano.",".$fila['rut_emp'].",".$id_cargo.",".$id_periodo.");";
		            
				    }
					
			    }
				
				$rs_docente = @pg_Exec($this->Conec->conectar(),$insert);
			 
			 }
		 
		 }else{
			 
			 $sql = "SELECT * FROM evados.eva_evaluado 
						WHERE 
						evados.eva_evaluado.id_ano = ".$ano." AND 
						evados.eva_evaluado.rut_evaluado = ".$rut." AND 
						evados.eva_evaluado.id_cargo = ".$id_cargo." AND id_periodo=".$id_periodo." ; ";
            $rs_2 = pg_Exec($this->Conec->conectar(),$sql) or die ("Error 2");
			
			if(pg_num_rows($rs_2)==0){
			    
				 $insert .="INSERT INTO evados.eva_evaluado (id_ano,rut_evaluado,id_cargo,id_periodo) 
		         VALUES(".$ano.",".$rut.",".$id_cargo.",".$id_periodo.");";
		         
				 $rs_docente = @pg_Exec($this->Conec->conectar(),$insert);
				 
			  }
			  
		   }
		
			if($rs_docente){
				return true;
			}else{
				return false;
			}
		
	 }
	
	
	public function existeEvaluados($rut,$ano,$id_cargo,$periodo){
		
	$sql ="SELECT * FROM evados.eva_evaluado WHERE id_cargo=".$id_cargo." AND id_ano=".$ano." AND rut_evaluado=".$rut." AND id_periodo=".$periodo;
	$rs_existe = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		
	return $rs_existe;
	
	}
	
	public function EliminaDocente($rut,$ano,$id_cargo,$id_periodo){
		
		/*************************TRAIGO EL PERIODO******************************************/
	/*	$fecha =  date(d.'/'.m.'/'.Y); 
		$sql_per="select id_periodo from periodo p where p.fecha_inicio >='07/09/2012 ' and p.fecha_termino<='07/09/2012';";
		$rs_per=pg_exec($this->Conec->conectar(),$sql_per) or die("Fallo ".$sql_per);
		$fila_per = @pg_fetch_array($rs_per,0);
		$id_periodo = $fila_per[0];*/
		/*************************************************************************************/
		
		

	$sql ="DELETE FROM evados.eva_evaluado WHERE  id_cargo=".$id_cargo." AND id_ano=".$ano." AND rut_evaluado=".$rut." and id_periodo=".$id_periodo;
	$rs_docente = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		
			if($rs_docente){
				return true;
			}else{
				return false;
			}
       
	   }

    
	
	public function mostrarevaluados($ano,$periodo){
		
	$sql="	SELECT 
		  	a.rut_evaluado,em.dig_rut,
		  	UPPER(e.nombre_cargo) as nombre_cargo,UPPER(em.nombre_emp) as nombre_emp,
		  	UPPER(em.ape_pat) as ape_pat,UPPER(em.ape_mat) as ape_mat,a.id_ano
			FROM 
			evados.eva_evaluado a
			LEFT OUTER JOIN public.cargos e ON e.id_cargo = a.id_cargo  
			LEFT OUTER JOIN public.empleado em ON em.rut_emp = a.rut_evaluado
			WHERE a.id_ano = $ano AND a.id_periodo=$periodo 
			ORDER BY 3;";
		$result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			
		return $result;
		
					
		 }
        
		
		
		
		public function institucion($inst){

$sql_ins = "SELECT
 UPPER(institucion.nombre_instit) as nombre_instit, 
 UPPER(institucion.calle) as calle, 
 institucion.nro,   
 region.nom_reg, 
 provincia.nom_pro, 
 region,ciudad,
 comuna,
 UPPER(comuna.nom_com) as nom_com, 
 institucion.telefono,
 institucion.fax,
 dig_rdb, 
 email,letra_inst,
 area_geo, 
 dependencia, 
 nu_resolucion, 
 fecha_resolucion,
 numero_inst 
 FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON  (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna  ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) WHERE institucion.rdb=".$inst." ";
 
   $result_ins = pg_exec( $this->Conec->conectar(),$sql_ins ) or die ("Select falló : ".$sql_ins);
   
   return  pg_fetch_array($result_ins,0);	
		
 }
 
 
 
 
 public function anoescolar($inst){

$sql = "SELECT * from evados.eva_ano_escolar aes where aes.id_institucion = ".$inst." and aes.situacion = 1";

$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd E#e#ee#" );
return pg_fetch_array($regis,0);


 } 
 
 public function periodo($periodo){
			$sql ="SELECT nombre_periodo FROM evados.eva_periodo WHERE id_periodo=".$periodo;
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
 
		
		
		public 	function CopiarEvaluados($a,$b,$periodo){
		
	    $sql = "SELECT * FROM  evados.eva_evaluado WHERE id_ano = $a AND id_periodo=$periodo";
		
		$result = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error 11" );
        
		if(pg_num_rows($result)  > 0){
			
			return false;
			
		  }else{
		  	
			$sql = "SELECT * FROM  evados.eva_evaluado WHERE id_ano = $a";
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
				$sql = 'INSERT INTO evados.eva_evaluado
				(id_ano,rut_evaluado,id_cargo,id_periodo) 
				(SELECT '.$a.' as id_ano,rut_evaluado,id_cargo,'.$periodo.'
				FROM evados.eva_evaluado WHERE id_ano = '.$a.' and id_periodo='.$ant_periodo.')';	
			}else{
			 	 $sql = 'INSERT INTO evados.eva_evaluado
				(id_ano,rut_evaluado,porcentaje,id_cargo,id_periodo) 
				(SELECT '.$a.' as id_ano,rut_evaluado,porcentaje,id_cargo,id_periodo
				FROM evados.eva_evaluado WHERE id_ano = (SELECT ae.ano_anterior FROM evados.eva_ano_escolar ae 
				WHERE ae.id_institucion = '.$b.' and ae.id_ano = '.$a.') and id_periodo =(select max(id_periodo) from evados.eva_periodo where id_ano = (select ano_anterior from evados.eva_ano_escolar where id_institucion='.$b.' and id_ano='.$a.')) )';
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

