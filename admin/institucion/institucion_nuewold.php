<?php 
	require('../../util/header.inc');
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	//echo $frmModo;
	//exit;
	$estado = array (
                'pae' =>"disabled",
                'CA' =>"disabled",
                'CP' =>"disabled",
                'WS' =>"disabled",
                'CPA' =>"disabled",
                'EX' =>"disabled"
        );
	if(strcmp($frmModo,"ingresar")){
		$qry2	="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
		$result2	= @pg_Exec($conn,$qry2);
		if (!$result2) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result2)!=0){//En caso de estar el arreglo vacio.
				$fila2 = @pg_fetch_array($result2,0);	
				if (!$fila2){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}else{
					$_TIPOINSTIT = $fila2["tipo_instit"];
					if(!session_is_registered('_TIPOINSTIT')){
						session_register('_TIPOINSTIT');
					};

					$_TIPOREGIMEN = $fila2["tipo_regimen"];
					if(!session_is_registered('_TIPOREGIMEN')){
						session_register('_TIPOREGIMEN');
					};
				}
			}
		}
	}
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
		}else{
			if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
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
<link href="../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../estilos.css" rel="stylesheet" type="text/css">
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

<LINK REL="STYLESHEET" HREF="../../util/td.css" TYPE="text/css">
		<?php if($frmModo!="mostrar"){ ?>
		<?php include('../../util/rpc.php3');?>
			<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
			<?php if($frmModo=="modificar"){ ?>
				<SCRIPT language="JavaScript">
					function valida(form){
						if(!chkVacio(form.txtRDB,'Ingresar RDB.')){
							return false;
						};

						if(!nroOnly(form.txtRDB,'Se permiten sólo numeros en el RDB.')){
							return false;
						};

						if(!chkVacio(form.txtDIGRDB,'Ingresar dígito RDB.')){
							return false;
						};

						if(!chkCod(form.txtRDB,form.txtDIGRDB,'RDB invalido.')){
							return false;
						};
						
						if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE Institución.')){
							return false;
						};

						if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
							return false;
						};

						if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
							return false;
						};

						if(form.txtTELEF.value!=''){
							if(!phoneOnly(form.txtTELEF,'Se permiten sólo numeros telefónicos en el campo TELEFONO.')){
								return false;
							};
						};

						if(form.txtFAX.value!=''){
							if(!phoneOnly(form.txtFAX,'Se permiten sólo numeros telefónicos en el campo FAX.')){
								return false;
							};
						};

						if(form.txtEMAIL.value!=''){
							if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
								return false;
							};
						};
						/*
						if(!chkSelect(f1.m1,'Seleccionar REGION.')){
							return false;
						};
						*/

						if(!chkSelect(f2.m2,'Seleccionar PROVINCIA.')){
							return false;
						};

						if(!chkSelect(f3.m3,'Seleccionar COMUNA.')){
							return false;
						};

						if(!chkSelect(form.cmbINSTIT,'Seleccionar TIPO DE INSTITUCION.')){
							return false;
						};

						if(!chkSelect(form.cmbEDUC,'Seleccionar TIPO DE EDUCACION.')){
							return false;
						};

						if(!chkSelect(form.cmbREGIMEN,'Seleccionar TIPO DE REGIMEN.')){
							return false;
						};

						if(!chkSelect(form.cmbIDIOMA,'Seleccionar IDIOMA.')){
							return false;
						};

						if(!chkSelect(form.cmbSEXO,'Seleccionar SEXO.')){
							return false;
						};

						if(!chkSelect(form.cmbMETODO,'Seleccionar METODO.')){
							return false;
						};

						if(!chkSelect(form.cmbFORMACION,'Seleccionar FORMACION.')){
							return false;
						};
						if(!chkFecha(form.txtFECHARES,'Fecha inválida.')){
					        return false;
				        };
						
						return true;
					}
				</SCRIPT>
		<?php };?>
			<?php if($frmModo=="ingresar"){ ?>
				<SCRIPT language="JavaScript">
					function valida(form){
						if(!chkVacio(form.txtRDB,'Ingresar RDB.')){
							return false;
						};

						if(!nroOnly(form.txtRDB,'Se permiten sólo numeros en el RDB.')){
							return false;
						};

						if(!chkVacio(form.txtDIGRDB,'Ingresar dígito RDB.')){
							return false;
						};

						if(!chkCod(form.txtRDB,form.txtDIGRDB,'RDB invalido.')){
							return false;
						};
						
						if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE Institución.')){
							return false;
						};

						if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
							return false;
						};

						if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
							return false;
						};

						if(form.txtTELEF.value!=''){
							if(!phoneOnly(form.txtTELEF,'Se permiten sólo numeros telefónicos en el campo TELEFONO.')){
								return false;
							};
						};

						if(form.txtFAX.value!=''){
							if(!phoneOnly(form.txtFAX,'Se permiten sólo numeros telefónicos en el campo FAX.')){
								return false;
							};
						};

						if(form.txtEMAIL.value!=''){
							if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
								return false;
							};
						};

						if(!chkSelect(form.cmbINSTIT,'Seleccionar TIPO DE INSTITUCION.')){
							return false;
						};

						if(!chkSelect(form.cmbEDUC,'Seleccionar TIPO DE EDUCACION.')){
							return false;
						};

						if(!chkSelect(form.cmbREGIMEN,'Seleccionar TIPO DE REGIMEN.')){
							return false;
						};

						if(!chkSelect(form.cmbIDIOMA,'Seleccionar IDIOMA.')){
							return false;
						};

						if(!chkSelect(form.cmbSEXO,'Seleccionar SEXO.')){
							return false;
						};

						if(!chkSelect(form.cmbMETODO,'Seleccionar METODO.')){
							return false;
						};

						if(!chkSelect(form.cmbFORMACION,'Seleccionar FORMACION.')){
							return false;
						};
                        if(!chkFecha(form.txtFECHARES,'Fecha inválida.')){
					        return false;
				        };
                        if(!chkSelect(f1.m1,'Seleccionar REGION.')){
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
		<?php };?>
	<?php };?>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
		    <?
			include("../../cabecera/menu_superior.php");
			?>
		  
		  
           </td>
           </tr>
             <tr align="left" valign="top"> 
                <td height="83" colspan="3">
				<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                      
					  
					    <!-- AQUI DEBE IR EL MENU LATERAL -->
						
						<?
			            include("../../menus/menu_lateral.php");
			            ?>
						
						
						 <!-- FIN DEL MENU LATERAL -->
						
						
						
						
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr valign="top"> 
                                  <td valign="top">
								  <!-- INGRESO DE NUEVO CÓDIGO A LA PLANTILLA -->      
 <table width="739" border="0" cellpadding="0" cellspacing="0" valign="top">
  <tr valign="top">    <? if(($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?> 
    <td align="center" valign="top">
	    <?                
			include("../../cabecera/menu_inferiorinstitucion.php");
		?>
		
	</td>	
	  
	  
<? } ?>


 <FORM method=post name="frm" action="procesoInstitucion.php3">
	<?php //echo tope("../../util/");?>
            <TD width=30></TD> 
		<TABLE WIDTH=90% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE WIDTH="90%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
                              <TD width=30></TD> 
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){ ?>
                                         
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;
									<?php if($_PERFIL==0) {?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarInstituciones.php3?modo=ini">&nbsp;
									<? }?>
								<?php };?>
								<?php if($frmModo=="mostrar"){ ?>
                                              
									<?php if(($_PERFIL==0) || ($_PERFIL==14)){ 	?>
										<?php // if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
											<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaInstitucion.php3?institucion=<?php echo $institucion?>&caso=3">&nbsp; 
                                             <?php // if($_PERFIL==0 ){ //SOLO ADMINISTRADOR GENERAL?>
                                                <!--<INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar onclick=document.location="seteaInstitucion.php3?caso=9">&nbsp; -->
												
												<!--INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="LISTADO" onClick=document.location="listarInstituciones.php3?modo=ini"-->&nbsp;
											<?php // };?>
										<?php // };?>
									<?php }?>
                                 <?php };?>
                             <?php if($frmModo=="modificar"){ ?>
                                    <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaInstitucion.php3?institucion=<?php echo $institucion?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
                       
						<TR height=20 bgcolor="#003b85" >
 							<TD align=middle colspan=2 class="tableindex">
								INSTITUCION
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD colspan=3>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>RBD</STRONG>
											</FONT>
										</TD>

                                        <td rowspan=2 valign=top width=194></td>
                                     
									</TR>
									<TR>
										
              <TD width="92"> 
                <?php if($frmModo=="ingresar"){ ?>
                                       
                <INPUT type="text" name=txtRDB size=10 maxlength=10 onChange="checkRutField(this);">
                                             <?php };?>
                                             <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['rdb']);
												};?>
                                             <?php if($frmModo=="modificar"){ 
												imp($fila['rdb']);
											};?>
                                        </TD>
										<TD width="14" align="center">&nbsp;-&nbsp;</TD>
										<TD width="117" align="left">
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtDIGRDB size=1 maxlength=1 >
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['dig_rdb']);
												};
											?>
											<?php if($frmModo=="modificar"){ 
												imp($fila['dig_rdb']);
											};?>
										</TD>
                                        
                                         
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE width="768" BORDER=0 CELLPADDING=0 CELLSPACING=0>
            <TR>
										
              <TD width="500"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                <STRONG>NOMBRE ESTABLECIMIENTO</STRONG> </FONT> </TD>
									</TR>
									<TR>
										
              <TD> 
                <?php if($frmModo=="ingresar"){ ?>
				<input type="text" name=txtNOMBRE size=83 maxlength=50>
                <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['rdb']);
												};
											?>
                <?php };?>
                <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['nombre_instit']);
												};
											?>
                <?php if($frmModo=="modificar"){ ?>
                <INPUT type="text" name=txtNOMBRE size=83 maxlength=50 value="<?php echo trim($fila['nombre_instit'])?>">
											<?php };?>
										</TD>
									</TR>
								</TABLE>
						   	</TD>
						</TR>						
