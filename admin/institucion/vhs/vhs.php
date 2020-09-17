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
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Documento sin t&iacute;tulo</title>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-size: 12px}
.Estilo2 {color: #6699FF}
.Estilo3 {
	font-size: 12px;
	color: #6699FF;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="615" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="615"><div align="left"><font color="#666666" size="2" face="Geneva, Arial, Helvetica, sans-serif">Usted est&aacute; en <img src="cortes/arrow.png" width="9" height="9"> admin <img src="cortes/arrow.png" width="9" height="9"> institucion <img src="cortes/arrow.png" width="9" height="9"> sae</font></div></td>
  </tr>
  <tr>
    <td height="162" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="57" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="fondo">
              <tr>
                <td height="39">Instituci&oacute;n</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="20" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datosB">
              <tr>
                <td width="5%"><font color="#6699FF"><strong>RBD</strong></font></td>
                <td width="8%"><?php if($frmModo=="ingresar"){ ?>
                  <INPUT type="text" name=txtRDB size=10 maxlength=10 onchange="checkRutField(this);">
                  <?php };?>
                  <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['rdb']);
												};?>
                  <?php if($frmModo=="modificar"){ 
												imp($fila['rdb']);
											};?>-
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
											};?></td>
                <td width="19%"><font color="#6699FF"><strong>ESTABLECIMIENTO</strong></font></td>
                <td width="68%"><?php if($frmModo=="ingresar"){ ?>
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
                  <?php };?></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="20" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datos">
              <tr class="datosB">
                <td width="40%" height="15"><font color="#6699FF"><strong>N&ordm; RESOLUCION </strong>(Nombre Establecimiento)</font></td>
                <td width="8%"><?php if($frmModo=="ingresar"){ ?>
                  <input type="text" name=txtNRES size=20 maxlength=30>
                  <?php };?>
                  <?php 
									 if($frmModo=="mostrar"){ 
									   imp($fila['nu_resolucion']);
									   };
									?>
                  <?php if($frmModo=="modificar"){ ?>
                  <input type="text" name=txtNRES size=20 maxlength=30 value="<?php echo trim($fila['nu_resolucion'])?>">
                  <?php };?></td>
                <td width="23%"><strong><font color="#6699FF">FECHA DE RESOLUCION</font></strong></td>
                <td width="29%"><?php if($frmModo=="ingresar"){ ?>
                  <input type="text" name=txtFECHARES size=20 maxlength=10 onChange="chkFecha(form.txtFECHARES,'Fecha invalida.');">
                  <br>
                  <FONT face="arial, geneva, helvetica" size=1 color=#000000> <STRONG>DD-MM-AAAA</STRONG></FONT>
                  <?php };?>
                  <?php 
										if($frmModo=="mostrar"){ 
										  impF($fila['fecha_resolucion']);
										  };
									  ?>
                  <?php if($frmModo=="modificar"){ ?>
                  <INPUT type="text" name=txtFECHARES size=20 maxlength=50 value="<?php impF($fila['fecha_resolucion'])?>" onChange="chkFecha(form.txtFECHARES,'Fecha invalida.');">
                  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>DD-MM-AAAA</STRONG></FONT>
                  <?php };?></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="20" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datosB">
              <tr>
                <td width="7%"><font color="#6699FF"><strong>LETRA</strong></font></td>
                <td width="3%"><?php if($frmModo=="ingresar"){ ?>
                  <input type="text" name=txtLETRA size=5 maxlength=30>
                  <?php };?>
                  <?php 
										 if($frmModo=="mostrar"){ 
										   imp($fila['letra_inst']);
										   };
										?>
                  <?php if($frmModo=="modificar"){ ?>
                  <INPUT type="text" name=txtLETRA size=5 maxlength=30 value="<?php echo trim($fila['letra_inst'])?>">
                  <?php };?></td>
                <td width="9%"><font color="#6699FF"><strong>NUMERO</strong></font></td>
                <td width="5%"><?php if($frmModo=="ingresar"){ ?>
                  <INPUT type="text" name=txtNUMINST size=5 maxlength=30>
                  <?php };?>
                  <?php 
										if($frmModo=="mostrar"){ 
										  imp($fila['numero_inst']);
										  };
									  ?>
                  <?php if($frmModo=="modificar"){ ?>
                  <INPUT type="text" name=txtNUMINST size=5 maxlength=30 value="<?php echo trim($fila['numero_inst'])?>">
                  <?php };?></td>
                <td width="14%"><font color="#6699FF"><strong>DEPENDENCIA</strong></font></td>
                <td width="62%"><?php 
 
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
                  <?php };?></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="20" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datos">
              <tr class="datosB">
                <td width="10%" height="15"><font color="#6699FF"><strong>TELEFONO</strong></font></td>
                <td width="9%"><?php if($frmModo=="ingresar"){ ?>
                  <INPUT type="text" name=txtTELEF size=20 maxlength=30>
                  <?php };?>
                  <?php 
															if($frmModo=="mostrar"){ 
																imp($fila['telefono']);
															};
														?>
                  <?php if($frmModo=="modificar"){ ?>
                  <INPUT type="text" name=txtTELEF size=20 maxlength=30 value="<?php echo trim($fila['telefono'])?>">
                  <?php };?></td>
                <td width="5%"><strong><font color="#6699FF">FAX</font></strong></td>
                <td width="8%"><?php if($frmModo=="ingresar"){ ?>
                  <INPUT type="text" name=txtFAX size=20 maxlength=30>
                  <?php };?>
                  <?php 
															if($frmModo=="mostrar"){ 
																imp($fila['fax']);
															};
														?>
                  <?php if($frmModo=="modificar"){ ?>
                  <INPUT type="text" name=txtFAX size=20 maxlength=30 value="<?php echo trim($fila['fax'])?>">
                  <?php };?></td>
                <td width="7%"><strong><font color="#6699FF">EMAIL</font></strong></td>
                <td width="61%"><?php if($frmModo=="ingresar"){ ?>
                  <INPUT type="text" name=txtEMAIL size=20 maxlength=50>
                  <?php };?>
                  <?php 
															if($frmModo=="mostrar"){ 
																imp($fila['email']);
															};
														?>
                  <?php if($frmModo=="modificar"){ ?>
                  <INPUT type="text" name=txtEMAIL size=20 maxlength=50 value="<?php echo trim($fila['email'])?>">
                  <?php };?></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datosB">

          </table></td>
        </tr>
		<tr><td><TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 width=100%>
            <TR class="datosB"> 
              <TD width="25%" height="82"> 
           
                  <TABLE width="179" BORDER=0 CELLPADDING=0 CELLSPACING=0>
                    <TR> 
                      <TD width="182" class="Estilo2">  
                        <FONT face="arial, geneva, helvetica"><STRONG>TIPO INSTITUCION</STRONG></FONT>  </TD>
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
              <TD width="27%"> <div align="left" class="Estilo1"> 
                  <TABLE width="274" BORDER=0 CELLPADDING=0 CELLSPACING=0>
                    <TR> 
                      <TD width="274"> <span class="Estilo2"> 
                        <FONT face="arial, geneva, helvetica"><STRONG>TIPO EDUCACION</STRONG> </FONT></span> </TD>
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

              <TD width="36%"> <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
                  <TR> 
                    <TD width="324" class="Estilo1"> <div align="left" class="Estilo2"> 
                        <FONT face="arial, geneva, helvetica"><STRONG>IDIOMA</STRONG></FONT>  </div></TD>
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
            <TR class="datosB"> 
              <TD height="57"> <div align="left" class="Estilo1"> 
                  <TABLE width="232" BORDER=0 CELLPADDING=0 CELLSPACING=0>
                    <TR> 
                      <TD> <span class="Estilo2"> 
                        <FONT face="arial, geneva, helvetica"><STRONG>SEXO</STRONG></FONT> </span> </TD>
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
              <TD> <div align="left" class="Estilo1"> 
                  <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
                    <TR> 
                      <TD> <span class="Estilo2"><FONT face="arial, geneva, helvetica"> 
                        <STRONG>METODO</STRONG> </FONT> </span></TD>
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
              <TD colspan=2> <div align="left" class="Estilo1"> 
                  <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
                    <TR> 
                      <TD valign="top"> <span class="Estilo2"> 
                        <FONT face="arial, geneva, helvetica"><STRONG>FORMACION</STRONG></FONT> </span> </TD>
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
          </TABLE></td></tr>
		  <tr><td>
		  <table><tr><td><TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
            <TR>
              <TD><span class="Estilo3"> <FONT face="arial, geneva, helvetica">CALLE</FONT> </span> </TD>
            </TR>
            <TR>
              <TD><?php if($frmModo=="ingresar"){ ?>
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
          </TABLE></td><td><TABLE WIDTH=101% BORDER=0 CELLSPACING=0 CELLPADDING=0>
            <TR>
              <TD width="57%"><span class="Estilo3"> <FONT face="arial, geneva, helvetica">NRO</FONT> </span> </TD>
              <TD width="43%"><span class="Estilo3"> <FONT face="arial, geneva, helvetica">AREA GEOGRAFICA </FONT></span> </TD>
            </TR>
            <TR>
              <TD><?php if($frmModo=="ingresar"){ ?>
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
              <TD><?php if($frmModo=="ingresar"){ ?>
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
          </TABLE></td></tr></table>
		  
		  </td></tr>
		  <tr><td></td></tr>
		  <tr><td></td></tr>
		  <tr><td><table><tr><td><TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
            <TR>
              <TD><span class="Estilo3"><FONT face="arial, geneva, helvetica"> DEPTO&nbsp;&nbsp;&nbsp;(OPCIONAL) </FONT> </span></TD>
              <TD><span class="Estilo3"><FONT face="arial, geneva, helvetica"> BLOCK&nbsp;&nbsp;&nbsp;(OPCIONAL) </FONT> </span></TD>
            </TR>
            <TR>
              <TD><?php if($frmModo=="ingresar"){ ?>
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
              <TD><?php if($frmModo=="ingresar"){ ?>
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
          </TABLE></td><td><TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
            <TR>
              <TD><span class="Estilo3"> <FONT face="arial, geneva, helvetica">VILLA/POBL&nbsp;&nbsp;&nbsp;(OPCIONAL) </FONT></span> </TD>
            </TR>
            <TR>
              <TD><?php if($frmModo=="ingresar"){ ?>
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
          </TABLE></td></tr></table></td></tr>
		  <tr><td><table width="100%">
		    <tr><td><TABLE width=96% height=100% bgcolor=White BORDER=0  CELLSPACING=0 CELLPADDING=0>
            <TR>
              <TD width="29%"><TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
                  <TR>
                    <TD><span class="Estilo3"> <FONT face="arial, geneva, helvetica">REGION </FONT></span> </TD>
                  </TR>
                  <TR>
                    <TD><?php if($frmModo=="ingresar"){ ?>
                        <FORM method=post name=f1 onsubmit="return false;">
                          <SELECT class=saveHistory id=m1 name=m1 onchange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
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
                        <FORM method=post name=f1 onsubmit="return false;">
                          <SELECT class=saveHistory id=m1 name=m1 onchange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
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
              </TABLE></TD>
              <TD width="21%"><TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
                  <TR>
                    <TD><span class="Estilo3"> <FONT face="arial, geneva, helvetica">PROVINCIA </FONT></span> </TD>
                  </TR>
                  <TR>
                    <TD><?php if($frmModo=="ingresar"){ ?>
                        <FORM method=post name=f2 onsubmit="return false;">
                          <SELECT class=saveHistory id=m2 name=m2 onchange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;">
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
                        <FORM method=post name=f2 onsubmit="return false;">
                          <SELECT class=saveHistory id=m2 name=m2 onchange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;">
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
              </TABLE></TD>
              <TD width="50%"><TABLE WIDTH=95% BORDER=0 CELLSPACING=0 CELLPADDING=0>
                  <TR>
                    <TD><span class="Estilo3"> <FONT face="arial, geneva, helvetica">COMUNA </FONT></span> </TD>
                  </TR>
                  <TR>
                    <TD><?php if($frmModo=="ingresar"){ ?>
                        <FORM  method=post name=f3 onsubmit="return false;">
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
                        <FORM method=post name=f3 onsubmit="return false;">
                          <SELECT class=saveHistory id=m3 name=m3 onchange="document.frm.txtCOM.value=document.f3.m3.value;">
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
              </TABLE></TD>
            </TR>
          </TABLE></td>
		  </tr></table></td></tr>
<tr><td>


<TABLE width=712 height=100 Border=0 cellpadding=1 cellspacing=0 bgcolor=#cccccc class="fondo">
<tr><td>Datos del director<TABLE width=100% height=100% bgcolor=White BORDER=0>
  <TR height="100%">
    <TD width="63%"><TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
        <TR>
          <TD width="24"><FONT face="arial, geneva, helvetica" size=1 color=#000000> <STRONG>RUN</STRONG> </FONT> </TD>
        </TR>
        <TR>
          <TD><?php
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
          <TD width="372" align="left"><?php if($frmModo=="ingresar"){ 
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
    <TD width="37%">&nbsp;</TD>
    <!--F7-->
  <TR height="100%">
    <TD width="63%"><TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
        <TR>
          <TD width="56%"><FONT face="arial, geneva, helvetica" size=1 color=#000000> <STRONG>NOMBRES</STRONG> </FONT> </TD>
          <TD width="44%"><FONT face="arial, geneva, helvetica" size=1 color=#000000> <STRONG>APELLIDO PATERNO</STRONG></FONT> </TD>
        </TR>
        <TR>
          <TD><?php 
							if($frmModo=="mostrar"){ 
								imp($filaEMP['nombre_emp']);
							};
						?>
              <?php if($frmModo=="modificar"){ 
                                imp($filaEMP['nombre_emp']);
							};?>
          </TD>
          <TD><?php 
								if($frmModo=="mostrar"){ 
									imp($filaEMP['ape_pat']);
									};?>
              <?php     if($frmModo=="modificar"){ 
                                    imp($filaEMP['ape_pat']);
									};?>
          </TD>
        </TR>
    </TABLE></TD>
    <TD width="37%"><TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
        <TR>
          <TD><FONT face="arial, geneva, helvetica" size=1 color=#000000> <STRONG>APELLIDO MATERNO</STRONG></FONT> </TD>
        </TR>
        <TR>
          <TD><?php 
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
</TABLE></td></tr></table>

</td></tr>		  
		  
        <tr>
          <td align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datos">
              <tr class="datosB">
                <td width="40%" height="15"><font color="#6699FF"><strong>N&ordm; RESOLUCION </strong>(Nombre Establecimiento)</font></td>
                <td width="8%">23017</td>
                <td width="23%"><strong><font color="#6699FF">FECHA DE RESOLUCION</font></strong></td>
                <td width="29%">09-09-1971</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="datosB">
              <tr>
                <td width="7%"><font color="#6699FF"><strong>LETRA</strong></font></td>
                <td width="3%">F</td>
                <td width="9%"><font color="#6699FF"><strong>NUMERO</strong></font></td>
                <td width="5%">60</td>
                <td width="14%"><font color="#6699FF"><strong>DEPENDENCIA</strong></font></td>
                <td width="62%">Municipalizado</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="40" align="center" valign="middle"><table width="80%" border="0" cellspacing="0" cellpadding="0">
              <tr align="center" valign="middle">
                <td width="17%"><table width="50" height="17" border="0" cellpadding="0" cellspacing="0" class="boton01">
                    <tr>
                      <td width="50%" height="15">Enviar</td>
                    </tr>
                </table></td>
                <td width="13%"><table width="50" height="17" border="0" cellpadding="0" cellspacing="0" class="boton01">
                    <tr>
                      <td width="50%" height="15">Borrar</td>
                    </tr>
                </table></td>
                <td width="70%" align="right"><table width="80%" border="0" cellpadding="0" cellspacing="0" class="boton02">
                    <tr align="center" valign="middle">
                      <td height="23"><img src="cortes/atras.gif" width="11" height="11"> Volver</td>
                      <td><img src="cortes/subir.gif" width="11" height="11"> Subir</td>
                      <td><img src="cortes/print.gif" width="11" height="11"> Imprimir</td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="49" align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
</body>
</html>
