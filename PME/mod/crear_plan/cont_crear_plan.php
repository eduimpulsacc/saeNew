<? header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "mod_crear_plan.php";

$obCreaPlan = new Crea_Plan($_IPDB,$_ID_BASE);

$funcion=$_POST['funcion'];

if($funcion==1)
{
	$result = $obCreaPlan->IngresaDatos($nombre_proyecto,$ano_1,$ano_4,$presupuesto,$objetivo,$fecha,$estado,$clasificacion,$rdb);	
	if($result){
		echo 1;
	   }else{
		echo 0;	   
	}
}

if($funcion==5)
{
	$result = $obCreaPlan->ModificaDatos($nombre_proyecto,$ano_1,$ano_4,$presupuesto,$objetivo,$fecha,$estado,$clasificacion,$id_proyecto);	
	if($result){
		echo 1;
	   }else{
		echo 0;	   
	}
}


if($funcion==2){
	?>
    	<table width='90%' border='0' align='center'>
			  <tr class='Estilo19'>
				<td>CREAR PLAN</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td align='right'>
       &nbsp;<img src="img/PNG-48/Back.png" id="volver" width="30" height="30" onclick='volver_atras()' onmouseover=this.style.cursor='pointer' title="VOLVER">
       &nbsp;<img src="img/PNG-48/Save.png" id="agregar" width="30" height="30" onclick='IngresoDatos(1)' onmouseover=this.style.cursor='pointer' title="GUARDAR DATOS">				  	   <img src="img/PNG-48/Save.png" id="modifica" width="30" height="30" onclick='IngresoDatos(5)' onmouseover=this.style.cursor='pointer' title="MODIFICAR DATOS">
              </td>
			  </tr>
			</table>
<table width="90%" border="1" style="border-collapse:collapse"  align="center">
<tr>
<td width="176" class="cuadro02">NOMBRE PROYECTO</td>
<td width="458" class="cuadro01"><input type="text" name="txt_nom_proyecto" id="txt_nom_proyecto" size="70"></td>
</tr>
<tr>
<td width="176" class="cuadro02">A&Ntilde;OS DE EJECUCI&Oacute;N</td>
<td width="458" class="cuadro01">
1-<input type="text" name="txt_ano1" id="txt_ano1" size="3" maxlength="4" onblur="correlativo(this.value)">
2-<input type="text" name="txt_ano2" id="txt_ano2" size="3" maxlength="4" readonly="readonly">
3-<input type="text" name="txt_ano3" id="txt_ano3" size="3" maxlength="4" readonly="readonly">
4-<input type="text" name="txt_ano4" id="txt_ano4" size="3" maxlength="4" readonly="readonly"></td>
</tr>
<tr>
<td width="176" class="cuadro02">PRESUPUESTO</td>
<td width="458" class="cuadro01">
$<input type="text" name="txt_presupuesto" id="txt_presupuesto" size="7" maxlength="8" onkeyup="Moneda(this)" onchange="Moneda(this) ">
</td>
</tr>
<tr>
<td width="176" class="cuadro02">OBJETIVO</td>
<td width="458" class="cuadro01">
<textarea id="txt_objetivo" cols="50" ></textarea>
</td>
</tr>
<tr>
<td width="176" class="cuadro02">FECHA</td>
<td width="458" class="cuadro01">
<input type="text" name="txtFECHA" id="txtFECHA" />
</td>
</tr>

<tr>
<td width="176" class="cuadro02">ESTADO</td>
<td width="458" class="cuadro01">
Habilitado    <input type="radio" name="estado" id="etado" value="1" checked="checked" />
Deshabilitado <input type="radio" name="estado" id="etado" value="0" />
</td>
<tr>
<td width="176" class="cuadro02">CLASIFICACI&Oacute;N</td>
<td width="458" class="cuadro01">
Aut&oacute;nomo<input style="margin-left:40" type="radio" name="clasificacion" id="clasificacion" value="0" checked="checked" /><br>
En&nbsp;recuperaci&oacute;n<input style="margin-left:10" type="radio" name="clasificacion" id="clasificacion" value="1" /><br>
Emergente<input style="margin-left:37" type="radio" name="clasificacion" id="clasificacion" value="2" /><br>
</td>
</tr>
</table>
    
    <?
	}
	
	if($funcion==3){
		$result=$obCreaPlan->muestra_datos();
		?>
        
        
		<table width='90%' border='0' align='center' id="tb_agregar">
			  <tr class='Estilo19'>
				<td>CREAR PLAN</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td align='right'>&nbsp;<img src="img/PNG-48/Add.png" id="btn_agregar" width="30" height="30" onclick='tabla_ingreso()' onmouseover=this.style.cursor='pointer' title="GUARDAR DATOS">				  
              </td>
			  </tr>
			</table>
		<table width='90%' border='1' style='border-collapse:collapse' align='center'>
			  <tr class="cuadro02">
				<td>Nombre Proyecto </td>
				<td>A&ntilde;os </td>
				<td>Presupuesto</td>
				<td>Objetivo</td>
                <td>Fecha</td>
                <td>Estado</td>
                <td>Clasificaci&oacute;n</td>
                <td colspan="2" align="center">Opciones</td>
			  </tr>
              <? if(pg_numrows($result)!=0){
				  	for($i=0;$i<pg_numrows($result);$i++){
						$fila = pg_fetch_array($result,$i);
						
						
				?>
			  <tr class="datos">
				<td>&nbsp;<?=$fila['nombre_proyecto'];?></td>
				<td>&nbsp;<?=$fila['nro_ano_1'].' al '.$fila['nro_ano_4'];?></td>
				<td>&nbsp;$<? echo number_format($fila['financiamiento'], 0, '', '.');?></td>
				<td><?=$fila['objetivo'];?></td>
				<td align="center"><?=$fila['fecha'];?></td>
				<td align="center"><?=$fila['estado'];?></td>
                <td align="center"><?=$fila['clasificacion'];?></td>
                <td align="center"><img src="img/PNG-48/Modify.png" width="30" height="30" border="0" onclick="Modificar(<?=$fila['id_proyecto'];?>)" onmouseover=this.style.cursor='pointer' title="MODIFICAR"></td>
				<td align="center"><img src="img/PNG-48/Delete.png" width="30" height="30" alt="Eliminar" border="0" onClick="Elimina(<?=$fila['id_proyecto'];?>)" onmouseover=this.style.cursor='pointer' title="ELIMINAR"></td>
			  </tr>
              <?	 }
			  	}else{?>
			  <tr class="datos">
				<td colspan="6" class="textosimple">SIN INFORMACIÓN</td>
			  </tr>
              
              
              <? } ?>
			</table>
		<?
		}
		

