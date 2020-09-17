<?
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

function imprime_arreglo($arreglo){
echo "<pre>";
print_r($arreglo);
echo "</pre>";
}
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $cmb_curso;
	$reporte		= $c_reporte;
	$fin_ano		= $check_ano;
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
	$ob_reporte ->promocion=1;
	$ob_reporte ->SubsectorRamo($conn);
	$result_sub = $ob_reporte ->result;
	$num_subsectores = @pg_numrows($result_sub);
	
	
	/******* ALUMNOS ************************/
	$ob_reporte ->ano =$ano;
	$ob_reporte ->curso = $curso;
	$ob_reporte ->orden = $opcion;
	$ob_reporte ->retirado=0;
	$result_alu = $ob_reporte ->FichaAlumnoTodos($conn);
	

  
    if (($curso != 0) or ($curso != NULL)){	
	    $query_curso="select * from curso where id_curso='$curso'";
	    $row_curso=pg_fetch_array(pg_exec($conn,$query_curso));
		
	}
	
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Notas_Finales_$Fecha.xls"); 
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
function exportar(){
			//form.target="_blank";
		window.location='printInformePlanillaNotasFinales_C.php?cmb_curso=<?=$curso?>&check_ano=<?=$fin_ano?>&c_reporte=<?=$c_reporte?>&opcion=<?=$opcion?>';
			//document.form.submit(true);
		return false;
}
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

