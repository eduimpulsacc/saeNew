function amd(fecha){
	var x;
	x	=	fecha.substr(6,4); //año
	x	+=	fecha.substr(3,2); //mes
	x	+=	fecha.substr(0,2); //dia
	return x;
}

function newWin(form,pag) {    
	var address		= pag;
//	var op_tool		= (document.form1.tool.checked== true)  ? 1 : 0;    
//	var op_loc_box  = (document.form1.loc_box.checked == true)  ? 1 : 0;    
//	var op_dir		= (document.form1.dir.checked == true)  ? 1 : 0;    
//	var op_stat		= (document.form1.stat.checked == true)  ? 1 : 0;    
//	var op_menu		= (document.form1.menu.checked == true)  ? 1 : 0;    
//	var op_scroll	= (document.form1.scroll.checked == true)  ? 1 : 0;    
//	var op_resize	= (document.form1.resize.checked == true)  ? 1 : 0;    
//	var op_wid		= document.form1.wid.value;   
//	var op_heigh	= document.form1.heigh.value;                 
//	var option		= "toolbar="+ op_tool +",location="+ op_loc_box +",directories=" + op_dir +",status="+ op_stat +",menubar="+ op_menu +",scrollbars="  + op_scroll +",resizable="  + op_resize +",width=" + op_wid +",height="+ op_heigh;

	var op_tool		= 1;
	var op_loc_box  = 1;
	var op_dir		= 1;
	var op_stat		= 1;
	var op_menu		= 1;
	var op_scroll	= 1;
	var op_resize	= 1;
//	var op_wid		= screen.width;
	var op_wid		= 800;
//	var op_heigh	= screen.height;
	var op_heigh	= 600;
	var option		= "toolbar="+ op_tool +",location="+ op_loc_box +",directories=" + op_dir +",status="+ op_stat +",menubar="+ op_menu +",scrollbars="  + op_scroll +",resizable="  + op_resize +",width=" + op_wid +",height="+ op_heigh;
//	var win3		= window.open("", "pagina", option);  
	var win4		= window.open(address, "pagina");
}


function tomaNombre(box){
	var checkStr = box.value;
	var checkOK = "/\\";
	
	for (i = checkStr.length;  i >= 0;  i--){
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j)){
				//alert(checkStr.substr(i+1,checkStr.length-i));
				return checkStr.substr(i+1,checkStr.length-i);
				break;
		};
	};
	return false;
};

function notaConOnly(box,msg){
	var checkStr = box.value;
	if (checkStr!=""){
		if ((checkStr!="MB")&&(checkStr!="B")&&(checkStr!="S")&&(checkStr!="I")){
			alert(msg);
			box.focus();
			box.select();
			return false;
		};
	};
	return true;
};

function notaNroOnly(box,msg){
	var checkStr = box.value;
	var checkOK = "0123456789";
	
	for (i = 0;  i < checkStr.length;  i++){
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j))
				break;
		if (j == checkOK.length){
			alert(msg);
			box.focus();
			box.select();
			return false;
		};
	};

	if((box.value>70)||(box.value<10)){
		alert(msg);
		box.focus();
		box.select();
		return false;

	}
	return true;
};


function igual(box1,box2,msg){
	var checkStr1 = box1.value;
	var checkStr2 = box2.value;

	if(checkStr1.length!=checkStr2.length){
		alert(msg);
		box2.focus();
		box2.select();
		return false;
	};

	for (i = 0;  i < checkStr1.length;  i++){
		ch1 = checkStr1.charAt(i);
		ch2 = checkStr2.charAt(i);
	
		if (ch1 != ch2){
			alert(msg);
			box2.focus();
			box2.select();
			return false;
		};
	};
	
	return true;
};


function go(url){
	window.location = url;
}

function borra(box) {
	box.value='';		// BORRA LA INFORMACION DEL CUADRO DE TEXTO
};

function chkVacio(box,msg){
	if (box.value==''){
		alert(msg);
		box.focus();
		box.select();
		return false;
	}else{
		return true;
	};
};

function chkSelect(box,msg){
	if (box.selectedIndex==0){
		alert(msg);
		box.focus();
		return false;
	}else{
		return true;
	};
};

