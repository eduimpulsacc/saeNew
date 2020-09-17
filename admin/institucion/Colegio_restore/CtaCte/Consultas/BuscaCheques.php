<? include"../../Coneccion/conexion.php";


	
	$sql_instit= "Select rdb, nombre_instit From institucion Where rdb = $_INSTIT ;";
	$resultado_query_instit = @pg_exec($conexion,$sql_instit);
	$total_filas_instit     = @pg_numrows($resultado_query_instit);
	
	$sql_banco = "SELECT * FROM banco";
	$Rs_Banco = @pg_exec($conexion,$sql_banco);
	
	$sql_fechas = "select distinct a.id_tipo_documento, b.id_comprobante_doc, a.fecha_venc, a.numero, a.monto , b.rut_apo, trim(c.nombre_apo) || CAST(' ' AS char)|| trim(c.ape_pat) ";
	$sql_fechas = $sql_fechas. " || CAST(' ' AS CHAR) || trim(c.ape_mat) as nombre_apoderado, b.nro_comprobante, d.nombre";
	$sql_fechas = $sql_fechas. " from con_documenta_doc a inner join con_documenta_comprobante b on a.id_comprobante_doc=b.id_comprobante_doc ";
	$sql_fechas = $sql_fechas. " inner join con_tipo_documento d on a.id_tipo_documento=d.id_tipo_documento inner join apoderado c ";
	$sql_fechas = $sql_fechas. " on b.rut_apo=c.rut_apo where ";
	if (($FechaDesde!="") and ($FechaHasta!="") AND ($cmbbanco==0) )
		$sql_fechas = $sql_fechas. " fecha_venc between '". $FechaDesde ."' and  '" . $FechaHasta ."'";
	if (($FechaDesde!="") and ($FechaHasta!="") AND ($cmbbanco!=0) )
		$sql_fechas = $sql_fechas. " fecha_venc between '". $FechaDesde ."' and  '" . $FechaHasta ."' AND id_banco=". $cmbbanco ."";
	if (($FechaDesde=="") and ($FechaHasta=="") AND ($cmbbanco!=0) )		
		$sql_fechas = $sql_fechas. " id_banco=". $cmbbanco ."";
	$sql_fechas = $sql_fechas. "  and rdb=" . $_INSTIT ." ORDER BY fecha_venc";
	$Rs_Fechas = @pg_exec($conexion,$sql_fechas);
	






	
?>
<SCRIPT language="JavaScript" src="Validaciones.js"></SCRIPT>
<script>
		function enviapag(form){
			if (form.cmbbanco.value!=0){
				form.cmbbanco.target="self";
			}
		}
		
		function imprimir(){
	document.getElementById("capa0").style.display='none';
	//document.getElementById("capa1").style.display='block';
	//document.getElementById("capa2").style.display='none';
	document.getElementById("capa3").style.display='block';
	/*document.getElementById("capa4").style.display='block';
	document.getElementById("capa5").style.display='block';
	document.getElementById("capa6").style.display='block';*/
	window.print();
	document.getElementById("capa0").style.display='block';
	//document.getElementById("capa1").style.display='none';
	//document.getElementById("capa2").style.display='block';
	document.getElementById("capa3").style.display='none';
	/*document.getElementById("capa4").style.display='none';	
	document.getElementById("capa5").style.display='block';
	document.getElementById("capa6").style.display='block';*/
}
 </script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="650" border="1" align="center" cellspacing="0" cellpadding="0">
 <tr> 
      <td width="96" class="linea_datos_02">INSTITUCI&Oacute;N</td>
      <td width="405" class="linea_datos_02" align="center"> <? print Trim(@pg_result($resultado_query_instit, 0, 1));?></td>
      <td width="141" class="linea_datos_02">
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
 </table>
 <BR>
 <form name="form" action="BuscaCheques.php" method="post">
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="93" class="linea_datos_02"><font face="Arial, Helvetica, sans-serif">Fecha Desde</font></td>
    <td class="linea_datos_02" align="center" width="15">&nbsp;:&nbsp;</td>
    <td width="258"><input name="FechaDesde" type="text" class="text_9_x_100"></td>    
    <td width="133" class="linea_datos_02"><font face="Arial, Helvetica, sans-serif">Fecha Hasta</font></td>
    <td width="15" class="linea_datos_02">&nbsp;:&nbsp;</td>
    <td width="122"><input name="FechaHasta" type="text" class="text_9_x_100"></td>
  </tr>
  <tr>
    <td class="linea_datos_02"><font face="Arial, Helvetica, sans-serif">BANCO</font></td>
    <td class="linea_datos_02">&nbsp;:&nbsp;</td>
    <td><select name="cmbbanco" class="ddlb_9_x_250" OnChange="enviapag(this.form);">
        <OPTION value="0">Seleccione Banco</OPTION>
  <?
	For ($j=0; $j < @pg_numrows($Rs_Banco); $j++){
		$fils = @pg_fetch_array($Rs_Banco,$j);?>
		
        <option value=<? echo $fils['id_banco'];?> <? If($fils['id_banco'] == $cmbbanco) {?>selected <? }?>><? echo $fils['nombre'];?></option>
 <? }?>
        </select></td>
    <div id="capa6"><td colspan="3"><input type="submit" name="cb_consulta" value="Consultar" class="cb_none_9_x_100"></td></div>
  </tr>
