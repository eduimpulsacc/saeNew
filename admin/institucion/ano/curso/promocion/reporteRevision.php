<?php require('../../../../../util/header.inc');
include('../../../../clases/class_Reporte.php');
include('../../../../clases/class_Membrete.php');

	$institucion	=$_INSTIT;
	$ano			=$anio;
	//echo "<h1>$ano</h1>";
	$curso			=$curso;
	$_POSP = 4;
	$_bot = 8;
	
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/***************** INSTITUCION *****************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
	
	/************* AÑO ESCOLAR ****************/
	$ob_reporte ->ano =$ano;
	$ob_reporte ->AnoEscolar($conn);
	$nro_ano = $ob_reporte->nro_ano;
	
	/********* CURSO *******************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	/************* PROFE JEFE *************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************* SUBSECTOR ****************/
	$ob_reporte ->curso = $curso;
	$ob_reporte ->SubsectorRamo($conn);
	$result_sub = $ob_reporte ->result;
	$num_subsectores = @pg_numrows($result_sub);
?>


<?php 

	
	
	
	
	if ($dia == ""){
	   ## si el campo esta vacío poner la fecha actual
	   $dia  = strftime("%d",time());
	   $mes  = strftime("%m",time());
	   $mes  = envia_mes($mes);
	   $ano2  = strftime("%Y",time()); 
	}else{
	   $dia = $dia;
	   $mes = $mes;
	   $ano2 = $ano2;
	}   
	
