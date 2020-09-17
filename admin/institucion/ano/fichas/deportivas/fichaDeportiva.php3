<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso          =$_CURSO;
	$_POSP          =5;
	$_bot           = 5;
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM FICHA_DEPORTIVA WHERE ID_ANO=".$ano." AND RUT_ALUMNO='".trim($alumno)."'";
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
	
// TOMO LOS DATOS DE UNA FICHA DEPORTIVA EXISTENTE SI ES QUE EXISTE
$q2 = "select * from ficha_deportivanew where id_ficha = '$id_ficha'";
$r2 = @pg_Exec($conn,$q2);
$n2 = @pg_numrows($r2);	
if ($n2 != 0){
    $f2 = pg_fetch_array($r2,0);
	$fecha = $f2['fecha'];
	
	$dd = substr($fecha,8,2);
	$mm = substr($fecha,5,2);
	$aa = substr($fecha,0,4);
	$fecha = "$dd-$mm-$aa";
	
	$observaciones = $f2['observaciones'];
	$emitido = $f2['emitido'];
}	
	

	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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


		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>		
		<SCRIPT language="JavaScript">


function valida(form){

			if(!chkVacio(form.fecha,'Ingresar Fecha.')){
				return false;
			};			
			if(!chkFecha(form.fecha,'Fecha inválida.')){
				 return false;			
			};
			
			
			if(!chkVacio(form.fechanac,'Ingresar Fecha de Nacimineto.')){
				return false;
			};				
								    
			if(!chkFecha(form.fechanac,'Fecha de nacimiento invalida .')){
				 return false;
			};

			
			if(!chkVacio(form.observaciones,'Ingresar Observaciones.')){
				return false;
			};			
			
			if(!chkVacio(form.emitido,'Ingresar campo Emitido por.')){
				return false;
			};			

			if(!nroOnly(form.txtPG3,'Campo inválido, Reingrese.')){
				return false;
			};					
			
			if(!nroOnly(form.txtPG6,'Campo inválido, Reingrese.')){
				return false;
			};	
			
			if(!nroOnly(form.txtPG9,'Campo inválido, Reingrese.')){
				return false;
			};	
			
			if(!nroOnly(form.txtPG11,'Campo inválido, Reingrese.')){
				return false;
			};										

				return true;
			}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</SCRIPT>
<style type="text/css">
.cajaborde tr td form table tr td table tr td table tr td table tr .tablatit2-1 {
	font-weight: bold;
	font-size: 16px;
}
</style>
</head>
	
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7">  
             <? include("../../../../../cabecera/menu_superior.php"); ?>
                           
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height=""><!-- inicio codigo nuevo -->
								  
								  
								  
								  
								  
								  
<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
<table width="90%"  border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"> 
       </td>
  </tr>