function nroOnly(box,msg){
	var checkStr = box.value;
	var checkOK = "0123456789";
	
	for (i = 0;  i < checkStr.length;  i++){
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j))
				break;
		if (j == checkOK.length){
			alert(msg);
			box.focus();
			box.select();
			return false;
		};
	};
	return true;
};

function phoneOnly(box,msg){
	var checkStr = box.value;
	var checkOK = "0123456789-() ";
	
	for (i = 0;  i < checkStr.length;  i++){
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j))
				break;
		if (j == checkOK.length){
			alert(msg);
			box.focus();
			box.select();
			return false;
		};
	};
	return true;
};

function letraOnly(box,msg){
	var checkStr = box.value;
	var checkOK = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
	
	for (i = 0;  i < checkStr.length;  i++){
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j))
				break;
		if (j == checkOK.length){
			alert(msg);
			box.focus();
			box.select();
			return false;
		};
	};
	return true;
};

function nombreArchivoOnly(box,msg){
	var checkStr = box.value;
	var checkOK = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	
	for (i = 0;  i < checkStr.length;  i++){
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j))
				break;
		if (j == checkOK.length){
			alert(msg);
			box.focus();
			box.select();
			return false;
		};
	};
	return true;
};


function alfaOnly(box,msg){
	var checkStr = box.value;

	var checkOK = "0123456789. ";     //PARA CHEQUEAR QUE NO COMIENCE CON UN DIGITO O PUNTO.
	ch = checkStr.charAt(1);
	for (j = 0;  j < checkOK.length;  j++)
		if (ch == checkOK.charAt(j))
			break;
	if (j < checkOK.length){
		alert(msg);
		box.focus();
		box.select();
		return false;
	};
	var checkOK = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóú0123456789. ";
	for (i = 0;  i < checkStr.length;  i++){
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j))
				break;
		if (j == checkOK.length){
			alert(msg);
			box.focus();
			box.select();
			return false;
		};
	};
	return true;
};

function isEmail (box,msg){
	var s=box.value;
    var i = 1;
    var sLength = s.length;

	while ((i < sLength) && (s.charAt(i) != "@")){
		i++
    }
    
	if ((i >= sLength) || (s.charAt(i) != "@")) {
		alert(msg);
		box.focus();
		box.select();
		return false;
	}else{
		i += 2;
	}
	
	while ((i < sLength) && (s.charAt(i) != ".")){
		i++
	}
    
	if ((i >= sLength - 1) || (s.charAt(i) != ".")) {
		alert(msg);
		box.focus();
		box.select();
		return false;
	}
    else{
		return true;
	}
}

function CheckRutDigito(rut, digito) {
	var dvr = '0';
	suma = 0;
	mult = 2;
	for ( i = rut.length - 1 ; i >= 0 ; i -- ) {
		suma = suma + rut.charAt(i) * mult
		if ( mult == 7 )
			mult = 2;
		else
			mult ++;
	};
	res = suma % 11;
	if (res == 1)
		dvr = 'k';
	else {
		if (res == 0)
			dvr = '0';
		else {
			dvi = 11 - res;
			dvr = dvi + "" ;
		}
	}
	if ( dvr != digito.toLowerCase() )
		return false;
	return true;
}

function chkCod(box1,box2,msg) { 
	rut=box1.value;
	digito=box2.value;
	if (!CheckRutDigito(rut, digito)){
		box1.focus();
		box1.select();
		alert(msg);
		return false;
		}
	return true;
}

