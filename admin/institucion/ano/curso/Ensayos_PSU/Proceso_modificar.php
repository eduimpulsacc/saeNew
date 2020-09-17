<?php 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "Mod_Ensayo_PSU.php";

$institucion=$_INSTIT;
//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$Obj_Ensayo_Psu = new EnsayoPSU($conn);
$funcion = $_POST['funcion'];

/* $sql ="delete from ensayos_psu where id_ramo=".$_POST['ramo']." and id_curso=".$_POST['curso']." and fecha='".$_POST['fecha']."'";

 //if($_PERFIL==0){echo $sql;}

	              $regis=pg_Exec($conn,$sql);
		

		if($regis){
		echo 1;
		}else{
		echo 0;
		}
*/
if($funcion==1){
//var_dump($_POST);
$fecha=$_POST['fecha'];
			$ramo=$_POST['ramo'];
			$curso=$_POST['curso'];
  $result = $Obj_Ensayo_Psu->carga_lista_alumnos($curso,$_ANO);
  ?>
  <input name="curso" type="hidden" id="curso" value="<?php echo $curso ?>" />
  <input name="ramo" type="hidden" id="ramo" value="<?php echo $ramo ?>" />
  <input name="fecha" type="hidden" id="fecha" value="<?php echo $fecha ?>" />
  <table  border="1"  style="border-collapse:collapse" align="center" >
              
              <tr class="tableindex" style="font-size:12px">
			  <th class="textonegrita" width="250" >Alumno
			    
			    <label for="ramo"></label></th>
			  <th class="textonegrita" width="250" >Puntaje</th>
			  
           
              
		    </tr>
			
			<?
			for($e=0;$e<@pg_numrows($result);$e++){
				$fila = pg_fetch_array($result,$e);
				$alumno = $fila['rut_alumno'];
		 
		$nombre_alumno=substr($fila['nombre_alu'],0,6);
		$rspun = $Obj_Ensayo_Psu->traePuntajedia($curso,$ramo,$alumno,$fecha)
			?>
					
	<tr align="center" style="font-size:9px;">
	<td width="250" align="left"><?=$fila['ape_pat'].' '.$fila['ape_mat'].' '.$nombre_alumno?>&nbsp;<input type="hidden" id="rut_alumno<?=$e?>" value="<?=$fila['rut_alumno'];?>" ></td>
	<td width="250" align="left"><input type='text' id='TXT_notam<?=$e?>' name='TXT_notam<?=$e?>' size='3' maxlength='3' value="<?php echo pg_result($rspun,5) ?>" /></td>
	
	
			<!--<input type="hidden" id="contador" value="<?=$e?>">-->
			</tr>
			
			<?
			
	}	
 
 ?>
</table>
<input type="hidden" id="contador" value="<?=$e?>">
<?
}
if($funcion==2){
	//show($_POST);
$cadena = explode("*",$funcion);

for($i=0;$i<count($cadena)-1;$i++){
	$separar = explode("|",$cadena[$i]); 
	$alumno =$separar[1]; 
	$puntaje =intval($separar[2]);
	$ramo =$separar[3]; 
	$fecha =$separar[4];
	$curso =$separar[6];
	$ano =$separar[5];
	
	if($puntaje==""){
		continue;
		}
	
	$rspun = $Obj_Ensayo_Psu->traePuntajedia($curso,$ramo,$alumno,$fecha);
	
	if(pg_numrows($rspun)>0){
	
	$rs_mod = $Obj_Ensayo_Psu->actPuntaje($curso,$ramo,$alumno,$fecha,$puntaje);
	}
	else{
		 $sql_insert = "INSERT INTO ensayos_psu(id_ano,id_ramo,id_curso,rut_alumno,fecha,puntaje) 
	                 VALUES
                     (".$ano.",".$ramo.",".$curso.",".$alumno.",'".$fecha."',".$puntaje.");";
					 
					             $regis=pg_Exec($conn,$sql_insert);
		
	}
	}
	
	//show($_POST);
}
?>