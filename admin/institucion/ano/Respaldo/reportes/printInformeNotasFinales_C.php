<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?
require('../../../../util/header.inc'); 
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	= $_INSTIT;
    $ano			= $_ANO;
	$curso			= $cmb_curso;
	$alumno 		= $cmb_alumno;
	$reporte		= $c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/****************DATOS PERIODO************/
	$ob_reporte ->ano=$ano;
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
	
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************** CURSO ***********************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	//--------------------------------------------------------------------------
	// DATOS CURSO //
	//--------------------------------------------------------------------------	
	$ob_reporte ->curso=$curso;
	$ob_reporte ->Curso($conn);
	$truncado_per = $ob_reporte->truncado;
	
	//----------------------------------------------------------------------------
	// DATOS ALUMNO
	//----------------------------------------------------------------------------	
	if ($alumno == 0){
		$ob_reporte->curso = $curso;
		$ob_reporte->ano=$ano;
		$result_alumno = $ob_reporte->TraeTodosAlumnos($conn);
	}else{
		$ob_reporte->ano=$ano;
		$ob_reporte->curso=$curso;
		$ob_reporte->alumno=$alumno;
		$result_alumno = $ob_reporte->TraeUnAlumno($conn);
	}

	$sql_promedio = "select max(promedio) as max_prom from promocion where id_curso = ".$curso;
	$result_promedio =@pg_Exec($conn,$sql_promedio);
	$fila_promedio = @pg_fetch_array($result_promedio,0);
	$promedio_final_mejor = 	$fila_promedio['max_prom'];

	$sql_promedio = "select promedio from promocion where id_curso = ".$curso;
	$result_promedio =@pg_Exec($conn,$sql_promedio);
	$promedio_final = 0; $cont_final = 0;
	for($g=0 ; $g < @pg_numrows($result_promedio) ; $g++)
	{
		$fila_promedio = @pg_fetch_array($result_promedio,$g);	
		if ($fila_promedio['promedio']>0)
		{
			$promedio_final = $promedio_final + $fila_promedio['promedio'];		
			$cont_final = $cont_final + 1;
		}
	}		
	if ($cont_final>0)
	$promedio_final_curso = round($promedio_final/$cont_final,0);
	
	
	

  	//----------------------------------------------------------------------------
	// DATOS PERIODO
	//----------------------------------------------------------------------------
	if ($_INSTIT==14629 ){
	    $sql_periodo = "select * from periodo where id_ano = ".$ano . " order by id_periodo Desc";
	}else{	
	    $sql_periodo = "select * from periodo where id_ano = ".$ano . " order by id_periodo";
	}
	
	$result_periodo = @pg_Exec($conn, $sql_periodo);
	$cadena = "";
	$habiles = 0;
	$cantidad_periodos =  @pg_numrows($result_periodo);
	for($e=0 ; $e < @pg_numrows($result_periodo) ; $e++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$e);
		if ($fila_periodo['dias_habiles']>0)
			$habiles = $habiles + $fila_periodo['dias_habiles'];
		if (trim($cadena)=="")
			$cadena = $fila_periodo['id_periodo'];
		else
			$cadena = $cadena . ";" . $fila_periodo['id_periodo'];
		
	}
	$periodo=explode(";",$cadena);
	
	$ob_reporte->curso=$curso;
	$ob_reporte->SubsectorRamo($conn);
	$result_subsector = $ob_reporte->result;

	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	
	
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
	
	////////////// FIN  /////////////////////////

