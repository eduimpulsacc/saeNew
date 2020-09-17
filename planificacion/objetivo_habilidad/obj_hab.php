<?php 
require("../../util/header.php");
session_start();
$_POSP=2;
//var_dump($_SESSION);<a href="../../util/header.php">header.php</a>
//echo $_ID_BASE;
?>
<!doctype html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<!--<link href="../../cortes/<?=$_INSTIT;?>/estilos.css" rel="stylesheet" type="text/css"> -->
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//listado();
	tpob();
  });


/*function Inicio(){
	 $("#tabs").tabs();
	var parametros="funcion=3";
	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  
		  }
	  })		
}*/
function tpob(){
var parametros = "funcion=15";
	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
	    $("#tpob").html(data);
		  }
	  })	
}

function listado(){
	var tipo = $("#cmbTIPO").val();
	var eje = $("#cmbEJE").val();
	var grado 	= $("#cmbGRADO").val();
	var ense 	= $("#cmbENSE").val();	
	var parametros = "funcion=1&tipo="+tipo+"&eje="+eje+"&grado="+grado+"&ense="+ense;
	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#listado").html(data);
		  }
	  })		
}

function agregar(){
	var parametros="funcion=2";
	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tabla").html(data);
		  }
	  })	
}

function guardar(){
	var codigo 	= $("#txtCODIGO").val();
	var opcion 	= $("#obj_hab").val();
	var texto  	= $("#arTEXTO").val();
	var eje 	= $("#cmbEJE").val();
	var grado 	= $("#cmbGRADO").val();
	var ense 	= $("#cmbENSE").val();
	var bbd= <?php echo $_ID_BASE ?>;
	var parametros ="funcion=3&codigo="+codigo+"&tipo="+opcion+"&eje="+eje+"&texto="+texto+"&grado="+grado+"&ense="+ense+"&bbd="+bbd;
	//alert(parametros);
	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		  if(data==1){
			  if(!confirm("DATOS ALMACENADOS, DESEA INGRESAR MAS INFORMACION")){
				 Limpiar();
			  }else{
				   Limpiar();
				//alert("llego");  
			  }
		  }else{
			alert("ERROR AL GUARDAR"); 
		  }
	   
		  }
	  })	
}
function Limpiar(){
	$("#txtCODIGO").val('');
	$("#arTEXTO").val('');	
	$("#cmbEJE").val(0);
	$("#subs").val('');
}
function agregar_obj(){
var tipo = $("#obj_hab").val();

var parametros ="funcion=6&tipo="+tipo;
//alert(parametros);
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		 $("#titeje").html(data);
		 $("#titeje").dialog({ 
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
		
		   ingresarEje();
		  
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	},open: function() {
          	//$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('disable');
			
      }      
  }) 
		  
	   
		  }
	  })

	
}

function existeCodigo(){
var cadena = $("#txtCODIGO").val();
var parametros = "funcion=5&cadena="+cadena;

if(cadena.length>0 && cadena.trim()!=""){
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
	   if(data==1){
		   alert("CODIGO YA EXISTE");
		   }
		  }
	  })	 
}
}

function activaBotonEje(){
var lopc = $("#obj_hab").val();
var cods = $('#codsubsector').val();
var ltxt = $('#nomeje').val();

if(lopc>0 && (ltxt.length>0 && ltxt.trim()!="") && ( cods!=0 && cods.trim()!="")){
			//$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('enable');
		}
		else{
			//$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('disable');
		}
}

function ingresarEje(){
var funcion=7;
var nombre = $("#nomeje").val();
var tipo=$("#obj_hab").val();
var rbd =  $("#rbd").val();
var codramo = $("#codsubsector").val();
var bbd= <?php echo $_ID_BASE ?>;
var parametros = "funcion="+funcion+"&nombre="+nombre+"&tipo="+tipo+"&rbd="+rbd+"&codramo="+codramo+"&bbd="+bbd;


$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 console.log(data); 
	   if(data==0){
		   alert("Error al guardar");
		   }else{
			 alert("Datos guardados");
			 
			 $("#subs").val(codramo);
			 $("#obj_hab"+tipo).prop("checked", true);
			 ejes(tipo,codramo);
			}
		  }
	  })
}

