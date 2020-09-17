<?php 
require('../../../../../util/header.inc');
include('../../../../clases/class_Reporte.php');
include('../../../../clases/class_Membrete.php');
include('../../../../clases/class_MotorBusqueda.php');


	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	 $curso=$_CURSO;
	$ramo			=$_RAMO; 
	$frmModo		=$_FRMMODO;
	$empleado		=$_EMPLEADO;
    $_POSP = 5;
	$_bot           =5;
	$_MDINAMICO     = 1;
	$curso			= $c_curso;


	$reporte		=$c_reporte;
	
$ob_reporte = new Reporte();
$ob_membrete = new Membrete();
$ob_motor = new MotorBusqueda();
$ob_motor ->ano =$ano;
$result_curso = $ob_motor ->curso($conn);

function CambioFechaDisplay($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}

function CambioFecha($fecha)   //    cambia fecha del tipo  dd/mm/aaaa  ->  aaaa/mm/dd    para poder hacer insert y update
{
	$retorno="";
	if(strlen($fecha) !=10)
		return $retorno;
	$d=substr($fecha,0,2);
	$m=substr($fecha,3,2);
	$a=substr($fecha,6,4);
	if (checkdate($m,$d,$a))
		$retorno=$a."-".$m."-".$d;
	else
		$retorno="";
	return $retorno;
}

/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
			  


 

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">


<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery.ui.datepicker.css">
<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery.ui.all.css">


<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../alumno/nueva_ficha_alumno/valida_rut_simple.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.core.js"></script>


<script language="javascript">
$(document).ready(function() {
	
	
	
$( "#fecha_accidente" ).datepicker({
    'dateFormat':'dd-mm-yy',
	firstDay: 1,
	yearRange: "2000:<?php echo date("Y") ?>",
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ],
    onSelect: function(dateText){
        var seldate = $(this).datepicker('getDate');
        seldate = seldate.toDateString();
        seldate = seldate.split(' ');
        var weekday=new Array();
            weekday['Mon']="1";
            weekday['Tue']="2";
            weekday['Wed']="3";
            weekday['Thu']="4";
            weekday['Fri']="5";
            weekday['Sat']="6";
            weekday['Sun']="7";
        var dayOfWeek = weekday[seldate[0]];
		 $('#diasemana_accidente').val(dayOfWeek);
		 
    }
	
});

//$.datepicker.regional['es']	


});



//Seleccionar lista de alumnos Curso
function selAlumnosCurso(){
	var curso =  $('#cmb_curso2').val();
	var anio =  <?php echo $ano ?>;
	//alert(curso);
		if (curso!=0)
		{
			//invocar carga listado
			$.ajax({
				url:"AlumnosCurso.php",
				data:"curso="+curso+"&anio="+anio,
				type:'POST',
				success:function(data){
				$('#alcurso').html(data);
		  }
		});  
		//mostrar listado e pagina
		$('#lista').css("display","block");
		
	}
		
	else
	//borrar todo el listado
	{
		$('#alcurso').html('');
		
	}
	
}


function selCurso(){
	$('#lista').html("");
	
	var curso =  $('#c_curso').val();
	var anio =  <?php echo $ano ?>;
	//alert(curso);
		if (curso !=0)
		{
			$('#btn_agregar').css("display","block");
			//invocar carga listado
			$.ajax({
				url:"ListaAccidente.php",
				data:"curso="+curso+"&anio="+anio,
				type:'POST',
				success:function(data){
				$('#lista').html(data);
		  }
		})  
		//mostrar listado e pagina
		$('#lista').css("display","block");
		
	}
		
	else
	//borrar todo el listado
	{
		$('#lista').html("");
		
	}
	
}


//validar rut
 function valida_rut(campo)
 {
	 var myString = $(campo).val();
	 var myArray = myString.split('-');
	 var rut = myArray[0];
	 var dig_rut = myArray[1];
	 
	 var validar_rut = Valida_Rut(rut,dig_rut);
	 if(validar_rut==1){
		//alert("rut correcto");
		}else{
		alert("Rut Incorrecto");
		$(campo).val("")
		return false;
	}
 }


