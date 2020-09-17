<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

if ($institucion==299){
	$whe_ensenanza=" OR (ensenanza = 10)";
   //	OR (curso.grado_curso<5) and (curso.ensenanza<>110)
}


?>
<?php 
  //setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$c_alumno;
	$curso			=$c_curso;
	$_POSP = 4;
	$_bot = 8;
	
	$sqlEns="select ensenanza from curso where id_curso =".$c_curso;
	$resEns=@pg_exec($conn, $sqlEns);
	$ensenanza=@pg_fetch_array($resEns,0);
	
	$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, (empleado.nombre_emp || ' ' || empleado.ape_pat ||' ' || empleado.ape_mat) as nombre, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultDIR =@pg_Exec($conn,$qryDIR);
	$filaDIR=@pg_fetch_array($resultDIR);	
	
	$sqlAlu="select (trim(nombre_alu) || ' ' || trim(ape_pat) || ' ' || trim(ape_mat)) as nombre from alumno where rut_alumno=".$alumno;
	$resAlu=@pg_exec($conn, $sqlAlu);
	$nombreAlu=@pg_fetch_array($resAlu);
	
	$sqlAno="select nro_ano from ano_escolar where id_ano=".$_ANO;
	$resAno=@pg_exec($conn, $sqlAno);
	$ano=@pg_fetch_array($resAno,0);
	
	$sqlInsit="SELECT *FROM institucion WHERE rdb=".$_INSTIT;
	$resInstit=@pg_exec($conn, $sqlInsit);
	$filaInstit=@pg_fetch_array($resInstit,0);
	
	$sqlReg="select nom_reg from region where cod_reg=".$filaInstit['region'];
	$resReg=@pg_exec($conn, $sqlReg);
	$region=@pg_fetch_array($resReg,0);
	
	$sqlPro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro=".$filaInstit['ciudad'];
	$resPro=@pg_exec($conn, $sqlPro);
	$ciudad=@pg_fetch_array($resPro,0);	
	
	$sqlCom="select nom_com from comuna where cod_reg=".$filaInstit['region']." and cor_pro=".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
	$resCom=@pg_exec($conn, $sqlCom);
	$comuna=@pg_fetch_array($resCom,0);	
	
	
	 $sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp, trabaja.cargo FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo=1 OR trabaja.cargo=23)";
		
	    /*$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp";
		$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
		$sql = $sql . "WHERE ( ((trabaja.rdb)=".$institucion.") AND trabaja.cargo='1' OR trabaja.cargo='23');";*/
		$result =@pg_Exec($conn,$sql);
		$fila = @pg_fetch_array($result,0);	
		$Nombre_Direc = strtoupper(trim(trim($fila['nombre_emp']. " " .$fila['ape_pat']) . " " . trim($fila['ape_mat'])  ));
        $cargo_dir    = $fila['cargo'];		
						
    if ($cargo_dir==1){
	    $cargo_dir  = "director(a)";
		$cargo_dir2 = "Director(a)";
	}
	if ($institucion==9239){
		$cargo_dir  = "Directora";
		$cargo_dir2 = "Directora";
	}
	if ($cargo_dir==23){
	    $cargo_dir  = "rector(a)";
		$cargo_dir2 = "Rector(a)";
	}		
	
 ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'certificadoEBasicaMedia.php?institucion=$institucion';
				form.submit(true);
	
				}	
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
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->

<table>
    <tr>
	  <td align="left">&nbsp;</td>
	</tr>
</table>

<table width="700"  border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td><div id="capa0">
<table width="100%">
  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
<td align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	    </td></tr></table>
     
      </div></td>
  </tr>
