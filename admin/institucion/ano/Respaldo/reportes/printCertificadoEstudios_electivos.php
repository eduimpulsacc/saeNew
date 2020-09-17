<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno			=$c_alumno;  
	$POSP = 4;
	$_bot = 8;
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
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
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
	
	//--------------------------------
	// CURSO
	//--------------------------------
 	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion, curso.ensenanza, curso.cod_es,curso.truncado_per ";
	$sql_curso = $sql_curso . "FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
 	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";
	$result_curso =@pg_Exec($conn,$sql_curso);
	$num_consulta = @pg_numrows($result_curso);
	
	if ($num_consulta==0){
	      /// el plan es propio, hacer otra cosnulta
		  
		  $sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion, curso.ensenanza, curso.cod_es,curso.truncado_per ";
		  $sql_curso = $sql_curso . "FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN incluye_propio ON curso.cod_decreto = incluye_propio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
		  $sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";
		  $result_curso =@pg_Exec($conn,$sql_curso);
		  $num_consulta = @pg_numrows($result_curso);
	
	}else{
	
	    /// nada ya trae informacion
	}
	
	
	
	$fila_curso = @pg_fetch_array($result_curso,$cont_paginas);
	//$curso = $fila_curso['id_curso'];
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	$grado = $fila_curso['grado_curso'];
	$ensenanza = $fila_curso['ensenanza'];
	$ensenanza_pal = $fila_curso['nombre_tipo'];
	$nombre_decreto = $fila_curso['nombre_decreto'];
	$nombre_decreto_eval = $fila_curso['nombre_decreto_eval'];
	$rolbasededatos  = $fila_curso['rdb']." - ".$fila_curso['dig_rdb'];
	$nu_resolucion = $fila_curso['nu_resolucion'];
	$cod_es = $fila_curso['cod_es'];
	$truncado_per=$fila_curso['truncado_per'];
	//-------------------------
	if ($ensenanza>309 and $grado>2){
		$sql_espe = "select * from especialidad where cod_esp = $cod_es";
		$result_espe =@pg_Exec($conn,$sql_espe);
		$fila_espe = @pg_fetch_array($result_espe,0);	
		$especialidad = ", ".$fila_espe['nombre_esp'];
	}
	//--------------------------------
	//  ALUMNOS
	//--------------------------------
	if ($alumno==0){
		$sql_alu = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso ";
		$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
		$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	}else{
		$sql_alu = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso  ";
		$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."')) ";
		$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	}
	$result_alu =@pg_Exec($conn,$sql_alu);
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
				form.action = 'CertificadoEstudios.php?institucion=$institucion';
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
//-->
</script>

<script> 
function cerrar(){ 
window.close() 
} 
</script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <!-- INGRESO DEL CUERPO DE LA PAGINA -->
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
</style>

<?
if ($curso != 0){
  ?>
<center> 
	<div id="capa0">	
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr align="left">
	  <td width="1%"><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
        <td align="right" >
          <strong><font face="Verdana, Arial, Helvetica, sans-seri" size="-2" color="#000099">ESTE REPORTE SE IMPRIME EN HOJA TAMA&Ntilde;O OFICIO </font></strong>		</td>
        <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR"></td>
      </tr>
    </table>	
    </div>	
   <?
}
?>   


