<?php require('../../../../../../util/header.inc');
include('../../../../../clases/class_Membrete.php');
include('../../../../../clases/class_MotorBusqueda.php');
include('../../../../../clases/class_Reporte.php');

	//setlocale("LC_ALL","es_ES")	;
	//---------------------------
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$alumno			=$_POST['cmb_alumno'];
	$reporte		=$c_reporte;
	
	
	

?>



<script language="javascript1.1" type="text/javascript">
function Imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	guardaImp();
	document.getElementById("capa0").style.display='block';
}


function guardaImp(){
	var ano =<?php echo $_ANO ?>;
	var curso =<?php echo $cmb_curso ?>;
	var alumno =<?php echo $alumno ?>;
	var reporte =<?php echo $c_reporte ?>;
	var parametros ="ano="+ano+"&curso="+curso+"&alumno="+alumno+"&reporte="+reporte;

	var cuenta=2;
	var cad_cuenta="";
	for(i=0;i<cuenta;i++){
		cad_cuenta = cad_cuenta+"../";
	}
	
	$.ajax({
		url:cad_cuenta+'cuentaRepo/cuentaRepo.php',
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
		}
	})
}

</script>
<?





	
	if($_PERFIL==15 or $_PERFIL==16){
		$alumno = $_ALUMNO;	
		$sql="SELECT id_curso FROM matricula WHERE id_ano=".$_ANO." AND rut_alumno=".$_ALUMNO;
		$rs_curso = pg_exec($conn,$sql);
		$curso 	= pg_result($rs_curso,0);
	}else {
		$alumno = $cmb_alumno;	
		$curso 	= $cmb_curso;
	}
	$_POSP = 6;
	$_bot = 8;
	
	//---------------------------
	if ($curso==0){?>
	  <!--	<script>alert("Debe seleccionar el Curso")</script> -->
	<? //exit;
	 }
	
	if ($alumno==0){?>
		<!--<script>alert("Debe seleccionar el Alumno")</script> -->	
	<? //exit;
	 }	
	 
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();	 
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;

	/************ CURSO ********************/	
	$Curso_pal =($institucion!=1717)?CursoPalabra2($curso, 0, $conn):CursoPalabra1($curso, 6, $conn);	
	


		//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	 
$institucion= $_INSTIT;
$sci  = "select num_corp from corp_instit where rdb = $institucion";
$rci= pg_exec($connection,$sci);
$corp = pg_result($rci,0);
	
	if ($alumno == 0){
		
	}else{
		
		
		
		
		$ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano = $ano;
		$rsAlumno= $ob_reporte->FichaAlumnoUno($conn);
		$fila= @pg_fetch_array($rsAlumno,0);
		$ob_reporte ->CambiaDato($fila);
		
		$sexo = $ob_reporte ->sexo;
		$Curso_pal  = ucwords($Curso_pal);
		if ($sexo == "Masculino"){
			$tipo1 = "alumno";
			$tipo2 = "del interesado";
			$tipo3 = "inscrito";
		}else{
			$tipo1 = "alumna";
			$tipo2 = "de la interesada";
			$tipo3 = "inscrita";
		}			
	}
	
	
	/************** FIRMA ***********************/
		$ob_reporte->rdb=$institucion;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		$ob_reporte->item=$reporte;
		
	
		
	if($_POST['cod_ver']==1){	
	
	//grabar codigo
	$ob_reporte ->alumno =$alumno;
	$ob_reporte->codigo=$frase;
	$ob_reporte->id_base=$_ID_BASE;
	$ob_reporte->curso=$curso;
	$ob_reporte->tipo_certificado=$c_reporte;
	$encriptado = encriptar_AES($curso.$alumno);
    $ob_reporte->codigo = $encriptado;
	$ob_reporte->fecha_emision=date("Y-m-d");
	$ob_reporte->hora_emision=date("H:i:s");
	$ob_reporte->grabaCodigo($connection);
	
	//----------
	}

	Function rutF($txt){
		if ($txt!=0){
			$largo=strlen($txt);
			if ($largo==9){
				$millon =substr (($txt), 0,2); 
				$centena = substr (($txt), 2,3); 
				$decena = substr (($txt), 5,3); 
				$exten = substr (($txt), -1); 
			}else{
				$millon =substr (($txt), 0,1); 
				$centena = substr (($txt), 1,3); 
				$decena = substr (($txt), 4,3); 
				$exten = substr (($txt), -1); 
			}
		$txt = $millon.".".$centena.".".$decena." - ".$exten;
		echo $txt;
		}
	}
		//----------
		$sql_curso = "select ensenanza, cod_es, cod_sector, cod_rama,grado_curso from curso where id_curso=" . $curso;
		$result_curso = @pg_exec($conn,$sql_curso);
		$fila_curso = @pg_fetch_array($result_curso,0);
		$Ense = $fila_curso['ensenanza'];
		$Espec = $fila_curso['cod_es'];
		$Sector = $fila_curso['cod_sector'];
		$Rama = $fila_curso['cod_rama'];
		$Grado = $fila_curso['grado_curso'];
		
		if ($Ense >310){
			$sql_esp = "select nombre_esp from especialidad where cod_esp=" .$Espec." and cod_sector=".$Sector." and cod_rama=".$Rama;
			$result_esp = @pg_exec($conn,$sql_esp);
			$fila_esp = @pg_fetch_array($result_esp,0);
			$Especialidad = $fila_esp['nombre_esp'];
		}
		
			$sql_Mat = "select num_mat from matricula where rut_alumno='" .$alumno."' and id_ano=".$ano;
			$result_Mat= @pg_exec($conn,$sql_Mat);
			$fila_Mat = @pg_fetch_array($result_Mat,0);
			$numero = $fila_Mat['num_mat'];
	//----------
	//----------
	$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp, trabaja.cargo FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo='1' OR trabaja.cargo='23')";

	    /*$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
		$sql = $sql . "WHERE (((trabaja.rdb)=".$institucion.") AND ((trabaja.cargo)=1)); ";*/
		$result =@pg_Exec($conn,$sql);
	
		$fila = @pg_fetch_array($result,0);
				
		
		if($institucion!=40251){
		$Nombre_Direc = strtoupper(trim(trim($fila['nombre_emp']. " " .$fila['ape_pat']) . " " . trim($fila['ape_mat'])  ));
		}else{
			
				
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->empleado=$ob_config->empleado1;
				$ob_reporte->nombre_emp;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				$Nombre_Direc = $ob_reporte->nombre_emp;
		}
        $cargo_dir    = $fila['cargo'];	
		
		
	if ($cargo_dir==1){
	    $cargo_dir  = "Director(a)";
		$cargo_dir2 = "Director(a)";
		
		if ($institucion==24977){
		     $cargo_dir2 = "Rector(a)";
		}
		if ($institucion==5661){
		     $cargo_dir = "Director(a)";
		}
		
	}
	if ($cargo_dir==23){
	    $cargo_dir  = "Rector(a)";
		$cargo_dir2 = "Rector(a)";
	}		



