
<?
require('../../../util/header.inc');
require('modGrupo.php');

$ob_grupo = new Grupo();


foreach($_POST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
}

if($funcion==1){
	$rs_ense= $ob_grupo->getEnsenanza($conn,$ano);
	$nano =  $ob_grupo->nroAno($conn,$ano);
	?>
    <input type="hidden" id="nano" value="<?php echo $nano ?>" />
    <select name="ense" id="ense" onChange="getNivel(this.value);">
    <option value="0">Seleccione tipo ense&ntilde;anza</option>
    <?php for($e=0;$e<pg_numrows($rs_ense);$e++){
		$fila_ense = pg_fetch_array($rs_ense,$e);
		?>
    <option value="<?php echo $fila_ense['ensenanza'] ?>"><?php echo $fila_ense['nombre_tipo'] ?></option>
    <?php }?>
    </select>
    <?
}
if($funcion==2){
	$rs_nivel= $ob_grupo->getNivel($conn,$ano,$ensenanza);
	?>
    <select name="nivel" id="nivel" onChange="getAsig(this.value);">
    <option value="0">Seleccione nivel</option>
    <?php for($e=0;$e<pg_numrows($rs_nivel);$e++){
		$fila_nivel = pg_fetch_array($rs_nivel,$e);
		?>
    <option value="<?php echo $fila_nivel['grado_curso'] ?>"><?php echo $fila_nivel['grado_curso'] ?>&deg; A&Ntilde;O</option>
    <?php }?>
    </select>
    <?
}
if($funcion==3){
	
    $rs_asig= $ob_grupo->getAsignatura($conn,$ano,$ensenanza,$nivel);
	?>
    <select name="asignatura" id="asignatura" onChange="activaBC()">
    <option value="0">Seleccione Asignatura</option>
    <?php for($e=0;$e<pg_numrows($rs_asig);$e++){
		$fila_asig = pg_fetch_array($rs_asig,$e);
		?>
    <option value="<?php echo $fila_asig['cod_subsector'] ?>"><?php echo $fila_asig['nombre'] ?></option>
    <?php }?>
    </select>
    <?
}
if($funcion==4){
?>
<input type="button" value="Ver Grupos" class="botonXX" onclick="muestraCreaGrupo();">
<?
}
if($funcion==5){
	$rs_listado=$ob_grupo->tablaGrupo($conn,$ano,$ensenanza,$nivel,$asig);
	?>
   
<table width="98%" border="1" id="conte" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

  <tr class="tablatit2-1">
   
    <td width="28%" height="42" align="center" valign="middle">Leccionario</td>
    <td width="12%" align="center" valign="middle">Porcentaje</td>
    <td width="14%" align="center" valign="middle">Casilla</td>
    <td width="14%" align="center" valign="middle">Orden</td>
    <td width="16%" align="center" valign="middle">Acciones</td>
  </tr><?php  if(pg_numrows($rs_listado)>0){?>
 <?php  for($l=0;$l<pg_numrows($rs_listado);$l++){
	 $cas="";
	 $fila = pg_fetch_array($rs_listado,$l);
	 $pac= $pac+$fila['porcentaje'] ;
	 ?>
  <tr id="fila<?php echo $fila['id_grupo'] ?>" class="textosimple">
   
    <td height="33"><?php echo $fila['nombre'] ?></td>
    <td align="center"><?php echo $fila['porcentaje'] ?> <input type="hidden" class="prco" value="<?php echo $fila['porcentaje'] ?>" /></td>
    <td><?php for($n=1;$n<=19;$n++){?>
	<?php $cas.= ($fila['nota'.$n]==1)?$n.",":""; ?>
	<?php }?>
	<?php echo substr($cas,0,-1) ?></td>
    <td align="center"><?php echo $fila['orden'] ?></td>
    <td align="center"><input type="button" name="button" id="button" class="botonXX btne" value="Editar" onclick="edifila(<?php echo $fila['id_grupo'] ?>)" /> <input type="button" name="button" id="button" class="botonXX btne" value="Eliminar" onclick="elifila(<?php echo $fila['id_grupo'] ?>)" /></td>
  </tr>

  <?php }?>
  <?php }?> 
  
</table>
<br />
<table width="98%" border="1"  cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="textosimple">
 <tr>
    <td  width="58%">Porcentaje Acumulado</td>
    <td width="12%" align="center" ><?php echo $pac ?>%</td>
    <td width="30%" align="center" >&nbsp;</td>
  </tr>
</table>
 <br />
 <?php if($pac<100){?>
 <input name="input" type="button" value="Crear Grupo" onclick="ngr(<?php echo $curso ?>)" class="botonXX" /><br />
 <?php }?>
<br />
<br />
<?php if($pac==100){?>
<input name="input" type="button" value="Asignar grupos" onclick="asigG()" class="botonXX" />
<?php }?>
 <? }
 if($funcion==6){
	 
	 $maxorden =  $ob_grupo->getOrdenGrupo($conn,$ano,$ensenanza,$nivel,$subsector);
	 ?>
     
<tr class="textosimple">
  
    <td height="33"><input name="txtLECCIONARIO" type="text" id="txtLECCIONARIO" size="50"  /></td>
    <td height="3" align="center"><input name="prc" type="text" id="prc" size="2" class="prco" /></td>
    <td><?php for($n=1;$n<=19;$n++){
		$rs_marca = $ob_grupo->veMarca($conn,$ano,$ensenanza,$nivel,$subsector,$n);
		
		
		 $vis = (pg_result($rs_marca,0)==1)?' style="display:none"':""; 
		
		?><span <?php echo $vis ?>><input name="n<?php echo $n?>" id="n<?php echo $n?>"  type="checkbox" value="" class="grn" />Nota <?php echo $n ?><br /></span>
  <?php }?></td>
    <td align="center"><input name="orden" type="text" id="orden" value="<?php echo (pg_result($maxorden,0)+1) ?>" size="2" class="solo-numero" /></td>
    <td><input type="button" value="Guardar" class="botonXX" onclick="guardaGrupo();" /></td>
</tr>
 <?
	 }
	 
