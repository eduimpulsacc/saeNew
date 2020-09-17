<?php 	require('../../../../../../util/header.inc');

//print_r($_POST);
require_once('../../../../../clases/soap/lib/nusoap.php');

//$fecha='2013-03-05';
$curso = $_POST['id_curso'];

ini_set('default_socket_timeout', 160);

	//$oSoapClient1 = new nusoap_client('http://dido.mineduc.cl:9080/WsApiAutorizacion/wsdl/SemillaServiciosSoapPort.wsdl',true);
	$oSoapClient1 = new nusoap_client('http://w7app.mineduc.cl/WsApiAutorizacion/wsdl/SemillaServiciosSoapPort.wsdl',true);
		// Se pudo conectar?
		$err = $oSoapClient1->getError();
		if ($err) {
		//	echo '<h2>Error1</h2><pre>'.$err.'</pre>';
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
		
		if ($oSoapClient1->fault) {
		
			//echo '<h2>Fault 1</h2><pre>';
			//print_r($resultado1);
			//echo '</pre>';
		
		} else {
		
			$err = $oSoapClient1->getError();
			
			if ($err) {
				//echo '<h2>Error2</h2><pre>'.$err.'</pre>';
			} else {
				//echo '<h2>Result</h2><pre>';
				//print_r($resultado1);
				//echo '</pre>';
			 }
		
		}
		
		//$nuevoCliente = new SoapClient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/AsistenciaSigeSoapPort.wsdl',true);
		$nuevoCliente = new SoapClient('http://w7app.mineduc.cl/WsApiMineduc/wsdl/AsistenciaSigeSoapPort.wsdl',true);
                $error = $nuevoCliente->getError();
                if ($err) {
			//echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} else{
					//echo '<h2>Conectado</h2>';
					
				}
		
		
		
		
		$StrXml3='<mine:EntradaGetReporteEnvioAsistenciaSige xmlns:mine="http://dido.mineduc.cl/Archivos/Schemas/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://dido.mineduc.cl/Archivos/Schemas/ http://dido.mineduc.cl/Archivos/Schemas/EntradaGetReporteEnvioAsistenciaSige.xsd"> 
		<mine:RBD>'.$rdb.'</mine:RBD> 
		<mine:CodigoEnvioAsistencia>'.$codigo_sige.'</mine:CodigoEnvioAsistencia> 
		<mine:Semilla>'.$resultado1[ValorSemilla].'</mine:Semilla> 
		</mine:EntradaGetReporteEnvioAsistenciaSige>';	
		
		
		$xml='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sch="http://dido.mineduc.cl/Archivos/Schemas/">
   <soapenv:Header/>
   <soapenv:Body>
      <sch:EntradaGetReporteEnvioAsistenciaSige>
         <sch:RBD>'.$rdb.'</sch:RBD>
         <sch:CodigoEnvioAsistencia>'.$codigo_sige.'</sch:CodigoEnvioAsistencia>
         <sch:Semilla>'.$resultado1[ValorSemilla].'</sch:Semilla>
      </sch:EntradaGetReporteEnvioAsistenciaSige>
   </soapenv:Body>
</soapenv:Envelope>';

if($_PERFIL==0){
$file=fopen(date("Y-m-d_H-i-s").'_'.'EntradaGetReporteEnvioAsistenciaSige_consulta.xml',"w+"); 
  fwrite ($file,$xml); 
  fclose($file); 
}

/*$feb = substr($codigo_sige, 0, 8);
$fecha_del_dia=substr($feb, 0, 4)."-".substr($feb, 4, 2)."-".substr($feb, 6, 2);	*/	
		
$fecha_del_dia = $_POST['fcons'];
	
$urlx="http://w7app.mineduc.cl/WsApiMineduc/services/AsistenciaSigeSoapPort";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $urlx);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

