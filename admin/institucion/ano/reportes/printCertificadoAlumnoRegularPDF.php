<?php
 /*error_reporting(E_ALL);
ini_set('display_errors', '1'); */
?>
<?

require('../../../../util/header.inc');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES")	;
	//---------------------------
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$alumno			=$cmb_alumno;
	$reporte		=$c_reporte;
	
	$_POSP = 4;
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
	$Curso_pal =CursoPalabra2($curso, 0, $conn);	
	


		//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$cmb_curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
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
	
	
	//----------
	

	function rutF($txt){
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
		$sql_curso = "select ensenanza, cod_es, cod_sector, cod_rama from curso where id_curso=" . $curso;
		$result_curso = @pg_exec($conn,$sql_curso);
		$fila_curso = @pg_fetch_array($result_curso,0);
		$Ense = $fila_curso['ensenanza'];
		$Espec = $fila_curso['cod_es'];
		$Sector = $fila_curso['cod_sector'];
		$Rama = $fila_curso['cod_rama'];
		
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
		
		$Nombre_Direc = strtoupper(trim(trim($fila['nombre_emp']. " " .$fila['ape_pat']) . " " . trim($fila['ape_mat'])  ));
        $cargo_dir    = $fila['cargo'];	
		
		
	if ($cargo_dir==1){
	    $cargo_dir  = "Director(a)";
		$cargo_dir2 = "Director(a)";
		
		if ($institucion==24977){
		     $cargo_dir2 = "Rector(a)";
		}
		
	}
	if ($cargo_dir==23){
	    $cargo_dir  = "Rector(a)";
		$cargo_dir2 = "Rector(a)";
	}		


 function fecha_espanol2($fecha)
	{
		$dia = substr($fecha,0,2);
		$mes = trim(substr($fecha,3,2));
		//Descripcion de meses						
		if($mes=="01"){$t_mes="Enero";}
		if($mes=="02"){$t_mes="Febrero";}
		if($mes=="03"){$t_mes="Marzo";}
		if($mes=="04"){$t_mes="Abril";}
		if($mes=="05"){$t_mes="Mayo";}
		if($mes=="06"){$t_mes="Junio";}
		if($mes=="07"){$t_mes="Julio";}
		if($mes=="08"){$t_mes="Agosto";}
		if($mes=="09"){$t_mes="Septiembre";}
		if($mes=="10"){$t_mes="Octubre";}
		if($mes=="11"){$t_mes="Noviembre";}
		if($mes=="12"){$t_mes="Diciembre";}	
		//fin descripcion					
		$ano = substr($fecha,6,4);
		$fecha = "$dia "."de"." $t_mes "."de"." $ano";
		return($fecha);
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

						

	}else if ( ($fila_curso['grado_curso']==2) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){

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

						

	}else if ( ($fila_curso['grado_curso']==5) and ($fila_curso['cod_decreto']==1000)){

		$Curso_pal0 =  "TRANSICIÓN 2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 =  "T2N - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 =  "TRANSICIÓN 2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "T2N - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
		
		$Curso_pal4 =  "KINDER - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));			

		

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

																					

	}else{

		$Curso_pal0 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 

		$Curso_pal1 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 		

		$Curso_pal2 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 		

		$Curso_pal3 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 	
		$Curso_pal4 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 
		//$Curso_pal4 =  ucwords(strtoupper($fila_curso["grado_curso"] . "º AÑO DE " . $fila_curso['nombre_tipo']));
		
		$Curso_pal5 =  ucwords(strtoupper("AÑO DE ".$fila_curso['nombre_tipo'])); 		
	
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

	
}

?>


<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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
 font-family:Arial, Helvetica, sans-serif; font-size:11px;

 }
 .subitem
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:16px;
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
	/*font-family: "Arial Narrow", Times, serif;*/
	font-size: 36px;
	/*font-style: italic;*/
}
.q {
	text-align: justify;
}

.tableindex {
	FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #ffffff; TEXT-INDENT: 5px; BACKGROUND-REPEAT: repeat-x; FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif; HEIGHT: 39px; BACKGROUND-COLOR: #B98702; TEXT-ALIGN: left; TEXT-DECORATION: none
}
</style>


  
<?php 

