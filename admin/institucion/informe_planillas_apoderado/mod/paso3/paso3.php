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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css"> <script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script language="JavaScript" type="text/JavaScript">

$(document).ready(function() {
	 cargaConcepto();
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
function eliminar(nombre,id){
	txt="esta seguro de eliminar el concepto   "+nombre;
	resp=confirm (txt);
	if (resp==true){
		/*url="conceptos.php?eliminar="+id;
		window.location=url;*/
		var parametros = "id_concepto="+id+"&funcion=4"
		$.ajax({
				url:"con_crear.php",
				data:parametros,
				type:'POST',
				success:function(data){
				//$('#alcurso').html(data);
				console.log(data);
				if(data==1){
					location.reload();
					//alert(data);
				}
		  }
		});  
	}else{
	
	}
}





		


function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
 
 

 
function guardarConcepto(){
var plantilla = <?php echo $plantilla ?>;
var funcion=1;
var nombre=$("#txt_concepto").val();
var sigla = $("#txt_sigla").val();
var glosa = $("#txt_glosa").val();

var parametros="plantilla="+plantilla+"&funcion="+funcion+"&nombre="+nombre+"&sigla="+sigla+"&glosa="+glosa;

if(nombre.length >0 && sigla.length >0  &&  glosa.length >0){
$.ajax({
	url:'con_paso3.php',
	data:parametros,
	type:'POST',
	success:function(data){
		//console.log(data);
	//alert(data);
		if(data==0){
		alert("Error al Cargar");
		}else{
			//alert("Error al Cargar");$('#areas').html(data);
			alert("Datos Guardados");
			cargaConcepto();
			}
		 }
	 })
}else{
alert("Ingrese campos requeridos");
}

}
 
function cargaConcepto(){
	 var plantilla = <?php echo $plantilla ?>;
	 var funcion=2;
	 var parametros="plantilla="+plantilla+"&funcion="+funcion;
	 
	 $.ajax({
	url:'con_paso3.php',
	data:parametros,
	type:'POST',
	success:function(data){
		//console.log(data);
	//alert(data);
		if(data==0){
		alert("Error al Cargar");
		}else{
			//alert("Error al Cargar");
			$('#listaconcepto').html(data);
			
			
			}
		 }
	 })
	 
	 
	
}
 
 function modificaConcepto(x){

$('#div_'+x+'').html('<input type="button" value="Guardar" onclick="GuardaModif('+x+')">');
$('#div2_'+x+'').html('<input type="button" value="Cancelar" onclick="AnulaModif('+x+')">');


$('#nombre_'+x+'').css("display","none");
$('#sigla_'+x+'').css("display","none");
$('#glosa_'+x+'').css("display","none");



document.getElementById('txt_nombre'+x+'').setAttribute("type","text");
document.getElementById('txt_sigla'+x+'').setAttribute("type","text");
document.getElementById('txt_glosa'+x+'').setAttribute("type","text");

}



function GuardaModif(x){
var nombre = $('#txt_nombre'+x+'').val();
var sigla = $('#txt_sigla'+x+'').val();
var glosa = $('#txt_glosa'+x+'').val();
var funcion=3;
var parametros ="funcion="+funcion+"&nombre="+nombre+"&sigla="+sigla+"&glosa="+glosa+"&id_concepto="+x;

/*alert("sdfsd");
AnulaModif(x);*/
$.ajax({
				url:"con_paso3.php",
				data:parametros,
				type:'POST',
				success:function(data){
				
				console.log(data);
				if(data==0){
				alert("Error al Cargar");
				}else{
					
					alert("Indicador modificado");
				//location.reload();
				cargaConcepto();
				}
				
		  }
		});
}


function AnulaModif(x){
	document.getElementById('txt_nombre'+x+'').setAttribute("type","hidden");
document.getElementById('txt_sigla'+x+'').setAttribute("type","hidden");	
document.getElementById('txt_glosa'+x+'').setAttribute("type","hidden");	


$('#nombre_'+x+'').css("display","block");
$('#sigla_'+x+'').css("display","block");
$('#glosa_'+x+'').css("display","block");

$('#div_'+x+'').html('<input type="button" value="Modificar" onclick="modificaConcepto('+x+')">');
$('#div2_'+x+'').html('<input type="button" value="Eliminar" onclick="EliminaConcepto('+x+')">');
}

function eliminaIndicador(x){
	
		txt="esta seguro de eliminar este  indicador  ";
	resp=confirm (txt);
	if (resp==true){
	var parametros = "id_concepto="+x+"&funcion=4";
	$.ajax({
				url:"con_paso3.php",
				data:parametros,
				type:'POST',
				success:function(data){
				//$('#alcurso').html(data);
				//console.log(data);
				if(data==0){
				alert("Error al Cargar");
				}else{
					
					alert("Indicador eliminado");
				//location.reload();
				cargaConcepto();
				}
				
		  }
		});
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
                            <td height="395" align="left" valign="top"><table width="100%" height="100%">
                              <tr>
                                <td valign="top">
								<table width="300" border="0" class="textosesion">
  <tr>
    <td width="114">Tipo Entrevista</td>
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
    <td>Tipo Ense&ntilde;anza</td>
    <td><?php 
	
	$rs_tipo=$obj_informe->Ensenanza($conn,$row_planilla['tipo_ense']);

echo pg_result($rs_tipo,1);

	  ?></td>
  </tr>
  <tr>
    <td>Grados</td>
    <td><?php echo ($row_planilla['grado1']==1)?"1° año<br>":"" ?>
    <?php echo ($row_planilla['grado2']==1)?"2° año<br>":"" ?>
<?php echo ($row_planilla['grado3']==1)?"3° año<br>":"" ?>
<?php echo ($row_planilla['grado4']==1)?"4° año<br>":"" ?>
<?php echo ($row_planilla['grado5']==1)?"5° año<br>":"" ?>
<?php echo ($row_planilla['grado6']==1)?"6° año<br>":"" ?>
<?php echo ($row_planilla['grado7']==1)?"7° año<br>":"" ?>
<?php echo ($row_planilla['grado8']==1)?"8° año<br>":"" ?>
<?php echo ($row_planilla['grado9']==1)?"9° año<br>":"" ?>
<?php echo ($row_planilla['grado10']==1)?"10° año<br>":"" ?>
<?php echo ($row_planilla['grado11']==1)?"11° año<br>":"" ?>
<?php echo ($row_planilla['grado12']==1)?"12° año<br>":"" ?>
<?php echo ($row_planilla['grado13']==1)?"13° año<br>":"" ?>
<?php echo ($row_planilla['grado14']==1)?"14° año<br>":"" ?>
<?php echo ($row_planilla['grado15']==1)?"15° año<br>":"" ?>
</td>
  </tr>
  <tr>
    <td>T&iacute;tulo</td>
    <td><?php echo $row_planilla['titulo'] ?></td>
  </tr>
  <tr>
    <td>Nombre concepto</td>
    <td><input name="txt_concepto" type="text" id="txt_concepto" value="" size="20"></td>
  </tr>
  <tr>
    <td>Sigla</td>
    <td><input name="txt_sigla" type="text" id="txt_sigla" value="" size="20"></td>
  </tr>
  <tr>
    <td>Glosa</td>
    <td><input name="txt_glosa" type="text" id="txt_glosa" value="" size="50"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2"><div id="listaconcepto"></div></td>
  </tr>
                                </table>
								<br>
								<input name="nuevoconc" type="button" class="botonXX" id="nuevoconc" onClick="guardarConcepto()" value="Guardar">
								<input name="nuevo2" type="button" value="Paso Anterior" class="botonXX" onClick="window.location.href = '../paso2/paso2.php?plantilla=<?php echo $plantilla ?>&creada=1'">
<input name="nuevo" type="button" value="Siguiente Paso" class="botonXX" onClick="window.location.href = '../paso4/paso4.php?plantilla=<?php echo $plantilla ?>'"></td>
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
