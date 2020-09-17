<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 1;
		if (!$ano){?>
	<script>
	alert ('Es posible que no tenga un año Seleccionado\r\no simplemente no existe ningun año escolar para la intitucion \r\n');
	window.location= '../listarAno.php3';
</script>	
	
	<? exit;
		
	}
	
// actualizacion del periodo si corresponde

if ($act_in==1){
     $qry2="SELECT periodo.id_periodo, periodo.cerrado, periodo.dias_habiles, periodo.nombre_periodo, periodo.fecha_inicio, periodo.fecha_termino, periodo.mostrar_notas FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano.")) ORDER BY periodo.fecha_inicio";
	 $result2 =@pg_Exec($conn,$qry2);
	 if (!$result2) {
		  error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
	 }else{
		  if (pg_numrows($result2)!=0){
			  $num_p = pg_numrows($result2);
			  for ($i=0; $i < $num_p; $i++){
			      $ing_notas = "ing_notas".$i;
				  $ing_notas = $$ing_notas;
				  
				  $act_pi    = "act_pi".$i;
				  $act_pi    = $$act_pi;
				  
				  			  
				  if ($ing_notas==1){
				      $valor = 1;
				  }else{
				      $valor = 0;
				  }			
				  $qry3 = "update periodo set ing_notas = '".trim($valor)."' where id_periodo = '".trim($act_pi)."'";
				  $res3 = pg_Exec($conn,$qry3);
			  }
		 }
	 }
}	 	 	  	  

/// fin actualizacion del periodo
	
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
      
	   <?
						 include("../../../../cabecera/menu_inferior.php");
						 ?>
	  
	  
	   </td>
  </tr>
</table>
	<center>
	
								<form name="form1" method="post" action="config_ing_notas.php">
								     <input name="act_in" type="hidden" value="1">
		                              <table width="100%" BORDER="0" CELLPADDING="3" CELLSPACING="1">
                                        <TR height=15> 
                                          <TD COLSPAN=5> <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
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
                                                        la institucion </b> </font> 
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
                                            <td align="middle" colspan="5" class="tableindex"> 
                                              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                  <td class="tableindex">Per&iacute;odos </td>
                                                  <td class="tableindex"><div align="right">
                                                      <input type="submit" name="Submit" value="ACTUALIZAR" class="BotonXX">
                                                    </div></td>
                                                </tr>
                                              </table>
                                            </td>
                                        </tr>
                                        <tr > 
                                          <td align="center" class="tablatit2-1"> 
                                            NOMBRE </td>
                                          <td align="center" class="tablatit2-1"> 
                                            FECHA INICIO </td>
                                          <td align="center" class="tablatit2-1"> 
                                            FECHA TERMINO </td>
                                          <td align="center" class="tablatit2-1">ESTADO 
                                          </td>
                                            <td align="center" class="tablatit2-1">&nbsp;</td>
                                        </tr>
                                        <?php
				$qry="SELECT periodo.id_periodo, periodo.cerrado, periodo.dias_habiles, periodo.nombre_periodo, periodo.fecha_inicio, periodo.fecha_termino, periodo.mostrar_notas FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano.")) ORDER BY periodo.fecha_inicio";
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
			
			
					for($i=0;$i<@pg_numrows($result);$i++){
						$fila = @pg_fetch_array($result,$i);
						$ing_notas = $fila['ing_notas'];
						
			                            ?>
                                        <?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
                                        <tr> 
                                          <?php }?>
                                          <td align="left"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
                                            <strong><?php echo $fila["nombre_periodo"];?></strong>	
                                            </font> </td>
                                          <td align="center"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
                                            <strong>
                                            <?php impF($fila["fecha_inicio"]);?>
                                            </strong> </font> </td>
                                          <td align="center"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
                                            <strong>
                                            <?php impF($fila["fecha_termino"]);?>
                                            </strong> </font> </td>
                                          <td align="center"> <font face="arial, geneva, helvetica" size="1" color="#000000"><strong> 
										    <?
									         if ($fila["cerrado"] == 1){ $estado = "CERRADO"; }else{ $estado = "ABIERTO"; } ?>
                                            <?=$estado ?>
                                            </strong> </font> </td>
                                            <td align="center"> <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp; 
                                              </font></td>
                                          
                                        </tr>
                                        <?php
								     	 
					}
				}
			?>                    </table>
				                  </form>					  
									  
									  
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
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
