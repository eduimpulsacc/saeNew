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
	$curso			= $cmb_curso;	
	$_POSP = 4;
	$_bot = 8;

	if (empty($curso) or empty($mes)){
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
	//-----------------------
	$sql = "select * from curso where id_ano = ".$ano." and id_curso = ".$curso;
	//-----------------------
	$result =pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);
	$id_curso = $fila["id_curso"];
	$ensenanza = $fila["ensenanza"];	
	if (!$result) 
	{
		error('<B> ERROR :</b>Error al acceder a la BD. (CURSOS)</B>');
	}
	else
	{
	if (pg_numrows($result)!=0)
	{//En caso de estar el arreglo vacio.
		$fila = @pg_fetch_array($result,0);	
		if (!$fila)
		{
			error('<B> ERROR :</b>Error al acceder a la BD. (CURSOS)</B>');
			exit();
		}
	}
	}
	//---------------------------------------
	$sql = "select * from tipo_ensenanza where cod_tipo = " .$ensenanza;
	$result01 =pg_Exec($conn,$sql);
	$fila01 = @pg_fetch_array($result01,0);	
	$ensenanza_pal = $fila01['nombre_tipo'] ;
	//---------------------------------------
	//-----------------------
	
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
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
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
								  <?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
<table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="30" align="center" valign="top"> 
      
	  <?
						include("../../../../cabecera/menu_inferior.php");
						?>
	  
	 </td>
		</tr> 
  
  
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<?
if (empty($curso) or empty($mes)){
   ## no hace nada
}else{
   ?>   

<center>
<table width="819" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="839"><table width="827" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="827"><div id="capa0">
		        <div align="right"> <font size="1" face="Arial, Helvetica, sans-serif">**Imprimir 
                  horizontal**</font>
<input name="button3" TYPE="button" class="botonXX" onClick="MM_openBrWindow('printAsistenciaMes.php?cmb_meses=<?=$cmb_meses ?>&cmb_curso=<?=$cmb_curso ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">				  
				 	
		    </div>
        </div></td>
      </tr>
    </table>
	<table width="826" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ins_pal));?></strong></font></td>
    <td width="10">&nbsp;</td>
    <td width="125" rowspan="4" align="center">

		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td width="125" align="center">
	<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## c�digo para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
	  		</td>
		</tr>
      </table>
	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono: &nbsp;<? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
            <td height="41" valign="top"><span class="cuadro01"><strong>ASISTENCIA &nbsp;<? echo CursoPalabra($curso, 1, $conn)?></strong></span></td>
    <td>&nbsp;</td>
    </tr>  
</table>
<br>	
<table width="826" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="tableindex">INFORME GENERAL DE ASISTENCIA MENSUAL</td>
  </tr>
  <tr>
    <td align="center" class="cuadro01"><strong><? echo trim(strtoupper($mes_pal . " " . $nro_ano)) ;?></strong></td>
  </tr>