function ejes(tipo){
if(!tipo){tipo=$("#obj_hab").val();}

var subsector= $("#subs").val();
var funcion=8;
var parametros = "funcion="+funcion+"&tipo="+tipo+"&subsector="+subsector;
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	   if(data==0){
		   alert("Error al cargar");
		   }else{
			$("#combeje").html(data);
			}
		  }
	  })
}

function gradoense(){
var funcion=9;
var tipoense=$("#tipense").val();
var parametros = "funcion="+funcion+"&tipoense="+tipoense;
//alert(parametros);
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==0){
		   alert("Error al cargar");
		   }else{
			$("#gra").html(data);
			}
		  }
	  })

}

function veramo(){
var cadena=""
cadena = $("#subs").val();


var parametros = "funcion=10&cadena="+cadena;

if(cadena.length>0 && cadena.trim()!=""){
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	   if(data==0){
		   alert("SUBSECTOR NO EXISTE");
		   }
		  }
	  })	 
}
}

function veramo2(){

var cadena = $("#codsubsector").val();

var parametros = "funcion=10&cadena="+cadena;

if(cadena.length>0 && cadena.trim()!=""){
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	   if(data==0){
		   alert("SUBSECTOR NO EXISTE");
		   }
		  }
	  })	 
}
}

function BuscaEje(){
	var tipo = $("#cmbTIPO").val();
	var ramo = $("#cmbASIGNATURA").val();
	var parametros = "funcion=11&cod_subsector="+ramo+"&tipo="+tipo;
	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#eje").html(data);
		  }
	  })		
}

function Buscar(){
	var tipo = $("#cmbTIPO").val();
	var eje = $("#cmbEJE").val();	
	var parametros = "funcion=12&tipo="+tipo+"&eje="+eje;
	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#eje").html(data);
		  }
	  })	
}

function gradoEnse(){
var funcion=13;
var ense = $("#cmbENSE").val();
var ano = <?php echo $_ANO ?>;
var parametros = "funcion=13&ense="+ense+"&ano="+ano;

	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#gra").html(data);
		  }
	  })	

}


function ramoGrado(){
var funcion=14;
var ense = $("#cmbENSE").val();
var ano = <?php echo $_ANO ?>;
var grado = $("#cmbGRADO").val();
var parametros = "funcion="+funcion+"&ense="+ense+"&ano="+ano+"&grado="+grado;
	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#ram").html(data);
		  }
	  })	

}

function DelOb(obj){
	var funcion=16;

if(confirm("Confirma eliminar objetivo de aprendizaje?")){

var parametros = "funcion="+funcion+"&obj="+obj;
	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// $("#ram").html(data);
		console.log(data);
		if(data==1){
			alert("eliminado");
			listado();
			}
		  }
	  })	
}
}


function EdOb(obj){
	
var parametros ="funcion=17&obj="+obj;
//alert(parametros);
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		 $("#edo").html(data);
		 $("#edo").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 600,
   Height: 300,
   minWidth: 600,
   minHeight: 300,
   maxWidth: 600,
   maxHeight: 300,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
	 "Guardar Datos": function(){
		
		   upObj();
		  
		  
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	},open: function() {
          	//$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('disable');
			
      }      
  }) 
		  
	   
		  }
	  })

	

}

function upObj(){
var funcion=18;
var obj = $("#iobj").val();
var cod = $("#txtCODIGO").val();
var txt = $("#arTEXTO").val();

var parametros = "funcion="+funcion+"&obj="+obj+"&txt="+txt+"&cod="+cod;
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// $("#ram").html(data);
		//console.log(data);
		if(data==1){
			alert("Datos modificados");
			$("#edo").dialog("close");
			listado();
			}
		else if(data==2){
			alert("Código existe");
			//listado();
			}
		else if(data==0){
		alert("Error al modificar");
		//listado();
		}
		  }
	  })
	}

