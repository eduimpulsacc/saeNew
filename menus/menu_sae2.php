<? 
require('../util/header.php');

$posp           =$_POSP;
$perfil_user    =$_PERFIL;
$institucion	=$_INSTIT;
$ano            =$_ANO;

if ($ano == NULL){
 $qry="SELECT id_institucion, id_ano, situacion from ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
 $result = @pg_Exec($conn,$qry);
 $filaaux = @pg_fetch_array($result,0);	
 $_ANO=$filaaux["id_ano"];
 $ano = $_ANO;
}  

  $qry_info = "select info_colegio from institucion where rdb = '$institucion'";
  $res_info = @pg_Exec($conn,$qry_info);
  $fila_info = @pg_fetch_array($res_info,0);
  $_INFO = $fila_info['info_colegio']; 

$location = dirname($_SERVER['PHP_SELF']); 
$arr = split('/', $location); 
$num = count($arr); 


$frmModo="ingresar";
$num = $num - 0; 

echo $sql ="SELECT id_menu,id_categoria,id_item FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$perfil_user;
$rs_perfil = pg_exec($conn,$sql) or die("SELECT FALLO :".$sql);


?>


<? /////////////////////////////////////////////////////////////////////////////
		// Este codigo permite al menu de la cabecera poder encontrar las imagenes en forma automatica
		
		$w = 0;
		$posp = $posp -2;
		$c = "sae3.0/";
		$e = "";
		$d = "";
		$ca = "";
		
		while ($w < $num){ // while de imagenes
		$e = $d;
		$d = $c;
		$c = "../".$c;
		$ca = $c."../";
		$w++; 
		}




////////////////////////////////////////////////////////////////////////////////////////////////

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en"><head><title></title><meta http-equiv="Content-Type" content="text/html; charset="/>

<!-- *** QuickMenu copyright (c) 2009, OpenCube Inc. All Rights Reserved.

	-QuickMenu may be manually customized by editing this document, or open this web page / menu
	 with the QuickMenu Visual Interface (File - Open).

-->


<!--%%%%%%%%%%%% QuickMenu Styles [Keep in head for full validation!] %%%%%%%%%%%-->
<style type="text/css">


/*!!!!!!!!!!! QuickMenu Core CSS [Do Not Modify!] !!!!!!!!!!!!!*/
/*[START-QCC]*/.qmmc .qmdivider{display:block;font-size:1px;border-width:0px;border-style:solid;position:relative;z-index:1;}.qmmc .qmdividery{float:left;width:0px;}.qmmc .qmtitle{display:block;cursor:default;white-space:nowrap;position:relative;z-index:1;}.qmclear {font-size:1px;height:0px;width:0px;clear:left;line-height:0px;display:block;float:none !important;}.qmmc {position:relative;zoom:1;z-index:10;}.qmmc a, .qmmc li {float:left;display:block;white-space:nowrap;position:relative;z-index:1;}.qmmc div a, .qmmc ul a, .qmmc ul li {float:none;}.qmsh div a {float:left;}.qmmc div{visibility:hidden;position:absolute;}.qmmc .qmcbox{cursor:default;display:inline-block;position:relative;z-index:1;}.qmmc .qmcbox a{display:inline;}.qmmc .qmcbox div{float:none;position:static;visibility:inherit;left:auto;}.qmmc li {z-index:auto;}.qmmc ul {left:-10000px;position:absolute;z-index:10;}.qmmc, .qmmc ul {list-style:none;padding:0px;margin:0px;}.qmmc li a {float:none;}.qmmc li:hover>ul{left:auto;}/*[END-QCC]*//*[START-QCC0]*/#qm0 li, #qm0 a {float:none;}#qm0 li:hover>ul{top:0px;left:100%;}/*[END-QCC0]*/