if($cb_ok!="Buscar"){
	$xls=1;
}

	 
if($xls==1){
$fecha_actual = date('d/m/Y-H:i:s');	 
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Certificado_alumno_regular_$fecha_actual.xls"); 	 
}	 

function CursoPalabra2($id_curso, $tipo, $conn){


	// $tipo = 0 - palabra completa

	// $tipo = 1 - iniciales

	// $tipo = 2 - palabra completa solo curso sn enseñanza

	// $tipo = 3 - iniciales solo curso sn enseñanza

	

	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";

	$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";

	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$id_curso."));";
	
	$result_curso =@pg_Exec($conn,$sql_curso);

	$fila_curso = @pg_fetch_array($result_curso,0);	



	if ( ($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987) or ($fila_curso['cod_decreto']==2572010) )){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal2 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));

				

	}else if ( ($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==121987) or ($fila_curso['cod_decreto']==1521989)) ){

		$Curso_pal0 =  "PRIMER CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "PC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "PRIMER CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]));				

		$Curso_pal3 = "PC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

				

	}else if ( ($fila_curso['grado_curso']==1) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "SALA CUNA - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "SALA CUNA - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

						

	}
	else if ( (($fila_curso['grado_curso']==3)) and ($fila_curso['cod_decreto']==5842007) and (($fila_curso['ensenanza']==167) or ($fila_curso['ensenanza']==165))){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "NB3 (7 Y 8 BASICO)- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal3 = "NB3 - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
											
	}
	else if ( ($fila_curso['grado_curso']==2) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){

		$Curso_pal0 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal2 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));

				

	}else if ( ($fila_curso['grado_curso']==3) and ($fila_curso['cod_decreto']==121987) ){

		$Curso_pal0 =  "SEGUNDO CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "SEGUNDO CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

						

	}else if ( ($fila_curso['grado_curso']==2) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "NIVEL MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "NMME - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "NIVEL MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "NMME - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

						

	}else if (($fila_curso['grado_curso']==3) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987) ) ){

		$Curso_pal0 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	  
		 		
		
		
	}else if ( ($fila_curso['grado_curso']==4) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==771982)) ){

		$Curso_pal0 =  "CUARTO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "CN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "CUARTO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "CN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   			

						
	}else if (($fila_curso['grado_curso']==3) and (($fila_curso['cod_decreto']==2572010) ) ){

		$Curso_pal0 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	  
		
	}else if (($fila_curso['grado_curso']==4) and (($fila_curso['cod_decreto']==2572010) ) ){

		$Curso_pal0 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	  
		
		
		
	}else if ( ($fila_curso['grado_curso']==3) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "NMMA - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "NMMA - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
		
		$Curso_pal4 =  "PLAY GROUP - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

						

	}else if ( ($fila_curso['grado_curso']==4) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "TRANSICIÓN 1er NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "T1N - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "TRANSICIÓN 1er NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));

		$Curso_pal3 = "T1N - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
		
		$Curso_pal4 =  "PRE KINDER - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		
		$Curso_pal6 =  "PRE KINDER - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	

						

	}else if ( ($fila_curso['grado_curso']==5) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "TRANSICIÓN 2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "T2N - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "TRANSICIÓN 2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "T2N - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "KINDER - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		
		$Curso_pal6 =  "KINDER - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));			

	
		

	}else if ( ($fila_curso['grado_curso']>0) and ($fila_curso['grado_curso']<5 ) and ($fila_curso['cod_decreto']==771982)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));						

		

	}else if ( (($fila_curso['grado_curso']==5) or ($fila_curso['grado_curso']==6 )) and ($fila_curso['cod_decreto']==771982)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));								



	}else if ( (($fila_curso['grado_curso']==7) or ($fila_curso['grado_curso']==8 )) and ($fila_curso['cod_decreto']==771982)){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));								



	}else if ( (($fila_curso['grado_curso']>0) and ($fila_curso['grado_curso']<5 )) and ($fila_curso['cod_decreto']==461987)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												



	}else if ( (($fila_curso['grado_curso']==5) or ($fila_curso['grado_curso']==6 )) and ($fila_curso['cod_decreto']==461987)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												



	}else if ( (($fila_curso['grado_curso']==1)) and ($fila_curso['cod_decreto']==2392004)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
	
	}else if ( (($fila_curso['grado_curso']==3)) and ($fila_curso['cod_decreto']==2392004)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));			
		
	}else if ( (($fila_curso['grado_curso']==2)) and ($fila_curso['cod_decreto']==5842007)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
		
	}else if ( (($fila_curso['grado_curso']==3)) and ($fila_curso['cod_decreto']==5842007)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
											
	}else if ((($fila_curso['grado_curso']==4)) and ($fila_curso['cod_decreto']==5842007)){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
	
	}else if ( (($fila_curso['grado_curso']==7) or ($fila_curso['grado_curso']==8)) and ($fila_curso['cod_decreto']==461987)){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

	}else if ( (($fila_curso['grado_curso']==8)) and ($fila_curso['cod_decreto']==2392004)){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

	}else if ( (($fila_curso['grado_curso']==3)) and ($fila_curso['cod_decreto']==2392004)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

																					

	}
	else if (($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==10002009) and ($fila_curso['ensenanza']==363)) ){

		$Curso_pal0 =  "PRIMER NIVEL MEDIO - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "PRIMER NIVEL MEDIO - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	 
			
		
	}
	else if (($fila_curso['grado_curso']==3)  and ($fila_curso['ensenanza']==363) ){

		$Curso_pal0 =  "SEGUNDO NIVEL MEDIO - ".ucwords(strtoupper($fila_curso["letra_curso"]." ".$fila_curso['nombre_tipo']));	   

		$Curso_pal1 =  "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		

		$Curso_pal2 =  "SEGUNDO NIVEL MEDIO - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	 
			
		
	}
	else{

		$Curso_pal0 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 

		$Curso_pal1 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 		

		$Curso_pal2 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 		

		$Curso_pal3 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 	
		$Curso_pal4 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 
		//$Curso_pal4 =  ucwords(strtoupper($fila_curso["grado_curso"] . "º AÑO DE " . $fila_curso['nombre_tipo']));
		
		$Curso_pal5 =  ucwords(strtoupper("AÑO DE ".$fila_curso['nombre_tipo'])); 
		
		$Curso_pal6 =  ucwords(strtoupper($fila_curso["grado_curso"] . "° AÑO " . $fila_curso["letra_curso"]." de ". $fila_curso['nombre_tipo']));		
	
	}

	if ($tipo == 0)

		return $Curso_pal0;

	if ($tipo == 1)

		return $Curso_pal1;

	if ($tipo == 2)

		return $Curso_pal2;

	if ($tipo == 3)

		return $Curso_pal3;				

	if ($tipo == 4)

		return $Curso_pal4;				

	if ($tipo == 5)

		return $Curso_pal5;	
	
	if ($tipo == 6)

		return $Curso_pal6;				

	
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'CertificadoAlumnoRegular.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
		
			
		function exportar(){
			window.location='printCertificadoAlumnoRegular_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
			return false;
		  }
		  
		  function exportarPDF(form){
			window.open('printCertificadoAlumnoRegularPDF.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&opcion=<?=$opcion?>&c_reporte=<?php $reporte?>&txtTIPO=<?=$txtTIPO?>&remitente=<?=$remitente?>&txtGLOSA=<?=$txtGLOSA?>','_blank');
			return false;
			
			
		  }
									
