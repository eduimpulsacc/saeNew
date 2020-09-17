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
<?
require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');


	setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno			=$c_alumno;  
	$_POSP = 5;
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
	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion ";
	$sql_curso = $sql_curso . "FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,$cont_paginas);
	$curso = $fila_curso['id_curso'];
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	$ensenanza_pal = $fila_curso['nombre_tipo'];
	$nombre_decreto = $fila_curso['nombre_decreto'];
	$nombre_decreto_eval = $fila_curso['nombre_decreto_eval'];
	$rolbasededatos  = $fila_curso['rdb']." - ".$fila_curso['dig_rdb'];
	$nu_resolucion = $fila_curso['nu_resolucion'];
	//--------------------------------
	//  ALUMNOS
	//--------------------------------
	if ($alumno==0){
		$sql_alu = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso ";
		$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
		$sql_alu = $sql_alu . "ORDER BY alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat; ";
	}else{
		$sql_alu = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso  ";
		$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."')) ";
		$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	}
	$result_alu =@pg_Exec($conn,$sql_alu);
	//-------------------------------- 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../estilos.css" rel="stylesheet" type="text/css">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
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
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <!-- INICIO CODIGO CUERPO DE LA PAGINA -->
 
 <STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
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
<table>
    <tr>
	  <td align="left"><input name="button4" type="button" class="botonX" onClick="cerrar()"  onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="CERRAR">
	  </td>
	</tr>
  </table>

<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<div id="capa0">	
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr align="left">
        <td >

          <strong><font face="Arial, Helvetica, sans-serif" size="-1" color="#000099">ESTE REPORTE SE IMPRIME EN HOJA TAMA&Ntilde;O OFICIO </font></strong>
