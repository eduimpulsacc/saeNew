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
		?><select name='select_cursos' id='select_cursos' onchange= <?php if($rdb!=9510){?>'carga_ramos(this.value)'<?php }else{?>'carga_alumnos(this.value)'<?php }?>>
		<option value='0' select='select' >(Selecccionar)</option>
        <?
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
			?>
			<option value="<?php echo $fila['id_curso'] ?>"><?php echo $Curso_pal ?></option>
            <?
		 }  // for 2
		 ?> 
		</select> 
		<?
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
			
			$an="";
			if($id_ramo!='0000'){
			 $an="and eps.id_ramo=".$id_ramo;	
			}
			
		  $result = $obj_EnsayoPSU->carga_lista_alumnos($id_curso,$ano);
		  
		  $sql="select distinct fecha from lectura_veloz eps where eps.id_curso=".$id_curso."  $an  order by fecha";
		  $regis_2=pg_Exec($conn,$sql);
		
			  ?>
			  <table width="650" border="1" align="center" style="border-collapse:collapse" >
              <tr class="color_fondo" style="font-size:12px" >
			  <th class="textonegrita" width="250">Alumno</th>
			  <th class="textonegrita" width="50" >Palabras</th>
			  <th class="textonegrita" width="50" >Concepto</th>
              <?
              	
				for($x=0;$x<@pg_numrows($regis_2);$x++){
					
					$fila_fecha=pg_fetch_array($regis_2,$x);
					
					$fecha=$fila_fecha['fecha'];
					
					$fecha_separ=explode('-',$fecha);
					
					 $fecha_ano=$fecha_separ[0];
					 $fecha_mes=$fecha_separ[1];
					 $fecha_dia=$fecha_separ[2];
					 $fecha_nueva=$fecha_dia.'/'.$fecha_mes.'/'.$fecha_ano;
					 
					?>
				<td colspan="2" align="center" class="textonegrita"><?=$fecha_nueva;?></td>
				<?
										
					}
			  
			  ?>
              
			</tr>
			
			<?
			for($e=0;$e<@pg_numrows($result);$e++){
				$fila = pg_fetch_array($result,$e);
		 
		$nombre_alumno=strtoupper($fila['ape_pat'].' '.$fila['ape_mat'].' '.$fila['nombre_alu']);
			?>
					
	<tr align="center" style="font-size:9px;">
	<td width="250" align="left">&nbsp;<?=$nombre_alumno?>
    <input type="hidden" id="rut_alumno<?=$e?>" value="<?=$fila['rut_alumno'];?>" ></td>
	
	<td width="50"><input type='text' id='TXT_nota<?=$e?>' name='TXT_nota<?=$e?>' size='3' maxlength='3'></td>
	<td width="50">
    <?php  $sc="select * from velocidad_lectora_calectora where rdb=".$_SESSION['_INSTIT'];
	$rsc=pg_exec($conn,$sc);
	?>
    <select id='CMB_Conc<?=$e?>' name='comb_<?=$e?>'>
    <?php for($rr=0;$rr<pg_numrows($rsc);$rr++){
		$frr= pg_fetch_array($rsc,$rr);
		?>
        <option value="<?php echo $frr['id_concepto'] ?>"><?php echo $frr['nombre'] ?></option>
    <?php }?>
	  </select></td>
    
			 <?
		
	for($i=0;$i<@pg_numrows($regis_2);$i++){
		$fila_fecha=pg_fetch_array($regis_2,$i);
		
		$an="";
			if($id_ramo!='0000'){
			 $an="and eps.id_ramo=".$id_ramo;	
			}
		
		 $sql="select * from lectura_veloz eps where eps.id_curso=".$id_curso."  $an and rut_alumno=".$fila['rut_alumno']."
		AND fecha='".$fila_fecha['fecha']."' order by fecha";	
		$regis_3=pg_Exec($conn,$sql);
		$fila_3 = pg_fetch_array($regis_3,0);
		$palabra=$fila_3['palabra'];
		
		$sconc="select nombre from velocidad_lectora_calectora where id_concepto=".$palabra=$fila_3['concepto'];
		@$rconc=pg_exec($conn,$sconc);
			?>
			<td width="30">&nbsp;<?=$fila_3['palabra']?></td>
			<td width="30"><?php echo @pg_result($rconc,0); ?></td>
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