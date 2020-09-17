<?

header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache");

//require_once("../../util/connect.php");
//require_once("../../../util/header.inc");
require_once('nusoap.php');




 // Clase para Realizar Todas las Consultas al Mineduc


  
	class consultas_webservices_mineduc
	{
		
		var $coneccion;
		
		function __construct($conn) {
	
			$this->coneccion = $conn;
			
		 }
		
		
		public function Servicio_Semilla(){
	
			$oSoapClient = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/SemillaServiciosSoapPort.wsdl',true);

			$err = $oSoapClient->getError();
			
			if($err){
			   return $err;  
		     }
					
			$StrXml = '<EntradaSemillaServicios xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
			xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd"
			 xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
				<ClienteId>3</ClienteId>
				<ConvenioId>4</ConvenioId>
				<ConvenioToken>TESTSIGE</ConvenioToken>
			</EntradaSemillaServicios>'; 
					
			$resultado = $oSoapClient->call('getSemillaServicios',$StrXml,
			'http://wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd',
			'http://wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd/getSemillaServicios');
			
			if ($oSoapClient->fault) 
			{
				print_r($resultado);
			}
			else
			{
				$err = $oSoapClient->getError();
				if ($err)
				{
					return $err;
				} 
				else 
				{
					return   $resultado['ValorSemilla'];
				 }
		    }	
			
		}
		
		
		
		public function ValidaAlumno($DatosAlumno,$Semilla)
		{
			$oSoapClient2 = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/ValidaAlumnoSigeSoapPort.wsdl',true);

			$err = $oSoapClient2->getError();
			if($err){
				      return $err;
					} 
			
			$StrXml2 = '<EntradaValidaAlumnoSige xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://wwwfs.mineduc.cl/Archivos/Schemas/
EntradaValidaAlumnoSige.xsd" xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/">

				<Run>
				
				<numero>'.utf8_encode($DatosAlumno[0]).'</numero>
				<dv>'.utf8_encode($DatosAlumno[1]).'</dv>
				</Run>
				<Nombres>'.utf8_encode($DatosAlumno[2]).'</Nombres>
				<ApellidoPaterno>'.utf8_encode($DatosAlumno[3]).'</ApellidoPaterno>     
				<ApellidoMaterno>'.utf8_encode($DatosAlumno[4]).'</ApellidoMaterno>
				<Semilla>'.$Semilla.'</Semilla>
			</EntradaValidaAlumnoSige>';
			
			$resultado2 = $oSoapClient2->call('getValidacion',$StrXml2,'http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaValidaAlumnosSige.xsd',
			'http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaValidaAlumnosSige.xsd/getValidacion');
			
			if($oSoapClient2->fault){
				print_r($resultado2);
			}else{
					$err = $oSoapClient2->getError();
				if ($err){
					return $err;
				}else{
					return  $resultado2['ExisteFichaAlumno'];
				}
			}
			
		}
	
	
	
	
	public function ingresaTipoEnsenanza($DatosTipoEnsenanza,$Semilla)
		{
			$oSoapClient2 = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/TipoEnsenanzaSigeSoapPort.wsdl',true);

			$err = $oSoapClient2->getError();
			if($err){
				      return $err;
					} 
			
$StrXml2 = '<mine:EntradaAddTipoEnsenanzaSige xmlns:mine="http://dido.mineduc.cl/Archivos/Schemas/"xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://dido.mineduc.cl/Archivos/Schemas/EntradaAddTipoEnsenanzaSige.xsd">
					
				<mine:RecordTipoEnsenanzaSige>
				      <mine:PKTipoEnsenanzaSige>
							<mine:AnioEscolar>'.utf8_encode($DatosTipoEnsenanza[0]).'</mine:AnioEscolar>
							<mine:RBD>'.utf8_encode($DatosTipoEnsenanza[1]).'</mine:RBD>
							<mine:CodigoTipoEnsenanza>'.utf8_encode($DatosTipoEnsenanza[2]).'</mine:CodigoTipoEnsenanza>
					  </mine:PKTipoEnsenanzaSige>
					<mine:EstadoTipoEnsenanza>'.utf8_encode($DatosTipoEnsenanza[3]).'</mine:EstadoTipoEnsenanza>
					<mine:NumeroAutorizacion>'.utf8_encode($DatosTipoEnsenanza[4]).'</mine:NumeroAutorizacion>  
					<mine:FechaAutorizacion>'.utf8_encode($DatosTipoEnsenanza[5]).'</mine:FechaAutorizacion>
					<mine:TieneCentroPadres>'.utf8_encode($DatosTipoEnsenanza[6]).'</mine:TieneCentroPadres>
					<mine:TienePersonalidadJuridica>'.utf8_encode($DatosTipoEnsenanza[7]).'</mine:TienePersonalidadJuridica>
					<mine:NumeroGruposDiferenciales>'.utf8_encode($DatosTipoEnsenanza[8]).'</mine:NumeroGruposDiferenciales>
					<mine:HorarioInicioManana>'.utf8_encode($DatosTipoEnsenanza[9]).'</mine:HorarioInicioManana>
					<mine:HorarioTerminoManana>'.utf8_encode($DatosTipoEnsenanza[10]).'</mine:HorarioTerminoManana>
					<mine:HorarioInicioTarde>'.utf8_encode($DatosTipoEnsenanza[11]).'</mine:HorarioInicioTarde>
					<mine:HorarioTerminoTarde>'.utf8_encode($DatosTipoEnsenanza[12]).'</mine:HorarioTerminoTarde>
					<mine:HorarioInicioMananaTarde>'.utf8_encode($DatosTipoEnsenanza[13]).'</HorarioInicioMananaTarde>
					<mine:HorarioTerminoMananaTarde>'.utf8_encode($DatosTipoEnsenanza[14]).'</HorarioTerminoMananaTarde>
					<mine:HorarioInicioVespertino>'.utf8_encode($DatosTipoEnsenanza[15]).'</mine:HorarioInicioVespertino>
					<mine:HorarioTerminoVespertino>'.utf8_encode($DatosTipoEnsenanza[16]).'</mine:HorarioTerminoVespertino>
			  </mine:RecordTipoEnsenanzaSige>
			 <Semilla>'.$Semilla.'</Semilla>
		</mine:EntradaAddTipoEnsenanzaSige>';
			
$resultado2 = $oSoapClient2->call('addTipoEnsenanza',$StrXml2,'http://dido.mineduc.cl/Archivos/Schemas/EntradaAddTipoEnsenanzaSige.xsd',
			'http://dido.mineduc.cl/Archivos/Schemas/EntradaAddTipoEnsenanzaSige.xsd/addTipoEnsenanza');
			
			if($oSoapClient2->fault){
				print_r($resultado2);
			}else{
					$err = $oSoapClient2->getError();
				if ($err){
					return $err;
				}else{
					return  $resultado2['SalidaAddTipoEnsenanzaSige'];
				}
			}
			
		}
	
	
	
	
		public function ingresaCursoSige($DatosCurso,$Semilla)
		{
			$oSoapClient3 = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/CursoSigeSoapPort.wsdl',true);

			$err = $oSoapClient3->getError();
			if($err){
				      return $err;
					} 
			
$StrXml3 = '<mine:EntradaAddCursoSige xmlns:mine="http://dido.mineduc.cl/Archivos/Schemas/"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://dido.mineduc.cl/Archivos/Schemas/
http://dido.mineduc.cl/Archivos/Schemas/EntradaAddCursoSige.xsd">
				<mine:RecordCursoSige>
				      <mine:PKCursoSige>
							<mine:AnioEscolar>'.utf8_encode($DatosCurso[0]).'</mine:AnioEscolar>
							<mine:RBD>'.utf8_encode($DatosCurso[1]).'</mine:RBD>
							<mine:CodigoTipoEnsenanza>'.utf8_encode($DatosCurso[2]).'</mine:CodigoTipoEnsenanza>
							<mine:CodigoGrado>'.utf8_encode($DatosCurso[3]).'</mine:CodigoGrado>
							<mine:LetraCurso>'.utf8_encode($DatosCurso[4]).'</mine:LetraCurso>
					  </mine:PKCursoSige>
					<mine:Run>
					        <mine:numero>'.utf8_encode($DatosCurso[5]).'</mine:numero> 
					        <mine:dv>'.utf8_encode($DatosCurso[6]).'</mine:dv> 
					</mine:Run>
					<mine:CursoCombinado>'.utf8_encode($DatosCurso[7]).'</mine:CursoCombinado>
					<mine:NumeroCursoCombinado>'.utf8_encode($DatosCurso[8]).'</mine:NumeroCursoCombinado>
					<mine:CodigoTipoJornada>'.utf8_encode($DatosCurso[9]).'</mine:CodigoTipoJornada>
					<mine:CodigoSectorEconomico>'.utf8_encode($DatosCurso[10]).'</mine:CodigoSectorEconomico>
					<mine:CodigoEspecialidad>'.utf8_encode($DatosCurso[11]).'</mine:CodigoEspecialidad>
					<mine:CodigoAlternativaDesarrolloCurricular>'.utf8_encode($DatosCurso[12]).'</mine:CodigoAlternativaDesarrolloCurricular>					 
			  </mine:RecordCursoSige>
			 <Semilla>'.$Semilla.'</Semilla>
		</mine:EntradaAddCursoSige>';
			
$resultado3 = $oSoapClient3->call('addCurso',$StrXml3,'http://dido.mineduc.cl/Archivos/Schemas/EntradaAddCursoSige.xsd',
'http://dido.mineduc.cl/Archivos/Schemas/EntradaAddCursoSige.xsd/addCurso');
			
			
				
			
			
			if($oSoapClient3->fault){
				
			}else{
					$err = $oSoapClient3->getError();
				if ($err){
					return $err;
				}else{
					return  $resultado3['mine:CodigoRespuestaCurso'];
				}
			}
			
		}
	
	
	
	   }
		
		
		
	$objeto = new consultas_webservices_mineduc();
	
	    
	
	echo "Semilla = ".$Semilla = $objeto->Servicio_Semilla();
    
    echo "<br>" ;
	   
    echo "Resultado Validacion = ".$IngresaCurso = $objeto->ingresaCursoSige(array('2012','9966','110','1','A','20277900','4','false','0','01','110','51001','1'),$Semilla);
		
		
		
			

	/*$objeto = new consultas_webservices_mineduc();
	
	echo "Semilla = ".$Semilla = $objeto->Servicio_Semilla();
    
    echo "<br>" ;
	   
    echo "Resultado Validacion = ".$ValidaAlumno = $objeto->ValidaAlumno(array('20277900','4','JOAQUIN GABRIEL',' 
	ALVARADO','ROJAS'),$Semilla);*/
	
    
	  
?>