</table>
<br>
<table width="827" border="1" cellpadding="0" cellspacing="0">
<? 
  $cadena4 = "";
  for($YYY=0 ; $YYY < 31 ; $YYY++)
  {
  	$dia_num = $YYY+1;
	if (FechaValida($mes,$dia_num,$nro_ano, $ano))
		$cadena4 = $cadena4 . ";" . $dia_num;
	else
		$cadena4 = $cadena4 . ";" . ".";
	}

	$dias_semana = explode(";",$cadena4);
	$cadena5 = "";
  for($YYYY=0 ; $YYYY < 31 ; $YYYY++)
  {
  	$dia_num = $YYYY+1;
	$fecha = mktime(0,0,0,$mes,$dia_num,$nro_ano);
	$dia_pal = strftime("%a",$fecha);
	if (FechaValida($mes,$dia_num,$nro_ano, $ano))
		$cadena5 = $cadena5 . ";" . strtoupper(substr($dia_pal,0,1));
	else
	//else
		$cadena5 = $cadena5 . ";" . ".";
	}
	$dias_letra = explode(";",$cadena5);
		?> 
  <tr class="cuadro02">
    <td width="78"><? echo $mes_pal ?></td>
    <td><? echo $dias_semana[1];?></td>
    <td><? echo $dias_semana[2];?></td>
    <td><? echo $dias_semana[3];?></td>
    <td><? echo $dias_semana[4];?></td>
    <td><? echo $dias_semana[5];?></td>
    <td><? echo $dias_semana[6];?></td>
    <td><? echo $dias_semana[7];?></td>
    <td><? echo $dias_semana[8];?></td>
    <td><? echo $dias_semana[9];?></td>
    <td><? echo $dias_semana[10];?></td>
    <td><? echo $dias_semana[11];?></td>
    <td><? echo $dias_semana[12];?></td>
    <td><? echo $dias_semana[13];?></td>
    <td><? echo $dias_semana[14];?></td>
    <td><? echo $dias_semana[15];?></td>
    <td><? echo $dias_semana[16];?></td>
    <td><? echo $dias_semana[17];?></td>
    <td><? echo $dias_semana[18];?></td>
    <td><? echo $dias_semana[19];?></td>
    <td><? echo $dias_semana[20];?></td>
    <td><? echo $dias_semana[21];?></td>
    <td><? echo $dias_semana[22];?></td>
    <td><? echo $dias_semana[23];?></td>
    <td><? echo $dias_semana[24];?></td>
    <td><? echo $dias_semana[25];?></td>
    <td><? echo $dias_semana[26];?></td>
    <td><? echo $dias_semana[27];?></td>
    <td><? echo $dias_semana[28];?></td>
    <td><? echo $dias_semana[29];?></td>
    <td><? echo $dias_semana[30];?></td>
    <td><? echo $dias_semana[31];?></td>
    <td width="37">TOTAL</td>
    <td width="51">% ASIS</td>
    </tr>
  <tr class="cuadro01">
    <td height="28">&nbsp;</td>
    <td><? echo $dias_letra[1];?></td>
    <td><? echo $dias_letra[2];?></td>
    <td><? echo $dias_letra[3];?></td>
    <td><? echo $dias_letra[4];?></td>
    <td><? echo $dias_letra[5];?></td>
    <td><? echo $dias_letra[6];?></td>
    <td><? echo $dias_letra[7];?></td>
    <td><? echo $dias_letra[8];?></td>
    <td><? echo $dias_letra[9];?></td>
    <td><? echo $dias_letra[10];?></td>
    <td><? echo $dias_letra[11];?></td>
    <td><? echo $dias_letra[12];?></td>
    <td><? echo $dias_letra[13];?></td>
    <td><? echo $dias_letra[14];?></td>
    <td><? echo $dias_letra[15];?></td>
    <td><? echo $dias_letra[16];?></td>
    <td><? echo $dias_letra[17];?></td>
    <td><? echo $dias_letra[18];?></td>
    <td><? echo $dias_letra[19];?></td>
    <td><? echo $dias_letra[20];?></td>
    <td><? echo $dias_letra[21];?></td>
    <td><? echo $dias_letra[22];?></td>
    <td><? echo $dias_letra[23];?></td>
    <td><? echo $dias_letra[24];?></td>
    <td><? echo $dias_letra[25];?></td>
    <td><? echo $dias_letra[26];?></td>
    <td><? echo $dias_letra[27];?></td>
    <td><? echo $dias_letra[28];?></td>
    <td><? echo $dias_letra[29];?></td>
    <td><? echo $dias_letra[30];?></td>
    <td><? echo $dias_letra[31];?></td>	
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
   <?
  ?>
  <tr>
    <td class="cuadro01">
	
	<? 
		//-----------------------------------------
		$Curso_pal = CursoPalabra($id_curso, 3, $conn);
		echo "<strong>".$Curso_pal."</strong>" ;
		//----------------------------------------
	?>
	</td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr class="cuadro01">
  <? 
	$cadena="";
	$total_mat=0;
	$matricula_a = ""; 			
	$asistentes_a = ""; 			
	$inasistentes_a = ""; 			
	for($Y=0 ; $Y < 31 ; $Y++)
  	{
		$dia = $Y+1;
		if (($Y+1)<10) 
			$dia = "0".($Y+1);
		//-------------------
		$sql_consulta ="";
		$sql_consulta = $sql_consulta . "select count(*) as cantidad from matricula where id_curso = ".$id_curso;
		$sql_consulta = $sql_consulta . " and fecha <= '".$mes."-".$dia."-".$nro_ano."' and bool_ar = 0 union ";
		$sql_consulta = $sql_consulta . "select count(*) as cantidad from asistencia where id_curso = ".$id_curso;
		$sql_consulta = $sql_consulta . " and fecha = '".$mes."-".$dia."-".$nro_ano."'";
		//------------------- Consulto las inasistencias que han sido justificadas
		$sql_justifica = "select count(*) as cantidad from justifica_inasistencia where id_curso = '$id_curso' and fecha = '$mes-$dia-$nro_ano'";		

		if (FechaValida($mes,$dia,$nro_ano, $ano))
		{
			//----------------------------------------------------
			$result_consulta =pg_Exec($conn,$sql_consulta);
			$fila_comsulta = @pg_fetch_array($result_consulta,1);
			$total_mat = $total_mat + $fila_comsulta['cantidad']; 
			$matricula_a[$Y+1] = $fila_comsulta['cantidad']; 
			//------------ Justifica INasistecia -----------------
			$res_justifica =  @pg_Exec($sql_justifica);
			$fila_justifica = @pg_fetch_array($res_justifica);
			$justificados = $fila_justifica['cantidad'];
			//----------------------------------------------------
			$fila_comsulta = @pg_fetch_array($result_consulta,0);
			$asistentes = ($matricula_a[$Y+1] - $fila_comsulta['cantidad']);
			$asistentes_a[$Y+1] = $asistentes + $justificados;  // Se les agrega + y - $justificados
			$inasistentes_a[$Y+1] = $fila_comsulta['cantidad'] - $justificados; 
			$total_asis = $total_asis + $asistentes + $justificados; 
			$total_ause = $total_ause + $fila_comsulta['cantidad'] - $justificados; 			
		}
		else
		{
			$matricula_a[$Y+1] = "."; 			
			$asistentes_a[$Y+1] = "."; 			
			$inasistentes_a[$Y+1] = "."; 			
		}
		
	}
	
	?>
    <td height="30"  class="cuadro02">Asistencia</td>
    <td><? echo $asistentes_a[1]; $asis1 = $asis1 + $asistentes_a[1];?></td>
    <td><? echo $asistentes_a[2]; $asis2 = $asis2 + $asistentes_a[2];?></td>
    <td><? echo $asistentes_a[3]; $asis3 = $asis3 + $asistentes_a[3];?></td>
    <td><? echo $asistentes_a[4]; $asis4 = $asis4 + $asistentes_a[4];?></td>
    <td><? echo $asistentes_a[5]; $asis5 = $asis5 + $asistentes_a[5];?></td>
    <td><? echo $asistentes_a[6]; $asis6 = $asis6 + $asistentes_a[6];?></td>
    <td><? echo $asistentes_a[7]; $asis7 = $asis7 + $asistentes_a[7];?></td>
    <td><? echo $asistentes_a[8]; $asis8 = $asis8 + $asistentes_a[8];?></td>
    <td><? echo $asistentes_a[9]; $asis9 = $asis9 + $asistentes_a[9];?></td>
    <td><? echo $asistentes_a[10]; $asis10 = $asis10 + $asistentes_a[10];?></td>
    <td><? echo $asistentes_a[11]; $asis11 = $asis11 + $asistentes_a[11];?></td>
    <td><? echo $asistentes_a[12]; $asis12 = $asis12 + $asistentes_a[12];?></td>
    <td><? echo $asistentes_a[13]; $asis13 = $asis13 + $asistentes_a[13];?></td>
    <td><? echo $asistentes_a[14]; $asis14 = $asis14 + $asistentes_a[14];?></td>
    <td><? echo $asistentes_a[15]; $asis15 = $asis15 + $asistentes_a[15];?></td>
    <td><? echo $asistentes_a[16]; $asis16 = $asis16 + $asistentes_a[16];?></td>
    <td><? echo $asistentes_a[17]; $asis17 = $asis17 + $asistentes_a[17];?></td>
    <td><? echo $asistentes_a[18]; $asis18 = $asis18 + $asistentes_a[18];?></td>
    <td><? echo $asistentes_a[19]; $asis19 = $asis19 + $asistentes_a[19];?></td>
    <td><? echo $asistentes_a[20]; $asis20 = $asis20 + $asistentes_a[20];?></td>
    <td><? echo $asistentes_a[21]; $asis21 = $asis21 + $asistentes_a[21];?></td>
    <td><? echo $asistentes_a[22]; $asis22 = $asis22 + $asistentes_a[22];?></td>
    <td><? echo $asistentes_a[23]; $asis23 = $asis23 + $asistentes_a[23];?></td>
    <td><? echo $asistentes_a[24]; $asis24 = $asis24 + $asistentes_a[24];?></td>
    <td><? echo $asistentes_a[25]; $asis25 = $asis25 + $asistentes_a[25];?></td>
    <td><? echo $asistentes_a[26]; $asis26 = $asis26 + $asistentes_a[26];?></td>
    <td><? echo $asistentes_a[27]; $asis27 = $asis27 + $asistentes_a[27];?></td>
    <td><? echo $asistentes_a[28]; $asis28 = $asis28 + $asistentes_a[28];?></td>
    <td><? echo $asistentes_a[29]; $asis29 = $asis29 + $asistentes_a[29];?></td>
    <td><? echo $asistentes_a[30]; $asis30 = $asis30 + $asistentes_a[30];?></td>
    <td><? echo $asistentes_a[31]; $asis31 = $asis31 + $asistentes_a[31];?></td>
    <td><? echo $total_asis;?></td>
	<td>
	<? 
	
	if ($total_mat>0) 
	{
	  echo round(($total_asis*100)/$total_mat,2)."%"; 
	  $promedio_gral = $promedio_gral + round(($total_asis*100)/$total_mat,2);
	  $cont_gral = $cont_gral + 1;
	}
	else 
	  echo "&nbsp;";
	  ?></td>
    </tr>
  <tr class="cuadro01">
    <td height="30" class="cuadro02">Ausentes</td>
    <td><? echo $inasistentes_a[1]; $inasis1 = $inasis1 + $inasistentes_a[1];?></td>
    <td><? echo $inasistentes_a[2]; $inasis2 = $inasis2 + $inasistentes_a[2];?></td>
    <td><? echo $inasistentes_a[3]; $inasis3 = $inasis3 + $inasistentes_a[3];?></td>
    <td><? echo $inasistentes_a[4]; $inasis4 = $inasis4 + $inasistentes_a[4];?></td>
    <td><? echo $inasistentes_a[5]; $inasis5 = $inasis5 + $inasistentes_a[5];?></td>
    <td><? echo $inasistentes_a[6]; $inasis6 = $inasis6 + $inasistentes_a[6];?></td>
    <td><? echo $inasistentes_a[7]; $inasis7 = $inasis7 + $inasistentes_a[7];?></td>
    <td><? echo $inasistentes_a[8]; $inasis8 = $inasis8 + $inasistentes_a[8];?></td>
    <td><? echo $inasistentes_a[9]; $inasis9 = $inasis9 + $inasistentes_a[9];?></td>
    <td><? echo $inasistentes_a[10]; $inasis10 = $inasis10 + $inasistentes_a[10];?></td>
    <td><? echo $inasistentes_a[11]; $inasis11 = $inasis11 + $inasistentes_a[11];?></td>
    <td><? echo $inasistentes_a[12]; $inasis12 = $inasis12 + $inasistentes_a[12];?></td>
    <td><? echo $inasistentes_a[13]; $inasis13 = $inasis13 + $inasistentes_a[13];?></td>
    <td><? echo $inasistentes_a[14]; $inasis14 = $inasis14 + $inasistentes_a[14];?></td>
    <td><? echo $inasistentes_a[15]; $inasis15 = $inasis15 + $inasistentes_a[15];?></td>
    <td><? echo $inasistentes_a[16]; $inasis16 = $inasis16 + $inasistentes_a[16];?></td>
    <td><? echo $inasistentes_a[17]; $inasis17 = $inasis17 + $inasistentes_a[17];?></td>
    <td><? echo $inasistentes_a[18]; $inasis18 = $inasis18 + $inasistentes_a[18];?></td>
    <td><? echo $inasistentes_a[19]; $inasis19 = $inasis19 + $inasistentes_a[19];?></td>
    <td><? echo $inasistentes_a[20]; $inasis20 = $inasis20 + $inasistentes_a[20];?></td>
    <td><? echo $inasistentes_a[21]; $inasis21 = $inasis21 + $inasistentes_a[21];?></td>
    <td><? echo $inasistentes_a[22]; $inasis22 = $inasis22 + $inasistentes_a[22];?></td>
    <td><? echo $inasistentes_a[23]; $inasis23 = $inasis23 + $inasistentes_a[23];?></td>
    <td><? echo $inasistentes_a[24]; $inasis24 = $inasis24 + $inasistentes_a[24];?></td>
    <td><? echo $inasistentes_a[25]; $inasis25 = $inasis25 + $inasistentes_a[25];?></td>
    <td><? echo $inasistentes_a[26]; $inasis26 = $inasis26 + $inasistentes_a[26];?></td>
    <td><? echo $inasistentes_a[27]; $inasis27 = $inasis27 + $inasistentes_a[27];?></td>
    <td><? echo $inasistentes_a[28]; $inasis28 = $inasis28 + $inasistentes_a[28];?></td>
    <td><? echo $inasistentes_a[29]; $inasis29 = $inasis29 + $inasistentes_a[29];?></td>
    <td><? echo $inasistentes_a[30]; $inasis30 = $inasis30 + $inasistentes_a[30];?></td>
    <td><? echo $inasistentes_a[31]; $inasis31 = $inasis31 + $inasistentes_a[31];?></td>
	<td><? echo $total_ause; ?></td>
    <td>&nbsp;</td>
	</tr>
  <tr class="cuadro01">
	<td height="30" class="cuadro02">Matr&iacute;cula</td>
    <td><? echo $matricula_a[1]; $mat1 = $mat1 + $matricula_a[1];?></td>
    <td><? echo $matricula_a[2]; $mat2 = $mat2 + $matricula_a[2];?></td>
    <td><? echo $matricula_a[3]; $mat3 = $mat3 + $matricula_a[3];?></td>
    <td><? echo $matricula_a[4]; $mat4 = $mat4 + $matricula_a[4];?></td>
    <td><? echo $matricula_a[5]; $mat5 = $mat5 + $matricula_a[5];?></td>
    <td><? echo $matricula_a[6]; $mat6 = $mat6 + $matricula_a[6];?></td>
    <td><? echo $matricula_a[7]; $mat7 = $mat7 + $matricula_a[7];?></td>
    <td><? echo $matricula_a[8]; $mat8 = $mat8 + $matricula_a[8];?></td>
    <td><? echo $matricula_a[9]; $mat9 = $mat9 + $matricula_a[9];?></td>
    <td><? echo $matricula_a[10]; $mat10 = $mat10 + $matricula_a[10];?></td>
    <td><? echo $matricula_a[11]; $mat11 = $mat11 + $matricula_a[11];?></td>
    <td><? echo $matricula_a[12]; $mat12 = $mat12 + $matricula_a[12];?></td>
    <td><? echo $matricula_a[13]; $mat13 = $mat13 + $matricula_a[13];?></td>
    <td><? echo $matricula_a[14]; $mat14 = $mat14 + $matricula_a[14];?></td>
    <td><? echo $matricula_a[15]; $mat15 = $mat15 + $matricula_a[15];?></td>
    <td><? echo $matricula_a[16]; $mat16 = $mat16 + $matricula_a[16];?></td>
    <td><? echo $matricula_a[17]; $mat17 = $mat17 + $matricula_a[17];?></td>
    <td><? echo $matricula_a[18]; $mat18 = $mat18 + $matricula_a[18];?></td>
    <td><? echo $matricula_a[19]; $mat19 = $mat19 + $matricula_a[19];?></td>
    <td><? echo $matricula_a[20]; $mat20 = $mat20 + $matricula_a[20];?></td>
    <td><? echo $matricula_a[21]; $mat21 = $mat21 + $matricula_a[21];?></td>
    <td><? echo $matricula_a[22]; $mat22 = $mat22 + $matricula_a[22];?></td>
    <td><? echo $matricula_a[23]; $mat23 = $mat23 + $matricula_a[23];?></td>
    <td><? echo $matricula_a[24]; $mat24 = $mat24 + $matricula_a[24];?></td>
    <td><? echo $matricula_a[25]; $mat25 = $mat25 + $matricula_a[25];?></td>
    <td><? echo $matricula_a[26]; $mat26 = $mat26 + $matricula_a[26];?></td>
    <td><? echo $matricula_a[27]; $mat27 = $mat27 + $matricula_a[27];?></td>
    <td><? echo $matricula_a[28]; $mat28 = $mat28 + $matricula_a[28];?></td>
    <td><? echo $matricula_a[29]; $mat29 = $mat29 + $matricula_a[29];?></td>
    <td><? echo $matricula_a[30]; $mat30 = $mat30 + $matricula_a[30];?></td>
    <td><? echo $matricula_a[31]; $mat31 = $mat31 + $matricula_a[31];?></td>
    <td><? echo $total_mat;?></td>
    <td>&nbsp;</td>
    </tr>

