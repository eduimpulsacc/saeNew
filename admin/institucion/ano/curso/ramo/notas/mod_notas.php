<?php require('../../../../../../util/header.inc');?>
<?php 

if ($id_ramo != NULL or $id_ramo != 0){
	$_RAMO=$id_ramo;
	session_register('_RAMO');
}

$institucion	=$_INSTIT;
$ano			=$_ANO;
$curso			=$_CURSO;
$ramo			=$_RAMO;

$docente		=5; //Codigo Docente
$_POSP          =6;
$_bot           =5;
$periodo = 1137;

//////// nuevo código


// Nombre del subsector seleccionado
$qry = "select cod_subsector from ramo where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$ano')) and id_ramo = '$ramo'";
$result =@pg_Exec($conn,$qry);
if (pg_numrows($result)!=0){
    $fila10 = @pg_fetch_array($result,0);	
	$cod_subsector =  $fila10['cod_subsector'];
	
	/// busco el nombre del subsector
	$qry2 = "select nombre from subsector where cod_subsector = '$cod_subsector'";
    $result2 =@pg_Exec($conn,$qry2);
    if (pg_numrows($result2)!=0){
        $fila11 = @pg_fetch_array($result2,0);	
	    $nombre_subsector =  $fila11['nombre'];
	}
}		

/// listado de subsectores del curso
$qry3 = "select ramo.cod_subsector, subsector.nombre, ramo.id_ramo from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_curso in (select id_curso from curso where id_ano = '$ano') and id_curso = '$curso')) ";	
$result3 =@pg_Exec($conn,$qry3);
$num3    =@pg_numrows($result3);

for ($i=0; $i < $num3; $i++){
    $fila13 = @pg_fetch_array($result3,$i);	
    $cod_subsector_[]          = $fila13['cod_subsector'];
	$nombre_subsector_[]       = substr($fila13['nombre'],0,15); 
	$nombre_subsector_titulo[] = substr($fila13['nombre'],0,60);
	$id_ramo_[]                = $fila13['id_ramo']; 

}

/// Para tomar el listado de alumnos del curso y los que tienene dicho ramo
$qry4="select alumno.rut_alumno, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat from alumno  where rut_alumno in (select matricula.rut_alumno from matricula where id_curso='$curso') order by ape_pat, ape_mat, nombre_alu ";
$result4 =@pg_Exec($conn,$qry4);
$num4    =@pg_numrows($result4);

for ($i=0; $i < $num4; $i++){
    $fila14 = @pg_fetch_array($result4,$i);	
    $rut_alumno_[]        = $fila14['rut_alumno'];
	$alumno_ape_pat_[]    = $fila14['ape_pat'];
	$alumno_ape_mat_[]    = $fila14['ape_mat'];
	$alumno_nombres_[]    = $fila14['nombre_alu'];
	
}	
/// tengo el listado del curso completo

/// sacar lista de alumnos que tiene cada subsector
/// tomamos el año actual

$qry5="SELECT nro_ano FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
$result5 =@pg_Exec($conn,$qry5);

if (pg_numrows($result5)!=0){
	$fila15 = @pg_fetch_array($result5,0);	
	$nro_ano = trim($fila15['nro_ano']);
}

$i_aux=0;
for ($i=0; $i < $num4; $i++){  // cilco que tiene todos los rut de alumnos

    for ($j=0; $j < $num3; $j++){  // ciclo que tiene todos los ramos
          $qry6 = "select rut_alumno from tiene$nro_ano where id_ramo = '$id_ramo_[$j]' and rut_alumno = '$rut_alumno_[$i]'";
	      $result6 =@pg_Exec($conn,$qry6);
	      if (@pg_numrows($result6)!=0){
		       // asigno subsector y rut de alumno a areglos
			   
		       $subsector_alumno_id_ramo[]           = $id_ramo_[$j];
			   $subsector_alumno_id_rut_alumno[]     = $rut_alumno_[$i];
			   $subsector_alumno_id_nombre_alumno[]  = $alumno_nombres_[$i];
			   $subsector_alumno_id_ape_pat_alumno[] = $alumno_ape_pat_[$i];
			   $subsector_alumno_id_ape_mat_alumno[] = $alumno_ape_mat_[$i];
			   
			  
			   $i_aux++;
		  }
	}

}		  	   