<!---------------------------------------------------------------------------------------------------!-->
                          <TR> 
							<TD width=30></TD>							
        <TD align=left> 
          <TABLE width=74% BORDER=0 CELLPADDING=0 CELLSPACING=0 bgcolor=White>
            
              <TD width="49%" valign="top"> 
                  <TABLE width="365" BORDER=0 align="left" CELLPADDING=0 CELLSPACING=0>
                  <TR> 
                      <TD width="300" height="17" valign="top"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>Nº RESOLUCION (Nombre establecimiento)</STRONG> 
                        </FONT> 
					  </TD>
                  </TR>
             <TR> 
                      
                    <TD height="24" valign="top"> 
                      <?php if($frmModo=="ingresar"){ ?>
                      <input type="text" name=txtNRES size=20 maxlength=30>
					<?php };?>
					<?php 
									 if($frmModo=="mostrar"){ 
									   imp($fila['nu_resolucion']);
									   };
									?>
                        <?php if($frmModo=="modificar"){ ?>
                        <input type="text" name=txtNRES size=20 maxlength=30 value="<?php echo trim($fila['nu_resolucion'])?>"> 
                        <?php };?>
                         </TD>
                    </TR>
                  </TABLE>
                </TD>
              <TD width="49%" height="57" valign="top"> <div align="left"> 
                  <TABLE width="349" BORDER=0 align="left" CELLPADDING=0 CELLSPACING=0>
                    <TR> 
                      <TD width="374" height="17" valign="top"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>FECHA DE RESOLUCION (Nombre de establecimiento)</STRONG></FONT> 
                      </TD>
                    </TR>
                    <TR> 
                      <TD height="40" valign="top" > 
                        <?php if($frmModo=="ingresar"){ ?>
                        <input type="text" name=txtFECHARES size=20 maxlength=10 onChange="chkFecha(form.txtFECHARES,'Fecha invalida.');">
                          <br> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>DD-MM-AAAA</STRONG></FONT>  
                        <?php };?>
                        <?php 
										if($frmModo=="mostrar"){ 
										  impF($fila['fecha_resolucion']);
										  };
									  ?>
                        <?php if($frmModo=="modificar"){ ?>
                        <INPUT type="text" name=txtFECHARES size=20 maxlength=50 value="<?php impF($fila['fecha_resolucion'])?>" onChange="chkFecha(form.txtFECHARES,'Fecha invalida.');">
                        <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>DD-MM-AAAA</STRONG></FONT> 
                        <?php };?>
                      </TD>
                    </TR>
                  </TABLE>
                </div></TD>
            </TR>
          </TABLE>
							</TD>
						</TR>
						
						<TR>
							<TD width=30></TD>
							
        <TD align=left> 
          <TABLE width=74% height="97" BORDER=0 CELLPADDING=0 CELLSPACING=2 bgcolor=White>
            <TR> 
              <TD width="25%" height="93" valign="top"> 
                <div align="left"> 
                  <TABLE width="168" BORDER=0 align="left" CELLPADDING=0 CELLSPACING=0>
                    <TR> 
                      <TD width="168"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>LETRA</STRONG> </FONT> </TD>
                    </TR>
                    <TR> 
                      <TD height="56"> 
                        <?php if($frmModo=="ingresar"){ ?>
                        <input type="text" name=txtLETRA size=5 maxlength=30> 
                        <?php };?>
                        <?php 
										 if($frmModo=="mostrar"){ 
										   imp($fila['letra_inst']);
										   };
										?>
                        <?php if($frmModo=="modificar"){ ?>
                        <INPUT type="text" name=txtLETRA size=5 maxlength=30 value="<?php echo trim($fila['letra_inst'])?>"> 
                        <?php };?>
                        <br> </TD>
                    </TR>
                  </TABLE>
                </div></TD>
              <TD width="29%" height="80" valign="top"> 
                <div align="left"> 
                  <TABLE width="235" BORDER=0 align="left" CELLPADDING=0 CELLSPACING=0>
                    <TR> 
                      <TD width="191" height="25"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>NUMERO</STRONG></FONT></TD>
                    </TR>
                    <TR> 
                      <TD height="34"> 
                        <?php if($frmModo=="ingresar"){ ?>
                        <INPUT type="text" name=txtNUMINST size=5 maxlength=30> 
                        <?php };?>
                        <?php 
										if($frmModo=="mostrar"){ 
										  imp($fila['numero_inst']);
										  };
									  ?>
                        <?php if($frmModo=="modificar"){ ?>
                        <INPUT type="text" name=txtNUMINST size=5 maxlength=30 value="<?php echo trim($fila['numero_inst'])?>">
                        <?php };?>
                      </TD>
                       
                    </TR>
                  </TABLE>
                </div></TD>

                       
              <TD width="46%" height="75"> 
                <div align="left"> 
                  <TABLE width="319" BORDER=0 align="left" CELLPADDING=0 CELLSPACING=0>
                    <TR> 
                      <TD width="319"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>DEPENDENCIA</STRONG> </FONT> </TD>
                    </TR>
                    <TR> 
                      <TD height="82"> 
                        <?php 
 
                          if($frmModo=="ingresar"){ ?>
                        <Select name="cmbDEP">
														<option value=0 >PARTICULAR SUBVENCIONADO</option>
														<option value=1 >PARTICULAR</option>
														<option value=2 >MUNICIPAL</option>
														<option value=3 selected>OTROS</option>
													</Select> 
                        <?php };?>
                        <?php 
										 if($frmModo=="mostrar"){ 
                                         
														switch ($fila['dependencia']) {
															 case 0:
																 imp('PARTICULAR SUBVENCIONADO');
																 break;
															 case 1:
																 imp('PARTICULAR');
																 break;
															 case 2:
																 imp('MUNICIPAL');
																 break;
															 case 3:
																 imp('OTROS');
																 break;
														 };
													};    
										  
										  
										?>
                        <?php if($frmModo=="modificar"){ ?>
                        <Select name="cmbDEP">
															<option value=0 <?php if($fila['dependencia']==0){ echo "selected";}?>>PARTICULAR SUBVENCIONADO</option>
															<option value=1 <?php if($fila['dependencia']==1){ echo "selected";}?>>PARTICULAR</option>
															<option value=2 <?php if($fila['dependencia']==2){ echo "selected";}?>>MUNICIPAL</option>
															<option value=3 <?php if($fila['dependencia']==3){ echo "selected";}?>>OTROS</option>
														</Select>
                        <?php };?>
                        <br> </TD>
                    </TR>
                  </TABLE>
                </div></TD>
               
            </TR>
          </TABLE>
		</TD>
		</TR>
						<TR>
							<TD width=30></TD>
							
        <TD>&nbsp; </TD>
						</TR>
