<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
?>
<? 
require('../../../../util/header.inc');
//require('../../../../util/LlenarCombo.php3');
//require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");
	$institucion=$_INSTIT;
	$ano=$_ANO;
	$curso=$cmb_curso;
	$alumno=$cmb_alumno;  
	$reporte=$c_reporte;
	$POSP=4;
	$_bot=8;
	if(isset($_POST['final']))
	$final =1;
	else
	$final=0;
	
	/*if($_PERFIL==0){
	//echo $firma;
	}*/

	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();

	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	/********** A�O ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	/****************DATOS PERIODO************/
	/*$ob_reporte ->ano=$ano;
	$ob_reporte ->periodo=$periodo;
	$ob_reporte ->periodo($conn);
	$periodo_pal = $ob_reporte->nombre_periodo . " DEL " . $nro_ano;
	$result1 = $ob_reporte->result;
	$dias_habiles = $ob_reporte->dias_habiles;
	$fecha_ini = $ob_reporte->fecha_inicio;
	$fecha_fin = $ob_reporte->fecha_termino;
	$ob_reporte ->ano = $ano; 
	$resultPeri = $ob_reporte ->TotalPeriodo($conn);
	$num_periodos = @pg_numrows($resultPeri);
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";	
		*/
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************** CURSO ***********************/
	if($institucion==1518){
		$Curso_pal = CursoPalabra($curso, 3, $conn);
	}else{
		$Curso_pal = CursoPalabra($curso, 0, $conn);
	}
	if($institucion==4772){
		$Curso_pal;
		strtr($Curso_pal,'-','�');
		$Curso_pal;
		
		}

	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);

	//--------------------------------
	// CURSO
	//--------------------------------
 	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto,plan_estudio.cod_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion, curso.ensenanza, curso.cod_es,curso.truncado_per ";
	$sql_curso = $sql_curso . "FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto and plan_estudio.rdb=".$institucion.") INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
 	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";
	$result_curso =@pg_Exec($conn,$sql_curso);
	$num_consulta = @pg_numrows($result_curso);
	
	if ($num_consulta==0){
	      /// el plan es propio, hacer otra cosnulta
		  
		 /* $sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion, curso.ensenanza, curso.cod_es,curso.truncado_per ";
		  $sql_curso = $sql_curso . "FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN incluye_propio ON curso.cod_decreto = incluye_propio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
		  $sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";*/
		  
		  	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto,plan_estudio.cod_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion, curso.ensenanza, curso.cod_es,curso.truncado_per ";
			$sql_curso = $sql_curso . "FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
 			$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";
		  $result_curso =@pg_Exec($conn,$sql_curso);
		  $num_consulta = @pg_numrows($result_curso);
	}else{
	
	    /// nada ya trae informacion
	}
	
	

	$fila_curso = @pg_fetch_array($result_curso,$cont_paginas);
	//$curso = $fila_curso['id_curso'];
	if($institucion==14860){
		$Curso_pal = CursoPalabra($curso, 4, $conn);
	}else{
		$Curso_pal = CursoPalabra($curso, 0, $conn);
	}
	$grado = $fila_curso['grado_curso'];
	$ensenanza = $fila_curso['ensenanza'];
	if($institucion==5661 || $institucion==4655){
		$ensenanza_pal=str_replace('CIENT�FICO','CIENT�FICA',$fila_curso['nombre_tipo']);
	}else{
		$ensenanza_pal = $fila_curso['nombre_tipo'];
	}
	$cod_decreto = $fila_curso['cod_decreto'];
	$nombre_decreto = $fila_curso['nombre_decreto'];
	$nombre_decreto_eval = $fila_curso['nombre_decreto_eval'];
	$rolbasededatos  = $fila_curso['rdb']." - ".$fila_curso['dig_rdb'];
	$nu_resolucion = $fila_curso['nu_resolucion'];
	$cod_es = $fila_curso['cod_es'];
	$truncado_per=$fila_curso['truncado_per'];
	//-------------------------
	if ($ensenanza>309 and $grado>=1){
		$sql_espe = "select * from especialidad where cod_esp = $cod_es";
		$result_espe =@pg_Exec($conn,$sql_espe);
		$fila_espe = @pg_fetch_array($result_espe,0);	
		
		if($institucion==1518){
			$especialidad = ", ESPECIALIDAD DE ".$fila_espe['nombre_esp'];
		}else{
				$especialidad = ", ".$fila_espe['nombre_esp'];
		}
		
	}
	//if($_PERFIL==0) echo "especialidad--".$especialidad;
	//--------------------------------
	//  ALUMNOS
	//--------------------------------
	if ($alumno==0){
		$ob_reporte ->ano = $ano;
		$ob_reporte ->curso = $curso;
		$ob_reporte ->retirado=0;
		$result_alu = $ob_reporte ->FichaAlumnoTodos($conn);
	}else{
		$ob_reporte ->ano = $ano;
		$ob_reporte ->curso = $curso;
		$ob_reporte ->alumno =$cmb_alumno;
		$result_alu = $ob_reporte ->FichaAlumnoUno($conn);
	}


	//-------------------------------- 
	
    $q1 = "select * from trabaja where rdb = '".trim($institucion)."' and (cargo=1 OR cargo=23)";
	$r1 = @pg_Exec($conn,$q1);
	$n1 = @pg_numrows($r1);
	//echo "n1 es: $n1 <br>";
	
	$f1 = @pg_fetch_array($r1,0);
	$cargo = $f1['cargo'];
	//echo "c: $cargo <br>";
	
	if ($cargo==1){
		$cargo_dir  = "director(a)";
		if($institucion!=770){
			$cargo_dir2 = "Director(a)";
		}else{
			$cargo_dir2 = "Director";
		}
	}
	if ($cargo==23){
		$cargo_dir  = "rector(a)";
		$cargo_dir2 = "Rector(a)";
	}	
	
	if ($institucion ==2278) { 
		$cargo_dir  = "director(a)";
		$cargo_dir2 = "Director(a)";
		}
	if($cargo==1 and $_INSTIT==9239){
	    $cargo_dir = "Directora";
	    $cargo_dir2 = "Directora";
	}	
	

