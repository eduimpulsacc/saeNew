<?
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_MotorBusqueda.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno 		=$c_alumno;
	$reporte		=$c_reporte;
	$_POSP = 6;
	$_bot = 8;
	
	
	//$ob_membrete = new Membrete();
	
	/*$sql = "SELECT id_dignos,nombre,tipo FROM diagnostico WHERE rdb=".$institucion;
	$rs_diag = @pg_exec($conn,$sql);
	*/
	$ob_motor = new MotorBusqueda();
$ob_motor ->ano =$ano;
$result_curso = $ob_motor ->curso($conn);

$result_peri = $ob_motor ->periodo($conn);
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">



function enviapag2(form){
        if( form.c_curso.value!=0 || form.cmb_periodos.value!=0){
                form.target="_blank";
                document.form.action = 'printInformeNotasParciales_C.php?xls=1';
                document.form.submit(true);
        }
}

function cargaRamos(){
	var ense = $('#cmbENS').val();
	//alert (ense);
	
	$.ajax({
				url:"../../cargaSubEnse.php",
				data:"tipo="+ense+"&ano=<?php echo $ano ?>",
				type:'POST',
				success:function(data){
				$('#dramo').html(data) ;
		  }
		});  
	
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <?  include("../../../../../../cabecera/menu_superior.php");  ?>
            <!-- FIN DE COPIA DE CABECERA -->        </td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><!-- AQUI VA EL MEN{U LATERAL -->
                  <?
						 $menu_lateral=3;
						 include("../../../../../../menus/menu_lateral.php");
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
                              <form method="post" action="printpromAsignatura.php" name="form" target="_blank">
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
                                                  <td width="35%" class="cuadro01"><div align="right">Tipo Ense&ntilde;anza</div></td>
                                                  <td class="cuadro01">										  <select name="cmbENS" id="cmbENS" onChange="cargaRamos();">
						<option value=0 selected>Seleccione Tipo de Enseñanza</option>
                      <?php 
					  $ob_motor->institucion = $institucion;
							$resultENS= $ob_motor->EnsenanzaNotas($conn);
								for($i=0 ; $i < @pg_numrows($resultENS) ; $i++){
									$filaENS = @pg_fetch_array($resultENS,$i);
										if ($filaENS["cod_tipo"]==$cmbENS){
											echo  "<option selected value=".$filaENS["cod_tipo"]." >".$filaENS["cod_tipo"]." - ".$filaENS["nombre_tipo"]."</option>";
										}else{
											echo  "<option value=".$filaENS["cod_tipo"]." >".$filaENS["cod_tipo"]." - ".$filaENS["nombre_tipo"]."</option>";
										}
													
								}
						?>
                    </select>
                                                     </td>
                                                  </tr>
                                                <tr>
                                                  <td class="cuadro01"><div align="right">Subsector :</div></td>
                                                  <td class="cuadro01"><div id="dramo">
 <select name="ramo" id="ramo"></select>                                                 </div></td>
                                                  </tr>
                                                <tr>
                                                  <td class="cuadro01"><div align="right">Periodo :</div></td>
                                                  <td class="cuadro01"><select name="cmb_periodos" class="ddlb_9_x">
          <option value=0 selected>(Seleccione Periodo)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_peri,$i); 
		  if ($fila['id_periodo']==$cmb_periodos)
   			echo  "<option selected value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  else
   			echo  "<option value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  ?>
          <? } 
		 
		  ?>
        </select></td>
                                                </tr>
                                                <tr>
                                                  <td rowspan="2" align="right" class="cuadro01"><div align="right">
                                                    <table width="" border="0" cellspacing="0" cellpadding="3">
                                                      <tbody>
                                                        <tr>
                                                          <td class="cuadro01">Tipo Evaluaci&oacute;n</td>
                                                        </tr>
                                                        <tr>
                                                          <td colspan="2" class="cuadro01">Formato</td>
                                                        </tr>
                                                      </tbody>
                                                    </table>
                                                    <br>
                                                  </div></td>
                                                  <td class="cuadro01"><input name="tipon" type="radio" id="tipon" value="1" checked="CHECKED">
                                                  <label for="tipon">Promedio 
                                                    <input type="radio" name="tipon" id="tipon2" value="2">
                                                  Examen 
                                                  <input type="radio" name="tipon" id="tipon3" value="3">
                                                  Apreciaci&oacute;n </label></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro01"><input name="tipor" type="radio" id="tipon4" value="1" checked="CHECKED">
                                                    <label for="tipon4">Listado
                                                      <input type="radio" name="tipor" id="tipon5" value="2">
                                                      Gr&aacute;fico</label></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro01">&nbsp;</td>
                                                  <td class="cuadro01">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                  <td colspan="2" align="right" class="cuadro01"><div align="right">
                                                    <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar" >
                                          &nbsp;&nbsp;&nbsp;          <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='../../Menu_Reportes_new2.php'">
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