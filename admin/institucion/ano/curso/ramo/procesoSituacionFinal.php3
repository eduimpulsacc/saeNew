 <?php require('../../../../../util/header.inc');?>

<?php 

/*if($_PERFIL==0)
{ print_r($_POST);
exit;
}*/

	$frmModo	=	$_FRMMODO;
	$ramo		=	$_RAMO;
	$curso      =	$_CURSO;
	$institucion = $_INSTIT;
	
	 $sql_1 = "select * from curso where id_curso = '$curso'";
	$res_1 = @pg_Exec($conn,$sql_1);
	$fil_1 = @pg_fetch_array($res_1);
	$truncado_sf = $fil_1['truncado_sf'];

	 //solucion a error 
	//echo "-->".$final=$prom;
	
	if ($frmModo=="modificar"){
	
		$qry2="SELECT pct_examen, nota_exim, pct_ex_escrito, pct_ex_oral,truncado_ex_final FROM ramo WHERE id_ramo=".$ramo;
		$result2=@pg_Exec($conn,$qry2);
		if (@pg_numrows($result2)!=0){
			$fila2 = @pg_fetch_array($result2,0);
			 $exim = $fila2['nota_exim'];
			$truncado_ex_final=$fila2['truncado_ex_final'];
		}
		for ($i=0 ; $i < $contalum ; $i++){
			if(($fila2['pct_ex_escrito']==NULL)or($fila2['pct_ex_escrito']==0)){ 
				 if($prom[$i] >= $exim){
				     $txtExamen[$i]= $prom[$i];
					  if ($txtEspecial[$i] >=40){
							$final[$i]=(round(40));
					 }else{
						 if($prom[$i] < $txtEspecial[$i]){
							$final[$i]= $txtEspecial[$i]; 
						 }else{
							$final[$i]= $prom[$i];
						 }
					 }
				 }else{
					$porc = $fila2['pct_examen'];
					$pct_prom=(100-$porc);
					if(($txtEspecial[$i]!="")and ($txtEspecial[$i] >=40)){
						$final[$i]=(round(40));
						 
					}else{   
					    // ----------------- SE AGREGAR VARIABLE DE INSTITUCION COLEGIO DIDIDER PARA CALCULO SOLO DE PROMEDIO DE NOTAS ---------------//
						if(($txtExamen[$i]!="" && $txtExamen[$i]!=0)){

							$fin[$i]=(number_format((($prom[$i])*($pct_prom/100))+(($txtExamen[$i])*($porc/100)),1 ));
							if ($truncado_ex_final==0){
							     
								 $final[$i] = substr($fin[$i],0,2);
							
							}else{
							
							if ($truncado_ex_final==1){ 
							$final[$i]=(round($fin[$i]));}
							}	
							
						}else{
							
							$final[$i]=$prom[$i]; /// primera solucion de error pcardenas
							$txtExamen[$i]=0;
							
						}
						/*if($prom[$i] < $txtEspecial[$i]){
							$final[$i]= $txtEspecial[$i]; 
						 }else{
							$final[$i]= $prom[$i];
						 }
						*/
					}
				}

			}else{
				if(( ($txtExamenEsc[$i]!="")&&($txtExamenEsc[$i]!=0)) && (($txtExamenOral[$i]=="")&&($txtExamenOral[$i]==0))){
					if($prom[$i] >= $exim){
					   $txtExamenEsc[$i]= $prom[$i];
					   if ($txtEspecial[$i] >=40){
							 $final[$i]=(round(40));
					  }else{
							$final[$i]= $prom[$i];
					 }
					}else{
						$porc = $fila2['pct_examen'];
						$pct_prom=(100-$porc);
						if(($txtEspecial[$i]!="") and ($txtEspecial[$i] >=40)){
							$final[$i]=(round(40));
						}else{
							$fin[$i]=(number_format((($prom[$i])*($pct_prom/100))+(($txtExamenEsc[$i])*($porc/100)),1 ));
							$final[$i]=(round($fin[$i]));
						}
					}
				}
				
				if(($txtExamenEsc[$i]=="") && ($txtExamenOral[$i]=="")){ 
					if($prom[$i] >= $exim){
					   $txtExamenEsc[$i]= $prom[$i];
						if ($txtEspecial[$i] >=40){
							$final[$i]=(round(40));
						}else{
							$final[$i]=$prom[$i];
						   }
					}else{
						$porc = $fila2['pct_examen'];
						$pct_prom=(100-$porc);
						if(($txtEspecial[$i]!="")and ($txtEspecial[$i] >=40)){
							$final[$i]=(round(40));
						}else{
							$pct_escrito = $fila2['pct_ex_escrito'];
							$pct_oral	= $fila2['pct_ex_oral'];
							$porc = $fila2['pct_examen'];
							$pct_prom=(100-$porc);
							$valor=$prom[$i];
							$Nota_Examen= (($txtExamenEsc[$i]*($pct_escrito/100))+($txtExamenOral[$i]*($pct_oral/100)));
							$fin[$i]=(number_format((($prom[$i])*($pct_prom/100))+(($Nota_Examen)*($porc/100)),1 ));
													
					
							 $final[$i]=(round($fin[$i]));
							   
						}
					}
				}
				
				if(($txtExamenEsc[$i]=="")&&($txtExamenOral[$i]=="")){
					$final[$i]=0;
					$txtExamenEsc[$i]=0;
					$txtExamenOral[$i]=0;
				}
				
			}
			
		if ($prom[$i]==""){
		   $prom[$i]=0;
		   $txtExamen[$i]=0;
		   $final[$i]=0;
	   }
				
				
				  $qry3="SELECT * from situacion_final WHERE  RUT_ALUMNO='".$rut_Alu[$i]."' AND ID_RAMO=".$ramo;
				  $result3=pg_Exec($conn,$qry3);
						if ($txtEspecial[$i]==""){
						    $txtEspecial[$i]=0;
						}
					 if (pg_numrows($result3)==0){
						
						if($fila2['pct_ex_escrito']==0){
						
						$qry="INSERT INTO situacion_final (rut_alumno, id_ramo, prom_gral, nota_examen, nota_final, prueba_especial) VALUES (".$rut_Alu[$i].",".$ramo.",".$prom[$i].",".intval($txtExamen[$i]).",".$final[$i].",".$txtEspecial[$i].")";
						
						}else{
						
						$qry="INSERT INTO situacion_final (rut_alumno, id_ramo, prom_gral, nota_exam_esc, nota_final, prueba_especial) VALUES	(".$rut_Alu[$i].",".$ramo.",".$prom[$i].",".intval($txtExamenEsc[$i]).",".$final[$i].",".$txtEspecial[$i].")";
						
						}
						
						$result=pg_exec($conn,$qry);
						
						if (!$result){
							imprime_array($final);
							echo ('<B> ERROR :</b>Error al acceder a la BD.(1)</B>'. $qry );
							exit();
						}
					}else{
						
						if(($txtExamenEsc[$i]!=" ") && ($txtExamenOral[$i]!=" ")){
							if($fila2['pct_ex_escrito']==0){
							
							/*echo*/ "<br>".$qry4="UPDATE situacion_final SET prom_gral=".$prom[$i].", nota_examen=".$txtExamen[$i].", nota_final=".$final[$i].", prueba_especial='".$txtEspecial[$i]."' WHERE RUT_ALUMNO='".$rut_Alu[$i]."' AND ID_RAMO=".$ramo."";
							
							}else{
							
								if($txtExamenOral[$i]=="") $txtExamenOral[$i]=0;
							
							$qry4="UPDATE situacion_final SET prom_gral=".$prom[$i].", nota_exam_esc=".$txtExamenEsc[$i].",nota_exam_oral=".$txtExamenOral[$i].", nota_final=".$final[$i].", prueba_especial='".$txtEspecial[$i]."' WHERE RUT_ALUMNO='".$rut_Alu[$i]."' AND ID_RAMO=".$ramo."";
							}
						}
							$result4=@pg_Exec($conn,$qry4);
						if(($txtExamenEsc[$i]!=0) && ($txtExamenOral[$i]==0)){
							if($txtExamenOral[$i]=="") $txtExamenOral[$i]=0;
								
								$qry4="UPDATE situacion_final SET prom_gral=".$prom[$i].", nota_exam_esc=".$txtExamenEsc[$i].",nota_exam_oral=".$txtExamenOral[$i].", 
								nota_final=".$final[$i].", prueba_especial='".$txtEspecial[$i]."' WHERE RUT_ALUMNO='".$rut_Alu[$i]."' AND ID_RAMO=".$ramo."";
								$result4=@pg_Exec($conn,$qry4);
							
							if (!$result4)
								error('<B> ERROR :</b>Error al acceder a la BD.(22)</B>'.$qry4 );
						}
						if(($txtExamenEsc[$i]!=0) && ($txtExamenOral[$i]!=0)){
							
							$qry4="UPDATE situacion_final SET prom_gral=".$prom[$i].", nota_exam_esc=".$txtExamenEsc[$i].",nota_exam_oral=".$txtExamenOral[$i].", nota_final=".$final[$i].", prueba_especial='".$txtEspecial[$i]."' WHERE RUT_ALUMNO='".$rut_Alu[$i]."' AND ID_RAMO=".$ramo."";
							$result4=@pg_Exec($conn,$qry4);
							
							if (!$result4)
								error('<B> ERROR :</b>Error al acceder a la BD.(222)</B>'.$qry4 );
						}
						if($txtExamen[$i]!=""){
						    if ($txtEspecial[$i]>$prom[$i] and $txtEspecial[$i] < 41){
							    if ($_PERFIL==0){
								     echo "Paso $i  <br>";
								}	 
								$qry4="UPDATE situacion_final SET prom_gral=".$prom[$i].", nota_examen=".$txtExamen[$i].", nota_final=".$txtEspecial[$i].", prueba_especial='".$txtEspecial[$i]."' WHERE RUT_ALUMNO='".$rut_Alu[$i]."' AND ID_RAMO=".$ramo."";
						
							}else{
								
								//simple
								$qry4="UPDATE situacion_final SET prom_gral=".$prom[$i].", nota_examen=".$txtExamen[$i].", nota_final=".$final[$i].", prueba_especial='".$txtEspecial[$i]."' WHERE RUT_ALUMNO='".$rut_Alu[$i]."' AND ID_RAMO=".$ramo."";
							}
							
							
							$result4=@pg_Exec($conn,$qry4);
							if (!$result4)
								error('<B> ERROR :</b>Error al acceder a la BD.(2222)</B>'.$qry4 );

						}
							/*$result4=@pg_Exec($conn,$qry4);
							if (!$result4)
								error('<B> ERROR :</b>Error al acceder a la BD.(2)</B>'.$qry4 ); */
					}
	 }//fin for
}

elseif ($frmModo=="eliminar"){
	
}
	echo "<script>window.location = 'seteaSituacionFinal.php3?caso=1&curso=".$_CURSO."'</script>";
	
?>
	