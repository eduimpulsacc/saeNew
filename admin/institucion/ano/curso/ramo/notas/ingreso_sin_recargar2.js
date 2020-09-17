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


function cargaDatos(idInput,alumno,ramo,periodo,n,promedio){
	alert('hh');
	var valorInput=document.getElementById(idInput).value;
	var promedio=document.getElementById(promedio).value;
	var divError=document.getElementById("error");
	
	// Elimino todos los espacios en blanco al principio y al final de la cadena
	valorInput=eliminaEspacios(valorInput);
		
	// Valido con una expresion regular el contenido de lo que el usuario ingresa
	var reg=/(^[a-zA-Z0-9._áéíóúñ¡!¿? -]{1,40}$)/;
	
	// Creo objeto AJAX y envio peticion al servidor
	var ajax=nuevoAjax();
	//alert('alumno:'+alumno+' ramo:'+ramo+' periodo:'+periodo+' casilla:'+casilla);
	
	ajax.open("GET", "ingreso_sin_recargar_proceso.php?valor="+valorInput+"&alumno="+alumno+"&ramo="+ramo+"&periodo="+periodo+"&casilla="+n+"&promedio="+promedio, true);
	ajax.send(null);	
	
}

function blanco(f,v){
	alert('blanco');
   	f.item(v).style.backgroundColor='#FFFF33';
	
}
function blanco2(f,v){
	alert('blanco2');
   	f.item(v).style.backgroundColor='#B6E7CE';
	
}
