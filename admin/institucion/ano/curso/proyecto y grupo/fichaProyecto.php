<? require('../../../../../util/header.inc'); 
	//include('../../../../clases/class_MotorBusqueda.php');
	//include('../../../../clases/class_Membrete.php');
	//include('../../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	

 echo "cmbPROYECTO ".$cmbPROYECTO;

	$sql = "select a.*,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' '  as varchar) || ape_mat as empleado FROM proyecto_grupo a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$institucion." AND id_proy=".$id_pro."";
	$rs_proy = @pg_exec($conn,$sql);
	$fila = @pg_fetch_array($rs_proy,0);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript">
function enviapag(form){
	form.action='fichaProyecto.php';
	form.submit(true);
}									
</script>

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
<style type="text/css">
<!--
.Estilo16 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg');
<? if($tipo==1){?>
	txt_ciclo();
<? }?>
">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>"></td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"><?
				include("../../../../../cabecera/menu_superior.php");
				?></td>
              </tr>
          </table></td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>              </td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  
                  <tr>
                    <td height="395" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                        <tr>
                          <td valign="top"><!-- INCLUYO CODIGO DE LOS BOTONES -->
                              <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td width="" height="30" align="center" valign="top"><? include("../../../../../cabecera/menu_inferior.php");?></td>
                                </tr>
                              </table>
                            <form id="form" name="form" action="" method="post">
                              <input name="caso" value="<?=$caso;?>" type="hidden">
                                <input name="id_pro" value="<?=$id_pro;?>" type="hidden">
                                <table width="650" border="0" align="center" cellpadding="5" cellspacing="0">
                                  <tr>
                                    <td width="289"><span class="Estilo16">Proyecto Intergraci&oacute;n o Grupo Diferencial </span></td>
                                    <td width="3"><strong>:</strong></td>
                                    <td width="328">
									<?  $sql = "SELECT id_proy,nombre,tipo FROM proyecto_grupo WHERE rdb=".$institucion." ORDER BY tipo ASC";
										$rs_proyecto = @pg_exec($conn,$sql);
									?>
									<select name="cmbPROYECTO" onChange="enviapag(this.form)">
										<option value="0">seleccione</option>
										<? for($i=0;$i<@pg_numrows($rs_proyecto);$i++){
												$fila_pro = @pg_fetch_array($rs_proyecto,$i);
											if($fila_pro['tipo']==1){?>
												<option value="<?=$fila_pro['id_proy'];?>"><?=$fila_pro['nombre']." (PI)";?></option>
											<? }else{?>
												<option value="<?=$fila_pro['id_proy'];?>"><?=$fila_pro['nombre']." (GD)";?></option>
										<? 	   }
										} ?>
									</select>
									&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td><span class="Estilo16">Alumno</span></td>
                                    <td><strong>:</strong></td>
                                    <td>&nbsp;
									
									</td>
                                  </tr>
                                </table>
								<br>
								<br>
                            </form></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr align="center" valign="middle">
              <td height="45" colspan="2" class="piepagina">SAE Sistema 
                de Administraci&oacute;n Escolar - 2005</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
   </tr>
      </table>
 </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>