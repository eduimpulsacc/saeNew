<?php 
session_start();
require("../../../../../util/header.php");
require("mod_calendario.php");
$funcion = $_POST['funcion'];

$ob_calendario = new Calendario();

if($funcion==1){
	if($_PERFIL!=17){
	$rs_cur = $ob_calendario->Cursos($conn,$anio);
	?>
    <select name="cmb_curso" id="cmb_curso" onchange="traeEvento(this.value)">
    <option value="0">Seleccione curso</option>
    <?
for($c=0;$c<pg_numrows($rs_cur);$c++){
	$fila_cur = pg_fetch_array($rs_cur,$c);
	?>
     <option value="<?php echo $fila_cur['id_curso'] ?>"><?php echo $fila_cur['curso'] ?></option>
    <?
}
?>
 </select>
<?
	}else{
	?>
    <script>
	$( document ).ready(function() {
   traeEvento(<?php echo $_CURSO ?>);
   	var d = new Date();
	var mm = d.getMonth();
	var dd = d.getDate();
	fecha(mm,dd);
});
	</script>
	<input type="hidden" name="cmb_curso" id="cmb_curso" value="<?php echo $_CURSO ?>" />
    <?php echo CursoPalabra($_CURSO,1,$conn) ?>
	<?
	}
}
if($funcion==2){
	$rs_act = $ob_calendario->cargaAct($conn,$curso);
?>
<script type="text/javascript">
$(document).ready(function(){	

	var clickDate = "";
	var clickAgendaItem = "";
	
	/**
	 * Initializes calendar with current year & month
	 * specifies the callbacks for day click & agenda item click events
	 * then returns instance of plugin object
	 */
	var jfcalplugin = $("#mycal").jFrontierCal({
		date: new Date(),
		dayClickCallback: myDayClickHandler,
		agendaClickCallback: myAgendaClickHandler,
		agendaDropCallback: myAgendaDropHandler,
		agendaMouseoverCallback: myAgendaMouseoverHandler,
		applyAgendaTooltipCallback: myApplyTooltip,
		agendaDragStartCallback : myAgendaDragStart,
		agendaDragStopCallback : myAgendaDragStop,
		dragAndDropEnabled: false
	}).data("plugin");
	
	/**
	 * Do something when dragging starts on agenda div
	 */
	function myAgendaDragStart(eventObj,divElm,agendaItem){
		// destroy our qtip tooltip
		if(divElm.data("qtip")){
			divElm.qtip("destroy");
		}	
	};
	
	/**
	 * Do something when dragging stops on agenda div
	 */
	function myAgendaDragStop(eventObj,divElm,agendaItem){
		//alert("drag stop");
	};
	
	/**
	 * Custom tooltip - use any tooltip library you want to display the agenda data.
	 * for this example we use qTip - http://craigsworks.com/projects/qtip/
	 *
	 * @param divElm - jquery object for agenda div element
	 * @param agendaItem - javascript object containing agenda data.
	 */
	function myApplyTooltip(divElm,agendaItem){

		// Destroy currrent tooltip if present
		if(divElm.data("qtip")){
			divElm.qtip("destroy");
		}
		
		var displayData = "";
		
		var title = agendaItem.title;
		var startDate = agendaItem.startDate;
		var agein = startDate.toLocaleString();
		//alert(agein);
		var resin = agein.split(" ");
		
		
		var endDate = agendaItem.endDate;
		var agefn = endDate.toLocaleString();
		var resfn = agefn.split(" ");
		
		
		var allDay = agendaItem.allDay;
		var data = agendaItem.data;
		displayData += "<br><b>" + title+ "</b><br><br>";
		if(allDay){
			displayData += "(All day event)<br><br>";
		}else{
			displayData += "<b>Fecha Inicio:</b> " + resin[0]+" "+resin[1] + "<br>" + "<b>Fecha t&eacute;rmino:</b> " + resfn[0]+" "+resfn[1] + "<br><br>";
		}
		for (var propertyName in data) {
			displayData += "<b>" + propertyName + ":</b> " + data[propertyName] + "<br>"
		}
		// use the user specified colors from the agenda item.
		var backgroundColor = agendaItem.displayProp.backgroundColor;
		var foregroundColor = agendaItem.displayProp.foregroundColor;
		var myStyle = {
			border: {
				width: 5,
				radius: 10
			},
			padding: 10, 
			textAlign: "left",
			tip: true,
			name: "dark" // other style properties are inherited from dark theme		
		};
		if(backgroundColor != null && backgroundColor != ""){
			myStyle["backgroundColor"] = backgroundColor;
		}
		if(foregroundColor != null && foregroundColor != ""){
			myStyle["color"] = foregroundColor;
		}
		// apply tooltip
		divElm.qtip({
			content: displayData,
			position: {
				corner: {
					tooltip: "bottomMiddle",
					target: "topMiddle"			
				},
				adjust: { 
					mouse: true,
					x: 0,
					y: -15
				},
				target: "mouse"
			},
			show: { 
				when: { 
					event: 'mouseover'
				}
			},
			style: myStyle
		});

	};

	/**
	 * Make the day cells roughly 3/4th as tall as they are wide. this makes our calendar wider than it is tall. 
	 */
	jfcalplugin.setAspectRatio("#mycal",0.75);

	/**
	 * Called when user clicks day cell
	 * use reference to plugin object to add agenda item
	 */
	function myDayClickHandler(eventObj){
		// Get the Date of the day that was clicked from the event object
		var date = eventObj.data.calDayDate;
		// store date in our global js variable for access later
		clickDate = date.getDate()+ "/" + (date.getMonth()+1) + "/" +  date.getFullYear();
		//clickDate = <?php echo date("d") ?>+ "/" +<?php echo date("m") ?>+ "/" +<?php echo date("Y") ?>;
		// open our add event dialog
		
		$('#add-event-form').dialog('open');
	};
	
	/**
	 * Called when user clicks and agenda item
	 * use reference to plugin object to edit agenda item
	 */
	function myAgendaClickHandler(eventObj){
		// Get ID of the agenda item from the event object
		var agendaId = eventObj.data.agendaId;	
		alert(agendaId);
		var date = eventObj.data.calDayDate;
		// pull agenda item from calendar
		var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
		clickAgendaItem = agendaItem;
		
		$("#display-event-form").dialog('open');
		
	};
	
	/**
	 * Called when user drops an agenda item into a day cell.
	 */
	function myAgendaDropHandler(eventObj){
		// Get ID of the agenda item from the event object
		var agendaId = eventObj.data.agendaId;
		// date agenda item was dropped onto
		var date = eventObj.data.calDayDate;
		// Pull agenda item from calendar
		var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);		
		alert("You dropped agenda item " + agendaItem.title + 
			" onto " + date.toString() + ". Here is where you can make an AJAX call to update your database.");
	};
	
	/**
	 * Called when a user mouses over an agenda item	
	 */
	function myAgendaMouseoverHandler(eventObj){
		var agendaId = eventObj.data.agendaId;
		var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
		//alert("You moused over agenda item " + agendaItem.title + " at location (X=" + eventObj.pageX + ", Y=" + eventObj.pageY + ")");
	};
	/**
	 * Initialize jquery ui datepicker. set date format to yyyy-mm-dd for easy parsing
	 */
	$("#dateSelect").datepicker({
		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat: 'dd/mm/yy',
		constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
	});
	
	/**
	 * Set datepicker to current date
	 */
	$("#dateSelect").datepicker('setDate', new Date());
	/**
	 * Use reference to plugin object to a specific year/month
	 */
	$("#dateSelect").bind('change', function() {
		var selectedDate = $("#dateSelect").val();
		var dtArray = selectedDate.split("/");
		var year = dtArray[2];
		// jquery datepicker months start at 1 (1=January)		
		var month = dtArray[1];
		// strip any preceeding 0's		
		month = month.replace(/^[0]+/g,"")		
		var day = dtArray[0];
		// plugin uses 0-based months so we subtrac 1
		jfcalplugin.showMonth("#mycal",year,parseInt(month-1).toString());
	});	
	/**
	 * Initialize previous month button
	 */
	$("#BtnPreviousMonth").button();
	$("#BtnPreviousMonth").click(function() {
		jfcalplugin.showPreviousMonth("#mycal");
		// update the jqeury datepicker value
		var calDate = jfcalplugin.getCurrentDate("#mycal"); // returns Date object
		var cyear = calDate.getFullYear();
		// Date month 0-based (0=January)
		var cmonth = calDate.getMonth();
		var cday = calDate.getDate();
		// jquery datepicker month starts at 1 (1=January) so we add 1
		//$("#dateSelect").datepicker("setDate",cyear+"-"+(cmonth+1)+"-"+cday);
		$("#dateSelect").datepicker(cday+"-"+(cmonth+1)+"-"+cyear);	
		return false;
	});
	/**
	 * Initialize next month button
	 */
	$("#BtnNextMonth").button();
	$("#BtnNextMonth").click(function() {
		jfcalplugin.showNextMonth("#mycal");
		// update the jqeury datepicker value
		var calDate = jfcalplugin.getCurrentDate("#mycal"); // returns Date object
		var cyear = calDate.getFullYear();
		// Date month 0-based (0=January)
		var cmonth = calDate.getMonth();
		var cday = calDate.getDate();
		// jquery datepicker month starts at 1 (1=January) so we add 1
		$("#dateSelect").datepicker(cday+"-"+(cmonth+1)+"-"+cyear);		
		return false;
	});
	
	
	

	/**
	 * Initialize add event modal form
	 */
	$("#add-event-form").dialog({
		autoOpen: false,
		height: 400,
		width: 400,
		modal: true,
		buttons: {
			'Crear': function() {

				var what = jQuery.trim($("#what").val());
				var desc = jQuery.trim($("#descripcion").val());
				
			
				if(what == ""){
					alert("Ingrese nombre de la actividad.");
					$("#what").focus();
				}
				else if(desc == ""){
					alert("Desde describir actividad.");
					$("#descripcion").focus();
				}
				
				else{
				
					var startDate = $("#startDate").val();
					var startDtArray = startDate.split("/");
					var startYear = startDtArray[2];
					// jquery datepicker months start at 1 (1=January)		
					var startMonth = startDtArray[1];		
					var startDay = startDtArray[0];
					// strip any preceeding 0's		
					startMonth = startMonth.replace(/^[0]+/g,"");
					startDay = startDay.replace(/^[0]+/g,"");
					var startHour = jQuery.trim($("#startHour").val());
					
					var startMin = jQuery.trim($("#startMin").val());
					var startMeridiem = jQuery.trim($("#startMeridiem").val());
					//startHour = parseInt(startHour.replace(/^[0]+/g,""));
					
					if(startHour == "0" || startHour == "00"){
						startHour = 0;
					}else{
						startHour = parseInt(startHour.replace(/^[0]+/g,""));
					}
					
					if(startMin == "0" || startMin == "00"){
						startMin = 0;
					}else{
						startMin = parseInt(startMin.replace(/^[0]+/g,""));
					}
					/*if(startMeridiem == "AM" && startHour == 12){
						startHour = 0;
					}else if(startMeridiem == "PM" && startHour < 12){
						startHour = parseInt(startHour) + 12;
					}*/

					var endDate = $("#endDate").val();
					var endDtArray = endDate.split("/");
					var endYear = endDtArray[2];
					// jquery datepicker months start at 1 (1=January)		
					var endMonth = endDtArray[1];		
					var endDay = endDtArray[0];
					// strip any preceeding 0's		
					endMonth = endMonth.replace(/^[0]+/g,"");

					endDay = endDay.replace(/^[0]+/g,"");
					var endHour = jQuery.trim($("#endHour").val());
					var endMin = jQuery.trim($("#endMin").val());
					var endMeridiem = jQuery.trim($("#endMeridiem").val());
					//endHour = parseInt(endHour.replace(/^[0]+/g,""));
					
					if(endHour == "0" || endHour == "00"){
						endHour = 0;
					}else{
						endHour = parseInt(endHour.replace(/^[0]+/g,""));
					}
					
					if(endMin == "0" || endMin == "00"){
						endMin = 0;
					}else{
						endMin = parseInt(endMin.replace(/^[0]+/g,""));
					}
					/*if(endMeridiem == "AM" && endHour == 12){
						endHour = 0;
					}else if(endMeridiem == "PM" && endHour < 12){
						endHour = parseInt(endHour) + 12;
					}*/
					
					//alert("Start time: " + startHour + ":" + startMin + " " + startMeridiem + ", End time: " + endHour + ":" + endMin + " " + endMeridiem);

					// Dates use integers
					/*var startDateObj = new Date(parseInt(startDay),parseInt(startMonth)-1,parseInt(startYear),startHour,startMin,0,0);
					var endDateObj = new Date(parseInt(startDay),parseInt(startMonth)-1,parseInt(startYear),endHour,endMin,0,0);*/
					var startDateObj = new Date(parseInt(startDay),parseInt(startMonth)-1,parseInt(startYear),startHour,startMin,0,0);
					var endDateObj = new Date(parseInt(startDay),parseInt(startMonth)-1,parseInt(startYear),endHour,endMin,0,0);

					// add new event to the calendar
					jfcalplugin.addAgendaItem(
						"#mycal",
						what,
						startDateObj,
						endDateObj,
						false,
						{
							Descripcion: desc,
							Actividad: what
							//lname: "Claus",
							
							//myDate: new Date(),
							//myNum: 42
						},
						{
							backgroundColor: $("#colorBackground").val(),
							foregroundColor: $("#colorForeground").val()
						}
					);
					 creaEvento();
					$(this).dialog('close');

				}
				
			},
			Cancelar: function() {
				$(this).dialog('close');
			}
		},
		open: function(event, ui){
			// initialize start date picker
			$("#startDate").datepicker({
				dateFormat: 'dd/mm/yy',
			/*minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),*/
			constrainInput: true,
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1
			});
			// initialize end date picker
			$("#endDate").datepicker({
				dateFormat: 'dd/mm/yy',
			/*minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),*/
			constrainInput: true,
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1
			});
			// initialize with the date that was clicked
			$("#startDate").val(clickDate);
			$("#endDate").val(clickDate);
			// initialize color pickers
			$("#colorSelectorBackground").ColorPicker({
				color: "#333333",
				onShow: function (colpkr) {
					$(colpkr).css("z-index","10000");
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$("#colorSelectorBackground div").css("backgroundColor", "#" + hex);
					$("#colorBackground").val("#" + hex);
				}
			});
			//$("#colorBackground").val("#1040b0");		
			$("#colorSelectorForeground").ColorPicker({
				color: "#ffffff",
				onShow: function (colpkr) {
					$(colpkr).css("z-index","10000");
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$("#colorSelectorForeground div").css("backgroundColor", "#" + hex);
					$("#colorForeground").val("#" + hex);
				}
			});
			//$("#colorForeground").val("#ffffff");				
			// put focus on first form input element
			$("#what").focus();
		},
		close: function() {
			// reset form elements when we close so they are fresh when the dialog is opened again.
			$("#startDate").datepicker("destroy");
			$("#endDate").datepicker("destroy");
			$("#startDate").val("");
			$("#endDate").val("");
			$("#startHour option:eq(0)").attr("selected", "selected");
			$("#startMin option:eq(0)").attr("selected", "selected");
			$("#startMeridiem option:eq(0)").attr("selected", "selected");
			$("#endHour option:eq(0)").attr("selected", "selected");
			$("#endMin option:eq(0)").attr("selected", "selected");
			$("#endMeridiem option:eq(0)").attr("selected", "selected");			
			$("#what").val("");
			$("#descripcion").val("");
			//$("#colorBackground").val("#1040b0");
			//$("#colorForeground").val("#ffffff");
		}
	});
	
	/**
	 * Initialize display event form.
	 */
	$("#display-event-form").dialog({
		autoOpen: false,
		height: 400,
		width: 400,
		modal: true,
		buttons: {		
			Cancelar: function() {
				$(this).dialog('destroy');
			},
			'Editar': function() {
				if(clickAgendaItem != null){
						jfcalplugin.deleteAgendaItemById("#mycal",clickAgendaItem.agendaId);
						var data = clickAgendaItem.data;
						//var data = clickAgendaItem.data;
										
						if(modificaEvento(data['id'])){
						alert("www");
						}						
						
					}
					var cac = $('#ial').val();
						alert("dd"+cac);
				//alert("Make your own edit screen or dialog!");
			},
			'Eliminar': function() {
				if(confirm("Seguro que desea eliminar este evento?")){
					if(clickAgendaItem != null){
						jfcalplugin.deleteAgendaItemById("#mycal",clickAgendaItem.agendaId);
						var data = clickAgendaItem.data;
						//var data = clickAgendaItem.data;
										
						eliminaEvento(data['id']);
						jfcalplugin.deleteAgendaItemById("#mycal",clickAgendaItem.agendaId);
					}
					$(this).dialog('destroy');
				}
			}			
		},
		open: function(event, ui){
			
			if(clickAgendaItem != null){
				var title = clickAgendaItem.title;
				var startDate = clickAgendaItem.startDate;
				var agein = startDate.toLocaleString();
				var resin = agein.split(" ");
				
				var endDate = clickAgendaItem.endDate;
				var agefn = endDate.toLocaleString();
				var resfn = agefn.split(" ");
				var allDay = clickAgendaItem.allDay;
				var data = clickAgendaItem.data;
				var id = clickAgendaItem.agendaId;
				// in our example add agenda modal form we put some fake data in the agenda data. we can retrieve it here.
				$("#display-event-form").append(
					"<br><b>" + title+ "</b><br><br>"		
				);				
				if(allDay){
					$("#display-event-form").append(
						"(All day event)<br><br>"				
					);				
				}else{
					$("#display-event-form").append(
						"<b>Fecha Inicio:</b> " + resin[0]+" "+resin[1] + "<br>" +
						"<b>Fecha t&eacute;rmino:</b> " + resfn[0]+" "+resfn[1] + "<br><br>"			
					);				
				}
				for (var propertyName in data) {
					$("#display-event-form").append("<b>" + propertyName + ":</b> " + data[propertyName] + "<br>");
				}			
			}		
		},
		close: function() {
			// clear agenda data
			$("#display-event-form").html("");
		}
	});
	
	<?php for($a=0;$a<pg_numrows($rs_act);$a++){
		$fila_act = pg_fetch_array($rs_act,$a);
		$fechai = explode("-",$fila_act['fecha_inicio']);
		$fechat = explode("-",$fila_act['fecha_termino']);
		$horai = explode(":",$fila_act['hora_inicio']);
		$horat = explode(":",$fila_act['hora_termino']);
		?>
		
		
		
jfcalplugin.addAgendaItem(
	"#mycal",
	"<?php echo $fila_act['nombre'] ?>",
	new Date(<?php echo $fechai[0] ?>,<?php echo ($fechai[1]-1) ?>,<?php echo ($fechai[2]) ?>,<?php echo ($horai[0]) ?>,<?php echo ($horai[1]) ?>,0),
	new Date(<?php echo $fechat[0] ?>,<?php echo ($fechat[1]-1) ?>,<?php echo ($fechat[2]) ?>,<?php echo ($horat[0]) ?>,<?php echo ($horat[1]) ?>),
	false,
	
	{
		Detalle: "<?php echo $fila_act['descripcion'] ?>",
		id: "<?php echo $fila_act['id_actividad'] ?>"
	},
	{
		<?php 
		$color1 = rand_color();
		//$color2 = rand_color();
		
		//if($color1 == $color2){$color2 = rand_color();}
		if($color1=="#ffffff"){$color2="#000000";}
		elseif($color1=="#000000"){$color2="#ffffff";}
		else{$color2="#ffffff";}
		?>
		backgroundColor: "<?php echo $color1 ?>",
		foregroundColor: "<?php echo $color2 ?>"
	}
		
);


	<?php }?>
	
});

	
	
	//hago la carga