$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'];
	$rut_alumno = $fila_alu['rut_alumno'] . " - " . strtoupper($fila_alu['dig_rut']);
	if ($firma==0){
	     $nombre_alu = ucwords(strtoupper(trim($fila_alu['nombre_alu']) . " " . trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat'])));
	}else{
	     $nombre_alu = ucwords(strtoupper(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']))); 
	}
	$curso = $fila_alu['id_curso'];
	
	
	
	
?>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<?php 
$html="<center><table width='550' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td>";
	 if($institucion != 770){
	$html.="<table width='550' border='0' cellspacing='0' cellpadding='0'>
	  <tr>
	    <td width='100' rowspan='5' align='left' valign='top'>
	";
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		$fecha_resolucion = $fila_foto['fecha_resolucion'];
		$ano_solo = substr($fecha_resolucion,0,4);
	    ## c�digo para tomar la insignia

	  if($institucion!=""){
		   $html.= "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   $html.= "<img src='".$d."menu/imag/logo.gif' >";
	  }
		$html.="</td>
		<td width='168' rowspan='5' align='left' valign='top'>		
			<div align='center'>
				<font face='Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>REP&Uacute;BLICA DE CHILE</strong></font><BR>
			    <font face='Verdana, Arial, Helvetica, sans-seri' size='-2'> MINISTERIO DE EDUCACI&Oacute;N</font><BR>
			    <font face='Verdana, Arial, Helvetica, sans-seri' size='-2'> DIVISI&Oacute;N DE EDUCACI&Oacute;N </font><BR>
			    <font face='Verdana, Arial, Helvetica, sans-seri' size='-2'>SECRETAR�A REGIONAL MINISTERIAL</font><BR>
			    <font face='Verdana, Arial, Helvetica, sans-seri' size='-2'>DE EDUCACI&Oacute;N </font><BR>
		    </div></td>
 <td width='50' rowspan='5'>

		</td>			
		<td width='60'><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'>REGI�N</font></td>
		<td width='5' ><font face'Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>:</strong></font></td>
		<td ><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>".$ob_membrete->region."</strong></font></td>
	   

	  </tr>
	  <tr>
		<td><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'>PROVINCIA</font></td>
		<td><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>:</strong></font></td>
		<td><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>";
		//echo $institucion;
		if ($institucion==12838){
		$html.= "CALAMA";
		}else{
		$html.= $ob_membrete->provincia;
		}
		$html.="</strong></font></td>
	    </tr>
	  <tr>
		<td><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'>COMUNA</font></td>
		<td><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>:</strong></font></td>
		<td><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>".$ob_membrete->comuna."</strong></font></td>
	    </tr>
	  <tr>
		<td nowrap><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'>A&Ntilde;O ESCOLAR</font></td>
		<td><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>:</strong></font></td>
		<td><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>".$nro_ano."</strong></font></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	</table>";
  }else{ 
		$html.="<br>";
  } 

$html.="<table width='550' border='0' cellspacing='1' cellpadding='3'>
      <tr>
        <td align='center'><font face='Verdana, Arial, Helvetica, sans-seri' size='3'><strong>CERTIFICADO ANUAL DE ESTUDIOS</strong></font></td>
      </tr>
	  <tr>
        <td align='center'><font face='Verdana, Arial, Helvetica, sans-seri' size='2'>".$ob_membrete->ins_pal."</font></td>
      </tr>
	   <tr >
        <td align='center'>";
		
		if ($institucion==770){ 
		     $html.="<font face='Verdana, Arial, Helvetica, sans-seri' size='1'>".$ensenanza_pal."</font>";
	}else{ 	
		   $html.="<font face='Verdana, Arial, Helvetica, sans-seri' size='2'>".$ensenanza_pal."</font>";
			 
    }
	$html.="</td>
	  </tr>
    </table><br>";
	
	$html.="<table width='550' border='0' cellspacing='0' cellpadding='0'>
	  <tr>
		<td align='center'><font face='Verdana, Arial, Helvetica, sans-seri' size='-1'><strong>";
		
		 if($institucion==770){ $html.= " A�O ESCOLAR $nro_ano"; }else{ $html.= strtoupper($nombre_institu);}
		 
		 $html.="</strong></font></td>
	  </tr>	  
	  <tr>";
	 
	  //if($institucion==11203 or $institucion==287){ //Imprime Todo Seguido
	  if($rd_tipo==2){
		$html.="<td align='justify'>
		      <font face='Verdana, Arial, Helvetica, sans-seri' size='-1'> Reconocido oficialmente por el Ministerio de Educaci�n de la Rep�blica de Chile seg�n ";
			    if($institucion==12086){ $html.= "RESOLUCI�N EXENTA N� 1379 DE FECHA 16 DE JUNIO DE 1987, MODIFICADA Y AMPLIADA SEG�N RESOLUCI�N EXENTA "; }else{ $html.= " DECRETO&nbsp;";}
				
				$html.=" <br> 
		      <strong>&nbsp;N&ordm;&nbsp; 
		      ".$nu_resolucion ." de  ".$ano_solo ."</strong> Rol Base de Datos&nbsp; <strong>N�". $rolbasededatos."</strong> otorga el presente Certificado de Calificaciones  Anuales y Situaci�n Final a DON(A) <u><strong>".$ob_reporte->tildeM($nombre_alu)."</strong></u>&nbsp;&nbsp;Run <strong>".$rut_alumno ."</strong> del&nbsp;  <strong>".$Curso_pal . $especialidad ."</strong> de acuerdo al plan de estudios aprobados por el Decreto&nbsp;<strong> N� ";  
			   if($institucion==253){
				   	$html.= " 5715 de 2001 ";
			   }else{				   
				   $html.= $nombre_decreto;
			   }
			   
			   $html.="</strong> Reglamento de Evaluaci�n y Promoci�n Escolar Decreto exento de Evaluaci�n <strong>N� ". $nombre_decreto_eval ."</strong>
		  </font></td>";	  
        	  }else{ //Imprime el nombre y el rut en una linea aparte
	
		$html.="<td align='justify'>
		      <font face='Verdana, Arial, Helvetica, sans-seri' size='-1'> Reconocido oficialmente por el Ministerio de Educaci�n de la Rep�blica de Chile seg�n "; if($institucion==1590){ $html.= "Ley N�12446 DE 1957 y exento N� 0540 de 1997,"; }elseif($institucion==9940 and $ensenanza==310) { $html.= "DECRETO&nbsp; <b>N� 03016 DE 1977 </b>";}else{ $html.= "DECRETO&nbsp; <strong>N&ordm; 
		       ".$nu_resolucion ." de  ".$ano_solo;} 
			  
			  $html.="</strong> Rol Base de Datos&nbsp;<strong>N� ".$rolbasededatos."</strong> otorga el presente Certificado de Calificaciones  Anuales y Situaci�n Final a DON(A) <strong>".$ob_reporte->tildeM($nombre_alu) ."</strong>, Run&nbsp;<strong>".$rut_alumno ."</strong> del&nbsp; <strong>"; 
			   	if($institucion==5661){
					$html.= $especialidad = str_replace('CIENT�FICO','CIENT�FICA',$Curso_pal);				
				}else{
			   	    $html.= $Curso_pal . $especialidad;
				}	
				 
                 $html.="</strong> de acuerdo al plan de estudios aprobados por ";
                  if($institucion==4772 or $institucion==17686){
					 	$html.= "la resoluci�n exenta ";
				 }else{
                 		$html.= "el Decreto &nbsp;";
				 } 
				
			   $html.="<strong>N� ";
			     
			   if ($institucion==25182){
			   		$html.= "150 de 2007, modifica por N� 4142 de 2009";
			   }elseif($institucion==565 and $ensenanza==310 and ($grado==3)){
				   $numdec = " y N� 128 de 2001 ";
				   $html.= $nombre_decreto.$numdec;
			   }elseif($institucion==565 and $ensenanza==310 and ($grado==4)){
				   $numdec = " y N� 344 de 2002 ";
				  $html.= $nombre_decreto.$numdec;
			    }elseif(($institucion==1709 || $institucion==9276) and $ensenanza==110 and ($grado==5 or $grado==6 or $grado==7 or $grado==8)){
				   $numdec = " y N� 1363 de 2011 ";
				  $html.= $nombre_decreto.$numdec;
				/*}elseif($institucion==253 and $ensenanza==310 and ($grado==1 or $grado==2)){
					echo "5715 de 2001";*/
				
				}elseif( $institucion==9276 and $ensenanza==310 and ($grado==1)){
					 $numdec = " y N� 1358 de 2011 ";
					  $html.= $nombre_decreto.$numdec;
					
				}elseif($institucion==1599  and $ensenanza==110 and ($grado==5 or $grado==6 or $grado==7 or $grado==8)){
					$html.= "1363  de 2011 ";
				
				}elseif($institucion==1603 and $ensenanza==110 and ($grado==5 or $grado==6 or $grado==7 or $grado==8)){
					$html.= " 1363  de 2011 ";
					
				/*}elseif($institucion==133 and $ensenanza==310 and ($grado==1 or $grado==2 or $grado==3 or $grado==4)){
					echo "5715  del 2001 ";*/
				}elseif($institucion==326 and $ensenanza==110 and ($grado==5 or $grado==6 or $grado==7 or $grado==8)){
					$html.= " 256 del 2009 ";			
					
				}else{	
					$html.= $nombre_decreto;
			  }
			  $html.="</strong> Reglamento de Evaluaci�n y Promoci�n Escolar Decreto exento de Evaluaci�n&nbsp; <strong>N� ". $nombre_decreto_eval ."</strong>
		  </font></td>";
	    } 
	  $html.="</tr>
	</table>";
	
	//notas
	$html.="<br>
	<table width='550' border='1' cellspacing='0' cellpadding='0'>
	  <tr>
		<td rowspan='2'><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>SUBSECTOR, ASIGNATURA O M&Oacute;DULO </strong></font></td>
		<td colspan='2' align='center'><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>CALIFICACI&Oacute;N FINAL</strong></font></td>
		</tr>
	  <tr>
		<td width='55' align='center'><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>CIFRAS</strong></font></td>
		<td width='200'><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>EN PALABRAS </strong></font></td>
	  </tr>";
	 
	  //----------------------------------
	  // SUBSECTORES - RAMOS
	  //---------------------------------
	  $ob_reporte ->curso =$cmb_curso;
	  $ob_reporte ->incide=1;
	  $ob_reporte ->NombreSubsector($conn);
	  $result_ramo = $ob_reporte->result;
	  $cont_ramos  = @pg_numrows($result_ramo);
	  for($i=0 ; $i< $cont_ramos  ; $i++)
	  {
		$fila_ramo = @pg_fetch_array($result_ramo,$i);	
		$ramo 			= $fila_ramo['id_ramo'] 	;
		$nombre_ramo 	= $fila_ramo['nombre'] 		;
		$examen 		= $fila_ramo['conex'] 		;
		$modo_eval		= $fila_ramo['modo_eval']	;
		$sub_obli 		= $fila_ramo['sub_obli']	;
		$sub_elect		= $fila_ramo['sub_elect']	;
		$sub_artis      = $fila_ramo['bool_artis']  ;
		$cod_subsector  = $fila_ramo['cod_subsector']	;
		$aprox          = $fila_ramo['truncado']	;
		$sw				=0;
		
				/// ver si este ramo pertecene a alguna formula con hijos
		$qry_formula = "select * from formula_hijo where id_hijo = '".trim($ramo)."'";
		$res_formula = @pg_Exec($conn,$qry_formula);
		$num_formula = @pg_numrows($res_formula);
		
	  if ($num_formula==0){
	
	  if ($final==1) { 
	  	$ob_reporte ->ano = $ano;
		$ob_reporte ->curso =$cmb_curso;
		$ob_reporte ->ramo = $ramo;
		$ob_reporte ->alumno = $alumno;
		$rs_prom_sub = $ob_reporte ->PromedioSubAlumno($conn);
		
		//for($s=0; $s<@pg_numrows($rs_prom_sub); $s++){
			
			$fila_sub = @pg_fetch_array($rs_prom_sub,0);
			$promedio_ramo = trim($fila_sub['promedio']);
			
			if($modo_eval==1){
				$promedio_ramo = substr($promedio_ramo,0,1).".".substr($promedio_ramo,1,1);
				$eval = 1;
			}else{
				$promedio_ramo = trim($fila_sub['promedio']);
				$eval = 2;
			}

			//if($promedio_ramo=="-") $promedio_ramo="EX";
			//if($_PERFIL==0){ 
			
			/*if($sub_obli==1 and ($promedio_ramo=="E.X" or $promedio_ramo==0) and $modo_eval==1){
			
			$promedio_ramo="EX";
				$eval=3;
			}*/
			
			
			
			//}
			
			/*if($sub_obli==1 and $promedio_ramo=="."){
				$promedio_ramo="EX";
				$eval=3;
			}elseif($sub_obli==2 and ($promedio_ramo=="." or $promedio_ramo=="-" or $promedio_ramo=="0")){
				$promedio_ramo="N/O";
			}elseif(trim($nombre_ramo) == "RELIGION"){
					$promedio_ramo = "N/O";
			}*/
			
			$sql ="SELECT * FROM tiene$nro_ano WHERE rut_alumno=".$alumno." AND id_ramo=".$ramo;
			$rs_tiene = @pg_exec($conn,$sql);
			$inscrito = @pg_numrows($rs_tiene);
			//echo $rd_obligatorio;
			//if($sub_obli==1 and ($promedio_ramo=="." or $promedio_ramo=="-" or $promedio_ramo=="0") ){
			
			if($sub_obli==1 and $inscrito==0){
				if($rd_obligatorio==1){
					$promedio_ramo = "N/O";
					$eval=3;
				}elseif($rd_obligatorio==2){
					$promedio_ramo = "EX";
					$eval=3;
				}elseif($rd_obligatorio==3){
					$sw=1;
				}elseif($rd_obligatorio==4){
					$promedio_ramo = $txt_obligatorio;
					$eval=5;
				}
				
			}elseif($sub_obli==0 and ($promedio_ramo=="." or $promedio_ramo=="-" or $promedio_ramo=="0" or $promedio_ramo=="")){
			
				if($rd_electivo==1){
					$promedio_ramo = "N/O";
				}elseif($rd_electivo==2){
					$promedio_ramo = "EX";
				}elseif($rd_electivo==3){
					$sw=1;
					
				}elseif($rd_electivo==4){
					$promedio_ramo = $txt_electivo;
					$eval=5;
				}
			}
			
			if($institucion!=24988){
				if(trim($nombre_ramo) == "RELIGION" and (trim($promedio_ramo)=="." or trim($promedio_ramo)=="-" or trim($promedio_ramo)=="0" or trim($promedio_ramo)=="EX")){
						$promedio_ramo = "N/O";
				}
			}
						
		 	if(( $promedio_ramo!="" or $promedio_ramo!="0" or $promedio_ramo==NULL) and $sw==0 ){	
			$html.= "<tr>
			  <td height='1' ><font face='Verdana, Arial, Helvetica, sans-seri' style='font-size:9px'> ".$nombre_ramo."</font></td>
			  <td align='center'><font face='Verdana, Arial, Helvetica, sans-seri' style='font-size:9px'>".$promedio_ramo."</font> </td>
	          <td><font face='Verdana, Arial, Helvetica, sans-seri' style='font-size:9px'>
			  ".Palabras($promedio_ramo,$eval,$institucion)."</font></td>
             </tr>";
			}
			
		//}
	  
	  } else { 
			
	  
		if ($examen == 2 or $examen == 0){ // Ramo sin examen (consulta en tabla notas)
		
// nuevo
			if($modo_eval==3){
					$sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano where rut_alumno = ".$alumno." and id_ramo = ".$ramo;
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
							
							
							
							if ($_INSTIT!=769 and $_INSTIT!=2999 and $_INSTIT!=1260){
								/// como es modo de evaluacion 3 debo convertir el promedio a conceptual
								/// menos pal San viator que es un pastel especial
								if ($prom > 0 and $prom < 40){
									$prom = "I";
								}
								if ($prom > 39 and $prom < 50){
									$prom = "S";
								}
								if ($prom > 49 and $prom < 60){
									$prom = "B";
								}
								if ($prom > 59 ){
									$prom = "MB";
								}				
								
								$prom = Conceptual($prom,2,$institucion,$ano,$conn);
							}else{
							    /// nada, ya que el San Viator no promedia los concenptos, sino que promedia los n�meros y al final eso da un concepto
							
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
							$promedio_ramo=Conceptual(intval($prom_per/$con_prom),1,$institucion,$ano,$conn);
						}
						elseif($aprox==1){
							$promedio_ramo=Conceptual(round($prom_per/$con_prom),1,$institucion,$ano,$conn);	
						}
						
						$promedio_ramo = Promediar($prom_per,$con_prom,$truncado_per);
						
						
					}
			}
			else{
// fin nuevo		
			$sql_notas = "select *  from notas$nro_ano, tiene$nro_ano ";
			$sql_notas = $sql_notas . "where notas$nro_ano.rut_alumno = '".$alumno."' and notas$nro_ano.id_ramo = ".$ramo." and tiene$nro_ano.id_ramo = $ramo and tiene$nro_ano.rut_alumno ='". $alumno . "'";
		    $result_notas = @pg_Exec($conn,$sql_notas);

			$promedio_ramo = 0; $contador = 0;
		    for($con_nota=0 ; $con_nota< @pg_numrows($result_notas); $con_nota++)
		    {
				$fila_notas = @pg_fetch_array($result_notas,$con_nota);	
				$promedio = trim($fila_notas['promedio']);
				if ($modo_eval == 1  or $modo_eval == 0 and $promedio>0){
				    if ($promedio > 0){
					    $promedio_ramo = $promedio_ramo + $promedio;
					    $contador = $contador  + 1;
					}	
				}
//vel
				else if (($modo_eval == 3 || $modo_eval == 2) && (chop($promedio)!="0" )){
					$promedio = Conceptual($promedio, 2,$institucion,$ano,$conn);
					$promedio_ramo = $promedio_ramo + $promedio;
					$contador = $contador  + 1;					
				}				
/*				if ((($modo_eval == 2)||($modo_eval == 3))&& (chop($promedio)!="0")){
					 $promedio = Conceptual($promedio, 2);
					$promedio_ramo = $promedio_ramo + $promedio;
					$contador = $contador  + 1;					
				}*/
				else if (($modo_eval == 3) && (chop($promedio)!="0" )){
					 $promedio = Conceptual($promedio, 2,$institucion,$ano,$conn);
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
			

				
				if ($modo_eval == 1  or $modo_eval == 0){
				    if ($_INSTIT==9827 and $promedio_ramo==39){
					    $promedio_ramo = 40;						   
					}
					$promedio_ramo = substr($promedio_ramo,0,1).".".substr($promedio_ramo,1,1);
					
				}else{
				     $promedio_ramo = Conceptual($promedio_ramo , 1,$institucion,$ano,$conn);						
				}
			}else{
				$promedio_ramo = "&nbsp;";
				/*if ($sub_obli == 1 or $cod_subsector==13){
					$sql_eximidos = "select * from tiene$nro_ano where id_ramo = $ramo and rut_alumno ='". $alumno . "'";
					$result_eximidos = @pg_Exec($conn,$sql_eximidos);				
					if (@pg_numrows($result_eximidos)==0)
						$promedio_ramo = "NO";
				}*/
				
					$sql_eximidos = "select * from tiene$nro_ano where id_ramo = $ramo and rut_alumno ='". $alumno . "'";
					$result_eximidos = @pg_Exec($conn,$sql_eximidos);	
					if ($sub_obli == 1){
						if (@pg_numrows($result_eximidos)==0)
							$promedio_ramo = "EX";
							
						
						   
					}
					
					
					$sql_eximidos_artis = "select * from tiene$nro_ano where id_ramo = $ramo and rut_alumno ='". $alumno . "'";
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
					$promedio_ramo = substr($promedio_ramo,0,1).".".substr($promedio_ramo,1,1);
				}else{
					$promedio_ramo = Conceptual($promedio_ramo , 1,$institucion,$ano,$conn);
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
		if($institucion==1517){ 
			switch ($promedio_ramo){
				case '1.9': $promedio_ramo='2.0'; break;
				case '2.9': $promedio_ramo='3.0'; break;
				case '3.9': $promedio_ramo='4.0'; break;
				case '4.9': $promedio_ramo='5.0'; break;
				case '5.9': $promedio_ramo='6.0'; break;
				case '6.9': $promedio_ramo='7.0'; break;
			}
		}
			
		
		if ($_INSTIT==9566 and $cod_subsector==13){ 
		         
		     if ($promedio_ramo > 0){
			     $largo_promedio = strlen($promedio_ramo);
				 
				 if ($largo_promedio==3){			     				
				     $caracter1 = substr($promedio_ramo,0,1);
				     $caracter2 = substr($promedio_ramo,2,1);
				     $promedio_ramo = "$caracter1$caracter2";
			     }
			     
				 $promedio_ramo = Conceptual ($promedio_ramo , 1,$institucion,$ano,$conn);
			 }else{
			      // el promedio ya es conceptual por lo tanto no lo mando a ninguna parte
			 }	  	 		
		     	if($promedio_ramo!="EX"){
			 		
			$html.=" <tr>
			  <td height='1' ><font face='Verdana, Arial, Helvetica, sans-seri' style='font-size:9px'> ".$nombre_ramo."</font></td>
			  <td align='center'><font face='Verdana, Arial, Helvetica, sans-seri' style='font-size:9px'>".$promedio_ramo."</font> </td>
	          <td><font face='Verdana, Arial, Helvetica, sans-seri' style='font-size:9px'>".Palabras($promedio_ramo, 2,$institucion)."</font></td>
             </tr>";
		     
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
				  
				  
				  		 
			 }else{	
			 		if($promedio_ramo!="EX"){	  
				  
				$html.= "<tr>
				  <td height='1'><font face='Verdana, Arial, Helvetica, sans-seri' style='font-size:8px'>".$nombre_ramo."</font></td>
				  <td align='center'><font face='Verdana, Arial, Helvetica, sans-seri' style='font-size:8px'>".$promedio_ramo."</font></td>
				  <td><font face='Verdana, Arial, Helvetica, sans-seri' style='font-size:8px'>".Palabras($promedio_ramo, $modo_eval,$institucion)."</font></td>
				 </tr>";
		   		}
		   } 	 
				 
	  } 
	  }
	  
	    } 
	  
	  
	  
  	   } 
	  $html.="<tr>
	    <td ><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'>PROMEDIO GENERAL </font></td>
	    <td align='center'>";
		
		$sql_final = "select promedio, asistencia, situacion_final, observacion from promocion where promocion.rut_alumno = '".trim($alumno)."'";
		$sql_final = $sql_final . "and promocion.id_ano = $ano  AND id_curso=$cmb_curso";
		//if($_PERFIL==0) echo $sql_final;
		$result_final = @pg_Exec($conn,$sql_final);
		$fila_final = @pg_fetch_array($result_final,0);
		if ($fila_final['promedio']>0){
			$promedio_final = substr($fila_final['promedio'],0,1).".".substr($fila_final['promedio'],1,1);
			$asistencia = $fila_final['asistencia']."%"; 
			$situacion_final = $fila_final['situacion_final'];
			$observacion = $fila_final['observacion'];
		}else{
			$promedio_final = "&nbsp;";
			$asistencia = "&nbsp;";
			$situacion_final = $fila_final['situacion_final'];
		}
		
        $html.="<font face='Verdana, Arial, Helvetica, sans-seri' size='-2'>".$promedio_final."</font> </td>
	    <td><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'>".Palabras($promedio_final, 1,$institucion)."
	    </font></td>
	    </tr>";
		
	  
		if ($_INSTIT==14912){
		
			  $html.= $variable_aux;
		
		 } 	

		
	 $html.= "<tr>
		<td ><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'>PORCENTAJE DE ASISTENCIA </font></td>
		<td align='center'><font face='Verdana, Arial, Helvetica, sans-seri' size='-2'>".$asistencia."</font></td>
		<td>&nbsp;</td>
	  </tr>";
	  if($institucion==5661){ 
	  	$html.="</table>
		<table width='550' border='0' cellpadding='0' cellspacing='0'>";
	   }
	  $html.="<tr >
		    <td height='28' colspan='3'>";
		
		
			if (trim($alumno)=="22982917"){ 
			     $html.= "&nbsp;";
			}else{  	 
			
			        $html.="<font face='Verdana, Arial, Helvetica, sans-seri' size='-2'><strong>
					EN CONSECUENCIA: </strong> ";
					 
						if (($ensenanza==560) and ($grado==1)) {  
						$grado=$grado+1; 
						} 
						
					if ($_INSTIT==1593 || $_INSTIT==10232){
						 $nuevo_curso = $grado + 1;
						 if ($nuevo_curso==1){
							 $paso_a = "PRIMER";
						 }
						 if ($nuevo_curso==2){
							 $paso_a = "SEGUNDO";
						 }
						 if ($nuevo_curso==3){
							 $paso_a = "TERCER";
						 }
						 if ($nuevo_curso==4){
							 $paso_a = "CUARTO";
						 }
						 if ($nuevo_curso==5){
							 $paso_a = "QUINTO";
						 }
						 if ($nuevo_curso==6){
							 $paso_a = "SEXTO";
						 }
						 if ($nuevo_curso==7){
							 $paso_a = "SEPTIMO";
						 }
						 if ($nuevo_curso==8){
							 $paso_a = "OCTAVO";
						 }
					
						 $situacion_pal = "ES PROMOVIDO(A) A ".$paso_a." A�O DE ".strtoupper($ensenanza_pal);
					}else{
						 if($institucion==25182 and ($grado==1 or $grado==2)){
							 $situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A ".($grado+1)."� A�O DE ENSE�ANZA MEDIA ";
						 }elseif($institucion==283 and $grado==2){
							 $situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A ".($grado+1)."� A�O DE ENSE�ANZA MEDIA ";				 
						 
						 }else{
							 if($institucion==1676 and ($grado==4)){
								 $situacion_pal = "EL ALUMNO(A) HA EGRESADO DE LA ENSE�ANZA MEDIA ADULTO CIENTIFICO HUMANISTA";
							 }
							 if($cod_decreto==121987 and ($grado==3 or $grado==4) ){
								 $situacion_pal = "EL ALUMNO(A) HA EGRESADO DE LA ENSE�ANZA MEDIA ADULTO CIENTIFICO HUMANISTA";
							}else{
								 $situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A ".($grado+1)."� A�O DE  ".strtoupper($ensenanza_pal);
							 }
						 }
					}
					
					
					if ($grado == 8)
						$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO(A) DE LA ".strtoupper($ensenanza_pal);
		
					if ($grado==4 and $ensenanza>309)
						if($institucion==1436 || $institucion==1676){
							$situacion_pal = "EL ALUMNO(A) EGRESA DE ".strtoupper($ensenanza_pal);
						}else{
							$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO(A) DE LA ".strtoupper($ensenanza_pal);
						}
					
				if  ($ensenanza==361){
					if ($grado == 1)
						$situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A SEGUNDO CICLO DE ".strtoupper($ensenanza_pal);
					if ($grado == 2)
						$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO(A) DE LA ".strtoupper($ensenanza_pal);
				}
				if  ($ensenanza==363){
					if ($grado == 1)
						$situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A SEGUNDO NIVEL  DE ".strtoupper($ensenanza_pal);
					if ($grado == 3)
						$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO(A) DE LA ".strtoupper($ensenanza_pal);
				}
				if  ($ensenanza==663){
					if ($grado == 1)
						$situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A SEGUNDO NIVEL  DE ".strtoupper($ensenanza_pal);
					if ($grado == 3)
						$situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A TERCER NIVEL  DE ".strtoupper($ensenanza_pal);
					if ($grado == 4)
						$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO(A) DE LA ".strtoupper($ensenanza_pal);
				}
				if  ($ensenanza==610){
					if ($grado == 4)
						$situacion_pal = "EL ALUMNO(A) HA SIDO EGRESADO(A) DE LA ".strtoupper($ensenanza_pal);
				}
				if  ($ensenanza==410){
					if ($grado == 4)
						$situacion_pal = "EL ALUMNO(A) HA SIDO EGRESADO(A) DE LA ".strtoupper($ensenanza_pal);
				}		
				if  ($ensenanza==563 or $ensenanza==463){
					if ($grado == 1)
						$situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A SEGUNDO NIVEL  DE ".strtoupper($ensenanza_pal);
					if ($grado == 3)
						$situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A TERCER NIVEL  DE ".strtoupper($ensenanza_pal);
					if ($grado == 4)
						$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO(A) DE LA ".strtoupper($ensenanza_pal);
				}
				
				if  ($ensenanza==110 and $grado == 8){
					  if ($_INSTIT==1593  || $_INSTIT==10232){
						   $situacion_pal = "ES PROMOVIDO(A) A PRIMER A�O DE ENSE�ANZA MEDIA";
					  }else{
						   $situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A PRIMERO DE ENSE�ANZA MEDIA";
					  }	   
				}		

				if ($situacion_final==1)
						$html.= $situacion_pal;
					if ($situacion_final==2){
						if($_INSTIT==10232){
						 if ($grado==1){
							 $paso_a = "PRIMER";
						 }
						 if ($grado==2){
							 $paso_a = "SEGUNDO";
						 }
						 if ($grado==3){
							 $paso_a = "TERCER";
						 }
						 if ($grado==4){
							 $paso_a = "CUARTO";
						 }
						 if ($grado==5){
							 $paso_a = "QUINTO";
						 }
						 if ($grado==6){
							 $paso_a = "SEXTO";
						 }
						 if ($grado==7){
							 $paso_a = "SEPTIMO";
						 }
						 if ($grado==8){
							 $paso_a = "OCTAVO";
						 }
							$html.= "REPITE EL ".$paso_a." A�O DE ".strtoupper($ensenanza_pal);
							
						}elseif($_INSTIT==1914 or  $_INSTIT==40252){
						 if ($grado==1){
							 $paso_a = "PRIMER";
						 }
						 if ($grado==2){
							 $paso_a = "SEGUNDO";
						 }
						 if ($grado==3){
							 $paso_a = "TERCER";
						 }
						 if ($grado==4){
							 $paso_a = "CUARTO";
						 }
						 if ($grado==5){
							 $paso_a = "QUINTO";
						 }
						 if ($grado==6){
							 $paso_a = "SEXTO";
						 }
						 if ($grado==7){
							 $paso_a = "SEPTIMO";
						 }
						 if ($grado==8){
							 $paso_a = "OCTAVO";
						 }
							$html.= "EL ALUMNO(A) HA REPROBADO EL ".$paso_a." A�O DE ".strtoupper($ensenanza_pal);
						}else{
							$html.= "EL ALUMNO(A) HA REPROBADO EL ".$Curso_pal;
						}
					}
					if ($situacion_final==3)
						$html.= "EL ALUMNO(A) FUE RETIRADO";

				
				$html.=" </font>";
			  
	  } 	
	  
			$html.="  </td>
		</tr>";
		if($institucion!=5661){	  
			$html.="</table>";
		 } 
	
	 if ($_INSTIT!=8905 or $_INSTIT!=24988 or $_INSTIT!=4655){ }
	$html.="<table width='550' border='0' cellpadding='0' cellspacing='0'>
	  <tr>
		<td height='20'><div align='left'><font size='2'><font face='Verdana, Arial, Helvetica, sans-seri'>Observaciones:</font></font>&nbsp;&nbsp;";if($observacion!="" ){$html.="<font size='-1' face='Verdana, Arial, Helvetica, sans-seri'>";$observacion."</font>";}$html.="</div></td>
	  </tr>";
	   for($xx=1;$xx<=$filas;$xx++){
	 $html.=" <tr>
		<td height='10'>__________________________________________________________________________________________</td>
	  </tr>";
	  } 
		
	$html.="</table>";
	 for($yy=1; $yy<=$txtESPACIO; $yy++){
		$html.=  "<BR>";
	}
	$html.="<br>

	<table width='550' border='0' align='center'>
  <tr>";
      
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->empleado=$ob_config->empleado1;
				$ob_reporte->curso=$cmb_curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='70'><hr align='center' width='150' color='#000000'><div align='center'><font face='Verdana, Arial, Helvetica, sans-seri' size='-1'>$ob_reporte->nombre_emp<br>$ob_reporte->nombre_cargo</font></div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				$html.= $firmadig1;
				}else{
				
                
			$html.="<td width='25%' class='item' height='100'><div style='width:100; height:50;'></div><hr align='center' width='150' color='#000000'><div align='center'><font face='Verdana, Arial, Helvetica, sans-seri' size='-1'>".$ob_reporte->nombre_emp."<br>".$ob_reporte->nombre_cargo."</font></div></td>";
			 }}
			 if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->empleado=$ob_config->empleado2;
				$ob_reporte->curso=$cmb_curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				if($institucion!=1914 && $institucion!=40251){
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='70'><hr align='center' width='150' color='#000000'><div    align='center'><font face='Verdana, Arial, Helvetica, sans-seri' size='-1'>$ob_reporte->nombre_emp<br>$ob_reporte->nombre_cargo</font></div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				}
				if(isset($firmadig2)){
				$html.= $firmadig2;
				}else{
				
		    $html.="<td width='25%' class='item'><div style='width:100; height:50;'></div><hr align='center' width='150' color='#000000'> 
		      <div align='center'><font face='Verdana, Arial, Helvetica, sans-seri' size='-1'>".$ob_reporte->nombre_emp."<br>
	        ".$ob_reporte->nombre_cargo."</font></div></td>";
			 }} 
			 if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->curso=$cmb_curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='70'><hr align='center' width='150' color='#000000'><div    align='center'>font face='Verdana, Arial, Helvetica, sans-seri' size='-1'>$ob_reporte->nombre_emp<br>$ob_reporte->nombre_cargo</font></div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				$html.= $firmadig3;
				}else{
				
				$html.="<td width='25%' class='item'><div style='width:100; height:50;'></div><hr align='center' width='150' color='#000000'><div align='center'><font face='Verdana, Arial, Helvetica, sans-seri' size='-1'>".$ob_reporte->nombre_emp."<br>
		    ".$ob_reporte->nombre_cargo."</font></div></td>";
			 }}
			 if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->curso=$cmb_curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='200' height='70'><hr align='center' width='150' color='#000000'><div    align='center'>font face='Verdana, Arial, Helvetica, sans-seri' size='-1'>$ob_reporte->nombre_emp<br>$ob_reporte->nombre_cargo</div></font></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				$html.= $firmadig4;
				}else{
		
		$html.="  <td width='25%' class='item'><div style='width:100; height:50;'></div><hr align='center' width='150' color='#000000'><div align='center'><font face='Verdana, Arial, Helvetica, sans-seri' size='-1'>".$ob_reporte->nombre_emp."<br>
	        ".$ob_reporte->nombre_cargo."</font></div></td>";
			 }}
		  $html.="</tr>
		</table>
	</td>
  </tr>
