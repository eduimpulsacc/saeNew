<? 
require("../../util/header.php");
require("mod_escala.php");

$funcion = $_POST['funcion'];

$ob_escala = new Escala();


if($funcion==1){
	$rs_escala = $ob_escala->Listado($conn,$ano);
?>


<table width="90%" border="0" align="center"  class="tablaredonda">
	<tr >
        <td class="tablaredonda cuadro01">NOMBRE</td>
        <td class="tablaredonda cuadro01">INICIO</td>
        <td class="tablaredonda cuadro01">TERMINO</td>
        <td class="tablaredonda cuadro01">OPCIONES</td>
    </tr>
    <? 
	if(pg_numrows($rs_escala)==0){?>
    <tr>
      <td colspan="4" class="textosimple">&nbsp;NO EXISTEN REGISTROS</td>
  </tr>
    <? }
	for($i=0;$i<pg_numrows($rs_escala);$i++){
			$fila = pg_Fetch_array($rs_escala,$i);
	?>
	<tr>
        <td class="textosimple">&nbsp;<?=$fila['nombre'];?></td>
        <td class="textosimple">&nbsp;<?=$fila['inicio'];?></td>
        <td class="textosimple">&nbsp;<?=$fila['termino'];?></td>
        <td>&nbsp;<a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Modify.png"  onclick="modifica(<?=$fila['id_escala'];?>)"/></a>
        <a href="#">
        <img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Delete.png"  onclick="eliminar(<?=$fila['id_escala'];?>);"/>
        </a></td>
	</tr>
    <? } ?>
</table>
<?	
}

if($funcion==2){

?><meta http-equiv="Content-Type" content="text/html; charset=latin9" />
	<table width="90%" border="0" class="tablaredonda">
  <tr>
    <td colspan="3" class="textonegrita">ESCALA DE EVALUACI&Oacute;N</td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
  <tr>
    <td class="textonegrita">NOMBRE</td>
    <td class="textonegrita">:</td>
    <td><label for="textfield"></label>
    <input type="text" name="txtNOMBRE" id="txtNOMBRE" class="input_redondo"></td>
  </tr>
  <tr>
    <td class="textonegrita">NOTA MINIMA</td>
    <td class="textonegrita">:</td>
    <td><input name="txtMINIMO" type="text" id="txtMINIMO" size="5" maxlength="2" class="input_redondo"></td>
  </tr>
  <tr>
    <td height="24" class="textonegrita">NOTA MAXIMA</td>
    <td class="textonegrita">:</td>
    <td><input name="txtMAXIMO" type="text" id="txtMAXIMO" size="5" maxlength="2" class="input_redondo"></td>
  </tr>
</table>

<?    
}

if($funcion==3){
	$rs_guarda = $ob_escala->GuardarEscala($conn,$ano,$nombre,$minimo,$maximo);

	if($rs_guarda){
		echo 1;
	}else{
		echo 0;	
	}
}

if($funcion==4){
	$rs_elimina = $ob_escala->EliminaEscala($conn,$escala);
	
	if($rs_elimina){
		echo 1;	
	}else{
		echo 0;
	}
	
}

if($funcion==5){
	$rs_escala = $ob_escala->BuscaEscala($conn,$escala);
	$fila = pg_fetch_array($rs_escala,0);
?>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
	<table width="90%" border="0" class="tablaredonda">
  <tr>
    <td colspan="3" class="textonegrita">ESCALA DE EVALUACI&Oacute;N</td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
  <tr>
    <td class="textonegrita">NOMBRE</td>
    <td class="textonegrita">:</td>
    <td><label for="textfield"></label>
    <input type="text" name="txtNOMBRE" id="txtNOMBRE" class="input_redondo" value="<?=$fila['nombre'];?>"></td>
  </tr>
  <tr>
    <td class="textonegrita">NOTA MINIMA</td>
    <td class="textonegrita">:</td>
    <td><input name="txtMINIMO" type="text" id="txtMINIMO" size="5" maxlength="2" class="input_redondo" value="<?=$fila['inicio'];?>"></td>
  </tr>
  <tr>
    <td height="24" class="textonegrita">NOTA MAXIMA</td>
    <td class="textonegrita">:</td>
    <td><input name="txtMAXIMO" type="text" id="txtMAXIMO" size="5" maxlength="2" class="input_redondo" value="<?=$fila['termino'];?>"></td>
  </tr>
</table>
<?	
}

if($funcion==6){
	$rs_modifica = $ob_escala->ModifcaEscala($conn,$escala,$ano,$nombre,$minimo,$maximo);
	
	if($rs_modifica){
		echo 1;
	}else{
		echo 0;	
	}
}
?>
