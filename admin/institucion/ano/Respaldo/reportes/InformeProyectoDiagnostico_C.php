<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno 		=$c_alumno;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	/*$sql = "SELECT id_dignos,nombre,tipo FROM diagnostico WHERE rdb=".$institucion;
	$rs_diag = @pg_exec($conn,$sql);*/
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
var ArrayDiagnostico = new Array();
var contador_diag;
<?php   $sql = "SELECT id_dignos,nombre,tipo FROM diagnostico ";
		$result = pg_exec($conn,$sql);
		$i=0;
		for ($i=0;$i<pg_numrows($result);$i++){
			$fila = pg_fetch_array($result,$i); ?>
			var ArrayFilProv = new Array(3);
			ArrayFilProv[0] = '<?php echo Trim($fila["id_dignos"])?>';
			ArrayFilProv[1] = '<?php echo Trim($fila["tipo"])?>';
			ArrayFilProv[2] = '<?php echo Trim($fila["nombre"])?>';
			ArrayDiagnostico[<?php echo $i?>] = ArrayFilProv;
<?php   }
	@pg_close($result); ?>
	contador_diag = <?php echo $i?>;
	
	
	
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
function muestra_campo(form){
	var campo;
	var campo2;
	campo=document.getElementById("cmbPROYECTO");
	campo2=document.getElementById("cmbGRUPO");
	
	if(document.form.rdPROYECTO[0].checked==true){
		campo.style.visibility = "visible"  
		campo2.style.visibility = "hidden" 
		 document.form.cmbDIGNOSTICO.length =0;
		 for(i=0;i<=contador_diag-1;i++){
		 	if (ArrayDiagnostico[i][1]==1){
				document.form.cmbDIGNOSTICO.options[document.form.cmbDIGNOSTICO.options.length++] = new Option(ArrayDiagnostico[i][2]);
				document.form.cmbDIGNOSTICO.options[document.form.cmbDIGNOSTICO.options.length - 1].value = ArrayDiagnostico[i][0];
			};
		}; 
	}else if(document.form.rdPROYECTO[1].checked==true){
		campo.style.visibility = "hidden"  
		campo2.style.visibility = "visible" 
		document.form.cmbDIGNOSTICO.length =0; 
		 for(i=0;i<=contador_diag-1;i++){
			if (ArrayDiagnostico[i][1]==2){
				document.form.cmbDIGNOSTICO.options[document.form.cmbDIGNOSTICO.options.length++] = new Option(ArrayDiagnostico[i][2]);
				document.form.cmbDIGNOSTICO.options[document.form.cmbDIGNOSTICO.options.length - 1].value = ArrayDiagnostico[i][0];
			};
		}; 
	}
}
function pagina(form){
	var campo;
	if(document.form.rdPROYECTO[0].checked==true){
		form.action='printProyectoIntegracionPorDiagnostico_C.php';
	}else if(document.form.rdPROYECTO[1].checked==true){
		form.action='printGrupoDiferencialPorDiagnostico_C.php';
	}
	form.submit(true);
}

//-->
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <?  include("../../../../cabecera/menu_superior.php");  ?>
            <!-- FIN DE COPIA DE CABECERA -->        </td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><!-- AQUI VA EL MEN{U LATERAL -->
                  <?
						 $menu_lateral=3;
						 include("../../../../menus/menu_lateral.php");
						 ?>
                  <!--  FIN MENU LATERAL -->              </td>
              <td width="73%" align="left" valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="395" align="left" valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                        <tr>
                          <td><!-- FIN DEL CONTENIDO CENTRAL DE LA PÁGINA -->
                              <!-- INSERTO EL CONTENIDO DEL MOTOR DE BUSQUEDA -->
                            <br>
                              <br>
                              <form method "post" action="" name="form" target="_blank">
                                <input name="c_reporte" type="hidden" value="<?=$reporte;?>">
                                <center>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><table width="100%" height="43" border="1" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td class="tableindex">Buscador Avanzado </td>
                                          </tr>
                                          <tr>
                                            <td height="27"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                  <td width="35%" class="cuadro01"><div align="right">Proyecto Integracion : </div></td>
                                                  <td width="11%" class="cuadro01"><div align="left">
                                                    <input name="rdPROYECTO" type="radio" value="1" onClick="muestra_campo(this.form)">
                                                  </div></td>
                                                  <td width="54%" class="cuadro01" align="left">
												  <? 	$sql = "SELECT id_proy,nombre FROM proyecto_grupo WHERE rdb=".$institucion." AND tipo=1";
												  		$rs_proyecto = @pg_exec($conn,$sql);
												?>
												<div id="proyecto">
												<select name="cmbPROYECTO" style="visibility:hidden" id="cmbPROYECTO">
													<option value="0">seleccione</option>
													<? for($i=0;$i<@pg_numrows($rs_proyecto);$i++){
															$fila_pro = @pg_fetch_array($rs_proyecto,$i);
													?>
													<option value="<?=$fila_pro['id_proy'];?>"><?=$fila_pro['nombre'];?></option>
													<? } ?>
												</select>	
												</div>												   </td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro01"><div align="right">Grupo Diferencial :</div></td>
                                                  <td class="cuadro01"><div align="left">
                                                    <input name="rdPROYECTO" type="radio" value="2" onClick="muestra_campo(this.form)">
                                                  </div></td>
                                                  <td class="cuadro01">
												   <? 	$sql = "SELECT id_proy,nombre FROM proyecto_grupo WHERE rdb=".$institucion." AND tipo=2";
												  		$rs_proyecto = @pg_exec($conn,$sql);
													?>
												<div id="grupo">
												<select name="cmbGRUPO" style="visibility:hidden" id="cmbGRUPO">
													<option value="0">seleccione</option>
													<? for($i=0;$i<@pg_numrows($rs_proyecto);$i++){
															$fila_pro = @pg_fetch_array($rs_proyecto,$i);
													?>
													<option value="<?=$fila_pro['id_proy'];?>"><?=$fila_pro['nombre'];?></option>
													<? } ?>
												</select>
												</div>												   </td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro01"><div align="right">Diagnostico :</div></td>
                                                  <td colspan="2" class="cuadro01">
												  <? 	$sql = "SELECT id_dignos, nombre FROM diagnostico WHERE rdb=".$institucion;
												  		$rs_dig = @pg_exec($conn,$sql);
													?>
													<select name="cmbDIGNOSTICO">
													<option value="0">seleccione</option>
													</select>	
												  
												  &nbsp;</td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro01">&nbsp;</td>
                                                  <td colspan="2" class="cuadro01">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                  <td colspan="3" class="cuadro01"><div align="center">
                                                    <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" value="Buscar" onClick="pagina(this.form);">
                                                    
                                                    <? if($_PERFIL==0){?>		  
                                                    <input name="cb_exp" type="submit"  class="botonXX"  id="cb_exp" value="Exportar">
                                                    <? }?>												  
                                                    <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
                                                  </div></td>
                                                </tr>
                                            </table></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                  </table>
                                </center>
                              </form>
                            <!-- FIN DEL CONTENIDO DEL MOTOR DE BUSQUEDA -->                          </td>
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
    <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
      </table>
</td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>