<?
session_start();

require "mod_doc.php";

$ob_doc = new TipoDoc($_IPDB,$_ID_BASE);

$funcion = $_POST['funcion'];
$tipodoc = $_POST['tipodoc'];
$rdb	 = $_INSTIT;
$tipo 	 = $_POST['tipo'];
$ano	 = $_ANO;

if($funcion==0){
	$result = $ob_doc->insertardoc($tipodoc,$rdb);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}

 } // fin funcion 0


if($funcion==1){
	$result = $ob_doc->actualizardoc($_id_tipo,$tipodoc,$rdb);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}

 } // fin funcion 0
 



if($funcion==3){

$_ano = $_POST['ano'];
$result = $ob_doc->cargadoc($_ano);
		
	if($result){
		   
	   $table = '  <label for="listaevaluadores">Tabla Documentos</label>
	  <table id="flex1" style="display:none" >
	  <thead>
		<tr align="center" >
		  <th width="30" >#</th>
		  <th width="100" >Nombre</th>
		  <th width="30" >Edit</th>
		  <th width="30" >Delete</th>
		</tr>
		</thead>
		<tbody>';
    
	  for($e=0;$e<pg_numrows($result);$e++){
      
	  $fila = pg_fetch_array($result,$e);
	  $i = $e;
	  $i++;
	  $elimina = "<a href='#' onclick='EliminaDoc(".$fila['id_tipo'].")' ><img src='img/PNG-48/Delete.png' width='18' height='18' border='0' /></a>";
	  $modificar = "<a href='#' onclick='buscardoc(".$fila['id_tipo'].")' ><img src='img/PNG-48/Modify.png' width='18' height='18' border='0' /></a>";
	  
      $table .= '<tr align="center">
      <td>'.$i.'&nbsp;</td>
      <td>'.$fila['nombre'].'&nbsp;</td>
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
 	$result = $ob_doc->eliminadoc($tipo);
	if($result){
		echo 1;
	}else{
		echo 0;
	}
 }


if($funcion==6){

 	$result = $ob_doc->buscardoc($_POST['iddoc']);
	if($result){
		if(pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
                //echo json_encode($fila);
				echo '<input id="_id_tipo" type="hidden" value="'.$fila['id_tipo'].'" />';
				echo '<input id="_nombre" type="hidden" value="'.$fila['nombre'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}


}


?>
