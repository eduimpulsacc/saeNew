//Nuevo Editor HTML
//autor: Ariel Mendez
//ultima modificacion: 15/05/2007 12.47 hs
//version: 1.2
window.onresize = refreshPos;
var editMode=false;
var selectedLink, sel, rng, selOK, editActivated, lastWhat;
var txtsinfondo= "";
var oldTexto = new Array();
var oldFotos = new Array();
var actualIframe="";
var intId=0;
var isPrev=false;
var isDWRInc = false;

//SELECCION DE NAVEGADOR
var isIE = true;
if (navigator.appName == 'Netscape' || navigator.appName == 'Opera')isIE = false;

function vistaDiseno(){
	var elemArray = document.getElementById("editCtl").contentWindow.document.getElementsByTagName('LABEL');
	for (iVar = 0;iVar < elemArray.length;iVar++){
		if (elemArray[iVar].id.substring(0,3) == "VAR"){
			for (h=0 ; h < variables.length;h++){
				if (variables[h][0] == elemArray[iVar].id.substring(3)){
					elemArray[iVar].innerHTML = "<i>["+variables[h][1]+"]</i>";
				}
			}
		}
	}
}
function vistaPrevia(){
	for (iVar = 0;iVar < document.getElementById("editCtl").contentWindow.document.getElementsByTagName('LABEL').length;iVar++){
		var auxElements = document.getElementById("editCtl").contentWindow.document.getElementsByTagName('LABEL');
		var auxElement = auxElements[iVar];
		if (auxElement.id.substring(0,3) != 'VAR'){continue;}
		var auxContent;
		//VARIABLE GARANTIA
		if (document.getElementById("editCtl").contentWindow.document.getElementsByTagName('LABEL')[iVar].id.substring(3) == 'warranty'){
			if (document.fmain.warranty.value != ''){
				auxContent = document.fmain.warranty.value;
			}
			else{
				auxContent = document.fmain.warrantyCheck[0].checked ? document.fmain.warrantyCheck[0].value : document.fmain.warrantyCheck[1].value;
			}
		}
		//VARIABLE PRECIO
		else if (document.getElementById("editCtl").contentWindow.document.getElementsByTagName('LABEL')[iVar].id.substring(3) == 'price'){
			if (document.getElementById("auctCI") && document.getElementById("auctCI").checked == true){
				auxContent = document.getElementById('priceCI').value + '.' + document.getElementById('priceDecCI').value;
			}
			if (document.getElementById("auctSN") && document.getElementById("auctSN").checked == true){
				auxContent = document.getElementById('priceSN').value + '.' + document.getElementById('priceDecSN').value;
			}
			if (document.getElementById("auctS1") && document.getElementById("auctS1").checked == true){
				auxContent = document.getElementById('priceS1').value + '.' + document.getElementById('priceDecS1').value;
			}
			if (document.getElementById("auctPR") && document.getElementById("auctPR").checked == true){
				auxContent = document.getElementById('pricePR').value + '.' + document.getElementById('priceDecPR').value;
			}
		}
		//RESTO DE LAS VARIABLES
		else{
			var auxObj = document.getElementById("editCtl").contentWindow.document.getElementsByTagName('LABEL')[iVar].id.substring(3);
			if (document.getElementsByName(auxObj)[0])auxContent = document.getElementsByName(auxObj)[0].value;
		}		
		document.getElementById("editCtl").contentWindow.document.getElementsByTagName('LABEL')[iVar].innerHTML = auxContent;
	}
	for (h=0 ; h < variables.length;h++){
		if (document.getElementsByName(variables[h][0])[0]){
			var textvar = "<LABEL id='VAR"+variables[h][0]+"' name='VARIABLE'>"+document.getElementsByName(variables[h][0])[0].value+"</LABEL>";
			if (document.getElementById("editCtl").contentWindow.document.getElementById('CONTENT')){
				for (var retry = 0;retry < 3;retry++)document.getElementById("editCtl").contentWindow.document.getElementById('CONTENT').innerHTML = document.getElementById("editCtl").contentWindow.document.getElementById('CONTENT').innerHTML.replace('['+variables[h][1]+']', textvar);
			}
			else{
				for (var retry = 0;retry < 3;retry++)document.getElementById("editCtl").contentWindow.document.body.innerHTML = document.getElementById("editCtl").contentWindow.document.body.innerHTML.replace('['+variables[h][1]+']', textvar);
			}
		}
	}
}

