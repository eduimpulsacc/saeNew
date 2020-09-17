function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objeto AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
} 

function eliminaEspacios(cadena)
{
	// Funcion equivalente a trim en PHP
	var x=0, y=cadena.length-1;
	while(cadena.charAt(x)==" ") x++;	
	while(cadena.charAt(y)==" ") y--;	
	return cadena.substr(x, y-x+1);
}

function cargaDatos(idDiv, idInput, rut, caso, id_estudio, tipo)
{	
	/*alert("idDiv= "+idDiv);
	alert("idInput= "+ idInput);
	alert("rut = "+ rut);
	alert("caso= "+ caso);
	alert("id_estudio= "+ id_estudio);
	alert("tipo= "+ tipo);*/
	var valorInput=document.getElementById(idInput).value;
	var divError=document.getElementById("error");
	if(idDiv == "div_rut_emp"){
	//separar rut de digito verificador;		
		var miString = valorInput; 
		largo = miString.length;
		dig = largo-1;
		rut = largo-2
		rut = miString.substring(-1,rut);
		digito = miString.substring(dig);
	//fin separacion
	};		
	// Elimino todos los espacios en blanco al principio y al final de la cadena
	valorInput=eliminaEspacios(valorInput);
	
	// Valido con una expresion regular el contenido de lo que el usuario ingresa
	var reg=/(^[a-zA-Z0-9._áéíóúñ¡!¿? -@]{1,40}$)/;
	//alert("valor input= "+ valorInput);
	if(!reg.test(valorInput)) 
	{ 
		// Si hay error muestro el div que contiene el error
		divError.innerHTML="El texto ingresado no es v&aacute;lido"
		divError.style.display="block";
	}
	else
	{
		// Si no hay error oculto el div (por si se mostraba)
		divError.style.display="none";
		mostrandoInput=false;
		document.getElementById(idDiv).innerHTML=valorInput;
		
		// Creo objeto AJAX y envio peticion al servidor
		var ajax=nuevoAjax();
		if (idDiv == "div_rut_emp"){
		ajax.open("GET", "procesaEmpleado_new2.php?dato="+valorInput+"&actualizar="+idInput+"&empleado="+rut+"&caso="+caso+"&id_estudio="+digito+"&tipo="+tipo, true);
		ajax.send(null);
		window.location='seteaEmpleado.php3?empleado='+rut+'&caso=1';
		}
		else
		{
		//alert("aki");
		ajax.open("GET", "procesaEmpleado_new2.php?dato="+valorInput+"&actualizar="+idInput+"&empleado="+rut+"&caso="+caso+"&id_estudio="+id_estudio+"&tipo="+tipo, true);
		ajax.send(null);
			if(caso==2){
				if(id_estudio==0){
				window.location='empleado_new2.php?pesta=2';
				};
			};
		};
		
	}
}

var mostrandoInput=false;

/*function getKeyCode(e)
{
		e= (window.event)? event : e;
		intKey = (e.keyCode)? e.keyCode: e.charCode;
		return intKey;
}
*/
function creaInput(idDiv, idInput, rut, caso, id_estudio, tipo)
{
	/*alert("idDiv= "+idDiv);
	alert("idInput= "+idInput);
	alert("rut= "+rut);
	alert("caso= "+caso);
	alert("id_estudio= "+id_estudio);
	alert("tipo= "+tipo);*/
	
	/* Funcion encargada de cambiar el texto comun de la fila por un campo input que conserve
	el valor que tenia ese campo */
	var divError=document.getElementById("error");
	/* Solo mostramos el input si ya no esta siendo mostrado y si ademas el div del error no esta en pantalla */
	if(!mostrandoInput && divError.style.display!="block")
	{
		// Obtenemos el div contenedor del futuro input
		var divContenedor=document.getElementById(idDiv);
		// Creamos el input
		divContenedor.innerHTML="<input type='text' onBlur='cargaDatos(\""+idDiv+"\", \""+idInput+"\", \""+rut+"\",\""+caso+"\",\""+id_estudio+"\",\""+tipo+"\")' value='"+divContenedor.innerHTML+"' id='"+idInput+"' maxlength='100'>";
		// Colocamos el cursor en el input creado
		document.getElementById(idInput).focus();
		document.getElementById(idInput).select();
		// Establecemos a true la variable para especificar que hay un input en pantalla y no se debe crear otro hasta que este se oculte
		mostrandoInput=true;
	}
}
function cargaContenido(idSelectOrigen, rut, caso, id_estudio, tipo, cont)
{
	/*alert("id_seleccion ="+ idSelectOrigen);
	alert("rut= "+rut);
	alert("caso= "+caso);
	alert("id_estudio= "+id_estudio);
	alert("tipo= "+tipo);
	alert("con"+cont);*/
	var aut="cmb_tipo_aut"+cont;
	var cargo="cargo"+cont;
	var subsec="cmb_subsector"+cont;
	//alert("subsec= "+subsec);
	
	var Select=document.getElementById(idSelectOrigen)
	if(tipo==24){
		var selectOrigen="tipo_aut";
		var idSelect=selectOrigen;
	}else if(tipo==25){
		var selectOrigen="cod_subsector";
		var idSelect=selectOrigen;
	}else{
		var selectOrigen=document.getElementById(idSelectOrigen);
		var idSelect=idSelectOrigen;
	}
		
	// Obtengo la opcion que el usuario selecciono
	var opcionSeleccionada=Select.options[Select.selectedIndex].value;
	//alert("campo= "+selectOrigen);
	/*alert("seleccion= "+ opcionSeleccionada);
	alert("actualizar="+idSelect);*/
	if(opcionSeleccionada==0)
	{
		alert("Debe selecccionar "+idSelectOrigen);
		
	}
	// Compruebo que el select modificado no sea el ultimo de la cadena
	else 
	{
		var ajax=nuevoAjax();
		ajax.open("GET", "procesaEmpleado_new2.php?actualizar="+idSelect+"&dato="+opcionSeleccionada+"&empleado="+rut+"&caso="+caso+"&id_estudio="+id_estudio+"&tipo="+tipo, true);
		ajax.send("dato="+opcionSeleccionada);
		//ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		  
  		
  		/*var param = "cod="+opcionSeleccionada;
		alert("param="+param);
		var myAjax = new nuevoAjax.Updater('nac1','http://colegiointeractivo.cl/sae3.0/admin/institucion/empleado/ajax/consultas_empleado.php',{method: 'get', parameters: param});   	
*/	  
	
		switch(idSelectOrigen)
		{
			case "comuna":
			var capa=document.getElementById("nom_com");
			var capa_com=document.getElementById("cod_com")
			var reg=document.getElementById("cod_reg").innerHTML;
			var pro=document.getElementById("cod_pro").innerHTML;
			if(opcionSeleccionada=='1' && reg=='1' && pro=='1'){
					capa.innerHTML='IQUIQUE ';
			}else if(opcionSeleccionada=='2' && reg=='1' && pro=='1'){
					capa.innerHTML='CAMINA ';
			}else if(opcionSeleccionada=='3' && reg=='1' && pro=='1'){
					capa.innerHTML='COLCHANE ';
			}else if(opcionSeleccionada=='4' && reg=='1' && pro=='1'){
					capa.innerHTML='HUARA ';
			}else if(opcionSeleccionada=='5' && reg=='1' && pro=='1'){
					capa.innerHTML='PICA ';
			}else if(opcionSeleccionada=='6' && reg=='1' && pro=='1'){
					capa.innerHTML='POZO ALMONTE ';
			}else if(opcionSeleccionada=='1' && reg=='1' && pro=='2'){
					capa.innerHTML='ARICA ';
			}else if(opcionSeleccionada=='2' && reg=='1' && pro=='2'){
					capa.innerHTML='CAMARONES ';
			}else if(opcionSeleccionada=='1' && reg=='1' && pro=='3'){
					capa.innerHTML='PUTRE ';
			}else if(opcionSeleccionada=='2' && reg=='1' && pro=='3'){
					capa.innerHTML='GENERAL LAGOS ';
			}else if(opcionSeleccionada=='1' && reg=='2' && pro=='1'){
					capa.innerHTML='ANTOFAGASTA ';
			}else if(opcionSeleccionada=='2' && reg=='2' && pro=='1'){
					capa.innerHTML='MEJILLONES ';
			}else if(opcionSeleccionada=='3' && reg=='2' && pro=='1'){
					capa.innerHTML='SIERRA GORDA ';
			}else if(opcionSeleccionada=='4' && reg=='2' && pro=='1'){
					capa.innerHTML='TALTAL ';
			}else if(opcionSeleccionada=='1' && reg=='2' && pro=='2'){
					capa.innerHTML='CALAMA ';
			}else if(opcionSeleccionada=='2' && reg=='2' && pro=='2'){
					capa.innerHTML='OLLAGUE ';
			}else if(opcionSeleccionada=='3' && reg=='2' && pro=='2'){
					capa.innerHTML='SAN PEDRO DE ATACAMA ';
			}else if(opcionSeleccionada=='1' && reg=='2' && pro=='3'){
					capa.innerHTML='TOCOPILLA ';
			}else if(opcionSeleccionada=='2' && reg=='2' && pro=='3'){
					capa.innerHTML='MARIA ELENA ';
			}else if(opcionSeleccionada=='1' && reg=='3' && pro=='1'){
					capa.innerHTML='COPIAPO ';
			}else if(opcionSeleccionada=='2' && reg=='3' && pro=='1'){
					capa.innerHTML='CALDERA ';
			}else if(opcionSeleccionada=='3' && reg=='3' && pro=='1'){
					capa.innerHTML='TIERRA AMARILLA ';
			}else if(opcionSeleccionada=='1' && reg=='3' && pro=='2'){
					capa.innerHTML='CHANARAL ';
			}else if(opcionSeleccionada=='2' && reg=='3' && pro=='2'){
					capa.innerHTML='DIEGO DE ALMAGRO ';
			}else if(opcionSeleccionada=='1' && reg=='3' && pro=='3'){
					capa.innerHTML='VALLENAR ';
			}else if(opcionSeleccionada=='2' && reg=='3' && pro=='3'){
					capa.innerHTML='ALTO DEL CARMEN ';
			}else if(opcionSeleccionada=='3' && reg=='3' && pro=='3'){
					capa.innerHTML='FREIRINA ';
			}else if(opcionSeleccionada=='4' && reg=='3' && pro=='3'){
					capa.innerHTML='HUASCO ';
			}else if(opcionSeleccionada=='1' && reg=='4' && pro=='1'){
					capa.innerHTML='LA SERENA ';
			}else if(opcionSeleccionada=='2' && reg=='4' && pro=='1'){
					capa.innerHTML='COQUIMBO ';
			}else if(opcionSeleccionada=='3' && reg=='4' && pro=='1'){
					capa.innerHTML='ANDACOLLO ';
			}else if(opcionSeleccionada=='4' && reg=='4' && pro=='1'){
					capa.innerHTML='LA HIGUERA ';
			}else if(opcionSeleccionada=='5' && reg=='4' && pro=='1'){
					capa.innerHTML='PAIHUANO ';
			}else if(opcionSeleccionada=='6' && reg=='4' && pro=='1'){
					capa.innerHTML='VICUNA ';
			}else if(opcionSeleccionada=='1' && reg=='4' && pro=='2'){
					capa.innerHTML='ILLAPEL ';
			}else if(opcionSeleccionada=='2' && reg=='4' && pro=='2'){
					capa.innerHTML='CANELA ';
			}else if(opcionSeleccionada=='3' && reg=='4' && pro=='2'){
					capa.innerHTML='LOS VILOS ';
			}else if(opcionSeleccionada=='4' && reg=='4' && pro=='2'){
					capa.innerHTML='SALAMANCA ';
			}else if(opcionSeleccionada=='1' && reg=='4' && pro=='3'){
					capa.innerHTML='OVALLE ';
			}else if(opcionSeleccionada=='2' && reg=='4' && pro=='3'){
					capa.innerHTML='COMBARBALA ';
			}else if(opcionSeleccionada=='3' && reg=='4' && pro=='3'){
					capa.innerHTML='MONTE PATRIA ';
			}else if(opcionSeleccionada=='4' && reg=='4' && pro=='3'){
					capa.innerHTML='PUNITAQUI ';
			}else if(opcionSeleccionada=='5' && reg=='4' && pro=='3'){
					capa.innerHTML='RIO HURTADO ';
			}else if(opcionSeleccionada=='2' && reg=='5' && pro=='1'){
					capa.innerHTML='CASABLANCA ';
			}else if(opcionSeleccionada=='3' && reg=='5' && pro=='1'){
					capa.innerHTML='CONCON ';
			}else if(opcionSeleccionada=='4' && reg=='5' && pro=='1'){
					capa.innerHTML='JUAN FERNANDEZ ';
			}else if(opcionSeleccionada=='5' && reg=='5' && pro=='1'){
					capa.innerHTML='PUCHUNCAVI ';
			}else if(opcionSeleccionada=='23' && reg=='13' && pro=='1'){
					capa.innerHTML='PROVIDENCIA ';
			}else if(opcionSeleccionada=='7' && reg=='5' && pro=='1'){
					capa.innerHTML='QUINTERO ';
			}else if(opcionSeleccionada=='8' && reg=='5' && pro=='1'){
					capa.innerHTML='VILLA ALEMANA ';
			}else if(opcionSeleccionada=='9' && reg=='5' && pro=='1'){
					capa.innerHTML='VINA DEL MAR ';
			}else if(opcionSeleccionada=='1' && reg=='5' && pro=='2'){
					capa.innerHTML='ISLA DE PASCUA ';
			}else if(opcionSeleccionada=='1' && reg=='5' && pro=='3'){
					capa.innerHTML='LOS ANDES ';
			}else if(opcionSeleccionada=='2' && reg=='5' && pro=='3'){
					capa.innerHTML='CALLE LARGA ';
			}else if(opcionSeleccionada=='3' && reg=='5' && pro=='3'){
					capa.innerHTML='RINCONADA ';
			}else if(opcionSeleccionada=='4' && reg=='5' && pro=='3'){
					capa.innerHTML='SAN ESTEBAN ';
			}else if(opcionSeleccionada=='1' && reg=='5' && pro=='4'){
					capa.innerHTML='LA LIGUA ';
			}else if(opcionSeleccionada=='2' && reg=='5' && pro=='4'){
					capa.innerHTML='CABILDO ';
			}else if(opcionSeleccionada=='3' && reg=='5' && pro=='4'){
					capa.innerHTML='PAPUDO ';
			}else if(opcionSeleccionada=='4' && reg=='5' && pro=='4'){
					capa.innerHTML='PETORCA ';
			}else if(opcionSeleccionada=='5' && reg=='5' && pro=='4'){
					capa.innerHTML='ZAPALLAR ';
			}else if(opcionSeleccionada=='1' && reg=='5' && pro=='5'){
					capa.innerHTML='QUILLOTA ';
			}else if(opcionSeleccionada=='2' && reg=='5' && pro=='5'){
					capa.innerHTML='LA CALERA ';
			}else if(opcionSeleccionada=='3' && reg=='5' && pro=='5'){
					capa.innerHTML='HIJUELAS ';
			}else if(opcionSeleccionada=='4' && reg=='5' && pro=='5'){
					capa.innerHTML='LA CRUZ ';
			}else if(opcionSeleccionada=='5' && reg=='5' && pro=='5'){
					capa.innerHTML='LIMACHE ';
			}else if(opcionSeleccionada=='6' && reg=='5' && pro=='5'){
					capa.innerHTML='NOGALES ';
			}else if(opcionSeleccionada=='7' && reg=='5' && pro=='5'){
					capa.innerHTML='OLMUE ';
			}else if(opcionSeleccionada=='1' && reg=='5' && pro=='6'){
					capa.innerHTML='SAN ANTONIO ';
			}else if(opcionSeleccionada=='2' && reg=='5' && pro=='6'){
					capa.innerHTML='ALGARROBO ';
			}else if(opcionSeleccionada=='3' && reg=='5' && pro=='6'){
					capa.innerHTML='CARTAGENA ';
			}else if(opcionSeleccionada=='4' && reg=='5' && pro=='6'){
					capa.innerHTML='EL QUISCO ';
			}else if(opcionSeleccionada=='5' && reg=='5' && pro=='6'){
					capa.innerHTML='EL TABO ';
			}else if(opcionSeleccionada=='6' && reg=='5' && pro=='6'){
					capa.innerHTML='SANTO DOMINGO ';
			}else if(opcionSeleccionada=='1' && reg=='5' && pro=='7'){
					capa.innerHTML='SAN FELIPE ';
			}else if(opcionSeleccionada=='2' && reg=='5' && pro=='7'){
					capa.innerHTML='CATEMU ';
			}else if(opcionSeleccionada=='3' && reg=='5' && pro=='7'){
					capa.innerHTML='LLAY LLAY ';
			}else if(opcionSeleccionada=='4' && reg=='5' && pro=='7'){
					capa.innerHTML='PANQUEHUE ';
			}else if(opcionSeleccionada=='5' && reg=='5' && pro=='7'){
					capa.innerHTML='PUTAENDO ';
			}else if(opcionSeleccionada=='6' && reg=='5' && pro=='7'){
					capa.innerHTML='SANTA MARIA ';
			}else if(opcionSeleccionada=='1' && reg=='6' && pro=='1'){
					capa.innerHTML='RANCAGUA ';
			}else if(opcionSeleccionada=='2' && reg=='6' && pro=='1'){
					capa.innerHTML='CODEGUA ';
			}else if(opcionSeleccionada=='3' && reg=='6' && pro=='1'){
					capa.innerHTML='COINCO ';
			}else if(opcionSeleccionada=='4' && reg=='6' && pro=='1'){
					capa.innerHTML='COLTAUCO ';
			}else if(opcionSeleccionada=='5' && reg=='6' && pro=='1'){
					capa.innerHTML='DONIHUE ';
			}else if(opcionSeleccionada=='6' && reg=='6' && pro=='1'){
					capa.innerHTML='GRANEROS ';
			}else if(opcionSeleccionada=='7' && reg=='6' && pro=='1'){
					capa.innerHTML='LAS CABRAS ';
			}else if(opcionSeleccionada=='8' && reg=='6' && pro=='1'){
					capa.innerHTML='MACHALI ';
			}else if(opcionSeleccionada=='9' && reg=='6' && pro=='1'){
					capa.innerHTML='MALLOA ';
			}else if(opcionSeleccionada=='10' && reg=='6' && pro=='1'){
					capa.innerHTML='MOSTAZAL ';
			}else if(opcionSeleccionada=='11' && reg=='6' && pro=='1'){
					capa.innerHTML='OLIVAR ';
			}else if(opcionSeleccionada=='12' && reg=='6' && pro=='1'){
					capa.innerHTML='PEUMO ';
			}else if(opcionSeleccionada=='13' && reg=='6' && pro=='1'){
					capa.innerHTML='PICHIDEGUA ';
			}else if(opcionSeleccionada=='14' && reg=='6' && pro=='1'){
					capa.innerHTML='QUINTA DE TILCOCO ';
			}else if(opcionSeleccionada=='15' && reg=='6' && pro=='1'){
					capa.innerHTML='RENGO ';
			}else if(opcionSeleccionada=='16' && reg=='6' && pro=='1'){
					capa.innerHTML='REQUINOA ';
			}else if(opcionSeleccionada=='17' && reg=='6' && pro=='1'){
					capa.innerHTML='SAN VICENTE ';
			}else if(opcionSeleccionada=='1' && reg=='6' && pro=='2'){
					capa.innerHTML='PICHILEMU ';
			}else if(opcionSeleccionada=='2' && reg=='6' && pro=='2'){
					capa.innerHTML='LA ESTRELLA ';
			}else if(opcionSeleccionada=='3' && reg=='6' && pro=='2'){
					capa.innerHTML='LITUECHE ';
			}else if(opcionSeleccionada=='4' && reg=='6' && pro=='2'){
					capa.innerHTML='MARCHIHUE ';
			}else if(opcionSeleccionada=='5' && reg=='6' && pro=='2'){
					capa.innerHTML='NAVIDAD ';
			}else if(opcionSeleccionada=='6' && reg=='6' && pro=='2'){
					capa.innerHTML='PAREDONES ';
			}else if(opcionSeleccionada=='1' && reg=='6' && pro=='3'){
					capa.innerHTML='SAN FERNANDO ';
			}else if(opcionSeleccionada=='2' && reg=='6' && pro=='3'){
					capa.innerHTML='CHEPICA ';
			}else if(opcionSeleccionada=='3' && reg=='6' && pro=='3'){
					capa.innerHTML='CHIMBARONGO ';
			}else if(opcionSeleccionada=='4' && reg=='6' && pro=='3'){
					capa.innerHTML='LOLOL ';
			}else if(opcionSeleccionada=='5' && reg=='6' && pro=='3'){
					capa.innerHTML='NANCAGUA ';
			}else if(opcionSeleccionada=='6' && reg=='6' && pro=='3'){
					capa.innerHTML='PALMILLA ';
			}else if(opcionSeleccionada=='7' && reg=='6' && pro=='3'){
					capa.innerHTML='PERALILLO ';
			}else if(opcionSeleccionada=='8' && reg=='6' && pro=='3'){
					capa.innerHTML='PLACILLA ';
			}else if(opcionSeleccionada=='9' && reg=='6' && pro=='3'){
					capa.innerHTML='PUMANQUE ';
			}else if(opcionSeleccionada=='10' && reg=='6' && pro=='3'){
					capa.innerHTML='SANTA CRUZ ';
			}else if(opcionSeleccionada=='1' && reg=='7' && pro=='1'){
					capa.innerHTML='TALCA ';
			}else if(opcionSeleccionada=='2' && reg=='7' && pro=='1'){
					capa.innerHTML='CONSTITUCION ';
			}else if(opcionSeleccionada=='3' && reg=='7' && pro=='1'){
					capa.innerHTML='CUREPTO ';
			}else if(opcionSeleccionada=='4' && reg=='7' && pro=='1'){
					capa.innerHTML='EMPEDRADO ';
			}else if(opcionSeleccionada=='5' && reg=='7' && pro=='1'){
					capa.innerHTML='MAULE ';
			}else if(opcionSeleccionada=='6' && reg=='7' && pro=='1'){
					capa.innerHTML='PELARCO ';
			}else if(opcionSeleccionada=='7' && reg=='7' && pro=='1'){
					capa.innerHTML='PENCAHUE ';
			}else if(opcionSeleccionada=='8' && reg=='7' && pro=='1'){
					capa.innerHTML='RIO CLARO ';
			}else if(opcionSeleccionada=='9' && reg=='7' && pro=='1'){
					capa.innerHTML='SAN CLEMENTE ';
			}else if(opcionSeleccionada=='1' && reg=='7' && pro=='2'){
					capa.innerHTML='CAUQUENES ';
			}else if(opcionSeleccionada=='2' && reg=='7' && pro=='2'){
					capa.innerHTML='CHANCO ';
			}else if(opcionSeleccionada=='3' && reg=='7' && pro=='2'){
					capa.innerHTML='PELLUHUE ';
			}else if(opcionSeleccionada=='1' && reg=='7' && pro=='3'){
					capa.innerHTML='CURICO ';
			}else if(opcionSeleccionada=='2' && reg=='7' && pro=='3'){
					capa.innerHTML='HUALANE ';
			}else if(opcionSeleccionada=='3' && reg=='7' && pro=='3'){
					capa.innerHTML='LICANTEN ';
			}else if(opcionSeleccionada=='4' && reg=='7' && pro=='3'){
					capa.innerHTML='MOLINA ';
			}else if(opcionSeleccionada=='5' && reg=='7' && pro=='3'){
					capa.innerHTML='RAUCO ';
			}else if(opcionSeleccionada=='6' && reg=='7' && pro=='3'){
					capa.innerHTML='ROMERAL ';
			}else if(opcionSeleccionada=='7' && reg=='7' && pro=='3'){
					capa.innerHTML='SAGRADA FAMILIA ';
			}else if(opcionSeleccionada=='8' && reg=='7' && pro=='3'){
					capa.innerHTML='TENO ';
			}else if(opcionSeleccionada=='9' && reg=='7' && pro=='3'){
					capa.innerHTML='VICHUQUEN ';
			}else if(opcionSeleccionada=='1' && reg=='7' && pro=='4'){
					capa.innerHTML='LINARES ';
			}else if(opcionSeleccionada=='2' && reg=='7' && pro=='4'){
					capa.innerHTML='COLBUN ';
			}else if(opcionSeleccionada=='3' && reg=='7' && pro=='4'){
					capa.innerHTML='LONGAVI ';
			}else if(opcionSeleccionada=='4' && reg=='7' && pro=='4'){
					capa.innerHTML='PARRAL ';
			}else if(opcionSeleccionada=='5' && reg=='7' && pro=='4'){
					capa.innerHTML='RETIRO ';
			}else if(opcionSeleccionada=='6' && reg=='7' && pro=='4'){
					capa.innerHTML='SAN JAVIER ';
			}else if(opcionSeleccionada=='7' && reg=='7' && pro=='4'){
					capa.innerHTML='VILLA ALEGRE ';
			}else if(opcionSeleccionada=='8' && reg=='7' && pro=='4'){
					capa.innerHTML='YERBAS BUENAS ';
			}else if(opcionSeleccionada=='10' && reg=='7' && pro=='1'){
					capa.innerHTML='SAN RAFAEL ';
			}else if(opcionSeleccionada=='1' && reg=='8' && pro=='1'){
					capa.innerHTML='CONCEPCION ';
			}else if(opcionSeleccionada=='2' && reg=='8' && pro=='1'){
					capa.innerHTML='CORONEL ';
			}else if(opcionSeleccionada=='3' && reg=='8' && pro=='1'){
					capa.innerHTML='CHIGUAYANTE ';
			}else if(opcionSeleccionada=='4' && reg=='8' && pro=='1'){
					capa.innerHTML='FLORIDA ';
			}else if(opcionSeleccionada=='5' && reg=='8' && pro=='1'){
					capa.innerHTML='HUALQUI ';
			}else if(opcionSeleccionada=='6' && reg=='8' && pro=='1'){
					capa.innerHTML='LOTA ';
			}else if(opcionSeleccionada=='7' && reg=='8' && pro=='1'){
					capa.innerHTML='PENCO ';
			}else if(opcionSeleccionada=='8' && reg=='8' && pro=='1'){
					capa.innerHTML='SAN PEDRO DE LA PAZ ';
			}else if(opcionSeleccionada=='9' && reg=='8' && pro=='1'){
					capa.innerHTML='SANTA JUANA ';
			}else if(opcionSeleccionada=='10' && reg=='8' && pro=='1'){
					capa.innerHTML='TALCAHUANO ';
			}else if(opcionSeleccionada=='11' && reg=='8' && pro=='1'){
					capa.innerHTML='TOME ';
			}else if(opcionSeleccionada=='1' && reg=='8' && pro=='2'){
					capa.innerHTML='LEBU ';
			}else if(opcionSeleccionada=='2' && reg=='8' && pro=='2'){
					capa.innerHTML='ARAUCO ';
			}else if(opcionSeleccionada=='3' && reg=='8' && pro=='2'){
					capa.innerHTML='CANETE ';
			}else if(opcionSeleccionada=='4' && reg=='8' && pro=='2'){
					capa.innerHTML='CONTULMO ';
			}else if(opcionSeleccionada=='5' && reg=='8' && pro=='2'){
					capa.innerHTML='CURANILAHUE ';
			}else if(opcionSeleccionada=='6' && reg=='8' && pro=='2'){
					capa.innerHTML='LOS ALAMOS ';
			}else if(opcionSeleccionada=='7' && reg=='8' && pro=='2'){
					capa.innerHTML='TIRUA ';
			}else if(opcionSeleccionada=='1' && reg=='8' && pro=='3'){
					capa.innerHTML='LOS ANGELES ';
			}else if(opcionSeleccionada=='2' && reg=='8' && pro=='3'){
					capa.innerHTML='ANTUCO ';
			}else if(opcionSeleccionada=='3' && reg=='8' && pro=='3'){
					capa.innerHTML='CABRERO ';
			}else if(opcionSeleccionada=='4' && reg=='8' && pro=='3'){
					capa.innerHTML='LAJA ';
			}else if(opcionSeleccionada=='5' && reg=='8' && pro=='3'){
					capa.innerHTML='MULCHEN ';
			}else if(opcionSeleccionada=='6' && reg=='8' && pro=='3'){
					capa.innerHTML='NACIMIENTO ';
			}else if(opcionSeleccionada=='7' && reg=='8' && pro=='3'){
					capa.innerHTML='NEGRETE ';
			}else if(opcionSeleccionada=='8' && reg=='8' && pro=='3'){
					capa.innerHTML='QUILACO ';
			}else if(opcionSeleccionada=='9' && reg=='8' && pro=='3'){
					capa.innerHTML='QUILLECO ';
			}else if(opcionSeleccionada=='10' && reg=='8' && pro=='3'){
					capa.innerHTML='SAN ROSENDO ';
			}else if(opcionSeleccionada=='11' && reg=='8' && pro=='3'){
					capa.innerHTML='SANTA BARBARA ';
			}else if(opcionSeleccionada=='12' && reg=='8' && pro=='3'){
					capa.innerHTML='TUCAPEL ';
			}else if(opcionSeleccionada=='13' && reg=='8' && pro=='3'){
					capa.innerHTML='YUMBEL ';
			}else if(opcionSeleccionada=='1' && reg=='8' && pro=='4'){
					capa.innerHTML='CHILLAN ';
			}else if(opcionSeleccionada=='2' && reg=='8' && pro=='4'){
					capa.innerHTML='BULNES ';
			}else if(opcionSeleccionada=='3' && reg=='8' && pro=='4'){
					capa.innerHTML='COBQUECURA ';
			}else if(opcionSeleccionada=='4' && reg=='8' && pro=='4'){
					capa.innerHTML='COELEMU ';
			}else if(opcionSeleccionada=='5' && reg=='8' && pro=='4'){
					capa.innerHTML='COIHUECO ';
			}else if(opcionSeleccionada=='6' && reg=='8' && pro=='4'){
					capa.innerHTML='CHILLAN VIEJO ';
			}else if(opcionSeleccionada=='7' && reg=='8' && pro=='4'){
					capa.innerHTML='EL CARMEN ';
			}else if(opcionSeleccionada=='8' && reg=='8' && pro=='4'){
					capa.innerHTML='NINHUE ';
			}else if(opcionSeleccionada=='9' && reg=='8' && pro=='4'){
					capa.innerHTML='NIQUEN ';
			}else if(opcionSeleccionada=='10' && reg=='8' && pro=='4'){
					capa.innerHTML='PEMUCO ';
			}else if(opcionSeleccionada=='11' && reg=='8' && pro=='4'){
					capa.innerHTML='PINTO ';
			}else if(opcionSeleccionada=='12' && reg=='8' && pro=='4'){
					capa.innerHTML='PORTEZUELO ';
			}else if(opcionSeleccionada=='13' && reg=='8' && pro=='4'){
					capa.innerHTML='QUILLON ';
			}else if(opcionSeleccionada=='14' && reg=='8' && pro=='4'){
					capa.innerHTML='QUIRIHUE ';
			}else if(opcionSeleccionada=='15' && reg=='8' && pro=='4'){
					capa.innerHTML='RANQUIL ';
			}else if(opcionSeleccionada=='16' && reg=='8' && pro=='4'){
					capa.innerHTML='SAN CARLOS ';
			}else if(opcionSeleccionada=='17' && reg=='8' && pro=='4'){
					capa.innerHTML='SAN FABIAN ';
			}else if(opcionSeleccionada=='18' && reg=='8' && pro=='4'){
					capa.innerHTML='SAN IGNACIO ';
			}else if(opcionSeleccionada=='19' && reg=='8' && pro=='4'){
					capa.innerHTML='SAN NICOLAS ';
			}else if(opcionSeleccionada=='20' && reg=='8' && pro=='4'){
					capa.innerHTML='TREHUACO ';
			}else if(opcionSeleccionada=='21' && reg=='8' && pro=='4'){
					capa.innerHTML='YUNGAY ';
			}else if(opcionSeleccionada=='1' && reg=='9' && pro=='1'){
					capa.innerHTML='TEMUCO ';
			}else if(opcionSeleccionada=='2' && reg=='9' && pro=='1'){
					capa.innerHTML='CARAHUE ';
			}else if(opcionSeleccionada=='3' && reg=='9' && pro=='1'){
					capa.innerHTML='CUNCO ';
			}else if(opcionSeleccionada=='4' && reg=='9' && pro=='1'){
					capa.innerHTML='CURARREHUE ';
			}else if(opcionSeleccionada=='5' && reg=='9' && pro=='1'){
					capa.innerHTML='FREIRE ';
			}else if(opcionSeleccionada=='6' && reg=='9' && pro=='1'){
					capa.innerHTML='GALVARINO ';
			}else if(opcionSeleccionada=='7' && reg=='9' && pro=='1'){
					capa.innerHTML='GORBEA ';
			}else if(opcionSeleccionada=='8' && reg=='9' && pro=='1'){
					capa.innerHTML='LAUTARO ';
			}else if(opcionSeleccionada=='9' && reg=='9' && pro=='1'){
					capa.innerHTML='LONCOCHE ';
			}else if(opcionSeleccionada=='10' && reg=='9' && pro=='1'){
					capa.innerHTML='MELIPEUCO ';
			}else if(opcionSeleccionada=='11' && reg=='9' && pro=='1'){
					capa.innerHTML='NUEVA IMPERIAL ';
			}else if(opcionSeleccionada=='12' && reg=='9' && pro=='1'){
					capa.innerHTML='PADRE LAS CASAS ';
			}else if(opcionSeleccionada=='13' && reg=='9' && pro=='1'){
					capa.innerHTML='PERQUENCO ';
			}else if(opcionSeleccionada=='14' && reg=='9' && pro=='1'){
					capa.innerHTML='PITRUFQUEN ';
			}else if(opcionSeleccionada=='15' && reg=='9' && pro=='1'){
					capa.innerHTML='PUCON ';
			}else if(opcionSeleccionada=='16' && reg=='9' && pro=='1'){
					capa.innerHTML='SAAVEDRA ';
			}else if(opcionSeleccionada=='17' && reg=='9' && pro=='1'){
					capa.innerHTML='TEODORO SCHMIDT ';
			}else if(opcionSeleccionada=='18' && reg=='9' && pro=='1'){
					capa.innerHTML='TOLTEN ';
			}else if(opcionSeleccionada=='19' && reg=='9' && pro=='1'){
					capa.innerHTML='VILCUN ';
			}else if(opcionSeleccionada=='20' && reg=='9' && pro=='1'){
					capa.innerHTML='VILLARRICA ';
			}else if(opcionSeleccionada=='1' && reg=='9' && pro=='2'){
					capa.innerHTML='ANGOL ';
			}else if(opcionSeleccionada=='2' && reg=='9' && pro=='2'){
					capa.innerHTML='COLLIPULLI ';
			}else if(opcionSeleccionada=='3' && reg=='9' && pro=='2'){
					capa.innerHTML='CURACAUTIN ';
			}else if(opcionSeleccionada=='4' && reg=='9' && pro=='2'){
					capa.innerHTML='ERCILLA ';
			}else if(opcionSeleccionada=='5' && reg=='9' && pro=='2'){
					capa.innerHTML='LONQUIMAY ';
			}else if(opcionSeleccionada=='6' && reg=='9' && pro=='2'){
					capa.innerHTML='LOS SAUCES ';
			}else if(opcionSeleccionada=='7' && reg=='9' && pro=='2'){
					capa.innerHTML='LUMACO ';
			}else if(opcionSeleccionada=='8' && reg=='9' && pro=='2'){
					capa.innerHTML='PUREN ';
			}else if(opcionSeleccionada=='9' && reg=='9' && pro=='2'){
					capa.innerHTML='RENAICO ';
			}else if(opcionSeleccionada=='10' && reg=='9' && pro=='2'){
					capa.innerHTML='TRAIGUEN ';
			}else if(opcionSeleccionada=='11' && reg=='9' && pro=='2'){
					capa.innerHTML='VICTORIA ';
			}else if(opcionSeleccionada=='1' && reg=='10' && pro=='1'){
					capa.innerHTML='PUERTO MONTT ';
			}else if(opcionSeleccionada=='2' && reg=='10' && pro=='1'){
					capa.innerHTML='CALBUCO ';
			}else if(opcionSeleccionada=='3' && reg=='10' && pro=='1'){
					capa.innerHTML='COCHAMO ';
			}else if(opcionSeleccionada=='4' && reg=='10' && pro=='1'){
					capa.innerHTML='FRESIA ';
			}else if(opcionSeleccionada=='5' && reg=='10' && pro=='1'){
					capa.innerHTML='FRUTILLAR ';
			}else if(opcionSeleccionada=='6' && reg=='10' && pro=='1'){
					capa.innerHTML='LOS MUERMOS ';
			}else if(opcionSeleccionada=='7' && reg=='10' && pro=='1'){
					capa.innerHTML='LLANQUIHUE ';
			}else if(opcionSeleccionada=='8' && reg=='10' && pro=='1'){
					capa.innerHTML='MAULLIN ';
			}else if(opcionSeleccionada=='9' && reg=='10' && pro=='1'){
					capa.innerHTML='PUERTO VARAS ';
			}else if(opcionSeleccionada=='1' && reg=='10' && pro=='2'){
					capa.innerHTML='CASTRO ';
			}else if(opcionSeleccionada=='2' && reg=='10' && pro=='2'){
					capa.innerHTML='ANCUD ';
			}else if(opcionSeleccionada=='3' && reg=='10' && pro=='2'){
					capa.innerHTML='CHONCHI ';
			}else if(opcionSeleccionada=='4' && reg=='10' && pro=='2'){
					capa.innerHTML='CURACO DE VELEZ ';
			}else if(opcionSeleccionada=='5' && reg=='10' && pro=='2'){
					capa.innerHTML='DALCAHUE ';
			}else if(opcionSeleccionada=='6' && reg=='10' && pro=='2'){
					capa.innerHTML='PUQUELDON ';
			}else if(opcionSeleccionada=='7' && reg=='10' && pro=='2'){
					capa.innerHTML='QUEILEN ';
			}else if(opcionSeleccionada=='8' && reg=='10' && pro=='2'){
					capa.innerHTML='QUELLÓN ';
			}else if(opcionSeleccionada=='9' && reg=='10' && pro=='2'){
					capa.innerHTML='QUEMCHI ';
			}else if(opcionSeleccionada=='10' && reg=='10' && pro=='2'){
					capa.innerHTML='QUINCHAO ';
			}else if(opcionSeleccionada=='1' && reg=='10' && pro=='3'){
					capa.innerHTML='OSORNO ';
			}else if(opcionSeleccionada=='2' && reg=='10' && pro=='3'){
					capa.innerHTML='PUERTO OCTAY ';
			}else if(opcionSeleccionada=='3' && reg=='10' && pro=='3'){
					capa.innerHTML='PURRANQUE ';
			}else if(opcionSeleccionada=='4' && reg=='10' && pro=='3'){
					capa.innerHTML='PUYEHUE ';
			}else if(opcionSeleccionada=='5' && reg=='10' && pro=='3'){
					capa.innerHTML='RIO NEGRO ';
			}else if(opcionSeleccionada=='6' && reg=='10' && pro=='3'){
					capa.innerHTML='SAN JUAN DE LA COSTA ';
			}else if(opcionSeleccionada=='7' && reg=='10' && pro=='3'){
					capa.innerHTML='SAN PABLO ';
			}else if(opcionSeleccionada=='1' && reg=='10' && pro=='4'){
					capa.innerHTML='CHAITEN ';
			}else if(opcionSeleccionada=='2' && reg=='10' && pro=='4'){
					capa.innerHTML='FUTALEUFU ';
			}else if(opcionSeleccionada=='3' && reg=='10' && pro=='4'){
					capa.innerHTML='HUALAIHUE ';
			}else if(opcionSeleccionada=='4' && reg=='10' && pro=='4'){
					capa.innerHTML='PALENA ';
			}else if(opcionSeleccionada=='1' && reg=='10' && pro=='5'){
					capa.innerHTML='VALDIVIA ';
			}else if(opcionSeleccionada=='2' && reg=='10' && pro=='5'){
					capa.innerHTML='CORRAL ';
			}else if(opcionSeleccionada=='3' && reg=='10' && pro=='5'){
					capa.innerHTML='FUTRONO ';
			}else if(opcionSeleccionada=='4' && reg=='10' && pro=='5'){
					capa.innerHTML='LA UNION ';
			}else if(opcionSeleccionada=='5' && reg=='10' && pro=='5'){
					capa.innerHTML='LAGO RANCO ';
			}else if(opcionSeleccionada=='6' && reg=='10' && pro=='5'){
					capa.innerHTML='LANCO ';
			}else if(opcionSeleccionada=='7' && reg=='10' && pro=='5'){
					capa.innerHTML='LOS LAGOS ';
			}else if(opcionSeleccionada=='8' && reg=='10' && pro=='5'){
					capa.innerHTML='MAFIL ';
			}else if(opcionSeleccionada=='9' && reg=='10' && pro=='5'){
					capa.innerHTML='S.JOSE DE MARIQUINA ';
			}else if(opcionSeleccionada=='10' && reg=='10' && pro=='5'){
					capa.innerHTML='PAILLACO ';
			}else if(opcionSeleccionada=='11' && reg=='10' && pro=='5'){
					capa.innerHTML='PANGUIPULLI ';
			}else if(opcionSeleccionada=='12' && reg=='10' && pro=='5'){
					capa.innerHTML='RIO BUENO ';
			}else if(opcionSeleccionada=='1' && reg=='11' && pro=='1'){
					capa.innerHTML='COYHAIQUE ';
			}else if(opcionSeleccionada=='2' && reg=='11' && pro=='1'){
					capa.innerHTML='LAGO VERDE ';
			}else if(opcionSeleccionada=='1' && reg=='11' && pro=='2'){
					capa.innerHTML='AYSEN ';
			}else if(opcionSeleccionada=='2' && reg=='11' && pro=='2'){
					capa.innerHTML='CISNES ';
			}else if(opcionSeleccionada=='3' && reg=='11' && pro=='2'){
					capa.innerHTML='GUAITECAS ';
			}else if(opcionSeleccionada=='1' && reg=='11' && pro=='3'){
					capa.innerHTML='COCHRANE ';
			}else if(opcionSeleccionada=='2' && reg=='11' && pro=='3'){
					capa.innerHTML='O HIGGINS ';
			}else if(opcionSeleccionada=='3' && reg=='11' && pro=='3'){
					capa.innerHTML='TORTEL ';
			}else if(opcionSeleccionada=='1' && reg=='11' && pro=='4'){
					capa.innerHTML='CHILE CHICO ';
			}else if(opcionSeleccionada=='2' && reg=='11' && pro=='4'){
					capa.innerHTML='RIO IBANEZ ';
			}else if(opcionSeleccionada=='1' && reg=='12' && pro=='1'){
					capa.innerHTML='PUNTA ARENAS ';
			}else if(opcionSeleccionada=='2' && reg=='12' && pro=='1'){
					capa.innerHTML='LAGUNA BLANCA ';
			}else if(opcionSeleccionada=='3' && reg=='12' && pro=='1'){
					capa.innerHTML='RIO VERDE ';
			}else if(opcionSeleccionada=='4' && reg=='12' && pro=='1'){
					capa.innerHTML='SAN GREGORIO ';
			}else if(opcionSeleccionada=='1' && reg=='12' && pro=='2'){
					capa.innerHTML='NAVARINO ';
			}else if(opcionSeleccionada=='2' && reg=='12' && pro=='2'){
					capa.innerHTML='ANTARTICA ';
			}else if(opcionSeleccionada=='1' && reg=='12' && pro=='3'){
					capa.innerHTML='PORVENIR ';
			}else if(opcionSeleccionada=='2' && reg=='12' && pro=='3'){
					capa.innerHTML='PRIMAVERA ';
			}else if(opcionSeleccionada=='3' && reg=='12' && pro=='3'){
					capa.innerHTML='TIMAUKEL ';
			}else if(opcionSeleccionada=='1' && reg=='12' && pro=='4'){
					capa.innerHTML='NATALES ';
			}else if(opcionSeleccionada=='2' && reg=='12' && pro=='4'){
					capa.innerHTML='TORRES DEL PAINE ';
			}else if(opcionSeleccionada=='1' && reg=='13' && pro=='1'){
					capa.innerHTML='SANTIAGO ';
			}else if(opcionSeleccionada=='2' && reg=='13' && pro=='1'){
					capa.innerHTML='CERRILLOS ';
			}else if(opcionSeleccionada=='3' && reg=='13' && pro=='1'){
					capa.innerHTML='CERRO NAVIA ';
			}else if(opcionSeleccionada=='4' && reg=='13' && pro=='1'){
					capa.innerHTML='CONCHALI ';
			}else if(opcionSeleccionada=='5' && reg=='13' && pro=='1'){
					capa.innerHTML='EL BOSQUE ';
			}else if(opcionSeleccionada=='6' && reg=='13' && pro=='1'){
					capa.innerHTML='ESTACION CENTRAL ';
			}else if(opcionSeleccionada=='7' && reg=='13' && pro=='1'){
					capa.innerHTML='HUECHURABA ';
			}else if(opcionSeleccionada=='8' && reg=='13' && pro=='1'){
					capa.innerHTML='INDEPENDENCIA ';
			}else if(opcionSeleccionada=='9' && reg=='13' && pro=='1'){
					capa.innerHTML='LA CISTERNA ';
			}else if(opcionSeleccionada=='10' && reg=='13' && pro=='1'){
					capa.innerHTML='LA FLORIDA ';
			}else if(opcionSeleccionada=='11' && reg=='13' && pro=='1'){
					capa.innerHTML='LA GRANJA ';
			}else if(opcionSeleccionada=='12' && reg=='13' && pro=='1'){
					capa.innerHTML='LA PINTANA ';
			}else if(opcionSeleccionada=='13' && reg=='13' && pro=='1'){
					capa.innerHTML='LA REINA ';
			}else if(opcionSeleccionada=='14' && reg=='13' && pro=='1'){
					capa.innerHTML='LAS CONDES ';
			}else if(opcionSeleccionada=='15' && reg=='13' && pro=='1'){
					capa.innerHTML='LO BARNECHEA ';
			}else if(opcionSeleccionada=='16' && reg=='13' && pro=='1'){
					capa.innerHTML='LO ESPEJO ';
			}else if(opcionSeleccionada=='17' && reg=='13' && pro=='1'){
					capa.innerHTML='LO PRADO ';
			}else if(opcionSeleccionada=='18' && reg=='13' && pro=='1'){
					capa.innerHTML='MACUL ';
			}else if(opcionSeleccionada=='19' && reg=='13' && pro=='1'){
					capa.innerHTML='MAIPU ';
			}else if(opcionSeleccionada=='20' && reg=='13' && pro=='1'){
					capa.innerHTML='NUNOA ';
			}else if(opcionSeleccionada=='21' && reg=='13' && pro=='1'){
					capa.innerHTML='PEDRO AGUIRRE CERDA ';
			}else if(opcionSeleccionada=='1' && reg=='13' && pro=='3'){
					capa.innerHTML='COLINA ';
			}else if(opcionSeleccionada=='24' && reg=='13' && pro=='1'){
					capa.innerHTML='PUDAHUEL ';
			}else if(opcionSeleccionada=='25' && reg=='13' && pro=='1'){
					capa.innerHTML='QUILICURA ';
			}else if(opcionSeleccionada=='26' && reg=='13' && pro=='1'){
					capa.innerHTML='QUINTA NORMAL ';
			}else if(opcionSeleccionada=='27' && reg=='13' && pro=='1'){
					capa.innerHTML='RECOLETA ';
			}else if(opcionSeleccionada=='28' && reg=='13' && pro=='1'){
					capa.innerHTML='RENCA ';
			}else if(opcionSeleccionada=='29' && reg=='13' && pro=='1'){
					capa.innerHTML='SAN JOAQUIN ';
			}else if(opcionSeleccionada=='30' && reg=='13' && pro=='1'){
					capa.innerHTML='SAN MIGUEL ';
			}else if(opcionSeleccionada=='31' && reg=='13' && pro=='1'){
					capa.innerHTML='SAN RAMON ';
			}else if(opcionSeleccionada=='32' && reg=='13' && pro=='1'){
					capa.innerHTML='VITACURA ';
			}else if(opcionSeleccionada=='1' && reg=='13' && pro=='2'){
					capa.innerHTML='PUENTE ALTO ';
			}else if(opcionSeleccionada=='2' && reg=='13' && pro=='2'){
					capa.innerHTML='PIRQUE ';
			}else if(opcionSeleccionada=='3' && reg=='13' && pro=='2'){
					capa.innerHTML='SAN JOSE DE MAIPO ';
			}else if(opcionSeleccionada=='4' && reg=='2' && pro=='4'){
					capa.innerHTML='EL LOA ';
			}else if(opcionSeleccionada=='2' && reg=='13' && pro=='3'){
					capa.innerHTML='LAMPA ';
			}else if(opcionSeleccionada=='3' && reg=='13' && pro=='3'){
					capa.innerHTML='TIL-TIL ';
			}else if(opcionSeleccionada=='1' && reg=='13' && pro=='4'){
					capa.innerHTML='SAN BERNARDO ';
			}else if(opcionSeleccionada=='2' && reg=='13' && pro=='4'){
					capa.innerHTML='BUIN ';
			}else if(opcionSeleccionada=='3' && reg=='13' && pro=='4'){
					capa.innerHTML='CALERA DE TANGO ';
			}else if(opcionSeleccionada=='4' && reg=='13' && pro=='4'){
					capa.innerHTML='PAINE ';
			}else if(opcionSeleccionada=='1' && reg=='13' && pro=='5'){
					capa.innerHTML='MELIPILLA ';
			}else if(opcionSeleccionada=='2' && reg=='13' && pro=='5'){
					capa.innerHTML='ALHUE ';
			}else if(opcionSeleccionada=='3' && reg=='13' && pro=='5'){
					capa.innerHTML='CURACAVI ';
			}else if(opcionSeleccionada=='4' && reg=='13' && pro=='5'){
					capa.innerHTML='MARIA PINTO ';
			}else if(opcionSeleccionada=='5' && reg=='13' && pro=='5'){
					capa.innerHTML='SAN PEDRO ';
			}else if(opcionSeleccionada=='1' && reg=='13' && pro=='6'){
					capa.innerHTML='TALAGANTE ';
			}else if(opcionSeleccionada=='2' && reg=='13' && pro=='6'){
					capa.innerHTML='EL MONTE ';
			}else if(opcionSeleccionada=='3' && reg=='13' && pro=='6'){
					capa.innerHTML='ISLA DE MAIPO ';
			}else if(opcionSeleccionada=='4' && reg=='13' && pro=='6'){
					capa.innerHTML='PADRE HURTADO ';
			}else if(opcionSeleccionada=='5' && reg=='13' && pro=='6'){
					capa.innerHTML='PENAFLOR ';
			}else if(opcionSeleccionada=='6' && reg=='5' && pro=='1'){
					capa.innerHTML='QUILPUÉ ';
			}else if(opcionSeleccionada=='22' && reg=='13' && pro=='1'){
					capa.innerHTML='PEÑALOLÉN ';
			}else if(opcionSeleccionada=='1' && reg=='5' && pro=='1'){
					capa.innerHTML='VALPARAíSO ';
			}else{
					capa.innerHTML='nulo';
			}
			capa_com.innerHTML=opcionSeleccionada;
			break;
			case "ciudad":
			var capa=document.getElementById("nom_pro");
			var capa_pro=document.getElementById("cod_pro");
			var reg=document.getElementById("cod_reg").innerHTML;
				if(opcionSeleccionada=='1' && reg=='1'){
					capa.innerHTML='IQUIQUE ';
				}else if(opcionSeleccionada=='1' && reg=='2'){
					capa.innerHTML='ANTOFAGASTA ';
				}else if(opcionSeleccionada=='1' && reg=='3'){
					capa.innerHTML='COPIAPO ';
				}else if(opcionSeleccionada=='1' && reg=='4'){
					capa.innerHTML='ELQUI ';
				}else if(opcionSeleccionada=='1' && reg=='6'){
					capa.innerHTML='CACHAPOAL ';
				}else if(opcionSeleccionada=='1' && reg=='7'){
					capa.innerHTML='TALCA ';
				}else if(opcionSeleccionada=='1' && reg=='8'){
					capa.innerHTML='CONCEPCION ';
				}else if(opcionSeleccionada=='1' && reg=='9'){
					capa.innerHTML='CAUTIN ';
				}else if(opcionSeleccionada=='1' && reg=='10'){
					capa.innerHTML='LLANQUIHUE ';
				}else if(opcionSeleccionada=='1' && reg=='11'){
					capa.innerHTML='COYHAIQUE ';
				}else if(opcionSeleccionada=='1' && reg=='12'){
					capa.innerHTML='MAGALLANES ';
				}else if(opcionSeleccionada=='1' && reg=='13'){
					capa.innerHTML='SANTIAGO ';
				}else if(opcionSeleccionada=='2' && reg=='2'){
					capa.innerHTML='EL LOA ';
				}else if(opcionSeleccionada=='2' && reg=='3'){
					capa.innerHTML='CHANARAL ';
				}else if(opcionSeleccionada=='2' && reg=='4'){
					capa.innerHTML='CHOAPA ';
				}else if(opcionSeleccionada=='2' && reg=='5'){
					capa.innerHTML='ISLA DE PASCUA ';
				}else if(opcionSeleccionada=='2' && reg=='6'){
					capa.innerHTML='CARDENAL CARO ';
				}else if(opcionSeleccionada=='2' && reg=='7'){
					capa.innerHTML='CAUQUENES ';
				}else if(opcionSeleccionada=='2' && reg=='8'){
					capa.innerHTML='ARAUCO ';
				}else if(opcionSeleccionada=='2' && reg=='9'){
					capa.innerHTML='MALLECO ';
				}else if(opcionSeleccionada=='2' && reg=='11'){
					capa.innerHTML='AYSEN ';
				}else if(opcionSeleccionada=='2' && reg=='12'){
					capa.innerHTML='ANTARTICA CHILENA ';
				}else if(opcionSeleccionada=='2' && reg=='13'){
					capa.innerHTML='CORDILLERA ';
				}else if(opcionSeleccionada=='3' && reg=='1'){
					capa.innerHTML='PARINACOTA ';
				}else if(opcionSeleccionada=='3' && reg=='2'){
					capa.innerHTML='TOCOPILLA ';
				}else if(opcionSeleccionada=='3' && reg=='3'){
					capa.innerHTML='HUASCO ';
				}else if(opcionSeleccionada=='3' && reg=='4'){
					capa.innerHTML='LIMARI ';
				}else if(opcionSeleccionada=='3' && reg=='5'){
					capa.innerHTML='LOS ANDES ';
				}else if(opcionSeleccionada=='3' && reg=='6'){
					capa.innerHTML='COLCHAGUA ';
				}else if(opcionSeleccionada=='3' && reg=='7'){
					capa.innerHTML='CURICO ';
				}else if(opcionSeleccionada=='3' && reg=='8'){
					capa.innerHTML='BIO-BIO ';
				}else if(opcionSeleccionada=='3' && reg=='10'){
					capa.innerHTML='OSORNO ';
				}else if(opcionSeleccionada=='3' && reg=='11'){
					capa.innerHTML='CAPITAN PRAT ';
				}else if(opcionSeleccionada=='3' && reg=='12'){
					capa.innerHTML='TIERRA DEL FUEGO ';
				}else if(opcionSeleccionada=='3' && reg=='13'){
					capa.innerHTML='CHACABUCO ';
				}else if(opcionSeleccionada=='4' && reg=='5'){
					capa.innerHTML='PETORCA ';
				}else if(opcionSeleccionada=='4' && reg=='7'){
					capa.innerHTML='LINARES ';
				}else if(opcionSeleccionada=='4' && reg=='8'){
					capa.innerHTML='NUBLE ';
				}else if(opcionSeleccionada=='4' && reg=='10'){
					capa.innerHTML='PALENA ';
				}else if(opcionSeleccionada=='4' && reg=='11'){
					capa.innerHTML='GENERAL CARRERA ';
				}else if(opcionSeleccionada=='4' && reg=='12'){
					capa.innerHTML='ULTIMA ESPERANZA ';
				}else if(opcionSeleccionada=='4' && reg=='13'){
					capa.innerHTML='MAIPO ';
				}else if(opcionSeleccionada=='5' && reg=='5'){
					capa.innerHTML='QUILLOTA ';
				}else if(opcionSeleccionada=='5' && reg=='10'){
					capa.innerHTML='VALDIVIA ';
				}else if(opcionSeleccionada=='5' && reg=='13'){
					capa.innerHTML='MELIPILLA ';
				}else if(opcionSeleccionada=='6' && reg=='5'){
					capa.innerHTML='SAN ANTONIO ';
				}else if(opcionSeleccionada=='6' && reg=='13'){
					capa.innerHTML='TALAGANTE ';
				}else if(opcionSeleccionada=='7' && reg=='5'){
					capa.innerHTML='SAN FELIPE DE ACONCAGUA ';
				}else if(opcionSeleccionada=='2' && reg=='10'){
					capa.innerHTML='CHILOÉ ';
				}else if(opcionSeleccionada=='4' && reg=='2'){
					capa.innerHTML='CALAMA ';
				}else if(opcionSeleccionada=='1' && reg=='5'){
					capa.innerHTML='VALPARAíSO ';
				}else if(opcionSeleccionada=='2' && reg=='1'){
					capa.innerHTML='ARICA ';
				}else{
					capa.innerHTML='nulo';	
				}
				capa_pro.innerHTML=opcionSeleccionada;
			break;
			case "region":
			var capa=document.getElementById("nom_reg");
			var capa_reg=document.getElementById("cod_reg");
				if(opcionSeleccionada=='1'){
					capa.innerHTML='TARAPACA ';
				}else if(opcionSeleccionada=='2'){
					capa.innerHTML='ANTOFAGASTA ';
				}else if(opcionSeleccionada=='3'){
					capa.innerHTML='ATACAMA ';
				}else if(opcionSeleccionada=='4'){
					capa.innerHTML='COQUIMBO ';
				}else if(opcionSeleccionada=='6'){
					capa.innerHTML='LIBERTADOR GENERAL BERNARDO O"HIGGINS ';
				}else if(opcionSeleccionada=='7'){
					capa.innerHTML='MAULE ';
				}else if(opcionSeleccionada=='8'){
					capa.innerHTML='BIO-BIO ';
				}else if(opcionSeleccionada=='9'){
					capa.innerHTML='LA ARAUCANIA ';
				}else if(opcionSeleccionada=='10'){
					capa.innerHTML='LOS LAGOS ';
				}else if(opcionSeleccionada=='11'){
					capa.innerHTML='AYSEN DEL GRAL.CARLOS IBANEZ DEL CAMPO ';
				}else if(opcionSeleccionada=='12'){
					capa.innerHTML='MAGALLANES Y DE LA ANTARTICA CHILENA ';
				}else if(opcionSeleccionada=='13'){
					capa.innerHTML='METROPOLITANA DE SANTIAGO ';
				}else if(opcionSeleccionada=='5'){
					capa.innerHTML='VALPARAíSO ';
				}else{
					capa.innerHTML="NO ES 2"
				}
				capa_reg.innerHTML=opcionSeleccionada
			break;			
			case "nacionalidad":
			/*alert("aki!!")*/
			var capa=document.getElementById("nac1");
			  if(opcionSeleccionada=="1"){
				  capa.innerHTML="EXTRANJERA";
			  }else{
				  capa.innerHTML="CHILENA";
			  }
			  break;    
			case "sexo":
			var capa=document.getElementById("sexo1");
				if(opcionSeleccionada=="1"){
					capa.innerHTML="HOMBRE";
				}else{
					capa.innerHTML="MUJER";	
				}
			 break;
			 case "estado_civil":
			 var capa=document.getElementById("est_civil");
			 	if(opcionSeleccionada=="1"){
					capa.innerHTML="SOLTERO(A)"
				}else if(opcionSeleccionada=="2"){
					capa.innerHTML="CASADO(A)";
				}else{
					capa.innerHTML="VIUDO(A)";
				}
				
				break;
			  case aut:
			  var capa=document.getElementById("tipo_autorizacion"+cont);
			  if(opcionSeleccionada=="1"){
					capa.innerHTML="INDEFINIDO";
				}else{
					capa.innerHTML="TEMPORAL";
				}
				break;
			  case cargo:
			  var capa=document.getElementById("cargos"+cont);
			  		if(opcionSeleccionada=="1"){
						capa.innerHTML="Director(a)";
					}else if(opcionSeleccionada=="2"){
						capa.innerHTML="Jefe UTP";
					}else if(opcionSeleccionada=="3"){
						capa.innerHTML="Enfermeria";
					}else if(opcionSeleccionada=="4"){
						capa.innerHTML="Contador(a)";
					}else if(opcionSeleccionada=="5"){
						capa.innerHTML="Docente";
					}else if(opcionSeleccionada=="6"){
						capa.innerHTML="Sub-Director";
					}else if(opcionSeleccionada=="7"){
						capa.innerHTML="Inspectoria General";
					}else if(opcionSeleccionada=="8"){
						capa.innerHTML="Titulacion";
					}else if(opcionSeleccionada=="9"){
						capa.innerHTML="Curriculista";
					}else if(opcionSeleccionada=="10"){
						capa.innerHTML="Evaluador";
					}else if(opcionSeleccionada=="11"){
						capa.innerHTML="Orientador(a)";
					}else if(opcionSeleccionada=="12"){
						capa.innerHTML="Sicopedagogo(a)";
					}else if(opcionSeleccionada=="13"){
						capa.innerHTML="Sicologo(a)";
					}else if(opcionSeleccionada=="14"){
						capa.innerHTML="Inspector(a)";
					}else if(opcionSeleccionada=="15"){
						capa.innerHTML="Auxiliar";
					}else if(opcionSeleccionada=="16"){
						capa.innerHTML="Coordinador CRA";
					}else if(opcionSeleccionada=="17"){
						capa.innerHTML="Coordinador Pastoral";
					}else if(opcionSeleccionada=="18"){
						capa.innerHTML="Corrdinador ACLE";
					}else if(opcionSeleccionada=="19"){
						capa.innerHTML="Secretaria";
					}else if(opcionSeleccionada=="20"){
						capa.innerHTML="Tesorero";
					}else if(opcionSeleccionada=="21"){
						capa.innerHTML="Asistente Social";
					}else if(opcionSeleccionada=="22"){
						capa.innerHTML="Coordinador Mantenimiento";
					}else if (opcionSeleccionada=="23"){
						capa.innerHTML="Rector";
					}else if (opcionSeleccionada=="24"){
						capa.innerHTML="Administrativo";
					}else if(opcionSeleccionada=="25"){
						capa.innerHTML="Jefe Administrativo";
					}else if (opcionSeleciconada=="27"){
						capa.innerHTML="Jefe Administrativo";
					}else if(opcionSeleccionada=="28"){
						capa.innerHTML="Asistente de Parvulo";
					}else if(opcionSeleccionada=="29"){
						capa.innerHTML="Bibliotecologo";
					}else if(opcionSeleccionada=="30"){
						capa.innerHTML="Coordinador Academico";
					}else if(opcionSeleccionada=="31"){
						capa.innerHTML="Asistente Social";
					}else if(opcionSeleccionada=="32"){
						capa.innerHTML="Capellan";
					}else if(opcionSeleccionada=="33"){
						capa.innerHTML="Educador Diferencial";
					}else{
						capa.innerHTML="Educador de Parvulos"
					}
			  break;
			  	case subsec:
				var capa=document.getElementById("subsector2"+cont);
					if(opcionSeleccionada=="9151"){
						capa.innerHTML="ACTIVIDADES EDUCATIVAS PARA TRABAJAR EN NB1 ";
					}else if(opcionSeleccionada=="9152"){
						capa.innerHTML="ACTIVIDADES Y MODALIDAD NO CONVENCIONAL PARA TRABAJAR CON PARVULOS ";
					}else if(opcionSeleccionada=="100005"){
						capa.innerHTML="PHYSICS ";
					}else if(opcionSeleccionada=="100007"){
						capa.innerHTML="SOCIAL STUDIES ";
					}else if(opcionSeleccionada=="100008"){
						capa.innerHTML="SPANISH SOCIAL ";
					}else if(opcionSeleccionada=="100006"){
						capa.innerHTML="CHEMISTRY ";
					}else if(opcionSeleccionada=="4649"){
						capa.innerHTML="FILOSOFIA DEL ARTE ";
					}else if(opcionSeleccionada=="4684"){
						capa.innerHTML="FORMACION DIFERENCIAL (BIOLOGIA) ";
					}else if(opcionSeleccionada=="4688"){
						capa.innerHTML="FORMACION DIFERENCIAL (HISTORIA) ";
					}else if(opcionSeleccionada=="4689"){
						capa.innerHTML="FORMACION DIFERENCIAL (INGLES) ";
					}else if(opcionSeleccionada=="4690"){
						capa.innerHTML="FORMACION DIFERENCIAL (MATEMATICA) ";
					}else if(opcionSeleccionada=="4691"){
						capa.innerHTML="FORMACION DIFERENCIAL (QUIMICA) ";
					}else if(opcionSeleccionada=="4712"){
						capa.innerHTML="FRUT. POST-COS Y M.PACKING ";
					}else if(opcionSeleccionada=="4720"){
						capa.innerHTML="FUNC. ELEM. MORFOSINTACTICOS Y LEXICO ";
					}else if(opcionSeleccionada=="4727"){
						capa.innerHTML="FUNDAMENTOS ";
					}else if(opcionSeleccionada=="4739"){
						capa.innerHTML="G. DE LA CONSTRUCCION ";
					}else if(opcionSeleccionada=="4791"){
						capa.innerHTML="GESTION FORMATIVA DEL VENDEDOR (C) ";
					}else if(opcionSeleccionada=="4805"){
						capa.innerHTML="H. Y TEC. BAS. DE GESTION E INSERC. LABORAL ";
					}else if(opcionSeleccionada=="4807"){
						capa.innerHTML="HACIA EL DESARROLLO ECONOMICO (ELECTIVO 2) ";
					}else if(opcionSeleccionada=="4822"){
						capa.innerHTML="HISTORIA UNIVERSAL Y GEOGRAFIA GENERAL ";
					}else if(opcionSeleccionada=="4836"){
						capa.innerHTML="HISTORIA EVOLUTIVA CONSTITUCIONAL DE CHILE ";
					}else if(opcionSeleccionada=="4856"){
						capa.innerHTML="HISTORIA Y CIENCIAS SOCIALES. ";
					}else if(opcionSeleccionada=="2530"){
						capa.innerHTML="PREPARADO Y CONFECCION DE PRENDAS FEMENINAS DEPORTIVAS Y DE TRABAJO ";
					}else if(opcionSeleccionada=="2716"){
						capa.innerHTML="LABORATORIO DE NORMALIZACION Y VERIFICACION ";
					}else if(opcionSeleccionada=="6951"){
						capa.innerHTML="APLICACION DE LA TEORIA ECONOMICA I ";
					}else if(opcionSeleccionada=="6952"){
						capa.innerHTML="APLICACION DE LA TEORIA ECONOMICA II ";
					}else if(opcionSeleccionada=="6953"){
						capa.innerHTML="DIAGNOSTICO Y ELABORACION DE PROYECTOS I ";
					}else if(opcionSeleccionada=="6954"){
						capa.innerHTML="DIAGNOSTIGO Y ELABORACION DE PROYECTOS II ";
					}else if(opcionSeleccionada=="6991"){
						capa.innerHTML="ETICA Y EVALUACION EN EL JARDIN INFANTIL ";
					}else if(opcionSeleccionada=="6987"){
						capa.innerHTML="TRABAJO CON FAMILIA Y LOS NIÑOS EN SITUACION DE RIESGO ";
					}else if(opcionSeleccionada=="6988"){
						capa.innerHTML="TECNICAS GENERALES DE TRABAJO SOCIAL ";
					}else if(opcionSeleccionada=="6989"){
						capa.innerHTML="PROYECTO SOCIAL ";
					}else if(opcionSeleccionada=="6990"){
						capa.innerHTML="NIVELES DE ACCION SOCIAL ";
					}else if(opcionSeleccionada=="9098"){
						capa.innerHTML="INTEGRACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="100002"){
						capa.innerHTML="WRITTEN EXPRESSION ";
					}else if(opcionSeleccionada=="100001"){
						capa.innerHTML="READING COMPREHENSION ";
					}else if(opcionSeleccionada=="100003"){
						capa.innerHTML="SCIENCE ";
					/*11*/
					}else if(opcionSeleccionada=="9149"){
						capa.innerHTML="GESTIÓN DE PEQUEÑA EMPRESA HOTELERA ";
					}else if(opcionSeleccionada=="9150"){
						capa.innerHTML="SALUD, HIGIENE Y ALIMENTACIÓN DEL PÁRVULO ";
					}else if(opcionSeleccionada=="9148"){
						capa.innerHTML="PREVENCIÓN DEL CONSUMO DE DROGAS ";
					}else if(opcionSeleccionada=="4169"){
						capa.innerHTML="DEPORTE Y RECREACION ";
					}else if(opcionSeleccionada=="4176"){
						capa.innerHTML="DEPORTES Y RECREACION ";
					}else if(opcionSeleccionada=="4178"){
						capa.innerHTML="DER. COMER. INT. ";
					}else if(opcionSeleccionada=="4223"){
						capa.innerHTML="DIB Y PR. ESPECIAL ";
					}else if(opcionSeleccionada=="4255"){
						capa.innerHTML="DIFERENCIADA LENGUAJE Y SOCIEDAD ";
					}else if(opcionSeleccionada=="4271"){
						capa.innerHTML="DIS. CIR. CON PC. ";
					}else if(opcionSeleccionada=="4272"){
						capa.innerHTML="DIS. OPER. Y MANT. SIST. DE CONT. ELEC. ";
					}else if(opcionSeleccionada=="4290"){
						capa.innerHTML="DISENO MUL. FOC. DISENO ARQ. Y URBANO ";
					}else if(opcionSeleccionada=="4319"){
						capa.innerHTML="DOCUMENTACION Y ARCHIVOS ";
					}else if(opcionSeleccionada=="4389"){
						capa.innerHTML="EL DESARR. PERS. INT. Y LA ORIENT. TECN. ";
					}else if(opcionSeleccionada=="4402"){
						capa.innerHTML="ELAB. PROD. AGROPECUARIOS ";
					}else if(opcionSeleccionada=="4403"){
						capa.innerHTML="ELAB. Y EVALU. DE PROY. ";
					}else if(opcionSeleccionada=="4419"){
						capa.innerHTML="ELABORACION Y PREP.DE ALIMENTOS PARA MENU,COST,BUFFET Y COCTAIL ";
					}else if(opcionSeleccionada=="4422"){
						capa.innerHTML="ELE. DE DERECH. C. PENAL Y LAB. ";
					}else if(opcionSeleccionada=="4423"){
						capa.innerHTML="ELEC. APLICACIONES DE LAS MATEMATICAS ";
					}else if(opcionSeleccionada=="4434"){
						capa.innerHTML="ELECTIVO ";
					}else if(opcionSeleccionada=="4438"){
						capa.innerHTML="ELECTIVO PSICOLOGIA ";
					}else if(opcionSeleccionada=="4455"){
						capa.innerHTML="ELECTIVO CASTELLANO ";
					}else if(opcionSeleccionada=="4462"){
						capa.innerHTML="ELECTIVO DE ALGEBRA ";
					}else if(opcionSeleccionada=="4465"){
						capa.innerHTML="ELECTIVO DE CASTELLANO ";
					}else if(opcionSeleccionada=="4466"){
						capa.innerHTML="ELECTIVO DE CIENCIAS ";
					}else if(opcionSeleccionada=="4468"){
						capa.innerHTML="ELECTIVO DE COMPUTACION ";
					}else if(opcionSeleccionada=="4475"){
						capa.innerHTML="ELECTIVO F ";
					}else if(opcionSeleccionada=="4483"){
						capa.innerHTML="ELECTIVO INGLES ";
					}else if(opcionSeleccionada=="4504"){
						capa.innerHTML="ELECTRICIDAD DOMICIALIARIA ";
					}else if(opcionSeleccionada=="4512"){
						capa.innerHTML="ELECTRICIDAD Y COMPUTACION ";
					}else if(opcionSeleccionada=="4523"){
						capa.innerHTML="ELECTRONICABASICA ";
					}else if(opcionSeleccionada=="4534"){
						capa.innerHTML="ELEMENTOS DE DERECHO,CIVIL,PENAL Y LABORAL ";
					}else if(opcionSeleccionada=="4551"){
						capa.innerHTML="EOG. Y REC. TURISTICOS ";
					}else if(opcionSeleccionada=="4556"){
						capa.innerHTML="ESPECIALIDAD ";
					}else if(opcionSeleccionada=="4571"){
						capa.innerHTML="ESTUD ";
					}else if(opcionSeleccionada=="4630"){
						capa.innerHTML="F.D. LENGUA CASTELLANA ";
					}else if(opcionSeleccionada=="100004"){
						capa.innerHTML="ORAL EXPRESSION ";
					}else if(opcionSeleccionada=="4635"){
						capa.innerHTML="FAC. SIS. PROD. Y PROPAG. VEGET ";
					}else if(opcionSeleccionada=="2800"){
						capa.innerHTML="ARTES VISUALES; ARTES ESCENICAS, TEATRO Y DANZA ";
					}else if(opcionSeleccionada=="3258"){
						capa.innerHTML="MANTENCION MECANICA ";
					}else if(opcionSeleccionada=="3485"){
						capa.innerHTML="CULTIVOS I ";
					}else if(opcionSeleccionada=="3768"){
						capa.innerHTML="APTITUD VERBAL II ";
					}else if(opcionSeleccionada=="3783"){
						capa.innerHTML="ARTESANIA BASICA ";
					}else if(opcionSeleccionada=="3797"){
						capa.innerHTML="ARTES MUSICALES:COMPOSICION MUSICAL ";
					}else if(opcionSeleccionada=="3798"){
						capa.innerHTML="ARTES PLASTICAS O ED. MUSICAL ";
					/*12*/
					}else if(opcionSeleccionada=="3837"){
						capa.innerHTML="AUDIOVISUAL,FOTOGRAFIA,DIAPORAMA,VIDEOS,CINE ";
					}else if(opcionSeleccionada=="3850"){
						capa.innerHTML="BIOL. PROB. FUND. DEL OR. ANI. Y ASP. B. DE ECOL. ";
					}else if(opcionSeleccionada=="3873"){
						capa.innerHTML="BIOLOGIA, EVOLUCION, ECOLOGIA Y AMBIENTE ";
					}else if(opcionSeleccionada=="3884"){
						capa.innerHTML="CIENCIAS SOCIALES Y REALIDAD NACIONAL ";
					}else if(opcionSeleccionada=="3948"){
						capa.innerHTML="COMERCIALIZACION Y VENTAS ";
					}else if(opcionSeleccionada=="3956"){
						capa.innerHTML="COMP.BAS.DE ALBAN.Y ADIT. PARA MORT. Y HORM. ";
					}else if(opcionSeleccionada=="3957"){
						capa.innerHTML="COMPET. BAS.DE TRAZ.Y EXCAV.,CARP. Y MOLD.DE OBRAS ";
					}else if(opcionSeleccionada=="3964"){
						capa.innerHTML="COMPRENS. LECT. INGLES ";
					}else if(opcionSeleccionada=="3965"){
						capa.innerHTML="COMPRENSI ";
					}else if(opcionSeleccionada=="3969"){
						capa.innerHTML="COMPRENSION DE LECTURA APLICADA ";
					}else if(opcionSeleccionada=="3981"){
						capa.innerHTML="COMPRENSION MEDIO NATURAL ";
					}else if(opcionSeleccionada=="3983"){
						capa.innerHTML="COMPRENSION MEDIO SOCIAL Y CULTURAL ";
					}else if(opcionSeleccionada=="3987"){
						capa.innerHTML="COMPRESION DEL MEDIO NATURAL ";
					}else if(opcionSeleccionada=="3989"){
						capa.innerHTML="COMPRESION DEL IDIOMA DE INGLES ";
					}else if(opcionSeleccionada=="3990"){
						capa.innerHTML="COMPRESION DEL IDIOMA ESCRITO ";
					}else if(opcionSeleccionada=="3992"){
						capa.innerHTML="COMPRESION DEL MEDIO ";
					}else if(opcionSeleccionada=="3993"){
						capa.innerHTML="COMPRESION DEL MEDIO SOCIAL ";
					}else if(opcionSeleccionada=="3994"){
						capa.innerHTML="COMPUTACION APLICADA ";
					}else if(opcionSeleccionada=="3995"){
						capa.innerHTML="COMPUTACION BASICA ";
					}else if(opcionSeleccionada=="4012"){
						capa.innerHTML="COMUNICACION GRAFICA ";
					}else if(opcionSeleccionada=="4046"){
						capa.innerHTML="CONSTRUCCION BAS. INTER. ";
					}else if(opcionSeleccionada=="4063"){
						capa.innerHTML="CONTABILIDAD II ";
					}else if(opcionSeleccionada=="4102"){
						capa.innerHTML="CREACIONES TEGNOLOGICAS ";
					}else if(opcionSeleccionada=="4142"){
						capa.innerHTML="D. LENGUAJE Y SOCIEDAD ";
					}else if(opcionSeleccionada=="4154"){
						capa.innerHTML="DECRETO 15 ";
					}else if(opcionSeleccionada=="4157"){
						capa.innerHTML="DECRETO 15 EDUC. PARA EL HOGAR ";
					}else if(opcionSeleccionada=="4158"){
						capa.innerHTML="DECRETO 15 HORTICULTURA ";
					}else if(opcionSeleccionada=="6924"){
						capa.innerHTML="INVESTIGACIÓN EN BIOLOGÍA ";
					}else if(opcionSeleccionada=="6925"){
						capa.innerHTML="ALBAÑILERIA Y ADITIVOS PARA MORTEROS Y HORMIGONES ";
					}else if(opcionSeleccionada=="6926"){
						capa.innerHTML="AUTOMATIZACION INDUSTRIAL Y OPERACION DE EQUIPOS INDUSTRIALES ";
					}else if(opcionSeleccionada=="6927"){
						capa.innerHTML="CARPINTERIA DE TRAZADO, REPLANTEO Y MOLDAJE DE OBRA, TRAZADO Y EXCAVACIÓN DE OBRAS DE EDIFICACION ";
					}else if(opcionSeleccionada=="6928"){
						capa.innerHTML="CIRCUITOS ELECTRICOS Y MANTENIMIENTO DE LOS SISTEMAS ELECTRICOS Y ELECTRONICOS AUXILIARES DEL VEHICULO, SEGURIDAD DE PEQUEÑA EMPRESA ";
					}else if(opcionSeleccionada=="6929"){
						capa.innerHTML="CONFORMADO Y MECANIZADO AVANZADO DE PIEZAS Y PROYECTOS MECANICOS";
					}else if(opcionSeleccionada=="6930"){
						capa.innerHTML="HORMIGONES PREMEZCLADOS, PRODUCCION DE HORMIGON EN OBRA, MOLDAJES ";
					}else if(opcionSeleccionada=="6931"){
						capa.innerHTML="INDUSTRIALIZADOS PARA HORMIGONES ";
					}else if(opcionSeleccionada=="6932"){
						capa.innerHTML="MANTENIMIENTO DE MOTORES Y DE SISTEMAS DEL VEHICULO ";
					}else if(opcionSeleccionada=="6933"){
						capa.innerHTML="MANTENIMIENTO MECANICO Y CONTROL DE CALIDAD DE PRODUCTOS MECANIZADOS ";
					}else if(opcionSeleccionada=="6934"){
						capa.innerHTML="PROGRAMACION DE LOS PROCESOS DE MECANIZADO, TALADRADO, TORNEADO Y FRESADO ";
					}else if(opcionSeleccionada=="6935"){
						capa.innerHTML="TALLER DE INTRODUCCION A LAS ESPECIALIDADES ";
					}else if(opcionSeleccionada=="6936"){
						capa.innerHTML="TALLER MENTALIDAD EMPRENDEDORA Y PROYECTOS EMPRESARIALES ";
					}else if(opcionSeleccionada=="6937"){
						capa.innerHTML="ACTIVIDADES FOLCLÓRICAS PROPIAS DE LA CULTURA ";
					}else if(opcionSeleccionada=="6938"){
						capa.innerHTML="CREACIÓN LITERARIA AYMARA ";
					}else if(opcionSeleccionada=="6939"){
						capa.innerHTML="EXPRESIÓN TRADICIONAL AYMARA ";
					}else if(opcionSeleccionada=="6940"){
						capa.innerHTML="HISTORIA DEL ARTE RUPESTRE ";
					}else if(opcionSeleccionada=="6941"){
						capa.innerHTML="LÓGICA MATEMÁTICA COMPUTACIONAL ";
					}else if(opcionSeleccionada=="6942"){
						capa.innerHTML="INGLÉS PRÁCTICO E INSTRUMENTAL. ";
					}else if(opcionSeleccionada=="6943"){
						capa.innerHTML="ORÍGENES DE LA QUÍMICA ";
					}else if(opcionSeleccionada=="6944"){
						capa.innerHTML="PROBLEMA DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="6945"){
						capa.innerHTML="IDIOMA EXTRANJERO INGLÉS: MÓDULO: CIENTÍFICO- TECNOLÓGICO ";
					}else if(opcionSeleccionada=="6946"){
						capa.innerHTML="OPERACIÓN DE MAQUINARIAS PESADAS: CAMIONES DE ALTO TONELAJE ";
					}else if(opcionSeleccionada=="6947"){
						capa.innerHTML="ACTIVIDADES PARA EL DESARROLLO PSICOSOCIAL DEL PARVULO ";
					}else if(opcionSeleccionada=="6948"){
						capa.innerHTML="HANDBOL ";
					}else if(opcionSeleccionada=="6949"){
						capa.innerHTML="MATERIALES E INSUMOS ";
					}else if(opcionSeleccionada=="6950"){
						capa.innerHTML="MODELAJE ASISTIDO POR COMPUTACION ";
					}else if(opcionSeleccionada=="0"){
						capa.innerHTML="INDETERMINADO ";
					/*13*/
					}else if(opcionSeleccionada=="703"){
						capa.innerHTML="LIBRE DISPOSICION ";
					}else if(opcionSeleccionada=="1861"){
						capa.innerHTML="T. DE ELEC. DOMIC. ";
					}else if(opcionSeleccionada=="2029"){
						capa.innerHTML="LIBRE ELECCION ";
					}else if(opcionSeleccionada=="2459"){
						capa.innerHTML="MANTENIMIENTO DE MOTORES RECIPROCOS Y SUS SISTEMAS ASOCIADOS ";
					}else if(opcionSeleccionada=="2724"){
						capa.innerHTML="ARTES VISUALES GRAFICA PINTURA Y ESCULTURA ";
					}else if(opcionSeleccionada=="2799"){
						capa.innerHTML="ARTES VISUALES, AUDIOVISUAL, FOTOGRAFIA, DIAPORAMA, VIDEO Y CINE";
					}else if(opcionSeleccionada=="6890"){
						capa.innerHTML="CONTEXTUALIZACION DE LA HISTORIA II ";
					}else if(opcionSeleccionada=="6891"){
						capa.innerHTML="CHEDUNGUN ";
					}else if(opcionSeleccionada=="6892"){
						capa.innerHTML="COMPRENSIÓN DEL MEDIO SOCIAL Y CULTURAL (CULTURA ITALIANA) ";
					}else if(opcionSeleccionada=="6893"){
						capa.innerHTML="IDENTIDAD CULTURAL ";
					}else if(opcionSeleccionada=="6894"){
						capa.innerHTML="MAPUDUNGUN ";
					}else if(opcionSeleccionada=="6895"){
						capa.innerHTML="ORIENTACIÓN MECANICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="6896"){
						capa.innerHTML="ORIENTACIÓN SERVICIO ALIMENTACIÓN COLECTIVA ";
					}else if(opcionSeleccionada=="6897"){
						capa.innerHTML="FILOSOFIA Y MORAL ";
					}else if(opcionSeleccionada=="6898"){
						capa.innerHTML="COMPLEMENTARIO DE QUIMICA ";
					}else if(opcionSeleccionada=="6899"){
						capa.innerHTML="ÁLGEBRA Y MODELOS ANALITICOS MATEMATICOS ";
					}else if(opcionSeleccionada=="6900"){
					    capa.innerHTML="ÁLGEBRA Y MODELOS ANALITICOS, BIOLOGIA ";
					}else if(opcionSeleccionada=="6901"){
					    capa.innerHTML="FUNCIONES Y PROCESOS INFINITOS MATEMATICOS ";
					}else if(opcionSeleccionada=="6902"){
					     capa.innerHTML="FUNCIONES Y PROCESOS INFINITOS, BIOLOGIA ";
					}else if(opcionSeleccionada=="6903"){
					    capa.innerHTML="SOCIALIZACION EN EL CRECIMIENTO PERSONAL ";
					}else if(opcionSeleccionada=="6904"){
					    capa.innerHTML="APLICACION INFORMATICA EN LA ADMINISTRACION ";
					}else if(opcionSeleccionada=="6905"){
					    capa.innerHTML="CONTABILIDAD Y TRIBUTACION ";
					}else if(opcionSeleccionada=="6906"){
					    capa.innerHTML="GESTION COMPRAVENTA Y COMERCIO EXTERIOR ";
					}else if(opcionSeleccionada=="6907"){
					    capa.innerHTML="INICIACION A LA ADMINISTRACION ";
					}else if(opcionSeleccionada=="6908"){
					    capa.innerHTML="TEORIA DE PROYECTOS ";
					}else if(opcionSeleccionada=="6909"){
					    capa.innerHTML="MATERIALES, SISTEMA Y EQUIPOS DE IMPRESION ";
					}else if(opcionSeleccionada=="6910"){
					    capa.innerHTML="ANÁLIS DE LA EXPERIENCIA EN EMPRESA  ";
					}else if(opcionSeleccionada=="6911"){
					    capa.innerHTML="GESTIÓN DE EMPRESA, CONTROL DE CALIDAD Y CONTAMINACIÓN AMBIENTAL";
					}else if(opcionSeleccionada=="6912"){
					    capa.innerHTML="MATERIALES, SISTEMAS Y EQUIPOS DE IMPRESIÓN Y POSTIMPRESIÓN  ";
					}else if(opcionSeleccionada=="6913"){
					    capa.innerHTML="EDUCACION VALORICA ";
					}else if(opcionSeleccionada=="6914"){
					    capa.innerHTML="DISEÑO MÚLTIPLE MATEMÁTICO ";
					}else if(opcionSeleccionada=="6915"){
					    capa.innerHTML="DISEÑO MÚLTIPLE HUMANISTA ";
					}else if(opcionSeleccionada=="6916"){
					    capa.innerHTML="APRECIACIÓN AL ARTE ";
					}else if(opcionSeleccionada=="6917"){
					    capa.innerHTML="LECTURA VELOZ ";
					}else if(opcionSeleccionada=="6918"){
					    capa.innerHTML="MÚSICA LATINOAMERICANA ";
					}else if(opcionSeleccionada=="6919"){
					    capa.innerHTML="PRÁCTICAS CIENTÍFICAS ";
					}else if(opcionSeleccionada=="6920"){
					    capa.innerHTML="REDACCIÓN Y COMPRENSIÓN LECTORA ";
					}else if(opcionSeleccionada=="6921"){
					    capa.innerHTML="CIENCIAS I BIOLOGÍA ";
					}else if(opcionSeleccionada=="6922"){
					    capa.innerHTML="CIENCIAS II QUÍMICA ";
					}else if(opcionSeleccionada=="6923"){
					    capa.innerHTML="PRESENTACIÓN DE POSTRES Y BOCADILLOS  ";
					}else if(opcionSeleccionada=="6855"){
					    capa.innerHTML="ADMINISTRACION DE EMPRESAS TURISTICAS ";
					/*14*/
					}else if(opcionSeleccionada=="6856"){
					    capa.innerHTML="MAQUINARIA NAVAL AUXILIAR ";
					}else if(opcionSeleccionada=="6857"){
					    capa.innerHTML="MAQUINARIA NAVAL PRINCIPAL ";
					}else if(opcionSeleccionada=="6858"){
					    capa.innerHTML="NAÚTICA Y ESTABILIDAD ";
					}else if(opcionSeleccionada=="6859"){
					    capa.innerHTML="REGLAMENTACIÓN MARÍTIMA Y AMBIENTAL ";
					}else if(opcionSeleccionada=="6860"){
					    capa.innerHTML="SISTEMAS HIDRÁULICOS ";
					}else if(opcionSeleccionada=="6861"){
					    capa.innerHTML="SISTEMAS NEUMÁTICOS ";
					}else if(opcionSeleccionada=="6862"){
					    capa.innerHTML="INGLÉS CIENTIFICO - HUMANISTA PLAN DIFERENCIADO 4º AÑO MEDIO ";
					}else if(opcionSeleccionada=="6863"){
					    capa.innerHTML="APLICACIONES INFORMATICA AVANZADA ";
					}else if(opcionSeleccionada=="6864"){
					    capa.innerHTML="NORMATIVA PREVISIONAL, LABORAL, COMERCIAL Y TRIBUTARIA ";
					}else if(opcionSeleccionada=="6865"){
					    capa.innerHTML="SALUD Y ADMINISTRACION I ";
					}else if(opcionSeleccionada=="6866"){
					    capa.innerHTML="COSTO Y ESTADO DE RESULTADO / GESTIÓN DE PEQUEÑA EMPRESA. ";
					}else if(opcionSeleccionada=="6867"){
					    capa.innerHTML="GESTIÓN DE COMPRAVENTA Y DE APROVISIONAMIENTO ";
					}else if(opcionSeleccionada=="6868"){
					    capa.innerHTML="SERVICIO DE ATENCIÓN AL CLIENTE/COMUNICACIÓN ORGANIZACIONAL ";
					}else if(opcionSeleccionada=="6870"){
					    capa.innerHTML="INTRODUCCION A LA CONTABILIDAD ";
					}else if(opcionSeleccionada=="6871"){
					    capa.innerHTML="ARMADO Y DESARMADO DE PC ";
					}else if(opcionSeleccionada=="6872"){
					    capa.innerHTML="PROYECTOS ELECTRONICOS ";
					}else if(opcionSeleccionada=="6873"){
					    capa.innerHTML="ECONOMIA Y COMERCIO ";
					}else if(opcionSeleccionada=="6874"){
					    capa.innerHTML="ETICA Y RELACION LABORAL ";
					}else if(opcionSeleccionada=="6875"){
					    capa.innerHTML="TEORIA Y PRACTICA DE PROYECTOS ";
					}else if(opcionSeleccionada=="6876"){
					    capa.innerHTML="MANTENCIÓN DE LA ROPA ";
					}else if(opcionSeleccionada=="6877"){
					    capa.innerHTML="TÉCNICAS BÁSICAS DE COMPUTACIÓN ";
					}else if(opcionSeleccionada=="6878"){
					    capa.innerHTML="HORTALIZAS ";
					}else if(opcionSeleccionada=="6879"){
					    capa.innerHTML="PLANTAS MEDICINALES ";
					}else if(opcionSeleccionada=="6880"){
					    capa.innerHTML="PROCESO AGROINDUSTRIAL ";
					}else if(opcionSeleccionada=="6881"){
					    capa.innerHTML="COMPRENSIÓN DEL MEDIO CULTURAL Y SOCIAL; ITALIANO ";
					}else if(opcionSeleccionada=="6882"){
					    capa.innerHTML="COORDINACIÒN FÌSICA Y MOTRIZ ASOCIADA A SALUD Y CALIDAD DE VIDA";
					}else if(opcionSeleccionada=="6883"){
					    capa.innerHTML="CULTIVO DE PECES Y CRUSTACEOS Y CULTIVOS DE ALGAS ";
					}else if(opcionSeleccionada=="6884"){
					    capa.innerHTML="EXPRESIÒN ORAL, ESCRITA Y COMUNICACIÒN ";
					}else if(opcionSeleccionada=="6885"){
					    capa.innerHTML="PREPARADO Y CONFECCIÒN DE PRENDAS MASCULINA DE VESTIR Y DE TRABAJO";
					}else if(opcionSeleccionada=="6886"){
					    capa.innerHTML="PROGRAMAS DE DISEÑO I ";
					}else if(opcionSeleccionada=="6887"){
					    capa.innerHTML="PROGRAMAS DE OFICINAS I ";
					}else if(opcionSeleccionada=="6888"){
					    capa.innerHTML="GESTION SEGURA Y DE CALIDAD ";
					}else if(opcionSeleccionada=="6889"){
					    capa.innerHTML="CONTEXTUALIZACION DE LA HISTORIA I ";
					}else if(opcionSeleccionada=="6821"){
					    capa.innerHTML="TECNICA DE VESTUARIO ";
					}else if(opcionSeleccionada=="6822"){
					    capa.innerHTML="INTRODUCCION AL CINE ";
					}else if(opcionSeleccionada=="6823"){
					    capa.innerHTML="DESARROLLO PERSONAL Y ORIENTACION VOCACIONAL ";
					}else if(opcionSeleccionada=="6824"){
					    capa.innerHTML="INTEGRACION Y DESARROLLO COMUNITARIO ";
					}else if(opcionSeleccionada=="6825"){
					    capa.innerHTML="OPERACIONES DE MECANIZADOS ";
					}else if(opcionSeleccionada=="6826"){
					    capa.innerHTML="ECONOMÍA Y FILOSOFÍA. ";
					}else if(opcionSeleccionada=="6827"){
					    capa.innerHTML="EDUCACIÓN CÍVICA Y BIOQUÍMICA ";
					}else if(opcionSeleccionada=="6828"){
					    capa.innerHTML="BIOLOGIA AVANZADA ";
					}else if(opcionSeleccionada=="6829"){
					    capa.innerHTML="FISICA AVANZADA ";
					}else if(opcionSeleccionada=="6830"){
					    capa.innerHTML="LA QUIMICA Y LOS BENEFICIOS PARA LA SALUD HUMANA ";
					}else if(opcionSeleccionada=="6831"){
					    capa.innerHTML="PREPARACION DE ESTADOS FINANCIEROS ";
					}else if(opcionSeleccionada=="6832"){
					    capa.innerHTML="TIPO Y VALORES HUMANOS EN LA LITERATURA UNIVERSAL ";
					}else if(opcionSeleccionada=="6833"){
					    capa.innerHTML="RENDIMIENTO PORTUARIO ";
					}else if(opcionSeleccionada=="6834"){
					    capa.innerHTML="ANTROPOLOGÍA, CRECIMIENTO Y DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="6835"){
					    capa.innerHTML="FUNDAMENTOS DE BOTANICA ";
					}else if(opcionSeleccionada=="6836"){
					    capa.innerHTML="PRINCIPIOS BASICOS DE ECONOMIA ";
					}else if(opcionSeleccionada=="6837"){
					    capa.innerHTML="NOCIONES DE ECOLOGIA PARA EL DESARROLLO HUMANO ";
					}else if(opcionSeleccionada=="6838"){
					    capa.innerHTML="TECNICAS DE RELACIONES HUMANAS Y ATENCION DE PUBLICO ";
					}else if(opcionSeleccionada=="6839"){
					    capa.innerHTML="PROBLEMAS GNOSEOLÓGICOS DEL HOMBRE CONTEMPORÁNEO ";
					}else if(opcionSeleccionada=="6840"){
					    capa.innerHTML="IMÁGENES DE NUESTRA HISTORIA, SIGNIFICADO Y TRASCENDENCIA ";
					}else if(opcionSeleccionada=="6841"){
					    capa.innerHTML="NUESTRO TERRITORIO, IMAGEN GEOGRÁFICA Y PATRIMONIO ECONÓMICO ";
					}else if(opcionSeleccionada=="6842"){
					    capa.innerHTML="ELECTIVO ARTISTICO I ";
					}else if(opcionSeleccionada=="6843"){
					    capa.innerHTML="ELECTIVO ARTISTICO II ";
					}else if(opcionSeleccionada=="6844"){
					    capa.innerHTML="ELECTIVO EDUCACION TECNOLOGICA I ";
					}else if(opcionSeleccionada=="6845"){
					    capa.innerHTML="ELECTIVO EDUCACION TECNOLOGICA II ";
					}else if(opcionSeleccionada=="6846"){
					    capa.innerHTML="ELECTIVO MULTIDISCIPLINARIO ";
					}else if(opcionSeleccionada=="6847"){
					    capa.innerHTML="APROVECHAMIENTO INTEGRAL DE MADERA, TINTES Y TEJIDOS ARTESANALES";
					}else if(opcionSeleccionada=="6848"){
					    capa.innerHTML="BOTANICA ";
					}else if(opcionSeleccionada=="6849"){
					    capa.innerHTML="CURSO BASICO DE MONTAÑA ";
					}else if(opcionSeleccionada=="6850"){
					    capa.innerHTML="ECOLOGIA Y TURISMO ";
					}else if(opcionSeleccionada=="6851"){
					    capa.innerHTML="ECONOMIA Y LEGISLACION DEL TURISMO ";
					}else if(opcionSeleccionada=="6852"){
					    capa.innerHTML="INTRODUCCION AL ECOTURISMO ";
					}else if(opcionSeleccionada=="6853"){
					    capa.innerHTML="PRACTICA LABORAL ";
					}else if(opcionSeleccionada=="6854"){
					    capa.innerHTML="RELACIONES PUBLICAS Y LEGISLACION ";
					}else if(opcionSeleccionada=="6787"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION CASTELLANO, PLAN DIFERENCIAL ";
					}else if(opcionSeleccionada=="6788"){
					    capa.innerHTML="MATEMATICAS PLAN DIFERENCIAL. ";
					}else if(opcionSeleccionada=="6789"){
					    capa.innerHTML="PREPARACIÓN GENERAL DEL EQUIPO PESADO PARA LA PUESTA EN MARCHA";
					}else if(opcionSeleccionada=="6790"){
					    capa.innerHTML="SOCIALIZACIÓN EN EL CRECIMIENTO PROFESIONAL ";
					}else if(opcionSeleccionada=="6791"){
					    capa.innerHTML="LENGUAJE, SOCIEDAD Y HABILIDADES SOCIALES ";
					}else if(opcionSeleccionada=="6792"){
					    capa.innerHTML="PROGRAMA SECTOR CURRICULAR EDUCACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="6793"){
					    capa.innerHTML="EDUCACION ARTISTICA MUSICAL ";
					}else if(opcionSeleccionada=="6794"){
					    capa.innerHTML="INGLES: MODULO LITERARIO CULTURAL ";
					}else if(opcionSeleccionada=="6795"){
					    capa.innerHTML="CIENCIAS SOCIALES, REALIDAD NACIONAL Y LOCAL. ";

					}else if(opcionSeleccionada=="6796"){
					    capa.innerHTML="LENGUAJE, SOCIEDAD. ";
					}else if(opcionSeleccionada=="6797"){
					    capa.innerHTML="GEOGRAFIA FISICA APLICADA ";
					}else if(opcionSeleccionada=="6798"){
					    capa.innerHTML="LA GRÁFICA ORIENTADA AL DIBUJO TÉCNICO ARQUITECTÓNICO ";
					}else if(opcionSeleccionada=="6799"){
					    capa.innerHTML="LENGUAJE, REDACCIÓN Y ORATORIA ";
					}else if(opcionSeleccionada=="6800"){
					    capa.innerHTML="MÉTODO DE INVESTIGACIÓN EN CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="6801"){
					    capa.innerHTML="NARRATIVA CHILENA E HISPANOAMERICANA ";
					}else if(opcionSeleccionada=="6802"){
					    capa.innerHTML="TRIGONOMETRÍA Y GEOMETRIA ANALITICA ";
					}else if(opcionSeleccionada=="6803"){
					    capa.innerHTML="PREPARACION DEL ESTADO FINANCIERO ";
					}else if(opcionSeleccionada=="6804"){
					    capa.innerHTML="CONTABILIDAD OPERATIVA ";
					}else if(opcionSeleccionada=="6805"){
					    capa.innerHTML="GESTION DE LA PEQUEÑA EMPRESA COSTOS Y ESTADO DE RESULTADO ";
					}else if(opcionSeleccionada=="6806"){
					    capa.innerHTML="CULTURA CRISTIANA ";
					}else if(opcionSeleccionada=="6807"){
					    capa.innerHTML="ECOLOGIA Y AMBIENTE ";
					}else if(opcionSeleccionada=="6808"){
					    capa.innerHTML="ACTIVIDAD EDUCATIVA EXPRESION ARTISTICA ";
					}else if(opcionSeleccionada=="6809"){
					    capa.innerHTML="ACTIVIDAD EDUCATIVA ACTIVIDADESPSICOMOTORAS ";
					}else if(opcionSeleccionada=="6810"){
					    capa.innerHTML="ENTREGANDO UN SERVICIO ";
					}else if(opcionSeleccionada=="6811"){
					    capa.innerHTML="BOSQUES DE LA REGIÓN DE AYSÉN ";
					}else if(opcionSeleccionada=="6812"){
					    capa.innerHTML="ORIENTACIÓN VOCACIONAL Y LABORAL 1 ";
					}else if(opcionSeleccionada=="6813"){
					    capa.innerHTML="TURISMO REGIONAL ";
					}else if(opcionSeleccionada=="6814"){
					    capa.innerHTML="GESTION ESTRATEGICA EMPRESARIAL ";
					}else if(opcionSeleccionada=="6815"){
					    capa.innerHTML="ESTRATEGIAS COMPETITIVAS ";
					}else if(opcionSeleccionada=="6816"){
					    capa.innerHTML="EXPLORACION AL SECTOR ADMINISTRACION Y COMERCIO ";
					}else if(opcionSeleccionada=="6817"){
					    capa.innerHTML="EXPLORACION AL SECTOR METAL MECANICO ";
					/*15*/
					
					}else if(opcionSeleccionada=="6818"){
					    capa.innerHTML="POLIDEPORTIVO ";
					}else if(opcionSeleccionada=="6819"){
					    capa.innerHTML="RAZONAMIENTO MATEMÁTICO ";
					}else if(opcionSeleccionada=="6820"){
					    capa.innerHTML="FORMACION EMPRENDEDORA. ";
					}else if(opcionSeleccionada=="6753"){
					    capa.innerHTML="LENGUAJE Y REALIDAD I ";
					}else if(opcionSeleccionada=="6754"){
					    capa.innerHTML="LENGUAJE Y REALIDAD II ";
					}else if(opcionSeleccionada=="6755"){
					    capa.innerHTML="LENGUAJES CONCRETOS / DIBUJO ";
					}else if(opcionSeleccionada=="6756"){
					    capa.innerHTML="LET\"S ACT SHAKESPEARE ";
					}else if(opcionSeleccionada=="6757"){
					    capa.innerHTML="LITERATURA E IDENTIDAD I ";
					}else if(opcionSeleccionada=="6758"){
					    capa.innerHTML="LITERATURA E IDENTIDAD II ";
					}else if(opcionSeleccionada=="6759"){
					    capa.innerHTML="LOS CIENTIFICOS Y SU APORTE A LA CIENCIA II ";
					}else if(opcionSeleccionada=="6760"){
					    capa.innerHTML="LOS DERECHOS HUMANOS Y EL CINE I ";
					}else if(opcionSeleccionada=="6761"){
					    capa.innerHTML="LOS DERECHOS HUMANOS Y EL CINE II ";
					}else if(opcionSeleccionada=="6762"){
					    capa.innerHTML="NORTH AMERICAN CONTEMPORARY DRAMA ";
					}else if(opcionSeleccionada=="6763"){
					    capa.innerHTML="QUIMICA EXPERIMENTAL DEL AMBIENTE I ";
					}else if(opcionSeleccionada=="6764"){
					    capa.innerHTML="QUIMICA EXPERIMENTAL DEL AMBIENTE II ";
					}else if(opcionSeleccionada=="6765"){
					    capa.innerHTML="RITMO AUDITIVO Y DANZA ";
					}else if(opcionSeleccionada=="6766"){
					    capa.innerHTML="SISTEMAS DE PRODUCCION ARTISTICA ";
					}else if(opcionSeleccionada=="6767"){
					    capa.innerHTML="TALLER DE EXPLORACION DE LA FORMA ";
					}else if(opcionSeleccionada=="6768"){
					    capa.innerHTML="TALLER DE EXPLORACION DE LA FORMA II ";
					}else if(opcionSeleccionada=="6769"){
					    capa.innerHTML="TALLER DE LENGUAJE AUDIOVISUAL ";
					}else if(opcionSeleccionada=="6770"){
					    capa.innerHTML="TECNICA VOCAL Y CANTO POPULAR ";
					}else if(opcionSeleccionada=="6771"){
					    capa.innerHTML="ORIENTACION TECNICO PROFESIONAL. ";
					}else if(opcionSeleccionada=="6772"){
					    capa.innerHTML="TALLER DE INICIACION AL MUNDO DEL TRABAJO ";
					}else if(opcionSeleccionada=="6773"){
					    capa.innerHTML="APRENDIZAJES Y OBSERVACIONES EN BENEFICIO DEL MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="6774"){
					    capa.innerHTML="TALLER DE EDUCACIÓN PARA LA VIDA CIUDADANA. ";
					}else if(opcionSeleccionada=="6775"){
					    capa.innerHTML="ELABORACION DE ALIMENTOS PREPARADOS ";
					}else if(opcionSeleccionada=="6776"){
					    capa.innerHTML="DISEÑO MULTIPLE ELECTIVO ";
					}else if(opcionSeleccionada=="6777"){
					    capa.innerHTML="FÍSICA CONTEMPORÁNEA ";
					}else if(opcionSeleccionada=="6778"){
					    capa.innerHTML="QUÍMICA DE LOS PROCESOS Y LA SALUD ";
					}else if(opcionSeleccionada=="6779"){
					    capa.innerHTML="APRECIACION MUSICAL I ";
					}else if(opcionSeleccionada=="6780"){
					    capa.innerHTML="ANÁLISIS BÁSICO DE LA ECONOMÍA CHILENA ";
					}else if(opcionSeleccionada=="6781"){
					    capa.innerHTML="GEOGRAFÍA TURÍSTICA DE CHILE ";
					}else if(opcionSeleccionada=="6782"){
					    capa.innerHTML="TEORÍA DEL TURISMO ";
					}else if(opcionSeleccionada=="6783"){
					    capa.innerHTML="TÓPICO DE FÍSICA INTEGRADA A LAS CIENCIAS BIOLÓGICAS QUÍMICAS ";
					}else if(opcionSeleccionada=="6784"){
					    capa.innerHTML="NOCIONES DE CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="6785"){
					    capa.innerHTML="NOCIONES DE ELECTRICIDAD ";
					}else if(opcionSeleccionada=="6786"){
					    capa.innerHTML="NOCIONES DE TURISMO ";
					}else if(opcionSeleccionada=="6719"){
					    capa.innerHTML="FISICO-MATEMATICA I ";
					}else if(opcionSeleccionada=="6720"){
					    capa.innerHTML="FISICO-MATEMATICA II ";
					}else if(opcionSeleccionada=="6721"){
					    capa.innerHTML="FUNDAMENTOS DEL PENSAMIENTO CRISTIANO OCCIDENTAL ";
					}else if(opcionSeleccionada=="6722"){
					    capa.innerHTML="HISTORIA DEL ARTE I ";
					}else if(opcionSeleccionada=="6723"){
					    capa.innerHTML="HISTORIA DEL ARTE II ";
					}else if(opcionSeleccionada=="6724"){
					    capa.innerHTML="LITERATURA Y REDACCION I ";
					}else if(opcionSeleccionada=="6725"){
					    capa.innerHTML="LITERATURA Y REDACCION II ";
					}else if(opcionSeleccionada=="6726"){
					    capa.innerHTML="MATEMATICA COMERCIAL I ";
					}else if(opcionSeleccionada=="6727"){
					    capa.innerHTML="MATEMATICA COMERCIAL II ";
					}else if(opcionSeleccionada=="6728"){
					    capa.innerHTML="MATEMATICA ESPECIFICA I ";
					}else if(opcionSeleccionada=="6729"){
					    capa.innerHTML="MATEMATICA ESPECIFICA II ";
					}else if(opcionSeleccionada=="6730"){
					    capa.innerHTML="PINTURA I ";
					}else if(opcionSeleccionada=="6731"){
					    capa.innerHTML="PINTURA II ";
					}else if(opcionSeleccionada=="6732"){
					    capa.innerHTML="AUDIOVISUALES: FOTOGRAFIA, DIAPORAMA, VIDEO, CINE, GRAFICA ";
					}else if(opcionSeleccionada=="6733"){
					    capa.innerHTML="BIOLOGIA ( ECOLOGIA ) ";
					}else if(opcionSeleccionada=="6734"){
					    capa.innerHTML="LENGUAJE INSTRUMENTAL Y SOCIEDAD ";
					}else if(opcionSeleccionada=="6735"){
					    capa.innerHTML="QUIMICA AVANZADA ";
					}else if(opcionSeleccionada=="6736"){
					    capa.innerHTML="INTRODUCCION AL P L C ,COMPONENTES ELECTRICOS Y ELECTRONICOS";
					}else if(opcionSeleccionada=="6737"){
					    capa.innerHTML="ACTUALIDAD INTERNACIONAL ";
					}else if(opcionSeleccionada=="6738"){
					    capa.innerHTML="COMPOSICION Y ARREGLOS MUSICALES II ";
					}else if(opcionSeleccionada=="6739"){
					    capa.innerHTML="CREACION Y FORMULACION DE PROYECTOS II ";
					}else if(opcionSeleccionada=="6740"){
					    capa.innerHTML="DE EUCLIDES A FERMAT I ";
					}else if(opcionSeleccionada=="6741"){
					    capa.innerHTML="DE EUCLIDES A FERMAT II ";
					}else if(opcionSeleccionada=="6742"){
					    capa.innerHTML="DESAFIOS MORALES PARA EL SIGLO XXI ";
					}else if(opcionSeleccionada=="6743"){
					    capa.innerHTML="EN LOS LIMITES DE LA CIENCIA Y LA VIDA I ";
					}else if(opcionSeleccionada=="6744"){
					    capa.innerHTML="ENSAMBLES RITMICOS CREATIVOS ";
					}else if(opcionSeleccionada=="6745"){
					    capa.innerHTML="ETICA , ECONOMIA Y POLITICA ";
					}else if(opcionSeleccionada=="6746"){
					    capa.innerHTML="FILOSOFIA LATINOAMERICANA ";
					}else if(opcionSeleccionada=="6747"){
					    capa.innerHTML="FILOSOFIA SOCIAL ";
					}else if(opcionSeleccionada=="6748"){
					    capa.innerHTML="FUNDAMENTOS DE LA MATERIA I ";
					}else if(opcionSeleccionada=="6749"){
					    capa.innerHTML="FUNDAMENTOS DE LA MATERIA II ";
					}else if(opcionSeleccionada=="6750"){
					    capa.innerHTML="GENETICA Y BIOTECNOLOGIA ";
					}else if(opcionSeleccionada=="6751"){
					    capa.innerHTML="LA ENERGIA QUE NOS RODEA ";
					}else if(opcionSeleccionada=="6752"){
					    capa.innerHTML="LA FISICA, UN MUNDO DINAMICO ";
					}else if(opcionSeleccionada=="6685"){
					    capa.innerHTML="GEOMETRIA DE TRANSICION ";
					}else if(opcionSeleccionada=="6686"){
					    capa.innerHTML="ORTOGRAFIA Y REDACCION ";
					}else if(opcionSeleccionada=="6687"){
					    capa.innerHTML="PERFECCIONANDO NUESTROS MOVIMIENTOS DEPORTIVOS ";
					}else if(opcionSeleccionada=="6688"){
					    capa.innerHTML="RECORRIDO LUDICO POR LAS RAMAS DEL ARTE ";
					}else if(opcionSeleccionada=="6689"){
					    capa.innerHTML="LENGUAJE FUNCIONAL ";
					}else if(opcionSeleccionada=="6690"){
					    capa.innerHTML="AJEDREZ ";
					}else if(opcionSeleccionada=="6691"){
					    capa.innerHTML="ELABORACION DE COMPONENTES DE MUEBLES, TERMINACIONES Y MONTAJES EN OBRAS";
					}else if(opcionSeleccionada=="6692"){
					    capa.innerHTML="HORMIGONES Y ALBAÑILERIA EN OBRAS";
					}else if(opcionSeleccionada=="6693"){
					    capa.innerHTML="INTRODUCCION A LAS MAQUINAS Y EQUIPOS ELECTRICOS";
					}else if(opcionSeleccionada=="6694"){
					    capa.innerHTML="MANTENIMIENTO DE REDES Y REPARACION DE ARTEFACTOS A GAS Y SANITARIOS";
					}else if(opcionSeleccionada=="6695"){
					    capa.innerHTML="MOLDAJES, HORMIGONES, ADITIVOS Y JUNTAS";
					}else if(opcionSeleccionada=="6696"){
					    capa.innerHTML="PROYECTOS BASICOS DE CARPINTERIA MUEBLES Y PREVENCION DE RIESGOS";
					}else if(opcionSeleccionada=="6697"){
					    capa.innerHTML="TRAZADO, MOVIMIENTOS DE TIERRA, ENFIERRADURA Y SEGURIDADAD";
					}else if(opcionSeleccionada=="6698"){
					    capa.innerHTML="DINAMICAS SOCIALES ";
					}else if(opcionSeleccionada=="6699"){
					    capa.innerHTML="OBRA GRUESA ";
					}else if(opcionSeleccionada=="6700"){
					    capa.innerHTML="OBRAS PRELIMINARES Y MANEJO DE BODEGA Y PAÑOLES ";
					}else if(opcionSeleccionada=="6701"){
					    capa.innerHTML="CULTIVO DE ALGAS ";
					}else if(opcionSeleccionada=="6702"){
					    capa.innerHTML="ESTIBA Y DESESTIBA DE NAVES MERCANTES Y ESPECIALES ";
					}else if(opcionSeleccionada=="6703"){
					    capa.innerHTML="PROCESAMIENTO Y CONTROL DE CALIDAD EN PRODUCTOS PESQUEROS ";
					}else if(opcionSeleccionada=="6704"){
					    capa.innerHTML="PRODUCCION Y PLANIFICACION EN ACUICULTURA ";
					}else if(opcionSeleccionada=="6705"){
					    capa.innerHTML="PINCELADAS POR EL MUNDO LABORAL ";
					}else if(opcionSeleccionada=="6706"){
					    capa.innerHTML="EQUIPOS DE DATOS DIGITALES ";
					}else if(opcionSeleccionada=="6707"){
					    capa.innerHTML="INSUMOS DE INDUSTRIA GRAFICA ";
					}else if(opcionSeleccionada=="6708"){
					    capa.innerHTML="TALLER DE DISEÑO GRAFICO ";
					}else if(opcionSeleccionada=="6709"){
					    capa.innerHTML="TALLER DE PUBLICIDAD EN RADIO ";
					}else if(opcionSeleccionada=="6710"){
					    capa.innerHTML="TALLER DE PUBLICIDAD EN TELEVISION ";
					}else if(opcionSeleccionada=="6711"){
					    capa.innerHTML="BIOLOGIA ESPECIFICA I ";
					}else if(opcionSeleccionada=="6712"){
					    capa.innerHTML="BIOLOGIA ESPECIFICA II ";
					}else if(opcionSeleccionada=="6713"){
					    capa.innerHTML="CIENCIAS POLITICAS I ";
					}else if(opcionSeleccionada=="6714"){
					    capa.innerHTML="CIENCIAS POLITICAS II ";
					}else if(opcionSeleccionada=="6715"){
					    capa.innerHTML="CULTURA CLASICA I ";
					}else if(opcionSeleccionada=="6716"){
					    capa.innerHTML="CULTURA CLASICA II ";
					}else if(opcionSeleccionada=="6717"){
					    capa.innerHTML="FISICA ESPECIFICA I ";
					}else if(opcionSeleccionada=="6718"){
					    capa.innerHTML="FISICA ESPECIFICA II ";
					}else if(opcionSeleccionada=="6651"){
					    capa.innerHTML="LABORATORIO TECNICO CONTABILIDAD ";
					}else if(opcionSeleccionada=="6652"){
					    capa.innerHTML="LABORATORIO TECNICO SECRETARIADO ";
					}else if(opcionSeleccionada=="6653"){
					    capa.innerHTML="MECANOGRAFIA ";
					}else if(opcionSeleccionada=="6654"){
					    capa.innerHTML="CONDICION FISICA ";
					}else if(opcionSeleccionada=="6655"){
					    capa.innerHTML="DESARROLLO ECONOMICO NACIONAL Y REGIONAL ";
					}else if(opcionSeleccionada=="6656"){
					    capa.innerHTML="FORMA Y PROCESO ";
					}else if(opcionSeleccionada=="6657"){
					    capa.innerHTML="HISTORIA MARITIMA ";
					}else if(opcionSeleccionada=="6658"){
					    capa.innerHTML="LENGUAJE Y RELACIONES HUMANAS ";
					}else if(opcionSeleccionada=="6659"){
					    capa.innerHTML="PERSPECTIVA DEL DESARROLLO DE VALPARAISO ";
					}else if(opcionSeleccionada=="6660"){
					    capa.innerHTML="FILOSOFIA Y PSICOLOGIA: PROBLEMAS DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="6661"){
					    capa.innerHTML="FILOSOFIA Y PSICOLOGIA: ARGUMENTACION ";
					}else if(opcionSeleccionada=="6662"){
					    capa.innerHTML="LENGUA CASTELLANA Y COMUNICACION-LITERATURA E IDENTIDAD ";
					}else if(opcionSeleccionada=="6663"){
					    capa.innerHTML="DECORE EL HOGAR ";
					}else if(opcionSeleccionada=="6664"){
					    capa.innerHTML="SIMBOLOS DE IDENTIDAD PATRIOS ";
					}else if(opcionSeleccionada=="6665"){
					    capa.innerHTML="COMUNICACION ORGANIZACIONAL Y GESTION DE COMPRAVENTA ";
					}else if(opcionSeleccionada=="6666"){
					    capa.innerHTML="INVESTIGACION DE MERCADO Y VERIFICACION DE EXISTENCIAS ";
					}else if(opcionSeleccionada=="6667"){
					    capa.innerHTML="LABORATORIO HABITOS DE ESTUDIO ";
					}else if(opcionSeleccionada=="6668"){
					    capa.innerHTML="PRACTICAS DE LABORATORIO ";
					}else if(opcionSeleccionada=="6669"){
					    capa.innerHTML="REDACCION Y APLICACION INFORMATICA, DATOS Y ARCHIVOS ";
					}else if(opcionSeleccionada=="6670"){
					    capa.innerHTML="SERVICIO DE ATENCION AL CLIENTE Y TECNICAS DE VENTAS ";
					}else if(opcionSeleccionada=="6671"){
					    capa.innerHTML="COMPRENSION DEL LENGUAJE INFORMATICO ";
					}else if(opcionSeleccionada=="6672"){
					    capa.innerHTML="TALLER DE INVESTIGACION CIENTIFICA ";
					}else if(opcionSeleccionada=="6673"){
					    capa.innerHTML="CONTROL DE CALIDAD EN SOLDADURA ";
					}else if(opcionSeleccionada=="6674"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN ARTES MUSICALES ";
					}else if(opcionSeleccionada=="6675"){
					    capa.innerHTML="MANTENIMIENTOS DE LOS SISTEMAS DE TRANSMISION Y FRENADO ";
					}else if(opcionSeleccionada=="6676"){
					    capa.innerHTML="APRENDER MATEMATICA ";
					}else if(opcionSeleccionada=="6677"){
					    capa.innerHTML="APRENDER MATEMATICAS CON MODELOS ALGEBRAICOS ";
					}else if(opcionSeleccionada=="6678"){
					    capa.innerHTML="CONOCIENDO EL JUEGO ";
					}else if(opcionSeleccionada=="6679"){
					    capa.innerHTML="CRECIENDO A TRAVES DEL JUEGO ";
					}else if(opcionSeleccionada=="6680"){
					    capa.innerHTML="DE LA ECONOMIA A LA ORGANIZACION POLITICA ";
					}else if(opcionSeleccionada=="6681"){
					    capa.innerHTML="DESCUBRIENDO LA NATURALEZA ";
					}else if(opcionSeleccionada=="6682"){
					    capa.innerHTML="EL JUEGO TEATRAL ";
					}else if(opcionSeleccionada=="6683"){
					    capa.innerHTML="ENGLISH AROUND US ";
					}else if(opcionSeleccionada=="6684"){
					    capa.innerHTML="ERASE UNA VEZ LA CIENCIA ";
					}else if(opcionSeleccionada=="6617"){
					    capa.innerHTML="AUDIOVISUAL: FILOSOFIA, DIAPORAMA, VIDEO ";
					}else if(opcionSeleccionada=="6618"){
					    capa.innerHTML="MODULO CULTURAL LITERARIO INGLES ";
					}else if(opcionSeleccionada=="6619"){
					    capa.innerHTML="MAQUINARIA, RIEGO, FERTILIZACION ";
					}else if(opcionSeleccionada=="6620"){
					    capa.innerHTML="TALLER DE INFORMATICA EDUCATIVA ";
					}else if(opcionSeleccionada=="6621"){
					    capa.innerHTML="TALLER ROTATORIO ";
					}else if(opcionSeleccionada=="6622"){
					    capa.innerHTML="DISEÑO DE ESTRATEGIAS PARA RESOLVER PROBLEMAS ";
					}else if(opcionSeleccionada=="6623"){
					    capa.innerHTML="ESCRITORES Y POETAS MIRANDO AL MUNDO ";
					}else if(opcionSeleccionada=="6624"){
					    capa.innerHTML="HISTORIA CONSTITUCIONAL Y EVOLUCION LIMITROFE DE CHILE ";
					}else if(opcionSeleccionada=="6625"){
					    capa.innerHTML="INGLISH FOR SPECIFIC PURPOSES ";
					}else if(opcionSeleccionada=="6626"){
					    capa.innerHTML="LA CIENCIA Y LA LITERATURA ";
					}else if(opcionSeleccionada=="6627"){
					    capa.innerHTML="OPINION PÚBLICA Y MEDIOS DE COMUNICACION ";
					}else if(opcionSeleccionada=="6628"){
					    capa.innerHTML="PROBLEMAS ETICOS DEL HOMBRE CONTEMPORANEO ";
					}else if(opcionSeleccionada=="6629"){
					    capa.innerHTML="RECREACION Y VIDA AL AIRE LIBRE ";
					}else if(opcionSeleccionada=="6630"){
					    capa.innerHTML="CIMENTANDO EL SER ";
					}else if(opcionSeleccionada=="6631"){
					    capa.innerHTML="FUNDAMENTOS ";
					}else if(opcionSeleccionada=="6632"){
					    capa.innerHTML="FUNDAMENTOS Y TECNOLOGIA ";
					}else if(opcionSeleccionada=="6633"){
					    capa.innerHTML="EDUCACION TECNOLOGICA E INFORMATICA ";
					}else if(opcionSeleccionada=="6634"){
					    capa.innerHTML="FUNDAMENTOS DE LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="6635"){
					    capa.innerHTML="LA LENGUA CASTELLANA EN AMERICA ";
					}else if(opcionSeleccionada=="6636"){
					    capa.innerHTML="MODAS ";
					}else if(opcionSeleccionada=="6637"){
					    capa.innerHTML="LENGUAJE COMO HERRAMIENTA PRODUCTIVA ";
					}else if(opcionSeleccionada=="6638"){
					    capa.innerHTML="INGLES SOCIAL COMUNICATIVO CIENTIFICO ";
					}else if(opcionSeleccionada=="6639"){
					    capa.innerHTML="INGLES SOCIAL COMUNICATIVO HUMANISTICO ";
					}else if(opcionSeleccionada=="6640"){
					    capa.innerHTML="PERFORACION Y TRONADURA EN METODOS DE EXPLOTACION ";
					}else if(opcionSeleccionada=="6641"){
					    capa.innerHTML="RECONOCIMIENTO DE ROCAS ";
					}else if(opcionSeleccionada=="6642"){
					    capa.innerHTML="TOPOGRAFIA EN MINERIA DE SUPERFICIE ";
					}else if(opcionSeleccionada=="6643"){
					    capa.innerHTML="LENGUAJE Y ARGUMENTACION :EXPERIENCIAS Y REFLEXIONES ";
					}else if(opcionSeleccionada=="6644"){
					    capa.innerHTML="ADMINISTRACION DE PEQUEÑA EMPRESA MINERA ";
					}else if(opcionSeleccionada=="6645"){
					    capa.innerHTML="GESTION SEGURA Y DE CALIDAD EN PLANTAS DE PROCESAMIENTO ";
					}else if(opcionSeleccionada=="6646"){
					    capa.innerHTML="CULTURAL LITERARIO DE INGLES ";
					}else if(opcionSeleccionada=="6647"){
					    capa.innerHTML="PELUQUERIA Y COSMETOLOGIA ";
					}else if(opcionSeleccionada=="6648"){
					    capa.innerHTML="INTRODUCCION A LA PSICOLOGIA MODERNA ";
					}else if(opcionSeleccionada=="6649"){
					    capa.innerHTML="PARTICIPACION CIUDADANA: COMPROMISO DE CAMBIO ";
					}else if(opcionSeleccionada=="6650"){
					    capa.innerHTML="PSICOLOGIA DEL DESARROLLO ";
					}else if(opcionSeleccionada=="6583"){
					    capa.innerHTML="VIDA SALUDABLE ";
					/*16*/
					
					}else if(opcionSeleccionada=="6856"){
					    capa.innerHTML="MAQUINARIA NAVAL AUXILIAR ";
					}else if(opcionSeleccionada=="6857"){
					    capa.innerHTML="MAQUINARIA NAVAL PRINCIPAL ";
					}else if(opcionSeleccionada=="6858"){
					    capa.innerHTML="NAÚTICA Y ESTABILIDAD ";
					}else if(opcionSeleccionada=="6859"){
					    capa.innerHTML="REGLAMENTACIÓN MARÍTIMA Y AMBIENTAL ";
					}else if(opcionSeleccionada=="6860"){
					    capa.innerHTML="SISTEMAS HIDRÁULICOS ";
					}else if(opcionSeleccionada=="6861"){
					    capa.innerHTML="SISTEMAS NEUMÁTICOS ";
					}else if(opcionSeleccionada=="6862"){
					    capa.innerHTML="INGLÉS CIENTIFICO - HUMANISTA PLAN DIFERENCIADO 4º AÑO MEDIO ";
					}else if(opcionSeleccionada=="6863"){
					    capa.innerHTML="APLICACIONES INFORMATICA AVANZADA ";
					}else if(opcionSeleccionada=="6864"){
					    capa.innerHTML="NORMATIVA PREVISIONAL, LABORAL, COMERCIAL Y TRIBUTARIA ";
					}else if(opcionSeleccionada=="6865"){
					    capa.innerHTML="SALUD Y ADMINISTRACION I ";
					}else if(opcionSeleccionada=="6866"){
					    capa.innerHTML="COSTO Y ESTADO DE RESULTADO / GESTIÓN DE PEQUEÑA EMPRESA. ";
					}else if(opcionSeleccionada=="6867"){
					    capa.innerHTML="GESTIÓN DE COMPRAVENTA Y DE APROVISIONAMIENTO ";
					}else if(opcionSeleccionada=="6868"){
					    capa.innerHTML="SERVICIO DE ATENCIÓN AL CLIENTE/COMUNICACIÓN ORGANIZACIONAL ";
					}else if(opcionSeleccionada=="6870"){
					    capa.innerHTML="INTRODUCCION A LA CONTABILIDAD ";
					}else if(opcionSeleccionada=="6871"){
					    capa.innerHTML="ARMADO Y DESARMADO DE PC ";
					}else if(opcionSeleccionada=="6872"){
					    capa.innerHTML="PROYECTOS ELECTRONICOS ";
					}else if(opcionSeleccionada=="6873"){
					    capa.innerHTML="ECONOMIA Y COMERCIO ";
					}else if(opcionSeleccionada=="6874"){
					    capa.innerHTML="ETICA Y RELACION LABORAL ";
					}else if(opcionSeleccionada=="6875"){
					    capa.innerHTML="TEORIA Y PRACTICA DE PROYECTOS ";
					}else if(opcionSeleccionada=="6876"){
					    capa.innerHTML="MANTENCIÓN DE LA ROPA ";
					}else if(opcionSeleccionada=="6877"){
					    capa.innerHTML="TÉCNICAS BÁSICAS DE COMPUTACIÓN ";
					}else if(opcionSeleccionada=="6878"){
					    capa.innerHTML="HORTALIZAS ";
					}else if(opcionSeleccionada=="6879"){
					    capa.innerHTML="PLANTAS MEDICINALES ";
					}else if(opcionSeleccionada=="6880"){
					    capa.innerHTML="PROCESO AGROINDUSTRIAL ";
					}else if(opcionSeleccionada=="6881"){
					    capa.innerHTML="COMPRENSIÓN DEL MEDIO CULTURAL Y SOCIAL; ITALIANO ";
					}else if(opcionSeleccionada=="6882"){
					    capa.innerHTML="COORDINACIÒN FÌSICA Y MOTRIZ ASOCIADA A SALUD Y CALIDAD DE VIDA";
					}else if(opcionSeleccionada=="6883"){
					    capa.innerHTML="CULTIVO DE PECES Y CRUSTACEOS Y CULTIVOS DE ALGAS ";
					}else if(opcionSeleccionada=="6884"){
					    capa.innerHTML="EXPRESIÒN ORAL, ESCRITA Y COMUNICACIÒN ";
					}else if(opcionSeleccionada=="6885"){
					    capa.innerHTML="PREPARADO Y CONFECCIÒN DE PRENDAS MASCULINA DE VESTIR Y DE TRABAJO";
					}else if(opcionSeleccionada=="6886"){
					    capa.innerHTML="PROGRAMAS DE DISEÑO I ";
					}else if(opcionSeleccionada=="6887"){
					    capa.innerHTML="PROGRAMAS DE OFICINAS I ";
					}else if(opcionSeleccionada=="6888"){
					    capa.innerHTML="GESTION SEGURA Y DE CALIDAD ";
					}else if(opcionSeleccionada=="6889"){
					    capa.innerHTML="CONTEXTUALIZACION DE LA HISTORIA I ";
					}else if(opcionSeleccionada=="6821"){
					    capa.innerHTML="TECNICA DE VESTUARIO ";
					}else if(opcionSeleccionada=="6822"){
					    capa.innerHTML="INTRODUCCION AL CINE ";
					}else if(opcionSeleccionada=="6823"){
					    capa.innerHTML="DESARROLLO PERSONAL Y ORIENTACION VOCACIONAL ";
					}else if(opcionSeleccionada=="6824"){
					    capa.innerHTML="INTEGRACION Y DESARROLLO COMUNITARIO ";
					}else if(opcionSeleccionada=="6825"){
					    capa.innerHTML="OPERACIONES DE MECANIZADOS ";
					}else if(opcionSeleccionada=="6826"){
					    capa.innerHTML="ECONOMÍA Y FILOSOFÍA. ";
					}else if(opcionSeleccionada=="6827"){
					    capa.innerHTML="EDUCACIÓN CÍVICA Y BIOQUÍMICA ";
					}else if(opcionSeleccionada=="6828"){
					    capa.innerHTML="BIOLOGIA AVANZADA ";
					}else if(opcionSeleccionada=="6829"){
					    capa.innerHTML="FISICA AVANZADA ";
					}else if(opcionSeleccionada=="6830"){
					    capa.innerHTML="LA QUIMICA Y LOS BENEFICIOS PARA LA SALUD HUMANA ";
					}else if(opcionSeleccionada=="6831"){
					    capa.innerHTML="PREPARACION DE ESTADOS FINANCIEROS ";
					}else if(opcionSeleccionada=="6832"){
					    capa.innerHTML="TIPO Y VALORES HUMANOS EN LA LITERATURA UNIVERSAL ";
					}else if(opcionSeleccionada=="6833"){
					    capa.innerHTML="RENDIMIENTO PORTUARIO ";
					}else if(opcionSeleccionada=="6834"){
					    capa.innerHTML="ANTROPOLOGÍA, CRECIMIENTO Y DESARROLLO PERSONAL ";	
					/*17*/
					}else if(opcionSeleccionada=="6835"){
					    capa.innerHTML="FUNDAMENTOS DE BOTANICA ";
					}else if(opcionSeleccionada=="6836"){
					    capa.innerHTML="PRINCIPIOS BASICOS DE ECONOMIA ";
					}else if(opcionSeleccionada=="6837"){
					    capa.innerHTML="NOCIONES DE ECOLOGIA PARA EL DESARROLLO HUMANO ";
					}else if(opcionSeleccionada=="6838"){
					    capa.innerHTML="TECNICAS DE RELACIONES HUMANAS Y ATENCION DE PUBLICO ";
					}else if(opcionSeleccionada=="6839"){
					    capa.innerHTML="PROBLEMAS GNOSEOLÓGICOS DEL HOMBRE CONTEMPORÁNEO ";
					}else if(opcionSeleccionada=="6840"){
					    capa.innerHTML="IMÁGENES DE NUESTRA HISTORIA, SIGNIFICADO Y TRASCENDENCIA ";
					}else if(opcionSeleccionada=="6841"){
					    capa.innerHTML="NUESTRO TERRITORIO, IMAGEN GEOGRÁFICA Y PATRIMONIO ECONÓMICO ";
					}else if(opcionSeleccionada=="6842"){
					    capa.innerHTML="ELECTIVO ARTISTICO I ";
					}else if(opcionSeleccionada=="6843"){
					    capa.innerHTML="ELECTIVO ARTISTICO II ";
					}else if(opcionSeleccionada=="6844"){
					    capa.innerHTML="ELECTIVO EDUCACION TECNOLOGICA I ";
					}else if(opcionSeleccionada=="6845"){
					    capa.innerHTML="ELECTIVO EDUCACION TECNOLOGICA II ";
					}else if(opcionSeleccionada=="6846"){
					    capa.innerHTML="ELECTIVO MULTIDISCIPLINARIO ";
					}else if(opcionSeleccionada=="6847"){
					    capa.innerHTML="APROVECHAMIENTO INTEGRAL DE MADERA, TINTES Y TEJIDOS ARTESANALES";
					}else if(opcionSeleccionada=="6848"){
					    capa.innerHTML="BOTANICA ";
					}else if(opcionSeleccionada=="6849"){
					    capa.innerHTML="CURSO BASICO DE MONTAÑA ";
					}else if(opcionSeleccionada=="6850"){
					    capa.innerHTML="ECOLOGIA Y TURISMO ";
					}else if(opcionSeleccionada=="6851"){
					    capa.innerHTML="ECONOMIA Y LEGISLACION DEL TURISMO ";
					}else if(opcionSeleccionada=="6852"){
					    capa.innerHTML="INTRODUCCION AL ECOTURISMO ";
					}else if(opcionSeleccionada=="6853"){
					    capa.innerHTML="PRACTICA LABORAL ";
					}else if(opcionSeleccionada=="6854"){
					    capa.innerHTML="RELACIONES PUBLICAS Y LEGISLACION ";
					}else if(opcionSeleccionada=="6787"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION CASTELLANO, PLAN DIFERENCIAL ";
					}else if(opcionSeleccionada=="6788"){
					    capa.innerHTML="MATEMATICAS PLAN DIFERENCIAL. ";
					}else if(opcionSeleccionada=="6789"){
					    capa.innerHTML="PREPARACIÓN GENERAL DEL EQUIPO PESADO PARA LA PUESTA EN MARCHA";
					}else if(opcionSeleccionada=="6790"){
					    capa.innerHTML="SOCIALIZACIÓN EN EL CRECIMIENTO PROFESIONAL ";
					}else if(opcionSeleccionada=="6791"){
					    capa.innerHTML="LENGUAJE, SOCIEDAD Y HABILIDADES SOCIALES ";
					}else if(opcionSeleccionada=="6792"){
					    capa.innerHTML="PROGRAMA SECTOR CURRICULAR EDUCACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="6793"){
					    capa.innerHTML="EDUCACION ARTISTICA MUSICAL ";
					}else if(opcionSeleccionada=="6794"){
					    capa.innerHTML="INGLES: MODULO LITERARIO CULTURAL ";
					}else if(opcionSeleccionada=="6795"){
					    capa.innerHTML="CIENCIAS SOCIALES, REALIDAD NACIONAL Y LOCAL. ";
					}else if(opcionSeleccionada=="6796"){
					    capa.innerHTML="LENGUAJE, SOCIEDAD. ";
					}else if(opcionSeleccionada=="6797"){
					    capa.innerHTML="GEOGRAFIA FISICA APLICADA ";
					}else if(opcionSeleccionada=="6798"){
					    capa.innerHTML="LA GRÁFICA ORIENTADA AL DIBUJO TÉCNICO ARQUITECTÓNICO ";
					}else if(opcionSeleccionada=="6799"){
					    capa.innerHTML="LENGUAJE, REDACCIÓN Y ORATORIA ";
					}else if(opcionSeleccionada=="6800"){
					    capa.innerHTML="MÉTODO DE INVESTIGACIÓN EN CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="6801"){
					    capa.innerHTML="NARRATIVA CHILENA E HISPANOAMERICANA ";
					}else if(opcionSeleccionada=="6802"){
					    capa.innerHTML="TRIGONOMETRÍA Y GEOMETRIA ANALITICA ";
					}else if(opcionSeleccionada=="6803"){
					    capa.innerHTML="PREPARACION DEL ESTADO FINANCIERO ";
					}else if(opcionSeleccionada=="6804"){
					    capa.innerHTML="CONTABILIDAD OPERATIVA ";
					}else if(opcionSeleccionada=="6805"){
					    capa.innerHTML="GESTION DE LA PEQUEÑA EMPRESA COSTOS Y ESTADO DE RESULTADO ";
					}else if(opcionSeleccionada=="6806"){
					    capa.innerHTML="CULTURA CRISTIANA ";
					/*18*/
					
					}else if(opcionSeleccionada=="6807"){
					    capa.innerHTML="ECOLOGIA Y AMBIENTE ";
					}else if(opcionSeleccionada=="6808"){
					    capa.innerHTML="ACTIVIDAD EDUCATIVA EXPRESION ARTISTICA ";
					}else if(opcionSeleccionada=="6809"){
					    capa.innerHTML="ACTIVIDAD EDUCATIVA ACTIVIDADESPSICOMOTORAS ";
					}else if(opcionSeleccionada=="6810"){
					    capa.innerHTML="ENTREGANDO UN SERVICIO ";
					}else if(opcionSeleccionada=="6811"){
					    capa.innerHTML="BOSQUES DE LA REGIÓN DE AYSÉN ";
					}else if(opcionSeleccionada=="6812"){
					    capa.innerHTML="ORIENTACIÓN VOCACIONAL Y LABORAL 1 ";
					}else if(opcionSeleccionada=="6813"){
					    capa.innerHTML="TURISMO REGIONAL ";
					}else if(opcionSeleccionada=="6814"){
					    capa.innerHTML="GESTION ESTRATEGICA EMPRESARIAL ";
					}else if(opcionSeleccionada=="6815"){
					    capa.innerHTML="ESTRATEGIAS COMPETITIVAS ";
					}else if(opcionSeleccionada=="6816"){
					    capa.innerHTML="EXPLORACION AL SECTOR ADMINISTRACION Y COMERCIO ";
					}else if(opcionSeleccionada=="6817"){
					    capa.innerHTML="EXPLORACION AL SECTOR METAL MECANICO ";
					}else if(opcionSeleccionada=="6818"){
					    capa.innerHTML="POLIDEPORTIVO ";
					}else if(opcionSeleccionada=="6819"){
					    capa.innerHTML="RAZONAMIENTO MATEMÁTICO ";
					}else if(opcionSeleccionada=="6820"){
					    capa.innerHTML="FORMACION EMPRENDEDORA. ";
					}else if(opcionSeleccionada=="6753"){
					    capa.innerHTML="LENGUAJE Y REALIDAD I ";
					}else if(opcionSeleccionada=="6754"){
					    capa.innerHTML="LENGUAJE Y REALIDAD II ";
					}else if(opcionSeleccionada=="6755"){
					    capa.innerHTML="LENGUAJES CONCRETOS / DIBUJO ";
					}else if(opcionSeleccionada=="6756"){
					    capa.innerHTML="LET\"S ACT SHAKESPEARE ";
					}else if(opcionSeleccionada=="6757"){
					    capa.innerHTML="LITERATURA E IDENTIDAD I ";
					}else if(opcionSeleccionada=="6758"){
					    capa.innerHTML="LITERATURA E IDENTIDAD II ";
					}else if(opcionSeleccionada=="6759"){
					    capa.innerHTML="LOS CIENTIFICOS Y SU APORTE A LA CIENCIA II ";
					}else if(opcionSeleccionada=="6760"){
					    capa.innerHTML="LOS DERECHOS HUMANOS Y EL CINE I ";
					}else if(opcionSeleccionada=="6761"){
					    capa.innerHTML="LOS DERECHOS HUMANOS Y EL CINE II ";
					}else if(opcionSeleccionada=="6762"){
					    capa.innerHTML="NORTH AMERICAN CONTEMPORARY DRAMA ";
					}else if(opcionSeleccionada=="6763"){
					    capa.innerHTML="QUIMICA EXPERIMENTAL DEL AMBIENTE I ";
					}else if(opcionSeleccionada=="6764"){
					    capa.innerHTML="QUIMICA EXPERIMENTAL DEL AMBIENTE II ";
					}else if(opcionSeleccionada=="6765"){
					    capa.innerHTML="RITMO AUDITIVO Y DANZA ";
					}else if(opcionSeleccionada=="6766"){
					    capa.innerHTML="SISTEMAS DE PRODUCCION ARTISTICA ";
					}else if(opcionSeleccionada=="6767"){
					    capa.innerHTML="TALLER DE EXPLORACION DE LA FORMA ";
					}else if(opcionSeleccionada=="6768"){
					    capa.innerHTML="TALLER DE EXPLORACION DE LA FORMA II ";
					}else if(opcionSeleccionada=="6769"){
					    capa.innerHTML="TALLER DE LENGUAJE AUDIOVISUAL ";
					}else if(opcionSeleccionada=="6770"){
					    capa.innerHTML="TECNICA VOCAL Y CANTO POPULAR ";
					}else if(opcionSeleccionada=="6771"){
					    capa.innerHTML="ORIENTACION TECNICO PROFESIONAL. ";
					}else if(opcionSeleccionada=="6772"){
					    capa.innerHTML="TALLER DE INICIACION AL MUNDO DEL TRABAJO ";
					}else if(opcionSeleccionada=="6773"){
					    capa.innerHTML="APRENDIZAJES Y OBSERVACIONES EN BENEFICIO DEL MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="6774"){
					    capa.innerHTML="TALLER DE EDUCACIÓN PARA LA VIDA CIUDADANA. ";
					}else if(opcionSeleccionada=="6775"){
					    capa.innerHTML="ELABORACION DE ALIMENTOS PREPARADOS ";
					}else if(opcionSeleccionada=="6776"){
					    capa.innerHTML="DISEÑO MULTIPLE ELECTIVO ";
					}else if(opcionSeleccionada=="6777"){
					    capa.innerHTML="FÍSICA CONTEMPORÁNEA ";
					}else if(opcionSeleccionada=="6778"){
					    capa.innerHTML="QUÍMICA DE LOS PROCESOS Y LA SALUD ";
					/*19*/
					}else if(opcionSeleccionada=="6779"){
					    capa.innerHTML="APRECIACION MUSICAL I ";
					}else if(opcionSeleccionada=="6780"){
					    capa.innerHTML="ANÁLISIS BÁSICO DE LA ECONOMÍA CHILENA ";
					}else if(opcionSeleccionada=="6781"){
					    capa.innerHTML="GEOGRAFÍA TURÍSTICA DE CHILE ";
					}else if(opcionSeleccionada=="6782"){
					    capa.innerHTML="TEORÍA DEL TURISMO ";
					}else if(opcionSeleccionada=="6783"){
					    capa.innerHTML="TÓPICO DE FÍSICA INTEGRADA A LAS CIENCIAS BIOLÓGICAS QUÍMICAS ";
					}else if(opcionSeleccionada=="6784"){
					    capa.innerHTML="NOCIONES DE CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="6785"){
					    capa.innerHTML="NOCIONES DE ELECTRICIDAD ";
					}else if(opcionSeleccionada=="6786"){
					    capa.innerHTML="NOCIONES DE TURISMO ";
					}else if(opcionSeleccionada=="6719"){
					    capa.innerHTML="FISICO-MATEMATICA I ";
					}else if(opcionSeleccionada=="6720"){
					    capa.innerHTML="FISICO-MATEMATICA II ";
					}else if(opcionSeleccionada=="6721"){
					    capa.innerHTML="FUNDAMENTOS DEL PENSAMIENTO CRISTIANO OCCIDENTAL ";
					}else if(opcionSeleccionada=="6722"){
					    capa.innerHTML="HISTORIA DEL ARTE I ";
					}else if(opcionSeleccionada=="6723"){
					    capa.innerHTML="HISTORIA DEL ARTE II ";
					}else if(opcionSeleccionada=="6724"){
					    capa.innerHTML="LITERATURA Y REDACCION I ";
					}else if(opcionSeleccionada=="6725"){
					    capa.innerHTML="LITERATURA Y REDACCION II ";
					}else if(opcionSeleccionada=="6726"){
					    capa.innerHTML="MATEMATICA COMERCIAL I ";
					}else if(opcionSeleccionada=="6727"){
					    capa.innerHTML="MATEMATICA COMERCIAL II ";
					}else if(opcionSeleccionada=="6728"){
					    capa.innerHTML="MATEMATICA ESPECIFICA I ";
					}else if(opcionSeleccionada=="6729"){
					    capa.innerHTML="MATEMATICA ESPECIFICA II ";
					}else if(opcionSeleccionada=="6730"){
					    capa.innerHTML="PINTURA I ";
					}else if(opcionSeleccionada=="6731"){
					    capa.innerHTML="PINTURA II ";
					}else if(opcionSeleccionada=="6732"){
					    capa.innerHTML="AUDIOVISUALES: FOTOGRAFIA, DIAPORAMA, VIDEO, CINE, GRAFICA ";
					}else if(opcionSeleccionada=="6733"){
					    capa.innerHTML="BIOLOGIA ( ECOLOGIA ) ";
					}else if(opcionSeleccionada=="6734"){
					    capa.innerHTML="LENGUAJE INSTRUMENTAL Y SOCIEDAD ";
					}else if(opcionSeleccionada=="6735"){
					    capa.innerHTML="QUIMICA AVANZADA ";
					}else if(opcionSeleccionada=="6736"){
					    capa.innerHTML="INTRODUCCION AL P L C ,COMPONENTES ELECTRICOS Y ELECTRONICOS";
					}else if(opcionSeleccionada=="6737"){
					    capa.innerHTML="ACTUALIDAD INTERNACIONAL ";
					}else if(opcionSeleccionada=="6738"){
					    capa.innerHTML="COMPOSICION Y ARREGLOS MUSICALES II ";
					}else if(opcionSeleccionada=="6739"){
					    capa.innerHTML="CREACION Y FORMULACION DE PROYECTOS II ";
					}else if(opcionSeleccionada=="6740"){
					    capa.innerHTML="DE EUCLIDES A FERMAT I ";
					}else if(opcionSeleccionada=="6741"){
					    capa.innerHTML="DE EUCLIDES A FERMAT II ";
					}else if(opcionSeleccionada=="6742"){
					    capa.innerHTML="DESAFIOS MORALES PARA EL SIGLO XXI ";
					}else if(opcionSeleccionada=="6743"){
					    capa.innerHTML="EN LOS LIMITES DE LA CIENCIA Y LA VIDA I ";
					}else if(opcionSeleccionada=="6744"){
					    capa.innerHTML="ENSAMBLES RITMICOS CREATIVOS ";
					}else if(opcionSeleccionada=="6745"){
					    capa.innerHTML="ETICA , ECONOMIA Y POLITICA ";
					}else if(opcionSeleccionada=="6746"){
					    capa.innerHTML="FILOSOFIA LATINOAMERICANA ";
					}else if(opcionSeleccionada=="6747"){
					    capa.innerHTML="FILOSOFIA SOCIAL ";
					}else if(opcionSeleccionada=="6748"){
					    capa.innerHTML="FUNDAMENTOS DE LA MATERIA I ";
					}else if(opcionSeleccionada=="6749"){
					    capa.innerHTML="FUNDAMENTOS DE LA MATERIA II ";
					}else if(opcionSeleccionada=="6750"){
					    capa.innerHTML="GENETICA Y BIOTECNOLOGIA ";
					}else if(opcionSeleccionada=="6751"){
					    capa.innerHTML="LA ENERGIA QUE NOS RODEA ";
					}else if(opcionSeleccionada=="6752"){
					    capa.innerHTML="LA FISICA, UN MUNDO DINAMICO ";
					}else if(opcionSeleccionada=="6685"){
					    capa.innerHTML="GEOMETRIA DE TRANSICION ";
					}else if(opcionSeleccionada=="6686"){
					    capa.innerHTML="ORTOGRAFIA Y REDACCION ";
					}else if(opcionSeleccionada=="6687"){
					    capa.innerHTML="PERFECCIONANDO NUESTROS MOVIMIENTOS DEPORTIVOS ";
					}else if(opcionSeleccionada=="6688"){
					    capa.innerHTML="RECORRIDO LUDICO POR LAS RAMAS DEL ARTE ";
					}else if(opcionSeleccionada=="6689"){
					    capa.innerHTML="LENGUAJE FUNCIONAL ";
					}else if(opcionSeleccionada=="6690"){
					    capa.innerHTML="AJEDREZ ";
					}else if(opcionSeleccionada=="6691"){
					    capa.innerHTML="ELABORACION DE COMPONENTES DE MUEBLES, TERMINACIONES Y MONTAJES EN OBRAS";
					}else if(opcionSeleccionada=="6692"){
					    capa.innerHTML="HORMIGONES Y ALBAÑILERIA EN OBRAS";
					}else if(opcionSeleccionada=="6693"){
					    capa.innerHTML="INTRODUCCION A LAS MAQUINAS Y EQUIPOS ELECTRICOS";
					}else if(opcionSeleccionada=="6694"){
					    capa.innerHTML="MANTENIMIENTO DE REDES Y REPARACION DE ARTEFACTOS A GAS Y SANITARIOS";
					}else if(opcionSeleccionada=="6695"){
					    capa.innerHTML="MOLDAJES, HORMIGONES, ADITIVOS Y JUNTAS";
					}else if(opcionSeleccionada=="6696"){
					    capa.innerHTML="PROYECTOS BASICOS DE CARPINTERIA MUEBLES Y PREVENCION DE RIESGOS";
					}else if(opcionSeleccionada=="6697"){
					    capa.innerHTML="TRAZADO, MOVIMIENTOS DE TIERRA, ENFIERRADURA Y SEGURIDADAD";
					}else if(opcionSeleccionada=="6698"){
					    capa.innerHTML="DINAMICAS SOCIALES ";
					}else if(opcionSeleccionada=="6699"){
					    capa.innerHTML="OBRA GRUESA ";
					}else if(opcionSeleccionada=="6700"){
					    capa.innerHTML="OBRAS PRELIMINARES Y MANEJO DE BODEGA Y PAÑOLES ";
					}else if(opcionSeleccionada=="6701"){
					    capa.innerHTML="CULTIVO DE ALGAS ";
					}else if(opcionSeleccionada=="6702"){
					    capa.innerHTML="ESTIBA Y DESESTIBA DE NAVES MERCANTES Y ESPECIALES ";
					}else if(opcionSeleccionada=="6703"){
					    capa.innerHTML="PROCESAMIENTO Y CONTROL DE CALIDAD EN PRODUCTOS PESQUEROS ";
					}else if(opcionSeleccionada=="6704"){
					    capa.innerHTML="PRODUCCION Y PLANIFICACION EN ACUICULTURA ";
					}else if(opcionSeleccionada=="6705"){
					    capa.innerHTML="PINCELADAS POR EL MUNDO LABORAL ";
					}else if(opcionSeleccionada=="6706"){
					    capa.innerHTML="EQUIPOS DE DATOS DIGITALES ";
					}else if(opcionSeleccionada=="6707"){
					    capa.innerHTML="INSUMOS DE INDUSTRIA GRAFICA ";
					}else if(opcionSeleccionada=="6708"){
					    capa.innerHTML="TALLER DE DISEÑO GRAFICO ";
					}else if(opcionSeleccionada=="6709"){
					    capa.innerHTML="TALLER DE PUBLICIDAD EN RADIO ";
					}else if(opcionSeleccionada=="6710"){
					    capa.innerHTML="TALLER DE PUBLICIDAD EN TELEVISION ";
					}else if(opcionSeleccionada=="6711"){
					    capa.innerHTML="BIOLOGIA ESPECIFICA I ";
					}else if(opcionSeleccionada=="6712"){
					    capa.innerHTML="BIOLOGIA ESPECIFICA II ";
					}else if(opcionSeleccionada=="6713"){
					    capa.innerHTML="CIENCIAS POLITICAS I ";
					}else if(opcionSeleccionada=="6714"){
					    capa.innerHTML="CIENCIAS POLITICAS II ";
					}else if(opcionSeleccionada=="6715"){
					    capa.innerHTML="CULTURA CLASICA I ";
					}else if(opcionSeleccionada=="6716"){
					    capa.innerHTML="CULTURA CLASICA II ";
					}else if(opcionSeleccionada=="6717"){
					    capa.innerHTML="FISICA ESPECIFICA I ";
					}else if(opcionSeleccionada=="6718"){
					    capa.innerHTML="FISICA ESPECIFICA II ";
					}else if(opcionSeleccionada=="6651"){
					    capa.innerHTML="LABORATORIO TECNICO CONTABILIDAD ";
					}else if(opcionSeleccionada=="6652"){
					    capa.innerHTML="LABORATORIO TECNICO SECRETARIADO ";
					}else if(opcionSeleccionada=="6653"){
					    capa.innerHTML="MECANOGRAFIA ";
					}else if(opcionSeleccionada=="6654"){
					    capa.innerHTML="CONDICION FISICA ";
					}else if(opcionSeleccionada=="6655"){
					    capa.innerHTML="DESARROLLO ECONOMICO NACIONAL Y REGIONAL ";
					}else if(opcionSeleccionada=="6656"){
					    capa.innerHTML="FORMA Y PROCESO ";
					/*20*/
					
					}else if(opcionSeleccionada=="6657"){
					    capa.innerHTML="HISTORIA MARITIMA ";
					}else if(opcionSeleccionada=="6658"){
					    capa.innerHTML="LENGUAJE Y RELACIONES HUMANAS ";
					}else if(opcionSeleccionada=="6659"){
					    capa.innerHTML="PERSPECTIVA DEL DESARROLLO DE VALPARAISO ";
					}else if(opcionSeleccionada=="6660"){
					    capa.innerHTML="FILOSOFIA Y PSICOLOGIA: PROBLEMAS DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="6661"){
					    capa.innerHTML="FILOSOFIA Y PSICOLOGIA: ARGUMENTACION ";
					}else if(opcionSeleccionada=="6662"){
					    capa.innerHTML="LENGUA CASTELLANA Y COMUNICACION-LITERATURA E IDENTIDAD ";
					}else if(opcionSeleccionada=="6663"){
					    capa.innerHTML="DECORE EL HOGAR ";
					}else if(opcionSeleccionada=="6664"){
					    capa.innerHTML="SIMBOLOS DE IDENTIDAD PATRIOS ";
					}else if(opcionSeleccionada=="6665"){
					    capa.innerHTML="COMUNICACION ORGANIZACIONAL Y GESTION DE COMPRAVENTA ";
					}else if(opcionSeleccionada=="6666"){
					    capa.innerHTML="INVESTIGACION DE MERCADO Y VERIFICACION DE EXISTENCIAS ";
					}else if(opcionSeleccionada=="6667"){
					    capa.innerHTML="LABORATORIO HABITOS DE ESTUDIO ";
					}else if(opcionSeleccionada=="6668"){
					    capa.innerHTML="PRACTICAS DE LABORATORIO ";
					}else if(opcionSeleccionada=="6669"){
					    capa.innerHTML="REDACCION Y APLICACION INFORMATICA, DATOS Y ARCHIVOS ";
					}else if(opcionSeleccionada=="6670"){
					    capa.innerHTML="SERVICIO DE ATENCION AL CLIENTE Y TECNICAS DE VENTAS ";
					}else if(opcionSeleccionada=="6671"){
					    capa.innerHTML="COMPRENSION DEL LENGUAJE INFORMATICO ";
					}else if(opcionSeleccionada=="6672"){
					    capa.innerHTML="TALLER DE INVESTIGACION CIENTIFICA ";
					}else if(opcionSeleccionada=="6673"){
					    capa.innerHTML="CONTROL DE CALIDAD EN SOLDADURA ";
					}else if(opcionSeleccionada=="6674"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN ARTES MUSICALES ";
					}else if(opcionSeleccionada=="6675"){
					    capa.innerHTML="MANTENIMIENTOS DE LOS SISTEMAS DE TRANSMISION Y FRENADO ";
					}else if(opcionSeleccionada=="6676"){
					    capa.innerHTML="APRENDER MATEMATICA ";
					}else if(opcionSeleccionada=="6677"){
					    capa.innerHTML="APRENDER MATEMATICAS CON MODELOS ALGEBRAICOS ";
					}else if(opcionSeleccionada=="6678"){
					    capa.innerHTML="CONOCIENDO EL JUEGO ";
					}else if(opcionSeleccionada=="6679"){
					    capa.innerHTML="CRECIENDO A TRAVES DEL JUEGO ";
					}else if(opcionSeleccionada=="6680"){
					    capa.innerHTML="DE LA ECONOMIA A LA ORGANIZACION POLITICA ";
					}else if(opcionSeleccionada=="6681"){
					    capa.innerHTML="DESCUBRIENDO LA NATURALEZA ";
					}else if(opcionSeleccionada=="6682"){
					    capa.innerHTML="EL JUEGO TEATRAL ";
					}else if(opcionSeleccionada=="6683"){
					    capa.innerHTML="ENGLISH AROUND US ";
					}else if(opcionSeleccionada=="6684"){
					    capa.innerHTML="ERASE UNA VEZ LA CIENCIA ";
					}else if(opcionSeleccionada=="6617"){
					    capa.innerHTML="AUDIOVISUAL: FILOSOFIA, DIAPORAMA, VIDEO ";
					}else if(opcionSeleccionada=="6618"){
					    capa.innerHTML="MODULO CULTURAL LITERARIO INGLES ";
					}else if(opcionSeleccionada=="6619"){
					    capa.innerHTML="MAQUINARIA, RIEGO, FERTILIZACION ";
					}else if(opcionSeleccionada=="6620"){
					    capa.innerHTML="TALLER DE INFORMATICA EDUCATIVA ";
					}else if(opcionSeleccionada=="6621"){
					    capa.innerHTML="TALLER ROTATORIO ";
					}else if(opcionSeleccionada=="6622"){
					    capa.innerHTML="DISEÑO DE ESTRATEGIAS PARA RESOLVER PROBLEMAS ";
					}else if(opcionSeleccionada=="6623"){
					    capa.innerHTML="ESCRITORES Y POETAS MIRANDO AL MUNDO ";
					}else if(opcionSeleccionada=="6624"){
					    capa.innerHTML="HISTORIA CONSTITUCIONAL Y EVOLUCION LIMITROFE DE CHILE ";
					}else if(opcionSeleccionada=="6625"){
					    capa.innerHTML="INGLISH FOR SPECIFIC PURPOSES ";
					}else if(opcionSeleccionada=="6626"){
					    capa.innerHTML="LA CIENCIA Y LA LITERATURA ";
					}else if(opcionSeleccionada=="6627"){
					    capa.innerHTML="OPINION PÚBLICA Y MEDIOS DE COMUNICACION ";
					}else if(opcionSeleccionada=="6628"){
					    capa.innerHTML="PROBLEMAS ETICOS DEL HOMBRE CONTEMPORANEO ";
					}else if(opcionSeleccionada=="6629"){
					    capa.innerHTML="RECREACION Y VIDA AL AIRE LIBRE ";
					}else if(opcionSeleccionada=="6630"){
					    capa.innerHTML="CIMENTANDO EL SER ";
					}else if(opcionSeleccionada=="6631"){
					    capa.innerHTML="FUNDAMENTOS ";
					}else if(opcionSeleccionada=="6632"){
					    capa.innerHTML="FUNDAMENTOS Y TECNOLOGIA ";
					}else if(opcionSeleccionada=="6633"){
					    capa.innerHTML="EDUCACION TECNOLOGICA E INFORMATICA ";
					}else if(opcionSeleccionada=="6634"){
					    capa.innerHTML="FUNDAMENTOS DE LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="6635"){
					    capa.innerHTML="LA LENGUA CASTELLANA EN AMERICA ";
					}else if(opcionSeleccionada=="6636"){
					    capa.innerHTML="MODAS ";
					}else if(opcionSeleccionada=="6637"){
					    capa.innerHTML="LENGUAJE COMO HERRAMIENTA PRODUCTIVA ";
					}else if(opcionSeleccionada=="6638"){
					    capa.innerHTML="INGLES SOCIAL COMUNICATIVO CIENTIFICO ";
					}else if(opcionSeleccionada=="6639"){
					    capa.innerHTML="INGLES SOCIAL COMUNICATIVO HUMANISTICO ";
					}else if(opcionSeleccionada=="6640"){
					    capa.innerHTML="PERFORACION Y TRONADURA EN METODOS DE EXPLOTACION ";
					}else if(opcionSeleccionada=="6641"){
					    capa.innerHTML="RECONOCIMIENTO DE ROCAS ";
					}else if(opcionSeleccionada=="6642"){
					    capa.innerHTML="TOPOGRAFIA EN MINERIA DE SUPERFICIE ";
					}else if(opcionSeleccionada=="6643"){
					    capa.innerHTML="LENGUAJE Y ARGUMENTACION :EXPERIENCIAS Y REFLEXIONES ";
					}else if(opcionSeleccionada=="6644"){
					    capa.innerHTML="ADMINISTRACION DE PEQUEÑA EMPRESA MINERA ";
					}else if(opcionSeleccionada=="6645"){
					    capa.innerHTML="GESTION SEGURA Y DE CALIDAD EN PLANTAS DE PROCESAMIENTO ";
					}else if(opcionSeleccionada=="6646"){
					    capa.innerHTML="CULTURAL LITERARIO DE INGLES ";
					}else if(opcionSeleccionada=="6647"){
					    capa.innerHTML="PELUQUERIA Y COSMETOLOGIA ";
					}else if(opcionSeleccionada=="6648"){
					    capa.innerHTML="INTRODUCCION A LA PSICOLOGIA MODERNA ";
					}else if(opcionSeleccionada=="6649"){
					    capa.innerHTML="PARTICIPACION CIUDADANA: COMPROMISO DE CAMBIO ";
					}else if(opcionSeleccionada=="6650"){
					    capa.innerHTML="PSICOLOGIA DEL DESARROLLO ";
					}else if(opcionSeleccionada=="6583"){
					    capa.innerHTML="VIDA SALUDABLE ";
					}else if(opcionSeleccionada=="6584"){
					    capa.innerHTML="MATEMATICA AVANZADA ";
					}else if(opcionSeleccionada=="6585"){
					    capa.innerHTML="CIENCIAS SOCIALES: LA CIUDAD CONTEMPORANEA ";
					}else if(opcionSeleccionada=="6586"){
					    capa.innerHTML="LENGUAJE ALGEBRAICO ";
					}else if(opcionSeleccionada=="6587"){
					    capa.innerHTML="LITERATURA UNIVERSAL ";
					}else if(opcionSeleccionada=="6588"){
					    capa.innerHTML="TALLER DE GEOLOGIA ";
					}else if(opcionSeleccionada=="6589"){
					    capa.innerHTML="REPRESENTACON GRAFICA Y MECANIZADO EN ESTRUCTURAS METALICAS ";
					}else if(opcionSeleccionada=="6590"){
					    capa.innerHTML="ACTIVIDADES CON INSTRUMENTOS MUSICALES OCCIDENTALES ";
					}else if(opcionSeleccionada=="6591"){
					    capa.innerHTML="ACTIVIDADES MUSICALES CON INSTRUMENTOS PROPIOS DE LA CULTURA MAPUCHE ";
					}else if(opcionSeleccionada=="6592"){
					    capa.innerHTML="ACTIVIDADES RECREATIVAS CON PARVULOS ";
					}else if(opcionSeleccionada=="6593"){
					    capa.innerHTML="COCINA MAPUCHE  Y CHILENA ";
					}else if(opcionSeleccionada=="6594"){
					    capa.innerHTML="GESTION DE COMPRAVENTA ";
					}else if(opcionSeleccionada=="6595"){
					    capa.innerHTML="INTERCULTURALIDAD Y DESARROLLO ";
					}else if(opcionSeleccionada=="6596"){
					    capa.innerHTML="CONDICION FISICA 2 ";
					}else if(opcionSeleccionada=="6597"){
					    capa.innerHTML="DOCUMENTACION JUDICIAL ";
					}else if(opcionSeleccionada=="6598"){
					    capa.innerHTML="CULTIVOS EN AMBIENTE CONTROLADO ";
					}else if(opcionSeleccionada=="6599"){
					    capa.innerHTML="MANEJO DE RECURSOS NATURALES ";
					}else if(opcionSeleccionada=="6600"){
					    capa.innerHTML="MAQUINARIA Y RECURSOS FORRAJEROS ";
					}else if(opcionSeleccionada=="6601"){
					    capa.innerHTML="PROCESOS AGROINDUSTRIALES ";
					}else if(opcionSeleccionada=="6602"){
					    capa.innerHTML="PRODUCCION GANADERA ";
					}else if(opcionSeleccionada=="6603"){
					    capa.innerHTML="CONTABILIDAD SUPERIOR Y AUDITORIA ";
					}else if(opcionSeleccionada=="6604"){
					    capa.innerHTML="ATENCION DE ENFERMERIA BASICA ";
					}else if(opcionSeleccionada=="6605"){
					    capa.innerHTML="PREPARACION DE EQUIPO, INSTRUMENTAL Y STOCK ";
					}else if(opcionSeleccionada=="6606"){
					    capa.innerHTML="PREVENCION DE ENFERMEDADES INFECTOCONTAGIOSAS ";
					}else if(opcionSeleccionada=="6607"){
					    capa.innerHTML="TECNICA DE ELABORACION Y PRESENTACION DE PLATOS DE LA COCINA MAPUCHE ";
					}else if(opcionSeleccionada=="6608"){
					    capa.innerHTML="TÈCNICA DE LA PREPARACION DE SANDWICH ";
					}else if(opcionSeleccionada=="6609"){
					    capa.innerHTML="TECNICAS DE PASTELERIA Y REPOSTERIA ";
					}else if(opcionSeleccionada=="6610"){
					    capa.innerHTML="TECNICAS DE PREPARACION PARA MENÚ BUFFET ";
					}else if(opcionSeleccionada=="6611"){
					    capa.innerHTML="TRABAJO EDUCATIVO CON EL PARVULO EN RIESGO SOCIAL ";
					}else if(opcionSeleccionada=="6612"){
					    capa.innerHTML="ACTIVIDADES MUSICALES CON INSTRUMENTOS OCCIDENTALES ";
					}else if(opcionSeleccionada=="6613"){
					    capa.innerHTML="ELABORACION INDUSTRIAL DE ALIMENTOS ";
					}else if(opcionSeleccionada=="6614"){
					    capa.innerHTML="RECREACION, URBANIDAD Y CULTURA AMBIENTAL ";
					}else if(opcionSeleccionada=="6615"){
					    capa.innerHTML="SOLUCION DE PROBLEMAS ";
					}else if(opcionSeleccionada=="6616"){
					    capa.innerHTML="RESOLUCION DE PROBLEMAS ";
					}else if(opcionSeleccionada=="6549"){
					    capa.innerHTML="MAQUINAS DE TRANSPORTE Y ELEVACION ";
					}else if(opcionSeleccionada=="6550"){
					    capa.innerHTML="MEDICION Y ANALISIS DE CIRCUITOS HIDRAULICOS Y  NEUMATICOS ";
					}else if(opcionSeleccionada=="6551"){
					    capa.innerHTML="SISTEMA DE ELECTRONICA DIGITAL ";
					}else if(opcionSeleccionada=="6552"){
					    capa.innerHTML="ALGEBRA Y PROGRESIONES ";
					}else if(opcionSeleccionada=="6553"){
					    capa.innerHTML="BIOLOGIA MOLECULAR Y ECOLOGIA ";
					}else if(opcionSeleccionada=="6554"){
					    capa.innerHTML="DISEÑO II O INTRODUCCION A LA QUIMICA GENERAL II ";
					}else if(opcionSeleccionada=="6555"){
					    capa.innerHTML="DISEÑO O INTRODUCCION A LA QUIMICA GENERAL I ";
					}else if(opcionSeleccionada=="6556"){
					    capa.innerHTML="ECONOMIA I ";
					}else if(opcionSeleccionada=="6557"){
					    capa.innerHTML="ECONOMIA II ";
					}else if(opcionSeleccionada=="6558"){
					    capa.innerHTML="ESTADISTICA COMPUTACIONAL I ";
					}else if(opcionSeleccionada=="6559"){
					    capa.innerHTML="ESTADISTICA COMPUTACIONAL II ";
					}else if(opcionSeleccionada=="6560"){
					    capa.innerHTML="FILOSOFIA:  LOGICA I ";
					}else if(opcionSeleccionada=="6561"){
					    capa.innerHTML="FILOSOFIA:  LOGICA II ";
					}else if(opcionSeleccionada=="6562"){
					    capa.innerHTML="FUNCIONES Y DERIVADAS ";
					}else if(opcionSeleccionada=="6563"){
					    capa.innerHTML="INTRODUCCION A LA MECANICA ";
					}else if(opcionSeleccionada=="6564"){
					    capa.innerHTML="INTRODUCCION A LAS CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="6565"){
					    capa.innerHTML="LIMITES Y DERIVADAS ";
					}else if(opcionSeleccionada=="6566"){
					    capa.innerHTML="LITERATURA Y COMUNICACION I ";
					}else if(opcionSeleccionada=="6567"){
					    capa.innerHTML="LITERATURA Y COMUNICACION II ";
					}else if(opcionSeleccionada=="6568"){
					    capa.innerHTML="LUGARES GEOMETRICOS Y TRIGONOMETRIA ";
					}else if(opcionSeleccionada=="6569"){
					    capa.innerHTML="QUIMICA GENERAL I ";
					}else if(opcionSeleccionada=="6570"){
					    capa.innerHTML="QUIMICA GENERAL II ";
					}else if(opcionSeleccionada=="6571"){
					    capa.innerHTML="ATENCION INTEGRAL DE ENFERMERIA AL BINOMIO MADRE HIJO SANO Y ENFERMO ";
					}else if(opcionSeleccionada=="6572"){
					    capa.innerHTML="APLICACION DE LOS ELEMENTOS BASICOS DE FARMACOLOGIA ";
					}else if(opcionSeleccionada=="6573"){
					    capa.innerHTML="EJECUCION DE PROCEDIMIENTOS COMERCIALES Y ADMINISTRATIVOS ";
					}else if(opcionSeleccionada=="6574"){
					    capa.innerHTML="OPERACION DE LOCALES FARMACEUTICOS ";
					}else if(opcionSeleccionada=="6575"){
					    capa.innerHTML="FUNDAMENTOS DE ESTIBAS Y OPERACION DE LA CARGA ";
					}else if(opcionSeleccionada=="6576"){
					    capa.innerHTML="INSTALACIONES ELECTRICAS Y REDES DE CABLEADO ";
					}else if(opcionSeleccionada=="6577"){
					    capa.innerHTML="MAQUINAS, EQUIPOS Y CONSTRUCCIONES ELECTRICAS ";
					}else if(opcionSeleccionada=="6578"){
					    capa.innerHTML="CINE Y MEDIOS DE COMUNICACION ";
					}else if(opcionSeleccionada=="6579"){
					    capa.innerHTML="COMPUTACION Y RECURSOS INFORMATICOS ";
					}else if(opcionSeleccionada=="6580"){
					    capa.innerHTML="EXPLORANDO NUESTRO MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="6581"){
					    capa.innerHTML="TALLER DE DESARROLLO DE HABITOS Y APTITUDES PARA EL APRENDIZAJE";
					}else if(opcionSeleccionada=="6582"){
					    capa.innerHTML="TECNICAS Y TERMINOLOGIA ";
					}else if(opcionSeleccionada=="6514"){
					    capa.innerHTML="MECANICA INDUSTRIAL ";
					}else if(opcionSeleccionada=="6515"){
					    capa.innerHTML="SERVICIO DE GASTRONOMIA ";
					}else if(opcionSeleccionada=="6516"){
					    capa.innerHTML="SERVICIOS DE ALIMENTACION COLECTIVA ";
					}else if(opcionSeleccionada=="6517"){
					    capa.innerHTML="VESTUARIO Y CONFECCION INDUSTRIAL ";
					}else if(opcionSeleccionada=="6519"){
					    capa.innerHTML="ACTIVIDADES MUSICALES OCCIDENTALES ";
					}else if(opcionSeleccionada=="6520"){
					    capa.innerHTML="MEDICINA TRADICIONAL MAPUCHE ";
					}else if(opcionSeleccionada=="6521"){
					    capa.innerHTML="PROYECTO DE INTEGRACION ";
					}else if(opcionSeleccionada=="6522"){
					    capa.innerHTML="SALUD MENTAL ";
					}else if(opcionSeleccionada=="6523"){
					    capa.innerHTML="ELABORACION Y PRESENTACION DE PLATOS DE COCINA INTERNACIONAL ";
					}else if(opcionSeleccionada=="6524"){
					    capa.innerHTML="FUNCIONES Y PROCESOS INFINITOS OPTATIVO ";
					}else if(opcionSeleccionada=="6525"){
					    capa.innerHTML="QUIMICA OPTATIVO ";
					}else if(opcionSeleccionada=="6526"){
					    capa.innerHTML="LENGUAJE Y  COMUNICACION  FORMACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="6527"){
					    capa.innerHTML="LA ORGANIZACION Y EL TRABAJO ";
					}else if(opcionSeleccionada=="6528"){
					    capa.innerHTML="ANTROPOLOGIA SOCIAL ";
					}else if(opcionSeleccionada=="6529"){
					    capa.innerHTML="TALLER DE FUTBOL ";
					}else if(opcionSeleccionada=="6530"){
					    capa.innerHTML="DIBUJO Y DISEÑO INDUSTRIAL ";
					}else if(opcionSeleccionada=="6531"){
					    capa.innerHTML="ESTRUCTURA DE CONSTRUCCION ";
					}else if(opcionSeleccionada=="6532"){
					    capa.innerHTML="MANTENIMIENTO Y OPERACION DE SISTEMA DE SISTEMA DE CONTROL ELECTRONICO DE POST ";
					}else if(opcionSeleccionada=="6533"){
					    capa.innerHTML="MANUALIDADES RECREATIVAS ";
					}else if(opcionSeleccionada=="6534"){
					    capa.innerHTML="ATENCION SOCIAL ";
					}else if(opcionSeleccionada=="6535"){
					    capa.innerHTML="TALLER APLICACIONES COMPUTACIONAL CNC.PLC. ";
					}else if(opcionSeleccionada=="6536"){
					    capa.innerHTML="TALLER EXPLORACION PROFESIONAL ";
					}else if(opcionSeleccionada=="6537"){
					    capa.innerHTML="TALLER TECNOLOGIA Y MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="6538"){
					    capa.innerHTML="BIBLIA LEYES Y COSTUMBRES JUDAICAS ";
					}else if(opcionSeleccionada=="6539"){
					    capa.innerHTML="LEYES Y COSTUMBRES ";
					}else if(opcionSeleccionada=="6540"){
					    capa.innerHTML="TALLER DE EXPRESION ORAL Y ESCRITA ";
					}else if(opcionSeleccionada=="6541"){
					    capa.innerHTML="TALLER DE APLICACIONES MATEMATICAS PARA EL DESARROLLO DEL PENSAMIENTO LOGICO ";
					}else if(opcionSeleccionada=="6542"){
					    capa.innerHTML="TALLER PRODUCTIVO ORIENTADO A LA VIDA LABORAL ";
					}else if(opcionSeleccionada=="6543"){
					    capa.innerHTML="LENGUAJE I ";
					}else if(opcionSeleccionada=="6544"){
					    capa.innerHTML="LENGUAJE II ";
					/*21*/
					
					}else if(opcionSeleccionada=="6545"){
					    capa.innerHTML="ATENCION DE ENFERMERIA AL NIÑO Y AL ADOLESCENTE SANO Y ENFERMO";
					}else if(opcionSeleccionada=="6546"){
					    capa.innerHTML="PRIMEROS AUXILIOS Y PREVENCION DE RIESGOS EN EL AMBITO LABORAL";
					}else if(opcionSeleccionada=="6547"){
					    capa.innerHTML="CONTROL DE CALIDAD DE LOS PROCESOS DE MECANIZADO ";
					}else if(opcionSeleccionada=="6548"){
					    capa.innerHTML="ENTRENAMIENTO DE LA CONDICION FISICA, ASOCIADA AL TRABAJO, A LA SALUD Y CALIDAD DE VIDA ";
					}else if(opcionSeleccionada=="6480"){
					    capa.innerHTML="DISEÑO Y OPERACION ";
					}else if(opcionSeleccionada=="6481"){
					    capa.innerHTML="INSTALACIONES ELECTRICAS EN BAJA TENSION ";
					}else if(opcionSeleccionada=="6482"){
					    capa.innerHTML="MANTENCION OPERACIONAL ";
					}else if(opcionSeleccionada=="6483"){
					    capa.innerHTML="MEDICION Y ANALISIS DE COMPONENTES ELECTRICOS ";
					}else if(opcionSeleccionada=="6484"){
					    capa.innerHTML="NEUMATICA HIDRAULICA ";
					}else if(opcionSeleccionada=="6485"){
					    capa.innerHTML="PLC ";
					}else if(opcionSeleccionada=="6486"){
					    capa.innerHTML="RELE PROGRAMABLE ";
					}else if(opcionSeleccionada=="6487"){
					    capa.innerHTML="ETICA FUNDAMENTAL ";
						
					}else if(opcionSeleccionada=="6488"){
					    capa.innerHTML="ORIENTACION PERSONAL Y PROFESIONAL I ";
					}else if(opcionSeleccionada=="6489"){
					    capa.innerHTML="ORIENTACION PERSONAL Y PROFESIONAL II ";
					}else if(opcionSeleccionada=="6490"){
					    capa.innerHTML="TALLER DE INTRODUCCION A LA INFORMATICA EMPRESARIAL ";
					}else if(opcionSeleccionada=="6491"){
					    capa.innerHTML="TALLER DE FISICA ";
					}else if(opcionSeleccionada=="6492"){
					    capa.innerHTML="TALLER DE QUIMICA ";
					}else if(opcionSeleccionada=="6493"){
					    capa.innerHTML="DIALECTICA ";
					}else if(opcionSeleccionada=="6494"){
					    capa.innerHTML="LEGISLACION SOCIAL Y COMERCIAL ";
					}else if(opcionSeleccionada=="6495"){
					    capa.innerHTML="TALLER EXPLORATORIO DE ESPECIALIDAD I ";
					}else if(opcionSeleccionada=="6496"){
					    capa.innerHTML="TALLER EXPLORATORIO DE ESPECIALIDAD II ";
					}else if(opcionSeleccionada=="6497"){
					    capa.innerHTML="GESTION EN COMPRAVENTA ";
					}else if(opcionSeleccionada=="6498"){
					    capa.innerHTML="TECNICAS DE VENTAS ";
						
					
					
					}else if(opcionSeleccionada=="6499"){
					    capa.innerHTML="GESTION RECURSOS HUMANOS ";
					}else if(opcionSeleccionada=="6500"){
					    capa.innerHTML="NOCIONES DE QUIMICA Y BIOQUIMICA ";
					}else if(opcionSeleccionada=="6501"){
					    capa.innerHTML="ANALISIS POLITICO DE CHILE ";
					}else if(opcionSeleccionada=="6502"){
					    capa.innerHTML="LABORATORIO DE DIGITACION Y COMPUTACION ";
					}else if(opcionSeleccionada=="6503"){
					    capa.innerHTML="TECNICAS DE HIGIENE PERSONAL, AMBIENTAL Y DE LOS ALIMENTOS ";
					}else if(opcionSeleccionada=="6504"){
					    capa.innerHTML="INFORME FINANCIERO ";
					}else if(opcionSeleccionada=="6505"){
					    capa.innerHTML="TALLER DE INTRODUCCION A LA INFORMATICA EMPRESARIAL I ";
					}else if(opcionSeleccionada=="6506"){
					    capa.innerHTML="TALLER ASISTENTE DE OFICINA ";
					}else if(opcionSeleccionada=="6507"){
					    capa.innerHTML="TALLER PELUQUERIA ";
					}else if(opcionSeleccionada=="6508"){
					    capa.innerHTML="ACTIVIDADES PARA EL DESARROLLO PSICOLOGICO DEL PARVULO ";
					}else if(opcionSeleccionada=="6509"){
					    capa.innerHTML="GESTION DE EMPRESA, CONTROL DE CALIDAD ";
					}else if(opcionSeleccionada=="6510"){
					    capa.innerHTML="LIDERAZGO Y CAPACIDAD EMPRENDEDORA ";
					}else if(opcionSeleccionada=="6511"){
					    capa.innerHTML="TORNERIA EN MADERA ";
					}else if(opcionSeleccionada=="6512"){
					    capa.innerHTML="CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="6513"){
					    capa.innerHTML="ELECTRONICA DIGITAL Y MICROPROCESADORES ";
					}else if(opcionSeleccionada=="6446"){
					    capa.innerHTML="TECNOLOGIA DE COMBUSTION ";
					}else if(opcionSeleccionada=="6447"){
					    capa.innerHTML="PROYECTO, CULTURA, ETICA RELIGIOSA ";
					}else if(opcionSeleccionada=="6448"){
					    capa.innerHTML="AFINAMIENTO DE LOS SISTEMAS DEL AUTOMOVIL ";
					}else if(opcionSeleccionada=="6449"){
					    capa.innerHTML="MANEJO ADMINISTRATIVO CONTABLE EN COMPUTACION ";
					}else if(opcionSeleccionada=="6450"){
					    capa.innerHTML="MODAS Y PELUQUERIA ";
					}else if(opcionSeleccionada=="6451"){
					    capa.innerHTML="LA PERSONALIDAD ";
					}else if(opcionSeleccionada=="6452"){
					    capa.innerHTML="LENGUA CASTELLANA Y SOCIEDAD ";
					}else if(opcionSeleccionada=="6453"){
					    capa.innerHTML="DACTILOGRAFIA Y REDACCION COMERCIAL ";
					}else if(opcionSeleccionada=="6454"){
					    capa.innerHTML="PRODUCCION DE LECHE ";
					
					}else if(opcionSeleccionada=="6455"){
					    capa.innerHTML="SILVOPAISAJISMO ";
					}else if(opcionSeleccionada=="6456"){
					    capa.innerHTML="LOS ALIMENTOS Y SU APORTE NUTRICIONAL ";
					}else if(opcionSeleccionada=="6457"){
					    capa.innerHTML="ARGUMENTACION Y PROBLEMAS DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="6458"){
					    capa.innerHTML="TALLER DE MURGA ";
					}else if(opcionSeleccionada=="6459"){
					    capa.innerHTML="LITERATURA Y GRAMATICA ";
					}else if(opcionSeleccionada=="6460"){
					    capa.innerHTML="ALIMENTACION DIRIGIDAS A LOS ENFERMOS ";
					}else if(opcionSeleccionada=="6461"){
					    capa.innerHTML="ATENCION DE ENFERMERIA INTEGRAL A PACIENTES MEDICOS QUIRURGICOS";
					}else if(opcionSeleccionada=="6462"){
					    capa.innerHTML="ELABORACION DE PRESENTACION DE PLATOS DE LA COCINA INTERNACIONAL";
					}else if(opcionSeleccionada=="6463"){
					    capa.innerHTML="PREPARACION Y MANTENIMIENTO DEL EQUIPAMIENTO INSTRUMENTAL STOCK DE MATERIALES E INSUMOS REQUERIDOS PARA LA ATENCION ";
					}else if(opcionSeleccionada=="6464"){
					    capa.innerHTML="PREPARADOS Y CONFECCION DE PRENDAS DEPORTIVAS Y DE TRABAJO ";
					}else if(opcionSeleccionada=="6465"){
					    capa.innerHTML="PSICOLOGIA CIENTIFICA ";
					}else if(opcionSeleccionada=="6466"){
					    capa.innerHTML="PSICOLOGIA HUMANISTA ";
					}else if(opcionSeleccionada=="6467"){
					    capa.innerHTML="ARMADO Y REPRESENTACION GRAFICA ";
					}else if(opcionSeleccionada=="6468"){
					    capa.innerHTML="GESTION DE LA PEQUEÑA EMPRESA Y DESARROLLO DE PROYECTOS ";
					}else if(opcionSeleccionada=="6469"){
					    capa.innerHTML="SOLDADURA Y CALIDAD EN CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="6470"){
					    capa.innerHTML="TRAZADO Y MECANIZADO EN CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="6471"){
					    capa.innerHTML="LIMPIEZA Y MANTENCION ";
					}else if(opcionSeleccionada=="6472"){
					    capa.innerHTML="ORIGENES E IDENTIDAD ";
					}else if(opcionSeleccionada=="6473"){
					    capa.innerHTML="PEQUEÑA EMPRESA Y TALLER ";
					}else if(opcionSeleccionada=="6474"){
					    capa.innerHTML="TECNICAS DEL CUIDADO Y CONSERVACION DE ROPA ";
					}else if(opcionSeleccionada=="6475"){
					    capa.innerHTML="DESARROLLO DE PROYECTOS Y REPRESENTACION GRAFICA DE CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="6476"){
					    capa.innerHTML="GESTION DE LA CALIDAD Y ADMINISTRACION DE UNA PEQUEÑA EMPRESA ";
					}else if(opcionSeleccionada=="6477"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION EN CHEDUNGUN ";
					}else if(opcionSeleccionada=="6478"){
					    capa.innerHTML="HISTORIA DE LA QUIMICA E INTRODUCCION A LA TERMODINAMICA ";
					}else if(opcionSeleccionada=="6479"){
					    capa.innerHTML="QUIMICA ORGANICA Y CATALISIS ";
					}else if(opcionSeleccionada=="6412"){
					    capa.innerHTML="PROCESO DE AUTOMATIZACION ";
					}else if(opcionSeleccionada=="6413"){
					    capa.innerHTML="CULTIVO DEL ESPIRITU ";
					}else if(opcionSeleccionada=="6414"){
					    capa.innerHTML="EDUCACION DE LA SEXUALIDAD Y EL AMOR ";
					}else if(opcionSeleccionada=="6415"){
					    capa.innerHTML="PANORAMA DEL PENSAMIENTO MODERNO ";
					}else if(opcionSeleccionada=="6416"){
					    capa.innerHTML="NOCIONES DE MECANICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="6417"){
					    capa.innerHTML="MANEJO DE PARRONALES I ";
					}else if(opcionSeleccionada=="6418"){
					    capa.innerHTML="MANEJO DE PARRONALES II ";
					}else if(opcionSeleccionada=="6419"){
					    capa.innerHTML="FISICA APLICADA II ";
					/*21*/
					}else if(opcionSeleccionada=="6420"){
					    capa.innerHTML="FISICA MATEMATICA I ";
					}else if(opcionSeleccionada=="6421"){
					    capa.innerHTML="FISICA MATEMATICA II ";
					}else if(opcionSeleccionada=="6422"){
					    capa.innerHTML="QUIMICA APLICADA II ";
					}else if(opcionSeleccionada=="6423"){
					    capa.innerHTML="EDUCACION PARA LA EXPRESION INTEGRAL ";
					}else if(opcionSeleccionada=="6424"){
					    capa.innerHTML="ELECTRICIDAD APLICADA II ";
					}else if(opcionSeleccionada=="6425"){
					    capa.innerHTML="TALLER DE ARTES VISUALES ";
					}else if(opcionSeleccionada=="6426"){
					    capa.innerHTML="TALLER DE HISTORIA Y CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="6427"){
					    capa.innerHTML="TALLER DE LENGUA CASTELLANA Y COMUNICACION ";
					}else if(opcionSeleccionada=="6428"){
					    capa.innerHTML="TALLERES DE DESARROLLO DE PROYECTOS ";
					}else if(opcionSeleccionada=="6429"){
					    capa.innerHTML="ADMINISTRACION DE EMPRESAS AGROPECUARIAS ";
					}else if(opcionSeleccionada=="6430"){
					    capa.innerHTML="DERECHO LABORAL Y PREVISION SOCIAL ";
					}else if(opcionSeleccionada=="6431"){
					    capa.innerHTML="DERECHO USUAL Y LEGISLACION SOCIAL ";
					}else if(opcionSeleccionada=="6432"){
					    capa.innerHTML="MODULO CULTURAL-LITERARIO ";
					}else if(opcionSeleccionada=="6433"){
					    capa.innerHTML="ASERRIO ";
					}else if(opcionSeleccionada=="6434"){
					    capa.innerHTML="ASIGNATURAS Y/O MODULOS ";
					}else if(opcionSeleccionada=="6435"){
					    capa.innerHTML="AUTOMATIZACION Y MANTENIMIENTO DE LOS SISTEMAS DE DIRECCION, SUSPENSION, TRANSMISION Y FRENOS ";
					}else if(opcionSeleccionada=="6436"){
					    capa.innerHTML="GESTION DE MICROEMPRESAS ";
					}else if(opcionSeleccionada=="6437"){
					    capa.innerHTML="LEGISLACION LABORAL Y PREVISIONAL ";
					}else if(opcionSeleccionada=="6438"){
					    capa.innerHTML="MANEJO Y COSECHA DE BOSQUES ";
					}else if(opcionSeleccionada=="6439"){
					    capa.innerHTML="MANTENIMIENTO DE LOS SISTEMAS ELECTRICOS, ELECTRONICOS DEL MOTOR Y SUS SISTEMAS DE SEGURIDAD Y CONFORTABILIDAD DEL VEHICULO ";
					}else if(opcionSeleccionada=="6440"){
					    capa.innerHTML="MANTENIMIENTO DE MOTORES Y SUS SISTEMAS AUXILIARES ";
					}else if(opcionSeleccionada=="6441"){
					    capa.innerHTML="PRODUCCION Y ESTABLECIMIENTO DE PLANTAS ";
					}else if(opcionSeleccionada=="6442"){
					    capa.innerHTML="REPARACIONES Y MANTENCION DE LOS ELEMENTOS MOVIBLES E INAMOVIBLES DE CHASIS Y CARROCERIA DEL VEHICULO ";
					}else if(opcionSeleccionada=="6443"){
					    capa.innerHTML="SERVICIO DE ATENCION AL CLIENTE ";
					}else if(opcionSeleccionada=="6444"){
					    capa.innerHTML="SISTEMA DE FRENOS ";
					}else if(opcionSeleccionada=="6445"){
					    capa.innerHTML="TECNICAS DE MECANIZADOS ";
					}else if(opcionSeleccionada=="6377"){
					    capa.innerHTML="DESCUBRIENDO EL MUNDO LABORAL ";
					}else if(opcionSeleccionada=="6378"){
					    capa.innerHTML="DISEÑO Y OPERACION DE SISTEMAS ELECTRICOS ";
					}else if(opcionSeleccionada=="6379"){
					    capa.innerHTML="DISEÑO Y OPERACION DE SISTEMAS ELECTRICOS AUTOMATIZADOS ";
					}else if(opcionSeleccionada=="6380"){
					    capa.innerHTML="TOMA DE DECISIONES FRENTE AL MUNDO LABORAL ";
					}else if(opcionSeleccionada=="6382"){
					    capa.innerHTML="ARTICULACION ";
					}else if(opcionSeleccionada=="6383"){
					    capa.innerHTML="CULTURA ";
					}else if(opcionSeleccionada=="6384"){
					    capa.innerHTML="TALLER FORMACION PARA EL TRABAJO ";
					}else if(opcionSeleccionada=="6385"){
					    capa.innerHTML="TALLER PRACTICO COMPUTACIONAL ";
					}else if(opcionSeleccionada=="6386"){
					    capa.innerHTML="EVOLUCION Y LITERATURA ";
					}else if(opcionSeleccionada=="6387"){
					    capa.innerHTML="HISTORIA Y CIENCIAS SOCIALES: LA CIUDAD CONTEMPORANEA ";
					}else if(opcionSeleccionada=="6388"){
					    capa.innerHTML="IDIOMA EXTRANJERO: INGLES (LITERATURA CULTURAL) ";
					}else if(opcionSeleccionada=="6389"){
					    capa.innerHTML="NATURALEZA, SOCIEDAD Y CULTURA ";
					}else if(opcionSeleccionada=="6390"){
					    capa.innerHTML="GEOMETRIA EUCLIDIANA ";
					}else if(opcionSeleccionada=="6391"){
					    capa.innerHTML="MATEMATICA: ALGEBRA ";
					}else if(opcionSeleccionada=="6392"){
					    capa.innerHTML="MATEMATICA: GEOMETRIA ";
					}else if(opcionSeleccionada=="6393"){
					    capa.innerHTML="ALEMAN BASICO ";
					}else if(opcionSeleccionada=="6394"){
					    capa.innerHTML="ALEMAN NIVEL MEDIO ";
					}else if(opcionSeleccionada=="6395"){
					    capa.innerHTML="ALEMAN NIVEL AVANZADO ";
					}else if(opcionSeleccionada=="6396"){
					    capa.innerHTML="ELECTROFISICA ";
					
					}else if(opcionSeleccionada=="6397"){
					    capa.innerHTML="LABORATORIO DE MICROPROCESADORES ";
					}else if(opcionSeleccionada=="6398"){
					    capa.innerHTML="MANTENCION DE COMPUTADORES ";
					}else if(opcionSeleccionada=="6399"){
					    capa.innerHTML="MANUALIDADES Y ARTESANIA ";
					}else if(opcionSeleccionada=="6400"){
					    capa.innerHTML="PLANIFICACION DE LA PRODUCCION ";
					}else if(opcionSeleccionada=="6401"){
					    capa.innerHTML="PRACTICA DE TALLER Y LABORATORIO ";
					}else if(opcionSeleccionada=="6402"){
					    capa.innerHTML="PROYECTO DE APLICACION ";
					}else if(opcionSeleccionada=="6403"){
					    capa.innerHTML="TALLER ATENCION DE PARVULOS ";
					}else if(opcionSeleccionada=="6404"){
					    capa.innerHTML="TALLER DE MATERIAL DIDACTICO ";
					}else if(opcionSeleccionada=="6405"){
					    capa.innerHTML="TEATRO Y LITERATURA INFANTIL ";
					}else if(opcionSeleccionada=="6406"){
					    capa.innerHTML="TECNICA DE PANADERIA ";
					}else if(opcionSeleccionada=="6407"){
					    capa.innerHTML="TECNICAS DE ELABORACION DE PLATOS TIPICOS NACIONALES E INTERNACIONALES ";
					}else if(opcionSeleccionada=="6408"){
					    capa.innerHTML="TECNICAS DE PASTELERIA Y REPOSTERIA ";
					}else if(opcionSeleccionada=="6409"){
					    capa.innerHTML="TECNICAS DE PREPARACION DE ALIMENTOS DE MENU, CARTA Y BUFETE ";
					}else if(opcionSeleccionada=="6410"){
					    capa.innerHTML="TECNICAS DE PREPARACION DE PLATOS PRINCIPALES ";
					}else if(opcionSeleccionada=="6411"){
					    capa.innerHTML="TECNOLOGIA DEL AREA ";
					}else if(opcionSeleccionada=="6343"){
					    capa.innerHTML="TECNOLOGIA ELECTRONICA ";
					}else if(opcionSeleccionada=="6344"){
					    capa.innerHTML="CALCULO1: APLICACION DE LAS MATEMATICAS ";
					}else if(opcionSeleccionada=="6345"){
					    capa.innerHTML="CALCULO2: APLICACION DE LAS MATEMATICAS ";
					}else if(opcionSeleccionada=="6346"){
					    capa.innerHTML="FISICA: ELECTROMAGNETISMO ";
					}else if(opcionSeleccionada=="6347"){
					    capa.innerHTML="FISICA: MECANICA PRINCIPIOS DE CONSERVACION ";
					}else if(opcionSeleccionada=="6348"){
					    capa.innerHTML="GEOMETRIA: APLICACION DE LAS MATEMATICAS ";
					}else if(opcionSeleccionada=="6349"){
					    capa.innerHTML="MATEMATICA: ALGEBRA Y MODELOS ANALITICOS ";
					}else if(opcionSeleccionada=="6350"){
					    capa.innerHTML="ADMINISTRACION COMERCIO I ";
					}else if(opcionSeleccionada=="6351"){
					    capa.innerHTML="ADMINISTRACION COMERCIO II ";
					}else if(opcionSeleccionada=="6352"){
					    capa.innerHTML="PROYECTOS E INSTALACIONES ELECTRICAS ";
					}else if(opcionSeleccionada=="6353"){
					    capa.innerHTML="MEDIO AMBIENTE, ANALISIS DE AGUA Y TRATAMIENTO DE RESIDUOS ";
					}else if(opcionSeleccionada=="6354"){
					    capa.innerHTML="ANALISIS VOLUMETRICO Y GRAVIMETRICO DE LA MATERIA PRIMA ";
					}else if(opcionSeleccionada=="6355"){
					    capa.innerHTML="FABRICACION DE PRODUCTOS ORGANICOS INDUSTRIALES ";
					}else if(opcionSeleccionada=="6356"){
					    capa.innerHTML="AFINAMIENTO SISTEMA DEL AUTOMOVIL ";
					}else if(opcionSeleccionada=="6357"){
					    capa.innerHTML="MANEJO ADMINISTRATIVO CONTABLE ";
					}else if(opcionSeleccionada=="6358"){
					    capa.innerHTML="MANEJO ADMINISTRATIVO CONTABILIDAD COMPUTACIONAL ";
					}else if(opcionSeleccionada=="6359"){
					    capa.innerHTML="MANTENCION, OPERACION Y DISEÑO CON DISPOSITIVOS Y CIRCUITOS ELECTRONICOS DIGITALES ";
					}else if(opcionSeleccionada=="6360"){
					    capa.innerHTML="MODIFICACION Y REPARACION DE ELEMENTOS INAMOVIBLES Y FIJOS NO ESTRUCTURALES ";
					}else if(opcionSeleccionada=="6361"){
					    capa.innerHTML="SALUD DE PARVULO ";
					}else if(opcionSeleccionada=="6362"){
					    capa.innerHTML="COMUNICANDONOS EN EL SIGLO XXI ";
					}else if(opcionSeleccionada=="6363"){
					    capa.innerHTML="LOS DERECHOS HUMANOS ";
					}else if(opcionSeleccionada=="6364"){
					    capa.innerHTML="MECANICA Y FISICA MODERNA ";
					}else if(opcionSeleccionada=="6365"){
					    capa.innerHTML="MEDIOS DE COMUNICACION ";
					}else if(opcionSeleccionada=="6366"){
					    capa.innerHTML="NOCIONES DE ADMINISTRACION ";
					}else if(opcionSeleccionada=="6367"){
					    capa.innerHTML="NOCIONES DE CALCULO ";
					}else if(opcionSeleccionada=="6368"){
					    capa.innerHTML="NOCIONES DE CALCULO II ";
					}else if(opcionSeleccionada=="6369"){
					    capa.innerHTML="NORMATIVA TRIBUTARIA Y LABORAL ";
					}else if(opcionSeleccionada=="6370"){
					    capa.innerHTML="REGULARIZACION CONTABLE, INFORMES FINANCIEROS, CONTABLES Y DE COSTOS ";
					}else if(opcionSeleccionada=="6371"){
					    capa.innerHTML="MECANICA AUTOMOTRIZ APLICADA I ";
					}else if(opcionSeleccionada=="6372"){
					    capa.innerHTML="MECANICA AUTOMOTRIZ APLICADA II ";
					}else if(opcionSeleccionada=="6373"){
					    capa.innerHTML="PELUQUERIA Y BELLEZA INTEGRAL APLICADA I ";
					}else if(opcionSeleccionada=="6374"){
					    capa.innerHTML="PELUQUERIA Y BELLEZA INTEGRAL APLICADA II ";
					}else if(opcionSeleccionada=="6375"){
					    capa.innerHTML="VENTAS Y TRAMITACION APLICADA I ";
					}else if(opcionSeleccionada=="6376"){
					    capa.innerHTML="VENTAS Y TRAMITACION APLICADA II ";
					}else if(opcionSeleccionada=="6309"){
					    capa.innerHTML="ARGUMENTACION Y ETICA ";
					}else if(opcionSeleccionada=="6310"){
					    capa.innerHTML="BIOLOGIA EVOLUTIVA ";
					}else if(opcionSeleccionada=="6311"){
					    capa.innerHTML="COMPLEMENTO DE LA QUIMICA ";
					}else if(opcionSeleccionada=="6312"){
					    capa.innerHTML="INGLES COMPLEMENTARIO ";
					}else if(opcionSeleccionada=="6313"){
					    capa.innerHTML="LENGUAJE Y HUMANISMO ";
					}else if(opcionSeleccionada=="6314"){
					    capa.innerHTML="TALLER DE MODA ";
					}else if(opcionSeleccionada=="6315"){
					    capa.innerHTML="MANTENCION Y OPERACION CONTENCION ELECTRICA POTENCIADA ";
					}else if(opcionSeleccionada=="6316"){
					    capa.innerHTML="MANTENCION Y OPERACION DE MAQUINA Y EQUIPO ELECTRICO ";
					}else if(opcionSeleccionada=="6317"){
					    capa.innerHTML="NATURALEZA ";
					}else if(opcionSeleccionada=="6318"){
					    capa.innerHTML="OPERACION Y PROGRAMA DE SISTEMA DE CONTROL P.L.C. ";
					}else if(opcionSeleccionada=="6319"){
					    capa.innerHTML="SOCIEDAD ";
					}else if(opcionSeleccionada=="6320"){
					    capa.innerHTML="COLORACION CAPILAR ";
					}else if(opcionSeleccionada=="6321"){
					    capa.innerHTML="INTRODUCCION AL COMERCIO Y LA ADMINISTRACION 1 ";
					}else if(opcionSeleccionada=="6322"){
					    capa.innerHTML="FUNDAMENTOS DEL DERECHO SOCIO-POLITICO ";
					}else if(opcionSeleccionada=="6323"){
					    capa.innerHTML="HISTORIA DE LAS RELIGIONES ";
					}else if(opcionSeleccionada=="6324"){
					    capa.innerHTML="INGLES FORMACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="6325"){
					    capa.innerHTML="MATEMATICA BIOESTADISTICA ";
					}else if(opcionSeleccionada=="6326"){
					    capa.innerHTML="METODOLOGIA DE LA INVESTIGACION SOCIAL ";
					}else if(opcionSeleccionada=="6327"){
					    capa.innerHTML="METODOLOGIA Y TEORIA DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="6328"){
					    capa.innerHTML="NOCIONES ELEMENTALES DE CALCULO ";
					}else if(opcionSeleccionada=="6329"){
					    capa.innerHTML="POLITICA CHILENA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="6330"){
					    capa.innerHTML="DESARROLLO FISICO ";
					}else if(opcionSeleccionada=="6331"){
					    capa.innerHTML="ADMINISTRACION Y GESTION PEQUEÑA EMPRESA ";
					}else if(opcionSeleccionada=="6332"){
					    capa.innerHTML="AREA DE CAPACITACION TECNOLOGICA INFORMATICA  ";
					}else if(opcionSeleccionada=="6333"){
					    capa.innerHTML="CONDUCCION Y REGLAMENTO DE TRANSITO ";
					}else if(opcionSeleccionada=="6334"){
					    capa.innerHTML="DIBUJO TECNICO ELECTRONICO ";
					}else if(opcionSeleccionada=="6335"){
					    capa.innerHTML="AREA DESARROLLO PERSONAL Y ORIENTACION SOCIAL Y LABORAL ";
					}else if(opcionSeleccionada=="6336"){
					    capa.innerHTML="FISICA ELECTRONICA ";
					}else if(opcionSeleccionada=="6337"){
					    capa.innerHTML="FISICA MECANICA ";
					}else if(opcionSeleccionada=="6338"){
					    capa.innerHTML="INDUCCIÒN TECNOLOGICA ";
					}else if(opcionSeleccionada=="6339"){
					    capa.innerHTML="INTERPRETACION DE PLANOS Y DIAGRAMAS ";
					}else if(opcionSeleccionada=="6340"){
					    capa.innerHTML="CIRCUITOS ELECTRICOS AUXILIAR DEL VEHICULO Y MANTENIMIENTO DE LOS SISTEMAS ELECTRICOS ";
					}else if(opcionSeleccionada=="6341"){
					    capa.innerHTML="TECNOLOGIA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="6342"){
					    capa.innerHTML="SISTEMAS NEUMATICOS E HIDRAULICOS MANTENIMIENTO DE VEHICULO ";
					}else if(opcionSeleccionada=="6275"){
					    capa.innerHTML="TECNOLOGIA Y LENGUAJE DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="6276"){
					    capa.innerHTML="PROYECTOS INFORMATICOS DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="6277"){
					    capa.innerHTML="MUSICA INSTRUMENTAL ";
					}else if(opcionSeleccionada=="6278"){
					    capa.innerHTML="CORO ";
					}else if(opcionSeleccionada=="6279"){
					    capa.innerHTML="BORDADO Y COSTURA ";
					}else if(opcionSeleccionada=="6280"){
					    capa.innerHTML="INTRODUCCION AL COMERCIO Y LA ADMINISTRACION 2 ";
					}else if(opcionSeleccionada=="6281"){
					    capa.innerHTML="GESTION DEL AGROECOSISTEMA Y PROYECTOS AGROPECUARIOS ";
					}else if(opcionSeleccionada=="6282"){
					    capa.innerHTML="SANIDAD REPRODUCCION Y SISTEMAS DE PRODUCCION ANIMAL ";
					}else if(opcionSeleccionada=="6283"){
					    capa.innerHTML="LABORATORIO COMPUTACION ";
					}else if(opcionSeleccionada=="6284"){
					    capa.innerHTML="TALLER LABORATORIO DE ELECTRICIDAD ";
					}else if(opcionSeleccionada=="6285"){
					    capa.innerHTML="TECNOLOGIA MECANICA ";
					}else if(opcionSeleccionada=="6286"){
					    capa.innerHTML="IDIOMA EXTRANJERO LATIN ";
					}else if(opcionSeleccionada=="6287"){
					    capa.innerHTML="TECNICA DE LA EXPRESION Y REDACCION COMERCIAL ";
					}else if(opcionSeleccionada=="6288"){
					    capa.innerHTML="DEPORTE Y ACTIVIDADES DE EXPRESION MOTRIZ ";
					}else if(opcionSeleccionada=="6289"){
					    capa.innerHTML="ADMINISTRACION GENERAL Y DE VENTAS ";
					}else if(opcionSeleccionada=="6290"){
					    capa.innerHTML="DISEÑO MULTIPLE FOCALIZADO, DISEÑO ARQUITECTONICO Y URBANO ";
					}else if(opcionSeleccionada=="6291"){
					    capa.innerHTML="NOCIONES DE CONTABILIDAD Y COMERCIO ";
					}else if(opcionSeleccionada=="6292"){
					    capa.innerHTML="NOCIONES DE ECONOMIA Y ADMINISTRACION ";
					}else if(opcionSeleccionada=="6293"){
					    capa.innerHTML="SISTEMAS DE INFORMACION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="6294"){
					    capa.innerHTML="CUBICACION Y PRESUPUESTO EN OBRAS DE ENFIERRADURA ";
					}else if(opcionSeleccionada=="6295"){
					    capa.innerHTML="DIBUJO TECNICO E INTERPRETACION DE PLANOS EDIFICACION ";
					}else if(opcionSeleccionada=="6296"){
					    capa.innerHTML="FORMACION DE PEQUEÑAS EMPRESAS ";
					}else if(opcionSeleccionada=="6297"){
					    capa.innerHTML="MUROS DE ALBAÑILERIA EN BLOQUES Y LADRILLOS RADIERES Y SOBRELOSAS ";
					}else if(opcionSeleccionada=="6298"){
					    capa.innerHTML="OBRAS DE CARPINTERIA EN EDIFICACION ";
					}else if(opcionSeleccionada=="6299"){
					    capa.innerHTML="REPLANTEO, TRAZADO Y EXCAVACIONES ";
					}else if(opcionSeleccionada=="6300"){
					    capa.innerHTML="TECNOLOGIA DEL HORMIGON APLICADO A EDIFICACION ";
					}else if(opcionSeleccionada=="6301"){
					    capa.innerHTML="PANADERIA ";
					}else if(opcionSeleccionada=="6302"){
					    capa.innerHTML="PLATOS TIPICOS ";
					}else if(opcionSeleccionada=="6303"){
					    capa.innerHTML="REPOSTERIA Y PASTELERIA ";
					}else if(opcionSeleccionada=="6304"){
					    capa.innerHTML="TALLER DE APLICACIONES COMPUTACIONALES ORIENTADAS AL CNC Y PLC";
					}else if(opcionSeleccionada=="6305"){
					    capa.innerHTML="TALLER DE EXPLORACION PROFESIONAL ";
					}else if(opcionSeleccionada=="6306"){
					    capa.innerHTML="TALLER DE TECNOLOGIA Y MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="6307"){
					    capa.innerHTML="MANEJO DE RECURSOS ";
					}else if(opcionSeleccionada=="6308"){
					    capa.innerHTML="PRODUCCION ";
					}else if(opcionSeleccionada=="6240"){
					    capa.innerHTML="ELECTRONICA BASICA Y ALGUNAS APLICACIONES TECNOLOGICAS I ";
					}else if(opcionSeleccionada=="6241"){
					    capa.innerHTML="ELECTRONICA BASICA Y ALGUNAS APLICACIONES TECNOLOGICAS II ";
					}else if(opcionSeleccionada=="6242"){
					    capa.innerHTML="ELEMENTOS DE CONTABILIDAD Y DOCUMENTACION MERCANTIL ";
					}else if(opcionSeleccionada=="6243"){
					    capa.innerHTML="TRAMITACION DE DOCUMENTACION ZOFRI ";
					}else if(opcionSeleccionada=="6244"){
					    capa.innerHTML="ALGEBRA Y MODELO ANALISTA ";
					}else if(opcionSeleccionada=="6246"){
					    capa.innerHTML="EMPRESA Y COMERCIO ";
					}else if(opcionSeleccionada=="6247"){
					    capa.innerHTML="INGLES ELECTIVO ";
					}else if(opcionSeleccionada=="6248"){
					    capa.innerHTML="REVOLUCION ECOLOGICA Y AMBIENTE ";
					}else if(opcionSeleccionada=="6249"){
					    capa.innerHTML="TALLER LABORATORIO METALMECANICO II ";
					}else if(opcionSeleccionada=="6250"){
					    capa.innerHTML="TALLER ANALISIS DE OPERACIONES Y NORMATIVA DEL SISTEMA EMPRESARIAL ";
					}else if(opcionSeleccionada=="6251"){
					    capa.innerHTML="TALLER LABORATORIO METALMECANICO ";
					}else if(opcionSeleccionada=="6252"){
					    capa.innerHTML="TALLER PRACTICAS SILVICULTURALES Y ECOLOGIA ";
					}else if(opcionSeleccionada=="6253"){
					    capa.innerHTML="TALLER PRACTICAS SILVICULTURALES Y ECOLOGIA II ";
					}else if(opcionSeleccionada=="6254"){
					    capa.innerHTML="EL CONSUMIDOR ";
					}else if(opcionSeleccionada=="6255"){
					    capa.innerHTML="GESTION COMERCIO EXTERIOR ";
					}else if(opcionSeleccionada=="6256"){
					    capa.innerHTML="GESTION DE POSTVENTA ";
					}else if(opcionSeleccionada=="6257"){
					    capa.innerHTML="GESTION DE VENTAS ";
					}else if(opcionSeleccionada=="6258"){
					    capa.innerHTML="INTERMEDIACION PUBLICITARIA ";
					}else if(opcionSeleccionada=="6259"){
					    capa.innerHTML="LEGISLACION MERCANTIL ";
					}else if(opcionSeleccionada=="6260"){
					    capa.innerHTML="PUBLICIDAD AUDIOVISUAL ";
					}else if(opcionSeleccionada=="6261"){
					    capa.innerHTML="VENTA PERSONALIZADA ";
					}else if(opcionSeleccionada=="6262"){
					    capa.innerHTML="DISEÑO ARQUITECTONICO Y URBANO ";
					}else if(opcionSeleccionada=="6263"){
					    capa.innerHTML="DISEÑO MULTIPLE FOCALIZADO ";
					}else if(opcionSeleccionada=="6264"){
					    capa.innerHTML="DERECHO COMERCIAL Y LEGISLACION SOCIAL ";
					}else if(opcionSeleccionada=="6265"){
					    capa.innerHTML="LABORATORIO ADMINISTRATIVO Y CONTABLE ";
					}else if(opcionSeleccionada=="6266"){
					    capa.innerHTML="COMPUTACION Y PRACTICA AGROPECUARIA ";
					}else if(opcionSeleccionada=="6267"){
					    capa.innerHTML="TALLER DEPORTIVO VOLEIBOL Y FUTBOL ";
					}else if(opcionSeleccionada=="6268"){
					    capa.innerHTML="ELECTRONICA Y TECNOLOGIA ";
					}else if(opcionSeleccionada=="6269"){
					    capa.innerHTML="LABORATORIO ESPECIALIDAD ";
					
					}else if(opcionSeleccionada=="6270"){
					    capa.innerHTML="LEGISLACION LABORAL Y ADMINISTRACION ";
					}else if(opcionSeleccionada=="6271"){
					    capa.innerHTML="LEGISLACION Y ADMINISTRACION LABORAL ";
					}else if(opcionSeleccionada=="6272"){
					    capa.innerHTML="TALLER MECANICO ";
					}else if(opcionSeleccionada=="6273"){
					    capa.innerHTML="TECNICAS DE REDACCION ";
					}else if(opcionSeleccionada=="6274"){
					    capa.innerHTML="TECNOLOGIA DE ELECTRICIDAD AUTOMOTRIZ ELECTRONICA ";
					}else if(opcionSeleccionada=="6205"){
					    capa.innerHTML="SOFTWARE Y HARDWARE ";
					}else if(opcionSeleccionada=="6206"){
					    capa.innerHTML="CULTIVO DE PECES Y ALGAS ";
					}else if(opcionSeleccionada=="6207"){
					    capa.innerHTML="MODELAJE Y CORTE DE VESTUARIO ASISTIDO POR COMPUTADORA ";
					}else if(opcionSeleccionada=="6208"){
					    capa.innerHTML="PREPARADO Y CONFECCION DE PRENDAS FEMENINAS DE VESTIR, DEPORTIVAS, DE TRABAJO Y DE ARTICULOS PARA EL HOGAR ";
					}else if(opcionSeleccionada=="6209"){
					    capa.innerHTML="SEGURIDAD Y PREVENCION DE RIESGOS EN ACUICULTURA Y NAVEGACION EN ACTIVIDADES DE ACUICULTURA ";
					}else if(opcionSeleccionada=="6210"){
					    capa.innerHTML="TALLER DE SOLDADURA AL ARCO ";
					}else if(opcionSeleccionada=="6211"){
					    capa.innerHTML="DISEÑO OPERACION Y MANTENIMIENTO DE SISTEMAS DE CONTROL ELECTRICO ";
					}else if(opcionSeleccionada=="6212"){
					    capa.innerHTML="MICROBIOLOGIA INDUSTRIAL ";
					}else if(opcionSeleccionada=="6213"){
					    capa.innerHTML="COSTOS Y ESTADOS DE RESULTADOS E INFORMES FINANCIEROS ";
					}else if(opcionSeleccionada=="6214"){
					    capa.innerHTML="GESTION EN COMERCIO EXTERIOR Y COMERCIO ELECTRONICO ";
					}else if(opcionSeleccionada=="6215"){
					    capa.innerHTML="QUIMICA FORMACION DIFERENCIADA HUMANISTICO-CIENTIFICA ";
					}else if(opcionSeleccionada=="6216"){
					    capa.innerHTML="PREPARADO Y CONFECCION DE VESTUARIO ";
					}else if(opcionSeleccionada=="6217"){
					    capa.innerHTML="VISION QUIMICA DE LOS CAMBIOS AMBIENTALES ";
					}else if(opcionSeleccionada=="6218"){
					    capa.innerHTML="MERCADO Y SISTEMAS TECNOLOGICOS I ";
					}else if(opcionSeleccionada=="6219"){
					    capa.innerHTML="ESTUDIOS DE LA REALIDAD NACIONAL Y MUNDIAL II ";
					}else if(opcionSeleccionada=="6220"){
					    capa.innerHTML="INGLES TECNICO II ";
					}else if(opcionSeleccionada=="6221"){
					    capa.innerHTML="QUIMICA DE LA NATURALEZA Y LA SALUD ";
					}else if(opcionSeleccionada=="6222"){
					    capa.innerHTML="TECNICAS DE LA EXPRESION ORAL Y ESCRITA II ";
					}else if(opcionSeleccionada=="6223"){
					    capa.innerHTML="FUNDAMENTO DE RELACIONES PUBLICAS ";
					}else if(opcionSeleccionada=="6224"){
					    capa.innerHTML="MERCADO Y SISTEMAS TECNOLOGICOS II ";
					}else if(opcionSeleccionada=="6225"){
					    capa.innerHTML="ADMINISTRACION II ";
					}else if(opcionSeleccionada=="6226"){
					    capa.innerHTML="MATEMATICA RECREATIVA ";
					}else if(opcionSeleccionada=="6227"){
					    capa.innerHTML="TEATRO, COMIC Y REVISTA ";
					}else if(opcionSeleccionada=="6228"){
					    capa.innerHTML="TALLER DE ARTES Y MANUALIDADES ";
					}else if(opcionSeleccionada=="6229"){
					    capa.innerHTML="TALLER PREDEPORTIVO Y RECREATIVO ";
					}else if(opcionSeleccionada=="6231"){
					    capa.innerHTML="TALLER DE DESTREZAS BASICAS DE EDUCACION FISICA ";
					}else if(opcionSeleccionada=="6232"){
					    capa.innerHTML="TALLER DE VOLEIBOL Y FUTBOL ";
					}else if(opcionSeleccionada=="6233"){
					    capa.innerHTML="REFORZAMIENTO MATEMATICA ";
					}else if(opcionSeleccionada=="6234"){
					    capa.innerHTML="BIBLIOTECA AL SERVICIO DEL APRENDIZAJE ";
					}else if(opcionSeleccionada=="6235"){
					    capa.innerHTML="LA VIDA Y SUS ORIGENES ";
					}else if(opcionSeleccionada=="6236"){
					    capa.innerHTML="TALLER DE GIMNASIA Y FUTBOL ";
					}else if(opcionSeleccionada=="6237"){
					    capa.innerHTML="REFORZAMIENTO CASTELLANO ";
					}else if(opcionSeleccionada=="6238"){
					    capa.innerHTML="QUIMICA PLAN DIFERENCIADO ";
					}else if(opcionSeleccionada=="6239"){
					    capa.innerHTML="GESTION DE COMRA Y VENTAS ";
					}else if(opcionSeleccionada=="6171"){
					    capa.innerHTML="TALLER APRENDER A APRENDER ";
					}else if(opcionSeleccionada=="6172"){
					    capa.innerHTML="TALLER DE TITERES ";
					}else if(opcionSeleccionada=="6173"){
					    capa.innerHTML="INFORMATICA NIVEL USUARIO ";
					}else if(opcionSeleccionada=="6174"){
					    capa.innerHTML="INTRODUCCION AL PARVULO ";
					}else if(opcionSeleccionada=="6175"){
					    capa.innerHTML="CREACION MUSICAL ";
					}else if(opcionSeleccionada=="6176"){
					    capa.innerHTML="CIRCUITOS ELECTRONICOS ";
					}else if(opcionSeleccionada=="6177"){
					    capa.innerHTML="LABORATORIO DE CIRCUITOS ELECTRONICOS ";
					}else if(opcionSeleccionada=="6178"){
					    capa.innerHTML="LABORATORIO DE REDES ELECTRICAS ";
					}else if(opcionSeleccionada=="6179"){
					    capa.innerHTML="PROYECTOS DE LA ESPECIALIDAD Y COMPUTACION ";
					}else if(opcionSeleccionada=="6180"){
					    capa.innerHTML="TALLER DE MAQUINAS ELECTRICAS ";
					}else if(opcionSeleccionada=="6181"){
					    capa.innerHTML="DESDE LOS BIO ELEMENTOS AL METABOLISMO CELULAR ";
					}else if(opcionSeleccionada=="6182"){
					    capa.innerHTML="LAS PLANTAS Y LOS ANIMALES Y SUS RESPUESTAS ANTE LAS CONDICIONES EXTREMAS DEL MEDIO ";
					}else if(opcionSeleccionada=="6183"){
					    capa.innerHTML="SISTEMA PLANETARIO Y TEORIA DE LA RELATIVIDAD ";
					}else if(opcionSeleccionada=="6184"){
					    capa.innerHTML="ARTE Y DECORACION ";
					}else if(opcionSeleccionada=="6185"){
					    capa.innerHTML="PASTELERIA Y COCINA ";
					}else if(opcionSeleccionada=="6186"){
					    capa.innerHTML="MANTENCION BASICA DE EQUIPOS Y HERRAMIENTAS ";
					}else if(opcionSeleccionada=="6187"){
					    capa.innerHTML="TALLERES DE CREATIVIDAD ";
					}else if(opcionSeleccionada=="6188"){
					    capa.innerHTML="HISTORIA CONTEMPORANEA DE AMERICA LATINA (SIGLO XX) ";
					}else if(opcionSeleccionada=="6189"){
					    capa.innerHTML="PORTUGUES ";
					}else if(opcionSeleccionada=="6190"){
					    capa.innerHTML="EXPERIENCIA EN LA EMPRESA ";
					}else if(opcionSeleccionada=="6191"){
					    capa.innerHTML="MANTENIMIENTO DE MOTORES Y MANTENIMIENTO DE LOS SISTEMAS AUXILIARES DEL MOTOR ";
					}else if(opcionSeleccionada=="6192"){
					    capa.innerHTML="PREPARADO Y CONFECCION DE VESTUARIO INFANTIL ";
					}else if(opcionSeleccionada=="6193"){
					    capa.innerHTML="MANTENIMIENTO DE LOS SISTEMAS DE TRANSMISION Y FRENADO Y MANTENIMIENTO DE LOS SISTEMAS DE DIRECCION Y SUSPENSION ";
					}else if(opcionSeleccionada=="6194"){
					    capa.innerHTML="TECNICAS DE MECANIZADO PARA EL MANTENIMIENTO DE VEHICULOS Y MANTENCION Y/O MONTAJE DE SISTEMAS DE SEGURIDAD Y CONFORTABILIDAD ";
					}else if(opcionSeleccionada=="6195"){
					    capa.innerHTML="LABORATORIO ENOLOGICO ";
					}else if(opcionSeleccionada=="6196"){
					    capa.innerHTML="DISEÑO MULTIPLE Y ESTETICA ";
					}else if(opcionSeleccionada=="6197"){
					    capa.innerHTML="DISEÑO MULTIPLE Y ESTETICA II ";
					}else if(opcionSeleccionada=="6198"){
					    capa.innerHTML="ATENCION INTEGRAL DE CLIENTES ";
					}else if(opcionSeleccionada=="6199"){
					    capa.innerHTML="CONOZCAMOS UNA EMPRESA ";
					}else if(opcionSeleccionada=="6200"){
					    capa.innerHTML="CULTURA FISICA, DEPORTE Y RECREACION ";
					}else if(opcionSeleccionada=="6201"){					
					    capa.innerHTML="HERRAMIENTAS DE GESTION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="6202"){
					    capa.innerHTML="TECNICAS DE DIGITACION ";
					}else if(opcionSeleccionada=="6203"){
					    capa.innerHTML="LENGUAJE Y PROGRAMACION ";
					}else if(opcionSeleccionada=="6204"){
					    capa.innerHTML="OPERACION DE RED ";
					}else if(opcionSeleccionada=="6137"){
					    capa.innerHTML="SALUD DEL NIÑO Y DEL ADOLESCENTE ";
					}else if(opcionSeleccionada=="6138"){
					    capa.innerHTML="EL MUNDO DEL ARTE Y LA MUSICA ";
					}else if(opcionSeleccionada=="6139"){
					    capa.innerHTML="LA MAGIA DE LOS NUMEROS ";
					}else if(opcionSeleccionada=="6140"){
					    capa.innerHTML="LA RELIGION FUENTE DE VIDA Y FE ";
					}else if(opcionSeleccionada=="6141"){
					    capa.innerHTML="MANUALIDADES Y UTILES ";
					}else if(opcionSeleccionada=="6142"){
					    capa.innerHTML="MI AMBIENTE Y YO ";
					}else if(opcionSeleccionada=="6143"){
					    capa.innerHTML="NUESTRO ENTORNO, CULTURAL, NATURAL Y SOCIAL ";
					}else if(opcionSeleccionada=="6144"){
					    capa.innerHTML="ORIGENES DE LA QUIMICA INTRODUCCION A LA TERMODINAMICA ";
					}else if(opcionSeleccionada=="6145"){
					    capa.innerHTML="PUEDO CREAR Y JUGAR CON MIS MANOS ";
					}else if(opcionSeleccionada=="6146"){
					    capa.innerHTML="PUEDO CREAR, JUGAR Y VALORAR EL TRABAJO CON MIS MANOS ";
					}else if(opcionSeleccionada=="6147"){
					    capa.innerHTML="TALLER DEPORTIVO RECREATIVO ";
					}else if(opcionSeleccionada=="6148"){
					    capa.innerHTML="TECNICAS PROCESO Y MANUALIDADES ";
					}else if(opcionSeleccionada=="6149"){
					    capa.innerHTML="ECONOMIA INTERNACIONAL CRECIENDO Y DESARROLLO ";
					}else if(opcionSeleccionada=="6150"){
					    capa.innerHTML="CIRCUITOS ELECTRICOS DEL VEHICULO Y MANTENIMIENTO DE LOS SISTEMAS ELECTRICOS Y ELECTRONICOS AUXILIARES DEL VEHICULO ";
					}else if(opcionSeleccionada=="6151"){
					    capa.innerHTML="APLICACIONES DE LAS MATEMATICAS ";
					}else if(opcionSeleccionada=="6152"){
					    capa.innerHTML="QUIMICA , FORMACION DIFERENCIADA HUMANISTICO - CIENTIFICA ";
					}else if(opcionSeleccionada=="6153"){
					    capa.innerHTML="PROCESOS DE SOLDADURA ";
					}else if(opcionSeleccionada=="6154"){
					    capa.innerHTML="MANTENIMIENTO BASICO DE MAQUINARIAS EQUIPOS Y HERRAMIENTAS ";
					}else if(opcionSeleccionada=="6155"){
					    capa.innerHTML="ACTIVIDAD CON LA FAMILIA Y TRABAJO EDUCATIVO CON PARVULO EN MODALIDAD NO CONVENCIONAL ";
					}else if(opcionSeleccionada=="6156"){
					    capa.innerHTML="ACTIVIDADES EDUCATIVAS, MATERIAL DIDACTICO Y DECORATIVO PARA TRABAJO CON PARVULO ";
					}else if(opcionSeleccionada=="6157"){
					    capa.innerHTML="ACTIVIDADES RECREATIVAS, MUSICALES CON GUITARRA Y DE EXPRESION CON PARVULO ";
					}else if(opcionSeleccionada=="6158"){
					    capa.innerHTML="SALUD EN PARVULO MANEJANDO LA HIGIENE Y SU ALIMENTACION ";
					}else if(opcionSeleccionada=="6159"){
					    capa.innerHTML="ARTES ESCENICAS / DEPORTES Y ACTIVIDADES DE EXPRESION MOTRIZ ";
					}else if(opcionSeleccionada=="6160"){
					    capa.innerHTML="COMPLEMENTARIO FISICA/ ANALISIS POLITICO DE CHILE ";
					}else if(opcionSeleccionada=="6161"){
					    capa.innerHTML="CONDICION FISICA / AUDIOVISUAL ";
					}else if(opcionSeleccionada=="6162"){
					    capa.innerHTML="TALLER EXPLORATORIO DIBUJO ";
					}else if(opcionSeleccionada=="6163"){
					    capa.innerHTML="TALLER EXPLORATORIO ORIENTACION ";
					}else if(opcionSeleccionada=="6164"){
					    capa.innerHTML="TALLER RECURSO EXPLORATORIO ";
					}else if(opcionSeleccionada=="6165"){
					    capa.innerHTML="TECNICA DE MECANIZADO PARA EL MANTENIMIENTO DE VEHICULO ";
					}else if(opcionSeleccionada=="6166"){
					    capa.innerHTML="TOPICOS DE FISICA INTEGRADOS A CIENCIA BIOLOGIA Y QUIMICA ";
					}else if(opcionSeleccionada=="6167"){
					    capa.innerHTML="SASTRERIA VARON ";
					}else if(opcionSeleccionada=="6168"){
					    capa.innerHTML="INDUSTRIALIZACION DE PRODUCTOS AGRICOLAS ";
					}else if(opcionSeleccionada=="6169"){
					    capa.innerHTML="PREPARACION Y EMBELLECIMIENTO DE SUPERFICIES DEL VEHICULO II ";
					}else if(opcionSeleccionada=="6170"){
					    capa.innerHTML="PRODUCCION DE FLORES Y PLANTAS ORNAMENTALES ";
					}else if(opcionSeleccionada=="6103"){
					    capa.innerHTML="GESTION EN PEQUEÑA EMPRESA DE EDIFICACION ";
					}else if(opcionSeleccionada=="6104"){
					    capa.innerHTML="LA ADMINISTRACION Y LA PREVENCION DE RIESGOS EN LA PEQUEÑA EMPRESA ";
					}else if(opcionSeleccionada=="6105"){
					    capa.innerHTML="LABORATORIO TECNOLOGICO EN EDIFICACION 1 ";
					}else if(opcionSeleccionada=="6106"){
					    capa.innerHTML="LABORATORIO TECNOLOGICO EN EDIFICACION 2 ";
					}else if(opcionSeleccionada=="6107"){
					    capa.innerHTML="LABORATORIO TECNOLOGICO EN TERMINACIONES 1 ";
					}else if(opcionSeleccionada=="6108"){
					    capa.innerHTML="LABORATORIO TECNOLOGICO EN TERMINACIONES 2 ";
					}else if(opcionSeleccionada=="6109"){
					    capa.innerHTML="BIOLOGIA GENERAL II ";
					}else if(opcionSeleccionada=="6110"){
					    capa.innerHTML="OPERACION DE EQUIPOS ELECTROHIDRONEUMATICOS INDUSTRIALES ";
					}else if(opcionSeleccionada=="6111"){
					    capa.innerHTML="PLANIFICACION Y PREVENCION DE RIESGOS ";
					}else if(opcionSeleccionada=="6112"){
					    capa.innerHTML="INICIACION A LA LOGICA ";
					}else if(opcionSeleccionada=="6113"){
					    capa.innerHTML="PROBLEMAS DEL MUNDO CONTEMPORANEO ";
					}else if(opcionSeleccionada=="6114"){
					    capa.innerHTML="PROYECTO INTERDISCIPLINARIO ";
					}else if(opcionSeleccionada=="6115"){
					    capa.innerHTML="QUIMICA ESPECIFICA ";
					}else if(opcionSeleccionada=="6116"){
					    capa.innerHTML="QUIMICA ESPECIFICA II ";
					}else if(opcionSeleccionada=="6117"){
					    capa.innerHTML="TECNICAS DE LA INVESTIGACION ";
					}else if(opcionSeleccionada=="6118"){
					    capa.innerHTML="TERMODINAMICA Y MUNDO CUANTICO ";
					}else if(opcionSeleccionada=="6119"){
					    capa.innerHTML="MANTENCION Y OPERACION DE MAQUINAS Y EQUIPOS ELECTRICOS ";
					}else if(opcionSeleccionada=="6120"){
					    capa.innerHTML="MEDIOS Y RECURSOS AUDIOVISUALES ";
					}else if(opcionSeleccionada=="6121"){
					    capa.innerHTML="TECNICAS DE INFORMATICA ";
					}else if(opcionSeleccionada=="6122"){
					    capa.innerHTML="CONFECCION DE PRENDAS PARA EL HOGAR Y LA FAMILIA ";
					}else if(opcionSeleccionada=="6123"){
					    capa.innerHTML="DECORE EL HOGAR CON SUS PROPIAS MANOS ";
					}else if(opcionSeleccionada=="6124"){
					    capa.innerHTML="PREPARACION Y CONFECCIONES DE SIMBOLOS EMBLEMATICOS ";
					}else if(opcionSeleccionada=="6125"){
					    capa.innerHTML="TECNICAS TRADICIONALES ";
					}else if(opcionSeleccionada=="6126"){
					    capa.innerHTML="MECANICA TECNICA ";
					}else if(opcionSeleccionada=="6127"){
					    capa.innerHTML="METALURGIA DE LA SOLDADURA ";
					}else if(opcionSeleccionada=="6128"){
					    capa.innerHTML="DISEÑO GRAFICO II ";
					}else if(opcionSeleccionada=="6129"){
					    capa.innerHTML="FUNDAMENTOS DE PSICOLOGIA GENERAL II ";
					}else if(opcionSeleccionada=="6130"){
					    capa.innerHTML="ATENCION DE ENFERMERIA BASICA INTEGRAL II 4º MEDIO ";
					}else if(opcionSeleccionada=="6131"){
					    capa.innerHTML="ATENCION DEL ADULTO MAYOR Y EL PACIENTE TERMINAL ";
					}else if(opcionSeleccionada=="6132"){
					    capa.innerHTML="EDUCACION PARA LA SALUD Y SALUD RURAL ";
					}else if(opcionSeleccionada=="6133"){
					    capa.innerHTML="PRIMEROS AUXILIOS, ATENCION PREHOSPITALARIA Y DE URGENCIA ";
					}else if(opcionSeleccionada=="6134"){
					    capa.innerHTML="RELACIONES INTERPERSONALES Y PROMOCION DE SALUD MENTAL ";
					}else if(opcionSeleccionada=="6135"){
					    capa.innerHTML="SALUD DE LA MUJER ";
					}else if(opcionSeleccionada=="6136"){
					    capa.innerHTML="SALUD DEL ADULTO ";
					}else if(opcionSeleccionada=="6068"){
					    capa.innerHTML="ELEMENTOS DE DERECHO LABORAL ";
					}else if(opcionSeleccionada=="6069"){
					    capa.innerHTML="ELEMENTOS DEL DERECHO ADMINISTRATIVO ";
					}else if(opcionSeleccionada=="6070"){
					    capa.innerHTML="ELEMENTOS DEL DERECHO PRIVADO ";
					}else if(opcionSeleccionada=="6071"){
					    capa.innerHTML="PROBLEMAS DEL CHILE CONTEMPORANEO ";
					}else if(opcionSeleccionada=="6072"){
					    capa.innerHTML="TECNICAS BASICAS DE GESTION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="6073"){
					    capa.innerHTML="MEDIO NATURAL ";
					}else if(opcionSeleccionada=="6074"){
					    capa.innerHTML="MEDIO SOCIAL Y CULTURAL ";
					}else if(opcionSeleccionada=="6075"){
					    capa.innerHTML="CAMARA FRIGORIFICA ";
					}else if(opcionSeleccionada=="6076"){
					    capa.innerHTML="TURISMO I ";
					}else if(opcionSeleccionada=="6077"){
					    capa.innerHTML="TURISMO II ";
					}else if(opcionSeleccionada=="6078"){
					    capa.innerHTML="PLATOS REPRESENTATIVOS DE LA COCINA ETNICA ";
					}else if(opcionSeleccionada=="6079"){
					    capa.innerHTML="SERVICIO DE CONSERJERIA Y CENTRO DE NEGOCIOS ";
					}else if(opcionSeleccionada=="6080"){
					    capa.innerHTML="LABORATORIO EXPLORACION ";
					}else if(opcionSeleccionada=="6081"){
					    capa.innerHTML="APLICACION EN INFORMATICA ";
					}else if(opcionSeleccionada=="6082"){
					    capa.innerHTML="MANTENCION Y OPERACION DE EQUIPOS DE CONTROL ELECTRICO DE POTENCIA ";
					}else if(opcionSeleccionada=="6083"){
					    capa.innerHTML="TAREAS DE SERVICIOS EN PLANTAS METALURGICAS ";
					}else if(opcionSeleccionada=="6084"){
					    capa.innerHTML="MANEJO HERRAMIENTAS INFORMATICAS ";
					}else if(opcionSeleccionada=="6085"){
					    capa.innerHTML="MANTENIMIENTO Y REPARACION DE COMPONENTES Y EQUIPOS ELECTRICOS";
					}else if(opcionSeleccionada=="6086"){
					    capa.innerHTML="APRENDAMOS A USAR NUESTRO CUERPO ";
					}else if(opcionSeleccionada=="6087"){
					    capa.innerHTML="EL MUNDO DE LOS NUMEROS ";
					}else if(opcionSeleccionada=="6088"){
					    capa.innerHTML="EL MUNDO QUE NOS RODEA ";
					}else if(opcionSeleccionada=="6089"){
					    capa.innerHTML="EVOLUCION ECOLOGICA Y AMBIENTE ";
					}else if(opcionSeleccionada=="6090"){
					    capa.innerHTML="EXPRESION DE LA FE ";
					}else if(opcionSeleccionada=="6091"){
					    capa.innerHTML="EXPRESION DEL ARTE ";
					}else if(opcionSeleccionada=="6092"){
					    capa.innerHTML="FE Y CULTURA ";
					}else if(opcionSeleccionada=="6094"){
					    capa.innerHTML="JUGANDO CON LAS MANOS ";
					}else if(opcionSeleccionada=="6095"){
					    capa.innerHTML="NUESTRA LENGUA MATERNA ";
					}else if(opcionSeleccionada=="6096"){
					    capa.innerHTML="MANEJO DE OFICINA I ";
					}else if(opcionSeleccionada=="6097"){
					    capa.innerHTML="MANEJO DE OFICINA II ";
					}else if(opcionSeleccionada=="6098"){
					    capa.innerHTML="PERSONALIDAD Y VIDA AFECTIVA ";
					}else if(opcionSeleccionada=="6099"){
					    capa.innerHTML="CIRCUITOS ELECTRONICOS BASICOS, SISTEMAS DE CARGA Y DE ARRANQUE DE LOS SISTEMAS AUXILIARES DEL MOTOR ";
					}else if(opcionSeleccionada=="6100"){
					    capa.innerHTML="CONTROLES EN LA INDUSTRIA ";
					}else if(opcionSeleccionada=="6101"){
					    capa.innerHTML="CUBICACION Y COSTOS EN EDIFICACION ";
					}else if(opcionSeleccionada=="6102"){
					    capa.innerHTML="CUBICACION Y COSTOS EN TERMINACIONES ";
					}else if(opcionSeleccionada=="6034"){
					    capa.innerHTML="ALIMENTACION Y TECNOLOGIA ";
					}else if(opcionSeleccionada=="6035"){
					    capa.innerHTML="IDENTIDAD Y SOCIEDAD ";
					}else if(opcionSeleccionada=="6036"){
					    capa.innerHTML="LENGUAJE HERRAMIENTA PRODUCTIVA ";
					}else if(opcionSeleccionada=="6037"){
					    capa.innerHTML="LENGUAJE Y VIDA COTIDIANA ";
					}else if(opcionSeleccionada=="6038"){
					    capa.innerHTML="MANEJO DE RECURSOS SILVO AGROPECUARIO ";
					}else if(opcionSeleccionada=="6039"){
					    capa.innerHTML="MATEMATICA APLICADA A LA INVESTIGACION ";
					}else if(opcionSeleccionada=="6040"){
					    capa.innerHTML="MATEMATICA APLICADA AL COMERCIO Y FINANZAS ";
					}else if(opcionSeleccionada=="6041"){
					    capa.innerHTML="NOCIONES DE ADMINISTRACION COMERCIAL ";
					}else if(opcionSeleccionada=="6042"){
					    capa.innerHTML="PROCESO DE CONSERVACION ";
					}else if(opcionSeleccionada=="6043"){
					    capa.innerHTML="SOCIEDAD Y PARTICIPACION ";
					}else if(opcionSeleccionada=="6044"){
					    capa.innerHTML="TECNICA TERMINOLOGIA ";
					}else if(opcionSeleccionada=="6045"){
					    capa.innerHTML="AUDITORIA Y ADMINISTRACION II ";
					}else if(opcionSeleccionada=="6046"){
					    capa.innerHTML="CONTABILIDAD AVANZADA ";
					}else if(opcionSeleccionada=="6047"){
					    capa.innerHTML="EVALUACION DE ESTRATEGIAS DE VENTA ";
					}else if(opcionSeleccionada=="6048"){
					    capa.innerHTML="GESTION CONTABLE II ";
					}else if(opcionSeleccionada=="6049"){
					    capa.innerHTML="INFORMATICA APLICADA II ";
					}else if(opcionSeleccionada=="6050"){
					    capa.innerHTML="INVESTIGACION DE MERCADO I ";
					}else if(opcionSeleccionada=="6051"){
					    capa.innerHTML="INVESTIGACION DE MERCADO II ";
					}else if(opcionSeleccionada=="6052"){
					    capa.innerHTML="LEGISLACION APLICADA A LA EMPRESA ";
					}else if(opcionSeleccionada=="6053"){
					    capa.innerHTML="TOMA DE DECISIONES Y RESOLUCION DE PROBLEMAS ";
					}else if(opcionSeleccionada=="6054"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION PARA LA INVESTIGACION ";
					}else if(opcionSeleccionada=="6055"){
					    capa.innerHTML="LEY COMERCIAL ";
					}else if(opcionSeleccionada=="6056"){
					    capa.innerHTML="LEY LABORAL APLICADA ";
					}else if(opcionSeleccionada=="6057"){
					    capa.innerHTML="LEY TRIBUTARIA I ";
					}else if(opcionSeleccionada=="6058"){
					    capa.innerHTML="LEY TRIBUTARIA II ";
					}else if(opcionSeleccionada=="6059"){
					    capa.innerHTML="LOGISTICA DE BODEGA ";
					}else if(opcionSeleccionada=="6060"){
					    capa.innerHTML="MARKETING DEL PUNTO DE VENTA I ";
					}else if(opcionSeleccionada=="6061"){
					    capa.innerHTML="MARKETING DEL PUNTO DE VENTA II ";
					}else if(opcionSeleccionada=="6062"){
					    capa.innerHTML="MARKETING ESTRATEGICO ";
					}else if(opcionSeleccionada=="6063"){
					    capa.innerHTML="MARKETING FUNDAMENTAL ";
					}else if(opcionSeleccionada=="6064"){
					    capa.innerHTML="PSICOLOGIA DE LA VENTA ";
					}else if(opcionSeleccionada=="6065"){
					    capa.innerHTML="SISTEMAS DE ARCHIVO ";
					}else if(opcionSeleccionada=="6066"){
					    capa.innerHTML="TECNICAS DE PSICOLOGIA APLICADA A LA EMPRESA ";
					}else if(opcionSeleccionada=="6067"){
					    capa.innerHTML="ELEMENTOS DE ADMINISTRACION Y NORMATIVAS ELECTRICAS ";
					}else if(opcionSeleccionada=="6000"){
					    capa.innerHTML="LENGUA CASTELLANA Y COMUNICACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="6001"){
					    capa.innerHTML="CULTURA MAPUCHE Y MAPUDUNGUN ";
					}else if(opcionSeleccionada=="6002"){
					    capa.innerHTML="TECNOLOGIA DE COMBUSTION DE LEÑA ";
					}else if(opcionSeleccionada=="6003"){
					    capa.innerHTML="EDUCACION TECNOLOGICA: UNA HERRAMIENTA PARA EL FUTURO ";
					}else if(opcionSeleccionada=="6004"){
					    capa.innerHTML="MANEJO INSTRUMENTAL DEL IDIOMA ";
					}else if(opcionSeleccionada=="6005"){
					    capa.innerHTML="INTRODUCCION A LA QUIMICA ";
					}else if(opcionSeleccionada=="6006"){
					    capa.innerHTML="INTRODUCCION A LA FISICA ";
					}else if(opcionSeleccionada=="6007"){
					    capa.innerHTML="LENGUA EXTRANJERA: FRANCES ";
					}else if(opcionSeleccionada=="6008"){
					    capa.innerHTML="LENGUA EXTRANJERA: INGLES ";
					}else if(opcionSeleccionada=="6009"){
					    capa.innerHTML="LENGUA MATERNA: CASTELLANO ";
					}else if(opcionSeleccionada=="6010"){
					    capa.innerHTML="ELECTRONICA Y ELECTRICIDAD ";
					}else if(opcionSeleccionada=="6011"){
					    capa.innerHTML="MANTENCION Y REPARACION DE COMPUTADORES ";
					}else if(opcionSeleccionada=="6012"){
					    capa.innerHTML="OFIMATICA ";
					}else if(opcionSeleccionada=="6013"){
					    capa.innerHTML="PLANIFICADOR DE VENTA Y PROMOCION ";
					}else if(opcionSeleccionada=="6014"){
					    capa.innerHTML="REPOSTERIA Y BANQUETERIA ";
					}else if(opcionSeleccionada=="6015"){
					    capa.innerHTML="ANALISIS QUIMICO ";
					}else if(opcionSeleccionada=="6016"){
					    capa.innerHTML="CONTROL Y GESTION ";
					}else if(opcionSeleccionada=="6017"){
					    capa.innerHTML="EL SISTEMA PLANTA QUIMICA ";
					}else if(opcionSeleccionada=="6018"){
					    capa.innerHTML="GESTION DE PEQUEÑA EMPRESA EN EDIFICACION ";
					}else if(opcionSeleccionada=="6019"){
					    capa.innerHTML="GESTION DE PEQUEÑA EMPRESA EN TERMINACION ";
					}else if(opcionSeleccionada=="6020"){
					    capa.innerHTML="INTERPRETACION DE PLANOS DE ARQUITECTURA ";
					}else if(opcionSeleccionada=="6021"){
					    capa.innerHTML="INTERPRETACION DE PLANOS DE INGENIERIA ";
					
					}else if(opcionSeleccionada=="6022"){
					    capa.innerHTML="LENGUA MATERNA ";
					}else if(opcionSeleccionada=="6023"){
					    capa.innerHTML="SOLDADURA, ARMADO Y PROTECCION DE SUPERFICIE ";
					}else if(opcionSeleccionada=="6024"){
					    capa.innerHTML="PROCESOS MECANICOS Y CONFORMADO DE PIEZAS ";
					}else if(opcionSeleccionada=="6025"){
					    capa.innerHTML="PROYECTO MECANICO Y MANTENCION INDUSTRIAL ";
					}else if(opcionSeleccionada=="6026"){
					    capa.innerHTML="LA EMPRESA Y SU ENTORNO ";
					}else if(opcionSeleccionada=="6027"){
					    capa.innerHTML="LA EMPRESA Y SUS FUNCIONES ";
					}else if(opcionSeleccionada=="6028"){
					    capa.innerHTML="TALLER COMPLEMENTARIO 1 ";
					}else if(opcionSeleccionada=="6029"){
					    capa.innerHTML="TALLER COMPLEMENTARIO 2 ";
					}else if(opcionSeleccionada=="6030"){
					    capa.innerHTML="TALLER DE GESTION 1 ";
					}else if(opcionSeleccionada=="6031"){
					    capa.innerHTML="TALLER DE GESTION 2 ";
					}else if(opcionSeleccionada=="6032"){
					    capa.innerHTML="ADMINISTRACION PERSONAL ";
					}else if(opcionSeleccionada=="6033"){
					    capa.innerHTML="ALGEBRA Y GEOMETRIA APLICADA ";
					}else if(opcionSeleccionada=="5965"){
					    capa.innerHTML="TECNOLOGIA AGROPECUARIA ";
					}else if(opcionSeleccionada=="5966"){
					    capa.innerHTML="CIRCUITOS ELECTRICOS AUXILIARES DEL VEHICULO Y MANTENIMIENTO DE LOS SISTEMAS ELECTRICOS AUXILIARES DEL VEHICULO ";
					}else if(opcionSeleccionada=="5967"){
					    capa.innerHTML="LOS SISTEMAS ELECTRICOS AUXILIARES DEL VEHICULO ";					
					}else if(opcionSeleccionada=="5968"){
					    capa.innerHTML="MANTENIMIENTO Y MECANIZADO EN MAQUINAS HERRAMIENTAS	CONVENCIONALES Y CNC ";
					}else if(opcionSeleccionada=="5969"){
					    capa.innerHTML="OPERACION Y AUTOMATIZACION ";
					}else if(opcionSeleccionada=="5970"){
					    capa.innerHTML="PROGRAMACION, CONFORMADO Y MECANIZADO DE PIEZAS AVANZADAS ";
					}else if(opcionSeleccionada=="5971"){
					    capa.innerHTML="ESCUELA DE ARTES Y MUSICA ";
					}else if(opcionSeleccionada=="5972"){
					    capa.innerHTML="TALLER DE HIGIENE Y SEGURIDAD ";
					}else if(opcionSeleccionada=="5973"){
					    capa.innerHTML="SICOLOGIA DEL DESARROLLO INFANTIL ";
					}else if(opcionSeleccionada=="5974"){
					    capa.innerHTML="COMUNICACION ESCRITA ";
					}else if(opcionSeleccionada=="5975"){
					    capa.innerHTML="INTRODUCCION A LOS SERVICIOS TURISTICOS ";
					}else if(opcionSeleccionada=="5976"){
					    capa.innerHTML="INTRODUCCION AL SECRETARIADO ";
					}else if(opcionSeleccionada=="5977"){
					    capa.innerHTML="EDUCACION TECNOLOGICA Y AGRICULTURA ";
					}else if(opcionSeleccionada=="5978"){
					    capa.innerHTML="EDUCACION TECNOLOGICA Y GANADERIA ";
					}else if(opcionSeleccionada=="5979"){
					    capa.innerHTML="GESTION EN AGROECOSISTEMAS ";
					}else if(opcionSeleccionada=="5980"){
					    capa.innerHTML="TECNICA APLICADA ";
					}else if(opcionSeleccionada=="5981"){
					    capa.innerHTML="ANATOMOFISIOLOGIA PARA ENFERMERIA ";
					}else if(opcionSeleccionada=="5983"){
					    capa.innerHTML="MICROBIOLOGIA Y PARASITOLOGIA ";
					}else if(opcionSeleccionada=="5984"){
					    capa.innerHTML="PLAN DE DESEMPEÑO PARA EL APRENDIZAJE DE LA EMPRESA ";
					}else if(opcionSeleccionada=="5985"){
					    capa.innerHTML="PLANIFICACION DE LA PRODUCCION, CONTROL DE COSTOS Y BODEGA ";
					}else if(opcionSeleccionada=="5986"){
					    capa.innerHTML="INSTRUMENTO PRINCIPAL CHELLO ";
					}else if(opcionSeleccionada=="5987"){
					    capa.innerHTML="INSTRUMENTO PRINCIPAL CLARINETE ";
					}else if(opcionSeleccionada=="5988"){
					    capa.innerHTML="INSTRUMENTO PRINCIPAL FLAUTA (TRAVERSA) ";
					}else if(opcionSeleccionada=="5989"){
					    capa.innerHTML="INSTRUMENTO PRINCIPAL SAXOFON ";
					}else if(opcionSeleccionada=="5990"){
					    capa.innerHTML="INSTRUMENTO PRINCIPAL TROMPETA ";
					}else if(opcionSeleccionada=="5991"){
					    capa.innerHTML="CULTIVOS PROTEGIDOS ";
					}else if(opcionSeleccionada=="5992"){
					    capa.innerHTML="ESTABLECIMIENTO MANEJO DE PRADERAS ";
					}else if(opcionSeleccionada=="5993"){
					    capa.innerHTML="LABORES AGROPECUARIAS ";
					}else if(opcionSeleccionada=="5994"){
					    capa.innerHTML="SISTEMA AGROPECUARIO I ";
					}else if(opcionSeleccionada=="5995"){
					    capa.innerHTML="SISTEMA AGROPECUARIO II ";
					}else if(opcionSeleccionada=="5996"){
					    capa.innerHTML="MAQUINARIAS E IMPLEMENTOS AGRICOLAS ";
					}else if(opcionSeleccionada=="5997"){
					    capa.innerHTML="PASANTIA EN LA EMPRESA ";
					}else if(opcionSeleccionada=="5998"){
					    capa.innerHTML="ECONOMIA Y LEGISLACION ";
					}else if(opcionSeleccionada=="5999"){
					    capa.innerHTML="ARTES VISUALES O MUSICALES FORMACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="5931"){
					    capa.innerHTML="CONTABILIDAD Y COMPRA Y VENTA ";
					}else if(opcionSeleccionada=="5932"){
					    capa.innerHTML="INFORMES FINANCIEROS Y COSTOS ";
					}else if(opcionSeleccionada=="5933"){
					    capa.innerHTML="NORMATIVA TRIBUTARIA Y COMERCIAL NACIONAL E INTERNACIONAL ";
					}else if(opcionSeleccionada=="5934"){
					    capa.innerHTML="EDUCACION ARTISTICA: ARTES PLASTICAS Y EDUCACION MUSICAL ";
					}else if(opcionSeleccionada=="5935"){
					    capa.innerHTML="DISCERNIMIENTO CRISTIANO ";
					}else if(opcionSeleccionada=="5936"){
					    capa.innerHTML="ACTIVIDADES RECREATIVAS Y EDUCATIVAS PARA EL TRABAJO CON PARVULOS ";
					}else if(opcionSeleccionada=="5937"){
					    capa.innerHTML="MODELAJE Y CORTE DE VESTUARIO FEMENINO PARA DIFERENTES OCASIONES";
					}else if(opcionSeleccionada=="5938"){
					    capa.innerHTML="PREPARADO Y CONFECCION DE PRENDAS DE VESTIR FEMENINA PARA DIFERENTES OCASIONES ";
					}else if(opcionSeleccionada=="5939"){
					    capa.innerHTML="TECNICAS DE COCINA BASICA Y DE SERVICIOS DE COMEDORES ";
					}else if(opcionSeleccionada=="5940"){
					    capa.innerHTML="TECNICAS DE SERVICIO DE COMEDORES ";
					}else if(opcionSeleccionada=="5941"){
					    capa.innerHTML="FILOSOFIA PARA ADOLESCENTES ";
					}else if(opcionSeleccionada=="5942"){
					    capa.innerHTML="FILOSOFIA PARA JOVENES ";
					}else if(opcionSeleccionada=="5943"){
					    capa.innerHTML="TEATRO Y DANZA ";
					}else if(opcionSeleccionada=="5944"){
					    capa.innerHTML="MECANIZACION AGRICOLA ";
					}else if(opcionSeleccionada=="5945"){
					    capa.innerHTML="PRODUCCION DE PECES ";
					}else if(opcionSeleccionada=="5946"){
					    capa.innerHTML="TALLER DE EXPERIENCIAS TECNOLOGICAS BASICAS ";
					}else if(opcionSeleccionada=="5947"){
					    capa.innerHTML="MANTENIMIENTO DE MAQUINAS E IMPLEMENTOS AGRICOLAS ";
					}else if(opcionSeleccionada=="5948"){
					    capa.innerHTML="CRIANZA Y FAENACION DE CERDOS ";
					}else if(opcionSeleccionada=="5949"){
					    capa.innerHTML="DERECHO PRIVADO II ";
					}else if(opcionSeleccionada=="5950"){
					    capa.innerHTML="ELEMENTOS DE DERECHO TRIBUTARIO ";
					}else if(opcionSeleccionada=="5951"){
					    capa.innerHTML="FIGURAS PENALES ";
					}else if(opcionSeleccionada=="5952"){
					    capa.innerHTML="LEY PROCESAL II ";
					}else if(opcionSeleccionada=="5953"){
					    capa.innerHTML="RELIGION EVANGELICA ";
					}else if(opcionSeleccionada=="5954"){
					    capa.innerHTML="BIOLOGIA CELULAR Y SUS APLICACIONES ";
					}else if(opcionSeleccionada=="5955"){
					    capa.innerHTML="DIVERSIDAD ORGANICA ";
					}else if(opcionSeleccionada=="5956"){
					    capa.innerHTML="HACIA UNA SOCIEDAD SOLIDARIA ";
					}else if(opcionSeleccionada=="5957"){
					    capa.innerHTML="QUIMICA Y CIENCIAS DE LA SALUD ";
					}else if(opcionSeleccionada=="5958"){
					    capa.innerHTML="MECANICA CUANTICA ";
					}else if(opcionSeleccionada=="5959"){
					    capa.innerHTML="COMUNICACION Y EXPRESION TEATRAL ";
					}else if(opcionSeleccionada=="5960"){
					    capa.innerHTML="DESARROLLO CORPORAL ";
					}else if(opcionSeleccionada=="5961"){
					    capa.innerHTML="MUJERES Y LITERATURA ";
					}else if(opcionSeleccionada=="5962"){
					    capa.innerHTML="ORATORIA ";
					}else if(opcionSeleccionada=="5963"){
					    capa.innerHTML="TALLER AFECTIVIDAD ";
					}else if(opcionSeleccionada=="5964"){
					    capa.innerHTML="UNA HISTORIA DIFERENTE ";
					}else if(opcionSeleccionada=="5897"){
					    capa.innerHTML="MATEMATICA APLICADA AL ARTE II ";
					}else if(opcionSeleccionada=="5898"){
					    capa.innerHTML="MATEMATICA INSTRUMENTAL I ";
					}else if(opcionSeleccionada=="5899"){
					    capa.innerHTML="MATEMATICA INSTRUMENTAL II ";
					}else if(opcionSeleccionada=="5900"){
					    capa.innerHTML="INTRODUCCION A LA FORMACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="5901"){
					    capa.innerHTML="ARTES DE LA REPRESENTACION TEATRO Y DANZA ";
					}else if(opcionSeleccionada=="5902"){
					    capa.innerHTML="CELULA Y ORGANISMO ,UN MODELO DE INTEGRACION ";
					}else if(opcionSeleccionada=="5903"){
					    capa.innerHTML="FUNDAMENTOS DE DESEMPEÑO Y ROL SOCIAL ";
					}else if(opcionSeleccionada=="5904"){
					    capa.innerHTML="GEOGRAFIA DE CHILE II ";
					}else if(opcionSeleccionada=="5905"){
					    capa.innerHTML="LA EXPRESION ESCRITA COMO MEDIO DE CREACION Y COMUNICACION ";
					}else if(opcionSeleccionada=="5906"){
					    capa.innerHTML="OFICIOS INTEGRADOS ";
					}else if(opcionSeleccionada=="5907"){
					    capa.innerHTML="PRENSA MEDIO DE COMUNICACION ";
					}else if(opcionSeleccionada=="5908"){
					    capa.innerHTML="PROCESOS PSICOLOGICOS ";
					}else if(opcionSeleccionada=="5909"){
					    capa.innerHTML="TECNICAS DE HABILITACION VERBAL ";
					}else if(opcionSeleccionada=="5910"){
					    capa.innerHTML="VIVIENDO MI PRESENTE PROYECTANDO MI FUTURO ";
					}else if(opcionSeleccionada=="5911"){
					    capa.innerHTML="ESPECIALIDADES ARTISTICA ";
					}else if(opcionSeleccionada=="5912"){
					    capa.innerHTML="FRANCES (SOCIAL Y COMUNICATIVO) ";
					}else if(opcionSeleccionada=="5913"){
					    capa.innerHTML="INTRODUCCION A LA GESTION ";
					}else if(opcionSeleccionada=="5914"){
					    capa.innerHTML="INTRODUCCION A LA PRODUCCION SILVOAGROPECUARIA ";
					}else if(opcionSeleccionada=="5915"){
					    capa.innerHTML="TECNOLOGIAS ALTERNATIVAS CAMPESINAS ";
					}else if(opcionSeleccionada=="5916"){
					    capa.innerHTML="PLAN COMPLEMENTARIO DE BIOLOGIA ";
					}else if(opcionSeleccionada=="5917"){
					    capa.innerHTML="PLAN COMPLEMENTARIO DE LENGUAJE ";
					}else if(opcionSeleccionada=="5918"){
					    capa.innerHTML="PLAN COMPLEMENTARIO DE MATEMATICAS ";
					}else if(opcionSeleccionada=="5919"){
					    capa.innerHTML="DISEÑO, OPERACION Y MANTENIMIENTO DE SISTEMAS DE CONTROL ";
					}else if(opcionSeleccionada=="5920"){
					    capa.innerHTML="INTERPRETACION DE PLANOS EN TERMINACIONES ";
					}else if(opcionSeleccionada=="5921"){
					    capa.innerHTML="INTERPRETACION DE PLANOS Y PROYECTOS ";
					}else if(opcionSeleccionada=="5922"){
					    capa.innerHTML="LABORATORIO DE ADITIVOS Y JUNTAS DE HORMIGON ";
					}else if(opcionSeleccionada=="5923"){
					    capa.innerHTML="MANTENCION Y OPERACION DE EQUIPOS DE CONTROL ELECTRICO ";
					}else if(opcionSeleccionada=="5924"){
					    capa.innerHTML="MANTENIMIENTO OPERACION Y DISTRIBUCION CON CIRCUITOS Y DISPOSITIVOS DIGITALES ";
					}else if(opcionSeleccionada=="5925"){
					    capa.innerHTML="MANTENIMIENTO Y OPERACION DE EQUIPOS DE CONTROL ELECTRICO DE POTENCIA ";
					}else if(opcionSeleccionada=="5926"){
					    capa.innerHTML="MEDICION Y ANALISIS DE COMPONENTES Y CIRCUITOS ELECTRICOS ";
					}else if(opcionSeleccionada=="5927"){
					    capa.innerHTML="OPERACIONES BASICAS EN EL DESARROLLO DE LOS OFICIOS MECANICOS ";
					}else if(opcionSeleccionada=="5928"){
					    capa.innerHTML="SISTEMAS ELECTRICOS DIGITALES ";
					}else if(opcionSeleccionada=="5929"){
					    capa.innerHTML="TECNICAS BASICAS PARA LA CONSTRUCCION DE UNA VIVIENDA DE ALBAÑILERIA ";
					}else if(opcionSeleccionada=="5930"){
					    capa.innerHTML="TECNICAS DE DESARROLLO DE LA MECANICA INDUSTRIAL ";
					}else if(opcionSeleccionada=="5863"){
					    capa.innerHTML="EJERCICIO FISICO APLICADO AL TRABAJO ";
					}else if(opcionSeleccionada=="5864"){
					    capa.innerHTML="PRODUCCION AGROPECUARIA ";
					}else if(opcionSeleccionada=="5865"){
					    capa.innerHTML="CULTIVOS FRUTALES Y FORESTALES ";
					}else if(opcionSeleccionada=="5866"){
					    capa.innerHTML="PREPARACION DE PLATOS TIPICOS NACIONALES E INTERNACIONALES ";
					}else if(opcionSeleccionada=="5867"){
					    capa.innerHTML="TECNICAS DE ELABORACION  Y PRESENTACION DE PLATOS  DE LA COCINA ETNICA ";
					}else if(opcionSeleccionada=="5868"){
					    capa.innerHTML="ANALISIS GRAVIMETRICO Y VOLUMETRICO, FABRICACION DE PRODUCTOS INDUSTRIALES ORGANICOS ";
					}else if(opcionSeleccionada=="5869"){
					    capa.innerHTML="ADMINISTRACION DE MICROEMPRESA ";
					}else if(opcionSeleccionada=="5870"){
					    capa.innerHTML="CIENCIAS SOCIALES E HISTORIA ";
					}else if(opcionSeleccionada=="5871"){
					    capa.innerHTML="COMPORTAMIENTO PSICOSOCIAL ";
					}else if(opcionSeleccionada=="5872"){
					    capa.innerHTML="ELEMENTO DE DERECHO POLITICO ";
					}else if(opcionSeleccionada=="5873"){
					    capa.innerHTML="ELEMENTOS DE LEGISLACION ";
					}else if(opcionSeleccionada=="5874"){
					    capa.innerHTML="ENFERMEDADES DEL GANADO ";
					}else if(opcionSeleccionada=="5875"){
					    capa.innerHTML="INTRODUCCION A LA EDUCACION PARVULARIA ";
					}else if(opcionSeleccionada=="5876"){
					    capa.innerHTML="INTRODUCCION A LA COMERCIALIZACION ";
					}else if(opcionSeleccionada=="5877"){
					    capa.innerHTML="NOCIONES ELEMENTALES DE ADMINISTRACION ";
					}else if(opcionSeleccionada=="5878"){
					    capa.innerHTML="NUTRICION II ";
					}else if(opcionSeleccionada=="5879"){
					    capa.innerHTML="PRODUCCION AVIAR ";
					}else if(opcionSeleccionada=="5880"){
					    capa.innerHTML="PSICOLOGIA ADULTO MAYOR ";
					}else if(opcionSeleccionada=="5881"){
					    capa.innerHTML="PSICOPATOLOGIA DEL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="5882"){
					    capa.innerHTML="RELACIONES PUBLICAS Y ATENCION DEL USUARIO ";
					}else if(opcionSeleccionada=="5883"){
					    capa.innerHTML="SISTEMA DE ORGANIZACION PARA LA GESTION ";
					}else if(opcionSeleccionada=="5884"){
					    capa.innerHTML="SISTEMAS DE INFORMACION PARA LA GESTION ";
					}else if(opcionSeleccionada=="5885"){
					    capa.innerHTML="TEORIA ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="5886"){
					    capa.innerHTML="TEORIA EN ADMINISTRACION ";
					}else if(opcionSeleccionada=="5887"){
					    capa.innerHTML="CIRCUITOS ELECTRONICOS BASICOS Y MANTENCION DE LOS SISTEMAS DE CARGA Y DE ARRANQUE DEL VEHICULO ";
					}else if(opcionSeleccionada=="5888"){
					    capa.innerHTML="COSTOS, REGULARIZACION E INFORMES FINANCIEROS ";
					}else if(opcionSeleccionada=="5889"){
					    capa.innerHTML="DISEÑO, OPERACION Y MANTENCION DE LOS SISTEMAS ELECTRICOS ";
					}else if(opcionSeleccionada=="5890"){
					    capa.innerHTML="MANTENIMIENTO DE OPERACION Y MAQUINAS Y EQUIPOS ELECTRICOS ";
					}else if(opcionSeleccionada=="5891"){
					    capa.innerHTML="NORMATIVA PREVISIONAL COMERCIAL Y TRIBUTARIA ";
					}else if(opcionSeleccionada=="5892"){
					    capa.innerHTML="FUNCIONES Y PROCESOS ANALITICOS ";
					}else if(opcionSeleccionada=="5893"){
					    capa.innerHTML="INGLES: SOCIAL - COMUNICATIVO ";
					}else if(opcionSeleccionada=="5894"){
					    capa.innerHTML="INTRODUCCION A LAS CIENCIAS SOCIALES I ";
					}else if(opcionSeleccionada=="5895"){
					    capa.innerHTML="INTRODUCCION A LAS CIENCIAS SOCIALES II ";
					}else if(opcionSeleccionada=="5896"){
					    capa.innerHTML="MATEMATICA APLICADA AL ARTE I ";
					}else if(opcionSeleccionada=="5829"){
					    capa.innerHTML="PRINCIPIOS DE GESTION PARA LA MICROEMPRESA ";
					}else if(opcionSeleccionada=="5830"){
					    capa.innerHTML="PRINCIPIOS DE PLANIFICACION Y BOLLERIA ";
					}else if(opcionSeleccionada=="5831"){
					    capa.innerHTML="TECNICA DE BAQUETEARIA ";
					}else if(opcionSeleccionada=="5832"){
					    capa.innerHTML="TECNICA PARA LA HABILITACION DE VIVEROS ";
					}else if(opcionSeleccionada=="5833"){
					    capa.innerHTML="TECNICA PARA PREPARACION DE COCTELES ";
					}else if(opcionSeleccionada=="5834"){
					    capa.innerHTML="ADMINISTRACION PORTUARIA ";
					}else if(opcionSeleccionada=="5835"){
					    capa.innerHTML="ADMINISTRACION SISTEMAS PORTUARIOS ";
					}else if(opcionSeleccionada=="5836"){
					    capa.innerHTML="CLASIFICACION DE NAVES PUERTOS Y CARGAS ";
					}else if(opcionSeleccionada=="5837"){
					    capa.innerHTML="LOGISTICA PORTUARIA ";
					}else if(opcionSeleccionada=="5838"){
					    capa.innerHTML="SEGURIDAD PORTUARIA ";
					}else if(opcionSeleccionada=="5839"){
					    capa.innerHTML="TALLER DE ANALISIS APRENDIZAJE EN LA EMPRESA ";
					}else if(opcionSeleccionada=="5840"){
					    capa.innerHTML="FILOSOFIA DIFERENCIADA, ARGUMENTACION Y PROBLEMAS DEL APRENDIZAJE ";
					}else if(opcionSeleccionada=="5841"){
					    capa.innerHTML="INGLES CULTURAL LITERARIO ";
					}else if(opcionSeleccionada=="5842"){
					    capa.innerHTML="INTRODUCCION A SERVICIOS HOTELEROS ";
					}else if(opcionSeleccionada=="5843"){
					    capa.innerHTML="TECNICAS Y SERVICIOS DE COMEDORES Y ATENCION AL CLIENTE ";
					}else if(opcionSeleccionada=="5844"){
					    capa.innerHTML="INGLES CIENTIFICO-LOGICO ";
					}else if(opcionSeleccionada=="5845"){
					    capa.innerHTML="SOCIAL COMUNICATIVO ( INGLES CIENTIFICO) ";
					}else if(opcionSeleccionada=="5846"){
					    capa.innerHTML="SOCIAL COMUNICATIVO ( INGLES HUMANISTA) ";
					}else if(opcionSeleccionada=="5847"){
					    capa.innerHTML="DESARROLLO DEL PENSAMIENTO PRACTICO ";
					}else if(opcionSeleccionada=="5848"){
					    capa.innerHTML="MODULO CIENTIFICO TECNOLOGICO VOCACIONAL ";
					}else if(opcionSeleccionada=="5849"){
					    capa.innerHTML="EDUCACION TECNOLOGICA ORIENTADA A LA GASTRONOMIA ";
					}else if(opcionSeleccionada=="5850"){
					    capa.innerHTML="EDUCACION PARA LA VIDA CIUDADANA ";
					}else if(opcionSeleccionada=="5851"){
					    capa.innerHTML="TALLER DE INTRODUCCION A LA ECONOMIA ";
					}else if(opcionSeleccionada=="5852"){
					    capa.innerHTML="BODEGA, PLANIFICACION Y CONTROL DE COSTO ";
					}else if(opcionSeleccionada=="5853"){
					    capa.innerHTML="PROYECTOS COMUNITARIOS ";
					}else if(opcionSeleccionada=="5854"){
					    capa.innerHTML="EDUCACION ORIENTADA A LA EMPRESA ";
					}else if(opcionSeleccionada=="5855"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION IDIOMA EXTRANJERO INGLES ";
					}else if(opcionSeleccionada=="5856"){
					    capa.innerHTML="TALLER DE USO Y APLICACIONES DE NUEVAS TECNOLOGIAS ";
					}else if(opcionSeleccionada=="5857"){
					    capa.innerHTML="ETICA CRISTIANA ";
					}else if(opcionSeleccionada=="5858"){
					    capa.innerHTML="CONCEPTOS BASICOS DE TECNICAS DE LABORATORIO ";
					}else if(opcionSeleccionada=="5859"){
					    capa.innerHTML="ARGUMENTACION Y ONTOLOGIA  DEL LENGUAJE ";
					}else if(opcionSeleccionada=="5860"){
					    capa.innerHTML="EVOLUCION ECOLOGICA Y MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="5861"){
					    capa.innerHTML="DIVERSIDAD DEL LENGUAJE ";
					}else if(opcionSeleccionada=="5862"){
					    capa.innerHTML="INTRODUCCION AL CALCULO INFINITESIMAL II ";
					}else if(opcionSeleccionada=="5795"){
					    capa.innerHTML="LENGUAJE Y PUBLICIDAD ";
					}else if(opcionSeleccionada=="5796"){
					    capa.innerHTML="TECNICAS AVANZADAS EN GESTION TURISTICA Y HOTELERA I ";
					}else if(opcionSeleccionada=="5797"){
					    capa.innerHTML="TECNICAS AVANZADAS EN GESTION TURISTICA Y HOTELERA II ";
					}else if(opcionSeleccionada=="5798"){
					    capa.innerHTML="VISION DEL ACONTECER NACIONAL ";
					}else if(opcionSeleccionada=="5799"){
					    capa.innerHTML="INSTALACION, OPERACION Y PROGRAMACION DE EQUIPOS Y SISTEMAS TELEINFORMATICOS ";
					}else if(opcionSeleccionada=="5800"){
					    capa.innerHTML="MANTENCION Y OPERACION DE EQUIPOS DE SONIDO E IMAGEN ";
					}else if(opcionSeleccionada=="5801"){
					    capa.innerHTML="EL DESARROLLO ECONOMICO UN DESAFIO ";
					}else if(opcionSeleccionada=="5802"){
					    capa.innerHTML="FUNDAMENTOS DE SOCIOLOGIA ";
					}else if(opcionSeleccionada=="5803"){
					    capa.innerHTML="POST COSECHA DE FRUTAS ";
					}else if(opcionSeleccionada=="5804"){
					    capa.innerHTML="CONFECCION Y VESTUARIO II ";
					}else if(opcionSeleccionada=="5805"){
					    capa.innerHTML="BIOLOGIA, EVOLUCION ECOLOGICA Y AMBIENTE ";
					}else if(opcionSeleccionada=="5806"){
					    capa.innerHTML="HISTORIA Y CIENCIAS SOCIALES INTRODUCCION AL DERECHO ";
					}else if(opcionSeleccionada=="5807"){
					    capa.innerHTML="INSTALACIONES ELECTRICAS, MONTAJE Y PROYECTOS ELECTRICOS ";
					}else if(opcionSeleccionada=="5808"){
					    capa.innerHTML="MEDICION Y ANALISIS DE CIRCUITOS ELECTRICOS Y ELECTRONICOS ";
					}else if(opcionSeleccionada=="5809"){
					    capa.innerHTML="PROYECTO E INSTALACIONES ELECTRICAS, COMANDO, PLC ";
					}else if(opcionSeleccionada=="5810"){
					    capa.innerHTML="PROYECTO ELECTRONICO, ARMADO DE PC Y ELECTRONICA DE POTENCIA ";
					}else if(opcionSeleccionada=="5811"){
					    capa.innerHTML="SISTEMAS DIGITALES, MANTENIMIENTO Y OPERACION DE MAQUINAS Y EQUIPOS ELECTRICOS ";
					}else if(opcionSeleccionada=="5812"){
					    capa.innerHTML="SONIDO E IMAGEN Y CIRCUITOS ELECTRONICOS DIGITALES ";
					}else if(opcionSeleccionada=="5813"){
					    capa.innerHTML="MATEMATICA ALGEBRA Y MODELO ANALITICO ";
					}else if(opcionSeleccionada=="5814"){
					    capa.innerHTML="INTRODUCCION A LA GESTION DE OFICINA ";
					}else if(opcionSeleccionada=="5815"){
					    capa.innerHTML="ELECTIVO IDIOMA EXTRANJERO (ALEMAN) ";
					}else if(opcionSeleccionada=="5816"){
					    capa.innerHTML="SISTEMA TECNOLOGICO COMPUTACIONAL: UTILITARIO O DE PROGRAMACION ";
					}else if(opcionSeleccionada=="5817"){
					    capa.innerHTML="ARTE TESTIMONIO Y CULTURA ";
					}else if(opcionSeleccionada=="5818"){
					    capa.innerHTML="TECNOLOGIA Y DISEÑO ";
					}else if(opcionSeleccionada=="5819"){
					    capa.innerHTML="ARTES VISUALES Y EL DISEÑO ESCENOGRAFICO ";
					}else if(opcionSeleccionada=="5820"){
					    capa.innerHTML="APLICACION DE LAS MATEMATICAS ";
					}else if(opcionSeleccionada=="5821"){
					    capa.innerHTML="APLICACION DE LAS MATEMATICAS EN LA CIENCIA ";
					}else if(opcionSeleccionada=="5822"){
					    capa.innerHTML="QUIMICA DE LAS MOLECULAS ";
					}else if(opcionSeleccionada=="5823"){
					    capa.innerHTML="SOCIEDAD CONTEMPORANEA Y TECNICAS DE INVESTIGACION SOCIAL ";
					}else if(opcionSeleccionada=="5824"){
					    capa.innerHTML="MATEMATICA SUPERIOR ";
					}else if(opcionSeleccionada=="5825"){
					    capa.innerHTML="SIMBOLOGIA Y SINTAXIS ";
					}else if(opcionSeleccionada=="5826"){
					    capa.innerHTML="FUNDAMENTOS SOBRE MANEJO DE PAKING ";
					}else if(opcionSeleccionada=="5827"){
					    capa.innerHTML="INTRODUCCION A LOS CULTIVOS FORZADOS ";
					}else if(opcionSeleccionada=="5828"){
					    capa.innerHTML="NOCIONES DE COCINA TRADICIONAL Y PLATOS TIPICOS ";
					}else if(opcionSeleccionada=="5760"){
					    capa.innerHTML="MODELOS MATEMATICOS INTUITIVOS ";
					}else if(opcionSeleccionada=="5761"){
					    capa.innerHTML="SISTEMAS DE INTEGRACION ";
					}else if(opcionSeleccionada=="5762"){
					    capa.innerHTML="ELECTIVO INGLES CIENTIFICO Y TECNOLOGICO ";
					}else if(opcionSeleccionada=="5763"){
					    capa.innerHTML="ELECTIVO FUNCIONES Y PROCESOS INFORMATICOS ";
					}else if(opcionSeleccionada=="5765"){
					    capa.innerHTML="FRUTALES MENORES DE HOJA CADUCA Y PERENNE ";
					}else if(opcionSeleccionada=="5766"){
					    capa.innerHTML="PRODUCCION, REPRODUCCION Y SANIDAD ANIMAL ";
					}else if(opcionSeleccionada=="5767"){
					    capa.innerHTML="SISTEMA DE PRODUCCION Y PROPAGACION VEGETAL ";
					}else if(opcionSeleccionada=="5768"){
					    capa.innerHTML="LABORATORIO DE LETRAS ";
					}else if(opcionSeleccionada=="5769"){
					    capa.innerHTML="LABORATORIO DE MATEMATICAS ";
					}else if(opcionSeleccionada=="5770"){
					    capa.innerHTML="SICOLOGIA Y RELACIONES HUMANAS ";
					}else if(opcionSeleccionada=="5771"){
					    capa.innerHTML="APRECIACION ESTETICA ";
					}else if(opcionSeleccionada=="5772"){
					    capa.innerHTML="FORMACION TEOLOGICA ";
					}else if(opcionSeleccionada=="5773"){
					    capa.innerHTML="HISTORIA DE LAS IDEAS POLITICAS ";
					}else if(opcionSeleccionada=="5774"){
					    capa.innerHTML="INTRODUCCION A LA ECONOMIA ";
					}else if(opcionSeleccionada=="5775"){
					    capa.innerHTML="MORFOFISIOLOGIA ";
					}else if(opcionSeleccionada=="5776"){
					    capa.innerHTML="CIENCIAS SOCIALES: LA CIUDAD ";
					}else if(opcionSeleccionada=="5777"){
					    capa.innerHTML="APRENDER EN ACCION ";
					}else if(opcionSeleccionada=="5778"){
					    capa.innerHTML="OPTIMIZACION DE ESPACIO ";
					}else if(opcionSeleccionada=="5779"){
					    capa.innerHTML="BIOLOGIA DIFERENCIADA ";
					}else if(opcionSeleccionada=="5780"){
					    capa.innerHTML="CIENCIAS SOCIALES DIFERENCIADA Y ECONOMIA ";
					}else if(opcionSeleccionada=="5781"){
					    capa.innerHTML="FISICA DIFERENCIADA ";
					}else if(opcionSeleccionada=="5782"){
					    capa.innerHTML="IDIOMA EXTRANJERO DIFERENCIADO: INGLES/ FRANCES/ALEMAN ";
					}else if(opcionSeleccionada=="5783"){
					    capa.innerHTML="IDIOMA EXTRANJERO: INGLES/FRANCES/ALEMAN ";
					}else if(opcionSeleccionada=="5784"){
					    capa.innerHTML="LENGUA CASTELLANA Y FORMACION DIFERENCIADA I: PERIODISMO ";
					}else if(opcionSeleccionada=="5785"){
					    capa.innerHTML="LENGUA CASTELLANA Y FORMACION DIFERENCIADA II: CREACION LITERARIA ";
					}else if(opcionSeleccionada=="5786"){
					    capa.innerHTML="ALEMAN DIFERENCIADO ";
					}else if(opcionSeleccionada=="5787"){
					    capa.innerHTML="INGLES DIFERENCIADO ";
					}else if(opcionSeleccionada=="5788"){
					    capa.innerHTML="MANTENCION DE AREAS VERDES ";
					}else if(opcionSeleccionada=="5789"){
					    capa.innerHTML="INGLES: VOCACIONAL - CIENTIFICO TECNOLOGICO - CULTURAL LITERARIO ";
					}else if(opcionSeleccionada=="5790"){
					    capa.innerHTML="CONTABILIDAD BASICA + NORMATIVA COMERCIAL Y TRIBUTARIA ";
					}else if(opcionSeleccionada=="5791"){
					    capa.innerHTML="GESTION DE COMPRAVENTAS + GESTION EN APROVISIONAMIENTO ";
					}else if(opcionSeleccionada=="5792"){
					    capa.innerHTML="CONVIVENCIA CIVICO SOCIAL ";
					}else if(opcionSeleccionada=="5793"){
					    capa.innerHTML="INFORMATICA AVANZADA I ";
					}else if(opcionSeleccionada=="5794"){
					    capa.innerHTML="INFORMATICA AVANZADA II ";
					}else if(opcionSeleccionada=="5726"){
					    capa.innerHTML="ALGEBRA Y CALCULO ";
					}else if(opcionSeleccionada=="5727"){
					    capa.innerHTML="ELABORACION DE PLATOS PRINCIPALES Y TIPICOS NACIONALES E INTERNACIONALES ";
					}else if(opcionSeleccionada=="5728"){
					    capa.innerHTML="LITERATURA ESPAÑOLA E HISPANOAMERICANA DEL SIGLO XX ";
					}else if(opcionSeleccionada=="5729"){
					    capa.innerHTML="NOCIONES DE DERECHO CIVIL ";
					}else if(opcionSeleccionada=="5730"){
					    capa.innerHTML="NOCIONES DE DERECHO POLITICO Y CONSTITUCIONAL ";
					}else if(opcionSeleccionada=="5731"){
					    capa.innerHTML="QUIMICA ORGANICA Y BIOQUIMICA ";
					}else if(opcionSeleccionada=="5732"){
					    capa.innerHTML="SOCIEDAD Y COMUNICACION ";
					}else if(opcionSeleccionada=="5733"){
					    capa.innerHTML="TOPICOS DE MATEMATICA UNIVERSITARIA ";
					}else if(opcionSeleccionada=="5734"){
					    capa.innerHTML="EDUCACION TECNOLOGICA COMPUTACIONAL ";
					}else if(opcionSeleccionada=="5735"){
					    capa.innerHTML="CONECTIVIDAD Y REDES ";
					}else if(opcionSeleccionada=="5736"){
					    capa.innerHTML="ALGEBRA MATRICIAL Y TRIGONOMETRIA ";
					}else if(opcionSeleccionada=="5737"){
					    capa.innerHTML="APLICACIONES NUMERICAS ELEMENTALES ";
					}else if(opcionSeleccionada=="5738"){
					    capa.innerHTML="DERIVADAS E INTEGRALES ";
					}else if(opcionSeleccionada=="5739"){
					    capa.innerHTML="FUNCIONES APLICADAS ";
					}else if(opcionSeleccionada=="5740"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA DE CHILE APLICADA ";
					}else if(opcionSeleccionada=="5741"){
					    capa.innerHTML="RECORRIDO POR EL TIEMPO Y EL ESPACIO ";
					}else if(opcionSeleccionada=="5742"){
					    capa.innerHTML="TALLER DE APOYO EDUCATIVO ";
					}else if(opcionSeleccionada=="5743"){
					    capa.innerHTML="TALLER DE MATEMATICA APLICADA ";
					}else if(opcionSeleccionada=="5744"){
					    capa.innerHTML="APOYO A LOS MODULOS ";
					}else if(opcionSeleccionada=="5745"){
					    capa.innerHTML="ELEMENTOS DE ECONOMIA ";
					}else if(opcionSeleccionada=="5746"){
					    capa.innerHTML="TALLER ARTE DE PINTAR ";
					}else if(opcionSeleccionada=="5747"){
					    capa.innerHTML="IDIOMA EXTRANJERO INGLES DIFERENCIADO ";
					}else if(opcionSeleccionada=="5748"){
					    capa.innerHTML="NOCIONES DE COMPUTACION NIVEL II ";
					}else if(opcionSeleccionada=="5749"){
					    capa.innerHTML="NOCIONES DE COMPUTACION NIVEL III ";
					}else if(opcionSeleccionada=="5750"){
					    capa.innerHTML="TUTORIA Y ORIENTACION ";
					}else if(opcionSeleccionada=="5751"){
					    capa.innerHTML="ARQUITECTURA Y DISEÑO ";
					}else if(opcionSeleccionada=="5752"){
					    capa.innerHTML="CHILE, ESPACIO Y TIEMPO ";
					}else if(opcionSeleccionada=="5753"){
					    capa.innerHTML="CREATIVIDAD Y EXPRESION ";
					}else if(opcionSeleccionada=="5754"){
					    capa.innerHTML="ECONOMIA Y PROBLEMAS DEL DESARROLLO ";
					}else if(opcionSeleccionada=="5755"){
					    capa.innerHTML="ESTETICA II ";
					}else if(opcionSeleccionada=="5756"){
					    capa.innerHTML="FISICA, TECNOLOGIA Y CIENCIA ";
					}else if(opcionSeleccionada=="5757"){
					    capa.innerHTML="FUNCIONES ";
					}else if(opcionSeleccionada=="5758"){
					    capa.innerHTML="LATINOAMERICA Y SUS CREADORES ";
					}else if(opcionSeleccionada=="5759"){
					    capa.innerHTML="LENGUAJE Y SOCIALIZACION ";
					}else if(opcionSeleccionada=="5690"){
					    capa.innerHTML="TALLER DE GESTION EMPRESARIAL ";
					}else if(opcionSeleccionada=="5691"){
					    capa.innerHTML="LITERATURA E IDENTIDAD HISPANOAMERICANA ";
					}else if(opcionSeleccionada=="5692"){
					    capa.innerHTML="BIOQUIMICA Y QUIMICA INDUSTRIAL ";
					}else if(opcionSeleccionada=="5693"){
					    capa.innerHTML="CONTROL DE CALIDAD ( GESTION AMBIENTAL Y PRODUCCION LIMPIA) ";
					}else if(opcionSeleccionada=="5694"){
					    capa.innerHTML="ELECTRICIDAD BASICA DOMICILIARIA ";
					}else if(opcionSeleccionada=="5695"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DE LA NATURALEZA Y LA SOCIEDAD ";
					}else if(opcionSeleccionada=="5696"){
					    capa.innerHTML="GESTION DE PYME ";
					}else if(opcionSeleccionada=="5697"){
					    capa.innerHTML="INICIACION A LA TECNOLOGIA COMPUTACIONAL ";
					}else if(opcionSeleccionada=="5698"){
					    capa.innerHTML="LABORATORIO QUIMICO GENERAL ";
					}else if(opcionSeleccionada=="5699"){
					    capa.innerHTML="LEGISLACION LABORAL Y PREVENCION DE RIESGOS ";
					}else if(opcionSeleccionada=="5700"){
					    capa.innerHTML="ORIGENES E HISTORIA DE LA QUIMICA INT. A. TERMODINAMICA ";
					}else if(opcionSeleccionada=="5701"){
					    capa.innerHTML="PREPARACION DE CONSERVERIA, FRUTAS Y VERDURAS ";
					}else if(opcionSeleccionada=="5702"){
					    capa.innerHTML="PREVENCION DE RIESGOS Y GESTION DE EMPRESA ";
					}else if(opcionSeleccionada=="5703"){
					    capa.innerHTML="PSICOLOGIA BASICA ";
					}else if(opcionSeleccionada=="5704"){
					    capa.innerHTML="QUIMICA ANALITICA CUANTITATIVA ";
					}else if(opcionSeleccionada=="5705"){
					    capa.innerHTML="SICOLOGIA LABORAL Y ETICA ";
					}else if(opcionSeleccionada=="5706"){
					    capa.innerHTML="TALLER : APRENDO A DISTRUTAR MI PAIS ";
					}else if(opcionSeleccionada=="5707"){
					    capa.innerHTML="TALLER : USO DE LABORATORIO ";
					}else if(opcionSeleccionada=="5708"){
					    capa.innerHTML="TALLER ARTISTICO ";
					}else if(opcionSeleccionada=="5709"){
					    capa.innerHTML="TALLER DE APLICACIONES INFORMATICAS ";
					}else if(opcionSeleccionada=="5710"){
					    capa.innerHTML="TALLER DE CONCEPTOS BASICOS MATEMATICOS ";
					}else if(opcionSeleccionada=="5711"){
					    capa.innerHTML="TALLER DE DINAMICAS DE AUTOAPRENDIZAJE ";
					}else if(opcionSeleccionada=="5712"){
					    capa.innerHTML="TALLER DE EXPRESION PLASTICA ";
					}else if(opcionSeleccionada=="5713"){
					    capa.innerHTML="TALLER DE INGLES TECNICO ";
					}else if(opcionSeleccionada=="5714"){
					    capa.innerHTML="TALLER DE INICIACION A LOS DEPORTES ";
					}else if(opcionSeleccionada=="5717"){
					    capa.innerHTML="TECNICAS DE MODULACION Y DICCION ";
					}else if(opcionSeleccionada=="5718"){
					    capa.innerHTML="TECNOLOGIA COMUNICACIONAL ";
					}else if(opcionSeleccionada=="5719"){
					    capa.innerHTML="TECNOLOGIA DE LOS ALIMENTOS Y ANALISIS INSTRUMENTAL ";
					}else if(opcionSeleccionada=="5720"){
					    capa.innerHTML="URBANIDAD Y PROTOCOLO ";
					}else if(opcionSeleccionada=="5721"){
					    capa.innerHTML="VIVAMOS LA CREATIVIDAD ";
					}else if(opcionSeleccionada=="5722"){
					    capa.innerHTML="FUNDAMENTOS DE ADMINISTRACION Y LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="5723"){
					    capa.innerHTML="TALLER DE EXPRESION TEATRAL ";
					}else if(opcionSeleccionada=="5724"){
					    capa.innerHTML="ACERCAMIENTO AL ENTORNO SOCIAL ";
					}else if(opcionSeleccionada=="5725"){
					    capa.innerHTML="ALGEBRA I ";
					}else if(opcionSeleccionada=="5656"){
					    capa.innerHTML="LENGUAJE Y RELACIONES HUMANAS II ";
					}else if(opcionSeleccionada=="5657"){
					    capa.innerHTML="LITERATURA E IDENTIDAD LATINOAMERICANA ";
					}else if(opcionSeleccionada=="5658"){
					    capa.innerHTML="MATEMATICA INSTRUMENTAL ";
					}else if(opcionSeleccionada=="5659"){
					    capa.innerHTML="PSICOLOGIA SOCIAL I ";
					}else if(opcionSeleccionada=="5660"){
					    capa.innerHTML="PSICOLOGIA SOCIAL II ";
					}else if(opcionSeleccionada=="5661"){
					    capa.innerHTML="ARTES VISUALES: ESPACIO Y CONSTRUCCIONES ";
					}else if(opcionSeleccionada=="5662"){
					    capa.innerHTML="BIOLOGIA MOLECULAR ";
					}else if(opcionSeleccionada=="5663"){
					    capa.innerHTML="DISEÑO PUBLICITARIO Y DE INTERIORES ";
					}else if(opcionSeleccionada=="5664"){
					    capa.innerHTML="ELEMENTOS DE ALGEBRA SUPERIOR ";
					}else if(opcionSeleccionada=="5665"){
					    capa.innerHTML="ELEMENTOS DE GEOMETRIA ANALITICA ";
					}else if(opcionSeleccionada=="5666"){
					    capa.innerHTML="HISTORIA DEL ARTE MODERNO ";
					}else if(opcionSeleccionada=="5667"){
					    capa.innerHTML="HISTORIA DEL ARTE Y ARQUITECTURA MODERNA ";
					}else if(opcionSeleccionada=="5668"){
					    capa.innerHTML="LA ECONOMIA AL SERVICIO DEL DESARROLLO HUMANO ";
					}else if(opcionSeleccionada=="5669"){
					    capa.innerHTML="LA GEOGRAFIA Y EL ESTUDIO DEL MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="5670"){
					    capa.innerHTML="LENGUA CASTELLANA Y COMUNICACION: REDACCION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="5671"){
					    capa.innerHTML="LINGÜISTICA Y SOCIEDAD ";
					}else if(opcionSeleccionada=="5672"){
					    capa.innerHTML="ADMINISTRACION DE REDES ";
					}else if(opcionSeleccionada=="5673"){
					    capa.innerHTML="AFINAMIENTO Y RECONSTRUCCION DE MOTORES ";
					}else if(opcionSeleccionada=="5674"){
					    capa.innerHTML="ARQUITECTURA DE COMPUTADORES ";
					}else if(opcionSeleccionada=="5675"){
					    capa.innerHTML="AUTOMATISMOS ";
					}else if(opcionSeleccionada=="5676"){
					    capa.innerHTML="COMUNICACION DE DATOS ";
					}else if(opcionSeleccionada=="5677"){
					    capa.innerHTML="CONECTIVIDAD DE REDES ";
					}else if(opcionSeleccionada=="5678"){
					    capa.innerHTML="FUNDAMENTOS DE COMPUTACION Y ELECTRONICA ";
					}else if(opcionSeleccionada=="5679"){
					    capa.innerHTML="HERRAMIENTAS Y AUTOMATIZACION DE OFICINAS ";
					}else if(opcionSeleccionada=="5680"){
					    capa.innerHTML="HERRAMIENTAS Y TECNICAS ";
					}else if(opcionSeleccionada=="5681"){
					    capa.innerHTML="INTERPRETACION DE MANUALES TECNICOS ";
					}else if(opcionSeleccionada=="5682"){
					    capa.innerHTML="LABORATORIO DE AUTOTRONICA ";
					}else if(opcionSeleccionada=="5683"){
					    capa.innerHTML="LABORATORIO DE INYECCION DIESEL ";
					}else if(opcionSeleccionada=="5684"){
					    capa.innerHTML="LABORATORIO DE INYECCION Y GASOLINA ";
					}else if(opcionSeleccionada=="5685"){
					    capa.innerHTML="MICROCONTROLADORES ";
					}else if(opcionSeleccionada=="5686"){
					    capa.innerHTML="REDES REMOTAS ";
					}else if(opcionSeleccionada=="5687"){
					    capa.innerHTML="SEGURIDAD Y MANTENCION INDUSTRIAL ";
					}else if(opcionSeleccionada=="5688"){
					    capa.innerHTML="SISTEMAS DE DIRECCION Y SUSPENSION ";
					}else if(opcionSeleccionada=="5689"){
					    capa.innerHTML="SISTEMAS OPERATIVOS DE REDES ";
					}else if(opcionSeleccionada=="5622"){
					    capa.innerHTML="CONOCER AL CLIENTE ";
					}else if(opcionSeleccionada=="5623"){
					    capa.innerHTML="CONTROL DE ACTIVO FIJO Y CIRCULANTE FINANCIERO ";
					}else if(opcionSeleccionada=="5624"){
					    capa.innerHTML="DESARROLLO DE LA CAPACIDAD EMPRENDEDORA ";
					}else if(opcionSeleccionada=="5625"){
					    capa.innerHTML="ELABORACION Y APLICACION DEL PLAN DE CUENTAS ";
					}else if(opcionSeleccionada=="5626"){
					    capa.innerHTML="EVALUAR LA VENTA ";
					}else if(opcionSeleccionada=="5627"){
					    capa.innerHTML="GESTION SECRETARIAL ";
					}else if(opcionSeleccionada=="5628"){
					    capa.innerHTML="MANEJO DE CORRESPONDENCIA ";
					}else if(opcionSeleccionada=="5629"){
					    capa.innerHTML="OPERACION DE NORMATIVAS TRIBUTARIAS, LABORALES Y SOCIALES ";
					}else if(opcionSeleccionada=="5630"){
					    capa.innerHTML="OPERACION TRIBUTARIA ";
					}else if(opcionSeleccionada=="5631"){
					    capa.innerHTML="OPERACIONES COMERCIALES ";
					}else if(opcionSeleccionada=="5632"){
					    capa.innerHTML="OPERACIONES CONTABLES ";
					}else if(opcionSeleccionada=="5633"){
					    capa.innerHTML="OPERAR SISTEMAS DE ARCHIVO ";
					}else if(opcionSeleccionada=="5634"){
					    capa.innerHTML="PREPARAR LA AGENDA DE VENTAS ";
					}else if(opcionSeleccionada=="5635"){
					    capa.innerHTML="REGISTRO Y DETERMINACION DE ESTADOS FINANCIEROS ";
					}else if(opcionSeleccionada=="5636"){
					    capa.innerHTML="TALLER CONTABLE ";
					}else if(opcionSeleccionada=="5637"){
					    capa.innerHTML="TALLER DE ADMINISTRACION DE PERSONAL ";
					}else if(opcionSeleccionada=="5638"){
					    capa.innerHTML="TRAMITACION DE DOCUMENTOS DE LA EMPRESA ";
					}else if(opcionSeleccionada=="5639"){
					    capa.innerHTML="ELABORACION DE DOCUMENTOS LABORALES ";
					}else if(opcionSeleccionada=="5640"){
					    capa.innerHTML="APLICACION DE HEURISTICA Y ESTRATEGIA EN LA SOLUCION DE PROBLEMAS ";
					}else if(opcionSeleccionada=="5641"){
					    capa.innerHTML="ELECTRICIDAD EN MODALIDAD DUAL ";
					}else if(opcionSeleccionada=="5642"){
					    capa.innerHTML="INTRODUCCION A LA ADMINISTRACION I ";
					}else if(opcionSeleccionada=="5643"){
					    capa.innerHTML="INTRODUCCION A LA ADMINISTRACION II ";
					}else if(opcionSeleccionada=="5644"){
					    capa.innerHTML="INTRODUCCION AL VESTUARIO Y TEJIDO ";
					}else if(opcionSeleccionada=="5645"){
					    capa.innerHTML="METODOLOGIA Y TECNICAS DE DISEÑO ";
					}else if(opcionSeleccionada=="5646"){
					    capa.innerHTML="DESARROLLO DEL PENSAMIENTO OCCIDENTAL ";
					}else if(opcionSeleccionada=="5647"){
					    capa.innerHTML="BIOETICA ";
					}else if(opcionSeleccionada=="5648"){
					    capa.innerHTML="EL DISCURSO Y EL MEDIO ";
					}else if(opcionSeleccionada=="5649"){
					    capa.innerHTML="EL TRABAJO Y EL ESPIRITU EMPRENDEDOR ";
					}else if(opcionSeleccionada=="5650"){
					    capa.innerHTML="EL TRABAJO Y EL ESPIRITU EMPRENDEDOR I ";
					}else if(opcionSeleccionada=="5651"){
					    capa.innerHTML="LA MATEMATICA Y LAS CIENCIAS I ";
					}else if(opcionSeleccionada=="5652"){
					    capa.innerHTML="LA MATEMATICA Y LAS CIENCIAS II ";
					}else if(opcionSeleccionada=="5653"){
					    capa.innerHTML="LA MECANICA CLASICA Y SUS LEYES ";
					}else if(opcionSeleccionada=="5654"){
					    capa.innerHTML="LA QUIMICA ORGANICA Y SUS DESARROLLO ";
					}else if(opcionSeleccionada=="5655"){
					    capa.innerHTML="LENGUAJE Y RELACIONES HUMANAS I ";
					}else if(opcionSeleccionada=="5587"){
					    capa.innerHTML="PRODUCTOS Y SUBPRODUCTOS VEGETALES Y ANIMALES ";
					}else if(opcionSeleccionada=="5588"){
					    capa.innerHTML="SANIDAD Y ALIMENTACION ANIMAL ";
					}else if(opcionSeleccionada=="5589"){
					    capa.innerHTML="TALLER VOCACIONAL AGRICOLA ";
					}else if(opcionSeleccionada=="5590"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA DE INSTRUMENTOS DE CUERDAS ";
					}else if(opcionSeleccionada=="5591"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA DE INSTRUMENTOS DE VIENTOS Y PERCUCION ";
					}else if(opcionSeleccionada=="5592"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN ARTES ESCENICAS ";
					}else if(opcionSeleccionada=="5593"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN ARTES VISUALES ";
					}else if(opcionSeleccionada=="5594"){
					    capa.innerHTML="GESTION, ELECTROTECNIA Y OLEONEUMATICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="5595"){
					    capa.innerHTML="MANTENIMIENTO AUTOMOTOR ";
					}else if(opcionSeleccionada=="5596"){
					    capa.innerHTML="MATEMATICAS FORMACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="5598"){
					    capa.innerHTML="LENGUA INGLESA ";
					}else if(opcionSeleccionada=="5599"){
					    capa.innerHTML="PATRIMONIO EDUCATIVO ";
					}else if(opcionSeleccionada=="5600"){
					    capa.innerHTML="ELECTROTECNIA Y PROGRAMACION DE LOS PROCESOS DE MECANIZADO ";
					}else if(opcionSeleccionada=="5601"){
					    capa.innerHTML="EQUIPOS Y AUTOMATIZACION INDUSTRIAL ";
					}else if(opcionSeleccionada=="5602"){
					    capa.innerHTML="MATERIALES Y PROYECTOS MECANICOS ";
					}else if(opcionSeleccionada=="5603"){
					    capa.innerHTML="MECANIZADO AVANZADO ";
					}else if(opcionSeleccionada=="5604"){
					    capa.innerHTML="MECANIZADO Y MANTENIMIENTO MECANICO ";
					}else if(opcionSeleccionada=="5605"){
					    capa.innerHTML="CARACTERISTICAS Y PROBLEMAS DEL CONOCER ";
					}else if(opcionSeleccionada=="5606"){
					    capa.innerHTML="CIENCIAS SOCIALES II ";
					}else if(opcionSeleccionada=="5607"){
					    capa.innerHTML="INGLES LITERARIO CULTURAL ";
					}else if(opcionSeleccionada=="5608"){
					    capa.innerHTML="LA TIERRA UN TODO COMPLEJO E INTERDEPENDIENTE ";
					}else if(opcionSeleccionada=="5609"){
					    capa.innerHTML="UNA MIRADA FISICA A NUESTRO CONOCER ";
					}else if(opcionSeleccionada=="5610"){
					    capa.innerHTML="VOCACIONAL: CIENTIFICO TECNOLOGICO Y CULTURAL LITERARIO ";
					}else if(opcionSeleccionada=="5611"){
					    capa.innerHTML="INTRODUCCION AL MUNDO INDUSTRIAL Y COMERCIAL ";
					}else if(opcionSeleccionada=="5612"){
					    capa.innerHTML="GESTION COMUNICACIONAL ";
					}else if(opcionSeleccionada=="5613"){
					    capa.innerHTML="GESTION DE LA SECRETARIA EN LA EMPRESA ";
					}else if(opcionSeleccionada=="5614"){
					    capa.innerHTML="GESTION DE PROVEEDORES Y CLIENTES ";
					}else if(opcionSeleccionada=="5615"){
					    capa.innerHTML="LA SECRETARIA EN LA PEQUEÑA EMPRESA ";
					}else if(opcionSeleccionada=="5616"){
					    capa.innerHTML="ADMINISTRACION DE LA COMUNICACION ";
					}else if(opcionSeleccionada=="5617"){
					    capa.innerHTML="ANALIZAR EL MERCADO ";
					}else if(opcionSeleccionada=="5618"){
					    capa.innerHTML="APLICACION DE UN PROGRAMA COMPUTACIONAL CONTABLE ";
					}else if(opcionSeleccionada=="5619"){
					    capa.innerHTML="APLICAR ESTRATEGIAS DE VENTAS ";
					}else if(opcionSeleccionada=="5620"){
					    capa.innerHTML="APLICAR PROCEDIMIENTOS DE VENTAS ";
					}else if(opcionSeleccionada=="5621"){
					    capa.innerHTML="CALCULO Y CONFECCION DE DECLARACION DE RENTA ANUAL ";
					}else if(opcionSeleccionada=="5553"){
					    capa.innerHTML="INTUICION GEOMETRICA ";
					}else if(opcionSeleccionada=="5554"){
					    capa.innerHTML="PRACTICA DEL IDIOMA INGLES ";
					}else if(opcionSeleccionada=="5555"){
					    capa.innerHTML="PROCESO ARITMETICO ";
					}else if(opcionSeleccionada=="5556"){
					    capa.innerHTML="TECNOLOGIA SOCIAL ";
					}else if(opcionSeleccionada=="5557"){
					    capa.innerHTML="INTEGRACION SOCIAL ";
					}else if(opcionSeleccionada=="5558"){
					    capa.innerHTML="FORMACION VALORICA ";
					}else if(opcionSeleccionada=="5559"){
					    capa.innerHTML="ALMACENAMIENTO DE CARGA EN ZONA DE DEPOSITOS, CONSOLIDACION Y DESCONSOLIDACION DE CONTENEDORES Y PRIMEROS AUXILIOS ";
					}else if(opcionSeleccionada=="5560"){
					    capa.innerHTML="AUTOMATIZACION, MANTENIMIENTO DE SOBREALIMENTADORES DE MOTORES ";
					}else if(opcionSeleccionada=="5561"){
					    capa.innerHTML="CIRCUITOS DE ELECTRONICOS BASICOS Y MANTENIMIENTO DE LOS SISTEMAS DE CARGA Y ARRANQUE DE VEHICULOS CIRCUITOS ELECTRICOS AUXILIARES DEL 	VEHICULO ";
					}else if(opcionSeleccionada=="5563"){
					    capa.innerHTML="CLASIFICACION DE PUERTOS Y TERMINALES DE INTERCAMBIO MODAL Y DOCUMENTOS PORTUARIOS ";
					}else if(opcionSeleccionada=="5564"){
					    capa.innerHTML="ESTIBA Y DESESTIBA DE NAVES MERCANTES, MOVILIZACION DE CARGA EN PUERTOS Y TERMINALES DE INTERCAMBIO MODAL ";
					}else if(opcionSeleccionada=="5565"){
					    capa.innerHTML="MANTENIMIENTO DE LOS SISTEMAS DE DIRECCION Y SUSPENSION, TRANSMISION Y FRENOS ";
					}else if(opcionSeleccionada=="5566"){
					    capa.innerHTML="MANTENIMIENTO DE MOTORES Y MANTENIMIENTO DE SISTEMAS AUXILIARES ";
					}else if(opcionSeleccionada=="5567"){
					    capa.innerHTML="MANTENIMIENTO Y MONTAJE DE SISTEMAS DE SEGURIDAD Y COMPARTIBILIDAD, TECNICAS DE MECANIZADO PARA EL MANTENIMIENTO DE VEHICULOS ";
					}else if(opcionSeleccionada=="5568"){
					    capa.innerHTML="ORGANIZACION Y SERVICIOS EN EL SISTEMA PORTUARIO, GESTION DE PEQUEÑA EMPRESA COMERCIO EXTERIOR ";
					}else if(opcionSeleccionada=="5569"){
					    capa.innerHTML="TERMINAL DE CONTENEDORES SEGURIDAD Y PREVENCION DE RIESGOS EN FAENAS PORTUARIAS ";
					}else if(opcionSeleccionada=="5570"){
					    capa.innerHTML="TIPOS DE NAVE MERCANTE Y TIPOS DE CARGA, MARCAJE Y EMBALAJES ";
					}else if(opcionSeleccionada=="5571"){
					    capa.innerHTML="TALLER DE FORMACION VALORICA ";
					}else if(opcionSeleccionada=="5572"){
					    capa.innerHTML="GESTION FORMATIVA DEL VENDEDOR Y SERVICIO DE ATENCION AL CLIENTE ";
					}else if(opcionSeleccionada=="5573"){
					    capa.innerHTML="GESTION DE COMPRAVENTA Y TECNICAS DE VENTAS ";
					}else if(opcionSeleccionada=="5574"){
					    capa.innerHTML="GESTION EN APROVISIONAMIENTO Y VERIFICACION DE EXISTENCIAS ";
					}else if(opcionSeleccionada=="5575"){
					    capa.innerHTML="GESTION DE LA PEQUENA EMPRESA Y COMERCIO EXTERIOR ";
					}else if(opcionSeleccionada=="5576"){
					    capa.innerHTML="MARKETING, INVESTIGACION DE MERCADO Y PUBLICIDAD ";
					}else if(opcionSeleccionada=="5577"){
					    capa.innerHTML="BIBLIA ";
					}else if(opcionSeleccionada=="5578"){
					    capa.innerHTML="BIBLIA, COSTUMBRES JUDAICAS, LEYES Y COSTUMBRES JUDAICAS ";
					}else if(opcionSeleccionada=="5579"){
					    capa.innerHTML="BIBLIA-LOS LIBROS DE MOISES ";
					}else if(opcionSeleccionada=="5580"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DE LA SOCIEDAD JUDIA ";
					}else if(opcionSeleccionada=="5581"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DEL MEDIO NATURAL, SOCIAL Y CULTURAL ";
					}else if(opcionSeleccionada=="5582"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION HEBREO ";
					}else if(opcionSeleccionada=="5583"){
					    capa.innerHTML="LEYES Y RELIGION ";
					}else if(opcionSeleccionada=="5584"){
					    capa.innerHTML="COSECHA Y POSTCOSECHA DE LA PRADERA VEGETAL ";
					}else if(opcionSeleccionada=="5585"){
					    capa.innerHTML="MAQUINARIA Y HERRAMIENTAS DE USO AGRICOLA ";
					}else if(opcionSeleccionada=="5586"){
					    capa.innerHTML="PRODUCCION DE FRUTALES ";
					}else if(opcionSeleccionada=="5518"){
					    capa.innerHTML="TRANSFERENCIA TECNOLOGICA ";
					}else if(opcionSeleccionada=="5519"){
					    capa.innerHTML="PREPARACION Y MANTENCION DEL EQUIPAMIENTO, INSTRUMENTAL, STOCK DE MATERIALES REQUERIDOS PARA LA ATENCION ";
					}else if(opcionSeleccionada=="5520"){
					    capa.innerHTML="TECNICO EN ATENCION DE ENFERMERIA ";
					}else if(opcionSeleccionada=="5521"){
					    capa.innerHTML="ANALISIS DE APRENDIZAJE EN LA EMPRESA ";
					}else if(opcionSeleccionada=="5523"){
					    capa.innerHTML="INTERPRETACION DE PLANOS EN CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="5524"){
					    capa.innerHTML="INTERPRETACIONES DE PLANOS EN OBRAS VIALES Y DE INFRAESTRUCTURA	ASISTIDA POR COMPUTACION ";
					}else if(opcionSeleccionada=="5525"){
					    capa.innerHTML="TECNOLOGIA EN OBRAS VIALES ";
					}else if(opcionSeleccionada=="5526"){
					    capa.innerHTML="SISTEMA DE PRODUCCION Y SANIDAD ANIMAL ";
					}else if(opcionSeleccionada=="5527"){
					    capa.innerHTML="SISTEMA DE PRODUCCION VEGETAL ";
					}else if(opcionSeleccionada=="5528"){
					    capa.innerHTML="TEJIDO ";
					}else if(opcionSeleccionada=="5529"){
					    capa.innerHTML="AUTOMATIZACION CONTABLE ";
					}else if(opcionSeleccionada=="5530"){
					    capa.innerHTML="CONVIVENCIA CIVIL ";
					}else if(opcionSeleccionada=="5531"){
					    capa.innerHTML="ECONOMIA Y GLOBALIZACION ";
					}else if(opcionSeleccionada=="5532"){
					    capa.innerHTML="EL ESPAÑOL COMO INSTRUMENTO DE COMUNICACION ";
					}else if(opcionSeleccionada=="5533"){
					    capa.innerHTML="INTRODUCCION AL CALCULO ";
					}else if(opcionSeleccionada=="5534"){
					    capa.innerHTML="INTRODUCCION AL LENGUAJE GRAFICO ";
					}else if(opcionSeleccionada=="5535"){
					    capa.innerHTML="MATEMATICAS COMERCIALES ";
					}else if(opcionSeleccionada=="5536"){
					    capa.innerHTML="PLANIMETRIA ";
					}else if(opcionSeleccionada=="5537"){
					    capa.innerHTML="ELECTRICIDAD Y EQUIPOS DE REFRIGERACION ";
					}else if(opcionSeleccionada=="5538"){
					    capa.innerHTML="LABORATORIO VOCACIONAL INTEGRADO ";
					}else if(opcionSeleccionada=="5539"){
					    capa.innerHTML="LEGISLACION ADUANERA ";
					}else if(opcionSeleccionada=="5540"){
					    capa.innerHTML="TALADRO - TORNO - SOLDADURA ";
					}else if(opcionSeleccionada=="5541"){
					    capa.innerHTML="DE LA MAQUINA DE ESCRIBIR AL ORDENADOR I ";
					}else if(opcionSeleccionada=="5542"){
					    capa.innerHTML="DE LA MAQUINA DE ESCRIBIR AL ORDENADOR II ";
					}else if(opcionSeleccionada=="5543"){
					    capa.innerHTML="INTRODUCCION A LAS ORGANIZACIONES PRODUCTIVAS ";
					}else if(opcionSeleccionada=="5544"){
					    capa.innerHTML="NOCIONES DE DERECHO CIVIL Y PENAL ";
					}else if(opcionSeleccionada=="5545"){
					    capa.innerHTML="NOCIONES DE LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="5546"){
					    capa.innerHTML="PRINCIPIOS DE FORMACION CIUDADANA ";
					}else if(opcionSeleccionada=="5547"){
					    capa.innerHTML="INGLES CIENTIFICO TECNOLOGICO, VOCACIONAL O LITERARIO CULTURAL";
					}else if(opcionSeleccionada=="5548"){
					    capa.innerHTML="DESARROLLO DEL SER ";
					}else if(opcionSeleccionada=="5549"){
					    capa.innerHTML="ALFABETIZANDO LA MODERNIDAD ";
					}else if(opcionSeleccionada=="5550"){
					    capa.innerHTML="LABORATORIO DE ORIENTACION PROFESIONAL ";
					}else if(opcionSeleccionada=="5551"){
					    capa.innerHTML="EXPRESION ARTISTICA MANUAL ";
					}else if(opcionSeleccionada=="5552"){
					    capa.innerHTML="INICIACION A LA MUSICA ";
					}else if(opcionSeleccionada=="5484"){
					    capa.innerHTML="TECNOLOGIA DE LA LECHE Y ELABORACION DE PRODUCTOS LACTEOS ";
					}else if(opcionSeleccionada=="5485"){
					    capa.innerHTML="TERMODINAMICA, CATALISIS, FUNDAMENTO DE LA ESPECTROCOPIA ";
					}else if(opcionSeleccionada=="5486"){
					    capa.innerHTML="PREPARACION DE SANDWICH Y PRODUCTOS PARA COCTEL, ELABORACION DE ENTRADAS FRIAS Y CALIENTES Y PLATOS PRINCIPALES PASTELERIA Y REPOSTERIA ";
					}else if(opcionSeleccionada=="5487"){
					    capa.innerHTML="ORIENTACION ESPECIALIDAD 1 ";
					}else if(opcionSeleccionada=="5488"){
					    capa.innerHTML="ORIENTACION ESPECIALIDAD 2 ";
					}else if(opcionSeleccionada=="5489"){
					    capa.innerHTML="BODEGA, RECEPCION, ALMACENAJE DE ALIMENTOS Y PLANIFICACION DE LA PRODUCCION Y CONTROL DE COSTOS ";
					}else if(opcionSeleccionada=="5490"){
					    capa.innerHTML="PREPARACION DE ALIMENTOS PARA MENU, CARTA BUFFET PLATOS TIPICOS NACIONALES E INTERNACIONALES Y SERVICIO DE COMEDORES ";
					}else if(opcionSeleccionada=="5491"){
					    capa.innerHTML="ORIENTACION VOCACIONAL ADMINISTRACION Y COMERCIO ";
					}else if(opcionSeleccionada=="5492"){
					    capa.innerHTML="ORIENTACION VOCACIONAL AGROPECUARIA ";
					}else if(opcionSeleccionada=="5493"){
					    capa.innerHTML="MANEJO Y PREPARACION DE MATERIAL Y EQUIPO REQUERIDO PARA LA ATENCION DE PACIENTES,FAMILIA Y COMUNIDAD\" ";
					}else if(opcionSeleccionada=="5494"){
					    capa.innerHTML="TALLER DE EXPRESION PLASTICA INSPIRADO EN LA ALFARERIA DIAGUITA ";
					}else if(opcionSeleccionada=="5495"){
					    capa.innerHTML="VISION SISTEMATICA DE LA ORGANIZACION, UNA HERRAMIENTA BASICA DE GESTION ";
					}else if(opcionSeleccionada=="5496"){
					    capa.innerHTML="DISCIPLINAS INSTRUMENTALES ";
					}else if(opcionSeleccionada=="5497"){
					    capa.innerHTML="FLAUTA DULCE ";
					}else if(opcionSeleccionada=="5498"){
					    capa.innerHTML="LECTURA Y TEORIA MUSICAL ";
					}else if(opcionSeleccionada=="5499"){
					    capa.innerHTML="PRACTICA INSTRUMENTAL ";
					}else if(opcionSeleccionada=="5500"){
					    capa.innerHTML="COMUNICACION ORGANIZACIONAL Y SERVICIO DE ATENCION AL CLIENTE ";
					}else if(opcionSeleccionada=="5501"){
					    capa.innerHTML="CONTABILIDAD BASICA, GESTION COMPRAVENTA ";
					}else if(opcionSeleccionada=="5502"){
					    capa.innerHTML="INSTALACIONES, MONTAJES Y CONSTRUCCIONES ELECTRICAS ";
					}else if(opcionSeleccionada=="5503"){
					    capa.innerHTML="MANTENIMIENTO Y OPERACION DE MAQUINAS Y EQUIPOS ELECTRICOS Y DISEÑO DE SISTEMAS DE CONTROL ";
					}else if(opcionSeleccionada=="5504"){
					    capa.innerHTML="RELIGION - DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="5505"){
					    capa.innerHTML="AMERICA LATINA Y LAS GRANDES TRANSFORMACIONES EN EL SIGLO XX ";
					}else if(opcionSeleccionada=="5506"){
					    capa.innerHTML="EVOLUCION ECOLOGIA Y MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="5507"){
					    capa.innerHTML="TRIGONOMETRIA Y FUNCIONES ";
					}else if(opcionSeleccionada=="5508"){
					    capa.innerHTML="QUIMICA ORGANICA E INORGANICA ";
					}else if(opcionSeleccionada=="5509"){
					    capa.innerHTML="MUEBLERIA Y VESTUARIO INFANTIL ";
					}else if(opcionSeleccionada=="5510"){
					    capa.innerHTML="INGLES (CIENTIFICO-TECNOLOGICO) ";
					}else if(opcionSeleccionada=="5511"){
					    capa.innerHTML="GESTION COMPRA/VENTA ";
					}else if(opcionSeleccionada=="5512"){
					    capa.innerHTML="DISEÑO, OPERACION Y ANALISIS DE SISTEMAS ELECTRICOS Y ELECTRONICOS ";
					}else if(opcionSeleccionada=="5513"){
					    capa.innerHTML="MANTENIMIENTO Y OPERACION DE MAQUINAS Y REDES ELECTRICAS ";
					}else if(opcionSeleccionada=="5514"){
					    capa.innerHTML="MEDICION Y ANALISIS DE REDES E INSTALACIONES ELECTRICAS ";
					}else if(opcionSeleccionada=="5515"){
					    capa.innerHTML="OPERACION Y PROGRAMACION DE SISTEMAS DE CONTROL CON PLC ";
					}else if(opcionSeleccionada=="5516"){
					    capa.innerHTML="PROYECTO MONTAJE Y CONSTRUCCIONES ELECTRICAS EN BAJA TENSION ";
					}else if(opcionSeleccionada=="5517"){
					    capa.innerHTML="LABORATORIO VOCACIONAL ";
					}else if(opcionSeleccionada=="5450"){
					    capa.innerHTML="SISTEMAS DE MAQUINARIA NAVAL ";
					}else if(opcionSeleccionada=="5451"){
					    capa.innerHTML="APLICACION DE LA MATEMATICA A TRAVES DEL COMPUTADOR I ";
					}else if(opcionSeleccionada=="5452"){
					    capa.innerHTML="APLICACION DE LA MATEMATICA A TRAVES DEL COMPUTADOR II ";
					}else if(opcionSeleccionada=="5453"){
					    capa.innerHTML="HECHOS HISTORICOS DEL SIGLO XX REFLEJADOS EN LA LITERATURA ";
					}else if(opcionSeleccionada=="5454"){
					    capa.innerHTML="NOCIONES BASICAS DE DERECHO CONSTITUCIONAL PENAL CIVIL Y LABORAL ";
					}else if(opcionSeleccionada=="5455"){
					    capa.innerHTML="CULTIVOS TRADICIONALES ";
					}else if(opcionSeleccionada=="5456"){
					    capa.innerHTML="FRUTALES CADUCOS Y PERENNES ";
					}else if(opcionSeleccionada=="5457"){
					    capa.innerHTML="GESTION DE PEQUEÑAS EMPRESA ";
					}else if(opcionSeleccionada=="5458"){
					    capa.innerHTML="ORIENTACION AL MUNDO DEL TRABAJO ";
					}else if(opcionSeleccionada=="5459"){
					    capa.innerHTML="PREPARACION Y EVALUACION DE PROYECTOS ";
					}else if(opcionSeleccionada=="5460"){
					    capa.innerHTML="SISTEMAS HIDRICOS ";
					}else if(opcionSeleccionada=="5461"){
					    capa.innerHTML="TALLER DE OFICINAS ";
					}else if(opcionSeleccionada=="5462"){
					    capa.innerHTML="TALLER DE ORIENTACION AL MUNDO DE TRABAJO ";
					}else if(opcionSeleccionada=="5463"){
					    capa.innerHTML="TALLERES VOCACIONALES ";
					}else if(opcionSeleccionada=="5464"){
					    capa.innerHTML="RECONOCIENDO EL MUNDO ANIMAL DEL ENTORNO AGRICOLA2 ";
					}else if(opcionSeleccionada=="5465"){
					    capa.innerHTML="CULTURAL LITERARIO ";
					}else if(opcionSeleccionada=="5466"){
					    capa.innerHTML="MODULO: PREPARADO Y CONFECCION DE VESTUARIO INFANTIL ";
					}else if(opcionSeleccionada=="5467"){
					    capa.innerHTML="VESTUARIO Y CONFECCION TEXTIL ";
					}else if(opcionSeleccionada=="5468"){
					    capa.innerHTML="AGROECOLOGIA, PREPARACION Y EVALUACION DE PROYECTOS ";
					}else if(opcionSeleccionada=="5469"){
					    capa.innerHTML="CULTIVOS FORZADOS/FRUTALES DE HOJA PERENNE ";
					}else if(opcionSeleccionada=="5470"){
					    capa.innerHTML="PROPAGACION VEGETAL/MAQUINARIA E IMPLEMENTOS AGRICOLAS ";
					}else if(opcionSeleccionada=="5471"){
					    capa.innerHTML="ALGEBRA I Y GEOMETRIA ANALITICA ";
					}else if(opcionSeleccionada=="5472"){
					    capa.innerHTML="ALGEBRA II Y GEOMETRIA EUCLIDIANA ";
					}else if(opcionSeleccionada=="5473"){
					    capa.innerHTML="APLICACIONES DE LA LENGUA CASTELLANA ";
					}else if(opcionSeleccionada=="5474"){
					    capa.innerHTML="FISIOANATOMIA ";
					}else if(opcionSeleccionada=="5475"){
					    capa.innerHTML="LITERATURA HISPANOAMERICANA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="5476"){
					    capa.innerHTML="QUIMICA ORGANICA APLICADA A LAS MOLECULAS BIOLOGICAS ";
					}else if(opcionSeleccionada=="5477"){
					    capa.innerHTML="ADMINISTRACION DE UNA PEQUEÑA EMPRESA O TALLER ";
					}else if(opcionSeleccionada=="5478"){
					    capa.innerHTML="BIOMATEMATICA ";
					}else if(opcionSeleccionada=="5479"){
					    capa.innerHTML="ESTRUCTURAS ";
					}else if(opcionSeleccionada=="5480"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION: FRANCES ";
					}else if(opcionSeleccionada=="5481"){
					    capa.innerHTML="METODOS Y TECNICAS DE INVESTIGACION SOCIAL ";
					}else if(opcionSeleccionada=="5482"){
					    capa.innerHTML="PROYECTOMATICA ";
					}else if(opcionSeleccionada=="5483"){
					    capa.innerHTML="TECNOLOGIA BASICA EN SILVICULTURA ";
					}else if(opcionSeleccionada=="5416"){
					    capa.innerHTML="SINOPSIS HISTORICA DE LA CULTURA OCCIDENTAL ";
					}else if(opcionSeleccionada=="5417"){
					    capa.innerHTML="POTENCIANDO EL DESARROLLO REPRESENTATIVO Y EXPRESIVO ";
					}else if(opcionSeleccionada=="5418"){
					    capa.innerHTML="TECNICAS DE AUDITORIA ";
					}else if(opcionSeleccionada=="5419"){
					    capa.innerHTML="TRIBUTARIA ";
					}else if(opcionSeleccionada=="5420"){
					    capa.innerHTML="INFORMATICA FUNCIONAL ";
					}else if(opcionSeleccionada=="5421"){
					    capa.innerHTML="CIENCIAS CONTEXTUALIZADAS ";
					}else if(opcionSeleccionada=="5422"){
					    capa.innerHTML="ESTUDIO DE MERCADO Y PEQUEÑA EMPRESA ";
					}else if(opcionSeleccionada=="5423"){
					    capa.innerHTML="RECURSOS HUMANOS ";
					}else if(opcionSeleccionada=="5424"){
					    capa.innerHTML="CICLO EXPLORATORIO ARTISTICO ";
					}else if(opcionSeleccionada=="5425"){
					    capa.innerHTML="NATURALEZA Y SOCIEDAD ";
					}else if(opcionSeleccionada=="5426"){
					    capa.innerHTML="LITERARIO CULTURAL (INGLES) ";
					}else if(opcionSeleccionada=="5427"){
					    capa.innerHTML="CALCULO INFINITESIMAL II ";
					}else if(opcionSeleccionada=="5428"){
					    capa.innerHTML="QUIMICA DEL CARBONO : QUIMICA DE LA VIDA ";
					}else if(opcionSeleccionada=="5429"){
					    capa.innerHTML="QUIMICA:ESTRUCTURA Y VIDA ";
					}else if(opcionSeleccionada=="5430"){
					    capa.innerHTML="SINOPSIS HISTORICA DE LA CULTURA ";
					}else if(opcionSeleccionada=="5431"){
					    capa.innerHTML="SINOPSIS HISTORICA DE LA CULTURA OCCIDENTAL II ";
					}else if(opcionSeleccionada=="5432"){
					    capa.innerHTML="ACUSTICA (FISICA) ";
					}else if(opcionSeleccionada=="5433"){
					    capa.innerHTML="ARMONIA Y COMPOSICION ";
					}else if(opcionSeleccionada=="5434"){
					    capa.innerHTML="INFORMATICA MUSICAL ";
					}else if(opcionSeleccionada=="5435"){
					    capa.innerHTML="INFORMATICA MUSICAL II ";
					}else if(opcionSeleccionada=="5436"){
					    capa.innerHTML="PIANO COMPLEMENTARIO I ";
					}else if(opcionSeleccionada=="5437"){
					    capa.innerHTML="PIANO COMPLEMENTARIO II ";
					}else if(opcionSeleccionada=="5438"){
					    capa.innerHTML="TEORIA Y SOLFEO AVANZADO ";
					}else if(opcionSeleccionada=="5439"){
					    capa.innerHTML="TALLER DE CELULA Y GENOMA Y ORGANISMO ";
					}else if(opcionSeleccionada=="5440"){
					    capa.innerHTML="TALLER: LA ESTADISTICA Y MI ENTORNO ";
					}else if(opcionSeleccionada=="5441"){
					    capa.innerHTML="ATENCION DE ENFERMERIA INTEGRAL A PACIENTES MEDICO QUIRURGICOS DE BAJA Y MEDIANA COMPLEJIDAD ";
					}else if(opcionSeleccionada=="5442"){
					    capa.innerHTML="CONSEJO DE CURSO Y REFLEXION DE ACTIVIDADES EN CAMPO CLINICO ";
					}else if(opcionSeleccionada=="5443"){
					    capa.innerHTML="TALLER DE ACTIVIDADES COMPLEMENTARIAS ";
					}else if(opcionSeleccionada=="5444"){
					    capa.innerHTML="TAREAS DE SERVICIO Y PLANTAS PIROMETALURGICAS Y DEL YODO ";
					}else if(opcionSeleccionada=="5445"){
					    capa.innerHTML="ADMINISTRACION Y GESTION EMPRESARIAL ";
					}else if(opcionSeleccionada=="5446"){
					    capa.innerHTML="CULTIVO DE INVERTEBRADOS ";
					}else if(opcionSeleccionada=="5447"){
					    capa.innerHTML="INTERPRETACION DE PLANOS Y MANTENCION DE NAVES ";
					}else if(opcionSeleccionada=="5448"){
					    capa.innerHTML="PROCESOS DE PRODUCTOS PESQUEROS Y ASEGURAMIENTO DE LA CALIDAD ";
					}else if(opcionSeleccionada=="5449"){
					    capa.innerHTML="SEGURIDAD, PREVENCION DE RIESGOS Y PRIMEROS AUXILIOS ";
					}else if(opcionSeleccionada=="5381"){
					    capa.innerHTML="TECNICA DE LOS ALIMENTOS ";
					}else if(opcionSeleccionada=="5382"){
					    capa.innerHTML="TECNICAS DE COMPUTACION PARA EL APRENDIZAJE DE LAS MATEMATICAS ";
					}else if(opcionSeleccionada=="5383"){
					    capa.innerHTML="TECNICAS DE COMUNICACION Y LECTURA FUNCIONAL ";
					}else if(opcionSeleccionada=="5384"){
					    capa.innerHTML="TECNICAS FEMENINAS ";
					}else if(opcionSeleccionada=="5385"){
					    capa.innerHTML="TECNOLOGIA DE MANEJO DE CULTIVOS II ";
					}else if(opcionSeleccionada=="5386"){
					    capa.innerHTML="TECNOLOGIA DE MANEJO SANITARIO Y MEDIO AMBIENTE II ";
					}else if(opcionSeleccionada=="5387"){
					    capa.innerHTML="TECNOLOGIA EN MADERA ";
					}else if(opcionSeleccionada=="5388"){
					    capa.innerHTML="TECNOLOGIA FORESTAL ";
					}else if(opcionSeleccionada=="5389"){
					    capa.innerHTML="TECNOLOGIA Y PRACTICA DE TALLER ";
					}else if(opcionSeleccionada=="5390"){
					    capa.innerHTML="TEJIDO, CORTE Y CONFECCION ";
					}else if(opcionSeleccionada=="5391"){
					    capa.innerHTML="TEORIA DE LA COMUNICACION I ";
					}else if(opcionSeleccionada=="5392"){
					    capa.innerHTML="TEORIA DE LA COMUNICACION II ";
					}else if(opcionSeleccionada=="5393"){
					    capa.innerHTML="TRAMITE Y DOCUMENTACION LEGAL II ";
					}else if(opcionSeleccionada=="5394"){
					    capa.innerHTML="TRANSFERENCIA AL AULA ";
					}else if(opcionSeleccionada=="5395"){
					    capa.innerHTML="VISION ANTROPOLOGICA: UN ENCUENTRO CON EL HOMBRE ";
					}else if(opcionSeleccionada=="5396"){
					    capa.innerHTML="WORDSTAR ";
					}else if(opcionSeleccionada=="5397"){
					    capa.innerHTML="COMBINATORIO Y PROBABILIDAD ";
					}else if(opcionSeleccionada=="5398"){
					    capa.innerHTML="PRECALCULO I Y II ";
					}else if(opcionSeleccionada=="5399"){
					    capa.innerHTML="QUIMICA HUMANISTICO-CIENTIFICA ";
					}else if(opcionSeleccionada=="5400"){
					    capa.innerHTML="EDUCACION ARTISTICA DEPORTIVA ";
					}else if(opcionSeleccionada=="5401"){
					    capa.innerHTML="FOTOGRAFIA COMUNICACIONAL ";
					}else if(opcionSeleccionada=="5402"){
					    capa.innerHTML="ELECTIVO LENGUAJE E IDENTIDAD ";
					}else if(opcionSeleccionada=="5403"){
					    capa.innerHTML="PRODUCTOS DE LA MADERA ";
					}else if(opcionSeleccionada=="5404"){
					    capa.innerHTML="DIFERENCIADO ARGUMENTACION Y PROBLEMAS DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="5405"){
					    capa.innerHTML="DIFERENCIADO CELULA, GENOMA Y ORGANISMOS ";
					}else if(opcionSeleccionada=="5406"){
					    capa.innerHTML="DIFERENCIADO INTRODUCCION A LA TERMODINAMICA ";
					}else if(opcionSeleccionada=="5407"){
					    capa.innerHTML="DIFERENCIADO LA CIUDAD CONTEMPORANEA ";
					}else if(opcionSeleccionada=="5408"){
					    capa.innerHTML="DIFERENCIADO LENGUAJE Y SOCIEDAD ";
					}else if(opcionSeleccionada=="5409"){
					    capa.innerHTML="DIFERENCIADO LITERATURA E IDENTIDAD ";
					}else if(opcionSeleccionada=="5410"){
					    capa.innerHTML="DIFERENCIADO QUIMICA FORMACION DIFERENCIADA HUMANISTICO - CIENTIFICO IVº MEDIO ";
					}else if(opcionSeleccionada=="5412"){
					    capa.innerHTML="EL CONOCIMIENTO HUMANO ";
					}else if(opcionSeleccionada=="5413"){
					    capa.innerHTML="INTRODUCCION AL CALCULO INFINITESIMAL ";
					}else if(opcionSeleccionada=="5414"){
					    capa.innerHTML="MATEMATICA Y GEOMETRIA ";
					}else if(opcionSeleccionada=="5415"){
					    capa.innerHTML="MORFOSINTAXIS APLICADA ";
					}else if(opcionSeleccionada=="5347"){
					    capa.innerHTML="SALESIANIDAD ";
					}else if(opcionSeleccionada=="5348"){
					    capa.innerHTML="SALUD Y MANEJO DE LA HIGIENE EN EL PARVULO ";
					}else if(opcionSeleccionada=="5349"){
					    capa.innerHTML="SERVICIO DE BAR I Y II ";
					}else if(opcionSeleccionada=="5350"){
					    capa.innerHTML="SERVICIO DE COMEDOR I Y II ";
					}else if(opcionSeleccionada=="5351"){
					    capa.innerHTML="SERVICIOS AL CLIENTE I Y II ";
					}else if(opcionSeleccionada=="5352"){
					    capa.innerHTML="SISTEMA PRODUCCION DE LECHE Y CARNE BOVINA ";
					}else if(opcionSeleccionada=="5353"){
					    capa.innerHTML="SOCIEDAD CHILENA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="5354"){
					    capa.innerHTML="SOFTWARE A NIVEL USUARIO EN P.C. 2° NIVEL ";
					}else if(opcionSeleccionada=="5355"){
					    capa.innerHTML="TALLER \"FORMANDO LIDERES EMPRENDEDORES\" ";
					}else if(opcionSeleccionada=="5356"){
					    capa.innerHTML="TALLER CONSERVACION MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="5357"){
					    capa.innerHTML="TALLER DE ACONDICIONAMIENTO FISICO ";
					}else if(opcionSeleccionada=="5358"){
					    capa.innerHTML="TALLER DE ACUICULTURA ";
					}else if(opcionSeleccionada=="5359"){
					    capa.innerHTML="TALLER DE COCINA I Y II ";
					}else if(opcionSeleccionada=="5360"){
					    capa.innerHTML="TALLER DE CULTIVOS HORTICOLAS ";
					}else if(opcionSeleccionada=="5361"){
					    capa.innerHTML="TALLER DE DESARROLLO PERSONAL: DEPORTE Y CULTURA ";
					}else if(opcionSeleccionada=="5362"){
					    capa.innerHTML="TALLER DE DESARROLLO PROFESIONAL ";
					}else if(opcionSeleccionada=="5363"){
					    capa.innerHTML="TALLER DE EXPRESION ARTISTICA ";
					}else if(opcionSeleccionada=="5364"){
					    capa.innerHTML="TALLER DE GANADERIA ";
					}else if(opcionSeleccionada=="5365"){
					    capa.innerHTML="TALLER DE INFORMATICA APLICADA A LA ACUICULTURA ";
					}else if(opcionSeleccionada=="5366"){
					    capa.innerHTML="TALLER DE INTRODUCCION A LA MECANICA ";
					}else if(opcionSeleccionada=="5367"){
					    capa.innerHTML="TALLER DE INTRODUCCION A LA PRODUCCION VEGETAL ";
					}else if(opcionSeleccionada=="5368"){
					    capa.innerHTML="TALLER DE LENGUAJE Y COMUNICACION ";
					}else if(opcionSeleccionada=="5369"){
					    capa.innerHTML="TALLER DE MANTENCION DE MAQUINARIA Y EQUIPOS AGRICOLAS ";
					}else if(opcionSeleccionada=="5370"){
					    capa.innerHTML="TALLER DE MECANICA ";
					}else if(opcionSeleccionada=="5371"){
					    capa.innerHTML="TALLER DE MUSICA INFANTIL ";
					}else if(opcionSeleccionada=="5372"){
					    capa.innerHTML="TALLER DE ORIENTACION \"CONSTRUYENDO MI PROYECTO DE VIDA\" ";
					}else if(opcionSeleccionada=="5373"){
					    capa.innerHTML="TALLER DE ORIENTACION \"EXPLORANDO MI MUNDO JUVENIL\" ";
					}else if(opcionSeleccionada=="5374"){
					    capa.innerHTML="TALLER DE PRACTICA Y/O LABORATORIO ";
					}else if(opcionSeleccionada=="5375"){
					    capa.innerHTML="TALLER DE PROYECTOS II ";
					}else if(opcionSeleccionada=="5376"){
					    capa.innerHTML="TALLER DE RECREACION Y ESPECIALIZACION DEPORTIVA ";
					}else if(opcionSeleccionada=="5377"){
					    capa.innerHTML="TALLER DE TECNICAS SECRETARIALES ";
					}else if(opcionSeleccionada=="5378"){
					    capa.innerHTML="TALLER INGLES ";
					}else if(opcionSeleccionada=="5379"){
					    capa.innerHTML="TALLER VOCACIONAL EXPLORATORIO ";
					}else if(opcionSeleccionada=="5380"){
					    capa.innerHTML="TALLER, LABORATORIO Y TECNOLOGIA DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="5313"){
					    capa.innerHTML="MATEMATICA CONTEXTUALIZADA ";
					}else if(opcionSeleccionada=="5314"){
					    capa.innerHTML="MATERIAL Y TRABAJO EDUCATIVO CON PARVULOS EN MODALIDAD NO CONVENCIONAL ";
					}else if(opcionSeleccionada=="5315"){
					    capa.innerHTML="MECANICA DE MAQUINAS ";
					}else if(opcionSeleccionada=="5316"){
					    capa.innerHTML="MECANIZADO FORESTAL I ";
					}else if(opcionSeleccionada=="5317"){
					    capa.innerHTML="MOCROBIOLOGIA BASICA Y MANIPULACION DE ALIMENTOS ";
					}else if(opcionSeleccionada=="5318"){
					    capa.innerHTML="MODULOS OBLIGATORIOS MODIFICADOS ";
					}else if(opcionSeleccionada=="5319"){
					    capa.innerHTML="MOTORES Y EQUIPOS MARINOS ";
					}else if(opcionSeleccionada=="5320"){
					    capa.innerHTML="NOCIONES BASICAS DE INFORMATICA Y COMPUTACION II ";
					}else if(opcionSeleccionada=="5321"){
					    capa.innerHTML="NOCIONES COMERCIALES ";
					}else if(opcionSeleccionada=="5322"){
					    capa.innerHTML="NOCIONES DE DERECHO DEL TRABAJO Y SEGURIDAD SOCIAL ";
					}else if(opcionSeleccionada=="5323"){
					    capa.innerHTML="NOCIONES DEL CODIGO CIVIL ";
					}else if(opcionSeleccionada=="5324"){
					    capa.innerHTML="NORMAS Y PROCEDIMIENTOS CULINARIOS I Y II ";
					}else if(opcionSeleccionada=="5325"){
					    capa.innerHTML="OPERACION DE COMPUTADORES A NIVEL USUARIO ";
					}else if(opcionSeleccionada=="5326"){
					    capa.innerHTML="ORGANIZACION DE SECRETARIADO ";
					}else if(opcionSeleccionada=="5327"){
					    capa.innerHTML="PANADERIA, PASTELERIA Y REPOSTERIA I Y II ";
					}else if(opcionSeleccionada=="5328"){
					    capa.innerHTML="PESCA Y CULTIVOS ACUATICOS ";
					}else if(opcionSeleccionada=="5329"){
					    capa.innerHTML="PLANTA HARINA Y PRODUCTOS BALANCEADOS ";
					}else if(opcionSeleccionada=="5330"){
					    capa.innerHTML="PLATOS REGIONALES ";
					}else if(opcionSeleccionada=="5331"){
					    capa.innerHTML="PRACTICAS ADMINISTRATIVAS Y COMERCIALES ";
					}else if(opcionSeleccionada=="5332"){
					    capa.innerHTML="PRACTICAS AGROPECUARIAS ";
					}else if(opcionSeleccionada=="5333"){
					    capa.innerHTML="PRIMEROS AUXILIOS Y FISIOLOGIA ACUATICA ";
					}else if(opcionSeleccionada=="5334"){
					    capa.innerHTML="PRIMEROS AUXILIOS Y PREVENCION DE ACCIDENTES ";
					}else if(opcionSeleccionada=="5335"){
					    capa.innerHTML="PROCESAMIENTO DE PRODUCTOS NATURALES ";
					}else if(opcionSeleccionada=="5336"){
					    capa.innerHTML="PROCESOS INDUSTRIALES DE APLICACION DE TECNOLOGIA DE FRIO ";
					}else if(opcionSeleccionada=="5337"){
					    capa.innerHTML="PRODUCCION AGROPECUARIA, FRUTAL Y FORESTAL ";
					}else if(opcionSeleccionada=="5338"){
					    capa.innerHTML="PRODUCCION DE CARNE BOVINA ";
					}else if(opcionSeleccionada=="5339"){
					    capa.innerHTML="PRODUCCION REGIONAL: COMPUTACION ";
					}else if(opcionSeleccionada=="5340"){
					    capa.innerHTML="PRODUCCION REGIONAL: HORTOFRUTICULTURA ";
					}else if(opcionSeleccionada=="5341"){
					    capa.innerHTML="PRODUCCION REGIONAL: LECHERIA ";
					}else if(opcionSeleccionada=="5342"){
					    capa.innerHTML="PRODUCCION REGIONAL: SILVICULTURA ";
					}else if(opcionSeleccionada=="5343"){
					    capa.innerHTML="PROTECCION FORESTAL Y LEGISLACION FORESTAL ";
					}else if(opcionSeleccionada=="5344"){
					    capa.innerHTML="PSICOLOGIA EVOLUTIVA II ";
					}else if(opcionSeleccionada=="5345"){
					    capa.innerHTML="REDACCION ADMINISTRATIVA Y COMERCIAL II ";
					}else if(opcionSeleccionada=="5346"){
					    capa.innerHTML="RELACIONES PUBLICIDAD ";
					}else if(opcionSeleccionada=="5279"){
					    capa.innerHTML="HOMBRE CONTEMPORANEO ";
					}else if(opcionSeleccionada=="5280"){
					    capa.innerHTML="HUMANISMO CRISTIANO ";
					}else if(opcionSeleccionada=="5281"){
					    capa.innerHTML="INGLES CIENTIFICO TECNOLOGICO ";
					}else if(opcionSeleccionada=="5282"){
					    capa.innerHTML="INGLES EN LA INFORMATICA ";
					}else if(opcionSeleccionada=="5283"){
					    capa.innerHTML="INSTALACION Y MANTENCION DE REDES DE AGUA POTABLE Y ARTEFACTOS SANITARIOS ";
					}else if(opcionSeleccionada=="5284"){
					    capa.innerHTML="INTRODUCCION A LA MICROEMPRESA II ";
					}else if(opcionSeleccionada=="5285"){
					    capa.innerHTML="INTRODUCCION A LA TECNOLOGIA FORESTAL I ";
					}else if(opcionSeleccionada=="5286"){
					    capa.innerHTML="INTRODUCCION A LA TECNOLOGIA FORESTAL II ";
					}else if(opcionSeleccionada=="5287"){
					    capa.innerHTML="INTRODUCCION A LAS CIENCIAS FORESTALES ";
					}else if(opcionSeleccionada=="5288"){
					    capa.innerHTML="INTRODUCCION AL CAMPO PROFESIONAL ";
					}else if(opcionSeleccionada=="5289"){
					    capa.innerHTML="INTRODUCCION AL DISEÑO ";
					}else if(opcionSeleccionada=="5290"){
					    capa.innerHTML="INTRODUCCION AL PENSAMIENTO REFLEXIVO ";
					}else if(opcionSeleccionada=="5291"){
					    capa.innerHTML="INTRODUCCION DEL CALCULO ";
					}else if(opcionSeleccionada=="5292"){
					    capa.innerHTML="INTRODUCCION TALLERES TECNOLOGICOS ";
					}else if(opcionSeleccionada=="5293"){
					    capa.innerHTML="INVENTARIO Y MENSURA FORESTAL ";
					}else if(opcionSeleccionada=="5294"){
					    capa.innerHTML="LA COMUNICACION Y LAS RELACIONES HUMANAS EN LA MICROEMPRESA II ";
					}else if(opcionSeleccionada=="5295"){
					    capa.innerHTML="LA EVOLUCION ORGANICA ";
					}else if(opcionSeleccionada=="5296"){
					    capa.innerHTML="LABORATORIO DE COMPUTACION APLICADA II ";
					}else if(opcionSeleccionada=="5297"){
					    capa.innerHTML="LABORATORIO DE INGLES I ";
					}else if(opcionSeleccionada=="5298"){
					    capa.innerHTML="LEGISLACION LABORAL Y SOCIAL ";
					}else if(opcionSeleccionada=="5299"){
					    capa.innerHTML="LEGISLACION PARA LA VIDA DEL TRABAJO ";
					}else if(opcionSeleccionada=="5300"){
					    capa.innerHTML="LENGUA CASTELLANA Y COMUNICACION I ";
					}else if(opcionSeleccionada=="5301"){
					    capa.innerHTML="LENGUA FRANCES Y COMUNICACION ";
					}else if(opcionSeleccionada=="5302"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION: ESPAÑOL ";
					}else if(opcionSeleccionada=="5303"){
					    capa.innerHTML="LENGUAJE, EXPRESION Y COMUNICACION I ";
					}else if(opcionSeleccionada=="5304"){
					    capa.innerHTML="MANEJO DE BODEGA ";
					}else if(opcionSeleccionada=="5305"){
					    capa.innerHTML="MANTENCION SISTEMAS AUXILIARES DEL MOTOR ";
					}else if(opcionSeleccionada=="5306"){
					    capa.innerHTML="MANTENIMIENTO DE LOS SISTEMAS DE GOBIERNO Y PROPULSION ";
					}else if(opcionSeleccionada=="5307"){
					    capa.innerHTML="MANTENIMIENTO DE LOS SISTEMAS DE TRANSMISION Y FUERZA ";
					}else if(opcionSeleccionada=="5308"){
					    capa.innerHTML="MAQUINARIA AGRICOLA III ";
					}else if(opcionSeleccionada=="5309"){
					    capa.innerHTML="MAQUINARIA AGRICOLA Y TALLER ";
					}else if(opcionSeleccionada=="5310"){
					    capa.innerHTML="MAQUINAS HERRAMIENTAS ";
					}else if(opcionSeleccionada=="5311"){
					    capa.innerHTML="MAQUINAS PROPULSORAS Y AUXILIARES ";
					}else if(opcionSeleccionada=="5312"){
					    capa.innerHTML="MATEMATICA AVANZADA I ";
					}else if(opcionSeleccionada=="5245"){
					    capa.innerHTML="ELEMENTOS DE CONTABILIDAD ";
					}else if(opcionSeleccionada=="5246"){
					    capa.innerHTML="ELEMENTOS DE TOPOGRAFIA ";
					}else if(opcionSeleccionada=="5247"){
					    capa.innerHTML="EQUIPOS EN LA INDUSTRIA ALIMENTARIA ";
					}else if(opcionSeleccionada=="5248"){
					    capa.innerHTML="EQUIPOS TERMICOS ";
					}else if(opcionSeleccionada=="5249"){
					    capa.innerHTML="ERGONOMIA EN FAENAS FORESTALES ";
					}else if(opcionSeleccionada=="5250"){
					    capa.innerHTML="ESTRIBA Y DESESTRIBA DE NAVES MERCANTES Y ESPECIALES ";
					}else if(opcionSeleccionada=="5251"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DE LA NATURALEZA: CIENCIAS DE LA VIDA Y DE LA TIERRA ";
					}else if(opcionSeleccionada=="5252"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DE LA SOCIEDAD: HISTORIA Y GEOGRAFIA ";
					}else if(opcionSeleccionada=="5253"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DEL MEDIO NATURAL: BIOLOGIA ";
					}else if(opcionSeleccionada=="5254"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DEL MEDIO SOCIAL Y CULTURAL: HISTORIA Y GEOGRAFIA ";
					}else if(opcionSeleccionada=="5255"){
					    capa.innerHTML="EXPERIENCIA VOCACIONAL I Y II ";
					}else if(opcionSeleccionada=="5256"){
					    capa.innerHTML="EXPERIMENTACION AGRICOLA ";
					}else if(opcionSeleccionada=="5257"){
					    capa.innerHTML="EXPRESION ARTISTICA LOCAL ";
					}else if(opcionSeleccionada=="5258"){
					    capa.innerHTML="FACTORES DE LA PROPAGACION VEGETAL ";
					}else if(opcionSeleccionada=="5259"){
					    capa.innerHTML="FITOTECNIA GENERAL ";
					}else if(opcionSeleccionada=="5260"){
					    capa.innerHTML="FLORES ";
					}else if(opcionSeleccionada=="5261"){
					    capa.innerHTML="FORMULACION Y EVALUACION DE PROYECTOS AGROPECUARIOS ";
					}else if(opcionSeleccionada=="5262"){
					    capa.innerHTML="FRUTALES MAYORES Y MENORES ";
					}else if(opcionSeleccionada=="5263"){
					    capa.innerHTML="FUNDAMENTOS AGRICOLAS ";
					}else if(opcionSeleccionada=="5264"){
					    capa.innerHTML="FUNDAMENTOS DE COMPUTACION PARA EL CURRICULUM INTEGRADO ";
					}else if(opcionSeleccionada=="5265"){
					    capa.innerHTML="FUNDAMENTOS DE ELECTRICIDAD II ";
					}else if(opcionSeleccionada=="5266"){
					    capa.innerHTML="GASFITERIA ";
					}else if(opcionSeleccionada=="5267"){
					    capa.innerHTML="GEOGRAFIA DESCRIPTIVA DE CHILE ";
					}else if(opcionSeleccionada=="5268"){
					    capa.innerHTML="GEOGRAFIA ECONOMICA Y DESCRIPTIVA DE CHILE ";
					}else if(opcionSeleccionada=="5269"){
					    capa.innerHTML="GESTION DE CALIDAD ";
					}else if(opcionSeleccionada=="5270"){
					    capa.innerHTML="GESTION DE NEGOCIO Y COMERCIO EXTERIOR ";
					}else if(opcionSeleccionada=="5271"){
					    capa.innerHTML="GESTION DE SERVICIOS DE ALIMENTACION COLECTIVA I Y II ";
					}else if(opcionSeleccionada=="5272"){
					    capa.innerHTML="GESTION Y ADMINISTRACION EN ACUICULTURA ";
					/*22*/
					}else if(opcionSeleccionada=="5273"){
					    capa.innerHTML="GIMNASIA FORMATIVA, RECREATIVA Y BIOLOGICA ";
					}else if(opcionSeleccionada=="5274"){
					    capa.innerHTML="HABILITACION LABORAL ";
					}else if(opcionSeleccionada=="5275"){
					    capa.innerHTML="HABITACIONES Y TECNICAS DE LAVANDERIA Y LENCERIA ";
					}else if(opcionSeleccionada=="5276"){
					    capa.innerHTML="HISTORIA DE CHILE CONTEMPORANEA ";
					}else if(opcionSeleccionada=="5277"){
					    capa.innerHTML="HISTORIA DE LA CULTURA Y LA CIVILIZACION CRISTIANA ";
					}else if(opcionSeleccionada=="5278"){
					    capa.innerHTML="HISTORIA DE LAS CIVILIZACIONES II ";
					}else if(opcionSeleccionada=="5211"){
					    capa.innerHTML="ACONDICIONAMIENTO DE MATERIAS PRIMAS ";
					}else if(opcionSeleccionada=="5212"){
					    capa.innerHTML="ACTUALIDAD MUNDIAL ";
					}else if(opcionSeleccionada=="5213"){
					    capa.innerHTML="ADMINISTRACION CONTABILIDAD Y COSTOS ";
					}else if(opcionSeleccionada=="5214"){
					    capa.innerHTML="ADMINISTRACION E INFORMATICA A NIVEL DE USUARIOS ";
					}else if(opcionSeleccionada=="5215"){
					    capa.innerHTML="ADMINISTRACION Y GESTION RURAL ";
					}else if(opcionSeleccionada=="5216"){
					    capa.innerHTML="ALGEBRA Y TRIGONOMETRIA ";
					}else if(opcionSeleccionada=="5217"){
					    capa.innerHTML="ANALISIS DEL APRENDIZAJE EN LA EMPRESA ";
					}else if(opcionSeleccionada=="5218"){
					    capa.innerHTML="ANATOMIA Y FISIOLOGIA HUMANA ";
					}else if(opcionSeleccionada=="5219"){
					    capa.innerHTML="APLICACION DE INFORMATICA A NIVEL DE USUARIO ";
					}else if(opcionSeleccionada=="5220"){
					    capa.innerHTML="APLICACION DE LA MATEMATICA A TRAVES DEL COMPUTADOR ";
					}else if(opcionSeleccionada=="5221"){
					    capa.innerHTML="APROVECHAMIENTO DE LAS MADERAS ";
					}else if(opcionSeleccionada=="5222"){
					    capa.innerHTML="ARTES VISUALES, ARTES ESCENICAS: TEATRO Y DANZA ";
					}else if(opcionSeleccionada=="5223"){
					    capa.innerHTML="CALCULO BASICO ";
					}else if(opcionSeleccionada=="5224"){
					    capa.innerHTML="CIENCIA Y TECNOLOGIA ";
					}else if(opcionSeleccionada=="5225"){
					    capa.innerHTML="CIENCIAS NATURALES Y BIOLOGIA ";
					}else if(opcionSeleccionada=="5226"){
					    capa.innerHTML="CIENCIAS SILVOAGROPECUARIAS ";
					}else if(opcionSeleccionada=="5227"){
					    capa.innerHTML="CIENCIAS SOCIALES I ";
					}else if(opcionSeleccionada=="5228"){
					    capa.innerHTML="COCINA FRIA Y CALIENTE I Y II ";
					}else if(opcionSeleccionada=="5229"){
					    capa.innerHTML="COMPRENSION DEL MEDIO NATURAL:HOMBRE-CIENCIA-CULTURA ";
					}else if(opcionSeleccionada=="5230"){
					    capa.innerHTML="COMPUTACION BASICA MS-DOS Y UTILITARIOS ";
					}else if(opcionSeleccionada=="5231"){
					    capa.innerHTML="CONOCIENDO EL MUNDO DE LA COMPUTACION ";
					}else if(opcionSeleccionada=="5232"){
					    capa.innerHTML="CONSERVACION DE ALIMENTOS Y ELABORACION DE PRODUCTOS LACTEOS ";
					}else if(opcionSeleccionada=="5233"){
					    capa.innerHTML="CREACION CIENTIFICA ";
					}else if(opcionSeleccionada=="5234"){
					    capa.innerHTML="CULTIVO DE INVERTEBRADOS ACUATICOS ";
					}else if(opcionSeleccionada=="5235"){
					    capa.innerHTML="CULTIVOS ALTERNATIVOS ";
					}else if(opcionSeleccionada=="5236"){
					    capa.innerHTML="CULTURA Y TRADICION LITERARIA ";
					}else if(opcionSeleccionada=="5237"){
					    capa.innerHTML="DEPORTE BASICO ";
					}else if(opcionSeleccionada=="5238"){
					    capa.innerHTML="DITACOM (DIGITACION AL TACTO DE COMUNICACION) ";
					}else if(opcionSeleccionada=="5239"){
					    capa.innerHTML="ECONOMIA, ADMINISTRACION Y LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="5240"){
					    capa.innerHTML="EL MUNDO CONTEMPORANEO EN LA MITAD DEL SIGLO XX ";
					}else if(opcionSeleccionada=="5241"){
					    capa.innerHTML="ELABORACION DE BEBIDAS ANALCOHOLICAS ";
					}else if(opcionSeleccionada=="5242"){
					    capa.innerHTML="ELECTROMECANICA BASICA ";
					}else if(opcionSeleccionada=="5243"){
					    capa.innerHTML="ELEMENTOS BASICOS DE COMPUTACION ";
					}else if(opcionSeleccionada=="5244"){
					    capa.innerHTML="ELEMENTOS DE COMPUTACION Y MATEMATICA FINANCIERA II ";
					}else if(opcionSeleccionada=="5177"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN FOLCLOR ";
					}else if(opcionSeleccionada=="5178"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN GUITARRA CLASICA ";
					}else if(opcionSeleccionada=="5179"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN INSTRUMENTOS DE PERCUSION ";
					}else if(opcionSeleccionada=="5180"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN INSTRUMENTOS DE VIENTOS ";
					}else if(opcionSeleccionada=="5181"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN MODELADO Y CERAMICA ";
					}else if(opcionSeleccionada=="5182"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN PIANO ";
					}else if(opcionSeleccionada=="5183"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN TEATRO ";
					}else if(opcionSeleccionada=="5184"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN VIOLA ";
					}else if(opcionSeleccionada=="5185"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN VIOLIN ";
					}else if(opcionSeleccionada=="5186"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN VIOLONCELLO ";
					}else if(opcionSeleccionada=="5187"){
					    capa.innerHTML="ACTUALIDAD ECONOMICA ";
					}else if(opcionSeleccionada=="5188"){
					    capa.innerHTML="ACTUALIDAD INTERNACIONAL II ";
					}else if(opcionSeleccionada=="5189"){
					    capa.innerHTML="ACTUALIDAD POLITICA ";
					}else if(opcionSeleccionada=="5190"){
					    capa.innerHTML="GRANDES ACONTECIMIENTOS DE A. LATINA SIGLO XX ";
					}else if(opcionSeleccionada=="5191"){
					    capa.innerHTML="METODOLOGIA DE LA INVESTIGACION ";
					}else if(opcionSeleccionada=="5192"){
					    capa.innerHTML="MONOGRAFIA LITERARIA ";
					}else if(opcionSeleccionada=="5193"){
					    capa.innerHTML="ESTABLECIMIENTO Y MANEJO DE RECURSOS ";
					}else if(opcionSeleccionada=="5194"){
					    capa.innerHTML="INDUSTRIA DE LA MADERA ";
					}else if(opcionSeleccionada=="5195"){
					    capa.innerHTML="MANTENCION DE SIERRAS ";
					}else if(opcionSeleccionada=="5196"){
					    capa.innerHTML="MEJORAMIENTO GENETICO FORESTAL ";
					}else if(opcionSeleccionada=="5197"){
					    capa.innerHTML="MUEBLERIA ";
					}else if(opcionSeleccionada=="5198"){
					    capa.innerHTML="PRODUCTOS DE ASERRIO ";
					}else if(opcionSeleccionada=="5199"){
					    capa.innerHTML="PROTECCION DE LA MADERA ";
					}else if(opcionSeleccionada=="5200"){
					    capa.innerHTML="RECURSOS NATURALES BASICOS Y SU INTEGRACION ";
					}else if(opcionSeleccionada=="5201"){
					    capa.innerHTML="USO DE LA MADERA EN LA CONSTRUCCION DE MUEBLES ";
					}else if(opcionSeleccionada=="5202"){
					    capa.innerHTML="USO Y CONTROL DEL FUEGO ";
					}else if(opcionSeleccionada=="5203"){
					    capa.innerHTML="VIVEROS Y REPOBLACION FORESTAL ";
					}else if(opcionSeleccionada=="5204"){
					    capa.innerHTML="METODOS Y TECNICAS DE INVESTIGACION ";
					}else if(opcionSeleccionada=="5205"){
					    capa.innerHTML="PREVENCION DE RIESGOS Y MEDIO AMBIENTE EN MINERIA ";
					}else if(opcionSeleccionada=="5206"){
					    capa.innerHTML="INTRODUCCION AL MUNDO DE LA GEOLOGIA ";
					}else if(opcionSeleccionada=="5207"){
					    capa.innerHTML="VESTUARIO INFANTIL ";
					}else if(opcionSeleccionada=="5208"){
					    capa.innerHTML="PROCESOS INFINITOS ";
					}else if(opcionSeleccionada=="5209"){
					    capa.innerHTML="INGLES CIENTIFICO ";
					}else if(opcionSeleccionada=="5210"){
					    capa.innerHTML="INGLES LITERARIO ";
					}else if(opcionSeleccionada=="5143"){
					    capa.innerHTML="METODOS DE RIEGO ";
					}else if(opcionSeleccionada=="5144"){
					    capa.innerHTML="OVINOTECNIA ";
					}else if(opcionSeleccionada=="5145"){
					    capa.innerHTML="PORCINOTECNIA ";
					}else if(opcionSeleccionada=="5146"){
					    capa.innerHTML="PSICOLOGIA DEL TRABAJO ";
					}else if(opcionSeleccionada=="5147"){
					    capa.innerHTML="SOFTWARE UTILITARIO ";
					}else if(opcionSeleccionada=="5148"){
					    capa.innerHTML="TECNICAS DE ADMINISTRACION Y VENTAS ";
					}else if(opcionSeleccionada=="5149"){
					    capa.innerHTML="TEJIDOS ARTESANALES ";
					}else if(opcionSeleccionada=="5150"){
					    capa.innerHTML="INTRODUCCION A LAS ESPECIALIDADES TECNICO PROFESIONALES ";
					}else if(opcionSeleccionada=="5151"){
					    capa.innerHTML="ATENCION DE ENFERMERIA AL PACIENTE MEDICO QUIRURGICO Y DE ESPECIALIDADES ";
					}else if(opcionSeleccionada=="5152"){
					    capa.innerHTML="ATENCION INTEGRAL ENFERMERIA AL NIÑO Y AL ADOLESCENTE SANO Y ENFERMO ";
					}else if(opcionSeleccionada=="5153"){
					    capa.innerHTML="ATENCION INTEGRAL ENFERMERIA BINOMIO MADRE E HIJO ";
					}else if(opcionSeleccionada=="5154"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DEL MEDIO NATURAL Y CULTURAL ";
					}else if(opcionSeleccionada=="5155"){
					    capa.innerHTML="LA MATEMATICA EN LA BIOLOGIA ";
					}else if(opcionSeleccionada=="5156"){
					    capa.innerHTML="MULTIMEDIA ";
					}else if(opcionSeleccionada=="5157"){
					    capa.innerHTML="NECESIDADES HUMANAS FUNDAMENTALES PARA EL CRECIMIENTO Y DESARROLLO INTEGRAL ";
					}else if(opcionSeleccionada=="5158"){
					    capa.innerHTML="PREVENCION DE ENFERMEDADES INFECTOCONTAGIOSAS Y PROTECCION DE LA SALUD ";
					}else if(opcionSeleccionada=="5159"){
					    capa.innerHTML="PRIMEROS AUXILIOS Y PREVENCION DE RIESGOS EN EL AMBIENTE LABORAL ";
					}else if(opcionSeleccionada=="5160"){
					    capa.innerHTML="TALLER TECNICO PROFESIONAL ";
					}else if(opcionSeleccionada=="5161"){
					    capa.innerHTML="PLAN ELECTIVO DE ARTES MUSICALES: CORO ";
					}else if(opcionSeleccionada=="5162"){
					    capa.innerHTML="PLAN ELECTIVO DE ARTES MUSICALES: GUITARRA CLASICA ";
					}else if(opcionSeleccionada=="5163"){
					    capa.innerHTML="PLAN ELECTIVO DE ARTES MUSICALES: INSTRUMENTOS DE PERCUSION ";
					}else if(opcionSeleccionada=="5164"){
					    capa.innerHTML="PLAN ELECTIVO DE ARTES MUSICALES: INSTRUMENTOS DE VIENTOS ";
					}else if(opcionSeleccionada=="5165"){
					    capa.innerHTML="PLAN ELECTIVO DE ARTES MUSICALES: PIANO ";
					}else if(opcionSeleccionada=="5166"){
					    capa.innerHTML="PLAN ELECTIVO DE ARTES MUSICALES: VIOLA ";
					}else if(opcionSeleccionada=="5167"){
					    capa.innerHTML="PLAN ELECTIVO DE ARTES MUSICALES: VIOLIN ";
					}else if(opcionSeleccionada=="5168"){
					    capa.innerHTML="PLAN ELECTIVO DE ARTES MUSICALES: VIOLONCELLO ";
					}else if(opcionSeleccionada=="5169"){
					    capa.innerHTML="PLAN ELECTIVO DE ARTES PLASTICAS Y EXPRESION CORPORAL: DANZA EDUCATIVA ";
					}else if(opcionSeleccionada=="5170"){
					    capa.innerHTML="PLAN ELECTIVO DE ARTES PLASTICAS Y EXPRESION CORPORAL: DIBUJO Y PINTURA ";
					}else if(opcionSeleccionada=="5171"){
					    capa.innerHTML="PLAN ELECTIVO DE ARTES PLASTICAS Y EXPRESION CORPORAL: FOLCLORE ";
					}else if(opcionSeleccionada=="5172"){
					    capa.innerHTML="PLAN ELECTIVO DE ARTES PLASTICAS Y EXPRESION CORPORAL: MODELADO Y CERAMICA ";
					}else if(opcionSeleccionada=="5173"){
					    capa.innerHTML="PLAN ELECTIVO DE ARTES PLASTICAS Y EXPRESION CORPORAL: TEATRO ";
					}else if(opcionSeleccionada=="5174"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN CORO ";
					}else if(opcionSeleccionada=="5175"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN DANZA EDUCATIVA ";
					}else if(opcionSeleccionada=="5176"){
					    capa.innerHTML="TALLER DE INICIACION ARTISTICA EN DIBUJO Y PINTURA ";
					}else if(opcionSeleccionada=="5109"){
					    capa.innerHTML="TRANSACCIONES COMERCIALES ";
					}else if(opcionSeleccionada=="5110"){
					    capa.innerHTML="GESTION DE PERSONAL ";
					}else if(opcionSeleccionada=="5111"){
					    capa.innerHTML="MANTENCION Y OPERACION DE MAQUINAS DE EQUIPOS ELECTRICOS ";
					}else if(opcionSeleccionada=="5112"){
					    capa.innerHTML="REPRODUCCION ANIMAL ";
					}else if(opcionSeleccionada=="5113"){
					    capa.innerHTML="EXPLORACION ARTES ESCENICAS ";
					}else if(opcionSeleccionada=="5114"){
					    capa.innerHTML="EXPLORACION ARTES VISUALES ";
					}else if(opcionSeleccionada=="5115"){
					    capa.innerHTML="EXPLORACION MUSICAL ";
					}else if(opcionSeleccionada=="5116"){
					    capa.innerHTML="INICIACION ARTES ESCENICAS ";
					}else if(opcionSeleccionada=="5117"){
					    capa.innerHTML="INICIACION ARTES VISUALES ";
					}else if(opcionSeleccionada=="5118"){
					    capa.innerHTML="INICIACION MUSICAL ";
					}else if(opcionSeleccionada=="5119"){
					    capa.innerHTML="MODULOS MODIFICADOS ";
					}else if(opcionSeleccionada=="5120"){
					    capa.innerHTML="TALLER DE EDUCACION FISICA ";
					}else if(opcionSeleccionada=="5121"){
					    capa.innerHTML="TECNICAS DE AISLAMIENTO ";
					}else if(opcionSeleccionada=="5122"){
					    capa.innerHTML="TEORIA MUSICAL ";
					}else if(opcionSeleccionada=="5123"){
					    capa.innerHTML="PLANIFICACION Y CONTROL DE LAS AREAS DE ALOJAMIENTO, RESTAURANTES Y CAFETERIAS ";
					}else if(opcionSeleccionada=="5124"){
					    capa.innerHTML="SERVICIO DE BAR, ENOLOGIA Y ARMONIA DE VINOS Y COMIDAS ";
					}else if(opcionSeleccionada=="5125"){
					    capa.innerHTML="TALLER DE PERIODISMO ";
					}else if(opcionSeleccionada=="5126"){
					    capa.innerHTML="TALLER PAA VERBAL ";
					}else if(opcionSeleccionada=="5127"){
					    capa.innerHTML="TALLER PAA MATEMATICA ";
					}else if(opcionSeleccionada=="5128"){
					    capa.innerHTML="TALLER PAA HISTORIA Y GEOGRAFIA ";
					}else if(opcionSeleccionada=="5129"){
					    capa.innerHTML="TALLER DE FRUTALES MENORES ";
					}else if(opcionSeleccionada=="5130"){
					    capa.innerHTML="TALLER DE FRUTALES DE HOJA CADUCA ";
					}else if(opcionSeleccionada=="5131"){
					    capa.innerHTML="MANTENIMIENTO Y/O MONTAJE DE SISTEMAS DE SEGURIDAD Y COMPORTABILIDAD ";
					}else if(opcionSeleccionada=="5132"){
					    capa.innerHTML="GENOMA HUMANO ";
					}else if(opcionSeleccionada=="5133"){
					    capa.innerHTML="INGLES VOCACIONAL ";
					}else if(opcionSeleccionada=="5134"){
					    capa.innerHTML="SISTEMA DE PREPARACION VEGETAL ";
					}else if(opcionSeleccionada=="5135"){
					    capa.innerHTML="ADMINISTRACION DE PREDIOS ";
					}else if(opcionSeleccionada=="5136"){
					    capa.innerHTML="ADMINISTRACION DE PRODUCTOS Y PRODUCCION PECUARIA ";
					}else if(opcionSeleccionada=="5137"){
					    capa.innerHTML="CONTAMINACION AMBIENTAL ";
					}else if(opcionSeleccionada=="5138"){
					    capa.innerHTML="ESTADISTICA Y MATEMATICA FINANCIERA ";
					}else if(opcionSeleccionada=="5139"){
					    capa.innerHTML="ESTRUCTURAS DE RIEGO ARTIFICIAL ";
					}else if(opcionSeleccionada=="5140"){
					    capa.innerHTML="LABORATORIO ADMINISTRATIVO ";
					}else if(opcionSeleccionada=="5141"){
					    capa.innerHTML="LEGISLACION Y SEGURIDAD ";
					}else if(opcionSeleccionada=="5142"){
					    capa.innerHTML="MANTENIMIENTO Y CONDICIONES DE ELEMENTOS DE CORTE ";
					}else if(opcionSeleccionada=="5074"){
					    capa.innerHTML="COMUNICACION BILINGUE ";
					}else if(opcionSeleccionada=="5075"){
					    capa.innerHTML="COMUNICACION PROTOCOLAR ";
					}else if(opcionSeleccionada=="5076"){
					    capa.innerHTML="ELABORACION Y PRESENTACION DE PLATOS INTERNACIONALES ";
					}else if(opcionSeleccionada=="5077"){
					    capa.innerHTML="ELABORACION Y PRESENTACION DE PLATOS NACIONALES E INTERNACIONALES ";
					}else if(opcionSeleccionada=="5078"){
					    capa.innerHTML="ELABORACION Y PRESENTACION DE PLATOS NACIONALES ";
					}else if(opcionSeleccionada=="5079"){
					    capa.innerHTML="ELABORACION Y PRESENTACION DE PRODUCTOS DE PASTELERIA Y REPOSTERIA ";
					}else if(opcionSeleccionada=="5080"){
					    capa.innerHTML="ELABORACION Y PRESENTACION DE PRODUCTOS DE PASTELERIA ";
					}else if(opcionSeleccionada=="5081"){
					    capa.innerHTML="ELABORACION Y PRESENTACION DE PRODUCTOS PARA BUFFET, COCTEL Y BANQUETES ";
					}else if(opcionSeleccionada=="5082"){
					    capa.innerHTML="GESTION MICROEMPRESARIAL EN EL AREA DE ALIMENTACION ";
					}else if(opcionSeleccionada=="5083"){
					    capa.innerHTML="INFORMACION TURISTICA DE CHILE ";
					}else if(opcionSeleccionada=="5084"){
					    capa.innerHTML="OPERACION HOTELERA ";
					}else if(opcionSeleccionada=="5085"){
					    capa.innerHTML="DESARROLLO MOTOR, COGNITIVO Y SOCIAL ";
					}else if(opcionSeleccionada=="5086"){
					    capa.innerHTML="MANTENGAMOS NUESTRA CONDICION FISICA ";
					}else if(opcionSeleccionada=="5087"){
					    capa.innerHTML="MEJOREMOS NUESTRO FISICO Y SALUD ";
					}else if(opcionSeleccionada=="5088"){
					    capa.innerHTML="PREPARACION FISICA PROFESIONAL ";
					}else if(opcionSeleccionada=="5089"){
					    capa.innerHTML="PSICOMOTRICIDAD EN EL PARVULO ";
					}else if(opcionSeleccionada=="5090"){
					    capa.innerHTML="MODULO CIENTIFICO TECNOLOGICO ";
					}else if(opcionSeleccionada=="5091"){
					    capa.innerHTML="MODULO LITERARIO CULTURAL ";
					}else if(opcionSeleccionada=="5092"){
					    capa.innerHTML="MODULO VOCACIONAL ";
					}else if(opcionSeleccionada=="5093"){
					    capa.innerHTML="ELABORACION Y PRESENTACION DE PRODUCTOS DE PANADERIA ";
					}else if(opcionSeleccionada=="5094"){
					    capa.innerHTML="REDACCION Y ORATORIA ";
					}else if(opcionSeleccionada=="5095"){
					    capa.innerHTML="LITERATURA Y VALORES ";
					}else if(opcionSeleccionada=="5096"){
					    capa.innerHTML="ACTIVIDADES SICOMOTRICES ";
					}else if(opcionSeleccionada=="5097"){
					    capa.innerHTML="ATENCION EN SALUD E HIGIENE DE LOS PARVULOS ";
					}else if(opcionSeleccionada=="5098"){
					    capa.innerHTML="ELABORACION Y PRESENTACION DE PLATOS DE LA COCINA NACIONAL ";
					}else if(opcionSeleccionada=="5100"){
					    capa.innerHTML="PLANIFICACION Y EVALUACION PRE-ESCOLAR ";
					}else if(opcionSeleccionada=="5101"){
					    capa.innerHTML="SUPERVISION DE SECCIONES ";
					}else if(opcionSeleccionada=="5102"){
					    capa.innerHTML="NOCIONES BASICAS DE COMPUTACION ";
					}else if(opcionSeleccionada=="5103"){
					    capa.innerHTML="SOFTWARE DE APLICACION Y REDES ";
					}else if(opcionSeleccionada=="5104"){
					    capa.innerHTML="CALCULO APLICADO A LA TECNOLOGIA ";
					}else if(opcionSeleccionada=="5105"){
					    capa.innerHTML="DIBUJO Y DISEÑO ";
					}else if(opcionSeleccionada=="5106"){
					    capa.innerHTML="PROCESOS INDUSTRIALES ";
					}else if(opcionSeleccionada=="5107"){
					    capa.innerHTML="ADMINISTRACION DE PRODUCTOS ";
					}else if(opcionSeleccionada=="5108"){
					    capa.innerHTML="COMERCIALIZACION DE BIENES Y SERVICIOS ";
					}else if(opcionSeleccionada=="5040"){
					    capa.innerHTML="ASAMBLEA Y DEVOCIONALES ";
					}else if(opcionSeleccionada=="5041"){
					    capa.innerHTML="EVALUACION ECOLOGIA Y AMBIENTE ";
					}else if(opcionSeleccionada=="5042"){
					    capa.innerHTML="INGLES COMUNICATIVO CON APLICACIONES A LA INFORMATICA ";
					}else if(opcionSeleccionada=="5043"){
					    capa.innerHTML="JARDINERIA Y FRUTICULTURA ";
					}else if(opcionSeleccionada=="5044"){
					    capa.innerHTML="LENGUA MAPUCHE ";
					}else if(opcionSeleccionada=="5045"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION MUSICAL ";
					}else if(opcionSeleccionada=="5046"){
					    capa.innerHTML="MANEJO DE OFICINA ";
					}else if(opcionSeleccionada=="5047"){
					    capa.innerHTML="MANIFESTACIONES ARTESANALES LOCALES ";
					}else if(opcionSeleccionada=="5048"){
					    capa.innerHTML="MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="5049"){
					    capa.innerHTML="NECESIDADES HUMANAS Y EL IMPACTO DE LA ENFERMEDAD EN EL SER HUMANO ";
					}else if(opcionSeleccionada=="5050"){
					    capa.innerHTML="ORIENTACION Y ADMINISTRACION EN LA ATENCION DE USUARIOS DE LA SALUD ";
					}else if(opcionSeleccionada=="5051"){
					    capa.innerHTML="ORQUESTA RITMICA ";
					}else if(opcionSeleccionada=="5052"){
					    capa.innerHTML="PRINCIPIOS DE ADMINISTRACION PUBLICA ";
					}else if(opcionSeleccionada=="5053"){
					    capa.innerHTML="PRODUCCION PECUARIA CASERA ";
					}else if(opcionSeleccionada=="5054"){
					    capa.innerHTML="SALUD BUCAL, ALIMENTACION Y NUTRICION ";
					}else if(opcionSeleccionada=="5055"){
					    capa.innerHTML="SANEAMIENTO AMBIENTAL ";
					}else if(opcionSeleccionada=="5056"){
					    capa.innerHTML="SISTEMA DE SALUD MAPUCHE ";
					}else if(opcionSeleccionada=="5057"){
					    capa.innerHTML="TECNICAS DE ELABORACION Y PRESENTACION DE PLATOS DE COCINA MAPUCHE ";
					}else if(opcionSeleccionada=="5058"){
					    capa.innerHTML="FISIOLOGIA II ";
					}else if(opcionSeleccionada=="5059"){
					    capa.innerHTML="GRAFICA, PINTURA Y ESCULTURA ";
					}else if(opcionSeleccionada=="5060"){
					    capa.innerHTML="INTRODUCCION A LA LOGICA ";
					}else if(opcionSeleccionada=="5061"){
					    capa.innerHTML="ACTIVIDADES MUSICALES CON INSTRUMENTOS ";
					}else if(opcionSeleccionada=="5062"){
					    capa.innerHTML="EJECUCION DE EVENTOS Y TECNICAS DE ELABORACION DE ALIMENTOS PARA COCTEL ";
					}else if(opcionSeleccionada=="5063"){
					    capa.innerHTML="ESTUDIO DE LA PERSONALIDAD Y SU DESARROLLO ";
					}else if(opcionSeleccionada=="5064"){
					    capa.innerHTML="INTRODUCCION A LA MULTIMEDIA ";
					}else if(opcionSeleccionada=="5065"){
					    capa.innerHTML="PLAN DE DESARROLLO DE APRENDIZAJE EN LA EMPRESA ";
					}else if(opcionSeleccionada=="5066"){
					    capa.innerHTML="PREPARACION Y CONSERVACION DE ALIMENTOS ";
					}else if(opcionSeleccionada=="5067"){
					    capa.innerHTML="PREPARADO Y CONFECCION DE PRENDAS DE VESTIR PARA EL HOGAR ";
					}else if(opcionSeleccionada=="5068"){
					    capa.innerHTML="PRODUCCION OVINA ";
					}else if(opcionSeleccionada=="5069"){
					    capa.innerHTML="PRODUCCION PORCINA ";
					}else if(opcionSeleccionada=="5070"){
					    capa.innerHTML="TECNICAS DE SERVICIO DE BAR, ENOLOGIA Y ARMONIA DE VINOS Y COMIDA ";
					}else if(opcionSeleccionada=="5071"){
					    capa.innerHTML="TECNICAS Y SERVICIO DE VENTA, MANEJO DE CAJA Y CONSERJERIA ";
					}else if(opcionSeleccionada=="5072"){
					    capa.innerHTML="ATENCION DE NECESIDADES EDUCATIVAS CURRICULARES ";
					}else if(opcionSeleccionada=="5073"){
					    capa.innerHTML="BODEGAJE, CONSERVACION Y REFRIGERACION DE ALIMENTOS ";
					}else if(opcionSeleccionada=="5006"){
					    capa.innerHTML="RELIGION IGLESIAS Y CORPORACIONES EVANGELICAS ";
					}else if(opcionSeleccionada=="5007"){
					    capa.innerHTML="RELIGION EVANGELICA BAUTISTA ";
					}else if(opcionSeleccionada=="5008"){
					    capa.innerHTML="RELIGION FE BAHA´L ";
					}else if(opcionSeleccionada=="5009"){
					    capa.innerHTML="RELIGION IGLESIA EVANGELICA PENTECOSTAL ";
					}else if(opcionSeleccionada=="5010"){
					    capa.innerHTML="RELIGION COMUNIDAD RELIGIOSA TESTIGOS DE JEHOVA ";
					}else if(opcionSeleccionada=="5011"){
					    capa.innerHTML="QUIMICA FORMACION DIFERENCIADA HUMANISTICO-CIENTIFICA 4° AÑO MEDIO ";
					}else if(opcionSeleccionada=="5012"){
					    capa.innerHTML="JARDINERIA Y MANTENCION DE AREAS VERDES ";
					}else if(opcionSeleccionada=="5013"){
					    capa.innerHTML="POSTCOSECHA Y PACKING ";
					}else if(opcionSeleccionada=="5014"){
					    capa.innerHTML="VITICULTURA ";
					}else if(opcionSeleccionada=="5015"){
					    capa.innerHTML="RAZONAMIENTO VERBAL I ";
					}else if(opcionSeleccionada=="5016"){
					    capa.innerHTML="RAZONAMIENTO VERBAL II ";
					}else if(opcionSeleccionada=="5017"){
					    capa.innerHTML="RAZONAMIENTO MATEMATICO I ";
					}else if(opcionSeleccionada=="5018"){
					    capa.innerHTML="RAZONAMIENTO MATEMATICO II ";
					}else if(opcionSeleccionada=="5019"){
					    capa.innerHTML="COMPETENCIAS MATEMATICAS ";
					}else if(opcionSeleccionada=="5020"){
					    capa.innerHTML="EDUCOMPUTACION ";
					}else if(opcionSeleccionada=="5021"){
					    capa.innerHTML="GESTION DE AGROECOSISTEMA ";
					}else if(opcionSeleccionada=="5022"){
					    capa.innerHTML="INSTALACIONES ELECTRONICAS ";
					}else if(opcionSeleccionada=="5023"){
					    capa.innerHTML="JUEGOS TRADICIONALES ";
					}else if(opcionSeleccionada=="5024"){
					    capa.innerHTML="APLICACION DE LA INFORMATICA I ";
					}else if(opcionSeleccionada=="5025"){
					    capa.innerHTML="APLICACION DE LA INFORMATICA II ";
					}else if(opcionSeleccionada=="5026"){
					    capa.innerHTML="APLICACIONES GEOMETRICAS ALGEBRAICAS I ";
					}else if(opcionSeleccionada=="5027"){
					    capa.innerHTML="APLICACIONES GEOMETRICAS ALGEBRAICAS II ";
					}else if(opcionSeleccionada=="5028"){
					    capa.innerHTML="ESPAÑOL INSTRUMENTAL ";
					}else if(opcionSeleccionada=="5029"){
					    capa.innerHTML="EXPRESION ORAL Y ESCRITA I ";
					}else if(opcionSeleccionada=="5030"){
					    capa.innerHTML="EXPRESION ORAL Y ESCRITA II ";
					}else if(opcionSeleccionada=="5031"){
					    capa.innerHTML="INFORMATICA APLICADA III ";
					}else if(opcionSeleccionada=="5032"){
					    capa.innerHTML="INFORMATICA APLICADA IV ";
					}else if(opcionSeleccionada=="5033"){
					    capa.innerHTML="LABORATORIO DE QUIMICA I ";
					}else if(opcionSeleccionada=="5034"){
					    capa.innerHTML="LABORATORIO DE QUIMICA II ";
					}else if(opcionSeleccionada=="5035"){
					    capa.innerHTML="LITERATURA Y SOCIEDAD ";
					}else if(opcionSeleccionada=="5036"){
					    capa.innerHTML="MATEMATICA APLICADA I ";
					}else if(opcionSeleccionada=="5037"){
					    capa.innerHTML="AGRICULTURA FAMILIAR ";
					}else if(opcionSeleccionada=="5038"){
					    capa.innerHTML="ARTESANIA CULINARIA ";
					}else if(opcionSeleccionada=="5039"){
					    capa.innerHTML="ASAMBLEA ";
					}else if(opcionSeleccionada=="4972"){
					    capa.innerHTML="PRODUCCION REGIONAL: CONSERVACION Y PROCESAMIENTO DE PRODUCTOS AGROPRECUARIOS ";
					}else if(opcionSeleccionada=="4973"){
					    capa.innerHTML="PRODUCCION REGIONAL: CULTIVOS BAJO PLASTICO ";
					}else if(opcionSeleccionada=="4974"){
					    capa.innerHTML="PRODUCCION REGIONAL: PRODUCCION DE LECHE ";
					}else if(opcionSeleccionada=="4975"){
					    capa.innerHTML="PRODUCCION REGIONAL: PRODUCCION FORESTAL ";
					}else if(opcionSeleccionada=="4976"){
					    capa.innerHTML="PRODUCCION REGIONAL: TRANSFERENCIA TECNOLOGICA ";
					}else if(opcionSeleccionada=="4977"){
					    capa.innerHTML="PROYECTOS DE PLANOS REFERIDOS A TERMINACIONES DE VIVIENDA ";
					}else if(opcionSeleccionada=="4978"){
					    capa.innerHTML="RECURSOS PARA OBTENER EMPLEOS SATISFACTORIOS ";
					}else if(opcionSeleccionada=="4979"){
					    capa.innerHTML="REFRIGERACION INDUSTRIAL ";
					}else if(opcionSeleccionada=="4980"){
					    capa.innerHTML="RELACIONES PUBLICAS EN ACCION ";
					}else if(opcionSeleccionada=="4981"){
					    capa.innerHTML="REPARACION DE ARTEFACTOS ELECTRICOS ";
					}else if(opcionSeleccionada=="4982"){
					    capa.innerHTML="REPOSTERIA REGIONAL ";
					}else if(opcionSeleccionada=="4983"){
					    capa.innerHTML="RIEGO PRESURIZADO ";
					}else if(opcionSeleccionada=="4984"){
					    capa.innerHTML="SANIDAD FORESTAL ";
					}else if(opcionSeleccionada=="4985"){
					    capa.innerHTML="SISTEMAS DE FRENO ";
					}else if(opcionSeleccionada=="4986"){
					    capa.innerHTML="SISTEMA DE PROTECCION ELECTRICA ";
					}else if(opcionSeleccionada=="4987"){
					    capa.innerHTML="SOLDADURAS Y TECNICAS DE CORTE ";
					}else if(opcionSeleccionada=="4988"){
					    capa.innerHTML="SUELO, FERTILIZACION Y RIEGO ";
					}else if(opcionSeleccionada=="4989"){
					    capa.innerHTML="SUELO, RIEGO Y FERTILIZACION ";
					}else if(opcionSeleccionada=="4990"){
					    capa.innerHTML="TECNICAS DE PASTELERIA, REPOSTERIA Y PANADERIA ";
					}else if(opcionSeleccionada=="4991"){
					    capa.innerHTML="TECNICAS PECUARIAS ";
					}else if(opcionSeleccionada=="4992"){
					    capa.innerHTML="TORNO I ";
					}else if(opcionSeleccionada=="4993"){
					    capa.innerHTML="TORNO II ";
					}else if(opcionSeleccionada=="4994"){
					    capa.innerHTML="TRATAMIENTOS TERMICOS ";
					}else if(opcionSeleccionada=="4995"){
					    capa.innerHTML="TUTORIA ACADEMICA ";
					}else if(opcionSeleccionada=="4996"){
					    capa.innerHTML="UNA VISION FUTURISTA HACIA LOS MEDIOS DE COMUNICACION ";
					}else if(opcionSeleccionada=="4997"){
					    capa.innerHTML="USO DE PROGRAMAS DE COMPUTACION ";
					}else if(opcionSeleccionada=="4998"){
					    capa.innerHTML="UTILIZANDO UN SEGUNDO IDIOMA AL SERVICIO DEL CLIENTE ";
					}else if(opcionSeleccionada=="4999"){
					    capa.innerHTML="VENTAS ";
					}else if(opcionSeleccionada=="5000"){
					    capa.innerHTML="RELIGION ORTODOXA ";
					}else if(opcionSeleccionada=="5001"){
					    capa.innerHTML="RELIGION PRESBITERIANA ";
					}else if(opcionSeleccionada=="5002"){
					    capa.innerHTML="RELIGION UNION CHILENA DE LA IGLESIA ADVENTISTA DEL 7MO DIA ";
					}else if(opcionSeleccionada=="5003"){
					    capa.innerHTML="RELIGION ANGLICANA ";
					}else if(opcionSeleccionada=="5004"){
					    capa.innerHTML="RELIGION CORPORACION IGLESIA EVANGELICA LUTERANA ";
					}else if(opcionSeleccionada=="5005"){
					    capa.innerHTML="RELIGION METODISTA ";
					}else if(opcionSeleccionada=="4938"){
					    capa.innerHTML="INTRODUCCION A LA PRODUCCION FORESTAL ";
					}else if(opcionSeleccionada=="4939"){
					    capa.innerHTML="INTRODUCCION AL CAMPO AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="4940"){
					    capa.innerHTML="INVENTARIO FORESTAL ";
					}else if(opcionSeleccionada=="4941"){
					    capa.innerHTML="LABORATORIO DE QUIMICA ";
					}else if(opcionSeleccionada=="4942"){
					    capa.innerHTML="LECTURA SOSTENIDA ";
					}else if(opcionSeleccionada=="4943"){
					    capa.innerHTML="LIDERANDO LAS TAREAS AL INTERIOR DE UNA ORGANIZACION ";
					}else if(opcionSeleccionada=="4944"){
					    capa.innerHTML="LINEAS DE MEDIA TENSION ";
					}else if(opcionSeleccionada=="4945"){
					    capa.innerHTML="MANEJANDO EL MUNDO CONTABLE ";
					}else if(opcionSeleccionada=="4946"){
					    capa.innerHTML="MANEJO DE PLANTACIONES Y BOSQUE NATIVO ";
					}else if(opcionSeleccionada=="4947"){
					    capa.innerHTML="MANEJO SILVOAGROPECUARIO ";
					}else if(opcionSeleccionada=="4948"){
					    capa.innerHTML="MANTENCION Y REPARACION DE MAQUINAS, EQUIPOS Y HERRAMIENTAS ";
					}else if(opcionSeleccionada=="4949"){
					    capa.innerHTML="MANTENCION Y REPARACION DE MOTORES DE COMBUSTION INTERNA Y SISTEMAS AUXILIARES ";
					}else if(opcionSeleccionada=="4950"){
					    capa.innerHTML="MANTENIMIENTO ";
					}else if(opcionSeleccionada=="4951"){
					    capa.innerHTML="MAQUINAS CNC ";
					}else if(opcionSeleccionada=="4952"){
					    capa.innerHTML="MAQUINAS RECTIFICADORAS ";
					}else if(opcionSeleccionada=="4953"){
					    capa.innerHTML="MECANIZACION AGRICOLA I ";
					}else if(opcionSeleccionada=="4954"){
					    capa.innerHTML="MECANIZACION AGRICOLA II ";
					}else if(opcionSeleccionada=="4955"){
					    capa.innerHTML="MECANIZACION FORESTAL I Y II ";
					}else if(opcionSeleccionada=="4956"){
					    capa.innerHTML="MECANIZADO CON HERRAMIENTAS MANUALES Y MAQUINAS HERRAMIENTAS ";
					}else if(opcionSeleccionada=="4957"){
					    capa.innerHTML="MEDICIONES ELECTRICAS ";
					}else if(opcionSeleccionada=="4958"){
					    capa.innerHTML="MONTAJE DE CONSTRUCCION DE ELEMENTOS ESTRUCTURALES ";
					}else if(opcionSeleccionada=="4959"){
					    capa.innerHTML="MOTORES OTTO DIESSEL ";
					}else if(opcionSeleccionada=="4960"){
					    capa.innerHTML="NOCIONES BASICAS PARA LA CONDUCCION ";
					}else if(opcionSeleccionada=="4961"){
					    capa.innerHTML="NOCIONES DE ADMINISTRACION Y PERSONAL ";
					}else if(opcionSeleccionada=="4962"){
					    capa.innerHTML="NOCIONES DE AUDITORIA Y CONTROL INTERNO ";
					}else if(opcionSeleccionada=="4963"){
					    capa.innerHTML="NORMAS E INSTALACIONES ELECTRICAS ";
					}else if(opcionSeleccionada=="4964"){
					    capa.innerHTML="OBRA GRUESA EN MADERA ";
					}else if(opcionSeleccionada=="4965"){
					    capa.innerHTML="OBRA GRUESA EN MADERA Y HORMIGON ";
					}else if(opcionSeleccionada=="4966"){
					    capa.innerHTML="ORGANIZACION Y TECNICAS COMERCIALES ";
					}else if(opcionSeleccionada=="4967"){
					    capa.innerHTML="PLANIFICACION Y ORGANIZACION DE EVENTOS ";
					}else if(opcionSeleccionada=="4968"){
					    capa.innerHTML="PRACTICA DE CONDUCCION ";
					}else if(opcionSeleccionada=="4969"){
					    capa.innerHTML="PREPARACION PARA EL AUTOEMPLEO ";
					}else if(opcionSeleccionada=="4970"){
					    capa.innerHTML="PRINCIPIOS DE GESTION ADMINISTRATIVA Y COMERCIAL ";
					}else if(opcionSeleccionada=="4971"){
					    capa.innerHTML="PRODUCCION REGIONAL ";
					}else if(opcionSeleccionada=="4904"){
					    capa.innerHTML="COLOCACION DE DIVERSOS TIPOS DE REVESTIMIENTOS EN PAVIMENTOS, MUROS, CIELOS Y TECHUMBRES ";
					}else if(opcionSeleccionada=="4905"){
					    capa.innerHTML="CONFECCION DE PROYECTOS MENORES REFERIDOS A TERMINACIONES ";
					}else if(opcionSeleccionada=="4906"){
					    capa.innerHTML="CONOCIENDO EL ROL DE LAS INSTITUCIONES PRIVADAS Y DE SERVICIOS PUBLICOS ";
					}else if(opcionSeleccionada=="4907"){
					    capa.innerHTML="CONTABILIDAD BASICA E INTERMEDIA ";
					}else if(opcionSeleccionada=="4908"){
					    capa.innerHTML="CONTABILIDAD DE EMPRESAS PUBLICAS ";
					}else if(opcionSeleccionada=="4909"){
					    capa.innerHTML="COSECHA Y TRANSPORTE ";
					}else if(opcionSeleccionada=="4910"){
					    capa.innerHTML="CULTIVOS Y PRADERAS ";
					}else if(opcionSeleccionada=="4911"){
					    capa.innerHTML="CULTURA Y TRADICIONES ";
					}else if(opcionSeleccionada=="4912"){
					    capa.innerHTML="CURSO PREPARATORIO PARA LAS PRUEBAS DE SELECCION A LAS UNIVERSIDADES ";
					}else if(opcionSeleccionada=="4913"){
					    capa.innerHTML="CURSO PROPEDEUTICO APLICACION DEL PENSAMIENTO CIENTIFICO CULTURAL ";
					}else if(opcionSeleccionada=="4914"){
					    capa.innerHTML="CURSO TOMA DE DECISIONES Y RESOLUCION DE PROBLEMAS TECNOLOGICOS ";
					}else if(opcionSeleccionada=="4915"){
					    capa.innerHTML="DISENO E INTERPRETACION DE PLANOS Y MANUALES ";
					}else if(opcionSeleccionada=="4916"){
					    capa.innerHTML="DISEÑO DE PROGRAMAS BASICOS PARA MECANIZADO ";
					}else if(opcionSeleccionada=="4917"){
					    capa.innerHTML="EJECUCION DE LA MUEBLERIA EN TERMINACIONES ";
					}else if(opcionSeleccionada=="4918"){
					    capa.innerHTML="EL MUNDO DE LA ELECTRICIDAD ";
					}else if(opcionSeleccionada=="4919"){
					    capa.innerHTML="ELABORACION Y COMERCIALIZACION DE PRODUCTOS DEL MAR ";
					}else if(opcionSeleccionada=="4920"){
					    capa.innerHTML="EN VIAS DE UNA MEJOR COMUNICACION ";
					}else if(opcionSeleccionada=="4921"){
					    capa.innerHTML="ESTABLECIMIENTOS DE PLANTACIONES ";
					}else if(opcionSeleccionada=="4922"){
					    capa.innerHTML="FABRICACION E INSTALACION DE PUERTAS Y VENTANAS ";
					}else if(opcionSeleccionada=="4923"){
					    capa.innerHTML="FENOMENOS ELECTRICOS ";
					}else if(opcionSeleccionada=="4924"){
					    capa.innerHTML="FENOMENOS MAGNETICOS ";
					}else if(opcionSeleccionada=="4925"){
					    capa.innerHTML="FRESADO I ";
					}else if(opcionSeleccionada=="4926"){
					    capa.innerHTML="FRESADO II ";
					}else if(opcionSeleccionada=="4927"){
					    capa.innerHTML="GESTION ADMINISTRATIVA DE LA DOCUMENTACION ";
					}else if(opcionSeleccionada=="4928"){
					    capa.innerHTML="GESTION AGROPECUARIA ";
					}else if(opcionSeleccionada=="4929"){
					    capa.innerHTML="GESTION DE RECURSOS HUMANOS ";
					}else if(opcionSeleccionada=="4930"){
					    capa.innerHTML="GESTION II ";
					}else if(opcionSeleccionada=="4931"){
					    capa.innerHTML="GESTION Y ADMINISTRACION DE MICROEMPRESAS DE TURISMO ";
					}else if(opcionSeleccionada=="4932"){
					    capa.innerHTML="GUIA DE TURISMO ";
					}else if(opcionSeleccionada=="4933"){
					    capa.innerHTML="HERRAMIENTAS MANUALES ";
					}else if(opcionSeleccionada=="4934"){
					    capa.innerHTML="INCORPORANDO TECNICAS DE ORGANIZACION SECRETARIAL ";
					}else if(opcionSeleccionada=="4935"){
					    capa.innerHTML="INSTALACION DE PUERTAS Y VENTANAS ";
					}else if(opcionSeleccionada=="4936"){
					    capa.innerHTML="INSTRUMENTOS DE CREDITOS ";
					}else if(opcionSeleccionada=="4937"){
					    capa.innerHTML="INTERPRETACION Y CONFECCION DE PLANOS GENERALES Y MAQUETA DE ESTUDIO DE VIVIENDA EN DOS NIVELES ";
					}else if(opcionSeleccionada=="4869"){
					    capa.innerHTML="HORTICULTURA Y FLORES ";
					}else if(opcionSeleccionada=="4870"){
					    capa.innerHTML="HORTICULTURA Y FLORICULTURA ";
					}else if(opcionSeleccionada=="4871"){
					    capa.innerHTML="HORTICULTURA Y JARDINERIA ";
					}else if(opcionSeleccionada=="4872"){
					    capa.innerHTML="HORTIFRUTICULTURA Y GANADERIA ";
					}else if(opcionSeleccionada=="4873"){
					    capa.innerHTML="HOTELERIA BAR ";
					}else if(opcionSeleccionada=="4874"){
					    capa.innerHTML="HOTELERIA COMEDOR ";
					}else if(opcionSeleccionada=="4875"){
					    capa.innerHTML="HOTELERIA Y TURISMO ";
					}else if(opcionSeleccionada=="4876"){
					    capa.innerHTML="HUERTO ORGANICO ";
					}else if(opcionSeleccionada=="4877"){
					    capa.innerHTML="EDUCACION DE LA FE ";
					}else if(opcionSeleccionada=="4878"){
					    capa.innerHTML="TALLER LITERARIO ";
					}else if(opcionSeleccionada=="4879"){
					    capa.innerHTML="EDUCACION FISICA: DEPORTES ";
					}else if(opcionSeleccionada=="4880"){
					    capa.innerHTML="FUNDAMENTOS DE LA COMUNICACION AUDIOVISUAL ";
					}else if(opcionSeleccionada=="4881"){
					    capa.innerHTML="IDEAS FUNDAMENTALES DE LAS CIENCIAS ";
					}else if(opcionSeleccionada=="4882"){
					    capa.innerHTML="EXPLORANDO LITERARIAMENTE LA REGION DEL MAULE ";
					}else if(opcionSeleccionada=="4883"){
					    capa.innerHTML="INGLES AUDIOVISUAL ";
					}else if(opcionSeleccionada=="4884"){
					    capa.innerHTML="ELABORACION DE MATERIAL DIDACTICO ";
					}else if(opcionSeleccionada=="4885"){
					    capa.innerHTML="CIENCIAS DE LA TIERRA Y MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="4886"){
					    capa.innerHTML="TALLER DE TECNICAS MIXTAS ";
					}else if(opcionSeleccionada=="4887"){
					    capa.innerHTML="TALLER DE COMICS E HISTORIETAS ";
					}else if(opcionSeleccionada=="4888"){
					    capa.innerHTML="EDUCACION FISICA: DEPORTE SELECCION ";
					}else if(opcionSeleccionada=="4889"){
					    capa.innerHTML="FUNDAMENTOS DE COMUNICACION AUDIOVISUAL ";
					}else if(opcionSeleccionada=="4891"){
					    capa.innerHTML="FILOSOFIA: ARGUMENTACION ";
					}else if(opcionSeleccionada=="4892"){
					    capa.innerHTML="FUNDAMENTOS DE ESPECTOMETRIA Y CATALISIS ";
					}else if(opcionSeleccionada=="4893"){
					    capa.innerHTML="FUNDAMENTOS DE ESPECTROSCOPIA CATALISIS ";
					}else if(opcionSeleccionada=="4894"){
					    capa.innerHTML="ACONDICIONAMIENTO FISICO PARA GUIA DE TURISMO ";
					}else if(opcionSeleccionada=="4895"){
					    capa.innerHTML="ACTIVIDADES AGROPECUARIAS II ";
					}else if(opcionSeleccionada=="4896"){
					    capa.innerHTML="ACTIVIDADES FORESTALES I Y II ";
					}else if(opcionSeleccionada=="4897"){
					    capa.innerHTML="AGENCIA DE VIAJES ";
					}else if(opcionSeleccionada=="4898"){
					    capa.innerHTML="AJUSTE DE MOTORES ";
					}else if(opcionSeleccionada=="4899"){
					    capa.innerHTML="APLICACION DE PINTURAS Y BARNICES ";
					}else if(opcionSeleccionada=="4900"){
					    capa.innerHTML="APLICACIONES HIDRONEUMATICAS ";
					}else if(opcionSeleccionada=="4901"){
					    capa.innerHTML="APLICAR NORMAS BASICAS PARA LA PREVENCION DE RIESGOS LABORALES ";
					}else if(opcionSeleccionada=="4902"){
					    capa.innerHTML="APRECIANDO UNA VIDA SALUDABLE ";
					}else if(opcionSeleccionada=="4903"){
					    capa.innerHTML="ATENCION AL TURISTA ";
					}else if(opcionSeleccionada=="4828"){
					    capa.innerHTML="HISTORIA DE LAS AMERICAS ";
					}else if(opcionSeleccionada=="4829"){
					    capa.innerHTML="HISTORIA DE LAS FRONTERAS DE CHILE ";
					}else if(opcionSeleccionada=="4830"){
					    capa.innerHTML="HISTORIA DEL ARTE UNIVERSAL ";
					}else if(opcionSeleccionada=="4831"){
					    capa.innerHTML="HISTORIA DEL ARTE Y DEL VESTUARIO ";
					}else if(opcionSeleccionada=="4832"){
					    capa.innerHTML="HISTORIA DEL ARTE Y EL TEJIDO ";
					}else if(opcionSeleccionada=="4833"){
					    capa.innerHTML="HISTORIA DEL PUEBLO MAPUCHE ";
					}else if(opcionSeleccionada=="4834"){
					    capa.innerHTML="HISTORIA ECONOMICA DE CHILE ";
					}else if(opcionSeleccionada=="4835"){
					    capa.innerHTML="HISTORIA ELECTIVO ";
					}else if(opcionSeleccionada=="4837"){
					    capa.innerHTML="HISTORIA I ";
					}else if(opcionSeleccionada=="4838"){
					    capa.innerHTML="HISTORIA IBEROAMERICANA ";
					}else if(opcionSeleccionada=="4839"){
					    capa.innerHTML="HISTORIA LOCAL ";
					}else if(opcionSeleccionada=="4840"){
					    capa.innerHTML="HISTORIA QUIMICA ";
					}else if(opcionSeleccionada=="4841"){
					    capa.innerHTML="HISTORIA SOCIAL DIFER ";
					}else if(opcionSeleccionada=="4842"){
					    capa.innerHTML="HISTORIA SOCIAL Y POLITICA DE EUROPA SIGLO XX ";
					}else if(opcionSeleccionada=="4843"){
					    capa.innerHTML="HISTORIA UNIVERSAL DEL SIGLO XX ";
					}else if(opcionSeleccionada=="4846"){
					    capa.innerHTML="HISTORIA UNIVERSAL Y CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="4847"){
					    capa.innerHTML="HISTORIA UNIVERSAL Y ECONOMIA ";
					}else if(opcionSeleccionada=="4848"){
					    capa.innerHTML="HISTORIA UNIVERSAL Y GEOGRAFIA ";
					}else if(opcionSeleccionada=="4849"){
					    capa.innerHTML="HISTORIA Y ANATOMIA SISTEMA ELEMENTALES ";
					}else if(opcionSeleccionada=="4850"){
					    capa.innerHTML="HISTORIA Y CIENCIAS ";
					}else if(opcionSeleccionada=="4851"){
					    capa.innerHTML="HISTORIA Y CIENCIAS SOCIALES APLICADA ";
					}else if(opcionSeleccionada=="4852"){
					    capa.innerHTML="HISTORIA Y CIENCIAS SOCIALES ELECTIVO ";
					}else if(opcionSeleccionada=="4853"){
					    capa.innerHTML="HISTORIA Y CIENCIAS SOCIALES I ";
					}else if(opcionSeleccionada=="4854"){
					    capa.innerHTML="HISTORIA Y CIENCIAS SOCIALES II ";
					}else if(opcionSeleccionada=="4855"){
					    capa.innerHTML="HISTORIA Y CIENCIAS SOCIALES Y REALIDAD NACIONAL ";
					}else if(opcionSeleccionada=="4858"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA DE AMERICA LATINA ";
					}else if(opcionSeleccionada=="4859"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA DE CHILE IX REGION ";
					}else if(opcionSeleccionada=="4861"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA DE CHILE Y EDUCACION CIVICA ";
					}else if(opcionSeleccionada=="4862"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA DE MAGALLANES ";
					}else if(opcionSeleccionada=="4863"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA UNIVERSAL ";
					}else if(opcionSeleccionada=="4865"){
					    capa.innerHTML="HISTORIA Y REALIDAD NACIONAL ";
					}else if(opcionSeleccionada=="4866"){
					    capa.innerHTML="HOMBRE CIENCIA Y CULTURA ";
					}else if(opcionSeleccionada=="4867"){
					    capa.innerHTML="HOMEOSTASIS Y ECOLOGIA ";
					}else if(opcionSeleccionada=="4868"){
					    capa.innerHTML="HORTICULTURA Y CULTIVOS ";
					}else if(opcionSeleccionada=="4790"){
					    capa.innerHTML="GESTION FINANCIERA ";
					}else if(opcionSeleccionada=="4792"){
					    capa.innerHTML="GESTION I ";
					}else if(opcionSeleccionada=="4793"){
					    capa.innerHTML="GESTION JURIDICA ";
					}else if(opcionSeleccionada=="4794"){
					    capa.innerHTML="GESTION MICRO EMPRESA ";
					}else if(opcionSeleccionada=="4795"){
					    capa.innerHTML="GESTION Y ADMINISTRACION ";
					}else if(opcionSeleccionada=="4796"){
					    capa.innerHTML="GESTION Y PROYECTO ";
					}else if(opcionSeleccionada=="4797"){
					    capa.innerHTML="GESTION Y PROYECTO DE LA EMPRESA ";
					}else if(opcionSeleccionada=="4798"){
					    capa.innerHTML="GESTION Y PROYECTO DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="4799"){
					    capa.innerHTML="GESTION Y SERVICIOS ";
					}else if(opcionSeleccionada=="4800"){
					    capa.innerHTML="GRAFICA ";
					}else if(opcionSeleccionada=="4801"){
					    capa.innerHTML="GRAFICA, PINTURA ";
					}else if(opcionSeleccionada=="4802"){
					    capa.innerHTML="GRAFICA, PINTURA Y FOTOGRAFIA ";
					}else if(opcionSeleccionada=="4803"){
					    capa.innerHTML="GRAFICA, PINTURA, ESCULTURA Y COMPOSICION MUSICAL ";
					}else if(opcionSeleccionada=="4804"){
					    capa.innerHTML="GRANDES SUCESOS DE LA HISTORIA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="4806"){
					    capa.innerHTML="HABILIDADES ";
					}else if(opcionSeleccionada=="4808"){
					    capa.innerHTML="HACIA EL DESARROLLO HUMANO ";
					}else if(opcionSeleccionada=="4809"){
					    capa.innerHTML="HERRAMIENTAS PARA LA SOLUCION DE PROBLEMAS A NIVEL ESCOLAR ";
					}else if(opcionSeleccionada=="4810"){
					    capa.innerHTML="HERRAMIENTAS Y MAQUINAS ";
					}else if(opcionSeleccionada=="4811"){
					    capa.innerHTML="HIDRAULICA ";
					}else if(opcionSeleccionada=="4812"){
					    capa.innerHTML="HIDRONEUMATICA ";
					}else if(opcionSeleccionada=="4813"){
					    capa.innerHTML="HIDROPONIA ";
					}else if(opcionSeleccionada=="4814"){
					    capa.innerHTML="HIGIENE ";
					}else if(opcionSeleccionada=="4815"){
					    capa.innerHTML="HIGIENE DE LOS ALIMENTOS ";
					}else if(opcionSeleccionada=="4816"){
					    capa.innerHTML="HIGIENE Y ALIMENTACION ";
					}else if(opcionSeleccionada=="4817"){
					    capa.innerHTML="HIGIENE Y SEGURIDAD LABORAL ";
					}else if(opcionSeleccionada=="4818"){
					    capa.innerHTML="HISTORIA EVOLUTIVA CONSTITUCIONAL DE CHILE ";
					}else if(opcionSeleccionada=="4819"){
					    capa.innerHTML="HISTORIA G. E. CIV. Y ECON. HIS. DEL CRIST. Y SU I. EN OCC. II";
					}else if(opcionSeleccionada=="4820"){
					    capa.innerHTML="HISTOLOGIA Y ANATOMIA SISTEMA ELEMENTAL ";
					}else if(opcionSeleccionada=="4821"){
					    capa.innerHTML="HISTORIA II ";
					}else if(opcionSeleccionada=="4823"){
					    capa.innerHTML="HISTORIA CIENCIAS SOCIALES Y EDUCACION CIVICA ";
					}else if(opcionSeleccionada=="4824"){
					    capa.innerHTML="HISTORIA CONTEMPORANEA AMERICA LATINA ";
					}else if(opcionSeleccionada=="4825"){
					    capa.innerHTML="HISTORIA DE AMERICA ";
					}else if(opcionSeleccionada=="4826"){
					    capa.innerHTML="HISTORIA DE LA PLASTICA Y LA MUSICA ";
					}else if(opcionSeleccionada=="4827"){
					    capa.innerHTML="HISTORIA DE LA QUIMICA Y TERMODINAMICA ";
					}else if(opcionSeleccionada=="4755"){
					    capa.innerHTML="GEOGRAFIA ECONOMICA DE CHILE ";
					}else if(opcionSeleccionada=="4757"){
					    capa.innerHTML="GEOGRAFIA FISICA I ";
					}else if(opcionSeleccionada=="4758"){
					    capa.innerHTML="GEOGRAFIA FISICA, HUMANA Y ECONOMICA DE CHILE ";
					}else if(opcionSeleccionada=="4759"){
					    capa.innerHTML="GEOGRAFIA GENERAL II ";
					}else if(opcionSeleccionada=="4760"){
					    capa.innerHTML="GEOGRAFIA REGIONAL Y CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="4761"){
					    capa.innerHTML="GEOGRAFIA TURISTICA MUNDIAL ";
					}else if(opcionSeleccionada=="4762"){
					    capa.innerHTML="GEOGRAFIA Y RECURSOS TURISTICOS DE CHILE ";
					}else if(opcionSeleccionada=="4763"){
					    capa.innerHTML="GEOLOGIA APLICADA ";
					}else if(opcionSeleccionada=="4764"){
					    capa.innerHTML="GEOLOGIA ECONOMICA ";
					}else if(opcionSeleccionada=="4765"){
					    capa.innerHTML="GEOMETRIA ANALITICA ";
					}else if(opcionSeleccionada=="4766"){
					    capa.innerHTML="GEOMETRIA APLICADA ";
					}else if(opcionSeleccionada=="4767"){
					    capa.innerHTML="GEOMETRIA PLANA CON COORD. Y GEOMETRIA ANALITICA BASICA ";
					}else if(opcionSeleccionada=="4768"){
					    capa.innerHTML="GEOMETRIA PLANA Y DEL ESPACIO ";
					}else if(opcionSeleccionada=="4769"){
					    capa.innerHTML="GEOMETRIA Y SUS APLICACIONES ";
					}else if(opcionSeleccionada=="4770"){
					    capa.innerHTML="GEOMORFOLOGIA Y CONSERVA ";
					}else if(opcionSeleccionada=="4771"){
					    capa.innerHTML="GEOPOLITICA ";
					}else if(opcionSeleccionada=="4772"){
					    capa.innerHTML="GEOPOLITICA DE AMERICA LATINA Y SU INTEGRACION MUNDIAL ";
					}else if(opcionSeleccionada=="4773"){
					    capa.innerHTML="GEOPOLITICA I ";
					}else if(opcionSeleccionada=="4774"){
					    capa.innerHTML="GEOPOLITICA II ";
					}else if(opcionSeleccionada=="4775"){
					    capa.innerHTML="GESTION MICROEMPRESARIA Y COMERCIO ";
					}else if(opcionSeleccionada=="4776"){
					    capa.innerHTML="GESTION COMERCIAL Y TRIBUTARIA ";
					}else if(opcionSeleccionada=="4777"){
					    capa.innerHTML="GESTION COMPRA Y VENTA INFORMATIVOS FINANCIEROS ";
					}else if(opcionSeleccionada=="4778"){
					    capa.innerHTML="GESTION CONTABLE I ";
					}else if(opcionSeleccionada=="4779"){
					    capa.innerHTML="GESTION CULTURAL Y DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="4780"){
					    capa.innerHTML="GESTION DE DATOS ";
					}else if(opcionSeleccionada=="4781"){
					    capa.innerHTML="GESTION DE EMPRESAS ";
					}else if(opcionSeleccionada=="4782"){
					    capa.innerHTML="GESTION DE EMPRESAS AGROPECUARIAS ";
					}else if(opcionSeleccionada=="4783"){
					    capa.innerHTML="GESTION DE LA PEQUENA EMPRESA - PROGRAMACION DE LOS PROCESOS DE	MECANIZADO ";
					}else if(opcionSeleccionada=="4784"){
					    capa.innerHTML="GESTION DE LAS COMUNICACIONES ";
					}else if(opcionSeleccionada=="4785"){
					    capa.innerHTML="GESTION DE MARKETING EN LA EMPRESA ";
					}else if(opcionSeleccionada=="4786"){
					    capa.innerHTML="GESTION DE OFICINA ";
					}else if(opcionSeleccionada=="4787"){
					    capa.innerHTML="GESTION DE PROYECTO ";
					}else if(opcionSeleccionada=="4788"){
					    capa.innerHTML="GESTION DEL AGROSISTEMA ";
					}else if(opcionSeleccionada=="4789"){
					    capa.innerHTML="GESTION EN EL TRABAJO ";
					}else if(opcionSeleccionada=="4718"){
					    capa.innerHTML="FRUTICULTURA II ";
					}else if(opcionSeleccionada=="4719"){
					    capa.innerHTML="FRUTICULTURA POST COSECHA ";
					}else if(opcionSeleccionada=="4721"){
					    capa.innerHTML="FUNCIONAMIENTO ORGANISMO ANIMAL ";
					}else if(opcionSeleccionada=="4722"){
					    capa.innerHTML="FUNCIONES NORFOSINTACTICAS ";
					}else if(opcionSeleccionada=="4723"){
					    capa.innerHTML="FUNDAMENTO DE MANTENCION ";
					}else if(opcionSeleccionada=="4724"){
					    capa.innerHTML="FUNDAMENTO DE OBSTETRICIA Y PUERICULTURA ";
					}else if(opcionSeleccionada=="4725"){
					    capa.innerHTML="FUNDAMENTO DE REDACCION Y DESARROLLO EXPRESION ORAL Y ESCRITA ";
					}else if(opcionSeleccionada=="4726"){
					    capa.innerHTML="FUNDAMENTOS DIF. HISTORIA Y CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="4728"){
					    capa.innerHTML="FUNDAMENTOS DE AGROECOLOGIA ";
					}else if(opcionSeleccionada=="4729"){
					    capa.innerHTML="FUNDAMENTOS DE COMPUTACION II ";
					}else if(opcionSeleccionada=="4730"){
					    capa.innerHTML="FUNDAMENTOS DE DISENO Y ARQUITECTURA ";
					}else if(opcionSeleccionada=="4731"){
					    capa.innerHTML="FUNDAMENTOS DE LA PRODUCCION VEGETAL ";
					}else if(opcionSeleccionada=="4732"){
					    capa.innerHTML="FUNDAMENTOS DE PSICOLOGIA GENERAL ";
					}else if(opcionSeleccionada=="4733"){
					    capa.innerHTML="FUNDAMENTOS DE PSICOLOGIA SOCIAL ";
					}else if(opcionSeleccionada=="4734"){
					    capa.innerHTML="FUNDAMENTOS DE VITICULTURA ";
					}else if(opcionSeleccionada=="4735"){
					    capa.innerHTML="FUNDAMENTOS DEL TURISMO II ";
					}else if(opcionSeleccionada=="4736"){
					    capa.innerHTML="FUNDAMENTOS DIF. EDUCACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="4737"){
					    capa.innerHTML="FUNDAMENTOS DIF. LENGUA CASTELLANA Y COMUNICACION ";
					}else if(opcionSeleccionada=="4738"){
					    capa.innerHTML="FUNDAMENTOS Y NOCIONES DE ECOLOGIA ";
					}else if(opcionSeleccionada=="4740"){
					    capa.innerHTML="GANADERIA AGRICOLA ";
					}else if(opcionSeleccionada=="4741"){
					    capa.innerHTML="GANADERIA BASICA ";
					}else if(opcionSeleccionada=="4742"){
					    capa.innerHTML="GANADERIA MAYOR ";
					}else if(opcionSeleccionada=="4743"){
					    capa.innerHTML="GANADERIA MENOR Y CUNICULTURA ";
					}else if(opcionSeleccionada=="4744"){
					    capa.innerHTML="GANADERIA Y LECHERIA ";
					}else if(opcionSeleccionada=="4745"){
					    capa.innerHTML="GASFITERIA Y SOLDADURA ";
					}else if(opcionSeleccionada=="4746"){
					    capa.innerHTML="GASTRONOMIA NACIONAL E INTERNACIONAL ";
					}else if(opcionSeleccionada=="4747"){
					    capa.innerHTML="GENETICA ";
					}else if(opcionSeleccionada=="4748"){
					    capa.innerHTML="GENETICA Y HERENCIA ";
					}else if(opcionSeleccionada=="4749"){
					    capa.innerHTML="GEOGRAFIA DE AMERICA ";
					}else if(opcionSeleccionada=="4750"){
					    capa.innerHTML="GEOGRAFIA DE AMERICA ANDINA ";
					}else if(opcionSeleccionada=="4751"){
					    capa.innerHTML="GEOGRAFIA DE AMERICA LATINA ";
					}else if(opcionSeleccionada=="4752"){
					    capa.innerHTML="GEOGRAFIA DEL PAISAJE CHILENO ";
					}else if(opcionSeleccionada=="4753"){
					    capa.innerHTML="GEOGRAFIA DESCRIPTIVA ";
					}else if(opcionSeleccionada=="4754"){
					    capa.innerHTML="GEOGRAFIA DESCRIPTIVA DE AMERICA LATINA ";
					}else if(opcionSeleccionada=="4678"){
					    capa.innerHTML="FORICULTURA Y PLANTAS ORNAMENTALES ";
					}else if(opcionSeleccionada=="4679"){
					    capa.innerHTML="FORMACION PROFESIONAL ";
					}else if(opcionSeleccionada=="4680"){
					    capa.innerHTML="FORMA DIFERENCIADA HISTORIA Y CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="4681"){
					    capa.innerHTML="FORMA DIFERENCIADA LENGUA CASTELLANA ";
					}else if(opcionSeleccionada=="4682"){
					    capa.innerHTML="FORMA DIFERENCIADA MATEMATICA ";
					}else if(opcionSeleccionada=="4683"){
					    capa.innerHTML="FORMACION DIFERENCIAL ARTES ";
					}else if(opcionSeleccionada=="4685"){
					    capa.innerHTML="FORMACION DIFERENCIAL CASTELLANO ";
					}else if(opcionSeleccionada=="4686"){
					    capa.innerHTML="FORMACION DIFERENCIAL EDUCACION FISICA ";
					}else if(opcionSeleccionada=="4687"){
					    capa.innerHTML="FORMACION DIFERENCIAL FISICA ";
					}else if(opcionSeleccionada=="4692"){
					    capa.innerHTML="FORMACION EMPRESARIAL ";
					}else if(opcionSeleccionada=="4693"){
					    capa.innerHTML="FORMACION HUMANA Y ESPIRITUAL ";
					}else if(opcionSeleccionada=="4694"){
					    capa.innerHTML="FORMACION MATEMATICA ";
					}else if(opcionSeleccionada=="4695"){
					    capa.innerHTML="FORMACION TECNICO PROFESIONAL ";
					}else if(opcionSeleccionada=="4696"){
					    capa.innerHTML="FORMACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="4697"){
					    capa.innerHTML="FORMACION VOCACIONAL ";
					}else if(opcionSeleccionada=="4698"){
					    capa.innerHTML="FORMACION Y DESARROLLO SUSTENTABLE ";
					}else if(opcionSeleccionada=="4699"){
					    capa.innerHTML="FORMACION Y ORIENTACION LABORAL ";
					}else if(opcionSeleccionada=="4700"){
					    capa.innerHTML="FORMATIVA COMERCIAL TRIBUTARIA ";
					}else if(opcionSeleccionada=="4701"){
					    capa.innerHTML="FORMULACION Y APLICACION DE PROYECTOS ";
					}else if(opcionSeleccionada=="4702"){
					    capa.innerHTML="FORMULACION Y ELABORACION DE PROYECTOS ";
					}else if(opcionSeleccionada=="4703"){
					    capa.innerHTML="FORRAJERAS ";
					}else if(opcionSeleccionada=="4704"){
					    capa.innerHTML="FORRAJERAS Y MANEJO DE PRADERAS ";
					}else if(opcionSeleccionada=="4705"){
					    capa.innerHTML="FOTOCOMPOSICION ";
					}else if(opcionSeleccionada=="4706"){
					    capa.innerHTML="FOTOGRAFIA DIAFRAGMA Y VIDEO CINE ";
					}else if(opcionSeleccionada=="4707"){
					    capa.innerHTML="FOTOGRAFIA Y DIAPORAMA ";
					}else if(opcionSeleccionada=="4708"){
					    capa.innerHTML="FOTOGRAFIA, DIAPORAMA , VIDEO Y CINE ";
					}else if(opcionSeleccionada=="4709"){
					    capa.innerHTML="FOTOINTERPRETACION FORESTAL ";
					}else if(opcionSeleccionada=="4710"){
					    capa.innerHTML="FOTOLIPOGRAFIA ";
					}else if(opcionSeleccionada=="4711"){
					    capa.innerHTML="FOTOLITOGRAFIA ";
					}else if(opcionSeleccionada=="4713"){
					    capa.innerHTML="FRUTALES ";
					}else if(opcionSeleccionada=="4714"){
					    capa.innerHTML="FRUTALES II ";
					}else if(opcionSeleccionada=="4715"){
					    capa.innerHTML="FRUTALES Y HORTALIZAS ";
					}else if(opcionSeleccionada=="4716"){
					    capa.innerHTML="FRUTALES Y TALLER DE PRACTICA ";
					}else if(opcionSeleccionada=="4717"){
					    capa.innerHTML="FRUTICULTURA I ";
					}else if(opcionSeleccionada=="4643"){
					    capa.innerHTML="FILOSOFIA 1 ";
					}else if(opcionSeleccionada=="4644"){
					    capa.innerHTML="FILOSOFIA 2 ";
					}else if(opcionSeleccionada=="4645"){
					    capa.innerHTML="FILOSOFIA ANTROPOLOGIA ";
					}else if(opcionSeleccionada=="4646"){
					    capa.innerHTML="FILOSOFIA DE LA EDUCACION ";
					}else if(opcionSeleccionada=="4647"){
					    capa.innerHTML="FILOSOFIA DE LA NINEZ ";
					}else if(opcionSeleccionada=="4648"){
					    capa.innerHTML="FILOSOFIA DE LAS CIENCIAS ";
					}else if(opcionSeleccionada=="4650"){
					    capa.innerHTML="FILOSOFIA DIFERENCIADA ";
					}else if(opcionSeleccionada=="4651"){
					    capa.innerHTML="FILOSOFIA FILOSOFIA ";
					}else if(opcionSeleccionada=="4652"){
					    capa.innerHTML="FILOSOFIA HUMANA ";
					}else if(opcionSeleccionada=="4653"){
					    capa.innerHTML="FILOSOFIA POLITICA ";
					}else if(opcionSeleccionada=="4654"){
					    capa.innerHTML="FILOSOFIA Y PSICOLOGIA 2 ";
					}else if(opcionSeleccionada=="4655"){
					    capa.innerHTML="FILOSOFIA Y PSICOLOGIA ELECTIVA ";
					}else if(opcionSeleccionada=="4656"){
					    capa.innerHTML="FILOSOFIA Y PSICOLOGIA FORMACION DIFERENCIADA HUMANISTICO CIENTIFICO TERCERO MEDIO ";
					}else if(opcionSeleccionada=="4657"){
					    capa.innerHTML="FISICA DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="4658"){
					    capa.innerHTML="FISICA DEPORTIVA ";
					}else if(opcionSeleccionada=="4659"){
					    capa.innerHTML="FISICA I - BIOLOGOS ";
					}else if(opcionSeleccionada=="4660"){
					    capa.innerHTML="FISICA I - MATEMATICOS ";
					}else if(opcionSeleccionada=="4661"){
					    capa.innerHTML="FISICA- INTRODUCCION A LA ELECTRICIDAD ";
					}else if(opcionSeleccionada=="4662"){
					    capa.innerHTML="FISICA MECANICA ELEMENTAL ";
					}else if(opcionSeleccionada=="4663"){
					    capa.innerHTML="FISICA MECANICA GENERAL ";
					}else if(opcionSeleccionada=="4664"){
					    capa.innerHTML="FISICA O QUIMICA ";
					}else if(opcionSeleccionada=="4665"){
					    capa.innerHTML="FISICA VECTORIAL ";
					}else if(opcionSeleccionada=="4666"){
					    capa.innerHTML="FISICA Y CALOR ";
					}else if(opcionSeleccionada=="4667"){
					    capa.innerHTML="FISICA Y FIS. ELECTIVA II ";
					}else if(opcionSeleccionada=="4668"){
					    capa.innerHTML="FISICA Y MECANICA GENERAL ";
					}else if(opcionSeleccionada=="4669"){
					    capa.innerHTML="FISICA Y QUIMICA DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="4670"){
					    capa.innerHTML="FISIOLOGIA ";
					}else if(opcionSeleccionada=="4671"){
					    capa.innerHTML="FISIOLOGIA DEL DEPORTE ";
					}else if(opcionSeleccionada=="4672"){
					    capa.innerHTML="FISIOLOGIA HUMANA Y SALUD ";
					}else if(opcionSeleccionada=="4673"){
					    capa.innerHTML="FISIOLOGIA VEGETAL ";
					}else if(opcionSeleccionada=="4674"){
					    capa.innerHTML="FISIOLOGIA Y BIOQUIMICA ";
					}else if(opcionSeleccionada=="4675"){
					    capa.innerHTML="FITOPATOLOGIA ";
					}else if(opcionSeleccionada=="4676"){
					    capa.innerHTML="FLORICULTURA Y PLANTAS ORNAMENTALES ";
					}else if(opcionSeleccionada=="4677"){
					    capa.innerHTML="FORESTACION ";
					}else if(opcionSeleccionada=="4604"){
					    capa.innerHTML="EVOLUCION GENERAL DE CHILE EN LA 2DA MITAD DEL SIGLO XX ";
					}else if(opcionSeleccionada=="4605"){
					    capa.innerHTML="EVOLUCION HISTORICA DE LA CULTURA CHILENA ";
					}else if(opcionSeleccionada=="4606"){
					    capa.innerHTML="EVOLUCION JURIDICA E INSTITUCIONAL ";
					}else if(opcionSeleccionada=="4607"){
					    capa.innerHTML="EVOLUCION POLITICA DE CHILE ";
					}else if(opcionSeleccionada=="4608"){
					    capa.innerHTML="EVOLUCION Y AMBIENTE ";
					}else if(opcionSeleccionada=="4609"){
					    capa.innerHTML="EVOLUCION Y COMPORTAMIENTO ANIMAL ";
					}else if(opcionSeleccionada=="4610"){
					    capa.innerHTML="EVOLUCION Y ECOLOGIA ";
					}else if(opcionSeleccionada=="4611"){
					    capa.innerHTML="EVOLUCION Y ECOLOGIA ANIMAL ";
					}else if(opcionSeleccionada=="4612"){
					    capa.innerHTML="EXPLORACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="4613"){
					    capa.innerHTML="EXPLORANDO EL MUNDO AGRICOLA ";
					}else if(opcionSeleccionada=="4614"){
					    capa.innerHTML="EXPLORANDO LITERATURA LA REGION DEL MAULE ";
					}else if(opcionSeleccionada=="4615"){
					    capa.innerHTML="EXPLOTACION Y MANEJO CASERO PRODUCCION PECUARIA ";
					}else if(opcionSeleccionada=="4616"){
					    capa.innerHTML="EXPRESION ARTISTICA Y ORNAMENTACION ";
					}else if(opcionSeleccionada=="4617"){
					    capa.innerHTML="EXPRESION CREATIVA PLASTICA ";
					}else if(opcionSeleccionada=="4618"){
					    capa.innerHTML="EXPRESION ESCRITA ";
					}else if(opcionSeleccionada=="4619"){
					    capa.innerHTML="EXPRESION FOLKLORICA ";
					}else if(opcionSeleccionada=="4620"){
					    capa.innerHTML="EXPRESION LENGUAJE ORAL Y ESCRITO ";
					}else if(opcionSeleccionada=="4621"){
					    capa.innerHTML="EXPRESION MUSICAL INTERCULTURAL ";
					}else if(opcionSeleccionada=="4622"){
					    capa.innerHTML="EXPRESION TEATRAL ";
					}else if(opcionSeleccionada=="4623"){
					    capa.innerHTML="EXPRESION VISUAL ";
					}else if(opcionSeleccionada=="4624"){
					    capa.innerHTML="EXPRESION Y REDACCION ";
					}else if(opcionSeleccionada=="4625"){
					    capa.innerHTML="EXTENSION AGRICOLA ";
					}else if(opcionSeleccionada=="4626"){
					    capa.innerHTML="EXTENSION RURAL Y TRANSFERENCIA TECNOLOGICA ";
					}else if(opcionSeleccionada=="4627"){
					    capa.innerHTML="FORMACION DIFERENCIAL INGLES ";
					}else if(opcionSeleccionada=="4628"){
					    capa.innerHTML="FORMACION DIFERENCIAL BIOLOGIA ";
					}else if(opcionSeleccionada=="4629"){
					    capa.innerHTML="FORMACION DIFERENCIAL HISTORIA ";
					}else if(opcionSeleccionada=="4631"){
					    capa.innerHTML="FORMACION DIFERENCIAL MATEMATICA ";
					}else if(opcionSeleccionada=="4632"){
					    capa.innerHTML="FORMACION DIFERENCIAL PSICOLOGIA ";
					}else if(opcionSeleccionada=="4633"){
					    capa.innerHTML="FORMACION DIFERENCIAL QUIMICA ";
					}else if(opcionSeleccionada=="4637"){
					    capa.innerHTML="FACTORES DE LA PRODUCCION ";
					}else if(opcionSeleccionada=="4639"){
					    capa.innerHTML="FARMACOLOGIA BASICA ";
					}else if(opcionSeleccionada=="4640"){
					    capa.innerHTML="FERTILIDAD Y FERTILIZANTES ";
					}else if(opcionSeleccionada=="4641"){
					    capa.innerHTML="FILOSOFIA DEL ARTE ";
					}else if(opcionSeleccionada=="4642"){
					    capa.innerHTML="FILOSOFIA - LOGICA FORMAL ";
					}else if(opcionSeleccionada=="4568"){
					    capa.innerHTML="ESTRUCTURA DE COSTOS ";
					}else if(opcionSeleccionada=="4569"){
					    capa.innerHTML="ESTRUCTURA DE DATOS Y ARCHIVO ";
					}else if(opcionSeleccionada=="4570"){
					    capa.innerHTML="ESTRUCTURA Y SISTEMAS COMPUTACIONALES ";
					}else if(opcionSeleccionada=="4572"){
					    capa.innerHTML="ESTUDIO A. COMPARATIVO: LAS EPOCAS HISTORICAS ";
					}else if(opcionSeleccionada=="4573"){
					    capa.innerHTML="ESTUDIO DEL INSTRUMENTO ";
					}else if(opcionSeleccionada=="4574"){
					    capa.innerHTML="ESTUDIO DEL MEDIO SOCIAL Y CULTURAL ";
					}else if(opcionSeleccionada=="4575"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DEL MEDIO NATURAL ";
					}else if(opcionSeleccionada=="4576"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DEL MEDIO SOCIAL ";
					}else if(opcionSeleccionada=="4577"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DEL MEDIO SOCIAL Y NATURAL ";
					}else if(opcionSeleccionada=="4578"){
					    capa.innerHTML="ESTUDIOS DE LA REALIDAD NACIONAL Y MUNDIAL ";
					}else if(opcionSeleccionada=="4579"){
					    capa.innerHTML="ESTUDIOS SOCIALES ";
					}else if(opcionSeleccionada=="4580"){
					    capa.innerHTML="ESTUDIOS SOCIALES II ";
					}else if(opcionSeleccionada=="4581"){
					    capa.innerHTML="ETICA EN ADMINISTRACION ";
					}else if(opcionSeleccionada=="4582"){
					    capa.innerHTML="ETICA PROFESIONAL PSICOLOGIA ";
					}else if(opcionSeleccionada=="4583"){
					    capa.innerHTML="ETICA PROFESIONAL RELACIONES HUMANAS Y PUBLICAS ";
					}else if(opcionSeleccionada=="4584"){
					    capa.innerHTML="ETICA PROFESIONAL Y PSICOLOGIA ";
					}else if(opcionSeleccionada=="4585"){
					    capa.innerHTML="ETICA TEORICA ";
					}else if(opcionSeleccionada=="4586"){
					    capa.innerHTML="ETICA TEORICA APLICADA ";
					}else if(opcionSeleccionada=="4587"){
					    capa.innerHTML="ETICA Y AXIOLOGIA ";
					}else if(opcionSeleccionada=="4588"){
					    capa.innerHTML="ETICA Y CONDUCTA PROFESIONAL ";
					}else if(opcionSeleccionada=="4589"){
					    capa.innerHTML="ETICA Y FORMACION VALORICA ";
					}else if(opcionSeleccionada=="4591"){
					    capa.innerHTML="ETICA Y LEGISLACION ";
					}else if(opcionSeleccionada=="4592"){
					    capa.innerHTML="ETICA Y ORIENTACION VOCACIONAL ";
					}else if(opcionSeleccionada=="4593"){
					    capa.innerHTML="ETICA Y RELACIONES ";
					}else if(opcionSeleccionada=="4594"){
					    capa.innerHTML="ETICA Y URBANIDAD ";
					}else if(opcionSeleccionada=="4595"){
					    capa.innerHTML="EVALUACION DE PROYECTOS ";
					}else if(opcionSeleccionada=="4596"){
					    capa.innerHTML="EVALUACION SENSORIAL ";
					}else if(opcionSeleccionada=="4597"){
					    capa.innerHTML="EVOLUCION ";
					}else if(opcionSeleccionada=="4598"){
					    capa.innerHTML="EVOLUCION AMERICA LATINA CONTINENTAL II ";
					}else if(opcionSeleccionada=="4599"){
					    capa.innerHTML="EVOLUCION AMERICA LATINA CONTINENTAL I ";
					}else if(opcionSeleccionada=="4600"){
					    capa.innerHTML="EVOLUCION CONSTITUCIONAL CHILENA ";
					}else if(opcionSeleccionada=="4601"){
					    capa.innerHTML="EVOLUCION DE CHILE EN EL SIGLO XX ";
					}else if(opcionSeleccionada=="4602"){
					    capa.innerHTML="EVOLUCION ECOLOGIA ";
					}else if(opcionSeleccionada=="4603"){
					    capa.innerHTML="EVOLUCION ECOLOGIA Y AMBIENTE (ELECTIVO 3) ";
					}else if(opcionSeleccionada=="4531"){
					    capa.innerHTML="ELEMENTOS DE ANATOMIA HUMANA ";
					}else if(opcionSeleccionada=="4532"){
					    capa.innerHTML="ELEMENTOS DE CALCULOS ";
					}else if(opcionSeleccionada=="4533"){
					    capa.innerHTML="ELEMENTOS DE COMPUTACION II ";
					}else if(opcionSeleccionada=="4535"){
					    capa.innerHTML="ELEMENTOS DE ECONOMIA Y COMERCIO ";
					}else if(opcionSeleccionada=="4536"){
					    capa.innerHTML="ELEMENTOS DE ESTADISTICA ";
					}else if(opcionSeleccionada=="4537"){
					    capa.innerHTML="ELEMENTOS DE GEOPOLITICA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="4538"){
					    capa.innerHTML="ELEMENTOS DE MATEMATICAS UNIVERSITARIA ";
					}else if(opcionSeleccionada=="4539"){
					    capa.innerHTML="ELEMENTOS DERECHO CIVIL, PENAL Y LABORAL ";
					}else if(opcionSeleccionada=="4540"){
					    capa.innerHTML="ELEMENTOS EN COMUNICACION ";
					}else if(opcionSeleccionada=="4541"){
					    capa.innerHTML="ELEMENTOS PARA LA PRACTICA ";
					}else if(opcionSeleccionada=="4542"){
					    capa.innerHTML="EMERGENCIA MEDICO QUIRURGICA ";
					}else if(opcionSeleccionada=="4543"){
					    capa.innerHTML="EMPASTADAS ";
					}else if(opcionSeleccionada=="4544"){
					    capa.innerHTML="ENCOLOGIA ";
					}else if(opcionSeleccionada=="4545"){
					    capa.innerHTML="ENFERMEDADES ";
					}else if(opcionSeleccionada=="4546"){
					    capa.innerHTML="ENFERMEDADES TRANSMISIBLES ";
					}else if(opcionSeleccionada=="4547"){
					    capa.innerHTML="ENFERMERIA ";
					}else if(opcionSeleccionada=="4548"){
					    capa.innerHTML="ENFERMERIA Y KINESIOLOGIA ";
					}else if(opcionSeleccionada=="4549"){
					    capa.innerHTML="ENTRADA FRIAS Y CALIENTES Y PRODUCTOS PARA COCTEL ";
					}else if(opcionSeleccionada=="4550"){
					    capa.innerHTML="ENTRENAMIENTO DE LA CONDICION MINIMA ";
					}else if(opcionSeleccionada=="4552"){
					    capa.innerHTML="EPISTEMOLOGIA ";
					}else if(opcionSeleccionada=="4553"){
					    capa.innerHTML="EQUIPOS DE VIDEOS ";
					}else if(opcionSeleccionada=="4554"){
					    capa.innerHTML="EQUIPOS E INSTRUMENTOS ";
					}else if(opcionSeleccionada=="4555"){
					    capa.innerHTML="EQUIPOS INDUSTRIALES ";
					}else if(opcionSeleccionada=="4557"){
					    capa.innerHTML="ESPECIALIZACION Y ADMINISTRACION DEPORTIVA ";
					}else if(opcionSeleccionada=="4558"){
					    capa.innerHTML="ESPECTROSCOPIA ";
					}else if(opcionSeleccionada=="4559"){
					    capa.innerHTML="ESPIRITUALIDAD SALESIANA ";
					}else if(opcionSeleccionada=="4560"){
					    capa.innerHTML="ESTUDIO Y ANALISIS DE LOS TEJIDOS ";
					}else if(opcionSeleccionada=="4561"){
					    capa.innerHTML="ESTABILIDAD ";
					}else if(opcionSeleccionada=="4562"){
					    capa.innerHTML="ESTADISTICA ELEMENTAL COMPUTACIONAL ";
					}else if(opcionSeleccionada=="4563"){
					    capa.innerHTML="ESTETICA Y MODELAJE SOCIAL ";
					}else if(opcionSeleccionada=="4564"){
					    capa.innerHTML="ESTIBA Y DESESTIBA ";
					}else if(opcionSeleccionada=="4565"){
					    capa.innerHTML="ESTIBA Y DESESTIBA DE NAVES MERCANTES ";
					}else if(opcionSeleccionada=="4566"){
					    capa.innerHTML="ESTRATEGIA DE COMUNICACION ";
					}else if(opcionSeleccionada=="4567"){
					    capa.innerHTML="ESTRUCTURA DE COMPUTADORES ";
					}else if(opcionSeleccionada=="4493"){
					    capa.innerHTML="ELECTIVO SOCIALES ";
					}else if(opcionSeleccionada=="4494"){
					    capa.innerHTML="ELECTIVO Y COMPUTACION ";
					}else if(opcionSeleccionada=="4495"){
					    capa.innerHTML="ELECTIVO1 ";
					}else if(opcionSeleccionada=="4496"){
					    capa.innerHTML="ELECTIVO2 ";
					}else if(opcionSeleccionada=="4497"){
					    capa.innerHTML="ELECTIVOS ARTISTICOS ARTES MANUALES ";
					}else if(opcionSeleccionada=="4498"){
					    capa.innerHTML="ELECTIVOS ARTISTICOS ARTES PLASTICAS ";
					}else if(opcionSeleccionada=="4499"){
					    capa.innerHTML="ELECTIVOS ARTISTICOS MUSICA ";
					}else if(opcionSeleccionada=="4500"){
					    capa.innerHTML="ELECTRICIDAD APLICADA A MOTORES ";
					}else if(opcionSeleccionada=="4501"){
					    capa.innerHTML="ELECTRICIDAD BASICA Y MANUALIDADES ";
					}else if(opcionSeleccionada=="4502"){
					    capa.innerHTML="ELECTRICIDAD DE AUTOMOVIL ";
					}else if(opcionSeleccionada=="4503"){
					    capa.innerHTML="ELECTRICIDAD DE SEMICONDUCTORES ";
					}else if(opcionSeleccionada=="4505"){
					    capa.innerHTML="ELECTRICIDAD DOMICILIARIA ";
					}else if(opcionSeleccionada=="4506"){
					    capa.innerHTML="ELECTRICIDAD EN EL HOGAR ";
					}else if(opcionSeleccionada=="4507"){
					    capa.innerHTML="ELECTRICIDAD I ";
					}else if(opcionSeleccionada=="4508"){
					    capa.innerHTML="ELECTRICIDAD II ";
					}else if(opcionSeleccionada=="4509"){
					    capa.innerHTML="ELECTRICIDAD III ";
					}else if(opcionSeleccionada=="4510"){
					    capa.innerHTML="ELECTRICIDAD IV ";
					}else if(opcionSeleccionada=="4511"){
					    capa.innerHTML="ELECTRICIDAD PRACTICA ";
					}else if(opcionSeleccionada=="4513"){
					    capa.innerHTML="ELECTRICIDAD Y ELECTRONICA EN EL HOGAR ";
					}else if(opcionSeleccionada=="4514"){
					    capa.innerHTML="ELECTRICIDAD Y MAGNETISMO ";
					}else if(opcionSeleccionada=="4515"){
					    capa.innerHTML="ELECTRO-FISICA APLICADA ";
					}else if(opcionSeleccionada=="4517"){
					    capa.innerHTML="ELECTRONICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="4518"){
					    capa.innerHTML="ELECTRONICA BASICA ";
					}else if(opcionSeleccionada=="4519"){
					    capa.innerHTML="ELECTRONICA BASICA I ";
					}else if(opcionSeleccionada=="4520"){
					    capa.innerHTML="ELECTRONICA COMPUTACIONAL ";
					}else if(opcionSeleccionada=="4521"){
					    capa.innerHTML="ELECTRONICA DE TELECOMUNICACIONES ";
					}else if(opcionSeleccionada=="4522"){
					    capa.innerHTML="ELECTRONICA INTEGRADA ";
					}else if(opcionSeleccionada=="4524"){
					    capa.innerHTML="ELECTROQUIMICA ";
					}else if(opcionSeleccionada=="4525"){
					    capa.innerHTML="ELECTROTECNIA Y AUTOMATIZACION INDUSTRIAL ";
					}else if(opcionSeleccionada=="4526"){
					    capa.innerHTML="ELEMENTO DE DERECHO CIVIL Y PENAL CHILENO ";
					}else if(opcionSeleccionada=="4527"){
					    capa.innerHTML="ELEMENTO DE FRUTICULTURA ";
					}else if(opcionSeleccionada=="4528"){
					    capa.innerHTML="ELEMENTOS DE DERECHO CIVIL, PENAL Y LABORAL ";
					}else if(opcionSeleccionada=="4529"){
					    capa.innerHTML="ELEMENTOS BASICOS DE CARPINTERIA ";
					}else if(opcionSeleccionada=="4530"){
					    capa.innerHTML="ELEMENTOS BASICOS DE CONTABILIDAD ";
					}else if(opcionSeleccionada=="4451"){
					    capa.innerHTML="ELECTIVO ARTES 2 ";
					}else if(opcionSeleccionada=="4452"){
					    capa.innerHTML="ELECTIVO ARTES PLASTICAS ";
					}else if(opcionSeleccionada=="4453"){
					    capa.innerHTML="ELECTIVO ARTISTICO ";
					}else if(opcionSeleccionada=="4454"){
					    capa.innerHTML="ELECTIVO BIOLOGIA Y ECOLOGIA ";
					}else if(opcionSeleccionada=="4456"){
					    capa.innerHTML="ELECTIVO CIENCIAS ";
					}else if(opcionSeleccionada=="4457"){
					    capa.innerHTML="ELECTIVO CIENCIAS SOCIALES Y REALIDAD NACIONAL ";
					}else if(opcionSeleccionada=="4458"){
					    capa.innerHTML="ELECTIVO CIENTIFICO 1 ";
					}else if(opcionSeleccionada=="4459"){
					    capa.innerHTML="ELECTIVO CIENTIFICO 2 ";
					}else if(opcionSeleccionada=="4460"){
					    capa.innerHTML="ELECTIVO COMPUTACION ";
					}else if(opcionSeleccionada=="4463"){
					    capa.innerHTML="ELECTIVO DE ARTE ";
					}else if(opcionSeleccionada=="4464"){
					    capa.innerHTML="ELECTIVO DE BIOQUIMICA ";
					}else if(opcionSeleccionada=="4467"){
					    capa.innerHTML="ELECTIVO DE CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="4469"){
					    capa.innerHTML="ELECTIVO DE DACTILOGRAFIA ";
					}else if(opcionSeleccionada=="4470"){
					    capa.innerHTML="ELECTIVO DE EDUCACION POR EL ARTE ";
					}else if(opcionSeleccionada=="4471"){
					    capa.innerHTML="ELECTIVO DE GEOGRAFIA ";
					}else if(opcionSeleccionada=="4472"){
					    capa.innerHTML="ELECTIVO DE INGLES ";
					}else if(opcionSeleccionada=="4473"){
					    capa.innerHTML="ELECTIVO DE PSICOLOGIA ";
					}else if(opcionSeleccionada=="4474"){
					    capa.innerHTML="ELECTIVO EVOLUCION, ECOLOGIA Y AMBIENTE ";
					}else if(opcionSeleccionada=="4476"){
					    capa.innerHTML="ELECTIVO FILOSOFIA ";
					}else if(opcionSeleccionada=="4477"){
					    capa.innerHTML="ELECTIVO FILOSOFIA Y PSICOLOGIA ";
					}else if(opcionSeleccionada=="4478"){
					    capa.innerHTML="ELECTIVO GEOMETRIA ANALITICA PLANA ";
					}else if(opcionSeleccionada=="4479"){
					    capa.innerHTML="ELECTIVO HUMANISTA 1 ";
					}else if(opcionSeleccionada=="4480"){
					    capa.innerHTML="ELECTIVO HUMANISTA 2 ";
					}else if(opcionSeleccionada=="4481"){
					    capa.innerHTML="ELECTIVO I ";
					}else if(opcionSeleccionada=="4482"){
					    capa.innerHTML="ELECTIVO II ";
					}else if(opcionSeleccionada=="4484"){
					    capa.innerHTML="ELECTIVO INGLES SOCIAL COMUNICATIVO ";
					}else if(opcionSeleccionada=="4485"){
					    capa.innerHTML="ELECTIVO INTERDICIPLINARIO ";
					}else if(opcionSeleccionada=="4486"){
					    capa.innerHTML="ELECTIVO LENGUA ";
					}else if(opcionSeleccionada=="4487"){
					    capa.innerHTML="ELECTIVO LENGUAJE ";
					}else if(opcionSeleccionada=="4488"){
					    capa.innerHTML="ELECTIVO LENGUAJE Y SOCIEDAD ";
					}else if(opcionSeleccionada=="4489"){
					    capa.innerHTML="ELECTIVO LITERATURA ";
					}else if(opcionSeleccionada=="4490"){
					    capa.innerHTML="ELECTIVO LITERATURA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="4491"){
					    capa.innerHTML="ELECTIVO ORIGENES E HISTORIA DE LA QUIMICA ";
					}else if(opcionSeleccionada=="4492"){
					    capa.innerHTML="ELECTIVO SICOLOGIA ";
					}else if(opcionSeleccionada=="4410"){
					    capa.innerHTML="ELABORACION DE MATERIALES ";
					}else if(opcionSeleccionada=="4411"){
					    capa.innerHTML="ELABORACION DE PRODUCTOS AGROPECUARIOS ";
					}else if(opcionSeleccionada=="4412"){
					    capa.innerHTML="ELABORACION DE PROYECTOS ";
					}else if(opcionSeleccionada=="4413"){
					    capa.innerHTML="ELABORACION PRODUCTOS HORTOFRUTICOLAS ";
					}else if(opcionSeleccionada=="4415"){
					    capa.innerHTML="ELABORACION Y COMERCIALIZACION ";
					}else if(opcionSeleccionada=="4416"){
					    capa.innerHTML="ELABORACION Y CONTROL DE CALIDAD DE PRODUCTOS PESQUEROS ";
					}else if(opcionSeleccionada=="4417"){
					    capa.innerHTML="ELABORACION Y EVALUACION DE PROYECTO ";
					}else if(opcionSeleccionada=="4420"){
					    capa.innerHTML="ELABORACION Y PRESENTACION DE ALIMENTOS ";
					}else if(opcionSeleccionada=="4421"){
					    capa.innerHTML="ELABORACION Y PROCESAMIENTO DE LA VIDA ";
					}else if(opcionSeleccionada=="4424"){
					    capa.innerHTML="ELECTIVO BASICA ";
					}else if(opcionSeleccionada=="4425"){
					    capa.innerHTML="ELECTIVO CASTELLANO ";
					}else if(opcionSeleccionada=="4426"){
					    capa.innerHTML="ELECTIVO GEOGRAFIA ";
					}else if(opcionSeleccionada=="4427"){
					    capa.innerHTML="ELECTIVO HACIA EL DESARROLLO ECONOMICO ";
					}else if(opcionSeleccionada=="4428"){
					    capa.innerHTML="ELECTIVO ECONOMIA Y CONSUMO ";
					}else if(opcionSeleccionada=="4429"){
					    capa.innerHTML="ELECTIVO PSICOLOGIA ";
					}else if(opcionSeleccionada=="4430"){
					    capa.innerHTML="ELECTIVO RECURSOS NATURALES ";
					}else if(opcionSeleccionada=="4431"){
					    capa.innerHTML="ELECTRICIDAD Y COMPUTACION ";
					}else if(opcionSeleccionada=="4432"){
					    capa.innerHTML="ELECTRICIDAD Y LABORATORIO ";
					}else if(opcionSeleccionada=="4433"){
					    capa.innerHTML="ELECTRICIDAD Y COMUNICACION NAVAL ";
					}else if(opcionSeleccionada=="4435"){
					    capa.innerHTML="ELECTIVO EDUCACION MUSICAL ";
					}else if(opcionSeleccionada=="4436"){
					    capa.innerHTML="ELECTIVO GEOGRAFIA FISICA ";
					}else if(opcionSeleccionada=="4437"){
					    capa.innerHTML="ELECTIVO INGLES ";
					}else if(opcionSeleccionada=="4439"){
					    capa.innerHTML="ELECTIVO 1 ";
					}else if(opcionSeleccionada=="4440"){
					    capa.innerHTML="ELECTIVO 2 ";
					}else if(opcionSeleccionada=="4441"){
					    capa.innerHTML="ELECTIVO 3 ";
					}else if(opcionSeleccionada=="4442"){
					    capa.innerHTML="ELECTIVO 4 ";
					}else if(opcionSeleccionada=="4443"){
					    capa.innerHTML="ELECTIVO 5 ";
					}else if(opcionSeleccionada=="4444"){
					    capa.innerHTML="ELECTIVO 6 ";
					}else if(opcionSeleccionada=="4445"){
					    capa.innerHTML="ELECTIVO 7 ";
					}else if(opcionSeleccionada=="4446"){
					    capa.innerHTML="ELECTIVO 8 ";
					}else if(opcionSeleccionada=="4447"){
					    capa.innerHTML="ELECTIVO ALGEBRA ";
					}else if(opcionSeleccionada=="4448"){
					    capa.innerHTML="ELECTIVO ALGEBRA Y MODELOS ANALITICOS ";
					}else if(opcionSeleccionada=="4449"){
					    capa.innerHTML="ELECTIVO ARQUITECTURA COLONIAL ";
					}else if(opcionSeleccionada=="4450"){
					    capa.innerHTML="ELECTIVO ARTES 1 ";
					}else if(opcionSeleccionada=="4370"){
					    capa.innerHTML="EDUCACION TECNICA MECANICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="4371"){
					    capa.innerHTML="EDUCACION TECNICO MANUAL Y ARTES PLASTICAS ";
					}else if(opcionSeleccionada=="4372"){
					    capa.innerHTML="EDUCACION TECNICO MANUAL Y HUERTOS FAMILIARES ";
					}else if(opcionSeleccionada=="4373"){
					    capa.innerHTML="EDUCACION TECNOLOGICA (COMPUTACION) ";
					}else if(opcionSeleccionada=="4374"){
					    capa.innerHTML="EDUCACION TECNOLOGICA (TEC.MANUAL) ";
					}else if(opcionSeleccionada=="4375"){
					    capa.innerHTML="EDUCACION TECNOLOGICA (PD) ";
					}else if(opcionSeleccionada=="4376"){
					    capa.innerHTML="EDUCACION TECNOLOGICA ARTES VISUALES Y MANUAL ";
					}else if(opcionSeleccionada=="4377"){
					    capa.innerHTML="EDUCACION TECNOLOGICA DIFERENCIADA ";
					}else if(opcionSeleccionada=="4378"){
					    capa.innerHTML="EDUCACION TECNOLOGICA ELECTIVO ";
					}else if(opcionSeleccionada=="4379"){
					    capa.innerHTML="EDUCACION TECNOLOGICA I ";
					}else if(opcionSeleccionada=="4380"){
					    capa.innerHTML="EDUCACION TECNOLOGICA II ";
					}else if(opcionSeleccionada=="4381"){
					    capa.innerHTML="EDUCACION TECNOLOGICA Y MANUALIDADES ";
					}else if(opcionSeleccionada=="4382"){
					    capa.innerHTML="EDUCACION TECNOLOGICA (PROYECTO DE INTEGRACION) ";
					}else if(opcionSeleccionada=="4383"){
					    capa.innerHTML="EDUCACION VISUAL ";
					}else if(opcionSeleccionada=="4384"){
					    capa.innerHTML="EDUCACION VOCACIONAL ";
					}else if(opcionSeleccionada=="4385"){
					    capa.innerHTML="EL ADVENIMIENTO DE UNA NUEVA EPOCA ";
					}else if(opcionSeleccionada=="4386"){
					    capa.innerHTML="EL ARTE Y LA INFORM. ";
					}else if(opcionSeleccionada=="4387"){
					    capa.innerHTML="EL CUENTO Y LA PLASTICA ";
					}else if(opcionSeleccionada=="4388"){
					    capa.innerHTML="EL CUIDADO DEL ENFERMO Y DEL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="4390"){
					    capa.innerHTML="EL DESARROLLO PERSONAL INTEG. Y LA ORIENTACION TECNICO PROFESIONAL ";
					}else if(opcionSeleccionada=="4391"){
					    capa.innerHTML="EL DISENO EN EL PLAN Y VOLUMEN ";
					}else if(opcionSeleccionada=="4392"){
					    capa.innerHTML="EL DISENO EN EL PLANO Y VOLUMEN ";
					}else if(opcionSeleccionada=="4393"){
					    capa.innerHTML="EL EMPLEO DE LAS MATEMATICAS Y LA RELACION CON OTRAS ASIGNATURAS";
					}else if(opcionSeleccionada=="4394"){
					    capa.innerHTML="EL JUEGO COMO ENTRETENCION ";
					}else if(opcionSeleccionada=="4395"){
					    capa.innerHTML="EL MARCO GEOGRAFICO Y LA HISTORIA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="4396"){
					    capa.innerHTML="EL MEDIO SOCIAL Y SUS INTERACCIONES EN MEDIO FISICO ";
					}else if(opcionSeleccionada=="4397"){
					    capa.innerHTML="EL MUNDO CONTEMPORANEO ";
					}else if(opcionSeleccionada=="4398"){
					    capa.innerHTML="EL MUNDO DE LA POSTGUERRA ";
					}else if(opcionSeleccionada=="4399"){
					    capa.innerHTML="EL MUNDO DEL ARTE ";
					}else if(opcionSeleccionada=="4400"){
					    capa.innerHTML="EL TEATRO UN ACTO DE VIDA EN EL ESPACIO ";
					}else if(opcionSeleccionada=="4401"){
					    capa.innerHTML="EL VENDEDOR Y EL SERVICIO AL CLIENTE ";
					}else if(opcionSeleccionada=="4404"){
					    capa.innerHTML="ELABORACION DE COMPONENTES DE CARPINTERIA Y MADERA ";
					}else if(opcionSeleccionada=="4405"){
					    capa.innerHTML="ELABORACION DE DISENO ";
					}else if(opcionSeleccionada=="4409"){
					    capa.innerHTML="ELABORACION DE LA MADERA ";
					}else if(opcionSeleccionada=="4334"){
					    capa.innerHTML="ECONOMIA Y CONSUMO ";
					}else if(opcionSeleccionada=="4335"){
					    capa.innerHTML="ECONOMIA Y CONTABILIDAD ";
					}else if(opcionSeleccionada=="4336"){
					    capa.innerHTML="ECONOMIA Y ESTADISTICA ";
					}else if(opcionSeleccionada=="4337"){
					    capa.innerHTML="ECONOMIA Y FINANZAS ";
					}else if(opcionSeleccionada=="4338"){
					    capa.innerHTML="ECONOMIA Y LEGISLACION SILVOAGROPECUARIA ";
					}else if(opcionSeleccionada=="4339"){
					    capa.innerHTML="ECONOMIA Y MERCADO ";
					}else if(opcionSeleccionada=="4340"){
					    capa.innerHTML="ECONOMIA, CONTABILIDAD AGRICOLA ";
					}else if(opcionSeleccionada=="4341"){
					    capa.innerHTML="ECOTURISMO ";
					}else if(opcionSeleccionada=="4342"){
					    capa.innerHTML="EDAFOLOGIA ";
					}else if(opcionSeleccionada=="4343"){
					    capa.innerHTML="EDUCACION PSICOMOTRIZ Y MOTORA POSTURAL ";
					}else if(opcionSeleccionada=="4344"){
					    capa.innerHTML="EDUCACION TECNOLOGICA: LAS ORGANIZACIONES Y EL TRABAJO ";
					}else if(opcionSeleccionada=="4346"){
					    capa.innerHTML="EDUCACION ";
					}else if(opcionSeleccionada=="4347"){
					    capa.innerHTML="EDUCACION ARTISTICA: ARTES ";
					}else if(opcionSeleccionada=="4348"){
					    capa.innerHTML="EDUCACION ARTISTICA: ARTES VISUALES ";
					}else if(opcionSeleccionada=="4350"){
					    capa.innerHTML="EDUCACION CIVICA COMUNAL ";
					}else if(opcionSeleccionada=="4351"){
					    capa.innerHTML="EDUCACION CIVICA E INTRODUCCION AL DERECHO ";
					}else if(opcionSeleccionada=="4352"){
					    capa.innerHTML="EDUCACION COMPLEMENTARIA ";
					}else if(opcionSeleccionada=="4353"){
					    capa.innerHTML="EDUCACION DE LA PERSONALIDAD ";
					}else if(opcionSeleccionada=="4354"){
					    capa.innerHTML="EDUCACION DE LOS VALORES HUMANOS CRISTIANOS ";
					}else if(opcionSeleccionada=="4355"){
					    capa.innerHTML="EDUCACION DEL TIEMPO LIBRE ";
					}else if(opcionSeleccionada=="4356"){
					    capa.innerHTML="EDUCACION DIFERENCIAL Y TEC. PSICOPEDAGOGICAS ";
					}else if(opcionSeleccionada=="4357"){
					    capa.innerHTML="EDUCACION ECOLOGIA Y AMBIENTE ";
					}else if(opcionSeleccionada=="4358"){
					    capa.innerHTML="EDUCACION EN EL PENSAR ";
					}else if(opcionSeleccionada=="4359"){
					    capa.innerHTML="EDUCACION FISICA DAMAS ";
					}else if(opcionSeleccionada=="4360"){
					    capa.innerHTML="EDUCACION FISICA VARONES ";
					}else if(opcionSeleccionada=="4361"){
					    capa.innerHTML="EDUCACION FORESTAL ";
					}else if(opcionSeleccionada=="4362"){
					    capa.innerHTML="EDUCACION INFANTIL ";
					}else if(opcionSeleccionada=="4363"){
					    capa.innerHTML="EDUCACION MATEMATICA (ARITMETICA) ";
					}else if(opcionSeleccionada=="4364"){
					    capa.innerHTML="EDUCACION PARA EL AMOR Y LA SEXUALIDAD ";
					}else if(opcionSeleccionada=="4365"){
					    capa.innerHTML="EDUCACION PARA EL HOGAR Y LA FAMILIA ";
					}else if(opcionSeleccionada=="4366"){
					    capa.innerHTML="EDUCACION PARA LA SEXUALIDAD ";
					}else if(opcionSeleccionada=="4367"){
					    capa.innerHTML="EDUCACION PERSONALIDAD ";
					}else if(opcionSeleccionada=="4368"){
					    capa.innerHTML="EDUCACION PSICOPEDAGOGICAS ";
					}else if(opcionSeleccionada=="4369"){
					    capa.innerHTML="EDUCACION TECNICA ";
					}else if(opcionSeleccionada=="4296"){
					    capa.innerHTML="DISENO TEXTIL ";
					}else if(opcionSeleccionada=="4297"){
					    capa.innerHTML="DISENO URBANISTICO ";
					}else if(opcionSeleccionada=="4298"){
					    capa.innerHTML="DISENO VESTUARIO Y ESTETICA II ";
					}else if(opcionSeleccionada=="4299"){
					    capa.innerHTML="DISENO Y CREACION ARTISTICA ";
					}else if(opcionSeleccionada=="4300"){
					    capa.innerHTML="DISENO Y DECORACION DE MUEBLES ";
					}else if(opcionSeleccionada=="4301"){
					    capa.innerHTML="DISENO Y DIBUJO TECNICO ";
					}else if(opcionSeleccionada=="4302"){
					    capa.innerHTML="DISENO Y ESTETICA ";
					}else if(opcionSeleccionada=="4303"){
					    capa.innerHTML="DISENO Y ESTETICA DEL VESTUARIO ";
					}else if(opcionSeleccionada=="4304"){
					    capa.innerHTML="DISENO Y EVALUACION DE PROYECTO SOCIAL ";
					}else if(opcionSeleccionada=="4305"){
					    capa.innerHTML="DISENO Y MANTENCION DE SISTEMAS DE CONTROL ELECTRONICO ";
					}else if(opcionSeleccionada=="4306"){
					    capa.innerHTML="DISENO Y PROYECTO DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="4307"){
					    capa.innerHTML="DISENO Y TRANSFORMACION DE PRENDAS DE VESTIR ";
					}else if(opcionSeleccionada=="4308"){
					    capa.innerHTML="DISENO, CORTE Y MODELAJE ";
					}else if(opcionSeleccionada=="4309"){
					    capa.innerHTML="DISENO, VESTUARIO Y ESTETICA ";
					}else if(opcionSeleccionada=="4310"){
					    capa.innerHTML="DISENOS Y PROYECTOS ";
					}else if(opcionSeleccionada=="4312"){
					    capa.innerHTML="DISTRIBUCION FISICA INTERNA ";
					}else if(opcionSeleccionada=="4313"){
					    capa.innerHTML="DIVULGACION CIENTIFICA Y TECNOLOGICA ";
					}else if(opcionSeleccionada=="4315"){
					    capa.innerHTML="DOCUMENTACION Y ARCHIVOS ";
					}else if(opcionSeleccionada=="4316"){
					    capa.innerHTML="DOCUMENTACION ";
					}else if(opcionSeleccionada=="4317"){
					    capa.innerHTML="DOCUMENTACION COMERCIAL Y NOCIONES DE CONTABILIDAD ";
					}else if(opcionSeleccionada=="4318"){
					    capa.innerHTML="DOCUMENTACION MARITIMO PORTUARIA ";
					}else if(opcionSeleccionada=="4320"){
					    capa.innerHTML="DOCUMENTOS COMERCIALES Y NOCIONES DE CONTABILIDAD ";
					}else if(opcionSeleccionada=="4321"){
					    capa.innerHTML="DOMOGRAFIA Y RECURSOS ECONOMICOS DE LA REGION ";
					}else if(opcionSeleccionada=="4322"){
					    capa.innerHTML="ECOLOGIA EVOLUCION Y MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="4323"){
					    capa.innerHTML="ECOLOGIA HUMANA ";
					}else if(opcionSeleccionada=="4324"){
					    capa.innerHTML="ECOLOGIA SILVO AGROPECUARIA ";
					}else if(opcionSeleccionada=="4325"){
					    capa.innerHTML="ECOLOGIA Y CONSERVACION DE RECURSOS NATURALES ";
					}else if(opcionSeleccionada=="4326"){
					    capa.innerHTML="ECOLOGIA Y EVOLUCION ORGANICA ";
					}else if(opcionSeleccionada=="4327"){
					    capa.innerHTML="ECOLOGIA Y NATURALEZA ";
					}else if(opcionSeleccionada=="4328"){
					    capa.innerHTML="ECOLOGIA Y PROTECCION DEL MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="4330"){
					    capa.innerHTML="ECOLOGIA, HIGIENE Y SANIDAD INDUSTRIAL ";
					}else if(opcionSeleccionada=="4331"){
					    capa.innerHTML="ECONOMIA DOMESTICA ";
					}else if(opcionSeleccionada=="4332"){
					    capa.innerHTML="ECONOMIA INTERNACIONAL ";
					}else if(opcionSeleccionada=="4333"){
					    capa.innerHTML="ECONOMIA Y ADMINISTRACION DE EMPRESAS ";
					}else if(opcionSeleccionada=="4253"){
					    capa.innerHTML="DIFERENCIADA EDUCACION TECNOLOGICA F.D. ";
					}else if(opcionSeleccionada=="4254"){
					    capa.innerHTML="DIFERENCIADA EVOLUCION, ECOLOGIA Y AMBIENTE ";
					}else if(opcionSeleccionada=="4256"){
					    capa.innerHTML="DIFERENCIADA MECANICA ";
					}else if(opcionSeleccionada=="4257"){
					    capa.innerHTML="DIFERENCIADO 1 ";
					}else if(opcionSeleccionada=="4258"){
					    capa.innerHTML="DIFERENCIADO 2 ";
					}else if(opcionSeleccionada=="4259"){
					    capa.innerHTML="DIFERENCIADO 3 ";
					}else if(opcionSeleccionada=="4260"){
					    capa.innerHTML="DIFERENCIAL FILOSOFIA ";
					}else if(opcionSeleccionada=="4261"){
					    capa.innerHTML="DIGITACION MANEJO RECURSOS INFORMATICOS ";
					}else if(opcionSeleccionada=="4262"){
					    capa.innerHTML="DIGITACION APLICADA ";
					}else if(opcionSeleccionada=="4263"){
					    capa.innerHTML="DIMENSIONAMIENTO DE SISTEMAS DE CULTIVOS ";
					}else if(opcionSeleccionada=="4264"){
					    capa.innerHTML="DIMENSIONAMIENTO Y CONSTRUCCION DE SISTEMA ";
					}else if(opcionSeleccionada=="4269"){
					    capa.innerHTML="DINAMISMO Y EVOLUCION FISICO SOCIAL ";
					}else if(opcionSeleccionada=="4270"){
					    capa.innerHTML="DIRIGENTE DEPORTIVO ";
					}else if(opcionSeleccionada=="4273"){
					    capa.innerHTML="DIS. Y EV. SOCIOEDUCATIVA ";
					}else if(opcionSeleccionada=="4274"){
					    capa.innerHTML="DISENO APLICADO DE VESTUARIO ";
					}else if(opcionSeleccionada=="4275"){
					    capa.innerHTML="DISENO ARTESANAL ";
					}else if(opcionSeleccionada=="4276"){
					    capa.innerHTML="DISENO ARTISTICO ";
					}else if(opcionSeleccionada=="4277"){
					    capa.innerHTML="DISENO CORTE Y CONFECCION ";
					}else if(opcionSeleccionada=="4278"){
					    capa.innerHTML="DISENO CORTE Y MODA ";
					}else if(opcionSeleccionada=="4279"){
					    capa.innerHTML="DISENO DE APLICACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="4280"){
					    capa.innerHTML="DISENO DE CALZADO ";
					}else if(opcionSeleccionada=="4281"){
					    capa.innerHTML="DISENO DE PROYECTO SOCIOED. ";
					}else if(opcionSeleccionada=="4282"){
					    capa.innerHTML="DISENO DE PROYECTOS ";
					}else if(opcionSeleccionada=="4283"){
					    capa.innerHTML="DISENO DE SISTEMAS ";
					}else if(opcionSeleccionada=="4284"){
					    capa.innerHTML="DISENO DE VESTUARIO Y ESTETICA ";
					}else if(opcionSeleccionada=="4285"){
					    capa.innerHTML="DISENO ESTUDIO Y TRAZADO PIEZAS METALICAS ";
					}else if(opcionSeleccionada=="4286"){
					    capa.innerHTML="DISENO FUNCIONAL ";
					}else if(opcionSeleccionada=="4287"){
					    capa.innerHTML="DISENO GRAFICO COMPUTACIONAL ";
					}else if(opcionSeleccionada=="4288"){
					    capa.innerHTML="DISENO GRAFICO PUBL. ESC. ";
					}else if(opcionSeleccionada=="4289"){
					    capa.innerHTML="DISENO GRAFICO Y DIBUJO PUBLICITARIO ";
					}else if(opcionSeleccionada=="4292"){
					    capa.innerHTML="DISENO OPERACION Y MANTENCION DE SISTEMAS DE CONTROL ELECTRICO";
					}else if(opcionSeleccionada=="4293"){
					    capa.innerHTML="DISENO OPERACION Y MANTENIMIENTO DE SISTEMAS ";
					}else if(opcionSeleccionada=="4294"){
					    capa.innerHTML="DISENO TECNICO ";
					}else if(opcionSeleccionada=="4295"){
					    capa.innerHTML="DISENO TECNICO COMPUTACIONAL ";
					}else if(opcionSeleccionada=="4211"){
					    capa.innerHTML="DESARROLLO LECTOR ";
					}else if(opcionSeleccionada=="4212"){
					    capa.innerHTML="DESARROLLO ORGANIZACIONAL ";
					}else if(opcionSeleccionada=="4213"){
					    capa.innerHTML="DESARROLLO PERSONAL PARA UN LIDER ";
					}else if(opcionSeleccionada=="4214"){
					    capa.innerHTML="DESARROLLO PERSONAL Y ORGANIZ.JUVENIL ";
					}else if(opcionSeleccionada=="4215"){
					    capa.innerHTML="DESARROLLO PSICOSOCIAL ";
					}else if(opcionSeleccionada=="4216"){
					    capa.innerHTML="DESARROLLO TEC A LA LECTURA ";
					}else if(opcionSeleccionada=="4218"){
					    capa.innerHTML="DESARROLLO Y ETICA PROFESIONAL ";
					}else if(opcionSeleccionada=="4219"){
					    capa.innerHTML="DESCUBRIENDO CHILE ";
					}else if(opcionSeleccionada=="4220"){
					    capa.innerHTML="DESEMPENO DE APRENDIZAJE EN LA EMPRESA ";
					}else if(opcionSeleccionada=="4221"){
					    capa.innerHTML="DIAGRAMA DE FLUJOS ";
					}else if(opcionSeleccionada=="4222"){
					    capa.innerHTML="DIAPORAMA, VIDEO , CINE ";
					}else if(opcionSeleccionada=="4224"){
					    capa.innerHTML="DIBUJO ARQUITECTONICO ";
					}else if(opcionSeleccionada=="4225"){
					    capa.innerHTML="DIBUJO DE CALDERERIA ";
					}else if(opcionSeleccionada=="4226"){
					    capa.innerHTML="DIBUJO DE ESTRUCTURAS ";
					}else if(opcionSeleccionada=="4227"){
					    capa.innerHTML="DIBUJO DE MAQUINAS ";
					}else if(opcionSeleccionada=="4228"){
					    capa.innerHTML="DIBUJO DE URBANISMO ";
					}else if(opcionSeleccionada=="4229"){
					    capa.innerHTML="DIBUJO ELECTRICO ";
					}else if(opcionSeleccionada=="4230"){
					    capa.innerHTML="DIBUJO MANUALIDAD ";
					}else if(opcionSeleccionada=="4231"){
					    capa.innerHTML="DIBUJO PROYECTO II ";
					}else if(opcionSeleccionada=="4232"){
					    capa.innerHTML="DIBUJO PUBLICITARIO Y GRAFICO ";
					}else if(opcionSeleccionada=="4233"){
					    capa.innerHTML="DIBUJO TECNICO Y/O PROYECTOS ";
					}else if(opcionSeleccionada=="4234"){
					    capa.innerHTML="DIBUJO TECNICO BASICO ";
					}else if(opcionSeleccionada=="4235"){
					    capa.innerHTML="DIBUJO TECNICO E INTERPRETACION DE PLANOS ";
					}else if(opcionSeleccionada=="4237"){
					    capa.innerHTML="DIBUJO TECNICO I ";
					}else if(opcionSeleccionada=="4238"){
					    capa.innerHTML="DIBUJO TECNICO II ";
					}else if(opcionSeleccionada=="4239"){
					    capa.innerHTML="DIBUJO TECNICO MECANICO ";
					}else if(opcionSeleccionada=="4240"){
					    capa.innerHTML="DIBUJO TOPOGRAFICO ";
					}else if(opcionSeleccionada=="4241"){
					    capa.innerHTML="DIBUJO Y DISENOS ELECTRICOS ";
					}else if(opcionSeleccionada=="4244"){
					    capa.innerHTML="DIBUJO Y PROYECTO DE INSTALACIONES ";
					}else if(opcionSeleccionada=="4247"){
					    capa.innerHTML="DIBUJO Y PROYECTO II ";
					}else if(opcionSeleccionada=="4249"){
					    capa.innerHTML="DIFERENCIADA ALGEBRA Y MODELOS ANALITICOS ";
					}else if(opcionSeleccionada=="4250"){
					    capa.innerHTML="DIFERENCIADA AUDIOVISUAL: FOTOGRAFIA, ETC. ";
					}else if(opcionSeleccionada=="4251"){
					    capa.innerHTML="DIFERENCIADA CIENCIAS SOCIALES Y REALIDAD NACIONAL ";
					}else if(opcionSeleccionada=="4252"){
					    capa.innerHTML="DIFERENCIADA CONDICION FISICA Y MOTRIZ ";
					}else if(opcionSeleccionada=="4167"){
					    capa.innerHTML="DENDROMETRIA ";
					}else if(opcionSeleccionada=="4168"){
					    capa.innerHTML="DEPORTE RECREACION Y PRIMEROS AUXILIOS ";
					}else if(opcionSeleccionada=="4171"){
					    capa.innerHTML="DEPORTE Y CULTURA ";
					}else if(opcionSeleccionada=="4173"){
					    capa.innerHTML="DEPORTE Y RECREACION I Y II ";
					}else if(opcionSeleccionada=="4174"){
					    capa.innerHTML="DEPORTE, RECREACION Y SALUD ";
					}else if(opcionSeleccionada=="4175"){
					    capa.innerHTML="DEPORTES Y ACTIVIDADES MOTRICES ";
					}else if(opcionSeleccionada=="4177"){
					    capa.innerHTML="DEPORTES Y SALUD ";
					}else if(opcionSeleccionada=="4179"){
					    capa.innerHTML="DERECHO BASICO ";
					}else if(opcionSeleccionada=="4180"){
					    capa.innerHTML="DERECHO CIVIL, PENAL Y LABORAL ";
					}else if(opcionSeleccionada=="4181"){
					    capa.innerHTML="DERECHO CONTABLE ";
					}else if(opcionSeleccionada=="4182"){
					    capa.innerHTML="DERECHO DEL TRABAJO Y SEGURIDAD SOCIAL ";
					}else if(opcionSeleccionada=="4183"){
					    capa.innerHTML="DERECHO II ";
					}else if(opcionSeleccionada=="4184"){
					    capa.innerHTML="DERECHO LABORAL Y ETICA ";
					}else if(opcionSeleccionada=="4185"){
					    capa.innerHTML="DERECHO LABORAL Y PREVISIONAL ";
					}else if(opcionSeleccionada=="4186"){
					    capa.innerHTML="DERECHO ROMANO ";
					}else if(opcionSeleccionada=="4187"){
					    capa.innerHTML="DERECHO USUAL ";
					}else if(opcionSeleccionada=="4188"){
					    capa.innerHTML="DERECHO Y LEGISLACION ";
					}else if(opcionSeleccionada=="4190"){
					    capa.innerHTML="DESARROLLO DE TECNICAS APLICADAS AL EJERCICIO DE LA LECTURA COMP. ";
					}else if(opcionSeleccionada=="4191"){
					    capa.innerHTML="DESARROLLO DEL TURISMO NACIONAL E INTERNACIONAL ";
					}else if(opcionSeleccionada=="4194"){
					    capa.innerHTML="DES. GEOHUMANO REG. DE CHILE ";
					}else if(opcionSeleccionada=="4196"){
					    capa.innerHTML="DESARROLLEMOS EL LENGUAJE ORAL (INGLES) ";
					}else if(opcionSeleccionada=="4197"){
					    capa.innerHTML="DESARROLLO AGRICOLA ";
					}else if(opcionSeleccionada=="4198"){
					    capa.innerHTML="DESARROLLO DE APLICACION ";
					}else if(opcionSeleccionada=="4199"){
					    capa.innerHTML="DESARROLLO DE CAPACIDADES PROFESIONALES ";
					}else if(opcionSeleccionada=="4200"){
					    capa.innerHTML="DESARROLLO DE ESPIRITU EMPRENDEDOR ";
					}else if(opcionSeleccionada=="4201"){
					    capa.innerHTML="DESARROLLO DE HABILIDADES MATEMATICAS ";
					}else if(opcionSeleccionada=="4202"){
					    capa.innerHTML="DESARROLLO DE LA CAPACIDAD EMPRESARIAL ";
					}else if(opcionSeleccionada=="4203"){
					    capa.innerHTML="DESARROLLO DE LA COMUNIDAD ";
					}else if(opcionSeleccionada=="4204"){
					    capa.innerHTML="DESARROLLO DE LA CREATIVIDAD ";
					}else if(opcionSeleccionada=="4205"){
					    capa.innerHTML="DESARROLLO DE LA SENSIBILIDAD ARTISTICO ";
					}else if(opcionSeleccionada=="4207"){
					    capa.innerHTML="DESARROLLO DEL ENTRENAMIENTO DE LA CONDICION FISICA ";
					}else if(opcionSeleccionada=="4208"){
					    capa.innerHTML="DESARROLLO ECONOMICO Y SOCIAL ";
					}else if(opcionSeleccionada=="4209"){
					    capa.innerHTML="DESARROLLO EMOCIONAL ";
					}else if(opcionSeleccionada=="4210"){
					    capa.innerHTML="DESARROLLO EMPRESARIAL ";
					}else if(opcionSeleccionada=="4123"){
					    capa.innerHTML="CULTIVO Y SANIDAD VEGETAL ";
					}else if(opcionSeleccionada=="4124"){
					    capa.innerHTML="CULTIVOS (I Y II) ";
					}else if(opcionSeleccionada=="4125"){
					    capa.innerHTML="CULTIVOS DE ALGAS Y CRUSTACEOS ";
					}else if(opcionSeleccionada=="4126"){
					    capa.innerHTML="CULTIVOS DE SECADO ";
					}else if(opcionSeleccionada=="4127"){
					    capa.innerHTML="CULTIVOS DE SECANO ";
					}else if(opcionSeleccionada=="4128"){
					    capa.innerHTML="CULTIVOS HORTOFRUTICOLAS Y ORNAMENTALES ";
					}else if(opcionSeleccionada=="4129"){
					    capa.innerHTML="CULTIVOS SUELO Y FERTILIZANTE ";
					}else if(opcionSeleccionada=="4130"){
					    capa.innerHTML="CULTIVOS SUELOS FERTILIZANTE RIEGO ";
					}else if(opcionSeleccionada=="4132"){
					    capa.innerHTML="CULTIVOS Y FORRAJES ";
					}else if(opcionSeleccionada=="4133"){
					    capa.innerHTML="CULTIVOS Y RECURSOS NATURALES ";
					}else if(opcionSeleccionada=="4134"){
					    capa.innerHTML="CULTIVOS Y SANIDAD VEGETAL ";
					}else if(opcionSeleccionada=="4135"){
					    capa.innerHTML="CULTURA FEMENINA ";
					}else if(opcionSeleccionada=="4136"){
					    capa.innerHTML="CULTURA TURISTICA ";
					}else if(opcionSeleccionada=="4137"){
					    capa.innerHTML="CULTURA TURISTICA DE CHILE ";
					}else if(opcionSeleccionada=="4138"){
					    capa.innerHTML="CULTURA Y SOCIEDAD MAPUCHE ";
					}else if(opcionSeleccionada=="4139"){
					    capa.innerHTML="CURRICULUM ";
					}else if(opcionSeleccionada=="4140"){
					    capa.innerHTML="D COMPRENSION DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="4141"){
					    capa.innerHTML="D. INTRODUCCION A LA TERMODINAMICA ";
					}else if(opcionSeleccionada=="4143"){
					    capa.innerHTML="DACTILOGRAFIA III ";
					}else if(opcionSeleccionada=="4144"){
					    capa.innerHTML="DACTILOGRAFIA APLICADA ";
					}else if(opcionSeleccionada=="4145"){
					    capa.innerHTML="DACTILOGRAFIA COMPUTACIONAL ";
					}else if(opcionSeleccionada=="4146"){
					    capa.innerHTML="DACTILOGRAFIA E INFORMATICA ";
					}else if(opcionSeleccionada=="4147"){
					    capa.innerHTML="DACTILOGRAFIA IV ";
					}else if(opcionSeleccionada=="4148"){
					    capa.innerHTML="DACTILOGRAMA ";
					}else if(opcionSeleccionada=="4149"){
					    capa.innerHTML="DASOMETRIA FORESTAL ";
					}else if(opcionSeleccionada=="4150"){
					    capa.innerHTML="DECLARACION COMERCIAL ";
					}else if(opcionSeleccionada=="4151"){
					    capa.innerHTML="DECORACION ";
					}else if(opcionSeleccionada=="4152"){
					    capa.innerHTML="DECORACION AMBIENTAL ";
					}else if(opcionSeleccionada=="4153"){
					    capa.innerHTML="DECORACION ESPACIOS INTERIORES ";
					}else if(opcionSeleccionada=="4155"){
					    capa.innerHTML="JARDINERIA ";
					}else if(opcionSeleccionada=="4161"){
					    capa.innerHTML="INICIACION A LA AGRICULTURA ";
					}else if(opcionSeleccionada=="4162"){
					    capa.innerHTML="DECUBRIENDO CHILE ";
					}else if(opcionSeleccionada=="4163"){
					    capa.innerHTML="DEFENSA FORESTAL ";
					}else if(opcionSeleccionada=="4166"){
					    capa.innerHTML="DEMOGRAFIA Y RECURSOS ECONOMICOS DE LA 7° REGION ";
					}else if(opcionSeleccionada=="4083"){
					    capa.innerHTML="CORTE DE PELO Y BASE ";
					}else if(opcionSeleccionada=="4084"){
					    capa.innerHTML="CORTE INDUSTRIAL ";
					}else if(opcionSeleccionada=="4085"){
					    capa.innerHTML="CORTE Y CONFECCION DAMAS ";
					}else if(opcionSeleccionada=="4086"){
					    capa.innerHTML="CORTE Y CONFECCION II ";
					}else if(opcionSeleccionada=="4087"){
					    capa.innerHTML="CORTE Y TRAZADO CHAPAS PERFILES Y TUBOS ";
					}else if(opcionSeleccionada=="4088"){
					    capa.innerHTML="COSECHA FORESTAL ";
					}else if(opcionSeleccionada=="4091"){
					    capa.innerHTML="COSECHA Y POST COSECHA ";
					}else if(opcionSeleccionada=="4093"){
					    capa.innerHTML="COSTO Y PRESUPUESTOS ";
					}else if(opcionSeleccionada=="4094"){
					    capa.innerHTML="COSTOS ";
					}else if(opcionSeleccionada=="4095"){
					    capa.innerHTML="COSTURA ";
					}else if(opcionSeleccionada=="4096"){
					    capa.innerHTML="COSTURA Y BORDADO ";
					}else if(opcionSeleccionada=="4097"){
					    capa.innerHTML="CREACION ARTISTICA ";
					}else if(opcionSeleccionada=="4098"){
					    capa.innerHTML="CREACION MUSICAL E INFORMATICA ";
					}else if(opcionSeleccionada=="4099"){
					    capa.innerHTML="CREACIONES ";
					}else if(opcionSeleccionada=="4100"){
					    capa.innerHTML="CREACIONES ARTESANALES ";
					}else if(opcionSeleccionada=="4101"){
					    capa.innerHTML="CREACIONES ARTISTICAS ";
					}else if(opcionSeleccionada=="4103"){
					    capa.innerHTML="CRECIMIENTO PERSONAL II ";
					}else if(opcionSeleccionada=="4104"){
					    capa.innerHTML="CRECIMIENTO Y DESARROLLO INFANTIL ";
					}else if(opcionSeleccionada=="4105"){
					    capa.innerHTML="CRIANZA DE AVES Y CERDOS ";
					}else if(opcionSeleccionada=="4106"){
					    capa.innerHTML="CRIAR GANADO SANO ";
					}else if(opcionSeleccionada=="4107"){
					    capa.innerHTML="CUBICACION ";
					}else if(opcionSeleccionada=="4109"){
					    capa.innerHTML="CUBICAR ENFIERRADURAS ";
					}else if(opcionSeleccionada=="4110"){
					    capa.innerHTML="CULTIVO AGRICOLA I ";
					}else if(opcionSeleccionada=="4111"){
					    capa.innerHTML="CULTIVO AGRICOLA II ";
					}else if(opcionSeleccionada=="4112"){
					    capa.innerHTML="CULTIVO AGROINDUSTRIALES ";
					}else if(opcionSeleccionada=="4113"){
					    capa.innerHTML="CULTIVO BAJO PLASTICO ";
					}else if(opcionSeleccionada=="4114"){
					    capa.innerHTML="CULTIVO BAJO PLASTICO E HIDROPONIA ";
					}else if(opcionSeleccionada=="4115"){
					    capa.innerHTML="CULTIVO DE CRUSTACEOS / MOLUSCOS ";
					}else if(opcionSeleccionada=="4116"){
					    capa.innerHTML="CULTIVO DE HORTALIZAS BAJO PLASTICO ";
					}else if(opcionSeleccionada=="4117"){
					    capa.innerHTML="CULTIVO DE PECES ";
					}else if(opcionSeleccionada=="4118"){
					    capa.innerHTML="CULTIVO FORZADO ";
					}else if(opcionSeleccionada=="4119"){
					    capa.innerHTML="CULTIVO HIDROPONICOS ";
					}else if(opcionSeleccionada=="4120"){
					    capa.innerHTML="CULTIVO III ";
					}else if(opcionSeleccionada=="4122"){
					    capa.innerHTML="CULTIVO Y FRUTICULTURA ";
					}else if(opcionSeleccionada=="4048"){
					    capa.innerHTML="CONSTRUCCION EN MADERA ";
					}else if(opcionSeleccionada=="4049"){
					    capa.innerHTML="CONSTRUCCION EN METALES ";
					}else if(opcionSeleccionada=="4050"){
					    capa.innerHTML="CONSTRUCCION I, II, III ";
					}else if(opcionSeleccionada=="4051"){
					    capa.innerHTML="CONSTRUCCION NAVAL ";
					}else if(opcionSeleccionada=="4052"){
					    capa.innerHTML="CONTABILIDAD I ";
					}else if(opcionSeleccionada=="4053"){
					    capa.innerHTML="CONTABILIDAD II ";
					}else if(opcionSeleccionada=="4054"){
					    capa.innerHTML="CONTABILIDAD AGRICOLA ";
					}else if(opcionSeleccionada=="4055"){
					    capa.innerHTML="CONTABILIDAD AGRICOLA LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="4056"){
					    capa.innerHTML="CONTABILIDAD APLICADA ";
					}else if(opcionSeleccionada=="4057"){
					    capa.innerHTML="CONTABILIDAD BASICA Y COMPRAVENTA ";
					}else if(opcionSeleccionada=="4058"){
					    capa.innerHTML="CONTABILIDAD DE COSTO II ";
					}else if(opcionSeleccionada=="4059"){
					    capa.innerHTML="CONTABILIDAD DE COSTO Y PRESUPUESTO ";
					}else if(opcionSeleccionada=="4060"){
					    capa.innerHTML="CONTABILIDAD DE COSTOS AGRICOLAS ";
					}else if(opcionSeleccionada=="4061"){
					    capa.innerHTML="CONTABILIDAD DE LABORATORIO ";
					}else if(opcionSeleccionada=="4062"){
					    capa.innerHTML="CONTABILIDAD GERENCIAL ";
					}else if(opcionSeleccionada=="4064"){
					    capa.innerHTML="CONTABILIDAD III ";
					}else if(opcionSeleccionada=="4065"){
					    capa.innerHTML="CONTABILIDAD SUPERIOR Y NOCIONES DE AUDITORIA ";
					}else if(opcionSeleccionada=="4066"){
					    capa.innerHTML="CONTABILIDAD Y ADMINISTRACION ";
					}else if(opcionSeleccionada=="4067"){
					    capa.innerHTML="CONTABILIDAD Y DOCUMENTO MERCANTIL ";
					}else if(opcionSeleccionada=="4068"){
					    capa.innerHTML="CONTABILIDAD Y LABORATORIO ";
					}else if(opcionSeleccionada=="4069"){
					    capa.innerHTML="CONTABILIDAD Y OPERACIONES BANCARIAS ";
					}else if(opcionSeleccionada=="4070"){
					    capa.innerHTML="CONTABILIDAD Y SUS FUNDAMENTOS ";
					}else if(opcionSeleccionada=="4071"){
					    capa.innerHTML="CONTABILIDAD Y SUS PROCESOS ";
					}else if(opcionSeleccionada=="4072"){
					    capa.innerHTML="CONTABILIDAD, ORG.DE OF.Y VENTA ";
					}else if(opcionSeleccionada=="4073"){
					    capa.innerHTML="CONTROL DE COSTOS DE ALIMENTOS Y BEBIDAS ";
					}else if(opcionSeleccionada=="4074"){
					    capa.innerHTML="CONTROL DE INCENDIOS ";
					}else if(opcionSeleccionada=="4075"){
					    capa.innerHTML="CONTROL DE INCENDIOS FORESTALES ";
					}else if(opcionSeleccionada=="4076"){
					    capa.innerHTML="CONTROL DE MALEZAS ";
					}else if(opcionSeleccionada=="4077"){
					    capa.innerHTML="CONTROL DE SOLDADURA ";
					}else if(opcionSeleccionada=="4078"){
					    capa.innerHTML="CONTROL Y ANALISIS ";
					}else if(opcionSeleccionada=="4079"){
					    capa.innerHTML="CONTROL Y ANALISIS DE LOS INSTRUMENTOS ";
					}else if(opcionSeleccionada=="4080"){
					    capa.innerHTML="CONTROL Y PLANIFICACION DE LA PRODUCCION ";
					}else if(opcionSeleccionada=="4081"){
					    capa.innerHTML="CONVERSION MECANICA DE LA MADERA ";
					}else if(opcionSeleccionada=="4082"){
					    capa.innerHTML="COOPERATIVAS AGROPECUARIAS ";
					}else if(opcionSeleccionada=="4011"){
					    capa.innerHTML="COMUNICACION EMPRESARIAL ";
					}else if(opcionSeleccionada=="4013"){
					    capa.innerHTML="COMUNICACION HERRAMIENTA PARA MI DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="4014"){
					    capa.innerHTML="COMUNICACION II ";
					}else if(opcionSeleccionada=="4015"){
					    capa.innerHTML="COMUNICACION LINGUISTICA TIPOS HUMANOS EN LITERATURA ";
					}else if(opcionSeleccionada=="4016"){
					    capa.innerHTML="COMUNICACION NAVAL ";
					}else if(opcionSeleccionada=="4017"){
					    capa.innerHTML="COMUNICACION ORAL UN ESPACIO DE CRECIMIENTO ";
					}else if(opcionSeleccionada=="4018"){
					    capa.innerHTML="COMUNICACION ORGANIZACIONAL (C) ";
					}else if(opcionSeleccionada=="4019"){
					    capa.innerHTML="COMUNICACION VISUAL ";
					}else if(opcionSeleccionada=="4020"){
					    capa.innerHTML="COMUNICACION Y COMERCIO ";
					}else if(opcionSeleccionada=="4021"){
					    capa.innerHTML="COMUNICACION Y EXTENSION ";
					}else if(opcionSeleccionada=="4022"){
					    capa.innerHTML="COMUNICACION Y LITERATURA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="4023"){
					    capa.innerHTML="COMUNICACION Y RELACIONES HUMANAS ";
					}else if(opcionSeleccionada=="4024"){
					    capa.innerHTML="COMUNICACION Y SOCIEDAD ";
					}else if(opcionSeleccionada=="4025"){
					    capa.innerHTML="COMUNICACIONES MARITIMAS ";
					}else if(opcionSeleccionada=="4026"){
					    capa.innerHTML="COMUNICACIONES Y RELACIONES HUMANAS ";
					}else if(opcionSeleccionada=="4027"){
					    capa.innerHTML="CONDUCCION Y MANEJO DE VEHICULOS ";
					}else if(opcionSeleccionada=="4028"){
					    capa.innerHTML="CONDUCCION Y MANTENCION DE VEHICULOS ";
					}else if(opcionSeleccionada=="4029"){
					    capa.innerHTML="CONFECCION DE MUNECAS EN MATERIALES DIVERSOS ";
					}else if(opcionSeleccionada=="4030"){
					    capa.innerHTML="CONFECCION DE VESTUARIO ";
					}else if(opcionSeleccionada=="4031"){
					    capa.innerHTML="CONFECCION DE VESTUARIO INFANTIL ";
					}else if(opcionSeleccionada=="4033"){
					    capa.innerHTML="CONFECCION Y VESTUARIO ";
					}else if(opcionSeleccionada=="4034"){
					    capa.innerHTML="CONFORMADO, TRAZADO Y CORTE DE CHAPAS, PERFILES Y TUBOS EN CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="4035"){
					    capa.innerHTML="CONOCIENDO LA MADERA ";
					}else if(opcionSeleccionada=="4036"){
					    capa.innerHTML="CONOCIENDO LAS MATEMATICAS ";
					}else if(opcionSeleccionada=="4037"){
					    capa.innerHTML="CONOCIMIENTO DEL MUNDO ACTUAL ";
					}else if(opcionSeleccionada=="4038"){
					    capa.innerHTML="CONOCIMIENTO MUNDO ACTUAL ";
					}else if(opcionSeleccionada=="4039"){
					    capa.innerHTML="CONSERVACION ARTESANAL DE ALIMENTOS ";
					}else if(opcionSeleccionada=="4040"){
					    capa.innerHTML="CONSERVACION DE LOS SUELOS ";
					}else if(opcionSeleccionada=="4041"){
					    capa.innerHTML="CONSERVACION DE PRODUCTOS DEL MAR ";
					}else if(opcionSeleccionada=="4042"){
					    capa.innerHTML="CONSERVACION DE SUELOS ";
					}else if(opcionSeleccionada=="4043"){
					    capa.innerHTML="CONSERVACION Y PROCESAMIENTOS DE PRODUCTOS AGRICOLAS ";
					}else if(opcionSeleccionada=="4044"){
					    capa.innerHTML="CONSERVERIA CASERA ";
					}else if(opcionSeleccionada=="4045"){
					    capa.innerHTML="CONSERVERIA Y PROCESAMIENTO DE VEGETALES ";
					}else if(opcionSeleccionada=="4047"){
					    capa.innerHTML="CONSTRUCCION DE INTERIORES ";
					}else if(opcionSeleccionada=="3961"){
					    capa.innerHTML="COMPOSICION MUSICAL I ";
					}else if(opcionSeleccionada=="3962"){
					    capa.innerHTML="COMPOSICION MUSICAL II ";
					}else if(opcionSeleccionada=="3963"){
					    capa.innerHTML="COMPRA VENTA Y ATENCION AL CLIENTE ";
					}else if(opcionSeleccionada=="3966"){
					    capa.innerHTML="COMPRENSION DE LECTURA APLICADA ";
					}else if(opcionSeleccionada=="3967"){
					    capa.innerHTML="COMPRENSION DE LA SOCIEDAD Y REALIDAD SOCIAL ";
					}else if(opcionSeleccionada=="3968"){
					    capa.innerHTML="COMPRENSION DE LAS MATEMATICAS ";
					}else if(opcionSeleccionada=="3970"){
					    capa.innerHTML="COMPRENSION DEL IDIOMA ";
					}else if(opcionSeleccionada=="3971"){
					    capa.innerHTML="COMPRENSION DEL IDIOMA INGLES ORAL Y ESCRITO ";
					}else if(opcionSeleccionada=="3972"){
					    capa.innerHTML="COMPRENSION DEL LENGUAJE ORAL Y ESCRITO FRANCES ";
					}else if(opcionSeleccionada=="3974"){
					    capa.innerHTML="COMPRENSION DEL MEDIO ";
					}else if(opcionSeleccionada=="3975"){
					    capa.innerHTML="COMPRENSION DEL MEDIO NATURAL, SOCIAL Y CULTURAL Y CHILE Y SU CULTURA ";
					}else if(opcionSeleccionada=="3976"){
					    capa.innerHTML="COMPRENSION DEL MEDIO SOCIAL ";
					}else if(opcionSeleccionada=="3977"){
					    capa.innerHTML="COMPRENSION LECTORA EN INGLES ";
					}else if(opcionSeleccionada=="3980"){
					    capa.innerHTML="COMPRENSION LINGUISTICA ";
					}else if(opcionSeleccionada=="3982"){
					    capa.innerHTML="COMPRENSION MEDIO SOCIAL ";
					}else if(opcionSeleccionada=="3984"){
					    capa.innerHTML="COMPRENSION MUSICAL ";
					}else if(opcionSeleccionada=="3986"){
					    capa.innerHTML="COMPRENSION Y PRODUCCION DEL IDIOMA ";
					}else if(opcionSeleccionada=="3988"){
					    capa.innerHTML="COMPRENSION DEL IDIOMA ORAL Y ESCRITO INGLES ";
					}else if(opcionSeleccionada=="3991"){
					    capa.innerHTML="COMPRENSION DEL LENGUAJE ESCRITO ";
					}else if(opcionSeleccionada=="3996"){
					    capa.innerHTML="COMPUTACION BASICA APLICADA ";
					}else if(opcionSeleccionada=="3997"){
					    capa.innerHTML="COMPUTACION APLICADA AL DIBUJO ";
					}else if(opcionSeleccionada=="3998"){
					    capa.innerHTML="COMPUTACION BASICA INSTITUCIONAL ";
					}else if(opcionSeleccionada=="3999"){
					    capa.innerHTML="COMPUTACION BASICA Y DACTILOGRAFIA ";
					}else if(opcionSeleccionada=="4000"){
					    capa.innerHTML="COMPUTACION CONTABLE ";
					}else if(opcionSeleccionada=="4001"){
					    capa.innerHTML="COMPUTACION GESTION ";
					}else if(opcionSeleccionada=="4002"){
					    capa.innerHTML="COMPUTACION HOTELERA ";
					}else if(opcionSeleccionada=="4003"){
					    capa.innerHTML="COMPUTACION IV ";
					}else if(opcionSeleccionada=="4004"){
					    capa.innerHTML="COMPUTACION OPTATIVA ";
					}else if(opcionSeleccionada=="4005"){
					    capa.innerHTML="COMPUTACION PARA EL MUNDO DEL TRABAJO ";
					}else if(opcionSeleccionada=="4006"){
					    capa.innerHTML="COMPUTACION Y CONTROL AUTOMATICO ";
					}else if(opcionSeleccionada=="4007"){
					    capa.innerHTML="COMPUTACION Y DACTILOGRAFIA ";
					}else if(opcionSeleccionada=="4008"){
					    capa.innerHTML="COMUNICACION GRAFICA ";
					}else if(opcionSeleccionada=="4009"){
					    capa.innerHTML="COMUNICACION APLICADA ";
					}else if(opcionSeleccionada=="4010"){
					    capa.innerHTML="COMUNICACION AUDIOVISUAL ";
					}else if(opcionSeleccionada=="3922"){
					    capa.innerHTML="CIENCIAS NATURALES: QUIMICA ";
					}else if(opcionSeleccionada=="3923"){
					    capa.innerHTML="CIENCIAS SOCIAL, NATURAL Y CULTURAL ";
					}else if(opcionSeleccionada=="3924"){
					    capa.innerHTML="CIENCIAS SOCIALES DIF ";
					}else if(opcionSeleccionada=="3925"){
					    capa.innerHTML="CIENCIAS SOCIALES Y REALIDAD SOCIAL ";
					}else if(opcionSeleccionada=="3926"){
					    capa.innerHTML="CIENCIAS NATURALES INTEGRADAS ";
					}else if(opcionSeleccionada=="3927"){
					    capa.innerHTML="CIRCUITO TURISTICO COMUNA HUARA ";
					}else if(opcionSeleccionada=="3928"){
					    capa.innerHTML="CIRCUITOS ELECTROTECNICOS ";
					}else if(opcionSeleccionada=="3929"){
					    capa.innerHTML="CITOLOGIA ";
					}else if(opcionSeleccionada=="3930"){
					    capa.innerHTML="CIUDAD CONTEMPORANEA ";
					}else if(opcionSeleccionada=="3931"){
					    capa.innerHTML="CIVICA Y LOS DERECHOS HUMANOS ";
					}else if(opcionSeleccionada=="3932"){
					    capa.innerHTML="CLOE ";
					}else if(opcionSeleccionada=="3933"){
					    capa.innerHTML="COCINA BASICA ";
					}else if(opcionSeleccionada=="3934"){
					    capa.innerHTML="COCINA INTERNACIONAL II ";
					}else if(opcionSeleccionada=="3935"){
					    capa.innerHTML="CODIGO ELECTIVO ";
					}else if(opcionSeleccionada=="3937"){
					    capa.innerHTML="COMERCIALIZACION DE PRODUCTOS PESQUEROS ";
					}else if(opcionSeleccionada=="3938"){
					    capa.innerHTML="COMERCIALIZACION Y VENTAS ";
					}else if(opcionSeleccionada=="3939"){
					    capa.innerHTML="COMERCIALIZACION AGRICOLA ";
					}else if(opcionSeleccionada=="3940"){
					    capa.innerHTML="COMERCIALIZACION DE COSTO ";
					}else if(opcionSeleccionada=="3941"){
					    capa.innerHTML="COMERCIALIZACION DE LA PRODUCCION AGROPECUARIA ";
					}else if(opcionSeleccionada=="3942"){
					    capa.innerHTML="COMERCIALIZACION Y AUTOGESTION EMPRESARIAL ";
					}else if(opcionSeleccionada=="3943"){
					    capa.innerHTML="COMERCIALIZACION Y COSTOS ";
					}else if(opcionSeleccionada=="3944"){
					    capa.innerHTML="COMERCIALIZACION Y MARKETING ";
					}else if(opcionSeleccionada=="3946"){
					    capa.innerHTML="COMERCIALIZACION Y PUBLICIDAD ";
					}else if(opcionSeleccionada=="3947"){
					    capa.innerHTML="COMERCIALIZACION Y TECNICAS DE VENTAS ";
					}else if(opcionSeleccionada=="3949"){
					    capa.innerHTML="COMERCIO ";
					}else if(opcionSeleccionada=="3950"){
					    capa.innerHTML="COMERCIO EXTERIOR Y LEGISLACION ADUANERA ";
					}else if(opcionSeleccionada=="3951"){
					    capa.innerHTML="COMERCIO EXTERIOR Y TRAMITACION ADUANERA ";
					}else if(opcionSeleccionada=="3952"){
					    capa.innerHTML="COMERCIO Y MERCADO ";
					}else if(opcionSeleccionada=="3953"){
					    capa.innerHTML="COMERCIO Y PUBLICIDAD ";
					}else if(opcionSeleccionada=="3954"){
					    capa.innerHTML="COMIDA NACIONAL E INTERNACIONAL ";
					}else if(opcionSeleccionada=="3955"){
					    capa.innerHTML="COMP ";
					}else if(opcionSeleccionada=="3958"){
					    capa.innerHTML="COMPLEMENTARIA ";
					}else if(opcionSeleccionada=="3959"){
					    capa.innerHTML="COMPLEMENTARIA RED DE CABLEADO ";
					}else if(opcionSeleccionada=="3960"){
					    capa.innerHTML="COMPLEMENTARIAS ";
					}else if(opcionSeleccionada=="3882"){
					    capa.innerHTML="BUSCANDO CAMINO ";
					}else if(opcionSeleccionada=="3883"){
					    capa.innerHTML="CIENCIAS NATURALES O BIOLOGIA ";
					}else if(opcionSeleccionada=="3885"){
					    capa.innerHTML="CIENCIAS SOCIALES Y REALIDAD NACIONAL II ";
					}else if(opcionSeleccionada=="3886"){
					    capa.innerHTML="CALCULO I ";
					}else if(opcionSeleccionada=="3888"){
					    capa.innerHTML="CALDERAS Y MAQUINAS A VAPOR ";
					}else if(opcionSeleccionada=="3890"){
					    capa.innerHTML="CAMARAS Y MATRICES ";
					}else if(opcionSeleccionada=="3891"){
					    capa.innerHTML="CAMBIOS Y HECHOS HISTORICOS DEL SIGLO XX ";
					}else if(opcionSeleccionada=="3892"){
					    capa.innerHTML="CAMINOS FORESTALES ";
					}else if(opcionSeleccionada=="3893"){
					    capa.innerHTML="CAPRINOTECNIA ";
					}else if(opcionSeleccionada=="3894"){
					    capa.innerHTML="CARPINTERIA DE TERMINACIONES EN MADERA ";
					}else if(opcionSeleccionada=="3895"){
					    capa.innerHTML="CARPINTERIA DE TRAZADO ";
					}else if(opcionSeleccionada=="3896"){
					    capa.innerHTML="CARPINTERIA Y MUEBLERIA VARONES ";
					}else if(opcionSeleccionada=="3897"){
					    capa.innerHTML="CARTOGRAFIA ";
					}else if(opcionSeleccionada=="3898"){
					    capa.innerHTML="CARTOGRAFIA FORESTAL ";
					}else if(opcionSeleccionada=="3899"){
					    capa.innerHTML="CARTOGRAFIA Y CONFECCION DE PLANOS ";
					}else if(opcionSeleccionada=="3900"){
					    capa.innerHTML="CASTELLANO FILOSOFIA Y FUNDAMENTO DE DERECHO SOCIO POLITICO ";
					}else if(opcionSeleccionada=="3901"){
					    capa.innerHTML="CASTELLANO DIFERENCIADO ";
					}else if(opcionSeleccionada=="3902"){
					    capa.innerHTML="CASTELLANO ELECTIVO ";
					}else if(opcionSeleccionada=="3903"){
					    capa.innerHTML="CASTELLANO Y FILOSOFIA ";
					}else if(opcionSeleccionada=="3905"){
					    capa.innerHTML="CELULA G ";
					}else if(opcionSeleccionada=="3906"){
					    capa.innerHTML="CESTERIA CHINA ";
					}else if(opcionSeleccionada=="3907"){
					    capa.innerHTML="CHANCADO DE MINERALES ";
					}else if(opcionSeleccionada=="3909"){
					    capa.innerHTML="CHILE TURISTICO ";
					}else if(opcionSeleccionada=="3911"){
					    capa.innerHTML="CIENCIA ";
					}else if(opcionSeleccionada=="3912"){
					    capa.innerHTML="CIENCIA BIOLOGICA ";
					}else if(opcionSeleccionada=="3913"){
					    capa.innerHTML="CIENCIA QUIMICA ";
					}else if(opcionSeleccionada=="3914"){
					    capa.innerHTML="CIENCIAS I ";
					}else if(opcionSeleccionada=="3915"){
					    capa.innerHTML="CIENCIAS II ";
					}else if(opcionSeleccionada=="3916"){
					    capa.innerHTML="CIENCIAS DE LA VIDA Y DE LA TIERRA ";
					}else if(opcionSeleccionada=="3917"){
					    capa.innerHTML="CIENCIAS DEL HOMBRE ";
					}else if(opcionSeleccionada=="3918"){
					    capa.innerHTML="CIENCIAS FISICA ";
					}else if(opcionSeleccionada=="3919"){
					    capa.innerHTML="CIENCIAS NATURALES O BIOLOGICAS ";
					}else if(opcionSeleccionada=="3920"){
					    capa.innerHTML="CIENCIAS NATURALES Y FISICA QUIMICA ";
					}else if(opcionSeleccionada=="3921"){
					    capa.innerHTML="CIENCIAS NATURALES: MECANICA ";
					}else if(opcionSeleccionada=="3842"){
					    capa.innerHTML="AUTOGESTION EMPRESARIAL ";
					}else if(opcionSeleccionada=="3843"){
					    capa.innerHTML="AUTORRATIZACION ";
					}else if(opcionSeleccionada=="3844"){
					    capa.innerHTML="AUXILIAR PARAMEDICO EN ENFERMERIA II ";
					}else if(opcionSeleccionada=="3845"){
					    capa.innerHTML="AVICULTURA ";
					}else if(opcionSeleccionada=="3846"){
					    capa.innerHTML="AVICULTURA-CUNICULTURA ";
					}else if(opcionSeleccionada=="3847"){
					    capa.innerHTML="BACTEREOLOGIA Y CONTROL DE CALIDAD ";
					}else if(opcionSeleccionada=="3848"){
					    capa.innerHTML="BANQUETERIA ";
					}else if(opcionSeleccionada=="3849"){
					    capa.innerHTML="BIOETICA Y DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="3852"){
					    capa.innerHTML="BIOLOGIA - QUIMICA ";
					}else if(opcionSeleccionada=="3854"){
					    capa.innerHTML="BIOLOGIA AMBIENTAL ";
					}else if(opcionSeleccionada=="3855"){
					    capa.innerHTML="BIOLOGIA CELULAR ANIMAL ";
					}else if(opcionSeleccionada=="3856"){
					    capa.innerHTML="BIOLOGIA CELULAR ELECTIVA ";
					}else if(opcionSeleccionada=="3857"){
					    capa.innerHTML="BIOLOGIA CELULAR I ";
					}else if(opcionSeleccionada=="3858"){
					    capa.innerHTML="BIOLOGIA CELULAR II ";
					}else if(opcionSeleccionada=="3859"){
					    capa.innerHTML="BIOLOGIA CELULAR Y BIOQUIMICA ";
					}else if(opcionSeleccionada=="3860"){
					    capa.innerHTML="BIOLOGIA CELULAR Y DE LA CONDUCTA ";
					}else if(opcionSeleccionada=="3861"){
					    capa.innerHTML="BIOLOGIA CELULAR Y ECOLOGIA ";
					}else if(opcionSeleccionada=="3862"){
					    capa.innerHTML="BIOLOGIA CELULAR Y EL ORGANISMO ANIMAL ";
					}else if(opcionSeleccionada=="3863"){
					    capa.innerHTML="BIOLOGIA CELULAR Y EL ORGANISMO VEGETAL Y PROBLEMAS FUNDAMENTALES DE ASPECTOS BASICOS DE ECOLOGIA ";
					}else if(opcionSeleccionada=="3864"){
					    capa.innerHTML="BIOLOGIA CELULAR Y FISIOLOGIA VEGETAL ";
					}else if(opcionSeleccionada=="3865"){
					    capa.innerHTML="BIOLOGIA CELULAR Y MOLECULAR Y MECANISMOS DE CONTROL ";
					}else if(opcionSeleccionada=="3866"){
					    capa.innerHTML="BIOLOGIA DEL ORGANISMO ANIMAL ";
					}else if(opcionSeleccionada=="3869"){
					    capa.innerHTML="BIOLOGIA ORGANICA ";
					}else if(opcionSeleccionada=="3870"){
					    capa.innerHTML="BIOLOGIA PESQUERA ";
					}else if(opcionSeleccionada=="3871"){
					    capa.innerHTML="BIOLOGIA PLANA ";
					}else if(opcionSeleccionada=="3872"){
					    capa.innerHTML="BIOLOGIA Y QUIMICA APLICADA ";
					}else if(opcionSeleccionada=="3874"){
					    capa.innerHTML="BIOLOGIA: EVOLUCION ";
					}else if(opcionSeleccionada=="3875"){
					    capa.innerHTML="BIOSEGURIDAD ";
					}else if(opcionSeleccionada=="3876"){
					    capa.innerHTML="BODEGA ";
					}else if(opcionSeleccionada=="3877"){
					    capa.innerHTML="BORDADO ";
					}else if(opcionSeleccionada=="3878"){
					    capa.innerHTML="BORDADO A MANO ";
					}else if(opcionSeleccionada=="3879"){
					    capa.innerHTML="BORDADO APLICADO ";
					}else if(opcionSeleccionada=="3880"){
					    capa.innerHTML="BOTANICA APLICADA ";
					}else if(opcionSeleccionada=="3881"){
					    capa.innerHTML="BOVINOTECNIA ";
					}else if(opcionSeleccionada=="3805"){
					    capa.innerHTML="ARTES VISUALES Y MANUALIDADES ";
					}else if(opcionSeleccionada=="3806"){
					    capa.innerHTML="ARTES VISUALES, DISENO MULTIPLE ";
					}else if(opcionSeleccionada=="3807"){
					    capa.innerHTML="ARTES VISUALES: TALLER AUDIOVISUAL ";
					}else if(opcionSeleccionada=="3808"){
					    capa.innerHTML="ARTESANIA / PELUQUERIA ";
					}else if(opcionSeleccionada=="3809"){
					    capa.innerHTML="ARTESANIA CULINARIA I ";
					}else if(opcionSeleccionada=="3810"){
					    capa.innerHTML="ARTESANIA CULINARIA II ";
					}else if(opcionSeleccionada=="3811"){
					    capa.innerHTML="ARTESANIA EN FLORES DE PANTY ";
					}else if(opcionSeleccionada=="3812"){
					    capa.innerHTML="ARTESANIA EN GREDA ";
					}else if(opcionSeleccionada=="3813"){
					    capa.innerHTML="ARTESANIA EN MADERA ";
					}else if(opcionSeleccionada=="3814"){
					    capa.innerHTML="ARTESANIA EN MADERAS Y/O VESTUARIO INFANTIL ";
					}else if(opcionSeleccionada=="3815"){
					    capa.innerHTML="ARTESANIA MAPUCHE ";
					}else if(opcionSeleccionada=="3816"){
					    capa.innerHTML="ARTESANIA PRODUCTIVA ";
					}else if(opcionSeleccionada=="3817"){
					    capa.innerHTML="ARTESANIA Y ELECTRICIDAD ";
					}else if(opcionSeleccionada=="3818"){
					    capa.innerHTML="ARTESANIA Y PELUQUERIA ";
					}else if(opcionSeleccionada=="3819"){
					    capa.innerHTML="ARTESANIA, POLICROMIA, BANER, PINTURA ";
					}else if(opcionSeleccionada=="3820"){
					    capa.innerHTML="ARTESANIAS PRODUCTIVAS ";
					}else if(opcionSeleccionada=="3822"){
					    capa.innerHTML="ARTISTICA INTEGRADA ";
					}else if(opcionSeleccionada=="3824"){
					    capa.innerHTML="ARTISTICO CULTURAL ";
					}else if(opcionSeleccionada=="3825"){
					    capa.innerHTML="ARTISTICO MANUAL ";
					}else if(opcionSeleccionada=="3826"){
					    capa.innerHTML="ASIGNATURA ELECTIVA ";
					}else if(opcionSeleccionada=="3827"){
					    capa.innerHTML="ASIGNATURAS TECNOLOGICAS ";
					}else if(opcionSeleccionada=="3828"){
					    capa.innerHTML="ASPECTOS BASICOS DE LA ECOLOGIA ";
					}else if(opcionSeleccionada=="3829"){
					    capa.innerHTML="ASPECTOS FUNDAMENNTALES DE LA BIOLOGIA EN LA INTERACCION SOCIAL DEL HOMBRE II ";
					}else if(opcionSeleccionada=="3830"){
					    capa.innerHTML="ASPECTOS FUNDAMENTALES DEL ORGANISMO ANIMAL Y ASPECTOS BASICOS DE LA ECOLOGIA ";
					}else if(opcionSeleccionada=="3831"){
					    capa.innerHTML="ASPECTOS GENERALES DE ZOOLOGIA Y BOTANICA ";
					}else if(opcionSeleccionada=="3832"){
					    capa.innerHTML="ASPECTOS PSICOLOGICOS DEL NINO ";
					}else if(opcionSeleccionada=="3833"){
					    capa.innerHTML="ATENCION AL CLIENTE ";
					}else if(opcionSeleccionada=="3834"){
					    capa.innerHTML="ATENCION DE NINOS ";
					}else if(opcionSeleccionada=="3835"){
					    capa.innerHTML="ATENCION DEL SENESCENTE ";
					}else if(opcionSeleccionada=="3836"){
					    capa.innerHTML="ATENCION ENFERMERIA BASICA INTEGRAL I ";
					}else if(opcionSeleccionada=="3838"){
					    capa.innerHTML="AUDIOVISUAL (PD) ";
					}else if(opcionSeleccionada=="3839"){
					    capa.innerHTML="AUDIOVISUAL: VIDEO ";
					}else if(opcionSeleccionada=="3840"){
					    capa.innerHTML="AUDITORIA Y ADMINISTRACION I ";
					}else if(opcionSeleccionada=="3841"){
					    capa.innerHTML="AULA TECNOLOGICA ";
					}else if(opcionSeleccionada=="3766"){
					    capa.innerHTML="APTITUD VERBAL II ";
					}else if(opcionSeleccionada=="3767"){
					    capa.innerHTML="APTITUD MATEMATICA II ";
					}else if(opcionSeleccionada=="3769"){
					    capa.innerHTML="ARBORICULTURA: FRUTALES ";
					}else if(opcionSeleccionada=="3770"){
					    capa.innerHTML="ARBORICULTURA: SILVICULTURA ";
					}else if(opcionSeleccionada=="3771"){
					    capa.innerHTML="ARCHIVO Y DOCUMENTOS ";
					}else if(opcionSeleccionada=="3772"){
					    capa.innerHTML="ARCHIVOS Y MAQUINAS DE OFICINA ";
					}else if(opcionSeleccionada=="3773"){
					    capa.innerHTML="AREA ";
					}else if(opcionSeleccionada=="3774"){
					    capa.innerHTML="AREA COMPLEMENTARIA FOLKLORE ";
					}else if(opcionSeleccionada=="3775"){
					    capa.innerHTML="AREA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="3776"){
					    capa.innerHTML="AREA DE ACTIVIDADES COMERCIALES ";
					}else if(opcionSeleccionada=="3777"){
					    capa.innerHTML="AREA DE ACTIVIDADES COMPLEMENTARIAS ";
					}else if(opcionSeleccionada=="3778"){
					    capa.innerHTML="AREA DE ACTIVIDADES CONTEMPORANEAS ";
					}else if(opcionSeleccionada=="3779"){
					    capa.innerHTML="AREA DE EDUCACION COMPLEMENTARIA ";
					}else if(opcionSeleccionada=="3780"){
					    capa.innerHTML="AREA DE EDUCACION TECNICA ";
					}else if(opcionSeleccionada=="3781"){
					    capa.innerHTML="AREA PROFESIONAL ";
					}else if(opcionSeleccionada=="3782"){
					    capa.innerHTML="AREA TECNICA ";
					}else if(opcionSeleccionada=="3784"){
					    capa.innerHTML="ARITMETICA COMERCIAL ";
					}else if(opcionSeleccionada=="3785"){
					    capa.innerHTML="ARMADO DE ELEMENTOS APLICANDO LA CALIDAD EN CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="3786"){
					    capa.innerHTML="ARQUEOLOGIA TURISTICA ";
					}else if(opcionSeleccionada=="3787"){
					    capa.innerHTML="ARTBORICULTURA FRUTAL Y FORESTAL ";
					}else if(opcionSeleccionada=="3788"){
					    capa.innerHTML="ARTE COMUNICACIONAL ";
					}else if(opcionSeleccionada=="3789"){
					    capa.innerHTML="ARTE TEXTIL ";
					}else if(opcionSeleccionada=="3790"){
					    capa.innerHTML="ARTES ELECTIVAS ";
					}else if(opcionSeleccionada=="3791"){
					    capa.innerHTML="ARTES ESCENICAS ";
					}else if(opcionSeleccionada=="3792"){
					    capa.innerHTML="ARTES ESCENICAS: TEATRO ";
					}else if(opcionSeleccionada=="3793"){
					    capa.innerHTML="ARTES GRAFICAS ";
					}else if(opcionSeleccionada=="3794"){
					    capa.innerHTML="ARTES GRAFICOS ";
					}else if(opcionSeleccionada=="3795"){
					    capa.innerHTML="ARTES MANUALES Y ARTES MUSICALES ";
					}else if(opcionSeleccionada=="3796"){
					    capa.innerHTML="ARTES MUSICALES DIFERENCIADO ";
					}else if(opcionSeleccionada=="3799"){
					    capa.innerHTML="ARTES VISUALES (GRAFICAY PINTURA) ";
					}else if(opcionSeleccionada=="3800"){
					    capa.innerHTML="ARTES VISUALES 1 ";
					}else if(opcionSeleccionada=="3801"){
					    capa.innerHTML="ARTES VISUALES ELECTIVO ";
					}else if(opcionSeleccionada=="3802"){
					    capa.innerHTML="ARTES VISUALES GRAFICAS ";
					}else if(opcionSeleccionada=="3804"){
					    capa.innerHTML="ARTES VISUALES Y ARTES MUSICALES ";
					}else if(opcionSeleccionada=="3731"){
					    capa.innerHTML="ANALISIS QUIMICO Y FISICO DE LOS ALIMENTOS ";
					}else if(opcionSeleccionada=="3732"){
					    capa.innerHTML="ANALISIS Y EVALUACION DE PROYECTOS ";
					}else if(opcionSeleccionada=="3733"){
					    capa.innerHTML="ANATOMIA ";
					}else if(opcionSeleccionada=="3734"){
					    capa.innerHTML="ANATOMIA Y BIOMECANICA ELEMENTAL ";
					}else if(opcionSeleccionada=="3735"){
					    capa.innerHTML="ANATOMIA Y FISIOLOGIA ";
					}else if(opcionSeleccionada=="3736"){
					    capa.innerHTML="ANATOMIA Y FISIOLOGIA ANIMAL PRACTICA ";
					}else if(opcionSeleccionada=="3738"){
					    capa.innerHTML="ANTECEDENTES PARA LOS PROBLEMAS DEL SIGLO ";
					}else if(opcionSeleccionada=="3739"){
					    capa.innerHTML="ANTROPOLOGIA CULTURAL ";
					}else if(opcionSeleccionada=="3740"){
					    capa.innerHTML="ANTROPOLOGIA MORAL ";
					}else if(opcionSeleccionada=="3741"){
					    capa.innerHTML="APARATO LOCOMOTOR Y PROTECTOR DEL INFANTE ";
					}else if(opcionSeleccionada=="3742"){
					    capa.innerHTML="APLICACION DE LA QUIMICA INORGANICA ";
					}else if(opcionSeleccionada=="3743"){
					    capa.innerHTML="APLICACION DE LOS FUNDAMENTOS DEL USO DEL CASTELLANO ";
					}else if(opcionSeleccionada=="3744"){
					    capa.innerHTML="APLICACION AL VESTUARIO ";
					}else if(opcionSeleccionada=="3745"){
					    capa.innerHTML="APLICACION DE INTERNET ";
					}else if(opcionSeleccionada=="3746"){
					    capa.innerHTML="APLICACION DE LA COMUNICACION ORAL Y ESCRITA ";
					}else if(opcionSeleccionada=="3747"){
					    capa.innerHTML="APLICACION DE LA FISICA ";
					}else if(opcionSeleccionada=="3748"){
					    capa.innerHTML="APLICACION DE LAS MATEMATICAS EN COMPUTACION ";
					}else if(opcionSeleccionada=="3749"){
					    capa.innerHTML="APLICACION DE SOFTWARE ";
					}else if(opcionSeleccionada=="3750"){
					    capa.innerHTML="APLICACION DE SOFTWARE EDUCATIVOS ";
					}else if(opcionSeleccionada=="3751"){
					    capa.innerHTML="APLICACION ESPECIFICA ";
					}else if(opcionSeleccionada=="3752"){
					    capa.innerHTML="APLICACION GEOMETRICA ";
					}else if(opcionSeleccionada=="3753"){
					    capa.innerHTML="APLICACION GEOMETRICA I ";
					}else if(opcionSeleccionada=="3754"){
					    capa.innerHTML="APLICACION GEOMETRICA II ";
					}else if(opcionSeleccionada=="3755"){
					    capa.innerHTML="APLICACIONES COMPUTACIONALES I ";
					}else if(opcionSeleccionada=="3756"){
					    capa.innerHTML="APLICACIONES COMPUTACIONALES II ";
					}else if(opcionSeleccionada=="3757"){
					    capa.innerHTML="APLICACIONES COMPUTACIONALES Y GESTION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="3758"){
					    capa.innerHTML="APLICACIONES DE LA COMPUTACION A LA GEOMETRIA ";
					}else if(opcionSeleccionada=="3759"){
					    capa.innerHTML="APLICACIONES DE LA MATEMATICA: ELEMENTOS DE COMPUTACION ";
					}else if(opcionSeleccionada=="3760"){
					    capa.innerHTML="APLICACIONES DE LA MORFOSINTAXIS I ";
					}else if(opcionSeleccionada=="3761"){
					    capa.innerHTML="APLICACIONES EN APROVISIONAMIENTO ";
					}else if(opcionSeleccionada=="3762"){
					    capa.innerHTML="APLICACIONES ESPECIFICAS ";
					}else if(opcionSeleccionada=="3763"){
					    capa.innerHTML="APOYO A LA RECREACION DEL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="3764"){
					    capa.innerHTML="APRENDIENDO A REDACTAR ";
					}else if(opcionSeleccionada=="3765"){
					    capa.innerHTML="APRESTO Y PRACTICA PARVULARIA ";
					}else if(opcionSeleccionada=="3697"){
					    capa.innerHTML="AGROFORESTAL ";
					}else if(opcionSeleccionada=="3698"){
					    capa.innerHTML="AGROFORESTERIA ";
					}else if(opcionSeleccionada=="3699"){
					    capa.innerHTML="AGROINDUSTRIA I ";
					}else if(opcionSeleccionada=="3700"){
					    capa.innerHTML="AGROINDUSTRIA III ";
					}else if(opcionSeleccionada=="3701"){
					    capa.innerHTML="AGROINDUSTRIA REGIONAL ";
					}else if(opcionSeleccionada=="3702"){
					    capa.innerHTML="AGROINDUSTRIA Y PACKING ";
					}else if(opcionSeleccionada=="3703"){
					    capa.innerHTML="AGROPECUARIA ARTESANIA ";
					}else if(opcionSeleccionada=="3704"){
					    capa.innerHTML="AGROPECUARIA I ";
					}else if(opcionSeleccionada=="3705"){
					    capa.innerHTML="AGROPECUARIA II ";
					}else if(opcionSeleccionada=="3706"){
					    capa.innerHTML="AGROPECUARIA III (APICULTURA) ";
					}else if(opcionSeleccionada=="3707"){
					    capa.innerHTML="AGROPECUARIA PRACTICA ";
					}else if(opcionSeleccionada=="3708"){
					    capa.innerHTML="AISLACION ";
					}else if(opcionSeleccionada=="3709"){
					    capa.innerHTML="ALEMAN I ";
					}else if(opcionSeleccionada=="3710"){
					    capa.innerHTML="ALGEBRA ARITMETICA ";
					}else if(opcionSeleccionada=="3711"){
					    capa.innerHTML="ALGEBRA ELEMENTAL Y GEOMETRIA EUCLIDIANA ";
					}else if(opcionSeleccionada=="3712"){
					    capa.innerHTML="ALGEBRA II ";
					}else if(opcionSeleccionada=="3713"){
					    capa.innerHTML="ALGEBRA Y GEOMETRIA ANALITICA ";
					}else if(opcionSeleccionada=="3714"){
					    capa.innerHTML="ALGEBRA Y GEOMETRIA ELEMENTAL ";
					}else if(opcionSeleccionada=="3715"){
					    capa.innerHTML="ALGEBRA Y MODELOS ARITMETICOS ";
					}else if(opcionSeleccionada=="3716"){
					    capa.innerHTML="ALGEBRA Y NOCIONES DE GEOMETRIA ";
					}else if(opcionSeleccionada=="3717"){
					    capa.innerHTML="ALGEBRA Y PROBLEMAS ANALITICOS ";
					}else if(opcionSeleccionada=="3718"){
					    capa.innerHTML="ALIMENTACION Y COCINA BASICA ";
					}else if(opcionSeleccionada=="3719"){
					    capa.innerHTML="ALIMENTO RECREATIVOS PARA PARVULOS ";
					}else if(opcionSeleccionada=="3720"){
					    capa.innerHTML="ALIMENTOS Y ALIMENTACION ";
					}else if(opcionSeleccionada=="3721"){
					    capa.innerHTML="ALIMENTOS Y ALIMENTACION ANIMAL ";
					}else if(opcionSeleccionada=="3722"){
					    capa.innerHTML="ALMACENAJE DE ALIMENTOS ";
					}else if(opcionSeleccionada=="3723"){
					    capa.innerHTML="ALTERNATIVAS PRODUCTIVAS ";
					}else if(opcionSeleccionada=="3724"){
					    capa.innerHTML="AMBIENTE Y SALUD ";
					}else if(opcionSeleccionada=="3725"){
					    capa.innerHTML="AMERICA LATINA Y GRANDES TRANSFORMACIONES ";
					}else if(opcionSeleccionada=="3726"){
					    capa.innerHTML="ANALISIS DE EXPERIENCIA ";
					}else if(opcionSeleccionada=="3727"){
					    capa.innerHTML="ANALISIS DE EXPERIENCIAS DE APRENDIZAJE EN LA EMPRESA ";
					}else if(opcionSeleccionada=="3728"){
					    capa.innerHTML="ANALISIS FINANCIERO ";
					}else if(opcionSeleccionada=="3729"){
					    capa.innerHTML="ANALISIS MICROBIOLOGICO DE LOS ALIMENTOS ";
					}else if(opcionSeleccionada=="3730"){
					    capa.innerHTML="ANALISIS QUIMICO ORGANICO ";
					}else if(opcionSeleccionada=="3663"){
					    capa.innerHTML="ADMINISTRACION SERVICIOS DE LA ALIMENTACION COLECTIVA ";
					}else if(opcionSeleccionada=="3664"){
					    capa.innerHTML="ADMINISTRACION SILVOAGROPECUARIA ";
					}else if(opcionSeleccionada=="3665"){
					    capa.innerHTML="ADMINISTRACION TEXTIL ";
					}else if(opcionSeleccionada=="3666"){
					    capa.innerHTML="ADMINISTRACION Y ACCION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="3667"){
					    capa.innerHTML="ADMINISTRACION Y COMERCIALIZACION AGRICOLA ";
					}else if(opcionSeleccionada=="3668"){
					    capa.innerHTML="ADMINISTRACION Y COMERCIO ";
					}else if(opcionSeleccionada=="3669"){
					    capa.innerHTML="ADMINISTRACION Y COMERCIO AGRICOLA ";
					}else if(opcionSeleccionada=="3670"){
					    capa.innerHTML="ADMINISTRACION Y CONTABILIDAD AGRICOLA ";
					}else if(opcionSeleccionada=="3671"){
					    capa.innerHTML="ADMINISTRACION Y COOPERATIVISMO ";
					}else if(opcionSeleccionada=="3672"){
					    capa.innerHTML="ADMINISTRACION Y COSTO ";
					}else if(opcionSeleccionada=="3673"){
					    capa.innerHTML="ADMINISTRACION Y COSTOS FORESTALES ";
					}else if(opcionSeleccionada=="3674"){
					    capa.innerHTML="ADMINISTRACION Y DERECHO LABORAL ";
					}else if(opcionSeleccionada=="3675"){
					    capa.innerHTML="ADMINISTRACION Y DOCUMENTACION MERCANTIL ";
					}else if(opcionSeleccionada=="3676"){
					    capa.innerHTML="ADMINISTRACION Y ECONOMIA BASICA ";
					}else if(opcionSeleccionada=="3677"){
					    capa.innerHTML="ADMINISTRACION Y LABORATORIO ";
					}else if(opcionSeleccionada=="3678"){
					    capa.innerHTML="ADMINISTRACION Y LEGISLACION AGRICOLA ";
					}else if(opcionSeleccionada=="3679"){
					    capa.innerHTML="ADMINISTRACION Y LEGISLACION FORESTAL ";
					}else if(opcionSeleccionada=="3680"){
					    capa.innerHTML="ADMINISTRACION Y LEGISLACION RURAL ";
					}else if(opcionSeleccionada=="3681"){
					    capa.innerHTML="ADMINISTRACION Y LEGISLACION TRIBUTARIA ";
					}else if(opcionSeleccionada=="3682"){
					    capa.innerHTML="ADMINISTRACION Y MANEJO DE LA PRODUCCION ";
					}else if(opcionSeleccionada=="3683"){
					    capa.innerHTML="ADMINISTRACION Y PROGRAMACION ";
					}else if(opcionSeleccionada=="3684"){
					    capa.innerHTML="ADMINISTRACION Y RECURSOS HUMANOS ";
					}else if(opcionSeleccionada=="3685"){
					    capa.innerHTML="ADMINISTRACION Y RELACIONES HUMANAS ";
					}else if(opcionSeleccionada=="3686"){
					    capa.innerHTML="ADMINISTRACION, LEGISLACION Y ETICA ";
					}else if(opcionSeleccionada=="3687"){
					    capa.innerHTML="ADMINISTRACION, LEGISLACION Y SALUD ";
					}else if(opcionSeleccionada=="3688"){
					    capa.innerHTML="ADMINISTRACIONES COMERCIALES ";
					}else if(opcionSeleccionada=="3689"){
					    capa.innerHTML="ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="3690"){
					    capa.innerHTML="ADORNOS NAVIDENOS ";
					}else if(opcionSeleccionada=="3691"){
					    capa.innerHTML="ADQUISICIONES ";
					}else if(opcionSeleccionada=="3692"){
					    capa.innerHTML="AEROFOTOGRAMETRIA ";
					}else if(opcionSeleccionada=="3693"){
					    capa.innerHTML="AGRICOLA ";
					}else if(opcionSeleccionada=="3694"){
					    capa.innerHTML="AGRICULTURA BASICA ";
					}else if(opcionSeleccionada=="3695"){
					    capa.innerHTML="AGRICULTURA ECOLOGICA ";
					}else if(opcionSeleccionada=="3696"){
					    capa.innerHTML="AGROECOLOGIA Y GESTION DEL AGROECOSISTEMA ";
					}else if(opcionSeleccionada=="3626"){
					    capa.innerHTML="ACTIVIDAD CON LA FAMILIA ";
					}else if(opcionSeleccionada=="3627"){
					    capa.innerHTML="ACTIVIDADES AGROPECUARIAS I ";
					}else if(opcionSeleccionada=="3628"){
					    capa.innerHTML="ACTIVIDADES AGROPECUARIAS I Y II ";
					}else if(opcionSeleccionada=="3629"){
					    capa.innerHTML="ACTIVIDADES AIRE Y AVENTURA ";
					}else if(opcionSeleccionada=="3630"){
					    capa.innerHTML="ACTIVIDADES DE APRENDIZAJE EN LA EMPRESA ";
					}else if(opcionSeleccionada=="3631"){
					    capa.innerHTML="ACTIVIDADES DE EXPRESION ";
					}else if(opcionSeleccionada=="3633"){
					    capa.innerHTML="ACTIVIDADES EDUCATIVAS PARA EL TRABAJO ";
					}else if(opcionSeleccionada=="3635"){
					    capa.innerHTML="ACTIVIDADES FORESTALES I ";
					}else if(opcionSeleccionada=="3637"){
					    capa.innerHTML="ACTIVIDADES MUSICALES ";
					}else if(opcionSeleccionada=="3638"){
					    capa.innerHTML="ACTUALIDAD ";
					}else if(opcionSeleccionada=="3639"){
					    capa.innerHTML="ACUSTICA ";
					}else if(opcionSeleccionada=="3640"){
					    capa.innerHTML="ADMINISTRACION AGROPECUARIA ";
					}else if(opcionSeleccionada=="3641"){
					    capa.innerHTML="ADMINISTRACION COMERCIAL Y PESQUERA ";
					}else if(opcionSeleccionada=="3642"){
					    capa.innerHTML="ADMINISTRACION CONTABLE ";
					}else if(opcionSeleccionada=="3643"){
					    capa.innerHTML="ADMINISTRACION DE ADQUISICION Y ALMACENAJE ";
					}else if(opcionSeleccionada=="3644"){
					    capa.innerHTML="ADMINISTRACION DE BASE DE DATOS ";
					}else if(opcionSeleccionada=="3645"){
					    capa.innerHTML="ADMINISTRACION DE CASINOS Y SERVICIOS ALIMENTARIOS ";
					}else if(opcionSeleccionada=="3646"){
					    capa.innerHTML="ADMINISTRACION DE COSTOS Y... ";
					}else if(opcionSeleccionada=="3647"){
					    capa.innerHTML="ADMINISTRACION DE EMPRESA Y PERSONAL ";
					}else if(opcionSeleccionada=="3648"){
					    capa.innerHTML="ADMINISTRACION DE FINANZAS ";
					}else if(opcionSeleccionada=="3649"){
					    capa.innerHTML="ADMINISTRACION DE LA COMERCIALIZACION ";
					}else if(opcionSeleccionada=="3650"){
					    capa.innerHTML="ADMINISTRACION DE SERVICIOS GASTRONOMICOS ";
					}else if(opcionSeleccionada=="3651"){
					    capa.innerHTML="ADMINISTRACION DE TALLERES O PEQUENA EMPRESA ";
					}else if(opcionSeleccionada=="3652"){
					    capa.innerHTML="ADMINISTRACION E INFORMATICA ";
					}else if(opcionSeleccionada=="3653"){
					    capa.innerHTML="ADMINISTRACION EDUCACION PARVULARIA ";
					}else if(opcionSeleccionada=="3654"){
					    capa.innerHTML="ADMINISTRACION FINANCIERA PRESUPUESTARIA ";
					}else if(opcionSeleccionada=="3655"){
					    capa.innerHTML="ADMINISTRACION FORESTAL ";
					}else if(opcionSeleccionada=="3656"){
					    capa.innerHTML="ADMINISTRACION GASTRONOMICA ";
					}else if(opcionSeleccionada=="3657"){
					    capa.innerHTML="ADMINISTRACION HOTELES Y RESTAURANTES ";
					}else if(opcionSeleccionada=="3658"){
					    capa.innerHTML="ADMINISTRACION INVENTARIO Y BODEGA ";
					}else if(opcionSeleccionada=="3659"){
					    capa.innerHTML="ADMINISTRACION LEGISLATIVA Y ETICA PROFESIONAL ";
					}else if(opcionSeleccionada=="3660"){
					    capa.innerHTML="ADMINISTRACION OPERACIONES PORTUARIAS 2 ";
					}else if(opcionSeleccionada=="3661"){
					    capa.innerHTML="ADMINISTRACION PEQUENA EMPRESA ";
					}else if(opcionSeleccionada=="3662"){
					    capa.innerHTML="ADMINISTRACION POR OBJETIVOS ";
					}else if(opcionSeleccionada=="3592"){
					    capa.innerHTML="REDACCION ADMINISTRATIVA Y COMERCIAL ";
					}else if(opcionSeleccionada=="3593"){
					    capa.innerHTML="REDACCION ADMINISTRATIVA Y LABORAL ";
					}else if(opcionSeleccionada=="3594"){
					    capa.innerHTML="REDACCION COMERCIAL II ";
					}else if(opcionSeleccionada=="3595"){
					    capa.innerHTML="REDACCION DE DOCUMENTOS USUALES ";
					}else if(opcionSeleccionada=="3596"){
					    capa.innerHTML="RIEGO Y DRENAJE ";
					}else if(opcionSeleccionada=="3597"){
					    capa.innerHTML="SANIDAD Y PATOLOGIA FORESTAL ";
					}else if(opcionSeleccionada=="3598"){
					    capa.innerHTML="SERVICIO ";
					}else if(opcionSeleccionada=="3599"){
					    capa.innerHTML="SOCIEDAD Y EMPRESA ";
					}else if(opcionSeleccionada=="3600"){
					    capa.innerHTML="SUELOS ";
					}else if(opcionSeleccionada=="3601"){
					    capa.innerHTML="TALLER DE DESARROLLO REGIONAL ";
					}else if(opcionSeleccionada=="3602"){
					    capa.innerHTML="TALLER DE EXPRESION ARTISTICA CORPORAL ";
					}else if(opcionSeleccionada=="3603"){
					    capa.innerHTML="TALLER DE EXPRESION CORPORAL ";
					}else if(opcionSeleccionada=="3604"){
					    capa.innerHTML="TALLER DE GESTION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="3605"){
					    capa.innerHTML="TALLER DE PRACTICAS ADMINISTRATIVAS Y COMERCIALES ";
					}else if(opcionSeleccionada=="3606"){
					    capa.innerHTML="TALLER DE PROYECTOS SILVOAGROPECUARIOS ";
					}else if(opcionSeleccionada=="3607"){
					    capa.innerHTML="TALLER DE SERVICIOS Y TECNICAS TURISTICAS ";
					}else if(opcionSeleccionada=="3608"){
					    capa.innerHTML="TALLER SECRETARIAL ";
					}else if(opcionSeleccionada=="3609"){
					    capa.innerHTML="TALLER SERVICIOS GASTRONOMICOS ";
					}else if(opcionSeleccionada=="3610"){
					    capa.innerHTML="TALLER TECNICO SECRETARIAL ";
					}else if(opcionSeleccionada=="3611"){
					    capa.innerHTML="TALLER Y EQUIPOS FORESTALES ";
					}else if(opcionSeleccionada=="3612"){
					    capa.innerHTML="TALLERES TECNICOS AGROPECUARIOS ";
					}else if(opcionSeleccionada=="3613"){
					    capa.innerHTML="TECNICAS FORESTALES III ";
					}else if(opcionSeleccionada=="3614"){
					    capa.innerHTML="TECNOLOGIA FORESTAL III ";
					}else if(opcionSeleccionada=="3615"){
					    capa.innerHTML="TECNOLOGIA PRACTICA Y LABORATORIO DE TALLER ";
					}else if(opcionSeleccionada=="3616"){
					    capa.innerHTML="TEORIA DE LA COMPUTACION II ";
					}else if(opcionSeleccionada=="3617"){
					    capa.innerHTML="TEORIA DE LA COMUNICACION LINGUISTICA ";
					}else if(opcionSeleccionada=="3618"){
					    capa.innerHTML="TRAMITE Y DOCUMENTACION LEGAL ";
					}else if(opcionSeleccionada=="3619"){
					    capa.innerHTML="TRANSPORTE Y COMERCIALIZACION ";
					}else if(opcionSeleccionada=="3620"){
					    capa.innerHTML="USO DIARIO DEL COMPUTADOR ";
					}else if(opcionSeleccionada=="3621"){
					    capa.innerHTML="VESTUARIO ";
					}else if(opcionSeleccionada=="3622"){
					    capa.innerHTML="VISION DE LA GEOGRAFIA ECONOMICA DE CHILE ";
					}else if(opcionSeleccionada=="3623"){
					    capa.innerHTML="ACADEMIA CIENTIFICA ";
					}else if(opcionSeleccionada=="3624"){
					    capa.innerHTML="ACADEMIA MUSICAL ";
					}else if(opcionSeleccionada=="3625"){
					    capa.innerHTML="ACONDICIONAMIENTO FISICO Y DEPORTE ";
					}else if(opcionSeleccionada=="3558"){
					    capa.innerHTML="MAQUINARIA AGRICOLA II ";
					}else if(opcionSeleccionada=="3559"){
					    capa.innerHTML="MATEMATICA FINANCIERA II ";
					}else if(opcionSeleccionada=="3560"){
					    capa.innerHTML="MATEMATICAS (ELECTIVAS) ";
					}else if(opcionSeleccionada=="3561"){
					    capa.innerHTML="MECANICA GENERAL I ";
					}else if(opcionSeleccionada=="3562"){
					    capa.innerHTML="MECANICA GENERAL II ";
					}else if(opcionSeleccionada=="3563"){
					    capa.innerHTML="MENSURA Y UTILIZACION FORESTAL ";
					}else if(opcionSeleccionada=="3564"){
					    capa.innerHTML="MORFOFISIOLOGIA COMPARADA A NIVEL ANIMAL Y VEGETAL ";
					}else if(opcionSeleccionada=="3565"){
					    capa.innerHTML="MORFOSINTAXIS ";
					}else if(opcionSeleccionada=="3566"){
					    capa.innerHTML="MOTORES MARINOS ";
					}else if(opcionSeleccionada=="3567"){
					    capa.innerHTML="MUEBLERIA BASICA ";
					}else if(opcionSeleccionada=="3568"){
					    capa.innerHTML="MUNDO AGROPECUARIO ";
					}else if(opcionSeleccionada=="3569"){
					    capa.innerHTML="NOCIONES BASICAS DE INFORMATICA Y COMPUTACION ";
					}else if(opcionSeleccionada=="3570"){
					    capa.innerHTML="NOCIONES DE SECRETARIADO ";
					}else if(opcionSeleccionada=="3571"){
					    capa.innerHTML="NOCIONES DEL DERECHO DEL TRABAJO Y SEGURIDAD SOCIAL ";
					}else if(opcionSeleccionada=="3572"){
					    capa.innerHTML="NOCIONES GENERALES DE LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="3573"){
					    capa.innerHTML="ORDENA Y CONSERVACION DE FORRAJE ";
					}else if(opcionSeleccionada=="3574"){
					    capa.innerHTML="PATRIMONIO HISTORICO CULTURAL ";
					}else if(opcionSeleccionada=="3575"){
					    capa.innerHTML="PLAN MATEMATICO ";
					}else if(opcionSeleccionada=="3576"){
					    capa.innerHTML="PREVENCION Y CONTROL DE INCENDIOS FORESTALES ";
					}else if(opcionSeleccionada=="3577"){
					    capa.innerHTML="PRIMEROS AUXILIOS II ";
					}else if(opcionSeleccionada=="3578"){
					    capa.innerHTML="PROBLEMATICA AMBIENTAL ";
					}else if(opcionSeleccionada=="3579"){
					    capa.innerHTML="PROCESAMIENTO ";
					}else if(opcionSeleccionada=="3580"){
					    capa.innerHTML="PROCESOS PRACTICOS ";
					}else if(opcionSeleccionada=="3581"){
					    capa.innerHTML="PROD. REG. : VETERINARIA PRACTICA ";
					}else if(opcionSeleccionada=="3582"){
					    capa.innerHTML="PRODUCCION ANIMAL I ";
					}else if(opcionSeleccionada=="3583"){
					    capa.innerHTML="PRODUCCION FORESTAL ";
					}else if(opcionSeleccionada=="3584"){
					    capa.innerHTML="PRODUCCION VEGETAL II ";
					}else if(opcionSeleccionada=="3585"){
					    capa.innerHTML="PROGRAMACION Y SOFTWARE COMPUTACIONAL ";
					}else if(opcionSeleccionada=="3586"){
					    capa.innerHTML="PROTECCION Y LEGISLACION FORESTAL ";
					}else if(opcionSeleccionada=="3587"){
					    capa.innerHTML="PSICOLOGIA DEL ADOLESCENTE ";
					}else if(opcionSeleccionada=="3588"){
					    capa.innerHTML="PSICOLOGIA PUBLICITARIA ";
					}else if(opcionSeleccionada=="3589"){
					    capa.innerHTML="PSICOLOGIA Y ETICA ";
					}else if(opcionSeleccionada=="3590"){
					    capa.innerHTML="RECURSOS DEL MAR ";
					}else if(opcionSeleccionada=="3591"){
					    capa.innerHTML="RECURSOS NATURALES BASICOS ";
					}else if(opcionSeleccionada=="3524"){
					    capa.innerHTML="GEOGRAFIA REGIONAL: DECIMA REGION ";
					}else if(opcionSeleccionada=="3525"){
					    capa.innerHTML="HISTORIA DE LA CULTURA I ";
					}else if(opcionSeleccionada=="3526"){
					    capa.innerHTML="HISTORIA DE LA CULTURA II ";
					}else if(opcionSeleccionada=="3527"){
					    capa.innerHTML="HISTORIA PRECOLOMBINA ";
					}else if(opcionSeleccionada=="3528"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA DE CHILE I ";
					}else if(opcionSeleccionada=="3529"){
					    capa.innerHTML="INFORMACION Y PROGRAMACION TOUR ";
					}else if(opcionSeleccionada=="3530"){
					    capa.innerHTML="INFORMATICA Y COMPUTACION II ";
					}else if(opcionSeleccionada=="3531"){
					    capa.innerHTML="INGLES AVANZADO EN LABORATORIO DE IDIOMAS ";
					}else if(opcionSeleccionada=="3532"){
					    capa.innerHTML="INSTALACIONES SANITARIAS ";
					}else if(opcionSeleccionada=="3533"){
					    capa.innerHTML="INSTRUMENTOS MUSICALES ";
					}else if(opcionSeleccionada=="3534"){
					    capa.innerHTML="INSTRUMENTOS Y EQUIPOS ";
					}else if(opcionSeleccionada=="3535"){
					    capa.innerHTML="INTRODUCCION A LA COMPUTACION Y FUNDAMENTOS DE LA PROGRAMACION ";
					}else if(opcionSeleccionada=="3536"){
					    capa.innerHTML="INTRODUCCION A LA DACTILOGRAFIA EN MAQUINAS ELECTRICAS Y COMPUTADORES II ";
					}else if(opcionSeleccionada=="3537"){
					    capa.innerHTML="INTRODUCCION A LA ECOLOGIA ";
					}else if(opcionSeleccionada=="3538"){
					    capa.innerHTML="INTRODUCCION A LA MICROBIOLOGIA ";
					}else if(opcionSeleccionada=="3539"){
					    capa.innerHTML="INTRODUCCION A LAS TECNICAS DE CULTIVO ";
					}else if(opcionSeleccionada=="3540"){
					    capa.innerHTML="INTRODUCCION A LOS ALIMENTOS ";
					}else if(opcionSeleccionada=="3541"){
					    capa.innerHTML="LA MADERA EN LA INDUSTRIA ";
					}else if(opcionSeleccionada=="3542"){
					    capa.innerHTML="LA TIERRA EN QUE VIVIMOS ";
					}else if(opcionSeleccionada=="3543"){
					    capa.innerHTML="LABORATORIO INGLES INSTRUMENTAL ";
					}else if(opcionSeleccionada=="3544"){
					    capa.innerHTML="LABORATORIO Y TECNICAS DE VENTAS ";
					}else if(opcionSeleccionada=="3545"){
					    capa.innerHTML="LECHERIA Y CRIANZA DE TERNEROS ";
					}else if(opcionSeleccionada=="3546"){
					    capa.innerHTML="LEGISLACION APLICADA ";
					}else if(opcionSeleccionada=="3547"){
					    capa.innerHTML="LEGISLACION PESQUERA ";
					}else if(opcionSeleccionada=="3548"){
					    capa.innerHTML="LEGISLACION RURAL Y ECONOMIA ";
					}else if(opcionSeleccionada=="3549"){
					    capa.innerHTML="LINGUISTICA GENERAL ";
					}else if(opcionSeleccionada=="3550"){
					    capa.innerHTML="LITERATURA CHILENA ";
					}else if(opcionSeleccionada=="3551"){
					    capa.innerHTML="LOCOMOCION ANIMAL ";
					}else if(opcionSeleccionada=="3552"){
					    capa.innerHTML="MANEJO DE PRADERAS ";
					}else if(opcionSeleccionada=="3553"){
					    capa.innerHTML="MANEJO GANADERO ";
					}else if(opcionSeleccionada=="3554"){
					    capa.innerHTML="MANEJO INSTRUMENTAL DEL IDIOMA ESPANOL ";
					}else if(opcionSeleccionada=="3555"){
					    capa.innerHTML="MANEJO INSTRUMENTAL DEL IDIOMA ESPANOL II ";
					}else if(opcionSeleccionada=="3556"){
					    capa.innerHTML="MANTENCION DE EQUIPOS INDUSTRIALES ";
					}else if(opcionSeleccionada=="3557"){
					    capa.innerHTML="MANUAL Y REPOSTERIA FINA ";
					}else if(opcionSeleccionada=="3490"){
					    capa.innerHTML="DEL PARLAMENTARISMO AL PRESIDENCIALISMO ";
					}else if(opcionSeleccionada=="3491"){
					    capa.innerHTML="DEPORTE ESPECIALIZADO ";
					}else if(opcionSeleccionada=="3492"){
					    capa.innerHTML="DERECHO ECONOMICO ";
					}else if(opcionSeleccionada=="3493"){
					    capa.innerHTML="DESARROLLO DE LA PERSONA EN EL CONTEXTO DE LA VIDA FAMILIAR ";
					}else if(opcionSeleccionada=="3494"){
					    capa.innerHTML="DESARROLLO VALORICO ";
					}else if(opcionSeleccionada=="3495"){
					    capa.innerHTML="DIAGRAMACION APLICADA ";
					}else if(opcionSeleccionada=="3496"){
					    capa.innerHTML="DISENO Y EQUIPAMIENTO TURISTICO ";
					}else if(opcionSeleccionada=="3497"){
					    capa.innerHTML="DOCUMENTACION CONTABLE II ";
					}else if(opcionSeleccionada=="3498"){
					    capa.innerHTML="ECONOMIA AGRARIA ";
					}else if(opcionSeleccionada=="3499"){
					    capa.innerHTML="EDUCACION Y SALUD ";
					}else if(opcionSeleccionada=="3500"){
					    capa.innerHTML="EL MUNDO DEL PEQUENO EMPRESARIO ";
					}else if(opcionSeleccionada=="3501"){
					    capa.innerHTML="ELECTRICIDAD AUTOMOTRIZ I ";
					}else if(opcionSeleccionada=="3502"){
					    capa.innerHTML="ELECTRICIDAD AUTOMOTRIZ II ";
					}else if(opcionSeleccionada=="3503"){
					    capa.innerHTML="ELECTRICIDAD BASICA DEL HOGAR ";
					}else if(opcionSeleccionada=="3504"){
					    capa.innerHTML="ELEMENTOS DE COMPUTACION Y MATEMATICA FINANCIERA ";
					}else if(opcionSeleccionada=="3505"){
					    capa.innerHTML="ENERGIA Y CONSTRUCCION ";
					}else if(opcionSeleccionada=="3506"){
					    capa.innerHTML="ENFERMEDADES Y PLAGAS FORESTALES ";
					}else if(opcionSeleccionada=="3507"){
					    capa.innerHTML="ENFERMERIA ANIMAL ";
					}else if(opcionSeleccionada=="3508"){
					    capa.innerHTML="ENFERMERIA DE GANADO ";
					}else if(opcionSeleccionada=="3509"){
					    capa.innerHTML="ENOLOGIA ";
					}else if(opcionSeleccionada=="3510"){
					    capa.innerHTML="ESPANOL INSTRUMENTAL I ";
					}else if(opcionSeleccionada=="3511"){
					    capa.innerHTML="ESPANOL INSTRUMENTAL II ";
					}else if(opcionSeleccionada=="3512"){
					    capa.innerHTML="ESTUDIO PATRIMONIO CULTURAL DE OSORNO ";
					}else if(opcionSeleccionada=="3513"){
					    capa.innerHTML="ETICA Y COMPORTAMIENTO PROFESIONAL ";
					}else if(opcionSeleccionada=="3514"){
					    capa.innerHTML="EXPERIMENTACION GANADERA ";
					}else if(opcionSeleccionada=="3515"){
					    capa.innerHTML="FISICA (ELECTIVAS) ";
					}else if(opcionSeleccionada=="3516"){
					    capa.innerHTML="FISICA ELECTIVA I ";
					}else if(opcionSeleccionada=="3517"){
					    capa.innerHTML="FISICA ELECTIVA II ";
					}else if(opcionSeleccionada=="3518"){
					    capa.innerHTML="FISICA ELECTIVO ";
					}else if(opcionSeleccionada=="3519"){
					    capa.innerHTML="FITOTECNIA GENERAL Y ESPECIAL ";
					}else if(opcionSeleccionada=="3520"){
					    capa.innerHTML="FRUTALES MAYORES ";
					}else if(opcionSeleccionada=="3521"){
					    capa.innerHTML="FUNDAMENTO DE ELECTRICIDAD I ";
					}else if(opcionSeleccionada=="3522"){
					    capa.innerHTML="GEOGRAFIA APLICADA I ";
					}else if(opcionSeleccionada=="3523"){
					    capa.innerHTML="GEOGRAFIA APLICADA II ";
					}else if(opcionSeleccionada=="3453"){
					    capa.innerHTML="ADMINISTRACION Y FINANZAS ";
					}else if(opcionSeleccionada=="3454"){
					    capa.innerHTML="ADMINISTRACION Y LEGISLACION TURISTICA ";
					}else if(opcionSeleccionada=="3455"){
					    capa.innerHTML="AGRICULTURA II ";
					}else if(opcionSeleccionada=="3456"){
					    capa.innerHTML="ALIMENTACION COLECTIVA Y ADMINISTRACION DE CASINOS ";
					}else if(opcionSeleccionada=="3457"){
					    capa.innerHTML="ANATOMIA COMPARADA ";
					}else if(opcionSeleccionada=="3458"){
					    capa.innerHTML="ANATOMIA COMPARADA I ";
					}else if(opcionSeleccionada=="3459"){
					    capa.innerHTML="APLICACION DE LA INFORMATICA ";
					}else if(opcionSeleccionada=="3460"){
					    capa.innerHTML="APLICACIONES DE LA MATEMATICA: TRIGONOMETRIA PLANA ";
					}else if(opcionSeleccionada=="3461"){
					    capa.innerHTML="APRECIACION CINEMATOGRAFICA ";
					}else if(opcionSeleccionada=="3462"){
					    capa.innerHTML="APRECIACION CINEMATOGRAFICA Y TV ";
					}else if(opcionSeleccionada=="3463"){
					    capa.innerHTML="APROXIMACION A LA REDACCION COMERCIAL ";
					}else if(opcionSeleccionada=="3464"){
					    capa.innerHTML="ARBORICULTURA ";
					}else if(opcionSeleccionada=="3465"){
					    capa.innerHTML="ARBORICULTURA FRUTAL Y FORESTAL ";
					}else if(opcionSeleccionada=="3467"){
					    capa.innerHTML="BIOLOGIA EVOLUTIVA I ";
					}else if(opcionSeleccionada=="3468"){
					    capa.innerHTML="BOTANICA BASICA ";
					}else if(opcionSeleccionada=="3469"){
					    capa.innerHTML="BOVINOS DE CARNE ";
					}else if(opcionSeleccionada=="3470"){
					    capa.innerHTML="BUCEO ";
					}else if(opcionSeleccionada=="3471"){
					    capa.innerHTML="CASTELLANO I ";
					}else if(opcionSeleccionada=="3472"){
					    capa.innerHTML="CINE ";
					}else if(opcionSeleccionada=="3473"){
					    capa.innerHTML="COCINA I ";
					}else if(opcionSeleccionada=="3474"){
					    capa.innerHTML="COLONIZACION ALEMANA EN CHILE ";
					}else if(opcionSeleccionada=="3475"){
					    capa.innerHTML="COMERCIALIZACION TURISTICA ";
					}else if(opcionSeleccionada=="3477"){
					    capa.innerHTML="COMPRENSION DEL IDIOMA MATERNO II ";
					}else if(opcionSeleccionada=="3478"){
					    capa.innerHTML="COMPUTACION Y TECNICAS DE MUESTREO ";
					}else if(opcionSeleccionada=="3479"){
					    capa.innerHTML="CONOCIENDO EL MUNDO DE LA COMPUTACION I ";
					}else if(opcionSeleccionada=="3480"){
					    capa.innerHTML="CONSERVACION Y MANTENCION DE RECURSOS NATURALES RE ";
					}else if(opcionSeleccionada=="3481"){
					    capa.innerHTML="CONSTRUCCIONES PREDIALES ";
					}else if(opcionSeleccionada=="3482"){
					    capa.innerHTML="CONTROL DE COSTOS ";
					}else if(opcionSeleccionada=="3483"){
					    capa.innerHTML="CORTE Y CONFECCION ";
					}else if(opcionSeleccionada=="3484"){
					    capa.innerHTML="CREACIONES TECNOLOGICAS ";
					}else if(opcionSeleccionada=="3486"){
					    capa.innerHTML="CULTURA ALEMANA ";
					}else if(opcionSeleccionada=="3487"){
					    capa.innerHTML="DACTILOGRAFIA I ";
					}else if(opcionSeleccionada=="3488"){
					    capa.innerHTML="DACTILOGRAFIA II ";
					}else if(opcionSeleccionada=="3489"){
					    capa.innerHTML="DANZAS FOLCLORICAS CHILENAS ";
					}else if(opcionSeleccionada=="3419"){
					    capa.innerHTML="TECNOLOGIA EN TEATRO ";
					}else if(opcionSeleccionada=="3420"){
					    capa.innerHTML="TECNOLOGIA FORESTAL IV ";
					}else if(opcionSeleccionada=="3421"){
					    capa.innerHTML="TECNOLOGIA I ";
					}else if(opcionSeleccionada=="3422"){
					    capa.innerHTML="TECNOLOGIA II ";
					}else if(opcionSeleccionada=="3423"){
					    capa.innerHTML="TECNOLOGIA SANITARIA Y MEDIO AMBIENTAL I ";
					}else if(opcionSeleccionada=="3424"){
					    capa.innerHTML="TECNOLOGIA Y PRACTICA APLICADA AL SECTOR MARITIMO I ";
					}else if(opcionSeleccionada=="3425"){
					    capa.innerHTML="TECNOLOGIA Y PRACTICA APLICADA AL SECTOR MARITIMO II ";
					}else if(opcionSeleccionada=="3426"){
					    capa.innerHTML="TECNOLOGICA DE MANEJOS ACUATICOS I ";
					}else if(opcionSeleccionada=="3427"){
					    capa.innerHTML="TEORIA Y TECNICA DEL TURISMO ";
					}else if(opcionSeleccionada=="3428"){
					    capa.innerHTML="TERMOTECNIA ";
					}else if(opcionSeleccionada=="3429"){
					    capa.innerHTML="TOPOGRAFIA BASICA ";
					}else if(opcionSeleccionada=="3430"){
					    capa.innerHTML="TRABAJO PRACTICO ";
					}else if(opcionSeleccionada=="3431"){
					    capa.innerHTML="TRANSMISIONES MECANICAS E HIDRAULICAS ";
					}else if(opcionSeleccionada=="3432"){
					    capa.innerHTML="TRIGONOMETRIA Y GEOMETRIA ";
					}else if(opcionSeleccionada=="3433"){
					    capa.innerHTML="UTILIZACION DE BOSQUES ";
					}else if(opcionSeleccionada=="3434"){
					    capa.innerHTML="UTILIZACION FORESTAL ";
					}else if(opcionSeleccionada=="3435"){
					    capa.innerHTML="VIVEROS FORESTALES ";
					}else if(opcionSeleccionada=="3436"){
					    capa.innerHTML="ZOOLOGIA ";
					}else if(opcionSeleccionada=="3437"){
					    capa.innerHTML="ANALISIS DE LA EMPRESA ";
					}else if(opcionSeleccionada=="3438"){
					    capa.innerHTML="INICIACION AL PERIODISMO ";
					}else if(opcionSeleccionada=="3439"){
					    capa.innerHTML="INTRODUCCION A LA ESPECIALIDAD DE GASTRONOMIA Y HOTELERIA ";
					}else if(opcionSeleccionada=="3440"){
					    capa.innerHTML="INTRODUCCION AL ESTUDIO DE LA TRANSMICION HEREDITARA ";
					}else if(opcionSeleccionada=="3441"){
					    capa.innerHTML="SOCIAL COMUNICATIVO (INGLES) ";
					}else if(opcionSeleccionada=="3442"){
					    capa.innerHTML="TALLER 1 (E.T.P. HOTELERIA) ";
					}else if(opcionSeleccionada=="3443"){
					    capa.innerHTML="TALLER 2 (E.T.P. HOTELERIA) ";
					}else if(opcionSeleccionada=="3444"){
					    capa.innerHTML="TALLER DUAL ";
					}else if(opcionSeleccionada=="3445"){
					    capa.innerHTML="ADMINISTRACION AGRICOLA I ";
					}else if(opcionSeleccionada=="3446"){
					    capa.innerHTML="ADMINISTRACION E INVESTIGACION DE MERCADO ";
					}else if(opcionSeleccionada=="3447"){
					    capa.innerHTML="ADMINISTRACION EMPRESAS TURISTICAS ";
					}else if(opcionSeleccionada=="3448"){
					    capa.innerHTML="ADMINISTRACION FORESTAL Y COMPUTACION ";
					}else if(opcionSeleccionada=="3449"){
					    capa.innerHTML="ADMINISTRACION I ";
					}else if(opcionSeleccionada=="3450"){
					    capa.innerHTML="ADMINISTRACION LABORAL ";
					}else if(opcionSeleccionada=="3451"){
					    capa.innerHTML="ADMINISTRACION RURAL I ";
					}else if(opcionSeleccionada=="3452"){
					    capa.innerHTML="ADMINISTRACION Y CONTABILIDAD ";
					}else if(opcionSeleccionada=="3385"){
					    capa.innerHTML="TECNICAS DE CULTIVO DE ALGAS ";
					}else if(opcionSeleccionada=="3386"){
					    capa.innerHTML="TECNICAS DE CULTIVO DE MOLUSCOS ";
					}else if(opcionSeleccionada=="3387"){
					    capa.innerHTML="TECNICAS DE CULTIVO DE PECES ";
					}else if(opcionSeleccionada=="3388"){
					    capa.innerHTML="TECNICAS DE ELABORACION ";
					}else if(opcionSeleccionada=="3389"){
					    capa.innerHTML="TECNICAS DE OFICINA Y MANEJO DE ARCHIVOS ";
					}else if(opcionSeleccionada=="3390"){
					    capa.innerHTML="TECNICAS DE PLENARIO ";
					}else if(opcionSeleccionada=="3391"){
					    capa.innerHTML="TECNICAS DE PROCESO ";
					}else if(opcionSeleccionada=="3392"){
					    capa.innerHTML="TECNICAS DE RECREACION APLICADA ";
					}else if(opcionSeleccionada=="3393"){
					    capa.innerHTML="TECNICAS FORESTALES IV ";
					}else if(opcionSeleccionada=="3394"){
					    capa.innerHTML="TECNICAS PARA EL APRENDIZAJE INTEGRADO ";
					}else if(opcionSeleccionada=="3395"){
					    capa.innerHTML="TECNOLOGIA ALIMENTOS Y BEBIDAS ";
					}else if(opcionSeleccionada=="3396"){
					    capa.innerHTML="TECNOLOGIA APLICADA ELECTRICIDAD AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="3397"){
					    capa.innerHTML="TECNOLOGIA DE LAS INSTALACIONES ELECTRICAS ";
					}else if(opcionSeleccionada=="3398"){
					    capa.innerHTML="TECNOLOGIA DE NATACION Y BUCEO ";
					}else if(opcionSeleccionada=="3399"){
					    capa.innerHTML="TECNOLOGIA DE PROCESAMIENTO ";
					}else if(opcionSeleccionada=="3400"){
					    capa.innerHTML="TECNOLOGIA DE PROCESOS Y CONTROL DE ALIMENTOS ";
					}else if(opcionSeleccionada=="3401"){
					    capa.innerHTML="TECNOLOGIA DEL DISENO ESTRUCTURAL ";
					}else if(opcionSeleccionada=="3402"){
					    capa.innerHTML="TECNOLOGIA DUAL ";
					}else if(opcionSeleccionada=="3403"){
					    capa.innerHTML="TECNOLOGIA EN ADMINISTRACION ";
					}else if(opcionSeleccionada=="3404"){
					    capa.innerHTML="TECNOLOGIA EN ADMINISTRACION HOTELERA ";
					}else if(opcionSeleccionada=="3405"){
					    capa.innerHTML="TECNOLOGIA EN AREAS HOTELERAS ";
					}else if(opcionSeleccionada=="3406"){
					    capa.innerHTML="TECNOLOGIA EN CULTIVOS ";
					}else if(opcionSeleccionada=="3407"){
					    capa.innerHTML="TECNOLOGIA EN EDUCACION PARVULARIA Y EN EDUCACION DIFERENCIAL ";
					}else if(opcionSeleccionada=="3408"){
					    capa.innerHTML="TECNOLOGIA EN INDUSTRIA DE ALIMENTOS ";
					}else if(opcionSeleccionada=="3409"){
					    capa.innerHTML="TECNOLOGIA EN INDUSTRIA DE SALMONES ";
					}else if(opcionSeleccionada=="3410"){
					    capa.innerHTML="TECNOLOGIA EN MANEJO DEL BOSQUE ";
					}else if(opcionSeleccionada=="3411"){
					    capa.innerHTML="TECNOLOGIA EN MAQUINAS Y EQUIPOS AGRICOLAS ";
					}else if(opcionSeleccionada=="3412"){
					    capa.innerHTML="TECNOLOGIA EN MENSURA E INVENTARIO DEL BOSQUE ";
					}else if(opcionSeleccionada=="3413"){
					    capa.innerHTML="TECNOLOGIA EN MERCADOTECNIA ";
					}else if(opcionSeleccionada=="3414"){
					    capa.innerHTML="TECNOLOGIA EN PRODUCCION ANIMAL ";
					}else if(opcionSeleccionada=="3415"){
					    capa.innerHTML="TECNOLOGIA EN PRODUCCION FORESTAL ";
					}else if(opcionSeleccionada=="3416"){
					    capa.innerHTML="TECNOLOGIA EN PRODUCCION VEGETAL ";
					}else if(opcionSeleccionada=="3417"){
					    capa.innerHTML="TECNOLOGIA EN SALUD Y PRIMEROS AUXILIOS ";
					}else if(opcionSeleccionada=="3418"){
					    capa.innerHTML="TECNOLOGIA EN SANEAMIENTO ";
					}else if(opcionSeleccionada=="3351"){
					    capa.innerHTML="SILVICULTURA II ";
					}else if(opcionSeleccionada=="3352"){
					    capa.innerHTML="SISTEMA DE INFORMACION Y MUESTREO ";
					}else if(opcionSeleccionada=="3353"){
					    capa.innerHTML="SISTEMA DE SUPERVISION ";
					}else if(opcionSeleccionada=="3354"){
					    capa.innerHTML="SISTEMA ELECTROMECANICO ";
					}else if(opcionSeleccionada=="3355"){
					    capa.innerHTML="SISTEMAS DE REFRIGERACION ";
					}else if(opcionSeleccionada=="3356"){
					    capa.innerHTML="SISTEMAS DE REFRIGERACION Y ENVAS ";
					}else if(opcionSeleccionada=="3357"){
					    capa.innerHTML="SISTEMAS Y METODOS DE PESCA ";
					}else if(opcionSeleccionada=="3358"){
					    capa.innerHTML="SOCIOLOGIA RURAL ";
					}else if(opcionSeleccionada=="3359"){
					    capa.innerHTML="SOCIOLOGIA Y EXTENSION RURAL ";
					}else if(opcionSeleccionada=="3360"){
					    capa.innerHTML="SOFTWARE COMPUTACIONAL II ";
					}else if(opcionSeleccionada=="3361"){
					    capa.innerHTML="SOFTWARE COMPUTACIONAL III ";
					}else if(opcionSeleccionada=="3362"){
					    capa.innerHTML="SOLDADURA Y ESTRUCTURAS ";
					}else if(opcionSeleccionada=="3363"){
					    capa.innerHTML="SUELOS FORESTALES ";
					}else if(opcionSeleccionada=="3364"){
					    capa.innerHTML="SUELOS, FERTILIZANTES Y REGADIO ";
					}else if(opcionSeleccionada=="3365"){
					    capa.innerHTML="TALLER DE ARTES APLICADAS ";
					}else if(opcionSeleccionada=="3366"){
					    capa.innerHTML="TALLER DE ARTES MUSICALES ";
					}else if(opcionSeleccionada=="3367"){
					    capa.innerHTML="TALLER DE CANALIZACIONES ELECTRICAS ";
					}else if(opcionSeleccionada=="3368"){
					    capa.innerHTML="TALLER DE CONSTRUCCION ";
					}else if(opcionSeleccionada=="3369"){
					    capa.innerHTML="TALLER DE DEPORTE Y RECREACION ";
					}else if(opcionSeleccionada=="3370"){
					    capa.innerHTML="TALLER DE ELECTRICIDAD AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="3371"){
					    capa.innerHTML="TALLER DE GUITARRA ";
					}else if(opcionSeleccionada=="3372"){
					    capa.innerHTML="TALLER DE INFORMATICA APLICADA ";
					}else if(opcionSeleccionada=="3373"){
					    capa.innerHTML="TALLER DE LA ESPECIALIDAD DE ACUICULTURA ";
					}else if(opcionSeleccionada=="3374"){
					    capa.innerHTML="TALLER DE MANTENCION Y REPARACION DE MAQUINAS ELECTRICAS ";
					}else if(opcionSeleccionada=="3375"){
					    capa.innerHTML="TALLER DE PRACTICAS AGROPECUARIAS ";
					}else if(opcionSeleccionada=="3376"){
					    capa.innerHTML="TALLER DE PROYECTOS ";
					}else if(opcionSeleccionada=="3377"){
					    capa.innerHTML="TALLER DE RECURSOS TECNOLOGICOS ";
					}else if(opcionSeleccionada=="3378"){
					    capa.innerHTML="TALLER DE SERVICIOS HOTELEROS ";
					}else if(opcionSeleccionada=="3379"){
					    capa.innerHTML="TALLER DE SOLDADURA Y CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="3380"){
					    capa.innerHTML="TALLER INGLES INSTRUMENTAL ";
					}else if(opcionSeleccionada=="3381"){
					    capa.innerHTML="TALLER TECNOLOGIA DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="3382"){
					    capa.innerHTML="TALLER TECNOLOGICO DE PROCESO ";
					}else if(opcionSeleccionada=="3383"){
					    capa.innerHTML="TECNICA APLICADA A LAS ARTES PLASTICAS ";
					}else if(opcionSeleccionada=="3384"){
					    capa.innerHTML="TECNICAS DE ADMINISTRACION DE FAENAS ";
					}else if(opcionSeleccionada=="3317"){
					    capa.innerHTML="PRODUCCION VEGETAL GENERAL ";
					}else if(opcionSeleccionada=="3318"){
					    capa.innerHTML="PRODUCCION Y SANIDAD VEGETAL ";
					}else if(opcionSeleccionada=="3319"){
					    capa.innerHTML="PRODUCTOS PESQUEROS ";
					}else if(opcionSeleccionada=="3320"){
					    capa.innerHTML="PROGRAMACION ESTRUCTURADA ";
					}else if(opcionSeleccionada=="3321"){
					    capa.innerHTML="PROMOCION DE VENTAS ";
					}else if(opcionSeleccionada=="3322"){
					    capa.innerHTML="PROTECCION FORESTAL ";
					}else if(opcionSeleccionada=="3323"){
					    capa.innerHTML="PROYECTOS EN COBOL ";
					}else if(opcionSeleccionada=="3324"){
					    capa.innerHTML="RECREACION Y ACTIVIDAD FISICA ";
					}else if(opcionSeleccionada=="3325"){
					    capa.innerHTML="RECREACION Y FOLKLORE ";
					}else if(opcionSeleccionada=="3326"){
					    capa.innerHTML="RECURSOS NATURALES Y SU APLICACION ";
					}else if(opcionSeleccionada=="3327"){
					    capa.innerHTML="RECURSOS TURISTICOS ";
					}else if(opcionSeleccionada=="3328"){
					    capa.innerHTML="RECURSOS TURISTICOS DEL SUR ";
					}else if(opcionSeleccionada=="3329"){
					    capa.innerHTML="REDACCION ADMINISTRATIVA Y OFICIAL II ";
					}else if(opcionSeleccionada=="3330"){
					    capa.innerHTML="REDACCION COMERCIAL Y ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="3331"){
					    capa.innerHTML="REDACCION COMERCIAL Y TECNICA DE LA EXPRESION ";
					}else if(opcionSeleccionada=="3332"){
					    capa.innerHTML="REDACCION COMERCIAL Y TECNICAS DE VENTA ";
					}else if(opcionSeleccionada=="3333"){
					    capa.innerHTML="REDACCION DE DOCUMENTOS ";
					}else if(opcionSeleccionada=="3334"){
					    capa.innerHTML="REDACCION DOCUMENTOS DE USO PUBLICO ";
					}else if(opcionSeleccionada=="3335"){
					    capa.innerHTML="REDACCION PROFESIONAL ";
					}else if(opcionSeleccionada=="3336"){
					    capa.innerHTML="REFRIGERACION, CONGELADOS Y EQUIPOS DE FRIO ";
					}else if(opcionSeleccionada=="3337"){
					    capa.innerHTML="REPOBLACION FORESTAL ";
					}else if(opcionSeleccionada=="3338"){
					    capa.innerHTML="REPRODUCCION E INSEMINACION ARTIFICIAL ";
					}else if(opcionSeleccionada=="3339"){
					    capa.innerHTML="SALA CUNA ";
					}else if(opcionSeleccionada=="3340"){
					    capa.innerHTML="SANIDAD E HIGIENE DE PLANTAS ";
					}else if(opcionSeleccionada=="3341"){
					    capa.innerHTML="SANIDAD INDUSTRIAL ";
					}else if(opcionSeleccionada=="3342"){
					    capa.innerHTML="SEGURIDAD Y LEGISLACION ";
					}else if(opcionSeleccionada=="3343"){
					    capa.innerHTML="SEGURIDAD, LEGISLACION Y ADMINISTRACION LABORAL ";
					}else if(opcionSeleccionada=="3344"){
					    capa.innerHTML="SEMANTICA DE LA LENGUA ";
					}else if(opcionSeleccionada=="3345"){
					    capa.innerHTML="SERVICIOS DE MESA ";
					}else if(opcionSeleccionada=="3346"){
					    capa.innerHTML="SEXUALIDAD Y PUERICULTURA ";
					}else if(opcionSeleccionada=="3347"){
					    capa.innerHTML="SILVICULTURA ";
					}else if(opcionSeleccionada=="3348"){
					    capa.innerHTML="SILVICULTURA APLICADA ";
					}else if(opcionSeleccionada=="3349"){
					    capa.innerHTML="SILVICULTURA BASICA ";
					}else if(opcionSeleccionada=="3350"){
					    capa.innerHTML="SILVICULTURA DE PLANTACIONES ";
					}else if(opcionSeleccionada=="3282"){
					    capa.innerHTML="NATACION Y BUCEO ";
					}else if(opcionSeleccionada=="3283"){
					    capa.innerHTML="NATACION Y BUCEO II ";
					}else if(opcionSeleccionada=="3284"){
					    capa.innerHTML="NAUTICA Y SEGURIDAD I ";
					}else if(opcionSeleccionada=="3285"){
					    capa.innerHTML="NAVEGACION COSTERA ";
					}else if(opcionSeleccionada=="3286"){
					    capa.innerHTML="NOCIONES DE CONTABILIDAD Y COMPUTACION ";
					}else if(opcionSeleccionada=="3287"){
					    capa.innerHTML="NOCIONES DE INSTALACIONES SANITARIAS ";
					}else if(opcionSeleccionada=="3288"){
					    capa.innerHTML="NORMAS DE EXPORTACION ";
					}else if(opcionSeleccionada=="3289"){
					    capa.innerHTML="NUTRICION ANIMAL ";
					}else if(opcionSeleccionada=="3290"){
					    capa.innerHTML="NUTRICION Y METABOLISMO ";
					}else if(opcionSeleccionada=="3291"){
					    capa.innerHTML="OCEANOGRAFÍA Y METEREOLOGIA ";
					}else if(opcionSeleccionada=="3292"){
					    capa.innerHTML="OPERACION DE COMPUTADORES ";
					}else if(opcionSeleccionada=="3293"){
					    capa.innerHTML="OPERACION DE MICROCOMPUTADORES ";
					}else if(opcionSeleccionada=="3294"){
					    capa.innerHTML="ORDENA Y TECNOLOGIA DE LA LECHE ";
					}else if(opcionSeleccionada=="3295"){
					    capa.innerHTML="ORGANIZACION DE ARCHIVOS ";
					}else if(opcionSeleccionada=="3296"){
					    capa.innerHTML="ORGANIZACION Y ADMINISTRACION DE JARDINES INFANTILES ";
					}else if(opcionSeleccionada=="3297"){
					    capa.innerHTML="ORGANIZACION Y EMPRESA ";
					}else if(opcionSeleccionada=="3298"){
					    capa.innerHTML="ORGANOS Y MECANISMOS DE MAQUINAS ";
					}else if(opcionSeleccionada=="3299"){
					    capa.innerHTML="PATOLOGIA DE PECES II ";
					}else if(opcionSeleccionada=="3300"){
					    capa.innerHTML="PATRIMONIO CULTURAL ";
					}else if(opcionSeleccionada=="3301"){
					    capa.innerHTML="PESCA ARTESANAL ";
					}else if(opcionSeleccionada=="3302"){
					    capa.innerHTML="PLANIFICACION Y PROYECTO ";
					}else if(opcionSeleccionada=="3303"){
					    capa.innerHTML="PRACTICA DE PRODUCCION ";
					}else if(opcionSeleccionada=="3304"){
					    capa.innerHTML="PRACTICA SILVOAGROPECUARIA ";
					}else if(opcionSeleccionada=="3305"){
					    capa.innerHTML="PRACTICA Y SEMINARIO ";
					}else if(opcionSeleccionada=="3306"){
					    capa.innerHTML="PRACTICAS AGROPECUARIAS INTEGRADAS ";
					}else if(opcionSeleccionada=="3307"){
					    capa.innerHTML="PRACTICAS FORESTALES ";
					}else if(opcionSeleccionada=="3308"){
					    capa.innerHTML="PRACTICAS SILVICOLAS INTEGRADAS ";
					}else if(opcionSeleccionada=="3309"){
					    capa.innerHTML="PRADERAS II ";
					}else if(opcionSeleccionada=="3310"){
					    capa.innerHTML="PRINCIPIOS DE TECNOLOGIA EN ALIMENTOS ";
					}else if(opcionSeleccionada=="3312"){
					    capa.innerHTML="PROCESAMIENTO DE RECURSOS NATURALES ";
					}else if(opcionSeleccionada=="3313"){
					    capa.innerHTML="PROCESO A BORDO ";
					}else if(opcionSeleccionada=="3314"){
					    capa.innerHTML="PRODUCCION ANIMAL GENERAL ";
					}else if(opcionSeleccionada=="3315"){
					    capa.innerHTML="PRODUCCION ANIMAL II ";
					}else if(opcionSeleccionada=="3316"){
					    capa.innerHTML="PRODUCCION BOVINA ";
					}else if(opcionSeleccionada=="3247"){
					    capa.innerHTML="LEGISLACION LABORAL FORESTAL ";
					}else if(opcionSeleccionada=="3248"){
					    capa.innerHTML="LITERATURA INFANTIL ";
					}else if(opcionSeleccionada=="3249"){
					    capa.innerHTML="LITERATURA Y COMUNICACION ";
					}else if(opcionSeleccionada=="3250"){
					    capa.innerHTML="MANEJO GANADERO E INSEMINACION ARTIFICIAL ";
					}else if(opcionSeleccionada=="3251"){
					    capa.innerHTML="MANIOBRAS Y MANTENCION DE EMBARCACIONES ";
					}else if(opcionSeleccionada=="3252"){
					    capa.innerHTML="MANIPULACION DE ALIMENTOS ";
					}else if(opcionSeleccionada=="3253"){
					    capa.innerHTML="MANIPULACION, PRESERVACION Y CONSERVACION DE LOS ALIMENTOS ";
					}else if(opcionSeleccionada=="3254"){
					    capa.innerHTML="MANTENCION MECANICA ";
					}else if(opcionSeleccionada=="3255"){
					    capa.innerHTML="MANTENCION DE EQUIPOS Y SEGURIDAD FORESTAL ";
					}else if(opcionSeleccionada=="3256"){
					    capa.innerHTML="MANTENCION DE EQUIPOS Y HERRAMIENTAS ";
					}else if(opcionSeleccionada=="3257"){
					    capa.innerHTML="MANTENCION INDUSTRIAL ";
					}else if(opcionSeleccionada=="3259"){
					    capa.innerHTML="MAQUINARIA FORESTAL ";
					}else if(opcionSeleccionada=="3260"){
					    capa.innerHTML="MAQUINARIA NAVAL ";
					}else if(opcionSeleccionada=="3261"){
					    capa.innerHTML="MAQUINARIA Y TALLER ";
					}else if(opcionSeleccionada=="3262"){
					    capa.innerHTML="MAQUINARIA Y TALLER II ";
					}else if(opcionSeleccionada=="3263"){
					    capa.innerHTML="MAQUINARIAS ";
					}else if(opcionSeleccionada=="3264"){
					    capa.innerHTML="MAQUINAS DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="3265"){
					    capa.innerHTML="MAQUINAS Y EQUIPOS ";
					}else if(opcionSeleccionada=="3266"){
					    capa.innerHTML="MATEMATICA GENERAL I ";
					}else if(opcionSeleccionada=="3267"){
					    capa.innerHTML="MATEMATICA GENERAL II ";
					}else if(opcionSeleccionada=="3268"){
					    capa.innerHTML="MECANICA AGRICOLA ";
					}else if(opcionSeleccionada=="3269"){
					    capa.innerHTML="MECANICA GENERAL ";
					}else if(opcionSeleccionada=="3270"){
					    capa.innerHTML="MECANICA Y MAQUINARIA ";
					}else if(opcionSeleccionada=="3271"){
					    capa.innerHTML="MEDICIONES FORESTALES ";
					}else if(opcionSeleccionada=="3272"){
					    capa.innerHTML="MENSURA E INVENTARIO ";
					}else if(opcionSeleccionada=="3273"){
					    capa.innerHTML="MENSURA E INVENTARIO FORESTAL ";
					}else if(opcionSeleccionada=="3274"){
					    capa.innerHTML="MENSURA FORESTAL ";
					}else if(opcionSeleccionada=="3275"){
					    capa.innerHTML="METODOLOGIA DE LA EDUCACION ";
					}else if(opcionSeleccionada=="3276"){
					    capa.innerHTML="METODOLOGIA Y TECNOLOGIA DE INVESTIGACION ";
					}else if(opcionSeleccionada=="3277"){
					    capa.innerHTML="MICROBIOLOGIA BASICA ";
					}else if(opcionSeleccionada=="3278"){
					    capa.innerHTML="MORFOLOGIA DE LOS PECES, CRUSTACEOS Y MOLUSCOS ";
					}else if(opcionSeleccionada=="3279"){
					    capa.innerHTML="MOTORES A COMBUSTION INTERNA ";
					}else if(opcionSeleccionada=="3280"){
					    capa.innerHTML="MOTORES Y EQUIPOS ";
					}else if(opcionSeleccionada=="3281"){
					    capa.innerHTML="MOTORES Y MAQUINARIA NAVAL ";
					}else if(opcionSeleccionada=="3213"){
					    capa.innerHTML="FUNDAMENTOS DE ELECTRICIDAD ";
					}else if(opcionSeleccionada=="3214"){
					    capa.innerHTML="GANADERIA III ";
					}else if(opcionSeleccionada=="3215"){
					    capa.innerHTML="GASTRONOMIA ESTETICA ";
					}else if(opcionSeleccionada=="3216"){
					    capa.innerHTML="GIMNASIA FORMATIVA, RECREATIVA Y DEPORTIVA ";
					}else if(opcionSeleccionada=="3217"){
					    capa.innerHTML="GIMNASIA MODERNA ";
					}else if(opcionSeleccionada=="3218"){
					    capa.innerHTML="HIDROLOGIA CONTINENTAL ";
					}else if(opcionSeleccionada=="3219"){
					    capa.innerHTML="HISTORIA DE LA CULTURA ";
					}else if(opcionSeleccionada=="3220"){
					    capa.innerHTML="HISTORIA UNIVERSAL Y GEOGRAFIA DE CHILE ";
					}else if(opcionSeleccionada=="3221"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA GENERAL ";
					}else if(opcionSeleccionada=="3222"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA REGIONAL ";
					}else if(opcionSeleccionada=="3223"){
					    capa.innerHTML="HORTOFRUTICULTURA ";
					}else if(opcionSeleccionada=="3224"){
					    capa.innerHTML="INCENDIOS (MANEJO DEL FUEGO) ";
					}else if(opcionSeleccionada=="3225"){
					    capa.innerHTML="INCENDIOS FORESTALES ";
					}else if(opcionSeleccionada=="3226"){
					    capa.innerHTML="INSEMINACION ARTIFICIAL ";
					}else if(opcionSeleccionada=="3227"){
					    capa.innerHTML="INTRODUCCION A LA BIOLOGIA MARINA ";
					}else if(opcionSeleccionada=="3228"){
					    capa.innerHTML="INTRODUCCION A LA DIETETICA ";
					}else if(opcionSeleccionada=="3229"){
					    capa.innerHTML="INTRODUCCION A LA PRODUCCION VEGETAL ";
					}else if(opcionSeleccionada=="3230"){
					    capa.innerHTML="INTRODUCCION A LAS CIENCIAS AGROPECUARIAS ";
					}else if(opcionSeleccionada=="3231"){
					    capa.innerHTML="INTRODUCCION AL CALCULO DIFERENCIAL E INTEGRAL ";
					}else if(opcionSeleccionada=="3232"){
					    capa.innerHTML="INTRODUCCION AL PROCESO ECONOMICO ";
					}else if(opcionSeleccionada=="3233"){
					    capa.innerHTML="INVENTARIO Y MENSURA FORESTAL III ";
					}else if(opcionSeleccionada=="3234"){
					    capa.innerHTML="INVESTIGACION GEOGRAFICA X REGION ";
					}else if(opcionSeleccionada=="3235"){
					    capa.innerHTML="LA ACTIVIDAD FISICA Y SUS TECNICAS EN EL MEDIO ACUATICO ";
					}else if(opcionSeleccionada=="3236"){
					    capa.innerHTML="LABORATORIO COMPUTACIONAL APLICADA II ";
					}else if(opcionSeleccionada=="3237"){
					    capa.innerHTML="LABORATORIO DE COMPUTACION APLICADA I ";
					}else if(opcionSeleccionada=="3238"){
					    capa.innerHTML="LABORATORIO DE MEDIDAS ELECTRICAS ";
					}else if(opcionSeleccionada=="3239"){
					    capa.innerHTML="LECHERIA ";
					}else if(opcionSeleccionada=="3240"){
					    capa.innerHTML="LEGISLACION LABORAL Y FORESTAL ";
					}else if(opcionSeleccionada=="3241"){
					    capa.innerHTML="LEGISLACION LABORAL Y TURISTICA ";
					}else if(opcionSeleccionada=="3242"){
					    capa.innerHTML="LEGISLACION MARITIMA ";
					}else if(opcionSeleccionada=="3243"){
					    capa.innerHTML="LEGISLACION SANITARIA ";
					}else if(opcionSeleccionada=="3244"){
					    capa.innerHTML="LEGISLACION Y ADMINISTRACION ";
					}else if(opcionSeleccionada=="3245"){
					    capa.innerHTML="LEGISLACION Y CONTABILIDAD FORESTAL ";
					}else if(opcionSeleccionada=="3246"){
					    capa.innerHTML="LENGUAJE DE PROGRAMACION II ";
					}else if(opcionSeleccionada=="3178"){
					    capa.innerHTML="EDUCACION MUSICAL APLICADA ";
					}else if(opcionSeleccionada=="3179"){
					    capa.innerHTML="EDUCACION TECNOLOGICA INFORMATICA ";
					}else if(opcionSeleccionada=="3180"){
					    capa.innerHTML="ELABORACION DE MATERIALES DE ESTIMULACION ";
					}else if(opcionSeleccionada=="3181"){
					    capa.innerHTML="ELECTRONICA Y COMUNICACIONES NAVALES ";
					}else if(opcionSeleccionada=="3182"){
					    capa.innerHTML="ENFERMEDADES Y PLAGAS FORESTALES II ";
					}else if(opcionSeleccionada=="3183"){
					    capa.innerHTML="ENVASES ";
					}else if(opcionSeleccionada=="3184"){
					    capa.innerHTML="EQUIPO INDUSTRIAL ";
					}else if(opcionSeleccionada=="3185"){
					    capa.innerHTML="EQUIPO TERMICO ";
					}else if(opcionSeleccionada=="3186"){
					    capa.innerHTML="EQUIPOS DE REFRIGERACION ";
					}else if(opcionSeleccionada=="3187"){
					    capa.innerHTML="ERGONOMIA FORESTAL APLICADA ";
					}else if(opcionSeleccionada=="3188"){
					    capa.innerHTML="ESPANOL INSTRUMENTAL Y REDACCION COMERCIAL ";
					}else if(opcionSeleccionada=="3189"){
					    capa.innerHTML="ESTABILIDAD Y ESTIBA ";
					}else if(opcionSeleccionada=="3190"){
					    capa.innerHTML="ESTADISTICA APLICADA I ";
					}else if(opcionSeleccionada=="3191"){
					    capa.innerHTML="ESTADISTICA APLICADA II ";
					}else if(opcionSeleccionada=="3192"){
					    capa.innerHTML="ESTADISTICA Y COMPUTACION ";
					}else if(opcionSeleccionada=="3193"){
					    capa.innerHTML="ESTUDIO DE LA EXPRESION MOTRIZ ";
					}else if(opcionSeleccionada=="3194"){
					    capa.innerHTML="ESTUDIO DE LA EXPRESION MUSICAL ";
					}else if(opcionSeleccionada=="3195"){
					    capa.innerHTML="ETICA PROFESIONAL Y RELACIONES PUBLICAS ";
					}else if(opcionSeleccionada=="3196"){
					    capa.innerHTML="ETICA Y LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="3197"){
					    capa.innerHTML="EXPLOTACION FORESTAL ";
					}else if(opcionSeleccionada=="3198"){
					    capa.innerHTML="EXPRESION GRAFICA Y PLASTICA ";
					}else if(opcionSeleccionada=="3199"){
					    capa.innerHTML="EXTENSION RURAL ";
					}else if(opcionSeleccionada=="3200"){
					    capa.innerHTML="FISICA III ";
					}else if(opcionSeleccionada=="3201"){
					    capa.innerHTML="FISICA INSTRUMENTAL ";
					}else if(opcionSeleccionada=="3202"){
					    capa.innerHTML="FITOTECNIA ESPECIAL ";
					}else if(opcionSeleccionada=="3203"){
					    capa.innerHTML="FORESTAL III ";
					}else if(opcionSeleccionada=="3204"){
					    capa.innerHTML="FORESTAL IV ";
					}else if(opcionSeleccionada=="3205"){
					    capa.innerHTML="FORJA Y SOLDADURA ";
					}else if(opcionSeleccionada=="3206"){
					    capa.innerHTML="FORMACION ETICO PROFESIONAL Y AUTOGESTION ";
					}else if(opcionSeleccionada=="3208"){
					    capa.innerHTML="FORMACION PERSONAL Y SOCIAL ";
					}else if(opcionSeleccionada=="3209"){
					    capa.innerHTML="FORMULACION DE PROYECTOS ";
					}else if(opcionSeleccionada=="3210"){
					    capa.innerHTML="FORMULACION Y EVALUACION DE PROYECTO ";
					}else if(opcionSeleccionada=="3211"){
					    capa.innerHTML="FOTOMECANICA ";
					}else if(opcionSeleccionada=="3212"){
					    capa.innerHTML="FUNDAMENTOS DE CONSTRUCCION ";
					}else if(opcionSeleccionada=="3144"){
					    capa.innerHTML="CONTROL DE AVENIA ";
					}else if(opcionSeleccionada=="3145"){
					    capa.innerHTML="CONTROL FITOSANITARIO ";
					}else if(opcionSeleccionada=="3146"){
					    capa.innerHTML="COSTOS DE LA PRODUCCION ";
					}else if(opcionSeleccionada=="3147"){
					    capa.innerHTML="CREACION Y DISENO ";
					}else if(opcionSeleccionada=="3148"){
					    capa.innerHTML="CRIANZA ANIMALES MENORES ";
					}else if(opcionSeleccionada=="3149"){
					    capa.innerHTML="CRIANZA DE TERNEROS ";
					}else if(opcionSeleccionada=="3150"){
					    capa.innerHTML="CULTIVO DE PRADERAS ";
					}else if(opcionSeleccionada=="3151"){
					    capa.innerHTML="CULTIVO DE SALMONES ";
					}else if(opcionSeleccionada=="3152"){
					    capa.innerHTML="CULTIVOS MARINOS ";
					}else if(opcionSeleccionada=="3153"){
					    capa.innerHTML="CULTIVOS EXTENSIVOS ";
					}else if(opcionSeleccionada=="3154"){
					    capa.innerHTML="CULTIVOS I ";
					}else if(opcionSeleccionada=="3155"){
					    capa.innerHTML="CULTIVOS II ";
					}else if(opcionSeleccionada=="3156"){
					    capa.innerHTML="CULTURA ARTISTICA Y DEPORTIVA ";
					}else if(opcionSeleccionada=="3157"){
					    capa.innerHTML="CULTURA Y TRADICIONES RURALES ";
					}else if(opcionSeleccionada=="3158"){
					    capa.innerHTML="CURRICULO DE TRANSICION ";
					}else if(opcionSeleccionada=="3159"){
					    capa.innerHTML="CURRICULO NIVEL MEDIO ";
					}else if(opcionSeleccionada=="3160"){
					    capa.innerHTML="DACTILOGRAFIA Y COMPUTACION ";
					}else if(opcionSeleccionada=="3161"){
					    capa.innerHTML="DASOMETRIA E INVENTARIO ";
					}else if(opcionSeleccionada=="3162"){
					    capa.innerHTML="DENDROLOGIA FORESTAL ";
					}else if(opcionSeleccionada=="3163"){
					    capa.innerHTML="DESARROLLO DE LA CALIDAD DE VIDA ";
					}else if(opcionSeleccionada=="3164"){
					    capa.innerHTML="DESARROLLO RURAL ";
					}else if(opcionSeleccionada=="3165"){
					    capa.innerHTML="DIBUJO DE PROYECTOS DE INTERPRETACION DE PLANOS ";
					}else if(opcionSeleccionada=="3166"){
					    capa.innerHTML="DISENO Y CONSTRUCCION ";
					}else if(opcionSeleccionada=="3167"){
					    capa.innerHTML="DOCUMENTACION MERCANTIL ";
					}else if(opcionSeleccionada=="3168"){
					    capa.innerHTML="DOCUMENTOS Y LEYES LABORALES ";
					}else if(opcionSeleccionada=="3169"){
					    capa.innerHTML="ECOLOGIA MARINA ";
					}else if(opcionSeleccionada=="3170"){
					    capa.innerHTML="ECOLOGIA TURISTICA ";
					}else if(opcionSeleccionada=="3171"){
					    capa.innerHTML="ECONOMIA BASICA ";
					}else if(opcionSeleccionada=="3172"){
					    capa.innerHTML="ECONOMIA FORESTAL APLICADA ";
					}else if(opcionSeleccionada=="3173"){
					    capa.innerHTML="ECONOMIA Y MARKETING ";
					}else if(opcionSeleccionada=="3174"){
					    capa.innerHTML="ECONOMIA, ADMINISTRACION Y LEGISLACION RURAL ";
					}else if(opcionSeleccionada=="3175"){
					    capa.innerHTML="EDUCACION A LA FE DEL PARVULO ";
					}else if(opcionSeleccionada=="3176"){
					    capa.innerHTML="EDUCACION FISICA APLICADA Y EXPRESION CORPORAL ";
					}else if(opcionSeleccionada=="3177"){
					    capa.innerHTML="EDUCACION FISICA Y PRACTICAS DEPORTIVAS ";
					}else if(opcionSeleccionada=="3110"){
					    capa.innerHTML="APLICACIONES DE LA MATEMATICA III ";
					}else if(opcionSeleccionada=="3111"){
					    capa.innerHTML="APLICACIONES DE LA MATEMATICA IV ";
					}else if(opcionSeleccionada=="3112"){
					    capa.innerHTML="ARTES DECORATIVAS ";
					}else if(opcionSeleccionada=="3113"){
					    capa.innerHTML="ARTES Y SISTEMAS DE CULTIVO ";
					}else if(opcionSeleccionada=="3114"){
					    capa.innerHTML="ARTES Y SISTEMAS DE PESCA ";
					}else if(opcionSeleccionada=="3115"){
					    capa.innerHTML="ARTES Y SISTEMAS PARA CULTIVOS ";
					}else if(opcionSeleccionada=="3116"){
					    capa.innerHTML="ARTESANIA BASICA ";
					}else if(opcionSeleccionada=="3117"){
					    capa.innerHTML="ASERRADEROS ";
					}else if(opcionSeleccionada=="3118"){
					    capa.innerHTML="BIOLOGIA HUMANA ";
					}else if(opcionSeleccionada=="3119"){
					    capa.innerHTML="BIOSISTEMA ";
					}else if(opcionSeleccionada=="3120"){
					    capa.innerHTML="CALCULO II ";
					}else if(opcionSeleccionada=="3121"){
					    capa.innerHTML="CANALIZACIONES ELECTRICAS ";
					}else if(opcionSeleccionada=="3122"){
					    capa.innerHTML="CARTOGRAFIA FOTO INTERPRETACION ";
					}else if(opcionSeleccionada=="3123"){
					    capa.innerHTML="CARTOGRAFIA Y FOTOGRAFIA AEREA ";
					}else if(opcionSeleccionada=="3124"){
					    capa.innerHTML="CASTELLANO II ";
					}else if(opcionSeleccionada=="3125"){
					    capa.innerHTML="CIENCIAS DE LA MATEMATICA ";
					}else if(opcionSeleccionada=="3126"){
					    capa.innerHTML="CIENCIAS Y TECNOLOGIA ";
					}else if(opcionSeleccionada=="3127"){
					    capa.innerHTML="CIVILIDAD ";
					}else if(opcionSeleccionada=="3128"){
					    capa.innerHTML="COCINA II ";
					}else if(opcionSeleccionada=="3129"){
					    capa.innerHTML="COCINA NACIONAL ";
					}else if(opcionSeleccionada=="3130"){
					    capa.innerHTML="COCINA NACIONAL E INTERNACIONAL ";
					}else if(opcionSeleccionada=="3131"){
					    capa.innerHTML="COCTELERIA ";
					}else if(opcionSeleccionada=="3132"){
					    capa.innerHTML="COMERCIALIZACION Y LEG. TURISTICA ";
					}else if(opcionSeleccionada=="3133"){
					    capa.innerHTML="COMPUTACION III ";
					}else if(opcionSeleccionada=="3134"){
					    capa.innerHTML="CONDUCCION AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="3135"){
					    capa.innerHTML="CONFECCION ADULTO ";
					}else if(opcionSeleccionada=="3136"){
					    capa.innerHTML="CONFECCION INFANTIL ";
					}else if(opcionSeleccionada=="3137"){
					    capa.innerHTML="CONGELADO ";
					}else if(opcionSeleccionada=="3138"){
					    capa.innerHTML="CONOCIENDO EL MUNDO DE LA COMPUTACION II ";
					}else if(opcionSeleccionada=="3139"){
					    capa.innerHTML="CONSERVACION DE FRUTAS Y HORTALIZAS ";
					}else if(opcionSeleccionada=="3140"){
					    capa.innerHTML="CONSERVACION DEL MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="3141"){
					    capa.innerHTML="CONTABILIDAD APLICADA II ";
					}else if(opcionSeleccionada=="3142"){
					    capa.innerHTML="CONTABILIDAD DE COSTOS Y SUPERIOR ";
					}else if(opcionSeleccionada=="3143"){
					    capa.innerHTML="CONTABILIDAD SUPERIOR Y COSTO ";
					}else if(opcionSeleccionada=="3076"){
					    capa.innerHTML="MANTENIMIENTO MECANICO ";
					}else if(opcionSeleccionada=="3077"){
					    capa.innerHTML="CIRCUITOS ELECTRONICOS AUXILIARES ";
					}else if(opcionSeleccionada=="3078"){
					    capa.innerHTML="IDIOMA (INGLES) ";
					}else if(opcionSeleccionada=="3079"){
					    capa.innerHTML="IDIOMA INGLES ETP ";
					}else if(opcionSeleccionada=="3080"){
					    capa.innerHTML="IDIOMA (FRANCES) ";
					}else if(opcionSeleccionada=="3081"){
					    capa.innerHTML="FRANCES DIFERENCIADO ";
					}else if(opcionSeleccionada=="3082"){
					    capa.innerHTML="QUIMICA DIFERENCIADA IV ";
					}else if(opcionSeleccionada=="3083"){
					    capa.innerHTML="FOTOGRAFIA, DIAPOSITIVA, VIDEO Y CINE ";
					}else if(opcionSeleccionada=="3084"){
					    capa.innerHTML="PLAN DE DESEMPENO ";
					}else if(opcionSeleccionada=="3085"){
					    capa.innerHTML="ANALISIS FISICO QUIMICO DE MUESTRAS ";
					}else if(opcionSeleccionada=="3086"){
					    capa.innerHTML="ACTIVIDADES AGROPECUARIAS ";
					}else if(opcionSeleccionada=="3087"){
					    capa.innerHTML="ACTIVIDADES FISICO DEPORTIVA ";
					}else if(opcionSeleccionada=="3088"){
					    capa.innerHTML="ACUICULTURA ";
					}else if(opcionSeleccionada=="3089"){
					    capa.innerHTML="ADMINISTRACION AGRICOLA II ";
					}else if(opcionSeleccionada=="3090"){
					    capa.innerHTML="ADMINISTRACION AGROPECUARIA Y LEGISLACION ";
					}else if(opcionSeleccionada=="3091"){
					    capa.innerHTML="ADMINISTRACION AVANZADA Y ETICA LABORAL ";
					}else if(opcionSeleccionada=="3092"){
					    capa.innerHTML="ADMINISTRACION GENERAL Y DE PERSONAL ";
					}else if(opcionSeleccionada=="3093"){
					    capa.innerHTML="ADMINISTRACION PREDIAL ";
					}else if(opcionSeleccionada=="3094"){
					    capa.innerHTML="ADMINISTRACION RURAL ";
					}else if(opcionSeleccionada=="3095"){
					    capa.innerHTML="ADMINISTRACION RURAL II ";
					}else if(opcionSeleccionada=="3096"){
					    capa.innerHTML="ADMINISTRACION Y GESTION PREDIAL ";
					}else if(opcionSeleccionada=="3097"){
					    capa.innerHTML="ADMINISTRACION Y LEGISLACION PESQUERA ";
					}else if(opcionSeleccionada=="3098"){
					    capa.innerHTML="ADMINISTRACION Y ORGANIZACION DE EMPRESAS ";
					}else if(opcionSeleccionada=="3099"){
					    capa.innerHTML="ADMINISTRACION Y PROYECTOS AGROPECUARIOS ";
					}else if(opcionSeleccionada=="3100"){
					    capa.innerHTML="ADMINISTRACION, CONTABILIDAD Y COSTO II ";
					}else if(opcionSeleccionada=="3101"){
					    capa.innerHTML="ADMINISTRACION, FINANZAS Y ETICA LABORAL ";
					}else if(opcionSeleccionada=="3102"){
					    capa.innerHTML="AGRICULTURA III ";
					}else if(opcionSeleccionada=="3103"){
					    capa.innerHTML="ALEMAN ";
					}else if(opcionSeleccionada=="3104"){
					    capa.innerHTML="ALIMENTACION ANIMAL ";
					}else if(opcionSeleccionada=="3105"){
					    capa.innerHTML="ALIMENTOS MARINOS ";
					}else if(opcionSeleccionada=="3106"){
					    capa.innerHTML="ANATOMIA COMPARADA II ";
					}else if(opcionSeleccionada=="3107"){
					    capa.innerHTML="ANTROPOLOGIA ";
					}else if(opcionSeleccionada=="3108"){
					    capa.innerHTML="APICULTURA ";
					}else if(opcionSeleccionada=="3109"){
					    capa.innerHTML="APLICACIONES DE INFORMATICA ";
					}else if(opcionSeleccionada=="3040"){
					    capa.innerHTML="CONSTRUCCION HABITACIONAL Y DE INTERIORES ";
					}else if(opcionSeleccionada=="3041"){
					    capa.innerHTML="INSTALACION DE REDES HIDROGASOGENAS ";
					}else if(opcionSeleccionada=="3042"){
					    capa.innerHTML="MECANICA DE MAQUINAS Y HERRAMIENTAS ";
					}else if(opcionSeleccionada=="3043"){
					    capa.innerHTML="MECANICA DE MANTENCION INDUSTRIAL ";
					}else if(opcionSeleccionada=="3044"){
					    capa.innerHTML="METODOS MATEMATICOS ";
					}else if(opcionSeleccionada=="3045"){
					    capa.innerHTML="CHILE Y LA CUENCA DEL PACIFICO ";
					}else if(opcionSeleccionada=="3046"){
					    capa.innerHTML="GEOGRAFIA GENERAL ";
					}else if(opcionSeleccionada=="3047"){
					    capa.innerHTML="VIAJE AL SUELO ";
					}else if(opcionSeleccionada=="3048"){
					    capa.innerHTML="RECONOCIENDO EL MUNDO VEGETAL ";
					}else if(opcionSeleccionada=="3049"){
					    capa.innerHTML="NECESIDAD SUELO PLANTA AGUA ";
					}else if(opcionSeleccionada=="3050"){
					    capa.innerHTML="CONOCIENDO EL MUNDO VEGETAL ";
					}else if(opcionSeleccionada=="3051"){
					    capa.innerHTML="AGROINDUSTRIA ";
					}else if(opcionSeleccionada=="3052"){
					    capa.innerHTML="FLORICULTURA ";
					}else if(opcionSeleccionada=="3053"){
					    capa.innerHTML="SANIDAD VEGETAL ";
					}else if(opcionSeleccionada=="3055"){
					    capa.innerHTML="ADMINISTRACION AGRICOLA ";
					}else if(opcionSeleccionada=="3056"){
					    capa.innerHTML="INTERESES MARITIMOS ";
					}else if(opcionSeleccionada=="3057"){
					    capa.innerHTML="PROCESAMIENTO DE LA INFORMACION ";
					}else if(opcionSeleccionada=="3058"){
					    capa.innerHTML="INGLES DOCUMENTAL ";
					}else if(opcionSeleccionada=="3059"){
					    capa.innerHTML="OPERACIONES PORTUARIAS ";
					}else if(opcionSeleccionada=="3060"){
					    capa.innerHTML="SEGURIDAD MARITIMO PORTUARIO ";
					}else if(opcionSeleccionada=="3061"){
					    capa.innerHTML="TRANSPORTE MULTIMODAL ";
					}else if(opcionSeleccionada=="3062"){
					    capa.innerHTML="SEMINARIO DE TITULACION ";
					}else if(opcionSeleccionada=="3063"){
					    capa.innerHTML="TRIGONOMETRIA PLANA ";
					}else if(opcionSeleccionada=="3064"){
					    capa.innerHTML="BIOLOGIA VEGETAL ";
					}else if(opcionSeleccionada=="3066"){
					    capa.innerHTML="SISTEMAS AMBIENTALES ";
					}else if(opcionSeleccionada=="3067"){
					    capa.innerHTML="CAPACITACION EN HERRAMIENTAS COMPUTACIONALES ";
					}else if(opcionSeleccionada=="3068"){
					    capa.innerHTML="COMUNICACION LINGUISTICA I ";
					}else if(opcionSeleccionada=="3069"){
					    capa.innerHTML="COMUNICACION LINGUISTICA II ";
					}else if(opcionSeleccionada=="3070"){
					    capa.innerHTML="COMUNICACION SITUACIONAL EN INGLES ";
					}else if(opcionSeleccionada=="3071"){
					    capa.innerHTML="PSICOLOGIA 2 ";
					}else if(opcionSeleccionada=="3072"){
					    capa.innerHTML="LENGUA CASTELLANA ";
					}else if(opcionSeleccionada=="3073"){
					    capa.innerHTML="COMPONENTES ELECTRONICOS ";
					}else if(opcionSeleccionada=="3074"){
					    capa.innerHTML="COMUNICACION Y TECNICAS DE MODULACION ";
					}else if(opcionSeleccionada=="3075"){
					    capa.innerHTML="TALLERES PEDAGOGICOS ";
					}else if(opcionSeleccionada=="3006"){
					    capa.innerHTML="ELECTIVO IDIOMA EXTRANJERO (INGLES) ";
					}else if(opcionSeleccionada=="3007"){
					    capa.innerHTML="SEMBLANZAS DE PERSONAJES CHILENOS ";
					}else if(opcionSeleccionada=="3008"){
					    capa.innerHTML="SISTEMA PREVISIONAL ";
					}else if(opcionSeleccionada=="3009"){
					    capa.innerHTML="TALLER DE ADMINISTRACION DE BODEGA Y CONTROL DE EXISTENCIA ";
					}else if(opcionSeleccionada=="3010"){
					    capa.innerHTML="TALLER DE ADMINISTRACION IMPORTACION Y EXPORTACION ";
					}else if(opcionSeleccionada=="3011"){
					    capa.innerHTML="TALLER DE COMERCIO EXTERIOR ";
					}else if(opcionSeleccionada=="3012"){
					    capa.innerHTML="TALLER DE COMPUTACION APLICADA ";
					}else if(opcionSeleccionada=="3013"){
					    capa.innerHTML="TALLER DE CONTABILIDAD ";
					}else if(opcionSeleccionada=="3014"){
					    capa.innerHTML="MINELURGIA ";
					}else if(opcionSeleccionada=="3015"){
					    capa.innerHTML="ELECTIVO HISTORIA Y CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="3016"){
					    capa.innerHTML="GRAVITACION UNIVERSAL ";
					}else if(opcionSeleccionada=="3017"){
					    capa.innerHTML="PSICOLOGIA DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="3018"){
					    capa.innerHTML="EXPRESION ORAL Y ESCRITA DEL IDIOMA INGLES ";
					}else if(opcionSeleccionada=="3019"){
					    capa.innerHTML="EXPLOTACION DE MINAS ";
					}else if(opcionSeleccionada=="3020"){
					    capa.innerHTML="GEOLOGIA ";
					}else if(opcionSeleccionada=="3021"){
					    capa.innerHTML="OPERACION DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="3022"){
					    capa.innerHTML="LABORATORIO Y PRACTICA ";
					}else if(opcionSeleccionada=="3023"){
					    capa.innerHTML="COMUNICACION PUBLICITARIA ";
					}else if(opcionSeleccionada=="3024"){
					    capa.innerHTML="MOMENTOS CULMINANTES DE LA HISTORIA DE EUROPA SIGLOS XVI AL XIX ";
					}else if(opcionSeleccionada=="50013"){
					    capa.innerHTML="Expresion Corporal ";
					}else if(opcionSeleccionada=="3026"){
					    capa.innerHTML="FILTRO Y CONVERSORES ANALOGOS DIGITALES ";
					}else if(opcionSeleccionada=="3027"){
					    capa.innerHTML="APLICACION DE FLUIDOS ";
					}else if(opcionSeleccionada=="3028"){
					    capa.innerHTML="CONFECCION Y MECANIZADO AVANZADO DE PIEZAS ";
					}else if(opcionSeleccionada=="3029"){
					    capa.innerHTML="FRESADO, TORNEADO Y TALADRADO ";
					}else if(opcionSeleccionada=="3030"){
					    capa.innerHTML="FUNDAMENTOS TECNOLOGICOS ";
					}else if(opcionSeleccionada=="3031"){
					    capa.innerHTML="PROYECTO DE CIRCUITOS HIDRAULICOS Y NEUMATICOS ";
					}else if(opcionSeleccionada=="3032"){
					    capa.innerHTML="ORGANIZACION Y ARCHIVO DE DATOS ";
					}else if(opcionSeleccionada=="3033"){
					    capa.innerHTML="PRACTICA DE COMPUTACION ";
					}else if(opcionSeleccionada=="3034"){
					    capa.innerHTML="TEORIA Y PRACTICA DE LA COMUNICACION ";
					}else if(opcionSeleccionada=="3035"){
					    capa.innerHTML="REFRIGERACION Y AIRE ACONDICIONADO ";
					}else if(opcionSeleccionada=="3036"){
					    capa.innerHTML="TECNICAS BASICAS DEL HORMIGON ";
					}else if(opcionSeleccionada=="3037"){
					    capa.innerHTML="SISTEMAS DE MANTENCION ";
					}else if(opcionSeleccionada=="3038"){
					    capa.innerHTML="ORGANOS DE MAQUINAS ";
					}else if(opcionSeleccionada=="3039"){
					    capa.innerHTML="MECANICA APLICADA ";
					}else if(opcionSeleccionada=="2971"){
					    capa.innerHTML="ELECTIVO HISTORIA ";
					}else if(opcionSeleccionada=="2972"){
					    capa.innerHTML="ELECTIVO MATEMATICAS ";
					}else if(opcionSeleccionada=="2973"){
					    capa.innerHTML="ESTADISTICA COMPUTACIONAL ";
					}else if(opcionSeleccionada=="2974"){
					    capa.innerHTML="FUNDAMENTO DE LAS MATEMATICAS ";
					}else if(opcionSeleccionada=="2975"){
					    capa.innerHTML="GANADERIA ";
					}else if(opcionSeleccionada=="2976"){
					    capa.innerHTML="GUERRAS MUNDIALES ";
					}else if(opcionSeleccionada=="2977"){
					    capa.innerHTML="HACIA UNA COMPRENSION DEL SIGLO XX ";
					}else if(opcionSeleccionada=="2978"){
					    capa.innerHTML="IMPORTACION Y EXPORTACION ";
					}else if(opcionSeleccionada=="2979"){
					    capa.innerHTML="INICIACION A LA PUBLICIDAD ";
					}else if(opcionSeleccionada=="2980"){
					    capa.innerHTML="INSTALACION Y ADMINISTRACION DE REDES ";
					}else if(opcionSeleccionada=="2981"){
					    capa.innerHTML="INTERNET ";
					}else if(opcionSeleccionada=="2982"){
					    capa.innerHTML="INTRODUCCION A LA LITERATURA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="2983"){
					    capa.innerHTML="INTRODUCCION A LA PSICOLOGIA ";
					}else if(opcionSeleccionada=="2984"){
					    capa.innerHTML="INTRODUCCION A LA SOCIOLOGIA ";
					}else if(opcionSeleccionada=="2985"){
					    capa.innerHTML="INTRODUCCION AL CALCULO II ";
					}else if(opcionSeleccionada=="2987"){
					    capa.innerHTML="LABORATORIO DE MANEJO UTILITARIO ";
					}else if(opcionSeleccionada=="2988"){
					    capa.innerHTML="LABORATORIO DE MARKETING INTERNACIONAL ";
					}else if(opcionSeleccionada=="2989"){
					    capa.innerHTML="LEGISLACION TRIBUTARIA Y LABORAL ";
					}else if(opcionSeleccionada=="2990"){
					    capa.innerHTML="LEGISLACION COMERCIAL ";
					}else if(opcionSeleccionada=="2991"){
					    capa.innerHTML="LITERATURA Y LINGUISTICA SIGLO XX ";
					}else if(opcionSeleccionada=="2992"){
					    capa.innerHTML="MANEJO DE UTILITARIOS ";
					}else if(opcionSeleccionada=="2993"){
					    capa.innerHTML="MANTENCION DE HARDWARE ";
					}else if(opcionSeleccionada=="2994"){
					    capa.innerHTML="MARKETING TURISTICO ";
					}else if(opcionSeleccionada=="2995"){
					    capa.innerHTML="MATEMATICA APLICADA II ";
					}else if(opcionSeleccionada=="2996"){
					    capa.innerHTML="MATEMATICAS FUNDAMENTALES ";
					}else if(opcionSeleccionada=="2997"){
					    capa.innerHTML="NOCIONES ELEMENTALES DE PERIODISMO ";
					}else if(opcionSeleccionada=="2998"){
					    capa.innerHTML="PERIODISMO ";
					}else if(opcionSeleccionada=="2999"){
					    capa.innerHTML="PLANILLA ELECTRONICA LOTUS ";
					}else if(opcionSeleccionada=="3000"){
					    capa.innerHTML="PRINCIPIOS DE BIOQUIMICA ";
					}else if(opcionSeleccionada=="3001"){
					    capa.innerHTML="PROBLEMAS DE LA SOCIEDAD CONTEMPORANEA ";
					}else if(opcionSeleccionada=="3002"){
					    capa.innerHTML="PROBLEMATICA ORGANISMO ANIMAL ";
					}else if(opcionSeleccionada=="3003"){
					    capa.innerHTML="PROCESADOR DE TEXTOS WORDSTAR ";
					}else if(opcionSeleccionada=="3004"){
					    capa.innerHTML="PROGRAMACION DE MICROCOMPUTADORES NIVEL I ";
					}else if(opcionSeleccionada=="3005"){
					    capa.innerHTML="RELACIONES HUMANAS EN LA EMPRESA ";
					}else if(opcionSeleccionada=="2936"){
					    capa.innerHTML="MONTAJE Y ARMADO DE ESTRUCTURAS ";
					}else if(opcionSeleccionada=="2937"){
					    capa.innerHTML="TALLER DE METALURGIA ";
					}else if(opcionSeleccionada=="2939"){
					    capa.innerHTML="INSTALACION DE SISTEMAS DE RIEGO TECNIFICADO ";
					}else if(opcionSeleccionada=="2940"){
					    capa.innerHTML="SOLUCIONES SANITARIAS PARTICULARES ";
					}else if(opcionSeleccionada=="2941"){
					    capa.innerHTML="MINERALOGIA ";
					}else if(opcionSeleccionada=="2942"){
					    capa.innerHTML="ELECTIVO IDIOMA EXTRANJERO (FRANCES) ";
					}else if(opcionSeleccionada=="2943"){
					    capa.innerHTML="ADMINISTRACION DE LA MANTENCION ";
					}else if(opcionSeleccionada=="2944"){
					    capa.innerHTML="ADMINISTRACION COMERCIAL ";
					}else if(opcionSeleccionada=="2945"){
					    capa.innerHTML="ADMINISTRACION DE ALMACENES DE DEPOSITOS ";
					}else if(opcionSeleccionada=="2946"){
					    capa.innerHTML="ADMINISTRACION DE EMPRESA PERSONAL ";
					}else if(opcionSeleccionada=="2947"){
					    capa.innerHTML="ADMINISTRACION DE LA FUERZA DE VENTAS ";
					}else if(opcionSeleccionada=="2948"){
					    capa.innerHTML="AGRICULTURA ";
					}else if(opcionSeleccionada=="2949"){
					    capa.innerHTML="ANATOMIA GENERAL HUMANA ";
					}else if(opcionSeleccionada=="2950"){
					    capa.innerHTML="ANTECEDENTES HISTORICOS DEL SIGLO XX ";
					}else if(opcionSeleccionada=="2951"){
					    capa.innerHTML="ARQUEOLOGIA ";
					}else if(opcionSeleccionada=="2952"){
					    capa.innerHTML="AUDITORIA Y PRESUPUESTO ";
					}else if(opcionSeleccionada=="2953"){
					    capa.innerHTML="BIOLOGIA CELULAR Y EL ORGANISMO VEGETAL ";
					}else if(opcionSeleccionada=="2954"){
					    capa.innerHTML="BIOLOGIA DEL DESARROLLO ";
					}else if(opcionSeleccionada=="2955"){
					    capa.innerHTML="BIOLOGIA MARINA ";
					}else if(opcionSeleccionada=="2956"){
					    capa.innerHTML="COMERCIO EXTERIOR Y LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="2957"){
					    capa.innerHTML="COMERCIO EXTERIOR Y LENGUAJE ADUANERO ";
					}else if(opcionSeleccionada=="2958"){
					    capa.innerHTML="COMPRENSION DEL IDIOMA INGLES ";
					}else if(opcionSeleccionada=="2959"){
					    capa.innerHTML="COMPRENSION DEL LENGUAJE ORAL Y ESCRITO DEL IDIOMA INGLES ";
					}else if(opcionSeleccionada=="2960"){
					    capa.innerHTML="COMUNICACION Y REDACCION COMERCIAL ";
					}else if(opcionSeleccionada=="2961"){
					    capa.innerHTML="CONTROL DE EXISTENCIA E INVENTARIO ";
					}else if(opcionSeleccionada=="2962"){
					    capa.innerHTML="CONTROL DE INVENTARIO ";
					}else if(opcionSeleccionada=="2963"){
					    capa.innerHTML="DERECHO CIVIL Y PENAL ";
					}else if(opcionSeleccionada=="2964"){
					    capa.innerHTML="DERECHOS HUMANOS ";
					}else if(opcionSeleccionada=="2965"){
					    capa.innerHTML="DESARROLLO HISTORICO DE CHILE DURANTE EL SIGLO XX ";
					}else if(opcionSeleccionada=="2966"){
					    capa.innerHTML="DIBUJO TECNICO ARQUITECTONICO ";
					}else if(opcionSeleccionada=="2967"){
					    capa.innerHTML="EDUCACION FISICA LABORAL ";
					}else if(opcionSeleccionada=="2968"){
					    capa.innerHTML="EL TURISMO Y SU IMPORTANCIA ACTUAL ";
					}else if(opcionSeleccionada=="2969"){
					    capa.innerHTML="ELECTIVO ARTES VISUALES ";
					}else if(opcionSeleccionada=="2970"){
					    capa.innerHTML="ELECTIVO COMUNICACION ";
					}else if(opcionSeleccionada=="2899"){
					    capa.innerHTML="TECNICAS DE ARCHIVO Y KARDEX ";
					}else if(opcionSeleccionada=="2900"){
					    capa.innerHTML="DIAGNOSTICO, MONTAJE Y MANTENCION DE SISTEMAS OLEOHIDRAULICOS Y NEUMATICOS ";
					}else if(opcionSeleccionada=="2901"){
					    capa.innerHTML="MECANIZACION DE PIEZAS ";
					}else if(opcionSeleccionada=="2903"){
					    capa.innerHTML="SOLDADURA Y REPARACION ";
					}else if(opcionSeleccionada=="2906"){
					    capa.innerHTML="ELABORACION DE PROYECTOS Y DISENO DE SISTEMAS DE ALUMBRADO Y FUERZA SEGUN SEC ";
					}else if(opcionSeleccionada=="2907"){
					    capa.innerHTML="INSTALACION Y MONTAJE DE CIRCUITOS DE ALUMBRADO, FUERZA Y EQUIPOS ELECTRICOS ";
					}else if(opcionSeleccionada=="2908"){
					    capa.innerHTML="CONSTRUCCION Y REPARACION DE REDES, MAQUINAS Y SISTEMAS ELECTRICOS ";
					}else if(opcionSeleccionada=="2909"){
					    capa.innerHTML="OPERACION Y MANTENCION DE CIRCUITOS, REDES, EQUIPOS ELECTRICOS Y CONTROLES AUTOMATICOS ";
					}else if(opcionSeleccionada=="2910"){
					    capa.innerHTML="FRIO INDUSTRIAL ";
					}else if(opcionSeleccionada=="2911"){
					    capa.innerHTML="MANTENCION Y REPARACION DE MOTORES DE COMBUSTION I ";
					}else if(opcionSeleccionada=="2912"){
					    capa.innerHTML="MANTENCION Y REPARACION DE SISTEMAS ELECTRICOS Y ELECTRONICOS ";
					}else if(opcionSeleccionada=="2913"){
					    capa.innerHTML="TALLER AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="2914"){
					    capa.innerHTML="DISENO DE ESTRUCTURA Y TRAZADO DE PIEZAS METALICAS ";
					}else if(opcionSeleccionada=="2915"){
					    capa.innerHTML="PREPARACION DE MATERIALES ";
					}else if(opcionSeleccionada=="2916"){
					    capa.innerHTML="CARPINTERIA METALICA ";
					}else if(opcionSeleccionada=="2917"){
					    capa.innerHTML="FORJA Y TRATAMIENTOS TERMICOS ";
					}else if(opcionSeleccionada=="2918"){
					    capa.innerHTML="CONSTRUCCION EN HORMIGON Y ALBANILERIA ";
					}else if(opcionSeleccionada=="2919"){
					    capa.innerHTML="CARPINTERIA DE CONSTRUCCION ";
					}else if(opcionSeleccionada=="2920"){
					    capa.innerHTML="CIENCIA Y ANTROPOLOGIA ";
					}else if(opcionSeleccionada=="2921"){
					    capa.innerHTML="INSTALACION Y MANTENCION DE REDES DE AGUA POTABLE ";
					}else if(opcionSeleccionada=="2922"){
					    capa.innerHTML="INSTALACION Y MANTENCION DE REDES Y ARTEFACTOS A GAS ";
					}else if(opcionSeleccionada=="2923"){
					    capa.innerHTML="DISENO, INSTALACION Y MANTENCION DE REDES DE CAPTACION, TRATAMIENTO Y EVACUACION DE AGUAS SERVIDAS ";
					}else if(opcionSeleccionada=="2924"){
					    capa.innerHTML="UNIONES Y SOLDADURAS ";
					}else if(opcionSeleccionada=="2925"){
					    capa.innerHTML="TALLER DE INSTALACIONES SANITARIAS ";
					}else if(opcionSeleccionada=="2926"){
					    capa.innerHTML="DIAGNOSTICO, MONTAJE Y MANTENCION DE SISTEMAS MECANICOS Y ELECTROMECANICOS ";
					}else if(opcionSeleccionada=="2927"){
					    capa.innerHTML="TRAMITACION ADUANERA ";
					}else if(opcionSeleccionada=="2928"){
					    capa.innerHTML="ELECTIVO ARTES MUSICALES ";
					}else if(opcionSeleccionada=="2929"){
					    capa.innerHTML="FISICA: TERMODINAMICA ";
					}else if(opcionSeleccionada=="2930"){
					    capa.innerHTML="LOGICA, MATRICES Y PROBABILIDADES ";
					}else if(opcionSeleccionada=="2931"){
					    capa.innerHTML="OPERACON Y MANTENCION DE CIRCUITOS, REDES, EQUIPOS ELECTRICOS Y CONTROLES AUTOMATICOS ";
					}else if(opcionSeleccionada=="2932"){
					    capa.innerHTML="ECONOMIA COMERCIO EXTERIOR ";
					}else if(opcionSeleccionada=="2933"){
					    capa.innerHTML="TALLER DE MINAS ";
					}else if(opcionSeleccionada=="2934"){
					    capa.innerHTML="MANTENCION Y REPARACION DE SISTEMAS DE RODAJE, SEGURIDAD Y CONFORT ";
					}else if(opcionSeleccionada=="2935"){
					    capa.innerHTML="AVANCES TECNOLOGICOS EN MECANICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="2865"){
					    capa.innerHTML="LABORATORIO PROFESIONAL ";
					}else if(opcionSeleccionada=="2866"){
					    capa.innerHTML="LOS PRINCIPALES PROBLEMAS GEOPOLITICOS POSTERIORES ";
					}else if(opcionSeleccionada=="2867"){
					    capa.innerHTML="NATACION ";
					}else if(opcionSeleccionada=="2868"){
					    capa.innerHTML="NOCIONES GENERALES DE INFORMATICA Y APLICACIONES COMPUTACIONALES";
					}else if(opcionSeleccionada=="2869"){
					    capa.innerHTML="PATRIMONIO CULTURAL NACIONAL Y REGIONAL ";
					}else if(opcionSeleccionada=="2870"){
					    capa.innerHTML="PRACTICA DE HOTELERIA ";
					}else if(opcionSeleccionada=="2871"){
					    capa.innerHTML="PRACTICA DE TURISMO ";
					}else if(opcionSeleccionada=="2872"){
					    capa.innerHTML="PRINCIPIOS DE CONTABILIDAD Y DOCUMENTACION MERCANTIL ";
					}else if(opcionSeleccionada=="2873"){
					    capa.innerHTML="REDACCION ADMINISTRATIVA Y OFICIAL ";
					}else if(opcionSeleccionada=="2874"){
					    capa.innerHTML="TALLER DE CARPINTERIA ";
					}else if(opcionSeleccionada=="2875"){
					    capa.innerHTML="TALLER DE DIBUJO TECNICO ";
					}else if(opcionSeleccionada=="2876"){
					    capa.innerHTML="TALLER DE LENGUAJE ";
					}else if(opcionSeleccionada=="2877"){
					    capa.innerHTML="TALLER MADERAS ";
					}else if(opcionSeleccionada=="2878"){
					    capa.innerHTML="TALLER TELAS ";
					}else if(opcionSeleccionada=="2879"){
					    capa.innerHTML="TECNICAS DE INVESTIGACION Y ESTADISTICA APLICADA ";
					}else if(opcionSeleccionada=="2880"){
					    capa.innerHTML="TECNICAS APLICADA ";
					}else if(opcionSeleccionada=="2881"){
					    capa.innerHTML="TECNICAS DE LA PUBLICIDAD ";
					}else if(opcionSeleccionada=="2882"){
					    capa.innerHTML="TEORIA DE ALIMENTACION COLECTIVA ";
					}else if(opcionSeleccionada=="2883"){
					    capa.innerHTML="TEORIA DE DIETETICA ";
					}else if(opcionSeleccionada=="2884"){
					    capa.innerHTML="TOPOGRAFIA ";
					}else if(opcionSeleccionada=="2885"){
					    capa.innerHTML="TRAMITACION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="2886"){
					    capa.innerHTML="TURISMO ";
					}else if(opcionSeleccionada=="2887"){
					    capa.innerHTML="COMPOSICION Y UTILIZACION DE MATERIALES ";
					}else if(opcionSeleccionada=="2888"){
					    capa.innerHTML="NORMAS Y MEDIDAS ";
					}else if(opcionSeleccionada=="2889"){
					    capa.innerHTML="EXPERIENCIA VOCACIONAL ";
					}else if(opcionSeleccionada=="2890"){
					    capa.innerHTML="DISENO E INTERPRETACION DE PLANOS MANUALES ";
					}else if(opcionSeleccionada=="2891"){
					    capa.innerHTML="INTRODUCCION A LA MECANICA INDUSTRIAL ";
					}else if(opcionSeleccionada=="2892"){
					    capa.innerHTML="INTERPRETACION DE ESQUEMAS, PLANOS Y MANUALES ELECTRICOS ";
					}else if(opcionSeleccionada=="2893"){
					    capa.innerHTML="INTERPRETACION DE ESQUEMAS Y MANUALES ";
					}else if(opcionSeleccionada=="2894"){
					    capa.innerHTML="INTRODUCCION A LA MECANICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="2895"){
					    capa.innerHTML="INTERPRETACION DE PLANOS ESTRUCTURALES ";
					}else if(opcionSeleccionada=="2896"){
					    capa.innerHTML="INTRODUCCION A LAS CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="2897"){
					    capa.innerHTML="DISENO DE PLANOS E INTERPRETACION DE MANUALES DE INSTALACIONES SANITARIAS ";
					}else if(opcionSeleccionada=="2898"){
					    capa.innerHTML="INTRODUCCION A LAS INSTALACIONES SANITARIAS ";
					}else if(opcionSeleccionada=="2831"){
					    capa.innerHTML="PRINCIPIOS ELECTRICOS Y ELECTRONICOS ";
					}else if(opcionSeleccionada=="2832"){
					    capa.innerHTML="CINE Y LITERATURA: DOS VISIONES COMPLEMENTARIAS DE LA FICCION ";
					}else if(opcionSeleccionada=="2833"){
					    capa.innerHTML="HISTORIA DE CHILE EN EL SIGLO XX ";
					}else if(opcionSeleccionada=="2834"){
					    capa.innerHTML="LA COMUNICACION A TRAVES DEL TEATRO ";
					}else if(opcionSeleccionada=="2835"){
					    capa.innerHTML="BIOLOGIA CELULAR ";
					}else if(opcionSeleccionada=="2836"){
					    capa.innerHTML="LEXICOLOGIA ";
					}else if(opcionSeleccionada=="2837"){
					    capa.innerHTML="INTRODUCCION A LA INFORMATICA Y FUNDAMENTOS DE PROGRAMACION ";
					}else if(opcionSeleccionada=="2838"){
					    capa.innerHTML="CIENCIAS SOCIALES HISTORIA Y GEOGRAFIA ";
					}else if(opcionSeleccionada=="2839"){
					    capa.innerHTML="HISTORIA Y CIENCIAS SOCIALES FORMACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="2840"){
					    capa.innerHTML="BIOLOGIA FORMACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="2841"){
					    capa.innerHTML="ARTES VISUALES FORMACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="2842"){
					    capa.innerHTML="FISICA FORMACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="2843"){
					    capa.innerHTML="FILOSOFIA Y PSICOLOGIA FORMACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="2844"){
					    capa.innerHTML="ANALISIS MATEMATICO ";
					}else if(opcionSeleccionada=="2845"){
					    capa.innerHTML="ALGUNOS PROBLEMAS DE CHILE CONTEMPORANEO A TRAVES DE DOCUMENTOS ";
					}else if(opcionSeleccionada=="2846"){
					    capa.innerHTML="ALIMENTO Y SALUD ";
					}else if(opcionSeleccionada=="2847"){
					    capa.innerHTML="AREA TECNICA ARTISTICA ";
					}else if(opcionSeleccionada=="2848"){
					    capa.innerHTML="CALIDAD DEL SUELO ";
					}else if(opcionSeleccionada=="2849"){
					    capa.innerHTML="CASTELLANO INSTRUMENTAL ";
					}else if(opcionSeleccionada=="2850"){
					    capa.innerHTML="CIENCIAS SOCIALES Y GEOGRAFIA ";
					}else if(opcionSeleccionada=="2851"){
					    capa.innerHTML="COMERCIALIZACION Y PROYECTOS ";
					}else if(opcionSeleccionada=="2852"){
					    capa.innerHTML="COMERCIO Y CONTABILIDAD ";
					}else if(opcionSeleccionada=="2853"){
					    capa.innerHTML="COSMETOLOGIA ";
					}else if(opcionSeleccionada=="2854"){
					    capa.innerHTML="CULTURA MUSICAL ";
					}else if(opcionSeleccionada=="2855"){
					    capa.innerHTML="DISENO GRAFICO PUBLICITARIO ";
					}else if(opcionSeleccionada=="2856"){
					    capa.innerHTML="DISENO, CORTE Y CONFECCION ";
					}else if(opcionSeleccionada=="2857"){
					    capa.innerHTML="ECONOMIA Y COMERCIO EXTERIOR ";
					}else if(opcionSeleccionada=="2858"){
					    capa.innerHTML="ESTABLECIMIENTO JURIDICO Y ADMINISTRATIVO DE LA MICRO EMPRESA ";
					}else if(opcionSeleccionada=="2859"){
					    capa.innerHTML="TALLER DE HARDWARE ";
					}else if(opcionSeleccionada=="2860"){
					    capa.innerHTML="FISICA ELECTIVA ";
					}else if(opcionSeleccionada=="2861"){
					    capa.innerHTML="GANADERIA MENOR ";
					}else if(opcionSeleccionada=="2862"){
					    capa.innerHTML="HOTELERIA I ";
					}else if(opcionSeleccionada=="2863"){
					    capa.innerHTML="HOTELERIA II ";
					}else if(opcionSeleccionada=="2864"){
					    capa.innerHTML="INTRODUCCION A LAS PESQUERIAS ";
					}else if(opcionSeleccionada=="2795"){
					    capa.innerHTML="FOTOGRAFIA PUBLICITARIA ";
					}else if(opcionSeleccionada=="2796"){
					    capa.innerHTML="SOCIEDAD, ESTADO Y DERECHO ";
					}else if(opcionSeleccionada=="2797"){
					    capa.innerHTML="EVOLUCION JURIDICA Y SOCIAL DE CHILE SIGLO XX ";
					}else if(opcionSeleccionada=="2798"){
					    capa.innerHTML="HISTORIA MUNDIAL DEL SIGLO XX ";
					}else if(opcionSeleccionada=="2801"){
					    capa.innerHTML="FILOSOFIA:PROBLEMAS DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="2802"){
					    capa.innerHTML="MATEMATICA DIFERENCIADA ";
					}else if(opcionSeleccionada=="2803"){
					    capa.innerHTML="HISTORIA DE LAS RELACIONES ENTRE LOS ESTADOS ";
					}else if(opcionSeleccionada=="2804"){
					    capa.innerHTML="FISIOLOGIA HUMANA ";
					}else if(opcionSeleccionada=="2805"){
					    capa.innerHTML="CIENCIAS SOCIALES E HISTORICAS ";
					}else if(opcionSeleccionada=="2806"){
					    capa.innerHTML="PRINCIPIOS CONTABLES BASICOS ";
					}else if(opcionSeleccionada=="2807"){
					    capa.innerHTML="PROGRAMACION EN BASE DE DATOS DBASE II ";
					}else if(opcionSeleccionada=="2808"){
					    capa.innerHTML="ADMINISTRACION DE PEQUENA EMPRESA ";
					}else if(opcionSeleccionada=="2809"){
					    capa.innerHTML="HISTORIA DEL SIGLO XX ";
					}else if(opcionSeleccionada=="2810"){
					    capa.innerHTML="METODOLOGIA DE PROYECTO ";
					}else if(opcionSeleccionada=="2811"){
					    capa.innerHTML="NOCIONES DE ANTROPOLOGIA FILOSOFICA ";
					}else if(opcionSeleccionada=="2812"){
					    capa.innerHTML="DESARROLLO ECONOMICO ";
					}else if(opcionSeleccionada=="2813"){
					    capa.innerHTML="LEGISLACION AMBIENTAL ";
					}else if(opcionSeleccionada=="2814"){
					    capa.innerHTML="RECURSOS RENOVABLES Y NO RENOVABLES ";
					}else if(opcionSeleccionada=="2815"){
					    capa.innerHTML="PREVENCION DE RIESGO AMBIENTAL ";
					}else if(opcionSeleccionada=="2816"){
					    capa.innerHTML="EVALUACION IMPACTO AMBIENTAL ";
					}else if(opcionSeleccionada=="2817"){
					    capa.innerHTML="TEMATICAS FILOSOFICAS Y PSICOLOGICAS ";
					}else if(opcionSeleccionada=="2818"){
					    capa.innerHTML="CULTURA Y FILOSOFIA ";
					}else if(opcionSeleccionada=="2819"){
					    capa.innerHTML="FILOSOFIA ELECTIVA ";
					}else if(opcionSeleccionada=="2820"){
					    capa.innerHTML="GEOGRAFIA APLICADA ";
					}else if(opcionSeleccionada=="2821"){
					    capa.innerHTML="ESTRATEGIAS DEL PENSAMIENTO ";
					}else if(opcionSeleccionada=="2822"){
					    capa.innerHTML="GRANDES ACONTECIMIENTOS DEL SIGLO XX ";
					}else if(opcionSeleccionada=="2823"){
					    capa.innerHTML="ELECTIVO LENGUA CASTELLANA Y COMUNICACION ";
					}else if(opcionSeleccionada=="2824"){
					    capa.innerHTML="REALIDAD NACIONAL ";
					}else if(opcionSeleccionada=="2825"){
					    capa.innerHTML="LITERATURA CONTEMPORANEA E HISPANOAMERICANA ";
					}else if(opcionSeleccionada=="2826"){
					    capa.innerHTML="HERRAMIENTAS DE PRODUCCION ";
					}else if(opcionSeleccionada=="2827"){
					    capa.innerHTML="PROTOCOLO ";
					}else if(opcionSeleccionada=="2828"){
					    capa.innerHTML="MEDICION Y ANALISIS DE SENALES EN TELECOMUNICACIONES ";
					}else if(opcionSeleccionada=="2829"){
					    capa.innerHTML="INSTALACION,CONFIGURACION Y MANTENCION DE SISTEMAS OPERATIVOS Y DE SERVICIOS PARA REDES DE COMPUTADORES ";
					}else if(opcionSeleccionada=="2830"){
					    capa.innerHTML="ESTRUCTURAS LOGICAS ";
					}else if(opcionSeleccionada=="2761"){
					    capa.innerHTML="HISTORIA DE LAS MANIFESTACIONES ARTISTICAS A TRAVES DE LA EVOLUCION LA PINTURA, HISTORIA DEL ARTE Y FOTOGRAFIA ";
					}else if(opcionSeleccionada=="2762"){
					    capa.innerHTML="FISICA, MECANICA Y GRAVITACION UNIVERSAL ";
					}else if(opcionSeleccionada=="2763"){
					    capa.innerHTML="COMPRENSION DE LA NATURALEZA A TRAVES DE LA EVOLUCION ";
					}else if(opcionSeleccionada=="2764"){
					    capa.innerHTML="GRAFICA, PINTURA, ESCULTURA E HISTORIA DEL ARTE ";
					}else if(opcionSeleccionada=="2765"){
					    capa.innerHTML="LABORATORIO DE PRODUCTOS CULINARIOS ";
					}else if(opcionSeleccionada=="2766"){
					    capa.innerHTML="ADMINISTRACION Y PROYECTOS COMERCIALES ";
					}else if(opcionSeleccionada=="2767"){
					    capa.innerHTML="METODOLOGIA DE LA EDUCACION PARVULARIA ";
					}else if(opcionSeleccionada=="2768"){
					    capa.innerHTML="TEORIA BASICA DE LA ADMINISTRACION DE EMPRESAS ";
					}else if(opcionSeleccionada=="2769"){
					    capa.innerHTML="ELECTRONICA EN MANTENCION DE EQUIPOS COMPUTACIONALES ";
					}else if(opcionSeleccionada=="2770"){
					    capa.innerHTML="NORMALIZACION Y PROYECTO ";
					}else if(opcionSeleccionada=="2771"){
					    capa.innerHTML="PUBLICIDAD,DISENO Y DIBUJO TECNICO ";
					}else if(opcionSeleccionada=="2772"){
					    capa.innerHTML="COLOR Y COMPOSICION ";
					}else if(opcionSeleccionada=="2773"){
					    capa.innerHTML="MUSICA APLICADA ";
					}else if(opcionSeleccionada=="2774"){
					    capa.innerHTML="TALLER MUSICAL Y SOFTWARE ";
					}else if(opcionSeleccionada=="2775"){
					    capa.innerHTML="CIENTIFICA ";
					}else if(opcionSeleccionada=="2776"){
					    capa.innerHTML="ARTISTICA ";
					}else if(opcionSeleccionada=="2777"){
					    capa.innerHTML="HUMANISTICA ";
					}else if(opcionSeleccionada=="2778"){
					    capa.innerHTML="TENDENCIAS LITERARIAS ";
					}else if(opcionSeleccionada=="2779"){
					    capa.innerHTML="COMPETENCIAS LINGUISTICAS ";
					}else if(opcionSeleccionada=="2780"){
					    capa.innerHTML="PROYECTOS DE COMUNICACION ";
					}else if(opcionSeleccionada=="2781"){
					    capa.innerHTML="GENERAL ";
					}else if(opcionSeleccionada=="2782"){
					    capa.innerHTML="EVOLUCION, AMBIENTE Y ORGANISMO ";
					}else if(opcionSeleccionada=="2783"){
					    capa.innerHTML="MECANICA,TERMODINAMICA Y ELECTRICIDAD ";
					}else if(opcionSeleccionada=="2784"){
					    capa.innerHTML="INORGANICA Y ORGANICA ";
					}else if(opcionSeleccionada=="2785"){
					    capa.innerHTML="EVOLUCIONES ECONOMICAS ";
					}else if(opcionSeleccionada=="2786"){
					    capa.innerHTML="MENTALIDADES DE LA HISTORIA ";
					}else if(opcionSeleccionada=="2787"){
					    capa.innerHTML="HISTORIA UNIVERSAL GENERAL ";
					}else if(opcionSeleccionada=="2788"){
					    capa.innerHTML="FUNDAMENTO DE LAS RELACIONES LABORALES ";
					}else if(opcionSeleccionada=="2789"){
					    capa.innerHTML="FORMA, ESPACIO Y COLOR ";
					}else if(opcionSeleccionada=="2790"){
					    capa.innerHTML="TEORIA DEL COLOR ";
					}else if(opcionSeleccionada=="2791"){
					    capa.innerHTML="PRACTICA Y LABORATORIO DE ELECTRONICA ";
					}else if(opcionSeleccionada=="2792"){
					    capa.innerHTML="ELECTRONICA INDUSTRIAL BASICA ";
					}else if(opcionSeleccionada=="2793"){
					    capa.innerHTML="TALLER DE DISENO Y EXPRESION GRAFICA ";
					}else if(opcionSeleccionada=="2794"){
					    capa.innerHTML="TECNICA DE IMPRESION ";
					}else if(opcionSeleccionada=="2727"){
					    capa.innerHTML="MICROEMPRESA ";
					}else if(opcionSeleccionada=="2728"){
					    capa.innerHTML="HISTORIA DEL SIGLO XX: UN NUEVO ENFOQUE DE LAS RELACIONES INTERNACIONALES ";
					}else if(opcionSeleccionada=="2729"){
					    capa.innerHTML="HACIA LA FILOSOFIA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="2730"){
					    capa.innerHTML="RESOLUCION DE PROBLEMAS:LENGUAJES ESTRUCTURADOS ";
					}else if(opcionSeleccionada=="2731"){
					    capa.innerHTML="MODIFICACIONES Y REPARACIONES ESTRUCTURALES DEL VEHICULOS ";
					}else if(opcionSeleccionada=="2732"){
					    capa.innerHTML="PREPARACION Y EMBELLECIMIENTO DE SUPERFICIES DEL VEHICULO ";
					}else if(opcionSeleccionada=="2733"){
					    capa.innerHTML="TRAZADO Y CORTE DE CHAPAS, PERFILES Y TUBOS ";
					}else if(opcionSeleccionada=="2734"){
					    capa.innerHTML="TOPOGRAFIA EN OBRAS VIALES ";
					}else if(opcionSeleccionada=="2735"){
					    capa.innerHTML="ORIGENES E HISTORIA DE LA QUIMICA ";
					}else if(opcionSeleccionada=="2736"){
					    capa.innerHTML="INTRODUCCION A LA TERMODINAMICA ";
					}else if(opcionSeleccionada=="2737"){
					    capa.innerHTML="FUNDAMENTOS DE ESPECTROSCOPIA ";
					}else if(opcionSeleccionada=="2738"){
					    capa.innerHTML="CATALISIS ";
					}else if(opcionSeleccionada=="2739"){
					    capa.innerHTML="SISTEMAS TECNOLOGICOS ";
					}else if(opcionSeleccionada=="2740"){
					    capa.innerHTML="LAS ORGANIZACIONES Y EL TRABAJO ";
					}else if(opcionSeleccionada=="2741"){
					    capa.innerHTML="HERRAMIENTAS Y TECNICAS BASICAS DE GESTION E INSERCION LABORAL ";
					}else if(opcionSeleccionada=="50006"){
					    capa.innerHTML="LECTURA ";
					}else if(opcionSeleccionada=="2743"){
					    capa.innerHTML="EDUCACION TECNOLOGICA FORMACION DIFERENCIADA 3°ANO MEDIO HUMANISTICO-CIENTIFICO ";
					}else if(opcionSeleccionada=="2744"){
					    capa.innerHTML="ELEMENTOS DE GEOMETRIA II ";
					}else if(opcionSeleccionada=="2745"){
					    capa.innerHTML="AUDIOVISUAL ";
					}else if(opcionSeleccionada=="2746"){
					    capa.innerHTML="COMPUTACION APLICADA II ";
					}else if(opcionSeleccionada=="2747"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA DE CHILE Y ECONOMIA ";
					}else if(opcionSeleccionada=="2748"){
					    capa.innerHTML="CONOCIENDO MI PAIS ";
					}else if(opcionSeleccionada=="2749"){
					    capa.innerHTML="LITERATURA Y LETRAS UNIVERSALES ";
					}else if(opcionSeleccionada=="2750"){
					    capa.innerHTML="CONOCIENDO LA GEOGRAFIA DE MI PAIS ";
					}else if(opcionSeleccionada=="2751"){
					    capa.innerHTML="COMPRENSION DE LA NATURALEZA ";
					}else if(opcionSeleccionada=="2752"){
					    capa.innerHTML="COMPRENSION DE LA SOCIEDAD ";
					}else if(opcionSeleccionada=="2753"){
					    capa.innerHTML="CIRCULACION DE LA MATERIA EN ANIMALES Y HERENCIA ";
					}else if(opcionSeleccionada=="2754"){
					    capa.innerHTML="LA EVOLUCION DEL ESTADO ";
					}else if(opcionSeleccionada=="2755"){
					    capa.innerHTML="LA COMPUTACION EN EL AMBITO DEL TRABAJO ";
					}else if(opcionSeleccionada=="2756"){
					    capa.innerHTML="LENGUAJE Y LITERATURA ";
					}else if(opcionSeleccionada=="2757"){
					    capa.innerHTML="CIENCIAS SOCIALES Y REALIDAD NACIONAL E INTERNACIONAL ";
					}else if(opcionSeleccionada=="2758"){
					    capa.innerHTML="QUIMICA DE LOS NUEVOS TIEMPOS ";
					}else if(opcionSeleccionada=="2759"){
					    capa.innerHTML="EL INGLES EN EL MUNDO DE LAS CIENCIAS ";
					}else if(opcionSeleccionada=="2760"){
					    capa.innerHTML="ANALISIS DE LA REALIDAD ECONOMICA ";
					}else if(opcionSeleccionada=="2692"){
					    capa.innerHTML="ACTIVIDADES MOTRICES DE CONTACTO CON LA NATURALEZA Y DE AVENTURA";
					}else if(opcionSeleccionada=="2693"){
					    capa.innerHTML="CONDICION FISICA Y MOTRIZ ASOCIADA A SALUD Y CALIDAD DE VIDA ";
					}else if(opcionSeleccionada=="2694"){
					    capa.innerHTML="DEPORTES Y ACTIVIDADES DE EXPRESION MOTRIZ ";
					}else if(opcionSeleccionada=="2695"){
					    capa.innerHTML="APLICACIONES DE LA MATEMATICA: GEOMETRIA ANALITICA PLANA ";
					}else if(opcionSeleccionada=="2696"){
					    capa.innerHTML="APLICACIONES DE LA MATEMATICA: NOCION INTUITIVA DE DERIVADA DE UNA FUNCION ";
					}else if(opcionSeleccionada=="2697"){
					    capa.innerHTML="LOGICA Y FUNCIONES ";
					}else if(opcionSeleccionada=="2698"){
					    capa.innerHTML="FISICA: MECANICA ";
					}else if(opcionSeleccionada=="2699"){
					    capa.innerHTML="QUIMICA: QUIMICA INORGANICA ";
					}else if(opcionSeleccionada=="2700"){
					    capa.innerHTML="ECONOMIA Y SU IMPACTO SOCIAL ";
					}else if(opcionSeleccionada=="2701"){
					    capa.innerHTML="TECNICA DE LA COMUNICACION ESCRITA EN EL AREA COMERCIAL Y ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="2702"){
					    capa.innerHTML="BIOLOGIA:ECOLOGIA Y EVOLUCION ";
					}else if(opcionSeleccionada=="2703"){
					    capa.innerHTML="INTRODUCCION AL DERECHO ";
					}else if(opcionSeleccionada=="2704"){
					    capa.innerHTML="LA CIUDAD EN LA HISTORIA ";
					}else if(opcionSeleccionada=="2705"){
					    capa.innerHTML="FILOSOFIA Y PSICOLOGIA:LOGICA ";
					}else if(opcionSeleccionada=="2706"){
					    capa.innerHTML="MANEJO DE LA HIGIENE EN PARVULOS ";
					}else if(opcionSeleccionada=="2707"){
					    capa.innerHTML="ELECTIVO BIOLOGIA ";
					}else if(opcionSeleccionada=="2708"){
					    capa.innerHTML="EXPRESION CREATIVA ";
					}else if(opcionSeleccionada=="2709"){
					    capa.innerHTML="TEOLOGIA Y FORMACION ETICO Y MORAL ";
					}else if(opcionSeleccionada=="2710"){
					    capa.innerHTML="ESTUDIO DE LAS CIENCIAS SOCIALES Y EL MEDIO ";
					}else if(opcionSeleccionada=="2711"){
					    capa.innerHTML="ESTUDIO CIENTIFICOS Y SU APLICACION ";
					}else if(opcionSeleccionada=="2712"){
					    capa.innerHTML="ESTUDIOS MATEMATICOS Y SU APLICACION ";
					}else if(opcionSeleccionada=="2713"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION: INGLES ";
					}else if(opcionSeleccionada=="2714"){
					    capa.innerHTML="LABORATORIO DE VERIFICACION Y AJUSTE DE MOTORES ";
					}else if(opcionSeleccionada=="2715"){
					    capa.innerHTML="LABORATORIO DE MAQUINAS Y EQUIPOS ";
					}else if(opcionSeleccionada=="4634"){
					    capa.innerHTML="F.DIF LENGUA CASTELLANA Y COMUNICA ";
					}else if(opcionSeleccionada=="2717"){
					    capa.innerHTML="LABORATORIO DE ELECTROHIDRONEUMATICA ";
					}else if(opcionSeleccionada=="2718"){
					    capa.innerHTML="LABORATORIO DE PROYECTO Y COMPUTACION ";
					}else if(opcionSeleccionada=="2719"){
					    capa.innerHTML="COMPORTAMIENTO ORGANIZACIONAL ";
					}else if(opcionSeleccionada=="2720"){
					    capa.innerHTML="LABORATORIO DE TRATAMIENTOS TERMICOS ";
					}else if(opcionSeleccionada=="2721"){
					    capa.innerHTML="PROGRAMACION DE LA MANTENCION ";
					}else if(opcionSeleccionada=="2722"){
					    capa.innerHTML="AMERICA LATINA PRESENTE PASADO Y FUTURO ";
					}else if(opcionSeleccionada=="2723"){
					    capa.innerHTML="ELECTRICIDAD Y ELECTROMAGNETISMO ";
					}else if(opcionSeleccionada=="2725"){
					    capa.innerHTML="PELUQUERIA ";
					}else if(opcionSeleccionada=="2726"){
					    capa.innerHTML="TAPICERIA ";
					}else if(opcionSeleccionada=="2658"){
					    capa.innerHTML="EDUCACION ARTISTICA: ARTES MUSICALES ";
					}else if(opcionSeleccionada=="2659"){
					    capa.innerHTML="GEOGRAFIA DE CHILE ";
					}else if(opcionSeleccionada=="2660"){
					    capa.innerHTML="TEORIA DEL ARTE ";
					}else if(opcionSeleccionada=="2661"){
					    capa.innerHTML="TALLER CERAMICA ";
					}else if(opcionSeleccionada=="2662"){
					    capa.innerHTML="TALLER ESCULTURA ";
					}else if(opcionSeleccionada=="2663"){
					    capa.innerHTML="TALLER GRABADO ";
					}else if(opcionSeleccionada=="2664"){
					    capa.innerHTML="TALLER ORFEBRERIA ";
					}else if(opcionSeleccionada=="2665"){
					    capa.innerHTML="TALLER PINTURA ";
					}else if(opcionSeleccionada=="2666"){
					    capa.innerHTML="TALLER FOTOGRAFIA ";
					}else if(opcionSeleccionada=="2667"){
					    capa.innerHTML="INSTRUMENTO PRINCIPAL GUITARRA ";
					}else if(opcionSeleccionada=="2668"){
					    capa.innerHTML="INSTRUMENTO PRINCIPAL FLAUTA ";
					}else if(opcionSeleccionada=="2669"){
					    capa.innerHTML="INSTRUMENTO PRINCIPAL PIANO ";
					}else if(opcionSeleccionada=="2670"){
					    capa.innerHTML="INSTRUMENTO PRINCIPAL VIOLIN ";
					}else if(opcionSeleccionada=="2671"){
					    capa.innerHTML="HISTORIA DE LA MUSICA ";
					}else if(opcionSeleccionada=="2672"){
					    capa.innerHTML="TEORIA DE LOS INSTRUMENTOS ";
					}else if(opcionSeleccionada=="2673"){
					    capa.innerHTML="CIENCIA TEOLOGICA Y ETICA ";
					}else if(opcionSeleccionada=="2674"){
					    capa.innerHTML="MATEMATICA ESPECIFICA ";
					}else if(opcionSeleccionada=="2675"){
					    capa.innerHTML="GEOGRAFIA FISICA ";
					}else if(opcionSeleccionada=="2676"){
					    capa.innerHTML="FISICO MATEMATICA ";
					}else if(opcionSeleccionada=="2677"){
					    capa.innerHTML="CULTURA CLASICA ";
					}else if(opcionSeleccionada=="2678"){
					    capa.innerHTML="CIENCIAS POLITICAS ";
					}else if(opcionSeleccionada=="2679"){
					    capa.innerHTML="DOCTRINAS SOCIALES ";
					}else if(opcionSeleccionada=="2680"){
					    capa.innerHTML="BIOLOGIA ESPECIFICA ";
					}else if(opcionSeleccionada=="2681"){
					    capa.innerHTML="REDACCION Y LITERATURA ";
					}else if(opcionSeleccionada=="2682"){
					    capa.innerHTML="MECANICA DE FLUIDOS ";
					}else if(opcionSeleccionada=="2683"){
					    capa.innerHTML="EXPRESION CULTURAL ";
					}else if(opcionSeleccionada=="2684"){
					    capa.innerHTML="CIENTIFICO TECNOLOGICO ";
					}else if(opcionSeleccionada=="2685"){
					    capa.innerHTML="VOCACIONAL ";
					}else if(opcionSeleccionada=="2686"){
					    capa.innerHTML="LITERARIO CULTURAL ";
					}else if(opcionSeleccionada=="2687"){
					    capa.innerHTML="FUNCIONES Y PROCESOS INFINITOS ";
					}else if(opcionSeleccionada=="2688"){
					    capa.innerHTML="QUIMICA FORMACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="2689"){
					    capa.innerHTML="QUIMICA FORMACION DIFERENCIADA I ";
					}else if(opcionSeleccionada=="2690"){
					    capa.innerHTML="EDUCACION TECNOLOGICA FORMACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="2691"){
					    capa.innerHTML="ARTES ESCENICAS, TEATRO, DANZA ";
					}else if(opcionSeleccionada=="2624"){
					    capa.innerHTML="TRASLADO E INSTALACION DE EQUIPOS Y COMPONENTES ";
					}else if(opcionSeleccionada=="2625"){
					    capa.innerHTML="TRATAMIENTO DE LA MADERA ";
					}else if(opcionSeleccionada=="2626"){
					    capa.innerHTML="TRATAMIENTO DE PRODUCTOS ALIMENTICIOS EN FRIO ";
					}else if(opcionSeleccionada=="2627"){
					    capa.innerHTML="TRATAMIENTO TERMICO DE LOS METALES ";
					}else if(opcionSeleccionada=="2628"){
					    capa.innerHTML="TRATAMIENTOS DE CONSERVACION DE PRODUCTOS ALIMENTICIOS ";
					}else if(opcionSeleccionada=="2629"){
					    capa.innerHTML="TRATAMIENTOS DE PROTECCION ";
					}else if(opcionSeleccionada=="2630"){
					    capa.innerHTML="TRAZADO Y DESARROLLO DE PLANCHAS ";
					}else if(opcionSeleccionada=="2631"){
					    capa.innerHTML="TRAZADO Y EXCAVACION DE OBRAS DE EDIFICACION ";
					}else if(opcionSeleccionada=="2632"){
					    capa.innerHTML="TRITURACION INDUSTRIAL DE MINERALES ";
					}else if(opcionSeleccionada=="2633"){
					    capa.innerHTML="TRONADURA ";
					}else if(opcionSeleccionada=="2634"){
					    capa.innerHTML="UNIONES, ARMADOS Y MONTAJE EN OBRA ";
					}else if(opcionSeleccionada=="2635"){
					    capa.innerHTML="USO DE GASES INDUSTRIALES Y REFRIGERANTES ";
					}else if(opcionSeleccionada=="2636"){
					    capa.innerHTML="VESTUARIO DEL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="2637"){
					    capa.innerHTML="COMUNICACION Y REDACCION APLICADA ";
					}else if(opcionSeleccionada=="2638"){
					    capa.innerHTML="RELACIONES PUBLICAS Y ATENCION AL CLIENTE ";
					}else if(opcionSeleccionada=="2639"){
					    capa.innerHTML="ANALISIS DE LA EXPERIENCIA EN LA EMPRESA ";
					}else if(opcionSeleccionada=="2640"){
					    capa.innerHTML="VERIFICACION DE EXISTENCIAS ";
					}else if(opcionSeleccionada=="2641"){
					    capa.innerHTML="TALLER DE SOLUCION DE PROBLEMAS ";
					}else if(opcionSeleccionada=="2642"){
					    capa.innerHTML="TALLER DE DEPORTES ";
					}else if(opcionSeleccionada=="2643"){
					    capa.innerHTML="TALLER SACRAMENTAL ";
					}else if(opcionSeleccionada=="2644"){
					    capa.innerHTML="TALLER DE DESARROLLO PERSONAL Y VIDA CRISTIANA ";
					}else if(opcionSeleccionada=="2645"){
					    capa.innerHTML="SOCIAL COMUNICATIVO ";
					}else if(opcionSeleccionada=="2646"){
					    capa.innerHTML="PERSPECTIVA HISTORICA DEL HOMBRE ";
					}else if(opcionSeleccionada=="2647"){
					    capa.innerHTML="FORMAS VIVIENTES Y SUS FUNCIONES ";
					}else if(opcionSeleccionada=="2648"){
					    capa.innerHTML="APLICACIONES MATEMATICAS COMPLEJAS ";
					}else if(opcionSeleccionada=="2649"){
					    capa.innerHTML="IDENTIDAD CHILENA EN SU CONTEXTO HISTORICO GEOGRAFICO ";
					}else if(opcionSeleccionada=="2650"){
					    capa.innerHTML="BASQUETBOL ";
					}else if(opcionSeleccionada=="2651"){
					    capa.innerHTML="ANTROPOLOGIA CRISTIANA ";
					}else if(opcionSeleccionada=="2652"){
					    capa.innerHTML="EDUCACION MATEMATICA: MATEMATICA ";
					}else if(opcionSeleccionada=="2653"){
					    capa.innerHTML="COMPRENSION DEL MEDIO NATURAL SOCIAL Y CULTURAL:CIENCIAS NATURALES ";
					}else if(opcionSeleccionada=="2654"){
					    capa.innerHTML="COMPRENSION DEL MEDIO NATURAL SOCIAL Y CULTURAL:CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="2655"){
					    capa.innerHTML="EDUCACION ARTISTICA: ARTES PLASTICAS ";
					}else if(opcionSeleccionada=="2656"){
					    capa.innerHTML="EDUCACION ARTISTICA: EDUCACION MUSICAL ";
					}else if(opcionSeleccionada=="2657"){
					    capa.innerHTML="RELIGION:FORMACION CRISTIANA ";
					}else if(opcionSeleccionada=="2590"){
					    capa.innerHTML="SISTEMAS DE PRODUCCION ANIMAL ";
					}else if(opcionSeleccionada=="2591"){
					    capa.innerHTML="SISTEMAS DE PRODUCCION VEGETAL ";
					}else if(opcionSeleccionada=="2592"){
					    capa.innerHTML="SISTEMAS ELECTRONICOS DIGITALES ";
					}else if(opcionSeleccionada=="2593"){
					    capa.innerHTML="SISTEMAS NEUMATICOS E HIDRAULICOS ";
					}else if(opcionSeleccionada=="2594"){
					    capa.innerHTML="SISTEMAS Y EQUIPOS DE POS IMPRESION ";
					}else if(opcionSeleccionada=="2595"){
					    capa.innerHTML="SOBREVIVENCIA EN EL MAR ";
					}else if(opcionSeleccionada=="2596"){
					    capa.innerHTML="SOBREVIVENCIA EN EL MAR Y COMBATE DE INCENDIOS ";
					}else if(opcionSeleccionada=="2597"){
					    capa.innerHTML="SOLDADURAS ";
					}else if(opcionSeleccionada=="2598"){
					    capa.innerHTML="SOLDADURAS EN INSTALACIONES SANITARIAS ";
					}else if(opcionSeleccionada=="2599"){
					    capa.innerHTML="SOLDADURA EN ATMOSFERA NATURAL Y ATMOSFERA PROTEGIDA ";
					}else if(opcionSeleccionada=="2600"){
					    capa.innerHTML="SONDAJES Y MOVIMIENTOS DE TIERRA ";
					}else if(opcionSeleccionada=="2601"){
					    capa.innerHTML="TABLEROS CONTRAENCHAPADOS ";
					}else if(opcionSeleccionada=="2602"){
					    capa.innerHTML="TABLEROS DE FIBRAS Y DE PARTICULAS AGLOMERADAS ";
					}else if(opcionSeleccionada=="2603"){
					    capa.innerHTML="TALADRADO, TORNEADO Y FRESADO ";
					}else if(opcionSeleccionada=="2604"){
					    capa.innerHTML="TAREAS DE SERVICIO EN PLANTAS CONCENTRADORAS ";
					}else if(opcionSeleccionada=="2605"){
					    capa.innerHTML="TAREAS DE SERVICIO EN PLANTAS DE REDUCCION DE TAMANO ";
					}else if(opcionSeleccionada=="2606"){
					    capa.innerHTML="TAREAS DE SERVICIO EN PLANTAS HIDROMETALURGICAS ";
					}else if(opcionSeleccionada=="2607"){
					    capa.innerHTML="TAREAS DE SERVICIO EN PLANTAS PIROMETALURGICAS ";
					}else if(opcionSeleccionada=="2608"){
					    capa.innerHTML="TECNICA EN VENTAS ";
					}else if(opcionSeleccionada=="2609"){
					    capa.innerHTML="TECNICAS DE BUCEO ";
					}else if(opcionSeleccionada=="2610"){
					    capa.innerHTML="TECNICAS DE ELABORACION Y PRESENTACION DE ALIMENTOS PARA COCTEL ";
					}else if(opcionSeleccionada=="2611"){
					    capa.innerHTML="TECNICAS DE IMPERMEABILIZACION Y AISLACION ";
					}else if(opcionSeleccionada=="2612"){
					    capa.innerHTML="TECNICAS DE MECANIZADO PARA EL MANTENIMIENTO DE VEHICULOS ";
					}else if(opcionSeleccionada=="2613"){
					    capa.innerHTML="TECNICAS DE MUESTREO MANUAL DE ROCAS Y MINERALES ";
					}else if(opcionSeleccionada=="2614"){
					    capa.innerHTML="TECNICAS DE SEPARACION: CROMATOGRAFIA Y EXTRACCION ";
					}else if(opcionSeleccionada=="2615"){
					    capa.innerHTML="TECNICAS DE VENTA Y MANEJO DE CAJA ";
					}else if(opcionSeleccionada=="2616"){
					    capa.innerHTML="TECNOLOGIA DE LA MADERA ";
					}else if(opcionSeleccionada=="2617"){
					    capa.innerHTML="TERMINAL DE CONTENEDORES ";
					}else if(opcionSeleccionada=="2618"){
					    capa.innerHTML="TIPOS DE CARGA MARCAJES Y EMBALAJES ";
					}else if(opcionSeleccionada=="2619"){
					    capa.innerHTML="TIPOS DE NAVES MERCANTES ";
					}else if(opcionSeleccionada=="2620"){
					    capa.innerHTML="TOPOGRAFIA EN OBRAS CIVILES ";
					}else if(opcionSeleccionada=="2621"){
					    capa.innerHTML="TRABAJO CON GRUPOS Y COMUNIDADES ";
					}else if(opcionSeleccionada=="2622"){
					    capa.innerHTML="TRABAJO EDUCATIVO CON PARVULOS EN MODALIDAD NO CONVENCIONAL ";
					}else if(opcionSeleccionada=="2623"){
					    capa.innerHTML="TRANSFORMACION DE LA MATERIA PRIMA ";
					}else if(opcionSeleccionada=="2556"){
					    capa.innerHTML="PROYECTOS BASICOS DE MATRICERIA ";
					}else if(opcionSeleccionada=="2557"){
					    capa.innerHTML="PROYECTOS ELECTRICOS EN BAJA TENSION ";
					}else if(opcionSeleccionada=="2558"){
					    capa.innerHTML="PROYECTOS MECANICOS ";
					}else if(opcionSeleccionada=="2559"){
					    capa.innerHTML="PUESTA ES MARCHA Y PRUEBA DE LOS SISTEMAS ";
					}else if(opcionSeleccionada=="2560"){
					    capa.innerHTML="PULPAJE DE ALTO RENDIMIENTO ";
					}else if(opcionSeleccionada=="2561"){
					    capa.innerHTML="PULPAJE QUIMICO ";
					}else if(opcionSeleccionada=="2562"){
					    capa.innerHTML="PURIFICACION DE COMPUESTOS ORGANICOS ";
					}else if(opcionSeleccionada=="2563"){
					    capa.innerHTML="QUIMICA TEXTIL ";
					}else if(opcionSeleccionada=="2564"){
					    capa.innerHTML="RECONOCIMIENTO DE ROCAS Y MINERALES ";
					}else if(opcionSeleccionada=="2565"){
					    capa.innerHTML="RECONOCIMIENTO DE ROCAS, MINERALES, DEPOSITOS Y ESTRUCTURAS GEOLOGICAS ";
					}else if(opcionSeleccionada=="2566"){
					    capa.innerHTML="RECUPERACION DE REACTIVOS ";
					}else if(opcionSeleccionada=="2567"){
					    capa.innerHTML="REDES DE APOYO A LA SALUD DEL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="2568"){
					    capa.innerHTML="REDES DE CABLEADO ";
					}else if(opcionSeleccionada=="2569"){
					    capa.innerHTML="REFINACION DE LA PULPA ";
					}else if(opcionSeleccionada=="2570"){
					    capa.innerHTML="REGISTRO DE INFORMACION TOPOGRAFICA Y GEOLOGICA ";
					}else if(opcionSeleccionada=="2571"){
					    capa.innerHTML="REGLAMENTACION ";
					}else if(opcionSeleccionada=="2572"){
					    capa.innerHTML="REGLAMENTACION MARITIMA, PESQUERA Y AMBIENTAL ";
					}else if(opcionSeleccionada=="2573"){
					    capa.innerHTML="REGULARIZACION CONTABLE ";
					}else if(opcionSeleccionada=="2574"){
					    capa.innerHTML="REPRESENTACION GRAFICA EN CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="2575"){
					    capa.innerHTML="REVESTIMIENTO CON PINTURAS Y PAPELES ";
					}else if(opcionSeleccionada=="2576"){
					    capa.innerHTML="REVESTIMIENTOS PETREOS ";
					}else if(opcionSeleccionada=="2577"){
					    capa.innerHTML="SALUD EN PARVULOS ";
					}else if(opcionSeleccionada=="2578"){
					    capa.innerHTML="SALUD RURAL ";
					}else if(opcionSeleccionada=="2579"){
					    capa.innerHTML="SALUD Y AUTONOMIA DEL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="2580"){
					    capa.innerHTML="SANIDAD Y REPRODUCCION ANIMAL ";
					}else if(opcionSeleccionada=="2581"){
					    capa.innerHTML="SECADO DE LA MADERA ";
					}else if(opcionSeleccionada=="2582"){
					    capa.innerHTML="SEGURIDAD INDUSTRIAL Y PREVENCION DE RIESGOS ";
					}else if(opcionSeleccionada=="2583"){
					    capa.innerHTML="SEGURIDAD INDUSTRIAL Y PRIMEROS AUXILIOS ";
					}else if(opcionSeleccionada=="2584"){
					    capa.innerHTML="SEGURIDAD Y PREVENCION DE RIESGOS EN ACUICULTURA ";
					}else if(opcionSeleccionada=="2585"){
					    capa.innerHTML="SEGURIDAD Y PREVENCION DE RIESGOS EN FAENAS PORTUARIAS ";
					}else if(opcionSeleccionada=="2586"){
					    capa.innerHTML="SEGURIDAD Y PRIMEROS AUXILIOS ";
					}else if(opcionSeleccionada=="2587"){
					    capa.innerHTML="SERVICIO ATENCION AL CLIENTE ";
					}else if(opcionSeleccionada=="2588"){
					    capa.innerHTML="SERVICIOS EN NAVES MERCANTES Y ESPECIALES ";
					}else if(opcionSeleccionada=="2589"){
					    capa.innerHTML="SISTEMAS AUXILIARES PARA LA MECANIZACION ";
					}else if(opcionSeleccionada=="2521"){
					    capa.innerHTML="PLANIFICACION Y CONTROL DE LA PRODUCCION ";
					}else if(opcionSeleccionada=="2522"){
					    capa.innerHTML="PLANIFICACION Y CONTROL DEL AREA DE ALOJAMIENTO ";
					}else if(opcionSeleccionada=="2523"){
					    capa.innerHTML="PREPARACION DE PLATOS PRINCIPALES ";
					}else if(opcionSeleccionada=="2524"){
					    capa.innerHTML="PREPARACION DE PULPAS Y SOLUCIONES ";
					}else if(opcionSeleccionada=="2525"){
					    capa.innerHTML="PREPARACION DE SANDWICH Y PRODUCTOS PARA COCTEL ";
					}else if(opcionSeleccionada=="2526"){
					    capa.innerHTML="PREPARACION DE SUPERFICIES PARA PROTECCION ";
					}else if(opcionSeleccionada=="2527"){
					    capa.innerHTML="PREPARACION DEL EQUIPAMIENTO E INSTRUMENTAL REQUERIDO PARA LA ATENCION ";
					}else if(opcionSeleccionada=="2528"){
					    capa.innerHTML="PREPARACION Y EVALUACION DE PROYECTOS AGROPECUARIOS ";
					}else if(opcionSeleccionada=="2529"){
					    capa.innerHTML="PREPARACION Y PROTECCION DE SUPERFICIES DE CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="2531"){
					    capa.innerHTML="PREPARADO Y CONFECCION DE PRENDAS MASCULINAS DE VESTIR ";
					}else if(opcionSeleccionada=="2532"){
					    capa.innerHTML="PRESENTACION DE ALIMENTOS PARA MENU, CARTA Y BUFFET ";
					}else if(opcionSeleccionada=="2533"){
					    capa.innerHTML="PRESERVACION DE LA MADERA ";
					}else if(opcionSeleccionada=="2534"){
					    capa.innerHTML="PREVENCION DE LA CONTAMINACION Y SEGURIDAD EN LA INDUSTRIA GRAFICA ";
					}else if(opcionSeleccionada=="2535"){
					    capa.innerHTML="PREVENCION DE LA VIOLENCIA INTRAFAMILIAR ";
					}else if(opcionSeleccionada=="2536"){
					    capa.innerHTML="PREVENCION DE LAS ENFERMEDADES INFECTOCONTAGIOSAS ";
					}else if(opcionSeleccionada=="2537"){
					    capa.innerHTML="PREVENCION DE RIESGOS Y PROTECCION DEL MEDIO AMBIENTE EN MINERIA ";
					}else if(opcionSeleccionada=="2538"){
					    capa.innerHTML="PREVENCION DEL CONSUMO DE DROGAS LICITAS E ILICITAS ";
					}else if(opcionSeleccionada=="2539"){
					    capa.innerHTML="PROCEDIMIENTOS ADMINISTRATIVOS EN LA ATENCION DEL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="2540"){
					    capa.innerHTML="PROCEDIMIENTOS BASICOS DE LABORATORIO ";
					}else if(opcionSeleccionada=="2541"){
					    capa.innerHTML="PROCESOS EN PLANTAS CONCENTRADORAS ";
					}else if(opcionSeleccionada=="2542"){
					    capa.innerHTML="PROCESOS HIDROMETALURGICOS INDUSTRIALES ";
					}else if(opcionSeleccionada=="2543"){
					    capa.innerHTML="PRODUCCION DE HORMIGON EN OBRA ";
					}else if(opcionSeleccionada=="2544"){
					    capa.innerHTML="PRODUCCION DE PLANTAS ";
					}else if(opcionSeleccionada=="2545"){
					    capa.innerHTML="PROGRAMA DE CONSERVACION ";
					}else if(opcionSeleccionada=="2546"){
					    capa.innerHTML="PROGRAMACION DE LOS PROCESOS DE MECANIZADO ";
					}else if(opcionSeleccionada=="2547"){
					    capa.innerHTML="PROGRAMAS SOCIALES Y RECREATIVOS PARA EL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="2548"){
					    capa.innerHTML="PROGRAMAS Y BENEFICIOS SOCIALES ";
					}else if(opcionSeleccionada=="2549"){
					    capa.innerHTML="PROMOCION DE LA SALUD BAJO EL MODELO DE SALUD FAMILIAR ";
					}else if(opcionSeleccionada=="2550"){
					    capa.innerHTML="PROMOCION DE LA SALUD MENTAL Y RELACIONES INTERPERSONALES ";
					}else if(opcionSeleccionada=="2551"){
					    capa.innerHTML="PROPAGACION VEGETAL ";
					}else if(opcionSeleccionada=="2552"){
					    capa.innerHTML="PROPIEDADES DE LA MADERA ";
					}else if(opcionSeleccionada=="2553"){
					    capa.innerHTML="PROPIEDADES Y TRATAMIENTOS DE LA MADERA ";
					}else if(opcionSeleccionada=="2554"){
					    capa.innerHTML="PROTECCIONES HIDRICAS Y DE CUBIERTAS ";
					}else if(opcionSeleccionada=="2555"){
					    capa.innerHTML="PROYECTOS BASICOS DE CARPINTERIA Y MUEBLES ";
					}else if(opcionSeleccionada=="2487"){
					    capa.innerHTML="MONTAJE DE ESTRUCTURAS METALICAS Y HORMIGONES PREFABRICADOS ";
					}else if(opcionSeleccionada=="2488"){
					    capa.innerHTML="MONTAJE DE SISTEMAS DE AISLACION ";
					}else if(opcionSeleccionada=="2489"){
					    capa.innerHTML="MONTAJE DE SISTEMAS ELECTRICOS E INSTRUMENTACION ";
					}else if(opcionSeleccionada=="2490"){
					    capa.innerHTML="MONTAJES Y CONSTRUCCIONES ELECTRICAS ";
					}else if(opcionSeleccionada=="2491"){
					    capa.innerHTML="MOVILIZACION DE CARGA EN PUERTOS Y TERMINALES DE INTERCAMBIO MODAL ";
					}else if(opcionSeleccionada=="2492"){
					    capa.innerHTML="MOVIMIENTO DE TIERRA ";
					}else if(opcionSeleccionada=="2493"){
					    capa.innerHTML="MUESTREO DE SONDAJE ";
					}else if(opcionSeleccionada=="2494"){
					    capa.innerHTML="MUESTREO EN OPERACIONES MINA ";
					}else if(opcionSeleccionada=="2495"){
					    capa.innerHTML="NAVEGACION ";
					}else if(opcionSeleccionada=="2496"){
					    capa.innerHTML="NAVEGACION EN ACTIVIDADES DE ACUICULTURA ";
					}else if(opcionSeleccionada=="2497"){
					    capa.innerHTML="OBRAS CIVILES MENORES ";
					}else if(opcionSeleccionada=="2498"){
					    capa.innerHTML="OBRAS DE ENFIERRADURA ";
					}else if(opcionSeleccionada=="2499"){
					    capa.innerHTML="OPERACION DE APAREJOS Y ARTES DE PESCA ";
					}else if(opcionSeleccionada=="2500"){
					    capa.innerHTML="OPERACION DE EQUIPOS INDUSTRIALES ";
					}else if(opcionSeleccionada=="2501"){
					    capa.innerHTML="OPERACION DE MAQUINARIAS DE NAVES PESQUERAS ";
					}else if(opcionSeleccionada=="2502"){
					    capa.innerHTML="OPERACION DE TRANSPORTE DE FLUIDOS ";
					}else if(opcionSeleccionada=="2503"){
					    capa.innerHTML="OPERACION MECANICA Y DE TRANSFERENCIA ";
					}else if(opcionSeleccionada=="2504"){
					    capa.innerHTML="OPERACION Y MANTENIMIENTO DE SISTEMAS Y EQUIPOS DE CULTIVOS ";
					}else if(opcionSeleccionada=="2505"){
					    capa.innerHTML="OPERACION Y PROGRAMACION DE SISTEMAS DE CONTROL CON CONTROLADORES LOGICOS PROGRAMABLES ";
					}else if(opcionSeleccionada=="2506"){
					    capa.innerHTML="OPERACION, ADMINISTRACION Y MANTENIMIENTO DE REDES DE AREA ";
					}else if(opcionSeleccionada=="2507"){
					    capa.innerHTML="ORGANIZACION DE ACTIVIDADES SOCIALES Y CULTURALES ";
					}else if(opcionSeleccionada=="2508"){
					    capa.innerHTML="ORGANIZACION DE LA ETAPA DE MONTAJE ";
					}else if(opcionSeleccionada=="2509"){
					    capa.innerHTML="ORGANIZACION Y SERVICIOS EN EL SISTEMA PORTUARIO ";
					}else if(opcionSeleccionada=="2510"){
					    capa.innerHTML="ORGANIZACION, ESTRUCTURA, Y FUNCIONAMIENTO DEL SISTEMA DE SALUD CHILENO ";
					}else if(opcionSeleccionada=="2511"){
					    capa.innerHTML="PACIENTE TERMINAL Y SU IMPACTO EN LA FAMILIA ";
					}else if(opcionSeleccionada=="2512"){
					    capa.innerHTML="PANIFICACION INDUSTRIAL ";
					}else if(opcionSeleccionada=="2513"){
					    capa.innerHTML="PAPEL DE DESECHO ";
					}else if(opcionSeleccionada=="2514"){
					    capa.innerHTML="PASTELERIA Y REPOSTERIA ";
					}else if(opcionSeleccionada=="2515"){
					    capa.innerHTML="PAVIMENTOS DE ASFALTO Y CARPETA GRAMULAR ";
					}else if(opcionSeleccionada=="2516"){
					    capa.innerHTML="PAVIMENTOS DE HORMIGON ";
					}else if(opcionSeleccionada=="2517"){
					    capa.innerHTML="PERFORACION DE ROCAS ";
					}else if(opcionSeleccionada=="2518"){
					    capa.innerHTML="PERSPECTIVAS Y SOMBRAS ";
					}else if(opcionSeleccionada=="2519"){
					    capa.innerHTML="PLAGAS Y ENFERMEDADES ";
					}else if(opcionSeleccionada=="2520"){
					    capa.innerHTML="PLANIFICACION DE LA PRODUCCION Y CONTROL DE COSTOS ";
					}else if(opcionSeleccionada=="2452"){
					    capa.innerHTML="MANTENIMIENTO DE LOS SISTEMAS ";
					}else if(opcionSeleccionada=="2453"){
					    capa.innerHTML="MANTENIMIENTO DE LOS SISTEMAS AUXILIARES DEL MOTOR ";
					}else if(opcionSeleccionada=="2454"){
					    capa.innerHTML="MANTENIMIENTO DE LOS SISTEMAS DE DIRECCION Y SUSPENSION ";
					}else if(opcionSeleccionada=="2455"){
					    capa.innerHTML="MANTENIMIENTO DE LOS SISTEMAS DE TRANSMISION Y FRENADO ";
					}else if(opcionSeleccionada=="2456"){
					    capa.innerHTML="MANTENIMIENTO DE MATRICES Y SISTEMAS MECANIZADOS ";
					}else if(opcionSeleccionada=="2457"){
					    capa.innerHTML="MANTENIMIENTO DE MECANICO ";
					}else if(opcionSeleccionada=="2458"){
					    capa.innerHTML="MANTENIMIENTO DE MOTORES ";
					}else if(opcionSeleccionada=="2460"){					
					    capa.innerHTML="MANTENIMIENTO DE SOBREALIMENTADORES DE MOTORES ";
					}else if(opcionSeleccionada=="50014"){
					    capa.innerHTML="Expresion Corporal ";
					}else if(opcionSeleccionada=="2462"){
					    capa.innerHTML="MANTENIMIENTO Y OPERACION DE MAQUINAS Y EQUIPOS ELECTRICOS ";
					}else if(opcionSeleccionada=="2463"){
					    capa.innerHTML="MANTENIMIENTO Y REPARACION DE ARTEFACTOS A GAS ";
					}else if(opcionSeleccionada=="2464"){
					    capa.innerHTML="MANTENIMIENTO Y REPARACION DE RED DE AGUA Y ARTEFACTOS SANITARIOS ";
					}else if(opcionSeleccionada=="2465"){
					    capa.innerHTML="MANTENIMIENTO Y/O MONTAJE DE SISTEMAS DE SEGURIDAD Y CONFORTABILIDAD ";
					}else if(opcionSeleccionada=="2466"){
					    capa.innerHTML="MANTENIMIENTO Y/O REPARACION DE REDES Y CAMARAS DE EVACUACION ";
					}else if(opcionSeleccionada=="2467"){
					    capa.innerHTML="MANTENIMIENTO, OPERACION Y DISENO CON DISPOSITIVOS Y CIRCUITOS ELECTRONICOS DIGITALES ";
					}else if(opcionSeleccionada=="2468"){
					    capa.innerHTML="MAQUETAS ";
					}else if(opcionSeleccionada=="2469"){
					    capa.innerHTML="MAQUINARIA DE NAVES MERCANTES Y ESPECIALES ";
					}else if(opcionSeleccionada=="2470"){
					    capa.innerHTML="MAQUINARIA E IMPLEMENTOS AGRICOLAS ";
					}else if(opcionSeleccionada=="2471"){
					    capa.innerHTML="MAQUINARIAS Y EQUIPOS ";
					}else if(opcionSeleccionada=="2472"){
					    capa.innerHTML="MARKETING Y PUBLICIDAD ";
					}else if(opcionSeleccionada=="2473"){
					    capa.innerHTML="MATERIA PRIMA Y USOS INDUSTRIALES ";
					}else if(opcionSeleccionada=="2474"){
					    capa.innerHTML="MATERIALES ";
					}else if(opcionSeleccionada=="2475"){
					    capa.innerHTML="MATRICES, MOLDES Y UTILES ";
					}else if(opcionSeleccionada=="2476"){
					    capa.innerHTML="MECANIZADO EN CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="2477"){
					    capa.innerHTML="MEDICION Y ANALISIS DE CIRCUITOS ELECTRICOS ";
					}else if(opcionSeleccionada=="2478"){
					    capa.innerHTML="MEDIOAMBIENTE Y TRATAMIENTO DE RESIDUOS ";
					}else if(opcionSeleccionada=="2479"){
					    capa.innerHTML="METEOROLOGIA ";
					}else if(opcionSeleccionada=="2480"){
					    capa.innerHTML="METODOS DE EXPLOTACION Y PROCESOS METALURGICOS ";
					}else if(opcionSeleccionada=="2481"){
					    capa.innerHTML="MINERALES INDUSTRIALES ";
					}else if(opcionSeleccionada=="2482"){
					    capa.innerHTML="MODELAJE Y CORTE DE VESTUARIO INFANTIL ";
					}else if(opcionSeleccionada=="2483"){
					    capa.innerHTML="MODIFICACIONES Y REPARACIONES DE ELEMENTOS INAMOVIBLES Y FIJOS NO ESTRUCTURALES DE UN VEHICULOS ";
					}else if(opcionSeleccionada=="2484"){
					    capa.innerHTML="MOLDAJES INDUSTRIALIZADOS PARA HORMIGONES ";
					}else if(opcionSeleccionada=="2485"){
					    capa.innerHTML="MONTAJE DE DUCTOS Y CANERIAS ";
					}else if(opcionSeleccionada=="2486"){
					    capa.innerHTML="MONTAJE DE EQUIPOS MECANICOS Y DE CALDERERIA ";
					}else if(opcionSeleccionada=="2418"){
					    capa.innerHTML="INSTALACION DE CIRCUITOS ELECTRICOS DE CONTROL AUTOMATICO ";
					}else if(opcionSeleccionada=="2419"){
					    capa.innerHTML="INSTALACION DE CIRCUITOS ELECTRICOS DE FUERZA ";
					}else if(opcionSeleccionada=="2420"){
					    capa.innerHTML="INSTALACION DE FAENAS ";
					}else if(opcionSeleccionada=="2421"){
					    capa.innerHTML="INSTALACION DE REDES DE CANERIAS ";
					}else if(opcionSeleccionada=="2422"){
					    capa.innerHTML="INSTALACION DE REDES DE EVACUACION ";
					}else if(opcionSeleccionada=="2423"){
					    capa.innerHTML="INSTALACION DE UNA RED DE AGUA POTABLE ";
					}else if(opcionSeleccionada=="50015"){
					    capa.innerHTML="GRADO DE AVANCE LENGUAJE Y COMUNICACIÓN ";
					}else if(opcionSeleccionada=="2425"){
					    capa.innerHTML="INSTALACION Y OPERACION DE EQUIPOS Y SISTEMAS DE RADIOCOMUNICACIONES ";
					}else if(opcionSeleccionada=="2426"){
					    capa.innerHTML="INSTALACION Y OPERACION DE EQUIPOS Y SISTEMAS TELEINFORMATICOS ";
					}else if(opcionSeleccionada=="2427"){
					    capa.innerHTML="INSTALACION, OPERACION Y PROGRAMACION DE EQUIPOS Y SISTEMAS TELEFONICOS ";
					}else if(opcionSeleccionada=="2428"){
					    capa.innerHTML="INSTALACIONES DE REDES A GAS ";
					}else if(opcionSeleccionada=="2429"){
					    capa.innerHTML="INSTALACIONES ELECTRICAS I ";
					}else if(opcionSeleccionada=="2430"){
					    capa.innerHTML="INSTRUMENTACION Y CONTROL DE PROCESOS ";
					}else if(opcionSeleccionada=="2431"){
					    capa.innerHTML="INTERPRETACION DE PLANES EN OBRAS VIALES ";
					}else if(opcionSeleccionada=="2432"){
					    capa.innerHTML="INTERPRETACION DE PLANOS EN INSTALACIONES SANITARIAS ";
					}else if(opcionSeleccionada=="2433"){
					    capa.innerHTML="INTERPRETACION DE PLANOS EN MONTAJE INDUSTRIAL ";
					}else if(opcionSeleccionada=="2434"){
					    capa.innerHTML="INTERPRETACION DE PLANOS EN REFRIGERACION Y CLIMATIZACION ";
					}else if(opcionSeleccionada=="2435"){
					    capa.innerHTML="INTERPRETACION DE PLANOS EN TERMINACIONES DE CONSTRUCCION ";
					}else if(opcionSeleccionada=="2436"){
					    capa.innerHTML="INTERPRETACION DE PLANOS Y CUBICACION ";
					}else if(opcionSeleccionada=="2437"){
					    capa.innerHTML="JUNTAS DE HORMIGON ";
					}else if(opcionSeleccionada=="2438"){
					    capa.innerHTML="LEGISLACION FORESTAL Y MEDIO AMBIENTAL ";
					}else if(opcionSeleccionada=="2439"){
					    capa.innerHTML="LEVANTAMIENTOS ";
					}else if(opcionSeleccionada=="2440"){
					    capa.innerHTML="LINEAS DE PROCESOS DE PRODUCTOS MARINOS ";
					}else if(opcionSeleccionada=="2441"){
					    capa.innerHTML="LINEAS DE PROCESOS PESQUEROS ";
					}else if(opcionSeleccionada=="2442"){
					    capa.innerHTML="MANEJO AMBIENTAL EN LA INDUSTRIA MADERERA ";
					}else if(opcionSeleccionada=="2443"){
					    capa.innerHTML="MANEJO DE BODEGA Y PANOLES ";
					}else if(opcionSeleccionada=="2444"){
					    capa.innerHTML="MANEJO DE BOSQUES ";
					}else if(opcionSeleccionada=="2445"){
					    capa.innerHTML="MANEJO DE PRADERAS Y ESPECIES FORRAJERAS ";
					}else if(opcionSeleccionada=="2446"){
					    capa.innerHTML="MANEJO DE STOCK DE MATERIALES E INSUMOS ";
					}else if(opcionSeleccionada=="2447"){
					    capa.innerHTML="MANEJO DEL FUEGO ";
					}else if(opcionSeleccionada=="2448"){
					    capa.innerHTML="MANEJO Y ALMACENAMIENTO DE MATERIALES ";
					}else if(opcionSeleccionada=="2449"){
					    capa.innerHTML="MANIOBRAS Y EQUIPOS DE CUBIERTA ";
					}else if(opcionSeleccionada=="2450"){
					    capa.innerHTML="MANIOBRAS Y EQUIPOS DE EXTRACCION PESQUERA ";
					}else if(opcionSeleccionada=="2451"){
					    capa.innerHTML="MANTENIMIENTO DE EQUIPOS ";
					}else if(opcionSeleccionada=="2384"){
					    capa.innerHTML="ELABORACION Y REMANUFACTURA DE LA MADERA ";
					}else if(opcionSeleccionada=="2385"){
					    capa.innerHTML="ELEMENTOS ADMINISTRATIVOS EN LA ATENCION DE SALUD ";
					}else if(opcionSeleccionada=="2386"){
					    capa.innerHTML="EMBALAJE Y ALMACENAJE DE PRODUCTOS ALIMENTICIOS TERMINADOS ";
					}else if(opcionSeleccionada=="2387"){
					    capa.innerHTML="ENFERMERIA BASICA INTEGRAL PARA EL PACIENTE, FAMILIA Y COMUNIDAD ";
					}else if(opcionSeleccionada=="2388"){
					    capa.innerHTML="ENSAYOS DE LABORATORIO ";
					}else if(opcionSeleccionada=="2389"){
					    capa.innerHTML="EQUIPOS DE NAVEGACION E INSTRUMENTOS ";
					}else if(opcionSeleccionada=="2390"){
					    capa.innerHTML="ESTABLECIMIENTO DE PLANTAS ";
					}else if(opcionSeleccionada=="2391"){
					    capa.innerHTML="ESTRATEGIA DE TRABAJO CON JOVENES ";
					}else if(opcionSeleccionada=="2392"){
					    capa.innerHTML="ESTRIBA Y DESESTIBA DE NAVES MERCANTES ";
					}else if(opcionSeleccionada=="2393"){
					    capa.innerHTML="EXCURSION Y CAMPISMO ";
					}else if(opcionSeleccionada=="2394"){
					    capa.innerHTML="EXPLOTACION DE RECURSOS NO METALICOS ";
					}else if(opcionSeleccionada=="2395"){
					    capa.innerHTML="EXPRESION CORPORAL Y TEATRAL ";
					}else if(opcionSeleccionada=="2396"){
					    capa.innerHTML="FABRICACION E INSTALACION DE REDES DE DUCTOS ";
					}else if(opcionSeleccionada=="2397"){
					    capa.innerHTML="FACTORES DE LA PRODUCCION VEGETAL ";
					}else if(opcionSeleccionada=="2398"){
					    capa.innerHTML="FAENAMIENTO Y PROCESAMIENTO DE CARNES ";
					}else if(opcionSeleccionada=="2399"){
					    capa.innerHTML="FISICA DE PAPEL ";
					}else if(opcionSeleccionada=="2400"){
					    capa.innerHTML="FORMACION DE LA HOJA ";
					}else if(opcionSeleccionada=="2401"){
					    capa.innerHTML="FORTIFICACION DE MINAS ";
					}else if(opcionSeleccionada=="2402"){
					    capa.innerHTML="FRUTALES DE HOJA PERENNE ";
					}else if(opcionSeleccionada=="2403"){
					    capa.innerHTML="GESTION ADMINISTRATIVA Y DE ARCHIVOS ";
					}else if(opcionSeleccionada=="2404"){
					    capa.innerHTML="GESTION DE COMERCIO EXTERIOR ";
					}else if(opcionSeleccionada=="2405"){
					    capa.innerHTML="GESTION DE LA CALIDAD EN CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="2406"){
					    capa.innerHTML="GESTION DE MANTENIMIENTO ";
					}else if(opcionSeleccionada=="2407"){
					    capa.innerHTML="GESTION DEL AGROECOSISTEMA ";
					}else if(opcionSeleccionada=="2408"){
					    capa.innerHTML="GESTION EN APROVISIONAMIENTO ";
					}else if(opcionSeleccionada=="2409"){
					    capa.innerHTML="GESTION EN MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="2410"){
					    capa.innerHTML="GESTION EN RECURSOS HUMANOS ";
					}else if(opcionSeleccionada=="2411"){
					    capa.innerHTML="GESTION SEGURA Y DE CALIDAD EN PLANTAS DE PROCESAMIENTO DE MINERALES ";
					}else if(opcionSeleccionada=="2412"){
					    capa.innerHTML="GRASAS, FIBRAS Y GLUCIDOS ";
					}else if(opcionSeleccionada=="2413"){
					    capa.innerHTML="HIGIENE DEL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="2414"){
					    capa.innerHTML="HORMIGONES PREMEZCLADOS ";
					}else if(opcionSeleccionada=="2415"){
					    capa.innerHTML="INFORMATICA I ";
					}else if(opcionSeleccionada=="2416"){
					    capa.innerHTML="INFORMES FINANCIEROS ";
					}else if(opcionSeleccionada=="2417"){
					    capa.innerHTML="INSTALACION DE ARTEFACTOS SANITARIOS ";
					}else if(opcionSeleccionada=="2349"){
					    capa.innerHTML="CONTROL DE CALIDAD DE PRODUCTOS MECANIZADOS ";
					}else if(opcionSeleccionada=="2350"){
					    capa.innerHTML="CONTROL DE PRODUCTOS MECANIZADOS ";
					}else if(opcionSeleccionada=="2351"){
					    capa.innerHTML="COSECHA DE BOSQUES ";
					}else if(opcionSeleccionada=="2352"){
					    capa.innerHTML="CUBICACION Y COSTOS DE MATERIALES ";
					}else if(opcionSeleccionada=="2353"){
					    capa.innerHTML="CUIDADOS DE ENFERMERIA DEL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="2354"){
					    capa.innerHTML="CULTIVOS DE ALGAS ";
					}else if(opcionSeleccionada=="2355"){
					    capa.innerHTML="CULTIVOS DE CRUSTACEOS ";
					}else if(opcionSeleccionada=="2356"){
					    capa.innerHTML="CULTIVOS DE MOLUSCOS ";
					}else if(opcionSeleccionada=="2357"){
					    capa.innerHTML="CULTIVOS DE PECES ";
					}else if(opcionSeleccionada=="2358"){
					    capa.innerHTML="CULTIVOS FORZADOS ";
					}else if(opcionSeleccionada=="2360"){
					    capa.innerHTML="DEPORTE HANDBOL ";
					}else if(opcionSeleccionada=="2361"){
					    capa.innerHTML="DESARROLLO DE PROYECTOS DE CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="2362"){
					    capa.innerHTML="DIBUJO DE INSTALACIONES DE REDES INTERIORES ";
					}else if(opcionSeleccionada=="2363"){
					    capa.innerHTML="DIBUJO MANUAL DE PLANOS DEFINITIVOS ";
					}else if(opcionSeleccionada=="2364"){
					    capa.innerHTML="DIBUJO MANUAL DE PLANTILLAS ARQUITECTONICAS Y ELEMENTOS MECANICOS ";
					}else if(opcionSeleccionada=="2365"){
					    capa.innerHTML="DIBUJO MANUAL DE PLANTILLAS DE DETALLES ESTRUCTURALES Y CONJUNTOS MECANICOS ";
					}else if(opcionSeleccionada=="2366"){
					    capa.innerHTML="DIBUJO TECNICO EN PROCESAMIENTO DE LA MADERA ";
					}else if(opcionSeleccionada=="2367"){
					    capa.innerHTML="DIBUJO TECNICO EN PRODUCTOS DE LA MADERA ";
					}else if(opcionSeleccionada=="2368"){
					    capa.innerHTML="DIBUJOS DE PLANOS ASISTIDOS POR COMPUTACION ";
					}else if(opcionSeleccionada=="2369"){
					    capa.innerHTML="DIMENSIONAMIENTO Y CONSTRUCCION DE SISTEMAS DE CULTIVO ";
					}else if(opcionSeleccionada=="2370"){
					    capa.innerHTML="DISENO Y TEJIDO DE PUNTO CIRCULAR ";
					}else if(opcionSeleccionada=="2371"){
					    capa.innerHTML="DISENO Y TEJIDO DE PUNTO RECTILINEO ";
					}else if(opcionSeleccionada=="2372"){
					    capa.innerHTML="DOCUMENTACION EN LA OPERACION PORTUARIA ";
					}else if(opcionSeleccionada=="2373"){
					    capa.innerHTML="ECOLOGIA FORESTAL ";
					}else if(opcionSeleccionada=="2374"){
					    capa.innerHTML="ELABORACION DE BEBIDAS ALCOHOLICAS Y ANALCOHOLICAS ";
					}else if(opcionSeleccionada=="2375"){
					    capa.innerHTML="ELABORACION DE CECINAS ";
					}else if(opcionSeleccionada=="2376"){
					    capa.innerHTML="ELABORACION DE COMPONENTES DE CARPINTERIA Y MUEBLES ";
					}else if(opcionSeleccionada=="2377"){
					    capa.innerHTML="ELABORACION DE ENTRADAS FRIAS Y CALIENTES ";
					}else if(opcionSeleccionada=="2378"){
					    capa.innerHTML="ELABORACION DE PLATOS TIPICOS NACIONALES E INTERNACIONALES ";
					}else if(opcionSeleccionada=="2379"){
					    capa.innerHTML="ELABORACION DE PRODUCTOS DEL MAR ";
					}else if(opcionSeleccionada=="2380"){
					    capa.innerHTML="ELABORACION DE PRODUCTOS HORTOFRUTICOLAS ";
					}else if(opcionSeleccionada=="2381"){
					    capa.innerHTML="ELABORACION DE PRODUCTOS LACTEOS ";
					}else if(opcionSeleccionada=="2382"){
					    capa.innerHTML="ELABORACION DE PROYECTOS SOCIALES Y CULTURALES ";
					}else if(opcionSeleccionada=="2383"){
					    capa.innerHTML="ELABORACION SEMINDUSTRIAL ";
					}else if(opcionSeleccionada=="2315"){
					    capa.innerHTML="APOYO A LEVANTAMIENTO TOPOGRAFICO ";
					}else if(opcionSeleccionada=="2316"){
					    capa.innerHTML="APOYO EMOCIONAL, SOCIAL Y ESPIRITUAL AL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="2317"){
					    capa.innerHTML="APOYO EN LEVANTAMIENTO TOPOGRAFICO ";
					}else if(opcionSeleccionada=="2318"){
					    capa.innerHTML="AREAS SILVESTRES Y SU MANEJO ";
					}else if(opcionSeleccionada=="2319"){
					    capa.innerHTML="ARMADO DE ELEMENTOS Y CONJUNTOS ";
					}else if(opcionSeleccionada=="2320"){
					    capa.innerHTML="ARMADO, MANTENIMIENTO Y OPERACION DE COMPUTADORES PERSONALES ";
					}else if(opcionSeleccionada=="2321"){
					    capa.innerHTML="ASEGURAMIENTO DE LA CALIDAD ";
					}else if(opcionSeleccionada=="2322"){
					    capa.innerHTML="ASERRADO ";
					}else if(opcionSeleccionada=="2323"){
					    capa.innerHTML="ATENCION A LA FAMILIA DEL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="2324"){
					    capa.innerHTML="ATENCION DE ENFERMERIA BASICA DERIVADA DEL DIAGNOSTICO Y TRATAMIENTO MEDICO ";
					}else if(opcionSeleccionada=="2325"){
					    capa.innerHTML="AUTOMATIZACION INDUSTRIAL ";
					}else if(opcionSeleccionada=="2326"){
					    capa.innerHTML="AUTOMATIZACION INDUSTRIAL DE LA MATRICERIA ";
					}else if(opcionSeleccionada=="2327"){
					    capa.innerHTML="BLANQUEO DE PULPA QUIMICA Y PULPA DE ALTO RENDIMIENTO ";
					}else if(opcionSeleccionada=="2328"){
					    capa.innerHTML="CALIDAD ";
					}else if(opcionSeleccionada=="2329"){
					    capa.innerHTML="CALIDAD DE CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="2330"){
					    capa.innerHTML="CAPTACION Y TRATAMIENTO DE AGUAS ";
					}else if(opcionSeleccionada=="2331"){
					    capa.innerHTML="CARGUIO Y TRANSPORTE ";
					}else if(opcionSeleccionada=="2332"){
					    capa.innerHTML="CARPINTERIA DE MUEBLES DE COCINA, CLOSET Y BANOS ";
					}else if(opcionSeleccionada=="2333"){
					    capa.innerHTML="CARPINTERIA DE TECHUMBRES, TABIQUERIA Y SUPERFICIES DE TRABAJO";
					}else if(opcionSeleccionada=="2334"){
					    capa.innerHTML="CARPINTERIA DE TERMINACIONES EN ALUMINIO ";
					}else if(opcionSeleccionada=="2335"){
					    capa.innerHTML="CARPINTERIA DE TRAZADO, REPLANTEO Y MOLDAJES DE OBRA ";
					}else if(opcionSeleccionada=="2336"){
					    capa.innerHTML="CARTOGRAFIA Y DIBUJO GEOLOGICO ";
					}else if(opcionSeleccionada=="2337"){
					    capa.innerHTML="CHANCADO PRIMARIO DE MINERALES ";
					}else if(opcionSeleccionada=="2338"){
					    capa.innerHTML="CIRCUITOS ELECTRICOS AUXILIARES DE VEHICULOS Y MANTENIMIENTO DE LOS SISTEMAS ELECTRICOS Y ELECTRONICOS AUXILIARES DEL VEHICULO ";
					}else if(opcionSeleccionada=="2339"){
					    capa.innerHTML="CIRCUITOS ELECTROTECNICOS BASICOS Y MANTENIMIENTO DE LOS SISTEMAS DE CARGA Y DE ARRANQUE DE VEHICULO ";
					}else if(opcionSeleccionada=="2340"){
					    capa.innerHTML="CLASES DE PAPEL ";
					
					}else if(opcionSeleccionada=="2341"){
					    capa.innerHTML="CLASIFICACION DE PUERTOS Y TERMINALES DE INTERCAMBIO MODAL ";
					}else if(opcionSeleccionada=="2342"){
					    capa.innerHTML="COMBATE DE INCENDIOS ";
					}else if(opcionSeleccionada=="2343"){
					    capa.innerHTML="COMERCIO ELECTRONICO ";
					}else if(opcionSeleccionada=="2344"){
					    capa.innerHTML="CONFORMADO EN CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="2345"){
					    capa.innerHTML="CONFORMADO Y MECANIZADO AVANZADO DE PIEZAS ";
					}else if(opcionSeleccionada=="2346"){
					    capa.innerHTML="CONSOLIDACION Y DESCONSOLIDACION DE CONTENEDORES ";
					}else if(opcionSeleccionada=="2347"){
					    capa.innerHTML="CONSTRUCCION Y ARMADO DE APAREJOS Y ARTES DE PESCA ";
					}else if(opcionSeleccionada=="2348"){
					    capa.innerHTML="CONTABILIDAD BASICA Y VERIFICACION DE EXISTENCIA ";
					}else if(opcionSeleccionada=="2281"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION CASTELLANO ";
					}else if(opcionSeleccionada=="2282"){
					    capa.innerHTML="FRANCES Y ALEMAN ";
					}else if(opcionSeleccionada=="2283"){
					    capa.innerHTML="ALGEBRA Y MATEMATICA ANALITICA ";
					}else if(opcionSeleccionada=="2284"){
					    capa.innerHTML="BIOLOGIA ELECTIVA ";
					}else if(opcionSeleccionada=="2285"){
					    capa.innerHTML="ESPANOL ";
					}else if(opcionSeleccionada=="2286"){
					    capa.innerHTML="ESTUDIOS MATEMATICOS ";
					}else if(opcionSeleccionada=="50007"){
					    capa.innerHTML="ESCRITURA ";
					}else if(opcionSeleccionada=="2288"){
					    capa.innerHTML="EXPRESION CORPORAL Y RECREACION ";
					}else if(opcionSeleccionada=="2289"){
					    capa.innerHTML="LA HISTORIA Y LAS CIENCIAS SOCIALES:SUS OBJETIVOS Y CAMPOS LABORALES ";
					}else if(opcionSeleccionada=="2290"){
					    capa.innerHTML="ABASTECIMIENTO Y DESPACHO ";
					}else if(opcionSeleccionada=="2291"){
					    capa.innerHTML="ACTIVIDADES CON LA FAMILIA ";
					}else if(opcionSeleccionada=="2292"){
					    capa.innerHTML="ACTIVIDADES DE APOYO A LA RECREACION DEL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="2293"){
					    capa.innerHTML="ACTIVIDADES DE EXPRESION CON PARVULOS ";
					}else if(opcionSeleccionada=="2294"){
					    capa.innerHTML="ACTIVIDADES DEPORTIVAS ";
					}else if(opcionSeleccionada=="2295"){
					    capa.innerHTML="ACTIVIDADES EDUCATIVAS CON PARVULOS EN SITUACION DE RIESGO SOCIAL ";					
					}else if(opcionSeleccionada=="2296"){
					    capa.innerHTML="ACTIVIDADES EDUCATIVAS PARA TRABAJOS CON PARVULOS ";
					}else if(opcionSeleccionada=="2297"){
					    capa.innerHTML="ACTIVIDADES MUSICALES CON GUITARRA ";
					}else if(opcionSeleccionada=="2298"){
					    capa.innerHTML="ACTIVIDADES RECREATIVAS PARA PARVULOS ";
					}else if(opcionSeleccionada=="2299"){
					    capa.innerHTML="ADITIVOS DE PAPEL ";
					}else if(opcionSeleccionada=="2300"){
					    capa.innerHTML="ADITIVOS PARA MORTEROS Y HORMIGONES ";
					}else if(opcionSeleccionada=="2301"){
					    capa.innerHTML="ADMINISTRACION DE BODEGA EN MONTAJE INDUSTRIAL ";
					}else if(opcionSeleccionada=="2302"){
					    capa.innerHTML="ADMINISTRACION DE FLOTAS PESQUERAS ";
					}else if(opcionSeleccionada=="2303"){
					    capa.innerHTML="ADMINISTRACION DE MEDICAMENTOS ";
					}else if(opcionSeleccionada=="2304"){
					    capa.innerHTML="ALBAÑILERIA ";
					}else if(opcionSeleccionada=="2305"){
					    capa.innerHTML="ALIMENTACION DEL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="2306"){
					    capa.innerHTML="ALIMENTOS: HUMEDAD, CENIZAS Y PROTEINAS ";
					}else if(opcionSeleccionada=="2307"){
					    capa.innerHTML="ALMACENAMIENTO DE CARGA EN ZONAS DE DEPOSITO ";
					}else if(opcionSeleccionada=="2308"){
					    capa.innerHTML="ANALISIS DE AGUA ";
					}else if(opcionSeleccionada=="2309"){
					    capa.innerHTML="ANALISIS DE COMPUESTOS ORGANICOS ";
					}else if(opcionSeleccionada=="2310"){
					    capa.innerHTML="ANALISIS FISICO DE LOS PRODUCTOS TEXTILES I ";
					}else if(opcionSeleccionada=="2311"){
					    capa.innerHTML="ANALISIS FISICO Y FISIOQUIMICO DE MUESTRAS ";
					}else if(opcionSeleccionada=="2312"){
					    capa.innerHTML="ANALISIS GRANULOMETRICO Y PREPARACION DE MUESTRA FINA ";
					}else if(opcionSeleccionada=="2313"){
					    capa.innerHTML="ANALISIS QUIMICO INORGANICO ";
					}else if(opcionSeleccionada=="2314"){
					    capa.innerHTML="APLICACION DE SOFTWARE BASICOS ";
					}else if(opcionSeleccionada=="2247"){
					    capa.innerHTML="ALIMENTACION, HIGIENE Y SALUD EN PARVULOS ";
					}else if(opcionSeleccionada=="2248"){
					    capa.innerHTML="ANALISIS DE LAS EXPERIENCIAS EN TERRENO ";
					}else if(opcionSeleccionada=="2249"){
					    capa.innerHTML="APLICACIONES INFORMATICAS ";
					}else if(opcionSeleccionada=="2250"){
					    capa.innerHTML="COSTOS Y ESTADOS DE RESULTADOS ";
					}else if(opcionSeleccionada=="2251"){
					    capa.innerHTML="GESTION DE APROVISIONAMIENTO ";
					}else if(opcionSeleccionada=="2252"){
					    capa.innerHTML="GESTION EN COMPRAVENTAS ";
					}else if(opcionSeleccionada=="2253"){
					    capa.innerHTML="PROYECTOS Y CONSTRUCCIONES ELECTRONICAS ";
					}else if(opcionSeleccionada=="2254"){
					    capa.innerHTML="ELECTRONICOS ";
					}else if(opcionSeleccionada=="2255"){
					    capa.innerHTML="MANTENIMIENTO,OPERACION Y DISENO CON DISPOSITIVOS Y CIRCUITOS ELECTRONICOS ";
					}else if(opcionSeleccionada=="2256"){
					    capa.innerHTML="ATENCION DE MENORES ";
					}else if(opcionSeleccionada=="2257"){
					    capa.innerHTML="CONSTRUCCION HABITACIONAL ";
					}else if(opcionSeleccionada=="2258"){
					    capa.innerHTML="MATERIAL DIDACTICO Y DECORATIVO ";
					}else if(opcionSeleccionada=="2259"){
					    capa.innerHTML="MEDICION Y ANALISIS DE COMPONENTES Y CIRCUITOS ELECTRONICOS ";
					}else if(opcionSeleccionada=="2260"){
					    capa.innerHTML="AUDIOVISUALES: FOTOGRAFIA, DIAPORAMA, VIDEO, CINE ";
					}else if(opcionSeleccionada=="2261"){
					    capa.innerHTML="COMPOSICION MUSICAL ";
					}else if(opcionSeleccionada=="2262"){
					    capa.innerHTML="ORIGEN E HISTORIA DE LA QUIMICA ";
					}else if(opcionSeleccionada=="2263"){
					    capa.innerHTML="INGLES (SOCIAL Y COMUNICATIVO) ";
					}else if(opcionSeleccionada=="50008"){
					    capa.innerHTML="EXPRESION ORAL ";
					}else if(opcionSeleccionada=="2265"){
					    capa.innerHTML="LITERATURA E IDENTIDAD ";
					}else if(opcionSeleccionada=="2266"){
					    capa.innerHTML="CELULA, GENOMA Y ORGANISMO ";
					}else if(opcionSeleccionada=="2267"){
					    capa.innerHTML="INDIVIDUO Y SOCIEDAD ";
					}else if(opcionSeleccionada=="2268"){
					    capa.innerHTML="ESTUDIO DEL HOMBRE ";
					}else if(opcionSeleccionada=="2269"){
					    capa.innerHTML="CIENCIAS EXPERIMENTALES ";
					}else if(opcionSeleccionada=="2270"){
					    capa.innerHTML="LITERATURA UNIVERSAL E HISPANOAMERICANA ";
					}else if(opcionSeleccionada=="2271"){
					    capa.innerHTML="BIOLOGIA INTENSIVA ";
					}else if(opcionSeleccionada=="2272"){
					    capa.innerHTML="QUIMICA INTENSIVA ";
					}else if(opcionSeleccionada=="2273"){
					    capa.innerHTML="FISICA INTENSIVA ";
					}else if(opcionSeleccionada=="2274"){
					    capa.innerHTML="LENGUAJE ALGEBRAICO Y LOGICA ";
					}else if(opcionSeleccionada=="2275"){
					    capa.innerHTML="GEOMETRIA ANALITICA Y TRIGONOMETRIA ";
					}else if(opcionSeleccionada=="2276"){
					    capa.innerHTML="ARTE LITERARIO, CREACION E HISTORIA DEL ARTE ";
					}else if(opcionSeleccionada=="2277"){
					    capa.innerHTML="ARTE Y ENTORNO CULTURAL ";
					}else if(opcionSeleccionada=="2278"){
					    capa.innerHTML="ESTETICA Y DISENO URBANISTICO ";
					}else if(opcionSeleccionada=="2279"){
					    capa.innerHTML="ELECTIVO DEL AREA ";
					}else if(opcionSeleccionada=="2280"){
					    capa.innerHTML="HISTORIA, GEOGRAFIA Y CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="2213"){
					    capa.innerHTML="SECRETARIADO Y RELACIONES PUBLICAS ";
					}else if(opcionSeleccionada=="2214"){
					    capa.innerHTML="LA CIUDAD CONTEMPORANEA ";
					}else if(opcionSeleccionada=="2215"){
					    capa.innerHTML="GESTION EN COMERCIO EXTERIOR ";
					}else if(opcionSeleccionada=="27"){
					    capa.innerHTML="LENGUA CASTELLANA Y COMUNICACION ";
					}else if(opcionSeleccionada=="50016"){
					    capa.innerHTML="Taller de Lenguaje ";
					}else if(opcionSeleccionada=="2218"){
					    capa.innerHTML="HISTORIA POLITICA,ECONOMICA Y SOCIAL DEL SIGLO XX ";
					}else if(opcionSeleccionada=="2219"){
					    capa.innerHTML="LA CULTURA CHILENA Y SU PROYECCION VALORICA ";
					}else if(opcionSeleccionada=="2220"){
					    capa.innerHTML="FORMACION DIFERENCIADA ";
					}else if(opcionSeleccionada=="2221"){
					    capa.innerHTML="BODEGA, RECEPCIÓN Y ALMACENAJE DE LOS ALIMENTOS ";
					}else if(opcionSeleccionada=="2222"){
					    capa.innerHTML="TECNICAS DE ELABORACION DE ENTRADAS FRIAS Y CALIENTES ";
					}else if(opcionSeleccionada=="2223"){
					    capa.innerHTML="TECNICAS DE PANADERIA ";
					}else if(opcionSeleccionada=="2224"){
					    capa.innerHTML="TECNICAS DE PREPARACION DE SANDWICH Y PRODUCTOS PARA COKTAIL ";
					}else if(opcionSeleccionada=="2225"){
					    capa.innerHTML="TECNICAS DE PROGRAMACION DE ALIMENTOS ";
					}else if(opcionSeleccionada=="2226"){
					    capa.innerHTML="PLATOS REPRESENTATIVOS DE LA COMIDA ETNICA ";
					}else if(opcionSeleccionada=="2227"){
					    capa.innerHTML="ENTRENAMIENTO DE LA CONDICION FISICA ";
					}else if(opcionSeleccionada=="2228"){
					    capa.innerHTML="MANTENIMIENTO DE LOS SISTEMAS Y CIRCUITOS DE CARGA, ARRANQUE, ELECTRONICOS, ELECTROTECNICOS,ELECTRONICOS DEL VEHICULO ";
					}else if(opcionSeleccionada=="2229"){
					    capa.innerHTML="DISENO, OPERACION Y MANTENCION DE SISTEMAS DE CONTROL ELECTRICO ";
					}else if(opcionSeleccionada=="2230"){
					    capa.innerHTML="MEDICION Y ANALISIS DE CIRCUITOS ELECTRONICOS ";
					}else if(opcionSeleccionada=="2232"){
					    capa.innerHTML="ACTUACION TEATRAL ";
					}else if(opcionSeleccionada=="2233"){
					    capa.innerHTML="HISTORIA DE LOS ESTADOS UNIDOS ";
					}else if(opcionSeleccionada=="2234"){
					    capa.innerHTML="TEORIA DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="2235"){
					    capa.innerHTML="BIO-FISICA ";
					}else if(opcionSeleccionada=="2236"){
					    capa.innerHTML="MORAL DE LA VIDA ";
					}else if(opcionSeleccionada=="2237"){
					    capa.innerHTML="INGLES I ";
					}else if(opcionSeleccionada=="2238"){
					    capa.innerHTML="ANALISIS CRISIS DE MODERNIDAD EN OCCIDENTE ";
					}else if(opcionSeleccionada=="2239"){
					    capa.innerHTML="HISTORIA DE OCCIDENTE IV ";
					}else if(opcionSeleccionada=="2240"){
					    capa.innerHTML="ANALISIS PROBLEMAS SOCIALES CONTEMPORANEOS ";
					}else if(opcionSeleccionada=="2241"){
					    capa.innerHTML="ANALISIS CRISIS HISTORICA DE OCCIDENTE ";
					}else if(opcionSeleccionada=="2242"){
					    capa.innerHTML="PARTICIPACION EN EDUCACION FISICA ";
					}else if(opcionSeleccionada=="2243"){
					    capa.innerHTML="ATENCION DE PARVULOS ";
					}else if(opcionSeleccionada=="2244"){
					    capa.innerHTML="ADMINISTRACION DE RECURSOS COMPUTACIONALES ";
					}else if(opcionSeleccionada=="2245"){
					    capa.innerHTML="ACTIVIDADES MUSICALES EN GUITARRA ";
					}else if(opcionSeleccionada=="2246"){
					    capa.innerHTML="TECNICAS DE MECANIZADO, MANTENIMIENTO DE LOS SISTEMAS DE SEGURIDAD Y CONFORTABILIDAD DEL VEHICULO ";
					}else if(opcionSeleccionada=="2179"){
					    capa.innerHTML="ADMINISTRACION DE EMPRESAS Y LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="2180"){
					    capa.innerHTML="INICIACION DEPORTIVA ";
					}else if(opcionSeleccionada=="2181"){
					    capa.innerHTML="MANTENCION ";
					}else if(opcionSeleccionada=="2182"){
					    capa.innerHTML="JUEGOS LOGICOS ";
					}else if(opcionSeleccionada=="2183"){
					    capa.innerHTML="INTRODUCCION AL ELECTROMAGNETISMO ";
					}else if(opcionSeleccionada=="2184"){
					    capa.innerHTML="NOCIONES DE ORGANIZACION ";
					}else if(opcionSeleccionada=="2185"){
					    capa.innerHTML="CONSERVERIA ";
					}else if(opcionSeleccionada=="2186"){
					    capa.innerHTML="INTEGRACION LATINOAMERICANA ";
					}else if(opcionSeleccionada=="2187"){
					    capa.innerHTML="ADMINISTRACION DE FINANZAS Y DE PERSONAL ";
					}else if(opcionSeleccionada=="2188"){
					    capa.innerHTML="CONCEPTO DE DESARROLLO DE SISTEMAS ";
					}else if(opcionSeleccionada=="2189"){
					    capa.innerHTML="PROYECCION DEL DESARROLLO DE LA COMPUTACION ";
					}else if(opcionSeleccionada=="2190"){
					    capa.innerHTML="PROBLEMAS LIMITROFES Y CONFLICTOS INTERNOS DE CHILE ";
					}else if(opcionSeleccionada=="2191"){
					    capa.innerHTML="ELECTROTECNIA Y TECNOLOGIA ";
					}else if(opcionSeleccionada=="2192"){
					    capa.innerHTML="TALLER DE GRAFICA ";
					}else if(opcionSeleccionada=="2193"){
					    capa.innerHTML="ELABORACION DE DOCUMENTOS ";
					}else if(opcionSeleccionada=="2194"){
					    capa.innerHTML="DISENO COMPUTACIONAL ";
					}else if(opcionSeleccionada=="2195"){
					    capa.innerHTML="LABORATORIO DE GRAFICA ";
					}else if(opcionSeleccionada=="2196"){
					    capa.innerHTML="LENGUA EXTRANJERA ";
					}else if(opcionSeleccionada=="28"){
					    capa.innerHTML="ARTES VISUALES ";
					}else if(opcionSeleccionada=="50009"){
					    capa.innerHTML="DEPORTE ";
					}else if(opcionSeleccionada=="2200"){
					    capa.innerHTML="PROBLEMAS DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="2201"){
					    capa.innerHTML="DISENO MULTIPLE ";
					}else if(opcionSeleccionada=="2202"){
					    capa.innerHTML="MULTITALLER DE GRAFICA, PINTURA Y ESCULTURA ";
					}else if(opcionSeleccionada=="2203"){
					    capa.innerHTML="DISENO ARQUITECTONICO ";
					}else if(opcionSeleccionada=="2204"){
					    capa.innerHTML="COMUNICACION ORGANIZACIONAL ";
					}else if(opcionSeleccionada=="2205"){
					    capa.innerHTML="GESTION DE DATOS Y ARCHIVOS ";
					}else if(opcionSeleccionada=="2206"){
					    capa.innerHTML="GESTION EN COMPRA Y VENTA ";
					}else if(opcionSeleccionada=="2207"){
					    capa.innerHTML="GESTION FORMATIVA DEL VENDEDOR ";
					}else if(opcionSeleccionada=="2208"){
					    capa.innerHTML="GESTION PEQUENA EMPRESA ";
					}else if(opcionSeleccionada=="2209"){
					    capa.innerHTML="NORMATIVA LABORAL Y PREVISIONAL ";
					}else if(opcionSeleccionada=="2210"){
					    capa.innerHTML="NORMATIVA COMERCIAL Y TRIBUTARIA ";
					}else if(opcionSeleccionada=="2211"){
					    capa.innerHTML="REDACCION Y APLICACION INFORMATICA ";
					}else if(opcionSeleccionada=="2212"){
					    capa.innerHTML="APLICACION INFORMATICA ";
					}else if(opcionSeleccionada=="2145"){
					    capa.innerHTML="RELIGION Y MORAL ";
					}else if(opcionSeleccionada=="2146"){
					    capa.innerHTML="EXPRESION RITMICA DEPORTIVA ";
					}else if(opcionSeleccionada=="2147"){
					    capa.innerHTML="EDUCACION DEL MOVIMIENTO DEPORTE Y RECREACION ";
					}else if(opcionSeleccionada=="2148"){
					    capa.innerHTML="EL HOMBRE Y SU ENTORNO NATURAL ";
					}else if(opcionSeleccionada=="2149"){
					    capa.innerHTML="ESTUDIO DE LA SOCIEDAD ";
					}else if(opcionSeleccionada=="2150"){
					    capa.innerHTML="TALLER DE MANUALIDADES ";
					}else if(opcionSeleccionada=="2151"){
					    capa.innerHTML="COMPUTACION Y PROGRAMACION ";
					}else if(opcionSeleccionada=="2152"){
					    capa.innerHTML="COMPUTACION LABORATORIO ";
					}else if(opcionSeleccionada=="2153"){
					    capa.innerHTML="FUNDAMENTOS DE BIENESTAR SOCIAL ";
					}else if(opcionSeleccionada=="2154"){
					    capa.innerHTML="LABORATORIO Y TECNOLOGIA ";
					}else if(opcionSeleccionada=="2155"){
					    capa.innerHTML="DISENO DE VESTUARIO ";
					}else if(opcionSeleccionada=="2156"){
					    capa.innerHTML="UTILITARIOS Y SOFTWARE DE USO GENERALIZADO ";
					}else if(opcionSeleccionada=="2157"){
					    capa.innerHTML="ORIENTACION LABORAL ";
					}else if(opcionSeleccionada=="2158"){
					    capa.innerHTML="INGLES TECNICO EN LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="2159"){
					    capa.innerHTML="PSICOLOGIA GENERAL Y EVOLUTIVA ";
					}else if(opcionSeleccionada=="2160"){
					    capa.innerHTML="PUERICULTURA Y NUTRICION ";
					}else if(opcionSeleccionada=="2161"){
					    capa.innerHTML="EXPRESION MUSICAL INFANTIL ";
					}else if(opcionSeleccionada=="2162"){
					    capa.innerHTML="RECREACION Y APRENDIZAJE ";
					}else if(opcionSeleccionada=="2163"){
					    capa.innerHTML="PRACTICA DE ALIMENTACION ";
					}else if(opcionSeleccionada=="2164"){
					    capa.innerHTML="ADMINISTRACION DE CASINOS ";
					}else if(opcionSeleccionada=="2165"){
					    capa.innerHTML="LEGISLACION LABORAL Y SANITARIA ";
					}else if(opcionSeleccionada=="2166"){
					    capa.innerHTML="FISICO QUIMICA ";
					}else if(opcionSeleccionada=="2167"){
					    capa.innerHTML="LABORATORIO DE FISICO QUIMICA ";
					}else if(opcionSeleccionada=="2168"){
					    capa.innerHTML="AUDITORIA INTERNA ";
					}else if(opcionSeleccionada=="2169"){
					    capa.innerHTML="PROYECTO ELECTRICO ";
					}else if(opcionSeleccionada=="2170"){
					    capa.innerHTML="PROYECTO E INTERPRETACION DE PLANOS ";
					}else if(opcionSeleccionada=="2171"){
					    capa.innerHTML="APLICACIONES DE SISTEMAS COMPUTACIONALES ";
					}else if(opcionSeleccionada=="2172"){
					    capa.innerHTML="CURRICULUM Y EVALUACION DE EDUCACION PARVULARIA ";
					}else if(opcionSeleccionada=="2173"){
					    capa.innerHTML="PROGRAMACION DE COMPUTADORAS ";
					}else if(opcionSeleccionada=="2174"){
					    capa.innerHTML="SISTEMAS INFORMATICOS ";
					}else if(opcionSeleccionada=="2175"){
					    capa.innerHTML="APLICACION DE SISTEMAS COMPUTACIONALES ";
					}else if(opcionSeleccionada=="2176"){
					    capa.innerHTML="NOCIONES DE CONTABILIDAD Y ECONOMIA ";
					}else if(opcionSeleccionada=="2177"){
					    capa.innerHTML="INTRODUCCION A LA VIDA LABORAL ";
					}else if(opcionSeleccionada=="2178"){
					    capa.innerHTML="ADMINISTRACION DE EMPRESAS Y LEGISLACION ";
					}else if(opcionSeleccionada=="2111"){
					    capa.innerHTML="INTRODUCCION AL USO DEL COMPUTADOR ";
					}else if(opcionSeleccionada=="2112"){
					    capa.innerHTML="INTRODUCCION A LAS CIENCIAS Y TECNOLOGIAS DEL MEDIO ACUATICO ";
					}else if(opcionSeleccionada=="2113"){
					    capa.innerHTML="INTRODUCCION A LAS TECNOLOGIAS DE ALIMENTOS ";
					}else if(opcionSeleccionada=="2114"){
					    capa.innerHTML="EMPRESA Y MOVIMIENTO MERCANTIL ";
					}else if(opcionSeleccionada=="2115"){
					    capa.innerHTML="DACTILOGRAFIA Y DIGITACION COMPUTACIONAL ";
					}else if(opcionSeleccionada=="2116"){
					    capa.innerHTML="TALLER CULTURAL Y DE EXTENSION ";
					}else if(opcionSeleccionada=="2117"){
					    capa.innerHTML="TALLER DE ACERCAMIENTO A LA EMPRESA ";
					}else if(opcionSeleccionada=="2118"){
					    capa.innerHTML="EL RECURSO FORESTAL Y EL DESAFIO AMBIENTAL ";
					}else if(opcionSeleccionada=="2119"){
					    capa.innerHTML="REPOBLACION ARTIFICIAL ARBOREA ";
					}else if(opcionSeleccionada=="2120"){
					    capa.innerHTML="PRACTICA AGROPECUARIA ";
					}else if(opcionSeleccionada=="2121"){
					    capa.innerHTML="REFORZAMIENTO EDUCATIVO ";
					}else if(opcionSeleccionada=="2122"){
					    capa.innerHTML="PRACTICAS SOLIDARIAS ";
					}else if(opcionSeleccionada=="2123"){
					    capa.innerHTML="CATECISMO ";
					}else if(opcionSeleccionada=="2124"){
					    capa.innerHTML="CATECISMO I ";
					}else if(opcionSeleccionada=="2125"){
					    capa.innerHTML="CATECISMO II ";
					}else if(opcionSeleccionada=="2126"){
					    capa.innerHTML="MEDIOS DE COMUNICACION SOCIAL ";
					}else if(opcionSeleccionada=="2127"){
					    capa.innerHTML="APRENDIENDO A PENSAR ";
					}else if(opcionSeleccionada=="2128"){
					    capa.innerHTML="RELIGION SALESIANA ";
					}else if(opcionSeleccionada=="2129"){
					    capa.innerHTML="TALLER ESPIRITUAL ";
					}else if(opcionSeleccionada=="2130"){
					    capa.innerHTML="EXPRESION RITMICA ";
					}else if(opcionSeleccionada=="2131"){
					    capa.innerHTML="CALIGRAFIA ";
					}else if(opcionSeleccionada=="2132"){
					    capa.innerHTML="HABILIDAD VERBAL ";
					}else if(opcionSeleccionada=="2133"){
					    capa.innerHTML="TALLER DE PSICOMOTRICIDAD ";
					}else if(opcionSeleccionada=="2134"){
					    capa.innerHTML="ENRIQUECIMIENTO INSTRUMENTAL ";
					}else if(opcionSeleccionada=="2135"){
					    capa.innerHTML="ACTIVIDADES DE LIBRE ELECCION ";
					}else if(opcionSeleccionada=="2136"){
					    capa.innerHTML="PREPARACION PARA LA SALUD ";
					}else if(opcionSeleccionada=="2137"){
					    capa.innerHTML="DESARROLLO PSICOMOTOR DEPORTIVO ";
					}else if(opcionSeleccionada=="2138"){
					    capa.innerHTML="DESARROLLO PSICOMOTOR DEPORTIVO I ";
					}else if(opcionSeleccionada=="2139"){
					    capa.innerHTML="DESARROLLO PSICOMOTOR DEPORTIVO II ";
					}else if(opcionSeleccionada=="2140"){
					    capa.innerHTML="DESARROLLO PSICOMOTOR DEPORTIVO III ";
					}else if(opcionSeleccionada=="2141"){
					    capa.innerHTML="EXPRESION RITMICA MOTRIZ ";
					}else if(opcionSeleccionada=="2142"){
					    capa.innerHTML="EXPRESION RITMICA MOTRIZ I ";
					}else if(opcionSeleccionada=="2143"){
					    capa.innerHTML="EXPRESION RITMICA MOTRIZ II ";
					}else if(opcionSeleccionada=="2144"){
					    capa.innerHTML="EXPRESION RITMICA MOTRIZ III ";
					}else if(opcionSeleccionada=="2077"){
					    capa.innerHTML="EDUCACION ARTISTICA VISUAL ";
					}else if(opcionSeleccionada=="2078"){
					    capa.innerHTML="FORMACION DE HABITOS PERSONALES Y SOCIALES ";
					}else if(opcionSeleccionada=="2079"){
					    capa.innerHTML="TALLER DE MUSICA ";
					}else if(opcionSeleccionada=="2080"){
					    capa.innerHTML="TALLER DE TEATRO Y MUSICA ";
					}else if(opcionSeleccionada=="2081"){
					    capa.innerHTML="DESARROLLO PERSONAL Y ACTITUD SOCIAL ";
					}else if(opcionSeleccionada=="2082"){
					    capa.innerHTML="RELIGION Y FORMACION PERSONAL ";
					}else if(opcionSeleccionada=="2083"){
					    capa.innerHTML="RELIGION Y ORIENTACION ";
					}else if(opcionSeleccionada=="2084"){
					    capa.innerHTML="TECNOLOGIA DE ELECTRICIDAD ";
					}else if(opcionSeleccionada=="2085"){
					    capa.innerHTML="TECNOLOGIA DE ELECTRONICA ";
					}else if(opcionSeleccionada=="2086"){
					    capa.innerHTML="TALLER DE TELECOMUNICACIONES ";
					}else if(opcionSeleccionada=="2087"){
					    capa.innerHTML="LABORATORIO DE TELECOMUNICACIONES ";
					}else if(opcionSeleccionada=="2088"){
					    capa.innerHTML="TECNOLOGIA DE TELECOMUNICACIONES ";
					}else if(opcionSeleccionada=="2089"){
					    capa.innerHTML="TALLER DE ORIENTACION VOCACIONAL ";
					}else if(opcionSeleccionada=="2090"){
					    capa.innerHTML="TALLER DE ELABORACION DE PROYECTOS ";
					}else if(opcionSeleccionada=="2091"){
					    capa.innerHTML="TALLER DE DIBUJO ";
					}else if(opcionSeleccionada=="2092"){
					    capa.innerHTML="EXPLORACION DE LOS SERVICIOS SECRETARIALES ";
					}else if(opcionSeleccionada=="2093"){
					    capa.innerHTML="EXPLORACION DE LOS SERVICIOS ALIMENTICIOS ";
					}else if(opcionSeleccionada=="2094"){
					    capa.innerHTML="AGRICULTURA GENERAL ";
					}else if(opcionSeleccionada=="2095"){
					    capa.innerHTML="TALLER DE LIBRE ELECCION ";
					}else if(opcionSeleccionada=="2096"){
					    capa.innerHTML="SOLDADURA ELECTRICA ";
					}else if(opcionSeleccionada=="2097"){
					    capa.innerHTML="JARDINERIA Y HORTICULTURA ";
					}else if(opcionSeleccionada=="2098"){
					    capa.innerHTML="SOFT ";
					}else if(opcionSeleccionada=="2099"){
					    capa.innerHTML="TALLER DE ELECTRICIDAD BASICA ";
					}else if(opcionSeleccionada=="2100"){
					    capa.innerHTML="TALLER DE BAWER ";
					}else if(opcionSeleccionada=="2101"){
					    capa.innerHTML="TALLER DE MUEBLERIA INFANTIL ";
					}else if(opcionSeleccionada=="2102"){
					    capa.innerHTML="TALLER DE MICROEMPRESA ";
					}else if(opcionSeleccionada=="2103"){
					    capa.innerHTML="INTRODUCCION A LAS ACTIVIDADES COMERCIALES ";
					}else if(opcionSeleccionada=="2104"){
					    capa.innerHTML="RECURSOS NATURALES RENOVABLES ";
					}else if(opcionSeleccionada=="2105"){
					    capa.innerHTML="TALLER SOBRE USO DE DOCUMENTOS MERCANTILES ";
					}else if(opcionSeleccionada=="2106"){
					    capa.innerHTML="ORIENTACION A LA ADMINISTRACION ";
					}else if(opcionSeleccionada=="2107"){
					    capa.innerHTML="TALLER EXPLORATORIO VOCACIONAL ";
					}else if(opcionSeleccionada=="2108"){
					    capa.innerHTML="INTRODUCCION AL TALLER ";
					}else if(opcionSeleccionada=="2109"){
					    capa.innerHTML="TALLER DE INTRODUCCION AL MUNDO LABORAL ";
					}else if(opcionSeleccionada=="2110"){
					    capa.innerHTML="INTRODUCCION A LA ACUICULTURA ";
					}else if(opcionSeleccionada=="2043"){
					    capa.innerHTML="ELEMENTOS PARA EL DISENO DE PROYECTOS ";
					}else if(opcionSeleccionada=="2044"){
					    capa.innerHTML="TALLER EXPLORATORIO DE CONSTRUCCION ";
					}else if(opcionSeleccionada=="2045"){
					    capa.innerHTML="TALLER EXPLORATORIO DE METALMECANICO ";
					}else if(opcionSeleccionada=="2046"){
					    capa.innerHTML="TALLER EXPLORATORIO DE ELECTRICIDAD ";
					}else if(opcionSeleccionada=="2047"){
					    capa.innerHTML="INTRODUCCION A LA TECNOLOGIA INDUSTRIAL ";
					}else if(opcionSeleccionada=="2048"){
					    capa.innerHTML="INTRODUCCION AL DIBUJO TECNICO ";
					}else if(opcionSeleccionada=="2049"){
					    capa.innerHTML="HIGIENE Y SEGURIDAD AMBIENTAL ";
					}else if(opcionSeleccionada=="2050"){
					    capa.innerHTML="INTRODUCCION AL RECURSO FORESTAL ";
					}else if(opcionSeleccionada=="2051"){
					    capa.innerHTML="INGLES O FRANCES ";
					}else if(opcionSeleccionada=="2052"){
					    capa.innerHTML="TALLER EXPLORATORIO DE MECANICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="2053"){
					    capa.innerHTML="INFORMACION BASICA ";
					}else if(opcionSeleccionada=="2054"){
					    capa.innerHTML="DESARROLLO DE HABILIDADES Y DETECCION DE APTITUDES REFERIDAS AL AMBITO DE LA ADMINISTRACION Y EL COMERCIO ";
					}else if(opcionSeleccionada=="2055"){
					    capa.innerHTML="PROCESOS TECNOLOGICOS ";
					}else if(opcionSeleccionada=="2056"){
					    capa.innerHTML="DIBUJO TECNOLOGICO ";
					}else if(opcionSeleccionada=="2057"){
					    capa.innerHTML="GESTION ";
					}else if(opcionSeleccionada=="2058"){
					    capa.innerHTML="LABORATORIO MERCANTIL ";
					}else if(opcionSeleccionada=="2059"){
					    capa.innerHTML="TALLER DE GESTION ";
					}else if(opcionSeleccionada=="2060"){
					    capa.innerHTML="PSICOLOGIA LABORAL ";
					}else if(opcionSeleccionada=="2061"){
					    capa.innerHTML="TALLER DE COMUNICACIONES ";
					}else if(opcionSeleccionada=="2062"){
					    capa.innerHTML="LABORATORIO DE TECNOLOGIA ";
					}else if(opcionSeleccionada=="2063"){
					    capa.innerHTML="TECNOLOGIA DE CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="2064"){
					    capa.innerHTML="TALLER DE MECANICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="2065"){
					    capa.innerHTML="LABORATORIO DE MECANICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="2066"){
					    capa.innerHTML="TECNOLOGIA DE MECANICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="2067"){
					    capa.innerHTML="LABORATORIO DE MECANICA INDUSTRIAL ";
					}else if(opcionSeleccionada=="2068"){
					    capa.innerHTML="TECNOLOGIA DE MECANICA INDUSTRIAL ";
					}else if(opcionSeleccionada=="2069"){
					    capa.innerHTML="BAILES NACIONALES Y LOCALES ";
					}else if(opcionSeleccionada=="2070"){
					    capa.innerHTML="INICIACION A LA FILOSOFIA ";
					}else if(opcionSeleccionada=="2071"){
					    capa.innerHTML="TECNICAS BASICAS DE PRIMEROS AUXILIOS ";
					}else if(opcionSeleccionada=="2072"){
					    capa.innerHTML="AREA INTEGRADA ";
					}else if(opcionSeleccionada=="2073"){
					    capa.innerHTML="RELIGION Y CULTURA CRISTIANA ";
					}else if(opcionSeleccionada=="2074"){
					    capa.innerHTML="TALLER DE BORDADO ";
					}else if(opcionSeleccionada=="2075"){
					    capa.innerHTML="TECNOLOGIA EDUCATIVA ";
					}else if(opcionSeleccionada=="2076"){
					    capa.innerHTML="RELIGION Y DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="2008"){
					    capa.innerHTML="TEORIA DEL CORTE ";
					}else if(opcionSeleccionada=="2009"){
					    capa.innerHTML="ORIENTACION PROFESIONAL PARA LA VIDA DEL TRABAJO ";
					}else if(opcionSeleccionada=="2010"){
					    capa.innerHTML="ORIENTACION PARA LA VIDA DEL TRABAJO ";
					}else if(opcionSeleccionada=="2011"){
					    capa.innerHTML="HACIA EL DESARROLLO ECONOMICO ";
					}else if(opcionSeleccionada=="2012"){
					    capa.innerHTML="HISTORIA DE LA ARQUITECTURA COLONIAL ";
					}else if(opcionSeleccionada=="2013"){
					    capa.innerHTML="INVESTIGACION SOBRE LA LITERATURA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="2014"){
					    capa.innerHTML="INVESTIGACION SOBRE VALORES HUMANOS EN LA LITERATURA ";
					}else if(opcionSeleccionada=="2015"){
					    capa.innerHTML="MECANICA: PRINCIPIOS DE CONSERVACION ";
					}else if(opcionSeleccionada=="2016"){
					    capa.innerHTML="PROBLEMAS FUNDAMENTALES DEL ORGANISMO ANIMAL Y ASPECTOS BIOLOGICOS ";
					}else if(opcionSeleccionada=="2017"){
					    capa.innerHTML="APLICACIONES DE LA MATEMATICA I ";
					}else if(opcionSeleccionada=="2018"){
					    capa.innerHTML="TALLER DE INICIACION EN LA PUBLICIDAD I ";
					}else if(opcionSeleccionada=="2019"){
					    capa.innerHTML="MECANICA ELEMENTAL ";
					}else if(opcionSeleccionada=="2020"){
					    capa.innerHTML="PROBLEMAS FUNDAMENTALES DEL ORGANISMO ANIMAL Y ASPECTOS BASICOS DE ECOLOGIA ";
					}else if(opcionSeleccionada=="2021"){
					    capa.innerHTML="APLICACIONES DE LA MATEMATICA II ";
					}else if(opcionSeleccionada=="2022"){
					    capa.innerHTML="TALLER DE INICIACION EN LA PUBLICIDAD II ";
					}else if(opcionSeleccionada=="2023"){
					    capa.innerHTML="INTRODUCCION A LA ELECTRICIDAD ";
					}else if(opcionSeleccionada=="2024"){
					    capa.innerHTML="LOS RECURSOS NATURALES BASICOS ";
					}else if(opcionSeleccionada=="2025"){
					    capa.innerHTML="LA BIOLOGIA CELULAR ";
					}else if(opcionSeleccionada=="2026"){
					    capa.innerHTML="INVESTIGACION SOBRE CHILE Y SUS REGIONES EN LA LITERATURA ";
					}else if(opcionSeleccionada=="2027"){
					    capa.innerHTML="TALLER DE MATEMATICA I ";
					}else if(opcionSeleccionada=="2028"){
					    capa.innerHTML="TALLER DE MATEMATICA II ";
					}else if(opcionSeleccionada=="2030"){
					    capa.innerHTML="METALURGICA ";
					}else if(opcionSeleccionada=="2031"){
					    capa.innerHTML="BOTANICA FORESTAL ";
					}else if(opcionSeleccionada=="2032"){
					    capa.innerHTML="CONSERVACION DE RECURSOS NATURALES ";
					}else if(opcionSeleccionada=="2033"){
					    capa.innerHTML="TRABAJO PRACTICO EN TERRENO ";
					}else if(opcionSeleccionada=="2034"){
					    capa.innerHTML="BOTANICA AGRICOLA ";
					}else if(opcionSeleccionada=="2035"){
					    capa.innerHTML="RECURSOS NATURALES Y FERTILIDAD ";
					}else if(opcionSeleccionada=="2036"){
					    capa.innerHTML="ELECTRICIDAD BASICA O DACTILOGRAFIA ";
					}else if(opcionSeleccionada=="2037"){
					    capa.innerHTML="COMUNICACION EN EL SIGLO XXI ";
					}else if(opcionSeleccionada=="2038"){
					    capa.innerHTML="INTRODUCCION A LA INFORMATICA I ";
					}else if(opcionSeleccionada=="2039"){
					    capa.innerHTML="INTRODUCCION A LA INFORMATICA II ";
					}else if(opcionSeleccionada=="2040"){
					    capa.innerHTML="PREVENCION DE RIESGOS OCUPACIONALES ";
					}else if(opcionSeleccionada=="2041"){
					    capa.innerHTML="LABORATORIO INDUSTRIAL BASICO ";
					}else if(opcionSeleccionada=="2042"){
					    capa.innerHTML="ELEMENTOS DE ANALISIS Y GESTION AMBIENTAL ";
					}else if(opcionSeleccionada=="1974"){
					    capa.innerHTML="ORGANIZACION Y ADMINISTRACION DE EMPRESAS ";
					}else if(opcionSeleccionada=="1975"){
					    capa.innerHTML="PASTELERIA Y COCTELERIA ";
					}else if(opcionSeleccionada=="1976"){
					    capa.innerHTML="PRACTICA PROFESIONAL ";
					}else if(opcionSeleccionada=="1977"){
					    capa.innerHTML="PRACTICA Y TECNOLOGIA DE TALLER ";
					}else if(opcionSeleccionada=="1978"){
					    capa.innerHTML="PROCEDIMIENTOS JUDICIALES ";
					}else if(opcionSeleccionada=="1979"){
					    capa.innerHTML="PROCESOS METALURGICOS ";
					}else if(opcionSeleccionada=="1980"){
					    capa.innerHTML="PROGRAMACION EN COMPUTACION ";
					}else if(opcionSeleccionada=="1981"){
					    capa.innerHTML="PROYECTO Y DISENO DE PLANOS ";
					}else if(opcionSeleccionada=="1982"){
					    capa.innerHTML="RECONSTRUCCION DE MOTORES ";
					}else if(opcionSeleccionada=="1983"){
					    capa.innerHTML="RELACIONES HUMANAS Y ETICA ";
					}else if(opcionSeleccionada=="1984"){
					    capa.innerHTML="RELACIONES HUMANAS Y ETICA PROFESIONAL ";
					}else if(opcionSeleccionada=="1985"){
					    capa.innerHTML="CALIGRAFIA Y COPIA ";
					}else if(opcionSeleccionada=="1986"){
					    capa.innerHTML="SISTEMA ELECTRICO ";
					}else if(opcionSeleccionada=="1987"){
					    capa.innerHTML="SISTEMAS DE AUDIO Y VIDEO ";
					}else if(opcionSeleccionada=="1988"){
					    capa.innerHTML="SISTEMAS DE TELECOMUNICACIONES Y TELEFONIA ";
					}else if(opcionSeleccionada=="1989"){
					    capa.innerHTML="TALLER DE ADMINISTRACION DE EMPRESAS ";
					}else if(opcionSeleccionada=="1990"){
					    capa.innerHTML="TALLER DE ANALISIS DE SISTEMAS ";
					}else if(opcionSeleccionada=="1991"){
					    capa.innerHTML="TALLER DE APLICACIONES ";
					}else if(opcionSeleccionada=="1992"){
					    capa.innerHTML="TALLER DE DISENO PUBLICITARIO ";
					}else if(opcionSeleccionada=="1993"){
					    capa.innerHTML="NOCIONES ADMINISTRATIVAS ";
					}else if(opcionSeleccionada=="1994"){
					    capa.innerHTML="TALLER DE LABORATORIO ";
					}else if(opcionSeleccionada=="1995"){
					    capa.innerHTML="TALLER DE MAQUINAS Y HERRAMIENTAS ";
					}else if(opcionSeleccionada=="1996"){
					    capa.innerHTML="TALLER DE PRODUCCION ";
					}else if(opcionSeleccionada=="1997"){
					    capa.innerHTML="TALLER DE PUBLICIDAD ";
					}else if(opcionSeleccionada=="1998"){
					    capa.innerHTML="TALLER TECNOLOGIA DE DISENO Y CONSTRUCCION ";
					}else if(opcionSeleccionada=="1999"){
					    capa.innerHTML="TAQUIDACTILOGRAFIA ";
					}else if(opcionSeleccionada=="2000"){
					    capa.innerHTML="TECNICAS DE LA COMPUTACION ";
					}else if(opcionSeleccionada=="2001"){
					    capa.innerHTML="TECNOLOGIA DE LA IMPRESION GRAFICA ";
					}else if(opcionSeleccionada=="2002"){
					    capa.innerHTML="TECNOLOGIA DE LA TERMINACION GRAFICA ";
					}else if(opcionSeleccionada=="2003"){
					    capa.innerHTML="TECNOLOGIA GRAFICA ";
					}else if(opcionSeleccionada=="2004"){
					    capa.innerHTML="TECNOLOGIA PARA LA PREPARACION GRAFICA ";
					}else if(opcionSeleccionada=="2005"){
					    capa.innerHTML="TECNOLOGIA Y PRACTICA DE RECTIFICADO ";
					}else if(opcionSeleccionada=="2006"){
					    capa.innerHTML="TECNOLOGIA DE LA COMUNICACION TELEFONICA ";
					}else if(opcionSeleccionada=="2007"){
					    capa.innerHTML="TERMODINAMICA ";
					}else if(opcionSeleccionada=="1940"){
					    capa.innerHTML="LABORATORIO DE ANALISIS DE ALIMENTOS ";
					}else if(opcionSeleccionada=="1941"){
					    capa.innerHTML="LABORATORIO DE APLICACIONES COMPUTACIONALES ";
					}else if(opcionSeleccionada=="1942"){
					    capa.innerHTML="LABORATORIO DE CIENCIAS ";
					}else if(opcionSeleccionada=="1943"){
					    capa.innerHTML="LABORATORIO DE DERECHO ";
					}else if(opcionSeleccionada=="1944"){
					    capa.innerHTML="LABORATORIO DE ELECTRONICA DE TELECOMUNICACIONES ";
					}else if(opcionSeleccionada=="1945"){
					    capa.innerHTML="LABORATORIO DE ELECTRONICA INDUSTRIAL ";
					}else if(opcionSeleccionada=="1946"){
					    capa.innerHTML="LABORATORIO DE ELECTROTECNIA ";
					}else if(opcionSeleccionada=="1947"){
					    capa.innerHTML="LABORATORIO DE HARDWARE ";
					}else if(opcionSeleccionada=="1948"){
					    capa.innerHTML="LABORATORIO DE LA ESPECIALIDAD ELECTRONICA ";
					}else if(opcionSeleccionada=="1949"){
					    capa.innerHTML="LABORATORIO DE PRACTICA COMERCIAL Y DOCUMENTACION MERCANTIL ";
					}else if(opcionSeleccionada=="1950"){
					    capa.innerHTML="LABORATORIO DE QUIMICA ANALITICA ";
					}else if(opcionSeleccionada=="1951"){
					    capa.innerHTML="LABORATORIO DE QUIMICA INDUSTRIAL ";
					}else if(opcionSeleccionada=="1952"){
					    capa.innerHTML="LABORATORIO DE QUIMICA ORGANICA ";
					}else if(opcionSeleccionada=="1953"){
					    capa.innerHTML="LABORATORIO TECNICO ";
					}else if(opcionSeleccionada=="1954"){
					    capa.innerHTML="LEGISLACION SOBRE ALMACENAJE ";
					}else if(opcionSeleccionada=="1955"){
					    capa.innerHTML="LEGISLACION TRIBUTARIA Y COMERCIAL ";
					}else if(opcionSeleccionada=="1956"){
					    capa.innerHTML="LOGICA APLICADA ";
					}else if(opcionSeleccionada=="1957"){
					    capa.innerHTML="MANTENCION ELECTROMECANICA ";
					}else if(opcionSeleccionada=="1958"){
					    capa.innerHTML="MANTENCION MOTORES DIESEL ";
					}else if(opcionSeleccionada=="1959"){
					    capa.innerHTML="MECANICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="1960"){
					    capa.innerHTML="MECANICA Y RESISTENCIA DE MATERIALES ";
					}else if(opcionSeleccionada=="1961"){
					    capa.innerHTML="TALLER DE RECREACION, URBANIDAD Y CULTURA AMBIENTAL ";
					}else if(opcionSeleccionada=="1962"){
					    capa.innerHTML="METODOS Y TECNICAS DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1963"){
					    capa.innerHTML="MICROBIOLOGIA BASICA Y SALUD E HIGIENE PECUARIA ";
					}else if(opcionSeleccionada=="1964"){
					    capa.innerHTML="MICROBIOLOGIA BASICA Y SALUD PECUARIA ";
					}else if(opcionSeleccionada=="1965"){
					    capa.innerHTML="MICROPROCESADORES ";
					}else if(opcionSeleccionada=="1966"){
					    capa.innerHTML="MORFOFISIOLOGIA ALIMENTACION Y PRODUCCION ANIMAL ";
					}else if(opcionSeleccionada=="1967"){
					    capa.innerHTML="MOTORES ";
					}else if(opcionSeleccionada=="1968"){
					    capa.innerHTML="MUSICAL Y FOLKCLOR ";
					}else if(opcionSeleccionada=="1969"){
					    capa.innerHTML="NOCIONES DE INVESTIGACION SOCIAL ";
					}else if(opcionSeleccionada=="1970"){
					    capa.innerHTML="NOCIONES DE PROGRAMACION ";
					}else if(opcionSeleccionada=="1971"){
					    capa.innerHTML="OPERACIONES METALURGICAS ";
					}else if(opcionSeleccionada=="1972"){
					    capa.innerHTML="ORGANIZACION INDUSTRIAL ";
					}else if(opcionSeleccionada=="1973"){
					    capa.innerHTML="ORGANIZACION Y ADMINISTRACION ";
					}else if(opcionSeleccionada=="1906"){
					    capa.innerHTML="DIRECCION Y SUSPENSION ";
					}else if(opcionSeleccionada=="1907"){
					    capa.innerHTML="DISENO BASICO Y APLICADO ";
					}else if(opcionSeleccionada=="1908"){
					    capa.innerHTML="EDUCACION PARA LA EMPRESA ";
					}else if(opcionSeleccionada=="1909"){
					    capa.innerHTML="EDUCACION SEXUAL Y FAMILIAR ";
					}else if(opcionSeleccionada=="1910"){
					    capa.innerHTML="ELECTRICIDAD BASICA Y APLICADA ";
					}else if(opcionSeleccionada=="1911"){
					    capa.innerHTML="ELECTRICIDAD DE AUTOMOVILES ";
					}else if(opcionSeleccionada=="1912"){
					    capa.innerHTML="ELECTRICIDAD INDUSTRIAL ";
					}else if(opcionSeleccionada=="1913"){
					    capa.innerHTML="HIGIENE Y SANIDAD AMBIENTAL ";
					}else if(opcionSeleccionada=="1914"){
					    capa.innerHTML="TALLER EXPERIMENTAL ";
					}else if(opcionSeleccionada=="1915"){
					    capa.innerHTML="EQUIPOS DE SONIDO ";
					}else if(opcionSeleccionada=="1916"){
					    capa.innerHTML="ESTADISTICA ELEMENTAL ";
					}else if(opcionSeleccionada=="1917"){
					    capa.innerHTML="ESTETICA ";
					}else if(opcionSeleccionada=="1918"){
					    capa.innerHTML="ESTRUCTURAS Y SISTEMAS ";
					}else if(opcionSeleccionada=="1919"){
					    capa.innerHTML="ETICA APLICADA ";
					}else if(opcionSeleccionada=="1920"){
					    capa.innerHTML="ETICA FUNCIONARIA ";
					}else if(opcionSeleccionada=="1921"){
					    capa.innerHTML="ETICA LABORAL Y RELACIONES HUMANAS ";
					}else if(opcionSeleccionada=="1922"){
					    capa.innerHTML="ETICA Y RELACIONES FUNCIONARIAS ";
					}else if(opcionSeleccionada=="1923"){
					    capa.innerHTML="TRANSMISIONES MECANICAS ";
					}else if(opcionSeleccionada=="1924"){
					    capa.innerHTML="EXPRESION MANUAL ";
					}else if(opcionSeleccionada=="1925"){
					    capa.innerHTML="EXPRESION ORAL ";
					}else if(opcionSeleccionada=="1926"){
					    capa.innerHTML="EXPRESION RITMICA CORPORAL ";
					}else if(opcionSeleccionada=="1927"){
					    capa.innerHTML="FITOTECNIA GENERAL Y DE LOS CEREALES ( CULTIVO II ) ";
					}else if(opcionSeleccionada=="1928"){
					    capa.innerHTML="FOLKLORE Y EDUCACION MUSICAL ";
					}else if(opcionSeleccionada=="1929"){
					    capa.innerHTML="FORICULTURA CULTIVO Y PROPAGACION DE PLANTAS ORNAMENTALES ";
					}else if(opcionSeleccionada=="1930"){
					    capa.innerHTML="FRENOS NEUMATICOS ";
					}else if(opcionSeleccionada=="1931"){
					    capa.innerHTML="FUNDAMENTOS DE ADMINISTRACION Y CONTABILIDAD ";
					}else if(opcionSeleccionada=="1932"){
					    capa.innerHTML="FUNDAMENTOS DE ATENCION PARVULARIA ";
					}else if(opcionSeleccionada=="1933"){
					    capa.innerHTML="FUNDAMENTOS DE ATENCION SOCIAL ";
					}else if(opcionSeleccionada=="1934"){
					    capa.innerHTML="TALLER DE COMPRENSION LECTORA ";
					}else if(opcionSeleccionada=="1935"){
					    capa.innerHTML="HIGIENE Y SALUD AMBIENTAL ";
					}else if(opcionSeleccionada=="1936"){
					    capa.innerHTML="IMPLANTACION DE AREAS VERDES E INTRODUCCION AL PAISAJISMO ";
					}else if(opcionSeleccionada=="1937"){
					    capa.innerHTML="LABORATORIO COBOL ";
					}else if(opcionSeleccionada=="1938"){
					    capa.innerHTML="LABORATORIO DE AGUA Y GAS ";
					}else if(opcionSeleccionada=="1939"){
					    capa.innerHTML="LABORATORIO DE ALIMENTACION COLECTIVA ";
					}else if(opcionSeleccionada=="1872"){
					    capa.innerHTML="DIBUJO BOSQUEJO TECNICO MECANO ";
					}else if(opcionSeleccionada=="1873"){
					    capa.innerHTML="TECNICA MAQUINA HERRAMIENTA ";
					}else if(opcionSeleccionada=="1874"){
					    capa.innerHTML="TECNICA MECANICA ";
					}else if(opcionSeleccionada=="1875"){
					    capa.innerHTML="TECNICA DE MANTENCION MECANICA ";
					}else if(opcionSeleccionada=="1876"){
					    capa.innerHTML="TECNICA MECANICA INDUSTRIAL ";
					}else if(opcionSeleccionada=="1877"){
					    capa.innerHTML="SALUD Y ALIMENTACION DEL PARVULO ";
					}else if(opcionSeleccionada=="1878"){
					    capa.innerHTML="ARTE Y CULTURA ";
					}else if(opcionSeleccionada=="1879"){
					    capa.innerHTML="INTRODUCCION A LOS SISTEMAS DE INFORMACION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="1880"){
					    capa.innerHTML="LENGUAJE Y TECNOLOGIA DE PROGRAMACION ";
					}else if(opcionSeleccionada=="1881"){
					    capa.innerHTML="ADMINISTRACION DE BODEGA ";
					}else if(opcionSeleccionada=="1882"){
					    capa.innerHTML="ELECTROMAGNETISMO ";
					}else if(opcionSeleccionada=="1883"){
					    capa.innerHTML="ADMINISTRACION Y LEGISLACION ";
					}else if(opcionSeleccionada=="1884"){
					    capa.innerHTML="ADMINISTRACION Y ORGANIZACION DEL TALLER ";
					}else if(opcionSeleccionada=="1885"){
					    capa.innerHTML="ADMINISTRACION Y VENTAS ";
					}else if(opcionSeleccionada=="1886"){
					    capa.innerHTML="ANALISIS DE ALIMENTOS ";
					}else if(opcionSeleccionada=="1887"){
					    capa.innerHTML="ANALISIS INSTRUMENTAL ";
					}else if(opcionSeleccionada=="1888"){
					    capa.innerHTML="ANALISTA DE SISTEMA ";
					}else if(opcionSeleccionada=="1889"){
					    capa.innerHTML="APICULTURA I Y II ";
					}else if(opcionSeleccionada=="1890"){
					    capa.innerHTML="APRENDIZAJE EN LA EMPRESA ";
					}else if(opcionSeleccionada=="1891"){
					    capa.innerHTML="BORDADO ARTISTICO ";
					}else if(opcionSeleccionada=="1892"){
					    capa.innerHTML="CALCULOS APLICADOS ";
					}else if(opcionSeleccionada=="1893"){
					    capa.innerHTML="CANCIONES Y DANZAS FOLKLORICAS NACIONALES ";
					}else if(opcionSeleccionada=="1894"){
					    capa.innerHTML="COCINA ";
					}else if(opcionSeleccionada=="1895"){
					    capa.innerHTML="COMPORTAMIENTO SOCIAL Y ESTETICA PERSONAL ";
					}else if(opcionSeleccionada=="1896"){
					    capa.innerHTML="COMPRENSION LENGUAJE ORAL Y ESCRITO INGLES ";
					}else if(opcionSeleccionada=="1897"){
					    capa.innerHTML="ECONOMIA Y UNIDADES ECONOMICAS ";
					}else if(opcionSeleccionada=="1898"){
					    capa.innerHTML="COMUNICACIONES ";
					}else if(opcionSeleccionada=="1899"){
					    capa.innerHTML="CONDUCCION Y REGLAMENTACION DEL TRABAJO ";
					}else if(opcionSeleccionada=="1900"){
					    capa.innerHTML="CONFECCION INDUSTRIAL ";
					}else if(opcionSeleccionada=="1901"){
					    capa.innerHTML="CONSEJO DE CURSO Y ORIENTACION ";
					}else if(opcionSeleccionada=="1902"){
					    capa.innerHTML="CONTROL DE PROCESOS INDUSTRIALES ";
					}else if(opcionSeleccionada=="1903"){
					    capa.innerHTML="CUBICACION CALCULO DE MATERIALES Y PRESUPUESTO ";
					}else if(opcionSeleccionada=="1904"){
					    capa.innerHTML="DIBUJO DIAGRAMACION Y ESTETICA GENERAL ";
					}else if(opcionSeleccionada=="1905"){
					    capa.innerHTML="DIBUJO TECNICO Y PUBLICITARIO ";
					}else if(opcionSeleccionada=="1837"){
					    capa.innerHTML="ADMINISTRACION DE LOCALES COMERCIALES ";
					}else if(opcionSeleccionada=="1838"){
					    capa.innerHTML="LEGISLACION Y DOCUMENTACION COMERCIAL Y LABORAL ";
					}else if(opcionSeleccionada=="1839"){
					    capa.innerHTML="OPERACION DE LOCALES COMERCIALES ";
					}else if(opcionSeleccionada=="1840"){
					    capa.innerHTML="TALLER DE ELECTRONICA ";
					}else if(opcionSeleccionada=="1841"){
					    capa.innerHTML="MECANICA Y TERMOLOGIA ";
					}else if(opcionSeleccionada=="1842"){
					    capa.innerHTML="MAQUINAS MATRICES Y CONTROL DE MAQUINAS ";
					}else if(opcionSeleccionada=="1843"){
					    capa.innerHTML="VITIVINICULTURA ";
					}else if(opcionSeleccionada=="1844"){
					    capa.innerHTML="LEGISLACION DE CONSTRUCCION Y SEGURIDAD LABORAL ";
					}else if(opcionSeleccionada=="1845"){
					    capa.innerHTML="LABORATORIO DE ELECTRICIDAD BASICA E INSTALACIONES DOMICILIARIAS ";
					}else if(opcionSeleccionada=="1846"){
					    capa.innerHTML="TECNICAS COMPLEMENTARIAS ";
					}else if(opcionSeleccionada=="1847"){
					    capa.innerHTML="PREVENCION DE RIESGOS E HIGIENE Y SEGURIDAD INDUSTRIAL ";
					}else if(opcionSeleccionada=="1848"){
					    capa.innerHTML="LABORATORIO DE ELECTRICIDAD Y ELECTRONICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="1849"){
					    capa.innerHTML="ELECTRICIDAD APLICADA A ELECTRICIDAD Y ELECTRONICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="1850"){
					    capa.innerHTML="LABORATORIO DE MOTORES A PRESION CONSTANTE ";
					}else if(opcionSeleccionada=="1851"){
					    capa.innerHTML="TECNOLOGIA DE MOTORES A PRESION CONSTANTE ";
					}else if(opcionSeleccionada=="1852"){
					    capa.innerHTML="TECNOLOGIA DE MOTORES A VOLUMEN CONSTANTE ";
					}else if(opcionSeleccionada=="1853"){
					    capa.innerHTML="ELECTRICIDAD APLICADA A MOTORES A VOLUMEN CONSTANTE ";
					}else if(opcionSeleccionada=="1854"){
					    capa.innerHTML="PREVENCION DE RIESGOS Y SEGURIDAD INDUSTRIAL ";
					}else if(opcionSeleccionada=="1855"){
					    capa.innerHTML="PREVENCION DE RIESGOS E HIGIENE Y SEGURIDAD ";
					}else if(opcionSeleccionada=="1856"){
					    capa.innerHTML="ELEMENTOS DE COMPUTACION BASICA ";
					}else if(opcionSeleccionada=="1857"){
					    capa.innerHTML="ADMINISTRACION Y MICROEMPRESA ";
					}else if(opcionSeleccionada=="1858"){
					    capa.innerHTML="INTRODUCCION A LA COMPUTACION Y SISTEMAS DIGITALES ";
					}else if(opcionSeleccionada=="1859"){
					    capa.innerHTML="LABORATORIO Y TALLER ";
					}else if(opcionSeleccionada=="1860"){
					    capa.innerHTML="DIBUJO TECNICO ELECTRICO ";
					}else if(opcionSeleccionada=="1862"){
					    capa.innerHTML="TECNICA ELECTRICA ";
					}else if(opcionSeleccionada=="1863"){
					    capa.innerHTML="INFORMATICA APLICADA I ";
					}else if(opcionSeleccionada=="1864"){
					    capa.innerHTML="TECNICO DE ELECTRICIDAD INDUSTRIAL ";
					}else if(opcionSeleccionada=="1865"){
					    capa.innerHTML="TECNICO DE MANTENCION ELECTRICA ";
					}else if(opcionSeleccionada=="1866"){
					    capa.innerHTML="TECNICO ELECTRONICO INDUSTRIAL ";
					}else if(opcionSeleccionada=="1867"){
					    capa.innerHTML="DIBUJO TECNICO ESTRUCTURAL ";
					}else if(opcionSeleccionada=="1868"){
					    capa.innerHTML="TALLER CARPINTERIA METALICA ";
					}else if(opcionSeleccionada=="1869"){
					    capa.innerHTML="DIBUJO ESTRUCTURA Y PROYECTO ";
					}else if(opcionSeleccionada=="1870"){
					    capa.innerHTML="TECNICO DE ESTRUCTURA METALICA ";
					}else if(opcionSeleccionada=="1871"){
					    capa.innerHTML="TECNOLOGIA INDUSTRIAL ";
					}else if(opcionSeleccionada=="1803"){
					    capa.innerHTML="ADMINISTRACION GENERAL Y FINANCIERA ";
					}else if(opcionSeleccionada=="1804"){
					    capa.innerHTML="LABORATORIO DE INFORMATICA ";
					}else if(opcionSeleccionada=="1805"){
					    capa.innerHTML="ADMINISTRACION DE INVENTARIOS ";
					}else if(opcionSeleccionada=="1806"){
					    capa.innerHTML="METODOLOGIA DE LA CONFECCION ";
					}else if(opcionSeleccionada=="1807"){
					    capa.innerHTML="MODELAJE Y ESTETICA ";
					}else if(opcionSeleccionada=="1808"){
					    capa.innerHTML="TALLER DE SECRETARIADO ";
					}else if(opcionSeleccionada=="1809"){
					    capa.innerHTML="CONTABILIDAD BASICA ";
					}else if(opcionSeleccionada=="1810"){
					    capa.innerHTML="RELACIONES PUBLICAS Y HUMANAS ";
					
					}else if(opcionSeleccionada=="1811"){
					    capa.innerHTML="TALLER DE REDACCION ";
					}else if(opcionSeleccionada=="1812"){
					    capa.innerHTML="BANQUETERIA Y EVENTOS ";
					}else if(opcionSeleccionada=="1813"){
					    capa.innerHTML="CONTABILIDAD Y LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="1814"){
					    capa.innerHTML="ELECTRONICA Y LABORATORIO ";
					}else if(opcionSeleccionada=="1815"){
					    capa.innerHTML="MICROPROCESADORES Y LABORATORIO ";
					}else if(opcionSeleccionada=="1816"){
					    capa.innerHTML="MERCADO FINANCIERO ";
					}else if(opcionSeleccionada=="1817"){
					    capa.innerHTML="PANORAMA GEOGRAFICO ECONOMICO DE CHILE ";
					}else if(opcionSeleccionada=="1818"){
					    capa.innerHTML="PSICOLOGIA INFANTIL ";
					}else if(opcionSeleccionada=="1819"){
					    capa.innerHTML="TOXICOLOGIA ALIMENTARIA ";
					}else if(opcionSeleccionada=="1820"){
					    capa.innerHTML="TEATRO INFANTIL ";
					}else if(opcionSeleccionada=="1821"){
					    capa.innerHTML="PREVENCION Y PRIMEROS AUXILIOS ";
					}else if(opcionSeleccionada=="1822"){
					    capa.innerHTML="EXPRESION DEL PARVULO ";
					}else if(opcionSeleccionada=="1823"){
					    capa.innerHTML="TEORIA Y LABORATORIO DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1824"){
					    capa.innerHTML="TECNICAS DE PROGRAMACION ";
					}else if(opcionSeleccionada=="1825"){
					    capa.innerHTML="HIGIENE Y SEGURIDAD ";
					}else if(opcionSeleccionada=="1826"){
					    capa.innerHTML="PREVENCION DE RIESGOS E HIGIENE ";
					}else if(opcionSeleccionada=="1827"){
					    capa.innerHTML="ELECTRONICA APLICADA ";
					}else if(opcionSeleccionada=="1828"){
					    capa.innerHTML="TECNICAS DE LA EXPRESION ORAL Y ESCRITA ";
					}else if(opcionSeleccionada=="1829"){
					    capa.innerHTML="INGLES AVANZADO ";
					}else if(opcionSeleccionada=="1830"){
					    capa.innerHTML="ARCHIVOS COMPUTACIONALES ";
					}else if(opcionSeleccionada=="1831"){
					    capa.innerHTML="LABORAL ";
					}else if(opcionSeleccionada=="1832"){
					    capa.innerHTML="QUIMICA INORGANICA ";
					}else if(opcionSeleccionada=="1833"){
					    capa.innerHTML="HIGIENE AMBIENTAL Y SALUD ";
					}else if(opcionSeleccionada=="1834"){
					    capa.innerHTML="TECNICA DE LA REPOSTERIA ";
					}else if(opcionSeleccionada=="1835"){
					    capa.innerHTML="LENGUAJE Y TECNICAS DE PROGRAMACION ";
					}else if(opcionSeleccionada=="1836"){
					    capa.innerHTML="HERRAMIENTAS DE APLICACION ";
					}else if(opcionSeleccionada=="1769"){
					    capa.innerHTML="DERECHO ";
					}else if(opcionSeleccionada=="1770"){
					    capa.innerHTML="LABORATORIO CONTABLE ";
					}else if(opcionSeleccionada=="1771"){
					    capa.innerHTML="DESARROLLO PERSONAL Y COMUNICACION ";
					}else if(opcionSeleccionada=="1772"){
					    capa.innerHTML="HOMBRE Y AMBIENTE ";
					}else if(opcionSeleccionada=="1773"){
					    capa.innerHTML="ADMINISTRACION Y PRESUPUESTO ";
					}else if(opcionSeleccionada=="1774"){
					    capa.innerHTML="EXPRESION DE CULTURA MUSICAL ";
					}else if(opcionSeleccionada=="1775"){
					    capa.innerHTML="MUSICA Y DANZAS FOLKLORICAS NACIONALES ";
					}else if(opcionSeleccionada=="1776"){
					    capa.innerHTML="PSICOLOGIA INFANTIL Y DEL APRENDIZAJE ";
					}else if(opcionSeleccionada=="1777"){
					    capa.innerHTML="TECNICAS MANUALES ";
					}else if(opcionSeleccionada=="1778"){
					    capa.innerHTML="LABORATORIO DE TECNICAS ADMINISTRATIVAS ";
					}else if(opcionSeleccionada=="1779"){
					    capa.innerHTML="EDUCACION SOCIAL ";
					}else if(opcionSeleccionada=="1780"){
					    capa.innerHTML="TECNOLOGIA DE MAQUINA ";
					}else if(opcionSeleccionada=="1781"){
					    capa.innerHTML="ETICA Y RELACIONES PUBLICAS ";
					}else if(opcionSeleccionada=="1782"){
					    capa.innerHTML="TECNICAS COMPUTACIONALES ";
					}else if(opcionSeleccionada=="1783"){
					    capa.innerHTML="ELEMENTOS DE COMPUTACION ";
					}else if(opcionSeleccionada=="1784"){

					    capa.innerHTML="LENGUAJE Y TECNOLOGIA ";
					}else if(opcionSeleccionada=="1785"){
					    capa.innerHTML="EDUCACION DIFERENCIAL ";
					}else if(opcionSeleccionada=="1786"){
					    capa.innerHTML="ETICA Y MORAL ";
					}else if(opcionSeleccionada=="1787"){
					    capa.innerHTML="ESTADISTICA APLICADA ";
					}else if(opcionSeleccionada=="1788"){
					    capa.innerHTML="TALLER DE EXPRESION MURAL ";
					}else if(opcionSeleccionada=="1789"){
					    capa.innerHTML="TALLER DE DISENO URBANISTICO ";
					}else if(opcionSeleccionada=="1790"){
					    capa.innerHTML="ETICA Y FILOSOFIA ";
					}else if(opcionSeleccionada=="1791"){
					    capa.innerHTML="NOCIONES DE CONTABILIDAD ";
					}else if(opcionSeleccionada=="1792"){
					    capa.innerHTML="COMBUSTION ";
					}else if(opcionSeleccionada=="1793"){
					    capa.innerHTML="MAQUINAS E IMPLEMENTOS AGRICOLAS ";
					}else if(opcionSeleccionada=="1794"){
					    capa.innerHTML="TALLER DE ALIMENTACION ";
					}else if(opcionSeleccionada=="1795"){
					    capa.innerHTML="SISTEMAS DIGITALES Y COMPUTACION ";
					}else if(opcionSeleccionada=="1796"){
					    capa.innerHTML="APLICACIONES DE LA MATEMATICA ";
					}else if(opcionSeleccionada=="1797"){
					    capa.innerHTML="ARTE Y DISENO ";
					}else if(opcionSeleccionada=="1798"){
					    capa.innerHTML="FILOSOFIA E HISTORIA DE LA CULTURA ";
					}else if(opcionSeleccionada=="1799"){
					    capa.innerHTML="DISENO PUBLICITARIO ";
					}else if(opcionSeleccionada=="1800"){
					    capa.innerHTML="REDACCION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="1801"){
					    capa.innerHTML="REDACCION OFICIAL ";
					}else if(opcionSeleccionada=="1802"){
					    capa.innerHTML="TECNICAS DE OFICINA ";
					}else if(opcionSeleccionada=="1735"){
					    capa.innerHTML="FILOSOFIA Y ETICA ";
					}else if(opcionSeleccionada=="1736"){
					    capa.innerHTML="EDUCACION CIVICA Y LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="1737"){
					    capa.innerHTML="SISTEMA DE CALIDAD Y MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="1738"){
					    capa.innerHTML="HIGIENE INDUSTRIAL ";
					}else if(opcionSeleccionada=="1739"){
					    capa.innerHTML="LEGISLACION SANITARIA Y LABORAL ";
					}else if(opcionSeleccionada=="1740"){
					    capa.innerHTML="CULTURA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="1741"){
					    capa.innerHTML="COMPUTACION Y SISTEMAS OPERATIVOS ";
					}else if(opcionSeleccionada=="1742"){
					    capa.innerHTML="ESTRUCTURA Y BASE DE DATOS ";
					}else if(opcionSeleccionada=="1743"){
					    capa.innerHTML="LENGUAJE DE PROGRAMACION BASIC ";
					}else if(opcionSeleccionada=="1744"){
					    capa.innerHTML="ACTIVIDADES PLASTICAS Y MANUALES ";
					}else if(opcionSeleccionada=="1745"){
					    capa.innerHTML="TALLER DE DANZAS FOLKLORICAS ";
					}else if(opcionSeleccionada=="1746"){
					    capa.innerHTML="TALLER DE EXPRESION MUSICAL ";
					}else if(opcionSeleccionada=="1747"){
					    capa.innerHTML="NOCIONES DE DERECHO Y LEGISLACION SOCIAL ";
					}else if(opcionSeleccionada=="1748"){
					    capa.innerHTML="SISTEMAS ADMINISTRATIVOS ";
					}else if(opcionSeleccionada=="1749"){
					    capa.innerHTML="LABORATORIO DE VENTA Y PUBLICIDAD ";
					}else if(opcionSeleccionada=="1750"){
					    capa.innerHTML="SISTEMAS OPERATIVOS ";
					}else if(opcionSeleccionada=="1751"){
					    capa.innerHTML="EXPRESION MUSICAL Y CORPORAL ";
					}else if(opcionSeleccionada=="1752"){
					    capa.innerHTML="PUERICULTURA ";
					}else if(opcionSeleccionada=="1753"){
					    capa.innerHTML="ADMINISTRACION DE TALLER ";
					}else if(opcionSeleccionada=="1754"){
					    capa.innerHTML="ELEMENTOS DE PROGRAMACION BASIC ";
					}else if(opcionSeleccionada=="1755"){
					    capa.innerHTML="PSICOLOGIA DEL PARVULO ";
					}else if(opcionSeleccionada=="1756"){
					    capa.innerHTML="FRANCES INSTRUMENTAL ";
					}else if(opcionSeleccionada=="1757"){
					    capa.innerHTML="PRODUCTOS DE PANADERIA Y PASTELERIA ";
					}else if(opcionSeleccionada=="1758"){
					    capa.innerHTML="TEORIA DE LA ALIMENTACION ";
					}else if(opcionSeleccionada=="1759"){
					    capa.innerHTML="TALLER DE CONFECCIONES ";
					}else if(opcionSeleccionada=="1760"){
					    capa.innerHTML="TALLER DE CORTES ";
					}else if(opcionSeleccionada=="1761"){
					    capa.innerHTML="DERECHO CONSTITUCIONAL ";
					}else if(opcionSeleccionada=="1762"){
					    capa.innerHTML="ELEMENTOS BASICOS DE LEGISLACION INMOBILIARIA ";
					}else if(opcionSeleccionada=="1763"){
					    capa.innerHTML="HISTORIA SOCIAL DE CHILE ";
					}else if(opcionSeleccionada=="1764"){
					    capa.innerHTML="ADMINISTRACION ADUANERA ";
					}else if(opcionSeleccionada=="1765"){
					    capa.innerHTML="ADMINISTRACION BANCARIA Y FINANCIERA ";
					}else if(opcionSeleccionada=="1766"){
					    capa.innerHTML="COMERCIO INTERNACIONAL ";
					}else if(opcionSeleccionada=="1767"){
					    capa.innerHTML="EDUCACION CIUDADANA ";
					}else if(opcionSeleccionada=="1768"){
					    capa.innerHTML="FORMACION SOCIAL DE AMERICA ";
					}else if(opcionSeleccionada=="1701"){
					    capa.innerHTML="TRANSMISIONES HIDRAULICAS ";
					}else if(opcionSeleccionada=="1702"){
					    capa.innerHTML="TURISMO AVENTURA ";
					}else if(opcionSeleccionada=="1703"){
					    capa.innerHTML="TURISMO CIENTIFICO-TECNOLOGICO ";
					}else if(opcionSeleccionada=="1704"){
					    capa.innerHTML="TURISMO CULTURAL ";
					}else if(opcionSeleccionada=="1705"){
					    capa.innerHTML="TURISMO ECOLOGICO ";
					}else if(opcionSeleccionada=="1706"){
					    capa.innerHTML="TUTORIA ";
					}else if(opcionSeleccionada=="1707"){
					    capa.innerHTML="URBANIZACION Y OBRAS CIVILES ";
					}else if(opcionSeleccionada=="1708"){
					    capa.innerHTML="TALLER CORAL ";
					}else if(opcionSeleccionada=="1709"){
					    capa.innerHTML="UTILITARIOS COMPUTACIONALES ";
					}else if(opcionSeleccionada=="1710"){
					    capa.innerHTML="VENTAS DE SALON ";
					}else if(opcionSeleccionada=="1711"){
					    capa.innerHTML="COMPUTACION E INFORMATICA TECNICA ";
					}else if(opcionSeleccionada=="1712"){
					    capa.innerHTML="INVERNADERO ";
					}else if(opcionSeleccionada=="1713"){
					    capa.innerHTML="COMPUTACION GRAFICA ";
					}else if(opcionSeleccionada=="1714"){
					    capa.innerHTML="COMPUTACION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="1715"){
					    capa.innerHTML="MULTITALLER DE EXPRESION PLASTICA EN EL PLANO Y VOLUMEN ";
					}else if(opcionSeleccionada=="1716"){
					    capa.innerHTML="LA OFICINA EN LA EMPRESA MODERNA ";
					}else if(opcionSeleccionada=="1717"){
					    capa.innerHTML="TALLER DE DISENO ";
					}else if(opcionSeleccionada=="1718"){
					    capa.innerHTML="LEGISLACION LABORAL Y COMERCIAL ";
					}else if(opcionSeleccionada=="1719"){
					    capa.innerHTML="MATEMATICA COMERCIAL Y ESTADISTICA ";
					}else if(opcionSeleccionada=="1720"){
					    capa.innerHTML="LEGISLACION SOCIAL Y LABORAL ";
					}else if(opcionSeleccionada=="1721"){
					    capa.innerHTML="DERECHO COMERCIAL Y TRIBUTARIO ";
					}else if(opcionSeleccionada=="1722"){
					    capa.innerHTML="PROBLEMAS SOCIALES CONTEMPORANEOS ";
					}else if(opcionSeleccionada=="1723"){
					    capa.innerHTML="DISENO Y VESTUARIO ";
					}else if(opcionSeleccionada=="1724"){
					    capa.innerHTML="SISTEMA DE INFORMACION ";
					}else if(opcionSeleccionada=="1725"){
					    capa.innerHTML="SISTEMAS OPERATIVOS Y UTILITARIOS ";
					}else if(opcionSeleccionada=="1726"){
					    capa.innerHTML="ELEMENTOS CONTABLES ";
					}else if(opcionSeleccionada=="1727"){
					    capa.innerHTML="ESTETICA Y PRESENTACION PERSONAL ";
					}else if(opcionSeleccionada=="1728"){
					    capa.innerHTML="SOFTWARE DE USO GENERALIZADO ";
					}else if(opcionSeleccionada=="1729"){
					    capa.innerHTML="SEGURIDAD E HIGIENE INDUSTRIAL ";
					}else if(opcionSeleccionada=="1730"){
					    capa.innerHTML="CORTE Y MODELAJE ";
					}else if(opcionSeleccionada=="1731"){
					    capa.innerHTML="ADMINISTRACION EN SERVICIOS ALIMENTARIOS ";
					}else if(opcionSeleccionada=="1732"){
					    capa.innerHTML="ELECTROMECANICA ";
					}else if(opcionSeleccionada=="1733"){
					    capa.innerHTML="HILANDERIA ";
					}else if(opcionSeleccionada=="1734"){
					    capa.innerHTML="TECNICA DE FORMACION PROFESIONAL ";
					}else if(opcionSeleccionada=="1667"){
					    capa.innerHTML="TECNOLOGIA DE LOS MATERIALES PRIMAS ";
					}else if(opcionSeleccionada=="1668"){
					    capa.innerHTML="TECNOLOGIA INTEGRADA Y DE EQUIPOS ";
					}else if(opcionSeleccionada=="1669"){
					    capa.innerHTML="TECNOLOGIA Y CONSERVACION DE ALIMENTOS ";
					}else if(opcionSeleccionada=="1670"){
					    capa.innerHTML="TECNOLOGIA Y LABORATORIO DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1671"){
					    capa.innerHTML="TECNOLOGIA Y PRACTICAS DE MECANICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="1672"){
					    capa.innerHTML="TEJEDURIA ";
					}else if(opcionSeleccionada=="1673"){
					    capa.innerHTML="TEJIDO DE PUNTO ";
					}else if(opcionSeleccionada=="1674"){
					    capa.innerHTML="TEJIDO DE PUNTO CIRCULAR ";
					}else if(opcionSeleccionada=="1675"){
					    capa.innerHTML="TEJIDO DE PUNTO RECTILINEO ";
					}else if(opcionSeleccionada=="1676"){
					    capa.innerHTML="TELECOMUNICACIONES ";
					}else if(opcionSeleccionada=="1677"){
					    capa.innerHTML="TELEFONIA ";
					}else if(opcionSeleccionada=="1678"){
					    capa.innerHTML="TELEPROCESO ";
					}else if(opcionSeleccionada=="1679"){
					    capa.innerHTML="TEORIA DE LA COMPUTACION ";
					}else if(opcionSeleccionada=="1680"){
					    capa.innerHTML="DESARROLLO DE LA INTELIGENCIA ";
					}else if(opcionSeleccionada=="1681"){
					    capa.innerHTML="TEORIA DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1682"){
					    capa.innerHTML="TEORIA DE PANADERIA ";
					}else if(opcionSeleccionada=="1683"){
					    capa.innerHTML="TEORIA DE PASTELERIA ";
					}else if(opcionSeleccionada=="1684"){
					    capa.innerHTML="TEORIA DE PRODUCTOS ";
					}else if(opcionSeleccionada=="1685"){
					    capa.innerHTML="TEORIA Y PRACTICA DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1686"){
					    capa.innerHTML="TEORIA Y TECNICAS DEL COLOR ";
					}else if(opcionSeleccionada=="1687"){
					    capa.innerHTML="TEORIAS DE PRODUCTOS ";
					}else if(opcionSeleccionada=="1688"){
					    capa.innerHTML="CONOCIENDO EL MUNDO DE LA EMPRESA ";
					}else if(opcionSeleccionada=="1689"){
					    capa.innerHTML="TERMINACION GRAFICA ";
					}else if(opcionSeleccionada=="1690"){
					    capa.innerHTML="TERMINACIONES ";
					}else if(opcionSeleccionada=="1691"){
					    capa.innerHTML="TINTORERIA ";
					}else if(opcionSeleccionada=="1692"){
					    capa.innerHTML="TISAJE ";
					}else if(opcionSeleccionada=="1693"){
					    capa.innerHTML="TITULACION Y CALCULO DE PRODUCCION ";
					}else if(opcionSeleccionada=="1694"){
					    capa.innerHTML="TOXICOLOGIA ALIMENTACION ";
					}else if(opcionSeleccionada=="1695"){
					    capa.innerHTML="TRAMITACION JUDICIAL ";
					}else if(opcionSeleccionada=="1696"){
					    capa.innerHTML="TRANSMISION ";
					}else if(opcionSeleccionada=="1697"){
					    capa.innerHTML="TRANSMISION DE DATOS ";
					}else if(opcionSeleccionada=="1698"){
					    capa.innerHTML="TRANSMISION Y REDES DE DATOS ";
					}else if(opcionSeleccionada=="1699"){
					    capa.innerHTML="TRANSPORTE Y SEGUROS ";
					}else if(opcionSeleccionada=="1700"){
					    capa.innerHTML="ADMINISTRACION DE ABASTECIMIENTO ";
					}else if(opcionSeleccionada=="1633"){
					    capa.innerHTML="TECNICAS DE ADMINISTRACION ";
					}else if(opcionSeleccionada=="1634"){
					    capa.innerHTML="TECNICAS DE ALIMENTACION COLECTIVA ";
					}else if(opcionSeleccionada=="1635"){
					    capa.innerHTML="TECNICAS DE ALMACENAMIENTO ";
					}else if(opcionSeleccionada=="1636"){
					    capa.innerHTML="TECNICAS DE ARCHIVO ";
					}else if(opcionSeleccionada=="1637"){
					    capa.innerHTML="TECNICAS DE ARCHIVO Y DOCUMENTACION ";
					}else if(opcionSeleccionada=="1638"){
					    capa.innerHTML="TECNICAS DE COCINA ";
					}else if(opcionSeleccionada=="1639"){
					    capa.innerHTML="TECNICAS DE COCINA BASICA Y PLANIFICACION DE MENU ";
					}else if(opcionSeleccionada=="1640"){
					    capa.innerHTML="TECNICAS DE DISEÑO ";
					}else if(opcionSeleccionada=="1641"){
					    capa.innerHTML="TECNICAS DE ELABORACION Y PRESENTACION DE ALIMENTOS ";
					}else if(opcionSeleccionada=="1642"){
					    capa.innerHTML="TECNICAS DE EXPRESION ";
					}else if(opcionSeleccionada=="1643"){
					    capa.innerHTML="TECNICAS DE EXPRESION Y COMUNICACION ";
					}else if(opcionSeleccionada=="1644"){
					    capa.innerHTML="TECNICAS DE LAS COMUNICACIONES ";
					}else if(opcionSeleccionada=="1645"){
					    capa.innerHTML="TECNICAS DE LAVANDERIA Y LENCERIA ";
					}else if(opcionSeleccionada=="1646"){
					    capa.innerHTML="TECNICAS DE OPERACION DE RESERVAS Y RECEPCION ";
					}else if(opcionSeleccionada=="1647"){
					    capa.innerHTML="TECNICAS DE SERVICIO DE BAR ";
					}else if(opcionSeleccionada=="1648"){
					    capa.innerHTML="TECNICAS DE SERVICIO DE COMEDORES Y DE ATENCION AL CLIENTE ";
					}else if(opcionSeleccionada=="1649"){
					    capa.innerHTML="TECNICAS DE TURISMO ";
					}else if(opcionSeleccionada=="1650"){
					    capa.innerHTML="TECNICAS DE VENTA ";
					}else if(opcionSeleccionada=="1651"){
					    capa.innerHTML="TECNICAS DE VENTAS E INVESTIGACION DE MERCADO ";
					}else if(opcionSeleccionada=="1652"){
					    capa.innerHTML="TECNICAS DE VENTAS Y MANEJO DE CAJA ";
					}else if(opcionSeleccionada=="1653"){
					    capa.innerHTML="TECNICAS GRUPALES ";
					}else if(opcionSeleccionada=="1654"){
					    capa.innerHTML="TECNICAS LITERARIAS Y TEATRALES ";
					}else if(opcionSeleccionada=="1655"){
					    capa.innerHTML="TECNICAS MANUALES Y DECORATIVAS ";
					}else if(opcionSeleccionada=="1656"){
					    capa.innerHTML="TECNICAS PSICOPEDAGOGICAS ";
					}else if(opcionSeleccionada=="1657"){
					    capa.innerHTML="TECNICAS RECREATIVAS ";
					}else if(opcionSeleccionada=="1658"){
					    capa.innerHTML="TECNICO CULINARIA ";
					}else if(opcionSeleccionada=="1659"){
					    capa.innerHTML="TECNOLOGIA APLICADA ";
					}else if(opcionSeleccionada=="1660"){
					    capa.innerHTML="TECNOLOGIA APLICADA Y PRACTICA DE TALLER ";
					}else if(opcionSeleccionada=="1661"){
					    capa.innerHTML="TECNOLOGIA DE EQUIPOS ";
					}else if(opcionSeleccionada=="1662"){
					    capa.innerHTML="TECNOLOGIA DE LA CALIDAD ";
					}else if(opcionSeleccionada=="1663"){
					    capa.innerHTML="TECNOLOGIA DE LA CONSTRUCCION ";
					}else if(opcionSeleccionada=="1664"){
					    capa.innerHTML="TECNOLOGIA DE LAS INSTALACIONES ";
					}else if(opcionSeleccionada=="1665"){
					    capa.innerHTML="TECNOLOGIA DE LOS ALIMENTOS ";
					}else if(opcionSeleccionada=="1666"){
					    capa.innerHTML="TECNOLOGIA DE LOS MATERIALES ";
					}else if(opcionSeleccionada=="1599"){
					    capa.innerHTML="TALLER DE JUGUETERIA ";
					}else if(opcionSeleccionada=="1600"){
					    capa.innerHTML="TALLER DE LA ELECTRICIDAD ";
					}else if(opcionSeleccionada=="1601"){
					    capa.innerHTML="TALLER DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1602"){
					    capa.innerHTML="TALLER DE LA ESPECIALIDAD EN LA EMPRESA ";
					}else if(opcionSeleccionada=="1603"){
					    capa.innerHTML="TALLER DE LA EXPRESION PLASTICA ";
					}else if(opcionSeleccionada=="1604"){
					    capa.innerHTML="TALLER DE MECANICA INDUSTRIAL ";
					}else if(opcionSeleccionada=="1605"){
					    capa.innerHTML="TALLER DE MODELAJE INDUSTRIAL ";
					}else if(opcionSeleccionada=="1606"){
					    capa.innerHTML="TALLER DE PANADERIA-PASTELERIA ";
					}else if(opcionSeleccionada=="1607"){
					    capa.innerHTML="TALLER DE RADIO Y TELEVISION ";
					}else if(opcionSeleccionada=="1608"){
					    capa.innerHTML="TALLER DE REDACCION Y COMUNICACION ";
					}else if(opcionSeleccionada=="1609"){
					    capa.innerHTML="TALLER DE SOLDADURA ";
					}else if(opcionSeleccionada=="1610"){
					    capa.innerHTML="TALLER DE TECNICAS CULINARIAS ";
					}else if(opcionSeleccionada=="1611"){
					    capa.innerHTML="TALLER DE TEJIDO ";
					}else if(opcionSeleccionada=="1612"){
					    capa.innerHTML="TALLER DE VESTUARIO ";
					}else if(opcionSeleccionada=="1613"){
					    capa.innerHTML="TALLER DUAL (EN LA EMPRESA) ";
					}else if(opcionSeleccionada=="1614"){
					    capa.innerHTML="TALLER EN LA EMPRESA ";
					}else if(opcionSeleccionada=="1615"){
					    capa.innerHTML="TALLER ESPECIALIZACION TEXTIL ";
					}else if(opcionSeleccionada=="1616"){
					    capa.innerHTML="TALLER GENERAL DE MECANICA ";
					}else if(opcionSeleccionada=="1617"){
					    capa.innerHTML="TALLER MECANICO AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="1618"){
					    capa.innerHTML="TALLER MODELO DE VESTUARIO FEMENINO ";
					}else if(opcionSeleccionada=="1619"){
					    capa.innerHTML="TALLER PRACTICO DE REDACCION Y ARCHIVO ";
					}else if(opcionSeleccionada=="1620"){
					    capa.innerHTML="TALLER PROFESIONAL ";
					}else if(opcionSeleccionada=="1621"){
					    capa.innerHTML="TALLER RECREATIVO ";
					}else if(opcionSeleccionada=="1622"){
					    capa.innerHTML="TALLER Y LABORATORIO ";
					}else if(opcionSeleccionada=="1623"){
					    capa.innerHTML="TALLER Y LABORATORIO DE SECRETARIADO ";
					}else if(opcionSeleccionada=="1624"){
					    capa.innerHTML="TALLERES DE ALIMENTACION ";
					}else if(opcionSeleccionada=="1625"){
					    capa.innerHTML="TAQUIDACTIGRAFIA ";
					}else if(opcionSeleccionada=="1626"){
					    capa.innerHTML="TAQUIGRAFIA ";
					}else if(opcionSeleccionada=="1627"){
					    capa.innerHTML="TECNICA ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="1"){
					    capa.innerHTML="CASTELLANO ";
					}else if(opcionSeleccionada=="2"){
					    capa.innerHTML="FILOSOFIA ";
					}else if(opcionSeleccionada=="29"){
					    capa.innerHTML="ARTES MUSICALES ";
					}else if(opcionSeleccionada=="4"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA DE CHILE ";
					}else if(opcionSeleccionada=="35"){
					    capa.innerHTML="HISTORIA Y CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="6"){
					    capa.innerHTML="CIENCIAS NATURALES ";
					}else if(opcionSeleccionada=="999"){
					    capa.innerHTML="FILOSOFIA Y PSICOLOGIA ";
					}else if(opcionSeleccionada=="50000"){
					    capa.innerHTML="LECTURA VELOZ INFANTIL ";
					}else if(opcionSeleccionada=="9"){
					    capa.innerHTML="ARTES PLASTICAS ";
					}else if(opcionSeleccionada=="10"){
					    capa.innerHTML="EDUCACION MUSICAL ";
					}else if(opcionSeleccionada=="50003"){
					    capa.innerHTML="INGLES AVANZADO 1 ";
					}else if(opcionSeleccionada=="12"){
					    capa.innerHTML="ARTES MANUALES ";
					}else if(opcionSeleccionada=="50004"){
					    capa.innerHTML="INGLES AVANZADO 2 ";
					}else if(opcionSeleccionada=="14"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION ";
					}else if(opcionSeleccionada=="15"){
					    capa.innerHTML="EDUCACION MATEMATICA ";
					}else if(opcionSeleccionada=="16"){
					    capa.innerHTML="COMPRENSION DEL MEDIO NATURAL, SOCIAL Y CULTURAL ";
					}else if(opcionSeleccionada=="17"){
					    capa.innerHTML="EDUCACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="18"){
					    capa.innerHTML="EDUCACION ARTISTICA ";
					}else if(opcionSeleccionada=="50005"){
					    capa.innerHTML="INGLES AVANZADO 3 ";
					}else if(opcionSeleccionada=="20"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DE LA NATURALEZA ";
					}else if(opcionSeleccionada=="21"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DE LA SOCIEDAD ";
					}else if(opcionSeleccionada=="22"){
					    capa.innerHTML="ORIENTACION ";
					}else if(opcionSeleccionada=="23"){
					    capa.innerHTML="HISTORIA UNIVERSAL Y GEOGRAFIA GENERAL ";
					}else if(opcionSeleccionada=="24"){
					    capa.innerHTML="EDUCACION CIVICA ";
					}else if(opcionSeleccionada=="25"){
					    capa.innerHTML="ECONOMIA POLITICA ";
					}else if(opcionSeleccionada=="26"){
					    capa.innerHTML="IDIOMA EXTRANJERO (FRANCES) ";
					}else if(opcionSeleccionada=="30"){
					    capa.innerHTML="TECNICAS ESPECIALES ";
					}else if(opcionSeleccionada=="31"){
					    capa.innerHTML="IDIOMA EXTRANJERO (ITALIANO) ";
					}else if(opcionSeleccionada=="32"){
					    capa.innerHTML="IDIOMA EXTRANJERO (ALEMAN) ";
					}else if(opcionSeleccionada=="33"){
					    capa.innerHTML="EDUCACION TECNICO MANUAL ";
					}else if(opcionSeleccionada=="34"){
					    capa.innerHTML="EDUCACION TECNICO MANUAL Y HUERTOS ESCOLARES ";
					}else if(opcionSeleccionada=="50011"){
					    capa.innerHTML="LENGUAJE PLUS ";
					}else if(opcionSeleccionada=="36"){
					    capa.innerHTML="IDIOMA EXTRANJERO II ";
					}else if(opcionSeleccionada=="37"){
					    capa.innerHTML="ARTES VISUALES O ARTES MUSICALES ";
					}else if(opcionSeleccionada=="38"){
					    capa.innerHTML="IDIOMA EXTRANJERO ";
					}else if(opcionSeleccionada=="39"){
					    capa.innerHTML="ECONOMIA ";
					}else if(opcionSeleccionada=="40"){
					    capa.innerHTML="EDUCACION CIVICA Y ECONOMIA ";
					}else if(opcionSeleccionada=="41"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA ";
					}else if(opcionSeleccionada=="42"){
					    capa.innerHTML="APRECIACION MUSICAL ";
					}else if(opcionSeleccionada=="43"){
					    capa.innerHTML="QUIMICA ELECTIVA ";
					}else if(opcionSeleccionada=="44"){
					    capa.innerHTML="TALLER TECNOLOGICO ";
					}else if(opcionSeleccionada=="45"){
					    capa.innerHTML="TALLER DE PROFUNDIZACION ";
					}else if(opcionSeleccionada=="46"){
					    capa.innerHTML="SEMINARIO ";
					}else if(opcionSeleccionada=="47"){
					    capa.innerHTML="DOCTRINA CRISTIANA ";
					}else if(opcionSeleccionada=="48"){
					    capa.innerHTML="QUIMICA I ";
					}else if(opcionSeleccionada=="49"){
					    capa.innerHTML="QUIMICA II ";
					}else if(opcionSeleccionada=="50"){
					    capa.innerHTML="ELECTIVO DE FISICA ";
					}else if(opcionSeleccionada=="51"){
					    capa.innerHTML="ELECTIVO DE QUIMICA ";
					}else if(opcionSeleccionada=="52"){
					    capa.innerHTML="ALEMAN AVANZADO ";
					}else if(opcionSeleccionada=="53"){
					    capa.innerHTML="FRANCES E INGLES AVANZADO EN EL LABORATORIO DE IDIOMAS ";
					}else if(opcionSeleccionada=="54"){
					    capa.innerHTML="COMPRENSION DE LECTURA ";
					}else if(opcionSeleccionada=="55"){
					    capa.innerHTML="COMPRENSION DEL IDIOMA ORAL ";
					}else if(opcionSeleccionada=="56"){
					    capa.innerHTML="COMPRENSION Y PRODUCCION DEL IDIOMA ORAL ";
					}else if(opcionSeleccionada=="57"){
					    capa.innerHTML="COMPRENSION DEL IDIOMA ESCRITO ";
					}else if(opcionSeleccionada=="58"){
					    capa.innerHTML="PANORAMA GENERAL DE LA PINTURA EN CHILE SIGLOS XVII, XVIII Y FINES DEL SIGLO XIX ";
					}else if(opcionSeleccionada=="59"){
					    capa.innerHTML="TALLER CERAMICO INSPIRADO EN LAS TRADICIONES ALFARERAS AUTOCTONAS DE CHILE Y AMERICA ANDINA ";
					}else if(opcionSeleccionada=="60"){
					    capa.innerHTML="NOCIONES BASICAS DE PUERICULTURA ";
					}else if(opcionSeleccionada=="61"){
					    capa.innerHTML="DISENO Y COSTRUCCION DE ESCENOGRAFIA PARA REPRESENTACIONES TEATRALES ";
					}else if(opcionSeleccionada=="62"){
					    capa.innerHTML="NOCIONES ELEMENTALES DE MECANICA DE MANTENCION DE MAQUINAS MOTRICES ";
					}else if(opcionSeleccionada=="63"){
					    capa.innerHTML="FUNDAMENTOS DE SISTEMAS Y TECNICAS DE USO COMERCIAL ";
					}else if(opcionSeleccionada=="64"){
					    capa.innerHTML="TALLER DE CREACIONES ARTESANAL ";
					}else if(opcionSeleccionada=="65"){
					    capa.innerHTML="TALLER DE MARROQUINERIA Y TALABARTERIA ";
					}else if(opcionSeleccionada=="66"){
					    capa.innerHTML="TALLER DE DISENO Y REALIZACION DE TRABAJOS TEXTILES ";
					}else if(opcionSeleccionada=="67"){
					    capa.innerHTML="MECANICA DE MAQUINAS DE ESCRIBIR ";
					}else if(opcionSeleccionada=="68"){
					    capa.innerHTML="TALLER DE DISENO, CORTE Y CONFECCION ";
					}else if(opcionSeleccionada=="69"){
					    capa.innerHTML="DISENO DE MOBILIARIO ";
					}else if(opcionSeleccionada=="70"){
					    capa.innerHTML="DISENO DE JARDINES ";
					}else if(opcionSeleccionada=="71"){
					    capa.innerHTML="TALLER DE GRABADOS ";
					}else if(opcionSeleccionada=="72"){
					    capa.innerHTML="TALLER DE INICIACION EN PRODUCCION DE MEDIOS AUDIOVISUALES ";
					}else if(opcionSeleccionada=="73"){
					    capa.innerHTML="TALLER DE EXPERIENCIAS ELECTROMECANICAS ";
					}else if(opcionSeleccionada=="74"){
					    capa.innerHTML="CANTO ESCOLAR ";
					}else if(opcionSeleccionada=="75"){
					    capa.innerHTML="LECTURA Y ESCRITURA ";
					}else if(opcionSeleccionada=="76"){
					    capa.innerHTML="ACTIVIDADES PARA ACADEMICAS ";
					}else if(opcionSeleccionada=="77"){
					    capa.innerHTML="GRAMATICA ";
					}else if(opcionSeleccionada=="78"){
					    capa.innerHTML="PENSAMIENTO LOGICO Y CREATIVO ";
					}else if(opcionSeleccionada=="79"){
					    capa.innerHTML="EXPERIENCIAS INTEGRADAS EN CIENCIAS Y TECNOLOGIA ";
					}else if(opcionSeleccionada=="80"){
					    capa.innerHTML="TALLERES EDUCATIVOS DE DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="81"){
					    capa.innerHTML="AREA MUSICAL ";
					}else if(opcionSeleccionada=="82"){
					    capa.innerHTML="EDUCACION PARA LA SALUD ";
					}else if(opcionSeleccionada=="83"){
					    capa.innerHTML="TALLER DE APLICACIONES DE LA MATEMATICA ";
					
					}else if(opcionSeleccionada=="84"){
					    capa.innerHTML="RECREACION DIRIGIDA ";
					}else if(opcionSeleccionada=="85"){
					    capa.innerHTML="TALLER DE MATEMATICA ";
					}else if(opcionSeleccionada=="86"){
					    capa.innerHTML="ORIENTACION CRISTIANA ";
					}else if(opcionSeleccionada=="87"){
					    capa.innerHTML="EXPLORANDO LA NATURALEZA ";
					}else if(opcionSeleccionada=="88"){
					    capa.innerHTML="LECTURA ";
					}else if(opcionSeleccionada=="89"){
					    capa.innerHTML="ESCRITURA ";
					}else if(opcionSeleccionada=="90"){
					    capa.innerHTML="INTRODUCCION A LA MUSICA ";
					}else if(opcionSeleccionada=="91"){
					    capa.innerHTML="TIEMPO DE LIBRE DISPOSICION ";
					}else if(opcionSeleccionada=="92"){
					    capa.innerHTML="HORAS ADICIONALES ";
					}else if(opcionSeleccionada=="93"){
					    capa.innerHTML="APLICACIONES ADMINISTRATIVAS ";
					}else if(opcionSeleccionada=="94"){
					    capa.innerHTML="TALLER DE INTRODUCCION DE ALIMENTACION ";
					}else if(opcionSeleccionada=="95"){
					    capa.innerHTML="TALLER DE INTRODUCCION A LA ACTIVIDAD TURISTICA ";
					}else if(opcionSeleccionada=="96"){
					    capa.innerHTML="TALLER DE FRANCES ";
					}else if(opcionSeleccionada=="97"){
					    capa.innerHTML="EXPRESION ORAL Y ESCRITA CASTELLANO ";
					}else if(opcionSeleccionada=="98"){
					    capa.innerHTML="RAZONAMIENTO VERBAL APLICADO ";
					}else if(opcionSeleccionada=="99"){
					    capa.innerHTML="RAZONAMIENTO VERBAL ";
					}else if(opcionSeleccionada=="100"){
					    capa.innerHTML="ACADEMIA CULTURA ALEMANA ";
					}else if(opcionSeleccionada=="101"){
					    capa.innerHTML="ACADEMIAS ";
					}else if(opcionSeleccionada=="102"){
					    capa.innerHTML="ACTUACION ";
					}else if(opcionSeleccionada=="103"){
					    capa.innerHTML="AEROBICA ";
					}else if(opcionSeleccionada=="104"){
					    capa.innerHTML="ANIMACION ";
					}else if(opcionSeleccionada=="105"){
					    capa.innerHTML="APOYO INFORMATICO ";
					}else if(opcionSeleccionada=="106"){
					    capa.innerHTML="APOYO PEDAGOGICO ";
					}else if(opcionSeleccionada=="107"){
					    capa.innerHTML="APRENDER A APRENDER ";
					}else if(opcionSeleccionada=="108"){
					    capa.innerHTML="APRENDER JUGANDO ";
					}else if(opcionSeleccionada=="109"){
					    capa.innerHTML="APRENDIZAJE SOCIAL ";
					}else if(opcionSeleccionada=="110"){
					    capa.innerHTML="ARITMETICA ";
					}else if(opcionSeleccionada=="111"){
					    capa.innerHTML="ARTE ";
					}else if(opcionSeleccionada=="112"){
					    capa.innerHTML="ARTE Y EDUCACION ";
					}else if(opcionSeleccionada=="113"){
					    capa.innerHTML="ARTE Y EDUCACION MUSICAL ";
					}else if(opcionSeleccionada=="114"){
					    capa.innerHTML="ARTES ";
					}else if(opcionSeleccionada=="115"){
					    capa.innerHTML="ARCHIVO Y CLASIFICACION BIBLIOGRAFICA ";
					}else if(opcionSeleccionada=="116"){
					    capa.innerHTML="TALLER MATEMATICA APLICADA ";
					}else if(opcionSeleccionada=="117"){
					    capa.innerHTML="ARTISTICA MUSICAL ";
					}else if(opcionSeleccionada=="118"){
					    capa.innerHTML="ARTISTICA PLASTICA ";
					}else if(opcionSeleccionada=="119"){
					    capa.innerHTML="AUDICION DIRIGIDA ";
					}else if(opcionSeleccionada=="120"){
					    capa.innerHTML="AUTODESARROLLO ";
					}else if(opcionSeleccionada=="121"){
					    capa.innerHTML="BADMINTON ";
					}else if(opcionSeleccionada=="122"){
					    capa.innerHTML="BAILE ";
					}else if(opcionSeleccionada=="123"){
					    capa.innerHTML="BIBLIOTECA ";
					}else if(opcionSeleccionada=="124"){
					    capa.innerHTML="CALCULO ";
					}else if(opcionSeleccionada=="125"){
					    capa.innerHTML="CAPELLANIA ";
					}else if(opcionSeleccionada=="126"){
					    capa.innerHTML="CASTILLO MAGICO ";
					}else if(opcionSeleccionada=="127"){
					    capa.innerHTML="CERAMICA ";
					}else if(opcionSeleccionada=="128"){
					    capa.innerHTML="CIENCIAS HISTORICAS ";
					}else if(opcionSeleccionada=="129"){
					    capa.innerHTML="CIENCIAS HUMANAS ";
					}else if(opcionSeleccionada=="130"){
					    capa.innerHTML="CIENCIAS INTEGRADAS ";
					}else if(opcionSeleccionada=="131"){
					    capa.innerHTML="CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="132"){
					    capa.innerHTML="COMPRENSION DEL MEDIO NATURAL ";
					}else if(opcionSeleccionada=="133"){
					    capa.innerHTML="COMPRENSION DEL MEDIO SOCIAL Y CULTURAL ";
					}else if(opcionSeleccionada=="134"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="135"){
					    capa.innerHTML="COMPUTACION DIDACTICA ";
					}else if(opcionSeleccionada=="136"){
					    capa.innerHTML="COMPUTACION E INFORMATICA ";
					}else if(opcionSeleccionada=="137"){
					    capa.innerHTML="COMPUTACION EDUCACIONAL ";
					}else if(opcionSeleccionada=="138"){
					    capa.innerHTML="COMPUTACION EDUCATIVA ";
					}else if(opcionSeleccionada=="139"){
					    capa.innerHTML="COMPUTACION INFORMATICA ";
					}else if(opcionSeleccionada=="140"){
					    capa.innerHTML="COMUNICACION ";
					}else if(opcionSeleccionada=="141"){
					    capa.innerHTML="COMUNICACION ORAL Y ESCRITA ";
					}else if(opcionSeleccionada=="142"){
					    capa.innerHTML="COMUNIDADES DE NINOS ";
					}else if(opcionSeleccionada=="143"){
					    capa.innerHTML="CONCEPTUALIZACION ";
					}else if(opcionSeleccionada=="144"){
					    capa.innerHTML="CONSEJO DE CURSO ";
					}else if(opcionSeleccionada=="145"){
					    capa.innerHTML="COSTURA Y PINTURA EN GENERO ";
					}else if(opcionSeleccionada=="146"){
					    capa.innerHTML="CREACION LITERARIA ";
					}else if(opcionSeleccionada=="147"){
					    capa.innerHTML="CREACION Y RECREACION ";
					}else if(opcionSeleccionada=="148"){
					    capa.innerHTML="CRECIMIENTO PERSONAL ";
					}else if(opcionSeleccionada=="149"){
					    capa.innerHTML="CRECIMIENTO Y DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="150"){
					    capa.innerHTML="CUENTA CUENTOS ";
					}else if(opcionSeleccionada=="151"){
					    capa.innerHTML="CULTURA ARABE ";
					}else if(opcionSeleccionada=="152"){
					    capa.innerHTML="CULTURA HEBREA ";
					}else if(opcionSeleccionada=="153"){
					    capa.innerHTML="CULTURA JUDIA ";
					}else if(opcionSeleccionada=="154"){
					    capa.innerHTML="CULTURA Y MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="155"){
					    capa.innerHTML="DANZA ";
					}else if(opcionSeleccionada=="156"){
					    capa.innerHTML="DANZA ACADEMICA ";
					}else if(opcionSeleccionada=="157"){
					    capa.innerHTML="DANZA MODERNA ";
					}else if(opcionSeleccionada=="158"){
					    capa.innerHTML="DEPORTE ";
					}else if(opcionSeleccionada=="159"){
					    capa.innerHTML="DEPORTE Y RECREACION ";
					}else if(opcionSeleccionada=="160"){
					    capa.innerHTML="DEPORTES ";
					}else if(opcionSeleccionada=="161"){
					    capa.innerHTML="DEPORTES (FUTBOL-BASQUETBOL-RITMICA-VOLEIBOL) ";
					}else if(opcionSeleccionada=="162"){
					    capa.innerHTML="DESARROLLO DE HABILIDADES ";
					}else if(opcionSeleccionada=="163"){
					    capa.innerHTML="DESARROLLO DE VIRTUDES HUMANAS ";
					}else if(opcionSeleccionada=="164"){
					    capa.innerHTML="DESARROLLO DEL PENSAMIENTO ";
					}else if(opcionSeleccionada=="165"){
					    capa.innerHTML="DESARROLLO DEL PENSAMIENTO LOGICO MATEMATICO ";
					}else if(opcionSeleccionada=="166"){
					    capa.innerHTML="DESARROLLO DESTREZAS INTELECTUALES ";
					}else if(opcionSeleccionada=="167"){
					    capa.innerHTML="DESARROLLO HABILIDAD DE LA INTELIGENCIA ";
					}else if(opcionSeleccionada=="168"){
					    capa.innerHTML="DESARROLLO HABILIDAD E INTERESES ";
					}else if(opcionSeleccionada=="169"){
					    capa.innerHTML="DESARROLLO MORAL ";
					}else if(opcionSeleccionada=="170"){
					    capa.innerHTML="DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="171"){
					    capa.innerHTML="DESARROLLO PERSONAL Y SOCIAL ";
					}else if(opcionSeleccionada=="172"){
					    capa.innerHTML="DESCUBRIENDO LA LITERATURA ";
					}else if(opcionSeleccionada=="173"){
					    capa.innerHTML="DIBUJO ";
					}else if(opcionSeleccionada=="174"){
					    capa.innerHTML="DISENO CONCEPTUAL ";
					}else if(opcionSeleccionada=="175"){
					    capa.innerHTML="ECOLOGIA ";
					}else if(opcionSeleccionada=="176"){
					    capa.innerHTML="EDUCACION A LA FE ";
					}else if(opcionSeleccionada=="177"){
					    capa.innerHTML="EDUCACION AL AMOR ";
					}else if(opcionSeleccionada=="178"){
					    capa.innerHTML="EDUCACION AMBIENTAL ";
					}else if(opcionSeleccionada=="179"){
					    capa.innerHTML="DACTILOGRAFIA Y TAQUIGRAFIA ";
					}else if(opcionSeleccionada=="180"){
					    capa.innerHTML="EDUCACION ARTISTICA MUSICAL Y PLASTICA ";
					}else if(opcionSeleccionada=="181"){
					    capa.innerHTML="EDUCACION ARTISTICA Y MUSICAL ";
					}else if(opcionSeleccionada=="182"){
					    capa.innerHTML="EDUCACION COMPUTACIONAL ";
					}else if(opcionSeleccionada=="183"){
					    capa.innerHTML="EDUCACION DE LA FE CATOLICA ";
					}else if(opcionSeleccionada=="184"){
					    capa.innerHTML="EDUCACION DEL RITMO Y LA AUDICION ";
					}else if(opcionSeleccionada=="185"){
					    capa.innerHTML="EDUCACION EN LA FE ";
					}else if(opcionSeleccionada=="186"){
					    capa.innerHTML="EDUCACION FISICA Y DEPORTES ";
					}else if(opcionSeleccionada=="187"){
					    capa.innerHTML="EDUCACION FISICA Y FOLKLORE ";
					}else if(opcionSeleccionada=="188"){
					    capa.innerHTML="EDUCACION INSTRUMENTAL ";
					}else if(opcionSeleccionada=="189"){
					    capa.innerHTML="EDUCACION INTERCULTURAL ";
					}else if(opcionSeleccionada=="190"){
					    capa.innerHTML="EDUCACION MATEMATICA Y GEOMETRIA ";
					}else if(opcionSeleccionada=="191"){
					    capa.innerHTML="EDUCACION PARA EL APRENDIZAJE ";
					}else if(opcionSeleccionada=="192"){
					    capa.innerHTML="EDUCACION PARA EL HOGAR ";
					}else if(opcionSeleccionada=="193"){
					    capa.innerHTML="EDUCACION PARA LA FAMILIA ";
					}else if(opcionSeleccionada=="194"){
					    capa.innerHTML="EDUCACION PARA LA VIDA ";
					}else if(opcionSeleccionada=="195"){
					    capa.innerHTML="EDUCACION PARA LA VIDA EN SOCIEDAD ";
					}else if(opcionSeleccionada=="196"){
					    capa.innerHTML="EDUCACION PLASTICA ";
					}else if(opcionSeleccionada=="197"){
					    capa.innerHTML="EDUCACION RITMICA CORPORAL ";
					}else if(opcionSeleccionada=="198"){
					    capa.innerHTML="EDUCACION RITMICO ";
					}else if(opcionSeleccionada=="199"){
					    capa.innerHTML="EDUCACION TECNOLOGICA E INTRODUCCION A LA COMPUTACION ";
					}else if(opcionSeleccionada=="200"){
					    capa.innerHTML="EDUCACION TECNOLOGICA Y COMPUTACION ";
					}else if(opcionSeleccionada=="201"){
					    capa.innerHTML="EDUCACION TECNOLOGICA Y COMPUTACION EDUCACIONAL ";
					}else if(opcionSeleccionada=="202"){
					    capa.innerHTML="EDUCAR EN EL PENSAR ";
					}else if(opcionSeleccionada=="203"){
					    capa.innerHTML="ELECTRICIDAD ";
					}else if(opcionSeleccionada=="204"){
					    capa.innerHTML="ENJOY WITH ENGLISH ";
					}else if(opcionSeleccionada=="205"){
					    capa.innerHTML="ESPIRITUALIDAD FRANCISCANA ";
					}else if(opcionSeleccionada=="206"){
					    capa.innerHTML="ESQUEMA CORPORAL ";
					}else if(opcionSeleccionada=="207"){
					    capa.innerHTML="ESTRUCTURACION TEMPORAL ESPECIAL ";
					}else if(opcionSeleccionada=="208"){
					    capa.innerHTML="ESTUDIO DIRIGIDO ";
					}else if(opcionSeleccionada=="209"){
					    capa.innerHTML="ESTUDIO Y TAREAS ";
					}else if(opcionSeleccionada=="210"){
					    capa.innerHTML="EXPRESION GRAFICA ";
					}else if(opcionSeleccionada=="211"){
					    capa.innerHTML="EXPRESION ";
					}else if(opcionSeleccionada=="212"){
					    capa.innerHTML="EXPRESION ARTISTICA ";
					}else if(opcionSeleccionada=="213"){
					    capa.innerHTML="EXPRESION CORPORAL ";
					}else if(opcionSeleccionada=="214"){
					    capa.innerHTML="NOCIONES DE COMERCIALIZACION ";
					}else if(opcionSeleccionada=="215"){
					    capa.innerHTML="EXPRESION INTEGRAL ";
					}else if(opcionSeleccionada=="216"){
					    capa.innerHTML="EXPRESION MUSICAL ";
					}else if(opcionSeleccionada=="217"){
					    capa.innerHTML="EXPRESION PLASTICA ";
					}else if(opcionSeleccionada=="218"){
					    capa.innerHTML="FILOSOFIA ESCOLAR ";
					}else if(opcionSeleccionada=="219"){
					    capa.innerHTML="FILOSOFIA PARA NINOS ";
					}else if(opcionSeleccionada=="220"){
					    capa.innerHTML="FILOSOFIA Y PENSAMIENTO DEL NINO ";
					}else if(opcionSeleccionada=="221"){
					    capa.innerHTML="FOLKLORE ";
					}else if(opcionSeleccionada=="222"){
					    capa.innerHTML="FORMA Y COLOR ";
					}else if(opcionSeleccionada=="223"){
					    capa.innerHTML="FORMA Y ESPACIO ";
					}else if(opcionSeleccionada=="224"){
					    capa.innerHTML="FORMACION ";
					}else if(opcionSeleccionada=="225"){
					    capa.innerHTML="FORMACION CRISTIANA ";
					}else if(opcionSeleccionada=="226"){
					    capa.innerHTML="FORMACION DE HABITOS ";
					}else if(opcionSeleccionada=="227"){
					    capa.innerHTML="FORMACION DE PRINCIPIOS ";
					}else if(opcionSeleccionada=="228"){
					    capa.innerHTML="FORMACION DE PRINCIPIOS Y VALORES ";
					}else if(opcionSeleccionada=="229"){
					    capa.innerHTML="FORMACION HUMANA ";
					}else if(opcionSeleccionada=="230"){
					    capa.innerHTML="FORMACION PERSONAL Y CIVICA ";
					}else if(opcionSeleccionada=="231"){
					    capa.innerHTML="FORMACION PERSONAL Y DESARROLLO DE HABILIDADES ";
					}else if(opcionSeleccionada=="232"){
					    capa.innerHTML="FORMACION RELIGIOSA ";
					}else if(opcionSeleccionada=="233"){
					    capa.innerHTML="FORMACION SOCIAL Y APOYO A LA SOCIEDAD ";
					}else if(opcionSeleccionada=="234"){
					    capa.innerHTML="GEOMETRIA ";
					}else if(opcionSeleccionada=="235"){
					    capa.innerHTML="GEOMETRIA ELEMENTAL ";
					}else if(opcionSeleccionada=="236"){
					    capa.innerHTML="GIMNASIA ARTISTICA ";
					}else if(opcionSeleccionada=="237"){
					    capa.innerHTML="GIMNASIA DEPORTIVA ";
					}else if(opcionSeleccionada=="238"){
					    capa.innerHTML="GRABADO ";
					}else if(opcionSeleccionada=="239"){
					    capa.innerHTML="GRAFICA PUBLICITARIA ";
					}else if(opcionSeleccionada=="240"){
					    capa.innerHTML="GUITARRA ";
					}else if(opcionSeleccionada=="241"){
					    capa.innerHTML="HABILIDADES, DESTREZAS, METODOS Y TECNICAS DE ESTUDIO ";
					}else if(opcionSeleccionada=="242"){
					    capa.innerHTML="HABITOS ";
					}else if(opcionSeleccionada=="243"){
					    capa.innerHTML="HABITOS DE ESTUDIO ";
					}else if(opcionSeleccionada=="244"){
					    capa.innerHTML="HISTORIA DEL ARTE ";
					}else if(opcionSeleccionada=="245"){
					    capa.innerHTML="HISTORIA JUDIA Y BIBLIA ";
					}else if(opcionSeleccionada=="246"){
					    capa.innerHTML="HISTORIA PATRIA Y DEL EJERCITO ";
					}else if(opcionSeleccionada=="247"){
					    capa.innerHTML="HISTORIA TEATRAL CHILENA ";
					}else if(opcionSeleccionada=="248"){
					    capa.innerHTML="IDIOMA EXTRANJERO ARABE ";
					}else if(opcionSeleccionada=="249"){
					    capa.innerHTML="IDIOMA EXTRANJERO INGLES ";
					}else if(opcionSeleccionada=="250"){
					    capa.innerHTML="INFORMATICA ";
					}else if(opcionSeleccionada=="251"){
					    capa.innerHTML="INFORMATICA APLICADA ";
					}else if(opcionSeleccionada=="252"){
					    capa.innerHTML="INFORMATICA EDUCATIVA ";
					}else if(opcionSeleccionada=="253"){
					    capa.innerHTML="INFORMATICA Y COMPUTACION ";
					}else if(opcionSeleccionada=="254"){
					    capa.innerHTML="INGLES ";
					}else if(opcionSeleccionada=="255"){
					    capa.innerHTML="INICIACION A LOS METALES ";
					}else if(opcionSeleccionada=="256"){
					    capa.innerHTML="INICIACION AL TELAR ";
					}else if(opcionSeleccionada=="257"){
					    capa.innerHTML="INICIACION DE LOS METALES ";
					}else if(opcionSeleccionada=="258"){
					    capa.innerHTML="INSTRUMENTO MUSICAL ";
					}else if(opcionSeleccionada=="259"){
					    capa.innerHTML="INSTRUMENTO MUSICAL COMPLEMENTARIO ";
					}else if(opcionSeleccionada=="260"){
					    capa.innerHTML="INSTRUMENTO PRINCIPAL ";
					}else if(opcionSeleccionada=="261"){
					    capa.innerHTML="INTERCULTURAL ";
					}else if(opcionSeleccionada=="262"){
					    capa.innerHTML="INTERDISCIPLINARIO ";
					}else if(opcionSeleccionada=="263"){
					    capa.innerHTML="INTRODUCCION A LA COMPUTACION ";
					}else if(opcionSeleccionada=="264"){
					    capa.innerHTML="INVESTIGACION SOBRE TIPOS HUMANOS ";
					}else if(opcionSeleccionada=="265"){
					    capa.innerHTML="LABORATORIO AMBIENTE DE APRENDIZAJE ";
					}else if(opcionSeleccionada=="266"){
					    capa.innerHTML="LABORATORIO CIENTIFICO CREATIVO ";
					}else if(opcionSeleccionada=="267"){
					    capa.innerHTML="LABORATORIO DE DACTILOGRAFIA ";
					}else if(opcionSeleccionada=="268"){
					    capa.innerHTML="LABORATORIO DE GRAMATICA EXPRESIVA ";
					}else if(opcionSeleccionada=="269"){
					    capa.innerHTML="LABORATORIO MINICIENTIFICO ";
					}else if(opcionSeleccionada=="270"){
					    capa.innerHTML="LATIN ";
					}else if(opcionSeleccionada=="271"){
					    capa.innerHTML="LECTURA COMPRENSIVA ";
					}else if(opcionSeleccionada=="272"){
					    capa.innerHTML="LECTURA Y REDACCION ";
					}else if(opcionSeleccionada=="273"){
					    capa.innerHTML="LENGUAJE HEBREO Y CULTURA JUDIA ";
					}else if(opcionSeleccionada=="274"){
					    capa.innerHTML="LITERATURA ";
					}else if(opcionSeleccionada=="275"){
					    capa.innerHTML="LITURGIA ";
					}else if(opcionSeleccionada=="276"){
					    capa.innerHTML="LOGICA ";
					}else if(opcionSeleccionada=="277"){
					    capa.innerHTML="LOS RECURSOS NATURALES BASICOS Y SU INTEGRACION A LA INDUSTRIA";
					}else if(opcionSeleccionada=="278"){
					    capa.innerHTML="MANUALIDADES ";
					}else if(opcionSeleccionada=="279"){
					    capa.innerHTML="MANUALIDADES TALLERES ";
					}else if(opcionSeleccionada=="280"){
					    capa.innerHTML="MATEMATICA CREATIVA ";
					}else if(opcionSeleccionada=="281"){
					    capa.innerHTML="MATEMATICA RECREATIVA APLICADA ";
					}else if(opcionSeleccionada=="282"){
					    capa.innerHTML="MATEMATICAS RECREATIVAS Y APLICADA ";
					}else if(opcionSeleccionada=="283"){
					    capa.innerHTML="MIMO ";
					}else if(opcionSeleccionada=="284"){
					    capa.innerHTML="MODELADO ";
					}else if(opcionSeleccionada=="285"){
					    capa.innerHTML="MODELO ";
					}else if(opcionSeleccionada=="286"){
					    capa.innerHTML="MOVIMIENTO Y EXPRESION ";
					}else if(opcionSeleccionada=="287"){
					    capa.innerHTML="MULTITALLER ";
					}else if(opcionSeleccionada=="288"){
					    capa.innerHTML="MUSICA ";
					}else if(opcionSeleccionada=="289"){
					    capa.innerHTML="MUSICAL ";
					}else if(opcionSeleccionada=="290"){
					    capa.innerHTML="NINOS LECTORES ";
					}else if(opcionSeleccionada=="291"){
					    capa.innerHTML="NINOS PENSANDO Y CREANDO ";
					}else if(opcionSeleccionada=="292"){
					    capa.innerHTML="NUTRICION APLICADA ";
					}else if(opcionSeleccionada=="293"){
					    capa.innerHTML="OPCIONALES ";
					}else if(opcionSeleccionada=="294"){
					    capa.innerHTML="ORFEBRERIA ";
					}else if(opcionSeleccionada=="295"){
					    capa.innerHTML="INVESTIGACION SOBRE TIPOS HUMANOS EN LA LITERATURA ";
					}else if(opcionSeleccionada=="296"){
					    capa.innerHTML="ORIENTACION TUTORIAL ";
					}else if(opcionSeleccionada=="297"){
					    capa.innerHTML="ORIENTACION VALORICA ";
					}else if(opcionSeleccionada=="298"){
					    capa.innerHTML="ORIENTACION Y CONSEJO ";
					}else if(opcionSeleccionada=="299"){
					    capa.innerHTML="ORIENTACION Y CONSEJO DE CURSO ";
					}else if(opcionSeleccionada=="300"){
					    capa.innerHTML="ORIENTACION Y CRECIMIENTO PERSONAL ";
					}else if(opcionSeleccionada=="301"){
					    capa.innerHTML="ORIENTACION Y DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="302"){
					    capa.innerHTML="ORIENTACION Y FORMACION VALORICA ";
					}else if(opcionSeleccionada=="303"){
					    capa.innerHTML="ORIENTACION Y SOCIEDAD DE MENORES ";
					}else if(opcionSeleccionada=="304"){
					    capa.innerHTML="ORIENTACION DESARROLLO PERSONAL Y AUTOESTIMA ";
					}else if(opcionSeleccionada=="305"){
					    capa.innerHTML="ORIENTACION DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="306"){
					    capa.innerHTML="PARTICIPACION SOCIAL ";
					}else if(opcionSeleccionada=="307"){
					    capa.innerHTML="PENSAMIENTO Y CAUTIVIDAD ";
					}else if(opcionSeleccionada=="308"){
					    capa.innerHTML="PENSAMIENTO Y CREATIVIDAD ";
					}else if(opcionSeleccionada=="309"){
					    capa.innerHTML="PIANO COMPLEMENTARIO ";
					}else if(opcionSeleccionada=="310"){
					    capa.innerHTML="PINTURA ";
					}else if(opcionSeleccionada=="311"){
					    capa.innerHTML="PLAN ELECTIVO ";
					}else if(opcionSeleccionada=="312"){
					    capa.innerHTML="PLASTICA ";
					}else if(opcionSeleccionada=="313"){
					    capa.innerHTML="PLASTICA MANUAL ";
					}else if(opcionSeleccionada=="314"){
					    capa.innerHTML="PRACTICA DE CONJUNTO ";
					}else if(opcionSeleccionada=="315"){
					    capa.innerHTML="PREPARACION CIUDADANA ";
					}else if(opcionSeleccionada=="316"){
					    capa.innerHTML="PROGRAMA ENRIQUECIMIENTO INDUSTRIAL ";
					}else if(opcionSeleccionada=="317"){
					    capa.innerHTML="PROGRAMA ENRIQUECIMIENTO INSTRUMENTAL ";
					}else if(opcionSeleccionada=="318"){
					    capa.innerHTML="PSICOMOTRICIADAD ";
					}else if(opcionSeleccionada=="319"){
					    capa.innerHTML="RECREACION Y DEPORTES ";
					}else if(opcionSeleccionada=="320"){
					    capa.innerHTML="RECREO COMPARTIDO ";
					}else if(opcionSeleccionada=="321"){
					    capa.innerHTML="RECREO DIRIGIDO ";
					}else if(opcionSeleccionada=="322"){
					    capa.innerHTML="REFLEXION ESPIRITUAL ";
					}else if(opcionSeleccionada=="323"){
					    capa.innerHTML="REFORZAMIENTO ";
					}else if(opcionSeleccionada=="324"){
					    capa.innerHTML="RELIGION (ACTIVIDAD PASTORAL) ";
					}else if(opcionSeleccionada=="325"){
					    capa.innerHTML="RELIGION JUDIA ";
					}else if(opcionSeleccionada=="326"){
					    capa.innerHTML="RELIGION Y FORMACION ";
					}else if(opcionSeleccionada=="327"){
					    capa.innerHTML="REPORTE ";
					}else if(opcionSeleccionada=="328"){
					    capa.innerHTML="SALUD ";
					}else if(opcionSeleccionada=="329"){
					    capa.innerHTML="SOCIALIZACION Y AUTOESTIMA ";
					}else if(opcionSeleccionada=="330"){
					    capa.innerHTML="TALLER ";
					}else if(opcionSeleccionada=="331"){
					    capa.innerHTML="TALLER ARTISTICO PLASTICO ";
					}else if(opcionSeleccionada=="332"){
					    capa.innerHTML="TALLER CIENTIFICO ";
					}else if(opcionSeleccionada=="333"){
					    capa.innerHTML="TALLER COMPLEMENTARIO ";
					}else if(opcionSeleccionada=="334"){
					    capa.innerHTML="TALLER COMPUTACION ";
					}else if(opcionSeleccionada=="335"){
					    capa.innerHTML="TALLER COREOGRAFICO ACADEMICO ";
					}else if(opcionSeleccionada=="336"){
					    capa.innerHTML="TALLER CRECIMIENTO PERSONAL ";
					}else if(opcionSeleccionada=="337"){
					    capa.innerHTML="TALLER DE ARQUIMEDES ";
					}else if(opcionSeleccionada=="338"){
					    capa.innerHTML="TALLER DE ARTES PLASTICAS ";
					}else if(opcionSeleccionada=="339"){
					    capa.innerHTML="TALLER DE AVANCE ";
					}else if(opcionSeleccionada=="340"){
					    capa.innerHTML="TALLER DE BAILE ";
					}else if(opcionSeleccionada=="341"){
					    capa.innerHTML="TALLER DE BIOLOGIA ";
					}else if(opcionSeleccionada=="342"){
					    capa.innerHTML="TALLER DE CALCULO ";
					}else if(opcionSeleccionada=="343"){
					    capa.innerHTML="TALLER DE CALIGRAFIA Y ESCRITURA CREATIVA ";
					}else if(opcionSeleccionada=="344"){
					    capa.innerHTML="TALLER DE CANTO ";
					}else if(opcionSeleccionada=="345"){
					    capa.innerHTML="TALLER DE CASTELLANO ";
					}else if(opcionSeleccionada=="346"){
					    capa.innerHTML="TALLER DE DESARROLLO DEL PENSAMIENTO ";
					}else if(opcionSeleccionada=="347"){
					    capa.innerHTML="TALLER DE EDUCACION MUSICAL ";
					}else if(opcionSeleccionada=="348"){
					    capa.innerHTML="TALLER DE ESPIRITUALIDAD SALESIANA ";
					}else if(opcionSeleccionada=="349"){
					    capa.innerHTML="TALLER DE ESTUDIOS Y TAREAS ";
					}else if(opcionSeleccionada=="350"){
					    capa.innerHTML="TALLER DE FOLKLORE ";
					}else if(opcionSeleccionada=="351"){
					    capa.innerHTML="TALLER DE FORMACION DE HABITOS ";
					}else if(opcionSeleccionada=="352"){
					    capa.innerHTML="TALLER DE GEOMETRIA ";
					}else if(opcionSeleccionada=="353"){
					    capa.innerHTML="TALLER DE HABILIDADES PREDEFINIDOS ";
					}else if(opcionSeleccionada=="354"){
					    capa.innerHTML="TALLER DE INGLES ";
					}else if(opcionSeleccionada=="355"){
					    capa.innerHTML="TALLER DE INICIACION A LA COMPUTACION ";
					}else if(opcionSeleccionada=="356"){
					    capa.innerHTML="TALLER DE INICIACION DE ACTIVIDAD ";
					}else if(opcionSeleccionada=="357"){
					    capa.innerHTML="TALLER DE INTEGRACION ";
					}else if(opcionSeleccionada=="358"){
					    capa.innerHTML="TALLER DE LA CIUDAD ";
					}else if(opcionSeleccionada=="359"){
					    capa.innerHTML="TALLER DE LECTURA ";
					}else if(opcionSeleccionada=="360"){
					    capa.innerHTML="TALLER DE LECTURA Y REDACCION ";
					}else if(opcionSeleccionada=="361"){
					    capa.innerHTML="TALLER DE OPTICA ";
					}else if(opcionSeleccionada=="362"){
					    capa.innerHTML="TALLER DE PRINCIPIO DE ARQUIMEDES ";
					}else if(opcionSeleccionada=="363"){
					    capa.innerHTML="TALLER DE RECREACION ";
					}else if(opcionSeleccionada=="364"){
					    capa.innerHTML="TALLER DE REPOSTERIA ";
					}else if(opcionSeleccionada=="365"){
					    capa.innerHTML="TALLER DE TEATRO ";
					}else if(opcionSeleccionada=="366"){
					    capa.innerHTML="TALLER DEPORTIVO ";
					}else if(opcionSeleccionada=="367"){
					    capa.innerHTML="TALLER EDUCACION AMBIENTAL ";
					}else if(opcionSeleccionada=="368"){
					    capa.innerHTML="TALLER ELECTIVO ";
					}else if(opcionSeleccionada=="369"){
					    capa.innerHTML="TALLER ESTUDIOS Y TAREAS ";
					}else if(opcionSeleccionada=="370"){
					    capa.innerHTML="TALLER FILOSOFIA ";
					}else if(opcionSeleccionada=="371"){
					    capa.innerHTML="TALLER FILOSOFIA PARA NINOS ";
					}else if(opcionSeleccionada=="372"){
					    capa.innerHTML="TALLER GIMNASIA RITMICA ";
					}else if(opcionSeleccionada=="373"){
					    capa.innerHTML="TALLER HISTORIA Y GEOGRAFIA ";
					}else if(opcionSeleccionada=="374"){
					    capa.innerHTML="TALLER HUERTO ";
					}else if(opcionSeleccionada=="375"){
					    capa.innerHTML="TALLER INFORMATICA ";
					}else if(opcionSeleccionada=="376"){
					    capa.innerHTML="TALLER INTEGRADO ";
					}else if(opcionSeleccionada=="377"){
					    capa.innerHTML="TALLER INTEGRADO DE SALUD Y ECOLOGIA ";
					}else if(opcionSeleccionada=="378"){
					    capa.innerHTML="TALLER MUSICA FOLKLORICA ";
					}else if(opcionSeleccionada=="379"){
					    capa.innerHTML="TALLER MUSICO FOLKLORICO ";
					}else if(opcionSeleccionada=="380"){
					    capa.innerHTML="TALLER PLASTICO MANUAL ";
					}else if(opcionSeleccionada=="381"){
					    capa.innerHTML="TALLER REPOSTERIA ";
					}else if(opcionSeleccionada=="382"){
					    capa.innerHTML="TALLERES ";
					}else if(opcionSeleccionada=="383"){
					    capa.innerHTML="TALLERES ARTISTICOS ";
					}else if(opcionSeleccionada=="384"){
					    capa.innerHTML="TALLERES CIENTIFICOS ";
					}else if(opcionSeleccionada=="385"){
					    capa.innerHTML="TALLERES COMPLEMENTARIOS ";
					}else if(opcionSeleccionada=="386"){
					    capa.innerHTML="TALLERES DE APRENDIZAJE ";
					}else if(opcionSeleccionada=="387"){
					    capa.innerHTML="TALLERES DE COMPUTACION ";
					}else if(opcionSeleccionada=="388"){
					    capa.innerHTML="TALLERES DE EXPLORACION ARTISTICA ";
					}else if(opcionSeleccionada=="389"){
					    capa.innerHTML="TALLERES DE LIBRE ELECCION ";
					}else if(opcionSeleccionada=="390"){
					    capa.innerHTML="TALLERES DEPORTIVOS ";
					}else if(opcionSeleccionada=="391"){
					    capa.innerHTML="TALLERES EXPLORACION ARTISTICA ";
					}else if(opcionSeleccionada=="392"){
					    capa.innerHTML="TALLERES LECTO-ESCRITURA ";
					}else if(opcionSeleccionada=="393"){
					    capa.innerHTML="TALLERES Y ACADEMIAS ";
					}else if(opcionSeleccionada=="394"){
					    capa.innerHTML="TAREAS Y TRABAJO ";
					}else if(opcionSeleccionada=="395"){
					    capa.innerHTML="TEATRO ";
					}else if(opcionSeleccionada=="396"){
					    capa.innerHTML="TEATRO Y EXPRESION CORPORAL ";
					}else if(opcionSeleccionada=="397"){
					    capa.innerHTML="TECNICA Y MANEJO DE LA VOZ ";
					}else if(opcionSeleccionada=="398"){
					    capa.innerHTML="TECNICAS MANUALES Y COMPUTACION ";
					}else if(opcionSeleccionada=="399"){
					    capa.innerHTML="TECNICAS Y ESTUDIO DIRIGIDO ";
					}else if(opcionSeleccionada=="400"){
					    capa.innerHTML="TECNICO MANUAL ";
					}else if(opcionSeleccionada=="401"){
					    capa.innerHTML="TECNOLOGIA COMPUTACIONAL ";
					}else if(opcionSeleccionada=="402"){
					    capa.innerHTML="TECNOLOGIA Y COMPUTACION ";
					}else if(opcionSeleccionada=="403"){
					    capa.innerHTML="TELAR ";
					}else if(opcionSeleccionada=="404"){
					    capa.innerHTML="TEOLOGIA ";
					}else if(opcionSeleccionada=="405"){
					    capa.innerHTML="TEOLOGIA Y FILOSOFIA ";
					}else if(opcionSeleccionada=="406"){
					    capa.innerHTML="TEORIA Y BIBLIA ";
					}else if(opcionSeleccionada=="407"){
					    capa.innerHTML="TEORIA Y SOLFEO ";
					}else if(opcionSeleccionada=="408"){
					    capa.innerHTML="VIDA CRISTIANA ";
					}else if(opcionSeleccionada=="409"){
					    capa.innerHTML="VIOLIN ";
					}else if(opcionSeleccionada=="410"){
					    capa.innerHTML="ATLETISMO ";
					}else if(opcionSeleccionada=="411"){
					    capa.innerHTML="HISTORIA ";
					}else if(opcionSeleccionada=="412"){
					    capa.innerHTML="CIENCIAS ";
					}else if(opcionSeleccionada=="413"){
					    capa.innerHTML="RELIGION CATOLICA ";
					}else if(opcionSeleccionada=="414"){
					    capa.innerHTML="DESARROLLO ";
					}else if(opcionSeleccionada=="415"){
					    capa.innerHTML="ORIENTACION ESTUDIO DIRIGIDO ";
					}else if(opcionSeleccionada=="416"){
					    capa.innerHTML="ORIENTACION TALLER ";
					}else if(opcionSeleccionada=="417"){
					    capa.innerHTML="TALLER DE APRENDIZAJE ";
					}else if(opcionSeleccionada=="418"){
					    capa.innerHTML="CIENCIAS HISTORICAS Y SOCIALES ";
					}else if(opcionSeleccionada=="419"){
					    capa.innerHTML="PROGRAMA DE ENRIQUECIMIENTO FUNDAMENTAL ";
					}else if(opcionSeleccionada=="420"){
					    capa.innerHTML="ESCRITURA CREATIVA ";
					}else if(opcionSeleccionada=="421"){
					    capa.innerHTML="COMPUTACION APLICADA ";
					}else if(opcionSeleccionada=="422"){
					    capa.innerHTML="DESARROLLO PERSONAL Y APOYO PEDAGOGICO ";
					}else if(opcionSeleccionada=="423"){
					    capa.innerHTML="TALLER DE COMPUTACION DIDACTICA ";
					}else if(opcionSeleccionada=="424"){
					    capa.innerHTML="TALLER MUSICAL ";
					}else if(opcionSeleccionada=="425"){
					    capa.innerHTML="FORMACION INTEGRAL ";
					}else if(opcionSeleccionada=="426"){
					    capa.innerHTML="EDUCACION FISICA Y EDUCACION PARA LA SALUD ";
					}else if(opcionSeleccionada=="427"){
					    capa.innerHTML="DESARROLLO PERSONAL Y AUTOESTIMA ";
					}else if(opcionSeleccionada=="428"){
					    capa.innerHTML="TALLER DE LECTURA Y ESCRITURA ";
					}else if(opcionSeleccionada=="429"){
					    capa.innerHTML="ARTE ESCENICO ";
					}else if(opcionSeleccionada=="430"){
					    capa.innerHTML="TALLER DE CREACION LITERARIA ";
					}else if(opcionSeleccionada=="431"){
					    capa.innerHTML="TALLER DE DESARROLLO CIENTIFICO ";
					}else if(opcionSeleccionada=="432"){
					    capa.innerHTML="TALLER DEPORTIVO FORMACION FISICA BASICA ";
					}else if(opcionSeleccionada=="433"){
					    capa.innerHTML="ORIENTACION Y DESARROLLO PERSONAL Y SOCIAL ";
					}else if(opcionSeleccionada=="434"){
					    capa.innerHTML="TALLER DE IDIOMAS ";
					}else if(opcionSeleccionada=="435"){
					    capa.innerHTML="TALLER DE ARTES ";
					}else if(opcionSeleccionada=="436"){
					    capa.innerHTML="ESTRUCTURAS METALICAS ";
					}else if(opcionSeleccionada=="437"){
					    capa.innerHTML="TALLER ESCRITURA CREATIVA ";
					}else if(opcionSeleccionada=="438"){
					    capa.innerHTML="TECNOLOGIA TECNICO MANUAL ";
					}else if(opcionSeleccionada=="439"){
					    capa.innerHTML="ORIENTACION Y APOYO PEDAGOGICO ";
					}else if(opcionSeleccionada=="440"){
					    capa.innerHTML="EDUCACION ARTISTICA PLASTICA ";
					}else if(opcionSeleccionada=="441"){
					    capa.innerHTML="EDUCACION ARTISTICA: MUSICA ";
					}else if(opcionSeleccionada=="442"){
					    capa.innerHTML="TALLER DE INICIACION EN ARTES APLICADAS ";
					}else if(opcionSeleccionada=="443"){
					    capa.innerHTML="TALLER Y LABORATORIO DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="444"){
					    capa.innerHTML="TECNOLOGIA DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="445"){
					    capa.innerHTML="HIGIENE Y PREVENCION DE RIESGOS ";
					}else if(opcionSeleccionada=="446"){
					    capa.innerHTML="TALLER DE APRESTO DE EDUCACION TECNICA ";
					}else if(opcionSeleccionada=="447"){
					    capa.innerHTML="CONTABILIDAD ";
					}else if(opcionSeleccionada=="448"){
					    capa.innerHTML="DERECHO COMERCIAL ";
					}else if(opcionSeleccionada=="449"){
					    capa.innerHTML="DACTILOGRAFIA Y REDACCION ";
					}else if(opcionSeleccionada=="450"){
					    capa.innerHTML="TALLER DE DESARROLLO PERSONAL Y VALORICO ";
					}else if(opcionSeleccionada=="451"){
					    capa.innerHTML="LABORATORIO DE EJECUCION ";
					}else if(opcionSeleccionada=="452"){
					    capa.innerHTML="INTRODUCCION A LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="453"){
					    capa.innerHTML="OBLIGATORIOS ";
					}else if(opcionSeleccionada=="454"){
					    capa.innerHTML="DE PASTORAL ";
					}else if(opcionSeleccionada=="455"){
					    capa.innerHTML="ROTATORIOS ";
					}else if(opcionSeleccionada=="456"){
					    capa.innerHTML="TALLER DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="457"){
					    capa.innerHTML="COMERCIALIZACION ";
					}else if(opcionSeleccionada=="458"){
					    capa.innerHTML="REDACCION ";
					}else if(opcionSeleccionada=="459"){
					    capa.innerHTML="EXPLORACION GRAFICA ";
					}else if(opcionSeleccionada=="460"){
					    capa.innerHTML="APLICACION COMPUTACION ";
					}else if(opcionSeleccionada=="461"){
					    capa.innerHTML="ACTIVIDADES ELECTIVAS ";
					}else if(opcionSeleccionada=="462"){
					    capa.innerHTML="FORMACION PERSONAL ";
					}else if(opcionSeleccionada=="463"){
					    capa.innerHTML="ORIENTACION PROFESIONAL ";
					}else if(opcionSeleccionada=="464"){
					    capa.innerHTML="TALLER DE COMPUTACION ";
					}else if(opcionSeleccionada=="465"){
					    capa.innerHTML="TALLER VOCACIONAL Y PROFESIONAL ";
					}else if(opcionSeleccionada=="466"){
					    capa.innerHTML="EXPRESION HUMANA ";
					}else if(opcionSeleccionada=="467"){
					    capa.innerHTML="TALLERES ELECTIVOS ";
					}else if(opcionSeleccionada=="468"){
					    capa.innerHTML="ORIENTACION PERSONAL ";
					}else if(opcionSeleccionada=="469"){
					    capa.innerHTML="ETICA PROFESIONAL ";
					}else if(opcionSeleccionada=="470"){
					    capa.innerHTML="RELACIONES HUMANAS ";
					}else if(opcionSeleccionada=="471"){
					    capa.innerHTML="INGLES APLICADO ";
					}else if(opcionSeleccionada=="472"){
					    capa.innerHTML="MERCADOTECNIA ";
					}else if(opcionSeleccionada=="473"){
					    capa.innerHTML="DESARROLLO PENSAMIENTO OCCIDENTAL ";
					}else if(opcionSeleccionada=="474"){
					    capa.innerHTML="ETICA Y DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="475"){
					    capa.innerHTML="TALLER DE ESTUDIO ";
					}else if(opcionSeleccionada=="476"){
					    capa.innerHTML="INTRODUCCION AL MUNDO DEL TRABAJO ";
					}else if(opcionSeleccionada=="477"){
					    capa.innerHTML="LA ARQUITECTURA COLONIAL CHILENA Y SUS RAICES ";
					}else if(opcionSeleccionada=="478"){
					    capa.innerHTML="DESARROLLO INTEGRAL ";
					}else if(opcionSeleccionada=="479"){
					    capa.innerHTML="ALGEBRA ";
					}else if(opcionSeleccionada=="480"){
					    capa.innerHTML="ESTADISTICA ";
					}else if(opcionSeleccionada=="481"){
					    capa.innerHTML="TEORIA DE LA ADMINISTRACION ";
					}else if(opcionSeleccionada=="482"){
					    capa.innerHTML="INSTITUCIONALIDAD POLITICA Y ECONOMICA ";
					}else if(opcionSeleccionada=="483"){
					    capa.innerHTML="IDENTIDAD NACIONAL ";
					}else if(opcionSeleccionada=="484"){
					    capa.innerHTML="CHILE EN EL SIGLO XX ";
					}else if(opcionSeleccionada=="485"){
					    capa.innerHTML="ORIENTACION VOCACIONAL ";
					}else if(opcionSeleccionada=="486"){
					    capa.innerHTML="PROYECTOS TECNOLOGICOS Y MANUALIDADES ";
					}else if(opcionSeleccionada=="487"){
					    capa.innerHTML="DIBUJO TECNICO Y PROYECTOS ";
					}else if(opcionSeleccionada=="488"){
					    capa.innerHTML="GESTION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="489"){
					    capa.innerHTML="PREVENCION DE RIESGOS ";
					}else if(opcionSeleccionada=="490"){
					    capa.innerHTML="FILOSOFIA PSICOLOGIA ";
					}else if(opcionSeleccionada=="491"){
					    capa.innerHTML="ADMINISTRACION Y PREVENCION DE RIESGOS ";
					}else if(opcionSeleccionada=="492"){
					    capa.innerHTML="LABORATORIO DE CIENCIAS Y TECNOLOGIA ";
					}else if(opcionSeleccionada=="493"){
					    capa.innerHTML="TALLER DE GASTRONOMIA ";
					}else if(opcionSeleccionada=="494"){
					    capa.innerHTML="TALLER DE HOTELERIA ";
					}else if(opcionSeleccionada=="495"){
					    capa.innerHTML="TALLER REFORZAMIENTO MATEMATICA ";
					}else if(opcionSeleccionada=="496"){
					    capa.innerHTML="TALLER REFORZAMIENTO LENGUA CASTELLANA Y COMUNICACION ";
					}else if(opcionSeleccionada=="497"){
					    capa.innerHTML="TALLER DE REFORZAMIENTO HISTORIA Y CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="498"){
					    capa.innerHTML="ARTES EXPRESIVA CORPORALES ";
					}else if(opcionSeleccionada=="499"){
					    capa.innerHTML="MI REGION EN MI PAIS ";
					}else if(opcionSeleccionada=="500"){
					    capa.innerHTML="TECNICAS DE LABORATORIO ";
					}else if(opcionSeleccionada=="501"){
					    capa.innerHTML="TALLER VOCACIONAL ";
					}else if(opcionSeleccionada=="502"){
					    capa.innerHTML="NOCIONES DE COMERCIO ";
					}else if(opcionSeleccionada=="503"){
					    capa.innerHTML="REDACCION COMERCIAL ";
					}else if(opcionSeleccionada=="504"){
					    capa.innerHTML="TALLER DE EXPRESION ";
					}else if(opcionSeleccionada=="505"){
					    capa.innerHTML="TALLER DE RELACIONES HUMANAS ";
					}else if(opcionSeleccionada=="506"){
					    capa.innerHTML="DACTILOGRAFIA ";
					}else if(opcionSeleccionada=="507"){
					    capa.innerHTML="TEORIA DE PRACTICA DE OFICINA ";
					}else if(opcionSeleccionada=="508"){
					    capa.innerHTML="TALLER PROPEDEUTICO ";
					}else if(opcionSeleccionada=="509"){
					    capa.innerHTML="DIBUJO TECNICO ";
					}else if(opcionSeleccionada=="510"){
					    capa.innerHTML="INTRODUCCION A LA TECNOLOGIA ";
					}else if(opcionSeleccionada=="511"){
					    capa.innerHTML="EL MUNDO DE LA COMUNICACION ";
					}else if(opcionSeleccionada=="512"){
					    capa.innerHTML="CONTABILIDAD Y PRESUPUESTO ";
					}else if(opcionSeleccionada=="513"){
					    capa.innerHTML="DIGITACION ";
					}else if(opcionSeleccionada=="514"){
					    capa.innerHTML="RELACIONES HUMANAS Y PROTOCOLO ";
					}else if(opcionSeleccionada=="515"){
					    capa.innerHTML="LABORATORIO ";
					}else if(opcionSeleccionada=="516"){
					    capa.innerHTML="ORGANIZACION DE OFICINA ";
					}else if(opcionSeleccionada=="517"){
					    capa.innerHTML="TECNOLOGIA ";
					}else if(opcionSeleccionada=="518"){
					    capa.innerHTML="FUNDAMENTOS DE SECRETARIADO ";
					}else if(opcionSeleccionada=="519"){
					    capa.innerHTML="HERRAMIENTAS Y AUTOMECANICAS DE OFICINA ";
					}else if(opcionSeleccionada=="520"){
					    capa.innerHTML="INTERPRETACION DE PLANOS TECNICOS ";
					}else if(opcionSeleccionada=="521"){
					    capa.innerHTML="ELECTRICIDAD AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="522"){
					    capa.innerHTML="ELECTRONICA ";
					}else if(opcionSeleccionada=="523"){
					    capa.innerHTML="FRENOS HIDRAULICOS ";
					}else if(opcionSeleccionada=="524"){
					    capa.innerHTML="LUBRICANTES Y COMBUSTIBLES ";
					}else if(opcionSeleccionada=="525"){
					    capa.innerHTML="MECANICA BASICA ";
					}else if(opcionSeleccionada=="526"){
					    capa.innerHTML="MECANICA DE BANCO ";
					}else if(opcionSeleccionada=="527"){
					    capa.innerHTML="MITOLOGIA ";
					}else if(opcionSeleccionada=="528"){
					    capa.innerHTML="SOLDADURA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="529"){
					    capa.innerHTML="FUNDAMENTOS DE COMPUTACION E INFORMATICA ";
					}else if(opcionSeleccionada=="530"){
					    capa.innerHTML="HARDWARE COMPUTACIONAL ";
					}else if(opcionSeleccionada=="531"){
					    capa.innerHTML="LABORATORIO DE SOFTWARE ";
					}else if(opcionSeleccionada=="532"){
					    capa.innerHTML="TECNICAS Y LENGUAJES DE PROGRAMACION ";
					}else if(opcionSeleccionada=="533"){
					    capa.innerHTML="ARMONIA ";
					}else if(opcionSeleccionada=="534"){
					    capa.innerHTML="MUSICA DE CAMARA ";
					}else if(opcionSeleccionada=="535"){
					    capa.innerHTML="HISTORIA DEL TEATRO CHILENO Y LATINOAMERICANO ";
					}else if(opcionSeleccionada=="536"){
					    capa.innerHTML="DISENO TEATRAL ";
					}else if(opcionSeleccionada=="537"){
					    capa.innerHTML="TECNICAS DE MAQUILLAJE ";
					}else if(opcionSeleccionada=="538"){
					    capa.innerHTML="HISTORIA DEL TEATRO UNIVERSAL ";
					}else if(opcionSeleccionada=="539"){
					    capa.innerHTML="TALLER COREOGRAFICO MODERNO ";
					}else if(opcionSeleccionada=="540"){
					    capa.innerHTML="TALLER DE BAILE FOLKLORICO ";
					}else if(opcionSeleccionada=="541"){
					    capa.innerHTML="GUITARRA FOLKLORICA ";
					}else if(opcionSeleccionada=="542"){
					    capa.innerHTML="PERCUSION ";
					}else if(opcionSeleccionada=="543"){
					    capa.innerHTML="AEROFANOS ";
					}else if(opcionSeleccionada=="544"){
					    capa.innerHTML="DISENO ";
					}else if(opcionSeleccionada=="545"){
					    capa.innerHTML="COMIC ";
					}else if(opcionSeleccionada=="546"){
					    capa.innerHTML="ESCULTURA ";
					}else if(opcionSeleccionada=="547"){
					    capa.innerHTML="VIDEO ";
					}else if(opcionSeleccionada=="548"){
					    capa.innerHTML="LABORATORIO DE SECRETARIADO ";
					}else if(opcionSeleccionada=="549"){
					    capa.innerHTML="EDUCACION RITMICA MUSICAL ";
					}else if(opcionSeleccionada=="550"){
					    capa.innerHTML="ATENCION DE EDUCACION DE PARVULOS ";
					}else if(opcionSeleccionada=="551"){
					    capa.innerHTML="TALLER DE ESPECIALIDAD ";
					}else if(opcionSeleccionada=="552"){
					    capa.innerHTML="DISENO DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="553"){
					    capa.innerHTML="TALLERES DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="554"){
					    capa.innerHTML="TECNICAS DE LA EXPRESION ";
					}else if(opcionSeleccionada=="555"){
					    capa.innerHTML="EXPRESION CORPORAL INFANTIL ";
					}else if(opcionSeleccionada=="556"){
					    capa.innerHTML="MODELAJE Y CORTE ";
					}else if(opcionSeleccionada=="557"){
					    capa.innerHTML="TALLER DE INICIACION AL DISENO TEXTIL ";
					}else if(opcionSeleccionada=="558"){
					    capa.innerHTML="LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="559"){
					    capa.innerHTML="ADMINISTRACION ";
					}else if(opcionSeleccionada=="560"){
					    capa.innerHTML="INFORMATICA Y LABORATORIO DE COMPUTACION ";
					}else if(opcionSeleccionada=="561"){
					    capa.innerHTML="PENSAMIENTO FILOSOFICO ";
					}else if(opcionSeleccionada=="562"){
					    capa.innerHTML="HISTORIA DE AMERICA LATINA ";
					}else if(opcionSeleccionada=="563"){
					    capa.innerHTML="ELECTROTECNIA ";
					}else if(opcionSeleccionada=="564"){
					    capa.innerHTML="PRACTICA DE TALLER ";
					}else if(opcionSeleccionada=="565"){
					    capa.innerHTML="LABORATORIO CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="566"){
					    capa.innerHTML="LABORATORIO DE MECANICA ";
					}else if(opcionSeleccionada=="567"){
					    capa.innerHTML="TALLER CARDINADO ";
					}else if(opcionSeleccionada=="568"){
					    capa.innerHTML="CULTURA RELIGIOSA ";
					}else if(opcionSeleccionada=="569"){
					    capa.innerHTML="DIBUJO TECNICO DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="570"){
					    capa.innerHTML="NOCIONES DE DERECHO ";
					}else if(opcionSeleccionada=="571"){
					    capa.innerHTML="TECNOLOGIA DE LA INFORMATICA ";
					}else if(opcionSeleccionada=="572"){
					    capa.innerHTML="ELECTRICIDAD Y ELECTRONICA ";
					}else if(opcionSeleccionada=="573"){
					    capa.innerHTML="FUNDAMENTOS DE COMPUTACION ";
					}else if(opcionSeleccionada=="574"){
					    capa.innerHTML="MATEMATICA COMERCIAL Y FINANCIERA ";
					}else if(opcionSeleccionada=="575"){
					    capa.innerHTML="MARKETING ";
					}else if(opcionSeleccionada=="576"){
					    capa.innerHTML="PUBLICIDAD ";
					}else if(opcionSeleccionada=="577"){
					    capa.innerHTML="TALLER CREATIVO ";
					}else if(opcionSeleccionada=="578"){
					    capa.innerHTML="TALLER DEPORTES ";
					}else if(opcionSeleccionada=="579"){
					    capa.innerHTML="COLOR ";
					}else if(opcionSeleccionada=="580"){
					    capa.innerHTML="GRAFICA COMPUTACIONAL ";
					}else if(opcionSeleccionada=="581"){
					    capa.innerHTML="TALLER PRINCIPAL ";
					}else if(opcionSeleccionada=="582"){
					    capa.innerHTML="LENGUAJE BASIC ";
					}else if(opcionSeleccionada=="583"){
					    capa.innerHTML="APLICACION COMPUTACIONAL ";
					}else if(opcionSeleccionada=="584"){
					    capa.innerHTML="MATEMATICA APLICADA ";
					}else if(opcionSeleccionada=="585"){
					    capa.innerHTML="TEORIA TURISTICA ";
					}else if(opcionSeleccionada=="586"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA TURISTICA DE CHILE ";
					}else if(opcionSeleccionada=="587"){
					    capa.innerHTML="INTRODUCCION ";
					}else if(opcionSeleccionada=="588"){
					    capa.innerHTML="SALUD E HIGIENE ";
					}else if(opcionSeleccionada=="589"){
					    capa.innerHTML="TALLER DE EXPRESION PLASTICA Y MANUAL ";
					}else if(opcionSeleccionada=="590"){
					    capa.innerHTML="LABORATORIO DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="591"){
					    capa.innerHTML="DISPOSITIVOS ELECTRONICOS ";
					}else if(opcionSeleccionada=="592"){
					    capa.innerHTML="FUNDAMENTOS ELECTRONICOS ";
					}else if(opcionSeleccionada=="593"){
					    capa.innerHTML="HIGIENE Y SEGURIDAD INDUSTRIAL ";
					}else if(opcionSeleccionada=="594"){
					    capa.innerHTML="TALLER DE INICIACION A LA COMUNICACION VISUAL CONTEMPORANEA ";
					}else if(opcionSeleccionada=="595"){
					    capa.innerHTML="EXPRESION Y COMUNICACION ";
					}else if(opcionSeleccionada=="596"){
					    capa.innerHTML="DESARROLLO PSICOLOGICO ";
					}else if(opcionSeleccionada=="597"){
					    capa.innerHTML="LABORATORIO DE ADMINISTRACION ";
					}else if(opcionSeleccionada=="598"){
					    capa.innerHTML="FORMACION CIUDADANA ";
					}else if(opcionSeleccionada=="599"){
					    capa.innerHTML="ORTOGRAFIA ";
					}else if(opcionSeleccionada=="600"){
					    capa.innerHTML="DEBERES ESCOLARES ";
					}else if(opcionSeleccionada=="601"){
					    capa.innerHTML="TALLER DEPORTIVO OPCIONAL ";
					}else if(opcionSeleccionada=="602"){
					    capa.innerHTML="TALLER EXPRESION LITERARIA ";
					}else if(opcionSeleccionada=="603"){
					    capa.innerHTML="TALLER DE PREPARACION PARA LA P.A.A DE MATEMATICAS ";
					}else if(opcionSeleccionada=="604"){
					    capa.innerHTML="TALLER DE COMPUTACION EDUCATIVA ";
					}else if(opcionSeleccionada=="605"){
					    capa.innerHTML="INTRODUCCION AL DIBUJO NORMALIZADO ";
					}else if(opcionSeleccionada=="606"){
					    capa.innerHTML="FUNDAMENTOS DE ELECTRICIDAD Y MECANICA INDUSTRIAL ";
					}else if(opcionSeleccionada=="607"){
					    capa.innerHTML="INTRODUCCION AL PENSAMIENTO ";
					}else if(opcionSeleccionada=="608"){
					    capa.innerHTML="ANTROPOLOGIA FILOSOFICA ";
					}else if(opcionSeleccionada=="609"){
					    capa.innerHTML="INTRODUCCION A LA FILOSOFIA ";
					}else if(opcionSeleccionada=="610"){
					    capa.innerHTML="TALLER ELECTIVO DE ARTE ";
					}else if(opcionSeleccionada=="611"){
					    capa.innerHTML="EXPLORANDO EL MUNDO LABORAL ";
					}else if(opcionSeleccionada=="612"){
					    capa.innerHTML="TALLER DE PRACTICA AGRICOLA ";
					}else if(opcionSeleccionada=="613"){
					    capa.innerHTML="TALLER TECNICO VOCACIONAL ";
					}else if(opcionSeleccionada=="614"){
					    capa.innerHTML="ORIENTACION AL DIBUJO ";
					}else if(opcionSeleccionada=="615"){
					    capa.innerHTML="ADMINISTRACION Y LENGUAJE EN AERONAUTICA ";
					}else if(opcionSeleccionada=="616"){
					    capa.innerHTML="AERODINAMICA ";
					}else if(opcionSeleccionada=="617"){
					    capa.innerHTML="DIBUJO Y PROYECTO ELECTRONICO ";
					}else if(opcionSeleccionada=="618"){
					    capa.innerHTML="LABORATORIO DE COMPUTACION Y SISTEMA DIGITAL ";
					}else if(opcionSeleccionada=="619"){
					    capa.innerHTML="LABORATORIO TECNOLOGICO Y TALLER DE ELECTRONICA ";
					}else if(opcionSeleccionada=="620"){
					    capa.innerHTML="MICROPROCESADOR Y LABORATORIO DE SISTEMA DIGITAL ";
					}else if(opcionSeleccionada=="621"){
					    capa.innerHTML="PREVENCION DE RIESGOS Y FACTOR HUMANO ";
					}else if(opcionSeleccionada=="622"){
					    capa.innerHTML="SISTEMA DE AVION Y MANTENIMIENTO AERONAUTICA ";
					}else if(opcionSeleccionada=="623"){
					    capa.innerHTML="TALLER CUANTAS POSIBILIDADES ";
					}else if(opcionSeleccionada=="624"){
					    capa.innerHTML="TALLER DE VIDEO Y SEXUALIDAD ";
					}else if(opcionSeleccionada=="625"){
					    capa.innerHTML="TALLER AGOTANDO RECURSOS ";
					}else if(opcionSeleccionada=="626"){
					    capa.innerHTML="NOCIONES DE INFORMATICA ";
					}else if(opcionSeleccionada=="627"){
					    capa.innerHTML="INTRODUCCION AL COMERCIO ";
					}else if(opcionSeleccionada=="628"){
					    capa.innerHTML="EXPLORACION VOCACIONAL ";
					}else if(opcionSeleccionada=="629"){
					    capa.innerHTML="TECNOLOGIA GENERAL ";
					}else if(opcionSeleccionada=="630"){
					    capa.innerHTML="TALLER EXPLORATORIO ";
					}else if(opcionSeleccionada=="631"){
					    capa.innerHTML="INTRODUCCION A LA INFORMATICA ";
					}else if(opcionSeleccionada=="632"){
					    capa.innerHTML="ORIENTACION GRUPAL ";
					}else if(opcionSeleccionada=="633"){
					    capa.innerHTML="USO DE SOFTWARE GRAFICO ";
					}else if(opcionSeleccionada=="634"){
					    capa.innerHTML="INICIACION AL DIBUJO TECNICO ";
					}else if(opcionSeleccionada=="635"){
					    capa.innerHTML="TALLER DEPORTIVO Y CULTURAL ";
					}else if(opcionSeleccionada=="636"){
					    capa.innerHTML="TALLER DE FORMACION PERSONAL ";
					}else if(opcionSeleccionada=="637"){
					    capa.innerHTML="FUND. COMERCIAL Y ADMINISTRACION BASICA ";
					}else if(opcionSeleccionada=="638"){
					    capa.innerHTML="TALLER DE AGROECOLOGIA ";
					}else if(opcionSeleccionada=="639"){
					    capa.innerHTML="TALLER DE CIENCIAS AGRONOMICAS ";
					}else if(opcionSeleccionada=="640"){
					    capa.innerHTML="TALLER DE CIENCIAS PECUARIAS ";
					}else if(opcionSeleccionada=="641"){
					    capa.innerHTML="TALLER AGROPECUARIO ";
					}else if(opcionSeleccionada=="642"){
					    capa.innerHTML="TECNOLOGIA E INFORMATICA ";
					}else if(opcionSeleccionada=="643"){
					    capa.innerHTML="ETICA Y RELACIONES HUMANAS ";
					}else if(opcionSeleccionada=="644"){
					    capa.innerHTML="EDUCACION TECNOLOGICA APLICADA ";
					}else if(opcionSeleccionada=="645"){
					    capa.innerHTML="EDUCACION FAMILIAR ";
					}else if(opcionSeleccionada=="646"){
					    capa.innerHTML="TECNICAS DE LA COMUNICACION ";
					}else if(opcionSeleccionada=="647"){
					    capa.innerHTML="UTILITARIOS ";
					}else if(opcionSeleccionada=="648"){
					    capa.innerHTML="NOCION DE INFORMATICA ";
					}else if(opcionSeleccionada=="649"){
					    capa.innerHTML="LABORATORIO QUIMICO ";
					}else if(opcionSeleccionada=="650"){
					    capa.innerHTML="SOCIALIZACION Y CRECIMIENTO PERSONAL ";
					}else if(opcionSeleccionada=="651"){
					    capa.innerHTML="GESTION PROFESIONAL ";
					}else if(opcionSeleccionada=="652"){
					    capa.innerHTML="TALLER CULINARIO ";
					}else if(opcionSeleccionada=="653"){
					    capa.innerHTML="EXPLORATORIO ";
					}else if(opcionSeleccionada=="654"){
					    capa.innerHTML="EXTRA ESCOLAR ";
					}else if(opcionSeleccionada=="655"){
					    capa.innerHTML="ALIMENTACION Y NUTRICION ";
					}else if(opcionSeleccionada=="656"){
					    capa.innerHTML="FUNDAMENTOS DE LA ELECTRICIDAD ";
					}else if(opcionSeleccionada=="657"){
					    capa.innerHTML="CULTIVOS ";
					}else if(opcionSeleccionada=="658"){
					    capa.innerHTML="PRACTICA AGRICOLA ";
					}else if(opcionSeleccionada=="659"){
					    capa.innerHTML="PRACTICA ";
					}else if(opcionSeleccionada=="660"){
					    capa.innerHTML="TALLER ORIENTACION PROFESIONAL ";
					}else if(opcionSeleccionada=="661"){
					    capa.innerHTML="CONTABILIDAD GENERAL ";
					}else if(opcionSeleccionada=="662"){
					    capa.innerHTML="EXPRESION ORAL Y ESCRITA ";
					}else if(opcionSeleccionada=="663"){
					    capa.innerHTML="INTRODUCCION AL SECTOR DE ADMINISTRACION Y COMERCIO ";
					}else if(opcionSeleccionada=="664"){
					    capa.innerHTML="TALLERES DE COMUNICACIONES ";
					}else if(opcionSeleccionada=="665"){
					    capa.innerHTML="TALLER DE CIENCIAS ";
					}else if(opcionSeleccionada=="666"){
					    capa.innerHTML="INTRODUCCION A LA EDUCACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="667"){
					    capa.innerHTML="TALLER FISICO ARTISTICO Y CULTURAL ";
					}else if(opcionSeleccionada=="668"){
					    capa.innerHTML="EL MUNDO JUVENIL BUSCA RESPUESTAS ";
					}else if(opcionSeleccionada=="669"){
					    capa.innerHTML="NOCIONES DE COMPUTACION ";
					}else if(opcionSeleccionada=="670"){
					    capa.innerHTML="EXPLOTACION Y CULTIVOS ";
					}else if(opcionSeleccionada=="671"){
					    capa.innerHTML="HORTICULTURA PRACTICA ";
					}else if(opcionSeleccionada=="672"){
					    capa.innerHTML="FRUTALES MENORES ";
					}else if(opcionSeleccionada=="673"){
					    capa.innerHTML="TALLER DE TEATRO Y EXPRESION ORAL ";
					}else if(opcionSeleccionada=="674"){
					    capa.innerHTML="TALLER LECTO ESCRITURA ";
					}else if(opcionSeleccionada=="675"){
					    capa.innerHTML="TALLER EXPRESION ESCRITA ";
					}else if(opcionSeleccionada=="676"){
					    capa.innerHTML="TALLER COMPENSATORIO DE MATEMATICAS ";
					}else if(opcionSeleccionada=="677"){
					    capa.innerHTML="ECOLOGIA Y MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="678"){
					    capa.innerHTML="LA COMUNICACION LINGUISTICA ";
					}else if(opcionSeleccionada=="679"){
					    capa.innerHTML="ACTIVIDAD PASTORAL ";
					}else if(opcionSeleccionada=="680"){
					    capa.innerHTML="CURSO OPCIONAL ";
					}else if(opcionSeleccionada=="681"){
					    capa.innerHTML="HISTORIA UNIVERSAL ";
					}else if(opcionSeleccionada=="682"){
					    capa.innerHTML="HISTORIA UNIVERSAL I ";
					}else if(opcionSeleccionada=="683"){
					    capa.innerHTML="HISTORIA UNIVERSAL II ";
					}else if(opcionSeleccionada=="684"){
					    capa.innerHTML="HISTORIA DE AMERICA Y CHILE ";
					}else if(opcionSeleccionada=="685"){
					    capa.innerHTML="TALLER DE CIENCIAS NATURALES ";
					}else if(opcionSeleccionada=="686"){
					    capa.innerHTML="CRECIENDO JUNTOS ";
					}else if(opcionSeleccionada=="687"){
					    capa.innerHTML="DESARROLLO COGNITIVO ";
					}else if(opcionSeleccionada=="688"){
					    capa.innerHTML="TALLERES EXTRAPROGRAMATICOS ";
					}else if(opcionSeleccionada=="689"){
					    capa.innerHTML="EDUCACION DE LA AFECTIVIDAD ";
					}else if(opcionSeleccionada=="690"){
					    capa.innerHTML="TALLER DE PENSAMIENTO ";
					}else if(opcionSeleccionada=="691"){
					    capa.innerHTML="TALLER DE HISTORIA DE CHILE ";
					}else if(opcionSeleccionada=="692"){
					    capa.innerHTML="LECTURA INTEGRADA ";
					}else if(opcionSeleccionada=="693"){
					    capa.innerHTML="RELIGION Y ETICA ";
					}else if(opcionSeleccionada=="694"){
					    capa.innerHTML="ARTES REPRESENTATIVAS ";
					}else if(opcionSeleccionada=="695"){
					    capa.innerHTML="PROTECCION DE LA SALUD ";
					}else if(opcionSeleccionada=="696"){
					    capa.innerHTML="PROFUNDIZACION DE SUBSECTORES ";
					}else if(opcionSeleccionada=="697"){
					    capa.innerHTML="EDUCACION PARA ETICA Y LA MORAL ";
					}else if(opcionSeleccionada=="698"){
					    capa.innerHTML="ORIENTACION EDUCACIONAL ";
					}else if(opcionSeleccionada=="699"){
					    capa.innerHTML="ESTRUCTURA DE LA MATERIA ";
					}else if(opcionSeleccionada=="700"){
					    capa.innerHTML="EDUCACION FISICA Y RECREACION ";
					}else if(opcionSeleccionada=="701"){
					    capa.innerHTML="ESTRUCTURA DE LA MATERIA I ";
					}else if(opcionSeleccionada=="702"){
					    capa.innerHTML="ESTRUCTURA DE LA MATERIA II ";
					}else if(opcionSeleccionada=="704"){
					    capa.innerHTML="TALLER DE PENSAMIENTO LUDICO ";
					}else if(opcionSeleccionada=="705"){
					    capa.innerHTML="PROYECTO DE COMPUTACION ";
					}else if(opcionSeleccionada=="706"){
					    capa.innerHTML="TALLER GENERAL ";
					}else if(opcionSeleccionada=="707"){
					    capa.innerHTML="TALLER GENERAL I ";
					}else if(opcionSeleccionada=="708"){
					    capa.innerHTML="TALLER GENERAL II ";
					}else if(opcionSeleccionada=="709"){
					    capa.innerHTML="METODOLOGIAS DE LABORES AGRICOLAS ";
					}else if(opcionSeleccionada=="710"){
					    capa.innerHTML="METODOLOGIAS DE LABORES AGRICOLAS I ";
					}else if(opcionSeleccionada=="711"){
					    capa.innerHTML="METODOLOGIAS DE LABORES AGRICOLAS II ";
					}else if(opcionSeleccionada=="712"){
					    capa.innerHTML="FORMACION GENERAL ";
					}else if(opcionSeleccionada=="713"){
					    capa.innerHTML="ORIENTE Y OCCIDENTE: DOS MUNDOS CON CULTURAS DIFERENTES ";
					}else if(opcionSeleccionada=="714"){
					    capa.innerHTML="TEORIA DE LA COMUNICACION ";
					}else if(opcionSeleccionada=="715"){
					    capa.innerHTML="COMPRENSION DEL IDIOMA ESCRITO INGLES ";
					}else if(opcionSeleccionada=="716"){
					    capa.innerHTML="COMPRENSION Y PRODUCCION DEL IDIOMA ORAL INGLES ";
					}else if(opcionSeleccionada=="717"){
					    capa.innerHTML="TALLER DE MUSICA INSTRUMENTAL ";
					}else if(opcionSeleccionada=="718"){
					    capa.innerHTML="TALLER DE CREACIONES TECNOLOGICAS ";
					}else if(opcionSeleccionada=="719"){
					    capa.innerHTML="COMPRENSION LECTORA ";
					}else if(opcionSeleccionada=="720"){
					    capa.innerHTML="ETICA LABORAL ";
					}else if(opcionSeleccionada=="721"){
					    capa.innerHTML="HISTORIA DE IBEROAMERICA ";
					}else if(opcionSeleccionada=="722"){
					    capa.innerHTML="APLICACIONES DE LAS MATEMATICAS: MATRICES Y DETERMINANTES Y GEOMETRIA ANALITICA PLANA ";
					}else if(opcionSeleccionada=="723"){
					    capa.innerHTML="APLICACIONES DE LAS MATEMATICAS: TRIGONOMETRIA PLANA Y ELEMENTOS DE COMBINATORIA ";
					}else if(opcionSeleccionada=="724"){
					    capa.innerHTML="DERECHO COMERCIAL Y LABORAL ";
					}else if(opcionSeleccionada=="725"){
					    capa.innerHTML="LABORATORIO INDUSTRIAL ";
					}else if(opcionSeleccionada=="726"){
					    capa.innerHTML="EL COMERCIO Y LAS EMPRESAS ";
					}else if(opcionSeleccionada=="727"){
					    capa.innerHTML="LA DACTILOGRAFIA AL SERVICIO DE LA COMPUTACION ";
					}else if(opcionSeleccionada=="728"){
					    capa.innerHTML="VENTA Y PUBLICIDAD ";
					}else if(opcionSeleccionada=="729"){
					    capa.innerHTML="RELIGION Y ACCION SOCIAL ";
					}else if(opcionSeleccionada=="730"){
					    capa.innerHTML="TALLER DE ORIENTACION Y CONSEJO DE CURSO ";
					}else if(opcionSeleccionada=="731"){
					    capa.innerHTML="ACONDICIONAMIENTO ORGANICO ";
					}else if(opcionSeleccionada=="732"){
					    capa.innerHTML="TALLER A LA TECNOLOGIA COMPUTACIONAL ";
					}else if(opcionSeleccionada=="733"){
					    capa.innerHTML="TALLER DE DESARROLLO PERSONAL ";
					}else if(opcionSeleccionada=="734"){
					    capa.innerHTML="TALLER DE COMUNICACION ";
					}else if(opcionSeleccionada=="735"){
					    capa.innerHTML="TALLER DE HISTORIA ";
					}else if(opcionSeleccionada=="736"){
					    capa.innerHTML="INICIACION A LA COMPUTACION ";
					}else if(opcionSeleccionada=="737"){
					    capa.innerHTML="EDUCACION FISICA, DEPORTE Y RECREACION ";
					}else if(opcionSeleccionada=="738"){
					    capa.innerHTML="ORIENTACION TUTORIA Y CONSEJO DE CURSO ";
					}else if(opcionSeleccionada=="739"){
					    capa.innerHTML="MULTITALLER EXPLORACION VOCACIONAL ";
					}else if(opcionSeleccionada=="740"){
					    capa.innerHTML="ELEMENTOS DE GEOMETRIA ";
					}else if(opcionSeleccionada=="741"){
					    capa.innerHTML="LA EMPRESA DESAFIO PARA UN ESPIRITU EMPRENDEDOR ";
					}else if(opcionSeleccionada=="742"){
					    capa.innerHTML="BIOLOGIA CELULAR Y MOLECULAR ";
					}else if(opcionSeleccionada=="743"){
					    capa.innerHTML="ELECTRICIDAD Y ELECTRONICA EXPERIMENTAL ";
					}else if(opcionSeleccionada=="744"){
					    capa.innerHTML="HISTORIA DEL CINE ";
					}else if(opcionSeleccionada=="745"){
					    capa.innerHTML="DEPORTE SELECCION ";
					}else if(opcionSeleccionada=="746"){
					    capa.innerHTML="EL TURISMO ";
					}else if(opcionSeleccionada=="747"){
					    capa.innerHTML="CRECIMIENTO PERSONAL FUNDAMENTO DE UN BUEN SERVICIO ";
					}else if(opcionSeleccionada=="748"){
					    capa.innerHTML="TALLER INTRODUCCION A LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="749"){
					    capa.innerHTML="JUEGOS DE COMERCIO ";
					}else if(opcionSeleccionada=="750"){
					    capa.innerHTML="INVESTIGACION Y ANALISIS DEL TURISMO ";
					}else if(opcionSeleccionada=="751"){
					    capa.innerHTML="SIGLO XXI DIGITACION ELECTRONICA ";
					}else if(opcionSeleccionada=="752"){
					    capa.innerHTML="TALLER DE ROTACION VOCACIONAL ";
					}else if(opcionSeleccionada=="753"){
					    capa.innerHTML="EDUCACION DEL CONSUMIDOR ";
					}else if(opcionSeleccionada=="754"){
					    capa.innerHTML="ELABORACION DE PROYECTOS PRODUCTIVOS ORIENTADOS AL AMBITO LABORAL ALIMENTICIO ";
					}else if(opcionSeleccionada=="755"){
					    capa.innerHTML="ELABORACION DE PROYECTOS PRODUCTIVOS ORIENTADOS AL AMBITO LABORAL TEXTIL ";
					}else if(opcionSeleccionada=="756"){
					    capa.innerHTML="ELABORACION DE PROYECTOS PRODUCTIVOS ORIENTADOS A LA ATENCION DE PARVULOS ";
					}else if(opcionSeleccionada=="757"){
					    capa.innerHTML="AYMARA ";
					}else if(opcionSeleccionada=="758"){
					    capa.innerHTML="CONJUNTO CORAL ";
					}else if(opcionSeleccionada=="759"){
					    capa.innerHTML="TALLER INSTRUMENTAL ";
					}else if(opcionSeleccionada=="760"){
					    capa.innerHTML="MUSICA FOLCLORICA ";
					}else if(opcionSeleccionada=="761"){
					    capa.innerHTML="GIMNASIA RITMICA ";
					}else if(opcionSeleccionada=="762"){
					    capa.innerHTML="DANZA EDUCATIVA ";
					}else if(opcionSeleccionada=="763"){
					    capa.innerHTML="ESTUDIOS ANDINOS ";
					}else if(opcionSeleccionada=="764"){
					    capa.innerHTML="ARTESANIA ";
					}else if(opcionSeleccionada=="765"){
					    capa.innerHTML="DANZA FOLCLORICA ";
					}else if(opcionSeleccionada=="766"){
					    capa.innerHTML="ARTESANIA ANDINA ";
					}else if(opcionSeleccionada=="767"){
					    capa.innerHTML="AGROPECUARIA ";
					}else if(opcionSeleccionada=="768"){
					    capa.innerHTML="TALLER DE ORIENTACION PROFESIONAL ";
					}else if(opcionSeleccionada=="769"){
					    capa.innerHTML="HABILIDADES VERBALES ";
					}else if(opcionSeleccionada=="770"){
					    capa.innerHTML="TALLER DE ESCRITURA CREATIVA ";
					}else if(opcionSeleccionada=="771"){
					    capa.innerHTML="COORDINACION PARTICIPATIVA INTEGRAL ";
					}else if(opcionSeleccionada=="772"){
					    capa.innerHTML="ARTISTICA TECNOLOGICA ";
					}else if(opcionSeleccionada=="773"){
					    capa.innerHTML="DEPORTIVA RECREATIVA ";
					}else if(opcionSeleccionada=="774"){
					    capa.innerHTML="PLAN COMPLEMENTARIO DE LECTURA ";
					}else if(opcionSeleccionada=="775"){
					    capa.innerHTML="JEFATURA ";
					}else if(opcionSeleccionada=="776"){
					    capa.innerHTML="TALLER MULTIDISCIPLINARIO ";
					}else if(opcionSeleccionada=="777"){
					    capa.innerHTML="ACTIVIDAD LIBRE ELECCION ";
					}else if(opcionSeleccionada=="778"){
					    capa.innerHTML="APRENDIENDO A CRECER ";
					}else if(opcionSeleccionada=="779"){
					    capa.innerHTML="APOYO TECNICO ";
					}else if(opcionSeleccionada=="780"){
					    capa.innerHTML="EDUCACION PARA VIDA FAMILIAR ";
					}else if(opcionSeleccionada=="781"){
					    capa.innerHTML="ACTIVIDADES EXTRAPROGRAMATICAS ";
					}else if(opcionSeleccionada=="782"){
					    capa.innerHTML="EXPRESION PERSONAL ";
					}else if(opcionSeleccionada=="783"){
					    capa.innerHTML="TEATRO FORMATIVO ";
					}else if(opcionSeleccionada=="784"){
					    capa.innerHTML="ESCRITURA REDACCION Y ORTOGRAFIA ";
					}else if(opcionSeleccionada=="785"){
					    capa.innerHTML="EL ARTE Y LA PLASTICA ";
					}else if(opcionSeleccionada=="786"){
					    capa.innerHTML="EL ARTE Y LA MUSICA ";
					}else if(opcionSeleccionada=="787"){
					    capa.innerHTML="NATURALEZA Y ECOLOGIA ";
					}else if(opcionSeleccionada=="788"){
					    capa.innerHTML="HISTORIA Y SOCIEDAD ";
					}else if(opcionSeleccionada=="789"){
					    capa.innerHTML="RECURSOS NATURALES Y NOCIONES BASICAS DE AGRICULTURA ";
					}else if(opcionSeleccionada=="790"){
					    capa.innerHTML="INTRODUCCION AL SERVICIO DE ALIMENTACION COLECTIVA ";
					}else if(opcionSeleccionada=="791"){
					    capa.innerHTML="MENTALIDAD Y PROYECTOS EMPRESARIALES ";
					}else if(opcionSeleccionada=="792"){
					    capa.innerHTML="FORMACION TECNICO VOCACIONAL ";
					}else if(opcionSeleccionada=="793"){
					    capa.innerHTML="LABORATORIO COMERCIAL ";
					}else if(opcionSeleccionada=="794"){
					    capa.innerHTML="TALLER DE DACTILOGRAFIA ";
					}else if(opcionSeleccionada=="795"){
					    capa.innerHTML="TALLER DE INFORMATICA ";
					}else if(opcionSeleccionada=="796"){
					    capa.innerHTML="RECURSOS PRODUCTIVOS ";
					}else if(opcionSeleccionada=="797"){
					    capa.innerHTML="TALLER DE PRACTICAS ";
					}else if(opcionSeleccionada=="798"){
					    capa.innerHTML="TALLER DE DESARROLLO INTEGRAL ";
					}else if(opcionSeleccionada=="799"){
					    capa.innerHTML="TECNOLOGIA Y PRACTICA ";
					}else if(opcionSeleccionada=="800"){
					    capa.innerHTML="TALLER DE DESARROLLO DE LA MENTALIDAD EMPRENDEDORA ";
					}else if(opcionSeleccionada=="801"){
					    capa.innerHTML="FUNDAMENTOS DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="802"){
					    capa.innerHTML="TALLER DE FORMACION VOCACIONAL ";
					}else if(opcionSeleccionada=="803"){
					    capa.innerHTML="TALLER DE ALIMENTACION Y SERVICIO O FUNDAMENTOS DE AGROECOLOGIA ";
					}else if(opcionSeleccionada=="804"){
					    capa.innerHTML="FUNDAMENTOS SOBRE PROYECTOS E INFORMATICA ";
					}else if(opcionSeleccionada=="805"){
					    capa.innerHTML="TECNICAS DE GESTION TURISTICA Y HOTELERA ";
					}else if(opcionSeleccionada=="806"){
					    capa.innerHTML="TALLERES ACLE ";
					}else if(opcionSeleccionada=="807"){
					    capa.innerHTML="ETNOGRAFIA MUSICAL ";
					}else if(opcionSeleccionada=="808"){
					    capa.innerHTML="INSTRUMENTO ";
					}else if(opcionSeleccionada=="809"){
					    capa.innerHTML="CONJUNTO INSTRUMENTAL ";
					}else if(opcionSeleccionada=="810"){
					    capa.innerHTML="TALLER DE PINTURA ";
					}else if(opcionSeleccionada=="811"){
					    capa.innerHTML="TALLER DE TEATRO O PINTURA ";
					}else if(opcionSeleccionada=="812"){
					    capa.innerHTML="TALLER RECREATIVO Y DEPORTE ";
					}else if(opcionSeleccionada=="813"){
					    capa.innerHTML="COMPUTACION I ";
					}else if(opcionSeleccionada=="814"){
					    capa.innerHTML="GEOGRAFIA, TURISMO Y EDUCACION AMBIENTAL ";
					}else if(opcionSeleccionada=="815"){
					    capa.innerHTML="CONTABILIDAD Y COMERCIALIZACION ";
					}else if(opcionSeleccionada=="816"){
					    capa.innerHTML="CULTURA Y TURISMO GESTION Y SERVICIOS ";
					}else if(opcionSeleccionada=="817"){
					    capa.innerHTML="ARTES INTEGRADAS ";
					}else if(opcionSeleccionada=="818"){
					    capa.innerHTML="COMPUTACION II ";
					}else if(opcionSeleccionada=="819"){
					    capa.innerHTML="TALLERES JECCD ";
					}else if(opcionSeleccionada=="820"){
					    capa.innerHTML="CREACION PLASTICA ";
					}else if(opcionSeleccionada=="821"){
					    capa.innerHTML="CREACION MELODICA ";
					}else if(opcionSeleccionada=="822"){
					    capa.innerHTML="EXPRESION MELODICA ";
					}else if(opcionSeleccionada=="823"){
					    capa.innerHTML="TALLER Y LABORATORIO BASICO ";
					}else if(opcionSeleccionada=="824"){
					    capa.innerHTML="LAS MUJERES Y LOS JOVENES A TRAVES DE LA HISTORIA ";
					}else if(opcionSeleccionada=="825"){
					    capa.innerHTML="TALLER DE CREACIONES ";
					}else if(opcionSeleccionada=="826"){
					    capa.innerHTML="TALLER DE EXPLORACION VOCACIONAL ";
					}else if(opcionSeleccionada=="827"){
					    capa.innerHTML="TALLER DE FORMACION TECNICO VOCACIONAL ";
					}else if(opcionSeleccionada=="828"){
					    capa.innerHTML="IDIOMA EXTRANJERO (HEBREO) ";
					}else if(opcionSeleccionada=="829"){
					    capa.innerHTML="DESARROLLO Y CRECIMIENTO PERSONAL ";
					}else if(opcionSeleccionada=="830"){
					    capa.innerHTML="ELECTIVO CULTURAL ARTISTICO ";
					}else if(opcionSeleccionada=="831"){
					    capa.innerHTML="CULTURA Y CIVILIZACION FRANCESA ";
					}else if(opcionSeleccionada=="832"){
					    capa.innerHTML="RECURSOS NATURALES ";
					}else if(opcionSeleccionada=="833"){
					    capa.innerHTML="PRONUNCIACION INGLESA ELEMENTAL ";
					}else if(opcionSeleccionada=="834"){
					    capa.innerHTML="GEOMETRIA PLANA ";
					}else if(opcionSeleccionada=="835"){
					    capa.innerHTML="GEOGRAFIA REGIONAL ";
					}else if(opcionSeleccionada=="836"){
					    capa.innerHTML="APLICACIONES TECNOLOGICAS ";
					}else if(opcionSeleccionada=="837"){
					    capa.innerHTML="EDUCACION CRISTIANA ";
					}else if(opcionSeleccionada=="838"){
					    capa.innerHTML="TALLER DE LA ESPIRITUALIDAD SALESIANA ";
					}else if(opcionSeleccionada=="839"){
					    capa.innerHTML="COM 2000 ";
					}else if(opcionSeleccionada=="840"){
					    capa.innerHTML="TALLER DE GIMNASIA ";
					}else if(opcionSeleccionada=="841"){
					    capa.innerHTML="TALLER DE GIMNASIA ARTISTICA ";
					}else if(opcionSeleccionada=="842"){
					    capa.innerHTML="ACTIVIDADES COMPLEMENTARIAS ";
					}else if(opcionSeleccionada=="843"){
					    capa.innerHTML="HORAS DE LIBRE DISPOSICION ";
					}else if(opcionSeleccionada=="844"){
					    capa.innerHTML="TEJIDO BORDADO ";
					}else if(opcionSeleccionada=="845"){
					    capa.innerHTML="EDUCACION PARA EL PENSAR ";
					}else if(opcionSeleccionada=="846"){
					    capa.innerHTML="HISTORIA Y LITERATURA DE CHILOE ";
					}else if(opcionSeleccionada=="847"){
					    capa.innerHTML="COMUNICACION Y PRODUCCION RADIAL ";
					}else if(opcionSeleccionada=="848"){
					    capa.innerHTML="CULTURA MITICA Y LITERATURA DE CHILOE ";
					}else if(opcionSeleccionada=="849"){
					    capa.innerHTML="RECURSOS NATURALES LOCALES Y SU APLICACION ";
					}else if(opcionSeleccionada=="850"){
					    capa.innerHTML="CONSTRUCCION Y ARTESANIA LOCAL ";
					}else if(opcionSeleccionada=="851"){
					    capa.innerHTML="FOLKLORE LOCAL ";
					}else if(opcionSeleccionada=="852"){
					    capa.innerHTML="DOCTRINA SOCIAL DE LA IGLESIA ";
					}else if(opcionSeleccionada=="853"){
					    capa.innerHTML="ANALISIS DE LAS CRISIS DE LA MODERNIDAD OCCIDENTAL ";
					}else if(opcionSeleccionada=="854"){
					    capa.innerHTML="LITERATURA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="855"){
					    capa.innerHTML="HISTORIA CONTEMPORANEA ";
					}else if(opcionSeleccionada=="856"){
					    capa.innerHTML="GEOGRAFIA HUMANA ";
					}else if(opcionSeleccionada=="857"){
					    capa.innerHTML="FUNDAMENTOS DE FISICA ";
					}else if(opcionSeleccionada=="858"){
					    capa.innerHTML="FUNDAMENTOS DE QUIMICA ";
					}else if(opcionSeleccionada=="859"){
					    capa.innerHTML="FUNDAMENTOS DE MATEMATICA SUPERIOR ";
					}else if(opcionSeleccionada=="860"){
					    capa.innerHTML="GEOGRAFIA ";
					}else if(opcionSeleccionada=="861"){
					    capa.innerHTML="ANALISIS DE PROBLEMAS SOCIALES CONTEMPORANEO ";
					}else if(opcionSeleccionada=="862"){
					    capa.innerHTML="MATEMATICA I ";
					}else if(opcionSeleccionada=="863"){
					    capa.innerHTML="MATEMATICA II ";
					}else if(opcionSeleccionada=="864"){
					    capa.innerHTML="MATEMATICA BASICA ";
					}else if(opcionSeleccionada=="865"){
					    capa.innerHTML="MATEMATICA GENERAL ";
					}else if(opcionSeleccionada=="866"){
					    capa.innerHTML="LITERATURA I ";
					}else if(opcionSeleccionada=="867"){
					    capa.innerHTML="LITERATURA II ";
					}else if(opcionSeleccionada=="868"){
					    capa.innerHTML="FISICA I ";
					}else if(opcionSeleccionada=="869"){
					    capa.innerHTML="FISICA II ";
					}else if(opcionSeleccionada=="870"){
					    capa.innerHTML="BIOLOGIA I ";
					}else if(opcionSeleccionada=="871"){
					    capa.innerHTML="BIOLOGIA II ";
					}else if(opcionSeleccionada=="872"){
					    capa.innerHTML="BIOLOGIA III ";
					}else if(opcionSeleccionada=="873"){
					    capa.innerHTML="ARTE Y CULTURA I ";
					}else if(opcionSeleccionada=="874"){
					    capa.innerHTML="ARTE Y CULTURA II ";
					}else if(opcionSeleccionada=="875"){
					    capa.innerHTML="HISTORIA DE OCCIDENTE ";
					}else if(opcionSeleccionada=="876"){
					    capa.innerHTML="HISTORIA DE OCCIDENTE I ";
					}else if(opcionSeleccionada=="877"){
					    capa.innerHTML="HISTORIA DE OCCIDENTE II ";
					}else if(opcionSeleccionada=="878"){
					    capa.innerHTML="HISTORIA DE OCCIDENTE III ";
					}else if(opcionSeleccionada=="879"){
					    capa.innerHTML="MICROECONOMIA ";
					}else if(opcionSeleccionada=="880"){
					    capa.innerHTML="LITERATURA GENERAL ";
					}else if(opcionSeleccionada=="881"){
					    capa.innerHTML="QUIMICA GENERAL ";
					}else if(opcionSeleccionada=="882"){
					    capa.innerHTML="FISICA GENERAL ";
					}else if(opcionSeleccionada=="883"){
					    capa.innerHTML="MATEMATICA COMUN ";
					}else if(opcionSeleccionada=="884"){
					    capa.innerHTML="HISTORIA HUMANA Y GEOGRAFIA GENERAL ";
					}else if(opcionSeleccionada=="885"){
					    capa.innerHTML="TALLER DE INVESTIGACION EL SECRETO DE LA VIDA ";
					}else if(opcionSeleccionada=="886"){
					    capa.innerHTML="TALLER LA PERSONA HUMANA Y SU ENTORNO ";
					}else if(opcionSeleccionada=="887"){
					    capa.innerHTML="TALLER AUTOESTIMA Y APRENDIZAJE ";
					}else if(opcionSeleccionada=="888"){
					    capa.innerHTML="TALLER DE ACTUALIZACION INFORMATICA ";
					}else if(opcionSeleccionada=="889"){
					    capa.innerHTML="TALLER DE SERES VIVOS Y MEDIO AMBIENTE REGIONAL ";
					}else if(opcionSeleccionada=="890"){
					    capa.innerHTML="TALLER ECOLOGIA Y DESARROLLO HUMANO ";
					}else if(opcionSeleccionada=="891"){
					    capa.innerHTML="TALLER INFORMATICA Y CONTROL AGROFORESTAL ";
					}else if(opcionSeleccionada=="892"){
					    capa.innerHTML="TALLER TECNICAS DE ESTUDIOS ";
					}else if(opcionSeleccionada=="893"){
					    capa.innerHTML="COMUNICACION Y LIDERAZGO EN EL AMBITO MARITIMO ";
					}else if(opcionSeleccionada=="894"){
					    capa.innerHTML="HIGIENE Y SEGURIDAD EN EL AMBITO MARITIMO ";
					}else if(opcionSeleccionada=="895"){
					    capa.innerHTML="NAUTICA Y MANIOBRAS ";
					}else if(opcionSeleccionada=="896"){
					    capa.innerHTML="TALLER MADERERO ";
					}else if(opcionSeleccionada=="897"){
					    capa.innerHTML="TALLER DE ESTRUCTURAS METALICAS ";
					}else if(opcionSeleccionada=="898"){
					    capa.innerHTML="TALLER DE REDACCION Y DIGITACION ";
					}else if(opcionSeleccionada=="899"){
					    capa.innerHTML="TALLER EMPRESA Y MOVIMIENTO MERCANTIL ";
					}else if(opcionSeleccionada=="900"){
					    capa.innerHTML="TALLER DE ANALISIS DE OPERACIONES Y NORMATIVA DEL SISTEMA EMPRESARIAL ";
					}else if(opcionSeleccionada=="901"){
					    capa.innerHTML="HUMANIZACION ";
					}else if(opcionSeleccionada=="902"){
					    capa.innerHTML="INTRODUCCION AL TRABAJO DE OFICINA ";
					}else if(opcionSeleccionada=="903"){
					    capa.innerHTML="INICIACION AL MUNDO DE LOS NEGOCIOS ";
					}else if(opcionSeleccionada=="904"){
					    capa.innerHTML="TALLER LIBRE ELECCION ";
					}else if(opcionSeleccionada=="905"){
					    capa.innerHTML="FORMACION FAMILIAR Y COMUNITARIA ";
					}else if(opcionSeleccionada=="906"){
					    capa.innerHTML="ESPIRITU EMPRENDEDOR ";
					}else if(opcionSeleccionada=="907"){
					    capa.innerHTML="PRACTICO VERBAL ";
					}else if(opcionSeleccionada=="908"){
					    capa.innerHTML="PRACTICO MATEMATICO ";
					}else if(opcionSeleccionada=="909"){
					    capa.innerHTML="TALLER DE SERVICIO GASTRONOMICO ";
					}else if(opcionSeleccionada=="910"){
					    capa.innerHTML="TALLER DE SERVICIO GASTRONOMICO II ";
					}else if(opcionSeleccionada=="911"){
					    capa.innerHTML="TALLER DE LENCERIA ";
					}else if(opcionSeleccionada=="912"){
					    capa.innerHTML="TALLER DE LIMPIEZA Y MANTENCION ";
					}else if(opcionSeleccionada=="913"){
					    capa.innerHTML="TALLER DE LIMPIEZA Y MANTENCION II ";
					}else if(opcionSeleccionada=="914"){
					    capa.innerHTML="PRACTICA TECNOLOGICA ";
					}else if(opcionSeleccionada=="915"){
					    capa.innerHTML="ORIENTACION PERSONAL Y PROFESIONAL ";
					}else if(opcionSeleccionada=="916"){
					    capa.innerHTML="TALLER DE FORMACION PERSONAL Y SOCIAL ";
					}else if(opcionSeleccionada=="917"){
					    capa.innerHTML="TALLER DE CULTURA Y EXTENSION ";
					}else if(opcionSeleccionada=="918"){
					    capa.innerHTML="TALLER DE RECURSOS NATURALES ";
					}else if(opcionSeleccionada=="919"){
					    capa.innerHTML="TALLER DE RECURSOS FORESTALES ";
					}else if(opcionSeleccionada=="920"){
					    capa.innerHTML="TALLER EXPLORATORIO DE CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="921"){
					    capa.innerHTML="DIBUJO TECNICO Y METROLOGIA ";
					}else if(opcionSeleccionada=="922"){
					    capa.innerHTML="DESARROLLO PERSONAL Y VOCACIONAL ";
					}else if(opcionSeleccionada=="923"){
					    capa.innerHTML="TALLER DE ADMINISTRACION ";
					}else if(opcionSeleccionada=="924"){
					    capa.innerHTML="TALLER DE ADMINISTRACION II ";
					}else if(opcionSeleccionada=="925"){
					    capa.innerHTML="TALLER ELABORACION INDUSTRIAL DE ALIMENTOS ";
					}else if(opcionSeleccionada=="926"){
					    capa.innerHTML="TALLER ELABORACION INDUSTRIAL DE ALIMENTOS II ";
					}else if(opcionSeleccionada=="927"){
					    capa.innerHTML="INFORMATICA BASICA ";
					}else if(opcionSeleccionada=="928"){
					    capa.innerHTML="INFORMATICA BASICA II ";
					}else if(opcionSeleccionada=="929"){
					    capa.innerHTML="TALLER FORESTAL ";
					}else if(opcionSeleccionada=="930"){
					    capa.innerHTML="TALLER FORESTAL II ";
					}else if(opcionSeleccionada=="931"){
					    capa.innerHTML="ACTIVIDADES CURRICULARES DE LIBRE ELECCION ";
					}else if(opcionSeleccionada=="932"){
					    capa.innerHTML="CONOCIENDO EL COMPUTADOR ";
					}else if(opcionSeleccionada=="933"){
					    capa.innerHTML="TALLER BASICO CONTABLE ";
					}else if(opcionSeleccionada=="934"){
					    capa.innerHTML="DISENO DE VESTUARIO Y AMBIENTE INFANTIL ";
					}else if(opcionSeleccionada=="935"){
					    capa.innerHTML="USO Y MANEJO DE EQUIPOS ";
					}else if(opcionSeleccionada=="936"){
					    capa.innerHTML="INTRODUCCION AL COMERCIO Y LA ADMINISTRACION ";
					}else if(opcionSeleccionada=="937"){
					    capa.innerHTML="INTRODUCCION A LA LEGISLACION TRIBUTARIA LABORAL ";
					}else if(opcionSeleccionada=="938"){
					    capa.innerHTML="DESARROLLO PERSONAL DEL ADOLESCENTE ";
					}else if(opcionSeleccionada=="939"){
					    capa.innerHTML="TALLER DE DIGITACION ";
					}else if(opcionSeleccionada=="940"){
					    capa.innerHTML="NOCIONES DE ADMINISTRACION Y COMERCIO ";
					}else if(opcionSeleccionada=="941"){
					    capa.innerHTML="TALLERES EXPLORATORIOS ";
					}else if(opcionSeleccionada=="942"){
					    capa.innerHTML="TALLER EXPLORATORIO DE ESPECIALIDAD ";
					}else if(opcionSeleccionada=="943"){
					    capa.innerHTML="DESARROLLO PERSONAL Y PROFESIONAL ";
					}else if(opcionSeleccionada=="944"){
					    capa.innerHTML="MEDIOS TECNOLOGICOS ";
					}else if(opcionSeleccionada=="945"){
					    capa.innerHTML="SERVICIOS ALIMENTICIOS ";
					}else if(opcionSeleccionada=="946"){
					    capa.innerHTML="SERVICIOS SECRETARIALES ";
					}else if(opcionSeleccionada=="947"){
					    capa.innerHTML="EL RECURSO FORESTAL EN CHILE ";
					}else if(opcionSeleccionada=="948"){
					    capa.innerHTML="EL DESARROLLO INDUSTRIAL EN EL MUNDO ";
					}else if(opcionSeleccionada=="949"){
					    capa.innerHTML="EL DIBUJO TECNICO EN LA INDUSTRIA ";
					}else if(opcionSeleccionada=="950"){
					    capa.innerHTML="TALLER INDUSTRIALIZACION DE LA MADERA ";
					}else if(opcionSeleccionada=="951"){
					    capa.innerHTML="TALLER EXPLORATORIO PARA LA DECISION VOCACIONAL ";
					}else if(opcionSeleccionada=="952"){
					    capa.innerHTML="INVESTIGACION APLICADA ";
					}else if(opcionSeleccionada=="953"){
					    capa.innerHTML="MANUALIDADES AGROPECUARIAS ";
					}else if(opcionSeleccionada=="954"){
					    capa.innerHTML="INTRODUCCION A LA PRODUCCION AGROPECUARIA ";
					}else if(opcionSeleccionada=="955"){
					    capa.innerHTML="TRABAJOS EN TERRENO ";
					}else if(opcionSeleccionada=="956"){
					    capa.innerHTML="INTRODUCCION A LA ANATOMIA ANIMAL ";
					}else if(opcionSeleccionada=="957"){
					    capa.innerHTML="INTRODUCCION A LA PRODUCCION ANIMAL ";
					}else if(opcionSeleccionada=="958"){
					    capa.innerHTML="INTRODUCCION A LA BOTANICA GENERAL ";
					}else if(opcionSeleccionada=="959"){
					    capa.innerHTML="GENERALIDADES DE LAS HORTALIZAS Y FRUTALES EN LA ALIMENTACION HUMANA Y PECUARIA ";
					}else if(opcionSeleccionada=="960"){
					    capa.innerHTML="SANIDAD FORESTAL Y CONTROL DE PLAGAS ";
					}else if(opcionSeleccionada=="961"){
					    capa.innerHTML="RELACIONES INTERPERSONALES EN LA GESTION MODERNA ";
					}else if(opcionSeleccionada=="962"){
					    capa.innerHTML="TALLER 1 ";
					}else if(opcionSeleccionada=="963"){
					    capa.innerHTML="TALLER 2 ";
					}else if(opcionSeleccionada=="964"){
					    capa.innerHTML="TALLER 3 ";
					}else if(opcionSeleccionada=="965"){
					    capa.innerHTML="INTRODUCCION A LA AGRICULTURA ";
					}else if(opcionSeleccionada=="966"){
					    capa.innerHTML="AUTONOMIA PERSONAL Y LABORAL ";
					}else if(opcionSeleccionada=="967"){
					    capa.innerHTML="COMPUTACION EN EL SIGLO XXI ";
					}else if(opcionSeleccionada=="968"){
					    capa.innerHTML="EXPLORACION AL MUNDO AGROPECUARIO ";
					}else if(opcionSeleccionada=="969"){
					    capa.innerHTML="INICIACION A LA GASTRONOMIA ";
					}else if(opcionSeleccionada=="970"){
					    capa.innerHTML="INTRODUCCION A LA ADMINISTRACION ";
					}else if(opcionSeleccionada=="971"){
					    capa.innerHTML="ORIENTACION PERSONAL Y VOCACIONAL ";
					}else if(opcionSeleccionada=="972"){
					    capa.innerHTML="TECNOLOGIAS INTEGRADAS ";
					}else if(opcionSeleccionada=="973"){
					    capa.innerHTML="LENGUAJES TECNOLOGICOS GRAFICOS ";
					}else if(opcionSeleccionada=="974"){
					    capa.innerHTML="VALORES FORMATIVOS ";
					}else if(opcionSeleccionada=="975"){
					    capa.innerHTML="BIBLIOTECA DE COMPUTACION ";
					}else if(opcionSeleccionada=="976"){
					    capa.innerHTML="TALLER EXPLORATORIO DE EDUCACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="977"){
					    capa.innerHTML="TALLER EXPLORATORIO DE AREA COMERCIAL ";
					}else if(opcionSeleccionada=="978"){
					    capa.innerHTML="PROCESOS PRODUCTIVOS ";
					}else if(opcionSeleccionada=="979"){
					    capa.innerHTML="TALLER EXPLORATORIO DE ALIMENTACION ";
					}else if(opcionSeleccionada=="980"){
					    capa.innerHTML="TALLER EXPLORATORIO DE CONFECCION ";
					}else if(opcionSeleccionada=="981"){
					    capa.innerHTML="TALLER EXPLORATORIO DE PROGRAMAS Y PROYECTOS SOCIALES ";
					}else if(opcionSeleccionada=="982"){
					    capa.innerHTML="HISTORIA DE CHILE ";
					}else if(opcionSeleccionada=="983"){
					    capa.innerHTML="TALLER DE CORTE Y CONFECCION ";
					}else if(opcionSeleccionada=="984"){
					    capa.innerHTML="TALLER DE ELECTRICIDAD ";
					}else if(opcionSeleccionada=="985"){
					    capa.innerHTML="VISION DE LA SOCIEDAD CONTEMPORANEA ";
					}else if(opcionSeleccionada=="986"){
					    capa.innerHTML="TECNOLOGIA DE LA INFORMACION ";
					}else if(opcionSeleccionada=="987"){
					    capa.innerHTML="IDIOMA EXTRANJERO COMPLEMENTARIO INGLES O FRANCES ";
					}else if(opcionSeleccionada=="988"){
					    capa.innerHTML="P A A VERBAL ";
					}else if(opcionSeleccionada=="989"){
					    capa.innerHTML="P A A MATEMATICA ";
					}else if(opcionSeleccionada=="990"){
					    capa.innerHTML="VALORES ";
					}else if(opcionSeleccionada=="991"){
					    capa.innerHTML="EXPLORANDO LA TECNOLOGIA ";
					}else if(opcionSeleccionada=="992"){
					    capa.innerHTML="LECTURA COMUN ";
					}else if(opcionSeleccionada=="993"){
					    capa.innerHTML="CUESTIONES DE ACTUALIDAD ";
					}else if(opcionSeleccionada=="994"){
					    capa.innerHTML="CLUB ";
					}else if(opcionSeleccionada=="995"){
					    capa.innerHTML="EDUCACION TECNICO FORESTAL ";
					}else if(opcionSeleccionada=="996"){
					    capa.innerHTML="EDUCACION TECNICO FORESTAL I ";
					}else if(opcionSeleccionada=="997"){
					    capa.innerHTML="EDUCACION TECNICO FORESTAL II ";
					}else if(opcionSeleccionada=="998"){
					    capa.innerHTML="FRANCES ";
					}else if(opcionSeleccionada=="50012"){
					    capa.innerHTML="MATEMATICA PLUS ";
					}else if(opcionSeleccionada=="1000"){
					    capa.innerHTML="VIDAS NUMEROS Y FORMAS ";
					}else if(opcionSeleccionada=="1001"){
					    capa.innerHTML="ACCESORIOS TECNICOS ";
					}else if(opcionSeleccionada=="1002"){
					    capa.innerHTML="ACONDICIONAMIENTO FISICO ";
					}else if(opcionSeleccionada=="1003"){
					    capa.innerHTML="ACTIVIDADES MANUALES ";
					}else if(opcionSeleccionada=="1004"){
					    capa.innerHTML="ACTIVIDADES RECREATIVAS ";
					}else if(opcionSeleccionada=="1005"){
					    capa.innerHTML="ADMINISTRACION HOTELERA ";
					}else if(opcionSeleccionada=="1006"){
					    capa.innerHTML="ADMINISTRACION DE ALIMENTACION COLECTIVA ";
					}else if(opcionSeleccionada=="1007"){
					    capa.innerHTML="ADMINISTRACION DE EMPRESA ";
					}else if(opcionSeleccionada=="1008"){
					    capa.innerHTML="ADMINISTRACION DE LA PRODUCCION ";
					}else if(opcionSeleccionada=="1009"){
					    capa.innerHTML="ADMINISTRACION DE OFICINA ";
					}else if(opcionSeleccionada=="1010"){
					    capa.innerHTML="ADMINISTRACION DE PERSONAL ";
					}else if(opcionSeleccionada=="1011"){
					    capa.innerHTML="ADMINISTRACION DE RECURSOS HUMANOS ";
					}else if(opcionSeleccionada=="1012"){
					    capa.innerHTML="ADMINISTRACION DE SERVICIOS ALIMENTARIOS ";
					}else if(opcionSeleccionada=="1013"){
					    capa.innerHTML="ADMINISTRACION DE SERVICIOS DE ALIMENTACION ";
					}else if(opcionSeleccionada=="1014"){
					    capa.innerHTML="ADMINISTRACION DE SERVICIOS DE ALIMENTOS ";
					}else if(opcionSeleccionada=="1015"){
					    capa.innerHTML="ADMINISTRACION DE SUPERMERCADOS ";
					}else if(opcionSeleccionada=="1016"){
					    capa.innerHTML="ADMINISTRACION DE VENTAS ";
					}else if(opcionSeleccionada=="1017"){
					    capa.innerHTML="ADMINISTRACION DEL ABASTECIMIENTO ";
					}else if(opcionSeleccionada=="1018"){
					    capa.innerHTML="ADMINISTRACION DEL AGRO ";
					}else if(opcionSeleccionada=="1019"){
					    capa.innerHTML="ADMINISTRACION FINANCIERA ";
					}else if(opcionSeleccionada=="1020"){
					    capa.innerHTML="ADMINISTRACION GENERAL ";
					}else if(opcionSeleccionada=="1021"){
					    capa.innerHTML="ADMINISTRACION INDUSTRIAL ";
					}else if(opcionSeleccionada=="1022"){
					    capa.innerHTML="ADMINISTRACION TURISTICA ";
					}else if(opcionSeleccionada=="1023"){
					    capa.innerHTML="ADMINISTRACION TURISTICA Y HOTELERA ";
					}else if(opcionSeleccionada=="1024"){
					    capa.innerHTML="ADMINISTRACION Y COMERCIALIZACION ";
					}else if(opcionSeleccionada=="1025"){
					    capa.innerHTML="ADMINISTRACION Y ECONOMIA ";
					}else if(opcionSeleccionada=="1026"){
					    capa.innerHTML="ADMINISTRACION Y GESTION ";
					}else if(opcionSeleccionada=="1027"){
					    capa.innerHTML="ADMINISTRACION Y GESTION DE EMPRESAS ";
					}else if(opcionSeleccionada=="1028"){
					    capa.innerHTML="ADMINISTRACION Y LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="1029"){
					    capa.innerHTML="ADMINISTRACION Y ORGANIZACION ";
					}else if(opcionSeleccionada=="1030"){
					    capa.innerHTML="ADMINISTRACION Y ORGANIZACION DE OFICINA ";
					}else if(opcionSeleccionada=="1031"){
					    capa.innerHTML="ADMINISTRACION Y RELACIONES PUBLICAS ";
					}else if(opcionSeleccionada=="1032"){
					    capa.innerHTML="ADMINISTRACION Y SEGURIDAD SOCIAL ";
					}else if(opcionSeleccionada=="1033"){
					    capa.innerHTML="ADUANA ";
					}else if(opcionSeleccionada=="1034"){
					    capa.innerHTML="AFINAMIENTO DE MOTORES ";
					}else if(opcionSeleccionada=="1035"){
					    capa.innerHTML="AGENCIA DE VIAJES Y TRANSPORTE TURISTICO ";
					}else if(opcionSeleccionada=="1036"){
					    capa.innerHTML="AGROECOLOGIA ";
					}else if(opcionSeleccionada=="1037"){
					    capa.innerHTML="AGROMETEOLOGIA Y HORTICULTURA GENERAL ";
					}else if(opcionSeleccionada=="1038"){
					    capa.innerHTML="AGROTURISMO ";
					}else if(opcionSeleccionada=="1039"){
					    capa.innerHTML="ALIMENTACION ";
					}else if(opcionSeleccionada=="1040"){
					    capa.innerHTML="ALIMENTACION COLECTIVA ";
					}else if(opcionSeleccionada=="1041"){
					    capa.innerHTML="ALIMENTACION DE PARVULOS ";
					}else if(opcionSeleccionada=="1042"){
					    capa.innerHTML="ALIMENTACION DEL PRE-ESCOLAR ";
					}else if(opcionSeleccionada=="1043"){
					    capa.innerHTML="ALIMENTACION PRE-ESCOLAR ";
					}else if(opcionSeleccionada=="1044"){
					    capa.innerHTML="ALIMENTACION Y DIETETICA ";
					}else if(opcionSeleccionada=="1045"){
					    capa.innerHTML="ANALISIS DE CIRCUITO ";
					}else if(opcionSeleccionada=="1046"){
					    capa.innerHTML="ANALISIS DE SISTEMA ";
					}else if(opcionSeleccionada=="1047"){
					    capa.innerHTML="ANALISIS FISICO DE LOS PRODUCTOS TEXTILES ";
					}else if(opcionSeleccionada=="1048"){
					    capa.innerHTML="ANIMACION DE GRUPOS TURISTICOS ";
					}else if(opcionSeleccionada=="1049"){
					    capa.innerHTML="APARADO Y ORNAMENTACION DE CALZADO ";
					}else if(opcionSeleccionada=="1050"){
					    capa.innerHTML="APICULTURA I ";
					}else if(opcionSeleccionada=="1051"){
					    capa.innerHTML="APICULTURA II ";
					}else if(opcionSeleccionada=="1052"){
					    capa.innerHTML="APLICACIONES COMPUTACIONALES ";
					}else if(opcionSeleccionada=="1053"){
					    capa.innerHTML="APLICACIONES COMPUTACIONALES CONTABLES ";
					}else if(opcionSeleccionada=="1054"){
					    capa.innerHTML="APLICACIONES COMPUTACIONALES TEXTILES ";
					}else if(opcionSeleccionada=="1055"){
					    capa.innerHTML="ARCHIVO ";
					}else if(opcionSeleccionada=="1056"){
					    capa.innerHTML="ARTE CULINARIO ";
					}else if(opcionSeleccionada=="1057"){
					    capa.innerHTML="ARTES APLICADAS ";
					}else if(opcionSeleccionada=="1058"){
					    capa.innerHTML="ARTESANIA TEXTIL ";
					}else if(opcionSeleccionada=="1059"){
					    capa.innerHTML="ARTICULOS PARA EL HOGAR ";
					}else if(opcionSeleccionada=="1060"){
					    capa.innerHTML="ATENCION DE PARVULO DIFERENCIAL ";
					}else if(opcionSeleccionada=="1061"){
					    capa.innerHTML="ATENCION PRE-ESCOLAR ";
					}else if(opcionSeleccionada=="1062"){
					    capa.innerHTML="ATENCION SOCIAL ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="1063"){
					    capa.innerHTML="AUDITORIA ";
					}else if(opcionSeleccionada=="1064"){
					    capa.innerHTML="AUTOGESTION ";
					}else if(opcionSeleccionada=="1065"){
					    capa.innerHTML="AVIONICA ";
					}else if(opcionSeleccionada=="1066"){
					    capa.innerHTML="BANCA DE DATOS Y ARCHIVO ";
					}else if(opcionSeleccionada=="1067"){
					    capa.innerHTML="BANQUETES Y EVENTOS ";
					}else if(opcionSeleccionada=="1068"){
					    capa.innerHTML="BASE DE DATOS ";
					}else if(opcionSeleccionada=="1069"){
					    capa.innerHTML="BEBIDAS ALIMENTACION Y BAR ";
					}else if(opcionSeleccionada=="1070"){
					    capa.innerHTML="BIENESTAR SOCIAL ";
					}else if(opcionSeleccionada=="1071"){
					    capa.innerHTML="BIOLOGIA APLICADA ";
					}else if(opcionSeleccionada=="1072"){
					    capa.innerHTML="BIOLOGIA GENERAL ";
					}else if(opcionSeleccionada=="1073"){
					    capa.innerHTML="BIOQUIMICA ";
					}else if(opcionSeleccionada=="1074"){
					    capa.innerHTML="BIOQUIMICA BASICA ";
					}else if(opcionSeleccionada=="1075"){
					    capa.innerHTML="BOTANICA GENERAL ";
					}else if(opcionSeleccionada=="1076"){
					    capa.innerHTML="CARACTERIZACION DEL NINO DISCAPACITADO ";
					}else if(opcionSeleccionada=="1077"){
					    capa.innerHTML="CARPINTERIA ";
					}else if(opcionSeleccionada=="1078"){
					    capa.innerHTML="CARPINTERIA DE TERMINACIONES ";
					}else if(opcionSeleccionada=="1079"){
					    capa.innerHTML="CENTRALES TELEFONICAS ";
					}else if(opcionSeleccionada=="1080"){
					    capa.innerHTML="CEREMONIAL Y PROTOCOLO ";
					}else if(opcionSeleccionada=="1081"){
					    capa.innerHTML="CIENCIAS APLICADAS ";
					}else if(opcionSeleccionada=="1082"){
					    capa.innerHTML="CIENCIAS APLICADAS AL ALMACENAMIENTO ";
					}else if(opcionSeleccionada=="1083"){
					    capa.innerHTML="CIRCUITOS ELECTRICOS ";
					}else if(opcionSeleccionada=="1084"){
					    capa.innerHTML="COCINA INTERNACIONAL ";
					}else if(opcionSeleccionada=="1085"){
					    capa.innerHTML="COCINA Y REPOSTERIA ";
					}else if(opcionSeleccionada=="1086"){
					    capa.innerHTML="COMBUSTION INTERNA ";
					}else if(opcionSeleccionada=="1087"){
					    capa.innerHTML="COMERCIALIZACION Y ECONOMIA ";
					}else if(opcionSeleccionada=="1088"){
					    capa.innerHTML="COMERCIO EXTERIOR ";
					}else if(opcionSeleccionada=="1089"){
					    capa.innerHTML="COMERCIO EXTERIOR Y DOCUMENTACION CONTABLE ";
					}else if(opcionSeleccionada=="1090"){
					    capa.innerHTML="COMPORTAMIENTO HUMANO DE LA ORGANIZACION ";
					}else if(opcionSeleccionada=="1091"){
					    capa.innerHTML="COMPRENSION DEL LENGUAJE ORAL Y ESCRITO ";
					}else if(opcionSeleccionada=="1092"){
					    capa.innerHTML="COMPUTACION APLICADA Y LABORATORIO ";
					}else if(opcionSeleccionada=="1093"){
					    capa.innerHTML="COMPUTACION BASICA ";
					}else if(opcionSeleccionada=="1094"){
					    capa.innerHTML="COMPUTACION DIGITAL ";
					}else if(opcionSeleccionada=="1095"){
					    capa.innerHTML="COMPUTADORES PERSONALES ";
					}else if(opcionSeleccionada=="1096"){
					    capa.innerHTML="COMUNICACION AUDIOVISUAL Y PUBLICITARIA ";
					}else if(opcionSeleccionada=="1097"){
					    capa.innerHTML="COMUNICACION LINGUISTICA ";
					}else if(opcionSeleccionada=="1098"){
					    capa.innerHTML="COMUNICACION SOCIAL ";
					}else if(opcionSeleccionada=="1099"){
					    capa.innerHTML="COMUNICACION Y ORATORIA ";
					}else if(opcionSeleccionada=="1100"){
					    capa.innerHTML="COMUNICACIONES Y RELACIONES PUBLICAS ";
					}else if(opcionSeleccionada=="1101"){
					    capa.innerHTML="CONFECCION ";
					}else if(opcionSeleccionada=="1102"){
					    capa.innerHTML="CONFECCION INFANTIL Y ADULTO ";
					}else if(opcionSeleccionada=="1103"){
					    capa.innerHTML="CONSERVACION ";
					}else if(opcionSeleccionada=="1104"){
					    capa.innerHTML="CONSERVACION DE ALIMENTOS ";
					}else if(opcionSeleccionada=="1105"){
					    capa.innerHTML="CONSTRUCCION ";
					}else if(opcionSeleccionada=="1106"){
					    capa.innerHTML="CONTABILIDAD DE COSTO ";
					}else if(opcionSeleccionada=="1107"){
					    capa.innerHTML="CONTABILIDAD RURAL Y ADMINISTRACION AGRICOLA ";
					}else if(opcionSeleccionada=="1108"){
					    capa.innerHTML="CONTABILIDAD SUPERIOR ";
					}else if(opcionSeleccionada=="1109"){
					    capa.innerHTML="CONTROL AUTOMATICO ";
					}else if(opcionSeleccionada=="1110"){
					    capa.innerHTML="CONTROL AUTOMATICO Y SISTEMAS DIGITALES ";
					}else if(opcionSeleccionada=="1111"){
					    capa.innerHTML="CONTROL DE CALIDAD ";
					}else if(opcionSeleccionada=="1112"){
					    capa.innerHTML="CONTROL ESTADISTICO DE CALIDAD TOTAL ";
					}else if(opcionSeleccionada=="1113"){
					    capa.innerHTML="CONTROL Y COMANDO DE MAQUINAS ";
					}else if(opcionSeleccionada=="1114"){
					    capa.innerHTML="CONTROL Y PROGRAMACION DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1115"){
					    capa.innerHTML="CONTROLES DE VUELO ";
					}else if(opcionSeleccionada=="1116"){
					    capa.innerHTML="CORTADO DE ARTICULOS DE CUERO ";
					}else if(opcionSeleccionada=="1117"){
					    capa.innerHTML="CORTE Y CONFECCION DE VESTUARIO DE CUERO ";
					}else if(opcionSeleccionada=="1118"){
					    capa.innerHTML="COCTELERIA Y BANQUETE ";
					}else if(opcionSeleccionada=="1119"){
					    capa.innerHTML="COSTOS Y PRESUPUESTOS DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1120"){
					    capa.innerHTML="CUBICACION Y PRESUPUESTO ";
					}else if(opcionSeleccionada=="1121"){
					    capa.innerHTML="CUBICACIONES COSTOS Y PRESUPUESTOS ";
					}else if(opcionSeleccionada=="1122"){
					    capa.innerHTML="CUBICACIONES Y PRESUPUESTO ";
					}else if(opcionSeleccionada=="1123"){
					    capa.innerHTML="CULTIVOS Y FORRAJERAS ";
					}else if(opcionSeleccionada=="1124"){
					    capa.innerHTML="CULTURA FISICA Y DEPORTIVA ";
					}else if(opcionSeleccionada=="1125"){
					    capa.innerHTML="CULTURA GENERAL ";
					}else if(opcionSeleccionada=="1126"){
					    capa.innerHTML="CURRICULUM Y EVALUACION ";
					}else if(opcionSeleccionada=="1127"){
					    capa.innerHTML="DACTILOGRAFIA Y REDACCION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="1128"){
					    capa.innerHTML="DEPARTAMENTO DE VENTAS ";
					}else if(opcionSeleccionada=="1129"){
					    capa.innerHTML="DERECHO APLICADO ";
					}else if(opcionSeleccionada=="1130"){
					    capa.innerHTML="DERECHO CIVIL ";
					}else if(opcionSeleccionada=="1131"){
					    capa.innerHTML="DERECHO DEL MENOR ";
					}else if(opcionSeleccionada=="1132"){
					    capa.innerHTML="DERECHO DEL TRABAJO ";
					}else if(opcionSeleccionada=="1133"){
					    capa.innerHTML="DERECHO ECONOMICO Y COMERCIAL ";
					}else if(opcionSeleccionada=="1134"){
					    capa.innerHTML="DERECHO LABORAL ";
					}else if(opcionSeleccionada=="1135"){
					    capa.innerHTML="DERECHO LABORAL Y COMERCIAL ";
					}else if(opcionSeleccionada=="1136"){
					    capa.innerHTML="DERECHO PENAL Y PROCESAL ";
					}else if(opcionSeleccionada=="1137"){
					    capa.innerHTML="DERECHO TRIBUTARIO ";
					}else if(opcionSeleccionada=="1138"){
					    capa.innerHTML="DERECHO USUAL Y LABORAL ";
					}else if(opcionSeleccionada=="1139"){
					    capa.innerHTML="DERECHO Y LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="1140"){
					    capa.innerHTML="DESARROLLO BIOLOGICO ";
					}else if(opcionSeleccionada=="1141"){
					    capa.innerHTML="DESARROLLO COMUNITARIO ";
					}else if(opcionSeleccionada=="1142"){
					    capa.innerHTML="DESARROLLO CULTURAL ";
					}else if(opcionSeleccionada=="1143"){
					    capa.innerHTML="DESARROLLO DE LA CAPACIDAD EMPRENDEDORA DEL ALUMNO ";
					}else if(opcionSeleccionada=="1144"){
					    capa.innerHTML="DESARROLLO DEL ESPIRITU EMPRENDEDOR ";
					}else if(opcionSeleccionada=="1145"){
					    capa.innerHTML="DESARROLLO Y EXTENSION RURAL ";
					}else if(opcionSeleccionada=="1146"){
					    capa.innerHTML="DESARROLLO Y PUERICULTURA DEL PARVULO ";
					}else if(opcionSeleccionada=="1147"){
					    capa.innerHTML="DIAGRAMACION Y ELABORACION DE LA FORMA IMPRESORA ";
					}else if(opcionSeleccionada=="1148"){
					    capa.innerHTML="DIBUJO ASISTIDO POR COMPUTACION EN 3D ";
					}else if(opcionSeleccionada=="1149"){
					    capa.innerHTML="DIBUJO DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1150"){
					    capa.innerHTML="DIBUJO DE PLANOS ASISTIDOS POR COMPUTACION ";
					}else if(opcionSeleccionada=="1151"){
					    capa.innerHTML="DIBUJO DE REDES E INSTALACIONES ELECTRICAS ";
					}else if(opcionSeleccionada=="1152"){
					    capa.innerHTML="DIBUJO DE REDES E INSTALACIONES SANITARIAS ";
					}else if(opcionSeleccionada=="1153"){
					    capa.innerHTML="DIBUJO E INTERPRETACION ";
					}else if(opcionSeleccionada=="1154"){
					    capa.innerHTML="DIBUJO E INTERPRETACION DE PLANOS ";
					}else if(opcionSeleccionada=="1155"){
					    capa.innerHTML="DIBUJO APLICADO ";
					}else if(opcionSeleccionada=="1156"){
					    capa.innerHTML="DIBUJO TECNICO E INTERPRETACION DE PLANOS ELECTRICOS ";
					}else if(opcionSeleccionada=="1157"){
					    capa.innerHTML="DIBUJO TECNICO Y ARQUITECTONICO ";
					}else if(opcionSeleccionada=="1158"){
					    capa.innerHTML="DIBUJO TECNICO Y DISENO INDUSTRIAL ";
					}else if(opcionSeleccionada=="1159"){
					    capa.innerHTML="DIBUJO TECNICO Y ORGANOS DE MAQUINAS ";
					}else if(opcionSeleccionada=="1160"){
					    capa.innerHTML="DIBUJO TECNICO Y PROYECTO DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1161"){
					    capa.innerHTML="DIBUJO TECNICO Y PROYECTOS MECANICOS ";
					}else if(opcionSeleccionada=="1162"){
					    capa.innerHTML="DIBUJO Y PROYECTO ";
					}else if(opcionSeleccionada=="1163"){
					    capa.innerHTML="DIBUJO Y PROYECTO ELECTRICO ";
					}else if(opcionSeleccionada=="1164"){
					    capa.innerHTML="DIBUJO Y PROYECTO DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1165"){
					    capa.innerHTML="DIETETICA ";
					}else if(opcionSeleccionada=="1166"){
					    capa.innerHTML="DISENO APLICADO ";
					}else if(opcionSeleccionada=="1167"){
					    capa.innerHTML="DISENO DE ESTRUCTURAS ";
					}else if(opcionSeleccionada=="1168"){
					    capa.innerHTML="DISENO DEL VESTUARIO ";
					}else if(opcionSeleccionada=="1169"){
					    capa.innerHTML="DISENO GRAFICO ";
					}else if(opcionSeleccionada=="1170"){
					    capa.innerHTML="DISENO Y APLICACION DE PROYECTOS ";
					}else if(opcionSeleccionada=="1171"){
					    capa.innerHTML="DISENO Y MODELAJE DE CALZADO ";
					}else if(opcionSeleccionada=="1172"){
					    capa.innerHTML="DISENO Y MODELAJE DE VESTUARIO DE CUERO ";
					}else if(opcionSeleccionada=="1173"){
					    capa.innerHTML="DISENO Y TEJIDO DE TELAS EN MAQUINAS CIRCULARES ";
					}else if(opcionSeleccionada=="1174"){
					    capa.innerHTML="DISENO Y TEJIDO DE TELAS EN MAQUINAS RECTILINEAS ";
					}else if(opcionSeleccionada=="1175"){
					    capa.innerHTML="DOCUMENTACION COMERCIAL ";
					}else if(opcionSeleccionada=="1176"){
					    capa.innerHTML="ECONOMATO ";
					}else if(opcionSeleccionada=="1177"){
					    capa.innerHTML="ECONOMIA EMPRESARIAL ";
					}else if(opcionSeleccionada=="1178"){
					    capa.innerHTML="ECONOMIA TURISTICA ";
					}else if(opcionSeleccionada=="1179"){
					    capa.innerHTML="ECONOMIA Y ADMINISTRACION ";
					}else if(opcionSeleccionada=="1180"){
					    capa.innerHTML="ECONOMIA Y ADMINISTRACION AGRICOLA ";
					}else if(opcionSeleccionada=="1181"){
					    capa.innerHTML="ECONOMIA Y GESTION DE EMPRESA ";
					}else if(opcionSeleccionada=="1182"){
					    capa.innerHTML="EDAFOLOGIA Y FERTILIZACION DE SUELOS ";
					}else if(opcionSeleccionada=="1183"){
					    capa.innerHTML="EDUCACION CIVICA Y SOCIAL ";
					}else if(opcionSeleccionada=="1184"){
					    capa.innerHTML="EDUCACION FISICA INFANTIL ";
					}else if(opcionSeleccionada=="1185"){
					    capa.innerHTML="EDUCACION MUSICAL INFANTIL ";
					}else if(opcionSeleccionada=="1186"){
					    capa.innerHTML="TALLER DE APLICACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="1187"){
					    capa.innerHTML="EDUCACION PARA EL TRABAJO ";
					}else if(opcionSeleccionada=="1188"){
					    capa.innerHTML="EDUCACION PARVULARIA ";
					}else if(opcionSeleccionada=="1189"){
					    capa.innerHTML="EDUCACION SEXUAL ";
					}else if(opcionSeleccionada=="1190"){
					    capa.innerHTML="EJECUCION DE EVENTOS ";
					}else if(opcionSeleccionada=="1191"){
					    capa.innerHTML="EL COLOR APLICADO AL VESTUARIO ";
					}else if(opcionSeleccionada=="1192"){
					    capa.innerHTML="ELECTRICIDAD APLICADA ";
					}else if(opcionSeleccionada=="1193"){
					    capa.innerHTML="ELECTRICIDAD APLICADA A MOTOR A PRESION CONSTANTE ";
					}else if(opcionSeleccionada=="1194"){
					    capa.innerHTML="ELECTRICIDAD BASICA ";
					}else if(opcionSeleccionada=="1195"){
					    capa.innerHTML="ELECTRICIDAD Y ELECTRONICA AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="1196"){
					    capa.innerHTML="AUTOMATIZACION ";
					}else if(opcionSeleccionada=="1197"){
					    capa.innerHTML="ELECTRO Y TERMOQUIMICA ";
					}else if(opcionSeleccionada=="1198"){
					    capa.innerHTML="ELECTRONICA DE LAS COMUNICACIONES ";
					}else if(opcionSeleccionada=="1199"){
					    capa.innerHTML="ELECTRONICA DE POTENCIA ";
					}else if(opcionSeleccionada=="1200"){
					    capa.innerHTML="ELECTRONICA DIGITAL ";
					}else if(opcionSeleccionada=="1201"){
					    capa.innerHTML="ELECTRONICA GENERAL ";
					}else if(opcionSeleccionada=="1202"){
					    capa.innerHTML="ELECTRONICA INDUSTRIAL ";
					}else if(opcionSeleccionada=="1203"){
					    capa.innerHTML="ELEMENTOS DE INVESTIGACION DEL MERCADO ";
					}else if(opcionSeleccionada=="1204"){
					    capa.innerHTML="ELEMENTOS DE INVESTIGACION ESTADISTICA ";
					}else if(opcionSeleccionada=="1205"){
					    capa.innerHTML="ELEMENTOS DE INVESTIGACION SOCIAL Y ESTADISTICA ";
					}else if(opcionSeleccionada=="1206"){
					    capa.innerHTML="ENNOBLECIMIENTOS TEXTILES ";
					}else if(opcionSeleccionada=="1207"){
					    capa.innerHTML="ENOLOGIA Y ARMONIA DE VINOS Y COMIDAS ";
					}else if(opcionSeleccionada=="1208"){
					    capa.innerHTML="ENSAYO DE MAQUINAS ";
					}else if(opcionSeleccionada=="1209"){
					    capa.innerHTML="ENTOMOGIA GENERAL Y AGRICOLA ";
					}else if(opcionSeleccionada=="1210"){
					    capa.innerHTML="ENVASADO Y BODEGAJE ";
					}else if(opcionSeleccionada=="1211"){
					    capa.innerHTML="EQUIPO DE NAVEGACION E INSTRUMENTOS DE LA AERONAVE ";
					}else if(opcionSeleccionada=="1212"){
					    capa.innerHTML="EQUIPOS Y MOTORES ";
					}else if(opcionSeleccionada=="1213"){
					    capa.innerHTML="ERGONOMIA ";
					}else if(opcionSeleccionada=="1214"){
					    capa.innerHTML="ESTAMPADO TEXTIL ";
					}else if(opcionSeleccionada=="1215"){
					    capa.innerHTML="ESPECIALIDAD FISICO DEPORTIVA ";
					}else if(opcionSeleccionada=="1216"){
					    capa.innerHTML="ESPECIALIZACION FISICO DEPORTIVA ";
					}else if(opcionSeleccionada=="1217"){
					    capa.innerHTML="ESTADISTICA BASICA ";
					}else if(opcionSeleccionada=="1218"){
					    capa.innerHTML="ESTADISTICA DESCRIPTIVA ";
					}else if(opcionSeleccionada=="1219"){
					    capa.innerHTML="ESTADISTICA Y MATEMATICA APLICADA ";
					}else if(opcionSeleccionada=="1220"){
					    capa.innerHTML="ESTADISTICA Y PROBABILIDADES ";
					}else if(opcionSeleccionada=="1221"){
					    capa.innerHTML="DOCUMENTACION ESCRITA ";
					}else if(opcionSeleccionada=="1222"){
					    capa.innerHTML="ESTETICA DE LA MODA ";
					}else if(opcionSeleccionada=="1223"){
					    capa.innerHTML="ESTIMULACION PSICOPEDAGOGICA ";
					}else if(opcionSeleccionada=="1224"){
					    capa.innerHTML="ESTRUCTURA ANALITICA ";
					}else if(opcionSeleccionada=="1225"){
					    capa.innerHTML="ESTRUCTURA DE DATOS ";
					}else if(opcionSeleccionada=="1226"){
					    capa.innerHTML="ESTRUCTURA Y ANALISIS DE LOS TEJIDOS ";
					}else if(opcionSeleccionada=="1227"){
					    capa.innerHTML="ESTRUCTURA Y MATERIALES CONSTITUYENTE DE LAS AERONAVE ";
					}else if(opcionSeleccionada=="1228"){
					    capa.innerHTML="ESTUDIO DE LA FIGURA HUMANA ";
					}else if(opcionSeleccionada=="1229"){
					    capa.innerHTML="ETICA ";
					}else if(opcionSeleccionada=="1230"){
					    capa.innerHTML="ETICA LABORAL Y LEGISLACION AGROPECUARIA ";
					}else if(opcionSeleccionada=="1231"){
					    capa.innerHTML="ETICA PROFESIONAL Y RELACIONES HUMANAS ";
					}else if(opcionSeleccionada=="1232"){
					    capa.innerHTML="ETICA Y HOTELERIA ";
					}else if(opcionSeleccionada=="1233"){
					    capa.innerHTML="ETICA, RELACIONES HUMANAS Y PUBLICAS ";
					}else if(opcionSeleccionada=="1234"){
					    capa.innerHTML="ETNOTURISMO ";
					}else if(opcionSeleccionada=="1235"){
					    capa.innerHTML="EXPRESION CORPORAL Y MUSICAL DEL PARVULO ";
					}else if(opcionSeleccionada=="1236"){
					    capa.innerHTML="EXPRESION DE CULTURA FISICO MUSICAL ";
					}else if(opcionSeleccionada=="1237"){
					    capa.innerHTML="EXPRESION PLASTICA MANUAL ";
					}else if(opcionSeleccionada=="1238"){
					    capa.innerHTML="EXPRESION PSICOMOTRIZ ";
					}else if(opcionSeleccionada=="1239"){
					    capa.innerHTML="EXPRESION RITMICA MOTRIZ DEL PARVULO ";
					}else if(opcionSeleccionada=="1240"){
					    capa.innerHTML="EXPRESION RITMICO MUSICAL ";
					}else if(opcionSeleccionada=="1241"){
					    capa.innerHTML="FERRETERIA AEREA Y TECNICOS DE MANEJO DE HERRAMIENTAS Y EQUIPOS";
					}else if(opcionSeleccionada=="1242"){
					    capa.innerHTML="FINANZAS ";
					}else if(opcionSeleccionada=="1243"){
					    capa.innerHTML="FISICA APLICADA ";
					}else if(opcionSeleccionada=="1244"){
					    capa.innerHTML="FISICA Y ELECTRICIDAD APLICADA ";
					}else if(opcionSeleccionada=="1245"){
					    capa.innerHTML="FITOTECNIA DE LAS OLEAGINOSAS LAS LEGUMINOSAS (CULTIVO 2) Y LOS FRUTALES ";
					}else if(opcionSeleccionada=="1246"){
					    capa.innerHTML="FITOTECNIA GENERAL Y DE LOS CEREALES (CULTIVO I) ";
					}else if(opcionSeleccionada=="1247"){
					    capa.innerHTML="FOLKLORE NACIONAL ";
					}else if(opcionSeleccionada=="1248"){
					    capa.innerHTML="FORMACION DE MICROEMPRESARIO ";
					}else if(opcionSeleccionada=="1249"){
					    capa.innerHTML="FORMACION ETICA ";
					}else if(opcionSeleccionada=="1250"){
					    capa.innerHTML="FORMACION PARA EL TRABAJO Y LA CIUDADANIA ";
					}else if(opcionSeleccionada=="1251"){
					    capa.innerHTML="FOTOGRAFIA ";
					}else if(opcionSeleccionada=="1252"){
					    capa.innerHTML="FRANCES TECNICO ";
					}else if(opcionSeleccionada=="1253"){
					    capa.innerHTML="FRUTALES DE HOJA CADUCA ";
					}else if(opcionSeleccionada=="1254"){
					    capa.innerHTML="FRUTALES DE HOJA PERSISTENTE ";
					}else if(opcionSeleccionada=="1255"){
					    capa.innerHTML="FRUTICULTURA ";
					}else if(opcionSeleccionada=="1256"){
					    capa.innerHTML="FUNCIONES COMPUTACIONALES ";
					}else if(opcionSeleccionada=="1257"){
					    capa.innerHTML="FUNDAMENTOS DE LA ELECTRONICA ";
					}else if(opcionSeleccionada=="1258"){
					    capa.innerHTML="FUNDAMENTOS DE ADMINISTRACION ";
					}else if(opcionSeleccionada=="1259"){
					    capa.innerHTML="FUNDAMENTOS DE EDUCACION PARVULARIA ";
					}else if(opcionSeleccionada=="1260"){
					    capa.innerHTML="FUNDAMENTOS DE LA EDUCACION PARVULARIA ";
					}else if(opcionSeleccionada=="1261"){
					    capa.innerHTML="FUNDAMENTOS DE PROGRAMACION ";
					}else if(opcionSeleccionada=="1262"){
					    capa.innerHTML="FUNDAMENTOS Y TECNICAS PSICOPEDAGOGICAS ";
					}else if(opcionSeleccionada=="1263"){
					    capa.innerHTML="GARANTIA DE CALIDAD ";
					}else if(opcionSeleccionada=="1264"){
					    capa.innerHTML="GASFITERIA GENERAL ";
					}else if(opcionSeleccionada=="1265"){
					    capa.innerHTML="GASTRONOMIA ";
					}else if(opcionSeleccionada=="1266"){
					    capa.innerHTML="GASTRONOMIA INTERNACIONAL ";
					}else if(opcionSeleccionada=="1267"){
					    capa.innerHTML="GEOGRAFIA ECONOMICA ";
					}else if(opcionSeleccionada=="1268"){
					    capa.innerHTML="GEOGRAFIA TURISTICA ";
					}else if(opcionSeleccionada=="1269"){
					    capa.innerHTML="GEOMETRIA DE LA DIRECCION ";
					}else if(opcionSeleccionada=="1270"){
					    capa.innerHTML="GESTION DE EXPEDIENTES TECNICOS ";
					}else if(opcionSeleccionada=="1271"){
					    capa.innerHTML="GESTION DE LA PEQUENA EMPRESA ";
					}else if(opcionSeleccionada=="1272"){
					    capa.innerHTML="INTERPRETACION MUSICAL ";
					}else if(opcionSeleccionada=="1273"){
					    capa.innerHTML="GESTION EMPRESARIAL ";
					}else if(opcionSeleccionada=="1274"){
					    capa.innerHTML="GESTION TURISTICA ";
					}else if(opcionSeleccionada=="1275"){
					    capa.innerHTML="HABILIDADES COMUNICACIONALES ";
					}else if(opcionSeleccionada=="1276"){
					    capa.innerHTML="HABITACIONES ";
					}else if(opcionSeleccionada=="1277"){
					    capa.innerHTML="HIDRAULICA Y NEUMATICA ";
					}else if(opcionSeleccionada=="1278"){
					    capa.innerHTML="HIGIENE AMBIENTAL ";
					}else if(opcionSeleccionada=="1279"){
					    capa.innerHTML="HIGIENE Y MANIPULACION DE ALIMENTOS ";
					}else if(opcionSeleccionada=="1280"){
					    capa.innerHTML="HIGIENE Y NUTRICION ";
					}else if(opcionSeleccionada=="1281"){
					    capa.innerHTML="HIGIENE Y SEGURIDAD EN SUPERMERCADOS ";
					}else if(opcionSeleccionada=="1282"){
					    capa.innerHTML="HIGIENE, SANIDAD Y BACTERIOLOGIA ";
					}else if(opcionSeleccionada=="1283"){
					    capa.innerHTML="HORTICULTURA ";
					}else if(opcionSeleccionada=="1284"){
					    capa.innerHTML="HOTELERIA ";
					}else if(opcionSeleccionada=="1285"){
					    capa.innerHTML="HOTELERIA Y HOGAR ";
					}else if(opcionSeleccionada=="1286"){
					    capa.innerHTML="IDENTIFICACION DE EQUIPOS Y PREPARACION DE DATOS DIGITALES ";
					}else if(opcionSeleccionada=="1287"){
					    capa.innerHTML="IMPRESION GRAFICA ";
					}else if(opcionSeleccionada=="1288"){
					    capa.innerHTML="INDUSTRIALIZACION DE LA MIEL Y MANEJO DE LA FLORA APICOLA ";
					}else if(opcionSeleccionada=="1289"){
					    capa.innerHTML="INFORMACION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="1290"){
					    capa.innerHTML="INFORMACION APLICADA ";
					}else if(opcionSeleccionada=="1291"){
					    capa.innerHTML="INFORMACION TURISTICA ";
					}else if(opcionSeleccionada=="1292"){
					    capa.innerHTML="INFORMACION Y COMPUTACION ";
					}else if(opcionSeleccionada=="1293"){
					    capa.innerHTML="INGLES COMERCIAL ";
					}else if(opcionSeleccionada=="1294"){
					    capa.innerHTML="INGLES INSTRUMENTAL ";
					}else if(opcionSeleccionada=="1295"){
					    capa.innerHTML="INGLES INSTRUMENTAL Y TECNICO ";
					}else if(opcionSeleccionada=="1296"){
					    capa.innerHTML="INGLES TECNICO ";
					}else if(opcionSeleccionada=="1297"){
					    capa.innerHTML="INNOVACION Y CREATIVIDAD ";
					}else if(opcionSeleccionada=="1298"){
					    capa.innerHTML="INSTALACIONES DE ALUMBRADO Y FUERZA ";
					}else if(opcionSeleccionada=="1299"){
					    capa.innerHTML="INSTALACIONES ELECTRICAS ";
					}else if(opcionSeleccionada=="1300"){
					    capa.innerHTML="INSTRUCCION A LA TELECOMUNICACION Y MICROPROCESADORES ";
					}else if(opcionSeleccionada=="1301"){
					    capa.innerHTML="INSTRUMENTACION INDUSTRIAL ";
					}else if(opcionSeleccionada=="1302"){
					    capa.innerHTML="INTEGRACION Y ZONA FRANCA ";
					}else if(opcionSeleccionada=="1303"){
					    capa.innerHTML="INTERPRETACION DE PLANOS ";
					}else if(opcionSeleccionada=="1304"){
					    capa.innerHTML="INTRODUCCION A LA ARQUITECTURA ";
					}else if(opcionSeleccionada=="1305"){
					    capa.innerHTML="INTRODUCCION A LA COMPUTACION E INFORMACION ";
					}else if(opcionSeleccionada=="1306"){
					    capa.innerHTML="INTRODUCCION A LA INVESTIGACION SOCIAL ";
					}else if(opcionSeleccionada=="1307"){
					    capa.innerHTML="INTRODUCCION AL TURISMO ";
					}else if(opcionSeleccionada=="1308"){
					    capa.innerHTML="INVESTIGACION DE MERCADO ";
					}else if(opcionSeleccionada=="1309"){
					    capa.innerHTML="INYECCION DE GASOLINA ";
					}else if(opcionSeleccionada=="1310"){
					    capa.innerHTML="INYECCION DIESEL ";
					}else if(opcionSeleccionada=="1311"){
					    capa.innerHTML="LA BIOLOGIA CELULAR Y EL ORGANISMO VEGETAL ";
					}else if(opcionSeleccionada=="1312"){
					    capa.innerHTML="LA EMPRESA HOTELERA ";
					}else if(opcionSeleccionada=="1313"){
					    capa.innerHTML="LABORATORIO ANALISIS ";
					}else if(opcionSeleccionada=="1314"){
					    capa.innerHTML="LABORATORIO COMPUTACIONAL ";
					}else if(opcionSeleccionada=="1315"){
					    capa.innerHTML="LABORATORIO DE ADMINISTRACION CONTABLE ";
					}else if(opcionSeleccionada=="1316"){
					    capa.innerHTML="LABORATORIO DE ALIMENTACION ";
					}else if(opcionSeleccionada=="1317"){
					    capa.innerHTML="LABORATORIO DE COMPUTACION ";
					}else if(opcionSeleccionada=="1318"){
					    capa.innerHTML="LABORATORIO DE CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="1319"){
					    capa.innerHTML="LABORATORIO DE CONTABILIDAD ";
					}else if(opcionSeleccionada=="1320"){
					    capa.innerHTML="LABORATORIO DE ELECTRICIDAD ";
					}else if(opcionSeleccionada=="1321"){
					    capa.innerHTML="LABORATORIO DE ELECTRICIDAD BASICA E INSTALACIONES SANITARIAS ";
					}else if(opcionSeleccionada=="1322"){
					    capa.innerHTML="LABORATORIO DE ELECTRICIDAD DE TELECOMUNICACIONES ";
					}else if(opcionSeleccionada=="1323"){
					    capa.innerHTML="LABORATORIO DE ELECTRICIDAD DIGITAL ";
					}else if(opcionSeleccionada=="1324"){
					    capa.innerHTML="LABORATORIO DE ELECTRICIDAD GENERAL ";
					}else if(opcionSeleccionada=="1325"){
					    capa.innerHTML="LABORATORIO DE ELECTRICIDAD INDUSTRIAL ";
					}else if(opcionSeleccionada=="1326"){
					    capa.innerHTML="LABORATORIO DE ELECTRICIDAD Y ELECTROTECNIA ";
					}else if(opcionSeleccionada=="1327"){
					    capa.innerHTML="LABORATORIO DE ELECTRONICA ";
					}else if(opcionSeleccionada=="1328"){
					    capa.innerHTML="LABORATORIO DE ELECTRONICA BASICA ";
					}else if(opcionSeleccionada=="1329"){
					    capa.innerHTML="LABORATORIO DE ELECTRONICA DE POTENCIA ";
					}else if(opcionSeleccionada=="1330"){
					    capa.innerHTML="LABORATORIO DE ELECTRONICA DIGITAL ";
					}else if(opcionSeleccionada=="1331"){
					    capa.innerHTML="LABORATORIO DE ELECTRONICA GENERAL ";
					}else if(opcionSeleccionada=="1332"){
					    capa.innerHTML="LABORATORIO DE GASTRONOMIA ";
					}else if(opcionSeleccionada=="1333"){
					    capa.innerHTML="LABORATORIO DE INGLES ";
					}else if(opcionSeleccionada=="1334"){
					    capa.innerHTML="LABORATORIO DE LA CONTABILIDAD ";
					}else if(opcionSeleccionada=="1335"){
					    capa.innerHTML="LABORATORIO DE LA DIGITACION ";
					}else if(opcionSeleccionada=="1336"){
					    capa.innerHTML="LABORATORIO DE LOS PRODUCTOS CULINARIOS ";
					}else if(opcionSeleccionada=="1337"){
					    capa.innerHTML="LABORATORIO DE MAQUINAS ELECTRICAS ";
					}else if(opcionSeleccionada=="1338"){
					    capa.innerHTML="LABORATORIO DE MARKETING ";
					}else if(opcionSeleccionada=="1339"){
					    capa.innerHTML="LABORATORIO DE MOTORES A VOLUMEN CONSTANTE ";
					}else if(opcionSeleccionada=="1340"){
					    capa.innerHTML="LABORATORIO DE OFICINA ";
					}else if(opcionSeleccionada=="1341"){
					    capa.innerHTML="LABORATORIO DE PRACTICAS DE ALIMENTACION ";
					}else if(opcionSeleccionada=="1342"){
					    capa.innerHTML="LABORATORIO DE PROGRAMACION ";
					}else if(opcionSeleccionada=="1343"){
					    capa.innerHTML="LABORATORIO DE REDES Y COMUNICACIONES ";
					}else if(opcionSeleccionada=="1344"){
					    capa.innerHTML="LABORATORIO DE REPOSTERIA Y PASTELERIA ";
					}else if(opcionSeleccionada=="1345"){
					    capa.innerHTML="LABORATORIO DE SECRETARIADO ADMINISTRATIVO ";
					}else if(opcionSeleccionada=="1346"){
					    capa.innerHTML="LABORATORIO DE SISTEMAS DIGITALES ";
					}else if(opcionSeleccionada=="1347"){
					    capa.innerHTML="LABORATORIO DE VENTA ";
					}else if(opcionSeleccionada=="1348"){
					    capa.innerHTML="LABORATORIO DUAL ";
					}else if(opcionSeleccionada=="1349"){
					    capa.innerHTML="LABORATORIO ELECTRONICA DE POTENCIA ";
					}else if(opcionSeleccionada=="1350"){
					    capa.innerHTML="LABORATORIO INGLES ";
					}else if(opcionSeleccionada=="1351"){
					    capa.innerHTML="LABORATORIO QUIMICO TEXTIL ";
					}else if(opcionSeleccionada=="1352"){
					    capa.innerHTML="LEGISLACION ";
					}else if(opcionSeleccionada=="1353"){
					    capa.innerHTML="LEGISLACION DE CONSTRUCCION Y SEGURIDAD SOCIAL ";
					}else if(opcionSeleccionada=="1354"){
					    capa.innerHTML="LEGISLACION DE CONTABILIDAD ";
					}else if(opcionSeleccionada=="1355"){
					    capa.innerHTML="LEGISLACION LABORAL PREVISIONAL ";
					}else if(opcionSeleccionada=="1356"){
					    capa.innerHTML="LEGISLACION LABORAL Y ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="1357"){
					    capa.innerHTML="LEGISLACION LABORAL Y TRIBUTARIA ";
					}else if(opcionSeleccionada=="1358"){
					    capa.innerHTML="LEGISLACION SOCIAL ";
					}else if(opcionSeleccionada=="1359"){
					    capa.innerHTML="LEGISLACION SOCIAL Y NOCIONES DE DERECHO ";
					}else if(opcionSeleccionada=="1360"){
					    capa.innerHTML="LEGISLACION SOCIAL Y TRIBUTARIA ";
					}else if(opcionSeleccionada=="1361"){
					    capa.innerHTML="LEGISLACION TRIBUTARIA ";
					}else if(opcionSeleccionada=="1362"){
					    capa.innerHTML="LEGISLACION TURISTICA ";
					}else if(opcionSeleccionada=="1363"){
					    capa.innerHTML="LENGUAJE ";
					}else if(opcionSeleccionada=="1364"){
					    capa.innerHTML="LENGUAJE COBOL ";
					}else if(opcionSeleccionada=="1365"){
					    capa.innerHTML="LENGUAJE COMPUTACIONAL ";
					}else if(opcionSeleccionada=="1366"){
					    capa.innerHTML="LENGUAJE DE PROGRAMACION ";
					}else if(opcionSeleccionada=="1367"){
					    capa.innerHTML="LENGUAJE DE PROGRAMACION COBOL ";
					}else if(opcionSeleccionada=="1368"){
					    capa.innerHTML="LENGUAJE DE PROGRAMACION PASCAL ";
					}else if(opcionSeleccionada=="1369"){
					    capa.innerHTML="LENGUAJE ORAL Y TEATRO INFANTIL ";
					}else if(opcionSeleccionada=="1370"){
					    capa.innerHTML="LENGUAJE, PAQUETES GENERALIZADOS Y PRACTICA DE COMPUTACION ";
					}else if(opcionSeleccionada=="1371"){
					    capa.innerHTML="LINEAS DE TRANSMISION Y ANTENAS ";
					}else if(opcionSeleccionada=="1372"){
					    capa.innerHTML="LINEAS Y ANTENAS ";
					}else if(opcionSeleccionada=="1373"){
					    capa.innerHTML="LITERATURA Y TEATRO ";
					}else if(opcionSeleccionada=="1374"){
					    capa.innerHTML="LITERATURA Y TEATRO INFANTIL ";
					}else if(opcionSeleccionada=="1375"){
					    capa.innerHTML="LUMINOTECNIA ";
					}else if(opcionSeleccionada=="1376"){
					    capa.innerHTML="MANEJO DE COMPUTADORES A NIVEL BASICO ";
					}else if(opcionSeleccionada=="1377"){
					    capa.innerHTML="MANTENCION DE MAQUINAS ";
					}else if(opcionSeleccionada=="1378"){
					    capa.innerHTML="MANTENCION DE MOTORES DE EXPLOSION ";
					}else if(opcionSeleccionada=="1379"){
					    capa.innerHTML="MANTENCION ELECTRONICA ";
					}else if(opcionSeleccionada=="1380"){
					    capa.innerHTML="MANTENCION PREVENTIVA ";
					}else if(opcionSeleccionada=="1381"){
					    capa.innerHTML="MANTENCION PRIMARIA DE EQUIPOS ";
					}else if(opcionSeleccionada=="1382"){
					    capa.innerHTML="MANTENIMIENTO DE MOTORES RECIPROCOS Y SUS SISTEMAS ASOCIADOS ";
					}else if(opcionSeleccionada=="1383"){
					    capa.innerHTML="MANTENIMIENTO DE MOTORES A REACCION Y SUS SISTEMAS ASOCIADOS ";
					}else if(opcionSeleccionada=="1384"){
					    capa.innerHTML="MANTENIMIENTO Y CONTROL ";
					}else if(opcionSeleccionada=="1385"){
					    capa.innerHTML="MANTENIMIENTO Y CONTROL DE CALIDAD ";
					}else if(opcionSeleccionada=="1386"){
					    capa.innerHTML="MAQUINAS MOTRICES ";
					}else if(opcionSeleccionada=="1387"){
					    capa.innerHTML="MAQUINA Y TERMINOLOGIA ";
					}else if(opcionSeleccionada=="1388"){
					    capa.innerHTML="MAQUINARIA AGRICOLA ";
					}else if(opcionSeleccionada=="1389"){
					    capa.innerHTML="MAQUINAS ELECTRICAS ";
					}else if(opcionSeleccionada=="1390"){
					    capa.innerHTML="MAQUINAS MOTRICES Y CONTROL DE MAQUINAS ";
					}else if(opcionSeleccionada=="1391"){
					    capa.innerHTML="MARKETING INTERNACIONAL ";
					}else if(opcionSeleccionada=="1392"){
					    capa.innerHTML="MARROQUINERIA ";
					}else if(opcionSeleccionada=="1393"){
					    capa.innerHTML="MATEMATICA APLICADA Y ESTADISTICA ";
					}else if(opcionSeleccionada=="1394"){
					    capa.innerHTML="MATEMATICA COMERCIAL ";
					}else if(opcionSeleccionada=="1395"){
					    capa.innerHTML="MATEMATICA CONTABLE ";
					}else if(opcionSeleccionada=="1396"){
					    capa.innerHTML="MATEMATICA FINANCIERA ";
					}else if(opcionSeleccionada=="1397"){
					    capa.innerHTML="MATERIALES DE CONSTRUCCION ";
					}else if(opcionSeleccionada=="1398"){
					    capa.innerHTML="MATERIALES E INSUMOS DE LA INDUSTRIA GRAFICA ";
					}else if(opcionSeleccionada=="1399"){
					    capa.innerHTML="MATERIAS PRIMAS TEXTILES Y SU HILATURA ";
					}else if(opcionSeleccionada=="1400"){
					    capa.innerHTML="MECANICA DE MANTENIMIENTO ";
					}else if(opcionSeleccionada=="1401"){
					    capa.innerHTML="MECANICA Y TERMOTECNIA ";
					}else if(opcionSeleccionada=="1402"){
					    capa.innerHTML="MECANICA Y TERMOLOGIA TECNICA ";
					}else if(opcionSeleccionada=="1403"){
					    capa.innerHTML="LABORATORIO DE PROGRAMACION EN COMPUTACION ";
					}else if(opcionSeleccionada=="1404"){
					    capa.innerHTML="MECANIZACION AGRICOLA Y TECNICAS DE RIEGOS Y DRENAJE ";
					}else if(opcionSeleccionada=="1405"){
					    capa.innerHTML="MEDIOS PUBLICITARIOS ";
					}else if(opcionSeleccionada=="1406"){
					    capa.innerHTML="MERCHANDISING ";
					}else if(opcionSeleccionada=="1407"){
					    capa.innerHTML="METODOLOGIA CATEQUISTA ";
					}else if(opcionSeleccionada=="1408"){
					    capa.innerHTML="METODOLOGIA DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1409"){
					    capa.innerHTML="METODOLOGIA DEL TRABAJO SOCIAL ";
					}else if(opcionSeleccionada=="1410"){
					    capa.innerHTML="METODOLOGIA Y TECNICA DEL TRABAJO SOCIAL ";
					}else if(opcionSeleccionada=="1411"){
					    capa.innerHTML="METODOS Y TECNICAS DEL TRABAJO SOCIAL ";
					}else if(opcionSeleccionada=="1412"){
					    capa.innerHTML="METROLOGIA ";
					}else if(opcionSeleccionada=="1413"){
					    capa.innerHTML="MICROBIOLOGIA ";
					}else if(opcionSeleccionada=="1414"){
					    capa.innerHTML="MICROBIOLOGIA DE ALIMENTOS ";
					}else if(opcionSeleccionada=="1415"){
					    capa.innerHTML="MICROEMPRESARIO Y LABORATORIO ";
					}else if(opcionSeleccionada=="1416"){
					    capa.innerHTML="MODELAJE ";
					}else if(opcionSeleccionada=="1417"){
					    capa.innerHTML="MODELAJE DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1418"){
					    capa.innerHTML="MODELAJE DE VESTUARIO ASISTIDO POR COMPUTADOR ";
					}else if(opcionSeleccionada=="1419"){
					    capa.innerHTML="MODELAJE INDUSTRIAL ";
					}else if(opcionSeleccionada=="1420"){
					    capa.innerHTML="DIBUJO PUBLICITARIO ";
					}else if(opcionSeleccionada=="1421"){
					    capa.innerHTML="MODELAJE Y CORTE DE VESTUARIO FEMENINO ";
					}else if(opcionSeleccionada=="1422"){
					    capa.innerHTML="TECNICAS DE VESTUARIO ";
					}else if(opcionSeleccionada=="1423"){
					    capa.innerHTML="MODELAJE Y CORTE DE VESTUARIO MASCULINO ";
					}else if(opcionSeleccionada=="1424"){
					    capa.innerHTML="MODELAJE Y DISENO ";
					}else if(opcionSeleccionada=="1425"){
					    capa.innerHTML="MODELAJE Y EXPRESION CORPORAL ";
					}else if(opcionSeleccionada=="1426"){
					    capa.innerHTML="MONTAJE DE CALZADO ";
					}else if(opcionSeleccionada=="1427"){
					    capa.innerHTML="MORFOSINTAXIS DEL CASTELLANO ";
					}else if(opcionSeleccionada=="1428"){
					    capa.innerHTML="MORFOFISIOLOGIA Y SANIDAD VEGETAL ";
					}else if(opcionSeleccionada=="1429"){
					    capa.innerHTML="MULTITALLER DE EXPRESION ARTISTICA ";
					}else if(opcionSeleccionada=="1430"){
					    capa.innerHTML="MULTITALLER DE EXPRESION PLASTICA ";
					}else if(opcionSeleccionada=="1431"){
					    capa.innerHTML="MULTITALLER FISICO RECREATIVO ";
					}else if(opcionSeleccionada=="1432"){
					    capa.innerHTML="MULTIUSUARIOS ";
					}else if(opcionSeleccionada=="1433"){
					    capa.innerHTML="MUNDO CONTEMPORANEO ";
					}else if(opcionSeleccionada=="1434"){
					    capa.innerHTML="MUSICA INFANTIL ";
					}else if(opcionSeleccionada=="1435"){
					    capa.innerHTML="MUSICA INFANTIL E INSTRUMENTAL ";
					}else if(opcionSeleccionada=="1436"){
					    capa.innerHTML="NEUMATICA ";
					}else if(opcionSeleccionada=="1437"){
					    capa.innerHTML="NOCIONES DE ADMINISTRACION Y COMERCIALIZACION ";
					}else if(opcionSeleccionada=="1438"){
					    capa.innerHTML="NOCIONES DE AUDITORIA ";
					}else if(opcionSeleccionada=="1439"){
					    capa.innerHTML="NOCIONES DE COMPUTACION E INFORMATICA ";
					}else if(opcionSeleccionada=="1440"){
					    capa.innerHTML="NOCIONES DE DERECHO COMERCIAL ";
					}else if(opcionSeleccionada=="1441"){
					    capa.innerHTML="NOCIONES DE DERECHO LABORAL ";
					}else if(opcionSeleccionada=="1442"){
					    capa.innerHTML="NOCIONES DE ECONOMIA ";
					}else if(opcionSeleccionada=="1443"){
					    capa.innerHTML="NOCIONES DE ENFERMERIA ";
					}else if(opcionSeleccionada=="1444"){
					    capa.innerHTML="NOCIONES DE ESTADISTICAS ";
					}else if(opcionSeleccionada=="1445"){
					    capa.innerHTML="NOCIONES DE INFORMACIONES ";
					}else if(opcionSeleccionada=="1446"){
					    capa.innerHTML="NOCIONES DE INFORMATICA Y COMPUTACION ";
					}else if(opcionSeleccionada=="1447"){
					    capa.innerHTML="NOCIONES DE PUERICULTURA ";
					}else if(opcionSeleccionada=="1448"){
					    capa.innerHTML="NORMAS DE DERECHO PROCESAL ";
					}else if(opcionSeleccionada=="1449"){
					    capa.innerHTML="NUTRICION ";
					}else if(opcionSeleccionada=="1450"){
					    capa.innerHTML="NUTRICION INFANTIL ";
					}else if(opcionSeleccionada=="1451"){
					    capa.innerHTML="NUTRICION Y DIETETICA ";
					}else if(opcionSeleccionada=="1452"){
					    capa.innerHTML="OLEOHIDRAULICA ";
					}else if(opcionSeleccionada=="1453"){
					    capa.innerHTML="OPERACION DE MAQUINAS DE IMPRESION ";
					}else if(opcionSeleccionada=="1454"){
					    capa.innerHTML="OPERACION DE SUPERMERCADOS ";
					}else if(opcionSeleccionada=="1455"){
					    capa.innerHTML="OPERACIONES CONTABLES Y BANCARIAS ";
					}else if(opcionSeleccionada=="1456"){
					    capa.innerHTML="ORGANIZACION DE EMPRESAS ";
					}else if(opcionSeleccionada=="1457"){
					    capa.innerHTML="ORGANIZACION DE OFICINA Y ARCHIVO ";
					}else if(opcionSeleccionada=="1458"){
					    capa.innerHTML="ORGANIZACION DEL JARDIN INFANTIL ";
					}else if(opcionSeleccionada=="1459"){
					    capa.innerHTML="ORGANIZACION TECNICO TURISTICA ";
					}else if(opcionSeleccionada=="1460"){
					    capa.innerHTML="ORGANIZACION Y ADMINISTRACION DE SERVICIOS ALIMENTARIOS ";
					}else if(opcionSeleccionada=="1461"){
					    capa.innerHTML="ORIENTACION TURISTICA ";
					}else if(opcionSeleccionada=="1462"){
					    capa.innerHTML="ORIENTACION Y ETICA PROFESIONAL ";
					}else if(opcionSeleccionada=="1463"){
					    capa.innerHTML="PANIFICACION Y PASTELERIA ";
					}else if(opcionSeleccionada=="1464"){
					    capa.innerHTML="PASTILLAJE ";
					}else if(opcionSeleccionada=="1465"){
					    capa.innerHTML="PLANIFICACION Y CONTROL DE AREA DE ALOJAMIENTO ";
					}else if(opcionSeleccionada=="1466"){
					    capa.innerHTML="PLANIFICACION Y CONTROL DE LOS SERVICIOS DE RESTAURANTES, BAR Y CAFETERIA ";
					}else if(opcionSeleccionada=="1467"){
					    capa.innerHTML="PLANILLA DE CALCULO ";
					}else if(opcionSeleccionada=="1468"){
					    capa.innerHTML="PLANOS Y PROYECTOS ";
					}else if(opcionSeleccionada=="1469"){
					    capa.innerHTML="PLANTA EXTERNA ";
					}else if(opcionSeleccionada=="1470"){
					    capa.innerHTML="POLITICAS SOCIALES ";
					}else if(opcionSeleccionada=="1471"){
					    capa.innerHTML="PRACTICA DE TALLER Y LABORATORIO DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1472"){
					    capa.innerHTML="PRACTICA Y TECNOLOGIA DE RECTIFICADO Y AJUSTE ";
					}else if(opcionSeleccionada=="1473"){
					    capa.innerHTML="PRACTICA Y TECNOLOGIA RELACIONADA ";
					}else if(opcionSeleccionada=="1474"){
					    capa.innerHTML="PRACTICAS EN LA EMPRESA ";
					}else if(opcionSeleccionada=="1475"){
					    capa.innerHTML="PRACTICAS SECRETARIALES ";
					}else if(opcionSeleccionada=="1476"){
					    capa.innerHTML="PREPARACION AL TISAJE ";
					}else if(opcionSeleccionada=="1477"){
					    capa.innerHTML="PREPARACION DE LA CONTAMINACION Y SALUD OCUPACIONAL ";
					}else if(opcionSeleccionada=="1478"){
					    capa.innerHTML="PREPARACION DE LA MAQUINA IMPRESORA ";
					}else if(opcionSeleccionada=="1479"){
					    capa.innerHTML="PREPARACION Y CONFECCION DE VESTUARIO INFANTIL ";
					}else if(opcionSeleccionada=="1480"){
					    capa.innerHTML="PREPARADO Y CONFECCION DE PRENDAS FEMENINAS DE VESTIR ";
					}else if(opcionSeleccionada=="1481"){
					    capa.innerHTML="PREPARADO Y CONFECCION DE PRENDAS FEMENINAS DEPORTIVAS Y DE TRABAJO ";
					}else if(opcionSeleccionada=="1482"){
					    capa.innerHTML="PREPARADO Y CONFECCION DE PRENDAS MASCULINAS DEPORTIVAS Y DE TRABAJO ";
					}else if(opcionSeleccionada=="1483"){
					    capa.innerHTML="GESTION DE PEQUENA EMPRESA Y COMPRAVENTA ";
					}else if(opcionSeleccionada=="1484"){
					    capa.innerHTML="PREVENCION DE LA CONTAMINACION Y SALUD OCUPACIONAL ";
					}else if(opcionSeleccionada=="1485"){
					    capa.innerHTML="PREVENCION DE RIESGOS Y PRIMEROS AUXILIOS ";
					}else if(opcionSeleccionada=="1486"){
					    capa.innerHTML="PRIMEROS AUXILIOS ";
					}else if(opcionSeleccionada=="1487"){
					    capa.innerHTML="PRINCIPIO DE ADMINISTRACION Y LEGISLACION LABORAL ";
					}else if(opcionSeleccionada=="1488"){
					    capa.innerHTML="PRINCIPIOS DE ADMINISTRACION ";
					}else if(opcionSeleccionada=="1489"){
					    capa.innerHTML="PROCESADOR DE TEXTO ";
					}else if(opcionSeleccionada=="1490"){
					    capa.innerHTML="PROCESO DE HILATURA ";
					}else if(opcionSeleccionada=="1491"){
					    capa.innerHTML="PRODUCCION ANIMAL ";
					}else if(opcionSeleccionada=="1492"){
					    capa.innerHTML="PRODUCCION VEGETAL ";
					}else if(opcionSeleccionada=="1493"){
					    capa.innerHTML="PROGRAMACION ";
					}else if(opcionSeleccionada=="1494"){
					    capa.innerHTML="PROGRAMACION AVANZADA Y UTILITARIOS ";
					}else if(opcionSeleccionada=="1495"){
					    capa.innerHTML="PROGRAMACION BASIC ";
					}else if(opcionSeleccionada=="1496"){
					    capa.innerHTML="PROGRAMACION COBOL ";
					}else if(opcionSeleccionada=="1497"){
					    capa.innerHTML="PROMOCION PUBLICITARIA ";
					}else if(opcionSeleccionada=="1498"){
					    capa.innerHTML="PROMOCION Y ORGANIZACION DE EVENTOS ";
					}else if(opcionSeleccionada=="1499"){
					    capa.innerHTML="PROYECTO DE LA ESPECIALIDAD ";
					}else if(opcionSeleccionada=="1500"){
					    capa.innerHTML="PROYECTOS ";
					}else if(opcionSeleccionada=="1501"){
					    capa.innerHTML="PROYECTOS E INTERPRETACIONES DE PLANOS ";
					}else if(opcionSeleccionada=="1502"){
					    capa.innerHTML="PROYECTOS ELECTRICOS ";
					}else if(opcionSeleccionada=="1503"){
					    capa.innerHTML="PSICOLOGIA ";
					}else if(opcionSeleccionada=="1504"){
					    capa.innerHTML="PSICOLOGIA APLICADA ";
					}else if(opcionSeleccionada=="1505"){
					    capa.innerHTML="PSICOLOGIA DEL APRENDIZAJE ";
					}else if(opcionSeleccionada=="1506"){
					    capa.innerHTML="PSICOLOGIA DEL APRENDIZAJE Y DEL DESARROLLO ";
					}else if(opcionSeleccionada=="1507"){
					    capa.innerHTML="PSICOLOGIA DEL DESARROLLO ";
					}else if(opcionSeleccionada=="1508"){
					    capa.innerHTML="PSICOLOGIA DEL DESARROLLO DEL PARVULO ";
					}else if(opcionSeleccionada=="1509"){
					    capa.innerHTML="PSICOLOGIA EVOLUTIVA ";
					}else if(opcionSeleccionada=="1510"){
					    capa.innerHTML="PSICOLOGIA GENERAL ";
					}else if(opcionSeleccionada=="1511"){
					    capa.innerHTML="PSICOLOGIA GENERAL Y DEL PARVULO ";
					}else if(opcionSeleccionada=="1512"){
					    capa.innerHTML="PSICOLOGIA SOCIAL ";
					}else if(opcionSeleccionada=="1513"){
					    capa.innerHTML="PSICOPATOLOGIA ";
					}else if(opcionSeleccionada=="1514"){
					    capa.innerHTML="PSICOPEDAGOGIA ";
					}else if(opcionSeleccionada=="1515"){
					    capa.innerHTML="PUERICULTURA Y ALIMENTACION DEL PARVULO ";
					}else if(opcionSeleccionada=="1516"){
					    capa.innerHTML="QUIMICA ANALITICA ";
					}else if(opcionSeleccionada=="1517"){
					    capa.innerHTML="QUIMICA ANALITICA CUALITATIVA Y CUANTITATIVA ";
					}else if(opcionSeleccionada=="1518"){
					    capa.innerHTML="QUIMICA APLICADA ";
					}else if(opcionSeleccionada=="1519"){
					    capa.innerHTML="QUIMICA INDUSTRIAL ";
					}else if(opcionSeleccionada=="1520"){
					    capa.innerHTML="QUIMICA ORGANICA ";
					}else if(opcionSeleccionada=="1521"){
					    capa.innerHTML="RADIO COMUNICACIONES ";
					}else if(opcionSeleccionada=="1522"){
					    capa.innerHTML="RADIO Y TELEVISION ";
					}else if(opcionSeleccionada=="1523"){
					    capa.innerHTML="RECONSTRUCCION MOTOR DIESSEL ";
					}else if(opcionSeleccionada=="1524"){
					    capa.innerHTML="RECREACION ";
					}else if(opcionSeleccionada=="1525"){
					    capa.innerHTML="REDACCION COMERCIAL APLICADA ";
					}else if(opcionSeleccionada=="1526"){
					    capa.innerHTML="REDACCION COMERCIAL Y OFICIAL ";
					}else if(opcionSeleccionada=="1527"){
					    capa.innerHTML="REDACCION PUBLICITARIA ";
					}else if(opcionSeleccionada=="1528"){
					    capa.innerHTML="REDACCION Y TECNICAS DE EXPRESION ";
					}else if(opcionSeleccionada=="1529"){
					    capa.innerHTML="REDES DE COMUNICACION ";
					}else if(opcionSeleccionada=="1530"){
					    capa.innerHTML="REFRIGERACION Y ALMACENAMIENTO ";
					}else if(opcionSeleccionada=="1531"){
					    capa.innerHTML="REGLAMENTACION AERONAUTICA ";
					}else if(opcionSeleccionada=="1532"){
					    capa.innerHTML="REGLAMENTACION ELECTRICA ";
					}else if(opcionSeleccionada=="1533"){
					    capa.innerHTML="RELACIONES HUMANAS Y PUBLICAS ";
					}else if(opcionSeleccionada=="1534"){
					    capa.innerHTML="RELACIONES PERSONALES ";
					}else if(opcionSeleccionada=="1535"){
					    capa.innerHTML="RELACIONES PUBLICAS ";
					}else if(opcionSeleccionada=="1536"){
					    capa.innerHTML="RELACIONES PUBLICAS HUMANAS Y ETICA ";
					}else if(opcionSeleccionada=="1537"){
					    capa.innerHTML="RELACIONES PUBLICAS Y ETICA ";
					}else if(opcionSeleccionada=="1538"){
					    capa.innerHTML="RELACIONES PUBLICAS Y ETICA PROFESIONAL ";
					}else if(opcionSeleccionada=="1539"){
					    capa.innerHTML="REPOSTERIA ";
					}else if(opcionSeleccionada=="1540"){
					    capa.innerHTML="REPOSTERIA FINA ";
					}else if(opcionSeleccionada=="1541"){
					    capa.innerHTML="REPRODUCCION DE PLANTAS ORNAMENTALES ";
					}else if(opcionSeleccionada=="1542"){
					    capa.innerHTML="RESISTENCIA DE LOS MATERIALES ";
					}else if(opcionSeleccionada=="1543"){
					    capa.innerHTML="RIEGO ";
					}else if(opcionSeleccionada=="1544"){
					    capa.innerHTML="RIESGOS HOTELEROS Y PRIMEROS AUXILIOS ";
					}else if(opcionSeleccionada=="1545"){
					    capa.innerHTML="SALUD Y ALIMENTACION ";
					}else if(opcionSeleccionada=="1546"){
					    capa.innerHTML="SALUD Y CUIDADOS DEL NINO ";
					}else if(opcionSeleccionada=="1547"){
					    capa.innerHTML="SALUD Y PUERICULTURA ";
					}else if(opcionSeleccionada=="1548"){
					    capa.innerHTML="SANEAMIENTO ";
					}else if(opcionSeleccionada=="1549"){
					    capa.innerHTML="SANEAMIENTO Y REGLAMENTACION SANITARIA ";
					}else if(opcionSeleccionada=="1550"){
					    capa.innerHTML="SANIDAD ANIMAL ";
					}else if(opcionSeleccionada=="1551"){
					    capa.innerHTML="SECRETARIADO ";
					}else if(opcionSeleccionada=="1552"){
					    capa.innerHTML="SEGURIDAD AEROESPACIAL ";
					}else if(opcionSeleccionada=="1553"){
					    capa.innerHTML="SEGURIDAD INDUSTRIAL ";
					}else if(opcionSeleccionada=="1554"){
					    capa.innerHTML="SEGURIDAD Y PREVENCION DE RIESGOS ";
					}else if(opcionSeleccionada=="1555"){
					    capa.innerHTML="SEPARACION DEL COLOR DIGITAL ";
					
					}else if(opcionSeleccionada=="1556"){
					    capa.innerHTML="SERVICIO AL CLIENTE ";
					}else if(opcionSeleccionada=="1557"){
					    capa.innerHTML="SERVICIO DE ALIMENTACION ";
					}else if(opcionSeleccionada=="1558"){
					    capa.innerHTML="SERVICIO DE ALOJAMIENTO ";
					}else if(opcionSeleccionada=="1559"){
					    capa.innerHTML="SERVICIO DE COMEDORES ";
					}else if(opcionSeleccionada=="1560"){
					    capa.innerHTML="SERVICIO DE CONSEJERIA Y CENTRO DE NEGOCIOS ";
					}else if(opcionSeleccionada=="1561"){
					    capa.innerHTML="SERVICIO OPTIMO AL CLIENTE ";
					}else if(opcionSeleccionada=="1562"){
					    capa.innerHTML="SERVICIOS DE HABITACIONES ";
					}else if(opcionSeleccionada=="1563"){
					    capa.innerHTML="SERVICIOS HOTELEROS ";
					}else if(opcionSeleccionada=="1564"){
					    capa.innerHTML="SISTEMA CONTABLES COMPUTACIONALES ";
					}else if(opcionSeleccionada=="1565"){
					    capa.innerHTML="SISTEMA DE INFORMACION ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="1566"){
					    capa.innerHTML="SISTEMA DE INFORMACION ADMINISTRATIVA Y PROGRAMA DE APLICACION ";
					}else if(opcionSeleccionada=="1567"){
					    capa.innerHTML="SISTEMA OPERATIVO ";
					}else if(opcionSeleccionada=="1568"){
					    capa.innerHTML="SISTEMA Y EQUIPOS DE POST-IMPRESION ";
					}else if(opcionSeleccionada=="1569"){
					    capa.innerHTML="SISTEMAS AUTOMATAS P. L. C. ";
					}else if(opcionSeleccionada=="1570"){
					    capa.innerHTML="SISTEMAS DE ENCENDIDO ELECTRICO ";
					}else if(opcionSeleccionada=="1571"){
					    capa.innerHTML="SISTEMAS DE LA AERONAVE ";
					}else if(opcionSeleccionada=="1572"){
					    capa.innerHTML="SISTEMAS DE REDES ";
					}else if(opcionSeleccionada=="1573"){
					    capa.innerHTML="SISTEMAS DIGITALES ";
					}else if(opcionSeleccionada=="1574"){
					    capa.innerHTML="SISTEMAS DIGITALES Y ESTRUCTURA DE MICROPROCESADORES ";
					}else if(opcionSeleccionada=="1575"){
					    capa.innerHTML="SISTEMAS DIGITALES Y LABORATORIO ";
					}else if(opcionSeleccionada=="1576"){
					    capa.innerHTML="SISTEMAS Y EQUIPOS DE IMPRESION ";
					}else if(opcionSeleccionada=="1577"){
					    capa.innerHTML="SOCIOLOGIA ";
					}else if(opcionSeleccionada=="1578"){
					    capa.innerHTML="SOCIOLOGIA RURAL Y EXTENSION AGRICOLA ";
					}else if(opcionSeleccionada=="1579"){
					    capa.innerHTML="SOFTWARE ";
					}else if(opcionSeleccionada=="1580"){
					    capa.innerHTML="SOFTWARE AVANZADO ";
					}else if(opcionSeleccionada=="1581"){
					    capa.innerHTML="SOFTWARE DE APLICACIONES ";
					}else if(opcionSeleccionada=="1582"){
					    capa.innerHTML="SOFTWARE Y TECNOLOGIA AVANZADA ";
					}else if(opcionSeleccionada=="1583"){
					    capa.innerHTML="SUELO Y FERTILIZANTES ";
					}else if(opcionSeleccionada=="1584"){
					    capa.innerHTML="SUPERVISION ";
					}else if(opcionSeleccionada=="1585"){
					    capa.innerHTML="SUPERVISION BASICA ";
					}else if(opcionSeleccionada=="1586"){
					    capa.innerHTML="TALLER DE APLICACION ";
					}else if(opcionSeleccionada=="1587"){
					    capa.innerHTML="TALLER DE BODEGA ";
					}else if(opcionSeleccionada=="1588"){
					    capa.innerHTML="TALLER DE COMPUTACION E INFORMATICA ";
					}else if(opcionSeleccionada=="1589"){
					    capa.innerHTML="TALLER DE CONFECCION DEL VESTUARIO FEMENINO ";
					}else if(opcionSeleccionada=="1590"){
					    capa.innerHTML="TALLER DE CONSTRUCCIONES METALICAS ";
					}else if(opcionSeleccionada=="1591"){
					    capa.innerHTML="TALLER DE DIBUJO ARQUITECTONICO ";
					}else if(opcionSeleccionada=="1592"){
					    capa.innerHTML="TALLER DE DINAMICA GRUPAL ";
					}else if(opcionSeleccionada=="1593"){
					    capa.innerHTML="TALLER DE EQUIPOS COMPUTACIONALES ";
					}else if(opcionSeleccionada=="1594"){
					    capa.innerHTML="TALLER DE EXPRESION PLASTICA EN EL PLANO Y VOLUMEN ";
					}else if(opcionSeleccionada=="1595"){
					    capa.innerHTML="TALLER DE EXPRESION Y CREACION ";
					}else if(opcionSeleccionada=="1596"){
					    capa.innerHTML="TALLER DE FOLCLOR MUSICAL ";
					}else if(opcionSeleccionada=="1597"){
					    capa.innerHTML="TALLER DE INICIACION EN LA PUBLICIDAD ";
					}else if(opcionSeleccionada=="1598"){
					    capa.innerHTML="TALLER DE INSTRUMENTOS MUSICALES ";
					}else if(opcionSeleccionada=="2742"){
					    capa.innerHTML="QUIMICA FORMACION DIFERENCIADA HUMANISTICO-CIENTIFICA 3° ANO MEDIO ";
					}else if(opcionSeleccionada=="2287"){
					    capa.innerHTML="ARGUMENTACION ";
					}else if(opcionSeleccionada=="2264"){
					    capa.innerHTML="EVOLUCION, ECOLOGIA Y AMBIENTE ";
					}else if(opcionSeleccionada=="2216"){
					    capa.innerHTML="MECANICA ";
					}else if(opcionSeleccionada=="2217"){
					    capa.innerHTML="ARTES VISUALES: GRAFICA, PINTURA, ESCULTURA ";
					}else if(opcionSeleccionada=="2197"){
					    capa.innerHTML="LENGUAJE Y SOCIEDAD ";
					}else if(opcionSeleccionada=="2198"){
					    capa.innerHTML="ALGEBRA Y MODELOS ANALITICOS ";
					}else if(opcionSeleccionada=="2199"){
					    capa.innerHTML="CIENCIAS SOCIALES Y REALIDAD NACIONAL ";
					}else if(opcionSeleccionada=="3"){
					    capa.innerHTML="BIOLOGIA ";
					}else if(opcionSeleccionada=="5"){
					    capa.innerHTML="MATEMATICA ";
					}else if(opcionSeleccionada=="7"){
					    capa.innerHTML="FISICA ";
					}else if(opcionSeleccionada=="8"){
					    capa.innerHTML="QUIMICA ";
					}else if(opcionSeleccionada=="11"){
					    capa.innerHTML="EDUCACION FISICA ";
					}else if(opcionSeleccionada=="13"){
					    capa.innerHTML="RELIGION ";
					}else if(opcionSeleccionada=="19"){
					    capa.innerHTML="IDIOMA EXTRANJERO (INGLES) ";
					}else if(opcionSeleccionada=="50010"){
					    capa.innerHTML="Biologia super plus ";
					}else if(opcionSeleccionada=="1628"){
					    capa.innerHTML="TECNICA CULINARIA ";
					}else if(opcionSeleccionada=="1629"){
					    capa.innerHTML="TECNICAS ADMINISTRATIVAS DE SERVICIO ";
					}else if(opcionSeleccionada=="1630"){
					    capa.innerHTML="TECNICAS AVANZADAS DE PROGRAMACION ";
					}else if(opcionSeleccionada=="1631"){
					    capa.innerHTML="TECNICAS COMERCIALES ";
					}else if(opcionSeleccionada=="1632"){
					    capa.innerHTML="TECNICAS CULINARIAS ";
					}else if(opcionSeleccionada=="50024"){
					    capa.innerHTML="Formación Personal y Social ";
					}else if(opcionSeleccionada=="50023"){
					    capa.innerHTML="EDUCACION TECNOLOGICA CIENTIFICO HUMANISTA ";
					}else if(opcionSeleccionada=="50025"){
					    capa.innerHTML="Comunicación ";
					}else if(opcionSeleccionada=="50026"){
					    capa.innerHTML="Relación con el Medio Natural y Cultural ";
					}else if(opcionSeleccionada=="2424"){
					    capa.innerHTML="INSTALACION Y MANTENIMIENTO DE EQUIPO DE SONIDO E IMAGEN ";
					}else if(opcionSeleccionada=="2461"){
					    capa.innerHTML="MANTENIMIENTO Y OPERACION DE EQUIPOS DE CONTROL ELECTRONICO DE POTENCIA ";
					}else if(opcionSeleccionada=="50019"){
					    capa.innerHTML="Taller de Computación ";
					}else if(opcionSeleccionada=="50020"){
					    capa.innerHTML="Taller de Estética ";
					}else if(opcionSeleccionada=="50021"){
					    capa.innerHTML="Taller de Soldadura ";
					}else if(opcionSeleccionada=="50022"){
					    capa.innerHTML="Taller de Religión ";
					}else if(opcionSeleccionada=="50017"){
					    capa.innerHTML="Taller de Matemática ";
					}else if(opcionSeleccionada=="50018"){
					    capa.innerHTML="Taller de Deporte ";
					}else if(opcionSeleccionada=="2231"){
					    capa.innerHTML="ARMADO, OPERACION Y MANTENCION DE COMPUTADORES PERSONALES ";
					}else if(opcionSeleccionada=="3025"){
					    capa.innerHTML="OPERACION Y PROGRAMACION DE SISTEMA DE CONTROL DE RELES PROGRAMABLES ";
					}else if(opcionSeleccionada=="50027"){
					    capa.innerHTML="Formación Personal Y Social ";
					}else if(opcionSeleccionada=="50028"){
					    capa.innerHTML="Comunicación ";
					}else if(opcionSeleccionada=="50029"){
					    capa.innerHTML="Relación con el Medio Natural y Cultural ";
					}else if(opcionSeleccionada=="50030"){
					    capa.innerHTML="Formación Personal y Social ";
					}else if(opcionSeleccionada=="50031"){
					    capa.innerHTML="Comunicación ";
					}else if(opcionSeleccionada=="50032"){
					    capa.innerHTML="Relación con el Medio Natural y Cultural ";
					}else if(opcionSeleccionada=="50033"){
					    capa.innerHTML="Formación Personal y Social ";
					}else if(opcionSeleccionada=="50034"){
					    capa.innerHTML="Comunicación ";
					}else if(opcionSeleccionada=="50035"){
					    capa.innerHTML="Relación con el Medio Natural y Social ";
					}else if(opcionSeleccionada=="50036"){
					    capa.innerHTML="Taller de Orientación ";
					}else if(opcionSeleccionada=="50037"){
					    capa.innerHTML="Taller de Inglés Funcional ";
					}else if(opcionSeleccionada=="50038"){
					    capa.innerHTML="Taller de Desarrollo del Pensamiento y Orientación ";
					}else if(opcionSeleccionada=="50039"){
					    capa.innerHTML="Taller de Informática ";
					}else if(opcionSeleccionada=="50040"){
					    capa.innerHTML="Taller de Reforzamiento en Lenguaje ";
					}else if(opcionSeleccionada=="50041"){
					    capa.innerHTML="Taller de Psicomotricidad y vida sana ";
					}else if(opcionSeleccionada=="50042"){
					    capa.innerHTML="Taller Litúrgico y de infancia misionera ";
					}else if(opcionSeleccionada=="50043"){
					    capa.innerHTML="Taller de vida sana y deporte ";
					}else if(opcionSeleccionada=="50044"){
					    capa.innerHTML="Taller de Ciencias ";
					}else if(opcionSeleccionada=="50045"){
					    capa.innerHTML="Taller de expresión plástico visual ";
					}else if(opcionSeleccionada=="50046"){
					    capa.innerHTML="Taller de Biología ";
					}else if(opcionSeleccionada=="50047"){
					    capa.innerHTML="Taller de desarrollo del pensamiento y lógico ";
					}else if(opcionSeleccionada=="50048"){
					    capa.innerHTML="Clase Digigtal ";
					}else if(opcionSeleccionada=="50049"){
					    capa.innerHTML="Taller de reforzamiento de Inglés funcional ";
					}else if(opcionSeleccionada=="50050"){
					    capa.innerHTML="Taller de Lenguaje ";
					}else if(opcionSeleccionada=="50051"){
					    capa.innerHTML="Taller de Física ";
					}else if(opcionSeleccionada=="50052"){
					    capa.innerHTML="Taller de reforzamiento de matemática ";
					}else if(opcionSeleccionada=="50053"){
					    capa.innerHTML="Taller de Inglés Técnico ";
					}else if(opcionSeleccionada=="50054"){
					    capa.innerHTML="Taller de expresión oral y escrita ";
					}else if(opcionSeleccionada=="50055"){
					    capa.innerHTML="Orientación vocacional ";
					}else if(opcionSeleccionada=="50056"){
					    capa.innerHTML="Taller de ética profesional ";
					}else if(opcionSeleccionada=="50057"){
					    capa.innerHTML="Taller de Historia ";
					}else if(opcionSeleccionada=="50058"){
					    capa.innerHTML="Taller de Química ";
					}else if(opcionSeleccionada=="50063"){
					    capa.innerHTML="Artes Escénicas: Teatro ";
					}else if(opcionSeleccionada=="50064"){
					    capa.innerHTML="Arte ";
					}else if(opcionSeleccionada=="50065"){
					    capa.innerHTML="Lectura oral ";
					}else if(opcionSeleccionada=="50066"){
					    capa.innerHTML="Lectura complementaria ";
					}else if(opcionSeleccionada=="50067"){
					    capa.innerHTML="Expresión oral ";
					}else if(opcionSeleccionada=="50068"){
					    capa.innerHTML="Expresión escrita ";
					}else if(opcionSeleccionada=="50059"){
					    capa.innerHTML="Resolucion de problemas ";
					}else if(opcionSeleccionada=="50060"){
					    capa.innerHTML="Numeracion ";
					}else if(opcionSeleccionada=="50061"){
					    capa.innerHTML="Dictado ";
					}else if(opcionSeleccionada=="50069"){
					    capa.innerHTML="Dictado ";
					}else if(opcionSeleccionada=="50062"){
					    capa.innerHTML="nuevo subsector disponible ";
					}else if(opcionSeleccionada=="50070"){
					    capa.innerHTML="Oral reading ";
					}else if(opcionSeleccionada=="50071"){
					    capa.innerHTML="Oral expression ";
					}else if(opcionSeleccionada=="50072"){
					    capa.innerHTML="Dictation ";
					}else if(opcionSeleccionada=="50073"){
					    capa.innerHTML="Writing ";
					}else if(opcionSeleccionada=="50074"){
					    capa.innerHTML="Comprehension ";
					}else if(opcionSeleccionada=="50075"){
					    capa.innerHTML="Spelling ";
					}else if(opcionSeleccionada=="50076"){
					    capa.innerHTML="Quiz ";
					}else if(opcionSeleccionada=="50077"){
					    capa.innerHTML="Resolución de problemas ";
					}else if(opcionSeleccionada=="50078"){
					    capa.innerHTML="Numeración ";
					}else if(opcionSeleccionada=="50079"){
					    capa.innerHTML="Dictado numerico ";
					}else if(opcionSeleccionada=="50080"){
					    capa.innerHTML="Proyectos individuales ";
					}else if(opcionSeleccionada=="50081"){
					    capa.innerHTML="Proyectos grupales ";
					}else if(opcionSeleccionada=="50082"){
					    capa.innerHTML="Música ";
					}else if(opcionSeleccionada=="50083"){
					    capa.innerHTML="Arte ";
					}else if(opcionSeleccionada=="50084"){
					    capa.innerHTML="Proyectos individuales naturaleza ";
					}else if(opcionSeleccionada=="50085"){
					    capa.innerHTML="Proyectos grupales naturaleza ";
					}else if(opcionSeleccionada=="50086"){
					    capa.innerHTML="Proyectos individuales sociedad ";
					}else if(opcionSeleccionada=="50087"){
					    capa.innerHTML="Proyectos grupales sociedad ";
					}else if(opcionSeleccionada=="50088"){
					    capa.innerHTML="Taller Inglès ";
					}else if(opcionSeleccionada=="50089"){
					    capa.innerHTML="Taller Inglés ";
					}else if(opcionSeleccionada=="50090"){
					    capa.innerHTML="Taller Inglés ";
					}else if(opcionSeleccionada=="50091"){
					    capa.innerHTML="Taller Inglés ";
					}else if(opcionSeleccionada=="50092"){
					    capa.innerHTML="TALLER DE EDUCACIÓN MUSICAL ";
					}else if(opcionSeleccionada=="50093"){
					    capa.innerHTML="Filosofia ";
					}else if(opcionSeleccionada=="50094"){
					    capa.innerHTML="Filosofia ";
					}else if(opcionSeleccionada=="50095"){
					    capa.innerHTML="GESTION DE LA PEQUEÑA EMPRESA ";
					}else if(opcionSeleccionada=="6955"){
					    capa.innerHTML="MANTENIMIENTO, MONTAJE Y DESMONTAJE ";
					}else if(opcionSeleccionada=="6956"){
					    capa.innerHTML="PRIMEROS AUXILIOS Y SOBREVIVENCIA EN EL MAR ";
					}else if(opcionSeleccionada=="6957"){
					    capa.innerHTML="QUIMICA DE ALIMENTOS ";
					}else if(opcionSeleccionada=="6958"){
					    capa.innerHTML="CONTABILIDAD COMPUTACIONAL ";
					}else if(opcionSeleccionada=="6959"){
					    capa.innerHTML="PRACTICAS DE OFICINA ";
					}else if(opcionSeleccionada=="6960"){
					    capa.innerHTML="CONTABILIDAD FINANCIERA ";
					}else if(opcionSeleccionada=="6961"){
					    capa.innerHTML="GESTION EN PEQUEÑA Y MEDIANA EMPRESA ";
					}else if(opcionSeleccionada=="6962"){
					    capa.innerHTML="INVESTIGACION COMERCIAL ";
					}else if(opcionSeleccionada=="6963"){
					    capa.innerHTML="LA POLITICA Y SUS CONSECUENCIAS SOCIALES Y ECONOMICAS ";
					}else if(opcionSeleccionada=="6964"){
					    capa.innerHTML="TALLER DE ITALIANO ";
					}else if(opcionSeleccionada=="6965"){
					    capa.innerHTML="GESTION EN ADMINISTRACION DE PERSONAL ";
					}else if(opcionSeleccionada=="6966"){
					    capa.innerHTML="INTERPRETACION MUSICAL FOLCLORICA I ";
					}else if(opcionSeleccionada=="6967"){
					    capa.innerHTML="DIBUJO Y PINTURA I ";
					}else if(opcionSeleccionada=="6968"){
					    capa.innerHTML="ARTES ESCENICAS I ";
					}else if(opcionSeleccionada=="6969"){
					    capa.innerHTML="EJECUCION INSTRUMENTAL SUPERIOR I ";
					}else if(opcionSeleccionada=="6970"){
					    capa.innerHTML="DANZA Y EXPRESION I ";
					}else if(opcionSeleccionada=="6971"){
					    capa.innerHTML="INTERPRETACION MUSICAL FOLCLORICA II ";
					}else if(opcionSeleccionada=="6972"){
					    capa.innerHTML="DIBUJO Y PINTURA II ";
					}else if(opcionSeleccionada=="6973"){
					    capa.innerHTML="ARTES ESCENICAS II ";
					}else if(opcionSeleccionada=="6974"){
					    capa.innerHTML="DANZA Y EXPRESION II ";
					}else if(opcionSeleccionada=="6975"){
					    capa.innerHTML="EJECUCION INSTRUMENTAL SUPERIOR II ";
					}else if(opcionSeleccionada=="6976"){
					    capa.innerHTML="SERVICIO DE ATENCION AL CLIENTE E INVESTIGACION DE MERCADO ";
					}else if(opcionSeleccionada=="6977"){
					    capa.innerHTML="GESTION DE RECURSOS HUMANOS, CONTABILIDAD BASICA Y COMUNICACION ORGANIZACIONAL ";
					}else if(opcionSeleccionada=="6978"){
					    capa.innerHTML="GESTION DE LA PEQUEÑA EMPRESA Y NORMATIVA COMERCIAL Y TRIBUTARIA ";
					}else if(opcionSeleccionada=="6979"){
					    capa.innerHTML="GESTION DE COMPRA-VENTA, APROVISIONAMIENTO Y COSTO Y ESTADOS DE RESULTADOS ";
					}else if(opcionSeleccionada=="6980"){
					    capa.innerHTML="LA REDACCION, ARTE DE LA PALABRA ESCRITA Y SU FUTURO EN LAS COMUNICACIONES. ";
					}else if(opcionSeleccionada=="6981"){
					    capa.innerHTML="PERSONALIDAD Y RELACIONES HUMANAS ";
					}else if(opcionSeleccionada=="6982"){
					    capa.innerHTML="TEENAGERS AT WORK ";
					}else if(opcionSeleccionada=="6983"){
					    capa.innerHTML="CIENCIAS RELIGIOSAS ";
					}else if(opcionSeleccionada=="6984"){
					    capa.innerHTML="LITERATURA FANTASTICA Y DE CIENCIA FICCION ";
					}else if(opcionSeleccionada=="6985"){
					    capa.innerHTML="TAXONOMIA VEGETAL ";
					}else if(opcionSeleccionada=="6986"){
					    capa.innerHTML="REPRODUCCION Y GENETICA EN EL SER HUMANO ";
					}else if(opcionSeleccionada=="6992"){
					    capa.innerHTML="FORMACION CONDUCTUAL ";
					}else if(opcionSeleccionada=="6993"){
					    capa.innerHTML="SECRETARIADO, RELACIONES PUBLICAS Y COMUNICACION ORGANIZACIONAL ";
					}else if(opcionSeleccionada=="6994"){
					    capa.innerHTML="GESTION EMPRESARIAL, ADMINISTRATIVO CONTABLE, PREVISIONAL Y TRIBUTARIA ";
					}else if(opcionSeleccionada=="6995"){
					    capa.innerHTML="GESTION EN COMERCIO EXTERIOR, COMERCIO ELECTRONICO Y NORMATIVA COMERCIAL Y TRIBUTARIA ";
					}else if(opcionSeleccionada=="6996"){
					    capa.innerHTML="ENOLOGIA Y TECNICAS DE SERVICIO DE BAR ";
					}else if(opcionSeleccionada=="6997"){
					    capa.innerHTML="HABITACIONES Y TECNICAS DE LAVANDERIA ";
					}else if(opcionSeleccionada=="6998"){
					    capa.innerHTML="PLANIFICACION, CONTROL Y TECNICAS DE LOS SERVICIOS DE RESTAURANT, BAR, CAFETERIA Y ATENCION AL CLIENTE ";
					}else if(opcionSeleccionada=="6999"){
					    capa.innerHTML="TECNICAS DE VENTA Y SERVICIO DE CONSEJERIA ";
					}else if(opcionSeleccionada=="7000"){
					    capa.innerHTML="PLANIFICACION Y TECNICA DE OPERACION Y RESERVA Y CONTROL DE ALOJAMIENTO ";
					}else if(opcionSeleccionada=="8001"){
					    capa.innerHTML="EJECUCION DE EVENTOS Y COCTELERIA ";
					}else if(opcionSeleccionada=="8002"){
					    capa.innerHTML="FISICA DE FLUIDOS Y CAMPOS ";
					}else if(opcionSeleccionada=="8003"){
					    capa.innerHTML="HISTORIA Y GEOGRAFIA DE ESPAÑA ";
					}else if(opcionSeleccionada=="8004"){
					    capa.innerHTML="VIRTUDES Y ETICA PROFESIONAL ";
					}else if(opcionSeleccionada=="8005"){
					    capa.innerHTML="FACTORES, SISTEMAS DE PRODUCCION Y PROPAGACION VEGETAL ";
					}else if(opcionSeleccionada=="8006"){
					    capa.innerHTML="COMPUTACION AVANZADA I ";
					}else if(opcionSeleccionada=="8007"){
					    capa.innerHTML="COMPUTACION AVANZADA II ";
					}else if(opcionSeleccionada=="8008"){
					    capa.innerHTML="TOPOGRAFIA MINERA SUBTERRANEA ";
					}else if(opcionSeleccionada=="8009"){
					    capa.innerHTML="ORIENTACION VOCACIONAL Y LABORAL ";
					}else if(opcionSeleccionada=="8010"){
					    capa.innerHTML="ORGANIZACION Y PRACTICA DEPORTIVA ";
					}else if(opcionSeleccionada=="8011"){
					    capa.innerHTML="LENGUA RAPA-NUI ";
					}else if(opcionSeleccionada=="8012"){
					    capa.innerHTML="OBRAS MAYORES DE CARPINTERIA, ESTRUCTURA Y HORMIGON ";
					}else if(opcionSeleccionada=="8013"){
					    capa.innerHTML="LENGUA, LITERATURA Y COMUNICACION. ";
					}else if(opcionSeleccionada=="8014"){
					    capa.innerHTML="ALGEBRA, FUNCIONES Y GEOMETRIA. ";
					}else if(opcionSeleccionada=="8015"){
					    capa.innerHTML="NUMEROS, PROPORCIONALIDAD Y GEOMETRIA. ";
					}else if(opcionSeleccionada=="8016"){
					    capa.innerHTML="LENGUA Y PENSAMIENTO ";
					}else if(opcionSeleccionada=="8017"){
					    capa.innerHTML="LOS AVANCES TECNOLOGICOS Y SU IMPACTO EN LA HUMANIDAD. ";
					}else if(opcionSeleccionada=="8018"){
					    capa.innerHTML="ESTADISTICA, FUNCIONES Y GEOMETRIA. ";
					}else if(opcionSeleccionada=="8019"){
					    capa.innerHTML="PROFUNDIZACION DE LA FISICA CLASICA. ";
					}else if(opcionSeleccionada=="8020"){
					    capa.innerHTML="BIOQUIMICA Y FISIOANATOMIA. ";
					}else if(opcionSeleccionada=="8021"){
					    capa.innerHTML="OPERACION DE MAQUINARIAS PESADAS: EQUIPO DE APOYO ";
					}else if(opcionSeleccionada=="8022"){
					    capa.innerHTML="OPERACION DE MAQUINARIAS PESADAS: CAMIONES ALTO TONELAJE ";
					}else if(opcionSeleccionada=="8023"){
					    capa.innerHTML="LENGUAJE ALGEBRAICO Y MODELOS LINEALES ";
					}else if(opcionSeleccionada=="8024"){
					    capa.innerHTML="DESARROLLO DE HABILIDADES COMUNICACIONALES ";
					}else if(opcionSeleccionada=="8025"){
					    capa.innerHTML="DESARROLLO DE UN PENSAMIENTO DE CALIDAD ";
					}else if(opcionSeleccionada=="8026"){
					    capa.innerHTML="EVOLUCION BIOLOGICA, CELULAR ANATOMICA Y ECOLOGICA ";
					}else if(opcionSeleccionada=="8027"){
					    capa.innerHTML="ARTES DRAMATICAS ";
					}else if(opcionSeleccionada=="8028"){
					    capa.innerHTML="ELECTIVO ARTISTICO III ";
					}else if(opcionSeleccionada=="8029"){
					    capa.innerHTML="ELECTIVO CIENTIFICO-BIOLOGICO I ";
					}else if(opcionSeleccionada=="8030"){
					    capa.innerHTML="ELECTIVO CIENTIFICO-BIOLOGICO II ";
					}else if(opcionSeleccionada=="8031"){
					    capa.innerHTML="ELECTIVO CIENTIFICO-BIOLOGICO III ";
					}else if(opcionSeleccionada=="8032"){
					    capa.innerHTML="ELECTIVO CIENTIFICO-MATEMATICO I ";
					}else if(opcionSeleccionada=="8033"){
					    capa.innerHTML="ELECTIVO CIENTIFICO-MATEMATICO II ";
					}else if(opcionSeleccionada=="8034"){
					    capa.innerHTML="ELECTIVO CIENTIFICO-MATEMATICO III ";
					}else if(opcionSeleccionada=="8035"){
					    capa.innerHTML="NUMEROS, PROPORCIONALIDAD Y GEOMETRIA. ";
					}else if(opcionSeleccionada=="8036"){
					    capa.innerHTML="MICROBIOLOGIA Y QUIMICA DE LOS ALIMENTOS ";
					}else if(opcionSeleccionada=="8037"){
					    capa.innerHTML="EQUIPOS Y PROCESOS TERMICOS ";
					}else if(opcionSeleccionada=="8038"){
					    capa.innerHTML="PROCESAMIENTO DE CARNEOS Y SUS DERIVADOS ";
					}else if(opcionSeleccionada=="8039"){
					    capa.innerHTML="ELABORACION DE PRODUCTOS PESQUEROS ";
					}else if(opcionSeleccionada=="8040"){
					    capa.innerHTML="MEJORAMIENTO DE LA CALIDAD Y PRODUCTIVIDAD ";
					}else if(opcionSeleccionada=="8041"){
					    capa.innerHTML="ALMACENAMIENTO Y COMERCIALIZACION ";
					}else if(opcionSeleccionada=="8042"){
					    capa.innerHTML="BOBINADO DE MAQUINAS ";
					}else if(opcionSeleccionada=="8043"){
					    capa.innerHTML="EXPERIENCIAS EDUCATIVAS PARA EL PARVULO ";
					}else if(opcionSeleccionada=="8044"){
					    capa.innerHTML="ETAPAS DE DESARROLLO DEL PARVULO ";
					}else if(opcionSeleccionada=="8045"){
					    capa.innerHTML="CREACION DE MATERIAL DIDACTICO Y DECORATIVO CON TECNICAS DIVERSAS ";
					}else if(opcionSeleccionada=="8046"){
					    capa.innerHTML="RECURSOS LITERARIOS PARA EL TRABAJO CON PARVULO ";
					}else if(opcionSeleccionada=="8047"){
					    capa.innerHTML="ALIMENTACION E HIGIENE DEL PARVULO ";
					}else if(opcionSeleccionada=="8048"){
					    capa.innerHTML="ACTIVIDADES RECREATIVAS EN EL PARVULO ";
					}else if(opcionSeleccionada=="8049"){
					    capa.innerHTML="ACTIVIDADES MUSICALES EN EL PARVULO ";
					}else if(opcionSeleccionada=="8050"){
					    capa.innerHTML="RECURSOS METODOLOGICOS PARA EL TRABAJO DE PARVULOS ";
					}else if(opcionSeleccionada=="8051"){
					    capa.innerHTML="DESARROLLO DEL PARVULO ";
					}else if(opcionSeleccionada=="8052"){
					    capa.innerHTML="ESTRATEGIAS DE APRENDIZAJE PARA EL PARVULO ";
					}else if(opcionSeleccionada=="8053"){
					    capa.innerHTML="DISEÑO DE MATERIAL DIDACTICO Y DECORATIVO DE ESPACIOS EDUCATIVOS ";
					}else if(opcionSeleccionada=="8054"){
					    capa.innerHTML="SALUD Y PREVENCION DE RIESGOS EN EL PARVULO ";
					}else if(opcionSeleccionada=="8055"){
					    capa.innerHTML="LA EXPRESION CORPORAL EN EL PARVULO ";
					}else if(opcionSeleccionada=="8056"){
					    capa.innerHTML="MANEJO DE TECNICAS DE EXPRESION MUSICAL ";
					}else if(opcionSeleccionada=="8057"){
					    capa.innerHTML="ACTIVIDADES LUDICAS EXTRAPROGRAMATICAS FORTALECIENDO INDEPENDENCIA ";
					}else if(opcionSeleccionada=="8058"){
					    capa.innerHTML="LA TECNOLOGIA DE LA INFORMATICA A NIVEL PEDAGOGICO ";
					}else if(opcionSeleccionada=="8059"){
					    capa.innerHTML="ESTRUCTURA Y FUNCIONAMIENTO DE UNA EMPRESA HOTELERA ";
					}else if(opcionSeleccionada=="8060"){
					    capa.innerHTML="GASTRONOMIA BASICA ";
					}else if(opcionSeleccionada=="8061"){
					    capa.innerHTML="APLICANDO AUDIOVISUALES EN LA COMUNICACION ";
					}else if(opcionSeleccionada=="8062"){
					    capa.innerHTML="EL INGLES EN LA HOTELERIA ";
					}else if(opcionSeleccionada=="8063"){
					    capa.innerHTML="ADMINISTRACION DE ACTIVIDADES HOTELERAS ";
					}else if(opcionSeleccionada=="8064"){
					    capa.innerHTML="PRODUCCION DE VINOS ";
					}else if(opcionSeleccionada=="8065"){
					    capa.innerHTML="ADMINISTRACION DE UNA EMPRESA HOTELERA ";
					}else if(opcionSeleccionada=="8066"){
					    capa.innerHTML="CREANDO CON OFFICE ";
					}else if(opcionSeleccionada=="8067"){
					    capa.innerHTML="EL SERVICIO DE RESTAURANT, BAR Y COMEDOR ";
					}else if(opcionSeleccionada=="8068"){
					    capa.innerHTML="PROGRAMACION DE EVENTOS ";
					}else if(opcionSeleccionada=="8069"){
					    capa.innerHTML="PRACTIQUEMOS INGLES ";
					}else if(opcionSeleccionada=="8070"){
					    capa.innerHTML="REACTIVIDAD Y EQUILIBRIO QUIMICO ";
					}else if(opcionSeleccionada=="8071"){
					    capa.innerHTML="PROCESO DE PRODUCTOS QUIMICOS ";
					}else if(opcionSeleccionada=="8072"){
					    capa.innerHTML="RECONOCIMIENTO DE CATIONES Y ANIONES ";
					}else if(opcionSeleccionada=="8073"){
					    capa.innerHTML="FUNDAMENTOS DE BIOLOGIA EN CONEXION CON LOS PROCESOS QUIMICOS ";
					}else if(opcionSeleccionada=="8074"){
					    capa.innerHTML="MECANICA Y FLUIDOS ";
					}else if(opcionSeleccionada=="8075"){
					    capa.innerHTML="MUNDO ATOMICO Y ELECTROMAGNETISMO ";
					}else if(opcionSeleccionada=="8076"){
					    capa.innerHTML="APLICANDO LA INFORMATICA A LA QUIMICA ";
					}else if(opcionSeleccionada=="8077"){
					    capa.innerHTML="REGISTRO DE DATOS ";
					}else if(opcionSeleccionada=="8078"){
					    capa.innerHTML="ENERGIA Y ESTRUCTURA MACROSCOPICA ";
					}else if(opcionSeleccionada=="8079"){
					    capa.innerHTML="CULTIVOS DE ALGAS Y CRUSTACEOS ";
					}else if(opcionSeleccionada=="8080"){
					    capa.innerHTML="MANEJO SUSTENTABLE DE EMPRESAS TURISTICAS. ";
					}else if(opcionSeleccionada=="8081"){
					    capa.innerHTML="GESTION ADMINISTRATIVA Y FINANCIERA DE EMPRESAS I. ";
					}else if(opcionSeleccionada=="8082"){
					    capa.innerHTML="GESTION ADMINISTRATIVA Y FINANCIERA DE EMPRESAS II. ";
					}else if(opcionSeleccionada=="8083"){
					    capa.innerHTML="MANEJO DE ACTIVIDADES PRODUCTIVAS EN EXPLOTACIONES AGROPECUARIAS. ";
					}else if(opcionSeleccionada=="8084"){
					    capa.innerHTML="TECNICAS, MANEJO Y GESTION AGROPECUARIA. ";
					}else if(opcionSeleccionada=="8085"){
					    capa.innerHTML="LABORATORIO CONTROLADORES AUTOMATICOS INDUSTRIALES. ";
					}else if(opcionSeleccionada=="8086"){
					    capa.innerHTML="LABORATORIO MICROPROCESADORES. ";
					}else if(opcionSeleccionada=="8087"){
					    capa.innerHTML="LABORATORIO CONTROL AUTOMATICO. ";
					}else if(opcionSeleccionada=="8088"){
					    capa.innerHTML="PREVENCION DE RIESGOS ELECTRONICOS. ";
					}else if(opcionSeleccionada=="8089"){
					    capa.innerHTML="INSTALACION OPERACION Y PROGRAMACION DE EQUIPOS Y SISTEMAS TELEFONICOS DE RADIO COMUNICACION TELEINFORMATICO. ";
					}else if(opcionSeleccionada=="8090"){
					    capa.innerHTML="ELECTIVO HUMANISTA III ";
					}else if(opcionSeleccionada=="8091"){
					    capa.innerHTML="INTRODUCCION AL MUNDO AGROPECUARIO ";
					}else if(opcionSeleccionada=="8092"){
					    capa.innerHTML="INTRODUCCION AL MUNDO DEL TURISMO ";
					}else if(opcionSeleccionada=="8093"){
					    capa.innerHTML="INTRODUCCION AL MUNDO DE LA MINERIA ";
					}else if(opcionSeleccionada=="8094"){
					    capa.innerHTML="ADOLESCENCIA TIEMPO DE DECISIONES ";
					}else if(opcionSeleccionada=="8095"){
					    capa.innerHTML="CICLO EXPLORATORIO ";
					}else if(opcionSeleccionada=="8096"){
					    capa.innerHTML="PLAN ELECTIVO EN ARTES MUSICALES ";
					}else if(opcionSeleccionada=="8097"){
					    capa.innerHTML="PLAN ELECTIVO EN ARTES VISUALES Y ESCENICAS ";
					}else if(opcionSeleccionada=="8098"){
					    capa.innerHTML="TURISMO ECOLOGICO Y DE AVENTURA ";
					}else if(opcionSeleccionada=="8099"){
					    capa.innerHTML="AREA SILVESTRE PROTEGIDA ";
					}else if(opcionSeleccionada=="8889"){
					    capa.innerHTML="INGLES LITERARIO Y CULTURAL ";
					}else if(opcionSeleccionada=="9000"){
					    capa.innerHTML="QUIMICA INDUSTRIAL Y PREVENCION DE RIESGOS. ";
					}else if(opcionSeleccionada=="9001"){
					    capa.innerHTML="ANALISIS GRAVIMETRICO Y VOLUMETRICO ";
					}else if(opcionSeleccionada=="9002"){
					    capa.innerHTML="PLANES DE MUESTREO ";
					}else if(opcionSeleccionada=="9003"){
					    capa.innerHTML="CRIANZA DE GANADO LECHERO BOVINO ";
					}else if(opcionSeleccionada=="9004"){
					    capa.innerHTML="PROYECTO SOCIAL N°1 ";
					}else if(opcionSeleccionada=="9005"){
					    capa.innerHTML="PROYECTO SOCIAL N°2 ";
					}else if(opcionSeleccionada=="9006"){
					    capa.innerHTML="TURISMO RURAL ";
					}else if(opcionSeleccionada=="9007"){
					    capa.innerHTML="PROGRAMACION Y ORGANIZACION DE EVENTOS ";
					}else if(opcionSeleccionada=="9008"){
					    capa.innerHTML="INTRODUCCION AL MUNDO DE LA MINERIA Y GEOLOGIA ";
					}else if(opcionSeleccionada=="9009"){
					    capa.innerHTML="ECONOMIA, NEGOCIOS Y RELACIONES LABORALES ";
					}else if(opcionSeleccionada=="9010"){
					    capa.innerHTML="PSICOLOGIA Y ETICA DEL TRABAJO ";
					}else if(opcionSeleccionada=="9011"){
					    capa.innerHTML="CIRCUITOS ELECTROMAGNETICOS ";
					}else if(opcionSeleccionada=="9012"){
					    capa.innerHTML="COMUNICACION ANALOGICA ";
					}else if(opcionSeleccionada=="9013"){
					    capa.innerHTML="COMUNICACION DIGITAL ";
					}else if(opcionSeleccionada=="9014"){
					    capa.innerHTML="TECNOLOGIA DE REDES ";
					}else if(opcionSeleccionada=="9015"){
					    capa.innerHTML="SISTEMAS OPERATIVOS Y APLICACIONES ";
					}else if(opcionSeleccionada=="9016"){
					    capa.innerHTML="TECNOLOGIA DE COMUNICACIONES ";
					}else if(opcionSeleccionada=="9017"){
					    capa.innerHTML="CANALIZACION E INTERVENCION DE CONSTRUCCIONES ";
					}else if(opcionSeleccionada=="9018"){
					    capa.innerHTML="CABLEADO Y CERTIFICACION ";
					}else if(opcionSeleccionada=="9019"){
					    capa.innerHTML="ARMADO Y REPARACION DE PCS ";
					}else if(opcionSeleccionada=="9020"){
					    capa.innerHTML="LABORATORIO DE ADMINISTRACION Y COMERCIO ";
					}else if(opcionSeleccionada=="9021"){
					    capa.innerHTML="PRINCIPIOS ELECTRICOS ";
					}else if(opcionSeleccionada=="9022"){
					    capa.innerHTML="LA IDENTIDAD EN LA LITERATURA ";
					}else if(opcionSeleccionada=="9023"){
					    capa.innerHTML="SOCIEDAD Y DEMOCRACIA ";
					}else if(opcionSeleccionada=="9024"){
					    capa.innerHTML="CIMENTANDO EL SER II ";
					}else if(opcionSeleccionada=="9025"){
					    capa.innerHTML="FUNDAMENTOS DE LEGISLACION LABORAL II ";
					}else if(opcionSeleccionada=="9026"){
					    capa.innerHTML="EDUCACION TECNOLOGICA E INFORMATICA II ";
					}else if(opcionSeleccionada=="9027"){
					    capa.innerHTML="EVOLUCION, ECOLOGIA Y AMBIENTE 3º MEDIO ";
					}else if(opcionSeleccionada=="9028"){
					    capa.innerHTML="LOGISTICA ";
					}else if(opcionSeleccionada=="9029"){
					    capa.innerHTML="OPERACIONES LOGISTICAS DE ALMACEN ";
					}else if(opcionSeleccionada=="9030"){
					    capa.innerHTML="RECEPCION Y ALMACENJE DE PRODUCTOS ";
					}else if(opcionSeleccionada=="9031"){
					    capa.innerHTML="DESPACHO Y DISTRIBUCION DE PRODUCTOS ";
					}else if(opcionSeleccionada=="9032"){
					    capa.innerHTML="PROYECTO PERSONAL ";
					}else if(opcionSeleccionada=="9033"){
					    capa.innerHTML="RAICES DE LA CIVILIZACION OCCIDENTAL ";
					}else if(opcionSeleccionada=="9034"){
					    capa.innerHTML="GESTION EN COMPRA VENTA Y RECURSOS HUMANOS ";
					}else if(opcionSeleccionada=="9035"){
					    capa.innerHTML="COMUNICACION EN ATENCION AL CLIENTE ";
					}else if(opcionSeleccionada=="9036"){
					    capa.innerHTML="NORMATIVA CONTABLE Y TRIBUTARIA ";
					}else if(opcionSeleccionada=="9037"){
					    capa.innerHTML="FACTORES DE LA PRODUCCION VEGETAL Y PROPAGACION ";
					}else if(opcionSeleccionada=="9038"){
					    capa.innerHTML="PRODUCCION VEGETAL Y AGRO ECOLOGIA ";
					}else if(opcionSeleccionada=="9039"){
					    capa.innerHTML="LOGICA Y TECNICA DE LA INVESTIGACION I ";
					}else if(opcionSeleccionada=="9040"){
					    capa.innerHTML="LOGICA Y TECNICA DE LA INVESTIGACION II ";
					}else if(opcionSeleccionada=="9041"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION FORMACION DIFERENCIADA AREA HUMANISTA ";
					}else if(opcionSeleccionada=="9042"){
					    capa.innerHTML="HISTORIA Y CIENCIAS SOCIALES FORMACION DIFERENCIADA AREA HUMANISTA ";
					}else if(opcionSeleccionada=="9043"){
					    capa.innerHTML="MATEMATICA FORMACION DIFERENCIADA AREA HUMANISTA ";
					}else if(opcionSeleccionada=="9044"){
					    capa.innerHTML="MATEMATICA FORMACION DIFERENCIADA AREA BIOLOGICA ";
					}else if(opcionSeleccionada=="9045"){
					    capa.innerHTML="QUIMICA FORMACION DIFERENCIADA AREA BIOLOGICA ";
					}else if(opcionSeleccionada=="9046"){
					    capa.innerHTML="BIOLOGIA FORMACION DIFERENCIADA AREA BIOLOGIA ";
					}else if(opcionSeleccionada=="9047"){
					    capa.innerHTML="MATEMATICA FORMACION DIFERENCIADA AREA MATEMATICA ";
					}else if(opcionSeleccionada=="9048"){
					    capa.innerHTML="FISICA FORMACION DIFERENCIADA AREA MATEMATICA ";
					}else if(opcionSeleccionada=="9049"){
					    capa.innerHTML="QUIMICA FORMACION DIFERENCIADA AREA MATEMATICA. ";
					}else if(opcionSeleccionada=="9050"){
					    capa.innerHTML="ARQUITECTURA NAVAL Y REGLAMENTACION MARITIMA. ";
					}else if(opcionSeleccionada=="9051"){
					    capa.innerHTML="DESARROLLO DE LAS CAPACIDADES COGNITIVAS EN EL PARVULO ";
					}else if(opcionSeleccionada=="9052"){
					    capa.innerHTML="PRODUCCION VEGETAL Y AGROECOLOGIA. ";
					}else if(opcionSeleccionada=="9053"){
					    capa.innerHTML="DESARROLLO DEL PENSAMIENTO CREATIVO ";
					}else if(opcionSeleccionada=="9054"){
					    capa.innerHTML="TRABAJO Y SOCIEDAD EN LA HISTORIA DE CHILE ";
					}else if(opcionSeleccionada=="9055"){
					    capa.innerHTML="AREA CAPACITACION TECNICA ";
					}else if(opcionSeleccionada=="9056"){
					    capa.innerHTML="AREA CAPACITACION PARTICIPACION CIUDADANA ";
					}else if(opcionSeleccionada=="9057"){
					    capa.innerHTML="MARKETING FUNDAMENTAL Y ESTRATEGICO ";
					}else if(opcionSeleccionada=="9058"){
					    capa.innerHTML="NUTRICION Y ALIMENTACION ";
					}else if(opcionSeleccionada=="9059"){
					    capa.innerHTML="MANEJO DE RECURSOS BENTONICOS ";
					}else if(opcionSeleccionada=="9060"){
					    capa.innerHTML="CULTIVO DE ESPECIES NO TRADICIONALES ";
					}else if(opcionSeleccionada=="9061"){
					    capa.innerHTML="CONTABILIDAD BASICA Y LEGISLACION ";
					}else if(opcionSeleccionada=="9062"){
					    capa.innerHTML="TESINA ";
					}else if(opcionSeleccionada=="9063"){
					    capa.innerHTML="CIENCIAS SOCIALES E HISTORIA GENERAL ";
					}else if(opcionSeleccionada=="9064"){
					    capa.innerHTML="ELECTRONICA APLICADA AL DISEÑO DE SISTEMAS TECNOLOGICOS ";
					}else if(opcionSeleccionada=="9065"){
					    capa.innerHTML="CIENCIAS SOCIALES Y MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="9066"){
					    capa.innerHTML="FORMACION DIFERENCIAL DE EDUCACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="9067"){
					    capa.innerHTML="NUTRICION VEGETAL Y FERTILIZANTES ";
					}else if(opcionSeleccionada=="9068"){
					    capa.innerHTML="FUNDAMENTOS Y METODOS DE RIEGO Y DRENAJE ";
					}else if(opcionSeleccionada=="9069"){
					    capa.innerHTML="VINIFICACION ";
					}else if(opcionSeleccionada=="9070"){
					    capa.innerHTML="ALIMENTACION Y NUTRICION ANIMAL ";
					}else if(opcionSeleccionada=="9071"){
					    capa.innerHTML="ADMINISTRACION Y GESTION DE PERSONAL ";
					}else if(opcionSeleccionada=="9072"){
					    capa.innerHTML="METODOLOGIAS DE LABORES AGRICOLAS IV ";

					}else if(opcionSeleccionada=="9073"){
					    capa.innerHTML="MANEJO DE SUELOS AGRICOLAS ";
					}else if(opcionSeleccionada=="9074"){
					    capa.innerHTML="FRUTALES DE HOJA CADUCA Y PERSISTENTE ";
					}else if(opcionSeleccionada=="9075"){
					    capa.innerHTML="VITICULTURA I ";
					}else if(opcionSeleccionada=="9076"){
					    capa.innerHTML="MAQUINARIA AGRICOLA I ";
					}else if(opcionSeleccionada=="9077"){
					    capa.innerHTML="METODOLOGIAS DE LABORES AGRICOLAS III ";
					}else if(opcionSeleccionada=="9078"){
					    capa.innerHTML="HISTORIA ESPECIFICA I ";
					}else if(opcionSeleccionada=="9079"){
					    capa.innerHTML="HISTORIA ESPECIFICA II ";
					}else if(opcionSeleccionada=="9080"){
					    capa.innerHTML="LITERATURA Y EXPRESION I ";
					}else if(opcionSeleccionada=="9081"){
					    capa.innerHTML="LITERATURA Y EXPRESION II ";
					}else if(opcionSeleccionada=="9082"){
					    capa.innerHTML="FISICA QUIMICA I ";
					}else if(opcionSeleccionada=="9083"){
					    capa.innerHTML="FISICA QUIMICA II ";
					}else if(opcionSeleccionada=="9084"){
					    capa.innerHTML="AUDIOVISUAL HUMANISTA ";
					}else if(opcionSeleccionada=="9085"){
					    capa.innerHTML="AUDIOVISUAL CIENCIAS ";
					}else if(opcionSeleccionada=="9086"){
					    capa.innerHTML="ANIMACION TURISTICA ";
					}else if(opcionSeleccionada=="9087"){
					    capa.innerHTML="NORMATIVA COMERCIAL, TRIBUTARIA Y CONTABILIDAD ";
					}else if(opcionSeleccionada=="9088"){
					    capa.innerHTML="FUNDAMENTOS PARA LA ORGANIZACION DE ACTIVIDADES TURISTICAS. ";
					}else if(opcionSeleccionada=="9089"){
					    capa.innerHTML="GESTION DE LA PRODUCCION EN COCINA Y PASTELERIA ";
					}else if(opcionSeleccionada=="9090"){
					    capa.innerHTML="GESTION DE LA COMPRA Y LA VENTA EN EMPRESAS DE SERVICIOS GASTRONOMICOS ";
					}else if(opcionSeleccionada=="9091"){
					    capa.innerHTML="GESTION DE LA PRODUCCION DE EVENTOS ";
					}else if(opcionSeleccionada=="9092"){
					    capa.innerHTML="GESTION DE LA VENTA Y SERVICIO DE EVENTOS ";
					}else if(opcionSeleccionada=="9093"){
					    capa.innerHTML="ALGEBRA Y GEOMETRIA ";
					}else if(opcionSeleccionada=="9094"){
					    capa.innerHTML="INFORMATICA APLICADA A LAS ARTES ";
					}else if(opcionSeleccionada=="9095"){
					    capa.innerHTML="PROGRAMAS DE DISEÑO II ";
					}else if(opcionSeleccionada=="9096"){
					    capa.innerHTML="PROGRAMAS DE OFICINAS II ";
					}else if(opcionSeleccionada=="9097"){
					    capa.innerHTML="TALLER DE CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="9099"){
					    capa.innerHTML="CONTABILIDAD COMERCIAL ";
					}else if(opcionSeleccionada=="9100"){
					    capa.innerHTML="COMUNICACION Y DERECHOS LABORALES EN LA EMPRESA ";
					}else if(opcionSeleccionada=="9101"){
					    capa.innerHTML="CULTIVO DE PECES Y MOLUSCOS ";
					}else if(opcionSeleccionada=="9102"){
					    capa.innerHTML="PRIMEROS AUXILIOS, SEGURIDAD Y PREVENCION DE RIESGOS ";
					}else if(opcionSeleccionada=="9103"){
					    capa.innerHTML="CULTIVO DE ALGAS Y CRUSTACEOS ";
					}else if(opcionSeleccionada=="9104"){
					    capa.innerHTML="SIMBOLOS PATRIOS ";
					}else if(opcionSeleccionada=="9105"){
					    capa.innerHTML="PASTELERIA ";
					}else if(opcionSeleccionada=="9106"){
					    capa.innerHTML="ORGANIZACION DE EVENTOS ";
					}else if(opcionSeleccionada=="9107"){
					    capa.innerHTML="COMERCIALIZACION Y LEGISLACION ";
					}else if(opcionSeleccionada=="9108"){
					    capa.innerHTML="TECNICAS SECRETARIALES ";
					}else if(opcionSeleccionada=="9109"){
					    capa.innerHTML="CONTABILIDAD PUBLICA ";
					}else if(opcionSeleccionada=="9110"){
					    capa.innerHTML="LEGISLACION TRIBUTARIA II ";
					}else if(opcionSeleccionada=="9111"){
					    capa.innerHTML="LEGISLACION TRIBUTARIA I ";
					}else if(opcionSeleccionada=="9112"){
					    capa.innerHTML="ELECTRONEUMATICA ";
					}else if(opcionSeleccionada=="9113"){
					    capa.innerHTML="CONDUCCION ";
					}else if(opcionSeleccionada=="9114"){
					    capa.innerHTML="MECANIZADO ";
					}else if(opcionSeleccionada=="9115"){
					    capa.innerHTML="PROTECCION ELECTRICA ";
					}else if(opcionSeleccionada=="9116"){
					    capa.innerHTML="PROYECTO ELECTRICO II ";
					}else if(opcionSeleccionada=="9117"){
					    capa.innerHTML="PROYECTO ELECTRICO I ";
					}else if(opcionSeleccionada=="9118"){
					    capa.innerHTML="MAGNETISMO ";
					}else if(opcionSeleccionada=="9119"){
					    capa.innerHTML="LINEAS ELECTRICAS ";
					}else if(opcionSeleccionada=="9120"){
					    capa.innerHTML="AUTOEMPLEO II ";
					}else if(opcionSeleccionada=="9121"){
					    capa.innerHTML="GESTION ADMINISTRATIVA Y COMERCIAL ";
					}else if(opcionSeleccionada=="9122"){
					    capa.innerHTML="RESOLUCION PROBLEMAS TECNOLOGICOS ";
					}else if(opcionSeleccionada=="9123"){
					    capa.innerHTML="PROPEDEUTICO II ";
					}else if(opcionSeleccionada=="9124"){
					    capa.innerHTML="PROPEDEUTICO I ";
					}else if(opcionSeleccionada=="9125"){
					    capa.innerHTML="PINTURAS Y BARNICES ";
					}else if(opcionSeleccionada=="9126"){
					    capa.innerHTML="PUERTAS Y VENTANAS ";
					}else if(opcionSeleccionada=="9127"){
					    capa.innerHTML="PROYECTO II ";
					}else if(opcionSeleccionada=="9128"){
					    capa.innerHTML="INSTALACION DE REVESTIMIENTO ";
					}else if(opcionSeleccionada=="9129"){
					    capa.innerHTML="ELEMENTOS ESTRUCTURALES ";
					}else if(opcionSeleccionada=="9130"){
					    capa.innerHTML="PROYECTO I ";
					}else if(opcionSeleccionada=="9131"){
					    capa.innerHTML="AUTOEMPLEO I ";
					}else if(opcionSeleccionada=="9132"){
					    capa.innerHTML="MECANICA AVANZADA ";
					}else if(opcionSeleccionada=="9133"){
					    capa.innerHTML="GRANDES TEMAS Y  MOTIVOS DE LA LITERATURA DE OCCIDENTE ";
					}else if(opcionSeleccionada=="9134"){
					    capa.innerHTML="CONFLICTOS DEL  MUNDO  CONTEMPORANEO ";
					}else if(opcionSeleccionada=="9135"){
					    capa.innerHTML="MATEMATICA PRACTICA 1 ";
					}else if(opcionSeleccionada=="9136"){
					    capa.innerHTML="MATEMATICA PRACTICA 2 ";
					}else if(opcionSeleccionada=="9137"){
					    capa.innerHTML="INTRODUCCION AUTOMOTRIZ ";
					}else if(opcionSeleccionada=="9138"){
					    capa.innerHTML="TEORIA COMUNICACIONAL ";
					}else if(opcionSeleccionada=="9139"){
					    capa.innerHTML="MEDIO AMBIENTE ACUATICO ";
					}else if(opcionSeleccionada=="9140"){
					    capa.innerHTML="ENFERMEDADES DE PECES ";
					}else if(opcionSeleccionada=="9141"){
					    capa.innerHTML="ESTADISTICA APLICADA A PROCESOS INDUSTRIALES ";
					}else if(opcionSeleccionada=="9142"){
					    capa.innerHTML="CULTURA FISICA ";
					}else if(opcionSeleccionada=="9143"){
					    capa.innerHTML="NORMATIVA COMERCIAL TRIBUTARIA ";
					}else if(opcionSeleccionada=="9144"){
					    capa.innerHTML="ACTUALIDAD EN EL MUNDO CONTEMPORANEO ";
					}else if(opcionSeleccionada=="9145"){
					    capa.innerHTML="LOGISTICA DE DISTRIBUCION Y ABASTECIMIENTO. ";
					}else if(opcionSeleccionada=="9146"){
					    capa.innerHTML="ESPIRITU EMPRENDEDOR EN VENTAS ";
					}else if(opcionSeleccionada=="9147"){
					    capa.innerHTML="TRAFICO AEREO ";
					}else if(opcionSeleccionada=="9153"){
					    capa.innerHTML="EVALUACION DE PROYECTOS Y GESTION AGROPECUARIA ";
					}else if(opcionSeleccionada=="9154"){
					    capa.innerHTML="FRUTALES Y  VIÑAS ";
					}else if(opcionSeleccionada=="9155"){
					    capa.innerHTML="DERECHO INTERNACIONAL HUMANITARIO ";
					}else if(opcionSeleccionada=="9156"){
					    capa.innerHTML="DISEÑO INTEGRAL Y PUBLICIDAD CREATIVA ";
					}else if(opcionSeleccionada=="9157"){
					    capa.innerHTML="ARTE Y DISEÑO GRAFICO:RECURSOS PARA UNA COMUNICACION EFICAZ ";
					}else if(opcionSeleccionada=="9158"){
					    capa.innerHTML="OPERACION Y PROGRAMACION DE SISTEMAS DE CONTROL CON RELES PROGRAMABLES ";
					}else if(opcionSeleccionada=="9159"){
					    capa.innerHTML="HACIA EL MUNDO DE LA GRAFICA Y EL DIBUJO TECNICO ";
					}else if(opcionSeleccionada=="9160"){
					    capa.innerHTML="HACIA EL MUNDO DE LA ADMINISTRACION Y EL COMERCIO ";
					}else if(opcionSeleccionada=="9161"){
					    capa.innerHTML="HACIA EL MUNDO DE LA ENFERMERIA, PARVULOS Y ADULTOS MAYORES ";
					}else if(opcionSeleccionada=="9162"){
					    capa.innerHTML="HACIA EL MUNDO DE LOS SERVICIOS DE ALIMENTACION Y TURISMO ";
					}else if(opcionSeleccionada=="9163"){
					    capa.innerHTML="SACRAMENTAL ";
					}else if(opcionSeleccionada=="9164"){
					    capa.innerHTML="ESTUDIO RETROSPECTIVO DE LAS CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="9165"){
					    capa.innerHTML="CONTABILIDAD Y AUDITORIA ";
					}else if(opcionSeleccionada=="9166"){
					    capa.innerHTML="ALGEBRA SUPERIOR ";
					}else if(opcionSeleccionada=="9167"){
					    capa.innerHTML="APLICACION INTEGRADA DEL LENGUAJE 1 ";
					}else if(opcionSeleccionada=="9168"){
					    capa.innerHTML="APLICACION INTEGRADA DEL LENGUAJE 2 ";
					}else if(opcionSeleccionada=="9169"){
					    capa.innerHTML="INTEGRACION DE LA MATEMATICA 1 ";
					}else if(opcionSeleccionada=="9170"){
					    capa.innerHTML="INTEGRACION DE MATEMATICA 2 ";
					}else if(opcionSeleccionada=="9171"){
					    capa.innerHTML="LECTURA COMPRENSIVA Y VELOZ ";
					}else if(opcionSeleccionada=="9172"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DE LA CULTURA LOCAL I Y II     ";
					}else if(opcionSeleccionada=="9173"){
					    capa.innerHTML="ESTUDIO Y COMPRENSIN DE LA CULTURA LOCAL III Y IV  ";
					}else if(opcionSeleccionada=="9174"){
					    capa.innerHTML="TECNOLOGIA FRIGORIFICA ";
					}else if(opcionSeleccionada=="9175"){
					    capa.innerHTML="CELULA, GENOMA, ORGANISMO Y HOMEOSTASIS ";
					}else if(opcionSeleccionada=="9176"){
					    capa.innerHTML="ESTADISTICA PARA LA INVESTIGACION ";
					}else if(opcionSeleccionada=="9177"){
					    capa.innerHTML="INGLES SITUACIONAL VIVENCIAL ";
					}else if(opcionSeleccionada=="9178"){
					    capa.innerHTML="UNA MIRADA AL MUNDO MACRO Y MICRO DE LA FISICA ";
					}else if(opcionSeleccionada=="9179"){
					    capa.innerHTML="CONDICION FISICA ASOCIADA A LA SALUD Y EL TRABAJO ";
					}else if(opcionSeleccionada=="9180"){
					    capa.innerHTML="COMUNICACION LABORAL Y ETICA ";
					}else if(opcionSeleccionada=="9181"){
					    capa.innerHTML="ORATORIA, DEBATE Y LIDERAZGO ";
					}else if(opcionSeleccionada=="9182"){
					    capa.innerHTML="BUENAS PRACTICAS AGRICOLAS ";
					}else if(opcionSeleccionada=="9183"){
					    capa.innerHTML="CIENCIAS APLICADAS A LA ACUICULTURA ";
					}else if(opcionSeleccionada=="9184"){
					    capa.innerHTML="CULTIVO DE ALGAS Y MOLUSCOS ";
					}else if(opcionSeleccionada=="9185"){
					    capa.innerHTML="IDENTIFICACION, DIAGRAMACION Y ELABORACION DE LA FORMA IMPRESORA Y SEPARACION DEL COLOR DIGITAL ";
					}else if(opcionSeleccionada=="9186"){
					    capa.innerHTML="PREPARACION, MANTENIMIENTO Y MATERIALES DE LAS MAQUINAS GRAFICAS ";
					}else if(opcionSeleccionada=="9187"){
					    capa.innerHTML="ANTROPOLOGIA SOCIAL II ";
					}else if(opcionSeleccionada=="9188"){
					    capa.innerHTML="INTRODUCCION A LAS ESPECIALIDADES ";
					}else if(opcionSeleccionada=="9189"){
					    capa.innerHTML="NATACION Y SALVATAJE ";
					}else if(opcionSeleccionada=="9190"){
					    capa.innerHTML="TIPOS DE NAVES MERCANTES Y ESPECIALES ";
					}else if(opcionSeleccionada=="9191"){
					    capa.innerHTML="ESTIBA Y DESESTIBA DE NAVES MERCANTES Y ESPECIALES ";
					}else if(opcionSeleccionada=="9192"){
					    capa.innerHTML="ADMINISTRACION Y GESTION DE LA PRODUCCION ";
					}else if(opcionSeleccionada=="9193"){
					    capa.innerHTML="TALLER DE TECNOLOGIA ";
					}else if(opcionSeleccionada=="9194"){
					    capa.innerHTML="TALLER DE INTRODUCCION A LA MICROEMPRESA ";
					}else if(opcionSeleccionada=="9195"){
					    capa.innerHTML="PROYECTO SOCIAL Nº 3 ";
					}else if(opcionSeleccionada=="9196"){
					    capa.innerHTML="PROYECTO SOCIAL Nº 4 ";
					}else if(opcionSeleccionada=="9197"){
					    capa.innerHTML="INGLES COMUNICACIONAL I Y II ";
					}else if(opcionSeleccionada=="9198"){
					    capa.innerHTML="ACTIVIDADES DE INICIACION MUSICAL DE PARVULOS ";
					}else if(opcionSeleccionada=="9199"){
					    capa.innerHTML="CIENCIAS SOCIALES E INTRODUCCION AL DERECHO ";
					}else if(opcionSeleccionada=="9200"){
					    capa.innerHTML="NIVELACION LENGUA CASTELLANA ";
					}else if(opcionSeleccionada=="9201"){
					    capa.innerHTML="NIVELACION MATEMATICA ";
					}else if(opcionSeleccionada=="9202"){
					    capa.innerHTML="ESTUDIO Y COMPRENSION DE LA CULTURA LOCAL ";
					}else if(opcionSeleccionada=="9203"){
					    capa.innerHTML="ARTES MANUALES COMO HERRAMIENTAS DE APRENDIZAJE ";
					}else if(opcionSeleccionada=="9204"){
					    capa.innerHTML="ENFRENTANDO LA VIDA ";
					}else if(opcionSeleccionada=="9205"){
					    capa.innerHTML="TALLER PERSONAL DE CONTACTOS ";
					}else if(opcionSeleccionada=="9206"){
					    capa.innerHTML="TALLER DE TECNICAS APLICADAS EN ACTIVIDADES DE ASEO INSTITUCIONAL E INDUSTRIAL ";
					}else if(opcionSeleccionada=="9207"){
					    capa.innerHTML="TALLER TRATAMIENTO DE PRODUCTOS ALIMENTICIOS EN FRIO ";
					}else if(opcionSeleccionada=="9208"){
					    capa.innerHTML="TALLER DE MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="9209"){
					    capa.innerHTML="PROPAGACION VEGETAL EN AMBIENTE ESPECIAL ";
					}else if(opcionSeleccionada=="9210"){
					    capa.innerHTML="TALLER DE SENDERISMO Y ECOLOGIA ";
					}else if(opcionSeleccionada=="9211"){
					    capa.innerHTML="SISTEMA DE PRODUCCION ANIMAL ";
					}else if(opcionSeleccionada=="9212"){
					    capa.innerHTML="TALLER DE PLANTAS MEDICINALES ";
					}else if(opcionSeleccionada=="9213"){
					    capa.innerHTML="HIGIENE Y TECNOLOGIA DE LOS ALIMENTOS ";
					}else if(opcionSeleccionada=="9214"){
					    capa.innerHTML="MODULO DE GESTION PEQUEÑA EMPRESA Y TALLER DE SENDERISMO Y ECOLOGIA ";
					}else if(opcionSeleccionada=="9215"){
					    capa.innerHTML="ADMINISTRACION BASICA Y DE PERSONAL ";
					}else if(opcionSeleccionada=="9216"){
					    capa.innerHTML="INTRODUCCION A LA FORMACION DIFERENCIADA TECNICO PROFESIONAL ";
					}else if(opcionSeleccionada=="9217"){
					    capa.innerHTML="ALFABETIZACION DIGITAL ";
					}else if(opcionSeleccionada=="9218"){
					    capa.innerHTML="ACTIVIDADES EDUCATIVAS DE CARACTER INTERCULTURAL ";
					}else if(opcionSeleccionada=="9219"){
					    capa.innerHTML="LA MUSICA Y EL PARVULO ";
					}else if(opcionSeleccionada=="9220"){
					    capa.innerHTML="NECESIDADES EDUCATIVAS ESPECIALES EN EL PARVULO ";
					}else if(opcionSeleccionada=="9221"){
					    capa.innerHTML="INTERCULTURALIDAD Y DESARROLLO ";
					}else if(opcionSeleccionada=="9222"){
					    capa.innerHTML="COCINA MAPUCHE Y FUSION ";
					}else if(opcionSeleccionada=="9223"){
					    capa.innerHTML="TECNICAS DE PRESENTACION DE ALIMENTOS PARA MENU, CARTA Y BUFFET ";
					}else if(opcionSeleccionada=="9224"){
					    capa.innerHTML="TECNICAS BASICAS DE TRABAJO SOCIAL ";
					}else if(opcionSeleccionada=="9225"){
					    capa.innerHTML="MECANIZADO EN CONSTRUCCIONES METALICAS Y SOLDADURA ";
					}else if(opcionSeleccionada=="9226"){
					    capa.innerHTML="TALLER DE DESARROLLO EVOLUTIVO DEL PARVULO ";
					}else if(opcionSeleccionada=="9227"){
					    capa.innerHTML="DISCURSO Y FUNDAMENTOS DE RETORICA ";
					}else if(opcionSeleccionada=="9228"){
					    capa.innerHTML="ACERCANDONOS AL CONOCIMIENTO A TRAVES DE LA INFORMATICA ";
					}else if(opcionSeleccionada=="9229"){
					    capa.innerHTML="TALLER DE LECTO-ESCRITURA I ";
					}else if(opcionSeleccionada=="9230"){
					    capa.innerHTML="TALLER DE LECTO-ESCRITURA II ";
					}else if(opcionSeleccionada=="9231"){
					    capa.innerHTML="TALLER DE MATEMATICA APLICADA I ";
					}else if(opcionSeleccionada=="9232"){
					    capa.innerHTML="TALLER DE MATEMATICA APLICADA II ";
					}else if(opcionSeleccionada=="9233"){
					    capa.innerHTML="EDUCACION MATEMATICA I ";
					}else if(opcionSeleccionada=="9234"){
					    capa.innerHTML="EDUCACION MATEMATICA II ";
					}else if(opcionSeleccionada=="9235"){
					    capa.innerHTML="INTRODUCCION A LA EDIFICACION ";
					}else if(opcionSeleccionada=="9236"){
					    capa.innerHTML="TIPOS DE VIVIENDA Y ESTRUCTURAS. ";
					}else if(opcionSeleccionada=="9237"){
					    capa.innerHTML="ELABORACION DE ENTRADAS Y PLATOS PRINCIPALES. ";
					}else if(opcionSeleccionada=="9238"){
					    capa.innerHTML="PASTELERIA, REPOSTERIA Y PANADERIA. ";
					}else if(opcionSeleccionada=="9239"){
					    capa.innerHTML="ACTIVIDADES RECREATIVAS Y DE EXPRESION. ";
					}else if(opcionSeleccionada=="9240"){
					    capa.innerHTML="VESTUARIO FEMENINO. ";
					}else if(opcionSeleccionada=="9241"){
					    capa.innerHTML="ALIMENTACION, HIGIENE, VESTUARIO Y CUIDADOS DE ENFERMERIA. ";
					}else if(opcionSeleccionada=="9242"){
					    capa.innerHTML="SALUD, AUTONOMIA , PROGRAMAS SOCIALES Y RECREATIVOS PARA EL ADULTO MAYOR. ";
					}else if(opcionSeleccionada=="9243"){
					    capa.innerHTML="REDES DE APOYO A LA SALUD PROCEDIMIENTOS ADMINISTRATIVO  Y ATENCION A LA FAMILIA. ";
					}else if(opcionSeleccionada=="9244"){
					    capa.innerHTML="PLATOS TIPICOS NACIONALES E INTERNACIONALES, PREPARACION Y PRESENTACION DE SANDWICH Y PRODUCTOS DE COCTEL. ";
					}else if(opcionSeleccionada=="9245"){
						capa.innerHTML="GESTIONANDO LA CREACION , PRODUCCION Y COSTOS DE UNA PEQUEÑA EMPRESA. ";
					}else if(opcionSeleccionada=="9246"){
					    capa.innerHTML="INVESTIGANDO LOS MERCADOS EXTERNOS DE LA EMPRESA. ";
					}else if(opcionSeleccionada=="9247"){
					    capa.innerHTML="VESTUARIO MASCULINO ASISTIDO POR COMPUTADOR ";
					}else if(opcionSeleccionada=="9248"){
					    capa.innerHTML="TALLER DE FORMACION DUAL EN LA EMPRESA ";
					}else if(opcionSeleccionada=="9249"){
					    capa.innerHTML="ADMINISTRACION DE LA PRODUCCION, BODEGA Y ALMACENAJE ALIMENTOS ";
					}else if(opcionSeleccionada=="9250"){
					    capa.innerHTML="TECNICAS Y ELABORACIONES GASTRONOMICAS BASICAS  ";
					}else if(opcionSeleccionada=="9251"){
					    capa.innerHTML="TECNICAS DE PANADERIA, PASTELERIA  Y PREPARACION DE SANDWICH Y PRODUCTOS PARA COCTEL. ";
					}else if(opcionSeleccionada=="9252"){
					    capa.innerHTML="DESARROLLO PERSONAL PARA LA VIDA CIUDADANA Y LABORAL. ";
					}else if(opcionSeleccionada=="9253"){
					    capa.innerHTML="EXPLOTACION COMERCIAL DE FRUTALES ";
					}else if(opcionSeleccionada=="9254"){
					    capa.innerHTML="MANEJO TECNICO DE LA PRODUCCION VEGETAL ";
					}else if(opcionSeleccionada=="9255"){
					    capa.innerHTML="MERCADO Y CLIENTES ";
					}else if(opcionSeleccionada=="9256"){
					    capa.innerHTML="PEQUEÑA EMPRESA ";
					}else if(opcionSeleccionada=="9257"){
					    capa.innerHTML="GESTION FINANCIERA Y DE COSTOS ";
					}else if(opcionSeleccionada=="9258"){
					    capa.innerHTML="EL DISCURSO LITERARIO ";
					}else if(opcionSeleccionada=="9259"){
					    capa.innerHTML="COMUNICACION EN LA EMPRESA ";
					}else if(opcionSeleccionada=="9260"){
					    capa.innerHTML="APLICACIONES LABORALES ";
					}else if(opcionSeleccionada=="9261"){
					    capa.innerHTML="RELACIONES COMERCIALES   ";
					}else if(opcionSeleccionada=="9262"){
					    capa.innerHTML="PROCESOS DE COMUNICACION ";
					}else if(opcionSeleccionada=="9263"){
					    capa.innerHTML="PROCESOS CONTABLES ";
					}else if(opcionSeleccionada=="9264"){
					    capa.innerHTML="HISTORIA DE UN PUEBLO CREYENTE ";
					}else if(opcionSeleccionada=="9265"){
					    capa.innerHTML="CUESTIONES FUNDAMENTALES DE LA FE ";
					}else if(opcionSeleccionada=="9266"){
					    capa.innerHTML="TALLER DE EDIFICACION ";
					}else if(opcionSeleccionada=="9267"){
					    capa.innerHTML="TALLER DE INTRODUCCION A LA ACUICULTURA ";
					}else if(opcionSeleccionada=="9268"){
					    capa.innerHTML="TALLER DE HABILIDADES LINGUISTICAS ";
					}else if(opcionSeleccionada=="9269"){
					    capa.innerHTML="TALLER DE HABILIDADES LOGICO-MATEMATICAS ";
					}else if(opcionSeleccionada=="9270"){
					    capa.innerHTML="MORAL DEL AMOR Y DE LA VIDA ";
					}else if(opcionSeleccionada=="9271"){
					    capa.innerHTML="MORAL SOCIAL ";
					}else if(opcionSeleccionada=="9272"){
					    capa.innerHTML="TRAZADO, MOLDAJE Y CARPINTERIA DE FUNDACION ";
					}else if(opcionSeleccionada=="9273"){
					    capa.innerHTML="CULTIVO DE PECES Y PLANIFICACION DE LA PRODUCCION ";
					}else if(opcionSeleccionada=="9274"){
					    capa.innerHTML="CULTIVO DE ORG. ACUATICOS (ALGAS, CRUSTACEOS, MOLUSCOS) ";
					}else if(opcionSeleccionada=="9275"){
					    capa.innerHTML="SEGURIDAD, PREVENC. DE RIESGOS Y 1° AUXIL. EN ACUICULTURA ";
					}else if(opcionSeleccionada=="9276"){
					    capa.innerHTML="JUNTAS DE HORMIGONES Y ADITIVOS PARA MORTEROS ";
					}else if(opcionSeleccionada=="9277"){
					    capa.innerHTML="ENFIERRADURA ";
					}else if(opcionSeleccionada=="9278"){
					    capa.innerHTML="INGLES COMUNICACIONAL ";
					}else if(opcionSeleccionada=="9279"){
					    capa.innerHTML="BIOQUIMICA I ";
					}else if(opcionSeleccionada=="9280"){
					    capa.innerHTML="BIOQUIMICA II ";
					}else if(opcionSeleccionada=="9281"){
					    capa.innerHTML="AJUSTE Y REGULARIZACIONES ";
					}else if(opcionSeleccionada=="9282"){
					    capa.innerHTML="ESTADOS FINANCIEROS ";
					}else if(opcionSeleccionada=="9283"){
					    capa.innerHTML="GESTION DE ABASTECIMIENTO ";
					}else if(opcionSeleccionada=="9284"){
					    capa.innerHTML="GESTION DE CLIENTES ";
					}else if(opcionSeleccionada=="9285"){
					    capa.innerHTML="NORMATIVA COMERCIAL ";
					}else if(opcionSeleccionada=="9286"){
					    capa.innerHTML="NORMATIVA LABORAL ";
					}else if(opcionSeleccionada=="9287"){
					    capa.innerHTML="NORMATIVA TRIBUTARIA ";
					}else if(opcionSeleccionada=="9288"){
					    capa.innerHTML="REMUNERACIONES ";
					}else if(opcionSeleccionada=="9289"){
					    capa.innerHTML="PRINCIPIO DE BIOLOGIA CELULAR Y BIOQUIMICA ";
					}else if(opcionSeleccionada=="9290"){
					    capa.innerHTML="FISIOLOGIA Y ANATOMIA HUMANA ";
					}else if(opcionSeleccionada=="9291"){
					    capa.innerHTML="TRIBUTACION EMPRESARIAL ";
					}else if(opcionSeleccionada=="9292"){
					    capa.innerHTML="GESTION ADMINISTRATIVA DE PERSONAL ";
					}else if(opcionSeleccionada=="9293"){
					    capa.innerHTML="COMERCIO INTERNACIONAL E INVESTIGACION DE MERCADO ";
					}else if(opcionSeleccionada=="9294"){
					    capa.innerHTML="SISTEMA DE COSTO Y APROVSIONAMIENTO ";
					}else if(opcionSeleccionada=="9295"){
					    capa.innerHTML="TECNICAS DE EQUIPOS Y OPERACIONES DE MAQUINAS DE IMPRESIÓN Y POST IMPRESIÓN ";
					}else if(opcionSeleccionada=="9296"){
					    capa.innerHTML="GESTION DE LA PEQEUÑA EMPRESA, PREVENCION EN EL CUIDADO Y SEGURIDAD DEL MEDIO AMBIENTE ";
					}else if(opcionSeleccionada=="9297"){
					    capa.innerHTML="TECNICAS EN OFICINAS ";
					}else if(opcionSeleccionada=="9298"){
					    capa.innerHTML="INGLES-SERVICIOS DE ALIMENTACION COLECTIVA ";
					}else if(opcionSeleccionada=="9299"){
					    capa.innerHTML="BUSSINES ENGLISH ";
					}else if(opcionSeleccionada=="9300"){
					    capa.innerHTML="PRACTICA DE IDIOMA ";
					}else if(opcionSeleccionada=="9301"){
					    capa.innerHTML="DERECHO GENERAL ";
					}else if(opcionSeleccionada=="9302"){
					    capa.innerHTML="DERECHO PROCESAL ";
					}else if(opcionSeleccionada=="9303"){
					    capa.innerHTML="ADMINISTRACIÓN PUBLICA Y NOTARIAS ";
					}else if(opcionSeleccionada=="9304"){
					    capa.innerHTML="MODALIDADES EDUCATIVAS PARA EL TRABAJO CON PARVULO ";
					}else if(opcionSeleccionada=="9305"){
					    capa.innerHTML="CIENCIAS APLICADAS AL SERVICIO DE ALIMENTACION ";
					}else if(opcionSeleccionada=="9306"){
					    capa.innerHTML="INTRODUCCION AL SOFTWARE ";
					}else if(opcionSeleccionada=="9307"){
					    capa.innerHTML="DISEÑO ";
					}else if(opcionSeleccionada=="9308"){
					    capa.innerHTML="EXPRESIONES DE LENGUAJE, LENGUAJE Y SOCIEDAD ";
					}else if(opcionSeleccionada=="9309"){
					    capa.innerHTML="CONSTRUCCIONES LITERALES ";
					}else if(opcionSeleccionada=="9310"){
					    capa.innerHTML="COMUNIDAD NACIONAL: OCUPACION DEL TERRITORIO A LO LARGO DE NUESTRA HISTORIA ";
					}else if(opcionSeleccionada=="9311"){
					    capa.innerHTML="EL ARTE EN RELACION DEL HOMBRE CON EL MUNDO ";
					}else if(opcionSeleccionada=="9312"){
					    capa.innerHTML="QUIMICA ORGANICA E INDUSTRIAL ";
					}else if(opcionSeleccionada=="9313"){
					    capa.innerHTML="ORGANIZACION Y FUNCION DEL CUERPO HUMANO ";
					}else if(opcionSeleccionada=="9314"){
					    capa.innerHTML="SISTEMA HORMONAL, VARIABILIDAD Y ECOSISTEMA ";
					}else if(opcionSeleccionada=="9315"){
					    capa.innerHTML="ELEMENTOS BASICOS DE FÍSICA ";
					}else if(opcionSeleccionada=="9316"){					
					    capa.innerHTML="ALGEBRA Y MATEMATICA ELEMENTAL ";
					}else if(opcionSeleccionada=="9317"){
					    capa.innerHTML="MECANICA, ELECTRICIDAD Y ATOMOS ";
					}else if(opcionSeleccionada=="9318"){
					    capa.innerHTML="MATEMATICA III: GEOMETRIA EUCLIDIANA ";
					}else if(opcionSeleccionada=="9319"){
					    capa.innerHTML="FILOSOFIA I: EL SENTIDO DE LA EXISTENCIA ";
					}else if(opcionSeleccionada=="9320"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION: LITERATURA Y CINE ";
					}else if(opcionSeleccionada=="9321"){
					    capa.innerHTML="MUSICA I: MUSICA POPULAR Y SU EVOLUCION EN EL TIEMPO ";
					}else if(opcionSeleccionada=="9322"){
					    capa.innerHTML="CIENCIAS SOCIALES III: AMERICA LATINA EN EL SIGLO XX ";
					}else if(opcionSeleccionada=="9323"){
					    capa.innerHTML="CIENCIAS SOCIALES IV:  PROBLEMAS DEL MUNDO ACTUAL ";
					}else if(opcionSeleccionada=="9324"){
					    capa.innerHTML="ARTE II: COMO REALIZAR UN CORTO ";
					}else if(opcionSeleccionada=="9325"){
					    capa.innerHTML="ARTE III: APRECIACION ESTETICA DEL CINE ";
					}else if(opcionSeleccionada=="9326"){
					    capa.innerHTML="ARTE I: DISEÑO            ";
					}else if(opcionSeleccionada=="9327"){
					    capa.innerHTML="INTRODUCCION AL PLAN DIFERENCIADO ";
					}else if(opcionSeleccionada=="9328"){
					    capa.innerHTML="INGLES: MODULO VOCACIONAL ";
					}else if(opcionSeleccionada=="9329"){
					    capa.innerHTML="FILOSOFIA Y DESARROLLO COGNITIVO ";
					}else if(opcionSeleccionada=="9330"){
					    capa.innerHTML="DIBUJO, GRABADO, PINTURA, ESCULTURA, INSTALACION ";
					}else if(opcionSeleccionada=="9331"){
					    capa.innerHTML="PLANIFICACIÓN Y GESTIÓN DE LA PEQUEÑA EMPRESA ";
					}else if(opcionSeleccionada=="9332"){
					    capa.innerHTML="MATERIAL DIDÁCTICO Y ACTIVIDADES CON PÁRVULOS Y SUS FAMILIAS ";
					}else if(opcionSeleccionada=="9333"){
					    capa.innerHTML="SALUD, AUTONOMÍA, REDES DE APOYO A LA SALUD Y PROCEDIMIENTOS ADMINISTRATIVOS EN    LA ATENCIÓN DEL ADULTO MAYOR ";
					}else if(opcionSeleccionada=="9334"){
					    capa.innerHTML="APOYO EMOCIONAL, SOCIAL, ESPIRITUAL Y ATENCIÓN A LA FAMILIA ";
					}else if(opcionSeleccionada=="9335"){
					    capa.innerHTML="ALIMENTOS, METABOLISMO Y ORGANISMO ";
					}else if(opcionSeleccionada=="9336"){
					    capa.innerHTML="ARTES VISUALES II ";
					}else if(opcionSeleccionada=="9337"){
					    capa.innerHTML="ARTES MUSICALES II ";
					}else if(opcionSeleccionada=="9338"){
					    capa.innerHTML="ARTES TEATRALES II ";
					}else if(opcionSeleccionada=="9340"){
					    capa.innerHTML="Estudio de Negocios ";
					}else if(opcionSeleccionada=="9341"){
					    capa.innerHTML="HACIA EL MUNDO TECNICO PROFESIONAL ";
					}else if(opcionSeleccionada=="9342"){
					    capa.innerHTML="APRENDO A PENSAR COMO PROFESIONAL ";
					}else if(opcionSeleccionada=="9343"){
					    capa.innerHTML="COMPETENCIAS PERSONALES PARA EL TRABAJO ";
					}else if(opcionSeleccionada=="9344"){
					    capa.innerHTML="DEPROTE, CULTURA Y EMPRESA ";
					}else if(opcionSeleccionada=="9345"){
					    capa.innerHTML="SISTEMA PRODUCCION VEGETAL Y AGROECOLGIA ";
					}else if(opcionSeleccionada=="9346"){
					    capa.innerHTML="ACTIVIDADES MUSICALES DESDE LA PERSPECTIVA MAPUCHE ";
					}else if(opcionSeleccionada=="9347"){
					    capa.innerHTML="ACTIVIDADES RECREATIVAS Y DE EXPRESION CON PARVULOS ";
					}else if(opcionSeleccionada=="9348"){
					    capa.innerHTML="COSMOVISION Y LENGUA MAPUCHE-HUILLICHE ";
					}else if(opcionSeleccionada=="9349"){
					    capa.innerHTML="ECONOMIA Y SOCIEDAD ";
					}else if(opcionSeleccionada=="9350"){
					    capa.innerHTML="INGLES TECNICO EN LA GESTION ADMINISTRATIVA I ";
					}else if(opcionSeleccionada=="9351"){
					    capa.innerHTML="INGLES TECNICO EN LA GESTION ADMINISTRATIVA II ";
					}else if(opcionSeleccionada=="9352"){
					    capa.innerHTML="MANTENCION Y EVALUACION DE RIEGO TECNIFICADO ";
					}else if(opcionSeleccionada=="9353"){
					    capa.innerHTML="ORIENTACION A LA GESTION JURIDICA ADMINISTRATIVA ";
					}else if(opcionSeleccionada=="9354"){
					    capa.innerHTML="PREVENCION DE RIESGOS Y PRIMEROS AUXILIOS TURISMO CULTURAL 	EJECUCION DE EVENTOS ";
					}else if(opcionSeleccionada=="9355"){
					    capa.innerHTML="TURISMO ALTERNATIVO ";
					}else if(opcionSeleccionada=="9356"){
					    capa.innerHTML="TURISMO ALTERNATIVO ";
					}else if(opcionSeleccionada=="9357"){
					    capa.innerHTML="WIÑON MAPU ";
					}else if(opcionSeleccionada=="9358"){
					    capa.innerHTML="TALLERES LABORALES ";
					}else if(opcionSeleccionada=="9359"){
					    capa.innerHTML="HISTORIA POLITICA Y CONSTITUCIONAL DE CHILE ";
					}else if(opcionSeleccionada=="9360"){
					    capa.innerHTML="PROFUNDIZANDO LA QUIMICA ";
					}else if(opcionSeleccionada=="9361"){
					    capa.innerHTML="ANIMACION DIGITAL ";
					}else if(opcionSeleccionada=="9362"){
					    capa.innerHTML="AMERICA LATINA Y EL CARIBE Y SUS RELACIONES CON ESTADOS UNIDOS ";
					}else if(opcionSeleccionada=="9363"){
					    capa.innerHTML="TECNICAS BASICAS DE BODEGA ";
					}else if(opcionSeleccionada=="9364"){
					    capa.innerHTML="ARTE Y CULTURA ANDINA    ";
					}else if(opcionSeleccionada=="9365"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="9366"){
					    capa.innerHTML="CIENCIAS SOCIALES APLICADAS AL ESTUDIO DEL DESARROLLO ECONOMICO DE CHILE ";
					}else if(opcionSeleccionada=="9367"){
					    capa.innerHTML="ARTE Y CULTURA ANDINA    ";
					}else if(opcionSeleccionada=="9368"){
					    capa.innerHTML="GESTION DEL AGROECOSISTEMA Y PREPARACION EVALUACION DE PROYECTOS AGROPECUARIOS ";
					}else if(opcionSeleccionada=="9369"){
					    capa.innerHTML="HISTORIA Y APRECIACION MUSICAL ";
					}else if(opcionSeleccionada=="9370"){
					    capa.innerHTML="LECTURA MUSICAL ";
					}else if(opcionSeleccionada=="9371"){
					    capa.innerHTML="ACTIVIDADES DE DEPORTE Y RECREACION ";
					}else if(opcionSeleccionada=="9372"){
					    capa.innerHTML="LINEAS DE PROCESO DE PRODUCTOS ACUICOLAS ";
					}else if(opcionSeleccionada=="9373"){
					    capa.innerHTML="COMERCIALIZACION DE PRODUCTOS ";
					}else if(opcionSeleccionada=="9374"){
					    capa.innerHTML="EMPRENDIMIENTO ";
					}else if(opcionSeleccionada=="9375"){
					    capa.innerHTML="LENGUA Y CULTURA AYMARA ";
					}else if(opcionSeleccionada=="9376"){
					    capa.innerHTML="COMPUTACION EN COMUNIDAD ";
					}else if(opcionSeleccionada=="9377"){
					    capa.innerHTML="MUSICA DE LOS ANDES ";
					}else if(opcionSeleccionada=="9378"){
					    capa.innerHTML="PRODUCCION DE EVENTOS ";
					}else if(opcionSeleccionada=="9379"){
					    capa.innerHTML="TECNICAS GASTRONOMICAS AVANZADAS, CARTA BUFFET Y SERVICIOS DE COMEDORES ";
					}else if(opcionSeleccionada=="9380"){
					    capa.innerHTML="EDUCACION PARA LA DEMOCRACIA Y RELACIONES INTERNACIONALES ";
					}else if(opcionSeleccionada=="9381"){
					    capa.innerHTML="GLOBALIZACION E HISTORIA LATINOAMERICANA ";
					}else if(opcionSeleccionada=="9382"){
					    capa.innerHTML="LABORATORIO TECNICO DE VENTAS ";
					}else if(opcionSeleccionada=="9383"){
					    capa.innerHTML="EMPRESA Y GESTION ";
					}else if(opcionSeleccionada=="9384"){
					    capa.innerHTML="OPERACIÓN DE SOFTWARE ";
					}else if(opcionSeleccionada=="9385"){
					    capa.innerHTML="DIAGRAMACION ";
					}else if(opcionSeleccionada=="9386"){
					    capa.innerHTML="REDES Y HARDWARE ";
					}else if(opcionSeleccionada=="9387"){
					    capa.innerHTML="LABORATORIO DE MICROCOMPUTADORES ";
					}else if(opcionSeleccionada=="9388"){
					    capa.innerHTML="EXPRESION Y RECREACION PARVULARIA ";
					}else if(opcionSeleccionada=="9389"){
					    capa.innerHTML="ALIMENTACION Y SALUD ";
					}else if(opcionSeleccionada=="9390"){
					    capa.innerHTML="ACTIVIDADES EDUCATIVAS CON PARVULOS ";
					}else if(opcionSeleccionada=="9391"){
					    capa.innerHTML="ACTIVIDAD MUSICAL CON GUITARRA ";
					}else if(opcionSeleccionada=="9392"){
					    capa.innerHTML="ENGLISH FOR TOURISM I ";
					}else if(opcionSeleccionada=="9393"){
					    capa.innerHTML="GESTION ADMINISTRATIVA DEL TURISMO ";
					}else if(opcionSeleccionada=="9394"){
					    capa.innerHTML="INTRODUCCION AL ESTUDIO DEL FENOMENO TURISTICO ";
					}else if(opcionSeleccionada=="9395"){
					    capa.innerHTML="CONTROLADORES LOGICOS PROGRAMABLES P.L.C . SISTEMAS ELECTRONICOS DIGITALES. ";
					}else if(opcionSeleccionada=="9396"){
					    capa.innerHTML="REDES DE CABLEADO, MONTAJE Y CONSTRUCCIONES ELECTRICAS ";
					}else if(opcionSeleccionada=="9397"){
					    capa.innerHTML="DISEÑO, OPERACION Y MANTENIMIENTO DE SISTEMAS DE CONTROL ELECTRICO. MANTENIMIENTO Y OPERACION DE MAQUINAS Y EQUIPOS ELECTRICOS ";
					}else if(opcionSeleccionada=="9398"){
					    capa.innerHTML="EXPLORACION TECNOLOGICA PERTINENTE A LA ACUICULTURA ";
					}else if(opcionSeleccionada=="9399"){
					    capa.innerHTML="EXPLORACION TECNOLOGICA PERTINENTE A LA ELECTRONICA ";
					}else if(opcionSeleccionada=="9400"){
					    capa.innerHTML="EXPLORACION TECNOLOGICA PERTINENTE AL TURISMO ";
					}else if(opcionSeleccionada=="9401"){
					    capa.innerHTML="TRATAMIENTO DE PROTECCION ";					
					}else if(opcionSeleccionada=="9402"){
					    capa.innerHTML="CULTURAS REGIONALES TIRANEÑAS ";
					}else if(opcionSeleccionada=="9403"){
					    capa.innerHTML="NUESTRAS RAICES ";
					}else if(opcionSeleccionada=="9404"){
					    capa.innerHTML="TRANSMISION CULTURAL ";
					}else if(opcionSeleccionada=="9405"){
					    capa.innerHTML="MUSICA Y DANZA ANDINA ";
					}else if(opcionSeleccionada=="9406"){
					    capa.innerHTML="INGLES COMUNICACIONAL I ";
					}else if(opcionSeleccionada=="9407"){
					    capa.innerHTML="INGLES COMUNICACIONAL II ";
					}else if(opcionSeleccionada=="9408"){
					    capa.innerHTML="SISTEMAS INFORMATICOS PARA ADMINISTRACION MODERNA. ";
					}else if(opcionSeleccionada=="9409"){
					    capa.innerHTML="NORMAS TRIBUTARIAS ESPECIALES. ";
					}else if(opcionSeleccionada=="9410"){
					    capa.innerHTML="ENGLISH IN THE COMPANY ";
					}else if(opcionSeleccionada=="9411"){
					    capa.innerHTML="ENGLISH AND BUSINESS ";
					}else if(opcionSeleccionada=="9412"){
					    capa.innerHTML="ATENCION A LA DIVERSIDAD DE PARVULOS CON NECESIDADES EDUCATIVAS ESPECIALES ";
					}else if(opcionSeleccionada=="9413"){
					    capa.innerHTML="ANALISIS EXPERENCIAL  ";
					}else if(opcionSeleccionada=="9414"){
					    capa.innerHTML="KIMELDUNGUN ";
					}else if(opcionSeleccionada=="9415"){
					    capa.innerHTML="DERECHO, PERSONA Y SOCIEDAD ";
					}else if(opcionSeleccionada=="9416"){
					    capa.innerHTML="HISTORIA, CINE : UN NUEVO ENFOQUE AL PASADO ";
					}else if(opcionSeleccionada=="9417"){
					    capa.innerHTML="ANTROPOLOGIA FILOSOFICA : EL ROL DEL JUEGO ";
					}else if(opcionSeleccionada=="9418"){
					    capa.innerHTML="REDACCION JURIDICA Y FUNCIONAL ";
					}else if(opcionSeleccionada=="9419"){
					    capa.innerHTML="SERVICIO DE ALIMENTACION COLECTIVA MODALIDAD TRADICIONAL ";
					}else if(opcionSeleccionada=="9420"){
					    capa.innerHTML="SERVICIO DE ALIMENTACION COLECTIVA MODALIDAD DUAL ";
					}else if(opcionSeleccionada=="9421"){
					    capa.innerHTML="ATENCION SOCIAL Y RECREATIVA ";
					}else if(opcionSeleccionada=="9422"){
					    capa.innerHTML="ATENCION DE ENFERMERIA ";
					}else if(opcionSeleccionada=="9423"){
					    capa.innerHTML="CIRCUITOS ELECTRICOS Y ELECTRONICOS DE SISTEMAS AUXILIARES Y MANTENIMIENTO DE SISTEMAS DE ARRANQUE, CARGA, SEGURIDAD Y CONFORT. ";
					}else if(opcionSeleccionada=="9424"){
					    capa.innerHTML="INDUCCION DUAL ";
					}else if(opcionSeleccionada=="9425"){
					    capa.innerHTML="INDUSTRIALIZACION DE ALIMENTOS ";
					}else if(opcionSeleccionada=="9426"){
					    capa.innerHTML="SEGURIDAD EN LAS INSTALACIONES DE TELECOMUNICACIONES ";
					}else if(opcionSeleccionada=="9427"){
					    capa.innerHTML="ELECTRONICA ANALOGICA ";
					}else if(opcionSeleccionada=="9428"){
					    capa.innerHTML="INSTALACIONES DE RADIO Y TELEVISION ";
					}else if(opcionSeleccionada=="9429"){
					    capa.innerHTML="INSTALACIONES DE TELEFONIA ";
					}else if(opcionSeleccionada=="9430"){
					    capa.innerHTML="REDES LOCALES DE DATOS ";
					}else if(opcionSeleccionada=="9431"){
					    capa.innerHTML="EQUIPOS INFORMATICOS Y SERVICIOS DE DATOS EN EL AMBITO DOMESTICO ";
					}else if(opcionSeleccionada=="9432"){
					    capa.innerHTML="INSTALACIONES BASICAS ";
					}else if(opcionSeleccionada=="9433"){
					    capa.innerHTML="TRANSVERSALES DEL AREA ";
					}else if(opcionSeleccionada=="9434"){
					    capa.innerHTML="DESARROLLO DE LA CULTURA JUVENIL ";
					}else if(opcionSeleccionada=="9435"){
					    capa.innerHTML="FILOSOFIA DEL MUNDO RURAL ";
					}else if(opcionSeleccionada=="9436"){
					    capa.innerHTML="GESTION DE LA EMPRESA AGROPECUARIA ";
					}else if(opcionSeleccionada=="9437"){
					    capa.innerHTML="RESPONSABILIDAD SOCIAL Y MUNDO LABORAL ";
					}else if(opcionSeleccionada=="9438"){
					    capa.innerHTML="TALLER DE DESARROLLO DE LA EXPRESION ORAL Y ESCRITA ";
					}else if(opcionSeleccionada=="9439"){
					    capa.innerHTML="NOCIONES BASICAS DE ORGANIZACION Y MANEJO DE UNA OFICIAN ";
					}else if(opcionSeleccionada=="9440"){
					    capa.innerHTML="MORAL Y VALORICA ";
					}else if(opcionSeleccionada=="9441"){
					    capa.innerHTML="EVOLUCION DEL PENSAMIENTO CONTEMPORANEO ";
					}else if(opcionSeleccionada=="9442"){
					    capa.innerHTML="ESPAÑOL A1 NIVEL SUPERIOR ";
					}else if(opcionSeleccionada=="9443"){
					    capa.innerHTML="INGLES B NIVEL MEDIO ";
					}else if(opcionSeleccionada=="9444"){
					    capa.innerHTML="METODOS MATEMATICOS NIVEL MEDIO ";
					}else if(opcionSeleccionada=="9445"){
					    capa.innerHTML="HISTORIA NIVEL MEDIO ";
					}else if(opcionSeleccionada=="9446"){
					    capa.innerHTML="BIOLOGIA NIVEL SUPERIOR ";
					}else if(opcionSeleccionada=="9447"){
					    capa.innerHTML="RELIGION (ETICA) ";
					}else if(opcionSeleccionada=="9448"){
					    capa.innerHTML="ECONOMIA NIVEL SUPERIOR ";
					}else if(opcionSeleccionada=="9449"){
					    capa.innerHTML="FISICA NIVEL SUPERIOR ";
					}else if(opcionSeleccionada=="9450"){
					    capa.innerHTML="QUIMICA NIVEL MEDIO ";
					}else if(opcionSeleccionada=="9451"){
					    capa.innerHTML="ARTE Y DISEÑO NIVEL MEDIO ";
					}else if(opcionSeleccionada=="9452"){
					    capa.innerHTML="FILOSOFIA: PROBLEMATICAS DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="9453"){
					    capa.innerHTML="CINE Y TEATRO ";
					}else if(opcionSeleccionada=="9454"){
					    capa.innerHTML="CIENCIAS SOCIALES: ECONOMIA ";
					}else if(opcionSeleccionada=="9455"){
					    capa.innerHTML="LITERATURA VEHICULO DE COMUNICACION Y AFECTIVIDAD. ";
					}else if(opcionSeleccionada=="9456"){
					    capa.innerHTML="MEDIOAMBIENTE Y SOCIEDAD ";
					}else if(opcionSeleccionada=="9457"){
					    capa.innerHTML="MATEMATICA Y SUS APLICACIONES ";
					}else if(opcionSeleccionada=="9458"){
					    capa.innerHTML="PUBLICIDAD Y DISEÑO ";
					}else if(opcionSeleccionada=="9459"){
					    capa.innerHTML="GEOGRAFIA: ORGANIZACION DEL ESPACIO MUNDIAL. ";
					}else if(opcionSeleccionada=="9460"){
					    capa.innerHTML="FILOSOFIA: PROBLEMATICAS DEL CONOCIMIENTO II ";
					}else if(opcionSeleccionada=="9461"){
					    capa.innerHTML="CINE Y TEATRO II ";
					}else if(opcionSeleccionada=="9462"){
					    capa.innerHTML="CIENCIAS SOCIALES: ECONOMIA ";
					}else if(opcionSeleccionada=="9463"){
					    capa.innerHTML="LITERATURA VEHICULO PARA LA TOLERANCIA Y EL RESPETO ";
					}else if(opcionSeleccionada=="9464"){
					    capa.innerHTML="MEDIOAMBIENTE Y LOS DESAFIOS DEL FUTURO ";
					}else if(opcionSeleccionada=="9465"){
					    capa.innerHTML="MATEMATICA Y SUS APLICACIONES II ";
					}else if(opcionSeleccionada=="9466"){
					    capa.innerHTML="FISICA: TERMODINAMICA Y NOCIONES DE RELATIVIDAD. ";
					}else if(opcionSeleccionada=="9467"){
					    capa.innerHTML="BIOLOGIA: CELULA, GENOMA Y ORGANISMO II ";
					}else if(opcionSeleccionada=="9468"){
					    capa.innerHTML="BIOLOGIA: EVOLUCION, ECOLOGIA Y AMBIENTE II ";
					}else if(opcionSeleccionada=="9469"){
					    capa.innerHTML="ARTES VISUALES:GRAFICA, PINTURA Y ESCULTURA II ";
					}else if(opcionSeleccionada=="9470"){
					    capa.innerHTML="PUBLICIDAD Y DISEÑO II ";
					}else if(opcionSeleccionada=="9471"){
					    capa.innerHTML="TALLER DE PRODUCTOS DE LA MADERA ";
					}else if(opcionSeleccionada=="9472"){
					    capa.innerHTML="DESARROLLO DE LA PSICOMOTRICIDAD ";
					}else if(opcionSeleccionada=="9473"){
					    capa.innerHTML="PREPARACION DE ALIMENTOS PARA MENU, CARTA Y BUFETTE ";
					}else if(opcionSeleccionada=="9474"){
					    capa.innerHTML="ACTIVACION DE LA INTELIGENCIA ";
					}else if(opcionSeleccionada=="9475"){
					    capa.innerHTML="INVESTIGACION CIENTIFICA 1 ";
					}else if(opcionSeleccionada=="9476"){
					    capa.innerHTML="GEOMETRIA 1 ";
					}else if(opcionSeleccionada=="9477"){
					    capa.innerHTML="INVESTIGACION CIENTIFICA 2 ";
					}else if(opcionSeleccionada=="9478"){
					    capa.innerHTML="GEOMETRIA 2 ";
					}else if(opcionSeleccionada=="9479"){
					    capa.innerHTML="FRANCES B ";
					}else if(opcionSeleccionada=="9480"){
					    capa.innerHTML="INTERPRETACION DE PLANOS DE EDIFICACION ";
					}else if(opcionSeleccionada=="9481"){
					    capa.innerHTML="ESTUDIO DE COSTOS Y RESULTADOS ";
					}else if(opcionSeleccionada=="9482"){
					    capa.innerHTML="FILOSOFIA : PERSONA, PERSONALIDAD Y CUIDADO DE SI ";
					}else if(opcionSeleccionada=="9483"){
					    capa.innerHTML="FILOSOFIA Y METODOLOGIA DE LA INVESTIGACION CIENTIFICA ";
					}else if(opcionSeleccionada=="9484"){
					    capa.innerHTML="ESTRUCTURA Y PROCESOS VITALES EN SERES VIVOS ";
					}else if(opcionSeleccionada=="9485"){
					    capa.innerHTML="VIAJEMOS POR EL MUNDO ";
					}else if(opcionSeleccionada=="9486"){
					    capa.innerHTML="DISEÑO GRAFICO PROYECTUAL ";
					}else if(opcionSeleccionada=="9487"){
					    capa.innerHTML="PRODUCCION DE OBJETOS TECNOLOGICAMENTE DECORATIVOS ";
					}else if(opcionSeleccionada=="9488"){
					    capa.innerHTML="DISEÑO Y AFICHE PUBLICITARIO ";
					}else if(opcionSeleccionada=="9489"){
					    capa.innerHTML="SISTEMAS ELECTRONICOS DE CONTROL DE POTENCIA Y DIGITALES ";
					}else if(opcionSeleccionada=="9490"){
					    capa.innerHTML="ARGUMENTACION Y DEBATE ";
					}else if(opcionSeleccionada=="9491"){
					    capa.innerHTML="HISTORIA ALEMANA ";
					}else if(opcionSeleccionada=="9492"){
					    capa.innerHTML="DESARROLLO DE HABILIDADES COGNITIVAS EN MATEMATICA ";
					}else if(opcionSeleccionada=="9493"){
					    capa.innerHTML="USO DEL LENGUAJE Y CAPACIDAD DE EXPRESION ";
					}else if(opcionSeleccionada=="9494"){
					    capa.innerHTML="INTRODUCCION A LA PLANIFICACION ESTRATEGICA ";
					}else if(opcionSeleccionada=="9495"){
					    capa.innerHTML="LENGUAJE DE SEÑAS ";
					}else if(opcionSeleccionada=="9496"){
					    capa.innerHTML="AUXILIAR EN PASTELERIA Y BANQUETERIA ";
					}else if(opcionSeleccionada=="9497"){
					    capa.innerHTML="GESTION DE COMPRAVENTA Y NORMATIVA TRIBUTARIA ";
					}else if(opcionSeleccionada=="9498"){
					    capa.innerHTML="GESTION DE MARKETING Y COMERCIO EXTERIOR ";
					}else if(opcionSeleccionada=="9499"){
					    capa.innerHTML="TECNICAS DE VENTAS EN ATENCION AL CLIENTE ";
					}else if(opcionSeleccionada=="9500"){
					    capa.innerHTML="SERVICIO Y COMUNICACION EN ATENCION AL CLIENTE ";
					}else if(opcionSeleccionada=="9501"){
					    capa.innerHTML="GESTION EN RECURSOS HUMANOS Y COMPRAVENTA ";
					}else if(opcionSeleccionada=="50096"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50097"){
					    capa.innerHTML=" ";
					}else if(opcionSeleccionada=="50098"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50099"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50100"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50101"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50102"){
					    capa.innerHTML=" ";
					}else if(opcionSeleccionada=="50103"){
					    capa.innerHTML="Chino ";
					}else if(opcionSeleccionada=="50104"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50105"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50106"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50107"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50117"){
					    capa.innerHTML="TALLER DE ARTES ";
					}else if(opcionSeleccionada=="50108"){
					    capa.innerHTML="TALLER DE EDUCACIÓN MUSICAL ";
					}else if(opcionSeleccionada=="50109"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50110"){
					    capa.innerHTML="DACTILOGRAFIA ";
					}else if(opcionSeleccionada=="50111"){
					    capa.innerHTML="COMERCIALIZACION ";
					}else if(opcionSeleccionada=="50112"){
					    capa.innerHTML="R. COMERCIAL ";
					}else if(opcionSeleccionada=="50113"){
					    capa.innerHTML="DACTILOGRAFIA ";
					}else if(opcionSeleccionada=="50114"){
					    capa.innerHTML="COMERCIALIZACION ";
					}else if(opcionSeleccionada=="50115"){
					    capa.innerHTML="R. COMERCIAL ";
					}else if(opcionSeleccionada=="50116"){
					    capa.innerHTML="FISICA ";
					}else if(opcionSeleccionada=="50118"){
					    capa.innerHTML="ARTESANIA ";
					}else if(opcionSeleccionada=="50119"){
					    capa.innerHTML="TALLER DE ARTESANIA ";
					}else if(opcionSeleccionada=="50120"){
					    capa.innerHTML="TALLER DE ECOLOGIA ";
					}else if(opcionSeleccionada=="50121"){
					    capa.innerHTML="TALLER DE INGLES ";
					}else if(opcionSeleccionada=="50122"){
					    capa.innerHTML="TALLER DE COMPUTACION ";
					}else if(opcionSeleccionada=="50123"){
					    capa.innerHTML="TALLER DE ECOLOGIA ";
					}else if(opcionSeleccionada=="50124"){
					    capa.innerHTML="TALLER DE COMPUTACION ";
					}else if(opcionSeleccionada=="50125"){
					    capa.innerHTML="TALLER DE INGLES ";
					}else if(opcionSeleccionada=="50126"){
					    capa.innerHTML="TALLER DE ARTESANIA ";
					}else if(opcionSeleccionada=="50127"){
					    capa.innerHTML="MATEMATICA ENTRETENIDA ";
					}else if(opcionSeleccionada=="50128"){
					    capa.innerHTML="DEPORTE Y RECREACION ";
					}else if(opcionSeleccionada=="50129"){
					    capa.innerHTML="MATEMATICA ENTRETENIDA ";
					}else if(opcionSeleccionada=="50130"){
					    capa.innerHTML="DEPORTES Y RECREACION ";
					}else if(opcionSeleccionada=="50131"){
					    capa.innerHTML=" ";
					}else if(opcionSeleccionada=="50132"){
					    capa.innerHTML="EDUCACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="50133"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50134"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50135"){
					    capa.innerHTML="TALLER TEATRO ";
					}else if(opcionSeleccionada=="50136"){
					    capa.innerHTML="tEATRO ";
					}else if(opcionSeleccionada=="50137"){
					    capa.innerHTML="MUSICA ";
					}else if(opcionSeleccionada=="50138"){
					    capa.innerHTML="MUSICA ";
					}else if(opcionSeleccionada=="50139"){
					    capa.innerHTML="Musica ";
					}else if(opcionSeleccionada=="50140"){
					    capa.innerHTML="MUSICA ";
					}else if(opcionSeleccionada=="50141"){
					    capa.innerHTML="Cuaderno dual ";
					}else if(opcionSeleccionada=="50142"){
					    capa.innerHTML="Cuaderno dual ";
					}else if(opcionSeleccionada=="50143"){
					    capa.innerHTML="CUADERNO DUAL (30%) ";
					}else if(opcionSeleccionada=="50144"){
					    capa.innerHTML="CUADERNO DUAL (30%) ";
					}else if(opcionSeleccionada=="50145"){
					    capa.innerHTML=" ";
					}else if(opcionSeleccionada=="50146"){
					    capa.innerHTML="INFORMATICA Y COMPUTACION ";
					}else if(opcionSeleccionada=="50147"){
					    capa.innerHTML="INFORMATICA Y COMPUTACION ";
					}else if(opcionSeleccionada=="50148"){
					    capa.innerHTML="ELECTIVO QUIMICA ";
					}else if(opcionSeleccionada=="50149"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50150"){
					    capa.innerHTML="Taller de Física ";
					}else if(opcionSeleccionada=="50151"){
					    capa.innerHTML="TALLER ARTISTICO ";
					}else if(opcionSeleccionada=="50152"){
					    capa.innerHTML="SASTRE ";
					}else if(opcionSeleccionada=="50153"){
					    capa.innerHTML="IDIOMA EXTRANJERO CHINO MANDARIN ";
					}else if(opcionSeleccionada=="50154"){
					    capa.innerHTML="Informatica y Computación ";
					}else if(opcionSeleccionada=="50155"){
					    capa.innerHTML="Musica ";
					}else if(opcionSeleccionada=="50156"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION ";
					}else if(opcionSeleccionada=="50157"){
					    capa.innerHTML="LENGUAJE Y COMUNICACION ";
					}else if(opcionSeleccionada=="50158"){
					    capa.innerHTML="288 ";
					}else if(opcionSeleccionada=="50159"){
					    capa.innerHTML="ARTES VISUALES ";
					}else if(opcionSeleccionada=="50160"){
					    capa.innerHTML="TALLER DE COMPUTACION ";
					}else if(opcionSeleccionada=="50161"){
					    capa.innerHTML="TALLER DE COMPUTACION ";
					}else if(opcionSeleccionada=="50162"){
					    capa.innerHTML="ARTES VISUALES ";
					}else if(opcionSeleccionada=="9503"){
					    capa.innerHTML="CONVIVENCIA SOCIAL ";
					}else if(opcionSeleccionada=="9504"){
					    capa.innerHTML="CONSUMO Y CALIDAD DE VIDA ";
					}else if(opcionSeleccionada=="9505"){
					    capa.innerHTML="INSERCION LABORAL ";
					}else if(opcionSeleccionada=="9506"){
					    capa.innerHTML="TECNOLOGIAS DE LA INFORMACION Y DE LAS TELECOMUNICACIONES ";
					}else if(opcionSeleccionada=="9507"){
					    capa.innerHTML="INGLES COMUNICATIVO ";
					}else if(opcionSeleccionada=="50163"){
					    capa.innerHTML="educacion artistica y artes visuales ";
					}else if(opcionSeleccionada=="50164"){
					    capa.innerHTML="CONSEJO DE CURSO Y/O ORIENTACION ";
					}else if(opcionSeleccionada=="50165"){
					    capa.innerHTML="CONSEJO DE CURSO ";
					}else if(opcionSeleccionada=="50166"){
					    capa.innerHTML="ORIENTACION ";
					}else if(opcionSeleccionada=="50167"){
					    capa.innerHTML="Desarrollo Integral del deportista ";
					}else if(opcionSeleccionada=="50168"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="50169"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="50170"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="50171"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="50172"){
					    capa.innerHTML="DEPORTES ";
					}else if(opcionSeleccionada=="50173"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="50174"){
					    capa.innerHTML="DEPORTES ";
					}else if(opcionSeleccionada=="50175"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="50176"){
					    capa.innerHTML="DEPORTES ";
					}else if(opcionSeleccionada=="50177"){
					    capa.innerHTML="DEPORTES ";
					}else if(opcionSeleccionada=="50178"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="50179"){
					    capa.innerHTML="DEPORTES ";
					}else if(opcionSeleccionada=="50180"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="50181"){
					    capa.innerHTML="DEPORTES ";
					}else if(opcionSeleccionada=="50182"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="50183"){
					    capa.innerHTML="DEPORTES ";
					}else if(opcionSeleccionada=="50184"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="50185"){
					    capa.innerHTML="DEPORTES ";
					}else if(opcionSeleccionada=="50186"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="50187"){
					    capa.innerHTML="DEPORTES ";
					}else if(opcionSeleccionada=="50188"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="50189"){
					    capa.innerHTML="DEPORTES ";
					}else if(opcionSeleccionada=="50190"){
					    capa.innerHTML="DEPORTES ";
					}else if(opcionSeleccionada=="50191"){
					    capa.innerHTML="DEPORTES ";
					}else if(opcionSeleccionada=="50192"){
					    capa.innerHTML="DESARROLLO INTEGRAL DEL DEPORTISTA ";
					}else if(opcionSeleccionada=="50193"){
					    capa.innerHTML="COMPUTACION ";
					}else if(opcionSeleccionada=="50194"){
					    capa.innerHTML="ORIENTACION ";
					}else if(opcionSeleccionada=="50195"){
					    capa.innerHTML="EDUCACION MUSICAL ";
					}else if(opcionSeleccionada=="50196"){
					    capa.innerHTML="TALLER DE INFORMATICA ";
					}else if(opcionSeleccionada=="50197"){
					    capa.innerHTML="ORIENTACION VOCACIONAL ";
					}else if(opcionSeleccionada=="50198"){
					    capa.innerHTML="ORIENTACION ";
					}else if(opcionSeleccionada=="50199"){
					    capa.innerHTML="Transversal del Área ";
					}else if(opcionSeleccionada=="50200"){
					    capa.innerHTML="EXPLORATORIO ";
					}else if(opcionSeleccionada=="50201"){
					    capa.innerHTML="EXPLORATORIO ";
					}else if(opcionSeleccionada=="50202"){
					    capa.innerHTML="Exploratorio ";
					}else if(opcionSeleccionada=="50203"){
					    capa.innerHTML="EXPLORATORIO ";
					}else if(opcionSeleccionada=="50204"){
					    capa.innerHTML="ORIENTACION ";
					}else if(opcionSeleccionada=="50205"){
					    capa.innerHTML="ORIENTACION ";
					}else if(opcionSeleccionada=="50206"){
					    capa.innerHTML="Filosofia 2 ";
					}else if(opcionSeleccionada=="50207"){
					    capa.innerHTML="ORIENTACION ";
					}else if(opcionSeleccionada=="50208"){
					    capa.innerHTML="INGLES CIENTIFICO TECNOLOGICO ";
					}else if(opcionSeleccionada=="50209"){
					    capa.innerHTML="Aprendizaje en laempresa ";
					}else if(opcionSeleccionada=="50210"){
					    capa.innerHTML="APRENDIZAJE EN LA EMPRESA ";
					}else if(opcionSeleccionada=="50211"){
					    capa.innerHTML="Modelaje y corte de vestuario masculino ";
					}else if(opcionSeleccionada=="50212"){
					    capa.innerHTML="MODELAJE DE VESTUARIO ASISTIDO POR COMPUTADORA ";
					}else if(opcionSeleccionada=="50213"){
					    capa.innerHTML="PREPARADO Y CONFECCION DE PRENDAS MASCULINAS DEPORTIVAS DE TRABAJO ";
					}else if(opcionSeleccionada=="50214"){
					    capa.innerHTML="PREPARADO Y CONFECCION DE PRENDAS MASCULINAS DE VESTIR ";
					}else if(opcionSeleccionada=="50215"){
					    capa.innerHTML="ORIENTACION ";
					}else if(opcionSeleccionada=="50216"){
					    capa.innerHTML="Filosofia ";
					}else if(opcionSeleccionada=="50217"){
					    capa.innerHTML="EXPRESION ARTISTICA ";
					}else if(opcionSeleccionada=="50218"){
					    capa.innerHTML="idioma extranjero (inglés) ";
					}else if(opcionSeleccionada=="50219"){
					    capa.innerHTML="IDIOMA EXTRANJERO (INGLES) ";
					}else if(opcionSeleccionada=="50220"){
					    capa.innerHTML="IDIOMA EXTRANJERO (INGLES) ";
					}else if(opcionSeleccionada=="50221"){
					    capa.innerHTML="CULTURAS ORIGINARIAS DE AMERICA ";
					}else if(opcionSeleccionada=="50222"){
					    capa.innerHTML="INGLES ";
					}else if(opcionSeleccionada=="50223"){
					    capa.innerHTML="MATEMATICAS Y MODELOS ANALITICOS ";
					}else if(opcionSeleccionada=="50224"){
					    capa.innerHTML="LENGUAJE Y SOCIEDAD ";
					}else if(opcionSeleccionada=="50225"){
					    capa.innerHTML="CS. SOCIALES Y REALIDAD NACIONAL ";
					}else if(opcionSeleccionada=="50226"){
					    capa.innerHTML="EVOLUCION ECOLOGIA Y AMBIENTE ";
					}else if(opcionSeleccionada=="50227"){
					    capa.innerHTML="PROBLEMAS DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="50228"){
					    capa.innerHTML="Taller Inglés ";
					}else if(opcionSeleccionada=="50229"){
					    capa.innerHTML="Taller Rapa Nui ";
					}else if(opcionSeleccionada=="50230"){
					    capa.innerHTML="Taller Actividades Lingüísticas ";
					}else if(opcionSeleccionada=="50231"){
					    capa.innerHTML="Taller Habilidades Matemáticas ";
					}else if(opcionSeleccionada=="50232"){
					    capa.innerHTML="Taller Inglés ";
					/*30*/
					}else if(opcionSeleccionada=="50233"){
					    capa.innerHTML="Taller Rapa Nui ";
					}else if(opcionSeleccionada=="50234"){
					    capa.innerHTML="Taller Habilidades Lingüística ";
					}else if(opcionSeleccionada=="50235"){
					    capa.innerHTML="Taller Habilidades Matemáticas ";
					}else if(opcionSeleccionada=="50236"){
					    capa.innerHTML="Taller Inglés ";
					}else if(opcionSeleccionada=="50237"){
					    capa.innerHTML="Taller Rapa Nui ";
					}else if(opcionSeleccionada=="50238"){
					    capa.innerHTML="Taller Rapa Nui ";
					}else if(opcionSeleccionada=="50239"){
					    capa.innerHTML="Taller Habilidades Lingüística ";
					}else if(opcionSeleccionada=="50240"){
					    capa.innerHTML="Taller Habilidades Matemáticas ";
					}else if(opcionSeleccionada=="50241"){
					    capa.innerHTML="Taller Inglés ";
					}else if(opcionSeleccionada=="50242"){
					    capa.innerHTML="Taller Rapa Nui ";
					}else if(opcionSeleccionada=="50243"){
					    capa.innerHTML="Taller Habilidades Lingüística ";
					}else if(opcionSeleccionada=="50244"){
					    capa.innerHTML="Taller Habilidades Matemáticas ";
					}else if(opcionSeleccionada=="50245"){
					    capa.innerHTML="Inglés ";
					}else if(opcionSeleccionada=="50246"){
					    capa.innerHTML="Taller Inglés ";
					}else if(opcionSeleccionada=="50247"){
					    capa.innerHTML="Taller Rapa Nui ";
					}else if(opcionSeleccionada=="50248"){
					    capa.innerHTML="Taller Habilidades Lingüística ";
					}else if(opcionSeleccionada=="50249"){
					    capa.innerHTML="Taller Habilidades Matemáticas ";
					}else if(opcionSeleccionada=="50250"){
					    capa.innerHTML="Taller Rapa Nui ";
					}else if(opcionSeleccionada=="50251"){
					    capa.innerHTML="Taller Habilidades Lingüística ";
					}else if(opcionSeleccionada=="50252"){
					    capa.innerHTML="Taller Habilidades Matemáticas ";
					}else if(opcionSeleccionada=="50253"){
					    capa.innerHTML="Taller Rapa Nui ";
					}else if(opcionSeleccionada=="50254"){
					    capa.innerHTML="Taller Habilidades Lingüística ";
					}else if(opcionSeleccionada=="50255"){
					    capa.innerHTML="Taller Habilidades Matemáticas ";
					}else if(opcionSeleccionada=="50256"){
					    capa.innerHTML="Taller Rapa Nui ";
					}else if(opcionSeleccionada=="50257"){
					    capa.innerHTML="Taller Instrumental ";
					}else if(opcionSeleccionada=="50258"){
					    capa.innerHTML="Debate y Argumentación ";
					}else if(opcionSeleccionada=="50259"){
					    capa.innerHTML="Taller de Física ";
					}else if(opcionSeleccionada=="50260"){
					    capa.innerHTML="IDIOMA EXTRANJERO (INGLÉS) ";
					}else if(opcionSeleccionada=="50261"){
					    capa.innerHTML="Lenguaje y Comunicación ";
					}else if(opcionSeleccionada=="50262"){
					    capa.innerHTML="Lenguaje y Convivencia ";
					}else if(opcionSeleccionada=="50263"){
					    capa.innerHTML="CONSEJO DE CURSO ";
					}else if(opcionSeleccionada=="50264"){
					    capa.innerHTML="CONSEJO DE CURSO ";
					}else if(opcionSeleccionada=="50265"){
					    capa.innerHTML="CONSEJO DE CURSO ";
					}else if(opcionSeleccionada=="50266"){
					    capa.innerHTML="CONSEJO DE CURSO ";
					}else if(opcionSeleccionada=="50267"){
					    capa.innerHTML="TALLER FOLCLOR ";
					}else if(opcionSeleccionada=="50268"){
					    capa.innerHTML="CONSEJO DE CURSO ";
					}else if(opcionSeleccionada=="50269"){
					    capa.innerHTML="CONSEJO DE CURSO ";
					}else if(opcionSeleccionada=="50270"){
					    capa.innerHTML="CONSEJO DE CURSO ";
					}else if(opcionSeleccionada=="50271"){
					    capa.innerHTML="CONSEJO DE CURSO ";
					}else if(opcionSeleccionada=="50272"){
					    capa.innerHTML="TRANSVERSAL GENERAL ";
					}else if(opcionSeleccionada=="50273"){
					    capa.innerHTML="TRANSVERSAL DEL AREA ";
					}else if(opcionSeleccionada=="50274"){
					    capa.innerHTML="TRANSVERSAL GENERAL ";
					
					}else if(opcionSeleccionada=="50275"){
					    capa.innerHTML="EXPRESIÓN ARTÍSTICA ";
					}else if(opcionSeleccionada=="50276"){
					    capa.innerHTML="TRANSVERSAL DE ÁREA ";
					}else if(opcionSeleccionada=="50277"){
					    capa.innerHTML="TRANSVERSAL GENERAL ";
					}else if(opcionSeleccionada=="50278"){
					    capa.innerHTML="EXPRESIÓN ARTÍSTICA ";
					}else if(opcionSeleccionada=="50279"){
					    capa.innerHTML="TRANSVERSAL DE ÁREA ";
					}else if(opcionSeleccionada=="50280"){
					    capa.innerHTML="TRANSVERSAL GENERAL ";
					}else if(opcionSeleccionada=="50281"){
					    capa.innerHTML="EXPRESIÓN ARTÍSTICA ";
					}else if(opcionSeleccionada=="50282"){
					    capa.innerHTML="TRANSVERSAL DE ÁREA ";
					}else if(opcionSeleccionada=="50283"){
					    capa.innerHTML="TRANSVERSAL GENERAL ";
					}else if(opcionSeleccionada=="50284"){
					    capa.innerHTML="EXPRESIÓN ARTÍSTICA ";
					}else if(opcionSeleccionada=="50285"){
					    capa.innerHTML="TRANSVERSAL DE ÁREA ";
					}else if(opcionSeleccionada=="50286"){
					    capa.innerHTML="TRANSVERSAL GENERAL ";
					}else if(opcionSeleccionada=="50287"){
					    capa.innerHTML="EXPRESIÓN ARTÍSTICA ";
					}else if(opcionSeleccionada=="50288"){
					    capa.innerHTML="TRANSVERSAL DE AREA ";
					}else if(opcionSeleccionada=="50289"){
					    capa.innerHTML="TRANSVERSAL GENERAL ";
					}else if(opcionSeleccionada=="50290"){
					    capa.innerHTML="TRANSVERSAL GENERAL ";
					}else if(opcionSeleccionada=="50291"){
					    capa.innerHTML="TRANSVERSAL GENERAL ";
					}else if(opcionSeleccionada=="50292"){
					    capa.innerHTML="TRANSVERSAL GENERAL ";
					}else if(opcionSeleccionada=="50293"){
					    capa.innerHTML="EXPRESIÓN ARTÍSTICA ";
					}else if(opcionSeleccionada=="50294"){
					    capa.innerHTML="TRANSVERSAL DE ÁREA ";
					}else if(opcionSeleccionada=="50295"){
					    capa.innerHTML="EXPRESIÓN ARTÍSTICA ";
					}else if(opcionSeleccionada=="50296"){
					    capa.innerHTML="TRANSVERSAL DE ÁREA ";
					}else if(opcionSeleccionada=="50297"){
					    capa.innerHTML="EXPRESIÓN ARTÍSTICA ";
					}else if(opcionSeleccionada=="50298"){
					    capa.innerHTML="TRANSVERSAL DE ÁREA ";
					}else if(opcionSeleccionada=="50299"){
					    capa.innerHTML="EXPRESIÓN ARTÍSTICA ";
					}else if(opcionSeleccionada=="50300"){
					    capa.innerHTML="TRANSVERSAL DE ÁREA ";
					}else if(opcionSeleccionada=="50301"){
					    capa.innerHTML="IDIOMA EXTRANJERO (INGLES) ";
					}else if(opcionSeleccionada=="50302"){
					    capa.innerHTML="IDIOMA EXTRANJERO (INGLES) ";
					}else if(opcionSeleccionada=="50303"){
					    capa.innerHTML="Culturas Originarias ";
					}else if(opcionSeleccionada=="50304"){
					    capa.innerHTML="ARTES MUSICALES ";
					}else if(opcionSeleccionada=="50305"){
					    capa.innerHTML="Lenguaje y Sociedad ";
					}else if(opcionSeleccionada=="50306"){
					    capa.innerHTML="Ciencias Sociales y Realidad Nacional ";
					}else if(opcionSeleccionada=="50307"){
					    capa.innerHTML="Argumentación ";
					}else if(opcionSeleccionada=="50308"){
					    capa.innerHTML="Algebra y Modelos Analíticos ";
					}else if(opcionSeleccionada=="50309"){
					    capa.innerHTML="Evolución, Ecología y Ambiente ";
					}else if(opcionSeleccionada=="50310"){
					    capa.innerHTML="Mecánica ";
					}else if(opcionSeleccionada=="50311"){
					    capa.innerHTML="Lenguaje y Sociedad ";
					}else if(opcionSeleccionada=="50312"){
					    capa.innerHTML="Ciencias Sociales y Realidad Nacional ";
					}else if(opcionSeleccionada=="50313"){
					    capa.innerHTML="Argumentación ";
					}else if(opcionSeleccionada=="50314"){
					    capa.innerHTML="Algebraa y Modelos Analíticos ";
					}else if(opcionSeleccionada=="50315"){
					    capa.innerHTML="Evolución, Ecología y Ambiente ";
					}else if(opcionSeleccionada=="50316"){
					    capa.innerHTML="Mecánica ";
					}else if(opcionSeleccionada=="50317"){
					    capa.innerHTML="Literatura e Identidad ";
					}else if(opcionSeleccionada=="50318"){
					    capa.innerHTML="La Ciudad Contemporánea ";
					}else if(opcionSeleccionada=="50319"){
					    capa.innerHTML="Argumentación ";
					}else if(opcionSeleccionada=="50320"){
					    capa.innerHTML="Funciones y Procesos Infinitos ";
					}else if(opcionSeleccionada=="50321"){
					    capa.innerHTML="Célula, Genóma y Organismo ";
					}else if(opcionSeleccionada=="50322"){
					    capa.innerHTML="Termodinámica ";
					}else if(opcionSeleccionada=="50323"){
					    capa.innerHTML="BIOLOGIA ELECTIVA ";
					}else if(opcionSeleccionada=="50324"){
					    capa.innerHTML="MATEMÁTICA ELECTIVA ";
					}else if(opcionSeleccionada=="50325"){
					    capa.innerHTML="LITERATURA E IDENTIDAD ";
					}else if(opcionSeleccionada=="50326"){
					    capa.innerHTML="HISTORIA Y CIENCIAS SOCIALES ELECTIVO: La ciudad contemporánea ";
					}else if(opcionSeleccionada=="50327"){
					    capa.innerHTML="BIOLOGÍA ELECTIVO ";
					}else if(opcionSeleccionada=="50328"){
					    capa.innerHTML="PSICOLOGÍA ELECTIVO: Argumentación ";
					}else if(opcionSeleccionada=="50329"){
					    capa.innerHTML="AUTONOMIA ";
					}else if(opcionSeleccionada=="50330"){
					    capa.innerHTML="CONVIVENCIA E IDENTIDAD ";
					}else if(opcionSeleccionada=="50331"){
					    capa.innerHTML="LENGUAJE VERBAL ";
					}else if(opcionSeleccionada=="50332"){
					    capa.innerHTML="LENGUAJE ARTISTICO ";
					}else if(opcionSeleccionada=="50333"){
					    capa.innerHTML="GRUPOS HUMANOS ";
					}else if(opcionSeleccionada=="50334"){
					    capa.innerHTML="SERES VIVOS ";
					}else if(opcionSeleccionada=="50335"){
					    capa.innerHTML="RELACIONES LOGICO MATEMATICAS ";
					}else if(opcionSeleccionada=="50336"){
					    capa.innerHTML="Idioma Extranjero (Inglés) ";
					}else if(opcionSeleccionada=="50337"){
					    capa.innerHTML="IDIOMA EXTRANJERO (INGLES) ";
					}else if(opcionSeleccionada=="50338"){
					    capa.innerHTML="ACONDICIONAMIENTO FISICO ";
					
					}else if(opcionSeleccionada=="50339"){
					    capa.innerHTML="DIFERENCIADO LENGUAJE Y SOCIEDAD ";
					}else if(opcionSeleccionada=="50340"){
					    capa.innerHTML="DIFERENCIADO MATEMATICA ";
					}else if(opcionSeleccionada=="50341"){
					    capa.innerHTML="DIFERENCIADO HISTORIA Y CIENCIAS SOCIALES ";
					}else if(opcionSeleccionada=="50342"){
					    capa.innerHTML="Consejo de C urso 144 ";
					}else if(opcionSeleccionada=="50343"){
					    capa.innerHTML="IDIOMA EXTRANJERO (INGLES) ";
					}else if(opcionSeleccionada=="50344"){
					    capa.innerHTML="Algebra y Modelos Analíticos ";
					}else if(opcionSeleccionada=="50345"){
					    capa.innerHTML="IDIOMA EXTRANJERO (INGLES) ";
					}else if(opcionSeleccionada=="50346"){
					    capa.innerHTML="TALLER DE URBANIDAD ";
					}else if(opcionSeleccionada=="50347"){
					    capa.innerHTML="IDIOMA INGLES ";
					}else if(opcionSeleccionada=="50348"){
					    capa.innerHTML="LA CIUDAD CONTEMPORANEA ";
					}else if(opcionSeleccionada=="50349"){
					    capa.innerHTML="ARTES ESCENICAS TEATROYDANZA ";
					}else if(opcionSeleccionada=="50350"){
					    capa.innerHTML="FUNDAMENTOS DE ESPECTROSCOPIA ,CATALISIS ";
					}else if(opcionSeleccionada=="50351"){
					    capa.innerHTML="PROBLEMAS DEL CONOCIMIENTO ";
					}else if(opcionSeleccionada=="50352"){
					    capa.innerHTML="LITERATURA E IDENTIDAD ";
					}else if(opcionSeleccionada=="50353"){
					    capa.innerHTML="FUNCIONES Y PROCESOS INFINITOS ";
					}else if(opcionSeleccionada=="50354"){
					    capa.innerHTML="CELULA GENOMA Y ORGANISMO ";
					}else if(opcionSeleccionada=="9562"){
					    capa.innerHTML="AYUDANTE DE COCINA ";
					}else if(opcionSeleccionada=="9559"){
					    capa.innerHTML="AUXILIAR DE PELUQUERIA ";
					}else if(opcionSeleccionada=="50355"){
					    capa.innerHTML="DIGITACION EN COMPUTACION ";
					}else if(opcionSeleccionada=="50356"){
					    capa.innerHTML="PELUQUERIA Y BELLEZA INTEGRAL ";
					}else if(opcionSeleccionada=="50357"){
					    capa.innerHTML="PELUQUERIA Y BELLEZA INTEGRAL ";
					}else if(opcionSeleccionada=="50358"){
					    capa.innerHTML="ORIGENES E HISTORIA DE LA QUIMICA ";
					}else if(opcionSeleccionada=="50359"){
					    capa.innerHTML="FUNCIONES Y PROCESOS INFINITOS ";
					}else if(opcionSeleccionada=="50360"){
					    capa.innerHTML="1890 ";
					}else if(opcionSeleccionada=="50361"){
					    capa.innerHTML="ANALISIS DE LA EXPERIENCIA EN LA EMPRESA ";
					}else if(opcionSeleccionada=="50362"){
					    capa.innerHTML="APRENDIZAJE EN LA EMPRESA ";
					}else if(opcionSeleccionada=="50363"){
					    capa.innerHTML="EDUCACION TECNOLOGICA ";
					}else if(opcionSeleccionada=="50364"){
					    capa.innerHTML="artes musicales ";
					}else if(opcionSeleccionada=="5562"){
					    capa.innerHTML="CIRCUITOS ELECTRICOS AUXILIARES DEL VEHICULO Y MANTENIMIENTO DE LOS SISTEMAS ELECTRICOS Y ELECTRONICOS AUXILIARES , PREPARACION Y EMBELLECIMIENTO DE SUPERFICIES DEL VEHICULO ";
					}else if(opcionSeleccionada=="50365"){
					    capa.innerHTML="ANALISIS DE LA EXPERIENCIA EN LA EMPRESA ";
					}else if(opcionSeleccionada=="50366"){
					    capa.innerHTML="APRENDIZAJE EN LA EMPRESA ";
					}else if(opcionSeleccionada=="50367"){
					    capa.innerHTML="ANALISIS DE LA EXPERIENCIA EN LA EMPRESA ";
					}else if(opcionSeleccionada=="50368"){
					    capa.innerHTML="APRENDIZAJE EN LA EMPRESA ";
					}else if(opcionSeleccionada=="50369"){
					    capa.innerHTML="expresión de arte ";
					}else if(opcionSeleccionada=="50370"){
					    capa.innerHTML="AUTONOMIA 1 ";
					}else if(opcionSeleccionada=="50371"){
					    capa.innerHTML="AUTONOMIA 1 ";
					}else if(opcionSeleccionada=="50372"){
					    capa.innerHTML="AUTONOMIA 1 ";
					}else if(opcionSeleccionada=="50373"){
					    capa.innerHTML="Artes Musicales ";
					}else if(opcionSeleccionada=="50374"){
					    capa.innerHTML="AUTONOMIA 2 ";
					}else if(opcionSeleccionada=="50375"){
					    capa.innerHTML="AUTONOMIA 3 ";
					}else if(opcionSeleccionada=="50376"){
					    capa.innerHTML="AUTONOMIA 4 ";
					}else if(opcionSeleccionada=="50377"){
					    capa.innerHTML="AUTONOMIA 5 ";
					}else if(opcionSeleccionada=="50378"){
					    capa.innerHTML="IDENTIDAD 1 ";
					}else if(opcionSeleccionada=="50379"){
					    capa.innerHTML="IDENTIDAD 2 ";
					}else if(opcionSeleccionada=="50380"){
					    capa.innerHTML="CONVIVENCIA 1 ";
					}else if(opcionSeleccionada=="50381"){
					    capa.innerHTML="CONVIVENCIA 2 ";
					}else if(opcionSeleccionada=="50382"){
					    capa.innerHTML="CONVIVENCIA 3 ";
					}else if(opcionSeleccionada=="50383"){
					    capa.innerHTML="INTRODUCCION AL MUNDO AGROPECUARIO ";
					}else if(opcionSeleccionada=="50384"){
					    capa.innerHTML="INTRODUCCION A LA GEOLOGIA ";
					}else if(opcionSeleccionada=="50385"){
					    capa.innerHTML="I";
					}else if(opcionSeleccionada=="50386"){
					    capa.innerHTML="INTRODUCCION A LA GEOLOGIA ";
					}else if(opcionSeleccionada=="50387"){
					    capa.innerHTML="INTRODUCCION AL MUNDO AGROPECUARIO ";
					}else if(opcionSeleccionada=="50388"){
					    capa.innerHTML="INTRODUCCION AL MUNDO AGROPECUARIO ";
					}else if(opcionSeleccionada=="50389"){
					    capa.innerHTML="LITERATURA E IDENTIDAD ";
					}else if(opcionSeleccionada=="50390"){
					    capa.innerHTML="FUNCIONES Y PROCESOS INFINITOS ";
					}else{
						capa.innerHTML="nulo";
					}
			  break;
			  
			  
		}
		
		
		/*if(idSelectOrigen=="nacionalidad"){
			var capa=document.getElementById("nac1");
			if(opcionSeleccionada=="1"){
				capa.innerHTML="EXTRANJERA";
			}else{
				capa.innerHTML="CHILENA";
			}
		}
		if(idSelectOrigen=="sexo"){
			var capa1=document.getElementById("sexo1");
			if(opcionSeleccionada=="1")
				capa1.innerHTML="HOMBRE";
			}else{
				capa1.innherHTML="MUJER";
			}
		}*/
		//alert("capa="+capa);
	}
}