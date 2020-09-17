<?php require('../../../../util/header.inc');



/*
foreach($_POST as $nombre_campo => $valor)
   { 
   $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	echo "asignacion=$asignacion<br>";
   } */


	/*************VARIABLES HOJA DE VIDA**************/

	if($tipo_hoja==1){
	$c_curso = $_GET['c_curso'];
	$c_ano = $_GET['c_ano'];
	}
	
	/***************************/
	
	
	$desde=	$_DESDE;
	$anotacion = $_ANOTACION;
	$frmModo	=$_FRMMODO;
	$institucion = $_INSTIT;
	$emp= $_POST["tipo_responsable"];
	if($_POST["txtFECHA2"]==null){
		$txtFECHA=$_POST["txtFECHA"];
		}
	if($_POST["txtFECHA"]==null){
		$txtFECHA=$_POST["txtFECHA2"];
	}
	if($_POST["txtOBS2"]==null){
		$txtOBS=$_POST["txtOBS"];
	}
	if($_POST["txtOBS"]==null){
		$txtOBS=$_POST["txtOBS2"];
	}
	
	//$anotacion= $_POST["tipo_anotacion"];
	//SI ES INSPECTOR COLOCA RUT DE INSPECTOR O SI NO RUT DE EMPLEADO
	/*if ($_PERFIL == 19){
	    $emp = $cmb_empleado;
	}else{	
	
		if($emp==NULL){
			$emp = $_NOMBREUSUARIO;
		}
    }**/
	if($emp!=NULL){
		$emp= $_POST["tipo_responsable"];
	}else{
		$emp = $_NOMBREUSUARIO;
	}
	
	if ($emp==0 or $emp==NULL){
	    $emp = $_POST["tipo_responsable2"];	
	}
	
	   
		if (($frmModo=="modificar") AND ($caso=="1")){
				
			// aqui actualizamos la anotacion
			   
			
			   $dd = substr($txtFECHA,0,2);
			   $mm = substr($txtFECHA,3,2);
			   $aa = substr($txtFECHA,6,4);
			   $txtFECHA = "$aa$mm$dd";
			
			
			
			if ($rdTIPO==1){  // CONDUCTA		   
			   
				 $actualizar = "update anotacion set tipo = '".trim($rdTIPO)."', fecha = '".$txtFECHA."', observacion = '".trim($txtOBS)."', rut_alumno = '".trim($rut)."', rut_emp = '".trim($emp)."', tipo_conducta = '".$tipo_conducta."', id_periodo = '".trim($cmb_periodos)."' where id_anotacion = '".trim($_ANOTACION)."'"; 
				 $result = pg_Exec($conn,$actualizar);			 
			}
			
			if ($rdTIPO==2){  // ATRASO
			   
				 $actualizar = "update anotacion set tipo = '".trim($rdTIPO)."', fecha = '".$txtFECHA."',  hora = '".$txtHORAS."', observacion = '".trim($txtOBS)."', rut_alumno = '".trim($rut)."', rut_emp = '".trim($emp)."', tipo_conducta = '".$tipo_conducta."', id_periodo = '".trim($cmb_periodos)."' where id_anotacion = '".trim($_ANOTACION)."'"; 
				 $result = pg_Exec($conn,$actualizar);			 
			}
			
			if ($rdTIPO==4){  // ENFERMERÍA
			   
				 $actualizar = "update anotacion set tipo = '".trim($rdTIPO)."', fecha = '".$txtFECHA."',  hora = '".$txtHORAS."', causal = '".trim($txtCAUSAL)."', tratamiento = '".trim($txtTRA)."',  observacion = '".trim($txtOBS)."', rut_alumno = '".trim($rut)."', rut_emp = '".trim($emp)."', tipo_conducta = '".$tipo_conducta."', id_periodo = '".trim($cmb_periodos)."' where id_anotacion = '".trim($_ANOTACION)."'"; 
				 $result = pg_Exec($conn,$actualizar);			 
			}			
			
			$_FRMMODO = "mostrar";
			echo "<script>window.location = '../../ano/curso/alumno/alumno.php3?sw2=1&pesta=4'</script>";
			exit();
	    }	
		if($frmModo=="modificar" && $caso==2){
			$sql = "UPDATE anotacion SET id_periodo = '".trim($cmb_periodos)."',observacion = '".trim($txtOBS)."', fecha = '".$txtFECHA."', sigla='".$_POST['sigla_subsector']."',codigo_tipo_anotacion='".$_POST['tipo_anotacion']."'  WHERE id_anotacion='".trim($_ANOTACION)."'"; 
			$Rs_anotacion = @pg_exec($conn,$sql);
			
		}	 
	
	    
	if ($frmModo=="ingresar") {
	            
				
				if ($oculto=="1"){
				        for ($iii=0; $iii < 10; $iii++){
							$txtFechadesde       = $_POST['txtFechadesde'.$iii];
							$cmb_periodos        = $_POST['cmb_periodos'.$iii];
							$sigla_subsector     = $_POST['sigla_subsector'.$iii];
							$tipo_responsable    = $_POST['tipo_responsable'.$iii];
							$tipo_anotacion      = $_POST['tipo_anotacion'.$iii];
							$detalle_anotaciones = $_POST['detalle_anotaciones'.$iii];
							$observaciones       = $_POST['observaciones'.$iii];	
							/// para el proximo ID de curso
							$qry="SELECT MAX(ID_ANOTACION) AS CANT FROM ANOTACION";
							$result =pg_Exec($conn,$qry);
							$fila = pg_fetch_array($result,0);	
							$newID =  $fila['cant'];
							$newID = $newID + 1 ;
							
							if ($detalle_anotaciones!="0"){
							      $qry="INSERT INTO ANOTACION (ID_ANOTACION, FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, id_periodo, sigla, codigo_tipo_anotacion, codigo_anotacion, rdb) VALUES	('".$newID."','".$txtFechadesde."','".trim($observaciones)."','".trim($rut)."','".trim($tipo_responsable)."','" .$cmb_periodos."' , '".$sigla_subsector."', '".$tipo_anotacion."', '".$detalle_anotaciones."', '".$institucion."' )";
							      $result =pg_Exec($conn,$qry);
								
							}	  
						}						
							   
				        /// fin ingreso masivo
				}else{	
							
				      				
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
						$fecha;
										

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
																
								   $qry="INSERT INTO ANOTACION (ID_ANOTACION, FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, id_periodo, sigla, codigo_tipo_anotacion, codigo_anotacion, rdb) VALUES	('".$newID."','".fEs2En($txtFECHA)."','".trim($txtOBS)."','".trim($rut)."','".trim($tipo_responsable)."','" .$cmb_periodos."' , '".$sigla_subsector."', '".$tipo_anotacion."', '".$detalle_anotaciones."', '".$institucion."' )";
								   $result =pg_Exec($conn,$qry);
								   if (!$result) {
										error('<b> ERROR :</b>Error al acceder a la BD. (333)</B>'.$qry);
										exit;
								   } 
								  
							 }	
							 
							 
							 
							 
							 
							 
								
						if($rdTIPO==2){//	ATRASO
							$qry="INSERT INTO ANOTACION (ID_ANOTACION, TIPO, FECHA, OBSERVACION, HORA, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",".trim($rdTIPO).",'".fEs2En($txtFECHA)."','".trim($txtOBS)."','".$txtHORAS."','".trim($rut)."','".trim($emp)."',".$cmb_periodos.")";
							$qry;
							return;
							
							/*$result =@pg_Exec($conn,$qry);
							if (!$result) {
								error('<b> ERROR :</b>Error al acceder a la BD. (4)</B>'.$qry);
								exit;
							}*/
						};
						if($rdTIPO==3){//	INASISTENCIA
							$qry="INSERT INTO ANOTACION (ID_ANOTACION, TIPO, FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",".trim($rdTIPO).",'".fEs2En($txtFECHA)."','".trim($txtOBS)."','".trim($rut)."','".trim($emp)."',".$cmb_periodos.")";
							return;
							
							$result =@pg_Exec($conn,$qry);
							if (!$result) {
								error('<b> ERROR :</b>Error al acceder a la BD. (5)</B>'.$qry);
								exit;
							}
						};
						
						
						if($rdTIPO==4){//	ENFERMERIA
				
						   $dd = substr($txtFECHA2,0,2);
						   $mm = substr($txtFECHA2,3,2);
						   $aa = substr($txtFECHA2,6,4);
						   $txtFECHA = "$aa-$mm-$dd";			   
							if($txtHORAS==""){
									$qry="INSERT INTO ANOTACION (ID_ANOTACION, TIPO, FECHA, OBSERVACION, CAUSAL, TRATAMIENTO, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",".trim($rdTIPO).",'".$txtFECHA2."','".trim($txtOBS2)."','".trim($txtCAUSAL)."','".trim($txtTRA)."','".trim($rut)."','".trim($emp)."',".$cmb_periodos.")";				
							}else{		   	   						
									$qry="INSERT INTO ANOTACION (ID_ANOTACION, TIPO, FECHA, OBSERVACION, HORA, CAUSAL, TRATAMIENTO, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",".trim($rdTIPO).",'".$txtFECHA2."','".trim($txtOBS2)."','".trim($txtHORAS)."','".trim($txtCAUSAL)."','".trim($txtTRA)."','".trim($rut)."','".trim($emp)."',".$cmb_periodos.")";
							}
						 return;
							$result =@pg_Exec($conn,$qry);
							
							/*if (!$result) {
								error('<b> ERROR :</b>Error al acceder a la BD. (6)</B>'.$qry);
								exit;
							}*/
						};
						if($rdTIPO==""){//SIN CONCEPTO
						
						$qry="INSERT INTO ANOTACION (ID_ANOTACION, FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",'".fEs2En($txtFECHA)."','".trim($txtOBS)."','".trim($rut)."','".trim($emp)."',".$cmb_periodos.")";
						$result =@pg_Exec($conn,$qry);
						/*if (!$result) {
								error('<b> ERROR :</b>Error al acceder a la BD. (5)</B>'.$qry);
								exit;
							}*/
						};
					
					
					} 
					
				}		
				
				
		}//fin if modo "ingresar"
		
		
		if ($frmModo=="eliminar"){  
			$sql="delete from anotacion where id_anotacion=".$anotacion;
			$result =@pg_Exec($conn,$sql);
			if (!$result) {
					error('<b> ERROR :</b>Error al acceder a la BD. (6)</B>'.$qry);
					exit;
				}
			/*if($_PERFIL==19)
			{
				echo "<script>window.location = '../../ano/matricula/matricula.php3'</script>";
			}*/
		}
	
	
		if ($desde!="alumno"){
			echo "<script>window.location = 'listarAnotacion.php3'</script>";
		}else
		if($_PERFIL==19)
		{
			$qry1="select max(id_ano) from matricula where rut_alumno = '$rut'";
			$res1=pg_Exec($conn,$qry1);
			$fila1=pg_fetch_array($res1);
			$max=$fila1['max'];
			
			$qry2="select id_curso from matricula where id_ano = '$max' and rut_alumno = '$rut'";
			$res2=pg_Exec($conn,$qry2);
			$fila2=pg_fetch_array($res2);
			$curso_act = $fila2['id_curso'];
		   echo "<script>window.location = '../../ano/curso/alumno/alumno.php3?pesta=4&curso_act=$curso_act'</script>";			
		}else
		{
			echo "<script>window.location = '../../ano/curso/alumno/alumno.php3?sw2=1&pesta=4&tipo_hoja=$tipo_hoja&c_alumno=$rut&c_curso=$c_curso&c_ano=$c_ano'</script>";
		}


?> 