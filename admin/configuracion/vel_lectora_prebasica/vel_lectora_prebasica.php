 <?php
 
include('../../../util/header.inc');


    
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$docente		= 5; //Codigo Docente
	$frmModo		=$_FRMMODO;
	$alumno			=$alumno;	
	$_POSP = 3;  
	$_bot = 8;

	



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../clases/jqueryui/jquery-ui-1.8.6.custom.css">
<script type="text/javascript" src="../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script language="JavaScript" src="../../clases/jqueryui/jquery.ui.core.js"></script>
<script type="text/javascript">

	$(document).ready(function() {
	
		/*CargaGrado();
		CargaConcepto();*/
		cargaArea();
		cargaCreador();
		cargaCalLectora();
	
		
      });

</script>



	<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
.conscroll {
overflow: auto;
width: 500px;
height: 400px;
clear:both;
} 
.salto{
page-break-after:always;
}
.Estilo5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}

.mayuscula{text-transform:uppercase;}
-->
    </style>

	
<SCRIPT language="JavaScript">


	
	function CargaConcepto(){
		var rdb="<?=$institucion;?>"
		 funcion=3;
	var parametros='funcion='+funcion+'&rdb='+rdb;
	//alert(parametros);	
	
	$.ajax({
	  url:'cont_velocidad_lectora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// alert(data);
	    $("#select_concepto").html(data);
		  }
	  })
	} 
	
	
	function ventana_ingreso(){
			
			var html="";
				
			html = html+'<label>Nombre Concepto : <input type="input" name="nombre_funcion" id="nombre_funcion"  value="" /></label>';
			html = html+'<input type="hidden" name="id_funcion" id="id_funcion"  value="" />';
			
			$('#procesar_datos').html(html);
			 
			$('#procesar_datos').dialog({ autoOpen:true,width:500,height:200,modal:true,
					buttons: {
					  'Aceptar': function( ){
						funcion_guardar_funcion(); 
						//$(this).dialog('close');
					  },
					  'Cancelar': function(){ 
					   $(this).dialog('close');
					  
					  }
					 }
				   });
		
			} // fin funcion	   


		function funcion_guardar_funcion(){
		  
		  if($('#nombre_funcion').val()==""){
			alert("Escriba Nombre Concepto");
			$('#nombre_funcion').focus();
			return false;
		  }
		 var rdb="<?=$institucion;?>"
	var parametros = "funcion=4&rdb="+rdb+"&nombre_funcion="+$("#nombre_funcion").val();
		// alert(parametros);	
		 
		 $.ajax({
		   url:'cont_velocidad_lectora.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data)
				  if(data==1){
                   alert("Datos Guardados");
				   $('#procesar_datos').dialog('close');
				   CargaConcepto(rdb);
				  }else{
		           alert("Error al Guardar Datos");				  
				  }
		      }
		  })
		}			



	function guarda_todo(){
		
		
			if($('#select_gradoCurso').val()==0){
			alert("Seleccione un Grado");
			return false;
		  }
		  if($('#txtconcepto').val()==""){
			alert("Escriba un Concepto");
			$('#txtconcepto').focus()
			return false;
		  }
		  
		  if($('#txtrango_ini').val()==""){
			alert("Escriba Nivel Inicial");
			$('#txtrango_ini').focus()
			return false;
		  }
		  if($('#txtrango_fin').val()==""){
			alert("Escriba Nivel Final");
			$('#txtrango_fin').focus()
			return false;
		  }
		  
		 var variables = $('#select_gradoCurso').val()
		  var param=variables.split("-");
		  var ensenanza=(param[0]);
		  var grado_curso=(param[1]);
		  var id_ano="<?=$ano?>";
		  var rdb="<?=$institucion;?>";
		  var id_concepto=$('#cmb_funcion').val();
			
	 var parametros = "funcion=1&ensenanza="+ensenanza+"&grado_curso="+grado_curso+"&concepto="+$('#txtconcepto').val()+"&rango_ini="+$('#txtrango_ini').val()+"&rango_fin="+$('#txtrango_fin').val()+"&id_ano="+id_ano+"&id_concepto="+id_concepto;
		 
		// alert(parametros);	
		//return false; 
		 $.ajax({
		   url:'cont_velocidad_lectora.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data)
				  if(data==1){
                   alert("Datos Guardados");
					    $("#select_gradoCurso option[value=0]").attr("selected",true);
						$('#txtconcepto').val("");
						$('#txtrango_ini').val("");
						$('#txtrango_fin').val("");
						verregistros(id_ano,rdb);
				    }else{ 
		           alert("Error al Guardar Datos");				  
				  }
				  
		      }
		  })
		}				
		
		
		
	function verregistros(){
			
		var id_ano="<?=$ano?>";	
        var rdb="<?=$institucion;?>";
		
	var parametros = "funcion=2&rdb="+rdb+"&id_ano="+id_ano;	
		//alert(parametros);
		$.ajax({
		   url:'cont_velocidad_lectora.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data)
				  if(data==0){
                 //alert("No Existen Datos");
				       	 // limpiatext();
				    }else{ 
				  //  alert("Existen Datos");
					   $('#muestradatos').html(data);
					   // $('#text_concepto').val($('#_conceptos').val());
					   //$('#text_ejemplos').val($('#_ejemplos').val());		  
				  }
				  
		      }
		  })
		}		
		
		
		function modifica_notas(){
			
		var id_ano="<?=$ano?>";	
        var rdb="<?=$institucion;?>";
		
	var parametros = "funcion=5&rdb="+rdb+"&id_ano="+id_ano;	
		//alert(parametros);
		$.ajax({
		   url:'cont_velocidad_lectora.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data)
				  if(data==0){
                 //alert("No Existen Datos");
				       	 // limpiatext();
				    }else{ 
				  //  alert("Existen Datos");
					   $('#muestradatos2').html(data);
					   
					   $("#muestradatos").hide();
					   $("#btnModifica").hide();
					   $("#muestradatos2").show();
					   $("#muestradatos3").hide();
					   // $('#text_concepto').val($('#_conceptos').val());
					   //$('#text_ejemplos').val($('#_ejemplos').val());		  
				  }
				  
		      }
		  })
		}		
		
		
	function modifica_todo(x,y){
		
				var x=x.toString();
				var y=y.toString();
				var z=x+y;
				var notaini=$('#txtranini'+z+'').val();
				var notafin=$('#txtranfin'+z+'').val();
				var idvel=$('#txtidvel'+z+'').val();
				
				var id_ano="<?=$ano?>";
		        var rdb="<?=$institucion;?>";
				
		var parametros = "funcion=6&notaini="+notaini+"&notafin="+notafin+"&idvel="+idvel;		
				
				//alert(parametros);
				
				$.ajax({
		   url:'cont_velocidad_lectora.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data)
				  if(data!=0){
					  
				   alert("Datos Modificados");
					 $("#muestradatos2").hide();
					 $("#muestradatos").show();
					 $("#btnModifica").show();
					 verregistros(id_ano,rdb);	  
                 
				       	 // limpiatext();
				    }else{ 
				    alert("Error al Modificar");
					   // $('#text_concepto').val($('#_conceptos').val());
					   //$('#text_ejemplos').val($('#_ejemplos').val());		  
				  }
				  
		      }
		  })
	 }
	 
	 
	 
	 
	function Fvolver(){
		
		 $("#muestradatos2").hide();
		  $("#muestradatos3").show();
		 $("#muestradatos").show();
		 $("#btnModifica").show();
		
		}	 
		
	
	function cargaCalLectora(){
		var rdb="<?=$institucion;?>"
		 funcion=7;
	var parametros='funcion='+funcion+'&rdb='+rdb;
		
	
	$.ajax({
	  url:'cont_velocidad_lectora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#muestradatos3").html(data);
		  }
	  })
	} 	
		
		
	function calCrear()	{
	var rdb="<?=$institucion;?>";
	var nombre=$("#tt_nombre").val();
	var sigla=$("#tt_sigla").val();
	 funcion=8;
	 var parametros ="funcion="+funcion+"&rdb="+rdb+"&nombre="+nombre+"&sigla="+sigla;
	 
	 $.ajax({
	  url:'cont_velocidad_lectora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	
	  if(data==1){
		  alert("Datos Cargados"); 
		 
	    
		cargaCalLectora();
		  }else{
			 alert("Error al guardar") ;
			  }
	   
		  }
	  })
	 
	}
		
		
