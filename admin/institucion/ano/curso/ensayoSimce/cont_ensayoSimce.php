<?php session_start();
require('../../../../../util/header.inc');

require "mod_ensayoSimce.php";

//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$obj_EnsayoSimce = new EnsayoSimce($conn);
$funcion = $_POST['funcion'];
if($funcion == 1){
	
$result = $obj_EnsayoSimce->carga_cursos($id_ano);
?>
<select name='select_cursos' id='select_cursos'  onchange='carga_ramos(this.value)'>
		<option value='0' select='select' >(Seleccionar)</option>
       <?php for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);?>
            <option value="<?php echo $fila['id_curso'] ?>" ><?php echo $Curso_pal ?></option>
      <?
	   }
	   ?>
</select>
       <?
}
if($funcion==2){

			$id_curso=$_POST['id_curso'];
		  $result = $obj_EnsayoSimce->carga_ramos($id_curso);
		  if($result){?>
<select name='select_ramos' id='select_ramos' onchange='carga_alumnos(this.value)'>
		<option value='0' select='select' >(Seleccionar)</option>
		<?
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
		?>
			<option value="<?php echo $fila['id_ramo'] ?>"><?php echo $fila['nombre'] ?></option>;
		 <?php }?> 
		 </select>
         <?
				}else{ 
				   echo 0;
		}	
	
}if($funcion==3)
{
$id_curso=$_POST['id_curso'];
$ano=$_POST['ano'];
$id_ramo=$_POST['id_ramo'];	

 $result = $obj_EnsayoSimce->carga_lista_alumnos($id_curso,$ano);
 $result2 = $obj_EnsayoSimce->carga_lista_puntajes($id_curso,$id_ramo);
 ?>
<table  border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td align="center"><strong>NOMBRE ALUMNO</strong></td>
    <td align="center"><strong>PUNTAJE</strong></td>
   <?php  for($x=0;$x<@pg_numrows($result2);$x++){
	   $fila_fecha=pg_fetch_array($result2,$x);?>
       <td class="textonegrita"><input type="button" value="M" class="botonxx" onclick="modificarItem(<?php echo $x ?>)" /></td>
    <td align="center"><strong><?php echo CambioFD($fila_fecha['fecha']) ?> </strong>
      <input type="button" value="E" class="botonxx" onclick="deleteItem(<?php echo $x ?>)" />
      <input name="fecha_<?php echo $x ?>" type="hidden" id="fecha_<?php echo $x ?>" value="<?php echo $fila_fecha['fecha'] ?>" />
   </td>
    <?php }?>
  </tr>
  <tr>
   <?
			for($e=0;$e<@pg_numrows($result);$e++){
				$fila = pg_fetch_array($result,$e);
		 
		$nombre_alumno=substr($fila['nombre_alu'],0,6);
			?>
					
	<tr align="center" style="font-size:9px;">
	<td width="250"><?=$fila['ape_pat'].' '.$fila['ape_mat'].' '.$nombre_alumno?>&nbsp;
    <input type="hidden" name="rut_alumno[]" id="rut_alumno<?=$e?>" value="<?=$fila['rut_alumno'];?>" ></td>
	
	<td width="50"><input type='text' id='TXT_nota<?=$e?>' name='TXT_nota[]' size='3' maxlength='3' class="pun">
    </td>
      <?php  for($y=0;$y<@pg_numrows($result2);$y++){
		  $fila_fecha2=pg_fetch_array($result2,$y);	 
		  ?>
    <td colspan="2"><?php
	 $result3=$obj_EnsayoSimce->puntaje_alumno_fecha($id_curso,$id_ramo,$fila['rut_alumno'],$fila_fecha2['fecha']);
	//var_dump($result3);
	$puntaje = pg_result($result3,5);
	echo ($puntaje==0)?"":$puntaje;
	 ?></td>
	  <?php }?>
  </tr>
  <?php }?>
</table>

 <?
}
if($funcion==4){
//var_dump($_POST);	

$fecha = CambioFE($txtFECHA);

$rut = $_POST['rut_alumno'];
$puntaje = $_POST['TXT_nota'];


$rs_fecha = $obj_EnsayoSimce->puntaje_curso_fecha($select_cursos,$select_ramos,$fecha);
if(pg_numrows($rs_fecha)>0){
echo 0;
}else{

for($i=0;$i<count($rut);$i++){
$rut_alumno=$rut[$i];
$punt=$puntaje[$i];	

if($punt==""){
		continue;
		}
	
$rs_guarda = $obj_EnsayoSimce->guardaPuntaje($ano,$select_ramos,$select_cursos,$rut_alumno,$fecha,intval($punt));	
}
echo 1;
}
}if($funcion==5){
	//var_dump($_POST);
	$rs_elimina =  $obj_EnsayoSimce->elimina_puntaje($curso,$ramo,$fecha);
	
	if($rs_elimina==true){
	echo 1;
	}else{
	echo 0;
	}
}
if($funcion==6)
{
//var_dump($_POST);
$fecha=$_POST['fecha'];
			$ramo=$_POST['ramo'];
			$curso=$_POST['curso'];
 $result = $obj_EnsayoSimce->carga_lista_alumnos($curso,$_ANO);
  ?>
  <input name="curso" type="hidden" id="curso" value="<?php echo $curso ?>" />
  <input name="ramo" type="hidden" id="ramo" value="<?php echo $ramo ?>" />
  <input name="fecha" type="hidden" id="fecha" value="<?php echo $fecha ?>" />
  <table  border="1"  style="border-collapse:collapse" align="center" >
              
              <tr class="tableindex" style="font-size:12px">
                <th class="textonegrita" width="250" >#</th>
			  <th class="textonegrita" width="250" >Alumno
			    
			    <label for="ramo"></label></th>
			  <th class="textonegrita" width="250" >Puntaje</th>
			  
           
              
		    </tr>
			
			<?
			for($e=0;$e<@pg_numrows($result);$e++){
				$fila = pg_fetch_array($result,$e);
				$alumno = $fila['rut_alumno'];
		 
		$nombre_alumno=substr($fila['nombre_alu'],0,6);
		$rspun = $obj_EnsayoSimce->puntaje_alumno_fecha($curso,$ramo,$alumno,$fecha);
			?>
					
	<tr align="center" style="font-size:9px;">
	  <td width="250" align="left"><?php echo $e+1; ?></td>
	<td width="250" align="left"><?=$fila['ape_pat'].' '.$fila['ape_mat'].' '.$nombre_alumno?>&nbsp;<input type="hidden" id="rut_alumno<?=$e?>" value="<?=$fila['rut_alumno'];?>" ></td>
	<td width="250" align="left">
   
    <input type='text' id='TXT_notam<?=$e?>' name='TXT_notam<?=$e?>' size='3' maxlength='3' value="<?php echo pg_result($rspun,5) ?>" />
    
    </td>
	
	
			<!--<input type="text" id="contador" value="<?=$e?>">-->
			</tr>
			
			<?
			
	}	
 
 ?>
</table>
<input type="hidden" id="contador" value="<?=$e?>">
<?
}
if($funcion==7){
	//show($_POST);
	//exit;  
$cadena = explode("*",$funcion);
for($i=0;$i<count($cadena);$i++){
	$separar = explode("|",$cadena[$i]); 
	$alumno =$separar[1]; 
	$puntaje =$separar[2];
	$ramo =$separar[3]; 
	$fecha =$separar[4];
	$curso =$separar[6];
	$ano =$separar[5];
	
	if($puntaje==""){
		continue;
		}
	
	$rspun = $obj_EnsayoSimce->puntaje_alumno_fecha($curso,$ramo,$alumno,$fecha);
	if(pg_numrows($rspun)>0){
	
	$rs_mod = $obj_EnsayoSimce->actPuntaje($curso,$ramo,$alumno,$fecha,$puntaje);
	}
	else{
		$rs_mod =$obj_EnsayoSimce->guardaPuntaje($ano,$ramo,$curso,$alumno,$fecha,intval($puntaje));
	}
	
	
	}
	
	//show($_POST);
}
?>