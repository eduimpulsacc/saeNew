<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	$_bot = 10;
	
	if ($botonera==1){
	$frmModo="mostrar";
	}else{
	$frmModo		=$_FRMMODO;
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

		<?php include('../../../util/rpc.php3');?>
<?php	if($frmModo=="ingresar"){
			include('../../../util/rpc.php3');?>

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
			</SCRIPT>
<?php	}; ?>
<?php	if($frmModo=="modificar"){
			include('../../../util/rpc.php3');?>
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
									
									<?
						             include("../../../cabecera/menu_inferiorinstitucion.php");
						            ?>
									
									
									  <?php if (($_PERFIL!=15)and($_PERFIL!=16)and($_PERFIL!=17)&&($_PERFIL!=8)){?>
									  <?php } ?>
<center>
  <table WIDTH="599" BORDER="0" CELLSPACING="1" CELLPADDING="3">
    <TR valign="top"> 
      <TD COLSPAN=2> 
        <TABLE width="375" BORDER=0 CELLPADDING=1 CELLSPACING=1>
						<TR>
			<br>				
            <TD width="101" align=left valign="top"> <FONT face="arial, geneva, helvetica" size=2> 
              <strong>INSTITUCION</strong> </FONT> </TD>
							<TD width="10">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD width="254">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
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
													echo trim($fila['nombre_instit']);
												}
											}
										?>
									</strong>								</FONT>							</TD>
						</TR>
					</TABLE>
					<br>
					<br>
				
				</TD>
			</TR>
			<tr>
				<td colspan=2 align=right>
					<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5) and ($_PERFIL!=15)&&($_PERFIL!=16)){ //FINANCIERO Y  CONTADOR?>
						<INPUT class="botonXX"  TYPE="button" value="AGREGAR" onClick=document.location="seteaLibro.php3?caso=2">
											<?php }?>
					<?php } //ACADEMICO Y LEGAL?>
					<?php if(($_PERFIL!=7) and ($_PERFIL!=15)&&($_PERFIL!=16)){?>
						<!--INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="../seteaInstitucion.php3?caso=4"-->
					<?php }?>
				</td>
			</tr>
			
    <tr height="20"> 
      <td colspan="3" align="middle" class="tableindex"> TOTAL DE LIBROS </td>
			</tr>
			<tr bgcolor="#48d1cc">
				<td align="center" width="97" class="tablatit2-1">
					ISBN
				</td>
				<td align="center" width="487" class="tablatit2-1">
					TITULO
				</td>
			</tr>
			<?php
				$qry="SELECT * FROM libro WHERE RBD=$institucion order by titulo";
				$result=@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
			?>
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaLibro.php3?libro=<?php echo $fila["id"];?>&caso=1')>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["isbn"];?></strong>
								</font>
							</td>
							<td align="left" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["titulo"];?></strong>
								</font>
							</td>
						</tr>
			<?php
					}
				}
			?>
			<tr>
				<td colspan="2">
				<hr width="100%" color="003b85">
				</td>
			</tr>
		</table>
	</center>
									
									
									
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
