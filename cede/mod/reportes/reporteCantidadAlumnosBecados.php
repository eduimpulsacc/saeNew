<?  


header( 'Content-type: text/html; charset=iso-8859-1' ); 
session_start(); 

$ano =$_REQUEST['ano'];
$curso = $_REQUEST['curso'];
$institucion 	= $_INSTIT;


require "../../Class/Membrete.php";	
require "../../Class/Reporte.php";	

$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

$fila_instit = $ob_membrete->institucion($_INSTIT);

$fila_ano =$ob_reporte->AnoEscolarSeteado($ano);

$rs_curso = $ob_reporte->AlumnoCurso($curso);


$rs_becas_ins= $ob_reporte->TraeDescBeca($ano);




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../../../cortes/25269/estilos.css"/>
<title>REPORTE CEDE:::::: COLEGIO INTERACTIVO</title>
</head>

<body>
<table width="650" border="0" align="center">
  <tr>
    <td width="172" align="center" valign="middle"> <? echo "<img src='../../../tmp/".$institucion."insignia". "' >";?></td>
    <td width="25" align="center" valign="middle"><hr align="center" width="1" size="100" /></td>
    <td width="439"><table width="100%" border="0">
      <tr>
        <td align="center" class="textonegrita"><? echo strtoupper($fila_instit['nombre_instit']);?></td>
      </tr>
      <tr>
        <td align="center" class="textosimple"><? echo $fila_instit['direc']." / ".$fila_instit['nom_reg'];?></td>
      </tr>
      <tr>
        <td align="center" class="textosimple"><? echo htmlentities("Telefóno",ENT_QUOTES,'UTF-8')."  ".$fila_instit['telefono'];?></td>
      </tr>
      <tr>
        <td align="center" class="textosesion">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="95%" border="0" align="center" cellpadding="0">
      <tr>
        <td align="center" class="textonegrita"><p><u>REPORTE ALUMNOS BECADOS</u></p></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td><table width="100%" border="0">
              <tr>
                <td width="23%" class="textonegrita">CURSO</td>
                <td width="2%" class="textonegrita">:</td>
                <td width="75%" class="textosimple">&nbsp;<? echo $ob_reporte->CursoPalabra($curso,0);?></td>
              </tr>
              <tr>
                <td class="textonegrita">PROFESOR JEFE</td>
                <td class="textonegrita">:</td>
                <td class="textosimple">&nbsp;<? echo $ob_reporte->ProfesorJefe($curso);?></td>
              </tr>
              <tr>
                <td class="textonegrita"><?=htmlentities("AÑO",ENT_QUOTES,'UTF-8')?></td>
                <td class="textonegrita">:</td>
                <td class="textosimple">&nbsp;<? echo $fila_ano['nro_ano'];?></td>
              </tr>
              <tr>
                <td colspan="3" class="textonegrita">
                <?php echo ($tipobeca==1)?"BECAS ESTATALES":"BECAS INSTITUCIONALES" ?>
                </td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><br /><table width="100%" border="1" style="border-collapse:collapse">
              <tr class="textonegrita">
                <td width="50%" height="25">ALUMNO</td>
             <?php  if ($tipobeca==1){?>
                <td align="center">Alimentaci&oacute;n JUNAEB</td>
                <td align="center">Chile Solidario</td>
                <td align="center">Municipal</td>
                <td align="center">Financiamiento compartido</td>
                <td align="center">C. de Padres</td>
                <td align="center">Seguro</td>
                <td align="center">Beneficio PIE</td>
                <td align="center">Beneficio SEP</td>
                <td align="center">Programa PUENTE</td>
                <td align="center">Otras</td>
               <?php  }else{
				   
				   if($rs_becas_ins>0){
					 for($b=0;$b<pg_num_rows($rs_becas_ins);$b++){
						 $fil_n_beca = pg_fetch_array($rs_becas_ins,$b);
						 
				   ?>
                   <td width="14%" align="center"><?php echo $fil_n_beca['nomb_beca'] ?></td>
                   <?php
					   }
				   }else{
				   
				   ?>
                <td width="14%" align="center">Becas institucionales</td>
               <?php  
				   }
			   }?>
              </tr>
              <? for($i=0;$i<pg_numrows($rs_curso);$i++){
						$fila = pg_fetch_array($rs_curso,$i);
						
					if($tipobeca==1){
						$rs_becaes = $ob_reporte->TraeBecasES($ano,$fila['rut_alumno']);
						$fil_becaes=pg_fetch_array($rs_becaes,0);
						}
						
					elseif($tipobeca==2){}	
				?>
              <tr class="textosimple">
                <td >&nbsp;&nbsp;<? echo $fila['nombre_alumno'];?></td>
               
                
                <?php  if ($tipobeca==1){?>
                <td align="center"><?php 
				if($fil_becaes['bool_baj']==1){
				echo "SI";
					$sum_bool_baj++;
				}else{echo "NO";}
				
				?></td>
                <td align="center">
                <?php 
				if($fil_becaes['bool_bchs']==1){
				echo "SI";
				$sum_bool_bchs++;
					
				}else{echo "NO";}
				
				?>
                </td>
                <td align="center"><?php 
				if($fil_becaes['bool_mun']==1){
				echo "SI";
				$sum_bool_mun++;
					
				}else{echo "NO";}
				
				?></td>
                <td align="center"><?php 
				if($fil_becaes['bool_fci']==1){
				echo "SI";
				$sum_bool_fci++;
					
				}else{echo "NO";}
				
				?></td>
                <td align="center"><?php 
				if($fil_becaes['bool_cpadre']==1){
				echo "SI";
				$sum_bool_cpadre++;
				
					
				}else{echo "NO";}
				
				?></td>
                <td align="center"><?php 
				if($fil_becaes['bool_seg']==1){
				echo "SI";
				$sum_bool_seg++;
					
				}else{echo "NO";}
				
				?></td>
                <td align="center"><?php 
				if($fil_becaes['ben_pie']==1){
				echo "SI";
				$sum_ben_pie++;
				}else{echo "NO";}
				
				?></td>
                <td align="center"><?php 
				if($fil_becaes['ben_sep']==1){
				echo "SI";
				$sum_ben_sep++;
					
				}else{echo "NO";}
				
				?></td>
                <td align="center"><?php 
				if($fil_becaes['ben_puente']==1){
				echo "SI";
				$sum_ben_puente++;
				
				}else{echo "NO";}
				
				?></td>
                <td align="center"><?php 
				if($fil_becaes['bool_otros']==1){
				echo "SI";
				$sum_bool_otros++;
					
				}else{echo "NO";}
				
				?></td>
               <?php  }else{
				   
				   if($rs_becas_ins>0){
					 for($b=0;$b<pg_num_rows($rs_becas_ins);$b++){
						 
						 
						 $fil_n_beca = pg_fetch_array($rs_becas_ins,$b);
						 
						$rs_tengobecains=$ob_reporte-> TraeBecasINS($ano,$fila['rut_alumno'],$fil_n_beca['id_beca']);
						 
				   ?>
                   <td width="14%" align="center"><?php if(pg_numrows($rs_tengobecains)>0){
					 echo "SI";  
					
					   }
						 else
						 {echo "NO";}?></td>
                   <?php
					   }
				   }else{
				   
				   ?>
                <td width="14%" align="center">S/I</td>
               <?php  
				   }
			   }?>
                
                </tr>
               <? } ?>
               <tr class="textonegrita"><td>TOTALES               
                <?php  if ($tipobeca==1){?>
                <td align="center"><?php echo intval($sum_bool_baj) ?></td>
                <td align="center"><?php echo intval($sum_bool_bchs) ?></td>
                <td align="center"><?php echo intval($sum_bool_mun) ?></td>
                <td align="center"><?php echo intval($sum_bool_fci) ?></td>
                <td align="center"><?php echo intval($sum_bool_cpadre) ?></td>
                <td align="center"><?php echo intval($sum_bool_seg) ?></td>
                <td align="center"><?php echo intval($sum_ben_pie) ?></td>
                <td align="center"><?php echo intval($sum_ben_sep) ?></td>
                <td align="center"><?php echo intval($sum_ben_puente) ?></td>
                <td align="center"><?php echo intval($sum_bool_otros) ?></td>
               <?php  }else{
				   
				   if($rs_becas_ins>0){
					 for($b=0;$b<pg_num_rows($rs_becas_ins);$b++){
						 $fil_n_beca = pg_fetch_array($rs_becas_ins,$b);
						
				   ?>
                   <td width="14%" align="center"><?php 
				 
				    $sum_rs = $ob_reporte->TraeSumBecasINS($ano,$fil_n_beca['id_beca'],$curso);
					$fil_sum_becains = pg_fetch_array($sum_rs,0);
				   echo intval($fil_sum_becains['suma_beca']); ?></td>
                   <?php
					   }
				   }else{
				   
				   ?>
                <td width="14%" align="center">S/I</td>
               <?php  
				   }
			   }?>
               </tr>
            </table></td>
          </tr>
          
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3" align="left" class=" textosesion">&nbsp;</td>
  </tr>
</table>
</body>
</html>
