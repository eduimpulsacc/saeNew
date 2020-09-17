<?	require('../../util/header.inc');
	//include('../clases/class_MotorBusqueda.php');
	//include('../../clases/class_Membrete.php');
	//include('../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	//$curso			=$c_curso	;
	//$alumno			=$c_alumno	;
	//$reporte		=$c_reporte;
	//$_POSP = 4;
	//$_bot = 8;
?>

<script language="javascript" type="text/javascript">
function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objeto AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
} 

function cargaponderacion(idInput,rut,ano,cod_sub_psu){
	var valorInput=document.getElementById(idInput).value;
		
	// Valido con una expresion regular el contenido de lo que el usuario ingresa
	//var reg=/(^[a-zA-Z0-9._áéíóúñ¡!¿? -]{1,40}$)/;
	
	// Creo objeto AJAX y envio peticion al servidor
	var ajax=nuevoAjax();
	//alert('puntaje:'+valorInput+' rut:'+rut+' año:'+ano+' cod_psu:'+cod_sub_psu);
	
	ajax.open("GET", "procesaagregarsubsector_psu.php?puntaje="+valorInput+"&rut_alumno="+rut+"&ano="+ano+"&tipo=2&cod_sub_psu="+cod_sub_psu, true);
	ajax.send(null);	
	
}
function asigna_ponderacion(idInput,fin){
	var valorInput=document.getElementById(idInput).value;
	//alert("valor="+valorInput);
	//alert("fin="+fin);
	for (i=0;i<(fin);i++){
     	elemento = "ponderacion"+i;
  		document.form.elements[elemento].value=valorInput;
		document.form.elements[elemento].focus();
	}
	document.form.volver.focus();

}
/*function vuelta(num_alumnos){
	//alert("num="+num_alumnos);
	for(i=0;i<num_alumnos;i++){
		elemento = "ponderacion"+i;
		document.form.elements[elemento].focus();
	}
	document.form.pondera_todos.focus();
	window.location='prueba_simce_psu.php';
}
*/
</script>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--<link href="../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">
-->
<SCRIPT language="JavaScript">
function enviapag(){
	form.submit(true);
}
function borrar_psu(){

}
function eliminar_sub(cod_psu,ano,cod_sub_psu){
	if(confirm("SE ELIMARAN LOS PUNTAJES RELACIONADOS.")){
		window.location='procesaagregarsubsector_psu.php?tipo=2&cod_sub_psu='+cod_sub_psu+'&cod_subsector='+cod_psu+'&cod_ano='+ano+'&caso=1'
	}
}
function ponderaciones(cod_subsector,cod_sub_psu){
		window.location='detalle_ponderacion_psu.php?cod_subsector='+cod_subsector+'&cod_sub_psu='+cod_sub_psu
}
function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../cabecera/menu_superior.php");
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
						include("../../menus/menu_lateral.php");
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
<!--								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="" align="center" valign="top"> >>>>>>>>>>>>><? include("../../cabecera/menu_inferior.php");?></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>
                              <!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<center>
</center>	
<FORM method="post" name="form" action="detalle_ponderacion_psu.php?cod_subsector=<?=$cod_subsector?>&cod_sub_psu=<?=$cod_sub_psu?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" class="tableindex">Busqueda Detalles Ponderaciones </td>
      </tr>
    <tr>
      <td class="cuadro01">Curso</td>
      <td>
	 
	  <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
					$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
					$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
					$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.") AND curso.grado_curso=4 AND tipo_ensenanza.nombre_tipo LIKE '%MEDIA%') $whe_perfil_curso";
					$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
					$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		        
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal." </option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal." </option>";
                }
		     } ?>
          </select> 
		  	  
		 
			    </strong> </font>	    <input type="button" name="volver" value="Volver" onClick="javascript:window.location='prueba_simce_psu.php'" class="botonXX"></td>
    </tr>
	<?
  
	$sql="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ";
	$sql.="alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, ";
	$sql.=" alumno.comuna, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, matricula.num_mat ";
	$sql.=" FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON ";
	$sql.=" matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$cmb_curso.") AND ";
	$sql.=" ((matricula.id_ano)=".$_ANO.")) and matricula.bool_ar=0 order by ape_pat, ape_mat, nombre_alu ";
	$resp = pg_exec($conn,$sql);
	$num_alumnos = pg_numrows($resp);
  ?>
    <tr>
      <td class="cuadro01">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
