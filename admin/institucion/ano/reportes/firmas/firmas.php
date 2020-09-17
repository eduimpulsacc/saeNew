<?php
if($_PERFIL==0){
/*echo  "curso-->".$cmb_curso;
echo  "curso2-->".$curso;
echo  "curso2-->".$c_curso;*/
 }
//echo "variable-->".$concur;
	$ntimbre ="";
	
	 for($nt=1;$nt<=$ruta_timbre;$nt++){
		$ntimbre.="../";
	 }
	 
	 $nfirma="";
	 for($nf=1;$nf<=$ruta_firma;$nf++){
		$nfirma.="../";
	 }
	 
	 $rtt=($xls==1)?"http://".$_SERVER['HTTP_HOST']."/sae3.0/":$ntimbre;
	 
	  $rff=($xls==1)?"http://".$_SERVER['HTTP_HOST']."/sae3.0/admin/institucion/":$nfirma;
	 
	 // echo $rff="http://".$_SERVER['HTTP_HOST']."/sae3.0/institucion/";
	
    $ob_institucion = new Membrete();
	$ob_institucion -> ano =$ano;
	$ob_institucion -> institucion =$institucion;
	$ob_institucion -> institucion($conn);
	
	


?>

<?php if($ob_config->timbre==0 || !is_file($ntimbre."timbres/".$ob_institucion ->timbre_ins)){?>
<table width="650" border="0" align="center">
		  <tr>
		  	<?  
			
			if($ob_config->firma1!=0 ){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->empleado=$ob_config->empleado1;
				if($concur!=0 || $concur!=" "){
					$ob_reporte->curso=$curso;
				}
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file($rff."empleado/firma_digital/".$rut_emp.".jpg") && $ob_config->firmadig1==1 ){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='".$rff."empleado/firma_digital/$rut_emp.jpg' width='200' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
                
			<td width="25%" class="item" height="100"><div style="width:100; height:50;"></div><?php if($_INSTIT!=10235){?><hr align="center" width="150" color="#000000"><?php }?><div align="center">
            <?php if(!$chcargo){?>
            <span class="item"><?=$ob_reporte->nombre_emp;?> </span>
            <?php }?>
            <br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			<? if($ob_config->firma2!=0 ){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->empleado=$ob_config->empleado2;
				if($concur!=0 || $concur!=" "){
					$ob_reporte->curso=$curso;
				}
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file($rff."empleado/firma_digital/".$rut_emp.".jpg") && $ob_config->firmadig2==1){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='".$rff."empleado/firma_digital/$rut_emp.jpg' width='200' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				if(isset($firmadig2)){
				echo $firmadig2;
				}else{
				?>
		    <td width="25%" align="center" class="item"><div style="width:100; height:50;"></div><?php if($_INSTIT!=10235){?><hr align="center" width="150" color="#000000"> <?php }?>
		      <div align="center">
			   <?php if(!$chcargo){?>
			  <?=$ob_reporte->nombre_emp;?>
              <?php }?><br>
    <? if($institucion==24762){
				echo "Director";	
			}else{
				echo $ob_reporte->nombre_cargo;
			}?></div></td>
			<? }} ?>
			 <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->empleado=$ob_config->empleado3;
				
				if($concur!=0 || $concur!=" "){
					$ob_reporte->curso=$curso;
				}
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file($rff."empleado/firma_digital/".$rut_emp.".jpg") && $ob_config->firmadig3==1){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='".$rff."empleado/firma_digital/$rut_emp.jpg' width='200' height='80'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				echo $firmadig3;
				}else{
				
				?>
			<td width="25%" align="center" class="item"><div style="width:100; height:50;"></div><?php if($_INSTIT!=10235){?><hr align="center" width="150" color="#000000"><?php }?><div align="center">
			 <?php if(!$chcargo){?>
			<?=$ob_reporte->nombre_emp;?><br>
            <?php }?>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->empleado=$ob_config->empleado4;
				if($concur!=0 || $concur!=" "){
					$ob_reporte->curso=$curso;
				}
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file($rff."empleado/firma_digital/".$rut_emp.".jpg") && $ob_config->firmadig4==1){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='".$rff."empleado/firma_digital/$rut_emp.jpg' width='200' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				echo $firmadig4;
				}else{
		?>
		  <td width="25%" align="center" class="item"><div style="width:100; height:50;"></div><?php if($_INSTIT!=10235){?><hr align="center" width="150" color="#000000"><?php }?><div align="center">
		   <?php if(!$chcargo){?>
		  <?=$ob_reporte->nombre_emp;?><br>
          <?php }?>
	        <?=$ob_reporte->nombre_cargo;?> </div></td>
			<? }}?>
           <?php  if($chk_apo==1){?>
			
            <td width="25%" class="item"><div style="width:100; height:50;"></div> <div align="center"><?php if($_INSTIT!=10235){?><hr align="center" width="150" color="#000000"><?php }?>
                <br>
                <?="Apoderado";?>
                <br>
                
                </div></td>
                <?php }?>
		  </tr>
		</table>
