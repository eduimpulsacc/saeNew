<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_archivos_publicos.php";

$obj_SubirArchivo = new SubirArchivo($conn);

$funcion = $_POST['funcion'];
	
	
	
	if($funcion==1)
	{
		$rdb=$_POST['rdb'];
		$id_ano=$_POST['id_ano'];
		$result =$obj_SubirArchivo->get_tipo_archivos_publicos($rdb,$id_ano);	
		
			?>
            <select id="tipo" name="tipo" >
            <option value="0">Seleccione</option>
            <?
            	for($i=0;$i<pg_numrows($result);$i++)
				{
					$fila = pg_fetch_array($result,$i);
					?>
                    	<option value="<?=$fila['id_tipo'];?>"><?=$fila['tipo_archivo'];?></option>
                        
                    <?
				}
			?>
            </select>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img title="Agregar Tipo" align="middle" src="../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Add.png" width="24" height="24" style="cursor:pointer;" onClick="abre_dialog()">
            <?			
	}
	
	
	
	if($funcion==2)
	{
		$rdb=$_POST['rdb'];
		$id_ano=$_POST['id_ano'];
		$tipo = $_POST['tipo'];	
		
		$result = $obj_SubirArchivo->add_tipo($rdb,$id_ano,$tipo);
		if($result){
			echo 1;
			}else{
			echo 0;	
			}
		
	}
	
	if($funcion==3){
		
		$result = $obj_SubirArchivo->get_archivos_publicos($rdb,$id_ano);
		
		if( pg_numrows($result)>0){
		?>
        <table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr class="tableindex">
    <td width="466">Nombre</td>
    <td colspan="2" align="center">Acciones</td>
    </tr>
    <?php for($i=0;$i<pg_numrows($result);$i++){
		$fila = pg_fetch_array($result,$i);
		?>
  <tr>
    <td height="38">&nbsp;<?php echo $fila['nombre_archivo'] ?></td>
    <td width="95" align="center"><a href="archivos/<?php echo $fila['nombre_archivo']?>" target="_blank"><img src="../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Search.png" width="24" height="24" /></a></td>
    <td width="81" align="center"><img src="../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Delete.png" width="24" height="24" onclick="quita(<?php echo $fila['id_archivo'] ?>)" /></td>
  </tr>
  <?php }?>
</table>

        <?
		}
	}
	
if($funcion==4){

$rs = $obj_SubirArchivo->get_archivos_publicos_uno($arc);

$nombre_archivo = pg_result($rs,5);

unlink('/var/www/html/sae3.0/admin/institucion/ano/archivos_publicos/archivos/'.$nombre_archivo);

$obj_SubirArchivo->delArchivoCurso($arc);
$rs2 = $obj_SubirArchivo->elimina_min($arc);




}

if($funcion==5){
 
	$rs = $obj_SubirArchivo->getCursos($id_ano);
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td><input id="st" type="checkbox" value="" onclick="sal()" />
    TODOS</td>
  </tr>
 	<?php for($i=0;$i<pg_numrows($rs);$i++){
		$f=pg_fetch_array($rs,$i);
		?>
     <tr>
    <td><input name="cur[]" class="cur" type="checkbox" value="<?php echo $f['id_curso']?>" /><?php echo CursoPalabra($f['id_curso'],1,$conn); ?></td>
  </tr>
	<?php } ?>
    </table>
    <?
}

	/*if($funcion==carga_emp){
		  $rdb=$_POST['rdb'];
		  $fecha=$_POST['fecha'];
		  $result = $obj_AtrasosMinutosEmp->carga_empleados($rdb);
		  //if($result){
			    $table = '<table width="450" border="1"  align="center" style="border-collapse:collapse;" >
              <tr class="tableindex">
			  <th width="%" >Nombre</th>
			  <th width="50" >Minutos</th>
			  <th width="50" >Modifica</th>
			  <th width="50" >Elimina</th>
			</tr>
			<tbody>';
			$contador=0;
			for($e=0;$e<pg_numrows($result);$e++){
				$fila = pg_fetch_array($result,$e);
				
		 $sql="select * from atraso_minutosemp where fecha_atraso='".$fecha."' and rut_empleado=".$fila["rut_emp"];
			 $regis = @pg_Exec($conn,$sql);		
			 $fila_minutos = pg_fetch_array($regis,0);
				
	$table .= ' <tr align="left" style="font-size:11px;" >
	<td width="%">'.$fila['nombre_emp'].$fila['ape_pat'].$fila['ape_mat'].'<input type="hidden" id="rut_emp'.$e.'" value='.$fila["rut_emp"].'>&nbsp;
	
	</td>
	
	<td width="%" align="center">'.$minuto ="<input type='text' id='minuto".$e."' size='2' maxlength='2' name='minuto".$e."' value=".$fila_minutos['minutos_atraso']." >".'&nbsp;</td>
	<td width="%" align="center">'.$Modifica ="<input type='button' class='botonXX' id='modifica".$e."' size='3' value='M' onclick='modificar(".$fila['rut_emp'].",$e)'  >".'&nbsp;</td>
	<td width="%" align="center">'.$Elimina ="<input type='button' class='botonXX' id='elimina".$e."' size='3' value='E' onclick='elimina(".$fila['rut_emp'].")' >".'&nbsp;</td>
				</tr>'; 
				$contador++;
			}// fin for
			
			$table .="<input type='hidden' id='contador'  value='".$contador."'";
			$table .= "<tbody></table>";
			echo $table;
				//}else{ 
				 //  echo 0;
		//}	
	}
	
	
	if($funcion==modificaM){
		
		$rut_emp=$_POST['rut_emp'];
		$fecha=$_POST['fecha'];
		$minutos=$_POST['minutos'];
		
		$result=$obj_AtrasosMinutosEmp->modifica_min($rut_emp,$fecha,$minutos);
		
		if($result){
			echo 1;
			}else{
			echo 0;	
			}
		
				
		}
	
	
	if($funcion==eliminaM){
		
		$rut_emp=$_POST['rut_emp'];
		$fecha=$_POST['fecha'];
		
		
		$result=$obj_AtrasosMinutosEmp->elimina_min($rut_emp,$fecha);
		
		if($result){
			echo 1;
			}else{
			echo 0;	
			}
		
				
		}
	*/
	
	
	
	
 

?>