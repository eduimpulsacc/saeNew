<? include"../../Coneccion/conexion.php";
	//require('ValidaCaracteres.inc');
	
	if ($Id_Comprob!="")
		$numcomprob = $Id_Comprob;
		
	$hoy = getdate();
	$year_actual = $hoy["year"];
	$mes_actual  = date(m);
	$dia_actual  = $hoy["mday"];
	$periodo = $year_actual.$mes_actual;
	$fecha_actual = $dia_actual."-".$mes_actual."-".$year_actual = $hoy["year"];
	
	
	$sql_instit= "Select rdb, nombre_instit From institucion Where rdb = $_INSTIT ;";
	$resultado_query_instit = @pg_exec($conexion,$sql_instit);
	$total_filas_instit     = @pg_numrows($resultado_query_instit);
	
	//----------------BUSQUEDA SOSTENEDOR --------------------------------------------
	$sql_apo = "select a.*, trim(b.nombre_apo) || CAST(' '  AS char)|| trim(b.ape_pat) || CAST(' ' AS CHAR) || trim(b.ape_mat) as nombre,b.dig_rut ";
	$sql_apo = $sql_apo. "from con_documenta_comprobante a inner join apoderado b on a.rut_apo=b.rut_apo where nro_comprobante=". $numcomprob . " and rdb=" . $_INSTIT;
	$Rs_Apo = @pg_exec($conexion,$sql_apo);
	$fila = @pg_fetch_array($Rs_Apo,0);
	$Id_Comprob = $fila['id_comprobante_doc'];
	$Rut_Apo = $fila['rut_apo'];
	
	//-----------------BUSQUEDA DE ALUMNOS -----------------------
	$sql_datos_alumno="Select distinct a.rut_alumno, b.rut_apo, a.rdb, a.id_ano, a.id_curso, f.nombre_alu, f.ape_pat, f.ape_mat,f.dig_rut, f1.grado_curso, f1.ensenanza, f1.letra_curso, t.nombre_tipo";
	$sql_datos_alumno = $sql_datos_alumno. " From matricula a, tiene2 b, ano_escolar e, alumno f, curso f1, tipo_ensenanza t, con_documenta_alumno c where a.rdb = $_INSTIT and b.rut_apo = '$Rut_Apo' And a.rut_alumno = b.rut_alumno ";
	$sql_datos_alumno = $sql_datos_alumno. " And a.rut_alumno = f.rut_alumno And a.rdb = e.id_institucion And a.id_ano = e.id_ano  And e.nro_ano >= $year_actual And a.id_curso = f1.id_curso and t.cod_tipo = f1.ensenanza";
	$sql_datos_alumno = $sql_datos_alumno. " ANd c.rut_alumno=f.rut_alumno AND id_comprobante=". $Id_Comprob ." Order by 1";
	$resultado_query_datos_alumno = @pg_exec($conexion,$sql_datos_alumno);
	$total_filas_datos_alumno     = @pg_numrows($resultado_query_datos_alumno);

	//----------------- SOLUCION PROVISORIA ----------------------- en espera de la carga de los bancos en los comprobantes ya ingresados
	$sql_banco = "select id_banco from con_documenta_doc where id_comprobante_doc=" . $Id_Comprob;
	$Rs_Banco = @pg_exec($conexion,$sql_banco);
	
	if(@pg_numrows!=0){
		$sql_documento = "select c.nombre,a.id_comprobante_doc, b.nombre as tipo, monto, numero,fecha_venc, observacion,d.nombre as banco ";
		$sql_documento = $sql_documento. " from con_documenta_doc a inner join con_tipo_documento b  on a.id_tipo_documento=b.id_tipo_documento ";
		$sql_documento = $sql_documento. " inner join con_cuenta c on a.id_cuenta=c.id_cuenta  inner join banco d on a.id_banco=d.id_banco where id_comprobante_doc=" . $Id_Comprob;
	}else{
		//----------------BUSQUEDA DE DOCUMENTACION -------------------
		$sql_documento = "select c.nombre,a.id_comprobante_doc, b.nombre as tipo, monto, numero,fecha_venc, observacion ";
		$sql_documento = $sql_documento. " from con_documenta_doc a inner join con_tipo_documento b  on a.id_tipo_documento=b.id_tipo_documento ";
		$sql_documento = $sql_documento. " inner join con_cuenta c on a.id_cuenta=c.id_cuenta   where id_comprobante_doc=" . $Id_Comprob;
	}
	$Rs_documento = @pg_exec($conexion,$sql_documento);
	
	
