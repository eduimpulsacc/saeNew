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

	//setlocale("LC_ALL","es_ES")	;
	//---------------------------
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$curso			=$c_curso	;
	$alumno			=$c_alumno	;
	$_POSP = 4;
	$_bot = 8;
	
	//---------------------------
	if ($curso==0){?>
	  <!--	<script>alert("Debe seleccionar el Curso")</script> -->
	<? //exit;
	 }
	
	if ($alumno==0){?>
		<!--<script>alert("Debe seleccionar el Alumno")</script> -->	
	<? //exit;
	 }		
	//---------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.rdb, institucion.dig_rdb ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$ciudad = $fila_ins['nom_pro'];
	$fono = $fila_ins['telefono'];
	$direc = $fila_ins['calle'].$fila_ins['nro'];
	$region = $fila_ins['nom_reg'];
	$provincia = $fila_ins['nom_pro'];
	$comuna = $fila_ins['nom_com'];
	$rbd = $fila_ins['rdb']." - ". $fila_ins['dig_rdb'];
	//----------
	$Curso_pal = CursoPalabra($curso, 0, $conn);	
	//----------
	//----------
		$sql_ano = "select nro_ano from ano_escolar where id_ano=" . $ano;
		$result_ano = @pg_exec($conn,$sql_ano);
		$fila_ano = @pg_fetch_array($result_ano,0);
		$Nano = $fila_ano['nro_ano'];
	//----------
	if ($alumno == 0){
		
	}else{
		$sqlAlumnos = "select * from alumno where rut_alumno = '".$alumno."'";
		$rsAlumno=@pg_Exec($conn,$sqlAlumnos);
		$fAlumno= @pg_fetch_array($rsAlumno,0);
//		$nombre = trim(ucwords(strtolower($fAlumno['nombre_alu']." ".$fAlumno['ape_pat']." ".$fAlumno['ape_mat'])));
		$nombre = trim($fAlumno['nombre_alu']." ".$fAlumno['ape_pat']." ".$fAlumno['ape_mat']);
		$sexo = $fAlumno['sexo'];
		$Curso_pal  = ucwords($Curso_pal);
		$Rut_Alum = $fAlumno['rut_alumno'].$fAlumno['dig_rut'];
		if ($sexo == 2){
			$tipo1 = "Alumno";
			$tipo2 = "del interesado";
		}else{
			$tipo1 = "Alumna";
			$tipo2 = "de la interesada";
		}			
	}
	

	    //----------
	    $sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp, trabaja.cargo FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo=1 OR trabaja.cargo=23)";
		
	    /*$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp";
		$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
		$sql = $sql . "WHERE ( ((trabaja.rdb)=".$institucion.") AND trabaja.cargo='1' OR trabaja.cargo='23');";*/
		$result =@pg_Exec($conn,$sql);
		$fila = @pg_fetch_array($result,0);	
		$Nombre_Direc = strtoupper(trim(trim($fila['nombre_emp']. " " .$fila['ape_pat']) . " " . trim($fila['ape_mat'])  ));
        $cargo_dir    = $fila['cargo'];		
						
    if ($cargo_dir==1){
	    $cargo_dir  = "Director(a)";
		$cargo_dir2 = "Director(a)";
	}
	if ($cargo_dir==23){
	    $cargo_dir  = "Rector(a)";
		$cargo_dir2 = "Rector(a)";
	}		

	Function rutF($txt){
		if ($txt!=0){
			$largo=strlen($txt);
			if ($largo==9){
				$millon =substr (($txt), 0,2); 
				$centena = substr (($txt), 2,3); 
				$decena = substr (($txt), 5,3); 
				$exten = substr (($txt), -1); 
			}else{
				$millon =substr (($txt), 0,1); 
				$centena = substr (($txt), 1,3); 
				$decena = substr (($txt), 4,3); 
				$exten = substr (($txt), -1); 
			}
		$txt = $millon.".".$centena.".".$decena." - ".$exten;
		echo $txt;
		}
	}
		//----------
		$sql_curso = "select ensenanza, cod_es, cod_sector, cod_rama from curso where id_curso=" . $curso;
		$result_curso = @pg_exec($conn,$sql_curso);
		$fila_curso = @pg_fetch_array($result_curso,0);
		$Ense = $fila_curso['ensenanza'];
		$Espec = $fila_curso['cod_es'];
		$Sector = $fila_curso['cod_sector'];
		$Rama = $fila_curso['cod_rama'];
		
		if ($Ense >310){
			$sql_esp = "select nombre_esp from especialidad where cod_esp=" .$Espec." and cod_sector=".$Sector." and cod_rama=".$Rama;
			$result_esp = @pg_exec($conn,$sql_esp);
			$fila_esp = @pg_fetch_array($result_esp,0);
			$Especialidad = $fila_esp['nombre_esp'];
		}
		
			$sql_Mat = "select num_mat from matricula where rut_alumno='" .$alumno."' and id_ano=".$ano;
			$result_Mat= @pg_exec($conn,$sql_Mat);
			$fila_Mat = @pg_fetch_array($result_Mat,0);
			$numero = $fila_Mat['num_mat'];
	//----------

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'CertificadoAlumnoRegular.php?institucion=$institucion';
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
      
	  
	   <?
						include("../../../../cabecera/menu_inferior.php");
						?>
	  
	  
	  <tr>
		</tr> 
  
  
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->

