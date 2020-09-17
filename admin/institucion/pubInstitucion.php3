<?php 
	require('../../util/header.inc');
	$institucion	=$_INSTIT;
	if(strcmp($frmModo,"ingresar")){
		$qry2	="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
		$result2	= @pg_Exec($conn,$qry2);
		if (!$result2) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result2)!=0){//En caso de estar el arreglo vacio.
				$fila2 = @pg_fetch_array($result2,0);	
				if (!$fila2){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}else{
					$_TIPOINSTIT = $fila2["tipo_instit"];
					if(!session_is_registered('_TIPOINSTIT')){
						session_register('_TIPOINSTIT');
					};
				}
			}
		}
	}
?>
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../util/td.css" TYPE="text/css">
		<?php if($frmModo!="mostrar"){ ?>
			<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
		<?php };?>
	</HEAD>
<BODY>
	<?php echo tope("../../util/");?>
	<FORM method=post name="frm" action="procesoInstitucion.php3">
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<tr>
							<td colspan=2 align=right>
								<INPUT TYPE="button" value="VOLVER" onClick=document.location="seteaInstitucion.php3?caso=4">
							</td>
						</tr>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>INSTITUCION</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
							<INPUT TYPE="button" value="ACTIVIDADES" name=btnCancelar>&nbsp;
							<INPUT TYPE="button" value="DIARIO ELECTRONICO" name=btnCancelar>&nbsp;
							<INPUT TYPE="button" value="AGENDA WEB" name=btnCancelar>&nbsp;
							</TD>
						</TR>
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#0099cc>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR></TABLE></FORM></BODY></HTML>