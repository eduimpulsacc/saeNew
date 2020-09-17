<? 

function dia_mes($mes,$ano){
	if($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 || $mes==10 || $mes==12){
		$dia=31;
	}elseif($mes==4 || $mes==6 || $mes==9 || $mes==11){
		$dia=30;
	}elseif(($ano%4)==0){
		$dia=29;
	}else{
		$dia==28;
	}
	return $dia;
}

function ComparaFecha($fecha1,$fecha2){
        $mesC1= (int) substr($fecha1,8,2);
        $diaC1= (int) substr($fecha1,5,2);
        $anoC1= (int) substr($fecha1,0,4);
        $mesC2= (int) substr($fecha2,8,2);
        $diaC2= (int) substr($fecha2,5,2);
        $anoC2= (int) substr($fecha2,0,4);

                if ($anoC1>$anoC2)  $x=1;
                if ($anoC1<$anoC2)  $x=2;
                if ($anoC1==$anoC2) {
                        if ($mesC1 > $mesC2) $x=1;
                        if ($mesC1 < $mesC2) $x=2;
                        if ($mesC1 == $mesC2) {
                                if ($diaC1 > $diaC2) $x=1;
                                if ($diaC1 < $diaC2) $x=2;
                                if ($diaC1 == $diaC2) $x=0;
                        }
                }
         return $x;
      };


function CursoPalabra($id_curso, $tipo, $conn){
	// $tipo = 0 - palabra completa
	// $tipo = 1 - iniciales
	// $tipo = 2 - palabra completa solo curso sn enseñanza
	// $tipo = 3 - iniciales solo curso sn enseñanza
	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
	$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$id_curso.")); ";
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,0);	
	if ( ($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){
		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		$Curso_pal1 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		$Curso_pal2 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));
		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));
	}else if ( ($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==121987) or ($fila_curso['cod_decreto']==1521989)) ){
		$Curso_pal0 =  "PRIMER CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		$Curso_pal1 =  "PC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
		$Curso_pal2 =  "PRIMER CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]));				
		$Curso_pal3 = "PC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
	}else if ( ($fila_curso['grado_curso']==1) and ($fila_curso['cod_decreto']==1000)){
		$Curso_pal0 =  "SALA CUNA - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		$Curso_pal1 =  "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
		$Curso_pal2 =  "SALA CUNA - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
		$Curso_pal3 = "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
	}else if ( ($fila_curso['grado_curso']==2) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){
		$Curso_pal0 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		$Curso_pal1 =  "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		$Curso_pal2 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));
		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));
	}else if ( ($fila_curso['grado_curso']==3) and ($fila_curso['cod_decreto']==121987) ){
		$Curso_pal0 =  "SEGUNDO CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		$Curso_pal1 =  "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
		$Curso_pal2 =  "SEGUNDO CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]));
		$Curso_pal3 = "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
	}else if ( ($fila_curso['grado_curso']==2) and ($fila_curso['cod_decreto']==1000)){
		$Curso_pal0 =  "NIVEL MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		$Curso_pal1 =  "NMME - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
		$Curso_pal2 =  "NIVEL MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));
		$Curso_pal3 = "NMME - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
	}else if (($fila_curso['grado_curso']==3) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){
		$Curso_pal0 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   
		$Curso_pal1 =  "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		
		$Curso_pal2 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   
		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   		
	}else if ( ($fila_curso['grado_curso']==4) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==771982)) ){
		$Curso_pal0 =  "CUARTO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   
		$Curso_pal1 =  "CN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		
		$Curso_pal2 =  "CUARTO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   
		$Curso_pal3 = "CN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   			
	}else if ( ($fila_curso['grado_curso']==3) and ($fila_curso['cod_decreto']==1000)){
		$Curso_pal0 =  "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		$Curso_pal1 =  "NMMA - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
		$Curso_pal2 =  "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));
		$Curso_pal3 = "NMMA - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
		$Curso_pal4 =  "PLAY GROUP - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
	}else if ( ($fila_curso['grado_curso']==4) and ($fila_curso['cod_decreto']==1000)){
		$Curso_pal0 =  "TRANSICIÓN 1er NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		$Curso_pal1 =  "T1N - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
		$Curso_pal2 =  "TRANSICIÓN 1er NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));
		$Curso_pal3 = "T1N - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
		$Curso_pal4 =  "PRE KINDER - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
	}else if ( ($fila_curso['grado_curso']==5) and ($fila_curso['cod_decreto']==1000)){
		$Curso_pal0 =  "TRANSICIÓN 2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
		$Curso_pal1 =  "T2N - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
		$Curso_pal2 =  "TRANSICIÓN 2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
		$Curso_pal3 = "T2N - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
	$Curso_pal4 =  "KINDER - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));			
	}else if ( ($fila_curso['grado_curso']>0) and ($fila_curso['grado_curso']<5 ) and ($fila_curso['cod_decreto']==771982)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));						

		

	}else if ( (($fila_curso['grado_curso']==5) or ($fila_curso['grado_curso']==6 )) and ($fila_curso['cod_decreto']==771982)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));								



	}else if ( (($fila_curso['grado_curso']==7) or ($fila_curso['grado_curso']==8 )) and ($fila_curso['cod_decreto']==771982)){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));								



	}else if ( (($fila_curso['grado_curso']>0) and ($fila_curso['grado_curso']<5 )) and ($fila_curso['cod_decreto']==461987)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												



	}else if ( (($fila_curso['grado_curso']==5) or ($fila_curso['grado_curso']==6 )) and ($fila_curso['cod_decreto']==461987)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												



	}else if ( (($fila_curso['grado_curso']==1)) and ($fila_curso['cod_decreto']==2392004)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));			
		
	}else if ( (($fila_curso['grado_curso']==2)) and ($fila_curso['cod_decreto']==5842007)){

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
		
	}else if ( (($fila_curso['grado_curso']==3)) and ($fila_curso['cod_decreto']==5842007)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
											
	}else if ((($fila_curso['grado_curso']==4)) and ($fila_curso['cod_decreto']==5842007)){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal2 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
	
	}else if ( (($fila_curso['grado_curso']==7) or ($fila_curso['grado_curso']==8)) and ($fila_curso['cod_decreto']==461987)){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

	}else if ( (($fila_curso['grado_curso']==8)) and ($fila_curso['cod_decreto']==2392004)){

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

	}else if ( (($fila_curso['grado_curso']==3)) and ($fila_curso['cod_decreto']==2392004)){

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

		$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		

		$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

		$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

																					

	}else{

		$Curso_pal0 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 

		$Curso_pal1 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 		

		$Curso_pal2 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 		

		$Curso_pal3 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 	
		$Curso_pal4 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 
		//$Curso_pal4 =  ucwords(strtoupper($fila_curso["grado_curso"] . "º AÑO DE " . $fila_curso['nombre_tipo']));
		
		$Curso_pal5 =  ucwords(strtoupper("AÑO DE ".$fila_curso['nombre_tipo'])); 		
	
	}

	if ($tipo == 0)

		return $Curso_pal0;

	if ($tipo == 1)

		return $Curso_pal1;

	if ($tipo == 2)

		return $Curso_pal2;

	if ($tipo == 3)

		return $Curso_pal3;				

	if ($tipo == 4)

		return $Curso_pal4;				

	if ($tipo == 5)

		return $Curso_pal5;				

}



