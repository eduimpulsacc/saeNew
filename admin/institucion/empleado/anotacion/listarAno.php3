<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
?>
<html>
	<head>
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
	</head>
<body>
	<?php echo tope("../../../../util/");?>
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD COLSPAN=3>
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
					</TABLE>
				</TD>
			</TR>
			<tr>
				<td colspan=3 align=right>
					<!--INPUT TYPE="button" value="VOLVER" onClick=document.location="../seteaInstitucion.php3?caso=4"-->
				</td>
			</tr>
			<tr height="20" bgcolor="#0099cc">
				<td align="middle" colspan="3">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>TOTAL DE AÑOS ACADEMICOS</strong>
					</font>
				</td>
			</tr>
			<tr bgcolor="#48d1cc">
				<td align="center" width="40">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>NUMERO</strong>
					</font>
				</td>
				<td align="center" width="280">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>FECHA INICIO</strong>
					</font>
				</td>
				<td align="center" width="280">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>FECHA TERMINO</strong>
					</font>
				</td>
			</tr>
			<?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
			?>
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('listarAlumnos.php3?anoSeleccionado=<?php echo $fila["id_ano"];?>&caso=1')>
							<td align="right" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["nro_ano"];?></strong>
								</font>
							</td>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
										<?php impF($fila["fecha_inicio"]);?>
									</strong>
								</font>
							</td>
							<td align="center">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
										<?php impF($fila["fecha_termino"]);?>
								</font>
							</td>
						</tr>
			<?php
					}
				}
			?>
			<tr>
				<td colspan="3">
				<hr width="100%" color="#0099cc">
				</td>
			</tr>
		</table>
	</center>
</body>
</html>