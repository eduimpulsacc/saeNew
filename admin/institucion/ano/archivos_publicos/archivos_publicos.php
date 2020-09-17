 <?php
 
 require_once('../../../../util/header.inc');
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$docente		= 5; //Codigo Docente
	$_POSP = 4;
	$_bot = 8;



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

<script language="JavaScript" src="class/jquery.form.js"></script>
<script type="text/javascript">

	$(document).ready(function() {
		
		$("#txtFECHA").datepicker({
		showOn: 'both',
		changeYear:false,
		changeMonth:true,
		dateFormat: 'mm-dd-yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es'];
		
			
		carga_tipo();
		carga_archivo();
		listoCurso();
		
		
      });


function carga_archivo(){
	 var rdb="<?=$institucion;?>";
	 var id_ano = "<?=$ano;?>";
	 funcion =3;
	 var parametros='funcion='+funcion+'&rdb='+rdb+'&id_ano='+id_ano;	
	 //alert(parametros);
	 $.ajax({
	  url:'cont_archivos_publicos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
	    $("#lista_empleados").html(data);
		  }
	  })
}

function quita(arc){
	 funcion =4;
	 var parametros='funcion='+funcion+'&arc='+arc;
	 
	 if(confirm("Desea aliminar archivo?")){
	  $.ajax({
	  url:'cont_archivos_publicos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  alert("archivo eliminado");
	   carga_archivo();
		  }
	  })
	 }
}


</script>



	<style type="text/css">
<!--
input[type=text], input[type=password], textarea {
	background: #fff;	border: solid 1px #d6d1c7;
	padding: 5px 7px;color: #1d5987;
	-webkit-border-radius: 4px;-moz-border-radius: 4px; }

textarea:focus, input[type=password]:focus, input[type=text]:focus, select :focus{
	border: 1px solid #79b7e7; background: #fff;
	outline: none; box-shadow: 0 1px 4px #c5c5a2;
	-webkit-box-shadow: 0 1px 4px #c5c5a2;
	-moz-box-shadow: 0 1px 4px #c5c5a2; }



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


	function carga_tipo(){
	 var rdb="<?=$institucion;?>";
	 var id_ano = "<?=$ano;?>";
	 funcion =1;
	 var parametros='funcion='+funcion+'&rdb='+rdb+'&id_ano='+id_ano;	
	 //alert(parametros);
	 $.ajax({
	  url:'cont_archivos_publicos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // alert(data);
	    $("#tipo_archivo").html(data);
		  }
	  })
	}
	
	
	
	function abre_dialog()
	{
		
		 $("#dialog_tipo").html(
		           '<br/><table width="100%" align="center" ><tr><td class="cuadro02">Nombre Tipo</td><td class="cuadro01"><input type="text" id="txt_tipo"></td></tr></table>')
		 $("#dialog_tipo").dialog({
			modal:true,
			height: 200,
            width: 350,
			hide:"explode",
			show:"clip",
			title:"Ingrese Nuevo Tipo",
			buttons: {
			Cancelar: function() {
          $( this ).dialog( "close" );
			},
			Guardar: function() {
          		add_tipo();
			}
		}
			 });
	}
	
	
	function add_tipo()
	{
		
		if($('#txt_tipo').val()==""){
			alert("Ingrese Nombre");
			$('#txt_tipo').focus();
			return false;	
		}
		
	 var rdb="<?=$institucion;?>";
	 var id_ano = "<?=$ano;?>";
	 var tipo = $('#txt_tipo').val();
	 funcion =2;
	 var parametros='funcion='+funcion+'&rdb='+rdb+'&id_ano='+id_ano+'&tipo='+tipo;	
	// alert(parametros);
	// return false;
	 
	 $.ajax({
	  url:'cont_archivos_publicos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // alert(data);
		  if(data==1){
			 alert("Dato Guardado"); 
			 carga_tipo()
			 $("#dialog_tipo").dialog("close");
			 
		  }else{
			alert("Error al Guardar");
		  }
	  }
	 })
  }
				

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
	
	
	function validaform()
	{
		
		if($('#txtFECHA').val()=="")
		{
			alert("Seleccione Fecha");	
			$('#txtFECHA').focus();
			return false;
		}
		if($('#tipo').val()==0)
		{
			alert("Seleccione Tipo");	
			$('#tipo').focus();
			return false;
		}
		if($('#txt_observacion').val()=="")
		{
			alert("Complete Todos los campos");	
			$('#txt_observacion').focus();
			return false;
		}
		if($('#txt_archivo').val()=="")
		{
			alert("Seleccione Archivo");	
			$('#txt_archivo').focus();
			return false;
		}
		if($('#txt_archivo').val()=="")
		{
			alert("Seleccione Archivo");	
			$('#txt_archivo').focus();
			return false;
		}
		
		//alert("val->"+fileValidation());
		
		if(fileValidation()==0){
			return false;
		}
		
		
     $('#form').submit();
	 alert("Archivo Enviado");
	//location.reload();
	 //RecargaPagina();
	// carga_archivo();
	 
	 
	<?php //if($_PERFIL!=0){?>
	// RecargaPagina();
	 
	<?php //}?>
	
	//Buscar_AreaCog($("#id_tipo").val(),<?=$rut_alumno;?>);
		
     } 
	
	
	
	function fileValidation(){
    var fileInput = document.getElementById('fileUpload');
    var filePath = fileInput.value;
    var allowedExtensions = /(.jpg|.jpeg|.png|.gif|.doc|.docx|.xls|.xlsx|.ppt|.pptx|.pdf|.bmp)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Debe subir archivos con extensi\xf3n .jpeg,.jpg,.png,.gif,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.bmp ');
        fileInput.value = '';
        return 0;
    }else{
	    return 1;
	}
}
	
	
		
		/*var queryString = $('#form').serialize(); 
		//$.post('proceso_archivos_publicos.php', queryString);
		
		alert(queryString);
		$.ajax({
	  url:'proceso_archivos_publicos.php',
	  data:queryString,
	  type:'POST',
	  success:function(data){
	  alert(data);
	  //$("#ano_acad").html(data);
		  }
	  })*/
		
		
	
	
	
	
	function RecargaPagina(){
		location.reload();
    }
		
		
		function listoCurso(){
	 var rdb="<?=$institucion;?>";
	 var id_ano = "<?=$ano;?>";
	 funcion =5;
	 var parametros='funcion='+funcion+'&rdb='+rdb+'&id_ano='+id_ano;	
	 //alert(parametros);
	 $.ajax({
	  url:'cont_archivos_publicos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	   $("#lcurso").html(data);
		  }
	  })
}	

