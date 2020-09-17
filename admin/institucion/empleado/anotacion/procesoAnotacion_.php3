<?php require('../../../../util/header.inc');?>
<?php
	$desde=	$_DESDE;
	$anotacion = $_ANOTACION;
	$frmModo	=$_FRMMODO;
	$institucion = $_INSTIT;
	echo $institucion;
	return;
	
	
	if ($frmModo=="modificar"){
	    /*echo "anotacion: $anotacion <br>";
		echo "txtFECHA: $txtFECHA <br>";
		echo "txtOBS: $txtOBS <br>";
		echo "rut: $rut <br>";
		echo "emp: $emp <br>";
		echo "cmb_periodos: $cmb_periodos <br>";
		echo "sigla_subsector: $sigla_subsector <br>";
		echo "tipo_anotacion: $tipo_anotacion <br>";
		echo "detalle_anotaciones: $detalle_anotaciones <br>";
		echo "institucion: $institucion <br>";
		
		exit();	*/
		
		$dd = substr($txtFECHA,0,2);
		$mm = substr($txtFECHA,3,2);
		$aa = substr($txtFECHA,6,4);
		
		$txtFECHA = "$aa$mm$dd";
		
		if ($txtOBS==NULL){
		   $txtOBS=" ";
		}
		
				
		$qry="UPDATE anotacion set fecha = '$txtFECHA', observacion = '$txtOBS', rut_alumno = '$rut', rut_emp = '$emp', id_periodo = '$cmb_periodos', sigla = '$sigla_subsector', codigo_tipo_anotacion = '$tipo_anotacion', codigo_anotacion = '$detalle_anotaciones', rdb = '$institucion' where id_anotacion = '$anotacion'"; 
				 								    					
		//$qry="INSERT INTO ANOTACION (ID_ANOTACION, FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, id_periodo, sigla, codigo_tipo_anotacion, codigo_anotacion, rdb) VALUES	(".$newID.",'".fEs2En($txtFECHA)."','".trim($txtOBS)."','".trim($rut)."','".trim($emp)."'," .$cmb_periodos." , ".$sigla_subsector.", ".$tipo_anotacion.", ".$detalle_anotaciones.", ".$institucion." )";
		$result =pg_Exec($conn,$qry);
		if (!$result) {
		     error('<b> ERROR :</b>Error al acceder a la BD. (3)</B>'.$qry);
		     exit;
		}
		$_FRMMODO = "mostrar";		
		
		
	}	
	
	

   
	if ($frmModo=="ingresar") {
	            /*   ANTIGUO CODIGO DE INGRESO   
			
				$qry="SELECT MAX(ID_ANOTACION) AS CANT FROM ANOTACION";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
				}else{
					$fila = @pg_fetch_array($result,0);	
					if (!$fila){
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$qry);
						exit();
					}
					$newID =  $fila['cant'];
					$newID = $newID + 1 ;
					if($rdTIPO==1){//	CONDUCTA
						$qry="INSERT INTO ANOTACION (ID_ANOTACION, TIPO, FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, tipo_conducta, id_periodo) VALUES	(".$newID.",".trim($rdTIPO).",'".fEs2En($txtFECHA)."','".trim($txtOBS)."','".trim($rut)."','".trim($emp)."',".$tipo_conducta."," .$cmb_periodos.")";
						$result =pg_Exec($conn,$qry);
						if (!$result) {
							error('<b> ERROR :</b>Error al acceder a la BD. (3)</B>'.$qry);
							exit;
						}
					};
					if($rdTIPO==2){//	ATRASO
						$qry="INSERT INTO ANOTACION (ID_ANOTACION, TIPO, FECHA, OBSERVACION, HORA, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",".trim($rdTIPO).",'".fEs2En($txtFECHA)."','".trim($txtOBS)."','".$txtHORAS."','".trim($rut)."','".trim($emp)."',".$cmb_periodos.")";
						$result =@pg_Exec($conn,$qry);
						if (!$result) {
							error('<b> ERROR :</b>Error al acceder a la BD. (4)</B>'.$qry);
							exit;
						}
					};
					if($rdTIPO==3){//	INASISTENCIA
						$qry="INSERT INTO ANOTACION (ID_ANOTACION, TIPO, FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",".trim($rdTIPO).",'".fEs2En($txtFECHA)."','".trim($txtOBS)."','".trim($rut)."','".trim($emp)."',".$cmb_periodos.")";
						$result =@pg_Exec($conn,$qry);
						if (!$result) {
							error('<b> ERROR :</b>Error al acceder a la BD. (5)</B>'.$qry);
							exit;
						}
					};
					if($rdTIPO==4){//	ENFERMERIA
						$qry="INSERT INTO ANOTACION (ID_ANOTACION, TIPO, FECHA, OBSERVACION, HORA, CAUSAL, TRATAMIENTO, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",".trim($rdTIPO).",'".fEs2En($txtFECHA)."','".trim($txtOBS)."','".trim($txtHORAS)."','".trim($txtCAUSAL)."','".trim($txtTRA)."','".trim($rut)."','".trim($emp)."',".$cmb_periodos.")";
						$result =@pg_Exec($conn,$qry);
						if (!$result) {
							error('<b> ERROR :</b>Error al acceder a la BD. (6)</B>'.$qry);
							exit;
						}
					};
					if($rdTIPO==""){//	SIN CONCEPTO
						$qry="INSERT INTO ANOTACION (ID_ANOTACION, FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",'".fEs2En($txtFECHA)."','".trim($txtOBS)."','".trim($rut)."','".trim($emp)."',".$cmb_periodos.")";
						$result =@pg_Exec($conn,$qry);
						if (!$result) {
							error('<b> ERROR :</b>Error al acceder a la BD. (5)</B>'.$qry);
							exit;
						}
					};
			    }   */
				
				
				$qry="SELECT MAX(ID_ANOTACION) AS CANT FROM ANOTACION";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
				}else{
					$fila = @pg_fetch_array($result,0);	
					if (!$fila){
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$qry);
						exit();
					}
					$newID =  $fila['cant'];
					$newID = $newID + 1 ;
					
					
					
					  if ($por==1){									   
						   	// buscar codigos y luego grabara
							$q1 = "select * from sigla_subsectoraprendisaje where sigla = '".trim($sigla2)."' and rdb = '".trim($institucion)."'";
							$r1 = pg_Exec($conn,$q1);
							$n1 = pg_numrows($r1);
						if ($n1==0){	?>
								<script language="javascript">
									alert("Error, Sigla de subsector aprendizaje no existe");
									window.location = 'anotacion.php3'
								</script>  
							<?	
							}else{
							    $f1 = pg_fetch_array($r1,0);
								$sigla_subsector = $f1['id_sigla'];
								
								// busco el codigo								
								$q2 = "select * from detalle_anotaciones, tipos_anotacion where  detalle_anotaciones.codigo = '".trim($codigo2)."' and  detalle_anotaciones.id_tipo = tipos_anotacion.id_tipo and rdb = '".trim($institucion)."'";
								$r2 = pg_Exec($conn,$q2);
								$n2 = pg_numrows($r2);
								if ($n2==0){	?>
								<script language="javascript">
									alert("Error, código no existe en anotaciones");
									window.location = 'anotacion.php3'
								</script>  								
								<?
								}else{
								    $f2 = pg_fetch_array($r2,0);
									$detalle_anotaciones = $codigo2;
									$tipo_anotacion      = $f2['id_tipo'];
																										
									
									// inserto el registro con los datos tomados
									$qry="INSERT INTO ANOTACION (ID_ANOTACION, FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, id_periodo, sigla, codigo_tipo_anotacion, codigo_anotacion, rdb) VALUES	('".$newID."','".fEs2En($txtFECHA2)."','".trim($txtOBS2)."','".trim($rut)."','".trim($emp)."','" .$cmb_periodos2."' , '".$sigla_subsector."', '".$tipo_anotacion."', '".$detalle_anotaciones."', '".$institucion."' )";
									$result =pg_Exec($conn,$qry);
									if (!$result) {
										error('<b> ERROR :</b>Error al acceder a la BD. (3)</B>'.$qry);
										exit;
									}
								}
							}							
							
				      }			
							
					
					
					 if ($por==2){					 								    					
						    $qry="INSERT INTO ANOTACION (ID_ANOTACION, FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, id_periodo, sigla, codigo_tipo_anotacion, codigo_anotacion, rdb) VALUES	('".$newID."','".fEs2En($txtFECHA)."','".trim($txtOBS)."','".trim($rut)."','".trim($emp)."','" .$cmb_periodos."' , '".$sigla_subsector."', '".$tipo_anotacion."', '".$detalle_anotaciones."', '".$institucion."' )";
						    $result =pg_Exec($conn,$qry);
						    if (!$result) {
							     error('<b> ERROR :</b>Error al acceder a la BD. (3)</B>'.$qry);
							     exit;
						    }  	  
					 }
			}	
				
				
				
		}//fin if modo "ingresar"
		
		
		if (trim($frmModo)=="eliminar"){  
			$sql="delete from anotacion where id_anotacion=".$anotacion;
			$result =@pg_Exec($conn,$sql);
				if (!$result) {
					error('<b> ERROR :</b>Error al acceder a la BD. (6)</B>'.$qry);
					exit;
				}
		}
		

		if ($desde!="alumno"){
			echo "<script>window.location = 'listarAnotacion.php3'</script>";
		}else{
		    echo "<script>window.location = '../../ano/curso/alumno/alumno.php3?sw2=1&pesta=4'</script>";
		}
	//}
?> 