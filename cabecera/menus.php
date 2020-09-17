<?php 

/*$theuri = $_SERVER['REQUEST_URI'];

if ( ($theuri =="/") or ($theuri =="/index.php") )
{
$itemis = "<img src=\"images/arrow.gif\" alt=\"arrow \"> 
<span class=\"note\"> Screen Text Here </span>";

} else {

$itemis = "<a href=\"www.yourdomain.com/index.php\">Screen Text Here </a>"; 
}
echo $itemis;
?> 
<!-- dos -->
dis
<?php

function fixmenu ($name1) {

$name2 = ucfirst($name1);

$item= "<a href=\"/$name1/\">$name2 </a>";

$theur = $_SERVER['REQUEST_URI'];

if ( ($theur =="/$name1/") or ($theur =="/$name1/index.html") ) 
{
$item= "<img src=\"/images/arrow.gif\" alt=\"arrow \">$name2";
}
return $item;
}

echo fixmenu(directoryname1) . "<br/>Screen Text If Required"; 

echo fixmenu(directoryname2) . "<br/>Different Screen Text If Required"; 

echo fixmenu(directoryname3) . "<br/>More Screen Text If Required"; */

?> 

<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="left" valign="top"> 
      <table width="810" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../periodo/listarPeriodo.php3"><img src="../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../feriado/listaFeriado.php3"><img src="../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../planEstudio/listarPlanesEstudio.php3"><img src="../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../atributos/listarTiposEnsenanza.php3"><img src="../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../botones/cursos_roll.gif" name="Image6" width="81" height="30" border="0" id="Image6"></a></td>
          <td width="81" height="30"><a href="../matricula/listarMatricula.php3"><img src="../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="periodo/listarPeriodo.php3"><img src="../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>