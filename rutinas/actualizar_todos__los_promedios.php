<?
error_reporting(E_ALL);
ini_set('display_errors', 1);  


/* phpinfo(); 
 return;*/
 
/*RUTINA PARA ACTUALIZAR LOS PROMEDIOS PARA LOS WNS QUE ESCRIBEN MUY RAPIDO EN EL MODULO DE NOTAS y LAS RUTINAS JSCRIPT NO ALCANZAN A ACTUALIZAR LA CELDA PROMEDIO*/
if(!ini_get('safe_mode') ){ 
set_time_limit(0);  
} 

//$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");


 //$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Viña.");
 
 $conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");	
	
// $conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Corporacion.");	
			 
if($conn){
	echo pg_dbname($conn);
	echo "<br/>Conectado<br/>";
	}

 

 /*$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");	
 
 $conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Corporacion.");*/	

function desifranotaconseptual($dato){
$nueva_nota=0;
if ( (trim($dato)=='MB') || (trim($dato)=='mb') || (trim($dato)=='Mb') || (trim($dato)=='mB') ){ $nueva_nota = '65';   }
if ( (trim($dato)=='B') || (trim($dato)=='b') ){ $nueva_nota = 55;	}//B		
if ( (trim($dato)=='S') || (trim($dato)=='s') ){ $nueva_nota = 45; } //S
if ( (trim($dato)=='I') || (trim($dato)=='i') ){ $nueva_nota = 35;	}//I
return $nueva_nota;
	}

function promedioconceptual( $prom_conc ){
	$letra = "x";
	if( $prom_conc >=60 && $prom_conc <= 70 ) $letra = 'MB';
	if( $prom_conc >=50 && $prom_conc <= 59 ) $letra = 'B';
	if( $prom_conc >=40 && $prom_conc <= 49 ) $letra = 'S';
	if( $prom_conc >=0   && $prom_conc <= 39 ) $letra = 'I';
	return $letra;
	}

function aprox_entero( $nota ){
	$prom_nuevo = 0;
	if ( $nota >= 65 && $nota <= 70 )  $prom_nuevo = 70;
	if ( $nota >= 60 && $nota <= 64 )  $prom_nuevo = 60;
	if ( $nota >= 55 && $nota <= 59 )  $prom_nuevo = 55;
	if ( $nota >= 50 && $nota <= 54 )  $prom_nuevo = 50;								
	if ( $nota >= 45 && $nota <= 49 )  $prom_nuevo = 45;
	if ( $nota >= 40 && $nota <= 44 )  $prom_nuevo = 40;
	if ( $nota >= 0   && $nota <= 39 )  $prom_nuevo = 35;
	return $prom_nuevo;
	}


/*OBTENGO TODOS LOS PERIODOS DE TODOS LOS RDB*/
echo $sql="SELECT inti.rdb,pe.id_periodo,pe.nombre_periodo
FROM institucion AS inti
INNER JOIN ano_escolar anes ON anes.id_institucion = inti.rdb  AND anes.nro_ano = 2011 
INNER JOIN periodo pe ON pe.id_ano = anes.id_ano
WHERE inti.rdb=287 ORDER BY 1,2,3 ;";
$result_sql = pg_Exec($conn,$sql) or die ("ERROR SISTEMA");

echo pg_num_rows($result_sql);

