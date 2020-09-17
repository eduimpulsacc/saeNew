<?	require('../../util/header.inc');
	//include('../clases/class_MotorBusqueda.php');
	//include('../../clases/class_Membrete.php');
	//include('../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$curso			=$cmb_curso ;
	//$curso			=$c_curso	;
	//$alumno			=$c_alumno	;
	//$reporte		=$c_reporte;
	//$_POSP = 4;
	//$_bot = 8;
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">


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

function cargarpuntos(idInput,rut,ano,id_sub_sim,institucion,curso){
	var valorInput=document.getElementById(idInput).value;
	//var promedio=document.getElementById(promedio).value;
	//var divError=document.getElementById("error");
	//alert("valor input="+valorInput);
	//alert("puntaje="+puntaje);
	//alert("rut="+rut);
	//alert("ano="+ano);
	//alert("cod_sub_sim="+cod_sub_sim);
	// Elimino todos los espacios en blanco al principio y al final de la cadena
	valorInput=eliminaEspacios(valorInput);
		
	// Valido con una expresion regular el contenido de lo que el usuario ingresa
	//var reg=/(^[a-zA-Z0-9._áéíóúñ¡!¿? -]{1,40}$)/;
	
	// Creo objeto AJAX y envio peticion al servidor
	var ajax=nuevoAjax();
	//alert('alumno:'+rut+' ano:'+ano+' id_sub_sim:'+id_sub_sim+' puntos:'+valorInput);
	
	ajax.open("GET", "procesaagregarsubsector_simce.php?puntos="+valorInput+"&rut_alumno="+rut+"&ano="+ano+"&id_sub_sim="+id_sub_sim+"&rdb="+institucion+"&curso="+curso, true);
	ajax.send(null);	 
	
}



function enviapag(){
	form.submit(true);
}

function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
	
	
//**	************************************//

function promedio(idtext,inicio,fin,count){
	var i;
	var acum=0;
	var suma=0;
	var elemento;
	var ponderado;
	var nuevo_prom=0;
	for(i=0;i<(count);i++){
		var elemento="casilla"+inicio+i;
		//alert("element="+elemento);
		suma = parseInt(document.form.elements[elemento].value);
			if(parseInt(suma)>0){
			acum = acum + suma;
			nuevo_prom=  acum/count;
			}
			
	}
	
	//puntaje = "puntaje"+inicio;
	//document.form.elements[puntaje].value=acum;
	var promedio = "promedio"+inicio;
	document.form.elements[promedio].value=Math.round(nuevo_prom);

}

//***********************************************//


function suma_puntajes(idtext,inicio,fin,count){
	var i;
	var acum=0;
	var suma=0;
	var elemento;
	var puntaje;
	var fin;
	var ini = 1;
	var fn = count+1;
	var desc=0;
	for(i=ini;i<(fn);i++){
		 //alert(i+inicio);
		//alert('casilla'+inicio+i);
		var elemento="casilla"+i+fin;
		//alert("element="+elemento);
		suma = parseInt(document.form.elements[elemento].value);
			if(parseInt(suma)>0){
			acum = acum + suma;
			desc = desc+1;
			//alert(acum);
			}
			
	}
	sum_prom=eval(acum/parseInt(desc));
	total_columna = "suma_casilla"+fin;
	document.form.elements[total_columna].value=Math.round(sum_prom);


}

//*****************************




function suma_totales(idtext,inicio,count){
	var i;
	var acum=0;
	var suma=0;
	var elemento;
	var puntaje;
	var fin;
	var ini = 1;
	for(i=ini;i<(count);i++){
		var elemento="puntaje"+i;
		suma = parseInt(document.form.elements[elemento].value);
			if(parseInt(suma)>0){
			acum = acum + suma;
			}
			
	}
	
	total_columna = "suma_puntaje";
	document.form.elements[total_columna].value=acum;


}

//****************************************


function promedio_final_curso(idtext,inicio,count){
	var i;
	var acum=0;
	var suma=0;
	var elemento;
	var puntaje;
	var fin;
	var ini = 1;
	var desc=0;
	for(i=ini;i<(count);i++){
		var elemento="promedio"+i;
		suma = parseInt(document.form.elements[elemento].value);
			if(parseInt(suma)>0){
			acum = acum + suma;
			desc=desc+1;
			//var final=  Math.round(acum/count);
			}
		var final=  Math.round(acum/parseInt(desc));	
	}
	total_columna = "suma_promedio";
	document.form.elements[total_columna].value=Math.round(final);
}