<!---------------------------------------------------------------------------------------------------!-->
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 width=100%>
            <TR>
										<TD width="22%">
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>TELEFONO</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name=txtTELEF size=20 maxlength=30>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																imp($fila['telefono']);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name=txtTELEF size=20 maxlength=30 value="<?php echo trim($fila['telefono'])?>">
														<?php };?>
													</TD>
												</TR>
											</TABLE>
										</TD>
										<TD width="34%">
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>FAX</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name=txtFAX size=20 maxlength=30>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																imp($fila['fax']);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name=txtFAX size=20 maxlength=30 value="<?php echo trim($fila['fax'])?>">
														<?php };?>
													</TD>
												</TR>
											</TABLE>
										</TD>
										<TD width="44%">
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD width="281">
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>EMAIL</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name=txtEMAIL size=20 maxlength=50>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																imp($fila['email']);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name=txtEMAIL size=20 maxlength=50 value="<?php echo trim($fila['email'])?>">
														<?php };?>
													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 width=100%>
            <TR> 
              <TD width="25%" height="82"> 
                <div align="left"> 
                  <TABLE width="179" BORDER=0 CELLPADDING=0 CELLSPACING=0>
                    <TR> 
                      <TD width="182"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>TIPO INSTITUCION</STRONG> </FONT> </TD>
                    </TR>
                    <TR> 
                      <TD> 
                        <?php if($frmModo=="ingresar"){ ?>
                        <select name="cmbINSTIT">
                          <option value=0 selected></option>
                          <option value=1 >Colegio</option>
                          <option value=2 >Jardin Infantil</option>
                          <option value=3 >Sala Cuna</option>
                        </select> 
                        <?php };?>
                        <?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['tipo_instit']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Colegio');
																		 break;
																	 case 2:
																		 imp('Jardin Infantil');
																		 break;
																	 case 3:
																		 imp('Sala Cuna');
																		 break;
																 };
															};
	 														if($frmModo=="modificar"){ ?>
                                                              <Select name="cmbINSTIT">
                                                              <option value=0 ></option>
                                                              <option value=1 <?php echo ($fila['tipo_instit'])==1?"selected":"" ?>>Colegio</option>
                                                              <option value=2 <?php echo ($fila['tipo_instit'])==2?"selected":"" ?>>Jardin Infantil</option>
                                                              <option value=3 <?php echo ($fila['tipo_instit'])==3?"selected":"" ?>>Salacuna</option>
                                                                    </Select> 
                        <?php }; ?>
                      </TD>
                    </TR>
                  </TABLE>
                </div></TD>
              <TD width="27%"> <div align="left"> 
                  <TABLE width="274" BORDER=0 CELLPADDING=0 CELLSPACING=0>
                    <TR> 
                      <TD width="274"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>TIPO EDUCACION</STRONG> </FONT> </TD>
                    </TR>
                    <TR> 
                      <TD> 
                        <?php if($frmModo=="ingresar"){ ?>
                        <Select name="cmbEDUC" >
                          <option value=0 selected></option>
                          <option value=1 >Kinder</option>
                          <option value=2 >Basica</option>
                          <option value=3 >Media</option>
                          <option value=4 >Kinder - Basica</option>
                          <option value=5 >Basica - Media</option>
                          <option value=6>Completa</option>
                        </Select> 
                        <?php };?>
                        <?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['tipo_educ']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Kinder');
																		 break;
																	 case 2:
																		 imp('Básica');
																		 break;
																	 case 3:
																		 imp('Media');
																		 break;
																	 case 4:
																		 imp('Kinder - Basica');
																		 break;
																	 case 5:
																		 imp('Básica - Media');
																		 break;
																	 case 6:
																		 imp('Completa');
																		 break;
																 };
															};
														?>
                        <?php 
															if($frmModo=="modificar"){ 
														  ?>
                        <Select name="cmbEDUC" >
                          <option value=0 ></option>
                          <option value=1 <?php echo ($fila['tipo_educ'])==1?"selected":"" ?>>Kinder</option>
                          <option value=2 <?php echo ($fila['tipo_educ'])==2?"selected":"" ?>>Basica</option>
                          <option value=3 <?php echo ($fila['tipo_educ'])==3?"selected":"" ?>>Media</option>
                          <option value=4 <?php echo ($fila['tipo_educ'])==4?"selected":"" ?>>Kinder - Basica</option>
                          <option value=5 <?php echo ($fila['tipo_educ'])==5?"selected":"" ?>>Basica - Media</option>
                          <option value=6 <?php echo ($fila['tipo_educ'])==6?"selected":"" ?>>Completa</option>
                        </Select> 
                        <?php };?>
                      </TD>
                    </TR>
                  </TABLE>
                </div></TD>
              <TD width="12%"> <div align="left"> 
                  <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
                    <TR> 
                      <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG></STRONG> </FONT> </TD>
                    </TR>
                    <TR> 
                      <TD> 
                        <?php /* if($frmModo=="ingresar"){ ?>
                        <Select name="cmbREGIMEN">
                          <option value=0 selected></option>
                          <option value=1>Indeterminado</option>
                          <option value=2>Trimestral</option>
                          <option value=3>Semestral</option>
                        </Select> 
                        <?php }; ?>
                        <?php 
															if($frmModo=="mostrar"){ 
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
                        <?php if($frmModo=="modificar"){ ?>
                        <Select name="cmbREGIMEN" >
                          <option value=0 ></option>
                          <option value=1 <?php echo ($fila['tipo_regimen'])==1?"selected":"" ?>>Indeterminado</option>
                          <option value=2 <?php echo ($fila['tipo_regimen'])==2?"selected":"" ?>>Trimestral</option>
                          <option value=3 <?php echo ($fila['tipo_regimen'])==3?"selected":"" ?>>Semestral</option>
                        </Select> 
                        <?php }; */?>
                      </TD>
                    </TR>
                  </TABLE>
                </div></TD>
              <TD width="36%"> <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
                  <TR> 
                    <TD width="324"> <div align="left"><FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>IDIOMA</STRONG> </FONT> </div></TD>
                  </TR>
                  <TR> 
                    <TD> 
                      <?php if($frmModo=="ingresar"){ ?>
                      <div align="left"> 
                        <Select name="cmbIDIOMA">
                          <option value=0 selected></option>
                          <option value=1 >Español</option>
                          <option value=2 >Ingles</option>
                          <option value=3 >Alemán</option>
                          <option value=4 >Bilingüe</option>
                          <option value=5 >Otros</option>
                        </Select>
                        <?php };?>
                        <?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['idioma']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Español');
																		 break;
																	 case 2:
																		 imp('Ingles');
																		 break;
																	 case 3:
																		 imp('Alemán');
																		 break;
																	 case 4:
																		 imp('Bilingue');
																		 break;
																	 case 5:
																		 imp('Otros');
																		 break;
																 };
															};
														?>
                        <?php if($frmModo=="modificar"){ ?>
                        <Select name="cmbIDIOMA">
                          <option value=0 ></option>
                          <option value=1 <?php echo ($fila['idioma'])==1?"selected":"" ?>>Español</option>
                          <option value=2 <?php echo ($fila['idioma'])==2?"selected":"" ?>>Ingles</option>
                          <option value=3 <?php echo ($fila['idioma'])==3?"selected":"" ?>>Alemán</option>
                          <option value=4 <?php echo ($fila['idioma'])==4?"selected":"" ?>>Bilingüe</option>
                          <option value=5 <?php echo ($fila['idioma'])==5?"selected":"" ?>>Otros</option>
                        </Select>
                        <?php };?>
                      </div></TD>
                  </TR>
                </TABLE></TD>
            </TR>
            <TR> 
              <TD height="57"> <div align="left"> 
                  <TABLE width="232" BORDER=0 CELLPADDING=0 CELLSPACING=0>
                    <TR> 
                      <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>SEXO</STRONG> </FONT> </TD>
                    </TR>
                    <TR> 
                      <TD height="41"> 
                        <?php if($frmModo=="ingresar"){ ?>
                        <Select name="cmbSEXO" >
                          <option value=0 selected></option>
                          <option value=1 >Mixto</option>
                          <option value=2 >Masculino</option>
                          <option value=3 >Femenino</option>
                        </Select> 
                        <?php };?>
                        <?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['sexo']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Mixto');
																		 break;
																	 case 2:
																		 imp('Masculino');
																		 break;
																	 case 3:
																		 imp('Femenino');
																		 break;
																 };
															};
														?>
                        <?php if($frmModo=="modificar"){ ?>
                        <Select name="cmbSEXO" >
                          <option value=0 ></option>
                          <option value=1 <?php echo ($fila['sexo'])==1?"selected":"" ?>>Mixto</option>
                          <option value=2 <?php echo ($fila['sexo'])==2?"selected":"" ?>>Masculino</option>
                          <option value=3 <?php echo ($fila['sexo'])==3?"selected":"" ?>>Femenino</option>
                        </Select> 
                        <?php };?>
                      </TD>
                    </TR>
                  </TABLE>
                </div></TD>
              <TD> <div align="left"> 
                  <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
                    <TR> 
                      <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>METODO</STRONG> </FONT> </TD>
                    </TR>
                    <TR> 
                      <TD height="46"> 
                        <?php if($frmModo=="ingresar"){ ?>
                        <Select name="cmbMETODO">
                          <option value=0 selected></option>
                          <option value=1 >Tradicional</option>
                          <option value=2 >Personalizado</option>
                          <option value=3 >Montessori</option>
                          <option value=4 >Internacional</option>
                          <option value=5 >Activa</option>
                          <option value=6 >Transtorno</option>
                          <option value=7 >Curriculum Integrado</option>
                          <option value=8 >Waldorf</option>
                        </Select> 
                        <?php };?>
                        <?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['metodo']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Tradicional');
																		 break;
																	 case 2:
																		 imp('Personalizado');
																		 break;
																	 case 3:
																		 imp('Montessori');
																		 break;
																	 case 4:
																		 imp('Internacional');
																		 break;
																	 case 5:
																		 imp('Activa');
																		 break;
																	 case 6:
																		 imp('Transtorno');
																		 break;
																	 case 7:
																		 imp('Curriculum Integrado');
																		 break;
																	 case 6:
																		 imp('Waldorf');
																		 break;
																 };
															};
														?>
                        <?php if($frmModo=="modificar"){ ?>
                        <Select name="cmbMETODO">
                          <option value=0 ></option>
                          <option value=1 <?php echo ($fila['metodo'])==1?"selected":"" ?> >Tradicional</option>
                          <option value=2 <?php echo ($fila['metodo'])==2?"selected":"" ?> >Personalizado</option>
                          <option value=3 <?php echo ($fila['metodo'])==3?"selected":"" ?>>Montessori</option>
                          <option value=4 <?php echo ($fila['metodo'])==4?"selected":"" ?>>Internacional</option>
                          <option value=5 <?php echo ($fila['metodo'])==5?"selected":"" ?>>Activa</option>
                          <option value=6 <?php echo ($fila['metodo'])==6?"selected":"" ?>>Transtorno</option>
                          <option value=6 <?php echo ($fila['metodo'])==7?"selected":"" ?>>Curriculum 
                          Integrado</option>
                          <option value=8 <?php echo ($fila['metodo'])==8?"selected":"" ?>>Waldorf</option>
                        </Select> 
                        <?php };?>
                      </TD>
                    </TR>
                  </TABLE>
                </div></TD>
              <TD colspan=2> <div align="left"> 
                  <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
                    <TR> 
                      <TD valign="top"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>FORMACION</STRONG> </FONT> </TD>
                    </TR>
                    <TR> 
                      <TD height="42" valign="center"> 
                        <?php if($frmModo=="ingresar"){ ?>
                        <Select name="cmbFORMACION">
                          <option value=0 selected></option>
                          <option value=1 >Católica</option>
                          <option value=2 >Laica</option>
                          <option value=3 >Cristiana</option>
                        </Select> 
                        <?php };?>
                        <?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['formacion']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Católica');
																		 break;
																	 case 2:
																		 imp('Laica');
																		 break;
																	 case 3:
																		 imp('Cristiana');
																		 break;
																 };
															};
														?>
                        <?php if($frmModo=="modificar"){ ?>
                        <Select name="cmbFORMACION">
                          <option value=0 ></option>
                          <option value=1 <?php echo ($fila['formacion'])==1?"selected":"" ?>>Católica</option>
                          <option value=2 <?php echo ($fila['formacion'])==2?"selected":"" ?>>Laica</option>
                          <option value=3 <?php echo ($fila['formacion'])==3?"selected":"" ?>>Cristiana</option>
                        </Select> 
                        <?php };?>
                      </TD>
                    </TR>
                  </TABLE>
                </div></TD>
            </TR>
          </TABLE>
							</TD>
						</TR>
						<TR>
           
							<TD width=30></TD>
							<TD>
								<TABLE width=660 bgcolor=#cccccc height=100 Border=0 cellpadding=1 cellspacing=0>
									<TR>
										<TD align=left height=10>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>DIRECCION</STRONG>
											</FONT>
										</TD>
									</TR>

									<TR>
										<TD>
											<TABLE width=712 height=100% bgcolor=White BORDER=0>
												<TR>
													<TD>
													<TR height="100%">
													<TD width="4%"></TD>
													<TD width="48%">
													<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
                    <TR>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>CALLE</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtCALLE size=35 maxlength=50>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['calle']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtCALLE size=35 maxlength=50 value="<?php echo trim($fila['calle'])?>" >
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD><TD width="48%">
													<TABLE WIDTH=101% BORDER=0 CELLSPACING=0 CELLPADDING=0>
                    <TR>
															<TD width="57%">
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>NRO</STRONG>
																</FONT>
															</TD>
															<TD width="43%">
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>AREA GEOGRAFICA</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtNRO size=12 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['nro']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtNRO size=10 maxlength=5 value=<?php echo $fila['nro']?> >
																<?php };?>
															</TD>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<SELECT NAME= txtAREAG >
                                                                      <OPTION>
                                                                      <OPTION>RURAL
                                                                      <OPTION>URBANO
                                                                     </SELECT>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['area_geo']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	
																	<SELECT NAME= txtAREAG >
                                                                      <OPTION><?php echo $fila['area_geo']?>
                                                                      <OPTION>RURAL
                                                                      <OPTION>URBANO
                                                                     </SELECT>
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD>
													
													<!--F7-->
													<TR height="100%">
													<TD width="4%"></TD>
													<TD width="48%">
													<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
                    <TR>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>DEPTO&nbsp;&nbsp;&nbsp;(OPCIONAL)</STRONG>
																</FONT>
															</TD>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>BLOCK&nbsp;&nbsp;&nbsp;(OPCIONAL)</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtDEP size=12 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['depto']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtDEP size=12 maxlength=10 value="<?php echo $fila['depto']?>" >
																<?php };?>
															</TD>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtBLO size=12 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['block']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtBLO size=12 maxlength=10 value="<?php echo $fila['txtBLO']?>">
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD>
													<TD width="48%">
													<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
														<TR>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>VILLA/POBL&nbsp;&nbsp;&nbsp;(OPCIONAL)</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtVIL size=34 maxlength=50>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['villa']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtVIL size=34 maxlength=50 value="<?php echo trim($fila['villa'])?>">
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD>
													</TR>

													<?php if($frmModo=="modificar"){ ?>
														<INPUT type="hidden" name=txtREG value=<?php echo $fila['region']?>>
														<INPUT type="hidden" name=txtCIU value=<?php echo $fila['ciudad']?>>
														<INPUT type="hidden" name=txtCOM value=<?php echo $fila['comuna']?>>
													<?php }else{?>
														<INPUT type="hidden" name=txtREG>
														<INPUT type="hidden" name=txtCIU>
														<INPUT type="hidden" name=txtCOM>
													<?php }?>

