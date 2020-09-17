<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "Mod_Ensayo_PSU.php";

//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$obj_EnsayoPSU = new EnsayoPSU($conn);
$funcion = $_POST['funcion'];
	
	if($funcion == 1){
			
		   $id_ano=$_POST['id_ano'];	
		  $result = $obj_EnsayoPSU->carga_cursos($id_ano);
		  if($result){
		$select = "<select name='select_cursos' id='select_cursos'  onchange='carga_ramos(this.value)'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
			$select .= "<option value='".$fila['id_curso']."' >".$Curso_pal."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	if($funcion==carga_ramos){
			$id_curso=$_POST['id_curso'];
		  $result = $obj_EnsayoPSU->carga_ramos($id_curso);
		  if($result){
		$select = "<select name='select_ramos' id='select_ramos' onchange='carga_alumnos(this.value)'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
		
			$select .= "<option value='".$fila['id_ramo']."'>".$fila['nombre']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
				}else{ 
				   echo 0;
		}	
	}
	
	
	
if($funcion==lista_alumnos){
			$id_curso=$_POST['id_curso'];
			$ano=$_POST['ano'];
			$id_ramo=$_POST['id_ramo'];
			
		  $result = $obj_EnsayoPSU->carga_lista_alumnos($id_curso,$ano);
		  
		  $sql="select distinct fecha from ensayos_psu eps where eps.id_curso=".$id_curso." and eps.id_ramo=".$id_ramo." order by fecha";
		  $regis_2=pg_Exec($conn,$sql);
		
			  ?>
             <div align="left"> <input type="button" value="E" class="botonxx"  /> 
                  Eliminar 
                     <input type="button" value="M" class="botonxx"  /> 
                  Modificar</div><br />

			  <table width="%" border="1" align="left" style="border-collapse:collapse" >
              
              <tr class="color_fondo" style="font-size:12px">
			  <th class="textonegrita" width="250" >Alumno
			    <input name="curso" type="hidden" id="curso" value="<?php echo $id_curso ?>" />
			    <label for="ramo"></label>
			    <input name="ramo" type="hidden" id="ramo" value="<?php echo $id_ramo ?>" /></th>
			  <th class="textonegrita" width="50" >Puntaje</th>
              <?
              	
				for($x=0;$x<@pg_numrows($regis_2);$x++){
					
					$fila_fecha=pg_fetch_array($regis_2,$x);
					
					$fecha=$fila_fecha['fecha'];
					
					$fecha_separ=explode('-',$fecha);
					
					 $fecha_ano=$fecha_separ[0];
					 $fecha_mes=$fecha_separ[1];
					 $fecha_dia=$fecha_separ[2];
					 $fecha_nueva=$fecha_dia.'/'.$fecha_mes.'/'.$fecha_ano;

$fecha_del=$fecha_ano.'-'.$fecha_mes.'-'.$fecha_dia;
					 
					 
					?>
				<td class="textonegrita"><?=$fecha_nueva;?>
				  <label for="fecha_$x"></label>
			    <input name="fecha_$x" type="hidden" id="fecha_<?php echo $x ?>" value="<?php echo $fecha_del ?>" /></td>
				<td class="textonegrita"><input type="button" value="M" class="botonxx" onclick="modificarItem(<?php echo $x ?>)" /></td>
				<td class="textonegrita"><input type="button" value="E" class="botonxx" onclick="deleteItem(<?php echo $x ?>)" /></td>
					
					<?
										
					}
			  
			  ?>
              
			</tr>
			
			<?
			for($e=0;$e<@pg_numrows($result);$e++){
				$fila = pg_fetch_array($result,$e);
		 
		$nombre_alumno=substr($fila['nombre_alu'],0,6);
			?>
					
	<tr align="center" style="font-size:9px;">
	<td width="250"><?=$fila['ape_pat'].' '.$fila['ape_mat'].' '.$nombre_alumno?>&nbsp;
    <input type="hidden" id="rut_alumno<?=$e?>" value="<?=$fila['rut_alumno'];?>" ></td>
	
	<td width="50"><input type='text' id='TXT_nota<?=$e?>' name='TXT_nota<?=$e?>' size='3' maxlength='3'>
    </td>
    
			 <?
		
	for($i=0;$i<@pg_numrows($regis_2);$i++){
		$fila_fecha=pg_fetch_array($regis_2,$i);
		 $sql="select * from ensayos_psu eps where eps.id_curso=".$id_curso." and eps.id_ramo=".$id_ramo." and rut_alumno=".$fila['rut_alumno']."
		AND fecha='".$fila_fecha['fecha']."' order by fecha";	
		$regis_3=pg_Exec($conn,$sql);
		$fila_3 = pg_fetch_array($regis_3,0);
		$puntaje=$fila_3['puntaje'];
			?>
			<td width="%" colspan="3">&nbsp;<?=$puntaje?></td>
			<?
			}
		} 
			
	?>
			<input type="hidden" id="contador" value="<?=$e?>">
			</tr>
			
			<?
			
	}	
 
 ?>
</table>