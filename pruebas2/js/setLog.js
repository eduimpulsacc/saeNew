function getUrlPath(str){
            pos = str.indexOf("//");
            pos = str.indexOf("/",pos+2);
            relative = str.substring(pos);
            pos= relative.indexOf("?");
            return relative.substring(0, pos);
}

function getUrlQueryString(str){
            pos = str.indexOf("//");
            pos = str.indexOf("/",pos+2);
            relative = str.substring(pos);
            pos= relative.indexOf("?");
            return relative.substring(pos);
}

function setLog(){
	v = window.location.pathname;
	if ( v.indexOf("jms") > 0 || v.indexOf("org_item_abm") > 0 || v.indexOf("org_item_categ") > 0 || v.indexOf("l_calif.calif_users") > 0 || v.indexOf("l_calif.my_calif") > 0 || v.indexOf("l_calif.replay_users") > 0 || v.indexOf("l_calif.my_history") > 0 || v.indexOf("org_bid.ofertar") > 0 || v.indexOf("org_bid_new.ofertar") > 0 || v.indexOf("org_pago_placetopay") > 0 || v.indexOf("org_pagoitu") > 0)
	return;
	ck = getCookieValue("orguserid");

	urlPath= self.location.pathname;
	urlQueryString= self.location.search;
	try{
		if(oldUrl!=null){
			urlPath= getUrlPath(oldUrl);
			urlQueryString= getUrlQueryString(oldUrl);
		}
	}
	catch(Exception){
	}


	if (ck==null||ck.length < 4 ){
		document.write("<a target=\"_top\" href=\"org_validate.user_login?as_url="+urlPath+"&as_user=&as_password=&as_nav_bar=Y&as_params="+escape(urlQueryString)+"\" class=hpcateg id=\"MENU:ENTRAR\">Entrar</a>");
		} else {
			document.write("<a target=\"_top\" href=\"/jm/logout\" class=hpcateg id=\"MENU:SALIR\">Salir</a>");

		}
}

function setLogPMS(){
	v = window.location.pathname;
	if ( v.indexOf("jms") > 0 || v.indexOf("org_item_abm") > 0 || v.indexOf("org_item_categ") > 0 || v.indexOf("l_calif.calif_users") > 0 || v.indexOf("l_calif.my_calif") > 0 || v.indexOf("l_calif.replay_users") > 0 || v.indexOf("l_calif.my_history") > 0 || v.indexOf("org_bid.ofertar") > 0 || v.indexOf("org_bid_new.ofertar") > 0 || v.indexOf("org_pago_placetopay") > 0 || v.indexOf("org_pagoitu") > 0)
	return;
	ck = getCookieValue("orguserid");

	urlPath= self.location.pathname;
	urlPath = urlPath.substr(1,urlPath.length);
	urlQueryString= self.location.search;
	try{
		if(oldUrl!=null){
			urlPath= getUrlPath(oldUrl);
			urlQueryString= getUrlQueryString(oldUrl);
		}
	}
	catch(Exception){
	}


	if (ck==null||ck.length < 4 ){
		document.write("<a target=\"_top\" href=\"/jm/login?url="+escape(urlPath)+escape(urlQueryString)+"\" class=hpcateg id=\"MENU:ENTRAR\">Entrar</a>");
		} else {
			document.write("<a target=\"_top\" href=\"/jm/logout\" class=hpcateg id=\"MENU:SALIR\">Salir</a>");

		}
}