<?
if ($curso > 0 ){
   ?>

<center>
  <table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr align="right">
      <td>
        <div id="capa0">
          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printCertificadoAlumnoRegular.php?c_curso=<?=$c_curso ?>&c_alumno=<?=$c_alumno ?>','','scrollbars=yes,resizable=yes,width=800,height=600')" value="IMPRIMIR">
      </div></td>
    </tr>
  </table>
  <table width="699" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="431" align="left"><font size="-2" face="Arial, Helvetica, sans-serif"><? echo strtoupper($ins_pal);?></font></td>
      <td width="12">&nbsp;&nbsp;&nbsp;</td>
      <td width="66"><font size="-2" face="Arial, Helvetica, sans-serif">Regi&oacute;n</font></td>
      <td width="190"><font size="-2" face="Arial, Helvetica, sans-serif">:&nbsp;<? echo $region;?></font></td>
    </tr>
    <tr> 
      <td align="left"><font size="-2" face="Arial, Helvetica, sans-serif"><? echo strtoupper($direc);?>&nbsp;<? echo strtoupper($comuna);?></font></td>
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td width="66"><font size="-2" face="Arial, Helvetica, sans-serif">Provincia</font></td>
      <td><font size="-2" face="Arial, Helvetica, sans-serif">:&nbsp;<? echo $provincia;?></font></td>
    </tr>
    <tr> 
      <td align="left"><font size="-2" face="Arial, Helvetica, sans-serif">FONO <? echo $fono;?></font></td>
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td width="66"><font size="-2" face="Arial, Helvetica, sans-serif">Comuna</font></td>
      <td><font size="-2" face="Arial, Helvetica, sans-serif">:&nbsp;<? echo $comuna;?></font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="66"><font size="-2" face="Arial, Helvetica, sans-serif">Rbd</font></td>
      <td><font size="-2" face="Arial, Helvetica, sans-serif">:&nbsp;<? echo $rbd;?></font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="66"><font size="-2" face="Arial, Helvetica, sans-serif">A&ntilde;o Escolar</font></td>
      <td><font size="-2" face="Arial, Helvetica, sans-serif">:&nbsp;<? echo $Nano;?></font></td>
    </tr>
  </table>
  <br>
  <table width="649" border="0" cellspacing="1" cellpadding="1">
  <tr>
      <td width="561" valign="top">
			<?	
				$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## código para tomar la insignia
			
				if($institucion!=""){
					echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
				}else{
					echo "<img src='".$d."menu/imag/logo.gif' >";
				}
			?>

	</td>
    
    </tr>
</table><br><br><br>
  <table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr>
<?  if($institucion==770){ ?>
		<td align="center" bgcolor="#FFCC00"><center><font size="+2"><strong>CERTIFICADO DE ALUMNO REGULAR</strong></font></center></td>
<? }else{ ?>
	  <td align="center" class="tableindex"><center><font size="+2">CERTIFICADO DE ALUMNO REGULAR</font></center></td>
<? } ?>	  
    </tr>
	<tr> 
      <td valign="top"><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
	  </tr>
  </table>
  <div align="left"><br>
    <br>
    <br>
  </div>
  <table width="750" border="0" cellspacing="0" cellpadding="0">
  <? if ($numero!=""){?>
    <tr> 
      <td><font face="Arial, Helvetica, sans-serif" size="2">Nº de Matrícula <strong><? echo $numero ?></strong></font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
	<? } ?>
    <tr> 
      <td width="360"><font face="Arial, Helvetica, sans-serif" size="2"><strong>
	  <?
		if($institucion == 24511){	
			echo "Meza Gotor Marcelo";
		}
		else{
//			echo ucwords(strtolower($Nombre_Direc));
			echo strtoupper($Nombre_Direc);
		}
	?>, </strong> 
	    <?
		if ($institucion==1593){ 
		     echo "Directora de la";
		}else{ 			 
             echo $cargo_dir;
			 echo "del ";
		}	 
		?>
		</font></td>
      <td width="352"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2"><b><? echo strtoupper($ins_pal);?></b></font></div></td>
    </tr>
  </table>
  <table width="750" border="0" cellspacing="0" cellpadding="0">
    <tr>
		<td colspan="3">&nbsp;</td>
	</tr>
    <tr> 
      <td width="96"><font face="Arial, Helvetica, sans-serif" size="2">certifica que </font></td>
      <td width="300" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo strtoupper($nombre)?></strong>&nbsp;</font></td>
      <td width="279" align="left"><font face="Arial, Helvetica, sans-serif" size="2"><b>R.U.T <? rutF($Rut_Alum);?></b>&nbsp;</font></td>
    </tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
    <tr> 
      <td colspan="3"></td>
    </tr>
    <tr> 
      <td colspan="3"></td>
    </tr>
    <tr> 
      <td colspan="3"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;es 
        <? echo $tipo1;?> regular del <b><? echo $Curso_pal, " ";?><? echo ucwords(strtolower($Especialidad)); ?></b> de este Establecimiento.</font> 
      </td>
    </tr>
	<tr><td>&nbsp;</td></tr>
    <tr> 
      <td colspan="3"><br><font face="Arial, Helvetica, sans-serif" size="2">Se 
        extiende el presente certificado a solicitud del apoderado para los fines 
        que estime conveniente.</font></td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
  </table>
  <br>  <br>
  <br>
  <br><br><br><br><br><br><br>
<table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr> 
		<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
	  </tr>
	  <tr> 
		<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2"><?=$cargo_dir2 ?> 
			Establecimiento </font></div></td>
	  </tr>
		<tr>
		<?
		$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
		$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
		$result =@pg_Exec($conn,$sql4);
		$fila = @pg_fetch_array($result,0);	
		$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
		?>
		<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1"> 
		<?
		if($institucion == 24511){	
			echo "MEZA GOTOR MARCELO";
		}
		else{
			echo $Nombre_Direc;
		}
	?>
			</font></strong></div></td>
	  </tr>
  </table>
<br><br><br><br><br><br>
  <table width="600" border="0" cellspacing="0" cellpadding="0">
    <tr><? $fecha = date("d-m-Y") ?>
	 <td width="%" align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo ($comuna . ", " . fecha_espanol($fecha))?></strong></font></td>
  </tr>
</table>
</center>
    <?
}
?>	
<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form method "post" action="">
<? 
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
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" class="cuadro01">Curso
	  <br>
	  <div align="left"> 
	      <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
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
		<br>
	  </div></td>
    </tr>
  <tr>
    <td colspan="2" class="cuadro01"><br>      Alumno<br>
      <select name="cmb_alumno" class="ddlb_9_x">
        <option value=0 selected>(Seleccione Alumno)</option>
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
    </tr>
  <tr>
    <td width="78" class="textosmediano">&nbsp;</td>
    <td><input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','CertificadoAlumnoRegular.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value);return document.MM_returnValue" value="Buscar"></td>
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