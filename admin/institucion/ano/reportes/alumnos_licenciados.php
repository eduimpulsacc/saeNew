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
	$cod_tipo		=$cmb_curso;
	$curso  		=$cmb_curso;
	$_POSP = 4;
	$_bot = 8;
	
	$sqlEns="select ensenanza tipo_ensenanza where cod_tipo =".$cod_tipo;
	$resEns=@pg_exec($conn, $sqlEns);
	$ensenanza=@pg_fetch_array($resEns,0);
	
	if ($institucion==769){
	    $cargo="23";
	}else{
	    $cargo="1";
	}
	
	$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, (empleado.nombre_emp || ' ' || empleado.ape_pat ||' ' || empleado.ape_mat) as nombre, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=".$cargo.")) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultDIR =@pg_Exec($conn,$qryDIR);
	$filaDIR=@pg_fetch_array($resultDIR);
	$nombre_director = $filaDIR['nombre']; 
	
		
	$sqlAlu="select (trim(nombre_alu) || ' ' || trim(ape_pat) || ' ' || trim(ape_mat)) as nombre from alumno where rut_alumno=".$alumno;
	$resAlu=@pg_exec($conn, $sqlAlu);
	$nombreAlu=@pg_fetch_array($resAlu);
	
	$sqlAno="select nro_ano from ano_escolar where id_ano=".$_ANO;
	$resAno=@pg_exec($conn, $sqlAno);
	$ano=@pg_fetch_array($resAno,0);
	$nro_ano = $ano['nro_ano'];
	
	$sqlInsit="SELECT nombre_instit, region, ciudad, comuna, nu_resolucion, fecha_resolucion FROM institucion WHERE rdb=".$_INSTIT;
	$resInstit=@pg_exec($conn, $sqlInsit);
	$filaInstit=@pg_fetch_array($resInstit,0);
	$nombre_institucion = $filaInstit['nombre_instit'];
	
	
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

<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}
.Estilo3 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
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
          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printalumnos_licenciados.php?cod_tipo=<?=$cod_tipo ?>&dia=<?=$dia ?>&mes=<?=$mes ?>&ano2=<?=$ano2 ?>&enomina=<?=$enomina ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
        </div>
      </div></td>
  </tr>
</table>
<?
if ($cod_tipo==110){
    $grado_curso = 8;
}
if ($cod_tipo==310){
    $grado_curso = 4;
}	



