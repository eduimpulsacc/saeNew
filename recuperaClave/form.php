<html>
    <head>
	
		<title>Google Captcha Protection in form- Demo Preview</title>
        <meta name="robots" content="noindex, nofollow" />
		
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="scripts.js"></script>
    </head>
    <body>

        <div id="mainform">
            <div class="innerdiv">
                <h2>Captcha creation using Google Library</h2>
                <!-- Required div starts here -->
                <form method="post" id="myForm">
                    <h3>Fill Your Information!</h3> 
                    <br/>
                    <table>                       
                        <tr>
                            <td><br/><br/><br/><br/><br/><br/></td>
							<!--including google captcha image from captcha.php-->
                            <td><img id="captcha_img" src="captcha.php" /><br/>
                                <span id="reload">Can't read? try another one</span></td>
                        <tr>
                            <td>Enter Text:</td>
                            <td><input id="captcha1" name="captcha" type="text"></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><input type='submit' id="button" value='Submit'><br/>
                            </td>
                        </tr>
                    </table>
                    <?php
                   include 'verify.php';
                    ?>
                </form>
            </div>
            <!-- Right side div -->
            <div id="formget"><a href=http://www.formget.com/app><img src="formget.jpg" alt="Online Form Builder"/></a>
            </div>
        </div>
    </body>
</html>