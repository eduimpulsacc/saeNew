<?php require('../../../../../util/header.inc');
session_start();
$institucion=$_INSTIT;
$_POSP = 4;
$_bot = 7;
$plantilla	=$plantilla;

require "../../Class/mod_plantillas.php";
$obj_informe = new informeApo();

$result_planilla = $obj_informe->getDatoPlantilla($conn,$plantilla);
$num_planilla=pg_numrows($result_planilla);
if ($num_planilla>0){
	$row_planilla=pg_fetch_array($result_planilla);
}


if(session_is_registered('_PLANTILLA_APO')){
		session_unregister('_PLANTILLA_APO');
	};
	
	session_register('_PLANTILLA_APO');
	
	$_PLANTILLA_APO=$plantilla;


	$rs_area = $obj_informe->getAreas($conn,$plantilla);

?>
<!DOCTYPE HTML >
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>

<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css"> <script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script language="JavaScript" type="text/JavaScript">

$(document).ready(function() {
	 cargaIndicador();
	  });


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
//-->
</script>
<script language="javascript" type="text/javascript">
<!--


function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
 
 
 function IngresoArea(){
	$("#formulario_clas").html('<br><form name="ingresoClas" id="ingresoClas" ><table><tr><td width="180"><label>Nombre:</label></td><td width="174"><input name="nombre_clas" id="nombre_clas" type="text" size="15" maxlength="30" /></td></tr></table></form>');
		   
	$("#formulario_clas").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 400,
   Height: 300,
   minWidth: 400,
   minHeight: 300,
   maxWidth: 400,
   maxHeight: 300,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
	 "Guardar Datos": function(){
		 if($('#nombre_clas').val()==0){
			alert("Escriba nombre de Area");
			$('#nombre_clas').focus();
			return false;
		}
		   ingresar_Area();
		  
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }) 
		   
  }
function ingresar_Area(){
	
var parametros = "funcion=10&nombre="+$("#nombre_clas").val()+"&plantilla="+<?php echo $plantilla ?>;
  $.ajax({
	url:"con_paso2.php",
	data:parametros,
	type:'POST',
	success:function(data){
		//console.log(data);
			if(data == 0){
			   alert("Error al Guardar Datos");
			}else{
			  alert("Datos Guardados");
			  cargaselectClas();
			  return true;
			}
		}
	}) 
  }		
    
function cargaselectClas(){
var parametros="funcion=11&plantilla="+<?php echo $plantilla ?>;
	$.ajax({
	url:'con_paso2.php',
	data:parametros,
	type:'POST',
	success:function(data){
	//alert(data);
		if(data==0){
		//alert("Error al Cargar");
		}else{
			$('#areas').html(data);
			
			}
		 }
	 })
} // fin funcion cargartabla	
 
 
function guardarIndicador(){
var plantilla = <?php echo $plantilla ?>;
var funcion=1;
var area=$("#cmbArea").val();
var indicador = $("#txt_indicador").val();

var parametros="plantilla="+plantilla+"&funcion="+funcion+"&area="+area+"&nombre="+indicador;

if(area != 0 && indicador.length >2){
$.ajax({
	url:'con_paso2.php',
	data:parametros,
	type:'POST',
	success:function(data){
		//console.log(data);
	//alert(data);
		if(data==0){
		alert("Debe tener al menos 1 area creada");
		}else{
			//alert("Error al Cargar");$('#areas').html(data);
			alert("Datos Guardados");
			 $("#txt_indicador").val('');
			cargaIndicador();
			}
		 }
	 })
}else{
alert("Ingrese campos requeridos");
}

}
 
function cargaIndicador(){
	 var plantilla = <?php echo $plantilla ?>;
	 var funcion=2;
	 var parametros="plantilla="+plantilla+"&funcion="+funcion;
	 
	 $.ajax({
	url:'con_paso2.php',
	data:parametros,
	type:'POST',
	success:function(data){
		//console.log(data);
	//alert(data);
		if(data==0){
		alert("Error al Cargar");
		}else{
			//alert("Error al Cargar");
			$('#listaindicador').html(data);
			
			
			}
		 }
	 })
	 
	 
	
}
 
 function ModificarIndicador(){
var frm=$("#itm").serialize();
 var funcion=3;
//alert(frm);

 var parametros="frm="+frm+"&funcion="+funcion;
	 
	 $.ajax({
	url:'con_paso2.php',
	data:parametros,
	type:'POST',
	success:function(data){
		console.log(data);
	//alert(data);
		if(data==0){
		alert("Error al Cargar");
		}else{
			alert("Datos Modificados");
			cargaIndicador();
		}
		 }
	 })
}



