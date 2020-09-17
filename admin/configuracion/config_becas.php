<?	require('../../util/header.inc');
	//include('../../clases/class_MotorBusqueda.php');
	//include('../../clases/class_Membrete.php');
	//include('../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$tipo;
	$id_beca;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link href="../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">


function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function valida(form){
	if(form.beca.value==""){
	alert('Ingrese nombre para la beca');
	return false;
	}
	
	if(form.desc.value==""){
	alert('Ingrese alguna descripcion para la beca');
	return false;
	}
	form.submit(true);

}


function enviapag(form){

		form.action = 'procesaagregar_becas.php?id_beca=<?=$id_beca?>';
		form.submit(true);
	
}
		
		
									
</script>
<style type="text/css">
.texto {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: normal;
	color: #666666;
	text-decoration: none;
	text-align: left;
	text-indent: 0pt;

}
</style>
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
<!--								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="" align="center" valign="top"> >>>>>>>>>>>>>>>>>>>>>>>>>>>></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>-->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->


<FORM method="post" name="form" action="procesaagregar_becas.php?ano=<?=$ano?>&tipo=2">

<? if(!$tipo){?>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0"  class="cuadro01">
    <tr>
      <td colspan="3" class="tableindex">INGRESO DE BECA</td>
      </tr>
    <tr height="40">
      <td width="33%">Nombre</td>
      <td width="33%"><input name="beca" type="text" id="beca"></td>
      <td width="33%"><input type="button" name="Submit" value="Guardar" class="botonXX" onClick="valida(this.form)">
        <input name="volver" type="button" class="botonXX" onClick="window.location='ingreso_becas.php'" id="volver" value="Volver"></td>
    </tr>
    <tr height="100">
      <td width="33%">Descripci&oacute;n</td>
      <td width="33%"><textarea name="desc" id="desc" rows="5" class="texto" cols="30"></textarea></td>
      <td width="33%">&nbsp;</td>
    </tr>
  </table>
  
  
 
 <? }else{?>

<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0"  class="cuadro01">
    <tr>
      <td colspan="3" class="tableindex">MODIFICACI&Oacute;N DE BECA</td>
	  <?
	  $sql="SELECT * FROM becas_conf WHERE id_beca=".$id_beca;
	  $res_sql=@pg_exec($conn,$sql);
	  $beca=pg_fetch_array($res_sql,0);
	  
	  ?>
      </tr>
    <tr height="40">
      <td width="33%">Nombre</td>
      <td width="33%"><input name="beca" type="text" id="beca" value="<?=$beca['nomb_beca']?>"></td>
      <td width="33%"><input type="button" name="Submit" value="Guardar" class="botonXX" onClick="enviapag(this.form)">
        <input name="volver" type="button" class="botonXX" onClick="window.location='ingreso_becas.php'" id="volver" value="Volver"></td>
    </tr>
    <tr height="100">
      <td width="33%">Descripci&oacute;n</td>
      <td width="33%">
        <textarea name="desc" id="desc" rows="5" class="texto" cols="30"><?=$beca['descripcion']?></textarea></td>
      <td width="33%">&nbsp;<input type="hidden" name="tipo" value="<?=$tipo?>"></td>
    </tr>
  </table> 
 <? }?> 
</FORM>

<!-- FIN CUERPO DE LA PAGINA -->

 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>