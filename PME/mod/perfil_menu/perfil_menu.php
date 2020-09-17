<? session_start(); 
	if(isset($_ANO_)){
	$ano=$_ANO_;
	}else{
	$ano=$_ANO;
	}
require "../../class/Membrete.class.php";	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Perfil v/s Menu</title>

<script>
$(document).ready(function() {
	
   $( "input:submit,input:button", "#cuerpo_PerfilMenu" ).button();
   
   cargaSelectPerfil();
});

function enviar(){
  
	$('#frm').submit();
	var id_perfil=$('#cmbPERFIL').val();
	alert("Proceso Realizado")
	cargatabla_perfilMenu(id_perfil);
	$("#principal").load("mod/index.php");

 } 


	function cargaSelectPerfil(){
  
       var fun="sperfil";
	       var parametros = "funcion="+fun;
		   var selec = "selectperfil";
		  // alert(parametros);
		$.ajax({
		  url:'mod/perfil_menu/cont_perfil_menu.php',
		  
		  data:parametros,
		  type:'POST',
			success:function(data){
			//alert(data);
                if(data==0){
				  alert("No se Encontraron Datos");
				 // $('#cmb_funcion').html(0);
				  // $("#cmb_funcion option[value=0]").attr("selected",true); 
				}else{
				$('#'+selec+'').html(data);
				$("input:submit,input:button", "#cuerpo_PerfilMenu" ).button();
				//cargatabla2();
				  }
		      }
		 })
	}
	
		function cargatabla_perfilMenu(id_perfil){
		
			//alert(id_perfil);
			var  parametros	= "funcion=1&cmbPERFIL="+id_perfil;
			//alert(parametros);
			$.ajax({
			url:'mod/perfil_menu/cont_perfil_menu.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("Error al Cargar");
			}else{
			$('#tabla_perfil_menu').html(data);
			
			
			$("input:submit,input:button", "#cuerpo_PerfilMenu" ).button();
			$("#principal").load("mod/index.php");
		   }
		 }
	  })
   } // fin funcion cargartabla
   
 
		
function ChequearTodos(chkbox)
{
	
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var elemento = document.forms[0].elements[i];
		if (elemento.type == "checkbox")
		{
			elemento.checked = chkbox.checked
		}
	}
}
		
</script>


<style type="text/css">
.color_fondo{ background-image:url(jquery-ui-1.8.17.custom/css/redmond/images/ui-bg_gloss-wave_55_5c9ccc_500x100.png); }
#cuerpo_PerfilMenu{ margin:25px; }
#crea_menu{ margin-top:15px; margin-bottom:15px; }

</style>

</head>
<body>
<div id="cuerpo_PerfilMenu" align="left">	
  <div id="tabs-1">
        <h3>CONFIGURACI&Oacute;N PERFIL MEN&Uacute;</h3>
        </div>
        <br>
        <form  id="frm" name="frm" method="post" action="mod/perfil_menu/procesoMenuPerfil.php" target="iframeUpload">
	<div id="selectperfil"></div>
      <br>
   <div id="glosario" align="left">
   <table >
   <tr>
        <td width="15%" class="textosimple">GLOSARIO</td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td width="0%" class="textosimple"><div >&nbsp;I: Ingreso</div> </td>
        <td width="0%" class="textosimple"><div >&nbsp;M: Modificar</div> </td>
        <td width="0%" class="textosimple"><div >&nbsp;E: Eliminar</div>  </td>
        <td width="0%" class="textosimple"><div >&nbsp;V: Ver</div> </td>
        <td width="0%" class="textosimple"><div ></div></td>
  </tr>
   </table>
   
    <label>Todos:  &nbsp;
        <input type="checkbox" name="checkbox11"  id="checkbox11" value="checkbox" onClick="ChequearTodos(this);">
        </label>
   </div>
   
   <div id="tabla_perfil_menu"></div>
   <div id="status"></div>
   <iframe name="iframeUpload" id="iframeUpload" width="100%" height="50%" align="bottom"  marginwidth="10%" scrolling="no" class="autoHeight" frameborder="0" >
</iframe>
   </form>
</div>
</body>
</html>
