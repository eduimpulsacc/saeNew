<?php 	require('../../../../../../util/header.inc');


//print_r($_POST);
date_default_timezone_set('America/Santiago');

$cmb_curso = $_CURSO;
$ano = $_ANO;
$rdb= $_INSTIT;
//$rdb=121212;
$ensenanza=$ensenanza;

$fecha_del_dia;

$separa_fecha=explode('/',$fecha_del_dia);

$dia=$separa_fecha[2];
 "------>".$dia;

	$qry0="select nro_ano from ano_escolar where id_ano=".$ano;
	$result0=@pg_Exec($conn,$qry0);
	$fila0	= @pg_fetch_array($result0,0);
	$nro_ano=$fila0['nro_ano'];


	 $sql_cur = "select * from curso where id_curso=$cmb_curso";
	$result_c=@pg_Exec($conn,$sql_cur);
	$fila_c	= @pg_fetch_array($result_c,0);
	$grado_curso=$fila_c['grado_curso'];
	$letra_curso=$fila_c['letra_curso'];



	$qry = " SELECT alumno.rut_alumno ||'-'|| alumno.dig_rut AS ausente, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista  ";
	$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
	$qry = $qry . " WHERE ((matricula.id_curso=".$cmb_curso.") AND (matricula.bool_ar=0)) ";
	$qry = $qry . " ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
	$result	= @pg_Exec($conn,$qry);
	
	//$nro_ano=2013;
	
	
	for ($z=0 ; $z<=60 ; $z++){
		
		$rut_ausentes=$_POST['check'.$z];
		//echo "check0-->".$check0;
		
		if($rut_ausentes>0){
			
			
			
			$sql_dig = "select dig_rut from alumno where rut_alumno=$rut_ausentes";
			$rs_dig=@pg_exec($conn,$sql_dig);
			$fila_dig = @pg_fetch_array($rs_dig,0);
			$fila_dig['dig_rut'];
			
		    $cad_rut=$rut_ausentes.','.$cad_rut;
		
		//$ausente = $ausente."<mine:numero>".$rut_ausentes."</mine:numero> <mine:dv>".$fila_dig['dig_rut']."</mine:dv>";
	
		/*$ausente = $ausente."<mine:Run>
			                     <mine:numero>".$rut_ausentes."</mine:numero> 
								 <mine:dv>".$fila_dig['dig_rut']."</mine:dv>
								 </mine:Run>";*/
		
		
		 $ausente = $ausente."<sch:Run>
                        <sch:numero>".$rut_ausentes."</sch:numero>
                        <sch:dv>".$fila_dig['dig_rut']."</sch:dv>
                     </sch:Run>";

		}
		
		
		
	}
	$cad_rut = substr ($cad_rut, 0, strlen($cad_rut) - 1);
	$conc=(strlen($cad_rut)==0)?"":" and matricula.rut_alumno not in(".$cad_rut.") ";
		
	
	 
	// if($_PERFIL==0){
		  $qryp = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, 
alumno.ape_mat, matricula.nro_lista,matricula.fecha ,matricula.fecha_retiro,matricula.bool_ar 
FROM alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno 
and matricula.fecha <='".$separa_fecha[0]."-".$separa_fecha[1]."-".$separa_fecha[2]."' 
 WHERE matricula.id_curso=".$cmb_curso."
  $conc 
  ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
 
		/* }
	 else{
	  $qryp = "SELECT alumno.rut_alumno,alumno.dig_rut , alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista  
		FROM alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno 
		WHERE matricula.id_curso=".$cmb_curso." AND matricula.bool_ar=0 $conc";
		$qryp.="ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
		
		
	 }*/
		$rs_presente = @pg_Exec($conn,$qryp);
		
		
			
		for($xx=0;$xx<@pg_numrows($rs_presente);$xx++){
			$fila = pg_fetch_array($rs_presente,$xx);
			//if($_PERFIL==0){
				
				if($fila["bool_ar"]==1 && strlen($fila["fecha_retiro"])>0 && $fila["fecha_retiro"]<=$separa_fecha[0]."-".$separa_fecha[1]."-".$separa_fecha[2] )
	{
	//echo $fila1["rut_alumno"]."--".$fila1["bool_ar"];
	}else{
		$prese=$prese."<sch:Run>
                        <sch:numero>".$fila['rut_alumno']."</sch:numero>
                        <sch:dv>".$fila['dig_rut']."</sch:dv>
                     </sch:Run>";
		}
				
				
			/*}else{
			
			$prese = $prese."<mine:numero>".$fila['rut_alumno']."</mine:numero> <mine:dv>".$fila['dig_rut']."</mine:dv> ";
			
			$prese=$prese."<mine:Run>
							<mine:numero>".$fila['rut_alumno']."</mine:numero> 
							<mine:dv>".$fila['dig_rut']."</mine:dv>
							</mine:Run>";
							
							$prese=$prese."<sch:Run>
                        <sch:numero>".$fila['rut_alumno']."</sch:numero>
                        <sch:dv>".$fila['dig_rut']."</sch:dv>
                     </sch:Run>";
			}*/
							
		}
		/*if($_PERFIL==0){
			echo $prese;
	exit;
		}*/
