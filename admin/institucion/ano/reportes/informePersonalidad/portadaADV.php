<style>
.bordes{
-webkit-border-radius:27px;
-moz-border-radius:27px;
-ms-border-radius:27px;
-o-border-radius:27px;
border-radius:27px;
border: 4px solid #000000;
}
.portada{
	font-family:"arial", cursive;
}
.titulop{
	font-size:24px;
}
.subitem { font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
}
.da{
	font-family:"arial";
	}
</style>
<?php 
$Curso_palK = CursoPalabra($curso, 4, $conn);
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><br>
<br>
<br>
<br>

<table width="650" border="0" align="center" class="portada">
  <tr>
    <td align="center">&nbsp;<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><img src="informePersonalidad/imgadv/jesus1.jpg" width="197" height="265"></td>
    <td align="center"><img src="informePersonalidad/imgadv/logoadv.jpg" width="200" height="200"></td>
    <td align="center"><img src="informePersonalidad/imgadv/jesus1.jpg" width="197" height="265"></td>
  </tr>
</table>

								 <br />
								<div align="center">
                                <img src="informePersonalidad/imgadv/txt1.jpg"><br><img src="informePersonalidad/imgadv/txt2.jpg">

                                </div>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td><br>
<br>
<br><br>
<br>


    <table width="650"><tr><td>
    <table width="630" style="border-collapse: collapse; font-weight: bold;" cellpadding="0" cellspacing="0" border="1" class="da">
    <tr>
      <td width="178"  bgcolor="#C6D9F1"><font color="#1F497D">&nbsp;Director</font></td>
      <td width="446" bgcolor="#92CDDC">
      <?php $ob_reporte->Director($conn);?>
      &nbsp;<?php echo strtoupper($ob_reporte->tildeM($ob_reporte->nombre_director)); ?></td>
    </tr>
    <tr>
      <td bgcolor="#C6D9F1"><font color="#1F497D">&nbsp;Nombre Ni&ntilde;o/a</font></td>
      <td bgcolor="#92CDDC">&nbsp;<?php echo strtoupper($ob_reporte->tildeM($ob_reporte->nombres));?></td>
    </tr>
    <tr>
      <td bgcolor="#C6D9F1"><font color="#1F497D">&nbsp;Rut</font></td>
      <td bgcolor="#92CDDC">&nbsp;<?php echo $ob_reporte->rut_alumno ?></td>
    </tr>
    <tr>
      <td bgcolor="#C6D9F1"><font color="#1F497D">&nbsp;Fecha Nacimiento</font></td>
      <td bgcolor="#92CDDC">&nbsp;<?php echo CambioFD($ob_reporte->fecha_nacimiento)  ?></td>
    </tr>
    <tr>
      <td bgcolor="#C6D9F1"><font color="#1F497D">&nbsp;Nombre Educadora</font></td>
      <td bgcolor="#92CDDC">&nbsp;<?
				    if($institucion==770){
		                 echo $ob_reporte->profe_nombre;
					}else{
		                 echo $ob_reporte->tildeM($ob_reporte->profe_nombre);
					}				
					?></td>
    </tr>
    <tr>
      <td bgcolor="#C6D9F1"><font color="#1F497D">&nbsp;Nombre t&eacute;cnico</font></td>
      <td bgcolor="#92CDDC">&nbsp;</td>
    </tr>
    </table><br>
<br>
<br><br>
<br>

<div align="center">
<table width="567" border="1" cellspacing="0" cellpadding="0" bordercolor="#4BACC6">
  <tr>
    <td width="563" align="center" style="font-family: Verdana, Geneva, sans-serif; font-size: 12px; font-weight: bold;">&iexcl;Instruye al niño en su camino, y aun cuando fuere viejo no se apartará de él!. <br>
Proverbios 22:6
</td>
  </tr>
</table>
</div>
    </td></tr></table>
    </td>
  </tr>
</table>
