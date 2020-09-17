<?php require('../../../util/header.inc');
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	//------------------
	$sql = "SELECT DISTINCT ramo.cod_subsector, subsector.nombre ";
	$sql = $sql . "FROM ramo, subsector, curso ";
	$sql = $sql . "WHERE curso.id_ano = $ano and ramo.id_curso = curso.id_curso and ramo.cod_subsector = subsector.cod_subsector ";
	$sql = $sql . "ORDER BY ramo.cod_subsector; ";
	//------------------
	$resultado_query= pg_exec($conn,$sql);
	if (!$resultado_query){ echo "ERROR: $sql"; exit;}	
	$total_filas= pg_numrows($resultado_query);	
	//------------------
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
			
			<SCRIPT LANGUAGE="JavaScript">
			<!--
				function valida(form){
					for (x=0;x<=form.length-1;x++){
						if (form[x].name.substr(0,5)=="horas"){
							if(!chkVacio(form[x],'Debe ingresar cantidad de horas para este subsector')){
								return false;
							};
						};
					};
					for (x=0;x<=form.length-1;x++){
						if (form[x].name.substr(0,5)=="horas"){
							if(!nroOnly(form[x],'Debe ingresar un número válido')){
								return false;
							};
						};
					};				
					return true;
				};//-->
</SCRIPT>


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
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../estilos.css" rel="stylesheet" type="text/css">
</head>
<html>
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
									
									
							      <center>
<FORM method=post name="frm" action="procesoHoras.php">
<input type="hidden" name="NumeroSubsectores" value="<? echo $total_filas?>">
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td>
		<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
			<TR>
				<TD align=left>
					<FONT face="arial, geneva, helvetica" size=2>
						<strong>INSTITUCION</strong>
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
						</strong>
					</FONT>
				</TD>
			</TR>
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
									error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
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
						</strong>
					</FONT>
				</TD>
			</TR>
		</TABLE>
		<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="right">
	  <? IF(($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=6)){ ?>
 		  <? if ($accion==1){?>
			  <INPUT name="button" TYPE="button" class="botonXX" onClick=document.location="NumeroHorasSemanales.php?accion=2" value="MODIFICAR">
          <? } ?>
		  <? if ($accion==2){?>
			  <INPUT name="button" TYPE="submit" class="botonXX"  value="GUARDAR" onClick="return valida(this.form);">		  	
		  <? } ?>
	  <? } ?>
    <? if ($accion==1){?>
	  <INPUT name="button2" TYPE="button" class="botonXX" onClick=document.location="ano_escolar.php3"  value="VOLVER">	
	<? } else { ?>
  <INPUT name="button2" TYPE="button" class="botonXX" onClick=document.location="NumeroHorasSemanales.php?accion=1" value="VOLVER">
	 <? } ?>
	</td>
  </tr>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr height="20">
    <td align="center" class="tableindex">N&Uacute;NERO DE HORAS SEMANALES POR SUBSECTOR </td>
  </tr>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td class="tablatit2-1">C&Oacute;DIGO SUBSECTOR</td>
    <td class="tablatit2-1">NOMBRE SUBSECTOR</td>
    <td class="tablatit2-1">N&Uacute;MERO DE HORAS SEMANALES</td>
  </tr>
<?
for ($j=0; $j < $total_filas; $j++)
{
	$fila = @pg_fetch_array($resultado_query,$j);
?>
  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila["cod_subsector"];?>
      <input type="hidden" name="subsector[<? $j?>]" value="<? echo $fila["cod_subsector"]?>">
    </strong></font></td>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila["nombre"];?></strong></font></td>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>
	<? 
	//-------
	$sql="select * from horas_subsectores where cod_subsector = ".$fila["cod_subsector"]. " and id_ano = $ano";
	$resultado_horas = pg_exec($conn,$sql);
	$fila_horas = @pg_fetch_array($resultado_horas,0);
	//------
	?>
      <? if ($accion==2){?><input name="horas[<? echo $j ?>]" type="text" size="10" maxlength="10" value="<? echo $fila_horas['horas'];?>"><? } ?>
	  <? if ($accion==1){?><? echo $fila_horas['horas']."&nbsp;" ?><? } ?>
    </strong></font></td>
  </tr>
 <? } ?>
</table>
</td>
 </tr>
  
</table>		

</form>
							  
							  		
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
															
									</td>
								 </tr>
							 </table>							  
								  
								  
								  
								  
		
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
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<? pg_close($conn); ?>
</body>
</html>