/// cargamos las notas del periodo - curso
$qry7 = "select * from notas$nro_ano where id_periodo = '$periodo'";
$result7 =@pg_Exec($conn,$qry7);
$num7    =@pg_numrows($result7);
for ($i=0; $i < $num7; $i++){
     $fila17 = pg_fetch_array($result7,$i);
     $notas_rut_alumno_[] = $fila17['rut_alumno'];
	 $notas_id_ramo_[]    = $fila17['id_ramo'];
	 $notas_id_periodo_[] = $fila17['id_periodo'];
	 $notas_nota1_[]      = $fila17['nota1'];
	 $notas_nota2_[]      = $fila17['nota2'];
	 $notas_nota3_[]      = $fila17['nota3'];
	 $notas_nota4_[]      = $fila17['nota4'];
	 $notas_nota5_[]      = $fila17['nota5'];
	 $notas_nota6_[]      = $fila17['nota6'];
	 $notas_nota7_[]      = $fila17['nota7'];
	 $notas_nota8_[]      = $fila17['nota8'];
	 $notas_nota9_[]      = $fila17['nota9'];
	 $notas_nota10_[]     = $fila17['nota10'];
	 $notas_nota11_[]     = $fila17['nota11'];
	 $notas_nota12_[]     = $fila17['nota12'];
	 $notas_nota13_[]     = $fila17['nota13'];
	 $notas_nota14_[]     = $fila17['nota14'];
	 $notas_nota15_[]     = $fila17['nota15'];
	 $notas_nota16_[]     = $fila17['nota16'];
	 $notas_nota17_[]     = $fila17['nota17'];
	 $notas_nota18_[]     = $fila17['nota18'];
	 $notas_nota19_[]     = $fila17['nota19'];
	 $notas_nota20_[]     = $fila17['nota20'];
	 $notas_promedio_[]   = $fila17['promedio'];


}


/// Creamos la lista de alumnos con sus campoos según que ramo realizan

for ($j=0; $j < $num3; $j++){
    	
	for ($i=0; $i < $i_aux; $i++){
	    		
		if ($subsector_alumno_id_ramo[$i]==$id_ramo_[$j]){	
		
		       	        
			    			
				$tabla_[$j] .= '<table width="100%" border="1" cellpadding="0" cellspacing="0"><tr><td width="180" class="textolink">&nbsp;'.$subsector_alumno_id_ape_pat_alumno[$i].' '.$subsector_alumno_id_ape_mat_alumno[$i].' '.$subsector_alumno_id_ape_mat_alumno[$i].'</td>'; for ($k=0; $k < $num7; $k++){ if ($notas_rut_alumno_[$k]==$subsector_alumno_id_rut_alumno[$i]  and $notas_id_ramo_[$k]==$id_ramo_[$j] and $notas_id_periodo_[$k]=='1137'){  $tabla_[$j] .= '<td width="1"><div align="center"><input name="textfield32" type="text" size="2" maxlength="2" value="'.$notas_nota1_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield33" type="text" size="2" maxlength="2" value="'.$notas_nota2_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield34" type="text" size="2" maxlength="2" value="'.$notas_nota3_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield35" type="text" size="2" maxlength="2" value="'.$notas_nota4_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield36" type="text" size="2" maxlength="2" value="'.$notas_nota5_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield37" type="text" size="2" maxlength="2" value="'.$notas_nota6_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield38" type="text" size="2" maxlength="2" value="'.$notas_nota7_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield39" type="text" size="2" maxlength="2" value="'.$notas_nota8_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield40" type="text" size="2" maxlength="2" value="'.$notas_nota9_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield41" type="text" size="2" maxlength="2" value="'.$notas_nota10_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield42" type="text" size="2" maxlength="2" value="'.$notas_nota11_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield43" type="text" size="2" maxlength="2" value="'.$notas_nota12_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield44" type="text" size="2" maxlength="2" value="'.$notas_nota13_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield45" type="text" size="2" maxlength="2" value="'.$notas_nota14_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield46" type="text" size="2" maxlength="2" value="'.$notas_nota15_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield47" type="text" size="2" maxlength="2" value="'.$notas_nota16_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield48" type="text" size="2" maxlength="2" value="'.$notas_nota17_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield49" type="text" size="2" maxlength="2" value="'.$notas_nota18_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield50" type="text" size="2" maxlength="2" value="'.$notas_nota19_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield51" type="text" size="2" maxlength="2" value="'.$notas_nota20_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td><td width="1"><div align="center"><input name="textfield52" type="text" size="2" maxlength="2" value="'.$notas_promedio_[$k].'" style="color:#003399; background-color:#FFFF33"></div></td>'; } } $tabla_[$j] .='</tr></table>';										
				
				
		}
	
	}
	
	if ($id_ramo_[$j]==$ramo){
	    $tabla_1 = $tabla_[$j];		
	}
	 
}	   


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script>

