<?php 
require('../../../../../../../util/header.inc');

header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache");

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/


	$periodo=$_POST['id_periodo1'];
	$taller=$_POST['id_taller1'];
	
	foreach( $_POST as $variable => $valor ){
		if(substr($variable,0,2)=="a_"){
			if($valor==""){$_POST[$variable]=0;}
		}
	}
	
	$ano = $_ANO; // varibla año del servidor //
	$Xreg = $_POST[Xreg]; // cantidad alumnos 
	$cont = 0;
	 
	//ALUMNOS DEL CURSO
	$qryAlu="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat,  
	alumno.ape_mat, tiene_taller.id_taller FROM (alumno INNER JOIN tiene_taller ON 
	alumno.rut_alumno = tiene_taller.rut_alumno) WHERE ((tiene_taller.id_taller)=".$taller.") 
	ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc ";
	$resultAlu	= @pg_Exec($conn,$qryAlu);

	$X=0;

	for($i=0;$i<@pg_numrows($resultAlu);$i++){
		$X++;
		$filaAlu	= @pg_fetch_array($resultAlu,$i);
		$alu		= $filaAlu['rut_alumno'];
					 
		$qry7="SELECT * FROM NOTAS_TALLER WHERE RUT_ALUMNO='".trim($alu)."' AND ID_TALLER=".$_TALLER." AND ID_PERIODO=".$periodo;
					$result7 =pg_Exec($conn,$qry7);
					$notas="";					
					$nn = 0;
					
					if (@pg_numrows($result7)!=0){
					   
					    for($nn=1;$nn<21;$nn++){
							$paso="a_".$X."_".$nn;
							$notas.=" NOTA$nn='".strtoupper($_POST[$paso])."',";
						}
						
						$p_promedio="a_".$X."_21";
						
						$qry="UPDATE NOTAS_TALLER SET ".$notas." PROMEDIO='".$_POST[$p_promedio]."' WHERE RUT_ALUMNO=".trim($alu)." AND ID_TALLER='".$_TALLER."' AND ID_PERIODO=".$periodo;
					
					
					}else{
						
					      $qry="INSERT INTO NOTAS_TALLER (RUT_ALUMNO, ID_TALLER, ID_PERIODO, NOTA1, NOTA2, NOTA3, NOTA4, NOTA5, NOTA6, NOTA7, NOTA8, NOTA9, NOTA10, NOTA11, NOTA12, NOTA13, NOTA14, NOTA15, NOTA16, NOTA17, NOTA18, NOTA19, NOTA20, PROMEDIO) VALUES (".trim($alu).",'".$_TALLER."',".$periodo.",";

						  for($nn=1;$nn<22;$nn++){
							 $paso="a_".$X."_".$nn;
							 $notas.=" '".strtoupper($_POST[$paso])."',";
						  }
						  $notas=substr($notas,0,strlen($notas)-1);
						  $qry.=$notas.")";				
					}
					
					
					$result =@pg_Exec($conn,$qry);
					
					
					if (!$result){
					error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
					
					
					}
	}
	pg_close($conn);
		
 
//echo 1;


?>