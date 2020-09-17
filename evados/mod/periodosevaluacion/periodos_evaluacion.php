<? session_start();	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Carga Documentos</title>

<link rel="stylesheet" type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css">
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>

<!--<script type="text/javascript" src="../../js/jquery_autoHeight.js"></script>-->
        
<script type="text/javascript">

 function cargador_periodos(){
   var parametros = "funcion=1";
   		$.ajax({
		  url:'mod/periodosevaluacion/cont_periodo_evaluacion.php',
		  type:'post',
		 data:parametros,
		  success:function(data){

					if(data!=0){
                      $("#select_periodo").html(data);
					}else{
					  alert("Error");
					}
			   }
		 })
      }
    
    cargador_periodos()
    
    function cargador_defechas(x){
    var parametros = "funcion=2&id="+x;
	//alert(parametros);
   		$.ajax({
		  url:'mod/periodosevaluacion/cont_periodo_evaluacion.php',
		  type:'post',
		 data:parametros,
		  success:function(data){
					if(data!=0){
                      $("#fechas").html(data);
					}else{
					  alert("Error");
					}
			   }
		 })
      }
      
    
    function enviardatosperiodo(){
    
     //if($('#cmb_periodo').val()==0) alert("..:: Seleccionar Periodo ::.."); return false;
    // if($('#datepicker_1').val()=="")alert("..:: Seleccionar Fecha Inicio ::.. "); return false;
    // if($('#datepicker_2').val()=="") alert("..:: Selecionar Fecha Termino ::.."); return false;
 
     $.ajax({
		  url:'mod/periodosevaluacion/cont_periodo_evaluacion.php',
		  type:'post',
		 data:$('#datosperiodo').serialize(),
		  success:function(data){
					if(data!=0){
                      alert('Datos Guardados');
                      cargador_tabla_resultados();
					}else{
					  alert("Error");
					}
			   }
		 })
     	
     }
    
       
   function cargador_tabla_resultados(){
    var parametros = "funcion=3";
   		$.ajax({
		  url:'mod/periodosevaluacion/cont_periodo_evaluacion.php',
		  type:'post',
		 data:parametros,
		  success:function(data){
					if(data!=0){
                      $("#tabla_resultados").html(data);
                      $("#flex1").flexigrid({
									width : 700,
									height : 150
								});
					}else{
					  alert("Error");
					}
			   }
		 })
      }
      
    cargador_tabla_resultados();
      
          
    function EliminaPeriodo(x,y){
    	var param = 'function=4&idanio='+x+'&idperiodo='+y
    	 $.ajax({
		  url:'mod/periodosevaluacion/cont_periodo_evaluacion.php',
		  type:'post',
		 data:param,
		  success:function(data){
					if(data!=0){
                      alert('Datos Eliminados');
                      cargador_tabla_resultados();
					}else{
					  alert("Error");
					}
			   }
		 })
    }
    
    
</script>
<style>

#bloques{ margin:10px; margin-top:5px; text-align:left; width:%; }
#cargar_archivo{ margin-left:40px; margin-top:5px; padding:20px; border:solid 1px; margin:10px; }

</style>

</head>
<body>  

<div id="bloques" align="center"  >
<fieldset>
<legend><strong><?=htmlentities("Configuración Periodos",ENT_QUOTES,'UTF-8');?></strong></legend>


<div id="cargar_archivo">

<form name="datosperiodo" id="datosperiodo">
<h1><?=htmlentities("Configuración de Periodos",ENT_QUOTES,'UTF-8');?></h1>
<br/>
<div id="select_periodo">			
<p>Seleccionar Perido
<select name"selectperiodo">
		<option>Seleccionar</option>
</select>
</p>
</div>
<div id="fechas">
<br/>
<p><h4>Para que se cargen las fechas del periodo tiene que seleccionar un periodo antes.</h4></p>
<label>Fecha Inicio de Evaluacion&nbsp;:&nbsp;</label>&nbsp;<input type="text" name="datepicker_1" id="datepicker_1" readonly="readonly" size="12" />
<br/>
<br/>
<label>Fecha Termino de Evaluacion&nbsp;:&nbsp;</label>&nbsp;<input type="text" name="datepicker_2" id="datepicker_2" readonly="readonly" size="12" />
<br/>
<br/>
<br/>
</div>
<input type="button" name="Guardar" id="Guardar" value="Guardar" class="botonXX"  onclick="enviardatosperiodo()" />
</form>


<br/>
<br/>
<p><h1>Tabla de Resultados</h1></p>

<div id="tabla_resultados">

<table border=1 style=" border-collapse:collapse ">
<tr>
	<th>&nbsp;Nombre Periodo&nbsp;</th>
	<th>&nbsp;Fecha Inicio Evaluacion&nbsp;</th>
	<th>&nbsp;Fecha Termino Evaluacion&nbsp;</th>
	<th>&nbsp;Eliminar&nbsp;</th>
<tr>	 
<tr align="center" >
	<td>Primer Periodo</td>   
	<td>Fecha Inicio</td>
	<td>Fecha Termino</td>
	<td>x</td>	
</tr>
<tr align="center" >
	<td>Segundo Periodo</td>
	<td>Fecha Inicio</td>
	<td>Fecha Termino</td>
	<td>x</td>	
</tr>
</table>

</div>


<br/>
			
</div>
</fieldset>
</div>
</body>
</html>

<script type="text/javascript">
 //cargador_periodos()
</script>