</script>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>

<script> 
function cerrar(){ 
window.close() 
} 
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS + 6;?>px;
 }

.Estilo1 {font-family: "Arial Narrow"}
.Estilo2 {
	font-family: Verdana;
	font-size: 9px;
	font-weight: bold;
}
.Estilo3 {font-size: 10}
.Estilo4 {font-size: 10px}
.Estilo6{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:9px;
	font-style:italic;
	color:#666666;
}
.Estilo5 {
	font-family: "Times New Roman", Times, serif;
	font-size: 36px;
	font-style: italic;
}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->

<?
if ($curso > 0 ){
   ?>
<center>
<form name="form" method="post" action="../../printCertificadoAlumnoRegular_C.php" target="_blank">
  <table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr align="right">
      <td>
        <div id="capa0">
		<table width="100%">
		  <tr><td><table>
          <tr>
            <td align="left"><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR">
            </td>
          </tr>
        </table>
          
		  </td>
		<td align="right">
		  <input name="button3"  type="button" class="botonXX" onClick="Imprimir()"  value="IMPRIMIR">
		<!--  <input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">-->
		<?php //if($_PERFIL==0){?>
        <!--  <input name="cb_exp2" type="button" onClick="exportarPDF(this.form)" class="botonXX"  id="cb_exp2" value="PDF">-->
         <?php  //}?>
          <input name="opcion" type="hidden" value="<?php echo $opcion ?>"></td>
		  </tr>
		  </table>
      </div></td>
    </tr>
  </table>
  
  
  
  
  <? 
  if ($opcion==2)
  {
  ?>
  	<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">
	           <?
			   if ($institucion==24977){ ?>
			          <table border="0" width="300" align="center">
			           <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;	
							   <?	
								$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
								$arr=@pg_fetch_array($result,0);
								$fila_foto = @pg_fetch_array($result,0);
								## código para tomar la insignia
								
								if($institucion!=""){
								echo "<img src='../../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
								}else{
								echo "<img src='".$d."menu/imag/logo.gif' >";
								}
								?>		   
					   </td>
					   </tr></table>
			   
			   
			  <? }
			  elseif($corp==9){?>
				  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr >
    <th width="120" align="left" scope="col"><img src="../../../../../../images/fodec.png" width="120" /></th>
    <th width="463" align="center" style="color:#900;">
    <em style="color:#036"><? echo (strtoupper($ob_membrete->ins_pal));?></em><br>
    <em>Fundaci&oacute;n  Oficio Diocesano de Educaci&oacute;n Cat&oacute;lica<br>
       &ldquo;Constructores  del Reino y Promotores de la Paz&rdquo;</em></th>
    <th width="159" align="center" valign="middle"><?
		if($institucion!=""){
			echo "<img src='../../../../../../tmp/".$institucion."insignia". "' alt='70' width='75' >";
		}else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
		}	?> </th>
    </tr>
</table>
				 <? }
			  else{ ?>	   
			   
					   <?	
						$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
						$arr=@pg_fetch_array($result,0);
						$fila_foto = @pg_fetch_array($result,0);
						## código para tomar la insignia
						
						if($institucion!=""){
						echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
						}else{
						echo "<img src='".$d."menu/imag/logo.gif' >";
						}
						?>
			
			<? } ?>	
		</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" ><center>
      <strong><font size="+2"><u>CERTIFICADO DE ALUMNO REGULAR</u></font></strong>
    </center></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">
      <table width="600" border="0" cellspacing="3" cellpadding="0">
        <tr>
    <td class="subitem"><div align="justify"><strong>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <?
		if($institucion == 24511){	
			echo "Meza Gotor Marcelo";
		}
		elseif($institucion==8905){
			echo "MARIELA ROSALBA ARAYA IGLESIAS";
			}
		else{
			echo strtoupper($Nombre_Direc);
		}
	?>, </strong> 
         <?
		if ($institucion==1593){ 
		     echo "Director";
		}
		/*else if($institucion==8905){
			echo "Director(a) Interino(a)";
			}*/
		else{
			 
		     if ($institucion==24977){
			      echo $cargo_dir2;
			 }else{
			      echo $cargo_dir;
			 }			 
             
			 if($institucion==14703){
			 echo "  ".strtoupper($ob_membrete->ins_pal).", Nº ".$institucion."-".$ob_membrete->dig_rdb;
			 
			 }else{
			 echo " del ".strtoupper($ob_membrete->ins_pal).", Nº ".$institucion."-".$ob_membrete->dig_rdb;
			 }
			 
			 
		}
		 
		?>,
      certifica que <strong><? $nombres=strtoupper($ob_reporte->nombres);
	  echo $ob_reporte->tildeM($nombres)?></strong> C&eacute;dula de Identidad Nº <?=$ob_reporte->rut_alumno;?>,
      es 
      <? echo $tipo1;?> regular del <? echo $Curso_pal, " ";?>
        <? 
		if ($institucion!=1518)
		echo $Especialidad; 
		
		?>
       de este Establecimiento Educacional, 
      año académico <?php echo $nro_ano ?>.</div></td>
  </tr>
      </table>
    </div></td>
  </tr>
  
 
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" class="subitem"><div align="justify"><em> <?=$remitente;?> </em></div></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">
      <table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
    <td><span class="subitem">&nbsp;&nbsp;&nbsp;Se extiende el presente certificado a petición del apoderado para los fines que estime conveniente.</span></td>
  </tr>
      </table>
    </div></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?
//crear generación de certificado
if($cod_ver==1){
?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" class="subitem"><div align="justify"><em>
C&oacute;digo de verificaci&oacute;n: <b><?php echo $encriptado ?></b>
</em></div></td>
  </tr>
</table>
<?
}

?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
	     <?
		if ($_INSTIT==25478){ ?>
			<!-- Firma y timbre -->
				<table width="570" border="0" align="right">
						<tr>
						  <td width="50%" align="center" valign="bottom"><!--<img src="firma_mayorpenalolen.jpg" width="210" height="74">--></td>
						  <td width="50%" align="center"><div align="left"><img src="../../timbre_mayorpenalolen.jpg" width="144" height="142"></div></td>
						</tr>
				</table>
			<!-- fin firma y timbre -->
	  <? } ?>
	  
	   <?
		if ($_INSTIT==24977){ ?>
			<!-- Firma y timbre -->
		  <table width="670" border="0" align="right">
						<tr>
						  <td width="25%" align="center" valign="bottom"><img src="../../timbre_mayortobalaba.jpg"></td>
						  <td width="75%" align="left"><!--/*<img src="../../firma_mayortobalaba.jpg" >*/--></td>
						</tr>
				</table>
			<!-- fin firma y timbre --> 
	  <? } ?>
      	
	</td>
  </tr>
   
  <tr>
    <td>
	     <!-- <table width="650" border="0" cellpadding="0" cellspacing="0">
          <?
			$sql4 = "SELECT empleado.rut_emp,empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
			$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
			$result =@pg_Exec($conn,$sql4);
			$fila = @pg_fetch_array($result,0);	
			$rut_emp=$fila['rut_emp'];
			
			$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
///////***********COMPRUEBA SI TIENE FIRMA DIGITAL*************////////	

if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg") && $crp==1 ){
"Archivo Firma 4 encontrado";
?>
 <tr> 
<?  $firmadig="<img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'>";?>
 <td>
   <div align="center"><strong><?=$firmadig?><font face="Arial, Helvetica, sans-serif" size="2">________________________________   </font></strong></div></td>
   
   
   
   	
 </tr>
 <tr> 
 <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2"><?=$cargo_dir2 ?>Establecimiento </font></div></td>
 </tr>
 <tr>

 <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1"> 
<?
  if($institucion == 24511){	
  echo "MEZA GOTOR MARCELO";
 }else{
  echo $Nombre_Direc;
}
 ?>
 </font></strong></div></td>
 </tr>-->
 
 <? }else{ ////////**********FIN COMPRUEBA FIRMA DIGITAL**********/////////
 ?>
			  <!--<script>alert('No Tiene Firma Digital');</script>-->
	                        
		  <!--<tr> 
          <?  
			if($ob_config->firma1!=0){
				
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg")  && $crp==1 ){
	 $firmadig1="<td align='center' width='25%' class='item' height='180'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='200' height='70'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
                
			<td width="25%" class="item" height="100"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center" class="item">
			  <?=$ob_reporte->nombre_emp;?> 
		    <br>
		    <?=$ob_reporte->nombre_cargo;?>
			</div></td>
			<? }} ?>
          -->
          
			<!--<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
		  </tr>
		  <tr> 
			<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2"><?=$cargo_dir2 ?> 
				Establecimiento </font></div></td>
		  </tr>
			<tr>
			
			<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1"> 
			<?
			if($institucion == 24511){	
				echo "MEZA GOTOR MARCELO";
			}
			else{
				echo $Nombre_Direc;
			}
		?>
				</font></strong></div></td>
		  </tr><? }?>
	  </table>	--></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
 
  <tr>
    <td  >
