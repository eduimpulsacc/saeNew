<? session_start();
require_once('mod_periodo_evaluacion.php');
$obj_periodos_evaluacion = new periodos_evaluacion($_IPDB,$_ID_BASE);

$_funky = $_POST[funcion];
$per_id = $_POST[id];


 

 if($_POST[cmb_periodo]){
 
$return = $obj_periodos_evaluacion->ingresa_periodo_evaluacion($_ANO,$_POST[cmb_periodo],$_POST[datepicker_1],$_POST[datepicker_2]);

	if($return){
        echo 1;		
	}else{
       	echo 0;		
	}

 }
 

if($_funky==1){ 
$result = $obj_periodos_evaluacion->select_periodos($_ANO); 

if($result){
		$select = "<label>Seleccionar Perido : <select name='cmb_periodo' id='cmb_periodo'  onchange='cargador_defechas(this.value)'  >
		<option value='0' select='select'  >Selecccionar</option>";
		for($i=0;$i<pg_num_rows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_periodo']."'>".$fila['nombre_periodo']."</option>";
		 }  
		 $select .= "</select></label>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
    }
	 

	 
	if($_funky==2){
	
		$result = $obj_periodos_evaluacion->consulta_periodo($per_id,$_ANO);
		
		$fila=pg_fetch_array($result,0);
		$fecha_i = split("-",$fila['fecha_inicio']);
		$fecha_inico = $fecha_i[0].",".($fecha_i[1] -1).",".$fecha_i[2];
		$fecha_t = split("-",$fila['fecha_termino']);
		$fecha_termino = $fecha_t[0].",".($fecha_t[1] -1).",".$fecha_t[2];
		
		echo '<script type="text/javascript">';
			
		echo "jQuery(function($){
		    $.datepicker.regional['es'] = {
		       showOn: 'button',
		       buttonText: 'Seleccionar',
		       minDate: new Date($fecha_inico),
		       maxDate: new Date($fecha_termino), 
		       constrainInput: true, 
		       closeText: 'Cerrar', 
		        prevText: '&#x3c;Ant',
		        nextText: 'Sig&#x3e;', 
		        currentText: 'Hoy',
		        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		        'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun', 'Jul','Ago','Sep','Oct','Nov','Dic'],
		        dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
		        dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
		        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
		        weekHeader: 'Sm',
		        dateFormat: 'mm/dd/yy',
		        firstDay: 1,
		        isRTL: false,
		        showMonthAfterYear: false,
		        yearSuffix: ''};
		       $.datepicker.setDefaults($.datepicker.regional['es']);
		      }); ";
		
			echo "$(document).ready(function() {
			   $('#datepicker_1').datepicker();
			   $('#datepicker_2').datepicker();
			});";
		
			echo '</script >';
				
			echo '<br/><label>Fecha Inicio de Evaluacion&nbsp;:&nbsp;</label>&nbsp;<input type="text" name="datepicker_1" id="datepicker_1" readonly="readonly" size="12" />
			<br/><br/>
			<label>Fecha Termino de Evaluacion&nbsp;:&nbsp;</label>&nbsp;<input type="text" name="datepicker_2" id="datepicker_2" readonly="readonly" size="12" />
			<br/><br/><br/>';
				
	    }	 
	
	

if($funcion==3){
				
	 $result = $obj_periodos_evaluacion->select_periodos_evaluaciones($_ANO);

	if($result){
												
	$table = '<label for="tabla_resultados"><strong>Tabla Periodos Evaluacion</strong></label>
		              <table id="flex1" style="display:none" >
		             <thead>
			         <tr align="center" >
			         <th width="260" >Nombre Periodo</th>
			         <th width="100" >Fecha Inicio Evaluacion</th>
			         <th width="100" >Fecha Termino Evaluacion</th>
			         <th width="100" >Eliminar</th>
			         </tr>
			         </thead>
			         <tbody>';
						
		  for($e=0;$e<pg_numrows($result);$e++){
		  
		  $fila = pg_fetch_array($result,$e);
		
		  $elimina = "<a href='#' onclick='EliminaPeriodo(".$fila['id_anio'].",".$fila['id_periodo'].")' ><img src='img/PNG-48/Delete.png' width='30' height='30' border='0' /></a>";

			  $table .= '<tr align="center" >
			  <td>'.$fila['nombre_periodo'].'&nbsp;</td>
			  <td>'.$fila['fecha_inicio'].'&nbsp;</td>
			  <td>'.$fila['fecha_termino'].'&nbsp;</td>
			  <td>'.$elimina.'&nbsp;</td>
			</tr>';
		   
			 }		// fin for
		   
			$table .= "<tbody></table>";
			
			echo $table;									
		
	    }				
	
    }


if($function==4){
    	$result = $obj_periodos_evaluacion->elimina_periodo_evaluacion($_POST['idanio'],$_POST['idperiodo']);
	    if($result){
	    	echo 1;			
	    }else{
	       echo 0;			
	    }
    }
	
	
	
		 		 
?>