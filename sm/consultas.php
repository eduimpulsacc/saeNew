<?php
error_reporting(E_ALL); //Enviar Errores de Codigo

class consultas_reportes {

          private $conect;
		  private $instit;
		  private $rut;
		  private $ida;
		  private $periodo;
  
		  public function __construct($conn,$_INSTIT,$rutalum,$idano){ 
			  $this->conect = $conn;  
			  $this->instit = $_INSTIT; 
			  $this->rut = $rutalum; 
			  $this->ida = $idano; 
			}
			
		
        
		
		public function consultar_periodos($idano){
		
		    $sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano= $idano  ORDER BY 2;";
			$result = @pg_exec($this->conect,$sql) or die ( pg_last_error($this->conect));
            if($result){
			return $result;
			}else{
			return false;
			} 
												
		}
		
        
		public function consulta_notas($idper){
			
			$result = '';
			
            $sql = "SELECT nro_ano,id_ano FROM ano_escolar  WHERE id_ano=".$this->ida;
			$rs_ano = @pg_exec($this->conect,$sql);
			$nro_ano = @pg_result($rs_ano,0);
			$id_ano = @pg_result($rs_ano,1);
			
			$sql = "select * from matricula where rut_alumno=".$this->rut." and id_ano=".$this->ida;
			$rs_matricula = @pg_exec($this->conect,$sql);
			
			if(pg_numrows($rs_matricula)==0){
			
				  return "<br>&nbsp;&nbsp;&nbsp;&nbsp;No Existe Matricula para el Alumno.<br/><br/> ";  // no tiene Matricula
			
			}else{
			
			$sql ="select s.nombre,n.promedio from notas$nro_ano n 
			INNER JOIN ramo r ON n.id_ramo=r.id_ramo 
			INNER JOIN subsector s on r.cod_subsector=s.cod_subsector 
			WHERE rut_alumno=".$this->rut." and id_periodo = ".$idper."; ";
			$rs_notas = @pg_exec($this->conect,$sql);
			
					if(pg_numrows($rs_notas)==0){
					     
						 return "<br>&nbsp;&nbsp;&nbsp;&nbsp;No Existen Registros de Notas Asociados al Alumno.<br/><br/> ";  // no tiene informacion de notas
					
					}else{
						
						// informacion encontrada
													
						for($i=0;$i<pg_num_rows($rs_notas);$i++){
								
								$fila = pg_fetch_array($rs_notas,$i);
								
										    $xxcv = "";
	    
											$arraypalabras = explode(" ",trim($fila['nombre']));
											
											
											for($e=0;$e<=count($arraypalabras);$e++){
											      
												  if( isset($arraypalabras[$e]) && isset($arraypalabras[$e])!="" ){
												  
												  if(strlen($arraypalabras[$e])>4){
											         
													 if(substr($arraypalabras[$e],0,1) !='('){
													 
													  $xxcv .= substr($arraypalabras[$e],0,1);
											         
													  }else{
													     
														 $xxcv .= substr($arraypalabras[$e],1,1);
														 
													  }
													  
													 if(strlen($xxcv)==4) break;
											
												   }
												   
												   
												   }
												   
											
												 }
											
											   if(strlen($xxcv)<4){
											   
												  $resta = 4 - strlen($xxcv);
											
												  for($r=0;$r<$resta;$r++){
											
													  $xxcv .= " ";           				  
									
												}
											   
										  }
								
								/*$result .= strtoupper($xxcv);
								$result .= ' : '.trim($fila['promedio'])."<br/>";*/
								
				//$result .= '<li data-icon="star" ><a href="#" >'.strtoupper($xxcv).' : '.trim($fila['promedio']).'</a></li>';
				$result .= '<li data-icon="star" ><a href="#" >'.strtoupper(Iniciales($fila['nombre'])).' : '.trim($fila['promedio']).'</a></li>';
								
								}

							return $result;
					   
					   }
					   
				 }	   

			 }
		
