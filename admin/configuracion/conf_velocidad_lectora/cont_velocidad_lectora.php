<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_velocidad_lectora.php";

$obj_VelocidadLec = new VelocidadLec($conn);
$funcion = $_POST['funcion'];
	
	
	if($funcion == 0){
			
		  $id_ano=$_POST['id_ano'];	
		  $result = $obj_VelocidadLec->carga_grado($id_ano);
		  if($result){
		?><select name='select_gradoCurso' id='select_gradoCurso' >
		<option value='0' select='select' >(Selecccionar)</option>
				<?
		for($i=0;$i<@pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			?><option value='<?php echo $fila['ensenanza'].'-'.$fila['grado_curso'] ?>'><?php echo $fila['tipo_grado'] ?></option>
		<?php  }?>  
		</select> 
		<?
		 }else{
		 echo 0;			
		 }
	}
	
	
 if($funcion == 1){
		 $id_ano=$_POST['id_ano'];
		 $ensenanza = $_POST['ensenanza'];
		 $grado_curso = $_POST['grado_curso'];
		 $concepto = $_POST['concepto'];
		 $rango_ini = $_POST['rango_ini'];
		 $rango_fin = $_POST['rango_fin'];
		 $id_concepto =$_POST['id_concepto'];
		 $result = $obj_VelocidadLec->guardad_vel_lec($id_ano,$grado_curso,$concepto,$rango_ini,$rango_fin,$ensenanza,$id_concepto);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
	   }
	  }
	 
	
	
	if($funcion==2){
			$id_ano=$_POST['id_ano'];
			$rdb=$_POST['rdb'];
		  $result = $obj_VelocidadLec->Carga_Vel_lec($id_ano);
		  
		  ?>
          <table align="center" width="650" border="1" style="border-collapse:collapse">
          <tr class="tableindex">
          <td width="389">Categoria Velocidad Lectora</td>
		  <?
		  for($e=0;$e<@pg_numrows($result);$e++){
				$fila = pg_fetch_array($result,$e);
				$ense=$fila['tipo_grado'];
				$grado = $fila['grado_curso'];
				
				 
				?>
             
			<td colspan="2" align="center"><?=$ense;?></td>
			 <?
             }
			 
			 if(!isset($ense)){
				 return false;;
				 echo "---->alguna wea!!!!";
				 }
		     ?>
		</tr>
        <?
		 $sql="select id_concepto,nombre_concepto from concepto_velocidad_lectora c
where rdb=".$rdb;
		 $regis = pg_Exec($conn,$sql) or die( "Error bd select 2".$sql);	
        for($i=0;$i<pg_numrows($regis);$i++){
				$fila = pg_fetch_array($regis,$i);
			 ?><tr>
			<td width="389"><?=utf8_decode($fila['nombre_concepto']);?></td>
             <?
			 
		$sql2="select * from velocidad_lectora v inner join 
         concepto_velocidad_lectora cv on v.id_concepto=cv.id_concepto 
          where cv.rdb=".$rdb." and cv.id_concepto=".$fila['id_concepto']." ORDER BY ensenanza,grado_curso ASC";
		  
		 $regis2 = pg_Exec($conn,$sql2) or die( "Error bd select 2".$sql2);	
		  for($e=0;$e<@pg_numrows($regis2);$e++){
				$fila2 = pg_fetch_array($regis2,$e);
			 ?>
            <td width="129"><?=$fila2['rango_inicial'];?>
            
            
            </td>
            <td width="110"><?=$fila2['rango_final'];?></td>
			 <?
             }
			 }
		     ?>
        </tr>
          </table>
          <br><br>
          <div id="btn_mod" style="border-left:92;"><input type="button"  class="botonXX" id="btnModifica" value="MODIFICAR" onClick="modifica_notas()"></div>
          
          
		  <?
	
	}
	
	
	
	if($funcion == 3){
		 $rdb = $_POST['rdb'];
		  $result = $obj_VelocidadLec->carga_concepto($rdb);
		 
		  if($result){
		$select = "<select name='cmb_funcion' id='cmb_funcion' style='margin-left:0px'>
		<option value='0' select='select'>(Selecccionar)</option>";
				
		for($i=0;$i<@pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_concepto']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre_concepto']))))."</option>";
				
		 }  // for 2 
				
		 $select .= "</select>"; 
		  echo $select.'&nbsp;&nbsp;<input type="button" name="" id=""  value="+" class="botonXX" onclick="ventana_ingreso()"/>';
			
		 }else{
            
		 echo 0;			
			
		 }
		  
		 }
	
	
	if($funcion == 4){
		 $rdb = $_POST['rdb'];
		 $nombre_funcion = $_POST['nombre_funcion'];
		 $result = $obj_VelocidadLec->guarda_concepto($rdb,$nombre_funcion);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}
	
	
	
	
	if($funcion==5){
			$id_ano=$_POST['id_ano'];
			$rdb=$_POST['rdb'];
		  $result = $obj_VelocidadLec->Carga_Vel_lec($id_ano);
		  
		  ?>
          <form id="mvel">
          <table align="center" width="650" border="1" style="border-collapse:collapse">
          <tr class="tableindex">
          <td width="389">Categoria Velocidad Lectora</td>
		  <?
		  for($e=0;$e<@pg_numrows($result);$e++){
				$fila = pg_fetch_array($result,$e);
				 $ense=$fila['tipo_grado'];
			 ?>
             
			<td colspan="2" align="center"><?=$ense;?></td>
			 <?
             }
		     ?>
		</tr>
        <?
		 $sql="select id_concepto,nombre_concepto from concepto_velocidad_lectora c
where rdb=".$rdb;
		 $regis = pg_Exec($conn,$sql) or die( "Error bd select 2".$sql);	
        for($i=0;$i<pg_numrows($regis);$i++){
				$fila = pg_fetch_array($regis,$i);
			 ?><tr>
			<td width="389"><?=$fila['nombre_concepto'];?></td>
             <?
			 
		 $sql2="select * from velocidad_lectora v inner join 
         concepto_velocidad_lectora cv on v.id_concepto=cv.id_concepto 
          where cv.rdb=".$rdb." and cv.id_concepto=".$fila['id_concepto']." ORDER BY grado_curso ASC";
		  
		 $regis2 = pg_Exec($conn,$sql2) or die( "Error bd select 2".$sql2);	
		 
		  for($e=0;$e<@pg_numrows($regis2);$e++){
				$fila2 = pg_fetch_array($regis2,$e);
				
			 ?>
            <td width="129">
          <input type="text" size="3" maxlength="3" id="txtranini<?=$i?><?=$e;?>" value="<?=$fila2['rango_inicial'];?>" />
           <input type="hidden" size="3" maxlength="2" id="txtidvel<?=$i?><?=$e;?>" value="<?=$fila2['id_vel_lec'];?>" />
           
            </td>
            <td width="110"><input type="text" size="3" maxlength="3" id="txtranfin<?=$i?><?=$e;?>" value="<?=$fila2['rango_final'];?>" />
<input type="button" value="M" size="3" class="botonXX" onclick="modifica_todo(<?=$i;?>,<?=$e;?>)">
<?php if($_PERFIL==0){?>
<input type="button" value="M2" size="3" class="botonXX" onclick="modifica_todo2(<?=$i;?>,<?=$e;?>)">				
<?php }?>
           
         </td>
			 <?
             }
			 }
		     ?>
             
          </tr>
         
          </table>
          </form>
          <br><br>
          <div id="btn_atras" style="border-left:92;"><input type="button"  class="botonXX" id="btnAtras" value="ATRAS" onClick="Fvolver()"></div>
		  <?
	
	}
	
	
	if($funcion == 6){
		 $notaini = $_POST['notaini'];
		 $notafin = $_POST['notafin'];
		 $idvel = $_POST['idvel'];
		
		 $result = $obj_VelocidadLec->modifica_vel($notaini,$notafin,$idvel);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}
	
