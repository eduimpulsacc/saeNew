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
    <td width="67%" class="textonegrita" align="center">&nbsp;
    <? $sql="SELECT nombre_instit FROM institucion WHERE rdb=".$institucion;
		$rs_instit = pg_exec($conn,$sql);
		echo pg_result($rs_instit,0);
	?>
    </td>
    <td width="13%" class="textosimple">A&ntilde;o Escolar </td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td valign="baseline">&nbsp;
    <hr color="#000000" /></td>
    <td class="textosimple">N&ordm; Matricula </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita"><div align="center">FICHA DE MATRICULA </div></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><hr color="#000000" /></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td colspan="8" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>DATOS DEL ALUMNO</p></td>
  </tr>
  <tr>
    <td width="95" valign="top"  class="textosimple">RUT</td>
    <td valign="top">&nbsp;</td>
    <td  valign="top"  class="textosimple">A&Ntilde;O</td>
    <td colspan="3"  valign="top" class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td width="95" valign="top" class="textosimple">NOMBRE</td>
    <td valign="top">&nbsp;</td>
    <td  valign="top" class="textosimple">CURSO</td>
    <td colspan="3"  valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="95" valign="top" class="textosimple">SEXO</td>
    <td valign="top">&nbsp;</td>
    <td  valign="top" class="textosimple">F.NAC</td>
    <td colspan="3"  valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="95" valign="top" class="textosimple">DOMICILIO</td>
    <td colspan="7" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="95" valign="top" class="textosimple">COMUNA</td>
    <td width="222"  valign="top">&nbsp;</td>
    <td width="85" valign="top" class="textosimple">TELEFONO FIJO:</td>
    <td width="88" valign="top">&nbsp;</td>
    <td width="81"  valign="top" class="textosimple">CELULAR:</td>
    <td width="65"  valign="top">&nbsp;</td>
  </tr>
</table>
<br />

<br />

<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td width="562" colspan="5" valign="top" bgcolor="#CCCCCC" class="textonegrita">ATENCI&Oacute;N DE    PROFESIONALES&nbsp; (Marcar con x)</td>
  </tr>
  <tr>
    <td width="71" valign="top">&nbsp;</td>
    <td width="94" valign="top">&nbsp;</td>
    <td width="95" valign="top">&nbsp;</td>
    <td width="85" valign="top">&nbsp;</td>
    <td width="217" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="71" align="center" valign="bottom" class="textosimple">Psic&oacute;logo</td>
    <td width="94" align="center" valign="bottom" class="textosimple">Fonoaudi&oacute;logo</td>
    <td width="95" align="center" valign="bottom" class="textosimple">Grupo diferencial</td>
    <td width="85" align="center" valign="top" class="textosimple">Otros</td>
    <td width="217" align="center" valign="top" class="textosimple">(mencionar)</td>
  </tr>
</table>
<br />
<td width="101" height="55" align="center" class="textosimple">&nbsp;</td>
    <td width="114" align="center" class="textosimple">&nbsp;</td>
    <td width="101" align="center" class="textosimple">&nbsp;</td>
    <td width="85" align="center" class="textosimple">&nbsp;</td>
    <td width="227" align="center" class="textosimple">&nbsp;</td>
  </tr>
