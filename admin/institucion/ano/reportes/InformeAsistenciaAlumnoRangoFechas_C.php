<?	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	
	$curso			=$c_curso	;
	$alumno			=$c_alumno	;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	if($c_ano!=""){
		$ano=$c_ano;	
	}else{
		$ano =$_ANO;	
	}
	
?>


<script language="javascript" type="text/javascript">
function enviapag(form){
	//alert(form.c_curso.value);
	if (form.c_ano.value!=0){
		form.target="_self";
		form.c_ano.target="self";
		form.action = 'InformeAsistenciaAlumnoRangoFechas_C.php?institucion=$institucion';
		form.submit(true);
	}	
	if (form.c_curso.value!=0){
		form.target="_self";
		form.c_curso.target="self";
		form.action = 'InformeAsistenciaAlumnoRangoFechas_C.php?institucion=$institucion&c_curso=$c_curso&c_ano=$c_ano';
		form.submit(true);
	}	
}
			

function buscapag(form){

	if(form.c_ano.value==0){
		alert('Debe seleccionar un año');
		return false;
		}
	
	if(form.c_curso.value==0){	
			alert('Debe seleccionar un curso');
			return false;
		}
	if(form.c_alumno.value==0){	
			alert('Debe seleccionar un alumno');
			return false;
		}	
	form.target = "_blank";	
	form.action = 'printInformeAsistenciaAlumnoRangoFechas_C.php?cb_ok=Buscar';	
	form.submit(true);


}	


function exportar(form){

	if(form.c_ano.value==0){
		alert('Debe seleccionar un año');
		return false;
		}
	
	if(form.c_curso.value==0){	
			alert('Debe seleccionar un curso');
			return false;
		}
	if(form.c_alumno.value==0){	
			alert('Debe seleccionar un alumno');
			return false;
		}	
	form.target = "_blank";	
	form.action = 'printInformeAsistenciaAlumnoRangoFechas_C.php';	
	form.submit(true);


}			
	

</script>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../../clases/jqueryui/themes/smoothness/jquery.ui.datepicker.css">
<link rel="stylesheet" type="text/css" href="../../../clases/jqueryui/themes/smoothness/jquery.ui.all.css">


<script type="text/javascript" src="../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery.ui.core.js"></script>

<SCRIPT language="JavaScript">
/*function enviapag(){
	form.submit(true);
}*/
function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
		
		
$(document).ready(function() {
	
	
	
$( "#fecha_desde,#fecha_hasta" ).datepicker({
    'dateFormat':'dd/mm/yy',
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
//convertir la fcha
function process(date){
   var date;
   // Do something
   return date;
}

function valida_envia(form) {
	var date1 = document.form.fecha_hasta.value;  /*february 25th*/
var date2 = document.form.fecha_desde.value;  /*february 26th*/
	
 if (document.form.c_ano.value==0){
		alert("Seleccione un año");
		return false;
	}	
else if (document.form.c_curso.value==0){
	alert("Seleccione un curso");
	return false;
}
else if (document.form.fecha_desde.value.length==0){
	alert("Seleccione fecha desde");
	return false;
}
else if (document.form.fecha_hasta.value.length==0){
	alert("Seleccione fecha hasta");
	return false;
}
else if(process(date2) > process(date1)){
          alert(date2 + ' es mayor que ' + date1);
		  return false;
    }
 else
 return true;
}

</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
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
								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="30" align="center" valign="top"></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>
<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<center>
</center>	
<form method="post" name="form" action="printInformeAsistenciaAlumnoRangoFechas_C.php" target="_blank" onSubmit="return valida_envia(this)" >
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
	
			<?php
				
				$ob_curso = new MotorBusqueda();
				$ob_curso->ano=$ano;
				$result=$ob_curso->curso($conn);
				
				$ob_ano = new MotorBusqueda();
				$ob_ano->rdb=$institucion;
				$rs_ano =$ob_ano->Ano($conn);
			?>
		<center>
			<table border="0" cellpadding="5" cellspacing="0" width="80%">
				<tr>
					<td align="center" class="tableindex" colspan="2"><? echo $numero.".- Buscador ".$nombre;?></td>
				</tr>
				<tr  class="cuadro01">
					<td>Año</strong></td>
					<td><select name="c_ano" id="c_ano" onChange="enviapag(this.form);">
					  <option value="0">Seleccione A&ntilde;o</option>
					  <? for($i=0;$i<@pg_numrows($rs_ano);$i++){
								$fila = @pg_fetch_array($rs_ano,$i);?>
					  <? if($fila['id_ano']==$c_ano){?>
					  <option value="<?=$fila['id_ano'];?>" selected="selected">
					    <?=$fila['nro_ano']?>
					    </option>
					  <? }else{?>
					  <option value="<?=$fila['id_ano'];?>">
					    <?=$fila['nro_ano'];?>
					    </option>
					  <? }
							} ?>
					  </select></td>
					</tr>
				<tr  class="cuadro01">
				  <td>Curso</td>
				  <td><select name="c_curso" >
				    <option value="0">(Seleccione Curso)</option>
				    <? 
								for($i=0;$i<@pg_numrows($result);$i++)
								{
									$fila = pg_fetch_array($result,$i);
									$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
									if($c_curso==$fila["id_curso"]){?>
				    <option selected="selected" value="<?=$fila['id_curso']?>">
				      <?=$Curso_pal?>
				      </option>
				    <?  }else{ ?>
				    <option value="<?=$fila['id_curso']?>">
				      <?=$Curso_pal?>
				      </option>
				    <?	}		}?>
				    </select></td>
				  </tr>
				<tr  class="cuadro01">
				  <td>Fecha</td>
				  <td>Desde
                              <input name="fecha_desde" type="text" id="fecha_desde" size="10" readonly placeholder="Seleccione">
                              <label for="fecha_desde"></label>
 Hasta
 <input name="fecha_hasta" type="text" id="fecha_hasta" size="10" readonly placeholder="Seleccione"></td>
				  </tr>
				<tr  class="cuadro01">
				  <td colspan="2"><input name="opt_ret" type="radio"  value="0" checked>
				    Alumos activos 
				    <input type="radio" name="opt_ret"  value="1">
				    Alumnos retirados</td>
				  </tr>
				<tr  class="cuadro01">
				  <td>&nbsp;</td>
				  <td><input name="cb_ok" type="SUBMIT" class="botonXX" id="cb_ok" value="Buscar"  >
				    <? if($_PERFIL==0 OR $_PERFIL==14 ){?>
                    <input name="cb_exp" type="button" onClick="exportar(this.form)" class="botonXX"  id="cb_exp" value="Exportar" >
                    <? }?>
                    <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'"></td>
				  </tr>
		    </table>
	</center>			
</form>

	
<!-- FIN CUERPO DE LA PAGINA -->

 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>