/*!!!!!!!!!!! QuickMenu Styles [Please Modify!] !!!!!!!!!!!*/


	/* QuickMenu 0 */

	/*"""""""" (MAIN) Container""""""""*/	
	#qm0	
	{	
		width:200px;
		background-color:transparent;
		border-width:0px 0px 1px 0px;
		border-style:solid;
		border-color:#858585;
	}


	/*"""""""" (MAIN) Items""""""""*/	
	#qm0 a	
	{	
		padding:8px 40px 8px 8px;
		background-color:#BED0B6;
		color:#333333;
		font-family:Verdana;
		font-size:11px;
		text-decoration:none;
		text-align:left;
		border-width:1px 1px 0px 1px;
		border-style:solid;
		border-color:#5C7A4E;
	}


	/*"""""""" (MAIN) Hover State""""""""*/	
	#qm0 a:hover	
	{	
		text-decoration:underline;
	}


	/*"""""""" (MAIN) Hover State - (duplicated for pure CSS)""""""""*/	
	#qm0 li:hover>a	
	{	
		text-decoration:underline;
	}


	/*"""""""" (MAIN) Parent Hover State""""""""*/	
	#qm0 .qmparent:hover	
	{	
		background-color:#99B48A;
	}


	/*"""""""" (MAIN) Active State""""""""*/	
	body #qm0 .qmactive, body #qm0 .qmactive:hover	
	{	
		background-color:#99B48A;
		text-decoration:underline;
	}


	/*"""""""" (SUB) Container""""""""*/	
	#qm0 div, #qm0 ul	
	{	
		padding:10px 5px 10px 5px;
		margin:0px;
		background-color:#ECF1E9;
		border-width:1px;
		border-style:solid;
		border-color:#858585;
	}


	/*"""""""" (SUB) Items""""""""*/	
	#qm0 div a, #qm0 ul a	
	{	
		padding:2px 40px 2px 5px;
		background-color:transparent;
		color:#333333;
		font-size:11px;
		border-width:1px 0px 1px 0px;
		border-style:solid;
		border-color:#ECF1E9;
	}


	/*"""""""" (SUB) Hover State""""""""*/	
	#qm0 div a:hover	
	{	
		text-decoration:underline;
	}


	/*"""""""" (SUB) Hover State - (duplicated for pure CSS)""""""""*/	
	#qm0 ul li:hover>a	
	{	
		text-decoration:underline;
	}


	/*"""""""" (SUB) Parent Hover State""""""""*/	
	#qm0 div .qmparent:hover	
	{	
		background-color:transparent;
	}


	/*"""""""" (SUB) Active State""""""""*/	
	body #qm0 div .qmactive, body #qm0 div .qmactive:hover	
	{	
		background-color:#BED0B6;
		text-decoration:none;
		border-style:solid;
		border-color:#556F46;
	}


	/*"""""""" Individual Titles""""""""*/	
	#qm0 .qmtitle	
	{	
		cursor:default;
		padding:3px 0px 3px 4px;
		color:#333333;
		font-family:arial;
		font-size:11px;
		font-weight:bold;
	}


	/*"""""""" Individual Horizontal Dividers""""""""*/	
	#qm0 .qmdividerx	
	{	
		border-top-width:1px;
		margin:4px 0px 4px 0px;
		border-color:#BFBFBF;
	}


	/*"""""""" Individual Vertical Dividers""""""""*/	
	#qm0 .qmdividery	
	{	
		border-left-width:1px;
		height:15px;
		margin:4px 2px 0px 2px;
		border-color:#BFBFBF;
	}


	/*"""""""" Custom Rule""""""""*/	
	ul#qm0 .qmparent	
	{	
		background-image:url(file:///C:/Archivos%20de%20programa/OpenCube/Visual%20CSS%20QuickMenu/chrome/content/qmimages/cssalt1_arrow_right.gif);
		background-repeat:no-repeat;
		background-position:95% 50%;
	}


	/*"""""""" Custom Rule""""""""*/	
	ul#qm0 ul .qmparent	
	{	
		background-image:url(file:///C:/Archivos%20de%20programa/OpenCube/Visual%20CSS%20QuickMenu/chrome/content/qmimages/cssalt1_arrow_right.gif);
	}


	/*"""""""" Custom Rule""""""""*/	
	ul#qm0 ul	
	{	
		margin:0px 0px 0px -1px;
	}


	/*"""""""" Custom Rule""""""""*/	
	ul#qm0 ul li:hover > a.qmparent	
	{	
		background-color:#BED0B6;
		background-image:url(file:///C:/Archivos%20de%20programa/OpenCube/Visual%20CSS%20QuickMenu/chrome/content/qmimages/cssalt1_arrow_right_hover.gif);
		text-decoration:underline;
		border-color:#556F46;
	}


	/*"""""""" Custom Rule""""""""*/	
	ul#qm0 li:hover > a.qmparent	
	{	
		background-color:#99B48A;
		background-image:url(file:///C:/Archivos%20de%20programa/OpenCube/Visual%20CSS%20QuickMenu/chrome/content/qmimages/cssalt1_arrow_right_hover.gif);
	}
	/*[END-QS0]*/


</style>

<!-- Add-On Core Code (Remove when not using any add-on's) -->
<!--[START-QZ]--><style type="text/css">.qmfv{visibility:visible !important;}.qmfh{visibility:hidden !important;}body {

}
</style><script type="text/javascript">if (!window.qmad){qmad=new Object();qmad.binit="";qmad.bvis="";qmad.bhide="";}</script><!--[END-QZ]-->

	<!-- Add-On Settings -->
	<script type="text/JavaScript">

		/*******  Menu 0 Add-On Settings *******/
		var a = qmad.qm0 = new Object();

		// Item Bullets (CSS - Imageless) Add On
		a.ibcss_apply_to = "parent";
		a.ibcss_main_type = "arrow";
		a.ibcss_main_direction = "down";
		a.ibcss_main_size = 6;
		a.ibcss_main_bg_color = "#99b48a";
		a.ibcss_main_bg_color_hover = "#bed0b6";
		a.ibcss_main_bg_color_active = "#bed0b6";
		a.ibcss_main_border_color = "#556F46";
		a.ibcss_main_position_x = -19;
		a.ibcss_main_position_y = -8;
		a.ibcss_main_align_x = "right";
		a.ibcss_main_align_y = "middle";
		a.ibcss_sub_type = "arrow";
		a.ibcss_sub_direction = "down";
		a.ibcss_sub_size = 5;
		a.ibcss_sub_bg_color = "#99b48a";
		a.ibcss_sub_bg_color_hover = "#bed0b6";
		a.ibcss_sub_bg_color_active = "#bed0b6";
		a.ibcss_sub_border_color = "#556F46";
		a.ibcss_sub_position_x = -16;
		a.ibcss_sub_align_x = "right";
		a.ibcss_sub_align_y = "middle";

		// Tree Menu Add On
		a.tree_enabled = true;
		a.tree_auto_collapse = "chain";
		a.tree_mouseover = true;
		a.tree_hide_focus_box = true;
		a.tree_expand_animation = 2;
		a.tree_expand_step_size = 2;
		a.tree_collapse_animation = 2;
		a.tree_collapse_step_size = 2;

		/*[END-QA0]*/

	</script>

<!-- Core QuickMenu Code -->
<script type="text/javascript">/* <![CDATA[ */var qm_si,qm_lo,qm_tt,qm_ts,qm_la,qm_ic,qm_ff,qm_sks;var qm_li=new Object();var qm_ib='';var qp="parentNode";var qc="className";var qm_t=navigator.userAgent;var qm_o=qm_t.indexOf("Opera")+1;var qm_s=qm_t.indexOf("afari")+1;var qm_s2=qm_s&&qm_t.indexOf("ersion/2")+1;var qm_s3=qm_s&&qm_t.indexOf("ersion/3")+1;var qm_n=qm_t.indexOf("Netscape")+1;var qm_v=parseFloat(navigator.vendorSub);var qm_ie8=qm_t.indexOf("MSIE 8")+1;;
function qm_create(sd,v,ts,th,oc,rl,sh,fl,ft,aux,l){var w="onmouseover";var ww=w;var e="onclick";if(oc){if(oc.indexOf("all")+1||(oc=="lev2"&&l>=2)){w=e;ts=0;}if(oc.indexOf("all")+1||oc=="main"){ww=e;th=0;}}if(!l){l=1;sd=document.getElementById("qm"+sd);if(window.qm_pure)sd=qm_pure(sd);sd[w]=function(e){try{qm_kille(e)}catch(e){}};if(oc!="all-always-open")document[ww]=qm_bo;if(oc=="main"){qm_ib+=sd.id;sd[e]=function(event){qm_ic=true;qm_oo(new Object(),qm_la,1);qm_kille(event)};}sd.style.zoom=1;if(sh)x2("qmsh",sd,1);if(!v)sd.ch=1;}else  if(sh)sd.ch=1;if(oc)sd.oc=oc;if(sh)sd.sh=1;if(fl)sd.fl=1;if(ft)sd.ft=1;if(rl)sd.rl=1;sd.th=th;sd.style.zIndex=l+""+1;var lsp;var sp=sd.childNodes;for(var i=0;i<sp.length;i++){var b=sp[i];if(b.tagName=="A"){eval();lsp=b;b[w]=qm_oo;if(w==e)b.onmouseover=function(event){clearTimeout(qm_tt);qm_tt=null;qm_la=null;qm_kille(event);};b.qmts=ts;if(l==1&&v){b.style.styleFloat="none";b.style.cssFloat="none";}}else  if(b.tagName=="DIV"){if(window.showHelp&&!window.XMLHttpRequest)sp[i].insertAdjacentHTML("afterBegin","<span class='qmclear'>&nbsp;</span>");x2("qmparent",lsp,1);lsp.cdiv=b;b.idiv=lsp;if(qm_n&&qm_v<8&&!b.style.width)b.style.width=b.offsetWidth+"px";new qm_create(b,null,ts,th,oc,rl,sh,fl,ft,aux,l+1);}}if(l==1&&window.qmad&&qmad.binit){ eval(qmad.binit);}};
function qm_bo(e){
	e=e||event;if(e.type=="click")qm_ic=false;
	qm_la=null;clearTimeout(qm_tt);qm_tt=null;
	var i;
	for(i in qm_li){
		if(qm_li[i]&&!((qm_ib.indexOf(i)+1)&&e.type=="mouseover"))
			qm_tt=setTimeout("x0('"+i+"')",qm_li[i].th);
	}
};
function qm_co(t){
	var f;
	for(f in qm_li){
		if(f!=t&&qm_li[f])
			x0(f);
	}
};
function x0(id){
	var i;
	var a;
	var a;
	if((a=qm_li[id])&&qm_li[id].oc!="all-always-open"){
		do{
			qm_uo(a);
		}
		while((a=a[qp])&&!qm_a(a));qm_li[id]=null;}};
function qm_a(a){if(a[qc].indexOf("qmmc")+1)return 1;};
function qm_uo(a,go){if(!go&&a.qmtree)return;if(window.qmad&&qmad.bhide)eval(qmad.bhide);a.style.visibility="";x2("qmactive",a.idiv);};
function qm_oo(e,o,nt){try{if(!o)o=this;if(qm_la==o&&!nt)return;if(window.qmv_a&&!nt)qmv_a(o);if(window.qmwait){qm_kille(e);return;}clearTimeout(qm_tt);qm_tt=null;qm_la=o;if(!nt&&o.qmts){qm_si=o;qm_tt=setTimeout("qm_oo(new Object(),qm_si,1)",o.qmts);return;}var a=o;if(a[qp].isrun){qm_kille(e);return;}while((a=a[qp])&&!qm_a(a)){}var d=a.id;a=o;qm_co(d);if(qm_ib.indexOf(d)+1&&!qm_ic)return;var go=true;while((a=a[qp])&&!qm_a(a)){if(a==qm_li[d])go=false;}if(qm_li[d]&&go){a=o;if((!a.cdiv)||(a.cdiv&&a.cdiv!=qm_li[d]))qm_uo(qm_li[d]);a=qm_li[d];while((a=a[qp])&&!qm_a(a)){if(a!=o[qp]&&a!=o.cdiv)qm_uo(a);else break;}}var b=o;var c=o.cdiv;if(b.cdiv){var aw=b.offsetWidth;var ah=b.offsetHeight;var ax=b.offsetLeft;var ay=b.offsetTop;if(c[qp].ch){aw=0;if(c.fl)ax=0;}else {if(c.ft)ay=0;if(c.rl){ax=ax-c.offsetWidth;aw=0;}ah=0;}if(qm_o){ax-=b[qp].clientLeft;ay-=b[qp].clientTop;}if((qm_s2&&!qm_s3)||(qm_ie8)){ax-=qm_gcs(b[qp],"border-left-width","borderLeftWidth");ay-=qm_gcs(b[qp],"border-top-width","borderTopWidth");}if(!c.ismove){c.style.left=(ax+aw)+"px";c.style.top=(ay+ah)+"px";}x2("qmactive",o,1);if(window.qmad&&qmad.bvis)eval(qmad.bvis);c.style.visibility="inherit";qm_li[d]=c;}else  if(!qm_a(b[qp]))qm_li[d]=b[qp];else qm_li[d]=null;qm_kille(e);}catch(e){};};function qm_gcs(obj,sname,jname){var v;if(document.defaultView&&document.defaultView.getComputedStyle)v=document.defaultView.getComputedStyle(obj,null).getPropertyValue(sname);else  if(obj.currentStyle)v=obj.currentStyle[jname];if(v&&!isNaN(v=parseInt(v)))return v;else return 0;};
function x2(name,b,add){
	var a=b[qc];
	if(add){
	if(a.indexOf(name)==-1)
		b[qc]+=(a?' ':'')+name;
	}else {
		b[qc]=a.replace(" "+name,"");
		b[qc]=b[qc].replace(name,"");
	}
};
function qm_kille(e){
	if(!e) e=event;e.cancelBubble=true;
	if(e.stopPropagation&&!(qm_s&&e.type=="click"))e.stopPropagation(); }
	if(window.name=="qm_copen"&&!window.qmv){
		document.write('<scr'+'ipt type="text/javascript" src="file:///C:/Archivos de programa/OpenCube/Visual CSS QuickMenu/chrome/content/qm_visual.js"></scr'+'ipt>')
	};
		function qa(a,b){return String.fromCharCode(a.charCodeAt(0)-(b-(parseInt(b/2)*2)));};;function qm_pure(sd){if(sd.tagName=="UL"){var nd=document.createElement("DIV");nd.qmpure=1;var c;if(c=sd.style.cssText)nd.style.cssText=c;qm_convert(sd,nd);var csp=document.createElement("SPAN");csp.className="qmclear";csp.innerHTML="&nbsp;";nd.appendChild(csp);sd=sd[qp].replaceChild(nd,sd);sd=nd;}return sd;};function qm_convert(a,bm,l){if(!l)bm[qc]=a[qc];bm.id=a.id;var ch=a.childNodes;for(var i=0;i<ch.length;i++){if(ch[i].tagName=="LI"){var sh=ch[i].childNodes;for(var j=0;j<sh.length;j++){if(sh[j]&&(sh[j].tagName=="A"||sh[j].tagName=="SPAN"))bm.appendChild(ch[i].removeChild(sh[j]));if(sh[j]&&sh[j].tagName=="UL"){var na=document.createElement("DIV");var c;if(c=sh[j].style.cssText)na.style.cssText=c;if(c=sh[j].className)na.className=c;na=bm.appendChild(na);new qm_convert(sh[j],na,1)}}}}}/* ]]> */</script>

<!-- Add-On Code: Tree Menu -->
<script type="text/javascript">/* <![CDATA[ */qmad.br_navigator=navigator.userAgent.indexOf("Netscape")+1;qmad.br_version=parseFloat(navigator.vendorSub);qmad.br_oldnav=qmad.br_navigator&&qmad.br_version<7.1;qmad.br_strict=(dcm=document.compatMode)&&dcm=="CSS1Compat";qmad.br_ie=window.showHelp;qmad.tree=new Object();qmad.tree.fixie=!qmad.br_strict&&qmad.br_ie;if(qmad.bvis.indexOf("qm_tree_item_click(b.cdiv);")==-1){qmad.bvis+="qm_tree_item_click(b.cdiv);";qm_tree_init_styles();qmad.binit+="qm_tree_init(null,sd.id);";};function qm_tree_init_styles(){var a,b;if(qmad){var i;for(i in qmad){if(i.indexOf("qm")!=0||i.indexOf("qmv")+1)continue;var ss=qmad[i];if(ss.tree_width)ss.tree_enabled=true;if(ss&&ss.tree_enabled){var az="";if(qmad.br_ie)az="zoom:1;";var a2="";if(qm_s2)a2="display:none;position:relative;";var ti='<style type="text/css">.qmistreestyles'+i+'{}  #'+i+'{position:relative !important;} #';var dst='width:auto !important;left:0px !important;top:0px !important;overflow:hidden;'+a2+az+'margin-left:0px !important;margin-top:0px !important;border-bottom-width:0px !important;border-top-width:0px !important;';if(ss.tree_auto_collapse=="fixed-height"){var a3=' #'+i+' div div{position:absolute !important;} #'+i+' .qmtreemshshow{overflow:visible !important;}';var wv=ti+i+' .qmtreemshstd{'+dst+'} #'+i+' .qmtreemshstda{float:none !important;white-space:normal !important;'+az+'}'+a3;}else {var wv=ti+i+' a{float:none !important;white-space:normal !important;'+az+'}#'+i+' div{'+dst+'}';if(ss.tree_sub_sub_indent)wv+='#'+i+' div div{padding-left:'+ss.tree_sub_sub_indent+'px;}';}document.write(wv+'</style>');}}}};function qm_tree_init(event,spec){var q=qmad.tree;var a,b;var i;for(i in qmad){if(i.indexOf("qm")!=0||i.indexOf("qmv")+1||i.indexOf("qms")+1||(spec!=i))continue;var ss=qmad[i];if(ss&&ss.tree_enabled){q.estep=ss.tree_expand_step_size;if(!q.estep)q.estep=1;q.mo=ss.tree_mouseover;q.acollapse=ss.tree_auto_collapse;var t=q.acollapse;if(t=="fixed-height")q.msh=true;else  if(t=="sync")q.sync=true;else  if(t=="chain")q.chain=true;else  if(t=="false"||!t){q.acollapse=false;q.mo=false;}else  if(t)q.chain=true;q.cstep=ss.tree_collapse_step_size;if(!q.cstep)q.cstep=1;q.no_focus=ss.tree_hide_focus_box;q.etype=ss.tree_expand_animation;if(q.etype)q.etype=parseInt(q.etype);if(qmad.tree.fixie||!q.etype)q.etype=0;q.ctype=ss.tree_collapse_animation;if(q.ctype)q.ctype=parseInt(q.ctype);if(qmad.tree.fixie||!q.ctype)q.ctype=0;if(qmad.br_oldnav){q.etype=0;q.ctype=0;}qm_tree_init_items(document.getElementById(i));}i++;}};function qm_tree_set_atag_classes(obj){ch=obj.childNodes;for(var i=0;i<ch.length;i++){if(ch[i]&&ch[i].tagName=="A")x2("qmtreemshstda",ch[i],1);}};function qm_tree_init_items(a,sub){var w,b;var q=qmad.tree;var aa;if(q.msh&&!sub){qm_tree_set_atag_classes(a);aa=a.getElementsByTagName("DIV");var mh=0;for(var j=0;j<aa.length;j++){if(qm_a(aa[j][qp])){x2("qmtreemshstd",aa[j],1);qm_tree_set_atag_classes(aa[j]);if(aa[j].offsetHeight>mh)mh=aa[j].offsetHeight;}}for(var j=0;j<aa.length;j++){var st=mh - aa[j].offsetHeight;if(qm_a(aa[j][qp])&&st>0){sp=document.createElement("SPAN");sp.style.display="block";sp.style.fontSize="1px";sp.style.height=st+"px";sp.style.lineHeight=st+"px";sp.qmtreespanah=1;sp.noselect=1;aa[j].appendChild(sp);}}}aa=a.childNodes;for(var j=0;j<aa.length;j++){if(aa[j].tagName=="A"){var h=aa[j].cdiv;var f=aa[j];if(h){if(!q.msh||qm_a(h[qp])){h.qmtree=1;h.ismove=1;}}if(!window.qmv){if((q.mo&&q.acollapse)||(q.msh&&(sub))){if(f.onclick){f.onmouseover=f.onclick;f.onclick=null;}}else {f.qmts=0;if(!f.onclick){f.onclick=f.onmouseover;f.onmouseover=null;}}}if(q.no_focus){f.onfocus=function(){this.blur();};}if(f.cdiv)new qm_tree_init_items(f.cdiv,1);if(f.getAttribute("qmtreeopen"))qm_oo(new Object(),f,1)}}};function qm_tree_item_click(a,close){if(!a.qmtree)return;var q=qmad.tree;if(q.msh&&!qm_a(a[qp]))return;if((z=window.qmv)&&(z=z.addons)&&(z=z.tree_menu)&&!z["on"+qm_index(a)])return;x2("qmfh",a);if(q.timer)return;qm_la=null;if(!q.co)q.co=new Object();if(a.style.position=="relative"){if(!q.mo&&!q.msh){cx=true;q.co["b"]=a;q.co["b"].qmtreecollapse=true;qm_tree_get_dd(a,q,q.co["b"]);qm_uo(a,1);qm_tree_item_expand(false,"b");if(window.qm_fade_a)qm_fade_a(a,1,1);var d=a.getElementsByTagName("DIV");for(var i=0;i<d.length;i++){if(d[i].idiv&&d[i].style.position=="relative"){q.co["b"+i]=d[i];q.co["b"+i].qmtreecollapse=true;qm_tree_get_dd(d[i],q,q.co["b"+i]);qm_uo(d[i],1);qm_tree_item_expand(false,"b"+i);if(window.qm_fade_a)qm_fade_a(d[i],1,1);}}if(window.qm_ibullets_hover)qm_ibullets_hover(null,a.idiv);}}else {if(q.msh&&q.co.e){if(q.lh&&q.lh!=a)qm_uo(q.lh,1);x2("qmfv",a);x2("qmfh",a,1);q.lh=a;return;}if(window.qm_fade_clear_timer)qm_fade_clear_timer(a);a.qmtreecollapse=false;if(qm_s2)a.style.display="block";q.co.e=a;qm_tree_get_dd(a,q,q.co.e);q.co.e.topd=true;q.co.e.cend=false;q.co.e.botd=true;if(a.qmtree_toppad){a.style.paddingTop="0px";q.co.e.topd=false;a.qmtree_tp=0;}if(a.qmtree_botpad){a.style.paddingBottom="0px";q.co.e.botd=false;a.qmtree_bp=0;}a.style.position="relative";q.eh=a.offsetHeight;a.style.height="0px";x2("qmfv",a,1);x2("qmfh",a);var sq='';if(!q.chain){sq=qm_tree_acol(a,q.msh);if(q.co[sq]){x2("qmtreemshshow",q.co[sq]);if(window.qm_fade_a)qm_fade_a(q.co[sq],1,1);}}if(q.msh)x2("qmtreemshshow",a);qm_tree_item_expand(true,"e",sq);if(window.qm_fade_a)qm_fade_a(a,false,1);}};function qm_tree_acol(a,gval){var q=qmad.tree;if(q.acollapse){var mobj=qm_get_menu(a);var ds=mobj.getElementsByTagName("DIV");for(var i=0;i<ds.length;i++){if(ds[i].style.position=="relative"&&ds[i]!=a){var go=true;var cp=a[qp];while(!qm_a(cp)){if(ds[i]==cp)go=false;cp=cp[qp];}if(go&&!q.co["a"+i]){cx=true;q.co["a"+i]=ds[i];q.co["a"+i].qmtreecollapse=true;qm_tree_get_dd(ds[i],q,q.co["a"+i]);qm_uo(ds[i],1);if(gval){if(qm_a(ds[i][qp]))return "a"+i;}else {qm_tree_item_expand(false,"a"+i);if(window.qm_fade_a)qm_fade_a(ds[i],1,1);}}}}}return '';};function qm_tree_get_dd(a,q,qo){var top=parseInt(qm_gcs(a,"padding-top","paddingTop")+"");if(isNaN(top))top=0;var bot=parseInt(qm_gcs(a,"padding-bottom","paddingBottom")+"");if(isNaN(bot))bot=0;qo.qmtree_toppad=top;qo.qmtree_botpad=bot;qo.qmtree_tpad=top+bot;qo.dist=a.offsetHeight;if(q.ctype==2)qo.dec_pos=qo.dist;else qo.dec_pos=1};function qm_tree_item_expand(isexp,i,ic){var q=qmad.tree;var go=false;var cs=1;var g=q.co[i];var h=q.co[ic];if(g){var t=g.style;if(!isexp){if(!t.height&&t.position=="relative"){t.height=(g.offsetHeight-g.qmtree_tpad)+"px";g.qmtreeht=parseInt(t.height);}cs=parseInt(Math.sqrt(2*g.dec_pos*(.2*q.cstep)));if(cs<1)cs=1;if(q.ctype==1)g.dec_pos+=cs;else  if(q.ctype==2)g.dec_pos-=cs;else  if(q.ctype==3){cs=q.cstep;g.dec_pos+=cs;}else cs=g.dist;if(q.ctype&&(g.dec_pos>0&&g.dec_pos<g.dist)){var sh=parseInt(t.height);if(sh-cs<=0){t.height="0px";if(g.qmtree_botpad-cs>0){g.qmtree_botpad -=cs;t.paddingBottom=g.qmtree_botpad+"px";}else  if(g.qmtree_toppad-cs>0){g.qmtree_toppad -=cs;t.paddingTop=g.qmtree_toppad+"px";}}else {var sh1=sh-cs;if(sh1<0)sh1=0;t.height=sh1+"px";}go=true;}else {qm_tree_finish_collapse(g);}}else {if(q.etype==1){cs=parseInt(Math.sqrt(2*g.dec_pos*(.2*q.estep)));if(cs<1)cs=1;g.dec_pos+=cs;}else  if(q.etype==2){cs=parseInt(Math.sqrt(2*g.dec_pos*(.2*q.estep)));if(cs<1)cs=1;g.dec_pos-=cs;}else  if(q.etype==3){cs=q.estep;g.dec_pos+=cs;}else cs=g.dist;go=true;if(g.qmtree_toppad&&!g.topd){if(q.etype&&g.qmtree_tp<g.qmtree_toppad-cs){g.qmtree_tp+=cs;t.paddingTop=g.qmtree_tp+"px";if(ic)h.style.paddingBottom=g.qmtree_toppad-g.qmtree_tp+"px";}else {if(ic)h.style.paddingBottom=0+"px";t.paddingTop=g.qmtree_toppad+"px";g.qmtree_toppad=0;g.topd=true;}}if(g.topd&&!g.cend){if(q.etype&&parseInt(t.height)<(q.eh-cs)){t.height=parseInt(t.height)+cs+"px";if(ic)h.style.height=q.eh-parseInt(t.height)+"px";}else {if(ic)h.style.height="0px";g.qmtreeh=t.height;t.height="";g.cend=true;if(g.botd)go=false;}}if(g.qmtree_botpad&&g.cend&&!g.botd){if(q.etype&&g.qmtree_bp<g.qmtree_botpad-cs){g.qmtree_bp+=cs;t.paddingBottom=g.qmtree_bp+"px";if(ic)h.style.paddingTop=(g.qmtree_botpad-g.qmtree_bp)+"px";}else {if(ic)qm_tree_finish_collapse(h);t.paddingBottom=g.qmtree_botpad+"px";g.qmtree_botpad=0;g.botd=true;go=false;}}}}if(go){if(!q.mo)qmwait=true;if(g)g.timer=setTimeout("qm_tree_item_expand("+isexp+",'"+i+"','"+ic+"')",10);if(window.qmv_position_pointer)qmv_position_pointer();}else {if(!q.mo)qmwait=false;if(g){if(isexp&&q.chain)qm_tree_acol(g);if(q.msh)x2("qmtreemshshow",g,1);g.timer=null;q.co[i]=null;}q.co[ic]=null;if(q.lh&&q.lh.idiv.className.indexOf("qmactive")>-1){qm_oo(new Object(),q.lh.idiv);q.lh=null;}if(window.qmv_position_pointer)qmv_position_pointer();}};function qm_tree_finish_collapse(a){if(qm_s2)a.style.display="";a.style.paddingBottom="";a.style.paddingTop="";a.style.height="";a.style.position="";x2("qmfh",a,1);x2("qmfv",a);a.style.visibility="inherit";qm_uo(a,1);};function qm_get_menu(a){while(!qm_a(a)&&(a=a[qp]))continue;return a;}/* ]]> */</script>

<!-- Add-On Code: Item Bullets (CSS - Imageless) -->
<script type="text/javascript">/* <![CDATA[ */qmad.br_navigator=navigator.userAgent.indexOf("Netscape")+1;qmad.br_version=parseFloat(navigator.vendorSub);qmad.br_oldnav6=qmad.br_navigator&&qmad.br_version<7;qmad.br_strict=(dcm=document.compatMode)&&dcm=="CSS1Compat";qmad.br_ie=window.showHelp;qmad.str=(qmad.br_ie&&!qmad.br_strict);if(!qmad.br_oldnav6){if(!qmad.ibcss)qmad.ibcss=new Object();if(qmad.bvis.indexOf("qm_ibcss_active(o,false);")==-1){qmad.bvis+="qm_ibcss_active(o,false);";qmad.bhide+="qm_ibcss_active(a,1);";qmad.binit+="qm_ibcss_init(null,sd.id.substring(2),1);";if(window.attachEvent)document.attachEvent("onmouseover",qm_ibcss_hover_off);else  if(window.addEventListener)document.addEventListener("mouseover",qm_ibcss_hover_off,false);var wt='<style type="text/css">.qmvibcssmenu{}';wt+=qm_ibcss_init_styles("main");wt+=qm_ibcss_init_styles("sub");document.write(wt+'</style>');}};function qm_ibcss_init_styles(pfix,id){var wt='';var a="transparent";var b="transparent";var t,q;add_div="";if(pfix=="sub")add_div="div ";var r1="ibcss_"+pfix+"_bg_color";var r2="ibcss_"+pfix+"_border_color";for(var i=0;i<10;i++){if(q=qmad["qm"+i]){if(t=q[r1])a=t;if(t=q[r2])b=t;wt+='#qm'+i+' '+add_div+'.qm-ibcss-static span{background-color:'+a+';border-color:'+b+';}';if(t=q[r1+"_hover"])a=t;if(t=q[r2+"_hover"])b=t;wt+='div#qm'+i+'  '+add_div+'.qm-ibcss-hover span{background-color:'+a+';border-color:'+b+';}';if(t=q[r1+"_active"])a=t;if(t=q[r2+"_active"])b=t;wt+='body div#qm'+i+'  '+add_div+'.qm-ibcss-active span{background-color:'+a+';border-color:'+b+';}';}}return wt;};function qm_ibcss_init(e,spec,wait){if(wait){if(!isNaN(spec)){setTimeout("qm_ibcss_init(null,"+spec+")",10);return;}}var z;if((z=window.qmv)&&(z=z.addons)&&(z=z.ibcss)&&(!z["on"+qmv.id]&&z["on"+qmv.id]!=undefined&&z["on"+qmv.id]!=null))return;qm_ts=1;var q=qmad.ibcss;var a,b,r,sx,sy;z=window.qmv;for(i=0;i<10;i++){if(!(a=document.getElementById("qm"+i))||(!isNaN(spec)&&spec!=i))continue;var ss=qmad[a.id];if(ss&&(ss.ibcss_main_type||ss.ibcss_sub_type)){q.mtype=ss.ibcss_main_type;q.msize=ss.ibcss_main_size;if(!q.msize)q.msize=5;q.md=ss.ibcss_main_direction;if(!q.md)md="right";q.mbg=ss.ibcss_main_bg_color;q.mborder=ss.ibcss_main_border_color;sx=ss.ibcss_main_position_x;sy=ss.ibcss_main_position_y;if(!sx)sx=0;if(!sy)sy=0;q.mpos=eval("new Array('"+sx+"','"+sy+"')");q.malign=eval("new Array('"+ss.ibcss_main_align_x+"','"+ss.ibcss_main_align_y+"')");r=q.malign;if(!r[0])r[0]="right";if(!r[1])r[1]="center";q.stype=ss.ibcss_sub_type;q.ssize=ss.ibcss_sub_size;if(!q.ssize)q.ssize=5;q.sd=ss.ibcss_sub_direction;if(!q.sd)sd="right";q.sbg=ss.ibcss_sub_bg_color;q.sborder=ss.ibcss_sub_border_color;sx=ss.ibcss_sub_position_x;sy=ss.ibcss_sub_position_y;if(!sx)sx=0;if(!sy)sy=0;q.spos=eval("new Array('"+sx+"','"+sy+"')");q.salign=eval("new Array('"+ss.ibcss_sub_align_x+"','"+ss.ibcss_sub_align_y+"')");r=q.salign;if(!r[0])r[0]="right";if(!r[1])r[1]="middle";q.type=ss.ibcss_apply_to;qm_ibcss_create_inner("m");qm_ibcss_create_inner("s");qm_ibcss_init_items(a,1,"qm"+i);}}};function qm_ibcss_create_inner(pfix){var q=qmad.ibcss;var wt="";var s=q[pfix+"size"];var type=q[pfix+"type"];var head;if(type.indexOf("head")+1)head=true;var gap;if(type.indexOf("gap")+1)gap=true;var v;if(type.indexOf("-v")+1)v=true;if(type.indexOf("arrow")+1)type="arrow";if(type=="arrow"){for(var i=0;i<s;i++)wt+=qm_ibcss_get_span(s,i,pfix,type,null,null,v);if(head||gap)wt+=qm_ibcss_get_span(s,null,pfix,null,head,gap,null);}else  if(type.indexOf("square")+1){var inner;if(type.indexOf("-inner")+1)inner=true;var raised;if(type.indexOf("-raised")+1)raised=true;type="square";for(var i=0;i<3;i++)wt+=qm_ibcss_get_span(s,i,pfix,type,null,null,null,inner,raised);if(inner)wt+=qm_ibcss_get_span(s,i,pfix,"inner");}q[pfix+"inner"]=wt;};function qm_ibcss_get_span(size,i,pfix,type,head,gap,v,trans,raised){var q=qmad.ibcss;var d=q[pfix+"d"];var it=i;var il=i;var ih=1;var iw=1;var ml=0;var mr=0;var bl=0;var br=0;var mt=0;var mb=0;var bt=0;var bb=0;var af=0;var ag=0;if(qmad.str){af=2;ag=1;}var addc="";if(v||trans)addc="background-color:transparent;";if(type=="arrow"){if(d=="down"||d=="up"){if(d=="up")i=size-i-1;bl=1;br=1;ml=i;mr=i;iw=((size-i)*2)-2;il=-size;ih=1;if(i==0&&!v){bl=iw+2;br=0;ml=0;mr=0;iw=0;if(qmad.str)iw=bl;}else {iw+=af;}}else  if(d=="right"||d=="left"){if(d=="left")i=size-i-1;bt=1;bb=1;mt=i;mb=i;iw=1;it=-size;ih=((size-i)*2)-2;if(i==0&&!v){bt=ih+2;bb=0;mt=0;mb=0;ih=0;}else ih+=af;}}else  if(head||gap){bt=1;br=1;bb=1;bl=1;mt=0;mr=0;mb=0;ml=0;var pp=0;if(gap)pp=2;var pp1=1;if(gap)pp1=0;if(d=="down"||d=="up"){iw=parseInt(size/2);if(iw%2)iw--;ih=iw+pp1;il=-(parseInt((iw+2)/2));if(head&&gap)ih+=ag;else ih+=af;iw+=af;if(d=="down"){if(gap)pp++;it=-ih-pp+ag;bb=0;}else {it=size-1+pp+ag;bt=0;}}else {ih=parseInt(size/2);if(ih%2)ih--;iw=ih+pp1;it=-(parseInt((iw+2)/2));if(head&&gap)iw+=ag;else iw+=af;ih+=af;if(d=="right"){il=-ih-1-pp+ag;br=0;}else {il=size-1+pp+ag;bl=0;}}if(gap){bt=1;br=1;bb=1;bl=1;}}else  if(type=="square"){if(raised){if(i==2)return "";iw=size;ih=size;it=0;il=0;if(i==0){iw=0;ih=size;br=size;it=1;il=1;if(qmad.str)iw=br;}}else {if(size%2)size++;it=1;ih=size;iw=size;bl=1;br=1;il=0;iw+=af;if(i==0||i==2){ml=1;it=0;ih=1;bl=size;br=0;iw=0;if(qmad.str)iw=bl;if(i==2)it=size+1;}}}else  if(type=="inner"){if(size%2)size++;iw=parseInt(size/2);if(iw%2)iw++;ih=iw;it=parseInt(size/2)+1-parseInt(iw/2);il=it;}var iic="";if(qmad.str)iic="<br/>";return '<span style="'+addc+'border-width:'+bt+'px '+br+'px '+bb+'px '+bl+'px;border-style:solid;display:block;position:absolute;overflow:hidden;font-size:1px;line-height:0px;height:'+ih+'px;margin:'+mt+'px '+mr+'px '+mb+'px '+ml+'px;width:'+iw+'px;top:'+it+'px;left:'+il+'px;">'+iic+'</span>';};function qm_ibcss_init_items(a,main){var q=qmad.ibcss;var aa,pf;aa=a.childNodes;for(var j=0;j<aa.length;j++){if(aa[j].tagName=="A"){if(window.attachEvent)aa[j].attachEvent("onmouseover",qm_ibcss_hover);else  if(window.addEventListener)aa[j].addEventListener("mouseover",qm_ibcss_hover,false);var skip=false;if(q.type!="all"){if(q.type=="parent"&&!aa[j].cdiv)skip=true;if(q.type=="non-parent"&&aa[j].cdiv)skip=true;}if(!skip){if(main)pf="m";else pf="s";var ss=document.createElement("SPAN");ss.className="qm-ibcss-static";var s1=ss.style;s1.display="block";s1.position="relative";s1.fontSize="1px";s1.lineHeight="0px";s1.zIndex=1;ss.ibhalign=q[pf+"align"][0];ss.ibvalign=q[pf+"align"][1];ss.ibposx=q[pf+"pos"][0];ss.ibposy=q[pf+"pos"][1];ss.ibsize=q[pf+"size"];qm_ibcss_position(aa[j],ss);ss.innerHTML=q[pf+"inner"];aa[j].qmibulletcss=aa[j].insertBefore(ss,aa[j].firstChild);ss.setAttribute("qmvbefore",1);ss.setAttribute("isibulletcss",1);if(aa[j].className.indexOf("qmactive")+1)qm_ibcss_active(aa[j]);}if(aa[j].cdiv)new qm_ibcss_init_items(aa[j].cdiv,null);}}};function qm_adds_gmc(a){while(!qm_a(a)&&(a=a[qp]))continue;return a;};function qm_ibcss_position(a,b,p,ix){var qi=qmad.ibcss;if(p){a=qi[p][ix-1][0];b=qi[p][ix-1][1];}if(!a.offsetWidth||!a.offsetHeight){if(!p){var ti="q_"+qm_adds_gmc(a).id;if(!qi[ti])qi[ti]=new Array();qi[ti].push(new Array(a,b));p=ti;ix=qi[ti].length;}setTimeout("qm_ibcss_position(null,null,'"+p+"',"+ix+")",10);}else {if(b.ibhalign=="right")b.style.left=(a.offsetWidth+parseInt(b.ibposx)-b.ibsize)+"px";else  if(b.ibhalign=="center")b.style.left=(parseInt(a.offsetWidth/2)-parseInt(b.ibsize/2)+parseInt(b.ibposx))+"px";else b.style.left=b.ibposx+"px";if(b.ibvalign=="bottom")b.style.top=(a.offsetHeight+parseInt(b.ibposy)-b.ibsize)+"px";else  if(b.ibvalign=="middle")b.style.top=parseInt((a.offsetHeight/2)-parseInt(b.ibsize/2)+parseInt(b.ibposy))+"px";else b.style.top=b.ibposy+"px";}};function qm_ibcss_hover(e,targ){e=e||window.event;if(!targ){var targ=e.srcElement||e.target;while(targ.tagName!="A")targ=targ[qp];}var ch=qmad.ibcss.lasth;if(ch&&ch!=targ&&ch.qmibulletcss)qm_ibcss_hover_off(new Object(),ch);if(targ.className.indexOf("qmactive")+1)return;var wo=targ.qmibulletcss;if(wo){x2("qm-ibcss-hover",wo,1);qmad.ibcss.lasth=targ;}if(e)qm_kille(e);};function qm_ibcss_hover_off(e,o){if(!o)o=qmad.ibcss.lasth;if(o&&o.qmibulletcss)x2("qm-ibcss-hover",o.qmibulletcss);};function qm_ibcss_active(a,hide){if(!hide&&a.className.indexOf("qmactive")==-1)return;if(hide&&a.idiv){var o=a.idiv;if(o&&o.qmibulletcss){x2("qm-ibcss-active",o.qmibulletcss);}}else {if(!a.cdiv.offsetWidth)a.cdiv.style.visibility="inherit";var aa=a.cdiv.childNodes;for(var i=0;i<aa.length;i++){if(aa[i].tagName=="A"&&aa[i].qmibulletcss)qm_ibcss_position(aa[i],aa[i].qmibulletcss);}var wo=a.qmibulletcss;if(wo)x2("qm-ibcss-active",wo,1);}}/* ]]> */</script><!--[END-QJ]-->

</head>

<body 	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px; >



<!-- QuickMenu Structure [Menu 0] -->


<ul id="qm0" class="qmmc">
	
	<li><a href="<? echo $c ?>admin/institucion/listarInstituciones.php3?modo=ini&pag=1" target="_self">Seleccione Institucion</a></li>
	<li><a href="<? echo $c ?>estadisticas/estadisticas_new.php" target="_self">Estadistica de Conexi&oacute;n</a></li>
	<li><a href="javascript:void(0);">Reportes Estadisticos</a></li>
	<li><a class="qmparent" href="javascript:void(0);">Administraci&oacute;n</a>

		<ul>
		<li><a href="javascript:void(0);">Datos Institución</a></li>
		<li><a href="javascript:void(0);">Años Academicos</a></li>
		<li><a href="javascript:void(0);">Respaldos</a></li>
		<li><a href="javascript:void(0);">Subir archivos RECH</a></li>
		<li><a href="javascript:void(0);">Log de Acceso</a></li>
		<li><a href="javascript:void(0);">Cantidad info </a></li>
		</ul></li>

	<li><a href="javascript:void(0);">Ficha Academica</a></li>
	<li><a class="qmparent" href="javascript:void(0);">Configuraci&oacute;n</a>

		<ul>
		<li><a href="javascript:void(0);">Periodo</a></li>
		<li><a href="javascript:void(0);">Feriados</a></li>
		<li><a href="javascript:void(0);">Planes de Estudios</a></li>
		<li><a href="javascript:void(0);">Tipos de Enseñanza</a></li>
		<li><a href="javascript:void(0);">Cursos</a></li>
		<li><a href="javascript:void(0);">Ciclos</a></li>
		<li><a href="javascript:void(0);">Ciclos-Niveles</a></li>
		<li><a href="javascript:void(0);">Informe de Personalidad</a></li>
		<li><a href="javascript:void(0);">Mapa Mensajeria</a></li>
		<li><a href="javascript:void(0);">Grupos</a></li>
		<li><a href="javascript:void(0);">Anotaciones</a></li>
		<li><a href="javascript:void(0);">Corporaciones</a></li>
		<li><a href="javascript:void(0);">Vacantes</a></li>
		<li><a href="javascript:void(0);">Criterio de Seleccin</a></li>
		<li><a href="javascript:void(0);">Act. Extraprogramaticas</a></li>
		<li><a href="javascript:void(0);">Prueba Simce-PSU</a></li>
		<li><a href="javascript:void(0);">Becas &amp; Beneficios</a></li>
		<li><a href="javascript:void(0);">Practicas</a></li>
		<li><a href="javascript:void(0);">Proyecto de Integración o Grupo Diferencial</a></li>
		<li><a href="javascript:void(0);">Reporte</a></li>
		<li><a href="javascript:void(0);">Crea Menú</a></li>
		<li><a href="javascript:void(0);">Perfil v/s Menú </a></li>
		</ul></li>

	<li><a class="qmparent" href="javascript:void(0);">Libro de Clases</a>

		<ul>
		<li><a class="qmparent" href="javascript:void(0);">Cursos</a>

			<ul>
			<li><a href="javascript:void(0);">Bsqueda Alumno</a></li>
			<li><a href="javascript:void(0);">Alumnos</a></li>
			<li><a href="javascript:void(0);">Subsectores</a></li>
			<li><a href="javascript:void(0);">Taller</a></li>
			<li><a href="javascript:void(0);">Horario</a></li>
			<li><a href="javascript:void(0);">Cal. Actividades</a></li>
			<li><a href="javascript:void(0);">Promoci n</a></li>
			<li><a href="javascript:void(0);">Asistencia Mensual</a></li>
			<li><a href="javascript:void(0);">Asistencia Horaria</a></li>
			<li><a href="javascript:void(0);">Asist. H. Docente</a></li>
			<li><a href="javascript:void(0);">Asist. Apoderado</a></li>
			<li><a href="javascript:void(0);">Justifica Inasistencia</a></li>
			<li><a href="javascript:void(0);">Atrasos</a></li>
			<li><a href="javascript:void(0);">Ficha Medica</a></li>
			<li><a href="javascript:void(0);">Ficha Deportiva</a></li>
			<li><a href="javascript:void(0);">Inf. Personalidad</a></li>
			<li><a href="javascript:void(0);">Hoja de Vida</a></li>
			<li><a href="javascript:void(0);">Resultados Curso</a></li>
			<li><a href="javascript:void(0);">Resultados Simce</a></li>
			<li><a href="javascript:void(0);">Resultados PSU</a></li>
			<li><a href="javascript:void(0);">Becas &amp; Beneficios</a></li>
			<li><a href="javascript:void(0);">Resumen horas planificacion curricular</a></li>
			<li><a href="javascript:void(0);">Proyecto Int. o Grupo Dif.</a></li>
			<li><a href="javascript:void(0);">Citacin Apoderados</a></li>
			</ul></li>

		<li><a href="javascript:void(0);">Matricula</a></li>
		<li><a href="javascript:void(0);">Matricula Postulaci&oacute;n</a></li>
		<li><a href="javascript:void(0);">Reportes</a></li>
		<li><a href="javascript:void(0);">Reportes Estadisticos</a></li>
		<li><a href="javascript:void(0);">Act. Extraprogramaticas</a></li>
		<li><a href="javascript:void(0);">Actas</a></li>
		</ul></li>

	<li><a class="qmparent" href="javascript:void(0);">Postulaci&oacute;n</a>

		<ul>
		<li><a href="javascript:void(0);">Formulario de Postulaci&oacute;n</a></li>
		<li><a href="javascript:void(0);">Postular</a></li>
		<li><a href="javascript:void(0);">Reportes Postulaci&oacute;n</a></li>
		</ul></li>

	<li><a class="qmparent" href="javascript:void(0);">Info. Colegio</a>

		<ul>
		<li><a href="javascript:void(0);">Nuestra Instituci&oacute;n</a></li>
		<li><a href="javascript:void(0);">Reglamento Interno</a></li>
		<li><a href="javascript:void(0);">Carta Dirección</a></li>
		<li><a href="javascript:void(0);">Proceso de Admisi&oacute;n</a></li>
		<li><a href="javascript:void(0);">Proyecto Educativo</a></li>
		<li><a href="javascript:void(0);">Uniforme</a></li>
		<li><a href="javascript:void(0);">Sede</a></li>
		<li><a href="javascript:void(0);">Mapa Ubicaci&oacute;n</a></li>
		<li><a href="javascript:void(0);">Insignia</a></li>
		</ul></li>

	<li><a class="qmparent" href="javascript:void(0);">Comunicaciones</a>

		<ul>
		<li><a href="javascript:void(0);">Mensajer a</a></li>
		<li><a href="javascript:void(0);">Agenda</a></li>
		<li><a href="javascript:void(0);">Diario Mural</a></li>
		<li><a href="javascript:void(0);">Sugerencia o Reclamos</a></li>
		</ul></li>

	<li><a class="qmparent" href="javascript:void(0);">Personal</a>

		<ul>
		<li><a href="javascript:void(0);">Listar Personal</a></li>
		<li><a href="javascript:void(0);">Asistencia del Personal</a></li>
		<li><a href="javascript:void(0);">Atrasos del Personal</a></li>
		<li><a href="javascript:void(0);">Dotacin Docente</a></li>
		</ul></li>

	<li><a href="javascript:void(0);">Soporte</a></li>
<li class="qmclear">&nbsp;</li></ul>

<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click (options: 'all' * 'all-always-open' * 'main' * 'lev2'), Right to Left, Horizontal Subs, Flush Left, Flush Top) -->
<script type="text/javascript">qm_create(0,false,250,250,false,false,false,false,false);</script><!--[END-QM0]-->


</body>
</html>
<? pg_close($conn);?>