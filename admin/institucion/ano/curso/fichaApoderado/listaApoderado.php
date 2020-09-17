<?
require('../../../../../util/header.inc');

 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<div id="listaApoderado">

<? if ($curso != NULL){ 
	   ?>
     <table>
      <tr valign="top">
            <td height="30"  class="textonegrita" colspan="1">PROFESOR JEFE </td>
            
            <td valign="top" colspan="4"><font face="arial, geneva, helvetica" size=2> <strong>
			
			<? 
				$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
				$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
				$result =@pg_Exec($conn,$sql4);
				if (!$result) 
				{
				}
				else
				{
					if (pg_numrows($result)!=0)
					{
						$fila = @pg_fetch_array($result,0);	
						if (!$fila)
						{
							
						}
					}
				}
				
		echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
				
				
				?>
			
			
			</strong>
			</font></td>
          </tr>
     </table> 
      
       <center>
      
	<table width="100%">
    
    <tr > 
      <td align="right" colspan="6" class="tableindex">
      <div align="right">
     <input type="button" class="botonXX" align="right" id="agregar_apo" name="agregar_apo" value="Agregar"  title="Agregar Apoderado" onclick="ingresa_apoderado()"  />
     </div>
      </td>
    </tr>
    <tr > 
	
      <?php if(($_PERFIL!=16)and($_PERFIL!=15) or ($institucion != "12838")){	?> 
     
		<?	if($_PERFIL!=15 and $institucion != "12838" and $_PERFIL!=16){	?>
 	 	<td align="center" width="75" class="tabla01"> <font face="arial, geneva, helvetica" size="1" color="#000000" > 
        	<strong>RUT</strong> </font>		</td>
		<?	}	?>
		
		<? //	if($_PERFIL!=15 and $institucion != "12838" and $_PERFIL!=16){	?>
 	 	
		
		<? //	}	?>
		
		
      <?php } ?>
      <td align="center" width="224" class="tabla01"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
        <strong>NOMBRE</strong> </font> </td>
      
	  <? if ($_PERFIL!=16 and $_PERFIL!=15){  // no muestro para alumno y apoderado ?>
	  	     <td align="center" width="179" class="tabla01"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
             <strong>DIRECCION</strong> </font> </td>
	 <? } ?>	
		
	  <? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>	
             <td align="center" width="73" class="tabla01"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
             <strong>TELEFONO</strong> </font> </td>
     <? } ?>
     
     <? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>	
             <td align="center" width="73" class="tabla01"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
             <strong>Ver Alumnos</strong> </font> </td>
     <? } ?>
     
     <? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>	
             <td align="center" width="73" class="tabla01"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
             <strong>Agregar Alumnos</strong> </font> </td>
     <? } ?>
	</tr>
    <?php
				     
				 $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, alumno.comuna, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, matricula.num_mat FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) AND nro_lista is not NULL order by ape_pat, ape_mat, nombre_alu ";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
				}else{
									
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
				 "RUT->".$rutA=$fila['rut_alumno'];
				 
				 
			 $sqlap=" select DISTINCT rut_apo
			from tiene2 where
			rut_alumno=".$rutA;
	 		$resultap =@pg_Exec($conn,$sqlap);
			for($x=0 ; $x < @pg_numrows($resultap) ; $x++){
				$filaap = @pg_fetch_array($resultap,$x);
			
			
			$sqlapo=" select DISTINCT apo.rut_apo,apo.dig_rut, apo.nombre_apo,apo.ape_pat,apo.ape_mat,apo.telefono,
			apo.calle,apo.nro,apo.depto,apo.region
			from apoderado apo where rut_apo=".$filaap['rut_apo'];
	 		    $resultapo =@pg_Exec($conn,$sqlapo)or die("Fallo");
				for($w=0 ; $w < @pg_numrows($resultapo) ; $w++){
				$filapo = @pg_fetch_array($resultapo,0);
			
			?>
			<?php if(($_PERFIL!=15)and($_PERFIL!=16)) { ?>
					<?	if($frmModo=="mostrar"){
					        if ($fila['bool_ar'] == 1){
							     ?>				           	
	<tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff'>             <?
						   }else{
							     ?>				           	
					             <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff'>               <?
							} 		 
							   				
								
						}	?>
			  <?php }
			  		else{ ?>
			<tr> 
			  <?php } ?>
			  <?php if(($_PERFIL!=16)and($_PERFIL!=15) or ($institucion != "12838")){	
			  ?>
						
						
					<?	if(($_PERFIL!=15)AND($institucion != "12838")AND($_PERFIL!=16)){	?>	
<td align="left"  class="textosimple" style="cursor:pointer" onclick="detalles_apo(<?=$filapo['rut_apo'];?>)" >
<font face="arial, geneva, helvetica" size="1" color="#000000" > 
							<strong>&nbsp;<?php echo $filapo["rut_apo"]." - ".$filapo["dig_rut"];?></strong> 
							</font> </td>
					<?	}	?>					
					
			  <?php } ?>		
			  
				
			    
			  
				  
				  <td align="left"style="cursor:pointer" onclick="detalles_apo(<?=$filapo['rut_apo'];?>)" > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
					<strong><?php echo $filapo["ape_pat"]." ".$filapo["ape_mat"].", ".$filapo["nombre_apo"];?></strong> 
					</font> </td>
					<? $qryC="select nom_com from comuna where cod_reg= ".$filapo["region"]." and cor_pro=".$filapo["ciudad"]." and cor_com=".$filapo["comuna"];
						$resultC=@pg_Exec($conn,$qryC);
					/*	 if (!$resultC) {
								error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
								exit();
						   }*/
						   $filaC= @pg_fetch_array($resultC,0);
					 ?>
					 
					 <? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>
					 		<td align="left" style="cursor:pointer" onclick="detalles_apo(<?=$filapo['rut_apo'];?>)" > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
<strong><? if($fila1['depto']!=""){		  echo strtoupper(trim($filapo['calle']) . " " . trim($filapo['nro']) . " depto" . " ".  trim($filapo['depto']) . " ". trim($filapo['nom_com']));
}else{
 echo strtoupper(trim($filapo['calle']) . " " . trim($filapo['nro']) . " ". trim($filapo['nom_com']));
}
	 ?></strong> 
	</font></td>
<? } ?>		
					
					
					<? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>					
					      <td align="left" style="cursor:pointer" onclick="detalles_apo(<?=$filapo['rut_apo'];?>)" > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
				         	<strong><?php echo $filapo["telefono"];?></strong> 
					      </font> </td>
				    <? } ?>		  
                    
     <? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>					
<td align="center" <? if ($fila['bool_ar'] == 1){?>class="tachado"<? }else{?>class="textosimple"<? }?> > <a onclick='veralum(<?=$filapo['rut_apo'];?>)' ><img src='../vitacora_alumno/img/PNG-48/Search.png' align="top"  width='25' height='25' border='0' style="cursor:pointer" title="Ver Alumnos Relacionados" /></a> </td>
				    <? } ?>		  
   <? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>					