<br>

	<div align="center">
      <table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
    <td class="subitem" align="<?php echo $opc_fecha ?>"> <?   
	
	$fecha = ($_PERFIL==16 || $_PERFIL==15)?date("d-m-Y"):$txtFECHA; 
	 $txf = ($_INSTIT!=25478)?fecha_espanol($fecha):fecha_espanol_min($fecha);
	 ?><? echo (trim($ob_membrete->comuna). ", ". $txf)?></td>
  </tr>
      </table>
    </div>
     
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
   
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="Estilo2"><div align="center" class="Estilo3">
      <div align="center" class="Estilo4">
	 <?php
	   if ($institucion==24977){
	       echo "Av. Camilo Henríquez 4206 - Puente Alto | Teléfono: 874 1295 - Fax: 874 4163<br>";
	       echo "www.colegiomayor.cl/tobalaba";
	   }	   
	   if ($institucion==25478){
	       echo "Valle del Aconcagua 8031 - Peñalolén | Fono-Fax: 758 3100";
	   }	   
	 ?></div>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?
  }
  elseif($opcion==1)
  {
  if ($institucion=="770"){ 
	    // no muestro los datos de la institucion
	    // por que ellos tienen hojas pre-impresas
	    echo "<br><br><br><br><br><br><br><br><br><br>";
		   
	 }
	  elseif($corp==9){?>
				  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr >
    <th width="120" align="left" scope="col"><img src="../../../../../../images/fodec.png" width="120" /></th>
    <th width="463" align="center" style="color:#900;"> <em style="color:#036"><? echo (strtoupper($ob_membrete->ins_pal));?></em><br><em>Fundaci&oacute;n  Oficio Diocesano de Educaci&oacute;n Cat&oacute;lica<br>
       &ldquo;Constructores  del Reino y Promotores de la Paz&rdquo;</em></th>
    <th width="159" align="center" valign="middle"><?
		if($institucion!=""){
			echo "<img src='../../../../../../tmp/".$institucion."insignia". "' alt='70' width='75' >";
		}else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
		}	?> </th>
    </tr>
</table>
				 <? }
	 else{
	
		?>
		  <table width="699" border="0" cellspacing="0" cellpadding="0">
			<tr> 
			  <td width="431" align="left"  class="item"><? echo strtoupper($ob_membrete->ins_pal);?></td>
			  <td width="12">&nbsp;&nbsp;&nbsp;</td>
			  <td width="66" class="item">Regi&oacute;n</td>
			  <td width="190" class="item">:&nbsp;<? echo $ob_membrete->region;?></td>
			</tr>
			<tr> 
			  <td align="left" class="item"><? echo strtoupper($ob_membrete->direccion);?>&nbsp;</td>
			  <td>&nbsp;&nbsp;&nbsp;</td>
			  <td width="66" class="item">Provincia</td>
			  <td class="item">:&nbsp;<? echo $ob_membrete->provincia;?></td>
			</tr>
			<tr> 
			  <td align="left" class="item">FONO <? echo $ob_membrete->telefono;?></td>
			  <td>&nbsp;&nbsp;&nbsp;</td>
			  <td width="66" class="item">Comuna</td>
			  <td class="item">:&nbsp;<? echo $ob_membrete->comuna;?></td>
			</tr>
			<tr> 
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td width="66" class="item">Rbd</td>
			  <td class="item">:&nbsp;<? echo $institucion;?></td>
			</tr>
			<tr> 
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td width="66" class="item">A&ntilde;o Escolar</td>
			  <td class="item">:&nbsp;<? echo $nro_ano;?></td>
			</tr>
		  </table>
		  <br>
		  <table width="649" border="0" cellspacing="1" cellpadding="1">
		  <tr>
			  <td width="561" valign="top">
				<?	
				$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## código para tomar la insignia
				
				if($institucion!=""){
				echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
				}else{
				echo "<img src='".$d."menu/imag/logo.gif' >";
				}
				?>
				
			</td>
			
			</tr>
		</table>
   <? } ?>