function quitacal(id){
var funcion=9;
if(confirm("Seguro de eliminar este concepto?")){
var parametros = "funcion="+funcion+"&id_c="+id;
$.ajax({
	  url:'cont_velocidad_lectora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		if(data==1){
			alert("Datos eliminados")
			cargaCalLectora();
		}else{
			alert("Error al aliminar");
		}
	   // $("#muestradatos3").html(data);
		  }
	  })	
	}	
}	


function cambiaCCal(id){
	var funcion=10;
	var parametros="funcion="+funcion+"&id_c="+id;
	$.ajax({
	  url:'cont_velocidad_lectora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 var cad=data.split("_");
				
	   $("#cnom"+id).html("<input type=\"text\" id=\"txnom"+id+"\" value=\""+cad[0]+"\">");
		$("#ssig"+id).html("<input type=\"text\" id=\"txsig"+id+"\" value=\""+cad[1]+"\">");
		$("#btnn"+id).html("<input type=\"button\" value=\"Guardar\" class=\"botonXX\" onclick=\"modCalLectora("+id+")\">");
		$("#btcn"+id).html("<input type=\"button\" value=\"Cancelar\" class=\"botonXX\" onclick=\"cargaCalLectora()\">");	
		  }
	  })

}	

function modCalLectora(id){
	var funcion=11;
	var nombre= $("#txnom"+id).val();
	var sigla= $("#txsig"+id).val();
	var parametros="funcion="+funcion+"&id_c="+id+"&nombre="+nombre+"&sigla="+sigla;
	//alert(parametros)
	$.ajax({
	  url:'cont_velocidad_lectora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		if(data==1){
			alert("Datos modificados")
			cargaCalLectora();
		}else{
			alert("Error al modificar");
		}
	   // $("#muestradatos3").html(data);
		  }
	  })
}


