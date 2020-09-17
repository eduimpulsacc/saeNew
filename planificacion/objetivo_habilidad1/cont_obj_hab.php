
<?
require("../../util/header.php");
require("mod_obj_hab.php");

$funcion = $_POST['funcion'];

$ob_objeto = new Objetivo_Habilidad();


if($funcion==1){
	$rs_listado = $ob_objeto->listado($conn);
?>
<table width="650" border="0">
  <tr>
    <td align="right"><a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" border="0" onclick="agregar()" /></a></td>
  </tr>
</table>

<table width="650" border="1" style="border-collapse:collapse">
  <tr>
    <td>codigo</td>
    <td>Objetivo/Habilidad</td>
    <td>texto</td>
    <td>tipo</td>
    <td>asignatura</td>
  </tr>
<? for($i=0;$i<pg_numrows($rs_listado);$i++){
		$fila= pg_fetch_array($rs_listado,$i);
?>
  <tr>
    <td>&nbsp;<?=$fila['codigo'];?></td>
    <td>&nbsp;<?=$fila['textoeje'];?></td>
    <td>&nbsp;<?=$fila['texto_oh'];?></td>
    <td>&nbsp;<?=$fila['nombre_tipo'];?></td>
    <td>&nbsp;<?=$fila['nombre'];?></td>
  </tr>
 <? } ?>
</table>

<?
}
if($funcion==2){
	$rs_ejes = $ob_objeto->ejes($conn,0);
	$rs_tipos = $ob_objeto->tipoEnse($conn);
	$rs_subsector= $ob_objeto->subsector($conn);
?>
<table width="650" border="0">
  <tr>
    <td class="textonegrita">&nbsp;MODULO DE OBJETIVOS Y HABILIDADES</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;<a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Save.png" width="24" height="24" border="0" onclick="guardar();" title="GUARDAR" />
      <img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Back.png" width="24" height="24" onclick="listado()" title="VOLVER" /> </a>
  </tr>
</table>

<table width="650" border="1" style="border-collapse:collapse">
  <tr>
    <td class="textonegrita">CODIGO</td>
    <td align="center" class="textonegrita">:</td>
    <td>&nbsp;<input type="text" name="txtCODIGO" id="txtCODIGO" style="text-transform:uppercase" onBlur="existeCodigo()"></td>
  </tr>
  <tr>
    <td class="textonegrita">TIPO</td>
    <td align="center" class="textonegrita">:</td>
    <td class="textosimple"><input type="radio" name="obj_hab" id="obj_hab0" value="0" onchange="ejes(0)">
      Objetivo 
        <input type="radio" name="obj_hab" id="obj_hab1" value="1" onchange="ejes(1)">
      <label for="obj_hab2">Habilidad      </label></td>
  </tr>
  
 <!-- <tr>
    <td class="textonegrita">Tipo Ense&ntilde;anza</td>
    <td align="center" class="textonegrita">:</td>
    <td class="textosimple" valign="baseline">
    <select id="tipense" name="tipense" onchange="gradoense()">
    <option value="0">Seleccione...</option>
   <?php  for($t=0;$t<pg_numrows($rs_tipos);$t++){
	   $fil_tipo = pg_fetch_array($rs_tipos,$t);
	   ?>
   <option value="<?php echo $fil_tipo['cod_tipo'] ?>"><?php echo $fil_tipo['nombre_tipo'] ?></option>
    <?php  }?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="textonegrita">Nivel</td>
    <td align="center" class="textonegrita">:</td>
    <td class="textosimple" valign="baseline">
    <div id="grados">
     <select name="gra" id="gra">
    	<option value="0">seleccione...</option>
        </select>
    </div>
    </td>
  </tr>-->
  <tr>
    <td class="textonegrita">C&oacute;d. subsector</td>
    <td align="center" class="textonegrita">:</td>
    <td class="textosimple" valign="baseline">
    <div id="ram"><input type="text" id="subs" name="subs" onchange="ejes()" onblur="veramo()"/></div>
    </td>
  </tr>
  <tr>
    <td class="textonegrita">Eje</td>
    <td align="center" class="textonegrita">:</td>
    <td class="textosimple" valign="baseline">
    <span id="combeje">
    <select name="cmbEJE" id="cmbEJE">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_ejes);$i++){
				$fila_eje = pg_fetch_array($rs_ejes,$i);
		?>
        <option value="<?=$fila_eje['id_eje'];?>"><?=$fila_eje['texto'];?></option>	
		<? } ?>	
        </select>
        </span>
    &nbsp;<a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" border="0" title="AGREGAR OBJETIVO" onclick="agregar_obj()" /></a></td>
  </tr>
  <tr>
    <td class="textonegrita">TEXTO</td>
    <td align="center" class="textonegrita">:</td>
    <td>&nbsp;<textarea name="texto" id="arTEXTO" cols="60" rows="5"></textarea></td>
  </tr>
