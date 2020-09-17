<?
require('../../../../util/header.inc');
//require('../../../../util/funciones.php');
//require('../../../../util/LlenarCombo.php3');
//require('../../../../util/SeleccionaCombo.inc');
//include('../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$cadena01		="00";	
	$_POSP = 4;
	$_bot = 8;
	
	//$ob_reporte = new Reporte();
	
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="../../../clases/jquery/jqueryui/jquery-ui-1.8.6.custom.css">
<script type="text/javascript" src="../../../clases/jquery/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../clases/jquery/jqueryui/jquery-1.4.2.min.js"></script>


<script language="JavaScript">

function enviapag(form){
	
	if (form.cmbCARRERA.value!=0){
	
		form.target="_self";
		form.action = 'motorRendimientoCriticoAcademico_CFT.php';
		form.submit(true);
		
		}	
	}			
	
function enviapag2(form){
		
		if (form.cmbCARRERA.value!=0){
		
			form.target="_blank";
			form.method="post"
			form.action = 'printRendimientoCriticoAcademico_CFT.php';
			form.submit(true);
			form.action = 'motorRendimientoCriticoAcademico_CFT.php';
			
			}	
		}

function enviando_parametros_grafico(){ 
   
    var grafico1  = $('#grafico1').val();
	var idcurso   = $('#cmbCURSO').val();
	var idcarrera = $('#cmbCARRERA').val();

	$("#grafico1").html('Buscando Grafico...');
	
   	var parametros ="idcurso="+idcurso+"idcarrera="+idcarrera;
		
		$.ajax({
   							
   			  url:'graficos/g_rendimiento_critico.php',
   			  data:parametros,
			  type:'POST',
			  success:function(data){
				
				 $("#grafico1").html(data); 
				 
				 $("#grafico1").dialog({
				    //modal: true,
				    title: "Grafico",
				    width: 800,
				    minWidth: 400,
				    maxWidth: 700,
				    show: "fold",
				    hide: "scale"
			      });
			          				   
				} 
			})  
	  
	  } 


<!--
function PopWindow()
{
window.open('popgraficosrendimientocritico.php','graficos','width=950,height=500,menubar=no,scrollbars=yes,toolbar=no,location=no,directories=no,resizable=no,top=120,left=70');
}
//-->


</script>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>

<td width="53" height="722" align="left" valign="top" 
background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;
		  
		  </td>
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
         <table width="100%" height="294" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								

<!-- FIN CODIGO DE BOTONES --><!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->
<FORM >
<? 

$sql_curso= "SELECT curso.id_curso, nombre FROM curso 
WHERE curso.id_ano=".$ano." AND id_carrera=".$cmbCARRERA;
$resultado_query_cue = pg_exec($conn,$sql_curso);

//------------------
$sql ="SELECT nombre, id_carrera FROM carrera WHERE rdb=".$institucion;
$rs_carrera =@pg_exec($conn,$sql) or die("SELECT FALLO :".$sql);

?>
<center>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701"  class="tableindex">Buscador Avanzado</td>
  </tr>
  <tr class="cuadro01">
    <td height="27"><table width="588" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="cuadro01">
        <td width="68">Carrera</td>
        <td><div align="left">
          <select name="cmbCARRERA" id="cmbCARRERA" class="ddlb_x" onChange="enviapag(this.form)">
            <option value=0 selected>(Seleccione Carrera)</option>
            <?
		  for($i=0 ; $i < @pg_numrows($rs_carrera) ; $i++)
		  {
		  	$fila = @pg_fetch_array($rs_carrera,$i); 
			if ($fila['id_carrera'] == $cmbCARRERA){
			   echo "<option value=".$fila['id_carrera']." selected>".$fila['nombre']."</option>";
			}else{
			    echo "<option value=".$fila['id_carrera'].">".$fila['nombre']."</option>";
		    }
		  }
		  ?>
          </select>
        </div>
              </span></td>
        <td width="213">&nbsp;</td>
        <td width="54"><div align="right">
          <input name="cb_ok" class="botonXX" type="button" value="Buscar" onClick="enviapag2(this.form)">
        </div></td>
      </tr>
      <tr class="cuadro01">
        <td>Seccion</td>
        <td><font size="1" face="arial, geneva, helvetica">
          <select name="cmbCURSO" id="cmbCURSO" class="ddlb_x">
            <option value=0 selected>Todos</option>
            <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  	$fila = @pg_fetch_array($resultado_query_cue,$i); 
			$Curso_pal = $fila['nombre'];
			if ($fila['id_curso'] == $cmbCURSO){
			   echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
			}else{
			    echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		    }
		  }
		  ?>
          </select>
  </font></td>
  <td>&nbsp;</td>
  <td>
  <input type="button" name="Grafico" class="botonXX" value="Grafico" onClick="PopWindow()" >
  </td>
  </tr>
  <tr class="cuadro01">
  <td>Final</td>
  <td><input name="chkFINAL" type="checkbox" id="chkFINAL" value="1"></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
  </table></td>
  </tr>
</table>
<br>
<div id="grafico1">&nbsp;</div>
<br>
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
                        de Administraci&oacute;n y Gestion</td>
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