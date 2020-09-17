<?

require("../../util/header.php");
require("mod_plani.php");

$funcion = $_POST['funcion'];

$ob_unidad = new Unidad();
session_start();


if($funcion==1){
	
	//$_CURSO = $crs;
	
	/*if(!$crs){
	$crs = $_CURSO;
	}*/
	
	
	if($_PERFIL==17){
		$rs_curso= $ob_unidad->cursoSsDocente($conn,$_NOMBREUSUARIO,$_INSTIT,$ano);
	
	}
	else{
		$rs_curso = $ob_unidad->traeCursos($conn,$ano);	
	}
	//exit;
	
?>	

<!--onchange="apoderado(this.value);"-->
<select name="sel_curso" id="sel_curso" onchange="traeRamo(this.value);traeEnse(this.value);" class="select_redondo" >
    	<option	value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila = pg_fetch_array($rs_curso,$i);
?>
		<option value="<?=$fila['id_curso'];?>" <?php echo ($fila['id_curso']==$_CURSO)?"selected":"" ?> ><?=CursoPalabra($fila['id_curso'], 0, $conn);?></option>
        	
<?	
		}
?>
</select>
<?
}


if($funcion==2){
	$_CURSO = $curso;
	
	if($_PERFIL!=17){
	$rs_ramo = $ob_unidad->traeRamo($conn,$curso);
	}else{
	//quiero ver si es profesor jefe
	$rs_super = $ob_unidad->esPJefe($conn,$_NOMBREUSUARIO,$curso) ;
	if(pg_numrows($rs_super )>0){
		$rs_ramo = $ob_unidad->traeRamo($conn,$curso);
	}else{
		$rs_ramo = $ob_unidad->ramosDct($conn,$_NOMBREUSUARIO,$curso);
		}
	}
	
	//exit;
	
?>	<!--onchange="apoderado(this.value);"-->
<select name="sel_ramo" id="sel_ramo" onchange="dicta(this.value);codigo(this.value)" class="select_redondo" >
    	<option	value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_ramo);$i++){
			$fila = pg_fetch_array($rs_ramo,$i);
?>
		<option value="<?=$fila['id_ramo'];?>" <?php echo  ($fila['id_ramo']==$_IDR)?"selected":""?>><?=$fila['nombre'];?></option>
        	
<?	
		}
?>
</select>
<?
}

if($funcion==3){
	
	$_IDR = $ramo;
	
	$rs_dicta = $ob_unidad->traeDicta($conn,$ramo);
	
	if(!$rs_dicta || pg_numrows($rs_dicta)==0)
		{
		 echo "no se encontro docente asociado";	
		}else{
		?>
        <input type="hidden" name="docdicta" id="docdicta" value="<?php echo pg_result($rs_dicta,0) ?>" class="select_redondo" />
        <div class="textosimple"><?php echo strtoupper(pg_result($rs_dicta,2)) ?></div>
        <?
			
		}
	
}

