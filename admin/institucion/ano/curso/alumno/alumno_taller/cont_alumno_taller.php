<?php
//header('Content-Type: text/html; charset=iso-8859-1'); 
session_start();
include_once('mod_alumno_taller.php');

?>

<?php

$obj_AlumnoTaller = new AlumnoTaller($conn);

$funcion = $_POST['funcion'];


if($funcion == 1){
	
	$rdb = $_POST['rdb'];
	$id_ano = $_POST['id_ano'];
	$rut_alumno = $_POST['rut_alumno'];
	$result = $obj_AlumnoTaller->carga_taller($rdb,$id_ano);
	?>
    <table width="650" border="1" style="border-collapse:collapse">
    <tr class="cuadro02">
    <td>Nombre Taller</td>
    <td>Docente a Cargo</td>
    <td>Docente que Imparte</td>
    <td>Modo Evaluaci&oacute;n</td>
    <td>Seleccionar</td>
    </tr>
    <?
	for($i=0;$i<pg_numrows($result);$i++){
		$fila = pg_fetch_array($result,$i);
	?>
    <tr class="cuadro01">
    <td><?=$fila['nombre_taller'];?></td>
    <td><? if($fila['acargo']==1){echo $fila['nombre_emp'];}?></td>
    <td>
	<?
	 $sql="select em.nombre_emp||' '||em.ape_pat||' '||em.ape_mat as nombre_empleado from
           empleado em 
           JOIN dicta_taller dt on em.rut_emp=dt.rut_emp
           where dt.id_taller=".$fila['id_taller']." and dt.acargo=0";
		   $res=pg_exec($conn,$sql);
		  echo $nombre_emp=pg_result($res,0)
	?>
    </td>
    <td><?=$fila['modo_evaluacion'];?></td>
    <td align="center">
    <?
    	$sql_tt="select t.* from taller t
				 join tiene_taller tt on t.id_taller=tt.id_taller
				 where rut_alumno=$rut_alumno and id_ano=$id_ano";
				 $reg=pg_exec($conn,$sql_tt);
				  $cantidad = pg_numrows($reg); 
			if($cantidad > 0){
			 ?>
             <input type="checkbox" name="chk_inscribe<?=$i?>" id="chk_inscribe<?=$i?>" value="1" onClick="incribe_taller(<?=$fila['id_taller'];?>,this.name)" checked ></td>
             <?	 
  		     }else{
	         ?>
             <input type="checkbox" name="chk_inscribe<?=$i?>" id="chk_inscribe<?=$i?>" value="1" onClick="incribe_taller(<?=$fila['id_taller'];?>,this.name)" ></td>
             <?
	}
	}
	?>
    </tr>
    </table>
    <?
	}
	
	
	if($funcion==2)
	{
		$id_taller=$_POST['id_taller'];
		$rut_alumno=$_POST['rut_alumno'];
		
		$result = $obj_AlumnoTaller->inscribe_taller($rut_alumno,$id_taller);
		if($result)
		{
		echo 1;	
		}else{
		echo 0;	
		}
	}
	
		if($funcion==3)
	{
		$id_taller=$_POST['id_taller'];
		$rut_alumno=$_POST['rut_alumno'];
		
		$result = $obj_AlumnoTaller->elimina_taller($rut_alumno,$id_taller);
		if($result)
		{
		echo 1;	
		}else{
		echo 0;	
		}
	}
	
	
	
	
 ?>
