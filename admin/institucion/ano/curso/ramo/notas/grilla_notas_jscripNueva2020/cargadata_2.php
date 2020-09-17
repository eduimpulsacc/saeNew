<?
/*error_reporting(E_ALL);
ini_set('display_errors', 1);  */

require('../../../../../../../util/header.inc');



$id_periodo=$_POST["id_periodo"];
$id_ramo=$_POST["id_ramo"];
$id_ano=$_POST["id_ano"];
$nro_ano=$_POST["nro_ano"];
 
/* if($id_ramo==294391){
	print_r($_POST);
	}*/
 
 $promedioX =0;
 
 
 	$sql_subsector="select cod_subsector,modo_eval,notagrupo from ramo where id_ramo=$id_ramo";
	$rs_cod_sub = pg_exec($conn,$sql_subsector);
	$cod_subsector = pg_result($rs_cod_sub,0);
	$mod_eval = pg_result($rs_cod_sub,1);
	$notagrupo = pg_result($rs_cod_sub,2);
	
	
	//si el año no esta cerrado,
	  $sql_prom="select * from promocion where id_curso=$_CURSO and promedio is not null";
		$pr1 = @pg_Exec($conn,$sql_prom);
		$cnt_prom=pg_numrows($pr1);
 	
	
/*$id_periodo = 1200;
$id_ramo = 129637;
$id_ano = 576;*/

