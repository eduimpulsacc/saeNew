<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
<script language="javascript" type="text/javascript">
function insRow()
{
	largo=document.getElementById('mytable').rows.length;
	var x=document.getElementById('mytable').insertRow(largo);
	j=largo;
	var y=x.insertCell(0)
	var z=x.insertCell(1)
	temp=largo+1;
	y.innerHTML="opcion "+temp;
	z.innerHTML="<input name=opt["+temp+"]>";

}
function delRow()
{
largo=document.getElementById('mytable').rows.length;
largo=largo-1;
if (largo>2){
	var x=document.getElementById('mytable').deleteRow(largo);
}else{
	alert ('minimo son 3 opciones');
}

}
</script>
</head>

<body>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr>
    <td><div align="center">INGRESO DE ENCUESTA</div></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><div align="right">
      <label>
	  <?
	  if ($op=="e"){
	      ?>
	      <input name="Submit" type="button" onclick="MM_callJS('history.go(-2)')" value="VOLVER" />
          <?
      }else{
	      ?>
	      <input name="Submit" type="button" onclick="MM_callJS('history.go(-1)')" value="VOLVER" />
          <?
	  } ?>	  
	  
	  </label>
    </div></td>
  </tr>
</table>
<br />
<form name="form1" method="post" action="proceso_encuesta.php?op=<?=$op ?>">
  <table width="500" align="center">
    <tr>
      <td width="30%">Pregunta</td>
      <td><textarea name="pregunta" cols="30" rows="3" id="pregunta"><?=$p ?>
      </textarea></td>
    </tr>
    <tr>
      <td colspan="2"><table width="500" align="center" id="mytable">
          <tr>
            <td width="30%">option 1</td>
            <td><input name="opt[1]" value="<?=$opcion[0] ?>" size="40" />
            <input type="hidden" name="votos[1]" value="<?=$votos[1] ?>" /></td>
          </tr>
          <tr>
            <td>option 2</td>
            <td><input name="opt[2]" value="<?=$opcion[1] ?>" size="40" />
			<input type="hidden" name="votos[2]" value="<?=$votos[2] ?>" /></td>
          </tr>
          <tr>
            <td>option 3</td>
            <td><input name="opt[3]" value="<?=$opcion[2] ?>" size="40" />
			<input type="hidden" name="votos[3]" value="<?=$votos[3] ?>" /></td>
          </tr>
		  <?
		  if ($op == "e"){
		     $i = 3; $j = 3; $k = 4;
             while ($i < $contopt){
			    ?>
			    <tr>
                 <td>option <?=$k?></td>
                 <td><input name="opt[<?=$k ?>]" value="<?=$opcion[$i] ?>" size="40" />
				 <input type="hidden" name="votos[<?=$k ?>]" value="<?=$votos[$k] ?>" /></td>
                </tr>
		        <?
				$i++; $j++; $k++;
			 }
		  }
		  ?>  
      </table></td>
    </tr>
    <tr>
      <td colspan="1"><div align="left"><a href="javascript:;" onclick="insRow();">Agregar opcion</a></div></td>
      <td colspan="1"><div align="right"><a href="javascript:;" onclick="delRow();">Eliminar opcion</a></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center"><br />
          <input name="id_encuesta" type="hidden" id="id_encuesta" value="<?=$id_encuesta ?>" />
      </div>
        <label>
        <div align="center">
          <input name="ingresarencuesta" type="submit" id="ingresarencuesta" value="INGRESAR ENCUESTA" />
        </div>
      </label></td>
    </tr>
  </table>
</form>
</body>
</html>