function poneVar(nombre){
	var nombre2;
	reselect();
	for (h=0 ; h < variables.length;h++){
		if (variables[h][1] == nombre) {
			nombre2 = variables[h][0];
			break;
		}
	}
	insertHTML("&nbsp;<LABEL id='VAR"+nombre2+"' name='VARIABLE'>["+nombre+"]</LABEL>&nbsp;");
	closeAllPopups();
}

function poneFondo(fondo){
	//SI TENIA UN FONDO PUESTO LO SACO
	if (document.getElementById("editCtl").contentWindow.document.getElementById('CONTENT')){
		var oldHtml = document.getElementById("editCtl").contentWindow.document.getElementById('CONTENT').innerHTML;
	}
	else{
		var oldHtml;
		if (document.getElementById("editCtl").contentWindow.document.getElementById('DOFON')){///DOFON
			oldHtml = document.getElementById("editCtl").contentWindow.document.getElementById('DOFON').innerHTML;
		}
		else{
			oldHtml = document.getElementById("editCtl").contentWindow.document.body.innerHTML;
		}
	}
	document.getElementById("editCtl").contentWindow.document.body.innerHTML = fondo;
	document.getElementById("editCtl").contentWindow.document.getElementById('CONTENT').innerHTML = oldHtml;
}

