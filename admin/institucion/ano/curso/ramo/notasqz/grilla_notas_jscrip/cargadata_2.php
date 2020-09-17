<?
error_reporting(E_ALL);
ini_set('display_errors', 1);  

require('../../../../../../../util/header.inc');



$id_periodo=$_POST["id_periodo"];
$id_ramo=$_POST["id_ramo"];
$id_ano=$_POST["id_ano"];
$nro_ano=$_POST["nro_ano"];
$periodo_real = $_POST["periodo_real"];
/*  var_dump($_POST);
 exit;*/
/* if($_PERFIL==0){
	print_r($_POST);
	}*/
 
 
 	$sql_subsector="select cod_subsector from ramo where id_ramo=$id_ramo";
	$rs_cod_sub = pg_exec($conn,$sql_subsector);
	$cod_subsector = pg_result($rs_cod_sub,0);
 	
	
/*$id_periodo = 1200;
$id_ramo = 129637;
$id_ano = 576;*/

if($cod_subsector==50686 || $cod_subsector==50687 || $cod_subsector==50688 || $cod_subsector==50689 || $cod_subsector==50690 and $_INSTIT==18049){
	function desifranotaconseptual($dato){
	$nueva_nota=0;
	
	if ( (trim($dato)=='EP') || (trim($dato)=='ep') || (trim($dato)=='Ep') || (trim($dato)=='eP') ){ $nueva_nota = 50; }//eP
	if ( (trim($dato)=='L') || (trim($dato)=='l') ){ $nueva_nota = 70;	}//L		
	if ( (trim($dato)=='NL') || (trim($dato)=='nl') || (trim($dato)=='Nl') || (trim($dato)=='nL') ){ $nueva_nota = 35; } //NL
	
	return $nueva_nota;
	}
}else if($cod_subsector==22 and $_INSTIT==19968){
	function desifranotaconseptual($dato){
	$nueva_nota=0;
	if ( (trim($dato)=='AL') || (trim($dato)=='al') || (trim($dato)=='Al') || (trim($dato)=='aL') ){ $nueva_nota = 65; }//AL
	if ( (trim($dato)=='L') || (trim($dato)=='l') ){ $nueva_nota = 50;	}//L		
	if ( (trim($dato)=='NL') || (trim($dato)=='nl') || (trim($dato)=='Nl') || (trim($dato)=='nL') ){ $nueva_nota = 30; } //NL
	
	return $nueva_nota;
	}
}else{
function desifranotaconseptual($dato){
$nueva_nota=0;

if ( (trim($dato)=='MB') || (trim($dato)=='mb') || (trim($dato)=='Mb') || (trim($dato)=='mB') ){ $nueva_nota = 65;   }
if ( (trim($dato)=='B') || (trim($dato)=='b') ){ $nueva_nota = 55;	}//B		
if ( (trim($dato)=='S') || (trim($dato)=='s') ){ $nueva_nota = 45; } //S
if ( (trim($dato)=='I') || (trim($dato)=='i') ){ $nueva_nota = 35;	}//I


return $nueva_nota;
	}
}

if($cod_subsector==50686 || $cod_subsector==50687 || $cod_subsector==50688 || $cod_subsector==50689 || $cod_subsector==50690 and $_INSTIT==18049){
	function promedioconceptual( $prom_conc ){
	$letra = "";
	
	if( $prom_conc >=56 && $prom_conc <= 70 ) $letra = 'L';
	if( $prom_conc >=40 && $prom_conc <= 55 ) $letra = 'EP';
	if( $prom_conc >=10 && $prom_conc <= 39 ) $letra = 'NL';
	return $letra;
	}
	
}else



