<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	$_bot = 0;
	$ano			=$_ANO;
	
	$sql_ano="select * from ano_escolar where id_ano=$ano";
		$res_ano=@pg_exec($conn,$sql_ano)or die ('no conecto');
		$fil_ano=@pg_fetch_array($res_ano,0);
		$nro_ano=$fil_ano['nro_ano'];
	
	
	foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   }
   
   foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
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
function visible(opcion,form){
if(document.getElementById(opcion).value==1){
colegio.style.visibility='visible';
corporacion.style.visibility='hidden';
form.corporacion.value=0;

}
if(document.getElementById(opcion).value==2)
{
corporacion.style.visibility='visible';
colegio.style.visibility='hidden';
form.rdb.value="";
form.nomcolegio.value="";

}


}
//-->
</script>
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">

<script language="JavaScript">
<!--
function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=300, height=266, top=85, left=140";
window.open(pagina,"",opciones);
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
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
                                  <td><!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
									<FORM  name="form" action="printCantInfoxColegio.php" method="get" target="_blank" >
<table border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center" valign="top"> 
      
	  
	  
	  
	  
	   </td>
  </tr>
</table>
<center>
  <table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="right"></td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="1" cellpadding="3">
	<TR height=20>
		<TD colspan=2 align=center class="tableindex"> <input type="hidden" name="nro_ano" value="<?php echo $nro_ano ?>">
		  Cantidad de Informaci&oacute;n por Colegio </TD>
	</TR>
</table>
<br>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
      <tr>
        <td width="5%"  align="center" valign="middle"><input name="opc" id="opc1" type="radio" value="1" onClick="visible(this.id,this.form)"></td>
        <td width="14%"  class="datosB">Buscar por Colegio</td>
        <td width="81%"  class="datosB"><div id="colegio" style="visibility:hidden">&nbsp;RDB&nbsp;
          <input name="rdb" type="text" id="rdb" size="10">
          o Nombre Colegio           
          <input name="nomcolegio" type="text" id="nomcolegio">&nbsp;
          <input type="submit" name="cb_ok" value="Buscar" class="botonXX" >
          &nbsp;<input name="submit" type="submit" class="botonXX" value="Exportar"></div></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><input name="opc" type="radio" id="opc2" value="2" onClick="visible(this.id,this.form)"></td>
        <td align="left" class="datosB">
		Buscar por Corporación</td>
        <td align="left" class="datosB"><div id="corporacion" style="visibility:hidden">
		<?
			//select corporaciones 
			$sql_corp="select * from corporacion order by nombre_corp";
			$res_corp=@pg_exec($conn,$sql_corp)
		
		?>
		  <select name="corporacion" >
            <option value=0>(Seleccione Corporación)</option>
			<option value="-1">Colegios sin corporación</option>
			<? 
			for ($i=0;$i<pg_numrows($res_corp);$i++)
			{
				$fil_corp=@pg_fetch_array($res_corp,$i);
				$num_corp=$fil_corp['num_corp'];
				$nombre_corp=$fil_corp['nombre_corp'];
			
			?>
			 <option value="<?php echo $num_corp ?>"><?php echo $nombre_corp ?></option>
			
			<?
			}
			?>
          </select>
		  <input type="submit" name="cb_ok" value="Buscar" class="botonXX" >
		  &nbsp;<input name="submit" type="submit" class="botonXX" value="Exportar">
          </div></td>
      </tr>
      
    </table></td>
  </tr>
</table>
<br>

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
                      <td height="45" colspan="2" class="piepagina"><?
						 include("../../../cabecera/menu_inferior.php");
						 ?></td>
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
<? pg_close($conn);?>
