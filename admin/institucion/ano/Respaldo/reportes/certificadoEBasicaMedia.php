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
if ($dia == ""){
	   ## si el campo esta vacío poner la fecha actual
	   $dia  = strftime("%d",time());
	   $mes  = strftime("%m",time());
	   $mes  = envia_mes($mes);
	   $ano2  = strftime("%Y",time()); 
	}else{
	   $dia = $dia;
	   $mes = $mes;
	   $ano2 = $ano2;
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
	
	$sqlInsit="SELECT * FROM institucion WHERE rdb=".$_INSTIT;
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
	
	
	
	
	$q1 = "select * from trabaja where rdb = '".trim($institucion)."' and (cargo=1 OR cargo=23)";
	$r1 = @pg_Exec($conn,$q1);
	$n1 = @pg_numrows($r1);
	//echo "n1 es: $n1 <br>";
	
	$f1 = @pg_fetch_array($r1,0);
	$cargo = $f1['cargo'];
	//echo "c: $cargo <br>";
	
	if ($cargo==1){
		$cargo_dir  = "director(a)";
		$cargo_dir2 = "Director(a)";
	}
	
	if ($cargo==1 and $institucion==9239){
		$cargo_dir  = "Directora";
		$cargo_dir2 = "Directora";
	}
	
	if ($cargo==23){
		$cargo_dir  = "rector(a)";
		$cargo_dir2 = "Rector(a)";
	}
	
 ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
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
								  <?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
<table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="30" align="center" valign="top"> 
      
	  
	  <?	include("../../../../cabecera/menu_inferior.php");
						?>
		</td>
		</tr> 
  
  
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->

<?
if ($curso != 0){
  ?>

<table width="100%"  border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printcertificadoEBasicaMedia.php?c_curso=<?=$c_curso ?>&c_alumno=<?=$c_alumno ?>&dia=<?=$dia ?>&mes=<?=$mes ?>&ano2=<?=$ano2 ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
        </div>
      </div></td>
  </tr>
</table>
<? if($cmb_alumno=="0"){  //Para todos los alumnos
$sql_todos="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
$result_todos= @pg_Exec($conn,$sql_todos);
for($x=0;$x<pg_numrows($result_todos);$x++){ 
$fila_todos = pg_fetch_array($result_todos,$x);
$fila_to2 = $fila_todos['nombre_alu']." ".$fila_todos['ape_pat']." ".$fila_todos['ape_mat'];
?>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#000000">
  <tr>
    <td>
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
	<?	if($institucion!=12838){ 
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			## código para tomar la insignia
	
		  if($institucion!=""){
			   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
		  }else{
			   echo "<img src='".$d."menu/imag/logo.gif' >";
		  }
	  }?>
	  </td>
          <td width="62%"><div align="center"><strong><font size="5" face="Arial, Helvetica, sans-serif">CERTIFICADO 
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
              don(a) : <strong><?php echo $fila_to2;?></strong></font></p>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
<!--        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
         <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
 -->        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td width="61%">&nbsp;</td>
          <td width="19%">__________________________________</td>
          <td width="20%">&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">
		  <?php 
		  	if($institucion == 24511){
				echo "MEZA GOTOR MARCELO";
			}
			else{
				echo $filaDIR['nombre'];
			}
		  ?></font></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?=$cargo_dir2 ?></font></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo ucwords(strtolower($comuna['nom_com'])).", ".$dia." de ".$mes." de ".$ano2 ?>
		  </font></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
</td>
  </tr>
</table>
<br><br><br><br><br><br>
<?  
	}//------------------------------------------------------------------------------- fin todos
}else{
?>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
          <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?PHP echo  "2006"?></font></div></td>
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
	<? if($institucion!=12838){
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			## código para tomar la insignia
	
		  if($institucion!=""){
			   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
		  }else{
			   echo "<img src='".$d."menu/imag/logo.gif' >";
		  }
	  }else{
	  	echo "&nbsp;";
	  }?>
	  </td>
          <td width="62%"><div align="center"><strong><font size="5" face="Arial, Helvetica, sans-serif">CERTIFICADO 
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
              don(a) : <strong><?php echo $nombreAlu['nombre']?></strong></font></p>
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
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
<!--        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
         <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
 -->        <tr> 
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr> 
          <td width="61%">&nbsp;</td>
          <td width="19%">__________________________________</td>
          <td width="20%">&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">
		  <?php 
		  	if($institucion == 24511){
				echo "MEZA GOTOR MARCELO";
			}
			else{
				echo $filaDIR['nombre'];
			}
		  ?></font></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?=$cargo_dir2 ?></font></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo ucwords(strtolower($comuna['nom_com'])).", ".$dia." de ".$mes." de ".$ano2 ?> 
		  </font></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<?
} }
?>
<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

  <form method "post" action="">
<? 
/*$sql_curso  = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso .= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso .= "WHERE (((curso.id_ano)=".$ano.")) AND ((curso.grado_curso=8) OR (curso.grado_curso=1)";
//$sql_curso = $sql_curso . "OR (curso.grado_curso=2) OR (curso.grado_curso=3) OR (curso.grado_curso=4)) AND ensenanza > 110)  ";
$sql_curso .= "OR (curso.grado_curso=2) OR (curso.grado_curso=3) OR (curso.grado_curso=4) OR (curso.grado_curso=5) $whe_ensenanza)  ";
echo $sql_curso .= "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
*/
$institucion	=$_INSTIT;
$ano			=$_ANO;
	if ($institucion!=0){
		$whe_ensenanza=" OR (ensenanza = 10)";
//		OR (curso.grado_curso<5) and (curso.ensenanza<>110)
	}



$sql_curso  = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso .= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso .= "WHERE (((curso.id_ano)=".$ano.")) AND ((
(curso.grado_curso=8) and (curso.ensenanza=110)) OR ((curso.grado_curso<5) and (curso.ensenanza<>110)) $whe_ensenanza )";
 $sql_curso .= "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";

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
	<table width="" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78" class="textosimple">Curso</td>
    <td width="263">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
          <option value=0 selected>(Seleccione Curso)</option>
            <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if (($resultado_query_cue[grado_curso]==5)&&($resultado_query_cue[grado_curso]!=10)) {}else{
			  if ($fila["id_curso"]==$cmb_curso){
					$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
					echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
			  }else{
					$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
					echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
			  }
		  }
          } ?>
        </select>
