<?php require('../../../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$institucion	=$_INSTIT;
	$plan			=$_PLAN;

	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
		  
	if($truncado) $truncado=1;	else	$truncado=0;
	

	if (!isset($conEX)){
	
	$conEX=2;
    $txtNEXIM=0;
	$txtPCT=0;

	}
	
	
	
if ($frmModo=="ingresar") {
          
	      if($ip)		$ip=1;		else	$ip=0;
	      if($sar)		$sar=1;		else	$sar=0;
		  if($truncado) $truncado=1;	else	$truncado=0;
		  
		            
		  if ($cmbSUBS==3){
		      // agregar el nuevo subsector a otra tabla de subsectores.
			  // buscamos cual es el maximo numero de subsector_otros para
			  // detectar cual es el que viene.
			  $sql_id_max_sub = "SELECT max(id_aux) as id_max FROM subsector_otros";
			  $res_id_max_sub = @pg_Exec($conn,$sql_id_max_sub);
			  $fila_sub = @pg_fetch_array($res_id_max_sub,0);	
			  $max_id_sub = trim($fila_sub['id_max']);
			  
			  // aumento el max_id_sub para no toparme con otro codigos de subsectores
			  $max_id_sub = $max_id_sub + 50000;
			  
			  // inserto en la nueva tabla que contiene el subsector creado
			  $qry_insert_sub = "insert into subsector_otros (cod_subsector_o,nombre_o)
			  values ('$max_id_sub','$nombresubsector')";
			  $res_insert_sub = @pg_Exec($conn,$qry_insert_sub);
			  
			  // ahora asigno el nuevo codigo a la variable subsector
			  $subsector = $max_id_sub;
			  $codSub    = $max_id_sub;
			  
			  // ahora debo insertar el subsector en la tabla normal de los subsectores
			  $qry_100 = "insert into subsector (cod_subsector, nombre)
			  values ('$subsector','$nombresubsector')";
			  $res_100 = pg_Exec($conn,$qry_100);
			  	  			  
			  /// i se continúa con el proceso de ingreso del subsector...
		  }else{	   
		       if ($chktodos==1){			        
			   
			        $i = 1;
				    /// otras variables
				    if($sub_ob==""){ $sub_ob=0; }		
					if($conEX==""){ $conEX=0; }
					if($txtPCT==""){ $txtPCT=0; }
					if($txtNEXIM==""){ $txtNEXIM=0; }
					if($newOr==""){ $newOr=0; }	 
					if($prueba_niv==""){ $prueba_niv=0; }
					if($txtPCTNIV==""){ $txtPCTNIV=0; }
					if($cmbMODOpruebaNivel==""){ $cmbMODOpruebaNivel=0; }
					if($pct_ex_escrito==""){ $pct_ex_escrito=0; }
					if($pct_ex_oral==""){ $pct_ex_oral=0; }				   
				   				   
				  
					   
					  					   
					  				   
					   
					      /// aqui comienzo proceso para agregar todos los subsectores seleccionados
						  /// tomo el id_curso maximo para insertar						  
						  $qry="SELECT MAX(ID_RAMO) AS ramo, max(id_orden)+1 as orden FROM RAMO WHERE ID_CURSO=".$curso;
				          $result =@pg_Exec($conn,$qry);
			              if (!$result){
				               error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
				               exit;
	   		              }
		                  $fila = @pg_fetch_array($result,0);	
		                  if (!$fila){
			                   error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			                   exit;
		                  }
				          $newID = trim($fila['ramo']);
		                  $newOr = trim($fila['orden']);
		                  if (empty($newOr)) $newOr = 1;
						  
						  if ($chktodos==1){
						     //SUBSECTORES QUE CORRESPONDEN AL CURSO DE ACUERDO AL PLAN DE ESTUDIO
							 $qry2="SELECT * FROM curso WHERE ID_CURSO=".$curso;
							 $result2 =@pg_Exec($conn,$qry2);
							 $fila2= @pg_fetch_array($result2,0);
							 $qry=0;
								
								if (($fila3['ensenanza']==110) and (($plan=="5451996") or ($plan=="5521997") or ($plan=="2201999") or ($plan=="812000") or ($plan=="4812000") or ($plan=="922002") or ($plan=="771999") or ($plan=="832000") or ($plan=="272001") or ($plan=="1022002") or ($plan=="4592002") or ($plan=="771982") or ($plan=="1901975") or ($plan=="121987") or ($plan=="1521989"))){
									$qry7="SELECT subsector.cod_subsector, subsector.nombre FROM subsector INNER JOIN ((curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN incluye ON plan_estudio.cod_decreto = incluye.cod_decreto) ON subsector.cod_subsector = incluye.cod_subsector WHERE (((curso.id_curso)=".$curso.")) union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
								
								}elseif (($fila3['ensenanza']>=310) AND (($fila2['grado_curso']==1) OR ($fila2['grado_curso']==2)) and (($plan=="5451996") or ($plan=="5521997") or ($plan=="2201999") or ($plan=="812000") or ($plan=="4812000") or ($plan=="922002") or ($plan=="771999") or ($plan=="832000") or ($plan=="272001") or ($plan=="1022002") or ($plan=="4592002") or ($plan=="771982") or ($plan=="1901975") or ($plan=="121987"))){
									$qry7="SELECT subsector.cod_subsector, subsector.nombre FROM subsector INNER JOIN ((curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN incluye ON plan_estudio.cod_decreto = incluye.cod_decreto) ON subsector.cod_subsector = incluye.cod_subsector WHERE (((curso.id_curso)=".$curso.")) union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
								
								}elseif (($fila3['ensenanza']>=410) AND (($fila2['grado_curso']==3) OR ($fila2['grado_curso']==4)) and (($plan=="5451996") or ($plan=="5521997") or ($plan=="2201999") or ($plan=="812000") or ($plan=="4812000") or ($plan=="922002") or ($plan=="771999") or ($plan=="832000") or ($plan=="272001") or ($plan=="1022002") or ($plan=="4592002") or ($plan=="771982") or ($plan=="1901975") or ($plan=="121987") or ($plan=="1521989") ))  {
									$qry7="select subsector.cod_subsector, subsector.nombre from incluye_tp inner join subsector on incluye_tp.cod_subsector=subsector.cod_subsector where incluye_tp.cod_esp=".$fila3['cod_es']." and incluye_tp.cod_rama=".$fila3['cod_rama']." and incluye_tp.cod_sector=".$fila3['cod_sector']." and complementario=1 and curso.id_curso=".$curso." union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
									
								}elseif (($fila3['ensenanza']>=460) AND (($fila2['grado_curso']==1) and ($plan=="1521989")) )  {
									$qry7="select subsector.cod_subsector, subsector.nombre from incluye_tp inner join subsector on incluye_tp.cod_subsector=subsector.cod_subsector where incluye_tp.cod_esp=".$fila3['cod_es']." and incluye_tp.cod_rama=".$fila3['cod_rama']." and incluye_tp.cod_sector=".$fila3['cod_sector']." and complementario=1 and curso.id_curso=".$curso." union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
								
								}elseif (($plan!="5451996") and ($plan!="5521997") and ($plan!="2201999") and ($plan!="812000") and ($plan!="4812000") and ($plan!="922002") and ($plan!="771999") and ($plan!="832000") and ($plan!="272001") and ($plan!="1022002") and ($plan!="4592002") and ($plan!="771982") and ($plan!="1901975") and ($plan!="121987") and ($plan!="1521989")){
									$qry7="select * from incluye_propio inner join subsector on incluye_propio.cod_subsector =subsector.cod_subsector where incluye_propio.cod_decreto=".$plan;
								}
							
						 
							 $result7 =@pg_Exec($conn,$qry7);
							 if (!$result7){ 
								 error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>'.$qry7);
							 }else{	
							 					  				 
								for($i=0 ; $i < @pg_numrows($result7) ; $i++){
									$fila7 = @pg_fetch_array($result7,$i);
									//RAMOS INGRESADOS AL CURSO
									$qry2="SELECT subsector.cod_subsector, subsector.nombre FROM (curso INNER JOIN ramo ON curso.id_curso = ramo.id_curso) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((curso.id_curso)=".$curso.") AND ((subsector.cod_subsector)=".$fila7["cod_subsector"]."))";
									$result2 =@pg_Exec($conn,$qry2);
										if (!$result2){ 
											error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
										}else{
											if (pg_numrows($result2)==0){
											    $chk = "chk".$fila7['cod_subsector'];
												$chk = $$chk; 
											
												if ($chk > 0){ // ingresar
																									  
														  $qry="SELECT MAX(ID_RAMO) AS ramo, max(id_orden)+1 as orden FROM RAMO WHERE ID_CURSO=".$curso;
														  $result =@pg_Exec($conn,$qry);
														  if (!$result){
																error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
																exit;
														  }
														  $fila = @pg_fetch_array($result,0);	
														  if (!$fila){
															 error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
															 exit;
														  }
														
														  $newID = trim($fila['ramo']);
														  $newOr = trim($fila['orden']);
														  if (empty($newOr)) $newOr = 1;
												
													echo "<br><br>";	
													echo   $qry="INSERT INTO RAMO (ID_CURSO, TIPO_RAMO, COD_SUBSECTOR, MODO_EVAL, SUB_OBLI, BOOL_IP, BOOL_SAR, CONEX, PCT_EXAMEN, NOTA_EXIM, TRUNCADO, ID_ORDEN, PRUEBA_NIVEL, PCT_NIVEL, MODO_EVAL_PNIVEL, PCT_EX_ESCRITO, PCT_EX_ORAL, FORMACION) VALUES (".$curso.",1,".$chk.",".$cmbMODO.",".$sub_ob.",".$ip.",".$sar.",".$conEX.",".$txtPCT.",".$txtNEXIM.",".$truncado.",".$newOr .",".$prueba_niv.",".$txtPCTNIV.",".$cmbMODOpruebaNivel.",".$pct_ex_escrito.",".$pct_ex_oral.",1)";
													
													
														  $result =pg_Exec($conn,$qry);
														  if (!$result) {
															 error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
															 exit;
														  }
														
														  if($codSub!=""){
															   $qryC = "select * from sub_propio where cod_subsector=".$chk." and rdb=".$institucion;
															   $resultC = pg_exec($conn, $qryC);
															   if (!$resultC) {
																  error('<b> ERROR :</b>Error al acceder a la BD. (30)'.$qryC);
																  exit;
															   }
															   $cant= pg_numrows($resultC);
															   if ($cant =0){
																	$qryPpio="insert into sub_propio (cod_subsector, rdb, id_ano, nro_res, fecha_res) values(".$chk.", ".$institucion.", ".$ano.", ".$codRes.", to_date('" .$txtFecha. "','DD MM YYYY'))";
																	$resultPpio=pg_Exec($conn,$qryPpio);
																	if (!$resultPpio) {
																		error('<b> ERROR :</b>Error al acceder a la BD. (31)'.$qryPpio);
																		exit;
																	}
															   }
														  }
														
														
														  $qry="SELECT MAX(ID_RAMO) AS ramo, max(id_orden)+1 as orden FROM RAMO WHERE ID_CURSO=".$curso;
														  $result =@pg_Exec($conn,$qry);
														  if (!$result){
															 error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
															 exit;
														  }
														  $fila = @pg_fetch_array($result,0);	
														  if (!$fila){
															 error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
															 exit;
														  }
														  $newID = trim($fila['ramo']);
														
														  $qry="INSERT INTO DICTA (RUT_EMP,ID_RAMO) VALUES ('".$cmbDOC."',".$newID.")";
														  $result =@pg_Exec($conn,$qry);
														  if (!$result) {
															  error('<b> ERROR :</b>Error al acceder a la BD.(41)'.$qry);
															  exit;
														  }												  
												
														  if($cmbAYU!=0){
															  $qry="INSERT INTO AYUDA (RUT_EMP,ID_RAMO) VALUES ('".$cmbAYU."',".$newID.")";
															  $result =@pg_Exec($conn,$qry);
															  if (!$result) {
																  error('<b> ERROR :</b>Error al acceder a la BD.(51)'.$qry);
																  exit;
															  }
														  }
														
														 
												 } /// fin ingresar
											
											}
											
										}
								} // fin for de ingreso masivo
							}
							
							  exit();
							
							 echo "<script>window.location = 'listarRamos.php3?plan=".$_PLAN."'</script>"; 
							
						}else{ // proceso normal		
		     
							  $qry="INSERT INTO RAMO (ID_CURSO, TIPO_RAMO, COD_SUBSECTOR, MODO_EVAL, SUB_OBLI, BOOL_IP, BOOL_SAR, CONEX, PCT_EXAMEN, NOTA_EXIM, TRUNCADO, ID_ORDEN, PRUEBA_NIVEL, PCT_NIVEL, MODO_EVAL_PNIVEL, PCT_EX_ESCRITO, PCT_EX_ORAL, FORMACION) VALUES (".$curso.",1,".$codSub.",".$cmbMODO.",".$sub_ob.",".$ip.",".$sar.",".$conEX.",".$txtPCT.",".$txtNEXIM.",".$truncado.",".$newOr .",".$prueba_niv.",".$txtPCTNIV.",".$cmbMODOpruebaNivel.",".$pct_ex_escrito.",".$pct_ex_oral.",1)";
							  $result =pg_Exec($conn,$qry);
							  if (!$result) {
								  error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
								  exit;
							  }
						  }	  
						      
		                  if($codsub!=""){
						      //echo "entro 1";
			                  $qryC = "select * from sub_propio where cod_subsector=".$codsub." and rdb=".$institucion;
			                  $resultC = pg_exec($conn, $qryC);
				              if (!$resultC){
					               error('<b> ERROR :</b>Error al acceder a la BD. (30)'.$qryC);
					               exit;
					          }
				              $cant= pg_numrows($resultC);
							  if ($codRes!=NULL and $txtFecha!=NULL){
					              if ($cant =0){
						              $qryPpio="insert into sub_propio (cod_subsector, rdb, id_ano, nro_res, fecha_res) values(".$codsub.", ".$institucion.", ".$ano.", ".$codRes.", to_date('" .$txtFecha. "','DD MM YYYY'))";
						              $resultPpio=pg_Exec($conn,$qryPpio);
							      	  
							          if (!$resultPpio){
								         error('<b> ERROR :</b>Error al acceder a la BD. (31)'.$qryPpio);
								         exit;
									  }	 
							      }
							  }	  
					       }else{
						      //echo "no entro";
						   
						   
						   }
			            
		                  
		
		                   $qry="SELECT MAX(ID_RAMO) AS ramo, max(id_orden)+1 as orden FROM RAMO WHERE ID_CURSO=".$curso;
		                   $result =@pg_Exec($conn,$qry);
			               if (!$result){
				               error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
				               exit;
	   		               }
		                   $fila = @pg_fetch_array($result,0);	
		                   if (!$fila){
			                   error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			                   exit;
		                   }
		                   $newID = trim($fila['ramo']);
						   $id_ramo_new = $newID;
		
	                       $qry="INSERT INTO DICTA (RUT_EMP,ID_RAMO) VALUES ('".$cmbDOC."',".$newID.")";
	                       $result =@pg_Exec($conn,$qry);
	                       if (!$result) {
		                       error('<b> ERROR :</b>Error al acceder a la BD.(41)'.$qry);
		                       exit;
	                       }
                           if($cmbAYU!=0){
		                       $qry="INSERT INTO AYUDA (RUT_EMP,ID_RAMO) VALUES ('".$cmbAYU."',".$newID.")";
		                       $result =@pg_Exec($conn,$qry);
					       }	   
		                   if (!$result) {
			                   error('<b> ERROR :</b>Error al acceder a la BD.(51)'.$qry);
			                   exit;
		                   }
					     
					   
						   ////NUEVO PROCESO PARA INSCRIBIR LOS ALUMOS AUTOMATICAMENTE EN EL SUBSECTOR  ///				   
						   
						   $sql_alumnos = "select rut_alumno from matricula where id_ano = '".trim($ano)."' and bool_ar = '0' and id_curso in (select id_curso from curso where id_curso in (select id_curso from ramo where id_ramo = '".trim($id_ramo_new)."'))";
						   $res_alumnos = @pg_Exec($conn,$sql_alumnos);
						   $num_alumnos = @pg_numrows($res_alumnos);
						  
						   if ($num_alumnos>0){
							   $k = 0;
							   while ($k < $num_alumnos){
								   $fila_alumno = @pg_fetch_array($res_alumnos,$k);
								   $rut_alumno = $fila_alumno['rut_alumno'];
							   
								   // verificar si este alumnos ya esta incrito en la tabla tinenro_ano
								   $sql_tiene = "select * from tiene$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_ramo_new)."' and id_curso = '".trim($curso)."'";
								   $res_tiene = @pg_Exec($conn,$sql_tiene);
								   $num_tiene = @pg_numrows($res_tiene);
								   
								   if ($num_tiene > 0){
										// no de debe agregar
								   }else{
										// hacer el insert en tiene							   
										$sql_inserta_alumno = "insert into tiene$nro_ano (rut_alumno, id_ramo, id_curso) values ('".trim($rut_alumno)."','".trim($id_ramo_new)."','".trim($curso)."')";
										$res_inserta_alumno = @pg_Exec($conn,$sql_inserta_alumno);
								   }
								   $k++;
							   }	   		
						   }else{
						   
							   echo "Atención. No hay alumnos encontrados para relacionarlos con este curso: $curso y subsector: $id_ramo_new. Avise al administrador del sistema";
							   exit();
						   }
					  
	                 			  
				    echo "<script>window.location = 'listarRamos.php3?plan=".$_PLAN."'</script>";
					exit();
					
			   }else{
			       if($cmbSUB!=""){
		               $subsector=$cmbSUB;
			       }else{
				       if ($codSub!=""){
				          $subsector=$codSub;
			           }
				   }
			   }			  	  
		  }	  
		 		  
		  if($cmbSUB!=0){
		      $subsector=$cmbSUB;
		  }else{
		      if ($codSub!=""){
		          $subsector=$codSub;
		      }
		  }
		  
    
		  if($sub_ob=="")$sub_ob=0;	
		  if($conEX=="")$conEX=0;
		  if($txtPCT=="")$txtPCT=0;
		  if($txtNEXIM=="")$txtNEXIM=0;
		  if($newOr=="")$newOr=0;	 
		  if($prueba_niv=="")$prueba_niv=0;
		  if($txtPCTNIV=="")$txtPCTNIV=0;
		  if($cmbMODOpruebaNivel=="")$cmbMODOpruebaNivel=0;
		  if($pct_ex_escrito=="")$pct_ex_escrito=0;
		  if($pct_ex_oral=="")$pct_ex_oral=0;
		 	
		
		  
		  
		  $qry="SELECT MAX(ID_RAMO) AS ramo, max(id_orden)+1 as orden FROM RAMO WHERE ID_CURSO=".$curso;
		  $result =@pg_Exec($conn,$qry);
		  if (!$result){
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
				exit;
	   	  }
		  $fila = @pg_fetch_array($result,0);	
		  if (!$fila){
			 error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			 exit;
		  }
		
		  $newID = trim($fila['ramo']);
		  $newOr = trim($fila['orden']);
		  if (empty($newOr)) $newOr = 1;

		
//		  $qry="INSERT INTO RAMO (ID_CURSO, TIPO_RAMO, COD_SUBSECTOR, MODO_EVAL, SUB_OBLI, BOOL_IP, BOOL_SAR, CONEX, PCT_EXAMEN, NOTA_EXIM, TRUNCADO, ID_ORDEN, PRUEBA_NIVEL, PCT_NIVEL, MODO_EVAL_PNIVEL, PCT_EX_ESCRITO, PCT_EX_ORAL) VALUES (".$curso.",1,".$subsector.",".$cmbMODO.",".$sub_ob.",".$ip.",".$sar.",'".$conEX."','".$txtPCT."','".$txtNEXIM."','".$truncado."',".$newOr .",'".$prueba_niv."','".$txtPCTNIV."', '".$cmbMODOpruebaNivel."','".$pct_ex_escrito."','".$pct_ex_oral."')";
    	  $qry="INSERT INTO RAMO (ID_CURSO, TIPO_RAMO, COD_SUBSECTOR, MODO_EVAL, SUB_OBLI, BOOL_IP, BOOL_SAR, CONEX, PCT_EXAMEN, NOTA_EXIM, TRUNCADO, ID_ORDEN, PRUEBA_NIVEL, PCT_NIVEL, MODO_EVAL_PNIVEL, PCT_EX_ESCRITO, PCT_EX_ORAL, FORMACION) VALUES (".$curso.",1,".$subsector.",".$cmbMODO.",".$sub_ob.",".$ip.",".$sar.",".$conEX.",".$txtPCT.",".$txtNEXIM.",".$truncado.",".$newOr .",".$prueba_niv.",".$txtPCTNIV.",".$cmbMODOpruebaNivel.",".$pct_ex_escrito.",".$pct_ex_oral.",1)";
	
		
		  $result =pg_Exec($conn,$qry);
		  if (!$result) {
			 error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
			 exit;
		  }
		
		  if($codSub!=""){
			 $qryC = "select * from sub_propio where cod_subsector=".$subsector." and rdb=".$institucion;
			 $resultC = pg_exec($conn, $qryC);
			 if (!$resultC) {
				error('<b> ERROR :</b>Error al acceder a la BD. (30)'.$qryC);
				exit;
			 }
			 $cant= pg_numrows($resultC);
			 if ($cant =0){
				$qryPpio="insert into sub_propio (cod_subsector, rdb, id_ano, nro_res, fecha_res) values(".$subsector.", ".$institucion.", ".$ano.", ".$codRes.", to_date('" .$txtFecha. "','DD MM YYYY'))";
				$resultPpio=pg_Exec($conn,$qryPpio);
				if (!$resultPpio) {
					error('<b> ERROR :</b>Error al acceder a la BD. (31)'.$qryPpio);
					exit;
				}
			 }
		  }
		
		
		  $qry="SELECT MAX(ID_RAMO) AS ramo, max(id_orden)+1 as orden FROM RAMO WHERE ID_CURSO=".$curso;
		  $result =@pg_Exec($conn,$qry);
		  if (!$result){
			 error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			 exit;
	   	  }
		  $fila = @pg_fetch_array($result,0);	
		  if (!$fila){
			 error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			 exit;
		  }
		  $newID = trim($fila['ramo']);
		
	      $qry="INSERT INTO DICTA (RUT_EMP,ID_RAMO) VALUES ('".$cmbDOC."',".$newID.")";
	      $result =@pg_Exec($conn,$qry);
	      if (!$result) {
		      error('<b> ERROR :</b>Error al acceder a la BD.(41)'.$qry);
		      exit;
	      }
		  
		  
		  
		  

	      if($cmbAYU!=0){
		      $qry="INSERT INTO AYUDA (RUT_EMP,ID_RAMO) VALUES ('".$cmbAYU."',".$newID.")";
		      $result =@pg_Exec($conn,$qry);
		      if (!$result) {
			      error('<b> ERROR :</b>Error al acceder a la BD.(51)'.$qry);
			      exit;
		      }
	      }
		
	      echo "<script>window.location = 'listarRamos.php3?plan=".$_PLAN."'</script>";
    }

    if ($frmModo=="modificar") {
	
	   if(!isset($txtPCT)){$txtPCT=0;}
	   if(!isset($txtNEXIM)){$txtNEXIM=0;}
	   if(!isset($conEX)){$conEX=0;}
	   if(!isset($cmbMODO)){$cmbMODO=0;}
	   if(!isset($sub_ob)){$sub_ob=0;}
	   if(!isset($ip)){$ip=0;}
	   if(!isset($aprox_entero)){$aprox_entero=0;}
	   if(!isset($sar)){$sar=0;}
	   if(!isset($truncado)){$truncado=0;}
	   if(!isset($prueba_niv)){$prueba_niv=0;}
	   if(!isset($txtPCTNIV)){$txtPCTNIV=0;}
	   if(!isset($prueba_niv)){$prueba_niv=0;}
	   if(!isset($cmbMODOpruebaNivel)){$cmbMODOpruebaNivel=0;}
	   if(!isset($pct_escrito)){$pct_escrito=0;}
	   if(!isset($pct_oral)){$pct_oral=0;}
	   if(!isset($prueba_niv)){$prueba_niv=0;}
	   if(!isset($truncado_pnivel)){$truncado_pnivel=0;}
          
  	   if($ip)		$ip=1;		else	$ip=0;
	   if($sar)		$sar=1;		else	$sar=0;
	   if(!$txtPCTNIV) $txtPCTNIV=0;
	   if(!$cmbMODOpruebaNivel) $cmbMODOpruebaNivel=0;
	   if(!$pct_escrito) $pct_escrito=0;
	   if(!$pct_oral) $pct_oral=0;
	   if(!$artis) $artis=0;

       if ($_PERFIL!=17){
		  // $qry="UPDATE ramo SET pct_examen = ".$txtPCT.", nota_exim = ".$txtNEXIM.", conex = ".$conEX.", modo_eval = ".$cmbMODO.", sub_obli =".$sub_ob." , bool_ip = ".$ip.", bool_sar = ".$sar.", truncado = ".$truncado.", prueba_nivel = ".$prueba_niv.", pct_nivel = ".$txtPCTNIV.", modo_eval_pnivel = ".$cmbMODOpruebaNivel.", pct_ex_escrito=".$pct_escrito.", pct_ex_oral=".$pct_oral.", truncado_pnivel = ".$truncado_pnivel." , bool_artis = ".$artis.", porc_examen=".$txtPCTEX."  WHERE (((id_ramo)=".$_RAMO."))";
		   $qry="UPDATE ramo SET aprox_entero= ".$aprox_entero.", pct_examen = ".$txtPCT.", nota_exim = ".$txtNEXIM.", conex = ".$conEX.", modo_eval = ".$cmbMODO.", sub_obli =".$sub_ob." , bool_ip = ".$ip.", bool_sar = ".$sar.", truncado = ".$truncado.", prueba_nivel = ".$prueba_niv.", pct_nivel = ".$txtPCTNIV.", modo_eval_pnivel = ".$cmbMODOpruebaNivel.", pct_ex_escrito=".$pct_escrito.", pct_ex_oral=".$pct_oral.", truncado_pnivel = ".$truncado_pnivel." , bool_artis = ".$artis.", porc_examen=".$txtPCTEX."  WHERE (((id_ramo)=".$_RAMO."))";
		   //echo $qry;
		   //return;
		   $result =@pg_Exec($conn,$qry);
	   }
	   if((!$result) and ($_PERFIL!=17)){
		   error('<b> ERROR :</b>Error al acceder a la BD. (311)'.$qry);
	   }else{
	       $qry2	="SELECT * FROM DICTA WHERE ID_RAMO=".$_RAMO;
	       $result2=@pg_Exec($conn,$qry2);
	       if(pg_numrows($result2)!=0){
	           $qry="UPDATE DICTA SET RUT_EMP='".$cmbDOC."' WHERE ID_RAMO=".$_RAMO;
	       }else{
		       $qry="INSERT INTO DICTA (RUT_EMP, ID_RAMO) VALUES ('".$cmbDOC."',".$_RAMO.")";
		   }    
		   $result =@pg_Exec($conn,$qry);

		   if($cmbAYU!=0){
			   $qry3="SELECT * FROM AYUDA WHERE ID_RAMO=".$_RAMO;
			   $result3=@pg_Exec($conn,$qry3);
			   if(pg_numrows($result3)!=0){
			        $qry="UPDATE AYUDA SET RUT_EMP='".$cmbAYU."' WHERE ID_RAMO=".$_RAMO;
			   }else{
				    $qry="INSERT INTO AYUDA (RUT_EMP,ID_RAMO) VALUES ('".$cmbAYU."',".$_RAMO.")";
			   }   
			   $result3 =@pg_Exec($conn,$qry);
				   		
		   }else{
			   $qry="DELETE FROM AYUDA WHERE ID_RAMO=".$_RAMO;
			   $result =@pg_Exec($conn,$qry);
		   }
		   
		   $sql = "SELECT * FROM examen_semestral WHERE id_ramo=".$_RAMO;
		   $rs_examen = @pg_exec($conn,$sql);
		   
		   $sql ="SELECT id_curso FROM ramo WHERE id_ramo=".$_RAMO;
		   $rs_curso =@pg_exec($conn,$sql);
		   $Curso = @pg_result($rs_curso,0);
		   

		   
		   if(pg_numrows($rs_examen)==0){
			   $largo=count($nombre2);
				for ($i=0;$i<$largo;$i++){ 
					$sql = "INSERT INTO examen_semestral (id_curso,id_ramo,nombre,porc,bool_ap) VALUES (".$Curso.",".$_RAMO.",'".$nombre2[$i]."',".$sigla[$i].",".$aprox_prom.")";
					$rs_semestral = pg_exec($conn,$sql);
				}
		   }else{
			   $largo=count($nombre2);
				for ($i=0;$i<$largo;$i++){ 
					$cod_examen = ${"id_examen".$i};
					echo "<br>".$sql = "UPDATE examen_semestral SET nombre='".$nombre2[$i]."',porc=".$sigla[$i]." WHERE id_curso=".$Curso." AND id_ramo=".$_RAMO." AND id_examen=".$cod_examen."";
					$rs_semestral = pg_exec($conn,$sql);
				}
				echo $sql = "UPDATE ramo SET porc_examen=".$txtPCTEX." WHERE id_ramo=".$fils_Curso['id_ramo']."";
				$rs_ramoEX = @pg_exec($conn,$sql);
		   }		   
	       echo "<script>window.location='seteaRamo.php3?caso=1&ramo=".$_RAMO."&plan=".$_PLAN."'</script>";
       }
   }	   
   



   if ($frmModo=="eliminar") {
 	   $qry1="DELETE FROM AYUDA WHERE ID_RAMO=".$_RAMO;
	   $result1 =@pg_Exec($conn,$qry1);
	   if (!$result1) {
		    error('<b> ERROR :</b>Error al eliminar.(510)'.$qry1);
	   }
	   $qry2="DELETE FROM DICTA WHERE ID_RAMO=".$_RAMO;
	   $result2 =@pg_Exec($conn,$qry2);
	   if (!$result2) {
		    error('<b> ERROR :</b>Error al eliminar.(511)'.$qry2);
	   }
	   $qry2="DELETE FROM tiene$nro_ano WHERE ID_RAMO=".$_RAMO;
	   $result2 =@pg_Exec($conn,$qry2);
	   if (!$result2) {
		    error('<b> ERROR :</b>Error al eliminar.(511)'.$qry2);
	   }
       $qry="DELETE FROM RAMO WHERE ID_RAMO=".$_RAMO;
	   $result =@pg_Exec($conn,$qry);
	   if (!$result) {
		   error('<b> ERROR :</b>Error al eliminar.(512)'.$qry);
	   }else{
		   echo "<script>window.location = 'listarRamos.php3?plan=".$_PLAN."'</script>";
	   }
  }
?>