Function Conceptual($nota, $tipo)

{

	//$tipo = 1 --- $nota viene con valor numérico devuelve conceptual

	//$tipo = 2 --- $nota viene con valor conceptual devuelve numérico

	$nota_res=0;

	$concepto="";		

	if ($tipo == 1)

	{

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

	}

	else

	{

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

function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {

  /*

    $interval can be:

    yyyy - Number of full years

    q - Number of full quarters

    m - Number of full months

    y - Difference between day numbers

      (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)

    d - Number of full days

    w - Number of full weekdays

    ww - Number of full weeks

    h - Number of full hours

    n - Number of full minutes

    s - Number of full seconds (default)

  */

  

  if (!$using_timestamps) {

    $datefrom = strtotime($datefrom, 0);

    $dateto = strtotime($dateto, 0);

  }

  $difference = $dateto - $datefrom; // Difference in seconds

   

  switch($interval) {

   

    case 'yyyy': // Number of full years



      $years_difference = floor($difference / 31536000);

      if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {

        $years_difference--;

      }

      if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {

        $years_difference++;

      }

      $datediff = $years_difference;

      break;



    case "q": // Number of full quarters



      $quarters_difference = floor($difference / 8035200);

      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {

        $months_difference++;

      }

      $quarters_difference--;

      $datediff = $quarters_difference;

      break;



    case "m": // Number of full months



      $months_difference = floor($difference / 2678400);

      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {

        $months_difference++;

      }

      $months_difference--;

      $datediff = $months_difference;

      break;



    case 'y': // Difference between day numbers



      $datediff = date("z", $dateto) - date("z", $datefrom);

      break;



    case "d": // Number of full days



      $datediff = floor($difference / 86400);

      break;



    case "w": // Number of full weekdays



      $days_difference = floor($difference / 86400);

      $weeks_difference = floor($days_difference / 7); // Complete weeks

      $first_day = date("w", $datefrom);

      $days_remainder = floor($days_difference % 7);

      $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?

      if ($odd_days > 7) { // Sunday

        $days_remainder--;

      }

      if ($odd_days > 6) { // Saturday

        $days_remainder--;

      }

      $datediff = ($weeks_difference * 5) + $days_remainder;

      break;



    case "ww": // Number of full weeks



      $datediff = floor($difference / 604800);

      break;



    case "h": // Number of full hours



      $datediff = floor($difference / 3600);

      break;



    case "n": // Number of full minutes



      $datediff = floor($difference / 60);

      break;



    default: // Number of full seconds (default)



      $datediff = $difference;

      break;

  }    



  return $datediff;



}

function DiasTrabajados($id_ano,$fecha1, $fecha2, $conn)

{

	$sqlFeriados = "select * from feriado where id_ano = ".$id_ano." and fecha_inicio >= '".$fecha1."' and fecha_inicio <= '".$fecha2."' order by fecha_inicio";

	$rsFeriado =@pg_Exec($conn,$sqlFeriados );

	for($i=0 ; $i < @pg_numrows($rsFeriado) ; ++$i)

	{

		$fFeriado= @pg_fetch_array($rsFeriado,$i);

		

		$fecha_inicio = $fFeriado['fecha_inicio'];

		$fecha_fin = $fFeriado['fecha_fin'];

		if (!empty($fecha_fin)){

			$dias_entre = DateDiff('d',$fecha_inicio, $fecha_fin);

			$dias = $dias + $dias_entre+1;

		}else{

			$dias = $dias + 1;

		}

	}



	$diferencia = datediff('w', $fecha1, $fecha2, false);

	return $diferencia-$dias;

}

function Promediar($suma,$cantidad, $truncado){
	if ($truncado == 1){
		$promedio = @round($suma/$cantidad,0);
	}else{
		$promedio = @intval($suma/$cantidad);
    }
	
	return $promedio;
}


function imprime_array($arreglo){
echo "<pre>";
print_r($arreglo);
echo "</pre>";
}

function aproximar_promedio($prom,$valor){
//si valor=1 aproxima, si no no
	if ($valor==1){
		$prom=round($prom,0);
	}
	if ($valor==1){
		$prom=floor($prom);
	}
	return $prom;
}


function promediofinalxquery(){

/*NO esta terminado esto de llama desde el archivo promocion_pro.php*/

$sql = "
SELECT 
(sum(Q.promedioquery) / count(*)) As superpromedioxquery
FROM 
( SELECT
( ( cast(n.nota1 as integer) + cast(n.nota2 as integer ) + cast(n.nota3 as integer ) + cast(n.nota4 as integer ) + 
cast(n.nota5 as integer ) + cast(n.nota6 as integer ) + cast(n.nota7 as integer ) + cast(n.nota8 as integer ) +
cast(n.nota9 as integer ) + cast(n.nota10 as integer ) + cast(n.nota11 as integer ) + cast(n.nota12 as integer ) + 
cast(n.nota13 as integer ) + cast(n.nota14 as integer ) + cast(n.nota15 as integer ) + cast(n.nota16 as integer ) + 
cast(n.nota17 as integer ) + cast(n.nota18 as integer ) + cast(n.nota19 as integer ) ) /
( (CASE WHEN (n.nota1 is not null) AND (n.nota1 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota2 is not null) AND (n.nota2 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota3 is not null) AND (n.nota3 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota4 is not null) AND (n.nota4 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota5 is not null) AND (n.nota5 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota6 is not null) AND (n.nota6 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota7 is not null) AND (n.nota7 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota8 is not null) AND (n.nota8 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota9 is not null) AND (n.nota9 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota10 is not null) AND (n.nota10 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota11 is not null) AND (n.nota11 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota12 is not null) AND (n.nota12 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota13 is not null) AND (n.nota13 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota14 is not null) AND (n.nota14 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota15 is not null) AND (n.nota15 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota16 is not null) AND (n.nota16 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota17 is not null) AND (n.nota17 <> '0') THEN 1 ELSE 0 END) +
  (CASE WHEN (n.nota18 is not null) AND (n.nota18 <> '0') THEN 1 ELSE 0 END) +
(CASE WHEN (n.nota19 is not null) AND (n.nota19 <> '0') THEN 1 ELSE 0 END) ) ) as promedioquery
FROM notas2008 as n 
WHERE n.id_ramo=129610 
AND n.rut_alumno=20678722) as Q";

//return; 

}


?>