</FORM> 	
													<TR height="100%">
														<TD width="4%"></TD>
														<TD COLSPAN=2>
															<TABLE width=96% height=100% bgcolor=White BORDER=0  CELLSPACING=0 CELLPADDING=0>
																<TR>
																	<TD width="29%">
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
																			<TR>
																				<TD>
																					<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																						<STRONG>REGION</STRONG>
																					</FONT>
																				</TD>
																			</TR>
																			<TR>
																				<TD>
																					<?php if($frmModo=="ingresar"){ ?>
<FORM method=post name=f1 onSubmit="return false;">
	<SELECT class=saveHistory id=m1 name=m1 onChange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
	<?php
		//SELECCIONAR TODAS LAS REGIONES
		$qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
		$resultREG	=@pg_Exec($connRPC,$qryREG);
		for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
			$filaREG = @pg_fetch_array($resultREG,$i);
			echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." </OPTION>\n";
		}//for resultREG
	?>
	</SELECT>
</FORM>

																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"){ 
																	$qryREG		="SELECT * FROM REGION WHERE COD_REG=".$fila['region'];
																	$resultREG	=@pg_Exec($conn,$qryREG);
																	$filaREG	= @pg_fetch_array($resultREG,0);
																	imp($filaREG['nom_reg']);
																						};
																					?>
			<?php if($frmModo=="modificar"){ ?>
				<!--INPUT type="text" name=txtREG size=20 value="<?php echo $fila['region']?>"-->
<FORM method=post name=f1 onSubmit="return false;">
	<SELECT class=saveHistory id=m1 name=m1 onChange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
	<?php
		//SELECCIONAR TODAS LAS REGIONES
		$qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
		$resultREG	=@pg_Exec($connRPC,$qryREG);
		for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
			$filaREG = @pg_fetch_array($resultREG,$i);
			if($filaREG['cod_reg']==$fila['region'])
				echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\" selected>".trim($filaREG['nom_reg'])." </OPTION>\n";
				else
					echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." </OPTION>\n";
		}//for resultREG
	?>
	</SELECT>