</table>  
<table width="827" border="0" cellspacing="0" cellpadding="0">
  <tr><br>
    <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Promedio Asistencia Mes : <? if ($cont_gral>0) echo round($promedio_gral/$cont_gral,2)."%"; else echo "&nbsp;";?></strong></font></div></td>
  </tr>
</table>
  </td>
  </tr>
  
</table>
<?
}

function FechaValida($mes_f, $dia_f, $ano_f, $ano_esc)
{
	$sw = 0;
	$conn=@pg_connect("dbname=coe port=1550 user=postgres password=usuariocoegc10");
	
		
	
	if (strlen($mes_f)==1)
		$mes_f = "0".$mes_f;
	if (strlen($dia_f)==1)
		$dia_f = "0".$dia_f;
		
	$fecha_f = mktime(0,0,0,$mes_f,$dia_f,$ano_f);
	$dia_pal_f = strftime("%a",$fecha_f);
	
	if (checkdate($mes_f, $dia_f, $ano_f) and ($dia_pal_f <> "s�b" and $dia_pal_f <> "dom" )) 
	{
		$sql_feriado = "select count(*) as cantidad from feriado where id_ano = " . $ano_esc . " and fecha_inicio <= '".$mes_f."-".$dia_f."-".$ano_f."' and fecha_fin >= '".$mes_f."-".$dia_f."-".$ano_f."'";
		$result_feriado = @pg_Exec($conn,$sql_feriado);
		$fila_feriado = @pg_fetch_array($result_feriado,0);	
		$feriado = $fila_feriado['cantidad'];
		if ($feriado==0)
		{
			$sw = 0;
		}
		else
		{
			$sw = 1;
		}
	}
	else
	{
		$sw = 1;
	}
		
	if ($sw == 0)
		return true;
	else
		return false;
}

