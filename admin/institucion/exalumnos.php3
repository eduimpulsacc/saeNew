<?php 
	require('../../util/header.inc');
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;

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
		<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtREP,'Ingresar REPRESENTANTE.')){
					return false;
				};

				if(!alfaOnly(form.txtREP,'Se permiten sólo caracteres alfanuméricos en el campo REPRESENTANTE.')){
					return false;
				};
				
				if(form.txtEMAIL.value!=''){
					if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
						return false;
					};
				};
				
				return true;
			}
		</SCRIPT>
	</HEAD>
<BODY>
	<?php echo tope("../../util/");?>
	<FORM method=post name="frm" action="procesoEX.php3">
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR >
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
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<tr>
							<td colspan=2 align=right>
								<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
						<?php if(($_PERFIL==1)||($_PERFIL==14)||($_PERFIL==0)||($_PERFIL==18)){ //DIRECTOR GENERAL , ADM WEB COLEGIO, ADM TOTAL WEB?>
										<?php if($_FRMMODO=="mostrar"){ ?>
											<INPUT TYPE="button" value="MODIFICAR" onClick=document.location="seteaEX.php3?caso=3">
										<?php }?>
										<?php if($_FRMMODO=="modificar"){ ?>
											<INPUT TYPE="submit" value="GUARDAR" onclick="return valida(this.form);">&nbsp;
											<INPUT TYPE="button" value="CANCELAR" onClick=document.location="seteaEX.php3?caso=1">
										<?php }?>
									<?php }?>
								<?php }?>
								<?php if($_PERFIL!=18){?>
									<INPUT TYPE="button" value="VOLVER" onClick=document.location="seteaInstitucion.php3?caso=4">
								<?php }?>
							</td>
						</tr>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>EXALUMNOS</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD colspan=3>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>REPRESENTANTE</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtREP size=83 maxlength=100>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila1['repex']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtREP size=83 maxlength=50 value="<?php echo $fila1['repex']?>">
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD colspan=3>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>E-MAIL</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtEMAIL size=83 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila1['emailex']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtEMAIL size=83 maxlength=50 value="<?php echo $fila1['emailex']?>">
											<?php };?>
										</TD>
									</TR>
								</TABLE>
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
						<TR>
							<TD width=30></TD>
							<TD> 
							<INPUT TYPE="button" value="DIARIO ELECTRONICO"   name=btnCancelar onClick=document.location="noticia/listarNoticia.php3?agrupacion=6">
							<INPUT TYPE="button" value="AGENDA WEB" name=btnCancelar name=btnCancelar onClick=document.location="agenda/listarAgenda.php3?agrupacion=6">
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
</BODY>
</HTML>