</script>

<div id="example" style="margin: auto; width:80%;">
		
		<br>
		<br><br>

  <div id="toolbar" class="ui-widget-header ui-corner-all" style="padding:3px; vertical-align: middle; white-space:nowrap; overflow: hidden;">
			<button id="BtnPreviousMonth">Mes Anterior</button>
			<button id="BtnNextMonth">Mes Siguiente</button>
			&nbsp;&nbsp;&nbsp;
			Fecha: <input type="text" id="dateSelect" size="20"/>
&nbsp;&nbsp;	</div>

		<br>

		<!--
		You can use pixel widths or percentages. Calendar will auto resize all sub elements.
		Height will be calculated by aspect ratio. Basically all day cells will be as tall
		as they are wide.
		-->
		<div id="mycal"></div>

</div>

		<!-- debugging-->
		<div id="calDebug"></div>

		<!-- Add event modal form -->
		<style type="text/css">
			//label, input.text, select { display:block; }
			fieldset { padding:0; border:0; margin-top:25px; }
			.ui-dialog .ui-state-error { padding: .3em; }
			.validateTips { border: 1px solid transparent; padding: 0.3em; }
		</style>
		<div id="add-event-form" title="Ingresar Datos Actividad">
			<p class="validateTips">Todos los campos son requeridos.</p>
			<form>
			<fieldset>
				<label for="name">Nombre actividad</label>
				<input type="text" name="what" id="what" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>
				<table style="width:100%; padding:5px;">
					<tr>
						<td>
							<label for="startDate">Fecha Inicio</label>
							<input type="text" name="startDate" id="startDate" value="" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>				
						</td>
						<td>&nbsp;</td>
						<td>
							<label>Hora Inicio</label>
							<select id="startHour" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
								<?php for($h=0;$h<=23;$h++){
									$hh = ($h<10)?"0".$h:$h;
									?>
                                    <option value="<?php echo $hh ?>"><?php echo $hh ?></option>
                                <?php  } ?>
							</select>				
						<td>
						<td>
							<label>Minuto</label>
							<select id="startMin" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
							<?php for($m=0;$m<=59;$m++){
									$mm = ($m<10)?"0".$m:$m;
									?>
                                    <option value="<?php echo $mm ?>"><?php echo $mm ?></option>
                                <?php  } ?>
							</select>				
						<td>						
				  </tr>
					<tr>
						<td>
							<label>Fecha t&eacute;rmino</label>
							<input type="text" name="endDate" id="endDate" value="" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>				
						</td>
						<td>&nbsp;</td>
						<td>
							<label>Hora t&eacute;rmino</label>
							<select id="endHour" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
								<?php for($h=0;$h<=23;$h++){
									$hh = ($h<10)?"0".$h:$h;
									?>
                                    <option value="<?php echo $hh ?>"><?php echo $hh ?></option>
                                <?php  } ?>
							</select>				
						<td>
						<td>
							<label>Minuto</label>
							<select id="endMin" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
								<?php for($m=0;$m<=59;$m++){
									$mm = ($m<10)?"0".$m:$m;
									?>
                                    <option value="<?php echo $mm ?>"><?php echo $mm ?></option>
                                <?php  } ?>
							</select>				
						<td>										
				  </tr>	
                    <td colspan="5">Descripci&oacute;n</td>
					  <td>                      
				  </tr>
					<tr>
					  <td colspan="5"><textarea name="descripcion" cols="30" rows="5" id="descripcion"></textarea></td>
					  <td>                      
				  </tr>			
				</table>
			</fieldset>
			</form>
		</div>
		
		<div id="display-event-form" title="Detalle Actividad"></div>		

		<p>&nbsp;</p>

	</div><!-- end example tab -->

