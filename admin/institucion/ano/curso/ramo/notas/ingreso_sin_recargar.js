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

function cargaDatos(idDiv, idInput,alumno,ramo,periodo,casilla,fila,nombre,id,n){
	var valorInput=document.getElementById(idInput).value;	
	alert('ssss');
	var valorInput="<INPUT style='color:#000000; background-color:#cccccc' onBlur='cargaDatos(this.id, '"+idInput+"','"+alumno+"','"+ramo+"','"+periodo+"','"+casilla+"','"+fila+"','"+nombre+"','"+nombre+"','"+id+"','"+n+"')'  TYPE=text id="+id+"  NAME="+nombre+" onkeyup='fn(this.form,this,"+n+"); crearInput(this.id, '"+idInput+"','"+alumno+"','"+ramo+"','"+periodo+"','"+casilla+"','"+fila+"','"+nombre+"','"+nombre+"','"+id+"','"+n+"')' value="+valorInput+"  size='2' maxlength='2'>";
	
	//var valorInput=document.getElementById(idInput).value;
	
	var divError=document.getElementById("error");
	
	// Elimino todos los espacios en blanco al principio y al final de la cadena
	valorInput=eliminaEspacios(valorInput);
		
	// Valido con una expresion regular el contenido de lo que el usuario ingresa
	var reg=/(^[a-zA-Z0-9._áéíóúñ¡!¿? -]{1,40}$)/;
	
	/*
	if(!reg.test(valorInput)) 
	{ 
		// Si hay error muestro el div que contiene el error
		divError.innerHTML="El texto ingresado no es v&aacute;lido"
		divError.style.display="block";
	}
	else
	{
	*/	
	
	// Si no hay error oculto el div (por si se mostraba)
	divError.style.display="none";
	mostrandoInput=false;
	
	document.getElementById(idDiv).innerHTML=valorInput;
	
	/*
	// Creo objeto AJAX y envio peticion al servidor
	var ajax=nuevoAjax();
	//alert('alumno:'+alumno+' ramo:'+ramo+' periodo:'+periodo+' casilla:'+casilla);
	ajax.open("GET", "ingreso_sin_recargar_proceso.php?dato="+valorInput+"&actualizar="+idInput+"&alumno="+alumno+"&ramo="+ramo+"&periodo="+periodo+"&casilla="+casilla, true);
	ajax.send(null);
			
	document.form.prom[fila].value=44;
	*/
}

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





var mostrandoInput=false;

function creaInput(idDiv, idInput,alumno,ramo,periodo,casilla,fila,nota_actual,nombre,id,n){
	 
	
	/* Funcion encargada de cambiar el texto comun de la fila por un campo input que conserve
	el valor que tenia ese campo */
	var divError=document.getElementById("error");
	/* Solo mostramos el input si ya no esta siendo mostrado y si ademas el div del error no esta en pantalla */
	if(!mostrandoInput && divError.style.display!="block")
	{
		// Obtenemos el div contenedor del futuro input
		var divContenedor=document.getElementById(idDiv);		
		// Creamos el input
		divContenedor.innerHTML="<input type='text' size='1' onBlur='cargaDatos(\""+idDiv+"\", \""+id+"\", \""+alumno+"\", \""+ramo+"\", \""+periodo+"\", \""+casilla+"\", \""+fila+"\", \""+nombre+"\", \""+id+"\", \""+n+"\")'  value='"+nota_actual+"' id='"+id+"' name='"+nombre+"' maxlength='2' style='color:#FFFF99; background-color:#006666' onkeyup='fn(this.form,this,\""+n+"\")'>";		
					
		// Establecemos a true la variable para especificar que hay un input en pantalla y no se debe crear otro hasta que este se oculte
		mostrandoInput=true;
		// Colocamos el cursor en el input creado
		document.getElementById(id).focus();
	}
}