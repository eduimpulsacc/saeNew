<?php require('../../../util/header.inc');?>
<?php 
if ($caso==1) {
    $_FRMMODO="ingresar";
	           
}else
if ($caso==3) {
   $_FRMMODO="grabar";
}


	$institucion	=$_INSTIT;
	$solicitud		=$_SOLICITUD;
	$frmModo		=$_FRMMODO;

if($frmModo=="grabar"){
$qry="insert into solicitud values ('$institucion',(select count(*)+1 from solicitud where rdb=$institucion),'$FECHA_PUB','$FECHA_CAD','$TITULAR','$CONTENIDO','$ESTADO')";
$result =@pg_Exec($conn,$qry);
if (!$result) {
	error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
}

?>
	<script>window.location='listarSolicitudes.php'</script>
<?php
	
}

?>

<?php
	if($frmModo=="ingresar"){

	$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
	$result =@pg_Exec($conn,$qry);
	if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	else	
		if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						exit();
				}
		}

?>
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../../util/td.css" TYPE="text/css">
	</HEAD>
<BODY >
	<FORM method=post name="frm" action="solicitud.php?caso=3">
			<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR>
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
									<strong><?echo $fila1['nombre_instit']  ;?></strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
								<TD align=right colspan=2>
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarSolicitudes.php">
              &nbsp; 
              <?php if ($_PERFIL==0){?>
              <?php } ?>
            </TD>
							</TR>
						<TR height=20 bgcolor=#0099cc>
								<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>SOLICITUD</strong>
								</FONT>
							</TD>
							</TR>
						<TR>
							<TD width=30></TD>
								<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA PUBLICACION</STRONG>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												
<STRONG>FECHA TERMINO PUBLICACION</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<input type=text name="FECHA_PUB" size=8 maxlength=10>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
										</td><td>	
												<input type=text name="FECHA_CAD" size=8 maxlength=10>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>

										</TD>
									</TR>
								</TABLE>
							</TD>
							</TR>
						<TR>
							<TD width=30></TD>
								<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>TITULAR</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
																							<INPUT type="text" name=TITULAR size=80 maxlength=100>
																																											</TD>
									</TR>
								</TABLE>
							</TD>
							</TR>
						<TR>
							<TD width=30></TD>
								<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									
									<TR>
										<TD>
											
																																</TD>
									</TR>
								</TABLE>
							</TD>
							</TR>
						<TR>
							<TD width=30></TD>
								<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>CONTENIDO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
																							<textarea name="CONTENIDO" cols="60" rows="5"></textarea>
																																											</TD>
									</TR>
								</TABLE>
							</TD>
							</TR>
						<TR>
							<TD width=30></TD>
								<TD align=right>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>ESTADO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD><select name="estado" size="1">
													
<option value="1">Habilitar</option>
													
<option value="2">Deshabilitar</option>
												</select></TD>
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
						<TR height=15>
								<TD width="100%" colspan=2>
							</TD>
							</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
		</FORM>
</BODY>
</HTML>
<?php
}
?>