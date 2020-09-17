<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
if ($botonera==1){
	$frmModo="mostrar";
	}else{
	$frmModo		=$_FRMMODO;
	}
	$ano			=$_ANO;
	$empleado		=$_EMPLEADO;
 ?>
 
 	<script language="JavaScript" type="text/JavaScript">


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
</script>

<SCRIPT language="JavaScript">

			function generar(){
				if(confirm('!!!ADVERTENCIA, esta opción se utiliza creado el nuevo año para traspasar alumnos del año anterior¡¡¡') == false){ return; };
				document.location="procesoMatAuto.php3"
			};


			function Confirmacion(){
			if(alert('¡EL INGRESO DE REGIMEN ES IRREVERSIBLE, DEBE ESTAR SEGURO DEL REGIMEN PARA ESTE AÑO ESCOLAR!') == false){ return; };
			};
</script>
<?php

$qry1="SELECT tipo_regimen FROM ANO_ESCOLAR WHERE id_ano=".$ano;
	$result1 =@pg_Exec($conn,$qry1);
	$fila1 = @pg_fetch_array($result1,0);
	$regimen=$fila1['tipo_regimen'];

?>

	<?php if($frmModo!="ingresar"){
		$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
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
			}
		}
	}
?>

<HTML>
	<HEAD>
	<script language="JavaScript">
function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=300, height=266, top=85, left=140";
window.open(pagina,"",opciones);
}
</script> 

		<LINK REL="STYLESHEET" HREF="../../../util/td.css" TYPE="text/css">
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtANO,'Ingresar AÑO.')){
					return false;
				};

				if(!chkSelect(form.cmbREGIMEN,'Debe Seleccionar Régimen.')){
					return false;
				};

				if(!nroOnly(form.txtANO,'Se permiten sólo números en el AÑO.')){
					return false;
				};

				if(!chkVacio(form.txtFECHAINI,'Ingresar FECHA INICIO.')){
					return false;
				};

				if(!chkFecha(form.txtFECHAINI,'Fecha Inicio inválida.')){
					return false;
				};

				if(!chkVacio(form.txtFECHATER,'Ingresar FECHA TERMINO.')){
					return false;
				};
				
				if(!chkFecha(form.txtFECHATER,'Fecha Término inválida.')){
					return false;
				};

				if(!chkFecha(form.txtFECHATER,'Fecha Término inválida.')){
					return false;
				};
				
				//VALIDACION INTERVALO DE FECHAS
				if(amd(form.txtFECHAINI.value)>=amd(form.txtFECHATER.value)){
					alert("Fecha de término no puede ser mayor o igual a la Fecha de inicio");
					return false;
				}

				return true;
			}
		</SCRIPT>