function sal(){
	$('#st').change(function() {
    var checkboxes = $(this).closest('table').find('td').find('.cur');
    if($(this).is(':checked')) {
        checkboxes.attr('checked', 'checked');
    } else {
        checkboxes.removeAttr('checked');
    }
});
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
<br><!--target="iframeUpload"-->
<form name="form" id="form" method="post" action="proceso_archivos_publicos.php" enctype="multipart/form-data" >

  <center>
    <table width="90%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td colspan="2" class="tableindex">SUBIR ARCHIVO PUBLICOS </td>
      </tr>
      <tr>
      <td colspan="2">&nbsp;</td>
      </tr>
      
    <tr>
      <td width="%" class="cuadro02" >FECHA:</td>
      <td width="%" class="cuadro01"><div id="fecha">
      <input type="text" name="txtFECHA" id="txtFECHA" >
      </div></td>
    </tr>
    
      <tr>
      <td width="%" class="cuadro02" >TIPO:</td>
      <td width="%" class="cuadro01"><div id="tipo_archivo">
      <select id="tip" name="tip">
      <option value="0">Seleccione</option>
      </select>
      </div></td>
      </tr>

	  <tr>
      <td width="%" class="cuadro02" >OBSERVACION:</td>
      <td width="%" class="cuadro01">
     <textarea id="txt_observacion" name="txt_observacion" cols="30" rows="2"></textarea>
      </td>
      </tr>
      
      <tr>
      <td width="%" class="cuadro02" >ARCHIVO:</td>
      <td width="%" class="cuadro01">
      <input type="file" name="fileUpload" id="fileUpload">
      </td>
      </tr>
   	
      <tr>
      <td width="%" class="cuadro02" >ESTADO:</td>
      <td width="%" class="cuadro01">Habilitado
      <input type="radio" name="estado" id="estado0" value="0" checked>
      Deshabilitado
      <input type="radio" name="estado" id="estado1" value="1">
      </td>
      </tr>
      
      <tr>
      <td width="%" class="cuadro02" >VISTA:</td>
      <td width="%" class="cuadro01">Alumno&nbsp;&nbsp;&nbsp;
      <input type="checkbox" name="vista_al" id="vista_al" value="1" checked>
      Apoderado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="checkbox" name="vista_apo" id="vista_apo" value="1">
      </td>
      </tr>
      <tr>
        <td class="cuadro02" >&nbsp;</td>
        <td class="cuadro01">&nbsp;</td>
      </tr>
      <tr>
        <td class="cuadro02" >CURSOS </td>
        <td class="cuadro01"><div id="lcurso"></div></td>
      </tr>
      <tr>
        <td class="cuadro02" >&nbsp;</td>
        <td class="cuadro01">&nbsp;</td>
      </tr>
      <tr>
        <td class="cuadro02" >&nbsp;</td>
        <td class="cuadro01">&nbsp;</td>
      </tr>
   
   
     <tr>
      <td colspan="2"><div align="right">
        <label>
        <input name="GUARDAR" type="submit" id="GUARDAR" value="GUARDAR" class="botonXX" onClick="validaform()">
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
 
  <div id="dialog_tipo"></div>
</center>
 <iframe name="iframeUpload" id="iframeUpload" width="100%" height="50%" align="bottom"  marginwidth="10%" scrolling="no" class="autoHeight" frameborder="0" >
</iframe>
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