$sql_alumnos="select alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.rut_alumno, alumno.dig_rut from alumno where rut_alumno in (select rut_alumno from promocion where  situacion_final='1' and id_curso in  (select id_curso from curso where id_ano = '$_ANO' and ensenanza = '$cod_tipo' and grado_curso = '$grado_curso'))  order by ape_pat, ape_mat, nombre_alu";
$result_alumnos= @pg_Exec($conn,$sql_alumnos);
?>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="logo_gobierno.jpg" width="121" height="81"><br>
          <br>
          <br>
          <br></td>
      </tr>
      <tr>
        <td><div align="center" class="Estilo2">N&oacute;mina de Alumnos Licenciados</div>
          <?php 
		  $tipo_ensenanza = $ensenanza['ensenanza'];
		  
		  $sql_ense = "select * from tipo_ensenanza where cod_tipo = '$tipo_ensenanza'";
		  $res_ense = @pg_Exec($conn,$sql_ense);
		  $fil_ense = @pg_fetch_array($res_ense);
		  
		  $nombre_ensenanza = $fil_ense['nombre_tipo'];
		  
		  echo "<font face=verdana size=1><div align=center>$nombre_ensenanza</div></font>";
		  
		  ?>
     </td>
      </tr>
    </table>
      <br>
      <br>
      <br>
      <table width="100%" border="1" cellpadding="5" cellspacing="1" bordercolor="#999999">
        <tr>
          <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="20%"><span class="Estilo2">Establecimiento</span></td>
              <td width="50%" class="Estilo2"><?=$nombre_institucion ?></td>
              <td width="15%" class="Estilo3">A&ntilde;o escolar </td>
              <td width="15%" class="Estilo3"><font size="1" face="Arial, Helvetica, sans-serif"><?=$nro_ano ?></font></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="Estilo3">Regi&oacute;n</td>
              <td class="Estilo3"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $region['nom_reg']?></font></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="Estilo3">Provicnia</td>
              <td class="Estilo3"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $ciudad['nom_pro']?></font></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="Estilo3">Comuna</td>
              <td class="Estilo3"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $comuna['nom_com']?></font></td>
            </tr>
          </table>
            <br></td>
          </tr>
        <tr>
          <td width="5%" height="25" bgcolor="#CCCCCC"><span class="Estilo1">N&ordm;</span></td>
          <td width="23%" bgcolor="#CCCCCC"><span class="Estilo1">Apellido Paterno </span></td>
          <td width="23%" bgcolor="#CCCCCC"><span class="Estilo1">Apellido Materno </span></td>
          <td width="33%" bgcolor="#CCCCCC"><span class="Estilo1">Nombres</span></td>
          <td width="15%" bgcolor="#CCCCCC"><span class="Estilo1">R.U.N.</span></td>
        </tr>
		<?
		for($x=0;$x<@pg_numrows($result_alumnos);$x++){ 
            $fila_alumnos = pg_fetch_array($result_alumnos,$x);
            $ape_pat      = $fila_alumnos['ape_pat'];
			$ape_mat      = $fila_alumnos['ape_mat'];
			$nombre_alu   = $fila_alumnos['nombre_alu'];
			$rut_alumno   = $fila_alumnos['rut_alumno'];
			$dig_rut      = $fila_alumnos['dig_rut'];
			?>		
			<tr>
			  <td class="Estilo3"><?=$x + 1; ?></td>
			  <td class="Estilo3"><?=$ape_pat ?></td>
			  <td class="Estilo3"><?=$ape_mat ?></td>
			  <td class="Estilo3"><?=$nombre_alu ?></td>
			  <td class="Estilo3"><? echo "$rut_alumno-$dig_rut"; ?></td>
			</tr>
			<?
		}
		
		?>	
      </table>
      <br>
      <br>
      <br>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="Estilo3"><?php echo ucwords(strtolower($comuna['nom_com'])).", ".$dia." de ".$mes." del ".$ano2 ?>&nbsp;<br>
            <br>
            <br>
            <br></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="Estilo1">
            <label></label>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="50%" class="Estilo1">
				<div align="center">
				 _________________________<br>
				 <?=$enomina ?><br>
          ENCARGADO DE CONFECCION DE NOMINAS</div>
				</td>
                <td width="50%" class="Estilo1">
				<div align="center">
				 _________________________<br>
		  <?
		  if ($_INSTIT==1756){
		     echo "RAQUEL GUERRERO OVALLE"; 
		  
		  }else{
              echo "$nombre_director";
		  }
		  
		  ?>	  
		  <br>
           DIRECTOR(A) DEL ESTABLECIMIENTO<? //=$cargo_dir2 ?></div>
				</td>
              </tr>
            </table>
           </td>
          </tr>
      </table>
      </td>
  </tr>
</table>
<br>
<?  	

}
?>
<!-- FIN CUERPO DE LA PAGINA -->
<!-- INICIO FORMULARIO DE BUSQUEDA -->
<form method "post" action="alumnos_licenciados.php">
<? 

$institucion	=$_INSTIT;
$ano			=$_ANO;

if ($institucion!=0){
	$whe_ensenanza=" OR (ensenanza = 10)";
}

$sql_curso  = "select * from tipo_ensenanza where cod_tipo in (SELECT cod_tipo from tipo_ense_inst where rdb = '".$_INSTIT."' and cod_tipo > 100 order by cod_tipo)";

$resultado_query_cue= @pg_Exec($conn,$sql_curso);

/*
$sql_curso  = "SELECT  curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso .= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso .= "WHERE (((curso.id_ano)=".$ano.")) AND ((
(curso.grado_curso=8) and (curso.ensenanza=110)) OR ((curso.grado_curso<5) and (curso.ensenanza<>110)) $whe_ensenanza )";
$sql_curso .= "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
*/
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
    <td width="78" class="textosimple">Ense&ntilde;anza</td>
    <td width="263">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	      <select name="cmb_curso"  class="ddlb_9_x" >
          <option value=0 selected>(Seleccione Tipo de Enseñanza)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
		       $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  
			   if ($fila["cod_tipo"]==$cmb_curso){
					$Curso_pal = $fila['nombre_tipo'];
					echo "<option selected value=".$fila['cod_tipo'].">".$Curso_pal."</option>";
			   }else{
					$Curso_pal = $fila['nombre_tipo'];
					echo "<option value=".$fila['cod_tipo'].">".$Curso_pal."</option>";
			   }
		  
          } ?>
        </select>
</font>	  </div></td>
    <td width="61" class="textosimple"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent',''certificadoEBasicaMedia.php?dia='+dia.value+'&amp;mes='+mes.value+'&amp;ano2='+ano2.value+'&amp;c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value');return document.MM_returnValue" value="Buscar"></td>
    </tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
<br>
<table width="600" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td class="Estilo2">Encargado confecci&oacute;n de n&oacute;minas </td>
    <td><input name="enomina" type="text" value="<?=$enomina ?>" size="40"></td>
  </tr>
</table>
<br>
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