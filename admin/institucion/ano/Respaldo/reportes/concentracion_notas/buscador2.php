<? require('../../../../../util/header.inc');?>
<? if ($txt){

}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Buscador de Sub Sectores</title>
<link href="../../../../../estilos.css" rel="stylesheet" type="text/css">
</head>

<body >

<form >
<table width="1%" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="53%"><table width="100%" height="43" border="1" cellpadding="0" cellspacing="0">
      <tr height="10">
        <td width="53%" ><b>Buscador Avanzado</b></td>
      </tr>
      <tr>
        <td height="27" nowrap><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td  nowrap><b>Sub-Sector</b></td>
            <td width="123" nowrap><input name="txt" type="text" value="" /></td>
		</tr><tr>
            <td width="199" colspan="2"  align="center" nowrap="nowrap"><input name="cb_ok" type="submit" class="botonXX" id="cb_ok" value="Buscar"/>            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<? if ($txt){
$txt = strtoupper ($txt);

$query_bus="select * from subsector where upper(nombre) like '%$txt%'";
$result_bus=pg_exec($conn,$query_bus);
$num_bus=pg_numrows($result_bus);


$num_bus=pg_numrows($result_bus);
?>
<table align="center">
  <tr >
    <td><b>Cod</b></td>
    <td><b>Sub Sector</b></td>
  </tr>
  <? for ($i=1;$i<=$num_bus;$i++){
$row_bus=pg_fetch_array($result_bus);
?>
  <tr valign="top" bgcolor="#ffffff" onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='transparent'" onclick="opener.insRow('<? echo $row_bus[cod_subsector];?>','<? echo $row_bus[nombre];?>');window.close();" >
    <td><font face="arial, geneva, helvetica" size="2" color="#000000"> <strong><? echo $row_bus['cod_subsector']?></strong></font></td>
    <td><font face="arial, geneva, helvetica" size="2" color="#000000"> <strong><? echo $row_bus['nombre']?></strong></font></td>
  </tr>
  <? }?>
</table>
<? }?>


</body>
</html>
	