<?php require('../../../util/header.inc');?>

<?php 
	$institucion	=$_INSTIT;
	echo $frmModo		=$_FRMMODO;
	echo $sede			=$_SEDE;
	$_POSP = 3;
	$_bot = 7;
?>

<?php
	if($frmModo!="ingresar"){
		$qry = "SELECT * FROM SEDE WHERE ID_SEDE=".$sede;
		$result = @pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (@pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				};
			};
		};
	}; 
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
	$_MENU;
	$_CATEGORIA;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <link rel="stylesheet" type="text/css" href="../../clases/jqueryui/jquery-ui-1.8.6.custom.css"> 
 
<script type="text/javascript" src="../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>    
   
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

		<?php //include('../../../util/rpc.php3');?>
<?php	if($frmModo=="ingresar"){?>
	<script>
	$(document).ready(function() {
		
  SelectRegiones();
});
		</script>	

			<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
			<SCRIPT language="JavaScript">
				function valida(form){
					if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE.')){
						return false;
					};

					if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo letras en el NOMBRE.')){
						return false;
					};

					if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
						return false;
					};

					if(!chkVacio(form.txtNUMERO,'Ingresar NUMERO.')){
						return false;
					};

					if(!nroOnly(form.txtNUMERO,'Se permiten sólo números en NUMERO.')){
						return false;
					};
					return true;
				}
				
function SelectRegiones(funcion,param){
		funcion=1;
		var parametros="funcion="+funcion;
		//alert(parametros);
		
		$.ajax({
			  url:'cont_sede.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				 // alert(data);
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					
					$('#regiones').html(data);
					
					  }
				 }
			}) 
	}
	
	
	function cargarselect2(funcion,id_region){
		var parametros="funcion="+funcion+'&id_region='+id_region;
	//	alert(parametros);
		
		$.ajax({
			  url:'cont_sede.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				//  alert(data);
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					$('#provincias').html(data);
					
					  }
				 }
			}) 
	}
	
	function cargarselect3(funcion,id_provincia){
		
		var id_region=$('#select_region').val();
		
		var parametros="funcion="+funcion+'&id_provincia='+id_provincia+'&id_region='+id_region;
		//alert(parametros);
		
		$.ajax({
			  url:'cont_sede.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
			//	  alert(data);
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					$('#comunas').html(data);
					
					  }
				 }
			}) 
	}
	
	
	
			</SCRIPT>
<?php	}; ?>
<?php	if($frmModo=="modificar"){
		?>
        <script>
	$(document).ready(function() {
		
  SelectRegiones();
});
		</script>	
        
			<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
			<SCRIPT language="JavaScript">
			function SelectRegiones(funcion,param){
		funcion=1;
		var parametros="funcion="+funcion;
		//alert(parametros);
		
		$.ajax({
			  url:'cont_sede.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				 // alert(data);
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					
					$('#regiones').html(data);
					
					  }
				 }
			}) 
	}
	
	
	function cargarselect2(funcion,id_region){
		var parametros="funcion="+funcion+'&id_region='+id_region;
	//	alert(parametros);
		
		$.ajax({
			  url:'cont_sede.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				//  alert(data);
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					$('#provincias').html(data);
					
					  }
				 }
			}) 
	}
	
	function cargarselect3(funcion,id_provincia){
		
		var id_region=$('#select_region').val();
		
		var parametros="funcion="+funcion+'&id_provincia='+id_provincia+'&id_region='+id_region;
		//alert(parametros);
		
		$.ajax({
			  url:'cont_sede.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
			//	  alert(data);
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					$('#comunas').html(data);
					
					  }
				 }
			}) 
	}
				function valida(form){
					if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE.')){
						return false;
					};

					if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo letras en el NOMBRE.')){
						return false;
					};

					if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
						return false;
					};

					if(!chkVacio(form.txtNUMERO,'Ingresar NUMERO.')){
						return false;
					};

					if(!nroOnly(form.txtNUMERO,'Se permiten sólo números en NUMERO.')){
						return false;
					};

					if(!chkSelect(f2.m2,'Seleccionar PROVINCIA.')){
						return false;
					};

					if(!chkSelect(f3.m3,'Seleccionar COMUNA.')){
						return false;
					};

					return true;
				}
			</SCRIPT>
<?php	}; ?>
	

