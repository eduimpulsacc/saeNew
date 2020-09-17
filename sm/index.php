<?
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

require_once('php-local-browscap.php');
$navegador=get_browser_local(); 

/*echo "<pre>";
print_r($navegador);
echo "</pre>";*/

//echo $_SERVER["HTTP_USER_AGENT"];

//if($navegador['cssversion']==3){

     //header('Location: /sm/mobilehtml5/index.php');
	
	//}else{
		
    //header('Location: /sm/mobilehtml5/index.php');
	//header('Location: http://192.168.100.203/sm/mobilexhtmlmp/index.php');
		
	//};
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, content="text/html; charset=UTF-8", minimum-scale=1, maximum-scale=1">
<title>Sae Movil</title>
<title> </title>
<meta name="keywords" content=" ">
<meta name="description" content=" ">
<script languaje="javascript">window.status=" ";</script>

<script language="javascript" src="lib/modernizr.js"></script>
<script>
if (Modernizr.canvas){
 window.location = 'mobilehtml5/index.php'
}else{
 window.location = 'mobilexhtmlmp/index.php'
} 
</script>
</head>
<body>
<html>
</html>
</body>    