//******************************************************************


function fn(form,field,m,n)
		{	
			var campo;
			var campo1 = "casilla"+m;
			var campo2 = "promedio"+m;
			var campo3 = "suma_casilla"+m;
			var campo4 = "suma_promedio";
			var next=0, found=false, x, y, g;
			var f=form;

			if(event.keyCode==37)  // codigo ascii de la flecha hacia la izquierda <---
			{
						switch (field){
							case (campo2):
								///next = next;
								var nn = eval(n-1);
								campo1 = "casilla"+m+nn;
								document.form.item(campo1).focus();
								break;
							case (campo1):
								next = m-1;
								break;
							case (campo3):
								next = m-1;
								break;	
							case (campo4):
								var nn = eval(n-1);
								campo3 = "suma_casilla"+nn;
								document.form.item(campo3).focus();
								break;
						}
						found=true;
			}
			if(event.keyCode==38)  // codigo ascii de la flecha hacia arriba 
			{
						switch (field){
							case (campo1):
								next = m-10;
								break;
							case (campo2):
								next = m-1;
								break;
							case (campo3):
								///next = next;
								campo1 = "casilla"+n+m;
								//alert(campo1);
								document.form.item(campo1).focus();
								break;	
							case (campo4):
								campo2 = "promedio"+m;
								document.form.item(campo2).focus();
								break;		
						}
						found=true;
			}
			if(event.keyCode==39)  // codigo ascii de la flecha hacia la derecha --->
			{
						switch (field){
							case (campo2):
								next = next;
								break;
							case (campo1):
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
								next = m+10;
								break;
							case (campo2):
								next = m+1;
								break;
							case (campo3):
								next = next;
								break;
						}
						found=true;
			}


			while(found){
					switch (field){
						case (campo1):
							campo = "casilla"+next;
							break;
						case (campo2):
							campo = "promedio"+next;
							break;
						case (campo3):
							campo = "suma_casilla"+next;
							break;
						case (campo4):
							campo = "suma_promedio"+next;
							break;	
					}
			//if(document.f.item(campo).)	
			if( f.item(campo).disabled==false &&  f.item(campo).type!='hidden'){
					f.item(campo).focus();
					break;
				}else{
				
				//alert('no existe');
				}
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
                                  <td>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
<!--								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="" align="center" valign="top"> >>>>>>>>>>>>>>>>>>>>></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>-->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
	
<form method="post" name="form" action="">
<? if($buscar =="Buscar" && $cmb_curso != 0){?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex">Resultados SIMCE </td>
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
	<?	$sql="SELECT grado_curso,letra_curso,ensenanza FROM curso  WHERE id_curso =".$cmb_curso;
			$resp = pg_exec($conn,$sql);
			$grado= pg_result($resp,0);
			$letra= pg_result($resp,1);
			$ensenanza= pg_result($resp,2);
			if($ensenanza==110){
			$ensenanza_sim="Básico";
			}else{
			$ensenanza_sim="Medio";
			}
			echo $grado."-".$letra." ".$ensenanza_sim;
	?>
	</td>
	</tr>
	</table>
	</td>
	
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <? $sql="SELECT * FROM simce_conf_2009 INNER JOIN subsector ON ";
	  	 $sql.="simce_conf_2009.cod_subsector=subsector.cod_subsector WHERE simce_conf_2009.grado=".$grado." ";
		 $sql.="and simce_conf_2009.ensenanza=".$ensenanza." and simce_conf_2009.id_ano=".$_ANO;	
		 $resp_sub = pg_exec($conn,$sql);
		 $num_sub = pg_numrows($resp_sub);
	  ?>
      <tr class="cuadro02">
        <td>ALUMNOS</td>
        <? for($j=0;$j<$num_sub;$j++){
			$fila_sub = pg_fetch_array($resp_sub,$j);
			?>  
		<td><div align="center"><?=$fila_sub['nombre']?></div></td>
		<? }?>
        <!--<td><div align="center">TOTAL PUNTAJE </div></td>-->
        <td><div align="center">PROMEDIO</div></td>
      </tr>
      <?
    $sql="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ";
	$sql.="alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, ";
	$sql.=" alumno.comuna, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, matricula.num_mat ";
	$sql.=" FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON ";
	$sql.=" matricula.rut_alumno = alumno.rut_alumno WHERE (matricula.bool_ar=0 and ((matricula.id_curso)=".$cmb_curso.") AND ";
	$sql.=" ((matricula.id_ano)=".$_ANO.")) order by ape_pat, ape_mat, nombre_alu ";
 	$resp = pg_exec($conn,$sql);
	$num_alumnos = pg_numrows($resp);
	for($i=0;$i<$num_alumnos;$i++){
	$fila_alumnos = pg_fetch_array($resp,$i);
  ?>
      <tr class="cuadro01">
        <? if($fila_alumnos['bool_ar']==1){?>
        <td class="tachado"><?=$fila_alumnos['ape_pat']." ".$fila_alumnos['ape_mat'].",".$fila_alumnos['nombre_alu']?></td>
       <? for($j=0;$j<$num_sub;$j++){
			$fila_sub = pg_fetch_array($resp_sub,$j);
			$f=$i+1;
			?>  
	    <td align="center"><input name="casilla<?=$f.$j?>" type="text" id="casilla<?=$f.$j?>" value="" size="4" disabled="disabled"></td>
		<? }?>
    <!--    <td align="center"><input name="puntaje<?=$f?>" type="text" id="puntaje<?=$f?>" value="" size="4" disabled="disabled"></td>-->
        <td align="center"><input name="promedio<?=$f?>" type="text" id="promedio<?=$f?>" value="" size="4" disabled="disabled" onKeyUp="fn(this.form,this.id,<?=$f?>)"></td>
        <? }else{?>
        <td class="cuadro01"><?=$fila_alumnos['ape_pat']." ".$fila_alumnos['ape_mat'].",".$fila_alumnos['nombre_alu']?></td>
		<? for($j=0;$j<$num_sub;$j++){
			$fila_sub = pg_fetch_array($resp_sub,$j);
			$f=$i+1;
			
			
						
			$sql="SELECT nota FROM simce_notas_2009 WHERE rut_alumno=".$fila_alumnos['rut_alumno']." and id_sub_sim=".$fila_sub['id_sub_sim']." and id_curso=".$cmb_curso;
			$res_sql=@pg_exec($conn,$sql);
			$nota=pg_result($res_sql,0);
			
			
			
			?>  
        <td align="center"><input name="casilla<?=$f.$j?>" type="text" id="casilla<?=$f.$j?>" value="<? if($res_sql!=NULL){ echo $nota; }?>" size="4" onBlur="promedio(this.id,<?=$f?>,<?=$j?>,<?=$num_sub?>); suma_puntajes(this.id,<?=$f?>,<?=$j?>,<?=$num_alumnos?>); cargarpuntos(this.id,<?=$fila_alumnos['rut_alumno']?>,<?=$_ANO?>,<?=$fila_sub['id_sub_sim']?>,<?=$institucion?>,<?=$curso?>); " onKeyUp="fn(this.form,this.id,<?=$f.$j?>)"></td>
		<? }?>
    <!--    <td align="center"><input name="puntaje<?=$f?>" type="text" id="puntaje<?=$f?>" value="" size="4" onBlur="suma_totales(this.id,<?=$f?>,<?=$num_alumnos?>); cargarpuntajes_totales(this.id,<?=$fila_alumnos['rut_alumno']?>,<?=$_ANO?>)"></td>-->
			<?
			$sql="SELECT puntaje_final FROM simce_final_2009 WHERE rut_alumno=".$fila_alumnos['rut_alumno']." and id_curso=".$cmb_curso;
			$res_sql=@pg_exec($conn,$sql);
			$prom=pg_result($res_sql,0);
			?>
        <td align="center"><input name="promedio<?=$f?>" type="text"  id="promedio<?=$f?>" value="<? if($res_sql!=NULL){ echo $prom; }?>" size="4" onBlur="promedio_final_curso(this.id,<?=$f?>,<?=$num_alumnos?>); cargarpuntos(this.id,<?=$fila_alumnos['rut_alumno']?>,<?=$_ANO?>,0,<?=$institucion?>,<?=$curso?>)" onKeyUp="fn(this.form,this.id,<?=$f?>,<?=$j?>)"></td>
        <? }?>
      </tr>
      <? }?>
      <tr class="cuadro01">
        <td class="cajamenu">&nbsp;</td>
        <td colspan="<?=$j?>" align="center" class="cajamenu">&nbsp;</td>
        <td align="center" class="cajamenu">&nbsp;</td>
      </tr>
      <tr class="cuadro01">
        <td><div align="left"><strong>Promedio Curso </strong></div></td>
		<? for($j=0;$j<$num_sub;$j++){
			$fila_sub = pg_fetch_array($resp_sub,$j);
			?> 
        <td align="center">
		<? 
		$sql_puntaje="SELECT SUM(nota) FROM simce_notas_2009 WHERE id_curso=".$cmb_curso." ";
		$sql_puntaje.="and id_sub_sim=".$fila_sub['id_sub_sim']." and id_ano=".$_ANO."";
		$res_puntaje=@pg_exec($conn,$sql_puntaje);
		$prom_sub = pg_result($res_puntaje,0);
		
		$sql_cantidad="SELECT count(*) FROM simce_notas_2009 WHERE id_sub_sim=".$fila_sub['id_sub_sim']." ";
		$sql_cantidad.="and id_curso=".$cmb_curso;
		$res_sql_cantidad=@pg_exec($conn,$sql_cantidad);
		$cantidad=pg_result($res_sql_cantidad,0);
		
		$promedio_subsector = round($prom_sub/$cantidad);
		
		?>
        <input name="suma_casilla<?=$j?>" type="text" id="suma_casilla<?=$j?>" value="<? if($res_puntaje!=NULL){ echo $promedio_subsector; }?>" size="4" 
        onselect="fn(this.form,this.id,<?=$j?>,<?=$f?>)" ></td>
		<? }?>
       <!-- <td align="center"><input name="suma_puntaje" type="text" id="suma_puntaje" value="" size="4"></td>-->
       <td align="center">
	   <?
			$sql_prom="SELECT puntaje FROM simce_inst_2009 WHERE rdb=".$institucion." and id_curso=".$cmb_curso." and id_ano=".$ano;
			$res_prom=@pg_exec($conn,$sql_prom);
			$prom_final=pg_result($res_prom,0);
			?>
	   <input name="suma_promedio" type="text" id="suma_promedio" value="<? if($res_prom!=NULL){ echo $prom_final; }?>" size="4" onBlur="cargarpuntos(this.id,0,<?=$_ANO?>,9999,<?=$institucion?>,<?=$curso?>)" onKeyUp="fn(this.form,this.id,<?=$f?>,<?=$j?>)"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <!--<td>&nbsp;</td>-->
      </tr>
    </table></td>
  </tr>
</table>

<? }?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="3" class="tableindex">Busqueda Resultados SIMCE </td>
      </tr>
    <tr>
    <tr>
      <td class="cuadro01">Curso</td>
      <td class="cuadro01">
	  
	  <?	$sql="SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso,";
	   		$sql.="tipo_ensenanza.nombre_tipo, curso.ensenanza FROM curso INNER JOIN simce_conf_2009 ON";
			$sql.=" (curso.ensenanza=simce_conf_2009.ensenanza and curso.grado_curso=simce_conf_2009.grado)";
			$sql.=" INNER JOIN tipo_ensenanza ON (simce_conf_2009.ensenanza=tipo_ensenanza.cod_tipo) WHERE curso.id_ano=".$ano;
			$resultado_query_sub = pg_exec($conn,$sql);
	  ?>
	  	<select name="cmb_curso" class="ddlb_x">
		  <option value="0" selected>(Seleccione curso)</option>
		  <?  for($i=0 ; $i < @pg_numrows($resultado_query_sub) ; $i++){
				$fila_sub = @pg_fetch_array($resultado_query_sub,$i); 
					if ($fila_sub['id_curso'] == $cmb_curso){
						echo "<option value=".$fila_sub['id_curso']." selected>".$fila_sub['grado_curso']."-".$fila_sub['letra_curso']." ".$fila_sub['nombre_tipo']."</option>";
					}else{
						echo "<option value=".$fila_sub['id_curso'].">".$fila_sub['grado_curso']."-".$fila_sub['letra_curso']." ".$fila_sub['nombre_tipo']."</option>";
					}
			}?>
       	</select>	  
		</td>
      <td class="cuadro01"><input type="submit" name="buscar" class="botonXX" value="Buscar"></td>
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