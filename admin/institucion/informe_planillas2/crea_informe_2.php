<?php require('../../../util/header.inc');

 $plantilla	=$_PLANTILLA;
$area		=$_AREA;
$concepto	=$_CONCEPTO;
$_POSP = 4;
$_bot = 7;
//exit;

$query_plantilla="select * from informe_plantilla where id_plantilla='$plantilla'";
$result_planilla=pg_exec($conn,$query_plantilla);
$num_planilla=pg_numrows($result_planilla);
if ($num_planilla>0){
	$row_planilla=pg_fetch_array($result_planilla);
}

if (isset($_POST['guardar'])){
	$nombre2=$_POST['nombre2'];
	
	 $largo=count($_POST['nombre2']);
	for ($i=0;$i<$largo;$i++){ 
		if ($nombre2[$i]!=""){
			 $sqlConcepto="INSERT INTO informe_concepto_eval (id_plantilla, nombre, sigla, glosa, fecha_creacion) VALUES($plantilla, '$nombre2[$i]', '$sigla[$i]', '$glosa[$i]',now ())";
			$resultConcepto=pg_Exec($conn, $sqlConcepto);
		}
	}
//header ("Location: crea_informe_2.php?ver=1");

$ver=1;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
<!--
function insRow(tabla)
{
	largo=document.getElementById(tabla).rows.length;
	var x=document.getElementById(tabla).insertRow(largo);
	var y=x.insertCell(0);
	var w=x.insertCell(1);
	var z=x.insertCell(2);
	//y.id="td"+j;
	y.innerHTML="<input name='nombre2[]' type='text'>";
	w.innerHTML="<input name='sigla[]' type='text'>";
	z.innerHTML="<input name='glosa[]' type='text'>";
}
function delRow(tabla)
{
	largo=document.getElementById(tabla).rows.length;
	largo=largo-1
	var x=document.getElementById(tabla).deleteRow(largo);
	
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<style type="text/css">
<!--
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
.Estilo11 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 10; }
.Estilo12 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 10px;
}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../cabecera/menu_superior.php");?>
					</td></tr></table>
					
					</td>
                  
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><?
					  $menu_lateral = 2;
						 include("../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
					  <tr>
					    <td class="fondo"><span class="Estilo5">2do.- Crear Conceptos evaluativos</span> (<? echo $row_planilla['nombre'];?>) </td>
					  </tr>
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top">
							<table width="95%"><tr><td><? if ($plantilla){?>
                                 <? if (!$ver){?>
								 <input name="agrega" type="button" value="Agregar" class="botonXX" onClick="insRow('mytable')">
 								 <input name="elimina" type="button" value="Eliminar" class="botonXX" onClick="delRow('mytable')"> <form method="post" action="crea_informe_2.php">
                                  <table width="95%" >
                                   
                                      <tr>
                                        <td width="33%" class="Estilo5"><span class="Estilo11">Nombre</span></td>
                                        <td width="33%" class="Estilo5"><span class="Estilo11">Sigla</span></td>
                                        <td width="33%" class="Estilo5"><span class="Estilo11">Glosa</span></td>
                                      </tr>
                                      <tr>
                                        <td colspan="3"><table id="mytable" width="100%">
                                        </table></td>
                                      </tr>
                                      <tr>
                                        <td colspan="3">
											<input name="guardar" type="submit" class="botonXX" value="Guardar">
											<input name="sin_concep" type="button" class="botonXX" onClick="MM_goToURL('parent','crea_informe_3.php');return document.MM_returnValue" value="Sin Conceptos" ></td>
                                      </tr>
                                   
                              </table> </form>
                                  <? }?>
                                  <? if ($ver){?>
                                  <table width="1%" align="center">
                                    <tr>
                                      <td width="33%"><span class="Estilo5">Nombre</span></td>
                                      <td width="33%"><span class="Estilo5">Sigla</span></td>
                                      <td width="33%"><span class="Estilo5">Glosa</span></td>
                                    </tr>
                                    <? 
			$query_todos="SELECT * FROM informe_concepto_eval where id_plantilla='$plantilla'";
			$result_todos=pg_exec($conn,$query_todos);
			$num_todos=pg_numrows($result_todos);
			?>
                                    <? for ($i=0;$i<$num_todos;$i++){
			$row_todos=pg_fetch_array ($result_todos);?>
                                    <tr>
                                      <td class="cuadro01"><? echo $row_todos['nombre'];?></td>
                                      <td class="cuadro01"><? echo $row_todos['sigla'];?></td>
                                      <td class="cuadro01"><? echo $row_todos['glosa'];?></td>
                                    </tr>
                                    <? }?>
                                    <form action="crea_informe_3.php" >
                                      <tr>
                                        <td colspan="3" align="center"><input name="aa" type="submit" value="Siguiente" class="botonXX" style="width:200px "></td>
                                      </tr>
                                    </form>
                                  </table>
                                  <? }?>
                                  <? }?>
                                  <? if (!$plantilla){?>
ingrese los datos en el paso uno
<? }?>
</td>
							</tr></table></td>

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
