<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$anotacion		=$_ANOTACION;
	$empleado		=$_EMPLEADO;
	$alumno			=$_ALUMNO;
	$desde			=$_DESDE;
	$ano			=$_ANO;

	$_POSP          =4;
	$_bot           =5;
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM ANOTACION WHERE ID_ANOTACION=".$anotacion;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1333)</B>');
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
	$sql_peri = "select * from periodo where id_ano = ".$ano;
	$result_peri = pg_exec($conn,$sql_peri);
?>
<HTML>
	<HEAD>

			
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>

		<SCRIPT language="JavaScript">
			var nro=0;
		
			function valida(form){
				
/*				if(!checkRadios("rdTIPO",'Seleccionar TIPO ANOTACION.')){
					return false;
				};
*/
				if(!chkSelect(form.cmb_periodos,'Seleccione PERIODO')){
					return false;
				};
				

				if(!chkFecha(form.txtFECHA,'Fecha inválida.')){
					return false;
				};

				if(!chkVacio(form.txtOBS,'Ingresar OBSERVACION.')){
					return false;
				};

				if(nro==1){//CONCUCTA
					if(!(form.tipo_conducta[0].checked) && !(form.tipo_conducta[1].checked)){
						alert("Seleccione Tipo de Coducta");
						return false;
					};
				};

				if(nro==2){//ATRASO
					if(!chkVacio(form.txtHORAS,'Ingresar HORAS de atraso.')){
						return false;
					};
					if(!chkHora(form.txtHORAS,'Hora inválida.')){
						return false;
					};
				};

				if(nro==3){//INASISTENCIA
					//nada que chequear.
				};
				
				if(nro==4){//ENFERMERIA
				
					if(!chkVacio(form.txtHORAS,'Ingresar HORA de ingreso a enfermeria.')){
						return false;
					};
					if(!chkVacio(form.txtCAUSAL,'Ingresar CAUSAL de acceso a enfermeria.')){
						return false;
					};
					if(!chkVacio(form.txtTRA,'Ingresar TRATAMIENTO recomendado.')){
						return false;
					};
					if(!chkHora(form.txtHORAS,'Hora inválida.')){
						return false;
					};					
				};
				return true;
			}

			function clean(form,tipo){
				if(tipo=='C'){
					form.txtHORAS.value='';
					form.txtCAUSAL.value='';
					form.txtTRA.value='';
				}
				if(tipo=='A'){
					form.txtCAUSAL.value='';
					form.txtTRA.value='';
				}
				if(tipo=='I'){
					form.txtHORAS.value='';
					form.txtCAUSAL.value='';
					form.txtTRA.value='';
				}
				if(tipo=='E'){
					form.txtHORAS.value='';
				}
			}
		</SCRIPT>

