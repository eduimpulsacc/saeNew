<?php require('../../../../../../util/header.inc');?>
<?php
	$periodo		=$_PERIODORAMO;
    $ramo          	=$_RAMO;
	$ano			=$_ANO;
   	$institucion	=$_INSTIT;

	foreach( $_POST as $variable => $valor ){
		if(substr($variable,0,2)=="a_"){
			if($valor==""){$_POST[$variable]=0;}
		}
	}
	
	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
	}else{
		if (pg_numrows($result)!=0){
			$fila1 = @pg_fetch_array($result,0);	
			if (!$fila1){
				error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
				exit();
			}
			$nro_ano = trim($fila1['nro_ano']);
		}
	}


	//ALUMNOS DEL CURSO
//	$qryAlu="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$ano_act.id_curso FROM (alumno INNER JOIN tiene$ano_act ON alumno.rut_alumno = tiene$ano_act.rut_alumno) WHERE tiene$ano_act.id_ramo=".$ramo." ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc ";
	$qryAlu="SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso, matricula.nro_lista "; 
	$qryAlu = $qryAlu . " FROM alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno ";
	$qryAlu = $qryAlu . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno ";
	$qryAlu = $qryAlu . " WHERE tiene$nro_ano.id_ramo=".$ramo." AND matricula.id_ano=".$ano." ";
	$qryAlu = $qryAlu . " AND matricula.bool_ar=0 ";
	$qryAlu = $qryAlu . " ORDER BY matricula.nro_lista asc, ape_pat, ape_mat, nombre_alu, rut_alumno asc ";

	$resultAlu	= @pg_Exec($conn,$qryAlu);
	$X=0;
	for($i=0;$i<@pg_numrows($resultAlu);$i++){
		$X++;
		$filaAlu	= @pg_fetch_array($resultAlu,$i);
		$alu		= $filaAlu['rut_alumno'];

/*					if($a[$X]["1"]=="") $a[$X]["1"]=0;
					if($a[$X]["2"]=="") $a[$X]["2"]=0;
					if($a[$X]["3"]=="") $a[$X]["3"]=0;
					if($a[$X]["4"]=="") $a[$X]["4"]=0;
					if($a[$X]["5"]=="") $a[$X]["5"]=0;
					if($a[$X]["6"]=="") $a[$X]["6"]=0;
					if($a[$X]["7"]=="") $a[$X]["7"]=0;
					if($a[$X]["8"]=="") $a[$X]["8"]=0;
					if($a[$X]["9"]=="") $a[$X]["9"]=0;
					if($a[$X]["10"]=="") $a[$X]["10"]=0;
					if($a[$X]["11"]=="") $a[$X]["11"]=0;
					if($a[$X]["12"]=="") $a[$X]["12"]=0;
					if($a[$X]["13"]=="") $a[$X]["13"]=0;
					if($a[$X]["14"]=="") $a[$X]["14"]=0;
					if($a[$X]["15"]=="") $a[$X]["15"]=0;
					if($a[$X]["16"]=="") $a[$X]["16"]=0;
					if($a[$X]["17"]=="") $a[$X]["17"]=0;
					if($a[$X]["18"]=="") $a[$X]["18"]=0;
					if($a[$X]["19"]=="") $a[$X]["19"]=0;
					if($a[$X]["20"]=="") $a[$X]["20"]=0;
					if($a[$X]["21"]=="") $a[$X]["21"]=0;
*/					
		
					$qry7="SELECT * FROM NOTAS$nro_ano WHERE RUT_ALUMNO=".trim($alu)." AND ID_RAMO=".$_RAMO." AND ID_PERIODO=".$periodo;
					$result7 =@pg_Exec($conn,$qry7);
					$notas="";					
					$nn = 0;
					 if (@pg_numrows($result7)!=0){
//						$qry="UPDATE NOTAS$nro_ano SET NOTA1='".$a[$X]["1"]."', NOTA2='".$a[$X]["2"]."', NOTA3='".$a[$X]["3"]."', NOTA4='".$a[$X]["4"]."', NOTA5='".$a[$X]["5"]."', NOTA6='".$a[$X]["6"]."', NOTA7='".$a[$X]["7"]."', NOTA8='".$a[$X]["8"]."', NOTA9='".$a[$X]["9"]."', NOTA10='".$a[$X]["10"]."', NOTA11='".$a[$X]["11"]."', NOTA12='".$a[$X]["12"]."', NOTA13='".$a[$X]["13"]."', NOTA14='".$a[$X]["14"]."', NOTA15='".$a[$X]["15"]."', NOTA16='".$a[$X]["16"]."', NOTA17='".$a[$X]["17"]."', NOTA18='".$a[$X]["18"]."', NOTA19='".$a[$X]["19"]."', NOTA20='".$a[$X]["20"]."', PROMEDIO='".$a[$X]["21"]."' WHERE RUT_ALUMNO=".$alu." AND ID_RAMO='".$_RAMO."' AND ID_PERIODO=".$periodo;
						for($nn=1;$nn<21;$nn++){
							$paso="a_".$X."_".$nn;
							$notas.=" NOTA$nn='".$_POST[$paso]."',";
						}
						$p_promedio="a_".$X."_21";
						$qry="UPDATE NOTAS$nro_ano SET ".$notas." PROMEDIO='".$_POST[$p_promedio]."' WHERE RUT_ALUMNO=".$alu." AND ID_RAMO='".$_RAMO."' AND ID_PERIODO=".$periodo;
					}else{
//						$qry="INSERT INTO NOTAS$nro_ano (RUT_ALUMNO, ID_RAMO, ID_PERIODO, NOTA1, NOTA2, NOTA3, NOTA4, NOTA5, NOTA6, NOTA7, NOTA8, NOTA9, NOTA10, NOTA11, NOTA12, NOTA13, NOTA14, NOTA15, NOTA16, NOTA17, NOTA18, NOTA19, NOTA20, PROMEDIO) VALUES (".$alu.",'".$_RAMO."',".$periodo.",'".$a[$X]["1"]."','".$a[$X]["2"]."','".$a[$X]["3"]."','".$a[$X]["4"]."','".$a[$X]["5"]."','".$a[$X]["6"]."','".$a[$X]["7"]."','".$a[$X]["8"]."','".$a[$X]["9"]."','".$a[$X]["10"]."','".$a[$X]["11"]."','".$a[$X]["12"]."','".$a[$X]["13"]."','".$a[$X]["14"]."','".$a[$X]["15"]."','".$a[$X]["16"]."','".$a[$X]["17"]."','".$a[$X]["18"]."','".$a[$X]["19"]."','".$a[$X]["20"]."','".$a[$X]["21"]."')";
						$qry="INSERT INTO NOTAS$nro_ano (RUT_ALUMNO, ID_RAMO, ID_PERIODO, NOTA1, NOTA2, NOTA3, NOTA4, NOTA5, NOTA6, NOTA7, NOTA8, NOTA9, NOTA10, NOTA11, NOTA12, NOTA13, NOTA14, NOTA15, NOTA16, NOTA17, NOTA18, NOTA19, NOTA20, PROMEDIO) VALUES (".$alu.",'".$_RAMO."',".$periodo.",";

						for($nn=1;$nn<22;$nn++){
							$paso="a_".$X."_".$nn;
							$notas.=" '".$_POST[$paso]."',";
						}
						$notas=substr($notas,0,strlen($notas)-1);
						$qry.=$notas.")";
					}
					$result =@pg_Exec($conn,$qry);
					if (!$result){
						error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
					}

	}
	
if ($_MODOEVAL==5){
    /// vuelve a la pagina por que no es necesario pasar a la otra pagina por que son SIGLAS
	echo "<script>window.location = 'new_mostrarNotas.php3?periodo=".trim($periodo)."'</script>";
}else{	
    echo "<script>window.location = 'promedio/proceso_promedio.php'</script>";
}

?>