<?php
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $cmb_curso;
	$reporte		= $c_reporte;
	$docente		= 5; //Codigo Docente

		$fecha1 		= $anoN."-04-30"; 

	
	
	$ob_reporte = new Reporte();
	$ob_reporte -> ano = $ano;
	
	$ob_reporte -> institucion = $institucion;
	$ob_reporte -> AnoEscolar($conn);
	
	$ob_membrete = new Membrete();
	$ob_membrete -> ano = $ano;
	$ob_membrete -> institucion = $institucion;
	$ob_membrete -> institucion($conn);
	
	
   	
	$ob_reporte ->orden = $orden;
	$total_filas= @pg_numrows($resultado_query);
 
 //-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$resultado_query= $ob_reporte ->NomCurso($conn);
	$total_filas= @pg_numrows($resultado_query);

	
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
</script>
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>
</head>

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
 .txt_tabla {
 font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: bold;
}
 .txt_nro{
 font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight:normal;
}
</style>
<body>
<table width="1024" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div id="capa0">
		<div align="right"> <font face="Arial, Helvetica, sans-serif" size="-1">Imprimir Horizontal</font>
		  <input name="button3" TYPE="button" class="botonXX" onClick="imprimir()" value="IMPRIMIR">	
  		</div>
	</div>
	</div>	</td>
  </tr>
  <tr>
    <td>
	
	
	
	
      <table width="100%" height="132" border="0" >
        <tr>
          <td width="184" align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>ESTABLECIMIENTO EDUCACIONAL </strong></font></td>
          <td width="185" align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;
            <?=$ob_membrete->ins_pal; ?>
          </font></td>
          <td align="left">&nbsp;</td>
          <td width="112" align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>REGION</strong></font></td>
          <td width="196" align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_membrete->region;?></font></td>
        </tr>
        <tr>
          <td> <div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>ROL BASE 
          DE DATOS</strong></font></div></td>
          <td> <div align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;</font><font face="Arial, Helvetica, sans-serif" size="1"><? echo $institucion." - ".$ob_membrete->dig_rdb;?></font></div></td>
          <td align="left">&nbsp;</td>
          <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>PROVINCIA</strong></font></div></td>
          <td>
            <div align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_membrete->provincia;?></font></div></td>
        </tr>
        <tr>
          <td ><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>A&Ntilde;O ESCOLAR </strong></font></div></td>
          <td ><div align="left"> <font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;</font><font face="Arial, Helvetica, sans-serif" size="1">
            <?=$ob_reporte->nro_ano; ?>
          </font></div></td>
		            <td align="left">&nbsp;</td>
          <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>COMUNA</strong></font></div></td>
          <td>
            <div align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_membrete->comuna;?></font></div></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
		            <td align="left">&nbsp;</td>
          <td><div align="left"></div></td>
          <td class="Estilo13 Estilo17"><div align="left"></div></td>
        </tr>
        <tr>
          <td height="16" colspan="5" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><strong>MATR&Iacute;CULA ALUMNOS DURANTE EL A&Ntilde;O </strong></font></td>
        </tr>
      </table>
    </td>
  </tr>
</table> 

<?php 

