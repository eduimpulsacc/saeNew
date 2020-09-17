<html>
<head><title>Editor</title></head>
<script type='text/javascript' src='/org-img/jsapi/HTMLeditorMainLib-1.2.js'></script>

<body>
<!-- INICIO EDITOR NUEVO -->

<table width="748" height="37" border="0" cellpadding="0" cellspacing="0" background="/org-img/vender06/editor/nuevo/bg_sup.gif" id="HTMLEDIT">
<tr>
<td><table border="0" cellpadding="0" cellspacing="0">
<tr>
<td colspan="5" height="9"></td>
</tr>
<tr>
<td width="18"></td>
<td width="160">
<table width="160" border="0" cellpadding="0" cellspacing="0">
<tr><td><select name="select" style="width:100px;color:#2c2b33;font-size:11px;" id="fontstyle"  onChange="changeFont();" title="Tipo de Letra">
<option selected>Arial</option><option>Arial Black</option><option>Times New Roman</option><option>Courier New</option>
<option>Verdana</option><option>Garamond</option>
</select></td>
<td width="10"></td>
<td><select name="select" style="width:45px;color:#2c2b33;font-size:11px;" id="fontsize" onChange="changeSize();" title="Tamaño de Letra">
<option>1</option>
<option>2</option>
<option selected>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
</select></td></tr></table></td>
<td width="12"></td>
<td align="center" background="/org-img/vender06/editor/nuevo/bg_botonera.gif" style="background-repeat:no-repeat;"><div style="position:relative; width:541px; height:22px;left: 0px; top: -27px;" id="EDIT0" align="center">
<div id="botonerasup" style="left: 0" title="Negrita" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('bold');"></div>
<div id="botonerasup" style="left: 27;" title="Itálica" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('italic');"></div>
<div style="left: 53;" id="botonerasup" title="Subrayado" onMouseDown="this.className='tariel2';buttonPress('underline');" onMouseUp="this.className='tariel';" onMouseOver="this.className='tariel';" onMouseOut="this.className='';"></div>
<div style="left: 92;" id="botonerasup" title="Alinear a la Izquierda" onMouseDown="this.className='tariel2';buttonPress('justifyleft');" onMouseUp="this.className='tariel';" onMouseOver="this.className='tariel';" onMouseOut="this.className='';"></div>
<div style="left: 118;" id="botonerasup" title="Centrar" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('justifycenter');"></div>
<div style="left: 143;" id="botonerasup" title="Alinear a la Derecha" onMouseDown="this.className='tariel2';buttonPress('justifyright');" onMouseUp="this.className='tariel';" onMouseOver="this.className='tariel';" onMouseOut="this.className='';"></div>
<div style="width:30px;left: 183;" title="Color de Letra" id="botonerasup" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';"><img src="/org-img/t.gif" width="30" height="20" onClick="buttonPress('foreColorPopup');"></div>
<div style="width:30px;left: 223;" title="Color de Párrafo" id="botonerasup" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';"><img src="/org-img/t.gif" width="30" height="20" onClick="buttonPress('backColorPopup');"></div>
<div style="width:30px;left: 261;" title="Color de Fondo" id="botonerasup" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';"><img src="/org-img/t.gif" width="30" height="20" onClick="buttonPress('bodyColorPopup');"></div>
<div style="left: 308;" title="Viñetas" id="botonerasup" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('insertunorderedlist');"><img src="/org-img/t.gif" width="20" height="20"></div>
<div style="left: 335;" title="Agregar Sangría" id="botonerasup" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('indent');"><img src="/org-img/t.gif" width="20" height="20"></div>
<div style="left: 360;" title="Quitar Sangría" id="botonerasup" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('outdent');"><img src="/org-img/t.gif" width="20" height="20"></div>
<div style="left: 404;" title="Insertar Link" id="botonerasup" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('adlnk');"></div>
<div style="left: 446;" title="Crear Nuevo" id="botonerasup" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('create');"></div>
<div style="left: 470;" title="Cortar" id="EDIT1" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('cut');"></div>
<div style="left: 492;" title="Copiar" id="EDIT2" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('copy');"></div>
<div style="left: 515;" title="Pegar" id="EDIT3" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('paste');"><img src="/org-img/t.gif" width="20" height="20"></div>
<div style="position:absolute; width: 15px; top: 43px; left: 186px; z-index:2;font-size:2px; height:3px;background-color:#000000;border:1px solid #2c2b33" id="COLOR1"> </div>
<div style="position:absolute; width: 15px; top: 43px; left: 264px; z-index:2;font-size:2px; height:3px;background-color:#FFFFFF;border:1px solid #2c2b33" id="COLOR3"> </div>
<div style="position:absolute; width: 15px; top: 43px; left: 226px; z-index:2;font-size:2px; height:3px;background-color:#FEE600;border:1px solid #2c2b33" id="COLOR2"> </div>
</div></td>
<td width="2"></td>
</tr></table></td>
</tr>
</table>
<table width="748" border="0" cellpadding="0" cellspacing="0" bgcolor="#F4F3F0">
<tr>
<td width="1" bgcolor="#999999"></td>
<td width="746" height="500" align="center" valign="top"><table width="746" border="0" cellpadding="0" cellspacing="0">
<tr>
<td></td>
<td height="1" bgcolor="#999999"></td>
<td></td>
</tr>
<tr>
<td width="5"></td>
<td width="737" height="27" background="/org-img/vender06/editor/nuevo/bg_inf.gif" bgcolor="#e6e6e6"><div style="position:relative; width:715px; height:22px;left: 10px; top: -47px;">
<div style="left:0" title="Elegir Diseño" id="botonerainf" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('designs');"></div>
<div style="left:105;" title="Elegir Estructura" id="botonerainf" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('layouts');"></div>
<div style="left:215;" title="Tus Fotos" id="botonerainf" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('pictures');"></div>
<div style="left:322;" title="Tus Links" id="botonerainf" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('links');"></div>
<div style="left:435;" title="Variables" id="botonerainf" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('vars');"></div>
<div style="left:550;" title="Plantillas" id="botonerainf" onMouseOver="this.className='tariel';" onMouseOut="this.className='';" onMouseUp="this.className='tariel';" onMouseDown="this.className='tariel2';buttonPress('plants');"></div>
<div style="top:48;left: 654; width:20; height:20" title="Abrir Plantilla" id="botonerainf" onMouseDown="this.className='tariel2';buttonPress('tempopener');" onMouseUp="this.className='tariel';" onMouseOver="this.className='tariel';" onMouseOut="this.className='';"></div>
<div style="top:48;left: 686; width:20; height:20" title="Guardar Plantilla" id="botonerainf" onMouseDown="this.className='tariel2';buttonPress('save');" onMouseUp="this.className='tariel';" onMouseOver="this.className='tariel';" onMouseOut="this.className='';"></div>
</div></td>
<td width="4"></td>
</tr>
</table>
<table width="734" border="0" cellpadding="0" cellspacing="0">
<tr><td height="8"></td></tr>
<tr>
<td height="19" id="SOLAPAS" background="/org-img/vender06/editor/nuevo/solapas.gif">
<div style="position:relative; width:734px;left:0;top:0;" id="TABS">
<div style="left:485px;" title="Diseño" id="imgEdit" onClick="setMode(this.id)"></div>
<div style="left:569px;" title="Vista Previa" id="imgPrev" onClick="setMode(this.id)"></div>
<div style="left:652px;" title="Código HTML" id="imgHtml" onClick="setMode(this.id)"></div>
</div></td></tr></table>
<table width="734" border="0" cellpadding="0" cellspacing="0">
<tr><td width="1" bgcolor="#999999"></td>
<td height="440" align="center" valign="top" bgcolor="#FFFFFF"><iframe name=editCtl id=editCtl width=732 height="440" marginwidth=0 marginheight=0 frameborder="0" onFocus="closeAllPopups()" onBeforeDeactivate='editActivated=true' onActivate='editActivated=false' style="cursor:text;"></iframe></td>
<td width="1" bgcolor="#999999"></td></tr>
<tr><td height="1" colspan="3" bgcolor="#999999"></td></tr></table></td><td width="1" bgcolor="#999999"></td></tr>
<tr><td bgcolor="#999999" colspan="3" height="1"></td></tr>
</table>

<!-- FIN EDITOR NUEVO -->
</body>
</html>