</table>

<?		
}

if($funcion==3){
	$rs_objetivo = $ob_objeto->Guardar($conn,$codigo,$tipo,$eje,$texto,$_INSTIT);
	
	if($rs_objetivo){
		echo 1;
	}else{
		echo 0;	
	}
}

if($funcion==4){
?>
<div id="tabs-1">
    <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
  </div>
  <div id="tabs-2">
    <p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
  </div>
  
<?	
}
if($funcion==5){
	$rs_obj = $ob_objeto->exobj($conn,$cadena);
	if(pg_numrows($rs_obj)>0){
	echo 1;
	}else{
	echo 0;
	}
	
}
if($funcion==6){
$rdb=($_PERFIL==0)?0:$_INSTIT;	
$rs_subsector= $ob_objeto->subsector($conn);
?>
<input type="hidden" name="rbd" id="rbd" value="<?php echo $rdb ?>"/>
Tipo Eje
<input type="radio" name="obj_hab2" value="0" onchange="activaBotonEje()">
      Objetivo 
        <input type="radio" name="obj_hab2" value="1" onchange="activaBotonEje()">
      <label for="obj_hab2">Habilidad      </label><br />
<br />
Nombre Eje
<input type="text" name="nomeje" id="nomeje" onchange="activaBotonEje()" style="text-transform:uppercase"/><br />
<br />
C&oacute;digo  
asignatura
<input type="text" id="codsubsector" name="codsubsector" onchange="activaBotonEje()" onblur="veramo2()"/>
<?	
	
}
if($funcion==7){
	//var_dump($_POST);
	$rs_guarda= $ob_objeto->guardaEje($conn,$nombre,$tipo,$rbd,$codramo);
	echo 1;
}
if($funcion==8){
	$rs_ejes = $ob_objeto->ejes($conn,$tipo,$subsector);
	?>
    <select name="cmbEJE" id="cmbEJE">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_ejes);$i++){
				$fila_eje = pg_fetch_array($rs_ejes,$i);
		?>
        <option value="<?=$fila_eje['id_eje'];?>"><?=strtoupper($fila_eje['texto']);?></option>	
		<? } ?>	
        </select>
    <?
}
if($funcion==9){
$rs_grado=$ob_objeto->gradosense($conn,$tipoense);
?>
 <select name="gra" id="gra">
 <option value="0">seleccione...</option>
 <?php for($t=0;$t<pg_numrows($rs_grado);$t++){
	 $fila_grado = pg_fetch_array($rs_grado,$t);
	 ?>
<option value="<?php echo $fila_grado['grado'] ?>"><?php echo $fila_grado['grado'] ?>&ordm; a&ntilde;o</option>
<?php }?>
</select>
<?
}
if($funcion==10){
	$rs_sub = $ob_objeto->existeSubsector($conn,$cadena);
	if(pg_numrows($rs_sub)==0){
	echo 0;
	}else{
	echo 1;
	}
}
?>
