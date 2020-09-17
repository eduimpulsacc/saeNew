<?php

require_once('../../../clases/soap/lib/nusoap.php');
//print_r($_POST);
	
	$ano = $ano;
	$rdb =$rdb;
	$ensenanza = $cmbENS;
	$codigo_grado=$cmbGRA;
	$letra_curso = $cmbLETRA;
	$rut_emp = $cmbSUP;
	$c_simple_combinado=$c_sim_com;
	
	if($c_simple_combinado==1 or $c_simple_combinado=="" ){
		$c_simple_combinado="false";
		}
		
		$jornada=$jornada;
		$especialidad=$cmbESP;
		if ($especialidad==""){
			$especialidad=0;
			}
		$alt_desarrollo_curricular=$cmbAltDCurri;
		
		$sector_economico=$cmbSEC;
		if($sector_economico==""){
			$sector_economico=0;
			}
		
	
	$sql_ano="select nro_ano from ano_escolar where id_ano=$ano";
	$rs_ano=pg_exec($conn,$sql_ano)or die ("Fallo".$sql_ano);
	$fila_ano = pg_fetch_assoc($rs_ano,0);
	$nro_ano=$fila_ano['nro_ano'];
	// "-->".$nro_ano;	
	
	//$nro_ano=2013;
	$sql_emp="select * from empleado em where em.rut_emp=$rut_emp";
			  $rs_emp=pg_exec($conn,$sql_emp)or die("Fallo ".$sql_emp);
			  $fila_emp = pg_fetch_assoc($rs_emp,0);
			  $dig_rut = $fila_emp['dig_rut'];	
	
		
/*****************************************************************************/	
		
		//$oSoapClient1 = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/SemillaServiciosSoapPort.wsdl',true);
		$oSoapClient1 = new soapclient('http://w7app.mineduc.cl/WsApiAutorizacion/wsdl/SemillaServiciosSoapPort.wsdl',true);	
		
		// Se pudo conectar?
		$err = $oSoapClient1->getError();
		if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
		} 
		
		/*************************SOLICITO VALOR SEMILLA************************************************/	

		$StrXml1 = '<EntradaSemillaServicios xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd"
		 xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
			<ClienteId>'.$_CLIENTEID.'</ClienteId>
			<ConvenioId>'.$_CONVENIOID.'</ConvenioId>
			<ConvenioToken>'.$_TOKEN.'</ConvenioToken>
		</EntradaSemillaServicios>'; 
			
				
		$resultado1 = $oSoapClient1->call('getSemillaServicios',$StrXml1,'http://wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd',
		'http://wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd/getSemillaServicios');
		
		
		//$xml1 = file_get_contents($StrXml1); 
		
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
				//print_r($resultado1);
				echo '</pre>';
			 }
		
		}
		
		/***************************CONSULTO POR CURSO*************************************************/
		
		//$oSoapClient2 = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/CursoSigeSoapPort.wsdl',true);
		$oSoapClient2 = new soapclient('http://w7app.mineduc.cl/WsApiMineduc/wsdl/CursoSigeSoapPort.wsdl',true);														
		// Se pudo conectar?
		$err = $oSoapClient2->getError();
		if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} 
		
		 $StrXml2 = '<mine:EntradaAddCursoSige xmlns:mine="http://dido.mineduc.cl/Archivos/Schemas/"
					xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
					xsi:schemaLocation="http://dido.mineduc.cl/Archivos/Schemas/
					http://dido.mineduc.cl/Archivos/Schemas/EntradaAddCursoSige.xsd">
					<mine:RecordCursoSige>
					<mine:PKCursoSige>
					<mine:AnioEscolar>'.$nro_ano.'</mine:AnioEscolar>
					<mine:RBD>'.$rdb.'</mine:RBD>
					<mine:CodigoTipoEnsenanza>'.$ensenanza.'</mine:CodigoTipoEnsenanza>
					<mine:CodigoGrado>'.$codigo_grado.'</mine:CodigoGrado>
					<mine:LetraCurso>'.$letra_curso.'</mine:LetraCurso>
					</mine:PKCursoSige>
					<mine:Run>
					<mine:numero>'.$rut_emp.'</mine:numero>
					<mine:dv>'.$dig_rut.'</mine:dv>
					</mine:Run>
					<mine:CursoCombinado>'.$c_simple_combinado.'</mine:CursoCombinado>
					<mine:NumeroCursoCombinado>0</mine:NumeroCursoCombinado>
					<mine:CodigoTipoJornada>'.$jornada.'</mine:CodigoTipoJornada>
					<mine:CodigoSectorEconomico>'.$sector_economico.'</mine:CodigoSectorEconomico>
					<mine:CodigoEspecialidad>'.$especialidad.'</mine:CodigoEspecialidad>';
					if ($alt_desarrollo_curricular>0){
$StrXml2.='<mine:CodigoAlternativaDesarrolloCurricular>'.$alt_desarrollo_curricular.'</mine:CodigoAlternativaDesarrolloCurricular>';
					}
					$StrXml2.='</mine:RecordCursoSige>
					<mine:Semilla>'.$resultado1[ValorSemilla].'</mine:Semilla>
					</mine:EntradaAddCursoSige>';
					
					
	//$xml = file_get_contents($StrXml2); 
	//print_r($xml);		
		
		
	$resultado2 = $oSoapClient2->call('addCurso',$StrXml2,'http://dido.mineduc.cl/Archivos/Schemas/EntradaAddCursoSige.xsd','http://dido.mineduc.cl/Archivos/Schemas/EntradaAddCursoSige.xsd/addCurso');
		            echo"<pre>";
					//$xml = file_get_contents($resultado2); 
					echo"</pre>";
		if ($oSoapClient2->fault) {
		
			print_r($resultado2);
		
		} else {
		
			$err = $oSoapClient2->getError();
			
			if ($err) {
			
				echo "-->".$err;
			
			} else {
			    
			
		 $resultado = $resultado2[CodigoRespuestaCurso];
		$mensajes = $resultado2[ListadoMensajes];
		"TITULO-->".$mensajes['Titulo'];
		"MENSAJE-->".$mensajes['Mensaje'];
				
			
		 $contar = count($mensajes['Mensaje']);
			
				
			}
		
		}
		
		
// echo '<h2>Debug</h2><pre>'.htmlspecialchars($oSoapClient2->debug_str, ENT_QUOTES).'</pre>';

if($resultado==1){
	echo"<script type='text/javascript'>
		alert('Datos Guardados En SIGE');
	</script>";
	echo "<script>window.location = 'listarCursos.php3'</script>";
	
	}else{
		if($mensajes['Titulo']){
		
		echo "<script type=\"text/javascript\">alert('".$mensajes['Titulo']."');</script>"; 
		
		if($contar==2){
			echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][0]."');</script>"; 
			echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][1]."');</script>"; 
			echo "<script>window.location = 'listarCursos.php3'</script>";
			exit;
			}
			
		if($contar==3){
		echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][0]."');</script>";
		 echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][1]."');</script>";
		 echo  "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][2]."');</script>"; 
		 echo "<script>window.location = 'listarCursos.php3'</script>";
		 exit;
		}
		
		if($contar==4){
		echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][0]."');</script>"; 
		echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][1]."');</script>"; 
		echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][3]."');</script>"; 
		echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][4]."');</script>"; 
		echo "<script>window.location = 'listarCursos.php3'</script>";
		exit;
		}
	
		
		if(count($mensajes['Mensaje'])==1) {
		 echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje']."');</script>"; 
		}
		echo "<script>window.location = 'listarCursos.php3'</script>";
		exit;
		
		}
	
	}
?>



