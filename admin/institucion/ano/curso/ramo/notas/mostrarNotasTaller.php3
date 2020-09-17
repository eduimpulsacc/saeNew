<?php require('../../../../../../util/header.inc');?>

<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$taller			=$_TALLER;
	$_POSP          =6;
	$_bot           =5; 
	$docente		=5; //Codigo Docente
	
	if($aux!=1)	{//HACER LA CONSULTA Y DESPLEGAR EL PRIMER PERIODO
		$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY NOMBRE_PERIODO";
		$result =@pg_Exec($conn,$qry);
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
		else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
					exit();
				};
				$periodo	= $fila1['id_periodo'];
			}else{
				echo "NO EXISTEN PERIODOS INGRESADOS PARA ESTE AÑO";
			}
		};
	}

	$_PERIODORAMO	=	$periodo;
	if(!session_is_registered('_PERIODORAMO')){
		session_register('_PERIODORAMO');
	};
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

<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>

		<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmbPERIODO.value!=0){
				form.cmbPERIODO.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'mostrarNotasTaller.php3?aux=1&periodo='+ form.cmbPERIODO.value;
				form.submit(true);
				}
			}
		</SCRIPT>

<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include ("../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                       <? $menu_lateral="3_1"; include ("../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390">
								  <!-- inicio codigo antiguo -->
								  
	<FORM method=post name="frm">
		<TABLE WIDTH=90% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
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
									<strong>TALLER</strong>
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
											$qry="SELECT * FROM TALLER WHERE (((taller.id_taller)=".$taller."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila10 = @pg_fetch_array($result,0);	
												echo trim($fila10['nombre_taller']);
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
                          <TR>
							
                   
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50">
							<TD align=right colspan=2>
							<?php if(($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
								<INPUT class="botonXX"  TYPE="button" value="INGRESAR" name=btnCancelar onClick=document.location="ingresoNotaTaller.php3">&nbsp;
							<?php }?>	
								<INPUT class="botonXX"  TYPE="button" value="VOLVER" name=btnCancelar onClick=document.location="../seteaTaller.php3?caso=4">&nbsp;
							</TD>
						</TR>
						<TR height=20>
							<TD align=middle colspan=2 class="tableindex">
								Notas del Taller
							</TD>
						</TR>
						<TR height=20 bgcolor=white>
							<TD align=middle colspan=2 align=center>

                  <?
                  
				  
	$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano."))  order by id_periodo";
	$result =@pg_Exec($conn,$qry);
	
				  
				  
				  ?>

								  <select name="cmbPERIODO" onChange="enviapag(this.form)">
									<?php
	
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
		else{
		   if (pg_numrows($result)!=0){
			   $fila1 = @pg_fetch_array($result,0);	
		   if (!$fila1){
				error('<B> ERROR :</b>Error al acceder a la BD. (84)</B>');
				exit();
				};
		   
		   for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila1 = @pg_fetch_array($result,$i);
				if($fila1['id_periodo']==$periodo){
				echo  "<option value=".$fila1["id_periodo"]." selected>".$fila1["nombre_periodo"]."</option>";
				}else{
				echo  "<option value=".$fila1["id_periodo"].">".$fila1["nombre_periodo"]."</option>";
				}
			}
		}
	};
	
	?>
	
    </Select>
	</TD>
	</TR>
	
    <TR>
	<TD>
	
    <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=5 width=100% bgcolor="#E6E6E6">
	<?php

	
//ALUMNOS DEL CURSO
$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno 
INNER JOIN tiene_taller ON alumno.rut_alumno = tiene_taller.rut_alumno) WHERE  
((tiene_taller.id_taller)=".$taller.") ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
$result =@pg_Exec($conn,$qry);

									if (!$result) 
										error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>'.$qry);
									else{
										if (pg_numrows($result)!=0){
											$fila1 = @pg_fetch_array($result,0);	
											if (!$fila1){
												error('<B> ERROR :</b>Error al acceder a la BD. (85)</B>');
												exit();
											};

												echo "<TR class='cuadro02'>";
												echo "<td align=center>Nro.</td>";
												echo "<TD align=center>ALUMNO</TD>";
												echo "<TD align=center><STRONG>1º</STRONG></TD>";
												echo "<TD align=center><STRONG>2º</STRONG></TD>";
												echo "<TD align=center><STRONG>3º</STRONG></TD>";
												echo "<TD align=center><STRONG>4º</STRONG></TD>";
												echo "<TD align=center><STRONG>5º</STRONG></TD>";
												echo "<TD align=center><STRONG>6º</STRONG></TD>";
												echo "<TD align=center><STRONG>7º</STRONG></TD>";
												echo "<TD align=center><STRONG>8º</STRONG></TD>";
												echo "<TD align=center><STRONG>9º</STRONG></TD>";
												echo "<TD align=center><STRONG>10º</STRONG></TD>";
												echo "<TD align=center><STRONG>11º</STRONG></TD>";
												echo "<TD align=center><STRONG>12º</STRONG></TD>";
												echo "<TD align=center><STRONG>13º</STRONG></TD>";
												echo "<TD align=center><STRONG>14º</STRONG></TD>";
												echo "<TD align=center><STRONG>15º</STRONG></TD>";
												echo "<TD align=center><STRONG>16º</STRONG></TD>";
												echo "<TD align=center><STRONG>17º</STRONG></TD>";
												echo "<TD align=center><STRONG>18º</STRONG></TD>";
												echo "<TD align=center><STRONG>19º</STRONG></TD>";
												echo "<TD align=center><STRONG>20º</STRONG></TD>";
												echo "<TD align=center>PROM";
												echo "</TD>";
												echo "</TR>";

											for($i=0 ; $i < @pg_numrows($result) ; $i++){
												
												$fila1 = @pg_fetch_array($result,$i);
												
												
												if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
												
												
													if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
														?>
						<!--TR bgcolor=#ffffff onmouseover=this.style.background='yellow'; this.style.cursor='hand'; onmouseout=this.style.background='transparent'; onClick="go('ingresoNota.php3?alumno=<?php echo $fila1['rut_alumno'];?>');"-->
															<TR >
														<?php
													}else{
														echo "<TR>";
													}
												}else{
													echo "<TR>";
												}
												echo "<td align='rigth' width='20' class='cuadro01'>";
												echo  $i + 1;
												echo "</td>";
												echo "<TD align=left width=400 class='cuadro01'>";
												echo  $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_alu"];
												echo "</TD>";
													
												//NOTAS ALUMNO POR RAMO Y PERIODO
											   $qry2="SELECT * FROM notas_taller WHERE (((notas_taller.rut_alumno)='".$fila1['rut_alumno']."') AND ((notas_taller.id_periodo)=".$periodo.") AND ((notas_taller.id_taller)=".$taller."))"; 
												$result2 =@pg_Exec($conn,$qry2);
												
												
												if (!$result2) 
													error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$qry2);
												else{
													if (pg_numrows($result2)!=0){
														$fila2 = @pg_fetch_array($result2,0);
														if (!$fila2){
															error('<B> ERROR :</b>Error al acceder a la BD. (86)</B>');
															exit();
														};
														for($j=1;$j<22;$j++){
															$var="nota"."$j";
															
															echo "<TD align=center width=100 bgcolor=white class='cuadro01'>";
															
															
															if ($j==21){
															
															       if ($fila10['modo_eval']==2){
															
															    		if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I)){
															
															       			echo($fila2['promedio']);
															
															      			}
															
																	}else{  
															
															            if ($fila2['promedio']!=0){
															
															                echo($fila2['promedio']);
															
															                }
															
															            }
															
															}else{
																
			 if($fila10['modo_eval']==2){
			 
			 if( (trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I) ){
																	      echo($fila2["$var"]);
																		  }
																        
																		}else{  
															           
																	   if ($fila2["$var"]!=0){
															              echo($fila2["$var"]);
															              }
															           
																	    }
															     }
															echo "</TD>";
														}
													}else{
															echo "<TD align=center width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=center width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";

																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
															echo "<TD align=right width=100 bgcolor=white>";
																imp('');
															echo "</TD>";
													}
												};
											
											};
										};
									};
								?>
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
					</TABLE>
				
			</TR>
		</TABLE>
	</FORM>
								        
							
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
