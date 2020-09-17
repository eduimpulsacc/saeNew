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
 <form method="post" id="form1" name="form1" ><b class="">
 <h3 style="background-color:#bf1e85">Recupere su contrase&ntilde;a</h3>
 <p><br/>
   Estimado usuario:</p>
 <p>Para recuperar su contrase&ntilde;a, ll&aacute;menos al n&uacute;mero de soporte<br>
   <br>
   <div style="font-size:34px">232411860</div>
 </p>
 </b>
 </form>
 </div>
 </div>
 </body>
</html>