<?php require('../../../util/header.inc');?>
<html>
	<head>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
	</head>
<body>
	<?php echo tope("../../../util/");?>
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR>
				<TD COLSPAN=5>
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
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$_INSTIT;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
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
					<INPUT TYPE="button" value="AGREGAR" onClick=document.location="seteaRemate.php3?caso=2">
					<INPUT TYPE="button" value="VOLVER" onClick=document.location="../seteaInstitucion.php3?caso=1">
				</td>
			</tr>
			<tr height="20" bgcolor="#0099cc">
				<td align="middle" colspan="3">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>MARKET PLACE</strong>
					</font>
				</td>
			</tr>
			<tr bgcolor="#48d1cc">
				<td align="center" width="80">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>FECHA INICIO</strong>
					</font>
				</td>
				<td align="center" width="80">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>FECHA TERMINO</strong>
					</font>
				</td>
				<td align="center" width="340">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>TITULAR</strong>
					</font>
				</td>
			</tr>
			<?php
				$qry="select * from remate where rdb=".$_INSTIT;
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
				}else{
					if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
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
				<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaRemate.php3?remate=<?php echo $fila["id_remate"];?>&caso=1')>
					<td align="CENTER" >
						<font face="arial, geneva, helvetica" size="1" color="#000000">
							<strong><?php impF($fila["fecha_i"])?></strong>
						</font>
					</td>
					<td align="CENTER" >
						<font face="arial, geneva, helvetica" size="1" color="#000000">
							<strong><?php impF($fila["fecha_t"])?></strong>
						</font>
					</td>
					<td align="LEFT">
						<font face="arial, geneva, helvetica" size="1" color="#000000">
							<strong><?php imp($fila["titular"])?></strong>
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