function replace(texto,s1,s2){
	return texto.split(s1).join(s2);
}

function act_subsector(n,c,r){
    var t;
	<?
	if (isset($id_ramo_[0])){  ?>
		if (r==<?=$id_ramo_[0]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[0]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[1])){  ?>
		if (r==<?=$id_ramo_[1]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[1]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[2])){  ?>
		if (r==<?=$id_ramo_[2]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[2]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[3])){  ?>
		if (r==<?=$id_ramo_[3]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[3]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[4])){  ?>
		if (r==<?=$id_ramo_[4]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[4]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[5])){  ?>
		if (r==<?=$id_ramo_[5]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[5]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[6])){  ?>
		if (r==<?=$id_ramo_[6]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[6]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[7])){  ?>
		if (r==<?=$id_ramo_[7]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[7]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[8])){  ?>
		if (r==<?=$id_ramo_[8]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[8]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[9])){  ?>
		if (r==<?=$id_ramo_[9]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[9]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[10])){  ?>
		if (r==<?=$id_ramo_[10]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[10]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[11])){  ?>
		if (r==<?=$id_ramo_[11]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[11]?>');
		}
 <? } ?>
	<?
	if (isset($id_ramo_[12])){  ?>
		if (r==<?=$id_ramo_[12]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[12]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[13])){  ?>
		if (r==<?=$id_ramo_[13]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[13]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[14])){  ?>
		if (r==<?=$id_ramo_[14]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[14]?>');
		}
 <? } ?>
 <?
	if (isset($id_ramo_[15])){  ?>
		if (r==<?=$id_ramo_[15]?>){
		   t = 'nada';
		   t = replace(t,'nada','<?=$tabla_[15]?>');
		}
 <? } ?>
    
   
    //document.getElementById('nom_subsector').style.visibility='hidden';
	document.getElementById('nom_subsector').innerHTML=n;
	// en nuestro javascript creamos las variables tabla_ nnnn
    document.getElementById('alumno_notas').innerHTML=t;
			       			
}
</script>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style>
.tachado {
    text-decoration: line-through;
}
.Estilo1 {
	font-size: 14px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo2 {
	color: #000000;
	font-weight: bold;
}
.Estilo3 {
	color: #990000;
	font-size: 12px;
}
.Estilo4 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #990000; }
.Estilo6 {
	color: #000000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.textolink {
	BORDER-RIGHT: 5px; PADDING-RIGHT: 5px; BORDER-TOP: 5px; PADDING-LEFT: 5px; FONT-WEIGHT: normal; FONT-SIZE: 8px; PADDING-BOTTOM: 5px; MARGIN: 5px; BORDER-LEFT: 5px; COLOR:#000000; PADDING-TOP: 5px; BORDER-BOTTOM: 5px; FONT-STYLE: normal; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3">
				<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
                    <tr>                       
                      <td width="73%" align="left" valign="top"><table width="100%" border="2">
                        <tr>
                          <td><table width="100%" border="1">
                            <tr>
                              <td width="60%"><table width="100%" border="1">
                                <tr>
                                  <td colspan="2">MODULO INGRESO DE NOTAS </td>
                                  </tr>
                                <tr>
                                  <td width="30%">&nbsp;</td>
                                  <td width="70%">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>Subsector</td>
                                  <td>&nbsp; <div id="nom_subsector"><?=$cod_subsector?>, <?=$nombre_subsector?> </div></td>
                                </tr>
                              </table></td>
                              <td width="40%"><table width="100%" border="1">
                                <tr>
                                  <td>Opciones Generales </td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td><table width="100%" border="2">
                            <tr>
                              <td width="1%" valign="top"><table width="160" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td height="24"><img src="images/tit_subsectores.jpg" width="160" height="25"></td>
                                </tr>
                                <tr>
                                  <td bgcolor="#000000"><img src="images/linea_negra.jpg" width="3" height="1"></td>
                                </tr>
								<?
								for ($i=0; $i < $num3; $i++){
                                    ?>
									<tr>
									  <td height="15">
									  <div id="0" onClick="act_subsector('<?=$nombre_subsector_titulo[$i]?>','<?=$cod_subsector_[$i]?>','<?=$id_ramo_[$i]?>');">
									  <table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr>
										  <td width="8"><img src="images/izq_subsec.jpg" width="8" height="20"></td>
										  <td width="144" bgcolor="#EAF2FF">&nbsp; <font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px" color="#FF0000"><?=$cod_subsector_[$i]?>,</font><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px" color="#666666"> <?=$nombre_subsector_[$i]?></font></td>
										  <td width="8"><img src="images/der_subsec.jpg" alt="<?=$nombre_subsector_titulo[$i]?>" width="8" height="20"></td>
										</tr>										
									  </table>
									  </div>
									  </td>
									</tr>
									<tr>
									  <td bgcolor="#6186B0"><img src="images/linea_azulclaro.jpg" width="3" height="1"></td>
									</tr>
								    <?
								 }
								 ?>                                
                              </table></td>
                              <td width="90%" valign="top"><table width="100%" border="1">
                                <tr>
                                  <td colspan="8">Procentaje</td>
                                  <td width="10%">Total % </td>
                                </tr>
                                <tr>
                                  <td width="130">.</td>
                                  <td><div align="center">
                                    <input name="textfield3" type="text" size="2" maxlength="2">
                                  </div></td>
                                  <td><div align="center">
                                    <input name="textfield4" type="text" size="2" maxlength="2">
                                  </div></td>
                                  <td><div align="center">
                                    <input name="textfield5" type="text" size="2" maxlength="2">
                                  </div></td>
                                  <td><div align="center">
                                    <input name="textfield6" type="text" size="2" maxlength="2">
                                  </div></td>
                                  <td><div align="center">
                                    <input name="textfield7" type="text" size="2" maxlength="2">
                                  </div></td>
                                  <td><div align="center">
                                    <input name="textfield8" type="text" size="2" maxlength="2">
                                  </div></td>
                                  <td><div align="center">
                                    <input name="textfield9" type="text" size="2" maxlength="2">
                                  </div></td>
                                  <td><div align="center">
                                    <input name="textfield10" type="text" size="2" maxlength="2">
                                  </div></td>
                                </tr>
                              </table>
                                <table width="100%" border="1">
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="8">Notas Parciales </td>
                                    </tr>
                                  <tr>
                                    <td width="180">Alumnos</td>
                                    <td width="1">N1</td>
                                    <td width="1">N2</td>
                                    <td width="1">N3</td>
                                    <td width="1">N4</td>
                                    <td width="1">N5</td>
                                    <td width="1">N6</td>
                                    <td width="1">N7</td>
									<td width="1">N8</td>
									<td width="1">N9</td>
									<td width="1">N10</td>
									<td width="1">N11</td>
									<td width="1">N12</td>
									<td width="1">N13</td>
									<td width="1">N14</td>
									<td width="1">N15</td>
									<td width="1">N16</td>
									<td width="1">N17</td>
									<td width="1">N18</td>
									<td width="1">N19</td>
									<td width="1">N20</td>
                                    <td width="1">Prom<br> 
                                      parc 2 </td>
                                  </tr>
								</table>  
								  <div id="alumno_notas"><?=$tabla_1?></div>								  
                                </td>
                              <td width="10%" valign="top"><table width="100%" border="1">
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                                <table width="100%" border="1">
                                  <tr>
                                    <td>Prom Per 1 </td>
                                    <td>Prom Per 2 </td>
                                    <td>Prom Gen </td>
                                  </tr>
                                  <tr>
                                    <td><div align="center">
                                      <input name="textfield392" type="text" size="2" maxlength="2">
                                    </div></td>
                                    <td><div align="center">
                                      <input name="textfield393" type="text" size="2" maxlength="2">
                                    </div></td>
                                    <td><div align="center">
                                      <input name="textfield394" type="text" size="2" maxlength="2">
                                    </div></td>
                                  </tr>
                                </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table>
				 </td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<?  pg_close($conn);?>
</body>
</html>
