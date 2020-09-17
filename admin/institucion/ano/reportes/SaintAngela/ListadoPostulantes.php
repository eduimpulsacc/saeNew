<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
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
	$sql_postula = "select * from postulacion order by ape_pat_post, ape_mat_post";
	$result_postula =@pg_Exec($conn,$sql_postula);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="file:///C|/Documents%20and%20Settings/imp/Mis%20documentos/coe%20nuevo%20(local)/admin/util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<center>
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
    </TABLE></td>
  </tr>
  <tr>
    <td align="right">
	<div id="capa0">
	  <input name="button3" TYPE="button" class="botonX" onclick="imprimir();" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
	  <INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="NUEVO" name=btnModificar onclick=document.location="FichaPostulacion.php?id_post=0" >
      <INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" name=btnModificar3  onClick=document.location="../Menu_Reportes.php">
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
    <td width="105"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>RUT POSTULANTE </strong></font></td>
    <td width="519"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>NOMBRE</strong></font><strong><font size="-2" face="Arial, Helvetica, sans-serif"> COMPLETO </font></strong></td>
  </tr>
  <?
	for($e=0 ; $e < @pg_numrows($result_postula) ; $e++) 
	{
		$fila_postula = @pg_fetch_array($result_postula,$e);
  ?>
  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('VerFichaPostulacion.php?id_post=<?php echo trim($fila_postula['id_post']);?>')>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><? echo $fila_postula['rut_post']."-".$fila_postula['dig_rut_post']?></strong></font></td>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><? echo strtoupper($fila_postula['ape_pat_post']." ".$fila_postula['ape_mat_post']." ".$fila_postula['nombre_post'])?></strong></font></td>
  </tr>
  <? } ?>
</table>
<? pg_close($conn); ?>


</center>
</body>
</html>
