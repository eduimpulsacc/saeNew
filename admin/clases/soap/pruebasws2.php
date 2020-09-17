<style type="text/css">
<!--
body,td,th {
	color: #00CC00;
}
body {
	background-color: #000000;
}
</style>
<?
header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache");

//require "../../../util/connect.php";

 //Agregamos la raíz al path para que podamos

//incluir Zend de forma directa



require_once('lib/nusoap.php');
      

		$oSoapClient1 = new nusoap_client('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/SemillaServiciosSoapPort.wsdl','wsdl');
								
		// Se pudo conectar?
		$err = $oSoapClient1->getError();
		if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
		} 
		
		/*************************SOLICITO VALOR SEMILLA************************************************/	

		$StrXml1 = '<EntradaSemillaServicios xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd"
		 xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
			<ClienteId>25</ClienteId>
			<ConvenioId>31</ConvenioId>
			<ConvenioToken>TESTCOLEGIOINTERACTIVO</ConvenioToken>
		</EntradaSemillaServicios>'; 
		$resultado1 = $oSoapClient1->call('getSemillaServicios',$StrXml1);
		
		if ($oSoapClient1->fault) {
		
			echo '<h2>Fault 1</h2><pre>';
			//print_r($resultado1);
			echo '</pre>';
		
		} else {
		
			$err = $oSoapClient1->getError();
			
			if ($err) {
				echo '<h2>Error2</h2><pre>'.$err.'</pre>';
			} else {
				echo '<h2>Result</h2><pre>';
				print_r($resultado1);
				echo '</pre>';
			 }
		
		}
		
		/***************************CONSULTO POR CURSOS*************************************************/

		$nuevoCliente =  new nusoap_client("http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/CursoSigeSoapPort.wsdl",'wsdl');
		$nuevoCliente->namespaces = "http://dido.mineduc.cl/Archivos/Schemas/";

	//	$nuevoCliente =  new nusoap_client('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/SemillaServiciosSoapPort.wsdl','wsdl');
		$error = $nuevoCliente->getError();
		
        if ($err) {
			echo '<h2>Error1</h2><pre></pre>';
		} else{
			echo '<h2>Conectado CREAME2!!!!</h2>';
		}
                             

                 				
		$StrXml2 ='<?xml version="1.0" encoding="UTF-8"?> <mine:EntradaAddCursoSige xmlns:mine="http://dido.mineduc.cl/Archivos/Schemas/TiposCursoSige.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://dido.mineduc.cl/Archivos/Schemas/ http://dido.mineduc.cl/Archivos/Schemas/EntradaAddCursoSige.xsd">
		<mine:RecordCursoSige>
		<mine:PKCursoSige>
			<mine:AnioEscolar>2012</mine:AnioEscolar>
			<mine:RBD>279</mine:RBD>
			<mine:CodigoTipoEnsenanza>510</mine:CodigoTipoEnsenanza>
			<mine:CodigoGrado>1</mine:CodigoGrado>
			<mine:LetraCurso>S</mine:LetraCurso>
		</mine:PKCursoSige>
		<mine:Run>
			<mine:numero>8464932</mine:numero>
			<mine:dv>5</mine:dv>
		</mine:Run>
		<mine:CursoCombinado>false</mine:CursoCombinado>
		<mine:NumeroCursoCombinado></mine:NumeroCursoCombinado>
		<mine:CodigoTipoJornada>1</mine:CodigoTipoJornada>
		<mine:CodigoSectorEconomico></mine:CodigoSectorEconomico>
		<mine:CodigoEspecialidad></mine:CodigoEspecialidad CodigoInfraestEspe>
		<mine:CodigoAlternativaDesarrolloCurricular>1</mine:CodigoAlternativaDesarrolloCurricular>
		</mine:RecordCursoSige>
		<mine:Semilla>'.$resultado1[ValorSemilla].'</mine:Semilla>
		</mine:EntradaAddCursoSige>';
		
		
//		$resul = $nuevoCliente->call('addCurso',$StrXml2,);    
		$resul = $nuevoCliente->call('addCursoxx');    


	echo '<h2>CPASEE'.$resul['CodigoRespuestaCurso'].' </h2>';
         
      /*  if($nuevoCliente->fault){
          echo $resul['CodigoRespuestaCurso'];
		    print_r($resul);
	    }else{*/
           $err = $nuevoCliente->getError();
           if ($err){
              echo "NOPASO!";
			  echo $err;
           }else{
              print_r($resul);
              echo "PASOOOO!!";
              echo $resul['CodigoRespuestaCurso'];
           }
  		//}       
                
		
  
  
?>



