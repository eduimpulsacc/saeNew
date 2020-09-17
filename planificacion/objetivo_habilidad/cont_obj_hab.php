<?
session_start();
require("../../util/header.php");
require("mod_obj_hab.php");

$funcion = $_POST['funcion'];

$ob_objeto = new Objetivo_Habilidad();


if($funcion==1){
	$rs_listado = $ob_objeto->listado($conn,$tipo,$eje,$grado,$ense);
?>
<table width="650" border="0">
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
</table>

<table width="727" border="0" >
  <tr>
    <td width="62" align="center" class="tableindexredondo">C&oacute;digo</td>
    <td width="501" align="center" class="tableindexredondo">Texto</td>
    <td colspan="2" align="center" class="tableindexredondo">Acciones</td>
  </tr>
<? for($i=0;$i<pg_numrows($rs_listado);$i++){
		$fila= pg_fetch_array($rs_listado,$i);
		
		if(($i % 2)==0){
			$estilo="detalleoff";	
		}else{
			$estilo="detalleon";
		}
?>
  <tr>
    <td class="<?=$estilo;?>"><?=$fila['codigo'];?></td>
    <td class="<?=$estilo;?>"><?=nl2br($fila['texto']);?></td>
    <td width="73" align="center" ><img src="../../admin/clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/edit.png" width="24" height="24" onclick="EdOb(<?=$fila['id_obj'];?>)" /></td>
    <td width="73" align="center" ><img src="../../admin/clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Delete.png" width="24" height="24" onclick="DelOb(<?=$fila['id_obj'];?>)" /></td>
  </tr>
 <? } ?>
</table>

<?
}
if($funcion==2){
	$rs_ejes = $ob_objeto->ejes($conn,0);
	$rs_tipos = $ob_objeto->tipoEnse($conn);
	$rs_subsector= $ob_objeto->subsector($conn);
	$rs_tipo = $ob_objeto->listaTipoObj($conn);
?>
<table width="650" border="0">
  <tr>
    <td class="tableindexredondo">&nbsp;MODULO DE OBJETIVOS Y HABILIDADES</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;<input name="GUARDAR" type="button" class="botonXX" onClick="guardar();" value="GUARDAR" /><input name="VOLVER" type="button" class="botonXX" value="VOLVER" />
  </tr>
</table>

<table width="650" border="1" style="border-collapse:collapse">
  <tr>
    <td class="cuadro02">CODIGO</td>
    <td align="center" class="cuadro02">:</td>
    <td class="cuadro01">&nbsp;<input type="text" name="txtCODIGO" id="txtCODIGO" style="text-transform:uppercase" onBlur="existeCodigo()" class="input_redondo"></td>
  </tr>
  <tr>
    <td class="cuadro02">TIPO</td>
    <td align="center" class="cuadro02">:</td>
    <td class="cuadro01"><select name="obj_hab" id="obj_hab" class="select_redondo">
    <?php for($i=0;$i<pg_numrows($rs_tipo);$i++){ 
	$fila = pg_fetch_array($rs_tipo,$i);
	?>
    <option value="<?php echo $fila['id_objetivo'] ?>"><?php echo $fila['nombre'] ?></option>
    
    <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="cuadro02">TIPO ENSE&Ntilde;ANZA</td>
    <td align="center" class="cuadro02">:</td>
    <td class="cuadro01"><select name="cmbENSE" id="cmbENSE" class="select_redondo" style="width:250px" onChange="gradoEnse()">
                <option value="0">seleccione...</option>
                <?php if($_PERFIL==0){
				$sql_ense = "select * from tipo_ensenanza order by cod_tipo";
				}else{
					 $sql_ense = "select distinct(cod_tipo),nombre_tipo from tipo_ensenanza
						inner join curso on curso.ensenanza = tipo_ensenanza.cod_tipo
						where id_ano=".$_ANO."
						order by cod_tipo";
				}
				$rs_ense = pg_exec($conn,$sql_ense);
					for($e=0;$e<pg_numrows($rs_ense);$e++){
						$fila_ense = pg_fetch_array($rs_ense,$e);
				
				?>
                
                  <option value="<?php echo $fila_ense['cod_tipo'] ?>">(<?php echo $fila_ense['cod_tipo'] ?>) <?php echo $fila_ense['nombre_tipo'] ?></option>
                  <?php }?>
                  </select></td>
  </tr>
  <tr>
    <td class="cuadro02">GRADO</td>
    <td align="center" class="cuadro02">:</td>
    <td class="cuadro01"> <div id="gra">
                  <select name="cmbGRADO" id="cmbGRADO" class="select_redondo" >
                    <option value="0">seleccione...</option>
                    
                  </select>
                </div></td>
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
    <td class="cuadro02">C&oacute;d. subsector</td>
    <td align="center" class="cuadro02">:</td>
    <td class="cuadro01" valign="baseline">
    <input type="text" id="subs" name="subs" onchange="ejes()" onblur="veramo()" class="input_redondo"/>
    </td>
  </tr>
  <tr>
    <td class="cuadro02">Eje</td>
    <td align="center" class="cuadro02">:</td>
    <td class="cuadro01" valign="baseline">
    <span id="combeje">
    <select name="cmbEJE" id="cmbEJE" class="select_redondo">
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
    <td class="cuadro02">TEXTO</td>
    <td align="center" class="cuadro02">:</td>
    <td class="cuadro01">&nbsp;<textarea name="texto" id="arTEXTO" cols="60" rows="5"></textarea></td>
  </tr>
</table><br />


<?		
}

if($funcion==3){
	if($_PERFIL==0){
		$rdb=0;
	}else{
		$rdb=$_INSTIT;	
	}
	$rs_objetivo = $ob_objeto->Guardar($conn,$codigo,$tipo,$eje,$texto,$rdb,$ense,$grado,$bbd);
	
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
	/*$rs_obj = $ob_objeto->exobj($conn,$cadena);
	if(pg_numrows($rs_obj)>0){
	echo 1;
	}else{*/
	echo 0;
	//}
	
}
if($funcion==6){
$rdb=($_PERFIL==0)?0:$_INSTIT;	
$rs_subsector= $ob_objeto->subsector($conn);
$rs_tipo = $ob_objeto->listaTipoObj($conn);
?>
<input type="hidden" name="rbd" id="rbd" value="<?php echo $rdb ?>"/>
Tipo Eje
 <select name="obj_hab2" id="obj_hab2" class="select_redondo">
    <?php for($i=0;$i<pg_numrows($rs_tipo);$i++){ 
	$fila = pg_fetch_array($rs_tipo,$i);
	?>
    <option value="<?php echo $fila['id_objetivo'] ?>"><?php echo $fila['nombre'] ?></option>
    
    <?php }?>
    </select>  <br />
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
	//$ob_objeto->variaCon($_ID_BASE);
	
	$rs_guarda= $ob_objeto->guardaEje($conn,$nombre,$tipo,$rbd,$codramo,$bbd);
	//$rs_guarda= $ob_objeto->guardaEje($ob_objeto->conn2,$nombre,$tipo,$rbd,$codramo);
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

if($funcion==11){
	$rs_eje = $ob_objeto->BuscarEje($conn,$cod_subsector,$tipo);
?>
<select name="cmbEJE" id="cmbEJE" class="select_redondo" onchange="listado()">
	<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_eje);$i++){
		$fila = pg_fetch_array($rs_eje,$i);
?>
	<option value="<?=$fila['id_eje'];?>"><?=$fila['texto'];?></option>
<?	}
}if($funcion==13){
	if($_PERFIL==0){	
	 $rs_gra = $ob_objeto->listadoGradoEnse($conn,$ense);
	}else{
	 $rs_gra = $ob_objeto->listadoGradoEnseINS($conn,$ense,$ano);
	}
?>
<select name="cmbGRADO" id="cmbGRADO" class="select_redondo" onchange="ramoGrado()" >
	<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_gra);$i++){
		$fila = pg_fetch_array($rs_gra,$i);
?>
	<option value="<?=$fila['grado_curso'];?>"><?=$fila['grado_curso'];?> A&Ntilde;O</option>
<?	}
?>
</select>
<?
}if($funcion==14){
	if($_PERFIL==0){	
	 $rs_asig = $ob_objeto->listaRamoADM($conn,$ense,$grado);
	}else{
	 $rs_asig = $ob_objeto->listaRamoINS($conn,$ense,$ano,$grado);
	}
	
	?>
<select id="cmbASIGNATURA" name="cmbASIGNATURA" class="select_redondo" onChange="BuscaEje();">
                	<option value="0">seleccione...</option>
                <?	
					
					for($i=0;$i<pg_numrows($rs_asig);$i++){
						$fila = pg_fetch_array($rs_asig,$i);
				?>
                	<option	value="<?=$fila['cod_subsector'];?>"><?=$fila['nombre']."(".$fila['cod_subsector'].")";?></option>
                <? } ?>
                </select>
                <?
}
if($funcion==15){
	$rs_tipo = $ob_objeto->listaTipoObj($conn);
?>
    <select name="cmbTIPO" id="cmbTIPO" class="select_redondo">
    <?php for($i=0;$i<pg_numrows($rs_tipo);$i++){ 
	$fila = pg_fetch_array($rs_tipo,$i);
	?>
    <option value="<?php echo $fila['id_objetivo'] ?>"><?php echo $fila['nombre'] ?></option>
    
    <?php }?>
    </select>  
<?
}
if($funcion==16){
	//show($_POST);
	$rs_del =$ob_objeto->ocObj($conn,$obj,$_ID_BASE);
	echo($rs_del)?1:0;
	}
