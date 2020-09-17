<? 

session_start();
require "../empleado/mod_empleado.php";


$funcion = $_POST['funcion'];

$ob_Empleado = new Empleado($_IPDB,$_ID_BASE);

if($funcion==1){
	$rs_cargo = $ob_Empleado->Listado($cargo,$_INSTIT);
	
?><br />
<br />

<table width="90%" border="0" align="center" cellpadding="10">
  <tr>
    <td align="center" class="textonegrita">&nbsp;<strong>LISTADO DE EMPLEADOS
    </strong></td>
  </tr>
</table>

<table width="90%" border="1" align="center" style="border-collapse:collapse">
  <tr class="tableindex">
    <td>RUT </td>
    <td>NOMBRE</td>
    <td> EVALUADOR</td>
    <td>EVALUADO</td>
    <td>RELACIONES</td>
    <td>EVALUACIONES</td>
    <td>ELIMINA <br />
    REGISTROS</td>
    <td>MODIFICA<br />
CARGOS</td>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_cargo);$i++){
	  $fila =pg_fetch_array($rs_cargo,$i);
	  
	  $rs_evaluador = $ob_Empleado->Evaluador($fila['rut_emp'],$_PERIODO);
	  if(pg_num_rows($rs_evaluador)==0){
	  		$evaluador= "<img src='img/PNG-48/ok.png' width='22' height='22' border='0' title='NO EXISTEN REGISTROS' onclick='agregar_apo(".$fila['rut_alumno'].")'/>";
			$sw1=1;
	  }else{
		 	$evaluador="<img src='img/PNG-48/Warning.png' width='22' height='22' border='0' title='EXISTEN REGISTROS' onclick='agregar_apo(".$fila['rut_alumno'].")'/>";
			$sw1=0;
	  }
	  
	  $rs_evaluado = $ob_Empleado->Evaluado($fila['rut_emp'],$_PERIODO);
	  if(pg_num_rows($rs_evaluado)==0){
	  		$evaluado= "<img src='img/PNG-48/ok.png' width='22' height='22' border='0' title='NO EXISTEN REGISTROS' onclick='agregar_apo(".$fila['rut_alumno'].")'/>";
			$sw2=1;
	  }else{
		 	$evaluado="<img src='img/PNG-48/Warning.png' width='22' height='22' border='0' title='EXISTEN REGISTROS' onclick='agregar_apo(".$fila['rut_alumno'].")'/>";
			$sw2=0;
	  }
	  
	  $rs_relacion = $ob_Empleado->Relacion($fila['rut_emp'],$_PERIODO);
	  if(pg_num_rows($rs_relacion)==0){
	  		$relacion= "<img src='img/PNG-48/ok.png' width='22' height='22' border='0' title='NO EXISTEN REGISTROS' onclick='agregar_apo(".$fila['rut_alumno'].")'/>";
			$sw3=1;
	  }else{
		 	$relacion="<img src='img/PNG-48/Warning.png' width='22' height='22' border='0' title='EXISTEN REGISTROS' onclick='agregar_apo(".$fila['rut_alumno'].")'/>";
			$sw3=0;
	  }
	  
	  $rs_evaluaciones = $ob_Empleado->Evaluaciones($fila['rut_emp'],$_PERIODO);
	  if(pg_num_rows($rs_evaluaciones)==0){
	  		$evaluaciones= "<img src='img/PNG-48/ok.png' width='22' height='22' border='0' title='NO EXISTEN REGISTROS' onclick='agregar_apo(".$fila['rut_alumno'].")'/>";
			$sw4=1;
	  }else{
		 	$evaluaciones="<img src='img/PNG-48/Warning.png' width='22' height='22' border='0' title='EXISTEN REGISTROS' onclick='agregar_apo(".$fila['rut_alumno'].")'/>";
			$sw4=0;
	  }
	?>
	  
  <tr>
    <td class="textosimple">&nbsp;<?=$fila['rut_emp']."-".$fila['dig_rut'];?>&nbsp;</td>
    <td class="textosimple">&nbsp;<?=$fila['nombre_empleado'];?></td>
    <td class="textosimple" align="center">&nbsp;<?=$evaluador;?></td>
    <td class="textosimple" align="center">&nbsp;<?=$evaluado;?></td>
    <td class="textosimple" align="center">&nbsp;<?=$relacion;?></td>
    <td class="textosimple" align="center">&nbsp;<?=$evaluaciones;?></td>
    <td class="textosimple" align="center">&nbsp;<a href="#"><? if($sw1==0 || $sw2==0 || $sw3==0 || $sw4==0) echo "<img src='img/PNG-48/Delete.png' width='22' height='22' border='0' title='Elimina Configuracion' onclick='elimina_conf(".$fila['rut_emp'].")'/>"; else echo "";?></a></td>
    <td class="textosimple" align="center">&nbsp;<? if($sw1==1 && $sw2==1 && $sw3==1 && $sw4==1) echo "<img src='img/PNG-48/Add.png' width='22' height='22' border='0' title='Modificar Cargos' onclick='modifica_cargos(".$fila['rut_emp'].")'/>"; else echo "";?></td>
  </tr>
  <? } ?>
  
