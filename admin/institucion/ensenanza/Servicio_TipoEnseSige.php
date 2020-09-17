<?php


require_once('../../clases/soap/lib/nusoap.php');
//print_r($_POST);



	$ano = $_ANO;
	$rdb=$rdb;
	
	$tipo_ensenanza = $agrupacion;
	
	$estado_ensenanza=$cmbESTADO;
	if($estado_ensenanza==0){
		$estado_ensenanza=1;
	  }else if($estado_ensenanza==1){
		  $estado_ensenanza=2;
		  }else if($estado_ensenanza==2){
			  $estado_ensenanza=3;
			  
			  }
	
	
	$numero_autorizacion=$txtNUME2;
	$fecha_autorizacion = $txtFECHA;
	$centro_padres = $ecp;
	if($centro_padres==""){
		$centro_padres="false";
		}	
	if($centro_padres==1){
		$centro_padres="true";
		}		
		
	$personalidad_jurudica=$pj;
	if($personalidad_jurudica==""){
		$personalidad_jurudica="false";
		}	
	if($personalidad_jurudica==1){
		$personalidad_jurudica="true";
		}		
		
	$numeros_diferenciales = $txtNumDife;
	if($numeros_diferenciales==""){
		$numeros_diferenciales=0;
		}	
		
	$hora_inicio_mañana=$txtHoraIni;
	if($horario_inicio_mañana==""){
		$horario_inicio_mañana="00:00:00";
		}	
		
	$hora_termino_mañana = $txtHoraFin;
		if($hora_termino_mañana==""){
		$hora_termino_mañana="00:00:00";
		}
		
		
	$hora_inicio_tarde= $txtHoraIniT;
	if($hora_inicio_tarde==""){
		$hora_inicio_tarde="00:00:00";
		}	
		
	$hora_termino_tarde = $txtHoraFinT;	
	if($hora_termino_tarde==""){
		$hora_termino_tarde="00:00:00";
		}	
		
	$hora_inicio_jorcom=$txtHoraIniMT;	
	if($hora_inicio_jorcom==""){
		$hora_inicio_jorcom="00:00:00";
		}	
		
	$hora_termino_jorcom=$txtHoraFinMT;	
	if($hora_termino_jorcom==""){
		$hora_termino_jorcom="00:00:00";
		}

	$sql_ano="select nro_ano from ano_escolar where id_ano=$ano";
	$rs_ano=pg_exec($conn,$sql_ano)or die ("Fallo".$sql_ano);
	$fila_ano = pg_fetch_assoc($rs_ano,0);
	$nro_ano=$fila_ano['nro_ano'];
	echo "<br>".$nro_ano;	

	//exit;	
/*****************************************************************************/	
		
		$oSoapClient1 = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/SemillaServiciosSoapPort.wsdl',true);
								
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
			print_r($resultado1);
			echo '</pre>';
		
		} else {
		
			$err = $oSoapClient1->getError();
			
			if ($err) {
				echo '<h2>Error2</h2><pre>'.$err.'</pre>';
			} else {
			 
			 }
		
		}
		
		/***************************CONSULTO POR TIPO ENSEÑANZA*************************************************/
		
		$oSoapClient2 = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/TipoEnsenanzaSigeSoapPort.wsdl',true);
														
		// Se pudo conectar?
		$err = $oSoapClient2->getError();
		if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} 
		
		
		$StrXml2 = '<mine:EntradaAddTipoEnsenanzaSige