				public function consulta_notas2($idper){
			
			$result = '';
			
            $sql = "SELECT nro_ano,id_ano FROM ano_escolar  WHERE id_ano=".$this->ida;
			$rs_ano = @pg_exec($this->conect,$sql);
			$nro_ano = @pg_result($rs_ano,0);
			$id_ano = @pg_result($rs_ano,1);
			
			$sql = "select * from matricula where rut_alumno=".$this->rut." and id_ano=".$this->ida;
			$rs_matricula = @pg_exec($this->conect,$sql);
			
			if(pg_numrows($rs_matricula)==0){
			
				  return "<br>&nbsp;&nbsp;&nbsp;&nbsp;No Existe Matricula para el Alumno.<br/><br/> ";  // no tiene Matricula
			
			}else{
			
			$sql ="select s.nombre,n.promedio from notas$nro_ano n 
			INNER JOIN ramo r ON n.id_ramo=r.id_ramo 
			INNER JOIN subsector s on r.cod_subsector=s.cod_subsector 
			WHERE rut_alumno=".$this->rut." and id_periodo = ".$idper."; ";
			$rs_notas = @pg_exec($this->conect,$sql);
			
					if(pg_numrows($rs_notas)==0){
					     
						 return "<br>&nbsp;&nbsp;&nbsp;&nbsp;No Existen Registros de Notas Asociados al Alumno.<br/><br/>";  // no tiene informacion de notas
					
					}else{
						
						// informacion encontrada
													
						for($i=0;$i<pg_num_rows($rs_notas);$i++){
								
								$fila = pg_fetch_array($rs_notas,$i);
								
										    $xxcv = "";
	    
											$arraypalabras = explode(" ",trim($fila['nombre']));
											
											for($e=0;$e<=count($arraypalabras);$e++){
											      
												  if( isset($arraypalabras[$e]) && isset($arraypalabras[$e])!="" ){
												  
												  if(strlen($arraypalabras[$e])>4){
											         
													 if(substr($arraypalabras[$e],0,1) !='('){
													 
													  $xxcv .= substr($arraypalabras[$e],0,1);
											         
													  }else{
													     
														 $xxcv .= substr($arraypalabras[$e],1,1);
														 
													  }
													  
													 if(strlen($xxcv)==4) break;
											
												   }
												   
												   
												   }
												   
											
												 }
											
											   if(strlen($xxcv)<4){
											   
												  $resta = 4 - strlen($xxcv);
											
												  for($r=0;$r<$resta;$r++){
											
													  $xxcv .= " ";           				  
									
												}
											   
										  }
								
								/*$result .= strtoupper($xxcv);
								$result .= ' : '.trim($fila['promedio'])."<br/>";*/
								
				$result .= '<tr><td width="45%" style="padding-left:50px;" >'.strtoupper($xxcv).'
				</td><td width="10%" >:</td><td> '.trim($fila['promedio']).'</td></tr>';
								
								}
                                 
					  $table = "<table border='1' width='70%' class='tablota' style='border-collapse: collapse;margin-left:15px; margin-bottom:5px; ' >
             <tr><th colspan='3' >Promedios del Periodo</th></tr>";		 

					  $table .= $result."</table>";
							
							return $table;
					   
					   }
					   
				 }	   

			 }	 
			 
