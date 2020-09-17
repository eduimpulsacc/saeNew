<? require('../../../../../../util/header.inc');?>
<?php 

$frmModo	=$_FRMMODO;
$ano		=$_ANO;
$ramo		=$_RAMO;
$curso		=$_CURSO;
$cmbPERIODO	=$cmbPERIODO;
$periodo_real = $_PERIODOREAL;



// nro año 
$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
$result_ano =@pg_Exec($conn,$sql_ano);
$fila_ano = @pg_fetch_array($result_ano,0);	
$nro_ano = $fila_ano['nro_ano'];

//configuracion ramo
$sql ="SELECT * FROM ramo WHERE id_ramo=".$ramo;
		$rs_ramo = @pg_exec($conn,$sql) or die ("SELECT RAMO:".$sql);
		$fila_ramo =@pg_fetch_array($rs_ramo,0);
		$truncado_per = $fila_ramo['truncado_per'];
		$truncado = $fila_ramo['truncado'];
		



//datos del periodo real que este abierto
$sql_per = "select * from periodo where id_ano = $ano and cerrado=0";
$result_per =@pg_Exec($conn,$sql_per);
if(pg_num_rows($result_per)!=1){
echo "<script>alert('Debe Haber solo un (1) periodo abierto')
location.href = '../../../periodo/listarPeriodo.php3';
</script>";
}
else{
$fil_preal = pg_fetch_array($result_per,0);
}

//periodo real
 $per_real =$fil_preal['id_periodo'];

/********************/

//die($per_real);

//datos del periodo quiz que este abierto, y con eso obtengo la posicion de la nota
$sql_pquiz = "select * from quiz_periodos where id_periodo = $cmbPERIODO";
$res_pquiz = @pg_exec($conn,$sql_pquiz);
$fila_pquiz = @pg_fetch_array($res_pquiz,0);
$posicion_nota = $fila_pquiz['posicion_nota'];

//recibir el promedio final del curso
$sql_prexquiz = "select rut_alumno, promedio_final from quiz_examen where  id_curso = $curso and id_ramo = $ramo and id_periodo = $cmbPERIODO and periodo_real=$periodo_real order by rut_alumno";
 

$res_pquiz = @pg_exec($conn,$sql_prexquiz);

//listo alumnos del curso
for($i=0;$i<@pg_num_rows($res_pquiz);$i++){
	$sum =0;
	$cont=0;
	//veo si el alumno tiene notas en el periodo real
	$fil_alu = pg_fetch_array($res_pquiz,$i);
	$rut = $fil_alu['rut_alumno'];
	$nota_quiz = $fil_alu['promedio_final'];
	
	//busco si el alumno posee notas en los periodos reales
	 $sql_notasreal = "select * from notas$nro_ano where rut_alumno = $rut and id_ramo = $ramo and id_periodo = $per_real";
	$res_notasreal = @pg_exec($conn,$sql_notasreal);
	
	//si no ninguna nota, insertare algo en la posicion que necesite
	if(pg_num_rows($res_notasreal)<1){
	 $sql_not = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo, nota$posicion_nota, promedio) values ($rut,$ramo,$per_real,'$nota_quiz','$nota_quiz')" ;
	 $res_not = @pg_exec($conn,$sql_not);
	
	}
	
	//si tengo notas, busco las notas que tengo que sumar, actualizo la nota de la posicion del periodo y calculo el nuevo el promedio final
	else{
		for($p=0;$p<pg_num_rows($res_notasreal);$p++){
			$fila_notas = pg_fetch_array($res_notasreal,$p);
			
			for($xx=1;$xx<21;$xx++){
				$posicion = "nota$xx";
				$nota = intval($fila_notas[$posicion]);
				
				if($nota >0){
				$sum = $sum + $nota;
				$cont ++;
				}
				
				if($xx == $posicion_nota){
				 $sql_not = "update notas$nro_ano set $posicion = '$nota_quiz' where rut_alumno = $rut  and id_ramo = $ramo and id_periodo = $per_real";
				//ejecuto query de insert o update notas
				$res_not = @pg_exec($conn,$sql_not);
				}
				
			}
			
		}
		//calculo promedio
		//echo "<br>sum-->".$sum." contador-->".$cont;
		
		
		if($cont>0){
		$promedio = $sum / $cont;
		}
		else{$promedio=0;}
		
		//veo si hay que redondear o no
		if($truncado==0 || $truncado== null)
		{
			$prom_final = intval($promedio);
		}
		else{
			$prom_final =  round($promedio);
		}

		
		
		//query de actualizar promedios
		$sql_prom = "update notas$nro_ano set promedio = '".$prom_final."' where rut_alumno = $rut and id_ramo = $ramo and id_periodo = $per_real";
		$res_prom = @pg_exec($conn,$sql_prom);
	
	}
	
	
	
}

//vuelta
echo "<script>parent.location.href = 'examen_quiz.php?truncado=&id_ramo=$ramo&viene_de=../listarRamos.php3&estado=2' </script>";
?>