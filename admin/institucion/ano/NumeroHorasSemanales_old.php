<?php require('../../../util/header.inc');?>
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
			
			<SCRIPT LANGUAGE="JavaScript">
			<!--
				function valida(form){
					for (x=0;x<=form.length-1;x++){
						if (form[x].name.substr(0,5)=="horas"){
							if(!chkVacio(form[x],'Debe ingresar cantidad de horas para este subsector')){
								return false;
							};
						};
					};
					for (x=0;x<=form.length-1;x++){
						if (form[x].name.substr(0,5)=="horas"){
							if(!nroOnly(form[x],'Debe ingresar un número válido')){
								return false;
							};
						};
					};				
					return true;
				};
</SCRIPT>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	//------------------
	$sql = "SELECT DISTINCT ramo.cod_subsector, subsector.nombre ";
	$sql = $sql . "FROM ramo, subsector, curso ";
	$sql = $sql . "WHERE curso.id_ano = $ano and ramo.id_curso = curso.id_curso and ramo.cod_subsector = subsector.cod_subsector ";
	$sql = $sql . "ORDER BY ramo.cod_subsector; ";
	//------------------
	$resultado_query= pg_exec($conn,$sql);
	if (!$resultado_query){ echo "ERROR: $sql"; exit;}	
	$total_filas= pg_numrows($resultado_query);	
	//------------------
	
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<center>
<FORM method=post name="frm" action="procesoHoras.php">
<input type="hidden" name="NumeroSubsectores" value="<? echo $total_filas?>">
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td>
		<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
			<TR>
				<TD align=left>
					<FONT face="arial, geneva, helvetica" size=2>
						<strong>INSTITUCION</strong>
					</FONT>
				</TD>
				<TD>
					<FONT face="arial, geneva, helvetica" size=2>
						<strong>:</strong>
					</FONT>
				</TD>
				<TD>
					<FONT face="arial, geneva, helvetica" size=2>
						<strong>
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
						</strong>
					</FONT>
				</TD>
			</TR>
			<TR>
				<TD align=left>
					<FONT face="arial, geneva, helvetica" size=2>
						<strong>AÑO ESCOLAR</strong>
					</FONT>
				</TD>
				<TD>
					<FONT face="arial, geneva, helvetica" size=2>
						<strong>:</strong>
					</FONT>
				</TD>
				<TD>
					<FONT face="arial, geneva, helvetica" size=2>
						<strong>
							<?php
								$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
								$result =@pg_Exec($conn,$qry);
								if (!$result) {
									error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
								}else{
									if (pg_numrows($result)!=0){
										$fila = @pg_fetch_array($result,0);	
										if (!$fila){
											error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
											exit();
										}
										echo trim($fila['nro_ano']);
									}
								}
							?>
						</strong>
					</FONT>
				</TD>
			</TR>
		</TABLE>
		<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="right">
	  <? IF(($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=6)){ ?>
 		  <? if ($accion==1){?>
			  <INPUT name="button" TYPE="button" class="botonX" onClick=document.location="NumeroHorasSemanales.php?accion=2" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="MODIFICAR">
          <? } ?>
		  <? if ($accion==2){?>
			  <INPUT name="button" TYPE="submit" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'  value="GUARDAR" onClick="return valida(this.form);">		  	
		  <? } ?>
	  <? } ?>
    <? if ($accion==1){?>
	  <INPUT name="button2" TYPE="button" class="botonX" onClick=document.location="ano_escolar.php3" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER">	
	<? } else { ?>
	  <INPUT name="button2" TYPE="button" class="botonX" onClick=document.location="NumeroHorasSemanales.php?accion=1" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER">
	 <? } ?>
	</td>
  </tr>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr height="20" bgcolor="#003b85">
    <td align="center"><font face="arial, geneva, helvetica" size="2" color="#ffffff"><strong>N&Uacute;NERO DE HORAS SEMANALES POR SUBSECTOR </strong></font></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr bgcolor="#48d1cc">
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>C&Oacute;DIGO SUBSECTOR </strong></font></td>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>NOMBRE SUBSECTOR </strong></font></td>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>N&Uacute;MERO DE HORAS SEMANALES </strong></font></td>
  </tr>
<?
for ($j=0; $j < $total_filas; $j++)
{
	$fila = @pg_fetch_array($resultado_query,$j);
?>
  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila["cod_subsector"];?>
      <input type="hidden" name="subsector[<? $j?>]" value="<? echo $fila["cod_subsector"]?>">
    </strong></font></td>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila["nombre"];?></strong></font></td>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>
	<? 
	//-------
	$sql="select * from horas_subsectores where cod_subsector = ".$fila["cod_subsector"]. " and id_ano = $ano";
	$resultado_horas = pg_exec($conn,$sql);
	$fila_horas = @pg_fetch_array($resultado_horas,0);
	//------
	?>
      <? if ($accion==2){?><input name="horas[<? echo $j ?>]" type="text" size="10" maxlength="10" value="<? echo $fila_horas['horas'];?>"><? } ?>
	  <? if ($accion==1){?><? echo $fila_horas['horas']."&nbsp;" ?><? } ?>
    </strong></font></td>
  </tr>
 <? } ?>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><hr width="100%" color="#003b85"></td>
  </tr>
</table>


</td>
 </tr>
  <tr>
    <td align="center"><table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
      <tr>
        <td>
          <table WIDTH="100%" BORDER="0" CELLSPACING="3" CELLPADDING="3" bgcolor=white>
            <tr>
              <td> <font face="arial, geneva, helvetica" size="1" color=black> - Para poder cambiar el n&uacute;mero de horas semanales para los subsectores, solo debe hacer click en modificar <br>
            <br>
              </font> </td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>		

</form>
</center>
</body>
</html>