<br><br>
  <table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr>
<?  if($institucion==770){ ?>
		<td align="center" bgcolor="#FFCC00"><center><font size="+2"><strong>CERTIFICADO DE ALUMNO REGULAR</strong></font></center></td>
<? }else{ ?>
	  <td align="center" class="tableindex"><center>
	    <font size="+2">CERTIFICADO DE ALUMNO REGULAR</font>
	  </center></td>
<? } ?>	  
    </tr>
	<tr> 
      <td valign="top" class="subitem"><div align="center"><strong>________________________________</strong></div></td>
    </tr>
  </table>
  <div align="left"><br>
    <br>
    <br>
  </div>
  <table width="650" border="0" cellspacing="0" cellpadding="0">
  <? if ($numero!=""){?>
    <tr> 
      <td class="subitem">Nº de Matrícula <strong><? echo $ob_reporte->num_matricula ?></strong></td>
    </tr>
    <tr> 
      <td class="subitem">&nbsp;</td>
    </tr>
	<? } ?>
    <tr> 
      <td width="346" class="subitem"><strong>
        <?
		if($institucion == 24511){	
			echo "Meza Gotor Marcelo";
		}
		elseif($institucion==8905){
			echo "MARIELA ROSALBA ARAYA IGLESIAS";
			}
		else{
			echo strtoupper($Nombre_Direc);
		}
	?>
        , </strong> 
           <?
		if ($institucion==1593){ 
		     echo "Director";
		}
		/*elseif($institucion==8905){
			echo "Director(a) Interino(a)";
			}*/
		else{ 			 
             echo $cargo_dir;
			 echo "del ";
		}	 
		?>	   
          </font><b><? echo strtoupper($ob_membrete->ins_pal);?></b>certifica que <strong><? echo $ob_reporte->tildeM(strtoupper($ob_reporte->nombres));?>, </strong>&nbsp;</div><b>R.U.T <? rutF($ob_reporte->rut_alumno2);?></b>&nbsp; es 
        <? echo $tipo1;?> regular del <b><? echo $Curso_pal, " ";?><? 
		if ($institucion!=1518)
		echo $Especialidad; 
		
		?></b> de este Establecimiento.</td>
    </tr>
	<tr><td colspan="3" class="subitem"><br><? echo $remitente;?></td></tr>
    <tr> 
      <td colspan="3" class="subitem"><br> Se 
        extiende el presente certificado a solicitud del apoderado para los fines 
        que estime conveniente.</td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
  </table>
  
  <?