</script>
<title>SAE: SISTEMA PLANIFICACION</title>
</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0">

<table width="1280" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="3" valign="top" background="../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="50"  height="900"></td>
    <td colspan="2" align="left" valign="top" height="70"><? include("../../cabecera_new/head.php");?></td>
    <td rowspan="3" background="../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../../menu_new/index.php");?></td>
    <td valign="top" align="center">
    	<br />
		<br />
        <table width="870" border="0" class="cajaborde">
          <tr>
            <td><br>
  			<div align="center" id="tabla">
            <table width="650" border="0" align="center">
              <tr>
                <td colspan="3" class="tableindexredondo">LISTADO DE OBJETIVO Y/O HABILIDADES</td>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td class="textonegrita">TIPO</td>
                <td class="textonegrita">:</td>
                <td>
                              <div id="tpob"></div>
                </td>
              </tr>
              <tr>
                <td class="textonegrita">TIPO ENSENANZA</td>
                <td class="textonegrita">:</td>
                <td><select name="cmbENSE" id="cmbENSE" class="select_redondo" style="width:250px" onChange="gradoEnse()">
                <option value="0">seleccione...</option>
                <?php if($_PERFIL==0){
				$sql_ense = "select * from tipo_ensenanza order by cod_tipo";
				}else{
					 $sql_ense = "select distinct(cod_tipo),nombre_tipo from tipo_ensenanza
						inner join curso on curso.ensenanza = tipo_ensenanza.cod_tipo
						where id_ano=".$_ANO."
						order by cod_tipo";
				}
				$rs_ense = pg_exec($conn,$sql_ense);
					for($e=0;$e<pg_numrows($rs_ense);$e++){
						$fila_ense = pg_fetch_array($rs_ense,$e);
				
				?>
                
                  <option value="<?php echo $fila_ense['cod_tipo'] ?>">(<?php echo $fila_ense['cod_tipo'] ?>) <?php echo $fila_ense['nombre_tipo'] ?></option>
                  <?php }?>
                  </select></td>
              </tr>
              <tr>
                <td class="textonegrita">GRADO CURSO</td>
                <td class="textonegrita">:</td>
                <td><div id="gra">
                  <select name="cmbGRADO" id="cmbGRADO" class="select_redondo" >
                    <option value="0">seleccione...</option>
                    
                  </select>
                </div></td>
              </tr>
              <tr>
                <td width="132" class="textonegrita">ASIGNATURA</td>
                <td width="8" class="textonegrita">:</td>
                <td width="496">
                <div id="ram">
					<select id="cmbASIGNATURA" name="cmbASIGNATURA" class="select_redondo">
                	<option value="0">seleccione...</option>
                </select>
                    </div>
                </td>
              </tr>
              <tr>
                <td class="textonegrita">EJES</td>
                <td class="textonegrita">:</td>
                <td>
                <div id="eje">
                <select name="cmbEJE" id="cmbEJE" class="select_redondo">
                	<option value="0">seleccione...</option>
                 </select>
                 </div>
                </td>
              </tr>
              <tr>
                <td colspan="3" align="right"><input name="cmbAGREGAR" type="button" class="botonXX" value="AGREGAR" onclick="agregar()">
                </td>
              </tr>
            </table><br>
<br>
				<div id="listado">
                <table width="650" border="0" align="center">
                  <tr>
                    <td class="tableindexredondo" width="100">CODIGO</td>
                    <td class="tableindexredondo">OBJETIVO HABILIDAD</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
				</div>

            </td>
          </tr>
        </table>
      &nbsp;
		<div id="titeje" align="center">&nbsp;</div>
        <div id="edo" align="center">&nbsp;</div>
    </td>
  </tr>
  <tr>
    <td colspan="2"><? include("../../cabecera_new/footer.html");?></td>
  </tr>
</table>
</body>
</html>