<td align="center" <? if ($fila['bool_ar'] == 1){?>class="tachado"<? }else{?>class="textosimple"<? }?> > <a onclick='dialogalumno(<?=$filapo['rut_apo'];?>)' ><img src='../vitacora_alumno/img/PNG-48/Add.png' align="top"  width='25' height='25' border='0' style="cursor:pointer" title="Agregar Alumno" /></a> </td>
				    <? } ?>		                                
				</tr>
    <?php
					}
				}
			}	
				} 

				// fin FOR 
//*************************************

				$qry2="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, alumno.comuna, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, matricula.num_mat FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) AND nro_lista is NULL order by ape_pat, ape_mat, nombre_alu asc ";
				$result2 =@pg_Exec($conn,$qry2);
				if (!$result2) {
					error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
				}else{
				
			for($i=0 ; $i < @pg_numrows($result2) ; $i++){
				$fila = @pg_fetch_array($result2,$i);
				$rutA=$fila['rut_alumno'];
				
		 
			$sqlap=" select rut_apo
			from tiene2 where
			rut_alumno=".$rutA;
	 		$resultap =@pg_Exec($conn,$sqlap);
			for($x=0 ; $x < @pg_numrows($resultap) ; $x++){
				$filaap = @pg_fetch_array($resultap,$x);
			
			
			   $sqlapo=" select DISTINCT apo.rut_apo,apo.dig_rut, apo.nombre_apo,apo.ape_pat,apo.ape_mat,apo.telefono,
			apo.calle,apo.nro,apo.depto,apo.region
			from apoderado apo where rut_apo=".$filaap['rut_apo'];
	 		    $resultapo =@pg_Exec($conn,$sqlapo)or die("Fallo");
				for($w=0 ; $w < @pg_numrows($resultapo) ; $w++){
				$filapo = @pg_fetch_array($resultapo,0);
			
			
			
			?>
			<?php if(($_PERFIL!=15)and($_PERFIL!=16)) { ?>
					<?	if($frmModo=="mostrar"){	
					
					        if ($fila['bool_ar'] == 1){
							   ?>
							   
						       <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff' )>             <?
							}else{
							
							   if ($om!=1){  ?>	  
							  <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff')>     <?
							}
						}	   
							   
						}	?>
				
			  <?php }
			  		else{ ?>
			<tr> 
			  <?php } ?>
			  
			  
			  
			  
			  
			  <?php if($_PERFIL!=16) { ?>
			  
								
						
 						   <?
						   if (($_PERFIL!=16) and ($_PERFIL!=15) and ($_INSTIT!=12838)){ ?>						   	
<td align="left" class="textosimple" style="cursor:pointer" onclick="detalles_apo(<?=$filapo['rut_apo'];?>)"> 
<font face="arial, geneva, helvetica" size="1" color="#000000"> 
							<strong><?php echo $filapo["rut_apo"]." - ".$filapo["dig_rut"];?></strong> 
							</font> </td>
						<? } ?>	
						
						
						 
							
			            
			             <?php 
			  } ?>
			  
			  
			  
			  
			  
				  <td align="left"style="cursor:pointer" onclick="detalles_apo(<?=$filapo['rut_apo'];?>)"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
					<strong><?php echo $filapo["ape_pat"]." ".$filapo["ape_mat"].", ".$filapo["nombre_apo"];?></strong> 
					</font> </td>
					<? $qryC="select nom_com from comuna where cod_reg= ".$filapo["region"]." and cor_pro=".$filapo["ciudad"]." and cor_com=".$filapo["comuna"];
						$resultC=@pg_Exec($conn,$qryC);
					
						   $filaC= @pg_fetch_array($resultC,0);
					 ?>
					 
					 <? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>					 
					 
<td align="left" style="cursor:pointer" onclick="detalles_apo(<?=$filapo['rut_apo'];?>)" > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
<strong><? 
if($fila1['depto']!=""){
 echo strtoupper(trim($filapo['calle']) . " " . trim($filapo['nro']) . " depto" . " ".  trim($filapo['depto']) . " ". trim($filapo['nom_com']));
	}
else{
echo strtoupper(trim($filapo['calle']) . " " . trim($filapo['nro']) . " ". trim($filapo['nom_com']));
}
?></strong> 
</font></td>
<? } ?>		
					
					
					<? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>
					      <td align="left" <? if ($fila['bool_ar'] == 1){?>class="tachado"<? }else{?>class="textosimple"<? }?> > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
					      <strong><?php echo $filapo["telefono"];?></strong> 
					      </font> </td>
				    <? } ?>		  
                    
                    
    <? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>
					      <td align="center" <? if ($fila['bool_ar'] == 1){?>class="tachado"<? }else{?>class="textosimple"<? }?> > <a onclick='veralum(<?=$filapo['rut_apo'];?>)' ><img src='../vitacora_alumno/img/PNG-48/Search.png' align="top"  width='25' height='25' border='0' style="cursor:pointer" title="Agregar Apoderado" /></a> </td>
				    <? } ?>	
                    	
  <? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>					
<td align="center" <? if ($fila['bool_ar'] == 1){?>class="tachado"<? }else{?>class="textosimple"<? }?> > <a onclick='dialogalumno(<?=$filapo['rut_apo'];?>)' ><img src='../vitacora_alumno/img/PNG-48/Add.png' align="top"  width='25' height='25' border='0' style="cursor:pointer" title="Agregar Alumno" /></a> </td>
				    <? } ?>	                  
				</tr>
    <?php			
					} 
			}
			}
				}// fin FOR
//**************************
				
			?>
			<input type="hidden" name="total3" value="<?=$total3?>">
    <tr> 
      <td colspan="6"> <hr width="100%" color="#003b85"> </td>
    </tr>
    
  </table>
</center>
</FORM> 
	<?
	}else{
	     ?>
		 </td>
		 </tr>
		 </table>
	     <?
    } ?>		 							  
			 							  
</div>		



</body>
</html>