if($cod_subsector==22 and $_INSTIT==19968){
	
	function promedioconceptual( $prom_conc ){
	$letra = "";
	
	if( $prom_conc >=60 && $prom_conc <= 70 ) $letra = 'AL';
	if( $prom_conc >=40 && $prom_conc <= 59 ) $letra = 'L';
	if( $prom_conc >=10 && $prom_conc <= 39 ) $letra = 'NL';
	return $letra;
	}
	
}else{

function promedioconceptual( $prom_conc ){
	$letra = "";
	
	if( $prom_conc >=60 && $prom_conc <= 70 ) $letra = 'MB';
	if( $prom_conc >=50 && $prom_conc <= 59 ) $letra = 'B';
	if( $prom_conc >=40 && $prom_conc <= 49 ) $letra = 'S';
	if( $prom_conc >0   && $prom_conc <= 39 ) $letra = 'I';
	return $letra;
	}
}
function aprox_entero( $nota ){
	$prom_nuevo = 0;
	if ( $nota >= 65 && $nota <= 70 )  $prom_nuevo = 70;
	if ( $nota >= 60 && $nota <= 64 )  $prom_nuevo = 60;
	if ( $nota >= 55 && $nota <= 59 )  $prom_nuevo = 55;
	if ( $nota >= 50 && $nota <= 54 )  $prom_nuevo = 50;								
	if ( $nota >= 45 && $nota <= 49 )  $prom_nuevo = 45;
	if ( $nota >= 40 && $nota <= 44 )  $prom_nuevo = 40;
	if ( $nota > 0   && $nota <= 39 )  $prom_nuevo = 35;
	return $prom_nuevo;
	}
		

	    $qry="SELECT * FROM ramo 
	    INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector 
	    WHERE ramo.id_ramo=".$id_ramo.";";
        $result =@pg_Exec($conn,$qry);
                
        if (pg_numrows($result)!=0){
           $fila10 = @pg_fetch_array($result,0);	
           //echo trim($fila10['nombre']);
           $_SESSION['_MODOEVAL'] = trim($fila10['modo_eval']);
		   $modo_eval = trim($fila10['modo_eval']);
           $truncado = trim($fila10['truncado']);	
           $aprox_entero = trim($fila10["aprox_entero"]);
		   $pct_nivel = trim($fila10['pct_nivel']);
           $prueba_nivel = 0; //trim($fila10['prueba_nivel']);
           $modo_eval_p_nivel = trim($fila10['modo_eval_pnivel']);
           $truncado_pnivel  = trim($fila10['truncado_pnivel']);
		   $bool_bloq = trim($fila10['bool_bloq']);
		   /*notas$nro_ano*/
		    $sql_busca = "SELECT * FROM quiz_notas n 
		   INNER JOIN  ramo r ON r.id_ramo=n.id_ramo 
		   WHERE n.id_ramo=".$id_ramo." AND n.id_periodo=".$id_periodo." and periodo_real= ".$periodo_real."  ";
		   $result_busca =@pg_Exec($conn,$sql_busca);
		   $p_nivel = @pg_num_rows($result_busca);
		 }

/*RUTINA PARA ACTUALIZAR LOS PROMEDIOS PARA LOS WNS QUE ESCRIBEN MUY RAPIDO EN EL MODULO DE NOTAS y LAS RUTINAS JSCRIPT NO ALCANZAN A ACTUALIZAR LA CELDA PROMEDIO NOTAS".$nro_ano."*/
   $sql ="SELECT * FROM quiz_notas WHERE ID_PERIODO=".$id_periodo." AND id_ramo=".$id_ramo." and periodo_real = $periodo_real;  ";
$rs_notas = @pg_exec($conn,$sql);
//return ;

for($i=0;$i<pg_num_rows($rs_notas);$i++){
	
	$fila = pg_fetch_array($rs_notas,$i);
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
		
		 if( ($fila['promedio']  != $promedio) && ( $promedio !="0" ) ) {
		 /*notas".$nro_ano."*/
		  $sql_Update = "UPDATE quiz_notas SET promedio='".$promedio."', periodo_real = $periodo_real WHERE rut_alumno=".$fila['rut_alumno']." AND id_ramo=".$fila['id_ramo']." AND id_periodo=".$fila['id_periodo']." and periodo_real = $periodo_real;  ";
		$rs_promedio = @pg_exec( $conn,$sql_Update ) or die("Error de Sistemas");
		
		   }
		  
		
		}
	
	}
		
}
/*************************************************************************/

/*************************************************************************/

