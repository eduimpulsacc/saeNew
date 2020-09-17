<style type="text/css">
.boton{
font-size:10px;
font-family:Verdana,Helvetica;
color:BLACK;
background:#CCCCCC;
border:0px;
width:80px;
height:19px;
}
</style>

<?

@session_start();  //el arroba esta puesto ya que el session_start no esta al top del head de la page
@session_destroy(); //destruyo las sesion

$caso == $caso;


if ($caso!=1 and  $caso!=2 and $caso!=3 and $caso!=4  and $caso!=8  and $caso!=7 and $caso!=9 ){
        $msg = "ESTIMADO USUARIO, ERROR NO EXISTE. (CODIGO 106).";// ERROR INEXISTENTE
			 } else 

	switch ($caso) {
		 case 1:
			 $msg = "ESTIMADO USUARIO, SE HA PRODUCIDO UN ERROR, POR FAVOR REINTENTE. (USUARIO NO EXISTE). caso interno 1";//USURIO NO EXISTE
			 break;
		 case 2: 
			 $msg = "ESTIMADO USUARIO, SE HA PRODUCIDO UN ERROR,POR FAVOR REINTENTE. (CLAVE ERRONEA). caso interno 2";//CLAVE INVALIDA
			 break;
		 case 3:
			 $msg = "ESTIMADO USUARIO, SE HA PRODUCIDO UN ERROR, POR FAVOR REINTENTE. (SIN ACCESO). caso interno 3";//SIN ACCESO
			 break;
		 case 4:
			 $msg = "ESTIMADO USUARIO,  SE HA PRODUCIDO UN ERROR, POR FAVOR REINTENTE. (SIN PERFIL). caso interno 4";//NO PERFIL
			 break;
			 
		 case 8:
			 $msg = "ESTIMADO USUARIO, SE HA PRODUCIDO UN ERROR, POR FAVOR REINTENTE. (CODIGO 106). caso interno 8";// USUARIO INTENTA COLOCAR COMANDOS INVASIVOS EN LOGIN
			 break;	 
		 
		 case 7:
			 $msg = "ESTIMADO USUARIO, SE HA PRODUCIDO UN ERROR, POR FAVOR REINTENTE MAS TARDE. (CODIGO 107). caso interno 6";// NO CONECTA A LA BD POSTGRES
			 break;	 
		 case 9:
			 $msg = "ESTIMADO USUARIO, SE HA PRODUCIDO UN ERROR, POR FAVOR REINTENTE. (USUARIO MAL INGRESADO).";// NO CONECTA A LA BD POSTGRES
			 break;	 	 
	 };
	 
	
?>
<html>
		<head>
			<title>Error.</title>
		</head>
	<body>
		<center>
		  <p><br>
          </p>
		  <p>&nbsp;</p>
		  <p><br>
		      <br>
	        <br>
	      </p>
		  <TABLE WIDTH="350" BORDER=0 CELLSPACING=1 CELLPADDING=1 BGCOLOR=WHITE>
				<TR>
					<TD BGCOLOR=WHITE><br>
					  <p><FONT face="Verdana, geneva, helvetica" size=1 color=BLACK>&nbsp;<?php echo $msg?>
				    </FONT>
					  <br>
					  </p>
					  <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <th scope="row"><font face="arial, geneva, helvetica" size=2 color=White><strong><img src="images.jpg" width="60" height="60" align="center"></strong></font></th>
                        </tr>
                      </table>
					  <p align="right"><br>
				      <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
				      ATTE. COLEGIO INTERACTIVO.</font></p>
				      <p align="right">&nbsp;</p></TD>
				</TR>
		  </TABLE>
		  <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
          <input name="button" type="button" class="boton" onClick='javascript:history.go(-2)' value="VOLVER">
          </font><br>
		<br>
		<br>
		<br>
		</center>
	</body>
</html>