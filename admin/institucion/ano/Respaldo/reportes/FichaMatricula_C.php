<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');

	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$docente		= 5; //Codigo Docente
	$frmModo		=$_FRMMODO;
	$alumno			=$alumno;	
	$reporte		= $c_reporte;

	

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
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px;}
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
			function enviapag2(form){
					
					form.target="_blank";
					var curso= document.form.cmb_curso.value;
					var alumno = document.form.alumno.value;
					var opcion = document.form.op_opcion.value;
					document.form.action='printFichaMatricula_C.php?curso='+curso+'&alumno='+alumno+'&op_opcion='+opcion;
					document.form.submit(true);
			}
			function enviapag(form){
			if (document.form.cmb_curso.value!=0){		
				document.form.target='_parent';		
				document.form.action = "FichaMatricula_C.php";
				document.form.submit();
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
		function envia(){
			document.form.action="ficha_matricula.php3";
			document.form.ssww.value=1;
			document.form.submit();
		}	
		function formulario(form){
			if(document.form.op_opcion[0].checked==true || document.form.op_opcion[1].checked==true){
				document.form.action="printFichaMatricula_C.php";
				document.form.submit(true);
			}
			if(document.form.op_opcion[2].checked==true){
				document.form.action="printFichaMatriculaBasica_C.php";
				document.form.submit(true);								
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
								  <!-- FIN CODIGO DE BOTONES -->
								 
								  <!-- INICIO FORMULARIO DE BUSQUEDA -->
<form name="form" method "post" action="" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<? 


$ob_motor = new MotorBusqueda();
$ob_motor ->ano = $ano;
$resultado_query_cue=$ob_motor ->curso($conn);
//------------------
?>
<center>
<table width="709" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701" class="cuadro02">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27" class="cuadro01">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78" class="cuadro01">Curso</td>
    <td width="263" class="cuadro01">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
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
</font>	  </div></td>
    <td width="61" class="cuadro01">Alumno</td>
    <td width="219" class="cuadro01"><select name="alumno" class="ddlb_9_x">
      <option value=0 selected>(Todos los Alumnos)</option>
      <?
		
		$ob_motor ->cmb_curso =$cmb_curso;
		$result = $ob_motor ->alumno($conn);
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);?>
      <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
	 	<?
		}
		?>
    </select></td>
    <td width="80" class="cuadro01">
      <div align="center">
        <input name="cb_ok" type="button" class="botonXX" id="cb_ok"  value="  Buscar "  onClick="formulario(this.form)">
        </div></td>
  </tr>
  <tr>
    <td class="cuadro01">Ficha en Blanco </td>
    <td class="cuadro01"><input type="button" name="Submit" value="OP.1"  class="botonXX" onClick="MM_openBrWindow('ficha_matricula2.html','FICHA1','scrollbars=yes,resizable=yes,width=750,height=800')" > <input type="button" name="Submit2" value="OP.2"  class="botonXX" onClick="MM_openBrWindow('ficha_matricula3.html','FICHA','scrollbars=yes,resizable=yes,width=750,height=800')">
      <input name="Submit3" type="button"   class="botonXX" onClick="MM_openBrWindow('ficha_matricula_basico.php','','status=yes,scrollbars=yes,resizable=yes,width=%,height=%')" value="OP.3"></td>
    <td class="cuadro01">Opci&oacute;n</td>
    <td class="cuadro01">
	  1
      <input name="op_opcion" type="radio" value="1" checked>
      2
      <input name="op_opcion" type="radio" value="2">
      3 
	  <input name="op_opcion" type="radio" value="3">	</td>
    <td class="cuadro01" align="right">
	  <div align="center">
	    <? if($_PERFIL==0){?>
	    <input name="cb_exp" type="button" class="botonXX" id="cb_exp" onClick="enviapag2(this.form)"  value="Exportar">
	    </div></td>
    <? }?>
	<td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01" align="right">
      <div align="center">
        <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2"  value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
        </div></td>
    <td class="cuadro01">&nbsp;</td>
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