</td>
        <td align="right"><input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR"></td>
      </tr>
    </table>	
    </div>	
	<table width="650" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="349" rowspan="2" align="center"><font face="Arial, Helvetica, sans-serif" size="4"><strong>CERTIFICADO ANUAL DE ESTUDIOS</strong></font></td>
		<td width="108"><font face="Arial, Helvetica, sans-serif" size="-1">REGIÓN</font></td>
		<td width="10"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
		<td width="183"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $region?></strong></font></td>
	  </tr>
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1">PROVINCIA</font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $provincia?></strong></font></td>
	  </tr>
	  <tr>
		<td rowspan="2" align="center" valign="top"><font face="Arial, Helvetica, sans-serif" size="3"><? echo $ensenanza_pal; ?></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1">COMUNA</font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $comuna?></strong></font></td>
	  </tr>
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1">ANO ESCOLAR</font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $nro_ano?></strong></font></td>
	  </tr>
	</table>
	<br>
	<br>
	<table width="650" border="1" cellspacing="0" cellpadding="1">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo strtoupper($nombre_institu); ?></strong></font></td>
	  </tr>
	  <tr>
		<td align="justify">
		      <font face="Arial, Helvetica, sans-serif" size="-1"> RECONOCIDO OFICIALMENTE POR EL MINISTERIO DE EDUCACI&Oacute;N DE LA REP&Uacute;BLICA DE CHILE SEG&Uacute;N DECRETO <u>N&ordm; 
		      <? echo $nu_resolucion ?></u> ROL BASE DE DATOS <u>Nº <? echo $rolbasededatos?></u> OTORGA EL PRESENTE CERTIFICADO DE CALIFICACIONES ANUALES Y SITUACI&Oacute;N FINAL
		  A <u>DON(A) <? echo $nombre_alu ?> </u> RUN <u><? echo $rut_alumno ?></u> DEL <u><? echo $Curso_pal ?></u> DE ACUERDO AL PLAN DE ESTUDIOS APROBADOS POR EL DECRETO 
		  <u>Nº <? echo $nombre_decreto?></u> REGLAMENTO DE EVALUACIÓN Y PROMOCIÓN ESCOLAR DECRETO <u>Nº <? echo $nombre_decreto_eval ?></u>
		  </font></td>
	  </tr>
	</table>
	<br>
	<br>
	<table width="650" border="1" cellspacing="0" cellpadding="0">
	  <tr>
		<td rowspan="2"><font face="Arial, Helvetica, sans-serif" size="2"><strong>SUBSECTOR, ASIGNATURA O M&Oacute;DULO </strong></font></td>
		<td colspan="2" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><strong>CALIFICACI&Oacute;N FINAL</strong></font></td>
		</tr>
	  <tr>
		<td width="55" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><strong>CIFRAS</strong></font></td>
		<td width="200"><font face="Arial, Helvetica, sans-serif" size="2"><strong>EN PALABRAS </strong></font></td>
	  </tr>
	  <?
	  //----------------------------------
	  // SUBSECTORES - RAMOS
	  //---------------------------------
	  $sql_ramo = "SELECT ramo.id_ramo, subsector.nombre, ramo.conex, ramo.modo_eval ";
	  $sql_ramo = $sql_ramo . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector, tiene$nro_ano ";
	  $sql_ramo = $sql_ramo . "WHERE (((ramo.id_curso)=".$curso.") and tiene$nro_ano.rut_alumno = ".$alumno." and tiene$nro_ano.id_ramo = ramo.id_ramo) ";
      $sql_ramo = $sql_ramo . "ORDER BY ramo.id_orden;";
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
	  ?>
	  <tr>
	    <td ><font face="Arial, Helvetica, sans-serif" size="2"> <? echo "  ".$nombre_ramo?></font></td>
	    <td align="center">
		<?
		if ($examen == 2){ // Ramo sin examen (consulta en tabla notas)
			$sql_notas = "select promedio from notas$nro_ano ";
			$sql_notas = $sql_notas . "where rut_alumno = '".$alumno."' and id_ramo = ".$ramo;
		    $result_notas = @pg_Exec($conn,$sql_notas);
			$promedio_ramo = 0; $contador = 0;
		    for($con_nota=0 ; $con_nota< @pg_numrows($result_notas); $con_nota++)
		    {
				$fila_notas = @pg_fetch_array($result_notas,$con_nota);	
				$promedio = trim($fila_notas['promedio']);
				if ($modo_eval == 1 and $promedio>0){
					$promedio_ramo = $promedio_ramo + $promedio;
					$contador = $contador  + 1;
				}else if ($modo_eval == 2 and chop($promedio)<>"0"){
					$promedio = Conceptual($promedio, 2);
					$promedio_ramo = $promedio_ramo + $promedio;
					$contador = $contador  + 1;					
				}

			}
			if ($promedio_ramo>0)
			{
				$promedio_ramo = round($promedio_ramo / $contador);
				if ($modo_eval == 1 ){
					$promedio_ramo = substr($promedio_ramo,0,1).".".substr($promedio_ramo,1,1);
				}else{
					$promedio_ramo = Conceptual($promedio_ramo , 1);
				}
			}else{
				$promedio_ramo = "&nbsp;";
			}
		}else{ // Ramo con examen (consulta en tabla situacion_final)
			$sql_notas = "select situacion_final.nota_final as promedio from situacion_final where situacion_final.id_ramo = ".$ramo." ";
			$sql_notas = $sql_notas . "and situacion_final.rut_alumno = '".$alumno."'";
		    $result_notas = @pg_Exec($conn,$sql_notas);
			$promedio_ramo = 0; $contador = 0;
			$fila_notas = @pg_fetch_array($result_notas,0);
			$promedio_ramo = $fila_notas['promedio'];
			if ($promedio_ramo>0)
			{
				if ($modo_eval == 1 ){
					$promedio_ramo = substr($promedio_ramo,0,1).".".substr($promedio_ramo,1,1);
				}else{
					$promedio_ramo = Conceptual($promedio_ramo , 1);
				}
			}else{
				$promedio_ramo = "&nbsp;";
			}			
		}
		?>
        <font face="Arial, Helvetica, sans-serif" size="-1"><? echo $promedio_ramo;?></font> </td>
	    <td><font face="Arial, Helvetica, sans-serif" size="2"><? Palabras($promedio_ramo, $modo_eval)?></font></td>
      </tr>
  	  <? } ?>
	  <tr>
	    <td ><font face="Arial, Helvetica, sans-serif" size="-1">PROMEDIO GENERAL </font></td>
	    <td align="center">
		<?
		$sql_final = "select promedio, asistencia, situacion_final from promocion where promocion.rut_alumno = ".$alumno;
		$sql_final = $sql_final . "and promocion.id_ano = $ano ";
		$result_final = @pg_Exec($conn,$sql_final);
		$fila_final = @pg_fetch_array($result_final,0);
		if ($fila_final['promedio']>0){
			$promedio_final = substr($fila_final['promedio'],0,1).".".substr($fila_final['promedio'],1,1);
			$asistencia = $fila_final['asistencia']."%";
			$situacion_final = $fila_final['situacion_final'];
		}else{
			$promedio_final = "&nbsp;";
			$asistencia = "&nbsp;";
		}
		?>
        <font face="Arial, Helvetica, sans-serif" size="-1"><? echo $promedio_final ;?></font> </td>
	    <td><font face="Arial, Helvetica, sans-serif" size="2">
	      <? Palabras($promedio_final, 1)?>
	    </font></td>
	    </tr>
	  <tr>
		<td ><font face="Arial, Helvetica, sans-serif" size="-1">PROMEDIO ASISTENCIA </font></td>
		<td align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $asistencia ;?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr >
		<td height="41" colspan="3"><font face="Arial, Helvetica, sans-serif" size="2"><strong>SITUACI&Oacute;N FINAL: </strong>
		<?
			if ($situacion_final==1)
				echo "EL ALUMNO(A) HA SIDO PROMOVIDO";
			if ($situacion_final==2)
				echo "EL ALUMNO(A) HA SIDO REPROVADO";
			if ($situacion_final==3)
				echo "EL ALUMNO(A) FUE RETIRADO";								
		?>
		</font></td>
		</tr>
	</table>
	<br>
	<br>
	<table width="650" height="119" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td height="27"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:______________________________________________________________________________</font></strong></font></div></td>
	  </tr>
	  <tr>
		<td height="22"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
		</tr>
	  <tr>
		<td height="23"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
		</tr>
				  <tr>
		<td height="23"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
		</tr>
	  <tr>
		<td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
		</tr>
	</table>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	<? for($lineas=0; $lineas < (20-$cont_ramos); $lineas++){?>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
      </tr>
	<? }?> 
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr> 
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr> 
		<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
		<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
	  </tr>
	  <tr> 
		<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Profesor(a) 
			Jefe </font></div></td>
		<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Director(a) 
                Establecimiento </font></div></td>
	  </tr>
		<tr>
		<?
		$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
		$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
		$result =@pg_Exec($conn,$sql4);
		$fila = @pg_fetch_array($result,0);	
		$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
		?>
		<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2"><? echo $nombre_profe; ?> 
			</font></strong></div></td>
		<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">MEZA GOTOR MARCELO 
		<?
/*		$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
		$sql = $sql . "WHERE (((trabaja.rdb)=".$institucion.") AND ((trabaja.cargo)=1)); ";
		$result =@pg_Exec($conn,$sql);
		$fila = @pg_fetch_array($result,0);	
		echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
*/	?>
			</font></strong></div></td>
	  </tr>
	</table>
	</td>
  </tr>
</table>
<? if  (($cont_alumnos - $cont_paginas)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

} ?>
</center>
</body>
</html>
<?
function Palabras($prom, $modo)
{
	if ($modo == 1){
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
				$palabra_completa = "MUY BIEN";
				break;
			case "B":
				$palabra_completa = "BIEN";
				break;
			case "S":
				$palabra_completa = "SUFICIENTE";
				break;
			case "I":
				$palabra_completa = "INSUFICIENTE";												
				break;
		}
	}
	if (empty($palabra_completa))
		$palabra_completa = "&nbsp;";
		
	echo  $palabra_completa;
}
?>

<!-- FIN CUERPO DE LA PAGINA -->
