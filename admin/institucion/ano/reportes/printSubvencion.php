<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?php require('../../../../util/header.inc');
setlocale(LC_ALL,"es_ES");
	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$mes 			= $cmb_meses;	
	
	if ($mes < 10){
	   $mes = "0".$mes;
	}
	
	$_POSP = 4;
	$_bot = 8;

	if (empty($mes)){
	 //exit;
	}else{ 
		if ($mes == 1) $mes_pal = "Enero";
	    if ($mes == 2) $mes_pal = "Febrero";
	    if ($mes == 3) $mes_pal = "Marzo";
	    if ($mes == 4) $mes_pal = "Abril";
	    if ($mes == 5) $mes_pal = "Mayo";
	    if ($mes == 6) $mes_pal = "Junio";
	    if ($mes == 7) $mes_pal = "Julio";
	    if ($mes == 8) $mes_pal = "Agosto";
	    if ($mes == 9) $mes_pal = "Septiembre";
	    if ($mes == 10) $mes_pal = "Octubre";
	    if ($mes == 11) $mes_pal = "Noviembre";
	    if ($mes == 12) $mes_pal = "Diciembre";
	    $dia_1 = "01"; 	$dia_2 = "02"; 	$dia_3 = "03";  $dia_4 = "04";	
	    $dia_5 = "05";	$dia_6 = "06";	$dia_7 = "07";	$dia_8 = "08";	
	    $dia_9 = "09";	$dia_10 = "10";	$dia_11 = "11";	$dia_12 = "12";	
	    $dia_13 = "13";	$dia_14 = "14";	$dia_15 = "15";	$dia_16 = "16";	
	    $dia_17 = "17";	$dia_18 = "18";	$dia_19 = "19";	$dia_20 = "20";	
	    $dia_21 = "21";	$dia_22 = "22";	$dia_23 = "23";	$dia_24 = "24";	
	    $dia_25 = "25";	$dia_26 = "26";	$dia_27 = "27";	$dia_28 = "28";	
	    $dia_29 = "29";	$dia_30 = "30";	$dia_31 = "31";	
	
	    //-------------- INSTITUCION -------------------------------------------------------------
	    $sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
		$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
		$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
		$result_ins =@pg_Exec($conn,$sql_ins);
		$fila_ins = @pg_fetch_array($result_ins,0);	
		$ins_pal = $fila_ins['nombre_instit'];
		$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
		$telefono = $fila_ins['telefono'];

		$sql01 = "select nro_ano from ano_escolar where id_ano = " . $ano;
		$result01 =pg_Exec($conn,$sql01);
		if (!$result01) 
		{
		     error('<B> ERROR :</b>Error al acceder a la BD. (ANO ESCOLAR)</B>');
	    }
		else
		{
			if (pg_numrows($result01)!=0)
			{//En caso de estar el arreglo vacio.
				$fila01 = @pg_fetch_array($result01,0);	
				if (!$fila01)
					{
					error('<B> ERROR :</b>Error al acceder a la BD. (ANO ESCOLAR)</B>');
					exit();
				}
			}
		}
		$nro_ano = $fila01['nro_ano'];
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
function cerrar(){ 
window.close() 
} 
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 
                              <!-- INICIO CUERPO DE LA PAGINA -->
                              <?
if (empty($mes)){
   ## no hace nada
}else{
   ?>
                             
                                <table width="700" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="700">
									
									<div id="capa0">
										<table width="100%">
										  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
										<td align="right">
											<input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
									  </td></tr></table>									
									</div>							
									
									
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="85%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ins_pal));?></strong></font></td>
                                            <td width="10">&nbsp;</td>
                                            <td width="15%" rowspan="4" align="center">
											
											
											  <table width="125" border="0" cellpadding="0" cellspacing="0">
                                                <tr valign="top">
                                                  <td width="125" align="center"><?
													$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
													$arr=@pg_fetch_array($result,0);
													$fila_foto = @pg_fetch_array($result,0);
													## código para tomar la insignia
											
												    if($institucion!=""){
													    echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
												    }else{
													    echo "<img src='".$d."menu/imag/logo.gif' >";
												    }?>                                                  </td>
                                                </tr>
                                            </table></td>
                                          </tr>
                                          <tr>
                                            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono: &nbsp;<? echo ucwords(strtolower($telefono));?></font></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                      </table>
                                      <br>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td align="center" class="tableindex">INFORME DE PROYECCIÓN A LA SUBVENCI&Oacute;N MENSUAL</td>
                                          </tr>
                                          <tr>
                                            <td align="center" class="cuadro01"><strong><? echo trim(strtoupper($mes_pal . " " . $nro_ano)) ;?></strong></td>
                                          </tr>
                                      </table>
                                      <br>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="80%" class="tableindex">Cursos</td>
                                            <td width="20%" class="tableindex">Subvenci&oacute;n por cursos </td>
                                          </tr>
                                          <?
										  //tomo todos los cursos de la institucion
										  $sql_1 = "select * from curso where id_ano = '".$_ANO."' order by ensenanza, grado_curso, letra_curso";
										  $res_1 = @pg_Exec($conn,$sql_1);
										  $num_1 = @pg_numrows($res_1);
										  
										  for ($i=0; $i < $num_1; $i++){
										       $fil_1 = @pg_fetch_array($res_1,$i);
											   $id_curso = $fil_1['id_curso'];
											   $val_sub  = $fil_1['val_sub'];
											   
											   // buscar los alumnos de este curso
											   $qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista ";
											   $qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
											   $qry = $qry . " WHERE ((matricula.id_curso=".$id_curso.") AND ((matricula.bool_ar=0)or(matricula.bool_ar isnull))) ";
											   
											   $sql_2 = $qry;
											   
											   //$sql_2 = "select * from matricula where id_curso = '$id_curso' and bool_ar = '0'";
											   $res_2 = @pg_Exec($conn,$sql_2);
											   $num_2 = @pg_numrows($res_2);
											   											  											   
											   /// ciclo de los alumnos											   
											   $subvencion_alumno =0;
											   $subvencion = 0;
											   
											   for ($j=0; $j < $num_2; $j++){
											       $fil_2 = @pg_fetch_array($res_2,$j);
											       $rut_alumno = $fil_2['rut_alumno'];
												   
												   $sql_3 = "select count(*) as cantidad from asistencia where rut_alumno = '".$rut_alumno."' and fecha like '".$nro_ano."-".$mes."%'"; 
											       $res_3 = @pg_Exec($conn,$sql_3);
												   $fil_3 = @pg_fetch_array($res_3);
												   
												   $inasistencia = $fil_3['cantidad'];
												   												   												   
												   if ($inasistencia > 0){											   
													   /// Aplicar formula
													   $porcentaje = (($inasistencia * 100) / 22);													   
													   $x = round(($val_sub * $porcentaje) / 100);													   
													   $subvencion = $val_sub - $x;
													   
												   }else{												   
												       $subvencion = $val_sub;												   
												   }												   												   
												   $subvencion_alumno = $subvencion_alumno + $subvencion;
											   }	   
												
											    /// mostrar el total por curso												   
												   
											   ?>
                                          <tr>
                                            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo CursoPalabra($id_curso, 1, $conn)?></font></td>
                                            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                                              <div align="right">
                                                <?=round($subvencion_alumno); ?>
                                              </div>
                                            </font></td>
                                          </tr>
                                          <?										
										    $subvencion_curso = $subvencion_curso + round($subvencion_alumno);
																					
										  } ?>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td><div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Total proyecci&oacute;n de subvenci&oacute;n mensual </font></div></td>
                                            <td><div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">$
                                              <?=$subvencion_curso ?>
                                            </font></div></td>
                                          </tr>
                                      </table></td>
                                  </tr>
                                </table>
                                <?								
								
                               							   
}


?>
<!-- FIN CUERPO DE LA PAGINA -->
                              
</body>
</html>
<? pg_close($conn);?>