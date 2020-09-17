<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
?>
<html>
	<head>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
	</head>
<body>
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR>
				<TD COLSPAN=2>
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
				<td colspan=2 align=right>
					<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
						<INPUT TYPE="button" value="AGREGAR" onClick=document.location="seteaLibro.php3?caso=2">
											<?php }?>
					<?php } //ACADEMICO Y LEGAL?>
					<?php if($_PERFIL!=7){?>
						<INPUT TYPE="button" value="VOLVER" onClick=document.location="../seteaInstitucion.php3?caso=4">
					<?php }?>
				</td>
			</tr>
			<tr height="20" bgcolor="#0099cc">
				<td align="middle" colspan="3">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>TOTAL DE LIBROS</strong>
					</font>
				</td>
			</tr>
			<tr bgcolor="#48d1cc">
				<td align="center" width="100">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>ISBN</strong>
					</font>
				</td>
				<td align="center" width="500">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>TITULO</strong>
					</font>
				</td>
			</tr>
			<?php
				$qry="SELECT * FROM libro WHERE RBD=".$institucion;
				$result=@pg_Exec($conn,$qry);
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
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaLibro.php3?libro=<?php echo $fila["id"];?>&caso=1')>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["isbn"];?></strong>
								</font>
							</td>
							<td align="left" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["titulo"];?></strong>
								</font>
							</td>
						</tr>
			<?php
					}
				}
			?>
			<tr>
				<td colspan="2">
				<hr width="100%" color="#0099cc">
				</td>
			</tr>
		</table>
	</center>
</body>
</html>