<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	$ano			=$_ANO;
   $_MDINAMICO = 1;	
	
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
		form.action = 'agregar_seleccion.php';
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
/*function valida() {

	if(!chkVacio(frm.txt_corp,'Ingrese Corporación')){
		return false;
	};
	
	if (!/^([0-9])*$/.test(numero))
		alert("El valor " + numero + " no es un número");
	}
	frm.submit()
	
}*/
   function ver_confirm()
   {
    if (document.form.sigla.value.length==0){
       alert("Favor Escribir Sigla")
       document.form.sigla.focus()
       return 0;
    }
	  if (document.form.descripcion.value.length==0){
       alert("Favor Escribir Sigla")
       document.form.descripcion.focus()
       return 0;
    } 
	 document.form.action = "procesaseleccion.php";
     document.form.submit();
	 
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
					  <form name="form" method="post" action="">
					  <input type="hidden" name="modo" value="1">
					  <table width="260" border="1" align="center">
                        <tr>
                          <td colspan="2" class="tableindex"><center>Ingreso de Vacantes </center></td>
                        </tr>
                 
                        <tr>
                          <td class="textosimple">Ense&ntilde;anza:</td>
                          <td>&nbsp;
						    <select name="ensenanza" class="ddlb_9_x" onChange="enviapag(this.form);">
						  <?
						  		$qry_corp ="SELECT cod_tipo,nombre_tipo FROM tipo_ensenanza  where cod_tipo in(select cod_tipo from tipo_ense_inst where rdb=$institucion) order by nombre_tipo asc";
								$resultado=@pg_Exec($conn,$qry_corp);
							 	for($i=0 ; $i < @pg_numrows($resultado) ; $i++){
									$fila = @pg_fetch_array($resultado,$i); 
									if (trim($fila["cod_tipo"])==trim($ensenanza)){
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
                          <td width="81" class="textosimple">Curso:</td>
                          <td width="163">&nbsp;
						  <select name="curso" class="ddlb_9_x" >
						  <?
									$qry_corp ="SELECT grado_curso,id_curso FROM curso where id_ano=".$ano." and ensenanza=".$ensenanza."order by grado_curso asc";
									$resultado=@pg_Exec($conn,$qry_corp);
							 	for($i=0 ; $i < @pg_numrows($resultado) ; $i++){
									$fila = @pg_fetch_array($resultado,$i); 
									if (trim($fila["id_curso"])==trim($cmb_curso)){
											echo "<option selected value=".$fila['id_curso'].">".$fila["grado_curso"]."</option>";
									}else{
											echo "<option value=".$fila['id_curso'].">".$fila["grado_curso"]."</option>";
									}
							} 
														  ?>
                              </select>
						  
						  </td>
                        </tr>
                        <tr>
                          <td class="textosimple">Sigla:</td>
                          <td><input name="sigla" type="text" id="sigla" size="30"></td>
                        </tr>
                        <tr>
                          <td class="textosimple">Descripcion
                          </td>
                          <td><input name="descripcion" type="text" id="descripcion" size="50"></td>
                        </tr>
                        <tr>
                          <td class="textosimple">Valor/Ponderaci&oacute;n</td>
                          <td><input name="valor" type="text" id="valor" size="10" onChange="validarSiNumero(this.value);"></td>
                        </tr>
                        <tr>
                          <td colspan="2"><INPUT class="botonXX" type="button" value="GUARDAR" onClick="ver_confirm()">
                            <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick="document.location='Criterio_seleccion.php'"></td>
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