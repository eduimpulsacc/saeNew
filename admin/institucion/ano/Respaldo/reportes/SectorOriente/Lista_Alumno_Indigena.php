<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$_POSP = 5;
	$_bot = 8;

	
	if (trim($_url)=="") $_url=0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../../coe_prueba/admin/institucion/Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../../coe_prueba/admin/institucion/Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">


<link href="../../../../../estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../cabecera/menu_superior.php");
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
						include("../../../../../menus/menu_lateral.php");
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
<table width="731" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="731" height="30" align="center" valign="top"> 
        <?
						include("../../../../../cabecera/menu_inferior.php");
						?>
	  
	  
	  
	  <tr>
    <td> <div align="right"><font color="#000099" size="2">*para volver presione 
        Reportes</font><font color="#000099"><strong> </strong></font></div></td>
		</tr> 
  
  
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<?
if ($cmb_curso!=0){
   ?>

<?php //echo tope("../../../../../util/");?>
	<center>
  <table width="550" border="0" cellspacing="1" cellpadding="3">
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
        <?php if(($_PERFIL!=15)and($_PERFIL!=16)and($_PERFIL!=17)) { ?>
        <!--input name="button" type="button" class="botonX" onClick=window.open("ImprimeListaAlumnos.php","","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=700,height=650,top=85,left=140") onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR"-->	
		<div id="capa0">
			<div align="right">
		  	  <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printLista_Alumno_Indigena.php?cmb_curso=<?=$cmb_curso ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
			</div>
	    </div>
        <?php } ?>
      </td>
    </tr>
	<TR>&nbsp;</TR>
	<br>
	<tr height="20"> 
      <td align="middle" colspan="5" class="tableindex"><div align="center">LISTADO DE ALUMNOS INDIGENAS</div></td>
    </tr>
	<tr><td>&nbsp;</td></tr>
	<br>
	<tr><td><table width="600" border="1" align="center" cellpadding="0" cellspacing="0">
	
    <tr> 
	  <td align="center" width="270" class="tablatit2-1">RUT</td>
      <td align="center" width="270" class="tablatit2-1">NOMBRE</td>
      <td align="center" width="270" class="tablatit2-1">FECHA NAC.</td>
	  <td align="center" width="270" class="tablatit2-1">DIRECCION</td>
    </tr>
    <?php
				$qry="SELECT alumno.rut_alumno,alumno.dig_rut, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.fecha_nac FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) AND matricula.bool_aoi=1  order by ape_pat, ape_mat, nombre_alu asc ";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
				}else{
				if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
					$fila = @pg_fetch_array($result,0);	
					if (!$fila){
						error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos en este curso</B>');
						exit();
					}
				}
			?>
    <?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
			?>
	  <td align="left" width="12%"> <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;&nbsp;<? echo $fila['rut_alumno']." - ".$fila['dig_rut']; ?></font> </td>
      <td align="left" width="40%"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>&nbsp;&nbsp;<?php echo $fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_alu"];?></strong> </font></td>
	  <td align="left" width="12%"> <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;<? impF($fila['fecha_nac']);?></font> </td>
	  <td align="left" width="40%"> <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;<? echo $fila['calle']."  ".$fila['nro']; ?></font> </td>
    </tr>
    <?php
					}
				}
			?>
	
	</table></td></tr>
    
	<tr> 
      <td colspan="5"> <hr width="100%" color="#003b85"> </td>
    </tr>
  </table>
</center>
   <?
}
?>   

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form action="Lista_Alumno_Indigena.php" method="post">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
?>
<center>
<table width="550" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="550">
	<table width="550" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="tableindex" align="center">Buscador Avanzado</td>
  </tr>
  <tr>
    <td height="27">
	<table width="550" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="420" class="textosmediano">Buscar por Curso
      <select name="cmb_curso" class="ddlb_x">
        <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		  $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		  
		  if ($fila['id_curso'] == $cmb_curso){
		     echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
		  }else{
		     echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }	 	 
           } ?>
      </select></td>
    
   
    <td width="80">
            <div align="center">
              <input name="cb_ok" class="botonXX"  type="submit" value="Buscar">        
                  </div></td>
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
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