function poneEstructura(estructura){
	var oldHtml = "";
	
	//GUARDAR HTML ANTERIOR
	if (document.getElementById("editCtl").contentWindow.document.getElementById('TEXTO1')){
		//Guardar textos actuales mientras existan
		for (i1=1;document.getElementById("editCtl").contentWindow.document.getElementById('TEXTO'+i1);i1++){
			oldTexto[i1] = document.getElementById("editCtl").contentWindow.document.getElementById('TEXTO'+i1).innerHTML;
		}
		//Guardar fotos actuales mientras existan
		for (i2=1;document.getElementById("editCtl").contentWindow.document.getElementById('FOTO'+i2);i2++){
			oldFotos[i2] = document.getElementById("editCtl").contentWindow.document.getElementById('FOTO'+i2).innerHTML;	
		}
	}
	else{
		if (document.getElementById("editCtl").contentWindow.document.getElementById('CONTENT')){
			oldHtml = document.getElementById("editCtl").contentWindow.document.getElementById('CONTENT').innerHTML;
		}
		else{
			if (document.getElementById("editCtl").contentWindow.document.getElementById('DOFON')){///DOFON
				oldHtml = document.getElementById("editCtl").contentWindow.document.getElementById('DOFON').innerHTML;
			}
			else{
				oldHtml = document.getElementById("editCtl").contentWindow.document.body.innerHTML;
			}
		}
	}
	//INSERTAR LA ESTRUCTURA
	if (document.getElementById("editCtl").contentWindow.document.getElementById('CONTENT')){
		//Esto no anduvo en FF -> document.getElementById("editCtl").contentWindow.document.getElementById('CONTENT').innerHTML = estructura;
		auxil = document.getElementById("editCtl").contentWindow.document.body.innerHTML;
		document.getElementById("editCtl").contentWindow.document.body.innerHTML = estructura;
		poneFondo(auxil);
	}
	else{
		if (document.getElementById("editCtl").contentWindow.document.getElementById('DOFON')){
// document.getElementById("editCtl").contentWindow.document.getElementById('DOFON').innerHTML = '<tr id="__fakeFCKRemove__"><td>&nbsp;</td></tr>' + estructura ;
// document.getElementById("editCtl").contentWindow.document.getElementById('DOFON').getElementById('__fakeFCKRemove__').removeNode(true) ;
			try{
				document.getElementById("editCtl").contentWindow.document.getElementById('DOFON').innerHTML = estructura;
			}
			catch(err){
				document.getElementById("editCtl").contentWindow.document.body.innerHTML = estructura;
			}
		}
		else{
			document.getElementById("editCtl").contentWindow.document.body.innerHTML = estructura;
		}
	}
	//INSERTAR EL HTML ANTERIOR
	if (oldHtml == ""){
		//Insertar TEXTO
		for (iOld1 = 1;iOld1 < oldTexto.length;iOld1++){
			if (document.getElementById("editCtl").contentWindow.document.getElementById('TEXTO'+iOld1)){
				document.getElementById("editCtl").contentWindow.document.getElementById('TEXTO'+iOld1).innerHTML = oldTexto[iOld1];
			}
		}
		//Insertar fotos
		for (iOld2 = 1;iOld2 < oldTexto.length;iOld2++){
			if (document.getElementById("editCtl").contentWindow.document.getElementById('FOTO'+iOld2) && oldFotos[iOld2] != null){
				document.getElementById("editCtl").contentWindow.document.getElementById('FOTO'+iOld2).innerHTML = oldFotos[iOld2];
			}
		}
	}
	else{
		document.getElementById("editCtl").contentWindow.document.getElementById('TEXTO1').innerHTML = oldHtml;
	}
}
function includeDWR(){
	if (!isDWRInc){
		var head = parent.document.getElementsByTagName('head')[0];
		script = document.createElement('script');
		script.type = 'text/javascript';
		script.src='engine.js';
		head.appendChild(script);
		script2 = document.createElement('script');
		script2.type = 'text/javascript';
		script2.src='SyiTemp.js';
		head.appendChild(script2);
		//document.write("<script language=javascript src='/org-img/dwr/engine.js'><\/scr'+'ipt>");
		//document.write("<script language=javascript src='/dwr/interface/SyiTemp.js'><\/scr'+'ipt>");
		isDWRInc = true;
	}
}
//TEMPLATES
function deleteTemplateRta(){
	 document.getElementById('plants').contentWindow.updateUsrPlants();
}
function addTemp(txt){
	document.getElementById("editCtl").contentWindow.document.body.innerHTML =txt;	
}
function saveDescRta(data){
	if (data == true){
		try{
			document.getElementById('plants').contentWindow.updateUsrPlants();
		}
		catch(err){}
		alert(L_SAVE_OK);
	}
	else alert(L_SAVE_NOK);
}


//FUNCIONES COMUNES A AMBOS NAVEGADORES
function initEditor(){
	if (!isIE && document.getElementById("EDIT1"))document.getElementById("EDIT1").style.display = "none";
	if (!isIE && document.getElementById("EDIT2"))document.getElementById("EDIT2").style.display = "none";
	if (!isIE && document.getElementById("EDIT3"))document.getElementById("EDIT3").style.display = "none";
	if (!isIE && document.getElementById("EDIT0"))document.getElementById("EDIT0").style.width = 470;
	//preloadImages(); Esto no esta funcioanndo bien
	document.getElementById("editCtl").contentWindow.document.designMode = "On";
	document.getElementById("editCtl").contentWindow.document.open();
	document.getElementById("editCtl").contentWindow.document.write("<BODY STYLE='font:10pt arial;' oncontextmenu='return false'>");
	document.getElementById("editCtl").contentWindow.document.close();
	vistaPrevia();
	setMode('imgEdit');
	if (!isIE){
		document.getElementById("editCtl").contentWindow.document.execCommand('enableInlineTableEditing',false,false);
		document.getElementById("editCtl").contentWindow.document.execCommand('enableObjectResizing',false,true);
	}
}
function getHtml() {
	if (editMode) {
		return document.getElementById("editCtl").contentWindow.document.body.innerHTML;
	} else {
		return document.getElementById("editCtl").contentWindow.document.body.innerText;
	}
}
function refreshPos(){
	//Este metodo actualiza la posicion absoluta del div de desactivado
	var auxpos = getPosition(document.getElementById('HTMLEDIT'));
	document.getElementById("disabledLayer").style.top = auxpos.top;
	document.getElementById("disabledLayer").style.left = auxpos.left;
	document.getElementById("disabledLayer").style.display = editMode?"none":"block";
}
function setHtml(txt) {
	if (editMode)
		document.getElementById("editCtl").contentWindow.document.body.innerHTML=sVal
	else
		document.getElementById("editCtl").contentWindow.document.body.innerText=sVal
}

