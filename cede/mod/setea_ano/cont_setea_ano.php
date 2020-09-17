<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_setea_ano.php";

$objMembrete= new Membrete($_IPDB,$_ID_BASE);
$Obj_SeteaAno = new SeteaAno($_IPDB,$_ID_BASE);
$funcion = $_POST['funcion'];


		if($funcion==1){
			$id_instit=$_POST['id_instit'];
			
		  $result = $Obj_SeteaAno->ano_academico($id_instit);
		  if($result){
			    $table = '<table width="100%" >
              <tr class="color_fondo" >
			  <th width="%" >A&ntilde;o Escolar</th>
			   <th width="%" >Fecha Inicio</th>
			  <th width="%" >Fecha Termino</th>
			  <th width="%" >Tipo Regimen</th>
			   <th width="%" >Estado</th>
			  
			</tr>
			<tbody>';
			
			for($e=0;$e<pg_numrows($result);$e++){
			  
				$fila = pg_fetch_array($result,$e);
				
				if($fila['tipo_regimen']==2){
					$regimen="Semestral";
					}else if($fila['tipo_regimen']==3){
						$regimen="Trimestral";
						}
						
				if($fila['situacion']==1){
					$situacion="Abierto";
					}else{
					 $situacion="Cerrado";	
						}		
					
	$table .= '<tr id="capa'.$fila["nro_ano"].'"align="center" id="cambia" onclick="CambiaAno('.$fila["id_ano"].','.$fila["nro_ano"].')" style="cursor:pointer;">
	
	<td>'.$fila['nro_ano'].'&nbsp;</td>
	<td>'.$fila['fecha_inicio'].'&nbsp;</td>
	<td>'.$fila['fecha_termino'].'&nbsp;</td>
	<td>'.$regimen.'&nbsp;</td>
	<td>'.$situacion.'&nbsp;</td>
	
				</tr>';
			}// fin for
			$table .= "<tbody></table>";
			echo $table;
				}else{ 
				   echo 0;
		}	
	}
	
	if($funcion==2){
	echo "A&ntilde;o Actual = ".$nro_ano=$_POST['nro_ano'];
	$_SESSION['_ANO_CEDE']=$_POST['id_ano'];
    $_ANO_CEDE=$_SESSION['_ANO_CEDE'];
	
	return 	$_ANO_CEDE;
	
		
	}
	

?>