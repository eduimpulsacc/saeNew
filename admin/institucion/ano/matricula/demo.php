<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script src="XHConn.js" type="text/javascript"></script>
<style type="text/css">{margin:0px;padding:0px;font: bold 11px "Verdana";text-decoration:none;}a:link,a:visited {	color:#0066CC;}a:active {	color:#000;}a:hover{	color:#FF9000;}input{border:1px solid #CCCCCC;cursor:pointer;padding:1px;}fieldset,#inclusao {margin:0px auto;width:25%;}#inclusao {width :50%;}
</style> 
<script>function logar () 
{/*aqui eu chamo a  a class*/var myConn = new XHConn(); /*pego o id do campo  */var poststr = "login=" + encodeURI( document.getElementById("login").value ) +"&senha=" + encodeURI( document.getElementById("senha").value ); /* Um alerta informando da n�o inclus�o da biblioteca */if (!myConn) alert("XMLHTTP not available. Try a newer/better browser."); /*aqui � onde vai mostrar atualizando quando eu for enviar os dados */document.getElementById('inclusao').innerHTML = "<img src='loading.gif' />"; /* o result do post */var inclusao = function (oXML) { document.getElementById('inclusao').innerHTML = oXML.responseText; }; /*aqui � enviado mesmo para pagina receber methodo post,+ as variaveis, valorese informar onde vai atualizar     */myConn.connect("receber.php", "POST", poststr, inclusao); /*uma coisa legal nesse script se o usuario n�o tive suporte a JavaScriptpor isso eu coloquei return false no form o php enviar sozinho  */}</script></head> <body>  <fieldset><legend>Fa�a seu login</legend><form action="receber.php" method="post"  onsubmit="logar(); return false">Login:<input type="text" name="login" id="nome"  size="25"maxlength="15" value=""  />Senha:<input type="text" name="senha" id="senha" size="25" maxlength="15" value="" /><p>&nbsp;</p><input type="submit"  id="submit" value="Cadastra" /></form>/fieldset> <div id="inclusao"></div></body></html>