<?php }
else{
?>
<table width="650" border="0" align="center">
  <tr>
    <td width="39%" rowspan="3" align="center" valign="top"><img src="<?php echo $rtt ?>timbres/<?php echo $ob_institucion ->timbre_ins ?>" width="150" height="150" /></td>
    <?  
			if($ob_config->firma1!=0 ){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->empleado=$ob_config->empleado1;
				if($concur!=0){
					$ob_reporte->curso=$curso;
				}
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file($rff."empleado/firma_digital/".$rut_emp.".jpg") && $ob_config->firmadig1==1 ){
	 $firmadig1="<td align='center' width='31%' class='item' height='100'><img src='".$rff."empleado/firma_digital/$rut_emp.jpg' width='200' height='50'><hr align='center' width='150' color='#000000'><div align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
                
			<td width="31%" height="100" align="center" class="item"><div style="width:100; height:50;"></div><?php if($_INSTIT!=10235){?><hr align="center" width="150" color="#000000"><?php }?><div align="center">
             <?php if(!$chcargo){?>
            <span class="item"><?=$ob_reporte->nombre_emp;?> </span>
            <?php }?><br>
    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
    	<? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->empleado=$ob_config->empleado2;
				if($concur!=0){
					$ob_reporte->curso=$curso;
				}
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
			//if($_PERFIL==0){	echo $rff."empleado/firma_digital/".$rut_emp.".jpg";}
	  if(is_file($rff."empleado/firma_digital/".$rut_emp.".jpg") && $ob_config->firmadig2==1){
	 $firmadig2="<td align='center' width='31%' class='item' height='100'><img src='".$rff."empleado/firma_digital/".$rut_emp.".jpg' width='200' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				if(isset($firmadig2)){
				echo $firmadig2;
				}else{
				?>
		    <td width="30%" align="center" class="item"><div style="width:100; height:50;"></div><?php if($_INSTIT!=10235){?><hr align="center" width="150" color="#000000"><?php }?>
		      <div align="center">
			   <?php if(!$chcargo){?>
			  <?=$ob_reporte->nombre_emp;?>
              <?php }?><br>
    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
   <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->empleado=$ob_config->empleado3;
				if($concur!=0){
					$ob_reporte->curso=$curso;
				}
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file($rff."empleado/firma_digital/".$rut_emp.".jpg") && $ob_config->firmadig3==1){
	 $firmadig3="<td align='center' width='31%' class='item' height='100'><img src='".$rff."empleado/firma_digital/$rut_emp.jpg' width='200' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				echo $firmadig3;
				}else{
				
				?>
			<td width="31%" align="center" class="item"><div style="width:100; height:50;"></div><?php if($_INSTIT!=10235){?><hr align="center" width="150" color="#000000"><?php }?><div align="center">
			 <?php if(!$chcargo){?>
			<?=$ob_reporte->nombre_emp;?>
            <?php }?><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
     <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->empleado=$ob_config->empleado4;
				if($concur!=0){
					$ob_reporte->curso=$curso;
				}
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file($rff."empleado/firma_digital/".$rut_emp.".jpg") && $ob_config->firmadig4==1){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='".$rff."empleado/firma_digital/$rut_emp.jpg' width='200' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				echo $firmadig4;
				}else{ 
				
		?>
		  <td width="30%" align="center" class="item"><div style="width:100; height:50;"></div><?php if($_INSTIT!=10235){?><hr align="center" width="150" color="#000000"><?php }?><div align="center">
		   <?php if(!$chcargo){?>
		  <?=$ob_reporte->nombre_emp;?>
          <?php }?>
          <br>
    <?=$ob_reporte->nombre_cargo;?> </div></td>
			<? }}?>
  </tr>
  <?php if($chk_apo==1){?>
  <tr>
    <td>&nbsp;</td>
     <td width="25%" class="item" align="center"><div style="width:100; height:50;" align="center"></div> <?php if($_INSTIT!=10235){?><hr align="center" width="150" color="#000000"><?php }?>
                <br>
                <?="Apoderado";?>
                <br>
                
                </div></td>
    <td>&nbsp;</td>
  </tr>
  <?php }?>
</table>


<?php }?>