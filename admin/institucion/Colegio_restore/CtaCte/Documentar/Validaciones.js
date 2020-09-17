function ValVac(objeto,valor,msg)
{
	if (valor=="" || valor=="null" || valor==-1)
	{
		alert(msg);
		objeto.focus();
		return false;
	};
	return true;
};


function ValCar(box,msg)
{
	var checkStr = box.value;
	var checkOK = "0123456789. ";     //PARA CHEQUEAR QUE NO COMIENCE CON UN DIGITO O PUNTO.
	ch = checkStr.charAt(1);
	for (j = 0;  j < checkOK.length;  j++)
		if (ch == checkOK.charAt(j))
			break;
	if (j < checkOK.length)
	{
		alert(msg);
		box.focus();
		box.select();
		return false;
	};
	
	var checkOK = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZáéíóúäëïöüÁÉÍÓÚÄËÏÖÜ¿?!¡()[]{}<>=+*/%&#$@Ç_·;:,^-0123456789. ";
	for (i = 0;  i < checkStr.length;  i++)
	{
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j))
				break;
		if (j == checkOK.length)
		{
			alert(msg);
			box.focus();
			box.select();
			return false;
		};
	};
	return true;
};

function ValCont(box,msg){
	var checkStr = box.value;
	var checkOK = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789";
	
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


function ValEnt(box,msg){
	var checkStr = box.value;
	var checkOK = "0123456789";
	
	for (i = 0;  i < checkStr.length;  i++)
	{
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j))
				break;
		if (j == checkOK.length)
		{
			alert(msg);
			box.focus();
			box.select();
			return false;
		};
	};
	return true;
};

function ValDec(box,msg){
	var checkStr = box.value;
	var checkOK = "0123456789.";
	
	for (i = 0;  i < checkStr.length;  i++)
	{
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j))
				break;
		if (j == checkOK.length)
		{
			alert(msg);
			box.focus();
			box.select();
			return false;
		};
	};
	return true;
};


function ValNumCuent(box,msg){
	var checkStr = box.value;
	var checkOK = "0123456789-";
	
	for (i = 0;  i < checkStr.length;  i++)
	{
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
			if (ch == checkOK.charAt(j))
				break;
		if (j == checkOK.length)
		{
			alert(msg);
			box.focus();
			box.select();
			return false;
		};
	};
	return true;
};


function ValRut(box1,box2,msg) { 
	rut=box1.value;
	digito=box2.value;
	if (!ValRutDigito(rut, digito))
	{
		box1.focus();
		box1.select();
		alert(msg);
		return false;
	};
	return true;
};

function ValRutDigito(rut, digito) {
	var dvr = '0';
	suma = 0;
	mult = 2;
	for ( i = rut.length - 1 ; i >= 0 ; i -- )
	{
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
		};
	};
	if ( dvr != digito.toLowerCase() )
		return false;
	return true;
};


function ValFecha(field,msg)
{
	var checkstr = "0123456789";
	var DateField = field;
	var Datevalue = "";
	var DateTemp = "";
	var seperator = "/";
	var day;
	var month;
	var year;
	var leap = 0;
	var err = 0;
	var i;
	err = 0;
	DateValue = DateField.value;
	/* Delete all chars except 0..9 */
		for (i = 0; i < DateValue.length; i++) 
		{
			if (checkstr.indexOf(DateValue.substr(i,1)) >= 0) 
			{
				DateTemp = DateTemp + DateValue.substr(i,1);
			};
		};
	DateValue = DateTemp;
	/* Always change date to 8 digits - string*/
	/* if year is entered as 2-digit / always assume 20xx */
		if (DateValue.length == 6) 
		{
			DateValue = DateValue.substr(0,4) + '20' + DateValue.substr(4,2); 
		};
		if (DateValue.length != 8) 
		{
			err = 19;
		};
	/* year is wrong if year = 0000 */
		year = DateValue.substr(4,4);
		if (year == 0) 
		{
			err = 20;
		};
	/* Validation of month*/
		month = DateValue.substr(2,2);
		if ((month < 1) || (month > 12)) 
		{
			err = 21;
		};
	/* Validation of day*/
		day = DateValue.substr(0,2);
		if (day < 1) 
		{
			err = 22;
		};
	/* Validation leap-year / february / day */
		if ((year % 4 == 0) || (year % 100 == 0) || (year % 400 == 0)) 
		{
			leap = 1;
		};
		if ((month == 2) && (leap == 1) && (day > 29)) 
		{
			  err = 23;
		};
		if ((month == 2) && (leap != 1) && (day > 28)) 
		{
			err = 24;
		};
	/* Validation of other months */
		if ((day > 31) && ((month == "01") || (month == "03") || (month == "05") || (month == "07") || (month == "08") || (month == "10") || (month == "12"))) 
		{
			err = 25;
		};
		if ((day > 30) && ((month == "04") || (month == "06") || (month == "09") || (month == "11"))) 
		{
			err = 26;
		};
	/* if 00 ist entered, no error, deleting the entry */
		if ((day == 0) && (month == 0) && (year == 00)) 
		{
			err = 0; day = ""; month = ""; year = ""; seperator = "";
		};
	/* if no error, write the completed date to Input-Field (e.g. 13.12.2001) */
		if (err == 0) 
		{
			DateField.value = day + seperator + month + seperator + year;
			return true;
		};
	/* Error-message if err != 0 */
		else 
		{
			alert(msg);
			field.focus();
			field.select();
			return false;
		};
};

function ValMail (box,msg)
{
	var s=box.value;
    var i = 1;
    var sLength = s.length;

	while ((i < sLength) && (s.charAt(i) != "@"))
	{
		i++
    };
    
	if ((i >= sLength) || (s.charAt(i) != "@")) 
	{
		alert(msg);
		box.focus();
		box.select();
		return false;
	}
	else
	{
		i += 2;
	};
	
	while ((i < sLength) && (s.charAt(i) != "."))
	{
		i++
	};
    
	if ((i >= sLength - 1) || (s.charAt(i) != ".")) 
	{
		alert(msg);
		box.focus();
		box.select();
		return false;
	}
    else
	{
		return true;
	};
};