<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
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
									
									
	
	<FORM method=post name="frm" action="procesoSede.php">
		<input type="hidden" name="rdb" value="<?=$institucion?>">
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
							<?php if($frmModo=="ingresar"){
									if($ingreso==1){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarSede.php">&nbsp;
							<?php 	}
								};?>

							<?php if($frmModo=="mostrar"){ ?>
								<?php if($elimina==1){?>
											<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaSede.php?caso=9;">&nbsp;
								<?php }
									  if($modifica==1){?>
									<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaSede.php?sede=<?php echo $sede?>&caso=3">
								<?php } 
								}?>
										<INPUT class="botonXX"  TYPE="button" value="LISTADO" onClick=document.location="listarSede.php">&nbsp;


							<?php if($frmModo=="modificar"){
										if($modifica==1){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaSede.php?sede=<?php echo $sede?>&caso=1">&nbsp;
							<?php 		};
								  }  ?>
							</TD>
						</TR>
						<TR height=20>
							<TD align=middle colspan=2 class="tableindex">		  									SEDE															</TD>
						</TR>
						<TR>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
												<TR>	
													<TD colspan="3" class="cuadro02">NOMBRE</TD>
												</TR>
												<TR>
													<TD colspan="3" class="cuadro01"><strong>
														<?php	if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtNOMBRE size=50 maxlength=200>
														<?php	};
																if($frmModo=="mostrar"){ 
																	echo (trim($fila['nombre']));
																};
																if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtNOMBRE size=50 maxlength=200 value="<?php echo trim($fila['nombre']); ?>">
														<?php	}; ?></strong>
													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD class="cuadro02">
											CALLE
										</TD>
										<TD class="cuadro02">
											NUMERO
										</TD>
										<TD class="cuadro02">
											DEPARTAMENTO
										</TD>
									</TR>
									<TR class="cuadro01">
										<TD>
											<?php	if($frmModo=="ingresar"){ ?>
														<INPUT type="text" name=txtCALLE size=50 maxlength=50>
											<?php	};
													if($frmModo=="mostrar"){ 
														echo (trim($fila['calle']));
													};
													if($frmModo=="modificar"){ ?>
														<INPUT type="text" name=txtCALLE size=50 maxlength=50 value="<?php echo trim($fila['calle']); ?>">
											<?php	}; ?>
										</TD>
										<TD>
											<?php	if($frmModo=="ingresar"){ ?>
														<INPUT type="text" name=txtNUMERO size=10 maxlength=10>
											<?php	};
													if($frmModo=="mostrar"){ 
														echo (trim($fila['nro']));
													};
													if($frmModo=="modificar"){ ?>
														<INPUT type="text" name=txtNUMERO size=10 maxlength=10 value="<?php echo trim($fila['nro']); ?>">
											<?php	}; ?>
										</TD>
										<TD>
											<?php	if($frmModo=="ingresar"){ ?>
														<INPUT type="text" name=txtDEPARTAMENTO size=10 maxlength=10>
											<?php	};
													if($frmModo=="mostrar"){ 
														echo (trim($fila['depto']));
													};
													if($frmModo=="modificar"){ ?>
														<INPUT type="text" name=txtDEPARTAMENTO size=10 maxlength=10 value="<?php echo trim($fila['depto']); ?>">
											<?php	}; ?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR class="cuadro02">
										<TD>
											BLOCK
										</TD>
										<TD colspan="2">
											VILLA
										</TD>
									</TR>
									<TR class="cuadro01">
										<TD>
											<?php	if($frmModo=="ingresar"){ ?>
														<INPUT type="text" name=txtBLOCK size=10 maxlength=10>
											<?php	};
													if($frmModo=="mostrar"){ 
														echo (trim($fila['block']));
													};
													if($frmModo=="modificar"){ ?>
														<INPUT type="text" name=txtBLOCK size=10 maxlength=10 value="<?php echo trim($fila['block']); ?>">
											<?php	}; ?>
										</TD>
										<TD colspan="2">
											<?php	if($frmModo=="ingresar"){ ?>
														<INPUT type="text" name=txtVILLA size=50 maxlength=50>
											<?php	};
													if($frmModo=="mostrar"){ 
														echo (trim($fila['villa']));
													};
													if($frmModo=="modificar"){ ?>
														<INPUT type="text" name=txtVILLA size=50 maxlength=50 value="<?php echo trim($fila['villa']); ?>">
											<?php	}; ?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>						
						<TR>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR class="cuadro02">
										<TD>
											REGION
										</TD>
										<TD>
											PROVINCIA
										</TD>
										<TD>
											COMUNA
										</TD>
									</TR>
									<TR class="cuadro01">
										<TD>
										<?php if($frmModo=="modificar"){ ?>
													<INPUT type="hidden" name=txtREG value=<?php echo $fila['region']?>>
													<INPUT type="hidden" name=txtCIU value=<?php echo $fila['ciudad']?>>
													<INPUT type="hidden" name=txtCOM value=<?php echo $fila['comuna']?>>
										<?php }else{?>
													<INPUT type="hidden" name=txtREG value=1>
													<INPUT type="hidden" name=txtCIU value=1>
													<INPUT type="hidden" name=txtCOM value=1>
										<?php }?>
	
										<?php if($frmModo=="ingresar"){ ?>
                                        
                                      

  <div id="regiones" class="saveHistory">
  
  <select >
  <option value=0 selected>Selecccionar</option>
  </select>
  </div>
							
										<?php };?>
										<?php if($frmModo=="mostrar"){ 
											 $qryREG = "SELECT * FROM REGION WHERE COD_REG=".$fila['region'];
												$resultREG	=@pg_Exec($conn,$qryREG);
												$filaREG	= @pg_fetch_array($resultREG,0);
												imp($filaREG['nom_reg']);
											  }; ?>
										<?php if($frmModo=="modificar"){ ?>
											
  <div id="regiones" class="saveHistory">
  
  <select >
  <option value=0 selected>Selecccionar</option>
  </select>
  </div>
							
										<?php }; ?>
								  </TD>
										<TD>
										<?php if($frmModo=="ingresar"){ ?>
												
  <div id="provincias" class="saveHistory">
  
  <select >
  <option value=0 selected>Selecccionar</option>
  </select>
  </div>

										<?php };?>
										<?php if($frmModo=="mostrar"){ 
												$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad'];
												$resultPRO	=@pg_Exec($conn,$qryPRO);
												$filaPRO	= @pg_fetch_array($resultPRO,0);
												imp($filaPRO['nom_pro']);
											  }; ?>
										<?php if($frmModo=="modificar"){ ?>
												
  <div id="provincias" class="saveHistory">
  
  <select >
  <option value=0 selected>Selecccionar</option>
  </select>
  </div>

										<?php };?>											
										</TD>
										<TD>
										<?php if($frmModo=="ingresar"){ ?>
											
  <div id="comunas" class="saveHistory">
  
  <select >
  <option value=0 selected>Selecccionar</option>
  </select>
  </div>

										<?php }; ?>
										<?php if($frmModo=="mostrar"){ 
												$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." AND COR_COM=".$fila['comuna'];
												$resultCOM	=@pg_Exec($conn,$qryCOM);
												$filaCOM	= @pg_fetch_array($resultCOM,0);
												imp($filaCOM['nom_com']);
											   }; ?>
										<?php if($frmModo=="modificar"){ ?>
												
  <div id="comunas" class="saveHistory">
  
  <select >
  <option value=0 selected>Selecccionar</option>
  </select>
  </div>
</FORM>
										<?php }; ?>
										</TD>
								</TR>
							  </TABLE>
							</TD>
						</TR>
						<TR>
							<TD>
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
			<TR><TD>		
				<INPUT class="botonXX"  TYPE="button" value="SALA DE CLASES"   name=btnGuardar onClick=document.location="../estancia/listarEstancia.php?menu=<?=$_MENU;?>&categoria=<?=$_CATEGORIA;?>&nw=1" >&nbsp;
			</TD></TR>

			<?php if($frmModo=="ingresar"){ ?>
					<TR height=15>
					<TD align="center">&nbsp;</TD>
				</TR>
			<?php }; ?>
			<?php if($frmModo=="mostrar"){ ?>
				<TR height=15>
					<TD align="center">&nbsp;</TD>
				</TR>
			<?php }; ?>
			<?php if($frmModo=="modificar"){?>
				<TR height=15>
					<TD align="center">&nbsp;</TD>
				</TR>
			<?php }; ?>
		</TABLE>			 
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