<tr>
    <td align="center" class="textosimple">
      <table width="650" border="1" align="center" cellpadding="1" cellspacing="0" style="border-collapse:collapse" >
        <tr>
          <td width="232" align="left" bgcolor="#CCCCCC" class="textonegrita" >RELIGION</td>
          <td colspan="3" align="left" bgcolor="#CCCCCC" class="textonegrita" >&nbsp;</td>
        </tr>
        <tr>
          <td align="left" class="textosimple">SACRAMENTOS RECIBIDOS<br />
            (marcar con una X)            <br /></td>
          <td align="left" valign="top" class="textosimple" >Bautismo</td>
          <td align="left" valign="top" class="textosimple">Primera Comuni&oacute;n</td>
          <td align="left" valign="top" class="textosimple" >Confirmaci&oacute;n</td>
        </tr>
      </table>
      <br />
      <table border="1" cellspacing="0" cellpadding="0" align="center" width="653" style="border-collapse:collapse">
        <tr>
          <td width="170" valign="top" bgcolor="#CCCCCC" class="textonegrita">CURSO REPETIDO:&nbsp;</td>
          <td width="483" valign="top" bgcolor="#CCCCCC" class="textonegrita">DATOS    BIOL&Oacute;GICOS &ndash; INFORMACI&Oacute;N DE SALUD</td>
        </tr>
        <tr>
          <td width="170" height="39" valign="top"><h3><strong>&nbsp;</strong></h3></td>
          <td width="483" valign="top"><h3>&nbsp;</h3></td>
        </tr>
      </table>
      <br />
      <table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
        <tr>
          <td width="657" colspan="8" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>PERTENECE&nbsp; A: (Marque con&nbsp; una&nbsp;    &ldquo;X&rdquo; lo que corresponda)</p></td>
        </tr>
        <tr>
          <td height="32" valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td width="47" valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="102" align="center" valign="top" class="textosimple">Programa Puente o Chile Solidario</td>
          <td width="73" align="center" valign="top" class="textosimple">JUNAEB</td>
          <td width="94" align="center" valign="top" class="textosimple">Subsidio<br />&Uacute;nico Familiar</td>
          <td width="85" align="center" valign="top" class="textosimple">Descendencia Ind&iacute;gena</td>
          <td width="66" align="center" valign="top" class="textosimple">Isapre</td>
          <td width="66" align="center" valign="top" class="textosimple">Fonasa</td>
          <td width="47" align="center" valign="top" class="textosimple">Grupo</td>
          <td width="123" align="center" valign="top" class="textosimple">Otro&nbsp; (especificar)</td>
        </tr>
      </table>
      <br />

      <table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
        <tr>
          <td  valign="top" colspan="4" class="textonegrita" bgcolor="#CCCCCC">&nbsp;DATOS DEL APODERADO&nbsp;</td>
        </tr>
        <tr>
          <td width="154" valign="top" class="textosimple">&nbsp;RUT</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="154" valign="top" class="textosimple">&nbsp;NOMBRE</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="154" valign="top" class="textosimple">&nbsp;PROFESION</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top" class="textosimple">&nbsp;PARENTEZCO</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="154" valign="top" class="textosimple">&nbsp;DOMICILIO</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top" class="textosimple">&nbsp;E-MAIL</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="154" valign="top" class="textosimple">&nbsp;COMUNA</td>
          <td width="229"  valign="top">&nbsp;</td>
          <td width="134" valign="top" class="textosimple">&nbsp;TELEFONO FIJO: </td>
          <td width="123" valign="top" class="textosimple">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top" class="textosimple">&nbsp;FECHA NAC.</td>
          <td  valign="top">&nbsp;</td>
          <td  valign="top" class="textosimple">&nbsp;CELULAR</td>
          <td  valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" valign="top" bgcolor="#CCCCCC" class="textonegrita">&nbsp;DATOS DE LA MADRE</td>
        </tr>
        <tr>
          <td valign="top" class="textosimple">&nbsp;RUT</td>
          <td  valign="top" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" class="textosimple">&nbsp;NOMBRE</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" class="textosimple">&nbsp;TELEFONO</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" class="textosimple">&nbsp;ESTUDIOS</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4"  valign="top" bgcolor="#CCCCCC" class="textonegrita">&nbsp;DATOS APODERADO SUPLENTE</td>
        </tr>
        <tr>
          <td  valign="top" class="textosimple">&nbsp;NOMBRE</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" class="textosimple">&nbsp;RUT</td>
          <td valign="top">&nbsp;</td>
          <td valign="top" class="textosimple">&nbsp;COMUNA</td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" class="textosimple">&nbsp;DOMICILIO</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" class="textosimple">&nbsp;PROFESION / OFICIO</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" class="textosimple">&nbsp;RELACION</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" class="textosimple">&nbsp;EMAIL</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" class="textosimple">&nbsp;TELEFONO</td>
          <td valign="top">&nbsp;</td>
          <td valign="top" class="textosimple">&nbsp;CELULAR</td>
          <td valign="top">&nbsp;</td>
        </tr>
      </table>
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
