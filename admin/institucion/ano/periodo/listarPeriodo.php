<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
echo	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 1;
		if (!$ano){?>
	<script>
	alert ('Es posible que no tenga un año Seleccionado\r\no simplemente no existe ningun año escolar para la institucion \r\n');
	window.location= '../listarAno.php3';
</script>	
	
	<? exit;
		
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

if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../index.php";
		 </script>

<? } ?>			


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

		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
	
<LINK REL="STYLESHEET" HREF="../../../../<?=$_ESTILO?>" TYPE="text/css">
		<?php //nclude('../../../../util/rpc.php3');?>
<?php	if($frmModo=="ingresar"){
		//	include('../../../../util/rpc.php3');?>

			<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
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
			include('../../../../util/rpc.php3');?>
			<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
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
	



<script language="JavaScript">
function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=300, height=266, top=85, left=140";
window.open(pagina,"",opciones);
}
</script> 



</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						$menu_lateral=2;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
										
						
								  
							 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
									
									<table height="30" border="0" cellpadding="0" cellspacing="0">
 						 <tr> 
    <td height="30" align="center" valign="top"> 
      
	   
	  
	  
	   </td>
  </tr>
</table>
	<center>
		                              <table BORDER="0" CELLSPACING="1" CELLPADDING="3">
                                        <TR height=15> 
                                          <TD COLSPAN=6> <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
                                              <TR> 
                                                <TD> <FONT face="arial, geneva, helvetica" size=2> 
                                                  <strong>AÑO ESCOLAR</strong></FONT>	
                                                </TD>
                                                <TD> <FONT face="arial, geneva, helvetica" size=2> 
                                                  <strong>:</strong> </FONT> </TD>
                                                <TD> <FONT face="arial, geneva, helvetica" size=2> 
                                                  <strong> 
                                                  <?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												echo "indeterminado</td></tr></table>";?>
                                                  <br>
                                                  <br>
                                                  <table bordercolor="#990000" border="1">
                                                    <tr> 
                                                      <td align="center"> <font color="#990000"><b> 
                                                        Es posible que no tenga 
                                                        un año Seleccionado<br>
                                                        o simplemente no existe 
                                                        ningun año escolar para 
                                                        la intitucion </b> </font> 
                                                      </td>
                                                    </tr>
                                                  </table>
                                                  <? exit;
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila['nro_ano']);
												}
											}
										?>
                                                  </strong> </FONT> </TD>
                                              </TR>
                                            </TABLE></TD>
                                        </TR>
                                        <tr height="20"> 
                                          <td align="middle" colspan="6" class="tableindex"> 
                                            Per&iacute;odos </td>
                                        </tr>
                                        <tr > 
                                          <td align="center" class="tablatit2-1"> 
                                            NOMBRE </td>
                                          <td align="center" class="tablatit2-1"> 
                                            FECHA INICIO </td>
                                          <td align="center" class="tablatit2-1"> 
                                            FECHA TERMINO </td>
                                          <td align="center" class="tablatit2-1"> 
                                            DIAS HABILES </td>
                                          <td align="center" class="tablatit2-1"> 
                                            MOSTRAR NOTAS </td>
                                          <td align="center" class="tablatit2-1">ESTADO</td>
                                        </tr>
                                        <?php
				$qry="SELECT periodo.id_periodo, periodo.cerrado, periodo.dias_habiles, periodo.nombre_periodo, periodo.fecha_inicio, periodo.fecha_termino, periodo.mostrar_notas, ano_escolar.nro_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano.")) ORDER BY periodo.fecha_inicio";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
							exit();
						}
					}
			?>
                                        <?php
			
			        $cant_errores = 0;
					for($i=0;$i<@pg_numrows($result);$i++){
						$fila = @pg_fetch_array($result,$i);
										
										$nro_ano = $fila['nro_ano'];
						
										?>
                                        <?php if($modifica==1){ //ACADEMICO Y LEGAL?>
                                          <tr onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaPeriodo.php3?periodo=<?php echo $fila["id_periodo"];?>&caso=1')> 
                                          <?php }?>
                                          <td align="left"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
                                            <strong><?php echo $fila["nombre_periodo"];?></strong>	
                                            </font> </td>
                                          <td align="center"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
                                            <strong> 
                                            <?
											if ($fila['fecha_inicio']==NULL){
											     echo "<font face='verdana' size='1' color='FF0000'>¡Falta información!</font>";
												 $cant_errores++;
												 $tipo_error_1 = 1;
											}else{											
											     $nro_ano_p = substr($fila["fecha_inicio"],0,4);
												 
												 if ($nro_ano_p!=$nro_ano){
												    $cant_errores++;
													$tipo_error_2 = 1;
													?>												 
												    <font color='FF0000'><?=impF($fila["fecha_inicio"]);?></font><?
												 }else{
												     impF($fila["fecha_inicio"]);												 
												 }   												 
											}	 
											?>
                                            </strong> </font> </td>
                                          <td align="center"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
                                            <strong> 
                                            <?
											if ($fila['fecha_termino']==NULL){
											     echo "<font face='verdana' size='1' color='FF0000'>¡Falta información!</font>";
												 $cant_errores++;
												 $tipo_error_1 = 1;
											}else{											
											     impF($fila["fecha_termino"]);
											}	 
											?>
                                            </strong> </font> </td>
                                          <td align="center"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
                                            <strong>
											<?
											if ($fila['dias_habiles']==0){
											    echo "<font face='verdana' size='1' color='FF0000'>¡Falta información!</font>";
												$cant_errores++;
												$tipo_error_1 = 1;
											}else{
											    echo $fila["dias_habiles"];
											}	
											?></strong>	
                                            </font> </td>
                                          <td align="center"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
                                            <strong> 
                                            <?php 
											if($fila["mostrar_notas"]==1){
												echo "SI";
											}else{
												echo "NO";
											};
										?>
                                            </strong></font></td>
                                          <?
									if ($fila["cerrado"] == 1){ $estado = "CERRADO"; }else{ $estado = "ABIERTO"; } ?>
                                          <td align="center" > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
                                            <strong> 
                                            <?=$estado ?>
                                            </strong> </font></td>
                                        </tr>
                                        <?php
								     	 
					}
				}
			?>
                                      </table>
								<?
								if ($cant_errores>0){ ?>	  
	                                  <br>
									  <table width="80%" border="1"  cellpadding="0" cellspacing="0">
									  <tr>
									  <td bgcolor="#FFFFFF">
										  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
											<tr>
											  <td width="10%"><div align="center"><img src="../../../../icono_atencion.gif" width="33" height="28"></div></td>
											  <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" >Atenci&oacute;n esta p&aacute;gina contiene <font color="#FF0000"><b><?=$cant_errores?></b></font> observaciones las cuales debe corregir. </font></td>
											</tr>
											<tr>
											  <td>&nbsp;</td>
											  <td>
											   <? if ($tipo_error_1==1){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><font color="#FF0000">- Falta informaci&oacute;n, </font> En uno o más campos falta informaci&oacute;n para determinar ciertos procesos. </font><br><? } ?>
											   <? if ($tipo_error_2==1){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><font color="#FF0000">- Información incorrecta, </font> Información errónea o no concuerda con la información requerida. </font><br><? } ?>
											   <br>											   											  
											 </td>
											</tr>
										  </table>
									  </td>
									  </tr>
									  </table>
							 <? } ?>		  
							
							<br>
	</center>
									
									
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
									
									
									
								  </td>
							    </tr>
							 </table>							  
								  
								  
								  
								  
		
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php");?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close ($conn);?>