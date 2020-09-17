<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	$ano			=$_ANO;
   $_MDINAMICO = 1;	
    $cmb_curso=$_POST["curso"];
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript">
function enviapag(form){
	if (form.ensenanza.value!=0){
		form.ensenanza.target="self";
		form.target="_parent";
		form.action = 'agregar_vacantes.php';
		form.submit(true);
	}	
}
				
</script>
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
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
function valida() {

	if(!chkVacio(frm.txt_corp,'Ingrese Corporación')){
		return false;
	};

	frm.submit()
	
}
//-->
</script>

		<?php include('../../util/rpc.php3');
		$cmb_ensenanza=$_POST["ensenanza"];?>
	
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
		 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../cabecera/menu_superior.php");
			   ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=2;
						 include("../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
					  <center>
					  <form name="form" method="post" action="procesavacantes.php">
					  <input type="hidden" name="modo" value="1">
					  <table width="260" border="1" align="center">
                        <tr>
                          <td colspan="2" class="tableindex">Ingreso de Vacantes </td>
                        </tr>
                 
                        <tr>
                          <td><font face="arial, geneva, helvetica" size="2" color="#000000"> Ense&ntilde;anza:</font></td>
                          <td>&nbsp;
						    <select name="ensenanza" class="ddlb_9_x" onChange="enviapag(this.form);">
						  <?
						  		$qry_corp ="SELECT cod_tipo,nombre_tipo FROM tipo_ensenanza  where cod_tipo in(select cod_tipo from tipo_ense_inst where rdb=$institucion) order by nombre_tipo asc";
								$resultado=@pg_Exec($conn,$qry_corp);
							 	for($i=0 ; $i < @pg_numrows($resultado) ; $i++){
									$fila = @pg_fetch_array($resultado,$i); 
									if (trim($fila["cod_tipo"])==trim($cmb_ensenanza)){
											echo "<option selected value=".$fila['cod_tipo'].">".$fila["nombre_tipo"]."</option>";
									}else{
											echo "<option value=".$fila['cod_tipo'].">".$fila["nombre_tipo"]."</option>";
									}
							} 
														  ?>
                              </select>
						  </td>
                        </tr>
						       <tr>
                          <td width="81"><font face="arial, geneva, helvetica" size="2" color="#000000"> Curso:</font></td>
                          <td width="163">&nbsp;
						  <select name="curso" class="ddlb_9_x" onChange="enviapag(this.form);">
						  <?
									$qry_corp ="SELECT grado_curso FROM curso where id_ano=".$ano." and ensenanza=".$cmb_ensenanza." group by grado_curso";
									$resultado=@pg_Exec($conn,$qry_corp);
							 	for($i=0 ; $i < @pg_numrows($resultado) ; $i++){
									$fila = @pg_fetch_array($resultado,$i); 
									if (trim($fila["grado_curso"])==trim($cmb_curso)){
											echo "<option selected value=".$fila['grado_curso'].">".$fila["grado_curso"]."</option>";
									}else{
											echo "<option value=".$fila['grado_curso'].">".$fila["grado_curso"]."</option>";
									}
							} 
														  ?>
                              </select>
						  
						  </td>
                        </tr>
                        <tr>
                          <td><font face="arial, geneva, helvetica" size="2" color="#000000"> Cantidad:</font></td>
                          <td><input name="cantidad" type="text" id="cantidad" size="4"></td>
                        </tr>
                        <tr>
                          <td colspan="2">
                            <INPUT class="botonXX"  TYPE="SUBMIT" value="GUARDAR">
							<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick="document.location='vacantes.php'">
                          </td>
                        </tr>
                      </table>
					  </form>
					  </center>
					  </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
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
