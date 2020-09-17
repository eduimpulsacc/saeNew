<?php session_start();

require "mod_informe.php";

//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$obj_asistencia = new Asistencia($conn);
$funcion = $_POST['funcion'];


if($funcion == 1){
			
		   $rdb=$_POST['rdb'];	
		  $result = $obj_asistencia->carga_anos($rdb);
		  if($result){
			  ?>
		<select name='select_anos' id='select_anos' onchange='carga_curso(this.value)'>
		<option value='0' select='select' >(Seleccionar)</option>
		<?
		
		
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			?>
			<option value="<?php echo $fila['id_ano'] ?>" <?php echo ($fila['id_ano']==$_ANO)?"selected":"" ?>><?php echo $fila['nro_ano'] ?></option>;
		 <?
         }  
		?>
		</select> 
		 <?
		 }else{
		 echo 0;			
		 }
	}

if($funcion==2){
	$rs_curso = $obj_asistencia->carga_cursos($anio);
?>
	<select id="cmb_curso" name="cmb_curso">
    	<option value="0">seleccione...</option>
<?
		for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila= pg_fetch_array($rs_curso,$i);
?>
		<option value="<?=$fila['id_curso'];?>"><?=CursoPalabra($fila['id_curso'],1,$conn)?>		
	<?	}
?>        
    </select>
<?		
}
?>