<?php }?>
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
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">	
</HEAD>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="91%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral= "3_1"; 
						include("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top">
								  
								  
								  <!-- INICIO CODIGO ANTIGUO -->




	<?php //echo tope("../../../../util/");?>
	<!--FORM method=post name="frm" action="seteaAnotacion.php3?pag=procesoAnotacion.php3&caso=2&desde= echo $desde &frmModo= echo $frmModo &alumno= echo $alumno "-->
	<FORM method=post name="frm" action="<? if ($frmModo=="ingresar"){ ?> procesoAnotacion_old.php3 <? }else{ if ($frmModo == "modificar"){ ?> procesoAnotacion_old.php3?caso=1 <? } } ?> ">
	<?php 
		echo "<input type=hidden name=rut value=".$alumno.">";
		echo "<input type=hidden name=emp value=".$empleado.">";
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>ALUMNO</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
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
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
												}
											}
										?>
									</strong>								</FONT>							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>RESPONSABLE</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
									   <? if ($_PERFIL==19){
												$q1 = "select * from empleado where rut_emp in (select rut_emp from trabaja where rdb = '".trim($_INSTIT)."') order by ape_pat";
												$r1 = pg_Exec($conn,$q1);
												$n1 = pg_numrows($r1);
												?>
												<select name="cmb_empleado">
												<? 
												for ($i=0; $i < $n1; $i++){
													$f1 = pg_fetch_array($r1,$i);
													?>	 
													<option value="<? echo trim($f1['rut_emp']) ?>" <? if (trim($f1['rut_emp'])==trim($empleado)){ ?> selected="selected" <? } ?>><? echo trim($f1['ape_pat'])." ".trim($f1['ape_mat']).", ".trim($f1['nombre_emp']) ?></option>
													<?
												}
												?>
												</select>
												<? 
										   }	
									    ?>		
											
									
										<?php 
										  if ($_PERFIL!=0 AND $_PERFIL != 19){ 
											$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$empleado;
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
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_emp']);
												}
											}
										}	
										?>
									</strong>								</FONT>							</TD>
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
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<?php if ($desde!="alumno"){ 
											echo ?><INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarAnotacion.php3">&nbsp;
										<?php }else
											if($_PERFIL==19){ 
												echo ?><INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="../../ano/matricula/matricula.php3?Modo=1">																								
										<?php }else{	?> 	
												<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="../../ano/curso/alumno/alumno.php3?sw2=1&pesta=4">
										<?			}?>																									
								<?php };?>
								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>									
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
										<!--INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar disabled-->&nbsp;
											<?php }?>
									<?php }?>
									<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarAnotacion.php3">&nbsp;
								<?php };?>
								
								<? if ($frmModo=="modificar"){ ?>
								        <INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
								        <INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="../../ano/curso/alumno/alumno.php3?sw2=1&pesta=4">
								<? } ?>						
								
								
								
							</TD>
						</TR>
						<TR height=20 >
							<TD align=middle colspan=2 class="tableindex">
								ANOTACION
							</TD>
						</TR>
						<tr>
							<td></td>
							<td><table width="500" border="0">
								<tr>
								  <td><font face="Geneva, Arial, Helvetica" size=1 color=#000000>PERIODO</font></td>
								</tr>
								<tr>
								  <td>
								  <?
								  if (($frmModo=="modificar") and ($_INSTIT == '8933')){ ?>
								      	<select name="cmb_periodos" class="ddlb_9_x">
										 <option value=0 selected>(Seleccione Periodo)</option>
										   <?
											  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
											  {
											  $fila1 = @pg_fetch_array($result_peri,$i); 
											  if (($fila1['id_periodo'])==($fila['id_periodo']))
												echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											  else
												echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											  ?>
										   <? } ?>
										</select>
																		  
								<? }else{ ?>							  
									  <select name="cmb_periodos" class="ddlb_9_x">
												<option value=0 selected>(Seleccione Periodo)</option>
										   <?
											  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
											  {
											  $fila1 = @pg_fetch_array($result_peri,$i); 
											  if ($fila1['id_periodo']==$cmb_periodos)
												echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											  else
												echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											  ?>
										   <? } ?>
										</select>
								 <? } ?>	
									
								  </td>
								</tr>
							  </table>
							</td>
						</tr>
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<TABLE WIDTH="500" BORDER=0 CELLSPACING=1 CELLPADDING=0 <?php if($frmModo!="mostrar"){ echo "bgcolor=#cccccc";}?>>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG><?php if($frmModo!="mostrar"){ echo "&nbsp;&nbsp;";}?>TIPO ANOTACION</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR align=center>
										<TD>
											<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 bgcolor=White>
												<TR>
													<?php if($frmModo!="mostrar"){ echo "<TD width=15></TD>";}?>
													<TD align=left>
													<?php if(($frmModo=="ingresar") OR ($frmModo=="modificar")){ ?>
														<input type=radio value=1 name=rdTIPO  
														onClick="layerATRASO.style.visibility='hidden';layerTIPOCONDUCTA.style.visibility='visible';
														layerENFERMERIA.style.visibility='hidden';clean(this.form,'C');nro=1" <? if ($fila['tipo']==1){ ?> checked="checked" <? } ?>>
														<FONT face="arial, geneva, helvetica" size=2 color=black>
															<strong>CONDUCTA</strong>
														</FONT>
														<input type=radio value=2 name=rdTIPO 
														onClick="layerATRASO.style.visibility='visible'; layerTIPOCONDUCTA.style.visibility='hidden'
														layerENFERMERIA.style.visibility='hidden';clean(this.form,'A');nro=2" <? if ($fila['tipo']==2){ ?> checked="checked" <? } ?>>
														<FONT face="arial, geneva, helvetica" size=2 color=black>
															<strong>ATRASO</strong>
														</FONT>
														<!--<input type=radio value=3 name=rdTIPO 
														onClick="layerATRASO.style.visibility='hidden';
														layerENFERMERIA.style.visibility='hidden';clean(this.form,'I');nro=3">
														<FONT face="arial, geneva, helvetica" size=2 color=black>
															<strong>INASISTENCIA</strong>
														</FONT> -->

														<input type=radio value=4 name=rdTIPO 
														onClick="layerATRASO.style.visibility='hidden';layerTIPOCONDUCTA.style.visibility='hidden'
														layerATRASO.style.visibility='visible';
														layerENFERMERIA.style.visibility='visible';
														clean(this.form,'E');nro=4" <? if ($fila['tipo']==4){ ?> checked="checked" <? } ?>>
														<FONT face="arial, geneva, helvetica" size=2 color=black>
															<strong>RESPONSABILIDAD</strong>														</FONT>
													<?php };?>
													<?php 
														if($frmModo=="mostrar"){ 
															switch ($fila['tipo']) {
																 case 0:
																	 imp('Indeterminado');
																	 break;
																 case 1:
																	 imp('Conducta');
																	 break;
																 case 2:
																	 imp('Atraso');
																	 break;
																 case 3:
																	 imp('Inasistencia');
																	 break;
																 case 4:
																	 imp('Enfermeria');
																	 break;
															 };
														};
													?>													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%>
									<TR>
										<TD width="43%" valign=bottom>
											<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=73%>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>FECHA</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if(($frmModo=="ingresar") OR ($frmModo == "modificar")){ ?>
															<INPUT type="text" name=txtFECHA size=10 maxlength=10 value="<? echo impF($fila['fecha']); ?>">
															<br>
															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																<STRONG>(DD-MM-AAAA)</STRONG>
															</FONT>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																impF($fila['fecha']);
															};
														?>
													</TD>
												</TR>
											</TABLE>
											<table width="229" height="39" border="0" cellpadding="0" cellspacing="0">
											  <tr>
												<td>
												<div id="layerTIPOCONDUCTA" style="visibility: <? if (($frmModo=="modificar") AND ($fila['tipo']==1)){ ?> true <? }else{ ?> hidden <? } ?>">
												<table width="229" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td><FONT face="arial, geneva, helvetica" size=1 color=#000000>TIPO CONDUCTA</FONT></td>
                                                  </tr>
                                                  <tr>
                                                    <td><input name="tipo_conducta" type="radio" <?  if (($frmModo=='modificar') AND ($fila['tipo_conducta']==1)) { ?>  checked="checked" <? } ?> value="1" >
                                                      POSITIVA
                                                        <input name="tipo_conducta" type="radio" <?  if (($frmModo=='modificar') AND ($fila['tipo_conducta']==2)) { ?>  checked="checked" <? } ?> value="2" >
                                                      NEGATIVA</td>
                                                  </tr>
                                                </table>
												</div>
												</td>
											  </tr>
										  </table>

										</TD>
										
										<TD width="57%" valign="top">
											<div id="layerATRASO" style="visibility: <? if (($frmModo=="modificar") AND ($fila['tipo'] > 1)){ ?>  true <? }else{ ?>  hidden <? } ?>">
												<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 >
													<TR>
														<TD>
															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																