//crear generación de certificado
if($cod_ver==1){
?><br> 
  <br>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" class="subitem"><div align="justify"><em>
C&oacute;digo de verificaci&oacute;n: <b><?php echo $encriptado ?></b>
</em></div></td>
  </tr>
</table>
<?
}

?>
  <br><br><br><br>
  
   <?php  
		 $ruta_timbre =6;
		 $ruta_firma =6;
		 include("../../firmas/firmas.php");?>
  <br><br><br>
  <table width="650" height="43" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr><? 
	$fecha = ($_PERFIL==16 || $_PERFIL==15)?date("d-m-Y"):$txtFECHA; 
	//$fecha = $txtFECHA ;
	$txf = ($_INSTIT!=25478)?fecha_espanol($fecha):fecha_espanol_min($fecha);
	?>
	 <td width="%" align="<?php echo ($opc_fecha=="left")?"left":"right" ?>"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo (trim($ob_membrete->comuna).", " . $txf)?></strong></font></td>
  </tr>
</table>
</form> 
</center>
    <p>
   
  <?
}elseif($opcion==3){
if($corp!=9){?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> <div align="center">
      <?	
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			## código para tomar la insignia
			
			if($institucion!=""){
			echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
			}else{
			echo "<img src='".$d."menu/imag/logo.gif' >";
			}
			?>
    </div></td>
  </tr>
  <tr>
    <td class="Estilo6"><div align="center"><em><font color="#666666"><? echo (strtoupper($ob_membrete->ins_pal));?></font></em></div></td>
  </tr>
  <tr>
    <td class="Estilo6"><div align="center" class="Estilo6"><? echo $ob_reporte->tilde(ucwords(strtolower($ob_membrete->direccion)));?></div></td>
  </tr>
  <tr>
    <td class="Estilo6"><div align="center"><em><font color="#666666"><? echo "Fono: ".$ob_membrete->telefono;?><? echo($institucion!=1603 && $institucion!=1717 )? " ":"";?></font></em></div></td>
  </tr>
  <tr>
    <td class="Estilo3"><div align="center"><em><font color="#666666"><? echo "e-mail: ".$ob_membrete->email;?></font></em></div></td>
  </tr>
  <tr>
    <td><hr color="#666666" style="border-collapse:collapse; height:1px"></td>
  </tr>
</table>
<?php } else{?>
				  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr >
    <th width="120" align="left" scope="col"><img src="../../../../../../images/fodec.png" width="120" /></th>
    <th width="463" align="center" style="color:#900;"> <em style="color:#036"><? echo (strtoupper($ob_membrete->ins_pal));?></em><br><em>Fundaci&oacute;n  Oficio Diocesano de Educaci&oacute;n Cat&oacute;lica<br>
       &ldquo;Constructores  del Reino y Promotores de la Paz&rdquo;</em></th>
    <th width="159" align="center" valign="middle"><?
		if($institucion!=""){
			echo "<img src='../../../../../../tmp/".$institucion."insignia". "' alt='70' width='75' >";
		}else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
		}	?> </th>
    </tr>
</table>
				 <? } ?>
