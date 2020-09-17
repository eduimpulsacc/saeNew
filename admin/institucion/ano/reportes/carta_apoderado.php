<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$docente		= 5; //Codigo Docente
	$frmModo		=$_FRMMODO;
	$alumno			=$alumno;	


if ($cmb_curso>0){
   $q1 = "SELECT * from institucion where rdb = '".trim($_INSTIT)."'";
   $r1 = @pg_Exec($conn,$q1);
   $n1 = @pg_numrows($r1);
   
   
   
    $qryEMP="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultEMP =@pg_Exec($conn,$qryEMP);
	if (!$resultEMP) {
	    error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
	     if (pg_numrows($resultEMP)!=0){//En caso de estar el arreglo vacio.
				$filaEMP = @pg_fetch_array($resultEMP,0);
				$nombre_director  =	$filaEMP['nombre_emp'];
				$nombre_director .= $filaEMP['ape_pat'];
				$nombre_director .= $filaEMP['ape_mat'];
				$ciudad           = $filaEMP['ciudad'];                
		 }
	}
	/// aqui determino el curso elegio
	$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
	$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) and curso.id_curso = '".trim($cmb_curso)."'";
	$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
	$resultado_query_cue = pg_exec($conn,$sql_curso);
	//------------------
	$sql_peri = "select * from periodo where id_ano = ".$ano;
	$result_peri = pg_exec($conn,$sql_peri);
    
	$fila = @pg_fetch_array($resultado_query_cue,0); 
	$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
	/// fin curso elegido
	
	
	
	
	// ahora tomo el nombre  del apoderado
	if (($cmb_apoderado>0) or ($cmb_alumno>0)){
	      $sq = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno in (select rut_alumno from matricula where rut_alumno = '".trim($cmb_alumno)."'))";  
	}
	
	$rs = @pg_Exec($conn,$sq);
	$ns = @pg_numrows($rs);
	 
}

//// FECHA HOY   ////
$dia_hoy = date(d);
$mes_hoy = date(m);
$ano_hoy = date(Y);

if ($mes_hoy=="01"){
   $mes_hoy = "Enero";
}
if ($mes_hoy=="02"){
   $mes_hoy = "Febrero";
}
if ($mes_hoy=="03"){
   $mes_hoy = "Marzo";
}
if ($mes_hoy=="04"){
   $mes_hoy = "Abril";
}
if ($mes_hoy=="05"){
   $mes_hoy = "Mayo";
}
if ($mes_hoy=="06"){
   $mes_hoy = "Junio";
}
if ($mes_hoy=="07"){
   $mes_hoy = "Julio";
}
if ($mes_hoy=="08"){
   $mes_hoy = "Agosto";
}
if ($mes_hoy=="09"){
   $mes_hoy = "Septiembre";
}
if ($mes_hoy=="10"){
   $mes_hoy = "Octubre";
}
if ($mes_hoy=="11"){
   $mes_hoy = "Noviembre";
}
if ($mes_hoy=="12"){
   $mes_hoy = "Diciembre";
}    

$fecha_hoy = "$dia_hoy $mes_hoy de $ano_hoy";

$qry_url = "select * from salida where rdb = '$institucion'";
    $result_2 =pg_Exec($conn,$qry_url);
    $fila_1 = @pg_fetch_array($result_2,0);	
	$web = $fila_1['direccion'];


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
	<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
.conscroll {
overflow: auto;
width: 500px;
height: 400px;
clear:both;
} 
.salto{
page-break-after:always;
}
.Estilo5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
    </style>
