<?php 
require('../../../../../util/header.inc');


	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$ramo			=$_RAMO; 
	$frmModo		=$_FRMMODO;
    $empleado		=$_NOMBREUSUARIO;
    $_POSP = 5;
	$_bot           =5;
	$_MDINAMICO     = 1;
	//$curso			= $c_curso;
	 $perfil 		=$_PERFIL;


$sql_curso = "select id_curso from curso where id_ano= $ano order by ensenanza, grado_curso,letra_curso";	
$result_curso = pg_exec($conn,$sql_curso);
 

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">


<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery.ui.datepicker.css">
<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.datepicker.js"></script>





<script>

function limpiarformulario(formulario){
   /* Se encarga de leer todas las etiquetas input del formulario*/
   $(formulario).find('input').each(function() {
      switch(this.type) {
         case 'password':
         case 'text':
         case 'hidden':
              $(this).val('');
              break;
         case 'checkbox':
         case 'radio':
              this.checked = false;
      }
   });
 
   /* Se encarga de leer todas las etiquetas select del formulario */
   $(formulario).find('select').each(function() {
       $("#"+this.id + " option[value=0]").attr("selected",true);
   });
   /* Se encarga de leer todas las etiquetas textarea del formulario */
   $(formulario).find('textarea').each(function(){
      $(this).val('');
   });
}


 
// Seleccionar lista de alumnos Curso
function cargaAlumno(){
	
	var curso =  $('#c_curso').val();
	//alert(curso);
	var anio =  <?php echo $ano ?>;
	var funcion=1;
	var parametros = "curso="+curso+"&anio="+anio+"&funcion="+funcion;
	//alert(parametros);
		
			//invocar carga listado
			$.ajax({
				url:"cont_entrevista.php",
				data:parametros,
				type:'POST',
				success:function(data){
				$('#alcurso').html(data);
		  }
		});  

}




function cargaAlumno2(curso){
	//alert(curso);
	//var curso =  $('#c_curso').val();
	var anio =  <?php echo $ano ?>;
	var funcion=7;
	var parametros = "curso="+curso+"&anio="+anio+"&funcion="+funcion;
	//alert(parametros);
		
			//invocar carga listado
			$.ajax({
				url:"cont_entrevista.php",
				data:parametros,
				type:'POST',
				success:function(data){
				$('#listentrevistado').html(data);
		  }
		});  
		//mostrar listado e pagina
		//$('#lista').css("display","block");
		
	
		
	
	
}


// Seleccionar lista de alumnos Curso
function cargaAlumno3(entrevistado){
	
	var curso =  $('#c_curso').val();
	//alert(curso);
	var anio =  <?php echo $ano ?>;
	var funcion=1;
	var parametros = "curso="+curso+"&anio="+anio+"&funcion="+funcion;
	//alert(parametros);
		
			//invocar carga listado
			$.ajax({
				url:"cont_entrevista.php",
				data:parametros,
				type:'POST',
				success:function(data){
				$('#alcurso').html(data);
				 $('#select_alumno').val( entrevistado );//To select Blue
				 buscaEntrevistas();		
		  }
		});  

}


function buscaEntrevistas(){
	//$('#lista').html("");
	
	var curso =  $('#c_curso').val();
	var ano =  <?php echo $ano ?>;
	var alumno = $('#select_alumno').val();
	var funcion=2;
	
	
		if (alumno !=0 )
		{
			//invocar carga listado
			$.ajax({
				url:"cont_entrevista.php",
				data:"curso="+curso+"&ano="+ano+"&alumno="+alumno+"&funcion="+funcion,
				type:'POST',
				success:function(data){
				$('#lista').html(data);
				$('#dialog-form').html('');
		  }
		})  
		//mostrar listado e pagina
	
		
	}
		
	else
	//borrar todo el listado
	{
		alert("Seleccione curso y alumno para listar resultados")
		$('#lista').html("");
		
	}
	
}

function nuevoA(){
	$('#lista').html("");
	 var funcion=3;
	 var ano =  <?php echo $ano ?>;
		
		$.ajax({
				url:"cont_entrevista.php",
				data:"funcion="+funcion+"&ano="+ano,
				type:'POST',
				success:function(data){
				$('#dialog-form').html(data);
				
		  }
		})  
		
		
 }
 
 
	
	function cancela(){
	
		$('#lista').html("");	
		$('#dialog-form').html("");
		
	}
	
 function cargaentrevistador(){
	 $('#rentrevistador').html("");
var tipo = $('#tipo_entrevista').val();
var funcion=4;
var rdb=<?php echo $institucion ?>;
var curso=$("#cmb_curso2").val();
var ano =  <?php echo $ano ?>;
var parametros = "funcion="+funcion+"&rdb="+rdb+"&curso="+curso+"&tipo="+tipo+"&ano="+ano;

if(curso==0 || tipo==0){
alert("Debe seleccionar curso y tipo entrevistador");
}else{

$.ajax({
				url:"cont_entrevista.php",
				data:parametros,
				type:'POST',
				success:function(data){
				$('#rentrevistador').html(data);
		  }
		}) 
		
}


}



