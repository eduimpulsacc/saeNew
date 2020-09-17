<?php require('../../../util/header.inc');?>
<?php 

if($_PERFIL==0) echo $ano;

	$institucion	=$_INSTIT;
	$_POSP = 3;
	$cram = $_GET['mdi'];
	$_MDINAMICO = $cram;
	
	if ($_PERFIL == 1){
	       $_MDINAMICO = 1;
	    }   

   if ($botonera==1){
	   $frmModo="mostrar";
	}else{
	   $frmModo=$_FRMMODO;
	  }

	$ano			=$_ANO;
	$empleado		=$_EMPLEADO;


/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=". 
		$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
 ?>
 <SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
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
//				document.location="procesoMatAuto.php3"
				document.location="pre_matauto.php"				
			};
			
			function mensaje(){
				alert('Estimado usuario, /n Para traspaso de matrícula del año anterior al año actual, debe contactarse al dpto. de Soporte');		
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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php include('../../../util/rpc.php3');?>
<?php	if($frmModo=="ingresar"){
			//include('../../../util/rpc.php3');?>

			<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
			<SCRIPT language="JavaScript">
				function valida(form){
					if(!chkVacio(form.txtANO,'Ingresar numero del AÑO.')){
						return false;
					};

					if(!soloNumeros(form.txtANO,'Se permiten sólo numeros.')){
						return false;
					};
					
					 if(form.txtFECHAINI.value==""){
						alert ('debe agregar la fecha de INICIO');
					     return false;
				    };
					/*if(!chkFecha(form.txtFECHAINI,'Fecha de INICIO inválida.')){
					    return false;
				     };*/
					 
					if(form.txtFECHATER.value==""){
						alert ('debe agregar la fecha de FIN');
					     return false;
				    };
					/*if(!chkFecha(form.txtFECHATER,'Fecha de FIN inválida.')){
					    return false;
				     };*/
					 
	
					if (form.cmbREGIMEN.value==0){
						alert ('seleccione un tipo de regimen');
					     return false;
					}

					return true;
				}
			</SCRIPT>
<?php	}; ?>
<?php	if($frmModo=="modificar"){
			include('../../../util/rpc.php3');?>
			<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
			<SCRIPT language="JavaScript">
				function valida(form){
						
		if(!chkVacio(form.txtANO,'Ingresar numero del AÑO.')){
						return false;
					};

					if(!soloNumeros(form.txtANO,'Se permiten sólo numeros.')){
						return false;
					};
					
					/* if(form.txtFECHAINI.value==""){
						alert ('debe agregar la fecha de INICIO');
					     return false;
				    };*/
					/*if(!chkFecha(form.txtFECHAINI,'Fecha de INICIO inválida.')){
					    return false;
				     };*/
					 
					if(form.txtFECHATER.value==""){
						alert ('debe agregar la fecha de FIN');
					     return false;
				    };
				/*	if(!chkFecha(form.txtFECHATER,'Fecha de FIN inválida.')){
					    return false;
				     };*/
					 return true;
				}
			</SCRIPT>
<?php	}; ?>
	
<script language="JavaScript">
function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=300, height=266, top=85, left=140";
window.open(pagina,"",opciones);
}
</script> 