//grupos
$cox="#ffffff";
	   if($notagrupo==1){
	//$cox="#ffffff";
			$slqgr="select * from grupo_nota where id_ramo=".$id_ramo." and id_periodo=$id_periodo order by orden";
			$r_gr = pg_exec($conn,$slqgr);
			
			
			//si no encuentro el grupo en el periodo tengo que buscar el año completo para no contaminar la informacion antigua
			
			if(pg_numrows($r_gr)==0 && $cnt_prom>0){
			$slqgr="select * from grupo_nota where id_ramo=".$id_ramo." order by orden";
			$r_gr = pg_exec($conn,$slqgr);
				}
			
			
			//armar grupo
			
			for($gx=0;$gx<pg_numrows($r_gr);$gx++){
			$filaxg = pg_fetch_array($r_gr,$gx);
				 $cox=($gx%2==0)?"#E2E2E2":"#FFE6E6";
				 for($px=0;$px<=18;$px++){
					if($filaxg['nota'.($px+1)]==1){
						//echo $cox;
						$col[$px]['color']=$cox;
					}	 
				}
			
				
			}
				 
		}
		else{
			 for($px=0;$px<=18;$px++){
				//echo $cox;
					$col[$px]['color']="#ffffff";
						 
				}
		
		}
	   
	   //fin grupo
	  // show($col);

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
function desifranotaconseptual2($dato){
$nueva_nota=0;

	$sql="SELECT valor_numerico, rango_x, rango_y FROM modulo_conceptos WHERE id_ano=".$id_ano." AND id_rdb=".$_INSTIT." AND nombre_concepto=".$dato;
	
	if($_PERFIL==0){echo $sql;}
	$rs_concepto = pg_exec($conn,$sql);
	$nueva_nota = pg_result($rs_concepto,0);
	return $nueva_nota;
	
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

function promedioconceptual2( $prom_conc ){
	$letra = "";
	
	
	$sql="SELECT nombre_concepto FROM modulo_conceptos WHERE id_rdb=".$_INSTIT."  AND rango_x >=".$prom_conc." AND rango_y <=".$prom_conc;
	$rs_result = pg_exec($conn,$sql);
	$letra = pg_result($rs_result,0);
	/*if( $prom_conc >=60 && $prom_conc <= 70 ) $letra = 'SI';
	if( $prom_conc >=50 && $prom_conc <= 59 ) $letra = 'G';
	if( $prom_conc >=40 && $prom_conc <= 49 ) $letra = 'RV';
	if( $prom_conc >0   && $prom_conc <= 39 ) $letra = 'N';*/
	
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
		   $trunca_grupo = trim($fila10['bool_aprgrp']);
		    $sql_busca = "SELECT * FROM notas$nro_ano n 
		   INNER JOIN  ramo r ON r.id_ramo=n.id_ramo 
		   WHERE n.id_ramo=".$id_ramo." AND n.id_periodo=".$id_periodo." AND n.nota20 is not null AND n.nota20<>'0' ";
		   $result_busca =@pg_Exec($conn,$sql_busca);
		   $p_nivel = @pg_num_rows($result_busca);
		 }

/*RUTINA PARA ACTUALIZAR LOS PROMEDIOS PARA LOS WNS QUE ESCRIBEN MUY RAPIDO EN EL MODULO DE NOTAS y LAS RUTINAS JSCRIPT NO ALCANZAN A ACTUALIZAR LA CELDA PROMEDIO*/
$sql ="SELECT * FROM NOTAS".$nro_ano." WHERE ID_PERIODO=".$id_periodo." AND id_ramo=".$id_ramo.";  ";
$rs_notas = @pg_exec($conn,$sql);
//return ;

for($i=0;$i<pg_num_rows($rs_notas);$i++){
	
	$fila = pg_fetch_array($rs_notas,$i);
	$rut_alumno = $fila['rut_alumno'];
	$contador = 0;
	$suma = 0;
    $promedio = 0;
	$sumaP = 0;
	$contadorP = 0;
    $promedioP = 0;
	
	$sumaPGX = 0;
    $promedioPGX = 0;
	
	for($j=1;$j<20;$j++){
		
		$n ="nota".$j;
		$nota = $fila[$n];
		
		
		
		
		if( ($fila['rut_alumno']==$rut_alumno) ){
		
		/*Notas Numericas Se Suman DIrectamente*/
		if( $modo_eval == 1 || $modo_eval == 3 ){
			 $suma = $suma + $nota ;
			 
			 
			if($nota!=0){
				$notaP = convertirNotaPorcentaje($nota,$_INSTIT,$conn);
				$notaP = ($notaP>=0)?$notaP:'0';
				$sumaP = $sumaP + $notaP ;
				$contadorP++;
			}else{
				$notaP=101;
			}
			
			
		
		//echo "<br>notacalculada->".$notaP;
		//echo "<br>querynota->".
		$sqlP="update notaponderacion".$nro_ano." set $n='$notaP' where rut_alumno=".$fila['rut_alumno']." and id_ramo=".$fila['id_ramo']." and id_periodo=".$fila['id_periodo'];
		$rsP = pg_exec($conn,$sqlP);
			 
		   }  
				 
		 /*Notas Conceptual pasar a Numerico para despues Sumar*/	
		 if( $modo_eval == 2 || $modo_eval == 4 ){
			
			   $nviene = trim($nota);
				//  $nota=desifranotaconseptual($nota);
				$nota=ConceptualBD(trim($nota),2,$_ANO,$_INSTIT,$conn);
				  
   			      $suma = $suma + $nota;
				  
				  
				if($nota!=0){
					if($nviene=="MB"){
						$notaP=100;
					}else{
						$notaP = convertirNotaPorcentaje($nota,$_INSTIT,$conn);
						$notaP = ($notaP>=0)?$notaP:'0';
						
					}
					$sumaP = $sumaP + $notaP ;
					$contadorP++;
				}else{
					$notaP=101;
				}
				
		
		//echo "<br>notacalculada->".$notaP;
		
	$fila['rut_alumno']."->".$sqlP="update notaponderacion".$nro_ano." set $n='$notaP' where rut_alumno=".$fila['rut_alumno']." and id_ramo=".$fila['id_ramo']." and id_periodo=".$fila['id_periodo'];
		$rsP = pg_exec($conn,$sqlP);
				  
   	    	   }
			   
			    if($modo_eval == 5 ){
			     $sql="SELECT valor_numerico, rango_x, rango_y FROM modulo_conceptos WHERE id_ano=".$id_ano." AND id_rdb=".$_INSTIT." AND nombre_concepto='".trim($nota)."'";
				$rs_concepto = pg_exec($conn,$sql);
				$nota = pg_result($rs_concepto,0);
   			    $suma = $suma + $nota;
				
				
				
				if($nota!=0){
					$notaP = convertirNotaPorcentaje($nota,$_INSTIT,$conn);
					$notaP = ($notaP>=0)?$notaP:'0';
					$sumaP = $sumaP + $notaP ;
					$contadorP++;
				}else{
					$notaP=101;
				}
		
		//echo "<br>notacalculada->".$notaP;
		//echo "<br>querynota->".
		$sqlP="update notaponderacion".$nro_ano." set $n='$notaP' where rut_alumno=".$fila['rut_alumno']." and id_ramo=".$fila['id_ramo']." and id_periodo=".$fila['id_periodo'];
		$rsP = pg_exec($conn,$sqlP);
				
   	      }
		
		  if($nota >0)$contador++;	
		
		}

		
		if($j==19){
		
		/*Promedio Numerico Truncado*/	
		if( $modo_eval == 1 || $modo_eval == 3 ){
		   if( $truncado == 1 ){
			   if( $suma > 0 ) $promedio =  round( $suma / $contador );
			   if( $sumaP > 0 ) $promedioP =  round( $sumaP / $contadorP );
		   }else{
			   if( $suma > 0 ) $promedio =  intval( $suma / $contador );
			   if( $sumaP> 0 ) $promedioP =  round( $sumaP / $contadorP );
		   }
		}
		
		 /************/	 
		if( $modo_eval == 3  ){
			  	 $promedio =  promedioconceptual( $promedio );
				 
				  
				
				 
			  }
       /************/	 
	   
       /*Promedio Conceptual*/
	   if( $modo_eval == 2 || $modo_eval == 4  ){
		  
		      $trunc= ($truncado == 1)?"round":"intval"; 
			   if( $suma > 0 ) $promedio =   $trunc( $suma / $contador );
			   if( $modo_eval_p_nivel != 1 && $modo_eval == 2 ){
					  $promedio =  promedioconceptual( $promedio );
				   }
			   }
		/************/	 
		
		/*Promedio Conceptual*/
	   if( $modo_eval == 5 ){
		  /*// echo "suma-->".$suma."  contador-->".$contador;*/
		   $trunc= ($truncado == 1)?"round":"intval"; 
		   if( $suma > 0 ) $promedio =   $trunc( $suma / $contador );
				 // $promedio =  promedioconceptual2( $promedio );
			$sql="SELECT nombre_concepto FROM modulo_conceptos WHERE id_rdb=".$_INSTIT." AND id_ano=".$_ANO." AND rango_x <=".trim($promedio)." AND rango_y >=".trim($promedio)."";
	$rs_result = pg_exec($conn,$sql);
	$promedio = pg_result($rs_result,0);
	//if($_PERFIL==0){echo $sql; }
	 /* if( $suma > 0 ) $promedio =  intval( $suma / $contador );
			   
				 $promedio =  promedioconceptual2( $promedio);*/
				
		}		 
                    
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
	   	   
	   //grupo_notas
	   //if($_PERFIL==0){
	   if($notagrupo==1){
		   $sumagrop=0;
		   	for($ng=0;$ng<pg_numrows($r_gr);$ng++){
			$cad_grp="";
			$cuengrp=0;
			$fila_gr = pg_fetch_array($r_gr,$ng);
			$porc=$fila_gr['porcentaje']/100;
			
			
			/*Variables para la cadena de porcentajes*/
			$cad_grpX="";
			$cuengrpX=0;
			$sumagropX=0;
			$pprxC=0;
			$ngropC=0;
			
			for($nog=1;$nog<=19;$nog++){
				
				if($fila_gr['nota'.$nog]==1){
				$sqln="select nota".$nog." from notas$nro_ano 
where rut_alumno=".$fila['rut_alumno']." and id_ramo=".$fila['id_ramo']." and id_periodo=".$fila['id_periodo'];
					$rsln=pg_exec($conn,$sqln);				
					if($modo_eval==1 || $modo_eval==3){
						$notaC = pg_result($rsln,0);
						if(intval(pg_result($rsln,0))>0){
							$cad_grp.="cast(nota".$nog." as INT)+";
							$cuengrp++;
						}
						
					}
					
					if($modo_eval==2 || $modo_eval==4){
						if(strlen(pg_result($rsln,0))>0){
							$notaC = pg_result($rsln,0);
							$notaC = ConceptualBD(trim($notaC),2,$_ANO,$_INSTIT,$conn);
							//$notaC=desifranotaconseptual($nota);
							
							//$cad_grp.="cast(nota".$nog." as INT)+";
							$cad_grp.=$notaC."+";
							$cuengrp++;
						}
					}
					elseif($modo_eval==5){
						if(pg_result($rsln,0)!='0'){
							$notaC = pg_result($rsln,0);
							$sql="SELECT valor_numerico, rango_x, rango_y FROM modulo_conceptos WHERE id_rdb=".$_INSTIT." AND nombre_concepto='".trim($notaC)."'";
				$rs_concepto = pg_exec($conn,$sql);
				$notaC = pg_result($rs_concepto,0);
				if(intval(pg_result($rs_concepto,0))>0){
							$cad_grp.=$notaC."+";
							$cuengrp++;
						}
						}
					}
						
						
/////////////montaje porcentaje
$sqlnX="select nota".$nog." from notaponderacion$nro_ano 
where rut_alumno=".$fila['rut_alumno']." and id_ramo=".$fila['id_ramo']." and id_periodo=".$fila['id_periodo'];
					$rslnX=pg_exec($conn,$sqlnX);				
					
						if(intval(pg_result($rslnX,0))<101){
							$cad_grpX.="cast(nota".$nog." as INT)+";
							$cuengrpX=$cuengrpX+1;
						}
					
					
					
//fin montaje porcentaje
						
										
				}	
				
				
					
			}
			
			  $cad_grp = substr($cad_grp,0,-1);
			  $cad_grpX = substr($cad_grpX,0,-1);
			  
			  
			if($cuengrp>0){
			$sql_nogr="select (($cad_grp)) from notas$nro_ano 
	where rut_alumno=".$fila['rut_alumno']." and id_ramo=".$fila['id_ramo']." and id_periodo=".$fila['id_periodo']." ";	
				$rsgrop=pg_exec($conn,$sql_nogr);
				//
				 //$pprx = (pg_result($rsgrop,0)/$cuengrp)*$porc;
				 
				// if($_PERFIL==0){echo "<br>".$fila['rut_alumno']."->".$pprx;}
				//echo "<br>";
				
				
				if($truncado == 0  && $trunca_grupo==1){
					$pprx = (round(pg_result($rsgrop,0)/$cuengrp))*$porc;
					$ngrop=round($pprx); 
					$caso=1;
				}
				elseif($truncado == 1  && $trunca_grupo==0){
					$pprx = intval(pg_result($rsgrop,0)/$cuengrp);
					$pprx = $pprx*$porc;
					$pprx = substr($pprx,0,4);
					$ngrop=$pprx; 
					$caso=2;
				}
				elseif($truncado == 1  && $trunca_grupo==1){
					$pprx = (round(pg_result($rsgrop,0)/$cuengrp))*$porc;
					$caso=3;	
				}
				elseif($truncado == 0  && $trunca_grupo==0){
					 $pprx = (pg_result($rsgrop,0)/$cuengrp)*$porc;
					$caso=4;	
				}
				$ngrop=$pprx; 
				
				$ngrop=( $trunca_grupo == 1  && $truncado==0)?round($pprx):intval($pprx);
				
				$sumagrop=$sumagrop+$ngrop;
				
				
				

							
				
				
			}
			
////////////////////////////montaje promedio porcentaje
if($cuengrpX>0){
				$sql_nogrX="select (($cad_grpX)) from notaponderacion$nro_ano 
	where rut_alumno=".$fila['rut_alumno']." and id_ramo=".$fila['id_ramo']." and id_periodo=".$fila['id_periodo']." ";	
				$rsgropX=pg_exec($conn,$sql_nogrX);
				//
				 //$pprx = (pg_result($rsgrop,0)/$cuengrp)*$porc;
				 
				// if($_PERFIL==0){echo "<br>".$fila['rut_alumno']."->".$pprx;}
				//echo "<br>";
				/*echo "<br>rsgropX->".pg_result($rsgropX,0);
				echo "<br>cuengrpX->".$cuengrpX;
				echo "<br>porc->".$porc;*/
				
				
				
				 $pprxC = (pg_result($rsgropX,0)/$cuengrpX)*$porc;
						
				
				//echo "<br>pprxC->".$pprxC;
				
				//$ngropC=($trunca_grupo == 1  && $truncado==0)?round($pprxC):intval($pprxC);
				
				$sumagropX=$sumagropX+$pprxC;
				
				
				

							
				
				
			}
			$sumaPGX = $sumaPGX+$sumagropX;
			$sumaPGX;
///////////////////////////fin montaje promedio porcentaje			
			
		}
		
		 	if( $sumagrop !="0"){
				
				if($truncado == 1  && $trunca_grupo==0){
			    $promedio =  round( $sumagrop );
		   }else{
			    //echo "pp".
				$promedio =  intval($sumagrop) ;
				//echo "<br>";
		   }
		
		   
		    //$promedio=$sumagrop;
		    if($mod_eval==1){$promedio=$promedio;}
		   if($mod_eval==3){$promedio =  ConceptualBD(trim($promedio),1,$_ANO,$_INSTIT,$conn);}
		   if($modo_eval==5){
			
		$sql="SELECT nombre_concepto FROM modulo_conceptos WHERE id_rdb=".$_INSTIT."  AND rango_x <=".$promedio." AND rango_y >=".$promedio;
			$rs_result = pg_exec($conn,$sql);
			$letra = pg_result($rs_result,0);
			if(strlen($letra)>0){
			  $promedio = $letra;
			}else{
				$getL =  "select min(rango_x) FROM modulo_conceptos  WHERE  id_rdb=$_INSTIT";
				$rgetL = pg_exec($conn,$getL);
				$nm = pg_result($rgetL,0);
				$sql="SELECT nombre_concepto FROM modulo_conceptos WHERE id_rdb=".$_INSTIT."  AND rango_x <=".$nm." AND rango_y >=".$nm;
			$rs_result = pg_exec($conn,$sql);
			$letra = pg_result($rs_result,0);
			 $promedio = $letra;
				
				}
			   
			   }
		   
		   
		   
		  //  if( ($fila['promedio']  != $promedio ) && ( $promedio !="" )) {
				
				$sql_Update = "UPDATE notas".$nro_ano." SET promedio='".$promedio."' WHERE rut_alumno=".$fila['rut_alumno']." AND id_ramo=".$fila['id_ramo']." AND id_periodo=".$fila['id_periodo']."";
			//}
			
			
/////////////////////////////montaje porcentaje
			if( $sumagropX !="0"){
				
					if($truncado == 1  && $trunca_grupo==0){
			@		$promedioX =  round( $sumaPGX );
			   }else{
					//echo "pp".
			@		$promedioX =  intval($sumaPGX) ;
					//echo "<br>";
			   }
			}
			
			$sql_UpdateX = "UPDATE notaponderacion".$nro_ano." SET promedio='".$promedioX."' WHERE rut_alumno=".$fila['rut_alumno']." AND id_ramo=".$fila['id_ramo']." AND id_periodo=".$fila['id_periodo']."";
			@$rs_promedioX = @pg_exec( $conn,$sql_UpdateX ) or die("Error de Sistemas");

/////////////////////////////montaje porcentaje
				
			}
		 
		   
		   }else{
	  // }//fin perfil0
	   
	   
		// && ( $promedio !="0" )
		 if( ($fila['promedio']  != $promedio ) && ( $promedio !="" )) {
		 
	$sql_Update = "UPDATE notas".$nro_ano." SET promedio='".$promedio."' WHERE rut_alumno=".$fila['rut_alumno']." AND id_ramo=".$fila['id_ramo']." AND id_periodo=".$fila['id_periodo']."";
		$rs_promedio = @pg_exec( $conn,$sql_Update ) or die("Error de Sistemas");
		
		
		
		
		
		
		 }
		 
		/* echo "<br>sumap=".$sumaP;
		 echo "<br>contadorP=".$contadorP;
		 echo "<br>".*/$sql_UpdateX = "UPDATE notaponderacion".$nro_ano." SET promedio='".$promedioP."' WHERE rut_alumno=".$fila['rut_alumno']." AND id_ramo=".$fila['id_ramo']." AND id_periodo=".$fila['id_periodo']."";
		$rs_promedioX = @pg_exec( $conn,$sql_UpdateX ) or die("Error de Sistemas");
		
		   }
		  
		
		}
	
	}
		
}
/*************************************************************************/

/*************************************************************************/

$sql_query ="SELECT 
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
LEFT JOIN notas".$nro_ano." ON notas".$nro_ano.".rut_alumno= alumno.rut_alumno 
AND notas".$nro_ano.".id_periodo = ".$id_periodo." AND notas".$nro_ano.".id_ramo = ".$id_ramo." 
INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno AND matricula.id_ano = ".$id_ano." 
INNER JOIN tiene".$nro_ano." ON alumno.rut_alumno = tiene".$nro_ano.".rut_alumno AND tiene".$nro_ano.".id_ramo = ".$id_ramo."  and tiene".$nro_ano.".id_curso=matricula.id_curso 
INNER JOIN ramo ON ramo.id_ramo = ".$id_ramo."  AND ramo.id_curso = matricula.id_curso
INNER JOIN periodo ON periodo.id_periodo = ".$id_periodo." AND periodo.id_ano = ".$id_ano." 
ORDER BY 4,5";

$result = pg_Exec($conn,$sql_query) or die ("Error 333") ; 

//if($_PERFIL==14) echo "<pre>".$sql_query."</pre>";

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

 if($notagrupo!=1){
$table =  $table."<tr align=center class='formatoth' >";
$table =  $table."<th>N&ordm; Lista</th>";
$table =  $table."<th>Alumno</th>";

for ( $e = 1 ; $e < 21 ; $e++ ){  
$table =  $table."<th onMouseOver='mostrarventana(".$e.")' ><a href='#' ><div  class='formatothmsj' id='ventanita".$e."'>&nbsp;".$e."&nbsp;</div></a></th>";
  }
  
$table =  $table."<th>&nbsp;Prom&nbsp;</th>";
$table =  $table."</tr></thead><tbody>";
 }
 else{
$table =  $table."<tr align=center class='formatoth'>";
$table =  $table."    <th rowspan=\"2\">N&ordm; Lista</th>";
$table =  $table."    <th rowspan=\"2\">Alumno</th>";
$rest = 0;
for($gx=0;$gx<pg_numrows($r_gr);$gx++){
	$colspan=0;
$filag = pg_fetch_array($r_gr,$gx);
$nombre = $filag['nombre']." (".$filag['porcentaje']."%)";
for($px=1;$px<=20;$px++){
					if($filag['nota'.($px)]==1){
						$colspan++;
						$rest++;
					}	 
				}	
$table =  $table."    <th colspan=\"".$colspan."\">".$nombre."</th>";
}
$table =  $table."<th colspan=".(20-$rest).">&nbsp;</th>";  
$table =  $table."    <th rowspan=\"2\">Prom</th>";
$table =  $table."  </tr>";
$table =  $table."  <tr align=center class='formatoth'>";
for ( $e = 1 ; $e < 21 ; $e++ ){  
$table =  $table."<th onMouseOver='mostrarventana(".$e.")' ><a href='#' ><div  class='formatothmsj' id='ventanita".$e."'>&nbsp;".$e."&nbsp;</div></a></th>";
  }

  
$table =  $table."  </tr>";
  $table =  $table."</thead><tbody>";
}

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
		
		$table = $table."<th class='formatoth alumn_".($i+1)."'' >".$curso[ $i ][ "nro_lista" ]." ";
		
        /*$table = $table."<div id='rut_alumno".$ont." ' style='display:none;' >".$curso[ $i ][ "rut" ]."</div>"; 
		$table = $table."<div id='id_periodo".$ont."'  style='display:none;' >".$curso[ $i ][ "id_periodo" ]."</div>"; 
		$table = $table."<div id='id_ramo".$ont."' style='display:none;' >".$curso[ $i ][ "id_ramo" ]."</div>"; */
		//$ti =($_PERFIL==0)?"text":"hidden";
		
		if ( $curso[ $i ][ "bool_ar" ] == 0){
		$table = $table.'<input type="hidden" name="rut_alumno'.$ont.'" value="'.$curso[ $i ][ "rut" ].'" />';  //id="rut_alumno'.$ont.'"
		}
		$table = $table.'<input type="hidden" name="id_periodo'.$ont.'" value="'.$curso[ $i ][ "id_periodo" ].'" />';  //id="id_periodo'.$ont.'" 
		
		$table = $table.'<input type="hidden" name="id_ramo'.$ont.'" value="'.$curso[ $i ][ "id_ramo" ].'" />';  //id="id_ramo'.$ont.'"
		
		$table = $table."</th>";
		$table = $table."<th align='left' class='formatoth alumn_".($i+1)."'' >&nbsp;".strtoupper($curso[ $i ][ "ape_pat" ])." ".strtoupper($curso[ $i ][ "ape_mat" ])." ".strtoupper($curso[ $i ][ "nombres" ])."&nbsp;</th>";


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
				
				if( $curso[ $i ][ "notas" ][ $e ]!=0 or $curso[ $i ][ "notas" ][ $e ]=='B' or $curso[ $i ][ "notas" ][ $e ]=='S' or $curso[ $i ][ "notas" ][ $e ]=='I' or $curso[ $i ][ "notas" ][ $e ]=='MB' or $curso[ $i ][ "notas" ][ $e ]=='AL' or $curso[ $i ][ "notas" ][ $e ]=='L' or $curso[ $i ][ "notas" ][ $e ]=='NL' or $curso[ $i ][ "notas" ][ $e ]=='EP' or $curso[ $i ][ "notas" ][ $e ]=='SI' or $curso[ $i ][ "notas" ][ $e ]=='G' or $curso[ $i ][ "notas" ][ $e ]=='RV' or $curso[ $i ][ "notas" ][ $e ]=='N' or $curso[ $i ][ "notas" ][ $e ]=='NO' or $curso[ $i ][ "notas" ][ $e ]=='D' or $curso[ $i ][ "notas" ][ $e ]=='ED'or $curso[ $i ][ "notas" ][ $e ]=='NM' ){
				
						if( $e != 19 ){
						
						      if( $curso[ $i ][ "bool_ar" ] == 1){
							      
							  $table = $table."<td class='guardad' bgcolor='".@$col[$e]['color']."'>".$curso[ $i ][ "notas" ][ $e ]."";
			$table = $table.'<input type="hidden" name="a_'.$i_i.'_'.$e_e.'" id="a_'.$i_i.'_'.$e_e.'" value="'.$curso[ $i ][ "notas" ][ $e ].'" />';
			
			//$table = $table.'<div style="display:none;" >a_'.$i_i.'_'.$e_e.'</div>';
			
			$table = $table."</td>";
							  
							  }else{ 
							  
							  $table = $table."<td class='".$clasico."' bgcolor='".@$col[$e]['color']."' >".$curso[ $i ][ "notas" ][ $e ]."";
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
						  
					        $table = $table."<td class='guardado' bgcolor='".@$col[$e]['color']."'>";
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
					         
					      @  $table = $table."<td bgcolor='".@$col[$e]['color']."'>";
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
	// $hi=($_PERFIL==0)?"hidden":"hidden";	
	
	$table = $table."<th class='formatoth' ><div id='prom".$ont."' >".$curso[ $i ][ "notas" ][20]."</div>";
	$table = $table.'<input type="hidden" name="a_'.$i_i.'_'.($e_e+1).'"   id="a_'.$i_i.'_'.($e_e+1).'"  value="'.$curso[ $i ][ "notas" ][ 20].'" />';
	
	//$table = $table.'<div >a_'.$i_i.'_'.$e_e.'</div>'; 
	 
	$table = $table."</th>";
	$table = $table."</tr>";
	        
   } // FIN CICLO
		
$table =  $table."<tr align=center class='formatoth' >";
$table =  $table."<th>NºLista</th>";
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