require_once('../../../../../clases/soap/lib/nusoap.php');


$fecha=str_replace("/","-",$fecha_del_dia);


/***semilla curl*/
		$xml = '<?xml version="1.0" encoding="utf-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sch="http://wwwfs.mineduc.cl/Archivos/Schemas/">
   <soapenv:Header/>
   <soapenv:Body>
      <sch:EntradaSemillaServicios>
         <sch:ClienteId>'.$_CLIENTEID.'</sch:ClienteId>
         <sch:ConvenioId>'.$_CONVENIOID.'</sch:ConvenioId>
         <sch:ConvenioToken>'.$_TOKEN.'</sch:ConvenioToken>
      </sch:EntradaSemillaServicios>
   </soapenv:Body>
</soapenv:Envelope>';

if($_PERFIL==0){
$file=fopen(date("Y-m-d_H-i-s").'_'.$cmb_curso.'_'.$grado_curso.trim($letra_curso).'_'.trim($letra_curso).'_'.$ensenanza.'semilla_consulta.xml',"w+"); 
  fwrite ($file,$xml); 
  fclose($file); 

}

$urlx = "http://w7app.mineduc.cl/WsApiAutorizacion/services/SemillaServiciosSoapPort";

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
//curl_setopt($ch, CURLOPT_USERPWD, "user_name:password"); /* If required */
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if($response){
$xml_parser = xml_parser_create();
xml_parse_into_struct($xml_parser, $response, $vals, $index);
xml_parser_free($xml_parser);

 $semilla = $vals[3]['value'];
 
  //guardar mensaje de semilla
 $sql_his1="insert into asistencia_sige_historia(rbd,id_ano,id_curso,fecha_envio,fecha_operacion,tipo,cod_respuesta,mensaje_respuesta,hora_operacion)values($_INSTIT,$_ANO,$_CURSO,'$fecha_del_dia','".date("Y-m-d")."',1,0,'$semilla','".date("H:i:s")."')";
 $rs_his1 = pg_exec($conn,$sql_his1);


}

if($_PERFIL==0){
if (file_put_contents ('./'.date("Y-m-d_H-i-s").'_'.$cmb_curso.'_'.$grado_curso.trim($letra_curso).'_'.trim($letra_curso).'_'.$ensenanza.'semilla_respuesta.xml', $response) !== false) {
  /* echo"<script type='text/javascript'>
		alert('Semilla ok');
	</script>";*/
} else {
    // echo 'Failed';
}
}





	//$oSoapClient1 = new nusoap_client('http://dido.mineduc.cl:9080/WsApiAutorizacion/wsdl/SemillaServiciosSoapPort.wsdl',true);
	$oSoapClient1 = new nusoap_client('http://w7app.mineduc.cl/WsApiAutorizacion/wsdl/SemillaServiciosSoapPort.wsdl',true);
								
		// Se pudo conectar?
		$err = $oSoapClient1->getError();
		if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
		} 
		
		/*************************SOLICITO VALOR SEMILLA************************************************/	
		
		
		
		
		
		
		/*
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
		
			echo '<h2>Fault 1</h2><pre>';
			print_r($resultado1);
			echo '</pre>';
		
		} else {
		
			$err = $oSoapClient1->getError();
			
			if ($err) {
				echo '<h2>Error2</h2><pre>'.$err.'</pre>';
			} else {
				/*echo '<h2>Result</h2><pre>';
				print_r($resultado1);
				echo '</pre>';*/
			/* }
		
		}*/
		
		/***************************CONSULTO POR ASISTENCIA*************************************************/
		
		
		//$nuevoCliente = new SoapClient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/AsistenciaSigeSoapPort.wsdl',true);
		$nuevoCliente = new SoapClient('http://w7app.mineduc.cl/WsApiMineduc/wsdl/AsistenciaSigeSoapPort.wsdl',true);
                $error = $nuevoCliente->getError();
                if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} else{
					//echo '<h2>Conectado</h2>';
					
				}

                 				
