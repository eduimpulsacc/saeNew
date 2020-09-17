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

function f_logout(){
	setCookie("orguseridp","0",null);
 	setCookie("orghash","0",null);
 	setCookie("orgnickp","0",null);
 	setCookie("orguserid","0",null);
 	setCookie("orgpago","0",null);
 	setCookie("pr_categ","",null);
 	setCookie("member","1",null);
	location.href=(top.location.pathname+top.location.search); 
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
function home(){
	dir = '/';
	if(getCookieValue("home")!=null && getCookieValue("home")!='')
		dir+=getCookieValue("home");
	location.href=dir;
}
function getTrackCookie(){
  if(getCookieValue("clicked")== null || getCookieValue("clicked")=="0"){	
  	var value = getCookieValue("track_info");
  	if(value!=null){
  		arrayKeys = value.split(":");   	
  		var out = "/jm/ml.track.me?save_ck=N";
  		for (i=1; i < arrayKeys.length; i++)
    		out += "&k"+i+"="+arrayKeys[i];
		var img = new Image().src = out;
	  	setCookie("clicked","1",null);
  	}
  }
}
function getBase(urlBase){
	pos = urlBase.indexOf("//")+2;
	if (pos != -1){
		urlBasePart = urlBase.substring(pos);
	}else{
		alert("Error: URL Invalida");
	}
	
	pos2 = urlBasePart.indexOf("/")+pos;
	
	if (pos2 == -1)
		alert("Error: URL Invalida");
		
	return urlBase.substring(0,pos2);	
}

function setPrCategLink(lnk)
{
    var c=getCookieValue("pr_categ");
    if (c==null) 
    	c="";

    if (lnk.substring(0,1)=="/"){
    	base = getBase(document.getElementsByTagName('base')[0].href);
    }else{
    	base = document.getElementsByTagName('base')[0].href;
    }    	    
    window.location=base+lnk+"&as_pr_categ_id="+c;
}