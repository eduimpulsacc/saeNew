<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="black">
			<tr>
				<td>
					<table width="100%" border="0" cellpadding="0" cellspacing="1" height="63">
						<tr>
							<td bordercolor="#FFFFFF" width="18" rowspan="2" bgcolor="#336699">
								<div align="center">
									<b><font size="2" face="Verdana, Arial, Helvetica, 
sans-serif"></font></b></div>
							</td>
							<td width="232" rowspan="2" bgcolor="#336699">
								<div align="center"><font color="white" size="2" 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><b><?php echo $area ?></b></font>
								</div>
							</td>
							<td colspan="3" bgcolor="#336699">
								<div align="center">
									<font color="white" size="2" 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><b>Evaluaci&oacute;n Diagn&oacute;stica</b></font></div>
							</td>
							<?php 

							$letra=array (
										  0 =>"b", 
										  1 =>"c",
										  2 =>"d");
										$semestre=array (
										  0 =>"Primer ", 
										  1 =>"Segundo",
										  2 =>"Tercer");
										$tipo=array (
										  3 =>"trimestre", 
										  2 =>"Semestre"
										);
									
							for($i=0;$i<$N;$i++){  ?>
							<td colspan="3" bgcolor="#336699">
								<div align="center">
									<font color="white" size="2" 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
									<b>
									<?php echo $semestre[$i]," ",$tipo[$N] ?>
									</b>
									</font>
							    </div>
							</td>
							<?php } ?>
						</tr>
						<tr height="10">
						    <td width="40" bgcolor="#add8e6" height="10">
								<div align="center">
									<font color="#000066"><b><font size="2" 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Si</font></b></font></div>
							</td>
							<td width="57" bgcolor="#add8e6" height="10">
								<div align="center">
									<font color="#000066"><b><font size="2" 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">A Veces</font></b></font></div>
							</td>
							<td width="50" bgcolor="#add8e6" height="10">
								<div align="center">
									<font color="#000066"><b><font size="2" 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">No</font></b></font></div>
							</td>
						
						 <?php	for($i=0;$i<$N;$i++) { ?>
										<td width="40" bgcolor="#add8e6" height="10">
											<div align="center">
												<font color="#000066"><b><font 
size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Si</font></b></font></div>
										</td>
										<td width="57" bgcolor="#add8e6" height="10">
											<div align="center">
												<font color="#000066"><b><font 
size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">A Veces</font></b></font></div>
										</td>
										<td width="50" bgcolor="#add8e6" height="10">
											<div align="center">
												<font color="#000066"><b><font 
size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">No</font></b></font></div>
										</td>
							
						<?php 	} ?>
						</tr>
