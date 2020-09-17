 <?php
 
 require_once('../../../../util/header.inc');
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$docente		= 5; //Codigo Docente
	$_POSP = 4;
	$_bot = 8;


$sqlF="select nro_ano from ano_escolar where id_ano=".$ano;
$resF = pg_exec($conn,$sqlF);
$nro_ano = pg_result($resF,0);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../../clases/jqueryui/jquery-ui-1.8.6.custom.css">
<script type="text/javascript" src="../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script language="JavaScript" src="../../../clases/jqueryui/jquery.ui.core.js"></script>

<script type="text/javascript">

	$(document).ready(function() {
		
		$("#txtFECHA").datepicker({
		showOn: 'both',
		changeYear:false,
		changeMonth:true,
		dateFormat: 'mm-dd-yy',
		minDate: new Date('<?php echo $nro_ano ?>/01/01'),
		maxDate: new Date('<?php echo $nro_ano ?>/12/31'),
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ],
	firstDay: 1
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']	
		
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

div.ui-datepicker{
font-size:12px;
}


    </style>

	
<SCRIPT language="JavaScript">

	function anos_acad(){
		var rdb="<?=$institucion;?>"
		 funcion=1;
	var parametros='funcion='+funcion+'&rdb='+rdb;
	//alert(parametros);	 
	$.ajax({
	  url:'Cont_AtrasosMinutosEmp.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //alert(data);
	    $("#ano_acad").html(data);
		  }
	  })
	} 
	
	
function CargaEmpleado(fecha){
	
		//alert(fecha);
		var rdb="<?=$institucion;?>"
		var funcion="carga_emp";
		
		var parametros='funcion='+funcion+'&rdb='+rdb+'&fecha='+fecha;
	//alert(parametros);
	$.ajax({
	  url:'Cont_AtrasosMinutosEmp.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 //alert(data);
	    $("#lista_empleados").html(data);
		  }
	  })
	}
		
		
 
		

function validaform(){
	
	if($("#txtFECHA").val()==""){
		alert("Escoja una fecha");
		return false;
		}
	
	var id_ano="<?=$ano?>"
	var x;
	var contador = $('#contador').val();
	var cuenta=contador-1;
	var parametros2='';
	var fecha = $("#txtFECHA").val();
	for(x=0; x <=cuenta; x++){
	var minutos=$('#minuto'+x+'').val();	
	var rut_emp=$('#rut_emp'+x+'').val();	
	var parametros="parametros"+x;
    var funcion="funcion"+x;
	/*if(!isNaN(minutos)){
	continue;
	}*/
	
	var parametros = "funcion="+funcion+'/'+"cantidad="+cuenta+'/'+id_ano+'/'+fecha+'/'+rut_emp+'/'+minutos+'*';
	
	parametros2= parametros2+parametros;
		
    }
	
   $.ajax({
			url:'procesoGuardar.php',
			data:parametros2,
			type:'POST',
			success:function(data){
		//	console.log(data);
			if(data!=0){
			alert("Datos Insertados");
			CargaEmpleado($("#txtFECHA").val());
			}else{
			alert("Error al Guardar");
		    }
	     }
      })
	}
	
	
	function modificar(rut,e){
		
		var minutos=$('#minuto'+e+'').val();
		
		//var minutos=document.getElementById('minuto'+e+'').value;
		//alert(minutos);
		if(minutos==""){
			alert("Escriba Minutos de Atraso");
			return false;			
			}
		var fecha=$("#txtFECHA").val();
		var funcion="modificaM";
		var parametros='funcion='+funcion+'&rut_emp='+rut+'&fecha='+fecha+'&minutos='+minutos;
		//alert(parametros);
		
		
		$.ajax({
				 url:'Cont_AtrasosMinutosEmp.php',
				 data:parametros,
				 type:'POST',
				 success:function(data){
				// alert(data);
				 if(data==0){
					 alert("error");
					 }else{
					 alert("Dato Modificado"); 	 
					 CargaEmpleado($("#txtFECHA").val());
						 }	 
					 }
				})
		
		
		}
	function elimina(rut){
		//alert(rut);
		var fecha=$("#txtFECHA").val();
		
		var funcion="eliminaM";
		var parametros='funcion='+funcion+'&rut_emp='+rut+'&fecha='+fecha;
		 if(!confirm("Seguro que desea Eliminar??")) { 
			return false;
			}else{
		$.ajax({
				 url:'Cont_AtrasosMinutosEmp.php',
				 data:parametros,
				 type:'POST',
				 success:function(data){
				// alert(data);
				 if(data==0){
					 alert("error");
					 }else{
					 alert("Dato Eliminado"); 	 
					 CargaEmpleado($("#txtFECHA").val());
						 }	 
					 }
				})
		}
		}
	
	
	
	function RecargaPagina(){
		location.reload();
    }
									
</script>

<script language="JavaScript" type="text/JavaScript">

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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><table width="100%"><tr><td><?
				include("../../../../cabecera/menu_superior.php");
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
						include("../../../../menus/menu_lateral.php");
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
<form name="form" id="form" method="post" action="Print_Informe_CartaFelicitacionAlumno.php" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">

  <center>
    <table width="90%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td colspan="2" class="tableindex">Buscador Avanzado </td>
      </tr>
      <tr>
      <td colspan="2">&nbsp;</td>
      </tr>
      
    <tr>
      <td width="36%" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fecha   :</td>
      <td width="64%"><div id="fecha">
      <input type="text" name="txtFECHA" id="txtFECHA" readonly onChange="CargaEmpleado(this.value)">
      </div></td>
    </tr>
   
    <tr>
      <td colspan="2"><div align="right">
        <label>
        <input name="GUARDAR" type="button" id="GUARDAR" value="GUARDAR" class="botonXX" onClick="validaform()">
        </label>
     </div></td>
      </tr>
      <tr>
      <td colspan="2">&nbsp;</td>
      </tr>
       <tr>
      <td colspan="2"><div id="lista_empleados">&nbsp;
           </div></td>
    </tr>
             
  </table>  
</center>
</form>

								 
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
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>
          </td>

         
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>