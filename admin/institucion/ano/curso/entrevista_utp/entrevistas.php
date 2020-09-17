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
	$empleado		=$_NOMBREUSUARIO;
    $_POSP = 5;
	$_bot           =5;
	$_MDINAMICO     = 1;
	$curso			= $c_curso;
	 $perfil 		=$_PERFIL;


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
	
	if($institucion == 770){		

		$sqlInstit="select * from institucion where rdb=".$institucion;
		$resultInstit=@pg_Exec($conn, $sqlInstit);
		$filaInstit=@pg_fetch_array($resultInstit);
		
		$sql_reg="select nom_reg from region where cod_reg =". $filaInstit['region'];
		$res_reg = pg_exec($conn, $sql_reg);
		$fila_reg = pg_fetch_array($res_reg);
		
		$sql_pro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro =".$filaInstit['ciudad'];
		$res_pro=pg_exec($conn, $sql_pro);
		$fila_pro = pg_fetch_array($res_pro);
		
		$sql_com="select nom_com from comuna where cod_reg=". $filaInstit['region'] ." and cor_pro =".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
		$res_com=pg_exec($conn, $sql_com);
		$fila_com = pg_fetch_array($res_com);	 

		$fecha = strftime("%d %m %Y");		
}				  


 

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">


<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery.ui.datepicker.css">
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.datepicker.js"></script>




<script language="javascript">
$(document).ready(function() { 
$( "#fecha_en1,#fecha_entrevista" ).datepicker({
    'dateFormat':'dd-mm-yy',
	firstDay: 1,
	yearRange: "2000:<?php echo date("Y") ?>",
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ]
	
});

//$.datepicker.regional['es']	


});


function cargalista(){
	var curso =  $('#cmb_curso2').val();
	var tipo =0;
	if($("#tipo_ap").is(':checked')) {  
        tipo=2;
    } 
	else if($("#tipo_alu").is(':checked')) {  
             tipo=1; 
    }
	
	if (curso!=0 && tipo != 0)
		{
			$.ajax({
				url:"listacurso.php",
				data:"curso="+curso+"&tipo="+tipo,
				type:'POST',
				success:function(data){
					
				$('#listentrevistado').html(data);
		  }
		});  
		}
	
}




/*armo listado de entrevistas*/
function buscaEntrevistas(){
	$('#lista').html("");
	$('#dialog-form').html("");
	$('#dialog-form2').html("");
	
	
	var curso =  $('#c_curso').val();
	var fecha =  $('#fecha_en1').val();
	
		if (curso >0 && fecha != "")
		{
			
			//invocar carga listado
			$.ajax({
				url:"lista_entrevistas.php",
				data:"curso="+curso+"&fecha="+fecha,
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
		alert("Seleccione curso y fecha para listar resultados")
		$('#lista').html("");
		
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
		//$('#alcurso').html("");
		//limpiarformulario("#form_agregar");
		//limpiarformulario("#form_editar");	
 }
 
 
 //guardar nueva entrevista
 function guardarNuevo(){ 
  var tipo=0;
 
 	if($("#tipo_ap").is(':checked')) {  
        tipo=2;
    } 
	else if($("#tipo_alu").is(':checked')) {  
        tipo=1; 
    }
 
	if($('#cmb_curso2').val()==0)
	{
		alert("Seleccione un curso");
		$( "#cmb_curso2" ).focus();
		return false;
	}
	
	if($('#cmb_entrevistado').val()==0)
	{
		alert("Seleccione un alumno o apoderado");
		$( "#cmb_curso2" ).focus();
		return false;
	}
	
	else if(tipo==0)
	{
		alert("Seleccione tipo entrevistado");
		$( "#tipo_accidente" ).focus();
		return false;
		
	}
	
	else if($('#fecha_entrevista').val()=="")
	{
		alert("Seleccione una fecha");
		$( "#fecha_entrevista" ).focus();
		return false;
	}
	
	

	else if($('#obs_entrevista').val()=="")
	{
		alert("Ingrese observaciones");
		$( "#obs_entrevista" ).focus();
		return false;
	}
	
	

 else{
	// return true;
		
		$.ajax({
				url:"procesaEntrevista.php",
				data:"accion=1"
					 +"&curso="+$('#cmb_curso2').val()
					 +"&cmb_entrevistado="+$('#cmb_entrevistado').val()
					 +"&fecha_entrevista="+$('#fecha_entrevista').val()
					 +"&tipo="+tipo
					 +"&obs_entrevista="+$('#obs_entrevista').val()
					 +"&obs_acuerdos="+$('#obs_acuerdos').val(),
				type:'POST',
				success:function(data){
					console.log(data);
					//$('#lista').html(date);
					//recargo listado entrevistas
					$('#lista').html("");
					$.ajax({
				url:"lista_entrevistas.php",
				data:"curso="+$('#cmb_curso2').val()+"&fecha="+$('#fecha_entrevista').val(),
				type:'POST',
				success:function(data){
					
				$('#combo').find("select").val($('#cmb_curso2').val()).attr("selected","selected");
				$('#fecha_en1').val($('#fecha_entrevista').val())
				
				$('#lista').css('display','block');
				$('#lista').html(data);
				limpiarformulario("#form_agregar");
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
    <td colspan="2" align="center" class="tableindex">&nbsp;Listado de Entrevistas Jefe UTP</td>
    </tr>
  <tr>
    <td colspan="2" class="cuadro01" >&nbsp;</td>
    </tr>
  <tr class="cuadro01">
    <td width="12%" class="textosimple">Curso:</td>
    <td width="88%"><form id="combo"><select name="c_curso"  class="ddlb_9_x" id="c_curso" onChange="buscaEntrevistas()">
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
  <tr class="cuadro01">
    <td class="textosimple">Fecha:</td>
    <td><label for="fecha_en1"></label>
      <input name="fecha_en1" type="text" id="fecha_en1" readonly onChange="buscaEntrevistas()"></td>
  </tr>
    <tr class="cuadro01"><td colspan="2">&nbsp;</td></tr>
    <tr class="cuadro01">
      <td colspan="2" align="right"><!--<input type="submit" name="btn_listar" id="btn_listar" value="Listar Entrevistas" onClick="buscaEntrevistas()" class="botonXX">--></td>
    </tr>
    <tr class="cuadro01">
      <td colspan="2" align="right">&nbsp;</td>
    </tr>
    <?php if($perfil==0 || $perfil==14 || $perfil == 21  || $perfil == 25){  ?>
    <tr class="cuadro01">
      <td colspan="2" align="right"><input type="button" name="btn_agregar" id="btn_agregar" value="Nueva Entrevista" class="botonXX" onClick="nuevoA()"></td>
    </tr>
    <?php }?>
  <tr >
    <td colspan="2" >
    
   </td>
    </tr>
                    </table>
    <br>

                    
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
<?php include('nuevo_entrevista.php')  ?>
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