</table>
<?php } ?>
	<?php //echo tope("../../../../../util/");?>
	<FORM method="post" name="frm" action="ing_fdeportiva.php" onSubmit="return valida(this);">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=idFicha value=".$fila['id_ficha'].">"
	?>
		<TABLE WIDTH=90% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
		<tr>
		<td align="right"><input name="button3" TYPE="button" class="botonXX" onClick="MM_openBrWindow('PfichaDeportiva.php?id_ficha=<?=$id_ficha ?>&cmb_periodos=<?=$id_periodo ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR"></td>
		</tr>
			<TR >
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
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
													echo trim($fila1['nro_ano']);
												}
											}
										?>
									</strong>								</FONT>							</TD>
						</TR>
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
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
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
									<strong>FECHA NACIMIENTO</STRONG></FONT> </TD>
						  <TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</STRONG></FONT></TD>
						  <TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong><?= date("d-m-Y",strtotime($fila1['fecha_nac']))?></STRONG></FONT>&nbsp;</TD>
						  </TR>
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
<table width="615" border="0" cellspacing="0" cellpadding="0">
						<TR height="50" >
							<TD align=right colspan=2>
								
							</TD>
						</TR>
						<TR height=20 >
							<TD align=middle colspan=2 class="tableindex">								
									FICHA DEPORTIVA
							</TD>
						</TR>
						<TR>
							<TD><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666">
                              <tr>
                                <td width="30%" class="cuadro02"><strong>Fecha</strong></td>
                                <td class="cuadro01"><label>								        
                                  <input name="fecha" type="text" id="fecha" value="<?=$fecha ?>" size="10" maxlength="10">
                                  <strong>
                                dd-mm-aaaa</strong></label></td>
                              </tr>
							  <tr>
                                <td class="cuadro02"><strong>Emitido por</strong></td>
                                <td class="cuadro01"><label>
                                <input name="emitido"  type="text" id="emitido" value="<?=$emitido ?>" size="40">
                                </label></td>
                              </tr>							  
                              <tr>
                                <td valign="top" class="cuadro02"><strong>Observaciones</strong></td>
                                <td valign="top" class="cuadro01"><label>
                                  <textarea name="observaciones"  cols="40" rows="5" id="observaciones" ><? echo trim($observaciones); ?></textarea>
                                </label></td>
                              </tr>
							
                              <tr>
                                <td colspan="2"><div align="center"><br>
                                  <?
								  if ($n2 == 0){
								     ?>
								     <label>
                                       <input type="submit"name="Submit" value="GUARDAR" class="BotonXX"   >
                                     </label>
									 <?
								  }
								  ?>	 
                                      <label>
                                      <input name="Submit2" type="button" onClick="MM_callJS('history.go(-1)')" value="VOLVER" class="BotonXX">
                                      </label>
                                </div></td>
                                </tr>
                            </table></TD>
						</TR>
						<TR>
							<TD><TABLE width=100% Border=0 cellpadding=1 cellspacing=0>
                              <TR>
                                <TD class="tableindex">  INFORMACI&Oacute;N GENERAL </TD>
                              </TR>
                              <TR>
                                <TD><TABLE width=100% height=100% bgcolor=White BORDER=0>
                                    <TR>
                                      <TD width="100%"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666">
                                        <tr>
                                          <td width="30%" class="cuadro02"><strong>FECHA DE NACIMIENTO </strong></td>
                                          <td class="cuadro01"><label>
										  <?
										 /* $fechanac = $fila['fechanac'];
										  if ($fechanac != NULL){
										     $dd = substr($fechanac,8,2);
										     $mm = substr($fechanac,5,2);
										     $aa = substr($fechanac,0,4);
										     $fechanac = "$dd-$mm-$aa";
										  }*/	 
										  ?>									  
                                         <input name="fechanac"  type="text" id="fechanac" size="10" value="<?= date("d-m-Y",strtotime($fila1['fecha_nac']))?>">
                                          dd-mm-aaaa</label></td>
                                        </tr>
                                        <tr>
                                          <td class="cuadro02"><strong>SEXO</strong></td>
                                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="5%"><label>
											   <?
											   if ($fila['sexo'] == 1){
											      ?>										  
                                                  <input name="sexo" type="radio" value="1" checked="checked">
                                                  <?
											   }else{
											   	  ?>										  
                                                  <input name="sexo" type="radio" value="1">
                                                  <?
											   }
											   ?>	  
											  
											  </label></td>
                                              <td class="cuadro01">Masculino</td>
                                              <td width="5%"><label>
											  <?
											  if ($fila['sexo'] == 2){
											     ?>
                                                 <input name="sexo" type="radio" value="2" checked="checked">
                                                 <?
										      }else{
											     ?>
                                                 <input name="sexo" type="radio" value="2">
                                                 <?
											  }
											  ?>									  		 
											  
											  </label></td>
                                              <td class="cuadro01">Femenino</td>
                                            </tr>
                                          </table></td>
                                        </tr>
                                        <tr>
                                          <td class="cuadro02"><strong>CURSO</strong></td>
                                          <td class="cuadro01">
										  <!-- INSERTO EL SCRIPT PARA SABER DE QUE CURSO ES -->
										  
										  <?php
											$qry="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, tipo_ensenanza.cod_tipo as tpe FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
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
													
													if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
														echo "PRIMER NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==121987) or ($fila1['cod_decreto']==1521989)) ){
														echo "PRIMER CICLO"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==1) and ($fila1['cod_decreto']==1000)){
														echo "SALA CUNA"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==2) and (($fila1['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
														echo "SEGUNDO NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==121987) ){
														echo "SEGUNDO CICLO"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==1000)){
														echo "NIVEL MEDIO MENOR"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==3) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
														echo "TERCER NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==3) and ($fila1['cod_decreto']==1000)){
														echo "NIVEL MEDIO MAYOR"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==4) and ($fila1['cod_decreto']==1000)){
														echo "TRANSICIÓN 1er NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==5) and ($fila1['cod_decreto']==1000)){
														echo "TRANSICIÓN 2do NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else{
														echo $fila1['grado_curso']."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}

													
													//echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
												}
											}
										?>
										
										
										<!-- FIN DEL SCRIPT DEL CURSO -->
										  
										  
										  
										  
										  </td>
                                        </tr>
                                        
                                        <tr>
                                          <td class="cuadro02"><strong>SELECCIONADO</strong></td>
                                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="5%"><label>
											   <?
											   if ($fila['seleccionado'] == 1){
											       ?>
                                                   <input name="seleccionado" type="radio" value="1" checked="checked">
                                                   <?
											   }else{
											       ?>
                                                   <input name="seleccionado" type="radio" value="1">
                                                   <?
											   }?>											   
											   	   
											  </label></td>
                                              <td width="10%" class="cuadro01">Si</td>
                                              <td width="5%" class="cuadro01"><label>
											   <?
											   if ($fila['seleccionado'] == 2){
											      ?>
                                                  <input name="seleccionado" type="radio" value="2" checked="checked">
                                                  <?
											   }else{
											   	  ?>
                                                  <input name="seleccionado" type="radio" value="2">
                                                  <?
											   }
											   ?> 
												  
											  </label></td>
                                              <td width="10%" class="cuadro01">No</td>
                                              <td class="cuadro01"><label>
											    <input name="para" maxlength="20"type="text" id="para" value="<?=$fila['para']; ?>">
                                              </label></td>
                                            </tr>
                                          </table></td>
                                        </tr>
                                        
                                      </table></TD>
                                    </TR>
                                </TABLE></TD>
                              </TR>
                            </TABLE></TD>
						</TR>
						<TR>
							<TD>
								<TABLE width=100% Border=0 cellpadding=0 cellspacing=0>
									<TR>
										
										<TD>
											<TABLE width=100% bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=left height=10 class="tablatit2-1">IMC</TD>
												</TR>
												<TR>
													<TD>
														<TABLE width=100% height=100% bgcolor=White BORDER=0>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD>
																				<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width=100%>
																					<TR>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>MARZO</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>JUNIO</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>SEPTIEMBRE</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>NOVIEMBRE</STRONG>
																							</FONT>
																						</TD>
																					</TR>
																					<TR>
																						<TD>
																		<INPUT type="text" name="txtPG3" size="5" maxlength="3" value="<?php echo $fila["pg3"]?>">
																							
																						</TD>
																						<TD>
																		<INPUT type="text" name="txtPG6" size="5" maxlength="3" value="<?php echo $fila["pg6"]?>">
																							
																						</TD>
																						<TD>
																		<INPUT type="text" name="txtPG9" size="5" maxlength="3" value="<?php echo $fila["pg9"]?>">
																		
																						</TD>
																						<TD>
																		<INPUT type="text" name="txtPG11" size="5" maxlength="3" value="<?php echo $fila["pg11"]?>">
																							
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
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD colspan=3>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color="#003b85">
										</TD>
									</TR>
								</TABLE>
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

								  
								  
								  
								  
								  
								  
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<!--fechanac = '', sexo = '', seleccionado = '', para = '' WHERE ID_FICHA = 53-->