</table>
<?
if ($alumno>0){
     $sql_todos="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$curso. " and matricula.rut_alumno = alumno.rut_alumno and alumno.rut_alumno = '$alumno' order by ape_pat, ape_mat, nombre_alu";
}else{
     $sql_todos="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
}
$result_todos= @pg_Exec($conn,$sql_todos);
for($x=0;$x<pg_numrows($result_todos);$x++){ 
    $fila_todos = pg_fetch_array($result_todos,$x);
    $fila_to2 = $fila_todos['nombre_alu']." ".$fila_todos['ape_pat']." ".$fila_todos['ape_mat'];
    ?>
    <table width="700" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#000000">
     <tr>
      <td>
	   <?
	   if ($institucion=="770"){ 
		       // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br><br><br><br><br><br><br>";
			   
	   }  ?>	
	
	
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>

		<tr> 
          <td colspan="4"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>REPUBLICA 
              DE CHILE</strong></font></div></td>
          <td width="198" rowspan="6" align="center"><img  src="escudo.jpg" width="120" height="80"></td>
          <td width="69"> <div align="left"></div></td>
          <td width="143"><div align="left"></div>
            <font size="1" face="Arial, Helvetica, sans-serif">REGION</font></td>
          <td width="198"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $region['nom_reg']?></font></div></td>
        </tr>
        <tr> 
          <td colspan="4"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">MINISTERIO 
              DE EDUCACION</font></div></td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">PROVINCIA</font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $ciudad['nom_pro']?></font></div></td>
        </tr>
        <tr> 
          <td colspan="4"><div align="center"><font face="Arial, Helvetica, sans-serif"><font size="1">DIVISION 
              DE EDUCACION GENERAL</font></font></div></td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">COMUNA</font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $comuna['nom_com']?></font></div></td>
        </tr>
        <tr> 
          <td colspan="4"><div align="center"><font face="Arial, Helvetica, sans-serif"><font size="1">SECRETARIA 
              REGIONAL MINISTERIAL DE EDUCACION</font></font></div></td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">ROL BASE DE DATOS</font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo number_format($_INSTIT,0,'','.');?>-<? echo $filaInstit['dig_rdb']?></font></div></td>
        </tr>
        <tr> 
          <td colspan="4" rowspan="3">&nbsp;</td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">A&Ntilde;O ESCOLAR 
            </font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?PHP echo  number_format($ano['nro_ano'],0,'','.')?></font></div></td>
        </tr>
        <tr> 
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">Decreto Cooperador 
            de la Funci&oacute;n</font></td>
          <td><div align="left"></div></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td><div align="left"></div></td>
          <td><font size="1" face="Arial, Helvetica, sans-serif">Educacional del 
            Estado</font></td>
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $filaInstit['nu_resolucion']." "; impF($filaInstit['fecha_resolucion']); ?></font></div></td>
        </tr>
        <tr> 
          <td width="235">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 

          <td width="6%">&nbsp;</td>
          <td width="12%">
	  <? if ($institucion=="770"){ 
		     // no muestro los datos de la institucion
			 // por que ellos tienen hojas pre-impresas
			 //echo "<br><br><br><br><br><br><br><br><br><br>";
			   
		 }else{
			
		
		      ?>  
			  <?
				$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## código para tomar la insignia
		
			  if($institucion!="" && $institucion!=12838){
				   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			  }elseif ($institucion!=12838){
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }else{
			  
			  }?>
			  
	  <? } ?>  
	  
	  
	  </td>
          <td width="62%"><div align="center"><strong><font size="5" face="Arial, Helvetica, sans-serif">LICENCIA 
              DE ENSE&Ntilde;ANZA <?php if ($ensenanza['ensenanza']>110){ 
			  							echo "MEDIA"; 
										}
					if (($ensenanza['ensenanza']<=110) and ($ensenanza['ensenanza']!="") and ($ensenanza['ensenanza']!=10)){
						 echo "BASICA";
				   }
				   if(($ensenanza['ensenanza']==10)){
						 echo "PRE BASICA";
				   }
					?></font></strong></div></td>
          <td width="20%">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="25%"></td>
          <td width="59%" rowspan="3"><p>&nbsp;</p>
            <p><font size="4" face="Arial, Helvetica, sans-serif">Establecimiento 
              : <strong><?php echo $filaInstit['nombre_instit']?></strong></font></p>
            <p><font size="4" face="Arial, Helvetica, sans-serif">CERTIFICO que 
              don(a) : <strong><?php echo $fila_to2; ?></strong></font></p>
			  <?php if ($ensenanza['ensenanza']>110){ 
			  			$educacion="Media"; 
					}
					if(($ensenanza['ensenanza']<=110) and ($ensenanza['ensenanza']!="") and ($ensenanza['ensenanza']!=10)){
						 $educacion="General B&aacute;sica y";
				   }
				   	if(($ensenanza['ensenanza']==10)){
						 $educacion="Pre Básica";
				   }
										  ?>
            <pre align="justify"><font size="4" face="Arial, Helvetica, sans-serif">ha aprobado todos los cursos correspondientes a la Educaci&oacute;n <?php echo $educacion?>
			

por lo tanto, ha dado cumplimiento a la obligatoriedad escolar dispuesta 

en el art&iacute;culo 19, N&ordm; 10 de la Constituci&oacute;n Pol&iacute;tica de la Rep&uacute;blica de Chile</font></pre></td>
          <td width="16%">&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr> 
		<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
	  </tr>
	  <tr> 
		<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2"><?=$cargo_dir2 ?> 
			Establecimiento </font></div></td>
	  </tr>
		<tr>
		  <td align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">
		    <?
		if($institucion == 24511){	
			echo "MEZA GOTOR MARCELO";
		}
		else{
			echo $Nombre_Direc;
		}
	?>
		  </font></strong></td>
	    </tr>
		<tr>
		<?
		$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
		$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
		$result =@pg_Exec($conn,$sql4);
		$fila = @pg_fetch_array($result,0);	
		$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
		?>
		<td><div align="left"><strong><font face="Arial, Helvetica, sans-serif" size="1"><?php echo ucwords(strtolower($comuna['nom_com'])).", ".$dia." de ".$mes." de ".$ano2 ?></div></font></td>
	  </tr>
  </table></td>
  </tr>
</table>
<? 
    //// salto de página
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";


} ?>
<!-- FIN CUERPO DE LA PAGINA -->


</body>
</html>
<? pg_close($conn);?>