function toggleDisableLayer(){
	if (document.getElementById("disabledLayer")){
		var auxpos = getPosition(document.getElementById('HTMLEDIT'));
		document.getElementById("disabledLayer").style.top = auxpos.top;
		document.getElementById("disabledLayer").style.left = screen.width/2 - getDim(document.getElementById("disabledLayer").style.width)/2;
		document.getElementById("disabledLayer").style.display = (editMode && !isPrev)?"none":"block";
		document.getElementById("fontstyle").disabled = !(editMode && !isPrev);
		document.getElementById("fontsize").disabled = !(editMode && !isPrev);
	}
}

function changeFont(){
	applyCommand('fontName',document.getElementById('fontstyle').options[document.getElementById('fontstyle').selectedIndex].text);
}

function changeSize(){
	applyCommand('fontSize',parseInt(document.getElementById('fontsize').options[document.getElementById('fontsize').selectedIndex].text));	
	document.getElementById("editCtl").contentWindow.focus();
}

function saveSelection(){
    if (!isIE){
    	if ( editActivated ){
	      sel = document.getElementById("editCtl").contentWindow.document.getSelection();
	      rng = sel.getRangeAt(0);
	}
    }
    else{	
	sel = editCtl.document.selection;
	rng = sel.createRange();
    }
}

function getPicsArray(){return pics;}

function getEl(sTag,start) {
	while ((start!=null) && (start.tagName!=sTag)){
		start = start.parentElement
	}
	return start;
}

function buttonPress(what) {
	if (!editMode) return;
	lastWhat = what;
	saveSelection();
	switch(what){
	case "create":
		if ( confirm(L_NPAGE_CONFIRM) ) {
			document.getElementById("editCtl").contentWindow.document.body.innerHTML = "";
			oldTexto = new Array();
			oldFotos = new Array();
		}
		break;
	case "foreColorPopup":
	case "backColorPopup":
	case "bodyColorPopup":
		lastWhat = what;
		what = "colors";
	case "save"://GUARDAR DESCRIPCION
	case "tempopener"://CARGAR DESCRIPCION
		if (what == "save" || what == "tempopener")document.getElementById(what).src=document.getElementById(what).src;
	case "plants"://CARGAR DESCRIPCION
	case "vars"://VARIABLES DE ML
	case "designs"://DISÑOS DE ML
	case "layouts"://ESTRUCTURAS DE ML
	case "links"://LINKS DE ML
	case "pictures"://FOTOS CARGADAS
	case "adlnk":
	case "addDesc":
		if ( what == "pictures" ){pictures.showPics();}
		closeAllPopups();
		togglePopup(what, "block");
		break;
	case "paste":
		document.getElementById("editCtl").contentWindow.focus();
	default:
		if (isIE){
			document.getElementById("editCtl").contentWindow.document.execCommand(what);
		}
		else{		
			document.getElementById("editCtl").contentWindow.document.execCommand(what,false,"");
		}
		document.getElementById("editCtl").contentWindow.focus();
	}
}

function insert_html(html){
	var random_string = "insert_html_" + Math.round(Math.random()*100000000);
	frames.editCtl.document.execCommand("insertimage",false, random_string);
	var pat = new RegExp("<[^<]*" + random_string + "[^>]*>");
	var current_html = frames.editCtl.document.body.innerHTML = frames.editCtl.document.body.innerHTML.replace(pat, html);
}

