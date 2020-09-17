<?php 
include_once('../../../../../util/header.inc');


	
	
	
	 $institucion	=$_INSTIT;
	 $frmModo		=$_FRMMODO;
	 $ano 			=$_ANO;
	$_POSP          =5;
	$_bot           =5;
	if ($_PERFIL==0){
		$sql="select num_corp from corp_instit where rdb=".$institucion;
		$rs_corp=pg_exec($conn,$sql);
		$corporacion=pg_result($rs_corp,0);
	}else {
		$corporacion=$_CORPORACION;
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
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}

	
		
	//echo $_PERFIL;
	//if ($_ALUMNO!=""){
	if ($sw != 1){
	   $alumno			=$_ALUMNO;
    }else{
	   $_ALUMNO = $alumno;
	}   
	//}
	$curso			=$_CURSO;
	if( $_PERFIL ==109 && $institucion!=516 && $institucion!=12086 && $institucion!=14912 && $institucion!=770 && $institucion!=12838  && $institucion!=9276 )
	{
		$curso = $curso_act; 
	}
		

    $estado = array (                
                 'BAJ'	=>"disabled",
                 'BCHS'	=>"disabled",
                 'AOI'	=>"disabled",
                 'RG'	=>"disabled",
                 'AE'	=>"disabled",
                 'GD'	=>"disabled",
                 'I'	=>"disabled",
				 'SEP'	=>"disabled"
        );

?>

 <?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../index.php";
		 </script>

<? } ?>

<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".trim($alumno)."'";
		
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
		}
	} 
	
	if ($r == "no"){
	     if($AR)        $AR=1;      else    $AR=0;
		 
	    // borramos la fecha de el ticket de retiro 
		$q2="UPDATE matricula SET  bool_ar ='".$AR."', fecha_retiro = NULL  WHERE (((rut_alumno)='".trim($_ALUMNO)."') AND (ID_ANO='".trim($ano)."'));";
		$r2=pg_Exec($conn,$q2);
		if (!$r2){
		   echo "Error no se producido la actualizacion";
		}    
		
	}
		$empleado = $fila['rut_emp'];
		
	
	$sql_ano = "SELECT nro_ano FROM ano_escolar WHERE id_ano = ".$ano;
	$res_ano = @pg_Exec($conn,$sql_ano);
	$arr_ano = pg_fetch_array($res_ano);
	
	$nro_ano = $arr_ano['nro_ano'];
	
?>	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<style type="text/css" media="screen, projection">

            /* Not required for Tabs, just to make this demo look better... */

            body {
                font-size: 16px; /* @ EOMB */
            }
            * html body {
                font-size: 100%; /* @ IE */
            }
            body * {
                font-size: 87.5%;
                font-family: "Trebuchet MS", Trebuchet, Verdana, Helvetica, Arial, sans-serif;
            }
            body * * {
                font-size: 100%;
            }
            h1 {
                margin: 1em 0 1.5em;
                font-size: 18px;
            }
            h2 {
                margin: 2em 0 1.5em;
                font-size: 16px;
            }
            p {
                margin: 0;
            }
            pre, pre+p, p+p {
                margin: 1em 0 0;
            }
            code {
                font-family: "Courier New", Courier, monospace;
            }
			
			div.ui-datepicker{
                font-size:12px;
                  }

			.estilotabla{
				background-color:ffffff;
				border-style:solid;
				border-color:666666;
				border-width:1px;
			}
			.estilocelda{
				background-color:ddeeff;
				color:333333;
				font-weight:bold;
				font-size:10pt;
			}
			div.ui-dialog{
    font-size:14px;
    }

</style>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Georgia, "Times New Roman", Times, serif;
	color: #FF0000;
	font-size:11pt;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" type="text/css" href="includes/jquery-ui-1.8.6.custom.css">

<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script language="JavaScript" src="../../../../clases/jquery.ui.core.js"></script>
<script language="JavaScript" src="../../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script language="JavaScript" src="../../../../clases/jqueryui/jquery.ui.datepicker.js"></script>
<script language="JavaScript" src="../../../../clases/jqueryui/jquery.ui.widget.js"></script>

<script type="text/javascript" src="../../../../../util/chkform.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="select.js"></script>
<script src="jquery.history_remote.pack.js" type="text/javascript"></script>


<script language="JavaScript" type="text/JavaScript">

function cargardatos(fu){
	
		if($('#cmb_periodos').val()==0){
			alert("Debe Seleccionar Periodo");
			return false;
		}
		if($('#txtFECHA').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		if($('#obser').val()==""){
			alert("Debe Escribir Observación");
			$('#obser').focus();
			return false;
		}
		
		var nroAno = "<?=$nro_ano;?>"
		var fecha = $('#txtFECHA').val()
		var array_separafecha = fecha.split("/")
		var dia =  array_separafecha[0];
		var mes =  array_separafecha[1];
		var ano =  array_separafecha[2];
		
		if(nroAno!=ano){
			alert("debe seleccionar el mismo año al del periodo");
			return false;
		}
		
		var curso = "<?=$curso?>"
		var rdb = "<?=$institucion;?>"
		var ano = "<?=$ano;?>"
        var rutusuario = "<?=$alumno;?>"
		var tipo='1';
		var id_vitacora=$('#_id_vitacora').val();
		var parametros = "funcion="+fu+"&periodo="+$('#cmb_periodos').val()+"&fecha="+$('#txtFECHA').val()+"&obser="+$('#obser').val()+'&ano='+ano+"&rutusuario="+rutusuario+'&tipo='+tipo+'&id_vitacora='+id_vitacora+'&rdb='+rdb+'&curso='+curso;
		//alert(parametros);
		
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  	   if(data==1){
						   alert("Se Cargaron los Datos");
						   cargartabla();
						}else{
						   alert("Error de SistemaAAAAA");
						}
					 }
				 });
	
				$('#txtFECHA').val("");
				$('#cmb_periodos').val("");
				$('#obser').val("");
				$('#bottoncontrol').html('<br><input name="creardoc" type="button" onClick="cargardatos(0)" value="Crear" class="botonXX"/>');
				
	 }// fin funcion cargadatos


   
 function buscarante(id_vitacora){
	
	var texto
    texto = "El numero de opciones del select: " + document.Formulariolista.cmb_periodos.length
    var indice = document.Formulariolista.cmb_periodos.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmb_periodos.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogido = document.Formulariolista.cmb_periodos.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogido
    //alert(textoEscogido);
	 
	 	var rdb= "<?=$institucion;?>"
		var curso = "<?=$curso?>"
	   var parametros = "funcion=3&id_vitacora="+id_vitacora+"&rdb="+rdb+"&curso="+curso;
	   //alert(parametros);
	 
			$.ajax({
			  url:'cont_vitacoraAlumnos.php',
			  type:'post',
			  //dataType: 'json',
			  data:parametros,
			  success:function(data){
				 // alert(data);
						if(data!=0){
						
						 $('#respuestabuscardoc').html(data);	
						 var tomaperiodo = $('#_nombreper').val();
						 var iddelperiodo = $('#_id_periodo').val();
						 var idddelperiodo = $('#cmb_periodos').val();
						 var nombreper= document.Formulariolista.cmb_periodos.options[indice].text
						 var largocombo = document.Formulariolista.cmb_periodos.options.length;
							for(ii=0;ii<largocombo;ii++){
								//alert(largocombo);
							if(document.Formulariolista.cmb_periodos.options[ii].value == iddelperiodo){
								
								document.Formulariolista.cmb_periodos.selectedIndex = ii;
								 
	                           }
							}  
						
						$('#txtFECHA').val($('#_ano').val());
						$('#obser').val($('#_obs').val());
						$('#obser').focus();
	$('#bottoncontrol').html('<br><input name="Modificar" type="button" class="botonXX" onClick="cargardatos(1)" value="Modificar" />');
	
						}else{
						  alert("Error al Cargar");
						}
				 }
			 })
		}
 
 
 function DialogAnte(id_vitacora){
	 
	 var rdb= "<?=$institucion;?>"
		var curso = "<?=$curso?>"
	   var parametros = "funcion=45&id_vitacora="+id_vitacora+"&rdb="+rdb+"&curso="+curso;
	   //alert(parametros);
	   
	    $.ajax({
	  url:'cont_vitacoraAlumnos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#dialogAntecedentes").html(data);
			   $("#dialogAntecedentes").dialog({
				  modal: true,
				  title: "Antecedentes",
				  width: 600,
				 
				  
				    buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		  }
	  });
	 
	 
	 }
 

function cargartabla(rut_alumno){
	var rut_alumno = "<?=$alumno;?>"
	var rdb= "<?=$institucion;?>"
	var curso = "<?=$curso?>"
	//alert(rdb)
	// "funcion=8&id_vitacora="+id_vitacora;
	var parametros = "funcion=2&rut_alumno="+rut_alumno+"&rdb="+rdb+"&curso="+curso;
	//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_evaluadores').html(data);
						
						$("#flex1").flexigrid({
								width : 830,
								height : 100
							});
						}
				     }
		         })
	          } // fin funcion cargartabla
			  
			  
 function EliminaAnte(a){
			var parametros = "funcion=4&id_vitacora="+a;
			 if(!confirm("Seguro que desea eliminar!")) {
				 return false;
			 }else{
			$.ajax({
				url:'cont_vitacoraAlumnos.php',
				data:parametros,
				type:'POST',
				success:function(data){
					if(data==0){
						alert("Error en la Eliminación");
					}else{
						alert("Datos Eliminados");
						cargartabla();
					}
				}
			})
		 }
 }


function cargartablaDae(){
	var rdb="<?=$institucion;?>"
	var rut_alumno = "<?=$alumno;?>"
	//alert(rdb);
	var parametros = "funcion=7&rut_alumno="+rut_alumno+"&rdb="+rdb;
	//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_evaluadores4').html(data);
						//reseteo();
						$("#flex4").flexigrid({
								width : 830,
								height : 100
							});
						}
				     }
		         })
	          } // fin funcion cargartabla dae	