?>
 

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->



<form action="AsistenciaMes.php" method="post">
<? 

echo "$ano<br>";
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
//------------------
$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);

//------------------
?>
<center>
<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="662" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="658" class="tableindex"><div align="center">Buscador Avanzado</div></td>
  </tr>
  <tr>
    <td height="27">
	<table width="658" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="74"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><strong>Buscar por </strong></font></td>
    <td width="345">
	  <div align="left">
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x">
          <option value=0 selected>(Seleccione Curso)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["id_curso"]==$cmb_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
        </select>
	    </font></div></td>
    <td width="29">&nbsp;</td>
    <td width="120">
	  <div align="left"></div>		</td>
    <td width="90"><div align="right"></div></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><strong>Mes</strong></font></td>
    <td><select name="cmb_meses" class="ddlb_9_x">
      <?
		  if ($cmb_meses == 1){
		     ?>
      <option value="1" selected>Enero</option>
      <?
		  }else{
		  	 ?>
      <option value="1">Enero</option>
      <?
	      }
		  if ($cmb_meses == 2){
		     ?>
      <option value="2" selected>Febrero</option>
      <?
		  }else{
		  	 ?>
      <option value="2">Febrero</option>
      <?
	      }
		  if ($cmb_meses == 3){
		     ?>
      <option value="3" selected>Marzo</option>
      <?
		  }else{
		  	 ?>
      <option value="3">Marzo</option>
      <?
	      }
		  if ($cmb_meses == 4){
		     ?>
      <option value="4" selected>Abril</option>
      <?
		  }else{
		  	 ?>
      <option value="4">Abril</option>
      <?
	      }
		  if ($cmb_meses == 5){
		     ?>
      <option value="5" selected>Mayo</option>
      <?
		  }else{
		  	 ?>
      <option value="5">Mayo</option>
      <?
	      }
		  if ($cmb_meses == 6){
		     ?>
      <option value="6" selected>Junio</option>
      <?
		  }else{
		  	 ?>
      <option value="6">Junio</option>
      <?
	      }
		  if ($cmb_meses == 7){
		     ?>
      <option value="7" selected>Julio</option>
      <?
		  }else{
		  	 ?>
      <option value="7">Julio</option>
      <?
	      }
		  if ($cmb_meses == 8){
		     ?>
      <option value="8" selected>Agosto</option>
      <?
		  }else{
		  	 ?>
      <option value="8">Agosto</option>
      <?
	      }
		  if ($cmb_meses == 9){
		     ?>
      <option value="9" selected>Septiembre</option>
      <?
		  }else{
		  	 ?>
      <option value="9">Septiembre</option>
      <?
	      }
		  if ($cmb_meses == 10){
		     ?>
      <option value="10" selected>Octubre</option>
      <?
		  }else{
		  	 ?>
      <option value="10">Octubre</option>
      <?
	      }
		  if ($cmb_meses == 11){
		     ?>
      <option value="11" selected>Noviembre</option>
      <?
		  }else{
		  	 ?>
      <option value="11">Noviembre</option>
      <?
	      }
		  if ($cmb_meses == 12){
		     ?>
      <option value="12" selected>Diciembre</option>
      <?
		  }else{
		  	 ?>
      <option value="12">Diciembre</option>
      <?
	      }
		  
		  ?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="cb_ok" type="submit" class="botonXX"  value="Buscar"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>
				 
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
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
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>