</table>
<table width='550' border='0' align='center'>
  <tr>
  <td>&nbsp;</td>
    <td><font face='Verdana, Arial, Helvetica, sans-serif' size='1'>".ucwords(strtolower($ob_membrete->comuna)).", ". $dia." de ".$mes." del ".$ano2 ."</font></td>
  </tr>
</table>";


	//fin tabla contenedora
	$html.="
    </td>
    </tr>
    </table></center>
";

function Palabras($prom, $modo, $institucion)
{
	$palabra="";
	$palabra_completa = "";
	if ($modo == 1 or $modo == 0){
		
	    for($e=0 ; $e < 3; $e++)
		{
			$numero = substr($prom,$e,1);
			switch ($numero) {
			
			 case ".":				 
				 $palabra[$e] = "COMA";
				 break;				 
			 case "0":
				 $palabra[$e] = "CERO";
				 break;
			 case "1":
				 $palabra[$e] = "UNO";
				 break;
			 case "2":
				 $palabra[$e] = "DOS";
				 break;
			 case "3":
				 $palabra[$e] = "TRES";
				 break;
			 case "4":
				 $palabra[$e] = "CUATRO";
				 break;				 				 				 
			 case "5":
				 $palabra[$e] = "CINCO";
				 break;
			 case "6":
				 $palabra[$e] = "SEIS";
				 break;
			 case "7":
				 $palabra[$e] = "SIETE";
				 break;
			 case "8":
				 $palabra[$e] = "OCHO";
				 break;
			 case "9":
				 $palabra[$e] = "NUEVE";
				 break;				 
			}

		}
		if($institucion==10232){
			$palabra_completa = $palabra[0]." , ".$palabra[2];
		}else{
			$palabra_completa = $palabra[0]." ".$palabra[1]." ".$palabra[2];
		}
	}elseif($modo==5){
		$palabra_completa = "&nbsp;";	
	}else{
		switch(trim($prom)){
			case "MB":
				$palabra_completa = "MUY BUENO";
				break;
			case "B":
				$palabra_completa = "BUENO";
				break;
			case "S":
				$palabra_completa = "SUFICIENTE";
				break;
			case "I":
				$palabra_completa = "INSUFICIENTE";												
				break;
		}
	}
	if($prom=="N/O")
		$palabra_completa="NO OPTA";
	if($prom=="-")
		$palabra_completa="&nbsp;";
	if ($prom=="EX")
		$palabra_completa = "EXIMIDO DEL SUBSECTOR";
	if (chop($palabra_completa)=="")
		$palabra_completa = "&nbsp;";
	/*if ($prom!="EX" and $prom!="N/O")
		$palabra_completa = "&nbsp;";*/
		
		
	return  $palabra_completa;
}
?>
<? pg_close($conn);?>
<?php

     
 //  $content=$html;
    $content = ob_get_clean();
	$fecha_actual = date('d_m_Y-H:i:s');

    // convert to PDF
    require_once("../../../clases/dompdf/dompdf_config.inc.php");
    $dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->set_paper('Legal', 'portrait');
$dompdf->stream("CertificadoAnualEstudios".$fecha_actual.".pdf",array("Attachment" => false));
?>