<?php
require('../../../../util/header.inc');


	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$reporte		= $c_reporte;
	$docente		= 5; //Codigo Docente


// cursos de la institucion
	$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
    $sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
    $sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
    $sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
    $query_curso = @pg_exec($conn,$sql_curso); 	
	
	for ($i=0; $i < @pg_numrows($query_curso); $i++){
	    $fila_curso = pg_fetch_array($query_curso,$i);
		$id_curso_[] = $fila_curso['id_curso'];
		$grado_curso_[] = $fila_curso['grado_curso'];
		$letra_curso_[] = $fila_curso['letra_curso'];
		$nombre_tipo_curso_[] = $fila_curso['nombre_tipo'];   
	
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
function onload(){
	document.form1.r_ordena.checked=true;
	
}
function valida(form1){
	if(document.form1.r_ordena1.checked==true){
		if(document.form1.cmb_curso.value==0){
			alert("Debe Seleccionar Curso.");
			return false;
		}
	}
	form1.submit(true);

}

function deshabilita_cmb(){

	document.form1.cmb_curso.disabled=true;
	document.form1.cmb_curso.value=0;
	document.form1.cmb_alumno.disabled=true;
	document.form1.cmb_alumno.value=0;
	document.form1.cmbCICLO.disabled=true;
	document.form1.cmbCICLO.value=0;
	document.form1.cmbNIVEL.disabled=true;
	document.form1.cmbNIVEL.value=0
	document.form1.cmb_beca.disabled=false;
	document.form1.r_ordena1.checked=false;
	document.form1.r_ordena2.checked=false;
	document.form1.r_ordena3.checked=false;
}
function habilita_cmb(){
	document.form1.cmb_curso.disabled=false;
	document.form1.cmb_alumno.disabled=false;
	document.form1.cmbCICLO.disabled=true;
	document.form1.cmbCICLO.value=0;
	document.form1.cmb_beca.disabled=true;
	document.form1.cmb_beca.value=0;
	document.form1.cmbNIVEL.disabled=true;
	document.form1.cmbNIVEL.value=0
	document.form1.r_ordena.checked=false;
	document.form1.r_ordena2.checked=false;
	document.form1.r_ordena3.checked=false;
}

function habilita_cmb1(){
	
	document.form1.cmb_curso.disabled=true;
	document.form1.cmb_curso.value=0;
	document.form1.cmb_alumno.disabled=true;
	document.form1.cmb_alumno.value=0;
	document.form1.cmbCICLO.disabled=false;
	document.form1.cmb_beca.disabled=true;
	document.form1.cmb_beca.value=0;
	document.form1.cmbNIVEL.disabled=true;
	document.form1.cmbNIVEL.value=0;
	document.form1.r_ordena1.checked=false;
	document.form1.r_ordena.checked=false;
	document.form1.r_ordena3.checked=false;
}


function deshabilita_cmb1(){
	
	document.form1.cmb_curso.disabled=true;
	document.form1.cmb_curso.value=0;
	document.form1.cmb_alumno.disabled=true;
	document.form1.cmb_alumno.value=0;
	document.form1.cmbCICLO.disabled=true;
	document.form1.cmbCICLO.value=0;
	document.form1.cmb_beca.disabled=true;
	document.form1.cmb_beca.value=0;
	document.form1.cmbNIVEL.disabled=false;
	document.form1.r_ordena1.checked=false;
	document.form1.r_ordena.checked=false;
	document.form1.r_ordena2.checked=false;
}

function enviapag(form1){
	var r_ordena = document.form1.r_ordena1.value;
	var curso = document.form1.cmb_curso.value;
	var ano = document.form1.cmb_ano.value;
	window.location='motor_informe_becas_beneficio.php?cmb_ano='+ano+'&cmb_curso='+curso+'&r_ordena='+r_ordena;
}
function enviapag2(form){ 
	var ano, frmModo; 
	ano2=form.cmb_ano.value;
		
	if (form.cmb_ano.value!="0"){	
		pag="../seteaAno.php3?caso=10&pa=37&ano="+ano2
		//ssssssspag="motor_informe_becas_beneficio.php?ano2="+ano2 
		form.action = pag; 
		form.target="_self";
		form.submit(true);		
	}		
 }
 
/*function enviapag1(form1){
	tipo_ensenanza = document.form1.cmb_tipo_ensenanza.value;
	curso = document.form1.cmb_curso.value;
	window.location='Informe_psu.php?cmb_tipo_ensenanza='+tipo_ensenanza+'&cmb_curso='+curso;
}*/
/*
			function enviapag2(form){
					form.target="_blank";
					var curso= document.form.cmb_curso.value;
					var opcion = document.form.orden.value;
					document.form.action='printRegistroMatriculaCurso_C.php?curso='+curso+'&orden='+opcion;
					document.form.submit(true);
			}*/
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
<? if($cmb_curso==0){?>
;deshabilita_cmb();onload();
<? }else{?>
;habilita_cmb();
<? }?>
">

 
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> <? include("../../../../cabecera/menu_superior.php");?>
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top">
				<table width="100%">
			  	<tr align="left" valign="top"> 
                	<td height="83">
						<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    	<tr> 
                      	<td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>
						
					  	</td>
                      <td width="73%" align="left" valign="top">
					  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
							
<table width="90%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
<tr> 
  <td valign="top">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" align="center">
	<form name="form1" method="post" action="print_informe_becas_beneficio.php" target="_blank">
    <input name="nombre" type="hidden" value="<?=$nombre;?>">
    <input name="numero" type="hidden" value="<?=$numero;?>">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td colspan="2" class="cuadro01"><div align="center">A&ntilde;o</div></td>
    <td class="cuadro01"> <?php				
											
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." $whe_perfil_ano ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} ?>
					
		    	   
						<select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                           <option value="0" selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
							  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
							</select>
					
				<? }	?>     </td>
    <td width="46%" class="cuadro01">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="6" class="cuadro02">Ordenar por : </td>
  </tr>
  <tr>
    <td width="13%" class="cuadro01"><div align="center">Curso
	</div></td>
    <td width="14%" class="cuadro01"><? if($r_ordena==2){?>
        <input name="r_ordena1" type="radio" class="cuadro01" value="2" checked="checked" onClick="javascript:habilita_cmb()" />
    <? }else{?>
	    <input name="r_ordena1" class="cuadro01" type="radio" value="2" onClick="javascript:habilita_cmb()" />
    <? }?></td>
    <td width="27%" class="cuadro01">
	<font face="arial, geneva, helvetica" size=2> <strong> 
			   <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);" >
		  <option value="0">Seleccione Curso </option>
		  <?
		  for ($i=0; $i < @pg_numrows($query_curso); $i++){
		       /// listado de Cursos;
			   
			   if (($id_curso_[$i] == $cmb_curso) or ($id_curso_[$i] == $curso)){?>
		            <option selected="selected"  value="<?=$id_curso_[$i]?>"><?=$grado_curso_[$i]?>-<?=$letra_curso_[$i]?> <?=$nombre_tipo_curso_[$i]?></option>
		        <? }else{?>	    
		           <option value="<?=$id_curso_[$i]?>"><?=$grado_curso_[$i]?>-<?=$letra_curso_[$i]?> <?=$nombre_tipo_curso_[$i]?></option>
                <? }	
		  }
          ?>		  
          </select> 
	             </strong></font></strong> </font>	</td>
    <td colspan="3" class="cuadro01"><div align="left">
	    
	    <select name="cmb_alumno" class="ddlb_9_x">
	     <option value=0 selected>(Todos los alumnos)</option>
	      <?
		$sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
		$result= @pg_Exec($conn,$sql);
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);?>
	      <?
			if ($fila["rut_alumno"] == $cmb_alumno){
			   ?>
	      <option value="<? echo $fila["rut_alumno"]; ?>" selected><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
	      <?
			}else{
			   ?>
	      <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>   	
	      <?
		    }		
			
		}
		?>
	      </select>
	      </div>	</td>
  </tr>
  <tr>
    <td class="cuadro01"><div align="center">Beca<br />
	</div></td>
    <td class="cuadro01"><? if($r_ordena==1){?>
		<input name="r_ordena" type="radio" value="1" class="cuadro01" checked="checked" onClick="javascript:deshabilita_cmb()" />
	<? }else{?>
        <input name="r_ordena" type="radio" value="1" class="cuadro01" onClick="javascript:deshabilita_cmb()" /></td>
    <? }?>
	<td class="cuadro01">
	<?		$sql="SELECT * FROM becas_conf WHERE id_ano=".$_ANO;
			$resp_cmb = pg_exec($conn,$sql);
			$num_becas = pg_numrows($resp_cmb);
	  ?>
	  	<select name="cmb_beca" class="ddlb_x">
		  <option value="0" selected>(Todas las becas)</option>
		  <?  for($i=0;$i<$num_becas;$i++){
				$fila_cmb = @pg_fetch_array($resp_cmb,$i); 
					if ($fila_cmb['id_beca'] == $cmb_beca){?>
						<option value="<?=$fila_cmb['id_beca']?>" selected><?=$fila_cmb['nomb_beca']?></option>
					<? }else{?>
						<option value="<?=$fila_cmb['id_beca']?>"><?=$fila_cmb['nomb_beca']?></option>
				<?	}
			}?>
       	</select></td>
    <td colspan="3" class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01"><div align="center">Ciclo</div> </td>
    <td class="cuadro01"><? if($r_ordena==3){?>
        <input name="r_ordena2" type="radio" class="cuadro01" value="3" checked="checked" onClick="javascript:habilita_cmb1()" />
    <? }else{?>
	    <input name="r_ordena2" class="cuadro01" type="radio" value="3" onClick="javascript:habilita_cmb1()" />
    <? }?></td>
    <td class="cuadro01">  <select name="cmbCICLO" class="ddlb_x" >
		  <option value="0">Seleccione Ciclo </option>
		  <?
		  /// listado de subsectores del curso
		  $qry3 = "select ciclo_conf.id_ciclo, ciclo_conf.nomb_ciclo from ciclo_conf where rdb = '$institucion' and id_ano = '$ano' ";	
		  $result3 =@pg_Exec($conn,$qry3);
		  $num3    =@pg_numrows($result3);
		
		  for ($i=0; $i < $num3; $i++){
			  $fila13 = @pg_fetch_array($result3,$i);	
			  $id_ciclo_[]          = $fila13['id_ciclo'];
			  $nombre_ciclo_[]      = $fila13['nomb_ciclo'];
			  ?>
			  <option value="<?=$id_ciclo_[$i]; ?>"><?=$nombre_ciclo_[$i]?></option>
			  <? 	
		  }
          ?>		  
          </select> </td>
    <td colspan="3" class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01"><div align="center">Niveles</div></td>
    <td class="cuadro01">
	<? if($r_ordena==4){?>
   <input name="r_ordena3" type="radio" class="cuadro01" value="4" checked="checked" onClick="javascript:deshabilita_cmb1()" />
    <? }else{?>
	<input name="r_ordena3" class="cuadro01" type="radio" value="4" onClick="javascript:deshabilita_cmb1()" />
    <? }?>
	</td>
    <td class="cuadro01"><select name="cmbNIVEL" class="ddlb_x" >
		  <option value="0">Seleccione Nivel </option>
		  <?
		  // tomar los niveles asociados
			$qry7 = "select id_nivel, nombre from niveles order by id_nivel";
			$result7 =@pg_Exec($conn,$qry7);
			for ($i=0; $i < @pg_numrows($result7); $i++){
				 $fila7 = @pg_fetch_array($result7,$i);	
				 $nombre_nivel_[]  = $fila7['nombre'];
				 $id_nivel_[]      = $fila7['id_nivel'];
				 ?>
			       <option value="<?=$id_nivel_[$i]; ?>"><?=$nombre_nivel_[$i]?></option>
			     <? 
			}		  
          
		  ?>		  
          </select></td>
    <td colspan="3" class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td colspan="3" class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="cuadro01"></td>
    <td class="cuadro01"><div align="center">
      <input type="button" name="cb_ok" class="botonXX" onClick="javascript:valida(this.form)" value="Buscar">
    </div></td>
    <td class="cuadro01"><input type="submit" name="cb_ok2" class="botonXX" value="Exportar">
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
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
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