<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--link href="../../../estilos.css" rel="stylesheet" type="text/css"-->
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100%" align="left" valign="top">
	   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../cabecera/menu_superior.php");
			   ?>
              </td>
         </tr>
         <tr align="left" valign="top"> 
            <td height="83" colspan="3">
				   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
										
						
								  
							 <table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td valign="top">
					            	
								   <!-- AQUI VA TODA LA PROGRAMACIÓN  -->
					
	<FORM method=post name="frm" action="procesoAno.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">"
	?>
		<TABLE WIDTH=100% BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
			<TR height=15>
				<TD>
					<TABLE WIDTH="95%" height="80%" BORDER=0 align="center">
						<TR height="" >
							<TD align="right" colspan=2>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT class="botonXX" TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX" TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarAno.php3">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
							 			<?php /*if(
											($_PERFIL!= 2)&&($_PERFIL!= 4)&&($_PERFIL!=19)&&
											($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&
											($_PERFIL!= 6)&&($_PERFIL!= 3)&&($_PERFIL!= 5)&&($_PERFIL!=25)&&($_PERFIL!=26)){ */
											
											if($modifica==1){?>
												<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaAno.php3?ano=<?php echo $ano?>&caso=3">
										<?php } ?>
									
									<? if ($_INSTIT==11106 AND $_PERFIL==19){//E3TE IF SE DEBE DE ELIMINAR ESTA SOLO PARA LA STA MARIA DE OVALLE?>
									<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaAno.php3?ano=<?php echo $ano?>&caso=3">
									<? } ?>
              <?php };?>
              <?php if($frmModo=="modificar"){ ?>
              <INPUT class="botonXX" TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">
              &nbsp;
									<INPUT class="botonXX" TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaAno.php3?ano=<?php echo $ano?>&caso=1">
									&nbsp;
								<?php };?>							</TD>
						</TR>
						<TR  height="20">
							<TD colspan=2 align=middle class="fondo">A&ntilde;o Escolar</TD>
						</TR>
						<TR>
							
							<TD>
							
								<TABLE WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
									<TR >
										<TD width="13%" class="tablatit2-1">AÑO</TD>
										<TD width="18%" class="tablatit2-1">FECHA INICIO</TD>
										<TD width="18%" class="tablatit2-1">FECHA TERMINO</TD>
										<TD width="22%" class="tablatit2-1">TIPO DE REGIMEN</TD>
										<TD width="29%" class="tablatit2-1">SITUACION</TD>
									</TR>
									<TR class="tabla02">
										
                  <TD valign="top" class="cuadro01"> 
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
                    <INPUT type="hidden" name=txtANO size=6 maxlength=4  value=<?php echo $fila['nro_ano']?>> 
                    <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG><?php echo $fila['nro_ano'] ?></STRONG> </FONT> 
                    <?php };?>                  </TD>
										
                  <TD valign="top" class="cuadro01"> 
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
                    <?php };?>                  </TD>
										
                  <TD valign="top" class="cuadro01"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtFECHATER size=10 maxlength=10 > <!--onChange="chkFecha(form.txtFECHATER,'Fecha termino invalida.');"-->
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
                    <?php };?>                  </TD>
										
                  <TD valign="top" class="cuadro01"> 
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
													  </TD>
										<TD class="cuadro01">
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
															</TABLE>														</td>
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
																		</TABLE>																	</TD>
																</TR>
															</TABLE>														</td>
													</tr>
												</table>
											<?php };?>										</TD>
									</TR>
								</TABLE>							</TD>
						</TR>
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLPADDING=0 CELLSPACING=0 class="tabla02">
									<TR>
										<TD>
											<!--table border="0" align="center" cellpadding="10" cellspacing="0" class="tabla02">
                                              <tr align="center" valign="middle">
                                                <td height="23"><a href="listarAno.php3" class="boton02"><img src="../../../cortes/atras.gif" width="11" height="11" border="0"> Volver</a></td>
                                                <td><a href="#arriba" class="boton02"><img src="../../../cortes/subir.gif" width="11" height="11" border="0"> Subir</a> </td>
                                                <td class="boton02"><a href="javascript:;" onClick="window.print();" class="boton02"><img src="../../../cortes/print.gif" width="11" height="11" border="0"> Imprimir</a></td>
                                              </tr>
                                            </table-->										</TD>
									</TR>
								</TABLE>							</TD>
						</TR>
						<TR height=15>
							<TD width="100%" colspan=2 align="center">
								<?php if($frmModo=="mostrar"){
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
									
										<?php if ($fila['situacion']==1) { ?>
										      <? if (($_SESSION[_PERFIL]==0)) { //||($_SESSION[_PERFIL]==14))  ?>
											      <INPUT TYPE="button" value="GENERAR MATRICULAS" onClick="generar();" class="botonXX"> 
											 <? }?>
											 <? if (($_SESSION[_PERFIL]==14)) { //||($_SESSION[_PERFIL]==14))  ?>
											      <INPUT TYPE="button" value="GENERAR MATRICULAS" onClick="mensaje();" class="botonXX"> 
											 <? }?>
											 
										<?php }?>
					
									<?php }else{?>
										
									<?php }?>
								<?php //}?>							</TD>
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
              </FONT>			  </TD>
			</TR>
			</TABLE>			</TD>
		  </TR>			
	  </TABLE> 
	</FORM>	
									
									
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
																	
															
								  </td>
							    </tr>
							 </table>							  
							</td>  
						  </tr>
                      </table>
					 </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
		    </td>
         </tr>
       </table>
    </td>

  </tr>
</table>

</td>
    <td width="53" align="left" valign="top" height="100%" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table> 
<?
pg_close($conn);
?>
</body>
</html>
