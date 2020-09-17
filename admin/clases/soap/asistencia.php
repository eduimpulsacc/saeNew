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

require "../../../util/connect.php";
require_once('lib/nusoap.php');

echo pg_dbname($conn);

$nro_ano=2012;
$rdb = 279;
$ensenanza = 310;
$grado = 1;
$fecha='2012-05-03';
$letra_curso = 'A';



echo $sql="select m.rut_alumno,al.dig_rut,c.id_ano,c.ensenanza,c.grado_curso,c.letra_curso from curso c
inner join matricula m on c.id_curso=m.id_curso
inner join alumno al on m.rut_alumno=al.rut_alumno
where c.id_ano=1166 and c.ensenanza=$ensenanza and c.grado_curso=$grado and c.letra_curso='$letra_curso'";

	$rs_curso=pg_exec($conn,$sql)or die(pg_last_error($sql));
	
    

	$oSoapClient1 = new nusoap_client('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/SemillaServiciosSoapPort.wsdl',true);
								
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
		
		
		echo "<pre>";
		echo $StrXml1;
		echo "</pre>";
				
		$resultado1 = $oSoapClient1->call('getSemillaServicios',$StrXml1,'http://wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd',
		'http://wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd/getSemillaServicios');
		
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
		
		
		$nuevoCliente = new SoapClient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/AsistenciaSigeSoapPort.wsdl',true);
                $error = $nuevoCliente->getError();
                if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} else{
					echo '<h2>Conectado!!</h2>';
					
				}
                             
                                                                                                                                 		               
                 				
$StrXml2 = '<mine:EntradaAddAsistenciaSige xmlns:mine="http://dido.mineduc.cl/Archivos/Schemas/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://dido.mineduc.cl/Archivos/Schemas/ http://dido.mineduc.cl/Archivos/Schemas/EntradaAddAsistenciaSige.xsd"> 
		<mine:RecordAsistenciaSige> 
		<mine:AnioEscolar>'.$nro_ano.'</mine:AnioEscolar> 
		<mine:RBD>'.$rdb.'</mine:RBD> 
		<mine:CodigoTipoEnsenanza>'.$ensenanza.'</mine:CodigoTipoEnsenanza> 
		<mine:CodigoGrado>'.$grado.'</mine:CodigoGrado> 
		<mine:FechaAsistencia>'.$fecha.'</mine:FechaAsistencia> 
		<mine:Cursos>
		<mine:Curso> 
		<mine:LetraCurso>'.$letra_curso.'</mine:LetraCurso> 
		<mine:Presentes>'; 
		
		for($x=0;$x<@pg_numrows($rs_curso);$x++){  
		$fila= pg_fetch_array($rs_curso,$x);
		
		$StrXml2.='<mine:Run> 
		<mine:numero>'.$fila['rut_alumno'].'</mine:numero> 
		<mine:dv>'.$fila['dig_rut'].'</mine:dv> 
		</mine:Run> ';
		}
		$StrXml2.='</mine:Presentes>
		<mine:Ausentes> 
		<mine:Run> 
		<mine:numero>20738153</mine:numero> 
		<mine:dv>5</mine:dv> 
		</mine:Run> 
		</mine:Ausentes> 
		</mine:Curso> 
		</mine:Cursos> 
		</mine:RecordAsistenciaSige> 
		<mine:Semilla>'.$resultado1[ValorSemilla].'</mine:Semilla> 
		</mine:EntradaAddAsistenciaSige>';
		
              
             			
       
             
         $resul = $nuevoCliente->call('addAsistencia',$StrXml2);   

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
                
	
	// } //fin for
     echo '<h2>Debug</h2><pre>'.htmlspecialchars($nuevoCliente->debug_str, ENT_QUOTES).'</pre>';
?>