function insertImage(img){
	reselect();
	insertHTML("<img align=absmiddle border=0 src=\""+img+"\">");
	closeAllPopups();
}

function setColor(color){
	applyColor(lastWhat, color);
}

function applyColor(what, color){
	if ( what == "foreColorPopup" ) {
		applyCommand("forecolor", color);
		document.getElementById('COLOR1').style.backgroundColor = '#' + color;
	}
	if ( what == "bodyColorPopup" ){
		setBodyColor(color);
		document.getElementById('COLOR3').style.backgroundColor = '#' + color;
	}
	if ( what == "backColorPopup" ){
		document.getElementById('COLOR2').style.backgroundColor = '#' + color;
		if (isIE){
			applyCommand("backcolor", color);
		}
		else{
			applyCommand("hilitecolor", color);
		}
	}
}

function setBodyColor(color){
	if (document.getElementById("editCtl").contentWindow.document.getElementById('CONTENT')){
		document.getElementById("editCtl").contentWindow.document.getElementById('CONTENT').style.backgroundColor = '#' + color;
	}
	else{
		if (document.getElementById("editCtl").contentWindow.document.getElementById('DOFON')){
			document.getElementById("editCtl").contentWindow.document.getElementById('DOFON').style.backgroundColor = '#' + color;
		}
		else{
			var oldHtmlColor = document.getElementById("editCtl").contentWindow.document.body.innerHTML;
			if (oldHtmlColor ==""){
				document.getElementById("editCtl").contentWindow.document.body.innerHTML = "<table bgColor=#"+color+" id='DOFON' cellpadding=0 cellspacing=0 border=0 width=100% height=100%><tr><td valign=top style='font:10pt arial;'><br></td></tr></table>";
			}
			else{
				document.getElementById("editCtl").contentWindow.document.body.innerHTML = "<table bgColor=#"+color+" id='DOFON' cellpadding=0 cellspacing=0 border=0 width=100% height=100%><tr><td valign=top style='font:10pt arial;'>"+oldHtmlColor+"</td></tr></table>";
			}
		}
	}
}

function loadSelectedPics(toLoad){
	reselect();
	for (i=0; i<6; i++){
		if ( toLoad[i] ) {
			insertHTML("<img align=absmiddle border=0 src=\""+pics[i]+"\">");
		}
	}
	closeAllPopups();
}

function getProxyURL(url){
	fileName = url.substring(url.lastIndexOf("/")+1);
	out = "/jm/img?s="+p_site_id+"&f="+fileName;
	return out;
}



function addDesc(txt){
	if (isIE){
		reselectIE();
		insertHTML(txt);
		r = editCtl.document.body.createTextRange();
		if ( r.findText(L_FILL_TITLE) ){
			r.select();
		} else {
			r = editCtl.document.body.createTextRange();
		}
	}
	else{
		reselect();
		insertHTML(txt);
	}	
	editCtl.scrollTo(0, 0);
}

function insertHTML(txt){
	if (isIE){
		if ( !selOK  ){
			r = editCtl.document.body.createTextRange();
			r.move("word", 1);
			r.collapse();
			r.select();
		}
		if (!sel || sel == null){
			return;
		}
		if ( sel.type == "Control" ) {
			sel.createRange().item(0).outerHTML = txt;
		} else {
			rng = sel.createRange();
			rng.pasteHTML(txt);
			rng.select();
		}
	}
	else{
		if ( !selOK  ){
			sel = document.getElementById("editCtl").contentWindow.getSelection();
			r = sel.getRangeAt(0);
		}
		if (!sel || sel == null)return;
		if ( sel.type == "Control" ) {
			sel.createRangeAt(0).item(0).outerHTML = txt;
		} else {
			sel = document.getElementById("editCtl").contentWindow.getSelection();
			rng = sel.getRangeAt(0);
			insert_html(txt);
		}
	}
}

function getDim(dim){
	return parseInt(dim.replace("px", ""));
}