/*$sql ="SELECT num_corp FROM corp_instit WHERE rdb=".$institucion;
$rs_corp = @pg_exec($conn,$sql);	
$corporacion = @pg_result($rs_corp,0);
	*/
	//if ($curso==0) {exit;}
	
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	//echo $sql_ano;
	
	$result_ano =pg_Exec($conn,$sql_ano);
	$fila_ano = pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.dig_rdb, institucion.nombre_instit, institucion.calle, institucion.nro, date_part('year',institucion.fecha_resolucion)as fecha_res, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.nu_resolucion, institucion.region ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	//if($_PERFIL==0) echo $sql_ins;
	$result_ins =pg_Exec($conn,$sql_ins);
	$fila_ins = pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$rdb = $institucion."-".$fila_ins['dig_rdb'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];
	$resolucion = $fila_ins['nu_resolucion'];
	$fecha_res = $fila_ins['fecha_res'];
	$comuna = $fila_ins['nom_com'];
	$ciudad = $fila_ins['nom_pro'];
	$region= $fila_ins['nom_reg'];
	$cod_region = $fila_ins['region'];
	//-------
	$sql_curso = "select curso.grado_curso, curso.letra_curso,  tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.ensenanza, curso.cod_es,curso.nivel_grado, niveles.nombre ";
	$sql_curso = $sql_curso . "from curso left outer join niveles on curso.id_nivel=niveles.id_nivel, tipo_ensenanza, plan_estudio, evaluacion ";
	$sql_curso = $sql_curso . "where id_curso = ".$curso." and curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql_curso = $sql_curso . "and plan_estudio.cod_decreto = curso.cod_decreto ";
	$sql_curso = $sql_curso . "and evaluacion.cod_eval = curso.cod_eval";
	//if($_PERFIL==0) echo $sql_curso;
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,0);
	$nivel_grado = $fila_curso['nivel_grado'];
	/*$curso_pal = $fila_curso['grado_curso']."-".$fila_curso['letra_curso'];*/
	$grado_curso = $fila_curso['grado_curso'];
	$letra_curso = $fila_curso['letra_curso'];
	$niveles = $fila_curso['nombre'].$letra_curso;
	$tipo_ensenanza = $fila_curso['nombre_tipo'];
	$plan_estudio =  $fila_curso['nombre_decreto'];
	$decreto_eval =  $fila_curso['nombre_decreto_eval'];
	$ense = $fila_curso['ensenanza'];
	$cod_es = $fila_curso['cod_es'];
	if($institucion==12086){
		if($fila_curso['ensenanza']==110){
			$curso_pal = CursoPalabra($curso, 4, $conn);			
		}elseif($fila_curso['ensenanza']==310){
			$curso_pal = CursoPalabra($curso, 4, $conn);			
		}
	}else{
		$curso_pal = CursoPalabra($curso, 0, $conn);
	}
	//-------------------------
	if ($ense>309 and $grado_curso>2){
		$sql_espe = "select * from especialidad where cod_esp = $cod_es";
		$result_espe =@pg_Exec($conn,$sql_espe);
		$fila_espe = @pg_fetch_array($result_espe,0);	
		$especialidad = ucwords(strtolower(", ".$fila_espe['nombre_esp']));
	}
	//--------------------------------	
	//---------
	if (($grado_curso==1 or $grado_curso==2) and $ense == 110) $nb = "NB1";
	if (($grado_curso==3 or $grado_curso==4) and $ense == 110) $nb = "NB2";	
	if (($grado_curso==5) and $ense == 110) $nb = "NB3";
	if (($grado_curso==6) and $ense == 110) $nb = "NB4";
	if (($grado_curso==7) and $ense == 110) $nb = "NB5";
	if (($grado_curso==8) and $ense == 110) $nb = "NB6";
	//-------
	if (($grado_curso==1) and $ense > 300 ) $nb = "NM1";
	if (($grado_curso==2) and $ense > 300 ) $nb = "NM2";
	if (($grado_curso==3) and $ense > 300 ) $nb = "NM3";
	if (($grado_curso==4) and $ense > 300 ) $nb = "NM4";	
	//-------
	
	//if($_PERFIL==0){
		$sql= "SELECT num_corp FROM corp_instit WHERE rdb=".$institucion;
		$rs_corp = @pg_exec($conn,$sql);
		$corporacion = @pg_result($rs_corp,0);
	//}else{
		//$corporacion=$_CORPORACION;
	//}
	/*if($corporacion==13){
		$fecha ="30-04-".$ano_escolar;
	}else{*/
		$fecha ="04-30-".$ano_escolar;
	//}

	$sql_alumnos = "select upper(alumno.ape_pat) as a,upper(alumno.ape_pat) as ape_pat, upper(alumno.ape_mat) as ape_mat, upper(alumno.nombre_alu) as nombre_alu, matricula.rut_alumno, upper(alumno.dig_rut) as dig_rut, alumno.sexo, alumno.fecha_nac, comuna.nom_com, matricula.id_curso, matricula.bool_ar ";
	$sql_alumnos = $sql_alumnos . "from matricula, alumno, comuna ";
	$sql_alumnos = $sql_alumnos . "where matricula.id_curso = ".$curso." and matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alumnos = $sql_alumnos . "and comuna.cor_com = alumno.comuna and comuna.cod_reg = alumno.region and comuna.cor_pro = alumno.ciudad and ((matricula.bool_ar=1 and matricula.fecha_retiro > '".$fecha."') or (matricula.bool_ar=0)) and nacionalidad=2";
	
	/*if ($institucion ==10774){*/
	$sql_alumnos = $sql_alumnos . "order by numero_reporte, a, alumno.ape_mat, alumno.nombre_alu ";
	/*}
	else
	{
	$sql_alumnos = $sql_alumnos . "order by nro_lista, a, alumno.ape_mat, alumno.nombre_alu ";
	}*/
	if($_PERFIL==0){
	//echo "<br>".$sql_alumnos;
	}
	$rsAlumnos =@pg_Exec($conn,$sql_alumnos);
	
	/*if ($_PERFIL==0){
		
		echo $sql_alumnos;}*/
	
	/*$sql_alumnos = "select upper(alumno.ape_pat) as ape_pat, upper(alumno.ape_mat) as ape_mat, upper(alumno.nombre_alu) as nombre_alu, matricula.rut_alumno, upper(alumno.dig_rut) as dig_rut, alumno.sexo, alumno.fecha_nac, comuna.nom_com, matricula.id_curso, matricula.bool_ar ";
	$sql_alumnos = $sql_alumnos . "from matricula, alumno, comuna ";
	$sql_alumnos = $sql_alumnos . "where matricula.id_curso = ".$curso." and matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alumnos = $sql_alumnos . "and comuna.cor_com = alumno.comuna and comuna.cod_reg = alumno.region and comuna.cor_pro = alumno.ciudad and ((matricula.bool_ar=1 and matricula.fecha_retiro > '".$ano_escolar."-04-30') or ((matricula.bool_ar=0)or(matricula.bool_ar isnull)))";
	$sql_alumnos = $sql_alumnos . "order by alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$rsAlumnos =@pg_Exec($conn,$sql_alumnos); */
	
