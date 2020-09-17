<?

/*************VARIABLES HOJA DE VIDA**************/
	
	$c_curso = $_GET['c_curso'];
	$c_ano = $_GET['c_ano'];
	
	/***************************/
		
	$desde=	$_DESDE;
	$anotacion = $_ANOTACION1;
	
	if($_GET['frmModo']==NULL){
	
	$frmModo	=$_FRMMODO;
	
	}else{$frmModo	=$_GET['frmModo'];}
	
	
	$institucion = $_INSTIT;
	$rut= $_ALUMNO;
	$emp = $_GET['tipo_responsable2'];
	
	if($emp==NULL){$emp=$_USUARIO;}
	$cmb_periodos2 = $_GET['cmb_periodos2'];
	
	if($_GET['cmb_periodos']!=NULL){
	$cmb_periodos = $_GET['cmb_periodos'];}else{$cmb_periodos = $_POST['cmb_periodos'];}
	
	$por = $_GET['por'];
	$oculto = $_GET['oculto']; 
	$rdTIPO = $_POST['rdTIPO'];
	$elimina = $_GET['elimina'];
	$sigla2 = $_POST['sigla2'];
	$codigo2 = $_POST['codigo2'];
			
	
			if($_POST['txtHORAS']==NULL){
			$txtHORAS = $_POST['txtHORAS2'];
				}
				
			if($_POST["txtFECHA2"]==NULL){
				$txtFECHA=$_POST["txtFECHA"];
				}
				
			if($_POST["txtFECHA"]==NULL){
				$txtFECHA=$_POST["txtFECHA2"];
			}
			
			if($_POST["txtOBS2"]==NULL){
				$txtOBS=$_POST["txtOBS"];
			}
			
			if($_POST["txtOBS"]==NULL){
				$txtOBS=$_POST["txtOBS2"];
			}
	

	   
if (($frmModo=="modificar") AND ($caso=="1")){
		
				
			// aqui actualizamos la anotacion
			   
			
			   $dd = substr($txtFECHA,0,2);
			   $mm = substr($txtFECHA,3,2);
			   $aa = substr($txtFECHA,6,4);
			   $txtFECHA = "$aa-$mm-$dd";
			
			
			
if ($rdTIPO==1){  // CONDUCTA		   
			   
				 $actualizar = "update anotacion set tipo = '".trim($rdTIPO)."', fecha = '".$txtFECHA."', observacion = '".trim($txtOBS)."', rut_alumno = '".trim($rut)."', rut_emp = '".trim($emp)."', tipo_conducta = '".$tipo_conducta."', id_periodo = '".trim($cmb_periodos)."' where id_anotacion = '".trim($_ANOTACION1)."'"; 
				 $result = pg_Exec($conn,$actualizar);	
				 		 
			}
			
			if ($rdTIPO==2){  // ATRASO
			   
				echo $actualizar = "update anotacion set tipo = '".trim($rdTIPO)."', fecha = '".$txtFECHA."',  hora = '".$txtHORAS."', observacion = '".trim($txtOBS)."', rut_alumno = '".trim($rut)."', rut_emp = '".trim($emp)."', tipo_conducta = '".$tipo_conducta."', id_periodo = '".trim($cmb_periodos)."' where id_anotacion = '".trim($_ANOTACION1)."'"; 
				 $result = pg_Exec($conn,$actualizar);	
			
				 	 
			}
			
			if ($rdTIPO==4){  // ENFERMERÍA
			   

$actualizar = "update anotacion set tipo = '".trim($rdTIPO)."', fecha = '".$txtFECHA."',  hora = '".$txtHORAS."',  observacion = '".trim($txtOBS)."', rut_alumno = '".trim($rut)."', rut_emp = '".trim($emp)."', id_periodo = '".trim($cmb_periodos)."' where id_anotacion = '".trim($_ANOTACION1)."'";
				 $result = pg_Exec($conn,$actualizar);	
				 		 
			}			
			
			$_FRMMODO = "mostrar";
			echo "<script>window.location = 'seteaAnotacion.php3?caso=1&activo=0&c_curso=$_CURSO&c_ano=$_ANO&alumno=$_ALUMNO'</script>";
			exit();
	    }	
		
		
		if($frmModo=="modificar" && $caso==2){
           $sql = "UPDATE anotacion SET id_periodo = '".trim($cmb_periodos)."',observacion = 
		   '".trim($txtOBS)."', fecha = '".$txtFECHA."',
		   sigla='".$_POST['sigla_subsector']."',codigo_tipo_anotacion='".$_POST['tipo_anotacion']."', codigo_anotacion='".$_POST['detalle_anotaciones']."'  WHERE id_anotacion='".trim($_ANOTACION1)."'"; 
			$Rs_anotacion = @pg_exec($conn,$sql);
			
		
			
			
			
		}	 
	


?>