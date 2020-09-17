<?php 
	require('../../util/header.inc');
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	
	$estado = array (
                'pae' =>"disabled",
                'CA' =>"disabled",
                'CP' =>"disabled",
                'WS' =>"disabled",
                'CPA' =>"disabled",
                'EX' =>"disabled"
        );
		
	if ($frmModo == NULL){
	   $frmModo = "mostrar";
	} 
	  	
		
?>	
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<!--link href="estilo_vhs.css" rel="stylesheet" type="text/css"-->
<SCRIPT type=text/javascript>
if (document.getElementById){ //DynamicDrive.com change
document.write('<style type="text/css">\n')
document.write('.submenu2{display: none;}\n')
document.write('</style>\n')
}
</SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
.Estilo1 {font-size: 12px}
.Estilo3 {	font-size: 12px;
	color: #6699FF;
	font-weight: bold;
	
}
.td_muestra {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	font-weight: normal;
	text-decoration: none;
	height: 30px;
	color: #666666;



}
</style>
</head>

		<?php if($frmModo!="mostrar"){ ?>
		<?php include('../../util/rpc.php3');?>
			<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
			<?php if($frmModo=="modificar"){ ?>
				<SCRIPT language="JavaScript">
					function valida(form){
														
						if(form.txtTELEF.value!=''){
							if(!phoneOnly(form.txtTELEF,'Se permiten sólo numeros telefónicos en el campo TELEFONO.')){
								return false;
							};
						};
						
						if(form.txtNRES.value==""){
							alert ('debe agregar la numero de resolucion');
					        return false;
				        };
						if(!nroOnly(form.txtNRES,'Se permiten sólo numeros en el numero de resolucion.')){
							return false;
						};
							
						
                        if(form.txtFECHARES.value==""){
							alert ('debe agregar la fecha de resolucion');
					        return false;
				        };
					    if(!chkFecha(form.txtFECHARES,'Debe ingresar una fecha')){
					        return false;
				        };	
						
					    if(!letraOnly(form.txtLETRA,'Debe ingresar una letra')){
					        return false;
				        };	
			
/*						if(!chkVacio(form.txtNUMINST,'Ingrese el numero de la institucion.')){
							return false;
						};	*/										
						if(!nroOnly(form.txtNUMINST,'Se permiten sólo numeros.')){
							return false;
						};											

						
						if(!nroOnly(form.txtNRO,'Se permiten sólo numeros.')){
							return false;
						};
						
						if(form.txtFAX.value!=''){
							if(!phoneOnly(form.txtFAX,'Se permiten sólo numeros telefónicos en el campo FAX.')){
								return false;
							};
						}	
							
												
						if(form.txtEMAIL.value!=''){
							if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
								return false;
							};
						};

						if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
							return false;
						};		
						
						if(form.txtNRO.value==""){
							alert ('ingrese numero de direccion .')
							return false;
						};
						
																		
						if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE Institución.')){
							return false;
						};

/*						if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
							return false;
							};
*/
						
						if (form.txtNRES.value==""){
							alert ('debe ingresar el numero de resolucion');
							return false;

						}


						if(!chkSelect(form.cmbINSTIT,'Seleccionar TIPO DE INSTITUCION.')){
							return false;
						};

						if(!chkSelect(form.cmbEDUC,'Seleccionar TIPO DE EDUCACION.')){
							return false;
						};

					/*	if(!chkSelect(form.cmbREGIMEN,'Seleccionar TIPO DE REGIMEN.')){
							return false;
						};*/

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
				
						if(form.txtTELEF.value!=''){
							if(!phoneOnly(form.txtTELEF,'Se permiten sólo numeros telefónicos en el campo TELEFONO.')){
								return false;
							};
						};
						
						if(form.txtNRES.value==""){
							alert ('debe agregar el numero de resolucion');
					        return false;
				        };
						
						
						if(!nroOnly(form.txtNRES,'Se permiten sólo numeros en el numero de resolucion.')){
							return false;
						};
							
						
                        if(form.txtFECHARES.value==""){
							alert ('debe agregar la fecha de resolucion');
					        return false;
				        };
					    if(!chkFecha(form.txtFECHARES,'Debe ingresar una fecha')){
					        return false;
				        };			
						
						if(!chkFecha(form.txtFECHARES,'Fecha inválida.')){
					        return false;
				        };
										
						
					    if(!letraOnly(form.txtLETRA,'Debe ingresar una letra')){
					        return false;
				        };	
			