function guardarNuevo(){
var funcion=6;
var curso=$("#cmb_curso2").val();
var ano =  <?php echo $ano ?>;
var entrevistador = $("#entrevistador").val();
var entrevistado = $("#entrevistado").val();
var tipo = $('#tipo_entrevista').val();
var descripcion = $("#desc_entrevista").val();
var observaciones = $("#obs_entrevista").val();
var acuerdos = $("#acuer_entrevista").val();
var fecha = $("#fecha_entrevista").val();

var parametros = "funcion="+funcion+"&curso="+curso+"&ano="+ano+"&entrevistador="+entrevistador+"&entrevistado="+entrevistado+"&tipo="+tipo+"&descripcion="+descripcion+"&observaciones="+observaciones+"&acuerdos="+acuerdos+"&fecha="+fecha;

if(entrevistador==0 || entrevistado==0 ||  tipo==0 || fecha==""  || descripcion=="" || observaciones=="" || acuerdos=="" )
{ alert("Todos los campos son obligatorios"); }
else{

		$.ajax({
				url:"cont_entrevista.php",
				data:parametros,
				type:'POST',
				success:function(data){
					//console.log(data);
				 if(data==1){
					  $('#c_curso').val( curso );//To select Blue
					    cargaAlumno3(entrevistado);
						
						
					 }else{
					alert("Error al guardar"); 
					}
		 		}
		}) 
		
}

}
 
 function elimina(ent){
if(confirm("Seguro de eliminar entrevista?")){
var funcion=8;
var parametros = "funcion="+funcion+"&ide="+ent;	
	
$.ajax({
				url:"cont_entrevista.php",
				data:parametros,
				type:'POST',
				success:function(data){
					console.log(data);
					if(data==1){
						alert("Datos eliminados");
				buscaEntrevistas();	
					}else{
						
						}
		  }
		})  
	
	}	
}
function mode(ide){
var funcion=9;
var parametros = "funcion="+funcion+"&ide="+ide

$.ajax({
		url:"cont_entrevista.php",
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
			
				$('#lista').html(data);
				$('#lista').html(data);
			
	}
	}) 
}

function guardarAct(){
var funcion = 10;
var ide=$("#ide").val();
var fecha=$("#fecha_entrevista").val();
var descripcion = $("#desc_entrevista").val();
var observaciones = $("#obs_entrevista").val();
var acuerdos = $("#acuer_entrevista").val();

var parametros="funcion="+funcion+"&ide="+ide+"&fecha="+fecha+"&descripcion="+descripcion+"&observaciones="+observaciones+"&acuerdos="+acuerdos;

if(descripcion=="" || observaciones=="" || acuerdos=="" || fecha==""){
	alert("Todos los campos son obligatorios");
}else{

$.ajax({
				url:"cont_entrevista.php",
				data:parametros,
				type:'POST',
				success:function(data){
					console.log(data);
				 if(data==1){
					alert("Datos modificados");
						buscaEntrevistas();		
						
					 }else{
					alert("Error al guardar")	; 
					}
		 		}
		}) 
}

}
  </script>



</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="" align="left" valign="top"> 
                        <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="650" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr>
                                  <td height="" valign="top">&nbsp;</td>
                                </tr>
                                <tr> 
                                  <td height="" valign="top">
								  <!--inicio codigo nuevo -->
								  
					
								  
								  
 
	<?php //echo tope("../../../../../util/");?>
	<center>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center" class="tableindex">&nbsp;Listado de Entrevistas a alumno</td>
    </tr>
  <tr>
    <td colspan="2" class="cuadro01" >&nbsp;</td>
    </tr>
  <tr class="cuadro01">
    <td width="12%" class="textosimple">Curso:</td>
    <td width="88%"><select name="c_curso" onChange="cargaAlumno()"  id="c_curso">
      <option value=0 >(Seleccione Curso)</option>
      <?
		  for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_curso,$i); 
		
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option  value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  
          } ?>
      </select></form></td>
  </tr>
  <tr class="cuadro01">
    <td class="textosimple">Alumno:</td>
    <td><div id="alcurso"><select name="select_alumno" id="select_alumno">
      <option value="0">(Seleccione alumno)</option>
    </select></div></td>
  </tr>
    <tr class="cuadro01"><td colspan="2">&nbsp;</td></tr>
    <tr class="cuadro01">
      <td colspan="2" align="right"><input type="submit" name="btn_listar" id="btn_listar" value="Listar Entrevistas" onClick="buscaEntrevistas()" class="botonXX"></td>
    </tr>
    <tr class="cuadro01">
      <td colspan="2" align="right">&nbsp;</td>
    </tr>
    <?php 
	
	
	if($_PERFIL==0 || $_PERFIL==14 || $_PERFIL == 21  || $_PERFIL == 25 || $_PERFIL == 20 || $_PERFIL == 17 || $_PERFIL == 35 || $_PERFIL == 8 || $_PERFIL == 35 || $_PERFIL == 73){  ?>
    <tr class="cuadro01">
      <td colspan="2" align="right"><input type="button" name="btn_agregar" id="btn_agregar" value="Registrar nueva entrevista" class="botonXX" onClick="nuevoA()"></td>
    </tr>
    <?php }?>
  <tr >
    <td colspan="2" >
    
   </td>
    </tr>
                    </table>
    <br>

                    
        <div id="lista" >
    </div>
    <div id="dialog-form"  ></div>
	</center>

	 							  
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr><td>&nbsp;</td></tr>
                           <tr><td>&nbsp;</td></tr>
                          <tr>
                            <td height="" align="left" valign="top">
                            <!--div de formulario de accidente-->


                            
                            </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"> <? include("../../../../../cabecera/menu_inferior.php") ;?> </td>
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





<? pg_close($conn);
pg_close($connection); ?>
</body>
</html>
