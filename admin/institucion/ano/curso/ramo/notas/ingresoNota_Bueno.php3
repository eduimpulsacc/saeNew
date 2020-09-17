<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$_ALUMNO		=$alumno;
	if(!session_is_registered('_ALUMNO'))
		session_register('_ALUMNO');
	$docente		=5; //Codigo Docente
	$periodo		=$_PERIODORAMO;


?>
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../../../../../util/td.css" TYPE="text/css">

<script language="JavaScript" type="text/JavaScript">
		<!--
		function MM_preloadImages() { //v3.0
		  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
			var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
			if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
		}
		
		function MM_swapImgRestore() { //v3.0
		  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
		}
		
		function MM_findObj(n, d) { //v4.01
		  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
			d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
		  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
		  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
		  if(!x && d.getElementById) x=d.getElementById(n); return x;
		}
		
		function MM_swapImage() { //v3.0
		  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
		   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
		}
		//-->

/*		function fn(form,field)
		{
			var next=0, found=false
			var f=frm

			if(event.keyCode==37)  // codigo ascii de la flecha hacia la izquierda <---
			{
				for(var i=0;i<f.length;i++)	{
					if(field.name==f.item(i).name){
						next=i-1;
						found=true
						break;
					}
				}
			}
			if(event.keyCode==38)  // codigo ascii de la flecha hacia arriba 
			{
				for(var i=0;i<f.length;i++)	{
					if(field.name==f.item(i).name){
						next=i-21;
						found=true
						break;
					}
				}
			}
			if(event.keyCode==39)  // codigo ascii de la flecha hacia la derecha --->
			{
				for(var i=0;i<f.length;i++)	{
					if(field.name==f.item(i).name){
						next=i+1;
						found=true
						break;
					}
				}
			}
			if(event.keyCode==40)  // codigo ascii de la flecha hacia abajo
			{
				for(var i=0;i<f.length;i++)	{
					if(field.name==f.item(i).name){
						next=i+21;
						found=true
						break;
					}
				}
			}



			while(found){
				if( f.item(next).disabled==false &&  f.item(next).type!='hidden'){
					f.item(next).focus();
					break;
				}
				else{
					if(next<f.length-1)
						next=next+1;
					else
						break;
				}
			}
		}
*/		
		function fn(form,field,m)
		{
			var next=0, found=false, x, y, g;
			var f=frm;

			if(event.keyCode==37)  // codigo ascii de la flecha hacia la izquierda <---
			{
						next=m+1;
						found=true;
			}
			if(event.keyCode==38)  // codigo ascii de la flecha hacia arriba 
			{
						next=m-19;
						found=true
			}
			if(event.keyCode==39)  // codigo ascii de la flecha hacia la derecha --->
			{
						next=m+3;
						found=true
			}
			if(event.keyCode==40)  // codigo ascii de la flecha hacia abajo
			{
						next=m+23;
						found=true
			}


			while(found){
				if( f.item(next).disabled==false &&  f.item(next).type!='hidden'){
					f.item(next).focus();
					break;
				}
			}

		}

		
</SCRIPT>



		
		<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>

		<?php if($_MODOEVAL==1){ //EVALUACION NUMERICA?>
			<SCRIPT language="JavaScript">

				function validaNota(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!notaNroOnly(box,'Nota inválida.')) 
						return false;	
					return true;
				}

				function validaNotaConceptual(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!notaConOnly(box,'Nota inválida. Usar letras MAYUSCULAS'))
						return false;
					return true;
				}


				function round(number,X) {
					// rounds number to X decimal places, defaults to 2
					X = (!X ? 0 : X);
					return Math.round(number*Math.pow(10,X))/Math.pow(10,X);
				}

				function valida(){ 
				var trun = frm.truncado.value;
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz++) //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;

					var suma = 0;
					var cant;
					//OBTENER PROMEDIOS
					for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
						cant = 0;
						for (var xx=(ff-20);xx<(ff);xx++){
							if (document.frm.elements[xx].value!=''){
								suma=(parseInt(suma)+parseInt(document.frm.elements[xx].value));
								cant++;
							}
						}
						if(cant!=0){
							if(trun==1){
								document.frm.elements[ff].value=round((suma/cant),0);
							}else if (trun!=1){
								document.frm.elements[ff].value=parseInt((suma/cant),0);			
							}
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
					}
				}

