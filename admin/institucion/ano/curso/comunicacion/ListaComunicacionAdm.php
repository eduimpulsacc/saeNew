<?php require('../../../../../util/header.inc');
	  include('../../../../../util/rpc.php3');
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$empleado		=$_EMPLEADO;
	$curso			=$_CURSO;


$sql="";
$sql = "SELECT nombre_instit FROM institucion WHERE rdb=".$institucion;
$Rs_Instit = @pg_exec($conn,$sql);
$filsInst =@pg_fetch_array($Rs_Instit,0);

$sql="";
$sql  ="SELECT * FROM comunicacion WHERE rut_apo is null AND rdb=".$institucion." AND autorizacion=1";
$Rs_Comun = @pg_exec($conn,$sql);

$sql="";
$sql  ="SELECT * FROM comunicacion WHERE rut_apo is null AND rdb=".$institucion." AND autorizacion=2";
$Rs_Comun2 = @pg_exec($conn,$sql);

$sql ="";
$sql ="SELECT empleado.nombre_emp, empleado.ape_pat,empleado.ape_mat FROM empleado WHERE rut_emp=".$empleado;
$Rs_Resp = @pg_exec($conn,$sql);
$filsResp = @pg_fetch_array($Rs_Resp,0);

?>
<script language="JavaScript" type="text/JavaScript" src="../../../../../util/chkform.js">

</script>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../../util/td.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="650" border="0" align="center">
  <tr> 
    <td width="129"><font size="2" face="Geneva, Arial, Helvetica"><strong>INSTITUCION</strong></font></td>
    <td width="17">:</td>
    <td width="490">&nbsp;<? echo $filsInst['nombre_instit'];?></td>
  </tr>
  <tr> 
    <td><strong><font size="2" face="Geneva, Arial, Helvetica">RESPONSABLE</font></strong></td>
    <td><strong> :</strong></td>
    <td>&nbsp;<? echo $filsResp['nombre_emp']." ".$filsResp['ape_pat']." ".$filsResp['ape_mat'];?></td>
  </tr>
</table>
<br>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
<TR>
	<td align="right"><INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../../curso/seteaCurso.php3?caso=1&curso=<? echo $curso; ?>"> </td>
</TR>
</TABLE>
<table width="650" border="0" align="center">
  <tr bgcolor=#003b85> 
    <td colspan="4" ><font color="#FFFFFF" size="2" face="Geneva, Arial, Helvetica"><strong>PENDIENTES 
      DE AUTORIZACI&Oacute;N</strong></font></td>
  </tr>
  <tr bgcolor="#48d1cc"> 
    <td width="75"><font size="1" face="Geneva, Arial, Helvetica">FECHA</font></td>
    <td width="240"><font size="1" face="Geneva, Arial, Helvetica">DOCENTE</font></td>
    <td width="164"><font size="1" face="Geneva, Arial, Helvetica">TITULO</font></td>
    <td width="153"><font size="1" face="Geneva, Arial, Helvetica">CURSO</font></td>
  </tr>
  <? if(@pg_numrows($Rs_Comun)!=0){
  		for($i=0;$i<@pg_numrows($Rs_Comun);$i++){
			$filsComun = @pg_fetch_array($Rs_Comun,$i);
			$sql="";
			$sql="SELECT empleado.nombre_emp, empleado.ape_pat,empleado.ape_mat FROM empleado WHERE rut_emp=".$filsComun['rut_emp'];
			$Rs_Emp = @pg_exec($conn,$sql);
			$filsEmp = @pg_fetch_array($Rs_Emp,0);
			$sql="";
			$sql = "select distinct matricula.id_curso from comun_alumno inner join matricula on comun_alumno.rut_alum=matricula.rut_alumno where id_comun=".$filsComun['id_comun'];
			$Rs_Curso = @pg_exec($conn,$sql);
			$filsCurso = @pg_fetch_array($Rs_Curso,0);
			$Curso_pal = CursoPalabra($filsCurso['id_curso'], 0, $conn); ?>
			<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaComunicacion.php?comunicacion=<?php echo $filsComun['id_comun'];?>&caso=5')>
    			<td><font size="1" face="Geneva, Arial, Helvetica">&nbsp;<? echo impF($filsComun['fecha']);?>&nbsp;</font></td>
				<td><font size="1" face="Geneva, Arial, Helvetica">&nbsp;<? echo $filsEmp['nombre_emp']." ".$filsEmp['ape_pat']." ".$filsEmp['ape_mat'];?>&nbsp;</font></td>
				<td><font size="1" face="Geneva, Arial, Helvetica">&nbsp;<? echo $filsComun['titulo'];?>&nbsp;</font></td>
				<td><font size="1" face="Geneva, Arial, Helvetica">&nbsp;<?  echo $Curso_pal;?> &nbsp;</font></td>
			  </tr>
	  <? 	}
		} ?>
</table>
<br>
<table width="650" border="0" align="center">
  <tr bgcolor=#003b85> 
    <td colspan="4"><font color="#FFFFFF" size="2" face="Geneva, Arial, Helvetica">AUTORIZADAS</font></td>
  </tr>
  <tr bgcolor="#48d1cc"> 
    <td width="75"><font size="1" face="Geneva, Arial, Helvetica">FECHA </font></td>
    <td width="239"><font size="1" face="Geneva, Arial, Helvetica">DOCENTE</font></td>
    <td width="170"><font size="1" face="Geneva, Arial, Helvetica">TITULO</font></td>
    <td width="148"><font size="1" face="Geneva, Arial, Helvetica">CURSO</font></td>
  </tr>
  <? if(@pg_numrows($Rs_Comun2)!=0){
  		for($i=0;$i<@pg_numrows($Rs_Comun2);$i++){
			$filsComun = @pg_fetch_array($Rs_Comun2,$i);
			$sql="";
			$sql="SELECT empleado.nombre_emp, empleado.ape_pat,empleado.ape_mat FROM empleado WHERE rut_emp=".$filsComun['rut_emp'];
			$Rs_Emp = @pg_exec($conn,$sql);
			$filsEmp = @pg_fetch_array($Rs_Emp,0);
			$sql="";
			$sql = "select distinct matricula.id_curso from comun_alumno inner join matricula on comun_alumno.rut_alum=matricula.rut_alumno where id_comun=".$filsComun['id_comun'];
			$Rs_Curso = @pg_exec($conn,$sql);
			$filsCurso = @pg_fetch_array($Rs_Curso,0);
			$Curso_pal = CursoPalabra($filsCurso['id_curso'], 0, $conn); ?>
			<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaComunicacion.php?comunicacion=<?php echo $filsComun['id_comun'];?>&caso=1')>
    			<td><font size="1" face="Geneva, Arial, Helvetica">&nbsp;<? echo impF($filsComun['fecha']);?>&nbsp;</font></td>
				<td><font size="1" face="Geneva, Arial, Helvetica">&nbsp;<? echo $filsEmp['nombre_emp']." ".$filsEmp['ape_pat']." ".$filsEmp['ape_mat'];?>&nbsp;</font></td>
				<td><font size="1" face="Geneva, Arial, Helvetica">&nbsp;<? echo $filsComun['titulo'];?>&nbsp;</font></td>
				<td><font size="1" face="Geneva, Arial, Helvetica">&nbsp;<?  echo $Curso_pal;?> &nbsp;</font></td>
			  </tr>
	  <? 	}
		} ?>
</table>
</body>
</html>