/*$StrXml2 = '<mine:EntradaAddAsistenciaSige xmlns:mine="http://dido.mineduc.cl/Archivos/Schemas/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://dido.mineduc.cl/Archivos/Schemas/ http://dido.mineduc.cl/Archivos/Schemas/EntradaAddAsistenciaSige.xsd"> 
		<mine:RecordAsistenciaSige> 
		<mine:AnioEscolar>'.$nro_ano.'</mine:AnioEscolar> 
		<mine:RBD>'.$rdb.'</mine:RBD> 
		<mine:CodigoTipoEnsenanza>'.$ensenanza.'</mine:CodigoTipoEnsenanza> 
		<mine:CodigoGrado>'.$grado_curso.'</mine:CodigoGrado> 
		<mine:FechaAsistencia>'.$fecha.'</mine:FechaAsistencia> 
		<mine:Cursos>
		<mine:Curso> 
		<mine:LetraCurso>'.trim($letra_curso).'</mine:LetraCurso> 
		<mine:Presentes>'; 
		$StrXml2.=$prese; 
		$StrXml2.='</mine:Presentes>
		<mine:Ausentes>'; 
		$StrXml2.=$ausente;
		$StrXml2.='</mine:Ausentes> 
		</mine:Curso> 
		</mine:Cursos> 
		</mine:RecordAsistenciaSige> 
		<mine:Semilla>'.$semilla.'</mine:Semilla> 
		</mine:EntradaAddAsistenciaSige>';*/
		
		
		
		
		
		$xml2='
		
		<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sch="http://dido.mineduc.cl/Archivos/Schemas/">
   <soapenv:Header/>
   <soapenv:Body>
      <sch:EntradaAddAsistenciaSige>
         <sch:RecordAsistenciaSige>
            <sch:AnioEscolar>'.$nro_ano.'</sch:AnioEscolar>
            <sch:RBD>'.$rdb.'</sch:RBD>
            <sch:CodigoTipoEnsenanza>'.$ensenanza.'</sch:CodigoTipoEnsenanza>
            <sch:CodigoGrado>'.$grado_curso.'</sch:CodigoGrado>
            <sch:FechaAsistencia>'.$fecha.'</sch:FechaAsistencia>
            <sch:Cursos>
               <!--1 or more repetitions:-->
               <sch:Curso>
                  <sch:LetraCurso>'.trim($letra_curso).'</sch:LetraCurso>
                 	<sch:Presentes>'; 
					$xml2.=$prese; 
					$xml2.='</sch:Presentes>
					<sch:Ausentes>'; 
					$xml2.=$ausente;
					$xml2.='</sch:Ausentes> 
               </sch:Curso>
            </sch:Cursos>
         </sch:RecordAsistenciaSige>
         <sch:Semilla>'.$semilla.'</sch:Semilla>
      </sch:EntradaAddAsistenciaSige>
   </soapenv:Body>
</soapenv:Envelope>';

if($_PERFIL==0){
$file=fopen(date("Y-m-d_H-i-s").'_'.$cmb_curso.'_'.$grado_curso.trim($letra_curso).'_'.trim($letra_curso).'_'.$ensenanza.'asistencia_consulta.xml',"w+"); 
  fwrite ($file,$xml2); 
  fclose($file); 
}

$urly = "http://w7app.mineduc.cl/WsApiMineduc/services/AsistenciaSigeSoapPort";

$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $urly);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);

