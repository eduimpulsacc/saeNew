<?php
require('../../../../../util/header.inc');

$_POSP = 5;
$_bot = 9;

//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
   $curso			=$c_curso;
	
	if($curso=="") $curso=0;
   
   if($c_reporte!=""){
    
	$_SESSION['N_REPORTE']=$c_reporte;
	
	}
	
	$fecha =date("d-m-Y");	

?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">

function carga_ramo(a){
	  if(a!=0){
	    window.location='situacionfinalexamen.php?c_curso='+a;  
	  }else{ 
	    alert("Debe Seleccionar Un Curso");
	  }
   }

function enviapag2(form){
        if( form.cmb_curso.value!=0 || form.cmb_ramos.value!=0){
                form.target="_blank";
                document.form.action = 'print_situacionfinalexamen.php?xls=1';
                document.form.submit(true);
        }else{
			alert("Completar Seleccion");
						
			}
}	
   
</script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
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

<form name="formul" target="_blank" method="post"  action="print_situacionfinalexamen.php" >
<input name="c_reporte" type="hidden" value="<?=$_SESSION['N_REPORTE'];?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<table width="88%" height="43" border="0" cellpadding="0" cellspacing="0" style="margin:30px; margin-top:30px;" align="center" >
  <tr>
    <td width="" class="tableindex">Buscador Avanzado </td>
  </tr>
</table>
<!-- inicio codigo nuevo -->

<div style="padding-top:0px;margin:30px; margin-top:0px; margin-bottom:0; padding-bottom:20px;" align="center">

<?
$sql_curso=  "SELECT curso.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,
CASE WHEN curso.ensenanza = 110 THEN 'Basico' ELSE 'Medio' 
END as ensenanzaletra 
FROM curso WHERE curso.id_ano = ".$ano." AND curso.ensenanza > 109 order by 4,2 ;";
$resultado_query_cue = pg_exec($conn,$sql_curso);
        ?>
 
 <label>Cursos :  &nbsp;        
<select name="cmb_curso" id="cmd_curso" class="ddlb_x" onChange="carga_ramo(this.value);">
<option value="0">(Seleccione un Curso)</option>
<!--<option value="01">Todos los Cursos</option>-->
<?
 for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
 $fila = @pg_fetch_array($resultado_query_cue,$i);
  
 if($curso==$fila['id_curso']){   

 echo "<br/>".$x =  'selected';
 
 echo "<option value=".$fila['id_curso']."  $x >".$fila['grado_curso'] ."-".$fila['letra_curso']."=>".$fila['ensenanzaletra']."</option>";
 
  }else{
	 
 echo "<option value=".$fila['id_curso']." >".$fila['grado_curso'] ."-".$fila['letra_curso']."=>".$fila['ensenanzaletra']."</option>";
	 
	 }
 

	 } ?>
  </select></label> 
<br/><br/>
 <?
 
	if($curso){ 

		$sqlu =  "SELECT ramo.id_ramo,sub.nombre FROM curso 
		INNER JOIN ramo ON ramo.id_curso = curso.id_curso 
		INNER JOIN subsector sub ON sub.cod_subsector = ramo.cod_subsector
		WHERE curso.id_curso = $curso ";
		
		$resultado_query_cueu = pg_exec($conn,$sqlu);
		
		if($resultado_query_cueu){
		
		echo '<label>Ramos : &nbsp;';	
		echo '<select name="cmb_ramos" id="cmb_ramos" class="ddlb_x" >';
		echo '<option value="0">(Seleccione un Ramo)</option>';	
		 
		 for($iu=0 ; $iu < pg_num_rows($resultado_query_cueu) ; $iu++){
			 		 
		 $filau = @pg_fetch_array($resultado_query_cueu,$iu); 
		 
		 echo "<option value=".$filau['id_ramo']." >".$filau['nombre']."</strong></option>";
		 
		 }
				 
		echo "</select></label> ";
			 
		}
	 
	 }else{
		
		echo '<label>Ramos  : &nbsp;';	 
		echo '<select name="cmd_ramos" id="cmb_ramos" class="ddlb_x" >';
		echo '<option value="0">(Seleccione un Ramo)</option>';	
		echo "</select></label> ";
		 
	  }
 
 ?> 
</div>
 
<table width="88%" border="0" cellpadding="1" cellspacing="0" style="margin:30px; margin-top:10px;" align="center">
      <tr>
        <th width="512" scope="col"><div align="right">
          <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar">
        </div></th>
        <th width="64" scope="col"><div align="right">
          <input name="cb_exp" type="button" onClick="enviapag2(this.form)" class="botonXX"  id="cb_exp" value="Exportar">
        </div></th>
        <th width="52" scope="col"><div align="right">
          <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver"onClick="window.location='../Menu_Reportes_new2.php'">
        </div></th>
      </tr>
    </table>
 
 
</form> 

<!-- fin codigo nuevo -->
								 
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                         
                         
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
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