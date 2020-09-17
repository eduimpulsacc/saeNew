<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	if($agrupacion!=""){
		$_AGRUPACION	=	$agrupacion;
		if(!session_is_registered('_AGRUPACION')){
			session_register('_AGRUPACION');
		};
		}else{
			$agrupacion	=	$_AGRUPACION;
	};
?>
<html>
	<head>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
	</head>
<body>
	<?php echo tope("../../../util/");?>
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
			<?php
				$qry="SELECT * FROM AGRUPACION WHERE ID_AGRUPACION=".$agrupacion;
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila1 = @pg_fetch_array($result,0);	
					}
				}
			?>
			<tr>
				<td colspan=3 align=right>
					<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
						<INPUT TYPE="button" value="AGREGAR" onClick=document.location="seteaNoticia.php3?caso=2">
											<?php }?>
					<?php }?>

					<?php if($fila1['id_agrupacion']==1){?>
						<INPUT TYPE="button" value="VOLVER" onClick=document.location="../seteaInstitucion.php3?caso=1">
					<?php }?>
					<?php if($fila1['id_agrupacion']==2){?>
						<INPUT TYPE="button" value="VOLVER" onClick=document.location="../centroPadres.php3?caso=1">
					<?php }?>
					<?php if($fila1['id_agrupacion']==3){?>
						<INPUT TYPE="button" value="VOLVER" onClick=document.location="../centroAlumnos.php3?caso=1">
					<?php }?>
					<?php if($fila1['id_agrupacion']==4){?>
						<INPUT TYPE="button" value="VOLVER" onClick=document.location="../webScout.php3?caso=1">
					<?php }?>
					<?php if($fila1['id_agrupacion']==5){?>
						<INPUT TYPE="button" value="VOLVER" onClick=document.location="../centroPastoral.php3?caso=1">
					<?php }?>
					<?php if($fila1['id_agrupacion']==6){?>
						<INPUT TYPE="button" value="VOLVER" onClick=document.location="../exalumnos.php3?caso=1">
					<?php }?>
				</td>
			</tr>
			<tr height="20" bgcolor="#0099cc">
				<td align="middle" colspan="3">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>NOTICIA <?php echo trim($fila1['nombre_agrupacion'])?></strong>
					</font>
				</td>
			</tr>
			<tr bgcolor="#48d1cc">
				<td align="center" width="100">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>FECHA</strong>
					</font>
				</td>
				<td align="center" width="400">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>TITULAR</strong>
					</font>
				</td>
				<td align="center" width="100">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>ESTADO</strong>
					</font>
				</td>
			</tr>
			<?php
				$qry="SELECT * FROM NOTICIA WHERE RDB=".$institucion." AND AGRUPACION=".$agrupacion;
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
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaNoticia.php3?noticia=<?php echo $fila["id_noticia"];?>&caso=1')>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
										<?php impF($fila["fecha_pub"]);?>
										
									</strong>
								</font>
							</td>
							<td align="left">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["titular"];?></strong>
								</font>
							</td>
							<td align="center">
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
										<?php 
											switch ($fila["estado"]) {
												 case 0:
													 imp('NO PUBLICADA');
													 break;
												 case 1:
													 imp('PUBLICADA');
													 break;
											 };

										?>
									</strong>
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