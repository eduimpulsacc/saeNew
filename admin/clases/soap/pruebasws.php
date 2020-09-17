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
		
		/*echo "<pre>";
		echo $StrXml1;
		echo "</pre>";*/
				
		$resultado1 = $oSoapClient1->call('getSemillaServicios',$StrXml1);
		
		if ($oSoapClient1->fault) {
		
			echo '<h2>Fault 1</h2><pre>';
			print_r($resultado1);
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
		
	
		
		
			
		$wsdl='http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/CursoSigeSoapPort.wsdl';

		$nuevoCliente =  new nusoap_client($wsdl,true);
		
		
		
             
                $error = $nuevoCliente->getError();
                if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} else{
					echo '<h2>Conectado!!!!</h2>';
					
				}
                             

                 				
$StrXml2 ='<mine:EntradaAddCursoSige xmlns:mine="http://dido.mineduc.cl/Archivos/Schemas/"
					xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
					xsi:schemaLocation="http://dido.mineduc.cl/Archivos/Schemas/
					http://dido.mineduc.cl/Archivos/Schemas/EntradaAddCursoSige.xsd">
<mine:RecordCursoSige> 
<mine:PKCursoSige> 
<mine:AnioEscolar>2012</mine:AnioEscolar> 
<mine:RBD>9960</mine:RBD> 
<mine:CodigoTipoEnsenanza>510</mine:CodigoTipoEnsenanza>
<mine:CodigoGrado>3</mine:CodigoGrado> 
<mine:LetraCurso>A</mine:LetraCurso> 
</mine:PKCursoSige> 
<mine:Run> 
<mine:numero>10230147</mine:numero> 
<mine:dv>1</mine:dv>
</mine:Run> 
<mine:CursoCombinado>false</mine:CursoCombinado> 
<mine:NumeroCursoCombinado>0</mine:NumeroCursoCombinado> 
<mine:CodigoTipoJornada>1</mine:CodigoTipoJornada> 
<mine:CodigoSectorEconomico>0</mine:CodigoSectorEconomico>
<mine:CodigoEspecialidad>0</mine:CodigoEspecialidad>
<mine:CodigoAlternativaDesarrolloCurricular>1</mine:CodigoAlternativaDesarrolloCurricular>
</mine:RecordCursoSige>
<mine:Semilla>'.$resultado1[ValorSemilla].'</mine:Semilla> 
</mine:EntradaAddCursoSige>';
              

	//$xml = file_get_contents($StrXml2); 
	//var_dump($xml);
	
	echo"<pre>";
	//print_r($nuevoCliente);
	echo"<pre>";
	
	$resul = $nuevoCliente->call('addCurso',$StrXml2,'http://dido.mineduc.cl/Archivos/Schemas/EntradaAddCursoSige.xsd','http://dido.mineduc.cl/Archivos/Schemas/EntradaAddCursoSige.xsd/addCurso');   
		
		
    echo"<pre>";
	//var_dump($resul);
	echo"<pre>";        
         
         
         if($nuevoCliente->fault){
            print_r($resul);
    }else{
            $err = $nuevoCliente->getError();
            if ($err){
                    echo $err;
            }else{
                print_r($resul);
                echo "PASOOOO!!";
                echo $resul['CodigoRespuestaCurso'];
         }
			
  }       
  
  
   
 	//echo '<h2>$oSoapClient1</h2><br>';
		/*echo '<h2>Request</h2><pre>'.htmlspecialchars($oSoapClient1->request, ENT_QUOTES).'</pre>';
		echo '<h2>Response</h2><pre>'.htmlspecialchars($oSoapClient1->response, ENT_QUOTES).'</pre>';
		echo '<h2>Debug</h2><pre>'.htmlspecialchars($oSoapClient1->debug_str, ENT_QUOTES).'</pre>';
		echo '<br>';
		echo '<h2>$oSoapClient2</h2><br>';
		echo '<h2>Request</h2><pre>'.htmlspecialchars($nuevoCliente->request, ENT_QUOTES).'</pre>';
		echo '<h2>Response</h2><pre>'.htmlspecialchars($nuevoCliente->response, ENT_QUOTES).'</pre>';*/
	//	echo '<h2>Debug</h2><pre>'.htmlspecialchars($nuevoCliente->debug_str, ENT_QUOTES).'</pre>';
		//echo '<br>';       
		
  
  
?>



