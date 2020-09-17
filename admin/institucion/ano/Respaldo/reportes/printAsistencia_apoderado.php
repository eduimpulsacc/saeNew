<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
require('../../../../util/header.inc');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 8;
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	
	//----------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	$nro_ano     = $fila_ano['nro_ano'];
	//----------
	$curso			=$cmb_curso;
	
	if (empty($curso)){
	   // exit;
	}else{
	   
	
	}
	if (empty($curso)){
	    $fecha1			= "";
	    $fecha2			= "";
	}else{	
	   
	}	
    
	
	if (empty($curso)){
	   // exit;
	}else{
	   
	//-----------------------------------------
	// Institución
	//-----------------------------------------
	$sql_insti = "Select * from institucion where rdb = " . $institucion;
	$result_insti =@pg_Exec($conn,$sql_insti);
	$fila_insti = @pg_fetch_array($result_insti,0);	
	$nombre_insti = $fila_insti['nombre_instit'];
	//-----------------------------------------
	// Curso
	//-----------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//--------------------------------------------
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat']) . " " . trim($fila_profe['ape_mat'] ) . " " . trim($fila_profe['nombre_emp'])));
	//-----------------------------------------
	// APODERADOS
	//-----------------------------------------
	$qry = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno in (select rut_alumno from matricula where id_curso = '$curso')) order by ape_pat, ape_mat";
	$result_apoderado = @pg_Exec($conn,$qry);
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	$sql_habiles = "select sum(dias_habiles) as dias_habiles from periodo where id_ano = ".$ano;
	$result_habiles =@pg_Exec($conn,$sql_habiles);
	$fila_habiles = @pg_fetch_array($result_habiles,0);	
	$dias_habiles = $fila_habiles['dias_habiles'];
	$sw = 0;
	if ($dias_habiles > 0) $sw = 1;
	if ($sw = 0)
	{
		echo "DEBE INGRESAR LOS DIAS HABILES EN EL SECTOR DE PERIODOS";
		exit;
	}
	
	}
	//-----------------------------------------
    	
	
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
//-->
</script>

<script> 
function cerrar(){ 
window.close() 
} 
</script>
<style type="text/css">
<!--
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; }
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; font-weight: bold; }
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->