if($cb_ok!="Buscar"){
 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Informe_notas_finales_$fecha_actual.xls"); 	 
}	
	
  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformeNotasFinales.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
			
	function exportar(){
		   	//form.target="_blank";
			window.location='printInformeNotasFinales_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
			//form.submit(true);
			return false;
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
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->
<?
if ($curso == 0){
  ## nada
}else{
 
  ?>
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="capa0">
		<table width="100%">
		  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   
		  value="CERRAR">
          
		  </td>
		<td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" 
		value="EXPORTAR">
			<? }?>
		  </td></tr></table>
        
      </div>
    </td>
  </tr>
</table>
<?
	$cantidad_alumnos = @pg_numrows($result_alumno);
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++)
	{
		$fila_alumno = @pg_fetch_array($result_alumno,$i);
		$alumno = $fila_alumno['rut_alumno'];
		$nombre_alumno = ucwords(strtoupper($fila_alumno['ape_pat'] . " " . $fila_alumno['ape_mat'] . " 
		" . $fila_alumno['nombre_alu']));

?>

<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br>";
	   
  }else{

	?>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487" class="item"><strong><? echo strtoupper(trim($ob_membrete->ins_pal));?></strong></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">

      <table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top" >
          <td width="125" align="center">
		  	<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>		  </td>
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="item">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<? } ?>

<table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr>
    	<td class="tableindex"><div align="center">INFORME DE NOTAS FINALES</div></td>
	</tr>
  <?
  if ($_INSTIT==1260){ ?>
	  <tr>
		<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Rol base de datos: 1260-2"; ?></strong></font></div></td>
	  </tr>
	  <tr>
		<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Resolución Exenta: 2244 del año 1986"; ?></strong></font></div></td>
	  </tr>
<? } ?> 	
	
  <tr>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Decreto Evaluación Nº : ".$ob_reporte->NombreDecretoEval?></strong></font></div></td>
  </tr>
  <tr>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Planes y Programas Nº : ".$ob_reporte->NombreDecreto?></strong></font></div></td>
  </tr>
  <tr>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Correspondiente al Año Lectivo : ".$nro_ano?></strong></font></div></td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="91" class="item"><div align="left"><strong>CURSO</strong></div></td>
    <td width="8"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td width="543"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $Curso_pal?></font></div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>ALUMNO</strong></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nombre_alumno?></font></div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>PROFESOR JEFE</strong></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ob_reporte->profe_jefe?></font></div></td>
  </tr>
</table>
<br>
<?
	if ($cantidad_periodos==3)
	{
?>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="307" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ASIGNATURA O SUBSECTOR DE APRENDIZAJE</strong></font></div></td>
    <td colspan="3"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIOS</strong></font></div></td>
    <td width="62" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO ANUAL</strong></font></div></td>
    <?
	if ($_INSTIT==14703){ ?>
	    <td width="62" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>70%</strong></font></div></td>
  <? } ?> 
	<td width="54" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>EXAMEN</strong></font></div></td>
   <?
	if ($_INSTIT==14703){ ?>	
	    <td width="54" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>30%</strong></font></div></td>
   <? } ?>
    <td width="73" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CALIFICACIÓN FINAL</strong></font></div></td>
  </tr>
  
  <tr>
    <td width="46"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>1º Trim</strong></font></div></td>
    <td width="46"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>2º Trim</strong></font></div></td>
    <td width="46"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>3º Trim</strong></font></div></td>
  </tr>
  <?
  	
	$prom_gene_periodos = 0;
	for($f=0 ; $f < @pg_numrows($result_subsector) ; $f++)
	{
		$fila_subsector = @pg_fetch_array($result_subsector,$f);
		$id_ramo = $fila_subsector['id_ramo'];
		$nom_subsector = $fila_subsector['nombre'];
		$modo_eval = $fila_subsector['modo_eval'];
		$cod_subsector = $fila_subsector['cod_subsector'];
		$conex = $fila_subsector['conex'];
		$nota_exim = $fila_subsector['nota_exim'];
		$sw=0;

  ?>	
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? if((trim($nom_subsector)=="RELIGION") && ($institucion==9566)){ echo $nom_subsector."(optativo)"; }else{ echo $nom_subsector;  }?></font></div></td>

	<?
	//---------
	//---------
	$prom_gene_periodos = 0; $contador_pro=0;
	for($procom=0 ; $procom < 3 ; $procom++)
	{?>    
	<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
	<?
	
		$sw = 0; 
		$sumo_nota = 0;
		$cuento_nota = 0;
		$ob_reporte ->ramo = $id_ramo;
		$ob_reporte ->nro_ano=$nro_ano;
		$ob_reporte ->periodo = $periodo[$procom];
		$ob_reporte ->rut_alumno = $fila_alumno['rut_alumno'];
		$result_notas =$ob_reporte ->Notas($conn);
		$fila_notas = @pg_fetch_array($result_notas,0);
		$promedio = $fila_notas['promedio'];		
			if ($modo_eval==1)
					{		
						if ($promedio>0){
							if ($promedio<40){
							    							
								     ?><font color="#FF0000"><? echo $promedio;?> </font><?
									 $prom_gene_periodos = $prom_gene_periodos + $promedio;
							         $contador_pro = $contador_pro + 1;
							}else{
							         echo $promedio;
									 $prom_gene_periodos = $prom_gene_periodos + $promedio;
							         $contador_pro = $contador_pro + 1;
							}
						}
						else{
							echo "---";
							$sw = 1;
						}
					}else{
					    
						if (empty($promedio) or chop($promedio)=="0"){
							echo "---";
							$sw = 1;
						}
						else{	
						    
							     echo $promedio;
							     								 
								 ///////////// nuevo codigo RELIGION SAN VIATOR    /////////////
								 if ($modo_eval==3 and $institucion==769){
								     /// nuevo proceso, que aunque el promedio es conceptual, para sacar el final se debe calcular en base a numérico
									 /// promediar el periodo
									 for ($ii=1; $ii < 21; ++$ii){
									     $nota = $fila_notas['nota'.$ii];
										 if ($nota > 0){
										     $sumo_nota = $sumo_nota + $nota;
											 $cuento_nota = $cuento_nota + 1;
										 }	 
									 }
									 /// promedio
									 $promedio = round($sumo_nota/$cuento_nota);															 									 								  
								 
								 }else{
								     $promedio = Conceptual($promedio,2);								     
								 
								 }
								 //////////// fin nuevo código   ////////////////
								 	
								 $prom_gene_periodos = $prom_gene_periodos + $promedio;			
							     $contador_pro = $contador_pro + 1; 
																	
						}
					}
?>
</font></div></td>
<?
	}
	if ($conex==1){
		$sql_promedio = "select * from situacion_final where rut_alumno = '".$alumno."' and id_ramo = ".$id_ramo;
		$result_promedio =@pg_Exec($conn,$sql_promedio);
		$fila_promedio = @pg_fetch_array($result_promedio,0);
		$prom_gral = $fila_promedio['prom_gral'];
		$nota_examen = $fila_promedio['nota_examen'];		
		if ($prom_gral == $nota_exim or $prom_gral > $nota_exim ) $nota_examen = "---";
		$nota_final = $fila_promedio['nota_final'];	
	} else {
		$nota_examen = "---";
		if ($prom_gene_periodos>0)
			$prom_gral = Promediar($prom_gene_periodos,$contador_pro,$truncado_per);
		
				
		$prom_gene_periodos = 0;			
		$nota_final = $prom_gral;
		
	}
	if ($modo_eval==2){
		$prom_gral = Conceptual($prom_gral,1);
		$nota_final = $prom_gral ;
	}
	if ($sw==1){
		$nota_examen = "---";
		$prom_gral = "---";
		$nota_final = "---";
	}
	?>
			<? //VEL Deja la nota de religion en forma de Concepto, (solo para colegio 770)
			if($modo_eval==3){ ?>
				<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
					<? 
										   					
					   if(!empty($prom_gral)){
									if ($prom_gral >= 60 and $prom_gral<=70)
										$concepto = "MB";						
									if ($prom_gral >= 50 and $prom_gral<=59)						
										$concepto = "B";						
									if ($prom_gral >= 40 and $prom_gral<=49)						
										$concepto = "S";					
									if ($prom_gral >= 0 and $prom_gral<=39)					
										$concepto = "I";
							echo $concepto;
					   }else{ 
					   		echo "---";
						}?>
					 </font></div>
				</td>
			<? }else{ ?>
				<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if (!empty($prom_gral)) echo $prom_gral; else echo "---";?></font></div></td>			
			<? } ?>
    <? if ($_INSTIT==14703){ ?>
			
				<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? 
				   if (!empty($prom_gral)){
					   $promedio_porcentaje = @round($prom_gral * 70 / 100);
				   }		  
				   if ((!empty($promedio_porcentaje)) and ($conex==1)) echo $promedio_porcentaje; else echo "---";?></font></div></td>
	<? } ?>	
   
<?			if($modo_eval==3 or $modo_eval==2 ){ ?>
			<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
					<? if ($nota_examen>0){
									if ($nota_examen >= 60 and $nota_examen<=70)
										$concepto = "MB";						
									if ($nota_examen >= 50 and $nota_examen<=59)						
										$concepto = "B";						
									if ($nota_examen >= 40 and $nota_examen<=49)						
										$concepto = "S";					
									if ($nota_examen >= 0 and $nota_examen<=39)					
										$concepto = "I";
							echo $concepto;
					   }else{ 
					   		echo "---";
						}?>
					 </font></div>
	  </td>
			<? }else{ ?>
			<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
			            <? if ($nota_examen>0){
						        echo $nota_examen;
								
								 
						  }else{
						        echo "---";
						  }?></font></div></td>
			<? } ?>			  
    
	<?  if ($_INSTIT==14703){ ?>
		           <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><?
				   if (!empty($nota_examen)){
				        $examen_porcentaje= @round($nota_examen*30/100);
				   }			   
				   if (($examen_porcentaje>0) and ($conex==1)) echo $examen_porcentaje; else echo "---";?></font></div></td>
		   <? } ?>	
	
<?			if($modo_eval==3){ ?>
				<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"> 
					<? if (!empty($nota_final)){
									if ($nota_final >= 60 and $nota_final<=70)
										$concepto = "MB";						
									if ($nota_final >= 50 and $nota_final<=59)						
										$concepto = "B";						
									if ($nota_final >= 40 and $nota_final<=49)						
										$concepto = "S";					
									if ($nota_final >= 0 and $nota_final<=39)					
										$concepto = "I";
							echo $concepto;
					   }else{ 
					   		echo "---";
						}?>
					 </font></div> 
				</td>
			<? }else{ ?>
				<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
				       <? if (!empty($nota_final)){
					          					   
					          echo $nota_final;
							  
					           
						  }else{
						       echo "---";
						  }
					   ?></font></div></td>
			<? } ?>		
  </tr>
  <? } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	 <?  if ($_INSTIT==14703){ ?>	
	    <td>&nbsp;</td>
		<td>&nbsp;</td>
   <? } ?>	
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?
	$sql_promedio = "select promedio, asistencia, observacion from promocion where rut_alumno = '".$alumno. "' and id_curso = ".$curso;
	$result_promedio =@pg_Exec($conn,$sql_promedio);
	$fila_promedio = @pg_fetch_array($result_promedio,0);
	$promedio_final_alumno = 	$fila_promedio['promedio'];
	$asistencia_real = $fila_promedio['asistencia'];
	$observacion = $fila_promedio['observacion'];
	if ($_INSTIT==14703){
	    $colspan=7;
	}else{
	    $colspan=5;
	}
	?>
  <tr>
    <td width="307"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO FINAL DEL ALUMNO</strong></font></div></td>
    <td colspan="<?=$colspan ?>">&nbsp;</td>
    <td width="73"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($promedio_final_alumno>0) echo $promedio_final_alumno; else echo "---";?></font></div></td>			
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>MEJOR PROMEDIO DEL CURSO</strong></font></div></td>
    <td colspan="<?=$colspan ?>">&nbsp;</td>
	
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
        <? if ($promedio_final_mejor>0) echo $promedio_final_mejor; else echo "---";?>
    </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO GENERAL DEL CURSO</strong></font></div></td>
    <td colspan="<?=$colspan ?>">&nbsp;</td>
	
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
        <? if ($promedio_final_curso>0) echo $promedio_final_curso; else echo "---";?>
    </font></div></td>	
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="<?=$colspan ?>">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 <? if ($_INSTIT!=770){ ?> <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TOT. DIAS/HORAS POR TRABAJAR (Anual)</strong></font></div></td>
    <td colspan="<?=$colspan ?>">&nbsp;</td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
        <? echo $habiles;?>
    </font></div></td>
  </tr>
  <? } ?>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TOTAL INASISTENCIAS (Anual)</strong></font></div></td>
    <td colspan="<?=$colspan ?>">&nbsp;</td>
	<?
	$sql_asistencia = "select count(*) as cantidad from asistencia where rut_alumno = '".$alumno."' and ano = ".$ano." ";
	$result_asistencia =@pg_Exec($conn,$sql_asistencia);
	$fila_asistencia = @pg_fetch_array($result_asistencia,0);
	$inasistencia = $fila_asistencia['cantidad'];

	$sql_justifica = "select count(*) as justificado from justifica_inasistencia where rut_alumno = '$alumno' and ano = '$ano'";
	$res_justifica = @pg_Exec($conn,$sql_justifica);
	$fila_justifica = @pg_fetch_array($res_justifica,0);
	$justificado = $fila_justifica['justificado'];
	$inasistencia;
	$justificado;
	$tot_inasistencia = $inasistencia - $justificado;		
	?>
    <td>
	  <div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
	    <? echo $tot_inasistencia;?>
      </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TOTAL ASISTENCIAS (%) (Anual)</strong></font></div></td>
    <td colspan="<?=$colspan ?>">&nbsp;</td>
	<?
	if ($inasistencia>0)
		$porcentaje = 100-round($tot_inasistencia * 100/$habiles,2)."%";
	else
		$porcentaje = "100%";
	?>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">&nbsp;<? echo $asistencia_real;?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nº DE ATRASOS (Anual)</strong></font></div></td>
    <td colspan="<?=$colspan ?>">&nbsp;</td>
	<?
	$suma = 0;
	$sql_atraso = "select count(fecha) as nro_atraso from anotacion where anotacion.tipo = 2 and anotacion.rut_alumno = '".$alumno . "' and fecha like '%$nro_ano-%'";
	$result_atraso =@pg_Exec($conn,$sql_atraso);
	$fila_suma = @pg_fetch_array($result_atraso,0);
	
	$suma = $fila_suma['nro_atraso'];
		
	?>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $suma;?></font></div></td>
  </tr>
</table>
 <?  } 
	if ($cantidad_periodos==2)
	{?>
 <table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="307" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ASIGNATURA O SUBSECTOR DE APRENDIZAJE</strong></font></div></td>
    <td colspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIOS</strong></font></div></td>
    <td width="62" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO ANUAL</strong></font></div></td>
    <td width="54" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>EXAMEN</strong></font></div></td>
    <td width="73" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CALIFICACIÓN FINAL</strong></font></div></td>
    </tr>
  <tr>
    <td width="71"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>1º Sem </strong></font></div></td>
    <td width="69"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>2º Sem </strong></font></div>      
    <div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"></font></div></td>
    </tr>
  <?
  	for($f=0 ; $f < @pg_numrows($result_subsector) ; $f++)
	{
		$fila_subsector = @pg_fetch_array($result_subsector,$f);
		$id_ramo = $fila_subsector['id_ramo'];
		$nom_subsector = $fila_subsector['nombre'];
		$modo_eval = $fila_subsector['modo_eval'];
		$cod_subsector = $fila_subsector['cod_subsector'];
		$conex = $fila_subsector['conex'];
		$nota_exim = $fila_subsector['nota_exim'];
		$sw = 0;
		
		
		
		/// ver si este ramo pertecene a alguna formula con hijos
		$qry_formula = "select * from formula_hijo where id_hijo = '".trim($id_ramo)."'";
		$res_formula = @pg_Exec($conn,$qry_formula);
		$num_formula = @pg_numrows($res_formula);
		
		if ($num_formula==0){
			  ?>	
			  <tr>
				<td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? if((trim($nom_subsector)=="RELIGION") && ($institucion==9566)){ echo $nom_subsector."(optativo)"; }else{ echo $nom_subsector;  };?></font></div></td>
			   <?
				//---------
				$prom_gene_periodos = 0; $contador_pro=0;	
				//---------
				for($procom=0 ; $procom < 2 ; $procom++)
				{?>    
				<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
				
				<?
				
					$sw = 0	;
					$ob_reporte ->nro_ano=$nro_ano;
					$ob_reporte ->rut_alumno = $alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->periodo = $periodo[$procom];
					$result_notas =$ob_reporte ->Notas($conn);
					$fila_notas = @pg_fetch_array($result_notas,0);
					$nota1 = $fila_notas['nota1'];
					$nota2 = $fila_notas['nota2'];
					$nota3 = $fila_notas['nota3'];
					$nota4 = $fila_notas['nota4'];
					$nota5 = $fila_notas['nota5'];
					$nota6 = $fila_notas['nota6'];
					$nota7 = $fila_notas['nota7'];
					$nota8 = $fila_notas['nota8'];
					$nota9 = $fila_notas['nota9'];
					$nota10 = $fila_notas['nota10'];
					$nota11 = $fila_notas['nota11'];
					$nota12 = $fila_notas['nota12'];
					$nota13 = $fila_notas['nota13'];
					$nota14 = $fila_notas['nota14'];
					$nota15 = $fila_notas['nota15'];
					$nota16 = $fila_notas['nota16'];
					$nota17 = $fila_notas['nota17'];
					$nota18 = $fila_notas['nota18'];
					$nota19 = $fila_notas['nota19'];
					$nota20 = $fila_notas['nota20'];
					$prom_ponderacion=0;
					$promedio 	= $fila_notas['promedio'];	
						$sql = "SELECT pos21 FROM nota_porcentaje2009 WHERE id_periodo=".$periodo[$procom]." AND id_ramo=".$id_ramo."";
						$resp = pg_exec($conn,$sql);
						$pos21 = pg_result($resp,0);
								
					if($tipo_eval=="0"){
						if ($modo_eval==1)
							{		
								if ($promedio>0){
									if($promedio<40){
										?><font color="#FF0000"><? 
											 if ($cod_subsector==13){								
												 $promedio = Conceptual($promedio, 1);					 
												 echo $promedio;
											 }else{	
												 echo $promedio;
											 } 
										
											  ?> </font>	<?
									}else{
										 if ($cod_subsector==13){								
											$promedio = Conceptual($promedio, 1);					 
											 echo $promedio;
										 }else{	
											 echo $promedio;
										 } 
									
										
									}
									$prom_gene_periodos = $prom_gene_periodos + $promedio;
									$contador_pro = $contador_pro + 1;					
								}
								else{
									echo "---";
									$sw = 1;
								}
							}
							else
							{
							
							 if ($modo_eval==3){
								  echo $promedio;
								  
								  ///////////// nuevo codigo RELIGION  /////////////
								  if ($institucion==2999 or $institucion==1260){
									 /// nuevo proceso, que aunque el promedio es conceptual, para sacar el final se debe calcular en base a numérico
									 /// promediar el periodo
									 for ($ii=1; $ii < 21; ++$ii){
										 $nota = $fila_notas['nota'.$ii];
										 if ($nota > 0){
											 $sumo_nota = $sumo_nota + $nota;
											 $cuento_nota = $cuento_nota + 1;
										 }	 
									 }
									 /// promedio
									 $promedio = round($sumo_nota/$cuento_nota);
									 /// limpio variables
									 $sumo_nota = 0;
									 $cuento_nota = 0;					 
								  }else{
									 $promedio = Conceptual($promedio,2);								     
								 
								  }
								  //////////// fin nuevo código   ////////////////
													   
								  $prom_gene_periodos = $prom_gene_periodos + $promedio;			
								  $contador_pro = $contador_pro + 1;
							   
							 }else{
									if (empty($promedio) or chop($promedio)=="0"){
										echo "---";
										$sw = 1;
									}else{
										echo $promedio;
										$promedio = Conceptual($promedio,2);																
										$prom_gene_periodos = $prom_gene_periodos + $promedio;			
										$contador_pro = $contador_pro + 1;										
									}
							  }	
						   }
					}else{
						if(!$pos21=="100"){
							if ($modo_eval==1)
								{		
									if ($promedio>0){
										if($promedio<40){
											?><font color="#FF0000"><? 
												 if ($cod_subsector==13){								
													 $promedio = Conceptual($promedio, 1);					 
													 echo $promedio;
												 }else{	
													 echo $promedio;
												 } 
											
												  ?> </font>	<?
										}else{
											 if ($cod_subsector==13){								
												$promedio = Conceptual($promedio, 1);					 
												 echo $promedio;
											 }else{	
												 echo $promedio;
											 } 
										
											
										}
										$prom_gene_periodos = $prom_gene_periodos + $promedio;
										$contador_pro = $contador_pro + 1;					
									}
									else{
										echo "---";
										$sw = 1;
									}
								}
								else
								{
								
								 if ($modo_eval==3){
									  echo $promedio;
									  
									  ///////////// nuevo codigo RELIGION  /////////////
									  if ($institucion==2999 or $institucion==1260){
										 /// nuevo proceso, que aunque el promedio es conceptual, para sacar el final se debe calcular en base a numérico
										 /// promediar el periodo
										 for ($ii=1; $ii < 21; ++$ii){
											 $nota = $fila_notas['nota'.$ii];
											 if ($nota > 0){
												 $sumo_nota = $sumo_nota + $nota;
												 $cuento_nota = $cuento_nota + 1;
											 }	 
										 }
										 /// promedio
										 $promedio = round($sumo_nota/$cuento_nota);
										 /// limpio variables
										 $sumo_nota = 0;
										 $cuento_nota = 0;					 
									  }else{
										 $promedio = Conceptual($promedio,2);								     
									 
									  }
									  //////////// fin nuevo código   ////////////////
														   
									  $prom_gene_periodos = $prom_gene_periodos + $promedio;			
									  $contador_pro = $contador_pro + 1;
								   
								 }else{
										if (empty($promedio) or chop($promedio)=="0"){
											echo "---";
											$sw = 1;
										}else{
											echo $promedio;
											$promedio = Conceptual($promedio,2);																
											$prom_gene_periodos = $prom_gene_periodos + $promedio;			
											$contador_pro = $contador_pro + 1;										
										}
								  }	
							   }
						}else{
							for($notas=1;$notas<21;$notas++){
								${"prom_ponderado".${"id_periodo".$id_ramo}} = $prom_pondera = porcentaje($periodo[$procom],$id_ramo,'pos'.$notas,${"nota".$notas},$conn);
								$prom_ponderacion = $prom_ponderacion + $prom_pondera;	
							}
							echo $prom_ponderacion;
							$promedio_f = $promedio_f + $prom_ponderacion;
						}
					}
			?>
			</font></div></td>
			<?
			}
				if ($conex==1){
					$ob_reporte ->alumno=$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$result_promedio = $ob_reporte ->SituacionFinal($conn);
					$fila_promedio = @pg_fetch_array($result_promedio,0);
					$prom_gral = $fila_promedio['prom_gral'];
					$nota_examen = $fila_promedio['nota_examen'];
					if ($prom_gral == $nota_exim or $prom_gral > $nota_exim ) $nota_examen = "---";
					$nota_final = $fila_promedio['nota_final'];	
				} else {
					$nota_examen = "---";
					if ($prom_gene_periodos>0){
						$prom_gral = Promediar($prom_gene_periodos,$contador_pro,$truncado_per);
						if ($_INSTIT==9827 and $prom_gral==39){
						    $prom_gral = 40;						   
						}
					}	
					$prom_gene_periodos = 0;
					$nota_final = $prom_gral;
					
				}
				if ($modo_eval==2){
					$prom_gral = Conceptual($prom_gral,1);
					$nota_final = $prom_gral ;
				}
				if ($sw==1){
					$nota_examen = "---";
					$prom_gral = "---";
					$nota_final = "---";
				}
				?>
				<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
				  <?
				  	if(!$pos21=="100"){
						   if (!empty($prom_gral)){
								 
									// if ($cod_subsector==13 and $modo_eval!=2){
									if($modo_eval==3){
										 $prom_gral = Conceptual($prom_gral, 1);					 
										 echo $prom_gral;
									 }else{
										 echo $prom_gral;
									 }	 
										 
								
								
							 }else{
								 echo "---";
							 } 
					}else{
						echo $prom_gral = ($promedio_f / 2);
					}?>
				</font></div></td>
				<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><?
				      if ($nota_examen>0){
					       
						       //if ($cod_subsector==13){							
							   if($modo_eval==3){
							       $nota_examen = Conceptual($nota_examen, 1);					 
			                       echo $nota_examen;
							   }else{
							       echo $nota_examen;
							   }	   
						   
					       
					  }else{
					       echo "---";
					  }
					  
					  ?></font></div></td>
				<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
				  <? 
				      
					  
					  if($final!=1){
						  if (!empty($nota_final)){
								
								   // if ($cod_subsector==13 and $modo_eval!=2){								
								   if($modo_eval==3){
										$nota_final = Conceptual($nota_final, 1);					 
										echo $nota_final;
									}else{
									if($_INSTIT==9276 & $nota_final=="---" & $id_ramo==118643){
										echo "EX";
										}else{
										echo $nota_final;
										}								
									}	
								
								
						  }else{
								echo "---";
						  }
					  }else{
					  	$ob_reporte ->ano = $ano;
						$ob_reporte ->curso = $curso;
						$ob_reporte ->ramo = $id_ramo;
						$ob_reporte ->alumno = $alumno;
						$rs_promedio = $ob_reporte->PromedioSubAlumno($conn);
						$prom_gral_alum = @pg_result($rs_promedio,0);
						if($prom_gral_alum!=""){
						if($_INSTIT==9276 & $prom_gral_alum==0 & $id_ramo==118643){
							echo "EX";
							}else{
							echo $prom_gral_alum;
							}
						}else{
							echo "---";
						}
					  }
					  ?>
				</font></div></td>
			  </tr>
	  <? } ?>		  
  <? } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="307"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO FINAL DEL ALUMNO</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
	<?
	$ob_reporte ->ano =$ano;
	$ob_reporte ->institucion =$institucion;
	$ob_reporte ->alumno=$alumno;
	$ob_reporte ->curso =$curso;
	$result_promedio =$ob_reporte ->Promocion($conn);
	$fila_promedio = @pg_fetch_array($result_promedio,0);
	$promedio_final_alumno = 	$fila_promedio['promedio'];
	$asistencia_real = $fila_promedio['asistencia'];
	$observacion = $fila_promedio['observacion'];
	?>
    <td width="73"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($promedio_final_alumno>0) echo $promedio_final_alumno; else echo "---";?></font></div></td>			
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>MEJOR PROMEDIO DEL CURSO</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
	
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
        <? if ($promedio_final_mejor>0) echo $promedio_final_mejor; else echo "---";?>
    </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO GENERAL DEL CURSO</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
	<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
        <? if ($promedio_final_curso>0) echo $promedio_final_curso; else echo "---";?>
    </font></div></td>	
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <? if ($_INSTIT!=770){?><tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TOT. DIAS/HORAS POR TRABAJAR (Anual)</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
        <? echo $habiles;?>
    </font></div></td>
  </tr>
  <? } ?>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TOTAL INASISTENCIAS (Anual)</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
	<?
		$ob_reporte ->ano =$ano;
		$ob_reporte ->alumno=$alumno;
		$result_asistencia =$ob_reporte ->Asistencia($conn);
		$inasistencia = @pg_numrows($result_asistencia);
		
		$ob_reporte ->ano =$ano;
		$ob_reporte ->alumno=$alumno;
		$res_justifica = $ob_reporte->JustificaAsistencia($conn);
		$justificado = @pg_numrows($res_justifica);
		$tot_inasistencia = $inasistencia - $justificado;			
	?>
    <td>
	  <div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
	    <? echo $tot_inasistencia;?>
      </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TOTAL ASISTENCIAS (%) (Anual)</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
	<?
	if ($inasistencia>0)
		$porcentaje = 100-round($tot_inasistencia * 100/$habiles,2)."%";
	else
		$porcentaje = "100%";
	?>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $asistencia_real;?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nº DE ATRASOS (Anual)</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
	<?
	$sql_atraso = "select fecha from anotacion where anotacion.tipo = 2 and anotacion.rut_alumno = '".$alumno . "'";
	$result_atraso =@pg_Exec($conn,$sql_atraso);
	$suma = 0;
	for($g=0 ; $g < @pg_numrows($result_atraso) ; $g++)
	{
		$fila_atraso = @pg_fetch_array($result_atraso,$g);
		//$atraso = strftime("%Y",$fila_atraso['fecha']);
		$atraso = substr($fila_atraso['fecha'],0,4);
		if (trim($atraso)==trim($nro_ano))
			$suma = $suma + 1;
	}		
	?>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $suma;?></font></div></td>
  </tr>
</table>
	
<? }?>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>OBSERVACIONES:&nbsp;&nbsp;<? if($observacion!=""){?><?=$observacion?><? }?></strong></font></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>___________________________________________________________________________________________________________</strong></font></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>___________________________________________________________________________________________________________</strong></font></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>___________________________________________________________________________________________________________</strong></font></div></td>
  </tr>
</table>
<?
if ($_INSTIT==1260){
    $sql_final = "select promedio, asistencia, situacion_final, observacion from promocion where promocion.rut_alumno = '".trim($alumno)."'";
	$sql_final = $sql_final . "and promocion.id_ano = $ano ";
	$result_final = @pg_Exec($conn,$sql_final);
	$fila_final = @pg_fetch_array($result_final,0);
	if ($fila_final['promedio']>0){
		$situacion_final = $fila_final['situacion_final'];
	}
	
	$grado_palabra = $grado + 1;
	
	if ($grado_palabra=="1"){
		$grado_palabra = "PRIMER";
	}
	if ($grado_palabra=="2"){
		$grado_palabra = "SEGUNDO";
	}
	if ($grado_palabra=="3"){
		$grado_palabra = "TERCER";
	}
	if ($grado_palabra=="4"){
		$grado_palabra = "CUARTO";
	}
	if ($grado_palabra=="5"){
		$grado_palabra = "QUINTO";
	}
	if ($grado_palabra=="6"){
		$grado_palabra = "SEXTO";
	}
	if ($grado_palabra=="7"){
		$grado_palabra = "SEPTIMO";
	}
	if ($grado_palabra=="8"){
		$grado_palabra = "OCTAVO";
	}
	
	$situacion_pal = "ES PROMOVIDO(A) A ".$grado_palabra." AÑO DE  ".strtoupper($ensenanza_pal);

    if  ($ensenanza==110 and $grado == 8){
	    $situacion_pal = "ES PROMOVIDO(A) A PRIMER AÑO DE ENSEÑANZA MEDIA";
	}
	
	if  ($ensenanza==310 and $grado == 4){
	    $situacion_pal = "EGRESA DE ".strtoupper($ensenanza_pal);
	}
    ?>
    <br>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>SITUACI&Oacute;N FINAL:&nbsp;&nbsp;
		<?
		if ($situacion_final==1)
			echo $situacion_pal;
			  if ($situacion_final==2)
				   echo "REPITE CURSO";
				   if ($situacion_final==3)
						 echo "RETIRADO DEL CURSO";		
		
		?>
		</strong></font></div></td>
	  </tr>
	</table>
<? } ?>
<br>
<br>
<table width="650" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    			<td width="25%" class="item" height="100"><div align="center">________________________________
				<br>       
				  <?=$ob_reporte->nombre_emp;?>
				  <br>
				  <?=$ob_reporte->nombre_cargo;?>
				</div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"> <div align="center">________________________________
       <br>
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><div align="center">________________________________
        <br>
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"> <div align="center">________________________________
       <br>
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>


 <? 
// echo $cantidad_alumnos." CANTIDAD ".$i." INDICE __ RESTA:".($cantidad_alumnos - $i);
 if  (($cantidad_alumnos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	
	
} 

?>
 <table width="650" border="0" align="center">
   <tr>
     <td><div align="left" class="item"><? 
	 setlocale(LC_TIME,"spanish");
	 $hoy=strftime("%A %d de %B de %Y");
	 echo ucwords($hoy); 
	 ?></div></td>
   </tr>
 </table>
</center>
  <?
}
?>  
<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>