//						if(!chkVacio(form.txtNUMINST,'Ingrese el numero de la institucion.')){
	//						return false;
		//				};											
						if(!nroOnly(form.txtNUMINST,'Se permiten sólo numeros.')){
							return false;
						};											

						
						if(form.txtFAX.value!=''){
							if(!phoneOnly(form.txtFAX,'Se permiten sólo numeros telefónicos en el campo FAX.')){
								return false;
							};
						}	
							
												
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

					/*	if(!chkSelect(form.cmbREGIMEN,'Seleccionar TIPO DE REGIMEN.')){
							return false;
						};*/

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
						
						if(!chkSelect(form.txtAREAG,'Seleccionar AREA GEOGRAFICA.')){
							return false;
						};						
						
						if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
							return false;
						};	
												
						if(form.txtNRO.value==""){
							alert ('ingrese numero de calle.')
							return false;
						};
						
						if(!nroOnly(form.txtNRO,'Se permiten sólo numeros.')){
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
<table width="100%" height="0" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="0" align="left" valign="top"><table width="100%" height="0" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="800" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle" valign="top">
				
				    <?
			         include("../../cabecera/menu_superior.php");
			        ?>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        
						<?
						$menu_lateral=1;
			            include("../../menus/menu_lateral.php");
			            ?>
						
						
					  </td>
                      <td width="73%" align="left" valign="top">

                     <?

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
	    $qry="SELECT * FROM INSTITUCION WHERE RDB=".trim($institucion);
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

<?	// URL ------------ VEL
	$qry_url = "select direccion from salida where rdb = '$institucion'";
	$res_url = @pg_Exec($conn,$qry_url);
	$fil_url = @pg_fetch_array($res_url,0);	
?>


<FORM method=post name="frm" action="procesoInstitucion.php3">

					  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top"><table width="615" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="615"><div align="left"><font color="#666666" size="2" face="Geneva, Arial, Helvetica, sans-serif"><A name="arriba"></A></font></div></td>
                              </tr>
                              <tr>
                                <td height="162" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td><?php if($frmModo=="ingresar"){ ?>
                                            <INPUT class="botonXX" TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">
&nbsp;
		<?php if($_PERFIL==0) {?>
              <INPUT class="botonXX" TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarInstituciones.php3?modo=ini">
		<? }?>
&nbsp;
              <?php };?>
              <?php if($frmModo=="mostrar"){ ?>
              <?php if(($_PERFIL==0) || ($_PERFIL==14)){ 	?>
              <?php // if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
              <INPUT class="botonXX" TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaInstitucion.php3?institucion=<?php echo $institucion?>&caso=3">
&nbsp;
              <?php // if($_PERFIL==0 ){ //SOLO ADMINISTRADOR GENERAL?>
              <!--<INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar onclick=document.location="seteaInstitucion.php3?caso=9">&nbsp; -->
              <!--INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="LISTADO" onClick=document.location="listarInstituciones.php3?modo=ini"-->
&nbsp;
              <?php // };?>
              <?php // };?>
              <?php }?>
              <?php };?>
              <?php if($frmModo=="modificar"){ ?>
              <INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">
&nbsp;
              <INPUT class="botonXX" TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaInstitucion.php3?institucion=<?php echo $institucion?>&caso=1">
&nbsp;
              <?php };?>                                        </td>
                                      </tr>
                                      <tr>
                                        <td height="57" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="fondo">
                                            <tr>
                                              <td height="39" class="tableindex">Instituci&oacute;n</td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                      <tr>
                                        <td align="center" valign="middle">
										
										<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666">
                                            <tr>
                                              <td class="cuadro02"><strong>RBD (*)</strong></td>
                                              <td nowrap class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                  <INPUT name=txtRDB type="text" onChange="checkRutField(this);" size=10 maxlength=10>
                                                  <?php };?>
                                                  <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['rdb']);
												};?>
                                                  <?php if($frmModo=="modificar"){ 
												imp($fila['rdb']);
											};?>
                                                  -
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
                                              <td class="cuadro02"><strong>ESTABLECIMIENTO (*)</strong></td>
                                              <td class="cuadro01">
											  <?php if($frmModo=="ingresar"){ ?>
                                                  <input name="txtNOMBRE" type="text" size=25 maxlength=50>
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
                                                  <INPUT type="text" name="txtNOMBRE" size=40 maxlength=50 value="<?php echo trim($fila['nombre_instit'])?>" >
                                              <?php };?></td>
                                          </tr>
                               
                                            <tr>
                                              <td class="cuadro02"><strong>N&ordm; RESOLUCION (*)</strong></td>
                                              <td class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                  <input name=txtNRES type="text" size=20 maxlength=30>
                                                  <?php };?>
                                                  <?php 
									 if($frmModo=="mostrar"){ 
									   imp($fila['nu_resolucion']);
									   };
									?>
                                                  <?php if($frmModo=="modificar"){ ?>
                                                  <input name="txtNRES" onChange="nroOnly(form.txtNRES,'Numero de Resolución invalido.');" type="text" value="<?php echo trim($fila['nu_resolucion'])?>" size=20 maxlength=30>
                                              <?php };?></td>
                                              <td class="cuadro02"><strong>FECHA DE RESOLUCION (*)</strong></td>
                                              <td class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                  <input name="txtFECHARES" type="text" size="20" maxlength="10">
                                                  <br>                                                DD-MM-AAAA
                                                  <?php };?>
                                                  <?php 
										if($frmModo=="mostrar"){ 
										  impF($fila['fecha_resolucion']);
										  };
									  ?>
                                                  <?php if($frmModo=="modificar"){ ?>
                                                  <INPUT name="txtFECHARES" type="text" onChange="chkFecha(form.txtFECHARES,'Fecha invalida.');" value="<?php impF($fila['fecha_resolucion'])?>" size="20" maxlength="50">
                                                DD-MM-AAAA
                                              <?php };?>											  </td>
                                          </tr>
                                        
                                            <tr>
                                              <td width="14%" class="cuadro02"><strong>LETRA</strong></td>
                                              <td width="62%" class="cuadro01">&nbsp;<?php if($frmModo=="ingresar"){ ?>
                                                  <input name=txtLETRA type="text" size=5 maxlength=30>
                                                  <?php };?>
                                                  <?php 
										 if($frmModo=="mostrar"){ 
										   imp($fila['letra_inst']);
										   };
										?>
                                                  <?php if($frmModo=="modificar"){ ?>
                                                  <INPUT name="txtLETRA" onChange="letraOnly(form.txtLETRA,'Letra invalida.');" type="text" value="<?php echo trim($fila['letra_inst'])?>" size="1" maxlength="1">
                                              <?php };?></td>
                                              <td width="10%" class="cuadro02"><strong>NUMERO</strong></td>
                                              <td width="61%" class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                <input name="txtNUMINST" type="text" size="5" maxlength="30">                                                  
                                                <?php };?>
                                                  <?php 
										if($frmModo=="mostrar"){ 
										  imp($fila['numero_inst']);
										  };
									  ?>
                                                  <?php if($frmModo=="modificar"){ ?>
                                                  <INPUT name="txtNUMINST" type="text" value="<?php echo trim($fila['numero_inst'])?>" size="5" maxlength="30">
                                              <?php };?></td></tr>
											<tr>
                                              <td width="14%" class="cuadro02"><strong>DEPENDENCIA </strong></td>
                                              <td width="50%" class="cuadro01"><?php 
 
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
                                                  <Select name="cmbDEP" >
                                                    <option value=0 <?php if($fila['dependencia']==0){ echo "selected";}?>>PARTICULAR SUBVENCIONADO</option>
                                                    <option value=1 <?php if($fila['dependencia']==1){ echo "selected";}?>>PARTICULAR</option>
                                                    <option value=2 <?php if($fila['dependencia']==2){ echo "selected";}?>>MUNICIPAL</option>
                                                    <option value=3 <?php if($fila['dependencia']==3){ echo "selected";}?>>OTROS</option>
                                                  </Select>
                                              <?php };?></td>
											  <td width="10%" height="15" class="cuadro02"><strong>TELEFONO</strong></td>
                                              <td width="61%" class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                  <INPUT name=txtTELEF type="text" size=20 maxlength=30>
                                                  <?php };?>
                                                  <?php 
															if($frmModo=="mostrar"){ 
																imp($fila['telefono']);
															};
														?>
                                                  <?php if($frmModo=="modificar"){ ?>
                                                  <INPUT name="txtTELEF" type="text" onChange="phoneOnly(form.txtTELEF,'Telefono invalido.');" value="<?php echo trim($fila['telefono'])?>" size=20 maxlength=30>
                                              <?php };?></td>
                                            </tr>
                                        
                                            <tr>
                                              
                                              <td width="14%" class="cuadro02"><strong>FAX</strong></td>
                                              <td width="62%" class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                  <INPUT name=txtFAX type="text" size=20 maxlength=30>
                                                  <?php };?>
                                                  <?php 
															if($frmModo=="mostrar"){ 
																imp($fila['fax']);
															};
														?>
                                                  <?php if($frmModo=="modificar"){ ?>
                                                  <INPUT name="txtFAX" type="text" value="<?php echo trim($fila['fax'])?>" onChange="phoneOnly(form.txtFAX,'Fax invalido.');" size=20 maxlength=30>
                                              <?php };?></td>
                                              <td width="10%" class="cuadro02"><strong>EMAIL</strong></td>
                                              <td width="61%" class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                  <INPUT name=txtEMAIL type="text" size=20 maxlength=50>
                                                  <?php };?>
                                                  <?php 
															if($frmModo=="mostrar"){ 
																imp($fila['email']);
															};
														?>
                                                  <?php if($frmModo=="modificar"){ ?>
                                                  <INPUT name="txtEMAIL" type="text" value="<?php echo trim($fila['email'])?>" onChange="isEmail(form.txtEMAIL,'Mail invalido.');"size=20 maxlength=50>
                                              <?php };?></td>
                                          </tr>
										  <TR>
											<TD class="cuadro02"><STRONG>TIPO INSTITUCION (*)</STRONG> </TD>
											<TD class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
												<select name="cmbINSTIT" >
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
												<Select name="cmbINSTIT" >
												  <option value=0 ></option>
												  <option value=1 <?php echo ($fila['tipo_instit'])==1?"selected":"" ?>>Colegio</option>
												  <option value=2 <?php echo ($fila['tipo_instit'])==2?"selected":"" ?>>Jardin Infantil</option>
												  <option value=3 <?php echo ($fila['tipo_instit'])==3?"selected":"" ?>>Salacuna</option>
												</Select>
											<?php }; ?>                                                    </TD>
                                                    <TD class="cuadro02"> <STRONG>TIPO EDUCACION (*)</STRONG>  </TD>
                                                    <TD class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
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
																		 imp('B&aacute;sica');
																		 break;
																	 case 3:
																		 imp('Media');
																		 break;
																	 case 4:
																		 imp('Kinder - Basica');
																		 break;
																	 case 5:
																		 imp('B&aacute;sica - Media');
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
                                                    <?php };?>                                                    </TD>
                                                  </TR>
											  
                                                  <TR>
                                                    <TD class="cuadro02"> <STRONG>IDIOMA (*)</STRONG> </TD>
                                                  	<TD class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                        <Select name="cmbIDIOMA" >
                                                          <option value=0 selected></option>
                                                          <option value=1 >Espa&ntilde;ol</option>
                                                          <option value=2 >Ingles</option>
                                                          <option value=3 >Alem&aacute;n</option>
                                                          <option value=4 >Biling&uuml;e</option>
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
																		 imp('Espa&ntilde;ol');
																		 break;
																	 case 2:
																		 imp('Ingles');
																		 break;
																	 case 3:
																		 imp('Alem&aacute;n');
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
                                                        <Select name="cmbIDIOMA" >
                                                          <option value=0 ></option>
                                                          <option value=1 <?php echo ($fila['idioma'])==1?"selected":"" ?>>Espa&ntilde;ol</option>
                                                          <option value=2 <?php echo ($fila['idioma'])==2?"selected":"" ?>>Ingles</option>
                                                          <option value=3 <?php echo ($fila['idioma'])==3?"selected":"" ?>>Alem&aacute;n</option>
                                                          <option value=4 <?php echo ($fila['idioma'])==4?"selected":"" ?>>Biling&uuml;e</option>
                                                          <option value=5 <?php echo ($fila['idioma'])==5?"selected":"" ?>>Otros</option>
                                                        </Select>
                                                    <?php };?>                                                    </TD>
													
                                                    <TD class="cuadro02"><STRONG>SEXO (*)</STRONG> </TD>
                                                    <TD height="41" class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
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
                                                    <?php };?>                                                    </TD>
                                                  </TR>
                                                  <TR>
                                                    <TD class="cuadro02"><strong>METODO (*)</strong></TD>
                                                    <td class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                        <select name="cmbMETODO" >
                                                          <option value="0" selected="selected"></option>
                                                          <option value="1" >Tradicional</option>
                                                          <option value="2" >Personalizado</option>
                                                          <option value="3" >Montessori</option>
                                                          <option value="4" >Internacional</option>
                                                          <option value="5" >Activa</option>
                                                          <option value="6" >Transtorno</option>
                                                          <option value="7" >Curriculum Integrado</option>
                                                          <option value="8" >Waldorf</option>
                                                        </select>
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
																	 case 8:
																		 imp('Waldorf');
																		 break;
																 };
															};
														?>
                                                        <?php if($frmModo=="modificar"){ ?>
                                                        <select name="cmbMETODO" >
                                                          <option value="0" ></option>
                                                          <option value="1" <?php echo ($fila['metodo'])==1?"selected":"" ?> >Tradicional</option>
                                                          <option value="2" <?php echo ($fila['metodo'])==2?"selected":"" ?> >Personalizado</option>
                                                          <option value="3" <?php echo ($fila['metodo'])==3?"selected":"" ?>>Montessori</option>
                                                          <option value="4" <?php echo ($fila['metodo'])==4?"selected":"" ?>>Internacional</option>
                                                          <option value="5" <?php echo ($fila['metodo'])==5?"selected":"" ?>>Activa</option>
                                                          <option value="6" <?php echo ($fila['metodo'])==6?"selected":"" ?>>Transtorno</option>
                                                          <option value="7" <?php echo ($fila['metodo'])==7?"selected":"" ?>>Curriculum Integrado</option>
                                                          <option value="8" <?php echo ($fila['metodo'])==8?"selected":"" ?>>Waldorf</option>
                                                        </select>
                                                        <?php };?>                                                    </td>
                                                    <td valign="top" class="cuadro02"><strong>FORMACION (*)</strong> </td>
                                                    <TD class="cuadro01">
													<?php if($frmModo=="ingresar"){ ?>
                                                            <select name="cmbFORMACION" >
                                                              <option value="0" selected="selected"></option>
                                                              <option value="1" >Cat&oacute;lica</option>
                                                              <option value="2" >Laica</option>
                                                              <option value="3" >Cristiana</option>
                                                            </select>
                                                            <?php };?>
                                                            <?php 
															if($frmModo=="mostrar"){ 
																switch ($fila['formacion']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Cat&oacute;lica');
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
                                                            <select name="cmbFORMACION" >
                                                              <option value="0" ></option>
                                                              <option value="1" <?php echo ($fila['formacion'])==1?"selected":"" ?>>Cat&oacute;lica</option>
                                                              <option value="2" <?php echo ($fila['formacion'])==2?"selected":"" ?>>Laica</option>
                                                              <option value="3" <?php echo ($fila['formacion'])==3?"selected":"" ?>>Cristiana</option>
                                                            </select>
                                                            <?php };?>                                                        </TD>
                                                  </TR>
												  
<TR>
                                                    <TD class="cuadro02"><strong> AREA GEOGRAFICA (*)</strong></TD>
                                                    <td class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                        <select name= "txtAREAG" >
                                                          <option> </option>
                                                          <option>RURAL </option>
                                                          <option>URBANO </option>
                                                        </select>
                                                        <?php };?>
                                                        <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['area_geo']);
																	};
																?>
                                                        <?php if($frmModo=="modificar"){ ?>
                                                        <select name="txtAREAG" >
                                                          <option <?php if(trim($fila['area_geo'])=='RURAL'){?> selected="selected" <? } ?>)>RURAL</option>
                                                          <option <?php if(trim($fila['area_geo'])=='URBANO'){?> selected="selected" <? } ?>)>URBANO</option>
                                                        </select>
                                                        <?php };?>                                                    </td>
                                                    <td valign="top" class="cuadro02"><strong>MOSTRAR INFO COLEGIO</strong></td>
                                                    <TD class="cuadro01">
														<?php if($frmModo=="ingresar"){ ?>
															<input name="info_colegio" type="checkbox">
														<? }	
														if($frmModo=="mostrar"){ 															
															if($fila['info_colegio']==1)
															{
																echo "SI";
															}else{
																echo "NO";
															}	
														 } ?>
														<?php if($frmModo=="modificar"){ ?>
															<input name="info_colegio" type="checkbox" <? if($fila['info_colegio']==1){?>checked="checked"<? }?>>
														<? } ?>
														
															
													</TD>
                                          </TR>												  
												  
												  
                                                  <TR>
                                                    <TD colspan="4">&nbsp;</TD>
                                                  </TR>
                                                  <TR>
                                                    <TD class="cuadro02"><strong>CALLE (*)</strong></TD>
                                                    <td class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                        <input name="txtCALLE" type="text" size="30" maxlength="50" />
                                                        <?php };?>
                                                        <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['calle']);
																	};
																?>
                                                        <?php if($frmModo=="modificar"){ ?>
                                                        <input name="txtCALLE" type="text" value="<?php echo trim($fila['calle'])?>" size="35" maxlength="50">
                                                        <?php };?>&nbsp;</td>
                                                    <td valign="top" class="cuadro02"><strong>NRO (*)</strong></td>
                                                    <td class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                        <input name="txtNRO" type="text" size="12" maxlength="10" />
                                                        <?php };?>
                                                        <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['nro']);
																	};
																?>
                                                        <?php if($frmModo=="modificar"){ ?>
                                                        <input name="txtNRO" type="text" maxlength="5"  value="<?php echo trim($fila['nro'])?>" onChange="nroOnly(form.txtNRO,'N&uacute;mero invalido.');" size="10">
                                                        <?php };?>  &nbsp;</td>
                                                  </TR>
                                                  <TR>
                                                    <TD class="cuadro02"><strong>DEPTO&nbsp;&nbsp;&nbsp;(OPCIONAL) </strong></TD>
                                                    <td height="46" class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                      <input name="txtDEP" type="text" size="12" maxlength="10" />
                                                      <?php };?>
                                                      <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['depto']);
																	};
																?>
                                                      <?php if($frmModo=="modificar"){ ?>
                                                      <input name="txtDEP" type="text" value="<?php echo trim($fila['depto'])?>" size="12" maxlength="10">
                                                      <?php };?>&nbsp;</td>
                                                    <td valign="top" class="cuadro02"><strong>BLOCK<br>(OPCIONAL) </strong></td>
                                                    <td class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                        <input name="txtBLO" type="text" size="12" maxlength="10" />
                                                        <?php };?>
                                                        <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['block']);
																	};
																?>
                                                        <?php if($frmModo=="modificar"){ ?>
                                                        <input name="txtBLO" type="text" value="<?php echo trim($fila['block'])?>" size="12" maxlength="10" />
                                                        <?php };?> &nbsp; </td>
                                                  </TR>
                                                  <TR>
                                                    <TD class="cuadro02"><strong>VILLA/POBL<br>(OPCIONAL) </strong></TD>
                                                    <td class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                        <input name="txtVIL" type="text" size="30" maxlength="50" />
                                                        <?php };?>
                                                        <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['villa']);
																	};
																?>
                                                        <?php if($frmModo=="modificar"){ ?>
                                                        <input name="txtVIL" type="text" value="<?php echo trim($fila['villa'])?>" size="34" maxlength="50" />
                                                        <?php };?>  &nbsp;                                                  </td>
