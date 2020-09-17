// JavaScript Document

function validaNota(box){
	if(box.value.length==0)	
	return true; // acepta longitud 0
	if(!notaNroOnly(box,'Nota inválida. 1')) 
	return false;	
	return true;
  }
				
function validaNotaNumerica(box){
	if(box.value.length==0)	
	return true; // acepta longitud 0
	if(!notaNroOnly(box,'Nota inválida. 2')) 
	return false;
		if (box.value>70){
		alert('Nota inválida. 3');
		return false;
		}
	return true;
  }

function validaNotaConceptual(box){
	if(box.value.length==0)	
	return true; // acepta longitud 0
	if(!notaConOnly(box,'Nota inválida. Usar letras MAYUSCULAS  1'))
	return false;
	return true;
  } 
  
 function round(number,X) {
					// rounds number to X decimal places, defaults to 2
					X = (!X ? 0 : X);
					return Math.round(number*Math.pow(10,X))/Math.pow(10,X);
				}

function aprox_entero(nota){
	var prom_nuevo = 0;
	if (nota>=65 && nota<=70) prom_nuevo = 70;
	if (nota>=60 && nota<=64) prom_nuevo = 60;
	if (nota>=55 && nota<=59) prom_nuevo = 55;
	if (nota>=50 && nota<=54) prom_nuevo = 50;								
	if (nota>=45 && nota<=49) prom_nuevo = 45;
	if (nota>=40 && nota<=44) prom_nuevo = 40;
	if (nota>=0   && nota<=39) prom_nuevo = 35;
	return prom_nuevo;
	}

function desifranotaconseptual(dato){
	var nueva_nota=0;
	var patron1 = /(^[mM][bB]{1}$)/;
	var patron2 = /(^[bB]{1}$)/; 
	var patron3 = /(^[sS]{1}$)/;
	var patron4 = /(^[iI]{1}$)/;
	 
	if ( patron1.test(dato) == true ) nueva_nota = 65;  //Mb
	if ( patron2.test(dato) == true ) nueva_nota = 55;	//B		
	if ( patron3.test(dato) == true ) nueva_nota = 45;  //S
	if ( patron4.test(dato) == true ) nueva_nota = 35;	//I

    return nueva_nota;
	
	}

function promedioconceptual(prom_conc){
	var letra = "x";
	if( prom_conc >=60 && prom_conc <= 70 ) letra = 'MB';
	if( prom_conc >=50 && prom_conc <= 59 ) letra = 'B';
	if( prom_conc >=40 && prom_conc <= 49 ) letra = 'S';
	if( prom_conc >=0   && prom_conc <= 39 ) letra = 'I';
	return letra;
	}


function validaNota(box){
	if(box.value.length==0)	
		return true; // acepta longitud 0		
	
	if(!notaConOnly(box,'Nota inválida. Usar letras MAYUSCULAS. '))
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

