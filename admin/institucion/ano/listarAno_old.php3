<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
?>
<html>
	<head>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
	
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body>
	<?php //echo tope("../../../util/");?>
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
				<td colspan=4 align=right>
					<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
						<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="AGREGAR" onClick=document.location="seteaAno.php3?caso=2">
											<?php }?>
					<?php } //ACADEMICO Y LEGAL?>
					<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../seteaInstitucion.php3?caso=4">
				</td>
			</tr>
			<tr height="20" bgcolor="003b85">
				<td align="middle" colspan="4">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>TOTAL DE AÑOS ESCOLARES</strong>
					</font>
				</td>
			</tr>
			<tr bgcolor="#48d1cc">
				<td align="center" width="50">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>NUMERO</strong>
					</font>
				</td>
				<td align="center" width="150">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>FECHA INICIO</strong>
					</font>
				</td>
				<td align="center" width="150">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>FECHA TERMINO</strong>
					</font>
				</td>
				<td align="center" width="250">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>SITUACION</strong>
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
					for($i=0;$i < @pg_numrows($result);$i++){
						$fila = @pg_fetch_array($result,$i);
			?>
				<!--MODIFICAR Y DIRECCIONARLO A HISTORICO-->
				<?php if($fila['situacion']==0){//CERRADO?>
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaAno.php3?ano=<?php echo $fila["id_ano"];?>&caso=1')>
				<?php }?>
				<?php if($fila['situacion']==1){//ABIERTO
						if (($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=6)&&($_PERFIL!=2)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
							<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaAno.php3?ano=<?php echo $fila["id_ano"];?>&caso=1')>
					<? }else{ ?>	
							<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaAno.php3?ano=<?php echo $fila["id_ano"];?>&caso=1&from=1')>						
				<?php 	}
				}?>

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
							<td align="center">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
										<?php 
											switch ($fila['situacion']) {
												 case 0:
													 imp('CERRADO');
													 break;
												 case 1:
													 imp('ABIERTO');
													 break;
												 default:
													 imp('INDETERMINADO');
													 break;
											 };
										?>
								</font>
							</td>
						</tr>
			<?php
					}
				}
			?>
			<tr>
				<td colspan="4">
				<hr width="100%" color="#0099cc">
				</td>
			</tr>
			<tr>
				<td colspan=4 align=center>
					<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
						<tr>
							<td>
								<table WIDTH="100%" BORDER="0" CELLSPACING="3" CELLPADDING="3" bgcolor=white>
									<tr>
										<td>
											<font face="arial, geneva, helvetica" size="1" color=black>
												- Seleccionar presionando con el puntero del mouse sobre el año que corresponda.<br>
												- Para agregar un nuevo año presionar "AGREGAR". <br>
												- Para volver a la información de la institución presionar "VOLVER". <br>
												- Para abandonar la sesión de usuario presionar "CERRAR SESION". <br>
											</font>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</center>
	<? pg_close($conn); ?>
</body>
</html>