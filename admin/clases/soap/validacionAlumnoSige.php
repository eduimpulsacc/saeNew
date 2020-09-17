<style type="text/css">
<!--
body,td,th {
	color: #00CC00;
}
body {
	background-color: #000000;
}
-->
</style>
<?
header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache");

require "../../../util/connect.php";
require_once('nusoap.php');


       $sql = "SELECT cur.id_curso, 
       (cur.grado_curso || ' - ' || cur.letra_curso) as cursote, 
		alu.ape_pat,alu.ape_mat,alu.nombre_alu,alu.rut_alumno,alu.dig_rut
		FROM institucion inst
		left outer join ano_escolar aesco on aesco.id_institucion = inst.rdb 
		left outer join curso cur on cur.id_ano = aesco.id_ano AND cur.id_curso = 1602
		left outer join matricula matri on matri.id_curso = cur.id_curso 
		left outer join alumno alu on alu.rut_alumno = matri.rut_alumno
		WHERE
		inst.rdb = 24988
		ORDER BY 2";
		
		


$rs = @pg_exec($conn,$sql) or die("SELECT FALLO:".$sql);


echo "<TABLE align='center' bordercolor='#00FF00' border='1' nowrap='nowrap' >";
echo "<TR>";
echo "<TH colspan='6'>&nbsp;SERVICIO WEB SERVICE SIGE&nbsp;</TH>";
echo "</TR>";
echo "<TR>";
echo "<TH colspan='6'>&nbsp;CONSULTA POR INSTITUCION N&deg;24988 CURSO N&deg;1602&nbsp;</TH>";
echo "</TR>";
echo "<TR>";
echo "<TH>&nbsp;#&nbsp;</TH>";
echo "<TH>&nbsp;RUT&nbsp;</TH>";
echo "<TH>&nbsp;NOMBRE&nbsp;</TH>";
echo "<TH>&nbsp;APE. PATERNO&nbsp;</TH>";
echo "<TH>&nbsp;APE. MATERNO&nbsp;</TH>";
echo "<TH>&nbsp;ESTADO&nbsp;</TH>";
echo "</TR>";

for($x=0;$x<@pg_numrows($rs);$x++){  // INICIO FOR
 
//echo $x1 = $fila['rut_alumno']."=".$fila['nombre_alu']."<br>";
  
	    $fila = @pg_fetch_array($rs,$x);

		$oSoapClient1 = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/SemillaServiciosSoapPort.wsdl',true);
								
		// Se pudo conectar?
		$err = $oSoapClient1->getError();
		if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} 
		
		/*************************SOLICITO VALOR SEMILLA************************************************/	

		/*$StrXml1 = '<EntradaSemillaServicios xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd"
		 xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
			<ClienteId>3</ClienteId>
			<ConvenioId>4</ConvenioId>
			<ConvenioToken>TESTSIGE</ConvenioToken>
		</EntradaSemillaServicios>'; */
		$StrXml1 = '<EntradaSemillaServicios xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd"
		 xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
			<ClienteId>25</ClienteId>
			<ConvenioId>31</ConvenioId>
			<ConvenioToken>TESTCOLEGIOINTERACTIVO</ConvenioToken>
		</EntradaSemillaServicios>'; 
				
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
				echo "semilla=".$resultado1['ValorSemilla'];
				echo '</pre>';
			 }
		
		}
		
		/***************************CONSULTO POR ALUMNOS*************************************************/
		
		$oSoapClient2 = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/ValidaAlumnoSigeSoapPort.wsdl',true);
														
		// Se pudo conectar?
		$err = $oSoapClient2->getError();
		if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} 
		
		$StrXml2 = '<EntradaValidaAlumnoSige xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaValidaAlumnoSige.xsd" xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
			<Run>
			<numero>'.utf8_encode($fila['rut_alumno']).'</numero>
			<dv>'.utf8_encode($fila['dig_rut']).'</dv>
			</Run>
			<Nombres>'.utf8_encode($fila['nombre_alu']).'</Nombres>
			<ApellidoPaterno>'.utf8_encode($fila['ape_pat']).'</ApellidoPaterno>     
			<ApellidoMaterno>'.utf8_encode($fila['ape_mat']).'</ApellidoMaterno>
			<Semilla>'.$resultado1[ValorSemilla].'</Semilla>
		</EntradaValidaAlumnoSige>';
		
		$resultado2 = $oSoapClient2->call('getValidacion',$StrXml2,'http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaValidaAlumnosSige.xsd',
		'http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaValidaAlumnosSige.xsd/getValidacion');
		
		if ($oSoapClient2->fault) {
		
			echo '<tr nowrap="nowrap" >
			      <td>'.$x.'</td>
				  <td colspan="5" >';
			print_r($resultado2);
			echo '</td>
			      </tr>';
		
		} else {
		
			$err = $oSoapClient2->getError();
			
			if ($err) {
			
				echo "<tr nowrap='nowrap' >
				      <td>".$x."</td>
				      <td colspan='5' >".$err.'</td>
					  </tr>';
			
			} else {
			    
				echo "<tr nowrap='nowrap' >";
				echo "<td>".$x."</td>"; 
				echo "<td align='center'>".$fila['rut_alumno']."-".$fila['dig_rut']."</td>";
				echo "<td>".$fila['nombre_alu']."</td>";
				echo "<td>".$fila['ape_pat']."</td>";
				echo "<td>".$fila['ape_mat']."</td>";
				echo "<td align='center'>".$resultado2[ExisteFichaAlumno]."</td>";
			    echo "</tr>";
			}
		
		}
		
		
		
		
		/*****************************************************************************************************/
		
		/*echo '<h2>$oSoapClient1</h2><br>';
		echo '<h2>Request</h2><pre>'.htmlspecialchars($oSoapClient1->request, ENT_QUOTES).'</pre>';
		echo '<h2>Response</h2><pre>'.htmlspecialchars($oSoapClient1->response, ENT_QUOTES).'</pre>';
		echo '<h2>Debug</h2><pre>'.htmlspecialchars($oSoapClient1->debug_str, ENT_QUOTES).'</pre>';
		echo '<br>';
		echo '<h2>$oSoapClient2</h2><br>';
		echo '<h2>Request</h2><pre>'.htmlspecialchars($oSoapClient2->request, ENT_QUOTES).'</pre>';
		echo '<h2>Response</h2><pre>'.htmlspecialchars($oSoapClient2->response, ENT_QUOTES).'</pre>';
		echo '<h2>Debug</h2><pre>'.htmlspecialchars($oSoapClient2->debug_str, ENT_QUOTES).'</pre>';
		echo '<br>';*/

  } // TERMINA FOR
  
echo "<TABLE>";
  
?>



