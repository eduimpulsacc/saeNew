
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){ 
window.close() 
} 

</script>

<?

require('../../../../../util/header.inc');
//include ("../calendario/calendario.php");


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 6;
	
	$sql_ano_actual = "select nro_ano from ano_escolar where id_institucion=".$institucion." AND id_ano = '".$_ANO."'";
	$res_ano_actual = @pg_Exec($conn,$sql_ano_actual);
	$fil_ano_actual = @pg_fetch_array($res_ano_actual,0);
	$nro_ano = $fil_ano_actual['nro_actual'];
	
	$sql = "SELECT nombre FROM tmp_matricula WHERE rdb=".$institucion;
	$rs_archivo = @pg_exec($conn,$sql);
	for($i=0;$i<@pg_numrows($rs_archivo);$i++){
		$fila = @pg_fetch_array($rs_archivo,$i);
		unlink('files/'.$fila['nombre']);
		/*if (!unlink('files/'.$fila['nombre'])){
			echo 'no se pudo borrar el archivo :'.$fila['nombre'];
		} */
	}
	$sql = "DELETE FROM tmp_matricula WHERE rdb=".$institucion;
	$rs_delete = @pg_exec($conn,$sql);
	
	
		
	

?>
<html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 00px;
}
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
-->
</style><head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="uploadify/uploadify.css" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function valida_ingreso(){
	if((document.frm1.BUSCARX[0].checked)&&(document.frm1.filtroRUT.value=="")){
		alert("Debe ingresar Rut");
		return;
	}
	if((document.frm1.BUSCARX[1].checked)&&(document.frm1.Apellido.value=="")){
		alert("Debe ingresar Apellido");
		return;
	}
	document.frm1.submit();
}
//-->



</script>
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
		'scriptData': {'name':'<?=$institucion;?>'}, // If the value is known to php you can also enter it here ie < ?= $value ?> or < ?= $_RESULT['value'] ?>
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
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>


<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						 $menu_lateral=3; 
						 include("../../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  <br>
								  <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
								  <fieldset style="border: 1px solid #CDCDCD; padding: 8px; padding-bottom:0px; margin: 8px 0">
							
									<hr width=100% size="1" color="" align="center">
									<p><span class="Estilo1" id="result_box">PASO 1: Subir Archivos </span>
									  <!-- Adding the value="John Doe" does not update the scriptData. It purley gives startUpload() something to pass in the conditional,
									and if the user deletes the name it will still trigger the alert -->
									  <input name="name2" id="name2" type="hidden" maxlength="255" size="50" value="<?=$institucion;?>"/>
									  
							</p>
									<div id="fileUploadname2">You have a problem with your javascript</div>
							<a href="javascript:startUpload('fileUploadname2', document.getElementById('name2'))">Subir Archivo</a> |
							<a href="javascript:$('#fileUploadname2').fileUploadClearQueue()">Cancelar Subida</a>
							<p></p>
					<hr width=100% size="1" color="" align="center">
									<p><span class="Estilo1" id="result_box">PASO 2: Cargar Matricula Inicial </span></p>
									<a href="inscribe_alumnos.php"><img src="uploadify/b_cargar.jpg" border="0" /></a>
									<p></p>
									<hr width=100% size="1" color="" align="center">
						</fieldset>
						<br />
								  <!-- FIN DEL NUEVO CÓDIGO -->
								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2007 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</tr>
</tr></div>
</body>
</html>
<? pg_close($conn);?>