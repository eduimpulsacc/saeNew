<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$reporte		=$c_reporte;
	$cadena01		="00";	
	$_POSP = 4;
	$_bot = 8;
	
	
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
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">



<? 
/*$sql1= "select * from ramo";
$result_con1 =pg_Exec($conn,$sql1)or die("Fallo :".$sql1);
for($i=0;$i<pg_numrows($result_con1);$i++){
						$fila1 = pg_fetch_array($result_con1,$i);  
						
						}
						 $id_curso = $fila1['id_curso'];

$sql= "select * from ramo r where r.conexper = 1 and id_curso = ".$id_curso.";";		
						$result_con =pg_Exec($conn,$sql)or die("Fallo :".$sql);
						
						for($e=0;$e<pg_numrows($result_con);$e++){
						$fila = pg_fetch_array($result_con,$e);  
						
						}
						echo $conexper = $fila['conexper'];*/
?>


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
								  <table width="731" height="0" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="731" height="0" align="center" valign="top"> 
      
	  
	 
  
  
</table>
<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form method "post" action="printPlanillaNotasGeneralesPeriodo.php" name="form" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 
	$ob_motor = new MotorBusqueda();
	$ob_motor ->ano =$ano;
	$ob_motor->perfil=$_PERFIL;
	$ob_motor->curso=$_CURSO;
	$ob_motor->usuario=$_NOMBREUSUARIO;
	$ob_motor->rdb=$institucion;
	$resultado_query_cue = $ob_motor ->curso2($conn); 
	
	//------------------
	$ob_motor ->ano =$ano;
	$result_peri = $ob_motor ->periodo($conn);
	
	//------------------
?>
<center>
<table width="709" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701"  class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
  <tr class="cuadro01">
    <td width="69">Curso</td>
    <td width="272">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso" class="ddlb_x">
		  <option value=0 selected>(Seleccione Curso)</option>
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
		  }
		  ?>
        </select>
	    </font>	  </div></td>
    <td width="61" class="textosmediano">Periodo</span></td>
    <td width="219"><select name="cmb_periodos">
			<option value=0 selected>(Seleccione Periodo)</option>
       <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_peri,$i); 
		  
		  if ($fila['id_periodo'] == $cmb_periodos){
		  	  ?>
              <option value="<? echo $fila['id_periodo']?>" selected><? echo $fila['nombre_periodo']?></option>
	          <?
		  }else{
		      ?>
              <option value="<? echo $fila['id_periodo']?>"><? echo $fila['nombre_periodo']?></option>
	          <?
		  }	  	  
	   
	   
	    } ?>
    </select></td>
    <td width="80"><div align="right"></div></td>
  </tr>
  <tr class="cuadro01">
    <td>Orden</td>
    <td>
      <div align="left">
        <input name="orden" type="radio" value="1" checked>
      Alfabetico 
      <input name="orden" type="radio" value="0">
      Nro Lista </div></td><td colspan="2"><div align="left">Sin alumnos retirados
        <input name="retirados" type="radio" value="1">
        </div></td>
    <td><div align="right"></div></td>
  </tr>
  <tr class="cuadro01">
    <td>Promedio</td>
    <td><input name="ck_opcion" type="radio" value="1" checked>
      Aritm&eacute;tico 
        <input name="ck_opcion" type="radio" value="0">
        Apreciaci&oacute;n</td>
         <? if ($institucion == 22019 or $institucion==24730){
		    ?>
   <td colspan="2" class="cuadro01">Letra May&uacute;scula
	       &nbsp; <input type="checkbox" name="check_may" value="1" > 
			<? }?> </td>
    <td>&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td>Promedio</td>
    <td>Con Examen&nbsp;&nbsp;&nbsp;
      <input type="checkbox" name="conexamen" id="conexamen" value="1"></td>
    <td colspan="2">Mostrar Suma de Promedios&nbsp;&nbsp;
    <input type="checkbox" name="sumapromedios" id="sumapromedios" value="1">
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td>Genero</td>
    <td><input type="radio" name="genero" id="radio" value="1">
      Femenino
        <input type="radio" name="genero" id="radio2" value="2">
Masculino
<input name="genero" type="radio" id="radio3" value="3" checked>
<label for="genero">Ambos</label></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" align="right"><input name="cb_ok" class="botonXX"  type= "submit"  value="Buscar">
      <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver" onClick="window.location='Menu_Reportes_new2.php'"></td>
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
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
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