//crear categoria
function nuevaCategoria()
{
	largo=document.getElementById('tabla_categoria').rows.length;
	var x=document.getElementById('tabla_categoria').insertRow(largo);
	j=largo;
	var y=x.insertCell(0);
	y.className="td2";
	y.id="td"+j;
	nombre_sub="sub_infor"+j;
	j=j+1;
	anterior=j-1;	
	y.innerHTML="<table ><tr><td colspan=2>Categoria "+j+"<input name=\"cat[]\" size=70 ><input name=\"boton[]\" type=\"button\" class=\"botonXX\" value=\"Nueva Sub Cat\" onclick=\"nuevaSub('"+nombre_sub+"',"+anterior+");\">&nbsp;&nbsp;&nbsp;&nbsp;<input name=\"boton[]\" type=\"button\" class=\"botonXX\" value=\"Elimina Sub Cat\" onclick=\"eliminaSub('"+nombre_sub+"')\"></td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><table id=\""+nombre_sub+"\" cellpadding=\"0\" cellspacing=\"0\"></table></td></tr></table>";
	
	$("#bg").show("");
	$("#elimina_cat1").show("");
}	


function eliminaCategoria(){
largo=document.getElementById('tabla_categoria').rows.length;

	if (largo>0){
		largo=largo-1;
		document.getElementById('tabla_categoria').rows[largo].className="a_eliminar";
		a=confirm ('se Eliminara toda la zona con color ROJO, \r\nesta seguro');
			if (a==true){
				var x=document.getElementById('tabla_categoria').deleteRow(largo);
			}else{
				document.getElementById('tabla_categoria').rows[largo].className="normal";
			}

	}
	
	if(largo==0){
	$("#bg").hide("");
	$("#elimina_cat1").hide("");
	}
}