		public function consulta_asistencia($idper){
		    
			$result = '';
			    
			$sql = "SELECT nro_ano,id_ano FROM ano_escolar  WHERE id_ano=".$this->ida;
			$rs_ano = @pg_exec($this->conect,$sql) or die("SELECT FALLO: ".$sql);
			$ano = @pg_result($rs_ano,0);
				
			$sql = "select * from matricula where rut_alumno=".$this->rut." and id_ano=".$this->ida;
			$rs_matricula = @pg_exec($this->conect,$sql);
			
			if(pg_numrows($rs_matricula)==0){
				
				  return 1; // no tiene matricula
			
			}else{
				
			   $sql ="select sum(p.dias_habiles)  from periodo p  where id_ano=".$this->ida;
			   $rs_periodo = @pg_exec($this->conect,$sql) or die("SELECT FALLO: ".$sql);
				
			   $dias_habiles = @pg_result($rs_periodo,0);
	
			   /********** ASISTENCIA*********************/
			   $sql ="select fecha from asistencia where ano=".$this->ida." AND rut_alumno=".$this->rut."order by 1 desc limit 3; ";
			   $rs_asist = @pg_exec($this->conect,$sql) or die ("SELECT FALLO: ".$sql);
			   $cont_asist = @pg_num_rows($rs_asist);
				
			   if(pg_numrows($rs_asist)==0){
			   
			     	 return "<br>No existe Registro de Asistencia para este Alumno<br/><br/>";  // no existe inasistencia;
				
			   }else{
			   	
			   $porcentaje_asistencia = round(substr(100 - (($cont_asist * 100) / $dias_habiles),0,5));
			   if(strlen( (string) $porcentaje_asistencia)==1) $porcentaje_asistencia = '0'.$porcentaje_asistencia.'%';
			   if(strlen( (string) $porcentaje_asistencia)==2) $porcentaje_asistencia = $porcentaje_asistencia.'%';
			   
			   $result .= '<br>Porcentaje Asistencia : '.$porcentaje_asistencia."<br/>";
			   
			   	if(strlen($cont_asist)==1){
					$can_atr = '0'.$cont_asist;
				}else{
					$can_atr = $cont_asist;
				  }
				
				$result .= 'Cantidad dias inasistencia : '.$can_atr.' d&iacute;as<br/>';
				
				$result .= '<h4>Ultimas : </h4>';
				
				for($i=0;$i<pg_num_rows($rs_asist);$i++){
					
					$fila = @pg_fetch_array($rs_asist,$i);
					
					$fe_array = explode("-",$fila['fecha']);
					
					$result .= 'Fecha : '.$fe_array[2].'/'.$fe_array[1].'/'.substr($fe_array[0],2,2)."<br/>";
				   
				   }
                 
				} 
				
				/************* ATRASOS **********************/

				$sql ="select fecha from anotacion where rut_alumno=".$this->ida." and tipo=2 ORDER BY fecha DESC";
				$rs_atrasos = @pg_exec($this->conect,$sql) or die("SELECT FALLO: ".$sql);
				
								if(pg_numrows($rs_atrasos)==0){
								
									  $result .= '<h4>No Existen Atrasos</h4><br/><br/>'; // no existe atrasos;
								
								}else{
								
									if(strlen(pg_numrows($rs_atrasos))==1) 
									{
									$can_atr = '0'.pg_numrows($rs_atrasos);
									}else{
									$can_atr = pg_numrows($rs_atrasos);
									}
									$result .= "ATRASOS".$can_atr."<br/>";
									
									for($i=0;$i<3;$i++){
										$fila = @pg_fetch_array($rs_atrasos,$i);
										$fe_array = explode("-",$fila['fecha']);
										$result .= $fe_array[2].$fe_array[1].substr($fe_array[0],2,2)."<br/>";
									}
								
								}
				
								
				}
				
				
				return $result;	
								
                  
		       }	 
		  
		  
		  
		   public function consulta_anotaciones($idper){
		                
					   $result = ''; 
						 
		               $sql = "SELECT * FROM anotacion WHERE id_periodo = $idper ORDER BY fecha desc LIMIT 3;";  
					   $rs = @pg_exec($this->conect,$sql);
						
						/*for( $i=0; $i<pg_num_rows($rs) ; $i++ ){
									
									$fila = @pg_fetch_array($rs,$i);
														   
						   $result .= '<li data-icon="star" ><a href="#" >'.$fila['fecha'].' : '.trim($fila['observacion']).'</a></li>';
						
						  }  */
						  
						  return $rs;   
		              
			   }
		  
		  
		  
		 		   public function sacameelrut($rt){
						for($tk=0;$tk<=strlen($rt);$tk++){
						  $caracter = $rt{$tk};
						  if($caracter=='0'){
							$ri = substr($rt,$tk,strlen($rt));
						  }else{
						    $ri = substr($rt,$tk,strlen($rt)); 
						    break;
						  }							
						}
					  return $ri;
					}
					
					
					
		public function damelasprimerasletrascabezon($nom){
	    
		$xxcv = "";
	    
		$arraypalabras = explode(" ",$nom);
		
		for($e=0;$e<=count($arraypalabras);$e++){
		
		      if(strlen($arraypalabras[$e])>4){
		
		         $xxcv .= substr($arraypalabras[$e],0,1);
		
			     if(strlen($xxcv)==4) break;
		
			   }
		
			 }
		
		   if(strlen($xxcv)<4){
		   
		      $resta = 4 - strlen($xxcv);
		
		      for($r=0;$r<$resta;$r++){
		
				  $xxcv .= " ";           				  
		
				}
		   
		   	  }
	    
		return strtoupper($xxcv);
       
	   }		
	
	
	}
					 
 function Iniciales($Subsector)
			{
			$largo = strlen($Subsector);
			for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
			{
			if ($cont_letras == 0)
			{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
			}
			$letra_query = substr($Subsector,$cont_letras,1);
			if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
			if (strlen($cadena)==6 )
			$cont_letras = $largo;
			}	
			if (strlen(trim($cadena))==1)
			return trim(strtoupper(substr($Subsector,0,3)));
			else
			return trim($cadena);
		}	
?>