/************       promedio prueba de nivel  de tipo numerica  ***********/
				function valida_prueba_nivel(pct_nivel){ 
				var trun = frm.truncado.value;
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz++) //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;

					var suma = 0;
					var prom=0;
					var cant;
					var prueba_nivel;
					//OBTENER PROMEDIOS
					for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
						cant = 0;
						for (var xx=(ff-20);xx<(ff-1);xx++){ // (ff-1) para k calcule hasta la nota 19
							if (document.frm.elements[xx].value!=''){
								suma=(parseInt(suma)+parseInt(document.frm.elements[xx].value));
								cant++;
							}
						}
						prueba_nivel=document.frm.elements[xx].value; 
						// calcular la nota con el porcentaje de la prueba de nivel 
						prom=(round(suma/cant)*(100-pct_nivel)/100) + (parseInt(prueba_nivel)*pct_nivel/100);
						if(cant!=0){
							if(trun==1){
								document.frm.elements[ff].value=round(prom,0);
							}else if (trun!=1){
								document.frm.elements[ff].value=parseInt(prom,0);			
							}
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
						prom=0;
					}
				}


/************       promedio prueba de nivel  de tipo conceptual  ***********/
				function valida_prueba_nivel_conceptual(pct_nivel){ 
				var trun = frm.truncado.value;
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz=zz+1){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(zz==3){
							var i=zz+19;
						}
						if(zz==i){
							if(!validaNotaConceptual(document.frm.elements[i]))
										return false;	
							i=i+21;
						}
						else{
							if(!validaNota(document.frm.elements[zz]))
										return false;
						}
					}

					var suma = 0;
					var prom=0;
					var cant;
					var nueva_nota;
					//OBTENER PROMEDIOS
					for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
						cant = 0;
						for (var xx=(ff-20);xx<(ff-1);xx++){ // (ff-1) para k calcule hasta la nota 19
							if (document.frm.elements[xx].value!=''){
								suma=(parseInt(suma)+parseInt(document.frm.elements[xx].value));
								cant++;
							}
						}
						
						if (document.frm.elements[xx].value == "MB")
							nueva_nota = 65;
						if (document.frm.elements[xx].value == "B")
							nueva_nota = 55;			
						if (document.frm.elements[xx].value == "S")
							nueva_nota = 45;
						if (document.frm.elements[xx].value == "I")
							nueva_nota = 35;						
						// calcular la nota con el porcentaje de la prueba de nivel 
						prom=((suma/cant)*(100-pct_nivel)/100) + (parseInt(nueva_nota)*pct_nivel/100);
						if(cant!=0){
							if(trun==1){
								document.frm.elements[ff].value=round(prom,0);
							}else if (trun!=1){
								document.frm.elements[ff].value=parseInt(prom,0);			
							}
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
						prom=0;
					}
				}


			</SCRIPT>
		<?php }?>

		<?php if($_MODOEVAL==2){ //EVALUACION CONCEPTUAL ?>
			<SCRIPT language="JavaScript">
				function validaNota(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!notaConOnly(box,'Nota inválida. Usar letras MAYUSCULAS'))
						return false;
					return true;
				}
		
				function validaNotaNumerica(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!notaNroOnly(box,'Nota inválida.')) 
						return false;	
					return true;
				}

				function valida(){ 
					//VALIDA NOTAS
					for (var zz=2;zz<document.frm.elements.length;zz++){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;
					}			

					var suma = 0;
					var cant;
					var nuevo;
					var prom;
					var letra = 'Z';
					//OBTENER PROMEDIOS
					for (var ff=22;ff<document.frm.elements.length;ff=ff+21){
						cant = 0;
						for (var xx=(ff-20);xx<(ff);xx++){
							if (document.frm.elements[xx].value!=''){
								if (document.frm.elements[xx].value == "MB")
									nuevo = 65;
								if (document.frm.elements[xx].value == "B")
									nuevo = 55;			
								if (document.frm.elements[xx].value == "S")
									nuevo = 45;
								if (document.frm.elements[xx].value == "I")
									nuevo = 35;						
								suma=(parseInt(suma)+parseInt(nuevo));
								cant++;
							}
						}
						if(cant!=0){
								prom = suma/cant;
								if (prom>=60 && prom<=70)
									letra = 'MB';
								if (prom>=50 && prom<=59)
									letra = 'B';
								if (prom>=40 && prom<=49)
									letra = 'S';
								if (prom>=0 && prom<=39)
									letra = 'I';
								document.frm.elements[ff].value=letra;
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
					}
				}


/************       promedio prueba de nivel  de tipo numerica  ***********/
				function valida_prueba_nivel(pct_nivel){ 
					//VALIDA NOTAS
					for (var zz=2;zz<document.frm.elements.length;zz=zz+1){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(zz==2){
							var i=zz+19;
						}
						if(zz==i){
							if(!validaNotaNumerica(document.frm.elements[i]))
										return false;	
							i=i+21;
						}
						else{
							if(!validaNota(document.frm.elements[zz]))
										return false;
						}
					}

					var suma = 0;
					var prom=0;
					var cant;
					var prueba_nivel;
					//OBTENER PROMEDIOS
					for (var ff=22;ff<document.frm.elements.length;ff=ff+21){
						cant = 0;
						for (var xx=(ff-20);xx<(ff-1);xx++){ // (ff-1) para k calcule hasta la nota 19
							if (document.frm.elements[xx].value!=''){
								if (document.frm.elements[xx].value == "MB")
									nueva_nota = 65;
								if (document.frm.elements[xx].value == "B")
									nueva_nota = 55;			
								if (document.frm.elements[xx].value == "S")
									nueva_nota = 45;
								if (document.frm.elements[xx].value == "I")
									nueva_nota = 35;						
								suma=(parseInt(suma)+parseInt(nueva_nota));
								cant++;
							}
						}
						prueba_nivel=document.frm.elements[xx].value; 
						
						// calcular la nota con el porcentaje de la prueba de nivel 
						prom=((suma/cant)*(100-pct_nivel)/100) + (parseInt(prueba_nivel)*pct_nivel/100);
						if(cant!=0){
								if (prom>=60 && prom<=70)
									letra = 'MB';
								if (prom>=50 && prom<=59)
									letra = 'B';
								if (prom>=40 && prom<=49)
									letra = 'S';
								if (prom>=0 && prom<=39)
									letra = 'I';
								document.frm.elements[ff].value=letra;
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
						prom=0;
					}
				}


/************       promedio prueba de nivel  de tipo conceptual  ***********/
				function valida_prueba_nivel_conceptual(pct_nivel){ 
					//VALIDA NOTAS
					for (var zz=2;zz<document.frm.elements.length;zz++) //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;

					var suma = 0;
					var prom=0;
					var cant;
					var nueva_nota;
					var prueba_nivel;
					var letra;
					//OBTENER PROMEDIOS
					for (var ff=22;ff<document.frm.elements.length;ff=ff+21){
						cant = 0;
						for (var xx=(ff-20);xx<(ff-1);xx++){ // (ff-1) para k calcule hasta la nota 19
							if (document.frm.elements[xx].value!=''){
								if (document.frm.elements[xx].value == "MB")
									nueva_nota = 65;
								if (document.frm.elements[xx].value == "B")
									nueva_nota = 55;			
								if (document.frm.elements[xx].value == "S")
									nueva_nota = 45;
								if (document.frm.elements[xx].value == "I")
									nueva_nota = 35;						
								suma=(parseInt(suma)+parseInt(nueva_nota));
								cant++;
							}
						}
						prueba_nivel = document.frm.elements[xx].value;
						if (prueba_nivel == "MB")
							prueba_nivel = 65;
						if (prueba_nivel == "B")
							prueba_nivel = 55;			
						if (prueba_nivel == "S")
							prueba_nivel = 45;
						if (prueba_nivel == "I")
							prueba_nivel = 35;						
						// calcular la nota con el porcentaje de la prueba de nivel 
						prom=((suma/cant)*(100-pct_nivel)/100) + (parseInt(prueba_nivel)*pct_nivel/100);
						if(cant!=0){
							if (prom>=60 && prom<=70)
								letra = 'MB';
							if (prom>=50 && prom<=59)
								letra = 'B';
							if (prom>=40 && prom<=49)
								letra = 'S';
							if (prom>=0 && prom<=39)
								letra = 'I';
							document.frm.elements[ff].value=letra;
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
						prom=0;
					}
				}

			</SCRIPT>
		<?php }?>

		<?php if($_MODOEVAL==3){ //EVALUACION NUMÉRICO CONCEPTUAL ?>
			<SCRIPT language="JavaScript">

				function validaNota(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!NotaNroPromCon(box,'Nota inválida.')) 
						return false;
					return true;
				}

				function round(number,X) {
					// rounds number to X decimal places, defaults to 2
					X = (!X ? 0 : X);
					return Math.round(number*Math.pow(10,X))/Math.pow(10,X);
				}

				function valida(){ 
					var trun = frm.truncado.value;
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz++){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;
					}			
					var suma = 0;
					var cant;
					var prom;
					var letra;
					//OBTENER PROMEDIOS
					for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
						cant = 0;
						for (var xx=(ff-20);xx<(ff);xx++){
							if (document.frm.elements[xx].value!=''){
								suma=(parseInt(suma)+parseInt(document.frm.elements[xx].value));
								cant++;
							}
						}
						if(cant!=0){
								if(trun==1){
									prom = round((suma/cant),0);
								}
								if (trun!=1){
									prom = parseInt((suma/cant),0);	
								}
								if (prom>=60 && prom<=70)
									letra = 'MB';
								if (prom>=50 && prom<=59)
									letra = 'B';
								if (prom>=40 && prom<=49)
									letra = 'S';
								if (prom>=0 && prom<=39)
									letra = 'I';
								document.frm.elements[ff].value=letra;
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
					}
				}
			</SCRIPT>
		<?php }?>


		<?php if($_MODOEVAL==4){ //EVALUACION CONCEPTUAL NUMÉRICO  ?>
			<SCRIPT language="JavaScript">

				function validaNota(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!NotaNroPromCon(box,'Nota inválida.')) 
						return false;
					return true;
				}

				function valida(){ 
					//VALIDA NOTAS
					for (var zz=2;zz<document.frm.elements.length;zz++){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;
					}			
					var suma = 0;
					var cant;
					var nueva_nota;
					var prom;
					//OBTENER PROMEDIOS
					for (var ff=22;ff<document.frm.elements.length;ff=ff+21){
						cant = 0;
						for (var xx=(ff-20);xx<(ff);xx++){
							if (document.frm.elements[xx].value!=''){
								if (document.frm.elements[xx].value == "MB")
									nueva_nota = 65;
								if (document.frm.elements[xx].value == "B")
									nueva_nota = 55;			
								if (document.frm.elements[xx].value == "S")
									nueva_nota = 45;
								if (document.frm.elements[xx].value == "I")
									nueva_nota = 35;						
								suma=(parseInt(suma)+parseInt(nueva_nota));
								cant++;
							}
						}
						if(cant!=0){
								prom = parseInt((suma/cant),0);
								if (prom>=65 && prom<=70)
									prom_nuevo = 70;
								if (prom>=60 && prom<=64)
									prom_nuevo = 60;
								if (prom>=55 && prom<=59)
									prom_nuevo = 55;
								if (prom>=50 && prom<=54)
									prom_nuevo = 50;								
								if (prom>=45 && prom<=49)
									prom_nuevo = 45;
								if (prom>=40 && prom<=44)
									prom_nuevo = 40;
								if (prom>=0 && prom<=39)
									prom_nuevo = 35;
								document.frm.elements[ff].value = prom_nuevo;			
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
					}
				}
			</SCRIPT>
		<?php }?>


	
