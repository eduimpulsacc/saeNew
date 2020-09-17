<?php require('../util/header.inc');
	$institucion	=$_INSTIT;
//	$frmModo		=$_FRMMODO;
	$frmModo		="mostrar";
	$curso			=$_CURSO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;

$_POSP=2;


	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
	
		<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
/*				if(!chkVacio(form.txtFECHAATE,'Ingresar FECHA ATENCION.')){
					return false;
				};

				if(!chkFecha(form.txtFECHAATE,'FECHA ATENCION invalida.')){
					return false;
				};
*/
				if(!chkVacio(form.txtFECHAPROXATE,'Ingresar FECHA PROXIMA ATENCION.')){
					return false;
				};

				if(!chkFecha(form.txtFECHAPROXATE,'FECHA PROXIMA ATENCION invalida.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
		<SCRIPT language="JavaScript">
			function jmpFicha(form){
				document.location = "seteaFichaMed.php3?caso=1&ficha=" + form.txtFECHAATE.value;
//				return false;
			}
		</SCRIPT>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../Sea/cortes/b_ayuda_r.jpg','../Sea/cortes/b_info_r.jpg','../Sea/cortes/b_mapa_r.jpg','../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->
								  
								  
								  
	<? 
	
	
	
	
	
	
	
	
	
	
	
	$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ficha_medica.fecha_atencion, ficha_medica.id_ficha FROM ficha_medica INNER JOIN alumno ON ficha_medica.rut_alumno = alumno.rut_alumno WHERE alumno.rut_alumno='".$alumno."'";
	$result =pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
	}else{
		if (pg_numrows($result)!=0){
			$fila = pg_fetch_array($result,0);	
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
				exit();
			}
		}
	}

	if($fila['id_ficha']!=""){
		$qry="SELECT * FROM FICHA_MEDICA WHERE ID_FICHA=".$fila['id_ficha']." ORDER BY FECHA_ATENCION DESC";
		$result =pg_Exec($conn,$qry);
		if (!$result){
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
		}else{
			if (pg_numrows($result)!=0){
				$fila = pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$qry);
					exit();
				}
			}
		}
	
	
	
	
	
	
	
	
	
	
	
	
	
	?>							  
	<CENTER>
		<TABLE BORDER=0 WIDTH=600>
			<TR valign=top>
				<TD COLSPAN=2>
					<!--<IMG src="../img/topSalud.jpg" width=650>-->
				</TD>	
			</TR>
			<TR valign=top>
				<TD>
					<!--<IMG src="../img/izquierda.jpg" width=75>-->
				</TD>
				<TD width=800>

	<FORM method=post name="frm">
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width=100%>
						<TR>
							<TD width="18%" align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>
								</FONT>
							</TD>
							<TD width="2%">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD width="45%">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
							<td width="35%" rowspan=4>
								<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=5>
                        <TR>
										<TD>
											<?php
												$result = @pg_Exec($conn,"select * from alumno where rut_alumno=".$alumno);
												$arr=@pg_fetch_array($result,0);

												$output= "select lo_export(".$arr[foto].",'/var/www/html/tmp/".$arr[rut_alumno]."');";
												$retrieve_result = @pg_exec($conn,$output);
											?>
											<!--<img src=../../tmp/<?php //echo $arr[rut_alumno] ?> ALT="NO DISPONIBLE" width=150>-->
										</TD>
									</TR>
								</TABLE>
							</td>
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
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
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
									<strong>CURSO</strong>
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
						 	// --- se agrego al query "tipo_ensenanza.cod_tipo" (pmeza) -----------
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo,tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
							// ---------------------------------------------------------------------
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
													echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													$tipo=$fila1['cod_tipo'];
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
									<strong>ALUMNO</strong>
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
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
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
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat'])." ".trim($fila1['nombre_alu']);
													
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
                  <TR height="50" >
							<TD align=right colspan=2>&nbsp;
							</TD>
					  </TR>
						<TR height=20 bgcolor=#0099cc>
							
                    <TD colspan=2 align=middle class="tableindex">FICHA MEDICA</TD>
						</TR>

						<TR>
							<TD colspan=3 align=center>
								<TABLE WIDTH="75%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA DE ATENCION<BR>DEL ESPECIALISTA</STRONG>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA PROXIMO<BR>CONTROL</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtFECHAATE size=10 maxlength=10 onChange="chkFecha(form.txtFECHAATE,'Fecha atencion invalida.');">
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_atencion']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtFECHAATE size=10 maxlength=10 onChange="chkFecha(form.txtFECHAATE,'Fecha atencion invalida.');"  value="<?php impF($fila['fecha_atencion'])?>">
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtFECHAPROXATE size=10 maxlength=10 onChange="chkFecha(form.txtFECHAPROXATE,'Fecha proximo control invalida.');">
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_prox_at']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtFECHAPROXATE size=10 maxlength=10 onChange="chkFecha(form.txtFECHAPROXATE,'Fecha proximo control invalida.');"  value="<?php impF($fila['fecha_prox_at'])?>">
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						
						<TR>
							<!--TD width=30></TD-->
							<TD>

								<TABLE width=100% Border=0 cellpadding=0 cellspacing=0>
									<TR>
										<TD width=30></TD>
										<TD>
											<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=left height=10>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>&nbsp;&nbsp;OFTALMOLOGIA</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<TABLE width=100% height=100% bgcolor=White BORDER=0>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk1">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_alta'],"chk1");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_alta'],"chk1");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ALTA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk2">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_en_estudio'],"chk2");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_en_estudio'],"chk2");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>EN ESTUDIO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk3">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_hipermetropia'],"chk3");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_hipermetropia'],"chk3");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>HIPERMETROPIA</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk4">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_miopia'],"chk4");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_miopia'],"chk4");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>MIOPIA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk5">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_astigmatismo_miope'],"chk5");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_astigmatismo_miope'],"chk5");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ASTIGMATISMO MIOPE</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk6">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_astigmatismo_hipermetrope'],"chk6");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_astigmatismo_hipermetrope'],"chk6");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ASTIGMATISMO HIPERMETROPE</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk7">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_astigmatismo_mixto'],"chk7");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_astigmatismo_mixto'],"chk7");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ASTIGMATISMO MIXTO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk8">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_astigmatismo_miopito_comp'],"chk8");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_astigmatismo_miopito_comp'],"chk8");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ASTIGMATISMO MIOPITO COMP</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk9">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_astigmatismo_hipermetria_c'],"chk9");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_astigmatismo_hipermetria_c'],"chk9");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ASTIGMATISMO HIPERMETRIA COMP</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk10">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_anisometropia'],"chk10");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_anisometropia'],"chk10");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ANISOMETROPIA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk11">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_estrabismo'],"chk11");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_estrabismo'],"chk11");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ESTRABISMO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk12">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_influencia_convergencia'],"chk12");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_influencia_convergencia'],"chk12");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>INFLUENCIA CONVENGENCIA</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2></TD>
																			<TD width="33%" align=right>
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>OTRO</STRONG>
																				</FONT>
																			</TD>
																			<TD COLSPAN=5 align=left>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						imp($fila['of_otros_desc']);	
																					};
																				?>
																				<?php if($frmModo=="modificar"){ ?>
																						<INPUT TYPE="text" NAME="of_otros_desc" size=50 value="<?php echo $fila['of_otros_desc']?>">
																				<?php }; ?>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%" align=center>
																	<HR width="80%" color=black><BR>
																	<FONT face="arial, geneva, helvetica" size=2>
																		<strong>INDICACIONES</strong>
																	</FONT>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox"  NAME="chk14">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_lentes_primera_vez'],"chk14");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_lentes_primera_vez'],"chk14");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>LENTES PRIMERA VEZ</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk15">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_cambiar_lentes'],"chk15");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_cambiar_lentes'],"chk15");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CAMBIAR LENTES</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk16">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_mantener_lentes'],"chk16");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_mantener_lentes'],"chk16");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>MANTENER LENTES</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk17">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_estudio_estrabismo'],"chk17");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_estudio_estrabismo'],"chk17");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ESTUDIO ESTRABISMO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk18">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_ejercicios_opticos'],"chk18");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_ejercicios_opticos'],"chk18");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>EJERCICIOS OPTICOS</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk19">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_cirugia'],"chk19");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_cirugia'],"chk19");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CIRUGIA</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2></TD>
																			<TD width="33%" align=right>
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>OTRO</STRONG>
																				</FONT>
																			</TD>
																			<TD COLSPAN=5 align=left>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						imp($fila['of_otros_desc_indic']);	
																					};
																				?>
																				<?php if($frmModo=="modificar"){ ?>
																						<INPUT TYPE="text" NAME="of_otros_desc_indic" size=50 value="<?php echo $fila['of_otros_desc_indic']?>">
																				<?php }; ?>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
														</TABLE>
													</TD>
												</TR>
											</TABLE>						
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<!--TD width=30></TD-->
							<TD>
								<TABLE width=100% Border=0 cellpadding=0 cellspacing=0>
									<TR>
										<TD width=30></TD>
										<TD>
											<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=left height=10>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>&nbsp;&nbsp;OTORRINO</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<TABLE width=100% height=100% bgcolor=White BORDER=0>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk21">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_alta'],"chk21");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_alta'],"chk21");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ALTA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk22">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_en_estudio'],"chk22");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_en_estudio'],"chk22");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>EN ESTUDIO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk23">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_agenesia_pabellon'],"chk23");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_agenesia_pabellon'],"chk23");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>AGENESIA PABELLON</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk24">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_cerumen_impactado'],"chk24");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_cerumen_impactado'],"chk24");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CERUMEN IMPACTADO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk25">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_mucosis_timpanica'],"chk25");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_mucosis_timpanica'],"chk25");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>MUCOSIS TIMPANICA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk26">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_hipoacusia_neurosensorial'],"chk26");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_hipoacusia_neurosensorial'],"chk26");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>HIPOACUSIA NEUROSENSORIAL</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2></TD>
																			<TD width="33%" align=right>
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>OTRO</STRONG>
																				</FONT>
																			</TD>
																			<TD COLSPAN=5 align=left>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						imp($fila['ot_otros_desc']);	
																					};
																				?>
																				<?php if($frmModo=="modificar"){ ?>
																						<INPUT TYPE="text" NAME="ot_otros_desc" size=50 value="<?php echo $fila['ot_otros_desc']?>">
																				<?php }; ?>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
														
															<TR>
																<TD width="100%" align=center>
																	<HR width="80%" color=black><BR>
																	<FONT face="arial, geneva, helvetica" size=2>
																		<strong>INDICACIONES</strong>
																	</FONT>
																</TD>
															</TR>
														

														







															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk28">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_audiometria'],"chk28");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_audiometria'],"chk28");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>AUDIOMETRIA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk29">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_impedanciometria'],"chk29");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_impedanciometria'],"chk29");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>IMPEDANCIOMETRIA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk30">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_radiografia'],"chk30");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_radiografia'],"chk30");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>RADIOGRAFIA</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>







															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk31">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_medicamento'],"chk31");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_medicamento'],"chk31");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>MEDICAMENTO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk32">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_audifono'],"chk32");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_audifono'],"chk32");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>AUDIFONO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk33">

																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_cirugia'],"chk33");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_cirugia'],"chk33");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CIRUGIA</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>




														
														
														

															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2></TD>
																			<TD width="33%" align=right>
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>OTRO</STRONG>
																				</FONT>
																			</TD>
																			<TD COLSPAN=5 align=left>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						imp($fila['ot_otros_desc_indic']);	
																					};
																				?>
																				<?php if($frmModo=="modificar"){ ?>
																						<INPUT TYPE="text" NAME="ot_otros_desc_indic" size=50 value="<?php echo $fila['ot_otros_desc_indic']?>">
																				<?php }; ?>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>

											
														</TABLE>
													</TD>
												</TR>
											</TABLE>						
										</TD>
									</TR>
								</TABLE>

							</TD>
						</TR>
						
						<TR>
							<!--TD width=30></TD-->
							<TD>

								<TABLE width=100% Border=0 cellpadding=0 cellspacing=0>
									<TR>
										<TD width=30></TD>
										<TD>
											<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=left height=10>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>&nbsp;&nbsp;ORTOPEDIA</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<TABLE width=100% height=100% bgcolor=White BORDER=0>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk35">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_alta'],"chk35");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_alta'],"chk35");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ALTA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk36">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_en_estudio'],"chk36");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_en_estudio'],"chk36");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>EN ESTUDIO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk37">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_pie_plano'],"chk37");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_pie_plano'],"chk37");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>PIE PLANO</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk38">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_genu_valgo_varo'],"chk38");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_genu_valgo_varo'],"chk38");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>GENU VALGO/VARO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk39">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_deform_adquir_dedos'],"chk39");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_deform_adquir_dedos'],"chk39");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>DEFORM. ADQUIR. DEDOS</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk40">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_escoliosis'],"chk40");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_escoliosis'],"chk40");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ESCOLIOSIS</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2></TD>
																			<TD width="33%" align=right>
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>OTRO</STRONG>
																				</FONT>
																			</TD>
																			<TD COLSPAN=5 align=left>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						imp($fila['or_otros_desc']);	
																					};
																				?>
																				<?php if($frmModo=="modificar"){ ?>
																						<INPUT TYPE="text" NAME="or_otros_desc" size=50 value="<?php echo $fila['or_otros_desc']?>">
																				<?php }; ?>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%" align=center>
																	<HR width="80%" color=black><BR>
																	<FONT face="arial, geneva, helvetica" size=2>
																		<strong>INDICACIONES</strong>
																	</FONT>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk42">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_cambiar_plantillas'],"chk42");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_cambiar_plantillas'],"chk42");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CAMBIAR PLANTILLAS</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk43">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_mantener_plantillas'],"chk43");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_mantener_plantillas'],"chk43");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>MANTENER PLANTILLAS</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk44">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_kinesiterapia'],"chk44");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_kinesiterapia'],"chk44");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>KINESITERAPIA</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk45">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_rx_extrem_inferiores'],"chk45");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_rx_extrem_inferiores'],"chk45");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>RX EXTREM. INFERIORES</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk46">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_rx_columna'],"chk46");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_rx_columna'],"chk46");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>RX COLUMNA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk47">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_corse'],"chk47");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_corse'],"chk47");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CORSE</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk48">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_cirugia'],"chk48");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_cirugia'],"chk48");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CIRUGIA</STRONG>
																				</FONT>
																			</TD>
																			<TD colspan=5></TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2></TD>
																			<TD width="33%" align=right>
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>OTRO</STRONG>
																				</FONT>
																			</TD>
																			<TD COLSPAN=5 align=left>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						imp($fila['or_otros_desc_indic']);	
																					};
																				?>
																				<?php if($frmModo=="modificar"){ ?>
																						<INPUT TYPE="text" NAME="or_otros_desc_indic" size=50 value="<?php echo $fila['or_otros_desc_indic']?>">
																				<?php }; ?>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
														</TABLE>
													</TD>
												</TR>
											</TABLE>						
										</TD>
									</TR>
								</TABLE>

							</TD>
						</TR>
						<TR>
							<TD colspan=3 align=center>
								<TABLE  BORDER=0 CELLSPACING=0 CELLPADDING=0 width=75%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>ACCIDENTES</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<textarea name="txtACCIDENTE" cols="60" rows="3"></textarea>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){
													if(trim($fila['accidentes'])!="")
														imp($fila['accidentes']);
														else
															imp('No se registran accidentes.');
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<textarea name="txtACCIDENTE" cols="60" rows="3"> <?php echo ($fila['accidentes'])?></textarea>
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD colspan=3 align=center>
								<TABLE  BORDER=0 CELLSPACING=0 CELLPADDING=0 width=75%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>ALERGIAS</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<textarea name="txtALERGIA" cols="60" rows="3"></textarea>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													if(trim($fila['alergias'])!="")
														imp($fila['alergias']);
														else
															imp('No se registran alergias.');
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<textarea name="txtALERGIA" cols="60" rows="3"> <?php echo ($fila['alergias'])?></textarea>
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
						  <TD colspan=3 align=center>
								<TABLE  BORDER=0 CELLSPACING=0 CELLPADDING=0 width=75%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>MEDICAMENTOS</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<textarea name="txtMEDICAMENTO" cols="60" rows="3"></textarea>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													if(trim($fila['medicamentos'])!="")
														imp($fila['medicamentos']);
														else
															imp('No se registran medicamentos.');
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<textarea name="txtMEDICAMENTO" cols="60" rows="3"> <?php echo ($fila['medicamentos'])?></textarea>
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							    <br>
                                <TABLE width=600 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
                                  <tr>
                                    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>GRUPO SANGUINEO</strong></font></td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <table width="600" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td>
                                            <? if($frmModo=="mostrar"){ ?>
                                            <table width="600" bgcolor="#FFFFFF">
                                              <tr>
                                                <td width="30" bgcolor="#FFFFFF" height="30" align="center"><? if($fila['grupo_sanguineo']==1){?>
                                                    <img src="../tic.gif">
                                                    <? } else {?>
                                                    _
                                                    <? }?></td>
                                                <td width="230" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">RH(-)</font></td>
                                                <td width="30" bgcolor="#FFFFFF" align="center"><? if($fila['grupo_sanguineo']==2){?>
                                                    <img src="../tic.gif">
                                                    <? } else {?>
                                                    _
                                                    <? }?></td>
                                                <td width="230" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">RH(+)</font></td>
                                              </tr>
                                              <tr>
                                                <td bgcolor="#FFFFFF" height="30" align="center"><? if($fila['grupo_sanguineo']==3){?>
                                                    <img src="../tic.gif">
                                                    <? } else {?>
                                                    _
                                                    <? }?></td>
                                                <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">AB(I)</font></td>
                                                <td bgcolor="#FFFFFF" align="center"><? if($fila['grupo_sanguineo']==4){?>
                                                    <img src="../tic.gif">
                                                    <? } else {?>
                                                    _
                                                    <? }?></td>
                                                <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">A(II)</font></td>
                                              </tr>
                                              <tr>
                                                <td bgcolor="#FFFFFF" height="30" align="center"><? if($fila['grupo_sanguineo']==5){?>
                                                    <img src="../tic.gif">
                                                    <? } else {?>
                                                    _
                                                    <? }?></td>
                                                <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">B(III)</font></td>
                                                <td bgcolor="#FFFFFF" align="center"><? if($fila['grupo_sanguineo']==6){?>
                                                    <img src="../tic.gif">
                                                    <? } else {?>
                                                    _
                                                    <? }?></td>
                                                <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">0(IV)</font></td>
                                              </tr>
                                            </table>
                                            <? } elseif($frmModo=="modificar" or $frmModo=="ingresar")  {?>
                                            <table width="600" bgcolor="#FFFFFF">
                                              <tr>
                                                <td width="30" bgcolor="#FFFFFF" height="30" align="center"><input type="radio" name="GrupoSangre" value="1" <? if($fila['grupo_sanguineo']==1){?>checked<? }?>></td>
                                                <td width="230" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">RH(-)</font></td>
                                                <td width="30" bgcolor="#FFFFFF" align="center"><input type="radio" name="GrupoSangre" value="2" <? if($fila['grupo_sanguineo']==2){?>checked<? }?>></td>
                                                <td width="230" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">RH(+)</font></td>
                                              </tr>
                                              <tr>
                                                <td bgcolor="#FFFFFF" height="30" align="center"><input type="radio" name="GrupoSangre" value="3" <? if($fila['grupo_sanguineo']==3){?>checked<? }?>></td>
                                                <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">AB(I)</font></td>
                                                <td bgcolor="#FFFFFF" align="center"><input type="radio" name="GrupoSangre" value="4" <? if($fila['grupo_sanguineo']==4){?>checked<? }?>></td>
                                                <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">A(II)</font></td>
                                              </tr>
                                              <tr>
                                                <td bgcolor="#FFFFFF" height="30" align="center"><input type="radio" name="GrupoSangre" value="5" <? if($fila['grupo_sanguineo']==5){?>checked<? }?>></td>
                                                <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">B(III)</font></td>
                                                <td bgcolor="#FFFFFF" align="center"><input type="radio" name="GrupoSangre" value="6" <? if($fila['grupo_sanguineo']==6){?>checked<? }?>></td>
                                                <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">0(IV)</font></td>
                                              </tr>
                                            </table>
                                            <? }?>
                                          </td>
                                        </tr>
                                    </table></td>
                                  </tr>
                                </table>
                                <br>
                                <table width="600" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
                                  <tr>
                                    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROBLEMAS ESPEC&iuml;FICOS DE SALUD DEL ALUMNO</strong></font></td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <? //echo $fila['problema_especifico1'];?>
                                      <table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                                        <tr>
                                          <td width="30" height="30"  align="center"><? if($frmModo=="mostrar"){if($fila['problema_especifico1']==1){?>
                                              <img src="../tic.gif">
                                              <? } else { ?>
                                              _
                                              <? }} else {?>
                                              <input type="checkbox" name="problema_especifico1" <? if($fila['problema_especifico1']==1){?> checked <? }?>>
                                              <? }?></td>
                                          <td width="290"><font face="Arial, Helvetica, sans-serif" size="-2">DIABETES</font></td>
                                          <td width="30" align="center"><? if($frmModo=="mostrar"){if($fila['problema_especifico2']==1){?>
                                              <img src="../tic.gif">
                                              <? } else { ?>
                                              _
                                              <? }} else {?>
                                              <input type="checkbox" name="problema_especifico2" <? if($fila['problema_especifico2']==1){?> checked <? }?>>
                                              <? }?></td>
                                          <td width="290"><font face="Arial, Helvetica, sans-serif" size="-2">PROBLEMAS DE COAGULAC&Iacute;ON</font></td>
                                        </tr>
                                        <tr>
                                          <td height="30" align="center"><? if($frmModo=="mostrar"){if($fila['problema_especifico3']==1){?>
                                              <img src="../tic.gif">
                                              <? } else { ?>
                                              _
                                              <? }} else {?>
                                              <input type="checkbox" name="problema_especifico3" <? if($fila['problema_especifico3']==1){?> checked <? }?>>
                                              <? }?></td>
                                          
                                <td><font face="Arial, Helvetica, sans-serif" size="-2">EPILEPSIA</font></td>
                                          <td align="center"><? if($frmModo=="mostrar"){if($fila['problema_especifico4']==1){?>
                                              <img src="../tic.gif">
                                              <? } else { ?>
                                              _
                                              <? }} else {?>
                                              <input type="checkbox" name="problema_especifico4" <? if($fila['problema_especifico4']==1){?> checked <? }?>>
                                              <? }?></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2">CRISIS ASM&Aacute;TICAS</font></td>
                                        </tr>
                                        <tr>
                                          <td height="30" align="center"><? if($frmModo=="mostrar"){if($fila['problema_especifico5']==1){?>
                                              <img src="../tic.gif">
                                              <? } else { ?>
                                              _
                                              <? }} else {?>
                                              <input type="checkbox" name="problema_especifico5" <? if($fila['problema_especifico5']==1){?> checked <? }?>>
                                              <? }?></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2">CRISIS CONVULSIVAS</font></td>
                                          <td align="center"><? if($frmModo=="mostrar"){if($fila['problema_especifico6']==1){?>
                                              <img src="../tic.gif">
                                              <? } else { ?>
                                              _
                                              <? }} else {?>
                                              <input type="checkbox" name="problema_especifico6" <? if($fila['problema_especifico6']==1){?> checked <? }?>>
                                              <? }?></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2">ASMA</font></td>
                                        </tr>
                                        <tr>
                                          <td height="30" align="center"><? if($frmModo=="mostrar"){if($fila['problema_especifico7']==1){?>
                                              <img src="../tic.gif">
                                              <? } else { ?>
                                              _
                                              <? }} else {?>
                                              <input type="checkbox" name="problema_especifico7" <? if($fila['problema_especifico7']==1){?> checked <? }?>>
                                              <? }?></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2">SANGRAMIENTO NASAL FRECUENTE</font></td>
                                          <td align="center"><? if($frmModo=="mostrar"){if($fila['problema_especifico8']==1){?>
                                              <img src="../tic.gif">
                                              <? } else { ?>
                                              _
                                              <? }} else {?>
                                              <input type="checkbox" name="problema_espeficico8" <? if($fila['problema_especifico8']==1){?> checked <? }?>>
                                              <? }?></td>
                                          <td><font face="Arial, Helvetica, sans-serif" size="-2">REACCI&Oacute;N AL&Eacute;RGICA A PICADURA DE INSECTOS</font></td>
                                        </tr>
                                        <tr>
                                          <td height="48" colspan="4" align="center" valign="middle"><table width="600" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td width="270" height="55" align="center"><font face="Arial, Helvetica, sans-serif" size="-2">OTROS</font></td>
                                                <td width="330" align="left"><font face="Arial, Helvetica, sans-serif" size="-2">
                                                  <? if($frmModo<>"mostrar"){?>
                                                  <input type=text NAME="problema_especifico_otros" size=50 value = "<?echo strtoupper($fila['problema_especifico_otros'])?>">
                                                  <? } else echo strtoupper($fila['problema_especifico_otros'])?>
                                                </font></td>
                                              </tr>
                                              <tr>
                                                <td height="55" colspan="2" align="center"><table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
                                                    <tr>
                                                      <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>SEGURO CLINICA</strong></font></td>
                                                    </tr>
                                                    <tr>
                                                      <td align="center">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                                                          <tr>
                                                            <td height="23"><font face="Arial, Helvetica, sans-serif" size="-2">
                                                              <? if($frmModo=="mostrar"){if($fila['tipo_seguro']==1) {?>
                                                              <img src="../tic.gif">
                                                              <? } else { ?>
                                                              _
                                                              <? }} else {?>
                                                              <input type=radio value=1 name=tipo_seguro onClick="layerCLINICA.style.visibility='hidden';nro=1" <? if($fila['tipo_seguro']==1){?> checked <? }?>>
                                                              <? }?>
                                                            </font></td>
                                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><FONT face="arial, geneva, helvetica" size=2 color=black><strong>ESTATAL</strong></FONT></font></td>
                                                            <td colspan="2" rowspan="2" valign="top">
                                                              <div id="layerCLINICA" style="visibility: <? if ($fila['tipo_seguro']==1) {?>hidden<? } else {?>visible<? } ?>">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                                                                  <tr>
                                                                    <td height="23"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>NOMBRE CL&Iacute;NICA</strong></font></td>
                                                                    <td><? if($frmModo=="mostrar"){ if ($fila['tipo_seguro']==2) {?>
                                                                        <font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo strtoupper($fila['clinica'])?></strong></font>
                                                                        <? }} else { ?>
                                                                        <input name="clinica" type="text" id="clinica3" size="50" maxlength="100" value="<? echo trim(strtoupper($fila['clinica']))?>">
                                                                        <? } ?>
                                                                                                  </tr>
                                                                  <tr>
                                                                    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FONO CLINICA</strong></font></td>
                                                                    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
                                                                      <? if($frmModo=="mostrar"){ if ($fila['tipo_seguro']==2) {?>
                                                                      <font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo strtoupper($fila['fono_clinica'])?></strong></font>
                                                                      <? }} else { ?>
                                                                      <input name="fono_clinica" type="text" id="fono_clinica4" maxlength="10" value="<? echo trim(strtoupper($fila['fono_clinica']))?>">
                                                                      <? } ?>
                                                                    </strong></font></td>
                                                                  </tr>
                                                                </table>
                                                            </div></td>
                                                          </tr>
                                                          <tr>
                                                            <td><font face="Arial, Helvetica, sans-serif" size="-2">
                                                              <? if($frmModo=="mostrar"){if($fila['tipo_seguro']==2) {?>
                                                              <img src="../tic.gif">
                                                              <? } else { ?>
                                                              _
                                                              <? }} else {?>
                                                              <input type=radio value=2 name=tipo_seguro onClick="layerCLINICA.style.visibility='visible';nro=1" <? if($fila['tipo_seguro']==2){?> checked <? }?>>
                                                              <? }?>
                                                            </font></td>
                                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><FONT face="arial, geneva, helvetica" size=2 color=black><strong>PRIVADO</strong></FONT></font></td>
                                                          </tr>
                                                      </table></td>
                                                    </tr>
                                                </table></td>
                                              </tr>
                                          </table></td>
                                        </tr>
                                    </table></td>
                                  </tr>
                                </table></TD>
						</TR>
						<TR>
							<TD colspan=3>
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
								<?php if($frmModo=="mostrar"){?>
								<?php }else{?>
								<?php }?>
							</TD>
						</TR>
						<TR height=15>
							<TD width="100%" colspan=2 ALIGN=CENTER>
								<FONT face="arial, geneva, helvetica" size=2 COLOR=RED>&nbsp;
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
<?php 
	}
	else{

?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width=100%>
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
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
							<td rowspan=4>
								<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=5>
                      <TR>
										<TD>
											<?php
												$result = @pg_Exec($conn,"select * from alumno where rut_alumno=".$alumno);
												$arr=pg_fetch_array($result,0);

												$output= "select lo_export(".$arr[foto].",'/var/www/html/tmp/".$arr['rut_alumno']."');";
												$retrieve_result = @pg_exec($conn,$output);
											?>
											<!--<img src=../../tmp/<?php //echo $arr['rut_alumno'] ?> ALT="NO DISPONIBLE" width=150>-->
										</TD>
									</TR>
								</TABLE>
							</td>
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
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
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
									<strong>CURSO</strong>
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
						 	// --- se agrego al query "tipo_ensenanza.cod_tipo" (pmeza) -----------
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo,tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
							// ---------------------------------------------------------------------
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
													echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													$tipo=$fila1['cod_tipo'];
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
									<strong>ALUMNO</strong>
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
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
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
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat'])." ".trim($fila1['nombre_alu']);
													
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
                <TR height="50">
							<!--<TD align=right>
								<INPUT TYPE="button" value="CONTENIDOS"  class="button" onClick=document.location="fichaContenidos.php3">
								<INPUT TYPE="button" value="FICHA APODERADOS"  class="button" onClick=document.location="fichaApoderados.php3">
								<INPUT TYPE="button" value="FICHA ALUMNO"  class="button" onClick=document.location="fichaAlumno.php3">
								<INPUT TYPE="button" value="FICHA DEPORTIVA"  class="button" onClick=document.location="fichaDeportiva.php3">
								<INPUT TYPE="button" value="SALIR"  class="button" onClick="window.open('../util/logout.php3', '_parent')">
							</TD>-->
						</TR>
						<TR height=20 >
							
                  <TD colspan=2 align=middle class="tableindex">FICHA MEDICA</TD>
						</TR>
						<TR height=20 bgcolor=white>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>No existe ficha medica registrada para el alumno en este año academico.</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
<?php 
	}
?>


				</TD>	
			</TR>
		</TABLE>
	</CENTER>


								  
								  
								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 - Desarrolla Colegio 
                        Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
