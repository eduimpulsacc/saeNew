
<?

session_start();
class SQL{

	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 


	public function nom_Corp($corporacion){
		 $sql="select corp.nombre_corp
                from corporacion AS corp 
                WHERE corp.num_corp =".$corporacion;
        $result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall�111 : ".$sql);
		return $result;
		}
	public function Corp_insti($institucion){
		 $sql="select corp.nombre_corp
                from corporacion AS corp INNER JOIN corp_instit ci ON corp.num_corp=ci.num_corp
                WHERE rdb =".$institucion;
        $result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall�111 : ".$sql);
		return $result;
		}
	public function Nombre_Institucion($institucion){
		$sql="SELECT nombre_instit FROM institucion WHERE rdb=".$institucion;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall� : ".$sql);
		return $result;
	}

	public function nom_insitit($instirucion){
		 $sql="select nombre_instit from institucion where rdb IN(select id_institucion 
        FROM evados.eva_ano_escolar ano where ano.id_ano=".$instirucion.")";
        $result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall� : ".$sql);
		return $result;
		}
	
		
	public function prueba($nacional){
		$sql ="SELECT * FROM eva_plantilla WHERE id_nacional=1";
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall� : ".$sql);
		return $result;
	}
	public function GrupoHomogenio($bloque){
		$sql ="SELECT nombre, porcentaje FROM evados.eva_bloque WHERE id_bloque=".$bloque;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall� : ".$sql);		
		
		return $result;
	}
	public function PautaEvaluacion($pauta){
		$sql ="SELECT id_plantilla, id_nacional, id_bloque, nombre FROM evados.eva_plantilla WHERE id_plantilla=".$pauta;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall� : ".$sql);		
		
		return $result;
	}
	
	public function Dimension($dimension){
		$sql ="SELECT  distinct pa.id_area,pa.id_nacional,pa.nombre FROM evados.eva_plantilla_area pa INNER JOIN evados.eva_plantilla_nacional pn ON pa.id_area=pn.id_area WHERE pn.id_area=".$dimension;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall� : ".$sql);		
		
		return $result;
	
	}
	

	public function Funcion($funcion){
		$sql = "SELECT id_subarea,nombre FROM evados.eva_plantilla_subarea WHERE id_subarea=".$funcion;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall� : ".$sql);		
		
		return $result;
	}
	
	public function Indicador($indicador){
		$sql ="SELECT id_item, nombre FROM evados.eva_plantilla_item WHERE id_item=".$indicador;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall� : ".$sql);		
		
		return $result;
	}
	
	public function CuentaFuncionItem($pauta,$dimension){
		$sql="SELECT count(id_subarea), count(id_item) FROM evados.eva_plantilla_nacional WHERE id_plantilla=".$pauta." AND id_area=".$dimension;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall� : ".$sql);		
		
		return $result;
	}
	
	public function Conceptos($nacional){
		$sql="SELECT * FROM evados.eva_concepto WHERE id_nacional=".$nacional." Order by orden";
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall� : ".$sql);		
		
		return $result;
	}
	
	public function PersonalBloque($bloque){
		
		$sql="SELECT rut_emp ||'-'|| dig_rut as rut, nombre_emp ||' '|| ape_pat ||' ' || ape_mat as nombre 
			  FROM evados.eva_bloque_evaluador bl INNER JOIN empleado emp ON bl.rut_evaluador=emp.rut_emp 
			  WHERE id_bloque=".$bloque;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall� : ".$sql);		
		
		return $result;		

	}
	
	public function Evaluados($ano,$bloque){

	  $sql="SELECT eva.id_cargo,emp.rut_emp ||'-'|| emp.dig_rut as rut,emp.nombre_emp ||' '|| 
	ape_pat ||' '|| ape_mat as nombre,emp.rut_emp FROM empleado 
	emp INNER JOIN evados.eva_evaluado eva ON emp.rut_emp=eva.rut_evaluado 
	WHERE  eva.rut_evaluado=".$bloque;					
	$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall� : ".$sql);		
	return $result;
		
		}
		
		
	public function datoscompilados(
	
		$nroano,
		$idnacional,
		$_cmbCORP,
		$_cmbINST,
		$_cmbCARGO,
		$_cmbGRUPO,
		$_cmbPAUTA, 
		$_cmbDIMENSION,
		$_cmbFUNCION,
		$_cmbINDICADOR
		
		){
		
	   $_filtro="";	
	
	   if($_cmbCORP!=0){
        $_filtro .= " AND ci.num_corp = $_cmbCORP ";
          }
	   
	   if($_cmbINST!=0){
        $_filtro .= " AND a.id_ano = $_cmbINST ";
          }
       
       if($_cmbCARGO!=0){
        $_filtro .= " AND a.id_cargo_evaluado = $_cmbCARGO ";
          }   
          
	   if($_cmbGRUPO!=0){
        $_filtro .= " AND a.rut_evaluado = $_cmbGRUPO ";
          }
       
       if($_cmbPAUTA!=0){
        $_filtro .= " AND a.id_plantilla = $_cmbPAUTA ";
          }              
		
	   if($_cmbDIMENSION!=0){
        $_filtro .= " AND a.id_area = $_cmbDIMENSION ";
          }
       
	   if($_cmbFUNCION!=0){
        $_filtro .= " AND a.id_subarea = $_cmbFUNCION ";
          }    
		
	   if($_cmbINDICADOR!=0){
        $_filtro .= " AND a.id_item = $_cmbINDICADOR ";
          }   		
		
		
        $sql = "SELECT d.id_bloque,d.nombre,d.orden as order_bloque,a.id_concepto,b.sigla,
				b.orden as order_concepto,
				COUNT(a.id_concepto) as result_cantidad_respuestas
				FROM nacional n
				INNER JOIN nacional_corp nc ON nc.id_nacional = n.id_nacional
				INNER JOIN corp_instit ci ON ci.num_corp = nc.num_corp
				INNER JOIN evados.eva_ano_escolar ae ON ae.id_institucion = ci.rdb AND ae.nro_ano = $nroano
				INNER JOIN evados.eva_plantilla_evaluacion a ON a.id_ano = ae.id_ano  
				INNER JOIN evados.eva_concepto b ON b.id_concepto = a.id_concepto
				INNER JOIN evados.eva_bloque_evaluador e 
				ON e.rut_evaluador = a.rut_evaluador AND e.id_cargo = a.id_cargo_evaluador
				INNER JOIN evados.eva_item_bloque c ON
				c.id_plantilla = a.id_plantilla AND
				c.id_area = a.id_area AND
				c.id_subarea = a.id_subarea AND
				c.id_item = a.id_item AND
				c.id_bloque = e.id_bloque
				INNER JOIN evados.eva_bloque d ON d.id_bloque = c.id_bloque
				
                WHERE  n.id_nacional = $idnacional  $_filtro
				
				GROUP BY 1,2,3,4,5,6 ORDER BY 3,6; ";
           
		   $result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select fallo : ".$sql);
		 
		   return $result; 
		
		}
		
		
	   public function gruposdebloques($a){
		   
		        $sql = "SELECT c.orden,e.id_bloque
						FROM evados.eva_plantilla_evaluacion a 
						INNER JOIN evados.eva_bloque_evaluador e ON 
						e.rut_evaluador = a.rut_evaluador AND e.id_cargo = a.id_cargo_evaluador
						INNER JOIN evados.eva_bloque c ON c.id_bloque = e.id_bloque
						WHERE a.id_plantilla=".$a." 
						GROUP BY c.orden,e.id_bloque
						ORDER BY c.orden";
						$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select fallo : ".$sql); 
		   
		       return $result;
		   
		   }
	   
	   
	   public function grupoporcentajes($e,$nro_ano){
		   
		   $a = explode('-',$e);
		   		   
		        $sql = "SELECT * FROM evados.eva_matriz_porcentual as z
						WHERE z.bloque1 in (".$a[0].")
						AND z.bloque2 in (".$a[1].") 
						AND z.bloque3 in (".$a[2].")  
						AND z.bloque4 in (".$a[3].") 
						AND z.bloque5 in (".$a[4].")
						AND z.nro_ano = ".$nro_ano.";";
		                
			$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select fallo : ".$sql); 
		   
		    return $result;
		   
		   }
	   		
		
		public function arrays_conceptos(
				
		$nroano,
		$idnacional,
		$_cmbCORP,
		$_cmbINST,
		$_cmbCARGO,
		$_cmbGRUPO,
		$_cmbPAUTA, 
		$_cmbDIMENSION,
		$_cmbFUNCION,
		$_cmbINDICADOR,
	    $idbloque
	    
	    ){
		
	    $_filtro="";	
	
	    if($_cmbCORP!=0){
             $_filtro .= " AND ci.num_corp = $_cmbCORP ";
          }
	    
	    if($_cmbINST!=0){
             $_filtro .= " AND a.id_ano = $_cmbINST ";
          }
       
        if($_cmbCARGO!=0){
             $_filtro .= " AND a.id_cargo_evaluado = $_cmbCARGO ";
          }   
          
	    if($_cmbGRUPO!=0){
             $_filtro .= " AND a.rut_evaluado = $_cmbGRUPO ";
          }
        
        if($_cmbPAUTA!=0){
             $_filtro .= " AND a.id_plantilla = $_cmbPAUTA ";
          }              
		
	    if($_cmbDIMENSION!=0){
             $_filtro .= " AND a.id_area = $_cmbDIMENSION ";
          }
        
	    if($_cmbFUNCION!=0){
             $_filtro .= " AND a.id_subarea = $_cmbFUNCION ";
          }    
		
	    if($_cmbINDICADOR!=0){
             $_filtro .= " AND a.id_item = $_cmbINDICADOR ";
          }
			
			
			 $sql = "SELECT a.id_concepto,
			                b.sigla,
			                b.orden as order_concepto
							FROM nacional n
							INNER JOIN nacional_corp nc ON nc.id_nacional = n.id_nacional
							INNER JOIN corp_instit ci ON ci.num_corp = nc.num_corp
							INNER JOIN evados.eva_ano_escolar ae ON ae.id_institucion = ci.rdb AND ae.nro_ano = $nroano
							INNER JOIN evados.eva_plantilla_evaluacion a ON a.id_ano = ae.id_ano  
							INNER JOIN evados.eva_concepto b ON b.id_concepto = a.id_concepto
							INNER JOIN evados.eva_bloque_evaluador e ON e.rut_evaluador = a.rut_evaluador AND e.id_cargo = a.id_cargo_evaluador
							INNER JOIN evados.eva_item_bloque c ON
							c.id_plantilla = a.id_plantilla AND
							c.id_area = a.id_area AND
							c.id_subarea = a.id_subarea AND
							c.id_item = a.id_item AND
							c.id_bloque = e.id_bloque
							INNER JOIN evados.eva_bloque d ON d.id_bloque = c.id_bloque 
							WHERE 
							
							n.id_nacional = $idnacional $_filtro AND d.id_bloque = $idbloque
							
							GROUP BY 1,2,3
							ORDER BY 3";
			   $result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select fallo : ".$sql); 
		       return $result;
		    
		    }
		    
		    
	public  function resultados_totales_xconceptos_mas_porcentajes(
	   
			    $nroano,
				$idnacional,
				$_cmbCORP,
				$_cmbINST,
				$_cmbCARGO,
				$_cmbGRUPO,
				$_cmbPAUTA, 
				$_cmbDIMENSION,
				$_cmbFUNCION,
				$_cmbINDICADOR
			
			){
		 	
	  $_filtro="";	
	
	   if($_cmbCORP!=0){
        $_filtro .= " AND ci.num_corp = $_cmbCORP ";
          }
	   
	   if($_cmbINST!=0){
        $_filtro .= " AND a.id_ano = $_cmbINST ";
          }
       
       if($_cmbCARGO!=0){
        $_filtro .= " AND a.id_cargo_evaluado = $_cmbCARGO ";
          }   
          
	   if($_cmbGRUPO!=0){
        $_filtro .= " AND a.rut_evaluado = $_cmbGRUPO ";
          }
       
       if($_cmbPAUTA!=0){
        $_filtro .= " AND a.id_plantilla = $_cmbPAUTA ";
          }              
		
	   if($_cmbDIMENSION!=0){
        $_filtro .= " AND a.id_area = $_cmbDIMENSION ";
          }
       
	   if($_cmbFUNCION!=0){
        $_filtro .= " AND a.id_subarea = $_cmbFUNCION ";
          }    
		
	   if($_cmbINDICADOR!=0){
        $_filtro .= " AND a.id_item = $_cmbINDICADOR ";
          }   		   															
	   														
	   														
          $sql = "SELECT  primera.id_concepto,primera.sigla,
          sum(primera.cantidad_respuestas) as total_xconcepto
		  ,round((sum(primera.cantidad_respuestas) * 100 ) / ( 
		  SELECT COUNT(a.*) as total_respuestas
		  FROM nacional n 
		  INNER JOIN nacional_corp nc ON nc.id_nacional = n.id_nacional 
		  INNER JOIN corp_instit ci ON ci.num_corp = nc.num_corp 
		  INNER JOIN evados.eva_ano_escolar ae ON ae.id_institucion = ci.rdb AND ae.nro_ano = $nroano
		  INNER JOIN evados.eva_plantilla_evaluacion a ON a.id_ano = ae.id_ano 
		  INNER JOIN evados.eva_concepto b ON b.id_concepto = a.id_concepto 
		  INNER JOIN evados.eva_bloque_evaluador e ON e.rut_evaluador = a.rut_evaluador AND e.id_cargo = a.id_cargo_evaluador 
		  INNER JOIN evados.eva_item_bloque c ON c.id_plantilla = a.id_plantilla 
		  AND c.id_area = a.id_area 
		  AND c.id_subarea = a.id_subarea 
		  AND c.id_item = a.id_item 
		  AND c.id_bloque = e.id_bloque 
		  INNER JOIN evados.eva_bloque d ON d.id_bloque = c.id_bloque 
		  
		  WHERE n.id_nacional = $idnacional  $_filtro
		  
		  ),2) as total_en_porcentaje
			FROM 
			( SELECT d.nombre,b.sigla,COUNT(a.id_concepto) as cantidad_respuestas,
			d.id_bloque,a.id_concepto,b.orden
			FROM nacional n 
			INNER JOIN nacional_corp nc ON nc.id_nacional = n.id_nacional 
			INNER JOIN corp_instit ci ON ci.num_corp = nc.num_corp 
			INNER JOIN evados.eva_ano_escolar ae ON ae.id_institucion = ci.rdb AND ae.nro_ano = $nroano 
			INNER JOIN evados.eva_plantilla_evaluacion a ON a.id_ano = ae.id_ano 
			INNER JOIN evados.eva_concepto b ON b.id_concepto = a.id_concepto 
			INNER JOIN evados.eva_bloque_evaluador e ON e.rut_evaluador = a.rut_evaluador AND e.id_cargo = a.id_cargo_evaluador 
			INNER JOIN evados.eva_item_bloque c ON c.id_plantilla = a.id_plantilla 
			AND c.id_area = a.id_area 
			AND c.id_subarea = a.id_subarea 
			AND c.id_item = a.id_item 
			AND c.id_bloque = e.id_bloque 
			INNER JOIN evados.eva_bloque d ON d.id_bloque = c.id_bloque 
			
			WHERE n.id_nacional = $idnacional  $_filtro
			
			GROUP BY 1,2,4,5,6
			ORDER BY 1,6
			) as primera 
			
			GROUP BY 1,2
			ORDER BY 1";	
												
	   		$result = pg_exec( $this->Conec->conectar(),$sql) or die ("Select fallo : ".$sql); 
		    return $result;
	   	
	   }	    	
	   
	

	 public function total_xbloque(
	    $nroano,$idnacional,$_cmbCORP,$_cmbINST,$_cmbCARGO,
		$_cmbGRUPO,$_cmbPAUTA,$_cmbDIMENSION,$_cmbFUNCION,
		$_cmbINDICADOR,$id_bloque
		){
		
	  $_filtro="";	
	
	   if($_cmbCORP!=0){
        $_filtro .= " AND ci.num_corp = $_cmbCORP ";
          }
	   
	   if($_cmbINST!=0){
        $_filtro .= " AND a.id_ano = $_cmbINST ";
          }
       
       if($_cmbCARGO!=0){
        $_filtro .= " AND a.id_cargo_evaluado = $_cmbCARGO ";
          }   
          
	   if($_cmbGRUPO!=0){
        $_filtro .= " AND a.rut_evaluado = $_cmbGRUPO ";
          }
       
       if($_cmbPAUTA!=0){
        $_filtro .= " AND a.id_plantilla = $_cmbPAUTA ";
          }              
		
	   if($_cmbDIMENSION!=0){
        $_filtro .= " AND a.id_area = $_cmbDIMENSION ";
          }
       
	   if($_cmbFUNCION!=0){
        $_filtro .= " AND a.id_subarea = $_cmbFUNCION ";
          }    
		
	   if($_cmbINDICADOR!=0){
        $_filtro .= " AND a.id_item = $_cmbINDICADOR ";
          }
	 	
	 					
	 		$sql = "SELECT  primera.nombre,primera.id_bloque,
					order_bloque,sum(primera.result_cantidad_respuestas) as total_xbloque 
					FROM 
					 ( SELECT d.id_bloque,d.nombre,d.orden as order_bloque,
					   a.id_concepto,b.sigla,
					   b.orden as order_concepto,
					   COUNT(a.id_concepto) as result_cantidad_respuestas 
					   FROM nacional n 
					   INNER JOIN nacional_corp nc ON nc.id_nacional = n.id_nacional 
					   INNER JOIN corp_instit ci ON ci.num_corp = nc.num_corp 
					   INNER JOIN evados.eva_ano_escolar ae ON ae.id_institucion = ci.rdb AND ae.nro_ano = $nroano
					   INNER JOIN evados.eva_plantilla_evaluacion a ON a.id_ano = ae.id_ano 
					   INNER JOIN evados.eva_concepto b ON b.id_concepto = a.id_concepto 
					   INNER JOIN evados.eva_bloque_evaluador e ON e.rut_evaluador = a.rut_evaluador AND e.id_cargo = a.id_cargo_evaluador 
					   INNER JOIN evados.eva_item_bloque c ON c.id_plantilla = a.id_plantilla 
					   AND c.id_area = a.id_area 
					   AND c.id_subarea = a.id_subarea 
					   AND c.id_item = a.id_item 
					   AND c.id_bloque = e.id_bloque 
					   INNER JOIN evados.eva_bloque d ON d.id_bloque = c.id_bloque 
					   			
					   WHERE n.id_nacional = $idnacional  $_filtro
					   					
					   AND d.id_bloque = $id_bloque
										
					   GROUP BY 1,2,3,4,5,6 ORDER BY 3,6
					   
					   ) as primera 
					   
					   GROUP BY 1,2,3
					   ORDER BY 3";
					   
					   
	 		$result = pg_exec( $this->Conec->conectar(),$sql) or die ("Select fallo : ".$sql); 
		    return $result;	
	 	
	   }
	 
	 
	 public function total_respuestas(
	    $nroano,$idnacional,$_cmbCORP,$_cmbINST,$_cmbCARGO,
		$_cmbGRUPO,$_cmbPAUTA,$_cmbDIMENSION,$_cmbFUNCION,
		$_cmbINDICADOR
	){
		
	  $_filtro="";	
	
	   if($_cmbCORP!=0){
        $_filtro .= " AND ci.num_corp = $_cmbCORP ";
          }
	   
	   if($_cmbINST!=0){
        $_filtro .= " AND a.id_ano = $_cmbINST ";
          }
       
       if($_cmbCARGO!=0){
        $_filtro .= " AND a.id_cargo_evaluado = $_cmbCARGO ";
          }   
          
	   if($_cmbGRUPO!=0){
        $_filtro .= " AND a.rut_evaluado = $_cmbGRUPO ";
          }
       
       if($_cmbPAUTA!=0){
        $_filtro .= " AND a.id_plantilla = $_cmbPAUTA ";
          }              
		
	   if($_cmbDIMENSION!=0){
        $_filtro .= " AND a.id_area = $_cmbDIMENSION ";
          }
       
	   if($_cmbFUNCION!=0){
        $_filtro .= " AND a.id_subarea = $_cmbFUNCION ";
          }    
		
	   if($_cmbINDICADOR!=0){
        $_filtro .= " AND a.id_item = $_cmbINDICADOR ";
          }
	   
	 					
	 		$sql = "SELECT 
					COUNT(a.*) as total_respuestas
					FROM nacional n 
					INNER JOIN nacional_corp nc ON nc.id_nacional = n.id_nacional 
					INNER JOIN corp_instit ci ON ci.num_corp = nc.num_corp 
					INNER JOIN evados.eva_ano_escolar ae ON ae.id_institucion = ci.rdb AND ae.nro_ano = $nroano 
					INNER JOIN evados.eva_plantilla_evaluacion a ON a.id_ano = ae.id_ano 
					INNER JOIN evados.eva_concepto b ON b.id_concepto = a.id_concepto 
					INNER JOIN evados.eva_bloque_evaluador e ON e.rut_evaluador = a.rut_evaluador AND e.id_cargo = a.id_cargo_evaluador 
					INNER JOIN evados.eva_item_bloque c ON c.id_plantilla = a.id_plantilla 
					AND c.id_area = a.id_area 
					AND c.id_subarea = a.id_subarea 
					AND c.id_item = a.id_item 
					AND c.id_bloque = e.id_bloque 
					INNER JOIN evados.eva_bloque d ON d.id_bloque = c.id_bloque 
					
					WHERE n.id_nacional = $idnacional $_filtro ";		

		$result = pg_exec( $this->Conec->conectar(),$sql) or die ("Select fallo : ".$sql); 
		return $result;	
	 	
	 }
	 
	 
	public function exportar_dataexel($_pauta,$_corporacion,$_instirucion,$_nacional,$_ano){
			
		$_filtro="";		
		
		if( $_corporacion != 0 ) $_filtro .= " AND ci.num_corp = $_corporacion ";
		if( $_pauta != 0 ) $_filtro .= " AND a.id_plantilla = $_pauta ";
		if( $_id_ano_institucion != 0 ) $_filtro .= " AND ci.rdb = $_instirucion ";
				
		$sql = "SELECT  co.nombre_corp as nombre_corporacion,
				ci.rdb,inti.nombre_instit as nombre_institucion,
				d.nombre as nombre_bloque,
				evpl.nombre as nombre_pauta,
				evpla.nombre as nombre_funcion,
				evaplsu.nombre as nombre_dimencion,
				evaplit.nombre as nombre_indicador,
				b.sigla,
				b.categoria,
				b.concepto
				FROM nacional n 
				INNER JOIN nacional_corp nc ON nc.id_nacional = n.id_nacional 
				INNER JOIN corporacion co ON co.num_corp = nc.num_corp
				INNER JOIN corp_instit ci ON ci.num_corp = nc.num_corp 
				INNER JOIN evados.eva_ano_escolar ae ON ae.id_institucion = ci.rdb AND ae.nro_ano = $_ano
				INNER JOIN institucion inti ON inti.rdb = ae.id_institucion
				INNER JOIN evados.eva_plantilla_evaluacion a ON a.id_ano = ae.id_ano
				INNER JOIN evados.eva_concepto b ON b.id_concepto = a.id_concepto 
				INNER JOIN evados.eva_bloque_evaluador e ON e.rut_evaluador = a.rut_evaluador 
				AND e.id_cargo = a.id_cargo_evaluador 
				INNER JOIN evados.eva_plantilla evpl ON evpl.id_plantilla = a.id_plantilla
				INNER JOIN evados.eva_plantilla_area evpla ON evpla.id_area = a.id_area 
				INNER JOIN evados.eva_plantilla_subarea evaplsu ON evaplsu.id_subarea = a.id_subarea 
				INNER JOIN evados.eva_plantilla_item evaplit ON evaplit.id_item = a.id_item
				INNER JOIN evados.eva_item_bloque c ON c.id_plantilla = a.id_plantilla 
				AND c.id_area = a.id_area AND c.id_subarea = a.id_subarea 
				AND c.id_item = a.id_item AND c.id_bloque = e.id_bloque 
				INNER JOIN evados.eva_bloque d ON d.id_bloque = c.id_bloque 
				WHERE 
				n.id_nacional = 1
				ORDER BY 5,4,8,11";	
		        
		$result = pg_exec( $this->Conec->conectar(),$sql) or die ("Select fallo : ".$sql); 
		return $result;
		  
	 }  
	
	
	public function tabladefrecuencia($_nacional,$_ano,$_corporacion,$_instirucion,$_bloque){
		  	
		  $filtro="";
		  $rk="";
		  
		  if($_corporacion!=0) $filtro .= " AND nc.num_corp = $_corporacion ";
		  if($_instirucion!=0) $filtro .= " AND a.id_ano = $_instirucion ";
		  if($_bloque!=0) $filtro .= " AND a.id_cargo_evaluado = $_bloque ";
		  
		  if($_corporacion!=0 && $_instirucion==0 ) $rk .= "4,";
		  						
          $sql = "SELECT 
				  nc.num_corp,a.id_plantilla,co.nombre_corp as nombre_corporacion,
				  ci.rdb,inti.nombre_instit as nombre_institucion,evpl.nombre as nombre_pauta,
				  emp.rut_emp,emp.nombre_emp,emp.ape_pat,emp.ape_mat,
				  a.id_cargo_evaluado,b.sigla,count(*) as resultado
				  FROM nacional n 
				  INNER JOIN nacional_corp nc ON nc.id_nacional = n.id_nacional 
				  INNER JOIN corporacion co ON co.num_corp = nc.num_corp
				  INNER JOIN corp_instit ci ON ci.num_corp = nc.num_corp 
				  INNER JOIN evados.eva_ano_escolar ae ON ae.id_institucion = ci.rdb AND ae.nro_ano = $_ano
				  INNER JOIN institucion inti ON inti.rdb = ae.id_institucion
				  INNER JOIN evados.eva_plantilla_evaluacion a ON a.id_ano = ae.id_ano
				  INNER JOIN evados.eva_concepto b ON b.id_concepto = a.id_concepto 
				  INNER JOIN evados.eva_bloque_evaluador e ON e.rut_evaluador = a.rut_evaluador 
				  AND e.id_cargo = a.id_cargo_evaluador 
				  INNER JOIN public.empleado emp ON emp.rut_emp = a.rut_evaluado
				  INNER JOIN evados.eva_plantilla evpl ON evpl.id_plantilla = a.id_plantilla
				  INNER JOIN evados.eva_plantilla_area evpla ON evpla.id_area = a.id_area 
				  INNER JOIN evados.eva_plantilla_subarea evaplsu ON evaplsu.id_subarea = a.id_subarea 
				  INNER JOIN evados.eva_plantilla_item evaplit ON evaplit.id_item = a.id_item
				  INNER JOIN evados.eva_item_bloque c ON c.id_plantilla = a.id_plantilla 
				  AND c.id_area = a.id_area AND c.id_subarea = a.id_subarea 
				  AND c.id_item = a.id_item AND c.id_bloque = e.id_bloque 
				  INNER JOIN evados.eva_bloque d ON d.id_bloque = c.id_bloque 
				  WHERE n.id_nacional = $_nacional
				  AND b.sigla in ('C','D')
				  $filtro
				  GROUP BY 1,2,3,4,5,6,7,8,9,10,11,12
				  ORDER BY $rk 2,6";
		 			
		  $result = pg_exec( $this->Conec->conectar(),$sql) or die ("Select fallo : ".$sql); 
		  return $result;
	  
	  }
	
	
	
	public function resultado_general_individual($_nacional,$_ano,$_corporacion,$_instirucion,$_bloque,$rutemp){
		  	
		$filtro="";
		  
		if($_corporacion!=0) $filtro .= " AND nc.num_corp = $_corporacion ";
		if($_instirucion!=0) $filtro .= " AND a.id_ano = $_instirucion ";
		if($_bloque!=0) $filtro .= " AND a.id_cargo_evaluado = $_bloque ";
		if($rutemp!="") $filtro .= " AND a.rut_evaluado = $rutemp ";
		  
 $sql = "SELECT
				count(*) as total_general 
				FROM nacional n 
				INNER JOIN nacional_corp nc ON nc.id_nacional = n.id_nacional 
				INNER JOIN corporacion co ON co.num_corp = nc.num_corp 
				INNER JOIN corp_instit ci ON ci.num_corp = nc.num_corp 
				INNER JOIN evados.eva_ano_escolar ae ON ae.id_institucion = ci.rdb 
				AND ae.nro_ano = $_ano 
				INNER JOIN institucion inti ON inti.rdb = ae.id_institucion 
				INNER JOIN evados.eva_plantilla_evaluacion a ON a.id_ano = ae.id_ano 
				INNER JOIN evados.eva_concepto b ON b.id_concepto = a.id_concepto 
				INNER JOIN evados.eva_bloque_evaluador e ON e.rut_evaluador = a.rut_evaluador 
				AND e.id_cargo = a.id_cargo_evaluador 
				INNER JOIN public.empleado emp ON emp.rut_emp = a.rut_evaluado 
				INNER JOIN evados.eva_plantilla evpl ON evpl.id_plantilla = a.id_plantilla 
				INNER JOIN evados.eva_plantilla_area evpla ON evpla.id_area = a.id_area 
				INNER JOIN evados.eva_plantilla_subarea evaplsu ON evaplsu.id_subarea = a.id_subarea 
				INNER JOIN evados.eva_plantilla_item evaplit ON evaplit.id_item = a.id_item 
				INNER JOIN evados.eva_item_bloque c ON c.id_plantilla = a.id_plantilla 
				AND c.id_area = a.id_area AND c.id_subarea = a.id_subarea 
				AND c.id_item = a.id_item AND c.id_bloque = e.id_bloque 
				INNER JOIN evados.eva_bloque d ON d.id_bloque = c.id_bloque 
				WHERE n.id_nacional = 1
					  $filtro ";
		
		  $result = pg_exec( $this->Conec->conectar(),$sql) or die ("Select fallo : ".$sql); 
		  return $result;							
		
	    }
	
	
   
   }
  ?>