<link href="../../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</HEAD>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){ ?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../../../periodo/listarPeriodo.php3"><img src="../../../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../feriado/listaFeriado.php3"><img src="../../../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../../planEstudio/listarPlanesEstudio.php3"><img src="../../../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../../atributos/listarTiposEnsenanza.php3"><img src="../../../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../../../botones/cursos_roll.gif" name="Image6" width="81" height="30" border="0" id="Image6"></a></td>
          <td width="81" height="30"><a href="../../../matricula/listarMatricula.php3"><img src="../../../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href=""><img src="../../../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>
<?php } ?>

	<?php //echo tope("../../../../../../util/");?>
	<FORM method=post name="frm" action="procesoIngreso.php3">
		<TABLE WIDTH=800 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													$ano_act = trim($fila1['nro_ano']);
													echo $ano_act;
													$_ANOACTUAL = $ano_act;
												
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>CURSO</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {

												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['grado_curso'])." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>SUBSECTOR</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT subsector.nombre, modo_eval, truncado, prueba_nivel, pct_nivel, modo_eval_pnivel FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila10 = @pg_fetch_array($result,0);	
												echo trim($fila10['nombre']);
												$modo_eval_p_nivel = $fila10['modo_eval_pnivel'];
											}
										?>
			<?php if ($_MODOEVAL==1 || $_MODOEVAL==3){ ?>
              <input name="truncado" type="hidden" value="<?php echo $fila10['truncado']; ?>">
			  <?php $fila10['truncado']; 
			  
			  }?>

									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>PERIODO</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$periodo;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nombre_periodo']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50">
							<TD align=right colspan=2>
							<?	if($fila10['prueba_nivel']==1 && $_MODOEVAL==1 ){	// llamar a la nueva funcion para calcular el promedio, enviar $fila10['pct_nivel']?>
							<?		if($modo_eval_p_nivel==2){	 //prueba de nivel del tipo conceptual ?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" name=btnGuardar onclick="return valida_prueba_nivel_conceptual(<? echo $fila10['pct_nivel'];?>);">&nbsp;
							<?		}else{ /*prueba de nivel del tipo numerico*/	 ?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" name=btnGuardar onclick="return valida_prueba_nivel(<? echo $fila10['pct_nivel'];?>);">&nbsp;
							<?		}	?>
							<?	}
