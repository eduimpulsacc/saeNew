<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot  =8;
	
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<SCRIPT language="JavaScript" src="../../../../util/chkform.js">
function generar(){
	if(confirm('!!ESTE PROCESO AGREGA TODOS LOS ALUMNOS PROMOVIDOS Y NO RETIRADOS DEL AÑO ANTERIOR¡¡') == false){ return; };
	document.location="../procesoMatAuto.php3"
};


function Confirmacion(){
if(alert('¡EL INGRESO DE REGIMEN ES IRREVERSIBLE, DEBE ESTAR SEGURO DEL REGIMEN PARA ESTE AÑO ESCOLAR!') == false){ return; };
};
//-->
</script>

<SCRIPT language="JavaScript">
	//	var modo.value = <? echo $_FRMMODO ?>;
	/*
	function generar(){
		if(confirm('!!ESTE PROCESO AGREGARA A TODOS LOS ALUMNOS PROMIVIDOS Y NO RETIRADOIS EL AÑO ANTERIOR¡¡') == false){ return; };{
				document.location="procesoMatAuto";
	}*/
	
//function Confirmacion(){
	
		/*alert(modo.value);
		}*/
			//document.location="seteaCurso.php3?caso=9"
		
			//function Confirmacion(){
				//	if(confirm('¡¡SI ELIMINA EL AÑO ESCOLAR SE PERDERAN TODOS LOS DATOS!!') == false){ return; };
					//	document.location="seteaAno.php3?caso=9"
				//	};
</script>
<?php

$qry1="SELECT tipo_regimen FROM institucion WHERE rdb=".$_INSTIT;
	$result1 =@pg_Exec($conn,$qry1);
	$fila1 = @pg_fetch_array($result1,0);
	$regimen=$fila1['tipo_regimen'];

?>

	<?php if($frmModo!="ingresar"){
		$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			//error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					//error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					//exit();
				}
			}
		}
	}
?>
	<style type="text/css">
<!--
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
	color: #FF0000;
}
.Estilo3 {font-size: 14px}
.Estilo4 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
-->
    </style>
<HEAD>
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtANO,'Ingresar AÑO.')){
					return false;
				};
				
				if(!chkSelect(form.cmbREGIMEN,'Debe Seleccionar Régimen.')){
					return false;
				};

				if(!nroOnly(form.txtANO,'Se permiten sólo números en el AÑO.')){
					return false;
				};

				if(!chkVacio(form.txtFECHAINI,'Ingresar FECHA INICIO.')){
					return false;
				};

				if(!chkFecha(form.txtFECHAINI,'Fecha Inicio inválida.')){
					return false;
				};

				if(!chkVacio(form.txtFECHATER,'Ingresar FECHA TERMINO.')){
					return false;
				};
				
				if(!chkFecha(form.txtFECHATER,'Fecha Término inválida.')){
					return false;
				};

				if(!chkFecha(form.txtFECHATER,'Fecha Término inválida.')){
					return false;
				};
				
				//VALIDACION INTERVALO DE FECHAS
				if(amd(form.txtFECHAINI.value)>=amd(form.txtFECHATER.value)){
					alert("Fecha de término no puede ser mayor o igual a la Fecha de inicio");
					return false;
				}

				return true;
			}
		</SCRIPT>
<?php }?>
	</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="20%" height="363" align="left" valign="top"> 
                        <?
						 $menu_lateral=3;
						 include("../../../../menus/menu_lateral.php");
						 ?>						</td>
                      <td width="80%" align="left" valign="top"><table width="100%" height="200" border="1" cellpadding="2" cellspacing="3">
                        <tr>
                          <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="31" height="40" valign="middle"><img src="images/config_reportes.jpg" width="31" height="27"></td>
                              <td valign="middle"> <span class="Estilo2">&nbsp;<span class="Estilo3">CONFIGURACION DE REPORTES </span></span></td>
                            </tr>
                            <tr>
                              <td colspan="2" background="images/cuadro_rojo_chico.jpg"><img src="images/cuadro_rojo_chico.jpg" width="1" height="1"></td>
                              </tr>
                          </table>
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="4">
                              <tr>
                                <td width="50%" height="200" valign="top" bgcolor="f1f3f5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td height="23" valign="middle" background="images/fondo_superior.jpg"><span class="Estilo4">&nbsp;&nbsp;REPORTES</span></td>
                                  </tr>
                                  <tr>
                                    <td>
									<?
									/// para sacar las categorias de los informes
									$sql_cat_inf = "select * from categoria_reportes order by id";
									$res_cat_inf = @pg_Exec($conn,$sql_cat_inf);
									$num_cat_inf = @pg_numrows($res_cat_inf);
									
									for ($i=0; $i < $num_cat_inf; $i++){
									     $fil_cat_inf = @pg_fetch_array($res_cat_inf,$i);
										 $nombre_categoria = $fil_cat_inf['nombre'];
										 ?>								
									  
										 <table width="100%" border="0" cellspacing="0" cellpadding="1">
										  <tr>
											<td colspan="3" bgcolor="F9F9F9">&nbsp; <?=$nombre_categoria ?></td>
											</tr>
										  <tr>
											<td width="2%" valign="middle"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">10</font></div></td>
											<td width="2%" valign="middle"><div align="center">
											  <label>
											  <input name="radiobutton" type="radio" value="radiobutton">
											  </label>
											</div></td>
											<td width="96%" valign="middle"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">NDNDNDNDNDNDND NDNDND </font></td>
										  </tr>
										  <tr>
											<td width="2%" valign="middle"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">10</font></div></td>
											<td width="2%" valign="middle"><div align="center">
											  <label>
											  <input name="radiobutton" type="radio" value="radiobutton">
											  </label>
											</div></td>
											<td width="96%" valign="middle"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">NDNDNDNDNDNDND NDNDND </font></td>
										  </tr>
										  <tr>
											<td width="2%" valign="middle"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">10</font></div></td>
											<td width="2%" valign="middle"><div align="center">
											  <label>
											  <input name="radiobutton" type="radio" value="radiobutton">
											  </label>
											</div></td>
											<td width="96%" valign="middle"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">NDNDNDNDNDNDND NDNDND </font></td>
										  </tr>
										  <tr>
											<td width="2%" valign="middle"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">10</font></div></td>
											<td width="2%" valign="middle"><div align="center">
											  <label>
											  <input name="radiobutton" type="radio" value="radiobutton">
											  </label>
											</div></td>
											<td width="96%" valign="middle"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">NDNDNDNDNDNDND NDNDND </font></td>
										  </tr>
										  <tr>
											<td width="2%" valign="middle"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">10</font></div></td>
											<td width="2%" valign="middle"><div align="center">
											  <label>
											  <input name="radiobutton" type="radio" value="radiobutton">
											  </label>
											</div></td>
											<td width="96%" valign="middle"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">NDNDNDNDNDNDND NDNDND </font></td>
										  </tr>
										 </table>
									<? } ?>  
									
									
									
									</td>
                                  </tr>
                                </table></td>
                                <td width="50%" valign="top" bgcolor="f1f3f5">&nbsp;</td>
                              </tr>
                            </table></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2007 </td>
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
