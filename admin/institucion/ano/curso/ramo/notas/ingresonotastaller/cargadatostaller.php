<?  
error_reporting(E_ALL);
ini_set('display_errors', 1);  

require('../../../../../../../util/header.inc');

$id_periodo=$_POST["id_periodo"];
$id_taller=$_POST["id_taller"];
$id_ano=$_POST["id_ano"];
$rdb=$_POST["rdb"]; 


/******************************************************************************/

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

/*************************************************************************/

$qry="SELECT * FROM TALLER WHERE taller.id_taller=".$id_taller."";
$result =@pg_Exec($conn,$qry);
if (pg_num_rows($result)!=0){
   $fila10 = @pg_fetch_array($result,0);	
   $modo_eval=$fila10['modo_eval'];
 }


/*RUTINA PARA ACTUALIZAR LOS PROMEDIOS PARA LOS WNS QUE ESCRIBEN MUY RAPIDO EN EL MODULO DE NOTAS y LAS RUTINAS JSCRIPT NO ALCANZAN A ACTUALIZAR LA CELDA PROMEDIO*/

$sql ="SELECT 
alumno.rut_alumno, 
alumno.dig_rut, 
upper(alumno.nombre_alu) as nombre_alu, 
upper(alumno.ape_pat) as ape_pat, 
upper(alumno.ape_mat) as ape_mat,
matricula.bool_ar,
notas_taller.* 
FROM alumno 
INNER JOIN  matricula ON matricula.rut_alumno = alumno.rut_alumno AND matricula.rdb = $rdb 
AND matricula.id_ano = $id_ano 
INNER JOIN periodo ON periodo.id_ano = $id_ano
INNER JOIN  tiene_taller ON alumno.rut_alumno = tiene_taller.rut_alumno AND tiene_taller.id_taller = $id_taller 
LEFT OUTER JOIN  notas_taller ON notas_taller.id_taller = tiene_taller.id_taller AND notas_taller.rut_alumno= tiene_taller.rut_alumno AND notas_taller.id_periodo = periodo.id_periodo
WHERE 
periodo.id_periodo= $id_periodo
ORDER BY alumno.ape_pat,alumno.ape_mat,alumno.nombre_alu,alumno.rut_alumno asc";

//if($_PERFIL==0)var_dump($sql);

$rs_notas = pg_exec($conn,$sql) or die(pg_last_error($conn));

for($i=0;$i>pg_num_rows($rs_notas);$i++){
	
	$fila = pg_fetch_array($rs_notas,$i);
	
	$rut_alumno = $fila['rut_alumno'];
	$contador = 0;
	$suma = 0;
    $promedio = 0;
	
	for($j=1;$j<20;$j++){
		
		$n ="nota".$j;
		$nota = $fila[$n];	
		
		if( ($fila['rut_alumno']==$rut_alumno) ){
		
		
		echo $fila['rut_alumno'];
		
		
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
			
			if( $suma > 0 ) $promedio =  intval( $suma / $contador );
		   
		/*if( $truncado == 1 ){
			   if( $suma > 0 ) $promedio =  round( $suma / $contador );
		   }else{
			  if( $suma > 0 ) $promedio =  intval( $suma / $contador );
		   }*/
		   
		}
		
		 /************/	 
		if( $modo_eval == 3  ){
			  	 $promedio =  promedioconceptual( $promedio );
			  }
       /************/	 
	   
       /*Promedio Conceptual*/
	   if( $modo_eval == 2 || $modo_eval == 4 ){
			   
			   if( $suma > 0 ) $promedio =  intval( $suma / $contador );
			   
			   if($modo_eval == 2 ){
					  $promedio =  promedioconceptual( $promedio );
				   }
				   
				   
			   }
		/************/	 					 
                    
	    /*Aproxima a Entero*/
	/*	if( $aprox_entero ==1 && $modo_eval == 1 ){
				$promedio = aprox_entero( $promedio );
			  }*/
		 /************/	
		
		 if( ($fila['promedio']  != $promedio) && ( $promedio !="0" ) ) {
		 
				echo "<br/>".$sql_Update = "UPDATE notas_taller SET promedio='".$promedio."' 
				WHERE  id_taller = ".$id_taller." AND rut_alumno= ".$fila['rut_alumno']."
				AND id_periodo = ".$id_periodo."; ";
				
				$rs_promedio = @pg_exec( $conn,$sql_Update ) or die("Error de Sistemas <br/>".$sql_Update);
		
		   }
		  
		
		}
	
	}
		
}
/*************************************************************************/


