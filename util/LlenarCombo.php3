<?php 
function LLenarCombo($sql,$conn,$param,$flag,$mensaje)
{
	$Conexion = @pg_exec($conn,$sql);
	echo "<select " . $param . ">";
	$cadena_vacio = $cadena_vacio . "&nbsp;";
	if ($flag=="true")
	{
		echo "<option style='Courier' value='null'>" . $mensaje . "</option>";

	}
	if ($Conexion)
	{
		if (pg_numrows($Conexion)!=0)
		{
			$strValue = "       ";
			$fils = @pg_fetch_array($Conexion,0);
			for ($i=0;$i<pg_numrows($Conexion);$i++)
			{
				$fils = @pg_fetch_array($Conexion,$i); 
	echo "<option style='Courier' value='" . Trim($fils[0]) . "'>" . Trim($fils[1]) . '  ' .Trim($fils[2]) . $strValue . "</option>";
			}
		}
	}
	@pg_close($Conexion);
	echo "</select>";
}
?>