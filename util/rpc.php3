<?php 
	

	echo "		<STYLE>.saveHistory {\n";
	echo "			BEHAVIOR: url(#default#savehistory)\n";
	echo "		}\n";
	echo "		</STYLE>\n";
		
	echo "		<SCRIPT language=JavaScript>\n";
	echo "			<!-- \n";
	echo "				v=false; \n";
	echo "			//-->\n";
	echo "		</SCRIPT>\n";

	echo "		<SCRIPT language=JavaScript1.1>\n";
	echo "			<!-- \n";
	echo "				if (typeof(Option)+\"\" != \"undefined\") \n";
	echo "					v=true; \n";
	echo "			//-->\n";
	echo "		</SCRIPT>\n";

	echo "		<SCRIPT language=JavaScript>\n";
	echo "			<!--\n";

	echo "			if(v){\n";
	echo "				a=new Array(22);\n";
	echo "				aln=22;\n";
	echo "			}\n";

	echo "			function getFormNum (formName) {\n";
	echo "				var formNum =-1;\n";
	echo "				for (i=0;i<document.forms.length;i++){\n";
	echo "					tempForm = document.forms[i];\n";
	echo "					if (formName == tempForm) {\n";
	echo "						formNum = i;\n";
	echo "						correctForm = tempForm;\n";
	echo "						break;\n";
	echo "					}\n";
	echo "				}\n";
	echo "				return formNum;\n";
	echo "			}\n";

	echo "			function jmp(form, elt)// The first parameter is a reference to the form.\n";
	echo "			{\n";
	echo "				if (form != null) {\n";
	echo "					with (form.elements[elt]) {\n";
	echo "						if (0 <= selectedIndex)\n";
	echo "							location = options[selectedIndex].value;\n";
	echo "					}\n";
	echo "				}\n";
	echo "			}\n";

	echo "			var catsIndex = -1;\n";
	echo "			var itemsIndex;\n";
	echo "			var subItemsIndex;\n";

	echo "			function newCat(){\n";
	echo "				catsIndex++;\n";
	echo "				a[catsIndex] = new Array();\n";
	echo "				itemsIndex = -1;\n";
	echo "			}\n";

	echo "			function O(txt,url) {\n";
	echo "				itemsIndex++;\n";
	echo "				a[catsIndex][itemsIndex] = new Array();\n";
	echo "				a[catsIndex][itemsIndex].text = txt;\n";
	echo "				a[catsIndex][itemsIndex].value = url;\n";
	echo "				subItemsIndex = 0;\n";
	echo "			}\n";

	echo "			function OO(txt,url) {\n";
	echo "				a[catsIndex][itemsIndex][subItemsIndex] = new myOptions(txt,url);\n";
	echo "				subItemsIndex++;\n";
	echo "			}\n";

	echo "			function myOptions(txt,url){\n";
	echo "				this.text = txt;\n";
	echo "				this.value = url;\n";
	echo "			}\n";
	echo "			// fill array\n";

	echo "		if (v) {\n"; // ns 2 fix
	//SELECCIONAR TODAS LAS REGIONES
	$qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
	$resultREG	=@pg_Exec($connRPC,$qryREG);
	for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
		$filaREG = @pg_fetch_array($resultREG,$i);
		echo "newCat();\n";
		//SELECCIONAR TODAS LAS PROVINCIAS DE LA REGION
		$qryPROV	="SELECT * FROM PROVINCIA WHERE COD_REG=".$filaREG['cod_reg']." ORDER BY NOM_PRO ASC";
		$resultPROV	=@pg_Exec($connRPC,$qryPROV);
		for($j=0 ; $j < @pg_numrows($resultPROV) ; $j++){
			$filaPROV = @pg_fetch_array($resultPROV,$j);
			if($j==0) echo "	O(\"\",\"\");\n";
			echo "	O(\"".trim($filaPROV['nom_pro'])."\",\"".trim($filaPROV['cor_pro'])."\");\n";
			//SELECCIONAR TODAS LAS COMUNAS DE LA PROVINCIA
			$qryCOM	="SELECT * FROM COMUNA WHERE COR_PRO=".$filaPROV['cor_pro']." AND COD_REG=".$filaREG['cod_reg']." ORDER BY NOM_COM ASC";
			$resultCOM	=@pg_Exec($connRPC,$qryCOM);
			for($k=0 ; $k < @pg_numrows($resultCOM) ; $k++){
				$filaCOM = @pg_fetch_array($resultCOM,$k);
				if($k==0) echo "		OO(\"\",\"\");\n";
				echo "		OO(\"".trim($filaCOM['nom_com'])."\",\"".trim($filaCOM['cor_com'])."\");\n";

			}//for resultCOM
		}//for resultPROV
	}//for resultREG
	echo "		} // if (v)\n";

	echo "			function relate(formName,elementNum,j) {\n";
	echo "				// relate first to second (and third) menus\n";
	echo "				// ie change first menu, changes second, then change third\n";
	echo "				//\n";
	echo "				if(v){\n";
	echo "				var formNum = getFormNum(formName);\n";
	echo "				 if (formNum>=0) {\n";
	echo "					formNum++; // reference next form, assume it follows in HTML\n";
	echo "					with (document.forms[formNum].elements[elementNum]) {\n";
	echo "						for(i=options.length-1;i>0;i--) options[i] = null; // null out in reverse order (bug workarnd)\n";
	echo "							for(i=0;i<a[j].length;i++){\n";
	echo "								options[i] = new Option(a[j][i].text,a[j][i].value); \n";
	echo "							}\n";
	echo "							options[0].selected = true;\n";
	echo "						}\n";
	echo "						// change third menu\n";
	echo "						relate2(formName,elementNum,0,1);\n";
	echo "					}\n";
	echo "					} else {\n";
	echo "						jmp(formName,elementNum);\n";
	echo "						}\n";
	echo "				}\n";

	echo "				function relate2(formName,elementNum,j,fromRelate) {\n";
	echo "				if(v){\n";
	echo "					var formNum = getFormNum(formName);\n";
	echo "					 if (formNum>=0) {\n";
	echo "						// find first menu's selection\n";
	echo "						// fromRelate means \"coming from relate function?\" \n";
	echo "						//   then increment formNum so k refers to first form, \n";
	echo "						//   not the nonexistent one before it (-1)\n";
	echo "						if (fromRelate) formNum++; // assumes forms follow each other \n";
	echo "							k = document.forms[formNum-1].elements[elementNum].selectedIndex;\n";
	echo "							if(k<0)k=0; // precaution against missing selected in first menu list - abk\n";
	echo "								formNum++; // reference next form, assume it follows in HTML\n";
	echo "								with (document.forms[formNum].elements[elementNum]) {\n";
	echo "									for(i=options.length-1;i>0;i--) \n";
	echo "										options[i] = null; // null out in reverse order (bug workarnd)\n";
	echo "									for(i=0;i<a[k][j].length;i++){\n";
	echo "										options[i] = new Option(a[k][j][i].text,a[k][j][i].value); \n";
	echo "								}\n";
	echo "								options[0].selected = true;\n";
	echo "							}\n";
	echo "						}\n";
	echo "						} else {\n";
	echo "							jmp(formName,elementNum);\n";
	echo "						}\n";
	echo "				}\n";

	echo "				function IEsetup(){\n";
	echo "					if(!document.all)\n"; 
	echo "						return;\n";
	echo "					IE5 = navigator.appVersion.indexOf(\"5.\")!=-1;\n";

	echo "					if(!IE5) {\n";
	echo "						for (i=0;i<document.forms.length;i++) {\n";
	echo "							document.forms[i].reset();\n";
	echo "						}\n";
	echo "					}\n";
	echo "				}\n";

	echo "				window.onload = IEsetup;\n";
	echo "		//-->\n";
	echo "		</SCRIPT>\n";
?>