</table>
<?		
}

if($funcion==2){
	
	$rs_cargo = $ob_Empleado->Cargos();
	$rs_empleado = $ob_Empleado->BuscaEmpleado($rut,$_INSTIT);
	$rut_emp = pg_result($rs_empleado,0)."-".pg_result($rs_empleado,1);	
	$nombre = pg_result($rs_empleado,2);
	for($i=0;$i<=pg_numrows($rs_empleado);$i++){
		$fila = pg_fetch_array($rs_empleado,$i);
		$id_cargo[$i] = $fila['cargo'];
		$nombre_cargo[$i] = $fila['nombre_cargo'];
		
	}
?><br />
<br />
<br />

<table width="90%" border="0" align="center">
  <tr>
    <td width="13%" class="textonegrita">RUT</td>
    <td width="3%" class="textonegrita">:</td>
    <td width="42%" class="textosimple">&nbsp;<?=$rut_emp;?></td>
    <td width="42%" class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita">NOMBRE</td>
    <td class="textonegrita">:</td>
    <td class="textosimple">&nbsp;<?=$nombre;?></td>
    <td class="textosimple" align="right"><a href="#"><img src="img/PNG-48/Save.png" width="30" height="30"  title="GUARDAR MODIFICACION" onclick="guarda_cargos(<?=$rut;?>,<?=$_INSTIT;?>)"/><img src="img/PNG-48/Back.png" width="30" height="30"  title="VOLVER A LISTADO" onclick="carga_tabla(<? echo $id_cargo[0];?>)"/></a></td>
  </tr>
</table>
<table width="90%" border="1" align="center" cellspacing="5" style="border-collapse:collapse">
  <tr class="tableindex">
    <td>CARGO 1</td>
    <td>CARGO 2</td>
  </tr>
  <tr>
    <td>&nbsp;
	<select name="cmbCARGO1" id="cmbCARGO1" >
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_cargo);$i++){
				$fila =pg_fetch_array($rs_cargo,$i);
				if($id_cargo[0]==$fila['id_cargo']){
		?>
        		<option value="<?=$fila['id_cargo'];?>" selected="selected"><?=$fila['nombre_cargo'];?></option>
         <? }else{?>
		        <option value="<?=$fila['id_cargo'];?>"><?=$fila['nombre_cargo'];?></option>
         <? } 
		}
		 ?>

			
    </select>
	</td>
    <td>&nbsp;<select name="cmbCARGO2" id="cmbCARGO2" >
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_cargo);$i++){
				$fila =pg_fetch_array($rs_cargo,$i);
				if($id_cargo[1]==$fila['id_cargo']){
		?>
        		<option value="<?=$fila['id_cargo'];?>" selected="selected"><?=$fila['nombre_cargo'];?></option>
         <? }else{?>
		        <option value="<?=$fila['id_cargo'];?>"><?=$fila['nombre_cargo'];?></option>
         <? } 
		}
		 ?>

			
    </select></td>
  </tr>
</table><br />


<?	
}

if($funcion==3){
	echo $rs_cargo = $ob_Empleado->Guarda_Cargo($cargo1,$cargo2,$rut_emp,$rdb);
	
		
}

if($funcion==4){
	echo $rs_elimina=$ob_Empleado->Elimina_Conf($rut_emp,$_PERIODO,$_ANO,$_INSTIT);	
}


?>