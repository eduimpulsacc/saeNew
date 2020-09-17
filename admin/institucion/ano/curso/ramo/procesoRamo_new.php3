<?php require('../../../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$institucion	=$_INSTIT;
	
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
		  
	if($truncado) $truncado=1;	else	$truncado=0;
		  

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
		       if ($seleccionmultiple==1){
			        
			   
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
				   				   
				    while ($i <= $cant_sub){
				       $codsub = "codsub".$i;
					   $codsub = $$codsub;
					   
					   if ($codsub > 0){					   
					   
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

		
    	                  $qry="INSERT INTO RAMO (ID_CURSO, TIPO_RAMO, COD_SUBSECTOR, MODO_EVAL, SUB_OBLI, BOOL_IP, BOOL_SAR, CONEX, PCT_EXAMEN, NOTA_EXIM, TRUNCADO, ID_ORDEN, PRUEBA_NIVEL, PCT_NIVEL, MODO_EVAL_PNIVEL, PCT_EX_ESCRITO, PCT_EX_ORAL) VALUES (".$curso.",1,".$codsub.",".$cmbMODO.",".$sub_ob.",".$ip.",".$sar.",".$conEX.",".$txtPCT.",".$txtNEXIM.",".$truncado.",".$newOr .",".$prueba_niv.",".$txtPCTNIV.",".$cmbMODOpruebaNivel.",".$pct_ex_escrito.",".$pct_ex_oral.")";
			              $result =pg_Exec($conn,$qry);
		                  if (!$result) {
			                  error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
			                  exit;
		                  }
		
		                  if($codsub!=""){
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
					       }	   
		                   if (!$result) {
			                   error('<b> ERROR :</b>Error al acceder a la BD.(51)'.$qry);
			                   exit;
		                   }
					   }   
	                   $i++;
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
		  
		  
		  if($cmbSUB!=""){
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
    	  $qry="INSERT INTO RAMO (ID_CURSO, TIPO_RAMO, COD_SUBSECTOR, MODO_EVAL, SUB_OBLI, BOOL_IP, BOOL_SAR, CONEX, PCT_EXAMEN, NOTA_EXIM, TRUNCADO, ID_ORDEN, PRUEBA_NIVEL, PCT_NIVEL, MODO_EVAL_PNIVEL, PCT_EX_ESCRITO, PCT_EX_ORAL) VALUES (".$curso.",1,".$subsector.",".$cmbMODO.",".$sub_ob.",".$ip.",".$sar.",".$conEX.",".$txtPCT.",".$txtNEXIM.",".$truncado.",".$newOr .",".$prueba_niv.",".$txtPCTNIV.",".$cmbMODOpruebaNivel.",".$pct_ex_escrito.",".$pct_ex_oral.")";
	
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
	   if(!isset($sar)){$sar=0;}
	   if(!isset($truncado)){$truncado=0;}
	   if(!isset($prueba_niv)){$prueba_niv=0;}
	   if(!isset($txtPCTNIV)){$txtPCTNIV=0;}
	   if(!isset($prueba_niv)){$prueba_niv=0;}
	   if(!isset($cmbMODOpruebaNivel)){$cmbMODOpruebaNivel=0;}
	   if(!isset($pct_escrito)){$pct_escrito=0;}
	   if(!isset($pct_oral)){$pct_oral=0;}
	   if(!isset($prueba_niv)){$prueba_niv=0;}
          
  	   if($ip)		$ip=1;		else	$ip=0;
	   if($sar)		$sar=1;		else	$sar=0;
	   if(!$txtPCTNIV) $txtPCTNIV=0;
	   if(!$cmbMODOpruebaNivel) $cmbMODOpruebaNivel=0;
	   if(!$pct_escrito) $pct_escrito=0;
	   if(!$pct_oral) $pct_oral=0;

       if ($_PERFIL!=17){
		   $qry="UPDATE ramo SET pct_examen = ".$txtPCT.", nota_exim = ".$txtNEXIM.", conex = ".$conEX.", modo_eval = ".$cmbMODO.", sub_obli =".$sub_ob." , bool_ip = ".$ip.", bool_sar = ".$sar.", truncado = ".$truncado.", prueba_nivel = ".$prueba_niv.", pct_nivel = ".$txtPCTNIV.", modo_eval_pnivel = ".$cmbMODOpruebaNivel.", pct_ex_escrito=".$pct_escrito.", pct_ex_oral=".$pct_oral."  WHERE (((id_ramo)=".$_RAMO."))";
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
		       $result =@pg_Exec($conn,$qry);

		       if($cmbAYU!=0){
			       $qry3="SELECT * FROM AYUDA WHERE ID_RAMO=".$_RAMO;
			       $result3=@pg_Exec($conn,$qry3);
			       if(pg_numrows($result3)!=0){
			            $qry="UPDATE AYUDA SET RUT_EMP='".$cmbAYU."' WHERE ID_RAMO=".$_RAMO;
				   }else{
					    $qry="INSERT INTO AYUDA (RUT_EMP,ID_RAMO) VALUES ('".$cmbAYU."',".$_RAMO.")";
				        $result3 =@pg_Exec($conn,$qry);
				   }		
			  }else{
				  $qry="DELETE FROM AYUDA WHERE ID_RAMO=".$_RAMO;
				  $result =@pg_Exec($conn,$qry);
		      }
	       }
	       echo "</script>window.location='seteaRamo.php3?caso=1&ramo=".$_RAMO."&plan=".$_PLAN."'</script>";
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