<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano 			= $_ANO;
	$_POSP = 3;
	$_bot = 0;

	if (empty($rut))
		$rut = $nombre_usuario;

	if ($tipo_clave==1){
		 $_TIPO_CLAVE = 1;	
		 session_register('_TIPO_CLAVE');
		 $sql = "select matricula.rut_alumno as rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu as nombres from matricula, alumno where matricula.rut_alumno = ".$rut." and id_ano = ".$ano." and matricula.rut_alumno = alumno.rut_alumno";
		 $rsResultado =@pg_Exec($conn,$sql);		
		 $fResultado= @pg_fetch_array($rsResultado,0);
		 $texto = "ALUMNO";
	}else{
//		$_TIPO_CLAVE = 1;		
		 $tipo_clave	= 0;			
		 session_register('_TIPO_CLAVE');
		 $sql = "select apoderado.rut_apo as rut, apoderado.ape_pat, apoderado.ape_mat, apoderado.nombre_apo as nombres from apoderado where apoderado.rut_apo = ".$rut." ";
		 $rsResultado =@pg_Exec($conn,$sql);			
		 $fResultado= @pg_fetch_array($rsResultado,0);		
		 $texto = "PADRES Y APODERADOS";
	}
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>
	function ir(form){
		var txtValor = document.form_detalle.nombre_usuario.value;
		var txtValor2= document.form_detalle.tipo_clave_aux.value;
		var txtURL = "DetalleClaves.php?rut=" + txtValor;
		window.location = "DetalleClaves.php?rut=" + txtValor + "&tipo_clave=" + txtValor2;
	}
</script>

<SCRIPT language="JavaScript" src="chkform.js"></SCRIPT>
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
						 $menu_lateral=1;
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
									
									
							      <form name="form_detalle">
<table border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center" valign="top">&nbsp; </td>
  </tr>
</table>
<center>

<input type="hidden" name="tipo_clave_aux" value="<? echo trim($tipo_clave)?>">
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="right"><INPUT class="botonXX"  name="button" TYPE="button" onClick=document.location="ListadoClaves.php?tipo=<?=$tipo_clave ?>" value="VOLVER"></td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="1" cellpadding="3">
	<TR height=20>
		<TD align=center colspan=2 class="tableindex">
			ADMINISTRADOR DE CLAVES - <? echo $texto?>
		</TD>
	</TR>
</table>
<br>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="114"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>RUT USUARIO </strong></font></td>
    <td width="120"><input name="nombre_usuario" type="text"  size="20" maxlength="10" value = "<? echo $rut ?>"></td>
    <td width="394"><input class="botonXX"  type="button" name="Submit2" value="BUSCAR" onClick="JavaScript:ir(this.form)"></td>
  </tr>
</table>
<br>
<?
$sqlUsuario = "select * from usuario where nombre_usuario = '".$rut."' and id_usuario in (select id_usuario from accede where rdb = '".$_INSTIT."')";
$rsUsuario =@pg_Exec($connection,$sqlUsuario);
$nUsuario = @pg_numrows($rsUsuario);

if ($nUsuario > 0){	
    $fUsuario= @pg_fetch_array($rsUsuario,0);
    ?>
    <div id="layerDetalle" style="visibility:<? if ($rut>0){?>visible<? }else{ ?>hidden<? }?> ">
    <table width="650" border="1" cellspacing="1" cellpadding="3">
      <tr>
        <td width="100"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>NOMBRE</strong></font><strong><font color="#000000" size="1" face="arial, geneva, helvetica"> USUARIO </font></strong></td>
        <td width="529"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $rut?></font>&nbsp;</td>
      </tr>
      <tr>
        <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>CLAVE</strong></font></td>
        <td><font face="Arial, Helvetica, sans-serif" size="-1"><?
	    echo $fUsuario['pw'];
	    ?></font>&nbsp;</td>
      </tr>
      <tr>
        <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>NOMBRE</strong></font><strong><font color="#000000" size="1" face="arial, geneva, helvetica"> </font></strong></td>
        <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(strtolower(trim($fResultado['ape_pat'])." ".trim($fResultado['ape_mat'])." ".trim($fResultado['nombres'])))?></font>&nbsp;</td>
      </tr>
     </table><br>
     <table width="650" border="0" cellspacing="1" cellpadding="3">
      <tr>
      <td>
	 
	 <? if ($_PERFIL==0 || $_NOMBREUSUARIO==21582867 || $_NOMBREUSUARIO==9171039  ){?>
	  <? if ($tipo_clave==1){ ?>
	  <input class="botonXX"  type="button" name="Submit22" value="EDITAR" onClick=document.location="curso/alumno/usuario/usuario.php3?RUT=<? echo trim($rut)?>">
	  <? } else { ?>
	  <input class="botonXX"  type="button" name="Submit22" value="EDITAR" onClick=document.location="curso/alumno/apoderado/usuario/usuario.php3?RUT=<? echo trim($rut)?>">	
	  <? } ?>	
	  <? } ?></td>
      </tr>
     </table>
     </div>
	 
	 
<? }else{
       if ($rut!=NULL){ 
           ?>
	       <table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
		     <tr>
		       <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">No existe usuario en la instituci&oacute;n actual. </font></td>
		     </tr>
	       </table>
	 <? } ?>	   
		   
<? } ?>  
   
</center>
</form>
									
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
															
									</td>
								 </tr>
							 </table>							  
								  
								  
								  
								  
		
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"> <? include("../../../cabecera/menu_inferior.php");?></td>
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
<?
pg_close($conn);
?>
</body>
</html>
