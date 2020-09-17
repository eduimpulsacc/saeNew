<script language="javascript">

//*************************************************************************************
//------------------------ VALIDACION DE CAMPOS VACIOS --------------------------------
//*************************************************************************************
	function CamposVacios(objeto,valor,nom_campo)
	{
		if (valor=="" || valor=="null" || valor==-1)
		{
			alert(" Debe ingresar datos en el campo obligatorio " + nom_campo );
			objeto.focus();
			return false;
		}
	}	
//*************************************************************************************
//---------------------- FIN VALIDACION DE CAMPOS VACIOS ------------------------------
//*************************************************************************************


//*************************************************************************************
//------------------------ VALIDACION DE NUMEROS ENTEROS ------------------------------
//*************************************************************************************
	function EsEntero(item, valor)
	{
		var checkOK = "0123456789";
		var checkStr = item.value;
		var allvalid = true;
		var allnum = "";
		var comapunto = 0;

		for (i = 0; i < checkStr.length; i++)
		{
			ch = checkStr.charAt(i);
			if (ch == "." || ch == "," )
			comapunto++;
			for (j = 0; j < checkOK.length; j++)
			if (ch == checkOK.charAt(j))
				break
			if (j == checkOK.length)
			{
				allvalid = false;
				break;
			}
			allnum += ch;
		}
		if (!allvalid || comapunto > 1)
		{	
			item.value = valor;
			item.select();
			item.focus();
			return(false);
		}
		return(true);
	}
//*************************************************************************************
//---------------------- FIN VALIDACION DE NUMEROS ENTEROS ----------------------------
//*************************************************************************************

</script>
<?
	Function impF($txt){
	if ($txt!=0){ 
		$ano = substr (($txt),0,4);
		$mes = substr(($txt),5,2);
		$dia = substr(($txt),8,3);
		$txt = sprintf ("%02d-%02d-%04d", $dia, $mes, $ano);
		echo $txt;
	}
	}
	
	Function rutF($txt){
		if ($txt!=""){
			$largo=strlen($txt);
			if ($largo==9){
				$millon =substr (($txt), 0,2); 
				$centena = substr (($txt), 2,3); 
				$decena = substr (($txt), 5,3); 
				$exten = substr (($txt), -1); 
			}else{
				$millon =substr (($txt), 0,1); 
				$centena = substr (($txt), 1,3); 
				$decena = substr (($txt), 4,3); 
				$exten = substr (($txt), -1); 
			}
		$txt = $millon.".".$centena.".".$decena." - ".$exten;
		echo $txt;
		}
	}
	Function mesF($txt){
			switch ($txt)
			{
			case 1:
				$txt = "ENERO";
				break;
			case 2:
				$txt = "FEBRERO";
				break;
			case 3:   
				$txt = "MARZO";
				break;
			case 4:
				$txt = "ABRIL";
				break;
			case 5:
				$txt = "MAYO";
				break;
			case 6:
				$txt = "JUNIO";
				break;
			case 7:
				$txt = "JULIO";
				break;
			case 8:
				$txt = "AGOSTO";
				break;
			case 9:	
				$txt = "SEPTIEMBRE";
				break;
			case 10:
				$txt = "OCTUBRE";
				break;
			case 11:
				$txt = "NOVIEMBRE";
				break;
			case 12:
				$txt = "DICIEMBRE";
				break;
			}
			echo $txt;
		}
?>