// modificar para el tipo conceptual
								else if($fila10['prueba_nivel']==1 && $_MODOEVAL==2){	?>
							<?		if($modo_eval_p_nivel==2){	//prueba de nivel del tipo conceptual ?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" name=btnGuardar onclick="return valida_prueba_nivel_conceptual(<? echo $fila10['pct_nivel'];?>);">&nbsp;
							<?		}else{ //prueba de nivel del tipo numerico	?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" name=btnGuardar onclick="return valida_prueba_nivel(<? echo $fila10['pct_nivel'];?>);">&nbsp;
							<?		}	?>
							<?	}
								else /*if($_MODOEVAL==3 || $_MODOEVAL==4) */  {	?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" name=btnGuardar onclick="return valida();">&nbsp;
							<?	}	?>
								<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="mostrarNotas.php3">&nbsp;	
							</TD>
						</TR>
						<TR height=20 bgcolor=#003b85>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>INGRESO NOTAS</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
								<?php
									//ALUMNOS DEL CURSO
//                                    $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$ano_act.id_curso FROM (alumno INNER JOIN tiene$ano_act ON alumno.rut_alumno = tiene$ano_act.rut_alumno) WHERE tiene$ano_act.id_ramo=".$ramo."  ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
    	                                $qry="SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$ano_act.id_curso, matricula.nro_lista "; 
										$qry = $qry . " FROM alumno INNER JOIN tiene$ano_act ON alumno.rut_alumno = tiene$ano_act.rut_alumno ";
										$qry = $qry . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno ";
										$qry = $qry . " WHERE tiene$ano_act.id_ramo=".$ramo." AND matricula.id_ano=".$ano." ";
										$qry = $qry . " ORDER BY matricula.nro_lista asc, ape_pat, ape_mat, nombre_alu, rut_alumno asc";
										$result =@pg_Exec($conn,$qry);


									if(!$result)
										error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
									else{
										if(pg_numrows($result)!=0){
											$fila1 = @pg_fetch_array($result,0);
												echo "<TR>";
												echo "<TD align=center>&nbsp;";
												echo "</TD>";
												echo "<TD align=center>ALUMNO";
												echo "</TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(1º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(2º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(3º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(4º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(5º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(6º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(7º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(8º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(9º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(10º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(11º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(12º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(13º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(14º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(15º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(16º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(17º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(18º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(19º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(20º)</STRONG></FONT></TD>";
												echo "<TD align=center>PROM";
												echo "</TD>";
												echo "</TR>";

												$X=0;
												$m = 0;
												$n = 0;
											for($i=0 ; $i < @pg_numrows($result) ; $i++){
												$X++;
												$Y=0;
												$fila1 = @pg_fetch_array($result,$i);
												if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
													if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
														?>
															<TR>
														<?php
													}else{
														echo "<TR bgcolor=#ffffff>";
													}
												}else{
													echo "<TR bgcolor=#ffffff>";
												}
												echo "<TD align=left width=20>";
												echo  $fila1["nro_lista"];
												echo "</TD>";

												echo "<TD align=left width=400>";
												echo  trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_alu"]);
												echo "</TD>";

												//NOTAS ALUMNO POR RAMO Y PERIODO
												$qry2="SELECT * FROM notas$ano_act WHERE (((notas$ano_act.rut_alumno)=".$fila1['rut_alumno'].") AND ((notas$ano_act.id_periodo)=".$periodo.") AND ((notas$ano_act.id_ramo)=".$ramo."))"; 

												$result2 =@pg_Exec($conn,$qry2);
												if (!$result2) 
													error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>');
												else{
													if (pg_numrows($result2)!=0){
														$fila2 = @pg_fetch_array($result2,0);	
														if (!$fila2){
															error('<B> ERROR :</b>Error al acceder a la BD. (86)</B>');
															exit();
														};
														for($j=1;$j<22;$j++){
															$Y++;
															$fila2 = @pg_fetch_array($result2,0);
															$var="nota"."$j";
															echo "<TD align=center width=100>";
														
															$n = $n+1;
				
															if ($Y==21){
																	if ($fila10['modo_eval']==2){
																		 if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I) ){
																			echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2['promedio'])."\" size=2  maxlength=2;>";
																		  }
																		  else{
																			 echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.") size=2  maxlength=2;>";
																		  }
																	}
																	if ($fila10['modo_eval']==1){
																		  if ($fila2['promedio']!=0){ 											
																			echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2['promedio'])."\" size=2  maxlength=2;>";   
																		  }
																		  else{
																			echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.")  size=2  maxlength=2;>";
																		  }
																	}
																	if ($fila10['modo_eval']==3){
																		  if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I)){
																			echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2['promedio'])."\" size=2  maxlength=2;>";   
																		  }
																		  else{
																			echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.")  size=2  maxlength=2;>";
																		  }
																	}
																	if ($fila10['modo_eval']==4){
																		  if ($fila2['promedio']!=0){
																			echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2['promedio'])."\" size=2  maxlength=2;>";   
																		  }
																		  else{
																			echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.")  size=2  maxlength=2;>";
																		  }
																	}
															}
															else{
																	if ($fila10['modo_eval']==2){
																		 if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I) OR trim($fila2["$var"])!=0){
																				echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.")  value=\"".trim($fila2["$var"])."\" size=2  maxlength=2;>";
																		 }
																		 else{
																				echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.")  size=2  maxlength=2 >";
																		 }
																	 }
																	if ($fila10['modo_eval']==1){
																		if(!strcmp($var,'nota20')){
																			 if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){
																				echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2["$var"])."\"  size=2  maxlength=2;>";
																			 }
																			 else{
																				 if (trim($fila2["$var"])!=0){
																					echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2["$var"])."\"  size=2  maxlength=2;>";
																				 }
																				 else{
																					echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.") size=2  maxlength=2;>";
																				}
																			 }
																		}
																		else{
																			 if (trim($fila2["$var"])!=0){
																				echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2["$var"])."\"  size=2  maxlength=2;>";
																			 }
																			 else{
																				echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.") size=2  maxlength=2;>";
																			 }
																		}
																	 }
																	if ($fila10['modo_eval']==3){
																		  if (trim($fila2["$var"])!=0){
																			echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.")  value=\"".trim($fila2["$var"])."\" size=2  maxlength=2;>";
																		  }
																		  else{
																			echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.")  size=2  maxlength=2;>";
																		  }
																	}
																	if ($fila10['modo_eval']==4){
																		  if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){
																			echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.")  value=\"".trim($fila2["$var"])."\" size=2  maxlength=2;>";
																		  }
																		  else{
																			echo "<INPUT TYPE=text id=\"a[".$X."][".$Y."]\"  NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this,".$n.")  size=2  maxlength=2;>";
																		  }
																	}
															}  
															echo "\n";
															echo "</TD>";
														}  // fin for j
													}	// fin if
													else{   // CUANDO SE INSERTAN NOTAS POR PRIMERA VEZ
/*														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][1]\"  NAME=\"a[".$X."][1]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][2]\" NAME=\"a[".$X."][2]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][3]\" NAME=\"a[".$X."][3]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][4]\" NAME=\"a[".$X."][4]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][5]\" NAME=\"a[".$X."][5]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][6]\" NAME=\"a[".$X."][6]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][7]\" NAME=\"a[".$X."][7]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][8]\" NAME=\"a[".$X."][8]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][9]\" NAME=\"a[".$X."][9]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][10]\" NAME=\"a[".$X."][10]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][11]\" NAME=\"a[".$X."][11]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][12]\" NAME=\"a[".$X."][12]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][13]\" NAME=\"a[".$X."][13]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][14]\" NAME=\"a[".$X."][14]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][15]\" NAME=\"a[".$X."][15]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][16]\" NAME=\"a[".$X."][16]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][17]\" NAME=\"a[".$X."][17]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][18]\" NAME=\"a[".$X."][18]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][19]\" NAME=\"a[".$X."][19]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][20]\" NAME=\"a[".$X."][20]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][21]\" NAME=\"a[".$X."][21]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
*/
														$m = $m+1;
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a[".$X."][1]\"  NAME=\"a[".$X."][1]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][2]\" NAME=\"a[".$X."][2]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][3]\" NAME=\"a[".$X."][3]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][4]\" NAME=\"a[".$X."][4]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][5]\" NAME=\"a[".$X."][5]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][6]\" NAME=\"a[".$X."][6]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][7]\" NAME=\"a[".$X."][7]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][8]\" NAME=\"a[".$X."][8\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][9]\" NAME=\"a[".$X."][9]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][10]\" NAME=\"a[".$X."][10]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][11]\" NAME=\"a[".$X."][11]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][12]\" NAME=\"a[".$X."][12]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][13]\" NAME=\"a[".$X."][13]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][14]\" NAME=\"a[".$X."][14]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][15]\" NAME=\"a[".$X."][15]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][16]\" NAME=\"a[".$X."][16]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][17]\" NAME=\"a[".$X."][17]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][18]\" NAME=\"a[".$X."][18]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][19]\" NAME=\"a[".$X."][19]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][20]\" NAME=\"a[".$X."][20]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a[".$X."][21]\" NAME=\"a[".$X."][21]\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
														echo "</TD>";

													}
												};
										
												echo "</TD>";
												echo "</TR>";
											};

										};
									};
								?>
								</TABLE>
							</TD>
						</TR>
						<!--TR>
							<TD align=right>
								<?php 
									if($_MODOEVAL==1){ //EVALUACION NUMERICA
								?>
									<!--INPUT TYPE="button" value="PROM" name=btnPromedio onClick="document.frm.NP.value=promedio(this.form);"-->&nbsp;
								<?php }?>
							</TD>
						</TR-->
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#003b85>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
</BODY>
</HTML>