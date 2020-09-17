function getBase(urlBase){
	pos = urlBase.indexOf("//");
	if (pos != -1){
		pos = pos+2;
		urlBasePart = urlBase.substring(pos);
	}else{
		alert("Error: URL Invalida");
	}	
	pos2 = urlBasePart.indexOf("/");
	if (pos2 == -1)
		alert("Error: URL Invalida");
	return urlBase.substring(0,pos2+pos);	
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

function addParameter(urlRet, paramName, paramValue){
	if(paramValue != null && paramValue != ""){
		if(!(urlRet.charAt(urlRet.length-1)=='?'))
			urlRet+= '&';
		urlRet+= paramName+"="+paramValue;
	}
	return urlRet;
}

function makeUrlSearch( word,
   	 categId,
   	 prCategId,
   	 searchBoth,
   	 filtroId,
   	 pciaId,
   	 bnr,
   	 visualId,
   	 filterId,
   	 desde,
   	 qshow,
   	 displayType,
   	 filtroId2,
	 priceMin,
   	 priceMax,
   	 custId,
   	 nickName,
   	 orderId){
   	 	var searchUrl="?";   	 	   	 	 	 	
   	 	searchUrl = addParameter(searchUrl, "as_word", quitaBarra(word));
  	  	searchUrl = addParameter(searchUrl, "as_categ_id", categId);
   	 	searchUrl = addParameter(searchUrl, "as_cust_id", custId);
   	 	searchUrl = addParameter(searchUrl, "as_nickname", nickName);
   	 	searchUrl = addParameter(searchUrl, "as_filter_id", filterId);
   	 	searchUrl = addParameter(searchUrl, "as_pr_categ_id", prCategId);
   	 	searchUrl = addParameter(searchUrl, "as_search_both", searchBoth);   	 		
   	 	searchUrl = addParameter(searchUrl, "as_price_min", priceMin);
   	 	searchUrl = addParameter(searchUrl, "as_price_max", priceMax);
   	 	searchUrl = addParameter(searchUrl, "as_filtro_id", filtroId);
   	 	searchUrl = addParameter(searchUrl, "as_visual_id", visualId);
   	 	searchUrl = addParameter(searchUrl, "bnr", bnr);
   	 	searchUrl = addParameter(searchUrl, "as_pcia_id", pciaId);
   	 	searchUrl = addParameter(searchUrl, "as_display_type", displayType);
   	 	searchUrl = addParameter(searchUrl, "as_order_id", orderId);
   	 	searchUrl = addParameter(searchUrl, "as_filtro_id2", filtroId2);
   	 	searchUrl = addParameter(searchUrl, "as_desde", desde);
   	 	searchUrl = addParameter(searchUrl, "as_qshow", qshow);		
		return searchUrl;
}

function prepareParameter(param){
	var paramValue = "";
	if (param != null)
		if (param.name == "as_search_both" || param.name == "as_categ_id"){
			if (param.checked)
				paramValue=param.value;
		}else{
			paramValue+=escape(param.value);	
		}
	return paramValue	
}

function quitaBarra(str){
            return str.replace(/\//g,'%20');      
}
function isAbsolute(str){	
	pos = str.indexOf("//");
	if (pos != -1){
		return true;
	}else{
		return false;
	}
}
function doSearch(searchForm){
	setCookie("ml_list","searching");
	var searchWord= searchForm.as_word.value;
	setCookie('LAST_SEARCH', searchWord, null);	
	if (isAbsolute(searchForm.action)){
		location.href = searchForm.action+makeUrlSearch(prepareParameter(searchForm.as_word), prepareParameter(searchForm.as_categ_id), prepareParameter(searchForm.as_pr_categ_id), prepareParameter(searchForm.as_search_both), prepareParameter(searchForm.as_filtro_id), prepareParameter(searchForm.as_pcia_id), prepareParameter(searchForm.bnr), prepareParameter(searchForm.as_visual_id), prepareParameter(searchForm.as_filter_id), prepareParameter(searchForm.as_desde), prepareParameter(searchForm.as_qshow), prepareParameter(searchForm.as_display_type), prepareParameter(searchForm.as_filtro_id2), prepareParameter(searchForm.as_price_min), prepareParameter(searchForm.as_price_max), prepareParameter(searchForm.as_cust_id), prepareParameter(searchForm.as_nickname), prepareParameter(searchForm.as_order_id));	
	}else{
		location.href = getBase(document.getElementsByTagName('base')[0].href)+searchForm.action+makeUrlSearch(prepareParameter(searchForm.as_word), prepareParameter(searchForm.as_categ_id), prepareParameter(searchForm.as_pr_categ_id), prepareParameter(searchForm.as_search_both), prepareParameter(searchForm.as_filtro_id), prepareParameter(searchForm.as_pcia_id), prepareParameter(searchForm.bnr), prepareParameter(searchForm.as_visual_id), prepareParameter(searchForm.as_filter_id), prepareParameter(searchForm.as_desde), prepareParameter(searchForm.as_qshow), prepareParameter(searchForm.as_display_type), prepareParameter(searchForm.as_filtro_id2), prepareParameter(searchForm.as_price_min), prepareParameter(searchForm.as_price_max), prepareParameter(searchForm.as_cust_id), prepareParameter(searchForm.as_nickname), prepareParameter(searchForm.as_order_id));	
	}
}

//JAI: Trackeo Buscador
function setSearchCookie(){
   setCookie("search_flag","1",null);
}

function enterKeySearch(e) {
  k = (document.all) ? window.event.keyCode : e.which;
  if (k == 13) {
    setSearchCookie();
  }
}


function setSearchFlags(searchForm){
	// setea flags en cookies para pulse
	setCookie("ml_list","searching");
	var searchWord= searchForm.as_word.value;
	setCookie('LAST_SEARCH', searchWord, null);		
}