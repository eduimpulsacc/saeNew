<?php require('../../../../../util/header.inc');
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$alumno			=$_ALUMNO;
	$apoderado		=$_NOMBREUSUARIO;

	if($empleado==NULL){
		$empleado = $_NOMBREUSUARIO;
	}

?>
<script language="JavaScript" type="text/JavaScript" src="../../../../../util/chkform.js">

</script>
<?
/*if(($_PERFIL==0)||($_PERFIL==17)){
	$qry = "SELECT a.*, b.nombre_emp,b.ape_pat,b.ape_mat FROM comunicacion a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=" . $institucion;
}else*/
if(($_PERFIL==0) || ($_PERFIL==17) || ($_PERFIL==14) ){
echo	$qry = "SELECT a.*, b.nombre_emp,b.ape_pat,b.ape_mat FROM comunicacion a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=" . $institucion ." AND a.rut_emp=" . $empleado . " AND a.rut_apo is NULL  ORDER BY fecha ASC";
}
if(($_PERFIL==15) || ($_PERFIL==16)){
	 $qry= "SELECT distinct a.*, b.nombre_emp,b.ape_pat,b.ape_mat FROM comun_alumno c INNER JOIN comunicacion a ON c.id_comun=a.id_comun INNER JOIN empleado b ON a.rut_emp=b.rut_emp  ";
echo	 $qry = $qry. " WHERE c.rut_alum=".$alumno . " and rdb=". $institucion ." ORDER BY fecha ASC";
}
$Rs_Comunic =@pg_exec($conn,$qry);

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<? if(($_PERFIL==0) OR ($_PERFIL==8) OR ($_PERFIL==17) OR ($_PERFIL==14) OR ($_PERFIL==15)){  ?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
      <td align="right">
      <? if($_PERFIL!=0){?>
		  <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="AGREGAR" name=btnGuardar onClick=document.location="seteaComunicacion.php?caso=2">
	  <? } ?>
		<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../../curso/seteaCurso.php3?caso=1&curso=<? echo $curso; ?>"> </td>
  </tr>
</table>
<? } ?>
<table width="600" border="0" align="center" cellpadding="1" cellspacing="0">
    <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr height=20 bgcolor=#003b85>
		  <TD align=middle colspan="7"><FONT face="arial, geneva, helvetica" size=2 color=White><strong>COMUNICACIONES <? if(($_PERFIL==15) || ($_PERFIL==16)) echo "RECIBIDAS"; else echo "ENVIADAS";?> </strong></FONT></TD>
	</tr>
        <tr bgcolor="#48d1cc"> 
          <td><font size="1" face="Arial, Helvetica, sans-serif">FECHA</font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">TITULO</font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">DOCENTE</font></td>
        </tr>
		<? 	if (@pg_numrows($Rs_Comunic)!=0){
			for ($i=0; $i<@pg_numrows($Rs_Comunic);$i++){
				$fila = @pg_fetch_array($Rs_Comunic,$i); ?>
			<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaComunicacion.php?comunicacion=<?php echo $fila['id_comun'];?>&caso=1')>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><? impF($fila['fecha']);?></font></td>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><? echo strtoupper($fila['titulo']);?></font></td>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><?php echo $fila["ape_pat"]."  ".$fila["ape_mat"].", ".$fila["nombre_emp"];?></font></td>
			</tr>
				
			<? }
			}else{?>
			<tr>
				<td colspan="4"><font size="2" face="Arial, Helvetica, sans-serif">No existen registros</font></td>
			</tr>
			<? } ?>
      </table></td>
  </tr>
</table>
<BR>
<? 
	if(($_PERFIL==0) || ($_PERFIL==17) || ($_PERFIL==14) ){
echo "<br>";
echo		$sql= "SELECT distinct a.*, b.nombre_apo,b.ape_pat,b.ape_mat FROM comunicacion a INNER JOIN apoderado b ON a.rut_apo=b.rut_apo WHERE rdb=" . $institucion ." ORDER BY fecha ASC";
	}
	if(($_PERFIL==15) || ($_PERFIL==16)){
echo "<br>";
echo		$sql= "SELECT distinct a.*, b.nombre_emp,b.ape_pat,b.ape_mat FROM comunicacion a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE a.rut_apo=" . $apoderado ." and rdb=" . $institucion ." ORDER BY fecha ASC";
	}
	$Rs_Apo = @pg_exec($conn,$sql);
	
	?>
		<table width="600" border="0" align="center" cellpadding="1" cellspacing="0">
    <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr height=20 bgcolor=#003b85>
		  <TD align=middle colspan="7"><FONT face="arial, geneva, helvetica" size=2 color=White><strong>COMUNICACIONES <? if(($_PERFIL==15) || ($_PERFIL==16)) echo "ENVIADAS"; else echo "RECIBIDAS";?>            </strong></FONT></TD>
		</tr>
        <tr bgcolor="#48d1cc"> 
          <td><font size="1" face="Arial, Helvetica, sans-serif">FECHA</font></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">TITULO</font></td>
		  <? if(($_PERFIL==15) || ($_PERFIL==16)){ ?>
          <td><font size="1" face="Arial, Helvetica, sans-serif">DOCENTE</font></td>
		  <? } ?>
		  <? if(($_PERFIL==0) || ($_PERFIL==17) || ($_PERFIL==14) ){?>
	      <td><font size="1" face="Arial, Helvetica, sans-serif">APODERADO</font></td>
		  <? } ?>
        </tr>
		<? 	if (@pg_numrows($Rs_Apo)!=0){
			for ($i=0; $i<@pg_numrows($Rs_Apo);$i++){
				$fila = @pg_fetch_array($Rs_Apo,$i); ?>
			<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaComunicacion.php?comunicacion=<?php echo $fila['id_comun'];?>&caso=1')>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><? impF($fila['fecha']);?></font></td>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><? echo strtoupper($fila['titulo']);?></font></td>
				<? if(($_PERFIL==15) || ($_PERFIL==16)){ ?>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><?php echo $fila["ape_pat"]."  ".$fila["ape_mat"].", ".$fila["nombre_emp"];?></font></td>
				<? } ?>
				<? if(($_PERFIL==0) || ($_PERFIL==17) || ($_PERFIL==14) ){ ?>
				<td><font face="Arial, Helvetica, sans-serif" size="1"><?php echo $fila["ape_pat"]."  ".$fila["ape_mat"].", ".$fila["nombre_apo"];?></font></td>
				<? } ?>
			</tr>
				
			<? }
			}else{?>
			<tr>
				<td colspan="4"><font size="2" face="Arial, Helvetica, sans-serif">No existen registros</font></td>
			</tr>
			<? } ?>
      </table></td>
  </tr>
</table>
</body>
</html>
