<?
require('../../../util/header.inc');
require('../../../util/LlenarCombo.php3');
require('../../../util/SeleccionaCombo.inc');

$_POSP = 3;

function Estado ($id_estado,$nombre){
		switch ($id_estado){
			case 2:
				echo "<font face='Geneva, Arial, Helvetica, sans-serif' size='1' color='red'>" . $nombre."</font>";
				break;
			case 3:
				echo "<font face='Geneva, Arial, Helvetica, sans-serif' size='1' color='green'>" . $nombre . "</font>";
				break;
			case 4:
				echo "<font face='Geneva, Arial, Helvetica, sans-serif' size='1' color='blue'>" . $nombre ."</font>";
				break;
					}
	}
	
	if ($_PERFIL != 0){
	
	    $qry = "SELECT soporte.*, estado.nombre, tipo_problema.nombre as problema FROM soporte inner join estado on soporte.id_estado=estado.id_estado INNER JOIN tipo_problema ON soporte.id_problema=tipo_problema.id_problema WHERE rbd = '".$_INSTIT."' "; 
		if (($txtDesde!="")&& ($txtHasta!="")&&($cmbESTADO!=0)){
			$qry =$qry . " fecha>=to_date('" . $txtDesde . "','DD MM YYYY') and fecha<=to_date('" . $txtHasta . "','DD MM YYYY') AND soporte.id_estado=" . $cmbESTADO . " ORDER BY fecha ASC";
		}
		if (($txtDesde=="")&& ($txtHasta=="")&&($cmbESTADO!=0)){
			$qry = $qry . "soporte.id_estado=" . $cmbESTADO . " ORDER BY fecha ASC";
		}
		if (($txtDesde!="")&& ($txtHasta!="")&&($cmbESTADO==0)){
			$qry =$qry . " fecha>=to_date('" . $txtDesde . "','DD MM YYYY') and fecha<=to_date('" . $txtHasta . "','DD MM YYYY') ORDER BY fecha ASC";
		}
	    $Rs_Soporte = @pg_exec($conn,$qry);
	
	
	}else{

	    $qry = "SELECT soporte.*, estado.nombre, tipo_problema.nombre as problema FROM soporte inner join estado on soporte.id_estado=estado.id_estado INNER JOIN tipo_problema ON soporte.id_problema=tipo_problema.id_problema WHERE "; 
		if (($txtDesde!="")&& ($txtHasta!="")&&($cmbESTADO!=0)){
			$qry =$qry . " fecha>=to_date('" . $txtDesde . "','DD MM YYYY') and fecha<=to_date('" . $txtHasta . "','DD MM YYYY') AND soporte.id_estado=" . $cmbESTADO . " ORDER BY fecha ASC";
		}
		if (($txtDesde=="")&& ($txtHasta=="")&&($cmbESTADO!=0)){
			$qry = $qry . "soporte.id_estado=" . $cmbESTADO . " ORDER BY fecha ASC";
		}
		if (($txtDesde!="")&& ($txtHasta!="")&&($cmbESTADO==0)){
			$qry =$qry . " fecha>=to_date('" . $txtDesde . "','DD MM YYYY') and fecha<=to_date('" . $txtHasta . "','DD MM YYYY') ORDER BY fecha ASC";
		}
	    $Rs_Soporte = @pg_exec($conn,$qry);
	
	}
	
	


	
			
