<?php
require('../../../../util/header.inc');


	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$reporte		= $c_reporte;
	$docente		= 5; //Codigo Docente
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
function cambia_valor(){
	if(form1.ck_1.checked==false && form1.ck_2.checked==false && form1.ck_3.checked==false && form1.ck_4.checked==false
		&& form1.ck_5.checked==false && form1.ck_6.checked==false && form1.ck_7.checked==false && form1.r_puntaje[0].checked==true){
			alert("Debe Seleccionar Algún subsector.");
			return false;
	}
	
		var marcado = "no";
	with(document.form1){
		for(var i=0;i<r_ordena.length;i++) {
			if(r_ordena[i].checked){
				if(r_ordena[i].value==2){
					if(cmb_tipo_ensenanza.value==0){
						alert("Debe Seleccionar Tipo de Enseñanza.");
						return false;
					}
					
				}
				
				if(r_ordena[i].value==1){
					if(cmb_curso.value==0){
						alert("Debe Seleccionar Curso.");
						return false;
					}
					
				}

			}
		}
	}


	document.form1.valor.value=2;
	form1.submit(true);
}
function defecto(){
	with(document.form1){
		r_ordena[1].checked=true;
		r_puntaje[0].checked=true;
	}

}
function validar(form1){
	if(form1.ck_1.checked==false && form1.ck_2.checked==false && form1.ck_3.checked==false && form1.ck_4.checked==false
		&& form1.ck_5.checked==false && form1.ck_6.checked==false && form1.ck_7.checked==false && form1.r_puntaje[0].checked==true){
			alert("Debe Seleccionar Algún subsector.");
			return false;
	}
	
	var marcado = "no";
	with(document.form1){
		for(var i=0;i<r_ordena.length;i++) {
			if(r_ordena[i].checked){
				if(r_ordena[i].value==2){
					if(cmb_tipo_ensenanza.value==0){
						alert("Debe Seleccionar Tipo de Enseñanza.");
						return false;
					}
					
				}
				
				if(r_ordena[i].value==1){
					if(cmb_curso.value==0){
						alert("Debe Seleccionar Curso.");
						return false;
					}
					
				}
				
				
			valor.value=1;
			form1.submit(true);
			return true;
			
			
			}
		}
	}
}

function deshabilita_cmb(){
	document.form1.cmb_curso.disabled=false;
	document.form1.cmb_tipo_ensenanza.disabled=true;
	document.form1.cmb_tipo_ensenanza.value=0;
}
function habilita_cmb(){
	document.form1.cmb_tipo_ensenanza.disabled=false;
	document.form1.cmb_curso.disabled=true;
	document.form1.cmb_curso.value=0;
}

function deshabilita_ck(){
	document.form1.ck_1.disabled=true;
	document.form1.ck_2.disabled=true;
	document.form1.ck_3.disabled=true;
	document.form1.ck_4.disabled=true;
	document.form1.ck_5.disabled=true;
	document.form1.ck_6.disabled=true;
	document.form1.ck_7.disabled=true;
	document.form1.ck_1.checked=false;
	document.form1.ck_2.checked=false;
	document.form1.ck_3.checked=false;
	document.form1.ck_4.checked=false;
	document.form1.ck_5.checked=false;
	document.form1.ck_6.checked=false;
	document.form1.ck_7.checked=false;

}

function habilita_ck(){
	document.form1.ck_1.disabled=false;
	document.form1.ck_2.disabled=false;
	document.form1.ck_3.disabled=false;
	document.form1.ck_4.disabled=false;
	document.form1.ck_5.disabled=false;
	document.form1.ck_6.disabled=false;
	document.form1.ck_7.disabled=false;
}


