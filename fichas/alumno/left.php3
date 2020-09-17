<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
 	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$frmModo		="mostrar";
	
	//----------------------------------------------------------------------------
	// AÑO ESCOLAR
	//----------------------------------------------------------------------------	
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano = @pg_Exec($conn, $sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = 	$fila_ano['nro_ano'];
	
	if($institucion==11106){
		$sql="SELECT * FROM MATRICULA WHERE RDB=".$institucion." AND RUT_ALUMNO='".$alumno."' ORDER BY ID_ANO DESC";
		$Rs_Alum = @pg_exec($conn,$sql);
		for($i=0;$i<@pg_numrows($Rs_Alum);$i++){
			$fils = @pg_fetch_array($Rs_Alum,$i);
			$sql="";
			$sql="SELECT notas$nro_ano.* FROM curso INNER JOIN ramo ON curso.id_curso=ramo.id_curso INNER JOIN notas$nro_ano ON ramo.id_ramo=notas$nro_ano.id_ramo WHERE curso.id_curso=" . $fils['id_curso'] . " AND rut_alumno=" . $alumno;
			$Rs_Curso =@pg_exec($conn,$sql);
			if(@pg_numrows($Rs_Curso)!=0){
				$_ANO=$fils["id_ano"];
				session_register('_ANO');

				$_CURSO=$fils["id_curso"];
				session_register('_CURSO');			
			}
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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

<body bgcolor="003b85" background="imag/fondopag.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('imag/ficha2.gif','imag/fmed2.gif','imag/fdeport2.gif','imag/salir2.gif','imag/docente2.gif','imag/notic2.gif','imag/calend2.gif','imag/mat2.gif','imag/fapod2.gif','imag/biblioteca2.gif','imag/horario2.gif','imag/lista2.gif','imag/listautiles2.gif','imag/diario_mural2.jpg')">
<table width="161" height="299" border="0" cellpadding="0" cellspacing="0">
    <tr> 
    <td width="161" height="34" valign="top"><font color="yellow" size="1" face="Arial, Helvetica, sans-serif"> 
      &nbsp;&nbsp;&nbsp;Bienvenido(a):<br>
      <?php
		$qryAlu="select * from alumno where rut_alumno=".$_ALUMNO;
		$resultAlu=@pg_Exec($conn,$qryAlu);
		$filaAlu=pg_fetch_array($resultAlu,0);?>
		&nbsp;&nbsp;&nbsp;<?php echo $filaAlu[nombre_alu]?>
      </font></td>
  </tr>
      <?
		$qryM="select * from periodo where id_ano=".$ano." order by id_periodo";
		$resultM=@pg_Exec($conn,$qryM);
		$filaM=pg_fetch_array($resultM,0);
 
  		if ($filaM['mostrar_notas']==1)
		{
  ?>
  <tr> 
    <td width="161" height="18"><a href="../fichaAlumno.php3" target="mainFrame"><img src="imag/ficha.gif" name="Image8" width="161" height="18" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','imag/ficha2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
    <?
  }
    if ($institucion!=24977 and $institucion!=25478){
  ?>

  <tr> 
    <!--td width="161" height="21"><a href="../seteaFichaMed.php3" target="mainFrame"><img src="imag/fmed.gif" name="Image9" width="161" height="21" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','imag/fmed2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td-->
    <td width="161" height="21"><a href="../fichaMedica.php3" target="mainFrame"><img src="imag/fmed.gif" name="Image9" width="161" height="21" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','imag/fmed2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
  <tr> 
    <td width="161" height="25"><a href="../fichaDeportiva.php3" target="mainFrame"><img src="imag/fdeport.gif" name="Image10" width="161" height="25" border="0" id="Image10" onMouseOver="MM_swapImage('Image10','','imag/fdeport2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
  <tr> 
    <td width="161" height="24"><a href="../fichaApoderados.php3" target="mainFrame"><img src="imag/fapod.gif" name="Image16" width="161" height="24" border="0" id="Image16" onMouseOver="MM_swapImage('Image16','','imag/fapod2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
  <tr> 
    <td width="161" height="25"><a href="../../admin/institucion/ano/curso/horario/listarHorario.php" target="mainFrame"><img src="imag/horario.gif" name="Image18" width="161" height="25" border="0" id="Image18" onMouseOver="MM_swapImage('Image18','','imag/horario2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
  <tr> 
    <td width="161" height="25"><a href="../../admin/institucion/ano/curso/alumno/listarAlumnos.php3" target="mainFrame"><img src="imag/lista.gif" name="Image420" width="161" height="25" border="0" id="Image420" onMouseOver="MM_swapImage('Image420','','imag/lista2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
  <tr> 
    <td width="161" height="25"><a href="../FichaProfesores.php" target="mainFrame"><img src="imag/profesores.gif" name="Image20" width="161" height="25" border="0" id="Image27" onMouseOver="MM_swapImage('Image27','','imag/profesores2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>  
 <!-- <tr> 
    <td width="161" height="25"><a href="#"><img src="imag/listautiles.gif" name="Image21" width="161" height="25" border="0" id="Image21" onMouseOver="MM_swapImage('Image21','','imag/listautiles2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
-->  <tr> 
    <td width="161" height="25"><a href="../fichaContenidos.php3" target="mainFrame"><img src="imag/mat.gif" name="Image11" width="161" height="25" border="0" id="Image11" onMouseOver="MM_swapImage('Image11','','imag/mat2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
  <!--<tr> 
    <td width="161" height="23"><a href="#"><img src="imag/calend.gif" name="Image12" width="161" height="23" border="0" id="Image12" onMouseOver="MM_swapImage('Image12','','imag/calend2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>-->
  <!--tr> 
    <td width="161" height="23"><a href="../../admin/institucion/noticia/listarNoticia.php3?agrupacion=1" target="mainFrame"><img src="imag/notic.gif" name="Image13" width="161" height="23" border="0" id="Image13" onMouseOver="MM_swapImage('Image13','','imag/notic2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr-->
  <!--tr>
    <td width="161" height="23"><a href="../../admin/institucion/biblioteca/listarLibros.php" target="mainFrame"><img src="imag/biblioteca.gif" name="Image17" width="161" height="23" border="0" id="Image17" onMouseOver="MM_swapImage('Image17','','imag/biblioteca2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr-->
  <!--<tr>
    <td width="161" height="25"><a href="http://www.colegioelectronico.com/coe/docente/main.htm" target="mainFrame"><img src="imag/docente.gif" name="Image14" width="161" height="25" border="0" id="Image14" onMouseOver="MM_swapImage('Image14','','imag/docente2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>-->
  <tr> 
    <td width="161" height="28" valign="bottom"><a href="../../admin/institucion/ano/curso/comunicacion/ListaComunicacion.php" target="mainFrame"><img src="imag/comunicaciones.jpg" name="Image100" width="161" height="25" border="0" id="Image100" onMouseOver="MM_swapImage('Image100','','imag/comunicaciones2.jpg',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
  <tr> 
    <td width="161" height="24" valign="bottom"><a href="contenidos.htm" target="mainFrame"><img src="imag/cont_dig.gif" name="Image22" width="161" height="18" border="0" id="Image22" onMouseOver="MM_swapImage('Image22','','imag/cont_dig2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
  <tr>
  	<td width="161" height="25"><a href="../diario/ListadoNoticias.php" target="mainFrame" onMouseOver="MM_swapImage('Image14','','imag/diario_mural2.jpg',1)" onMouseOut="MM_swapImgRestore()"><img src="imag/diario_mural.jpg" name="Image14" width="161" height="23" border="0"></a></td>
  </tr>
  <tr>
    <td width="161" height="23"><a href="../../admin/institucion/ano/curso/alumno/usuario/claveAcceso.php3" target="mainFrame"><img src="imag/clave.gif" name="Image432" width="161" height="23" border="0" id="Image432" onMouseOver="MM_swapImage('Image432','','imag/clave2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
  <tr>
    <td width="161" height="28" valign="bottom"><a href="../../admin/institucion/Colegio_restore/Reportes/Rpt18/rpt18.php?tipo=<? echo trim($tipo)?>&c_curso=<? echo trim($curso)?>&c_alumno=<? echo $alumno?>" target="mainFrame"><img src="imag/informe.gif" name="Image470" width="161" height="23" border="0" id="Image470" onMouseOver="MM_swapImage('Image470','','imag/informe2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
<? } ?>  
  <?php if ($_USUARIO=="22278"){?>
  <tr>
    <td width="161" height="28" valign="bottom"><a href="../../admin/institucion/webmail/verMail.php" target="mainFrame"><font color="#FFFFFF">REVISA 
      TU CORREO</font></a></td>
  </tr>
  <tr>
    <td width="161" height="25" valign="bottom"><a href="../../admin/institucion/webmail/crearMail.htm" target="mainFrame"><font color="#FFFFFF">CREAR 
      CORREO</font></a></td>
  </tr>  
  <?php }?>
</table>
</body>
</html>
