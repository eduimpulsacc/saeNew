<? require('../../../../../../util/header.inc');

$frmModo	=$_FRMMODO;
$ano		=$_ANO;
$ramo		=$_RAMO;
$curso		=$_CURSO;
echo "quiz->".$cmbPERIODO	=$cmbPERIODO;
echo "<br>real->".$periodo_real = $_PERIODOREAL;
$porc_examen_quiz = $porc_examen_quiz;
$porc_restante = intval(100-$porc_examen_quiz);

//var_dump($_POST);
//exit;

for($i=0;$i<$contadori;$i++){
		 $rut = $rut_Alu[$i];
		/* $promedio = intval($prom_Alu[$i]);	
		 $examen = intval($txtExamen[$i]);	
		 $p_final = intval($p_final[$i]);	*/
		 $promedio = ${"prom_Alu".$i};	
		 $examen = ${"txtExamen".$i};	
		 //$p_final = ${"p_final".$i};	
		 
		 if(intval($examen)==0)
		 {$examen=$promedio;}
			
			//reviso si esta el rut en la tabla. si esta, update, si no, insert
			echo "<br>". $sql_ex1 = "select rut_alumno from quiz_examen where rut_alumno = $rut and id_curso = $curso and id_ramo = $ramo and id_periodo = $cmbPERIODO and periodo_real=$periodo_real" ;
			$re_ex1 = @pg_exec($conn,$sql_ex1);
			
			
			if(@pg_num_rows($re_ex1)>0){
			$p_prom = ($promedio*($porc_restante/100))+($examen*($porc_examen_quiz/100));	
			
			if($truncado_examen_quiz==0 || $truncado_examen_quiz==NULL){
				$p_final= intval($p_prom);
			}else{
				$p_final=round($p_prom);
			}


				
				//si encuentro cosas, solo actualizo
			echo "<br>". $sq2 = "update quiz_examen set  promedio = $promedio,examen = $examen,promedio_final =$p_final,periodo_real=$periodo_real where rut_alumno = $rut and id_curso = $curso and id_ramo = $ramo and id_periodo = $cmbPERIODO and periodo_real=$periodo_real";
			}else{ //como no encontre dato, inserto 
			$p_prom = ($promedio*($porc_restante/100))+($examen*($porc_examen_quiz/100));	
			
			if($truncado_examen_quiz==0 || $truncado_examen_quiz==NULL){
				$p_final= intval($p_prom);
			}else{
				$p_final=round($p_prom);
			}
			echo "<br>". $sq2 = "insert into quiz_examen (id_curso,id_ramo,id_periodo,rut_alumno,promedio,examen,promedio_final,periodo_real)values ($curso,$ramo,$cmbPERIODO,$rut,$promedio,$examen,$p_final,$periodo_real)";
				}
				
			$re_ex2 = @pg_exec($conn,$sq2);	
			//echo $sq2;exit;
	//vuelta
echo "<script>parent.location.href = 'examen_quiz.php?truncado=&id_ramo=$ramo&viene_de=../listarRamos.php3&estado=1' </script>";
		
}

?>
