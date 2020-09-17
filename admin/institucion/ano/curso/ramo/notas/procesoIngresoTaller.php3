<?php require('../../../../../../util/header.inc');?>
<?php
	$periodo		=$_PERIODORAMO;
    $taller          =$_TALLER;
	
	foreach( $_POST as $variable => $valor ){
		if(substr($variable,0,2)=="a_"){
			if($valor==""){$_POST[$variable]=0;}
		}
	}
	
	//ALUMNOS DEL CURSO
	
	$qryAlu="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene_taller.id_taller FROM (alumno INNER JOIN tiene_taller ON alumno.rut_alumno = tiene_taller.rut_alumno) WHERE ((tiene_taller.id_taller)=".$taller.") ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc ";
	$resultAlu	= @pg_Exec($conn,$qryAlu);
	$X=0;
	for($i=0;$i<@pg_numrows($resultAlu);$i++){
		$X++;
		$filaAlu	= @pg_fetch_array($resultAlu,$i);
		$alu		= $filaAlu['rut_alumno'];
				
				/*	if($a[$X][1]=="") $a[$X][1]=0;
					if($a[$X][2]=="") $a[$X][2]=0;
					if($a[$X][3]=="") $a[$X][3]=0;
					if($a[$X][4]=="") $a[$X][4]=0;
					if($a[$X][5]=="") $a[$X][5]=0;
					if($a[$X][6]=="") $a[$X][6]=0;
					if($a[$X][7]=="") $a[$X][7]=0;
					if($a[$X][8]=="") $a[$X][8]=0;
					if($a[$X][9]=="") $a[$X][9]=0;
					if($a[$X][10]=="") $a[$X][10]=0;
					if($a[$X][11]=="") $a[$X][11]=0;
					if($a[$X][12]=="") $a[$X][12]=0;
					if($a[$X][13]=="") $a[$X][13]=0;
					if($a[$X][14]=="") $a[$X][14]=0;
					if($a[$X][15]=="") $a[$X][15]=0;
					if($a[$X][16]=="") $a[$X][16]=0;
					if($a[$X][17]=="") $a[$X][17]=0;
					if($a[$X][18]=="") $a[$X][18]=0;
					if($a[$X][19]=="") $a[$X][19]=0;
					if($a[$X][20]=="") $a[$X][20]=0;
					if($a[$X][21]=="") $a[$X][21]=0;  */
					 
					$qry7="SELECT * FROM NOTAS_TALLER WHERE RUT_ALUMNO='".trim($alu)."' AND ID_TALLER=".$_TALLER." AND ID_PERIODO=".$periodo;
					$result7 =pg_Exec($conn,$qry7);
					$notas="";					
					$nn = 0;
					
					if (@pg_numrows($result7)!=0){
					    //$qry="UPDATE NOTAS_TALLER SET NOTA1='".$a[$X]["1"]."', NOTA2='".$a[$X]["2"]."', NOTA3='".$a[$X]["3"]."', NOTA4='".$a[$X]["4"]."', NOTA5='".$a[$X]["5"]."', NOTA6='".$a[$X]["6"]."', NOTA7='".$a[$X]["7"]."', NOTA8='".$a[$X]["8"]."', NOTA9='".$a[$X]["9"]."', NOTA10='".$a[$X]["10"]."', NOTA11='".$a[$X]["11"]."', NOTA12='".$a[$X]["12"]."', NOTA13='".$a[$X]["13"]."', NOTA14='".$a[$X]["14"]."', NOTA15='".$a[$X]["15"]."', NOTA16='".$a[$X]["16"]."', NOTA17='".$a[$X]["17"]."', NOTA18='".$a[$X]["18"]."', NOTA19='".$a[$X]["19"]."', NOTA20='".$a[$X]["20"]."', PROMEDIO='".$a[$X]["21"]."' WHERE RUT_ALUMNO='".trim($alu)."' AND ID_TALLER='".$_TALLER."' AND ID_PERIODO=".$periodo;
					    for($nn=1;$nn<21;$nn++){
							$paso="a_".$X."_".$nn;
							$notas.=" NOTA$nn='".$_POST[$paso]."',";
						}
						$p_promedio="a_".$X."_21";
						$qry="UPDATE NOTAS_TALLER SET ".$notas." PROMEDIO='".$_POST[$p_promedio]."' WHERE RUT_ALUMNO=".trim($alu)." AND ID_TALLER='".$_TALLER."' AND ID_PERIODO=".$periodo;
					
					
					}else{
					      $qry="INSERT INTO NOTAS_TALLER (RUT_ALUMNO, ID_TALLER, ID_PERIODO, NOTA1, NOTA2, NOTA3, NOTA4, NOTA5, NOTA6, NOTA7, NOTA8, NOTA9, NOTA10, NOTA11, NOTA12, NOTA13, NOTA14, NOTA15, NOTA16, NOTA17, NOTA18, NOTA19, NOTA20, PROMEDIO) VALUES (".trim($alu).",'".$_TALLER."',".$periodo.",";

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
	pg_close($conn);
		
echo "<script>window.location = 'mostrarNotasTaller.php3?periodo=".trim($periodo)."'</script>";
?>