function enviapag(form1){
	form1.submit(true);
}
function enviapag1(form1){
	tipo_ensenanza = document.form1.cmb_tipo_ensenanza.value;
	curso = document.form1.cmb_curso.value;
	window.location='Informe_psu.php?cmb_tipo_ensenanza='+tipo_ensenanza+'&cmb_curso='+curso;
}

			function enviapag2(form){
					form.target="_blank";
					var curso= document.form.cmb_curso.value;
					var opcion = document.form.orden.value;
					document.form.action='printRegistroMatriculaCurso_C.php?curso='+curso+'&orden='+opcion;
					document.form.submit(true);
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')
<? if($cmb_tipo_ensenanza==0 && $cmb_curso==0){?>
;deshabilita_cmb()
<? }?>
;defecto()">

 
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><? include("../../../../cabecera/menu_superior.php");?>
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><table width="100%"><tr><td><table width="100%"><tr><td>&nbsp;</td>
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
  <td>

<table width="709" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<form name="form1" method="post" action="print_Informe_psu.php" target="_blank">
	<input type="hidden" name="valor" id="valor">
	<table width="100%" border="0">
  <tr>
    <td colspan="5" class="tableindex">GENERADOR INFORME PSU </td>
  </tr>
  <tr>
    <td class="cuadro01">A&ntilde;o</td>
    <td class="cuadro01"><?  $sql = "SELECT * FROM ano_escolar WHERE id_institucion =".$institucion." ORDER BY nro_ano ASC";
		$resp = pg_exec($conn,$sql);
		$num = pg_numrows($resp);
		
		?>
      <select name="cmb_ano" id="cmb_ano" class="ddlb_x">
        <? for($i=0;$i<$num;$i++){
			$fila_ano = pg_fetch_array($resp,$i); ?>
        <option value="<?=$fila_ano['id_ano']?>" selected>
          <?=$fila_ano['nro_ano']?>
          </option>
        <? }?>
      </select></td>
    <td width="46%" class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="cuadro02">Subsectores</td>
  </tr>
  <tr>
    <td colspan="2" class="cuadro01"><input type="checkbox" name="ck_1" value="1">
HISTORIA Y CS.  SOC. <br />
<input type="checkbox" name="ck_2" value="1">
MATEMATICA <br />
<input type="checkbox" name="ck_6" value="1">
LENG. CASTELLANA Y COMUNIC. </td>
    <td class="cuadro01"><input type="checkbox" name="ck_7" value="1">
      CIENCIAS <br />
      <input type="checkbox" name="ck_3" value="1">
      BIOLOGIA <br />
      <input type="checkbox" name="ck_4" value="1">
      QUIMICA <br />
      <input type="checkbox" name="ck_5" value="1">
    FISICA </td>
  </tr>
  
  <tr>
    <td colspan="5" class="cuadro02">Ordenar por : </td>
  </tr>
  <tr>
    <td width="27%" class="cuadro01"><div align="center">Curso&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="r_ordena" type="radio" value="2" onClick="javascript:habilita_cmb()" />
    </div></td>
    <td width="27%" class="cuadro01">
	  <? 	$sql="SELECT * FROM tipo_ensenanza WHERE cod_tipo IN (SELECT cod_tipo FROM tipo_ense_inst WHERE ";
			$sql.="rdb = $institucion) AND nombre_tipo LIKE '%MEDIA%' ORDER BY cod_tipo DESC";
			$rs_ense = @pg_exec($conn,$sql);?>
              <select name="cmb_tipo_ensenanza" id="cmb_tipo_ensenanza" class="ddlb_9_x">
			        <option value="0" selected>(Seleccione tipo enseñanza)</option>
			        <? 	
							 //llenar combo 
							  //$ob_ense = new Reporte();
							  //$ob_ense->institucion=$institucion;							  
							  //$resultado_cmb=$ob_ense->Ensenanza($conn);				  		  	 
										  for($i=0;$i<pg_numrows($rs_ense);$i++){
												$llenar_combo=pg_fetch_array($rs_ense,$i);
										  if($llenar_combo['cod_tipo']==$cmb_tipo_ensenanza){
						?>
			        <option value="<?=$llenar_combo['cod_tipo'];?>" selected="selected">
			          <?=$llenar_combo['nombre_tipo'];?>
			          </option>
			        <? }else{ ?>
			        <option value="<?=$llenar_combo['cod_tipo'];?>">
			          <?=$llenar_combo['nombre_tipo'];?>
			          </option>
			        <? }
								} ?>
			        </select>    </td>
    <td colspan="3" class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01"><div align="center">Alumnos
      <input name="r_ordena" type="radio" value="1" onClick="javascript:deshabilita_cmb()" /></div></td>
    <td class="cuadro01">                 
	<? 
					// AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //
	
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.") AND curso.grado_curso=4 AND tipo_ensenanza.nombre_tipo LIKE '%MEDIA%') $whe_perfil_curso";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		        
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal." </option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal." </option>";
                }
		     } ?>
          </select> 	</td>
    <td colspan="3" class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="cuadro02">Evaluaci&oacute;n : </td>
  </tr>
  <tr>
    <td colspan="2" class="cuadro01"><div align="center">Puntaje
        <input name="r_puntaje" type="radio" value="1" onClick="javascript:habilita_ck()">
    </div></td>
    <td class="cuadro01"><div align="center">Puntaje/Promedio
        <input name="r_puntaje" type="radio" value="2" onClick="javascript:deshabilita_ck()">
    </div></td>
  </tr>
  <tr>
    <td class="cuadro01"></td>
    <td class="cuadro01"><div align="center">
      <input type="button" name="cb_ok" class="botonXX" onClick="javascript:validar(this.form)" value="Buscar">
    </div></td>
    <td class="cuadro01"><input type="button" name="cb_ok2" class="botonXX" onClick="javascript:cambia_valor();" value="Exportar">
      <input name="cb_ok22" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'"></td>
  </tr>
</table>
</form>


	</td>
  </tr>
</table>

								 
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
