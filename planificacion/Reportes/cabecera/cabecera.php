<?php 
$cr="";
for($cc=0;$cc<$r;$cc++){
$cr.="../";	
}
$cr=$cr."cabecera/";
?>

<table width="100%" border="0">
      <tr class="textonegrita">
        <td>
        <? 
			echo $fila_membrete['nombre_instit']."<br> Tel&eacute;fono:".$fila_membrete['telefono']."<br> Direcci&oacute;n:".$fila_membrete['calle']." ".$fila_membrete['nro'];
?>        
        </td>
        <td align="center"><img src="<?php echo $cr ?>lna.jpg" width="2" height="100" /></td>
        <td align="right"><? 
			if($institucion!=""){
				   echo "<img src='../../../tmp/".$fila_membrete['rdb']."insignia". "' >";
			}else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			}
			?>	
        </td>
      </tr>
    </table>