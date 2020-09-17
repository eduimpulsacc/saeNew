<?
require('../../../../util/header.inc');
 
$institucion= $_INSTIT;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</head>
<script language="javascript1.1" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
</STYLE>

<body>
<div id="capa0">
<table width="650" align="center">
  <tr>
    <td><input name="button4" type="button" class="botonXX" onclick="window.close()"   value="CERRAR" /></td>
    <td align="right"><input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onclick="javascript:imprimir()" />
        <? if($_PERFIL==0){?>
        <input name="cb_exp" type="button" onclick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR" />
        <? }?>
    </td>
  </tr>
</table>
</div>
<? //for($i=1;$i<3;$i++){?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%" rowspan="4"><?
						if($institucion!=""){
							echo "<img src='../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?></td>
    <td width="67%" class="textosimple">&nbsp;</td>
    <td width="13%" class="textosimple">A&ntilde;o Escolar </td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="textosimple">N&ordm; Matricula </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita"><div align="center">FICHA DE MATRICULA </div></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" valign="top"  class="textonegrita"><p>DATOS DEL ALUMNO</p></td>
  </tr>
  <tr>
    <td width="123" valign="top"  class="textosimple">RUT</td>
    <td valign="top">&nbsp;</td>
    <td  valign="top"  class="textosimple">EDAD</td>
    <td  valign="top" class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td width="123" valign="top" class="textosimple">NOMBRE</td>
    <td valign="top">&nbsp;</td>
    <td  valign="top" class="textosimple">APE. PATERNO</td>
    <td  valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">APE. MATERNO</td>
    <td valign="top">&nbsp;</td>
    <td  valign="top" class="textosimple">F.NAC</td>
    <td  valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="123" valign="top" class="textosimple">SEXO</td>
    <td valign="top">&nbsp;</td>
    <td  valign="top" class="textosimple">NACIONALIDAD</td>
    <td  valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">HIJOS</td>
    <td valign="top">&nbsp;</td>
    <td  valign="top" class="textosimple">ESTADO CIVIL</td>
    <td  valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="123" valign="top" class="textosimple">DOMICILIO</td>
    <td colspan="5" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="123" valign="top" class="textosimple">COMUNA</td>
    <td width="173"  valign="top">&nbsp;</td>
    <td width="140" valign="top" class="textosimple">TELEFONO FIJO:</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">CELULAR</td>
    <td  valign="top">&nbsp;</td>
    <td valign="top" class="textosimple">E-MAIL</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">TRABAJA</td>
    <td  valign="top" class="textosimple"><input type="checkbox" name="checkbox" id="checkbox" />
      SI 
      <input type="checkbox" name="checkbox2" id="checkbox2" />
      NO</td>
    <td valign="top" class="textosimple">LUGAR TRABAJO</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">EMBARAZADA</td>
    <td  valign="top" class="textosimple"><input type="checkbox" name="checkbox3" id="checkbox3" />
SI
  <input type="checkbox" name="checkbox3" id="checkbox4" />
NO</td>
    <td valign="top" class="textosimple">MESES</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">ETNIA</td>
    <td  valign="top">&nbsp;</td>
    <td valign="top" class="textosimple">VIVE CON</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">ESTUDIO A&Ntilde;O ANTERIOR</td>
    <td  valign="top" class="textosimple"><input type="checkbox" name="checkbox4" id="checkbox5" />
SI
  <input type="checkbox" name="checkbox4" id="checkbox6" />
NO</td>
    <td valign="top" class="textosimple">A&Ntilde;OS REPETIDOS</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">A&Ntilde;OS RETIRADOS</td>
    <td  valign="top">&nbsp;</td>
    <td valign="top" class="textosimple">CAUSA</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">ESTUDIOS DEL PADRE</td>
    <td  valign="top">&nbsp;</td>
    <td valign="top" class="textosimple">ESTUDIOS DE LA MADRE</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td colspan="4" class="textonegrita"><p>DATOS APODERADO<br />
    </p></td>
  </tr>
  <tr>
    <td width="203" class="textosimple">NOMBRE CASO EMERGENCIA</td>
    <td width="246">&nbsp;</td>
    <td width="50" class="textosimple">FONO</td>
    <td width="123">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE APODERADO /TUTOR</td>
    <td>&nbsp;</td>
    <td class="textosimple">FONO</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">DOMICILIO</td>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td colspan="4" class="textonegrita"><p>DATOS DE SALUD</p></td>
  </tr>
  <tr>
    <td width="183" class="textosimple">PROBLEMA APRENDIZAJE</td>
    <td width="84" class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox5" id="checkbox7" />
SI
<input type="checkbox" name="checkbox5" id="checkbox8" />
NO</span></td>
    <td width="115" class="textosimple">TIPO PROBLEMA</td>
    <td width="240" class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">ENFERMEDAD CR&Oacute;NICA</td>
    <td class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox6" id="checkbox9" />
SI
<input type="checkbox" name="checkbox6" id="checkbox10" />
NO</span></td>
    <td class="textosimple">TIPO ENFERMEDAD</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">TRATAMIENTO PSICOL&Oacute;GICO</td>
    <td class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox7" id="checkbox11" />
SI
<input type="checkbox" name="checkbox7" id="checkbox12" />
NO</span></td>
    <td class="textosimple">CENTRO DE ATENCI&Oacute;N</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">POSEE DISCAPACIDAD</td>
    <td class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox8" id="checkbox13" />
SI
<input type="checkbox" name="checkbox8" id="checkbox14" />
NO</span></td>
    <td class="textosimple">TIPO</td>
    <td class="textosimple"><table width="100%" border="0">
      <tr>
        <td>VISUAL          </td>
        <td><input type="checkbox" name="checkbox9" id="checkbox15" /></td>
        <td>MOTRIZ          </td>
        <td><input type="checkbox" name="checkbox10" id="checkbox16" /></td>
      </tr>
      <tr>
        <td>TGD          </td>
        <td><input type="checkbox" name="checkbox14" id="checkbox20" /></td>
        <td>AUDITIVA          </td>
        <td><input type="checkbox" name="checkbox12" id="checkbox18" /></td>
      </tr>
       <tr>
        <td>INTELECTUAL</td>
        <td><input type="checkbox" name="checkbox11" id="checkbox17" /></td>
        <td>OTRAS          </td>
        <td><input type="checkbox" name="checkbox13" id="checkbox19" /></td>
       </tr>
    </table></td>
  </tr>
  <tr>
    <td class="textosimple">CARNET DISCAPACIDAD</td>
    <td class="textosimple"><input type="checkbox" name="checkbox15" id="checkbox21" />
SI
  <input type="checkbox" name="checkbox15" id="checkbox22" />
NO</td>
    <td class="textosimple">REQUIERE EX&Aacute;MEN DE VALIDACI&Oacute;N DE ESTUDIOS</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
</table>
<br />
<br /><H1 class=SaltoDePagina> </H1>
<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td colspan="4" class="textonegrita"><p>BENEFICIOS<br />
    </p></td>
  </tr>
  <tr>
    <td class="textosimple">PROYECTO INTEGRACI&Oacute;N</td>
    <td class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox16" id="checkbox23" />
SI
<input type="checkbox" name="checkbox16" id="checkbox24" />
NO</span></td>
    <td class="textosimple">FICHA PROTECCION SOCIAL</td>
    <td class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox17" id="checkbox25" />
SI
<input type="checkbox" name="checkbox17" id="checkbox26" />
NO</span></td>
  </tr>
  <tr>
    <td class="textosimple">BECA JUNAEB</td>
    <td class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox18" id="checkbox27" />
SI
<input type="checkbox" name="checkbox18" id="checkbox28" />
NO</span></td>
    <td class="textosimple">PROGRAMAS SOCIALES</td>
    <td><table width="100%" border="0">
      <tr>
        <td class="textosimple">CHILE CRECE CONTIGO</td>
        <td class="textosimple"><span class="textosimple">
          <input type="checkbox" name="checkbox19" id="checkbox29" />
        </span></td>
      </tr>
      <tr>
        <td class="textosimple">PROGRAMA PUENTE</td>
        <td class="textosimple"><span class="textosimple">
          <input type="checkbox" name="checkbox20" id="checkbox30" />
        </span></td>
      </tr>
      <tr>
        <td class="textosimple">CHILE SOLIDARIO</td>
        <td class="textosimple"><span class="textosimple">
          <input type="checkbox" name="checkbox21" id="checkbox31" />
        </span></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="textosimple">PROGRAMAS JUDICIALES</td>
    <td class="textosimple"><table width="100%" border="0">
      <tr>
        <td class="textosimple">SENAME</td>
        <td class="textosimple"><input type="checkbox" name="checkbox23" id="checkbox35" /></td>
      </tr>
      <tr>
        <td class="textosimple">SERNAM</td>
        <td class="textosimple"><input type="checkbox" name="checkbox23" id="checkbox36" /></td>
      </tr>
    </table></td>
    <td class="textosimple">PROGRAMAS DE SALUD</td>
    <td class="textosimple"><table width="100%" border="0">
      <tr>
        <td class="textosimple">VIOLENCIA FAMILIAR</td>
        <td class="textosimple"><input type="checkbox" name="checkbox22" id="checkbox32" /></td>
      </tr>
      <tr>
        <td class="textosimple">SALUD MENTAL</td>
        <td class="textosimple"><input type="checkbox" name="checkbox22" id="checkbox33" /></td>
      </tr>
      <tr>
        <td class="textosimple">CONSUMO DROGAS</td>
        <td class="textosimple"><input type="checkbox" name="checkbox22" id="checkbox34" /></td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<br />
<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td colspan="4" class="textonegrita"><p>DOCUMENTOS</p></td>
  </tr>
  <tr>
    <td class="textosimple">CERTIFICADO NACIMIENTO</td>
    <td align="center" class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox24" id="checkbox37" />
    </span></td>
    <td class="textosimple">CERTIFICADO DE NOTAS</td>
    <td align="center" class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox28" id="checkbox41" />
    </span></td>
  </tr>
  <tr>
    <td class="textosimple">AUTOR. SECREMINEDUC</td>
    <td align="center" class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox25" id="checkbox38" />
    </span></td>
    <td class="textosimple">NIVEL</td>
    <td align="center" class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox29" id="checkbox42" />
    </span></td>
  </tr>
  <tr>
    <td class="textosimple">PLAZO FECHA</td>
    <td align="center" class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox26" id="checkbox39" />
    </span></td>
    <td class="textosimple">MANUAL DE CONVIVENCIA</td>
    <td align="center" class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox30" id="checkbox43" />
    </span></td>
  </tr>
  <tr>
    <td class="textosimple">APORTE VOLUNTARIO CCA</td>
    <td align="center" class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox27" id="checkbox40" />
    </span></td>
    <td class="textosimple">PAGO MATRICULA</td>
    <td align="center" class="textosimple"><span class="textosimple">
      <input type="checkbox" name="checkbox31" id="checkbox44" />
    </span></td>
  </tr>
</table>
<br />

<br />
<br />
<td width="101" height="55" align="center" class="textosimple">&nbsp;</td>
    <td width="114" align="center" class="textosimple">&nbsp;</td>
    <td width="101" align="center" class="textosimple">&nbsp;</td>
    <td width="85" align="center" class="textosimple">&nbsp;</td>
    <td width="227" align="center" class="textosimple">&nbsp;</td>
  </tr>
<tr>
    <td align="center" class="textosimple"><br />
      <br />
      <br />
      <p><br />
      </p>
<br />
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla04">
  <tr>
    <td><div align="right">______________________________</div></td>
  </tr>
  <tr>
    <td><div align="right">FIRMA APODERADO </div></td>
  </tr>
</table>
<br />

<table width="650" border="0" align="center" cellpadding="2" cellspacing="0" class="tabla04">
  <tr>
    <td width="154">FECHA MATRICULA </td>
    <td width="496">_______________________________</td>
  </tr>
  <tr>
    <td>FECHA RETIRO </td>
    <td>_______________________________</td>
  </tr>
  <tr>
    <td>MOTIVO RETIRO </td>
    <td>_____________________________________________________________</td>
  </tr>
  <tr>
    <td colspan="2">___________________________________________________________________________________</td>
  </tr>
</table>
<br />
<? //} ?></td>  
</body>
</html>
