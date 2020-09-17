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
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*$sql = "SELECT id_dignos,nombre,tipo FROM diagnostico WHERE rdb=".$institucion;
	$rs_diag = @pg_exec($conn,$sql);*/
	
	$ob_motor = new MotorBusqueda();
$ob_motor ->ano =$ano;
$result_curso = $ob_motor ->curso($conn);

$result_peri = $ob_motor ->periodo($conn);
	
	$ob_reporte->rdb=$institucion;
	
	$rs_anio = $ob_reporte->AnoInstitucionCerrado($conn);
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">

function enviapag(form){
	if (form.cmbENS.value!=0){
		form.cmbENS.target="self";
		form.target="_blank";
		form.action = 'printInformeAsistenciaRangoAnos.php';
		form.submit(true);
	}	
}

function enviapag2(form){
        if( form.c_curso.value!=0 || form.cmb_periodos.value!=0){
                form.target="_blank";
                document.form.action = 'printInformeNotasParciales_C.php?xls=1';
                document.form.submit(true);
        }
}

function cargaRamos(){
	var ense = $('#cmbENS').val();
	var anodesde = $('#anodesde').val();
	var anohasta = $('#anohasta').val();
	//alert (ense);
	
	$.ajax({
				url:"cargaSubEnse.php",
				data:"anodesde="+anodesde+"&anohasta="+anohasta+"&rdb=<?php echo $institucion ?>&tipo="+ense+"&carga=2",
				type:'POST',
				success:function(data){
				$('#dramo').html(data) ;
		  }
		});  
	
}

function cargaEnsenanza(){
	var anodesde = $('#anodesde').val();
	var anohasta = $('#anohasta').val();
	var ndesde = $('#anodesde option:selected').text();
	var nasta = $('#anohasta option:selected').text();
	//alert (ndesde);
	
	if(anodesde == 0  && anohasta==0){
		alert('Años deben ser distintos de 0');
	}
	else if(ndesde > nasta)
	{
		alert('Años desde desde ser menor que año hasta');
	}
	
	else{
	
	$.ajax({
				url:"cargaSubEnse.php",
				data:"anodesde="+anodesde+"&anohasta="+anohasta+"&rdb=<?php echo $institucion ?>&carga=1",
				type:'POST',
				success:function(data){
				$('#ens').html(data) ;
		  }
		});  
	}
}
	
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
                                <input name="nombre" type="hidden" value="<?=$nombre;?>">
                                <input name="numero" type="hidden" value="<?=$numero;?>">
                                <center>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><table width="100%" height="43" border="1" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
                                          </tr>
                                          <tr>
                                            <td height="27"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                  <td align="right" class="cuadro01"><div align="right">A&ntilde;os acad&eacute;micos</div></td>
                                                  <td class="cuadro01">Desde
                                                    <label for="anodesde"></label>
                                                    <select name="anodesde" id="anodesde" onChange="cargaEnsenanza();">
<option value="0">Seleccione</option>
<?php 
for($i=0;$i<pg_num_rows($rs_anio);$i++){
	$fil_anio = pg_fetch_array($rs_anio,$i);
?>
<option value="<?php echo $fil_anio['id_ano'] ?>"><?php echo $fil_anio['nro_ano'] ?></option>
  <?php }?>                                          
                                                    </select> 
                                                    Hasta
                                                    <label for="anohasta"></label>
                                                    <select name="anohasta" id="anohasta" onChange="cargaEnsenanza()">
<option value="0">Seleccione</option>
<?php 
for($i=0;$i<pg_num_rows($rs_anio);$i++){
	$fil_anio = pg_fetch_array($rs_anio,$i);
?>
<option value="<?php echo $fil_anio['id_ano'] ?>"><?php echo $fil_anio['nro_ano'] ?></option>
  <?php }?>    
</select></td>
                                                </tr>
                                                <tr>
                                                  <td width="35%" class="cuadro01"><div align="right">Tipo Ense&ntilde;anza</div></td>
                                                  <td class="cuadro01" valign="middle"><div id="ens"></div></td>
                                                  </tr>
                                                <tr>
                                                  <td colspan="2" align="left" class="cuadro01"><div align="left"> * (S&oacute;lo a&ntilde;os cerrados)</div></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro01">&nbsp;</td>
                                                  <td class="cuadro01">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                  <td colspan="2" class="cuadro01"><div align="center">
                                                    <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" value="Buscar" onClick="enviapag(this.form);">
                                                    
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
              <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
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