<?php require('../../../../../util/header.inc');
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
	
	$qry ="";
	$qry ="SELECT b.id_curso FROM ficha_psicologica a inner join matricula b on a.rut_alum=b.rut_alumno  WHERE a.id_ano=" . $ano . " group by id_curso";
	$Rs_Curso = @pg_exec($conn,$qry);
	if (!$Rs_Curso) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}	
	
	if($caso==1){
		$qry="select distinct a.* from alumno a inner join matricula b on a.rut_alumno=b.rut_alumno inner join ficha_psicologica c on b.rut_alumno=c.rut_alum where id_curso=" . $id_curso;
		$Rs_Alumno =@pg_Exec($conn,$qry);
		if (!$Rs_Alumno) {
			error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
		}		
	}
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
</head>

<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="2"><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
        <TR> 
          <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> 
            </FONT> </TD>
          <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
            </FONT> </TD>
          <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
            <?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												}
											}
										?>
            </strong> </FONT> </TD>
        </TR>
        <TR> 
          <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>AÑO</strong> 
            </FONT> </TD>
          <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
            </FONT> </TD>
          <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
            <?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
												}
											}
										?>
            </strong> </FONT> </TD>
        </TR>
      </TABLE></td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr> 
    <td bgcolor="#003b85" colspan="2"><div align="center"><font color="#FFFFFF" size="2" face="Geneva, Arial, Helvetica, sans-serif"><strong>LISTADO DE CURSOS</strong></font></div></td>
  </tr>
  <tr>
   	<td bgcolor="#48d1cc"><font face="Geneva, Arial, Helvetica, sans-serif" size="1">CANTIDAD ALUMNOS</font></td>
	<td bgcolor="#48d1cc"> <font face="Geneva, Arial, Helvetica, sans-serif" size="1">CURSO</font></td>
  </tr>
  <? if(@pg_numrows($Rs_Curso)!=0){
  		for($i=0;$i<@pg_numrows($Rs_Curso);$i++){
			$fila = @pg_fetch_array($Rs_Curso,$i);
			$id_curso = $fila['id_curso'];
			$Curso_pal = CursoPalabra($id_curso, 1, $conn);
		$qry="";
		$qry = "SELECT distinct a.rut_alum FROM ficha_psicologica a inner join matricula b on a.rut_alum=b.rut_alumno  WHERE b.id_curso=" . $id_curso ." and a.id_ano=" . $ano;
		$Rs_cantidad = @pg_exec($conn,$qry);
		$fils = @pg_fetch_array($Rs_cantidad,$i);
		$Cuenta = @pg_numrows($Rs_cantidad);
	?>
  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('listadoCurso.php?id_curso=<?php echo $id_curso;?>&caso=1')>
    <td><font face="Geneva, Arial, Helvetica, sans-serif" size="1"><? echo $Cuenta;?></font></td>
	<td><font face="Geneva, Arial, Helvetica, sans-serif" size="1"><? echo $Curso_pal;?></font></td>
  </tr>
  <? } } ?>
</table>
<br>
<? if($caso==1){?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td bgcolor="#003b85" colspan="3"><div align="center"><font color="#FFFFFF" size="2" face="Geneva, Arial, Helvetica, sans-serif"><strong>LISTADO DE ALUMNOS</strong></font></div></td>
  </tr>
  <tr> 
    <td bgcolor="#48d1cc"><font size="1" face="Geneva, Arial, Helvetica, sans-serif">RUT</font></td>
    <td bgcolor="#48d1cc"><font size="1" face="Geneva, Arial, Helvetica, sans-serif">NOMBRE ALUMNO</font></td>
  </tr>
  <? for($j=0;$j<@pg_numrows($Rs_Alumno);$j++){
  		$fila1 =@pg_fetch_array($Rs_Alumno,$j);
  ?>
  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaFicha.php?alumno=<?php echo $fila1['rut_alumno'];?>&caso=5')>
    <td><font face="Geneva, Arial, Helvetica, sans-serif" size="1"><? echo $fila1['rut_alumno']. " - " . $fila1['dig_rut'];?></font></td>
    <td><font face="Geneva, Arial, Helvetica, sans-serif" size="1"><? echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']); ?></font></td>
  </tr>

<? }
	} ?>
</table>
</body>
</html>
