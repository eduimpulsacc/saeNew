<? 
//$conn=@pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");
$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Corporacion.");
//$conn=pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");


$ano =1182;
function Concepto($nota, $tipo){
	//$tipo = 1 --- $nota viene con valor numérico devuelve conceptual
	//$tipo = 2 --- $nota viene con valor conceptual devuelve numérico
	$nota_res=0;
	$concepto="";		
	if ($tipo == 1){
		if ($nota >= 60 and $nota<=70)
			$concepto = "MB";
		if ($nota >= 50 and $nota<=59)
			$concepto = "B";
		if ($nota >= 40 and $nota<=49)
			$concepto = "S";
		if ($nota >= 0 and $nota<=39)
			$concepto = "I";
		if($nota==0)
			$concepto = "-";
		return $concepto ;
	}else{
		if (trim($nota) == "MB")
			$nota_res = 65;
		if (trim($nota) == "B")
			$nota_res = 55;			
		if (trim($nota) == "S")
			$nota_res = 45;
		if (trim($nota) == "I")
			$nota_res = 35;						
		return $nota_res;
	}
}
	/**************PONER ID_ANO PARA LOS PERIODOS***************/
    $qry_per = "select * from periodo where id_ano =".$ano;
	 $res_per = @pg_Exec($conn,$qry_per);
	 $num_per = @pg_numrows($res_per);
	 
	 if ($num_per == 2){
	      $fil_per = @pg_fetch_array($res_per,0);
		echo  "<br>"."pero1--->".$periodo1 = $fil_per['id_periodo'];
		  
		  $fil_per = @pg_fetch_array($res_per,1);
		  echo "per2---->".$periodo2 = $fil_per['id_periodo'];
	 }else{
	      echo "Error, fatal 1 <br>";
		  exit();
	 }
	 
	 

	$total=0;
  $sql ="select id_ramo, curso.truncado_final FROM ramo inner join curso on curso.id_curso= ramo.id_curso
       where id_ano=".$ano." and ramo.modo_eval=3";
	   
	   $res=pg_exec($conn,$sql)or die("fallo_x".$sql);
	   
	   for($i=0; $i<pg_numrows($res); $i++){
		  $fila=pg_fetch_array($res,$i);
		 $id_ramo = $fila['id_ramo']; 
		 $truncado_final=$fila['truncado_final'];
		  
		  
		  $qry="select * from tiene2011 where id_ramo=".$id_ramo;
		  $res_tiene=pg_exec($conn,$qry)or die("fallo_2");
		  
		  for($x=0; $x<pg_numrows($res_tiene);$x++){
			  
			  $fila_tiene=pg_fetch_array($res_tiene,$x);
			  $rut_alumno=$fila_tiene['rut_alumno'];
			  
	   $sql_notas="select * from notas2011 where id_ramo=".$id_ramo." 
			       and rut_alumno=".$rut_alumno." and id_periodo=".$periodo1;
			  $rs_notas=pg_exec($conn,$sql_notas)or die("Fallo_xxx".$sql_notas);
		 for($z=0; $z<pg_numrows($rs_notas);$z++){
			  $fila_notas=pg_fetch_array($rs_notas,$z);
			   $periodo_primero=$fila_notas['id_periodo'];
			   "<br>".$periodo; 
			  $conta=0;
			  $suma=0;
		 for($j=1; $j<20; $j++){
				   $notas=$fila_notas['nota'.$j];
		 if( $notas>0){
					$notas;
			 $suma = $suma + $notas;
			 $conta++;	
				
				
			$promedio1 = round($suma / $conta);
		    }
	    }
		
	 }
	 	
	      "<br>"."promedio-->".$promedio1;
		  "<-----concepto-->".$promediocon1;
		  
		  
		  
		   $sql_notas2="select * from notas2011 where id_ramo=".$id_ramo." 
			       and rut_alumno=".$rut_alumno." and id_periodo=".$periodo2;
			  $rs_notas2=pg_exec($conn,$sql_notas2)or die("Fallo_xxx".$sql_notas2);
		 for($y=0; $y<pg_numrows($rs_notas2);$y++){
			  $fila_notas2=pg_fetch_array($rs_notas2,$y);
			   $periodo_segundo=$fila_notas2['id_periodo'];
			  $conta2=0;
			  $suma2=0;
			  
		 for($k=1; $k<20; $k++){
				   $notas2=$fila_notas2['nota'.$k];
		 if( $notas2>0){
					$notas2;
			 $suma2 = $suma2 + $notas2;
			 $conta2++;	
				
				
			$promedio2 = round($suma2 / $conta2);
			
			
			
		    }
	    }
		
	 }
	echo"<br>"."promedio1-->".$promedio1;
	echo"<-----promedio2-->".$promedio2."--";
	
	if($truncado_final==1){
	echo "promedio_promedio--------------------------->".$promedio_promedio=round(($promedio1 + $promedio2)/2);
	}else{
	echo "promedio_promedio--------------------------->".$promedio_promedio=intval(($promedio1 + $promedio2)/2);	
		}
	
	echo "----------------------->>>>".$promedio_conceptual = Concepto($promedio_promedio,1);
		  
		//echo  "<br>"."total--->".$total=($promedio1+$promedio2);
		
			$sql_up="UPDATE  promedio_sub_alumno AS ps SET promedio = '".$promedio_conceptual."' 
			WHERE  promedio_sub_alumno.id_ramo=".$id_ramo." and promedio_sub_alumno.rut_alumno=".$rut_alumno;
			
			$rs_update=pg_exec($conn,$sql_up)or die("Fallo esta /&%$$%xxx");
			
	}
	 
}
	   
	   
	   


?>