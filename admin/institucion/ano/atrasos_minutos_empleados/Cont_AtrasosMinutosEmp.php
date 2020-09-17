<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "Mod_AtrasosMinutosEmp.php";

$obj_AtrasosMinutosEmp = new AtrasosMinutosEmp($conn);

$funcion = $_POST['funcion'];
	
	
	if($funcion==carga_emp){
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
		$fecha=CambioFE($_POST['fecha']);
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
	
	
	
	
	
 

?>