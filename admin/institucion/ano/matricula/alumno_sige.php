<?php
require_once("../../../clases/soap/lib/nusoap.php");
//print_r($_POST);


$rut_alumno=$txtRUT;
$dig_rut=$txtDIGRUT;
$nombre_alumno=$txtNOMBRE; 
$ape_pat = $txtAPEPAT;
$ape_mat = $txtAPEMAT; 
  
  

		//$oSoapClient1 = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/SemillaServiciosSoapPort.wsdl',true);
		$oSoapClient1 = new soapclient('http://w7app.mineduc.cl/WsApiAutorizacion/wsdl/SemillaServiciosSoapPort.wsdl',true);				
		// Se pudo conectar?
		$err = $oSoapClient1->getError();
		if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} 
		
		/*************************SOLICITO VALOR SEMILLA************************************************/	

		
		/*$StrXml1 = '<EntradaSemillaServicios xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd"
		 xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
			<ClienteId>25</ClienteId>
			<ConvenioId>31</ConvenioId>
			<ConvenioToken>TESTCOLEGIOINTERACTIVO</ConvenioToken>
		</EntradaSemillaServicios>'; */

	$StrXml1 = '<EntradaSemillaServicios xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd"
		 xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
			<ClienteId>$_CLIENTEID</ClienteId>
			<ConvenioId>$_CONVENIOID</ConvenioId>
			<ConvenioToken>$_TOKEN</ConvenioToken>
		</EntradaSemillaServicios>';
						
		$resultado1 = $oSoapClient1->call('getSemillaServicios',$StrXml1,'http://wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd',
		'http://wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd/getSemillaServicios');
		
		if ($oSoapClient1->fault) {
		
			//echo '<h2>Fault 1</h2><pre>';
			//print_r($resultado1);
			//echo '</pre>';
		
		} else {
		
			$err = $oSoapClient1->getError();
			
			if ($err) {
				 '<pre>'.$err.'</pre>';
			} else {
			
			 }
		
		}
		
		/***************************CONSULTO POR ALUMNOS*************************************************/
		
		//$oSoapClient2 = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/ValidaAlumnoSigeSoapPort.wsdl',true);
		$oSoapClient2 = new soapclient('http://w7app.mineduc.cl/WsApiMineduc/wsdl/ValidaAlumnoSigeSoapPort.wsdl',true);
														
		// Se pudo conectar?
		$err = $oSoapClient2->getError();
		if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} 
		
		$StrXml2 = '<EntradaValidaAlumnoSige xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaValidaAlumnoSige.xsd" xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
			<Run>
			<numero>'.$rut_alumno.'</numero>
			<dv>'.$dig_rut.'</dv>
			</Run>
			<Nombres>'.$nombre_alumno.'</Nombres>
			<ApellidoPaterno>'.$ape_pat.'</ApellidoPaterno>     
			<ApellidoMaterno>'.$ape_mat.'</ApellidoMaterno>
			<Semilla>'.$resultado1[ValorSemilla].'</Semilla>
		</EntradaValidaAlumnoSige>';
		
		$resultado2 = $oSoapClient2->call('getValidacion',$StrXml2);
		
		if ($oSoapClient2->fault) {
		
		
		//	print_r($resultado2);
		
		
		} else {
		
			$err = $oSoapClient2->getError();
			
			if ($err) {
			
				 $err;
			
			} else {
			    
				$resultado = $resultado2[ExisteFichaAlumno];
				
	if ($resultado==1){
	echo "<script type=\"text/javascript\">alert('RUN de entrada tiene Ficha SIGE y la identificación proporcionada es correcta.');</script>"; 
	
	}
	else if($resultado==2){
	echo "<script type=\"text/javascript\">alert('RUN de entrada tiene Ficha SIGE, pero la identificación proporcionada no corresponde a la registrada en SIGE.');</script>"; 
	echo "<script>window.location = 'listarMatricula.php3'</script>";
	exit;
	}
	else if($resultado==3){
	echo "<script type=\"text/javascript\">alert('Este código de retorno no está operativo por el momento.');</script>"; 	
	echo "<script>window.location = 'listarMatricula.php3'</script>";
		}
	
	else if($resultado==4){
	echo "<script type=\"text/javascript\">alert('RUN de entrada NO tiene Ficha SIGE.');</script>";
	echo "<script>window.location = 'listarMatricula.php3'</script>";
	
	
	}	
	else if($resultado==5){
	echo "<script type=\"text/javascript\">alert('RUN de entrada NO válido.');</script>";
	echo "<script>window.location = 'listarMatricula.php3'</script>";
	
	}		
	else if($resultado==6){
	echo "<script type=\"text/javascript\">alert('Semilla de operación NO válida o ha caducado. (renovar semilla)');</script>";
	echo "<script>window.location = 'listarMatricula.php3'</script>";
	
	}	
	else if($resultado==7){
	echo "<script type=\"text/javascript\">alert('Error interno de servicio.');</script>";
	echo "<script>window.location = 'listarMatricula.php3'</script>";
	
	}			
				
		}
		
	}
		
		//echo '<h2>Debug</h2><pre>'.htmlspecialchars($oSoapClient2->debug_str, ENT_QUOTES).'</pre>';
	
 
//  exit;
  
?>



