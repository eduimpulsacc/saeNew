<?php require('../../../../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$apoderado		=$_APODERADO;

	if ($RUT>0){
		$apoderado = $RUT;
		session_register('_APODERADO');
		$_APODERADO = $apoderado;
	   }

	$qry="select * from usuario where nombre_usuario='".trim($apoderado)."'";

	$result =@pg_Exec($conn,$qry);

	if (!$result) {
	error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
		if (pg_numrows($result)!=0){
			$fila1 = @pg_fetch_array($result,0);	
			if (!$fila1){
	error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			exit();
			}else{
			$idUsuario=trim($fila1['id_usuario']);
			};

		};

	};



	$_ID_USER	=	$idUsuario;

	if(!session_is_registered('_ID_USER')){

		session_register('_ID_USER');

	};

	//SI $idUsuario ES "" IMPLICA QUE NO EXISTE ESTE USUARIO REGISTRADO.

?> 

<HTML>

	<HEAD>

		<LINK REL="STYLESHEET" HREF="../../../../../../../util/td.css" TYPE="text/css">

		<SCRIPT language="JavaScript" src="../../../../../../../util/chkform.js"></SCRIPT>

		<SCRIPT language="JavaScript">

			function valida(form){

				return true;

			}

		</SCRIPT>

	    <link href="../../../../../../../util/objeto.css" rel="stylesheet" type="text/css">

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></HEAD>

<BODY background="../../../../../../../menu/docente/imag/fondomain.gif" leftmargin="75" >
<FORM method=post name="frm">

		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0>

			<TR height=15>

				<TD <?php if($idUsuario=="") { echo "colspan=4";}?>>

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

												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');

											}else{

												if (pg_numrows($result)!=0){

													$fila1 = @pg_fetch_array($result,0);	

													if (!$fila1){

														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');

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

						<TR>

							<TD align=left>

								<FONT face="arial, geneva, helvetica" size=2>

									<strong>APODERADO</strong>

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

											$qry="SELECT * FROM APODERADO WHERE RUT_APO='".$apoderado."'";

											$result =@pg_Exec($conn,$qry);

											if (!$result) {

												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');

											}else{

												if (pg_numrows($result)!=0){

													$fila1 = @pg_fetch_array($result,0);	

													if (!$fila1){

														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');

														exit();

													}

													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_apo']);

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

		<?php if($idUsuario!="") {//SI EL NOMBRE DE USUARIO YA ESTA REGISTRADO COMO USUARIO DE COE?>

			<TR height=15>

				<TD>

					<TABLE WIDTH="100%" height="100%" BORDER=0 align="left" CELLPADDING=5 CELLSPACING=5>
          <TR height="50" >

							<TD align=right colspan=2>

									<? if ($_TIPO_CLAVE==1){?>

									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name="button" TYPE="button" onClick=document.location="../../../../Claves.php" value="VOLVER">								  &nbsp;

									<? } else { ?>																		

									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../apoderado.php" >

									<? } ?>&nbsp;

							</TD>

						</TR>

						<TR height=20 bgcolor=#003b85>

							<TD align=center colspan=2>

								<FONT face="arial, geneva, helvetica" size=2 color=White>

									<strong>USUARIO</strong>

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

												<STRONG>NOMBRE USUARIO</STRONG>

											</FONT>

										</TD>

									</TR>

									<TR>

										<TD>

											<?php 

												imp(trim($apoderado));

											?>

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

													<STRONG>PERFILES DE ACCESO</STRONG>

												</FONT>

										</TD>

									</TR>

									<TR>

										<TD >

											<?php

													$qry="SELECT usuario.id_usuario, usuario.nombre_usuario, accede.estado, accede.rdb, perfil.id_perfil, perfil.nombre_perfil FROM (accede INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil) INNER JOIN usuario ON accede.id_usuario = usuario.id_usuario WHERE (((usuario.id_usuario)=".$idUsuario.") AND ((accede.rdb)=".$_INSTIT.")) ORDER BY NOMBRE_PERFIL ASC;";

													$result =@pg_Exec($conn,$qry);

													if (!$result) 

														error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');

													else{

														if (pg_numrows($result)!=0){

															$fila1 = @pg_fetch_array($result,0);	

															if (!$fila1){

																error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>');

																exit();

															};

															for($i=0 ; $i < @pg_numrows($result) ; $i++){

																$fila1 = @pg_fetch_array($result,$i);

																echo "- ".$fila1["nombre_perfil"];

																	if($fila1["estado"]==1)

																		if(($_PERFIL==15)||($_PERFIL==16)){//APODERADO O ALUMNO

																			echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=button value=off onClick=document.location='onoffPerfil.php3?estado=1&perfil=".$fila1["id_perfil"]."&usuario=".$fila1["id_usuario"]."' disabled ><BR>";

																			}else{

																				echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=button value=off onClick=document.location='onoffPerfil.php3?estado=1&perfil=".$fila1["id_perfil"]."&usuario=".$fila1["id_usuario"]."'><BR>";

																			}

																		else

																			if(($_PERFIL==15)||($_PERFIL==16)){//APODERADO O ALUMNO

																				echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=button value=on onClick=document.location='onoffPerfil.php3?estado=0&perfil=".$fila1["id_perfil"]."&usuario=".$fila1["id_usuario"]."' disabled ><BR>";

																				}else{

																					echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=button value=on onClick=document.location='onoffPerfil.php3?estado=0&perfil=".$fila1["id_perfil"]."&usuario=".$fila1["id_usuario"]."'><BR>";

																				}

															}

														}

												};

											?>

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

						<TR height=15>

						

							<TD width="100%" colspan=2 align=left>

								<INPUT TYPE="button" class="botonZ" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="CAMBIAR CLAVE" onClick=document.location="claveAcceso.php">

								<?php if(($_PERFIL==0)||($_PERFIL==14)||($_PERFIL==1)){//ADMINISTRADOR TOTAL O ADMINISTRADOR WEB?>

									<INPUT TYPE="button" class="botonZ" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="AGREGAR PERFIL" onClick=document.location="addPerfil.php">

								<?php 

									

								}?>

							</TD>

						</TR>

		<?php }else{ //EMPLEADO SIN ACCESO WEB?>

						<TR>

							<TD width=30></TD>

							<TD colspan=3>

								<center><BR><BR><BR><BR>

									USUARIO SIN ACCESO WEB <BR>

									<INPUT TYPE="button" class="botonZ" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="CREAR CUENTA" onClick=document.location="creaAcceso.php"<?php if(($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=1)){echo " disabled ";}?>>&nbsp;

								</center>

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

									<TR>

										
                  <TD align=right> 
                    <? if ($_TIPO_CLAVE==1){?>
                    &nbsp; 
                    <? } else { ?>
                    <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../apoderado.php" >
                    <input class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' name="button2" type="button" onClick=document.location="../../../../Claves.php" value="VOLVER"> 
                    <? } ?>
                    &nbsp; </TD>

									</TR>

								</TABLE>

							</TD>

						</TR>

					<?php }?>

					</TABLE>

				</TD>

			</TR>

		</TABLE>

	</FORM>

</BODY>

</HTML>