<?
$cont_alumnos = @pg_numrows($result_alu);
for($cont_paginas=0 ; $cont_paginas < $cont_alumnos  ; $cont_paginas++)
{
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'];
	$rut_alumno = $fila_alu['rut_alumno'] . " - " . strtoupper($fila_alu['dig_rut']);
	$nombre_alu = ucwords(strtoupper(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']))); 
	$curso = $fila_alu['id_curso'];
	
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<? if($institucion != 770){ ?>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="150" rowspan="5" align="left" valign="top">
	<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		$fecha_resolucion = $fila_foto['fecha_resolucion'];
		$ano_solo = substr($fecha_resolucion,0,4);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
		</td>
		<td width="198" rowspan="5" align="left" valign="top">		
			<div align="center">
				<font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>REP&Uacute;BLICA DE CHILE</strong></font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> MINISTERIO DE EDUCACI&Oacute;N</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> DIVISI&Oacute;N DE EDUCACI&Oacute;N </font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">SECRETARIA REGIONAL MINISTERIAL</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">DE EDUCACI&Oacute;N </font><BR>
		    </div></td>
 <td width="161" rowspan="5"><? //} ?>
   <?
		//$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		//$arr=@pg_fetch_array($result,0);
		//$fila_foto = @pg_fetch_array($result,0);
		//if 	(!empty($fila_foto['insignia']))
		//{
		//	$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
		//	$retrieve_result = @pg_exec($conn,$output);?></td>			
		<td width="90"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">REGIÓN</font></td>
		<td width="10"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td width="191"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $region?></strong></font></td>
	   

	  </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PROVINCIA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $provincia?></strong></font></td>
	    </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">COMUNA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $comuna?></strong></font></td>
	    </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">A&Ntilde;O ESCOLAR</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $nro_ano?></strong></font></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	</table>
<?  }else{ ?>
		<br><br><br><br><br><br>
<?  } ?> 
	<table width="650" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="4"><strong>CERTIFICADO ANUAL DE ESTUDIOS</strong></font></td>
      </tr>
      <tr >
        <td align="center">
		<?
		if ($institucion==770){ ?>
		     <font face="Verdana, Arial, Helvetica, sans-seri" size="2"><? echo $ensenanza_pal; ?></font>
	<?	}else{ ?>		
		     <font face="Verdana, Arial, Helvetica, sans-seri" size="3"><? echo $ensenanza_pal; ?></font>
			 
     <? } ?>
	    </td>
	  </tr>
    </table>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><strong><? if($institucion==770){ echo "AÑO ESCOLAR $nro_ano"; }else{ echo strtoupper($nombre_institu);} ?></strong></font><br><br></td>
	  </tr>	  
	  <tr>
	  <?
	  if($institucion==11203){ //Imprime Todo Seguido?>
		<td align="justify">
		      <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"> Reconocido oficialmente por el Ministerio de Educación de la República de Chile según decreto <br> <strong>N&ordm; 
		      <? echo $nu_resolucion ?> de  <?=$ano_solo ?></strong> Rol Base de Datos <strong>Nº <? echo $rolbasededatos?></strong> otorga el presente Certificado de Calificaciones  Anuales y Situación Final a 
			   DON(A) <u><strong><? echo $nombre_alu ?></strong></u> Run <strong><? echo $rut_alumno ?></strong> del <strong><? echo $Curso_pal . $especialidad ?></strong> de acuerdo al plan de estudios aprobados por el Decreto 
			   <strong>Nº <? echo $nombre_decreto?></strong> Reglamento de Evaluación y Promoción Escolar Decreto <strong>Nº <? echo $nombre_decreto_eval ?></strong>
		  </font></td>	  
<?	  }else{ //Imprime el nombre y el rut en una linea aparte
	  ?>
		<td align="justify">
		      <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"> Reconocido oficialmente por el Ministerio de Educación de la República de Chile según decreto <br> <strong>N&ordm; 
		      <? echo $nu_resolucion ?> de  <?=$ano_solo ?></strong> Rol Base de Datos <strong>Nº <? echo $rolbasededatos?></strong> otorga el presente Certificado de Calificaciones  Anuales y Situación Final a 
			   DON(A) <br><div align="center"><u><strong><? echo $nombre_alu ?></strong></u> Run <strong><? echo $rut_alumno ?></strong> </div> del <strong><? echo $Curso_pal . $especialidad ?></strong> de acuerdo al plan de estudios aprobados por el Decreto 
			   <strong>Nº <? echo $nombre_decreto?></strong> Reglamento de Evaluación y Promoción Escolar Decreto <strong>Nº <? echo $nombre_decreto_eval ?></strong>
		  </font></td>
	<? } ?>
	  </tr>
	</table>
	<br>
	<table width="650" border="1" cellspacing="0" cellpadding="0">
	  <tr>
		<td rowspan="2"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>SUBSECTOR, ASIGNATURA O M&Oacute;DULO </strong></font></td>
		<td colspan="2" align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>CALIFICACI&Oacute;N FINAL</strong></font></td>
		</tr>
	  <tr>
		<td width="55" align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>CIFRAS</strong></font></td>
		<td width="200"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>EN PALABRAS </strong></font></td>
	  </tr>
	  <?
	  //----------------------------------
	  // SUBSECTORES - RAMOS
	  //---------------------------------
	  $sql_ramo = "select * from (ramo inner join subsector on ramo.cod_subsector = subsector.cod_subsector) inner join tiene$nro_ano on ramo.id_ramo = tiene$nro_ano.id_ramo where tiene$nro_ano.id_curso = '$curso' and tiene$nro_ano.rut_alumno = '$alumno' ORDER BY ramo.id_orden ";

	  
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
		$cod_subsector  = $fila_ramo['cod_subsector']	;
		$aprox          = $fila_ramo['truncado']	;
		
		/// ver si este ramo pertecene a alguna formula con hijos
		$qry_formula = "select * from formula_hijo where id_hijo = '".trim($ramo)."'";
		$res_formula = @pg_Exec($conn,$qry_formula);
		$num_formula = @pg_numrows($res_formula);
		
	  if ($num_formula==0){
	  
	  if ($cod_subsector==22 and $_INSTIT==99999999999999) { echo "&nbsp;"; } else { 
			
	  ?>
	  <tr>
	    <td ><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> <? echo "  ".$nombre_ramo?></font></td>
	    <td align="center">
		<?
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
							
							
							
							
						    /// como es modo de evaluacion 3 debo convertir el promedio a conceptual
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
							
						    $prom = Conceptual($prom,2);						
							
							
							
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
			

				
				if ($modo_eval == 1  or $modo_eval == 0){
					$promedio_ramo = substr($promedio_ramo,0,1).".".substr($promedio_ramo,1,1);
					
				}else{
				     $promedio_ramo = Conceptual($promedio_ramo , 1);						
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
			     
				 $promedio_ramo = Conceptual ($promedio_ramo , 1);
			 }else{
			      // el promedio ya es conceptual por lo tanto no lo mando a ninguna parte
			 }	  	 		
		     ?>		     
			 <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? echo $promedio_ramo;?></font> </td>
	         <td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? Palabras($promedio_ramo, 2)?></font></td>
             </tr>
		     
			 <?			
		}else{	
		       if($modo_eval==3){
			      
					if ($promedio_ramo > 0 and $promedio_ramo < 40){
							$promedio_ramo = "I";
					}
					if ($promedio_ramo > 39 and $promedio_ramo < 50){
						$promedio_ramo = "S";
					}
					if ($promedio_ramo > 49 and $promedio_ramo < 60){
						$promedio_ramo = "B";
					}
					if ($promedio_ramo > 59 ){
						$promedio_ramo = "MB";
					}						
				   
			  }	
		
		
		     ?>
             <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? echo $promedio_ramo;?></font> </td>
	         <td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? Palabras($promedio_ramo, $modo_eval)?></font></td>
             </tr>
	 <? } 
	  }
	  
	    } ?>
	  
	  
	  
  	  <? } ?>
	  <tr>
	    <td ><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PROMEDIO GENERAL </font></td>
	    <td align="center">
		<?
		$sql_final = "select promedio, asistencia, situacion_final, observacion from promocion where promocion.rut_alumno = '".trim($alumno)."'";
		$sql_final = $sql_final . "and promocion.id_ano = $ano ";
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
		}
		?>
        <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? echo $promedio_final ;?></font> </td>
	    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">
	      <? Palabras($promedio_final, 1)?>
	    </font></td>
	    </tr>
	  <tr>
		<td ><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PORCENTAJE DE ASISTENCIA </font></td>
		<td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? echo $asistencia ;?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr >
		    <td height="28" colspan="3"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>EN 
              CONSECUENCIA: </strong> 
              <?
			    if (($ensenanza==560) and ($grado==1)) {  
				$grado=$grado+1; 
				} 

			$situacion_pal = "EL ALUMNO(A) HA SIDO PROMOVIDO A ".($grado+1)."º AÑO DE ".strtoupper($ensenanza_pal);
		
			if ($grado == 8)
				$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO DE LA ".strtoupper($ensenanza_pal);

			if ($grado==4 and $ensenanza>309)
	            $situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO DE LA ".strtoupper($ensenanza_pal);
			
		if  ($ensenanza==361){
			if ($grado == 1)
				$situacion_pal = "EL ALUMNO(A) HA SIDO PROMOVIDO A SEGUNDO CICLO DE ".strtoupper($ensenanza_pal);
			if ($grado == 2)
				$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO DE LA ".strtoupper($ensenanza_pal);
		}
		
		if  ($ensenanza==110 and $grado == 8){
				$situacion_pal = "EL ALUMNO(A) HA SIDO PROMOVIDO A PRIMERO DE ENSEÑANZA MEDIA";
		}		
		
		if ($situacion_final==1)
				echo $situacion_pal;
			if ($situacion_final==2)
				echo "EL ALUMNO(A) HA SIDO REPROBADO";
			if ($situacion_final==3)
				echo "EL ALUMNO(A) FUE RETIRADO";
		?>
              </font></td>
		</tr>
	</table>
	<? if ($_INSTIT!=8905 or $_INSTIT!=24988){ ?><br><? }?>
	<table width="650" height="114" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td height="22"><div align="left"><font size="2"><font face="Verdana, Arial, Helvetica, sans-seri">Observaciones:</font></font>&nbsp;&nbsp;<? if($observacion!=""){?><font size="-1"><?=$observacion?></font><? }?></div></td>
	  </tr>
	  <tr>
		<td height="22"><div align="left"><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font></div></td>
		</tr>
	  <tr>
		<td height="23"><div align="left"><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font></div></td>
		</tr>
				  <tr>
		<td height="23"><div align="left"><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font></div></td>
		</tr>
	</table>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	<? for($lineas=0; $lineas < (14-$cont_ramos); $lineas++){?>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
      </tr>
	<? }?> 
	  <tr>