if($funcion==4){

$rs_lista = $ob_unidad->listaUnidad($conn,$id_ano,$rdb,$curso,$ramo,$docente);

//$rs_a=  $ob_unidad->anoEscola($conn,$_ANO);
 


?>
<table width="700" border="0" align="center">
  <tr>
    <td align="center" class="cuadro02 tablaredonda">#</td>
    <?php if($curso==0){?>
    <td class="cuadro02 tablaredonda">Curso</td>
    <?php }?>
    <?php if($ramo==0){?>
    <td class="cuadro02 tablaredonda">Ramo</td>
    <?php }?>
    <td class="cuadro02 tablaredonda">Nombre</td>
    <td class="cuadro02 tablaredonda">Estado</td>
    <td class="cuadro02 tablaredonda">Fecha Inicio</td>
    <td class="cuadro02 tablaredonda">Fecha T&eacute;rmino</td>
    <td colspan="9" align="center" class="cuadro02 tablaredonda"><div align="center">Acciones</div></td>
  </tr>
 <?php  for($i=0;$i<pg_numrows($rs_lista);$i++){
	 $fila=pg_fetch_array($rs_lista,$i);
	 $rs_ramo=$ob_unidad->traeRamo($conn,$fila['id_curso'],$fila['id_ramo']);
	 $rs_estado=$ob_unidad->traeEstadoClaseUno($conn,$fila['estado']);
	 $rs_curso = $ob_unidad->traeCursosUno($conn,$fila['id_curso']);
	 
	 ?>
  <tr class="cuadro01">
    <td align="center" class="tablaredonda">
      <?php echo ($i+1) ?>
      <input type="hidden" name="idUnidad" id="idUnidad" value="<?php echo $fila['id_planificacion']?>" />
    <input type="hidden" name="rm<?php echo $fila['id_planificacion']?>" id="rm<?php echo $fila['id_planificacion']?>" value="<? echo pg_result($rs_ramo,2);?>" />
    <input type="hidden" name="grdo2<?php echo $fila['id_planificacion']?>" id="grdo2<?php echo $fila['id_planificacion']?>" value="<?php echo pg_result($rs_curso,1) ?>" />
 <input name="ens2<?php echo $fila['id_planificacion']?>" type="hidden" id="ens2<?php echo $fila['id_planificacion']?>" value="<?php echo pg_result($rs_curso,3) ?>"/>
    
    </td>
    <?php if($curso==0){?>
    <td class="tablaredonda"><?php echo CursoPalabra($fila['id_curso'],1,$conn) ?></td>
    <?php }?>
    <?php if($ramo==0){?>
    <td class="tablaredonda"><?=pg_result($rs_ramo,1);?></td>
    <?php }?>
    <td class="tablaredonda"><?php echo $fila['nombre'] ?></td>
    <td class="tablaredonda"><?php echo pg_result($rs_estado,1); ?></td>
    <td align="center" class="tablaredonda"><?php echo CambioFD($fila['fecha_inicio'])?></td>
    <td align="center" class="tablaredonda"><?php echo CambioFD($fila['fecha_termino']) ?></td>
   
    <td align="center" class="tablaredonda"><input name="vi" type="button" onClick="veUnidad(<?php echo $fila['id_planificacion']?>)" value="V" class="botonXX" title="Ver Planificacion"/></td>
    <?php if($_PERFIL==0 || $_PERFIL==14 || $_PERFIL==17){?>

    <td align="center" class="tablaredonda"><input name="ed" type="button" id="ed" onclick="editaUnidad(<?php echo $fila['id_planificacion']?>)" value="E" class="botonXX" title="Editar Planificacion"/></td>
    <?php }?>
	
   
    <td align="center" class="tablaredonda"><input name="es" type="button" value="ES" title="Cambiar Estado" onclick="cambiaEstado(<?php echo $fila['id_planificacion'] ?>)" class="botonXX" /></td>
   
    <td align="center" class="tablaredonda"><input type="button" name="u" id="u" value="PS" title="Asignar Planificaci&oacute;n Semanal" onclick="goUnidad(<?php echo $fila['id_planificacion']?>)" class="botonXX" /></td>
    <!--<td align="center" class="tablaredonda"><input type="button" name="r" id="r" value="R" title="Replicar Planificacion" onclick="replicaUnidad(<?php echo $fila['id_unidad']?>)" class="botonXX"  /></td>-->
     <?php if($_PERFIL==0 || $_PERFIL==14 || $_PERFIL==17){?>
  <!--  <td align="center" class="tablaredonda"><input type="button" name="rl" id="rl" value="<?php echo ($fila['ejecutada']==1)?"NRL":"RL" ?>" title="Marcar Clase como <?php echo ($fila['ejecutada']==1)?"NO realizada":"Realizada" ?>" <?php echo ($fila['estado']!=2)?"disabled":"" ?> onclick="claserl(<?php echo $fila['id_unidad'] ?>,<?php echo ($fila['ejecutada']==1)?0:1 ?>)" class="<?php echo ($fila['estado']!=2)?"botonXXI":"botonXX" ?>" /></td>-->
    <?php }?>
    <td align="center" class="tablaredonda"><a href="carhgafile/index.php?rr=<?php echo $_INSTIT ?>&icls=<?php echo $fila['id_planificacion'] ?>" target="_blank" onClick="window.open(this.href, this.target, 'width=600,height=300'); return false;"><input type="button" name="ac" id="ac" value="A" title="Subir Archivo Evaluaci&oacute;n" class="botonXX" ></a></td>
   <!-- <td align="center" class="tablaredonda"><input type="button" name="impi" id="impi" value="I" title="Imprimir planificaci&oacute;n mensual" onclick="impPL(<?php echo $fila['id_planificacion'] ?>)" class="botonXX" /></td>-->
    <?php if($_PERFIL==0 ){?>
    <td  class="tablaredonda"><input type="button" name="button2" id="button2" value="X" class="botonXX"  onclick="borraAnual(<?php echo $fila['id_planificacion'] ?>)" /></td>
   <?php }?>
  </tr>
  <?php }?>
</table>
<?
}
if($funcion==5){
	//show($_POST);
	
	$rs_ano = $ob_unidad->anoEscola($conn,$_ANO);
	$nano = pg_result($rs_ano,1);
	//$rs_objetivo =$ob_unidad->traeEjeObjetivo2($conn,$rdb,trim($cod_ramo),0,$ense,$grado);
	$rs_eje = $ob_unidad->teje($conn,trim($cod_ramo),$ense,$grado);
	/*$rs_habilidad =$ob_unidad->traeEjeHabilidad($conn,$rdb,$cod_ramo);
	$rs_tipo = $ob_unidad->teje($conn,$cod_ramo,$ens,$grdo);*/
	//exit;
	$rs_uni = $ob_unidad->numUnidad($conn);
	?>
    <script>
$(document).ready(function(){
	
	$("#fecha_inicio, #fecha_termino").datepicker({
			showOn: 'both',
			//changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			minDate: new Date('01/01/'+<?php echo $nano ?>+''),
			maxDate: new Date('12/31/'+<?php echo $nano ?>+''),
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1
			//buttonImage: 'img/Calendario.PNG',
		});
		
		
          $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });
        

  });
  </script>
   <table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td class="cuadro02">Fecha Inicio</td>
    <td><input type="text" name="fecha_inicio" id="fecha_inicio" onchange="calsem()" />
    <input type="hidden" name="nn_ano" id="nn_ano" value="<?php echo $nano ?>"  /></td>
    <td class="cuadro02">Fecha T&eacute;rmino</td>
    <td><input type="text" name="fecha_termino" id="fecha_termino" onchange="calsem()" /></td>
  </tr>
  <tr>
    <td class="cuadro02">Cant. Horas</td>
    <td><input type="text" name="cant_horas" id="cant_horas" class="solo-numero" /></td>
    <td class="cuadro02">Cant. Semanas</td>
    <td><input type="text" name="cant_semanas" id="cant_semanas" class="solo-numero" /></td>
  </tr>
  <tr>
    <td class="cuadro02">Mes</td>
    <td><select name="mes" id="mes" onchange="cmes()">
    <option value="0">Seleccione</option>
 <?php  for($m=1;$m<=12;$m++){
	 $mes = ($m<10)?"0".$m:$m;
	 ?>
 <option value="<?php echo $mes ?>"><?php echo envia_mes($m); ?></option>
  <?php }?>
  </select></td>
    <td class="cuadro02">Semana</td>
    <td>
    <div id="sem">
    <select name="semana">
    <option value="0">Seleccione</option>
    </select>
    </div>
    </td>
  </tr>
  <tr>
    <td class="cuadro02">Unidad</td>
    <td><select name="n_unidad" id="n_unidad">
    <option value="0">Seleccione</option>
    <?php for($u=0;$u<pg_numrows($rs_uni);$u++){
		$filau=pg_fetch_array($rs_uni,$u);
		?>
    <option value="<?php echo $filau['id_unidad'] ?>"><?php echo $filau['texto'] ?></option>
    <?php }  ?>
    </select></td>
    <td class="cuadro02">&Aacute;mbito</td>
    <td><input type="text" name="ambito" id="ambito" /></td>
  </tr>
  <tr>
    <td class="cuadro02">Tipo</td>
    <td><input type="text" name="tipop" id="tipop" /></td>
    <td class="cuadro02">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php if($ense==10){?>
  <tr>
    <td class="cuadro02">Cursos did&aacute;cticos</td>
    <td><textarea name="didactico" rows="5" id="didactico"></textarea></td>
    <td class="cuadro02">Evaluaci&oacute;n</td>
    <td><textarea name="evaluacion" rows="5" id="evaluacion"></textarea></td>
  </tr>
  <?php }?>
</table>
<br />
<br />

<table width="650" border="1" align="center" style="border-collapse:collapse">
 <tr>
    <td colspan="4" class="cuadro02"><!--<input name="tipo" id="tipo0" type="radio" value="0" onclick="cargatipo(0);" />Objetivos <input name="tipo" id="tipo1" type="radio" value="1" onclick="cargatipo(1);" />-->
    
     <!-- <input type="hidden" name="cargaobj" id="cargaobj" /> 
      <input type="hidden" name="cargahab" id="cargahab" />-->
       <?php for($ti=0;$ti<pg_numrows($rs_eje);$ti++){
		  $fila_eje = pg_fetch_array($rs_eje,$ti);
		  ?>
          <?php if($ti==0){ ?>
          <input name="crg" id="crg" type="hidden" value="<?php echo $fila_eje['id_objetivo']; ?>" />
          <?php }?>
           <input type="hidden" name="cargatipo[]" id="cargatipo<?php echo $fila_eje['id_objetivo']; ?>" />
           <input type="hidden" name="cargaind[]" id="cargaind<?php echo $fila_eje['id_objetivo']; ?>" />  
      <input name="tipo" id="tipo<?php echo $t ?>" type="radio" value="<?php echo $fila_eje['id_objetivo']; ?>" onclick="cargatipo(<?php echo $fila_eje['id_objetivo']; ?>);" <?php echo ($ti==0)?"checked":"" ?> /><?php echo $fila_eje['nombre']; ?>
      <?php }?>
     
      </td>
  </tr>
