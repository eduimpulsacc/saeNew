<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="td.css" TYPE="text/css">
		<?php include('rpc.php3');?>
		<SCRIPT language="JavaScript" src="chkform.js"></SCRIPT>
	</HEAD>
<BODY>

	<STRONG>REGION</STRONG>
	<FORM method=post name=f1 onsubmit="return false;">
		<SELECT class=saveHistory id=m1 name=m1 onchange="relate(this.form,0,this.selectedIndex);">
		<?php
			//SELECCIONAR TODAS LAS REGIONES
			$qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
			$resultREG	=@pg_Exec($connRPC,$qryREG);
			for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
				$filaREG = @pg_fetch_array($resultREG,$i);
				echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." </OPTION>\n";
			}//for resultREG
		?>
		</SELECT>
	</FORM>

	<STRONG>PROVINCIA</STRONG>
	<FORM method=post name=f2 onsubmit="return false;">
		<SELECT class=saveHistory id=m2 name=m2 onchange="relate2(this.form,0,this.selectedIndex,0);"> 
		<?php
			//SELECCIONAR TODAS LAS PROVINCIAS
			$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=1 ORDER BY NOM_PRO ASC";
			$resultPRO	=@pg_Exec($connRPC,$qryPRO);
			for($i=0 ; $i < @pg_numrows($resultPRO) ; $i++){
				$filaPRO = @pg_fetch_array($resultPRO,$i);
				echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\">".trim($filaPRO['nom_pro'])." </OPTION>\n";
			}//for resultPRO
		?>
		</SELECT>
	</FORM>

	<STRONG>COMUNA</STRONG>
	<FORM  method=post name=f3 onsubmit="return false;">
		<!--SELECT class=saveHistory id=m3 name=m3 onchange="document.frm.txtCOM.value=document.f3.m3.value;"--> 
		<SELECT class=saveHistory id=m3 name=m3> 
		<?php
			//SELECCIONAR TODAS LAS COMUNAS
			$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=1 AND COR_PRO=1 ORDER BY NOM_COM ASC";
			$resultCOM	=@pg_Exec($connRPC,$qryCOM);
			for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
				$filaCOM = @pg_fetch_array($resultCOM,$i);
				echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\">".trim($filaCOM['nom_com'])." </OPTION>\n";
			}//for resultPRO
		?>
		</SELECT> 
	</FORM>
</BODY>
</HTML>