?>
<html>
<head>
<title>Untitled Document</title>
<link href="../../css/objeto.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="Validaciones.js"></SCRIPT>
<SCRIPT language="JavaScript">
function imprimir(){
	document.getElementById("capa0").style.display='none';
	document.getElementById("capa1").style.display='none';
	/*document.getElementById("capa3").style.display='block';
	document.getElementById("capa4").style.display='block';*/
	window.print();
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
	/*document.getElementById("capa2").style.display='block';
	document.getElementById("capa3").style.display='none';
	document.getElementById("capa4").style.display='none';	*/
}
</script>
</head>

<body>
<table width="651" border="1" align="center" cellspacing="0" cellpadding="0">
 <tr> 
      <td width="95" class="linea_datos_02">INSTITUCI&Oacute;N</td>
      <td width="394" class="linea_datos_02" align="center"> <? print Trim(@pg_result($resultado_query_instit, 0, 1));?></td>
      <td width="154" class="linea_datos_02">
	  <div align="right" id="capa4" style="display:none">
          <table width="50%" border="0" align="right">
            <tr> 
      <td width="50%">
	  	<?
		$result = @pg_exec($conexion,"select * from institucion where rdb=".$_INSTIT);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conexion,$output);?>
		<table width="125" border="0" cellpadding="0" cellspacing="0" align="right">
          <tr>
            <td width="125" align="center">

							<img src=../../../../../../tmp/<? echo trim($_INSTIT)."insignia" ?> ALT="NO DISPONIBLE"  width=80 ></td>
			 </tr>
             </table>
			<? } ?>

	  &nbsp;</td>
    </tr>
  </table>
  </div>
&nbsp;</td>
    </tr>
 </table><br>
 <form name="form" action="BuscaComprobante.php" method="post">
<table width="649" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="152" class="linea_datos_02">nº Comprobante</td>
    <td width="13" class="linea_datos_02">&nbsp;:&nbsp;</td>
    <td width="279"><input name="numcomprob" type="text" class="text_9_x_50" id="numcomprob" value="<? echo $numcomprob;?>"></td>
    <td width="195"><div align="left" id="capa1"><input type="submit" name="cb_consulta" value="Consultar" class="cb_none_9_x_100"></div></td>
  </tr>
</table>
</form>

<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="152" class="linea_datos_02">sostenedor</td>
    <td width="13" class="linea_datos_02">&nbsp;:&nbsp;</td>
    <td width="279" class="membrete_datos"><? echo $fila['nombre'];?></td>
    <td width="37" class="linea_datos_02">rut</td>
    <td width="13" class="linea_datos_02">&nbsp;:&nbsp;</td>
    <td width="142" class="membrete_datos"><? echo $fila['rut_apo']. " -  " . $fila['dig_rut'];?></td>
  </tr>
</table><br>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="453" class="linea_datos_02">total documento</td>
    <td width="191" class="membrete_datos"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="membrete_datos">&nbsp;$&nbsp;</td>
    <td class="membrete_datos"><div align="right"><? echo number_format($fila['monto'],2);?></div></td>
  </tr>
</table>
</td>
  </tr>
</table>