function getPosition(o){
	var retval=new Object();
	var param =o;
	retval={top:0,left:0,width:0,height:0};

	retval.left = param.offsetLeft;
	retval.top  = param.offsetTop;

	var parent=param.offsetParent;
	while( parent !=null )
		{
		retval.left += parent.offsetLeft;
		retval.top += parent.offsetTop;
		parent = parent.offsetParent;
		}
	retval.height = param.height;
	retval.width  = param.width;
	return retval;
}
function applyCommand(opt,what){
	if (!isIE){
		reselect();
		document.getElementById("editCtl").contentWindow.document.execCommand(opt,"",what);
	}
	else{
		reselectIE();
		editCtl.document.execCommand(opt,"",what);
	}
	closeAllPopups();
}

function closeAllPopups(){
	
	clearInterval(intId);
	togglePopup("colors", "none");
	togglePopup("plants", "none");
	togglePopup("tempopener", "none");
	togglePopup("save", "none");
	togglePopup("vars", "none");
	togglePopup("pictures", "none");
	togglePopup("links", "none");
	togglePopup("designs", "none");
	togglePopup("layouts", "none");
	togglePopup("loadedPics", "none");
	togglePopup("addDesc", "none");
	togglePopup("colorPopup", "none");
	togglePopup("upload", "none");
	togglePopup("save", "none");
	togglePopup("adlnk", "none");
}
function showLoadError(){
	try{
		var cargo = eval(actualIframe).cargaError();
		if (cargo){
			clearInterval(intId);
		}
		else{
			noCargo();
		}
	}
	catch (error){//Si no cargo el iframe
		noCargo();
	}
}
function noCargo(){
	clearInterval(intId);
	backPopUp = document.getElementById(actualIframe);
	errorBox = document.getElementById('loadError');
	var auxpos = getPosition(document.getElementById('HTMLEDIT'));
	errorBox.style.top = auxpos.top + 75 + backPopUp.height/2;
	errorBox.style.left = screen.width/2 - getDim(errorBox.style.width)/2;
	errorBox.style.display = 'block';
}
function errorSi(){
	intId = setInterval(showLoadError,25000);
	document.getElementById('loadError').style.display = 'none';
}

function errorNo(){
	document.getElementById('loadError').style.display = 'none';
	closeAllPopups();
	if (document.getElementById(actualIframe))document.getElementById(actualIframe).src ="/jm/vobject?vObjectID=CARGANDO";
}

function togglePopup(name, onOff){
	box=document.getElementById(name);
	if ( onOff=="block" && box){
		actualIframe=name;
		if (box.src.indexOf("CARGANDO")>=0)intId = setInterval(showLoadError,25000);
		if (name == 'designs' && box.src.indexOf("/jm/vobject?vObjectID=I_HE_MLDESIGNS_SYI")<0){box.src = "/jm/vobject?vObjectID=I_HE_MLDESIGNS_SYI";};
		if (name == 'plants' && box.src.indexOf("/jm/descuploader?act=plants")<0){box.src = "/jm/descuploader?act=plants";}
		if (name == 'layouts' && box.src.indexOf("/jm/vobject?vObjectID=I_HE_MLLAYOUTS_SYI")<0){box.src = "/jm/vobject?vObjectID=I_HE_MLLAYOUTS_SYI";}
		if (name == 'links' && box.src.indexOf("/jm/vobject?vObjectID=I_HE_MLLINKS_SYI")<0){box.src = "/jm/vobject?vObjectID=I_HE_MLLINKS_SYI";}
		if (name == 'adlnk' && box.src.indexOf("/jm/vobject?vObjectID=I_HE_ADLINK_SYI")<0){box.src = "/jm/vobject?vObjectID=I_HE_ADLINK_SYI";}
		if (name == 'pictures' && box.src.indexOf("/jm/vobject?vObjectID=I_HE_LOADEDPICS_SYI")<0){box.src = "/jm/vobject?vObjectID=I_HE_LOADEDPICS_SYI";}
		if (name == 'save' && box.src.indexOf("/jm/vobject?vObjectID=DESCSAVE")<0){box.src = "/jm/vobject?vObjectID=DESCSAVE";}
		if (name == 'tempopener' && box.src.indexOf("/jm/vobject?vObjectID=DESCUPLOAD")<0){box.src = "/jm/vobject?vObjectID=DESCUPLOAD";}
		if (name == 'colors' && box.src.indexOf("/jm/vobject?vObjectID=I_HE_COLORPOPUP_SYI")<0){box.src = "/jm/vobject?vObjectID=I_HE_COLORPOPUP_SYI";}
		if (name == 'vars' && box.src.indexOf("/jm/descuploader?act=vars")<0){box.src = "/jm/descuploader?act=vars";}
		
		var auxpos = getPosition(document.getElementById('HTMLEDIT'));
		box.style.top = auxpos.top + 75; //20 fijos debajo
		box.style.left=screen.width/2 - getDim(box.style.width)/2;
	}
	if (box) box.style.display = onOff;
	if (box) box.contentWindow.focus();
}

