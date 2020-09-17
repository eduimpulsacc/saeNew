<table>
 <tr>
    <td width="172" height="120" align="center" valign="middle"><? 
			if($fila_instit['rdb']!=""){
				   echo "<img src='../../../../tmp/".$fila_instit['rdb']."insignia". "' width='97' height='117'>";
			}else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			}
			?>	</td>
    <td width="25" align="center" valign="middle"><hr align="center" width="1" size="100" /></td>
    <td width="439"><table width="100%" border="0">
      <tr>
        <td align="center" class="textonegrita"><? echo strtoupper($fila_instit['nombre_instit']);?></td>
      </tr>
      <tr>
        <td align="center" class="textosimple"><? echo $fila_instit['direc']." / ".$fila_instit['nom_reg'];?></td>
      </tr>
      <tr>
        <td align="center" class="textosimple"> <? echo "Tel&eacute;fono ".$fila_instit['telefono'];?></td>
      </tr>
     
    </table></td>
  </tr>
</table>