if (empty($curso)){
     //exit;
}else{
   ?>	 
   
   <table>
    <tr>
	  <td align="left">&nbsp;</td>
	</tr>
  </table>

<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr align="right">
        <td>
		<div id="capa0">
		<TABLE width="100%"><TR><TD><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></TD><TD  align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </TD>
		 
		    <TD  align="right"><input name="button32" type="button" class="botonXX" onClick="javascript:exportar()"  value="EXPORTAR"></TD>
		
		</TR></TABLE>
        </div>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	
	
	
	
	
<? if ($institucion=="770"){ 

	   echo "<br><br><br><br><br><br><br><br><br><br><br>";
	   
  }else{

	?>	
<table width="650" border="0" cellspacing="0" cellpadding="0">
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
			  if($institucion==24783){
					  echo "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
					 }else{
					  echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
					 }
		  }else{
			   echo "<img src='".$d."menu/imag/logo.gif' >";
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

<? } ?>



<table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr>
    	<td class="tableindex"><div align="center">PLANILLA DE NOTAS FINALES</div></td>
	</tr>
	<tr>
		<td><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>AÑO <? echo $nro_ano?></strong> </font></div></td>
	</tr>
</table>
<br>
	<table width="650" border="0" cellspacing="0" cellpadding="0">

            <td width="120"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="1" face="arial, geneva, helvetica"><strong>:</strong></font></div></td>
        <td width="526"><font size="1" face="arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
            <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Profesor(a) 
              Jefe</strong></font></td>
        <td><font size="1" face="arial, geneva, helvetica"><strong>:</strong></font></td>
        <td><font size="1" face="arial, geneva, helvetica"><? echo $ob_reporte->tildeM($ob_reporte->profe_jefe);?></font></td>
      </tr>
    </table>
	<br>	<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="2" width="20" class="tablatit2-1">Nº</td>
	<td width="30%" rowspan="2" class="tablatit2-1">NOMBRE DEL ALUMNO</td>
    <td colspan="100" class="tablatit2-1"><div align="center">SUBSECTORES</div></td>
	</tr>
  <tr>
    <?	 
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$cod_subsector = $fila_sub['cod_subsector'];
		$modo_eval = $fila_sub['modo_eval'];
		$examen = $fila_sub['conex']; // 1 SI 2 NO
		if($modo_eval==1) $contador_promedio++;
    ?>	
    <td colspan="3" ><div align="center"><font size="1" face="verdana, arial, geneva, helvetica"><strong>
    <? InicialesSubsector($subsector_curso) ?>
</strong></font></div></td>
	<? }?>
            <td width="15" align="center" ><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Final</strong></font></td>
    </tr>
    <?	 
	$numero_alumnos = @pg_numrows($result_alu);	 
	for($i=0 ; $i < @pg_numrows($result_alu) ;$i++)
	{
	  $fila_alu = @pg_fetch_array($result_alu,$i);
	  $nombre_alu = ucwords(strtolower(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu'])));
	  $rut_alumno = $fila_alu['rut_alumno'];
	  ?>	
  <tr>
    <td align="center"><font size="0" face="arial, geneva, helvetica"><? echo $i+1; ?></font></td>
    <td width="30%"><font size="0" face="arial, geneva, helvetica"><? echo $ob_reporte->tilde(substr($nombre_alu,0,25)); ?></font></td>
	<?	 
	$$promedio_promo_alumno = 0;
	$nota_menor = 0;
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$modo_eval = $fila_sub['modo_eval'];
		$cod_subsector = $fila_sub['cod_subsector'];
		$examen = $fila_sub['conex']; // 1 SI 2 NO
		$obliga = $fila_sub['sub_obli'];


	if($fin_ano==1){
	
		if($examen==1){
		
			$prom_gral = NULL;
			$nota_examen = NULL;
			$nota_final = NULL;
			
			$sql_sit_final = "SELECT prom_gral,nota_examen,nota_final FROM situacion_final WHERE id_ramo=".$id_ramo." AND rut_alumno=".$rut_alumno;
			$res_sit_final = @pg_exec($conn,$sql_sit_final);
			$sit_final = pg_fetch_array($res_sit_final,0);
			$prom_gral = $sit_final['prom_gral'];
			$nota_examen = $sit_final['nota_examen'];
			$nota_final = $sit_final['nota_final'];
			
		}else{
			
			$prom_gral = NULL;
			$nota_examen = NULL;
			$nota_final = NULL;
			
			$sql_prom = "SELECT promedio FROM promedio_sub_alumno WHERE id_ramo=".$id_ramo." AND id_curso=".$curso." AND rut_alumno=".$rut_alumno;
			$res_prom = @pg_exec($conn,$sql_prom);
			$prom_gral = pg_result($res_prom,0);
			$nota_final = $prom_gral;
			
		}
		
		
	}else{
	
		if($examen==1){
		
			$prom_gral = NULL;
			$nota_examen = NULL;
			$nota_final = NULL;
			
			$sql_sit_final = "SELECT prom_gral,nota_examen,nota_final FROM situacion_final WHERE id_ramo=".$id_ramo." AND rut_alumno=".$rut_alumno;
			$res_sit_final = @pg_exec($conn,$sql_sit_final);
			$sit_final = pg_fetch_array($res_sit_final,0);
			$prom_gral = $sit_final['prom_gral'];
			$nota_examen = $sit_final['nota_examen'];
			$nota_final = $sit_final['nota_final'];

			
		}else{
			
			$prom_gral = NULL;
			$nota_examen = NULL;
			$nota_final = NULL;
			
			if($cod_subsector!=13){
			$sql_prom = "SELECT AVG(CAST(promedio as INT)) FROM notas$nro_ano WHERE id_ramo=".$id_ramo." AND rut_alumno=".$rut_alumno;
			$res_prom = @pg_exec($conn,$sql_prom);
			$prom_gral = pg_result($res_prom,0);
			if($row_curso['truncado_final']==1){
				$prom_gral = round($prom_gral,0);
				$nota_final = $prom_gral;
			}else{
				$prom_gral = intval($prom_gral);
				$nota_final = $prom_gral;		
			}

			
			}else{
			
			$sql_prom = "SELECT promedio as INT FROM notas$nro_ano WHERE id_ramo=".$id_ramo." AND rut_alumno=".$rut_alumno;
			$res_prom = @pg_exec($conn,$sql_prom);
			$prom_gral = pg_result($res_prom,0);
			$nota_final = $prom_gral;

			
			}
			
		}
	
	
	
	
	}
	?>	
    <td width="15" align="center"><font size="0" face="arial, geneva, helvetica"><? if($prom_gral!=NULL){ echo $prom_gral;}else{ echo "-";}?></font></td>
	<td width="15" align="center"><font size="0" face="arial, geneva, helvetica"><? if($nota_examen!=NULL){ echo $nota_examen;}else{ echo "-";}?></font></td>
	<td width="15" align="center"><font size="0" face="arial, geneva, helvetica"><? if($nota_final!=NULL){ echo $nota_final;}else{ echo "-";}?></font></td>
	<? 
	
	//////////////////// EN CONSTRUCCION /////////////////////////////
	
	$promedio_alumno = $promedio_alumno+$nota_final;
	if($cont==8){
		echo $prom = $promedio_alumno/($num_subsectores-1);
		$promedio_alumno = 0;
	} 
	
	////////////////////////////////////////////////////////////////
	
	$sql_promocion = "SELECT promedio FROM promocion WHERE id_curso=".$curso." AND rut_alumno=".$rut_alumno." AND id_ano=".$ano;
	$res_promocion = @pg_exec($conn,$sql_promocion);
	$promedio_promo_alumno = pg_result($res_promocion,0);
	
	
	}

	?>
    <td width="15"><div align="center"><font size="0" face="arial, geneva, helvetica"><?=$promedio_promo_alumno?></font></div></td>
    </tr>
  	<? 	
	} 
	?>
  <tr>
    <td>&nbsp;</td>
    <td width="30%"><font size="1" face="verdana, arial, geneva, helvetica"><strong>Nota Menor</strong></font> </td>
	<? for($cont=0 ; $cont < $num_subsectores; $cont++)
	{?>
    <td colspan="3" align="center">&nbsp;</td>
    <? }?>
	<td width="15" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="30%"><font size="1" face="verdana, arial, geneva, helvetica"><strong>Nota Mayor</strong></font> </td>
    <? for($cont=0 ; $cont < $num_subsectores; $cont++)
	{?>
	<td colspan="3" align="center">&nbsp;</td>
    <? }?>
	<td width="15" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="30%"><font size="1" face="verdana, arial, geneva, helvetica"><strong>Mota Media </strong></font></td>
	<? for($cont=0 ; $cont < $num_subsectores; $cont++)
	{?>
    <td colspan="3" align="center">&nbsp;</td>
    <? }?>
	<td width="15" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="30%"><font size="1" face="verdana, arial, geneva, helvetica"><strong>Promedio del Curso </strong></font></td>
    <? for($cont=0 ; $cont < $num_subsectores; $cont++)
	{?>
	<td colspan="3" align="center">&nbsp;</td>
    <?  }?>
	<td width="15" align="center">&nbsp;</td>
  </tr>
	</table>	
	</td>
  </tr>
</table>

<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
</center>
  <?
}
?>  

<?
function InicialesSubsector($Subsector)
{
	$largo = strlen($Subsector);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($Subsector,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		echo trim(strtoupper(substr($Subsector,0,3)));
	else
		echo trim($cadena);
}
?>

<!-- FIN CUERPO DE LA PAGINA -->


<table width="650" border="0" align="center">
  <tr>
    <td><div align="left" class="subitem">
	<font face="verdana,Arial, Helvetica, sans-serif" size="2">
      <? 
	 setlocale(LC_TIME,"spanish");
	 $hoy=strftime("%A %d de %B de %Y");
	 echo ucwords($hoy); 
	 ?>
	 </font>
    </div></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