function reselect(){
	if (isIE){reselectIE();return;}

	if (!sel || sel == null){
		selOK = false;
		return;
	}
	if (sel.type != "None") return;
	s = document.getElementById("editCtl").contentWindow.getSelection();
	r = s.getRangeAt(0);
	if ( r.inRange(rng) ){
		selOK = true;
		r.setEndPoint("StartToStart", rng);
		r.setEndPoint("EndToEnd", rng);
		r.select();
	} 
	else {
		selOK = false;
	}
}

function setMode(newMode) {
	if (newMode == 'imgEdit' || newMode == 'imgPrev'){
		if (editMode == false){
			document.getElementById("editCtl").contentWindow.document.body.style.font = "10pt arial";
			if (isIE){
				editCtl.document.body.innerHTML=editCtl.document.body.innerText;
			}
			else{
				document.getElementById("editCtl").contentWindow.document.body.innerHTML=document.getElementById("editCtl").contentWindow.document.body.textContent;
			}
		}
		editMode = true;
		if (newMode == 'imgPrev'){
			document.getElementById('SOLAPAS').className = "solA";
			vistaPrevia();
			isPrev = true;
		}
		else{
			document.getElementById('SOLAPAS').className = "solB";
			vistaDiseno();
			isPrev = false;
		}
	}
	if (newMode == 'imgHtml'){
		document.getElementById('SOLAPAS').className = "solC";
		vistaDiseno();
		document.getElementById("editCtl").contentWindow.document.body.style.font = "10pt verdana";
		if (editMode == true){
			if (isIE){
				editCtl.document.body.innerText=editCtl.document.body.innerHTML;
			}
			else{
				document.getElementById("editCtl").contentWindow.document.body.textContent=document.getElementById("editCtl").contentWindow.document.body.innerHTML;
			}
		}
		editMode = false;
		isPrev = false;
	}
	closeAllPopups();
	toggleDisableLayer();
}

function insertLink(lnk){
	if (isIE){
		insertLinkIE(lnk);
	}
	else{
		if ( lnk != "" ) {
			document.getElementById("editCtl").contentWindow.document.execCommand("CreateLink", "", lnk);
		}
		closeAllPopups();
	}
}
/*********************************************************/
/*--------------------------IE---------------------------*/
/*********************************************************/
function insertLinkIE(lnk){
	reselectIE();
	if ( lnk != "" ) {
		if ( sel.type == "None" ) {
			insertHTML("<A HREF=\""+lnk+"\">"+lnk+"</A> ");
		} else {
			editCtl.document.execCommand("CreateLink", "", lnk);
		}
	}
	closeAllPopups();
}
function reselectIE(){
	if (!sel || sel == null){
		selOK = false;
		return;
	}
	if (sel.type != "None") return;
	r = editCtl.document.body.createTextRange();
	if ( r.inRange(rng) ){
		selOK = true;
		r.setEndPoint("StartToStart", rng);
		r.setEndPoint("EndToEnd", rng);
		r.select();
	} else {
		selOK = false;
	}
}