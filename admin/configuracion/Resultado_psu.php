<?	require('../../util/header.inc');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$_POSP = 2;
	
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
		$_ITEM = $item;
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

function eliminaEspacios(cadena)
{
	// Funcion equivalente a trim en PHP
	var x=0, y=cadena.length-1;
	while(cadena.charAt(x)==" ") x++;	
	while(cadena.charAt(y)==" ") y--;	
	return cadena.substr(x, y-x+1);
}
function cargarpuntaje(idInput,rut,ano,cod_sub_psu,curso){
	var valorInput=document.getElementById(idInput).value;
	//var promedio=document.getElementById(promedio).value;
	//var divError=document.getElementById("error");
	//alert("valor input="+valorInput);
	//alert("puntaje="+puntaje);
	//alert("rut="+rut);
	//alert("ano="+ano);
	//alert("cod_sub_psu="+cod_sub_psu);
	// Elimino todos los espacios en blanco al principio y al final de la cadena
	//valorInput=eliminaEspacios(valorInput);
		
	// Valido con una expresion regular el contenido de lo que el usuario ingresa
	//var reg=/(^[a-zA-Z0-9._áéíóúñ¡!¿? -]{1,40}$)/;
	
	// Creo objeto AJAX y envio peticion al servidor
	var ajax=nuevoAjax();
	//alert('puntaje:'+valorInput+' rut:'+rut+' año:'+ano+' cod_psu:'+cod_sub_psu);
	
	ajax.open("GET", "procesaagregarsubsector_psu.php?puntaje="+valorInput+"&rut_alumno="+rut+"&ano="+ano+"&curso="+curso+"&cod_sub_psu="+cod_sub_psu, true);
	ajax.send(null);	
	
}
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
<SCRIPT language="JavaScript" type="text/javascript">
function enviapag(){
	form.submit(true);
}
function borrar_psu(){

}
function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function promedio_vertical_ponderado(num_alumnos){
	var suma=0;
	var acum=0;
	var desc=0;
	var inicio = 1;
	var fin = num_alumnos +1;
	for(i=inicio;i<fin;i++){
		var elemento="txtprom"+i;
		suma = parseInt(document.form.elements[elemento].value);
		if(parseInt(suma)>0){
			acum = acum + suma;
			desc = desc +1;
		}
	}
	prom_sub_ver = eval(acum / parseInt(desc));
	var ponderado = "prom_ver_ponderado";
	document.form.elements[ponderado].value=Math.round(prom_sub_ver);
}
function promedio_vertical(num_alumnos,cod_subsector,e){
	//alert("num_alumnos"+num_alumnos);
	//alert("cod_subsector"+cod_subsector);
	//alert("e"+e);
	var cod_subsector;
	var suma=0;
	var acum=0;
	var inicio=1;
	var desc = 0;
	var fin = num_alumnos +1;
	for(i=1;i<(fin);i++){
		 var elemento="txtnota"+i+e;
		suma = parseInt(document.form.elements[elemento].value);
			if(parseInt(suma)>0){
				acum = acum + suma;
				desc = desc+1;
			}
	}
	//alert("desc"+desc);
	if(desc != 0){
	var prom_sub = eval(acum / parseInt(desc));
	}else{
	var prom_sub = eval(acum / 1);
	}
	//alert("prom_sub="+prom_sub);
	var ee = e+1;
	var promedio = "prom_ver"+num_alumnos+ee;
	//alert("promedio_vertical"+promedio);
	//alert(promedio);
	document.form.elements[promedio].value=Math.round(prom_sub);
}
function promedio(idtext,inicio,ponderacion,count){
//alert("ponderacion= "+ponderacion);
	var ponderacion;
	var i;
	var acum=0;
	var suma=0;
	var elemento;
	var ponderado;
	var num=0;
	for(i=0;i<(count);i++){
		elemento="txtnota"+inicio+i;
		pondera="txtponderacion"+inicio+i;
		suma = parseInt(document.form.elements[elemento].value);
		ponderacion1 = parseInt(document.form.elements[pondera].value);
		
		if(ponderacion1==0){
			
			if(parseInt(suma)>0){
				acum = acum + suma;
				num = num +i
				
			}
		}else{
			pondera1=ponderacion1;
			if(parseInt(suma)>0){
				acum = acum + (suma * eval(pondera1 / 100)) ;
				
			}
		}
		//alert("acum"+acum);
		///alert("num"+num);	
	}
	ponderado = "txtprom"+inicio;
	if(ponderacion1==0){
		if(num != 0){
			document.form.elements[ponderado].value=eval(acum/num);
		}else{
			document.form.elements[ponderado].value=eval(acum/1);
		}
	}else{
	document.form.elements[ponderado].value=Math.round(acum);
	}
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
function fn(form,field,m)
		{	
			
			var field,m;
			var campo1 = "txtprom"+m;
			var campo2 = "prom_ver"+m;
			var campo3 = "txtnota"+m;
			var next=0, found=false, x, y, g;
			var f=form;

			if(event.keyCode==37)  // codigo ascii de la flecha hacia la izquierda <---
			{
						switch (field){
							case (campo1):
								campo3 = "txtnota"+m+1;
								document.form.item(campo3).focus();
								break;
							case (campo2):
								next = m-1;
								break;
							case (campo3):
								next = m-1;
								break;
						}
						found=true;
			}
			if(event.keyCode==38)  // codigo ascii de la flecha hacia arriba 
			{
						switch (field){
							case (campo1):
								next = m-1;
								break;
							case (campo2):
								var valor = m-2;
								campo3 = "txtnota"+valor;
								//alert("campo2"+campo3);
								document.form.item(campo3).focus();
								
								break;
							case (campo3):
								next = m-10;
								break;
						}
						found=true;
			}
			if(event.keyCode==39)  // codigo ascii de la flecha hacia la derecha --->
			{
						switch (field){
							case (campo1):
								next = next;
								break;
							case (campo2):
								next = m+1;
								break;
							case (campo3):
								next = m+1;
								break;
						}
						found=true;
			}
			if(event.keyCode==40)  // codigo ascii de la flecha hacia abajo
			{
						switch (field){
							case (campo1):
								next = m+1;
								break;
							case (campo2):
								next = next;
								break;
							case (campo3):
								next = m+10;
								break;
						}
						found=true;
			}


			while(found){
					switch (field){
						case (campo1):
							campo = "txtprom"+next;
							break;
						case (campo2):
							campo = "prom_ver"+next;
							break;
						case (campo3):
							campo = "txtnota"+next;
							break;
					}
			//if(document.f.item(campo).)	
			if( f.item(campo).disabled==false &&  f.item(campo).type!='hidden'){
					f.item(campo).focus();
					break;
				}else{
				
				alert("no existe");
				}
			}

		}
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
    <td width="" height="" align="center" valign="top"> >>>>>>>>>>>>>>>></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>-->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<center>
</center>	
<form method="post" name="form" action="">
<? if($cmb_curso != 0){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex">Resultados PSU</td>
  </tr>
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td width="9%" class="cuadro02"><strong>Institucion</strong></td>
	<td width="1%" class="cuadro02"><strong>:</strong></td>
	<td width="72%" class="cuadro01">
	<?	$sql = "SELECT nombre_instit FROM institucion WHERE rdb=".$institucion;
		$resp=pg_exec($conn,$sql);
		echo pg_result($resp,0);
	?></td>
	</tr>
	<tr>
	<td class="cuadro02"><strong>Año</strong></td>
	<td class="cuadro02"><strong>:</strong></td>
	<td class="cuadro01">
	<? 	$sql="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$_ANO;
		$resp = pg_exec($conn,$sql);
		echo pg_result($resp,0);
	?></td>
	</tr>
	<tr>
	<td class="cuadro02"><strong>Curso</strong></td>
	<td class="cuadro02"><strong>:</strong></td>
	<td class="cuadro01">
	<?	$sql="SELECT grado_curso,letra_curso FROM curso  WHERE id_curso =".$cmb_curso;
			$resp = pg_exec($conn,$sql);
			$grado= pg_result($resp,0);
			$letra= pg_result($resp,1);
			echo $grado."-".$letra;
	?>
	</td>
	</tr>
	</table>
	</td>
  </tr>
  <tr>
    <td>
			<table border="0" cellpadding="0" cellspacing="0">
			<tr>
			<td>&nbsp;</td>
			</tr>
			<tr class="cuadro02">
			<td>ALUMNOS</td>
			<? $sql = "SELECT * FROM psu_conf_2009 WHERE cod_ano=".$_ANO;
				$resp_sub = pg_exec($conn,$sql);
				$num_sub = pg_numrows($resp_sub);
				for($sub_sec=0;$sub_sec<$num_sub;$sub_sec++){
				$fila_sub = pg_fetch_array($resp_sub,$sub_sec)?>
				<td>
				<?
				switch ($fila_sub['cod_subsector']) {
					 case 1:
						  echo "HISTORIA Y <br /> CIENCIAS<br /> SOCIALES<br />";
						  break;
					 case 2:
						  echo "MATEMATICA";
						  break;
					 case 3:
						  echo "BIOLOGIA";
						  break;
				 	 case 4:
						  echo "QUIMICA";
						  break;
					 case 5:
						  echo "FISICA";
						  break;
					 case 6:
						  echo "LENGUA <br />CASTELLANA <br />Y COMUNIC.";
						  break;
					 case 7:
					 	  echo "CIENCIAS";
						  break;
				 }
				?></td>
				<? }?>
				<td><div align="center">PONDERACION</div></td>
			</tr>
			<?
				$sql="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ";
				$sql.="alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, ";
				$sql.=" alumno.comuna, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, matricula.num_mat ";
				$sql.=" FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON ";
				$sql.=" matricula.rut_alumno = alumno.rut_alumno WHERE (matricula.bool_ar=0 AND((matricula.id_curso)=".$cmb_curso.") AND ";
				$sql.=" ((matricula.id_ano)=".$_ANO.")) order by ape_pat, ape_mat, nombre_alu ";
				$resp = pg_exec($conn,$sql);
				$num_alumnos = pg_numrows($resp);
				for($i=0;$i<$num_alumnos;$i++){
				$fila_alumnos = pg_fetch_array($resp,$i);
			  ?>
			<tr class="cuadro01">
			
			<? if($fila_alumnos['bool_ar']==1){?>
					<td class="tachado"><?=$fila_alumnos['ape_pat']." ".$fila_alumnos['ape_mat'].",".$fila_alumnos['nombre_alu']?></td>
					<? for($e=0;$e<$num_sub;$e++){?>
						<td align="center"><input type="text" name="txtnota<?=$i?>" value="-" disabled="disabled" size="4"></td>
					<? }?>
					<td align="center"><input type="text" name="txtprom<?=$i?>" id="txtprom<?=$i?>" onKeyUp="fn(this.form,this.id,<?=$i?>)" size="4"disabled="disabled"></td>
			<? }else{?>
				<td><?=$fila_alumnos['ape_pat']." ".$fila_alumnos['ape_mat'].",".$fila_alumnos['nombre_alu']?></td>
					<? for($e=0;$e<$num_sub;$e++){
					
						$fila_sub1=pg_fetch_array($resp_sub,$e);
								$sql_psu_resul = "SELECT puntaje,ponderacion FROM psu_notas_2009 WHERE cod_ano=".$_ANO." AND cod_sub_psu=".$fila_sub1['cod_sub_psu']." AND rut_alumno=".$fila_alumnos['rut_alumno'];
								$resp_resul = pg_exec($conn,$sql_psu_resul);
								$puntaje = pg_result($resp_resul,0);
								$ponde_aux = pg_result($resp_resul,1);
								if($ponde_aux==NULL){ 
									$ponderacion=0; 
								}else{ 
									$ponderacion = $ponde_aux;
								}
								$sql_psu_resul;
								$f = $i+1;
								$g = $e+1;
								$mm = $mm+1;
								
					?>
					<td align="center">
					<input type="text" name="txtnota<?=$f.$e?>" id="txtnota<?=$f.$e?>" value="<?=$puntaje?>" onKeyUp="fn(this.form,this.id,<?=$f.$e?>)" onBlur="promedio_vertical(<?=$num_alumnos?>,<?=$fila_sub1['cod_subsector']?>,<?=$e?>);promedio(this.id,<?=$f?>,<?=$ponderacion?>,<?=$num_sub?>);cargarpuntaje(this.id,<?=$fila_alumnos['rut_alumno']?>,<?=$_ANO?>,<?=$fila_sub1['cod_sub_psu']?>,<?=$cmb_curso?>)" size="4" maxlength="3">
					<input type="hidden" name="txtponderacion<?=$f.$e?>" id="txtponderacion<?=$f.$e?>" value="<?=$ponderacion?>">
					<? //if($_PERFIL==0){ echo $ponderacion;}?></td>
					
					<? }
					 $sql_puntaje_ponderado = "SELECT puntaje FROM psu_puntajes_2009 WHERE rut_alumno=".$fila_alumnos['rut_alumno']." AND cod_ano=".$_ANO;
					 $resp_ponderado = pg_exec($conn,$sql_puntaje_ponderado);
					 $puntaje_ponderado = pg_result($resp_ponderado,0);
					 ?>
					<td align="center"><input type="text" name="txtprom<?=$f?>" id="txtprom<?=$f?>" onKeyUp="fn(this.form,this.id,<?=$f?>)" value="<?=$puntaje_ponderado?>" size="4" onBlur="promedio_vertical_ponderado(<?=$num_alumnos?>);cargarpuntaje(this.id,<?=$fila_alumnos['rut_alumno']?>,<?=$_ANO?>,0,<?=$cmb_curso?>)"></td>
			<? }
			}?>
			</tr>
			<tr>
			  <td colspan="<?=$num_sub+2?>" class="cajamenu">&nbsp;</td>
			  </tr>
			<tr class="cuadro01">
			  <td class="cuadro01">PROMEDIOS</td>
			  <? $X = $f.$e;
			     for($sub_sec=1;$sub_sec<$num_sub+1;$sub_sec++){
			  		$sql_promedio="SELECT puntaje FROM psu_promedios_2009 WHERE id_ano=".$_ANO." AND id_subsector=".$sub_sec."AND curso=".$cmb_curso;
					$resp=pg_exec($conn,$sql_promedio);
					$promedios_sub = pg_result($resp,0);
				
				?>	
			 	  <td align="center">
				  <input type="text" value="<?=$promedios_sub?>" onKeyUp="fn(this.form,this.id,<?=$f.$sub_sec?>)" name="prom_ver<?=$f.$sub_sec?>" id="prom_ver<?=$f.$sub_sec?>" size="4" onChange="cargarpuntaje(this.id,<?=$sub_sec?>,<?=$_ANO?>,999999,<?=$cmb_curso?>)" onBlur="cargarpuntaje(this.id,<?=$sub_sec?>,<?=$_ANO?>,999999,<?=$cmb_curso?>)">
				 </td>
				  <? $X = $X+1;?>
			 	  <? }?>
			  <td align="center">
			  <? $sql_promedio_pondera = "SELECT puntaje FROM psu_promedios_2009 WHERE id_subsector=999999 AND id_ano=".$_ANO." AND curso=".$cmb_curso;
			  	 $resp = pg_exec($conn,$sql_promedio_pondera);
				 $promedio_pondera  = pg_result($resp,0)
			  ?>
			  <input type="text" name="prom_ver_ponderado" value="<?=$promedio_pondera?>" id="prom_ver_ponderado" size="4" onBlur="cargarpuntaje(this.id,999999,<?=$_ANO?>,999999,<?=$cmb_curso?>)"></td>
			  <!--<td>&nbsp;</td>-->
			  <!--<td align="center">&nbsp;</td>
			  <td align="center">&nbsp;</td>-->
			  </tr>
			</table>
</td>
  </tr>
</table>

<? }?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" class="tableindex">Busqueda Resultados PSU </td>
      </tr>
    <tr>
      <td class="cuadro01">Curso:</td>
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
		  	  
		 
			    </strong> </font>	  </td>
    </tr>
    <tr>
      <td colspan="2" class="cuadro01">&nbsp;</td>
      </tr>
  </table>

</form>
	
<!-- FIN CUERPO DE LA PAGINA -->

 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../cabecera/menu_inferior.php"); ?></td>
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