<!-- Continuar VEL-->
                                                    <td valign="top" class="cuadro02"><strong>URL&nbsp;&nbsp;<input type="button" class="botonXX" title="Redirecciona a la WEB de su Institución al momento de [SALIR] Ejemplo URL: http://www.colegiointeractivo.com" value="?"></strong></td>																						
                                                    <td class="cuadro01">
													<?	if($frmModo=="mostrar"){
														echo $fil_url['direccion']?>&nbsp;
												   	<?	}
														if($frmModo=="modificar"){	
														?>
														<input name="url" type="text" size="30" maxlength="60" value="<?=$fil_url['direccion']?>">
													<? }	?>
													</td>
                                                  </TR> 
												<TR>
                                                    <TD colspan="4" class="cuadro01">&nbsp;</TD>
                                                  </TR>                                              </TABLE></td>
                                            </tr>
                                        </table></td>
                                      </tr>
									    <INPUT type="hidden" name="txtREG" size="20" value="<?php echo $fila['region']?>">
										<INPUT type="hidden" name="txtCIU" size="20" value="<?php echo $fila['ciudad']?>">
										<input type="hidden" name="txtCOM" size="20" value="<?php echo $fila['comuna']?>">
                                    </FORM>
                                    <tr>
                                      <td align="left">
									  
									  <TABLE  width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666">
                                                <TR valign="top">
                                                  <TD width="33%" align="left">
								<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
                                                      <TR>
													  
													  
													  
													  
