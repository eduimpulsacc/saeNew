<?php 
	$connRPC2=@pg_connect("dbname=coe host=10.132.10.36 port=5432 user=postgres password=co#newaaaccess;
	if (!$connRPC2) {
	 error('<b>ERROR:</b>No se puede conectar a la base de datos.1');
	 exit;
	}
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
	echo "						if (0 <= selectedIn)\n";
	echo "							location = options[selectedIn].value;\n";
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
	//SELECCIONAR TODAS LAS ENSENANZAS
	$qry4="SELECT * FROM tipo_ensenanza WHERE (cod_tipo='410' OR cod_tipo='510' OR cod_tipo='610' OR cod_tipo='710'OR cod_tipo='810') ORDER BY cod_tipo ASC";                                                                                                              
		  $result4	=@pg_Exec($connRPC2,$qry4);
           if (@pg_numrows($result4)!=0){;
            for($i=0 ; $i < @pg_numrows($result4) ; $i++){ 
            $fila4 = @pg_fetch_array($result4,$i);
		echo "newCat();\n";
		//SELECCIONAR TODAS LAS RAMAS
		$qryRA="SELECT * FROM RAMA WHERE COD_TIPO=".$fila4['cod_tipo']." ORDER BY NOM_PRO ASC";                                                                                                              
		    $resultRA	=@pg_Exec($connRPC2,$qryRA);
             if (@pg_numrows($resultRA)!=0){;?>
            <?php echo "<OPTION value=\"".($filaRA['cod_tipo'])."\">".($filaRA['nombre_rama'])." </OPTION>\n";
			//SELECCIONAR TODAS LAS ESPECIALIDADES
			$qryES	="SELECT * FROM ESPECIALIDAD  WHERE COD_RAMA=".$filaRA['cod_tipo']." ORDER BY NOM_COM ASC";
			$resultES	=@pg_Exec($connRPC2,$qryES);
			for($k=0 ; $k < @pg_numrows($resultES) ; $k++){
				$filaES = @pg_fetch_array($resultES,$k);
				if($k==0) echo "		OO(\"\",\"\");\n";
				echo "		OO(\"".trim($filaES['cod_esp'])."\",\"".trim($filaES['nombre_esp'])."\");\n";

			}//for resultCOM
		}
          } //for resultRAMA
	   }
//         }//for resultENSENANZA
	echo "		} // if (v)\n";

	echo "			function relateDOS(formName,elementNum,j) {\n";
	echo "				// relateDOS first to second (and third) menus\n";
	echo "				// ie change first menu, changes second, then change third\n";
	echo "				//\n";
	echo "				if(v){\n";
	echo "				var formNum = getFormNum(formName);\n";
	echo "				 if (formNum>=0) {\n";
	echo "					formNum++; // reference next form, assume it follows in HTML\n";
	echo "					with (document.forms[formNum].elements[elementNum]) {\n";
	echo "						for(i=options.length-1;i>0;i--) options[i] = null; // null out in reverse order (bug workarnd)\n";
	echo "							for(i=0;i<a[j].length;i++){\n";
	echo "								options[i] = new Option(a[i][i].text,a[i][i].value); \n";
	echo "							}\n";
	echo "							options[0].selected = true;\n";
	echo "						}\n";
	echo "						// change third menu\n";
	echo "						relateTRES(formName,elementNum,0,1);\n";
	echo "					}\n";
	echo "					} else {\n";
	echo "						jmp(formName,elementNum);\n";
	echo "						}\n";
	echo "				}\n";

	echo "				function relateTRES(formName,elementNum,j,fromRelateDOS) {\n";
	echo "				if(v){\n";
	echo "					var formNum = getFormNum(formName);\n";
	echo "					 if (formNum>=0) {\n";
	echo "						// find first menu's selection\n";
	echo "						// fromRelate means \"coming from relate function?\" \n";
	echo "						//   then increment formNum so k refers to first form, \n";
	echo "						//   not the nonexistent one before it (-1)\n";
	echo "						if (fromRelateDOS) formNum++; // assumes forms follow each other \n";
	echo "							k = document.forms[formNum-1].elements[elementNum].selectedIn;\n";
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
