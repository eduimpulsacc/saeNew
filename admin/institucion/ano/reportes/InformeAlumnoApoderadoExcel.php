<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

	$dd = date(d);
    $mm = date(m);
    $aa = date(Y);
    $fechahoy = "$dd-$mm-$aa";

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$curso;
	$cadena01		="00";	
	$_POSP = 4;
	$_bot = 8;
	if (empty($curso)) //exit;
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	
	//------------------------
	
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//-----------------------------------------
	// Institución
	//-----------------------------------------
	$sql_insti = "Select * from institucion where rdb = " . $institucion;
	$result_insti =@pg_Exec($conn,$sql_insti);
	$fila_insti = @pg_fetch_array($result_insti,0);	
	$nombre_insti = $fila_insti['nombre_instit'];
	//-----------------------------------------
	// Curso y Profesor Jefe
	//-----------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//-----------------------------------------
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat']) . " " . trim($fila_profe['ape_mat'] ) . " " . trim($fila_profe['nombre_emp'])));
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.num_mat, alumno.dig_rut ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$result_alu =@pg_Exec($conn,$sql_alu);
	//-----------------------------------------
	
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=alumno_apoderado_$fechahoy.xls");	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0">
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	
	  </td>
      </tr>
      <tr>
      <td>
	  <table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="tableindex"><div align="center">INFORME ALUMNO APODERADO </div></td>
      </tr>
      <tr>
            <td align="center"><font size="1" face="verdana, arial, geneva, helvetica"><strong>&nbsp; </strong></font></td>
      </tr>
      </table>
      <br>
	  <table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
            <td width="115"><font size="1" face="verdana,arial, geneva, helvetica"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="1" face="verdana,arial, geneva, helvetica">:</font></div></td>
        <td width="531"><font size="1" face="verdana,arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
           <td><font size="1" face="verdana,arial, geneva, helvetica"><strong>Profesor(a) 
              Jefe</strong></font></td>
        <td><font size="1" face="verdana,arial, geneva, helvetica">:</font></td>
        <td><font size="1" face="verdana,arial, geneva, helvetica"><? echo $profe_jefe;?></font></td>
      </tr>
	 <tr>
    <td>&nbsp;</td>
  </tr>
      </table>
	  <br>

      <table width="650" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td  colspan="5" class="tablatit2">INFORMACION DEL ALUMNO</td>
        <td  colspan="6" class="tablatit2"><div align="center">INFORMACIÓN APODERADO</div></td>
      </tr>
      <tr>
         <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Nº Mat.</strong></font></td>
	     <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Rut</strong></font></td>
		 <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Nombre</strong></font></td>
	     <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Apellido Paterno</strong></font></td>
		 <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Apellido Materno</strong></font></td>
		 
	     <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Rut</strong></font></td>
		 <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Nombre</strong></font></td>
		 <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Apellido Paterno</strong></font></td>
		 <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Apellido Materno</strong></font></td>
		 <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Dirección</strong></font></td>
		 <td align="center" ><font size="1" face="verdana,arial, geneva, helvetica"><strong>Teléfono</strong></font></td>
	 </tr>

       <?
	  $numero_alumnos = @pg_numrows($result_alu);	 
	  
	  
	  for($i=0 ; $i < @pg_numrows($result_alu) ; $i++){
	     $fila_alu = @pg_fetch_array($result_alu,$i);
	     $rut_alumno = $fila_alu['rut_alumno'];
		 $dig_alu    = $fila_alu['dig_rut'];
		 $nombre_alu = $fila_alu['nombre_alu'];
		 $ape_pat    = $fila_alu['ape_pat'];
		 $ape_mat    = $fila_alu['ape_mat'];
		 
		 $rut_alumno = $fila_alu['rut_alumno'];
	     ?>	
         <tr>
         <td align="center"><font size="1" face="arial, geneva, helvetica"><? echo $i+1; ?></font></td>
         <td><font size="1" face="arial, geneva, helvetica"><? echo "$rut_alumno-$dig_alu"; ?></font></td>
		 <td><font size="1" face="arial, geneva, helvetica"><?=$nombre_alu?></font></td>
		 <td><font size="1" face="arial, geneva, helvetica"><?=$ape_pat?></font></td>
		 <td><font size="1" face="arial, geneva, helvetica"><?=$ape_mat?></font></td>
	    
			  <?
	          // Aqui saco la informacion del apoderado y su telefono
	          $sql_apo = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno = '".trim($rut_alumno)."')";
	          $res_apo = @pg_Exec($conn,$sql_apo);
	          $num_apo = @pg_numrows($res_apo);
	          $fila_apo = @pg_fetch_array($res_apo,0);
	          $rut_apo    = $fila_apo['rut_apo'];
			  $dig_apo    = $fila_apo['dig_rut'];
			  $nombre_apo = $fila_apo['nombre_apo'];
	          $ape_pat    = $fila_apo['ape_pat'];
			  $ape_mat    = $fila_apo['ape_mat'];
			  $calle      = $fila_apo['calle'];
			  $nro_calle  = $fila_apo['nro'];
			  $telefono   = $fila_apo['telefono'];         
			
		      ?>	
		      <td><div align="left"><font size="1" face="arial, geneva, helvetica">&nbsp;<? echo "$rut_apo-$dig_apo"; ?></font></div></td>
			  <td><div align="left"><font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $nombre_apo; ?></font></div></td>
		      <td><div align="center"><font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $ape_pat; ?></font></div></td>
			  <td><div align="left"><font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $ape_mat; ?></font></div></td>
			  <td><div align="left"><font size="1" face="arial, geneva, helvetica">&nbsp;<? echo "$calle $nro_calle"; ?></font></div></td>
			  <td><div align="left"><font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $telefono; ?></font></div></td>
			  </tr>
  	     <?  } ?>
	</table>
	
	
	
	
		
	</td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>