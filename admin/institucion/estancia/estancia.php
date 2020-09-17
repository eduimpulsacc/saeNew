<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
echo	$frmModo		=$_FRMMODO;
	$estancia		=$_ESTANCIA;
	$_POSP = 3;
?>
<?php
	function LLenarCombo($sql,$cone,$param,$flag,$mensaje){
		$Conexion = @pg_exec($cone,$sql);
		echo "<select " . $param . ">";
		$cadena_vacio = $cadena_vacio . "&nbsp;";
		if ($flag=="true"){
			echo "<option style='Courier' value='null'>" . $mensaje . "</option>";
		};
		if ($Conexion){
			if (@pg_numrows($Conexion)!=0){
				$strValue = "       ";
				$fils = @pg_fetch_array($Conexion,0);
				for ($i=0;$i<pg_numrows($Conexion);$i++){
					$fils = @pg_fetch_array($Conexion,$i);
					echo "<option style='Courier' value='" . Trim($fils[0]) . "'>" . Trim($fils[1]) . $strValue . "</option>";
				};
			};
		};
		@pg_close($Conexion);
		echo "</select>";
	};
	
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM ESTANCIA WHERE ID_ESTANCIA=".$estancia;
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
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
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
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function SeleccionaCombo(Objeto, valor){
				for (i=0;i < Objeto.options.length; i ++){
					if (Objeto.options[i].value == valor){
						Objeto.options[i].selected = true; 
					};
				};
			};
			function valida(form){
				if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE.')){
					return false;
				};
				if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				};
				if(!chkVacio(form.txtCAPACIDAD,'Ingresar CAPACIDAD.')){
					return false;
				};

				if(!nroOnly(form.txtCAPACIDAD,'Se permiten sólo números en la CAPACIDAD.')){
					return false;
				};

				if(!chkSelect(form.cmbTIPOESTANCIA,'Seleccionar TIPO ESTANCIA.')){
					return false;
				};

				if(!chkSelect(form.cmbSECTOR,'Seleccionar SEDE-SECTOR.')){
					return false;
				};

				if(form.txtDESCRIPCION.value!=''){
					if(!alfaOnly(form.txtDESCRIPCION,'Se permiten sólo caracteres alfanuméricos en el campo DESCRIPCION.')){
						return false;
					};
				};
				return true;
			}
		</SCRIPT>
<?php }?>
	
<?php 	$str_Set_E = "{";
			if($frmModo=="modificar"){
				if ($fila['id_sede']!=""){
					$str_Set_E = $str_Set_E . "SeleccionaCombo(frm.cmbSECTOR," . $fila['id_sede'] . ");";
				};
			};
			$str_Set_E = $str_Set_E . "}"; 
	?>