</FORM>

			<?php };?>
																				</TD>
																			</TR>
																		</TABLE>
																	</TD>
																	<TD width="21%">
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
																			<TR>
																				<TD>
																					<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																						<STRONG>PROVINCIA</STRONG>
																					</FONT>
																				</TD>
																			</TR>
																			<TR>
																				<TD>
																					<?php if($frmModo=="ingresar"){ ?>
<FORM method=post name=f2 onSubmit="return false;">
	<SELECT class=saveHistory id=m2 name=m2 onChange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;"> 
	<?php
		//SELECCIONAR TODAS LAS PROVINCIAS
		$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=1 ORDER BY NOM_PRO ASC";
		$resultPRO	=@pg_Exec($connRPC,$qryPRO);
		for($i=0 ; $i < @pg_numrows($resultPRO) ; $i++){
			$filaPRO = @pg_fetch_array($resultPRO,$i);
			echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\">".trim($filaPRO['nom_pro'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT>
</FORM>

																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"){ 
										$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad'];
										$resultPRO	=@pg_Exec($conn,$qryPRO);
										$filaPRO	= @pg_fetch_array($resultPRO,0);
										imp($filaPRO['nom_pro']);
																						};
																					?>
<?php if($frmModo=="modificar"){ ?>
	<!--INPUT type="text" name=txtCIU size=20 value=<?php echo $fila['ciudad']?>-->

<FORM method=post name=f2 onSubmit="return false;">
	<SELECT class=saveHistory id=m2 name=m2 onChange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;"> 
	<?php
		//SELECCIONAR TODAS LAS PROVINCIAS
		$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila['region']." ORDER BY NOM_PRO ASC";
		$resultPRO	=@pg_Exec($connRPC,$qryPRO);
		for($i=0 ; $i < @pg_numrows($resultPRO) ; $i++){
			$filaPRO = @pg_fetch_array($resultPRO,$i);
			if($filaPRO['cor_pro']==$fila['ciudad'])
				echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\" selected>".trim($filaPRO['nom_pro'])." </OPTION>\n";
				else
					echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\">".trim($filaPRO['nom_pro'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT>
</FORM>


<?php };?>
																				</TD>
																			</TR>
																		</TABLE>
																	</TD>
																	<TD width="50%">
																		<TABLE WIDTH=95% BORDER=0 CELLSPACING=0 CELLPADDING=0>
																			<TR>
																				<TD>
																					<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																						<STRONG>COMUNA</STRONG>
																					</FONT>
																				</TD>
																			</TR>
																			<TR>
																				<TD>
																					<?php if($frmModo=="ingresar"){ ?>
<FORM  method=post name=f3 onSubmit="return false;">
                  <select class=saveHistory id=select name=select onChange="document.frm.txtCOM.value=document.f3.m3.value;">
                    <?php
		//SELECCIONAR TODAS LAS COMUNAS
		$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=1 AND COR_PRO=1 ORDER BY NOM_COM ASC";
		$resultCOM	=@pg_Exec($connRPC,$qryCOM);
		for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
			$filaCOM = @pg_fetch_array($resultCOM,$i);
			echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\">".trim($filaCOM['nom_com'])." </OPTION>\n";
		}//for resultPRO
	?>
                  </select>
                </FORM>
																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"){ 
			$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." AND COR_COM=".$fila['comuna'];
			$resultCOM	=@pg_Exec($conn,$qryCOM);
			$filaCOM	= @pg_fetch_array($resultCOM,0);
			imp($filaCOM['nom_com']);
																						};
																					?>
																					<?php if($frmModo=="modificar"){ ?>
											<!--INPUT type="text" name=txtCOM size=20 value=<?php echo $fila['comuna']?>-->

<FORM method=post name=f3 onSubmit="return false;">
	<SELECT class=saveHistory id=m3 name=m3 onChange="document.frm.txtCOM.value=document.f3.m3.value;"> 
	<?php
		//SELECCIONAR TODAS LAS COMUNAS
		$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." ORDER BY NOM_COM ASC";
		$resultCOM	=@pg_Exec($connRPC,$qryCOM);
		for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
			$filaCOM = @pg_fetch_array($resultCOM,$i);
			if($filaCOM['cor_com']==$fila['comuna'])
				echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\" selected>".trim($filaCOM['nom_com'])." </OPTION>\n";
				else
					echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\" >".trim($filaCOM['nom_com'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT> 
</FORM>
<?php };?>
																				</TD>
																			</TR>
																		</TABLE>
																	</TD>
																</TR>
															</TABLE>
														</TD>
													</TR>
                                               
													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>						
							</TD>
						</TR>
						
<?php						
			 if(($frmModo=="mostrar") or ($frmModo=="modificar")){ ?>			
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE width=712 bgcolor=#cccccc height=100 Border=0 cellpadding=1 cellspacing=0>
      <TR>
										<TD width="684" height=10 align=left>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>DATOS DEL DIRECTOR</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<TABLE width=100% height=100% bgcolor=White BORDER=0>
            <TR height="100%"> 
              <TD width="63%"> <TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
                  <TR> 
                    <TD width="24"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                      <STRONG>RUN</STRONG> </FONT> </TD>
                  </TR>
                  <TR> 
                    <TD> 
                      <?php
                           if(($frmModo=="mostrar") or ($frmModo=="modificar")){
                                $qryEMP="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
		                    $resultEMP =@pg_Exec($conn,$qryEMP);
		                  if (!$resultEMP) {
			                   error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		                    }else{
			                if (pg_numrows($resultEMP)!=0){//En caso de estar el arreglo vacio.
				                  $filaEMP = @pg_fetch_array($resultEMP,0);	
				                if (!$filaEMP){
					           error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					          exit();
				                 }
			                   }
		                     }
                           } 
                                                                      
	                        if($frmModo=="mostrar"){                              
                             imp($filaEMP['rut_emp']);
                                };
                            if($frmModo=="modificar"){ 
							  imp($filaEMP['rut_emp']);
								};
                       ?>
              </TD>

                     <TD width="13" align="center">&nbsp;-&nbsp;</TD>
										
                    <TD width="372" align="left"> 
                      <?php if($frmModo=="ingresar"){ 
						     imp($filaEMP['dig_rut']);
					     };?>
                      <?php 
							if($frmModo=="mostrar"){ 
							 imp($filaEMP['dig_rut']);
						};
						 ?>
                       <?php if($frmModo=="modificar"){ 
						imp($filaEMP['dig_rut']);
						};?>
                    </TD>

                  </TR>
                </TABLE></TD>
              <TD width="37%">&nbsp; </TD>
              <!--F7-->
            <TR height="100%"> 
              <TD width="63%"> <TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
                  <TR> 
                    <TD width="56%"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                      <STRONG>NOMBRES</STRONG> </FONT> 
                    </TD>
                    <TD width="44%"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                      <STRONG>APELLIDO PATERNO</STRONG></FONT> </TD>
                  </TR>
                  <TR> 
                    <TD> 
                      
                      <?php 
							if($frmModo=="mostrar"){ 
								imp($filaEMP['nombre_emp']);
							};
						?>
                      <?php if($frmModo=="modificar"){ 
                                imp($filaEMP['nombre_emp']);
							};?>
                    </TD>
                    <TD> 
                      
                      <?php 
								if($frmModo=="mostrar"){ 
									imp($filaEMP['ape_pat']);
									};?>
                      <?php     if($frmModo=="modificar"){ 
                                    imp($filaEMP['ape_pat']);
									};?>
                    </TD>
                  </TR>
                </TABLE></TD>
              <TD width="37%"> <TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
                  <TR> 
                    <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                      <STRONG>APELLIDO MATERNO</STRONG></FONT> </TD>
                  </TR>
                  <TR> 
                    <TD> 
                     
                      <?php 
						         if($frmModo=="mostrar"){ 
									imp($filaEMP['ape_mat']);
									};?>
                      <?php      if($frmModo=="modificar"){ 
									imp($filaEMP['ape_mat']);
									};?>
                    </TD>
                  </TR>
                </TABLE></TD>
            </TR>
          </TABLE>
                                         </TD>
                                      </TR>
                                   </TABLE>
                                 </TD>
                               </TR>
                            
                          </TD>
                        </TR>
   <?php } ?>                                          																							
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="94%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="98%" color=#003b85>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR height=15>
							
  <TD width="100%" colspan=2> 
    <?php if($frmModo=="mostrar"){?><center>
    <?php if($institucion==10237){ ?>
    <BR>
    <?php } ?>
    <BR>
										<BR>
    <?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
    <?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
    <?php }?>
    <?php }else{?>
    <?php }?>
    <!--<INPUT TYPE="button" value="MOVIL ESCOLAR" 
				onClick=document.location="../../tesc/fichaTesc.php3?rdb=<?php // echo trim($_INSTIT);?>">-->
    <?php }else{?>
								<?php }?>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<?php if($frmModo=="ingresar"){?>
				<tr>
					<td colspan=3 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													<ul>
														<li>Una vez finalizado el ingreso de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para volver al listado de instituciones ingresadas al sistema.</li>
														
<li>Para abandonar la sesión de usuario presionar "CERRAR SESION".</li>
													</ul>
												</font>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php }?>
			<?php if($frmModo=="mostrar"){?>
				<tr>
					<td colspan=3 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													
                <ul>
                  <li>"AÑO ACADEMICO" : Años académicos ingresados a la institución.</li>
                  <li>"NOTICIA" : Total de noticias de la institución.</li>
                  <li>"AGENDA" : Total de notas de la agenda de la institución.</li>
                  <li>"PERSONAL" : Empleados de la institución.</li>
                  <li>"CARTA DIRECCION", "PROYECTO EDUCATIVO", "UNIFORME", "REGLAMENTO 
                    INTERNO", "NUESTRA INSTITUCION" y "PROCESO ADMISION" : Accede 
                    al texto que corresponde.</li>
                  <li>"BIBLIOTECA" : Accede al total de libros registrados para 
                    la institución.</li>
                  <li>"INSIGNIA" y "MAPA" : Permiten el ingreso de las imagenes 
                    correspondientes.</li>
                  <li>"BOLSA DE TRABAJO" : Permite el ingreso de ofertas de trabajo.</li>
                  <li>"LICITACIONES" : Permite el ingreso de avisos para publicarlos 
                    en web.</li>
                  <li>"ELIMINAR" : Elimina toda la información de la institución 
                    ingresada</li>
                  <li>"LISTADO" : Despliega el total de instituciones ingresadas.</li>
                  <li>Para abandonar la sesión de usuario presionar "CERRAR SESION".</li>
                </ul>
												</font>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php }?>
			<?php if($frmModo=="modificar"){?>
				<tr>
					<td colspan=3 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													<ul>
														<li>Una vez finalizado la modificación de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para no realizar modificaciones.</li>
														<li>Para abandonar la sesión de usuario presionar "CERRAR SESSION".</li>
													</ul>
												</font>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
                 
			<?php }?>
		</TABLE>




							 
							 
                                   <!-- FIN DEL NUEVO CODIGO DE LA PLANTILLA -->
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="90" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
