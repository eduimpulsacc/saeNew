<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP          =5;
	$_bot           =5;
	//if ($_ALUMNO!=""){
	if ($sw != 1){
	   $alumno			=$_ALUMNO;
    }else{
	   $_ALUMNO = $alumno;
	}   
	//}
	$curso			=$_CURSO;
	
	$aa = date(Y);
	
	// ELIMINO AL ALUMNO DE LAS TABLAS SOLICITADAS
	
	$q1 = "delete from matricula where rut_alumno = '$alumno' and id_ano = '$ano'";
	$r1 = pg_Exec($conn,$q1);
	if (!$r1){
	   echo "Error, No se ha eliminado al alumno";
	   exit();
	}
	$q2 = "delete from tiene$aa where rut_alumno = '$alumno'";
	$r2 = pg_Exec($conn,$q2);
	if (!r2){
	    echo "Error, no he borrado desde la tabla tiene$aa";
		exit();
	}
	$q3 = "delete from asistencia where rut_alumno = '$alumno' and ano = '$ano'";
	$r3 = pg_Exec($conn,$q3);
	if (!r3){
	    echo "Error, no he borrado desde la tabla asistencia";
		exit();
	}
	$q4 = "delete from inasistencia_asignatura where rut_alumno = '$alumno' and ano = '$ano'";
	$r4 = pg_Exec($conn,$q4);
	if (!r4){
	    echo "Error, no he borrado desde la tabla inasistencia_asignatura";
		exit();
	}
		    
    pg_close($conn);
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo2 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>
<link href="../../../../../estilos.css" rel="stylesheet" type="text/css">
<body topmargin="0" leftmargin="0" rightmargin="0">
<table width="250" height="200" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><div align="center">
      <p><br />
        <span class="Estilo1"><u><span class="Estilo2">Respaldo de Alumno Retirado</span></u><span class="Estilo2"><br />
          <br />
          <br />
          Para obtener un respaldo del alumno retirado haga haga click <br />
          en el siguiente boton
	      </span><br />
	      <br />
          <input name="Submit2" type="button" class="botonXX" onclick="window.open('respaldo_excel.php');window.close();" value="BAJAR ARCHIVO EXCEL" />
      
    </div></td>
  </tr>
</table>
</body>
</html>