<script>
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
	
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (document.form.cmb_curso.value!=0){				
				document.form.action = "carta_apoderado.php";
				document.form.submit();
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
		function envia(){
			document.form.action="carta_apoderado.php";
			document.form.ssww.value=1;
			document.form.submit();
		}	
									
</script>

<script language="JavaScript" type="text/JavaScript">
<!--
function imprimir(){
Element = document.getElementById("layer1")
Element.style.display='none';
Element = document.getElementById("layer2")
Element.style.display='none';
window.print();
Element = document.getElementById("layer1")
Element.style.display='';
Element = document.getElementById("layer2")
Element.style.display='';
}

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

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><table width="100%"><tr><td><?
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
<table width="731" height="0" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="731" height="0" align="center" valign="top"> 
      
	                    <?
						include("../../../../cabecera/menu_inferior.php");
						?>
<!--a href="" target="_top"-->
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->

<? if ($BUSCAR=="BUSCAR"){?>
<div id="layer2">
<table width="100%">
  <tr><td align="right">
<input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printcarta_apoderado.php?ssww=1&cmb_curso=<?=$cmb_curso?>&alumno=<?=$alumno?>&cmb_alumno=<?=$cmb_alumno ?>','','scrollbars=yes,resizable=no,width=700,height=500')"  value="IMPRIMIR">
</td></tr></table>									
</div>
<?
if ($cmb_alumno==0){
    // listar cada apoderado de cada alumno
	$sq = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno in (select rut_alumno from matricula where id_curso = '".trim($cmb_curso)."'))";  
    $rs = @pg_Exec($conn,$sq);
	$ns = @pg_numrows($rs);
}
?>

<?
$i=0;
while ($i < $ns){
	$fs = @pg_fetch_array($rs,$i);
	$nombre_apoderado =  ucwords(strtolower($fs['ape_pat'].$fs['ape_mat'].$fs['nombre_apo'])); 
	$rut_apo          =  $fs['rut_apo']; 
	
    ?>	
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>
			<!-- aqui va la insignia -->
			
			<table width="125" border="0" cellpadding="0" cellspacing="0">
			<tr valign="top" >
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
				}?>		  </td>
			</tr>
		  </table>
			
			<!-- fin de la insignia -->	
			
			</td>
			<td><div align="right"><span class="Estilo5"><?=$fecha_hoy ?></span></div></td>
		  </tr>
		</table>
		<?
				
		//// aqui tomo los datos del alumno
		
		  if ($cmb_alumno==0){
			   $sql="select * from alumno where rut_alumno in (select rut_alumno from tiene2 where rut_apo = '".trim($rut_apo)."' and rut_alumno in (select rut_alumno from matricula where id_ano=$ano and rdb=$_INSTIT and bool_ar=0 and rut_alumno in (select rut_alumno from tiene2 where rut_apo = '".trim($rut_apo)."')))";
		  }else{
			   $sql="select * from alumno where rut_alumno in (select rut_alumno from tiene2 where rut_apo = '".trim($rut_apo)."' and rut_alumno in (select rut_alumno from matricula where id_ano=$ano and rdb=$_INSTIT and bool_ar=0 and rut_alumno=$cmb_alumno))";
		  }	  
		
		
		//$sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno and alumno.rut_alumno = '".trim($cmb_alumno)."'";
		$result= @pg_Exec($conn,$sql);
		$fila =  @pg_fetch_array($result,0);
		$nombre_alumno  = $fila['ape_pat'];
		$nombre_alumno .= $fila['ape_mat'];
		$nombre_alumno .= $fila['nombre_alu'];
		/// fin nombre del alumno
	    		
		/// ahora debo tomar los datos de acceso
		$sq1 = "select * from usuario where nombre_usuario = '".trim($rut_apo)."' ";
		$rq1 = pg_Exec($conn,$sq1);
		if (@pg_numrows($rq1)>0){
			 $filasq1 = @pg_fetch_array($rq1,0);
			 $usuario_apoderado = $filasq1['nombre_usuario'];
			 $clave_apoderado   = $filasq1['pw'];
		}
		//// fin datos de acceso del apoderado	
	    ?>
		
		
		  <p class="Estilo5"><br>
			<br>
			Se&ntilde;or(a):  <b><?=$nombre_apoderado ?></b><br>
			Apoderado(a)  de <b><?=$nombre_alumno ?></b> de <b><?=$Curso_pal ?></b></p>
		  <p class="Estilo5"><strong>Presente:</strong></p>
		  <p class="Estilo5">Junto  con saludarle, tenemos el agrado de informarle que nuestro establecimiento se  encuentra en un plan de innovaci&oacute;n tecnol&oacute;gica y se ha adherido a la plataforma  Internet de Gesti&oacute;n Escolar &ldquo;Colegio Interactivo&rdquo;.<br>
		    <br>
	  Esta  aplicaci&oacute;n a la cual podr&aacute; acceder desde el &nbsp;sitio Web <? if ($web==null){ echo "http://www.colegiointeractivo.com";} else { echo $web ;}?>, nos permitir&aacute;&nbsp; fortalecer la misi&oacute;n familia-colegio,  inform&aacute;ndole en forma continua tanto del rendimiento acad&eacute;mico de su pupilo(a),  como su conducta, a fin de fortalecer sus debilidades y destacar sus logros.<br>
	  Para  acceder a esta informaci&oacute;n por primera vez, siga los siguientes pasos:</p>
		  <ol class="Estilo5">
			<li>Ingrese nombre usuario: <b><?=$usuario_apoderado ?></b> </li>
			<li>Clave: <b><?=$clave_apoderado ?></b></li>
		  </ol>
		  <p class="Estilo5">Como norma de  seguridad, le solicitamos modifique su clave peri&oacute;dicamente y en caso de tener  dificultades comun&iacute;quese con el soporte interno del Colegio.</p>
		  <p class="Estilo5">&nbsp;</p>
		  <p class="Estilo5">Atentamente a  usted.<br>
		  </p>
		  <p align="center" class="Estilo5"><strong><?=$nombre_director ?></strong><br>
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Director(a)<br>
		  </p>
		  <hr></td>
	  </tr>
	</table>
    <?
	$i++;
 } ?>

<? } ?>
<!-- FIN CUERPO DE LA PAGINA -->
<!-- INICIO FORMULARIO DE BUSQUEDA -->
<?
$institucion	= $_INSTIT;
$ano			= $_ANO;
$c_curso = 0;




?>
<br>
<form name="form" method "post" action="">
<input name="ssww" type="hidden" value="">
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
  <table width="90%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td colspan="2" class="tableindex">Buscador Avanzado </td>
      </tr>
    <tr>
      <td width="40%">Curso</td>
      <td width="60%">&nbsp;
	  
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
        </select></td>
    </tr>
    <tr>
      <td>Alumno</td>
      <td>&nbsp;
	  <select name="cmb_alumno" class="ddlb_9_x">
      <option value=0 selected>(Todos los Alumnos)</option>
      <?
		$sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
		$result= @pg_Exec($conn,$sql);
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);?>
      <option value="<? echo $fila["rut_alumno"]; ?>" <? if ($cmb_alumno==$fila['rut_alumno']){ ?> selected="selected" <? } ?>><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
      <?
		}
		?>
    </select></td>
    </tr>
  
    <tr>
      <td colspan="2"><div align="center">
        <label>
        <input name="BUSCAR" type="submit" id="BUSCAR" value="BUSCAR">
        </label>
      </div></td>
      </tr>
  </table>  
</center>
</form>

								 
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table>
							  
						    </td>
                          </tr>
                        </table>
						
					</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>
          </td>

         
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>