<br>

  
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="237" colspan="3" class="linea_datos_02"><div align="center">ALUMNOS</div></td>
  </tr>
  <tr> 
    <td width="147" class="linea_datos_02">NOMBRE</td>
    <td width="119" class="linea_datos_02">CURSO</td>
    <td width="68" class="linea_datos_02">MONTO </td>

  </tr>
  <?
	For ($j=0; $j < $total_filas_datos_alumno; $j++)
	{
	$ls_rut_alumno = Trim(pg_result($resultado_query_datos_alumno, $j, 0));
	$ls_ensenanza = Trim(pg_result($resultado_query_datos_alumno, $j, 10));
	$ls_grado = Trim(pg_result($resultado_query_datos_alumno, $j, 9));
	$ls_rdb = Trim(pg_result($resultado_query_datos_alumno, $j, 2));
	$sql_grado= "select distinct id_cuenta, grado,monto,a.id_categoria from con_categoria_cuenta b, con_categoria_grado a where grado=$ls_grado and ensenanza =$ls_ensenanza and b.rdb=$_INSTIT and b.id_categoria=a.id_categoria and b.id_cuenta in (Select id_cuenta From con_cuenta where rdb = $_INSTIT and asignar< 3 Order by nombre )";
	$resultado_query_grado = @pg_exec($conexion,$sql_grado);
	$total_filas_grado = @pg_numrows($resultado_query_grado);
	?>
  <input name="total_filas_grado" type="hidden" value="<? echo @pg_numrows($resultado_query_grado)?>">
  <? //for ($count_0=0 ; $count_0<$j ; $count_0++ ){ $a=$a+1;?>
  <tr> 
    <input name="cuenta_alum" type="hidden" value="<? echo $total_filas_datos_alumno;?>">
    <td class="membrete_datos">&nbsp;<? print Trim(pg_result($resultado_query_datos_alumno, $j, 6));?> 
      <? print Trim(pg_result($resultado_query_datos_alumno, $j, 7));?> <? print Trim(pg_result($resultado_query_datos_alumno, $j, 5));?></td>
    <td class="membrete_datos"> 
      <!-- <div align="right">&nbsp; <? print pg_result($resultado_query_datos_alumno, $j, 9);?> 
          <? print Trim(pg_result($resultado_query_datos_alumno, $j, 11));?> </div> -->
      <div align="left"> 
        <? 
				if (pg_result($resultado_query_datos_alumno, $j, 10)>=110){
					 print pg_result($resultado_query_datos_alumno, $j, 9);
					 echo "º";
					 print Trim(pg_result($resultado_query_datos_alumno, $j, 11));
					 echo "&nbsp"; 
					 print pg_result($resultado_query_datos_alumno, $j, 12);
				 }
				 if (pg_result($resultado_query_datos_alumno, $j, 10)<110){
							if (pg_result($resultado_query_datos_alumno, $j, 9)==1){
								$grado= "SALA CUNA";
							}
							if (pg_result($resultado_query_datos_alumno, $j, 9)==2){
								$grado="NIVEL MEDIO MENOR";
							}
							if (pg_result($resultado_query_datos_alumno, $j, 9)==3){
								$grado="NIVEL MEDIO MAYOR";
							}
							if (pg_result($resultado_query_datos_alumno, $j, 9)==4){
								$grado="TRANSICIÓN 1er NIVEL";
							}
							if (pg_result($resultado_query_datos_alumno, $j, 9)==5){
								$grado="TRANSICIÓN 2º NIVEL";
							}
				echo $grado," ", Trim(pg_result($resultado_query_datos_alumno, $j, 11));
			 }
			 ?>
      </td>
    <!-- <td class="membrete_datos"><div align="right">&nbsp;  -->
    <? 
		  
		  for ($count_0=0 ; $count_0<$total_filas_grado ; $count_0++ ){ 
		  $a=$a+1;
		  $b=$b+$count_0;
		  
		  $val=@pg_result($resultado_query_grado, $count_0, 0);
										  $sqlCta="select nombre from con_cuenta where id_cuenta=".$val;
										  $resCta = pg_exec($conexion, $sqlCta);
										  $fila =pg_fetch_array($resCta,0);
										  if(($b!=$j) and ($alumno!=1)){echo "<td>&nbsp;</td><td>&nbsp;</td>";}
										  echo "<td class=\"membrete_datos\"><div class=\"membrete_datos\" align=\"right\">&nbsp;",$fila['nombre'];
										  echo "  -  ";
										//for($count_0=0 ; $count_0 < $total_filas_grado_0 ; $count_0++){
											$sqlCount_0="select count(id_cuenta) from con_categoria_cuenta_periodo where id_cuenta=".@pg_result($resultado_query_grado, $count_0, 0)." and id_categoria = ".@pg_result($resultado_query_grado, $count_0, 3)."";
											$resCount_0 = pg_exec($conexion, $sqlCount_0);
											$filaCount_0 = pg_fetch_array($resCount_0, 0);
											$cant_0 = $filaCount_0['count'];
											$monto_0 = $cant_0 * @pg_result($resultado_query_grado, $count_0, 2);?>
    <? if($alumno==0) $m[$a]="";
												
											if ($descuento[$a]!=""){
												$monto_0 = $monto_0 * $descuento[$a];
												echo number_format(round($monto_0),'2');
											}else if($m[$a]!=""){
												$monto_0 = $m[$a];
												echo number_format(round($monto_0),'2');
											}else{
												echo number_format(round($monto_0),'2');
												
											}
											echo "<input name=\"m[".$a."]\" type=\"hidden\" value=".$monto_0.">";

											if($nomcta0=="") {
												$nomcta0=$fila['nombre'];
											}
											if ($nomcta0 == $fila['nombre']) {
												$mcta0 = $monto_0 + $mcta0;
											}else {
												$nomcta1 = $fila['nombre'];
												$mcta1 = $monto_0 + $mcta1;
											}
											$totaliza = $totaliza + $monto_0;
										//}

										  //echo(@pg_result($resultado_query_grado, $count, 2));?></td>
  </tr>
  <? $total_matricula=$total_matricula + @pg_result($resultado_query_grado, $count, 2);
	  } ?>
  <?
	
	}
	?>
  <td colspan="2" class="linea_datos_02">subtotal 
    <? echo $nomcta0?> <input type="hidden" name="hd_nomcta0" value="<? echo strtoupper(trim($nomcta0))?>"> 
  </td>
  <td class="linea_datos_02"><div align="right"> 
      <input name="hd_mcta0" type="hidden" value="<? echo number_format($mcta0,'2') ?>">
      <? echo number_format($mcta0,'2')?></div></td>
  <tr> 
    <td colspan="2" class="linea_datos_02">subtotal 
      <? echo $nomcta1 ?> <input type="hidden" name="hd_nomcta1" value="<? echo strtoupper(trim($nomcta1))?>"> 
    </td>
    <td class="linea_datos_02"><div align="right"> 
        <input name="hd_mcta1" type="hidden" value="<? echo number_format($mcta1,'2') ?>">
        <? echo number_format($mcta1,'2')?></div></td>
  </tr>
 
    <td colspan="2" class="linea_datos_02">TOTAL 
    </td>
    <td class="linea_datos_02"><div align="right"><? echo number_format($totaliza,'2');//,$tot; ; ?> 
        <input name="tota" type="hidden" value="<? echo $totaliza;?>">
      </div></td>
  </tr>
