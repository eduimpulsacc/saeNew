 <?php require('../../../../../util/header.inc');?>

<?php 

	$frmModo	=	$_FRMMODO;
	$ramo		=	$_RAMO;
	$curso      =	$_CURSO;
	$ano		= $_ANO;
	$institucion= $_INSTIT;
	$periodo 	= $_PERIODO;
	
	$sql_1 = "select * from curso where id_curso = ".$curso.";";
	$res_1 = pg_Exec($conn,$sql_1)or die ("Fallo :".$sql);
	$fil_1 = pg_fetch_array($res_1);
	$truncado_sf = $fil_1['truncado_sf'];
	
	
	
	$final=$prom;
	
	if ($frmModo=="modificar"){
		$qry2="SELECT pct_ex_semestral, nota_ex_semestral,truncado_ex_semestral FROM ramo WHERE id_ramo=".$ramo.";";
		$result2=pg_Exec($conn,$qry2)or die("Fallo 2 :".$qry2);
		if (pg_numrows($result2)!=0){
			$fila2 = pg_fetch_array($result2,0);
			  $exim = $fila2['nota_exim'];
			  $truncado_sf = $fila2['truncado_ex_semestral'];
			 
			 
		}
		
		for ($i=0 ; $i < $contalum ; $i++){
			if($prom[$i]!=""){
			 $porc = $fila2['pct_ex_semestral'];
			 $pct_prom=(100-$porc);
				$final[$i]= $prom[$i];
				if($txtExamen[$i]!="" && trim($txtExamen[$i])!="0"){
					if($institucion==10026){
						$fin[$i]=(substr((($prom[$i])/10)*($pct_prom/100),0,3)+(substr(($txtExamen[$i]/10)*($porc/100),0,3)))*10;
					}else{
						$fin[$i]=(number_format((($prom[$i])*($pct_prom/100))+(($txtExamen[$i])*($porc/100)),1 ));
					}
				if ($truncado_sf==0){
						 $final[$i] = substr($fin[$i],0,2);
				}else{
					if ($truncado_sf==1){
						 $final[$i]=(round($fin[$i]));}
					}	
					
				}else{
					$final[$i]=$prom[$i];
					$txtExamen[$i]=0;
				}	

				
		
$qry3="SELECT * from situacion_periodo WHERE  RUT_ALUMNO='".$rut_Alu[$i]."' AND ID_RAMO=".$ramo." AND  id_periodo=".$periodo.";";
$result3=pg_Exec($conn,$qry3)or die ("Fallo 3".$qry3);

   if (pg_numrows($result3)==0){
	 $qry="INSERT INTO situacion_periodo (rut_alumno, id_periodo, id_ramo, prom_gral, nota_examen, nota_final) 
	 VALUES (".$rut_Alu[$i].",".$periodo.", ".$ramo.",".$prom[$i].",".$txtExamen[$i].",".$final[$i].")";
						
						$result=pg_exec($conn,$qry)or die("Fallo qq:".$qry);
						if (!$result){
							imprime_array($final);
							echo ('<B> ERROR :</b>Error al acceder a la BD.(1)</B>'. $qry );
							exit();
						}
					}else{
						
						//if($txtExamen[$i]!=""){

  $qry4="UPDATE situacion_periodo SET prom_gral= ".$prom[$i].", nota_examen=".$txtExamen[$i].", nota_final=".$final[$i]." WHERE RUT_ALUMNO='".$rut_Alu[$i]."' AND ID_RAMO=".$ramo." AND id_periodo=".$periodo.";";
							
							$result4 = pg_Exec($conn,$qry4)or die("Fallo r:".$qry4);
							if (!$result4)
								error('<B> ERROR :</b>Error al acceder a la BD.(2)</B>'.$qry4 );
						//}
							/*$result4=@pg_Exec($conn,$qry4);
							if (!$result4)
								error('<B> ERROR :</b>Error al acceder a la BD.(2)</B>'.$qry4 ); */
					}
			}
	 }//fin for
}


	echo "<script>window.location = 'seteaSituacionFinalPeriodo.php?caso=4&curso=$curso&id_ramo=$ramo&cmbPERIODO=$periodo'
</script>";
?>