<br>
<br>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center" class="Estilo5">CERTIFICADO ALUMNO REGULAR</div></td>
  </tr>
</table>
<br>
<br>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="">
  <tr>
    <td width="203" class="subitem"><em>Decreto Cooperador </em></td>
    <td width="447" class="subitem"><em><strong> Res. Exenta N&ordm; <?=$ob_membrete->nu_resolucion;?> A&ntilde;o <?=substr($ob_membrete->fecha_resol,0,4);?> </strong></em></td>
  </tr>
<? if ($institucion!=12838){?>
  <tr>
  <td class="subitem"><em>Rol Base de Datos </em></td>
  <td class="subitem"><em><strong>
      <?=$institucion."-".$ob_membrete->dig_rdb;?>
    </strong></em> 
	</td>
  </tr>
    <? }?> 
</table>
<br>
<br>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="3">
  <tr>
    <td class="subitem" style="line-height:150%"><div align="justify"><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>&nbsp;
        <?	
	
		 
		if($institucion==8905){
			echo "MARIELA ROSALBA ARAYA IGLESIAS";
		}
		else{
			echo strtoupper($Nombre_Direc);
		}?>, </em></strong>
            <em>
      <?
		if ($institucion==1593){ 
		     echo "Director";
		}
		/*else if($institucion==8905){
			echo "Director(a) Interino(a)";
			}*/
		else{ 
		     if ($institucion==24977){
			      echo $cargo_dir2;
			 }else{
			      echo $cargo_dir;
			 }			 
              if($institucion==14703 ){
			 echo "  ".trim(strtoupper($ob_membrete->ins_pal)).", ";
			 
			  }elseif($institucion==302){
				  echo "  de la ".trim(strtoupper($ob_membrete->ins_pal)).", ";
			  
			 }else{
			 echo " del ".trim(strtoupper($ob_membrete->ins_pal)).", ";
			 }
			
		}
		?>
      certifica que el(la) <?=$tipo1;?>, <strong>
        <? $nombres=strtoupper($ob_reporte->nombres);
	  echo ucwords(strtolower($ob_reporte->tilde($nombres)));?>
        </strong> C&eacute;dula de Identidad N&ordm;
            <? imp($ob_reporte->rut_alumno);?>,
            	<?
                if($txtTIPO !=""){
			
			echo "que cursa el"." ". $Curso_pal.",";
			}  ?>
           <?php  if($_INSTIT!=25478 && $_INSTIT!=1717){?>
            
      <?=$tipo3;?> <? if($institucion!=6835){ ?>en el Registro Escolar N&ordm; <? echo $ob_reporte->num_matricula ?>,<? } ?> a&ntilde;o <?=$nro_ano;?>,
      <?php }//if quita linea ,mayor peñalolen?>
       es
      
      <? 
	  	if($txtTIPO !=""){
			
			echo $txtTIPO;
			}else{
	  ?>
      
       <? 

	   echo $tipo1;
	   
			
	   ?>
       
       
        regular del Establecimiento Educacional, cursando el <? echo $Curso_pal, " ";?>
    <? 
		if ($rd_esp==1)
		echo $Especialidad; 
			}
		?>.</em></div></td>
  </tr>