for($ix=0;$ix<pg_num_rows($result_sql);$ix++){

 $fila_todo = pg_fetch_array($result_sql,$ix);

/*TODOAS LAS NOTAS DEL PERIODO*/
echo "<br/>";
echo $sql ="SELECT * FROM NOTAS2011 WHERE ID_PERIODO=".$fila_todo['id_periodo']."order by 2;";
$rs_notas = @pg_exec($conn,$sql);

for($i=0;$i<pg_num_rows($rs_notas);$i++){
	
	$fila = pg_fetch_array($rs_notas,$i);

        echo "<br/>";
		echo $qry="SELECT * FROM ramo WHERE ramo.id_ramo=".$fila['id_ramo'].";";
        $result = pg_Exec($conn,$qry);
        		        
        if (pg_num_rows($result)!=0){
                
				$fila10 = @pg_fetch_array($result,0);
				$modo_eval = trim($fila10['modo_eval']);
                $modo_eval_p_nivel = trim($fila10['modo_eval_pnivel']);
                $truncado_pnivel  = trim($fila10['truncado_pnivel']);
                $aprox_entero = trim($fila10["aprox_entero"]);
                $truncado = trim($fila10['truncado']);	
                $pct_nivel = trim($fila10['pct_nivel']);
                $prueba_nivel = trim($fila10['prueba_nivel']);
				$bool_bloq = trim($fila10['bool_bloq']); 	   
				
				}
	
	$rut_alumno = $fila['rut_alumno'];
	$contador = 0;
	$suma = 0;
    $promedio = 0;
	
	for($j=1;$j<20;$j++){
		
		$n ="nota".$j;
		$nota = $fila[$n];	
		
		if( ($fila['rut_alumno']==$rut_alumno) ){
		
		/*Notas Numericas Se Suman DIrectamente*/
		if( $modo_eval == 1 || $modo_eval == 3 ){
			 $suma = $suma + $nota ;
		   }  
				 
		 /*Notas Conceptual pasar a Numerico para despues Sumar*/	
		 if( $modo_eval == 2 || $modo_eval == 4 ){
			      $nota=desifranotaconseptual($nota);
   			      $suma = $suma + $nota;
   	    	   }
		
		  if($nota >0)$contador++;	
		
		}

		
		if($j==19){
		
		/*Promedio Numerico Truncado*/	
		if( $modo_eval == 1 || $modo_eval == 3 ){
		   if( $truncado == 1 ){
			   if( $suma > 0 ) $promedio =  round( $suma / $contador );
		   }else{
			   if( $suma > 0 ) $promedio =  intval( $suma / $contador );
		   }
		}
		
		 /************/	 
		if( $modo_eval == 3  ){
			  	 $promedio =  promedioconceptual( $promedio );
			  }
       /************/	 
	   
       /*Promedio Conceptual*/
	   if( $modo_eval == 2 || $modo_eval == 4 ){
			   if( $suma > 0 ) $promedio =  intval( $suma / $contador );
			   if( $modo_eval_p_nivel != 1 && $modo_eval == 2 ){
					  $promedio =  promedioconceptual( $promedio );
				   }
			   }
		/************/	 					 
                    
	    /*Aproxima a Entero*/
		if( $aprox_entero ==1 && $modo_eval == 1 ){
				$promedio = aprox_entero( $promedio );
			  }
		 /************/	
		 
		/*Prueba Nivel*/ 
		// Si no existe prueba de nivel quedara la variable en 0;
		if( $fila["nota20"]  != "" ){  
		   $notapruebadenivel = $fila["nota20"];
		}else{
		   $notapruebadenivel = 0;
		 }		
		 
		if( $notapruebadenivel != "" && $modo_eval == 1 &&  $prueba_nivel == 1 ){
                if( $modo_eval_p_nivel == 1 ){   /*prueba de nivel del tipo numerico*/ 
					if( $promedio > 0 ) $promedio  = (  $promedio * ( 100 - $pct_nivel )  )  / 100; 
					$otro  =  (  $notapruebadenivel  *  $pct_nivel  )   / 100;
					$promedio =  $promedio  +  $otro;
				if(  $truncado_pnivel  ==  1 ){
					if( $promedio > 0 ) $promedio = round($promedio,0);
				}else{
				   if( $promedio > 0 ) $promedio = $promedio;
				}
			 }
		  }
	   /*FIN Prueba Nivel*/ 
				 
		$sql_Update = "UPDATE notas2011 SET promedio='".$promedio."' WHERE rut_alumno=".$fila['rut_alumno']." AND id_ramo=".$fila['id_ramo']." AND id_periodo=".$fila['id_periodo']."";
		$rs_promedio = pg_exec( $conn,$sql_Update ) or die("Error de Sistemas");
		
		echo '<br/>'.$sql_Update."<br/>";
		
		
		}
	
	} 
	
	
		
 } 


}


echo "<h1><strong>".$i."</strong></h1>"

/*************************************************************************/

?>