if($funcion==17){
//	show($_POST);
	$rs_data = $ob_objeto->Dobj($conn,$obj);
	$fila_obj = pg_fetch_array($rs_data,0);
	?>
    <table width="529" border="1" style="border-collapse:collapse">
  <tr>
    <td width="81" class="cuadro02">CODIGO</td>
    <td width="5" align="center" class="cuadro02">:</td>
    <td width="421" class="cuadro01">&nbsp;<input type="text" name="txtCODIGO" id="txtCODIGO" style="text-transform:uppercase" onBlur="existeCodigo()" class="input_redondo" value="<?php echo $fila_obj['codigo'] ?>">
    <input type="hidden" name="iobj" id="iobj" value="<?php echo $fila_obj['id_obj'] ?>" /></td>
  </tr>
    <tr>
    <td class="cuadro02">TEXTO</td>
    <td align="center" class="cuadro02">:</td>
    <td class="cuadro01">&nbsp;<textarea name="texto" id="arTEXTO" cols="60" rows="5"><?php echo $fila_obj['texto'] ?></textarea></td>
  </tr>

  </table>
    <?
	}
if($funcion==18){
	//show($_POST);
	$rs_existe = $ob_objeto->exobj2($conn,$cod,$obj);
	
	if(pg_numrows($rs_existe)>0){
	echo 2;	
	}
	else{
		$rs_up = $ob_objeto->updObj($conn,$obj,utf8_decode($cod),utf8_decode($txt),$_ID_BASE);
		echo($rs_up)?1:0;
	}
	
	}
?>