<?
if (empty($curso)){
  ## no hace nada
}else{
   ?>  

  <form action="" method="get">
    <center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>

	<div id="capa0">
	<table width="100%">
	  <tr>
	<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
	<td align="right">
      <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	  </td></tr></table>
	 </div>
</td>
  </tr>
</table>

 <? if ($institucion=="770"){ 
		 echo "<br><br><br><br><br><br><br><br><br>";
 }
 
 ?>



<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		
		
	 <? if ($institucion=="770"){ 
		  
		  
		  
     }else{  ?>
	
	
	
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="125" align="center">
	 <?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
							</td>
			 </tr>
             </table>
			 
	
	<? } ?>			 
			 
			 
			 
	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono :<? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>











	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  align="center" class="tableindex">INFORME DE INASISTENCIAS DE APODERADOS</td>
  </tr>
  
</table>
<br>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
          <tr>
                    <td width="126"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></td>
            <td width="10" ><div align="left"><strong><font size="1" face="arial, geneva, helvetica">:</font></strong></div></td>
            <td width="514" ><font size="1" face="arial, geneva, helvetica"><? echo $Curso_pal; ?></font></td>
          </tr>
          <tr>
                    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor(a) 
                      Jefe</strong></font></td>
            <td ><div align="left"><strong><font size="1" face="arial, geneva, helvetica">:</font></strong></div></td>
            <td ><font size="1" face="arial, geneva, helvetica"><? echo $profe_jefe; ?></font></td>
          </tr>
        </table>
		<br>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="cccccc">
          <tr>
            <td width="23%" height="25" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">Apoderado</span></div></td>
            <td width="7%" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">Mar</span></div></td>
            <td width="7%" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">Abr</span></div></td>
            <td width="7%" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">May</span></div></td>
            <td width="7%" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">Jun</span></div></td>
            <td width="7%" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">Jul</span></div></td>
            <td width="7%" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">Ago</span></div></td>
            <td width="7%" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">Sep</span></div></td>
            <td width="7%" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">Oct</span></div></td>
            <td width="7%" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">Nov</span></div></td>
            <td width="7%" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">Dic</span></div></td>
            <td width="7%" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">Total</span></div></td>
          </tr>
		  <?	
		  for($i=0 ; $i < @pg_numrows($result_apoderado) ; $i++){
		     $fila = @pg_fetch_array($result_apoderado,$i);
		     $nombre_apo = ucwords(strtolower(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_apo'])));
		     $rut_apo = $fila['rut_apo'];
		     ?>
             <tr>
			 <?
			  // determinar la inasistencia por cada mes
			  $sql_asis = "select count(*) as cantidad from asistencia_apo where ano = ".$ano." and rut_apo = ".$rut_apo." and (fecha >='03-01-$nro_ano' and fecha <='03-31-$nro_ano')";
			  $result_asis =@pg_Exec($conn,$sql_asis);
			  $fila_asis = @pg_fetch_array($result_asis,0);
			  $dias_ausente = $fila_asis['cantidad'];
			  $marzo =	$dias_ausente;
			  
			  $sql_asis = "select count(*) as cantidad from asistencia_apo where ano = ".$ano." and rut_apo = ".$rut_apo." and (fecha >='04-01-$nro_ano' and fecha <='04-30-$nro_ano')";
			  $result_asis =@pg_Exec($conn,$sql_asis);
			  $fila_asis = @pg_fetch_array($result_asis,0);
			  $dias_ausente = $fila_asis['cantidad'];
			  $abril =	$dias_ausente;
			  
			  $sql_asis = "select count(*) as cantidad from asistencia_apo where ano = ".$ano." and rut_apo = ".$rut_apo." and (fecha >='05-01-$nro_ano' and fecha <='05-31-$nro_ano')";
			  $result_asis =@pg_Exec($conn,$sql_asis);
			  $fila_asis = @pg_fetch_array($result_asis,0);
			  $dias_ausente = $fila_asis['cantidad'];
			  $mayo =	$dias_ausente;
			  
			  $sql_asis = "select count(*) as cantidad from asistencia_apo where ano = ".$ano." and rut_apo = ".$rut_apo." and (fecha >='06-01-$nro_ano' and fecha <='06-30-$nro_ano')";
			  $result_asis =@pg_Exec($conn,$sql_asis);
			  $fila_asis = @pg_fetch_array($result_asis,0);
			  $dias_ausente = $fila_asis['cantidad'];
			  $junio =	$dias_ausente;
			  
			  $sql_asis = "select count(*) as cantidad from asistencia_apo where ano = ".$ano." and rut_apo = ".$rut_apo." and (fecha >='07-01-$nro_ano' and fecha <='07-31-$nro_ano')";
			  $result_asis =@pg_Exec($conn,$sql_asis);
			  $fila_asis = @pg_fetch_array($result_asis,0);
			  $dias_ausente = $fila_asis['cantidad'];
			  $julio =	$dias_ausente;
			  
			  $sql_asis = "select count(*) as cantidad from asistencia_apo where ano = ".$ano." and rut_apo = ".$rut_apo." and (fecha >='08-01-$nro_ano' and fecha <='08-31-$nro_ano')";
			  $result_asis =@pg_Exec($conn,$sql_asis);
			  $fila_asis = @pg_fetch_array($result_asis,0);
			  $dias_ausente = $fila_asis['cantidad'];
			  $agosto =	$dias_ausente;
			  
			  $sql_asis = "select count(*) as cantidad from asistencia_apo where ano = ".$ano." and rut_apo = ".$rut_apo." and (fecha >='09-01-$nro_ano' and fecha <='09-30-$nro_ano')";
			  $result_asis =@pg_Exec($conn,$sql_asis);
			  $fila_asis = @pg_fetch_array($result_asis,0);
			  $dias_ausente = $fila_asis['cantidad'];
			  $septiembre =	$dias_ausente;
			  
			  $sql_asis = "select count(*) as cantidad from asistencia_apo where ano = ".$ano." and rut_apo = ".$rut_apo." and (fecha >='10-01-$nro_ano' and fecha <='10-31-$nro_ano')";
			  $result_asis =@pg_Exec($conn,$sql_asis);
			  $fila_asis = @pg_fetch_array($result_asis,0);
			  $dias_ausente = $fila_asis['cantidad'];
			  $octubre =	$dias_ausente;
			  
			  $sql_asis = "select count(*) as cantidad from asistencia_apo where ano = ".$ano." and rut_apo = ".$rut_apo." and (fecha >='11-01-$nro_ano' and fecha <='11-30-$nro_ano')";
			  $result_asis =@pg_Exec($conn,$sql_asis);
			  $fila_asis = @pg_fetch_array($result_asis,0);
			  $dias_ausente = $fila_asis['cantidad'];
			  $noviembre =	$dias_ausente;
			  
			  $sql_asis = "select count(*) as cantidad from asistencia_apo where ano = ".$ano." and rut_apo = ".$rut_apo." and (fecha >='12-01-$nro_ano' and fecha <='12-31-$nro_ano')";
			  $result_asis =@pg_Exec($conn,$sql_asis);
			  $fila_asis = @pg_fetch_array($result_asis,0);
			  $dias_ausente = $fila_asis['cantidad'];
			  $diciembre =	$dias_ausente;
			  
			  $total = $marzo + $abril + $mayo + $junio + $julio + $agosto + $septiembre + $octubre + $noviembre + $diciembre;
			  ?>			  
			 
              <td bgcolor="ffffff"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">&nbsp;<? echo $nombre_apo;?></font></td>
              <td bgcolor="ffffff"><div align="center"><span class="Estilo3">&nbsp;<?=$marzo ?></span></div></td>
              <td bgcolor="ffffff"><div align="center"><span class="Estilo3">&nbsp;<?=$abril ?></span></div></td>
              <td bgcolor="ffffff"><div align="center"><span class="Estilo3">&nbsp;<?=$mayo ?></span></div></td>
              <td bgcolor="ffffff"><div align="center"><span class="Estilo3">&nbsp;<?=$junio ?></span></div></td>
              <td bgcolor="ffffff"><div align="center"><span class="Estilo3">&nbsp;<?=$julio ?></span></div></td>
              <td bgcolor="ffffff"><div align="center"><span class="Estilo3">&nbsp;<?=$agosto ?></span></div></td>
              <td bgcolor="ffffff"><div align="center"><span class="Estilo3">&nbsp;<?=$septiembre ?></span></div></td>
              <td bgcolor="ffffff"><div align="center"><span class="Estilo3">&nbsp;<?=$octubre ?></span></div></td>
              <td bgcolor="ffffff"><div align="center"><span class="Estilo3">&nbsp;<?=$noviembre ?></span></div></td>
              <td bgcolor="ffffff"><div align="center"><span class="Estilo3">&nbsp;<?=$diciembre ?></span></div></td>
              <td bgcolor="ffffff"><div align="center"><span class="Estilo3">&nbsp;<?=$total ?></span></div></td>
             </tr>
			 <?
		   }
		   ?>			 
        </table>
		
		
		</td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>

</center>
</form>

<?
}
?>
<!-- FIN CUERPO DE LA PAGINA -->


</body>
</html>
<? pg_close($conn);?>