if ($curso > 0 ){
   ?>
  <?php if($opcion==1){
 if ($institucion=="770"){ 
	    // no muestro los datos de la institucion
	    // por que ellos tienen hojas pre-impresas
	    $html= "<br><br><br><br><br><br><br><br><br><br>";
		   
	 }
	 else{
		$html=" <table width='530' border='0' cellspacing='0' cellpadding='0' style='font-family:Arial, Helvetica, sans-serif; font-size:11px;'>
			<tr> 
			  <td  align='left' class='item'>".strtoupper($ob_membrete->ins_pal)."</td>
			  <td>&nbsp;&nbsp;&nbsp;</td>
			  <td  class='item'>Regi&oacute;n</td>
			  <td  class='item'>:&nbsp;".$ob_membrete->region."</td>
			</tr>
			<tr> 
			  <td align='left' class='item'>".strtoupper($ob_membrete->direccion)."&nbsp;</td>
			  <td>&nbsp;&nbsp;&nbsp;</td>
			  <td  class='item'>Provincia</td>
			  <td class='item'>:&nbsp; ".$ob_membrete->provincia."</td>
			</tr>
			<tr> 
			  <td align='left' class='item'>FONO ". $ob_membrete->telefono."</td>
			  <td>&nbsp;&nbsp;&nbsp;</td>
			  <td  class='item'>Comuna</td>
			  <td class='item'>:&nbsp;".$ob_membrete->comuna."</td>
			</tr>
			<tr> 
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td  class='item'>Rbd</td>
			  <td class='item'>:&nbsp;".$institucion."</td>
			</tr>
			<tr> 
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td  class='item'>A&ntilde;o Escolar</td>
			  <td class='item'>:&nbsp;".$nro_ano."</td>
			</tr>
		  </table>
		  <br>
		  
		   <br>
		  <table width='649' border='0' cellspacing='1' cellpadding='1'>
		  <tr>
			  <td width='530' valign='top'>
				";	
				$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## código para tomar la insignia
				
				if($institucion!=""){
				$html.="<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
				}else{
				$html.= "<img src='".$d."menu/imag/logo.gif' >";
				}
				
				
		$html.="</td>
			
			</tr>
		</table>
		<br><br>
  <table width='530' border='0' cellspacing='0' cellpadding='0'>
    <tr>";
 if($institucion==770){
		$html.="<td align='center' bgcolor='#FFCC00'><center><font size='+2'><strong>CERTIFICADO DE ALUMNO REGULAR</strong></font></center></td>";
 }else{ 
	 $html.=" <td align='center' class='tableindex'><center>
	    <font size='+2'>CERTIFICADO DE ALUMNO REGULAR</font>
	  </center></td>";
 } 	  
    $html.="</tr>
	<tr> 
      <td valign='top' class='subitem'><div align='center'><strong>________________________________</strong></div></td>
    </tr>
  </table>
		<div align='left'><br>
    <br>
    <br>
  </div>
  <table width='530' border='0' cellspacing='0' cellpadding='0'>";
   if ($numero!=""){
    $html.="<tr> 
      <td class='subitem'>Nº de Matrícula <strong>".$ob_reporte->num_matricula."</strong></td>
    </tr>
    <tr> 
      <td class='subitem'>&nbsp;</td>
    </tr>";
	 } 
    $html.="<tr> 
      <td width='346' class='subitem'><strong>
        ";
		if($institucion == 24511){	
			$html.= "Meza Gotor Marcelo";
		}
		else{
			$html.= strtoupper($Nombre_Direc);
		}
	
        $html.=", </strong> ";
          
		if ($institucion==1593){ 
		     $html.= "Director";
		}else{ 			 
             $html.= $cargo_dir;
			 $html.= "del ";
		}	 
			   
         $html.="</font>
     <b>".strtoupper($ob_membrete->ins_pal)."</b></div></td>
    </tr>
  </table>
  <table width='530' border='0' cellspacing='0' cellpadding='0'>
    <tr>
		<td colspan='3'>&nbsp;</td>
	</tr>
    <tr> 
      <td  height='19' class='subitem'>certifica que </td>
      <td  align='center'width='267' class='subitem'><div align='left'><strong>";
	 $nombres=strtoupper($ob_reporte->nombres);
	   $html.= $ob_reporte->tildeM($nombres)
	  ."</strong>&nbsp;</div></td>
      <td  align='left' class='subitem'><b>R.U.T ".$ob_reporte->rut_alumno."</b>&nbsp;</td>
    </tr>
	<tr>
		<td colspan='3' class='subitem'>&nbsp;</td>
	</tr>
    <tr> 
      <td colspan='3' class='subitem'></td>
    </tr>
    <tr> 
      <td colspan='3' class='subitem'></td>
    </tr>
    <tr> 
      <td colspan='3' class='subitem'>&nbsp;es 
        ".$tipo1." regular del <b>".$Curso_pal." ";
		
		if ($institucion!=1518)
		$html.= ucwords(strtolower($Especialidad)); 
		
		$html.="</b> de este Establecimiento.</td>
    </tr>
	<tr><td colspan='3' class='subitem'><br>".$remitente."</td></tr>
    <tr> 
      <td colspan='3' class='subitem'><br> Se 
        extiende el presente certificado a solicitud del apoderado para los fines 
        que estime conveniente.</td>
    </tr>
    <tr> 
      <td colspan='3'>&nbsp;</td>
    </tr>
  </table>
 
  <br><br><br><br><br><br><br><br><br>
  
<table width='530' border='0' cellpadding='0' cellspacing='0'>";
          
			$sql4 = "SELECT empleado.rut_emp,empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
			$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
			$result =@pg_Exec($conn,$sql4);
			$fila = @pg_fetch_array($result,0);	
			$rut_emp=$fila['rut_emp'];
			
			$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
///////***********COMPRUEBA SI TIENE FIRMA DIGITAL*************////////	

if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
//$html.="Archivo Firma 4 encontrado";



  $firmadig="<img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'>";
$html.=" 
 </tr>
 <tr><td valign='bottom'>
   <div align='center'>".$firmadig."</div></td></tr>
   <tr><td align='center'><strong><font face='Arial, Helvetica, sans-serif' size='2'>________________________________   </font></strong></td></tr>
 <tr> 
 <td><div align='center'><font face='Arial, Helvetica, sans-serif' size='2'>".$cargo_dir2 ."Establecimiento </font></div></td>
 </tr>
 <tr>

 <td><div align='center'><strong><font face='Arial, Helvetica, sans-serif' size='1'> ";

  if($institucion == 24511){	
  $html.= "MEZA GOTOR MARCELO";
 }else{
  $html.= $Nombre_Direc;
}
 $html.="
 </font></strong></div></td>
 </tr>";
 
 }else{ ////////**********FIN COMPRUEBA FIRMA DIGITAL**********/////////
  
	                        
		$html.="  <tr> 
			<td><div align='center'><strong><font face='Arial, Helvetica, sans-serif' size='2'>________________________________</font></strong></div></td>
		  </tr>
		  <tr> 
			<td><div align='center'><font face='Arial, Helvetica, sans-serif' size='2'>".$cargo_dir2."
				Establecimiento </font></div></td>
		  </tr>
			<tr>
			
			<td><div align='center'><strong><font face='Arial, Helvetica, sans-serif' size='1'> ";
			
			if($institucion == 24511){	
				$html.="MEZA GOTOR MARCELO";
			}
			else{
				$html.= $Nombre_Direc;
			}
		
				$html.="</font></strong></div></td>
		  </tr>"; }
	 $html.=" </table>
<br><br><br><br>
<table width='530' height='43' border='0' align='center' cellpadding='0' cellspacing='0'>
    <tr>";
	$fecha = date("d-m-Y");
	 $html.="<td width='%' align='left'><font face='Arial, Helvetica, sans-serif' size='-1'><strong>".($ob_membrete->comuna . ", " . fecha_espanol2($fecha))."</strong></font></td>
  </tr>
</table>
  ";
		 
	}
   } //fin tipo1
  elseif($opcion==2){?>
  <?php 
  $html="<table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align='center'>";?>
	           <?
			   if ($institucion==24977){ ?>
			         <?php  $html.="<table border='0' width='300' align='center'>
			           <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;	";
							   	
								$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
								$arr=@pg_fetch_array($result,0);
								$fila_foto = @pg_fetch_array($result,0);
								## código para tomar la insignia
								
								if($institucion!=""){
								$html.="<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
								}else{
								$html.="<img src='".$d."menu/imag/logo.gif' >";
								}
										   
					  $html.=" </td>
					   </tr></table>";?>
			   
			   
			  <? }else{ ?>	   
			   
					   <?	
						$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
						$arr=@pg_fetch_array($result,0);
						$fila_foto = @pg_fetch_array($result,0);
						## código para tomar la insignia
						
						if($institucion!=""){
						$html.="<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
						}else{
						$html.="<img src='".$d."menu/imag/logo.gif' >";
						}
						?>
			
			<? } 	
		$html.="</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align='center' ><center>
      <strong><font size='+2'><u>CERTIFICADO DE ALUMNO REGULAR</u></font></strong>
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
    <td><div align='center'>
      <table width='530' border='0' cellspacing='0' cellpadding='0'>
        <tr>
    <td class='subitem'><div align='justify'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>
    ";
      
		if($institucion == 24511){	
			$html.=" Meza Gotor Marcelo";
		}
		else{
			$html.= strtoupper($Nombre_Direc);
		}
	$html.=", </strong>"; 
        
		if ($institucion==1593){ 
		     $html.= "Director";
		}else{ 
		     if ($institucion==24977){
			      $html.= $cargo_dir2;
			 }else{
			     $html.= $cargo_dir;
			 }			 
             
			 if($institucion==14703){
			 $html.="  ".strtoupper($ob_membrete->ins_pal).", Nº ".$institucion."-".$ob_membrete->dig_rdb;
			 
			 }else{
			$html.=" del ".strtoupper($ob_membrete->ins_pal).", Nº ".$institucion."-".$ob_membrete->dig_rdb;
			 }
			 
			 
		}
		 
		$html.=",
      certifica que <strong>";
	  $nombres=strtoupper($ob_reporte->nombres);
	  $html.=$ob_reporte->tildeM($nombres)."</strong> C&eacute;dula de Identidad Nº ".$ob_reporte->rut_alumno.",
      es ".$tipo1." regular del ".$Curso_pal.", " ;
         
		if ($institucion!=1518)
		$html.= ucwords(strtolower($Especialidad)); 
		
		
       $html.="de este Establecimiento Educacional, 
      año académico ". $nro_ano .".</div></td>
  </tr>
      </table>
    </div></td>
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
    <td><div align='center'>
      <table width='600' border='0' cellspacing='0' cellpadding='0'>
        <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='subitem'>Se extiende el presente certificado a petición del apoderado para los fines que estime conveniente.</span></td>
  </tr>
      </table>
    </div></td>
  </tr>
  
  <tr>
    <td><br><br><br><br><br><br></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	";
		if ($_INSTIT==25478){ 
			//<!-- Firma y timbre -->
			$html.="<table width='570' border='0' align='right'>
						<tr>
						  <td width='50%' align='center' valign='bottom'>&nbsp;</td>
						  <td width='50%' align='center'><div align='left'><img src='timbre_mayorpenalolen.jpg' width='144' height='142'></div></td>
						</tr>
				</table>
			";
	  } 
	  
	   
		if ($_INSTIT==24977){ 
			//<!-- Firma y timbre --><
			
			
				$html.="<table width='530' border='0' align='right'>
						<tr>
						  <td width='25' align='center' valign='bottom'><img src='timbre_mayortobalaba.jpg'></td>
						  <td width='75%' align='left'><img src='firma_mayortobalaba.jpg' ></td>
						</tr>
				</table>
				<br><br><br><br><br><br>";
				
		//	<!-- fin firma y timbre -->
	   } 
	$html.="</td>
  </tr>
   
  <tr>
    <td>
	      <table width='530' border='0' cellpadding='0' cellspacing='0'>";
          
			$sql4 = "SELECT empleado.rut_emp,empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
			$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
			$result =@pg_Exec($conn,$sql4);
			$fila = @pg_fetch_array($result,0);	
			$rut_emp=$fila['rut_emp'];
			
			$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
///////***********COMPRUEBA SI TIENE FIRMA DIGITAL*************////////	

if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
$html.="Archivo Firma 4 encontrado";

$html.=" <tr> ";
  $firmadig="<img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'>";
$html.=" 
 </tr>
 <tr><td valign='bottom'>
   <div align='center'><strong>".$firmadig."<font face='Arial, Helvetica, sans-serif' size='2'>________________________________   </font></strong></div></td></tr>
 <tr> 
 <td><div align='center'><font face='Arial, Helvetica, sans-serif' size='2'>".$cargo_dir2 ."Establecimiento </font></div></td>
 </tr>
 <tr>

 <td><div align='center'><strong><font face='Arial, Helvetica, sans-serif' size='1'> ";

  if($institucion == 24511){	
  $html.= "MEZA GOTOR MARCELO";
 }else{
  $html.= $Nombre_Direc;
}
 $html.="
 </font></strong></div></td>
 </tr>";
 
 }else{ ////////**********FIN COMPRUEBA FIRMA DIGITAL**********/////////
  
	                        
		$html.="  <tr> 
			<td><div align='center'><strong><font face='Arial, Helvetica, sans-serif' size='2'>________________________________</font></strong></div></td>
		  </tr>
		  <tr> 
			<td><div align='center'><font face='Arial, Helvetica, sans-serif' size='2'>".$cargo_dir2."
				Establecimiento </font></div></td>
		  </tr>
			<tr>
			
			<td><div align='center'><strong><font face='Arial, Helvetica, sans-serif' size='1'> ";
			
			if($institucion == 24511){	
				$html.="MEZA GOTOR MARCELO";
			}
			else{
				$html.= $Nombre_Direc;
			}
		
				$html.="</font></strong></div></td>
		  </tr>"; }
	 $html.=" </table>	</td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td class='Estilo2'><div align='center' class='Estilo3'>
      <div align='center' class='Estilo4'>
	 ";
	   if ($institucion==24977){
	       $html.= "Av. Camilo Henríquez 4206 - Puente Alto | Teléfono: 874 1295 - Fax: 874 4163<br>";
	       $html.= "www.colegiomayor.cl/tobalaba";
	   }	   
	   if ($institucion==25478){
	       $html.= "Valle del Aconcagua 8031 - Peñalolén | Fono-Fax: 758 3100";
	   }	   
	 $html.="</div>
    </div></td>
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
  <tr>";
  $fecha = date("d-m-Y");
  $html.=" <td>".($ob_membrete->comuna . ", " . fecha_espanol2($fecha))."</td>
  </tr>
</table>";?>
  
  <?php }elseif($opcion==3){
	  
	 $html=" <table width='530' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td> <div align='center'>
     ";
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			## código para tomar la insignia
			
			if($institucion!=""){
			 $html.= "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
			}else{
			$html.= "<img src='".$d."menu/imag/logo.gif' >";
			}
			
   $html.=" </div></td>
  </tr>
  <tr>
    <td class='Estilo6'><div align='center'><em><font color='#666666'>".ucwords(strtolower($ob_membrete->ins_pal))."</font></em></div></td>
  </tr>
  <tr>
    <td class='Estilo6'><div align='center' class='Estilo6'><em><font color='#666666'>".$ob_reporte->tilde(ucwords(strtolower($ob_membrete->direccion)))."</font></em></div></td>
  </tr>
  <tr>
    <td class='Estilo6'><div align='center'><em><font color='#666666'>Fono: ".$ob_membrete->telefono."   Fax: ".$ob_membrete->fax."</font></em></div></td>
  </tr>
  <tr>
    <td class='Estilo3'><div align='center'><em><font color='#666666'>e-mail: ".$ob_membrete->email."</font></em></div></td>
  </tr>
  <tr>
    <td><hr color='#666666' style='border-collapse:collapse; height:1px'></td>
  </tr>
</table>

<br>
<br>
<table width='530' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td><div align='center' class='Estilo5'><em style='font-size:36px;'>CERTIFICADO ALUMNO REGULAR</em></div></td>
  </tr>
</table>
<br>
<br>
<table width='330' border='0' align='left' cellpadding='0' cellspacing='0'>
  <tr>
    <td  class='subitem' width='110'><em>Decreto Cooperador </em></td>
    <td  class='subitem'><em><strong> Res. Exenta N&ordm;".$ob_membrete->nu_resolucion." A&ntilde;o ".substr($ob_membrete->fecha_resol,0,4)." </strong></em></td>
  </tr>";
if ($institucion!=12838){
  $html.="<tr>
  <td><em>Rol Base de Datos </em></td>
  <td class='subitem'><em><strong>
      ".$institucion."-".$ob_membrete->dig_rdb."
    </strong></em> 
	</td>
    </tr>";
     } 
   $html.="</table>
<br>
<br>
<table width='530' border='0' align='center' cellpadding='0' cellspacing='3'>
  <tr>
    <td class='subitem' style='line-height:200%'><div align='justify'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><strong>
	";
	
		if($institucion == 24511){	
			$html.= "Meza Gotor Marcelo";
		}
		else{
			$html.= strtoupper($Nombre_Direc);
		}
	
	$html.="<strong></em>,<em> ";
	if ($institucion==1593){ 
		     $html.= "Director";
		}else{ 
		     if ($institucion==24977){
			      $html.= $cargo_dir2;
			 }else{
			      $html.= $cargo_dir;
			 }			 
              if($institucion==14703 ){
			 $html.= "  ".trim(strtoupper($ob_membrete->ins_pal)).", ";
			 
			  }elseif($institucion==302){
				  $html.= "  de la ".trim(strtoupper($ob_membrete->ins_pal)).", ";
			  
			 }else{
			 $html.= " del ".trim(strtoupper($ob_membrete->ins_pal)).", ";
			 }
			
		}
	$html.="certifica que el(la) ".$tipo1."&nbsp; ";
	$nombres=strtoupper($ob_reporte->nombres);
	  $html.= "<strong>".$ob_reporte->tildeM($nombres)."</strong>, C&eacute;dula de Identidad N&ordm; ".$ob_reporte->rut_alumno;
	
                if($txtTIPO !=""){
			
			$html.= "que cursa el"." ". $Curso_pal.",";
			} 
			
			$html.=$tipo3." en el Registro Escolar N&ordm; ".$ob_reporte->num_matricula." , a&ntilde;o ".$nro_ano.", es ";
				
			
	  	if($txtTIPO !=""){
			
			$html.= $txtTIPO;
			}else{
	  ?>
      
       <? 

	   $html.= $tipo1." regular del Establecimiento Educacional, cursando el ".$Curso_pal." ";
           
		/*if ($institucion!=1518)
		{$html.= ucwords(strtolower($Especialidad)); }*/
			}
		
		
	
	$html.=".</em></div>
	</td>
	</tr>
	</table>
	<br>
<table width='530' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td colspan='2' class='subitem'><div align='justify'><em> ".$remitente." </em></div></td>
  </tr>
</table>

<br>
<table width='530' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td colspan='2' class='subitem'><div align='justify'><em> ".$txtGLOSA." </em></div></td>
  </tr>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
<table width='530' border='0' cellpadding='0' cellspacing='0'>";
          
			$sql4 = "SELECT empleado.rut_emp,empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
			$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
			$result =@pg_Exec($conn,$sql4);
			$fila = @pg_fetch_array($result,0);	
			$rut_emp=$fila['rut_emp'];
			
			$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
///////***********COMPRUEBA SI TIENE FIRMA DIGITAL*************////////	

if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
$html.="Archivo Firma 4 encontrado";

$html.=" <tr> ";
  $firmadig="<img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'>";
$html.=" 
 </tr>
 <tr><td valign='bottom'>
   <div align='center'><strong>".$firmadig."<font face='Arial, Helvetica, sans-serif' size='2'>________________________________   </font></strong></div></td></tr>
 <tr> 
 <td><div align='center'><font face='Arial, Helvetica, sans-serif' size='2'>".$cargo_dir2 ."Establecimiento </font></div></td>
 </tr>
 <tr>

 <td><div align='center'><strong><font face='Arial, Helvetica, sans-serif' size='1'> ";

  if($institucion == 24511){	
  $html.= "MEZA GOTOR MARCELO";
 }else{
  $html.= $Nombre_Direc;
}
 $html.="
 </font></strong></div></td>
 </tr>";
 
 }else{ ////////**********FIN COMPRUEBA FIRMA DIGITAL**********/////////
  
	                        
		$html.="  <tr> 
			<td><div align='center'><strong><font face='Arial, Helvetica, sans-serif' size='2'>________________________________</font></strong></div></td>
		  </tr>
		  <tr> 
			<td><div align='center'><font face='Arial, Helvetica, sans-serif' size='2'>".$cargo_dir2."
				Establecimiento </font></div></td>
		  </tr>
			<tr>
			
			<td><div align='center'><strong><font face='Arial, Helvetica, sans-serif' size='1'> ";
			
			if($institucion == 24511){	
				$html.="MEZA GOTOR MARCELO";
			}
			else{
				$html.= $Nombre_Direc;
			}
		
				$html.="</font></strong></div></td>
		  </tr>"; }
	 $html.=" </table>	

<br>
<table width='530' height='43' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>";
     $fecha = date("d-m-Y");
     $html.="<td width='%' align='left'><em><font face='Arial, Helvetica, sans-serif' size='-1'>".($ob_membrete->comuna . ", " . fecha_espanol2($fecha))."</font></em></td>
  </tr>
</table>
<br>";
	  
	  
	  }//fin tipo3
  
 }?>


<?php

     
 //  $content=$html;
    $content = ob_get_clean();
	$fecha_actual = date('d_m_Y-H:i:s');

    // convert to PDF
    require_once("../../../clases/dompdf/dompdf_config.inc.php");
    $dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->set_paper('Letter', 'portrait');
$dompdf->stream("CertidicadoAlumnoRegular".$fecha_actual.".pdf",array("Attachment" => false));
?>