</script>
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


 function nuevoA(){
	 
		$('#dialog-form').css("display","block");
		$('#dialog-form2').css("display","none");
		$('#alcurso').html("");
		limpiarformulario("#form_agregar");
		limpiarformulario("#form_editar");
		
		mfo(0);
			
 }
 
 
 //guardar nuevo accidente
 function guardarNuevo(){ 
 
	if($('#cmb_curso2').val()==0)
	{
		alert("Seleccione un curso");
		$( "#cmb_curso2" ).focus();
		return false;
	}
	else if($('#fecha_accidente').val()=="")
	{
		alert("Seleccione una fecha");
		$( "#fecha_accidente" ).focus();
		return false;
	}
	
	else if($('#tipo_accidente').val()==0)
	{
		alert("Seleccione tipo accidente");
		$( "#tipo_accidente" ).focus();
		return false;
		
	}
	
	

	else if($('#obs_accidente').val()=="")
	{
		alert("Describa Accidente");
		$( "#obs_accidente" ).focus();
		return false;
	}
	
	

 else{
	// return true;
		
		$.ajax({
				url:"ProcesaAccidente.php",
				data:"anio="+<?php echo $ano ?>
					 +"&accion=1"
					 +"&curso="+$('#cmb_curso2').val()
					 +"&alumno="+$('#cmb_alumno').val()
					 +"&fecha_accidente="+$('#fecha_accidente').val()
					 +"&hora_accidente="+$('#hora_accidente').val()
					 +"&minuto_accidente="+$('#minuto_accidente').val()
					 +"&diasemana_accidente="+$('#diasemana_accidente').val()
					 +"&tipo_accidente="+$('#tipo_accidente').val()
					 +"&observaciones="+$('#obs_accidente').val()
					 +"&nom_testigo1="+$('#nom_testigo1').val()
					 +"&nom_testigo2="+$('#nom_testigo2').val()
					 +"&rut_testigo1="+$('#rut_testigo1').val()
					 +"&rut_testigo2="+$('#rut_testigo2').val()
					 +"&folio="+$('#foli').val(),
				type:'POST',
				success:function(data){
					console.log(data);
					//$('#lista').html(date);
					//recargo listado accidentes
					$.ajax({
				url:"ListaAccidente.php",
				data:"curso="+$('#cmb_curso2').val()+"&anio="+<?php echo $ano ?>,
				type:'POST',
				success:function(data){
				$('#combo').find("select").val($('#cmb_curso2').val()).attr("selected","selected");
				$('#lista').html(data);
				limpiarformulario("#form_agregar");
				$('#fff').html('');
				
				$('#dialog-form').css("display","none");
		  }
		})  
			
		  }
		}) 
		
		
 }//fin else
		
	}
	
	
	function cancela(){
	
	limpiarformulario("#form_editar");
	$('#dialog-form2').css("display","none");
	
	limpiarformulario("#form_agregar");
	$('#dialog-form').css("display","none");	
	}
	
 


  </script>



</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="javascript:selAlumnosCurso(0)">
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
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
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
								  
								  
							<table width="" height="30" border="0" cellpadding="0" cellspacing="0">
                              <tr> 
                                 <td height="30" align="center" valign="top">								  
                                    <?php if(($_PERFIL!=15)and ($_PERFIL!=16)and ($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=30)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
                                    
	                               <?php } ?>
	                                </td>
                              </tr>
                            </table>
								  
								  
								  
								  
 
	<?php //echo tope("../../../../../util/");?>
	<center>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center" class="tableindex">&nbsp;Listado de accidentes</td>
    </tr>
  <tr>
    <td colspan="2" class="cuadro01" >&nbsp;</td>
    </tr>
  <tr class="cuadro01">
    <td width="12%" class="textosimple" >A&ntilde;o: </td>
    <td width="88%" class="textosimple"><? echo trim($nro_ano) ?></td>
  </tr>
  <tr class="cuadro01">
    <td class="textosimple">Curso:</td>
    <td><form id="combo"><select name="c_curso"  class="ddlb_9_x" id="c_curso" onChange="selCurso();">
        <option value=0 selected>(Seleccione Curso)</option>
        <?
		  for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_curso,$i); 
		  if ($fila["id_curso"]==$c_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
      </select></form></td>
    </tr>
    <tr class="cuadro01"><td colspan="2">&nbsp;</td></tr>
    <tr class="cuadro01">
      <td colspan="2" align="right"><input type="button" name="agregar" id="agregar" value="Registrar Accidente" class="botonXX" onClick="nuevoA()"></td>
    </tr>
  <tr >
    <td colspan="2" >
    
   </td>
    </tr>
                    </table><br>

                    
        <div id="lista" style="display:none" class="print">
    </div>
	</center>
</FORM> 
	 							  
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr><td>&nbsp;</td></tr>
                           <tr><td>&nbsp;</td></tr>
                          <tr>
                            <td height="" align="left" valign="top">
                            <!--div de formulario de accidente-->
<div id="dialog-form" style="display:none" >
<?php include('NuevoAccidente.php')  ?>
</div>
<div id="dialog-form2" style="display:none" >
<?php include('EditaAccidente.php')  ?>
</div>
                            
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
