<?php require('../../../util/header.inc');?>
<?php 
	$institucion	= $_INSTIT;
	$_POSP = 3;
	$_bot = 0;
	
	$curso = $cmb_curso;
	$ano   = $_ANO;
    $tipo_clave = $_GET['tipo_clave'];
	
	
	if($_PERFIL==0){
		//echo $curso;
		}

	if ($tipo_clave==1)
	{
		session_register('_TIPO_CLAVE');
		$_TIPO_CLAVE = 1;
		$sqlAlumnos = "select matricula.rut_alumno as rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu as nombres, matricula.id_curso from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = ".$curso." and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
		$rsResultado =@pg_Exec($conn,$sqlAlumnos);
		$texto = "ALUMNO";		
	} if ($tipo_clave==2){
		session_register('_TIPO_CLAVE');
		$_TIPO_CLAVE = 1;
		
		 $sql = "select apoderado.rut_apo as rut, apoderado.ape_pat, apoderado.ape_mat, apoderado.nombre_apo as nombres from matricula, apoderado, tiene2 where matricula.id_ano = ".$ano." and matricula.id_curso = ".$curso." and matricula.rut_alumno = tiene2.rut_alumno and apoderado.rut_apo = tiene2.rut_apo order by apoderado.ape_pat, apoderado.ape_mat";
		$rsResultado =@pg_Exec($conn,$sql);		
		$texto = "PADRES Y APODERADOS";		
	}
	

	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
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
//-->
</script>

<script language="JavaScript">
<!--
function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=300, height=266, top=85, left=140";
window.open(pagina,"",opciones);
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script> 

<script>
	function valida(form)
	{
		if(!chkSelect(frm_buscador.cmb_curso,'Seleccione Curso')){
			return false;
		};

		return true;
	}
	
	function ventanaSecundaria (URL){
	   window.open(URL,"Excel")
	}
</script>	

<SCRIPT language="JavaScript">
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <?
			   include("../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
										
						
								  
							 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
					            	<br>
								   <!-- AQUI VA TODA LA PROGRAMACIÓN  -->
								   
<center><form action="procesoClave.php" method="POST" name="form">
  <table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="right">
	<? if ($institucion==9071){?>
	    <INPUT class="botonXX" name="button" TYPE="button"  value="GENERAR EXCEL" onClick="ventanaSecundaria('genera_excel.php?curso=<?= $cmb_curso?>')">
	<? } ?>
	<? if ($cmb_curso != NULL){ ?>
	    <INPUT class="botonXX" name="button" TYPE="submit"  value="GUARDAR">
	<? } ?>
	<INPUT name="button" TYPE="button" class="botonXX" onClick="MM_goToURL('parent','ListadoClaves.php?tipo=<?=$tipo_clave ?>');return document.MM_returnValue" value="VOLVER"></td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="1" cellpadding="3">
	<TR height=20>
		<TD align=center colspan=2 class="tableindex"> Administrador de Claves - <? echo $texto?>		</TD>
	</TR>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr>
	<td width="92" class="tablatit2-1">Activo/Inactivo</td>
	<td width="109" class="tablatit2-1">RUT (NOMBRE USUARIO) </td>
    <td width="80" class="tablatit2-1">CLAVE</td>
    <td width="235" class="tablatit2-1">NOMBRE  </td>
    <td width="98" class="tablatit2-1">BLOQUEAR</td>
    </tr>
  <?
	for($i=0;$i < @pg_numrows($rsResultado);$i++){
		$fResultado= @pg_fetch_array($rsResultado,$i);
		$url_pass = "_ALUMNO=".trim($fResultado['rut']);
		
	  if ($tipo_clave==2) 
		$url = "curso/alumno/apoderado/usuario/usuario.php3?RUT";
	  else 
		$url = "curso/alumno/usuario/usuario.php3?RUT";
	    
	$sql="SELECT estado FROM accede 
	INNER JOIN usuario ON accede.id_usuario=usuario.id_usuario 
	WHERE nombre_usuario='".$fResultado['rut']."'";
	
	//if($_PERFIL==0){echo $sql;}
		$Rs_Clave = @pg_exec($connection,$sql);
		$filsClave = @pg_fetch_array($Rs_Clave,0);
		$Estado = $filsClave['estado'];
?>
  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'>
  <!-- <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('<? echo $url;?>=<? echo trim($fResultado['rut'])?>')>  -->     
    <td><font face="Arial, Helvetica, sans-serif"><INPUT TYPE="checkbox" NAME="usuario[<? echo $i ?>]" value="<? echo $fResultado['rut']?>" <? if ($Estado==0){ ?> checked <? } ?>></font></td>
	<td><font face="Arial, Helvetica, sans-serif"><? echo $fResultado['rut']?></font></td>
    <td><font face="Arial, Helvetica, sans-serif">
	<?
	$sqlUsuario = "select * from usuario where nombre_usuario = '".$fResultado['rut']."'";
	$rsUsuario =@pg_Exec($connection,$sqlUsuario);	
	$fUsuario= @pg_fetch_array($rsUsuario,0);	
	echo $fUsuario['pw'];
	
	$sql ="SELECT bloqueo FROM alumno WHERE rut_alumno='".$fResultado['rut']."'";
	$rs_alumno = pg_exec($conn,$sql);
	$bloqueo = pg_result($rs_alumno,0);
	?>
	&nbsp;</font></td>
    <td><font face="Arial, Helvetica, sans-serif"><? echo ucwords(strtolower(trim($fResultado['ape_pat'])." ".trim($fResultado['ape_mat'])." ".trim($fResultado['nombres'])))?></font></td>
     <td><input type="checkbox" name="bloqueo[<? echo $i ?>]" id="bloqueo[<? echo $i ?>]" value="<? echo $fResultado['rut']?>" <? if ($bloqueo==1){ ?> checked <? } ?>>
      </td>
	<INPUT TYPE="hidden" name="clave[<? echo $i ?>]" value="<? echo $fResultado['rut']?>">
    </tr>
  <? } ?>
</table>
</form>
 
</center>
							
					<!-- AQUÍ INGRESO EL CONTENIDO DE LA PÁGINA MotorBuscadorCalve.php, QUE AHORA VA SIN FRAME -->
					           
							   
							   
							   <br>
								<br>

							   
 <form action="ListarClavesCurso.php?tipo_clave=<? echo $tipo_clave ?>" method="post"  name="frm_buscador">

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
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="600">
	<table width="600" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="600" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78" class="cuadro01">Curso</td>
    <td width="263">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x" >
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
</font>	  </div></td>
    <td width="80"><div align="right">
      <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar" onClick="return valida(this.form);">
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
	<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
   </td>
 </tr>
</table>							  
	
     </tr>
     </table>
     </td>
     </tr>
     
     <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<? pg_close($conn); ?>
</body>
</html>