<? if(!$cmb_curso==0){?>

<table width="73%" border="0" align="center">
  <tr>
    <td colspan="2" class="tableindex">DETALLE PONDERACIONES</td>
  </tr>
  <? $sql_sub_psu="SELECT cod_sub_psu FROM psu_conf_2009 WHERE cod_subsector =".$cod_subsector." AND cod_ano=".$_ANO;
  	 $resp_sub_psu = pg_exec($conn,$sql_sub_psu);
	 $cod_sub_psu = pg_result($resp_sub_psu,0);
	?>
  <tr>
    <td width="43%" class="cuadro02">ALUMNOS</td>
    <td width="28%" class="cuadro02"><?
	switch ($cod_subsector) {
					 case 1:
						  echo "<div align='center'>HISTORIA Y <br /> CIENCIAS<br /> SOCIALES<br /></div>";
						  break;
					 case 2:
						  echo "<div align='center'>MATEMATICA</div>";
						  break;
					 case 3:
						  echo "<div align='center'>BIOLOGIA</div>";
						  break;
				 	 case 4:
						  echo "<div align='center'>QUIMICA</div>";
						  break;
					 case 5:
						  echo "<div align='center'>FISICA</div>";
						  break;
					 case 6:
						  echo "<div align='center'>LENGUA <br />CASTELLANA <br />Y COMUNIC.</div>";
						  break;
					 case 7:
						  echo "<div align='center'>CIENCIAS</div>";
						  break;
				 }
	?></td>
  </tr>
  
  <tr class="cajamenu">
    <td class="cajamenu"><div align="center">TODOS</div></td>
    <td class="cajamenu"><div align="center"><input type="text" onBlur="asigna_ponderacion(this.id,<?=$num_alumnos?>)" name="pondera_todos" id="pondera_todos" size="2"><?="%"?>
    </div></td>
  </tr>
  <?
	for($i=0;$i<$num_alumnos;$i++){
	$fila_alumnos = pg_fetch_array($resp,$i);
  ?>
  <tr>
    <? if($fila_alumnos['bool_ar']==1){?>
    <td class="tachado"><?=$fila_alumnos['ape_pat']." ".$fila_alumnos['ape_mat'].",".$fila_alumnos['nombre_alu']?></td>
    <td align="center" class="tachado"><input type="text" size="2" maxlength="2" name="ponderacion" disabled="disabled">
        <?="%"?></td>
    <? }else{?>
    <td width="24%" class="cuadro01"><?=$fila_alumnos['ape_pat']." ".$fila_alumnos['ape_mat'].",".$fila_alumnos['nombre_alu']?></td>
    <?      $sql_detalle_actual = "SELECT ponderacion FROM psu_notas_2009 WHERE cod_sub_psu=".$cod_sub_psu." AND cod_ano=".$_ANO." AND rut_alumno=".$fila_alumnos['rut_alumno'];
			$resp_detalle_actual = pg_exec($conn,$sql_detalle_actual);
			$ponderacion_actual = pg_result($resp_detalle_actual,0);?>
    <td width="5%" class="cuadro01"><div align="center">
      <input type="text" size="2" value="<?=$ponderacion_actual?>" maxlength="2" name="ponderacion<?=$i?>" id="ponderacion<?=$i?>" onBlur="cargaponderacion(this.id,<?=$fila_alumnos['rut_alumno']?>,<?=$_ANO?>,<?=$cod_sub_psu?>)">
      <?="%"?>
    </div></td>
    <? }?>
  </tr>
  <? }?>
</table>
<? }?>
</FORM>

	
<!-- FIN CUERPO DE LA PAGINA -->						    </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>