xmlns:mine="http://dido.mineduc.cl/Archivos/Schemas/"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://dido.mineduc.cl/Archivos/Schemas/EntradaAddTipoEnsenanzaSige.xsd"> 
  <mine:RecordTipoEnsenanzaSige> 
		<mine:PKTipoEnsenanzaSige> 
		<mine:AnioEscolar>'.$nro_ano.'</mine:AnioEscolar> 
		<mine:RBD>'.$rdb.'</mine:RBD> 
		<mine:CodigoTipoEnsenanza>'.$tipo_ensenanza.'</mine:CodigoTipoEnsenanza> 
		</mine:PKTipoEnsenanzaSige> 
		<mine:EstadoTipoEnsenanza>'.$estado_ensenanza.'</mine:EstadoTipoEnsenanza> 
		<mine:NumeroAutorizacion>'.$numero_autorizacion.'</mine:NumeroAutorizacion> 
		<mine:FechaAutorizacion>'.$fecha_autorizacion.'</mine:FechaAutorizacion> 
		<mine:TieneCentroPadres>'.$centro_padres.'</mine:TieneCentroPadres> 
		<mine:TienePersonalidadJuridica>'.$personalidad_jurudica.'</mine:TienePersonalidadJuridica> 
		<mine:NumeroGruposDiferenciales>'.$numeros_diferenciales.'</mine:NumeroGruposDiferenciales>
		<mine:HorarioInicioManana>'.$hora_inicio_mañana.'</mine:HorarioInicioManana> 
		<mine:HorarioTerminoManana>'.$hora_termino_mañana.'</mine:HorarioTerminoManana> 
		<mine:HorarioInicioTarde>'.$hora_inicio_tarde.'</mine:HorarioInicioTarde> 
		<mine:HorarioTerminoTarde>'.$hora_termino_tarde.'</mine:HorarioTerminoTarde> 
		<mine:HorarioInicioMananaTarde>'.$hora_inicio_jorcom.'</mine:HorarioInicioMananaTarde> 
		<mine:HorarioTerminoMananaTarde>'.$hora_termino_jorcom.'</mine:HorarioTerminoMananaTarde> 
		<mine:HorarioInicioVespertino>00:00:00</mine:HorarioInicioVespertino> 
		<mine:HorarioTerminoVespertino>00:00:00</mine:HorarioTerminoVespertino> 
		</mine:RecordTipoEnsenanzaSige> 
		<mine:Semilla>'.$resultado1[ValorSemilla].'</mine:Semilla> 
		</mine:EntradaAddTipoEnsenanzaSige>';
		
				
											
	
		$resultado2 = $oSoapClient2->call('addTipoEnsenanza',$StrXml2);
				
		if ($oSoapClient2->fault) {
		
			print_r($resultado2);
			
		} else {
			$err = $oSoapClient2->getError();
			
			if ($err) {
				      echo $err;
			
			} else {
				
			
			$resultado = $resultado2[CodigoRespuestaTipoEnsenanza];
			
			$mensajes = $resultado2[ListadoMensajes];
			"TITULO-->".$mensajes['Titulo'];
			"MENSAJE-->".$mensajes['Mensaje'];
			
			
			$contar = count($mensajes['Mensaje']);
			
			}
		
		}
		
		
		//echo '<h2>Debug</h2><pre>'.htmlspecialchars($oSoapClient2->debug_str, ENT_QUOTES).'</pre>';
		
		if($resultado==1){
	echo"<script type='text/javascript'>
		alert('Datos Guardados En SIGE');
	</script>";
	
	}else{
		if($mensajes['Titulo']){
		
		echo "<script type=\"text/javascript\">alert('".$mensajes['Titulo']."');</script>"; 
		
		if($contar==2){
			echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][0]."');</script>"; 
			echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][1]."');</script>"; 
		echo "<script>window.location = '../atributos/agregar_tipo_ense.php3'</script>";
			exit;
			}
			
		if($contar==3){
		echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][0]."');</script>";
		 echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][1]."');</script>";
		 echo  "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][2]."');</script>"; 
		echo "<script>window.location = '../atributos/agregar_tipo_ense.php3'</script>";
		 exit;
		}
		
		if($contar==4){
		echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][0]."');</script>"; 
		echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][1]."');</script>"; 
		echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][3]."');</script>"; 
		echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje'][4]."');</script>"; 
		echo "<script>window.location = '../atributos/agregar_tipo_ense.php3'</script>";
		exit;
		}
	
		
		if(count($mensajes['Mensaje'])==1) {
		 echo "<script type=\"text/javascript\">alert('".$mensajes['Mensaje']."');</script>"; 
		}
		echo "<script>window.location = '../atributos/agregar_tipo_ense.php3'</script>";
		
		}
	
	}
		
		
		
		
		/*****************************************************************************************************/
		
	
// echo '<h2>Debug</h2><pre>'.htmlspecialchars($oSoapClient2->debug_str, ENT_QUOTES).'</pre>';
//exit;  
?>



