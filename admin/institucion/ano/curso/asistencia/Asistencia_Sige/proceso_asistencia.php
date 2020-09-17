<?php 	require('../../../../../../util/header.inc');
 pg_dbname($conn);

print_r($_POST);

echo"curso-->".$cmb_curso = $_CURSO;
$ano = $_ANO;
echo"----->".$rdb= $_INSTIT;
$ensenanza=$ensenanza;
echo "<br>";

	$qry0="select nro_ano from ano_escolar where id_ano=".$ano;
	$result0=@pg_Exec($conn,$qry0);
	$fila0	= @pg_fetch_array($result0,0);
	$nro_ano=$fila0['nro_ano'];

	echo $sql_cur = "select * from curso where id_curso=$cmb_curso";
	$result_c=@pg_Exec($conn,$sql_cur);
	$fila_c	= @pg_fetch_array($result_c,0);
	$grado_curso=$fila_c['grado_curso'];
	$letra_curso=$fila_c['letra_curso'];





	$dia_maximo = date("d");
	

	$qry = " SELECT alumno.rut_alumno ||'-'|| alumno.dig_rut AS ausente, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista  ";
	$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
	$qry = $qry . " WHERE ((matricula.id_curso=".$cmb_curso.") AND (matricula.bool_ar=0)) ";
	$qry = $qry . " ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
	$result	= @pg_Exec($conn,$qry);
	
	
	for ($z=1 ; $z<=$dia_maximo ; $z++){
		$X=0;
		$dia=$z;
		$total_alumnos = @pg_numrows($result);	
		for($i=0; $i<@pg_numrows($result); $i++){
			$X++;
			$filaAlu	= @pg_fetch_array($result,$i);
			$alu		= $filaAlu['ausente'];
		
			$vv1="a_".$X."_".$z;
			
			if($_POST[$vv1]=="on"){					
				if ($dia < 10){
					$fecha=("0".$dia."-".$cmbMes."-".$nro_ano);
				}else{
					$fecha=($dia."-".$cmbMes."-".$nro_ano);
				}	
				 "<br> ALUMNO AUSENTE-->".$alu."-->".$fecha;
					$rut_al=$alu.','.$rut_al;
					$cadena[$z]= $cadena[$z].",".$alu;
			}
		}
	}
	
	echo "<br>";
	echo"zzz----->".($z);
	echo "<br>";
	echo"cadena----->".print_r($cadena);
	echo "<br>";
	//echo count($cadena);
	"<br><br>";
	 "-->".$rut_al;
	
	$cad_rut = substr ($rut_al, 0, strlen($cad_rut) - 1);
	
	for ($z=1 ; $z<=$dia_maximo ; $z++){
		
		$cat = substr($cadena[$z],1,strlen($cadena[$z]));
		if($cat!=""){
			$rut = substr($cat,0,8);
			$dig = substr($cat,9,1);
			$ausente = $ausente."<mine:Run>
			                     <mine:numero>".$rut."</mine:numero> 
								 <mine:dv>".$dig."</mine:dv>
								 </mine:Run>";
		}
		$qry = " SELECT alumno.rut_alumno,alumno.dig_rut , alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista  
		FROM alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno 
		WHERE matricula.id_curso=".$cmb_curso." AND matricula.bool_ar=0 ";
		if($cat!=""){
		$qry.=" and matricula.rut_alumno not in(".substr($cat,0,8).") ";
		}
		$qry.="ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
		
	    $rs_presente	= @pg_Exec($conn,$qry) or die(pg_last_error($conn));
		
		for($x=0;$x<@pg_numrows($rs_presente);$x++){
			$fila = pg_fetch_array($rs_presente,$x);
			
			$prese = $prese."<mine:Run>
							<mine:numero>".$fila['rut_alumno']."</mine:numero> 
							<mine:dv>".$fila['dig_rut']."</mine:dv>
							</mine:Run>";
		}
		
		
		//include(webservice);
	}
	



require_once('../../../../../clases/soap/lib/nusoap.php');

//$fecha='2012-05-07';
//echo "FECHAAAAAAAAAA!!!!---->".$fecha=date('Y-m-d');

