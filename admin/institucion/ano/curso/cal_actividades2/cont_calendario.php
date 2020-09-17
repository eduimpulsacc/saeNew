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
    <select name="cmb_curso" id="cmb_curso" onchange="traeEvento(this.value);">
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
	}else{?>
    
		<input type="hidden" name="cmb_curso" id="cmb_curso" value="<?php echo $_CURSO ?>" />
        <script>
	$( document ).ready(function() {
	
   traeEvento(<?php echo $_CURSO ?>);
   				
});
	</script>
    <?php echo CursoPalabra($_CURSO,1,$conn) ?>
	<?
	}
	
}

if($funcion==2){
	
	$rs_act = $ob_calendario->cargaAct($conn,$curso);
	
?>
<link rel="stylesheet" type="text/css" href="../../../../clases/calendar/css/frontierCalendar/jquery-frontier-cal-1.3.2.css" />

<!-- Include CSS for color picker plugin (Not required for calendar plugin. Used for example.) -->
<link rel="stylesheet" type="text/css" href="../../../../clases/calendar/css/colorpicker/colorpicker.css" />

<!-- Include CSS for JQuery UI (Required for calendar plugin.) -->
<link rel="stylesheet" type="text/css" href="../../../../clases/calendar/css/jquery-ui/smoothness/jquery-ui-1.8.1.custom.css" />

<!--
Include JQuery Core (Required for calendar plugin)
** This is our IE fix version which enables drag-and-drop to work correctly in IE. See README file in js/jquery-core folder. **
-->
<script type="text/javascript" src="../../../../clases/calendar/js/jquery-core/jquery-1.4.2-ie-fix.min.js"></script>

<!-- Include JQuery UI (Required for calendar plugin.) -->
<script type="text/javascript" src="../../../../clases/calendar/js/jquery-ui/smoothness/jquery-ui-1.8.1.custom.min.js"></script>

<!-- Include color picker plugin (Not required for calendar plugin. Used for example.) -->
<script type="text/javascript" src="../../../../clases/calendar/js/colorpicker/colorpicker.js"></script>

<!-- Include jquery tooltip plugin (Not required for calendar plugin. Used for example.) -->
<script type="text/javascript" src="../../../../clases/calendar/js/jquery-qtip-1.0.0-rc3140944/jquery.qtip-1.0.js"></script>

<script type="text/javascript" src="../../../../clases/calendar/js/lib/jshashtable-2.1.js"></script>

<!-- Include JQuery Frontier Calendar plugin -->
<script type="text/javascript" src="../../../../clases/calendar/js/frontierCalendar/jquery-frontier-cal-1.3.2.min.js"></script>
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
		dragAndDropEnabled: true
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
		var endDate = agendaItem.endDate;
		var allDay = agendaItem.allDay;
		var data = agendaItem.data;
		var detalle = agendaItem.desc_act;
		displayData += "<br><b>" + title+ "</b><br><br>";
		if(allDay){
			displayData += "(Todo el d\u00EDa)<br><br>";
		}else{
			displayData += "<b>Comienza:</b> " + startDate + "<br>" + "<b>Termina:</b> " + endDate + "<br><br>"+ "<b>Detalle:</b> " + detalle + "<br><br>";
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
		var dd=(date.getDate()<10)?"0"+date.getDate():date.getDate();
		var mm=((date.getMonth()+1)<10)?"0"+(date.getMonth()+1):(date.getMonth()+1);
		// store date in our global js variable for access later
		clickDate =  dd+ "/" + mm + "/" + date.getFullYear();
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
		alert("Ha eliminado evento " + agendaItem.title + 
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
		dateFormat: 'dd/mm/yy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		firstDay: 1
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
		$("#dateSelect").datepicker("setDate",cday+"/"+(cmonth+1)+"/"+cyear);
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
		$("#dateSelect").datepicker("setDate",cday+"/"+(cmonth+1)+"/"+cyear);		
		return false;
	});
	
	/**
	 * Initialize delete all agenda items button
	 */
	$("#BtnDeleteAll").button();
	$("#BtnDeleteAll").click(function() {	
		jfcalplugin.deleteAllAgendaItems("#mycal");	
		return false;
	});		
	
	/**
	 * Initialize iCal test button
	 */
	$("#BtnICalTest").button();
	$("#BtnICalTest").click(function() {
		// Please note that in Google Chrome this will not work with a local file. Chrome prevents AJAX calls
		// from reading local files on disk.		
		jfcalplugin.loadICalSource("#mycal",$("#iCalSource").val(),"html");	
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
			'Agregar': function() {

				var what = jQuery.trim($("#what").val());
				var desc_act = jQuery.trim($("#desc_act").val());
			
				if(what == ""){
					alert("Ingrese una descripci\u00F3n corta de la actividad.");
				}
				else if(desc_act == ""){
					alert("Complete los detalles de la actividad.");
					$("#desc_act").focus();
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
					startHour = parseInt(startHour.replace(/^[0]+/g,""));
					if(startMin == "0" || startMin == "00"){
						startMin = 0;
					}else{
						startMin = parseInt(startMin.replace(/^[0]+/g,""));
					}
					if(startMeridiem == "AM" && startHour == 12){
						startHour = 0;
					}else if(startMeridiem == "PM" && startHour < 12){
						startHour = parseInt(startHour) + 12;
					}

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
					endHour = parseInt(endHour.replace(/^[0]+/g,""));
					if(endMin == "0" || endMin == "00"){
						endMin = 0;
					}else{
						endMin = parseInt(endMin.replace(/^[0]+/g,""));
					}
					if(endMeridiem == "AM" && endHour == 12){
						endHour = 0;
					}else if(endMeridiem == "PM" && endHour < 12){
						endHour = parseInt(endHour) + 12;
					}
					
					//alert("Start time: " + startHour + ":" + startMin + " " + startMeridiem + ", End time: " + endHour + ":" + endMin + " " + endMeridiem);

					// Dates use integers
					var startDateObj = new Date(parseInt(startYear),parseInt(startMonth)-1,parseInt(startDay),startHour,startMin,0,0);
					var endDateObj = new Date(parseInt(endYear),parseInt(endMonth)-1,parseInt(endDay),endHour,endMin,0,0);
					creaEvento();
					
<?php
					 $max = $ob_calendario->maxI($conn);
					 $cod = pg_result($max,0);
					?>
					// add new event to the calendar
					jfcalplugin.addAgendaItem(
						"#mycal",
						what,
						startDateObj,
						endDateObj,
						false,
						{
							Detalle: desc_act,
							id: "<?php echo $cod ?>"
						},
						{
								<?
								$color1 = rand_color();
								if($color1=="#ffffff"){$color2="#000000";}
								elseif($color1=="#000000"){$color2="#ffffff";}
								else{$color2="#ffffff";}
								?>
								backgroundColor: "<?php echo $color1 ?>",
								foregroundColor: "<?php echo $color2 ?>"
						}
					);


					$(this).dialog('close');

				}
				
			},
			"Cancelar": function() {
				$(this).dialog('close');
			}
		},
		open: function(event, ui){
			// initialize start date picker
			$("#startDate").datepicker({
				showOtherMonths: true,
				selectOtherMonths: true,
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: 'dd/mm/yy',
		dateFormat: 'dd/mm/yy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		firstDay: 1
				
			});
			// initialize end date picker
			$("#endDate").datepicker({
				showOtherMonths: true,
				selectOtherMonths: true,
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: 'dd/mm/yy',
		dateFormat: 'dd/mm/yy',
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
			$("#desc_act").val("");
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
			Cancel: function() {
				$(this).dialog('close');
			},
			'Editar datos': function() {
				alert("Make your own edit screen or dialog!");
			},
			'Eliminar datos': function() {
				if(confirm("\u00BFConfirma que desea eliminar este evento?")){
					if(clickAgendaItem != null){
						jfcalplugin.deleteAgendaItemById("#mycal",clickAgendaItem.agendaId);
						eliminaEvento(data['id']);
						//jfcalplugin.deleteAgendaItemByDataAttr("#mycal","myNum",42);
					}
					$(this).dialog('close');
				}
			}			
		},
		open: function(event, ui){
			if(clickAgendaItem != null){
				var title = clickAgendaItem.title;
				var startDate = clickAgendaItem.startDate;
				var endDate = clickAgendaItem.endDate;
				var allDay = clickAgendaItem.allDay;
				var data = clickAgendaItem.data;
				var detalle = clickAgendaItem.desc_act;
				// in our example add agenda modal form we put some fake data in the agenda data. we can retrieve it here.
				$("#display-event-form").append(
					"<br><b>" + title+ "</b><br><br>"		
				);				
				if(allDay){
					$("#display-event-form").append(
						"(Todo el d\u00EDa)<br><br>"				
					);				
				}else{
					$("#display-event-form").append(
						"<b>Empieza:</b> " + startDate + "<br>" +
						"<b>Termina:</b> " + endDate + "<br><br>"+
						"<b>Detalle:</b> " + detalle + "<br><br>"				
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

	/**
	 * Initialize our tabs
	 */
	$("#tabs").tabs({
		/*
		 * Our calendar is initialized in a closed tab so we need to resize it when the example tab opens.
		 */
		show: function(event, ui){
			if(ui.index == 1){
				jfcalplugin.doResize("#mycal");
			}
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
</script>
		
		

		<div id="toolbar" class="ui-widget-header ui-corner-all" style="padding:3px; vertical-align: middle; white-space:nowrap; overflow: hidden;">
			<button id="BtnPreviousMonth">Mes Anterior</button>
			<button id="BtnNextMonth">Mes siguiente</button>
			&nbsp;&nbsp;&nbsp;
			Fecha: <input type="text" id="dateSelect" size="20"/>
		  &nbsp;&nbsp;&nbsp;</div>

		<br>

		<!--
		You can use pixel widths or percentages. Calendar will auto resize all sub elements.
		Height will be calculated by aspect ratio. Basically all day cells will be as tall
		as they are wide.
		-->
		<div id="mycal">lkdlkjsdfjklfdslkj</div>

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
		<div id="add-event-form" title="Datos evento">
		  <p class="validateTips">Todos los campos son requeridos.</p>
			 <form id="frm" name="frm">
			<fieldset>
				<label for="name">Actividad</label>
				<input type="hidden" name="hiddenField" id="hiddenField" />
				<input type="text" name="what" id="what" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>
				<table style="width:100%; padding:5px;">
					<tr>
					  <td>
						<label>&iquest;Cu&aacute;ndo empieza?</label>
						  <input name="startDate" type="text" class="text ui-widget-content ui-corner-all" id="startDate" style="margin-bottom:12px; width:95%; padding: .4em;" value="" readonly="readonly"/>				
						</td>
						<td>&nbsp;</td>
						<td>
							<label>HH</label><select name="startHour" class="text ui-widget-content ui-corner-all" id="startHour" style="margin-bottom:12px; width:95%; padding: .4em;">
								<option value="12" SELECTED>12</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
							</select>				
						<td>
						<td>
							<label>MM</label>
							<select name="startMin" class="text ui-widget-content ui-corner-all" id="startMin" style="margin-bottom:12px; width:95%; padding: .4em;">
								<option value="00" SELECTED>00</option>
                                <option value="05">05</option>
								<option value="10">10</option>
                                <option value="15">15</option>
								<option value="20">20</option>
                                <option value="25">25</option>
								<option value="30">30</option>
                                <option value="35">35</option>
								<option value="40">40</option>
                                <option value="45">45</option>
								<option value="50">50</option>
                                <option value="55">55</option>
							</select>	
                            </td>
                            <td>
							<label> AM/PM</label>
							<select name="startMeridiem" class="text ui-widget-content ui-corner-all" id="startMeridiem" style="margin-bottom:12px; width:95%; padding: .4em;">
								<option value="AM" SELECTED>AM</option>
								<option value="PM">PM</option>
							</select>				
						</td>					
					</tr>
					<tr>
					  <td>
						<label>&iquest;Cu&aacute;ndo termina?</label>
						  <input name="endDate" type="text" class="text ui-widget-content ui-corner-all" id="endDate" style="margin-bottom:12px; width:95%; padding: .4em;" value="" readonly="readonly"/>				
						</td>
						<td>&nbsp;</td>
						<td>
							<label>HH</label>
							<select name="endHour" class="text ui-widget-content ui-corner-all" id="endHour" style="margin-bottom:12px; width:95%; padding: .4em;">
								<option value="12" SELECTED>12</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
							</select>				
						<td>
						<td>
							<label>MM</label>
							<select name="endMin" class="text ui-widget-content ui-corner-all" id="endMin" style="margin-bottom:12px; width:95%; padding: .4em;">
								<option value="00" SELECTED>00</option>
                                <option value="05">05</option>
								<option value="10">10</option>
                                <option value="15">15</option>
								<option value="20">20</option>
                                <option value="25">25</option>
								<option value="30">30</option>
                                <option value="35">35</option>
								<option value="40">40</option>
                                <option value="45">45</option>
								<option value="50">50</option>
                                <option value="55">55</option>
							</select>
                            </td>
                            <td>
							<label> AM/PM</label>
							<select name="endMeridiem" class="text ui-widget-content ui-corner-all" id="endMeridiem" style="margin-bottom:12px; width:95%; padding: .4em;">
								<option value="AM" SELECTED>AM</option>
								<option value="PM">PM</option>
							</select>				
						</td>											
					</tr>
					<tr>
					  <td colspan="6">Descripci&oacute;n				      </td>
				  </tr>
					<tr>
					  <td colspan="6"><label for="desc_act"></label>
                      <textarea name="desc_act" cols="40" rows="5" id="desc_act"></textarea></td>
				  </tr>
					<tr>
					  <td colspan="6">&nbsp;</td>
				  </tr>			
				</table>
			</fieldset>
			</form>
		</div>
		
		<div id="display-event-form" title="Actividad"></div>
        <div id="ediact" title="Modificar datos actividad"></div>
			
			
<?	
}
if($funcion==3){
var_dump($_POST);

$hora_inicio = date( "H:i", strtotime( "$startHour:$startMin $startMeridiem" ) ).":00";
$hora_termino = date( "H:i", strtotime( "$endHour:$endMin $endMeridiem" ) ).":00";

 $rs_guarda = $ob_calendario->guardaAct($conn,$curso,utf8_decode($what),CambioFE($startDate),CambioFE($endDate),$hora_inicio,$hora_termino,utf8_decode($desc_act));

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
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1
			
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
<?php }?>