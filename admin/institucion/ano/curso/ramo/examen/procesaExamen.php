<? require('../../../../../../util/header.inc');

$frmModo	=$_FRMMODO;
$ano		=$_ANO;
$ramo		=$_RAMO;
$curso		=$_CURSO;
$cmbPERIODO	=$_PERIODO;

if($frmModo=="modificar"){
	for($j=0;$j<$contadorj;$j++){	
		$rut = ${"rut".$j};
		$Promedio = ${"promedio".$j};
		for($i=0;$i<$contadori;$i++){
			$Nota 	=${"txtEXAMEN".$j.$i};
			$Examen =${"id_examen".$i};
			if($Nota!=""){
				$sql ="SELECT * FROM notas_examen WHERE id_examen=".$Examen." AND id_curso=".$curso." AND id_ramo=".$ramo." AND id_ano=".$ano." AND rut_alumno=".$rut." and periodo=".$cmbPERIODO;
				
				$rs_examen = @pg_exec($conn,$sql);
				if(@pg_numrows($rs_examen)==0){
					$sql ="INSERT INTO notas_examen (id_examen,id_curso,id_ramo,id_ano,rut_alumno,periodo,nota) VALUES (".$Examen.",".$curso.",".$ramo.",".$ano.",".$rut.",".$cmbPERIODO.",".$Nota.")";
					$rs_notas = @pg_exec($conn,$sql);
					
					$sql ="INSERT INTO promedio_examen (id_curso,id_ramo,id_ano,rut_alumno,id_periodo,promedio) VALUES(".$curso.",".$ramo.",".$ano.",".$rut.",".$cmbPERIODO.",".$Promedio.")";
					$rs_promedio = @pg_exec($conn,$sql);
				}else{
					$sql = "UPDATE notas_examen SET nota=".$Nota." WHERE id_examen=".$Examen." AND id_curso=".$curso." AND id_ramo=".$ramo." AND id_ano=".$ano." AND rut_alumno=".$rut." AND periodo=".$cmbPERIODO;
					$rs_notas = @pg_exec($conn,$sql);					
					
					$sql = "UPDATE promedio_examen SET promedio=".$Promedio." WHERE id_curso=".$curso." AND id_ramo=".$ramo." AND id_ano=".$ano." AND rut_alumno=".$rut." AND id_periodo=".$cmbPERIODO;
					$rs_promedio=@pg_exec($conn,$sql);
				}
				
			}
		}
	} 
}
echo "<script>parent.location.href = 'seteaExamen.php?caso=1&cmbPERIODO=".$cmbPERIODO."&id_ramo=".$ramo."' </script>";	

?>