?>
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
<SCRIPT language="JavaScript">
		function valida(form){
			if (form.txtDesde.value!=""){
			
				if(!chkFecha(form.txtDesde,'Fecha Inicio inválida.')){
					return false;
				};
				if(!chkVacio(form.txtHasta,'Ingresar FECHA TERMINO.')){
					return false;
				};
				if(!chkFecha(form.txtHasta,'Fecha Término inválida.')){
					return false;
				};
				if(amd(form.txtDesde.value)>=amd(form.txtHasta.value)){
					alert("Fecha de término no puede ser menor o igual a la Fecha de inicio");
					return false;
				}
				
			}
			if(form.txtHasta.value!=""){
				if(!chkVacio(form.txtDesde,'Ingresar FECHA INICIO.')){
					return false;
				};
				if(!chkFecha(form.txtDesde,'Fecha Inicio inválida.')){
					return false;
				};
				if(!chkFecha(form.txtHasta,'Fecha Término inválida.')){
					return false;
				};
				//VALIDACION INTERVALO DE FECHAS
				if(amd(form.txtDesde.value)>=amd(form.txtHasta.value)){
					alert("Fecha de término no puede ser menor o igual a la Fecha de inicio");
					return false;
				}
			}
			return true;
		}
			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../Sea/cortes/b_ayuda_r.jpg','../../../Sea/cortes/b_info_r.jpg','../../../Sea/cortes/b_mapa_r.jpg','../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="19"><!--inicio codigo antiguo -->
                                    <table width="607" height="421" border="1">
                                      <tr>
                                        <td height="362" valign="top"><!-- inicio listado sporte -->
                                          <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="tableindex"> 
    <td colspan="6"> <div align="center">
      <table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td class="tableindex">LISTADO DE SOPORTE</td>
          <td><div align="right">
		  <input name="nuevo" type="button" value="NUEVO"  onclick="window.location = '../../../solicitud2/index.php?nuevo=1';"/></div></td>
        </tr>
      </table>
      </div></td>
  </tr>
  <tr class="tablatit2-1"> 
    <td>RBD</td>
    <td>COLEGIO</td>
    <td>FECHA</td>
	<td>HORA</td>
    <td>TIPO PROBLEMA</td>
    <td>ESTADO</td>
  
  </tr>
  <? if(@pg_numrows($Rs_Soporte)!=0){
  		for($i=0;$i<@pg_numrows($Rs_Soporte);$i++){
			$fila = @pg_fetch_array($Rs_Soporte,$i);
			$qry = "SELECT nombre_instit, rdb FROM institucion WHERE rdb =". $fila['rbd'];
			$Rs_Instit = @pg_exec($conn,$qry);
			$fils = @pg_fetch_array($Rs_Instit,0);
			
  ?>
  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaSoporte.php3?soporte=<?php echo $fila["id_soporte"];?>&caso=3')>						
    <td><font face="arial, geneva, helvetica" size="1">&nbsp;<? echo $fils['rdb'];?></font></td>
    <td><font face="arial, geneva, helvetica" size="1">&nbsp;<? echo substr($fils['nombre_instit'],0,30);?></font></td>
    <td><font size="1" face="arial, geneva, helvetica">&nbsp;<? impF($fila['fecha']);?></font>&nbsp;</td>
    <td><font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $fila['hora'];?></font></td>
    <td><font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $fila['problema'];?></font></td>
	<td><font size="1" face="arial, geneva, helvetica">&nbsp;<? ESTADO($fila['id_estado'],$fila['nombre']);?></font></td>
 </tr>
  <? } // fin for
  }else{?>
  <tr>
  	<td colspan="5" class="cuadro01"><div align="center">No se registran solicitudes </div></td>
  </tr>
  <? } ?>
</table>


										
										
									</td><!-- fin listado soporte -->
                                      </tr>
                                      <tr><!-- inicio motor de soporte -->
                                        <td height="51">
										
										
										
										
										
										
										<!-- inicio motor de soporte -->
	<? $institucion	=$_INSTIT;
	$qry = "";
	$qry = "SELECT * FROM estado ";
	$Rs_Soporte = pg_exec($conn,$qry);			?>						
										

<form method "post" action="main_soporte.php3" target="_self">
<center>
<table width="709" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="1" cellpadding="0" cellspacing="0">
            <tr>
              <td width="701" class="tableindex"><div align="center">Buscador 
                  Avanzado </div></td>
  </tr>
  <tr>
    <td height="27">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="80"><font size="1" face="arial, geneva, helvetica">Fecha desde</font></td>
                    <td width="94" class="text_9_x_100"><input name="txtDesde" type="text" size="15" maxlength="10"></td>
                    <td width="19"><font size="1" face="arial, geneva, helvetica">&nbsp;</font></td>
                    <td width="82"><font size="1" face="arial, geneva, helvetica">Fecha Hasta</font></td>
                    <td width="133"><font size="1" face="arial, geneva, helvetica"><input name="txtHasta" type="text" size="15" maxlength="10"></font></td>
                    <td width="43"><font size="1" face="arial, geneva, helvetica">Estado</font></td>
                    <td width="167" >&nbsp; <select name="cmbESTADO">
                        <option value=0 selected>Selecione Estado </option>
                        <? for($i=0 ; $i < @pg_numrows($Rs_Soporte) ; $i++){
							$fila = @pg_fetch_array($Rs_Soporte,$i);
						if ($fila["id_estado"]==$cmbESTADO){
							echo  "<option selected value=".$fila["id_estado"]." >".$fila["nombre"]."</option>";
						}else{
							echo  "<option value=".$fila["id_estado"]." >".$fila["nombre"]."</option>";
						}
									
				}
			?>
                      </select> </td>
                    <td width="83"><div align="right"> 
                        <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar" onClick="return valida(this.form);">
					  </div></td>
                  </tr>
                </table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>

										
										
										
										
										
							<!-- fin de motoro de soporte -->			
										
										
										
										
										
										</td>
                                      </tr>
                                    </table>
								  <!-- fin codigo antiguo --></td>
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
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