if($funcion==7){
	//show($_POST);
	$rs_lista = $obj_VelocidadLec->listaConCal($rdb);
	?>
    <hr />
	 <table align="center" width="650" border="1" style="border-collapse:collapse">
          <tr class="tableindex">
          <td colspan="3">Conceptos Calidad Lectora</td>
         <!-- <td width="71" rowspan="3"><input type="button" name="button2" id="button2" value="Eliminar" class="botonXX" onclick="quitacal(<?php echo $fila['id_concepto'] ?>)" /></td>
          </tr>-->
          <tr class="tableindex">
            <td width="306">Nombre</td>
            <td width="177">Sigla</td>
            <td>&nbsp;</td>
          </tr>
          <?php if(pg_numrows($rs_lista)>0){
			  for($i=0;$i<pg_numrows($rs_lista);$i++){
				  $fila=pg_fetch_array($rs_lista,$i);
			  ?>
          <tr>
            <td id="cnom<?php echo $fila['id_concepto'] ?>"><?php echo $fila['nombre'] ?></td>
            <td id="ssig<?php echo $fila['id_concepto'] ?>"><?php echo $fila['sigla'] ?></td>
            <td width="68" align="center" id="btnn<?php echo $fila['id_concepto'] ?>"><input type="button" name="button" id="button" value="Modificar" class="botonXX" onclick="cambiaCCal(<?php echo $fila['id_concepto'] ?>)" /></td>
          </tr>
          <?php }?>
         <?php  }else
          {?>
          <tr><td colspan="4">No Existen registros</td>
          <?php }?>
	 </table>
	 <br />
	 <br />
      <table align="center" width="650" border="1" style="border-collapse:collapse">
         <tr class="tableindex">
          <td width="389" colspan="3">Agregar concepto Calidad Lectora</td>
        </tr>
          <tr class="tableindex">
            <td>Nombre</td>
            <td align="center">Sigla</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr >
            <td><input name="tt_nombre" type="text" id="tt_nombre" size="50" /></td>
            <td><input type="text" name="tt_sigla" id="tt_sigla" /></td>
            <td align="center"><input type="button"  class="botonXX" id="btnAtras2" value="CREAR CONCEPTO" onclick="calCrear()" /></td>
          </tr>
          </table>
      <br />
      <?  
}
if($funcion==8){
//show($_POST);
$result=$obj_VelocidadLec->guardaConCal($rdb,utf8_decode($nombre),utf8_decode($sigla));
if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
}
if($funcion==9){
//show($_POST);
$result=$obj_VelocidadLec->quitaConCal($id_c);
if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
}
if($funcion==10){
$result=$obj_VelocidadLec->ConCalUno($id_c);	
$nombre=pg_result($result,2);
$glosa=pg_result($result,3);
echo $nombre."_".$glosa;
}

if($funcion==11){
	//show($_POST);
$result=$obj_VelocidadLec->modCalUno($id_c,utf8_decode($nombre),utf8_decode($sigla));
if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
}
	
?>