<!--------------------------------------------------------------------------*REGION*----------------------------------------------------------->													  
                                                        <TD class="cuadro02"><strong> REGION (*) </strong></TD>
                                                      </TR>
                                                      <TR>
                                                        <TD class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                            <FORM method="post" name="f1" onSubmit="return false;">
                                                              <SELECT id="m1" name="m1" onChange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
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
                                                            <FORM method="post" name="f1" onSubmit="return false;">
                                                              <SELECT id="m1" name="m1" onChange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
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
                                                        <?php };?>                                                        </TD>
                                                      </TR>
                                                  </TABLE></TD>
                                                  <TD width="33%"><TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
                                                      <TR>
													  
													  
													  
													  
													  
<!-----------------------------------------------------------------------------------*PROVINCIA*-------------------------------------------------->
                                                        <TD class="cuadro02"><strong> PROVINCIA (*) </strong></TD>
                                                      </TR>
                                                      <TR>
                                                        <TD class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                            <FORM method="post" name="f2" onSubmit="return false;">
                                                              <SELECT id="m2" name="m2" onChange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;">
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
                                                        
                                                            <FORM method="post" name="f2" onSubmit="return false;">
                                                              <SELECT id="m2" name="m2" onChange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;">
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
                                                        <?php };?>                                                        </TD>
                                                      </TR>
                                                  </TABLE></TD>
                                                  <TD width="34%"><TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
                                                      <TR>
                                                        <TD class="cuadro02"><strong> COMUNA (*) </strong></TD>
                                                      </TR>
                                                      <TR>
                                                        <TD class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
                                                            <FORM  method="post" name="f3" onSubmit="return false;">
                                                              <select id="select" name=select onChange="document.frm.txtCOM.value=document.f3.m3.value;">
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
                                                            <FORM method="post" name="f3" onSubmit="return false;">
                                                              <SELECT id="m3" name="m3" onChange="document.frm.txtCOM.value=document.f3.m3.value;">
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
                                                        <?php };?>                                                        </TD>
                                                      </TR>
                                                  </TABLE></TD>
                                                </TR>
                                            </TABLE>
                                      <p>&nbsp;</p></td>
                                    </tr>
                                    <tr>
                                      <td><TABLE width="100%" Border=0 cellpadding=0 cellspacing=0 >
                                          <tr>
                                        <td>
										<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666">
                                                        <TR class="cuadro01">
                                                          <TD colspan="4" class="cuadro02"><strong>DATOS DEL DIRECTOR </strong></TD>
                                                        </TR>
                                                        <TR class="cuadro01">
                                                          <TD width="100" class="cuadro02"> <strong>RUN</strong>  </TD>
                                                          <TD width="83" class="cuadro01"><?php
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
                       ?>                                                          </TD>
                                                          <TD width="24" align="center" class="cuadro01">&nbsp;-&nbsp;</TD>
                                                          <TD width="478" align="left" class="cuadro01"><?php if($frmModo=="ingresar"){ 
						     imp($filaEMP['dig_rut']);
					     };?>
                                                              <?php 
							if($frmModo=="mostrar"){ 
							 imp($filaEMP['dig_rut']);
						};
						 ?>
                                                              <?php if($frmModo=="modificar"){ 
						imp($filaEMP['dig_rut']);
						};?>                                                          </TD>
                                                      </TR>
                                                        <TR class="cuadro01">
                                                          <TD class="cuadro02"><strong>NOMBRE</strong></TD>
                                                          <TD colspan="3" class="cuadro01"><strong>
														  <?=imp($filaEMP['nombre_emp'])?>&nbsp;
														  <?=imp($filaEMP['ape_pat'])?>&nbsp;
														  <?=imp($filaEMP['ape_mat'])?>
                                                          </strong></TD>
                                                        </TR>
                                                    </TABLE>
													
													</td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td height="40" align="center" valign="middle"><br>
                                      <table width="80%" border="0" cellspacing="0" cellpadding="0">
                                        <tr align="center" valign="middle">
                                          <td width="70%" align="right"><table width="80%" border="0" cellpadding="0" cellspacing="0" class="boton02">
                                            <tr align="center" valign="middle">
                                              <td height="23">
											  <?php if($_PERFIL==0) {?>
												  <a href="listarInstituciones.php3?modo=ini&pag=1" class="boton02"><img src="cortes/atras.gif" width="11" height="11" border="0"> Volver</a>
											  <? }?>
											  </td>
                                                    <td><a href="#arriba" class="boton02"><img src="cortes/subir.gif" width="11" height="11" border="0">Subir</a> </td>
                                                    <td><a href="javascript:;" onClick="window.print();" class="boton02"><img src="cortes/print.gif" width="11" height="11" border="0"> Imprimir</a></td>
                                            </tr>
                                            </table></td>
                                        </tr>
                                      </table></td></tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td align="center" valign="middle">&nbsp;</td>
                              </tr>
                            </table>
							
							
							</td>
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
          <td width="53" align="left" height="800" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
