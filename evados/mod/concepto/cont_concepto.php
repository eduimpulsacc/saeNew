<?
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();

require "mod_concepto.php";

$ob_concepto = new Concepto($_IPDB,$_ID_BASE);

$funcion = $_POST['funcion'];
$concepto = $_POST['concepto'];
$id_nacional	 = $_NACIONAL;
$tipo 	 = $_POST['tipo'];


if($funcion==0){
	
	$result = $ob_concepto->insertarconcepto($categoria,$concepto,$sigla,$id_nacional,$critico,$estado,$peso,$optimo);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}

 } // fin funcion 0


if($funcion==1){
	
	$result = $ob_concepto->actualizaconcepto($categoria,$concepto,$sigla,$critico,$id_concepto);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}

 } // fin funcion 0
 

if($funcion==3){

$rdb = $_INSTIT;
$result = $ob_concepto->cargaconcepto($id_nacional);
		
	if($result){
		   
	   $table = '  <label for="listaevaluadores">Tabla de Conceptos</label>
	  <table id="flex1" style="display:none" >
	  <thead>
		<tr align="center" >
		  <th width="100"  class="textonegrita">Categoria</th>
		  <th width="250"  class="textonegrita">Concepto</th>
		  <th width="35"  class="textonegrita">Sigla</th>
		  <th width="35"  class="textonegrita">Critico</th>
		  <th width="50"  class="textonegrita">Modifica</th>		  	
		  <th width="50"  class="textonegrita">Eliminar</th>
		</tr>
		</thead>
		<tbody>';
    
	  for($e=0;$e<pg_numrows($result);$e++){
      
	  $fila = pg_fetch_array($result,$e);
	  $elimina = "<a href='#' onclick='EliminaConcepto(".$fila['id_concepto'].")' ><img src='img/PNG-48/Delete.png' width='30' height='30' border='0' /></a>";
	  $modificar = "<a href='#' onclick='buscarconcepto(".$fila['id_concepto'].")' ><img src='img/PNG-48/Modify.png' width='30' height='30' border='0' /></a>";
	  	if($fila['critico']==1){
	  		$critico="SI";
		}else{
			$critico="NO";
		} 
	  
      $table .= '<tr align="center">
      <td class="textosimple" align="left">'.$fila['categoria'].'&nbsp;</td>
      <td class="textosimple">'.$fila['concepto'].'&nbsp;</td>
	  <td class="textosimple">'.$fila['sigla'].'&nbsp;</td>
	  <td class="textosimple">'.$critico.'&nbsp;</td>
	  <td>'.$modificar.'&nbsp;</td>
	  <td>'.$elimina.'&nbsp;</td>
    </tr>';																																																																																																																																				
   
     }// fin for
   
    $table .= "<tbody></table>";																																	
	   
    echo $table;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 3
 
 if($funcion==5){
 	$result = $ob_concepto->eliminaconcepto($id);
	if($result){
		echo 1;
	}else{
		echo 0;
	}
 }


if($funcion==6){

 	$result = $ob_concepto->buscarconcepto($_POST['id_concepto']);
	if($result){
		if(pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0);
                //echo json_encode($fila);
				echo '<input id="_idconcepto" type="hidden" value="'.$fila['id_concepto'].'" />';
				echo '<input id="_categoria" type="hidden" value="'.$fila['categoria'].'" />';
				echo '<input id="_concepto" type="hidden" value="'.$fila['concepto'].'" />';
				echo '<input id="_sigla" type="hidden" value="'.$fila['sigla'].'" />';
				echo '<input id="_critico" type="hidden" value="'.$fila['critico'].'" />';
				
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}


}



?>


