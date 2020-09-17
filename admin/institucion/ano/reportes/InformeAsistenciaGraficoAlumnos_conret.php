<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$curso;
	$periodo        =$periodo;
	$_POSP = 4;
	$_bot = 8;
	
	$sql_periodo    = "select * from periodo where id_periodo = ".$periodo." order by fecha_inicio";
	$result_periodo = @pg_Exec($conn, $sql_periodo);
	$fila_periodo   = @pg_fetch_array($result_periodo,0);
	$nombre_periodo = $fila_periodo['nombre_periodo'];
	
	

	
if (trim($_url)==""){ $_url=0;
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
                <td height="0"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
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
                            <td height="0" align="left" valign="top">
														
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" <? if ($curso!=0 and $periodo!=0){ ?> class="cajaborde" <? } ?>>
                                <tr> 
                                  <td>						  
								 
								  

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->

<?
include("../../../../cabecera/menu_inferior.php");
?>


<?
if ($curso!=0){
   ?>
<?php //echo tope("../../../../../util/");?>
	<center>
	<FORM method=post name="frm">
  <table width="700" border="0" cellspacing="1" cellpadding="3">
    <tr height=15> 
      <td colspan=5> <table border=0 cellspacing=1 cellpadding=1>
          <tr> 
            <td align=left> <strong><font face="arial, geneva, helvetica" size="1"> INSTITUCION 
              </font></strong> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
              </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong> 
              <?php  
                                                                               
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila['nombre_instit']);
												}
											}
										?>
              </strong> </font> </td>
          </tr>
          <tr> 
            <td align=left> <font face="arial, geneva, helvetica" size="1"> <strong>AÑO ESCOLAR</strong> </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong> 
              <?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila['nro_ano']);
												}
											}
										?>
              </strong> </font> </td>
          </tr>
          <tr> 
            <td align=left> <font face="arial, geneva, helvetica" size="1"> <strong>CURSO</strong> 
              </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
              </font> </td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong> 
              <?php
											$qry="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";

											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{

												$fila1 = @pg_fetch_array($result,0);	
												if (!$fila1){
													error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
													exit();
												}
												
							if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
								echo "PRIMER NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==121987) or ($fila1['cod_decreto']==1521989)) ){
								echo "PRIMER CICLO"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==1) and ($fila1['cod_decreto']==1000)){
								echo "SALA CUNA"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==2) and (($fila1['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "SEGUNDO NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==121987) ){
								echo "SEGUNDO CICLO";
							}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==1000)){
								echo "NIVEL MEDIO MENOR"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==3) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
								echo "TERCER NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==3) and ($fila1['cod_decreto']==1000)){
								echo "NIVEL MEDIO MAYOR"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==4) and ($fila1['cod_decreto']==1000)){
								echo "TRANSICIÓN 1er NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else if ( ($fila1['grado_curso']==5) and ($fila1['cod_decreto']==1000)){
								echo "TRANSICIÓN 2do NIVEL"." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}else{
								echo $fila1['grado_curso']." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
							}
												
											}
										?>
              </strong> </font> </td>
          </tr>
        </table></td>
    </tr>
	<tr><td>&nbsp;</td></tr>
    <tr> 
      <td colspan=5 align=right> 

		<div id="capa0">
			<div align="right">
		<?php if(($_PERFIL!=15)and($_PERFIL!=16)and($_PERFIL!=17)) { ?>
        	  	  <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printInformeAsistenciaGraficoAlumnos_conret.php?curso=<?=$curso ?>&periodo=<?=$periodo ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
        <?php } ?>
	    </div>

      </td>
    </tr>
	<TR>&nbsp;</TR>
	<br>
	<tr height="20"> 
      <td align="middle" colspan="5" class="tableindex"><div align="center">LISTADO DEL CURSO</div></td>
    </tr>
	<tr><td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><?=$nombre_periodo ?></b></font></td></tr>
	<br>
	<tr><td><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
	
    <tr> 
      <td align="center" width="5%" class="tablatit2-1">N&ordm;</td>
      <td align="center" width="35%" class="tablatit2-1">NOMBRE</td>
      <td align="center" width="50%" class="tablatit2-1">Asistencia</td>
      <td align="center" width="10%" class="tablatit2-1" bgcolor="#c8d6fb"><div align="center">%</div></td>
    </tr>
    <?
	$qry="SELECT matricula.bool_ar, alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.region, alumno.ciudad, alumno.comuna, matricula.id_curso FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano."))  order by ape_pat, ape_mat, nombre_alu asc ";
	$result =@pg_Exec($conn,$qry);
	if (!$result){
		error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
	}else{
	    if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
			
		   if (!$fila){
			  error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos en este curso</B>');
			  exit();
		   }
		}   
	}
	
	/// ciclo para listar cada alumno	
	for($i=0 ; $i < @pg_numrows($result) ; $i++){
		$fila = @pg_fetch_array($result,$i);
		$rut_alumno = $fila['rut_alumno'];	
		
		
		
		
		$sql_periodo = "select * from periodo where id_periodo = ".$periodo." order by fecha_inicio";
		$result_periodo = pg_Exec($conn, $sql_periodo);
		$periodos = pg_numrows($result_periodo);
		$cadena_asis_periodo=0;
		for($cont=0 ; $cont < @pg_numrows($result_periodo) ; $cont++){
			$fila_periodo = @pg_fetch_array($result_periodo,$cont);
			$fecha_ini = $fila_periodo['fecha_inicio'];
			$fecha_fin = $fila_periodo['fecha_termino'];
			$dias_habiles = $fila_periodo['dias_habiles'];
							
			
			$sql_asis = "select * from asistencia where fecha > '".$fila_periodo['fecha_inicio']."' and fecha < '".$fila_periodo['fecha_termino']."' and rut_alumno = ".trim($rut_alumno);
			$result_asis = @pg_Exec($conn, $sql_asis);
			$num_asis = @pg_numrows($result_asis);
			
			$asistencia = @round(100-($num_asis*100/$dias_habiles));	
			$anchotabla = (3 * $asistencia);
					
		}		
	    ?>
        <tr>
		  <td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $i+1; ?></font> </td>
          <td align="left" ><font face="arial, geneva, helvetica" style="font-size:9px"  color="#000000"><?php echo $fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_alu"];?></font></td>
          <td align="left" width="310" >
		        <table border="0" cellspacing="0" cellpadding="0" height="13"><tr><td background="images/fondo_barra.jpg" width="<?=$anchotabla ?>"></td><td background="images/termino_fondo.jpg" width="9"></td></tr></table>
		  </td>
          <td align="right" bgcolor="#c8d6fb" ><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo "$asistencia %"; ?></font></td>
        </tr>
        <?php
	    }	
	}
}
?>
	
