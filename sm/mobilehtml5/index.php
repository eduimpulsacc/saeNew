<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta name="viewport" content="width=device-width, content="text/html; charset=UTF-8", minimum-scale=1, maximum-scale=1">

<title>sae movil</title>

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>

<script>
/* $(function() {
     $("#callAjax").click(function() {
          var theName = $.trim($("#theName").val());
          if(theName.length > 0)
          {
             $.ajax({
                      type: "POST",
                      url: "http://10.0.2.2/mobileajax/callajax.php",
                      data: ({name: theName}),
                      cache: false,
                      dataType: "text",
                      success: onSuccess
                    });
                }else{
					alert("SALIDA");
					}
            });
            $("#resultLog").ajaxError(function(event, request, settings, exception) {
            $("#resultLog").html("Error Calling: " + settings.url + "<br />HTPP Code: " + request.status);
			});
            function onSuccess(data)
            {
                $("#resultLog").html("Result: " + data);
            }
        });*/
    </script>

</head>
 
<body>
 
<div data-role="page"  >

            <div data-role="header" data-theme="b"  style="padding:15px;">
        &nbsp;
          </div>
          <!-- /header -->
        
<div data-role="content"   >

    <div align="center" >
    <!--style="margin:1px"-->
    <img src="logosaemovil.png" width="283" height="73" />
    </div>
    
    <form action="../inicio/chkuser.php" method="post" name="frm" rel="external" id="frm" data-ajax="false"  >
    <fieldset> 
    <!--<div data-role="fieldcontain">-->
    <label for="nombre_usuario">Usuario</label>
    <input name="nombre_usuario" id="nombre_usuario" type="text" value="" maxlength="8" required />
    <label for="password">Contrase&ntilde;a</label>
    <input name="password" id="password" type="password" value="" maxlength="8" required />
    <input type="submit" name="Enviar" id="Enviar" value="Conectar" >
    <!--</div>-->
    </fieldset> 
    </form>
    
 </div>
 
  <div data-role="footer" align="center" data-theme="b" >
  
  <br>
  <p style="font-size:10px"> 
  <a href="mailto:info@colegiointeractivo.com?subject=Consulta%20desde%20SaeMovil">contacto@eduimpulsa.com</a>
  </p>
  <p style="font-size:10px">
  <a href="tel:28293350">Fono : ( 56-2 ) 32411860</a>
  </p>
  <p style="font-size:10px"><a href="http://www.colegiointeractivo.com/">www.colegiointeractivo.cl</a> 
  </p>
  <p style="font-size:10px">Copyright Todos los Derechos Reservados</p>
  <br>
  
  </div>

  </div>
 
</body>
</html>

<!--http://www.giantflyingsaucer.com/blog/?p=2574
http://www.giantflyingsaucer.com/blog/?p=1948
http://www.jquery4u.com/mobile/50-jquery-mobile-development/
http://www.jquery4u.com/mobile/50-jquery-mobile-development/-->