</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../botones/generar_roll.gif','../../../botones/periodo_roll.gif','../../../botones/feriados_roll.gif','../../../botones/planes_roll.gif','../../../botones/tipos_roll.gif','../../../botones/cursos_roll.gif','../../../botones/matricula_roll.gif','../../../botones/reportes_roll.gif'),<?php echo $str_Set_E; ?>">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=4;
						 include("../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
 							 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
					            	<br>
									<!-- AQUI VA TODA LA PROGRAMACIÓN  -->
    <table width="" height="30" border="0" cellpadding="0" cellspacing="0"></table>
	<?php //echo tope("../../../util/");?>
	<FORM method=post name="frm" action="procesoEstancia.php">
	<?php 
	echo "<input type=hidden name=rdb value=".$institucion.">"
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){ 
										if($ingreso==1){?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarEstancia.php">&nbsp;
								<?php 	};
									}?>

								<?php if($frmModo=="mostrar"){ 
										if($modifica==1){
								?>										
										<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaEstancia.php?estancia=<?php echo $estancia?>&caso=3">&nbsp;
										<?php }
										if($elimina==1){?>
										<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaEstancia.php?caso=9;">&nbsp;
										<? } ?>
<INPUT class="botonXX"  TYPE="button" value="LISTADO" onClick=document.location="listarEstancia.php">&nbsp;
								<?php };?>

								<?php if($frmModo=="modificar"){ 
										if($modifica==1){?>
									<INPUT class="botonXX"   TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaEstancia.php?estancia=<?php echo $estancia?>&caso=1">&nbsp;
								<?php 	};
									}?>							</TD>
						</TR>
						<TR height=20>
							<TD colspan=2 align=middle class="tableindex">
								SALA DE CLASE</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR class="cuadro02">
										<TD width="45%"><STRONG>NOMBRE</STRONG></TD>
										<TD width="55%"><STRONG>CAPACIDAD</STRONG></TD>
									</TR>
									<TR class="cuadro01">
										<TD>
											<?php	if($frmModo=="ingresar"){ ?>
														<INPUT type="text" name=txtNOMBRE size=30 maxlength=50>
											<?php	};
													if($frmModo=="mostrar"){ 
														echo (trim($fila['nombre']));
													};
													if($frmModo=="modificar"){ ?>
														<INPUT type="text" name=txtNOMBRE size=30 maxlength=50 value="<?php echo trim($fila['nombre']); ?>">
											<?php	}; ?>										</TD>
										<TD>
											<?php	if($frmModo=="ingresar"){ ?>
														<INPUT type="text" name=txtCAPACIDAD size=6 maxlength=6>
											<?php	};
													if($frmModo=="mostrar"){ 
														echo (trim($fila['capacidad']));
													};
													if($frmModo=="modificar"){ ?>
														<INPUT type="text" name=txtCAPACIDAD size=6 maxlength=6 value="<?php echo trim($fila['capacidad']); ?>">
											<?php	}; ?>										</TD>
									</TR>
									<TR>
										<TD colspan="2">&nbsp;</TD>
									</TR>
									<TR class="cuadro02">
										<TD>
												<STRONG>TIPO SALA </STRONG>																					</TD>
										<TD>
												<STRONG>SEDE - SECTOR</STRONG>																					</TD>
									</TR>
									<TR class="cuadro01">
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<SELECT name="cmbTIPOESTANCIA">
													<OPTION value="">&nbsp;</OPTION>
													<OPTION value=1>SALA</OPTION>
													<OPTION value=2>LABORATORIO</OPTION>
													<OPTION value=3>GIMNASIO</OPTION>
													<OPTION value=4>PATIO</OPTION>
												</SELECT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													switch ($fila['id_tipoestancia']) {
														 case 1:
															 imp('SALA');
															 break;
														 case 2:
															 imp('LABORATORIO');
															 break;
													     case 3:
															 imp('GIMNASIO');
															 break;
														 case 4:
															 imp('PATIO');
															 break;
													 };													
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<SELECT name="cmbTIPOESTANCIA">
													<OPTION value=""></OPTION>
													<OPTION value=1 <?php if ($fila['id_tipoestancia']==1){ echo("SELECTED");};?>>SALA</OPTION>
													<OPTION value=2 <?php if ($fila['id_tipoestancia']==2){ echo("SELECTED");};?>>LABORATORIO</OPTION>
												</SELECT>
											<?php };?>										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ 
											
									LlenarCombo("SELECT id_sede, nombre FROM sede WHERE id_institucion=".$institucion."", $conn, "name='cmbSECTOR' size='1' width='40' syle='FONT-FAMILY:Verdana; FONT-SIZE:8pt'","true","");	
												?>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
												$qry = "SELECT * FROM SEDE WHERE ID_SEDE=" . $fila['id_sede'] . " AND ID_INSTITUCION=" . $institucion;
													$result = @pg_Exec($conn,$qry);
													if (!$result) {
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
													}else{
														if (@pg_numrows($result)!=0){
															$fila1 = @pg_fetch_array($result,0);	
															if (!$fila1){
																error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
																exit();
															};
															echo trim($fila1['nombre']);
														};
													};
												};
											?>
											<?php if($frmModo=="modificar"){ 
													LlenarCombo("SELECT id_sede, nombre FROM sede WHERE id_institucion=".$institucion."", $conn, "name='cmbSECTOR' size='1' width='40' syle='FONT-FAMILY:Verdana; FONT-SIZE:8pt'","true","");				
												  };
											?>										</TD>
									</TR>
									<TR>
										<TD colspan="2">&nbsp;</TD>
									</TR>
									<TR class="cuadro02">
										<TD colspan="2">
												<STRONG>DESCRIPCION</STRONG>																					</TD>
									</TR>
									<TR class="cuadro01">
										<TD colspan="2">
											<?php if($frmModo=="ingresar"){ ?>
												<TEXTAREA NAME="txtDESCRIPCION" ROWS="3" COLS="50" MAXLENGTH="500"></TEXTAREA>
											<?php }; ?>
											<?php if($frmModo=="mostrar"){ 
													imp($fila['descripcion']);
												  }; ?>
											<?php if($frmModo=="modificar"){ ?>
												<TEXTAREA NAME="txtDESCRIPCION" ROWS="3" COLS="50" MAXLENGTH="500"><?php echo (trim($fila['descripcion'])); ?></TEXTAREA>
											<?php }; ?>										</TD>										
									</TR>
								</TABLE>							</TD>
						</TR>
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#003b85>										</TD>
									</TR>
								</TABLE>							</TD>
						</TR>
					</TABLE>				</TD>
			</TR>

			
		</TABLE>
	</FORM>
									
									
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
									
									
									
									</td>
								 </tr>
							 </table>							  
								  
								  
								  
								  
		
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