</table>
<div id="obj">
</div>
<div id="mx">
</div>
    
    <?
}
if($funcion==6){
	$rs_curso = $ob_unidad->traeCursosUno($conn,$curso);
	
	?>
 <input type="hidden" name="grdo" id="grdo" value="<?php echo pg_result($rs_curso,1) ?>" />
<input name="ens" type="hidden" id="ens" value="<?php echo pg_result($rs_curso,3) ?>" />
 <?
}
if($funcion==7){
$rs_ramo =$ob_unidad->traeRamoUno($conn,$ramo);
$fila_ramo = pg_fetch_array($rs_ramo,0);
$cod_ramo=$fila_ramo['cod_subsector'];
echo $cod_ramo;
}
if($funcion==8){
	$rs_curso = $ob_unidad->traeCursosUno($conn,$curso);
	$ense = pg_result($rs_curso,3);
	$grado = pg_result($rs_curso,1);
	
	
	
	
	
	?>
    <br />

<table width="650" align="center" border="1" style="border-collapse:collapse">
	<?
	
//$rs_objetivo =$ob_unidad->traeEjeObjetivo($conn,$rdb,$cod_ramo,$tipo);
$rs_objetivo =$ob_unidad->traeEjeObjetivo2($conn,$rdb,$cod_ramo,$tipo,$ense,$grado);
 for($o=0;$o<pg_numrows($rs_objetivo);$o++){
		 $fila_obj = pg_fetch_array($rs_objetivo,$o);
		
		  
		
			
			
			
		 ?>
		  <tr><td class="cuadro02"><?php echo $fila_obj['texto'] ?></td>
		  <?
		 $rs_eje =$ob_unidad->traeObj($conn,$fila_obj['id_eje'],$rdb,$ense,$grado,$tipo);
		 for($j=0;$j<pg_numrows($rs_eje);$j++){
			$fila = $fila_obj = pg_fetch_array($rs_eje,$j);
			$rs_ideva = $ob_unidad->buscaIndicador($conn,$fila['id_obj']);
			
			$cad_ind="";
			
			$ideva = "";
			$rs_inditpo = $ob_unidad->traeIndiUnidadO($conn,$unn,$fila['id_obj']);
			
			if(pg_numrows($rs_inditpo)>0){
			
				for($in=0;$in<pg_numrows($rs_inditpo);$in++){
				$fila_in = pg_fetch_array($rs_inditpo,$in);
				$cad_ind.=$fila_in['id_obj']."_".$fila_in['id_indicador'].","; 	
				}	
			}
			?>
		  <tr><td align="justify" id="fila<?php echo  $fila['id_obj']?>" onclick="pp(<?php echo  $fila['id_obj']?>);sumatipo(<?php echo  $fila['tipo']?>); buscasel(<?php echo  $fila['tipo']?>);" class="i textosimple"><?php echo nl2br($fila['codigo']."-".$fila['texto']) ?><input name="obj_destino[]" type="checkbox" class="oo<?php echo  $fila['tipo']?>" id="destino<?=$fila['id_obj']?>" style="visibility:hidden" value="<?php echo  $fila['id_obj']?>" /> 
 <input type="hidden" id="lindv<?php echo  $fila['id_obj']?>" name="lindv<?php echo  $fila['id_obj']?>" class="lindv<?php echo  $fila['tipo']?>" value="<?php echo $cad_ind ?>" />
 </td>
          <?
		 }
		 
		 
              
 }

	
	?>
</table>
    <?
}
if($funcion==9){
//show($_POST);

$rs_indi = $ob_unidad->buscaIndicador($conn,$obj);
?><br />
<br />

<table width="100%" border="1" style="border-collapse:collapse">
<?php for($i=0;$i<pg_numrows($rs_indi);$i++){
	$fila=pg_fetch_array($rs_indi,$i);?>
  <tr id="filaind<?php echo  $fila['id_indicador']?>">
    <td onclick="ppi(<?php echo $fila['id_indicador'] ?>,<?php echo $obj ?>,<?php echo $fila['tipo'] ?>)"><?php echo $fila['texto'] ?>&nbsp;
    <input type="checkbox" name="ind[]" id="ind<?php echo $fila['id_indicador'] ?>"  class="oid<?php echo  $fila['id_obj']?>" value="<?php echo $fila['id_obj'] ?>_<?php echo $fila['id_indicador'] ?>" style="visibility:hidden" /></td>
  </tr>
  <?php }?>
</table>
<?	
}
if($funcion==10){
$year = $nano;
$month = $mes;
list($primeraSemana,$ultimaSemana)=semanasMes($year,$month);
//show(semanasMes($year,$month));

?>
<select name="semana" id="semana" onchange="cdias()">
    <option value="0">Seleccione</option>
   
<?
for($s=$primeraSemana;$s<=$ultimaSemana;$s++){

 $week = $s;


   $fechaInicioSemana  = date('d-m-Y', strtotime($year . 'W' . str_pad($week , 2, '0', STR_PAD_LEFT)));
 $fecha_lunes = $fechaInicioSemana; //Lunes
 $fecha_viernes = date('d-m-Y', strtotime($fechaInicioSemana.' 4 day')); //Viernes
 ?>
 <option value="<?php echo $week ?>">Semana <?php echo $week ?> / <?php echo $fecha_lunes ?> a <?php echo $fecha_viernes ?></option>
 <?
}

?> 
</select>
<?
}
if($funcion==11){
$exs=$ob_unidad->existe($conn,CambioFE($fecha_inicio),CambioFE($fecha_termino),$sel_curso,$sel_ramo);
//pruebo si existe unidad similar
if(pg_numrows($exs)>0){
echo 2;
}
//si no existe, la guardo
else{
	$rs_sub= $ob_unidad->subsector($conn,$cod_ramo);
	$cod_sub = pg_result($rs_sub,1);
	$ids = pg_result($rs_sub,0);
	
	$rs_ano = $ob_unidad->anoEscola($conn,$ano);
	$txt_fechaini = pg_result($rs_ano,2);
	$txt_fechater = pg_result($rs_ano,3);
	$numa = pg_result($rs_ano,1);
	
	$rs_curuno = $ob_unidad->traeCursosUno($conn,$sel_curso);
	$gr = pg_result($rs_curuno,1);
	$lt = pg_result($rs_curuno,2);
	$en = pg_result($rs_curuno,3);
	
	$tipop=(isset($_POST['tipop']))?$_POST['tipop']:"";
	$ambito=(isset($_POST['ambito']))?$_POST['ambito']:"";
	
	//$txt_nombre = "PLANIFICACION ".$en."_".$gr."_".trim($lt)."_".trim($cod_ramo)."_$numa_$n_unidad";
	$txt_nombre= "SEMANA".$semana."_".$en."_".$gr."_".trim($lt)."_".trim($cod_ramo)."_UNIDAD".$n_unidad;
	

	 $rs_guarda = $ob_unidad->guardaUnidadAno($conn,$rdb,$ano,$sel_curso,$sel_ramo,$docdicta,CambioFE($fecha_inicio),CambioFE($fecha_termino),$txt_nombre,$tipop,$ambito);
	 
	 //si guarde la unidad
	 if($rs_guarda){
		 //buscar la untima que tengo con el rdb para anidad
		$rs_ultimaUnidad = $ob_unidad->ultimaUnidad($conn,$rdb);
		$id_unidad = pg_result($rs_ultimaUnidad,0);
		
		
		
		//insertar detalle plani mensual
		$txt_nombre_pm = "PLANIFICACION_DET ".$en."_".$gr."_".trim($lt)."_".trim($cod_ramo)."_unidad".$n_unidad."_".envia_mes($mes);
		$rs_gmensual = $ob_unidad->insPlaniMensual($conn,$id_unidad,$cant_semanas,$cant_horas,utf8_decode($didactico),utf8_decode($evaluacion),$txt_nombre_pm,$n_unidad);
		
		
		//insertar detalle planificacion anual
		$rs_ulMensual = $ob_unidad->ultimaUnidadMenusal($conn,$rdb);
		$id_mensual = pg_result($rs_ulMensual,0);
		
		//plan anual detalle
		$insem  = date('Y-m-d', strtotime($nn_ano . 'W' . str_pad($semana , 2, '0', STR_PAD_LEFT)));
 		$inisem = $insem; //Lunes
 		$tersem = date('Y-m-d', strtotime($insem.' 4 day')); //Viernes
		
		$rs_ingDetMsn = $ob_unidad->ingAnualDetalle($conn,$id_unidad,$id_mensual,$semana,$unidad,$inisem,$tersem,$mes,$n_unidad);
		
		//ultimo
		$rs_ulsem = $ob_unidad->ultimaUnidadMensual($conn,$rdb);
		$ulsem = pg_result($rs_ulsem,0);
		
		
		//objetivos
		$obj_destino=$_POST['cargatipo'];
		 if(count($obj_destino)>0){
			for ($i=0;$i<count($obj_destino);$i++) { 
			$cuenta_tipo = explode(",",$obj_destino[$i]);
				for ($j=0;$j<count($cuenta_tipo);$j++) { 
				$rs_guardaObjetivo = $ob_unidad->guardaObjetivo($conn,$ulsem,$cuenta_tipo[$j]);
				}
				
				
			}
				 
			}
			
			//indicadores
			if(strlen($_POST["cargaind"])>0){
				$lista = $_POST["cargaind"];
				for($l=0;$l<count($_POST["cargaind"]);$l++){
					$cuenta_ind = explode(",",$lista[$l]);
					if(strlen($lista[$l])>0){
					//show($cuenta_ind);
					for($k=0;$k<count($cuenta_ind);$k++){
					$cc=explode("_",$cuenta_ind[$k]);
					$indicador = $cc[1];
					$objetivo =$cc[0];
					  $ob_unidad->guardaIndicador($conn,$ulsem,$objetivo,$indicador); 
					 
						}
					}
				}
			}
			
			
		
		
	echo 1;
}
else{
	echo 0;

}	//fin uardar
	 
}

}//fin funcion