<?
}if($funcion==3){
	//var_dump($_POST);
	$in = explode("/",$fecha_inicio);
	$mi = ($in[1]<10)?"0".$in[1]:$in[1];
	$di = ($in[0]<10)?"0".$in[0]:$in[0];
	$fini = $in[2]."-".$mi."-".$di;
	
	$te = explode("/",$fecha_termino);
	$mt = ($te[1]<10)?"0".$te[1]:$te[1];
	$dt = ($te[0]<10)?"0".$te[0]:$te[0];
	$fter = $te[2]."-".$mt."-".$dt;
	
	$rs_guarda = $ob_calendario->guardaAct($conn,$curso,$nombre,$fini,$fter,$hora_inicio,$hora_termino,$descripcion);
}
if($funcion==4){
//var_dump($_POST);
$rs_borra = $ob_calendario->borraAct($conn,$act);
}
if($funcion==5){
//var_dump($_POST);
$rs_act = $ob_calendario->traeAct($conn,$act);
$fila_act =pg_fetch_array($rs_act,0);
$horai = explode(":",$fila_act['hora_inicio']);
$horat = explode(":",$fila_act['hora_termino']);
?>
<script>
$(document).ready(function(){
	
	$("#startDate2, #endDate2").datepicker({
			dateFormat: 'dd/mm/yy',
			/*minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),*/
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute']
			//buttonImage: 'img/Calendario.PNG',
		});
		
		
	

  });
  
 
	

  </script>
<p class="validateTips">Todos los campos son requeridos.</p>
<input type="hidden" id="idact" value="<?=$fila_act['id_actividad']?>">
			<form>
			<fieldset>
				<label for="name">Nombre actividad</label>
				<input type="text" name="what" id="what2" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;" value="<?=$fila_act['nombre']?>"/>
				<table style="width:100%; padding:5px;">
					<tr>
						<td>
							<label for="startDate">Fecha Inicio</label>
							<input type="text" name="startDate" id="startDate2" value="<?=CambioFD($fila_act['fecha_inicio'])?>" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>				
						</td>
						<td>&nbsp;</td>
						<td>
							<label>Hora Inicio</label>
							<select id="startHour2" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
								<?php for($h=0;$h<=23;$h++){
									$hh = ($h<10)?"0".$h:$h;
									?>
                                    <option value="<?php echo $hh ?>" <?=($horai[0]==$hh)?"selected":"" ?>><?php echo $hh ?></option>
                                <?php  } ?>
							</select>				
						<td>
						<td>
							<label>Minuto</label>
							<select id="startMin2" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
							<?php for($m=0;$m<=59;$m++){
									$mm = ($m<10)?"0".$m:$m;
									?>
                                    <option value="<?php echo $mm ?>" <?=($horai[1]==$mm)?"selected":"" ?>><?php echo $mm ?></option>
                                <?php  } ?>
							</select>				
						<td>						
				  </tr>
					<tr>
						<td>
							<label>Fecha t&eacute;rmino</label>
							<input type="text" name="endDate2" id="endDate2" value="<?=CambioFD($fila_act['fecha_termino'])?>" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>				
						</td>
						<td>&nbsp;</td>
						<td>
							<label>Hora t&eacute;rmino</label>
							<select id="endHour2" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
								<?php for($h=0;$h<=23;$h++){
									$hh = ($h<10)?"0".$h:$h;
									?>
                                    <option value="<?php echo $hh ?>" <?=($horat[0]==$hh)?"selected":"" ?>><?php echo $hh ?></option>
                                <?php  } ?>
							</select>				
						<td>
						<td>
							<label>Minuto</label>
							<select id="endMin2" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
								<?php for($m=0;$m<=59;$m++){
									$mm = ($m<10)?"0".$m:$m;
									?>
                                    <option value="<?php echo $mm ?>" <?=($horat[1]==$mm)?"selected":"" ?>><?php echo $mm ?></option>
                                <?php  } ?>
							</select>				
						<td>										
				  </tr>	
                    <td colspan="5">Descripci&oacute;n</td>
					  <td>                      
				  </tr>
					<tr>
					  <td colspan="5"><textarea name="descripcion" cols="30" rows="5" id="descripcion2"><?=$fila_act['descripcion']?></textarea></td>
					  <td>                      
				  </tr>			
				</table>
<?
}if($funcion==6){
	//var_dump($_POST);
	
$rs_amodi = $ob_calendario->actAct($conn,$nombre,CambioFE($fecha_inicio),CambioFE($fecha_termino),$hora_inicio,$hora_termino,$descripcion,$idact);
//echo($rs_amodi)?1:0;
}
?>