function cargardatos4(f){
	
		if($('#cmb_periodos4').val()==0){
			alert("Debe Seleccionar Periodooo");
			return false;
		}
		if($('#txtFECHA4').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmb_situacion4').val()=="0"){
			alert("Debe Seleccionar Situacion");
			return false;
		}
		
		if($('#cmbDOC').val()=="0"){
			alert("Debe Seleccionar Docente");
			return false;
		}
		
		
		if($('#obser4').val()==""){
			alert("Debe Escribir Observación");
			$('#obser4').focus();
			return false;
		}
		
		
		
		var nroAno = "<?=$nro_ano;?>"
		var fecha = $('#txtFECHA4').val()
		var array_separafecha = fecha.split("/")
		var dia =  array_separafecha[0];
		var mes =  array_separafecha[1];
		var ano =  array_separafecha[2];
		
		if(nroAno!=ano){
			alert("debe seleccionar el mismo año al del periodo");
			return false;
		}
		
		
		var curso = "<?=$curso?>"
		var rdb="<?=$institucion;?>"
		var ano = "<?=$ano;?>"
        var rutalumno = "<?=$alumno;?>"
		var tipo='4';
		var id_vitacora=$('#_id_vitacora').val();
		var f='5';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos4').val()+"&fecha="+$('#txtFECHA4').val()+"&concepto="+$('#cmb_situacion4').val()+"&docente="+$('#cmbDOC').val()+"&obser="+$('#obser4').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&tipo='+tipo+'&id_vitacora='+id_vitacora+'&rdb='+rdb+'&curso='+curso;
		//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				 // alert(data);
				  	   if(data==1){
						   alert("Se Cargaron los Datos");
						   cargartablaDae();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
	
				$('#txtFECHA4').val("");
				$('#cmb_periodos4').val("");
				$('#obser4').val("");
				$('#cmbDOC').val("");
				$('#bottoncontro4').html('<br><input name="crearDae" type="button" onClick="cargardatos4(0)" value="Crear" class="botonXX"/>');
				
	 }// fin funcion cargadatos



	function DialogDae(id_vitacora){
	 
	 var rdb= "<?=$institucion;?>"
		var curso = "<?=$curso?>"
	   var parametros = "funcion=47&id_vitacora="+id_vitacora+"&rdb="+rdb+"&curso="+curso;
	  // alert(parametros);
	   
	    $.ajax({
	  url:'cont_vitacoraAlumnos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#dialogDae").html(data);
			   $("#dialogDae").dialog({
				  modal: true,
				  title: "DAE",
				  width: 600,
				 
				  
				    buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		  }
	  });
	 
	 
	 }
	
	
function modificaDae(f){
	
		if($('#cmb_periodos4').val()==0){
			alert("Debe Seleccionar Periodooo");
			return false;
		}
		if($('#txtFECHA4').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmb_situacion4').val()=="0"){
			alert("Debe Seleccionar Situacion");
			return false;
		}
		
		if($('#cmbDOC').val()=="0"){
			alert("Debe Seleccionar Docente");
			return false;
		}
		
		
		if($('#obser4').val()==""){
			alert("Debe Escribir Observación");
			$('#obser4').focus();
			return false;
		}
		
		var ano = "<?=$ano;?>"
        var rutalumno = "<?=$alumno;?>"
		var tipo='4';
		var id_vitacora=$('#_id_vitacora_Dae').val();
		var f='6';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos4').val()+"&fecha="+$('#txtFECHA4').val()+"&concepto="+$('#cmb_situacion4').val()+"&docente="+$('#cmbDOC').val()+"&obser="+$('#obser4').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&tipo='+tipo+'&id_vitacora='+id_vitacora;
		//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  	   if(data==1){
						   alert("Se Cargaron los Datos");
						   cargartablaDae();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
	
				$('#txtFECHA4').val("");
				$('#cmb_periodos4').val("");
				$('#obser4').val("");
				$('#cmb_situacion4').val("");
				$('#cmbDOC').val("");
				
				
				$('#bottoncontro4').html('<br><input name="crearDae" type="button" onClick="cargardatos4(0)" value="Crear" class="botonXX"/>');
				
	 }// fin funcion Modifica Dae


function buscarDae(id_vitacora){
	var texto
    texto = "El numero de opciones del select: " + document.Formulariolista.cmb_periodos4.length
    var indice = document.Formulariolista.cmb_periodos4.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmb_periodos4.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogido = document.Formulariolista.cmb_periodos4.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogido
    //alert(textoEscogido);
	 
	   var parametros = "funcion=8&id_vitacora="+id_vitacora;
			$.ajax({
			  url:'cont_vitacoraAlumnos.php',
			  type:'post',
			  //dataType: 'json',
			  data:parametros,
			  success:function(data){
						if(data!=0){
						
						 $('#respuestabuscarDae').html(data);			  
						var tomaperiodoDae = $('#_nombreper_Dae').val();
						
						var tomasituacionDae = $('#_situ_Dae').val();
						var tomaDocenteDae = $('#nom_docente_Dae').val();
						 var iddelperiodoDae = $('#_id_periodoDae').val();
						 var id_conceptoDae = $('#_concepto').val();
						 var rut_emple = $('#_docente_Dae').val();
						 
						
						 var largocomboper = document.Formulariolista.cmb_periodos4.options.length;
						 var largocombositu = document.Formulariolista.cmb_situacion4.options.length;
						 var largocomboemp = document.Formulariolista.cmbDOC.options.length;
						 
						for(i=0;i<largocomboper;i++){
							if(document.Formulariolista.cmb_periodos4.options[i].value == iddelperiodoDae){
								document.Formulariolista.cmb_periodos4.selectedIndex = i;
	                             }
							 }  
					    for(e=0;e<largocombositu;e++){
					  		if(document.Formulariolista.cmb_situacion4.options[e].value == id_conceptoDae){
								document.Formulariolista.cmb_situacion4.selectedIndex = e;
	                             }
							 }  
							 
					    for(i=0;i<largocomboemp;i++){
							if(document.Formulariolista.cmbDOC.options[i].value == rut_emple){
								document.Formulariolista.cmbDOC.selectedIndex = i;
	                             }
							 }  
						
						
						$('#txtFECHA4').val($('#_ano_Dae').val());
						$('#obser4').val($('#_obs_Dae').val());
						 $('#obser4').focus();
	$('#bottoncontro4').html('<br><input name="Modificar4" id="Modificar4" type="button" class="botonXX" onClick="modificaDae()" value="Modificar" />');
	
						}else{
						  alert("Error al Cargar");
						}
				 }
			 })
		}

function EliminaAnteDae(j){
			var parametros = "funcion=9&id_vitacora="+j;
			 if(!confirm("Seguro que desea eliminar!")) {
				 return false;
			 }else{
			$.ajax({
				url:'cont_vitacoraAlumnos.php',
				data:parametros,
				type:'POST',
				success:function(data){
					if(data==0){
						alert("Error en la Eliminación");
					}else{
						cargartablaDae();
						alert("Datos Eliminados");
						
					}
				}
			})
		 }
 }

function habilitacombo5(){
	
	var texto
    texto =  document.Formulariolista.cmbEval.length
    var indice = document.Formulariolista.cmbEval.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmbEval.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogido = document.Formulariolista.cmbEval.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogido
	//alert(valor);
	var num1=11;
	var num2=12;
    //alert(textoEscogido);
		if(valor == num1 || valor == num2){
		document.Formulariolista.cmbDOC5.disabled =false;
		}else{
		document.Formulariolista.cmbDOC5.disabled =true;
		}
	}

	
	function cargardatos5(){
	
		if($('#cmb_periodos5').val()==0){
			alert("Debe Seleccionar Periodo");
			return false;
		}
		if($('#txtFECHA5').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmbEval').val()=="0"){
			alert("Debe Seleccionar Evaluador");
			return false;
		}
		
		
				
		if($('#cmbApo').val()=="0"){
			alert("Debe Seleccionar Apoderado");
			return false;
		}
		
		
		if($('#obserApo').val()==""){
			alert("Debe Escribir Observación");
			$('#obserApo').focus();
			return false;
		}
		
		
		var nroAno = "<?=$nro_ano;?>"
		var fecha = $('#txtFECHA5').val()
		var array_separafecha = fecha.split("/")
		var dia =  array_separafecha[0];
		var mes =  array_separafecha[1];
		var ano =  array_separafecha[2];
		
		if(nroAno!=ano){
			alert("debe seleccionar el mismo año al del periodo");
			return false;
		}
		
		var curso = "<?=$curso?>"
		var rdb="<?=$institucion;?>"
		var ano = "<?=$ano;?>"
		var rutalumno = "<?=$alumno;?>"
		var tipo='5';
		var id_vitacora=$('#_id_vitacora').val();
		var f='10';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos5').val()+"&fecha="+$('#txtFECHA5').val()+"&evaluador="+$('#cmbEval').val()+"&rutApo="+$('#cmbApo').val()+"&docente="+$('#cmbDOC5').val()+"&obser="+$('#obserApo').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&tipo='+tipo+'&id_vitacora='+id_vitacora+'&rdb='+rdb+'&curso='+curso;
		//alert(parametros);
		
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  	   if(data==1){
						   alert("Se Cargaron los Datos");
						   cargartablaApo();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
	
				$('#txtFECHA5').val("");
				$('#cmbEval').val("");
				$('#cmb_periodos5').val("");
				$('#obserApo').val("");
				$('#cmbApo').val("");
				$('#cmbDOC5').val("");
				$('#bottoncontro5').html('<br><input name="crearApo" type="button" onClick="cargardatos5(0)" value="Crear" class="botonXX"/>');
				
	 }// fin funcion cargadatos		  

  function cargartablaApo(){
	var rdb="<?=$institucion;?>"
	var rut_alumno = "<?=$alumno;?>"
	//alert(rdb);
	var parametros = "funcion=11&rut_alumno="+rut_alumno+"&rdb="+rdb;
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_evaluadores5').html(data);
						//reseteo();
						$("#flex5").flexigrid({
								width : 830,
								height : 100
							});
						}
				     }
		         })
	          } // fin funcion cargartabla Entrevista Apoderado

	function DialogApo(id_vitacora){
	 
	 var rdb= "<?=$institucion;?>"
		var curso = "<?=$curso?>"
	   var parametros = "funcion=48&id_vitacora="+id_vitacora+"&rdb="+rdb+"&curso="+curso;
	  // alert(parametros);
	   
	    $.ajax({
	  url:'cont_vitacoraAlumnos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#dialogApo").html(data);
			   $("#dialogApo").dialog({
				  modal: true,
				  title: "Entrevista Apoderado",
				  width: 600,
				 
				  
				    buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		  }
	  });
	 
	 
	 }
			

	function modificaApo(){
	
		if($('#cmb_periodos5').val()==0){
			alert("Debe Seleccionar Periodo");
			return false;
		}
		if($('#txtFECHA5').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmbEval').val()=="0"){
			alert("Debe Seleccionar Docente");
			return false;
		}
		
		if($('#cmbApo').val()=="0"){
			alert("Debe Seleccionar Apoderado");
			return false;
		}
		
		
		if($('#obserApo').val()==""){
			alert("Debe Escribir Observación");
			$('#obserApo').focus();
			return false;
		}
		
		var ano = "<?=$ano;?>"
		var rutalumno = "<?=$alumno;?>"
		var tipo='5';
		var id_vitacora=$('#_id_vitacora_Apo').val();
		var f='13';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos5').val()+"&fecha="+$('#txtFECHA5').val()+"&evaluador="+$('#cmbEval').val()+"&rutApo="+$('#cmbApo').val()+"&docente="+$('#cmbDOC5').val()+"&obser="+$('#obserApo').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&tipo='+tipo+'&id_vitacora='+id_vitacora;
		//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  	   if(data==1){
						   alert("Datos Modificados");
						   cargartablaApo();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
	
				$('#txtFECHA5').val("");
				$('#cmbEval').val("");
				$('#cmb_periodos5').val("");
				$('#obserApo').val("");
				$('#cmbApo').val("");
				$('#cmbDOC5').val("");
				$('#bottoncontro5').html('<br><input name="crearApo" type="button" onClick="cargardatos5(0)" value="Crear" class="botonXX"/>');
				
	 }// fin funcion Modifica Datos Entrevista Apoderado	  

function buscarApo(id_vitacora){
	var texto
    texto = "El numero de opciones del select: " + document.Formulariolista.cmb_periodos5.length
    var indice = document.Formulariolista.cmb_periodos5.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmb_periodos5.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogido = document.Formulariolista.cmb_periodos5.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogido
	 
	   var parametros = "funcion=12&id_vitacora="+id_vitacora;
	 // alert(parametros);
			$.ajax({
			  url:'cont_vitacoraAlumnos.php',
			  type:'post',
			  //dataType: 'json',
			  data:parametros,
			  success:function(data){
				 // alert(data);
						if(data!=0){
						
						 $('#respuestabuscarEntAp').html(data);			  
						var tomaperiodoApo = $('#_nombreper_Apo').val();
						
						var tomasituacionApo = $('#_situ_Apo').val();
						var tomaDocenteApo = $('#nom_docente_Apo').val();
						 var iddelperiodoApo = $('#_id_periodo_Apo').val();
						 var rutApo = $('#_rut_Apo').val();
						 var rut_empleApo = $('#_docente_Apo').val();
						 var id_concepto_vitacora = $('#_id_concepto_vitacora').val();
						 
						
						 var largocomboperApo = document.Formulariolista.cmb_periodos5.options.length;
						 var largocomboApo = document.Formulariolista.cmbApo.options.length;
						 var largocomboempApo = document.Formulariolista.cmbDOC5.options.length;
						 var largocomboEval = document.Formulariolista.cmbEval.options.length;
						 
						for(i=0;i<largocomboperApo;i++){
							if(document.Formulariolista.cmb_periodos5.options[i].value == iddelperiodoApo){
								document.Formulariolista.cmb_periodos5.selectedIndex = i;
	                             }
							 }  
					    for(e=0;e<largocomboApo;e++){
					  		if(document.Formulariolista.cmbApo.options[e].value == rutApo){
								document.Formulariolista.cmbApo.selectedIndex = e;
	                             }
							 }  
							 
					    for(i=0;i<largocomboempApo;i++){
							if(document.Formulariolista.cmbDOC5.options[i].value == rut_empleApo){
								document.Formulariolista.cmbDOC5.selectedIndex = i;
	                             }
							 }  
							 
						for(i=0;i<largocomboEval;i++){
							if(document.Formulariolista.cmbEval.options[i].value == id_concepto_vitacora){
								document.Formulariolista.cmbEval.selectedIndex = i;
	                             }
							 }  	 
						
						
						$('#txtFECHA5').val($('#_ano_Apo').val());
						$('#obserApo').val($('#_obs_Apo').val());
						$('#obserApo').focus();	
	$('#bottoncontro5').html('<br><input name="Modificar5" id="Modificar5" type="button" class="botonXX" onClick="modificaApo()" value="Modificar" />');
	
						}else{
						  alert("Error al Cargar");
						}
				 }
			 })
		}
		
		
	function EliminaAnteApo(ap){
			var parametros = "funcion=14&id_vitacora="+ap;
			 if(!confirm("Seguro que desea eliminar!")) {
				 return false;
			 }else{
			$.ajax({
				url:'cont_vitacoraAlumnos.php',
				data:parametros,
				type:'POST',
				success:function(data){
					if(data==0){
						alert("Error en la Eliminación");
					}else{
						cargartablaApo();
						alert("Datos Eliminados");
						
					}
				}
			})
		 }
 }	
		
	function habilitacombo6(){
	
	var texto
    texto =  document.Formulariolista.cmbEvalAlum.length
    var indice = document.Formulariolista.cmbEvalAlum.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmbEvalAlum.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogido = document.Formulariolista.cmbEvalAlum.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogido
	//alert(valor);
	var num1=11;
	var num2=12;
    //alert(textoEscogido);
		if(valor == num1 || valor == num2){
		document.Formulariolista.cmbDOC6.disabled =false;
		}else{
		document.Formulariolista.cmbDOC6.disabled =true;
		}
	}	
		
		
	function cargardatos6(){
	
		if($('#cmb_periodos6').val()=="0"){
			alert("Debe Seleccionar Periodooo");
			return false;
		}
		if($('#txtFECHA6').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmbEvalAlum').val()=="0"){
			alert("Debe Seleccionar Evaluador");
			return false;
		}
		
		if(document.Formulariolista.cmbDOC6.disabled ==false){
			if($('#cmbDOC6').val()=="0"){
			alert("Debe Seleccionar Docente");
			return false;
		}
			}
		
		
		if($('#obserAlum').val()==""){
			alert("Debe Escribir Observación");
			$('#obserApo').focus();
			return false;
		}
		
		var nroAno = "<?=$nro_ano;?>"
		var fecha = $('#txtFECHA6').val()
		var array_separafecha = fecha.split("/")
		var dia =  array_separafecha[0];
		var mes =  array_separafecha[1];
		var ano =  array_separafecha[2];
		
		if(nroAno!=ano){
			alert("debe seleccionar el mismo año al del periodo");
			return false;
		}
		
		
		var curso="<?=$curso?>"
		var rdb= "<?=$institucion;?>"
		var ano = "<?=$ano;?>"
		var rutalumno = "<?=$alumno;?>"
		var tipo='6';
		var id_vitacora=$('#_id_vitacora').val();
		var f='15';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos6').val()+"&fecha="+$('#txtFECHA6').val()+"&evaluador="+$('#cmbEvalAlum').val()+"&docente="+$('#cmbDOC6').val()+"&obser="+$('#obserAlum').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&tipo='+tipo+'&id_vitacora='+id_vitacora+'&rdb='+rdb+'&curso='+curso;
		//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  	   if(data==1){
						   alert("Se Cargaron los Datos");
						   cargartablaAlum();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
	
				$('#txtFECHA6').val("");
				$('#cmb_periodos6').val("");
				$('#obserAlum').val("");
				$('#cmbDOC6').val("");
				$('#cmbEvalAlum').val("");
				$('#bottoncontro6').html('<br><input name="crearApo" type="button" onClick="cargardatos6(0)" value="Crear" class="botonXX"/>');
				
				
	 }// fin funcion cargadatos	6	  		
		
	function cargartablaAlum(){
	 var rdb="<?=$institucion;?>"
	var rut_alumno = "<?=$alumno;?>"
	//alert(rdb);
	var parametros = "funcion=16&rut_alumno="+rut_alumno+"&rdb="+rdb;
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_evaluadores6').html(data);
						//reseteo();
						$("#flex6").flexigrid({
								width : 830,
								height : 100
							});
						}
				     }
		         })
	          } // fin funcion cargartabla Entrevista ALumno		
		
	function DialogAlum(id_vitacora){
	 
	 var rdb= "<?=$institucion;?>"
		var curso = "<?=$curso?>"
	   var parametros = "funcion=49&id_vitacora="+id_vitacora+"&rdb="+rdb+"&curso="+curso;
	  // alert(parametros);
	   
	    $.ajax({
	  url:'cont_vitacoraAlumnos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#dialogAlum").html(data);
			   $("#dialogAlum").dialog({
				  modal: true,
				  title: "Entrevista Alumno",
				  width: 600,
				 
				  
				    buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		  }
	  });
	 
	 
	 }	
		
		
		
		
	function buscarAlum(id_vitacora){
	var texto
    texto = "El numero de opciones del select: " + document.Formulariolista.cmb_periodos6.length
    var indice = document.Formulariolista.cmb_periodos6.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmb_periodos6.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogido = document.Formulariolista.cmb_periodos6.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogido
	 
	   var parametros = "funcion=17&id_vitacora="+id_vitacora;
	   //alert(parametros);
			$.ajax({
			  url:'cont_vitacoraAlumnos.php',
			  type:'post',
			  //dataType: 'json',
			  data:parametros,
			  success:function(data){
				 // alert(data);
						if(data!=0){
						
						 $('#respuestabuscarEntAlum').html(data);			  
						var tomaperiodoAlum = $('#_nombreper_Alum').val();
						
						var tomasituacionAlum = $('#_situ_Alum').val();
						var tomaDocenteAlum = $('#nom_docente_Alum').val();
						 var iddelperiodoAlum = $('#_id_periodo_Alum').val();
						 var rut_empleAlum = $('#_docente_Alum').val();
						 var id_evaalum= $('#_id_concepto_vitacora_alum').val();
						 
						
						 var largocomboperAlum = document.Formulariolista.cmb_periodos6.options.length;
						// var largocomboAlum = document.Formulariolista.cmbAlum.options.length;
						 var largocomboempAlum = document.Formulariolista.cmbDOC6.options.length;
						 var largocomboavaluadoralum= document.Formulariolista.cmbEvalAlum.options.length;
						 
						for(i=0;i<largocomboperAlum;i++){
							if(document.Formulariolista.cmb_periodos6.options[i].value == iddelperiodoAlum){
								document.Formulariolista.cmb_periodos6.selectedIndex = i;
	                             }
							 }  
					    
							 
					    for(i=0;i<largocomboempAlum;i++){
							if(document.Formulariolista.cmbDOC6.options[i].value == rut_empleAlum){
								document.Formulariolista.cmbDOC6.selectedIndex = i;
	                             }
							 }  
							 
					    for(i=0;i<largocomboavaluadoralum;i++){
							if(document.Formulariolista.cmbEvalAlum.options[i].value == id_evaalum){
								document.Formulariolista.cmbEvalAlum.selectedIndex = i;
	                             }
							 }  		 
						
						
						$('#txtFECHA6').val($('#_ano_Alum').val());
						$('#obserAlum').val($('#_obs_Alum').val());
						$('#obserAlum').focus();	
	$('#bottoncontro6').html('<br><input name="Modificar6" id="Modificar6" type="button" class="botonXX" onClick="modificaAlum()" value="Modificar" />');
	
						}else{
						  alert("Error al Cargar");
						}
				 }
			 })
		}	
		
		
		
	function modificaAlum(){
	
		if($('#cmb_periodos6').val()==0){
			alert("Debe Seleccionar Periodo");
			return false;
		}
		if($('#txtFECHA6').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmbEvalAlum').val()=="0"){
			alert("Debe Seleccionar Evaluador");
			return false;
		}
		
		if(document.Formulariolista.cmbDOC6.disabled ==false){
			if($('#cmbDOC6').val()=="0"){
			alert("Debe Seleccionar Docente");
			return false;
		}
			}
		
				
		if($('#obserAlum').val()==""){
			alert("Debe Escribir Observación");
			$('#obserAlum').focus();
			return false;
		}
		
		var ano = "<?=$ano;?>"
		var rutalumno = "<?=$alumno;?>"
		var tipo='6';
		var id_vitacora=$('#_id_vitacora_Alum').val();
		var f='18';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos6').val()+"&fecha="+$('#txtFECHA6').val()+"&evaluador="+$('#cmbEvalAlum').val()+"&docente="+$('#cmbDOC6').val()+"&obser="+$('#obserAlum').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&tipo='+tipo+'&id_vitacora='+id_vitacora;
		//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  	   if(data==1){
						   alert("Datos Modificados");
						   cargartablaAlum();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
	
				$('#txtFECHA6').val("");
				$('#cmb_periodos6').val("");
				$('#obserAlum').val("");
				$('#cmbDOC6').val("");
				$('#cmbEvalAlum').val("");
				$('#bottoncontro6').html('<br><input name="crearApo" type="button" onClick="cargardatos6(0)" value="Crear" class="botonXX"/>');
				
	 }// fin funcion Modifica Datos Entrevista Alumno	

	
	function EliminaAnteAlum(al){
			var parametros = "funcion=19&id_vitacora="+al;
			 if(!confirm("Seguro que desea eliminar!")) {
				 return false;
			 }else{
			$.ajax({
				url:'cont_vitacoraAlumnos.php',
				data:parametros,
				type:'POST',
				success:function(data){
					if(data==0){
						alert("Error en la Eliminación");
					}else{
						cargartablaAlum();
						alert("Datos Eliminados");
						
					}
				}
			})
		 }
 }	


	function habilitacombo7(){
	
	var texto
    texto =  document.Formulariolista.cmbDerInt.length
    var indice = document.Formulariolista.cmbDerInt.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmbDerInt.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogido = document.Formulariolista.cmbDerInt.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogido
	//alert(valor);
	var num=20;
	
    //alert(textoEscogido);
		if(valor == num){
		document.Formulariolista.cmbDOC7.disabled =false;
		}else{
		document.Formulariolista.cmbDOC7.disabled =true;
		}
	}		

	function cargardatos7(){
	
		if($('#cmb_periodos7').val()==0){
			alert("Debe Seleccionar Periodo");
			return false;
		}
		if($('#txtFECHA7').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmbDerInt').val()=="0"){
			alert("Debe Seleccionar Evaluador");
			return false;
		}
		
		if(document.Formulariolista.cmbDOC7.disabled ==false){
			if($('#cmbDOC7').val()=="0"){
			alert("Debe Seleccionar Docente");
			return false;
		}
			}
			
		if($('#obserDerInt').val()==""){
			alert("Debe Escribir Observación");
			$('#obserDerInt').focus();
			return false;
		}
		
		var nroAno = "<?=$nro_ano;?>"
		var fecha = $('#txtFECHA7').val()
		var array_separafecha = fecha.split("/")
		var dia =  array_separafecha[0];
		var mes =  array_separafecha[1];
		var ano =  array_separafecha[2];
		
		if(nroAno!=ano){
			alert("debe seleccionar el mismo año al del periodo");
			return false;
		}
		
		
		var curso="<?=$curso?>"
		var rdb = "<?=$institucion;?>"
		var ano = "<?=$ano;?>"
		var rutalumno = "<?=$alumno;?>"
		var tipo='7';
		var id_vitacora=$('#_id_vitacora').val();
		var f='20';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos7').val()+"&fecha="+$('#txtFECHA7').val()+"&evaluador="+$('#cmbDerInt').val()+"&docente="+$('#cmbDOC7').val()+"&obser="+$('#obserDerInt').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&tipo='+tipo+'&id_vitacora='+id_vitacora+'&rdb='+rdb+'&curso='+curso;
		//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  	   if(data==1){
						   alert("Se Cargaron los Datos");
						   cargartablaDerInt();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
	
				$('#txtFECHA7').val("");
				$('#cmb_periodos7').val("");
				$('#obserDerInt').val("");
				$('#cmbDOC7').val("");
				$('#bottoncontro7').html('<br><input name="crearDerInt" type="button" onClick="cargardatos7(0)" value="Crear" class="botonXX"/>');
				
				
	 }// fin funcion cargadatos	7	  	

	
	function cargartablaDerInt(){
	  var rdb="<?=$institucion;?>"
	var rut_alumno = "<?=$alumno;?>"
	//alert(rdb);
	var parametros = "funcion=21&rut_alumno="+rut_alumno+"&rdb="+rdb;
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_evaluadores7').html(data);
						//reseteo();
						$("#flex7").flexigrid({
								width : 830,
								height : 100
							});
						}
				     }
		         })
	          } // fin funcion cargartabla Derivacion Int.
	
			
	function DialogDerInt(id_vitacora){
	 
	 var rdb= "<?=$institucion;?>"
		var curso = "<?=$curso?>"
	   var parametros = "funcion=50&id_vitacora="+id_vitacora+"&rdb="+rdb+"&curso="+curso;
	  // alert(parametros);
	   
	    $.ajax({
	  url:'cont_vitacoraAlumnos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //alert(data);
		$("#dialogoDerInt").html(data);
			   $("#dialogoDerInt").dialog({
				  modal: true,
				  title: "Derivaci&oacute;n Interna",
				  width: 600,
				 
				  
				    buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		  }
	  });
	 
	 
	 }		
			
			
			
			function buscarDerInt(id_vitacora){
	var texto
    texto = "El numero de opciones del select: " + document.Formulariolista.cmb_periodos7.length
    var indice = document.Formulariolista.cmb_periodos7.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmb_periodos7.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogido = document.Formulariolista.cmb_periodos7.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogido
	 
	   var parametros = "funcion=22&id_vitacora="+id_vitacora;
	   //alert(parametros);
			$.ajax({
			  url:'cont_vitacoraAlumnos.php',
			  type:'post',
			  //dataType: 'json',
			  data:parametros,
			  success:function(data){
				 // alert(data);
						if(data!=0){
						
						 $('#respuestabuscarDerInt').html(data);			  
						var tomaperiodoDerInt = $('#_nombreper_DerInt').val();
						
						var tomasituacionDerInt = $('#_situ_DerInt').val();
						var tomaDocenteDerInt = $('#nom_docente_DerInt').val();
						 var iddelperiodoDerInt = $('#_id_periodo_DerInt').val();
						 var rut_empleDerInt = $('#_docente_DerInt').val();
						 var id_evaDerInt= $('#_id_concepto_vitacora_DerInt').val();
						 
						
						 var largocomboperDerInt = document.Formulariolista.cmb_periodos7.options.length;
						// var largocomboAlum = document.Formulariolista.cmbAlum.options.length;
						 var largocomboempDerInt = document.Formulariolista.cmbDOC7.options.length;
						 var largocomboavaluadorDerInt= document.Formulariolista.cmbDerInt.options.length;
						 
						for(i=0;i<largocomboperDerInt;i++){
							if(document.Formulariolista.cmb_periodos7.options[i].value == iddelperiodoDerInt){
								document.Formulariolista.cmb_periodos7.selectedIndex = i;
	                             }
							 }  
					    
							 
					    for(i=0;i<largocomboempDerInt;i++){
							if(document.Formulariolista.cmbDOC7.options[i].value == rut_empleDerInt){
								document.Formulariolista.cmbDOC7.selectedIndex = i;
	                             }
							 }  
							 
					    for(i=0;i<largocomboavaluadorDerInt;i++){
							if(document.Formulariolista.cmbDerInt.options[i].value == id_evaDerInt){
								document.Formulariolista.cmbDerInt.selectedIndex = i;
	                             }
							 }  		 
						
						
						$('#txtFECHA7').val($('#_ano_DerInt').val());
						$('#obserDerInt').val($('#_obs_DerInt').val());
						$('#obserDerInt').focus();	
	$('#bottoncontro7').html('<br><input name="Modificar7" id="Modificar7" type="button" class="botonXX" onClick="modificaDerInt()" value="Modificar" />');
	
						}else{
						  alert("Error al Cargar");
						}
				 }
			 })
		}	


	
	function modificaDerInt(){
	
		if($('#cmb_periodos7').val()==0){
			alert("Debe Seleccionar Periodo");
			return false;
		}
		if($('#txtFECHA7').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmbDerInt').val()=="0"){
			alert("Debe Seleccionar Docente");
			return false;
		}
		
				
		if($('#obserDerInt').val()==""){
			alert("Debe Escribir Observación");
			$('#obserDerInt').focus();
			return false;
		}
		
		var ano = "<?=$ano;?>"
		var rutalumno = "<?=$alumno;?>"
		var tipo='7';
		var id_vitacora=$('#_id_vitacora_DerInt').val();
		var f='23';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos7').val()+"&fecha="+$('#txtFECHA7').val()+"&evaluador="+$('#cmbDerInt').val()+"&docente="+$('#cmbDOC7').val()+"&obser="+$('#obserDerInt').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&tipo='+tipo+'&id_vitacora='+id_vitacora;
		//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  	   if(data==1){
						   alert("Datos Modificados");
						   cargartablaDerInt();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
	
				$('#txtFECHA7').val("");
				$('#cmb_periodos7').val("");
				$('#obserDerInt').val("");
				$('#cmbDOC7').val("");
				$('#cmbDerInt').val("");
				$('#bottoncontro7').html('<br><input name="crearApo" type="button" onClick="cargardatos7(0)" value="Crear" class="botonXX"/>');
				
	 }// fin funcion Modifica Datos Derivacion Int	

	
	function EliminaDerInt(di){
			var parametros = "funcion=24&id_vitacora="+di;
			 if(!confirm("Seguro que desea eliminar!")) {
				 return false;
			 }else{
			$.ajax({
				url:'cont_vitacoraAlumnos.php',
				data:parametros,
				type:'POST',
				success:function(data){
					if(data==0){
						alert("Error en la Eliminación");
					}else{
						cargartablaDerInt();
						alert("Datos Eliminados");
						
					}
				}
			})
		 }
 }
	
	
	function habilitacombo8(){
	
	var texto
    texto =  document.Formulariolista.cmbDerExt.length
    var indice = document.Formulariolista.cmbDerExt.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmbDerExt.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogido = document.Formulariolista.cmbDerExt.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogido
	//alert(valor);
	var num=26;
	
    //alert(textoEscogido);
		if(valor == num){
		document.Formulariolista.cmbDOC8.disabled =false;
		}else{
		document.Formulariolista.cmbDOC8.disabled =true;
		}
	}		
	
	
	function cargardatos8(){
	
		if($('#cmb_periodos8').val()==0){
			alert("Debe Seleccionar Periodo");
			return false;
		}
		if($('#txtFECHA8').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmbDerExt').val()=="0"){
			alert("Debe Seleccionar Evaluador");
			return false;
		}
		
		if(document.Formulariolista.cmbDOC8.disabled ==false){
			if($('#cmbDOC8').val()=="0"){
			alert("Debe Seleccionar Docente");
			return false;
		}
			}
			
		if($('#obserDerExt').val()==""){
			alert("Debe Escribir Observación");
			$('#obserDerExt').focus();
			return false;
		}
		
		var nroAno = "<?=$nro_ano;?>"
		var fecha = $('#txtFECHA8').val()
		var array_separafecha = fecha.split("/")
		var dia =  array_separafecha[0];
		var mes =  array_separafecha[1];
		var ano =  array_separafecha[2];
		
		if(nroAno!=ano){
			alert("debe seleccionar el mismo año al del periodo");
			return false;
		}
		
		
		var curso="<?=$curso?>"
		var rdb = "<?=$institucion;?>"
		var ano = "<?=$ano;?>"
		var rutalumno = "<?=$alumno;?>"
		var tipo='8';
		var id_vitacora=$('#_id_vitacora').val();
		var f='25';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos8').val()+"&fecha="+$('#txtFECHA8').val()+"&evaluador="+$('#cmbDerExt').val()+"&docente="+$('#cmbDOC8').val()+"&obser="+$('#obserDerExt').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&tipo='+tipo+'&id_vitacora='+id_vitacora+'&rdb='+rdb+'&curso='+curso;
		//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  	   if(data==1){
						   alert("Se Cargaron los Datos");
						   cargartablaDerExt();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
	
				$('#txtFECHA8').val("");
				$('#cmb_periodos8').val("");
				$('#obserDerExt').val("");
				$('#cmbDOC8').val("");
				$('#bottoncontro8').html('<br><input name="crearDerExt" type="button" onClick="cargardatos8(0)" value="Crear" class="botonXX"/>');
				
				
	 }// fin funcion cargadatos	DerExt
	 
	 function cargartablaDerExt(){
	  var rdb="<?=$institucion;?>"
	var rut_alumno = "<?=$alumno;?>"
	//alert(rdb);
	var parametros = "funcion=26&rut_alumno="+rut_alumno+"&rdb="+rdb;
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_evaluadores8').html(data);
						//reseteo();
						$("#flex8").flexigrid({
								width : 830,
								height : 100
							});
						}
				     }
		         })
	          } // fin funcion cargartabla Derivacion Ext.
			  
			  
			  
	function DialogDerExt(id_vitacora){
	 
	 var rdb= "<?=$institucion;?>"
	 var curso = "<?=$curso?>"
	 var parametros = "funcion=51&id_vitacora="+id_vitacora+"&rdb="+rdb+"&curso="+curso;
	  // alert(parametros);
	   
	    $.ajax({
	  url:'cont_vitacoraAlumnos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //alert(data);
		$("#dialogoDerExt").html(data);
			   $("#dialogoDerExt").dialog({
				  modal: true,
				  title: "Derivaci&oacute;n Externa",
				  width: 600,
				 
				  
				    buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		  }
	  });
	 
	 
	 }				  
			  
			  
	function buscarDerExt(id_vitacora){
	var texto
    texto = "El numero de opciones del select: " + document.Formulariolista.cmb_periodos8.length
    var indice = document.Formulariolista.cmb_periodos8.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmb_periodos8.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogido = document.Formulariolista.cmb_periodos8.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogido
	 
	   var parametros = "funcion=27&id_vitacora="+id_vitacora;
	   //alert(parametros);
			$.ajax({
			  url:'cont_vitacoraAlumnos.php',
			  type:'post',
			  //dataType: 'json',
			  data:parametros,
			  success:function(data){
				 // alert(data);
						if(data!=0){
						
						 $('#respuestabuscarDerExt').html(data);			  
						var tomaperiodoDerExt = $('#_nombreper_DerExt').val();
						
						var tomasituacionDerExt = $('#_situ_DerExt').val();
						var tomaDocenteDerExt = $('#nom_docente_DerExt').val();
						 var iddelperiodoDerExt = $('#_id_periodo_DerExt').val();
						 var rut_empleDerExt = $('#_docente_DerExt').val();
						 var id_evaDerExt= $('#_id_concepto_vitacora_DerExt').val();
						 
						
						 var largocomboperDerExt = document.Formulariolista.cmb_periodos8.options.length;
						// var largocomboAlum = document.Formulariolista.cmbAlum.options.length;
						 var largocomboempDerExt = document.Formulariolista.cmbDOC8.options.length;
						 var largocomboavaluadorDerExt= document.Formulariolista.cmbDerExt.options.length;
						 
						for(i=0;i<largocomboperDerExt;i++){
							if(document.Formulariolista.cmb_periodos8.options[i].value == iddelperiodoDerExt){
								document.Formulariolista.cmb_periodos8.selectedIndex = i;
	                             }
							 }  
					    
							 
					    for(i=0;i<largocomboempDerExt;i++){
							if(document.Formulariolista.cmbDOC8.options[i].value == rut_empleDerExt){
								document.Formulariolista.cmbDOC8.selectedIndex = i;
	                             }
							 }  
							 
					    for(i=0;i<largocomboavaluadorDerExt;i++){
							if(document.Formulariolista.cmbDerExt.options[i].value == id_evaDerExt){
								document.Formulariolista.cmbDerExt.selectedIndex = i;
	                             }
							 }  		 
						
						
						$('#txtFECHA8').val($('#_ano_DerExt').val());
						$('#obserDerExt').val($('#_obs_DerExt').val());
						$('#obserDerExt').focus();	
	$('#bottoncontro8').html('<br><input name="Modificar8" id="Modificar8" type="button" class="botonXX" onClick="modificaDerExt()" value="Modificar" />');
	
						}else{
						  alert("Error al Cargar");
						}
				 }
			 })
		}	
	
	
		function modificaDerExt(){
	
		if($('#cmb_periodos8').val()==0){
			alert("Debe Seleccionar Periodo");
			return false;
		}
		if($('#txtFECHA8').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmbDerExt').val()=="0"){
			alert("Debe Seleccionar Docente");
			return false;
		}
		
				
		if($('#obserDerExt').val()==""){
			alert("Debe Escribir Observación");
			$('#obserDerExt').focus();
			return false;
		}
		
		var ano = "<?=$ano;?>"
		var rutalumno = "<?=$alumno;?>"
		var tipo='8';
		var id_vitacora=$('#_id_vitacora_DerExt').val();
		var f='28';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos8').val()+"&fecha="+$('#txtFECHA8').val()+"&evaluador="+$('#cmbDerExt').val()+"&docente="+$('#cmbDOC8').val()+"&obser="+$('#obserDerExt').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&tipo='+tipo+'&id_vitacora='+id_vitacora;
		//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  	   if(data==1){
						   alert("Datos Modificados");
						   cargartablaDerExt();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
	
				$('#txtFECHA8').val("");
				$('#cmb_periodos8').val("");
				$('#obserDerExt').val("");
				$('#cmbDOC8').val("");
				$('#cmbDerExt').val("");
				$('#bottoncontro8').html('<br><input name="crearDerExt" type="button" onClick="cargardatos8(0)" value="Crear" class="botonXX"/>');
				
	 }// fin funcion Modifica Datos Derivacion Ext	
		
	
		function EliminaDerExt(de){
			var parametros = "funcion=29&id_vitacora="+de;
			 if(!confirm("Seguro que desea eliminar!")) {
				 return false;
			 }else{
			$.ajax({
				url:'cont_vitacoraAlumnos.php',
				data:parametros,
				type:'POST',
				success:function(data){
					if(data==0){
						alert("Error en la Eliminación");
					}else{
						cargartablaDerExt();
						alert("Datos Eliminados");
						
					}
				}
			})
		 }
 }
 
 
 	function habilitacombo9(){
	
	var texto
    texto =  document.Formulariolista.cmbAcTom.length
    var indice = document.Formulariolista.cmbAcTom.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmbAcTom.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogido = document.Formulariolista.cmbAcTom.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogido
	//alert(valor);
	var num=26;
	
    //alert(textoEscogido);
		if(valor == num){
		document.Formulariolista.cmbDOC9.disabled =false;
		}else{
		document.Formulariolista.cmbDOC9.disabled =true;
		}
	}		
	
	function cargardatos9(){
	
		if($('#cmb_periodos9').val()==0){
			alert("Debe Seleccionar Periodo");
			return false;
		}
		if($('#txtFECHA9').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmbAcTom').val()=="0"){
			alert("Debe Seleccionar Evaluador");
			return false;
		}
		
		if(document.Formulariolista.cmbDOC9.disabled ==false){
			if($('#cmbDOC9').val()=="0"){
			alert("Debe Seleccionar Docente");
			return false;
		}
			}
			
		if($('#obserAcTom').val()==""){
			alert("Debe Escribir Observación");
			$('#obserAcTom').focus();
			return false;
		}
		
		var nroAno = "<?=$nro_ano;?>"
		var fecha = $('#txtFECHA9').val()
		var array_separafecha = fecha.split("/")
		var dia =  array_separafecha[0];
		var mes =  array_separafecha[1];
		var ano =  array_separafecha[2];
		
		if(nroAno!=ano){
			alert("debe seleccionar el mismo año al del periodo");
			return false;
		}
		
		var curso="<?=$curso?>"
		var rdb = "<?=$institucion;?>"
		var ano = "<?=$ano;?>"
		var rutalumno = "<?=$alumno;?>"
		var tipo='9';
		var id_vitacora=$('#_id_vitacora').val();
		var f='30';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos9').val()+"&fecha="+$('#txtFECHA9').val()+"&evaluador="+$('#cmbAcTom').val()+"&docente="+$('#cmbDOC9').val()+"&obser="+$('#obserAcTom').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&tipo='+tipo+'&id_vitacora='+id_vitacora+'&rdb='+rdb+'&curso='+curso;
		//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  	   if(data==1){
						   alert("Se Cargaron los Datos");
						   cargartablaAcTom();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
	
				$('#txtFECHA9').val("");
				$('#cmb_periodos9').val("");
				$('#obserAcTom').val("");
				$('#cmbDOC9').val("");
				$('#bottoncontro9').html('<br><input name="crearAcTom" type="button" onClick="cargardatos9(0)" value="Crear" class="botonXX"/>');
				
				
	 }// fin funcion cargadatos	AcTom
	 
	 
	  function cargartablaAcTom(){
	  var rdb="<?=$institucion;?>"
	var rut_alumno = "<?=$alumno;?>"
	//alert(rdb);
	var parametros = "funcion=31&rut_alumno="+rut_alumno+"&rdb="+rdb;
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_evaluadores9').html(data);
						//reseteo();
						$("#flex9").flexigrid({
								width : 830,
								height : 100
							});
						}
				     }
		         })
	          } // fin funcion cargartabla Accuerdos Tom.

		
		function DialogAcTom(id_vitacora){
	 
	 var rdb= "<?=$institucion;?>"
	 var curso = "<?=$curso?>"
	 var parametros = "funcion=52&id_vitacora="+id_vitacora+"&rdb="+rdb+"&curso="+curso;
	  // alert(parametros);
	   
	    $.ajax({
	  url:'cont_vitacoraAlumnos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //alert(data);
		$("#dialogoAcTom").html(data);
			   $("#dialogoAcTom").dialog({
				  modal: true,
				  title: "Acuerdos Tomados",
				  width: 600,
				 
				  
				    buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		  }
	  });
	 
	 
	 }				  


		function buscarAcTom(id_vitacora){
	var texto
    texto = "El numero de opciones del select: " + document.Formulariolista.cmb_periodos9.length
    var indice = document.Formulariolista.cmb_periodos9.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmb_periodos9.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogido = document.Formulariolista.cmb_periodos9.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogido
	 
	   var parametros = "funcion=32&id_vitacora="+id_vitacora;
	  // alert(parametros);
			$.ajax({
			  url:'cont_vitacoraAlumnos.php',
			  type:'post',
			  //dataType: 'json',
			  data:parametros,
			  success:function(data){
				 // alert(data);
						if(data!=0){
						
						 $('#respuestabuscarAcTom').html(data);			  
						var tomaperiodoAcTom = $('#_nombreper_AcTom').val();
						
						var tomasituacionAcTom = $('#_situ_AcTom').val();
						var tomaDocenteAcTom = $('#nom_docente_AcTom').val();
						 var iddelperiodoAcTom = $('#_id_periodo_AcTom').val();
						 var rut_empleAcTom = $('#_docente_AcTom').val();
						 var id_evaAcTom= $('#_id_concepto_vitacora_AcTom').val();
						 
						
						 var largocomboperAcTom = document.Formulariolista.cmb_periodos9.options.length;
						// var largocomboAlum = document.Formulariolista.cmbAlum.options.length;
						 var largocomboempAcTom = document.Formulariolista.cmbDOC9.options.length;
						 var largocomboavaluadorAcTom= document.Formulariolista.cmbAcTom.options.length;
						 
						for(i=0;i<largocomboperAcTom;i++){
							if(document.Formulariolista.cmb_periodos9.options[i].value == iddelperiodoAcTom){
								document.Formulariolista.cmb_periodos9.selectedIndex = i;
	                             }
							 }  
					    
							 
					    for(i=0;i<largocomboempAcTom;i++){
							if(document.Formulariolista.cmbDOC9.options[i].value == rut_empleAcTom){
								document.Formulariolista.cmbDOC9.selectedIndex = i;
	                             }
							 }  
							 
					    for(i=0;i<largocomboavaluadorAcTom;i++){
							if(document.Formulariolista.cmbAcTom.options[i].value == id_evaAcTom){
								document.Formulariolista.cmbAcTom.selectedIndex = i;
	                             }
							 }  		 
						
						
						$('#txtFECHA9').val($('#_ano_AcTom').val());
						$('#obserAcTom').val($('#_obs_AcTom').val());
						$('#obserAcTom').focus();	
	$('#bottoncontro9').html('<br><input name="Modificar9" id="Modificar9" type="button" class="botonXX" onClick="modificaAcTom()" value="Modificar" />');
	
						}else{
						  alert("Error al Cargar");
						}
				 }
			 })
		}		

		
		function modificaAcTom(){
	
		if($('#cmb_periodos9').val()==0){
			alert("Debe Seleccionar Periodo");
			return false;
		}
		if($('#txtFECHA9').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmbAcTom').val()=="0"){
			alert("Debe Seleccionar Docente");
			return false;
		}
		
				
		if($('#obserAcTom').val()==""){
			alert("Debe Escribir Observación");
			$('#obserAcTom').focus();
			return false;
		}
		
		var ano = "<?=$ano;?>"
		var rutalumno = "<?=$alumno;?>"
		var tipo='9';
		var id_vitacora=$('#_id_vitacora_AcTom').val();
		var f='33';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos9').val()+"&fecha="+$('#txtFECHA9').val()+"&evaluador="+$('#cmbAcTom').val()+"&docente="+$('#cmbDOC9').val()+"&obser="+$('#obserAcTom').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&tipo='+tipo+'&id_vitacora='+id_vitacora;
		//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  	   if(data==1){
						   alert("Datos Modificados");
						   cargartablaAcTom();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
	
				$('#txtFECHA9').val("");
				$('#cmb_periodos9').val("");
				$('#obserAcTom').val("");
				$('#cmbDOC9').val("");
				$('#cmbAcTom').val("");
				$('#bottoncontro9').html('<br><input name="crearAcTom" type="button" onClick="cargardatos9(0)" value="Crear" class="botonXX"/>');
				
	 }// fin funcion Modifica Datos Derivacion Ext	
		

	function EliminaAcTom(at){
			var parametros = "funcion=34&id_vitacora="+at;
			 if(!confirm("Seguro que desea eliminar!")) {
				 return false;
			 }else{
			$.ajax({
				url:'cont_vitacoraAlumnos.php',
				data:parametros,
				type:'POST',
				success:function(data){
					if(data==0){
						alert("Error en la Eliminación");
					}else{
						cargartablaAcTom();
						alert("Datos Eliminados");
						
					}
				}
			})
		 }
 }
 
 
 //destaca por
 
 function cargardatos2(){
	
		if($('#cmb_periodos2').val()==0){
			alert("Debe Seleccionar Periodo");
			return false;
		}
		if($('#txtFECHA2').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmbdestaca1').val()=="0"){
			alert("Debe al menos una forma");
			return false;
		}
		
		var nroAno = "<?=$nro_ano;?>"
		var fecha = $('#txtFECHA2').val()
		var array_separafecha = fecha.split("/")
		var dia =  array_separafecha[0];
		var mes =  array_separafecha[1];
		var ano =  array_separafecha[2];
		
		if(nroAno!=ano){
			alert("debe seleccionar el mismo año al del periodo");
			return false;
		}
		
		var curso = "<?=$curso?>"
		var rdb= "<?=$institucion;?>"	
		var ano = "<?=$ano;?>"
		var rutalumno = "<?=$alumno;?>"
		//var tipo='2';
		var id_vitacora_destaca=$('#_id_vitacora_destaca').val();
		var f='35';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos2').val()+"&fecha="+$('#txtFECHA2').val()+"&destaca1="+$('#cmbdestaca1').val()+"&destaca2="+$('#cmbdestaca2').val()+"&destaca3="+$('#cmbdestaca3').val()+"&destaca4="+$('#cmbdestaca4').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&id_vitacora_destaca='+id_vitacora_destaca+'&rdb='+rdb+'&curso='+curso;
		//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  	   if(data==1){
						   alert("Se Cargaron los Datos");
						   cargartablaDestaca();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
				
				$('#cmbdestaca1').val("");
				$('#cmbdestaca2').val("");
				$('#cmbdestaca3').val("");
				$('#cmbdestaca4').val("");
				$('#txtFECHA2').val("");
				$('#cmbDOC2').val("");
				$('#bottoncontro2').html('<br><input name="crearDestaca" type="button" onClick="cargardatos2(0)" value="Crear" class="botonXX"/>');
				
				
	 }// fin funcion cargadatos	Destaca por
 
 
 	 function cargartablaDestaca(){
	   var rdb="<?=$institucion;?>"
	var rut_alumno = "<?=$alumno;?>"
	//alert(rdb);
	var parametros = "funcion=36&rut_alumno="+rut_alumno+"&rdb="+rdb;
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_evaluadores2').html(data);
						//reseteo();
						$("#flex2").flexigrid({
								width : 830,
								height : 100
							});
						}
				     }
		         })
	          } // fin funcion cargartabla
			  
			  
	 function DialogDestaca(id_vitacora_destaca){
	 
	 var rdb= "<?=$institucion;?>"
		var curso = "<?=$curso?>"
	   var parametros = "funcion=46&id_vitacora_destaca="+id_vitacora_destaca+"&rdb="+rdb+"&curso="+curso;
	  // alert(parametros);
	   
	    $.ajax({
	  url:'cont_vitacoraAlumnos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#dialogDestaca").html(data);
			   $("#dialogDestaca").dialog({
				  modal: true,
				  title: "Destaca Por",
				  width: 500,
				 
				    buttons: {
					
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		  }
	  });
	 
	 
	 }		  
			  
			  
			  
			  
		function buscarDestaca(id_vitacora_destaca){
	var texto
    texto = "El numero de opciones del select: " + document.Formulariolista.cmb_periodos2.length
    var indice = document.Formulariolista.cmb_periodos2.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmb_periodos2.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogido = document.Formulariolista.cmb_periodos2.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogido
	 
	   var parametros = "funcion=37&id_vitacora_destaca="+id_vitacora_destaca;
	   //alert(parametros);
			$.ajax({
			  url:'cont_vitacoraAlumnos.php',
			  type:'post',
			  //dataType: 'json',
			  data:parametros,
			  success:function(data){
				 // alert(data);
						if(data!=0){
						$('#respuestabuscarDestaca').html(data);			  
						var tomaperiodoDestaca = $('#_nombreper_Destaca').val();
						var iddelperiodoDestaca = $('#_id_periodo_Destaca').val();
						 
						var tomadestaca1 = $('#_destaca1').val();
						var tomadestaca2 = $('#_destaca2').val();
						var tomadestaca3 = $('#_destaca3').val();
	    				var tomadestaca4 = $('#_destaca4').val();
						 
						 var largocomboperDestaca = document.Formulariolista.cmb_periodos2.options.length;
						// var largocomboAlum = document.Formulariolista.cmbAlum.options.length;
						 var largocombodestaca1 = document.Formulariolista.cmbdestaca1.options.length;
						 var largocombodestaca2 = document.Formulariolista.cmbdestaca2.options.length;
						 var largocombodestaca3 = document.Formulariolista.cmbdestaca3.options.length;
						 var largocombodestaca4 = document.Formulariolista.cmbdestaca4.options.length;
						 
						for(i=0;i<largocomboperDestaca;i++){
							if(document.Formulariolista.cmb_periodos2.options[i].value == iddelperiodoDestaca){
								document.Formulariolista.cmb_periodos2.selectedIndex = i;
	                             }
							 }  
					    
							 
					    for(i=0;i<largocombodestaca1;i++){
							if(document.Formulariolista.cmbdestaca1.options[i].value == tomadestaca1){
								document.Formulariolista.cmbdestaca1.selectedIndex = i;
	                             }
							 }  
							 
					     for(i=0;i<largocombodestaca2;i++){
							if(document.Formulariolista.cmbdestaca2.options[i].value == tomadestaca2){
								document.Formulariolista.cmbdestaca2.selectedIndex = i;
	                             }
							 }  
							 
						 for(i=0;i<largocombodestaca3;i++){
							if(document.Formulariolista.cmbdestaca3.options[i].value == tomadestaca3){
								document.Formulariolista.cmbdestaca3.selectedIndex = i;
	                             }
							 }  	 
							 
						 for(i=0;i<largocombodestaca4;i++){
							if(document.Formulariolista.cmbdestaca4.options[i].value == tomadestaca4){
								document.Formulariolista.cmbdestaca4.selectedIndex = i;
	                             }
							 }  	 
						
						
			
				$('#txtFECHA2').val($('#_ano_Destaca').val());
	$('#bottoncontro2').html('<br><input name="Modificar2" id="Modificar2" type="button" class="botonXX" onClick="modificaDestaca()" value="Modificar" />');
	$('#Modificar2').focus();
						}else{
						  alert("Error al Cargar");
						}
				 }
			 })
		}			  
		
		
		function modificaDestaca(){
	
		if($('#cmb_periodos2').val()==0){
			alert("Debe Seleccionar Periodo");
			return false;
		}
		if($('#txtFECHA2').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($('#cmbdestaca1').val()=="0"){
			alert("Debe al menos una forma");
			return false;
		}
		
		var ano = "<?=$ano;?>"
		var rutalumno = "<?=$alumno;?>"
		//var tipo='2';
		var id_vitacora_destaca=$('#_id_vitacora_Destaca').val();
		var f='38';
		
		var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos2').val()+"&fecha="+$('#txtFECHA2').val()+"&destaca1="+$('#cmbdestaca1').val()+"&destaca2="+$('#cmbdestaca2').val()+"&destaca3="+$('#cmbdestaca3').val()+"&destaca4="+$('#cmbdestaca4').val()+'&ano='+ano+"&rutalumno="+rutalumno+'&id_vitacora_destaca='+id_vitacora_destaca;
		//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  	   if(data==1){
						   alert("Se Cargaron los Datos");
						   cargartablaDestaca();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
				
				$('#cmbdestaca1').val("");
				$('#cmbdestaca2').val("");
				$('#cmbdestaca3').val("");
				$('#cmbdestaca4').val("");
				$('#txtFECHA2').val("");
				$('#cmbDOC2').val("");
				$('#bottoncontro2').html('<br><input name="crearDestaca" type="button" onClick="cargardatos2(0)" value="Crear" class="botonXX"/>');
				$('#bottoncontro2').focus();
				
				
	 }// fin funcion cargadatos	Destaca por
		

	function EliminaDestaca(des){
			var parametros = "funcion=39&id_vitacora_destaca="+des;
			 if(!confirm("Seguro que desea eliminar!")) {
				 return false;
			 }else{
			$.ajax({
				url:'cont_vitacoraAlumnos.php',
				data:parametros,
				type:'POST',
				success:function(data){
					if(data==0){
						alert("Error en la Eliminación");
					}else{
						cargartablaDestaca();
						alert("Datos Eliminados");
						
					}
				}
			})
		 }
 }
 
 
 		 function cargartablaramos(){
	   var rdb="<?=$institucion;?>"
	var rut_alumno = "<?=$alumno;?>"
	var periodo = $('#cmb_periodos_Ren').val();
	var nro_ano = "<?=$nro_ano;?>"
	//alert(rdb);
	var parametros = "funcion=40&rut_alumno="+rut_alumno+"&rdb="+rdb+"&periodo="+periodo+"&nro_ano="+nro_ano;
	//alert(parametros);
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#cargaramos').html(data);
						//reseteo();
						$("#flex3").flexigrid({
								width : 800,
								height : 350
							});
							cargartablaRendimiento();
							buscarperiodos();
						}
				     }
		         })
	          } // fin funcion cargartabla Accuerdos Tom.
			
		
		function buscarNotas(id_ramo){
			
			texto = "El numero de opciones del select: " + document.Formulariolista.cmb_periodos_Ren.length
    var indice = document.Formulariolista.cmb_periodos_Ren.selectedIndex
    texto += "nIndice de la opcion escogida: " + indice
    var valor = document.Formulariolista.cmb_periodos_Ren.options[indice].value
    texto += "nValor de la opcion escogida: " + valor
    var textoEscogidonota = document.Formulariolista.cmb_periodos_Ren.options[indice].text
    texto += "nTexto de la opcion escogida: " + textoEscogidonota
			
			
	var rdb="<?=$institucion;?>"
	var rut_alumno = "<?=$alumno;?>"
	var periodo = $('#cmb_periodos_Ren').val();
	var nro_ano = "<?=$nro_ano;?>"
	var parametros = "funcion=41&rut_alumno="+rut_alumno+"&rdb="+rdb+"&periodo="+periodo+"&nro_ano="+nro_ano+"&id_ramo="+id_ramo+"&textoEscogidonota="+textoEscogidonota;

    $.ajax({
	  url:'cont_vitacoraAlumnos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#carganotas").html(data);
			   $("#carganotas").dialog({
				  modal: true,
				  title: "Notas Parciales",
				  width: 950,
				  minWidth: 400,
				  maxWidth: 500,
				  
				    buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		  }
	  });
												
					
  };
  
  
  function cargardatosRendimiento(id_ramo,contador){
	
		if($('#cmb_periodos_Ren').val()==0){
			alert("Debe Seleccionar Periodo");
			return false;
		}
		
		if($('#txtFECHA10').val()==""){
			alert("Debe Seleccionar Fecha");
			return false;
		}
		
		if($("#observacionren"+contador).get(0).value==""){
			alert("Debe Escribir una Observacion ");
			return false;
		}
		
		var nroAno = "<?=$nro_ano;?>"
		var fecha = $('#txtFECHA10').val()
		var array_separafecha = fecha.split("/")
		var dia =  array_separafecha[0];
		var mes =  array_separafecha[1];
		var ano =  array_separafecha[2];
		
		if(nroAno!=ano){
			alert("debe seleccionar el mismo año al del periodo");
			return false;
		}
		
		var rdb= "<?=$institucion;?>"	
		var ano = "<?=$ano;?>"
		var rutalumno = "<?=$alumno;?>"
		var curso="<?=$curso?>"
		var observacion = $("#observacionren"+contador).get(0).value;
		var nota = $("#nota"+contador).get(0).value;
		
		if(nota<=0){
		alert("El Alumno no tiene Notas")
			return false;
			}
		
	var f='42';
	var parametros = "funcion="+f+"&periodo="+$('#cmb_periodos_Ren').val()+"&fecha="+$('#txtFECHA10').val()+'&ano='+ano+"&rutalumno="+rutalumno+"&observacion="+observacion+'&id_ramo='+id_ramo+'&rdb='+rdb+'&nota='+nota+'&curso='+curso;
	alert(parametros);
	if(!confirm("Seguro que desea Guardar!!\nEstos Datos no son modificables!!")) {
		     return false;
			 }else{
		  $.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				  //alert(data);
				  if(data==1){
				alert("Se Cargaron los Datos");
				cargartablaRendimiento();
				  }else{
			    alert("Error... Ya existen Datos");
				cargartablaRendimiento();
			    }
			}
		});
				
				$("#observacionren"+contador).val("");
				$('#txtFECHA10').val("");
				//$('#cmb_periodos_Ren').val("0");
	 }// fin funcion cargadatos	Rendimiento
  
  }
		
		
	 function cargartablaRendimiento(){
    var rdb="<?=$institucion;?>"
	var rut_alumno = "<?=$alumno;?>"
	var periodo = $('#cmb_periodos_Ren').val();
	var nro_ano = "<?=$nro_ano;?>"
	var parametros = "funcion=43&rut_alumno="+rut_alumno+"&rdb="+rdb+"&periodo="+periodo+"&nro_ano="+nro_ano;
	//alert(parametros);
	//return false;
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_evaluadores10').html(data);
						
						$("#flexRen").flexigrid({
								width : 500,
								height : 100
							});
						}
				     }
		         })
	          } // fin funcion cargartabla Accuerdos Tom.	
		
		
	function cargadatosRendimiento(id_ano,contador){
			
	var rdb="<?=$institucion;?>"
	var rut_alumno = "<?=$alumno;?>"
	var periodo = $('#cmb_periodos_Ren').val();
	var nro_ano = $("#id_del_ano"+contador).val();
	
	var parametros = "funcion=44&rut_alumno="+rut_alumno+"&rdb="+rdb+"&periodo="+periodo+"&nro_ano="+nro_ano;
	//alert(parametros);
	//return false;
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#verrendim').html(data);
						$("#verrendim").dialog({
							modal: true,
				            title: "Observaciones",
							width : 600,
							height : 300,
								 buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
							});
						}
				     }
		         })
	          } // fin funcion	
			  
			  
			  
	function ingreso_apoderado(){
          
	$("#formulario_apoderado").html('<br><form name="ingresoapo" id="ingresoapo" ><table width="366"><tr><td width="180"><label>Rut Apoderado:</label></td><td width="174"><input name="rut_apo" id="rut_apo" type="text" size="15" maxlength="15" /></td></tr><tr><td><label>Nombres:</label></td><td><input name="nombres_apo" id="nombres_apo" type="text" size="15" maxlength="15" /></td></tr><tr><td><label>Apellido Paterno:</label></td><td><input name="apaterno_apo" id="apaterno_apo" type="text" size="15" maxlength="15" /></td></tr><tr><td><label>Apellido Materno:</label></td><td><input name="amaterno_apo" id="amaterno_apo" type="text" size="15" maxlength="15" /></td></tr><tr><td><label>Telefono:</label></td><td><input name="telefono_apo" id="telefono_apo" type="text" size="15" maxlength="15" /></td></tr><tr><td><label>EMail:</label></td><td><input name="email_apo" id="email_apo" type="text" size="15" maxlength="30" /></td></tr></table></form>');
		   
	$("#formulario_apoderado").dialog({ 
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
		 if($('#rut_apo').val()==0){
			alert("Escriba Rut del Apoderado");
			$('#rut_apo').focus();
			return false;
		}
		 if($('#nombres_apo').val()==0){
			alert("Escriba Nombres");
			$('#nombres_apo').focus();
			return false;
		}
		if($('#apaterno_apo').val()==0){
			alert("Escriba Apellido Paterno");
			$('#apaterno_apo').focus();
			return false;
		}
		if($('#amaterno_apo').val()==0){
			alert("Escriba Apellido Materno");
			$('#amaterno_apo').focus();
			return false;
		}
		if($('#telefono_apo').val()==0){
			alert("Escriba Telefono");
			$('#telefono_apo').focus();
			return false;
		}
		if($('#email_apo').val()==0){
			alert("Escriba Mail");
			$('#email_apo').focus();
			return false;
		}
		   ingresar_apoderado();
		  
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }) 
		   
  }
  
  function ingresar_apoderado(){
		
	var rut_alumno = "<?=$alumno;?>"	
	var parametros = "funcion=53&rut_apo="+$("#rut_apo").val()+"&nombre_apo="+$("#nombres_apo").val()+"&apaterno_apo="+$("#apaterno_apo").val()+"&amaterno_apo="+$("#amaterno_apo").val()+"&telefono_apo="+$("#telefono_apo").val()+"&email_apo="+$("#email_apo").val()+"&rut_alumno="+rut_alumno;
	//alert(parametros);
	//return false;
		  $.ajax({
			url:"cont_vitacoraAlumnos.php",
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
					if(data != 0){
					   alert("Error al Guardar Datos");
					}else{
						
					  alert("Datos Guardados");
					   cargaselectApo();
					 //cargarinicio();
					  //document.Formulariolista.cmbAPO.reload();
					//$('#entrevista_apoderado').focus();
					  return true;
					}
		        }
		    }) 
      }		  
			  
				  
 
   function cargaselectApo(){
	var curso = "<?=$curso;?>";
   var ano = "<?=$ano;?>"
   var rutusuario = "<?=$alumno;?>"	
  	   
    var parametros="funcion=54&rutusuario="+rutusuario;
	//alert(parametros);
	
		$.ajax({
		  url:'cont_vitacoraAlumnos.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#selectApo').html(data);
						
						}
				     }
		         })
	          } // fin funcion cargartabla
			  
   
			  