$meses=array("","","","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
$dias=array("","","",31,30,31,30,31,31,30,31,30,31);
$sw=0;

for ($i=0;$i<$total_filas;$i++)
  {
  	$fila = pg_fetch_array($resultado_query,$i);
	$filaxxx = pg_fetch_array($resultado_query,$i+1);
	$ob_reporte->grado_c=$fila['grado_curso'];
	$ob_reporte->letra_c=$fila['letra_curso'];
	$ob_reporte->ensenanza=$fila['ensenanza'];
	$ob_reporte->idcurso=$fila['id_curso'];
	$ob_reporte->ensenanza2=$filaxxx['ensenanza'];
	
	$ensenanza=$fila['ensenanza'];
	$ensenanza2=$filaxxx['ensenanza'];	
	$h_ense=0;
	
  ?>
<table   border="1" cellpadding="0" cellspacing="0" class="txt_tabla">
  <?php if ($i==0)
{?>
  <tr>
    <td   bgcolor="#999999">CURSO</td>
    <td colspan="3" bgcolor="#999999" width="100"><div align="center">MARZO</div></td>
    <td colspan="3" bgcolor="#999999" width="100"><div align="center">ABRIL</div></td>
    <td colspan="3" bgcolor="#999999" width="100"><div align="center">MAYO</div></td>
    <td colspan="3" bgcolor="#999999" width="100"><div align="center">JUNIO</div></td>
    <td colspan="3" bgcolor="#999999" width="100"><div align="center">JULIO</div></td>
    <td colspan="3" bgcolor="#999999" width="100"><div align="center">AGOSTO</div></td>
    <td colspan="3" bgcolor="#999999" width="100"><div align="center">SEPTIEMBRE</div></td>
    <td colspan="3" bgcolor="#999999" width="100"><div align="center">OCTUBRE</div></td>
    <td colspan="3" bgcolor="#999999" width="100"><div align="center">NOVIEMBRE</div></td>
    <td bgcolor="#999999" colspan="3" width="100"><div align="center">DICIEMBRE</div></td>
  </tr>
  <tr>
    <td  >&nbsp;</td>
    <td><div align="center">M</div></td>
    <td><div align="center">F</div></td>
    <td><div align="center">TOT</div></td>
    <td><div align="center">M</div></td>
    <td><div align="center">F</div></td>
    <td><div align="center">TOT</div></td>
    <td><div align="center">M</div></td>
    <td><div align="center">F</div></td>
    <td><div align="center">TOT</div></td>
    <td><div align="center">M</div></td>
    <td><div align="center">F</div></td>
    <td><div align="center">TOT</div></td>
    <td><div align="center">M</div></td>
    <td><div align="center">F</div></td>
    <td><div align="center">TOT</div></td>
    <td><div align="center">M</div></td>
    <td><div align="center">F</div></td>
    <td><div align="center">TOT</div></td>
    <td><div align="center">M</div></td>
    <td><div align="center">F</div></td>
    <td><div align="center">TOT</div></td>
    <td><div align="center">M</div></td>
    <td><div align="center">F</div></td>
    <td><div align="center">TOT</div></td>
    <td><div align="center">M</div></td>
    <td><div align="center">F</div></td>
    <td><div align="center">TOT</div></td>
    <td><div align="center">M</div></td>
    <td><div align="center">F</div></td>
    <td><div align="center">TOT</div></td>
  </tr>
  <?php }?>
  <?php $sql_tipo="select * from tipo_ensenanza where cod_tipo=".$ob_reporte->ensenanza;
   $res_tip=pg_exec($conn,$sql_tipo);
   $fila0 = @pg_fetch_array($res_tip,0);?>
  <tr>
    <td width="200" ><? echo $ob_reporte->grado_c; ?> - <?php echo $ob_reporte->letra_c ?>
        <?php 
   // busco tipo enseñanza
  
   
  
   ?>
        <?php echo trim($fila0['nombre_tipo']); ?> </td>
    <?php for ($j=0;$j<=12;$j++)
	{
		
		if ($j>2)
		{
	?>
    <td colspan="3" valign="top" height="100%"><table width="100" height="100%" border="1" align="center" cellpadding="0" cellspacing="0" class="txt_tabla">
      <tr>
        <td width="33" class="txt_nro" style="border-left:none; border-bottom:none; border-top:none" ><div align="center"><?
	  	
		//total matricula

  $qry2="select count(*) as total from alumno where rut_alumno in ( select rut_alumno from matricula where id_curso = '".$ob_reporte->idcurso."'  and fecha <= '".$ob_reporte->nro_ano."-".$j."-".$dias[$j]."' and id_ano=".$ob_reporte->ano.") and sexo = '2'";
 
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												 "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														//exit();
													}
													//echo trim($fila1['suma']);
													$total = $fila2['total'];
													
													
												}
											} 
										
										
										//total retirados	
			 $qry2="select count(*) as retirados from alumno where rut_alumno in ( select rut_alumno from matricula where id_curso = '".$ob_reporte->idcurso."' and fecha_retiro <= '".$ob_reporte->nro_ano."-".$j."-".$dias[$j]."' and id_ano=".$ob_reporte->ano.") and sexo = '2'";
 
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												 "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														//exit();
													}
													//echo trim($fila1['suma']);
													$retirados = $fila2['retirados'];
													
													
												}
											} 
	
		echo $hombres=$total-$retirados;
		
		$h_ense=$h_ense+$hombres;
		
											?></div></td>
        <td width="33" class="txt_nro" style="border-bottom:none; border-top:none"><div align="center"><?
	  	
		//total matricula femenina

  $qry2="select count(*) as total from alumno where rut_alumno in ( select rut_alumno from matricula where id_curso = '".$ob_reporte->idcurso."'  and fecha <= '".$ob_reporte->nro_ano."-".$j."-".$dias[$j]."' and id_ano=".$ob_reporte->ano.") and sexo = '1'";
 
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												 "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														//exit();
													}
													//echo trim($fila1['suma']);
													$total = $fila2['total'];
													
													
												}
											} 
										
										
										//total retirados	
			 $qry2="select count(*) as retirados from alumno where rut_alumno in ( select rut_alumno from matricula where id_curso = '".$ob_reporte->idcurso."' and fecha_retiro <= '".$ob_reporte->nro_ano."-".$j."-".$dias[$j]."' and id_ano=".$ob_reporte->ano.") and sexo = '1'";
 
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												 "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														//exit();
													}
													//echo trim($fila1['suma']);
													$retirados = $fila2['retirados'];
													
													
												}
											} 
	
		echo $mujeres=$total-$retirados;
		
											?></div></td>
        <td width="34" class="txt_nro" style="border-right:none; border-bottom:none; border-top:none"><div align="center"><?php echo $totalcurso=$hombres+$mujeres ?></div></td>
      </tr>
    </table></td>
    <?php }
	}
	?>
  </tr>
  <?  
  
  $filaxxx = pg_fetch_array($resultado_query,$i+1);
  $ensenanza=$fila['ensenanza'];
  $ensenanza2=$filaxxx['ensenanza']; 
   
  if($ensenanza!=$ensenanza2){ 
       $sw=1;
  }    
  
  if ($sw==1){ ?>
  <tr>
    <td width="200"  bgcolor="#999999" >Subtotal <?php echo trim($fila0['nombre_tipo']); ?></td>
    <?php for ($j=0;$j<=12;$j++)
	{
		
		if ($j>2)
		{
	?>
    <td  bgcolor="#999999" colspan="3" height="100%" ><table width="100" height="100%" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="33" class="txt_tabla" style="border-left:none; border-bottom:none; border-top:none"><div align="center">
		<? 
	  
	  //calculo retirados
	  $sql_ense1="SELECT count(*) AS ense1 FROM alumno INNER JOIN matricula ON (alumno.rut_alumno = matricula.rut_alumno) INNER JOIN curso ON (matricula.id_curso = curso.id_curso) WHERE MATRICULA.ID_ANO=(".$ob_reporte->ano.") AND (alumno.sexo = 2) AND (curso.ensenanza = ".$ensenanza.") AND (matricula.fecha_retiro < '".$ob_reporte->nro_ano."-".$j."-".$dias[$j]."')";
	//echo "sql_ense1=$sql_ense1<br>";
	
	$result_ense1 =@pg_Exec($conn,$sql_ense1);
											if (!$result_ense1) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												echo "qry=$qry<br>";
											}else{
												if (pg_numrows($result_ense1)!=0){
													$fila_ense1 = @pg_fetch_array($result_ense1,0);	
													if (!$fila_ense1){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
													//echo trim($fila1['suma']);
													$enseh1=$fila_ense1['ense1'];
													
													
												}
											} 
											//echo $enseh1;
											
											
	//calculo los que hay
	$sql_ense1="SELECT count(*) AS ense1 FROM alumno INNER JOIN matricula ON (alumno.rut_alumno = matricula.rut_alumno) INNER JOIN curso ON (matricula.id_curso = curso.id_curso) WHERE MATRICULA.ID_ANO=(".$ob_reporte->ano.") AND (alumno.sexo = 2) AND (curso.ensenanza = ".$ensenanza.")";
	//echo "sql_ense1=$sql_ense1<br>";
	
	$result_ense1 =@pg_Exec($conn,$sql_ense1);
											if (!$result_ense1) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												echo "qry=$qry<br>";
											}else{
												if (pg_numrows($result_ense1)!=0){
													$fila_ense1 = @pg_fetch_array($result_ense1,0);	
													if (!$fila_ense1){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
													//echo trim($fila1['suma']);
													$enseh2=$fila_ense1['ense1'];
													
													
												}
											} 
	
	
	$ensefinalh=$enseh2-$enseh1;
	echo $ensefinalh;
	
	?></div></td>
        <td width="33" class="txt_tabla" style="border-bottom:none; border-top:none"><div align="center"><? 
	  
	  //calculo retirados
	  $sql_ense1="SELECT count(*) AS ense1 FROM alumno INNER JOIN matricula ON (alumno.rut_alumno = matricula.rut_alumno) INNER JOIN curso ON (matricula.id_curso = curso.id_curso) WHERE MATRICULA.ID_ANO=(".$ob_reporte->ano.") AND (alumno.sexo = 1) AND (curso.ensenanza = ".$ensenanza.") AND (matricula.fecha_retiro < '".$ob_reporte->nro_ano."-".$j."-".$dias[$j]."')";
	//echo "sql_ense1=$sql_ense1<br>";
	
	$result_ense1 =@pg_Exec($conn,$sql_ense1);
											if (!$result_ense1) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												echo "qry=$qry<br>";
											}else{
												if (pg_numrows($result_ense1)!=0){
													$fila_ense1 = @pg_fetch_array($result_ense1,0);	
													if (!$fila_ense1){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
													//echo trim($fila1['suma']);
													$enseh1=$fila_ense1['ense1'];
													
													
												}
											} 
											//echo $enseh1;
											
											
	//calculo los que hay
	$sql_ense1="SELECT count(*) AS ense1 FROM alumno INNER JOIN matricula ON (alumno.rut_alumno = matricula.rut_alumno) INNER JOIN curso ON (matricula.id_curso = curso.id_curso) WHERE MATRICULA.ID_ANO=(".$ob_reporte->ano.") AND (alumno.sexo = 1) AND (curso.ensenanza = ".$ensenanza.")";
	//echo "sql_ense1=$sql_ense1<br>";
	
	$result_ense1 =@pg_Exec($conn,$sql_ense1);
											if (!$result_ense1) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												echo "qry=$qry<br>";
											}else{
												if (pg_numrows($result_ense1)!=0){
													$fila_ense1 = @pg_fetch_array($result_ense1,0);	
													if (!$fila_ense1){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
													//echo trim($fila1['suma']);
													$enseh2=$fila_ense1['ense1'];
													
													
												}
											} 
	
	
	$ensefinalf=$enseh2-$enseh1;
	echo $ensefinalf;
	
	?></div></td>
        <td width="34" class="txt_tabla" style="border-right:none; border-bottom:none; border-top:none"><div align="center"><?php $final=$ensefinalf+$ensefinalh; echo $final?></div></td>
      </tr>
    </table></td>
    <?php }
		  }
		  
		  ?>
  </tr>
  <?
	 $sw=0;
  }    
   
  
   
}
?>
  <tr>
    <td width="200">TOTAL</td>
    <?php for ($j=0;$j<=12;$j++)
	{
		
		if ($j>2)
		{
	?>
    <td  valign="top" colspan="3"><table width="100" border="1" cellpadding="0" cellspacing="0" bgcolor="#999999" class="txt_tabla">
      <tr>
        <td width="33"><div align="center" class="txt_nro"><strong>
          <?
	  	//calculo retirados
		  $qry="SELECT COUNT(*) AS SUMA FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ob_reporte->ano.") AND (MATRICULA.id_curso>0)  AND  SEXO = '2' and matricula.fecha_retiro<'".$ob_reporte->nro_ano."-".$j."-".$dias[$j]."')";
			
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												echo "qry=$qry<br>";
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
													//echo trim($fila1['suma']);
													$totalhombres1 = $fila1['suma'];
													
													
												}
											} 
											
											
		//calculo total
		    $qry2="SELECT COUNT(*) AS SUMA2 FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ob_reporte->ano.")  AND SEXO = '2' AND (MATRICULA.id_curso>0))";
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												echo "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
													//echo trim($fila2['suma2']);
													$totalhombres2 = $fila2['suma2'];
													
												}
											} 
		$totalhombres=$totalhombres2-$totalhombres1;
		echo $totalhombres;	
		
											?>
        </strong></div></td>
        <td width="33" class="txt_nro"><div align="center"><strong>
          <?
	  	//calculo retirados
		    $qry="SELECT COUNT(*) AS SUMA FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ob_reporte->ano.") AND (MATRICULA.id_curso>0)  AND SEXO = '1' and matricula.fecha_retiro<'".$ob_reporte->nro_ano."-".$j."-".$dias[$j]."')";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												echo "qry=$qry<br>";
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
													//echo trim($fila1['suma']);
													$totalmujeres1 = $fila1['suma'];
												}
											} 
											
											
		//calculo total
		    $qry2="SELECT COUNT(*) AS SUMA2 FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ob_reporte->ano.") AND (MATRICULA.id_curso>0) AND  SEXO = '1' )";
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												//echo "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
													//echo trim($fila2['suma2']);
													$totalmujeres2 = $fila2['suma2'];
												}
											} 
		$totalmujeres=$totalmujeres2-$totalmujeres1;
		echo $totalmujeres;		
											?>
        </strong></div></td>
        <td width="34" class="txt_nro"><div align="center" class="Estilo1">
          <div align="center"><?php $total=$totalhombres+$totalmujeres; echo $total;?></div>
        </div></td>
      </tr>
    </table></td>
    <?php 
	}
	}?>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>