</table><br>
<table width="650" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="linea_datos_02">cuenta</td>
    <td class="linea_datos_02">tipo documento</td>
    <td class="linea_datos_02">banco</td>
    <td class="linea_datos_02">numero serie</td>
    <td class="linea_datos_02">monto $</td>
    <td class="linea_datos_02">fecha venc.</td>
    <td class="linea_datos_02">observacion</td>
  </tr>
  <? for ($i=0;$i<@pg_numrows($Rs_documento);$i++){
  		$fila_Doc = @pg_fetch_array($Rs_documento,$i);
  ?>
  <tr>
    <td class="membrete_datos"><? echo $fila_Doc['nombre'];?></td>
    <td class="membrete_datos"><? echo $fila_Doc['tipo'];?></td>
    <td class="membrete_datos"><? echo $fila_Doc['banco'];?>&nbsp;</td>
    <td class="membrete_datos"><? echo $fila_Doc['numero'];?></td>
    <td class="membrete_datos"><? echo number_format($fila_Doc['monto'],2);?></td>
    <td class="membrete_datos"><? impF($fila_Doc['fecha_venc']);?></td>
    <td class="membrete_datos">&nbsp;<? echo $fila_Doc['observacion'];?></td>
  </tr>
  <?php } ?>
</table>
<br>
<table width="650" border="0" align="center">
    <tr>
    <td align="right" class="membrete_datos">&nbsp;<?php  /*setlocale ("LC_TIME", "es_ES");*/ echo (strftime("%d de %B de %Y")); ?></td>
  </tr>
</table>

<br>
<br>
  <div align="right"><table width="50%" border="0" align="center">
    <tr align="center"> 
        <td width="47%">_________________________</td>
      <td width="53%">_________________________</td>
  </tr>
  <tr>
      <td align="center" class="membrete_datos">Firma Sostenedor</td>
      <td align="center" class="membrete_datos">Firma Cajero</td>
  </tr>
</table></div><br>
<table width="%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td> 
        <div align="center" id="capa0"> 
          <input name="cmdimprimiroriginal" type="button" class="cb_none_9_x_100" id="cmdimprimiroriginal" onClick="imprimir();" value="Imprimir">		  
        </div>
      </td>
  </tr>
</table>
</body>
</html>
