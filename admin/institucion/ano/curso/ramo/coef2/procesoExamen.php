<? require('../../../../../../util/header.inc');

$frmModo	=$_FRMMODO;
$ano		=$_ANO;
$ramo		=$_RAMO;
$curso		=$_CURSO;
$cmbPERIODO	=$cmbPERIODO;




for($i=0;$i<$contadori;$i++){
		 $rut = $rut_Alu[$i];
		/* $promedio = intval($prom_Alu[$i]);	
		 $examen = intval($txtExamen[$i]);	
		 $p_final = intval($p_final[$i]);	*/
		 $promediobase = trim(${"prom_Alu".$i});
		
		 $examen = trim(${"txtnota1".$i});	
		 $promedio = trim(${"p_final".$i});	
		
		 if(intval($examen)==0)
		 {
			 $examen=$promediobase;
		 	$promedio=$promediobase;
		 }
		 
		 if(intval($promediobase)==0)
		 {
			$examen =0;
			$promedio=0;
				
		 }
		 
		 
			
		//reviso si esta el rut en la tabla. si esta, update, si no, insert
			 $sql_ex1 = "select rut_alumno from notacoef where rut_alumno = $rut and id_ramo = $ramo and id_periodo = $cmbPERIODO" ;
				$re_ex1 = @pg_exec($conn,$sql_ex1);
			
		
			if(@pg_num_rows($re_ex1)>0){
			
			
			if($aprox_coef2==0 || $aprox_coef2==NULL){
				$p_final= intval($promedio);
			}else{
				$p_final=round($promedio);
			}


				
				//si encuentro cosas, solo actualizo
			$sq2 = "update notacoef set  promediobase=$promediobase, nota1=$examen, nota2=$examen,  promedio=$promedio where rut_alumno = $rut and id_ramo = $ramo and id_periodo = $cmbPERIODO ";
			}else{ //como no encontre dato, inserto 
			
			
			if($aprox_coef2==0 || $aprox_coef2==NULL){
				$p_final= intval($p_prom);
			}else{
				$p_final=round($p_prom);
			}
			 $sq2 = "insert into notacoef values ($rut,$ramo,$cmbPERIODO,$promediobase,$examen,$examen,$promedio)";
				}
				
				//echo $sq2; 
			$re_ex2 = @pg_exec($conn,$sq2);	
			//echo $sq2;
	//vuelta
	
echo "<script>parent.location.href = 'examen.php?truncado=&id_ramo=$ramo&periodo=$cmbPERIODO&viene_de=../listarRamos.php3' </script>";
		
}

?>
