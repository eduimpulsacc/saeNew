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
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$tipo_ensenanza	=$tipo_ensenanza;
	
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
	// A�o Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
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
	$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$result_alu =@pg_Exec($conn,$sql_alu);
	// Subsectores
	//-----------------------------------------
	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) ORDER BY ramo.id_orden; ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	$num_subsectores = @pg_numrows($result_sub);
	//-----------------------------------------	
	
	$tipo_triplexxx = $tipo_ensenanza; 
	
	if ($tipo_ensenanza!=NULL or $tipo_ensenanza != 0){
		//////////////////// consulta para traer todos los alunos de cuarto medio con su promedio  /////////////////
		$sql_1 = "select al.rut_alumno, al.dig_rut, al.nombre_alu, al.ape_pat, al.ape_mat, al.comuna, c.id_curso, c.grado_curso, c.ensenanza, c.letra_curso,
				  p.promedio, co.nom_com from alumno al, promocion p, curso c, comuna co where
				  c.id_ano = '$_ANO' and 
				  c.grado_curso = '4' and
				  c.ensenanza = '$tipo_ensenanza' and
				  c.id_curso = p.id_curso and				  
				  p.rut_alumno = al.rut_alumno and
				  al.region = co.cod_reg and
				  al.ciudad = co.cor_pro and
				  al.comuna = co.cor_com				  
				  order by p.promedio desc";
		$res_1 = pg_Exec($conn,$sql_1);
		$num_1 = pg_numrows($res_1);
		
		$total = $num_1;
		
		$num_1 = ($num_1*5/100);
		$num_1 = substr($num_1,0,3);
		
		
		for ($i=0; $i < $num_1; $i++){
		    $fil_1 = pg_fetch_array($res_1,$i);
			$promedio      = $fil_1['promedio'];
		
		}
		
		
		
		///
		$sql_2 = "select al.rut_alumno, al.dig_rut, al.nombre_alu, al.ape_pat, al.ape_mat, al.comuna, c.id_curso, c.grado_curso, c.ensenanza, c.letra_curso,
				  p.promedio, co.nom_com from alumno al, promocion p, curso c, comuna co where
				  c.id_ano = '$_ANO' and 
				  c.grado_curso = '4' and
				  c.ensenanza = '$tipo_ensenanza' and
				  c.id_curso = p.id_curso and				  
				  p.rut_alumno = al.rut_alumno and
				  al.region = co.cod_reg and
				  al.ciudad = co.cor_pro and
				  al.comuna = co.cor_com and
				  p.promedio >= '$promedio'				  
				  order by p.promedio desc";
		$res_2 = @pg_Exec($conn,$sql_2);
		$num_2 = @pg_numrows($res_2);		
		
		
	}
	
		
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
				form.action = 'InformeRendimientoCriticoFinal.php?institucion=$institucion';
				form.submit(true);
	
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
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
								

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->


  <center>
  
  
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	 <? if (isset($tipo_ensenanza)){ ?>
	
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printInformeMejoresPromedios.php?tipo_ensenanza=<?=$tipo_ensenanza ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
        </div>
        </div>
		</td>
      </tr>
    </table>
	
	  </td>
      </tr>
      <tr>
      <td>

	  
	  <table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="tableindex"><div align="center"><strong>5%</strong> MEJORES PROMEDIOS DE LOS CUARTOS MEDIOS  </div></td>
      </tr>
      
      </table>
      <table width="100%" border="0" cellspacing="3" cellpadding="0">
        <tr>
          <td width="5%" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px"><b>Nro.</b></td>
		  <td width="10%" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px"><b>Rut</b></td>
          <td width="40%" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px"><b>Alumno</b></td>
          <td width="15%" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px"><b>Curso</b></td>
          <td width="20%" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px"><div align="center"><b>Promedio <br> 
            Final </b></div></td>
          <td width="10%" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px"><b>Comuna</b></td>
        </tr>
		<?
		for ($i=0; $i < $num_2; $i++){
		    $fil_2 = pg_fetch_array($res_2,$i);
			$rut_alumno    = $fil_2['rut_alumno'];
			$nombre_alu    = $fil_2['nombre_alu'];
			$promedio      = $fil_2['promedio'];
			$ape_pat       = $fil_2['ape_pat'];
			$ape_mat       = $fil_2['ape_mat'];
			$letra_curso   = $fil_2['letra_curso'];
			$grado_curso   = $fil_2['grado_curso'];
			$comuna        = $fil_2['nom_com'];
			
			?>
			 <tr>
			  <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px" align="right">&nbsp;<?=$i + 1 ?></td>
			  <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=$rut_alumno ?></td>
			  <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=$nombre_alu ?> <?=$ape_pat ?> <?=$ape_mat ?></td>
			  <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=$grado_curso ?> <?=$letra_curso ?></td>
			  <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;
			    <div align="center">
			      <?=$promedio ?>
			      </div></td>
			  <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=$comuna ?></td>
			</tr>
			<?
		}
        ?>
      </table>
      <br>
      <table width="100%" border="1" cellspacing="0" cellpadding="5">
        <tr>
          <td width="30%" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px">Total alumnos 4&ordm; Medios </td>
          <td width="70%" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px"><b><?=$total ?></b></td>
        </tr>
        <tr>
          <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px"> 5% mejores promedios </td>
          <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px"><b><?=$num_1 ?> (a seleccionar dentro de este informe)</b></td>
        </tr>
        <tr>
          <td colspan="2" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px">
		      El 5% mejores promedios de los 4� Medios, corresponde a: <?=$num_1 ?> dentro de este informe,
			  para evitar discriminaciones el sistema muestra  todos los alumnos, que posean
			  el mejor promedio m�s bajo.    
		  
		  </td>
          </tr>
      </table>

  <? } ?>	  
	  
    <br>
	<form action="InformeMejoresPromedios.php" method="post">
    <? 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	// aqui muestro todos los curso de la instituci�n
	$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
	$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
	$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
	$resultado_query_cue = pg_exec($conn,$sql_curso);
	?>
	  
      <br>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px">Tipo de ense&ntilde;anza </td>
          <td><label>
            <select name="tipo_ensenanza" class="ddlb_x">
			    <option value="0">Seleccione tipo de ense�anza</option>
				<?
				 for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
					 $fila    = @pg_fetch_array($resultado_query_cue,$i);
					 $filanex = @pg_fetch_array($resultado_query_cue,$i+1); 
					 $tipo_ensenanza = $fila['ensenanza'];
					 $tipo_ensenanzanex = $filanex['ensenanza'];
				  
				     if ($tipo_ensenanza > 309){
				  
						 if ($tipo_ensenanza==$tipo_ensenanzanex){
							// no muestro aun el promedio
							// y sigo acumulando
						 }else{
							// muestro el promedio y luego limpio las variables
							// busco el nombre de tipo de ensenanza
							$sql_te = "select * from tipo_ensenanza where cod_tipo = '$tipo_ensenanza'";
							$res_te = @pg_Exec($conn,$sql_te);
							$fila_te = pg_fetch_array($res_te,0);
							$nombre_tipo_ensenanza = $fila_te['nombre_tipo'];
							if ($tipo_ensenanza > 300){
								?>
								<option value="<?=$tipo_ensenanza ?>" <? if ($tipo_triplexxx==$tipo_ensenanza){ ?> selected="selected" <? } ?> ><?=$nombre_tipo_ensenanza ?> - <?=$tipo_ensenanza ?></option>
								<?
							} 	
						 }
					 }	 
				  }	
				?>
           </select>
          </label></td>
          <td><div align="right">
            <label>
            <input type="submit" name="Submit" value="Buscar">
            </label>
          </div></td>
        </tr>
      </table>
	  </form>
	  </td>
      </tr>
</table>
<span class="Estilo2">*Para Visualizar correctamente este informe, debe de haber generado la promoci&oacute;n para los cuarto medios.</span> <br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
</center>


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