</table>
<br>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" class="subitem"><div align="justify"><em> <?=$remitente;?> </em></div></td>
  </tr>
</table>

<br>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" class="subitem"><div align="justify"><em> <?=$txtGLOSA;?> </em></div></td>
  </tr>
</table>
<br>
<br><br>

<?
//crear generación de certificado
if($cod_ver==1){
?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" class="subitem"><div align="justify"><em>
C&oacute;digo de verificaci&oacute;n: <b><?php echo $encriptado ?></b>
</em></div></td>
  </tr>
</table>
<?
}

?>
<br>
<br>

<?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
<br>
<table width="600" height="43" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <? //  $fecha = $txtFECHA;
	
	$fecha = ($_PERFIL==16 || $_PERFIL==15)?date("d-m-Y"):$txtFECHA; 
	$txf = ($_INSTIT!=25478)?fecha_espanol($fecha):fecha_espanol_min($fecha);
	 ?>
    <td width="%" align="<?=$opc_fecha;?>"><em><font face="Arial, Helvetica, sans-serif" size="-1"><? echo trim($ob_membrete->comuna) .", ".$txf?></font></em></td>
  </tr>
</table>
<br>

<?	
}}
?>
<?
//crear generación de certificado
if($cod_ver==1){
?>
<table width="600" height="43" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr><td>
<div align="right" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; text-decoration:none">
Fecha de Emisión <?php echo date("d-m-Y") ?>.<br>
La Institución o persona ante quien se presente este Certificado, podrá verificarlo en www.colegiointeractivo.cl, opci&oacute;n Certificados.
</div><br>

</td></tr></table>

<?

}
?>
<?
		if ($corp==9)if ($institucion!=40251){ ?><br>




			<!-- Firma y timbre -->
				<table width="650" align="center" border="0">
						<tr>
						  <td align="center" valign="bottom"><p align="center" style="color:#900"><strong><em>&ldquo;Buscad  lo que nos une y no lo que nos separa</em></strong><strong>&rdquo;</strong></p></td>
				  </tr>
						<tr>
						  <td align="center" valign="bottom"><hr style="color:#900;border-top: 3px double"></td>
				  </tr>
						<tr>
						  <td  align="center" valign="bottom">
                          <em style="font-size:12px">
                          <? echo $ob_reporte->tilde(ucwords(strtolower($ob_membrete->direccion)));?>
<br>
<? echo "Fono: ".$ob_membrete->telefono;?>
<br>
<? echo "e-mail: ".$ob_membrete->email;?>
                          
                          </em>
                          </td>
				  </tr>
						
				</table>
			<!-- fin firma y timbre --> 
	  <? } ?>	
</p>
    <p>	
      <!-- FIN CUERPO DE LA PAGINA -->
      
</p>
</body>
</html>
<? pg_close($conn);?>