function chkFecha(field,msg){
	var checkstr = "0123456789";
	var DateField = field;
	var Datevalue = "";
	var DateTemp = "";
	var seperator = "-";
	var day;
	var month;
	var year;
	var leap = 0;
	var err = 0;
	var i;
	   err = 0;
	   DateValue = DateField.value;
	   /* Delete all chars except 0..9 */
	   for (i = 0; i < DateValue.length; i++) {
		  if (checkstr.indexOf(DateValue.substr(i,1)) >= 0) {
			 DateTemp = DateTemp + DateValue.substr(i,1);
		  }
	   }
	   DateValue = DateTemp;
	   /* Always change date to 8 digits - string*/
	   /* if year is entered as 2-digit / always assume 20xx */
	   if (DateValue.length == 6) {
		  DateValue = DateValue.substr(0,4) + '20' + DateValue.substr(4,2); }
	   if (DateValue.length != 8) {
		  err = 19;}
	   /* year is wrong if year = 0000 */
	   year = DateValue.substr(4,4);
	   if (year == 0) {
		  err = 20;
	   }
	   /* Validation of month*/
	   month = DateValue.substr(2,2);
	   if ((month < 1) || (month > 12)) {
		  err = 21;
	   }
	   /* Validation of day*/
	   day = DateValue.substr(0,2);
	   if (day < 1) {
		 err = 22;
	   }
	   /* Validation leap-year / february / day */
	   if ((year % 4 == 0) || (year % 100 == 0) || (year % 400 == 0)) {
		  leap = 1;
	   }
	   if ((month == 2) && (leap == 1) && (day > 29)) {
		  err = 23;
	   }
	   if ((month == 2) && (leap != 1) && (day > 28)) {
		  err = 24;
	   }
	   /* Validation of other months */
	   if ((day > 31) && ((month == "01") || (month == "03") || (month == "05") || (month == "07") || (month == "08") || (month == "10") || (month == "12"))) {
		  err = 25;
	   }
	   if ((day > 30) && ((month == "04") || (month == "06") || (month == "09") || (month == "11"))) {
		  err = 26;
	   }
	   /* if 00 ist entered, no error, deleting the entry */
	   if ((day == 0) && (month == 0) && (year == 00)) {
		  err = 0; day = ""; month = ""; year = ""; seperator = "";
	   }
	   /* if no error, write the completed date to Input-Field (e.g. 13.12.2001) */
	   if (err == 0) {
		  DateField.value = day + seperator + month + seperator + year;
		  return true;
	   }
	   /* Error-message if err != 0 */
		else {
			alert(msg);
//			DateField.select();
//			DateField.focus();
			return false;
		//alert("Date is incorrect!");
		}
}

function checkRadios(nombre,msg) {
	var el = document.forms[0].elements;
	for(var i = 0 ; i < el.length ; ++i) {
		if((el[i].type == "radio")&&(el[i].name == nombre)) {
			var radiogroup = el[el[i].name]; // get the whole set of radio buttons.
			var itemchecked = false;
			for(var j = 0 ; j < radiogroup.length ; ++j) {
				if(radiogroup[j].checked) {
					itemchecked = true;
					break;
				}
			}
			if(!itemchecked) { 
				alert(msg);  
				if(el[i].focus)
					el[i].focus();
				return false;
			}
		}
	}
	return true;
} 

function checkRutField(campo){
	var tmpstr = "";
	texto=campo.value;
	for ( i=0; i < texto.length ; i++ )
		if ( texto.charAt(i) != ' ' && texto.charAt(i) != '.' && texto.charAt(i) != '-' )
			tmpstr = tmpstr + texto.charAt(i);
			texto = tmpstr;
			largo = texto.length;
			if ( largo < 2 ){
			alert("Debe ingresar el rut completo."+txt);
			return false;
		}
		for (i=0; i < largo ; i++ ){ 
			if ( texto.charAt(i) !="0" && texto.charAt(i) != "1" && texto.charAt(i) !="2" && texto.charAt(i) != "3" && texto.charAt(i) != "4" && texto.charAt(i) !="5" && texto.charAt(i) != "6" && texto.charAt(i) != "7" && texto.charAt(i) !="8" && texto.charAt(i) != "9" && texto.charAt(i) !="k" && texto.charAt(i) != "K" ) {
			alert("El valor ingresado no corresponde a un Rut válido."+txt);
			}
		}
		campo.value = texto;
		return false;
}

function chkHora(box,msg){
	var checkStr = box.value;
	var checkOK = "0123456789:";
	
	for (i = 0;  i < checkStr.length;  i++){
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j))
				break;
		if (j == checkOK.length){
			alert(msg);
			box.focus();
			box.select();
			return false;
		};
	};
	if(checkStr.length!=5){
		alert(msg);
		box.focus();
		box.select();
		return false;
	}
	if(checkStr.charAt(2)!=":"){
		alert(msg);
		box.focus();
		box.select();
		return false;
	}
	return true;
};

function estavacio(theField,msg){ 
var x=true;
   if ((theField == null) || (theField.length == 0)){
    alert(msg); 
    x=false;
  }
return x;       
}
