<? 

	$conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

	$conn2=@pg_connect("dbname=murialdo host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

	//Migracion de ramos desde muriadlo a coi final y l tablas tienes respectivas por pcardenas

	//MURIALDO
	//-- 789 = 2008  curso 110
	//-- 792 = 2009 curso 187
	//-- 793 = 2010 curso  9364
	
			//COI FINAL
			//-- 1265 = 2008 curso 23467
			//-- 1266 = 2009 curso 23468
			//-- 1267 = 2010 curso 23469

	$sql = "SELECT *  FROM ramo WHERE id_curso = 9364"; 		// ramos del curso  4b para distintos años 
	$rs   =  @pg_exec($conn2,$sql);

	for ($i=0; $i <  pg_num_rows($rs); $i++) { 
		
		$fila =  pg_fetch_array($rs,$i); 
		 
		$ramo_antiguo = $fila ['id_ramo'];
		
		    if(empty($fila['material'])){ $material = "NULL"; }else{ $material = $fila['material']; }
	        if(empty($fila['modo_eval'])){ $modo_eval = "NULL"; }else{ $modo_eval = $fila['modo_eval']; }
			if(empty($fila['tipo_ramo'])){ $tipo_ramo = "NULL"; }else{ $tipo_ramo = $fila['tipo_ramo']; }
			if(empty($fila['id_curso'])){ $id_curso = "NULL"; }else{ $id_curso = $fila['id_curso']; }
			if(empty($fila['cod_subsector'])){ $cod_subsector= "NULL"; }else{ $cod_subsector = $fila['cod_subsector']; }
			if(empty($fila['horas'])){ $horas= "NULL"; }else{ $horas= $fila['horas']; }
			if(empty($fila['sub_obli'])){ $sub_obli= "NULL"; }else{ $sub_obli = $fila['sub_obli']; }
			if(empty($fila['sub_elect'])){ $sub_elect= "NULL"; }else{ $sub_elect= $fila['sub_elect']; }
			if(empty($fila['bool_ip'])){ $bool_ip = "NULL"; }else{ $bool_ip = $fila['bool_ip']; }
			if(empty($fila['bool_sar'])){ $bool_sar = "NULL"; }else{ $bool_sar = $fila['bool_sar']; }
			if(empty($fila['conex'])){ $conex = "NULL"; }else{ $conex = $fila['conex']; }
			if(empty($fila['pct_examen'])){ $pct_examen = "NULL"; }else{ $pct_examen= $fila['pct_examen']; }
			if(empty($fila['nota_exim'])){ $nota_exim = "NULL"; }else{ $nota_exim = $fila['nota_exim']; } 
			if(empty($fila['truncado'])){ $truncado= "NULL"; }else{ $truncado = $fila['truncado']; }
			if(empty($fila['id_orden'])){ $id_orden = "NULL"; }else{ $id_orden= $fila['id_orden']; } 
			if(empty($fila['truncado_per'])){ $truncado_per = "NULL"; }else{ $truncado_per = $fila['truncado_per']; }
			if(empty($fila['prueba_nivel'])){ $prueba_nivel = "NULL"; }else{ $prueba_nivel = $fila['prueba_nivel']; } 
		
		echo $insert = "INSERT INTO ramo ( material,	modo_eval,	tipo_ramo,id_curso,	cod_subsector,
		horas, 	sub_obli,	sub_elect, 	bool_ip,	bool_sar,	conex, 
		pct_examen, 	nota_exim,	truncado,	id_orden,	truncado_per, 
		prueba_nivel)
	    VALUES ( ".$material.", ".$modo_eval.", ".$tipo_ramo.", 23469, ".$cod_subsector.", 
	    ".$horas.", ".$sub_obli.",  ".$sub_elect.", ".$bool_ip.", ".$bool_sar.", ".$conex.", ".$pct_examen.", 
	    ".$nota_exim.", ".$truncado.", ".$id_orden.", ".$truncado_per.", ".$prueba_nivel.");";
		
		echo "<br/>";
				
		// INSERT INTO NUEVO RAMO
		$rs_insert = @pg_exec($conn,$insert);   
		 		
		if($rs_insert){
		 echo "insert ok <br>"; 
		}else{
		 echo "error insert <br>";
		}
		
		// BUSCO ID NUEVO RAMO 
		 $sql_ultimo_id_ramo = "SELECT  id_ramo FROM ramo ORDER BY  1 DESC  LIMIT 1";  	
		 $rs_ultimo_id_ramo = @pg_exec($conn,$sql_ultimo_id_ramo);
		
		 $ramo_nuevo =  pg_result($rs_ultimo_id_ramo,0);    
		 
		 //  BUSCO ALUMNO ASOCIADOS AL RAMO ANTIGUO;
		$sql = "SELECT  rut_alumno FROM tiene2010 WHERE  id_curso = 9364 AND id_ramo = $ramo_antiguo"; 
	     $rs_alumnos_tienen_ramo = @pg_exec($conn2,$sql);
		
					for ($a=0; $a <  pg_num_rows($rs_alumnos_tienen_ramo); $a++){
						 
							$fila_alumnos_tienen_ramo =  pg_fetch_array($rs_alumnos_tienen_ramo,$a);
							$rut_alumno =   $fila_alumnos_tienen_ramo['rut_alumno'];
							
							// INSERTO ALUMNOS CON NUEVO ID RAMO
							$insert_alumnos_tienen_ramo = "INSERT INTO public.tiene2010
							 ( rut_alumno,id_ramo,id_curso) VALUES ( $rut_alumno, $ramo_nuevo,23469);"; 
						    $result = @pg_exec($conn,$insert_alumnos_tienen_ramo);
							if($result){
							echo "insert ok <br/>";
							}else{
							echo "no insert <br/>";
							}
					
					}
		

		
		           // Selecciono Dicta 
		           $sql = "SELECT   rut_emp, id_ramo  FROM  public.dicta  where id_ramo = $ramo_antiguo  ;";
				   $result = @pg_exec($conn2,$sql);
				   if( $result){
				   		$rut_emp = pg_result($result,0);
				   	    $insert = "INSERT INTO    public.dicta (   rut_emp,   id_ramo ) VALUES (  $rut_emp  ,   $ramo_nuevo );";
						$result = @pg_exec($conn,$insert);
						if($result){
							echo "insert dicta ok <br/>";
						}else{
							echo "Error en insert Dicta	<br/>";
						}
				   }else{
						echo "ERROR en insert dicta <br/>";
				    }
				    				    				   
				//Selecciono Notas del Ano  2008
				//--primero 1609
				//--segundo 1610
				// primero 2555
				// segundo 2556 
                /******************************/ 
               	//Selecciono Notas del Ano  2009
				//--primero 1615 
				//--segundo 1616
				// primero 2557
				// segundo 2558 
               /*********************************/ 
               //Selecciono Notas del ano 2010
               //--primero 1617
              //--segundo 1618
               //--primero 2559
               //--segundo 2560               
             /*********************************/ 
                
                

				 
		$sql_n1 = "SELECT * FROM  notas2010 WHERE  id_ramo = $ramo_antiguo  AND  id_periodo = 1617" ; 
		$result_n1 = @pg_exec($conn2,$sql_n1);
		
		for ($in1=0; $in1 < pg_num_rows($result_n1); $in1++) {
				 			
				 	$fila_n1 = pg_fetch_array($result_n1,$in1);
				 						 			
					 if($fila_n1['notaap']==NULL){ 
					  $notaap = NULL; 
					 }else{ 
					  $notaap = $fila_n1['notaap']; 
					 }
							 
		     $insert = "INSERT INTO public.notas2010
								( rut_alumno,id_ramo,id_periodo,nota1,
								   nota2,nota3,nota4,nota5,nota6,
								   nota7,nota8,nota9,nota10,nota11,
								   nota12,nota13,nota14,nota15,nota16,
								   nota17,nota18,nota19,nota20,promedio,notaap
								) VALUES (
								  ".$fila_n1['rut_alumno'].",
								  ".$ramo_nuevo.",2559,
								  '".$fila_n1['nota1']."',
								  '".$fila_n1['nota2']."',
								  '".$fila_n1['nota3']."',
								  '".$fila_n1['nota4']."',
								  '".$fila_n1['nota5']."',
								  '".$fila_n1['nota6']."',
								  '".$fila_n1['nota7']."',
								  '".$fila_n1['nota8']."',
								  '".$fila_n1['nota9']."',
								  '".$fila_n1['nota10']."',
								  '".$fila_n1['nota11']."',
								  '".$fila_n1['nota12']."',
								  '".$fila_n1['nota13']."',
								  '".$fila_n1['nota14']."',
								  '".$fila_n1['nota15']."',
								  '".$fila_n1['nota16']."',
								  '".$fila_n1['nota17']."',
								  '".$fila_n1['nota18']."',
								  '".$fila_n1['nota19']."',
								  '".$fila_n1['nota20']."',
								  '".$fila_n1['promedio']."',
								  '".$notaap."' );";		
					 	 $rs_n1 = pg_exec($conn,$insert ) or die("Error : ".$insert );
					 	 
					 	 			if($rs_n1){
					 	 				echo "INSERT NOTAS OK PRIMERA<br/>";	
					 	 			}

                     }   // ciclo de las notas donde tengo el rut de alumnos del curso 
               
               
		$sql = "SELECT * FROM notas2010  WHERE  id_ramo = $ramo_antiguo   AND  id_periodo = 1618"; 
			 $result_n2 = @pg_exec($conn2,$sql);
			    
				for ($in2=0; $in2 < pg_num_rows($result_n2); $in2++) { 
						
					$fila_n2 = pg_fetch_array($result_n2,$in2);
											
					 if($fila_n2['notaap']==NULL){  
					  $notaap ="NULL"; 
					 }else{ 
					  $notaap = $fila_n2['notaap']; 
					 }					
								
					 $insert = "INSERT INTO  public.notas2010  ( rut_alumno,id_ramo,id_periodo,nota1,
								  nota2,nota3,nota4,nota5,nota6, nota7,nota8,nota9,nota10,nota11,
								  nota12,nota13,nota14,nota15,nota16,
								  nota17,nota18,nota19,nota20,promedio,notaap
								) VALUES (
								  ".$fila_n2['rut_alumno'].",
								  ".$ramo_nuevo.",2560,
								  '".$fila_n2['nota1']."',
								  '".$fila_n2['nota2']."',
								  '".$fila_n2['nota3']."',
								  '".$fila_n2['nota4']."',
								  '".$fila_n2['nota5']."',
								  '".$fila_n2['nota6']."',
								  '".$fila_n2['nota7']."',
								  '".$fila_n2['nota8']."',
								  '".$fila_n2['nota9']."',
								  '".$fila_n2['nota10']."',
								  '".$fila_n2['nota11']."',
								  '".$fila_n2['nota12']."',
								  '".$fila_n2['nota13']."',
								  '".$fila_n2['nota14']."',
								  '".$fila_n2['nota15']."',
								  '".$fila_n2['nota16']."',
								  '".$fila_n2['nota17']."',
								  '".$fila_n2['nota18']."',
								  '".$fila_n2['nota19']."',
								  '".$fila_n2['nota20']."',
								  '".$fila_n2['promedio']."',
								  '".$notaap."' );";		
					 	 			$rs_n2 = pg_exec($conn,$insert) or die("Error : ".$insert);		
					 	 			
					 	 			if($rs_n2){
					 	 				echo "INSERT NOTAS OK SEGUNDO  <br/>";	
					 	 			}else{ echo "false"; }


		   				
				// PROMOCION DE ESTE ALUMNO
 
		        $sql_promocion = "SELECT  rdb, id_ano, id_curso, rut_alumno, promedio, asistencia,
				situacion_final, fecha_retiro,  cod_esp,  cod_sector, cod_rama,
				tipo_reprova,  observacion, usuario,  fecha_prom, hora_prom
				FROM 
				public.promocion 
				WHERE  rdb = 1604  AND id_ano = 793  AND id_curso =  9364  AND rut_alumno =  ".$fila_n2['rut_alumno']." ;" ;
				$result_03 = @pg_exec($conn2, $sql_promocion );
				
				
			   
			   for ($i3=0; $i3 < pg_num_rows($result_03); $i3++) {
			   	
				    $fila_03  = pg_fetch_array($result_03,$i3);
					
						if(empty($fila_03['rut_alumno'])){ $rut_alumno = "NULL"; }else{ $rut_alumno = $fila_03['rut_alumno']; }
						
						if(empty($fila_03['promedio'])){ $promedio ="NULL"; }else{ $promedio = $fila_03['promedio']; }
						
						if(empty($fila_03['asistencia'])){ $asistencia ="NULL"; }else{ $asistencia = $fila_03['asistencia']; }
						
						if(empty($fila_03['situacion_final'])){ $situacion_final = "NULL"; }else{ $situacion_final = $fila_03['situacion_final']; }
						
						if(empty($fila_03['fecha_retiro'])){ $fecha_retiro = "DEFAULT"; }else{ $fecha_retiro  =  "'".$fila_03['fecha_retiro']."'"; }
						
						if(empty($fila_03['cod_esp'])){ $cod_esp = "NULL"; }else{ $cod_esp = $fila_03['cod_esp']; }
						
						if(empty($fila_03['cod_sector'])){ $cod_sector = "NULL"; }else{ $cod_sector = $fila_03['cod_sector']; }
						
						if(empty($fila_03['cod_rama'])){ $cod_rama = "NULL"; }else{ $cod_rama = $fila_03['cod_rama']; }
						
						if(empty($fila_03['tipo_reprova'])){ $tipo_reprova ="NULL"; }else{ $tipo_reprova  = $fila_03['tipo_reprova']; }
						
						if(empty($fila_03['observacion'] )){ $observacion = "NULL"; }else{ $observacion = $fila_03['observacion']; }


		$sql_select_promocion = " SELECT * FROM public.promocion
		WHERE  rdb = 1604 AND id_ano = 1267 AND id_curso = 23469 and rut_alumno = ".$rut_alumno."; ";
		$result_03_select = @pg_exec($conn, $sql_select_promocion);
		
		if(!pg_num_rows($result_03_select)!=0){

	      $sql_insert_03 = "INSERT INTO public.promocion
					( rdb,id_ano,id_curso,rut_alumno,promedio,asistencia,situacion_final,	fecha_retiro,cod_esp,cod_sector,cod_rama,tipo_reprova,observacion)
					VALUES ( 1604,1267,23469,".$rut_alumno.",".$promedio.",".$asistencia.",
					".$situacion_final.", ".$fecha_retiro.", ".$cod_esp.",  ".$cod_sector.",
					".$cod_rama.", ".$tipo_reprova.", '".$observacion."');";
  
                    $result_003 = @pg_exec($conn,$sql_insert_03 );
					                            
					if($result_003){
					       echo "insert promocion alumno ok <br/>";
					}else{
					      echo "insert promocion alumno Error ".$sql_insert_03."<br/>";
					      }

						}
												 
	                 }	
					 
				               
				// PROMEDIO SUB ALUMNO DE ESTE ALUMNO.
		        $sql_promedio_sub_alumno = "SELECT 
				rdb,id_ano,id_curso,id_ramo,rut_alumno,promedio
				FROM  public.promedio_sub_alumno 
			    WHERE  rdb = 1604  AND id_ano = 793  AND id_curso =  9364  
			   AND id_ramo = $ramo_antiguo  AND rut_alumno =  ".$fila_n2['rut_alumno'].";";
			   $result_04 = @pg_exec($conn2,  $sql_promedio_sub_alumno );
			   
			   for ($i4=0; $i4 < pg_num_rows($result_04); $i4++) {
				    $fila_04  = pg_fetch_array($result_04,$i4);
				   
			$sql_insert_05 = "INSERT INTO public.promedio_sub_alumno
												(   rdb,id_ano,id_curso,id_ramo,rut_alumno,promedio) 
												VALUES ( 1604,1267,23469,$ramo_nuevo,".$fila_04['rut_alumno'].",'".$fila_04['promedio']."' );"; 
                                                $result_05 = @pg_exec($conn,$sql_insert_05 );
                                                
					                             if($result_05){
					                                 echo "insert promedio sub alumno ok <br/>";
					                             }else{
					                             	echo "insert promedio sub alumno Error ".$sql_insert_05."<br/>";
					                             }
			                             
			                             }	

					              
					              }  

               	 

         }