//---------
//------------ PROFESOR  JEFE ---------------
$qry = "";
$qry = "SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM curso INNER JOIN (empleado INNER JOIN supervisa ON empleado.rut_emp = supervisa.rut_emp) ON curso.id_curso = supervisa.id_curso WHERE (((curso.id_curso)=" . $cmb_curso ."))";
$Rs_Profe =@pg_exec($conn,$qry);
$fila_Profe = @pg_fetch_array($Rs_Profe,0);
$Nombre_Profe = trim($fila_Profe['nombre_emp'])." ".trim($fila_Profe['ape_pat'])." ".trim($fila_Profe['ape_mat']);
//--------
//----------- DIRECTOR ----------------------
$qry="";
$qry = "SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=" . $institucion . ") and cargo=1)";
$Rs_Dir	= @pg_exec($conn,$qry);
$fila_Dir = @pg_fetch_array($Rs_Dir,0);
$Nombre_Dir = trim($fila_Dir['nombre_emp'])." ".trim($fila_Dir['ape_pat'])." ". trim($fila_Dir['ape_mat']);


//----------- RECTOR ----------------------
$qry="";
$qry = "SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=" . $institucion . ") and cargo=23)";
$Rs_Rec	= @pg_exec($conn,$qry);
$fila_Rec = @pg_fetch_array($Rs_Rec,0);
$Nombre_Rec = trim($fila_Rec['nombre_emp'])." ".trim($fila_Rec['ape_pat'])." ". trim($fila_Rec['ape_mat']);

function validar_dav ($alumno,$dig_rut){
	      
		 $alumno = $alumno;
		 $dig_rut = $dig_rut;
		 		  
		  
		 $largo_rut = strlen($alumno);
		 $multiplicador = 2;
		 $resultado = 0;
		 $largo=$largo_rut-1;
			 
		 for ($i=0; $i < $largo_rut; $i++){
			 $num = substr($alumno,$largo,1);
			 
			 if ($multiplicador > 7){
				 $multiplicador = 2;
			 }
			 $resultado = $resultado + ($multiplicador * $num);			 
			 $multiplicador++; 
			 $largo--;
				 
		 }
				 
		 $resto = 11-($resultado%11);		 
		 
		 if ($resto==10){
			 $dig = "K";
		 }else{
		     if ($resto==11){
			     $dig = 0;
			 }else{	 
		         $dig = $resto;
			 }	 
		 }	 
		 
		 if ($dig_rut=="k"){
		     $dig_rut="K";   
		 } 
		 
		 if ($dig==$dig_rut){
			  $ok=1;   
		 }else{
		      
			  $ok=0;
			  	  
		 }	
		 return $ok;
		       	 
	}

