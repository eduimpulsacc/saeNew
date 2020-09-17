<?

require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
require('../../../../../util/funciones_new.php'); 
$situacion = $_REQUEST[situacion];
$institucion	=$_INSTIT;
$ano = $_REQUEST[ano];
$curso	=$_REQUEST[curso];
$rutusuario = $_REQUEST[rutusuario];
$usuario = $_USUARIO;
$docente =5; //Codigo Docente
$_ANO = $ano;
session_register('_ANO');

	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result){
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													$nroAno=$fila1['nro_ano'];
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														//exit();
													}
													trim($nroAno);
													$situacion = $fila1['situacion']; 
												}
											}
											
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
			$_ITEM =$item;
			session_register('_ITEM');
		}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
		
	}
										



?>
<!--<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>-->



<script src="../../../../clases/flexigrid-1.1/js/flexigrid.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../../../../clases/flexigrid-1.1/css/flexigrid.css">

<script type="text/javascript" language="javascript">
$(document).ready(function(){ // Script para cargar al inicio del modulo
cargartabla();
});



	$(function() {
		$( "#tabs" ).tabs();
	});
	
	
	$(document).ready(function(){			
	$("#txtFECHA").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'dd/mm/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	})	
		
		
	$(document).ready(function(){			
	$("#txtFECHA2").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'dd/mm/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	})		
	
	
	$(document).ready(function(){			
	$("#txtFECHA3").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'dd/mm/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	})	
	
	
	$(document).ready(function(){			
	$("#txtFECHA4").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'dd/mm/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	})	
		 
	$(document).ready(function(){			
	$("#txtFECHA5").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'dd/mm/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	})		 
	
	$(document).ready(function(){			
	$("#txtFECHA6").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'dd/mm/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	})		
	
	$(document).ready(function(){			
	$("#txtFECHA7").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'dd/mm/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	}) 
	
	$(document).ready(function(){			
	$("#txtFECHA8").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'dd/mm/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	}) 
	
	$(document).ready(function(){			
	$("#txtFECHA9").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'dd/mm/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	}) 
	$(document).ready(function(){			
	$("#txtFECHA10").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'dd/mm/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	}) 
 
/*function validarfecha(){

//TEXT FECHAS 
		
	if ( $("#txtFECHA").val() != 0 ){ 
	var fechaingresada = $("#txtFECHA").val(); 
	var obsfocus =  1; }

// SELECT PERIODOS
    if ($('#cmb_periodos2').val() != 0 ){ var idper = $('#cmb_periodos2').val();}
		
	if ($('#cmb_periodos3').val() != 0 ){ var idper = $('#cmb_periodos3').val();}
		
	if ($('#cmb_periodos').val() != 0  )	{ var idper = $('#cmb_periodos').val();}

   	var parametros ="idperiodo="+idper+"&fechaingresada="+fechaingresada;
	//alert(parametros);
		
 }	
	


 function compare_dates(fecha,fecha2) // 08/12/2010 
   {  
     var xMonth=fecha.substring(3,5);  
     var xDay=fecha.substring(0,2);  
     var xYear=fecha.substring(6,10);  
	 
     var yMonth=fecha2.substring(3,5);  
     var yDay=fecha2.substring(0,2);  
     var yYear=fecha2.substring(6,10);  
     alert(yMonth);
	 if (xYear > yYear)  
     {  return(true) }  
     else  
     {  
       if (xYear == yYear)  
       {   
         if (xMonth > yMonth)  
         { return(true) }  
         else  
         {   
           
		   if (xMonth == yMonth)  
           {  
             if (xDay > yDay)  
               return(true);  
             else  
               return(false);  
           }  
           else  
             return(false);  
         }  
       }  
       else  
         return(false);  
     }  
 }  */


  function reseteo(){
   $('#Formulariolista')[0].reset();
	$('#bottoncontrol').html('<br><input name="creardoc" type="button" onClick="cargardatos(0)" value="Crear" class="botonXX"/>');
      }
   function reseteo4(){
   $('#Formulariolista')[0].reset();
    $('#bottoncontro4').html('<br><input name="crearApo" type="button" onClick="cargardatos4(0)" value="Crear" class="botonXX"/>');
		cargartablaDae();
      }	  
	  
	  
	

	function reseteo5(){
   $('#Formulariolista')[0].reset();
   $('#bottoncontro5').html('<br><input name="crearApo" type="button" onClick="cargardatos5(0)" value="Crear" class="botonXX"/>');
		cargaselectApo();
		cargartablaApo();
		
      }	    
	  
	  function reseteo6(){
   $('#Formulariolista')[0].reset();
    $('#bottoncontro6').html('<br><input name="crearApo" type="button" onClick="cargardatos6(0)" value="Crear" class="botonXX"/>');
		cargartablaAlum();
      }	   
	  
	  function reseteo7(){
   $('#Formulariolista')[0].reset();
    $('#bottoncontro7').html('<br><input name="crearApo" type="button" onClick="cargardatos7(0)" value="Crear" class="botonXX"/>');
		cargartablaDerInt();
      }	   
	  
	    function reseteo8(){
   $('#Formulariolista')[0].reset();
    $('#bottoncontro8').html('<br><input name="crearApo" type="button" onClick="cargardatos8(0)" value="Crear" class="botonXX"/>');
		cargartablaDerExt();
      }	   
	  
	    function reseteo9(){
   $('#Formulariolista')[0].reset();
    $('#bottoncontro9').html('<br><input name="crearAcTom" type="button" onClick="cargardatos9(0)" value="Crear" class="botonXX"/>');
		cargartablaAcTom();
      }	   
	  
	      function reseteo2(){
   $('#Formulariolista')[0].reset();
    $('#bottoncontro2').html('<br><input name="crearAcTom" type="button" onClick="cargardatos2(0)" value="Crear" class="botonXX"/>');
		cargartablaDestaca();
      }	   
	  
	    function reseteo3(){
   $('#Formulariolista')[0].reset();
   	
      }	   


	function validadestaca(){
		
		var combodes1 = $('#cmbdestaca1').val();
		var combodes2 = $('#cmbdestaca2').val();
		var combodes3 = $('#cmbdestaca3').val();
		var combodes4 = $('#cmbdestaca4').val();
		
		
		if(combodes1!=0){
		if(combodes1==combodes2){
			 alert("Escoja Un Concepto diferente!!");
			 var largocombodestaca2= document.Formulariolista.cmbdestaca2.options.length;
						for(i=0;i<largocombodestaca2;i++){
							if(document.Formulariolista.cmbdestaca2.options[i].value == combodes1){
								document.Formulariolista.cmbdestaca2.selectedIndex = 0;
	               }
			    }  
			}
		}
		
		if(combodes1!=0){
		if(combodes1==combodes3){
			alert("Escoja Un Concepto diferente!!");
			 var largocombodestaca3= document.Formulariolista.cmbdestaca3.options.length;
						for(i=0;i<largocombodestaca3;i++){
							if(document.Formulariolista.cmbdestaca3.options[i].value == combodes1){
								document.Formulariolista.cmbdestaca3.selectedIndex = 0;
	               }
			    }  
			}	
		}
		
		if(combodes1!=0){
		if(combodes1==combodes4){
			alert("Escoja Un Concepto diferente!!");
			 var largocombodestaca4= document.Formulariolista.cmbdestaca4.options.length;
						for(i=0;i<largocombodestaca4;i++){
							if(document.Formulariolista.cmbdestaca4.options[i].value == combodes1){
								document.Formulariolista.cmbdestaca4.selectedIndex = 0;
	               }
			    }  
			}		
		}
		
		if(combodes2!=0){
		if(combodes2==combodes3){
			
			alert("Escoja Un Concepto diferente!!");
			 var largocombodestaca3= document.Formulariolista.cmbdestaca3.options.length;
						for(i=0;i<largocombodestaca3;i++){
							if(document.Formulariolista.cmbdestaca3.options[i].value == combodes2){
								document.Formulariolista.cmbdestaca3.selectedIndex = 0;
	               }
			    }  
			}
		}
		
		if(combodes2!=0){
		if(combodes2==combodes4){
			alert("Escoja Un Concepto diferente!!");
			 var largocombodestaca4= document.Formulariolista.cmbdestaca4.options.length;
						for(i=0;i<largocombodestaca4;i++){
							if(document.Formulariolista.cmbdestaca4.options[i].value == combodes2){
								document.Formulariolista.cmbdestaca4.selectedIndex = 0;
	               }
			    }  
			}	
		}
		
		if(combodes3!=0){
		if(combodes3==combodes4){
			alert("Escoja Un Concepto diferente!!");
			 var largocombodestaca4= document.Formulariolista.cmbdestaca4.options.length;
						for(i=0;i<largocombodestaca4;i++){
							if(document.Formulariolista.cmbdestaca4.options[i].value == combodes3){
								document.Formulariolista.cmbdestaca4.selectedIndex = 0;
	               }
			    }  
			}		
		}	
		
		}	
		
		
		function buscarperiodos(){ 
		
		
	if ($('#cmb_periodos').val() != 0 )
		{
		  var idper = $('#cmb_periodos').val();
		  var x = 1;
		   }
		
	if ($('#cmb_periodos2').val() != 0 )
		{
		  var idper = $('#cmb_periodos2').val();
		  var x = 2;
			}
		
	if ($('#cmb_periodos_Ren').val() != 0  )
		{
		  var idper = $('#cmb_periodos_Ren').val();
		  var x = 3;
		  }
		  
	if ($('#cmb_periodos4').val() != 0  )
		{
		  var idper = $('#cmb_periodos4').val();
		  var x = 4;
		  }	  
		  
	if ($('#cmb_periodos5').val() != 0  )
		{
		  var idper = $('#cmb_periodos5').val();
		  var x = 5;
		  }	  	
		  
	if ($('#cmb_periodos6').val() != 0  )
		{
		  var idper = $('#cmb_periodos6').val();
		  var x = 6;
		  }	  	    
		  
	if ($('#cmb_periodos7').val() != 0  )
		{
		  var idper = $('#cmb_periodos7').val();
		  var x = 7;
		  }	  	  
		  
	if ($('#cmb_periodos8').val() != 0  )
		{
		  var idper = $('#cmb_periodos8').val();
		  var x = 8;
		  }	  	  
		  
	if ($('#cmb_periodos9').val() != 0  )
		{
		  var idper = $('#cmb_periodos9').val();
		  var x = 9;
		  }	  	  
		
	var parametros ="idperiodo="+idper;
		
		//alert(parametros);
		
			$.ajax({
							
			  url:'buscafechaperiodo.php',
			  data:parametros,
			  type:'POST',
			  
			  success:function(data){
			        $("#fechasdeperiodo"+x+"").html(data);
				    } 
					
	 }) 
		
  }		  
  
  function validarfecha(){

//TEXT FECHAS 
	if ( $("#txtFECHA").val() != 0 ){ 
	var fechaingresada = $("#txtFECHA").val(); 
	var obsfocus = 1; }
	
	if ( $("#txtFECHA2").val() != 0 ){ 
	var fechaingresada = $("#txtFECHA2").val(); 
	var obsfocus = 2; }
	
	if ( $("#txtFECHA10").val() != 0 ){ 
	var fechaingresada = $("#txtFECHA10").val(); 
	var obsfocus =  3; }
	
	if ( $("#txtFECHA4").val() != 0 ){ 
	var fechaingresada = $("#txtFECHA4").val(); 
	var obsfocus =  4; }
	
	if ( $("#txtFECHA5").val() != 0 ){ 
	var fechaingresada = $("#txtFECHA5").val(); 
	var obsfocus =  5; }
	
	if ( $("#txtFECHA6").val() != 0 ){ 
	var fechaingresada = $("#txtFECHA6").val(); 
	var obsfocus =  6; }
	
	if ( $("#txtFECHA7").val() != 0 ){ 
	var fechaingresada = $("#txtFECHA7").val(); 
	var obsfocus =  7; }
	
	if ( $("#txtFECHA8").val() != 0 ){ 
	var fechaingresada = $("#txtFECHA8").val(); 
	var obsfocus =  8; }
	
	if ( $("#txtFECHA9").val() != 0 ){ 
	var fechaingresada = $("#txtFECHA9").val(); 
	var obsfocus =  9; }

// SELECT PERIODOS
    if ($('#cmb_periodos').val() != 0 ){ var idper = $('#cmb_periodos').val();}
		
	if ($('#cmb_periodos2').val() != 0 ){ var idper = $('#cmb_periodos2').val();}
		
	if ($('#cmb_periodos_Ren').val() != 0  )	{ var idper = $('#cmb_periodos_Ren').val();}
	
	if ($('#cmb_periodos4').val() != 0  )	{ var idper = $('#cmb_periodos4').val();}
	
	if ($('#cmb_periodos5').val() != 0  )	{ var idper = $('#cmb_periodos5').val();}
	
	if ($('#cmb_periodos6').val() != 0  )	{ var idper = $('#cmb_periodos6').val();}
	
	if ($('#cmb_periodos7').val() != 0  )	{ var idper = $('#cmb_periodos7').val();}
	
	if ($('#cmb_periodos8').val() != 0  )	{ var idper = $('#cmb_periodos8').val();}
	
	if ($('#cmb_periodos9').val() != 0  )	{ var idper = $('#cmb_periodos9').val();}
	

   	var parametros ="idperiodo="+idper+"&fechaingresada="+fechaingresada;
	//alert(parametros);
		
	if ( $('#fecha_inicio').val() == "Ingresar Fecha Inicio" ) {
	         alert("Si no tiene Fecha Inicio periodo no puede realizar este Registro");
	         return false;
	        }
	
		if ( $('#fecha_termino').val() == "Ingresar Fecha Termino" ) {
	         alert("Si no tiene Fecha Termino periodo no puede realizar este Registro");
	         return false;
	        }
		
				$.ajax({
						url:'validacionfechaperiodo.php',
						data:parametros,
						type:'POST',
						success:function(data){
						
						//alert(data);
						if (data == 0){
						   alert("Error: Verificar las Fechas de Periodo");
						} else {
						if (data == 1){ 
													   //alert("Fecha es Correcta");
													  /* if(obsfocus == 1){
													   $("#obser").focus();
													   }
															   if(obsfocus == 2){
															   $("#txtOBS3").focus();
															   }
																	   if(obsfocus == 3){
																	   $("#txtOBS").focus();
																	   }
											   */}else{
				alert("Esta Fecha no esta Dentro del Rango de Fechas de Perido\nEscoja Una Dentro del rango por favor");
					/*	$("#txtFECHA").val("")
						$("#txtFECHA2").val("")
						$("#txtFECHA10").val("")
						$("#txtFECHA4").val("")
						$("#txtFECHA5").val("")
						$("#txtFECHA6").val("")
						$("#txtFECHA7").val("")
						$("#txtFECHA8").val("")
						$("#txtFECHA9").val("")*/
											   //$("#fechasdeperiodo1").html(data);
												}
								   } 
					
							} //success
				 }) 
	   
 }	
  
</script>



<?

$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".trim($rutusuario)."'";
		
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					//exit();
				}
			}
		}?>

<form name="Formulariolista" id="Formulariolista" >

<div id="tabs" >

	<ul>
		<li ><a href="#antecedentes" onclick="reseteo()" >Antecedentes<br>&nbsp;</a></li>
		<li ><a href="#destaca" onclick="reseteo2()" >Destaca<br>Por</a></li>
		<li ><a href="#rendimiento" onclick="reseteo3()" >Rendimiento<br>&nbsp;</a></li>
        <li ><a href="#dae" onclick="reseteo4()" >D.A.E<br>&nbsp;</a></li>
        <li ><a href="#entrevista_apoderado" onclick="reseteo5()" >Entrevista <br>Apoderado</a></li>
        <li ><a href="#entrevista_alumno" onclick="reseteo6()" >Entrevista <br>Alumno</a></li>
        <li ><a href="#derivacion_interna" onclick="reseteo7()" >Derivaci&oacute;n <br>Interna</a></li>
		<li ><a href="#informe_especialista" onclick="reseteo8()" >Infor Especialista <br>Externo</a></li>
        <li ><a href="#acuerdos_tomados" onclick="reseteo9()" >Acuerdos<br>&nbsp;&nbsp;&nbsp;Tomados&nbsp;&nbsp;</a></li>
    </ul>


  
<div id="antecedentes" >

  <table width="100%"  class="textosimple" >
    <tr class="textonegrita">
   <td width="15%" align="left" >RUT ALUMNO:</td>
   <td width="85%" ><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></td>
   </tr>
   <tr class="textonegrita">
   <td width="15%" align="left" >NOMBRE ALUMNO:</td>
   <td width="85%" ><?=$fila['nombre_alu'].$fila['ape_pat'].$fila['ape_mat'];?></td>
   </tr>
  </table>
<fieldset>
<div id="respuestabuscardoc">&nbsp;</div>
<div id="dialogAntecedentes">&nbsp;</div>
<table width="100%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Periodo:</td>
    <td width="82%">&nbsp;<select  id="cmb_periodos" name="cmb_periodos" class="ddlb_9_x Estilo3" onchange="buscarperiodos()">
          <option value=0 selected>(Seleccione Periodo)</option>
          <?
		  
$sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano." order by 1";
	
	$result_peri = @pg_exec($conn,$sql);
	for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
	
		$fila1 = @pg_fetch_array($result_peri,$i); 
		echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
		
      } 
	  
	  ?>
        </select> 
        <div id="fechasdeperiodo1"></div>
        </td>
     
  </tr>
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Fecha:</td>
    <td>&nbsp;<input type="text" name="txtFECHA" 
		id="txtFECHA" readonly="readonly" size="11" maxlength="11" onchange="validarfecha()"/></td>
  </tr>
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Antecedentes:</td>
    <td>&nbsp;<textarea name="obser" cols="60" rows="3" id="obser"></textarea></td>
  </tr>
  
</table>	


<? 
 if($ingreso==1){
		   ?>
<div id="bottoncontrol" align="left">
<br>						
<input align="left" name="creardoc" type="button" onClick="cargardatos(0)" value="Crear" class="botonXX" />
</div>
<?   }?>

<div id="botton" >
</div>

</fieldset>


 <div id='table_evaluadores'>
  </div>
</div> 
<!--PRIMER DIV-->

<div id="destaca">  <!--SEGUNDO DIV-->
<table width="100%"  class="textosimple">
    <tr class="textonegrita">
   <td width="15%" align="left" >RUT ALUMNO:</td>
   <td width="85%" ><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></td>
   </tr>
   <tr class="textonegrita">
   <td width="15%" align="left" >NOMBRE ALUMNO:</td>
   <td width="85%" ><?=$fila['nombre_alu'].$fila['ape_pat'].$fila['ape_mat'];?></td>
   </tr>
  </table>
 
<fieldset>
<div id="respuestabuscarDestaca">&nbsp;</div>
<div id="dialogDestaca">&nbsp;</div>
<table width="%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Periodo:</td>
    <td width="82%">&nbsp;<select  id="cmb_periodos2" name="cmb_periodos2" class="ddlb_9_x Estilo3"  onchange="buscarperiodos()">
          <option value=0 selected>(Seleccione Periodo)</option>
          <?
		  
$sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano." order by 1";
	
	$result_peri = @pg_exec($conn,$sql);
	for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
	
		$fila1 = @pg_fetch_array($result_peri,$i); 
		echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
		
      } 
	  
	  ?>
        </select>  <div id="fechasdeperiodo2"></div></td>
  </tr>
   
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Fecha:</td>
    <td>&nbsp;<input type="text" name="txtFECHA2" 
		id="txtFECHA2" readonly="readonly" size="11" maxlength="11" onchange="validarfecha()"/></td>
  </tr>
  
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">Destaca&nbsp;Por&nbsp;1:</td>
  <td>
  	 <?php
		 $qry="select * from conceptos_vitacora co where co.tipo=1 order by 1";
		 $result5 =@pg_Exec($conn,$qry);
		  
	if (!$result5) 
		error('<B> ERROR :</b>Error al acceder a la BD. (evaalum)</B>');
	else{
	if (pg_numrows($result5)!=0){
		$fila5 = @pg_fetch_array($result5,0);	
	if(!$fila5){
		error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
	//exit();
		};
		}
				
?>                   

 &nbsp;<Select name="cmbdestaca1" id="cmbdestaca1" onchange="validadestaca()">
                      <option value="0" selected>Destaca por 1</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$id_conc_vitac=$fila5['id_conceptos_vitacora'];
									
									echo  "<option value=".$id_conc_vitac.">".$fila5["nombre"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    <?php };?>
  
  </td>
  </tr>
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">Destaca por 2:</td>
  <td>
  	             &nbsp;<Select name="cmbdestaca2" id="cmbdestaca2" onchange="validadestaca()">
                      <option value="0" selected>Destaca por 2</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$id_conc_vitac=$fila5['id_conceptos_vitacora'];
									
									echo  "<option value=".$id_conc_vitac.">".$fila5["nombre"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    
  </td>
  </tr>
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">Destaca por 3:</td>
  <td>
  
  	           &nbsp;<Select name="cmbdestaca3" id="cmbdestaca3" onchange="validadestaca()" >
                      <option value="0" selected>Destaca por 3</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$id_conc_vitac=$fila5['id_conceptos_vitacora'];
									
									echo  "<option value=".$id_conc_vitac.">".$fila5["nombre"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    
  </td>
  </tr>
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">Destaca por 4:</td>
  <td>
   &nbsp;<Select name="cmbdestaca4" id="cmbdestaca4" onchange="validadestaca()" >
                      <option value="0" selected>Destaca por 4</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$id_conc_vitac=$fila5['id_conceptos_vitacora'];
									
									echo  "<option value=".$id_conc_vitac.">".$fila5["nombre"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    
  </td>
  </tr>
  
  </table>	
<?   if($ingreso==1){
		   ?>
<div id="bottoncontro2" align="left">
<br>																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																<input align="left" name="crearDestaca" type="button" onClick="cargardatos2(0)" value="Crear" class="botonXX" />
</div>
<? }?>

<div id="bottonDesPor" >
</div>

</fieldset>


 <div id='table_evaluadores2'>
  </div>

</div>  <!--FIN SEGUNDO DIV-->
	 


<div id="rendimiento"> <!--TERCER DIV-->
 <table width="100%"  class="textosimple" >
    <tr class="textonegrita">
   <td width="15%" align="left" >RUT ALUMNO:</td>
   <td width="85%" ><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></td>
   </tr>
   <tr class="textonegrita">
   <td width="15%" align="left" >NOMBRE ALUMNO:</td>
   <td width="85%" ><?=$fila['nombre_alu'].$fila['ape_pat'].$fila['ape_mat'];?></td>
   </tr>
  </table>
<fieldset>
<div id="respuestabuscarren">&nbsp;</div>
<table width="100%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
  <tr class="textosimple">
    <td width="8%" class="textonegrita">&nbsp;Periodo:</td>
    <td width="92%">&nbsp;<select  id="cmb_periodos_Ren" name="cmb_periodos_Ren" class="ddlb_9_x Estilo3" onchange="cargartablaramos()">
          <option value=0 selected>(Seleccione Periodo)</option>
          <?
		  
$sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano." order by 1";
	
	$result_peri = @pg_exec($conn,$sql);
	for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
	
		$fila1 = @pg_fetch_array($result_peri,$i); 
		echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
		
      } 
	  
	  ?>
        </select> <div id="fechasdeperiodo3"></div></td>
  </tr>
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Fecha:</td>
    <td>&nbsp;<input type="text" name="txtFECHA10" 
		id="txtFECHA10" readonly="readonly" size="11" maxlength="11" onchange="validarfecha()"/></td>
  </tr><br />
  </table>
  <div id="cargaramos">
</div>
<div id="carganotas">

</div>

<div id="botton" >
</div>

</fieldset>

<br />
 <div id='table_evaluadores10'>
  </div>
  
<div id='verrendim'>
</div>

</div> <!--TERCER DIV-->


<div id="dae"> <!--CUARTO DIV-->
<table width="100%"  class="textosimple" >
    <tr class="textonegrita">
   <td width="15%" align="left" >RUT ALUMNO:</td>
   <td width="85%" ><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></td>
   </tr>
   <tr class="textonegrita">
   <td width="15%" align="left" >NOMBRE ALUMNO:</td>
   <td width="85%" ><?=$fila['nombre_alu'].$fila['ape_pat'].$fila['ape_mat'];?></td>
   </tr>
  </table>
<fieldset>
<div id="respuestabuscarDae">&nbsp;</div>
<div id="dialogDae">&nbsp;</div>
<table width="%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Periodo:</td>
    <td width="82%">&nbsp;<select  id="cmb_periodos4" name="cmb_periodos4" class="ddlb_9_x Estilo3" onchange="buscarperiodos()">
          <option value=0 selected>(Seleccione Periodo)</option>
          <?
		  
$sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano." order by 1";
	
	$result_peri = @pg_exec($conn,$sql);
	for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
	
		$fila1 = @pg_fetch_array($result_peri,$i); 
		echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
		
      } 
	  
	  ?>
        </select><div id="fechasdeperiodo4"></div> </td>
  </tr>
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Fecha:</td>
    <td>&nbsp;<input type="text" name="txtFECHA4" 
		id="txtFECHA4" readonly="readonly" size="11" maxlength="11" onchange="validarfecha()"/></td>
  </tr>
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Situación Actual:</td>
    <td width="82%">&nbsp;<select  id="cmb_situacion4" name="cmb_situacion4" class="ddlb_9_x Estilo3">
          <option value=0 selected>(Seleccione Situacion)</option>
          <?
		  
$sql4 = "select * from conceptos_vitacora where tipo =3";
	
	$result_peri4 = @pg_exec($conn,$sql4);
	for($q=0 ; $q < @pg_numrows($result_peri4) ; $q++){
	
		$fila4 = @pg_fetch_array($result_peri4,$q); 
		echo  "<option value=".$fila4["id_conceptos_vitacora"]." >".$fila4['nombre']."</option>";
		
      } 
	  
	  ?>
        </select> </td>
  </tr>
  
  <tr class="textosimple">
  <td width="18%" class="textonegrita">&nbsp;Docente:</td>
  <td>
  
  	 <?php
                			$qry="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((trabaja.cargo)=".$docente.") AND ((trabaja.rdb)=".$institucion.")) order by empleado.ape_pat, empleado.ape_mat";
							$result5 =@pg_Exec($conn,$qry);
							if (!$result5) 
								error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
							else{
								if (pg_numrows($result5)!=0){
									$fila5 = @pg_fetch_array($result5,0);	
									if(!$fila5){
										error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
										//exit();
									};
								}
				
?>                    &nbsp;<Select name="cmbDOC" id="cmbDOC">
                      <option value="0" selected>Seleccionar Docente</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$rut_emp=$fila5['rut_emp'];
									
									echo  "<option value=".$rut_emp.">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    <?php };?>
  
  </td>
  
  </tr>
  
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Observacion&nbsp;Situacion&nbsp;Actual:</td>
    <td>&nbsp;<textarea name="obser4" cols="60" rows="3" id="obser4"></textarea></td>
  </tr>
  
</table>	
<?   if($ingreso==1){
		   ?>
<div id="bottoncontro4" align="left">
<br>																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																<input align="left" name="creardoc" type="button" onClick="cargardatos4(0)" value="Crear" class="botonXX" />
</div>
<? }?>

<div id="botton" >
</div>

</fieldset>


 <div id='table_evaluadores4'>
  </div>
</div>  
<!-- FIN CUARTO DIV-->

<div id="entrevista_apoderado"><!--DIV 5 -->
<table width="100%"  class="textosimple" >
    <tr class="textonegrita">
   <td width="15%" align="left" >RUT ALUMNO:</td>
   <td width="85%" ><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></td>
   </tr>
   <tr class="textonegrita">
   <td width="15%" align="left" >NOMBRE ALUMNO:</td>
   <td width="85%" ><?=$fila['nombre_alu'].$fila['ape_pat'].$fila['ape_mat'];?></td>
   </tr>
  </table>
<fieldset>
<div id="respuestabuscarEntAp">&nbsp;</div>
<div id="dialogApo">&nbsp;</div>
<div id="formulario_apoderado" class="ui-button-text" title="Ingreso Apoderado"></div>
<table width="%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Periodo:</td>
    <td width="82%">&nbsp;<select  id="cmb_periodos5" name="cmb_periodos5" class="ddlb_9_x Estilo3" onchange="buscarperiodos()">
          <option value=0 selected>(Seleccione Periodo)</option>
          <?
		  
$sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano." order by 1";
	
	$result_peri = @pg_exec($conn,$sql);
	for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
	
		$fila1 = @pg_fetch_array($result_peri,$i); 
		echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
		
      } 
	  
	  ?>
        </select> <div id="fechasdeperiodo5"></div></td>
  </tr>
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Fecha:</td>
    <td>&nbsp;<input type="text" name="txtFECHA5" 
		id="txtFECHA5" readonly="readonly" size="11" maxlength="11" onchange="validarfecha()"/></td>
  </tr>
  
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Especialista:</td>
  <td>
  
  	 <?php
                			$qry="select * from conceptos_vitacora co where co.tipo=4";
							$result5 =@pg_Exec($conn,$qry);
							if (!$result5) 
								error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
							else{
								if (pg_numrows($result5)!=0){
									$fila5 = @pg_fetch_array($result5,0);	
									if(!$fila5){
										error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
										//exit();
									};
								}
				
?>                    &nbsp;<Select name="cmbEval" id="cmbEval" onchange="habilitacombo5()" >
                      <option value="0" selected>Especialista</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$id_conc_vitac=$fila5['id_conceptos_vitacora'];
									
									echo  "<option value=".$id_conc_vitac.">".$fila5["nombre"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    <?php };?>
  
  </td>
  </tr>
  
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Docente:</td>
  <td>
  
  	 <?php
                			$qry="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((trabaja.cargo)=".$docente.") AND ((trabaja.rdb)=".$institucion.")) order by empleado.ape_pat, empleado.ape_mat";
							$result5 =@pg_Exec($conn,$qry);
							if (!$result5) 
								error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
							else{
								if (pg_numrows($result5)!=0){
									$fila5 = @pg_fetch_array($result5,0);	
									if(!$fila5){
										error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
										//exit();
									};
								}
				
?>                    &nbsp;<Select name="cmbDOC5" id="cmbDOC5" disabled="disabled">
                      <option value="0" selected>Seleccionar Docente</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$rut_emp=$fila5['rut_emp'];
									
									echo  "<option value=".$rut_emp.">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
								}
							
						?>
                    </Select> 
                    
                    <?php };?>
  
  </td>
  </tr>
  
  <tr class="textosimple">
  <td width="18%" class="textonegrita">&nbsp;Apoderado:</td>
  
  <td>
  
  	    <div id="selectApo"> 
        </div>           
                   
  
  </td>
  
  </tr>
  
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Observacion&nbsp;Entravista&nbsp;Apoderado:</td>
    <td>&nbsp;<textarea name="obserApo" cols="60" rows="3" id="obserApo"></textarea></td>
  </tr>
  
</table>	

<?   if($ingreso==1){
		   ?>
<div id="bottoncontro5" align="left" >
																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																											<input align="left" name="crearApo" type="button" onClick="cargardatos5(0)" value="Crear" class="botonXX" />
</div>


<? }?>

<div id="bottonApo" >
</div>

</fieldset>


 <div id='table_evaluadores5'>
  </div>
</div><!--FIN DIN 5-->

<div id="entrevista_alumno"><!-- DIV 6-->
<table width="100%"  class="textosimple" >
    <tr class="textonegrita">
   <td width="15%" align="left" >RUT ALUMNO:</td>
   <td width="85%" ><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></td>
   </tr>
   <tr class="textonegrita">
   <td width="15%" align="left" >NOMBRE ALUMNO:</td>
   <td width="85%" ><?=$fila['nombre_alu'].$fila['ape_pat'].$fila['ape_mat'];?></td>
   </tr>
  </table>
<fieldset>
<div id="respuestabuscarEntAlum">&nbsp;</div>
<div id="dialogAlum">&nbsp;</div>
<table width="%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Periodo:</td>
    <td width="82%">&nbsp;<select  id="cmb_periodos6" name="cmb_periodos6" class="ddlb_9_x Estilo3" onchange="buscarperiodos()">
          <option value=0 selected>(Seleccione Periodo)</option>
          <?
		  
$sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano." order by 1";
	
	$result_peri = @pg_exec($conn,$sql);
	for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
	
		$fila1 = @pg_fetch_array($result_peri,$i); 
		echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
		
      } 
	  
	  ?>
        </select> <div id="fechasdeperiodo6"></div></td>
  </tr>
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Fecha:</td>
    <td>&nbsp;<input type="text" name="txtFECHA6" 
		id="txtFECHA6" readonly="readonly" size="11" maxlength="11" onchange="validarfecha()"/></td>
  </tr>
  
   <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Especialista:</td>
  <td>
  
  	 <?php
                			$qry="select * from conceptos_vitacora co where co.tipo=4";
							$result5 =@pg_Exec($conn,$qry);
							if (!$result5) 
								error('<B> ERROR :</b>Error al acceder a la BD. (evaalum)</B>');
							else{
								if (pg_numrows($result5)!=0){
									$fila5 = @pg_fetch_array($result5,0);	
									if(!$fila5){
										error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
										//exit();
									};
								}
				
?>                    &nbsp;<Select name="cmbEvalAlum" id="cmbEvalAlum" onchange="habilitacombo6()" >
                      <option value="0" selected>Especialista</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$id_conc_vitac=$fila5['id_conceptos_vitacora'];
									
									echo  "<option value=".$id_conc_vitac.">".$fila5["nombre"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    <?php };?>
  
  </td>
  </tr>
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Docente:</td>
  <td>
  
  	 <?php
                			$qry="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((trabaja.cargo)=".$docente.") AND ((trabaja.rdb)=".$institucion.")) order by empleado.ape_pat, empleado.ape_mat";
							$result5 =@pg_Exec($conn,$qry);
							if (!$result5) 
								error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
							else{
								if (pg_numrows($result5)!=0){
									$fila5 = @pg_fetch_array($result5,0);	
									if(!$fila5){
										error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
										//exit();
									};
								}
				
?>                    &nbsp;<Select name="cmbDOC6" id="cmbDOC6" disabled="disabled">
                      <option value="0" selected>Seleccionar Docente</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$rut_emp=$fila5['rut_emp'];
									
									echo  "<option value=".$rut_emp.">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    <?php };?>
  </td>
  </tr>
  
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Observacion&nbsp;Entravista&nbsp;Alumno:</td>
    <td>&nbsp;<textarea name="obserAlum" cols="60" rows="3" id="obserAlum"></textarea></td>
  </tr>
  
</table>	

<?   if($ingreso==1){
		   ?>
<div id="bottoncontro6" align="left">
<br>																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																<input align="left" name="crearApo" type="button" onClick="cargardatos6(0)" value="Crear" class="botonXX" />
</div>
<? }?>

<div id="bottonAlum" >
</div>

</fieldset>


 <div id='table_evaluadores6'>
  </div>
</div><!-- FIN 6-->

<div id="derivacion_interna"><!--DIV 7 -->
<table width="100%"  class="textosimple" >
    <tr class="textonegrita">
   <td width="15%" align="left" >RUT ALUMNO:</td>
   <td width="85%" ><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></td>
   </tr>
   <tr class="textonegrita">
   <td width="15%" align="left" >NOMBRE ALUMNO:</td>
   <td width="85%" ><?=$fila['nombre_alu'].$fila['ape_pat'].$fila['ape_mat'];?></td>
   </tr>
  </table>
<fieldset>
<div id="respuestabuscarDerInt">&nbsp;</div>
<div id="dialogoDerInt">&nbsp;</div>
<table width="%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Periodo:</td>
    <td width="82%">&nbsp;<select  id="cmb_periodos7" name="cmb_periodos7" class="ddlb_9_x Estilo3" onchange="buscarperiodos()">
          <option value=0 selected>(Seleccione Periodo)</option>
          <?
		  
$sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano." order by 1";
	
	$result_peri = @pg_exec($conn,$sql);
	for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
	
		$fila1 = @pg_fetch_array($result_peri,$i); 
		echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
		
      } 
	  
	  ?>
        </select> <div id="fechasdeperiodo7"></div></td>
  </tr>
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Fecha:</td>
    <td>&nbsp;<input type="text" name="txtFECHA7" 
		id="txtFECHA7" readonly="readonly" size="11" maxlength="11" onchange="validarfecha()"/></td>
  </tr>
  
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Especialista:</td>
  <td>
  
  	 <?php
                			$qry="select * from conceptos_vitacora co where co.tipo=5 order by 1";
							$result5 =@pg_Exec($conn,$qry);
							if (!$result5) 
								error('<B> ERROR :</b>Error al acceder a la BD. (evaalum)</B>');
							else{
								if (pg_numrows($result5)!=0){
									$fila5 = @pg_fetch_array($result5,0);	
									if(!$fila5){
										error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
										//exit();
									};
								}
				
?>                    &nbsp;<Select name="cmbDerInt" id="cmbDerInt" onchange="habilitacombo7()" >
                      <option value="0" selected>Especialista</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$id_conc_vitac=$fila5['id_conceptos_vitacora'];
									
									echo  "<option value=".$id_conc_vitac.">".$fila5["nombre"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    <?php };?>
  
  </td>
  </tr>
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Docente:</td>
  <td>
  
  	 <?php
     $qry="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat
	  FROM empleado INNER JOIN
	  trabaja ON empleado.rut_emp = trabaja.rut_emp
	  INNER JOIN institucion ON trabaja.rdb = institucion.rdb
	  where trabaja.rdb=".$institucion." 
	  order by empleado.ape_pat, empleado.ape_mat";
							$result5 =@pg_Exec($conn,$qry)or die("Fallo :".$qry);
							if (!$result5) 
								error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
							else{
								if (pg_numrows($result5)!=0){
									$fila5 = @pg_fetch_array($result5,0);	
									if(!$fila5){
										error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
										//exit();
									};
								}
				
?>                    &nbsp;<Select name="cmbDOC7" id="cmbDOC7" disabled="disabled">
                      <option value="0" selected>Seleccionar Docente</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$rut_emp=$fila5['rut_emp'];
									
									echo  "<option value=".$rut_emp.">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    <?php };?>
  </td>
  </tr>
  
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Observacion&nbsp;Derivaci&oacute;n&nbsp;Interna:</td>
    <td>&nbsp;<textarea name="obserDerInt" cols="60" rows="3" id="obserDerInt"></textarea></td>
  </tr>
  
</table>	
<?   if($ingreso==1){
		   ?>
<div id="bottoncontro7" align="left">
<br>																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																<input align="left" name="crearDerInt" type="button" onClick="cargardatos7(0)" value="Crear" class="botonXX" />
</div>
<? }?>

<div id="bottonDerInt" >
</div>

</fieldset>


 <div id='table_evaluadores7'>
  </div>
</div><!-- fin 7-->

<div id="informe_especialista"><!-- div 8-->
<table width="100%"  class="textosimple">
    <tr class="textonegrita">
   <td width="15%" align="left" >RUT ALUMNO:</td>
   <td width="85%" ><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></td>
   </tr>
   <tr class="textonegrita">
   <td width="15%" align="left" >NOMBRE ALUMNO:</td>
   <td width="85%" ><?=$fila['nombre_alu'].$fila['ape_pat'].$fila['ape_mat'];?></td>
   </tr>
  </table>
<fieldset>
<div id="respuestabuscarDerExt">&nbsp;</div>
<div id="dialogoDerExt">&nbsp;</div>
<table width="%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Periodo:</td>
    <td width="82%">&nbsp;<select  id="cmb_periodos8" name="cmb_periodos8" class="ddlb_9_x Estilo3" onchange="buscarperiodos()">
          <option value=0 selected>(Seleccione Periodo)</option>
          <?
		  
$sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano." order by 1";
	
	$result_peri = @pg_exec($conn,$sql);
	for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
	
		$fila1 = @pg_fetch_array($result_peri,$i); 
		echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
		
      } 
	  
	  ?>
        </select> <div id="fechasdeperiodo8"></div></td>
  </tr>
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Fecha:</td>
    <td>&nbsp;<input type="text" name="txtFECHA8" 
		id="txtFECHA8" readonly="readonly" size="11" maxlength="11" onchange="validarfecha()"/></td>
  </tr>
  
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Especialista:</td>
  <td>
  
  	 <?php
                			$qry="select * from conceptos_vitacora co where co.tipo=6 order by 1";
							$result5 =@pg_Exec($conn,$qry);
							if (!$result5) 
								error('<B> ERROR :</b>Error al acceder a la BD. (evaalum)</B>');
							else{
								if (pg_numrows($result5)!=0){
									$fila5 = @pg_fetch_array($result5,0);	
									if(!$fila5){
										error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
										//exit();
									};
								}
				
?>                    &nbsp;<Select name="cmbDerExt" id="cmbDerExt" onchange="habilitacombo8()" >
                      <option value="0" selected>Especialista</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$id_conc_vitac=$fila5['id_conceptos_vitacora'];
									
									echo  "<option value=".$id_conc_vitac.">".$fila5["nombre"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    <?php };?>
  
  </td>
  </tr>
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Docente:</td>
  <td>
  
  	 <?php
     $qry="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat
	  FROM empleado INNER JOIN
	  trabaja ON empleado.rut_emp = trabaja.rut_emp
	  INNER JOIN institucion ON trabaja.rdb = institucion.rdb
	  where trabaja.rdb=".$institucion." 
	  order by empleado.ape_pat, empleado.ape_mat";
							$result5 =@pg_Exec($conn,$qry)or die("Fallo :".$qry);
							if (!$result5) 
								error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
							else{
								if (pg_numrows($result5)!=0){
									$fila5 = @pg_fetch_array($result5,0);	
									if(!$fila5){
										error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
										//exit();
									};
								}
				
?>                    &nbsp;<Select name="cmbDOC8" id="cmbDOC8" disabled="disabled">
                      <option value="0" selected>Seleccionar Docente</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$rut_emp=$fila5['rut_emp'];
									
									echo  "<option value=".$rut_emp.">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    <?php };?>
  </td>
  </tr>
  
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Observacion&nbsp;Derivaci&oacute;n&nbsp;Externa:</td>
    <td>&nbsp;<textarea name="obserDerExt" cols="60" rows="3" id="obserDerExt"></textarea></td>
  </tr>
  
</table>	

<?   if($ingreso==1){
		   ?>
<div id="bottoncontro8" align="left">
<br>																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																<input align="left" name="crearDerExt" type="button" onClick="cargardatos8(0)" value="Crear" class="botonXX" />
</div>
<? } ?>

<div id="bottonDerExt" >
</div>

</fieldset>


 <div id='table_evaluadores8'>
  </div>
</div><!--fin 8-->

<div id="acuerdos_tomados">
<table width="100%"  class="textosimple">
    <tr class="textonegrita">
   <td width="15%" align="left" >RUT ALUMNO:</td>
   <td width="85%" ><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></td>
   </tr>
   <tr class="textonegrita">
   <td width="15%" align="left" >NOMBRE ALUMNO:</td>
   <td width="85%" ><?=$fila['nombre_alu'].$fila['ape_pat'].$fila['ape_mat'];?></td>
   </tr>
  </table>
<fieldset>
<div id="respuestabuscarAcTom">&nbsp;</div>
<div id="dialogoAcTom">&nbsp;</div>
<table width="%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Periodo:</td>
    <td width="82%">&nbsp;<select  id="cmb_periodos9" name="cmb_periodos9" class="ddlb_9_x Estilo3" onchange="buscarperiodos()">
          <option value=0 selected>(Seleccione Periodo)</option>
          <?
		  
$sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano." order by 1";
	
	$result_peri = @pg_exec($conn,$sql);
	for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
	
		$fila1 = @pg_fetch_array($result_peri,$i); 
		echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
		
      } 
	  
	  ?>
        </select> <div id="fechasdeperiodo9"></div></td>
  </tr>
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Fecha:</td>
    <td>&nbsp;<input type="text" name="txtFECHA9" 
		id="txtFECHA9" readonly="readonly" size="11" maxlength="11" onchange="validarfecha()"/></td>
  </tr>
  
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Especialista:</td>
  <td>
  
  	 <?php
		$qry="select * from conceptos_vitacora co where co.tipo=6 order by 1";
		 $result5 =@pg_Exec($conn,$qry);
	if (!$result5) 
		error('<B> ERROR :</b>Error al acceder a la BD. (evaalum)</B>');
	else{
	if (pg_numrows($result5)!=0){
		$fila5 = @pg_fetch_array($result5,0);	
	if(!$fila5){
		error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
	//exit();
		};
		}
				
?>                    &nbsp;<Select name="cmbAcTom" id="cmbAcTom" onchange="habilitacombo9()" >
                      <option value="0" selected>Especialista</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$id_conc_vitac=$fila5['id_conceptos_vitacora'];
									
									echo  "<option value=".$id_conc_vitac.">".$fila5["nombre"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    <?php };?>
  
  </td>
  </tr>
  
  <tr class="textosimple">
    <td width="18%" class="textonegrita">&nbsp;Docente:</td>
  <td>
  
  	 <?php
     $qry="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat
	  FROM empleado INNER JOIN
	  trabaja ON empleado.rut_emp = trabaja.rut_emp
	  INNER JOIN institucion ON trabaja.rdb = institucion.rdb
	  where trabaja.rdb=".$institucion." 
	  order by empleado.ape_pat, empleado.ape_mat";
							$result5 =@pg_Exec($conn,$qry)or die("Fallo :".$qry);
							if (!$result5) 
								error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
							else{
								if (pg_numrows($result5)!=0){
									$fila5 = @pg_fetch_array($result5,0);	
									if(!$fila5){
										error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
										//exit();
									};
								}
				
?>                    &nbsp;<Select name="cmbDOC9" id="cmbDOC9" disabled="disabled">
                      <option value="0" selected>Seleccionar Docente</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									$rut_emp=$fila5['rut_emp'];
									
									echo  "<option value=".$rut_emp.">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
								}
							
						?>
                    </Select> 
                
                    
                    <?php };?>
  </td>
  </tr>
  
  <tr class="textosimple">
    <td class="textonegrita">&nbsp;Observacion&nbsp;Acuerdos&nbsp;Tomados:</td>
    <td>&nbsp;<textarea name="obserAcTom" cols="60" rows="3" id="obserAcTom"></textarea></td>
  </tr>
  
</table>	
<?   if($ingreso==1){
		   ?>
<div id="bottoncontro9" align="left">
<br>																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																<input align="left" name="crearAcTom" type="button" onClick="cargardatos9(0)" value="Crear" class="botonXX" />
</div>
<? }?>

<div id="bottonAcTom" >
</div>

</fieldset>


 <div id='table_evaluadores9'>
  </div>
</div>




</div><!-- End -->

</form>