/*************************************************************************/

$sql_query ="SELECT 
alumno.rut_alumno, 
alumno.dig_rut, 
upper(alumno.nombre_alu) as nombre_alu, 
upper(alumno.ape_pat) as ape_pat, 
upper(alumno.ape_mat) as ape_mat,
matricula.bool_ar,
notas_taller.* 
FROM alumno 
INNER JOIN  matricula ON matricula.rut_alumno = alumno.rut_alumno AND matricula.rdb = $rdb 
AND matricula.id_ano = $id_ano 
INNER JOIN periodo ON periodo.id_ano = $id_ano
INNER JOIN  tiene_taller ON alumno.rut_alumno = tiene_taller.rut_alumno AND tiene_taller.id_taller = $id_taller 
LEFT OUTER JOIN  notas_taller ON notas_taller.id_taller = tiene_taller.id_taller AND notas_taller.rut_alumno= tiene_taller.rut_alumno AND
notas_taller.id_periodo = periodo.id_periodo
WHERE 
periodo.id_periodo= $id_periodo
ORDER BY alumno.ape_pat,alumno.ape_mat,alumno.nombre_alu,alumno.rut_alumno asc";

$result = pg_Exec($conn,$sql_query) or die ("Error 333") ; 


//if($_PERFIL==0) echo $sql_query;

$curso = array ();

