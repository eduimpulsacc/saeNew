<?php require('../../../../util/header.inc');

$plantilla	=$_PLANTILLA;
$area		=$_AREA;
$concepto	=$_CONCEPTO;

echo $_PLANTILLA."<br>";
echo $_AREA."<br>";
echo $_CONCEPTO;

?>
<html>
<head>
<title>Untitled Document</title>

<script>
	function valida(form){
		if(form.txtplantilla.value=="") {alert("DEBE COMPLETAR DATOS DE PLANTILLA"); var sale=0;}
		if(form.txtarea.value=="") {alert("DEBE COMPLETAR DATOS DE AREAS"); var sale=0;}
		if(form.txtconcepto.value=="") {alert("DEBE COMPLETAR DATOS DE CONCEPTOS DE EVALUACIÓN"); var sale=0;}
		if (sale!=0){
			form.sgte.target="self";
			form.action="plantillaPaso2.php";
			form.submit(true);
		}
	}

</script>


</head>

<body>
<form action="plantillaPaso2.php" method="post">
  <table width="76%" border="0" align="center">
    <tr> 
      <td colspan="3" bgcolor="#003b85"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>CREAR 
          PLANTILLA DE INFORME</strong></font></div></td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp; </td>
    </tr>
    <tr> 
      <td colspan="3"><font size="2" face="Arial, Helvetica, sans-serif">1ro.- 
        Datos Plantilla</font></td>
    </tr>
    <tr> 
      <td colspan="3"> <?php 
		if($plantilla!=""){
			$srcP="creaPlantilla.php?creada=1";
		}else{
			$srcP="creaPlantilla.php";
		}
		?>
        <fieldset>
        <legend><font size="2" face="Arial, Helvetica, sans-serif"><strong>Plantilla</strong></font></legend>
        
		<iframe id="iframe0" name="iframe0" src="<?php echo $srcP; ?>" frameborder="0" style="width:100%; height:130%;"></iframe>
        </fieldset>
        &nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3" bordercolor="#003b85"><font size="2" face="Arial, Helvetica, sans-serif"> 
        2do.- Crear las Areas de Evaluaci&oacute;n.</font> </td>
    </tr>
    <tr> 
      <td> 
	   <?php 
		if($area!=""){
			$srcA="/area/creaArea.php?creada=1";
		}else{
			$srcA="/area/area.php";
		}
		?>
	  <fieldset>
        <legend><font size="2" face="Arial, Helvetica, sans-serif"><strong>Areas</strong></font></legend>
        <iframe id="iframe0" name="iframe0" src="<?php echo $srcA; ?>" frameborder="0" style="width:100%; height:100%;"></iframe>
        &nbsp; </fieldset></td>
    </tr>
    <tr> 
      <td>&nbsp; </td>
    </tr>
    <tr> 
      <td colspan="3"><font size="2" face="Arial, Helvetica, sans-serif"> 3ro.- 
        Crear los Conceptos Evaluativos.</font></td>
    </tr>
    <tr> 
	 
      <td colspan="3" bordercolor="#003b85">
	  <?php 
		if($concepto!=""){
			$srcC="/concepto/creaConcepto.php?creada=1";
		}else{
			$srcC="/concepto/creaConcepto.php";
		}
		?>
		<fieldset>
        <legend><font size="2" face="Arial, Helvetica, sans-serif"><strong>Conceptos</strong></font></legend>
        <iframe id="iframe0" name="iframe0" src="<?php echo $srcC; ?>" frameborder="0" style="width:100%; height:100%;"></iframe>
        &nbsp; </fieldset></td>
    </tr>
    <tr> 
      <td colspan="3">
	    <input type="hidden" name="txtplantilla" value="<?php echo $_PLANTILLA?>">
        <input type="hidden" name="txtarea" value="<?php echo $_AREA?>">
        <input type="hidden" name="txtconcepto" value="<?php echo $_CONCEPTO?>">
		</td>
    </tr>
    <tr> 
      <td colspan="3" align="right">
<input type="button" name="sgte" value="Siguiente >>" onClick="valida(this.form)"></td>
    </tr>
    <tr> 
      <td colspan="3" align="right">&nbsp; </td>
    </tr>
  </table>
</form>
</body>
</html>
