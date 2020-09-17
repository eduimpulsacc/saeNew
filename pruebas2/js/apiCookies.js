function getSubdomain(){		
	var dom = ""+window.location.host;
	var pos = dom.indexOf("mercadoli");
	if(pos == -1)
		pos = dom.indexOf("deremate");
	if(pos == -1)
		pos = dom.indexOf("arremate");
	if (pos != -1)	
		dom = dom.substring(pos);		
	return dom;
}
function getCookieValue(name) {
	var start=document.cookie.indexOf(name+"=");
	var len=start+name.length+1;
	if (start == -1) 
		return null;
	var end=document.cookie.indexOf(";",len);
	if (end==-1) 
		end=document.cookie.length;
	return unescape(document.cookie.substring(len,end));
}
function setCookie(cookieName,cookieValue,nDays) {
	setCookie(cookieName,cookieValue,nDays, null);
}		
function deleteCookie(name){
	setCookie(name,tmp,(new Date(1)));
}
function setCookie(cookieName,cookieValue,nDays,path) {
	var subdomain = getSubdomain();
	if (path == null)
		path ="/";
	if(nDays!=null){
		today  = new Date();
		expire = new Date();
		if (nDays==null || nDays==0) 
			nDays=1;
		expire.setTime(today.getTime() + 3600000*24*nDays);								
		document.cookie = cookieName+"="+cookieValue+";path="+path + ";domain=."+ subdomain +  ";expires="+expire.toGMTString();
	}
	else
		document.cookie = cookieName+"="+cookieValue+";path="+path+";domain=."+ subdomain;		
}
function setContextCookie(val){
	var urlBase=document.getElementsByTagName("base")[0].href.replace("www","pmspxl");
	urlBase=urlBase.substring(0,7+urlBase.substring(7).indexOf("/"));
	url = urlBase+"/jm/PmsPixel?ck="+val;
	var pixelDiv = document.getElementById("pmspxl");
	if(pixelDiv!=null)
		pixelDiv.innerHTML="<img width=0 height=0 src='"+url+"'>";
}	