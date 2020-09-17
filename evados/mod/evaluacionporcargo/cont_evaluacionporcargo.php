<? header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require "mod_evaluacionporcargo.php";

$_ANO = 1206;
$periodo	= 2442;
$obj_PautaevaCargo = new PautaevaCargo($_IPDB,$_ID_BASE);
$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
$funcion = $_POST['funcion'];
$rut = trim($_POST['rut_evaluador']);

	if($funcion==1){

	  	$result = 
		$obj_PautaevaCargo->evaluadosporevaluadorcargo($rut,$_ANO,$_INSTIT,$periodo);   // variable de seccion rut y ano
		
		$result2 = $obj_PautaevaCargo->fechas_periodo_evaluacion($_ANO);
		$fila_validafechaperiodo = pg_fetch_array($result2,0);
			
		if($result){
		   $table = '<table id="flex1" style="display:none" >
		  <thead>
			<tr align="center" >
			  <th width="200" >Pauta eval.'.$_ANO.'</th>
			  <th width="544" >Cargo</th>
			</tr>
			</thead>
			<tbody>';
						
		  for($e=0;$e<pg_numrows($result);$e++){
			  
		  $fila = pg_fetch_array($result,$e);
		  
         if ( ($fila['fecha_evaluacion']!='') ){
	
	    $bloques = "<img src='img/PNG-48/ok.png' width='34' height='34' border='0' title='Evaluacion Cerrada' />";	
		
        	}else{
	
	// if($fila_validafechaperiodo['bool']==1){
	
		$bloques = "<a href='#' onclick='eliminaDatosporCargo(".$fila['rut_evaluador'].",".$fila['id_cargo'].",".$fila['cargo_evaluado'].",".$fila['id_bloque'].",".$e.")' >
				 	<img src='img/PNG-48/Add.png' width='34' height='34' border='0'  title='Abrir Evaluacion'  /></a>";
					
	
	/*	$bloques = "<a href='#' onclick='cargaDatosporCargo(".$fila['rut_evaluador'].",".$fila['id_cargo'].",".$fila['cargo_evaluado'].",".$fila['id_bloque'].",".$e.")' >
				 	<img src='img/PNG-48/Add.png' width='34' height='34' border='0'  title='Abrir Evaluacion'  /></a>";*/
		
	// }else{
	
	 //	$bloques = "<a href='#' onclick='fechafueraderango()'><img src='img/PNG-48/Add.png' width='34' height='34' border='0'  title='Abrir Evaluacion'  /></a>";
	
		// }
	
	      }

	        $table .= '<tr>	  
						  <td>'.$bloques.'&nbsp;</td>
						  <td>'.$fila['nombre_cargo'].'&nbsp;<input type="hidden" id="_nombre_cargo'.$e.'" value="'.$fila['nombre_cargo'].'">
						  </td>
						</tr>';
		   
			 }	// fin for
		   
			$table .= "<input type='hidden' id='c_nombre_cargo' value='".$e."'><tbody></table>";
			echo $table;
			   
			}else{ 
			   echo 0; 
			}
			
	 } 	// fin funcion 1
	 
	 
	 if($funcion==2)
	 {
		$rut_evaluador=$_POST['rut_evaluador'];
		$id_cargo=$_POST['id_cargo'];
		$cargo_evaluado=$_POST['cargo_evaluado'];
		$id_bloque=$_POST['id_bloque'];
		$id_nacional=$_POST['id_nacional'];
		$numero=$_POST['numero'];
		$periodo=$_POST['periodo'];
		$id_ano=$_POST['id_ano'];
		$nombre_cargo = $_POST['nombre_cargo'];
		
		
		$result = $obj_PautaevaCargo->pautaporcargos($rut_evaluador,$id_cargo,$cargo_evaluado,$id_bloque,$id_nacional,$numero);
		
		if(pg_numrows($result)!=0){
		$nro_ano=$ob_membrete->nro_ano($id_ano);
		$nombre_periodo=$ob_membrete->nombre_periodo($periodo);
		
		$rs_cuenta_total=$obj_PautaevaCargo->cuenta_total($rut_evaluador,$id_cargo,$cargo_evaluado,$id_bloque,$id_nacional,$numero);
		 $contador_eva = $rs_cuenta_total-$numero;
		
		
		
		?>
        <table align="center" width="600">
        <tr align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:13px">
        <td>Evaluacion&nbsp;<?=$nombre_cargo?>&nbsp;&nbsp;<br /><?=$nombre_periodo?>&nbsp;<?=$nro_ano?> </td>
        <tr>
        </table>
        <div id="separa" style="height:50" ></div>
		<table width="600" border="1" style="border-collapse:collapse">
        <td width="82" class="cuadro02">Dimencion</td>
        <td width="502" class="cuadro01"><? echo pg_result($result,1)?>
        </td>
        </tr>
         <td class="cuadro02">Funcion</td>
        <td class="cuadro01"><? echo pg_result($result,3)?></td>
        </tr>
         <td class="cuadro02">Indicador</td>
        <td class="cuadro01"><? echo pg_result($result,5)?></td>
        
        </tr>
        </table>
        
        <div id="separa" style="height:50" ></div>
        <table>
        <tr class="cuadro01">
        <td style="background-color:#E6E6E6">Evaluaciones&nbsp;:
        <?=$contador_eva?>&nbsp;de&nbsp;<?=$rs_cuenta_total;?>
         </td>
         </tr>
         </table>  
                 <?
        	$sql="select re.*,em.ape_pat||' '||em.ape_mat||' '||em.nombre_emp as nombre_emp 
				  from evados.eva_relacion_evaluacion re
				  join empleado em on em.rut_emp=re.rut_evaluado 
				  where re.rut_evaluador=$rut_evaluador and re.cargo_evaluado=$cargo_evaluado AND re.id_ano=$id_ano and re.id_periodo=$periodo";
			$result_= pg_exec($obj_PautaevaCargo->Conec->conectar(),$sql)or die("fallo ".$sql);
		?>
        <form id="pautaporcargo" name="pautaporcargo">
        <input type='hidden' name='tableevaluacionporcargo' id='tableevaluacionporcargo'  value='1'/>
        
        <table width="600" border="1" style="border-collapse:collapse">
        <div id="cuenta_neg"></div>
        <tr class="cuadro02">
        <td width="%"><?=$nombre_cargo?></td>
        <td width="%">Conceptos</td>
        </tr>
        <tr>
        <?
        	for($i=0;$i<pg_numrows($result_);$i++){
				$fila = pg_fetch_array($result_,$i);
		?>
         	<td class="cuadro01">
         	<?=$fila['nombre_emp']?></td>
            <td class="cuadro01">
				<? 
					$sql_concep="select * from evados.eva_concepto order by orden";
					$res_conc = pg_exec($obj_PautaevaCargo->Conec->conectar(),$sql_concep);
					for($j=0;$j<pg_numrows($res_conc);$j++){
					$fila_c= pg_fetch_array($res_conc);
					?>
                    
                   <?=$fila_c['sigla'];?><input type="radio" name="conceptos[<?=$i?>]" id="conceptos[<?=$i?>]" value="<?=$fila_c['id_concepto']?>,<?=$fila['rut_evaluado']?>"/>
                    <input type="radio"  name="conceptos[<?=$i?>]"  value="0" checked="checked" style="visibility:hidden;"/>
                   <input type="hidden" id="_id_concepto" name="_id_concepto"  value="<?=$fila_c['id_concepto']?>"/>
                   <input type="hidden" id="idsPauta[<?=$i?>]" name="idsPauta[<?=$i?>]" value="<? echo pg_result($result,6)?>.<? echo pg_result($result,0)?>.<? echo pg_result($result,2)?>.<? echo pg_result($result,4)?>.<?=$rut_evaluador;?>.<?=$fila['rut_evaluado'];?>.<?=$periodo?>.<?=$cargo_evaluado?>.<?=$id_cargo?>.<?=$id_nacional?>" />
                    <?
					
					}
				?></td>
                </tr>
        <?
			}
		?>
        
        </table>
        </form>
		<?	
		}else{
		echo 0;	
		}

	 }
	 
	 
	 if($funcion==3){
		 
		 $rut_evaluador = $_POST['rut_evaluador'];
		 $id_ano = $_POST['id_ano'];
		 $id_periodo = $_POST['id_periodo'];
		 
		 $obj_PautaevaCargo->borra_datos_tmp($rut_evaluador,$id_ano,$id_periodo);
		 return;
		 }
		 
		 
		 if($funcion==4)
	 {
		$rut_evaluado=$_POST['rut_evaluado'];
		$nomre_emp = $obj_PautaevaCargo->nombre_emp($rut_evaluado);
		echo $nomre_emp;	 
	 }
	 
	 
	 if($funcion==5)
	 {
		 $rut_evaluador=$_POST['rut_evaluador'];
		 $id_ano=$_POST['id_ano'];
		 $periodo=$_POST['periodo'];
		 
		$regis = $obj_PautaevaCargo->tabla_tmp($rut_evaluador,$id_ano,$periodo);
		 if($regis){
			 echo 1;
			 }else{
				echo 0;	 
			 }
	 }
	 
	 
	 
	 if($_POST['tableevaluacionporcargo']==1){  
		//print_r($_POST);

	     $largo_array = count($_POST['conceptos']);	
	     $largo_array;
		
        for($e=0;$e<=count($_POST['conceptos']);$e++){
			if($_POST['conceptos'][$e]!=0){	
			$datos = explode(".",$_POST['idsPauta'][$e]);
		//	print_r($datos);
		
	$rs_cuenta_total = $obj_PautaevaCargo->cuenta_total($datos[4],$datos[8],$datos[7],$a,$datos[9]);	
	
	$id_concepto = explode(',',$_POST['conceptos'][$e]);	
			
	  $sql_c="select count(*) from evados.eva_plantilla_evaluacion_tmp where id_plantilla=".$datos[0]." and id_ano=".$_ANO." and ip_periodo = ".$datos[6]." and                id_concepto=".$id_concepto[0]." and rut_evaluado=".$datos[5]." and rut_evaluador=".$datos[4]." ";	
		$regis = pg_Exec($obj_PautaevaCargo->Conec->conectar(),$sql_c) or die("fallo ".$sql_c); 
		$negativas = pg_result($regis,0);
		$total_t = ($negativas*100)/$rs_cuenta_total;
		
        $total_negativas = round($total_t);
		
		if($total_negativas > 5 and $_POST['conceptos'][$e]==9){
		?>
        <input type='hidden' id='_rut_evaluado_' value="<?=$datos[5]?>">
		<input type='hidden' id='cuenta_negativas' value="<?=$total_negativas?>">
        <input type='hidden' id='concepto_' value="<?=$_POST['conceptos'][$e]?>"/> 
        
        <?
		}else{
			$result = $obj_PautaevaCargo->insert_evaluacion($datos,$id_concepto[0],$_ANO,$rs_cuenta_total);
			if(!$result){
			echo "Error";
			}
		   //$result = $obj_PautaevaCargo->fechaevaluacion($_ANO,$datos[5],$datos[4],$periodo);
		  //if(!$result) echo "Error";	
		 }
		 
		}
      } 
	  echo 1;
	 
	}
	 
	 
	 
	 
	 
	 
	/* if($funcion==2){

		echo  $obj_PautaevaCargo->putaevaluacion($_POST['rutevador'],$_POST['rutevado'],$_POST['cargo_evaluado'],$_POST['cargo_evaluador'],$_POST['bloqueevaluador'],$_NACIONAL,$_ANO);
		 
		 }
		 
		 
		if($funcion==3){

		$result = $obj_PautaevaCargo->cargadorportafolio($_POST['rut_evaluado'],$_ANO);
		 
		 if($result){

		   $table = '<table id="flex11" style="display:none" >
		   <thead>
			<tr align="center" >
			  <th width="300" >Nombre Archivo</th>
			  <th width="100" >Tipo Archivo</th>
			</tr>
			</thead>
			<tbody>';
		    
		  for($e=0;$e<pg_numrows($result);$e++){
		  
		  $fila = pg_fetch_array($result,$e);
              
			  $fila['rut_evaluado'];
			    
              $table .= "<tr>
			  <td><a href='?archivo=".$fila['nombre_archivo']."' >".$fila['nombre_archivo']."</a></td>
			  <td>".$fila['tipo_doc']."&nbsp;</td>
			  </tr>";
		   
			 }// fin for
		   
			$table .= "<tbody></table>";
			echo $table;
			   
			}else{ 
			   echo 0; 
			}
		 
		 } 
		*/ 
	
		 

?>
