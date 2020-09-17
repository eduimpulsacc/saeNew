<?php require('../../../../util/header.inc');
$institucion =$_INSTIT;
$plantilla	=$_PLANTILLA;
?>


<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="procesoPlantilla.php" method="post">
  <table width="100%" border="0" align="center">
    <tr> 
      <td colspan="2"> <font size="2" face="Arial, Helvetica, sans-serif">1.- 
        <?php if($creada!=1){
        echo "Seleccione el Tipo de Ense&ntilde;anza al que aplicar&aacute; este informe.";
		}else{
		echo "Tipo de Ense&ntilde;anza al que aplicar&aacute; este informe:";
		}
		?>
        </font>&nbsp;</td>
    </tr>
    <tr> 
      <td width="8%">&nbsp;</td>
      <td width="92%"> 
        <?php 
	 	$sqlEns="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from  tipo_ense_inst inner join tipo_ensenanza on tipo_ense_inst.cod_tipo=tipo_ensenanza.cod_tipo where tipo_ense_inst.rdb='".$institucion."' and tipo_ense_inst.estado=1";
		$resultEns=pg_Exec($conn,$sqlEns);
	 ?>
        <?php if($creada!=1){?>
        <select name="cmbEns" id="cmbEns">
          <option value="0" selected>Seleccione Tipo de Ense&ntilde;anza</option>
          <?php
		  
		  for($cEns=0 ; $cEns<pg_numrows($resultEns) ; $cEns++){
			  $filaEns=pg_fetch_array($resultEns,$cEns);
			  echo "<option value=".$filaEns['cod_tipo'].">".$filaEns['nombre_tipo']."</option>";	
		  }//fin for
		  
		  ?>
        </select> 
        <?php }else{ //fin if($creada!=1)
				$sqlTraeEns="select nombre_tipo from tipo_ensenanza inner join informe_plantilla on tipo_ensenanza.cod_tipo=informe_plantilla.tipo_ensenanza where informe_plantilla.id_plantilla=".$plantilla;
				$resultTraeEns=pg_Exec($conn,$sqlTraeEns);
				$filaTraeEns=pg_fetch_array($resultTraeEns,0);
				echo "<font size=2 face=Arial, Helvetica, sans-serif>";
				echo $filaTraeEns['nombre_tipo'];
				echo "</font>";
			}
			?>
      </td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">2.- 
        <?php 
	  if($creada!=1){
	  echo "Asigne un nombre a la nueva Plantilla de Informe.";
	  }else{
	  echo "Nombre de la nueva Plantilla de Informe:";
	  }
	  ?>
        </font> &nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><font size="2" face="Arial, Helvetica, sans-serif"> 
        <?php if($creada!=1){
		echo "Nombre:";?>
		
        <input name="txtNombrePla" type="text" id="txtNombrePla" size="50" maxlength="50">
        <?php }else{
				$sqlTraeNombre="select nombre from informe_plantilla where id_plantilla=".$plantilla;
				$resultTraeNombre=pg_Exec($conn, $sqlTraeNombre);
				$filaTraeNombre=pg_fetch_array($resultTraeNombre,0);
				echo "<font size=2 face=Arial, Helvetica, sans-serif>";
				echo $filaTraeNombre['nombre'];
				echo "</font>";
	  		} ?>
        </font></td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2"> 
        <?php if ($creada!=1){?>
        <input type="submit" name="Submit" value="Grabar"></td>
      <?php }else{
			echo "<font size=2 face=Arial, Helvetica, sans-serif><STRONG>";
	  		echo "Estos datos han sido grabados siga con el paso Nro. 2";
			echo "</strong></font>";
	  		}
	  ?>
    </tr>
  </table>

</form>
</body>
</html>
