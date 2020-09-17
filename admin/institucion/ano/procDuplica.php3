<?php require('../../../util/header.inc');?>
<?php
 
   $qryC = "select * from curso";
     $resultC = @pg_Exec($conn,$qryC);
	   for($i=0 ; $i < @pg_numrows($resultC) ; $i++){
	      $filaC = @pg_fetch_array($resultC,$i);
		  $curso = $filaC['id_curso'];
		  $tipo = $filaC['ensenanza'];
		  $ano  = $filaC['id_ano'];
		  
	$qryI = "select * from ano_escolar where id_ano=".$ano;
	  $resultI = @pg_Exec($conn,$qryI);
	      $filaI = @pg_fetch_array($resultI,0);
		  $rdb = $filaI['id_institucion'];

	$qry="SELECT corre FROM tipo_ense_inst where cod_tipo =".$tipo." and rdb=".$rdb;
	  $result = @pg_Exec($conn,$qry);
	   $fila1 = @pg_fetch_array($result,0);
	    $corre  = $fila1['corre'];
		
		$cont =0;
			$qryM="SELECT * FROM hora_jm WHERE corre=".$corre;
			$resultM = @pg_Exec($conn,$qryM);
			$cuentaM  = @pg_numrows($resultM);
				if ($cuentaM >0){
				 $cont = $cont +1;
				 $jornada=1;
				 }
				
			$qryM="SELECT * FROM hora_jt WHERE corre=".$corre;
			$resultM = @pg_Exec($conn,$qryM);
			$cuentaM  = @pg_numrows($resultM);
				if ($cuentaM >0){
				 $cont = $cont +1;
				 $jornada =2;
				 }
				
				
			$qryM="SELECT * FROM hora_mt WHERE corre=".$corre;
			$resultM = @pg_Exec($conn,$qryM);
			$cuentaM  = @pg_numrows($resultM);
				if ($cuentaM >0) {
				$cont = $cont +1;
				$jornada =3;
				}

			$qryM="SELECT * FROM hora_jv WHERE corre=".$corre;
			$resultM = @pg_Exec($conn,$qryM);
			$cuentaM  = @pg_numrows($resultM);
				if ($cuentaM >0) {
				$cont = $cont +1;
				$jornada = 4;
				}
				
				
				if ($cont >1){
				 echo $curso."<br>";
				 }else{
				   if($cont ==1){
				$qryU = "update curso set bool_jor=".$jornada." where id_curso=".$curso;
					$resultU = @pg_Exec($conn,$qryU);
					
				    } 
				}
		}
		pg_close($conn);
		echo "fin";
?>