contador_sub=-1;
function nuevaSub(cat,pos)
{	
	vhs=cat+"-----"+pos;
//	alert (vhs);
//	alert (cat);
//	cat=eval(cat);
	largo=document.getElementById(cat).rows.length;
//	alert (largo);
	var x=document.getElementById(cat).insertRow(largo);
	var y=x.insertCell(0);
	y.className="td2";
	temp=largo+1
	nombre_items="items"+pos+"_"+temp;
	temp=largo+1;
	label=pos+1;
	label=label+"."+temp;
	contador_sub=contador_sub+1;
	y.innerHTML=label+" <input name=\"sub[]\" size=70 ><input name=\"id_cat[]\" type=hidden value=\""+pos+"\"><input name=\"id_sub[]\" type=hidden  value=\""+contador_sub+"\"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<table id=\""+nombre_items+"\" ></table>";
}

function eliminaSub(subcate){
largo=document.getElementById(subcate).rows.length;

	if (largo>0){
		largo=largo-1;
		document.getElementById(subcate).rows[largo].className="a_eliminar";
		a=confirm ('se Eliminara toda la zona con color ROJO, \r\nesta seguro');
			if (a==true){
				var x=document.getElementById(subcate).deleteRow(largo);
			}else{
				document.getElementById(subcate).rows[largo].className="normal";
			}
		}
}


function cargaCreador(){
	var rdb=<?php echo $institucion; ?>;
	var funcion=12;
	var parametros="funcion="+funcion
	$.ajax({
	  url:'cont_velocidad_lectora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		
	    $("#muestradatos").html(data);
		$("#bg").hide("");
		$("#elimina_cat1").hide("");
		  }
	  })
}	

function guadaItem(){
	var rdb=<?php echo $institucion; ?>;
	var funcion=13;
	var frm=$("#frimtm").serialize();
	var parametros="funcion="+funcion+"&rdb="+rdb+"&frm="+frm;
	$.ajax({
	  url:'cont_velocidad_lectora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	
		
	    //$("#muestradatos").html(data);
		alert("Datos guardados");
		$("#tabla_categoria").html("");
		
		
		cargaArea();
		  }
	  })
	
}


function cargaArea(){
	var rdb=<?php echo $institucion; ?>;
	var funcion=14;
	var parametros="funcion="+funcion+"&rdb="+rdb;
	$.ajax({
	  url:'cont_velocidad_lectora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		
	    $("#muestradatos2").html(data);
		  }
	  })
}	

function cambiaConceptp(id){
	var funcion=15;
	var parametros="funcion="+funcion+"&id_c="+id;
	$.ajax({
	  url:'cont_velocidad_lectora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 var cad=data;
		console.log(data);		
	   $("#cnc"+id).html("<input type=\"text\" id=\"txnom"+id+"\" value=\""+cad+"\" size=70>");
		$("#btnc"+id).html("<input type=\"button\" value=\"Guardar\" class=\"botonXX\" onclick=\"modConc("+id+")\">&nbsp;<input type=\"button\" value=\"Cancelar\" class=\"botonXX\" onclick=\"cargaArea()\">");
		
		  }
	  })

}

function modConc(id){
	var funcion=16;
	var glosa= $("#txnom"+id).val();
	var parametros="funcion="+funcion+"&id_c="+id+"&glosa="+glosa;
	//alert(parametros)
	$.ajax({
	  url:'cont_velocidad_lectora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		if(data==1){
			alert("Datos modificados")
			cargaArea();
		}else{
			alert("Error al modificar");
		}
	   // $("#muestradatos3").html(data);
		  }
	  })
}
						
</script>


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
//-->
</script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><table width="100%"><tr><td><?
				include_once("../../../cabecera/menu_superior.php");
				?>
</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../menus/menu_lateral.php");
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
                                  <td><br>
                                 
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <div id="layer2"></div>
<br>
<div id="muestradatos">&nbsp;</div>
<div id="muestradatos2">&nbsp;</div>
<div id="muestradatos3">&nbsp;</div>
								 
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table>
							  
						    </td>
                          </tr>
                        </table>
						
					</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include_once("../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>
          </td>

         
          <td width="53" height="1024" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>