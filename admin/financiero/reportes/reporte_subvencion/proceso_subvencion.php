<?
require_once('mod_reporte_subvencion.php');
require('../../../../util/header.inc');

$id_nacional=	$_ID_NACIONAL;
$nro_ano = $cmb_anos; 
$mes	 = $cmb_mes;
$tipo_instit=1;
//print_r($_POST);
	
$obj_motor = new Motor($conn); 

/*$datos_instit=$obj_motor->datos_institucion($rdb);
$nombre=pg_result($datos_instit,2);
$calle=pg_result($datos_instit,3);
$numero=pg_result($datos_instit,4);
$direc=$calle."  ".$numero;
$fono=pg_result($datos_instit,11);
$insignia=pg_result($datos_instit,27);*/


       $result_i = $obj_motor->busca_institucion($id_nacional);
				
		for($j=0;$j<pg_numrows($result_i);$j++){
			
			
			
			$monto_total1=0;
			$monto_total2=0;
			$monto_total3=0;
			$monto_total4=0;
						
			
			$fila_instit=pg_fetch_array($result_i,$j);
			$rdb = $fila_instit['rdb'];
			$nom_instit=$fila_instit['nombre_instit'];
		   


$rs_ano=$obj_motor->ano_academico($rdb,$nro_ano);
$id_ano=(pg_result($rs_ano,0));

if($mes==3){
	$dias_restarMarzo=$obj_motor->habilesdiciembre($cmb_mes,$id_ano);
	$dias_restarMarzo=pg_result($dias_restarMarzo,0);
	// "<br>"." Dias restarMarzo-->".$dias_restarMarzo;
	}

if($mes==12){
	$dias_habilesMes=$obj_motor->habilesdiciembre($cmb_mes,$id_ano);
	$dias_habilesMes=pg_result($dias_habilesMes,0);
	//echo "<br>"."Dias Habiles".$dias_habilesMes;
	}else{
$dias_habilesMes=$obj_motor->habiles($cmb_mes,$nro_ano);
//echo "<br>"."Dias Habiles ---->".$dias_habilesMes;
	}
$dias_feriados=$obj_motor->dias_feriados($id_ano,$cmb_mes);
//echo "<br>"."Dias Feriados ---->".$dias_feriados;

if($mes==3){
	$diasTotalesMes=($dias_habilesMes-$dias_restarMarzo)-$dias_feriados;
	}else{
$diasTotalesMes=$dias_habilesMes-$dias_feriados;
	}
	
	//echo "totalesMes-->".$diasTotalesMes;

        
        $tipo=1;

        $rs_matricula1=$obj_motor->total_matricula($id_ano,$cmb_mes,$tipo);
        $total_mat1 = pg_result($rs_matricula1,0);
        
        for($i=0;$i<pg_numrows($rs_matricula1);$i++){
            $fila1=pg_fetch_array($rs_matricula1,$i);
            
            $id_curso=$fila1['id_curso'];
            
            $rs_asistencia=$obj_motor->aistencia_mes($id_ano,$cmb_mes,$tipo,$id_curso);
            $asistencia = pg_result($rs_asistencia,0);
      if($total_asistencia=="")
         {
            $total_asistencia=0;	 
         }
            $cantidad1    = $fila1['contador'];
            $ensenanza1   = $fila1['ensenanza'];
            $grado_curso1 = $fila1['grado_curso'];
            
             $imprime="<table align='center' border='1' style='border-collapse:collapse'>
            <tr>
            <td>".$cantidad1."</td>
            <td>".$ensenanza1."</td>
            <td>".$grado_curso1."</td>
            </tr></table>";
            
            $rs_subvencion=$obj_motor->calculasubvencion($ensenanza1,$grado_curso1,$tipo,$tipo_instit,$nro_ano);
            
            for($x=0; $x<pg_numrows($rs_subvencion);$x++)
            {
                $fila_s=pg_fetch_array($rs_subvencion,$x);
                $factor=$fila_s[0];
                $monto = $fila_s[1]; 
                /*echo"<pre>";
                print_r($fila_s);
                echo"</pre>";*/	
                
                $totalasistencia=($diasTotalesMes*$cantidad1)-$asistencia;
                
                $factorMonto=($monto*$factor)*$totalasistencia;
                //echo"<br>factorMonto--->".$factorMonto;
                $monto_total1=$factorMonto + $monto_total1;
            }
            
        }
		if($monto_total1==""){$monto_total1=0;}
         "<BR>---->SEP $".$monto_total1;
		
		
		
						
  /***************************FIN PROCESO PIE***************************************************/
      
	  
	  
        $tipo=2;

        $rs_matricula1=$obj_motor->total_matricula($id_ano,$cmb_mes,$tipo);
        $total_mat1 = pg_result($rs_matricula1,0);
        
        for($i=0;$i<pg_numrows($rs_matricula1);$i++){
            $fila1=pg_fetch_array($rs_matricula1,$i);
            
            $id_curso=$fila1['id_curso'];
            
            $rs_asistencia=$obj_motor->aistencia_mes($id_ano,$cmb_mes,$tipo,$id_curso);
            $asistencia = pg_result($rs_asistencia,0);
      if($total_asistencia=="")
         {
            $total_asistencia=0;	 
         }
            
            $cantidad1    = $fila1['contador'];
            $ensenanza1   = $fila1['ensenanza'];
            $grado_curso1 = $fila1['grado_curso'];
            
             $imprime="<table align='center' border='1' style='border-collapse:collapse'>
            <tr>
            <td>".$cantidad1."</td>
            <td>".$ensenanza1."</td>
            <td>".$grado_curso1."</td>
            </tr></table>";
            
            $rs_subvencion=$obj_motor->calculasubvencion($ensenanza1,$grado_curso1,$tipo,$tipo_instit,$nro_ano);
            
            for($x=0; $x<pg_numrows($rs_subvencion);$x++)
            {
                $fila_s=pg_fetch_array($rs_subvencion,$x);
                $factor=$fila_s[0];
                $monto = $fila_s[1]; 
                /*echo"<pre>";
                print_r($fila_s);
                echo"</pre>";*/	
                
                $totalasistencia=($diasTotalesMes*$cantidad1)-$asistencia;
                
                $factorMonto=($monto*$factor)*$totalasistencia;
                //echo"<br>factorMonto--->".$factorMonto;
                $monto_total2=$factorMonto + $monto_total2;
            }
            
        }
		if($monto_total2==""){$monto_total2=0;}
         "<br>PIE-->"."$".$monto_total2;
        
        ?>
        
        <?php
        
        $tipo=3;
        
    $rs_matricula1=$obj_motor->total_matricula($id_ano,$cmb_mes,$tipo);
        $total_mat1 = pg_result($rs_matricula1,0);
        
        for($i=0;$i<pg_numrows($rs_matricula1);$i++){
            $fila1=pg_fetch_array($rs_matricula1,$i);
            
            $id_curso=$fila1['id_curso'];
            
            $rs_asistencia=$obj_motor->aistencia_mes($id_ano,$cmb_mes,$tipo,$id_curso);
            $asistencia = pg_result($rs_asistencia,0);
      if($total_asistencia=="")
         {
            $total_asistencia=0;	 
         }
            
            $cantidad1    = $fila1['contador'];
            $ensenanza1   = $fila1['ensenanza'];
            $grado_curso1 = $fila1['grado_curso'];
            
            echo $imprime="<table align='center' border='1' style='border-collapse:collapse'>
            <tr>
            <td>".$cantidad1."</td>
            <td>".$ensenanza1."</td>
            <td>".$grado_curso1."</td>
            </tr></table>";
            
            $rs_subvencion=$obj_motor->calculasubvencion($ensenanza1,$grado_curso1,$tipo,$tipo_instit,$nro_ano);
            
            for($x=0; $x<pg_numrows($rs_subvencion);$x++)
            {
                $fila_s=pg_fetch_array($rs_subvencion,$x);
                $factor=$fila_s[0];
                $monto = $fila_s[1]; 
                /*echo"<pre>";
                print_r($fila_s);
                echo"</pre>";*/	
                
                $totalasistencia=($diasTotalesMes*$cantidad1)-$asistencia;
                
                $factorMonto=($monto*$factor)*$totalasistencia;
                //echo"<br>factorMonto--->".$factorMonto;
                $monto_total3=$factorMonto + $monto_total3;
            }
            
        }
		if($monto_total3==""){$monto_total3=0;}
         "<br>RETOS-->"."$".$monto_total3;
        
        ?>
        
        
         <?php
        
        $tipo=4;
        
        $rs_matricula1=$obj_motor->total_matricula($id_ano,$cmb_mes,$tipo);
        $total_mat1 = pg_result($rs_matricula1,0);
        
        for($i=0;$i<pg_numrows($rs_matricula1);$i++){
            $fila1=pg_fetch_array($rs_matricula1,$i);
            
            $id_curso=$fila1['id_curso'];
            
            $rs_asistencia=$obj_motor->aistencia_mes($id_ano,$cmb_mes,$tipo,$id_curso);
            $asistencia = pg_result($rs_asistencia,0);
      if($total_asistencia=="")
         {
            $total_asistencia=0;	 
         }
            
            $cantidad1    = $fila1['contador'];
            $ensenanza1   = $fila1['ensenanza'];
            $grado_curso1 = $fila1['grado_curso'];
            
             $imprime="<table align='center' border='1' style='border-collapse:collapse'>
            <tr>
            <td>".$cantidad1."</td>
            <td>".$ensenanza1."</td>
            <td>".$grado_curso1."</td>
            </tr></table>";
            
            $rs_subvencion=$obj_motor->calculasubvencion($ensenanza1,$grado_curso1,$tipo,$tipo_instit,$nro_ano);
            
            for($x=0; $x<pg_numrows($rs_subvencion);$x++)
            {
                $fila_s=pg_fetch_array($rs_subvencion,$x);
                $factor=$fila_s[0];
                $monto = $fila_s[1]; 
                /*echo"<pre>";
                print_r($fila_s);
                echo"</pre>";	*/
                
            //	echo"asistencia-->".$asistencia;
                "total asistencia-->".$totalasistencia=($diasTotalesMes*$cantidad1)-$asistencia;
                
                $factorMonto=($monto*$totalasistencia);
                //echo"<br>factorMonto--->".$factorMonto;
                $monto_total4=$factorMonto + $monto_total4;
            }
            
        }
		if($monto_total4==""){$monto_total4=0;}
         "<BR>--->NORMAL  $".intval($monto_total4);
            "<hr>";
			
			
			//exit;
		
		$rs_insert=$obj_motor->guarda_subvencion($rdb,$nom_instit,$nro_ano,$mes,$monto_total1,$monto_total2,$monto_total3,$monto_total4,$id_nacional);	
		
		
    	 }//fin for intitucion		
					
			if($rs_insert)
			{
				echo 1;
				/*echo"<script>alert('Registros Guardados')</script>";
				header("Location: reporte_subvencion.php?1"); 	*/
			}else{
				echo 0;
			}
        ?>
     
       
       
  
   