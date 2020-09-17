<? require('../../../util/header.inc');

function Estado ($id_estado,$nombre){
		switch ($id_estado){
			case 2:
				echo "<font face='Geneva, Arial, Helvetica, sans-serif' size='1' color='red'>" . $nombre."</font>";
				break;
			case 3:
				echo "<font face='Geneva, Arial, Helvetica, sans-serif' size='1' color='green'>" . $nombre . "</font>";
				break;
			case 4:
				echo "<font face='Geneva, Arial, Helvetica, sans-serif' size='1' color='blue'>" . $nombre ."</font>";
				break;
					}
	}

	$qry = "SELECT soporte.*, estado.nombre, tipo_problema.nombre as problema FROM soporte inner join estado on soporte.id_estado=estado.id_estado INNER JOIN tipo_problema ON soporte.id_problema=tipo_problema.id_problema WHERE "; 
		if (($txtDesde!="")&& ($txtHasta!="")&&($cmbESTADO!=0)){
			$qry =$qry . " fecha>=to_date('" . $txtDesde . "','DD MM YYYY') and fecha<=to_date('" . $txtHasta . "','DD MM YYYY') AND soporte.id_estado=" . $cmbESTADO . " ORDER BY fecha ASC";
		}
		if (($txtDesde=="")&& ($txtHasta=="")&&($cmbESTADO!=0)){
			$qry = $qry . "soporte.id_estado=" . $cmbESTADO . " ORDER BY fecha ASC";
		}
		if (($txtDesde!="")&& ($txtHasta!="")&&($cmbESTADO==0)){
			$qry =$qry . " fecha>=to_date('" . $txtDesde . "','DD MM YYYY') and fecha<=to_date('" . $txtHasta . "','DD MM YYYY') ORDER BY fecha ASC";
		}
	$Rs_Soporte = @pg_exec($conn,$qry);
	
	




?> 
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<p>&nbsp;</p><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="003b85"> 
    <td colspan="6"> <div align="center"><font color="#FFFFFF" size="2" face="arial, geneva, helvetica"><strong>LISTADO DE SOPORTE</strong></font></div></td>
  </tr>
  <tr bgcolor="#48d1cc"> 
    <td><font size="1" face="arial, geneva, helvetica">RBD</font></td>
    <td><font size="1" face="arial, geneva, helvetica">COLEGIO</font></td>
    <td><font size="1" face="arial, geneva, helvetica">FECHA</font></td>
	<td><font size="1" face="arial, geneva, helvetica">HORA</font></td>
    <td><font size="1" face="arial, geneva, helvetica">TIPO PROBLEMA</font></td>
    <td><font size="1" face="arial, geneva, helvetica">ESTADO</font></td>
  
  </tr>
  <? if(@pg_numrows($Rs_Soporte)!=0){
  		for($i=0;$i<@pg_numrows($Rs_Soporte);$i++){
			$fila = @pg_fetch_array($Rs_Soporte,$i);
			$qry = "SELECT nombre_instit, rdb FROM institucion WHERE rdb =". $fila['rbd'];
			$Rs_Instit = @pg_exec($conn,$qry);
			$fils = @pg_fetch_array($Rs_Instit,0);
			
  ?>
  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaSoporte.php3?soporte=<?php echo $fila["id_soporte"];?>&caso=3')>						
    <td><font face="arial, geneva, helvetica" size="1">&nbsp;<? echo $fils['rdb'];?></font></td>
    <td><font face="arial, geneva, helvetica" size="1">&nbsp;<? echo substr($fils['nombre_instit'],0,30);?></font></td>
    <td><font size="1" face="arial, geneva, helvetica">&nbsp;<? impF($fila['fecha']);?></font>&nbsp;</td>
    <td><font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $fila['hora'];?></font></td>
    <td><font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $fila['problema'];?></font></td>
	<td><font size="1" face="arial, geneva, helvetica">&nbsp;<? ESTADO($fila['id_estado'],$fila['nombre']);?></font></td>
 </tr>
  <? } // fin for
  }else{?>
  <tr>
  	<td colspan="5">No se registran solicitudes </td>
  </tr>
  <? } ?>
</table>

</body>
</html>