</table>
</form>

<table width="649" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="649"> 
        <div align="right" id="capa0">
        <input name="cmdimprimiroriginal" type="button" class="cb_none_9_x_100" id="cmdimprimiroriginal" onClick="imprimir();" value="Imprimir">
      </div>
      </td>
  </tr>
</table>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="linea_datos_02" width="83"><div align="center">RUT</div></td>
    <td width="160" class="linea_datos_02"><div align="center">PROPIETARIO</div></td>
    <td width="88" class="linea_datos_02"><div align="center">MONTO</div></td>
    <td width="66" class="linea_datos_02"><div align="center">Tipo doc.</div></td>
    <td width="88" class="linea_datos_02"><div align="center">N&ordm; Doc.</div></td>
    <td width="96" class="linea_datos_02">fecha Venc.</td>
    <td width="53" class="linea_datos_02">N&ordm; Comp</td>
  </tr>
  
  <? 
	if(@pg_numrows($Rs_Fechas)!=0){  

  	for($i=0;$i<@pg_numrows($Rs_Fechas);$i++){
  		$fila = @pg_fetch_array($Rs_Fechas,$i);
		//----------BUSQUEDA DE DIGITO----------
	$sql= "Select dig_rut From apoderado where rut_apo =" . $fila['rut_apo'];
	$Rs_Dig = @pg_exec($conexion,$sql);
	$fils =@pg_fetch_array($Rs_Dig,0);
	$Rut = $fila['rut_apo']." - ". $fils['dig_rut'];
	
		?>
  <tr onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'><a href="BuscaComprobante.php?Id_Comprob=<?php echo $fila['nro_comprobante']; ?>">

    <td class="membrete_datos" width="83" align="right"><? echo $Rut;?></td>
    <td class="membrete_datos"><? echo $fila['nombre_apoderado'];?></td>
    <td class="membrete_datos"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="membrete_datos">&nbsp;$&nbsp;</td>
    <td class="membrete_datos" align="right"><? echo $fila['monto'];?></td>
  </tr>
</table>
</td>
    <td class="membrete_datos" align="center"><? echo $fila['nombre'];?></td>
    <td class="membrete_datos" align="center"><? echo $fila['numero'];?></td>
    <td class="membrete_datos"><? impF($fila['fecha_venc']);?> </td>
    <td class="membrete_datos" align="center"><? echo $fila['nro_comprobante'];?></td>
  </a></tr>
  <? 	if($fila['id_tipo_documento']==2) 
  			$Total_Cheques = $Total_Cheques + $fila['monto'];
		if ($fila['id_tipo_documento']==3)
			$Total_Letras = $Total_Letras + $fila['monto'];
	
  }// fin for
  }else{?>
  <tr>
  	<td colspan="7" class="membrete_datos">No se registran datos</td>
  </tr>
 <? }?>
</table><br>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="linea_datos_05">total de cheques</td>
     <td class="membrete_datos" align="right"><? echo number_format($Total_Cheques,2);?></td>
  </tr>
  <tr>
   <td class="linea_datos_05">Total de letras</td>
    <td class="membrete_datos" align="right"><? echo number_format($Total_Letras,2);?></td>
  </tr>
</table>

<br><br>
<br>

<div align="right" id="capa3" style="display:none"><table width="53%" border="0" align="center">
    <tr align="center"> 
        <td width="47%">_________________________</td>
      <td width="53%">_________________________</td>
  </tr>
  <tr>
      <td align="center" class="membrete_datos">Firma Encargado</td>
      <td align="center" class="membrete_datos">Firma Contabilidad</td>
  </tr>
</table></div>

</body>
</html>