</table></td></tr>

<?
  if ($curso!=0 and $periodo!=0){ ?>    
    <tr> 
     <td colspan="5"> <hr width="100%" color="#003b85"> </td>
    </tr>
<? } ?>	
	
  </table>
  </center>
  

  
<!-- FIN CUERPO DE LA PAGINA -->



<!-- INICIO FORMULARIO DE BUSQUEDA -->
<form method "post" action="InformeAsistenciaGraficoAlumnos_conret.php">
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
	    <select name="curso"  class="ddlb_9_x" >
            <option value=0 selected>(Seleccione Curso)</option>
		    <?
		    for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
		        if ($fila["id_curso"]==$cmb_curso){
  				    $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				    echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		        }else{
  				    $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				    echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		        }
            }
			?>
       </select>
</font> </div></td>
    <td width="61" class="textosimple">Periodo</td>
    <td width="219">
	<select name="periodo" class="ddlb_9_x">
	   <option value=0 selected>(Seleccione Periodo)</option>
        <?
		for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
		    $fila = @pg_fetch_array($result_peri,$i); 
		    if ($fila['id_periodo']==$cmb_periodos)
   			    echo  "<option selected value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		    else
   			    echo  "<option value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		     
	    } ?>
        </select></td>
     <td width="80"><div align="right">
     <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar">
    </div></td>
  </tr>
</table>

<?
if ($curso!=0 and $periodo!=0){ ?>
	  </td>
	  </tr>
	</table>
<? } ?>	


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
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
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