<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

		
	//setlocale("LC_ALL","es_ES");
	$institucion	='2163';
	$ano			='116';	
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>


<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'CertificadoEstudios_promocion.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>


<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">

								
								 
		<!-- INGRESO DEL CUERPO DE LA PAGINA -->
		
		<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<center>

<?
//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
	
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.fecha_resolucion ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN comuna ON (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) AND (institucion.region = comuna.cod_reg)) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro'] . " - " . $fila_institu['nom_com']));
	$telefono = $fila_institu['telefono'];
	$region = ucwords(strtolower($fila_institu['nom_reg']));
	$provincia = ucwords(strtolower($fila_institu['nom_pro']));
	$comuna = ucwords(strtolower($fila_institu['nom_com']));



$sql_curso_prom = "select id_curso from curso where id_ano = '$ano' and ensenanza > '309' and grado_curso = '2'";
$res_curso_prom = @pg_Exec($conn, $sql_curso_prom);
$num_curso_prom = @pg_numrows($res_curso_prom);

if ($num_curso_prom > 0){

    for ($i_curso=0; $i_curso < $num_curso_prom; $i_curso++){
    
	$fil_curso_prom = @pg_fetch_array($res_curso_prom,$i_curso);
	
	$curso  = $fil_curso_prom['id_curso'];
	$alumno	= 0;  
	
	
	$POSP = 4;
	$_bot = 8;


	
	
	//--------------------------------
	// CURSO
	//--------------------------------
 	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion, curso.ensenanza, curso.cod_es,curso.truncado_per ";
	$sql_curso = $sql_curso . ", curso.nivel_grado FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
 	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";
	$result_curso =@pg_Exec($conn,$sql_curso);
	$num_consulta = @pg_numrows($result_curso);
	
	
	
	if ($num_consulta==0){
	      /// el plan es propio, hacer otra cosnulta
		  
		  $sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion, curso.ensenanza, curso.cod_es,curso.truncado_per ";
		  $sql_curso = $sql_curso . ", curso.nivel_grado FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN incluye_propio ON curso.cod_decreto = incluye_propio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
		  $sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";
		  $result_curso =@pg_Exec($conn,$sql_curso);
		  $num_consulta = @pg_numrows($result_curso);
	
	}else{
	
	    /// nada ya trae informacion
	}	  
	
	
	$fila_curso = @pg_fetch_array($result_curso,$cont_paginas);
	//$curso = $fila_curso['id_curso'];
	if($institucion==12086){
		if($fila_curso['ensenanza']==110){
			$Curso_pal = CursoPalabra($curso, 4, $conn);			
		}elseif($fila_curso['ensenanza']==310){
			$Curso_pal = CursoPalabra($curso, 5, $conn);			
		}
	}else{
		$Curso_pal = CursoPalabra($curso, 0, $conn);
	}
	$grado = $fila_curso['grado_curso'];
	$ensenanza = $fila_curso['ensenanza'];
	$ensenanza_pal = $fila_curso['nombre_tipo'];
	$nombre_decreto = $fila_curso['nombre_decreto'];
	$nombre_decreto_eval = $fila_curso['nombre_decreto_eval'];
	$rolbasededatos  = $fila_curso['rdb']." - ".$fila_curso['dig_rdb'];
	$nu_resolucion = $fila_curso['nu_resolucion'];
	$cod_es = $fila_curso['cod_es'];
	$truncado_per=$fila_curso['truncado_per'];
	$nivel_curso =$fila_curso['nivel_grado'];
	//-------------------------
	//--------------------------------
	//  ALUMNOS
	//--------------------------------
	
	$sql_alu = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	
	$result_alu =@pg_Exec($conn,$sql_alu);
	//-------------------------------- 
	







$cont_alumnos = @pg_numrows($result_alu);
for($cont_paginas=0 ; $cont_paginas < $cont_alumnos  ; $cont_paginas++)
{
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'];
	$rut_alumno = $fila_alu['rut_alumno'] . " - " . strtoupper($fila_alu['dig_rut']);
	if ($_INSTIT==1593){
	     $nombre_alu = ucwords(strtoupper(trim($fila_alu['nombre_alu']) . " " . trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat'])));
	}else{
	     $nombre_alu = ucwords(strtoupper(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']))); 
	}
	$curso = $fila_alu['id_curso'];
	
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	
	
	
	<br>
	<table width="650" border="1" cellspacing="0" cellpadding="0">
	 
	 
	  <?
	  //----------------------------------
	  // SUBSECTORES - RAMOS
	  //---------------------------------
	  $sql_ramo = "SELECT ramo.cod_subsector, ramo.id_ramo, subsector.nombre, ramo.conex, ramo.modo_eval, ramo.sub_obli, ramo.truncado, ramo.bool_artis ";
      $sql_ramo = $sql_ramo . "FROM ramo, subsector where ramo.id_curso = $curso and ramo.cod_subsector = subsector.cod_subsector ";
      $sql_ramo = $sql_ramo . "ORDER BY ramo.id_orden; ";
	  
	  	  
	  //---------------------------------
	  $result_ramo = @pg_Exec($conn,$sql_ramo);
	  $cont_ramos  = @pg_numrows($result_ramo);
	  for($i=0 ; $i< $cont_ramos  ; $i++)
	  {
		$fila_ramo = @pg_fetch_array($result_ramo,$i);	
		$ramo 			= $fila_ramo['id_ramo'] 	;
		$nombre_ramo 	= $fila_ramo['nombre'] 		;
		$examen 		= $fila_ramo['conex'] 		;
		$modo_eval		= $fila_ramo['modo_eval']	;
		$sub_obli 		= $fila_ramo['sub_obli']	;
		$sub_artis      = $fila_ramo['bool_artis']  ;
		$cod_subsector  = $fila_ramo['cod_subsector'];
		$aprox          = $fila_ramo['truncado'];
		
		/// ver si este ramo pertecene a alguna formula con hijos
		$qry_formula = "select * from formula_hijo where id_hijo = '".trim($ramo)."'";
		$res_formula = @pg_Exec($conn,$qry_formula);
		$num_formula = @pg_numrows($res_formula);
		
	  if ($num_formula==0){
		if ($cod_subsector==22 and $_INSTIT==99999999999999999999) { echo "&nbsp;"; } else { 	
	  ?>
	  
	   	<?
		if ($examen == 2 or $examen == 0){ // Ramo sin examen (consulta en tabla notas)
		
// nuevo
       		if($modo_eval==3){
			         
			
					$sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas2006prom where rut_alumno = ".$alumno." and id_ramo = ".$ramo ;
					$rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
					$prom=0;
					$promedio_ramo=0;
					$con_prom=0;
					$prom_per=0;
					for($g=0 ; $g < @pg_numrows($rsNotas_3) ; $g++)
					{
						$con_notas = 0;
						$sum=0;
						$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
						if($fNotas_3['nota1']>0){
							$notas_1 = $fNotas_3['nota1'];	
							$con_notas=$con_notas+1;	
							$sum = $sum + $notas_1;
						}
						if($fNotas_3['nota2']>0){
							$notas_2 = $fNotas_3['nota2'];	
							$con_notas=$con_notas+1;	
							$sum = $sum + $notas_2;
						}
						if($fNotas_3['nota3']>0){
							$notas_3 = $fNotas_3['nota3'];	
							$con_notas=$con_notas+1;	
							$sum = $sum + $notas_3;
						}
						if($fNotas_3['nota4']>0){
							$notas_4 = $fNotas_3['nota4'];
								$con_notas=$con_notas+1;
							$sum = $sum + $notas_4;
						}
						if($fNotas_3['nota5']>0){
							$notas_5 = $fNotas_3['nota5'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_5;
						}
						if($fNotas_3['nota6']>0){
							$notas_6 = $fNotas_3['nota6'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_6;
						}
						if($fNotas_3['nota7']>0){
							$notas_7 = $fNotas_3['nota7'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_7;
						}
						if($fNotas_3['nota8']>0){
							$notas_8 = $fNotas_3['nota8'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_8;
						}
						if($fNotas_3['nota9']>0){
							$notas_9 = $fNotas_3['nota9'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_9;
						}
						if($fNotas_3['nota10']>0){
							$notas_10 = $fNotas_3['nota10'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_10;
						}
						if($fNotas_3['nota11']>0){
							$notas_11 = $fNotas_3['nota11'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_11;
						}
						if($fNotas_3['nota12']>0){
							$notas_12 = $fNotas_3['nota12'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_12;
						}
						if($fNotas_3['nota13']>0){
							$notas_13 = $fNotas_3['nota13'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_13;
						}
						if($fNotas_3['nota14']>0){
							$notas_14 = $fNotas_3['nota14'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_14;
						}
						if($fNotas_3['nota15']>0){
							$notas_15 = $fNotas_3['nota15'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_15;
						}
						if($fNotas_3['nota16']>0){
							$notas_16 = $fNotas_3['nota16'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_16;
						}
						if($fNotas_3['nota17']>0){
							$notas_17 = $fNotas_3['nota17'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_17;
						}
						if($fNotas_3['nota18']>0){
							$notas_18 = $fNotas_3['nota18'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_18;
						}
						if($fNotas_3['nota19']>0){
							$notas_19 = $fNotas_3['nota19'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_19;
						}
						if($fNotas_3['nota20']>0){
							$notas_20 = $fNotas_3['nota20'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_20;
						}
						if($con_notas>0)
							$prom = $sum/$con_notas;

						    
						    if ($aprox==0){
							     $prom = intval($prom);
							}
							if ($aprox==1){						    
							     $prom =  round($prom);
							}				
														
						
						    if ($_INSTIT!=769 and $_INSTIT!= 2999 and $_INSTIT!=1260 ){
								/// como es modo de evaluacion 3 debo convertir el promedio a conceptual
								if ($prom > 0 and $prom < 40){
									$prom = "I";
								}
								if ($prom > 39 and $prom < 50){
									$prom = "S";
								}
								if ($prom > 49 and $prom < 60)
								{
									$prom = "B";
								}
								if ($prom > 59 ){
									$prom = "MB";
								}				
	
								$prom = Conceptual($prom,2);
							}else{
							    /// nada, ya que el San Viator no promedia los concenptos, sino que promedia los números y al final eso da un concepto
								
							
							}	
						   
                           
							 
							
						if($aprox==0){
							$prom_per = $prom_per + intval($prom);
							if($prom_per>0)	
								$con_prom = $con_prom + 1;
						}
						elseif($aprox==1){
							$prom_per = $prom_per + round($prom);
							if($prom_per>0)	
								$con_prom = $con_prom + 1;
						}

				
					}
					
					if($con_prom>0){
						if($aprox==0){
						    
						    $promedio_ramo=Conceptual(intval($prom_per/$con_prom),1);
						}
						elseif($aprox==1){
						    
							$promedio_ramo=Conceptual(round($prom_per/$con_prom),1);	
						}						
						$promedio_ramo = Promediar($prom_per,$con_prom,$truncado_per);	
										
					}
					
					
			}else{
// fin nuevo		
			$sql_notas = "select *  from notas2006prom, tiene$nro_ano ";
			$sql_notas = $sql_notas . "where notas2006prom.rut_alumno = '".$alumno."' and notas2006prom.id_ramo = ".$ramo." and tiene$nro_ano.id_ramo = $ramo and tiene$nro_ano.rut_alumno ='".$alumno."'";
		    
			
			
			$result_notas = @pg_Exec($conn,$sql_notas);
			
			$promedio_ramo = 0; $contador = 0;
		    for($con_nota=0 ; $con_nota< @pg_numrows($result_notas); $con_nota++)
		    {
				$fila_notas = @pg_fetch_array($result_notas,$con_nota);	
				$promedio = trim($fila_notas['promedio']);
				if ($modo_eval == 1  or $modo_eval ==0  and $promedio>0){
				    
					if ($promedio > 0){
					    $promedio_ramo = $promedio_ramo + $promedio;
					    $contador = $contador  + 1;
					}	
			
				}
//vel



				else if (($modo_eval == 3 || $modo_eval == 2) && (chop($promedio)!="0" )){
					 $promedio = Conceptual($promedio, 2);
					$promedio_ramo = $promedio_ramo + $promedio;
					$contador = $contador  + 1;					
				}				
/*				if ((($modo_eval == 2)||($modo_eval == 3))&& (chop($promedio)!="0")){
					 $promedio = Conceptual($promedio, 2);
					$promedio_ramo = $promedio_ramo + $promedio;
					$contador = $contador  + 1;					
				}*/
				else if (($modo_eval == 3) && (chop($promedio)!="0" )){
					 $promedio = Conceptual($promedio, 2);
					$promedio_ramo = $promedio_ramo + $promedio;
					$contador = $contador  + 1;					
				}
				else if(($modo_eval == 2) && (chop($promedio)!="0" && $promedio!=0)){
					$promedio_ramo = $promedio_ramo + $promedio;
					$contador = $contador  + 1;					
				}
//fin - vel				
			}
			if ($promedio_ramo>0)
			{
				if ($truncado_per==0){
					$promedio_ramo = floor($promedio_ramo / $contador);
					if($institucion==1517){ 
						switch ($promedio_ramo){
							case 19: $promedio_ramo=20; break;
							case 29: $promedio_ramo=30; break;
							case 39: $promedio_ramo=40; break;
							case 49: $promedio_ramo=50; break;
							case 59: $promedio_ramo=60; break;
							case 69: $promedio_ramo=70; break;
						}
					}
	
				}
				if ($truncado_per==1){
					$promedio_ramo = round($promedio_ramo / $contador);
					if($institucion==1517){ 
						switch ($promedio_ramo){
							case 19: $promedio_ramo=20; break;
							case 29: $promedio_ramo=30; break;
							case 39: $promedio_ramo=40; break;
							case 49: $promedio_ramo=50; break;
							case 59: $promedio_ramo=60; break;
							case 69: $promedio_ramo=70; break;
						}
					}
				
				}
				//$promedio_ramo = round($promedio_ramo / $contador);
			

				
				if ($modo_eval == 1 or $modo_eval == 0){
				    if ($_INSTIT==9827 and $promedio_ramo==39){
					    $promedio_ramo = 40;						   
					}
					
					
				}else{
				     $promedio_ramo = Conceptual($promedio_ramo , 1);						
				}
			}else{
				if ($institucion==9239 and $cod_subsector==13){
				     $promedio_ramo = "N/O";
				}else{
				     $promedio_ramo = "&nbsp;";
				}
				/*if ($sub_obli == 1 or $cod_subsector==13){
					$sql_eximidos = "select * from tiene$nro_ano where id_ramo = $ramo and rut_alumno ='". $alumno . "'";
					$result_eximidos = @pg_Exec($conn,$sql_eximidos);				
					if (@pg_numrows($result_eximidos)==0)
						$promedio_ramo = "NO";
				}*/
				
					$sql_eximidos = "select * from tiene$nro_ano where id_ramo = $ramo and rut_alumno ='".$alumno."'";
					$result_eximidos = @pg_Exec($conn,$sql_eximidos);	
					if ($sub_obli == 1){
						if (@pg_numrows($result_eximidos)==0)
							$promedio_ramo = "EX";
							
						
						   }
						   
					$sql_eximidos_artis = "select * from tiene$nro_ano where id_ramo = $ramo and rut_alumno ='".$alumno."'";
					$result_eximidos_artis = @pg_Exec($conn,$sql_eximidos_artis);	
					 if ($sub_artis == 1){
						if (@pg_numrows($result_eximidos_artis)==0)
							$promedio_ramo = "&nbsp;";
							
						
						  }   
					
					
					if(($cod_subsector==13)&&(@pg_numrows($result_eximidos)==0))
							$promedio_ramo = "NO";
					if (($cod_subsector!=13)&&($sub_obli == 2)){
						if (@pg_numrows($result_eximidos)==0)
//							$promedio_ramo = "EX";
							$promedio_ramo = "&nbsp;";
					}
			}
			} // fin if nuevo*****************************************************************
		}else{ // Ramo con examen (consulta en tabla situacion_final)
		   	
			$sql_notas = "select situacion_final.nota_final as promedio from situacion_final where situacion_final.id_ramo = ".$ramo." ";
			$sql_notas = $sql_notas . "and situacion_final.rut_alumno = '".trim($alumno)."'";
		    $result_notas = @pg_Exec($conn,$sql_notas);
			$promedio_ramo = 0; $contador = 0;
			$fila_notas = @pg_fetch_array($result_notas,0);
			$promedio_ramo = $fila_notas['promedio'];
			if ($promedio_ramo>0)
			{
				if ($modo_eval == 1  or $modo_eval == 0){
					
				}else{
					$promedio_ramo = Conceptual($promedio_ramo , 1);
				}
			}else{
				$promedio_ramo = "&nbsp;";
				/*if ($sub_obli == 1 or $cod_subsector==13){
					$sql_eximidos = "select * from tiene$nro_ano where id_ramo = $ramo and rut_alumno = '" . $alumno . "'";
					$result_eximidos = @pg_Exec($conn,$sql_eximidos);				
					if (@pg_numrows($result_eximidos)==0)
						$promedio_ramo = "&nbsp;";
				}	*/
				$sql_eximidos = "select * from tiene$nro_ano where id_ramo = $ramo and rut_alumno ='".trim($alumno)."'";
					$result_eximidos = @pg_Exec($conn,$sql_eximidos);	
					if ($sub_obli == 1){
						if (@pg_numrows($result_eximidos)==0)
							$promedio_ramo = "EX";
							
							
							
							
					}
					if(($cod_subsector==13)&&(@pg_numrows($result_eximidos)==0))
							$promedio_ramo = "NO";
					if (($cod_subsector!=13)&&($sub_obli == 2)){
						if (@pg_numrows($result_eximidos)==0)
							$promedio_ramo = "EX";
					}				
			}			
		}
		//if($institucion==1517){ 
			//switch ($promedio_ramo){
				//case '1.9': $promedio_ramo='2.0'; break;
				//case '2.9': $promedio_ramo='3.0'; break;
				//case '3.9': $promedio_ramo='4.0'; break;
				//case '4.9': $promedio_ramo='5.0'; break;
				//case '5.9': $promedio_ramo='6.0'; break;
				//case '6.9': $promedio_ramo='7.0'; break;
			//}
		//}
			
		
		if ($_INSTIT==9566 and $cod_subsector==13){ 
		         
		     if ($promedio_ramo > 0){
			     $largo_promedio = strlen($promedio_ramo);
				 
				 if ($largo_promedio==3){			     				
				     $caracter1 = substr($promedio_ramo,0,1);
				     $caracter2 = substr($promedio_ramo,2,1);
				     $promedio_ramo = "$caracter1$caracter2";
			     }
			     
				 $promedio_ramo = Conceptual ($promedio_ramo , 1);
								 
			 }else{
			     
			      // el promedio ya es conceptual por lo tanto no lo mando a ninguna parte
			 }
			 
			  ?> 
			      <tr>
					<td ><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> <? echo "  ".$nombre_ramo?></font></td>	     
					<td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? echo $promedio_ramo;?></font> </td>
					<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">&nbsp;</font></td>
				 </tr>		  	 
		      <?
			  
			  /// nuevo código para grabar en tabla de EDuardo
			  $sql_bus_final = "select * from promedio_sub_alumno where rdb = '$institucion' and id_ano = '$ano' and id_curso = '$curso' and id_ramo = '$ramo' and rut_alumno = '".trim($alumno)."'";
			  $res_bus_final = @pg_Exec($conn, $sql_bus_final);
			  $num_bus_final = @pg_numrows($res_bus_final);
			  
			  if ($num_bus_final==0){
			       /// inserto
				   $sql_final_sub = "insert into promedio_sub_alumno (rdb, id_ano, id_curso, id_ramo, rut_alumno, promedio) values ('$institucion','$ano','$curso','$ramo','".trim($alumno)."','$promedio_ramo')";
				   $res_final_sub = @pg_Exec($conn, $sql_final_sub);  
			  }else{
			       /// actualizo			  
			       $sql_final_sub = "update promedio_sub_alumno set promedio = '$promedio_ramo' where rdb = '$institucion' and id_ano = '$ano' and id_curso = '$curso' and id_ramo = '$ramo' and rut_alumno = '".trim($alumno)."'";
				   $res_final_sub = @pg_Exec($conn, $sql_final_sub);
			  }
			  
			 			
		}else{
		      if($modo_eval==3){
			        
			        if ($promedio_ramo==0){
							$promedio_ramo = "&nbsp;";							
					}					
					if ($promedio_ramo > 0 and $promedio_ramo < 40){
							$promedio_ramo = "I";
							$palabra_religion = "INSUFICIENTE";
					}
					if ($promedio_ramo > 39 and $promedio_ramo < 50){
						$promedio_ramo = "S";
						$palabra_religion = "SUFICIENTE";
					}
					if ($promedio_ramo > 49 and $promedio_ramo < 60){
						$promedio_ramo = "B";
						$palabra_religion = "BUENO";
					}
					if ($promedio_ramo > 59 ){
						$promedio_ramo = "MB";
						$palabra_religion = "MUY BUENO";
					}						
				   
			  }
			 
			 if ($_INSTIT==14912 and $cod_subsector==13){
			      //$palabra_religion = Palabras($promedio_ramo, $modo_eval);
			      $variable_aux = '
				  <tr>
				   <td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">'.$nombre_ramo.'</font></td>
				   <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">'.$promedio_ramo.'</font> </td>
				   <td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">'.$palabra_religion.'</font></td>
				  </tr>';
				  
				  
					  /// nuevo código para grabar en tabla de EDuardo
					  $sql_bus_final = "select * from promedio_sub_alumno where rdb = '$institucion' and id_ano = '$ano' and id_curso = '$curso' and id_ramo = '$ramo' and rut_alumno = '".trim($alumno)."'";
					  $res_bus_final = @pg_Exec($conn, $sql_bus_final);
					  $num_bus_final = @pg_numrows($res_bus_final);
					  
					  if ($num_bus_final==0){
						   /// inserto
						   $sql_final_sub = "insert into promedio_sub_alumno (rdb, id_ano, id_curso, id_ramo, rut_alumno, promedio) values ('$institucion','$ano','$curso','$ramo','".trim($alumno)."','$promedio_ramo')";
						   $res_final_sub = @pg_Exec($conn, $sql_final_sub);  
					  }else{
						   /// actualizo			  
						   $sql_final_sub = "update promedio_sub_alumno set promedio = '$promedio_ramo' where rdb = '$institucion' and id_ano = '$ano' and id_curso = '$curso' and id_ramo = '$ramo' and rut_alumno = '".trim($alumno)."'";
						   $res_final_sub = @pg_Exec($conn, $sql_final_sub);
					  }
				  
				  		 
			 }else{		  
				  ?>
				  <tr>
				   <td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? echo "  ".$nombre_ramo?></font></td>
				   <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? echo $promedio_ramo;?></font> </td>
				   <td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">&nbsp;</font></td>
				  </tr>
				  <?
				  
					  /// nuevo código para grabar en tabla de EDuardo
					  $sql_bus_final = "select * from promedio_sub_alumno where rdb = '$institucion' and id_ano = '$ano' and id_curso = '$curso' and id_ramo = '$ramo' and rut_alumno = '".trim($alumno)."'";
					  $res_bus_final = @pg_Exec($conn, $sql_bus_final);
					  $num_bus_final = @pg_numrows($res_bus_final);
					  
					  if ($num_bus_final==0){
						   /// inserto
						   $sql_final_sub = "insert into promedio_sub_alumno (rdb, id_ano, id_curso, id_ramo, rut_alumno, promedio) values ('$institucion','$ano','$curso','$ramo','".trim($alumno)."','$promedio_ramo')";
						   $res_final_sub = @pg_Exec($conn, $sql_final_sub);  
					  }else{
						   /// actualizo			  
						   $sql_final_sub = "update promedio_sub_alumno set promedio = '$promedio_ramo' where rdb = '$institucion' and id_ano = '$ano' and id_curso = '$curso' and id_ramo = '$ramo' and rut_alumno = '".trim($alumno)."'";
						   $res_final_sub = @pg_Exec($conn, $sql_final_sub);
					  }
				  
				  
			 } ?>	
			
	 <? } 
	 
	   
	  
	  }
	  
  } ?>
	  
	  
	  
  	  <? } ?>
	  <tr>
	    <td ><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PROMEDIO GENERAL </font></td>
	    <td align="center">
		
        <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? echo $promedio_final ;?></font> </td>
	    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">
	     
	    </font></td>
	  </tr>
	
	</table>
	<br>
	
	</td>
  </tr>
</table>
<? 

} 


} /// fin form de cursos

}else{

   echo "<br><br>no hay cursos de 4to medio...";

}

echo "fin proceso institucion $institucion  <br>";

?>
</center>
</body>
</html>
<!-- FIN DE CUERPO DE LA PAGINA -->					 
 
<? pg_close($conn);?>