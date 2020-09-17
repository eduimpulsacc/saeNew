<HTML>
	<HEAD>
		<TITLE>COMBOS REGIONES</TITLE>
		<?php include('rpc.php3');?>
	</HEAD>
	<BODY bgColor=#ffffff>
	<CENTER>
		<TABLE bgColor=#ddccff border=0 cellPadding=8 cellSpacing=0>
			  <TBODY>
				<TR vAlign=top>
					<TD>REGION:<BR>
						<FORM method=post name=f1 onsubmit="return false;">
							<SELECT class=saveHistory id=m1 name=m1 onchange=relate(this.form,0,this.selectedIndex)>
							<?php
								//SELECCIONAR TODAS LAS REGIONES
								$qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
								$resultREG	=@pg_Exec($connRPC,$qryREG);
								for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
									$filaREG = @pg_fetch_array($resultREG,$i);
									echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." \n";
								}//for resultREG
							?>
							</OPTION>
							</SELECT>
						</FORM>
					</TD>
					<TD bgColor=#ffffff vAlign=center><B>---&gt;</B></TD>
					<TD>PROVINCIA:<BR>
						<FORM method=post name=f2 onsubmit="return false;">
							<SELECT class=saveHistory id=m2 name=m2 onchange=relate2(this.form,0,this.selectedIndex,0)> 
							<?php
								//SELECCIONAR TODAS LAS PROVINCIAS
								$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=1 ORDER BY NOM_PRO ASC";
								$resultPRO	=@pg_Exec($connRPC,$qryPRO);
								for($i=0 ; $i < @pg_numrows($resultPRO) ; $i++){
									$filaPRO = @pg_fetch_array($resultPRO,$i);
									echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\">".trim($filaPRO['nom_pro'])." \n";
								}//for resultPRO
							?>
							</OPTION>
							</SELECT>
						</FORM>
					</TD>
				    <TD bgColor=#ffffff vAlign=center><B>---&gt;</B></TD>
					<TD>COMUNA:<BR>
						<FORM action=/cgi-bin/redirect.cgi method=post name=f3 onsubmit="return false;">
							<SELECT class=saveHistory id=m3 name=m3>
							<?php
								//SELECCIONAR TODAS LAS COMUNAS
								$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=1 AND COR_PRO=1 ORDER BY NOM_COM ASC";
								$resultCOM	=@pg_Exec($connRPC,$qryCOM);
								for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
									$filaCOM = @pg_fetch_array($resultCOM,$i);
									echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\">".trim($filaCOM['nom_com'])." \n";
								}//for resultPRO
							?>
							</OPTION>
							</SELECT> 
						</FORM>
					</TD>
				</TR>
			</TBODY>
		</TABLE>
	</CENTER>
	</BODY>
</HTML>