<!--	    <td>&nbsp;</td>		-->
	    <td>&nbsp;</td>
	    </tr>
	  <tr> 
		<td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="2">________________________________</font></strong></div></td>
		<td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="2">________________________________</font></strong></div></td>
	  </tr>
	  <tr> 
		<td><div align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">Profesor(a) Jefe </font></div></td>
		<td><div align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><?=$cargo_dir2 ?> Establecimiento</font></div></td>
	  </tr>
	  <tr> 
		<?
		$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
		$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
		$result =@pg_Exec($conn,$sql4);
		$fila = @pg_fetch_array($result,0);	
		$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
		$profe_jefe = ucwords(strtoupper(trim($fila['nombre_emp']) . " " . trim($fila['ape_pat']) . " " . trim($fila['ape_mat'])));
		?>
		<td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">
			<? if($institucion==770){
					echo $profe_jefe;
				}else{
			 		echo $nombre_profe; 
				}?>
			</font></strong></div></td>
		<td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> 
		<?
		$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
		if ($institucion !=2278){$sql = $sql . "WHERE (((trabaja.rdb)=".$institucion.") AND ((trabaja.cargo)=1 OR trabaja.cargo=23)); ";}
		if ($institucion ==2278){$sql = $sql . "WHERE (((trabaja.rdb)=".$institucion.") AND ((trabaja.cargo)=1)); ";}
		$result =@pg_Exec($conn,$sql);
		$fila = @pg_fetch_array($result,0);	
		if($institucion==770){
			echo ucwords(strtoupper(trim($fila['nombre_emp']) . " " . trim($fila['ape_pat']) . " " . trim($fila['ape_mat'])));
		}else{
			echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
		}
	?>
			</font></strong></div></td>
	  </tr>
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
		<tr>
		    <td><? //$fecha=date("d-m-Y");?>
			<font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><? echo ucwords(strtolower($comuna)).", ". $dia." de ".$mes." del ".$ano2; /*fecha_espanol($fecha)*/ ?></font>
			
			</td>
		  <td>&nbsp;</td>
		  </tr>
		<tr>
		    <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
	</table>
	</td>
  </tr>
</table>

<? if  (($cont_alumnos - $cont_paginas)<>1) 
	echo "<H1 class=SaltoDePagina></H1>";

} ?>
</center>
</body>
</html>
<?
function Palabras($prom, $modo)
{
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
	
		$palabra_completa = $palabra[0]." ".$palabra[1]." ".$palabra[2];
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
	if($prom=="NO")
		$palabra_completa="NO OPTA";
	if ($prom=="EX")
		$palabra_completa = "EXIMIDO DEL SUBSECTOR";
	if (chop($palabra_completa)=="")
		$palabra_completa = "&nbsp;";
		
	echo  $palabra_completa;
}
?>

<!-- FIN DE CUERPO DE LA PAGINA -->					 
</body>
</html>
<? pg_close($conn);?>