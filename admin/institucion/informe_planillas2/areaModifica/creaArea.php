<?php require('../../../../util/header.inc');
	$plantilla	=$_PLANTILLA;
if ($option==2){
	$creada=1;
}
echo $_PLANTILLA;
echo $_AREA;
$_POSP = 4;
$_bot = 7;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">

							
						  <form action="../../planilla_planillas2/areaModifica/procesoArea.php" method="post">
<?php 

if($creada!=1){
	for ($cant=0 ; $cant<$txtCant ; $cant++){
			$obj = "<td width=47%>";
			$obj = $obj."<font size=2 face=Arial, Helvetica, sans-serif>Nombre: ";
			$obj = $obj."<input name=\"txtNombreAr[".$cant."]\" type=text size=30 maxlength=200>";
			$obj = $obj."</font></td>";
			$obj = $obj."<td width=25% valign=middle>";
			$obj = $obj."<label><br>";
			$obj = $obj."<input type=radio name=\"concepto[".$cant."]\" value=1>";
			$obj = $obj."<font size=1 face=Arial, Helvetica, sans-serif>con Concepto Evaluativo</font></label>";
			$obj = $obj."</td>&nbsp;&nbsp;";
			$obj = $obj."<td width=28% valign=middle>";
			$obj = $obj."<input type=radio name=\"concepto[".$cant."]\" value=0>";
			$obj = $obj."<font size=1 face=Arial, Helvetica, sans-serif>sin Concepto Evaluativo</font>";
			$obj = $obj."<br>";
			$obj = $obj."<input type=radio name=\"subArea[".$cant."]\" value=1>";
			$obj = $obj."<font size=1 face=Arial, Helvetica, sans-serif>con Subareas</font></label>";
			$obj = $obj."</td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$obj = $obj."<td width=28% valign=middle>";
			$obj = $obj."<input type=radio name=\"subArea[".$cant."]\" value=0>";
			$obj = $obj."<font size=1 face=Arial, Helvetica, sans-serif>sin Subareas</font>";

			$obj = $obj."</td><br><br>";
			echo $obj;
			

	}
	
	echo "<input type='hidden' name='cant' value='".$cant."'>";
	
	if($cant!=0){
		echo "<td>";
		//echo "<input type='submit' name='enviar' value='Grabar Areas' onclick='window.location=procesoArea.php?cant=".$cant.";'>";
		echo "<input type='submit' class=botonXX  name='enviar' value='GRABAR AREAS'>";
		echo "</td>";
		echo "<td>";
		echo "&nbsp;&nbsp;<input type='button' class=botonXX  name='atras' value='VOLVER' onclick='window.location=\"area.php\";'>";
		echo "</td>";

	}else {
		echo "<script>window.location='area.php'</script>";
	}
}
	//Despues de crear areas las muestro
	if($creada==1){
		$sqlTraeAreas="SELECT * FROM informe_area WHERE id_plantilla=".$plantilla;
		$resultTraeAreas=pg_Exec($conn, $sqlTraeAreas);
		if (!$resultTraeAreas)
					error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlTraeAreas);
					//exit;
				else{
					echo "<td><font size=2 face=Arial, Helvetica, sans-serif>Areas Creadas</font></td><br><br>";
					for($count=0 ; $count<pg_numrows($resultTraeAreas) ; $count++){
						$filaAreas=pg_fetch_array($resultTraeAreas, $count);
						echo "<tr>";
						echo "<td>";
						echo "<font size=2 face=Arial, Helvetica, sans-serif>Area:";
						echo "&nbsp;&nbsp;";
						echo $filaAreas['nombre'];
						echo "</td>";
						echo "</tr><br>";
					}//
					//trae el id de la ultima area para registrarlo en la session
					$sqlTraeId="select max (id_area) as id_area from informe_area where id_plantilla=".$plantilla;
					$resultTraeId=pg_Exec($conn, $sqlTraeId);
					if (!$resultTraeId)
						error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlTraeId);
						//exit;
					else{
						$filaTraeId=pg_fetch_array($resultTraeId,0);
						echo $_AREA=$filaTraeId['id_area'];
				
					//registra el id de la ultima area en la session, la q recien se grabó
					if(!session_is_registered('_AREA')){
							session_register('_AREA');
					};
				}//fin if (!$resultTraeId)
				}//fin else
	
						echo "<br><br><font size=2 face=Arial, Helvetica, sans-serif><STRONG>";
						echo "Estos datos han sido grabados siga con el paso Nro. 3";
						echo "</strong></font>";
	}//fin ($creada==1){
			
			
?>
</form>	
							
</body>
</html>