<?php }?>
<script language="JavaScript">
function Confirmacion(){
	if(confirm('¿ESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
		document.location="procesoMatAuto.php3?botonera=1"
	};
</script>	
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url();
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></HEAD>

<body  MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">

<?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="periodo/listarPeriodo.php3?botonera=1"><img src="../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2" onMouseOver="MM_swapImage('Image2','','../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="feriado/listaFeriado.php3?botonera=1"><img src="../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../planEstudio/listarPlanesEstudio.php3?botonera=1"><img src="../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../atributos/listarTiposEnsenanza.php3?botonera=1"><img src="../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="curso/listarCursos.php3?botonera=1"><img src="../botones/cursos.gif" name="Image6" width="81" height="30" border="0" id="Image6" onMouseOver="MM_swapImage('Image6','','../botones/cursos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="matricula/listarMatricula.php3?botonera=1"><img src="../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="ActasMatricula/Menu_Actas.php?botonera=1"><img src="../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="javascript:generar();"><img src="../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>
<? }?>

	<?php //echo tope("../../../util/");?>
	<FORM method=post name="frm" action="procesoAno.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">"
	?>
		<TABLE WIDTH=600 BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
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
						</TR>
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarAno.php3">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
								 			<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=6)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaAno.php3?ano=<?php echo $ano?>&caso=3">&nbsp;
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="DIARIO MURAL" name=btnDiarioMural  onClick=document.location="../../../fichas/diario/ListadoNoticias.php">&nbsp;
										<!--INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar onClick="Confirmacion()"-->&nbsp;
											<?php }?>
									<?php } //ACADEMICO Y LEGAL?>
									
										
				  <? IF(($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=6)){ ?>
				  <INPUT name="button" TYPE="button" class="botonZ" onClick=document.location="Claves.php" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="CLAVES DE SISTEMA">
				  <INPUT name="button_r" TYPE="button" class="botonX" onClick=document.location="Menu_Respaldo.php" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="RESPALDOS">										
				  <INPUT name="button_r" TYPE="button" class="botonX" onClick=document.location="NumeroHorasSemanales.php?accion=1" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="SUBSECTORES">
					<? } ?>
	              <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="listarAno.php3">

              &nbsp; 
              <?php };?>
              <?php if($frmModo=="modificar"){ ?>
              <!--<input name="treprte" type="button" onclick=document.location="anos.php3" value="ANO">-->
              <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaAno.php3?ano=<?php echo $ano?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#003b85>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>AÑO ESCOLAR</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD width=20></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD width="13%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>AÑO</STRONG>
											</FONT>
										</TD>
										<TD width="18%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA INICIO</STRONG>
											</FONT>
										</TD>
										<TD width="18%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA TERMINO</STRONG>
											</FONT>
										</TD>
										<TD width="22%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>TIPO DE REGIMEN</STRONG>
											</FONT>
										</TD>
										<TD width="29%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>SITUACION</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										
                  <TD valign="top"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtANO size=6 maxlength=4> <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>(AAAA)</STRONG> </FONT> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['nro_ano']);
												};
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name=txtANO size=6 maxlength=4 value=<?php echo $fila['nro_ano']?>> 
                    <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>(AAAA)</STRONG> </FONT> 
                    <?php };?>
                  </TD>
										
                  <TD valign="top"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtFECHAINI size=10 maxlength=10 onChange="chkFecha(form.txtFECHAINI,'Fecha inicio invalida.');"> 
                    <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>(DD-MM-AAAA)</STRONG> </FONT> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_inicio']);
												};
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name=txtFECHAINI size=10 maxlength=10 value=<?php impF($fila['fecha_inicio'])?>> 
                    <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>(DD-MM-AAAA)</STRONG> </FONT> 
                    <?php };?>
                  </TD>
										
                  <TD valign="top"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtFECHATER size=10 maxlength=10 onChange="chkFecha(form.txtFECHATER,'Fecha termino invalida.');"> 
                    <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>(DD-MM-AAAA)</STRONG> </FONT> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_termino']);
												};
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name=txtFECHATER size=10 maxlength=10 value=<?php impF($fila['fecha_termino'])?>> 
                    <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>(DD-MM-AAAA)</STRONG> </FONT> 
                    <?php };?>
                  </TD>
										
                  <TD valign="top"> 
                    <?php  if($frmModo=="ingresar"){ ?>
                    <Select name="cmbREGIMEN" onChange="Confirmacion()">
                      <option value=0 selected></option>
                      <option value=2>Trimestral</option>
                      <option value=3>Semestral</option>
                    </Select> 
                    <?php }; ?>
                    <?php 
															if(($frmModo=="mostrar")||($frmModo=="modificar")){ 
																switch ($fila['tipo_regimen']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 2:
																		 imp('Trimestral');
																		 break;
																	 case 3:
																		 imp('Semestral');
																		 break;
																 };
															};
														?>
                    <?php /* if($frmModo=="modificar"){ ?>
                    <Select name="cmbREGIMEN" >
                      <option value=0 ></option>
                      <option value=1 <?php echo ($fila['tipo_regimen'])==1?"selected":"" ?>>Indeterminado</option>
                      <option value=2 <?php echo ($fila['tipo_regimen'])==2?"selected":"" ?>>Trimestral</option>
                      <option value=3 <?php echo ($fila['tipo_regimen'])==3?"selected":"" ?>>Semestral</option>
                    </Select> 
                    <?php }; */?>
                  </TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<table WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
													<tr>
														<td align=LEFT>
															<TABLE WIDTH="150" BORDER=0 CELLSPACING=1 CELLPADDING=0 bgcolor=#cccccc>
																<TR>
																	<TD>
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 bgcolor=White>
																			<TR>
																				<TD width=5></TD>
																				
                                    <TD align=left valign="top"> 
                                      <p>
                                        <input type=radio value=0 name=rdSIT>
                                        CERRADO&nbsp;&nbsp; </p>
                                      <p>
                                        <input type=radio value=1 name=rdSIT checked>
                                        ABIERTO </p></TD>
																			</TR>
																		</TABLE>													
																	</TD>
																</TR>
															</TABLE>
														</td>
													</tr>
												</table>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){
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
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<table WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
													<tr>
														<td align=LEFT>
															<TABLE WIDTH="150" BORDER=0 CELLSPACING=1 CELLPADDING=0 bgcolor=#cccccc>
																<TR>
																	<TD>
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 bgcolor=White>
																			<TR>
																				<TD width=5></TD>
																				
                                    <TD align=left valign="top"> <p>
                                        <input type=radio value=0 name=rdSIT <?php if($fila['situacion']==0) echo "checked"?>>
                                        CERRADO&nbsp;&nbsp;</p>
                                      <p> 
                                        <input type=radio value=1 name=rdSIT <?php if($fila['situacion']==1) echo "checked"?>>
                                        ABIERTO </p></TD>
																			</TR>
																		</TABLE>													
																	</TD>
																</TR>
															</TABLE>
														</td>
													</tr>
												</table>
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
											<HR width="100%" color=#003b85>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR height=15>
							<TD width="100%" colspan=2>
								<?php if($frmModo=="mostrar"){?>
								       <center>
									<!--INPUT TYPE="button" value="PERIODOS" onClick=document.location="periodo/listarPeriodo.php3"-->
									<?php
										$sw=0;
										$qry="SELECT * FROM PERIODO WHERE ID_ANO=".$ano;
										$result =@pg_Exec($conn,$qry);
										if (!$result) 
											error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
										else{
											$periodosIngresados=pg_numrows($result);
											if($_TIPOREGIMEN==2)//TRIMESTRAL
												if($periodosIngresados<3)
													$sw=1;
											if($_TIPOREGIMEN==3)//SEMESTRAL
												if($periodosIngresados<2)
													$sw=1;
										};
									?>
									<!--INPUT TYPE="button" value="PLANES DE ESTUDIO" onClick=document.location="../planEstudio/listarPlanesEstudio.php3">
										<INPUT TYPE="button" value="TIPOS DE ENSEÑANZA"    onClick=document.location="../atributos/listarTiposEnsenanza.php3">
										<input type="button" name="Button" value="FERIADOS" onClick=document.location="feriado/listaFeriado.php3">
										<INPUT TYPE="button" value="CURSOS" onClick=document.location="curso/listarCursos.php3">
              
              
           
              <input name="button" type="button" onClick=document.location="matricula/listarMatricula.php3" value="MATRICULA"> 
              <INPUT TYPE="button" value="REPORTES" onClick=document.location="reportes/listados.php3">
										<?php if($_PERFIL==0 || $_PERFIL==1 || $_PERFIL==2 || $_PERFIL==3 || $_PERFIL==14){?>
										<?php //if($_PERFIL=!14) ?> 
											
												<!--<INPUT TYPE="button" value="CTA CORRIENTE" onClick=document.location="pagos/listarPagos.php">-->
											
										<?php }?>
				
					<!--INPUT TYPE="button" value="FICHA MEDICA" onClick=document.location="fichas/listarAlumnosMatriculados.php3?tipoFicha=1">
				
				
					<!--INPUT TYPE="button" value="FICHA DEPORTIVA" onClick=document.location="fichas/listarAlumnosMatriculados.php3?tipoFicha=2"-->
				
					<?php if (($fila['situacion']==1) and ($fila['ano_anterior']!="")){ 
					    ?>
					<!--INPUT TYPE="button" value="GENERAR MATRICULAS" onClick="generar();">
				<?php }?>
					
									<?php }else{?>
										<INPUT TYPE="button" value="CURSOS" disabled >
										<INPUT TYPE="button" value="MATRICULA" disabled >
										<INPUT TYPE="button" value="REPORTES" disabled >
										<?php if($_PERFIL!=14){?>
											<?php if($_PLAN>=2){ //PLUS O +?>
												<INPUT TYPE="button" value="CTA CORRIENTE" disabled >
											<?php }?>
										<?php }?>

										
				<?php if($_PLAN>=2){ //PLUS O +?>
					<INPUT TYPE="button" value="FICHA MEDICA"  disabled >
				<?php }?>
				<?php if($_PLAN>=1){ //basico O +?>
							<INPUT TYPE="button" value="FICHA DEPORTIVA"  disabled -->
				<?php }?>
		
		</center>
									<?php }?>
								<?php //}?>

							</TD>
						</TR>
						<TR height=15>
							
            <TD width="100%" colspan=2 ALIGN=CENTER> <FONT face="arial, geneva, helvetica" size=2 COLOR=RED> 
              <?php if(($_PERFIL==14)||($_PERFIL==0)||($_PERFIL==1)){ ?>
              <?php if($frmModo=="mostrar"){ ?>
              <?php
												$qry="SELECT * FROM PERIODO WHERE ID_ANO=".$ano;
												$result =@pg_Exec($conn,$qry);
												if (!$result) 
													error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
												else{
													$periodosIngresados=pg_numrows($result);
													
													if($regimen==1){//BIMESTRAL
														if($periodosIngresados<4){
															echo "\"FALTAN PERIODOS POR INGRESAR\"";
														}
													}
													if($regimen==2){//TRIMESTRAL
														if($periodosIngresados<3){
															echo "\"FALTAN PERIODOS POR INGRESAR\"";
														}
													}
													if($regimen==3){//SEMESTRAL
														if($periodosIngresados<2){
															echo "\"FALTAN PERIODOS POR INGRESAR\"";
														}
													}
												};
											?>
              <?php };?>
              <?php };?>
              </FONT> </TD>
						</TR>
					</TABLE>
				</TD>
			</TR>		
	  </TABLE>
	</FORM>
</BODY>
</HTML>