if($funcion==7){
	
	//show($_POST);
	$rs_guarda=$ob_grupo->guardaGrupo($conn,$_ANO,$porcentaje,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12,$n13,$n14,$n15,$n16,$n17,$n18,$n19,0,utf8_decode($leccionario),$ensenanza,$nivel,$subsector,$orden);
echo ($rs_guarda)?1:0;

}
if($funcion==8){
	//show($_POST);
$rs_fila = $ob_grupo->tablaGrupoDet($conn,$grupo);
	$fila = pg_fetch_array($rs_fila,0);
	?>
	<td height="33"><input name="txtLECCIONARIO" type="text" id="txtLECCIONARIO"  value="<?php echo $fila['nombre']; ?>" size="50"/></td>
  <td height="3" align="center"><input name="prc" type="text" id="prc" class="prco" size="2" value="<?php echo $fila['porcentaje'] ?>" /></td>
  <td class="textosimple"><?php for($n=1;$n<=19;$n++){
		 $rs_marca = $ob_grupo->veMarca($conn,$ano,$ensenanza,$nivel,$subsector,$n,$grupo);
		?><input name="n<?php echo $n?>" id="n<?php echo $n?>" type="checkbox" value="" class="grn" <?php echo ($fila['nota'.$n]==1)?'checked':"" ?> <?php echo (pg_result($rs_marca,0)==1)?'style="visibility:hidden"':""  ?> />Nota <?php echo $n ?><br />
  <?php }?></td>
   <td align="center"><input name="orden" type="text" id="orden" value="<?php echo $fila['orden'] ?>" size="2" class="solo-numero" /></td>
  <td><input name="idg" type="hidden" id="idg" value="<?php echo $fila['id_grupo'] ?>" /><input name="" type="button" value="Guardar" class="botonXX" onclick="guardaGrupoEdi();" />&nbsp;<input type="button" name="button" id="button" value="Cancela Edici&oacute;n" class="botonXX" onclick="muestraCreaGrupo();" /></td>
<? }
if($funcion==9){

$rs_guarda=$ob_grupo->actualizaGrupo($conn,$grupo,$porcentaje,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12,$n13,$n14,$n15,$n16,$n17,$n18,$n19,0,utf8_decode($leccionario),$orden);
echo ($rs_guarda)?1:0;
}
if($funcion==10){
$rs_eli=$ob_grupo->borraGrupo($conn,$grupo);
$ob_grupo->borraGrupoFrom($conn,$grupo);
echo ($rs_eli)?1:0;
}
if($funcion==11){


$rs_listado=$ob_grupo->tablaGrupo($conn,$_ANO,$ensenanza,$nivel,$subsector);
 for($g=0;$g<pg_numrows($rs_listado);$g++){
$fila_grupo = pg_fetch_array($rs_listado,$g);
$grupo=$fila_grupo['id_grupo'];
//borro los grupos que tienen este id de grupo
 $ob_grupo->borraGrupoFrom($conn,$grupo);
}

//reviso los cursos que no tienen activado los grupos para activarlos
$ramosingupo = $ob_grupo->ramoGR($conn,$_ANO,$ensenanza,$nivel,$subsector,0);
for($rs=0;$rs<pg_numrows($ramosingupo);$rs++){
$fila=pg_fetch_array($ramosingupo,$rs);
$id_ramos = $fila['id_ramo'];
$curso = $fila['id_curso'];
$ob_grupo->activaGrupo($conn,$id_ramos);

//pego los grupos de notas
$rs_pego = $ob_grupo->PegaGrupo($conn,$_ANO,$ensenanza,$nivel,$subsector,$curso,$id_ramos);




}

//reviso los ramos que si tienen grupo de notas activado pero no tienen grupos, y para eso tengo que revisar todos los cursos de la asignatura
$rs_curso = $ob_grupo->listaCurso($conn,$_ANO,$ensenanza,$nivel);
for($c=0;$c<pg_numrows($rs_curso);$c++){
$fila_curso  = pg_fetch_array($rs_curso,$c);
$curso = $fila_curso['id_curso'];
$rs_ramo = $ob_grupo->getIdRamo($conn,$curso,$subsector);
$id_ramo = pg_result($rs_ramo,0);
$rs_grupoC=$ob_grupo->countGrupoforRamo($conn,$id_ramo);

//$rs_grupo = $ob_grupo->tablaCurso($conn,$curso);

//si no le encuentro nada, voy a pegar los grupos
if(pg_numrows($rs_grupoC)==0){
	$rs_pego = $ob_grupo->PegaGrupo($conn,$_ANO,$ensenanza,$nivel,$subsector,$curso,$id_ramo);

}


$modo_eval = pg_result($rs_ramo,1);
$truncado = pg_result($rs_ramo,2);
$aprox_grupo = pg_result($rs_ramo,3);
$aprox_entero = pg_result($rs_ramo,4);
//busco las posiciones para calcular promedio
$sumagrop=0;

	
	$rs_periodo = $ob_grupo->getPeriodos($conn,$_ANO);
	
	//lista de alumnos de la asignatura
	$rs_alu =  $ob_grupo->alumnosInscritos($conn,$nano,$id_ramo);
	
	//recorre alumnos
	for($al=0;$al<pg_numrows($rs_alu);$al++){
		$fila_alumno = pg_fetch_array($rs_alu,$al);
		$alumno = $fila_alumno['rut_alumno'];
	//recorre periodos
	for($p=0;$p<pg_numrows($rs_periodo);$p++){
		$fila_periodo = pg_fetch_array($rs_periodo,$p);	
		$id_periodo = $fila_periodo['id_periodo'];
		
		//recorre grupos
		for($gp=0;$gp<pg_numrows($rs_grupoC);$gp++){
		
		$fila_gr = pg_fetch_array($rs_grupoC,$gp);
	//echo "porcentaje->".
		$porc=$fila_gr['porcentaje']/100;
		
		
		$cad_grp="";
		$cuengrp=0;
	
		
			for($nog=1;$nog<=19;$nog++){
				if($fila_gr['nota'.$nog]==1){
				$rsln=$ob_grupo->getNotaPosicion($conn,$nano,$nog,$id_ramo,$id_periodo,$alumno);
				$nota = pg_result($rsln,0);
				if(strlen($nota)>0 && trim($nota) !='0'){
					
					if( $aprox_entero ==1 && $modo_eval == 1 ){
					$conv = aprox_entero( $nota );
					$notagr[$alumno][$id_periodo][$fila_gr['id_grupo']][]=$conv;
				  }
					elseif($modo_eval==1 || $modo_eval==3){
					//echo "num->".$modo_eval;
						$notagr[$alumno][$id_periodo][$fila_gr['id_grupo']][]=$nota;
					}
					elseif($modo_eval==2 || $modo_eval==4){
						//echo "conc->".$modo_eval;
						$conv =  Conceptual($nota, 2);
						$notagr[$alumno][$id_periodo][$fila_gr['id_grupo']][]=$conv;
					}
					elseif($modo_eval==5){
						$conv = $ob_grupo->desifranotaconseptualN($conn,$id_ano,$_INSTIT,$nota);
						$notagr[$alumno][$id_periodo][$fila_gr['id_grupo']][]=$conv;
						//echo "esp->".$modo_eval;
					}
			
				}
				
				}
			
			}
			
			$red = ($aprox_grupo==1)?"round":"intval";
		$notap[$alumno][$id_periodo][]=($red(array_sum($notagr[$alumno][$id_periodo][$fila_gr['id_grupo']])/count($notagr[$alumno][$id_periodo][$fila_gr['id_grupo']])))*$porc;	
		}
		
		$rpa = ($truncado==1)?"round":"intval";
		//$prom_alu[$alumno][$id_periodo][]=$rpa(array_sum($notap[$alumno][$id_periodo]));
		if(count($notap[$alumno][$id_periodo])>0){
		
		//echo "\n$alumno->".
		$prom_alu = $rpa(array_sum($notap[$alumno][$id_periodo]));
		
		//convertir promedio de conceptual o numerico conceptual
		if ($modo_eval==1 || $modo_eval==4){
			$prom_aluA =$prom_alu;
			}
		elseif($modo_eval==2 || $modo_eval==3){
			$prom_aluA =  Conceptual($prom_alu, 1);
			}
		elseif ($modo_eval==5){
			$prom_aluA = $ob_grupo->desifranotaconseptualN($conn,$id_ano,$_INSTIT,$prom_alu);
			}
		
			
			if($prom_alu){
			$actProm = $ob_grupo->actPromedio($conn,$nano,$alumno,$id_ramo,$id_periodo,$prom_aluA);
			}
		}
				
		
	}
	
	
	


}
//show($prom_alu);


}



//echo $lg = substr($lg,0,-1);


/*$rs_ramo= $ob_grupo->listaRamo($conn,$ano,$ensenanza,$nivel,$asig);*/
}
?>