$sql_query ="SELECT distinct
matricula.rut_alumno,
alumno.dig_rut,
matricula.bool_ar,
matricula.nro_lista,
initcap(alumno.nombre_alu) as nombre,
initcap(alumno.ape_pat) as ape_pat,
initcap(alumno.ape_mat) as ape_mat,
tiene".$nro_ano.".id_curso,
periodo.id_periodo, 
ramo.id_ramo,
notas".$nro_ano.".nota1,
notas".$nro_ano.".nota2,
notas".$nro_ano.".nota3,
notas".$nro_ano.".nota4,
notas".$nro_ano.".nota5,
notas".$nro_ano.".nota6,
notas".$nro_ano.".nota7,
notas".$nro_ano.".nota8,
notas".$nro_ano.".nota9,
notas".$nro_ano.".nota10,
notas".$nro_ano.".nota11,
notas".$nro_ano.".nota12,
notas".$nro_ano.".nota13,
notas".$nro_ano.".nota14,
notas".$nro_ano.".nota15,
notas".$nro_ano.".nota16,
notas".$nro_ano.".nota17,
notas".$nro_ano.".nota18,
notas".$nro_ano.".nota19,
notas".$nro_ano.".nota20,
notas".$nro_ano.".promedio 
FROM alumno 
LEFT JOIN quiz_notas notas".$nro_ano." ON notas".$nro_ano.".rut_alumno= alumno.rut_alumno 
AND notas".$nro_ano.".id_periodo = ".$id_periodo." AND notas".$nro_ano.".id_ramo = ".$id_ramo." 
INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno AND matricula.id_ano = ".$id_ano." 
INNER JOIN tiene".$nro_ano." ON alumno.rut_alumno = tiene".$nro_ano.".rut_alumno AND tiene".$nro_ano.".id_ramo = ".$id_ramo."  and tiene".$nro_ano.".id_curso=matricula.id_curso 
INNER JOIN ramo ON ramo.id_ramo = ".$id_ramo."  AND ramo.id_curso = matricula.id_curso
LEFT JOIN quiz_periodos periodo ON periodo.id_periodo = ".$id_periodo." AND periodo.id_ano = ".$id_ano." and notas".$nro_ano.".periodo_real = $periodo_real 

ORDER BY 4,5";

$result = pg_Exec($conn,$sql_query) or die ("Error 333") ; 

//if($_PERFIL==0) echo "<pre>".$sql_query."</pre>";

$curso = array ();

if (pg_numrows($result)!=0){
for($i=0 ; $i < pg_numrows($result) ; $i++){

$fila1 = pg_fetch_array($result,$i);

			$curso[$i] = array ( 
			"rut" => $fila1["rut_alumno"],
			"dig_rut" => $fila1["dig_rut"],
			"id_curso" => $fila1["id_curso"],
			"nro_lista" => $fila1["nro_lista"],
			"ape_pat" => /*utf8_encode(*/$fila1["ape_pat"]/*)*/,
			"ape_mat" => /*utf8_encode(*/$fila1["ape_mat"]/*)*/,
			"nombres" => /*utf8_encode(*/$fila1["nombre"]/*)*/,
			"bool_ar" => $fila1["bool_ar"],
			"id_periodo" => $fila1["id_periodo"],
			"id_ramo" => $fila1["id_ramo"],
													"notas" => array( 
													trim($fila1["nota1"]),
													trim($fila1["nota2"]),
													trim($fila1["nota3"]),
													trim($fila1["nota4"]),
													trim($fila1["nota5"]),
													trim($fila1["nota6"]),
													trim($fila1["nota7"]),
													trim($fila1["nota8"]),
													trim($fila1["nota9"]),
													trim($fila1["nota10"]),
													trim($fila1["nota11"]),
													trim($fila1["nota12"]),
													trim($fila1["nota13"]),
													trim($fila1["nota14"]),
													trim($fila1["nota15"]),
													trim($fila1["nota16"]),
													trim($fila1["nota17"]),
													trim($fila1["nota18"]),
													trim($fila1["nota19"]),
													trim($fila1["nota20"]),
													trim($fila1["promedio"]) 
													  )
					 );  // fin array curso
   }
} 

//echo json_encode($curso);

/*echo "<pre>";
print_r($curso);
echo "</pre>";*/

$table = "";
$table = $table.'<form id="form1_patracom" name="form1_patracom" onsubmit="return false" >';
$table =  $table."<table width='100%' border=1 id='paises' align='center'"; 
$table =  $table."style='border-collapse:collapse' cellpadding='1' cellspacing='0'>";
$table =  $table."<thead>";
$table =  $table."<tr align=center class='formatoth' >";
$table =  $table."<th>N&ordm;  Lista</th>";
$table =  $table."<th>Alumno</th>";