function cargarinicio(x){ 
 var id = x;
 cargaContenido(id); 
	}


function enviapag2(form){
	
   var curso = "<?=$curso;?>";
   var ano = "<?=$ano;?>"
   var rutusuario = "<?=$alumno;?>"	
      
   $("#cabeza").html('Bitacora Alumno');
      	
   var x ='<br><h5>Espere Por Favor Procesando...</h5><br>';
   x = x+'<img src="../../../../clases/img_jquery/ajax-loader.gif"><br><br>'; 
   $("#modulodatos").html(x);
    var parametros='curso='+curso+'&ano='+ano+"&rutusuario="+rutusuario;
	//alert(parametros);
    $.ajax({
	  url:'listarAlumnos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#modulodatos").html(data);
	 }
      
	  })
   }	


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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
	

</script>


<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad= "<? echo"cargarinicio();";?>



<? if ($r == "si"){ ?>;MM_openBrWindow('v_respaldo.php','','width=250,height=200')<? }?>">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><? include("../../../../../cabecera/menu_superior.php"); ?></td>
        </tr>
		<tr align="left" valign="top"> 
			<td height="83" colspan="3">
				<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="0%" height="363" align="left" valign="top"> </td>
                      <td width="100%" align="left" valign="top">
						  <table width="100%" border="0" cellpadding="0" cellspacing="0">
							  <tr> 
								<td align="left" valign="top">&nbsp;</td>
							  </tr>
							  <tr> 
								<td height="395" align="left" valign="top"> 
								  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
									<tr> 
									  <td height="390" valign="top">
									  
								  <!--inicio codigo nuevo pagina con fallas de tablas-->
								  
								 
								 
								
				<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width="100%">
						
						<TR valign="top">
							<TD width="117" align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong>								</FONT>							</TD>
							<TD width="1%">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD width="51%">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
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
													echo trim($nroAno);
													$situacion = $fila1['situacion']; 
												}
											}
										?>
									</strong>								</FONT>							</TD>
							<td width="33%" rowspan="2"><table align="right">
							<?
							$foto = trim($fila['nom_foto']);
							
							?>
							
							  <tr><td><img src="../../../../../infousuario/images/<?=trim($alumno)  ?>" width="80" height="90"> </td></tr>
							  </table></td>
						</TR>
						<TR>
							<TD align=left valign="top">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>CURSO</strong>								</FONT>							</TD>
							<TD valign="top">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD valign="top">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
										   
											 $qry="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, tipo_ensenanza.cod_tipo as tpe FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".trim($curso).")) and curso.id_ano = '$ano'";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (106)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														//exit();
													}
													
													if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
														echo "PRIMER NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==121987) or ($fila1['cod_decreto']==1521989)) ){
														echo "PRIMER CICLO"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==1) and ($fila1['cod_decreto']==1000)){
														echo "SALA CUNA"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==2) and (($fila1['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
														echo "SEGUNDO NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==121987) ){
														echo "SEGUNDO CICLO"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==1000)){
														echo "NIVEL MEDIO MENOR"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==3) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
														echo "TERCER NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==3) and ($fila1['cod_decreto']==1000)){
														echo "NIVEL MEDIO MAYOR"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==4) and ($fila1['cod_decreto']==1000)){
														echo "TRANSICIÓN 1er NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==5) and ($fila1['cod_decreto']==1000)){
														echo "TRANSICIÓN 2do NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else{
														echo $fila1['grado_curso']."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}

													
													//echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
												}
											}
										?>
									</strong>								</FONT>							</TD>
							</TR>
					</TABLE>					
																																																										
															 
                    
                  
			        <!-- codigo nuevo con pestañas -->

<div class="tableindex" id="cabeza" >Bitacora Alumno
 </div>
<div id="boton" align="right">                    
<input type="button" name="volver" class="botonXX" onClick="history.back(-1)" value="VOLVER">
</div>



<div id="modulodatos" align="center" >
 </div>

                    
                    
			 		<!--fin codigo nuevo  paginas con fallas de tablas--->
							  </td>
                                </tr>
                              </table>
						    </td>
                          </tr>
                        </table>
					</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php");?></td>
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