$headers2 = array();
array_push($headers2, "Content-Type: text/xml; charset=utf-8");
array_push($headers2, "Accept: text/xml");
array_push($headers2, "Cache-Control: no-cache");
array_push($headers2, "Pragma: no-cache");
array_push($headers2, "SOAPAction: http://api.soap.website.com/WSDL_SERVICE/GetShirtInfo");
if($xml2 != null) {
    curl_setopt($ch2, CURLOPT_POSTFIELDS, "$xml2");
    array_push($headers2, "Content-Length: " . strlen($xml2));
}
//curl_setopt($ch, CURLOPT_USERPWD, "user_name:password"); /* If required */
curl_setopt($ch2, CURLOPT_POST, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);
$response = curl_exec($ch2);
$code2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
curl_close($ch2);
if($_PERFIL==0){
if (file_put_contents ('./'.date("Y-m-d_H-i-s").'_'.$cmb_curso.'_'.$grado_curso.trim($letra_curso).'_'.trim($letra_curso).'_'.$ensenanza.'asistencia_respuesta.xml', $response) !== false) {
  /* echo"<script type='text/javascript'>
		alert('asistencia ');
	</script>";*/
} else {
   //  echo 'Failed';
}
}
        // $resul = $nuevoCliente->call('addAsistencia',$StrXml2);   

        /* if($nuevoCliente->fault){
            print_r($resul);
    }else{
            $err = $nuevoCliente->getError();
            if ($err){
                    echo $err;
            }else{*/
