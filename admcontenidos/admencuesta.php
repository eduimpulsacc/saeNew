<?
require('util/header2.inc');

if ($op == "b"){
   // Borramos la encuesta seleccionada
   $q2 = "delete from encuesta where id = '$id_encuesta'";
   $q3 = "delete from opciones_encuesta where id_encuesta = '$id_encuesta'";
   $r2 = pg_Exec($conn,$q2);
   if (!$r2){
       echo "Error no se pudo eliminar la encuesta";
	   exit();
   }
   $r3 = pg_Exec($conn,$q3);
   if (!$r3){
       echo "Error no se pudo eliminar las opciones de la encuesta";
   }
}   	   	 

if ($op == "a"){
   // Activamos la encuesta
   $q4 = "update encuesta set activo = '$est' where id = '$id_encuesta'";
   $r4 = pg_Exec($conn,$q4);
   if (!$r4){
       echo "Error no se pudo actualizar la encuesta";
	   exit();
   }
}    	   
  




$q1 = "select * from encuesta order by id desc";
$r1 = pg_Exec($conn,$q1);
if (!r1){
   echo "Error al intentar tomar la encuesta";
   exit();
}
   	 
?>		 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr>
    <td><div align="center">ENCUESTAS</div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><div align="right">
      <label>
      <input name="Submit" type="button" onclick="MM_goToURL('parent','form_encuesta.php');return document.MM_returnValue" value="AGREGAR ENCUESTA" />
      </label>
    </div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="15%" bgcolor="#CCCCCC"><div align="center">FECHA</div></td>
    <td width="35%" bgcolor="#CCCCCC"><div align="center">ENCUESTA</div></td>
    <td width="10%" bgcolor="#CCCCCC"><div align="center">VOTANTES</div></td>
	<td width="10%" bgcolor="#CCCCCC"><div align="center">RESULTADOS</div></td>
    <td width="10%" bgcolor="#CCCCCC"><div align="center">EDITAR</div></td>
    <td width="10%" bgcolor="#CCCCCC"><div align="center">BORRAR</div></td>
    <td width="10%" bgcolor="#CCCCCC"><div align="center">ACTIVAR</div></td>
  </tr>
  <?
  if (pg_numrows($r1) != 0){
     $i = 0;
	 while ($i < pg_numrows($r1)){
	    $f1 = pg_fetch_array($r1,$i);
		$id_encuesta = $f1['id'];
		$fecha       = $f1['fecha'];
		$dd          = substr($fecha,8,2);
		$mm          = substr($fecha,5,2);
		$aa          = substr($fecha,0,4);
		$fecha       = "$dd-$mm-$aa";
		$pregunta    = $f1['pregunta'];
		$votantes    = $f1['votantes'];
		$activo      = $f1['activo'];
		if ($activo == 1){
		   $imagen = "circulo_verde.gif";
		   $est = 0;
		}else{
		   $imagen = "circulo_rojo.gif";
		   $est = 1;
		}      
			 
	    ?>
        <tr>
          <td><div align="center"><?=$fecha ?></div></td>
          <td><div align="center"><a href="proceso_encuesta.php?id_encuesta=<?=$id_encuesta ?>&modo=4"><?=$pregunta ?></a></div></td>
          <td><div align="center"><?=$votantes ?></div></td>
          <td><div align="center"><a href="proceso_encuesta.php?id_encuesta=<?=$id_encuesta ?>&modo=4&ver=si"><img src="images/lupa.gif" width="16" height="14" border="0" /></a></div></td>		  
		  <td><div align="center">
		  <?
		  if ($votantes == 0){
		     ?>
		      <a href="proceso_encuesta.php?op=e&modo=4&id_encuesta=<?=$id_encuesta ?>"><img src="images/lapiz.gif" width="16" height="14" border="0" /></a>
			 <?
	      } ?>		  
			  </div></td>
          <td><div align="center"><a href="proceso_encuesta.php?id_encuesta=<?=$id_encuesta ?>&modo=4&ver=si&op=b"><img src="images/cruz.gif" width="14" height="14" border="0" /></a></div></td>
          <td><div align="center"><a href="admencuesta.php?op=a&id_encuesta=<?=$id_encuesta ?>&est=<?=$est ?>"><img src="images/<?=$imagen ?>" width="17" border="0" height="12" /></a></div></td>
        </tr>
		<?
		$i++;
     }
  }
  ?>	 		
	 
</table>
</body>
</html>
