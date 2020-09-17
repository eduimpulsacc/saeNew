<? 
require('util/header.inc');

$sql="select * from encuesta.encuestas e where estado=true and id_perfil=".$_PERFIL;
$rs_encuesta = pg_exec($connection,$sql);
$nombre_encuesta = pg_result($rs_encuesta,1);
$id_encuesta = pg_result($rs_encuesta,0);

$sql="select * from encuesta.preguntas_encuesta pe where pe.id_enc=".$id_encuesta;
$rs_pregunta = pg_exec($connection,$sql);

$sql="SELECT count(*) as contador FROM encuesta.respuestas_encuestas re
WHERE re.for_id_preg in (SELECT id_preg FROM encuesta.preguntas_encuesta pe
INNER JOIN encuesta.encuestas e ON pe.id_enc=e.id_enc WHERE e.id_enc=".$id_encuesta." and estado=true)
AND rdb=".$_INSTIT." AND id_perfil=".$_PERFIL." AND re.rut_usuario=".$_NOMBREUSUARIO." AND re.id_ano=".$_ANO;
$rs_existe = pg_exec($connection,$sql);
$existe = pg_result($rs_existe,0);
if($existe > 0){
		echo "<script>window.close()</script>";		
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>www.colegiointeractivo.com</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; }
.Estilo3 {color: #FF0000}
body {
	background-color: #f5f5f5;
}
-->
</style>
</head>

<body>
<form name="form" action="proceso_encuesta.php" method="post">
<table width="650" border="1" style="border-collapse:collapse"> 
  <tr>
    <td>
    <br />
    <table width="90%" border="1" style="border-collapse:collapse" align="center">
  <tr>
    <td colspan="4" align="center"  class="tableindex">&nbsp;<?=$nombre_encuesta;?></td>
    </tr>
  <tr>
    <td colspan="4" align="right"><input type="submit" name="GUARDAR" id="GUARDAR" value="GUARDAR"  class="botonXX"/></td>
    </tr>
  <tr class="tablatit2-1">
      <td width="7%" class="textonegrita">N&ordm;</td>
    <td width="55%">Pregunta</td>
    <td width="9%">Nota</td>
    <td width="29%">Observacion</td>
    </tr>
    <? for($i=0;$i<pg_numrows($rs_pregunta);$i++){
			$fila =pg_fetch_array($rs_pregunta,$i);
	?>	
    <input type="hidden" name="id_pregunta<?=$i;?>"  value="<?=$fila['id_preg'];?>"/>
  <tr>
    <td class="textosimple">&nbsp;<?=$i+1;?></td>
    <td class="textosimple">&nbsp;<?=$fila['pregunta'];?></td>
    <td class="textosimple">&nbsp;
    	<? $sql="SELECT id_tip_resp FROM encuesta.relacion_preg_tip_resp WHERE id_preg=".$fila['id_preg']." AND id_tip_resp=1";
			$rs_tipo = pg_exec($connection,$sql);
			
			if(pg_numrows($rs_tipo)!=0){
		?>
        <select name="cmbNOTA<?=$i;?>">
        	<option value="7">7</option>
            <option value="6">6</option>
            <option value="5">5</option>
            <option value="4">4</option>
            <option value="3">3</option>
            <option value="2">2</option>
        	<option value="1">1</option>
        </select>
        <? } ?>
    </td>
    <td class="textosimple">
    <? $sql="SELECT id_tip_resp FROM encuesta.relacion_preg_tip_resp WHERE id_preg=".$fila['id_preg']." AND id_tip_resp=2";
	   $rs_tipo = pg_exec($connection,$sql);
			
			if(pg_numrows($rs_tipo)!=0){
		?>
    	<textarea name="cmbOBS<?=$i;?>" cols="" rows=""></textarea>
    	<? } ?>
    </td>
    </tr>
    <? } ?>
    </table>
<br />
</td>
  </tr>
</table>
<input type="hidden" name="contador" value="<?=$i;?>" />
</form>
</body>
</html>