if (pg_numrows($result)!=0){
	
for($i=0 ; $i < pg_numrows($result) ; $i++){

$fila1 = pg_fetch_array($result,$i);

   $curso[$i] = array ( 
   "rut" => $fila1[0],
   "dig_rut" => $fila1["dig_rut"],
   "ape_pat" =>$fila1["ape_pat"],
   "ape_mat" =>$fila1["ape_mat"],
   "nombres" =>$fila1["nombre_alu"],
   "id_periodo" => $id_periodo,
   "id_taller" => $id_taller,
   "bool_ar" => $fila1["bool_ar"],
      
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

/*echo "<pre>CURSO";
print_r($curso);
echo "</pre>";
*/

$table = "";
$table = $table.'<form id="form1_patracom" name="form1_patracom" onsubmit="return false" >';
$table =  $table."<table width='100%' border=1 id='paises' align='center'"; 
$table =  $table."style='border-collapse:collapse' cellpadding='1' cellspacing='0'>";
$table =  $table."<thead>";
$table =  $table."<tr align=center class='formatoth' >";
$table =  $table."<th>N. Lista</th>";
$table =  $table."<th>Alumno</th>";

for ( $e = 1 ; $e < 21 ; $e++ ){ //onMouseOver='mostrarventana(".$e.")' 
$table =  $table."<th><a href='#' ><div  class='formatothmsj' id='ventanita".$e."'>&nbsp;".$e."&nbsp;</div></a></th>";
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
		
		$table = $table."<th class='formatoth' >".($i+1)." ";
		
        /*$table = $table."<div id='rut_alumno".$ont." ' style='display:none;' >".$curso[ $i ][ "rut" ]."</div>"; 
		$table = $table."<div id='id_periodo".$ont."'  style='display:none;' >".$curso[ $i ][ "id_periodo" ]."</div>"; 
		$table = $table."<div id='id_ramo".$ont."' style='display:none;' >".$curso[ $i ][ "id_ramo" ]."</div>"; */
		
$table = $table.'<input type="hidden" name="rut_alumno'.$ont.'" value="'.$curso[ $i ][ "rut" ].'" />';  
//id="rut_alumno'.$ont.'"
		
$table = $table.'<input type="hidden" name="id_periodo'.$ont.'" value="'.$curso[ $i ][ "id_periodo" ].'" />';  //id="id_periodo'.$ont.'" 
		
$table = $table.'<input type="hidden" name="id_taller'.$ont.'" value="'.$curso[ $i ][ "id_taller" ].'" />';  
//id="id_ramo'.$ont.'"
		
$table = $table."</th>";
		
		
$table = $table."<th align='left' class='formatoth' >&nbsp;".$curso[ $i ][ "ape_pat" ]." ".$curso[ $i ][ "ape_mat" ]." ".$curso[ $i ][ "nombres" ]."&nbsp;</th>";

			// bloqueo de notas  para que no modifique el profesor 
			//despues de ingresarlas 
			/*if( ($_PERFIL!=14) or ($_PERFIL!=0) ){
				  if($bool_bloq==1) $clasico = "guardado";  
				}*/
						
			for ( $e = 0 ; $e < 20 ; $e++ ){ 
			
			    $i_i = $i+1;
				$e_e = $e+1;
				
		//entro si hay datos guardados 
		if( $curso[ $i ][ "notas" ][ $e ]!=0 or $curso[ $i ][ "notas" ][ $e ]=='B' or $curso[ $i ][ "notas" ][ $e ]=='S' or $curso[ $i ][ "notas" ][ $e ]=='I' or $curso[ $i ][ "notas" ][ $e ]=='MB'){
				
			/*if( $e != 19 ){*/
						
						      if( $curso[ $i ][ "bool_ar" ] == 1){
							      
							  $table = $table."<td class='guardado' >".$curso[ $i ][ "notas" ][ $e ]."";
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
						 
			/*}else{
							  
			$table = $table."<th class='guardadopruebadenivel' >";
			$table = $table."<div id='pruebadenivel".$ont."' >".$curso[ $i ][ "notas" ][ $e ]."</div>";
			$table = $table.'<input type="hidden" name="a_'.$i_i.'_'.$e_e.'" id="a_'.$i_i.'_'.$e_e.'" value="'.$curso[ $i ][ "notas" ][ $e ].'" />';	
			//$table = $table.'<div style="display:none;" >a_'.$i_i.'_'.$e_e.'</div>';
			$table = $table."</th>";
						 
						 }*/
						 
		}else{  // si el dato biene vacio desde el array curso
				
		
		
		if( $curso[ $i ][ "bool_ar" ] == 1){
						  
		/*if( $e != 19 ){*/	
						  
		$table = $table."<td class='guardado'>";
		$table = $table.'<input type="hidden" name="a_'.$i_i.'_'.$e_e.'" id="a_'.$i_i.'_'.$e_e.'" value="0" />';
		//$table = $table.'<div style="display:none;" >a_'.$i_i.'_'.$e_e.'</div>';
		$table = $table."</td>";
		$inex_td++; 
							
		/*}else{
							
		$table = $table."<th class='formatoth' >";
		$table = $table.'<input type="hidden" name="a_'.$i_i.'_'.$e_e.'" id="a_'.$i_i.'_'.$e_e.'" value="0" />';
		//$table = $table.'<div style="display:none;" >a_'.$i_i.'_'.$e_e.'</div>';
		$table = $table."</th>";
			}*/
		
		}else{
		
		/*if( $e != 19 ){	*/	
					         
		$table = $table."<td>";
		$table = $table.'<input type="hidden" name="a_'.$i_i.'_'.$e_e.'" id="a_'.$i_i.'_'.$e_e.'" value="0" />';
		//$table = $table.'<div style="display:none;" >a_'.$i_i.'_'.$e_e.'</div>';
		$table = $table."</td>"; 
					   		 
		//onDblClick='dobleclick(".$inex_td.",".$e.",".$i.")'  // aun no esta listo editar con dobleClick
		$inex_td++; 
							
		/* }else{
							
		$table = $table."<th class='guardadopruebadenivel' >";
		$table = $table."<div id='pruebadenivel".$ont."' ></div>"; //".$curso[ $i ][ "notas" ][ $e ]."
		$table = $table.'<input type="hidden" name="a_'.$i_i.'_'.$e_e.'" id="a_'.$i_i.'_'.$e_e.'" value="0" />';
		//$table = $table.'<div style="display:none;" >a_'.$i_i.'_'.$e_e.'</div>';
		$table = $table."</th>";
						   
		}*/
		  
		}
		
	  }
		
	}// FIN CICLO 
	
	
	// el espacio 20 dentro de notas equivale al promedio en la query 	
	
	$table = $table."<th class='formatoth' ><div id='prom".$ont."' >".$curso[ $i ][ "notas" ][20]."</div>";
	$table = $table.'<input type="hidden" name="a_'.$i_i.'_'.($e_e+1).'"   id="a_'.$i_i.'_'.($e_e+1).'"  value="'.$curso[ $i ][ "notas" ][ 20].'" />';
	
	//$table = $table.'<div >a_'.$i_i.'_'.$e_e.'</div>'; 
	 
	$table = $table."</th>";
	$table = $table."</tr>";
	        
   } // FIN CICLO
		 
$table =  $table."<tr align=center class='formatoth' >";
$table =  $table."<th>N. Lista</th>";
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

pg_close();

?>