if($funcion==4){
	$result=$obCreaPlan->BuscaDatos($id_proyecto);
	$fila = pg_fetch_array($result,0);
	?>
     <input type="hidden" name="hidden_id_proyecto" id="hidden_id_proyecto" value="<?=$fila['id_proyecto'];?>" />
    <input type="hidden" name="hidden_nombre_proyecto" id="hidden_nombre_proyecto" value="<?=$fila['nombre_proyecto'];?>" />
    <input type="hidden" name="hidden_objetivo" id="hidden_objetivo" value="<?=$fila['objetivo'];?>" />
    <input type="hidden" name="hidden_financia" id="hidden_financia" value="<?=$fila['financiamiento'];?>" />
    <input type="hidden" name="hidden_ano_1" id="hidden_ano_1" value="<?=$fila['nro_ano_1'];?>" />
    <input type="hidden" name="hidden_ano_4" id="hidden_ano_4" value="<?=$fila['nro_ano_4'];?>" />
    <input type="hidden" name="hidden_fecha" id="hidden_fecha" value="<?=$fila['fecha'];?>" />
    <input type="hidden" name="hidden_estado" id="hidden_estado" value="<?=$fila['estado'];?>" />
    <input type="hidden" name="hidden_clasificacion" id="hidden_clasificacion" value="<?=$fila['clasificacion'];?>" />
   <?
	
}

if($funcion==6){
	
	$result = $obCreaPlan->ElimaDatos($id_proyecto);
	if($result){
		echo 1;
		}else{
		echo 0;	
		}
	}


?>