/*
function fEs2En3($txt){
	$x=substr($txt,8,2); //MES	
	$x.="-";
	$x.=substr($txt,5,2);//DIA	
	$x.="-";
	$x.= substr($txt,0,4); // AÑO
	return $x;
}

function fEs2En22445($txt){

	$x=substr($txt,5,2); //MES	
		$x.="-";
		$x.=substr($txt,8,2);//DIA	
		$x.="-";
		$x.= substr($txt,0,4); // AÑO
		return $x;

}
$sql ="SELECT c.grado_curso,c.letra_curso,c.ensenanza, m.* FROM matricula m INNER JOIN curso c ON m.id_ano=c.id_ano AND m.id_curso=c.id_curso WHERE rdb=14275 and m.id_ano in (SELECT id_ano FROM ano_escolar WHERE id_institucion=14275 and nro_ano=2007)";
$rs_alumno = pg_exec($conn2,$sql);


for($i=0;$i<pg_numrows($rs_alumno);$i++){
	$fila = pg_fetch_array($rs_alumno,$i);
	
	$sql ="SELECT id_curso,id_ano FROM curso WHERE ensenanza=".$fila['ensenanza']." AND grado_curso='".$fila['grado_curso']."' AND letra_curso='".$fila['letra_curso']."' and id_ano in (SELECT id_ano FROM ano_escolar WHERE id_institucion=14275 and nro_ano=2007)";
	$rs_curso= pg_exec($conn,$sql);
	$id_curso = pg_result($rs_curso,0);
	$id_ano = pg_result($rs_curso,1);

	

	if($fila['fecha_retiro']!=""){
		$fecha_retiro = fEs2En22445($fila['fecha_retiro']);
	}
	if($fila['bool_ar']=="1"){
		echo "<br>".$sql ="INSERT INTO matricula (rut_alumno, rdb, id_ano, id_curso, fecha, num_mat, bool_baj, bool_bchs, bool_aoi, bool_rg, bool_ae, bool_i, bool_gd, bool_ar, fecha_retiro, nro_lista) VALUES('".$fila['rut_alumno']."','".$fila['rdb']."','".$id_ano."','".$id_curso."','".fEs2En22445($fila['fecha'])."','".$fila['num_mat']."','".$fila['bool_baj']."','".$fila['bool_bchs']."','".$fila['bool_aoi']."','".$fila['bool_rg']."','".$fila['bool_ae']."','".$fila['bool_i']."','".$fila['bool_gd']."','".$fila['bool_ar']."','".$fecha_retiro."','".$fila['nro_lista']."')";
	}else{
		echo "<br>".$sql ="INSERT INTO matricula (rut_alumno, rdb, id_ano, id_curso, fecha, num_mat, bool_baj, bool_bchs, bool_aoi, bool_rg, bool_ae, bool_i, bool_gd, bool_ar, nro_lista) VALUES('".$fila['rut_alumno']."','".$fila['rdb']."','".$id_ano."','".$id_curso."','".fEs2En22445($fila['fecha'])."','".$fila['num_mat']."','".$fila['bool_baj']."','".$fila['bool_bchs']."','".$fila['bool_aoi']."','".$fila['bool_rg']."','".$fila['bool_ae']."','".$fila['bool_i']."','".$fila['bool_gd']."','".$fila['bool_ar']."','".$fila['nro_lista']."')";
	
	}
		$rs_insert = pg_exec($conn,$sql); 
		
}  */