if($response){
	$xml_parser = xml_parser_create();
	xml_parse_into_struct($xml_parser, $response, $vals, $index);
	xml_parser_free($xml_parser);
	/*echo "<pre>";
	var_dump($vals);
	echo "</pre>";*/
	
	 $mensajes = $vals[3]['value'];		
	 $resultado = $vals[4]['value'];
	// $mensajes=1;	
	
	
	 		
	if($mensajes==1){
	echo"<script type='text/javascript'>
		alert('Operacion/Accion ejecutada exitosamente.');
	</script>";
	
	 //guardar mensaje de respuesta
 $sql_his1="insert into asistencia_sige_historia(rbd,id_ano,id_curso,fecha_envio,fecha_operacion,tipo,cod_respuesta,mensaje_respuesta,hora_operacion)values($_INSTIT,$_ANO,$_CURSO,'$fecha_del_dia','".date("Y-m-d")."',2,$mensajes,'$resultado','".date("H:i:s")."')";
 $rs_his1 = pg_exec($conn,$sql_his1);
	
	$sql_del="delete from asistencia where ano=".$ano." and id_curso=".$cmb_curso." and fecha='".$fecha_del_dia."'";
	$rs_delete=pg_exec($conn,$sql_del)or die("Fallo delete - ".$sql_del);
	
	for ($z=0 ; $z<=60 ; $z++){
	
	$rut_ausentes=$_POST['check'.$z];
	//echo "check0-->".$check0;
	
	if($rut_ausentes>0){
	}else{
	continue;	
	}
	$fecha_del_dia=str_replace("/","-",$fecha_del_dia);
	 $sql_guarda_asis="insert into asistencia (rut_alumno,ano,id_curso,fecha) values (".$rut_ausentes.",".$ano.",".$cmb_curso.",'".$fecha_del_dia."')";
	$rs_insert=pg_exec($conn,$sql_guarda_asis)or die("fallo insert - " .$sql_guarda_asis);
	
	//if($_PERFIL==0){echo $sql_guarda_asis."<br>";}
	
	}			
				
	//if($_PERFIL==0){exit;}
	
	$sql_update="update public.asistencia_sige set estado=0 where rdb=$rdb and id_ano=$ano and id_curso=$cmb_curso and fecha='$fecha' ";
	$rs_update = pg_exec($conn,$sql_update);		
				
	 $sql_insert_codigo="INSERT INTO 
						public.asistencia_sige
						( rdb,
						  id_ano,
						  id_curso,
						  fecha,
						  codigo_sige,
						  estado,
						  hora,
						  usuario,
						  estado_sige) 
						VALUES (".$rdb.",".$ano.",".$cmb_curso.",'".$fecha."','".$resultado."',1,'".date('H:i:s')."','".$_NOMBREUSUARIO."',0);";
						$result_insert=@pg_exec($conn,$sql_insert_codigo)or die("fallo ins as.s".$sql_insert_codigo);
						
				
	
	}else if($mensajes==2){
		
		
			for($x=0;$x<count($vals);$x++){
			if($vals[$x]['tag']=='MENSAJE'){
				$arm[]=$vals[$x]['value'];
				$sql_his1="insert into asistencia_sige_historia(rbd,id_ano,id_curso,fecha_envio,fecha_operacion,tipo,cod_respuesta,mensaje_respuesta,hora_operacion)values($_INSTIT,$_ANO,$_CURSO,'$fecha_del_dia','".date("Y-m-d")."',2,$mensajes,'".$vals[$x]['value']."','".date("H:i:s")."')";
 $rs_his1 = pg_exec($conn,$sql_his1);
				}
			}
	
		
	$ms="";
	if(count($arm)>0){
	$ms.='\r';
	for($m=0;$m<count($arm);$m++){
	 $ms.='\n'.$arm[$m];	
		}
	}
	
	
	
	?><script type='text/javascript'>
	alert('Error(es) de Validacion(es) de Negocio.<?php echo $ms ?>');</script>
	
	<?
	
	}else if($mensajes==3){
	echo"<script type='text/javascript'>
		alert('RDB NO tiene Servicio Disponible.');
	</script>";
	
	 $sql_his1="insert into asistencia_sige_historia(rbd,id_ano,id_curso,fecha_envio,fecha_operacion,tipo,cod_respuesta,mensaje_respuesta,hora_operacion)values($_INSTIT,$_ANO,$_CURSO,'$fecha_del_dia','".date("Y-m-d")."',2,$mensajes,'$resultado','".date("H:i:s")."')";
 $rs_his1 = pg_exec($conn,$sql_his1);
	
	}else if($mensajes==4){
	echo"<script type='text/javascript'>
		alert('Convenio NO tiene asociado el RDB .');
	</script>";
	
	 $sql_his1="insert into asistencia_sige_historia(rbd,id_ano,id_curso,fecha_envio,fecha_operacion,tipo,cod_respuesta,mensaje_respuesta,hora_operacion)values($_INSTIT,$_ANO,$_CURSO,'$fecha_del_dia','".date("Y-m-d")."',2,$mensajes,'$resultado','".date("H:i:s")."')";
 $rs_his1 = pg_exec($conn,$sql_his1);
	
	}else if($mensajes==5){
	echo"<script type='text/javascript'>
		alert('Servicio NO Disponible.');
	</script>";
	 $sql_his1="insert into asistencia_sige_historia(rbd,id_ano,id_curso,fecha_envio,fecha_operacion,tipo,cod_respuesta,mensaje_respuesta,hora_operacion)values($_INSTIT,$_ANO,$_CURSO,'$fecha_del_dia','".date("Y-m-d")."',2,$mensajes,'$resultado','".date("H:i:s")."')";
 $rs_his1 = pg_exec($conn,$sql_his1);
	
	}else if($mensajes==6){
	echo"<script type='text/javascript'>
		alert('Semilla de operacion NO valida o ha caducado. (renovar semilla)');
	</script>";
	 $sql_his1="insert into asistencia_sige_historia(rbd,id_ano,id_curso,fecha_envio,fecha_operacion,tipo,cod_respuesta,mensaje_respuesta,hora_operacion)values($_INSTIT,$_ANO,$_CURSO,'$fecha_del_dia','".date("Y-m-d")."',2,$mensajes,'$resultado','".date("H:i:s")."')";
 $rs_his1 = pg_exec($conn,$sql_his1);
	
	}else if($mensajes==7){
	echo"<script type='text/javascript'>
		alert('Error Interno de Servicio');
	</script>";
	 $sql_his1="insert into asistencia_sige_historia(rbd,id_ano,id_curso,fecha_envio,fecha_operacion,tipo,cod_respuesta,mensaje_respuesta,hora_operacion)values($_INSTIT,$_ANO,$_CURSO,'$fecha_del_dia','".date("Y-m-d")."',2,$mensajes,'$resultado','".date("H:i:s")."')";
 $rs_his1 = pg_exec($conn,$sql_his1);
	}
	
	
	
	}
   //}
	// } //fin for
	
	
    '<h2>Debug</h2><pre>'.htmlspecialchars($nuevoCliente->debug_str, ENT_QUOTES).'</pre>';
	
	   echo "<script>window.location = 'asistencia_sige.php'</script>";
	

?>














