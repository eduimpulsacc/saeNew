<?
require('../../../../../../util/header.inc');
include('../../../../../clases/class_MotorBusqueda.php');
//include('../../../../../clases/class_Membrete.php');
//include('../../../../../clases/class_Reporte.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno 		=$c_alumno;
	$reporte		=$c_reporte;
	$_POSP = 6;
	$_bot = 8;

?>
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script language="javascript" type="text/javascript">

$( document ).ready(function() {
    tpe(1);
});

function act(){
	var tipo = $('input[name=tipo]:checked').val();
	var frm = $('input[name=trepo]:checked').val();
	
	/*if(tipo==1 && frm==1){
	var ruta ="repitenciaCurso/printrepitenciaCurso.php";
	}
	if(tipo==1 && frm==2){
	var ruta ="repitenciaCurso/graficorepitenciaCurso.php";
		
	}
	if(tipo==2 && frm==1){
	//var ruta ="repitenciaCiclo/printrepitenciaCiclo.php";
	var ruta ="repitenciaCurso/printrepitenciaCurso.php";
	}
	if(tipo==2 && frm==2){
	var ruta ="repitenciaCiclo/graficorepitenciaCiclo.php";
	}
	*/
	var ruta ="repitenciaCurso/printrepitenciaCurso.php";
	document.form.action=ruta;
	document.form.submit(); 
}

function tpe(tipo){
if(tipo==1){
	$('tr[id^="yy"]').show();
	
	}
else{
$('tr[id^="yy"]').hide();
}

}

</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"><?
				include("../../../../../../cabecera/menu_superior.php");
				?>                </td>
              </tr>
          </table></td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><?
						$menu_lateral=3;
						include("../../../../../../menus/menu_lateral.php");
						?>              </td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="395" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                        <tr>
                          <td><br>
                              <!-- INCLUYO CODIGO DE LOS BOTONES -->
                              <table height="0" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td height="0" align="center" valign="top">
                                  </table>
                            <form method="post" action="" name="form" target="_blank"> 
							<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
                            <input name="nombre" type="hidden" value="<?=$nombre;?>">
                            <input name="numero" type="hidden" value="<?=$numero;?>">
                                <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="705"><table height="43" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                          <td width="701" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
                                        </tr>
                                        <tr>
                                          <td height="27"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                              
                                              <tr>
                                                <td class="cuadro01"><div align="left">Buscar por 
                                                  </div></td>
                                                <td class="cuadro01"><input name="tipo" type="radio" id="tipo"  value="1" checked="CHECKED" onChange="tpe(1)">
Tipo de ense&ntilde;anza
  <input type="radio" name="tipo" id="tipo" value="2" onChange="tpe(2)" >
Ciclo </td>
                                              </tr>
                                              <tr id="yy" style="display:none">
                                                <td class="cuadro01" id="yy1" >Tipo de Ense&ntilde;anza</td>
                                                <td class="cuadro01" id="yy2" >
                                                <?php  $sqlte="select distinct e.cod_tipo,e.nombre_tipo
														 from tipo_ensenanza e
														 inner join curso c on c.ensenanza = e.cod_tipo
														 where c.id_ano = ".$_ANO." and e.cod_tipo>10 
														 order by e.cod_tipo";
														  $resulte = pg_Exec($conn,$sqlte);?>
                                                <select name="tense" id="tense">
                                                <option value="0">Seleccione</option>
                                               <?php  for($t=0;$t<pg_numrows($resulte);$t++){
												   $filat=pg_fetch_array($resulte,$t);?>
                                                <option value="<?php echo $filat['cod_tipo'] ?>"><?php echo $filat['nombre_tipo'] ?></option>
                                                <?php }?>
                                                </select></td>
                                              </tr>
                                              <tr>
                                                <td class="cuadro01">Promoci&oacute;n realizada </td>
                                                <td class="cuadro01"><input type="radio" name="finalp" id="finalp" value="1"  checked="">
                                                  SI
                                                  <input type="radio" name="finalp" id="finalp" value="2">
                                                  NO </td>
                                              </tr>
                                              <tr>
                                                <td class="cuadro01">Tipo de riesgo                                                  </td>
                                                <td class="cuadro01"><input type="radio" name="filtrapor" id="finalp2" value="1"  checked="">
Notas
  <input type="radio" name="filtrapor" id="filtrapor" value="2">
Asistencia
<input type="radio" name="filtrapor" id="filtrapor" value="3"> 
Ambos
</td>
                                              </tr>
                                              <tr>
                                                <td class="cuadro01">Unidad Medida</td>
                                                <td class="cuadro01"><input type="radio" name="cant" id="cant" value="1"  checked="">
Cantidad
  <input type="radio" name="cant" id="cant" value="2"> 
  Porcentaje
</td>
                                              </tr>
                                              <tr>
                                                <td class="cuadro01">Tipo de reporte                                                  </td>
                                                <td class="cuadro01"><input name="trepo" type="radio" id="trepo"  value="1" checked="CHECKED">
Listado
  <input type="radio" name="trepo" id="trepo" value="2">
Gr&aacute;fico</td>
                                              </tr>
                                              <tr>
                                                <td colspan="2" class="cuadro01">&nbsp;</td>
                                              </tr>
                                              <!--<tr>
                                                <td colspan="2" class="cuadro01">Nota: Informe requiere tener promoci&oacute;n realizada</td>
                                              </tr>-->
                                              <tr>
                                                <td colspan="2" align="center" class="cuadro01"><input name="cb_ok" type="button" class="botonXX"  id="cb_ok" value="Buscar" onClick="act()">
                                                  <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver"onClick="window.location='../../Menu_Reportes_new2.php'"></td>
                                              </tr>
                                              <tr>
                                                <td width="141" class="textosmediano">&nbsp;</td>
                                                <td width="322">&nbsp;</td>
                                              </tr>
                                          </table></td>
                                        </tr>
                                    </table></td>
                                  </tr>
                                </table>
                            </form>
                            <!-- FIN FORMULARIO DE BUSQUEDA -->                          </td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr align="center" valign="middle">
              <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
   </tr>
      </table>
 </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>