?>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<STYLE>
@media print{
    H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
}

 
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<div id="capa0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left"><font face="Arial, Helvetica, sans-serif" size="-1" color="#000066"><strong>ESTE INFORME DEBE IMPRIMIRSE EN HOJA TAMA&Ntilde;O OFICIO</strong></font>		</td>
        <td align="right"><div id="capa0">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
        </div></td>
		<? if($_PERFIL==0){?>
        <td align="right">&nbsp;</td>
      	<? }?>
	  </tr>
  </table>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">
		<?
		$result = @pg_Exec($conn,"select insignia, rdb from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

		  if($institucion!=""){
			   echo "<img src='../../../../../".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
		  }else{
			   echo "<img src='../../../../../".$d."menu/imag/logo.gif' >";
		  }?>
	  		</td>
		</tr>
    </table>
	</td>
  </tr>
  <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>

								  

<!-- INICIO CUERPO DE LA PAGINA -->

<table width="100%" border="0" cellspacing="0" cellpadding="0">

            <td width="120"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="1" face="arial, geneva, helvetica"><strong>:</strong></font></div></td>
        <td width="526"><font size="1" face="arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
            <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Profesor(a) 
              Jefe</strong></font></td>
        <td><font size="1" face="arial, geneva, helvetica"><strong>:</strong></font></td>
        <td><font size="1" face="arial, geneva, helvetica"><? echo $ob_reporte->profe_jefe;?></font></td>
      </tr>
    </table>
<div align="right">



<table width="100%"  border="1" cellspacing="0" cellpadding="0">
  <tr class="cuadro02">
          <td>&nbsp;</td>
          <td valign="top" class="cuadro02">NOMINA DE ALUMNOS </td>
          <td class="cuadro02" valign="top">RUN</td>
          <td class="cuadro02" valign="top" width="20">COD RUN </td>
          <td class="cuadro02" valign="top" width="27">SEXO</td>
          <td class="cuadro02" valign="top" width="40">FEC NAC </td>
          <td class="cuadro02" valign="top">COMUNA RESIDENCIA </td>
          <?
// nuevo2
		$sql_aprox = "SELECT truncado_per FROM curso WHERE id_curso=".$curso."";		  
		$rs_aprox = pg_Exec($conn,$sql_aprox);
		$fil_aprox = pg_fetch_array($rs_aprox,0);
		if($institucion==9566){
			$aprox = 0;
		}
		else{
			$aprox = $fil_aprox['truncado_per'];
		}
// fin nuevo2

	//$sql_subsectores = "select * from subsector_ramo where id_curso = ".$curso." and (bool_ip = 1 or cod_subsector = 13) order by id_orden";

	$sql_subsectores = "select * from ramo INNER JOIN subsector ON ramo.cod_subsector=subsector.cod_subsector where id_curso = ".$curso."  and (bool_ip = 1 or ramo.cod_subsector = 13) order by id_orden";
	$rsSubsectores=@pg_Exec($conn,$sql_subsectores);

	$cantidad_subsectores = @pg_numrows($rsSubsectores);
	for($e=0 ; $e < @pg_numrows($rsSubsectores) ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$sub_obli = $fSubsectores['sub_obli'];
//****VEL*** busca los subsectores formulas
		$sql_formula = "select * from formula where id_ramo = '$id_ramo'";
		$res_formula = pg_Exec($conn,$sql_formula);
	    if(pg_numrows($res_formula)!=0){
			$fila_formula = pg_fetch_array($res_formula);
			$id_formula = $fila_formula['id_formula'];
			$sql_form_hijo = "select * from formula_hijo where id_formula = '$id_formula'";
			$res_form_hijo = pg_Exec($conn,$sql_form_hijo);
			if(pg_numrows($res_form_hijo)!=0)
			{
				pg_numrows($res_form_hijo);
				for($f=0; $f<=pg_numrows($res_form_hijo); $f++)
				{
					$fila_hijo = pg_fetch_array($res_form_hijo);
					$arreglo_hijo[] = $fila_hijo['id_hijo'];				
				}			
			}
		}//***VEL***
	}
//*****SE repite la condicion pero ahora muestra solamente los padres de los subsectores formulas
	
	for($e=0 ; $e < @pg_numrows($rsSubsectores) ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$sub_obli = $fSubsectores['sub_obli'];	
		$largo = strlen($arreglo_hijo);
		$existe = 0;
		for($h=0;$h<=$largo;$h++)
		{
			$id_hijo = $arreglo_hijo[$h];
			if($arreglo_hijo[$h] == $id_ramo)
			{
				$existe = 1;				
			}
		}
		if($existe == 0){
			if($cod_subsector!=13){?>
          <td class="cuadro02" valign="top"><? echo $cod_subsector?></td>
          <? }
		 }
	}//***VEL***?>
          <td align="center" valign="top"><img src="../../reportes/promedio-general.gif" width="11" height="61"></td>
    <? 
	for($e=0 ; $e < @pg_numrows($rsSubsectores) ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$sub_obli = $fSubsectores['sub_obli'];
		$bool_asist = $fSubsectores['bool_asist'];
		
	
			if($cod_subsector==13){
				$religion=$id_ramo;	?>
          <td class="cuadro02" valign="top"><? echo $cod_subsector?></td>
          <? }}?>
    
	      <td align="center" valign="top"><img src="../../reportes/asistencia.gif"></td>
          <td align="center" valign="top"><img src="../../reportes/situacion-final.gif" width="11" height="59"></td>
          <td class="cuadro02" valign="top">OBSERVACIONES</td>
        </tr>
        <?
	///// consultar si la institucion es de viña del mar

/*	$sql_quinta = "SELECT region FROM institucion WHERE rdb=".$_INSTIT;
	$rs_quinta = @pg_exec($conn,$sql);
	$num_vina = pg_result($rs_quinta,0);*/
	
		
		
  	if (@pg_numrows($rsAlumnos)<30)
	  $espacio_lineas = 15;
  	if (@pg_numrows($rsAlumnos)>29)
	  $espacio_lineas = 5;
	  
	  $jj = 1;
	  
	for($i=0 ; $i < @pg_numrows($rsAlumnos) ; $i++)
	{
		$fAlumno = @pg_fetch_array($rsAlumnos,$i);
		$alumno = trim($fAlumno['rut_alumno']);
		
			
		$dig_rut = trim($fAlumno['dig_rut']);
				
		if ($cod_region==5 or $institucion==11209 or $institucion==2163 ){
		      /// no entra a validar rut
			  $ok = 1;
			  
		}else{
		      /// si entra a validar rut		
		
			$ok = validar_dav($alumno,$dig_rut);		
			if ($dig_rut==NULL){
				if ($_INSTIT==516){			
					 $ok = 1;
				}else{
					 $ok = 0;			
				}	 
			}	
			if ($dig_rut== " "){
				if ($_INSTIT==516){			
					 $ok = 1;
				}else{
					 $ok = 0;			
				}
			}
		}
		
		
		
		if ($ok==1){
				
		$curso = $fAlumno['id_curso'];
		$sql_promocion = "select promedio, asistencia, situacion_final, observacion from promocion where rut_alumno = ".$alumno." and id_curso = ".$curso;
		$rsPromocion=@pg_Exec($conn,$sql_promocion);
		$fPromocion = @pg_fetch_array($rsPromocion,0);	
		$promedio = $fPromocion['promedio'];
		if($_INSTIT==769 || $_INSTIT==1436){
			$promedio = substr($promedio,0,1).",".substr($promedio,1,1);
		}else{
			if($_INSTIT==9853 || $_INSTIT==5661){
				if (!empty($promedio)) $promedio = substr($promedio,0,1).",".substr($promedio,1,1); else $promedio = "&nbsp;";
			}else{
				if (!empty($promedio)) $promedio = substr($promedio,0,1).".".substr($promedio,1,1); else $promedio = "&nbsp;";
			}
		}
		if (!empty($fPromocion['asistencia'])) $asistencia = $fPromocion['asistencia']."%"; else $asistencia = "&nbsp;";
		$situacion_final = $fPromocion['situacion_final'];
		if ($situacion_final==1) $situacion_final = "P";
		if ($situacion_final==2) $situacion_final = "R";
		if ($situacion_final==3) $situacion_final = "Y";
		if (!empty($fPromocion['observacion'])) $observacion = $fPromocion['observacion']; else $observacion = "&nbsp;";
  ?>
        <tr class="cuadro01">
          <td height=<? echo $espacio_lineas?>><? echo $jj; ?></td>
          <td ><? echo trim($fAlumno['ape_pat']) . " " . trim($fAlumno['ape_mat'] ). " " . trim($fAlumno['nombre_alu']) ?></td>
          <td ><? echo $fAlumno['rut_alumno'] ?></td>
          <td ><? echo $fAlumno['dig_rut']."&nbsp;" ?></td>
          <td ><?  if($rd_genero==1){ 
		  				if ($fAlumno['sexo']==1){ echo "F"; }else{ echo "M";}
					}else{
						if ($fAlumno['sexo']==1){ echo "2"; }else{ echo "1";}
					} ?></td>
          <td ><? echo Cfecha2($fAlumno['fecha_nac']) ?></td>
          <td ><? echo $fAlumno['nom_com'] ?></td>
          <?
		  
		  $jj++;
		 // echo "<br> cantidad de subsectores ".$cantidad_subsectores;
	for($e=0 ; $e < $cantidad_subsectores ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$modo_eval = $fSubsectores['modo_eval']; 
		$conex = $fSubsectores['conex']; // 1 si 2 no
		$sql_eximido = "select count(*) as cantidad from tiene$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo." and id_curso = ".$curso;
		$rsEximido=@pg_Exec($conn,$sql_eximido);
		$fEximido= @pg_fetch_array($rsEximido,0);
		
//***VEL***		
		$largo = strlen($arreglo_hijo);
		$existe = 0;
		for($h=0;$h<=$largo;$h++)
		{
			$id_hijo = $arreglo_hijo[$h];
			if($arreglo_hijo[$h] == $id_ramo)
			{
				$existe = 1;				
			}
		}		
		
//***VEL***			
		
		
		if ($fEximido['cantidad']>0){
		
			$sql = "SELECT promedio FROM promedio_sub_alumno WHERE rdb=".$institucion." AND id_ano=".$ano." and id_curso = ".$curso." AND id_ramo = ".$id_ramo." and rut_alumno = ".$alumno;
			$rs_promedios = @pg_exec($conn,$sql);
			$promedio_nota = @pg_result($rs_promedios,0);
			$decima = substr($promedio_nota,0,1);
			$centecima = substr($promedio_nota,1,1);
			if($_INSTIT==769 || $_INSTIT==1436 || $_INSTIT==5661){
				$promedio_nota =$decima.",".$centecima;
			}
			//if($promedio_nota==0){
			if($modo_eval==1 and $promedio_nota==0){
				
				if (($_INSTIT==1579) or ($situacion_final == "Y") or ($_INSTIT==1653) or ($_INSTIT==24977) or ($_INSTIT==9239) or ($_INSTIT==1672) or ($_INSTIT==2090) or ($_INSTIT==1973) or ($_INSTIT==14860) or ($_INSTIT==12086) or ($_INSTIT==1515) or ($_INSTIT==287) or ($_INSTIT==1741 and $cod_subsector!=11)){
				     $promedio_nota="&nbsp;";
				}elseif($institucion==5661){
					$promedio_nota="---";				
				}else{
				     $promedio_nota="EX";
			    }
			}
		}else{
			if ($fSubsectores['sub_obli']==1){
			    if ($fSubsectores['bool_ip']==1){
				      if (($_INSTIT==1672 || $institucion==10232 || $institucion==317) or ($_INSTIT==2090) or ($situacion_final == "Y")){
					 	   $promedio_nota = "&nbsp;"; 
					  }elseif(($_INSTIT==26094) or ($situacion_final == "Y")){
					  		$promedio_nota = "--"; 					  
					  }else{	 
						   $promedio_nota = "EX";
					  }	   
					 
				}else{
				     $promedio_nota = "&nbsp;";
				}	 
			}else{
				if($institucion==1672 || $institucion==1914 || $institucion==12086 || $institucion==769){
					$promedio_nota = "-";
				}else{	
					$promedio_nota = "&nbsp;";
				}
			}	
		}
//***VEL*** Muestro solo si existe		
		 // if($existe == "0"){		
		 if($cod_subsector!=13){?>
                 <td align="center"><? if ($situacion_final <> "Y") echo $promedio_nota; elseif($_INSTIT==769 || $_INSTIT==1436 || $_INSTIT==5661) echo "---";  elseif ($institucion==10232) echo "&nbsp;"; else echo "&nbsp;"; ?></td>
          <? }
		  }
		 // }
		 
		 
		 ?>
          <td align="center"><? if ($situacion_final <> "Y") echo $promedio; elseif($_INSTIT==769 || $_INSTIT==1436 || $_INSTIT==5661) echo "---"; else echo "&nbsp;"; ?></td>
	     <?
		for($e=0 ; $e < $cantidad_subsectores ; $e++){
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$modo_eval = $fSubsectores['modo_eval']; 
		$conex = $fSubsectores['conex']; // 1 si 2 no
		$sql_eximido = "select count(*) as cantidad from tiene$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo." and id_curso = ".$curso;
		$rsEximido=@pg_Exec($conn,$sql_eximido);
		$fEximido= @pg_fetch_array($rsEximido,0);		
		if ($fEximido['cantidad']>0){
			$sql = "SELECT promedio FROM promedio_sub_alumno WHERE rdb=".$institucion." AND id_ano=".$ano." and id_curso = ".$curso." and id_ramo = ".$id_ramo." and rut_alumno = ".$alumno."";
			$rs_promedios = @pg_exec($conn,$sql);
			$promedio_nota = @pg_result($rs_promedios,0);
			
			
		}else{
			if ($fSubsectores['sub_obli']==1){
				if ($fSubsectores['bool_artis']==1){
				    $promedio_nota = "&nbsp;";
				}else{
				    $promedio_nota = "EX";
				}
			}else{
				$promedio_nota = "N/O"; // cambio solicitado por el coyancura
			}	
		}
		if($cod_subsector==13){ ?>
             <td align="center" >
			 <? if ($situacion_final <> "Y"){
 			 
			         if ($_INSTIT==9566){
					     if($promedio_nota > 0){ 					 
							 $promedio_nota = Conceptual($promedio_nota , 1);					 
							 echo $promedio_nota;
						 }else{
						     	 
						     echo  $promedio_nota;
						 }						
					 }else{	
						 /*if ($institucion==9239){
						    echo "N/O";
						 }else{*/
						      if (($institucion==1653 or $institucion==9239 or $institucion==12086) and (trim($promedio_nota)=="EX" or trim($promedio_nota)==0) or trim($promedio_nota)=="-"){
							       echo "N/O";
							  }else if($institucion==1756 and trim($promedio_nota)=="EX"){
									echo "&nbsp;";							  
							  }else{					     			     
					               echo $promedio_nota."&nbsp;";
							  }	   
						 //}	
						/* if($promedio_nota!=""){
						 	echo $promedio_nota;
						}else{
							echo "EX";
						} 	*/				 
					 }	 
			    }else{
					if($_INSTIT==769 || $_INSTIT==1436 || $_INSTIT==5661){
						 echo "---";
					}else{
						echo "&nbsp;";
					}
					
				}
			   ?></td>
   <? }} ?>
		  <td align="center">
		  <? if ($situacion_final <> "Y") echo $asistencia; elseif($_INSTIT==769 || $_INSTIT==1436 || $_INSTIT==5661) echo "---"; else echo " "; ?>&nbsp;</td>
          <td align="center"><? echo $situacion_final ?>&nbsp;</td>
          <td><? echo $observacion."&nbsp;"; ?></td>

        </tr>
        <? 
		
		}
		
		
		} ?>
    </table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="left">  <font face="Arial, Helvetica, sans-serif" size="-2">
	  C&oacute;digos :        Promovido= P       Reprobado =  R       Retirado =  Y					Masculino = 1   -   Femenino = 2 *******
	  Nota :   La asignatura de Religi&oacute;n no tiene incidencia en su promedio general de calificaciones ni en la situaci&oacute;n final del alumno.															
	  </font></td>
  </tr>
</table>	     
  </div>
  
<H1 class=SaltoDePagina>&nbsp;</H1>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"><p>
     <font face="Arial, Helvetica, sans-serif" size="-2">
    <strong>Si Este reporte no se despliega de manera correcta, puede deberse a el(los) siguientes(s) motivo(s) <br>
    </strong><br>
    <strong>- Datos del alumno:</strong> Verificar si en los datos de un alumno aparece comuna, nacionalidad, sexo. <br>
    <strong>- Rut del alumno:</strong> Verificar si el rut completo de un alumno es correcto. <br>
    <strong>- Generaci&oacute;n incorrecta de acta:</strong> Proceso de promoci&oacute;n se gener&oacute; de manera incompleta, sin esperar a que finalizara correctamente. Recuerde que 

la p&aacute;gina activa debe terminar de cargar completamente antes de seguir con el siguiente paso.<br>
- Aproximaci&oacute;n del promedio general se debe realizar desde el men&uacute; <b>Configuraci&oacute;n->Curso</b><br>

- Las bonificaciones de configuran en el men&uacute; <b>Libro de clases->Curso->Asignaturas->Configurar Asignatura</b><br>

- El promedio final de la asignatura se configura en el men&uacute;<b>Libro de clases->cursos->asignatura</b>
</font></p>
    </p></td>
  </tr>
</table> <br>
 
<table border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif; font-size:9px" align="left">
  <tr>
    <td colspan="6" align="center">Art&iacute;culos Promoci&oacute;n SIGE</td>
    </tr>
  <tr>
    <td>N&ordm;</td>
    <td>Situaciones Cursos</td>
    <td>Decreto 511/97<br>
      1&ordm;&nbsp;a&nbsp;8&ordm;&nbsp;b&aacute;sico</td>
    <td>Decreto 112/99<br>
1&ordm; y 2&ordm; medio.
</td>
    <td>Decreto 83/01<br>
      3&ordm;&nbsp;y&nbsp;4&ordm;&nbsp;HC</td>
    <td>Decreto<br>83/01<br>3&ordm; y 4&ordm; TP</td>
  </tr>
  <tr>
    <td>1</td>
    <td><p>Eximici&oacute;n de un Subsector</p></td>
    <td>Registro  interno
del EE. Número y fecha.

Decreto	158/ junio   de  1999. artículo único
</td>
    <td>Registro  interno
del EE. Número y fecha

Decreto	158/ junio   de  1999. artículo único
</td>
    <td>Registro interno
del EE. Número y fecha
</td>
    <td>Sólo	para
plan  general. (Registro
interno	del
EE.   Número y fecha).
Decreto
83/01 Art. 6

No	existe eximición
para
especialidad.
</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Promoción  con  %
menor	de asistencia.
(1º y 3º básico)
</td>
    <td>Decreto	107,
artículo 10 </td>
    <td align="center">-</td>
    <td align="center">-</td>
    <td align="center">-</td>
  </tr>
  <tr>
    <td>3</td>
    <td>Repitencia	por
rendimiento	(1º  y
3º básico)
</td>
    <td>Decreto	107,
artículo 10
;</td>
    <td align="center">-</td>
    <td align="center">-</td>
    <td align="center">-</td>
  </tr>
  <tr>
    <td>4</td>
    <td>Promoción  con  %
menor	de asistencia.
(2º  y  4º  hasta  8º
básico)
(1º a 4º medio)
</td>
    <td>Artículo  11,  Nº
2
</td>
    <td>Art. 8, Nº 2</td>
    <td>Art,5, letra C</td>
    <td>Art,5, letra C</td>
  </tr>
  <tr>
    <td>5</td>
    <td>Finalización
anticipada   de   año escolar
</td>
    <td>Artículo Nº 12</td>
    <td>Art. 4, INC ,8</td>
    <td>Art 12, letra I</td>
    <td>Art 12, letra I</td>
  </tr>
  <tr>
    <td>6</td>
    <td>Alumno retirado</td>
    <td>Fecha</td>
    <td>Fecha</td>
    <td>Fecha</td>
    <td>Fecha</td>
  </tr>
</table>
         
</div>  

</body>
</html>
<? pg_close($conn);?>