$headers = array();
array_push($headers, "Content-Type: text/xml; charset=utf-8");
array_push($headers, "Accept: text/xml");
array_push($headers, "Cache-Control: no-cache");
array_push($headers, "Pragma: no-cache");
array_push($headers, "SOAPAction: http://api.soap.website.com/WSDL_SERVICE/GetShirtInfo");
if($xml != null) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
    array_push($headers, "Content-Length: " . strlen($xml));
}
//curl_setopt($ch, CURLOPT_USERPWD, "user_name:password"); 
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
$conttx="";
if($_PERFIL==0){
if (file_put_contents ('./'.date("Y-m-d_H-i-s").'_'.'EntradaGetReporteEnvioAsistenciaSige_respuesta.xml', $response) !== false) {
 /*  echo"<script type='text/javascript'>
		alert('Semilla ok');
	</script>";*/
} else {
    // echo 'Failed';
}		
}
		$resul_codigo = $nuevoCliente->call('getReporteEnvioAsistencia',$StrXml3);   

         if($nuevoCliente->fault){
            print_r($resul_codigo);
			
    }else{
            $err = $nuevoCliente->getError();
            if ($err){
                    echo $err;
            }else{
				if($_PERFIL==0){

                //print_r($resul_codigo);
                 
				/*echo "<pre>";
                    echo "--->".$resul_codigo[CodigoRespuestaReporteEnvioAsistencia];
				echo "</pre>";
				echo "<pre>";
                   print_r($resul_codigo[ListadoMensajes]);
				echo "</pre>";	*/
				

				//$mensajes2 = $resul_codigo['ListadoMensajes'];
				//print_r($mensajes2);
				}
				$mensajes2 = $resul_codigo['ListadoMensajes'];
				if($resul_codigo[CodigoRespuestaReporteEnvioAsistencia]==2){
			
					$listado_errores=$mensajes2['Titulo']; 
					$largo_errores = count($mensajes2['Mensaje']);
					$mensaje_error[] = $mensajes2['Mensaje'];

					//var_dump($mensaje_error);
				
				for($i=0;$i<$largo_errores;$i++){
					
					   $sql_his1="insert into asistencia_sige_historia(rbd,id_ano,id_curso,fecha_envio,fecha_operacion,tipo,cod_respuesta,mensaje_respuesta,hora_operacion)
					   values($_INSTIT,$_ANO,$curso,'$fecha_del_dia','".date("Y-m-d")."',4,'".$resul_codigo[CodigoRespuestaReporteEnvioAsistencia]."',
					   '".$mensaje_error[$i]."','".date("H:i:s")."')";
 $rs_his1 = pg_exec($conn,$sql_his1);
//if($_PERFIL==0){echo $sql_his1;}
				}
				
				

				//print_r($mensaje_error);
				?>
				<table align="center" width="90%" border="1" style="border-collapse:collapse">
                <tr align="center" class="cuadro02">
                <td><?=$listado_errores?></td>
                </tr>
                        <?
				for($i=0;$i<=$largo_errores;$i++){
				
					 ?>
				<tr>
				 <td class="cuadro01"><?=$mensaje_error[$i];?></td>
                 <?
				}
				?>
			    </tr></table>
			<?
				}
				elseif($resul_codigo[CodigoRespuestaReporteEnvioAsistencia]==3){
			
			    $listado_errores=$mensajes2['Titulo']; 
				$largo_errores = count($mensajes2['Mensaje']);
				$mensaje_error = $mensajes2['Mensaje'];
				
				
				
				
				for($i=0;$i<$largo_errores;$i++){
					$conttx="";
				$cadena_buscada   = 'FALTANTE';
$posicion_coincidencia = strpos($mensaje_error[$i], $cadena_buscada);
if ($posicion_coincidencia){
$conttx=" DEBE VERIFICAR QUE ALUMNO EST&Eacute; EN SAE Y SIGE, Y LUEGO REENVIAR ASISTENCIA";
}
					
					   $sql_his1="insert into asistencia_sige_historia(rbd,id_ano,id_curso,fecha_envio,fecha_operacion,tipo,cod_respuesta,mensaje_respuesta,hora_operacion)values($_INSTIT,$_ANO,$curso,'$fecha_del_dia','".date("Y-m-d")."',4,'".$resul_codigo[CodigoRespuestaReporteEnvioAsistencia]."','".$mensaje_error[$i].$conttx."','".date("H:i:s")."')";
 $rs_his1 = pg_exec($conn,$sql_his1);

				}


				//print_r($mensaje_error);
				?>
				<table align="center" width="90%" border="1" style="border-collapse:collapse">
                <tr align="center" class="cuadro02">
                <td><?=$listado_errores?></td>
                </tr>
                        <?
				for($i=0;$i<=$largo_errores;$i++){
					$cadena_buscada   = 'FALTANTE';
$posicion_coincidencia = strpos($mensaje_error[$i], $cadena_buscada);
$conttx="";
if ($posicion_coincidencia){
$conttx=" DEBE VERIFICAR QUE ALUMNO EST&Eacute; EN SAE Y SIGE, Y LUEGO REENVIAR ASISTENCIA";
}
					
					 ?>
				<tr>
				 <td class="cuadro01"><?=$mensaje_error[$i].$conttx;?></td>
                 <?
				}
				?>
			    </tr></table>
			<?
				}else{
				 echo $resul_codigo[CodigoRespuestaReporteEnvioAsistencia];
				 $sql_his1="insert into asistencia_sige_historia(rbd,id_ano,id_curso,
				 fecha_envio,fecha_operacion,tipo,cod_respuesta,mensaje_respuesta,hora_operacion)v
				 alues($_INSTIT,$_ANO,$curso ,'$fecha_del_dia','".date("Y-m-d")."',4,'".$resul_codigo[CodigoRespuestaReporteEnvioAsistencia]."','".$resul_codigo[CodigoRespuestaReporteEnvioAsistencia]."','".date("H:i:s")."')";
 $rs_his1 = pg_exec($conn,$sql_his1);
				}
		}
			
	}
	
		
/*if($_PERFIL==0){
	 echo $sql_his1;
}
*/
?>