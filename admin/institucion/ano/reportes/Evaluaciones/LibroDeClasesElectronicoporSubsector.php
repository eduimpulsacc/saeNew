<?
require('../../../../../util/header.inc'); 

	//setlocale("LC_ALL","es_ES");
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$alumno 		= $c_alumno;
	$reporte		= $c_reporte;
	$frmModo		= $_FRMMODO;
	$_POSP = 4;
	$_bot = 8;
	
	
	if ($dia == ""){
	   ## si el campo esta vac�o poner la fecha actual
	   $dia   = strftime("%d",time());
	   $mes   = strftime("%m",time());
	   $mes   = envia_mes($mes);	   
	   $ano2  = strftime("%Y",time());
	   $mes2  = date("F"); 
	}
	 $mes2  = date("F"); 
	 
	 
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
	
	/// consulta que trae a los alumnos
	 $sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
	$query_curso = @pg_exec($conn,$sql_curso); 	
	
	for ($i=0; $i < @pg_numrows($query_curso); $i++){
	    $fila_curso = pg_fetch_array($query_curso,$i);
		$id_curso_[] = $fila_curso['id_curso'];
		$grado_curso_[] = $fila_curso['grado_curso'];
		$letra_curso_[] = $fila_curso['letra_curso'];
		$nombre_tipo_curso_[] = $fila_curso['nombre_tipo'];   
	
	}
	
	
	//-----------------------------------------
	// Cantidad de Subsectores
	//-----------------------------------------
	$sql_sub = "select count(*) as cantidad from ramo where id_curso = ".$cmbCURSO." ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	$fila_sub = @pg_fetch_array($result_sub,0);	
	$num_subsectores = $fila_sub['cantidad'];
	//-----------------------------------------
	// Subsectores
	//-----------------------------------------
	$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.conex, ramo.sub_obli, ramo.cod_subsector ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$cmbCURSO."))  ORDER BY ramo.id_orden; ";
	$result_sub =@pg_Exec($conn,$sql_sub );
	//-----------------------------------------		
	for ($i=0; $i < @pg_numrows($result_sub); $i++){
			$fila_sub = pg_fetch_array($result_sub,$i);        
			$id_ramo_[]          = $fila_sub['id_ramo'];
			$subsector_nombre_[] = $fila_sub['nombre'];
			$cod_subsector_[]    = $fila_sub['cod_subsector'];
	}		
			

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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

function valida(form){
	
with (form){

	if (form.cmb_ano.value=="0"){		
		alert('DEBE SELECCIONAR UN A�O');
		form.cmb_ano.focus();	
		return false;
		};
		
	if (form.cmbPERIODO.value=="0"){		
		alert('DEBE SELECCIONAR UN PERIODO');
		form.cmbPERIODO.focus();	
		return false;
		};	
		
	if (form.cmbCURSO.value=="0"){		
		alert('DEBE SELECCIONAR UN CURSO');
		form.cmbCURSO.focus();	
		return false;
		};	
		
	if (form.cmbSUBSECTOR.value=="0"){		
		alert('DEBE SELECCIONAR UN SUBSECTOR');
		form.cmbSUBSECTOR.focus();
		return false;
		};
			

	  form.target="_blank";
	  form.action = 'printLibroDeClasesElectronicoporSubsector.php';
	  form.submit(true);
	}		
 }
 
 
 function enviapag2(form){
	var ano, frmModo; 
	ano2=form.cmb_ano.value;
		
	if (form.cmb_ano.value!="0"){		
		pag="../../seteaAno.php3?caso=10&pa=25&ano="+ano2
		form.action = pag;
		form.target="_self";
		form.submit(true);	
	}		
 }



//-->
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
.Estilo9 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
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
						$menu_lateral=3;
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
                                  <td>
								  <br>
								  
					

<!-- INICIO FORMULARIO DE BUSQUEDA -->
<form name="form"   action="printLibroDeClasesElectronicoporSubsector.php" method="post">
<table align="center" width="90%" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27"><table width="100%" border="0" cellspacing="5">
      <tr>
        <td width="20%"><span class="Estilo9">A&ntilde;o escolar </span></td>
        <td width="50%">
           <?php				
											
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
                           <option value="0" selected>Seleccione un A�o</option> <?
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
					
				<? }	?>        </td>
        <td width="50%" align="center"><label>
          <input type="button" name="Submit" value="Buscar" class="BotonXX" onClick="valida(this.form);">
        </label></td>
      </tr>
      <tr>
        <td><span class="Estilo9">Per&iacute;odo</span></td>
        <td>
		  
          <select name="cmbPERIODO"  class="ddlb_x">
				 <option value="0">Seleccione Per�odo</option>
				<?php
					$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano."))  order by id_periodo";
					$result =@pg_Exec($conn,$qry);
					if (!$result) 
						error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
					else{
						if (pg_numrows($result)!=0){
							$fila1 = @pg_fetch_array($result,0);	
							if (!$fila1){
								error('<B> ERROR :</b>Error al acceder a la BD. (84)</B>');
								exit();
							};
							for($i=0 ; $i < @pg_numrows($result) ; $i++){
								$fila1 = @pg_fetch_array($result,$i);
								if($fila1['id_periodo']==$cmbPERIODO){
									echo  "<option value=".$fila1["id_periodo"]." selected>".$fila1["nombre_periodo"]."</option>";
								}else{
									echo  "<option value=".$fila1["id_periodo"].">".$fila1["nombre_periodo"]."</option>";
								}
							}
						}
					};
				?>
			</Select>        </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><span class="Estilo9">Curso</span></td>
        <td>
		
		<select name="cmbCURSO" class="ddlb_x" onChange="window.location='LibroDeClasesElectronicoporSubsector.php?cmbPERIODO='+cmbPERIODO.value+'&cmbCURSO='+this.value;" >
		    <option value="0">Seleccione Curso </option>
		    <?
		    for ($i=0; $i < @pg_numrows($query_curso); $i++){
		        /// listado de Cursos;
			    ?>
			    <option value="<?=$id_curso_[$i]?>" <? if ($cmbCURSO==$id_curso_[$i]){ ?> selected="selected" <? } ?>><?=$grado_curso_[$i]?>-<?=$letra_curso_[$i]?> <?=$nombre_tipo_curso_[$i]?></option>
			    <? 	
		    }
            ?>		  
        </select>        </td>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td><span class="Estilo9">Subsector</span></td>
        <td>
		
		<select name="cmbSUBSECTOR" class="ddlb_x" id="cmbSUBSECTOR">
			<option value=0 selected>Seleccione un subsector</option>
			   <?
			   for ($i=0; $i < @pg_numrows($result_sub); $i++){
					?>
					<option value="<? echo $cod_subsector_[$i]; ?>"><?=$subsector_nombre_[$i];?></option>
                    <?
			   }
			   ?>
        </select>		 </td>
        <td>&nbsp;</td>
      </tr>
	  <tr>
	    <td class="Estilo9">Promedio</td>
	    <td class="Estilo9"><input name="ckPROMEDIO" type="radio" value="0" checked>
	      Aritmetico 
	        <input name="ckPROMEDIO" type="radio" value="1">
	        Apreciacion</td>
	    <td>&nbsp;</td>
	    </tr>
      
      
    </table></td>
  </tr>
</table>
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
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>