</font>	  </div></td>
    <td width="61" class="textosimple">Alumno</td>
    <td width="219"><select name="cmb_alumno" class="ddlb_9_x">
      <option value="0" selected>(Todos los Alumnos)</option>
      <?
		$sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
		$result= @pg_Exec($conn,$sql);
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);?>
			<?
			if ($fila["rut_alumno"] == $cmb_alumno){
			   ?>
      <option value="<? echo $fila["rut_alumno"]; ?>" selected><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
	           <?
			}else{
			   ?>
      <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
	           <?
			 }
	  ?>		 
			     
      
	  
	  
	  <?
		}
		?>
    </select></td>
	
    <td width="80"><div align="right">
      <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','certificadoEBasicaMedia.php?dia='+dia.value+'&mes='+mes.value+'&ano2='+ano2.value+'&c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value);return document.MM_returnValue" value="Buscar">
    </div></td>
  </tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
<table width="320" border="0" cellspacing="2" cellpadding="0" align="center">
          <tr>
            <td class="textosimple">Fecha del Informe</td> 
            <td><div align="center">
              <input name="dia" type="text" id="dia" size="2" value="<?=$dia ?>">
            </div></td>		
           <td><div align="center">
           <input name="mes" type="text" id="mes" size="11" value="<?=$mes ?>">
           </div></td>
           <td><div align="center">
           <input name="ano2" type="text" id="ano2" size="4" value="<?=$ano2 ?>">
           </div></td>
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
                        de Administraci&oacute;n Escolar - 2006</td>
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
