<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<title>::::::::COLEGIO INTERACTIVO::::::::::</title>

<link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" />

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery.uploadify.js"></script>

<script type="text/javascript">
function startUpload(id, conditional)
{
	if(conditional.value.length != 0) {
		$('#'+id).fileUploadStart();
	} else
		alert("Usted debe ingresar su nombre. Antes de subir");
}
</script>
<script type="text/javascript">


$(document).ready(function() {
	$("#fileUploadname").fileUpload({
		'uploader': 'uploadify/uploader.swf',
		'cancelImg': 'uploadify/cancel.png',
		'script': 'uploadify/upload_name.php',
		'folder': 'files',
		'multi': false,
		'displayData': 'percentage',
		onComplete: function (evt, queueID, fileObj, response, data) {
			alert("Successfully uploaded: "+response);
		}
	});

	$("#fileUploadname2").fileUpload({
		'uploader': 'uploadify/uploader.swf',
		'cancelImg': 'uploadify/cancel.png',
		'script': 'uploadify/upload_name.php',
		'folder': 'files',
		'multi': true,
		'displayData': 'percentage',
		'scriptData': {'name':'rdb'}, // If the value is known to php you can also enter it here ie < ?= $value ?> or < ?= $_RESULT['value'] ?>
		onComplete: function (evt, queueID, fileObj, response, data) {
			//alert("Successfully uploaded: "+response);
		}
	});

	$("#fileUploadname3").fileUpload({
		'uploader': 'uploadify/uploader.swf',
		'cancelImg': 'uploadify/cancel.png',
		'script': 'uploadify/upload_name.php',
		'folder': 'files',
		'multi': true,
		'displayData': 'percentage',
		'scriptData': {'name':'JohnDoe', 'location':'Australia'}, 
		onComplete: function (evt, queueID, fileObj, response, data) {
			alert("Successfully uploaded: "+response);
		}
	});

	$('#name').bind('change', function(){
		$('#fileUploadname').fileUploadSettings('scriptData','&name='+$(this).val());
	});
	$('#name2').bind('change', function(){
		$('#fileUploadname2').fileUploadSettings('scriptData','&name='+$(this).val());
	});

	// When setting scriptData you must enter the full parameter string. More checks need to be done in this case
	// because what you will experience is if you enter a name it will wipe location:Australia unless Australia is
	// written in the location field. The same applies visa versa, the only difference is there is an "isEmpty" check
	// on the name field.
	$('#name3').bind('change', function(){
		$('#fileUploadname3').fileUploadSettings('scriptData','&name='+$(this).val()+'&location='+$('#location').val());
	});
	$('#location').bind('change', function(){
		$('#fileUploadname3').fileUploadSettings('scriptData','&name='+$('#name3').val()+'&location='+$(this).val());
	});

});

</script>
</head>

<body>
      <fieldset style="border: 1px solid #CDCDCD; padding: 8px; padding-bottom:0px; margin: 8px 0">
		
				<hr width=100% size="1" color="" align="center">
				<p><span id="result_box"><span title="Name is known at execution of this file, but   can be overridden.">Nombre es conocido en la ejecuci&oacute;n de este archivo,   pero se puede reemplazar.</span></span></p>
				<strong>Nombre Archivo:  </strong>
				<!-- Adding the value="John Doe" does not update the scriptData. It purley gives startUpload() something to pass in the conditional,
				and if the user deletes the name it will still trigger the alert -->
                <input name="name2" id="name2" type="hidden" maxlength="255" size="50" value="RDB"/>
                <br /><br />
		<div id="fileUploadname2">You have a problem with your javascript</div>
		<a href="javascript:startUpload('fileUploadname2', document.getElementById('name2'))">Subir Archivo</a> |
		<a href="javascript:$('#fileUploadname2').fileUploadClearQueue()">Cancelar Subida</a>
    	<p></p>
<hr width=100% size="1" color="" align="center">
				<p>&nbsp;</p>
				<p></p>
    </fieldset>
</body>
</html>