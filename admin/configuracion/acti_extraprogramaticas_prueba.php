<?
require('../../util/header.inc');
require_once("../../agenda/includes/widgets/widgets_start.php");


$institucion	=$_INSTIT;
$ano			=$_ANO;
$_POSP = 2;
$_bot = 0;
$_MDINAMICO = 1;
$perfil = $_PERFIL; 
	
$usuarioensesion = $_USUARIOENSESION;

// tomo los cursos de esta institucion
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = @pg_Exec($conn,$sql_curso);



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
<script language="JavaScript" src="../../agenda/includes/widgets/calendar.js"></script>
<script language="JavaScript" src="../../agenda/includes/widgets/calendar-setup.js"></script>
<script language="JavaScript" src="../../agenda/includes/widgets/lang/calendar-es.js"></script>
<SCRIPT type="text/javascript" src="../../estadisticas/js/mootools.js"></SCRIPT>
<SCRIPT type="text/javascript" src="../../estadisticas/js/moodalbox.js"></SCRIPT>
<link rel="stylesheet" type="text/css" media="all" href="../../agenda/includes/widgets/calendar-brown.css" title="green"/>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr align="left" valign="top">
              <td height="75" valign="top"><?
			         include("../cabecera/menu_superior.php");
			        ?>
              </td>
            </tr>
          </table>
     
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="362" align="left" valign="top"><!-- AQUI INSERTO EL MENÚ DINÁMICO -->
                  <?
						include("../menus/menu_lateral.php");
						?>
              </td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#999999">
                        <tr align="center" valign="top">
                          <td height="162" align="center"><table width="100%">
                              <tr>
                                <td class="tableindex"><div align="center">INGRESO DE INFORMACION A LA AGENDA DIARIA</div></td>
                              </tr>
                            </table>
                              <br>
                              <form action="ing_agenda.php" method="post" enctype="multipart/form-data" name="form1">
                                <table width="80%" border="0" align="center" cellpadding="0" cellspacing="5">
                                  <tr>
                                    <td class="cuadro02">Fecha Inicio</td>
                                    <td class="cuadro01"><input name="fecha_inicio" type="widget" id="fecha_inicio" size="12" maxlength="10"  subtype="wcalendar" format="%Y-%m-%d" skin="blue" language="es" label="..." mondayfirst="true" singleclick="true"  readonly="true"  value="<? echo trim(date("Y-m-d"));?>	"/>        
                                      <label>
								  <input type="button" id="txtFecha" class="botadd" value="Cal.">
								  <script type="text/javascript">
									Calendar.setup({
										inputField     :    "fecha_inicio",      // id of the input field
										ifFormat       :    "%Y-%m-%d",  // format of the input field (even if hidden, this format will be honored)
										button         :    "txtFecha",  // trigger button (well, IMG in our case)
										align          :    "Bl",           // alignment (defaults to "Bl")
										singleClick    :    true,
										mondayFirst	   :    true
									});
									</script>
                                      </label>                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro02">Fecha Caduca</td>
                                    <td class="cuadro01"><input name="fecha_caduca" type="widget" class="texto" id="fecha_caduca" size="12" maxlength="10"  subtype="wcalendar" format="%Y-%m-%d" skin="blue" language="es" label="..." mondayfirst="true" singleclick="true"   readonly="true"/>
									<label>
								  <input type="button" id="txtFecha2" class="botadd" value="Cal.">
								  <script type="text/javascript">
									Calendar.setup({
										inputField     :    "fecha_caduca",      // id of the input field
										ifFormat       :    "%Y-%m-%d",  // format of the input field (even if hidden, this format will be honored)
										button         :    "txtFecha2",  // trigger button (well, IMG in our case)
										align          :    "Bl",           // alignment (defaults to "Bl")
										singleClick    :    true,
										mondayFirst	   :    true
									});
									</script>
                                      </label> 
									
									</td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro02">Publicar para</td>
                                    <td class="cuadro01"><select name="cmb_curso"  class="ddlb_9_x">
                                        <option value="0" selected>TODOS LOS CURSOS</option>
                                        <?
		                                               for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		                                                   {
		                                                   $fila = @pg_fetch_array($resultado_query_cue,$i); 
		                                                   if ($fila["id_curso"]==$cmb_curso){
  				                                               $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				                                               echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		                                                   }else{
  				                                               $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				                                               echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		                                                   }
                                                       }
													   ?>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro02">T&iacute;tulo</td>
                                    <td class="cuadro01"><input name="titulo" type="text" id="titulo" size="40"></td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro02">Detalle</td>
                                    <td class="cuadro01"><textarea name="detalle" cols="35" rows="5" id="detalle"></textarea></td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro02">Archivo Adjunto</td>
                                    <td class="cuadro01"><label>
                                      <input type="file" name="file">
                                    </label></td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro02">Subir imagen</td>
                                    <td class="cuadro01"><label>
                                      <input name="imagen" type="file" id="imagen">
                                    </label></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" class="cuadro01"><div align="center">
                                        <input name="b1" type="submit" id="b1" value="Publicar" class="botonXX">
                                        <input name="b2" type="button" id="b2"  class="botonXX" onClick="MM_callJS('history.go(-1)')" value="Volver">
                                    </div></td>
                                  </tr>
                                </table>
                            </form></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr align="center" valign="middle">
              <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
  </tr>
      </table>
</td>
  </tr>
</table>
</body>
</html>
<? require_once("../../agenda/includes/widgets/widgets_end.php");?>