<?php session_start(); ?>
<html>
 <head>
 
 <title></title>
 
 <link rel="stylesheet" type="text/css" href="style.css">
 <script src="../admin/clases/jquery/jquery.js"></script>
<script src="scripts.js"></script>
<script>
 $(document).ready(function() {
 $("#reload").click(function() {
 $("#captcha_img").attr("src", "captcha.php");
 });
});

</script>

 </head>
 <body onLoad="document.getElementById('captcha-form').focus()">
 <div id="mainform">
 <div class="innerdiv"><!-- Required div starts here -->
 <form method="post" id="form1" name="form1" >
 <h3 style="background-color:#bf1e85">Recupere su contrase&ntilde;a</h3>
 <br/>
 <table>
 <tr>
   <td>Perfil</td>
   <td><select name="cmbPerfil" id="cmbPerfil" required>
     <option value="">Seleccione</option>
     <option value="1">Alumno</option>
     <option value="2">Apoderado</option>
     <option value="3">Empleado</option>
   </select></td>
 <tr>
   <td>Rut (12345678-9)</td>
   <td><input type="text" name="rut" id="rut" onBlur="javascript:Rut(document.form1.rut.value)" required></td>
 <tr>
   <td>Email</td>
   <td><input type="email" name="email" id="email" required></td>
 <tr>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
 <tr>
 <td><br/><br/><br/><br/><br/><br/></td>
 <!--including google captcha image from captcha.php-->
 <td><img src="captcha.php" id="captcha" /><br/>
 <span id="reload" onClick="document.getElementById('captcha').src='captcha.php?'+Math.random();
    document.getElementById('captcha-form').focus();" >Elegir otra combinaci&oacute;n</span></td>
 <tr>
 <td>C&oacute;digo de seguridad</td>
 <td><input type="text" name="captcha" id="captcha-form" autocomplete="off" required /></td>
 </tr>
  <tr>
 <td></td>
 <td><input name="Enviar" type='submit' id="button" value='Enviar Datos' style="background-color:#bf1e85"><br/>
 </td>
 </tr>
 </table>
 <?php
 
 
if (isset($_POST["captcha"])) 
 {
    session_start();
	//Verifying user input captcha text with google generated captcha
    if ($_SESSION["captcha"] == $_POST["captcha"]) 
	{
		
		if($_POST["cmbPerfil"]==1){
		$c = " and accede.id_perfil=16";
		}
		elseif($_POST["cmbPerfil"]==2){
		$c = " and accede.id_perfil=15";
		}
		if($_POST["cmbPerfil"]==3){
		$c = " and accede.id_perfil not in(0,15,16)";
		}
		
		$r = explode("-",$_POST["rut"]);
		$rut = $r[0];
		
		$connection=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conex Coi_Usuario");
		
		 $sql = "select nombre_usuario,pw,id_base from usuario
inner join accede on accede.id_usuario = usuario.id_usuario
where usuario.nombre_usuario = '".$rut."' and accede.estado=1  $c GROUP by nombre_usuario,pw,id_base;";
	$rs = pg_exec($connection,$sql);
	
	if(pg_numrows($rs)>0){
		
		$id_base = pg_result($rs,2);
		$login = pg_result($rs,0);
		$pw = pg_result($rs,1);
		
		if($id_base==1)
		{
			$BaseDatos = "coi_final";	
			$Servidor = "ip-172-31-0-119.ec2.internal";		
		}
		
		elseif($id_base==2)
		{
			$BaseDatos = "coi_final_vina";	
			$Servidor = "ip-172-31-11-223.ec2.internal";	
		}
		
		/*elseif($id_base==3)
		{
			$BaseDatos = "coi_antofagasta";	
			$Servidor = "192.168.1.11";	
		}
		*/
		elseif($id_base==4)
		{
			$BaseDatos = "coi_corporaciones";	
			$Servidor = "ip-172-31-13-9.ec2.internal";	
		}
		
		$Usuario = "postgres";
		$Clave = "f4g5h6.j";
		$Port = "5432";
		
		$cadenaconeccion = "dbname = ".$BaseDatos." host=".$Servidor." port = ".$Port." user = ".$Usuario."  password = ".$Clave." ";
		
			$Conect = pg_connect($cadenaconeccion) or die("no conecta");
			
			//echo $cadenaconeccion; exit;
			
		if($_POST["cmbPerfil"]==1){
		//alumno
		$sql_u ="select nombre_alu, ape_pat, ape_mat from alumno where rut_alumno = $rut";
		}
		elseif($_POST["cmbPerfil"]==2){
			$sql_u ="select nombre_apo, ape_pat, ape_mat from apoderado where rut_apo = $rut";
		
		}
		if($_POST["cmbPerfil"]==3){
		$sql_u ="select nombre_emp, ape_pat, ape_mat from empleado where rut_emp = $rut";
		}
		
		$rs_u = pg_exec($Conect,$sql_u);
		
		$nom= pg_result($rs_u,0);
		$ape_pat= pg_result($rs_u,1);
		$ape_mat= pg_result($rs_u,2);
		
		
	//mail("ccanto@colegiointeractivo.com","aaaa","hola");
	echo "<b class=\"correct\">Se ha enviado su contrase&ntilde;a a la direcci&oacute;n de correo ingresada.  Si no ve el mensaje en su bandeja de entrada, revise su bandeja de SPAM.</b>";
	
	
	
	
	
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <contacto@colegiointeractivo.com>' . "\r\n";
	$subject = "[Sistema SAE] Recuperar contraseña";
	
	$message = "
	<html>
	<body>
	Estimado(a) usuario(a) $nom $ape_pat $ape_mat:<br />
<br />
A continuación encontrará los datos de acceso a la plataforma:
 <br /><br /><br />
<table border='0' cellspacing='0' cellpadding='0'>
  <tbody>
    <tr>
      <td width='174' valign='top'><b>URL</b></td>
      <td width='573' valign='top'><a href='http://www.colegiointeractivo.cl' target='_blank'><b>www.colegiointeractivo.cl</b></a></td>
    </tr>
    <tr>
      <td width='174' valign='top'>
       <b>Usuario</b>
        </td>
      <td width='573' valign='top'><b>$login </b></td>
    </tr>
    <tr>
      <td width='174' valign='top'>
       <b>Contraseña</b>
        </td>
      <td width='573' valign='top'><b>$pw </b></td>
    </tr>
  </tbody>
</table>

	
	 <p><i>Este es un mensaje automático, por favor no lo responda.</i></p>
	</body>
	</html>
	";
	
	//echo $message;
	
	mail($_POST["email"],$subject,$message,$headers);
	}
	else{
		echo "<b class=\"wrong\">Datos no encontrados. Comun&iacute;quese con el administrador del sistema SAE en su colegio</b>";
	}
	//var_dump($_POST);	
   // header("location:mensaje.php");
    } 
	else 
	{
    echo "<b class=\"wrong\">C&oacute;digo incorrecto</b>";
    }
    unset($_SESSION['captcha']);
}
?>
 </form>
 </div>
 </div>
 </body>
</html>