function eliminaIndicador(x){
	
	txt="esta seguro de eliminar el indicador?";
	resp=confirm (txt);
	if (resp==true){
	var id=$('#iditem_'+x+'').val();
	var funcion=4;
	
	var parametros="item="+id+"&funcion="+funcion;
	
	 $.ajax({
	url:'con_paso2.php',
	data:parametros,
	type:'POST',
	success:function(data){
		console.log(data);
	//alert(data);
		if(data==0){
		alert("Error al Cargar");
		}else{
			alert("Indicador eliminado");
			cargaIndicador();
		}
		 }
	 })
	}
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../../../cabecera/menu_superior.php");?>
					</td></tr></table>
					
					</td>
                  
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><?
						 include("../../../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%" class="textosesion">
                              <tr>
                                <td valign="top">
								<table width="650" border="0">
  <tr >
    <td width="114"><strong>Tipo Entrevista</strong></td>
    <td width="170"><?php 
	switch($row_planilla['tipo_plantilla']){
	case 1:
	$tipo="Apoderado";
	break;
	
	case 2:
	$tipo="Alumno";
	break;
	
	case 3:
	$tipo="Entrevistador";
	break;
	
	default:
	$tipo="";
	break;
	}
	
	echo $tipo ?></td>
  </tr>
  <tr>
    <td><strong>Tipo Ense&ntilde;anza</strong></td>
    <td><?php 
	
	$rs_tipo=$obj_informe->Ensenanza($conn,$row_planilla['tipo_ense']);

echo pg_result($rs_tipo,1);

	  ?></td>
  </tr>
  <tr>
    <td><strong>Grados</strong></td>
    <td><?php echo ($row_planilla['grado1']==1)?"1&ordm; a&ntilde;o<br>":"" ?>
    <?php echo ($row_planilla['grado2']==1)?"2&ordm; a&ntilde;o<br>":"" ?>
<?php echo ($row_planilla['grado3']==1)?"3&ordm; a&ntilde;o<br>":"" ?>
<?php echo ($row_planilla['grado4']==1)?"4&ordm; a&ntilde;o<br>":"" ?>
<?php echo ($row_planilla['grado5']==1)?"5&ordm; a&ntilde;o<br>":"" ?>
<?php echo ($row_planilla['grado6']==1)?"6&ordm; a&ntilde;o<br>":"" ?>
<?php echo ($row_planilla['grado7']==1)?"7&ordm; a&ntilde;o<br>":"" ?>
<?php echo ($row_planilla['grado8']==1)?"8&ordm; a&ntilde;o<br>":"" ?>
<?php echo ($row_planilla['grado9']==1)?"9&ordm; a&ntilde;o<br>":"" ?>
<?php echo ($row_planilla['grado10']==1)?"10&ordm; a&ntilde;o<br>":"" ?>
<?php echo ($row_planilla['grado11']==1)?"11&ordm; a&ntilde;o<br>":"" ?>
<?php echo ($row_planilla['grado12']==1)?"12&ordm; a&ntilde;o<br>":"" ?>
<?php echo ($row_planilla['grado13']==1)?"13&ordm; a&ntilde;o<br>":"" ?>
<?php echo ($row_planilla['grado14']==1)?"14&ordm; a&ntilde;o<br>":"" ?>
<?php echo ($row_planilla['grado15']==1)?"15&ordm; a&ntilde;o<br>":"" ?>
</td>
  </tr>
  <tr>
    <td><strong>T&iacute;tulo</strong></td>
    <td><?php echo $row_planilla['titulo'] ?></td>
  </tr>
  <tr>
    <td><strong>&Aacute;rea</strong></td>
    <td>
    <div id="formulario_clas" title="Nueva &aacute;rea de evaluaci&oacute;n"></div>
    <div id="areas">
    <select name="cmbArea" id="cmbArea" class="requerido" >
    <option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_area);$i++){
				$fila_area = pg_Fetch_array($rs_area,$i);
		?>
        <option value="<?=$fila_area['id_area'];?>"><?=$fila_area['nombre'];?></option>
        <? } ?>
    </select>
    </div>
      <input type="image" name="narea" id="narea" value="Bot&oacute;n" src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Add.png" onclick="IngresoArea()" >
      
      </td>
  </tr>
  <tr>
    <td><strong>Indicador</strong></td>
    <td><textarea name="txt_indicador" cols="20" rows="3" id="txt_indicador" style="margin: 0px; width: 493px; height: 119px;"></textarea></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2"><div id="listaindicador"></div></td>
  </tr>
                                </table>
								<br>
								<input name="nuevoconc" type="button" class="botonXX" id="nuevoconc" onClick="guardarIndicador()" value="Guardar">
								<input name="nuevoconc2" type="button" class="botonXX" id="nuevoconc2" onClick="ModificarIndicador()" value="Modificar">
 <input name="nuevo" type="button" value="Paso Anterior" class="botonXX" onClick="window.location.href = '../paso1/paso1.php?id_plantilla=<?php echo $plantilla ?>&creada=1'">                               
<input name="nuevo" type="button" value="Siguiente Paso" class="botonXX" onClick="window.location.href = '../paso3/paso3.php?plantilla=<?php echo $plantilla ?>'"></td>
                              </tr></table>                         </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
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
</body>
</html>
