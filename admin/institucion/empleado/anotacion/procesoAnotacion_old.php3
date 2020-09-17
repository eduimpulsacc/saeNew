<?php require('../../../../util/header.inc');?>
<?php
	
	
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
	 $empleado		=$_EMPLEADO;
	if ($_PERFIL == 19){
	    $emp = $cmb_empleado;
	}else{	
	
		if($emp==NULL){
			$emp = $_NOMBREUSUARIO;
		}
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
	
	
    
	if ($frmModo=="ingresar") {
	           
				
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
					
					if($rdTIPO==1){//	CONDUCTA
						//echo $emp;
					 	$qry="INSERT INTO ANOTACION (ID_ANOTACION, TIPO, FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, tipo_conducta, id_periodo) VALUES	(".$newID.",".trim($rdTIPO).",'".fEs2En($txtFECHA)."','".trim($txtOBS)."','".trim($rut)."','".trim($emp)."',".$tipo_conducta."," .$cmb_periodos.")";
						$result =pg_Exec($conn,$qry);
						/*if (!$result) {
							error('<b> ERROR :</b>Error al acceder a la BD. (3)</B>'.$qry);
							exit;
						}*/
					};
					if($rdTIPO==2){//	ATRASO
						$qry="INSERT INTO ANOTACION (ID_ANOTACION, TIPO, FECHA, OBSERVACION, HORA, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",".trim($rdTIPO).",'".fEs2En($txtFECHA)."','".trim($txtOBS)."','".$txtHORAS."','".trim($rut)."','".trim($empleado)."',".$cmb_periodos.")";
						$result =@pg_Exec($conn,$qry);
						/*if (!$result) {
							error('<b> ERROR :</b>Error al acceder a la BD. (4)</B>'.$qry);
							exit;
						}*/
						
					};
					if($rdTIPO==3){//	INASISTENCIA
						$qry="INSERT INTO ANOTACION (ID_ANOTACION, TIPO, FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",".trim($rdTIPO).",'".fEs2En($txtFECHA)."','".trim($txtOBS)."','".trim($rut)."','".trim($emp)."',".$cmb_periodos.")";
						$result =@pg_Exec($conn,$qry);
						/*if (!$result) {
							error('<b> ERROR :</b>Error al acceder a la BD. (5)</B>'.$qry);
							exit;
						}*/
					};
					if($rdTIPO==4){//	ENFERMERIA
					
			   $dd = substr($txtFECHA,0,2);
			   $mm = substr($txtFECHA,3,2);
			   $aa = substr($txtFECHA,6,4);
			   $txtFECHA = "$aa-$mm-$dd";			   
				if($txtHORAS==""){
						$qry="INSERT INTO ANOTACION (ID_ANOTACION, TIPO, FECHA, OBSERVACION, CAUSAL, TRATAMIENTO, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",".trim($rdTIPO).",'".$txtFECHA."','".trim($txtOBS)."','".trim($txtCAUSAL)."','".trim($txtTRA)."','".trim($rut)."','".trim($emp)."',".$cmb_periodos.")";				
				}else{		   	   						
						$qry="INSERT INTO ANOTACION (ID_ANOTACION, TIPO, FECHA, OBSERVACION, HORA, CAUSAL, TRATAMIENTO, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",".trim($rdTIPO).",'".$txtFECHA."','".trim($txtOBS)."','".trim($txtHORAS)."','".trim($txtCAUSAL)."','".trim($txtTRA)."','".trim($rut)."','".trim($emp)."',".$cmb_periodos.")";
				}
							
						$result =@pg_Exec($conn,$qry);
						if (!$result) {
							error('<b> ERROR :</b>Error al acceder a la BD. (6)</B>'.$qry);
							exit;
						}
					};
					if($rdTIPO==""){//	SIN CONCEPTO
						$qry="INSERT INTO ANOTACION (ID_ANOTACION, FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, ID_PERIODO) VALUES	(".$newID.",'".fEs2En($txtFECHA)."','".trim($txtOBS)."','".trim($rut)."','".trim($emp)."',".$cmb_periodos.")";
						$result =@pg_Exec($conn,$qry);
						/*if (!$result) {
							error('<b> ERROR :</b>Error al acceder a la BD. (5)</B>'.$qry);
							exit;
						}*/
					};
			    
				
				} 	
				
				
		}//fin if modo "ingresar"
		
		
		if ($mod=="1"){  
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
			 echo "<script>window.location = '../../ano/curso/alumno/alumno.php3?sw2=1&pesta=4&tipo_hoja=$tipo_hoja&c_alumno=$rut&c_curso=$c_curso&c_ano=$c_ano'</script>" ;
		}

?> 