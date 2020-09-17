<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	document.getElementById("capa1").style.display='none';	
	window.print();
	document.getElementById("capa1").style.display='block';
	document.getElementById("capa0").style.display='block';
}
</script>
<?
require('../../../../../util/header.inc');

	setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
	// AÑO ESCOLAR
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	$ano_escolar2 = $fila_ano['nro_ano']+1;
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM institucion INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion."));";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro'] . " - " . $fila_institu['nom_com']));
	$telefono = $fila_institu['telefono'];		 	
	//-----------------
	// COMUNAS
	//------------------
	$sql_comuna = "select * from comuna order by nom_com";
	$result_comuna =@pg_Exec($conn,$sql_comuna);
	//----------------------
	// CURSOS POSTULACION
	//-----------------------	
	$sql_cursos = "select curso.grado_curso, ";
	$sql_cursos = $sql_cursos . "curso.ensenanza, ";
	$sql_cursos = $sql_cursos . "tipo_ensenanza.nombre_tipo ";
	$sql_cursos = $sql_cursos . "from   curso, tipo_ensenanza ";
	$sql_cursos = $sql_cursos . "where  id_ano = ".$ano." ";
	$sql_cursos = $sql_cursos . "and    tipo_ensenanza.cod_tipo = curso.ensenanza ";
	$sql_cursos = $sql_cursos . "order by curso.ensenanza ,curso.grado_curso ";
	$result_cursos =@pg_Exec($conn,$sql_cursos);
	//------------------
	$sql_postula = "select * from postulacion where id_ano = ".$ano_escolar2." and rdb = ".$institucion." order by ape_pat_post, ape_mat_post";
	$result_postula =@pg_Exec($conn,$sql_postula);
	//----------------
?>
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<div id="capa1">
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../../periodo/listarPeriodo.php3"><img src="../../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../feriado/listaFeriado.php3"><img src="../../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../planEstudio/listarPlanesEstudio.php3"><img src="../../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../atributos/listarTiposEnsenanza.php3"><img src="../../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../curso/listarCursos.php3"><img src="../../../botones/cursos.gif" name="Image6" width="81" height="30" border="0" id="Image6" onMouseOver="MM_swapImage('Image6','','../../../botones/cursos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../../botones/matricula_roll.gif" name="Image7" width="81" height="30" border="0" id="Image7" ></a></td>
          <td width="81" height="30"><a href="../../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../../../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="#"><img src="../../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>        </tr>
      </table> </td>
  </tr>
</table>
</div>
<center>
<br>
<table width="630"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
      <TR>
        <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> </FONT> </TD>
        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>
          <?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila['nombre_instit']);
												}
											}
										?>
        </strong> </FONT> </TD>
      </TR>
      <TR>
        <TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>AÑO POSTULACION</strong></FONT></TD>
        <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
        <TD><FONT face="arial, geneva, helvetica" size=2><strong><? echo $ano_escolar2?></strong></FONT></TD>
      </TR>
    </TABLE></td>
  </tr>
  <tr>
    <td align="right">
	<div id="capa0">
	  <input name="button3" TYPE="button" class="botonX" onclick="imprimir();" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
	  <INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="NUEVO" name=btnModificar onclick=document.location="FichaPostulacion.php?id_post=0" >
      <INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" name=btnModificar3  onClick=document.location="../listarMatricula.php3">
    </div>	  
	</td>	
  </tr>  
</table>
<br>
<table width="630" border="0" cellspacing="1" cellpadding="1" bgcolor="#003b85">
  <tr>
    <td align="center"><font face="Arial, Helvetica, sans-serif" size="2"><strong><font color="white">PROCESO POSTULACI&Oacute;N </font></strong></font></td>
  </tr>
</table>
<table width="630" BORDER=0 CELLSPACING=1 CELLPADDING=1>
  <tr bgcolor="#48d1cc">
    <td width="94"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>RUT POSTULANTE </strong></font></td>
    <td width="257"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>NOMBRE</strong></font><strong><font size="-2" face="Arial, Helvetica, sans-serif"> COMPLETO </font></strong></td>
    <td width="269"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>CURSO A POSTULAR </strong></font></td>
    <td width="269"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>ESTADO</strong></font></td>
  </tr>
  <?
	for($e=0 ; $e < @pg_numrows($result_postula) ; $e++) 
	{
		$fila_postula = @pg_fetch_array($result_postula,$e);
		$sql_cursos = "select * from tipo_ensenanza where cod_tipo = ".$fila_postula['ensenanza_post'];
		$result_cursos =@pg_Exec($conn,$sql_cursos);	
		$fila_cursos = @pg_fetch_array($result_cursos,0);
		$curso_post = $fila_postula['grado_post']."º ".$fila_cursos['nombre_tipo'];
  ?>
  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('VerFichaPostulacion.php?id_post=<?php echo trim($fila_postula['id_post']);?>')>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><? echo $fila_postula['rut_post']."-".$fila_postula['dig_rut_post']?></strong></font></td>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><? echo strtoupper($fila_postula['ape_pat_post']." ".$fila_postula['ape_mat_post']." ".$fila_postula['nombre_post'])?></strong></font></td>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><? echo $curso_post ?></strong></font></td>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>  <? if($fila_postula['estado']==1 ) echo "Lista de Espera";
	if($fila_postula['estado']==2 ) echo "Proceso de Selecci&oacute;n";
	if($fila_postula['estado']==3 ) echo "Seleccionado(a)";?></strong></font></td>
  </tr>
  <? } ?>
</table>
<? pg_close($conn); ?>


</center>
</body>
</html>