if($funcion==12){
	show($_POST);

$rs_listaua = $ob_unidad->traeUnidadU($conn,$id_unidad);

for($ua=0;$ua<pg_numrows($rs_listaua);$ua++){
$filaua = pg_fetch_array($rs_listaua,$ua);
$id_unidadU = $filaua['id_planificacion'];
/*
//clases
$rs_cls= $ob_unidad->traeClasesU($conn,$id_unidadU);
for($c=0;$c<pg_numrows($rs_cls);$c++){
	$fila_cls = pg_fetch_array($rs_cls,$c);
	
	$id_clase=$fila_cls['id_clase'];
	
		$ruta ="../clase/acv/";

		//busco si tengo archivos asociados
		$rs_lista = $ob_unidad->archivoClase($conn,$id_clase);
		if(pg_numrows($rs_lista)>0){
			for($a=0;$a<pg_numrows($rs_lista);$a++){
			$fila = pg_fetch_array($rs_lista,$a);
				@unlink($ruta.$fila['ruta']) ;
			}
		}
	
		$ob_unidad->delArchivoClase($conn,$id_clase);
		$ob_unidad->delNotaClase($conn,$id_clase);
		$ob_unidad->delObsClase($conn,$id_clase);
		$ob_unidad->delRecursoClase($conn,$id_clase);
		$ob_unidad->delTipoevaClase($conn,$id_clase);
		$ob_unidad->delObjClase($conn,$id_clase);
		$ob_unidad->delClase($conn,$id_clase);
	}

*/
//borro datos de unidad
$ruta_u ="../plani_anual/acv/";
//busco si tengo archivos asociados
		$rs_listau = $ob_unidad->archivoUnidadU($conn,$id_unidadU);
		if(pg_numrows($rs_lista)>0){
			for($b=0;$b<pg_numrows($rs_listau);$b++){
			$filau = pg_fetch_array($rs_listau,$b);
				@unlink($ruta_u.$filau['ruta']) ;
			}
		}


/*
$ob_unidad->delArchivoUnidadU($conn,$id_unidadU);
$ob_unidad->delObjUnidadU($conn,$id_unidadU);
$ob_unidad->delNotaUnidadU($conn,$id_unidadU);
$ob_unidad->delObjUnidadU($conn,$id_unidadU);*/
$ob_unidad->delObsUnidadU($conn,$id_unidadU);
$ob_unidad->delUnidadU($conn,$id_unidadU);


}
}
if($funcion==13){

	$rs_estado = $ob_unidad->traeEstadoClase($conn);
	$rs_historial = $ob_unidad->traeHistorialcambiosUAnual($conn,$unidad);
	
	?><?php if($_PERFIL==0 || $_PERFIL==14 || $_PERFIL==25){?>
    <input type="hidden" id="unidad" value="<?php echo $unidad ?>" />
    <table width="599" border="1" style="border-collapse:collapse">
    <tr><td width="160" class="cuadro02">Seleccione Estado</td>
    <td width="711"><select name="opc_estado" id="opc_estado" onchange="abrecomen()">
    <option value="0">seleccione...</option>
    <?php for($e=0;$e<pg_numrows($rs_estado);$e++){
		$fila_estado = pg_fetch_array($rs_estado,$e);
		if($fila_estado['id_estado']!=1 && $fila_estado['id_estado']!=3){
		?>
        <option value="<?php echo $fila_estado['id_estado'] ?>"><?php echo $fila_estado['glosa'] ?></option>
		
   <?php }}?>
    
    </select></td></tr>
    </table>
    <br />
<br />

    <div id="comest"></div>
    <br />
<br />
    <?php  } ?>

<table width="600" border="1" style="border-collapse:collapse">
<tr class="cuadro02">
<td colspan="2" align="center">Historial de Cambios</td>
</tr>
<tr class="cuadro02">
<td width="105" >Fecha</td>
<td width="479">Descripci&oacute;n</td>
</tr>
 <?php 
 for($h=0;$h<pg_numrows($rs_historial);$h++){
		$fila_historial = pg_fetch_array($rs_historial,$h);
?>
<tr class="cuadro01">
<td width="105"><?php echo CambioFD($fila_historial['fecha']) ?></td>
<td width="479"><?php echo $fila_historial['observacion'] ?></td>
</tr>
<?php }?>
</table>
    <?
 

}if($funcion==14){
	
	$desc=($estado==2)?"Aprobación final":$descripcion;
	
	$rs_estado = $ob_unidad->guardaHistorialcambiosUAnual($conn,$unidad,date("Y-m-d"),$desc);
	
	if($rs_estado){
	$rs_cambia = $ob_unidad->cambiaEstadoClaseUAnual($conn,$unidad,$estado);
	echo 1;
	}
	else{
	echo 0;
	}
}
//ver configuracion
if($funcion==15){
	//var_dump($_POST);
	$rs_unidad =$ob_unidad->traeUnidad($conn,$idUnidad);
	
?>
	<table width="650" border="0" align="center" cellspacing="3">
    <tr>
		  <td colspan="4" align="center" class="titulo">PLANIFICACI&Oacute;N MENSUAL</td>
	  </tr>
     <? if(pg_numrows($rs_unidad)>0){
		$fila_unidad = pg_fetch_array($rs_unidad,0);
		$rs_dicta=$ob_unidad->traeDicta($conn,$fila_unidad['id_ramo']);
		$rs_ramo=$ob_unidad->traeRamo($conn,$fila_unidad['id_curso'],$fila_unidad['id_ramo']);
		$rs_eje=$ob_unidad->tejeUnidad($conn,$idUnidad);
		$rs_arc = $ob_unidad->traearchivo($conn,$idUnidad);
		$rs_det = $ob_unidad->traeAnualDet($conn,$idUnidad);
		
		$id_det = pg_result($rs_det,0);
		
		
     ?>
     <tr>
		  <td colspan="4" class="cuadro02">TITULO: <?php echo $fila_unidad['nombre'] ?></td>
	  </tr>
      <tr>
		  <td class="cuadro02">CURSO</td>
		  <td colspan="3" class="cuadro01"><?php echo CursoPalabra($fila_unidad['id_curso'],1,$conn) ?></td>
	  </tr>
      <tr>
		  <td width="127" class="cuadro02">ASIGNATURA</td>
		  <td colspan="3" class="cuadro01"><?=pg_result($rs_ramo,1);?></td>
      </tr>
		<tr>
		  <td class="cuadro02">DOCENTE</td>
		  <td colspan="3" class="cuadro01"><?php echo strtoupper(pg_result($rs_dicta,2)) ?></td>
	  </tr>
		<tr>
		  <td width="127" class="cuadro02">FECHA INICIO</td>
		  <td width="25%" class="cuadro02">FECHA TERMINO</td>
		  <td width="25%" class="cuadro02">SEMANAS ASIGNADAS</td>
		  <td width="25%" class="cuadro02">HORAS ASIGNADAS</td>
	  </tr>
		<tr>
		  <td class="cuadro01"><?php echo CambioFD($fila_unidad['fecha_inicio']) ?></td>
		  <td class="cuadro01"><?php echo CambioFD($fila_unidad['fecha_termino']) ?></td>
		  <td class="cuadro01"><?php echo $fila_unidad['cant_semanas'] ?></td>
		  <td class="cuadro01"><?php echo $fila_unidad['cant_horas'] ?></td>
	  </tr>
		<tr>
		  <td class="cuadro02">MES ASIGNACION</td>
		  <td class="cuadro02">SEMANA ASIGNACION</td>
		  <td class="cuadro02">&nbsp;</td>
		  <td class="cuadro02">&nbsp;</td>
	  </tr>
		<tr>
		  <td class="cuadro01"><?php echo envia_mes($fila_unidad['num_mes']) ?></td>
		  <td class="cuadro01"><?php echo $fila_unidad['id_semana'] ?></td>
		  <td class="cuadro01">&nbsp;</td>
		  <td class="cuadro01">&nbsp;</td>
	  </tr>
		<tr>
		  <td colspan="4">&nbsp;</td>
	  </tr>
		<tr>
		  <td colspan="4">&nbsp;</td>
	  </tr>
      <?php if(pg_numrows($rs_eje)>0){
		?>
           <?php for($e=0;$e<pg_numrows($rs_eje);$e++){
		  $fila_eje = pg_fetch_array($rs_eje,$e);
		 
		  $rs_tipe=$ob_unidad->tipoEjesBloqueAnio($conn,$id_det,$fila_eje['id_objetivo']);
		
		  ?>
		<tr>
		  <td colspan="4" >
		  <table width="100%">
          <tr class="cuadro02">
            <td colspan="2"><?php echo strtoupper($fila_eje['nombre'])?></td>
            </tr>
           <?php   for($ti=0;$ti<pg_numrows($rs_tipe);$ti++){ 
		     $fila_tipe = pg_fetch_array($rs_tipe,$ti);
			  $rs_obj=$ob_unidad->traeObjeUnidadAnio($conn,$fila_tipe['id_eje'],$fila_eje['id_objetivo'],$id_det);
		   ?>
          <tr class="cuadro02">
          <td  width="50%"><?php echo strtoupper($fila_tipe['texto']) ?></td><td>INDICADORES DE EVALUACI&Oacute;N</td></tr>
         
          <?php for($o=0;$o<pg_numrows($rs_obj);$o++){
		  $fila_obj = pg_fetch_array($rs_obj,$o);
		  ?>
		<tr class="cuadro01">
		  <td valign="top"><?php echo strtoupper($fila_obj['codigo']) ?> - <?php echo nl2br($fila_obj['texto'])?></td>  							          <td valign="top">
          <?php 
		  $rs_ind_a = $ob_unidad->buscaIndicadorSel($conn,$fila_obj['id_obj']);
		  for($ff=0;$ff<pg_numrows($rs_ind_a);$ff++){
			  $fila_inda = pg_fetch_array($rs_ind_a,$ff);
		  echo nl2br($fila_inda['texto'])."<br>";
		  }
		  ?>
          </td>
	  </tr>
	  <?php }?>
	  <?php }?>
          </table>
		  </td>
	  </tr>
      
       
      <?php }?>
      <?php }?>
		<tr>
		  <td colspan="4">&nbsp;</td>
	  </tr>
    
     
       <?php if(pg_numrows($rs_arc )>0){
	  $ruta = pg_result($rs_arc,2);
	  ?>
  <tr>
   <td colspan="4">&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02" colspan="4">ARCHIVO EVALUACI&Oacute;N</td>
 </tr>
 
 <tr>
   <td class="cuadro01" colspan="4"><a href="acv/<?php echo $ruta ?>" target="_blank"><?php echo $ruta ?></a></td>
 </tr><?php }?>
     <? }
	else{ ?>
		<tr><td colspan="4" align="center">SIN INFORMACI&Oacute;N</td></tr>
	<?    }?>
	</table>
   <? 
	
}
if($funcion==16){

	//show($_POST);
	
	$rs_ano = $ob_unidad->anoEscola($conn,$_ANO);
	$nano = pg_result($rs_ano,1);
	//$rs_objetivo =$ob_unidad->traeEjeObjetivo2($conn,$rdb,trim($cod_ramo),0,$ense,$grado);
	$rs_tipo = $ob_unidad->teje($conn,trim($cod_ramo),$ens,$grdo);
	//$rs_habilidad =$ob_unidad->traeEjetraeEjeObjetivo($conn,$rdb,$cod_ramo);
	
	//exit;
	$rs_unidad =$ob_unidad->traeUnidad($conn,$idUnidad);
	$fila_unidad = pg_fetch_array($rs_unidad,0);
	$rs_uni = $ob_unidad->numUnidad($conn);
	$rs_ramo=$ob_unidad->traeRamo($conn,$fila_unidad['id_curso'],$fila_unidad['id_ramo']);
	?>
<script>
$(document).ready(function(){
	
	$("#fecha_inicio, #fecha_termino").datepicker({
			showOn: 'both',
			//changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			minDate: new Date('01/01/'+<?php echo $nano ?>+''),
			maxDate: new Date('12/31/'+<?php echo $nano ?>+''),
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
		
		
          $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });
        
		//cmes();

  });
  </script>
   <input type="hidden" name="idUnidad" id="idUnidad" value="<?php echo $fila_unidad['id_planificacion']?>" />
  <input type="hidden" name="rm" id="rm" value="<?=pg_result($rs_ramo,2);?>" />
<input type="hidden" name="cr" id="cr" value="<?php echo $fila_unidad['id_curso']?>" />
  <input name="an" type="hidden" id="an" value="<?php echo $nano ?>" />
   <input name="id_mensual" type="hidden" id="id_mensual" value="<?php echo $fila_unidad['id_mensual']?>" />
    <input name="id_anual_det" type="hidden" id="id_anual_det" value="<?php echo $fila_unidad['id_anual_det']?>" />
<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td class="cuadro02">Fecha Inicio</td>
    <td><input type="text" name="fecha_inicio" id="fecha_inicio" value="<?php echo CambioFD($fila_unidad['fecha_inicio']) ?>" />      <input type="hidden" name="nn_ano" id="nn_ano" value="<?php echo $nano ?>"  /></td>
    <td class="cuadro02">Fecha T&eacute;rmino</td>
    <td><input type="text" name="fecha_termino" id="fecha_termino" value="<?php echo CambioFD($fila_unidad['fecha_termino']) ?>"/></td>
  </tr>
  <tr>
    <td class="cuadro02">Cant. Horas</td>
    <td><input type="text" name="cant_horas" id="cant_horas" class="solo-numero" value="<?php echo $fila_unidad['cant_horas'] ?>" /></td>
    <td class="cuadro02">Cant. Semanas</td>
    <td><input type="text" name="cant_semanas" id="cant_semanas" class="solo-numero" value="<?php echo $fila_unidad['cant_semanas'] ?>" /></td>
  </tr>
  <tr>
    <td class="cuadro02">Mes</td>
    <td><select name="mes" id="mes" onchange="cmes()">
    <option value="0">Seleccione</option>
 <?php  for($m=1;$m<=12;$m++){
	 $mes = ($m<10)?"0".$m:$m;
	 ?>
 <option value="<?php echo $mes ?>" <?php echo $fila_unidad['num_mes']==$mes?"selected":""; ?>><?php echo envia_mes($m); ?></option>
  <?php }?>
  </select></td>
    <td class="cuadro02">Semana</td>
    <td>
    <div id="sem">
    <select name="semana">
    <option value="0">Seleccione</option>
    <? $year = $nano;
$month = $fila_unidad['num_mes'];
list($primeraSemana,$ultimaSemana)=semanasMes($year,$month);
//show(semanasMes($year,$month));

for($s=$primeraSemana;$s<=$ultimaSemana;$s++){

 $week = $s;


   $fechaInicioSemana  = date('d-m-Y', strtotime($year . 'W' . str_pad($week , 2, '0', STR_PAD_LEFT)));
 $fecha_lunes = $fechaInicioSemana; //Lunes
 $fecha_viernes = date('d-m-Y', strtotime($fechaInicioSemana.' 4 day')); //Viernes
 ?>
 <option value="<?php echo $week ?>" <?php echo ($week==$fila_unidad['id_semana']?"selected":"") ?>>Semana <?php echo $week ?> / <?php echo $fecha_lunes ?> a <?php echo $fecha_viernes ?></option>
 <?
}

?> 

    </select>
    </div>
    </td>
  </tr>
  <tr>
    <td class="cuadro02">Unidad</td>
    <td><select name="n_unidad" id="n_unidad">
    <option value="0">Seleccione</option>
    <?php for($u=0;$u<pg_numrows($rs_uni);$u++){
		$filau=pg_fetch_array($rs_uni,$u);
		?>
    <option value="<?php echo $filau['id_unidad'] ?>"><?php echo $filau['texto'] ?></option>
    <?php }  ?>
    </select></td>
    <td class="cuadro02">&Aacute;mbito</td>
    <td><input type="text" name="ambito" id="ambito" value="<?php echo $fila_unidad['ambito'] ?>" /></td>
  </tr>
  <tr>
    <td class="cuadro02">Tipo</td>
    <td><input type="text" name="tipop" id="tipop" value="<?php echo $fila_unidad['tipo'] ?>" /></td>
    <td class="cuadro02">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php if($ense==10){?>
  <tr>
    <td class="cuadro02">Cursos did&aacute;cticos</td>
    <td><textarea name="didactico" rows="5" id="didactico"><?php echo $fila_unidad['didactico'] ?></textarea></td>
    <td class="cuadro02">Evaluaci&oacute;n</td>
    <td><textarea name="evaluacion" rows="5" id="evaluacion"><?php echo $fila_unidad['evaluacion'] ?></textarea></td>
  </tr>
  <?php }?>
</table>
<br />
<br />

<table width="650" border="1" align="center" style="border-collapse:collapse">
 <tr>
    <td colspan="4" class="cuadro02">
       <?php for($ti=0;$ti<pg_numrows($rs_tipo);$ti++){
		  $fila_tipo = pg_fetch_array($rs_tipo,$ti);
		  $cad_ind="";
		  if ($ti==0){
			  
            $crg = $fila_tipo['id_objetivo']; ?>
      <input name="crg" id="crg" type="hidden" value="<?php echo $fila_tipo['id_objetivo']; ?>" />
        
              <? }
		  
			$rs_obj=$ob_unidad->traeObjUnidad($conn,$fila_tipo['id_objetivo'],$_POST['idUnidad']);
			$cob="";
			for($o=0;$o<pg_numrows($rs_obj);$o++){
				$fil_obj=pg_fetch_array($rs_obj,$o);
				
				$cob.=$fil_obj['id_obj'].",";
				
				
			}
			$cob=substr($cob, 0, -1);
			
			$rs_inditpo = $ob_unidad->traeIndiUnidadC($conn,$fila_unidad['id_anual_det'],$fila_tipo['id_objetivo']);
			if(pg_numrows($rs_inditpo)>0){
			
			for($in=0;$in<pg_numrows($rs_inditpo);$in++){
			$fila_in = pg_fetch_array($rs_inditpo,$in);
			$cad_ind.=$fila_in['id_obj']."_".$fila_in['id_indicador'].","; 	
			}	
			}
		  
		  ?>
           <input type="hidden" name="cargatipo[]" id="cargatipo<?php echo $fila_tipo['id_objetivo']; ?>" value="<?php echo $cob ?>" /> 
      <input name="tipo" id="tipo<?php echo $t ?>" type="radio" value="<?php echo $fila_tipo['id_objetivo']; ?>" onclick="cargatipoedi(<?php echo $fila_tipo['id_objetivo']; ?>,<?php echo $idUnidad ?>);" <?php echo ($ti==0)?"checked":"" ?> />
      <?php echo $fila_tipo['nombre']; ?>
    <input type="hidden" name="cargaind[]" id="cargaind<?php echo $fila_tipo['id_objetivo']; ?>" value="<?php echo $cad_ind ?>" />  
    <?php }?>
    </td>
  </tr>
</table>
<div id="obj">
</div>
<div id="mx">
</div>
<script>
cargatipoedi(<?php echo $crg ?>,<?php echo $idUnidad ?>);

</script>

    
    <?
	
}
if($funcion==17){
	//show($_POST);
	$rs_curso = $ob_unidad->traeCursosUno($conn,$curso);
	$ense = pg_result($rs_curso,3);
	$grado = pg_result($rs_curso,1);
	//$rs_objetivo =$ob_unidad->traeEjeObjetivo2($conn,$rdb,$cod_ramo,$_POST['tipo'],$ense,$grado);
	$rs_objetivo =$ob_unidad->traeEjeObjetivo2($conn,$rdb,$cod_ramo,$tipo,$ense,$grado);
	?><br />

   
<table width="650" align="center" border="1" style="border-collapse:collapse">
	<?
	


//$rs_objetivo =$ob_unidad->traeEjeObjetivo2($conn,$rdb,$cod_ramo,$tipo,$ense,$grado);
 for($o=0;$o<pg_numrows($rs_objetivo);$o++){
		 $fila_obj = pg_fetch_array($rs_objetivo,$o);
		 ?>
		  <tr><td class="cuadro02"><?php echo $fila_obj['texto'] ?></td>
		  <?
		// $rs_eje =$ob_unidad->traeObj($conn,$fila_obj['id_eje'],$rdb,$ense,$grado);
		  $rs_eje =$ob_unidad->traeObj($conn,$fila_obj['id_eje'],$rdb,$ense,$grado,$tipo);
		 for($j=0;$j<pg_numrows($rs_eje);$j++){
			$fila = $fila_obj = pg_fetch_array($rs_eje,$j);
			
			$rs_marca = $ob_unidad->traeMarcado($conn,$id_unidad,$fila['id_obj']);
			
			if(pg_numrows($rs_marca)==0){
			$marca=0;
			}else{
			$marca=1;
			}
			
			$l_oo="";
			$rs_inditpo = $ob_unidad->traeIndiUnidadO($conn,$id_unidad,$fila['id_obj']);
			$cad_ind="";
			if(pg_numrows($rs_inditpo)>0){
			
				for($in=0;$in<pg_numrows($rs_inditpo);$in++){
				$fila_in = pg_fetch_array($rs_inditpo,$in);
				$cad_ind.=$fila_in['id_obj']."_".$fila_in['id_indicador'].","; 	
				}	
			}
			
			?>
		   <tr><td align="justify" id="fila<?php echo  $fila['id_obj']?>" onclick="pp(<?php echo  $fila['id_obj']?>);sumatipo(<?php echo  $fila['tipo']?>); buscasel(<?php echo  $fila['tipo']?>)" class="i textosimple <?php echo ($marca==1)?"check":"" ?>"><?php echo nl2br($fila['codigo']."-".$fila['texto']) ?><input name="obj_destino[]" type="checkbox" class="oo<?php echo  $fila['tipo']?>" id="destino<?=$fila['id_obj']?>"  value="<?php echo  $fila['id_obj']?>" <?php echo ($marca==1)?"checked":"" ?> style="visibility:hidden"/>
		      <input type="hidden" id="lindv<?php echo  $fila['id_obj']?>" name="lindv<?php echo  $fila['id_obj']?>" class="lindv<?php echo  $fila['tipo']?>" value="<?php echo $cad_ind ?>"/></td>
          <?
		 }
		 
		 
              
 }


	
	?>
</table>
    <?
}
if($funcion==18){
//show($_POST);
$obj_destino=$_POST['cargatipo'];
$rs_guarda = $ob_unidad->actualizaUnidad($conn,$idUnidad,CambioFE($fecha_inicio),CambioFE($fecha_termino),$tipo,$ambito);

$ob_unidad->eliminaObjAn($conn,$id_anual_det); 
$ob_unidad->eliminaIndAn($conn,$id_anual_det);



//plan anual detalle
		$insem  = date('Y-m-d', strtotime($nn_ano . 'W' . str_pad($semana , 2, '0', STR_PAD_LEFT)));
 		$inisem = $insem; //Lunes
 		$tersem = date('Y-m-d', strtotime($insem.' 4 day')); //Viernes
		
		$didactico=($ens==10)?$didactico:"";
		$evaluacion=($ens==10)?$evaluacion:"";
		
		$rs_upMsn = $ob_unidad->upPMensiual($conn,$id_mensual,$cant_semanas,$cant_horas,$didactico,$evaluacion);
		
		$rs_upDet = $ob_unidad->upPlanidetalle($conn,$id_anual_det,$inisem,$tersem,$semana,$mes);
		
		//objetivos
		 if(count($obj_destino)>0){
			for ($i=0;$i<count($obj_destino);$i++) { 
			$cuenta_tipo = explode(",",$obj_destino[$i]);
				for ($j=0;$j<count($cuenta_tipo);$j++) { 
				$rs_guardaObjetivo = $ob_unidad->guardaObjetivo($conn,$id_anual_det,$cuenta_tipo[$j]);
				}
				
				
			}
				 
			}
			
			//indicadores
			if(strlen($_POST["cargaind"])>0){
				$lista = $_POST["cargaind"];
				for($l=0;$l<count($_POST["cargaind"]);$l++){
					$cuenta_ind = explode(",",$lista[$l]);
					if(strlen($lista[$l])>0){
					//show($cuenta_ind);
					for($k=0;$k<count($cuenta_ind);$k++){
					$cc=explode("_",$cuenta_ind[$k]);
					$indicador = $cc[1];
					$objetivo =$cc[0];
					  $ob_unidad->guardaIndicador($conn,$id_anual_det,$objetivo,$indicador); 
					 
						}
					}
				}
			}
	
	echo 1;
}
if($funcion==19){
//show($_POST);
$dunidad= $ob_unidad->traeUnidad($conn,$ipl);
$fila_unidad = pg_fetch_array($dunidad,0);
$f_curso = $ob_unidad->traeCursosUno($conn,$fila_unidad['id_curso']);
?>
<style type="text/css" media="print">
  @page { size: Legal landscape; }
</style>
<div class="print">
<?php if(pg_result($f_curso,3)==10){
	$rs_dicta =$ob_unidad->traeSupervisa($conn,$fila_unidad['id_curso']);
	?>
<table width="650" border="0" align="center">
  <tr class="cuadro02 tablaredonda">
    <td colspan="4" align="center">Planificaci&oacute;n Mensual </td>
    </tr>
  <tr class="cuadro02 tablaredonda">
    <td colspan="4">Datos Generales</td>
  </tr>
  <tr >
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr class="cuadro02 tablaredonda">
    <td>Unidad Tem&aacute;tica</td>
    <td>&Aacute;mbito</td>
    <td>N&uacute;cleo</td>
    <td>Ejes</td>
  </tr>
  <tr>
    <td><?php echo $fila_unidad['nombre'] ?></td>
    <td><?php echo $fila_unidad['ambito'] ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="cuadro02 tablaredonda">
    <td>Nivel</td>
    <td>Curso</td>
    <td colspan="2">Docente</td>
    </tr>
  <tr>
    <td><?php echo utf8_decode(CursoPalabra_Informe(2,pg_result($f_curso,3),pg_result($f_curso,1),$conn)); ?></td>
    <td><?php echo CursoPalabra($fila_unidad['id_curso'],1,$conn); ?></td>
    <td colspan="2"><?php echo pg_result($rs_dicta,2); ?></td>
    </tr>
  <tr class="cuadro02 tablaredonda">
    <td>Horas efectivas mensuales</td>
    <td>Cantidad de Horas semanales</td>
    <td>Fecha Inicio</td>
    <td>Fecha t&eacute;rmino</td>
  </tr>
  <tr>
    <td><?php echo $fila_unidad['cant_horas'] ?></td>
    <td><?php echo $fila_unidad['cant_semanas'] ?></td>
    <td><?php echo CambioFD($fila_unidad['fecha_inicio']) ?></td>
    <td><?php echo CambioFD($fila_unidad['fecha_termino']) ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<br />
<?php }else{
$rs_ramo = $ob_unidad->traeRamo($conn,$fila_unidad['id_curso'],$fila_unidad['id_ramo']);
$rs_dicta =$ob_unidad->traeDicta($conn,$fila_unidad['id_ramo']);


	
	?>
<table width="650" border="0" align="center" >
    <tr class="cuadro02 tablaredonda">
      <td colspan="3" align="center">Planificaci&oacute;n Mensual </td>
    </tr>
    <tr class="cuadro02 tablaredonda">
      <td colspan="3">Datos Generales</td>
    </tr>
    <tr >
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr class="cuadro02 tablaredonda">
      <td>Asignatura</td>
      <td>Curso</td>
      <td>Docente</td>
    </tr>
    <tr class="cuadro01 tablaredonda">
      <td><?php echo pg_result($rs_ramo,1); ?></td>
      <td><?php echo CursoPalabra($fila_unidad['id_curso'],1,$conn); ?></td>
      <td><?php echo pg_result($rs_dicta,2); ?></td>
    </tr>
    <tr class="cuadro02 tablaredonda">
      <td>Horas efectivas mensuales</td>
      <td>Semanas efectivas </td>
      <td>Fecha Inicio/<br />
        Fecha t&eacute;rmino</td>
    </tr>
    <tr class="cuadro01 tablaredonda">
      <td><?php echo $fila_unidad['cant_horas'] ?></td>
      <td><?php echo $fila_unidad['cant_semanas'] ?></td>
      <td><?php echo CambioFD($fila_unidad['fecha_inicio']) ?> a <?php echo CambioFD($fila_unidad['fecha_termino']) ?></td>
    </tr>
  </table>

<?php }
$rs_clase = $ob_unidad->traeClasesSemana($conn,$ipl);
?>
<br />
<br />
<table width="650" border="0" align="center">
  <tr class="cuadro02 tablaredonda">
    <td>Semana</td>
    <td>Aprendizajes esperados</td>
    <td>Actividades</td>
    <td>Indicadores de Evaluaci&oacute;n</td>
  </tr>
  <?php for($c=0;$c<pg_numrows($rs_clase);$c++){
	  $fila_semana = pg_fetch_array($rs_clase,$c);
	  ?>
  <tr>
    <td></td>
    <td></td>
    <td><?php echo $fila_semana['actividades'] ?></td>
    <td>&nbsp;</td>
  </tr>
  <?php }?>
</table>




</div>
<?
}
?>