<STRONG>TIEMPO ATRASO (atraso)<BR>HORA INGRESO 
(enfermeria)</STRONG>
															</FONT>
														</TD>
													</TR>
													<TR>
														<TD>
															<?php if($frmModo=="ingresar"){ ?>
																      <INPUT type="text" name="txtHORAS" size="4" maxlength="5" value="00:00" >
															<?php };?>
															
															<?php if($frmModo=="modificar"){ ?>
																      <INPUT type="text" name="txtHORAS" size="4" maxlength="5" value="<?=$fila['hora'] ?>">
															<?php };?>
															
															<?php 
																if($frmModo=="mostrar"){ 
																	imp($fila['hora']);
																};
															?>&nbsp;&nbsp; 
															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																<STRONG>(HH:MM)</STRONG>
															</FONT>
														</TD>
													</TR>
												</TABLE>
											</div>									  </TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=50%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>OBSERVACION</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if(($frmModo=="ingresar") OR ($frmModo=="modificar")){ ?>
												<textarea name="txtOBS" cols="60" rows="5"><? echo trim($fila['observacion']) ?></textarea>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['observacion']);
												};
											?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<div id="layerENFERMERIA" style="visibility: <? if (($frmModo=="modificar") AND ($fila['tipo']==4)){ ?> true <? }else{ ?> hidden <? } ?>">
									<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=50%>
										<TR>
											<TD>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>CAUSAL</STRONG>
												</FONT>
											</TD>
										</TR>
										<TR>
											<TD>
												<?php if(($frmModo=="ingresar") OR ($frmModo=="modificar")){ ?>
													<textarea name="txtCAUSAL" cols="60" rows="5"><? echo trim($fila['causal']) ?></textarea>
												<?php };?>
												<?php 
													if($frmModo=="mostrar"){ 
														imp($fila['causal']);
													};
												?>
											</TD>
										</TR>
										<TR height=15><TD></TD></TR>
										<TR>
											<TD>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>TRATAMIENTO</STRONG>
												</FONT>
											</TD>
										</TR>
										<TR>
											<TD>
												<?php if(($frmModo=="ingresar") OR ($frmModo=="modificar")){ ?>
													<textarea name="txtTRA" cols="60" rows="5"><? echo trim($fila['tratamiento']) ?></textarea>
												<?php };?>
												<?php 
													if($frmModo=="mostrar"){ 
														imp($fila['tratamiento']);
													};
												?>
											</TD>
										</TR>
									</TABLE>
								</div>
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
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
	
	
                             <!-- FIN CODIGO ANITGUO -->
 
                               </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><div align="center">SAE 
                          Sistema de Administraci&oacute;n Escolar - 2005 - Desarrolla 
                          Colegio Interactivo</div></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>"></td>
        </tr>
      </table></td>
  </tr>
</table>	
	
</BODY>
</HTML>