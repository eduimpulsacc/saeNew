<?php require('../../util/header.inc');?>
<?php 
	$alumno			=$_ALUMNO;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="739" height="300" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="bottom"><p>
	<?php
		$result = @pg_Exec($conn,"select * from alumno where rut_alumno=".$alumno);
		$arr=@pg_fetch_array($result,0);
		$output= "select lo_export(".$arr[foto].",'/opt/www/tmp/".chop($alumno)."');";
		$retrieve_result = @pg_exec($conn,$output);
	if (!$retrieve_result){ ?>
			<img src="../apoderado/imag/alumno.gif" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="180" height="220" id="ALUMNO">
	<?php }else{ ?>
			<img src="../../../../../../../tmp/<?echo chop($alumno)?>" ALT="NO DISPONIBLE" width=150></p>
	<?php } ?>
	
	<!--img src="imag/alumno.gif" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="180" height="220" id="ALUMNO"--></p>
      <p><font color="003b85" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>&iexcl;Bienvenido 
        <?php echo $arr['nombre_alu']; ?>&nbsp; <?php echo $arr['ape_pat']; ?>&nbsp; <?php echo $arr['ape_mat']; ?> !<br>
        </strong></font></p>
      </td>
  </tr>
</table>
</body>
</html>