for ( $e = 1 ; $e < 21 ; $e++ ){  
$table =  $table."<th onMouseOver='mostrarventana(".$e.")' ><a href='#' ><div  class='formatothmsj' id='ventanita".$e."'>&nbsp;".$e."&nbsp;</div></a></th>";
  }
  
$table =  $table."<th>&nbsp;Prom&nbsp;</th>";
$table =  $table."</tr></thead><tbody>";

$clasico = "";
$inex_td = 0;
$ont = 0;
$num_alumnos = count( $curso );

for ( $i = 0  ;  $i  <  count( $curso )  ;  $i ++ ){ 

$ont++;

		if ( $curso[ $i ][ "bool_ar" ] == 1){
		    $table = $table."<tr class='tachado' align='center' >";
		 } else { 																																																							
		    $table = $table."<tr class='textolink' align='center' >";
		    }
		
		$table = $table."<th class='formatoth' >".$curso[ $i ][ "nro_lista" ]." ";
		
        /*$table = $table."<div id='rut_alumno".$ont." ' style='display:none;' >".$curso[ $i ][ "rut" ]."</div>"; 
		$table = $table."<div id='id_periodo".$ont."'  style='display:none;' >".$curso[ $i ][ "id_periodo" ]."</div>"; 
		$table = $table."<div id='id_ramo".$ont."' style='display:none;' >".$curso[ $i ][ "id_ramo" ]."</div>"; */
		
		$table = $table.'<input type="hidden" name="rut_alumno'.$ont.'" value="'.$curso[ $i ][ "rut" ].'" />';  //id="rut_alumno'.$ont.'"
		
		$table = $table.'<input type="hidden" name="id_periodo'.$ont.'" value="'.$id_periodo.'" />';  //id="id_periodo'.$ont.'" 
		
		$table = $table.'<input type="hidden" name="id_ramo'.$ont.'" value="'.$curso[ $i ][ "id_ramo" ].'" />';  //id="id_ramo'.$ont.'"
		
			$table = $table.'<input type="hidden" name="periodo_real'.$ont.'" value="'.$periodo_real.'" />';  //id="id_ramo'.$ont.'"
		
		
		$table = $table."</th>";
		$table = $table."<th align='left' class='formatoth' >&nbsp;".strtoupper($curso[ $i ][ "ape_pat" ])." ".strtoupper($curso[ $i ][ "ape_mat" ])." ".strtoupper($curso[ $i ][ "nombres" ])."&nbsp;</th>";


			// bloqueo de notas  para que no modifique el profesor 
			//despues de ingresarlas 
			
			if($_PERFIL != 14 && $_PERFIL != 0){
				  if($bool_bloq==1){
				   $clasico = "guardado";  
				  }
				}
				
						
			for ( $e = 0 ; $e < 20 ; $e++ ){ 
			
			    $i_i = $i+1;
				$e_e = $e+1;
				
				if( $curso[ $i ][ "notas" ][ $e ]!=0 or $curso[ $i ][ "notas" ][ $e ]=='B' or $curso[ $i ][ "notas" ][ $e ]=='S' or $curso[ $i ][ "notas" ][ $e ]=='I' or $curso[ $i ][ "notas" ][ $e ]=='MB' or $curso[ $i ][ "notas" ][ $e ]=='AL' or $curso[ $i ][ "notas" ][ $e ]=='L' or $curso[ $i ][ "notas" ][ $e ]=='NL' or $curso[ $i ][ "notas" ][ $e ]=='EP' ){
				
						if( $e != 19 ){
						
						      if( $curso[ $i ][ "bool_ar" ] == 1){
							      
							  $table = $table."<td class='guardad' >".$curso[ $i ][ "notas" ][ $e ]."";
			$table = $table.'<input type="hidden" name="a_'.$i_i.'_'.$e_e.'" id="a_'.$i_i.'_'.$e_e.'" value="'.$curso[ $i ][ "notas" ][ $e ].'" />';
			
			//$table = $table.'<div style="display:none;" >a_'.$i_i.'_'.$e_e.'</div>';
			
			$table = $table."</td>";
							  
							  }else{ 
							  
							  $table = $table."<td class='".$clasico."' >".$curso[ $i ][ "notas" ][ $e ]."";
			$table = $table.'<input type="hidden" name="a_'.$i_i.'_'.$e_e.'" id="a_'.$i_i.'_'.$e_e.'" value="'.$curso[ $i ][ "notas" ][ $e ].'" />';
			//$table = $table.'<div style="display:none;" >a_'.$i_i.'_'.$e_e.'</div>';
			$table = $table."</td>"; 
							  
							  } 
						   
						     $inex_td++;
						 
						 }else{
							  
							  $table = $table."<th class='guardadopruebadenivel' >";
							  $table = $table."<div id='pruebadenivel".$ont."' >".$curso[ $i ][ "notas" ][ $e ]."</div>";
			  $table = $table.'<input type="hidden" name="a_'.$i_i.'_'.$e_e.'" id="a_'.$i_i.'_'.$e_e.'" value="'.$curso[ $i ][ "notas" ][ $e ].'" />';	
			  //$table = $table.'<div style="display:none;" >a_'.$i_i.'_'.$e_e.'</div>';
			  $table = $table."</th>";
						 
						 }
						 
				}else{
				
				      if( $curso[ $i ][ "bool_ar" ] == 1){
					      if( $e != 19 ){	
						  
					        $table = $table."<td class='guardado'>";
			$table = $table.'<input type="hidden" name="a_'.$i_i.'_'.$e_e.'" id="a_'.$i_i.'_'.$e_e.'" value="0" />';
			//$table = $table.'<div style="display:none;" >a_'.$i_i.'_'.$e_e.'</div>';
							$table = $table."</td>";
							$inex_td++; 
							
							}else{
							
							   $table = $table."<th class='formatoth' >";
			$table = $table.'<input type="hidden" name="a_'.$i_i.'_'.$e_e.'" id="a_'.$i_i.'_'.$e_e.'" value="0" />';
			//$table = $table.'<div style="display:none;" >a_'.$i_i.'_'.$e_e.'</div>';
							   $table = $table."</th>";
							   
							}
					  }else{
					        if( $e != 19 ){		
					         
					        $table = $table."<td>";
		    $table = $table.'<input type="hidden" name="a_'.$i_i.'_'.$e_e.'" id="a_'.$i_i.'_'.$e_e.'" value="0" />';
			//$table = $table.'<div style="display:none;" >a_'.$i_i.'_'.$e_e.'</div>';
					        $table = $table."</td>"; 
					   		 
							 //onDblClick='dobleclick(".$inex_td.",".$e.",".$i.")'  // aun no esta listo editar con dobleClick
						     $inex_td++; 
							
							}else{
							
							  $table = $table."<th class='guardadopruebadenivel' >";
							  $table = $table."<div id='pruebadenivel".$ont."' ></div>"; //".$curso[ $i ][ "notas" ][ $e ]."
							  $table = $table.'<input type="hidden" name="a_'.$i_i.'_'.$e_e.'" id="a_'.$i_i.'_'.$e_e.'" value="0" />';
			   				  //$table = $table.'<div style="display:none;" >a_'.$i_i.'_'.$e_e.'</div>';
							  $table = $table."</th>";
						   
							}
					   }   
				   }
		
				} // FIN CICLO 
	
	
	// el espacio 20 dentro de notas equivale al promedio en la query 	
	
	$table = $table."<th class='formatoth' ><div id='prom".$ont."' >".$curso[ $i ][ "notas" ][20]."</div>";
	$table = $table.'<input type="hidden" name="a_'.$i_i.'_'.($e_e+1).'"   id="a_'.$i_i.'_'.($e_e+1).'"  value="'.$curso[ $i ][ "notas" ][ 20].'" />';
	
	//$table = $table.'<div >a_'.$i_i.'_'.$e_e.'</div>'; 
	 
	$table = $table."</th>";
	$table = $table."</tr>";
	        
   } // FIN CICLO
		 
$table =  $table."<tr align=center class='formatoth' >";
$table =  $table."<th>N&ordm; Lista</th>";
$table =  $table."<th>Alumno</th>";
	
	for ( $e = 1 ; $e < 21 ; $e++ ){  
	  $table =  $table."<th><div class='formatothmsj' >&nbsp;".$e."&nbsp;</div></th>";
	}

$table =  $table."<th>&nbsp;Prom&nbsp;</th>";
$table =  $table."</tr>";
$table = $table."</tbody></table><br><br><div class='tip' id='res_lupas'>PATRACOM</div>";
$table = $table."<input id='Xreg' name='Xreg' type='hidden' value='".$num_alumnos."' >";
$table = $table."</form>";

echo $table;
pg_close($conn);
pg_close($connection);
?>