for ($z=1 ; $z<=$dia_maximo ; $z++){
	$sql="select m.rut_alumno,al.dig_rut,c.id_ano,c.ensenanza,c.grado_curso,c.letra_curso from curso c
	inner join matricula m on c.id_curso=m.id_curso
	inner join alumno al on m.rut_alumno=al.rut_alumno
	where c.id_ano=1166 and c.ensenanza=$ensenanza and c.grado_curso=$grado_curso and c.letra_curso='$letra_curso'";
	$rs_curso=@pg_exec($conn,$sql)or die(pg_last_error($sql));
	
    

	$oSoapClient1 = new nusoap_client('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/SemillaServiciosSoapPort.wsdl',true);
								
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
		</EntradaSemillaServicios>'; 
		*/
			$StrXml1 = '<EntradaSemillaServicios xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd"
		 xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
		<ClienteId>'.$_CLIENTEID.'</ClienteId>
			<ConvenioId>'.$_CONVENIOID.'</ConvenioId>
			<ConvenioToken>'.$_TOKEN.'</ConvenioToken>
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
					echo '<h2>Conectado'.$z.'</h2>';
					
				}
                             
                                                                                                                                 		               
                 				
$StrXml2 = '<mine:EntradaAddAsistenciaSige xmlns:mine="http://dido.mineduc.cl/Archivos/Schemas/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://dido.mineduc.cl/Archivos/Schemas/ http://dido.mineduc.cl/Archivos/Schemas/EntradaAddAsistenciaSige.xsd"> 
		<mine:RecordAsistenciaSige> 
		<mine:AnioEscolar>'.$nro_ano.'</mine:AnioEscolar> 
		<mine:RBD>'.$rdb.'</mine:RBD> 
		<mine:CodigoTipoEnsenanza>'.$ensenanza.'</mine:CodigoTipoEnsenanza> 
		<mine:CodigoGrado>'.$grado_curso.'</mine:CodigoGrado> 
		<mine:FechaAsistencia>'.$fecha.'</mine:FechaAsistencia> 
		<mine:Cursos>
		<mine:Curso> 
		<mine:LetraCurso>'.$letra_curso.'</mine:LetraCurso> 
		<mine:Presentes>'; 
		$StrXml2.=$prese; 
		$StrXml2.='</mine:Presentes>
		<mine:Ausentes>'; 
		$StrXml2.=$ausente;
		$StrXml2.='</mine:Ausentes> 
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
				echo"<pre>";
                    print_r($resul['CodigoEnvioAsistencia']);
				echo"</pre>";
				echo"<pre>";
				print_r($resul['ListadoMensajes']);
				echo"</pre>";
				
				
				
		$StrXml3='<mine:EntradaGetReporteEnvioAsistenciaSige xmlns:mine="http://dido.mineduc.cl/Archivos/Schemas/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://dido.mineduc.cl/Archivos/Schemas/ http://dido.mineduc.cl/Archivos/Schemas/EntradaGetReporteEnvioAsistenciaSige.xsd"> 
		<mine:RBD>'.$rdb.'</mine:RBD> 
		<mine:CodigoEnvioAsistencia>'.$resul['CodigoEnvioAsistencia'].'</mine:CodigoEnvioAsistencia> 
		<mine:Semilla>'.$resultado1[ValorSemilla].'</mine:Semilla> 
		</mine:EntradaGetReporteEnvioAsistenciaSige>';		
				
			  $resul_codigo = $nuevoCliente->call('getReporteEnvioAsistencia',$StrXml3);   

         if($nuevoCliente->fault){
            print_r($resul_codigo);
    }else{
            $err = $nuevoCliente->getError();
            if ($err){
                    echo $err;
            }else{
                print_r($resul_codigo);
                echo "PASOOOO CODIGO!!";
				echo"<pre>";
                    echo "--->".$resul_codigo['CodigoRespuestaReporteEnvioAsistencia'];
				echo"</pre>";
				echo"<pre>";
                    echo "--->".$resul_codigo['ListadoMensajes'];
				echo"</pre>";
			
			
			}
			}
	 }
  }       
                
}
	// } //fin for
     echo '<h2>Debug</h2><pre>'.htmlspecialchars($nuevoCliente->debug_str, ENT_QUOTES).'</pre>';
?>














